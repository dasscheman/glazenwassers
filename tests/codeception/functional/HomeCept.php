<?php

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('Biologenkantoor');
$I->seeLink('Wat is Glazenwasser?');
$I->click('Wat is Glazenwasser?');
$I->see('Wat is Glazenwasser?');
