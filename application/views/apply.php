<script type="text/javascript">
function backtoprofile()
{

    window.location = "<?php echo base_url().'competitor/profile';?>";
}
// edit judges 
function validateEditCompetitor()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	var EditCompetitorICode 	 = $('#EditCompetitorICode').val();
	var LoginCredentialICode = $('#LoginCredentialICode').val();
		
	
	if($('#CompetitionICode').val()==""){
   		jAlert('Please select division name.', 'Pole Dance', 'CompetitionICode');
		return false;
    }
		
	var EmailAddress = $('#EmailAddress').val();
	
	var checkEmailIdExist = base_url+'admin/user/checkEmailIdExist/'+LoginCredentialICode+'/';
	
	$.ajax({  
			type: "POST",
			url: checkEmailIdExist,  
			data: {"EmailAddress": EmailAddress },  
			success: function(msg)
			{  
				//alert(msg); return false;
				if(msg == 'Exist')
				{
					jAlert('This Email Address is already exist.', 'Pole Dance', 'EmailAddress');
					return false;
				}
				else
				{
					$("#updateeditcompetitorform").submit();
				}
			 }
		});
}


//edited by 4axiz

function loaddivision(val){
	var division = base_url+'competitor/ajaxCompetitionSelect/';	

	if($(val).val()){
		$.ajax({  
			type: "POST",
			url: division,  
			data: {"CompetitionICode": $(val).val() },  
			success: function(msg)
			{  
				
				$(".judges_div").html(msg);
				$("#divisionrow").show();
			}
		});
	}
	else{ 
		
		$("#divisionrow").hide();
		//$(".judges_div").html("");
	}
}

//edited by 4axiz
</script>
<?php if($this->session->flashdata('apply_msg') == 'false') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('You have already applied to this competition.', 'Pole Dance', '');
  $("#divisionrow").hide();
});
	
</script>
<?php } else if($this->session->flashdata('apply_msg') == 'true'){?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('You have successfully applied to this competition.', 'Pole Dance', '');
});


	
</script>
<?php } ?>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Apply to the competition </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="updateeditcompetitorform" id="updateeditcompetitorform" method="post" action="<?php echo base_url();?>competitor/apply_to_competition/<?php echo $this->session->userdata('LoginUserICode');?>">
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
	  <?php //print_r($Competions);?>
      <tr>
        <td width="5%" height="45">&nbsp;</td>
        <td width="11%" align="left"><span class="box_title">Competitions <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="34%" height="45" align="left">
			<select name="CompetitionICode" id="CompetitionICode" class="tb_drop" style="width:286px; height:32px; margin-top:8px; background-color:#FFF;" tabindex="10" onchange="loaddivision(this);" >
          <option value="" class="box_drop">Select Competition Name</option>
          <?php if(count($Competions) > 0 ){foreach($Competions as $row){?>
          <option class="box_drop" value="<?php echo $row['CompetitionICode'];?>"><?php echo $row['CompetitionName'];?></option>
          <?php } } else{ ?>
          <option class="box_drop" value="">No Records Available</option>
          <?php } ?>
        </select>	</td>
      </tr>
      
   <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
      
      <!--  this code was edited by 4axiz -->
      
      <tr id="divisionrow" style="display: none;">
      	<td width="5%" height="45">&nbsp;</td>
        <td width="11%" align="left"><span class="box_title" id="label_title">Select Division <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="34%" height="45" align="left">
        	<table width="80%" height="35" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div class="judges_div" style="width:280px;">
              
            </div></td>
          </tr>
        </table>
        </td>
      </tr>
      
      <!--  this code was edited by 4axiz -->
      
      <tr>
        <td height="45" colspan="7"><table width="100%" height="42" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="19%" align="left"></td>
            <td width="8%" align="left"><span class="btn_bx">
				<input type="button" name="updatecompetitorbutton" id="updatecompetitorbutton" value="Apply" onClick="return validateEditCompetitor();" tabindex="13"></span> 
			
			 <input type="hidden" name="EditCompetitorICode" id="EditCompetitorICode" value="<?php echo $this->uri->segment(4);?>" />
			<input type="hidden" name="LoginCredentialICode" id="LoginCredentialICode" value="" /></td>
			<td width="4%" align="left">&nbsp;</td>
			 <td width="8%" align="left"><span class="btn_bx"><input type="button" name="back" id="back" value="Back" onClick="return backtoprofile();" tabindex="14"></span> 
			</td>
			<td width="69%" align="left"></td>
            <td width="4%" align="left">&nbsp;</td>
          </tr>
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