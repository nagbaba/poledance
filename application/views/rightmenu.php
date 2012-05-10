<div class="box_3">
       	  <h1>Upcomming Competitions</h1>
	      <div class="st">
            	<div class="st_lft">
                 <?php 	if(!empty($Upcomingcommpetitiondetails)){  
		   					foreach($Upcomingcommpetitiondetails as $val) {  ?> 
			    	 			<div class="s_txt"><a href="<?php echo base_url().'competition/viewcompetitiondetails/'.$val['CompetitionICode'].'/';?>" class="s_link"><?php echo ucwords($val['CompetitionName']); ?></a></div>
                 <?php }} else { ?>
                 		<div class="s_txt"><a href="#" class="s_link"><?php echo 'Not Available'; ?></a></div>
                 <?php }?>    
                </div> 
                <div class="clear"></div> 
          	</div>
           <!--- box end --->
        </div>