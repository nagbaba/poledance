<!-- MULTI SELECT IN DROPDOWN BOX -->
<script src="<?php echo base_url();?>js/multiSelect_dropdown.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>css/multiSelect_dropdown.css" rel="stylesheet" type="text/css" />

<!-- date picker css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker_style.css">
<link href="<?php echo base_url(); ?>css/themes/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>

<script type="text/javascript">
$(document).ready( function() {
	$("#JudgesICode").multiSelect({ selectAllText: 'Select All' });
	$("#CompetitorICode").multiSelect({ selectAllText: 'Select All' });
	loadcompetitor();
	editchanges();
	$('#IsPublic').change(function() {
 	 	
		var status = $('#IsPublic').val();
		var CompetitionICode = $('#CompetitionICode').val();
		var updateStatusUrl = base_url+'competition/UpdateCompetitionStatus';
	
		$.ajax({  
				type: "POST",
				url: updateStatusUrl,  
				data: {"status": status,"CompetitionICode": CompetitionICode},  
				success: function(msg)
				{  
					//alert(msg); return false;
					if(msg == 'success')
					{
						jAlert('The status of this competition is changed.', 'Pole Dance', 'IsPublic');
						location.reload();
						
					}
					else
					{
						jAlert('The status of this competition is not changed.', 'Pole Dance', 'IsPublic');
					}
				 }
			});
			
		});
});
</script>

<script type="text/javascript">
// load division dropdown
/*function loadsectiondropdown(DivisionICode)
{
	$('#CompetitorName').val('N');
	
	var sectiondw = base_url+'admin/home/loadsectiondropdown/';
	$.ajax({  
			type: "POST",
			url: sectiondw,  
			data: {"DivisionICode": DivisionICode },  
			success: function(msg)
			{  
				$('#sectiondropdown').html(msg); 
			}
		});
	
	var competitordw = base_url+'admin/home/loadcompetitordropdown/';	
		$.ajax({  
			type: "POST",
			url: competitordw,  
			data: {"DivisionICode": DivisionICode },  
			success: function(msg)
			{  
				$('#particularCompetitor').html(msg); 
			}
		});
		
	
}*/
function editchanges(){  // edited by bernazzyk to have the look of edit, through this function the change will be shown - edit date: 28-04-12
	var CcompetitorArray  = <?php echo json_encode($CcompetitorArrayTest);?>;
	//alert_r(CcompetitorArray);
	for(i in CcompetitorArray){
		$(".competitor").each(function(){
			if($(this).attr("id").substring(10) == CcompetitorArray[i].CompetitorICode){
				$(this).find("input").each(function(){
					var name = $(this).attr("name");
					name = name.split("[");
					if(CcompetitorArray[i].DivisionICode == name[1].substring(0,name[1].length-1)){
						$(this).attr("checked","checked");
					}					
				});
				$(this).find("select").each(function(){
					var name = $(this).attr("name");
					name = name.split("[");
					if(CcompetitorArray[i].DivisionICode == name[1].substring(0,name[1].length-1)){
						$(this).find("option").each(function(){
							var selectname = $(this).attr("value");
							if(CcompetitorArray[i].CompetitorOrder == selectname){
								$(this).attr("selected","selected");
							}	
						});
					}										
				});
			}
		});
	}
}


