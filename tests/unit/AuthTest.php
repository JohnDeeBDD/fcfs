<?php

/*
Anatomy of a connection
Connections to migrate post are on a per user, per email basis.
Each user starts out as "NOT CONNECTED".
When a user attempts to connect, the site creates a






 */

class AuthTest extends \Codeception\TestCase\WPTestCase{

    /**
     * @test
     * it should store incoming auth nonce
     * it should calculate the incoming auth nonce
     * the Acceptor should bounce bad incoming requests
     * the Acceptor should notify mothership if bad requests are coming in
     */

    /**
     * @test
     * getUserConnectionStatus should return "NOT CONNECTED"
     */
    public function getUserConnectionStatusShouldReturnNotConnected(){
        //Given there is a user that is not connected
        //When getUserConnectionStatus is called
        //Then is should return NOT CONNECTED
        $result = \MigratePosts\Auth::getUserConnectionStatus(1);
        $this->assertEquals("NOT CONNECTED", $result);

        //And this should also be true if the user creates a meta and then deletes it:
        $data = ["nonce" => "ABC", "expires" => "123"];
        update_user_meta(1, "migrate-posts-last-valid-nonce", $data);
        delete_user_meta(1, "migrate-posts-last-valid-nonce");

        $result = \MigratePosts\Auth::getUserConnectionStatus(1);
        $this->assertEquals("NOT CONNECTED", $result);
    }

    /**
     * @test
     * it should set the pending time 15 minutes into the future
     */
    public function itShouldSetThePendingTime15MinutesIntoTheFuture(){
        \MigratePosts\Auth::setEmailNonce(1);
        $data = get_user_meta(1, "migrate-posts-last-valid-nonce");

        //The unix time should be pretty darned close to 15 mins, we'll go greater than 14 and less than 16 here
        $expires = $data[0]['expires'];
        $timePlus14 = time() + (60 * 14);
        $this->assertGreaterThan($timePlus14, $expires);
        $timePlus16 = time() + (60 * 16);
        $this->assertLessThan($timePlus16, $expires);
    }

    /**
     * @test
     * getUserConnectionStatus should kill the pending email if expired
     */
    public function getUserConnectionStatusShouldKillPendingIfExpired(){
        \MigratePosts\Auth::setEmailNonce(1);

        $randomString = "asdf;lkjasdf;lkjwe4oih23ohasdf";

        //set expiry to yesterday:
        $timeMinus24 = time() - (24*60*60);

        $data = ["nonce" => $randomString, "expires" => $timeMinus24];
        update_user_meta(1, "migrate-posts-last-valid-nonce", $data);

        $result = \MigratePosts\Auth::getUserConnectionStatus(1);
        $this->assertEquals("NOT CONNECTED", $result);
    }

    /**
     * @test
     * it should validate an incoming email nonce
     */
    public function isEmailNonceValid(){
        $nonce = \MigratePosts\Auth::setEmailNonce(1);
        $response = \MigratePosts\Auth::isEmailNonceValid(1, $nonce);
        $this->assertEquals(true, $response);
    }

    /**
     * @test
     * it should invalidate a bad incoming email nonce
     */
    public function isEmailNonceInvalid(){
        $nonce = \MigratePosts\Auth::setEmailNonce(1);
        $response = \MigratePosts\Auth::isEmailNonceValid(1, "notAValidNonce");
        $this->assertEquals(false, $response);
    }

    /*
     * Anatomy of an auth nonce
     * First half = node nonce
     * 2nd half = mothership nonce
     * nonce has expiration time
     * last successful nonce is stored
     * if no successfull nonce is there, not connected
     *
     * starting state:
     * has last good nonce
     * expired incoming nonce
     *
     * initiator        acceptor            ms

     *
     * user creates manifest on node1
     * submit incoming nonce to mothership
     * submit manifest to mothership
     *  receieve incoming and ms-nonce upon success
     *  ms-nonce is incoming nonce on node2
     * process manifest passing node2 incoming nonce
     * node2 holds manifest in que until done
     * node2 submits compleated manifest
     *  receive new incoming nonce
     *  node1 request new incoming nonce
     *
     *
     *

    */
}