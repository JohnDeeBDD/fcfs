<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

   /**
    * Define custom actions here
    */
   public function getScenario() {
	   // TODO: Implement getScenario() method.
   }

	public function __construct()
   {
       //parent::__construct($scenario);

       //require_once('/var/www/html/wphttps/wp-content/plugins/developer-contest/src/DeveloperContest/autoloader.php');

       require_once('/var/www/html/wp-content/plugins/migrate-posts/src/MigratePosts/autoloader.php');
       require_once('/var/www/html/wp-content/plugins/migrate-posts/src/MigratePostsMothership/autoloader.php');


   }

    public function getMockManifest(){
        $Manifest = new \MigratePosts\Manifest();
        $Constants = new \MigratePosts\Constants();
        $Site2Url = $Constants->site2Url;

        $Transaction1 = new \MigratePosts\Transaction();
        $Transaction1->postID = 3;
        $Transaction1->destinationURL = $Site2Url;
        $Transaction1->directive = "send";

        $Transaction2 = new \MigratePosts\Transaction();
        $Transaction2->postID = 5;
        $Transaction2->destinationURL = $Site2Url;
        $Transaction2->directive = "send";

        $manifest = [
            $Transaction1,
            $Transaction2
        ];

        $Manifest->manifest = $manifest;
        return $Manifest;
    }

}