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

\add_action("admin_menu", [new Page_FCFS, "addMenuPage"]);

\add_action ('rest_api_init', [new API_ClickList, 'doRegisterRoutes']);