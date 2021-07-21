<?php

namespace FCFS;

class Page_FCFS{

    /*
     public function enqueueSettingsPageJS(){
        wp_register_script(
            'migrate-posts-settings-page',
            plugin_dir_url(__FILE__) . 'settings-page.js', // here is the JS file
            ['jquery', 'wp-api'],
            '1.0',
            true
        );
        wp_enqueue_script('migrate-posts-settings-page');
    }
    */

    public function enable() {
	        \add_menu_page(  'FCFS', 'FCFS','edit_posts', "fcfs", array($this, "renderPage"));
    }

    public function renderPage(){
	    $firstComeFirstServe = __("First Come First Serve", "fcfs");
        $output =
<<<OUTPUT
<div id = "main">
	<div id = "wpbody-content">
		<div class = "wrap">
		<h1>
            $firstComeFirstServe
        </h1>
        <form method = "post" action = "/wp-admin/tools.php?page=fcfs" >
			    <table class="form-table" role="presentation">
                    <tr><td>Post ID</td><td><input type = "text" name = "fcfs-postID" /></td></tr>
                    <tr><td></td><td><input type = "submit" name = "fcfs-submit-button" id = "fcfs-submit-button" /></td></tr>
			    	<tr><td><a target = "BLANK" href = "/wp-content/plugins/fcfs/tests/_output/report.html">Test Results</a></td></tr>
			    </table>
		</form>
        
		</div><!-- end: .main -->
	</div><!-- end: .wpbody-content -->
</div><!-- end: .wrap -->
OUTPUT;
        echo $output;
    }
}