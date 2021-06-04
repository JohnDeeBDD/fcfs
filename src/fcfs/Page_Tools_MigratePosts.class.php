<?php

namespace MigratePosts;

class Page_Tools_MigratePosts{

    public function enable(){
        //this command puts the settings page on the WordPress admin menu:
        add_action( 'admin_menu', array($this, 'addMenuPage' ));
        add_action("admin_enqueue_scripts", [$this, "enqueueSettingsPageJS"]);
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
        $Auth = new Auth;
        if ( current_user_can( ($Auth->requiredCapabilityToUsePlugin))) {
	        add_submenu_page( 'tools.php', 'Migrate Posts', 'Migrate Posts',
		        'edit_posts', "migrate-posts", array($this, "renderPage"));
        }
    }

    public function returnDevelopmentSectionHtml(){
        $Constants = new Constants;
        $Site1Url = ($Constants->site1Url) . "/wp-admin/edit.php";
        $Site2Url = ($Constants->site2Url) . "/wp-admin/edit.php";

        $Manifest = get_option("migrate-posts-manifest");
        if($Manifest == false){
            $Manifest = new Manifest();
        }
        $manifest = $Manifest->returnHTML();
        $resetTimes = get_option("resetter");

        $userID = get_current_user_id();
        $data = get_user_meta($userID);
        ob_start();
        var_dump($data);
        $data = ob_get_clean();


        $output = <<<OUTPUT
<h2>DEVELOPMENT</h2>
<form method = "post">
<input type = 'text' name  = 'new_admin_email'/>
<input type = 'submit' />
</form>
        Rest Times: $resetTimes <br />
        Manifest: $manifest<br />
        User Meta: $data<br />
        <br />
        <a href = "/wp-admin/tools.php?page=migrate-posts&next=true">Next transaction</a><br />
        <a href = "$Site1Url" target = "_blank">Site1</a><br />
        <a href = "$Site2Url" target = "_blank">Site2</a><br />
        <a href = "/wp-admin/tools.php?page=migrate-posts&migrate-posts-reset=true">Reset</a><br />
        <br />
        <a target = " _blank" href = "/wp-content/plugins/migrate-posts/tests/_output/report.html">Test Results</a>
<hr />
OUTPUT;
        return $output;

    }


    public function renderPage(){
        $developmentSection = $this->returnDevelopmentSectionHtml();
        $contentSection = $this->returnContentView();
        $output =
<<<OUTPUT
<script>
    console.log("Page_Tools_MigratePosts.class.php line 80");
    var MigratePosts = {};
</script>
<div id = "main">
	<div id = "wpbody-content">
		<div class = "wrap">
		<h1>
            Migrate Posts
        </h1>
        <form method = "post" action = "/wp-admin/tools.php?page=migrate-posts" >
			    <table class="form-table" role="presentation">
                    $contentSection
			    </table>
		</form>
        $developmentSection
		</div><!-- end: .main -->
	</div><!-- end: .wpbody-content -->
</div><!-- end: .wrap -->
OUTPUT;
        echo $output;
    }

    private function returnYouAreNowConnectedViewHTML(){
        $output = <<<OUTPUT
<h1>MigratePosts.com Success!</h1>
You are now connected.<br /><br/>
<a href = '/wp-admin/tools.php?page=migrate-posts'>CLICK TO CONTINUE</a>
OUTPUT;
        return $output;
    }


    public function returnContentView(){
        //die("returnContentView");
        if(isset($_GET['migrate-posts-activation-nonce'])){
            $userID = get_current_user_id();
            $status = Auth::getUserConnectionStatus($userID);
            if(Auth::getUserConnectionStatus($userID) == "EMAIL PENDING"){
                $bool = (Auth::isEmailNonceValid($userID, $_GET['migrate-posts-activation-nonce']));
                //echo("bool $bool");die();
                if(Auth::isEmailNonceValid($userID, $_GET['migrate-posts-activation-nonce'])){
                    //good nonce
                    Auth::setIncomingNonce($userID);
                    echo($this->returnYouAreNowConnectedViewHTML());
                    die();
                }else{
                    die("SOMETHING IS WRONG. - 1");
                }
            }
            echo ("status: $status");
            die("SOMETHING IS WRONG. - 2");
        }
    	$output = "";
        $output = $output .
            <<<OUTPUT
<tr class = "migrate-posts-connected">
	<th scope = "row">
		<label for="contestPostID">Post or Page ID</label>
	</th>
	<td>
		<input type = "text" name = "contestPostID" id = "contestPostID" size = "5" />
		<p class = "description" id = "migrate-posts-enter-a-post-or-page-id-description" >Enter a post or page ID.</p>
		<span id = "migrate-posts-error-post-not-found" style = "display:none;">Error: post ID not found</span>
	</td>
</tr>
<tr id = "migrate-posts-preview-and-submit-row" class = "migrate-posts-connected">
	<th scope = "row">
		<label for="">
			<div id = "migrate-posts-postid-submit-button-div">
				<input type = "button" class="button button-primary" id = "migrate-posts-postid-submit-button" value = "Submit" />
			</div><!-- END: #migrate-posts-postid-submit-button-div-->
		</label>
	</th>
	<td>
		<p id = "migrate-posts-preview-post-about-to-be-selected" ></p>
	</td>
</tr>
OUTPUT;

	    $UI_DoMigratePostButton = new UI_DoMigratePostButton;
	    $output = $output . $UI_DoMigratePostButton->returnHtml();

        $UI_SendConnectionEmail = new UI_SendConnectionEmail();
        $output = $output . $UI_SendConnectionEmail->returnHtml();
        //return "something!!!";
        return $output;
    }
}