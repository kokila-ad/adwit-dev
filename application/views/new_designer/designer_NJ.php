
<!-- BEGIN HEADER -->
<?php
       $this->load->view("new_designer/head"); 
?>
<!-- END HEADER -->
<script type="text/javascript"> 
 $(document).ready(function(e) {
        $('#date').change(function(e) {
  
            window.location = "<?php echo base_url().index_page().'new_designer/home/designer_NJ/'?>" + $('#date').val() ;
        });
    });
</script>	


<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Production <small>report</small></h1>
			</div>
			<!-- END PAGE TITLE -->
			<!-- BEGIN PAGE TOOLBAR -->
			<div class="page-toolbar">
				<!-- BEGIN THEME PANEL -->
	<!-- END THEME PANEL -->
			</div>
			<!-- END PAGE TOOLBAR -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
		<!-- BEGIN CALENDER SEARCH -->
			<div class="row">
        <div class="col-lg-12">
         <div class="navbar navbar-default" role="navigation">
				
				<div class="margin-top-10">
					<form role="form" method="post"> &nbsp; &nbsp; Date &nbsp;
					<?php if(isset($num_days)) { ?>
					<select class="padding-vertical-5 padding-horizontal-10" id="date" name="date">
						<option value = "">SELECT</option>
						<option value = "7" <?php if($num_days=='7') echo "selected";?>>7 Days</option>
						<option value = "15" <?php if($num_days=='15') echo "selected";?>>15 Days</option>
						<option value = "30" <?php if($num_days=='30') echo "selected";?>>30 Days</option>
					</select>
					<?php }?>
					</form>
				</div>
		</div>

			<!-- END CALENDER SEARCH -->
			
			
			
			<!-- BEGIN PUBLICATION TABLE -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Production Table</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
											<tr>
												<!--<th>ID</th>-->
												<th colspan="2" style=" text-align: center;">Designer</th>
												<th colspan="3" style=" text-align: center;">Total</th>
												<th rowspan="2" style=" vertical-align: middle;">Avg DP</th>
												<th colspan="9" style=" text-align: center;">Category</th>
												
											</tr>
                                            <tr>
												<!--<th>ID</th>-->
												<th>Name</th>
												<th>Code</th>
												<th> Ads</th>
												<th>QA</th>
												<th>NJ</th>
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th>RJ</th>
												<th>SJ</th>
												
                                                
											</tr>
										</thead>
							<tbody name="testTable" id="testTable">
<?php

