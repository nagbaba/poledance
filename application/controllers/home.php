<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function Home()
	{ 
		parent::__construct();
		$this->load->model('homemodel','home',TRUE);
		$this->load->helper(array('form', 'url'));
		$this->load->helper('userfunctions');
		$this->load->library('session');
		
		$this->initEmail();
		$this->load->library('email');
		
		$this->load->library('template');
	}
	
	// load index page
	public function index()
	{
		// get last 6 upcoming competition details
		$WhereFieldValue = "CompetitionDate >= '".date("Y-m-d")."' AND IsDeleted = '0' AND IsActive = '0' AND IsCompleted = '0' AND IsPublic = '1' ORDER BY CompetitionDate ASC LIMIT 0,6"; 
		$Fields = "CompetitionICode, CompetitionName";
		$data['Upcomingcommpetitiondetails'] =$this->home->getParticularResults('competition_master', $Fields, $WhereFieldValue);
		
		// get last 6 completed competition details
		//$WhereFieldValue = "CompetitionDate <= '".date("Y-m-d")."' AND IsDeleted = '0' AND IsActive = '0' AND IsStarted = '2' ORDER BY CompetitionDate DESC LIMIT 0,6"; 
		$WhereFieldValue = "IsDeleted = '0' AND IsActive = '0' AND IsStarted = '2' AND IsCompleted = '1' AND IsPublic = '1' ORDER BY CompetitionDate DESC LIMIT 0,6"; 
		$data['Completedcommpetitiondetails'] =$this->home->getParticularResults('competition_master', $Fields, $WhereFieldValue);
		
		$this->load->view('index', $data);
	}
	
	#logout function
	function logout()
	{
		session_destroy();  
		$path = base_url();
		redirect($path);
	}
	
	//load about us page
	function aboutus()
	{
		$this->template->write_view('contentpane','aboutus',FALSE,FALSE);
		$this->template->render();
	}
	
	// load contact us page
	function contactus()
	{
		$this->template->write_view('contentpane','contactus',FALSE,FALSE);
		$this->template->render();
	}
	
	// load competitors page
	function competitors()
	{
		$this->template->write_view('contentpane','competitors',FALSE,FALSE);
		$this->template->render();
	}
	
	// load competitors page
	function competitionresults()
	{
		$this->template->write_view('contentpane','competitionresults',FALSE,FALSE);
		$this->template->render();
	}
	
	// load how page
	function how()
	{
		$this->template->write_view('contentpane','how',FALSE,FALSE);
		$this->template->render();
	}
	
	//load Index login
	function indexlogin()
	{ 
        $this->template->write_view('contentpane','indexlogin',FALSE,FALSE);
		$this->template->render();
	}
	
	//load login 
	function loadlogin()
	{
	 
	   $value = $_POST['value'];
	   echo $value;
	}
	
	function adminlogin()
	{
	 // $this->load->view('eventadminlogin');
	   $this->template->write_view('contentpane','eventadminlogin',FALSE,FALSE);
	   $this->template->render();
	}
	function judgelogin()
	{
	// $this->load->view('judgeslogin');
	 
	  $this->template->write_view('contentpane','judgeslogin',FALSE,FALSE);
	  $this->template->render();
	}
	
	//load judges home page
	function judgeshomepage()
	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$this->template->write_view('contentpane','judgeshomepage',FALSE,FALSE);
		$this->template->render();
	}
	
	// check user login in user_master table
	function checkeventadminlogin()
	{
		$EmailAddress =  $_POST['EmailAddress'];
		$Password     =  $_POST['Password'];
		$UserType     =  $_POST['UserType'];

		$chk_eventadmin = $this->home->LoginCheck('login_credentials', $EmailAddress, $Password, $UserType);
		if(!empty($chk_eventadmin))
		{
			$WhereField = "EventAdminICode = '".$chk_eventadmin['UserKeyICode']."'";
			$Details = $this->home->getAllDetailsFromId('event_admin_master', $WhereField);
			
			if($Details['IsDeleted'] == 1)
			{
				echo 'Invalid'; exit;
			}
			elseif($Details['IsActive'] == 0)
			{
				$this->session->set_userdata('UserICode', $Details['EventAdminICode']);
				$this->session->set_userdata('LoginUserICode', $Details['EventAdminICode']);
				$this->session->set_userdata('UserEmailAddress', $chk_eventadmin['EmailAddress']);
				$this->session->set_userdata('UserName', $Details['FirstName'].' '.$Details['LastName']);
				$this->session->set_userdata('UserType', 'E');
				$this->session->set_userdata('LoginCredentialICode', $chk_eventadmin['LoginCredentialICode']);
				echo 'E'; exit;
			}
			else{ echo 'InActive'; exit;}
		}
		else
		{	
			echo 'Invalid'; exit;
		}
	}
	
	// judges login validation
	function checkjudgeslogin()
	{
		$EmailAddress =  $_POST['EmailAddress'];
		$Password     =  $_POST['Password'];
		$UserType     =  $_POST['UserType'];

		$chk_judges = $this->home->LoginCheck('login_credentials', $EmailAddress, $Password, $UserType);
		if(!empty($chk_judges))
		{
			$WhereField = "JudgesICode = '".$chk_judges['UserKeyICode']."'";
			$Details = $this->home->getAllDetailsFromId('judges_master', $WhereField);
			
			if($Details['IsDeleted'] == 1)
			{
				echo 'Invalid'; exit;
			}
			elseif($Details['IsActive'] == 0)
			{
				$this->session->set_userdata('UserICode', $Details['JudgesICode']);
				$this->session->set_userdata('LoginUserICode', $Details['JudgesICode']);
				$this->session->set_userdata('IsJudgeHead', $Details['IsHead']); 
				$this->session->set_userdata('UserEmailAddress', $chk_judges['EmailAddress']);
				$this->session->set_userdata('UserName', $Details['FirstName'].' '.$Details['LastName']);
				$this->session->set_userdata('UserType', 'J');
				$this->session->set_userdata('LoginCredentialICode', $chk_judges['LoginCredentialICode']);
				echo 'J'; exit;
			}
			else{ echo 'InActive'; exit;}
		}
		else
		{	
			echo 'Invalid'; exit;
		}
	}
	
	// competitors login validation
	function checkcompetitorslogin()
	{
		$EmailAddress =  $_POST['EmailAddress'];
		$Password     =  $_POST['Password'];
		$UserType     =  $_POST['UserType'];

		$chk_competitors = $this->home->LoginCheck('login_credentials', $EmailAddress, $Password, $UserType);
		if(!empty($chk_competitors))
		{
			$WhereField = "CompetitorICode = '".$chk_competitors['UserKeyICode']."'";
			$Details = $this->home->getAllDetailsFromId('competitor_master', $WhereField);
			
			if($Details['IsDeleted'] == 1)
			{
				echo 'Invalid'; exit;
			}
			elseif($Details['IsActive'] == 0)
			{
				$this->session->set_userdata('UserICode', $Details['CompetitorICode']);
				$this->session->set_userdata('LoginUserICode', $Details['CompetitorICode']);
				$this->session->set_userdata('IsJudgeHead', ''); 
				$this->session->set_userdata('UserEmailAddress', $chk_competitors['EmailAddress']);
				$this->session->set_userdata('UserName', $Details['FirstName'].' '.$Details['LastName']);
				$this->session->set_userdata('UserType', 'C');
				$this->session->set_userdata('LoginCredentialICode', $chk_competitors['LoginCredentialICode']);
				echo 'C'; exit;
			}
			else{ echo 'InActive'; exit;}
		}
		else
		{	
			echo 'Invalid'; exit;
		}
	}
	
	
	//load password screen
	function loadforgotPassword()
	{
		$this->load->view('forgotpassword');
	}
	
	//load user login form
	function userloginform()
	{
		$this->load->view('userloginform');	
	}
	
	// send password 
	function sendPassword()
	{
		$EmailAddress = $_POST['EmailAddress'];
		$WhereFieldValue = "EmailAddress = '".$EmailAddress."'";
		$Available = $this->home->getAllDetailsFromId('login_credentials',  $WhereFieldValue);
		
		if(!empty($Available))
		{
			$UniqID = uniqid();	$NewPassword = md5($UniqID);   //assign new password
			
			// change the password and update in user_master table
			$changepassword['Password'] = $NewPassword;
			$this->home->UpdateProcess('login_credentials', $changepassword, 'EmailAddress', $EmailAddress);
			
			// send mail to user
			$msg = 'Hi ! <br><br>Your Pole Dance Account login credentials are:<br><br>Email Address :&nbsp; '.$Available['EmailAddress'].'<br>Password  :&nbsp; '.$UniqID.'<br><br><br>Thanks & Regards, <br> Pole Dance';
			
			// send user id / password through this email id
			$this->email->clear(TRUE);
			$this->email->to($EmailAddress);
			$this->email->from('admin@poledance.com');
			$this->email->subject('Your POLE DANCE application login account details');
			$this->email->message($msg);
			if($this->email->send()){
				echo "send";
			}else{
				echo "fail";
			}
		}
		else
		{
			echo 'notindb'; exit;
		}
	}
	
	function register()
	{
		//if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		$WhereFieldValue = "IsDeleted ='0' AND IsActive='0'"; $OrderFiledValue = "DivisionName ASC";
		$data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);
		
		$this->template->write_view('contentpane','register_competitor',$data,FALSE);
		$this->template->render();
	}
	
	function register_judges()
	{
		//if(!($this->session->userdata('UserType') == 'C')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$this->template->write_view('contentpane','register_judges',FALSE,FALSE);
		$this->template->render();
	}
	
	function addcompetitor()
	{
		//if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }

		if( $this->uri->segment(3) == 'insert')
		{
			$isEmailAlreadyExist = $this->home->isEmailExist('login_credentials',$this->input->post('EmailAddress'));
			if(!$isEmailAlreadyExist){
				$code = uniqid();
				
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
				$competitor['DivisionICode'] 	= $this->input->post('DivisionICode');
				$competitor['IsActive'] 	    = 1;
				$competitor['CreatedBy'] 		= 1;
				$competitor['CreatedUserType'] 	= $this->session->userdata('UserType');
				$competitor['CreatedDate'] 		= date('Y-m-d H:i:s');
				$competitor['activation_code'] 		= $code;
				
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
						$this->home->UpdateProcess('competitor_master', $ProfileImage, 'CompetitorICode', $CompetitorICode);
					}
				}
				
				
										 
				$this->session->set_flashdata('act_msg', 'true');
				
				$actlink = '<a href="'.base_url().'/home/activate_competitor/'.$code.'">Click here to activate your account</a>';
				
				$this->epoleSendEmail("Your activation link is ".$actlink, "Account Activation", "admin@epolejudge.com", 'no-reply', mysql_escape_string(trim(strtolower($this->input->post('EmailAddress')))));
				
				$path = base_url(); redirect(base_url().'home');
				
			}else{
				
				$this->session->set_flashdata('register_msg', 'true');
			
				$path = base_url(); redirect(base_url().'home/register');
			}
		}
		else
		{
			$path = base_url(); redirect(base_url().'home');
		}
	}
	
	function addjudges()
	{
		//if(!($this->session->userdata('UserType') == 'E')){ $path = base_url().'admin/home/evenadminlogout/'; redirect($path); exit; }
		
		if( $this->uri->segment(3)== 'insert')
		{
			$isEmailAlreadyExist = $this->home->isEmailExist('login_credentials',$this->input->post('EmailAddress'));
			if(!$isEmailAlreadyExist){
				$code = uniqid();
				
				$judges['FirstName']		= mysql_escape_string(trim($this->input->post('FirstName')));
				$judges['LastName'] 		= mysql_escape_string(trim($this->input->post('LastName')));
				$judges['FullName'] 		= $judges['FirstName']." ".$judges['LastName'];
				$judges['AddressLine1'] 	= mysql_escape_string(trim($this->input->post('AddressLine1')));
				$judges['AddressLine2'] 	= mysql_escape_string(trim($this->input->post('AddressLine2')));
				$judges['PhoneNumber'] 		= mysql_escape_string(trim($this->input->post('PhoneNumber')));
				$judges['MobileNumber'] 	= mysql_escape_string(trim($this->input->post('MobileNumber')));
				$judges['Country'] 			= mysql_escape_string(trim($this->input->post('Country')));
				$judges['Bio'] 				= addslashes($this->input->post('Bio'));
				$judges['IsHead']		    = 0;
				$judges['IsActive'] 	    = 1;
				$judges['CreatedBy'] 		= 1;
				$judges['CreatedUserType'] 	= $this->session->userdata('UserType');
				$judges['CreatedDate'] 		= date('Y-m-d H:i:s');
				$judges['activation_code'] 		= $code;
				
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
						$this->home->UpdateProcess('judges_master', $ProfileImage, 'JudgesICode', $JudgesICode);
					}
				}
				
				$this->session->set_flashdata('act_msg', 'true');
				
				$actlink = '<a href="'.base_url().'/home/activate_judges/'.$code.'">Click here to activate your account</a>';
				
				$this->epoleSendEmail("Your activation link is ".$actlink, "Account Activation", "admin@epolejudge.com", 'no-reply', mysql_escape_string(trim(strtolower($this->input->post('EmailAddress')))));
				
				$path = base_url(); redirect(base_url().'home/');
			
			}else{
				$this->session->set_flashdata('register_msg', 'true');
			
				$path = base_url(); redirect(base_url().'home/register_judges');
			}
		}
		else
		{
			$this->template->write_view('contentpane','home', FALSE, FALSE);
			$this->template->render();
		}
	}
	
	function activate_competitor($code)
	{
		$WhereFieldValue = "activation_code = '".$code."'";
		$userDetails = $this->home->getAllDetailsFromId('competitor_master', $WhereFieldValue);
		
		$WhereFieldValue1 = "UserKeyICode = '".$userDetails['CompetitorICode']."'";
		$emailDetails = $this->home->getAllDetailsFromId('login_credentials', $WhereFieldValue1);
				
		$active_acc['IsActive'] = 0;
		$active_acc['activation_code'] = '';
		$this->home->UpdateProcess('competitor_master', $active_acc, 'CompetitorICode', $userDetails['CompetitorICode']);
		
		$this->session->set_flashdata('activated_msg', 'true');
			
		/*$actlink = '<a href="'.base_url().'/home/activate_judges/'.$code.'">Click here to activate your account</a>';*/
			
		$this->epoleSendEmail("Your account has been activated", "Account Activated", "admin@epolejudge.com", 'no-reply', $emailDetails['EmailAddress']);
			
		$path = base_url(); redirect(base_url().'home/');
		
		
	}
	
	function activate_judges($code)
	{
		$WhereFieldValue = "activation_code = '".$code."'";
		$userDetails = $this->home->getAllDetailsFromId('judges_master', $WhereFieldValue);
		
		$WhereFieldValue1 = "UserKeyICode = '".$userDetails['JudgesICode']."'";
		$emailDetails = $this->home->getAllDetailsFromId('login_credentials', $WhereFieldValue1);
		
		$active_acc['IsActive'] = 0;
		$active_acc['activation_code'] = '';
		$this->home->UpdateProcess('judges_master', $active_acc, 'JudgesICode', $userDetails['JudgesICode']);
		
		$this->session->set_flashdata('activated_msg', 'true');
			
		/*$actlink = '<a href="'.base_url().'/home/activate_judges/'.$code.'">Click here to activate your account</a>';*/
			
		$this->epoleSendEmail("Your account has been activated", "Account Activated", "admin@epolejudge.com", 'no-reply', $emailDetails['EmailAddress']);
			
		$path = base_url(); redirect(base_url().'home/');
		
		
	}
	
	 /**
     * initEmail: Initializes email.
     *
     * @since : 1.0.
     * @params : None.
     * @return : bool true/false.
     *
     */
    function initEmail()
    {
        $this->load->library('email');

        $config['useragent'] = 'localhost.com';
        $config['mailtype']  = 'html';
        $config['protocol']  = 'sendmail';
        $config['mailpath']  = '/usr/sbin/sendmail';
        $config['wordwrap']  = TRUE;
        $config['charset']   = 'iso-8859-1';

        $this->email->initialize($config);

        return true;
    }


    /**
     * dcSendEmail : Sends email.
     *
     * @since : 1.0.
     * @params : String $message,
     * 		 String $subject,
     *           String $from,
     *           String $replyTo,
     *           String $to.
     * @return : bool true/false.
     *
     */
    function epoleSendEmail($message, $subject, $from, $replyTo, $to)
    {
        $this->initEmail();
        $this->email->message($message);
        $this->email->subject($subject);
        $this->email->from($from);
        $this->email->reply_to($replyTo);
        $this->email->to($to);
        $this->email->send();
		
        /*echo $this->email->print_debugger();
        exit;*/
        
        return true;
    }
	
	// check email id exist in db
	function checkEmailIdExist()
	{
		//if(!($this->session->userdata('UserType'))){ $path = base_url().'admin/home/logout/'; redirect($path); exit; }
		
		$EmailAddress = $_POST['EmailAddress'];
		
			$WhereFieldValue = "EmailAddress = '".$EmailAddress."'";
			$checkOldPaswword = $this->home->checkThisFieldValueInTable('login_credentials',  $WhereFieldValue);
			if($checkOldPaswword == '0'){echo 'insert';exit;} else{ echo 'Exist';  exit;}
		
	}
	

}
