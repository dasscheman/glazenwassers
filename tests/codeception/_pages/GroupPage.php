<?php

namespace tests\codeception\_pages;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class GroupPage extends BasePage
{
    public $route = 'group';

    /**
     * @param array $groupData
     */
    public function submit(array $groupData)
    {
        foreach ($groupData as $field => $value) {
			$inputType = 'input';
			$this->actor->fillField($inputType . '[name="Group[' . $field . ']"]', $value);
        }
        $this->actor->click('Opslaan');
    }
}