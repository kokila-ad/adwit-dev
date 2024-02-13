<?php $this->load->view("lite/head.php"); ?>
<?php //$this->load->view("lite/header.php"); ?>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="<?php echo base_url(); ?>assets/lite/css/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/lite/js/dropzone/dropzone.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <!--<script>
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."lite/home/order_assets";?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	   
	});
 </script>
--> 
<div id="main">
<section>
	<div class="container margin-top-20">   
		<!--<div class="row">				
			<div class="col-md-12 padding-bottom-5 text-right">
			
				<span class="dropdown">
					<span class="cursor-pointer" type="button" data-toggle="dropdown" id="view">View Uploaded Files<span class="caret"></span></span>	 
						<div class="table-responsive dropdown-menu file_li " id="show">  							 
							<p class="text-right padding-right-10"><small><a id="refresh-btn"><i class="fa fa-refresh"></i></a></small></p>	
													
	 
							<table class="table table-striped table-hover" id="mytable">
							<tbody>
							<?php if(isset($file_names)) { $i=1;  foreach($file_names as $row)  { ?>
									<form method="post" action="<?php echo base_url().index_page().'lite/home/delete_file'; ?>">
										<tr>
											<td><?php echo $i; ?></td>
											<td><a href="#"><?php echo $row; $i++; ?></a></td>
											<td>
												<input type="text" name="order_id" value="<?php echo $order_id; ?>" style="display:none;">
												<input type="text" name="file_name" value="<?php echo $row; ?>" style="display:none;">
												<button type="submit" name="submit"><i class="fa fa-trash"></i></button>
											</td>
										</tr>
									</form>
							<?php } }?>									
							</tbody>
							</table>
						</div>
				</span>
				
			</div>
		</div>-->
			
		<div class="row">
			<div class="col-md-12 margin-top-5">
				<form action="<?php echo site_url('/lite/home/dragdrop'); ?>" class="dropzone" >
					<div class="dz-default dz-message"><span><strong>Choose a file</strong> or drag it here</span></div>
				</form>
				<form method="post"> 
					<div class="row margin-top-20">
						<div class="col-md-2 col-md-offset-10 margin-bottom-10">
						 <button type="submit" class="btn btn-primary btn-lg margin-right-15 btn-block" name="order_submit">  <span>Finish</span> </button>
						</div>		
					</div>	
				</form>
			</div>
			<div class="col-md-12 margin-top-15">
				
			</div>  
		</div>
	</div>
</section>
</div>	<!-- /main -->
			
<?php //$this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>
 
