<?php

namespace tests\codeception\_pages;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class StreettransactionPage extends BasePage
{
    public $route = 'streettransaction';

    /**
     * @param array $streettransactionData
     */
    public function submit(array $streettransactionData)
    {
        foreach ($streettransactionData as $field => $value) {
			$inputType = 'input';
			if ($field === 'district_id'){
				$inputType = 'select';
				$this->actor->selectOption($inputType . '[name="Streettransaction[' . $field . ']"]', $value);
			} else {
				$this->actor->fillField($inputType . '[name="Streettransaction[' . $field . ']"]', $value);
			}
        }
        $this->actor->click('Opslaan');
    }
}