<?php $this->load->view('new_admin/header')?>
<script type="text/javascript">
	$(document).ready(function(){	  
		$(".dropdown-checkboxes").hide();	
		$('.date-picker').click(function() {
			$(".cursor-pointer").addClass(" filter ");
		});	
		$('#filter').click(function() {
			$(".dropdown-checkboxes").toggle();
		});
		
		$('#filter1').click(function() {
			$(".dropdown-checkboxe").toggle();
		});
				
		$('#filter2').click(function() {
			$(".dropdown-checkboxess").toggle();
		});
	});
</script>
<script>
	function addRating(x) { 
		$.ajax({
		url: "<?php echo base_url().index_page().'new_admin/home/template_add_tag';?>",
		data:'id='+$('#order_id'+x).val()+'&tags='+$('#tags'+x).val(),
		type: "POST",
		success:	function(msg){
						jQuery('#tags_display'+x).html(msg);
					} 
		});
		//refresh div
		$('#tags'+x).val("");
		
	}
</script>
			<div class="portlet light">
				<div class="row">	
					<div class="col-md-6 col-xs-12 margin-bottom-5">
						<a href="<?php echo base_url().index_page().'new_admin/home/manage'; ?>" class="font-lg">Manage</a> - 
						<u class="font-lg font-grey-gallery">Template GM</u>
					</div>							
					
					<div class="col-md-6 col-xs-4 margin-bottom-5 text-right">				
						
						
						<?php echo $this->session->flashdata('message'); ?>	
						<?php if(isset($id)){ ?>
						<form method="get">
							<div class="btn-group left-dropdown">
								<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true" id="filter2">
									<i class="fa fa-filter fa-2x"></i>
								</span>
								
								<div class="dropdown-menu hold-on-click dropdown-checkboxess padding-10" role="menu">
									<?php $template_bank_sizes = $this->db->query("SELECT * FROM `template_bank_sizes`")->result_array(); ?>
										<div class="text-right margin-top-10">
											<input type="text" name="num" value="1" style="display:none">
											<input type="text" name="id" value="<?php echo $id; ?>" style="display:none">
										</div>
										<label class="margin-bottom-5">
										<input name="size_id" value="all" <?php if($size_id == 'all') echo 'checked';?> type="radio" class="margin-right-5">All</label><br>				
										<?php foreach($template_bank_sizes as $t_row) { ?>
										<label><input type="radio" name="size_id" value="<?php echo $t_row['id']; ?>" 
										<?php if($size_id == $t_row['id']){ echo "checked='checked'";}?>class="margin-right-5"><?php echo $t_row['name'] ;?></label><br>
										<?php //echo $size_id.' - '.$t_row['id']; ?>
										<?php } ?>
										<div class="text-right"> 
											<button type="submit" class="btn bg-grey-gallery padding-5 btn-sm"> Submit</button>
										</div>		
								</div><?php } ?>
								<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
							</div>	
						</form>	
					</div>				
				</div>
				<div class="portlet-body">
					<div class="row report margin-0 border-top border-bottom">
					<?php $template_bank = $this->db->query("SELECT * FROM `template_bank`")->result_array(); ?>
						<div class="col-md-4 col-sm-6 report-tab">
							<h3 class="font-blue margin-top-15 margin-bottom-5"><?php echo count($template_bank); ?></h3>
							<p class="font-grey-gallery margin-0">Total No Of Templates</p>
						</div>
						<div class="col-md-4 col-sm-6 report-tab padding-right-20">
							<form method="get" > 
								<div class="input-group margin-top-25">
									<input type="text" name="id" class="form-control" placeholder="Enter Tag" required/>
									<span class="input-group-btn">
									<input type="text" name="num" value="1" hidden>
									<input type="text" name="size_id" value="all" style="display:none">
									<button type="submit" name="search" class="btn bg-grey-gallery" type="button">Search</button>
									</span>
								</div>
								<p class="font-grey-gallery margin-top-5"><?php echo $this->session->flashdata('t_message');
								if(isset($id)){ echo $id; } ?></p>
							</form>
						</div>
						 
						<div class="col-md-4 col-sm-6 report-tab padding-left-40">
							<div class="row margin-top-15">
									<div class="col-md-8 col-md-offset-2">
									<form method="post" action="<?php echo base_url().index_page().'new_admin/home/template_multiple_image'; ?>" enctype="multipart/form-data">
										<div class="btn-group btn-block left-dropdown margin-top-5 margin-bottom-10">
											<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
												<button class="btn default btn-block" id="filter1"><i class="fa fa-upload fa-2x"></i> Upload Images</button>
											</div>
											<div class="dropdown-menu hold-on-click dropdown-checkboxe padding-10" role="menu">
												<input type="file" name="img_url" multiple class="form-control margin-bottom-10">
												<div class="text-right margin-top-10">
													<button type="submit" class="btn btn-primary btn-sm">Submit</button>
												</div>													
											</div>
										</div>	
									</form>	
										<button class="btn default btn-block"><i class="fa fa-gear fa-2x"></i> Settings</button>
									</div>
								</div>
						</div>
					</div> 
				</div>
			</div>
		 	
			<div class="col-md-12 imagebank">		 	 
				<div class="row margin-0">
				<?php if(isset($templates)){
					$i=0; foreach($templates as $sql){ $i++; 
					//$sql = $this->db->get_where('template_bank', array('id' => $template_id['template_bank_id']))->row_array();
					//$sql = $this->db->query("SELECT * FROM `template_bank` WHERE `id` = '".$template_id['template_bank_id']."'")->result_array();
					?>
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
												<label id="tags_display<?php echo $i; ?>" class="text-grey">
											<!-- <?php 
													//$order_tags = $this->db->get_where('template_bank_tag',array('template_bank_id'=>$sql['id']))->result_array(); 
													//foreach($order_tags as $row_tag){
														//$tag = $this->db->get_where('template_tags',array('id'=>$row_tag['tag_id']))->row_array();
														//echo $tag['name'].' , ';	
													//}
												?> -->
												</label>
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
									<!--<a href="<?php echo 'download.php?file_source='.$sql['url']; ?>">
										<i class="fa fa-download margin-right-5" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Download"></i> 
									</a>-->
								</div>
							</div>
						</div>
				<?php } } ?>						
				</div>
			</div>  
		
				<!--<div class="row margin-top-20">  	
					<div class="col-md-12 text-right">
						<?php if(isset($num) && isset($id)){
							$next = $num + 1; 
							if($num > 1){ $back = $num - 1; }
						?>
						<?php if(isset($back)){ ?>
						<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM?id='.$id.'&num='.$back; ?>">
							<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
						</a>
						<?php } ?>
						<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM?id='.$id.'&num='.$next; ?>">
							<button class="btn btn-dark btn-outline btn-sm">Next</button>
						</a><?php } ?>
					</div>					
				</div>-->

		<div class="row margin-top-20">  	
			<div class="col-md-12 text-right">
				<?php if(isset($num) && isset($id) && isset($size_id)){
					$next = $num + 1; 
					if($num > 1){ $back = $num - 1; }
				?>
				<?php if(isset($back)){ ?>
					<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM?id='.$id.'&num='.$back.'&size_id='.$size_id; ?>">
					<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
					</a>
				<?php }if($templates_count >= $rowsPerPage) { ?>
					<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM?id='.$id.'&num='.$next.'&size_id='.$size_id; ?>">
					<button class="btn btn-dark btn-outline btn-sm">Next</button>
					</a>
				<?php } }elseif(isset($num) && isset($id)){
					$next = $num + 1; 
					if($num > 1){ $back = $num - 1; }
				?>
				<?php if(isset($back)){ ?>
					<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM?id='.$id.'&num='.$back; ?>">
					<button class="btn btn-dark btn-outline btn-sm margin-right-5">Back</button>
					</a>
				<?php }if($templates_count >= $rowsPerPage) { ?>
					<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM?id='.$id.'&num='.$next; ?>">
					<button class="btn btn-dark btn-outline btn-sm">Next</button>
					</a>
				<?php } } ?>
			</div>					
		</div>
<?php $this->load->view('new_admin/footer')?>