<?php $this->load->view("new_designer/head");?>

<div class="page-content">
<div class="container">

	<div class="col-md-12">
		<div class="portlet light margin-top-10">
			<div class="portlet-title">
			<div  class="col-xs-12 text-center">
				<?php echo '<span style=" color:#900;">'.$this->session->flashdata('message').'</span>'; ?> 
			</div>
			<div class="portlet-body">
			<form method = "POST">
			 <table class="table table-striped table-bordered table-hover" >
				<thead>
					<tr>
				<!--	<th>Date</th>-->
						<th>AdwitAds ID</th>
						<th>Reason</th>
						<th>Comment</th>
				   </tr>  
				</thead>
				<tbody>
				<?php if(isset($r_review['comment'])){
						$verify_type = $this->db->query("SELECT `name` FROM `verification_type` WHERE `id` IN (".$r_review['verification_type'].")")->result_array();
						
					?>
					<tr>
						<td><?php echo $r_review['order_id'];?></td>
						<td><?php foreach($verify_type as $v_row){ echo $v_row['name'].'<br/>'; } ?></td>
						<td>
							<div style="background-color:white; border:1px solid #e5e5e5;border-radius: 4px; padding: 8px;    height: 150px; " class =" scroller margin-bottom-10 ">
							
							<?php if($r_review['admin_id']!='0'){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_review['comment']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_review['admin_name']; ?> <b>(Admin)</b> </p>
							</div>
							</div>
							<?php } ?>
						
						<?php if(isset($r_review['designer_id']) && $r_review['designer_id'] != '0' && $r_review['designer_reply'] != NULL ) { //tl ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_review['designer_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_review['d_name']; ?> <b>(Designer)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php } ?> 
							
							<?php if(isset($r_review['tl_designer_id']) && $r_review['tl_designer_id'] != '0' && $r_review['dtl_reply'] != NULL ) { //designer ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_review['dtl_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_review['tl_name']; ?> <b>(D Team Lead)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($r_review['hi_b_designer_id']) && $r_review['hi_b_designer_id'] != '0' && $r_review['hi_b_designer_reply'] != NULL ) { //hi_b_designer ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_review['hi_b_designer_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_review['hi_b_name']; ?> <b>(Hybrid Designer)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							
							<?php if(isset($r_review['csr_id']) && $r_review['csr_id'] != '0' &&  $r_review['csr_id'] != NULL  && $r_review['csr_reply'] != NULL ){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_review['csr_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_review['c_name']; ?> <b> (Proof Reader)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							<?php if(isset($r_review['rov_csr_id']) && $r_review['rov_csr_id'] != '0' &&  $r_review['rov_csr_id'] != NULL  && $r_review['rov_csr_reply'] != NULL ){ ?>
							<div class="row">
							<div class="col-sm-6">
								<?php echo $r_review['rov_csr_reply']; ?>
							</div>
							<div class="col-sm-6 text-right">
								<p><?php echo $r_review['r_name']; ?> <b> (Rov CSR)</b> </p>
								<p class="font-grey-cascade"> </p>
							</div>
							</div>
							<?php }?>
							
							</div>
							<div style="color:#900;"  class=" margin-top-10" >Your Reply </div>
							<textarea rows="2" name="reply" class=" form-control margin-top-5" required/></textarea>
							
							<input type="hidden" value="<?php echo $r_review['rev_id']; ?>" name="rev_id">
							<input type="hidden" value="<?php echo $r_review['id']; ?>" name="comment_id">
							
							<button type="submit" name="c_search"  class=" btn btn-sm blue margin-top-10">Submit </button>
							
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			</form>
			</div>
			</div>
		</div>
	</div>
</div>
</div>

<?php $this->load->view("new_designer/foot");?>