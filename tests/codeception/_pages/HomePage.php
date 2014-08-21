<?php

namespace codeception\_pages;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class HomePage extends BasePage
{
    public $route = 'site/index';

    /**
     * @param array $formData
     */
    public function submit(array $formData)
    {
        foreach ($formData as $field => $value) {
            $inputType = $field === 'text' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="RecipeForm[' . $field . ']"]', $value);
        }
        $this->actor->click('Submit');
    }
}
