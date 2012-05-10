<script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.pagination.js"></script>
<script>
        var members = [
					   <?php	if(!empty($Completedcommpetitiondetails)){  
		   						$Count = count($Completedcommpetitiondetails); $z=1;
								foreach($Completedcommpetitiondetails as $val) {
								
								//else{ 
								
									if(($z == $Count) || ( $Count == 1) )
									{
						?>
						['<a href="<?php echo base_url().'competition/viewresultrank/'.$val['CompetitionICode'].'/'?>"><?php echo ucwords($val['CompetitionName']).'<br><br>';?></a>']
						
						<?php		} 
									else if($z == 1)
									{
						?>
						['<a href="<?php echo base_url().'competition/viewresultrank/'.$val['CompetitionICode'].'/'?>"><?php echo ucwords($val['CompetitionName']).'<br><br>';?></a>'],
						<?php		}
									else
									{ ?>
						['<a href="<?php echo base_url().'competition/viewresultrank/'.$val['CompetitionICode'].'/'?>"><?php echo ucwords($val['CompetitionName']).'<br><br>';?></a>'],				
						<?php 		}	
								//}
					   
					   $z++; }} else{ ?>
					   ['<?php echo 'No Records'.'<br><br>';?>']
					   <?php } ?>
					   ];
 </script>
<script type="text/javascript">
            
			function pageselectCallback(page_index, jq){
                // Get number of elements per pagionation page from form
                var items_per_page = 5;//$('#items_per_page').val();
                var max_elem = Math.min((page_index+1) * items_per_page, members.length);
                var newcontent = '';
                
                // Iterate through a selection of the content and build an HTML string
                for(var i=page_index*items_per_page;i<max_elem;i++)
                {
                    newcontent += '<dt>' + members[i][0] + '</dt>';
                }
                
                // Replace old content with new content
                $('#Searchresult').html(newcontent);
                
                // Prevent click eventpropagation
                return false;
            }
            
            function getOptionsFromForm(){
                var opt = {callback: pageselectCallback};
                // Collect options from the text fields - the fields are named like their option counterparts
                $("input:hidden").each(function(){
                    opt[this.name] = this.className.match(/numeric/) ? parseInt(this.value) : this.value;
                });
                // Avoid html injections in this demo
                var htmlspecialchars ={ "&":"&amp;", "<":"&lt;", ">":"&gt;", '"':"&quot;"}
                $.each(htmlspecialchars, function(k,v){
                    opt.prev_text = opt.prev_text.replace(k,v);
                    opt.next_text = opt.next_text.replace(k,v);
                })
                return opt;
            }
			
            // When document has loaded, initialize pagination and form 
            $(document).ready(function(){
				// Create pagination element with options from form
                var optInit = getOptionsFromForm();
                $("#Pagination").pagination(members.length, optInit);
                
				// Event Handler for for button
				$("#setoptions").click(function(){
                    var opt = getOptionsFromForm();
                    // Re-create pagination content with new parameters
                    $("#Pagination").pagination(members.length, opt);
                }); 

            });
            
        </script>
      
       
        	
<div class="left_b">
  <div class="box_1">
    <h1>Competitions Results</h1>
    <div class="st">
    <div class="st_lft">
      <div id="Searchresult" >
      	<input type="hidden" value="5" name="items_per_page" id="items_per_page" class="numeric"/>
		<input type="hidden" value="4" name="num_display_entries" id="num_display_entries" class="numeric"/>
		<input type="hidden" value="0" name="num_edge_entries" id="num_edge_entries" class="numeric"/>
		<input type="hidden" value="Prev" name="prev_text" id="prev_text"/>
		<input type="hidden" value="Next" name="next_text" id="next_text"/>
		</div>
        <br />
         <div id="Pagination" class="pagination"></div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>

