<?php

class Action_DeleteFCFSTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function itShouldBeInstantiable() {
		$Action1 = new \FCFS\Action_DeleteFCFS();
		$Action2 = new \FCFS\Action_MakeFCFS;
	}

	/**
	 * @test
	 * it should delete the CPT if the enabled post is deleted
	 */
	public function itShould(){
		//Given there is a post:
		$data   = [ 'post_title' => "test" ];
		$postID = wp_insert_post( $data );
		//And the post is an FCFS post [which means there is a FCFS CPT assciated with the post-pt
		$Action         = new \FCFS\Action_MakeFCFS;
		$Action->postID = $postID;
		$FCFSpostID = $Action->doMakeFCFS();

		//The the action is enabled: this is the same as in the plugin, but we added a namespace:
		\add_action( 'delete_post', [new \FCFS\Action_DeleteFCFS, 'doDeleteSomeKindOfPost']);

		//When the post-pt is deleted
		wp_delete_post( $postID, true);

		//Then the FCFS cpt should ALSO be deleted
		$FCFSstauts =  get_post_status( $FCFSpostID );
		$title = get_the_title( $FCFSpostID);
		$this->assertFalse($FCFSstauts, "For some reason, PPT $postID Title $title FCFSpostID $FCFSpostID is still there");

	}
}