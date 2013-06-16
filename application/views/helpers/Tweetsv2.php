<?php
use Codebird\Codebird;

class Zend_View_Helper_Tweetsv2 extends Zend_View_Helper_Abstract
{
	public function Tweetsv2(){

		//We use already made Twitter OAuth library
		//https://github.com/mynetx/codebird-php
		require_once ('codebird/codebird.php');
		
		//Twitter OAuth Settings
		$CONSUMER_KEY = '5DgxM4lIebEXkJB1tPg3Q';
		$CONSUMER_SECRET = 'BY2ToZsI4xFNRsBZL32FbznfkFlSzb4BjWkkcOKGzOc';
		$ACCESS_TOKEN = '507230390-hmoezBoN0eX9WEPQ5bJpNmxbWuMVeonm22QZG4NU';
		$ACCESS_TOKEN_SECRET = '8bC9H2JCQJnlL325OfxEgOQO9gcbh3YewJm2UwnQtE';
		
		//Get authenticated
		Codebird::setConsumerKey($CONSUMER_KEY, $CONSUMER_SECRET);
		$cb = Codebird::getInstance();
		$cb->setToken($ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);
		
		//retrieve posts
		//$q = $_POST['q'];
		$q = "@papadopoulosk";
		$count = '9'; //$_POST['count'];
 		$api = "/statuses/user_timeline.json?screen_name=twitterapi&count=2"; //$_POST['api'];
		
		//https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
		//https://dev.twitter.com/docs/api/1.1/get/search/tweets
		$params = array(
				'screen_name' => $q,
				'q' => $q,
				'count' => $count
		);
		
		//Make the REST call
		$data = (array) $cb->$api($params);
		
		//Output result in JSON, getting it ready for jQuery to process
		echo json_encode($data);
		
	}
}