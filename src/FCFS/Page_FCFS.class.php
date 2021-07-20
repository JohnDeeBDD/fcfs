<?php

namespace FCFS;

class Page_FCFS{

    public function enable(){
        //this command puts the settings page on the WordPress admin menu:
	    //\add_menu_page(  'FCFS', 'fcfs','edit_posts', "fcfs", array($this, "renderPage"));
         add_action( 'admin_menu', array($this, 'addMenuPage' ));
   //     add_action("admin_enqueue_scripts", [$this, "enqueueSettingsPageJS"]);
    }

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

    public function addMenuPage($x) {
	        \add_menu_page(  'FCFS', 'FCFS','edit_posts', "fcfs", array($this, "renderPage"));
    }

    private function returnContentView(){
    	$UserClickList = new UserClickList();
		return $UserClickList->returnHTML();
    }


    public function renderPage(){
        $contentSection = $this->returnContentView();
	    $firstComeFirstServe = __("First Come First Serve", "fcfs");
        $output =
<<<OUTPUT
<div id = "main">
	<div id = "wpbody-content">
		<div class = "wrap">
		<h1>
            $firstComeFirstServe
        </h1>
        <form method = "post" action = "/wp-admin/tools.php?page=migrate-posts" >
			    <table class="form-table" role="presentation">
                    $contentSection
			    </table>
		</form>
        
		</div><!-- end: .main -->
	</div><!-- end: .wpbody-content -->
</div><!-- end: .wrap -->
OUTPUT;
        echo $output;
    }
}