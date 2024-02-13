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

<!-- BEGIN PAGE CONTAINER -->

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">
			<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<!--<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 

				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a>-->

				Designer Avg NJ -
				<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>
			</div>
			<div class="col-md-5 col-xs-9 margin-bottom-10  text-right">
			<div class="col-md-9">
				<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									<input type="text" class="form-control border-radius-left" name="designer_id" value="" style="display:none;">
									<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date">
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-3 ">
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
			</div>
			
		</div>
	</div>

	<div class="portlet-body " >
			<table class="table table-bordered table-hover" id="sample_6">
                 <thead>				
					<tr>
						<th>Designer Name</th>
						<th>Code</th>
						<th>Total NJ</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$total_nj = 0; $r_total_nj=0; $result = 0; $total_nj_count = 0;
					foreach($designers as $row){
					$query = "SELECT COUNT(cat_result.id) AS cat_cont, SUM(print.wt) AS total_nj FROM `cat_result` 
											LEFT JOIN `print` ON cat_result.category = print.name
											WHERE cat_result.designer IN (".$row['id'].") AND (cat_result.ddate BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
								$total_nj = $this->db->query("$query")->row_array();			
								//echo $row['name'].' - '.$query.'<br/>';
								
								$r_query = "SELECT COUNT(rev_sold_jobs.id) AS rev_cont, SUM(print.wt) AS r_total_nj FROM `rev_sold_jobs` 
											LEFT JOIN `print` ON rev_sold_jobs.category = print.name
											WHERE rev_sold_jobs.designer IN (".$row['id'].") AND (rev_sold_jobs.date BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
										
								$r_total_nj = $this->db->query("$r_query")->row_array();
								//echo $row['name'].' - '.$r_query.'<br/>';
								
								$result = $total_nj['total_nj'] + $r_total_nj['r_total_nj'];
								$total_nj_count = $total_nj_count + $result;
					
					
				?>
				<tr>
					<td><?php echo $row['name'];?></td>
					<td><?php echo $row['username'];?></td>
					<td><?php if(isset($result)){echo round($result,2);}else {echo "0";}?></td>
				</tr>
				<?php }?>
			</tbody> 
			<tfoot>
				<tr> 

					<th colspan="2">Total</th>
					<th><?php echo round($total_nj_count, 2); ?></th>
				</tr>

				</tfoot> 
			</table>
			
		
	</div>
</div>
</div>
</div>
</div>
</div>

<!-- END PAGE CONTAINER -->


<?php $this->load->view('new_admin/footer.php'); ?>

<?php $this->load->view('new_admin/datatable.php'); ?>




