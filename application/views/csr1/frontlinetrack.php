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
<style>.word-wrap-name{	max-width: 200px;	word-wrap: break-word;}</style>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'csr/home/frontlinetrack_';?>" + $('#display_type').val() + "<?php echo '/'.$form; ?>" ;
        });
    });
</script>

<script type="text/javascript">

function flip(id)
{
 if($("#priority-"+id+"").is(':checked') )
   $("#notes-"+id+"").show();
 else
    $("#notes-"+id+"").hide();
	
} 

</script>

<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php /*if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/Chicago');
				}*/ 
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
			$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
        </p>

<?php 
echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>';
if(isset($form)): 
?>
<div class="row-fluid" style="width:96%; margin: 0 auto;">
<div style="padding-bottom: 20px;">
	<div style="float: left;">
	<form method="post">
                <input type="submit" name="date"  value="<?php echo $qystday; ?>" /> 
		<input type="submit" name="date" value="<?php echo $pystday; ?>" /> 
		<input type="submit" name="date" value="<?php echo $ystday; ?>" /> 
		<input type="submit" name="date" value="<?php echo $today; ?>" /> 
	</form>

	</div>
	<div style="float: right;">
<a href="<?php echo base_url().index_page().'csr/home/revision/'.$form;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Incoming</button></a>
		<select id="display_type" name="display_type" style="width:80px; height:20px;" >
		   <option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
		   <option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
		</select>
		<?php echo "".$current_time ; ?><a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img src="images/refresh_trackingsheet.png"/></a>
	</div>
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
												<th colspan="4" style="text-align: center;">Time Stamp</th>
												<th rowspan="2" style="vertical-align: middle;">Designer</th>
												<th rowspan="2"style="vertical-align: middle;">Time Left</th>
												<th rowspan="2"style="vertical-align: middle;">	Time Sent</th>
												<th rowspan="2"style="vertical-align: middle;">Time Taken</th>
												<!--<th rowspan="2"style="vertical-align: middle;">Action</th>-->
												
												<th rowspan="2"style="vertical-align: middle;">Inst/<br/>Attch</th>
												<th rowspan="2"style="vertical-align: middle;">pdf</th>
											</tr>
                                            <tr>
                                              <th>New&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                              <th>Pickup&nbsp;&nbsp;</th>
                                              <th>Revision</th>
                                              <!--<th>Fasttrack</th>-->
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
	
	$i=0;
	foreach($jobs as $row){
		if($row['designer']!='0'){
			$designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
		}
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
									<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
										<td><?php echo $count ; ?></td>
										<td class="word-wrap-name"><?php echo $row['order_no']; ?></td>
										
										<td><?php if($row['category']=='new'){ echo $row['time'];} ?></td>
										<td><?php if($row['category']=='pickup'){ echo $row['time'];} ?></td>
										<td><?php if($row['category']=='revision'){ echo $row['time'];} ?></td>
										<!--<td><?php if($row['category']=='fastrack'){ echo $row['time'];} ?></td>-->
										<td><?php if($row['category']=='sold'){ echo $row['time'];} ?></td>
										
										<td><?php if($row['designer']!='0'){ echo $designer[0]['username']; } ?></td>
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
												<?php if($row['question']!='' && $row['answer']=='none'){ echo'<td>Question Sent</td>';}
												else{?>
										<td>
												<?php if($row['sent_time']!='00:00:00'){ echo $row['sent_time'] ; }else{ ?>
												
												<form method="post" enctype="multipart/form-data">
												
												<?php if($row['job_accept']=='0' && $row['order_id']!=''){ ?>
										<div class="btn-group">
										 <button type="submit" name="accept" class="btn btn-primary">Accept</button>
										 <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
										 <ul class="dropdown-menu">
										   <li>	<?php if($row['question']==''){ ?><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/question/'.$row['id'];?>'" >Question</a><?php } ?></li>
										 </ul>
										</div>
											<?php }elseif($row['order_id']=='' && $row['frontline_csr']=='0'){ ?>
												<button type="submit" name="Submit" class="btn btn-info">Send</button>
											<?php }elseif($row['new_slug']!='none'){ ?>
										
														<input type="file" name="pdf" id="pdf" value="upload PDF" accept="application/pdf" />
														
														<span style="color:#0000FF">Note</span><input type="checkbox" name="priority" id="priority-<?php echo $i; ?>" onClick="flip(<?php echo $i; ?>);" />
															<div id="notes-<?php echo $i; ?>" hidden >
																<input type="textarea" name="note" id="note"/>
       
															</div>
														
														<input type="submit" name="Submit" id="Submit" value="Submit" onclick="return confirm('Are you sure you want to end ?');" />
													<?php } ?>
													<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
													
													<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
													
													<input name="adrep" value="<?php echo $row['adrep'];?>" readonly style="display:none;" />
													<?php if(isset($date)){ ?><input name="date" value="<?php echo $date;?>" readonly style="display:none;" /><?php } ?>
												</form>
												
												<?php } ?>
										</td>
												<?php }}else{ echo "<td> <font color='blue'>removed</font> </td>"; } ?>
												
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
												  } 
											?>												  
										</td>
																					
										<td>	
	<!--<a onclick="window.open('<?php echo base_url().index_page().'csr/home/orderfrontline_cancel/'.$row['id'];?>')" style="cursor:pointer; text-decoration: none;">Click</a>-->											
	<a onclick="window.open('<?php echo base_url().index_page().'csr/home/frontline_instruction/'.$row['id'];?>')" style="cursor:pointer; text-decoration: none;">Click</a>
<!--<a href="<?php echo base_url().index_page().'csr/home/frontline_instruction/'.$row['id'];?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'csr/home/frontline_instruction/'.$row['id'];?>','1432728298066','width=800,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">Click</a>	-->
										</td>
										<td>
											<?php if($row['pdf_path']!='none'){ $pdf_path = base_url().$row['pdf_path']; ?>
											<a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a>
											<?php }else{ echo' '; }  ?> 
										</td>	
								</tr>
<?php $i++; } ?>											
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