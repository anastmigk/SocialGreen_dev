<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Welcome";
    	$this->view->title = $title;
    	
    	//Retrieve All user accounts
    	$accounts = new Application_Model_DbTable_Accounts();
    	$query = $accounts->select();
    	$query->from(array('act' => 'activity'), array('SUM(act.quantity) as quantity','SUM(act.plastic) as plastic','SUM(act.glass) as glass','SUM(act.aluminium) as aluminium', '(SUM(act.glass)*1+SUM(act.plastic)*2+SUM(act.aluminium)*3) as leafs','userid','MAX(act.date) as date'));
    	$query->join(array('acc' => 'accounts'), 'act.userid = acc.id', array('fullname','username','avatar','description', 'url'));
    	$query->order('leafs Desc');
    	$query->group(array("username"));
    	$query->setIntegrityCheck(false);
    	//echo (String)$query;
    	$this->view->accounts = $accounts->fetchAll($query);
    	$this->view->imgPrefix = "/images/avatars/";
    	
    	
    }

    public function indexAction()
    {
        // action body
    	//$form = new Application_Model_FormLogin();
    	//$this->view->loginForm = $form;  

    	//$form2 = new Application_Model_FormRegister();
    	//$this->view->registerForm = $form2;
    	
    	$activity = new Application_Model_DbTable_Activity();
    	//$this->view->results = $activity->fetchAll();
    	
    	$query = $activity->select();
    	$query->from(array('acc' => 'accounts'), array('id', 'username','avatar', 'fullname'));
    	$query->join(array('act' => 'activity'), 'act.userid = acc.id', array('quantity','date', 'aluminium','glass','plastic'));
    	$query->order('act.date DESC');
    	$query->setIntegrityCheck(false);
    	
    	$result = $activity->fetchAll($query);
    	$page = $this->_getParam('page',1);
    	$paginator = Zend_Paginator::factory($result);
    	$paginator->setItemCountPerPage(10);
    	$paginator->setCurrentPageNumber($page);
    	
    	//$this->view->paginator=$paginator;
    	$this->view->results = $paginator;
    	
    	$Ladder = new Application_Model_DailyLadder();
    	$this->view->activity = $Ladder->getGraph();
    	$this->view->usernames = $Ladder->getUsernames();
    	$this->view->dates = $Ladder->getDates();
    	
    	$query = $activity->select();
    	$query->from($activity);
    	$this->view->allActivity = $activity->fetchAll($query);
    	
    	
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







