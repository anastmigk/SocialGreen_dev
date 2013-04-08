<?php
class Zend_View_Helper_Access extends Zend_View_Helper_Abstract
{
    public function Access($view){
        
    	$auth = Zend_Auth::getInstance();
    	
    	if (!$auth->hasIdentity()){
    		$user = "guest";
    		$homelink = $view->url(array('controller'=>'index'), null, TRUE);
    	} else {
    		$homelink = $view->url(array('controller'=>'account'), null, TRUE);
    		$user = "member";
    	}
    	 
    	$acl = new Zend_Acl();
    	$acl->addRole(new Zend_Acl_Role('guest'))->addRole(new Zend_Acl_Role('member'))->addRole(new Zend_Acl_Role('admin'));
    	//$parents = array('guest', 'member', 'admin');
    	
    	$acl->add(new Zend_Acl_Resource('index'));
    	$acl->add(new Zend_Acl_Resource('about'));
    	$acl->add(new Zend_Acl_Resource('auth'));
    	$acl->add(new Zend_Acl_Resource('error'));
    	$acl->add(new Zend_Acl_Resource('account'));
    	$acl->add(new Zend_Acl_Resource("greenladder"));
    	//$acl->add(new Zend_Acl_Resource('register'), 'account');
    	
    	
    	$acl->allow("guest","index");
    	$acl->allow("guest","error");
    	$acl->allow("guest","about");
    	$acl->allow("guest","auth");
    	$acl->allow("guest","greenladder", array("binupdate"));
    	$acl->allow("guest","account", array('register','confirm','reset'));
    	$acl->allow('member');
    	
    	$acl->deny("guest","about",array("index"));
    	
    	$frontController = Zend_Controller_Front::getInstance();
    	$controllerName  = $frontController->getRequest()->getControllerName();
    	$privilageName =$frontController->getRequest()->getActionName();
    	$urlOptions = array('controller' => 'index',
    			'action' => 'index'
    	);
    	$redirector = new Zend_Controller_Action_Helper_Redirector();
    	
    	return  array("acl" =>$acl->isAllowed($user,  $controllerName, $privilageName) ? 'allowed' : 'denied', "homelink"=> $homelink);
    	
    }

}
?>