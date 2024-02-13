<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

<div id="main">
<section>
	<div class="container margin-bottom-50">
		<div class="row"> 			
			<div class="col-md-10 col-md-offset-1 text-center">
				<p><?php echo $this->session->flashdata('message'); ?></p>
				<!--<div class="row padding-10"></div>-->
				
				For any questions regarding the payment transaction and for support please
				<a href="http://www.adwitglobal.com/ad-production-services/" style="text-decoration: underline" target="_blank">
				contact us</a> here.
				
			</div>
		</div>
	</div>
</section>
</div>
	
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>			
<?php $this->load->view("lite/footer.php"); ?>
<?php $this->load->view("lite/foot.php"); ?>
 