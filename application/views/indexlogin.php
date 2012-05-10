<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<script type="text/javascript" > 

function adminlogin(value)
{
//alert('hi');
//alert(value);
 var dataurl = base_url +'home/loadlogin/';
       $.ajax({
		  	type:"POST",
				url: dataurl,
				data:{"value":value},
				success:function(msg)
				{
				if(msg == 'adminlogin')
				{
				
				
				window.location.href =  base_url +'home/adminlogin/';
				}
				else
				{
				window.location.href =  base_url +'home/judgelogin/';
				}
           }
		 });
}

</script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
    <td><div class="box">
            <div class="left"></div>
            <div class="right"></div>
            <div class="heading">
                <h1 style="color:#AD2E76;">Select Your Login </h1>
            </div>
            <div class="content">
                    <div style="background-color:#FFFFFF; border: 1px solid  #E8E8E8; width:60%; padding-bottom:100px;">
                <table align="center">
			            <th>        <input type="checkbox" name="option1" value="adminlogin"  onclick="return adminlogin('adminlogin');"> Event Admin Login
                        <input type="checkbox" name="option2" value="judgelogin" onclick="return adminlogin('judgeslogin');"> Judges Login </th>
                
				</table>
				  </div>
        </div></td>
</tr> 
</table>

