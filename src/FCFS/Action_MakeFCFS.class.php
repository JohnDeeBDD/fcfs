<?php 

namespace FCFS;

class Action_MakeFCFS{

	public $postID;
    
    public function doMakeFCFS($postID = null){
    	if(!(isset($this->postID))){
	        $this->postID = $postID;
	    }
        \update_post_meta( ($this->postID), "fcfs", "open" );
	    return TRUE;
    }

    public function enable(){
    	if (isset($_POST['fcfs-makeFCFSPostID'])){
    		$this->postID = $_POST['fcfs-makeFCFSPostID'];
		    add_action("init", [$this, "checkSecurityNonce"]);
		    add_action("init", [$this, "doMakeFCFS" ]);
	    }
    }

    public function checkSecurityNonce(){
    	//This function is a one way trip. Either the nonce is there, or it dies.
    	if (isset($_POST['fcfs-makeFCFSNonce'])){
    		if (\wp_verify_nonce( $_POST['fcfs-makeFCFSNonce'], 'makeFCFS' ) ) {
			    return;
		    }
    	}
    	//This should never happen:
	    die("Bad user. Don't be doin that.");
    }
}