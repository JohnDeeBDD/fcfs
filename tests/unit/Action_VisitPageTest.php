<?php

include_once("/var/www/html/wp-content/plugins/fcfs/src/FCFS/autoloader.php");
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
        $Action->doMakeFCFS($postID);
	  
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
	  
	  /**
	   * @ignore
	   * edge case: user visits FCFS page that is NOT opened
	   */
	   public function userVisitsClosedFCFS_page(){
	   //Given there is an FCFS post	 
		$data   = [
			'post_title'   => "Test Title",
			'post_content' => "lorum ipsum"
		];
		$postID = wp_insert_post( $data );
		$Action = new \FCFS\Action_MakeFCFS();
		$Action->doMakeFCFS($postID);
		
		//And the page is NOT opened
		//In this case we will NOT open the post!
		//$Action2 = new \FCFS\Action_OpenCloseFCFS();
		//$Action2->doMakeFCFS_postOpen($postID);
	    
	   //Then nothing should happen
	   $Action2 = new \FCFS\Action_VisitFCFS_Page;
	   $userID1 = $this->factory->user->create( array(
			'user_email' => 'email1@email1.com',
			'user_login' => 'Jim',
			'role'       => 'administrator'
		) );
		$time = 123;
	   $result = $Action2->doAction($userID, $postID, $time);
	   
	   
	   $this->assertFalse($result);
	   
	   
	   }
	  
	  
}