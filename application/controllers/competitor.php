<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Competitor extends CI_Controller {
	
	function Competitor()
	{ 
		parent::__construct();
		$this->load->model('homemodel','home',TRUE);
		
		//edited by 4axiz
		
		$this->load->model("competitionmodel");
		
		//edited by 4axiz
		
		$this->load->helper(array('form', 'url'));
		$this->load->helper('userfunctions');
		$this->load->library('session');
		$this->load->library('email');
		
		$this->load->library('template');
	}
	
	// load index page
	public function index()
	{
		// get last 6 upcoming competition details
		$WhereFieldValue = "CompetitionDate >= '".date("Y-m-d")."' AND IsDeleted = '0' AND IsActive = '0' AND IsCompleted = '0' ORDER BY CompetitionDate ASC LIMIT 0,6"; 
		$Fields = "CompetitionICode, CompetitionName";
		$data['Upcomingcommpetitiondetails'] =$this->home->getParticularResults('competition_master', $Fields, $WhereFieldValue);
		
		// get last 6 completed competition details
		//$WhereFieldValue = "CompetitionDate <= '".date("Y-m-d")."' AND IsDeleted = '0' AND IsActive = '0' AND IsStarted = '2' ORDER BY CompetitionDate DESC LIMIT 0,6"; 
		$WhereFieldValue = "IsDeleted = '0' AND IsActive = '0' AND IsStarted = '2' ORDER BY CompetitionDate DESC LIMIT 0,6"; 
		$data['Completedcommpetitiondetails'] =$this->home->getParticularResults('competition_master', $Fields, $WhereFieldValue);
		
		$this->load->view('index', $data);
	}
	
	//load profile page
	function profile()
	{
		if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		/*$WhereFieldValue = "CompetitorICode = '".$this->session->userdata('LoginUserICode')."'";
		$data['CompetitorDetails'] = $this->home->getAllDetailsFromId('competitor_master', $WhereFieldValue);*/
		
		$FTField = "FT.*"; $STField = "ST.*"; 
			$OnCondition = "( FT.CompetitorICode = ST.UserKeyICode)";
			$WhereField = "ST.UserType = 'C' AND FT.IsDeleted = '0' AND FT.CompetitorICode = '".$this->session->userdata('LoginUserICode')."'";
			$data['CompetitorDetails'] = $this->home->getAllDetailsFromIdFromBothTable('competitor_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField,'CompetitorICode');
		
		$WhereFieldValue = "IsDeleted ='0'"; $OrderFiledValue = "DivisionName ASC";
		$data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);
		
		$SingleWhere = "CompetitorICode = '".$this->session->userdata('LoginUserICode')."'";
		$Fields = "*";
		$data['SelDivision'] = $this->home->getParticularResults('competitor_division', $Fields, $SingleWhere);	
		
		$this->template->write_view('contentpane','profile',$data,FALSE);
		$this->template->render();
	}
	
	function edit_profile()
	{
		if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		if( $this->uri->segment(3)== 'update')
		{
			
			$CompetitorICode			= $this->uri->segment(4);
			$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
			$val = $this->home->getSingleFieldValue('competitor_master', 'CreatedBy', $SingleWhere);
		//	if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
			
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
			//$competitor['DivisionICode'] 	= serialize($this->input->post('DivisionICode'));
			$competitor['embed_code'] 	    = $this->input->post('embed_code');
			$competitor['ModifiedBy'] 		= 0;
			$competitor['ModifiedUserType'] = '';
			$competitor['ModifiedDate'] 	= date('Y-m-d H:i:s');
			
			$this->home->UpdateProcess('competitor_master', $competitor, 'CompetitorICode', $CompetitorICode);
			
			$LoginCredentialICode = $this->input->post('LoginCredentialICode');
			$competitorlogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			
			if($this->input->post('Password') != ''){
				$competitorlogin['Password'] 	= md5(trim($this->input->post('Password')));
			}
			$this->home->UpdateProcess('login_credentials', $competitorlogin, 'LoginCredentialICode', $LoginCredentialICode);
			
			
			//change division code
			
			//this code is changed by 4axiz
			
//			$divCodes = $this->input->post('DivisionICode');
//		
//			if(!empty($divCodes))
//			{
//				foreach($divCodes as $divCode)
//				{
//					$WhereFieldValue = "CompetitorICode = '".$this->session->userdata('LoginUserICode')."' AND DivisionICode = '".$divCode."'"; 
//					$isValueExist = $this->home->isValueExist('competitor_division', $WhereFieldValue);
//					
//					//echo $isValueExist;
//					if($isValueExist == 'false')
//					{
//						$competitor_division['CompetitorICode']		= $this->session->userdata('LoginUserICode');
//						$competitor_division['DivisionICode']		= $divCode;
//					
//						$this->home->InsertQuery('competitor_division', $competitor_division);
//					}
//				}
//			}
			
			//this code is changed by 4axiz
		
//		exit; 
			
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
				}

			}
			
			//$path = base_url(); redirect(base_url().'competitor/profile');
		
		/*else
		{
		
			$path = base_url(); redirect(base_url().'competitor/profile');
		}*/
		
		 // edit profile video 
			$configv['upload_path'] = './uploads/videos/';
			$configv['allowed_types'] = 'flv|mov|mpeg|mpg|avi';
			/*$config['max_size']	= '100';*/
			$configv['file_name'] = 	uniqid();
			
			$this->load->library('upload', $configv);
			$this->upload->initialize($configv);
			
			if ($this->upload->do_upload('video'))
			{
				
				$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
				$OldVideoName = $this->home->getSingleFieldValue('competitor_master', 'video', $SingleWhere);
				if($OldVideoName!='')
				{
					unlink('./uploads/videos/'.$OldVideoName);
				}
				
				$data = array('upload_data' => $this->upload->data());	
				foreach($data as $val)
				{
					$ProfileVideo['video'] = $val['file_name'];
					$this->home->UpdateProcess('competitor_master', $ProfileVideo, 'CompetitorICode', $CompetitorICode);
				}
			}
			
			$path = base_url(); redirect(base_url().'competitor/profile');
		}
		else
		{
		
			$path = base_url(); redirect(base_url().'competitor/profile');
		}
	}
	
	function apply()
	{
		if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		/*$WhereFieldValue = "CompetitorICode = '".$this->session->userdata('LoginUserICode')."'";
		$data['CompetitorDetails'] = $this->home->getAllDetailsFromId('competitor_master', $WhereFieldValue);*/
		
		
		$WhereFieldValue = "IsStarted='1' AND ISCompleted='0' AND IsDeleted ='0'"; $OrderFiledValue = "CompetitionICode ASC";
		$data['Competions'] = $this->home->getAllDetails('competition_master', $WhereFieldValue, $OrderFiledValue);
		
		//this code was edited by 4axiz
		
		$WhereFieldValue = "IsDeleted ='0'"; $OrderFiledValue = "DivisionName ASC";
		$data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);
		
		//this code was edited by 4axiz
		
		$this->template->write_view('contentpane','apply',$data,FALSE);
		$this->template->render();
	}
	
	
	function ajaxCompetitionSelect(){  // edited by 4axiz
		if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
				
		$data['CompetionDivisioin'] = $this->competitionmodel->competitionDivisions($_POST['CompetitionICode']);
		$str = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td align='left' height='15' colspan='2'></td></tr>";
		
		foreach ($data['CompetionDivisioin'] as $val){
			$checked = "";
			
			$WhereFieldValue = "CompetitionICode = '".$_POST['CompetitionICode']."' AND DivisionICode = '".$val."'";
			$CompetitorICode = $this->home->getAllIdInArrayFormate('competition_competitor', $WhereFieldValue, 'CompetitorICode');
			
			foreach ($CompetitorICode as $value){
				if($this->session->userdata('LoginUserICode') == $value) $checked = "checked='checked' disabled = 'disabled'";
			}			
			$divisionName = $this->home->getSingleFieldValue('division_master', 'DivisionName', "DivisionICode = '".$val."'");
			$str  = $str."<tr><td align='left' width='11%' height='27'><input id='DivisionICode[]' type='checkbox' value='".$val."' name='DivisionICode[]'".$checked."><td>";
			$str = $str."<td align='left' width='89%'><span class='box_title'>".$divisionName."</span></td></tr>";
		}
		$str = $str."</table>";
		echo $str;
		 
	}
	
	function apply_to_competition($CompetitorICode='')  // this functionality of this function is edited by 4axiz
	{
		$CompetitionICode = $this->input->post('CompetitionICode');
      	$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND CompetitorICode = '".$this->session->userdata('LoginUserICode')."'"; 
		//$hasApplied = $this->home->hasApplied('competition_competitor', $WhereFieldValue);
		
		
			
		//if($hasApplied == 'false')
		//{
			
			//edited by 4axiz
			
			//$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
			//$DivisionICode = $this->home->getSingleFieldValue('competitor_master', 'DivisionICode', $SingleWhere);
			if(isset($_POST['DivisionICode'])){			
				foreach ($_POST['DivisionICode'] as $val){
					$highestOrder = $this->home->getOrderOfLastCompetitor($CompetitionICode,$val);
					$comp_competitor['CompetitionICode'] 	= $CompetitionICode;
					$comp_competitor['DivisionICode']		= $val;
					$comp_competitor['CompetitorICode']		= $CompetitorICode;
					$comp_competitor['CompetitorOrder']		= $highestOrder['highest_order']+1;
					//$this->home->InsertQuery('competition_competitor', $comp_competitor);
					$WhereFieldValue = "CompetitionICode= '".$CompetitionICode."' AND CompetitorICode = '".$comp_competitor['CompetitorICode']."' AND IsDeleted = '0' AND DivisionICode='".$comp_competitor['DivisionICode'] ."'";
					$CCICode = $this->home->checkThisFieldValueInTableAndReturnICode('competition_competitor',  $WhereFieldValue, 'CompetitionCompetitorICode');
					if($CCICode > 0){
						// update process
						//$this->home->UpdateProcess('competition_competitor', $comp_competitor, 'CompetitionCompetitorICode', $CCICode);
					}
					else{
						// insert process
						$CompetitionCompetitorICode = $this->home->InsertQuery('competition_competitor', $comp_competitor);
					}
					
				}
			}			
			
			//edited by 4axiz
			
			//print_r($comp_competitor);
			
			
			
			$this->session->set_flashdata('apply_msg', 'true');
				
			$path = base_url(); redirect(base_url().'competitor/apply');
		
//		}else{
//			$this->session->set_flashdata('apply_msg', 'false');
//			
//			$path = base_url(); redirect(base_url().'competitor/apply');
//		
//		}
	}
	
	function video($CompetitorICode)
	{
	if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$data['CompetitorICode'] = $CompetitorICode;
		
		$FTField = "FT.*"; $STField = "ST.*"; 
		$OnCondition = "( FT.CompetitorICode = ST.UserKeyICode)";
		$WhereField = "ST.UserType = 'C' AND FT.IsDeleted = '0' AND FT.CompetitorICode = '".$data['CompetitorICode']."'";
		$data['CompetitorDetails'] = $this->home->getAllDetailsFromIdFromBothTable('competitor_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField,'CompetitorICode');
		//$this->load->view('view_video',$data);	
		$this->template->write_view('contentpane','view_video',$data,FALSE);
		$this->template->render();
	}
	
	function remove_video($CompetitorICode)
	{
		if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$SingleWhere = "CompetitorICode = '".$CompetitorICode."'";
		$OldVideoName = $this->home->getSingleFieldValue('competitor_master', 'video', $SingleWhere);
		if($OldVideoName!='')
		{
			unlink('./uploads/videos/'.$OldVideoName);
		}
				
		$ProfileVideo['video'] = '';
		$this->home->UpdateProcess('competitor_master', $ProfileVideo, 'CompetitorICode', $CompetitorICode);
		$this->session->set_flashdata('remove_video', 'true');
		$path = base_url(); redirect(base_url().'competitor/profile');
	}
	
	function loadChangeCompetitorPassword()
	{
		$this->load->view('change_competitor_password');
	}
	
	
}
