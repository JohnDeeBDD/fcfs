<?php

namespace FCFS;

class Action_OpenCloseFCFS{


        public function doMakeFCFS_postOpen($postID){
            $data = ["status" => "open"];
            update_post_meta($postID, "fcfs", $data);
        }
        
        public function doMakeFCFS_postClosed($postID){
            $data = ["status" => "closed"];
            update_post_meta($postID, "fcfs", $data);
        }
}