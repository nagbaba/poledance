<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<script type="text/javascript" > 
    function refreshpage()
    {
        window.location.href = base_url+'competition/startedcompetitionlist/';
    }

    //Post Message
    function PostMessage(competitoncompetitorIcode)
    {
        window.location.href = base_url+'competition/PostResult/'+competitoncompetitorIcode+'/';
    }
	
	//view result page
	function ViewResult(competitoncompetitorIcode)
	{
		window.location.href =	base_url+'competition/viewresultpage/'+competitoncompetitorIcode+'/'; 
	}
</script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
    <td>
   	  <div class="box">
        <div style="float:right;">  <a  onclick="return refreshpage();" style="cursor:pointer;"><img src="<?php echo base_url();?>images/refresh.png" alt="Refresh" width="32" height="32" title="Refresh" /> Refresh</a></div>
        <div class="heading"><h1 style="color:#AD2E76;">Started Competitions</h1></div>
        <div>&nbsp;</div>
        <table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
        	<td><table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="80%">
	<thead>
		<tr>
			<th width="44%" height="32" align="left">Competition Name</th>
			<th width="41%" align="left">Competition Date			  </th>
			<td width="15%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($CompetitionDetails)){ foreach($CompetitionDetails as $row){ ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['CompetitionName']), 25);?></td>
            <td class="left"><?php echo getDateDisplay($row['CompetitionDate']);?></td>
            <td class="center" id="ActionICon<?php echo $row['CompetitionICode']; ?>" align="center"><a href="<?php echo base_url();?>competition/competitionresultpost/<?php echo $row['CompetitionICode']; ?>/" class="tlink">View</a></td>
		</tr>
		<?php }} ?>
	</tbody>
</table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        </table>
        
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
			"aoColumns": [ null, { "sType": "uk_date" } ]
	});
});
</script>