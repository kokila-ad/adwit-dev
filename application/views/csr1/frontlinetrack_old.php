<?php
	$this->load->view("csr/header");
?>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<!--<meta http-equiv="refresh" content="30" >-->
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/frontlinetrack_all/';?>" + $('#help_desk').val() ;
        });
    });
</script>

<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'csr/home/frontlinetrack_';?>" + $('#display_type').val() + "<?php echo '/'.$form; ?>" ;
        });
    });
</script>

<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/New_York');
				}
				$current_time = date("H:i:s"); 
		?>
    }
</script>

        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<div id="Middle-Div">

<p style="text-align:center;"> 
        	Select Your Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('help_desk')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
        </p>

<?php if(isset($form)):?>
<div class="row-fluid" style="width:96%; margin: 0 auto;">
<div style="padding-bottom: 20px;">
<div style="float: left;"><form method="post">
								<input type="submit" name="date" value="<?php echo $pystday; ?>" /> 
								<input type="submit" name="date" value="<?php echo $ystday; ?>" /> 
								<input type="submit" name="date" value="<?php echo $today; ?>" /> 
							</form></div>
                            <div style="float: right;">
							<select id="display_type" name="display_type" style="width:80px; height:20px;" >
            <option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
        	<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
            </select>
							<?php echo "".$current_time ; ?><a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img src="images/refresh_trackingsheet.png"/></a></div>
                            </div>
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Frontline Tracking - <?php if(isset($date)){ echo $date; }else{ echo $today;} ?>
								</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
											  <th rowspan="2" style="vertical-align: middle;">No.</th>
												<th rowspan="2" style="vertical-align: middle;">Job No.</th>
												<th colspan="5" style="text-align: center;">Time Stamp</th>
												<th rowspan="2"style="vertical-align: middle;">Time Left</th>
												<th rowspan="2"style="vertical-align: middle;">	Time Sent</th>
												<th rowspan="2"style="vertical-align: middle;">Time Taken</th>
												<!--<th rowspan="2"style="vertical-align: middle;">Action</th>-->
												
												<th rowspan="2"style="vertical-align: middle;">Remarks/<br/>Remove</th>
												
											</tr>
                                            <tr>
                                              <th>New&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                              <th>Pickup&nbsp;&nbsp;</th>
                                              <th>Revision</th>
                                              <th>Fasttrack</th>
                                              <th>Sold&nbsp;&nbsp;&nbsp;&nbsp;</th>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">	
