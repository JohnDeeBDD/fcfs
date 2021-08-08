<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create an FCFS post');

$I->loginAsAdmin();
$I->amOnPage('/wp-admin/edit.php?post_type=fcfs&mode=list');

$mockPostID = "1555";
$I->fillField("fcfs-makeFCFSPostID", $mockPostID);
$I->click('#fcfs-makefcfs-submit-button');

//TODO: this shouldn't happen!
sleep(1);

$I->see("Test Post One");
$I->amOnPage('/test-post-one/');
$I->see("1. Codeception");