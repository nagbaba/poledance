<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function User()
	{ 
		parent::__construct();
		$this->load->model('admin/homemodel','home',TRUE);
		
		$this->load->helper(array('form', 'url'));
		$this->load->helper('userfunctions');
	
		$this->load->library('template');
		$this->template->set_template('admin');
		
		$this->load->library('session');
	}
	
	// load manage user file 
	function manageeventadmin()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$FTField = "FT.*"; $STField = "ST.EmailAddress"; 
		$OnCondition = "( FT.EventAdminICode = ST.UserKeyICode)";
		$WhereField = "ST.UserType = 'E' AND FT.IsDeleted = '0'"; $OrderFiledValue = "FT.FullName ASC";
		$data['EventAdminDetails'] = $this->home->getAllDetailsFromBothTable('event_admin_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField, $OrderFiledValue);

		$this->template->write_view('contentpane','admin/manageeventadmin', $data, FALSE);
		$this->template->render();
	}
	
	// load add user page and insert user
	function addeventadmin()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'insert')
		{
			$eventadmin['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$eventadmin['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$eventadmin['FullName'] 		= $eventadmin['FirstName']." ".$eventadmin['LastName'];
			$eventadmin['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$eventadmin['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$eventadmin['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$eventadmin['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$eventadmin['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$eventadmin['EventName'] 		= mysql_escape_string(trim($this->input->post('EventName')));
			$eventadmin['Bio'] 				= addslashes($this->input->post('Bio'));
			$eventadmin['CreatedBy'] 		= $this->session->userdata('AdminICode');
			$eventadmin['CreatedUserType'] 	= $this->session->userdata('UserType');
			$eventadmin['CreatedDate'] 		= date('Y-m-d H:i:s');
			
			$EventAdminICode = $this->home->InsertQuery('event_admin_master', $eventadmin);
			
			$eventadminlogin['UserKeyICode']= $EventAdminICode;
			$eventadminlogin['UserType'] 	= 'E';
			$eventadminlogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$eventadminlogin['Password'] 	= md5(trim($this->input->post('Password')));
			
			$lastInsertId = $this->home->InsertQuery('login_credentials', $eventadminlogin);
			
			// profile image upload
			$config['upload_path'] = './uploads/EventadminImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			//$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
		        $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('ProfileImage'))
			{
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileImage['ProfileImage'] = $val['file_name'];
					$this->home->UpdateProcess('event_admin_master', $ProfileImage, 'EventAdminICode', $EventAdminICode);
				}
			}
			
			$path = base_url(); redirect(base_url().'admin/user/manageeventadmin/');
		}
		else
		{
			$this->template->write_view('contentpane','admin/addeventadmin', FALSE, FALSE);
			$this->template->render();
		}
	}
	
	// load edit user page and edit user
	function editeventadmin()
	{
		if(!($this->session->userdata('UserType') == 'MA')){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'update')
		{
			$EventAdminICode				= $this->uri->segment(5);
			$eventadmin['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$eventadmin['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$eventadmin['FullName'] 		= $eventadmin['FirstName']." ".$eventadmin['LastName'];
			$eventadmin['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$eventadmin['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$eventadmin['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$eventadmin['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$eventadmin['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$eventadmin['EventName'] 		= mysql_escape_string(trim($this->input->post('EventName')));
			$eventadmin['Bio'] 				= addslashes($this->input->post('Bio'));
			$eventadmin['ModifiedBy'] 		= $this->session->userdata('AdminICode');
			$eventadmin['ModifiedUserType'] = $this->session->userdata('UserType');
			$eventadmin['ModifiedDate'] 	= date('Y-m-d H:i:s');
			
			$this->home->UpdateProcess('event_admin_master', $eventadmin, 'EventAdminICode', $EventAdminICode);
			
			$LoginCredentialICode = $this->input->post('LoginCredentialICode');
			$eventadminlogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$this->home->UpdateProcess('login_credentials', $eventadminlogin, 'LoginCredentialICode', $LoginCredentialICode);
			
			 // edit profile image 
			$config['upload_path'] = './uploads/EventadminImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			/*$config['max_size']	= '100';*/
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
		       $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('ProfileImage'))
			{
				$SingleWhere = "EventAdminICode = '".$EventAdminICode."'";
				$OldPhotoName = $this->home->getSingleFieldValue('event_admin_master', 'ProfileImage', $SingleWhere);
				if($OldPhotoName!='')
				{
					unlink('./uploads/EventadminImages/'.$OldPhotoName);
				}
				
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileImage['ProfileImage'] = $val['file_name'];
					$this->home->UpdateProcess('event_admin_master', $ProfileImage, 'EventAdminICode', $EventAdminICode);
				}
			}
			
			$path = base_url(); redirect(base_url().'admin/user/manageeventadmin/');
		}
		else
		{
			$EventAdminICode = $this->uri->segment(4);
			
			$FTField = "FT.*"; $STField = "ST.*"; 
			$OnCondition = "( FT.EventAdminICode = ST.UserKeyICode)";
			$WhereField = "ST.UserType = 'E' AND FT.IsDeleted = '0' AND FT.EventAdminICode = '".$EventAdminICode."'";
			$data['EventAdminDetails'] = $this->home->getAllDetailsFromIdFromBothTable('event_admin_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField);
		
			$this->template->write_view('contentpane','admin/editeventadmin', $data, FALSE);
			$this->template->render();
		}
	}
	
	// edit event admin my profile
	function editeventadminmyprofile()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$EventAdminICode				= $this->session->userdata('LoginUserICode');
		$eventadmin['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
		$eventadmin['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
		$eventadmin['FullName'] 		= $eventadmin['FirstName']." ".$eventadmin['LastName'];
		$eventadmin['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
		$eventadmin['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
		$eventadmin['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
		$eventadmin['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
		$eventadmin['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
		$eventadmin['EventName'] 		= mysql_escape_string(trim($this->input->post('EventName')));
		$eventadmin['Bio'] 				= addslashes($this->input->post('Bio'));
		$eventadmin['ModifiedBy'] 		= $this->session->userdata('LoginUserICode');
		$eventadmin['ModifiedUserType'] = $this->session->userdata('UserType');
		$eventadmin['ModifiedDate'] 	= date('Y-m-d H:i:s');
		
		$this->home->UpdateProcess('event_admin_master', $eventadmin, 'EventAdminICode', $EventAdminICode);
		
		$LoginCredentialICode = $this->input->post('LoginCredentialICode');
		$eventadminlogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
		$this->home->UpdateProcess('login_credentials', $eventadminlogin, 'LoginCredentialICode', $LoginCredentialICode);
		
		 // edit profile image 
		$config['upload_path'] = './uploads/EventadminImages/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		/*$config['max_size']	= '100';*/
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		$config['file_name'] = 	uniqid();
		
		$this->load->library('upload', $config);
		
		if ($this->upload->do_upload('ProfileImage'))
		{
			$SingleWhere = "EventAdminICode = '".$EventAdminICode."'";
			$OldPhotoName = $this->home->getSingleFieldValue('event_admin_master', 'ProfileImage', $SingleWhere);
			if($OldPhotoName!='')
			{
				unlink('./uploads/EventadminImages/'.$OldPhotoName);
			}
			
			$data = array('upload_data' => $this->upload->data());	
			foreach($data as $val)
			{
				$ProfileImage['ProfileImage'] = $val['file_name'];
				$this->home->UpdateProcess('event_admin_master', $ProfileImage, 'EventAdminICode', $EventAdminICode);
			}
		}
		
		$path = base_url(); redirect(base_url().'admin/home/eventadminhomepage/');
	}
	
	// check email id exist in db
	function checkEmailIdExist()
	{
		if(!($this->session->userdata('UserType'))){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$EmailAddress = $_POST['EmailAddress'];
		if($this->uri->segment(4) != '')
		{
			$LoginCredentialICode = $this->uri->segment(4);
			$WhereFieldValue = "EmailAddress = '".$EmailAddress."' AND LoginCredentialICode != '".$LoginCredentialICode."'";
			$checkOldPaswword = $this->home->checkThisFieldValueInTable('login_credentials',  $WhereFieldValue);
			if($checkOldPaswword == '0'){echo 'insert';exit;} else{ echo 'Exist';  exit;}
		}
		else
		{
			$WhereFieldValue = "EmailAddress = '".$EmailAddress."'";
			$checkOldPaswword = $this->home->checkThisFieldValueInTable('login_credentials',  $WhereFieldValue);
			if($checkOldPaswword == '0'){echo 'insert';exit;} else{ echo 'Exist';  exit;}
		}
	}
	
	// delete user from user_master table
	function deleteEventAdmin()
	{
		$EventAdminICode = $this->uri->segment(4);
		$changestatus['IsDeleted'] = 1;
		$this->home->UpdateProcess('event_admin_master', $changestatus, 'EventAdminICode', $EventAdminICode);
		$path = base_url(); redirect(base_url().'admin/user/manageeventadmin/');
	}
	
	// load manage event file 
	function manageevent()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$WhereFieldValue = "IsDeleted ='0'"; $OrderFiledValue = "EventName ASC";
		$data['EventDetails'] = $this->home->getAllDetails('event_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','admin/manageevent', $data, FALSE);
		$this->template->render();
	}
	
	// load manage event file 
	function managedivision()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "DivisionName ASC";
		$data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','admin/managedivision', $data, FALSE);
		$this->template->render();
	}
	
	// load division page
	function adddivision()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if($this->uri->segment(4) == 'editdiv')
		{
			$DivisionICode = $this->uri->segment(5);
			$SingleWhere = "DivisionICode = '".$DivisionICode."'";
			$data['DivisionValue'] = $this->home->getSingleFieldValue('division_master', 'DivisionName', $SingleWhere);
			$data['ButtonValue'] = 'Update';
			
			$WhereFieldValue = "DivisionICode = '".$DivisionICode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$data['SectionArray'] = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
		}
		else
		{
			$data['DivisionValue'] = ''; $data['ButtonValue'] = 'Save'; $data['SectionArray'] = '';
		}
	
		$WhereFieldValue = "IsDeleted = '0' AND IsActive= '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
		$Fields = "SectionICode, SectionName";
		$data['SectionDetails'] = $this->home->getParticularResults('section_master', $Fields, $WhereFieldValue);
		
		$this->load->view('admin/adddivision', $data);
	}

	// load division page
	function startcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$this->load->view('admin/startcompetition');
	}

	// check division name exist in db
	function checkDivisionNameExist()
	{
		$DivisionName = $_POST['DivisionName'];
		if($this->uri->segment(4) != '')
		{
			$DivisionICode = $this->uri->segment(4);
			$WhereFieldValue = "DivisionName = '".$DivisionName."' AND DivisionICode != '".$DivisionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkDivisionName = $this->home->checkThisFieldValueInTable('division_master',  $WhereFieldValue);
			if($checkDivisionName > '0')
			{
				echo 'Exist';  exit;
			}
			else{ echo 'Available';  exit;}
		}
		else
		{
			$WhereFieldValue = "DivisionName = '".$DivisionName."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkDivisionName = $this->home->checkThisFieldValueInTable('division_master',  $WhereFieldValue);
			if($checkDivisionName > 0)
			{
				echo 'Exist';  exit;
				
			}
			else{ echo 'Available';  exit; }
		}
	}
	
	function mapsection()
	{
		$DivisionICode =  $this->input->post('DivisionICode');
		
		if(empty($DivisionICode))
		{
			$division['DivisionName'] 	 = mysql_escape_string(trim($this->input->post('DivisionName')));
			$division['CreatedBy'] 		 = $this->session->userdata('LoginUserICode');
			$division['CreatedUserType'] = $this->session->userdata('UserType');
			$division['CreatedDate'] 	 = date('Y-m-d H:i:s');
			$DivisionICode = $this->home->InsertQuery('division_master', $division);
			
			// insert records into division_section_master table
			$SectionICodeArray = $this->input->post('SectionICode');
			if(!empty($SectionICodeArray))
			{
				foreach($SectionICodeArray as $v)
				{
					$insdivsec['DivisionICode'] = $DivisionICode;
					$insdivsec['SectionICode']  = $v;
					$insdivsec['CreatedBy'] 	= $this->session->userdata('LoginUserICode');
					$insdivsec['CreatedUserType'] = $this->session->userdata('UserType');
					$insdivsec['CreatedDate'] 	  = date('Y-m-d H:i:s');
					
					$DivisionSectionICode = $this->home->InsertQuery('division_section_master', $insdivsec);
				}
			}
		}
		else
		{
			$division['DivisionName'] 	 = mysql_escape_string(trim($this->input->post('DivisionName')));
			$this->home->UpdateProcess('division_master', $division, 'DivisionICode', $DivisionICode);
			
			// get old records
			$WhereFieldValue = "DivisionICode = '".$DivisionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$oldSectionArray = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'DivisionSectionICode');
			
			// insert records into division_section_master table
			$newSectionArray = array();
			$SectionICodeArray = $this->input->post('SectionICode');
			if(!empty($SectionICodeArray))
			{
				foreach($SectionICodeArray as $v)
				{
					// get count 
					$WhereFieldValue = "DivisionICode='".$DivisionICode."' AND SectionICode='".$v."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
					$Count = $this->home->getTotalCountOfRecords('division_section_master', $WhereFieldValue);
					
					if($Count > 0)
					{
						$Fields = "DivisionSectionICode, IsDeleted";
						$Rec = $this->home->getParticularResultsFromId('division_section_master', $Fields, $WhereFieldValue);
						$newSectionArray[] = $Rec['DivisionSectionICode'];
						if($Rec['IsDeleted'] == 1)
						{
							// update
							$divsec['IsDeleted'] 	 = 0;
							$this->home->UpdateProcess('division_section_master', $divsec, 'DivisionSectionICode', $Rec['DivisionSectionICode']);
						}
					}
					else
					{
						$insdivsec['DivisionICode'] = $DivisionICode;
						$insdivsec['SectionICode']  = $v;
						$insdivsec['CreatedBy'] 		 = $this->session->userdata('LoginUserICode');
						$insdivsec['CreatedUserType'] = $this->session->userdata('UserType');
						$insdivsec['CreatedDate'] 	 = date('Y-m-d H:i:s');
						
						$DivisionSectionICode = $this->home->InsertQuery('division_section_master', $insdivsec);
						$newSectionArray[] = $DivisionSectionICode;
					}
				}
			}
			
			// old speciality delete
			$SectionArrayForDelete = array_diff($oldSectionArray, $newSectionArray);
			$SectionArrayForDelete  = implode(',',$SectionArrayForDelete);
			
			if($SectionArrayForDelete != '')
			{
				$SetField = "IsDeleted = '1'"; $WhereFieldValue = "DivisionSectionICode IN (".$SectionArrayForDelete.")";
				$deleteFromTable = $this->home->UpdateProcessUsingMultifield('division_section_master', $SetField, $WhereFieldValue);
			}
			
		}
		
		
		
		
		
		
		redirect(base_url().'admin/user/managedivision/');
	 	 /*
	
		
		echo 'insert';exit;*/
		
		/*$division['DivisionName'] 	  = mysql_escape_string(trim($DivisionName));
				$division['ModifiedBy'] 	  = $this->session->userdata('LoginUserICode');
				$division['ModifiedUserType'] = $this->session->userdata('UserType');
				$division['ModifiedDate'] 	  = date('Y-m-d H:i:s');
			
				$this->home->UpdateProcess('division_master', $division, 'DivisionICode', $DivisionICode);
				echo 'update'; exit;*/
	}
	
	// delete division from division_master table
	function deleteDivision()
	{
		$DivisionICode = $this->uri->segment(4);
		$changestatus['IsDeleted'] = 1;
		$this->home->UpdateProcess('division_master', $changestatus, 'DivisionICode', $DivisionICode); // delete in division table
		$path = base_url(); redirect(base_url().'admin/user/managedivision/');
	}
	
	// delete division from division_master table
	function deleteSection()
	{
		$SectionICode = $this->uri->segment(4);
		$changestatus['IsDeleted'] = 1;
		$this->home->UpdateProcess('section_master', $changestatus, 'SectionICode', $SectionICode); // delete in section table
		$this->home->UpdateProcess('subsection_master', $changestatus, 'SectionICode', $SectionICode); // delete in sub section table
		$path = base_url(); redirect(base_url().'admin/user/sectionmanagement/');
	}
	
	// load manage event file 
	function sectionmanagement()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		// set temp session value
		$this->session->set_userdata('TempSessionValue', uniqid());
		
		$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "SectionName ASC";
		$data['SectionDetails'] = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','admin/managesection', $data, FALSE);
		$this->template->render();
	}
	
	// load section page
	function addsection()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		// check temp session value 
		if($this->session->userdata('TempSessionValue') == ''){ $path = base_url().'admin/user/sectionmanagement/'; redirect($path); exit; }
		
		if($this->uri->segment(4) == 'insert')
		{
			//insert into section_master master table
			$section['SectionName'] 	= mysql_escape_string(trim($this->input->post('SectionName')));
			$section['MinPoint'] 	 	= mysql_escape_string(trim($this->input->post('MinPoint')));
			$section['MaxPoint'] 	 	= mysql_escape_string(trim($this->input->post('MaxPoint')));
			$section['SectionDescription'] 	= addslashes($this->input->post('SectionDescription'));
			$section['CreatedBy'] 	  	= $this->session->userdata('LoginUserICode');
			$section['CreatedUserType'] = $this->session->userdata('UserType');
			$section['CreatedDate'] 	= date('Y-m-d H:i:s');
			
			$SectionICode = $this->home->InsertQuery('section_master', $section);
			
			// insert records in to subsection master table
			$WhereFieldValue = "TempSessionValue = '".$this->session->userdata('TempSessionValue')."' AND CreatedBy='".$this->session->userdata('LoginUserICode')."'";
			$OrderFiledValue = "SubsectionName ASC";
			$subSectionDetails = $this->home->getAllDetails('temp_subsection', $WhereFieldValue, $OrderFiledValue);
			
			if(!empty($subSectionDetails))
			{
				foreach($subSectionDetails as $row)
				{
					// insert records in to subsection_master table
					$subsection['SectionICode'] 	= $SectionICode;
					$subsection['SubsectionName'] 	= $row['SubsectionName'];
					$subsection['SubsectionDescription'] 	= $row['SubsectionDescription'];
					$subsection['IsActive'] 		= $row['IsActive'];
					$subsection['CreatedBy'] 	  	= $this->session->userdata('LoginUserICode');
					$subsection['CreatedUserType'] 	= $this->session->userdata('UserType');
					$subsection['CreatedDate'] 		= date('Y-m-d H:i:s');
					
					$SubsectionICode = $this->home->InsertQuery('subsection_master', $subsection);
					
					// delete form temp_subsection table
					$wherefield = "TempSubsectionICode = '".$row['TempSubsectionICode']."'";
					$this->home->permamnantDelete('temp_subsection', $wherefield);
				}
			}
			
			$path = base_url(); redirect(base_url().'admin/user/sectionmanagement/');
			
		}
		else
		{
			// load temp table data
			$WhereFieldValue = "TempSessionValue = '".$this->session->userdata('TempSessionValue')."' AND CreatedBy ='".$this->session->userdata('LoginUserICode')."'";
			$OrderFiledValue = "SubsectionName ASC";
			$data['SubsectionDetails'] = $this->home->getAllDetails('temp_subsection', $WhereFieldValue, $OrderFiledValue);
			
			$this->template->write_view('contentpane','admin/addsection', $data, FALSE);
			$this->template->render();
		}
	}
	
	// load section page
	function editsection()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		// check temp session value 
		if($this->session->userdata('TempSessionValue') == ''){ $path = base_url().'admin/user/sectionmanagement/'; redirect($path); exit; }
		
		if($this->uri->segment(4) == 'update')
		{
			$SectionICode = $this->uri->segment(5);
			//insert into section_master master table
			$section['SectionName'] 	= mysql_escape_string(trim($this->input->post('SectionName')));
			$section['MinPoint'] 	 	= mysql_escape_string(trim($this->input->post('MinPoint')));
			$section['MaxPoint'] 	 	= mysql_escape_string(trim($this->input->post('MaxPoint')));
			$section['SectionDescription'] 	= addslashes($this->input->post('SectionDescription'));
			$section['ModifiedBy'] 	  	= $this->session->userdata('LoginUserICode');
			$section['ModifiedUserType'] = $this->session->userdata('UserType');
			$section['ModifiedDate'] 	= date('Y-m-d H:i:s');
			
			$this->home->UpdateProcess('section_master', $section, 'SectionICode', $SectionICode);
			
			$path = base_url(); redirect(base_url().'admin/user/sectionmanagement/');
			
		}
		else
		{
			$SectionICode = $this->uri->segment(4);

			$SingleWhere = "SectionICode = '".$SectionICode."'";
			$val = $this->home->getSingleFieldValue('section_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
			
			// section details
			$WhereFieldValue = "IsDeleted ='0' AND SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$data['SectionDetails'] = $this->home->getAllDetailsFromId('section_master', $WhereFieldValue);
			
			//load temp table data
			$WhereFieldValue = "SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$OrderFiledValue = "SubsectionName ASC";
			$data['SubsectionDetails'] = $this->home->getAllDetails('subsection_master', $WhereFieldValue, $OrderFiledValue);
			
			$this->template->write_view('contentpane','admin/editsection', $data, FALSE);
			$this->template->render();
		}
	}
	
	// Insert sub section for the section
	function insertsubsection()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$processAction 	= $_POST['processAction'];
		$SubsectionName = $_POST['SubsectionName'];
		$SubsectionDescription = addslashes($_POST['SubsectionDescription']);
		if($processAction == 'insertsubsection')
		{
			$tempsection['TempSessionValue'] 		= $this->session->userdata('TempSessionValue');
			$tempsection['SubsectionName'] 			= $SubsectionName;
			$tempsection['SubsectionDescription'] 	= $SubsectionDescription;
			$tempsection['IsActive'] 				= 0;
			$tempsection['CreatedBy'] 				= $this->session->userdata('LoginUserICode');
			$tempsection['CreatedUserType'] 		= $this->session->userdata('UserType');
			$tempsection['CreatedDate'] 			= date('Y-m-d H:i:s');
			
			$WhereFieldValue = "SubsectionName = '".$SubsectionName."' AND TempSessionValue = '".$this->session->userdata('TempSessionValue')."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkSubsectionName = $this->home->checkThisFieldValueInTable('temp_subsection',  $WhereFieldValue);	
			
			if($checkSubsectionName == 0)
			{
				$lastInsertId = $this->home->InsertQuery('temp_subsection', $tempsection);
				echo $this->subsectiontable(); exit;
			}	
			else
			{
				echo 'Exist';
			}
		}
		else
		{
			$tempsection['SectionICode'] 	= $_POST['SectionICode'];
			$tempsection['SubsectionName'] 	= $SubsectionName;
			$tempsection['SubsectionDescription'] 	= $SubsectionDescription;
			$tempsection['CreatedBy'] 		= $this->session->userdata('LoginUserICode');
			$tempsection['CreatedUserType'] = $this->session->userdata('UserType');
			$tempsection['CreatedDate'] 	= date('Y-m-d H:i:s');
			
			$WhereFieldValue = "SubsectionName = '".$SubsectionName."' AND SectionICode = '".$tempsection['SectionICode']."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkSubsectionName = $this->home->checkThisFieldValueInTable('subsection_master',  $WhereFieldValue);	
			
			if($checkSubsectionName == 0)
			{
				$lastInsertId = $this->home->InsertQuery('subsection_master', $tempsection);
				echo $this->subsectiontableforedit($tempsection['SectionICode']); exit;
			}	
			else
			{
				echo 'Exist';
			}
		}
	}
	
	// Edit sub section for the section
	function editsubsection()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$processAction = $_POST['processAction'];
		$SubsectionName = $_POST['SubsectionName'];
		$EditId = $_POST['EditId'];
		
		if($processAction == 'insertsubsection')
		{
			
			$tempsection['SubsectionName'] 	= $SubsectionName;
			$tempsection['SubsectionDescription'] = $_POST['SubsectionDescription'];
			
			$WhereFieldValue = "SubsectionName = '".$SubsectionName."' AND TempSubsectionICode != '".$EditId."' AND TempSessionValue = '".$this->session->userdata('TempSessionValue')."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkSubsectionName = $this->home->checkThisFieldValueInTable('temp_subsection',  $WhereFieldValue);	
			
			if($checkSubsectionName == 0)
			{
				$this->home->UpdateProcess('temp_subsection', $tempsection, 'TempSubsectionICode', $EditId);
				echo $this->subsectiontable(); exit;
			}	
			else
			{
				echo 'Exist';
			}
		}
		else
		{
			$SectionICode 	= $_POST['SectionICode'];
			
			$tempsection['SubsectionName'] 	= $SubsectionName;
			$tempsection['SubsectionDescription'] = $_POST['SubsectionDescription'];
			
			$WhereFieldValue = "SubsectionName = '".$SubsectionName."' AND SubsectionICode != '".$EditId."' AND SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkSubsectionName = $this->home->checkThisFieldValueInTable('subsection_master',  $WhereFieldValue);	
			
			if($checkSubsectionName == 0)
			{
				$this->home->UpdateProcess('subsection_master', $tempsection, 'SubsectionICode', $EditId);
				echo $this->subsectiontableforedit($SectionICode); exit;
			}	
			else
			{
				echo 'Exist';
			}
		}
	}
	
	// delete division from division_master table
	function deleteSubSection()
	{
		if($this->uri->segment(4) == 'foredit')
		{
			$SubsectionICode = $this->uri->segment(5);
			$SectionICode = $_POST['SectionICode'];
			$wherefield = "SubsectionICode = '".$SubsectionICode."'";
			$this->home->permamnantDelete('subsection_master', $wherefield);
			echo $this->subsectiontableforedit($SectionICode); exit;
		}
		else
		{
			$TempSubsectionICode = $this->uri->segment(4);
			$wherefield = "TempSubsectionICode = '".$TempSubsectionICode."'";
			$this->home->permamnantDelete('temp_subsection', $wherefield);
			echo $this->subsectiontable(); exit;
		}
	}
	
	// get subsection description
	function getSubsectionDescription()
	{
		if($_POST['processAction'] == 'Add')
		{
			$TempSubsectionICode  = $_POST['EditId'];
			$SingleWhere = "TempSubsectionICode = '".$TempSubsectionICode."'";
			$val = $this->home->getSingleFieldValue('temp_subsection', 'SubsectionDescription', $SingleWhere);
		}
		else
		{
			$SubsectionICode  = $_POST['EditId'];
			$SingleWhere = "SubsectionICode = '".$SubsectionICode."'";
			$val = $this->home->getSingleFieldValue('subsection_master', 'SubsectionDescription', $SingleWhere);
		}
		echo stripslashes($val);
	}
	
	function subsectiontable()
	{
		// load temp table data
		$WhereFieldValue = "TempSessionValue = '".$this->session->userdata('TempSessionValue')."'AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; 
		$OrderFiledValue = "SubsectionName ASC";
		$SubsectionDetails = $this->home->getAllDetails('temp_subsection', $WhereFieldValue, $OrderFiledValue);
		
		$table =  '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
		<thead>
		<tr>
			<th width="66%" height="32" align="left">Sub Section Name </th>
			<td width="17%" align="center" class="th_css">Status</th>
			<td width="17%" align="center" class="th_css">Action</td>
		</tr>
		</thead>
		<tbody>';
			if(count($SubsectionDetails) > 0 ){
			foreach($SubsectionDetails as $row){
		$table .=	'<tr class="gradeC">
			<td class="left">'.getMaxFieldLength(ucwords($row['SubsectionName']), 30).'</td>
			<td class="center" id="status'.$row['TempSubsectionICode'].'">'.getUserStatus($row['IsActive'], 'temp_subsection', $row['TempSubsectionICode'], 'sub-section', 'TempSubsectionICode').'</td>
			<td class="center"><img src="'.base_url().'images/edit.png" border="0" width="16" height="16" alt="Edit Sub Section" title="Edit Sub Section" style="cursor:pointer;" onclick="editsubsectiondata(\''.$row['SubsectionName'].'\', \''.$row['TempSubsectionICode'].'\');"/>
			<img src="'.base_url().'images/delete.png" border="0" width="16" height="16" alt="Delete Sub Section" title="Delete Sub Section" style="cursor:pointer; padding-left:25px;" onclick="deleteSubSection(\''.$row['TempSubsectionICode'].'\');"/></td>
		</tr>';
		 }}
		 $table .= '</tbody>
		</table>';
		
		echo $table;
		
		?>
		<link href="<?php echo base_url(); ?>css/themes/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" >				
		<link href="<?php echo base_url(); ?>css/demo_table_jui.css" rel="stylesheet" type="text/css" >	
		<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTable.js"></script>
		
		<script language="javascript">
		$(document).ready(function() {
		oTable = $('#tablegrid1').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [ null ]
		});
		});
		</script>
		<?php 
	}
	
	function subsectiontableforedit($SectionICode)
	{
		//load temp table data
		$WhereFieldValue = "SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
		$OrderFiledValue = "SubsectionName ASC";
		$SubsectionDetails = $this->home->getAllDetails('subsection_master', $WhereFieldValue, $OrderFiledValue);
		
		$table =  '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
		<thead>
		<tr>
			<th width="66%" height="32" align="left">Sub Section Name </th>
			<td width="17%" align="center" class="th_css">Status</th>
			<td width="17%" align="center" class="th_css">Action</td>
		</tr>
		</thead>
		<tbody>';
			if(count($SubsectionDetails) > 0 ){
			foreach($SubsectionDetails as $row){
		$table .=	'<tr class="gradeC">
			<td class="left">'.getMaxFieldLength(ucwords($row['SubsectionName']), 30).'</td>
			<td class="center" id="status'.$row['SubsectionICode'].'">'.getUserStatus($row['IsActive'], 'subsection_master', $row['SubsectionICode'], 'sub-section', 'SubsectionICode').'</td>
			<td class="center"><img src="'.base_url().'images/edit.png" border="0" width="16" height="16" alt="Edit Sub Section" title="Edit Sub Section" style="cursor:pointer;" onclick="editsubsectiondata(\''.$row['SubsectionName'].'\', \''.$row['SubsectionICode'].'\');"/>
			<img src="'.base_url().'images/delete.png" border="0" width="16" height="16" alt="Delete Sub Section" title="Delete Sub Section" style="cursor:pointer; padding-left:25px;" onclick="deleteSubSection(\''.$row['SubsectionICode'].'\', \''.$SectionICode.'\');"/></td>
		</tr>';
		 }}
		 $table .= '</tbody>
		</table>';
		
		echo $table;
		
		?>
		<link href="<?php echo base_url(); ?>css/themes/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" >				
		<link href="<?php echo base_url(); ?>css/demo_table_jui.css" rel="stylesheet" type="text/css" >	
		<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTable.js"></script>
		
		<script language="javascript">
		$(document).ready(function() {
		oTable = $('#tablegrid1').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [ null ]
		});
		});
		</script>
		<?php  
	}
	
	// check division name exist in db
	function checkSectionNameExist()
	{
		$SectionName = $_POST['SectionName'];
		if($this->uri->segment(4) != '')
		{
			$SectionICode = $this->uri->segment(4);
			$WhereFieldValue = "SectionName='".$SectionName."' AND SectionICode != '".$SectionICode."' AND CreatedBy='".$this->session->userdata('LoginUserICode')."'";
			$checkSectionName = $this->home->checkThisFieldValueInTable('section_master',  $WhereFieldValue);
		
			if($checkSectionName == '0')
			{
				// check sub section available or/ not
				$WhereFieldValue = "SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
				$checkSubSectionName = $this->home->checkThisFieldValueInTable('subsection_master', $WhereFieldValue);
				if($checkSubSectionName == 0)
				{
					echo 'subsectionempty'; exit;
				}
				else
				{
					echo 'update'; exit;
				}
			}
			else{ echo 'Exist';  exit;}
		}
		else
		{
			$WhereFieldValue = "SectionName = '".$SectionName."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$checkSectionName = $this->home->checkThisFieldValueInTable('section_master',  $WhereFieldValue);
		
			if($checkSectionName == '0')
			{
				// check sub section available or/ not
				$WhereFieldValue = "TempSessionValue = '".$this->session->userdata('TempSessionValue')."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
				$checkSubSectionName = $this->home->checkThisFieldValueInTable('temp_subsection', $WhereFieldValue);
				if($checkSubSectionName == 0)
				{
					echo 'subsectionempty'; exit;
				}
				else
				{
					echo 'insert'; exit;
				}
			}
			else{ echo 'Exist';  exit;}
		}
	}
	
	// load manage judges
	function managejudges()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$FTField = "FT.*"; $STField = "ST.EmailAddress"; 
		$OnCondition = "( FT.JudgesICode = ST.UserKeyICode)";
		//$WhereField = "ST.UserType = 'J' AND FT.IsDeleted = '0' AND FT.CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND FT.CreatedUserType = '".$this->session->userdata('UserType')."'"; 
		$WhereField = "ST.UserType = 'J' AND FT.IsDeleted = '0'"; 
		$OrderFiledValue = "FT.FullName ASC";
		$data['JudgesDetails'] = $this->home->getAllDetailsFromBothTable('judges_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField, $OrderFiledValue);

		$this->template->write_view('contentpane','admin/managejudges', $data, FALSE);
		$this->template->render();
	}
	
	// load add judges page and insert judges
	function addjudges()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'insert')
		{
			$judges['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$judges['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$judges['FullName'] 		= $judges['FirstName']." ".$judges['LastName'];
			$judges['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$judges['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$judges['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$judges['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$judges['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$judges['Bio'] 				= addslashes($this->input->post('Bio'));
			$judges['IsHead']		    = $this->input->post('IsHead');
			$judges['CreatedBy'] 		= $this->session->userdata('LoginUserICode');
			$judges['CreatedUserType'] 	= $this->session->userdata('UserType');
			$judges['CreatedDate'] 		= date('Y-m-d H:i:s');
			
			$JudgesICode = $this->home->InsertQuery('judges_master', $judges);
			
			$judgeslogin['UserKeyICode']= $JudgesICode;
			$judgeslogin['UserType'] 	= 'J';
			$judgeslogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$judgeslogin['Password'] 	= md5(trim($this->input->post('Password')));
			
			$lastInsertId = $this->home->InsertQuery('login_credentials', $judgeslogin);
			
			// profile image upload
			$config['upload_path'] = './uploads/JudgesImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			//$config['max_size']	= '100';
			$config['max_width']  = '500';
			$config['max_height']  = '768';
		    $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('ProfileImage'))
			{
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileImage['ProfileImage'] = $val['file_name'];
					$this->home->UpdateProcess('judges_master', $ProfileImage, 'JudgesICode', $JudgesICode);
				}
			}else{
				
				$error = array('error' => $this->upload->display_errors());
				if($error['error'] != '<p>You did not select a file to upload.</p>'){
					$this->session->set_flashdata('upload_error' , $error['error']);
				}

			}
			
			$path = base_url(); redirect(base_url().'admin/user/managejudges/');
		}
		else
		{
			$this->template->write_view('contentpane','admin/addjudges', FALSE, FALSE);
			$this->template->render();
		}
	}
	
	// load edit judges page and edit judges
	function editjudges()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'update')
		{
			$JudgesICode				= $this->uri->segment(5);
			
			/*$SingleWhere = "JudgesICode = '".$JudgesICode."'";
			$val = $this->home->getSingleFieldValue('judges_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }*/
			
			$judges['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$judges['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$judges['FullName'] 		= $judges['FirstName']." ".$judges['LastName'];
			$judges['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$judges['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$judges['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$judges['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$judges['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$judges['Bio'] 				= addslashes($this->input->post('Bio'));
			$judges['IsHead']		    = $this->input->post('IsHead');
			$judges['ModifiedBy'] 		= $this->session->userdata('AdminICode');
			$judges['ModifiedUserType'] = $this->session->userdata('UserType');
			$judges['ModifiedDate'] 	= date('Y-m-d H:i:s');
			
			$this->home->UpdateProcess('judges_master', $judges, 'JudgesICode', $JudgesICode);
			
			$LoginCredentialICode = $this->input->post('LoginCredentialICode');
			$judgeslogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$this->home->UpdateProcess('login_credentials', $judgeslogin, 'LoginCredentialICode', $LoginCredentialICode);
			
			 // judges images upload
			$config['upload_path'] = './uploads/JudgesImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			/*$config['max_size']	= '100';*/
			$config['max_width']  = '500';
			$config['max_height']  = '768';
		    $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('ProfileImage'))
			{
				$SingleWhere = "JudgesICode = '".$JudgesICode."'";
				$OldPhotoName = $this->home->getSingleFieldValue('judges_master', 'ProfileImage', $SingleWhere);
				if($OldPhotoName!='')
				{
					unlink('./uploads/JudgesImages/'.$OldPhotoName);
				}
				
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileImage['ProfileImage'] = $val['file_name'];
					$this->home->UpdateProcess('judges_master', $ProfileImage, 'JudgesICode', $JudgesICode);
				}
			}else{
				
				$error = array('error' => $this->upload->display_errors());
				if($error['error'] != '<p>You did not select a file to upload.</p>'){
					$this->session->set_flashdata('upload_error' , $error['error']);
					$path = base_url(); redirect(base_url().'admin/user/editjudges/'.$JudgesICode);
				}

			}
			
			$path = base_url(); redirect(base_url().'admin/user/managejudges/');
		}
		else
		{
			$JudgesICode = $this->uri->segment(4);

			/*$SingleWhere = "JudgesICode = '".$JudgesICode."'";
			$val = $this->home->getSingleFieldValue('judges_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }*/

			$FTField = "FT.*"; $STField = "ST.*"; 
			$OnCondition = "( FT.JudgesICode = ST.UserKeyICode)";
			$WhereField = "ST.UserType = 'J' AND FT.IsDeleted = '0' AND FT.JudgesICode = '".$JudgesICode."'";
			$data['JudgesDetails'] = $this->home->getAllDetailsFromIdFromBothTable('judges_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField);
		
			$this->template->write_view('contentpane','admin/editjudges', $data, FALSE);
			$this->template->render();
		}
	}
	
	// delete user from user_master table
	function deleteJudges()
	{
		$JudgesICode = $this->uri->segment(4);
		
		$SingleWhere = "JudgesICode = '".$CompetitorICode."'";
		$OldPhotoName = $this->home->getSingleFieldValue('judges_master', 'ProfileImage', $SingleWhere);
		if($OldPhotoName!='')
		{
			unlink('./uploads/JudgesImages/'.$OldPhotoName);
		}
		
		//delete competitor details
		$wherefieldcomp = "JudgesICode = '".$CompetitorICode."'";
		$this->home->permamnantDelete('judges_master', $wherefieldcomp );
		
		//delete user from login credentials
		$wherefield = "UserKeyICode = '".$CompetitorICode."'";
		$this->home->permamnantDelete('login_credentials', $wherefield );
		
		//delete user from competition
		$wherefieldcompetition = "JudgesICode = '".$CompetitorICode."'";
		$this->home->permamnantDelete('competition_judges', $wherefieldcompetition );
		
		/*$changestatus['IsDeleted'] = 1;
		$this->home->UpdateProcess('judges_master', $changestatus, 'JudgesICode', $JudgesICode);*/ //old logic to delete
		$path = base_url(); redirect(base_url().'admin/user/managejudges/');
	}
	
	// load manage competitors
	function managecompetitor()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$FTField = "FT.*"; $STField = "ST.EmailAddress"; 
		$OnCondition = "( FT.CompetitorICode = ST.UserKeyICode)";
		//$WhereField = "ST.UserType = 'C' AND FT.IsDeleted = '0' AND FT.CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND FT.CreatedUserType = '".$this->session->userdata('UserType')."'"; 
		$WhereField = "ST.UserType = 'C' AND FT.IsDeleted = '0'"; 
		$OrderFiledValue = "FT.FullName ASC";
		$data['CompetitorDetails'] = $this->home->getAllDetailsFromBothTable('competitor_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField, $OrderFiledValue);
		$this->template->write_view('contentpane','admin/managecompetitor', $data, FALSE);
		$this->template->render();
	}
	
	// load add competitor page and insert competitor
	function addcompetitor()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'insert')
		{
			$competitor['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$competitor['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$competitor['NickName'] 		= mysql_escape_string(trim($this->input->post('NickName')));
			$competitor['FullName'] 		= $competitor['FirstName']." ".$competitor['LastName'];
			$competitor['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$competitor['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$competitor['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$competitor['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$competitor['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$competitor['Bio'] 				= addslashes($this->input->post('Bio'));
			
			$competitor['CreatedBy'] 		= $this->session->userdata('LoginUserICode');
			$competitor['CreatedUserType'] 	= $this->session->userdata('UserType');
			$competitor['CreatedDate'] 		= date('Y-m-d H:i:s');
			
			$CompetitorICode = $this->home->InsertQuery('competitor_master', $competitor);
			
			$competitorlogin['UserKeyICode']= $CompetitorICode;
			$competitorlogin['UserType'] 	= 'C';
			$competitorlogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$competitorlogin['Password'] 	= md5(trim($this->input->post('Password')));
			
			$lastInsertId = $this->home->InsertQuery('login_credentials', $competitorlogin);
			
			// profile image upload
			$config['upload_path'] = './uploads/CompetitiorImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			//$config['max_size']	= '100';
			$config['max_width']  = '500';
			$config['max_height']  = '768';
		    $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('ProfileImage'))
			{
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileImage['ProfileImage'] = $val['file_name'];
					$this->home->UpdateProcess('competitor_master', $ProfileImage, 'CompetitorICode', $CompetitorICode);
				}
			}else{
				
				$error = array('error' => $this->upload->display_errors());
				if($error['error'] != '<p>You did not select a file to upload.</p>'){
					$this->session->set_flashdata('upload_error' , $error['error']);
				}

			}
			
			$path = base_url(); redirect(base_url().'admin/user/managecompetitor/');
		}
		else
		{
			$WhereFieldValue = "IsDeleted ='0' AND IsActive='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "DivisionName ASC";
			
			$data = array();
			
			$this->template->write_view('contentpane','admin/addcompetitor', $data, FALSE);
			$this->template->render();
		}
	}
	
	// load edit competitor page and edit competitor
	function editcompetitor()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'update')
		{
			$CompetitorICode			= $this->uri->segment(5);
			/*$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
			$val = $this->home->getSingleFieldValue('competitor_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }*/
			
			$competitor['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$competitor['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$competitor['NickName'] 		= mysql_escape_string(trim($this->input->post('NickName')));
			$competitor['FullName'] 		= $competitor['FirstName']." ".$competitor['LastName'];
			$competitor['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$competitor['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$competitor['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$competitor['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$competitor['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$competitor['Bio'] 				= addslashes($this->input->post('Bio'));
			//$competitor['DivisionICode'] 	= $this->input->post('DivisionICode');
			$competitor['ModifiedBy'] 		= $this->session->userdata('AdminICode');
			$competitor['ModifiedUserType'] = $this->session->userdata('UserType');
			$competitor['ModifiedDate'] 	= date('Y-m-d H:i:s');
			
			$this->home->UpdateProcess('competitor_master', $competitor, 'CompetitorICode', $CompetitorICode);
			
			$LoginCredentialICode = $this->input->post('LoginCredentialICode');
			$competitorlogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$this->home->UpdateProcess('login_credentials', $competitorlogin, 'LoginCredentialICode', $LoginCredentialICode);
			
			 // edit profile image 
			$config['upload_path'] = './uploads/CompetitiorImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			/*$config['max_size']	= '100';*/
			$config['max_width']  = '500';
			$config['max_height']  = '768';
		    $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('ProfileImage'))
			{
				$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
				$OldPhotoName = $this->home->getSingleFieldValue('competitor_master', 'ProfileImage', $SingleWhere);
				if($OldPhotoName!='')
				{
					unlink('./uploads/CompetitiorImages/'.$OldPhotoName);
				}
				
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileImage['ProfileImage'] = $val['file_name'];
					$this->home->UpdateProcess('competitor_master', $ProfileImage, 'CompetitorICode', $CompetitorICode);
				}
			}else{
				
				$error = array('error' => $this->upload->display_errors());
				if($error['error'] != '<p>You did not select a file to upload.</p>'){
					$this->session->set_flashdata('upload_error' , $error['error']);
					$path = base_url(); redirect(base_url().'admin/user/editcompetitor/'.$CompetitorICode);
				}
				
				

			}
			
			$path = base_url(); redirect(base_url().'admin/user/managecompetitor/');
		}
		else
		{
			$CompetitorICode = $this->uri->segment(4);

			/*$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
			$val = $this->home->getSingleFieldValue('competitor_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }*/

			$FTField = "FT.*"; $STField = "ST.*"; 
			$OnCondition = "( FT.CompetitorICode = ST.UserKeyICode)";
			$WhereField = "ST.UserType = 'C' AND FT.IsDeleted = '0' AND FT.CompetitorICode = '".$CompetitorICode."'";
			$data['CompetitorDetails'] = $this->home->getAllDetailsFromIdFromBothTable('competitor_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField);
			
			$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "DivisionName ASC";
			
			$this->template->write_view('contentpane','admin/editcompetitor', $data, FALSE);
			$this->template->render();
		}
	}
	
	// delete user from competitor_master table
	function deleteCompetitor()
	{
		$CompetitorICode = $this->uri->segment(4);
		/*$changestatus['IsDeleted'] = 1;
		$this->home->UpdateProcess('competitor_master', $changestatus, 'CompetitorICode', $CompetitorICode);*/ // old logic to delete

		//delete profile pic from server
		$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
		$OldPhotoName = $this->home->getSingleFieldValue('competitor_master', 'ProfileImage', $SingleWhere);
		if($OldPhotoName!='')
		{
			unlink('./uploads/CompetitiorImages/'.$OldPhotoName);
		}
		
		//delete video from server
		$SingleWhereVid = "CompetitorICode = '".$CompetitorICode."'";
		$OldVideoName = $this->home->getSingleFieldValue('competitor_master', 'video', $SingleWhereVid);
		if($OldVideoName!='')
		{
			unlink('./uploads/videos/'.$OldVideoName);
		}
	
		//delete competitor details
		$wherefieldcomp = "CompetitorICode = '".$CompetitorICode."'";
		$this->home->permamnantDelete('competitor_master', $wherefieldcomp );
		
		//delete user from login credentials
		$wherefield = "UserKeyICode = '".$CompetitorICode."'";
		$this->home->permamnantDelete('login_credentials', $wherefield );
		
		//delete user from competition
		$wherefieldcompetition = "CompetitorICode = '".$CompetitorICode."'";
		$this->home->permamnantDelete('competition_competitor', $wherefieldcompetition );
				
		$path = base_url(); redirect(base_url().'admin/user/managecompetitor/');
	}
	
	// load manage competition page
	function managecompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "CompetitionName ASC";
		$data['CompetitionDetails'] = $this->home->getAllDetails('competition_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','admin/managecompetition', $data, FALSE);
		$this->template->render();
	}
	
	// load add competition page and insert competition
	function addcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'insert')
		{
			// competition time format
			
			
			$hour = $this->input->post('CompetitionHour');
			$minu = $this->input->post('CompetitionMiniute');
			$secs = '00';
			$merd = $this->input->post('CompetitionMeridian');
			$time = $hour.':'.$minu.':'.$secs.' '.$merd;
			$CompetitionTime =  date('H:i:s', strtotime($time));
			
			// competition duration
			$hour1 = $this->input->post('DurationHour');
			$minu1 = $this->input->post('DurationMiniute');
			$secs1 = '00';
			$merd1 = 'AM';
			$time1 = $hour1.':'.$minu1;
			$CompetitionDuration =  date('H:i:s', strtotime($time1));
			
			$competition['CompetitionName']			= mysql_escape_string(trim($this->input->post('CompetitionName')));
			$competition['CompetitionDate'] 		= date('Y-m-d', strtotime($this->input->post('CompetitionDate')));
			$competition['CompetitionTime'] 		= $CompetitionTime;
			$competition['CompetitionDuration'] 	= $CompetitionDuration;
			$competition['CompetitionAddressLine1']	= addslashes(trim($this->input->post('CompetitionAddressLine1')));
			$competition['CompetitionAddressLine2'] = addslashes(trim($this->input->post('CompetitionAddressLine2')));
			$competition['CompetitionSuburb'] 		= mysql_escape_string(trim($this->input->post('CompetitionSuburb')));
			$competition['CompetitionCountry'] 		= mysql_escape_string(trim($this->input->post('CompetitionCountry')));
			$competition['CompetitionPostalCode'] 	= mysql_escape_string(trim($this->input->post('CompetitionPostalCode')));
			
			// contact person details
			$competition['FirstName']				= mysql_escape_string(trim($this->input->post('FirstName')));
			$competition['LastName'] 				= mysql_escape_string(trim($this->input->post('LastName')));
			$competition['FullName'] 				= $competition['FirstName']." ".$competition['LastName'];
			$competition['EmailAddress'] 			= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$competition['AddressLine1'] 			= addslashes(trim($this->input->post('AddressLine1')));
			$competition['AddressLine2'] 			= addslashes(trim($this->input->post('AddressLine2')));
			$competition['Suburb'] 					= mysql_escape_string(trim($this->input->post('Suburb')));
			$competition['Country'] 				= mysql_escape_string(trim($this->input->post('Country')));
			$competition['PostalCode'] 				= mysql_escape_string(trim($this->input->post('PostalCode')));
			$competition['PhoneNumber'] 			= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$competition['MobileNumber'] 			= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$competition['CreatedBy'] 				= $this->session->userdata('LoginUserICode');
			$competition['CreatedUserType'] 		= $this->session->userdata('UserType');
			$competition['CreatedDate'] 			= date('Y-m-d H:i:s');
			$competition['IsPublic'] 			    = $this->input->post('IsPublic');
			
			$CompetitionICode = $this->home->InsertQuery('competition_master', $competition);
			
			// insert into competition_judges table
			$JudgesICode  = $this->input->post('JudgesICode');
			if(!empty($JudgesICode))
			{
				foreach ($JudgesICode as $res)
				{
					$comp_judges['CompetitionICode'] = $CompetitionICode;
					$comp_judges['JudgesICode']		 = $res;
					$CompetitionJudgesICode = $this->home->InsertQuery('competition_judges', $comp_judges);
				}
			}
			
			// insert into competition_competitor table
//			$CompetitorICode  = $this->input->post('CompetitorICode');
//			if(!empty($CompetitorICode))
//			{
//				foreach ($CompetitorICode as $rez)
//				{
//					$s = explode('_', $rez);
//					$CompetitorICode = $s[0];
//					$OrderFieldName = $s[1];
//					
//					$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
//					$DivisionICode = $this->home->getSingleFieldValue('competitor_master', 'DivisionICode', $SingleWhere);
//					
//						$comp_competitor['CompetitionICode'] 	= $CompetitionICode;
//						$comp_competitor['DivisionICode']		= $DivisionICode;
//						$comp_competitor['CompetitorICode']		= CompetitorICode;
//						$comp_competitor['CompetitorOrder']		= $this->input->post('OrderList'.$OrderFieldName);
//						$CompetitionCompetitorICode = $this->home->InsertQuery('competition_competitor', $comp_competitor);
//					
//				}
//			}
			
			//
			
			
			//This portion is edited by bernazzyk to insert into the competition_competitor table in different requirements - edit date: 28-04-12
			
			foreach ($_POST['DivisionICode'] as $val){
				foreach ($_POST['division_code'] as $key=>$division_code){
					if($val == $key){
						foreach ($_POST['division_code'][$val] as $key1=>$val1){
							$comp_competitor['CompetitionICode'] 	= $CompetitionICode;
							$comp_competitor['DivisionICode']		= $key;
							$comp_competitor['CompetitorICode'] 	= $key1;
							$comp_competitor['CompetitorOrder'] 	= $_POST['competitor'][$val][$key1];
							$CompetitionCompetitorICode = $this->home->InsertQuery('competition_competitor', $comp_competitor);
						}
						
					}
				}
			}
			
			//This portion is edited by bernazzyk to insert into the competition_competitor table in different requirements
			
			// compettion image upload
			$config['upload_path'] = './uploads/CompetitionImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			//$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
		    $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('CompetitionImage'))
			{
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$CompetitionImage['CompetitionImage'] = $val['file_name'];
					$this->home->UpdateProcess('competition_master', $CompetitionImage, 'CompetitionICode', $CompetitionICode);
				}
			}
			
			$path = base_url(); redirect(base_url().'admin/user/managecompetition/');
		}
		else
		{
			$WhereFieldValue = "IsDeleted ='0' AND IsActive='0'"; 
			$OrderFiledValue = "DivisionName ASC";
			$data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);
			
			$WhereFieldValue = "IsDeleted ='0'"; $OrderFiledValue = "FullName ASC";
			$data['JudgesDetails'] = $this->home->getAllDetails('judges_master', $WhereFieldValue, $OrderFiledValue);
		
			//this code is edited by bernazzyk to get competitor details - edit date: 28-04-12
			
			$WhereFieldValue = "IsDeleted ='0'"; 
			$OrderFiledValue = "FullName ASC";
			$data['CompetitorDetails'] = $this->home->getAllDetails('competitor_master', $WhereFieldValue, $OrderFiledValue);
			
			//this code is edited by bernazzyk
			
			$this->template->write_view('contentpane','admin/addcompetition', $data, FALSE);
			$this->template->render();
		}
	}
	
	function getDivisionName() {
		$DivisionName = $this->home->getSingleFieldValue('division_master', 'DivisionName', "DivisionICode = '".$_POST['DivisionICode']."'");
		echo $DivisionName;
	}
	
	// load edit competition page and update competition details
	function editcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(4)== 'update')
		{
			$CompetitionICode = $this->input->post('CompetitionICode');
			// check this competition crated by login user
			$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
			$val = $this->home->getSingleFieldValue('competition_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
			
			// check this competiton started
			$val = $this->home->getSingleFieldValue('competition_master', 'IsCompleted', $SingleWhere);
			if($val == 1){ $path = base_url().'admin/user/managecompetition/'; redirect($path); exit; }
			
			// competition time format
			$hour = $this->input->post('CompetitionHour');
			$minu = $this->input->post('CompetitionMiniute');
			$secs = '00';
			$merd = $this->input->post('CompetitionMeridian');
			$time = $hour.':'.$minu.':'.$secs.' '.$merd;
			$CompetitionTime =  date('H:i:s', strtotime($time));
			
			// competition duration
			$hour1 = $this->input->post('DurationHour');
			$minu1 = $this->input->post('DurationMiniute');
			$secs1 = '00';
			$merd1 = 'AM';
			$time1 = $hour1.':'.$minu1;
			$CompetitionDuration =  date('H:i:s', strtotime($time1));
		
			$competition['CompetitionName']			= mysql_escape_string(trim($this->input->post('CompetitionName')));
			$competition['CompetitionDate'] 		= date('Y-m-d', strtotime($this->input->post('CompetitionDate')));
			$competition['CompetitionTime'] 		= $CompetitionTime;
			$competition['CompetitionDuration'] 	= $CompetitionDuration;
			$competition['CompetitionAddressLine1']	= addslashes(trim($this->input->post('CompetitionAddressLine1')));
			$competition['CompetitionAddressLine2'] = addslashes(trim($this->input->post('CompetitionAddressLine2')));
			$competition['CompetitionSuburb'] 		= mysql_escape_string(trim($this->input->post('CompetitionSuburb')));
			$competition['CompetitionCountry'] 		= mysql_escape_string(trim($this->input->post('CompetitionCountry')));
			$competition['CompetitionPostalCode'] 	= mysql_escape_string(trim($this->input->post('CompetitionPostalCode')));
			
			// contact person details
			$competition['FirstName']				= mysql_escape_string(trim($this->input->post('FirstName')));
			$competition['LastName'] 				= mysql_escape_string(trim($this->input->post('LastName')));
			$competition['FullName'] 				= $competition['FirstName']." ".$competition['LastName'];
			$competition['EmailAddress'] 			= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			$competition['AddressLine1'] 			= addslashes(trim($this->input->post('AddressLine1')));
			$competition['AddressLine2'] 			= addslashes(trim($this->input->post('AddressLine2')));
			$competition['Suburb'] 					= mysql_escape_string(trim($this->input->post('Suburb')));
			$competition['Country'] 				= mysql_escape_string(trim($this->input->post('Country')));
			$competition['PostalCode'] 				= mysql_escape_string(trim($this->input->post('PostalCode')));
			$competition['PhoneNumber'] 			= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$competition['MobileNumber'] 			= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$competition['CreatedBy'] 				= $this->session->userdata('LoginUserICode');
			$competition['CreatedUserType'] 		= $this->session->userdata('UserType');
			$competition['CreatedDate'] 			= date('Y-m-d H:i:s');
			$competition['IsPublic'] 				= $this->input->post('IsPublic');
			
			$this->home->UpdateProcess('competition_master', $competition, 'CompetitionICode', $CompetitionICode);
			
			//get old judges id for this competion
			$Where = "CompetitionICode ='".$CompetitionICode."' AND IsDeleted = '0'";
		    $OldCompetitionJudgesICode = $this->home->getAllIdInArrayFormate('competition_judges', $Where, 'CompetitionJudgesICode');
			
			//get old competitor id for this competion
		    $OldCompetitionCompetitorICode = $this->home->getAllIdInArrayFormate('competition_competitor', $Where, 'CompetitionCompetitorICode');
			
			//insert /or update new judges for this competition
			$JudgesICode  = $this->input->post('JudgesICode');
			$NewCompetitionJudgesICode = array();
			if(!empty($JudgesICode))
			{
				foreach ($JudgesICode as $res)
				{
					$comp_judges['CompetitionICode'] = $CompetitionICode;
					$comp_judges['JudgesICode']		 = $res;
					
					//check this judges id already available in table.
					$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND JudgesICode = '".$comp_judges['JudgesICode']."' AND IsDeleted = '0'";
					$CompetitionJudgesICode = $this->home->checkThisFieldValueInTableAndReturnICode('competition_judges',  $WhereFieldValue, 'CompetitionJudgesICode');
					
					if($CompetitionJudgesICode > 0)
					{
						// update process
						$this->home->UpdateProcess('competition_judges', $comp_judges, 'CompetitionJudgesICode', $CompetitionJudgesICode);
						$NewCompetitionJudgesICode[] = $CompetitionJudgesICode;
					}
					else
					{
						// insert process
						$CompetitionJudgesICode = $this->home->InsertQuery('competition_judges', $comp_judges);
						$NewCompetitionJudgesICode[] = $CompetitionJudgesICode;
					}
				}
			}
			
			// to find delete judges
			$CompetitionJudgesICodeForDelete = array_diff($OldCompetitionJudgesICode, $NewCompetitionJudgesICode);
			$DeleteCompetitionJudges = implode(',',$CompetitionJudgesICodeForDelete);
			
			//delete judges details from competition_judges table
			if($DeleteCompetitionJudges != '')
			{
				$wherefield = "CompetitionJudgesICode IN (".$DeleteCompetitionJudges.") AND CompetitionICode = '".$CompetitionICode."'";
				$deleteFromTable = $this->home->permamnantDelete('competition_judges', $wherefield);
			}
			
			//edited by bernazzyk, as the edit functionality is changed for the given requirements - edit date: 28-04-12
			
			
			$NewCompetitionCompetitorICode = array();
			foreach ($_POST['DivisionICode'] as $val){
				foreach ($_POST['division_code'] as $key=>$division_code){
					if($val == $key){
						foreach ($_POST['division_code'][$val] as $key1=>$val1){
							$comp_competitor['CompetitionICode'] 	= $CompetitionICode;
							$comp_competitor['DivisionICode']		= $key;
							$comp_competitor['CompetitorICode'] 	= $key1;
							$comp_competitor['CompetitorOrder'] 	= $_POST['competitor'][$val][$key1];
							$WhereFieldValue = "CompetitionICode= '".$CompetitionICode."' AND CompetitorICode = '".$comp_competitor['CompetitorICode']."' AND IsDeleted = '0' AND DivisionICode='".$comp_competitor['DivisionICode'] ."'";
							$CCICode = $this->home->checkThisFieldValueInTableAndReturnICode('competition_competitor',  $WhereFieldValue, 'CompetitionCompetitorICode');
							if($CCICode > 0){
								// update process
								$this->home->UpdateProcess('competition_competitor', $comp_competitor, 'CompetitionCompetitorICode', $CCICode);
								$NewCompetitionCompetitorICode[] = $CCICode;
							}
							else{
								// insert process
								$CompetitionCompetitorICode = $this->home->InsertQuery('competition_competitor', $comp_competitor);
								$NewCompetitionCompetitorICode[] = $CompetitionCompetitorICode;
							}
							
						}
						
					}
				}
			}
			
			//edited by bernazzyk
			
			// to find delete judges
			$CompetitionCompetitorICodeForDelete = array_diff($OldCompetitionCompetitorICode, $NewCompetitionCompetitorICode);
			$DeleteCompetitionCompetitor = implode(',',$CompetitionCompetitorICodeForDelete);
			
			//delete judges details from competition_judges table
			if($DeleteCompetitionCompetitor != '')
			{
				$wherefield = "CompetitionCompetitorICode IN (".$DeleteCompetitionCompetitor.") AND CompetitionICode = '".$CompetitionICode."'";
				$deleteFromTable = $this->home->permamnantDelete('competition_competitor', $wherefield);
			}
			
			 // edit comprtition image 
			$config['upload_path'] = './uploads/CompetitionImages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			/*$config['max_size']	= '100';*/
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
		    $config['file_name'] = 	uniqid();
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('CompetitionImage'))
			{
				$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
				$OldPhotoName = $this->home->getSingleFieldValue('competition_master', 'CompetitionImage', $SingleWhere);
				if($OldPhotoName!='')
				{
					unlink('./uploads/CompetitionImages/'.$OldPhotoName);
				}
				
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$CompetitionImage['CompetitionImage'] = $val['file_name'];
					$this->home->UpdateProcess('competition_master', $CompetitionImage, 'CompetitionICode', $CompetitionICode);
				}
			}
			
			$path = base_url(); redirect(base_url().'admin/user/managecompetition/');
		}
		else
		{
			$CompetitionICode = $this->uri->segment(4);
			
			// check this competition crated by login user
			$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
			$val = $this->home->getSingleFieldValue('competition_master', 'CreatedBy', $SingleWhere);
			if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
			
			// get all division details
			$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "DivisionName ASC";
			$data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);
			
			$WhereFieldValue = "IsDeleted ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; $OrderFiledValue = "FullName ASC";
			$data['JudgesDetails'] = $this->home->getAllDetails('judges_master', $WhereFieldValue, $OrderFiledValue);
			
			$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
			$data['CompetitionDetails'] = $this->home->getAllDetailsFromId('competition_master', $WhereFieldValue);
			
			// load judges for this competition
			$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
			$JudgesICode = $this->home->getAllIdInArrayFormate('competition_judges', $WhereFieldValue, 'JudgesICode');
			$data['Cjudges'] = $JudgesICode;
			
			// Competition Division already selected
			$data['DivisionICode'] = $this->home->getAllSelectedDivision($CompetitionICode);
			
			//edited by bernazzyk to the competitor details - edit date: 28-04-12

			$WhereFieldValue = "IsDeleted ='0'"; 
			$OrderFiledValue = "FullName ASC";
			$data['CompetitorDetails'] = $this->home->getAllDetails('competitor_master', $WhereFieldValue, $OrderFiledValue);
			
			//edited by bernazzyk
			
			// load competitor for this competition
			$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
			$CompetitorICode = $this->home->getAllIdInArrayFormate('competition_competitor', $WhereFieldValue, 'CompetitorICode');
			$data['CcompetitorArray'] = $CompetitorICode;
			
			//edited by bernazzyk to get the competitor of the competition - edit date: 28-04-12
			
			$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
			$CompetitorICodeTest = $this->home->getAllDetails('competition_competitor', $WhereFieldValue, 'CompetitorICode');
			$data['CcompetitorArrayTest'] = $CompetitorICodeTest;
			
			//edited by bernazzyk
			
			$this->template->write_view('contentpane','admin/editcompetition', $data, FALSE);
			$this->template->render();
		}
	}
	
	
	// check division name exist in db
	function checkCompetitionNameExist()
	{
		$CompetitionName = $_POST['CompetitionName'];
		
		if($this->uri->segment(4) == 'update')
		{
			$CompetitionICode = $this->uri->segment(5);
			$WhereFieldValue = "CompetitionName = '".$CompetitionName."' AND CompetitionICode != '".$CompetitionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND IsDeleted = '0'";
			$checkCompetitionName = $this->home->checkThisFieldValueInTable('competition_master', $WhereFieldValue);
			if($checkCompetitionName == '0'){ echo 'update';exit; }
				else{ echo 'Exist';  exit;}
		}
		else
		{
			$WhereFieldValue = "CompetitionName = '".$CompetitionName."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' AND IsDeleted = '0'";
			$checkCompetitionName = $this->home->checkThisFieldValueInTable('competition_master',  $WhereFieldValue);
			if($checkCompetitionName == '0'){echo 'insert'; exit;}
				else{ echo 'Exist';  exit;}
		}
	}
	
	// delete competition from competition_master table
	function deleteCompetition()
	{
		$CompetitionICode = $this->uri->segment(4);
		$changestatus['IsDeleted'] = 1;
		$this->home->UpdateProcess('competition_master', $changestatus, 'CompetitionICode', $CompetitionICode);
		$path = base_url(); redirect(base_url().'admin/user/managecompetition/');
	}
	
	// manage start competition list.
	function managestartcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$WhereFieldValue = "IsDeleted ='0' AND IsStarted = '0' AND IsCompleted = '0' AND IsActive ='0' AND CompetitionDate >='".date('Y-m-d')."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; 
		$OrderFiledValue = "CompetitionName ASC";
		$data['CompetitionDetails'] = $this->home->getAllDetails('competition_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','admin/managestartcompetition', $data, FALSE);
		$this->template->render();
	}
	
	// manage start competition list.
	function manageendcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$WhereFieldValue = "IsDeleted ='0' AND IsStarted = '1' AND IsCompleted = '0' AND IsActive ='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'"; 
		$OrderFiledValue = "CompetitionName ASC";
		$data['CompetitionDetails'] = $this->home->getAllDetails('competition_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','admin/manageendcompetition', $data, FALSE);
		$this->template->render();
	}
	
	
	function managestartcompetitionAjax()
	{
		$CompetitionICode = $_POST['CompetitionICode'];
		if($CompetitionICode != "")
		{
			$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND IsDeleted = '0'";
			$Cnt = $this->home->getTotalCountOfRecords('competition_competitor', $WhereFieldValue);
			
			if($Cnt > 0)
			{
				$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND IsDeleted = '0'";
				$CCnt = $this->home->getTotalCountOfRecords('competition_judges', $WhereFieldValue);
				
				if($CCnt > 0)
				{
					$competition['IsStarted'] = '1';
			 		$this->home->UpdateProcess('competition_master', $competition, 'CompetitionICode', $CompetitionICode);
			 		echo '<img src= "'.base_url().'images/tick2.png" border="0" width="24" height="24" style="cursor:pointer;" title="Competition Started"/>';
				}
				else
				{
					echo 'No Judges';   exit;
				}
			}
			else
			{
				echo 'No Competitors';	exit;
			}
		}
	}
	
	function manageendcompetitionAjax()
	{
		$CompetitionICode = $_POST['CompetitionICode'];
		if($CompetitionICode != "")
		{
			/*$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND IsDeleted = '0'";
			$Cnt = $this->home->getTotalCountOfRecords('competition_competitor', $WhereFieldValue);
			
			if($Cnt > 0)
			{
				$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND IsDeleted = '0'";
				$CCnt = $this->home->getTotalCountOfRecords('competition_judges', $WhereFieldValue);
				
				if($CCnt > 0)
				{*/
					$competition['IsStarted'] = '2';
					$competition['IsCompleted'] = '1';
			 		$this->home->UpdateProcess('competition_master', $competition, 'CompetitionICode', $CompetitionICode);
			 		echo '<img src= "'.base_url().'images/close.png" border="0" width="24" height="24" style="cursor:pointer;" title="Competition Closed"/>';
			/*	}
				else
				{
					echo 'No Judges';   exit;
				}
			}
			else
			{
				echo 'No Competitors';	exit;
			}*/
		}
	}
	
	// list all competitor for the particular competition.
	function listallcompetitioncompetitor()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(4);
		
		// get competitor competiton Details
		$FTField = "FT.CompetitionCompetitorICode, FT.CompetitionICode,  FT.CompetitorICode, FT.CompetitorOrder, FT.CompetitionStartTime, FT.CompetitionEndTime"; 
		$STField = "ST.CompetitionName, ST.CompetitionDate, ST.CompetitionDuration"; 
		$OnCondition = "( FT.CompetitionICode = ST.CompetitionICode)";
		$WhereField = "ST.IsDeleted = '0' AND FT.CompetitionICode = '".$CompetitionICode."'";
		$data['CompDetails'] = $this->home->getAllListDetailsFromBothTable('competition_competitor', 'competition_master', $FTField, $STField, $OnCondition, $WhereField);
		
		// load competition name
		$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionName'] = $this->home->getSingleFieldValue('competition_master', 'CompetitionName', $SingleWhere);
			
		$this->template->write_view('contentpane','admin/listallcompetitioncompetitor', $data, FALSE);
		$this->template->render();
	}
	
	function addstartcompetition()
	{
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(4);
		
		if($this->input->post('StartCompetitionMeridian') == 0) {$StartCompetitionMeridian = 'AM';} else{ $StartCompetitionMeridian = 'PM';}
		if($this->input->post('EndCompetitionMeridian') == 0) {$EndCompetitionMeridian = 'AM';} else{ $EndCompetitionMeridian = 'PM';}
		// competition start time format
		$hour = $this->input->post('StartCompetitionHour');
		$minu = $this->input->post('StartCompetitionMiniute');
		$secs = '00';
		$merd = $StartCompetitionMeridian;
		$time = $hour.':'.$minu.':'.$secs.' '.$merd;
		$StartCompetitionTime =  date('H:i:s', strtotime($time));
		
		// competition end time format
		$Endhour = $this->input->post('EndCompetitionHour');
		$Endminu = $this->input->post('EndCompetitionMiniute');
		$Endsecs = '00';
		$Endmerd = $EndCompetitionMeridian;
		$Endtime = $Endhour.':'.$Endminu.':'.$Endsecs.' '.$Endmerd;
		$EndCompetitionTime =  date('H:i:s', strtotime($Endtime));
	
		$competition['StartTime'] = $StartCompetitionTime;
		$competition['EndTime'] = $EndCompetitionTime;
		$competition['IsStarted'] = 1;
		$competition['CompetitionType'] = $this->input->post('CompetitionType');
		
		$this->home->UpdateProcess('competition_master', $competition, 'CompetitionICode', $CompetitionICode);
		$path = base_url(); redirect(base_url().'admin/user/managestartcompetition/');
	}
	
	function updatecompstarttime()
	{	
		if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		// input
		$CompetitionCompetitorICode = $_POST['CompetitionCompetitorICode'];
		
		// competition time format
		$hourStart = $this->input->post('CompetitionStartTimeHour');
		$minuStart = $this->input->post('CompetitionStartTimeMiniute');
		$secsStart = '00';
		$timeStart = $hourStart.':'.$minuStart.':'.$secsStart;
		$CompetitionStartTime =  date('H:i:s', strtotime($timeStart));
		
		$hourEnd = $this->input->post('CompetitionEndTimeHour');
		$minuEnd = $this->input->post('CompetitionEndTimeMiniute');
		$secsEnd = '00';
		$timeEnd = $hourEnd.':'.$minuEnd.':'.$secsEnd;
		$CompetitionEndTime =  date('H:i:s', strtotime($timeEnd));
			
		$updateval['CompetitionStartTime'] = $CompetitionStartTime;
		$updateval['CompetitionEndTime'] = $CompetitionEndTime;
		
		// update competition_competitor table
		$this->home->UpdateProcess('competition_competitor', $updateval, 'CompetitionCompetitorICode', $CompetitionCompetitorICode);
	}
	
	function deleteConfigResult()
	{
		$ChampionshipICode = $this->uri->segment(4);
		$DivisionICode = $this->uri->segment(5);
		
		 // delete form competitionresult_analysis table
		$wherefield = "ChampionshipICode = '" . $ChampionshipICode . "' AND DivisionICode = '" . $DivisionICode . "' ";
		$this->home->permamnantDelete('competitionresult_analysis', $wherefield);
	
		$path = base_url(); redirect(base_url().'admin/result/managecompetitionresult/');
	}
}

