<?php

use tests\codeception\_pages\AboutPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that about works');
AboutPage::openBy($I);
$I->see('Wat is Glazenwasser?', 'h1');
