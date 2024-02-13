<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.flashmsg {

    background-color: #dff0d8;
    border: 1px solid #c4d4be;
    padding: 5px 15px 5px 15px;

}
</style>
<?php $this->load->view('new_client/header') ?>
	<div class="container margin-top-50 margin-bottom-20"> 
		<div class="row ">
			<div class="col-md-4 col-sm-4 col-xs-12 ">
				<p>Unique Job Name/Number: <b><?php echo $pagedesignId['id'];?></b></p>
				
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 text-center">
				<p>Page Number: 
					<b>
					<?php 
						foreach ($pagesId as $pagid){
							echo $pagid['job_no'].",  ";
						}
					?>
					</b>
				</p>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 text-right">
				<p>
				    Publish Date : <b><?php echo $pagedesignId['publish_date']; ?></b> 
				</p>
			</div>
		</div>	 
	</div>
	<div class="middl">
		<div class="container">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8 padding-division">
					<div class="text-center ">
						<form> 
							<p class="flashmsg"><?php echo $this->session->flashdata('item');?></p>
							<!-- <pre class="text-red">Your order successflly submitted.</pre> -->	
						</form>
					</div>
				</div>
				<div class="col-sm-2"></div>	
			</div>
		</div>
	</div>
<?php $this->load->view('new_client/footer') ?>