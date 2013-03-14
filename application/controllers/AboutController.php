<?php

class AboutController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function binAction()
    {
        // action body
    }

    public function ourteamAction()
    {
        // action body
    }

    public function contactAction()
    {
        //Function to submit form and send mail
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper("layout")->disableLayout();
    	
        $f = new Application_Form_ContactForm();
        $flag = $f->isValid($this->_getAllParams());
        $json = $f->getMessages();
        if ($flag){
        	echo '<div class="alert alert-success">Your message has been sent! We will get back to you ASAP!</div>';
        	
        	$htmlMail = $f->getValue('description');
        
        	$mail = new Zend_Mail();
        	$mail->setBodyText($htmlMail)
        	->setFrom($f->getValue('email'), 'Social Green Project Team')
        	->addTo($f->getValue('email')) //akoma den einai etoimo
        	->setSubject('Mail')
        	->send();
        	
        	
        } else {
        	//echo '<div class="alert alert-error">'.Zend_Json::encode($json).'</div>'; 
        $arrMessages = $json;
        //$output = Zend_Json::encode($json);
		$output="<ol>";
		foreach($json as $field => $arrErrors) {
		    $output.= "<li>".$json[$field][0]."</li>";//rrErrors[$field];
		}
		$output.="</ol>";
        	echo '<div class="alert alert-error">'.$output.'</div>';
        }
    }

    public function teamAction()
    {
        // action body
    }

    public function howItWorksAction()
    {
        // action body
    }

    public function getInvolvedAction()
    {
        // action body
    }


}