<?php
$count = '0'; $cat_time = '0'; $timer = '0';
	$hd_name = $this->db->get_where('help_desk',array('id' => $form))->result_array();
	
	if($display_type=='pending')
	{
		if(isset($date)){
			$this->db->order_by("id", "asc");
			$jobs = $this->db->get_where('rev_sold_jobs',array('help_desk' => $form, 'date'=> $date, 'sent_time'=> '00:00:00', 'job_status'=>'1'))->result_array();
			//$count = count($jobs)+1;
		}else{
			$this->db->order_by("id", "asc");
			$jobs = $this->db->get_where('rev_sold_jobs',array('help_desk' => $form, 'date'=> $today, 'sent_time'=> '00:00:00', 'job_status'=>'1'))->result_array();
			//$count = count($jobs)+1;
		}
	}

	if($display_type=='all')
	{
		if(isset($date)){
			$this->db->order_by("id", "asc");
			$jobs = $this->db->get_where('rev_sold_jobs',array('help_desk' => $form, 'date'=> $date))->result_array();
			 
		}else{
			$this->db->order_by("id", "asc");
			$jobs = $this->db->get_where('rev_sold_jobs',array('help_desk' => $form, 'date'=> $today))->result_array();
			
		}
	}
	
	foreach($jobs as $row){
		$count--; 
		$time_left = '0';
		//$count = sprintf('%03d',$count);
		$start = strtotime($row['time']);
		$end = strtotime($current_time);
		$time_left = $end - $start ;
		$time_left = $time_left / 60;
		$time_left_rnd = round($time_left,0);
		$frontline_timer = $this->db->get('frontline_timer')->result_array();
		foreach($frontline_timer as $row1){
			if($row['category'] == $row1['cat_name'])
			{ $cat_time = $row1['duration']; }
		}
?>										
											<tr class="odd gradeX">
											  <td><?php echo $count ; ?></td>
												<td><?php echo $row['order_no']; ?></td>
												<td><?php if($row['category']=='new'){ echo $row['time'];} ?></td>
												<td><?php if($row['category']=='pickup'){ echo $row['time'];} ?></td>
												<td><?php if($row['category']=='revision'){ echo $row['time'];} ?></td>
												<td><?php if($row['category']=='fastrack'){ echo $row['time'];} ?></td>
												<td><?php if($row['category']=='sold'){ echo $row['time'];} ?></td>
                                                <td><?php if($time_left < $cat_time && $row['sent_time']=='00:00:00')
														 { 
															$timer = $cat_time - $time_left ; 
															if($timer<= '5'){
																echo "<font color='red'>". round($timer,0)." min </font>";
															}else{ echo round($timer,0)." mins"; }
														 }else{echo "Elapsed"; } 
														 ?>
												</td>
												<?php if($row['job_status']=='1'){ ?>
												<td>
												<?php if($row['sent_time']!='00:00:00'){ echo $row['sent_time'] ; }else{ ?>
												
												<form method="post" enctype="multipart/form-data">
												<?php if($form=='0' || $form=='10'){ ?>
													<input type="file" name="pdf" id="pdf" value="upload PDF" accept="application/pdf" />
												<?php } ?>
													<input type="submit" name="Submit" value="Submit" onclick="return confirm('Are you sure you want to end ?');" />
													<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
													
													<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
													
													<input name="adrep" value="<?php echo $row['adrep'];?>" readonly style="display:none;" />
													<?php if(isset($date)){ ?><input name="date" value="<?php echo $date;?>" readonly style="display:none;" /><?php } ?>
												</form>
												
												<?php }?>
												</td>
												<?php }else{ ?>
												<td><?php echo "<font color='blue'>removed</font>";?></td><?php } ?>
												<td>
<?php if($row['time_taken']!='0')
		  { 
			//calculating hours, minutes and seconds (as floating point values)
			$hours = $row['time_taken'] / 3600; //one hour has 3600 seconds
			$minutes = ($hours - floor($hours)) * 60;
			$seconds = ($minutes - floor($minutes)) * 60;

			//formatting hours, minutes and seconds
			$final_hours = floor($hours);
			$final_minutes = floor($minutes);
			$final_seconds = floor($seconds);

			//output
			echo $final_hours . ":" . $final_minutes . ":" . $final_seconds; 
		 } ?>
												  
											    </td>
												<!--
												<?php if($row['job_status']=='1'){ ?>
												<td><?php if($row['sent_time']=='00:00:00'){  ?>
												<form method="post">
												<input name="oid" value="<?php echo $row['id'];?>" readonly style="display:none;" /> 
												
												<?php if(isset($date)){ ?><input name="date" value="<?php echo $date;?>" readonly style="display:none;" /><?php } ?>	
												<input type="submit" name="remove" value="remove" class="btn"  />
												<input type="text" name="reason" autocomplete="off" required />
											
					<a href="#removeFor" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Remove</a>
                                                
                                               
                     <div id="removeFor" class="modal hide">
						<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">&times;</button>
						Reason for Remove
						</div>
						<div class="modal-body">
						<textarea name="reason" cols="30" rows="10" required></textarea>
											
						</div>
						<div class="modal-footer">
						
						<input type="submit" name="remove" value="Confirm" class="btn" />
						
						<?php if(isset($date)){ ?><input name="date" value="<?php echo $date;?>" readonly style="display:none;" /><?php } ?>
							
						<a data-dismiss="modal" class="btn" href="#">Cancel</a>
						</div>
					</div>   
												</form>
												<?php } ?>
												</td>
												<?php }else{ ?>
												<td><?php echo "<font color='blue'>removed</font>"; ?></td><?php } ?>
												-->
												
												<td> 
	<!--<input type="button" value="Click" onclick="window.open('<?php echo base_url().index_page().'csr/home/frontlinetrack_edit/'.$row['id'];?>')" />-->
	<a onclick="window.open('<?php echo base_url().index_page().'csr/home/frontlinetrack_edit/'.$row['id'];?>')" style="cursor:pointer; text-decoration: none;">Click</a>											
												</td>
												
											</tr>
<?php } ?>											
										</tbody>
									</table>
                                </div>
                            </div>
                        </div>
                        </div>
<?php  endif;?>							
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
	$this->load->view("csr/footer");
?> 