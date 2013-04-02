<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Accounts Management";
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
				$salt = substr(md5(rand()), 0, 32);
				$hashedPass = sha1($form->getValue('pswd').$salt);
				
				$token = uniqid();
				$data = array(
                         'email'=>$form->getValue('email'),
                         'description'=>$form->getValue('description'),
                         'username'=>$form->getValue('username'),
                         'password'=>$form->getValue('pswd'),
                         'created'=>date('Y-m-d H:i:s'),
                         'updated'=>date('Y-m-d H:i:s'),
						 'recovery'=>$token,
  						 'password'=>$hashedPass,
						 'salt'=> $salt
                         );       
				TRY {
					$account->insert($data);
					//$this->_helper->flashMessenger->addMessage("You have successfully registered at Social Green Project!");
					//$this->_helper->redirector("index", 'index');
					//$this->_helper->redirector("index","index",array("register"));// _redirector->gotoUrl('/my-controller/my-action/param1/test/param2/test2');
					
					$smtpServer = 'socialgreenproject.com';
					$username = 'info@socialgreenproject.com';
					$password = 'sgadmin12!';
					 
					$config = array(
							'auth' => 'login',
							'username' => $username,
							'password' => $password);
					 
					$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
					
					$htmlMail = "<!DOCTYPE html>
						<html>
						<head>
						<meta charset='UTF-8'>
						<title></title>
							<style>
							body
							{
							max-width:600px;
							}
							* {
								font-family:Georgia;
								color: #911762;
							}
							</style>	
						</head>
						<body>
						<img style='max-width:400px' src='http://socialgreenproject.com/images/social.png'>
						<h1>Welcome at Social Green Project</h1>
						<p>This is a confirmation mail for registering at our community. <br>
							Click the following link to confirm your registration.</p>
						<a href='http://socialgreenproject.com/account/confirm/token/".$token."/usr/".$form->getValue('username')."'>http://socialgreenproject.com/account/confirm/token/".$token."/usr/".$form->getValue('username')."</a>
						</body>
						</html>";
					
					$mail = new Zend_Mail();
					$mail->setBodyHtml($htmlMail)
					->setFrom('no-reply@socialgreenproject.com', 'Social Green Project Team')
					->addTo($form->getValue('email'))
					->setSubject('Confirmation Mail')
					->send($transport);
					
					//$this->_helper->_redirector("index", 'index', array("register","true"));
					$this->_helper->_redirector('index','index',null,array('register'=>'true'));
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
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
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
    		$userId = $auth->getStorage()->read()->id;
    		
    		
    		$accounts = new Application_Model_DbTable_Accounts();
    		$select = $accounts->select();
    		$select->from($accounts)->where('id = ?', $userId);
    		
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
    				$salt = substr(md5(rand()), 0, 32);  
    				$hashedPass = sha1($form->getValue('pswd').$salt);
    				$data2 = array(
    						'email'=>$form->getValue('email'),
    						'description'=>$form->getValue('description'),
    						'username'=>$form->getValue('username'),
    						'password'=>$hashedPass,
    						'salt'=> $salt,
    						'created'=>date('Y-m-d H:i:s'),
    						'updated'=>date('Y-m-d H:i:s')
    				);
    				
    				$where = array('id = ?' => $userId); 
    		
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

    public function confirmAction()
    {
        // action body
    	$token = $this->_getParam('token');
    	$user = $this->_getParam('usr');
    	
    	$userDB = new Application_Model_DbTable_Accounts();
    	$select = $userDB->select();
		$select->from($userDB)->where('username = ?', $user)->where('recovery = ?', $token);
		$accountRowset = $userDB->fetchRow($select);
		if (count($accountRowset) > 0) {
			$this->view->user = $user;			
			$data = array(
					'recovery'=>'',
					'confirmed'=>1
			);
			$where = array('id = ?' => $accountRowset->id);
			$userDB->update( $data, $where);
		} else {
			$this->_helper->redirector("index","index");
		}
    }

    public function resetAction()
    {
        // action body
    	$token = $this->_getParam('token');
    	$now = date("Y-m-d H:i:s");
    	//$user = $this->_getParam('check');
    	$queue = new Application_Model_DbTable_RecoveryQueue();
    	$select = $queue->select();
    	$select->where("token = ?", $token)->where("validUntil > ?", $now);
    	$rowset = $queue->fetchRow($select);
    	if (count($rowset) > 0) {
    		echo "Token is valid.. We may or may not reset your password..!";
    		$where = $queue->getAdapter()->quoteInto('token = ?', $token);
 			$queue->delete($where);
    	}
    }


}













