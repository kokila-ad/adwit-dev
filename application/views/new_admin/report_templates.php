<?php $this->load->view('new_admin/header')?>
 <script>
	function addRating(x) { 
		$.ajax({
		url: "<?php echo base_url().index_page().'new_admin/home/add_tag';?>",
		data:'id='+$('#order_id'+x).val()+'&tags='+$('#tags'+x).val(),
		type: "POST",
		success:	function(msg){
						jQuery('#tags_display'+x).html(msg);
					} 
		});
		
		//refresh div
		$('#tags'+x).val("");
		//$( "#tags_display" ).load( "<?php echo base_url().index_page()."new_client/home/templates";?> #tags_display" );
	}

</script>
<style>
iframe {  background-color: #525659; }
</style>


<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-6 col-xs-8">
			<a href="<?php echo base_url().index_page().'new_admin/home/manage'; ?>" class="font-lg">Manage</a> - 
			<u class="font-lg font-grey-gallery">Templates</u>
		</div>							
			
	</div>
	<div class="portlet-body">
		<div class="row report margin-0 border-top border-bottom">
			<div class="col-md-3 col-sm-6 report-tab">
				<h3 class="font-blue margin-top-20 margin-bottom-5">Templates</h3>
			</div>
			<div class="col-md-3 col-sm-6 report-tab">
				<h3 class="font-blue margin-top-15 margin-bottom-5"><?php echo $template; ?></h3>
				<p class="font-grey-gallery margin-0">Total No Of Templates</p>
			</div>
			<div class="col-md-3 col-sm-6 report-tab padding-right-20">		
				<h3 class="font-blue"><?php echo $user_count; ?></h3>
				<p class="font-grey-gallery">Users</p>
			</div>
			
			<div class="col-md-3 col-sm-6 report-tab padding-left-40 align-center">
				<h3 class="bold font-grey-gallery margin-top-20"><a href="#" class="fa fa-gear fa-2x margin-top-20"></a></h3>
				<h5 class="bold font-grey-gallery">Settings</h5>
			</div>								
		</div>
		
		<div class="row margin-0 border  margin-top-30">
			<form method="get" > 
				<div class="col-md-6 padding-20 align-center">
					<p class="font-grey-gallery margin-top-5"><?php echo $this->session->flashdata('message');
					 if(isset($id)){ echo $id; } ?></p>
				</div>
				<div class="col-md-6 padding-20 border-left">
					<div class="input-group">
						<input type="text" name="id" class="form-control" placeholder="Enter Template ID">
						<span class="input-group-btn">
						<input type="text" name="num" value="1" hidden>
						<button type="submit" name="search" class="btn bg-grey-gallery">Search</button>
						</span>
					</div>
				</div>
			</form>
		</div>
		
		<?php if(isset($orders)){ ?>
		<div class="row margin-top-30"> 
			<?php $i=0; foreach($orders as $row){ $i++;
					if(file_exists($row['pdf'])){
			?>						
			<div class="col-md-4 margin-bottom-20">
				<iframe src="<?php echo base_url().$row['pdf'].'#zoom=-50'; ?>" frameborder="0" width="100%" height="220"></iframe>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6"><span class="text-grey">AdwitAds ID:</span> <?php echo $row['id']; ?></div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-right"> 
						<a href="<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['id']; ?>">
							<i class="fa fa-clipboard margin-right-15" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Pickup"></i> 
						</a>
						<span class="dropdown">
							<span class="cursor-pointer" type="button" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-tags margin-right-15 cursor-pointer" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="AddTag"></i>
							</span>
														
							<div class="table-responsive dropdown-menu file_li padding-10 text-right"> 
								<form>
									<input type="text" name="tags" id="tags<?php echo $i; ?>" class="form-control">
									<label id="tags_display<?php echo $i; ?>" class="text-grey">
									<?php 
										$order_tags = $this->db->get_where('order_tags',array('order_id'=>$row['id']))->result_array(); 
										foreach($order_tags as $row_tag){
											$tag = $this->db->get_where('tags',array('id'=>$row_tag['tag_id']))->row_array();
											echo $tag['name'].' ';	
										}
									?>
									</label>
									<input type="text" name="order_id" id="order_id<?php echo $i; ?>" value="<?php echo $row['id']; ?>" style="display:none">
									<button type="button" name="submit_tag" class="btn btn-primary btn-sm margin-top-10" id="submit_tag" onclick="addRating(<?php echo $i; ?>);">Add Tag</button>
								</form>
							</div>						
						</span>
		
						<!-- view -->
						<a href="<?php echo base_url().$row['pdf']; ?>" target="_Blank">
							<i class="fa fa-eye margin-right-15" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View"></i> 
						</a>
						<!-- download -->
						<a href="<?php echo base_url().'download.php?file_source='.$row['pdf']; ?>">
							<i class="fa fa-download margin-right-5" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Download"></i> 
						</a>	
						
					</div>
				</div>
			</div>	
			<?php } } ?>							
		</div>	
		
		
		<div class="row margin-top-20">  	
			<div class="col-md-12 text-right">
			<?php 
				$next = $num + 1; 
				if($num > 1){ $back = $num - 1; }
			?>
			<?php if(isset($back)){ ?>
			<a href="<?php echo base_url().index_page().'new_admin/home/report_templates?id='.$id.'&num='.$back; ?>">
			<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
			</a>
			<?php } ?>
			<a href="<?php echo base_url().index_page().'new_admin/home/report_templates?id='.$id.'&num='.$next; ?>">
			<button class="btn btn-dark btn-outline btn-sm">Next</button>
			</a>
			</div>					
		</div>
		<?php } ?>
	</div>
</div>
		 	 
<?php $this->load->view('new_admin/footer')?>