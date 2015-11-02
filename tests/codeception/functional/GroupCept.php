<?php

use tests\codeception\_pages\LoginPage;
use tests\codeception\_pages\GroupPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that group actions works');

$groupPage = GroupPage::openBy($I);
$loginPage = LoginPage::openBy($I);
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('admin', 'sorbo');

$I->amOnPage('?r=group%2Findex');
$I->see('Groepen');

$I->seeLink('Groep Maken');
$I->click('Groep Maken');
$I->see('Groep Maken');

$I->amGoingTo('submit new group form with no data');
$groupPage->submit([
	'name' => '',
	'members' => '',
	'start_score' => '']);
$I->expectTo('see validations errors');
$I->see('Groepsnaam cannot be blank.');
$I->see('Leden cannot be blank.');
$I->see('Start Kapitaal cannot be blank.');

$I->amGoingTo('submit new street form with incorrect data');
$groupPage->submit([
	'name' => 'team extra',
	'members' => 'extra leden',
	'start_score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Start Kapitaal must be an integer.');

$I->amGoingTo('submit new street form with correct data');
$groupPage->submit([
	'name' => 'team extra',
	'members' => 'extra leden',
	'start_score' => 300]);
$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('delete a grouprecord');
$I->amOnPage('?r=group%2Fview&id=3');
//$I->click('Verwijderen');
//$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('update a street record with incorrect data');
$I->amOnPage('?r=group%2Fview&id=4');
$I->click('Bijwerken');
$groupPage->submit([
	'name' => 'team extra',
	'members' => 'extra leden',
	'start_score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Start Kapitaal must be an integer.');

$groupPage->submit([
	'name' => '',
	'members' => '',
	'start_score' => '']);
$I->expectTo('see validations errors');
$I->see('Groepsnaam cannot be blank.');
$I->see('Leden cannot be blank.');
$I->see('Start Kapitaal cannot be blank.');

$I->amGoingTo('update a street record with correct data');
$I->amOnPage('?r=group%2Fview&id=4');
$I->click('Bijwerken');
$groupPage->submit([
	'name' => 'team b extra',
	'members' => 'extra b leden',
	'start_score' => 400]);
$I->seeInCurrentUrl('?r=group%2Fview&id=4');