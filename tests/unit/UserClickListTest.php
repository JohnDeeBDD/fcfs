<?php

class UserClickListTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function itShouldBeInstantiable(){
		$Manifest = new \FCFS\UserClickList();
	}
	
	private function createMockClickListInDB($postID){
		$Action = new \FCFS\Action_VisitFCFS_Page();
		//Given there are 5 users in the site:
	    $userID1 = $this->factory->user->create( array( 'user_email' => 'email1@email1.com','user_login' => 'Jim', 'role' => 'administrator' ) );
	    $time = 100;
	    $Action->doAction($userID1, $postID, $time);
	    
	    $userID2 = $this->factory->user->create( array( 'user_email' => 'email2@email1.com','user_login' => 'Tom', 'role' => 'administrator' ) );
	    $time = 222;
	    $Action->doAction($userID2, $postID, $time);
	    
	    $userID3 = $this->factory->user->create( array( 'user_email' => 'email3@email1.com','user_login' => 'Sam', 'role' => 'administrator' ) );
	    $time = 333;
	    $Action->doAction($userID3, $postID, $time);
	    
	    $userID4 = $this->factory->user->create( array( 'user_email' => 'email4@email1.com','user_login' => 'Jill', 'role' => 'administrator' ) );
	    $time = 444;
	    $Action->doAction($userID4, $postID, $time);
	    
	    $userID5 = $this->factory->user->create( array( 'user_email' => 'email5@email1.com','user_login' => 'Dave', 'role' => 'administrator' ) );
	    $time = 555;
	    $Action->doAction($userID5, $postID, $time);
	    
	    $userIDs = [$userID1, $userID2, $userID3, $userID4, $userID5];
	    return $userIDs;
	}
	private function createMockPost(){
		//This function mocks a FCFS post.
		$data = [
	    	'post_title'    => "Test Title",
	    	'post_content'  => "lorum ipsum"
	    ];
        $postID = wp_insert_post( $data );
        $Action = new \FCFS\Action_MakeFCFS;
        $Action->makeFCFS($postID);
        return ($postID);
	}
	
	
	/**
	 * @test
	 * it should output the list of user IDs
	 */
	public function itShouldOutputTheListOfUserIds(){
		//Given there is a mock post and a bunch of previous clicks
		$postID = $this->createMockPost();
		$userIDs = $this->createMockClickListInDB($postID);
		
		//When the method returnArrayOfUserIDs is called
		$ClickList = new \FCFS\UserClickList();
		
		//Then it should return the list of IDs
		$expected = $userIDs;
		$given = $ClickList->returnListArray($postID);

		$this->assertEquals($expected, $given);
	}
	 
	  
	  /**
	   * @test
	   * it should be able to output the user names
	   */
	   public function itShouldBeAbleToOutputTheUserNames(){
	   	$this->markTestIncomplete("output of userIDs should be done first.");
	   }
	   
	   /**
	    * @test
	    * it should handle no users output
	    */
	    public function itShouldHandleNoUsers(){
	 		$UserList = new \FCFS\UserClickList();
			$sampleUserList = [];
			$postID = 1;
				 		
	 		//When the list is outputed
	 		$actualOutput = $UserList->returnHTML();
	 		
	 		//Then "No users yet!" should be outputted
			$expectedOutput = "<ul><li>No users yet!</li></ul>";
			$this->assertEquals($expectedOutput, $actualOutput);
	    }
}