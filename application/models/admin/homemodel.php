<?php 
class homemodel extends CI_Model
{
	
    function __construct()
    {
        parent::__construct();
    }
	
	// check user from db
	function LoginCheck($loginname, $password)
	{
		$sql = "SELECT * FROM admin WHERE EmailAddress = '".$loginname."' AND Password = '".md5($password)."'"; 
    	        $query = $this->db->query($sql);
		$row = $query->row_array(); 
		return $row;
	}
	
	// check password this password is available /or not
	function getCheckThisOldAdminPassword($AdminICode, $OldPassword)
	{
		$Password = md5($OldPassword);
		$query = $this->db->query("SELECT * FROM admin WHERE Password = '".$Password."' AND AdminICode = '".$AdminICode."' ");	
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return 0;
		}
	}
	
	// check password this password is available /or not
	function getCheckThisOldUserPassword($LoginCredentialICode, $OldPassword)
	{
		$Password = md5($OldPassword);
		$query = $this->db->query("SELECT * FROM login_credentials WHERE Password = '".$Password."' AND LoginCredentialICode = '".$LoginCredentialICode."'");	
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return 0;
		}
	}
	
	// get particular fields in table
	function getParticularResults($TableName, $Fields, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT ".$Fields." FROM ".$TableName." WHERE ".$WhereFieldValue."");
		if ($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else{ return false;}
	}
	
	// get all details from particular id
	function getParticularResultsFromId($TableName, $Fields, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT ".$Fields." FROM ".$TableName." WHERE ".$WhereFieldValue."");
		if ($query->num_rows() > 0)
		{			
			return $query->row_array();
		}
		else{ return false;}
	}
	
	//Inser into Database
	function InsertQuery($tbl,$data)
	{
		if($this->db->insert($tbl,$data))
		{
			return $this->db->insert_id();
		}
	}
	
	//Update Process
	function UpdateProcess($tbl,$data,$field,$ID)
	{
		$this->db->where($field,$ID);
		$this->db->update($tbl,$data); 
	}
	
	//update physician schedule days
	function UpdateProcessUsingMultifield($tbl, $set, $wherefield)
	{
		$query = "UPDATE ".$tbl." SET  ".$set." WHERE ".$wherefield;
		$exe = mysql_query($query);
	}
	
	// get all details from db
	function getAllDetails($TableName, $WhereFieldValue, $OrderFiledValue)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ORDER BY ".$OrderFiledValue." ");
		if ($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
	}
	
	// get total count in table
	function getTotalCountOfRecords($TableName, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ");
		return $query->num_rows();
	}
	
	// get all details from both table
	function getAllDetailsFromBothTable($FirstTable, $SecondTable, $FTField, $STField, $OnCondition, $WhereField, $OrderFiledValue)
	{
		$query = $this->db->query("SELECT ".$FTField.", ".$STField." FROM ".$FirstTable." AS FT LEFT JOIN ".$SecondTable." AS ST ON ".$OnCondition." WHERE ".$WhereField." ORDER BY ".$OrderFiledValue."");
		if ($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
	}
	
	// get detail from db using id
	function getAllDetailsFromId($TableName, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue."");
		if ($query->num_rows() > 0){			
			return $row = $query->row_array();
		}else{
			return false;
		}	
	}
	
	// get all id's in array formate for the particular mention field from the mentioned table
	function getAllIdInArrayFormate($TableName, $WhereFieldValue, $fieldname)
	{
		$FICodes = array();
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue."");
		if ($query->num_rows() > 0)
		{
	      	foreach($query->result_array() as $v)
			{
				$FICodes[] = $v[$fieldname];
			}
		}
		$result = $FICodes;
		return  $result;
	}
	
	// get detail from both table
	function getAllDetailsFromIdFromBothTable($FirstTable, $SecondTable, $FTField, $STField, $OnCondition, $WhereField)
	{
		$query = $this->db->query("SELECT ".$FTField.", ".$STField." FROM ".$FirstTable." AS FT LEFT JOIN ".$SecondTable." AS ST ON ".$OnCondition." WHERE ".$WhereField."");
		if ($query->num_rows() > 0){			
			return $row = $query->row_array();
		}else{
			return false;
		}	
	}
	
	// get detail from both table
	function getAllListDetailsFromBothTable($FirstTable, $SecondTable, $FTField, $STField, $OnCondition, $WhereField)
	{
		$query = $this->db->query("SELECT ".$FTField.", ".$STField." FROM ".$FirstTable." AS FT LEFT JOIN ".$SecondTable." AS ST ON ".$OnCondition." WHERE ".$WhereField."");
		if ($query->num_rows() > 0){			
			return $row = $query->result_array();
		}else{
			return false;
		}	
	}
	
	// get Create Schedule Status
	function getSingleFieldValue($tablename, $FieldName, $SingleWhere)
	{
		$query = $this->db->query("SELECT ".$FieldName." FROM ".$tablename." WHERE ".$SingleWhere);
		$row = $query->row_array();
		return $row[$FieldName];	
	}
	
	//check this field value is already exist in table
	function checkThisFieldValueInTable($TableName,  $WhereFieldValue)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ");	
		
		if ($query->num_rows() > 0){ return 1; }else{ return 0; }
	}
	
	//check this field value is already exist in table
	function checkThisFieldValueInTableAndReturnICode($TableName,  $WhereFieldValue, $FieldName)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ");	
		
		if ($query->num_rows() > 0){ $row = $query->row_array(); return $row[$FieldName]; }else{ return 0; }
	}
	
	// permanant delete
	function permamnantDelete($tablename, $wherefield )
	{
		$sql = "DELETE FROM ".$tablename." WHERE ".$wherefield;
		mysql_query($sql);	
	}
	
	// sum of certain field value
	function getSumOfValue($TableName, $FieldName, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT SUM(".$FieldName.") AS TotalValue FROM ".$TableName." WHERE ".$WhereFieldValue." ");	
		
		if ($query->num_rows() > 0){ $row = $query->row_array(); return $row['TotalValue']; }else{ return 0; }
	}
	
	//check start comepetition exist
	function checkstartcompetition($competitionid)
	{
		if($competitionid != '')
		{
			$query = $this->db->query("SELECT * FROM competition_competitor WHERE IsStarted = '1' AND CompetitionCompetitorICode = '$competitionid' ");	
		}
		if ($query->num_rows() > 0){			
			return 1;
		}else{
			return 0;
		}
	}
	
	// get all selected division
	function getAllSelectedDivision($CompetitionICode)
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
        
	
}	

?>