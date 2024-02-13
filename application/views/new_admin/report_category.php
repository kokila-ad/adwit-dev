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
			<div class="col-md-6 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report_category/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> -
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report_production/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
				<?php if($pub_id != 'all') { echo '- '.$publications[0]['name'] ; }?>-
				<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>
				
				
			</div>
			<div class="col-md-5 col-xs-9 margin-bottom-10  text-right">
			<div class="col-md-9">
			
					<form method="get"> 
				<div class="btn-group left-dropdown">
					<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
						<a id="filter"><i class="fa fa-filter fa-2x cursor-pointer"></i></a>
					</span>
					<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
						<div class="radio-list">
							<label><input type="radio" name="order_type" id="print" value="2" checked>Print Ad </label>
							<label><input type="radio" name="order_type" id="web" value="1" <?php if($order_type=='1') echo 'checked';?>>Web Ad </label>
							<label><input type="radio" name="order_type" id="all" value="all" <?php if($order_type=='all') echo 'checked';?>>All </label>
						</div>
						<div class="date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
							<input type="text" class="form-control border-radius-left" name="from" value="" placeholder="From Date">
							<input type="text" class="form-control border-radius-right margin-top-5" name="to"  value="" placeholder="To Date">
							<div class="text-right margin-top-10">
								<input type="text" name="publication_id" value="<?php echo $pub_id ;?>" style="display:none;">
								<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
							</div>
						</div>
					</div>
					<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
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
						<th>Category</th>
						<th>Count</th>
						
					</tr>
				</thead>
				<tbody>
				<?php foreach($orders as $row){ ?>
				<tr>
					<td><?php echo $row['category'];?></td>
					<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/category_pub_design_details/'.$type.'/'.$user.'/'.$order_type.'/'.$pub_id.'/'.$row['category'].'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
					<?php echo $row['cat_count'];?></td>
				</tr>
				<?php } ?>
			</tbody> 
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




