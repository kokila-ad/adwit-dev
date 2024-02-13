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
			<ul class="page-breadcrumb breadcrumb hide">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Dashboard
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>
			        <div class="row" <?php if(isset($form)) echo "hidden";  ?>>
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Select your desk</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse" data-original-title="" title="">
								</a>

							</div>
						</div>
						
						
						<div class="portlet-body row" id="help_desk" name="help_desk">			
						<div class="col-md-12">						
							<div class="row">	
							<?php 
							$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
							foreach($types as $type)
							{ ?>
								<div class="col-md-3 col-sm-4 margin-bottom-10 margin-left-10">
									<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_order_list/'.$type['id']?>" class="btn btn-success btn-block btn-lg m-icon-big row no-margin">
										<div class="col-md-10 col-sm-10 col-xs-10 padding-0"><?php echo $type['name']; ?>	</div>
										<div class="col-md-2 col-sm-2 col-xs-2 padding-0 text-right"><i class="m-icon-swapright m-icon-white margin-top-5"></i></div>											
									</a>		
								</div>
							<?php }?>	
							
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
<script>
    $(document).ready(function () {
    localStorage.removeItem('selected_display');
    localStorage.removeItem('selected_date');
});
</script>