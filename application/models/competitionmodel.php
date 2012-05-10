<?php 
class competitionmodel extends CI_Model
{
	
    function __construct()
    {
        parent::__construct();
    }
	// get competition competitor name lsit
	function getCompetitionCompetitor($CompetitionICode)
	{
		//this code is edited by bernazzyk to get the value -  edit date: 28-04-12
		
		$this->db->select('T1.CompetitorICode, T1.CompetitionCompetitorICode, T1.CompetitorOrder, T1.DivisionICode, T2.FullName');
		
		//this code is edited by bernazzyk
		
		$this->db->from('competition_competitor AS T1');
		$this->db->join('competitor_master AS T2', 'T1.CompetitorICode = T2.CompetitorICode', 'left');	
		$this->db->where('T1.CompetitionICode', $CompetitionICode);
		$this->db->order_by("T1.CompetitorOrder", "asc"); 
		$query = $this->db->get();
		if ($query->num_rows() > 0){			
			return $row = $query->result_array();
		}else{
			return false;
		}

	}
	
	//  get competition first competitor name lsit
	function getFirstCompetitionCompetitor($CompetitionICode)
	{
		$this->db->select('T1.CompetitorICode, T1.CompetitionCompetitorICode');
		$this->db->from('competition_competitor AS T1');
		$this->db->join('competitor_master AS T2', 'T1.CompetitorICode = T2.CompetitorICode', 'left');	
		$this->db->where('T1.CompetitionICode', $CompetitionICode);
		$this->db->order_by("T1.CompetitorOrder", "asc"); 
		$this->db->limit(1, 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row['CompetitionCompetitorICode'];
		}else{
			return false;
		}	
	}
	
	// get Title details
	function getTitleDetails($CompetitionCompetitorICode)
	{
		$this->db->select('T1.CompetitorICode, T1.CompetitorOrder, T2.FullName, T2.embed_code, T2.video, T2.ProfileImage, T3.DivisionName, T3.DivisionICode');
		$this->db->from('competition_competitor AS T1');
		$this->db->join('competitor_master AS T2', 'T1.CompetitorICode = T2.CompetitorICode', 'left');	
		$this->db->join('division_master AS T3', 'T1.DivisionICode = T3.DivisionICode', 'left');	
		$this->db->where('T1.CompetitionCompetitorICode', $CompetitionCompetitorICode);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){			
			return $row = $query->row_array();
		}
	}
	
	// get competition divisions
	function competitionDivisions($CompetitionICode)
	{
		$DICodes = array();
		$this->db->distinct();
		$this->db->select('DivisionICode');
		$this->db->from("competition_competitor");
		$this->db->where('CompetitionICode', $CompetitionICode);
		$result = $this->db->get();
		if($result->num_rows()>0)
		{
			foreach($result->result_array() as $v)
			{
				$DICodes[] = $v['DivisionICode'];
			}
		}
		$result = $DICodes;
		return  $result;	
	}  
	
	function maxScoreCompetitor($CompetitionICode, $ChampionshipICode, $DivisionICode)
	{
		$query = $this->db->query("SELECT CompetitionCompetitorICode, TotalSecuredScore FROM competitor_result_score WHERE CompetitionICode = '".$CompetitionICode."' AND ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' AND ChampionOn = '0' ORDER BY TotalSecuredScore desc limit 0,1");
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row['CompetitionCompetitorICode'];
		}
	}
	
	//getMaxScoreInParticularCompetition
	function getMaxScoreInParticularCompetition($CompetitionICode, $ChampionshipICode, $DivisionICode)
	{
		$query = $this->db->query("SELECT CompetitionCompetitorICode FROM competitor_result_score WHERE CompetitionICode = '".$CompetitionICode."' AND ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' AND ChampionOn = '".$ChampionshipICode."' AND TotalSecuredScore != '0' limit 0,1");
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row['CompetitionCompetitorICode'];
		}
	}
	
	//getCompetitionCompetitorICodeForThisCompetitionChanmpion
	function getCompetitionCompetitorICodeForThisCompetitionChanmpion($CompetitionICode, $ChampionshipICode, $DivisionICode)
	{
		$CCICodes = array();
		$query = $this->db->query("SELECT DISTINCT CompetitionCompetitorICode FROM competitor_result_score WHERE CompetitionICode = '".$CompetitionICode."' AND ChampionOn = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' ");
		if ($query->num_rows() > 0){
			foreach($query->result_array() as $v)
			{
				$CCICodes[] = $v['CompetitionCompetitorICode'];
			}
			$result = $CCICodes;
			return  $result;
		}
	}
	
	function getCompetitionChampionName($CompetitionCompetitorICode)
	{
		$CompName = '';
		$query = $this->db->query("SELECT M.FullName FROM competition_competitor AS C LEFT JOIN competitor_master AS M ON (C.CompetitorICode = M.CompetitorICode) WHERE C.CompetitionCompetitorICode IN (".$CompetitionCompetitorICode.")");
		if ($query->num_rows() > 0)
		{
			foreach($query->result_array() as $v)
			{
				if($CompName == '')
				{
					$CompName = $v['FullName'];
				}
				else
				{
					$CompName = $CompName.', '.$v['FullName'];
				}
				
			}
			return  $CompName;
		}
	}

/*	//getMaxSecuredCompetitorName
	function getMaxSecuredCompetitorName($CompetitionCompetitorICode)
	{
		$this->db->select('T2.FullName');
		$this->db->from('competition_competitor AS T1');
		$this->db->join('competitor_master AS T2', 'T1.CompetitorICode = T2.CompetitorICode', 'left');	
		$this->db->where('T1.CompetitionCompetitorICode', $CompetitionCompetitorICode);
		$query = $this->db->get();
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row['FullName'];
		}	
	}*/
	
	// get judge competitions
	function getjudgecompetitions($JudgesICode)
	{
		$DICodes = array();
		$this->db->distinct();
		$this->db->select('CompetitionICode');
		$this->db->from("competition_judges");
		$this->db->where('JudgesICode', $JudgesICode);
		$result = $this->db->get();
		if($result->num_rows()>0)
		{
			foreach($result->result_array() as $v)
			{
				$DICodes[] = $v['CompetitionICode'];
			}
		}
		$result = $DICodes;
		return  $result;	
	}
	
	#---- GET MAXIMUM SCORE
	function getMaximumScoreFromCompetition($CompetitionICode, $DivisionICode, $ChampionshipICode)
	{
		$this->db->select_max('TotalSecuredScore', 'MScore');
		$this->db->from("competitor_result_score");
		$this->db->where('CompetitionICode', $CompetitionICode);
		$this->db->where('ChampionshipICode', $ChampionshipICode);
		$this->db->where('DivisionICode', $DivisionICode);
		$this->db->where('ChampionOn', 0);
		$this->db->limit(1, 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row['MScore'];
		}
		
	}
}	

?>