<div class="black_menu_t">
<ul id="menu_u">
	<li><a href="<?php echo base_url();?>">Home</a></li>
	<li><a href="<?php echo base_url();?>home/aboutus/">About us</a></li>
	
	<?php if($this->session->userdata('UserType') == 'J'){?>
    <li><a href="<?php echo base_url();?>home/contactus/">Contact us</a></li>
	<?php if($this->session->userdata('IsJudgeHead') == 1) {?>
		<li><a href="<?php echo base_url();?>competition/alljudges/">Judges</a></li> 
	<?php } ?>
		<li ><a href="<?php echo base_url().'competition/startedcompetitionlist';?>">Competitions</a></li>
		<li><a href="<?php echo base_url().'judge/profile';?>">Profile</a></li>
		<li style="border-right:none;"><a href="<?php echo base_url().'judge/my_competition';?>">My Competitions</a></li>
	<?php } else{ ?>
		<li style="border-right:none;"><a href="<?php echo base_url();?>home/contactus/">Contact us</a></li>
		<?php if($this->session->userdata('UserType') == 'C'){?>
			<li style="border-right:none; border-left: 1px solid #333333;"><a href="<?php echo base_url().'competitor/apply';?>">Apply</a></li>
		<?php } ?>
    <?php } ?>
	<?php if($this->session->userdata('LoginUserICode') == ''){?>
    <li style="float:right; border-right:none;"><a href="#?w=600" rel="user_login" class="poplight" >Login</a></li>
	<li style="float:right; border-right:none;"><a href="<?php echo base_url();?>home/register">Register</a></li>
	<?php }?>
	<?php if($this->session->userdata('LoginUserICode')){?><li style="float:right;border-right:none;"><a href="<?php echo base_url();?>home/logout/">Logout</a></li><?php }?>
</ul>
</div>