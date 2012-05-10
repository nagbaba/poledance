<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Judge extends CI_Controller {
	
	function Judge()
	{ 
		parent::__construct();
		$this->load->model('homemodel','home',TRUE);
		$this->load->model('competitionmodel','Mcompetition',TRUE);
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
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$FTField = "FT.*"; $STField = "ST.*"; 
		$OnCondition = "( FT.JudgesICode = ST.UserKeyICode)";
		$WhereField = "ST.UserType = 'J' AND FT.IsDeleted = '0' AND FT.JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$data['JudgesDetails'] = $this->home->getAllDetailsFromIdFromBothTable('judges_master', 'login_credentials', $FTField, $STField, $OnCondition, $WhereField,'JudgesICode');
		
		$this->template->write_view('contentpane','judge_profile',$data,FALSE);
		$this->template->render();
	}
	
	function edit_profile()
	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		if( $this->uri->segment(3)== 'update')
		{
			$JudgesICode				= $this->uri->segment(4);
			
			$SingleWhere = "JudgesICode = '".$JudgesICode."'";
			$val = $this->home->getSingleFieldValue('judges_master', 'CreatedBy', $SingleWhere);
			//if(!($this->session->userdata('LoginUserICode') == $val)){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
			
			$judges['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
			$judges['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
			$judges['FullName'] 		= $judges['FirstName']." ".$judges['LastName'];
			$judges['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
			$judges['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
			$judges['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
			$judges['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
			$judges['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
			$judges['Bio'] 				= addslashes($this->input->post('Bio'));
			
			$judges['ModifiedBy'] 		= 0;
			$judges['ModifiedUserType'] = '';
			$judges['ModifiedDate'] 	= date('Y-m-d H:i:s');
			
			$this->home->UpdateProcess('judges_master', $judges, 'JudgesICode', $JudgesICode);
			
			$LoginCredentialICode = $this->input->post('LoginCredentialICode');
			$judgeslogin['EmailAddress']= mysql_escape_string(trim(strtolower($this->input->post('EmailAddress'))));
			
			if($this->input->post('Password') != ''){
				$judgeslogin['Password'] 	= md5(trim($this->input->post('Password')));
			}
			
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
				}
			}
				$path = base_url(); redirect(base_url().'judge/profile');
		}else{
			$path = base_url(); redirect(base_url().'judge/profile');
		}
	}
	
	function my_competition()
	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$SingleWhere = "JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$HeadJudgeCreaterICode = $this->home->getSingleFieldValue('judges_master', 'CreatedBy', $SingleWhere);
		
		$WhereFieldValue = "CreatedBy = '".$HeadJudgeCreaterICode."' AND IsActive = '0' AND IsDeleted = '0' ORDER BY FullName ASC";
		$Fields = "JudgesICode, FullName";			
		$data['JudgesDetails'] = $this->home->getParticularResults('judges_master', $Fields, $WhereFieldValue);
		
		// get first judge icode
		$JudICode =$this->session->userdata('LoginUserICode');
		
		$JudgesICode = $JudICode;
		
		
		
		$data['JICode'] = $JudgesICode;
		$data['IsJudgeHead'] = $this->session->userdata('IsJudgeHead');
		
		$getAllCompetitionICode = $this->Mcompetition->getjudgecompetitions($JudgesICode);
		
		if(!empty($getAllCompetitionICode))
		{
			$getAllCompetitionICode = implode(',', $getAllCompetitionICode);
			
			$Fields = "CompetitionICode, CompetitionName, CompetitionDate";
			$WhereFieldValue = "CompetitionICode IN (".$getAllCompetitionICode.") AND IsDeleted = '0'";
			$data['CompetitionDetails'] = $this->home->getParticularResults('competition_master', $Fields, $WhereFieldValue);
			
		}
		else
		{
			$data['CompetitionDetails'] = '';
		}
		
		$this->template->write_view('contentpane','mycompetitionlist',$data,FALSE);
		$this->template->render();
	}
		
}
