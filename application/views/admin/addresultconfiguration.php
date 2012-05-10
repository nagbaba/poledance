<script type="text/javascript">
function loadsectiondropdown(DivisionICode)
{
	var sectiondw = base_url+'admin/home/loadsectiondropdownforresultconfiguration/';
	$.ajax({  
			type: "POST",
			url: sectiondw,  
			data: {"DivisionICode": DivisionICode },  
			success: function(msg)
			{ 
				//alert(msg); return false;
                 $('#sectiondropdown').html(msg); 
			}
		});
}

//load subsection dropdown
/*function loadsubsectiondropdown(SectionICode)
{
	var sectiondw = base_url+'admin/home/loadsubsectiondropdownforresultconfiguration/';
	$.ajax({  
			type: "POST",
			url: sectiondw,  
			data: {"SectionICode": SectionICode },  
			success: function(msg)
			{  
				$('#subsectiondropdown').html(msg); 
			}
		});
}*/
function deletedata(DivisionICode)
{
   var sectiondw = base_url+'admin/home/deleteresultconfigurationdata/';
	$.ajax({  
			type: "POST",
			url: sectiondw,  
			data: {"DivisionICode": DivisionICode },  
			success: function(msg)
			{  
				if(msg == 'Exist')
					 {
					  window.location.href = base_url+'admin/result/addresultconfiguration/'
					 }
				}
		});
    
}

function resettemptable(SessionValueForResConfig)
{
	 var deleteoldrecords = base_url+'admin/result/deleteoldrecords/';
	$.ajax({  
			type: "POST",
			url: deleteoldrecords,  
			data: {"SessionValueForResConfig": SessionValueForResConfig },  
			success: function(msg)
			{  
				if(msg != 'NoRecords')
				{
					$('#ResultConfigTableId').html(msg);
				}
			}
		});
}
// sub section validate
function addSubsectionValidate()
{
	var insertsectionpercentage = base_url+'admin/result/insertsectionpercentage/';
	var checkChampionExist = base_url+'admin/result/checkChampionExist/';
	
	if($('#DivisionICode').val()==""){
		jAlert('Please select division name.', 'Pole Dance', 'DivisionICode');
		return false;
	}
	if($('#ChampionshipIcode').val()==""){
		jAlert('Please select championship name.', 'Pole Dance', 'ChampionshipIcode');
		return false;
	}
	
	var DivisionICode = $('#DivisionICode').val();
	var ChampionshipIcode = $('#ChampionshipIcode').val();
	var processAction = $('#processAction').val();
	
	$.ajax({  
		type: "POST",
		url: checkChampionExist,  
		data: {"DivisionICode": DivisionICode, "ChampionshipIcode":ChampionshipIcode, "processAction": processAction},  
		success: function(msg)
		{  
			if(msg == 'ChampionshipdataExist')
			{
				jAlert('This Championship is already exist.', 'Pole Dance', 'ChampionshipIcode');
				return false;	
			}
			else
			{
				if($('#SectionICode').val()==""){
					jAlert('Please select section name.', 'Pole Dance', 'SectionICode');
					return false;
				}
				if($('#PercentageValue').val()==""){
					jAlert('Please enter percentage value.', 'Pole Dance', 'PercentageValue');
					return false;
				}
				else{
					if(checkSpecialChar('PercentageValue', 5) == false){
						jAlert('Please enter a valid value. Ex : 40', 'Pole Dance', 'PercentageValue');
						return false;
					}		
				}
				
				var SectionICode = $('#SectionICode').val();
				var PercentageValue =$('#PercentageValue').val();
				
				 $.ajax({  
					type: "POST",
					url: insertsectionpercentage,
					data: {"DivisionICode": DivisionICode, "SectionICode": SectionICode,"processAction": processAction, "PercentageValue": PercentageValue, "ChampionshipIcode":ChampionshipIcode},  
					success: function(msg)
						{ 
							//alert(msg);   return false;
							if(msg == 'Exist')
							{
								jAlert('This section is already exist.', 'Pole Dance', 'SectionICode');
								return false;
							}
							else if(msg == 'ChampionshipdataExist')
							{
								jAlert('This Championship is already exist.', 'Pole Dance', 'ChampionshipIcode');
								return false;
							}
							else
							{
								$('#ResultConfigTableId').html(msg);
								$('#PercentageValue').val('');
								$('#SectionICode').val('');
								//$('#SubsectionICode').val('');
							}
						}
					});
			}
		}
	});
}

