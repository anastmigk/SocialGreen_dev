<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Welcome";
    	$this->view->title = $title;
    }

    public function indexAction()
    {
        // action body
    	$form = new Application_Model_FormLogin();
    	$this->view->loginForm = $form;  

    	$form2 = new Application_Model_FormRegister();
    	$this->view->registerForm = $form2;
    }


}