function loadcompetitor()
{
	//edited by bernazzyk to load the competitor in different style as per the recent requirement - edit date: 28-04-12

	var DivisionICode = '';
	var select = "";
	$("input[name='DivisionICode[]']").each(function() {
		if ($(this).attr('checked')) { 
			if(DivisionICode == '')	{ 
				DivisionICode = $(this).val(); 
			} else	{ 
				DivisionICode = DivisionICode+','+$(this).val(); 
			} 
		}
	});
	if(DivisionICode!=""){
		//$(".competitor").html("");
		DivisionICode = DivisionICode.split(",");
		var competitorCount = <?php echo count($CompetitorDetails);?>;
		var str = "";
		
		for(i in DivisionICode){
			var competitordw = base_url+'admin/user/getDivisionName/';	
			$.ajax({  
			type: "POST",
			async: false,
			url: competitordw,  
			data: {"DivisionICode": DivisionICode[i] },  
			success: function(msg)
			{  

				str = str + "<div><div style='float:left; width:200px;'><input type='checkbox'/><span class='division_code'>"+msg+"</span></div>";
				str = str + "<div style='float:left; margin-left:10px; width:75px;'><select class='simpledrop'><option value=''>Order</option>";
				for (j = 1; j<=competitorCount; j++){
					str = str + '<option value="'+j+'">'+j+'</option>';
				}
				str = str + '</select></div><div class="clear"></div></div>';

				
			}
			});
			
		
		}
		$(".competitor").html(str);
		for(i in DivisionICode){
			$(".competitor").each(function(){
				var competitorID = $(this).attr("id").substring(10);
				$(this).children("div").eq(i).find("input").attr("name","division_code["+DivisionICode[i]+"]["+competitorID+"]");
				$(this).children("div").eq(i).find("select").attr("name","competitor["+DivisionICode[i]+"]["+competitorID+"]");				
			});
		}
		
		
	}
	
	//edited by bernazzyk




	
//	var DivisionICode = '';
//	$("input[name='DivisionICode[]']").each(function() {
//		if ($(this).attr('checked')) { if(DivisionICode == '')	{ DivisionICode = $(this).val(); } else	{ DivisionICode = DivisionICode+','+$(this).val(); } }
//	});
//	
//	var competitordw = base_url+'admin/home/loadcompetitordropdown/';	
//	$.ajax({  
//		type: "POST",
//		url: competitordw,  
//		data: {"DivisionICode": DivisionICode },  
//		success: function(msg)
//		{  
//			$('#particularCompetitor').html(msg); 
//			$('#chckHead').attr("checked",'checked');
//			$("input[name='CompetitorICode[]']").attr("checked",'checked');
//		}
//	});
}

function loadcompetitoredit(val)
{
	//edited by bernazzyk
	var DivisionICode = '';
	var select = "";
	if ($(val).attr('checked')) { 
		DivisionICode = $(val).val(); 	
	}
	else{
		unselect = $(val).val();
		$(".competitor").each(function(){
			$(this).find("input").each(function(){
				var name = $(this).attr("name");
				name = name.split("[");
				if(unselect == name[1].substring(0,name[1].length-1)){
					$(this).parent("div").parent("div").remove();
				}	
			});
		});
	}
	if(DivisionICode!=""){
		//$(".competitor").html("");
		//	DivisionICode = DivisionICode.split(",");
		var competitorCount = <?php echo count($CompetitorDetails);?>;
		var str = "";
		
			var competitordw = base_url+'admin/user/getDivisionName/';	
			$.ajax({  
			type: "POST",
			async: false,
			url: competitordw,  
			data: {"DivisionICode": DivisionICode },  
			success: function(msg)
			{  

				str = str + "<div id='"+DivisionICode+"'><div style='float:left; width:200px;'><input type='checkbox'/><span class='division_code'>"+msg+"</span></div>";
				str = str + "<div style='float:left; margin-left:10px; width:75px;'><select class='simpledrop'><option value=''>Order</option>";
				for (j = 1; j<=competitorCount; j++){
					str = str + '<option value="'+j+'">'+j+'</option>';
				}
				str = str + '</select></div><div class="clear"></div></div>';
				
				
			}
			});
			
		$(".competitor").append(str);

			$(".competitor").each(function(){
				var competitorID = $(this).attr("id").substring(10);
				$(this).children("div#"+DivisionICode).find("input").attr("name","division_code["+DivisionICode+"]["+competitorID+"]");
				$(this).children("div#"+DivisionICode).find("select").attr("name","competitor["+DivisionICode+"]["+competitorID+"]");				
			});
		
		
	}
	
	
//	if(DivisionICode!=""){
//		var competitordw = base_url+'admin/home/load_competitor_dropdown/';	
//		$.ajax({  
//			type: "POST",
//			url: competitordw,  
//			data: {"DivisionICode": DivisionICode },  
//			success: function(msg)
//			{  
//				$('#particularCompetitor').html(msg); 
//				$('#chckHead').attr("checked",'checked');
//				$("input[name='CompetitorICode[]']").attr("checked",'checked');
//			}
//		});
//	}

	//edited by bernazzyk
}

