<?php

/**
 * The purpose of the DevelopmentRestter class is to reset both development sites to a pristine state so that we can
 * run the acceptance suite. It should do things like reset post, users, and other data.
 */

class DevelopmentResetterTest extends \Codeception\TestCase\WPTestCase{

    use Codeception\AssertThrows;

    /**
     * @test
     */
    public function itShouldBeInstatiable(){
        $Resetter = new MigratePostsMothership\DevelopmentResetter();
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfActivatedOnAnyRougeSite()
    {
        //The reset() method expects a site name which should only be "Dev Site 1" or "Dev Site 2"
        $this->assertThrowsWithMessage(
            Exception::class,
            'ERROR: Site cannot be determined',
            function () {
                $Resetter = new MigratePostsMothership\DevelopmentResetter();
                $Resetter->reset("A bad / random site name");
            }
        );

        $this->assertDoesNotThrow(
            Exception::class,
            function() {
                $Resetter = new MigratePostsMothership\DevelopmentResetter();
                $Resetter->reset("Dev Site 1");
            }
        );

        $this->assertDoesNotThrow(
            Exception::class,
            function() {
                $Resetter = new MigratePostsMothership\DevelopmentResetter();
                $Resetter->reset("Dev Site 2");
            }
        );
    }

    /**
     * @test
     */
    public function itShouldDeleteAnyOldPosts(){
        //Given there is an old post in the DB
        $content = 'This post should not be accessible after reset';
        $my_post = array(
            'post_title'    => 'OLD POST',
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_author'   => 1,
        );
        $postID = wp_insert_post( $my_post );

        //When the DB is reset:
        //And we assume that we are on "Dev Site 1"
        $siteName = "Dev Site 1";
        $Resetter = new MigratePostsMothership\DevelopmentResetter();
        $Resetter->reset($siteName);

        //Then the old post should not be accessible
        $actualContent = get_post_field('post_content', $postID);
        $this->assertNotEquals($actualContent, $content);
    }

    /**
     * @test
     */
    public function itShouldDeleteAnyOldTrash(){
        $Resetter = new MigratePostsMothership\DevelopmentResetter();
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @test
     */
    public function itShouldAddDefaultContentToDevSite1(){
        $Resetter = new MigratePostsMothership\DevelopmentResetter();
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @test
     */
    public function addDefaultUserIfNoneExistsTest(){
        //Given the default user DOES NOT exist
        $defaultUser = "Codeception";
        $doesUserExist = username_exists($defaultUser );
        $this->assertFalse($doesUserExist);
        //When the site is reset
        $Resetter = new MigratePostsMothership\DevelopmentResetter();
        $Resetter->reset("Dev Site 1");
        //Then the default user should exist
        $userID = username_exists( $defaultUser);
        $this->assertNotFalse($userID);
        //And the user status should be "NOT CONNECTED" [because this is a newly created user!]
        $Auth = new MigratePosts\Auth();
        $userConnectionStatus = $Auth::getUserConnectionStatus($userID);
        $this->assertEquals("NOT CONNECTED", $userConnectionStatus);
    }
}