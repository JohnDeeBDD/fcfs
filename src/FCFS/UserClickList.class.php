<?php

namespace FCFS;

class UserClickList{
//This object contains the code for the list itself

	public function doReturnListJSON(){
		return "1. Someuser";	
	}

	public function returnHTML(){
		$output = "<ul>";	
		if ($this->userList == []){
			$output = $output . "<li>No users yet!</li>";
		}
		foreach($this->userList as $userID){
			//echo($userID . "\n\r");
			$user = get_user_by( 'id', $userID );
	   		$userLogin = $user->user_login;		
			$output = $output . "<li>" . $userLogin . "</li>";
		}
		$output = $output . "</ul>";
		return $output;
	}
	
	public function getUserList(){
		return $this->userList;
	}
		
	public $userList = [];

}