$(document).ready(function() {
  	var TotalChkBox = $("input[name='CompetitorICode[]']").size();
  	var TotalSelectedBox = $("input[name='CompetitorICode[]']").filter(":checked").size();
	if(TotalChkBox == TotalSelectedBox){ $('#chckHead').attr("checked",'checked'); } else { $('#chckHead').attr("checked",''); }
});

// Add New competition Validation
function validateAddNewcompetitor()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	var phoneNumberPattern = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;  // US Phone Number Validation
	if($('#CompetitionName').val()==""){
   		jAlert('Please enter competition name.', 'Pole Dance', 'CompetitionName');
		return false;
    }
	else{
		if(checkSpecialChar('CompetitionName', 1) == false){
			jAlert('Please enter valid competition name.', 'Pole Dance', 'CompetitionName');
			return false;
		}		
	}
	if($('#CompetitionDate').val()==""){
   		jAlert('Please select competition date.', 'Pole Dance', 'CompetitionDate');
		return false;
    }
	
	var currentdate =  new Date();
	var currentdate =  currentdate.getTime();
	
	var CompetitionDate = $('#CompetitionDate').val();
	var CompetitionDate1 = CompetitionDate.split("-");
	var CompetitionDate2 = new Date(CompetitionDate1[2]+'/'+CompetitionDate1[1]+'/'+CompetitionDate1[0]);
	var ToDateValue = CompetitionDate2.getTime();
	
	if(currentdate > ToDateValue)
	{
		jAlert('Competition date should be greater than current date.', 'Pole Dance', 'CompetitionDate');
		return false;
	}
	if($('#CompetitionHour').val()==""){
   		jAlert('Please select competition time.', 'Pole Dance', 'CompetitionHour');
		return false;
    }
	if($('#CompetitionMiniute').val()==""){
   		jAlert('Please select competition time.', 'Pole Dance', 'CompetitionMiniute');
		return false;
    }
	if($('#DurationHour').val()==""){
   		jAlert('Please select competition duration hour.', 'Pole Dance', 'DurationHour');
		return false;
    }
	if($('#DurationMiniute').val()==""){
   		jAlert('Please select competition duration minute.', 'Pole Dance', 'DurationMiniute');
		return false;
    }
	if($('#CompetitionSuburb').val()==""){
   		jAlert('Please enter competition suburb name.', 'Pole Dance', 'CompetitionSuburb');
		return false;
    }else{
		if(checkSpecialChar('CompetitionSuburb', 4) == false){
			jAlert('Please enter valid competition suburb name.', 'Pole Dance', 'CompetitionSuburb');
			return false;
		}		
	}
	if($('#CompetitionCountry').val()==""){
   		jAlert('Please enter competition country name.', 'Pole Dance', 'CompetitionCountry');
		return false;
    }else{
		if(checkSpecialChar('CompetitionCountry', 4) == false){
			jAlert('Please enter valid competition country name.', 'Pole Dance', 'CompetitionCountry');
			return false;
		}		
	}
    if($('#CompetitionPostalCode').val() !=""){
		if(checkSpecialChar('CompetitionPostalCode', 1) == false){
			jAlert('Please enter valid competition postal code.', 'Pole Dance', 'CompetitionPostalCode');
			return false;
		}		
	}
	if($('#IsPublic').val()==""){
   		jAlert('Please select the Is Public field.', 'Pole Dance', 'IsPublic');
		return false;
    }
	/*if($('#JudgeName').val()=="N"){
   		jAlert('Please select judges name.', 'Pole Dance', 'JudgesICode');
		return false;
    }
	if($('#DivisionICode').val()==""){
   		jAlert('Please select division name.', 'Pole Dance', 'DivisionICode');
		return false;
    }
	
	var CompetitorICode = $("input[name='CompetitorICode[]']").serializeArray();
	if(CompetitorICode.length == 0) 
	{ 
		jAlert('Please select competitor name.', 'Yombook', 'CompetitorICode[]');
		return false;
	}*/
	
	//order validation. 
	var TotalCountOfCheckBox = $('#TotalCheckBox').val();
	for(var x = 0; x < TotalCountOfCheckBox; x++)
	{
		if (jQuery('#CompetitorICode'+x).is(':checked')) 
		{ 
			var OrderList = 'OrderList'+x;
			if($('#OrderList'+x).val()==""){
				jAlert('Please select competitor order value.', 'Pole Dance', OrderList);
				return false;
			}
		} 
	}
	if($('#CompetitionImage').val() != ""){
		var ext = $('#CompetitionImage').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			jAlert('Invalid file type. Upload only .gif, .png, .jpg and .jpeg.', 'Pole Dance', 'CompetitionImage');
			return false;
		}
	}
	
	if($('#FirstName').val() !=""){
		if(checkSpecialChar('FirstName', 4) == false){
			jAlert('Please enter valid contact person first name.', 'Pole Dance', 'FirstName');
			return false;
		}		
	}
	
	if($('#LastName').val() !=""){
		if(checkSpecialChar('LastName', 4) == false){
			jAlert('Please enter valid contact person last name.', 'Pole Dance', 'LastName');
			return false;
		}		
	}
	if($('#EmailAddress').val() !="")
	{
		if(!filter.test($('#EmailAddress').val())){
		jAlert('Please enter contact person valid email address.', 'Pole Dance', 'EmailAddress');
		return false;
		}
	}
	if($('#Suburb').val()!=""){
		if(checkSpecialChar('Suburb', 4) == false){
			jAlert('Please enter valid contact person suburb name.', 'Pole Dance', 'Suburb');
			return false;
		}		
	}
	if($('#Country').val()!=""){
		if(checkSpecialChar('Country', 4) == false){
			jAlert('Please enter valid contact person country name.', 'Pole Dance', 'Country');
			return false;
		}		
	}
	if($('#PostalCode').val()!=""){
		if(checkSpecialChar('PostalCode', 1) == false){
			jAlert('Please enter valid contact person postal code.', 'Pole Dance', 'PostalCode');
			return false;
		}		
	}
	
	if($('#PhoneNumber').val()!="")
	{
		var phoneVal = $('#PhoneNumber').val();
		if(!phoneRegExp.test(phoneVal))
		{
			jAlert('Please enter valid phone number.', 'Pole Dance', 'PhoneNumber');
			return false;
		}
		var numbers = phoneVal.split("").length;	
		if ( numbers  < 8 || numbers > 15 ) {
          	jAlert('Phone Number should be 8 to 14 digits.', 'Pole Dance', 'PhoneNumber');
			return false;
        }
	}
	if($('#MobileNumber').val()!="")
	{
		if(!mobileRegExp.test($('#MobileNumber').val()))
	  	{
			jAlert('Mobile Number should be 10 digits. Ex: 123 456 7890.', 'Pole Dance', 'MobileNumber');
			return false;	
	  	}
	}
	
	var CompetitionName = $('#CompetitionName').val();
	var CompetitionICode = $('#CompetitionICode').val();
	var checkCompetitionNameExist = base_url+'admin/user/checkCompetitionNameExist/update/'+CompetitionICode+'/';
	
	$.ajax({  
			type: "POST",
			url: checkCompetitionNameExist,  
			data: {"CompetitionName": CompetitionName },  
			success: function(msg)
			{  
				//alert(msg); return false;
				if(msg == 'Exist')
				{
					jAlert('This competition name is already exist.', 'Pole Dance', 'CompetitionName');
					return false;
				}
				else
				{
					$("#updatecompetitionform").submit();
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
    <h1 style="color:#AD2E76;">Edit Competition Details </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="updatecompetitionform" id="updatecompetitionform" method="post" action="<?php echo base_url();?>admin/user/editcompetition/update/<?php echo $this->uri->segment(4);?>/" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="19">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td align="left"><span class="box_title">Competition Name <span class="asterick">*</span></span></td>
        <td align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['CompetitionName'];?>" class="tb3" style="width:280px;" tabindex="1" name="CompetitionName" id="CompetitionName" maxlength="50" onkeyup="trimFirstSpace('CompetitionName');" onkeypress="enterPage('updatecompetitionbutton', event);" /></td>
        <td align="left"><span class="box_title">Competition Date <span class="asterick">*</span></span></td>
        <td align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo date('d-m-Y', strtotime($CompetitionDetails['CompetitionDate']));?>" class="tb3" style="width:280px;" tabindex="2" name="CompetitionDate" id="CompetitionDate" maxlength="20"  onkeyup="trimFirstSpace('CompetitionDate');" onkeypress="enterPage('updatecompetitionbutton', event);" readonly="readonly" /></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td align="left"><span class="box_title">Competition Time<span class="asterick">*</span></span></td>
        <td align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><?php 
		  		$hour = date('g', strtotime($CompetitionDetails['CompetitionTime']));
		  		$miniute = date('i', strtotime($CompetitionDetails['CompetitionTime']));
				$meridiem = date('A', strtotime($CompetitionDetails['CompetitionTime']));
			?>
            <select name="CompetitionHour" id="CompetitionHour" class="tb_drop" style="width:86px; height:32px; padding-left:8px; margin-top:8px;" tabindex="3" >
              <option value="" class="box_drop">Hour</option>
              <?php for($i=1; $i<=12; $i++){?>
              <option class="box_drop" value="<?php echo $i;?>" <?php if($hour == $i){echo 'selected';}?>><?php echo $i;?></option>
              <?php } ?>
            </select>
          &nbsp;&nbsp;&nbsp;
            <select name="CompetitionMiniute" id="CompetitionMiniute" class="tb_drop" style="width:95px; height:32px; padding-left:8px;  margin-top:8px;" tabindex="4" >
              <option value="" class="box_drop">Minutes</option>
			  <option class="box_drop" value="0" <?php if($miniute == 0){echo 'selected';}?>>0</option>
              <?php for($k=1; $k<=59; $k++){?>
              <option class="box_drop" value="<?php echo $k;?>" <?php if($miniute == $k){echo 'selected';}?> ><?php echo $k;?></option>
              <?php } ?>
            </select>
  &nbsp;&nbsp;&nbsp;
  <select name="CompetitionMeridian" id="CompetitionMeridian" class="tb_drop" style="width:70px; height:32px; padding-left:10px;margin-top:8px;" tabindex="5" >
    <option class="box_drop" value="AM" <?php if($meridiem == 'AM'){echo 'selected';}?>>AM</option>
    <option class="box_drop" value="PM" <?php if($meridiem == 'PM'){echo 'selected';}?>>PM</option>
  </select>        </td>
        <td height="45" align="left"><span class="box_title">Competition Duration <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left">
		<?php 
		  		$Durationhour = date('G', strtotime($CompetitionDetails['CompetitionDuration']));
		  		$Durationminiute = date('i', strtotime($CompetitionDetails['CompetitionDuration']));
			?>
		<select name="DurationHour" id="DurationHour" class="tb_drop" style="width:86px; height:32px; padding-left:8px; margin-top:8px;" tabindex="6" >
            <option value="" class="box_drop">Hour</option>
            <option class="box_drop" value="0" <?php if($Durationhour == 0){echo 'selected';}?>>0</option>
            <?php for($i=1; $i<=12; $i++){?>
            <option class="box_drop" value="<?php echo $i;?>" <?php if($Durationhour == $i){echo 'selected';}?>><?php echo $i;?></option>
            <?php } ?>
          </select>
  &nbsp;&nbsp;
  <select name="DurationMiniute" id="DurationMiniute" class="tb_drop" style="width:95px; height:32px; padding-left:8px;  margin-top:8px;" tabindex="7" >
    <option value="" class="box_drop">Minutes</option>
	<option class="box_drop" value="0" <?php if($Durationminiute == 0){echo 'selected';}?>>0</option>
    <?php for($k=1; $k<=59; $k++){?>
    <option class="box_drop" value="<?php echo $k;?>" <?php if($Durationminiute == $k){echo 'selected';}?>><?php echo $k;?></option>
    <?php } ?>
</select></td>
      </tr>
      
      
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Address Line 1</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo stripslashes($CompetitionDetails['CompetitionAddressLine1']);?>" class="tb3" style="width:280px;" tabindex="8" name="CompetitionAddressLine1" id="CompetitionAddressLine1" maxlength="255" onkeyup="trimFirstSpace('CompetitionAddressLine1');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Address Line 2</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo stripslashes($CompetitionDetails['CompetitionAddressLine2']);?>" class="tb3" style="width:280px;" tabindex="9" name="CompetitionAddressLine2" id="CompetitionAddressLine2" maxlength="255" onkeyup="trimFirstSpace('CompetitionAddressLine2');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Suburb <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['CompetitionSuburb'];?>" class="tb3" style="width:280px;" tabindex="10" name="CompetitionSuburb" id="CompetitionSuburb" maxlength="40" onkeyup="trimFirstSpace('CompetitionSuburb');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Country <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['CompetitionCountry'];?>" class="tb3" style="width:280px;" tabindex="11" name="CompetitionCountry" id="CompetitionCountry" maxlength="40" onkeyup="trimFirstSpace('CompetitionCountry');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Postal Code</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['CompetitionPostalCode'];?>" class="tb3" style="width:280px;" tabindex="12" name="CompetitionPostalCode" id="CompetitionPostalCode" maxlength="20" onkeyup="trimFirstSpace('CompetitionPostalCode');"  onkeypress="enterPage('updatecompetitionbutton', event);"/>        </td>
        <td align="left"><span class="box_title">Select Judges</span></td>
        <td align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><?php if(count($JudgesDetails) > 0 ){ ?>
            <select name="JudgesICode" id="JudgesICode" style="width:264px;line-height:25px;" tabindex="13" multiple="multiple">
              <option class="box_drop" value="">Select </option>
              <?php foreach($JudgesDetails as $row){?>
              <option class="box_drop" value="<?php echo $row['JudgesICode'];?>" <?php if(in_array($row['JudgesICode'], $Cjudges)){echo 'selected';}?>><?php echo $row['FullName'];?></option>
              <?php } ?>
            </select>
            <?php } else {?>
            <input type="text" value="No Judges Available" class="tb3" style="width:280px; margin-top:7px;" tabindex="13" name="ttt" id="ttt"onkeypress="enterPage('updatecompetitionbutton', event);" readonly="readonly"/>
            <?php } ?>        </td>
      </tr>
      <tr>
        <td height="19" colspan="7">&nbsp;</td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left" valign="top"><span class="box_title" style="padding-top:5px;">Select Division</span></td>
        <td align="center" valign="top"><span class="box_title">:</span></td>
        <td height="45" align="left" valign="top"><table width="80%" height="35" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div class="judges_div" style="width:280px;">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" height="15"></td>
                </tr>
                <?php if(!empty($DivisionDetails)){ foreach($DivisionDetails as $row){ ?>
                <tr>
                  <td width="11%" height="27" align="left"><input type="checkbox" name="DivisionICode[]" id="DivisionICode[]" value="<?php echo $row['DivisionICode'];?>" onclick="loadcompetitoredit(this)" <? if($row['DivisionICode'] !="" and (in_array($row['DivisionICode'], $DivisionICode))){echo "checked";}   ?>/></td>
                  <td width="89%" align="left"><span class="box_title"><?php echo $row['DivisionName'];?></span></td>
                </tr>
                <?php }} else {?>
                <tr>
                  <td colspan="2" align="left"><span class="box_title">No Records</span></td>
                </tr>
                <?php } ?>
              </table>
            </div></td>
          </tr>
        </table>
          </td>
        <td height="45" align="left" valign="top"><span class="box_title">Select  Competitor</span></td>
        <td align="center" valign="top"><span class="box_title">:</span></td>
        <td height="45" align="left" valign="top"><table width="95%" height="35" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>
                	<div class="judges_div2" id="particularCompetitor" >
              <div>
              
                <!-- this code is edited by bernazzyk -->
                <div>
                  <div colspan="2" align="left" height="15"><b>Competitor Name</b></div>
                </div>	
                	
                	<?php if(!empty($CompetitorDetails)){ foreach ($CompetitorDetails as $rowCompetitor){?>
                <div style="padding-left: 20px;">                	
                  <div align="left">
                  	<span class="box_title"><?php echo getMaxFieldLength(ucwords($rowCompetitor['FullName']), 23);?></span>
                  	<div class="competitor" id="competitor<?php echo $rowCompetitor['CompetitorICode'];?>">
						
                  	</div>
                  </div>                 
                  
                </div>
                <?php }} else {?>
                <div>
                  <div colspan="2" align="left"><span class="box_title">No Records</span></div>
                </div>
                <?php }?>
                <!-- this code is edited by bernazzyk -->
                
              </div>
            </div>
                </td>
              </tr>
          </table></td>
        </tr>
      <tr>
        <td height="19">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19" align="left">&nbsp;</td>
      </tr>
	  <tr>
	    <td height="103">&nbsp;</td>
	    <td height="103" align="left"><span class="box_title">Competition Image </span></td>
	    <td height="103" align="center"><span class="box_title">:</span></td>
	    <td height="103" align="left"><?php if($CompetitionDetails['CompetitionImage'] !='') { ?>
	      <img src="<?php echo base_url(); ?>uploads/CompetitionImages/<?php echo $CompetitionDetails['CompetitionImage'];?>" width="100px" height="100px" border="0"/>
	      <?php } else { ?>
	      <img src="<?php echo base_url(); ?>images/NoPhoto.jpg" width="100px" height="100px" border="0"/>
	      <?php } ?></td>
	    <td height="103" align="left">&nbsp;</td>
	    <td align="center">&nbsp;</td>
	    <td height="103" align="left">&nbsp;</td>
	    </tr>
      <tr>
        <td height="44">&nbsp;</td>
        <td height="45" align="left">&nbsp;</td>
        <td height="44" align="center">&nbsp;</td>
        <td height="44" align="left"><input type="file" name="CompetitionImage" id="CompetitionImage" class="tb1" size="20" tabindex="10" /></td>
        <td height="44" align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="44" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" colspan="3" align="left"><h1 style="color:#AD2E76;">Competition Contact Person Details.</h1></td>
        <td height="45" align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="45" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td width="5%" height="45">&nbsp;</td>
        <td width="12%" align="left"><span class="box_title">First Name</span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="31%" height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['FirstName'];?>" class="tb3" style="width:280px;" tabindex="17" name="FirstName" id="FirstName" maxlength="50"  onkeyup="trimFirstSpace('FirstName');" onkeypress="enterPage('updatecompetitionbutton', event);" /></td>
        <td width="14%" height="45" align="left"><span class="box_title">Last Name</span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="32%" height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['LastName'];?>" class="tb3" style="width:280px;" tabindex="18" name="LastName" id="LastName" maxlength="50" onkeyup="trimFirstSpace('LastName');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
      
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Email Address</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['EmailAddress'];?>" class="tb3" style="width:280px; text-transform:lowercase;" tabindex="18" name="EmailAddress" id="EmailAddress" maxlength="80" onkeyup="trimFirstSpace('EmailAddress');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Address Line 1</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo stripslashes($CompetitionDetails['AddressLine1']);?>" class="tb3" style="width:280px;" tabindex="19" name="AddressLine1" id="AddressLine1" maxlength="255" onkeyup="trimFirstSpace('AddressLine1');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Address Line 2</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo stripslashes($CompetitionDetails['AddressLine2']);?>" class="tb3" style="width:280px;" tabindex="20" name="AddressLine2" id="AddressLine2" maxlength="255" onkeyup="trimFirstSpace('AddressLine2');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Suburb</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['Suburb'];?>" class="tb3" style="width:280px;" tabindex="21" name="Suburb" id="Suburb" maxlength="50" onkeyup="trimFirstSpace('Suburb');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Country</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['Country'];?>" class="tb3" style="width:280px;" tabindex="22" name="Country" id="Country" maxlength="50" onkeyup="trimFirstSpace('Country');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Postal Code</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['PostalCode'];?>" class="tb3" style="width:280px;" tabindex="23" name="PostalCode" id="PostalCode" maxlength="50" onkeyup="trimFirstSpace('PostalCode');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
      
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Phone Number</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['PhoneNumber'];?>" class="tb3" style="width:280px;" tabindex="24" name="PhoneNumber" id="PhoneNumber" maxlength="15" onkeyup="trimFirstSpace('PhoneNumber');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Mobile Number</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitionDetails['MobileNumber'];?>" class="tb3" style="width:280px;" tabindex="25" name="MobileNumber" id="MobileNumber" maxlength="15" onkeyup="trimFirstSpace('MobileNumber');"  onkeypress="enterPage('updatecompetitionbutton', event);"/></td>
      </tr>
       <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Result Status<span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left">
			<select name="IsPublic" id="IsPublic" style="width:285px;">
				<option value="1" <?php if($CompetitionDetails['IsPublic'] == '1') echo 'selected="selected"'; ?>>Public</option>
				<option value="0" <?php if($CompetitionDetails['IsPublic'] == '0') echo 'selected="selected"'; ?>>Private</option>
			</select>
		</td>
     </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td height="24" align="left">&nbsp;</td>
        <td height="24" align="center">&nbsp;</td>
        <td height="24" align="left">&nbsp;</td>
        <td height="24" align="left">&nbsp;</td>
        <td height="24" align="center">&nbsp;</td>
        <td height="24" align="left">&nbsp;</td>
      </tr>
      
      
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="45" colspan="7"><table width="100%" height="67" border="0" cellpadding="0" cellspacing="0">
        <?php if($CompetitionDetails['IsCompleted'] == 1) {?>
          <tr>
            <td height="24" colspan="3" align="left"><span class="btn_bx" style="margin-left:240px;">
			<input type="hidden" value="<?php echo $CompetitionDetails['CompetitionICode'];?>" name="CompetitionICode" id="CompetitionICode"/>
              <input type="button" name="clear" id="clear" value="Cancel" tabindex="27" onclick="location.href='<?php echo base_url();?>admin/user/managecompetition/'"/></span></td>
            <td align="left">&nbsp;</td>
          </tr>
          <?php } else {?>
          <tr>
            <td width="21%" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
            <td width="9%" align="left"><span class="btn_bx">
              <input type="button" name="updatecompetitionbutton" id="updatecompetitionbutton" value="Update" onClick="return validateAddNewcompetitor();" tabindex="26"></span>
			<input type="hidden" value="N" name="JudgeName" id="JudgeName"/>
			<input type="hidden" value="N" name="CompetitorName" id="CompetitorName"/>
			<input type="hidden" value="<?php echo $CompetitionDetails['CompetitionICode'];?>" name="CompetitionICode" id="CompetitionICode"/>			</td>
            <td width="66%" align="left"><span class="btn_bx">
              <input type="button" name="clear" id="clear" value="Cancel" tabindex="27" onclick="location.href='<?php echo base_url();?>admin/user/managecompetition/'"/></span></td>
            <td width="4%" align="left">&nbsp;</td>
          </tr>
          <?php } ?>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
    </table>
	</form>
</div>
    </div>
  </div>
</div></td>
      </tr>
    </table>
<script type="text/javascript">
$(document).ready(function()
{
	$('#CompetitionDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
});
</script>