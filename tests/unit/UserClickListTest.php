<?php

use Codeception\TestCase\WPTestCase;
use FCFS\Action_MakeFCFS;
use FCFS\Action_VisitFCFS_Page;
use FCFS\UserClickList;

class UserClickListTest extends WPTestCase {
	/**
	 * @test
	 * classes should be instantiable
	 */
	public function classesShouldBeInstantiable() {
		$UserClickList = new UserClickList();
		$Action_MakeFCFS = new Action_MakeFCFS();
		$Action_VisitFCFS_Page = new Action_VisitFCFS_Page();
	}

	/**
	 * @test
	 * UserClickList->returnArrayOfUserIDs() test
	 */
	public function func_returnArrayOfUserIDsTest() {
		//Given there is a mock post and a bunch of previous clicks
		$postID  = $this->createMockPost();
		$userIDs = $this->createMockClickListInDB( $postID );

		//When the method returnArrayOfUserIDs is called
		$ClickList = new UserClickList();
		$result = $ClickList->returnArrayOfUserIDs( $postID );

		//Then it should return the list of IDs
		$this->assertEquals( $userIDs, $result );
	}

	/**
	 * @test
	 * returnArrayOfUserNames()
	 */
	public function func_returnArrayOfUserNamesTest() {
		//Given there is a mock post and a bunch of previous clicks
		$postID  = $this->createMockPost();
		$userIDs = $this->createMockClickListInDB( $postID );

		//When the method returnArrayOfUserNames is called
		$ClickList = new UserClickList();

		//Then it should return the list of IDs
		$expected = [ "Jim", "Tom", "Sam", "Jill", "Dave" ];
		$given    = $ClickList->returnArrayOfUserNames( $postID );

		$this->assertEquals( $expected, $given );
	}

	/**
	 * @test
	 * edge case: no users
	 */
	public function edgeCase_NoUsersTest() {
		//Given there is a mock post with no clicks
		$postID  = $this->createMockPost();
		$Action = new Action_MakeFCFS();
		$Action->postID = $postID;
		$Action->doMakeFCFS();

		//When the method returnArrayOfUserNames is called
		$ClickList = new UserClickList();

		//Then it should return "No users yet"
		$expected = "No users yet";
		//not just a string! $expected = "No users yet";
		$given    = $ClickList->returnArrayOfUserNames( $postID );

		$this->assertEquals( $expected, $given );
	}

	/**
	 * @test
	 * edge case: the post isn't a registered FCFS
	 */
	public function edgeCase_thePostIsNotFCFS(){
		//Given there is a post that is NOT a FCFS post
		$data   = [
			'post_title'   => "Test Title",
			'post_content' => "lorum ipsum"
		];
		$postID = wp_insert_post( $data );

		//In this test, we will NOT make the post an FCFS post:
		/*
		$Action = new Action_MakeFCFS;
		$Action->makeFCFS( $postID );
		*/

		//When the method returnArrayOfUserNames is called
		$ClickList = new UserClickList();

		//Then it should return "Not an FCFS post"
		$expected = "ERROR: Not an FCFS post";
		$given    = $ClickList->returnArrayOfUserNames( $postID );

		$this->assertEquals( $expected, $given );
	}

	private function createMockPost() {
		//This function mocks a FCFS post. However, there are no clicks yet.
		$data   = [
			'post_title'   => "Test Title",
			'post_content' => "lorum ipsum"
		];
		$postID = wp_insert_post( $data );
		$Action = new Action_MakeFCFS;
		$Action->doMakeFCFS( $postID );

		return ( $postID );
	}

	private function createMockClickListInDB( $postID ) {
		$Action = new Action_VisitFCFS_Page();
		//Given there are 5 users in the site:
		$userID1 = $this->factory->user->create( array(
			'user_email' => 'email1@email1.com',
			'user_login' => 'Jim',
			'role'       => 'administrator'
		) );
		//Who have each clicked the FCFS page:
		$time = 100;
		$Action->doAction( $userID1, $postID, $time );

		$userID2 = $this->factory->user->create( array(
			'user_email' => 'email2@email1.com',
			'user_login' => 'Tom',
			'role'       => 'administrator'
		) );
		$time    = 222;
		$Action->doAction( $userID2, $postID, $time );

		$userID3 = $this->factory->user->create( array(
			'user_email' => 'email3@email1.com',
			'user_login' => 'Sam',
			'role'       => 'administrator'
		) );
		$time    = 333;
		$Action->doAction( $userID3, $postID, $time );

		$userID4 = $this->factory->user->create( array(
			'user_email' => 'email4@email1.com',
			'user_login' => 'Jill',
			'role'       => 'administrator'
		) );
		$time    = 444;
		$Action->doAction( $userID4, $postID, $time );

		$userID5 = $this->factory->user->create( array(
			'user_email' => 'email5@email1.com',
			'user_login' => 'Dave',
			'role'       => 'administrator'
		) );
		$time    = 555;
		$Action->doAction( $userID5, $postID, $time );

		$userIDs = [ $userID1, $userID2, $userID3, $userID4, $userID5 ];

		return $userIDs;
	}

}