<?php $this->load->view('new_admin/header')?>

<style>
	.dropdown-menu{
		position: relative !important;
	}
	.btn-xxs{
		padding: 5px;
		font-size: 12px;
		line-height: .8;
	}
	.dropdown-menu{
		position: relative !important;
	}
</style>


 <div class="col-md-12">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row margin-bottom-5">	
			<div class="col-md-6 col-xs-8">
				<!--<a href="manage.html" class="font-lg">Report</a> - 
				<a href="manage.html" class="font-lg font-grey-gallery">Complaints</a> -->
				<a href="<?php echo base_url().index_page().'new_admin/home/admin_report';?>" class="font-lg font-grey-gallery">Error List</a>
			</div>							
			<div class="col-md-6 col-xs-4 text-right">	
					<div class="btn-group"> 
						<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
			</div>
			</div> 
		</div>
		<div class="portlet-body">
			<table class="table table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th class="hidden">Copy</th>
						<th class="hidden">Attachments</th>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<!--<th>Job Name</th>-->
						<th>Job Name</th>
						<th>Version</th>
						<th>Reason for Revision</th>
					<!--	<th>Error Action</th>-->
					</tr>
				</thead> 
				<tbody> 
				<?php 
					if(isset($rev_sold)){
						foreach($rev_sold as $rev_sold_row){
						$rev_reason = $this->db->get_where('rev_reason',array('id' => $rev_sold_row['reason_c']))->result_array();
						?>
					<tr>
						<td class="hidden">								
							<?php echo $rev_sold_row['note']; ?>
						</td>
						<td class="hidden">	
							<?php 
								if($rev_sold_row['file_path'] != 'none' && file_exists($rev_sold_row['file_path'])){ 
									$filepath = $rev_sold_row['file_path'];
									$this->load->helper('directory');
									$map = glob($filepath.'/*',GLOB_BRACE);
									if($map)$i=0;{ foreach($map as $row1){$i++;
							?>								
							<a href="<?php echo base_url().$row1; ?>" target="_Blank" class="btn btn-xxs bg-grey-cascade">Attachments <?php echo $i;?></a>
							<?php } } } ?>
							<!--<a href="#" class="btn btn-xxs bg-grey-cascade">Attachments 2</a>
							<a href="#" class="btn btn-xxs bg-grey-cascade">Attachments 3</a>-->
						</td>
						<td><?php $date = strtotime($rev_sold_row['date']); echo date('M d, Y', $date); ?></td>
						<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$rev_sold_row['help_desk'].'/'.$rev_sold_row['order_id'].'/'.$EA;?>" type="button">
						<?php echo $rev_sold_row['order_id'] ;?></a></td>
						<!--<td><?php echo $rev_sold_row['order_no'] ;?></td>-->
						<td><?php echo $rev_sold_row['order_no'] ;?></td>
						<td><?php echo $rev_sold_row['version']; ?></td>	
						<td><?php echo $rev_reason[0]['name'] ;?></td>
						<!--<td>
							<form method="post">
								<div class="btn-group right-dropdown">
									<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="false">
										<strong class="btn grey btn-sm margin-bottom-5">Error</strong>
									</span>
									<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
										<label><input type="radio" name="c_error" value="1" <?php if($rev_sold_row['c_error']=='1')echo "checked= 'checked'"; ?> class="form-control margin-bottom-10">Yes</label>
										<label><input type="radio" name="c_error" value="2" <?php if($rev_sold_row['c_error']=='2')echo "checked= 'checked'"; ?> class="form-control">No</label>
										
										<div class="margin-top-10 text-right">
											<input type="text" name="rev_id" value="<?php echo $rev_sold_row['id']?>" style="display:none">
											<button type="submit" name="c_submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
										</div>
									</div>		
								</div>
							</form>
						</td>-->
					</tr> 
					<?php } } ?>
				</tbody>
			</table>
		</div>
	</div> 
 </div>
 
 <!--<div class="col-md-2">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="font-lg margin-bottom-5 align-center">Archive</div>	
		</div>
		<div class="portlet-body">
			<?php 	$start = date('Y-m-d', strtotime('-3 day')); //start date
					$end =  date('Y-m-d');//end date
					//echo $start.' - '.$end;
					 $dates = array();
					$start = $current = strtotime($start);
					$end = strtotime($end);

					while ($current <= $end) { 
					$dates[] = date('Y-m-d', $current);
					$current = strtotime('+1 days', $current);}
					foreach($dates as $d){ ?>
					<a href="<?php echo base_url().index_page(). 'new_admin/home/error_list/'.$d; ?>"  class="btn btn-sm margin-bottom-10 btn-block default"><?php $date = strtotime($d); echo date('M d, Y', $date); ?></a>
					<?php } ?>
		</div>
	</div>
</div>-->	

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable.php'); ?>
