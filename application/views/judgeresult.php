<?php 
$WhereField = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CreatedBy = '".$JId."'";
$TotalPoints = $this->home->getSumOfParticularFieldFromId('post_result', 'SecuredPoints', $WhereField ); 

$WhereField = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND CreatedBy <>0";
$TotalPointsOfAllJudges = $this->home->getSumOfParticularFieldFromId('post_result', 'SecuredPoints', $WhereField ); 
	?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<!-- Tooltip scripts -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.tooltip.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip_jquery.dimensions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip_jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/flowplayer-3.2.8.min.js"></script>
<script>
function refreshpage() { window.location.href = base_url+'competition/postResult/'; } // refresh this page
function backurl() { window.location.href = base_url+'competition/alljudges/'+<?php echo $this->uri->segment(4);?>+'/'; } // go to back page

function gotojudge(judgeid){
	window.location.href = base_url+'competition/judgeresult/'+<?=$CompetitionICode?>+'/'+judgeid;
}

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

 // for tooltip
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
<?if($IsJudgeHead){?>
  <tr>
    <td width="22%"> <h1 style="color:#AD2E76;">Judges</h1></td>
   
    </tr>
	 <tr>
    <td width="22%">
	<select style="width:200px;" onchange="gotojudge(this.options[this.options.selectedIndex].value);">
	<?
	foreach( $AllJudges as $onejudge):
	?>
	<option <?if($JId==$onejudge['JudgesICode']){echo 'selected=true';}?> value="<?=$onejudge['JudgesICode']?>"><?=$onejudge['FullName']?></option>
	<?
	endforeach;
	?>
	</select>
	</td>
    </tr>
<?
}
?>
  <tr>
    <td width="22%"> <h1 style="color:#AD2E76;margin-top:20px">Competitor</h1></td>
    <td> <h1 style="color:#AD2E76;">Result</h1>  <div style="float:right;"></div></td>
    </tr>
  <tr>
    <td height="23" valign="top">
      <table width="98%" border="0" style="background-color:#F3F3F3;">
        <tr>
          <td height="4"></td>
          </tr>
        <?php if(!empty($CompetitorNameList)){ foreach($CompetitorNameList as $v) { ?>
        
        <!-- edited by bernazzyk to add the division name there - edit date: 28-04-12 -->
        <tr>
          <td height="30" style="padding-left:5px;"><a href="<?php echo base_url();?>competition/judgeresult/<?php echo $CompetitionICode;?>/<?php echo $this->uri->segment(4);?>/<?php echo $v['CompetitionCompetitorICode'];?>/" class="NameLink"><?php echo $v['CompetitorOrder'].'. '.getMaxFieldLength(ucwords($v['FullName']), 22).' - '.$this->home->getSingleFieldValue('division_master', 'DivisionName', "DivisionICode = '".$v['DivisionICode']."'");?></a></td>
          </tr>
          
        <!-- edited by bernazzyk -->  
        
        <?php } }?>
         <tr>
          <td height="4"></td>
          </tr>
        </table>
		
		
		<?php
			//echo $CompetitionDetails['IsCompleted'].$CompetitionDetails['IsStarted'].$CompetitionResultPostDetails."::teat";
		if($CompetitionDetails['IsCompleted'] != 1  && $CompetitionDetails['IsStarted'] != 0 && $CompetitionResultPostDetails != ""){ ?>
		<br/>
		<table>
		<tr>
		<td>
		<span class="btn_bx" style="float:right; width:60px;">
		<input type="button" onclick="return endcompetition('<?php echo $CompetitionICode; ?>');" tabindex="2" name="End" value="End">
		</span>
		</td>
		</tr>
		</table>
		<?
		}
		?>
		
		</td>
    <td valign="top">
    <form name="postresult" id="postresult" action="<?php echo base_url().'competition/saveresult/';?>" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="competitionTitle"><?php  echo ucwords($CompetitionName);?> </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="720" border="0" cellspacing="0" cellpadding="0" align="right">
          <tr>
            <td width="442"  valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
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
            <td width="278"  valign="top"><table width="98%" height="42" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="3" align="center">
			<?php if(!empty($TitleDetails['ProfileImage']) && file_exists("./uploads/CompetitiorImages/".$TitleDetails['ProfileImage'])){?>
				<img src="<?php echo base_url(); ?>uploads/CompetitiorImages/<?php echo $TitleDetails['ProfileImage'];?>" width="150px" height="150px" border="0" title="<?php echo ucwords($TitleDetails['FullName']);?>"/>
				<?php } else {?>
				<img src="<?php echo base_url(); ?>images/NoPhoto.jpg" width="150px" height="150px" border="0" title="No Image"/>
				<?php } ?>				</td>
				 <td height="30" style="padding-left:5px;">
		  <?php if($TitleDetails['video'] != ''){?>
		   <a href="<?php echo base_url(); ?>uploads/videos/<?php echo $TitleDetails['video'];?>" style="display:block;width:190px;height:150px" id="player"> 
			</a>
   		  <?php }else{ ?>
		  	<iframe width="190" height="150" src="<?php echo $TitleDetails['embed_code']; ?>" frameborder="0" allowfullscreen></iframe>
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
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                       <?php
						if(count($championshipdetails) > 0) {
							foreach ($championshipdetails as $req){?>
                        <td  class="tbl_topleft"  height="30"><span class="table_result"><?php echo $req['ChampionshipName'];?> = <b>
						<?php 
							$SinglefieldWhere = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND ChampionshipICode = '".$req['ChampionshipICode']."' AND CreatedBy = '".$JId."'";
							$TTScore = $this->home->getSingleFieldValue('competitor_result', 'SecuredPercentage', $SinglefieldWhere);
							if(!empty($TTScore)){echo $TTScore; }else{echo '--';}
						?></b></span></td>
                        <?php } } ?>
                       </tr>
                     </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td></tr>
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
				</script>			   </td>
              </tr>
             <tr>
            <td colspan="3">
            <div style="overflow-x:auto;overflow-y:hidden; width:740px; height:100px; ">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr><?php for($k=0; $k < $SectionCount; $k++){
			 			if($k == 0){ $Topstyle = 'tbl_topleft';}else{$Topstyle = 'tbl_topright'; }
			  ?>
                <td height="27" class="<?php echo $Topstyle;?>"><span style="cursor:pointer;" class="tooltip_popup" title="<?php echo $Subsectiondetails[$k]['SubsectionDescription']; ?>"><?php echo $Subsectiondetails[$k]['SubsectionName']; ?></span></td><?php }?>
               </tr>
              <tr>
                
                <?php for($k=0; $k < $SectionCount; $k++){
                        $txtfieldname = 'securedpts_'.$row['SectionICode'].'_'.$Subsectiondetails[$k]['SubsectionICode'].'_'.$row['MaxPoint'];
                        $fval[] = $txtfieldname;
						if($k == 0){ $Bottomstyle = 'tbl_bottomleft';}else{$Bottomstyle = 'tbl_bottomright'; }
                        
                    ?>
                     <input type="hidden" name="fieldname[]" value="<?php echo $txtfieldname;?>" />
					 <td height="45"  class="<?php echo $Bottomstyle; ?>"><span class="table_title">
						<?php 
						$SingleWhere = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$row['SectionICode']."' AND CreatedBy = '".$JId."'";
						$PostResultIcode = $this->home->getSingleFieldValue('post_result', 'PostResultIcode', $SingleWhere);
						
						$Where = "SubsectionIcode = '".$Subsectiondetails[$k]['SubsectionICode']."' AND PostResultIcode = '".$PostResultIcode."'";
						echo $Subsectionsecuredpoints = $this->home->getSingleFieldValue('post_subsection_result', 'Subsectionsecuredpoints', $Where);
						
						?>
					 </span></td>
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
        <td><?php if(!empty($Sectiondetails) > 0) {?>
                     <table width="100%" border="0" cellpadding="0" cellspacing="0">
                       <tr>
                         <td width="11%" height="30" class="tbl_topleft">&nbsp;</td>
                         <?php foreach ($Sectiondetails as $row) { ?>
                         <td class="tbl_topright"><?php echo $row['SectionName'];?></td>
                         <?php } ?>
                         <td class="tbl_topright" ><span class="table_title">TOTAL</span></td>
                       </tr>
                       <tr>
                         <td height="42" class="tbl_bottomleft"><span class="table_title">Total Points</span></td>
                         <?php foreach ($Sectiondetails as $row) { ?>
                         <td class="tbl_bottomright">
                         <?php
                         $Where = "CompetitionCompetitorICode = '".$CompetitionCompetitorICode."' AND SectionICode = '".$row['SectionICode']."' AND CreatedBy = '".$JId."'";
						 echo $Subsectionsecuredpoints = $this->home->getSingleFieldValue('post_result', 'SecuredPoints', $Where);
						 ?>                         </td>
                         <?php } ?>
                         <td class="tbl_bottomright"><span class="table_title"><?php echo $TotalPoints;?></span></td>
                       </tr>
                     </table>
                     <?php } ?></td>
      </tr>
	
	   <tr>
        <td>&nbsp;</td>
      </tr>
	
	  <tr>
	   <td>Total Point Of All Judges: <span class="table_title"><?=$TotalPointsOfAllJudges?></span></td>
      </tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
	   <?php if($Comment != ''){?>
	  <tr>
        <td class="table_title">Comment</td>
      </tr>
	   <tr>
        <td ><?php echo $Comment;?></td>
      </tr>
	  <?php } ?>
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="hidden" name="CompetitionICode" value="<?php echo $CompetitionICode;?>" />
            <input type="hidden" name="CompetitionCompetitorICode" value="<?php echo $CompetitionCompetitorICode;?>" />
            <input type="hidden" name="CompetitorICode" value="<?php echo $TitleDetails['CompetitorICode'];?>" />
            <span style = "float:right; width:60px;" class="btn_bx"><input type="button"  value="Close" name="Close" onclick="return backurl();" tabindex="1" /></span>        </td>
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