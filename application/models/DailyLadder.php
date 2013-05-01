<?php

class Application_Model_DailyLadder
{
	
	private $graph;
	
	/**
	 * @return the $graph
	 */
	public function getGraph() {
		return $this->graph;
	}

	public function __construct(array $options = null){
		/*
		$ladder = new Application_Model_DbTable_Ladder();
		$users = new Application_Model_DbTable_Accounts();
		
		$usersSelect = $users->select();
		$usersSelect->from($users, array('username','id'));
		$count = $users->fetchAll($usersSelect);
		$userCount = count($count);
		$users = $count->toArray();
				 
		$dateSelect = $ladder->select();
		$dateSelect->from($ladder, array('activityDate'))->distinct()->order('activityDate ASC');
		$dates = $ladder->fetchAll($dateSelect);
		 
		$dateCount = count($dates);
		 
		$lastDate = null;
		$graph = "['Date','ihu','aueb'],";
		 
		foreach ($dates as $date){
			$graph.="['".$date->activityDate."'";
			foreach ($users as $key=>$value){
				$dataSelect = $ladder->select();
				$dataSelect->from($ladder,array("earnedPoints"))->where("activityDate = ?",$date->activityDate)->where("userId = ?", $value['id']);
				$dataset = $ladder->fetchAll($dataSelect);
				if (count($dataset)==0) {
					$graph.=",0";
				} else {
					foreach ($dataset as $entry){
						$graph.= ",".$entry->earnedPoints;
					}
				}
				 
			}
			$graph.="],";
		}
		$graph = substr($graph,0,-1);
		*/
		
		$activity = new Application_Model_DbTable_Activity();
		$select = $activity->select();
		$select->from($activity)->order("userid ASC");
		$data = $activity->fetchAll($select);
		
		$datesSelect = $activity->select();
		$datesSelect->from($activity, array('date'))->distinct()->order("date ASC");
		$dates = $activity->fetchAll($datesSelect);
		$dateArray = array();
		foreach ($dates as $date){
			$dateArray[] = $date['date'];
		}
		
//		var_dump($dateArray);
		
		$users =  array();
		$currentID = null;
		$currentDate = null;
		$population = count($dateArray);
		$flipped_dateArray = array_flip($dateArray);
		//var_dump($flipped_dateArray);
		
		foreach ($data as $entry){
			
			$needle = $entry['date'];
			$currentID = $entry['userid'];
			$users[$currentID] = array_fill(0, $population, 0);
			
			if (isset($flipped_dateArray[$needle]) )
			{
				$users[$currentID][strval($flipped_dateArray[$needle])] = $entry['quantity'];
//				$users[$currentID][] = $entry['quantity'];
				
			} else {
			//	$users[$currentID][] = 0;
			}
			
			
	/*		
			if ($currentDate!=$entry['date']){
				$currentDate = $entry['date'];
			}
				$currentID = $entry['userid'];
				$users[$currentID][] = $entry['quantity'];
	*/
		}
		$jsUsers = array();
		foreach ($users as $user){
			$jsUsers[]= $this->getHtmlCode($user);
		}
		
		//$this->graph = $this->getHtmlCode($graph);	
		$this->graph = $jsUsers;	
	}

	private function getHtmlCode($vars) {
		
		$htmlCode = "<script type='text/javascript'>
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
		
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
		
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
		
        // Create the data table.
    	  var data = google.visualization.arrayToDataTable([
    	  ". $vars."]);
		
        // Set chart options
        var options = {'title':'Who is the best recycler? - Daily Activity',
                       'is3D': true};
		
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('dailyLadder'));
        chart.draw(data, options);
      }
    </script>
    <div id='dailyLadder'></div>
		 ";
		
		$newHtml = "";
		$js_array = json_encode($vars);
		return $js_array;
		//return $htmlCode;
	}
}

