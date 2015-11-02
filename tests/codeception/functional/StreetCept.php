<?php

use tests\codeception\_pages\LoginPage;
use tests\codeception\_pages\StreetPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that street actions works');

$streetPage = StreetPage::openBy($I);
$loginPage = LoginPage::openBy($I);
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('admin', 'sorbo');

$I->amOnPage('?r=street%2Findex');
$I->see('Straten');

$I->seeLink('Straat Maken');
$I->click('Straat Maken');
$I->see('Straat Maken');

$I->amGoingTo('submit new street form with no data');
$streetPage->submit([
	'name' => '',
	'score' => '']);
$I->expectTo('see validations errors');
$I->see('Straatnaam cannot be blank.');
$I->see('Prijs (€) cannot be blank.');

$I->amGoingTo('submit new street form with incorrect data');
$streetPage->submit([
	'name' => 'martinuskerk',
	'score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Prijs (€) must be an integer.');
$I->see('Wijk must be an integer.');

$I->amGoingTo('submit new street form with correct data');
$streetPage->submit([
    'name' => 'NieuweKerk',
	'district_id' => 'kerken',
	'score' => 25]);
$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('delete a streetrecord');
$I->amOnPage('?r=street%2Fview&id=2');
//$I->click('Verwijderen');
//$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('update a street record with incorrect data');
$I->amOnPage('?r=street%2Fview&id=2');
$I->click('Bijwerken');
$streetPage->submit([
    'name' => '',
	'district_id' => 'kerken',
	'score' => '']);
$I->expectTo('see validations errors');
$I->see('Straatnaam cannot be blank.');
$I->see('Prijs (€) cannot be blank.');

$streetPage->submit([
	'score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Prijs (€) must be an integer.');

$I->amGoingTo('update a street record with correct data');
$I->amOnPage('?r=street%2Fview&id=2');
$I->click('Bijwerken');
$streetPage->submit([
    'name' => 'NieuweKerk2',
	'district_id' => 'kerken',
	'score' => 45]);
$I->seeInCurrentUrl('?r=street%2Fview&id=2');