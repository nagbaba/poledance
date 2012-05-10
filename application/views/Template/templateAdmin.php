<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<link href="<?php echo base_url(); ?>css/master_stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.alerts.css">

<script> 
	var base_url ='<?php echo base_url();?>'; 
	var phoneRegExp = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
	var mobileRegExp = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
</script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery-1.4.3.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/superfish.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/common_functions.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery.alerts.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/home.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script> 
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="head_inner2"><div class="logo"><img src="<?php echo base_url();?>images/logo.jpg" alt="" width="175" height="100" border="0" usemap="#Map2"><map name="Map2"><area shape="circle" coords="91,41,94" href="<?php if($this->session->userdata('UserType') == 'MA'){echo base_url().'admin/home/homepage/';}else{echo base_url().'admin/home/eventadminhomepage/';}?>"></map></div>
		<div style="font-size:22px; color:#ffd83d; margin:0px; padding:58px 10px 0px 24px; float:left; font-weight:normal;">Online Judging System for</div><div style="font-size:26px; color:#ffffff; margin:0px; padding:54px 0px 0px 0px; float:left; font-weight:normal;">Pole Dance & Fitness Competitions</div><div class="clear"></div></div></td>
  </tr>
  <tr>
    <td><table width="100%" height="34" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="menu">
                <ul class="nav left sf-js-enabled" style="display: block;">
                    <li class="selected sfHover" id="dashboard"><a href="<?php if($this->session->userdata('UserType') == 'MA'){echo base_url().'admin/home/homepage/';}else{echo base_url().'admin/home/eventadminhomepage/';}?>" class="top">Home</a></li>
					
					<!-- start of master admin menus --> 
					<?php if($this->session->userdata('UserType') == 'MA'){ ?>
					 <li class="" id="extension"><a class="top">Settings</a>
                         <ul style="display: none; visibility: hidden;">
						 	<li><a href="<?php echo base_url();?>admin/home/changemyprofile/">My Profile</a></li>
							<li><a href="<?php echo base_url();?>admin/home/changepassword/">Change Password</a></li>
                         </ul>
                    </li>
                   
                    <li class="selected sfHover" id="dashboard"><a href="<?php echo base_url();?>admin/user/manageeventadmin/" class="top">Event Administrators</a></li>
					
					<?php } ?>
					 <!-- end of master admin menus -->
					<!-- start of event admin menus --> 
					<?php if($this->session->userdata('UserType') == 'E'){ ?>
					
					<li class="" id="extension"><a class="top">My Account</a>
                         <ul style="display: none; visibility: hidden;">
						 	<li><a href="<?php echo base_url();?>admin/home/changeeventadminprofile/">My Profile</a></li>
							<li><a href="<?php echo base_url();?>admin/home/changepassword/">Change Password</a></li>
                         </ul>
                    </li>
					
					 <li class="" id="extension"><a class="top">Settings</a>
                         <ul style="display: none; visibility: hidden;">
							<li><a href="<?php echo base_url();?>admin/user/sectionmanagement/">Section Management</a></li>
						 	<li><a href="<?php echo base_url();?>admin/user/managedivision/">Division Management</a></li>
							<li><a href="<?php echo base_url();?>admin/user/managejudges/">Judges Management</a></li>
							<li><a href="<?php echo base_url();?>admin/user/managecompetitor/">Competitor Management</a></li>
							<li><a href="<?php echo base_url();?>admin/user/managecompetition/">Competition Management</a></li>
							<li><a href="<?php echo base_url();?>admin/result/managecompetitionresult/">Result Configuration</a></li>
							<li><a href="<?php echo base_url();?>admin/user/managestartcompetition/">Start Competition</a></li>
							<li><a href="<?php echo base_url();?>admin/user/manageendcompetition/">End Competition</a></li>
                         </ul>
                    </li>
					
					<!--li class="selected sfHover" id="dashboard"><a href="#" class="top">Results</a></li-->
                   <?php } ?>
				   <!-- end of event admin menus -->
                 </ul>
                 
                <ul style="display: block;" class="nav right sf-js-enabled">
                      <ul style="display: none; visibility: hidden;"></ul>
                    </li>
                    <li id="store"><a class="top" href="<?php if($this->session->userdata('UserType') == 'MA'){echo base_url().'admin/home/logout/';}else{echo base_url().'admin/home/evenadminlogout/';}?>">Logout</a></li>
                </ul>
                
  <script type="text/javascript"><!--
$(document).ready(function() {
	$('.nav').superfish({
		hoverClass	 : 'sfHover',
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false, 
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});
	
	$('.nav').css('display', 'block');
});
//--></script>
  <script type="text/javascript"><!-- 
function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';
	
	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');
				
				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}
	
	return urlVarValue;
} 

$(document).ready(function() {
	route = getURLVar('route');
	
	if (!route) {
		$('#dashboard').addClass('selected');
	} else {
		part = route.split('/');
		
		url = part[0];
		
		if (part[1]) {
			url += '/' + part[1];
		}
		
		$('a[href*=\'' + url + '\']').parents('li[id]').addClass('selected');
	}
});
//--></script>
</div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" background="<?php echo base_url(); ?>images/background.png">&nbsp;</td>
  </tr>
  <tr>
    <td height="15">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<!--Content Pane Starts Here-->
					
					<?php echo $contentpane; ?>
					
					  <!--Content Pane Ends Here-->
	
	
	</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td background="<?php echo base_url(); ?>images/background.png">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><?php echo $footerpane; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
