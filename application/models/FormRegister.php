<?php
class Application_Model_FormRegister extends Zend_Form {
    public function __construct($options=NULL) {
        parent::__construct($options);
        
        $this->setName('register');
        $this->setMethod('post');
        $this->setAction('/sg-alpha/public/account/register/');
        
        $username = new Zend_Form_Element_Text('username');
        $username->setAttrib('size',35);
        $username->setRequired(true);
        $username->addValidator('alnum');
        $username->addErrorMessage("Please use only alphanumeric characters!");
        $username->removeDecorator('label');
        $username->removeDecorator('htmlTag');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('size',35);
        $email->setRequired(true);
        $email->addValidator('emailAddress');
        $email->removeDecorator('label');
        $email->removeDecorator('htmlTag');
        $email->addErrorMessage('Wrong e-mail format');
        
        $pswd = new Zend_Form_Element_Password('pswd');
        $pswd->setAttrib('size',35);
        $pswd->setRequired(true);
        $pswd->removeDecorator('label');
        $pswd->removeDecorator('htmlTag');
        $pswd->addErrorMessage("Password is required");
        
        //Retype password
        $pswd2 = new Zend_Form_Element_Password('pswd2');
        $pswd2->setAttrib('size',35);
        $pswd2->setRequired(true);
        $pswd2->removeDecorator('label');
        $pswd2->removeDecorator('htmlTag');
        $pswd2->addErrorMessage("Password re-type is not correct");
        $pswd2->addValidator('Identical', false, array('token' => 'pswd'));
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->removeDecorator('label');
        $description->removeDecorator('htmlTag');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Register");
        $submit->removeDecorator('DtDdWrapper');
        
        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_register.phtml'))));
        
        $this->addElements(array($username, $email, $pswd, $pswd2,$description, $submit));
    }
}

