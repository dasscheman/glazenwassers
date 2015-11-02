<?php

use tests\codeception\_pages\LoginPage;
use tests\codeception\_pages\StreettransactionPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that streettransaction actions works');

$streettransactionPage = StreettransactionPage::openBy($I);
$loginPage = LoginPage::openBy($I);
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('admin', 'sorbo');

$I->amOnPage('?r=streettransaction%2Findex');
$I->see('Glazen wassen');

$I->amGoingTo('update all streettransactions');
$I->seeLink('Alle transacties updaten');
$I->click('Alle transacties updaten');
$I->see('Glazen wassen');

$I->amGoingTo('check all streettransactions in database');
$I->seeInDatabase('streettransaction', array(
	'id' => 8,
	'street_id' => 2,
	'group_id' => 4,
	'status' => 0,
	'start_datetime' => '2015-03-26 20:52:30',
	'end_datetime' => '2015-03-26 21:07:30'));

$I->seeInDatabase('streettransaction', array(
	'id' =>9,
	'street_id' => 2,
	'group_id' => 3,
	'status' => 4,
	'start_datetime' => '2015-03-26 20:55:30',
	'end_datetime' => '0000-00-00 00:00:00'));

$I->seeInDatabase('streettransaction', array(
	'id' => 10,
	'street_id' => 2,
	'group_id' => 3,
	'status' => 0,
	'start_datetime' => '2015-03-26 21:42:10',
	'end_datetime' => '2015-03-26 21:57:10'));

$I->seeInDatabase('streettransaction', array(
	'id' => 11,
	'street_id' => 11,
	'group_id' => 3,
	'status' => 0,
	'start_datetime' => '2015-03-26 21:42:25',
	'end_datetime' => '2015-03-26 21:57:25'));

$I->seeInDatabase('streettransaction', array(
	'id' => 12,
	'street_id' => 13,
	'group_id' => 3,
	'status' => 0,
	'start_datetime' => '2015-03-26 22:08:25',
	'end_datetime' =>  '2015-03-26 22:23:25'));

$I->seeInDatabase('streettransaction', array(
	'id' => 13,
	'street_id' => 2,
	'group_id' => 3,
	'status' => 1,
	'start_datetime' => '2015-03-29 15:35:40',
	'end_datetime' => '2015-03-29 15:50:40'));

$I->seeInDatabase('streettransaction', array(
	'id' => 14,
	'street_id' => 2,
	'group_id' => 4,
	'status' => 4,
	'start_datetime' => '2015-03-29 15:36:10',
	'end_datetime' =>'0000-00-00 00:00:00'));

$I->seeInDatabase('streettransaction', array(
	'id' => 15,
	'street_id' => 7,
	'group_id' => 5,
	'status' => 0,
	'start_datetime' => '2015-03-29 15:36:20',
	'end_datetime' => '2015-03-29 15:51:20'));

$I->seeInDatabase('streettransaction', array(
	'id' => 16,
	'street_id' => 8,
	'group_id' => 5,
	'status' => 0,
	'start_datetime' => '2015-03-29 15:36:30',
	'end_datetime' =>  '2015-03-29 15:51:30'));


$I->amGoingTo('check all grouptransactions in database');
$I->seeInDatabase('grouptransaction', array(
//	'id' => 1123,
	'street_transaction_id' => 8,
	'group_id' => 4,
	'status' => 6,
	'score' => 8,
	'datetime' => '2015-03-26 20:52:30'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1124,
	'street_transaction_id' => 9,
	'group_id' => 3,
	'status' => 2,
	'score' => -8,
	'datetime' => '2015-03-26 20:55:30'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1125,
	'street_transaction_id' => 9,
	'group_id' => 4,
	'status' => 0,
	'score' => 8,
	'datetime' => '2015-03-26 20:55:30'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1126,
	'street_transaction_id' => 10,
	'group_id' => 3,
	'status' => 6,
	'score' => 8,
	'datetime' => '2015-03-26 21:42:10'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1127,
	'street_transaction_id' => 11,
	'group_id' => 3,
	'status' => 6,
	'score' => 4,
	'datetime' => '2015-03-26 21:42:25'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1128,
	'street_transaction_id' => 12,
	'group_id' => 3,
	'status' => 6,
	'score' => 13,
	'datetime' => '2015-03-26 22:08:25'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1128,
	'street_transaction_id' => 13,
	'group_id' => 3,
	'status' => 6,
	'score' => 8,
	'datetime' => '2015-03-29 15:35:40'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1130,
	'street_transaction_id' => 14,
	'group_id' => 4,
	'status' => 2,
	'score' => -8,
	'datetime' => '2015-03-29 15:36:10'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1131,
	'street_transaction_id' => 14,
	'group_id' => 3,
	'status' => 0,
	'score' => 8,
	'datetime' => '2015-03-29 15:36:10'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1133,
	'street_transaction_id' => 15,
	'group_id' => 5,
	'status' => 6,
	'score' => 7,
	'datetime' => '2015-03-29 15:36:20'));

$I->seeInDatabase('grouptransaction', array(
//	'id' => 1132,
	'street_transaction_id' => 16,
	'group_id' => 5,
	'status' => 6,
	'score' => 4,
	'datetime' => '2015-03-29 15:36:30'));

$I->seeLink('Nieuwe ramen wassen');
$I->click('Nieuwe ramen wassen');
$I->see('Nieuwe ramen wassen');
/*
$I->amGoingTo('submit new streettransaction form with correct data');
$streettransactionPage->submit([
    'name' => 'downtown',
	'score' => 44]);
$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('delete a streettransactionrecord');
$I->amOnPage('?r=district%2Fview&id=2');
//$I->click('Verwijderen');
//$I->seeInCurrentUrl('?r=site%2Findex-opzetten');

$I->amGoingTo('update a streettransaction record with incorrect data');
$I->amOnPage('?r=district%2Fview&id=3');
$I->click('Bijwerken');
$streettransactionPage->submit([
	'name' => '',
	'score' => '']);
$I->expectTo('see validations errors');
$I->see('Wijknaam cannot be blank.');
$I->see('Bijbetaling voor een hele wijk (€) cannot be blank.');

$streettransactionPage->submit([
	'score' => 'text']);
$I->expectTo('see validations errors');
$I->see('Bijbetaling voor een hele wijk (€) must be an integer.');

$I->amGoingTo('update a streettransaction record with correct data');
$I->amOnPage('?r=district%2Fview&id=3');
$I->click('Bijwerken');
$streettransactionPage->submit([
    'name' => 'hogescholen',
	'score' => 45]);
$I->seeInCurrentUrl('?r=district%2Fview&id=3');

*/