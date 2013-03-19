<?php

class Application_Model_Quiz
{
	private $questions;
	private $validAnswers;
	
	public function __construct(){
		//$answers = new Application_Model_DbTable_Answers();
		$questions = new Application_Model_DbTable_Questions();
		$valid_answers = new Application_Model_DbTable_AnswersTemplate();
		$this->validAnswers = $valid_answers->fetchAll();
		$select = $questions->select();
		$this->questions = $questions->fetchAll();
	}
	
	public function getQuestions (){
		return $this->questions;
	}
	
	public function getValidAnswers(){
		return $this->validAnswers;
	}
	
	public function getQsAs(){
		$questionaire = array();
		$answers = array();
		
		
		$i=0;
		foreach($this->questions as $q){
			$curAnswer = array();
			foreach ($this->validAnswers as $a){
				//$answers[$a->question_id] = array($a->valid_answer);
				if ($a->question_id==$q->id){
					$curAnswer[$a->id]=$a->valid_answer;
				}
				$questionaire[$i] = array($q->title,$q->question, $curAnswer);
			}
			$i++;
		}
		
		return $questionaire;
	}
}
