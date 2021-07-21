<?php

class ActionOpenCloseFCFSTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @test
	 * it should be instantialble
	 */
	public function itShouldBeInstantiable(){
		$Action = new \FCFS\Action_MakeFCFS;
	}
}