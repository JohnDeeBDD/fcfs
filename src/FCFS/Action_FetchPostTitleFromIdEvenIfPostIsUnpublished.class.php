<?php

namespace FCFS;

class Action_FetchPostTitleFromIdEvenIfPostIsUnpublished extends Abstract_API_Action{

	public $namespace = "fcfs/v1";
	public $actionName = "fetch-post-title-from-id-even-if-post-is-unpublished";
	public $capability = 'activate_plugins';

	public function getActionUiHtml($args){}

	public function doAction($request){
		if(!(isset($_REQUEST['postID']))){
			return "Error: No post id";
		}
		$postID = $_REQUEST['postID'];
		if(!(is_numeric ( $postID ))){
			return "Error: something is wrong with the input";
		}
		if(!($this->doesPostExist($postID))){
			return "Error: post does not exist";
		}
		$title = get_the_title( $postID );
		return $title;
	}

	public function doesPostExist($postID){
		//an existing post will have some kind of post status that is a string
		return is_string( get_post_status($postID) );
	}

	public function returnJS(){

		$EnterAPostOrPageID = __("Enter a post or page ID.", "fcfs");
		$namespace = $this->namespace;
		$actionName = $this->actionName;
		$Api = "/wp-json/$namespace/$actionName";
		$output =
			<<<OUTPUT
<script>
console.log("Action_FetchPostTitleFromIdEvenIfPostIsUnpublished");
jQuery(document).ready(function() {
    if (jQuery("#migrate-posts-postid-submit-button").length){
        MigratePosts.SetupStrings();
        jQuery("#contestPostID").keyup(function() {
            MigratePosts.validatePostIdAfterKeypress();
        });
        MigratePosts.ajaxSiteWhenIdNumberInInputBoxIsStableFor1Second();
        jQuery("#migrate-posts-postid-submit-button").click(function(){
          //  jQuery('#migrate-posts-form').attr('action', '/wp-admin/admin.php?page=migrate-posts&action=migrate-posts-designate-post-as-contest');
            jQuery("#migrate-posts-form").submit(); // Submit
        });
        MigratePosts.validatePostIdAfterKeypress();
    }
});

const MigratePosts = {};
MigratePosts.SetupStrings = function(){
    console.log("MigratePosts.SetupStrings()");
    jQuery("#migrate-posts-enter-a-post-or-page-id-description").text("$EnterAPostOrPageID");
}

var originalColor = jQuery("#migrate-posts-p-enter-a-post-or-page-id").css("color");
MigratePosts.updateDataOnChange = function (){
    var DeveloperContestArrayOfDataIDs = 123;
}
MigratePosts.contestDataAjaxUpdate = function(inputDate){
    parseDate = jQuery(inputDate).val();
    if (Date.parse(parseDate)) {
        console.log("MigratePosts.contestDataAjaxUpdate valid!! " + parseDate);
    } else {
        console.log("MigratePosts.contestDataAjaxUpdate NOT valid " + parseDate);
    }
}

MigratePosts.ajaxSiteWhenIdNumberInInputBoxIsStableFor1Second = function(){
    console.log("MigratePosts.ajaxSiteWhenIdNumberInInputBoxIsStableFor1Second");
    //We dont want to AJAX the site after every keypress, but only after it's been there for a whole second
    // Get the input box
    let input = document.getElementById('contestPostID');

    // Init a timeout variable to be used below
    let timeout = null;

    // Listen for keystroke events
    input.addEventListener('keyup', function (e) {
        // Clear the timeout if it has already been set.
        // This will prevent the previous task from executing
        // if it has been less than <MILLISECONDS>
        clearTimeout(timeout);

        // Make a new timeout set to go off in 1000ms (1 second)
        timeout = setTimeout(function () {
            var postID = jQuery("#contestPostID").val();
            if(MigratePosts.validatePostIdTextField(postID)){
                console.log("AjaxSiteWhenIdNumberInInputBoxIsStableFor1Second post" + postID);
                MigratePosts.fetchPostTitleAjax(postID);
            }
        }, 1000);
    });
}
MigratePosts.fetchPostTitleAjax = function(postID){
    jQuery.ajax({
        url: "/wp-json/$namespace/$actionName",
        data: {
            'postID': postID,
            '_wpnonce': wpApiSettings.nonce,
        },
        method: "POST",
        success: function(data) {
            fetchPostTitleResponse = String(data);
            if(data == "Error: post does not exist"){
                console.log('fetchPostTitleAjax');
                MigratePosts.setDescriptionMessageToDefault();
            }else{
                console.log("data coming in " + data);
                //jQuery("#migrate-posts-preview-and-submit-row").show();
                jQuery("#migrate-posts-preview-post-about-to-be-selected").text(fetchPostTitleResponse);
            }
        },
        error: function(errorThrown) {
            fetchPostTitleResponse = JSON.stringify(errorThrown);
            console.log(errorThrown);
        }
    });
}

MigratePosts.IsItAValidPostIdEntry = function(){
    console.log("MigratePosts.IsItAValidPostIdEntry");
    //This function checks to see that the entry is a number or blank
    var postID = jQuery("#contestPostID").val();
    if(Math.floor(postID) == postID && jQuery.isNumeric(postID)){
        return true;
    }else{
        console.log("MigratePosts.IsItAValidPostIdEntry: return false");
        return false;
    }
}

MigratePosts.setDescriptionMessageToDefault = function(){
    console.log("MigratePosts.setDescriptionMessageToDefault");
    //jQuery("#migrate-posts-p-enter-a-post-or-page-id").text(MigratePosts.stringEnterAPostOrPageID);
    //        jQuery("#migrate-posts-p-enter-a-post-or-page-id").html(MigratePosts.stringEnterOnlyAnInteger);
    jQuery("#migrate-posts-p-enter-a-post-or-page-id").css("color", originalColor);
    jQuery("#migrate-posts-postid-submit-button").prop("disabled",false);
}
MigratePosts.validatePostIdAfterKeypress = function(){
    jQuery("#migrate-posts-preview-post-about-to-be-selected").text("");
    var postID = jQuery("#contestPostID").val();

    if(postID == ""){
       // console.log("validatePostIdAfterKeypress");
        jQuery("#migrate-posts-postid-submit-button").prop("disabled",true);
        return;
    }
    if(MigratePosts.IsItAValidPostIdEntry() || (postID == "")){
        //console.log("IsItAValidPostIdEntry 90 post is valid");
        MigratePosts.setDescriptionMessageToDefault();
    }else{
        console.log("post is NOT valid!!!");
        //console.log(MigratePosts.stringEnterOnlyAnInteger);
        
        //jQuery("#migrate-posts-p-enter-a-post-or-page-id").html(MigratePosts.stringEnterOnlyAnInteger);
        jQuery("#migrate-posts-p-enter-a-post-or-page-id").html("MY BALLS!!!");
        jQuery("#migrate-posts-p-enter-a-post-or-page-id").css("color", "red");
        jQuery("#migrate-posts-postid-submit-button").prop("disabled",true);
    }
}
MigratePosts.validatePostIdTextField = function(postID){
    if(postID == ""){
        return false;
    }
    if(Math.floor(postID) == postID && jQuery.isNumeric(postID)){
        return true;
    }
    return false;
}
MigratePosts.lastAjaxSent = null;
</script>
OUTPUT;
		return $output;
	}
}
