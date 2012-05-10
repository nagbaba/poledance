<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<script>
//add new sub section validate
function addSubsectionValidate()
{
	//alert('sd');
	var SubsectionName = $('#SubsectionName').val();
	var EditId = $('#EditId').val();
	var processAction = $('#processAction').val();
	var SubsectionDescription = $('#SubsectionDescription').val();
	if(EditId != '')
	{
		var checkSectionNameExist = base_url+'admin/user/editsubsection/';
		var EditUID = EditId;
	}
	else
	{
		var checkSectionNameExist = base_url+'admin/user/insertsubsection/';
		var EditUID = '';
	}
	if($('#SubsectionName').val()==""){
   		jAlert('Please select sub section name.', 'Pole Dance', 'SubsectionName');
		return false;
    }
	else{
		if(checkSpecialChar('SubsectionName', 2) == false){
			jAlert('Please enter valid sub section name.', 'Pole Dance', 'SubsectionName');
			return false;
		}		
	}
	
	$.ajax({  
			type: "POST",
			url: checkSectionNameExist,  
			data: {"SubsectionName": SubsectionName, "SubsectionDescription": SubsectionDescription, "EditId": EditUID, "processAction": processAction },  
			success: function(msg)
			{  
				if(msg == "Exist")
				{
					jAlert('This sub section name is already exist.', 'Yombook', 'SubsectionName');
					return false;		
				}
				else
				{
					$('#subSectionTable').html(msg);
					$('#SubsectionName').val('');
					$('#SubsectionDescription').val('');
					$('#EditId').val('');
					$('#AddLabel').html('Add Sub Section');
					$('#AddButton').attr('title', 'Add Sub Section');
				}
			 }
		});
}

//delete sub section 
function deleteSubSection(TempSubsectionICode)
{
	jConfirm('Do you want to delete this sub section?', 'Pole Dance', function(r) {
	if(r == true)
	{
		var checkSectionNameExist = base_url+'admin/user/deleteSubSection/'+TempSubsectionICode+'/';
		$.ajax({  
			type: "POST",
			url: checkSectionNameExist,  
			data: {"TempSubsectionICode": TempSubsectionICode},  
			success: function(msg)
			{  
				//alert(msg); return false;
				$('#subSectionTable').html(msg);
				$('#SubsectionName').val('');
				$('#SubsectionDescription').val('');
				$('#EditId').val('');
				$('#AddLabel').html('Add Sub Section');
				$('#AddButton').attr('title', 'Add Sub Section');
			 }
		});
	}
	});	
}

//Edit sub section data
function editsubsectiondata(SubsectionName, EditId)
{
	var getSubsectionDescription = base_url+'admin/user/getSubsectionDescription/'+EditId+'/';
	var processAction = 'Add';
	$.ajax({  
			type: "POST",
			url: getSubsectionDescription,  
			data: {"EditId": EditId, "processAction": processAction},  
			success: function(msg)
			{
				//alert(msg); return false;
				$('#SubsectionName').val(SubsectionName);
				$('#SubsectionDescription').val(msg);
				$('#EditId').val(EditId);
				$('#AddLabel').html('Edit Sub Section');
				$('#AddButton').attr('title', 'Edit Sub Section');
			  }
	});
}

