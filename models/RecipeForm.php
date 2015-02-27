<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\base\InvalidParamException;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;        

/**
 * RecipeForm is the model behind the recipe form.
 */
class RecipeForm extends Model
{
    public $title;
    public $firstname;
    public $lastname;
    public $url;
    public $text;
    public $recipes;
    public $fridge;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'firstname', 'lastname'], 'required'],
            [['filename'], 'safe'],
            ['url', 'url'],
            [['text'], 'required', 
                'when' => function($model) {
                    return empty($model->url);
                }, 
                'message' => 'Please complete either the url or the text',
                'whenClient' => "function (attribute, value) {
                    return !$('#recipeform-url').val();
                }"
            ],
        ];
    }

    /**
    * @inheritdoc
    */
    public function afterValidate()
    {
        if(!$this->getErrors('text')) {
            if($this->url) {
                try {
                    $this->recipes = file_get_contents($this->url); 
                } catch (\Exception $e) {
                    $this->addError('url', 'Could not connect to the URL.');
                }
                //validate json
                try {
                    $this->recipes = Json::decode($this->recipes);
                } catch (InvalidParamException $e) {
                    $this->addError('url', 'The URL did not return a valid Json response.');
                }
            } elseif($this->text) {
                $this->recipes = $this->text;
                //validate json
                try {
                    $this->recipes = Json::decode($this->recipes);
                } catch (InvalidParamException $e) {
                    $this->addError('text', 'The Json is invalid.');
                }                
            }
        }

        //validate csv file and load it into the fridge
        if(isset($this->file->name)) {
            $filename = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $this->file->name;
            $this->file->saveAs($filename);
            $this->filename = $this->file->name;
        }

        try {
            $filename = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $this->filename;
            
            $config = new LexerConfig();
            $lexer = new Lexer($config);
            $interpreter = new Interpreter();
            $today = date("Y-m-d");
        
            $interpreter->addObserver(function(array $columns) use ($today) {
                if(count($columns) <> 4) {
                    throw new \Exception('The CSV file contains inconsistent columns');
                }
                $useBy = \DateTime::createFromFormat('d/m/Y', $columns[3])->format('Y-m-d');
                if($useBy >= $today) {
                    $this->fridge[$columns[0]] = ['item' => $columns[0], 'amount' => $columns[1], 'unit' => $columns[2], 'use-by' => $useBy];
                }
            });
            $lexer->parse($filename, $interpreter);
        } catch (\Exception $e) {
            $this->addError('file', $e->getMessage());
            $this->filename = '';
        }
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'file' => 'CSV File',
            'text' => 'Json',
        ];
    }

    /**
     * Find the recipes that can be cooked with the content of the fridge
     * @return array the recipes that can be cooked
     */
    public function findRecipes()
    {
        $recipes = [];
        foreach($this->recipes as $recipe) {
            $valid = true;
            $recipe_date = "2020-10-10";
            foreach($recipe['ingredients'] as $ingredient) {
                if(!isset($this->fridge[$ingredient['item']]) || $this->fridge[$ingredient['item']]['amount'] < $ingredient['amount']) {
                    $valid = false;
                } elseif($recipe_date > $this->fridge[$ingredient['item']]['use-by']) {
                    $recipe_date = $this->fridge[$ingredient['item']]['use-by'];
                }
            }
            if($valid) {
                $recipes[$recipe_date] = $recipe;
            }
        }
        ksort($recipes);
        return array_shift($recipes);
    }
}
