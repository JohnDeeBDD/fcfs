<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See that the js function gatherIDsVisableInEditor works');

//Given there are 5 posts
//When I go to the FCFS settings page
$I->loginAsAdmin();
$I->amOnPage('/wp-admin/edit.php?post_type=fcfs&mode=list');
$I->see('FCFS');

//And I execute the function
$result = $I->executeJS('return FCFS.gatherIDsVisableInEditor();');


//When I execute the function doAJAX_FetchPostTitle(1555)
//Then it should return the title of post 1555
$result = $I->executeJS('return FCFS.doAJAX_FetchPostTitle(1555);');
$expectedResult = "Test Post One";

$I->assertEquals($expectedResult, $result);


//Given three is a jQuery document ready func that should convert the
//FCFS-post-titles to the value of the actual post IDs that the title string represent
$I->see('Test Post One');