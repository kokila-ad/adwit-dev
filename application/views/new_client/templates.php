<?php $this->load->view('new_client/header'); ?>
<style>        
    iframe.noScrolling{
        width: 100%;
        height: 220px;
        overflow: hidden !important;
    }
    i { color: #444; cursor: pointer;}                   
    i:hover { color: #006599;}                   
</style>
<script>
	function addRating(x) { 
		$.ajax({
		url: "<?php echo base_url().index_page().'new_client/home/add_tag';?>",
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
	
<div id="main">
<section>
	<div class="container margin-vertical-50">  	  
		<div class="row border margin-0">  				
			<div class="col-md-6 col-sm-12 col-xs-12">  
				<p class="center margin-top-20">
				<?php /*	echo $this->session->flashdata('message');
						if(isset($id)){ echo $id; }*/
					if ($this->session->flashdata('message')) {
                        echo '<script>
                            $(document).ready(function() {
                                $("#errorModal").modal("show");
                            });
                        </script>';
					}
				?>
				</p>
			</div> 					

			<div class="col-md-6 col-sm-12 col-xs-12 padding-0 border-left">
				<form method="get" > 
					<div id="search" class="padding-15">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
								<input type="text" name="id" class="form-control border-blue input-sm" title="" placeholder="Enter keywords" required>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
								<input type="text" name="num" value="1" style="display:none">
								<button type="submit" name="search" class="btn btn-blue btn-sm btn-block margin-right-15">Search</button>
							</div>
						</div>	
					</div>
				</form> 
			</div>
		</div>
		<?php if(isset($orders)){ ?>
		<div class="row margin-top-50">  
			<?php $i=0; foreach($orders as $row){ $i++;
					if(file_exists($row['pdf'])){
			?>
			<div class="col-md-4 margin-bottom-20">
				<iframe src="<?php echo base_url().$row['pdf'].'#zoom=-50'; ?>" frameborder="0" width="100%" height="220"></iframe>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6"><span class="text-grey">AdwitAds ID: </span><?php echo $row['id']; ?></div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<a href="<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$row['id']; ?>">
							<i class="fa fa-clipboard margin-right-15" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Pickup"></i> 
						</a>			
						<span class="dropdown">
							<span class="cursor-pointer" type="button" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-tags margin-right-15 cursor-pointer" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="AddTag"></i>
							</span>
																	
							<div class="table-responsive dropdown-menu file_li padding-10 text-right" id="tag_div">	
								<form>
									<input type="text" name="tags" id="tags<?php echo $i; ?>" class="form-control">
									<label id="tags_display<?php echo $i; ?>" class="text-grey">
									<?php 
										$order_tags = $this->db->get_where('order_tags',array('order_id'=>$row['id']))->result_array(); 
										foreach($order_tags as $row_tag){
											$tag = $this->db->get_where('tags',array('id'=>$row_tag['tag_id']))->row_array();
											echo $tag['title'].' ';	
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
			<a href="<?php echo base_url().index_page().'new_client/home/templates?id='.$id.'&num='.$back; ?>">
			<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
			</a>
			<?php } ?>
			<a href="<?php echo base_url().index_page().'new_client/home/templates?id='.$id.'&num='.$next; ?>">
			<button class="btn btn-dark btn-outline btn-sm">Next</button>
			</a>
			</div>					
		</div>
		<?php } ?> 
	</div>
</section>
</div>

<style>
    .modal-backdrop {
    display:none;
}

</style>
<!-- Modal -->
<div class="modal" id="errorModal" tabindex="-1"  role="dialog" aria-labelledby="confirmationModalTitle" >
 <div class="modal-dialog modal-dialog-centered" role="document" style="width:700px;">
    <div class="modal-content" style="width:85%">
      <div class="modal-header" style="border-bottom: 0 !important;background-color:#333 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="errorModal" style="margin-top: 0px !important; padding:10px !important;"><center><b>Alert</b></center></h5>
      </div>
      <div class="modal-body" style="padding: 15px 16px;">
          <h4 style="color:#900;"><?php echo $this->session->flashdata('message')?></h4>
      </div>
      <div class="modal-footer" style="background-color:#fff !important;">
        <button type="button" class="btn btn-warning" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>