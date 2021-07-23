<?php

class SettingsPageTest extends \Codeception\TestCase\WPTestCase {
    
    /**
     * @test
     * classes should be instatiable
     */
     
    public function classesShouldBeInstatiable(){
        $Page = new \FCFS\Page_FCFS;    
    }
    
	/**
	 * @test
	 * method returnArrayFCFS_Posts test
	 */
	public function returnArrayOfFCFS_PostsTest(){
		//Given there are 3 posts:
		$postID1 = wp_insert_post(['post_title'=>'Test']);
		$postID2 = wp_insert_post(['post_title'=>'Test']);
		$postID3 = wp_insert_post(['post_title'=>'Test']);

		//And two of those posts are FCFS posts:
	    $Action = new \FCFS\Action_MakeFCFS;
	    //We'll skip the first one:
		//$Action->makeFCFS($postID1);
		$Action->makeFCFS($postID2);
	    $Action->makeFCFS($postID3);

	    //When returnArrayFCFS_Posts is called:
	    $Page = new \FCFS\Page_FCFS;
	    $givenArrayOfPostIDs = $Page->returnArrayFCFS_Posts();

	    //Then the two FCFS post IDs should be returned only:
	    $expectedResult = [$postID2, $postID3];
	    $this->assertEquals($expectedResult, $givenArrayOfPostIDs);
	}
	
	/**
	 * @test
	 * it should return an empty array if there are no FCFS posts
	 */
	 public function edgeCase_noFCFSposts(){
	     $Page = new \FCFS\Page_FCFS; 
	     $result = $Page->returnArrayFCFS_Posts();
	     $this->assertEquals([], $result);
	 }
	
}