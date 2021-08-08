<?php 

namespace FCFS;

class Action_VisitFCFS_Page{

	public function listenForVisit(){

		global $post;
		//Check to see if the user is on a "singular" post. If it's a blog roll, the
		//"click" doesn't count:
		if(\is_singular()){
			$postID = $post->ID;
			$meta = get_post_meta( $postID, "fcfs", true );
			//I do not understand WHY this meta returns "" when it's empty but
			//on line 25 the same function returns [] .
			//var_dump($meta);die("gonna leave this in production in case someone can anser!");
			if($meta == ""){
				return false;
			}
			if($meta == "open"){

				$userID = get_current_user_id();
				$key = "fcfs-" . $userID;
				$meta = get_post_meta( $postID, $key );
				//var_dump($meta);die("gonna leave this in production in case someone can anser!");
				if($meta == []){
					$time = time();
					$this->doAction($userID, $postID, $time);
					return true;
				}else{
					//the user has already registered a click, so we'll just return here...
				}
			}
			return true;
		}
		return false;
	}


        public function doAction($userID, $postID, $time){
            $key = "fcfs-" . $userID;
            add_post_meta( $postID, $key, $time);
        }

}