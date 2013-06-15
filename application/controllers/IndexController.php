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
    	
    	$tweetDB = new Application_Model_DbTable_Tweets();
    	$select = $tweetDB->select();
    	$select->from($tweetDB);
	 	$tweetsResults = $tweetDB->fetchAll($select);
	 	$tempTweets = array();
	 	foreach ($tweetsResults as $tweet){
	 		$tempTweets[] = $tweet['tweet'];
	 	}
	 	shuffle($tempTweets);
	 	$this->view->tweet = $tempTweets[0];
	 	$this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function submitContactFormAction()
    {
        $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    $form = new Application_Form_QuizForm();
	    	
	    $form->isValidPartial($this->_getAllParams());
	    $json = $form->processAjax($this->getRequest()->getPost());
	    //header('Content-type: application/json');
	    echo var_dump($this->_getAllParams());
    }

    public function submitContactAction()
    {
        //Action that just displays the Contact form.. this is used to display form in each page..
    	$contactForm = new Application_Form_ContactForm();
    	$this->view->contactForm = $contactForm;
    }
}







