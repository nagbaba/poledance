<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<!-- Tooltip scripts -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.tooltip.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip_jquery.dimensions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip_jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/flowplayer-3.2.8.min.js"></script>
<script>
function refreshpage() { window.location.href = base_url+'competition/postResult/'; } // refresh this page
function backurl() { window.location.href = base_url+'competition/startedcompetitionlist'; } // go to back page

function checkMaxScore(val, minscore, maxscore, fieldname) // chaeck max secured score
{
	if(val != '')
	{
		if(Number(minscore) > 0)
		{
			if((Number(val) < Number(minscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}
		else
		{
			//alert('-ive');
			if((Number(val) > Number(minscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}

		if(Number(maxscore) > 0)
		{
			//alert('+ive');
			if((Number(val) > Number(maxscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}
		else
		{
			//alert('-ive');
			if((Number(val) < Number(maxscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}
	}
}

function checkCompetitionStatus()
{
	var CompetitionICode = $("#CompetitionICode").val();
	var checkCompetitionStatus =  base_url+'competition/checkCompetitionStatus/';;
	$.ajax({  
			type: "POST",
			url: checkCompetitionStatus,  
			data: {"CompetitionICode": CompetitionICode },  
			success: function(msg)
			{  
				if(msg == 'Closed')
				{
					jAlert('This competition now closed.', 'Pole Dance', 'EmailAddress');
					return false;
				}
				else
				{
					$("#postresult").submit();
				}
			 }
		});
}
// ENTER ONLY NUMBER IN TEXTBOX
/*function isNumberKey(evt)
 {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45 && charCode != 46)
  return false;
  return true;
 }*/
 
$(function() {
$('.tooltip_popup').tooltip({
	track: true,
	delay: 0,
	showURL: false,
	extraClass: "right"
});
});


function endcompetition(CompetitionICode)
{
 jConfirm('Do you want to close this competition?', 'Pole Dance', function(r) {
	if(r == true)
	{
		var endcompetition = base_url+'competition/manageendcompetitionAjax/';
		$.ajax({  
			type: "POST",
			url: endcompetition,  
			data: {"CompetitionICode": CompetitionICode },  
			success: function(msg)
			{
			if(msg == 'success'){
				window.location.reload();
				}
				//alert(msg);
			}	
		});
	}
	});	
}
</script>

    <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <td><div class="box">
                <div class="heading">
                   
</div>
                <div>&nbsp;</div>
                <div class="content">
<table width="970" border="0">
  <tr>
    <td width="22%"> <h1 style="color:#AD2E76;">Competitor</h1></td>
    <td> <h1 style="color:#AD2E76;">Result </h1>  <div style="float:right;"></div> </td>
    </tr>
  <tr>
    <td height="23" valign="top">
      <table width="98%" border="0" style="background-color:#F3F3F3;">
        <tr>
          <td height="4"></td>
          </tr>
        <?php if(!empty($CompetitorNameList)){ foreach($CompetitorNameList as $v) {?>
        <!-- edited by 4axiz to show the division also -->
        <tr>
          <td height="30" style="padding-left:5px;"><a href="<?php echo base_url();?>competition/PostResult/<?php echo $CompetitionICode;?>/<?php echo $v['CompetitionCompetitorICode'];?>/" class="NameLink"><?php echo $v['CompetitorOrder'].'. '.getMaxFieldLength(ucwords($v['FullName']), 22).' - '.$this->home->getSingleFieldValue('division_master', 'DivisionName', "DivisionICode = '".$v['DivisionICode']."'");?></a></td>
          </tr>
         <!-- edited by 4axiz to show the division also -->
        <?php } }?>
         <tr>
          <td height="4"></td>
          </tr>
		
        </table>
		<br/>
		<table>
		<tr>
		<td>
		<?php /*if($CompetitionDetails['IsCompleted'] != 1){?>
			<span class="btn_bx" style="float:right; width:60px;">
				<input type="button" onclick="return endcompetition('<?php echo $CompetitionICode; ?>');" tabindex="2" name="End" value="End">
			</span>
		<? }*/?>
		</td>
		</tr>
		</table>
		
		</td>
    <td valign="top">
    <form name="postresult" id="postresult" action="<?php echo base_url().'competition/saveresult/';?>" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	    <td><div class="competitionTitle"><?php  echo ucwords($CompetitionDetails['CompetitionName']);
			
			if(!empty($disable)){echo '<span class="redalert"> &nbsp;&nbsp;-&nbsp;&nbsp;Competition has now closed.</span>';}
		?>
		</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="720" border="0" cellspacing="0" cellpadding="0" align="right">
          <tr>
            <td width="449"  valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td width="30%" height="30"><span class="Rtitle">Competitor Name </span></td>
                <td width="4%"><span class="Rtitle">:</span></td>
                <td width="66%" class="Rstitle"><?php echo getMaxFieldLength(ucwords($TitleDetails['FullName']), 40); ?></td>
                </tr>
              <tr>
                <td height="30"><span class="Rtitle">Division Name</span></td>
                <td><span class="Rtitle">:</span></td>
                <td class="Rstitle"><?php echo getMaxFieldLength(ucwords($TitleDetails['DivisionName']), 40); ?></td>
                </tr>
              <tr>
                <td height="30"><span class="Rtitle">Order Number</span></td>
                <td><span class="Rtitle">:</span></td>
                <td class="Rstitle"><?php echo $TitleDetails['CompetitorOrder'];?></td>
              </tr>
              </table></td>
            <td width="271"  valign="top"><table width="98%" height="42" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="3" align="center">
				<?php if(!empty($TitleDetails['ProfileImage']) && file_exists("./uploads/CompetitiorImages/".$TitleDetails['ProfileImage'])){?>
				<img src="<?php echo base_url(); ?>uploads/CompetitiorImages/<?php echo $TitleDetails['ProfileImage'];?>" width="150px" height="150px" border="0" title="<?php echo ucwords($TitleDetails['FullName']).' image';?>"/>
				<?php } else {?>
				<img src="<?php echo base_url(); ?>images/NoPhoto.jpg" width="150px" height="150px" border="0" title="No Image"/>
				<?php } ?>				</td>
				<td height="30" style="padding-left:5px;">
		  <?php if($TitleDetails['video'] != ''){?>
		   <a href="<?php echo base_url(); ?>uploads/videos/<?php echo $TitleDetails['video'];?>" style="display:block;width:190px;height:145px" id="player"> 
			</a>
   		  <?php }else{ ?>
		  	<iframe width="190" height="145" src="<?php echo $TitleDetails['embed_code']; ?>" frameborder="0" allowfullscreen></iframe>
		  <?php } ?>
		  </td>
                </tr>
              
              </table></td>
            </tr>
          <tr>
            <td height="19" colspan="2">&nbsp;</td>
          </tr>
          </table></td>
        </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #999;">
          <tr>
            <td height="30" align="center" class="table_result">
              <?php echo ucwords($JudgesDetails['FullName']).' - '.ucwords($JudgesDetails['Country']);?></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="29">&nbsp;</td></tr>
      <tr>
        <td><?php  if(!empty($Sectiondetails)) { $i = 1;
					$fval = array();
					foreach ($Sectiondetails as $row) { 
						$WhereFieldValue = "SectionICode ='".$row['SectionICode']."' AND IsActive='0' AND IsDeleted = '0'";
						$SectionCount = $this->home->getTotalCountOfRecords('subsection_master', $WhereFieldValue);
						// fetch subsection details
						if($SectionCount > 0)
						{
							$Fields = "SubsectionICode, SubsectionName, SubsectionDescription";
							$Subsectiondetails = $this->home->getParticularResults('subsection_master', $Fields, $WhereFieldValue);
			?>      
            <table width="100%" border="0" >
            <tr>
              <td colspan="3" align="left"><table width="100%" border="0">
                <tr>
                  <td width="13%" class="table_title">Section <?php echo $i; ?></td>
                  <td width="3%" class="table_title">:</td>
                  <td width="84%" class="table_result"><span id="slideToggle<?php echo $row['SectionICode'];?>" style="cursor:pointer;" title="Click here to view section description"><?php echo $row['SectionName'];?></span>&nbsp;&nbsp;&nbsp;<span class="table_title2"><?php echo $row['MinPoint'].' ~ '.$row['MaxPoint'];?> Points Each</span></td>
                </tr>
				
               </table><div class="slideTogglebox<?php echo $row['SectionICode'];?>" style="display:none;" align="justify">
			   <?php echo $row['SectionDescription'];?></div>
			 	<script>
					$("#slideToggle<?php echo $row['SectionICode'];?>").click(function () {
					   $('.slideTogglebox<?php echo $row['SectionICode'];?>').slideToggle("slow");
					});
				</script>			  </td>
              </tr>
             <tr>
            <td colspan="3">
            <div style="overflow-x:auto;overflow-y:hidden; width:740px; height:100px; ">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
			  	<?php for($k=0; $k < $SectionCount; $k++){
					if($k == 0){ $Topstyle = 'tbl_topleft';}else{$Topstyle = 'tbl_topright'; }
				?>
                <td height="27" class="<?php echo $Topstyle;?>"><span style="cursor:pointer;" class="tooltip_popup" title="<?php echo $Subsectiondetails[$k]['SubsectionDescription']; ?>"><?php echo $Subsectiondetails[$k]['SubsectionName']; ?></span></td>
                <?php }?>
               </tr>
              <tr>
                <?php for($k=0; $k < $SectionCount; $k++){
                        $txtfieldname = 'securedpts_'.$row['SectionICode'].'_'.$Subsectiondetails[$k]['SubsectionICode'].'_'.$row['MaxPoint'];
                        $fval[] = $txtfieldname;
						if($k == 0){ $Bottomstyle = 'tbl_bottomleft';}else{$Bottomstyle = 'tbl_bottomright'; }
                    ?>
                     <input type="hidden" name="fieldname[]" value="<?php echo $txtfieldname;?>" />
					 <td height="45" class="<?php echo $Bottomstyle; ?>"><input type="text" id="<?php echo $txtfieldname;?>" name="<?php echo $txtfieldname;?>" style="width:60px;" maxlength="3" onkeyup="return checkMaxScore(this.value,'<?php echo $row['MinPoint'];?>', '<?php echo $row['MaxPoint'];?>', '<?php echo $txtfieldname;?>');"  tabindex="1" <?php echo $disable; ?>/></td>
                <?php }?>
               </tr>
               <tr>
                <td height="19" >&nbsp;</td>
                </tr>
            </table>
            </div>            </td>
            </tr>
            </table>
			<?php } $i++; } } ?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	   <tr>
        <td class="table_title">Write Comment</td>
      </tr>
	  <tr>
        <td><textarea name="Comment" id="Comment" rows="6" cols="50"></textarea></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="hidden" name="CompetitionICode" id="CompetitionICode" value="<?php echo $CompetitionICode;?>" />
            <input type="hidden" name="CompetitionCompetitorICode" id="CompetitionCompetitorICode" value="<?php echo $CompetitionCompetitorICode;?>" />
            <input type="hidden" name="CompetitorICode" value="<?php echo $TitleDetails['CompetitorICode'];?>" />
          	<?php if(empty($disable)) {?>
		    <span style = "float:right; width:60px;" class="btn_bx"><input type="button"  value="Save" name="Save" tabindex="2" onclick="return checkCompetitionStatus();"/></span><?php } ?></td>
      </tr>
  </table>
  </form>
  </td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
</div>
                </div>

                   </td>
        </tr> 
    </table>

<script type="text/javascript">
		$(document).ready(function() {
			flowplayer("player", "<?php echo base_url(); ?>js/flowplayer-3.2.9.swf");
			});
		</script>