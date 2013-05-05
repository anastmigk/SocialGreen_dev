<?php
class Zend_View_Helper_Tweets extends Zend_View_Helper_Abstract
{
	public function Tweets(){
		
		$url = file_get_contents("https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=sociallgreen");
		
		$arr = json_decode($url,true);
		$prettyString = Zend_Json::prettyPrint($url);
		//print_r($prettyString);
		
		echo "<table class='' id='twitter'>";
		$displayCounter = 1;
		$limit = 4;
		foreach ($arr as $item){
			if ($displayCounter=='1') echo '<tr><td><button class="btn btn-info" data-toggle="button" id="moarTweets" type="button">More&nbsp;<i class="icon-circle-arrow-down icon-white"></i></button></td></tr>';
			echo "<tr";
			if ($displayCounter>=$limit) echo " class='hidden' ";
			echo ">";
			echo "<td class='text'>";
			echo $item['text'];//linkEntitiesWithinText($arr);//$item['text'];
			echo "</td>";
			echo "<td class='time'>";
			echo date("j/n/y",strtotime($item['created_at']));;
			echo "</td>";
			echo "</tr>";
			$displayCounter++;
		}
		echo "</table>";
		?>
		<script>
		$("#moarTweets").click(function(){
			if ($(this).attr('class')=="btn btn-info"){
				$("table#twitter").find("tr:hidden").each(function(){
					$(this).toggleClass("hidden");//css('background-color', 'red');
				});
				$("#moarTweets").html('Less&nbsp;<i class="icon-circle-arrow-up icon-white"></i>');
			} else if ($(this).attr('class')=="btn btn-info active") {
				$("table#twitter").find("tr").slice(-<?php echo $displayCounter-$limit; ?>).each(function(){
					$(this).toggleClass("hidden");//css('background-color', 'red');
				});
				$("#moarTweets").html('More&nbsp;<i class="icon-circle-arrow-down icon-white"></i>');
			}
			
//			$("#moarTweets").html('Less&nbsp;<i class="icon-circle-arrow-up"></i>');
		});
		</script>
		<?php	
	}
}