<?php

class Action_OpenCloseFCFSTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function classesShouldBeInstantiable(){
		$Action1 = new \FCFS\Action_OpenCloseFCFS;
		$Action2 = new \FCFS\Action_MakeFCFS;
	}

	/**
	 * @test
	 *
	 */
	public function makeFCFS_PostOpenTest(){
		//Given there is a post
		$data   = [
			'post_title'   => "Test Title",
			'post_content' => "lorum ipsum"
		];
		$postID = wp_insert_post( $data );
		
		//And the post is an FCFS post:
		$Action = new \FCFS\Action_MakeFCFS();
		$Action->doMakeFCFS($postID);
		
		//When the method doMakeFCFS_postOpen is called:		
		$Action2 = new \FCFS\Action_OpenCloseFCFS();
		$Action2->doMakeFCFS_postOpen($postID);
		
		//Then the post meta should contain status:open
		$meta =	get_post_meta($postID, 'fcfs', true);
		$expectedMeta = ['status' => 'open'];
		$this->assertEquals($meta, $expectedMeta);
	}

	/**
	 * @test
	 *
	 */
	public function makeFCFS_PostClosedTest(){
		//Given there is a post
		$data   = [
			'post_title'   => "Test Title",
			'post_content' => "lorum ipsum"
		];
		$postID = wp_insert_post( $data );
		
		//And the post is an FCFS post:
		$Action = new \FCFS\Action_MakeFCFS();
		$Action->doMakeFCFS($postID);
		
		//When the method doMakeFCFS_postOClosed is called:		
		$Action2 = new \FCFS\Action_OpenCloseFCFS();
		$Action2->doMakeFCFS_postClosed($postID);
		
		//Then the post meta should contain status:closed
		$meta =	get_post_meta($postID, 'fcfs', true);
		$expectedMeta = ['status' => 'closed'];
		$this->assertEquals($meta, $expectedMeta);
	}

}