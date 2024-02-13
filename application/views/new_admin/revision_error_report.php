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
	<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery"> Advocate Control Account :
		<span><?php $f = strtotime($from) ; $t = strtotime($to); echo "From "." - ".date('M d, Y', $f)." ". "  To " . " - " .date('M d, Y', $t);?> </span>
	</div>
	<div></div>
	

	<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">
		<form method="get">
			<div class="btn-group left-dropdown">							
			<div class="btn-group left-dropdown">
			
			<div class="btn-group left-dropdown">							
				<!--<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
					<i class="fa fa-filter cursor-pointer"></i> Filter
				</button> -->
			<!--<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
				<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
					
					<input type="text" class="form-control border-radius-left" name="date" placeholder="From Date">
							
					<div class="text-right margin-top-10">
						<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
					</div>
				</div>
			</div> -->
			<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
				<a target = "blank" href="<?php echo base_url().index_page().'new_admin/home/advocate_w_m_report';?>"  class="btn btn-primary btn-xs" >Error Report</a>
			</div>
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
		
		<table class="table table-striped table-bordered table-hover" id="sample_6">
		
			<thead>
				<tr>
					<th>AdwitAds ID</th>
					
				<!--<th>Designer <br>Team Lead </th>
					<th>Designer</th>
					<th>Code</th>
					<th>Proof <br>Reader</th>
					<th>Code</th>
					<th>Rov CSR</th>
					<th>Hybrid <br>Designer </th> -->
					<th style="width: 900px; ">The Comment</th>
					<th style="width: 900px; ">The Reply</th>
					<th>Designer</th>
					<th>CSR</th>
					<th >Error (Y/N)</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($rev_orders as $r_order){ ?>
				<tr>
					<td><?php echo $r_order['order_id'];?></td>
					
			<!--	<td><?php if(isset($r_order['tl_name'])){echo $r_order['tl_name'];}else{echo'';} ?></td>
					<td><?php if(isset($r_order['d_name'])){echo $r_order['d_name'];}else{echo'';} ?></td>
					<td><?php if(isset($r_order['du_name'])){echo $r_order['du_name'];}else{echo'';}?></td>
					<td><?php if(isset($r_order['c_name'])){echo $r_order['c_name'];}else{echo'' ;} ?></td>
					<td><?php if(isset($r_order['cu_name'])){echo$r_order['cu_name'];}else{echo'';}?></td>
					<td><?php if(isset($r_order['r_name'])){echo $r_order['r_name'];}else{echo'' ;} ?></td>
					<td><?php if(isset($r_order['hi_b_name'])){echo $r_order['hi_b_name'];}else{echo'' ;}?></td>-->
					<td><?php echo $r_order['comment'];?></td>
					<td>
					
				
					<?php if(isset($r_order['designer_id']) && $r_order['designer_id'] != '0' && $r_order['designer_reply'] != NULL ) {  ?>
					<div class="row">
							<div class="col-sm-6">
						<?php echo $r_order['designer_reply']; ?> -
						</div>
						<div class="col-sm-6 text-right">
						<p><?php echo $r_order['d_name']; ?> <b>(Designer)</b> </p>
						<p class="font-grey-cascade"> </p>
							</div>	
					</div>
							
							<?php } ?> 
							
							<?php if(isset($r_order['tl_designer_id']) && $r_order['tl_designer_id'] != '0' && $r_order['dtl_reply'] != NULL ) {  ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_order['dtl_reply']; ?>  -
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_order['tl_name']; ?> <b>(D Team Lead)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($r_order['hi_b_designer_id']) && $r_order['hi_b_designer_id'] != '0' && $r_order['hi_b_designer_reply'] != NULL ) { //hi_b_designer ?>
							<div class="row">
							<div class="col-sm-6"> 
								<?php echo $r_order['hi_b_designer_reply']; ?> -
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_order['hi_b_name']; ?> <b>(Hybrid Designer)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($r_order['csr_id']) && $r_order['csr_id'] != '0' && $r_order['csr_id'] != NULL && $r_order['csr_reply'] != NULL ){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_order['csr_reply']; ?> -
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_order['c_name']; ?> <b> (Proof Reader)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($r_order['rov_csr_id']) && $r_order['rov_csr_id'] != '0' &&  $r_order['rov_csr_id'] != NULL  && $r_order['rov_csr_reply'] != NULL ){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_order['rov_csr_reply']; ?> -
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_order['r_name']; ?> <b> (Rov CSR)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
					</div>		
					</td>
					<td>
					<?php 
						if(isset($r_order['d_name'])){
							echo $r_order['d_name'].'('.$r_order['du_name'].')';
						}elseif(isset($r_order['tl_name'])){
							echo $r_order['tl_name'].'('.$r_order['tlu_name'].')';
						}elseif(isset($r_order['hi_b_name'])){
							echo $r_order['hi_b_name'].'('.$r_order['hi_b_uname'].')';
						}else{
							echo'';
						} 
					?>
					</td>
					<td><?php if(isset($r_order['c_name'])){ echo $r_order['c_name'].'('.$r_order['cu_name'].')'; }else{echo'';} ?></td>
					<td>
						<label>
							<input type="radio" class="error radio" data-row_id="<?php echo $r_order['id']; ?>" value="1" <?php if($r_order['error'] =='1')echo 'checked="checked"';?> name="error<?php echo $r_order['id']; ?>" > Yes 
						</label> 
						<label>
							<input type="radio" class="error radio" data-row_id="<?php echo $r_order['id']; ?>" value="0" <?php if($r_order['error'] =='0')echo 'checked="checked"';?> name="error<?php echo $r_order['id']; ?>" > No 
						</label> 
					</td>	
				</tr>
			<?php } ?>
			</tbody>		
		</table>
		
	</div>
</div>

<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>
<script>
$('.error').click(function(){
	var value = $(this).val(); 
	var comment_id = $(this).data('row_id'); 
	var search = 'search';
	$.ajax({
		url: "<?php echo base_url().index_page().'new_admin/home/revision_error_update'; ?>",
		type: "POST",
		data: {error:value, comment_id:comment_id, search:search},
		success: function(data){
			alert(data);
		}
	});
	window.location.reload();	
});

</script>

<script> 
		function goBack(){ window.history.back(); }
	</script>