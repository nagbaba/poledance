    <table width="98%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><div class="box">
            <!--div style="float:right;"><a onclick="return backurl();" style="cursor:pointer;" title="Go Back"><img src="<?php echo base_url(); ?>images/back.png" alt="Go Back" title="Go Back"/> Back</a></div-->
                <div class="heading">
                    <h1 style="color:#AD2E76;">Competition Champion</h1>
                </div>
                <div>&nbsp;</div>
                <div class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #999;">
  <tr>
    <td><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td class="table_result">&nbsp;</td>
                </tr>
                <tr>
                  <td class="table_result" align="center"> <?php echo $CompetitionName;?></td>
                </tr>
                <tr><td class="table_result">&nbsp;</td></tr>
                
                <?php if(!empty($Divisions)){ foreach($Divisions as $v){
					$SingleWhere = "DivisionICode = '".$v['DivisionICode']."'";
					$DivsionName = $this->home->getSingleFieldValue('division_master', 'DivisionName', $SingleWhere);
				?>
  <tr>
    <td class="title">Division Name : <span class="pagetitle"><?php echo $DivsionName;?></span></td>
  </tr>
  <tr>
    <td>
    <table width="80%" border="0" cellspacing="0" cellpadding="0" align="right">
   <?php if(!empty($Championshipdetails)){ foreach($Championshipdetails as $b){
   		 $ChampionshipICode = $b;
   		 $ChampionshipName = getChampionShipName($ChampionshipICode);	
		 
		 $CompetitionCompetitorICode = $this->Mcompetition->getCompetitionCompetitorICodeForThisCompetitionChanmpion($CompetitionICode, $ChampionshipICode, $v['DivisionICode']);
		 
		 if(!empty($CompetitionCompetitorICode))
		 {
		 	$CompetitionCompetitorICode = implode(',', $CompetitionCompetitorICode);
			
			$CompetitorsName = $this->Mcompetition->getCompetitionChampionName($CompetitionCompetitorICode);
		 }
		 else
		 {
		 	$CompetitorsName = '';
		 }
		 //exit;
		 
		 
	     //$MaxScore = $this->Mcompetition->getMaxScoreInParticularCompetition($CompetitionICode, $b, $v['DivisionICode']);
		 //$CompetitorName = $this->Mcompetition->getMaxSecuredCompetitorName($MaxScore);
	?>
    
  <tr>
    <td width="19%" height="35" class="pagesubtitle"><?php echo $ChampionshipName;?></td>
    <td width="3%" class="pagesubtitle">:</td>
    <td width="78%" class="title"><?php if(!empty($CompetitorsName)){echo $CompetitorsName;} else{echo '--';}; ?></td>
    </tr>
  <?php }} ?>
</table>
</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
  <?php  } }?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>

</div>
                </div>

                   </td>
        </tr> 
    </table>

