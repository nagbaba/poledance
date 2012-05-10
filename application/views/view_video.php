
<script> var base_url ='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common_functions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/event.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/flowplayer-3.2.8.min.js"></script>
<script type="text/javascript">
function backtoprofile()
{

    window.location = "<?php echo base_url().'competitor/profile';?>";
}
</script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
 
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<table width="100%" border="0">
<tr>
<td align="center">
<a href="<?php echo base_url(); ?>uploads/videos/<?php echo $CompetitorDetails['video'];?>" style="display:block;width:590px;height:400px;" id="player"> 
			</a>
	 
	 </td>  
	 </tr>
	 <tr><td>&nbsp;</td></tr>
	 <tr>
<td align="center" style="padding-left:400px;">
<span class="btn_bx"><input style="width:19%; text-align:center;" type="button" name="back" id="back" value="My Profile" onClick="return backtoprofile();" tabindex="14"></span> 
			
	 
	 </td>  
	 </tr>
</table>
<script type="text/javascript">
		$(document).ready(function() {
			flowplayer("player", "<?php echo base_url(); ?>js/flowplayer-3.2.9.swf");
			});
		</script>

</div>
    </div>
  </div>
</div></td>
      </tr>
    </table>
	
