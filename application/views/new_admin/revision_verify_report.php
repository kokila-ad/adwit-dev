<?php $this->load->view("new_admin/header"); ?>

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

<div class="portlet light">
	<div class="portlet-title">
	<div  class="col-xs-12 text-center">
	
	<?php echo '<span style=" color:#900;">'.$this->session->flashdata('message').'</span>'; ?> 
</div>
	<div class="row">
	<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
		<a href="<?php echo base_url().index_page(). 'new_admin/home/revision_verify_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> :
		<span><?php $f = strtotime($from) ; $t = strtotime($to); echo "From "." - ".date('M d, Y', $f)." ". "  To " . " - " .date('M d, Y', $t);?> </span>
	</div>

	<div></div>

	<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">
		<form method="get">
			<div class="btn-group left-dropdown">							
			<div class="btn-group left-dropdown">
			<div class="btn-group left-dropdown">							
			<!--	<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
					<i class="fa fa-filter cursor-pointer"></i> Filter
				</button> -->
		<!--	<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
				<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
					
					<input type="text" class="form-control border-radius-left" name="date" placeholder="From Date">
							
					<div class="text-right margin-top-10">
						<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
					</div>
				</div>
			</div> -->
			</div></div>
			</div>
		</form>
	</div>

	<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">	
		<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
	</div>

	<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
		<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
	</div>
	</div>
	</div>
	<div class="portlet-body">	
	<form method="post">
		<table class="table table-striped table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th style='display:none'></th>
					<th>Helpdesk</th>
					<th>Publication</th>
					<th>AdwitAds ID</th>
					<th>Designer Name</th>
					<th>Code</th>
					<th>Version</th>
					<th>Category</th> 
					<th>Instruction</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach($rev_orders as $rev_order){ 
					//$prev[] = $rev_order['rev_id']; $prev_rev_id = implode(',',$prev); 
					$help_desk = $this->db->query("SELECT `name` FROM `help_desk` WHERE `id` = '".$rev_order['help_desk']."'")->row_array();
						if(isset($rev_order) && $rev_order['version'] == 'V1a'){
							//$cat_result = $this->db->query("SELECT cat_result.id AS cat_id,cat_result.order_no,cat_result.designer,cat_result.version FROM `cat_result` 
							//                                    WHERE cat_result.order_no = '".$rev_order['order_id']."'")->row_array();

							$designer_name = $this->db->query("SELECT `id`, `name`,`username` FROM `designers` WHERE `id` = '".$rev_order['cat_result_designer']."'")->row_array();
							$prev_ver = $rev_order['cat_result_version'];						
						}else{
							$cur_ver = $rev_order['version'];
							$str = substr($cur_ver, -1);
							$str_prev = chr(ord($str)-1);
							$prev_ver = 'V1'.$str_prev;
							$prev_rev_details = $this->db->query("SELECT `id`, `designer` FROM `rev_sold_jobs` 
																	WHERE rev_sold_jobs.order_id = '".$rev_order['order_id']."' AND rev_sold_jobs.version = '$prev_ver' AND rev_sold_jobs.designer !='0' ")->row_array();
							if(isset($prev_rev_details['designer'])){
								$designer_name = $this->db->query("SELECT `id`, `name`,`username` FROM `designers` WHERE `id` = '".$prev_rev_details['designer']."'")->row_array();
							}
						}
					?>
					
				<td style='display:none'></td>
				<td><?php if(isset($help_desk['name'])){ echo $help_desk['name']; }else{ echo''; } ?></td>
				<td><?php echo $rev_order['publicationName'] ?></td>
				<td> 
					<a style=" color:#5b9bd1;" target = "blank" href="<?php echo base_url().index_page().'new_admin/home/order_review_history/'.$rev_order['order_id'];?>"><?php echo $rev_order['order_id'];?>
					</a>
				</td>
				<td><?php if(isset($designer_name['name'])){echo $designer_name['name'];}else{echo'';} ?></td>
				<td><?php if(isset($designer_name['username'])){echo $designer_name['username'];}else{echo'';}?></td>
				<td><?php echo $prev_ver;?></td>
				<td><?php echo $rev_order['cat_result_category']; ?></td>
				<td><?php echo $rev_order['rev_note']?></td>
				<td>
				<!--Start: Cancel-->	
				<?php if($rev_order['verify']== '0'){?>	
				<div class = "btn btn-block btn-xs btn-grey cursor-pointer padding-left ">
				<form id="form-id" method = "POST" action="<?php echo base_url().index_page().'new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'';?>">
					<input type ="hidden" value="<?php echo $rev_order['rev_id']; ?>" name="id" >
					<input type ="hidden" value="<?php echo $rev_order['order_id']; ?>" name="order_id">
					<input type ="hidden" value ="1" name ="verify">
					<!--<input type ="hidden" value="<?php echo $prev_rev_id; ?>" name="prev_rev_id">-->
					<a href="<?php echo base_url().index_page().'new_admin/home/revision_verify_type/'.$type.'/'.$rev_order['rev_id'].'/'.$date.'?from='.$from.'&to='.$to.'';?>">
					<button class = "btn btn-block btn-xs grey" name="submit">Verify</button></a>
				</form>
				</div>
				<?php }?>
				
				<?php if($rev_order['verify']== '1'){?>	
				<div class = "btn btn-block btn-xs padding-5 btn-grey cursor-pointer padding-left-5">
					<input type="hidden" value="<?php echo $rev_order['rev_id']; ?>" name="id">
					<input type="hidden" value="<?php echo $rev_order['order_id']; ?>" name="order_id">
					<a href="<?php echo base_url().index_page().'new_admin/home/revision_verify_type/'.$type.'/'.$rev_order['rev_id'].'/'.$date.'?from='.$from.'&to='.$to.'';?>">Verifying</a>
				</div>
				<?php }?>
				
			   <!--End: Cancel-->
			   
				</td>
			</tr>
			<?php }?>
			</tbody>		
		</table>
		</form>
	</div>
</div>

<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>
