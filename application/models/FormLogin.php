<?php

class Application_Model_FormLogin extends Zend_Form
{
    public function __construct($options=NULL) {
        parent::__construct($options);
        
        $this->setName('login');
        $this->setMethod('post');
        $this->setAction('/sg-alpha/public/account/register');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('size',35);
        $email->removeDecorator('label')->removeDecorator('htmlTag');
        $email->setRequired(true);
        $email->addValidator('emailAddress');
        $email->addErrorMessage('Wrong e-mail format dude!');
        
        $pswd = new Zend_Form_Element_Password('pswd');
        $pswd->setAttrib('size',35);
        $pswd->removeDecorator('label')->removeDecorator('htmlTag');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setlabel('Login');
        $submit->removeDecorator('DtDdWrapper');

        $this->setDecorators( array( array('ViewScript',
            array('viewScript' => '_form_login.phtml'))));
        
        $this->addElements(array($email, $pswd, $submit));
    }

}

