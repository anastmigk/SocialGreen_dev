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
    	//$form = new Application_Model_FormLogin();
    	//$this->view->loginForm = $form;  

    	//$form2 = new Application_Model_FormRegister();
    	//$this->view->registerForm = $form2;
    	
    }

    public function submitContactFormAction()
    {
        //$this->_helper->viewRenderer->setNoRender();
        //$this->_helper->getHelper("layout")->disableLayout();
    	
        $f = new Application_Form_ContactForm();
        $f->isValid($this->_getAllParams());
        $json = $f->getMessages();
        
        header("Content-type: application/json");
        //echo Zend_Json::encode($json);
        echo "TEST";
    }

    public function submitContactAction()
    {
        //Action that just displays the Contact form.. this is used to display form in each page..
    	$contactForm = new Application_Form_ContactForm();
    	$this->view->contactForm = $contactForm;
    }


}





