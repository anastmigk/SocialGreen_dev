<?php

class RestapiController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout()->disableLayout();
    	
    }

    public function indexAction()
    {
        // action body
    	//$this->_helper->redirector('index', 'account');
    }
    
        
    public function userinfoAction()
    {
    	$request = $this->getRequest();
    	$user = $request->getPost('user');
    	
    	$this->view->badgesPrefix = "/images/badges/";
    	$this->view->imgPrefix = "/images/avatars/";
    	$this->view->title = $user;
    	
    	
    	if ($request->isPost())
    	{
    		 
    		if (userexist($user))
    		{
    			/*Retrieve All user's badges
    			$userbadges = new Application_Model_DbTable_Accounts();
    			$query = $userbadges->select('bad.id','bad.title','bad.path','bad.class');
    			$query->from(array('acc' => 'accounts'),array('id','username'));
    			$query->from(array('usb' => 'user_badges'),array('badge_id','user_id'));
    			$query->from(array('bad' => 'badges'),array('id','title','path', 'class'));
    			$query->where('acc.id = usb.user_id AND acc.username = "'.$user.'" AND usb.badge_id = bad.id');
    			$query->group(array("bad.id"));
    			
    			$query->setIntegrityCheck(false);
    			$this->view->userbadges = $userbadges->fetchAll($query);*/
    			
    			/*Retrieve ALL user's Activity
    			$useractivity = new Application_Model_DbTable_Accounts();
    			$query3 = $useractivity->select();
    			$query3->from(array('acc' => 'accounts'), array('id', 'username','avatar', 'fullname'));
    			$query3->from(array('act' => 'activity'),array('quantity','date', 'aluminium','glass','plastic'));
    			$query3->where('acc.username = "'.$user.'" AND act.userid = acc.id');
    			
    			$query3->order('act.date DESC');
    			$query3->setIntegrityCheck(false);
    			
    			$result2 = $useractivity->fetchAll($query3);*/
    			
    			/*$accounts = new Application_Model_DbTable_Accounts();
    			$query = $accounts->select();
    			$query->from(array('act' => 'activity'), array('SUM(act.quantity) as quantity','SUM(act.plastic) as plastic','SUM(act.glass) as glass','SUM(act.aluminium) as aluminium', '(SUM(act.glass)*1+SUM(act.plastic)*2+SUM(act.aluminium)*3) as leafs','userid','MAX(act.date) as date'));
    			$query->join(array('acc' => 'accounts'), 'act.userid = acc.id', array('fullname','username','avatar','description', 'url'));
    			$query->order('leafs Desc');
    			$query->group(array("username"));
    			$query->setIntegrityCheck(false);
    			//echo (String)$query;
    			$this->view->accounts = $accounts->fetchAll($query);*/
    			
    			/*Retrieve ALL user's Activity*/
		    	$userinfo = new Application_Model_DbTable_Accounts();
		    	$query3 = $userinfo->select();
		    	$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url'));
		    	$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
		    	$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
		    	$query3->group("acc.username");
		    	$query3->setIntegrityCheck(false);
		    	$this->view->userinfo = $userinfo->fetchRow($query3);
    			 
    		}
    		else
    		{
    			//$this->view->errors = array( array("Wrong username and password combination dude!"));
    			//$this->_response->clearBody();
				//$this->_response->clearHeaders();
				//$this->_response->setHttpResponseCode(404);
    			$this->view->errors = "User don't exist";
    		}
    		 
    	}
    	else
    	{
    		//$this->_response->clearBody();
			//$this->_response->clearHeaders();
			//$this->_response->setHttpResponseCode(404);
    		$this->view->errors = "No post data";
    	}
    	
    	/*
    	
    	$user = $this->_getParam('user');
    	$this->view->title = $user;
    	$this->view->user = $user;
    	
    	$userinfo = new Application_Model_DbTable_Accounts();
    	$query3 = $userinfo->select();
    	$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url'));
    	$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
    	$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
    	$query3->group("acc.username");
    	$query3->setIntegrityCheck(false);
    	
    	$this->view->userinfo = $userinfo->fetchRow($query3);*/
    	
    	function userexist($user)
    	{
    		if($user != NULL)
    		{
    			$usr = new Application_Model_DbTable_Accounts();
    			$query = $usr->select();
    			$query->from(array('acc' => 'accounts'), array('username'));
    			$query->where('acc.username = "'.$user.'"');
    			$query->setIntegrityCheck(false);
    			$username = $usr->fetchRow($query);
    	
    			if($username->username !=NULL)
    			{
    				return true;
    			}
    			else
    			{
    				return false;
    			}
    		}
    		else
    		{
    			return false;
    		}
    		return false;
    	}
    	
    	
    }

    public function userloginAction()
    {
        // action body
    }


}





