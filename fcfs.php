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
require_once (plugin_dir_path(__FILE__). 'src/FCFS/FCFS_CPT.php');

\add_action("admin_menu", [new Page_FCFS, "enable"]);

\add_action ('rest_api_init', [new API_ClickList, 'doRegisterRoutes']);
\add_action ('rest_api_init', [new API_SettingsPage, 'doRegisterRoutes']);
\add_shortcode('FCFS', [new Shortcode_FCFS, 'doReturnShortcode']);

$Action = new Action_MakeFCFS();
$Action->enable();

if ( isset($_GET['post_type']) && ($_GET['post_type'] == "fcfs") ) {
	global $pagenow;
	if($pagenow == "edit.php"){
		// add the action
		add_action( 'admin_enqueue_scripts', 'FCFS\action_admin_enqueue_scripts', 10, 1 );
	}
}

function myguten_enqueue() {
	wp_enqueue_script(
		'wp-fcfs-fe',
		plugins_url( '/src/FCFS/wp-fcfs.js', __FILE__ )
	);
}
add_action( 'wp_enqueue_scripts', 'FCFS\myguten_enqueue' );
// define the admin_enqueue_scripts callback
function action_admin_enqueue_scripts( $array ) {
	wp_enqueue_script(
		'wp-fcfs',
		plugins_url( '/src/FCFS/settings-page.js', __FILE__ ),
		['wp-api', 'jquery']
	);
	wp_localize_script( "wp-fcfs", "FCFS", ["arrayOfFCFSPostIDs" => [1,2,3,4]]);
	wp_enqueue_style( "wp-fcfs", plugins_url( '/src/FCFS/settings-page.css', __FILE__ ) );
};




if(isset($_GET['fcfs-reset'])){
	//die("!!");
	add_action("init", 'FCFS\doReset');
}

function doReset(){
	//die("2");
	$Action = new \FCFS\Action_MakeFCFS;
	$Action->makeFCFS(1557);
}

        
if(isset($_GET['doit'])){
	//die("!!");
	add_action("init", 'FCFS\doIt');
}

function doIt(){
	//die("doit");
        //$Action = new Action_MakeFCFS;
        //$Action->makeFCFS(1555);
        $Action2 = new Action_VisitFCFS_Page;
        $time = time();
        $Action2->doAction(2, 1555, $time);
}