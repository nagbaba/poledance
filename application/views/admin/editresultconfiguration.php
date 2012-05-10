<script type="text/javascript">
    // sub section validate
    function addSubsectionValidate()
    {
        var insertsubsectionresulrt = base_url+'admin/result/insertsectionpercentage/';
	
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
		
	
        var DivisionICode = $('#DivisionICode').val();
		var ChampionshipICode = $('#ChampionshipICode').val();
		var PercentageValue =$('#PercentageValue').val();
		var SectionICode = $('#SectionICode').val();
		var processAction = $('#processAction').val();

		$.ajax({  
            type: "POST",
            url: insertsubsectionresulrt,
            data: {"DivisionICode": DivisionICode, "ChampionshipIcode": ChampionshipICode, "PercentageValue": PercentageValue, "SectionICode": SectionICode,"processAction": processAction},  
            success: function(msg)
            { 
                if(msg == 'Exist')
				{
					jAlert('This section is already exist.', 'Pole Dance', 'SectionICode');
					return false;
				}
               	else
				{
					$('#ResultConfigTableId').html(msg);
					$('#PercentageValue').val('');
					$('#SectionICode').val('');
                }
            }
        });
    }

    //delete result config
    function deleteResultConfig(CompetitonResultAnalysisICode, ChampionshipICode, DivisionICode)
    {
     
       jConfirm('Do you want to delete this section?', 'Pole Dance', function(r) {
            if(r == true)
            {
                var deleteresultconfig = base_url+'admin/result/deleteresultconfig/foredit/';
                $.ajax({  
                    type: "POST",
                    url: deleteresultconfig,  
                    data: {"CompetitonResultAnalysisICode": CompetitonResultAnalysisICode,"ChampionshipICode": ChampionshipICode,"DivisionICode": DivisionICode},  
                    success: function(msg)
                    {  
                        $('#ResultConfigTableId').html(msg);
                    }
                });
            }
        });	
    }

    // validate new result config
    function validateEditResultConfig(ChampionshipICode, DivisionICode)
    {
		$.ajax({  
		type: "POST",
		url: base_url+'admin/result/getTotalTempTableCount/',  
		data: {"processAction": $('#processAction').val(), "ChampionshipICode":ChampionshipICode, "DivisionICode":DivisionICode},  
		success: function(msg)
		{
			if(msg == 'validateFields')
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
					data: {"processAction": $('#processAction').val(), "SectionICode": $('#SectionICode').val(), "ChampionshipICode":ChampionshipICode, "DivisionICode":DivisionICode},  
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
							$("#editresultconfigform").submit();
						}
					 }
				});
			}
			else
			{
				//alert('success');
				$("#editresultconfigform").submit();	
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
                    <h1 style="color:#AD2E76;">Edit Competition Result Analysis </h1>
                </div>
                <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
                <div class="content">
                    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
                         clear: both;"></div>
                    <div>
                        <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
                             252); border: 1px solid  #E8E8E8; padding: 10px;">
                            <form name="editresultconfigform" id="editresultconfigform" method="post" action="<?php echo base_url(); ?>admin/result/editresultconfiguration/update/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/">
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
        <td height="45" colspan="2" align="left" class="table_result"><?php echo $DivisionName; ?>
        <input type="hidden" value="<?php echo $this->uri->segment(5);?>" name="DivisionICode" id="DivisionICode"/></td>
      </tr>
      <tr>
        <td width="5%" height="45">&nbsp;</td>
        <td width="17%" align="left"><span class="box_title">Championship On <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td height="45" colspan="2" align="left" class="table_result"><?php echo $ChampionshipName; ?>
        <input type="hidden" value="<?php echo $this->uri->segment(4);?>" name="ChampionshipICode" id="ChampionshipICode"/>
        </td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Section Involved  <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td width="27%" height="45" align="left">
        <select name="SectionICode" id="SectionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="4">
        <option value="" class="box_drop">Select Section Name</option>
        <?php if(!empty($SectionDetails) > 0 ){foreach($SectionDetails as $row){?>
        <option class="box_drop" value="<?php echo $row['SectionICode']; ?>"><?php echo $row['SectionName']; ?></option>
        <?php } } else { ?>
        <option value="" class="box_drop">No Records Available.</option>
        <?php } ?>
        </select>
        </td>
        <td height="45" align="left">&nbsp;</td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Performance Percentage <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="3" name="PercentageValue" id="PercentageValue" maxlength="2" onKeyUp="trimFirstSpace('PercentageValue');"/></td>
        <td width="48%" height="45" align="left" id="sectiondropdown"><button type="button" id="addbutton" onClick="return addSubsectionValidate();" title="Save"><img src="<?php echo base_url(); ?>images/addmore.png" border="0" width="23" height="23" tabindex="5" /></button>
              <a href="" id="savetype" onClick="return addSubsectionValidate();" style="color:black; font-weight:bold; text-decoration: none; padding-left: 8px;">Add </a></td>
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
                <?php if (!empty($ResAnalysisDetails)) {
				        foreach ($ResAnalysisDetails as $row) {
                        $SectionICode = $row['SectionICode'];
              			$SingleWhere = "SectionICode = '".$row['SectionICode']."'";
		     			$SectionName  = $this->home->getSingleFieldValue('section_master', 'SectionName', $SingleWhere); 
		  		?>
                <tr class="gradeC">
                  <td class="left"><?php echo getMaxFieldLength(ucwords($SectionName), 22);?></td>
                  <td class="left"><?php echo $row['TotalPercentage'];?></td>
				  <!--td class="center" id="status<?php echo $row['CompetitonResultAnalysisICode'];?>"><?php echo getUserStatus($row['IsActive'], 'competitionresult_analysis', $row['CompetitonResultAnalysisICode'], 'section', 'CompetitonResultAnalysisICode'); ?></td-->
                  <td class="center"><img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete" title="Delete" style="cursor:pointer;" onclick="deleteResultConfig('<?php echo $row['CompetitonResultAnalysisICode'];?>','<?php echo $row['ChampionshipICode'];?>','<?php echo $row['DivisionICode'];?>');"/> </td>
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
            <td width="7%" align="left"><!--<span class="btn_bx">
              <input type="button" name="addnewresultconfigbutton" id="addnewresultconfigbutton" value="Submit" onClick="return validateEditResultConfig('<?php echo $this->uri->segment(4);?>', '<?php echo $this->uri->segment(5);?>');" tabindex="6"></span>-->
              <span class="btn_bx">
              <input type="button" name="clear" id="clear" value="Close" tabindex="7" onclick="location.href='<?php echo base_url();?>admin/result/managecompetitionresult/'"/>
              </span>
              <input type="hidden" value="editsubsectionresconfig" class="input-text-box" name="processAction" id="processAction"/></td>
            <td width="64%" align="left">&nbsp;</td>
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