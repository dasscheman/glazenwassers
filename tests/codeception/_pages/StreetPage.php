<?php

namespace tests\codeception\_pages;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class StreetPage extends BasePage
{
    public $route = 'street';

    /**
     * @param array $streetData
     */
    public function submit(array $streetData)
    {
        foreach ($streetData as $field => $value) {
			$inputType = 'input';
			if ($field === 'district_id'){
				$inputType = 'select';
				$this->actor->selectOption($inputType . '[name="Street[' . $field . ']"]', $value);
			} else {
				$this->actor->fillField($inputType . '[name="Street[' . $field . ']"]', $value);
			}
        }
        $this->actor->click('Opslaan');
    }
}