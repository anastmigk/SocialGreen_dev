<?php

class Application_Form_BinUpdateForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('GET');
    	$this->setaction("http://socialgreen.azurewebsites.net/public/greenladder/binupdate/");
    	$this->setName("BinUpdateForm");
    	
    	
    	$id = new Zend_Form_Element("userid");
    	$id->setLabel("User ID");
    	$id->setRequired(true);
    	
    	$quantity = new Zend_Form_Element("quantity");
    	$quantity->setLabel("Quantity");
    	$quantity->setRequired(true);
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel("Send!");
    	$submit->setAttrib("class", "btn btn-large btn-inverse");
    	
    	$this->addElements(array($id,$quantity,$submit));
    }


}

