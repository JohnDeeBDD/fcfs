<?php

class UserClickListTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function itShouldBeInstantiable(){
		$Manifest = new \FCFS\UserClickList();
	}
	
	/**
	 * @test
	 * it should output the list via a shortcode
	 */
	public function itShouldOutputTheListViaAShortcode(){
		//Given there is a post:
	    $data = [
	    	'post_title'    => "test",
	    	'post_content'  => "[FCFS]"
	    ];
        $postID = wp_insert_post( $data );

		//and a user:
		$userID = $this->factory->user->create( array( 'user_email' => "test@email.com",'user_login' => 'Someuser', 'role' => 'administrator' ) );
		wp_set_current_user( $userID );
		
		//When the user visits the page:
		$Clicklist = new \FCFS\UserClickList;
		$result = $Clicklist->doReturnClicklist($postID);
		
		//Then the clicklist should contian the user's screename
		$expectedResult = "1. Someuser";
		
		$this->assertEquals($expectedResult, $result);
	}
	
	
	/**
	 * @test
	 * it should contain an array
	 */
	 public function itShouldContainAnArray(){
		$Manifest = new \FCFS\UserClickList();
		$result = $Manifest->getUserList();
		$this->assertTrue(is_array($result));
	 }
	 
	 /**
	  * @test
	  * it should stash and fetch from the DB
	  */
	  public function itShouldStashAndFetchFromTheDB(){
		$UserList = new \FCFS\UserClickList();
		$sampleUserList = [1, 2, 3, 4, 5];
		$postID = 1;
		$UserList->setUserList($sampleUserList);
		$UserList->stashInDB($postID);
		
		$UserList2 = new \FCFS\UserClickList();
		$UserList2->fetchFromDB($postID);
		$userListFromDB = $UserList2->getUserList();
		
		$this->assertEquals($sampleUserList, $userListFromDB);
		
	  }
	  
	  /**
	   * @test
	   * it should be able to pull the user names
	   */
	   public function itShouldBeAbleToPullTheUserNames(){
			//Given there are 5 users in the site:
	        $userID1 = $this->factory->user->create( array( 'user_email' => 'email1@email1.com','user_login' => 'Bob', 'role' => 'administrator' ) );
	        $userID2 = $this->factory->user->create( array( 'user_email' => 'email2@email1.com','user_login' => 'Tom', 'role' => 'administrator' ) );
	        $userID3 = $this->factory->user->create( array( 'user_email' => 'email3@email1.com','user_login' => 'Sam', 'role' => 'administrator' ) );
	        $userID4 = $this->factory->user->create( array( 'user_email' => 'email4@email1.com','user_login' => 'Jill', 'role' => 'administrator' ) );
	        $userID5 = $this->factory->user->create( array( 'user_email' => 'email5@email1.com','user_login' => 'Dave', 'role' => 'administrator' ) );
	 		$UserList = new \FCFS\UserClickList();
			$sampleUserList = [$userID1, $userID2, $userID3, $userID4, $userID5];
			$postID = 1;
			$UserList->setUserList($sampleUserList);
	 		
	 		//When the list is outputed
	 		$actualOutput = $UserList->returnHTML();
	 		
	 		//Then the user names should be visable
			$expectedOutput = "<ul><li>Bob</li><li>Tom</li><li>Sam</li><li>Jill</li><li>Dave</li></ul>";
			$this->assertEquals($expectedOutput, $actualOutput);
	   }
	   
	   /**
	    * @test
	    * it should handle no users output
	    */
	    public function itShouldHandleNoUsers(){
	 		$UserList = new \FCFS\UserClickList();
			$sampleUserList = [];
			$postID = 1;
			$UserList->setUserList($sampleUserList);
	 		
	 		//When the list is outputed
	 		$actualOutput = $UserList->returnHTML();
	 		
	 		//Then "No users yet!" should be outputted
			$expectedOutput = "<ul><li>No users yet!</li></ul>";
			$this->assertEquals($expectedOutput, $actualOutput);
	    }
}