foreach($designer as $row)
{	
	$team_lead = $this->db->get_where('team_lead',array('id' => $row['design_team_lead']))->result_array();
	$art_dir = $this->db->get_where('art_director',array('id' => $team_lead[0]['art_director']))->result_array();
	//$bg_grp = $this->db->get_where('business_groups',array('id' => $art_dir[0]['business_group_id']))->result_array();
	$dp_sft = 0; $pub_nj = 0; $job_count = 0; $sq_inches = 0; $total_QA = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_rev = 0; $cat_sold = 0;
	
	$designerr_min_count = 0; $designerr_major_count = 0; $perfect_count = 0;
	$techerr_min_count = 0; $techerr_major_count = 0; 
	$texterr_min_count = 0; $texterr_major_count = 0; 
	$visualerr_min_count = 0; $visualerr_major_count = 0;
	
			$designer_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$designer_id' AND `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
				//$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
				$cp_id1 = $this->db->query("SELECT DISTINCT `order_no` FROM `cp_tool` WHERE `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();			
				
				$additional_hrs = $this->db->query("SELECT * FROM `designer_additional_hours` WHERE  `designer`='$designer_id' AND `status`='approved' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `designer`='$designer_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
			}else{
				$cat_result = $this->db->get_where('cat_result',array('designer' => $designer_id, 'ddate' => $today))->result_array();
				//$rev_sold = $this->db->query("SELECT * FROM `ptrands` WHERE  `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				$cp_id = $this->db->query("SELECT * FROM `cp_tool` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				$cp_id1 = $this->db->query("SELECT DISTINCT `order_no` FROM `cp_tool` WHERE `designer`='$designer_id' AND `date`='$today' ;")->result_array();			
				$additional_hrs = $this->db->get_where('designer_additional_hours',array('designer' => $designer_id, 'date' => $today, 'status' => "approved"))->result_array();
				$rev_sold = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `designer`='$designer_id' AND `date`='$today' ;")->result_array();
				
			}
			$total_QA = count($cp_id);	
			foreach($cat_result as $row2)
			{
				$w_h = 0;
				$category = $this->db->get_where('print',array('name' => $row2['category']))->result_array();
				$pub_nj = $pub_nj + $category[0]['wt'];
				if($row2['shift_factor']!='0'){
					if($additional_hrs){
						$dp_sft = $dp_sft + ($category[0]['wt'] / ($row2['shift_factor'] + $additional_hrs[0]['hours'])); //new job DP calculation (dp=nj/(shift_factor+$additional_hrs))
					}else{
						$dp_sft = $dp_sft + ($category[0]['wt'] / $row2['shift_factor']); //new job DP calculation (dp=nj/shift_factor)
					}
				}
				$job_count++;
				
				$w_h = $row2['width'] * $row2['height'];
				$sq_inches = $sq_inches + $w_h;
				
				if($row2['category'] == 'A')
				{
					$cat_a++;
				}
				if($row2['category'] == 'B')
				{
					$cat_b++;
				}
				if($row2['category'] == 'C' || $row2['category'] == 'c')
				{
					$cat_c++;
				}
				if($row2['category'] == 'D')
				{
					$cat_d++;
				}
				if($row2['category'] == 'E')
				{
					$cat_e++;
				}
				if($row2['category'] == 'F')
				{
					$cat_f++;
				}
				if($row2['category'] == 'G')
				{
					$cat_g++;
				}
			
			}
			if($rev_sold)
			{			
				foreach($rev_sold as $row3)
				{
					$row3['category'] = strtoupper($row3['category']);
					$cat_wt = $this->db->get_where('print',array('name' => $row3['category']))->result_array();
					$pub_nj = $pub_nj + $cat_wt[0]['wt'];
					
					$dp_sft = $dp_sft + $cat_wt[0]['wt'];
					/*if($row3['shift_factor']!='0')
					{
						if($additional_hrs){
							$dp_sft = $dp_sft + ($cat_wt[0]['wt'] / ($row3['shift_factor'] + $additional_hrs[0]['hours'])); //new job DP calculation (dp=nj/(shift_factor+$additional_hrs))
						}else{
							$dp_sft = $dp_sft + ($cat_wt[0]['wt'] / $row3['shift_factor']); //new job DP calculation (dp=nj/shift_factor)
						}
					}*/
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
	
	//minor major error
			foreach($cp_id as $row1)
			{
				$cid = $row1['id'];
				//minor error degree
				$err_design_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='1' AND `error_degree`='1' ;")->result_array();
				$err_tech_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='2' AND `error_degree`='1' ;")->result_array();
				$err_text_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='3' AND `error_degree`='1' ;")->result_array();
				$err_visual_min = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='4' AND `error_degree`='1' ;")->result_array();
				
				//major error degree
				$err_design_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='1' AND `error_degree`='2' ;")->result_array();
				$err_tech_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='2' AND `error_degree`='2' ;")->result_array();
				$err_text_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='3' AND `error_degree`='2' ;")->result_array();
				$err_visual_major = $this->db->query("SELECT * FROM `cp_error_result` WHERE `cp_result_id`='$cid' AND `error_type`='4' AND `error_degree`='2' ;")->result_array();
	
				foreach($err_design_min as $min1)		//design type error
				{
					$designerr_min_count++;
				}
				foreach($err_design_major as $major1)
				{
					$designerr_major_count++;
				}
				foreach($err_tech_min as $min2)			//tech type error
				{
					$techerr_min_count++;
				}
				foreach($err_tech_major as $major2)
				{
					$techerr_major_count++;
				}
				foreach($err_text_min as $min3)			//text type error
				{
					$texterr_min_count++;
				}
				foreach($err_text_major as $major3)
				{
					$texterr_major_count++;
				}
				foreach($err_visual_min as $min4)			//visual type error
				{
					$visualerr_min_count++;
				}
				foreach($err_visual_major as $major4)
				{
					$visualerr_major_count++;
				}
	
			}
	
		$tot_minor =  $designerr_min_count + $techerr_min_count + $visualerr_min_count + $texterr_min_count  ;
		$tot_major =  $designerr_major_count + $techerr_major_count + $visualerr_major_count + $texterr_major_count ;
	
		$dp_sft = $dp_sft/30;
		if($dp_sft > '1'){ $dp_sft = '1'; }
	?>    									
											<tr class="odd gradeX">
												<!--<td><?php echo $row['id']; ?></td>-->
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												
												<td><?php echo $job_count; ?></td>
												<td><?php echo $total_QA; ?></td>
												<td><?php echo $pub_nj; ?></td>
												<!--<td><?php echo $avg_tt; ?></td>-->
												<td><?php echo round($dp_sft,2); ?></td>
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $cat_rev; ?></td>
												<td><?php echo $cat_sold; ?></td>
												
											</tr>
<?php }?>											
										</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PUBLICATION TABLE -->
			
		

			
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<!-- BEGIN PRE-FOOTER -->
	
<!-- END PRE-FOOTER -->


<?php $this->load->view('new_designer/foot');?>