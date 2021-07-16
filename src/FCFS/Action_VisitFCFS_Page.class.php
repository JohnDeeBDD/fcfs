<?php 

namespace FCFS;

class Action_VisitFCFS_Page{
    

        public function doAction($userID, $postID, $time){
            $key = "fcfs-" . $userID;
            add_post_meta( $postID, $key, $time);
        }

}