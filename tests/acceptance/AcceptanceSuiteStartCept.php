<?php
$I = new AcceptanceTester($scenario);
$I->wantTo("reset the sitse for the acceptance suite tests");
$I->loginAsAdmin();

//When the "reset" API is touched:
$Constants = new MigratePosts\Constants();
$I->amOnUrl(($Constants->site1Url) . "/?migrate-posts-reset=true");
$I->amOnUrl(($Constants->site1Url) ."/wp-admin/edit.php");

//We create six dummy posts
$I->see("All (6)");

//There should be nothing in the trash:
$I->dontSee("Trash (");