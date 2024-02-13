<?php $this->load->view('new_admin/header.php'); ?>

<script>
$(document).ready(function(){	    
	$(".dropdown-checkboxes").hide();	
	$('.date-picker').click(function() {
		$(".cursor-pointer").addClass(" filter ");
	});	
	$('#filter').click(function() {
		$(".dropdown-checkboxes").toggle();
	});
});
</script>
<!--<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>-->


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
				<?php if($ppcsr_id != 'all') { echo '- '.$csr[0]['name'] ; }?>
			</div>
			
			<div class="col-md-5 col-xs-9 margin-bottom-10 text-right padding-right-0">	
				<?php if($ppcsr_id != 'all') { ?> 
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									<input type="text" class="form-control border-radius-left" name="ppcsr_id" value="<?php echo $ppcsr_id ;?>" style="display:none;">
									<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date">
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				<?php } ?>	
			</div>	
			
			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="portlet-body no-space" id="close_filter">
			<?php if($ppcsr_id == 'all') { ?>
				<table class="table table-bordered table-hover" id="sample_6">
			<?php } else{ ?>
		<div class="table-scrollable">
			<table class="table table-bordered table-hover"><?php } ?> 
				<thead>
					<tr>
						<th>Username</th>
						<th>CSR Name</th>
						<th>New Order Created</th>
						<th>Categorised</th>
						<th>QA</th>
						<th>DC</th>
						<th>Revision Order Created</th>
						<th>Revision Accept</th>
						<th>Rov Checked</th>
						<th>Revision Sent</th>
						<th>Error</th>
						<th>Total NJ</th>
					</tr>
				</thead>
				<tbody>
				<?php $tot_new_order_count = 0; $tot_category_count = 0; $tot_QA_count = 0; $tot_cp_tool_count = 0; $tot_rev_created_count = 0; $tot_rev_accepted_count = 0; $tot_rov_checked_count = 0; $tot_rev_sent_count = 0;
				$tot_error_count = 0; $tot_final_nj = 0;
				foreach($csr as $row){  $error_count = 0;
				$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0; $cat_h = 0;
				$orders = $this->db->query("SELECT `id` FROM `orders` WHERE `csr` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
				$cat_result = $this->db->query("SELECT `id` FROM `cat_result` WHERE `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
				$QA = $this->db->query("SELECT * FROM `cat_result` WHERE `csr_QA` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
				
				$cp_tool = $this->db->query("SELECT * from `cp_tool` where `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
				$rev_created = $this->db->query("SELECT * from `rev_sold_jobs` where `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
				$rev_accepted = $this->db->query("SELECT * from `rev_sold_jobs` where `c_create` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
				$rov_checked = $this->db->query("SELECT * from `ptrands` where `csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
				$rev_sent = $this->db->query("SELECT * from `rev_sold_jobs` where `frontline_csr` = '".$row['id']."' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
				if($QA){  foreach($QA as $Q) { //echo $Q['order_no'].'-'.$Q['csr_QA'].'</br>';
					$pro_con = $this->db->query("SELECT Distinct(`order_id`),`dc_id` FROM `production_conversation` WHERE `order_id` = '".$Q['order_no']."' AND (`dc_id` != '".$row['id']."' AND `dc_id` != '0') ")->result_array();
					$error_count = $error_count + count($pro_con);
					
					$cat_wt = $this->db->get_where('print',array('name' => $Q['category']))->result_array();
					if($Q['category'] == 'A')
					{
						$cat_a++; 
					}
					if($Q['category'] == 'B')
					{
						$cat_b++;
					}
					if($Q['category'] == 'C')
					{
						$cat_c++;
					}
					if($Q['category'] == 'D')
					{
						$cat_d++;
					}
					if($Q['category'] == 'E')
					{
						$cat_e++;
					}
					if($Q['category'] == 'F')
					{
						$cat_f++;
					}
					if($Q['category'] == 'G')
					{
						$cat_g++;
					}
					if($Q['category'] == 'H')
					{
						$cat_h++;
					}
					
					
				}}
				
				//csr weight
				$print = $this->db->query("SELECT * FROM `print`")->result_array();
				foreach($print as $print_row){
					$name = $print_row['name'];
					$weight[$name] = $print_row['csr_wt'];
				}
				$cat_nj = ($cat_a * $weight['A']) + ($cat_b * $weight['B']) + ($cat_c * $weight['C']) + ($cat_d * $weight['D']) + ($cat_e * $weight['E']) + ($cat_f * $weight['F']) + ($cat_g * $weight['G']) + ($cat_h * $weight['H']);
				//echo $cat_nj;
				//counts
				$new_order_count = count($orders);
				$category_count = count($cat_result);
				$QA_count = count($QA); 
				$cp_tool_count = count($cp_tool);
				$rev_created_count = count($rev_created);
				$rev_accepted_count = count($rev_accepted);
				$rov_checked_count = count($rov_checked);
				$rev_sent_count = count($rev_sent);
				
				$nj_value1 = $this->db->get_where('nj_parameter',array('id' =>'1' ))->result_array();
				$nj_value2 = $this->db->get_where('nj_parameter',array('id' =>'2' ))->result_array();
				$nj_value3 = $this->db->get_where('nj_parameter',array('id' =>'3' ))->result_array();
				$nj_value4 = $this->db->get_where('nj_parameter',array('id' =>'4' ))->result_array();
				$nj_value5 = $this->db->get_where('nj_parameter',array('id' =>'5' ))->result_array();
				$nj_value6 = $this->db->get_where('nj_parameter',array('id' =>'6' ))->result_array();
				$nj_value7 = $this->db->get_where('nj_parameter',array('id' =>'7' ))->result_array();
				$nj_value8 = $this->db->get_where('nj_parameter',array('id' =>'8' ))->result_array();
				$nj_value9 = $this->db->get_where('nj_parameter',array('id' =>'9' ))->result_array();
				$new_order_nj = $new_order_count / $nj_value1[0]['value'];
				$category_nj = $category_count / $nj_value2[0]['value'];
				$QA_nj = $QA_count / $nj_value3[0]['value'];
				$cp_nj = $cp_tool_count / $nj_value4[0]['value'];
				$rev_created_nj = $rev_created_count / $nj_value5[0]['value'];
				$rev_accepted_nj = $rev_accepted_count / $nj_value6[0]['value'];
				$rov_checked_nj = $rov_checked_count / $nj_value7[0]['value'];
				$rev_sent_nj = $rev_sent_count / $nj_value8[0]['value'];
				$error_nj = $error_count / $nj_value9[0]['value'];
				$final_nj = $new_order_nj + $category_nj + $cat_nj + $cp_nj + $rev_created_nj + $rev_accepted_nj + $rov_checked_nj +$rev_sent_nj + $error_nj;
					
				?>
				
					<tr>
						<td><?php echo $row['username'] ;?></td>
						<td><?php echo $row['name'] ;?></td>
						<td><?php echo $new_order_count ;?></td>
						<td><?php echo $category_count ;?></td>
						<td><?php echo $QA_count ;?></td>
						<td><?php echo $cp_tool_count ;?></td>
						
						<td><?php echo $rev_created_count ;?></td>
						<td><?php echo $rev_accepted_count ;?></td>
						<td><?php echo $rov_checked_count ; ?></td>
						<td><?php echo $rev_sent_count ; ?></td>
						<td><?php if(isset($error_count) && ($error_count != '0')){ echo $error_count; }?></td>
						<td><?php echo $final_nj ; ?></td>
					</tr>
					<?php 
						$tot_new_order_count = $tot_new_order_count + $new_order_count;
						$tot_category_count = $tot_category_count + $category_count;
						$tot_QA_count = $tot_QA_count + $QA_count;
						$tot_cp_tool_count = $tot_cp_tool_count + $cp_tool_count;
						$tot_rev_created_count = $tot_rev_created_count + $rev_created_count;
						$tot_rev_accepted_count = $tot_rev_accepted_count + $rev_accepted_count;
						$tot_rov_checked_count = $tot_rov_checked_count + $rov_checked_count;
						$tot_rev_sent_count = $tot_rev_sent_count + $rev_sent_count;
						$tot_error_count = $tot_error_count + $error_count;
						$tot_final_nj = $tot_final_nj + $final_nj;
					?>

				<?php } ?>
				</tbody>
				<?php if($ppcsr_id == 'all') { ?>
				<tfoot>
					<tr>
						<th colspan="2">Total</th>
						<th><?php echo $tot_new_order_count ;?></th>
						<th><?php echo $tot_category_count ;?></th>
						<th><?php echo $tot_QA_count ;?></th>
						<th><?php echo $tot_cp_tool_count ;?></th>
						<th><?php echo $tot_rev_created_count ;?></th>
						<th><?php echo $tot_rev_accepted_count ;?></th>
						<th><?php echo $tot_rov_checked_count ;?></th>
						<th><?php echo $tot_rev_sent_count ;?></th>
						<th><?php echo $tot_error_count ;?></th>
						<th><?php echo $tot_final_nj ;?></th>
					</tr>
				</tfoot>
			  <?php } ?>
			</table>
		</div>
	</div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>