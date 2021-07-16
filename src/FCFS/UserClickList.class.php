<?php

namespace FCFS;

class UserClickList{
//public function enableShortcode_FCFS(){}

	public function doReturnShortcode_FCFS(){
		
		return "1. Someuser";	
	}

	public function returnHTML(){
		$output = "<ul>";
		//var_dump($this->userList);die();
		
		if ($this->userList == []){
			$output = $output . "<li>No users yet!</li>";
		}
		foreach($this->userList as $userID){
			//echo($userID . "\n\r");
			$user = get_user_by( 'id', $userID );
			//var_dump($user->user_nicename);die();
    		$userLogin = $user->user_login;
			
			$output = $output . "<li>" . $userLogin . "</li>";
		}
		$output = $output . "</ul>";
		return $output;
	}
	
	public function getUserList(){
		return $this->userList;
		
	}
	
	public function stashInDB($postID){
		$optionName = "fcfs-clicklist-" . $postID;
		$data = $this->userList;
	    update_option($optionName, $data);
	}
	
	public function fetchFromDB($postID){
		$optionName = "fcfs-clicklist-" . $postID;
		$this->userList = get_option( $optionName, true);
	}
	
	public $userList = [];
	public function setUserList($userList){
		//var_dump($userList); die("xxx");
		$this->userList = $userList;	
	}
	

}