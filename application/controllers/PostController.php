<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $postManger = new Application_Model_DbManager_PostManager();
        $result = $postManger->findByPage(1);
        $this->view->post =  $result;
    }


}

