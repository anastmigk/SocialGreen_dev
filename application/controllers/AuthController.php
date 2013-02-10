<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	
    }

    public function indexAction()
    {
        // action body
    	$form = new Application_Model_FormLogin();
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    	
    		if ($form->isValid($request->getPost())) {
    	
    			// do 	something here to log in+
    			if ($this->_process($form->getValues())) {
    			
    				// We're authenticated! Redirect to the home page
    			
    				$this->_helper->redirector('index', 'index');
    			} else {
    				
    				$this->view->errors = array( array("Wrong username and password combination dude!"));
    			}
    			
    		} else {
    			$this->view->errors = $form->getErrors();
    		}
    	
    	}
    	
    	$this->view->form = $form;
    	 
    }

    protected function _process($values)
    {
    
    	// Get our authentication adapter and check credentials
    
    	$adapter = $this->_getAuthAdapter();
    
    	$adapter->setIdentity($values['username']);
    
    	$adapter->setCredential($values['password']);
    
    	$auth = Zend_Auth::getInstance();
    
    	$result = $auth->authenticate($adapter);
    
    	if ($result->isValid() && $this->isConfirmedAction($values['username'])) {
    
    		$user = $adapter->getResultRowObject();
    
    		$auth->getStorage()->write($user);
    
    		return true;
    
    	}
    
    	return false;
    
    }

    protected function _getAuthAdapter()
    {
    
    
    
    	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    
    	$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

    	$authAdapter->setTableName('accounts')
    
    	->setIdentityColumn('username')
    
    	->setCredentialColumn('password');
    
    	//->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        
    	return $authAdapter;
    
    }

    public function logoutAction()
    {
        // action body
    	Zend_Auth::getInstance()->clearIdentity();
    	
    	$this->_helper->redirector('index', 'index'); // back to login page
    }

    protected function isConfirmedAction($username)
    {
        // action body
    	$account = new Application_Model_DbTable_Accounts();
    	$select = $account->select();
    	$select->from($account)->where('username = ?', $username);
    	$row = $account->fetchRow($select);
    	if (count($row)>0){
    		if ($row->confirmed ==1){
    			return true;
    		}
    	}
    	return false;
    }


}





