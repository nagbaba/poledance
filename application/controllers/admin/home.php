<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function Home()
	{ 
		parent::__construct();
		$this->load->model('admin/homemodel','home',TRUE);
		$this->load->helper(array('form', 'url'));
		$this->load->helper('userfunctions');
	
		$this->load->library('template');
		$this->template->set_template('admin');
		
		$this->load->library('session');
	}
	
	// load index page
	function index() 
	{ 
		$this->load->view('admin/index');
	}
	
	// check admin login
	function checkadminlogin()
	{
		$loginname =  $_POST['loginname'];
		$password =  $_POST['password'];
		
		$chk_admin = $this->home->LoginCheck($loginname, $password);
		
		if(count($chk_admin) > 0)
		{
			$this->session->set_userdata('AdminICode', $chk_admin['AdminICode']);
			$this->session->set_userdata('LoginUserICode', $chk_admin['AdminICode']);
			$this->session->set_userdata('AdminEmailAddress', $chk_admin['EmailAddress']);
			$this->session->set_userdata('AdminName', $chk_admin['FirstName'].' '.$chk_admin['LastName']);
			$this->session->set_userdata('UserType', 'MA');
			echo 'Valid';
		}
		else
		{	
			echo 'Invalid';
		}
	}
	
	#logout function
	function logout()
	{
		session_destroy();  
		$path = base_url().'admin/';
		redirect($path);
	}
	
	#logout function
	function evenadminlogout()
	{
		session_destroy();  
		$path = base_url();
		redirect($path);
	}
	
	// load admin home page
	function homepage()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$this->template->write_view('contentpane','admin/home',FALSE,FALSE);
		$this->template->render();
	}
	
	// load event admin home page
	function eventadminhomepage()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$this->template->write_view('contentpane','admin/eventadminhome',FALSE,FALSE);
		$this->template->render();
	}
	
	// admin change password
	function changepassword()
	{
		if(!($this->session->userdata('UserType'))){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$this->template->write_view('contentpane','admin/changepassword',FALSE,FALSE);
		$this->template->render();
	}
	
	// change password
	function getchangepassword()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$AdminICode = $this->session->userdata('AdminICode');
		$OldPassword = $_POST['OldPassword'];
		$NewPassword = $_POST['NewPassword'];
		$checkOldPaswword = $this->home->getCheckThisOldAdminPassword($AdminICode, $OldPassword);
		if($checkOldPaswword != 0){
			// change the password and update in login credential table
			if($checkOldPaswword['Password'] == md5($NewPassword))
			{
				echo 'samePasswordNotAccepted';
			}
			else
			{
				$changepassword['Password'] = md5($NewPassword);
				$this->home->UpdateProcess('admin', $changepassword, 'AdminICode', $AdminICode);
				echo 'success';
			}
		}
		else{
			echo 'mismatch';
		}
	}
	
	// change password
	function getchangeeventadminpassword()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$UserKeyICode = $this->session->userdata('LoginUserICode');
		$OldPassword = $_POST['OldPassword'];
		$NewPassword = $_POST['NewPassword'];
		$LoginCredentialICode = $this->session->userdata('LoginCredentialICode');
		
		$checkOldPaswword = $this->home->getCheckThisOldUserPassword($LoginCredentialICode, $OldPassword);
		if($checkOldPaswword != 0){
			// change the password and update in login credential table
			if($checkOldPaswword['Password'] == md5($NewPassword))
			{
				echo 'samePasswordNotAccepted';
			}
			else
			{
				$changepassword['Password'] = md5($NewPassword);
				$this->home->UpdateProcess('login_credentials', $changepassword, 'LoginCredentialICode', $LoginCredentialICode);
				echo 'success';
			}
		}
		else{
			echo 'mismatch';
		}
	}
	
	// admin change email address
	function changemyprofile()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$WhereFieldValue = "AdminICode ='".$this->session->userdata('AdminICode')."'";
		$data['AdminDetails'] = $this->home->getAllDetailsFromId('admin', $WhereFieldValue);
		
		$this->template->write_view('contentpane','admin/changemyprofile', $data, FALSE);
		$this->template->render();
	}
	
	// change event admin profile
	function changeeventadminprofile()
	{
		if(!($this->session->userdata('UserType'))){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$EventAdminICode = $this->session->userdata('LoginUserICode');
		
		$FTField = "FT.*"; $STField = "ST.*"; 
		$OnCondition = "( FT.EventAdminICode = ST.UserKeyICode)";
		$WhereField = "ST.UserType = 'E' AND FT.IsDeleted = '0' AND FT.EventAdminICode = '".$EventAdminICode."'";
		$data['EventAdminDetails'] = $this->home->getAllDetailsFromIdFromBothTable('event_admin_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField);
			
		$this->template->write_view('contentpane','admin/changeeventadminprofile', $data, FALSE);
		$this->template->render();
	}
	
	// change password
	function getchangemyprofile()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$AdminICode = $this->session->userdata('AdminICode');
		$Upd['FirstName'] = $_POST['FirstName'];
		$Upd['LastName'] = $_POST['LastName'];
		$Upd['EmailAddress'] = $_POST['EmailAddress'];
		
		$WhereFieldValue = "EmailAddress = '".$_POST['EmailAddress']."' AND AdminICode != '".$this->session->userdata('AdminICode')."'";
		$checkOldPaswword = $this->home->checkThisFieldValueInTable('admin',  $WhereFieldValue);
		
		if($checkOldPaswword == '0')
		{
			$this->home->UpdateProcess('admin', $Upd, 'AdminICode', $AdminICode);
			echo 'success';	
		}
		else{ echo 'Exist';} 
	}
	
	// change the status active /or de-active
	function statuschange()
	{
		//if(!($this->session->userdata('UserType'))){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		$TableName 	 = 	$_POST['TableName'];
		$EditId 	 = 	$_POST['EditId'];
		$UpdateValue = 	$_POST['UpdateValue'];
		$Who 		 = 	$_POST['Who'];
		$EditFieldName = $_POST['EditFieldName'];
		$Url = base_url();
		
		switch($UpdateValue)
		{
			case(1):
					  $changestatus['IsActive'] = $UpdateValue;	
					  $this->home->UpdateProcess($TableName, $changestatus, $EditFieldName, $EditId);
					  $img = '<img src="'.base_url().'images/noaccept.png" border="0" onClick="StatusActive(\''.$TableName.'\', \''.$EditId.'\', 0, \''.$Who.'\', \''.$Url.'\', \''.$EditFieldName.'\');" style="cursor:pointer;" title="Activate">';
					  break;
					  
			case(0):
					  $changestatus['IsActive'] = $UpdateValue;	
					  $this->home->UpdateProcess($TableName, $changestatus, $EditFieldName, $EditId);
					  $img = '<img src="'.base_url().'images/accept.png" border="0" onClick="StatusActive(\''.$TableName.'\', \''.$EditId.'\', 1, \''.$Who.'\', \''.$Url.'\', \''.$EditFieldName.'\');" style="cursor:pointer;" title="Deactivate">';
					  break;
		}
		echo $img;
	}
	
	// load the section list when click the particule division name
	function loadsectiondropdown($DivisionICode)
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$DivisionICode = $DivisionICode;
                
       	$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND DivisionICode = '".$DivisionICode."'"; 
		$OrderFiledValue = "SectionName ASC";
		$SectionDetails = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
		
		$table = '<select name="SectionICode" id="SectionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="4" >
            <option value="" class="box_drop">Select Section Name</option>';
             if(count($SectionDetails) > 0 ){foreach($SectionDetails as $row){
           		$table .= '<option class="box_drop" value="'.$row['SectionICode'].'">'.$row['SectionName'].'</option>';
            } } else{ 
            $table .= '<option class="box_drop" value="">No Records Available</option>';
            }
           $table .= '</select>';
		
		echo $table;
	}
	
	// load the section list when click the particule division name for resultconfiguration
	function loadsectiondropdownforresultconfiguration()
	{
		$DivisionICode = $_POST['DivisionICode'];
		// get sectionicode for this division in array formate
		$WhereFieldValue = "DivisionICode= '".$DivisionICode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
		$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
		
		$table = '<select name="SectionICode" id="SectionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="4">
			  <option value="" class="box_drop">Select Section Name</option>';
			  
		if(!empty($AllSectionICode))
		{
			$AllSectionICode = implode(',', $AllSectionICode);
			$WhereFieldValue="SectionICode IN (".$AllSectionICode.") AND IsDeleted='0' AND IsActive='0'  AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; 
			$OrderFiledValue = "SectionName ASC";
			$SectionDetails = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
			
			if(count($SectionDetails) > 0 ){foreach($SectionDetails as $row){
			   $table .= '<option class="box_drop" value="'.$row['SectionICode'].'">'.$row['SectionName'].'</option>';
			   } } else{ 
					$table .= '<option class="box_drop" value="">No Records Available</option>';
				}
		}
		else
		{
			$table .= '<option class="box_drop" value="">No Records Available</option>';
		}
		 $table .= '</select>';
			
			echo $table;
	}
	function deleteresultconfigurationdata(){
	  	$DivisionICode = $_POST['DivisionICode'];
	   	$WhereFieldValue = "SessionValueForResConfig = '" . $this->session->userdata('SessionValueForResConfig')."' AND DivisionICode != '".$DivisionICode."'";
   		$checkOlddata= $this->home->checkThisFieldValueInTable('temp_resultconfig',  $WhereFieldValue);
		if($checkOlddata == '1')
		{
			$wherefield = "SessionValueForResConfig = '" . $this->session->userdata('SessionValueForResConfig')."' AND DivisionICode != '".$DivisionICode."'";
			$val = $this->home->permamnantDelete('temp_resultconfig', $wherefield);
			echo 'Exist'; exit;
		}
		else
		{
			echo 'Null';
		}
	}
	       
	// load the sub-section list when click the particule division name for resultconfiguration
	function loadsubsectiondropdownforresultconfiguration()
	{
		$SectionICode = $_POST['SectionICode'];
		$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND SectionICode = '".$SectionICode."'"; 
		$OrderFiledValue = "SubsectionName ASC";
		$SubsectionDetails = $this->home->getAllDetails('subsection_master', $WhereFieldValue, $OrderFiledValue);
		
		$table = '<select name="SubsectionICode" id="SubsectionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="4">
            <option value="" class="box_drop">Select Sub-section Name</option>';
             if(count($SubsectionDetails) > 0 ){foreach($SubsectionDetails as $row){
                $table .= '<option class="box_drop" value="'.$row['SubsectionICode'].'">'.$row['SubsectionName'].'</option>';
            } } else{ 
                $table .= '<option class="box_drop" value="">No Records Available</option>';
            }
        $table .= '</select>';
		echo $table;
	}
	
	// load competitor for the particular division
	function loadcompetitordropdown1()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		?>
		<script type="text/javascript">
		$(document).ready( function() {
		$("#CompetitorICode").multiSelect({ selectAllText: 'Select All' });
		});
		</script>
		
		<?php 
		$DivisionICode = $_POST['DivisionICode'];
		$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND DivisionICode = '".$DivisionICode."'"; 
		$OrderFiledValue = "FullName ASC";
		$CompetitorDetails = $this->home->getAllDetails('competitor_master', $WhereFieldValue, $OrderFiledValue);
		
		if(count($CompetitorDetails) > 0 ){
			$table =   '<select name="CompetitorICode" id="CompetitorICode" class="multiSelect" style="width:264px;line-height:25px;" tabindex="14">
        			<option class="box_drop" value="">Select </option>';
					foreach($CompetitorDetails as $row){
				$table .=   '<option class="box_drop" value="'.$row['CompetitorICode'].'">'.$row['FullName'].'</option>';
					}
				$table .='</select>';
         }
		 else
		 {
		 $table = '<input type="text" value="No Competitor Available" onkeypress="enterPage(\'addnewcompetitionbutton\', event);"  class="tb3" style="width:280px; margin-top:7px;" tabindex="16" name="sss" id="sss" readonly="readonly"/>';
		 }
		 
		 echo $table;
			
	}
	
	function loadcompetitordropdown()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$DivisionICode = $_POST['DivisionICode'];
		
		if(!empty($DivisionICode))
		{
			$WhereFieldValue = "DivisionICode IN (".$DivisionICode.") AND IsDeleted ='0'"; 
			$OrderFiledValue = "FullName ASC";
			$CompetitorDetails = $this->home->getAllDetails('competitor_master', $WhereFieldValue, $OrderFiledValue);
		}
		else
		{
			$CompetitorDetails = '';	
		}
		
		$table = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		if(!empty($CompetitorDetails) > 0 )
		{
			$Cnt = count($CompetitorDetails);
			$table .= '<tr>
			<td width="8%" align="left"><input type="checkbox" name="chckHead" id="chckHead" value="" onclick="toggleChecked(this.checked);"/></td>
			<td width="71%" align="left"><span class="box_title" style="font-weight:bold;">Competitor Name</span></td>
			<td width="21%" align="left"><span class="box_title" style="font-weight:bold;">Order</span><input type="hidden" name="TotalCheckBox" value="'.$Cnt.'" id="TotalCheckBox"><input type="hidden" name="SelectOrder" value="" id="SelectOrder"></td>
			</tr>';
			
			$z=0;
			foreach($CompetitorDetails as $row)
			{
				$table .= '<tr>
				<td align="left" height="28px;"><input type="checkbox" name="CompetitorICode[]" id="CompetitorICode'.$z.'" value="'.$row['CompetitorICode'].'_'.$z.'" class="checkbox" tabindex="15" onclick="chkMainBox();"/></td>
				<td align="left"><span class="box_title">'.getMaxFieldLength(ucwords($row['FullName']), 23).'</span></td>
				<td align="left">
					<select class="simpledrop" name="OrderList'.$z.'" id="OrderList'.$row['CompetitorICode'].'" tabindex="16"><option value="">Order</option>';
					for($i=1; $i <= $Cnt; $i++){
					$table .= '<option value="'.$i.'">'.$i.'</option>';}
					$table .= '</select></td>
				</tr>';
				$z++;
			}
		}
		else
		{
			$table .= '<tr>
			<td><span class="box_title">No Records</span></td>
			</tr>';
		}
		
		$table .= '</table>';
		echo $table;
	}
	
	function loadcompetitorforeditcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$DivisionICode = $_POST['DivisionICode'];
		
		if(!empty($DivisionICode))
		{
			$WhereFieldValue = "DivisionICode IN (".$DivisionICode.") AND IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; 
			$OrderFiledValue = "FullName ASC";
			$CompetitorDetails = $this->home->getAllDetails('competitor_master', $WhereFieldValue, $OrderFiledValue);
		}
		else
		{
			$CompetitorDetails = '';	
		}
		$CompetitionICode =1;
		$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
		$CompetitorICode = $this->home->getAllIdInArrayFormate('competition_competitor', $WhereFieldValue, 'CompetitorICode');
		$CcompetitorArray = $CompetitorICode;
		
		$table = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		if(!empty($CompetitorDetails) > 0 )
		{
			$Cnt = count($CompetitorDetails);
			$table .= '<tr>
			<td width="8%" align="left"><input type="checkbox" name="chckHead" id="chckHead" value="" onclick="toggleChecked(this.checked)"/></td>
			<td width="71%" align="left"><span class="box_title" style="font-weight:bold;">Competitor Name</span></td>
			<td width="21%" align="left"><span class="box_title" style="font-weight:bold;">Order</span><input type="hidden" name="TotalCheckBox" value="'.$Cnt.'" id="TotalCheckBox"><input type="hidden" name="SelectOrder" value="" id="SelectOrder"></td>
			</tr>';
			
			$z=0;
			foreach($CompetitorDetails as $row)
			{
				$SingleWhere = "CompetitorICode = '".$row['CompetitorICode']."' AND CompetitionICode = '".$CompetitionICode."'";
				$TCnt = $this->home->getTotalCountOfRecords('competition_competitor', $SingleWhere);
				if($TCnt > 0)
				{
					$val = $this->home->getSingleFieldValue('competition_competitor', 'CompetitorOrder', $SingleWhere);
				}
				else
				{
					$val = '';
				}
				
				if(in_array($row['CompetitorICode'], $CcompetitorArray)) {$Sel =  "checked";} else{$Sel =  "";}
				
				$table .= '<tr>
				<td align="left" height="28px;"><input type="checkbox" name="CompetitorICode[]" id="CompetitorICode'.$z.'" value="'.$row['CompetitorICode'].'_'.$z.'" class="checkbox" tabindex="15" '.$Sel.' onclick="chkMainBox();"/></td>
				<td align="left"><span class="box_title">'.getMaxFieldLength(ucwords($row['FullName']), 23).'</span></td>
				<td align="left">
					<select class="simpledrop" name="OrderList'.$z.'" id="OrderList'.$z.'" tabindex="16"><option value="">Order</option>';
					for($i=1; $i <= $Cnt; $i++)
					{ 
						if($val == $i){$VSel =  "selected";} else{$VSel =  "";}
						$table .= '<option value="'.$i.'" '.$VSel.'>'.$i.'</option>';
					}
						$table .= '</select></td>
				</tr>';
				$z++;
			}
		}
		else
		{
			$table .= '<tr>
			<td><span class="box_title">No Records</span></td>
			</tr>';
		}
		
		$table .= '</table>';
		echo $table;
	}


}
