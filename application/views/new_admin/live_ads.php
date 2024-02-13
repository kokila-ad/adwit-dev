<?php $this->load->view('new_admin/header.php'); ?>
<style>
.btn-hover-dark:hover { background-color: #333333 !important; color: #ffffff !important;}
</style>

<div class="portlet light">
	<div class="portlet-body">		
		<div class="row">
		<div class="col-md-6 ">	
			<div class="row margin-bottom-10 margin-top-15">
				<div class="col-sm-3 padding-right-0 margin-bottom-10">	
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/revision_frontlinetrack';?>">
					<button type="submit" name="revision" class="btn btn-block btn-hover-dark border-radius-5 bg-grey">Revision</button>
				</form>
				</div>
			
				<div class="col-sm-3 padding-right-0 margin-bottom-10">	
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/new_ads';?>">
					<button type="submit" name="new_ads" class="btn btn-block btn-hover-dark border-radius-5 bg-grey">New Ads</button>
				</form>
				</div>
				
				<div class="col-sm-3 padding-right-0 margin-bottom-10">	
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/revision_others';?>">
					<button type="submit" name="new_ads" class="btn btn-block btn-hover-dark border-radius-5 bg-grey">Others</button>
				</form>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

<?php $this->load->view('new_admin/footer.php'); ?>