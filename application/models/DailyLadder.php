<?php

class Application_Model_DailyLadder
{
	
	private $graph;
	private $usernames;
	private $dates;
	
	/**
	 * @return the $graph
	 */
	public function getGraph() {
		return $this->graph;
	}
	
	public function getUsernames(){
		return $this->usernames;
	}
	
	public function getDates(){
		return $this->dates;
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
		$query = $activity->select();
		$query->from(array('act' => 'activity'), array('id', 'userid','quantity','date'));
		$query->join(array('acc' => 'accounts'), 'act.userid = acc.id', array("id","username"));
		$query->order('act.date ASC');
		$query->setIntegrityCheck(false);
		
		//$activity = new Application_Model_DbTable_Activity();
		//$select = $activity->select();
		//$select->from($activity)->order("userid ASC");
		//$data = $activity->fetchAll($select);
		$data = $activity->fetchAll($query);
		
		//$datesSelect = $activity->select();
		//$datesSelect->from($activity, array('date'))->distinct()->order("date ASC");
		//$dates = $activity->fetchAll($datesSelect);
		
		$dateArray = array();
		$prevDate = null;
		$i=0;
		foreach ($data as $date){
			if ($prevDate!=$date['date']){
				$prevDate = $date['date'];
				$dateArray[$i] = $date['date'];
				$i++;
			}
		}
		$this->dates = $dateArray;
		
		$flipped_dateArray = array_flip($dateArray);
		$population = count($flipped_dateArray);
		
		$users =  array();
		$currentID = null;
		$currentDate = null;
		$usernames = array();
		//var_dump($flipped_dateArray);
		foreach ($data as $entry){
			$currentID = $entry['userid'];
			$users[$currentID] = array_fill(0, $population, 0);
		}
		
		$i=0;
		$prevUser = null;
		foreach ($data as $entry){
			$currentID = $entry['userid'];
			$needle = $entry['date'];
			if ($prevUser!= $currentID) {
				$users[$currentID][$flipped_dateArray[$needle]] = $entry['quantity'];
				$usernames[$currentID] = $entry['username'];
			} else {
				$users[$currentID][$flipped_dateArray[$needle]] += $entry['quantity'];
			}
		$i++;	
		}
		$jsUsers = array();
		foreach ($users as $user){
			$jsUsers[]= $this->getHtmlCode($user); //transform to Javascript Array
			
		}
		$this->usernames = $usernames;
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

