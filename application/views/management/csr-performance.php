<?php $this->load->view("management/head"); ?>
<script type="text/javascript">
	$(document).ready(function($) {    
   		$( "#from_date" ).datepicker({ minDate: "-9M", maxDate: 0, dateFormat: 'yy-mm-dd' });	
		$( "#to_date" ).datepicker({ minDate: "-9M", maxDate: 0, dateFormat: 'yy-mm-dd'});	
	});	
	
</script>

<div class="page-container">
	<div class="page-content">
		<div class="container">
		
			<div class="row margin-top-15">
				<div class="col-sm-12">
					<div class="portlet light">
					   <div class="portlet-title">
							<div class="row static-info">
							<form method="post">
								<div class="col-md-7 value margin-top-10">CSR Performance :  <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?></div>
								<div class="col-md-4 no-space">
									<div class="input-group input-large date-picker input-daterange pull-right" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" id="from_date" placeholder="YYYY-MM-DD" name="from_date">
												<span class="input-group-addon">to</span>
												<input type="text" class="form-control" id="to_date" placeholder="YYYY-MM-DD" name="to_date">
									</div>
								</div>
								<div class="col-md-1 text-right">
									<button type="submit" name="submit" class="btn btn-primary btn-md btn-block">Submit</button>
								</form>
								</div>
							</div>
						</div>
					  <div class="portlet-body">
						<!-- <div style="padding-left: 30px; padding-top: 20px;">
								<form method="post" style="padding:0; margin:0;">
								<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
								<input type="submit" value="Submit" />
								</form>
						 </div>-->
						<table class="table table-striped table-bordered table-hover" id="sample_2">
						<thead>
							<tr>
								<th rowspan="2" style="vertical-align: middle;">Username</th>
								<th rowspan="2" style="vertical-align: middle;">CSR</th>
								<!--<th colspan="7" style=" text-align: center;">Catergory(QA)</th>-->
								<th colspan="6" style=" text-align: center;">Total</th>
								<th rowspan="2" style="vertical-align: middle;">Final NJ</th>
							</tr>
							<tr>
							<!--
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								-->
								<th style=" text-align: center;">QA
	<a onclick="window.open('<?php echo base_url().index_page().'management/home/QA_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>																							
								</th>
							<!--<th style=" text-align: center;">QA_NJ</th> -->
								<th style=" text-align: center;">Categorised</th>
								<th style=" text-align: center;">Incoming
	<a onclick="window.open('<?php echo base_url().index_page().'management/home/incoming_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>												
								</th>
								<th style=" text-align: center;">Outgoing
	<a onclick="window.open('<?php echo base_url().index_page().'management/home/outgoing_performance/';?>')" style="cursor:pointer; text-decoration: none; color:#999;">(?)</a>																								
								</th>
								<th>RovCheck</th>
								<th>Uploads</th>
							</tr>
						</thead>
						<tbody name="testTable" id="testTable">
	<?php

	foreach($csr as $row)
	{	

	$QA_nj = 0; $cat_nj = 0; $incoming_nj = 0; $outgoing_nj = 0; $final_nj = 0; $pub_nj = 0; $rev_nj = 0; $revision_nj = 0;
	$cat_job_count = 0; $sq_inches = 0; $cp_job_count = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;

	$csr_id = $row['id'];
	if(isset($from) && isset($to))
	{
	$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	$cp = $this->db->query("SELECT * FROM `cat_result` WHERE  `csr_QA`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
	$incoming = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	$outgoing = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `frontline_csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
	$upload = $this->db->query("SELECT * FROM `cp_tool` WHERE  `upload_csr`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
	}else{
	$cat_result = $this->db->get_where('cat_result',array('csr' => $csr_id, 'date' => $today))->result_array();
	$cp = $this->db->get_where('cat_result',array('csr_QA' => $csr_id, 'date' => $today))->result_array();
	$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `csr`='$csr_id' AND `date`='$today' ;")->result_array();
	$incoming = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `csr`='$csr_id' AND `date`='$today' ;")->result_array();
	$outgoing = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `frontline_csr`='$csr_id' AND `date`='$today' ;")->result_array();			
	$upload = $this->db->query("SELECT * FROM `cp_tool` WHERE  `upload_csr`='$csr_id' AND `date`='$today' ;")->result_array();			
	}
	$cat_job_count = count($cat_result);
	$cp_job_count = count($cp);
	foreach($cp as $row2)
	{
	$cat = $this->db->get_where('cat_result',array('order_no' => $row2['order_no']))->result_array();
	if($cat){
	$cat_wt = $this->db->get_where('print',array('name' => $cat[0]['category']))->result_array();
	$pub_nj = $pub_nj + $cat_wt[0]['wt'];

	if($cat[0]['category'] == 'A')
	{
		$cat_a++;
	}
	if($cat[0]['category'] == 'B')
	{
		$cat_b++;
	}
	if($cat[0]['category'] == 'C' || $cat[0]['category'] == 'c')
	{
		$cat_c++;
	}
	if($cat[0]['category'] == 'D')
	{
		$cat_d++;
	}
	if($cat[0]['category'] == 'E')
	{
		$cat_e++;
	}
	if($cat[0]['category'] == 'F')
	{
		$cat_f++;
	}
	if($cat[0]['category'] == 'G')
	{
		$cat_g++;
	}
	}
	}

	if($rev_sold)
	{			
	foreach($rev_sold as $row3)
	{
	$row3['category'] = strtoupper($row3['category']);
	$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
	if(isset($cat_wt[0]['wt'])){
		$rev_nj = $rev_nj + $cat_wt[0]['wt'];
	}

	if($row3['category'] == 'REVISION')
	{
		$cat_rev++;
	}
	if($row3['category'] == 'SOLD')
	{
		$cat_sold++;
	}
	}
	}
	$QA_nj = $pub_nj / 5 ;
	$cat_nj = $cat_job_count / 27;
	$incoming_nj = count($incoming) / 27;
	$outgoing_nj = count($outgoing) / 27;
	$revision_nj = $rev_nj / 27;
	$final_nj = $QA_nj + $cat_nj + $incoming_nj + $outgoing_nj + $revision_nj;

	?>    									
							<tr class="odd gradeX">
								<td><?php echo $row['username'];?></td>
								<td><?php echo $row['name']; ?></td>
								<!--
								<td><?php echo $cat_a; ?></td>
								<td><?php echo $cat_b; ?></td>
								<td><?php echo $cat_c; ?></td>
								<td><?php echo $cat_d; ?></td>
								<td><?php echo $cat_e; ?></td>
								<td><?php echo $cat_f; ?></td>
								<td><?php echo $cat_g; ?></td>
								-->
								<td><?php echo $cp_job_count; ?></td>
								<!--<td><?php echo round($pub_nj,2); ?></td>-->
								<td><?php echo $cat_job_count; ?></td>
								<td><?php echo round(count($incoming),2); ?></td>
								<td><?php echo round(count($outgoing),2); ?></td>
								<td><?php echo $cat_rev; ?></td>
								<td><?php echo round(count($upload),2); ?></td>
								<td><?php echo round($final_nj,2); ?></td>
								
							</tr>
						  <?php }?>											
						</tbody>
					</table>
					</div>
					 </div>
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
		
<?php $this->load->view("management/foot"); ?>









