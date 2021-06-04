<?php
$I = new AcceptanceTester($scenario);

$I->loginAsAdmin();

// Given there is a "controller" in the main JS file that sets the view
$I->wantTo('See that the correct view presents when a user comes to the settings page');

$I->amOnPage("/wp-admin/tools.php?page=migrate-posts");

$I->executeJS("MigratePosts.mainViewController('CONNECTED');");
$I->see("Post or Page ID");

$I->executeJS("MigratePosts.mainViewController('NOT CONNECTED');");
$I->see("You are not connected. You must send a connection email, and click the link contained in the email.");

$I->executeJS("MigratePosts.mainViewController('EMAIL PENDING');");
$I->see("A connection email is pending.");