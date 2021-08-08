<?php
/*
Plugin Name: First Come First Served
Plugin URI: https://wpdev.tv
Description: See which users visit a page, and in which order
Version: 1.0
Author: johndee
Author URI: https://generalchicken.guru
*/

namespace FCFS;


//die("FCFS");

require_once (plugin_dir_path(__FILE__). 'src/FCFS/autoloader.php');
//require_once (plugin_dir_path(__FILE__). 'src/FCFS/FCFS_CPT.php');


$SettingsPage = new Page_FCFS();
$SettingsPage->enable();



\add_action ('rest_api_init', [new API_ClickList, 'doRegisterRoutes']);
\add_action ('rest_api_init', [new API_SettingsPage, 'doRegisterRoutes']);
\add_shortcode('FCFS', [new Shortcode_FCFS, 'doReturnShortcode']);
\add_action( 'delete_post', [new Action_DeleteFCFS, 'doDeleteSomeKindOfPost']);

$Action = new Action_MakeFCFS();
$Action->enable();

//\add_action('wp', [new Action_VisitFCFS_Page, "listenForVisit"] );


//DEVELOPMENT::

if(isset($_GET['doit'])){
	//die("!!");
	add_action("init", 'FCFS\doIt');
}

function doIt(){
	//die("doit");
}