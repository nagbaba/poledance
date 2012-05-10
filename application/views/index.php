<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Online Judging System for Pole Dance & Fitness Competitions</title>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.alerts.css">

<script> var base_url ='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.4.3.js"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/common_functions.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery.alerts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/menu.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/cufon.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/Century_Gothic_400.font.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/event.js"></script>

<!-- lightbox javascript and css -->
<link href="<?php echo base_url(); ?>css/lightbox.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>js/lightbox.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>images/favicon.ico" rel="SHORTCUT ICON"/>

<script type="text/javascript">
	Cufon.replace ('#main h1')
	Cufon.replace ('#main h2')
	Cufon.replace ('.banner_inner h3')
	Cufon.replace ('.banner_inner h4')
</script>

<?php if($this->session->flashdata('act_msg') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('You are registered.Please activate your account via the link we sent you on your registered email,Thanks.', 'Pole Dance', '');
});
	
</script>
<?php }?>
<?php if($this->session->flashdata('activated_msg') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('Your account is now active.', 'Pole Dance', '');
});
	
</script>
<?php } ?>
</head>

<body>
<div align="center" id="men_bg_h">
<div id="head_1_h">
<div class="black_menu_h">
<div id="men_bg">
	<div id="head">
    	<div id="head_1">
       	  <div id="head_main">
           	  	<div class="logo"><img src="<?php echo base_url();?>images/logo.jpg" alt="" width="228" height="143" border="0" usemap="#Map2"><map name="Map2"><area shape="circle" coords="91,41,94" href="<?php echo base_url();?>"></map></div>
            	<div class="banner_inner">
                <div class="top_add"><a href="http://www.polefitnessworld.com" target="_blank"><img src="<?php echo base_url();?>images/add.gif" alt="" width="400" height="73" border="0"></a></div>
           		<!--h3>Online Judging System for Pole Dance & Fitness Competitions</h3><div class="clear"></div></div-->
               <span style="font-size:22px; color:#ffd83d; margin:0px; padding:16px 0px 0px 0px; float:right; font-weight:normal;">Online Judging System for <span style="color:#FFF;font-size:26px;">Pole Dance & Fitness Competitions</span></span> <div class="clear"></div></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="black_menu" align="center"><?php echo $this->load->view('topmenu');?></div>
    <div class="x"><img src="<?php echo base_url();?>images/x.gif"></div>
    <!--- End Header --->
    <div id="main">
    	<?php echo $this->load->view('leftmenu');?>
      <div class="box_2">
    <h1>Online Judging System</h1>
            <div class="c-left">
                <ul id="menu">
                    <li>
                        <ul> 
                        <li><p><strong>At long last:</strong> a pole fitness and dance judging system with Competition Management!<br><a href="<?php echo base_url();?>home/aboutus/">Read More ++</a></p></li>
                        </ul>
                  	</li>
                </ul>
           </div>
         <!--  <div class="clear"></div>
           <h2>What are you Looking for?</h2>
            <div class="box_pad"><a href="<?php echo base_url();?>home/competitors/">Competitors</a>
            <a href="<?php echo base_url();?>home/competitionresults/">Competition Results</a>
            <a href="<?php echo base_url();?>home/how/">How</a></div>-->
      	</div>
        <div class="box_3">
            <?php echo $this->load->view('rightmenu');?>
        </div>
      <div class="clear"></div>
        <div class="border"></div>
         <!--- Line end --->
		 <?php if($this->session->userdata('UserType') == '') {?>
       <div class="box_1_b">
       	<?php echo $this->load->view('eventadminlogin');?>
       </div>
        <div class="box_2">
       	 <!-- <h1>Welcome to IPDFA and e-polejudge </h1>
          After the IPC Competition in Tokyo 2010 it became evident that competition judging could be done more efficiantly and quickly if it was computerised, thus e-pole judge is now born. 
       	  <br><a href="<?php echo base_url().'home/aboutus/'?>" class="read_more">Read More ++</a>-->
		  <?php echo $this->load->view('competitorlogin');?>
        </div>
        <div class="box_3">
       	 <?php echo $this->load->view('judgeslogin');?>
        </div>
        <div class="clear"></div>
        <div class="border"></div>
		<?php } else {?>
        <div style="height:200px;">&nbsp;</div>
        <?php } ?>
        <div align="center"><!--img src="<?php echo base_url();?>images/twitter.jpg" alt="" width="231" height="49" border="0" usemap="#Map"-->
        <map name="Map">
          <area shape="circle" coords="96,18,16" href="#"><area shape="circle" coords="140,18,16" href="#">
        </map></div>
        <!--- 2nd tab end --->
    </div>
    <!--- End Main --->
</div>
</div>
</div>
</div>
<!-- Footer -->
<div id="footer_h" align="center"><div id="footer">Copyright 2011 <a href="http://www.completeinternet.com.au">Complete Internet Services Pty Ltd.</a> All Rights Reserved.</div></div>
<!-- Footer -->
<div id="forgot_password" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'home/loadforgotPassword/'; ?>" frameBorder="0" width="100%" height="200px;" style="border:none;"></iframe>
</div>
<div id="user_login" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'home/userloginform/'; ?>" frameBorder="0" width="100%" height="280px;" style="border:none;"></iframe>
</div>
</body>
</html>