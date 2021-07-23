<?php

namespace FCFS;

class API_SettingsPage{

    public $namespace = "fcfs/v1";
    public $actionName = "settings-page";
    public $capability = 'activate_plugins';
    public $methods = ['POST'];

    public function doAction($args){
	    ob_start();
	    var_dump($args);
	    $result = ob_get_clean();
		return $result;
    }

    public function doRegisterRoutes(){
        register_rest_route(
            $this->namespace,
            $this->actionName,
            array(
                'methods' => ($this->methods),
                'callback' => function () {
                    return ($this->doAction($_REQUEST));
                },
                'permission_callback' => function () {
                    $capability = $this->capability;
                    if (!(current_user_can($capability))) {
                        return FALSE;
                    }
                    return TRUE;
                },
                'validate_callback' => function () {
					return TRUE;
                }
            )
        );
    }
}