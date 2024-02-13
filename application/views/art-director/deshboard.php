<?php
       $this->load->view("art-director/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});
	
	
	
</script>

  <div id="Middle-Div">
  <div style="padding-left: 30px; padding-top: 20px;">
		
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">  
							<?php	 $team_lead1 = $this->db->get_where('team_lead',array('Join_location' => '1','is_active'=>'1'))->result_array();
                                     $team_lead2 = $this->db->get_where('team_lead',array('Join_location' => '2','is_active'=>'1'))->result_array();  
                                     $team_lead3 = $this->db->get_where('team_lead',array('Join_location' => '3','is_active'=>'1'))->result_array();  
                                     $team_lead4 = $this->db->get_where('team_lead',array('Join_location' => '4','is_active'=>'1'))->result_array();  
                                     $team_lead5 = $this->db->get_where('team_lead',array('Join_location' => '5','is_active'=>'1'))->result_array();  
									 $designers1 = $this->db->get_where('designers',array('Join_location' => '1', 'is_active'=>'1'))->result_array();
                                     $designers2 = $this->db->get_where('designers',array('Join_location' => '2', 'is_active'=>'1'))->result_array(); 
                                     $designers3 = $this->db->get_where('designers',array('Join_location' => '3', 'is_active'=>'1'))->result_array(); 
                                     $designers4 = $this->db->get_where('designers',array('Join_location' => '4', 'is_active'=>'1'))->result_array(); 
                                     $designers5 = $this->db->get_where('designers',array('Join_location' => '5', 'is_active'=>'1'))->result_array();	
                                     $Total1=count($team_lead1)+count($team_lead2)+count($team_lead3)+count($team_lead4)+count($team_lead5)+count($designers1)+count($designers2)+count($designers3)+count($designers4)+count($designers5);
																		 
							?>
							<b>All Active Users Counts-<?php  echo $Total1; ?></b>
							
							  </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
										<thead>
											<tr>
											    <th>Locations</th>	
												<td>Bangalore</td>
												<td>Dharwad</td>
												<td>Chamarajanagar</td>
												<td>Udupi</td>
												<td>Mysore</td>
												<td>Total</td>
			
			</tr></thead><tbody>
						<tr>
											    <th><a href="<?php echo base_url().index_page().'art-director/home/new_designer';?>">Designers</a></th>								 <?php
	 $designers1 = $this->db->get_where('designers',array('Join_location' => '1', 'is_active'=>'1'))->result_array(); 
					echo  '<td>'.  count($designers1).'</td>';	
	 $designers2 = $this->db->get_where('designers',array('Join_location' => '2', 'is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($designers2).'</td>';	
	 $designers3 = $this->db->get_where('designers',array('Join_location' => '3', 'is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($designers3).'</td>';
     $designers4 = $this->db->get_where('designers',array('Join_location' => '4', 'is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($designers4).'</td>';	
     $designers5 = $this->db->get_where('designers',array('Join_location' => '5', 'is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($designers5).'</td>';	
	 $Total=count($designers1)+count($designers2)+count($designers3)+count($designers4)+count($designers5);
			echo '<td> ' .$Total . '</td>';			
			?>       </tr>					
								<tr>
						                        <th><a href="<?php echo base_url().index_page().'art-director/home/new_teams';?>">Team Lead</a></th>								 <?php
	 $team_lead1 = $this->db->get_where('team_lead',array('Join_location' => '1','is_active'=>'1'))->result_array(); 
					echo  '<td>'.  count($team_lead1).'</td>';	
	 $team_lead2 = $this->db->get_where('team_lead',array('Join_location' => '2','is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($team_lead2).'</td>';	
	 $team_lead3 = $this->db->get_where('team_lead',array('Join_location' => '3','is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($team_lead3).'</td>';
     $team_lead4 = $this->db->get_where('team_lead',array('Join_location' => '4','is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($team_lead4).'</td>';	
     $team_lead5 = $this->db->get_where('team_lead',array('Join_location' => '5','is_active'=>'1'))->result_array(); 				
			echo  '<td>'.  count($team_lead5).'</td>';	
			$Total1=count($team_lead1)+count($team_lead2)+count($team_lead3)+count($team_lead4)+count($team_lead5);
			echo '<td>'.$Total1.' </td>';
									
					?></tr>	</tbody></table>
               </div>
                  </div></div></div>                              			
									
		
										
		 <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"> 
								<b>All Adtypes volueme</b>
							  </div> </div>     
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
			<thead>
											<tr>
		                                        <td><a href="<?php echo base_url().index_page().'art-director/home/live_ads/1';?>">Metro</a></td>
												<td><a href="<?php echo base_url().index_page().'art-director/home/live_ads/2';?>">TS</td>
												<td><a href="<?php echo base_url().index_page().'art-director/home/live_ads/3';?>">Softwrite</td>
												<td><a href="<?php echo base_url().index_page().'art-director/home/live_ads/4';?>">Canada</td>
												<td>Total</td>
			                                </tr>
			</thead><tbody>
						<tr>
									       <?php ;
		                                          echo'<td>'.count($metro).'</td>';
		                                          echo'<td>'.count($TS).'</td>';
		                                          echo'<td>'.count($Softwrite).'</td>';
		                                          echo'<td>'.count($Canada).'</td>';
					                              $Total=count($metro)+count($TS)+count($Softwrite)+count($Canada);
		                                          echo'<td>'.$Total.'</td>';
			                               ?> 
			            </tr>			</tbody></table></div> </div></div> </div>
						
           <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"> 
	                     <b>Today Adds Status Pending</b>
							  </div> </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
											<tr>
											    <th></th>
		                                        <td>Design</td>
												<td>QA</td>
												<td>Upload</td>
												<td>Completed</td>
			                                </tr>
			                     </thead><tbody>
					<tr>
											    <th>Metro</th>	<?php
											
									            echo  '<td>'.  count($metro_pending).'</td>';	
												echo'<td></td>';
											    echo'<td></td>';
												echo'<td></td>';
					?></tr>				
			        <tr>
											    <th>Softwrite</th>								 <?php
											
		                                        echo  '<td>'.  count($softwrite_pending).'</td>';	
		                                        echo'<td></td>';
		                                        echo'<td></td>';
		                                        echo'<td></td>';
			        ?></tr>				
																					
			         <tr>
											    <th>TS</th>								 <?php
											
		                                        echo  '<td>'.  count($TS_pending).'</td>';	
		                                        echo'<td></td>';
		                                        echo'<td></td>';
		                                        echo'<td></td>';
			        ?></tr>			
					
		             <tr>
											    <th>Canada</th>								 <?php
											
		                                       echo  '<td>'.  count($canada_pending).'</td>';	
		                                       echo'<td></td>';
		                                       echo'<td></td>';
		                                       echo'<td></td>';
			       ?></tr>					
						</tbody></table>
						</div>
                         </div>
                        </div>
                        </div>
  </div>
  
    <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>
                       
<?php
       $this->load->view("art-director/footer");
?>










