<?php

namespace FCFS;

class UserClickList{
//This object contains the code for the list itself

	public function returnListArray($postID){
		//find metadata that looks like "fcfs-xxx" where xxx is a username
		$data = get_post_meta($postID);
		//var_dump($data);
		$userIDs = array();	
		foreach($data as $key => $val){
			//$metaData[0] == key "fcfs-123" ??? i think
			//var_dump ($metaDataItem[0]); die();
			//Looking for a "dash in the 5th position]
			$dash = strpos( $key, "-");
			if($dash){	
		    //add each user id to the array
		    	$substring  =  substr( $key, $dash+1);
		    	array_push($userIDs, $substring);
		    }	
		}

		//print_r($userIDs);die();
		return $userIDs;
	}

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