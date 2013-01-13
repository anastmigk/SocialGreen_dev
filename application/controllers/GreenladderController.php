<?php

class GreenladderController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Green Ladder ASDf";
    	$this->view->title = $title;    	
    	
    	$Ladder = new Application_Model_Ladder();
    	$this->view->graph = $Ladder->getGraph();
    	
    	$dailyLadder = new Application_Model_DailyLadder();
    	$this->view->dailyGraph = $dailyLadder->getGraph();
    	
  
    }

    public function indexAction()
    {
        // action body
        
    }


}

