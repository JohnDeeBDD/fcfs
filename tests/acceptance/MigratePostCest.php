<?php

use MigratePosts\Constants;

class MigratePostCest{
	/**
	 * @test
	 * it should process a single transaction
	 */
	public function itShouldProcessASingleTransaction( AcceptanceTester $I ) {
		//Given there is a post on Site1
		//And there is a transaction referencing that post
		$postTitle = 'Test Post One';
		$Transaction = new MigratePosts\Transaction();
		$Transaction->status = "NOTSTARTED";
		$postObject = get_page_by_title($postTitle, OBJECT, 'post');
		$Transaction->postID = $postObject->ID;;

		//And that transaction is going to Site2
		$Constants = new MigratePosts\Constants();
		$Transaction->destinationURL = $Constants->site2Url;
		$Transaction->directive = "SEND";

		//When the transaction is processed
		$resultID = $Transaction->doProcess();

		//Then the post should be visible via the WorcPress API on Site2
		$URL = $Constants->site2Url . "wp-json/wp/v2/posts/" . $resultID;
		$result = wp_remote_get($URL);
		$result = json_decode($result['body']);
		$result = $result->title->rendered;

		//And the post title, as accessed via the API on Site2, should be the same as the original post title
		$I->assertEquals($postTitle, $result);
	}

	/**
	 * @test
	 * it should process two transactions
	 */

	public function itShouldProcessTwoTransactions( AcceptanceTester $I ) {
		//Given there is a post on Site1
		//And there is a transaction referencing that post
		$postTitle = 'Test Post Two';
		$Transaction = new MigratePosts\Transaction();
		$Transaction->status = "NOTSTARTED";
		$postObject = get_page_by_title($postTitle, OBJECT, 'post');
		$Transaction->postID = $postObject->ID;;

		//And that transaction is going to Site2
		$Constants = new MigratePosts\Constants();
		$Transaction->destinationURL = $Constants->site2Url;
		$Transaction->directive = "SEND";

		//When the transaction is processed
		$resultID = $Transaction->doProcess();

		//Then the post should be visible via the WorcPress API on Site2
		$URL = $Constants->site2Url . "wp-json/wp/v2/posts/" . $resultID;
		$result = wp_remote_get($URL);
		$result = json_decode($result['body']);
		$result = $result->title->rendered;

		//And the post title, as accessed via the API on Site2, should be the same as the original post title
		$I->assertEquals($postTitle, $result);

		$postTitle = 'Test Post Three';
		$Transaction2 = new MigratePosts\Transaction();
		$Transaction2->status = "NOTSTARTED";
		$postObject = get_page_by_title($postTitle, OBJECT, 'post');
		$Transaction2->postID = $postObject->ID;

		//And that transaction is going to Site2
		$Constants = new MigratePosts\Constants();
		$Transaction2->destinationURL = $Constants->site2Url;
		$Transaction2->directive = "SEND";

		//When the transaction is processed
		$resultID = $Transaction2->doProcess();

		//Then the post should be visible via the WorcPress API on Site2
		$URL = $Constants->site2Url . "wp-json/wp/v2/posts/" . $resultID;
		$result = wp_remote_get($URL);
		$result = json_decode($result['body']);
		$result = $result->title->rendered;
	}

	/**
	 * @test
	 * a manifest should run on it's own
	 */

	public function manifestShouldRunOnItsOwn( AcceptanceTester $I ) {
		$postTitle1 = 'Test Post Four';
		$postTitle2 = 'Test Post Five';
		$postTitle3 = 'Test Post Six';

		$Transaction1 = new MigratePosts\Transaction();
		$Transaction2 = new MigratePosts\Transaction();
		$Transaction3 = new MigratePosts\Transaction();

		$Transaction1->status = "NOTSTARTED";
		$Transaction2->status = "NOTSTARTED";
		$Transaction3->status = "NOTSTARTED";

		$postObject = get_page_by_title($postTitle1, OBJECT, 'post');
		$Transaction1->postID = $postObject->ID;
		$postObject = get_page_by_title($postTitle2, OBJECT, 'post');
		$Transaction2->postID = $postObject->ID;
		$postObject = get_page_by_title($postTitle3, OBJECT, 'post');
		$Transaction3->postID = $postObject->ID;

		$Constants = new MigratePosts\Constants();
		$Transaction1->destinationURL = $Constants->site2Url;
		$Transaction2->destinationURL = $Constants->site2Url;
		$Transaction3->destinationURL = $Constants->site2Url;

		$Transaction1->directive = "SEND";
		$Transaction2->directive = "SEND";
		$Transaction3->directive = "SEND";

		$Manifest = new MigratePosts\Manifest();
		$Manifest->manifest = [$Transaction1, $Transaction2, $Transaction3];

		update_option("migrate-posts-manifest", $Manifest);

		//$Initiator = new \MigratePosts\Initiator();
		//$Initiator->doNextTransactionInSeparateProcess();
		$Constants = new MigratePosts\Constants();
		$URL = ($Constants->site1Url) . "wp-json/migrate-posts/v1/do-process-manifest";
		wp_remote_post($URL, array(
			'method' => 'POST',
			'timeout' => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => false,
			//'headers' => array() ,
			//'body' => $send_data,
			//'cookies' => array()
		));
	}

}