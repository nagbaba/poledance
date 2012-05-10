<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Online Judging System for Pole Dance Competitions</title>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css">

<?php if(($this->uri->segment(1) == 'home' && $this->uri->segment(2) == 'register') || 
         ($this->uri->segment(1) == 'home' && $this->uri->segment(2) == 'register_judges') ||
		 ($this->uri->segment(1) == 'competitor' && $this->uri->segment(2) == 'profile') ||
		 ($this->uri->segment(1) == 'judge' && $this->uri->segment(2) == 'profile')){ ?>
<link href="<?php echo base_url(); ?>css/register_stylesheet.css" rel="stylesheet" type="text/css">
<?php }?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.alerts.css">
<link href="<?php echo base_url(); ?>images/favicon.ico" rel="SHORTCUT ICON"/>
<script> 
	var base_url ='http://epolejudge.freistudium.com/'; 
	var phoneRegExp = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
	var mobileRegExp = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
</script>
<script> var base_url ='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.4.3.js"></script>
<script src="<?php echo base_url(); ?>js/menu.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/cufon.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/Century_Gothic_400.font.js"></script>

<script language="JavaScript" src="<?php echo base_url(); ?>js/common_functions.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script> 
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery.alerts.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/event.js"></script>

<!-- lightbox javascript and css -->
<link href="<?php echo base_url(); ?>css/lightbox.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>js/lightbox.js" type="text/javascript"></script>

<script type="text/javascript">
	Cufon.replace ('#main h1')
	Cufon.replace ('#main h2')
	Cufon.replace ('.banner_inner h3')
	Cufon.replace ('.banner_inner h4')
</script>

<?
if(  $this->session->userdata('UserType') == 'J'  ){
?>
		<style>
			#men_bg_inner{
				 width: 1002px;
				 background: none;
			}
			.black_menu_h {
				width: 100%;
				 background: none;
			}
			#men_bg_inner_h {
				 background: none;
				width: 100%;
			}
			#head_1_inner_h {
			 background: none;
			width: 100%;
			}
		</style>
<?
}
?>
</head>
<body>
<div align="center" id="men_bg_inner_h">
<div id="head_1_inner_h">
<div class="black_menu_h">
<div id="men_bg_inner">
	<div id="head_inner" >
	<?php if($this->session->userdata('UserType') == 'J'  ){?>
		<div style="background-color:#7A0C49;">
       	 
			<span style="font-size:22px; color:#ffd83d; margin:0px; padding:16px 10px 0px 0px; float:left; font-weight:normal;"><span style="color:#FFF;font-size:22px;padding-left: 10px;">e - polejudge </span> Online Judging System for <span style="color:#FFF;font-size:22px;">Pole Dance & Fitness Competitions</span></span>
			 <div class="clear"></div>
         <br/>
    </div>
	<?php }else{?>
    	<div id="head_1_inner">
       	  <div id="head_main">
           	  	<div class="logo"><img src="<?php echo base_url();?>images/logo.jpg" alt="" width="228" height="143" border="0" usemap="#Map2"><map name="Map2"><area shape="circle" coords="91,41,94" href="<?php echo base_url();?>"></map></div>
            	<div class="banner_inner">
                <div class="top_add"><a href="#"><img src="<?php echo base_url();?>images/add.gif" alt="" width="400" height="73" border="0"></a></div>
   		    	<span style="font-size:22px; color:#ffd83d; margin:0px; padding:16px 0px 0px 0px; float:right; font-weight:normal;">Online Judging System for <span style="color:#FFF;font-size:26px;">Pole Dance & Fitness Competitions</span></span> <div class="clear"></div></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
	<?php } ?>
    <div class="black_menu" align="center"><?php echo $this->load->view('topmenu');?></div>
    
    <div class="x"><img src="<?php echo base_url();?>images/x.gif" style="padding-left:150px;"><span class="namedisplay"> 
	<?php echo $this->session->userdata('UserName');?></span></div>
    <!--- End Header --->
    <div id="main">
             
        <!--- End Left --->
        <div class="main_right">
       	 <?php echo $contentpane; ?>
        </div>
        <!--- End Right --->
        <div class="clear"></div>
    </div>
    <!--- End Main --->
	</div>
</div>
</div>
</div>
<!-- Footer -->
<div id="footer_h" align="center"><div id="footer">Copyright 2011 Complete Internet Services Pty Ltd. All Rights Reserved.</div></div>
<!-- Footer -->

<div id="forgot_password" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'home/loadforgotPassword/'; ?>" frameBorder="0" width="100%" height="200px;" style="border:none;"></iframe>
</div>

<div id="user_login" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'home/userloginform/'; ?>" frameBorder="0" width="100%" height="280px;" style="border:none;"></iframe>
</div>

</body>
</html>
