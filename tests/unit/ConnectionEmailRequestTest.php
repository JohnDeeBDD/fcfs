<?php

class ConnectionEmailRequestTest extends \Codeception\TestCase\WPTestCase
{

    /**
     * @test
     */
    public function classes_should_be_instantiatable(){
        $Action1 = new \MigratePosts\Action_SendConnectionEmailRequestToMothership();
        $Action2 = new \MigratePostsMothership\Action_ReceiveSendConnectionEmailRequest();
    }

    /**
     * @test
     * it should bounce bad emails
     */
    public function itShouldBounceBadEmails(){

    }

    /**
     * @test
     */
    public function theCorrectDataShouldBeCompiledBeforeBeingSentToTheMothership(){
        $user_id = $this->factory->user->create();
        wp_set_current_user( $user_id );

        $email = "name@email.com";

        // ??? this seems to be automatically set by the test framework ???
        $siteUrl = "http://locahost";

        //this sets the user data in the local test DB
        $user_data = wp_update_user( array( 'ID' => $user_id, 'user_email' => $email ) );


        $Action1 = new \MigratePosts\Action_SendConnectionEmailRequestToMothership();

        //This is what we're testing here:
        $data = $Action1->returnDataForPostBody($user_id);

        $this->assertEquals($email, $data['email']);
        $this->assertEquals($siteUrl, $data['siteUrl']);

        //The "nonce" should be a random string, 50 chars long:
        $this->assertTrue(is_string($data['nonce']));
        $this->assertEquals(50, strlen($data['nonce']));
    }

}