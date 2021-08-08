<?php

namespace FCFS;

class Shortcode_FCFS{
    
    public function doReturnShortcode(){
        global $post;
        $postID = $post->ID;
        $Action = new Action_VisitFCFS_Page;
        //die("doReturnShortcode");
        $Action->listenForVisit();
        $output = $this->returnHTML($postID);
        //$output = $output . $this->returnJS($postID);
        return $output;
    }
    
    public function returnJS($postID){
        $output = <<<OUTPUT
<script>
//alert("JS HERE! post $postID");
</script>
OUTPUT;
        return $output;
    }
    
    public function returnHTML($postID){
        $List = new UserClickList();
        $names = $List->returnArrayOfUserNames($postID);
        //var_dump($names);die(" names");
        if($names == "ERROR: Not an FCFS post"){
        	return;
        }
        if($names == "No users yet"){
            return $names;
        }
        $output = "<ol>";
        foreach($names as $name){
            $output = $output . "<li>" . $name . "</li>";
        }
        $output = $output . "</ol>";
        return $output;
    }
    
}