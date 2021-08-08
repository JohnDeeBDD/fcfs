/*global jQuery/*
/*global FCFS*/
jQuery(document).ready(function () {
    console.log("FCFS settings-page.js");
});

FCFS.doAJAX_FetchPostTitle = function (postID) {
    var URL = "/wp-json/wp/v2/posts/" + postID;
    jQuery.ajax({
        url: URL,
        data: {
            '_wpnonce': wpApiSettings.nonce,
        },
        method: "POST",
        success: function (data) {
            FCFS.changeEditLinks(data, postID);
        },
        error: function (errorThrown) {
            fetchPostTitleResponse = JSON.stringify(errorThrown);
            console.log(errorThrown);
        }
    });
}
