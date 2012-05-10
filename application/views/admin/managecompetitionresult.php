<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<link href="<?php echo base_url(); ?>css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/facebox.js" type="text/javascript"></script>

<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Manage   Results Configuration </h1>
  </div>
  
  <div style="float:right; padding-top:10px; padding-right:200px;"><a href="<?php echo base_url();?>admin/result/addresultconfiguration/"  style="color:black; font-weight:bold; text-decoration: none; padding-left: 8px;"><img src="<?php echo base_url();?>images/add.png" width="32" height="32" border="0"  alt="Add Result Configuration" title="Add Result Configuration" style="cursor:pointer;"/>&nbsp;Add Result Configuration</a></div>
 
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;"><table width="75%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="38%" height="32" align="left">Division Name</th>
			<th width="29%" align="left">Championship Name</th>
			<th width="17%" align="left">Created Date</th>
			<td width="16%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(!empty($CompetitionDetails)){
			foreach($CompetitionDetails as $row){
			$SingleWhere = "DivisionICode = '".$row['DivisionICode']."'";
			$DivisionName  = $this->home->getSingleFieldValue('division_master', 'DivisionName', $SingleWhere);
			
			$SingleWhere = "ChampionshipICode = '".$row['ChampionshipICode']."'";
			$ChampionshipName  = $this->home->getSingleFieldValue('championship', 'ChampionshipName', $SingleWhere);
			
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($DivisionName), 20);?></td>
                        <td class="left"><?php echo getMaxFieldLength(ucwords($ChampionshipName), 20);?></td>
                        <td class="left"><?php echo getDateDisplay($row['CreatedDate']);?></td>
                          <td class="center"><a href="<?php echo base_url();?>admin/result/editresultconfiguration/<?php echo $row['ChampionshipICode'];?>/<?php echo $row['DivisionICode'];?>/"><img src="<?php echo base_url();?>images/edit.png" border="0" width="16" height="16" alt="Edit" title="Edit" style="cursor:pointer;"/></a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete User" title="Delete User" style="cursor:pointer;" onclick="deleteConfigResult('<?php echo $row['ChampionshipICode'];?>', '<?php echo $row['DivisionICode'];?>');"/></td>
		</tr>
		<?php }} //ChampionshipICode, DivisionICode ?>
	</tbody>
</table></td>
  </tr>
</table></div>
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
			"aoColumns": [ null, null, null,  { "sType": "uk_date" } ]
	});
});
</script>