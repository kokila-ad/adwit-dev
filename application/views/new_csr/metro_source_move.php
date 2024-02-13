<?php $this->load->view("new_csr/head.php"); ?>
<style>
.padding-0{
	padding: 0px;
}
.margin-top-5 {
	margin-top: 5px;
}
</style>
<div class="page-container">

	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE BREADCRUMB -->
			
			<!-- END PAGE BREADCRUMB -->
			<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>
			        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						
						<div class="portlet-body row" id="help_desk" name="help_desk">			
						<div class="col-md-12">						
							<div class="row">	
							
								<div class="col-md-3 col-sm-4 margin-bottom-10 margin-left-10">
									<form method="post">
										<input type="submit" name="move_source" value="Move Source" />
									</form>
									<!--<a href="<?php echo base_url.index_page().'new_csr/home/metro_source_move';?>" class="btn btn-success btn-block btn-lg m-icon-big row no-margin">
										<div class="col-md-10 col-sm-10 col-xs-10 padding-0">Move Source	</div>
										<div class="col-md-2 col-sm-2 col-xs-2 padding-0 text-right"><i class="m-icon-swapright m-icon-white margin-top-5"></i></div>											
									</a>-->		
								</div>
								
							
							</div>	
						</div>															
					</div>
						
						
						
					</div>
				</div>
                </div>
			

		</div>
	</div>
</div>
<?php $this->load->view("new_csr/foot.php"); ?>
