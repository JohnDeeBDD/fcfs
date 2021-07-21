<?php

namespace FCFS;

class UserClickList{

	public function returnArrayOfUserNames($postID){
		return [];
	}

	public function returnArrayOfUserIDs($postID){
		//find metadata that looks like "fcfs-xxx" where xxx is a username
		$data = get_post_meta($postID);
		$userIDs = array();	
		foreach($data as $key => $val){
			//Looking for a "dash in the 5th position. i.e. "fcfs-123" where 123 is the userID
			$dash = strpos( $key, "-");
			if($dash){	
		    //add each user id to the array
		    	$substring  =  substr( $key, $dash+1);
		    	array_push($userIDs, $substring);
		    }	
		}
		return $userIDs;
	}
}