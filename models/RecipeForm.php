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
    public $phone;
    public $mobile;
    public $preferred;
    public $url;
    
    
    public $unit;
    public $street_type;
    public $street;
    public $suburb;
    public $postcode;
    public $state;
    public $country;

    public $r_unit;
    public $r_street_type;
    public $r_street;
    public $r_suburb;
    public $r_postcode;
    public $r_state;
    public $r_country;

    
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'firstname', 'lastname'], 'required'],
            [['preferred'], 'required'],
            
            [['unit', 'street_type', 'street', 'suburb', 'postcode', 'state', 'country'], 'required'],
            [['r_unit', 'r_street_type', 'r_street', 'r_suburb', 'r_postcode', 'r_state', 'r_country'], 'required'],
            ['url', 'url'],
            [['phone'], 'required', 
                'when' => function($model) {
                    return empty($model->mobile);
                }, 
                'message' => 'Please complete either the phone or the mobile',
                'whenClient' => "function (attribute, value) {
                    return !$('#recipeform-mobile').val();
                }"
            ],
        ];
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
}
