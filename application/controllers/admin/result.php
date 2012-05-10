<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result extends CI_Controller {

    function Result() {
        parent::__construct();
        $this->load->model('admin/homemodel', 'home', TRUE);

        $this->load->helper(array('form', 'url'));
        $this->load->helper('userfunctions');

        $this->load->library('template');
        $this->template->set_template('admin');

        $this->load->library('session');
    }

    // load manage result configuration
    function managecompetitionresult() {
		
        if (!($this->session->userdata('UserType') == 'E')) { $path = base_url() . 'admin/home/evenadminlogout/'; redirect($path); exit; }

        // set temp session value
        $this->session->set_userdata('SessionValueForResConfig', uniqid());

        $Fields = "CompetitonResultAnalysisICode, DivisionICode, ChampionshipICode, CreatedDate";
		$WhereFieldValue = "IsDeleted='0' AND CreatedBy='".$this->session->userdata('LoginUserICode')."' GROUP BY ChampionshipICode, DivisionICode";
		$data['CompetitionDetails'] = $this->home->getParticularResults('competitionresult_analysis', $Fields, $WhereFieldValue);
	
		$this->template->write_view('contentpane', 'admin/managecompetitionresult', $data, FALSE);
        $this->template->render();
    }

    // add new result configuration
    function addresultconfiguration() {
        if (!($this->session->userdata('UserType') == 'E')) { $path = base_url() . 'admin/home/evenadminlogout/'; redirect($path); exit;}

        if ($this->uri->segment(4) == 'insert') 
		{
		    //insert data into competitionresult_analysis master table
            $WhereFieldValue = "SessionValueForResConfig = '" . $this->session->userdata('SessionValueForResConfig') . "' AND CreatedBy='" . $this->session->userdata('LoginUserICode') . "'";
            $OrderFiledValue = "TempResultConfigICode ASC";
            $temp_resultconfig = $this->home->getAllDetails('temp_resultconfig', $WhereFieldValue, $OrderFiledValue);

            if (!empty($temp_resultconfig)) 
			{
                foreach ($temp_resultconfig as $tep) 
				{
                    // insert records in to competitionresult_analysis table
					$resultanalysis['ChampionshipICode'] = $tep['ChampionshipICode'];
                    $resultanalysis['DivisionICode'] = $tep['DivisionICode'];
                    $resultanalysis['SectionICode'] = $tep['SectionICode'];
                    $resultanalysis['TotalPercentage'] = $tep['PercentageValue'];
                    $resultanalysis['IsActive'] = $tep['IsActive'];
                    $resultanalysis['CreatedBy'] = $this->session->userdata('LoginUserICode');
                    $resultanalysis['CreatedUserType'] = $this->session->userdata('UserType');
                    $resultanalysis['CreatedDate'] = date('Y-m-d H:i:s');

                    $CompetitonResultAnalysisICode = $this->home->InsertQuery('competitionresult_analysis', $resultanalysis);

                    // delete form temp_resultconfig table
                    $wherefield = "TempResultConfigICode = '" . $tep['TempResultConfigICode'] . "'";
                    $this->home->permamnantDelete('temp_resultconfig', $wherefield);
                }
            }
            $path = base_url();
            redirect(base_url() . 'admin/result/managecompetitionresult/');
        } else 
		{
          	// check temp session value 
         	if ($this->session->userdata('SessionValueForResConfig') == '') { $path = base_url().'admin/result/managecompetitionresult/'; redirect($path);
                exit;}

            // load all divisions
            $WhereFieldValue = "IsDeleted ='0' AND IsActive='0' AND CreatedBy = '" . $this->session->userdata('LoginUserICode') . "'";
            $OrderFiledValue = "DivisionName ASC";
            $data['DivisionDetails'] = $this->home->getAllDetails('division_master', $WhereFieldValue, $OrderFiledValue);

			 // load all chanpions type
			$WhereFieldValue = "IsDeleted ='0' AND IsActive = '0' AND IsOnlyForResult = '0'";
            $OrderFiledValue = "ChampionshipName ASC";
            $data['championshipDetails'] = $this->home->getAllDetails('championship', $WhereFieldValue, $OrderFiledValue);
			
			$data['SectionnDetails'] = '';
			
            // load temp table data
            $WhereFieldValue = "SessionValueForResConfig = '" . $this->session->userdata('SessionValueForResConfig') . "' AND CreatedBy ='" . $this->session->userdata('LoginUserICode') . "' GROUP BY SectionICode";
            $OrderFiledValue = "TempResultConfigICode ASC";
            $data['ResultconfigDetails'] = $this->home->getAllDetails('temp_resultconfig', $WhereFieldValue, $OrderFiledValue);

            $this->template->write_view('contentpane', 'admin/addresultconfiguration', $data, TRUE);
            $this->template->render();
        }
    }

	// delete old records in temp table
	function deleteoldrecords()
	{
		$SessionValueForResConfig = $_POST['SessionValueForResConfig'];
		$wherefield = "SessionValueForResConfig = '".$SessionValueForResConfig."'";
		
		$cnt = $this->home->getTotalCountOfRecords('temp_resultconfig', $wherefield );
		if($cnt > 0)
		{
			$this->home->permamnantDelete('temp_resultconfig', $wherefield );
			echo $this->tempresultconfigtable(); exit;			
		}
		else
		{
			echo 'NoRecords'; 	 exit;		
		}
	}
	
    // edit result configuration
    function editresultconfiguration() 
	{
       	if(!($this->session->userdata('UserType') == 'E')) { $path = base_url() . 'admin/home/evenadminlogout/';  redirect($path); exit; }

      	if ($this->uri->segment(4) == 'update') 
	   	{
            $ChampionshipICode = $this->uri->segment(5);
			$DivisionICode = $this->uri->segment(6);

            //insert data into competitionresult_analysis master table
            $wherefield = "ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."'";
            $set = "ModifiedBy = '".$this->session->userdata('LoginUserICode')."', ModifiedUserType = '".$this->session->userdata('UserType')."', ModifiedDate = '".date('Y-m-d H:i:s')."'";
			$this->home->UpdateProcessUsingMultifield('competitionresult_analysis', $set, $wherefield);
			
            $path = base_url();
            redirect(base_url() . 'admin/result/managecompetitionresult/');
        }
		else 
		{
			// check temp session value 
          	if ($this->session->userdata('SessionValueForResConfig') == '') { $path = base_url().'admin/result/managecompetitionresult/'; redirect($path);
                exit;}
				
			$ChampionshipICode = $this->uri->segment(4);
			$DivisionICode = $this->uri->segment(5);
			$WhereFieldValue = "ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$Fields = "CompetitonResultAnalysisICode, ChampionshipICode, DivisionICode, SectionICode, TotalPercentage, IsActive";
			$data['ResAnalysisDetails'] = $this->home->getParticularResults('competitionresult_analysis', $Fields, $WhereFieldValue);
			
			$SingleWhere = "ChampionshipICode = '".$ChampionshipICode."'";
			$data['ChampionshipName'] = $this->home->getSingleFieldValue('championship', 'ChampionshipName', $SingleWhere);
			
			$SingleWhere = "DivisionICode = '".$DivisionICode."'";
			$data['DivisionName'] = $this->home->getSingleFieldValue('division_master', 'DivisionName', $SingleWhere);
			
			$WhereFieldValue = "DivisionICode= '".$DivisionICode."' AND IsDeleted = '0' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
			$AllSectionICode = $this->home->getAllIdInArrayFormate('division_section_master', $WhereFieldValue, 'SectionICode');
			
			if($AllSectionICode)
			{
				$AllSectionICode = implode(',', $AllSectionICode);
				$Fields = "SectionICode, SectionName";
				$WhereFieldValue = "SectionICode IN (".$AllSectionICode.") AND IsActive = '0' AND IsDeleted = '0'";
				$data['SectionDetails'] = $this->home->getParticularResults('section_master', $Fields, $WhereFieldValue);
			}
			else
			{
				$data['SectionDetails'] ='';
			}
				
			$this->template->write_view('contentpane', 'admin/editresultconfiguration', $data, TRUE);
			$this->template->render();
	    }
    }
	
	//getTotalTempTableCount
	function getTotalTempTableCount()
	{
		$processAction = $_POST['processAction'];
		if($processAction == 'insertsubsectionresconfig')
		{
			$SessionValueForResConfig = $this->session->userdata('SessionValueForResConfig');
			$wherefield = "SessionValueForResConfig = '".$SessionValueForResConfig."'";
			$cnt = $this->home->getTotalCountOfRecords('temp_resultconfig', $wherefield );	
			if($cnt > 0)
			{
				echo 'NoNeed';
			}
			else
			{
				echo 'validateFields';
			}
		}
		else
		{
			$ChampionshipICode = $_POST['ChampionshipICode'];
			$DivisionICode = $_POST['DivisionICode'];
			
			$wherefield = "ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' AND IsDeleted = '0'";
			$cnt = $this->home->getTotalCountOfRecords('competitionresult_analysis', $wherefield );	
			if($cnt > 0)
			{
				echo 'NoNeed';
			}
			else
			{
				echo 'validateFields';
			}
		}
	}

    //check result config details exist in table
    function checkresultconfigdetailsexist() 
	{
		$processAction = $_POST['processAction'];
		$SectionICode  = $_POST['SectionICode'];
        if ($processAction == 'insertsubsectionresconfig') 
		{
			if(!empty($SectionICode))
			{
				echo 'clickaddbutton';
			}
			else
			{
				$SessionValueForResConfig = $this->session->userdata('SessionValueForResConfig');
				$wherefield = "SessionValueForResConfig = '".$SessionValueForResConfig."'";
				$cnt = $this->home->getTotalCountOfRecords('temp_resultconfig', $wherefield );
			
				if($cnt > 0){ echo 'insert'; exit;}
					else{ echo 'clickaddbutton'; }	
			}
        }
		else
		{
			if(!empty($SectionICode))
			{
				echo 'clickaddbutton';
			}
			else
			{
				$ChampionshipICode = $_POST['ChampionshipICode'];
				$DivisionICode = $_POST['DivisionICode'];
			
				$wherefield = "ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' AND IsDeleted = '0'";
				$cnt = $this->home->getTotalCountOfRecords('competitionresult_analysis', $wherefield );
			
				if($cnt > 0){ echo 'insert'; exit;}
					else{ echo 'clickaddbutton'; }	
			}	
		}
    }
	
	// chek this championship exist in competitionresult_analysis table
	function checkChampionExist()
	{
		$DivisionICode 		= $_POST['DivisionICode'];
		$ChampionshipIcode 	= $_POST['ChampionshipIcode'];
		$processAction 		= $_POST['processAction'];
		
		$WhereFieldValue = "DivisionICode = '" . $DivisionICode . "' AND ChampionshipICode = '" . $ChampionshipIcode . "' AND IsDeleted ='0'";
		$checkChampionshipon = $this->home->checkThisFieldValueInTable('competitionresult_analysis', $WhereFieldValue);
   
		if($checkChampionshipon == 1)
		{
		  	echo 'ChampionshipdataExist';  exit;
		}
		else
		{
			echo 'insert'; exit;
		}
	}

    // insert into temp table
    function insertsectionpercentage()
	{
	   $DivisionICode 		= $_POST['DivisionICode'];
	   $SectionICode 		= $_POST['SectionICode'];
	   $ChampionshipIcode 	= $_POST['ChampionshipIcode'];
	   $processAction 		= $_POST['processAction'];
	   $PercentageValue  	= $_POST['PercentageValue'];
  		
		// insert process
        if ($processAction == 'insertsubsectionresconfig') 
		{
			$tempsection['SessionValueForResConfig'] = $this->session->userdata('SessionValueForResConfig');
			$tempsection['DivisionICode'] = $DivisionICode;
			$tempsection['SectionICode'] = $SectionICode;
			$tempsection['ChampionshipICode'] = $ChampionshipIcode;
			$tempsection['PercentageValue'] =  $PercentageValue ;
			$tempsection['CreatedBy'] = $this->session->userdata('LoginUserICode');
			$tempsection['CreatedUserType'] = $this->session->userdata('UserType');
			$tempsection['CreatedDate'] = date('Y-m-d H:i:s');

			$WhereFieldValue = "DivisionICode = '" . $DivisionICode . "' AND SectionICode = '" . $SectionICode . "' AND ChampionshipICode = '" . $ChampionshipIcode . "' AND SessionValueForResConfig = '" . $this->session->userdata('SessionValueForResConfig') . "' AND CreatedBy = '" . $this->session->userdata('LoginUserICode') . "'";
		    $checkSectionName = $this->home->checkThisFieldValueInTable('temp_resultconfig', $WhereFieldValue);
			 
			if ($checkSectionName == 0) 
			{
				$lastInsertId = $this->home->InsertQuery('temp_resultconfig', $tempsection);
				echo $this->tempresultconfigtable(); exit;
			} 
			else 
			{
				echo 'Exist';
			}
        }
		else
		{
           // $resanaly['SessionValueForResConfig'] = $this->session->userdata('SessionValueForResConfig');
            $resanaly['DivisionICode'] = $DivisionICode;
            $resanaly['SectionICode'] = $SectionICode;
		    $resanaly['ChampionshipICode'] = $ChampionshipIcode;
            $resanaly['TotalPercentage'] =  $PercentageValue ;
            $resanaly['CreatedBy'] = $this->session->userdata('LoginUserICode');
            $resanaly['CreatedUserType'] = $this->session->userdata('UserType');
            $resanaly['CreatedDate'] = date('Y-m-d H:i:s');

			$WhereFieldValue = "DivisionICode = '" . $DivisionICode . "' AND SectionICode = '" . $SectionICode . "' AND ChampionshipICode = '" . $ChampionshipIcode . "' AND CreatedBy = '" . $this->session->userdata('LoginUserICode') . "' AND IsDeleted = '0'";
           $checkSectionName = $this->home->checkThisFieldValueInTable('competitionresult_analysis', $WhereFieldValue);
             
            if ($checkSectionName == 0) 
			{
                $lastInsertId = $this->home->InsertQuery('competitionresult_analysis', $resanaly);
				echo $this->competitionresult_analysistable($ChampionshipIcode, $DivisionICode); exit;
			} 
			else 
			{
                echo 'Exist';
            }
        }
    }

    // delete result config
    function deleteresultconfig() {
        if ($this->uri->segment(4) == 'foredit') 
		{
            $CompetitonResultAnalysisICode = $_POST['CompetitonResultAnalysisICode'];
			$ChampionshipICode = $_POST['ChampionshipICode'];
			$DivisionICode = $_POST['DivisionICode'];
            $wherefield = "CompetitonResultAnalysisICode = '" . $CompetitonResultAnalysisICode . "'";
            $this->home->permamnantDelete('competitionresult_analysis', $wherefield);
            echo $this->competitionresult_analysistable($ChampionshipICode, $DivisionICode);
            exit;
        } 
		else 
		{
            $DeleteId = $_POST['TempResultConfigICode'];
            $wherefield = "TempResultConfigICode = '" . $DeleteId . "'";
            $this->home->permamnantDelete('temp_resultconfig', $wherefield);
            echo $this->tempresultconfigtable();
            exit;
        }
    }

    // load result config table
    function tempresultconfigtable() {
        // load temp table data
        $WhereFieldValue = "SessionValueForResConfig = '" . $this->session->userdata('SessionValueForResConfig') . "' AND CreatedBy ='" . $this->session->userdata('LoginUserICode') . "'";
        $OrderFiledValue = "TempResultConfigICode ASC";
       	$ResultconfigDetails = $this->home->getAllDetails('temp_resultconfig', $WhereFieldValue, $OrderFiledValue);

    	$table =  '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
              <thead>
                <tr>
                  <th width="34%" height="32" align="left"> Section Name </th>
                  <th width="38%" align="left" >Percentage</th>
				   <!--td width="15%" align="center" class="th_css">Status</td-->
                  <td width="13%" align="center" class="th_css">Delete</td>
                </tr>
              </thead>
              <tbody>';
                if (!empty($ResultconfigDetails)) {
					foreach ($ResultconfigDetails as $row) {
                    $SectionICode = $row['SectionICode'];
              		$SingleWhere = "SectionICode = '".$row['SectionICode']."'";
		     		$SectionName  = $this->home->getSingleFieldValue('section_master', 'SectionName', $SingleWhere); 
		  
			  		$table .=  '<tr class="gradeC">
                  	<td class="left">'.getMaxFieldLength(ucwords($SectionName), 22).'</td>
                  	<td class="left">'.$row['PercentageValue'].'</td>
				  	<!--td class="center" id="status'.$row['TempResultConfigICode'].'">'.getUserStatus($row['IsActive'], 'temp_resultconfig', $row['TempResultConfigICode'], 'section', 'TempResultConfigICode').'</td-->
                  	<td class="center"><img src="'.base_url().'images/delete.png" border="0" width="16" height="16" alt="Delete" title="Delete" style="cursor:pointer;" onclick="deleteResultConfig(\''.$row['TempResultConfigICode'].'\');"/></td>
                	</tr>';
				 	}
				}
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
			"aoColumns": [ null, null ]
		});
		});
		</script>
        <?php
    }

    // load form original table 'competitionresult_section' for edit
    function competitionresult_analysistable($ChampionshipICode, $DivisionICode)
	{
       	$Fields = "CompetitonResultAnalysisICode, ChampionshipICode, DivisionICode, SectionICode, TotalPercentage, IsActive";
	   	$WhereFieldValue = "ChampionshipICode = '".$ChampionshipICode."' AND DivisionICode = '".$DivisionICode."' AND CreatedBy = '".$this->session->userdata('LoginUserICode')."'";
	   	$ResultconfigDetails = $this->home->getParticularResults('competitionresult_analysis', $Fields, $WhereFieldValue);

    	$table =  '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
              <thead>
                <tr>
                  <th width="34%" height="32" align="left"> Section Name </th>
                  <th width="38%" align="left" >Percentage</th>
				   <!--td width="15%" align="center" class="th_css">Status</td-->
                  <td width="13%" align="center" class="th_css">Delete</td>
                </tr>
              </thead>
              <tbody>';
                if (!empty($ResultconfigDetails)) {
					foreach ($ResultconfigDetails as $row) {
                    $SectionICode = $row['SectionICode'];
              		$SingleWhere = "SectionICode = '".$row['SectionICode']."'";
		     		$SectionName  = $this->home->getSingleFieldValue('section_master', 'SectionName', $SingleWhere); 
		  
			  		$table .=  '<tr class="gradeC">
                  	<td class="left">'.getMaxFieldLength(ucwords($SectionName), 22).'</td>
                  	<td class="left">'.$row['TotalPercentage'].'</td>
				  	<!--td class="center" id="status'.$row['CompetitonResultAnalysisICode'].'">'.getUserStatus($row['IsActive'], 'competitionresult_analysis', $row['CompetitonResultAnalysisICode'], 'section', 'CompetitonResultAnalysisICode').'</td-->
                 	<td class="center"><img src="'.base_url().'images/delete.png" border="0" width="16" height="16" alt="Delete" title="Delete" style="cursor:pointer;" onclick="deleteResultConfig(\''.$row['CompetitonResultAnalysisICode'].'\', \''.$row['ChampionshipICode'].'\', \''.$row['DivisionICode'].'\');"/></td>
               		</tr>';
				 	}
				}
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
			"aoColumns": [ null, null ]
		});
		});
		</script>
        <?php 
    }

}
