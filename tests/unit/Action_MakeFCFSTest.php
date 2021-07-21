<?php

class Action_MakeFCFSTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function itShouldBeInstantiable(){
        $Action = new \FCFS\Action_MakeFCFS;	
	}
	
	/**
	 * @test
	 * it should designate a post as an FCFS post
	 */
	 public function itShoudlDesignateAPostAsAnFCFSPost(){
	    //Given there is a post:
	    $data = ['post_title'    => "test"];
        $postID = wp_insert_post( $data );
        
        //When the admin makes the post a valid FCFS post:
        $Action = new \FCFS\Action_MakeFCFS;
        $Action->makeFCFS($postID);
        
        //Then there should be post metadata called "fcfs"
        $result = metadata_exists("post",$postID, "fcfs");    	    
	    $this->assertTrue( $result );
	 }
	 
}