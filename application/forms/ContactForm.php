<?php

class Application_Form_ContactForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	//$this->setName("recoveryForm");
    	//$this->setAction($path);
    	
    	$name = new Zend_Form_Element_Text("name");
    	$name->setAttrib ('placeholder', "What's your name?");
    	$name->setAttrib ('class', "input-block-level");
    	$name->setAttrib('size',35);
    	$name->setRequired(true);
    	$name->addValidator('alnum');
    	$name->addErrorMessage("Please use only alphanumeric characters!");
    	$name->removeDecorator('label');
    	$name->removeDecorator('htmlTag');
    	
    	$email = new Zend_Form_Element_Text('email');
    	$email->setAttrib("placeholder", "We need an e-mail to get back to you!");
    	$email->setAttrib ('class', "input-block-level");
    	$email->setAttrib('size',35);
    	$email->setRequired(true);
    	$email->addValidator('emailAddress');
    	$email->removeDecorator('label');
    	$email->removeDecorator('htmlTag');
    	$email->addErrorMessage('Wrong e-mail format');
    	
    	// Add a captcha
    	$captcha = new Zend_Form_Element_Captcha("captcha",array(
    			/*'label'      => 'Are you human?!:',*/
    			'required'   => true,
    			'captcha'    => array(
    					'captcha' => 'Figlet',
    					'wordLen' => 5,
    					'timeout' => 300
    			),
    			'messages' => array(
    					'badCaptcha' => 'You have entered an invalid value for the captcha'
    			)
    	));
    	$captcha->setAttrib ( 'class', "input-block-level");
    	$captcha->removeDecorator('htmlTag');
    	
    	$description = new Zend_Form_Element_Textarea('description');
    	$description->setAttrib("placeholder", "Tell us about it!");
    	$description->removeDecorator('label');
    	$description->removeDecorator('htmlTag');
    	$description->setAttrib ( 'class', "input-block-level");
    	$description->setAttrib('rows', '4');
    	$description->setAttrib('cols', '8');
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel("Send!");
    	$submit->removeDecorator('DtDdWrapper');
    	
    	$submit->setAttrib ( 'class', "btn btn-success");
    	
    	$this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_contact.phtml'))));
    	//$this->addElements(array($name, $email, $captcha, $description, $submit));
    	$this->addElements(array($name, $email, $description, $submit));
    }


}

