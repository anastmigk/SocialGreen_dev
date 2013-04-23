<?php

class Application_Form_UploadAvatar extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setName('upload');
    	$this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	
    	$description = new Zend_Form_Element_Text('description');
    	$description->setLabel('Description');
    	$description->setRequired(true);
    	$description->addValidator('NotEmpty');
    	
    	$file = new Zend_Form_Element_File('file');
    	$file->setLabel('File');
    	$file->setDestination(BASE_PATH . '/public/images/avatars');
    	$file->setRequired(true);
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Upload');
    	$submit->setAttrib("class", "btn btn-large btn-inverse");
    	
    	$this->addElements(array($description, $file, $submit));
    }


}

