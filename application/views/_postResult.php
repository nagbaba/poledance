<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
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

// ENTER ONLY NUMBER IN TEXTBOX
/*function isNumberKey(evt)
 {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45 && charCode != 46)
  return false;
  return true;
 }*/
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
    <td> <h1 style="color:#AD2E76;">Result</h1>  <div style="float:right;"></div></td>
    </tr>
  <tr>
    <td height="23" valign="top">
      <table width="98%" border="0" style="background-color:#F3F3F3;">
        <tr>
          <td height="4"></td>
          </tr>
        <?php if(!empty($CompetitorNameList)){ foreach($CompetitorNameList as $v) {?>
        <tr>
          <td height="30" style="padding-left:5px;"><a href="<?php echo base_url();?>competition/PostResult/<?php echo $CompetitionICode;?>/<?php echo $v['CompetitionCompetitorICode'];?>/" class="NameLink"><?php echo $v['CompetitorOrder'].'. '.getMaxFieldLength(ucwords($v['FullName']), 22);?></a></td>
          </tr>
        <?php } }?>
         <tr>
          <td height="4"></td>
          </tr>
        </table></td>
    <td valign="top">
    <form name="postresult" id="postresult" action="<?php echo base_url().'competition/saveresult/';?>" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="720" border="0" cellspacing="0" cellpadding="0" align="right">
          <tr>
            <td width="360"><table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="32%" height="30"><span class="Rtitle">Competition Name </span></td>
                <td width="2%"><span class="Rtitle">:</span></td>
                <td width="66%"><?php echo getMaxFieldLength(ucwords($CompetitionDetails['CompetitionName']), 25) ?></td>
                </tr>
              <tr>
                <td height="30"><span class="Rtitle">Division Name</span></td>
                <td><span class="Rtitle">:</span></td>
                <td><?php echo getMaxFieldLength(ucwords($TitleDetails['DivisionName']), 25) ?></td>
                </tr>
              </table></td>
            <td width="360"><table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="33%" height="30"><span class="Rtitle">Competitor Name </span></td>
                <td width="3%"><span class="Rtitle">:</span></td>
                <td width="64%"><?php echo getMaxFieldLength(ucwords($TitleDetails['FullName']), 25) ?></td>
                </tr>
              <tr>
                <td height="30"><span class="Rtitle">Order Number</span></td>
                <td><span class="Rtitle">:</span></td>
                <td><?php echo $TitleDetails['CompetitorOrder'];?></td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td height="30" colspan="2">&nbsp;</td>
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
							$Fields = "SubsectionICode, SubsectionName";
							$Subsectiondetails = $this->home->getParticularResults('subsection_master', $Fields, $WhereFieldValue);
			?>      
            <table width="100%" border="0" >
            <tr>
              <td colspan="3" align="left"><table width="100%" border="0">
                <tr>
                  <td width="13%" class="table_title">Section <?php echo $i; ?></td>
                  <td width="3%" class="table_title">:</td>
                  <td width="84%" class="table_result"><?php echo $row['SectionName'];?></td>
                </tr>
              </table></td>
              </tr>
             <tr>
            <td colspan="3">
            <div style="overflow-x:auto;overflow-y:hidden; width:740px; height:100px; ">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="27" height="27" class="tbl_topleft"><?php echo $row['SectionName'];?></td>
                <?php for($k=0; $k < $SectionCount; $k++){?>
                <td class="tbl_topright"><?php echo $Subsectiondetails[$k]['SubsectionName']; ?></td>
                <?php }?>
               </tr>
              <tr>
                <td height="45" class="tbl_bottomleft"><?php echo $row['MinPoint'].' ~ '.$row['MaxPoint'];?></td>
                <?php for($k=0; $k < $SectionCount; $k++){
                        $txtfieldname = 'securedpts_'.$row['SectionICode'].'_'.$Subsectiondetails[$k]['SubsectionICode'].'_'.$row['MaxPoint'];
                        $fval[] = $txtfieldname;
                        
                    ?>
                     <input type="hidden" name="fieldname[]" value="<?php echo $txtfieldname;?>" />
                <td class="tbl_bottomright"><input type="text" id="<?php echo $txtfieldname;?>" name="<?php echo $txtfieldname;?>" style="width:60px;" maxlength="3" onkeyup="return checkMaxScore(this.value,'<?php echo $row['MinPoint'];?>', '<?php echo $row['MaxPoint'];?>', '<?php echo $txtfieldname;?>');"  tabindex="1"/></td>
                <?php }?>
               </tr>
               <tr>
                <td height="19" >&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
            </table>
            </div>
            </td>
            </tr>
            </table>
			<?php } $i++; } } ?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="hidden" name="CompetitionICode" value="<?php echo $CompetitionICode;?>" />
            <input type="hidden" name="CompetitionCompetitorICode" value="<?php echo $CompetitionCompetitorICode;?>" />
            <input type="hidden" name="CompetitorICode" value="<?php echo $TitleDetails['CompetitorICode'];?>" />
            <span style = "float:right; width:60px;" class="btn_bx"><input type="submit"  value="Save" name="Save" tabindex="2"/></span>
        </td>
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

