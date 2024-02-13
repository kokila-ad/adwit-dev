<?php $this->load->view('india_client/header'); ?>
<link href="<?php echo base_url(); ?>assets/css/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/dropzone/dropzone.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."india_client/home/order_success/".$order_details[0]['id'];?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	});
</script>

  
 <div id="main">
    <section>
      <div class="container margin-top-40 center">                        
			<p class="xlarge">Your order has been placed</p>  
            <div> <span class="border-radius padding-horizontal-70 padding-vertical-5 margin-top-20"> Order No: <a href="#" class="text-red"><?php echo $order_details[0]['id'];?></a></span></div>
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
										<td><a href="#"><?php echo $row; 	$i++; ?></a></td>
										<td><a href="<?php echo base_url().'download.php?file_source='.$order_details[0]['file_path'].'/'.$row; ?>" target="_blank"><i class="fa fa-download"></i></a></td>
										<!--<a href="<?php echo base_url()?>download.php?file_source=<?php echo $row_map; ?>" class="btn btn-circle btn-xs">-->
									 </tr>
								 <?php } } ?> 
								</tbody>
							 </table>
						</div>
					</span>
				</div>
			</div>
			<div>
				<form id="uploadfile" action="<?php echo base_url().index_page().'india_client/home/order_success'.'/'.$orderid; ?>"  class="dropzone"> 
					<div class="col-md-12" id="drag">
						<div class="dz-default dz-message"><span><strong>Choose a file</strong> or drag it here</span></div>
						<?php if(isset($file_sucess)){ echo $file_sucess; } ?>
					</div>
				</form>
					<div class="row float-right margin-top-10">	
						<div class="col-md-12">
							<a href="<?php echo base_url().index_page().'india_client/home'; ?>" name="submit" class="btn btn-primary">Submit</a>
						</div>
					</div>
				
		   </div>	 			
	  </div>
	 </section>
  </div>
 
<?php $this->load->view('india_client/footer'); ?>

