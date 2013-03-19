<?php

class Application_Form_QuizForm extends Zend_Form
{

    public function init($qas)
    {
        /* Form Elements & Other Definitions Here ... */
    	$groupid = 1; //Question id to group answers
    	foreach ($qas as $qa){ //iterate through questions to create an element for each question
    		$tempElement = new Zend_Form_Element_Radio();
    		$tempElement->setMultiOptions($qa[2]);
    		echo $qa[1] ;
    		/*$answerid=1; //specific answers id for each question
    		foreach ($qa[2] as $validAnswer){
    				 $answerid++; ?>
    				<label class="radio">
    			  		<input type="radio" name="optionsRadios<?php echo $groupid; ?>" id="optionsRadios<?php echo $answerid; ?>" value="option<?php echo $answerid;?>">
    			  		<?php echo $validAnswer; ?>	
    				</label><?php 
    		 }
    		 $groupid++;*/
    		$this->addElement($tempElement); 
    	} 
    	$this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_quiz.phtml'))));
    }


}