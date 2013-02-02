<?php 
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 

{

    public function loggedInAs ()

    {

        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {

            $username = $auth->getIdentity()->username;

            $logoutUrl = $this->view->url(array('controller'=>'auth','action'=>'logout'), null, true);
            
            $editUrl = $this->view->url(array('controller'=>'account', 'action'=>'profile', 'usr'=>$username),null, true);
            
            $edit ='<li class="has-dropdown">
            			<a href="'.$editUrl.'">'.$username.'</a>
	            		<ul class="dropdown">
		           			<li><a href='.$this->view->url(array('controller'=>'account','action'=>'profile', 'usr'=>$username)).'>More info</a></li>
           					<li><a href='.$this->view->url(array('controller'=>'account','action'=>'edit')).'>Edit</a></li>
           					<li><a href="'.$logoutUrl.'">Logout</a></li>
            			</ul>
           			</li>';
            
            

            //return '<li><a href="'.$logoutUrl.'">Logout</a></li><li><a href="'.$editUrl.'">Profile</a></li>';
            //return $edit;
      
            return '<li><a href='. $this->view->url(array('controller'=>'greenladder'), null, TRUE).'>Game</a></li>
    				<li><a href='. $this->view->url(array('controller'=>'account'), null, TRUE).'>Users</a></li>
            		<li><a href='.$this->view->url(array('controller'=>'account','action'=>'profile', 'usr'=>$username)).'>More info</a></li>
           			<li><a href='.$this->view->url(array('controller'=>'account','action'=>'edit')).'>Edit</a></li>
           			<li><a href="'.$logoutUrl.'">Logout</a></li>
					  </li>';
        } 

		        

        $request = Zend_Controller_Front::getInstance()->getRequest();

        $controller = $request->getControllerName();

        $action = $request->getActionName();
/*
        if($controller == 'auth' && $action == 'index') {

            return '';

        }
*/
        $loginUrl = $this->view->url(array('controller'=>'auth', 'action'=>'index'));
        $registerUrl = "<li><a href=".$this->view->url(array('controller'=>'account', 'action'=>'register'), null, TRUE).">Register</a></li>";

        return '<li><a href="'.$loginUrl.'">Login</a></li>'.$registerUrl;
       

    }

}
?>