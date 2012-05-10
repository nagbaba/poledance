<?php 
class homemodel extends CI_Model
{
	
    function __construct()
    {
        parent::__construct();
    }
	
	// check user from db
	function LoginCheck($TableName, $EmailAddress, $Password, $UserType)
	{
		$sql = "SELECT * FROM ".$TableName." WHERE EmailAddress = '".$EmailAddress."' AND Password = '".md5($Password)."' AND UserType = '".$UserType."'"; 
    	$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->row_array(); 
		}
		else
		{
			return FALSE;
		}
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
	
	// get Create Schedule Status
	function getSingleFieldValue($tablename, $FieldName, $SingleWhere)
	{
		$query = $this->db->query("SELECT ".$FieldName." FROM ".$tablename." WHERE ".$SingleWhere);
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
       		return $row[$FieldName];
		}
    }
	
	// get detail from both table
	function getAllDetailsFromIdFromBothTable($FirstTable, $SecondTable, $FTField, $STField, $OnCondition, $WhereField, $OrderFiledValue)
	{
		$query = $this->db->query("SELECT ".$FTField.", ".$STField." FROM ".$FirstTable." AS FT LEFT JOIN ".$SecondTable." AS ST ON ".$OnCondition." WHERE ".$WhereField." ORDER BY ".$OrderFiledValue."");
		if ($query->num_rows() > 0){			
			return $row = $query->row_array();
		}else{
			return false;
		}	
	}
	
	//check this field value is already exist in table
	function checkThisFieldValueInTable($TableName,  $WhereFieldValue)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ");	
		
		if ($query->num_rows() > 0){ return 1; }else{ return 0; }
	}
	
	// get particular fields in table
	function getParticularResults($TableName, $Fields, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT DISTINCT ".$Fields." FROM ".$TableName." WHERE ".$WhereFieldValue."");
		if ($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else{ return false;}
	}
	
	// get total count in table
	function getTotalCountOfRecords($TableName, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ");
		return $query->num_rows();
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
	
	// permanant delete
	function permamnantDelete($tablename, $wherefield )
	{
		$sql = "DELETE FROM ".$tablename." WHERE ".$wherefield;
		mysql_query($sql);	
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
	
	// sum particular field in table
	function getSumOfParticularFieldFromId($TableName, $FieldName, $WhereFieldValue)
	{
		$query = $this->db->query("SELECT SUM(".$FieldName.") AS ".$FieldName." FROM ".$TableName." WHERE ".$WhereFieldValue."");
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row[$FieldName];
		}else{
			return false;
		}	
	}
	
	//getMaxScoreInParticularCompetition
	function getMaxScoreInParticularCompetition($CompetitionICode)
	{
		$query = $this->db->query("SELECT CompetitionCompetitorICode FROM competition_competitor WHERE TotalSecuredScore = ( SELECT MAX(TotalSecuredScore) FROM competition_competitor WHERE CompetitionICode = '".$CompetitionICode."') ");
		if ($query->num_rows() > 0){			
			$row = $query->row_array();
			return $row['CompetitionCompetitorICode'];
		}
	}

	function GetAllData($tablename,$codition='',$order='',$limit=''){
		if( $order=='' ){
			$str_order = '' ;
		}else{
			$str_order = ' order by '.$order ;
		}
		if( $codition=='' ){
			$sql = 'SELECT * from '.$tablename.$str_order;
		}else{
			$sql = 'SELECT * from '.$tablename . ' where '.$codition.$str_order;
		}
		if( $limit!='' ){
			$sql .= ' limit '.$limit;
		}
		//echo $sql;
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}
	
	function GetInfoByID($id,$tablename,$idcloname){
		$query = $this->db->get_where($tablename, array($idcloname => $id));
		$res = $query->result_array();
		return $res[0];
	}
	
	function isResultPosted($TableName, $WhereFieldValue)
	{
	        $query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue."");
                if ($query->num_rows() > 0){			
			return true;
		}else{
			return false;
		}	
	}
	
	function hasApplied($TableName, $WhereFieldValue)
	{
	        $query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue."");
			
                if ($query->num_rows() > 0){			
			return 'true';
		}else{
			return 'false';
		}	
	}
	
	function getOrderOfLastCompetitor($CompetitionICode,$DivisionICode)
	{
	        $query = $this->db->query("SELECT MAX(CompetitorOrder) as highest_order FROM competition_competitor where CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."'");
			
                if ($query->num_rows() > 0){			
			return $query->row_array();
		}else{
			return 'false';
		}	
	}
	
	function isEmailExist($TableName,$Email)
	{
	        $query = $this->db->query("SELECT * FROM ".$TableName." WHERE EmailAddress='".$Email."'");
                if ($query->num_rows() > 0){			
			return true;
		}else{
			return false;
		}	
	}
	
	function isValueExist($TableName, $WhereFieldValue)
	{
	        $query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue."");
			
                if ($query->num_rows() > 0){			
			return 'true';
		}else{
			return 'false';
		}	
	}
	
	//edited by 4axiz
	
//check this field value is already exist in table
	function checkThisFieldValueInTableAndReturnICode($TableName,  $WhereFieldValue, $FieldName)
	{
		$query = $this->db->query("SELECT * FROM ".$TableName." WHERE ".$WhereFieldValue." ");	
		
		if ($query->num_rows() > 0){ $row = $query->row_array(); return $row[$FieldName]; }else{ return 0; }
	}
}	


?>