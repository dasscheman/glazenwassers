<?php

namespace tests\codeception\_pages;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class DistrictPage extends BasePage
{
    public $route = 'district';

    /**
     * @param array $districtData
     */
    public function submit(array $districtData)
    {
        foreach ($districtData as $field => $value) {
			$inputType = 'input';
			if ($field === 'district_id'){
				$inputType = 'select';
				$this->actor->selectOption($inputType . '[name="District[' . $field . ']"]', $value);
			} else {
				$this->actor->fillField($inputType . '[name="District[' . $field . ']"]', $value);
			}
        }
        $this->actor->click('Opslaan');
    }
}