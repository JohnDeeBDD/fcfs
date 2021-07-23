<?php

namespace FCFS;

class UserClickList{

	public function returnArrayOfUserNames($postID){
		$userNames = array();
		$IDs = $this->returnArrayOfUserIDs($postID);
		if(!(get_post_meta($postID, "fcfs"))){
			return "ERROR: Not an FCFS post";
		}
		if ( count($IDs) == 0){
			return "No users yet";
		}
		else {
			
			foreach($IDs as $id){
				//$id = intval($id);
				$user_info = \get_userdata($id);
    			array_push($userNames, $user_info->user_login);
			}
			return $userNames;
			
		}
		//die();
		
		
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