<?php

class TransactionTest extends \Codeception\TestCase\WPTestCase{

    /**
     * @test
     * it should ne instantiable
    */
    public function itShouldBeInstantiable(){
        $Transaction = new \MigratePosts\Transaction();
        $classProperties = ["postID", "directive", "destinationURL", "originationURL", "status"];
        foreach ($classProperties as $property){
            $this->assertTrue(property_exists($Transaction, $property), "Error. Property $property does not exist.");
        }
    }

	/**
	 * @test
	 * is should return the "first" transaction
	 */
	public function itShouldReturnTheFirstTransaction(){
		$Constants = new \MigratePosts\Constants();
		$Transaction1 = new \MigratePosts\Transaction;
		$Transaction1->destinationURL= $Constants->site2Url;
		$Transaction1->postID = 3;
		$Transaction1->directive = "send";
		$Transaction1->status = "NOTSTARTED";
		$returnedTransaction = $Transaction1->getMockTransaction("FIRST");
		$this->assertEquals($Transaction1, $returnedTransaction);
	}
}