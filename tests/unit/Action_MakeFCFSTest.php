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
        $Action->postID = $postID;
        $Action->doMakeFCFS($postID);
        
        //Then there should be post metadata called "fcfs"
        $result = metadata_exists("post",$postID, "fcfs");    	    
	    $this->assertTrue( $result );
	 }

	 /**
	  * @test
	  * it should add the shortcode [FCFS] to the post content
	  */
	 public function itShouldAddTheShortcodeToThePost(){
		 //Given there is a post:
		 $postID = wp_insert_post( ['post_content' => "SOME CONTENT"] );

		 //When the action MakeFCFS is called on the post:
		 $Action = new \FCFS\Action_MakeFCFS;
		 $Action->postID = $postID;
		 $Action->doMakeFCFS($postID);

		 //Then the shortcode "[FCFS]" should be added to the content and saved in the DB
		 $Post = get_post($postID);
		 $content = $Post->post_content;
		 $expectedContent = "[FCFS]SOME CONTENT";
		 $this->assertEquals($expectedContent, $content, "shortcode was not added properly");
	 }
}