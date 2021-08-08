<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See that the browser can launch');
$I->amOnUrl("https://generalchicken.guru");
//pause();
$I->see("Yum! General Tso’s");
$I->dontSee("Yabadaba.");

function pause(){
    echo "Press ENTER to continue: ";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    fclose($handle);
    echo "\n";
    RETURN;
}