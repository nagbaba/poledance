<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Competition extends CI_Controller {
	
	function Competition()
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
	
	// load started competition list
	function startedcompetitionlist()
	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$FTField = "FT.CompetitionICode, FT.CompetitionName, FT.CompetitionDate"; $STField="ST.JudgesICode"; $OnCondition = "( FT.CompetitionICode = ST.CompetitionICode )"; 
		$WhereField = "FT.IsDeleted = '0' AND IsStarted = '1' AND ST.IsDeleted = '0' AND ST.JudgesICode = '".$this->session->userdata('LoginUserICode')."' AND FT.CompetitionDate >='".date('Y-m-d')."'"; $OrderFiledValue = "FT.CompetitionDate DESC";
		
		$data['CompetitionDetails'] = $this->home->getAllDetailsFromBothTable('competition_master', 'competition_judges', $FTField, $STField, $OnCondition, $WhereField, $OrderFiledValue);
		
		$this->template->write_view('contentpane','startedcompetitionlist',$data,FALSE);
		$this->template->render();
	}
	
	function competitionresultpost()
	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		$CompetitionICode = $this->uri->segment('3');
		
		// get first competition competitor icode

		$CompetitionCompetitorICode = $this->Mcompetition->getFirstCompetitionCompetitor($CompetitionICode);	
		redirect(base_url().'competition/PostResult/'.$CompetitionICode.'/'.$CompetitionCompetitorICode.'/');
	}
	
   function PostResult()
   {
   		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(3);
		$CompetitionCompetitorICode = $this->uri->segment(4);
		
		// if check alredy result posted
		$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
		$IsResultPosted = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
		if($IsResultPosted > 0 ){ $path = base_url().'competition/viewresultpage/'.$CompetitionICode.'/'.$CompetitionCompetitorICode.'/'; redirect($path); exit; }
		
		// post result section
		$data['CompetitionICode'] = $CompetitionICode;
		$data['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
		$data['CompetitorNameList'] = $this->Mcompetition->getCompetitionCompetitor($CompetitionICode); // for left menu
		
		// competition Name
		$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
		$Fields = "CompetitionName, IsStarted";
		$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $SingleWhere);
		if($data['CompetitionDetails']['IsStarted'] == 2 ){ $data['disable'] = 'disabled="disabled"';}else{ $data['disable'] = '';} // for text box disable
		
		$Fields = "CompetitionName, CreatedBy, IsCompleted";
		$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $WhereFieldValue);
		
		
		// comeptition details
		$data['TitleDetails'] = $this->Mcompetition->getTitleDetails($CompetitionCompetitorICode);
		
		// judges details
		$Fields = "FullName, Country";
		$WhereFieldValue = "JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$data['JudgesDetails'] = $this->home->getParticularResultsFromId('judges_master', $Fields, $WhereFieldValue);
		
		$WhereFieldValue="DivisionICode='".$data['TitleDetails']['DivisionICode']."' AND IsDeleted='0' AND CreatedBy='".$data['CompetitionDetails']['CreatedBy']."'";
		$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
		$AllSectionICode = implode(',', $AllSectionICode);
		// section details
		if(!empty($AllSectionICode))
		{
			$WhereFieldValue = "SectionICode IN (".$AllSectionICode.") AND IsDeleted='0' AND IsActive='0' AND CreatedBy = '".$data['CompetitionDetails']['CreatedBy']."'"; 
			$OrderFiledValue = "SectionName ASC";
			$data['Sectiondetails'] = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
		}
			
		$this->template->write_view('contentpane', 'postResult', $data, FALSE);
		$this->template->render();
   }
   
   // edit posted result
   function editpostedresult()
   {
   		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(3);
		$CompetitionCompetitorICode = $this->uri->segment(4);
		
		// post result section
		$data['CompetitionICode'] = $CompetitionICode;
		$data['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
		$data['CompetitorNameList'] = $this->Mcompetition->getCompetitionCompetitor($CompetitionICode); // for left menu
		
		// competition Name
		$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
		$Fields = "CompetitionName, IsStarted";
		$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $SingleWhere);
		if($data['CompetitionDetails']['IsStarted'] == 2 ){ $data['disable'] = 'disabled="disabled"';}else{ $data['disable'] = '';} // for text box disable
		
		$Fields = "CompetitionName, CreatedBy";
		$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $WhereFieldValue);
		
		// comeptition details
		$data['TitleDetails'] = $this->Mcompetition->getTitleDetails($CompetitionCompetitorICode);
		
		// judges details
		$Fields = "FullName, Country";
		$WhereFieldValue = "JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$data['JudgesDetails'] = $this->home->getParticularResultsFromId('judges_master', $Fields, $WhereFieldValue);
		
		$WhereFieldValue="DivisionICode='".$data['TitleDetails']['DivisionICode']."' AND IsDeleted='0' AND CreatedBy='".$data['CompetitionDetails']['CreatedBy']."'";
		$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
		$AllSectionICode = implode(',', $AllSectionICode);
		// section details
		if(!empty($AllSectionICode))
		{
			$WhereFieldValue = "SectionICode IN (".$AllSectionICode.") AND IsDeleted='0' AND IsActive='0' AND CreatedBy = '".$data['CompetitionDetails']['CreatedBy']."'"; 
			$OrderFiledValue = "SectionName ASC";
			$data['Sectiondetails'] = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
		}
			
		$WhereF = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND CompetitorICode = '".$data['TitleDetails']['CompetitorICode']."'";
		$data['Comment'] = $this->home->getSingleFieldValue('comments', 'Comment_text', $WhereF);	
			
		$this->template->write_view('contentpane', 'editpostedresult', $data, FALSE);
		$this->template->render();
   }
   
   // update edit result
   function saveupdateresult()
   {
   		$CompetitionCompetitorICode = $this->input->post('CompetitionCompetitorICode');
		$CompetitionIcode = $this->input->post('CompetitionICode');
		
		$fval = $this->input->post('fieldname');
		$PRICode = array();
		foreach ($fval as $row) 
		{ 
			$exp = explode('_', $row);
			$txtfieldname = $row;
			$SectionICode = $exp[1];
			$SubsectionIcode = $exp[2];
			$MaximumPoints = $exp[3];
			$CompetitionIcode = $CompetitionIcode;
			
			// insert into 'post_result' table
			$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$Cnt = $this->home->getTotalCountOfRecords('post_result', $WhereFieldValue);
			if($Cnt == 0)
			{
				$postresult['CompetitionCompetitorICode']	= $CompetitionCompetitorICode;
				$postresult['CompetitionICode']	= $CompetitionIcode;
				$postresult['SectionICode'] 	= $SectionICode;
				$postresult['CompetitorICode'] 	= $this->input->post('CompetitorICode');
				$postresult['CreatedBy'] 	= $this->session->userdata('LoginUserICode');
				$postresult['CreatedDate'] 	= date('Y-m-d H:i:s');
				$PostResultIcode = $this->home->InsertQuery('post_result', $postresult);
				$PRICode[] = $PostResultIcode;
			}
			else
			{
				$PostResultIcode = $this->home->getSingleFieldValue('post_result', 'PostResultIcode', $WhereFieldValue);
				$PRICode[] = $PostResultIcode;
			}
			
			// insert into 'post_subsection_result' table
			 $WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$SectionICode."' AND SubsectionIcode = '".$SubsectionIcode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			 $RCnt = $this->home->getTotalCountOfRecords('post_subsection_result', $WhereFieldValue);
			 
			 if($RCnt == 0) // insert new records in 'post_subsection_result' table
			 {
				 $postsubresult['PostResultIcode'] = $PostResultIcode;
				 $postsubresult['CompetitionCompetitorICode']	= $CompetitionCompetitorICode;
				 $postsubresult['SectionICode']	= $SectionICode;
				 $postsubresult['SubsectionIcode'] = $SubsectionIcode;
				 $postsubresult['Subsectionsecuredpoints'] = $this->input->post($txtfieldname);
				 $postsubresult['MaximumPoints'] = $MaximumPoints;
				 $postsubresult['CreatedBy'] 	= $this->session->userdata('LoginUserICode');
				 $postsubresult['CreatedDate'] 	= date('Y-m-d H:i:s');
				 
				 $SubsectionresultIcode = $this->home->InsertQuery('post_subsection_result', $postsubresult);
			 }
			 else // update records in 'post_subsection_result' table
			 {
			 	$set = "Subsectionsecuredpoints = '".$this->input->post($txtfieldname)."'";
			 	$this->home->UpdateProcessUsingMultifield('post_subsection_result', $set, $WhereFieldValue);
			 }
		}
		// update securedpoints field in 'post_result' table
		if(!empty($PRICode))
		{
			foreach ($PRICode as $rez)
			{
				$PostResultIcode = $rez;
				$WhereField = "PostResultIcode = '".$PostResultIcode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' "; 
				
				$SecuredPoints = $this->home->getSumOfParticularFieldFromId('post_subsection_result', 'Subsectionsecuredpoints', $WhereField ); 
				$Totalpoints = $this->home->getSumOfParticularFieldFromId('post_subsection_result', 'MaximumPoints', $WhereField ); 
				
				// update 'post_result' table
				$updpostresult['SecuredPoints'] = $SecuredPoints;
				$updpostresult['Totalpoints'] = $Totalpoints;
				$this->home->UpdateProcess('post_result', $updpostresult, 'PostResultIcode', $PostResultIcode);
			}
		}
		
		$WhereFld = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionIcode."' AND CompetitorICode = '".$this->input->post('CompetitorICode')."'";
		$data['Comment'] = $this->home->getSingleFieldValue('comments', 'Comment_text', $WhereFld);
		
		if($data['Comment'] != ''){
			$WhereF = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionIcode."' AND CompetitorICode = '".$this->input->post('CompetitorICode')."'";
			$set = "Comment_text = '".$this->input->post('Comment')."'";
			$this->home->UpdateProcessUsingMultifield('comments', $set, $WhereF);
		}else{
			$comment['CompetitionCompetitorICode']	= $CompetitionCompetitorICode;
			$comment['CompetitionICode']	= $CompetitionIcode;
			$comment['CompetitorICode'] 	= $this->input->post('CompetitorICode');
			$comment['Comment_text'] 	= $this->input->post('Comment');
			//insert comment
			$this->home->InsertQuery('comments', $comment);
		}
		// load success page
		$path = base_url(); 
		redirect(base_url().'competition/viewupdateresultpage/'.$CompetitionIcode.'/'.$CompetitionCompetitorICode.'/save/');
   }
	
	// insert result for competitor
   	function saveresult()
   	{
		$CompetitionCompetitorICode = $this->input->post('CompetitionCompetitorICode');
		$CompetitionIcode = $this->input->post('CompetitionICode');
		
		$fval = $this->input->post('fieldname');
		$PRICode = array();
		foreach ($fval as $row) 
		{ 
			$exp = explode('_', $row);
			$txtfieldname = $row;
			$SectionICode = $exp[1];
			$SubsectionIcode = $exp[2];
			$MaximumPoints = $exp[3];
			$CompetitionIcode = $CompetitionIcode;
			
			// insert into 'post_result' table
			$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$SectionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$Cnt = $this->home->getTotalCountOfRecords('post_result', $WhereFieldValue);
			if($Cnt == 0)
			{
				$postresult['CompetitionCompetitorICode']	= $CompetitionCompetitorICode;
				$postresult['CompetitionICode']	= $CompetitionIcode;
				$postresult['SectionICode'] 	= $SectionICode;
				$postresult['CompetitorICode'] 	= $this->input->post('CompetitorICode');
				$postresult['CreatedBy'] 	= $this->session->userdata('LoginUserICode');
				$postresult['CreatedDate'] 	= date('Y-m-d H:i:s');
				$PostResultIcode = $this->home->InsertQuery('post_result', $postresult);
				$PRICode[] = $PostResultIcode;
			}
			
			// insert into 'post_subsection_result' table
			 $WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$SectionICode."' AND SubsectionIcode = '".$SubsectionIcode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			 $RCnt = $this->home->getTotalCountOfRecords('post_subsection_result', $WhereFieldValue);
			 
			 if($RCnt == 0)
			 {
				 $postsubresult['PostResultIcode'] = $PostResultIcode;
				 $postsubresult['CompetitionCompetitorICode']	= $CompetitionCompetitorICode;
				 $postsubresult['SectionICode']	= $SectionICode;
				 $postsubresult['SubsectionIcode'] = $SubsectionIcode;
				 $postsubresult['Subsectionsecuredpoints'] = $this->input->post($txtfieldname);
				 $postsubresult['MaximumPoints'] = $MaximumPoints;
				 $postsubresult['CreatedBy'] 	= $this->session->userdata('LoginUserICode');
				 $postsubresult['CreatedDate'] 	= date('Y-m-d H:i:s');
				 
				 $SubsectionresultIcode = $this->home->InsertQuery('post_subsection_result', $postsubresult);
			  }
		}
		// update securedpoints field in 'post_result' table
		if(!empty($PRICode))
		{
			foreach ($PRICode as $rez)
			{
				$PostResultIcode = $rez;
				$WhereField = "PostResultIcode = '".$PostResultIcode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."' "; 
				
				$SecuredPoints = $this->home->getSumOfParticularFieldFromId('post_subsection_result', 'Subsectionsecuredpoints', $WhereField ); 
				$Totalpoints = $this->home->getSumOfParticularFieldFromId('post_subsection_result', 'MaximumPoints', $WhereField ); 
				
				// update 'post_result' table
				$updpostresult['SecuredPoints'] = $SecuredPoints;
				$updpostresult['Totalpoints'] = $Totalpoints;
				$this->home->UpdateProcess('post_result', $updpostresult, 'PostResultIcode', $PostResultIcode);
			}
		}
	
		$comment['CompetitionCompetitorICode']	= $CompetitionCompetitorICode;
		$comment['CompetitionICode']	= $CompetitionIcode;
		$comment['CompetitorICode'] 	= $this->input->post('CompetitorICode');
		$comment['Comment_text'] 	= $this->input->post('Comment');
		//insert comment
		$this->home->InsertQuery('comments', $comment);
	
		// load success page
		$path = base_url(); redirect(base_url().'competition/viewresultpage/'.$CompetitionIcode.'/'.$CompetitionCompetitorICode.'/save/');
	}
   
   	// result view page
   	function viewresultpage()
   	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(3);
		$CompetitionCompetitorICode = $this->uri->segment(4);

		$data['CompetitionICode'] = $CompetitionICode;
		$data['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
		
		$data['CompetitorNameList'] = $this->Mcompetition->getCompetitionCompetitor($CompetitionICode); // for left menu
		
		$Fields = "CompetitionName, CreatedBy, IsCompleted, IsStarted";
		$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $WhereFieldValue);
		
		// comeptition details
		$data['TitleDetails'] = $this->Mcompetition->getTitleDetails($CompetitionCompetitorICode);
		
		// competition Name
		$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionName'] = $this->home->getSingleFieldValue('competition_master', 'CompetitionName', $SingleWhere);
		
		// judges details
		$Fields = "FullName, Country";
		$WhereFieldValue = "JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$data['JudgesDetails'] = $this->home->getParticularResultsFromId('judges_master', $Fields, $WhereFieldValue);
		
		$WhereFieldValue="DivisionICode='".$data['TitleDetails']['DivisionICode']."' AND IsDeleted='0' AND CreatedBy='".$data['CompetitionDetails']['CreatedBy']."'";
		$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
		$AllSectionICode = implode(',', $AllSectionICode);
		
		// section details
		$WhereFieldValue = "SectionICode IN (".$AllSectionICode.") AND IsDeleted='0' AND IsActive='0' AND CreatedBy = '".$data['CompetitionDetails']['CreatedBy']."'"; 
		$OrderFiledValue = "SectionName ASC";
		$data['Sectiondetails'] = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
		
		// get championship details
		$WhereFieldValue = "IsActive = '0' AND IsDeleted = '0' ORDER BY OrderKey ASC"; $Fields = "ChampionshipICode, ChampionshipName";
		$data['championshipdetails'] = $this->home->getParticularResults('championship', $Fields, $WhereFieldValue);
		
		if($this->session->userdata('UserType') == 'J')
		{
			if($this->uri->segment(5) == 'save')
			{
				// insert into 'competitor_result' table
				if(count($data['championshipdetails']) > 0)
				{
					foreach($data['championshipdetails'] as $req)
					{
						if($req['ChampionshipName'] == 'Ultimate') // if reult type is 'ULTIMATE'
						{
							$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
							$TotalSecuredPercentage = $this->home->getSumOfParticularFieldFromId('post_result', 'SecuredPoints', $WhereFieldValue);
							
							if(count($TotalSecuredPercentage) > 0)
							{
								$compresult['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
								$compresult['CompetitionICode']  = $CompetitionICode;
								$compresult['ChampionshipICode'] = $req['ChampionshipICode'];
								$compresult['DivisionICode'] 	 = $data['TitleDetails']['DivisionICode'];
								$compresult['SecuredPercentage'] = $TotalSecuredPercentage;
								$compresult['CreatedBy'] 		 = $this->session->userdata('LoginUserICode');
								/*$compresult['CreatedUserType'] 	 = $this->session->userdata('UserType');*/
								$compresult['CreatedDate'] 		 = date('Y-m-d');
								
								$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
								$TCnt = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
							
								if($TCnt == 0)  // insert ultimate result
								{
									$CompetitorResultICode = $this->home->InsertQuery('competitor_result', $compresult);  
									
									$upd['IsResultPosted'] = 1;
									$this->home->UpdateProcess('competition_competitor', $upd, 'CompetitionCompetitorICode', $CompetitionCompetitorICode);
									
									$updz['IsCompleted'] = 0;
									$this->home->UpdateProcess('competition_master', $updz, 'CompetitionICode', $CompetitionICode);
								} 
								
								// update total ultimate score in 'competitor_result_score' table
								$this->updatecompetitorresultscore($CompetitionCompetitorICode, $req['ChampionshipICode'], $data['TitleDetails']['DivisionICode'], $CompetitionICode);
								
				

							}
						}
						else
						{
							//$DivisionICode = $data['competitiondetails']['DivisionICode'];
							$TotalSecuredPercentage = '';
							if(!empty($data['Sectiondetails'])) 
							{
								foreach ($data['Sectiondetails'] as $rez) 
								{
									$SectionICode = $rez['SectionICode'];
									// to find percentage
									$Where = "DivisionICode = '".$data['TitleDetails']['DivisionICode']."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND IsDeleted='0' AND SectionICode = '".$SectionICode."'";
									$TotalPercentage = $this->home->getSingleFieldValue('competitionresult_analysis', 'TotalPercentage', $Where);
									$TotalPercentage = (float)($TotalPercentage);
									
									// to find secured points
									$WhereF = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$SectionICode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
									$SecuredPoints = $this->home->getSingleFieldValue('post_result', 'SecuredPoints', $WhereF);
									$SecuredPoints = (float)($SecuredPoints);
									
									if(!empty($TotalPercentage))
									{
										$Percentage = ($TotalPercentage/100)*$SecuredPoints; // to find percentage
										$Percentage = (float)($Percentage);
										
										if(empty($TotalSecuredPercentage))
										{
											$TotalSecuredPercentage = $Percentage;	
										}
										else
										{
											$TotalSecuredPercentage = $TotalSecuredPercentage + $Percentage;
										}
									}
								}
							}
							//echo $TotalSecuredPercentage."::test";
							// if date exist in post_result table then update in competition_competitor table and competitor_result table
							$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
							$TsCnt = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
							if($TsCnt > 0)
							{
								$compresult['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
								$compresult['CompetitionICode'] = $CompetitionICode;
								$compresult['ChampionshipICode'] = $req['ChampionshipICode'];
								$compresult['DivisionICode'] 	 = $data['TitleDetails']['DivisionICode'];
								$compresult['SecuredPercentage'] = $TotalSecuredPercentage;
								$compresult['CreatedBy'] 		= $this->session->userdata('LoginUserICode');
								$compresult['CreatedDate'] 		= date('Y-m-d');
								
								$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
								$TCnt = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
								
								if($TCnt == 0) // insert other result
								{
									$CompetitorResultICode = $this->home->InsertQuery('competitor_result', $compresult);
									
									$upd['IsResultPosted'] = 1;
									$this->home->UpdateProcess('competition_competitor', $upd, 'CompetitionCompetitorICode', $CompetitionCompetitorICode);
									
									$updz['IsCompleted'] = 0;
									$this->home->UpdateProcess('competition_master', $updz, 'CompetitionICode', $CompetitionICode);
								} 
							}
						
							// update total ultimate score in 'competitor_result_score' table
							$this->updatecompetitorresultscore($CompetitionCompetitorICode, $req['ChampionshipICode'], $data['TitleDetails']['DivisionICode'], $CompetitionICode);
						}
					}
				}
				
				#---- SET RANK FOR COMPETITOR
				$CompetitionChamp = array(1, 2, 3, 4, 5);
				
				#---- UPDATE 'ChampionOn' FIELD IS TO 0
				$DivisionICode = $data['TitleDetails']['DivisionICode'];
				$wherefield = "CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."'";
				$set = "ChampionOn = '0'";
				$this->home->UpdateProcessUsingMultifield('competitor_result_score', $set, $wherefield);
				#---- UPDATE 'ChampionOn' FIELD IS TO 0
				
				foreach($CompetitionChamp as $reqz)
				{
					$ChampionshipICode = $reqz;
					
					if($ChampionshipICode == 4){ $zz = 2;}elseif($ChampionshipICode == 5){ $zz = 3;}else{$zz = $ChampionshipICode;}
					
					#---- GET MAXIMUM SECURED SCORE
					$maxSecuredScore = $this->Mcompetition->getMaximumScoreFromCompetition($CompetitionICode, $DivisionICode, $zz);
					#---- GET MAXIMUM SECURED SCORE
					
					#---- GET MAXIMUM SECURED SCORE COMPETITOR
					if(!empty($maxSecuredScore))
					{
						$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."' AND ChampionshipICode = '".$zz."' AND TotalSecuredScore = '".$maxSecuredScore."'";
						$CompetitionCompetitorICodeMS = $this->home->getAllIdInArrayFormate('competitor_result_score', $WhereFieldValue, 'CompetitionCompetitorICode');
						
						if(!empty($CompetitionCompetitorICodeMS))
						{
							$CompetitionCompetitorICodeMS = implode(',', $CompetitionCompetitorICodeMS);
							
							#---- UPDATE 'ChampionOn' FIELD IN 'competitor_result_score' TABLE
							$wherefield = "CompetitionCompetitorICode IN (".$CompetitionCompetitorICodeMS.") AND CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."'";
							
							$set = "ChampionOn = '".$ChampionshipICode."'";
							$this->home->UpdateProcessUsingMultifield('competitor_result_score', $set, $wherefield);
							#---- UPDATE 'ChampionOn' FIELD IN 'competitor_result_score' TABLE
							
						}
					}
					#---- GET MAXIMUM SECURED SCORE COMPETITOR
				}
				//
				/*if(count($data['championshipdetails']) > 0)
				{
					// change all champion is default 0
					$DivisionICode = $data['TitleDetails']['DivisionICode'];
					$wherefield = "CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."'";
					$set = "ChampionOn = '0'";
					$this->home->UpdateProcessUsingMultifield('competitor_result_score', $set, $wherefield);
					
					foreach($data['championshipdetails'] as $reqz)
					{
						$ChampionshipICode = $reqz['ChampionshipICode'];
						//get max score competitor
						$maxScoreCompetitor = $this->Mcompetition->maxScoreCompetitor($CompetitionICode, $ChampionshipICode, $DivisionICode);
						
						// update 'ChampionOn' field in 'competitor_result_score' table
						$wherefield = "CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."' AND CompetitionCompetitorICode = '".$maxScoreCompetitor."'";
						$set = "ChampionOn = '".$ChampionshipICode."'";
						$this->home->UpdateProcessUsingMultifield('competitor_result_score', $set, $wherefield);
					}
				}*/
				
				$nxt_competitor = $this->getNextCompetitor($CompetitionICode,$this->session->userdata('LoginUserICode'));
		
				$path = base_url(); redirect(base_url().'competition/PostResult/'.$CompetitionICode.'/'.$nxt_competitor);
				
			}
			
			$WhereF = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND CompetitorICode = '".$data['TitleDetails']['CompetitorICode']."'";
			$data['Comment'] = $this->home->getSingleFieldValue('comments', 'Comment_text', $WhereF);
		}
		
		$this->template->write_view('contentpane','viewresultpage',$data,FALSE);
		$this->template->render();
	}
	
	function getNextCompetitor($CompetitionICode,$JudgeICode)
	{
		//core php
		$sql = "SELECT * FROM `competition_competitor` WHERE `CompetitionICode` = '".$CompetitionICode."'";
	
		$query = mysql_query($sql);
		
		$all_competitors = array();
		$all_competitors_query = '';
		
		while ($val = mysql_fetch_array($query)){
		
			$all_competitors[] = $val["CompetitionCompetitorICode"];
			
			$all_competitors_query .= $val["CompetitionCompetitorICode"] . ',';
		
		}
		
		//var_dump($all_competitors);
		
		$all_competitors_query = substr($all_competitors_query, 0, strlen($all_competitors_query) - 1);

		$sql2 = "SELECT * FROM `competitor_result` WHERE `CreatedBy` = '".$JudgeICode."' AND `CompetitionCompetitorICode` IN ( $all_competitors_query ) GROUP BY `CompetitionCompetitorICode`";
		
		$query2 = mysql_query($sql2);

		
		$nr_competitors_results = mysql_num_rows($query2);
		
		if ($nr_competitors_results > 0){

			$all_competitors_results = array();
			
			while ($val2 = mysql_fetch_array($query2)){
			
				$all_competitors_results[] = $val2["CompetitionCompetitorICode"];
			
			}
			
			
			$next_competitors = array_diff($all_competitors, $all_competitors_results);
			
			if (count($next_competitors)> 0 ){
			
						
				$next_competitor = current($next_competitors);
				
			}
			else{
				$next_competitor = current($all_competitors);
				
			}
		}
		else{
			$next_competitor = current($all_competitors);
			
		}
		
		return $next_competitor;
		
		//core php	
	}
	
	// result view page
   	function viewupdateresultpage()
   	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(3);
		$CompetitionCompetitorICode = $this->uri->segment(4);
		
		// comeptition details
		$data['TitleDetails'] = $this->Mcompetition->getTitleDetails($CompetitionCompetitorICode);
		
		$Fields = "CompetitionName, CreatedBy";
		$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $WhereFieldValue);
		
		#---- GET ALL SECTION DETAILS {
		$WhereFieldValue="DivisionICode='".$data['TitleDetails']['DivisionICode']."' AND IsDeleted='0' AND CreatedBy='".$data['CompetitionDetails']['CreatedBy']."'";
		$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
		$AllSectionICode = implode(',', $AllSectionICode);
		
		if(!empty($AllSectionICode))
		{
			$WhereFieldValue = "SectionICode IN (".$AllSectionICode.") AND IsDeleted='0' AND IsActive='0' AND CreatedBy = '".$data['CompetitionDetails']['CreatedBy']."'"; 
			$OrderFiledValue = "SectionName ASC";
			$data['Sectiondetails'] = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
			#---- GET ALL SECTION DETAILS }
		}
			
		// get championship details
		$WhereFieldValue = "IsActive = '0' AND IsDeleted = '0' ORDER BY OrderKey ASC"; $Fields = "ChampionshipICode, ChampionshipName";
		$data['championshipdetails'] = $this->home->getParticularResults('championship', $Fields, $WhereFieldValue);
		
		if($this->session->userdata('UserType') == 'J')
		{
			if($this->uri->segment(5) == 'save')
			{
				// insert into 'competitor_result' table
				if(count($data['championshipdetails']) > 0)
				{
					foreach($data['championshipdetails'] as $req)
					{
						if($req['ChampionshipName'] == 'Ultimate') // if reult type is 'ULTIMATE'
						{
							$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
							$TotalSecuredPercentage = $this->home->getSumOfParticularFieldFromId('post_result', 'SecuredPoints', $WhereFieldValue);
							
							if(count($TotalSecuredPercentage) > 0)
							{
								$compresult['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
								$compresult['CompetitionICode']  = $CompetitionICode;
								$compresult['ChampionshipICode'] = $req['ChampionshipICode'];
								$compresult['DivisionICode'] 	 = $data['TitleDetails']['DivisionICode'];
								$compresult['SecuredPercentage'] = $TotalSecuredPercentage;
								$compresult['CreatedBy'] 		 = $this->session->userdata('LoginUserICode');
								$compresult['CreatedDate'] 		 = date('Y-m-d');
								
								$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
								$TCnt = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
							
								if($TCnt == 0)  // insert ultimate result
								{
									$CompetitorResultICode = $this->home->InsertQuery('competitor_result', $compresult);  
								}
								else #---- ELSE UPDATE TABLE
								{
									$set = "SecuredPercentage = '".$TotalSecuredPercentage."'";
									$this->home->UpdateProcessUsingMultifield('competitor_result', $set, $WhereFieldValue);
								}
								
								#---- FOR UPDATE 'IsResultPosted' FIELD IN 'competition_competitor' TABLE
								$upd['IsResultPosted'] = 1;
								$this->home->UpdateProcess('competition_competitor', $upd, 'CompetitionCompetitorICode', $CompetitionCompetitorICode);
								#---- FOR UPDATE 'IsResultPosted' FIELD IN 'competition_competitor' TABLE
								
								#---- FOR UPDATE 'IsCompleted' FIELD IN 'competition_master' TABLE	
								$updz['IsCompleted'] = 0;
								$this->home->UpdateProcess('competition_master', $updz, 'CompetitionICode', $CompetitionICode);
								#---- FOR UPDATE 'IsCompleted' FIELD IN 'competition_master' TABLE
								
								// update total ultimate score in 'competitor_result_score' table
								$this->updatecompetitorresultscore($CompetitionCompetitorICode, $req['ChampionshipICode'], $data['TitleDetails']['DivisionICode'], $CompetitionICode);
							}
						}
						else
						{
							//$DivisionICode = $data['competitiondetails']['DivisionICode'];
							$TotalSecuredPercentage = '';
							if(!empty($data['Sectiondetails'])) 
							{
								foreach ($data['Sectiondetails'] as $rez) 
								{
									$SectionICode = $rez['SectionICode'];
									// to find percentage
									$Where = "DivisionICode = '".$data['TitleDetails']['DivisionICode']."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND IsDeleted='0' AND SectionICode = '".$SectionICode."'";
									$TotalPercentage = $this->home->getSingleFieldValue('competitionresult_analysis', 'TotalPercentage', $Where);
									$TotalPercentage = (float)($TotalPercentage);
									
									// to find secured points
									$WhereF = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$SectionICode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
									$SecuredPoints = $this->home->getSingleFieldValue('post_result', 'SecuredPoints', $WhereF);
									$SecuredPoints = (float)($SecuredPoints);
									
									if(!empty($TotalPercentage))
									{
										$Percentage = ($TotalPercentage/100)*$SecuredPoints; // to find percentage
										$Percentage = (float)($Percentage);
										
										if(empty($TotalSecuredPercentage))
										{
											$TotalSecuredPercentage = $Percentage;	
										}
										else
										{
											$TotalSecuredPercentage = $TotalSecuredPercentage + $Percentage;
										}
									}
								}
							}
							
							// if date exist in post_result table then update in competition_competitor table and competitor_result table
							$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
							$TsCnt = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
							if($TsCnt > 0)
							{
								$compresult['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
								$compresult['CompetitionICode'] = $CompetitionICode;
								$compresult['ChampionshipICode'] = $req['ChampionshipICode'];
								$compresult['DivisionICode'] 	 = $data['TitleDetails']['DivisionICode'];
								$compresult['SecuredPercentage'] = $TotalSecuredPercentage;
								$compresult['CreatedBy'] 		= $this->session->userdata('LoginUserICode');
								$compresult['CreatedDate'] 		= date('Y-m-d');
								
								$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND IsDeleted='0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
								$TCnt = $this->home->getTotalCountOfRecords('competitor_result', $WhereFieldValue);
								
								if($TCnt == 0) // insert other result
								{
									$CompetitorResultICode = $this->home->InsertQuery('competitor_result', $compresult);
								}
								else
								{
									$set = "SecuredPercentage = '".$TotalSecuredPercentage."'";
									$this->home->UpdateProcessUsingMultifield('competitor_result', $set, $WhereFieldValue);
								}
								
								#---- FOR UPDATE 'IsResultPosted' FIELD IN 'competition_competitor' TABLE
								$upd['IsResultPosted'] = 1;
								$this->home->UpdateProcess('competition_competitor', $upd, 'CompetitionCompetitorICode', $CompetitionCompetitorICode);
								#---- FOR UPDATE 'IsResultPosted' FIELD IN 'competition_competitor' TABLE
								
								#---- FOR UPDATE 'IsCompleted' FIELD IN 'competition_master' TABLE
								$updz['IsCompleted'] = 0;
								$this->home->UpdateProcess('competition_master', $updz, 'CompetitionICode', $CompetitionICode); 
								#---- FOR UPDATE 'IsCompleted' FIELD IN 'competition_master' TABLE
							}
							
							// update total ultimate score in 'competitor_result_score' table
							$this->updatecompetitorresultscore($CompetitionCompetitorICode, $req['ChampionshipICode'], $data['TitleDetails']['DivisionICode'], $CompetitionICode);
						}
					}
				}
				
				#---- SET RANK FOR COMPETITOR
				$CompetitionChamp = array(1, 2, 3, 4, 5);
				
				#---- UPDATE 'ChampionOn' FIELD IS TO 0
				$DivisionICode = $data['TitleDetails']['DivisionICode'];
				$wherefield = "CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."'";
				$set = "ChampionOn = '0'";
				$this->home->UpdateProcessUsingMultifield('competitor_result_score', $set, $wherefield);
				#---- UPDATE 'ChampionOn' FIELD IS TO 0
				
				
				foreach($CompetitionChamp as $reqz)
				{
					$ChampionshipICode = $reqz;
					
					if($ChampionshipICode == 4){ $zz = 2;}elseif($ChampionshipICode == 5){ $zz = 3;}else{$zz = $ChampionshipICode;}
					
					#---- GET MAXIMUM SECURED SCORE
					$maxSecuredScore = $this->Mcompetition->getMaximumScoreFromCompetition($CompetitionICode, $DivisionICode, $zz);
					#---- GET MAXIMUM SECURED SCORE
					
					#---- GET MAXIMUM SECURED SCORE COMPETITOR
					if(!empty($maxSecuredScore))
					{
						$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."' AND ChampionshipICode = '".$zz."' AND TotalSecuredScore = '".$maxSecuredScore."'";
						$CompetitionCompetitorICodeMS = $this->home->getAllIdInArrayFormate('competitor_result_score', $WhereFieldValue, 'CompetitionCompetitorICode');
						
						if(!empty($CompetitionCompetitorICodeMS))
						{
							$CompetitionCompetitorICodeMS = implode(',', $CompetitionCompetitorICodeMS);
							
							#---- UPDATE 'ChampionOn' FIELD IN 'competitor_result_score' TABLE
							$wherefield = "CompetitionCompetitorICode IN (".$CompetitionCompetitorICodeMS.") AND CompetitionICode = '".$CompetitionICode."' AND DivisionICode = '".$DivisionICode."'";
							
							$set = "ChampionOn = '".$ChampionshipICode."'";
							$this->home->UpdateProcessUsingMultifield('competitor_result_score', $set, $wherefield);
							#---- UPDATE 'ChampionOn' FIELD IN 'competitor_result_score' TABLE
							
						}
					}
					#---- GET MAXIMUM SECURED SCORE COMPETITOR
				}
				#---- SET RANK FOR COMPETITOR
			}
		}
		
		$path = base_url().'competition/viewresultpage/'.$CompetitionICode.'/'.$CompetitionCompetitorICode.'/';
		redirect($path); 
	}
	
	// result view page
   	function judgeresult()
   	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$CompetitionICode = $this->uri->segment(3);
		$JudgesICode = $this->uri->segment(4);
		$data['JId'] = $JudgesICode;
		$data['IsJudgeHead'] = $this->session->userdata('IsJudgeHead');
		
		$data['CompetitorNameList'] = $this->Mcompetition->getCompetitionCompetitor($CompetitionICode); // for left menu

		if(!empty($data['CompetitorNameList']))
		{
			if($this->uri->segment(5) !='' )
			{
				$CompetitionCompetitorICode = $this->uri->segment(5);
			}
			else
			{
				$CompetitionCompetitorICode = $data['CompetitorNameList'][0]['CompetitionCompetitorICode'];
			}
			
			$data['CompetitionICode'] = $CompetitionICode;
			$data['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
			
			//judeges of this competition
			$alljudgesID = $this->home->GetAllData('competition_judges', 'CompetitionICode='.$CompetitionICode );
		
			foreach( $alljudgesID as $onejudgeID ):
				$onejudgeid = $onejudgeID['JudgesICode'];
				$onejudgeinfo = $this->home->GetInfoByID( $onejudgeid,'judges_master','JudgesICode' );
				$data['AllJudges'][] = $onejudgeinfo;	
			endforeach;
			
			//get division of this competition
			$sql = 'SELECT distinct(DivisionICode) from competition_competitor where CompetitionICode='.$CompetitionICode;
			$query = $this->db->query($sql);
			$data['alldivisionid'] = $query->result_array();
			//get division name , and division competitor, and divison score
			foreach( $data['alldivisionid']  as $onedivisionid ):
				$onedivisionid = $onedivisionid['DivisionICode'];
				$onedivisioninfo = $this->home->GetInfoByID( $onedivisionid,'division_master','DivisionICode' );
				$data['alldivisionname'][] = $onedivisioninfo['DivisionName'];
				
				$sql = 'SELECT CompetitionCompetitorICode ,CompetitorICode  from competition_competitor where CompetitionICode='.$CompetitionICode.' and DivisionICode='.$onedivisionid;
				$query = $this->db->query($sql);
				$allcomepetor_onedivision = $query->result_array();
				foreach( $allcomepetor_onedivision as $one_comepetor_onedivision ):
					$one_comepetor_onedivision_id = $one_comepetor_onedivision['CompetitorICode'];
					$one_comepetor_onedivision_info = $this->home->GetInfoByID( $one_comepetor_onedivision_id,'competitor_master','CompetitorICode' );
					$data['alldivisoncompetitor'][$onedivisioninfo['DivisionName']][] = $one_comepetor_onedivision_info['FullName'];
					
					$one_competitioncompetitor_onedivision_id = $one_comepetor_onedivision['CompetitionCompetitorICode'];
					
					//echo "hi";
				endforeach;
			endforeach;
			//echo var_dump($data['alldivisionname']);
		
			$Fields = "CompetitionName, CreatedBy , IsCompleted, IsStarted";
			$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
			$data['CompetitionDetails'] = $this->home->getParticularResultsFromId('competition_master', $Fields, $WhereFieldValue);
			
			//$Fields = "*";
			//$one = 1;
			$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND IsResultPosted = '1'";
			//$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."' and IsResultPosted='".$one."'";
			$data['CompetitionResultPostDetails'] = $this->home->isResultPosted('competition_competitor', $WhereFieldValue);
			
			// comeptition details
			$data['TitleDetails'] = $this->Mcompetition->getTitleDetails($CompetitionCompetitorICode);
			
			// competition Name
			$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
			$data['CompetitionName'] = $this->home->getSingleFieldValue('competition_master', 'CompetitionName', $SingleWhere);
			
			// judges details
			$Fields = "FullName, Country";
			$WhereFieldValue = "JudgesICode = '".$JudgesICode."'";
			$data['JudgesDetails'] = $this->home->getParticularResultsFromId('judges_master', $Fields, $WhereFieldValue);
			
			$WhereFieldValue="DivisionICode='".$data['TitleDetails']['DivisionICode']."' AND IsDeleted='0' AND CreatedBy='".$data['CompetitionDetails']['CreatedBy']."'";
			$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
			$AllSectionICode = implode(',', $AllSectionICode);
			
			// section details
			$WhereFieldValue = "SectionICode IN (".$AllSectionICode.") AND IsDeleted='0' AND IsActive='0' AND CreatedBy = '".$data['CompetitionDetails']['CreatedBy']."'"; 
			$OrderFiledValue = "SectionName ASC";
			$data['Sectiondetails'] = $this->home->getAllDetails('section_master', $WhereFieldValue, $OrderFiledValue);
			
			// get championship details
			$WhereFieldValue = "IsActive = '0' AND IsDeleted = '0' ORDER BY OrderKey ASC"; $Fields = "ChampionshipICode, ChampionshipName";
			$data['championshipdetails'] = $this->home->getParticularResults('championship', $Fields, $WhereFieldValue);
			
			$WhereF = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CompetitionICode = '".$CompetitionICode."' AND CompetitorICode = '".$data['TitleDetails']['CompetitorICode']."'";
			$data['Comment'] = $this->home->getSingleFieldValue('comments', 'Comment_text', $WhereF);
			
			$this->template->write_view('contentpane','judgeresult',$data,FALSE);
			$this->template->render();
		}
	}
	
	function updatecompetitorresultscore($CompetitionCompetitorICode, $ChampionshipICode, $DivisionICode, $CompetitionICode)
	{
		$WhereFieldValue = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND ChampionshipICode = '".$ChampionshipICode."'";
		$ResCnt = $this->home->getTotalCountOfRecords('competitor_result_score', $WhereFieldValue);
		$ChampionTotalScore = $this->home->getSumOfParticularFieldFromId('competitor_result', 'SecuredPercentage', $WhereFieldValue);
		if($ResCnt == 0)
		{
			$postsubresultz['CompetitionCompetitorICode'] = $CompetitionCompetitorICode;
			$postsubresultz['CompetitionICode'] = $CompetitionICode;
			$postsubresultz['ChampionshipICode'] = $ChampionshipICode;
			$postsubresultz['DivisionICode'] = $DivisionICode;
			$postsubresultz['TotalSecuredScore'] = $ChampionTotalScore;  
			$CompetitorResultScoreICode = $this->home->InsertQuery('competitor_result_score', $postsubresultz);		
		}
		else
		{
			$CRSICode = $this->home->getSingleFieldValue('competitor_result_score', 'CompetitorResultScoreICode', $WhereFieldValue);
			
			$updatez['TotalSecuredScore'] = $ChampionTotalScore;
			$this->home->UpdateProcess('competitor_result_score', $updatez, 'CompetitorResultScoreICode', $CRSICode);
		}
	}
	
	// result view page from home page
   	function viewresultrank()
   	{
		$CompetitionICode = $this->uri->segment(3);
		$data['CompetitionICode'] = $CompetitionICode;
		$data['Divisions'] = $this->Mcompetition->competitionDivisions($CompetitionICode);
		
		// to find Competition name
		$Where = "CompetitionICode = '".$CompetitionICode."'";
		$data['CompetitionName'] = $this->home->getSingleFieldValue('competition_master', 'CompetitionName', $Where);
		
		// champioship details
		/*$WhereFieldValue = "IsDeleted = '0'"; $OrderFiledValue = "OrderKey ASC";
		$data['Championshipdetails'] = $this->home->getAllDetails('championship', $WhereFieldValue, $OrderFiledValue);*/
		
		$data['Championshipdetails'] = array(1, 2, 3, 4, 5);
		
		$this->template->write_view('contentpane','viewresultrank',$data, FALSE);
		$this->template->render();	
	}
	
	// view competion details page   
   	function viewcompetitiondetails()
   	{
		$CompetitionICode = $this->uri->segment(3);
		$WhereFieldValue = "CompetitionICode = '".$CompetitionICode."'";
		$data['commpdetails'] =$this->home->getAllDetailsFromId('competition_master', $WhereFieldValue);
		
	   	$this->template->write_view('contentpane','viewcompetitiondetails',$data,FALSE);
		$this->template->render();
	}
	
	function checkCompetitionStatus()
	{
		$CompetitionICode = $_POST['CompetitionICode'];
		
		$SingleWhere = "CompetitionICode = '".$CompetitionICode."'";
		$Status = $this->home->getSingleFieldValue('competition_master', 'IsStarted', $SingleWhere);
		if($Status == 2){ echo 'Closed'; exit; } else { echo 'Available'; exit; } 
	}
	
	//list all judges
	function alljudges()
	{
		if(!($this->session->userdata('UserType') == 'J')){ $path = base_url().'home/logout/'; redirect($path); exit; }
		
		$SingleWhere = "JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$HeadJudgeCreaterICode = $this->home->getSingleFieldValue('judges_master', 'CreatedBy', $SingleWhere);
		
		$WhereFieldValue = "CreatedBy = '".$HeadJudgeCreaterICode."' AND IsActive = '0' AND IsDeleted = '0' ORDER BY FullName ASC";
		$Fields = "JudgesICode, FullName";			
		$data['JudgesDetails'] = $this->home->getParticularResults('judges_master', $Fields, $WhereFieldValue);
		
		// get first judge icode
		$JudICode = $this->uri->segment(3);
		if(!empty($JudICode)){
			$JudgesICode = $JudICode;
		}
		else
		{
			$JudgesICode = $data['JudgesDetails'][0]['JudgesICode'];
		}
		
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
		
		$this->template->write_view('contentpane','alljudges',$data,FALSE);
		$this->template->render();
	}
	
	// get judge competitions
	function judgecompetition()
	{
		$JudgesICode = $this->uri->segment(3);
		$SingleWhere = "JudgesICode = '".$this->session->userdata('LoginUserICode')."'";
		$HeadJudgeCreaterICode = $this->home->getSingleFieldValue('judges_master', 'CreatedBy', $SingleWhere);
		
		$WhereFieldValue = "CreatedBy = '".$HeadJudgeCreaterICode."' AND IsActive = '0' AND IsDeleted = '0'"; $Fields = "JudgesICode, FullName";			
		$data['JudgesDetails'] = $this->home->getParticularResults('judges_master', $Fields, $WhereFieldValue);
		
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
		
		$this->template->write_view('contentpane','alljudges',$data,FALSE);
		$this->template->render();
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
			//echo '<img src= "'.base_url().'images/close.png" border="0" width="24" height="24" style="cursor:pointer;" title="Competition Closed"/>';
			echo 'success';
			exit;
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
	
	function UpdateCompetitionStatus()
	{
		$status = $_POST['status'];
		$CompetitionICode = $_POST['CompetitionICode'];
		
		$competition['IsPublic'] = $status;

		$this->home->UpdateProcess('competition_master', $competition, 'CompetitionICode', $CompetitionICode);
			
		echo 'success';
		exit;
	}
   
}
