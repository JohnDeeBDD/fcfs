<?php

class InitiatorTest extends \Codeception\TestCase\WPTestCase{
    /**
     * @todo
     * it should stash a manifest
     */
    public function itShouldStashAManifest(){
        $Manifest= new \MigratePosts\Manifest();

        //Given there is a manifest
        $Manifest = $Manifest->getMockManifest();

        //And there is an available API
        $Initiator = new MigratePosts\Initiator();
        add_action ('rest_api_init', [$Initiator, 'doRegisterRoutes']);
        global $wp_rest_server;
	    $wp_rest_server = new WP_REST_Server;
        do_action( 'rest_api_init' );
		//When the mothership calls the stash-manifest API
		$request = new WP_REST_Request( 'POST', '/migrate-posts/v1/stash-manifest' );
		$_POST['migrate-posts-manifest'] = $Manifest->manifest;
		$response = $wp_rest_server->dispatch( $request );

		$this->assertEquals( 200, $response->get_status() );
		//Then the manifest should be stashed in the database
		$data = $response->get_data();
		$this->assertEquals($data, "KAPLA!");
		$dbOption = get_option("migrate-posts-manifest");
		$this->assertEquals( $Manifest->manifest, $dbOption);
    }
}