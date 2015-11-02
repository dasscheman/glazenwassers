<?php

use tests\codeception\_pages\LoginPage;
use tests\codeception\_pages\DistrictPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that district actions works');

$districtPage = DistrictPage::openBy($I);
$loginPage = LoginPage::openBy($I);
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('admin', 'sorbo');

$I->amOnPage('?r=district%2Findex');
$I->see('Wijken');

$I->seeLink('Wijk Maken');
$I->click('Wijk Maken');
$I->see('Wijk Maken');

$I->amGoingTo('submit new district form with no data');
$districtPage->submit([
	'name' => '',
	'score' => '']);
$I->expectTo('see validations errors');
$I->see('Wijknaam cannot be blank.');
$I->see('Bijbetaling voor een hele wijk (€) cannot be blank.');

$I->amGoingTo('submit new street form with incorrect data');
$districtPage->submit([
	'score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Bijbetaling voor een hele wijk (€) must be an integer.');

$I->amGoingTo('submit new street form with correct data');
$districtPage->submit([
    'name' => 'downtown',
	'score' => 44]);
$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('delete a districtrecord');
$I->amOnPage('?r=district%2Fview&id=2');
//$I->click('Verwijderen');
//$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('update a street record with incorrect data');
$I->amOnPage('?r=district%2Fview&id=3');
$I->click('Bijwerken');
$districtPage->submit([
	'name' => '',
	'score' => '']);
$I->expectTo('see validations errors');
$I->see('Wijknaam cannot be blank.');
$I->see('Bijbetaling voor een hele wijk (€) cannot be blank.');

$districtPage->submit([
	'score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Bijbetaling voor een hele wijk (€) must be an integer.');

$I->amGoingTo('update a district record with correct data');
$I->amOnPage('?r=district%2Fview&id=3');
$I->click('Bijwerken');
$districtPage->submit([
    'name' => 'hogescholen',
	'score' => 45]);
$I->seeInCurrentUrl('?r=district%2Fview&id=3');