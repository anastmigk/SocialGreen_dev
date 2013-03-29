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
        $ntempos = array(
        		"Dimitrios Ntempos", 
        		"CEO, Co-founder", 
        		"ntempos.jpg", 
        		'Dimitrios has studied economy and the computer science at Aristotle university of thessaloniki. His working experience contains positions at public and the private sector. he strongly believes that starting up is the absolute next step after education.',
        		"http://gr.linkedin.com/pub/dimitrios-ntempos/33/407/4b1/",
        		"aboutme",
        		"http://about.me/di.ntempos");
        
        $kuze = array(
        		"Evangelos Almpanidis",
        		"Electronic Engineer, Co-Founder",
        		"vaggel.jpg", 
        		"Born in Thessaloniki, vangelis deals with the hardware component of Social-Green. He has worked as an embeded system developer as well as academic assistante in A.T.E.I (digital labs I&II) lab. He is a paok fc fun and former graffiti artist.",
        		'http://gr.linkedin.com/pub/almpanidis-evangelos/5a/43b/194/',
        		"aboutme",
        		'http://about.me/evangelos.almpanidis');
        
        $konos = array(
        		"Konstantinos Papadopoulos",
        		"CTO, Co-founder",
        		"esu.jpg",
        		"Konstantinos works as a jr. IT Auditor while the same time leads the technical part of Social-Green. At his free time he enjoys Web & iOS and studing about Information Security. He Holds an MSc degree in ICT Systems.",
        		'http://www.linkedin.com/in/papadopoulosk',
        		'twitter',
        		'https://twitter.com/papadopoulospk');
        
        $laps = array(
        		"George Lapatas",
        		"Web Developer",
        		"giwrgos.jpg",
        		"Born in thessaloniki, george is about to graduate from the dept computer science and technology, university of Peloponnese. At social-green he delivers cut-edge code and clear cut user interfaces . He loves travelling and swimming.",
        		'http://gr.linkedin.com/pub/giorgos-lapatas/3b/621/324/',
        		'aboutme',
        		'http://about.me/glapatas');
		
		$antonis = array(
				"Antonis Karanaftis",
				"Designer & Artist",
				"antw.jpg",
				"He is the Art Director of Social Green where he handles every design related issue. His working experience contains printing and graphic design positions. In his free time, Antonis enjoys photo shooting and animation.",
				'http://gr.linkedin.com/pub/antonis-karanaftis/65/3a1/19b',
				'mail',
				'#');
        
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
        	echo '<div class="alert alert-success">Your message has been sent! We will get back to you!</div>';
        	
        	$smtpServer = 'socialgreenproject.com';
        	$username = 'info@socialgreenproject.com';
        	$password = 'sgadmin12!';
        	
        	$config = array(
        			'auth' => 'login',
        			'username' => $username,
        			'password' => $password);
        	
        	$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
        	
        	$htmlMail = $f->getValue('description');
        
        	$mail = new Zend_Mail();
        	$mail->setBodyText($htmlMail)
        	->setFrom($f->getValue('email'), $f->getValue('name'))
        	->addTo("info@socialgreenproject.com") //akoma den einai etoimo
        	->setSubject('User Mail sent on '.date("F j, Y, g:i a").'!')
        	->send($transport);
        	
        	
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
        
        //$this->view->questions = $questions;
        //$this->view->validAnswers = $validAnswers;
        
        //$this->view->qa = $quizModel->getQsAs();
        $this->view->quizForm = $quizModel->getQuizForm();
    }

    public function submitQuizAction()
    {
        // action body
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->layout->disableLayout();
    	$form = new Application_Form_QuizForm();
    	
    	$form->isValidPartial($this->_getAllParams());
    	if ($form==true){
    		//$json = $form->processAjax($this->getRequest()->getPost());
    		//header('Content-type: application/json');
    		$Quiz = new Application_Model_Quiz();
    		$answers = $this->_getAllParams();
    		try {
    			$Quiz->saveAnswers($answers);
    			echo 1;
    		} catch (Exception $e) {
    			echo 0;
    		}
    		
    	}

    }


}

















