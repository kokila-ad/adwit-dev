<?php $this->load->view('new_csr/head'); ?>

<!-- BEGIN PAGE CONTAINER -->
 
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			
				<div class="col-md-12">
					<div class="portlet light">
					<div class="row">
						<div class="col-md-6">
							Publication Name: <?php echo $publication_details[0]['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						<div class="col-md-6 text-right">
							Adrep Name: <?php echo $adrep_details[0]['first_name']; ?> <?php echo $adrep_details[0]['last_name']; ?>
						</div>
					</div>
					<div class="row margin-top-20">
						<?php echo $this->session->flashdata('message');?>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form name="form" method="post" enctype="multipart/form-data" class="horizontal-form">
								<div class="form-body">
									<center><input type="file" name="upload_multiple" required>Upload xlsx File</center>
								</div>
								<div class="form-actions right">
									<a  onclick="goBack()" type="button" class="btn default">Cancel</a>
									<button type="submit" name="submit" class="btn blue">Submit</button>
								</div>
							</form>
							<!-- END FORM-->
						</div>
					</div>
					<a href="<?php echo base_url(); ?>assets/xlsx_files/header_format.xlsx">**xlsx file header format</a>
				</div>
			</div>
		</div>
	</div>
</div>



<?php $this->load->view('new_csr/foot'); ?>




