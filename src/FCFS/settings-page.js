/*global jQuery/*
/*global FCFS*/
jQuery(document).ready(function(){
    console.log("FCFS settings-page.js");
    FCFS.doAddMakeFCFSForm();
    var $visibleIDs = FCFS.gatherIDsVisableInEditor();
    if( $visibleIDs.length > 0 ){
        for (let i = 0; i < $visibleIDs.length; i++){
            $postIDTitle = FCFS.doAJAX_FetchPostTitle($visibleIDs[i]);
        }
    }
    jQuery('.post-type-fcfs #the-list').show();
    
    //create a loop to go over each one and replace the title
    //there may be a "flash" of the numerals... explore display:none the numbers is CSS if possible
    //would like to avoid "flashing" the numbers

    FCFS.doChangeAnchorLinkInHoverEditLinks();
    
});

FCFS.doAJAX_FetchPostTitle = function($postID){
    var URL = "/wp-json/wp/v2/posts/" + $postID;
    jQuery.ajax({
//        url: "/wp-json/fcfs/v1/settings-page",

        url: URL,
        data: {
            //'make-fcfs-post-id': postID,
            '_wpnonce': wpApiSettings.nonce,
        },
        method: "POST",
        success: function(data) {
            jQuery('.column-title .row-title').each(function(){
                if( jQuery(this).text() == $postID ) {
                    var origID = jQuery(this).closest('.entry').find( '.check-column :checkbox' ).val();
                    var hrefLink = jQuery(this).closest('.column-title').find( '.row-actions .edit a' ).attr('href');
                    hrefLink = hrefLink.replace('post='+origID,'post='+$postID);
                    jQuery(this).html(data.title.raw);
                    jQuery(this).closest('.column-title').find( '.row-actions .edit a' ).attr('href', hrefLink);
                }
            });
        },
        error: function(errorThrown) {
            fetchPostTitleResponse = JSON.stringify(errorThrown);
            console.log(errorThrown);
        }
    });
}

FCFS.doAddMakeFCFSForm = function(){
    var formHtml = "<form method = 'post'>" +
        "<input type ='text' name = 'fcfs-makeFCFSPostID'id = 'fcfs-makeFCFSPostID' /><br />" +
        "<input type = 'submit' value = 'Add New'  name = 'fcfs-makefcfs-submit-button' id = 'fcfs-makefcfs-submit-button' />" +
        "<a class = 'page-title-action'>Add New</a></form>";
    jQuery(".wp-header-end").after(formHtml);
}

FCFS.gatherIDsVisableInEditor = function(){
    var $arrayOfPostIDs = [];
    jQuery('.column-title .row-title').each(function(){
        $arrayOfPostIDs.push(jQuery(this).html());
    });
    return $arrayOfPostIDs;
}

FCFS.getPostTitlesFromIds = function($arrayOfPostIDs){
    
    return $arrayOfTitles;
}

FCFS.makeTitlesLegible = function($arrayOfTitles, $arrayOfPostIDs){
//use jQuery to make the titles vis
    
}

FCFS.doChangeAnchorLinkInHoverEditLinks = function(){

}
//http://3.129.13.214/wp-admin/post.php?post=1603&action=edit
//http://3.129.13.214/wp-admin/post.php?post=1555&action=edit