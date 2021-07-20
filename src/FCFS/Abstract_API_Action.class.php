<?php

namespace FCFS;

abstract class Abstract_API_Action{

    /* This abstract class is used for opening up WordPress API routes, and mapping them to our
     * classes.
     */

    public $actionName;
    public $capability = "exist";
    public $methods = ['POST', 'GET'];
    public $namespace = "fcfs/v1";

    abstract public function doAction($args);

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
                    $cap = $this->capability;
                    if (!(current_user_can($cap))) {
                        return FALSE;
                    }
                    return TRUE;
                },
            )
        );
    }
}