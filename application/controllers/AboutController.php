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
        $ntempos = array("Dimitrios Ntempos", "Business Development Manager, Founder", "ntempos.jpg", 'He has graduated from the Department of Economics of Aristotle university. 
				During those years he attended student exchange programmes in Sweden and France gaining multicultural experiences. 
				By October 2012 he holds an MSc at "Informatics and Management" from the Computer Science Departement of Aristotle. 
				His working experience include traineeships at Greek ministry of foreign affairs, Hellenic post bank and a Consulting company. 
				He is a co-founder of SocialGreen where he works on the Business Development of the project.');
        
        $kuze = array("Evangelos Almpanidis","Electronic engineer, Co-Founder","almpanidis.jpg", "Born and raised in Thessaloniki. He is a graduate of the department of electronics, Alexandreio Technological Education Institute of Thessaloniki and has the capabilities to carry out the procedures of both digital and analog electronics design. 
				His main interests contain embedded software and hardware issues, using FPGA's and microcontrollers.
				 He is the electronic engineer of Social Green having developed the project's prototype bin. 
				Furthermore he has worked as an embedded developer in elevator industry and as technical personnel at A.T.E.I(digital labs I&amp;II). 
				In his free time he is getting involved with graphic design.");
        
        $konos = array("Konstantinos Papadopoulos","IT Manager, Co-Founder","papadopoulos.jpg","Born and raised in Thessaloniki. He is a graduate of the department of electronics, Alexandreio Technological Education Institute of Thessaloniki and has the capabilities to carry out the procedures of both digital and analog electronics design. 
				His main interests contain embedded software and hardware issues, using FPGA's and microcontrollers.
				 He is the electronic engineer of Social Green having developed the project’s prototype bin. 
				Furthermore he has worked as an embedded developer in elevator industry and as technical personnel at A.T.E.I(digital labs I&II). 
				Én his free time he is getting involved with graphic design.");
        $laps = array("George Lapatas","Lead Software Developer","lapatas.png","Born and raised in Thessaloniki, George always show passion for technology, sports and travels. 
				He attends the University of Peloponnese where he complete his studies at the Department of Computer Science and Technology and currently involving with the SocialGreen as a Web programmer. 
					In the mean time he is a swimmer and participate in swimming competitions. He has traveled to Italy, New York and many greek islands, his next big trip will be London." );
		$antonis = array("Antonis Karanaftis","Lead Designer","karanaftis.jpg","Born in Thessaloniki, he is about to graduate from the department of Graphic Design, Technological Educational Institute of Athens. 
				His working experience contains printing and graphic design positions. 
				In his free time, Antonis enjoys photo shooting and animation. 
				He is the Art Director of Social Green where he handles both digital and printed design projects.");
        
        $team = array($ntempos,$kuze,$konos,$laps,$antonis);
        //var_dump($team);
        $this->view->team = $team;
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
		    $output.= "<li>".$json[$field][0]."</li>";
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

    public function quizAction()
    {
        // action body
        $this->view->title = "Quiz";
        
        $quizModel = new Application_Model_Quiz();
        $questions = $quizModel->getQuestions();
        $validAnswers = $quizModel->getValidAnswers();
        
        $this->view->questions = $questions;
        $this->view->validAnswers = $validAnswers;
        
        $this->view->qa = $quizModel->getQsAs();
    }
}















