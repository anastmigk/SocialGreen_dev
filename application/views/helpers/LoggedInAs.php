<?php 
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 

{

    public function loggedInAs ()

    {

        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {

            $username = $auth->getIdentity()->username;
            $avatar = $auth->getIdentity()->avatar;
            $accounts2 = new Application_Model_DbTable_Accounts();
            $select2 = $accounts2->select();
            $select2->from($accounts2, array('avatar'))->where('username = ?', $username);
            
            $avatarTemp = $accounts2->fetchAll($select2);
            $avatar = $avatarTemp[0]->avatar;
            
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
            
            
           // <!-- POP UP menu for later.. -->
            $dropdownMenu = '<ul class="nav pull-right">
            					<li class="dropdown">
            						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="img-rounded smallProfileImage" src="'.$this->view->baseUrl($avatar).'"></a>
            							<ul class="dropdown-menu">
            								<li class="nav-header" ><i class="icon-user"></i>&nbsp;&nbsp;Hello '.$username.'!</li>
            								<li class="divider"></li>
											<li><a href='. $this->view->url(array('controller'=>'account'), null, TRUE).'><i class="icon-home"></i>&nbsp;&nbsp;Home</a></li>
            								<li><a href='. $this->view->url(array('controller'=>'account' , 'action'=>'profile'), null, TRUE).'?user='.$username.'><i class="icon-book"></i>&nbsp;&nbsp;Profile</a></li>';
            										
            								//'<li><a href='. $this->view->url(array('controller'=>'account'), null, TRUE).' title="We have lots of users">Users</a></li>
            								//<li><a href='.$this->view->url(array('controller'=>'account','action'=>'profile', 'usr'=>$username)).' title="Find out more">More Info</a></li>
            								$dropdownMenu.='<li><a href='.$this->view->url(array('controller'=>'account','action'=>'edit')).' title="Change your info"><i class="icon-edit"></i>&nbsp;&nbsp;Edit</a></li>
            								<li><a href="'.$logoutUrl.'" title="Bye"><i class="icon-off"></i>&nbsp;&nbsp;Logout</a></li>
            							</ul>
            					</li>
            				</ul>';
           // <!-- -->

            //return '<li><a href="'.$logoutUrl.'">Logout</a></li><li><a href="'.$editUrl.'">Profile</a></li>';
            //return $edit;
      
           /* return '<li><a href='. $this->view->url(array('controller'=>'greenladder'), null, TRUE).' title="Check out the game">Game</a></li>
    				<li><a href='. $this->view->url(array('controller'=>'account'), null, TRUE).' title="We have lots of users">Users</a></li>
            		<li><a href='.$this->view->url(array('controller'=>'account','action'=>'profile', 'usr'=>$username)).' title="Find out more">More info</a></li>
           			<li><a href='.$this->view->url(array('controller'=>'account','action'=>'edit')).' title="Change your info">Edit</a></li>
           			<li><a href="'.$logoutUrl.'" title="Bye">Logout</a></li>
					  </li>';*/
            return $dropdownMenu;
        } 

        

        $request = Zend_Controller_Front::getInstance()->getRequest();

        $controller = $request->getControllerName();

        $action = $request->getActionName();
/*
        if($controller == 'auth' && $action == 'index') {

            return '';

        }
*/		/*$introLink='<li><a title="Learn more!">How It Works</a></li>
					<li><a title="Participate!">Get Involved</a></li>';*/
        $loginUrl = '<li><a href="'.$this->view->url(array('controller'=>'auth', 'action'=>'index')).'" title="Get inside Social Green!">Login</a></li>';
        //$loginUrl = $this->view->url(array('controller'=>'auth', 'action'=>'index'));
        $registerUrl = "<li><a id='buttonModalRegister' href=".$this->view->url(array('controller'=>'account', 'action'=>'register'), null, TRUE)." title='Be a member!'>Register</a></li>";
        //$registerUrl = "<li><a id='buttonModalRegister' href='#'>Register</a></li>";
        
        return $registerUrl.$loginUrl;
        //return $introLink.$registerUrl.$loginUrl;
        //return '<li><a href="'.$loginUrl.'" title="Get inside Social Green!">Login</a></li>'.$registerUrl;
        //return '<li><a id="buttonModalLogin" href="#">Login</a></li>'.$registerUrl;

    }

}
?>