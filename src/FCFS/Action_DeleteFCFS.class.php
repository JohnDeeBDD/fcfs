<?php

namespace FCFS;

class Action_DeleteFCFS{

    public function doDeleteSomeKindOfPost($postID){
    	//die("POST ID GIVEN: $postID");
        $postType = get_post_type($postID);
        if($postType == "fcfs"){
        	//die("doDel $postID");
            $this->doDeleteFCFS_CPT($postID);
        }else{
        	//die("else");
	        \update_post_meta( $postID, "fcfs", "open" );
	        $result = \get_post_meta($postID, 'fcfs', true);
	        //var_dump($result);die();
            if((get_post_meta($postID, 'fcfs'))){
            	//die("do");
                $this->doDeleteFCFSenabledPost($postID);
            }
        }
    }

    public function doDeleteFCFSenabledPost($postID){
    	//die("doDeleteFCFSenabledPost $postID");
        $FCFS_postID = get_the_title($postID);
        wp_delete_post($FCFS_postID);
    }
    
    public function doDeleteFCFS_CPT($FCFS_PostID){
        //delete_post_meta( $postID, "fcfs");
        //get post meta
        //loop through it
        //rid of all meta data that starts with "FCFS" in $postID "fcfs-4" "fcfs-7" fcfs-{userID}
    }

}