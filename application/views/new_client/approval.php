<?php $this->load->view('new_client/header');?>
<div id="main">
	<section>
		<div class="container center" style="margin: 100px auto 150px auto;">
			<div class="row">
			<?php  echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>';  ?>
				<div class="col-md-4 col-md-offset-4">
				
					<div class="dropdown text-grey">
					<button class="btn btn-danger margin-top-20" type="btn" name="approve" data-toggle="dropdown" id="approve" aria-expanded="true" style="width: 170px;">Approve</button>
					<button class="btn btn-blue margin-top-20" type="btn" name="approval" id="approval" data-toggle="dropdown" style="width: 170px;" >Send for Approval</button>
					<!--<a href="<?php echo base_url().index_page().'new_client/home/jRate/'.$order_id ;?>" 
					   onclick="javascript:void window.open('<?php echo base_url().index_page().'new_client/home/jRate/'.$order_id;?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
						<span class="btn btn-grey margin-bottom-20"  type="btn" name="" id="view" aria-expanded="true">Approve</span>
					</a>-->
						<div class="dropdown-menu file_li padding-10 margin-top-5">
							<div id="approvalView">
							<p class="margin-bottom-5">Send for Approval</p>
								<div class="row">
									<form method="post" action="">
										<div class="col-xs-12">
											<label>AD Number</label>
											<input type="text" name="ad_num" class="form-control input-sm margin-bottom-10" required>
										
											<label>Name</label>
											<input type="text" name="name" class="form-control input-sm margin-bottom-10" required>
										
											<label>Email Address</label>
											<input type="email" name="email_id" class="form-control input-sm margin-bottom-10" required>
											<button type="submit" name="send" class="btn btn-danger margin-right-5 btn-block btn-sm">Send</button>
										</div>
									</form>	
								</div>
							</div>
							<div id="approveView">
							<p class="margin-bottom-5">AD Number</p>
							<div class="row">
								<form method="post" action="<?php echo base_url().index_page().'new_client/home/send_vidn_approval/'.$order_id ;?>">
									<div class="col-xs-12">
										<input type="text" name="ad_num" class="form-control input-sm" <?php if(isset($approve_details)){ echo"value='".$approve_details['ad_num']."'"; } ?> required>
									</div>
									<div class="col-xs-12 margin-top-10">
										<button class="btn btn-blue margin-right-5 btn-block btn-sm" type="submit" name="send" id="view" aria-expanded="true">Send</button>
									</div>
								</form>
								<div class="col-xs-12 margin-top-15" style="text-align: center;">
									or
								</div>	
								<div class="col-xs-12 margin-top-10">
									<form method="post" action="">
										<button type="submit" name="only_update" class="btn btn-gray margin-right-5 btn-block btn-sm">Don't Send</button>
									</form>
								</div>	
							</div>
							</div>
						</div>
					</div>
					
				</div>		
			</div>
		</div>
	</section>

</div>
<script>
$(document).ready(function(){
	
	$('#approval').click(function() { 
		$("#approvalView").show();
		$("#approveView").hide();
	});
	$('#approve').click(function() {
		$("#approveView").show();
		$("#approvalView").hide();
	});
		/*$('#approval').click(function() {
			$(".dropdown-menu").addClass(" display-block ");
		});	
		$('#filter').click(function() {
			$(".dropdown-menu").removeClass(" display-block ");
		});	*/
	});
</script>
<?php $this->load->view('new_client/footer');?>