<?php

class ManifestTest extends \Codeception\TestCase\WPTestCase {


    /**
     * @test
     * it should return the next transaction
     */
    public function itShouldReturnTheNextTransaction(){
	    $UnitTester = new UnitTester();

	    $Transaction1 = new \MigratePosts\Transaction();
	    $Transaction1 = $Transaction1->getMockTransaction("FIRST");

	    $Manifest = new MigratePosts\Manifest();
	    $Manifest = $Manifest->getMockManifest();

	    //When the getNextTransaction method is called
	    $nextTransaction = $Manifest->getNextTransaction();

	    $this->assertEquals($Transaction1, $nextTransaction);
    }

    /**
     * @test
     * it should return the next two transactions
     */
    public function itShouldReturnTheNextTwoTransactions(){
	    $Transaction1 = new \MigratePosts\Transaction();
	    $Transaction2 = new \MigratePosts\Transaction();
	    $Transaction1 = $Transaction1->getMockTransaction("FIRST");
	    $Transaction2 = $Transaction2->getMockTransaction("SECOND");

	    $Manifest = new MigratePosts\Manifest();
	    $Manifest = $Manifest->getMockManifest();

	    //When the getNextTransaction method is called
	    $nextTransaction = $Manifest->getNextTransaction();
	    $this->assertEquals($Transaction1, $nextTransaction);
	    $nextTransaction = $Manifest->getNextTransaction();

	    $this->assertEquals($Transaction2, $nextTransaction);
    }

    /**
     * @test
     * it should return no action if there is nothing in the manifest
     */
    public function itShouldReturnNoAction(){
        $Manifest = new MigratePosts\Manifest();
        //Given there is a manifest with no transactions in it
        $Manifest->manifest = [];

        //When the getNextTransaction method is called
        $nextTransaction = $Manifest->getNextTransaction();

        //Then "no transactions" should be returned
        $Constants = new \MigratePosts\Constants();
        $Site2Url = $Constants->site2Url;
        $this->assertEquals("No transactions", $nextTransaction);
    }

	/**
	 * @test
	 * if its not an array, getNextTransaction() should return false
	 */
	public function ifItsNotAnArrayItShouldReturnFalse(){
		$Manifest = new MigratePosts\Manifest();
		$Manifest = $Manifest->getMockManifest();
		$Manifest->manifest = "NOT AN ARRAY";
		$result = $Manifest->getNextTransaction();
		$this->assertEquals(FALSE, $result);
	}

    /**
     * @test
     * it should return the next transaction that is not done
     */
    public function itShouldReturnTheNextTransactionThatIsNotDone(){
	    $Transaction1 = new \MigratePosts\Transaction();
	    $Transaction2 = new \MigratePosts\Transaction();
	    $Transaction3 = new MigratePosts\Transaction();
	    $Transaction4 = new MigratePosts\Transaction();

	    $Transaction1 = $Transaction1->getMockTransaction("FIRST");
	    $Transaction2 = $Transaction2->getMockTransaction("SECOND");

	    //This transaction is marked "DONE":
	    $Transaction3 = $Transaction3->getMockTransaction("THIRD");
	    //var_dump($Transaction3);die();

	    //This one isn't:
	    $Transaction4 = $Transaction4->getMockTransaction("FOURTH");
	    //var_dump($Transaction4);die("<!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! FOURTH");

	    $Manifest = new MigratePosts\Manifest;
	    $Manifest->manifest = [$Transaction1, $Transaction2, $Transaction3, $Transaction4];

	    //When the getNextTransaction method is called 3 times
	    $nextTransaction = $Manifest->getNextTransaction();
	    $nextTransaction = $Manifest->getNextTransaction();
	    $nextTransaction = $Manifest->getNextTransaction();

	    $this->assertEquals($Transaction4, $nextTransaction);
    }
}