<?php

include_once("/var/www/html/wp-conten/plugins/fcfs/src/fcfs/autoloader.php");
class Action_VisitPageTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function itShouldBeInstantiable() {
		$Action = new \FCFS\Action_VisitFCFS_Page();
	}
}

// bin/codecept run unit -vvv --html
// cd /var/www/html/wp-content/plugins/fcfs