//delete result config
function deleteResultConfig(TempResultConfigICode)
{
	jConfirm('Do you want to delete this section?', 'Pole Dance', function(r) {
	if(r == true)
	{
		var deleteresultconfig = base_url+'admin/result/deleteresultconfig/';
		$.ajax({  
			type: "POST",
			url: deleteresultconfig,  
			data: {"TempResultConfigICode": TempResultConfigICode},  
			success: function(msg)
			{  
				$('#ResultConfigTableId').html(msg);
			 }
		});
	}
	});	
}

// validate new result config
function validateAddResultConfig()
{
	$.ajax({  
		type: "POST",
		url: base_url+'admin/result/getTotalTempTableCount/',  
		data: {"processAction": $('#processAction').val(), "SectionICode": $('#SectionICode').val()},  
		success: function(msg)
		{
			if(msg == 'validateFields')
			{
				if($('#DivisionICode').val()==""){
					jAlert('Please select division name.', 'Pole Dance', 'DivisionICode');
					return false;
				}
				if($('#ChampionshipIcode').val()==""){
					jAlert('Please select championship name.', 'Pole Dance', 'ChampionshipIcode');
					return false;
				}
				var checkChampionExist = base_url+'admin/result/checkChampionExist/';
				var DivisionICode = $('#DivisionICode').val();
				var ChampionshipIcode = $('#ChampionshipIcode').val();
				var processAction = $('#processAction').val();
				
				$.ajax({  
					type: "POST",
					url: checkChampionExist,  
					data: {"DivisionICode": DivisionICode, "ChampionshipIcode":ChampionshipIcode, "processAction": processAction},  
					success: function(msg)
					{  
						if(msg == 'ChampionshipdataExist')
						{
							jAlert('This Championship is already exist.', 'Pole Dance', 'ChampionshipIcode');
							return false;	
						}
						else
						{
							if($('#SectionICode').val()==""){
								jAlert('Please select section name.', 'Pole Dance', 'SectionICode');
								return false;
							}
							if($('#PercentageValue').val()==""){
								jAlert('Please enter percentage value.', 'Pole Dance', 'PercentageValue');
								return false;
							}
							else{
								if(checkSpecialChar('PercentageValue', 5) == false){
									jAlert('Please enter a valid value. Ex : 40', 'Pole Dance', 'PercentageValue');
									return false;
								}		
							}
							
							$.ajax({  
								type: "POST",
								url: base_url+'admin/result/checkresultconfigdetailsexist/',  
								data: {"processAction": $('#processAction').val(), "SectionICode": $('#SectionICode').val()},  
								success: function(msg)
								{  
									if(msg == 'clickaddbutton')
									{
										jAlert('Please add section details.', 'Pole Dance', 'addbutton');
										return false;
									}
									else
									{
										//alert('success');
										$("#addresultconfigform").submit();
									}
								 }
							});		
						}
					}
				});
				
				
			}
			else
			{
				//alert('success');
				$("#addresultconfigform").submit();	
			}
		}
	});
		

}
</script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">New Competition Result Analysis </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="addresultconfigform" id="addresultconfigform" method="post" action="<?php echo base_url();?>admin/result/addresultconfiguration/insert/">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="19">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19" colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Division Name <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" colspan="2" align="left">
        <select name="DivisionICode" id="DivisionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="1" onchange="loadsectiondropdown(this.value); resettemptable('<?php echo $this->session->userdata('SessionValueForResConfig'); ?>'); ">
            <option value="" class="box_drop">Select Division Name</option>
            <?php if(count($DivisionDetails) > 0 ){foreach($DivisionDetails as $div){?>
            <option class="box_drop" value="<?php echo $div['DivisionICode']; ?>"><?php echo $div['DivisionName']; ?></option>
            <?php } } else{ ?>
            <option class="box_drop" value="">No Records Available</option>
            <?php } ?>
        </select></td>
      </tr>
      <tr>
        <td width="5%" height="45">&nbsp;</td>
        <td width="17%" align="left"><span class="box_title">Championship On <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td height="45" colspan="2" align="left">
		<select name="ChampionshipIcode" id="ChampionshipIcode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="2" onchange="resettemptable('<?php echo $this->session->userdata('SessionValueForResConfig'); ?>');" >
          <option value="" class="box_drop">Select Championship Name</option>
		  <?php if(count($championshipDetails) > 0 ){foreach($championshipDetails as $dat){?>
            <option class="box_drop" value="<?php echo $dat['ChampionshipICode']; ?>"><?php echo $dat['ChampionshipName']; ?></option>
            <?php } } else{ ?>
            <option class="box_drop" value="">No Records Available</option>
            <?php } ?>
        </select></td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Section Involved  <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td width="27%" height="45" align="left" id="sectiondropdown">
		<select name="SectionICode" id="SectionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="3">
            <option value="" class="box_drop">Select Section Name</option>
            <?php if(!empty($SectionnDetails)){foreach($SectionnDetails as $sec){?>
            <option class="box_drop" value="<?php echo $sec['SectionICode']; ?>"><?php echo $sec['SectionName']; ?></option>
            <?php } } else{ ?>
            <option class="box_drop" value="">No Records Available</option>
            <?php } ?>
        </select>		</td>
       	<td height="45" align="left">&nbsp;</td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
         <td height="45" align="left"><span class="box_title">Performance Percentage <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="4" name="PercentageValue" id="PercentageValue" maxlength="2" onKeyUp="trimFirstSpace('PercentageValue');"/></td>
        <td width="48%" height="45" align="left" id="sectiondropdown"><button type="button" id="addbutton" onClick="return addSubsectionValidate();" title="Save"><img src="<?php echo base_url(); ?>images/addmore.png" border="0" width="23" height="23" tabindex="5" /></button>
              <a href="" onClick="return addSubsectionValidate();" style="color:black; font-weight:bold; text-decoration: none; padding-left: 8px;">Add</a></td>
      </tr>
      <tr>
        <td height="19">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
        <td height="19" align="center">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td height="19">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
        <td height="19" align="center">&nbsp;</td>
        <td height="19" colspan="2" align="left" ><table width="80%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="ResultConfigTableId"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
              <thead>
                <tr>
                  <th width="34%" height="32" align="left"> Section Name </th>
                  <th width="38%" align="left" >Percentage</th>
				   <!--td width="15%" align="center" class="th_css">Status</td-->
                  <td width="13%" align="center" class="th_css">Delete</td>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($ResultconfigDetails)) {
				        foreach ($ResultconfigDetails as $row) {
                        $SectionICode = $row['SectionICode'];
              			$SingleWhere = "SectionICode = '".$row['SectionICode']."'";
		     			$SectionName  = $this->home->getSingleFieldValue('section_master', 'SectionName', $SingleWhere); 
		  		?>
                <tr class="gradeC">
                  <td class="left"><?php echo getMaxFieldLength(ucwords($SectionName), 22);?></td>
                  <td class="left"><?php echo $row['PercentageValue'];?></td>
				  <!--td class="center" id="status<?php echo $row['TempResultConfigICode'];?>"><?php echo getUserStatus($row['IsActive'], 'temp_resultconfig', $row['TempResultConfigICode'], 'section', 'TempResultConfigICode'); ?></td-->
                  <td class="center"><img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete" title="Delete" style="cursor:pointer;" onclick="deleteResultConfig('<?php echo $row['TempResultConfigICode'];?>');"/> </td>
                </tr>
                <?php }}?>
              </tbody>
            </table></td>
            </tr>
        </table></td>
        </tr>
      
      <tr>
        <td height="19">&nbsp;</td>
        <td height="19" colspan="4" align="left" valign="top">
          <table width="68%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td ></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="45" colspan="5"><table width="100%" height="42" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="25%" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
            <td width="7%" align="left"><span class="btn_bx">
              <input type="button" name="addnewresultconfigbutton" id="addnewresultconfigbutton" value="Submit" onClick="return validateAddResultConfig();" tabindex="6"></span><input type="hidden" value="insertsubsectionresconfig" class="input-text-box" name="processAction" id="processAction"/></td>
            <td width="64%" align="left"><span class="btn_bx">
              <input type="button" name="clear" id="clear" value="Cancel" tabindex="7" onclick="location.href='<?php echo base_url();?>admin/result/managecompetitionresult/'"/></span></td>
            <td width="4%" align="left">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
    </table>
	</form>
</div>
    </div>
  </div>
</div></td>
      </tr>
    </table>
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