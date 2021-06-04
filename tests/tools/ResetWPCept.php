<?php 
$I = new AcceptanceTester($scenario);
//shell_exec ("bin/wp rewrite structure '/%postname%/'" );
$I->wantTo('Setup WordPress');
$I->amOnPage("/wp-admin/setup-config.php?step=1");
$I->see("Below you should enter your database connection details.");
$I->fillField('dbname', 'wordpress');
$I->fillField('uname', 'wordpressuser');
$I->click('.button');
$I->click('.button');
$I->fillField('weblog_title', '1Site1');
$I->fillField('user_name', 'admin');
//$I->fillField('#pass1-text', 'password');
//$I->fillField(['id' => 'pass1-text'], 'password');
$I->fillField(['id' => 'pass1'], 'password');
$I->fillField('admin_email', 'johndeebdd@gmail.com');
$I->checkOption('pw_weak');
$I->click('#submit');
sleep(3);
$myFile = "/var/www/html/wp-config.php";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = "define('FS_METHOD', 'direct');\n";
fwrite($fh, $stringData);
fclose($fh);

/*
$myFile = "/etc/apache2/apache2.conf";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = "<Directory /var/www/html/>
AllowOverride All
</Directory>";
fwrite($fh, $stringData);
fclose($fh);
*/