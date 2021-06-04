<?php

class Mothership_Action_ValidateEmailNonceTest extends \Codeception\TestCase\WPTestCase
{

    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable(){
        $Action = new \MigratePosts\Mothership_Action_ValidateEmailNonce();
    }

    /**
     * @test
     * it should return true when a good validation is attempted
     */
    public function returnTrueWhenValidationIsAttempted(){
        //Given an email nonce has been created

        $Url = "https://somesite.com";
        $nonce = \MigratePosts\Auth::mothership_setEmailNonce(1, $Url);
        $result = \MigratePosts\Auth::mothership_isEmailNonceValid(1, $Url, $nonce);
        $this->assertTrue($result);
    }

    /**
     * @test
     * it should return false when a bad validation is attempted
     */
    public function returnFalseWhenValidationIsAttempted(){
        //Given an "email nonce" has been created
        $Url = "https://somesite.com";
        $nonce = \MigratePosts\Auth::mothership_setEmailNonce(1, $Url);

        //When validation is attempted with the bad nonce
        $result = \MigratePosts\Auth::mothership_isEmailNonceValid(1, $Url, "bad nonce");

        //Then a false reseult should occur
        $this->assertFalse($result);
    }

}