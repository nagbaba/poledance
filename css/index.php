<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Online Judging System for Pole Dance Competitions</title>
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
</head>

<body>
<div align="center">
<div id="men_bg">
	<div id="head">
    	<div id="head_1">
       	  <div id="head_main">
           	  	<div class="logo"><img src="<?php echo base_url();?>images/logo.jpg" alt="" width="228" height="143" border="0" usemap="#Map2"><map name="Map2"><area shape="circle" coords="91,41,94" href="<?php echo base_url();?>"></map></div>
            	<div class="banner_inner">
                <div class="top_add"><a href="#"><img src="<?php echo base_url();?>images/add.jpg" alt="" width="400" height="73" border="0"></a></div>
           		<!--h3>Online Judging System for Pole Dance & Fitness Competitions</h3><div class="clear"></div></div-->
               <span style="font-size:22px; color:#ffd83d; margin:0px; padding:16px 10px 0px 0px; float:left; font-weight:normal;">Online Judging System for <span style="color:#FFF;font-size:26px;">Pole Dance & Fitness Competitions</span></span> <div class="clear"></div></div>
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
                        <li><p><strong>It is a long:</strong> established fact that a reader will be distracted by the readable content .<br><a href="<?php echo base_url();?>home/aboutus/">Read More ++</a></p></li>
                        </ul>
                  	</li>
                </ul>
           </div>
           <div class="clear"></div>
           <h2>What are you Looking for?</h2>
            <div class="box_pad"><a href="<?php echo base_url();?>home/competitors/">Competitors</a>
            <a href="<?php echo base_url();?>home/competitionresults/">Competition Results</a>
            <a href="<?php echo base_url();?>home/how/">How</a></div>
      	</div>
        <?php echo $this->load->view('rightmenu');?>
      <div class="clear"></div>
        <div class="border"></div>
         <!--- Line end --->
		 <?php if($this->session->userdata('UserType') == '') {?>
       <div class="box_1_b">
       	<?php echo $this->load->view('eventadminlogin');?>
       </div>
        <div class="box_2">
       	  <h1>Welcome to IPDFA</h1>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting...
       		<br><a href="<?php echo base_url().'home/aboutus/'?>" class="read_more">Read More ++</a>
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
    <div id="footer">Copyright 2011 Complete Internet Services Pty Ltd. All Rights Reserved.</div>
</div>
</div>
<div id="forgot_password" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'home/loadforgotPassword/'; ?>" frameBorder="0" width="100%" height="200px;" style="border:none;"></iframe>
</div>
<div id="user_login" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'home/userloginform/'; ?>" frameBorder="0" width="100%" height="280px;" style="border:none;"></iframe>
</div>
</body>
</html>
