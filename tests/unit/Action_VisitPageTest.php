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
	
	 /**
	  * @test
	  * it should record a timestamp when the user visits the page
	  */
	  public function itShouldRecordATimestampWhenTheUserVisitsThePage(){
	  	//Given there is a post:
	    $data = ['post_title'    => "test"];
        $postID = wp_insert_post( $data );
        
        //And the admin has dsignated it FCFS:
        $Action = new \FCFS\Action_MakeFCFS;
        $Action->makeFCFS($postID);
	  
	    //When user visists the page at a particular time:
		$userID = 123;
	  	$time = 567;
	  	$key = "fcfs-" . $userID;
	  	$Action = new \FCFS\Action_VisitFCFS_Page();
	  	//$time = time();
	  	$Action->doAction($userID, $postID, $time);
	  	
		//Then a valid timestamp should be recorded as post meta
		$result = get_post_meta( $postID, $key, true);
		
		$expectedResult = $time;
		$this->assertEquals($expectedResult, $result);
	  }
	  
	  
}