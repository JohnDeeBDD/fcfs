<?php 

namespace FCFS;

class Action_MakeFCFS{

	private $postID;
    
    public function makeFCFS($postID = null){
    	if($postID === null){
    		$postID = $this->postID;
		}
        \update_post_meta( $postID, "fcfs", "open" );
	    $id = wp_insert_post(array(
		    'post_title'=>$postID,
		    'post_type'=>'fcfs'
	    ));
    }

    public function enable(){
    	if (isset($_POST['fcfs-makeFCFSPostID'])){
    		$this->postID = $_POST['fcfs-makeFCFSPostID'];
    		add_action("init", [$this, "makeFCFS"]);
	    }
    }
}