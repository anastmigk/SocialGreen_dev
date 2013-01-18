<?php
class Application_Model_FormRegister extends Zend_Form {
    public function __construct($options=NULL) {
        parent::__construct($options);
        
        $this->setName('register');
        $this->setMethod('post');
        $this->setAction('/SocialGreen_dev/public/account/register/');
        //$this->setAction($this->url(array('controller'=>'account','action'=>'register'), null, true));
        
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
        
        /*$file = new Zend_Form_Element_File('file');
        //$file->setLabel('File to Upload:');
        //$file->setDestination('/images');
        $file->addValidator('IsImage');
        $file->setMaxFileSize(5242880);
        $file->addValidator('Size', false, array('max' => '5242880'));
        $file->addValidator('Count', false, 1);
        $file->addValidator('Extension', false, array('jpg', 'jpeg', 'png', 'gif'));
        $file->removeDecorator('label');
        $file->removeDecorator('htmlTag');
        $file->addErrorMessage("Profile Photo");*/
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->removeDecorator('label');
        $description->removeDecorator('htmlTag');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Register");
        $submit->removeDecorator('DtDdWrapper');
        
        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_register.phtml'))));
        
        $this->addElements(array($username, $email, $pswd, $pswd2, $description, $submit));
    }
}

