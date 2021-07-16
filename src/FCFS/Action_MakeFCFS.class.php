<?php 

namespace FCFS;

class Action_MakeFCFS{
    
    public function makeFCFS($postID){
        
        add_post_meta( $postID, "fcfs", "boomshakalaka", true );
        
    
    }
    
}