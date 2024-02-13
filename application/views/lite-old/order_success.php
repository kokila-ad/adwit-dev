<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<script>
function myFunction() {
    location.reload();
}
</script>

<style>
.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}
</style>

<script>
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."lite/home/order_success/".$order_details[0]['id'];?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	});
</script>

  
 <div id="main">
    <section>
      <div class="container margin-top-40 center">                        
			<p>Your order has been placed</p>  
            <div> <span class="border-radius padding-horizontal-70 padding-vertical-5 margin-top-20"> AdwitAds ID: <a href="#" class="text-red"><?php echo $order_details[0]['id'];?></a></span></div>
		<?php echo $this->session->flashdata('message'); ?>
	  </div><!-- /.container-->
	</section><!-- /section -->
  
 	 <section>
		<div class="container margin-top-60">     
			<div class="row">				
				<div class="col-md-12 margin-bottom-15 text-right">
					<span class="dropdown">
						<a class="cursor-pointer" type="button" data-toggle="dropdown" id="view">View Uploaded Files<span class="caret"></span></a>
						<div class="table-responsive dropdown-menu file_li " id="show"> 
							<table class="table table-striped table-hover" id="mytable">
								 <tbody>
								 <?php if(isset($file_names)) { $i=1;  foreach($file_names as $row) { ?>
									 <tr>
										<td><?php echo $i ?></td>
										<td><a href="<?php echo base_url().'downloads/'.$order_details[0]['id'].'-'.$order_details[0]['job_no'].'/'.$row;?>" target="_blank"><?php echo $row; 	$i++; ?></a></td>
										<td><a href="<?php echo base_url().'download.php?file_source='.$order_details[0]['file_path'].'/'.$row; ?>" target="_blank"><i class="fa fa-download"></i></a></td>
									</tr>
								 <?php } } ?> 
								</tbody>
							 </table>
						</div>
					</span>
				</div>
			</div>
			<div>
				<form id="uploadfile" action="<?php echo base_url().index_page().'lite/home/order_success'.'/'.$orderid; ?>"  class="dropzone margin-350 drag-bg dz-clickable dz-started"> 
					<?php if(isset($file_sucess)){ echo $file_sucess; } ?>
					<div class="dz-default dz-message margin-top-70">You can attach or drag files here</div>
				</form>
					<div class="row float-right margin-top-10">	
						<div class="col-md-12">
							<span>Please wait for all files to upload before submitting.</span>
							<a href="<?php echo base_url().index_page().'lite/home/dashboard'; ?>" name="submit">
							<button type="submit" name="submit" class="btn btn-danger btn-sm">Order Now</button>
							</a>
							<!--
							<small class="text-grey">(Cancel order)</small>
							<a href="<?php echo base_url().index_page().'lite/home/dashboard'; ?>" name="submit" class="btn btn-blue">Submit</a>
							-->
						</div>
					</div>
				
		   </div>	 			
	  </div>
	 </section>
  </div>
 <?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>	