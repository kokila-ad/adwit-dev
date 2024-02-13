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
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#channel').change(function(e) {
            window.location = "<?php echo base_url().index_page().'art-director/home/live_ads/';?>" + $('#channel').val() ;
        });
    });
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'art-director/home/live_ads_pending_';?>" + $('#display_type').val();
        });
    });
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#publication').change(function(e) {
            window.location = "<?php echo base_url().index_page().'art-director/home/live_ads/';?>"  + $('#channel').val()+'/'+$('#publication').val();
        });
    });
</script>
  <div id="Middle-Div">
  <div style="padding-left: 30px; padding-top: 20px;">
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
												<div style="padding-bottom: 20px;">
<div style="float: right;">
                            <div style="float: right;">
							<select id="display_type" name="display_type" style="width:80px; height:20px;" >
            
        	<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?>>Pending</option>
			<option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
            </select>
							</div>&nbsp&nbsp&nbsp&nbsp
                            
							<div style="float: right;">
                               <div style="padding-bottom: 20px; margin-right:20px;">
											
							Filter Channels:&nbsp;
								<select id="channel" name="channel" style="width:80px; height:20px;" >
								<option value="">All</option>
								
								<?php
			$types = $this->db->get_where('channels')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($channel==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
								</select>
							 
							</div></div>
                            </div></div>
							<div class="block">
                            <div class="navbar navbar-inner block-header">	
								       <div style="float:right">
											<?php if(!empty($channel))
							{ ?>
							Filter Publication:&nbsp;
								<select id="publication" name="publication" style="width:80px; height:20px;" >
								<option value="">All</option>
								
								<?php
		$types = $this->db->get_where('publications',array('channel' => $channel))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($publication==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
								</select>
							 <?php }  ?>
							</div>
                            </div>
                            <div class="block-content collapse in">
						
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
										<thead>
											<tr>
											    <th>Date</th>
												<th>Adwit_Ads_Id</th>
												<th>Unique_Job_Id</th>
												<th>Publication</th>
												<th>Design</th>
												<th>QA</th>
												<th>Uploaded</th>
												<th>view</th>
                                               
											</tr>
										</thead>
									<tbody>
<?php
$i=1;
foreach($result as $row)
{	
	$publication = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array(); 
	$QA = $this->db->get_where('cp_tool',array('cat_result_id' => $row['id']))->result_array(); 
	
	?>    									
											<tr class="odd gradeX">
											    <td><?php echo $row['date']  ?></td>
												<td><?php echo $row['order_no']; ?></td>
												<td><?php echo $row['job_name'] ?></td>
												<td><?php echo $publication[0]['name'] ?></td>
												<td><?php if(($row['slug']=='none')) { echo "Pending";} else { echo "Completed"; }  ?></td>
												<td><?php if($QA){echo "Done";} else{ echo "pending";  } ?></td>
												<?php  if(($row['pdf_path']=='none')) { ?>
                                                <td><?php  echo "Pending";   ?></td>											
											<?php }	else { ?>
											  <td><a href="http://www.adwitads.com/weborders/<?php echo $row['pdf_path']?>" target="_blank"><img src="images/sample-image.jpg"  />Sent</a></td>		
											<?php } ?>
											<td> <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'art-director/home/live_ads_view/'.$row['order_no'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/order_view.png" alt="view"/></a> </td>
												
												
											</tr>
<?php }?>											
										</tbody>
									</table>
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
