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
		
		$elements = $form->getElements();
		foreach($elements as $element) {
			$element->removeDecorator('Errors');
		}
       
        if ($this->getRequest()->isPost())
        { 	
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
					
					$mail = new Zend_Mail();
					$mail->setBodyText('This is the text of the mail.')
					->setFrom('no-reply@socialgreenproject.com', 'Social Green Project')
					->addTo($form->getValue('email'), $form->getValue('username'))
					->setSubject('SocialGreen Project Registration')
					->send();
					
                }
                catch (Zend_Db_Exception $e) {
					echo $e->getMessage();	
                }
			}
            else
            {
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
    	$this->view->title = "Profile";
        $accounts = new Application_Model_DbTable_Accounts();
        $select = $accounts->select();
        $select->where("username = ?", $username);
        $this->view->account = $accounts->fetchRow($select);
    }

    public function editAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
    	
    		$username = $auth->getIdentity()->username;
    		
    		$accounts = new Application_Model_DbTable_Accounts();
    		$select = $accounts->select();
    		$select->from($accounts)->where('username = ?', $username);
    		
    		$userAccount = $accounts->fetchAll($select);
    		$form = new Application_Model_FormRegister("edit");
    		
    		$elements = $form->getElements();
    		foreach($elements as $element) {
    			$element->removeDecorator('Errors');
    		}
    		
    		$form->populate($userAccount->current()->toArray());
    		
    		$this->view->form = $form;
    		
    		
    		if ($this->getRequest()->isPost()) {
    		
    			if ($form->isValid($this->_request->getPost()))
    			{
    				$account = new Application_Model_DbTable_Accounts();
    				 
    				$data2 = array(
    						'email'=>$form->getValue('email'),
    						'description'=>$form->getValue('description'),
    						'username'=>$form->getValue('username'),
    						'password'=>$form->getValue('pswd'),
    						'created'=>date('Y-m-d H:i:s'),
    						'updated'=>date('Y-m-d H:i:s')
    				);
    				
    				$where = array('username = ?' =>$form->getValue('username')); 
    		
    				TRY {
    					$account->update( $data2, $where);
    					$this->_helper->flashMessenger->addMessage("You have successfully updated your profile!");
    					$this->_helper->redirector("index", 'account');
    				} catch (Zend_Db_Exception $e) {
    					echo $e->getMessage();
    				}
    			}else {
    				$this->view->errors = $form->getErrors();
    			}
    		
    		}
    		
    		
    	}
    }

    public function deleteAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
    		$username = $auth->getIdentity()->username;
    		$accounts = new Application_Model_DbTable_Accounts();
    		//$accounts->delete("username = ?", $username);
    		$where = $accounts->getAdapter()->quoteInto("username = ?", $username);
    		$accounts->delete($where);
    		$auth->clearIdentity();
    		$this->_redirect('/');
    	} else {
    		$this->_redirect('/');
    	}
    }
}









