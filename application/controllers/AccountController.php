<?php

class AccountController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    	$title = "User Accounts";
    	$this->view->title = $title;
    	if ($this->_helper->FlashMessenger->hasMessages()) {
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    	}
    }

    public function indexAction()
    {
        // action body
        $accounts = new Application_Model_DbTable_Accounts();
        $this->view->accounts = $accounts->fetchAll();
       
    }

    public function registerAction()
    {
    	$title = "User Registration";
    	$this->view->title = $title;
    	
       $form = new Application_Model_FormRegister();
       
         if ($this->getRequest()->isPost()) {
         	
             if ($form->isValid($this->_request->getPost()))
             {
                     $account = new Application_Model_DbTable_Accounts();
                     
                     $data = array(
                         'email'=>$form->getValue('email'),
                         'description'=>$form->getValue('description'),
                         'username'=>$form->getValue('username'),
                         'password'=>$form->getValue('pswd'),
                         'created'=>date('Y-m-d H:i:s'),
                         'updated'=>date('Y-m-d H:i:s')
                         );
                        
                		TRY {
                			$account->insert($data);
                			$this->_helper->flashMessenger->addMessage("You have successfully registered at Social Green Project!");
                			$this->_helper->redirector("index", 'account');
                		} catch (Zend_Db_Exception $e) {
                			echo $e->getMessage();	
                		}
             }else {
                $this->view->errors = $form->getErrors();
             }

         }
        $this->view->title = "New registration";
        $this->view->form = $form;        
    }

    public function profileAction()
    {
        // action body
        $username = $this->_getParam('usr');
        $accounts = new Application_Model_DbTable_Accounts();
        $select = $accounts->select();
        $select->where("username = ?", $username);
        $this->view->account = $accounts->fetchRow($select);
    }

    public function editAction()
    {
        // action body
    }


}







