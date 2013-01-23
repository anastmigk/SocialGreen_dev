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
    	
    }


}

