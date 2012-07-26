<?php

class FacebookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $user = Josh_Facebook::getUser();
        if ($user) {
            try {
            $user_info = FB_Facebook::api("/me");
            $this->view->assign("data",$user_info);
            } catch (FacebookApiException $e) {
                print($e);
           	    $user = null;
                $this->view->assign("data","khong co");
            }
        }
    }

    public function loginAction()
    {
        // action body
        $loginUrl = $facebook->getLoginUrl(array(
            'scope' => 'publish_stream,publish_actions,manage_pages',
            'redirect_uri' => 'http://localhost/facebook/index.php'
        )); 
    }
    
    public function logoutAction()
    {
        // action body
        $logoutUrl = $facebook->getLogoutUrl(array(
	       'next' => 'http://localhost/facebook/index.php'
        ));
    }
    
    public function postAction()
    {
        // action body
    }
}

