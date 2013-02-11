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
		           			<li><a href='.$this->view->url(array('controller'=>'account','action'=>'profile', 'usr'=>$username)).' title="Dig in">More info</a></li>
           					<li><a href='.$this->view->url(array('controller'=>'account','action'=>'edit')).' title="Change your profile">Edit</a></li>
           					<li><a href="'.$logoutUrl.'" title="Bye">Logout</a></li>
            			</ul>
           			</li>';
            
            

            //return '<li><a href="'.$logoutUrl.'">Logout</a></li><li><a href="'.$editUrl.'">Profile</a></li>';
            //return $edit;
      
            return '<li><a href='. $this->view->url(array('controller'=>'greenladder'), null, TRUE).' title="Check out the game">Game</a></li>
    				<li><a href='. $this->view->url(array('controller'=>'account'), null, TRUE).' title="We have lots of users">Users</a></li>
            		<li><a href='.$this->view->url(array('controller'=>'account','action'=>'profile', 'usr'=>$username)).' title="Find out more">More info</a></li>
           			<li><a href='.$this->view->url(array('controller'=>'account','action'=>'edit')).' title="Change your info">Edit</a></li>
           			<li><a href="'.$logoutUrl.'" title="Bye">Logout</a></li>
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
        $registerUrl = "<li><a id='buttonModalRegister' href=".$this->view->url(array('controller'=>'account', 'action'=>'register'), null, TRUE)." title='Be a member!'>Register</a></li>";
        //$registerUrl = "<li><a id='buttonModalRegister' href='#'>Register</a></li>";
        
        return '<li><a href="'.$loginUrl.'" title="Get inside Social Green!">Login</a></li>'.$registerUrl;
        //return '<li><a id="buttonModalLogin" href="#">Login</a></li>'.$registerUrl;

    }

}
?>