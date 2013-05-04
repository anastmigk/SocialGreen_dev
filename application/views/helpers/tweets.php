<?php
class Zend_View_Helper_Tweets extends Zend_View_Helper_Abstract
{
	public function Tweets(){
		
		$url = file_get_contents("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=papadopoulospk&count=6");
		
		$arr = json_decode($url,true);
		
		$prettyString = Zend_Json::prettyPrint($url);
		//print_r($prettyString);
		
		echo "<table class='' id='twitter'>";
		foreach ($arr as $item){
			echo "<tr>";
			echo "<td class='text'>";
			echo $item['text'];
			echo "</td>";
			echo "<td class='time'>";
			echo date("j/n/y",strtotime($item['created_at']));;
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		
	}
}