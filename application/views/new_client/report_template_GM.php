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
		url: "<?php echo base_url().index_page().'new_client/home/template_add_tag';?>",
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
		
		<?php if(isset($id)){ ?>	
			<!-- <div class="row margin-top-30">
			<?php $template_bank_sizes = $this->db->query("SELECT * FROM `template_bank_sizes`")->result_array();
				foreach($template_bank_sizes as $t_row) { ?>
				<div class="col-md-2 col-sm-3 col-xs-6">
					<form method="get">
						<input type="text" name="num" value="1" style="display:none">
						<input type="text" name="id" value="<?php echo $id; ?>" style="display:none">
						<input type="text" name="size_id" value="<?php echo $t_row['id']; ?>" style="display:none">
						<button type="submit" name="template_bank_sizes" class="btn default btn-block margin-bottom-10"><?php echo $t_row['name'] ;?></button>
					</form>
				</div><?php } ?>
			</div> -->
		<?php } ?>
		
		<div class="row">
			<div class="col-md-12 imagebank">		 	 
				<div class="row  margin-top-30">
				<?php if(isset($templates)){ $i=0; foreach($templates as $sql){ $i++; ?>
					<div class="col-md-4 col-sm-3 col-xs-6 margin-bottom-15">
						<iframe class="border" src="<?php echo $sql['url'].'#zoom=-50'; ?>" frameborder="0" width="100%" height="220"></iframe>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6"><span class="text-grey">ID:</span> <?php echo $sql['id']; 
							?> </div>
							
							<div class="col-md-6 col-sm-6 col-xs-6 text-right"> 
								<span class="dropdown">
									<span class="cursor-pointer" type="button" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-tags margin-right-15 cursor-pointer" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="AddTag"></i>
									</span>
																
									<div class="table-responsive dropdown-menu file_li padding-10 text-right"> 
										<form>
											<input type="text" name="tags" id="tags<?php echo $i; ?>" class="form-control">
											<label id="tags_display<?php echo $i; ?>" class="text-grey"></label>
											<input type="text" name="order_id" id="order_id<?php echo $i; ?>" value="<?php echo $sql['id']; ?>" style="display:none">
											<button type="button" name="submit_tag" class="btn btn-primary btn-sm margin-top-10" id="submit_tag" onclick="addRating(<?php echo $i; ?>);">Add Tag</button>
										</form>
									</div>						
								</span>
				
								<!-- view -->
								<a href="<?php echo $sql['url']; ?>" target="_Blank">
									<i class="fa fa-eye margin-right-15" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View"></i> 
								</a>
								<!-- download -->
							<!--	<a href="<?php echo base_url().'download.php?file_source='.$sql['url']; ?>">
									<i class="fa fa-download margin-right-5" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Download"></i> 
								</a>	-->
								
							</div>
						</div> 
					</div>
				<?php } ?>						
				</div>
			</div>
		</div><?php } ?>
		 
		<div class="row margin-top-20">  	
			<div class="col-md-12 text-right">
				<?php if(isset($num) && isset($id) && isset($size_id)){
					$next = $num + 1; 
					if($num > 1){ $back = $num - 1; }
				?>
				<?php if(isset($back)){ ?>
					<a href="<?php echo base_url().index_page().'new_client/home/report_template_GM?id='.$id.'&num='.$back.'&size_id='.$size_id; ?>">
					<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
					</a>
				<?php }if($templates_count >= $rowsPerPage) { ?>
					<a href="<?php echo base_url().index_page().'new_client/home/report_template_GM?id='.$id.'&num='.$next.'&size_id='.$size_id; ?>">
					<button class="btn btn-dark btn-outline btn-sm">Next</button>
					</a>
				<?php } }elseif(isset($num) && isset($id)){
					$next = $num + 1; 
					if($num > 1){ $back = $num - 1; }
				?>
				<?php if(isset($back)){ ?>
					<a href="<?php echo base_url().index_page().'new_client/home/report_template_GM?id='.$id.'&num='.$back; ?>">
					<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
					</a>
				<?php }if($templates_count >= $rowsPerPage) { ?>
					<a href="<?php echo base_url().index_page().'new_client/home/report_template_GM?id='.$id.'&num='.$next; ?>">
					<button class="btn btn-dark btn-outline btn-sm">Next</button>
					</a>
				<?php } } ?>
			</div>					
		</div>
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