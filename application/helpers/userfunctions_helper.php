<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

#Maximum Execution Time
ini_set("max_execution_time",60); 

// get dody id
function getbodyid($PageName)
{
	$PageName = strtolower($PageName);
	if($PageName == 'home')
	{
		return 'home';	
	}
	else
	{
		return 'inner';	
	}
}

function getMaxFieldLength($FieldValue, $Flength)
{
	$len = strlen($FieldValue);
	if($len > $Flength){ $fv = substr($FieldValue, 0, $Flength); return  $fv.'...';}else{ return  $FieldValue;}
}

// load page title for all pages
function getPageTitle($PageTitleICode)
{
	$query = "SELECT PT.PageTitleName, PM.PageMessage FROM page_title AS PT LEFT JOIN page_message AS PM on (PT.PageTitleICode = PM.PageTitleICode) WHERE PT.PageTitleICode = '".$PageTitleICode."' ";	
	$exe = mysql_query($query);
	$row = mysql_fetch_array($exe);
	return  $row;
}

#User Status
function getUserStatus($Status, $TableName, $EditId, $Who, $EditFieldName)
{
	$Url = base_url();
		
	switch($Status)
	{
		case(0):
				$img = '<img src="'.base_url().'images/accept.png" border="0" onClick="StatusActive(\''.$TableName.'\', \''.$EditId.'\', 1, \''.$Who.'\', \''.$Url.'\', \''.$EditFieldName.'\');" style="cursor:pointer;" title="Deactivate">';
				break;
		case(1):
				$img = '<img src="'.base_url().'images/noaccept.png" border="0" onClick="StatusActive(\''.$TableName.'\', \''.$EditId.'\', 0, \''.$Who.'\', \''.$Url.'\', \''.$EditFieldName.'\');" style="cursor:pointer;" title="Activate">';
				break;
	}
	return  $img;
}

// display user type
function getUserType($Type)
{
	if($Type == 'E'){echo 'Event Admin';}elseif($Type == 'J'){echo 'Judges';}else{echo 'Competitor';}
}

// date display
function getDateDisplay($Ddate)
{
	echo date('d-m-Y', strtotime($Ddate));
}


//left menu scc
function getleftMenuCss($page)
{
	$query = "SELECT * FROM menu WHERE pagename = '$page'";	
	$exe = mysql_query($query);
	$row = mysql_fetch_array($exe);
	return  $row;
}

//array rearrange
function rearrange($array1)
{
	$Cnt = count($array1);
	$TCnt = $Cnt-1;

	$array2 = array();
	for($i=0; $i<$Cnt; $i++)
	{
		if($i == 0)
		{
			$array2Key = $TCnt;
		}
		else
		{
			$array2Key = $i-1;
		}
		$array2[$array2Key] = $array1[$i];
	}
	return $array2;
}

// dyas array list
function createDateRangeArray($start, $end) {
$range = array();

if (is_string($start) === true) $start = strtotime($start);
if (is_string($end) === true ) $end = strtotime($end);

if ($start > $end) return createDateRangeArray($end, $start);

do {
$range[] = date('Y-m-d', $start);
$start = strtotime("+ 1 day", $start);
}
while($start <= $end);

return $range;
}

#---- DISPLAY CHAMPIONSHIP NAME
function getChampionShipName($CompetitionICode)
{
	switch($CompetitionICode)
	{
		case('1'):
					$ChanmpName = "Ultimate";
					break;
		case('2'):
					$ChanmpName = "Pole Fit";
					break;
		case('3'):
					$ChanmpName = "Pole Art";
					break;
		case('4'):
					$ChanmpName = "Pole Fit Runner";
					break;
		case('5'):
					$ChanmpName = "Pole Art Runner";
					break;
	}
	return $ChanmpName;
}
#---- DISPLAY CHAMPIONSHIP NAME
?>