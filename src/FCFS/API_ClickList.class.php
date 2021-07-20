<?php

namespace FCFS;

class API_ClickList{

    public $namespace = "fcfs/v1";
    public $actionName = "clicklist";
    public $capability = 'exist';
    public $methods = ['GET'];

    public function doAction($args){
        //At this point, there will always be a post ID, however there may not be a valid post
        $postID = $_REQUEST['post-id'];
        $List = new UserClickList;
        $status = $List->fetchFromDB($postID);
        if ( \is_wp_error( $status )) {
            return $status;
        }
            
        return ($List->doReturnListJSON());
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
                    if(isset($_REQUEST['post-id']) && (is_numeric($_REQUEST['post-id']))){
                        return TRUE;
                     }else{
                        return FALSE;
                    }
                }
            )
        );
    }
}