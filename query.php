<?php
	// MySQL Settings
	$db_host 		= 'localhost';	// server to connect to.	
	$db_user 		= 'bernazzy_epole';	// mysql username to access the database with.
	$db_pass 		= '%JN=2Fh;=xoo';	// mysql password to access the database with.
	$db_database 	= 'bernazzy_epole';	// the name of the database.
	
	// Connect to the database
	mysql_connect ($db_host, $db_user, $db_pass) or die ('Could not connect to the database.');
	mysql_selectdb ($db_database) or die ('Could not select database.');
	
	
	$sql = "SELECT * FROM `competition_competitor` WHERE `CompetitionICode` = '37'";
	
	$query = mysql_query($sql);
	
	$all_competitors = array();
	$all_competitors_query = '';
	
	while ($val = mysql_fetch_array($query)){
	
		$all_competitors[] = $val["CompetitionCompetitorICode"];
		
		$all_competitors_query .= $val["CompetitionCompetitorICode"] . ',';
	
	}
	
	var_dump($all_competitors);
	
	$all_competitors_query = substr($all_competitors_query, 0, strlen($all_competitors_query) - 1);


	
	echo $all_competitors_query;
	
	
	$sql2 = "SELECT * FROM `competitor_result` WHERE `CreatedBy` = '1' AND `CompetitionCompetitorICode` IN ( $all_competitors_query ) GROUP BY `CompetitionCompetitorICode`";
	
	$query2 = mysql_query($sql2);

	
	$nr_competitors_results = mysql_num_rows($query2);
	
	if ($nr_competitors_results > 0){

		$all_competitors_results = array();
		
		while ($val2 = mysql_fetch_array($query2)){
		
			$all_competitors_results[] = $val2["CompetitionCompetitorICode"];
		
		}
		
		echo '<br>----------------<br>';
		
		var_dump($all_competitors_results);
		
		$next_competitors = array_diff($all_competitors, $all_competitors_results);
		print_r($next_competitors);
		
		if (count($next_competitors)> 0 ){
		
			echo '<br>----------------<br>';
			var_dump($next_competitors);
			
			
			$next_competitor = current($next_competitors);
			echo '<br>----------------<br>';
			var_dump($next_competitor);
		}
		else{
			$next_competitor = current($all_competitors);
			echo '<br>----------------<br>';
			var_dump($next_competitor);
		}
	}
	else{
		$next_competitor = current($all_competitors);
		echo '<br>----------------<br>';
		var_dump($next_competitor);
	}
	
?>