// add new section validate
function addSectionValidate(SectionICode)
{
	/*if($('#DivisionICode').val()==""){
   		jAlert('Please select division name.', 'Pole Dance', 'DivisionICode');
		return false;
    }*/
	if($('#SectionName').val()==""){
   		jAlert('Please enter section name.', 'Pole Dance', 'SectionName');
		return false;
    }
	else{
		if(checkSpecialChar('SectionName', 1) == false){
			jAlert('Please enter valid section name.', 'Pole Dance', 'SectionName');
			return false;
		}		
	}
	if($('#MinPoint').val()==""){
   		jAlert('Please enter minimum point.', 'Pole Dance', 'MinPoint');
		return false;
    }
	else{
		if(checkSpecialChar('MinPoint', 6) == false){
			jAlert('Please enter a valid number.', 'Pole Dance', 'MinPoint');
			return false;
		}		
	}
	if($('#MaxPoint').val()==""){
   		jAlert('Please enter maximum point.', 'Pole Dance', 'MaxPoint');
		return false;
    }else{
		if(checkSpecialChar('MaxPoint', 6) == false){
			jAlert('Please enter a valid number.', 'Pole Dance', 'MaxPoint');
			return false;
		}		
	}
	if($('#MinPoint').val() > 0 && $('#MaxPoint').val() > 0)
	{
		if(parseInt($('#MinPoint').val()) > parseInt($('#MaxPoint').val()))
		{
			jAlert('Max point value should be greater than min point value.', 'Pole Dance', 'MaxPoint');
			return false;
		}
	}
	else
	{
		if(parseInt($('#MinPoint').val()) < parseInt($('#MaxPoint').val()))
		{
			jAlert('Max point value should be less than min point value.', 'Pole Dance', 'MaxPoint');
			return false;
		}	
	}
	
	//var DivisionICode = $('#DivisionICode').val();
	var SectionName = $('#SectionName').val();
	
	if(SectionICode != ''){ var checkSectionNameExist = base_url+'admin/user/checkSectionNameExist/'+SectionICode+'/';}
		else{ var checkSectionNameExist = base_url+'admin/user/checkSectionNameExist/';}
	
	$.ajax({  
			type: "POST",
			url: checkSectionNameExist,  
			data: {"SectionName": SectionName },  
			success: function(msg)
			{  
				//alert(msg); return false;
				if(msg == 'Exist')
				{
					jAlert('This Section Name is already exist.', 'Pole Dance', 'SectionName');
					return false;
				}
				else if(msg == 'subsectionempty')
				{
					jAlert('Please add subsection.', 'Pole Dance', 'SubsectionName');
					return false;
				}
				else
				{
					//window.location.href = base_url+'admin/user/sectionmanagement/';
					$("#addsectionform").submit();
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
    <h1 style="color:#AD2E76;">Add New Section </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="addsectionform" id="addsectionform" method="post" action="<?php echo base_url();?>admin/user/addsection/insert/">
	<table width="90%" border="0" cellpadding="0" cellspacing="2" align="center">
<tr>
    <td width="16%" align="right">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
</tr>
<!--<tr>
  <td height="50" align="left"><span class="box_title">Division Name <span class="asterick">*</span></span></td>
  <td align="left">:</td>
  <td colspan="2" align="left">
  		<select name="DivisionICode" id="DivisionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px;" tabindex="1" >
			<option value="" class="box_drop">Select Division Name</option>
			<?php if(count($DivisionDetails) > 0 ){foreach($DivisionDetails as $row){?>
			<option class="box_drop" value="<?php echo $row['DivisionICode'];?>"><?php echo $row['DivisionName'];?></option>
			<?php } } else{ ?>
			<option class="box_drop" value="">No Records Available</option>
			<?php } ?>
	  	</select></td>
  <td align="left">&nbsp;</td>
</tr>-->
<tr>
    <td height="50" align="left"><span class="box_title">Section Name <span class="asterick">*</span></span></td>
    <td align="left">:</td>
    <td width="80%" align="left"><input name="SectionName" id="SectionName" value="" type="text" style="width:355px; margin-top:8px;" maxlength="50" onkeyup="trimFirstSpace('SectionName');"  tabindex="1" class="tb1" onkeypress="enterPage('addsectionbutton', event);" /></td>
    <td width="2%" align="left">&nbsp;</td>
</tr>
<tr>
  <td height="50" align="left"><span class="box_title">Section Description</span></td>
  <td align="left">:</td>
  <td align="left"><textarea name="SectionDescription" id="SectionDescription" class="tb3" cols="40" rows="5" style="resize:none; width:350px; height:100px;" tabindex="2"></textarea></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="50" align="left"><span class="box_title">Section Point <span class="asterick">*</span></span></td>
  <td align="left">:</td>
  <td align="left"><span class="box_title">Min : </span>
    <input name="MinPoint" id="MinPoint" value="1" type="text" style="width:89px; margin-top:8px;" maxlength="3" onkeyup="trimFirstSpace('MinPoint');"  tabindex="3" class="tb1" onkeypress="enterPage('addsectionbutton', event);" />
    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<span class="box_title">Max :</span>
    <input name="MaxPoint" id="MaxPoint" value="" type="text" style="width:89px; margin-top:8px;" maxlength="3" onkeyup="trimFirstSpace('MaxPoint');"  tabindex="4" class="tb1" onkeypress="enterPage('addsectionbutton', event);"  /></td>
  <td align="left">&nbsp;</td>
</tr>


<tr>
  <td height="19" align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="42" align="left"><span class="box_title">Sub Section Name <span class="asterick">*</span></span></td>
  <td align="left">:</td>
  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="37"><input name="SubsectionName" id="SubsectionName" value="" type="text" style="width:355px; margin-top:8px;" maxlength="40" onkeyup="trimFirstSpace('SubsectionName');"  tabindex="5" class="tb1" onkeypress="enterPage('addsectionbutton', event);" /></td>
      </tr>
  </table></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="42" align="left"><span class="box_title">Subsection Description</span></td>
  <td align="left">:</td>
  <td align="left"><table width="100%" height="32" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50%" valign="bottom"><textarea name="SubsectionDescription" id="SubsectionDescription" class="tb3" cols="40" rows="5" style="resize:none; width:350px; height:100px;" tabindex="6"></textarea></td>
      <td width="50%" valign="bottom" style="padding-bottom:8px;"><button type="button" onclick="return addSubsectionValidate('<?php echo $this->uri->segment(5);?>');" title="Add Sub Section" id="AddButton"><img src="<?php echo base_url();?>images/addmore.png" border="0" width="23" height="23" tabindex="7" /></button><a href="#" onclick="return addSubsectionValidate('<?php echo $this->uri->segment(5);?>');" style="color:black; font-weight:bold; text-decoration: none; padding-left: 4px;" id="AddLabel">Add Sub Section</a>
	  
	  <input type="hidden" value="" class="input-text-box" name="EditId" id="EditId"/>	
	  <input type="hidden" value="insertsubsection" class="input-text-box" name="processAction" id="processAction"/>		</td>
    </tr>
  </table></td>
  <td align="left">&nbsp;</td>
</tr>

<tr>
  <td height="19" align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="42" align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left"><table width="85%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="subSectionTable"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="71%" height="32" align="left">Sub Section Name </th>
			<td width="14%" align="center" class="th_css">Status</th>
			<td width="15%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(count($SubsectionDetails) > 0 ){
			foreach($SubsectionDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['SubsectionName']), 40);//echo substr(ucwords($DivisionName), 0, 25);?></td>
              <td class="center" id="status<?php echo $row['TempSubsectionICode'];?>"><?php echo getUserStatus($row['IsActive'], 'temp_subsection', $row['TempSubsectionICode'], 'sub-section', 'TempSubsectionICode'); ?></td>
			  
              <td class="center"><img src="<?php echo base_url();?>images/edit.png" border="0" width="16" height="16" alt="Edit Sub Section" title="Edit Sub Section" style="cursor:pointer;" onclick="editsubsectiondata('<?php echo $row['SubsectionName']; ?>', '<?php echo $row['TempSubsectionICode'];?>');"/>
			  <img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete Sub Section" title="Delete Sub Section" style="cursor:pointer; padding-left:25px;" onclick="deleteSubSection('<?php echo $row['TempSubsectionICode'];?>');"/>			  </td>
		</tr>
		<?php }}?>
	</tbody>
</table></td>
  </tr>
</table></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="19" align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="42" align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left"><table width="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="8%"><span class="btn_bx">
      <input type="button" name="addsectionbutton" id="addsectionbutton" tabindex="8" value="Save" class="text_box" onClick="return addSectionValidate('<?php echo $this->uri->segment(5);?>');"/></span></td>
      <td width="92%"><span class="btn_bx">
              <input type="button" name="clear" id="clear" value="Cancel" tabindex="9" onclick="location.href='<?php echo base_url();?>admin/user/sectionmanagement/'"/></span></td>
    </tr>
  </table></td>
  <td align="left">&nbsp;</td>
</tr>

  
  <tr>
    <td colspan="4">&nbsp;</td>
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
			"aoColumns": [ null ]
	});
});
</script>