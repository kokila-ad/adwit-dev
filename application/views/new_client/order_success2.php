<?php $this->load->view('new_client/header'); ?>


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
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."new_client/home/order_success/".$order_details[0]['id'];?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	});
</script>

  
 <div id="main">
    <section>
      <div class="container margin-top-40 center">                        
			<p>Your order has been placed</p>  
            <div> <span class="border-radius padding-horizontal-70 padding-vertical-5 margin-top-20"> AdwitAds Id: <a href="#" class="text-red"><?php echo $order_details[0]['id'];?></a></span></div>
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
										<td>
											<a href="<?php echo base_url().'download.php?file_source='.$order_details[0]['file_path'].'/'.$row; ?>" target="_blank"><i class="fa fa-download"></i></a>
										</td>
										<td>
											<form method="post" action="<?php echo base_url().index_page().'new_client/home/newad_remove_att';?>">
												<input type="hidden" name="filepath" value="<?php echo $order_details[0]['file_path']; ?>">
												<input type="hidden" name="filename" value="<?php echo $row; ?>">
												<input type="hidden" name="adwitadsid" value="<?php echo $order_details[0]['id']; ?>">
												<button type="submit" name="remove_att" id="remove" class="btn btn-outline padding-0" 
												style="background-color: #f9f9f9;margin-top: -4px;color: #1b1b1b;"><i class="fa fa-close"></i></button>
											</form>
										</td>
									</tr>
								 <?php } } ?> 
								</tbody>
							 </table>
						</div>
					</span>
				</div>
			</div>
			<div>
				<form id="uploadfile" action="<?php echo base_url().index_page().'new_client/home/order_success'.'/'.$orderid; ?>"  class="dropzone"> 
					<?php if(isset($file_sucess)){ echo $file_sucess; } ?>
					<div class="dz-default dz-message margin-top-70">You can attach or drag files here</div>
				</form>
			</div>
			 </div>
	</section>
	<section>
      <div class="container margin-top-40">  
				<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_success'.'/'.$orderid; ?>">
					<div class="row">				
						<div class="col-md-12 margin-bottom-15">
							<table class="table table-striped table-bordered table-hover" id="mytable">
								<tbody>
									<?php $mood_board = $this->db->query("SELECT * FROM `mood_board`;")->result_array(); ?>
										<h4>Select a theme (below) for your ad. Or if you have another, drop it in the box (above).</h4>
									<?php if(isset($mood_board)) { ?>
									<tr>
										<?php foreach($mood_board as $row){?>
										<th><input type="radio" name="mood_board" value="<?php echo $row['id'];?>"><?php echo ' '.$row['name'];?></th><?php } ?>
									</tr>
									<tr>
										<?php foreach($mood_board as $row){?>
										<td><image src="<?php echo base_url().$row['path'];?>" height="100%" width="100%"></td><?php } ?>
									</tr>
									<?php }	?>
								</tbody>
							</table>
						</div>
					</div>
				
				<div class="row float-right margin-top-10">	
					<div class="col-md-12">
						Please wait for all files to upload before submitting.
						<button type="submit" name="submit" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
						<!--<a href="<?php echo base_url().index_page().'new_client/home'; ?>" name="submit" class="btn btn-blue">Submit</a>-->
					</div>
				</div>
				</form>
		</div>
	 </section>
	 
  </div>
 
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
