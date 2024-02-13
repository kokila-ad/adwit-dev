<?php $this->load->view('new_admin/header.php'); ?>


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">
			<div class="col-md-6 font-lg font-grey-gallery">
				
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-lg">Reports</a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-lg"><?php echo $type;?></a> -
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-lg font-grey-gallery"><?php echo $user;?></a> -
				<?php echo $groups[0]['name'] ;?> -
				<a class="font-lg font-grey-gallery">Category Wise</a> -
					
					<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?> 
					
			</div> 
			<div class="col-md-6 text-right">	
				<button class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>

	<div class="portlet-body no-space">	
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
					<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_admin/home/category_grp_design_details/'.$id.'/'.$row['category'].'/'.$type.'/'.$user.'/'.$order_type.'/'.$date.'?from='.$from.'&to='.$to;?>'" style="cursor:pointer; text-decoration: none;">
					<?php echo $row['cat_count'];?></td>
				</tr>
			<?php } ?>
			</tbody> 
		</table>
	</div>
	
</div>
  
  
  
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable')?>