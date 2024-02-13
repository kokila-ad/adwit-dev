<?php $this->load->view('new_admin/header.php'); ?>

<form role="form" method="post" enctype="multipart/form-data" >							
	<div class="row">
		<div class="col-md-6">		
			<div class="caption">
				<span class="font-md font-grey-gallery bold"><h3>Request Developer</h3></span>
			</div>
		</div>
		<div class="col-md-6">
			<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
			</div>
	</div>
	<hr class="margin-top-10">
	<div class="row margin-top-15">
		<div class="col-md-6">
			<label>Request Id </label>
			<input type="text" name="rqt_id" value="<?php if(isset($rqt_display))echo $rqt_display[0]['id']; ?>"  class="form-control margin-bottom-15">
		</div>
		<div class="col-md-6">	
			<label>Description </label>
			<input type="text" value="<?php if(isset($rqt_display))echo $rqt_display[0]['description']; ?>"  class="form-control margin-bottom-15">														
		</div>
		<div class="col-md-6">
			<label>Connected Tables <span class="font-red">*</span></label>
				<textarea rows="2" name="con_table" class="form-control margin-bottom-15" required=""><?php if(isset($develop_display))echo $develop_display[0]['connected_table'];?>
				</textarea>
			<label>Flow Chart <span class="font-red">*</span></label>
				<input type="file" name="file"  class="form-control margin-bottom-30" required="">	
			<label>Conditions <span class="font-red">*</span></label>
				<textarea rows="2" name="condition" class="form-control margin-bottom-15" required=""><?php if(isset($develop_display))echo $develop_display[0]['conditions']; ?></textarea>
		</div>						
		<div class="col-md-6"> 	
			<label>Actions <span class="font-red">*</span></label>
				<textarea rows="2" name="action" class="form-control margin-bottom-15" required=""> <?php if(isset($develop_display))echo $develop_display[0]['actions']; ?></textarea>
			<label>Pages <span class="font-red">*</span></label>
				<textarea rows="2" name="page" class="form-control margin-bottom-15" required=""><?php if(isset($develop_display))echo $develop_display[0]['pages']; ?></textarea>
			<label>Comments <span class="font-red">*</span></label>
				<textarea rows="2"  name="comment" class="form-control margin-bottom-15" required=""><?php if(isset($develop_display))echo $develop_display[0]['comments'];?></textarea>			
			<div class="text-right padding-top-5">
				<button type="submit"  name="submit" onclick="myFunction()" class="btn blue">Submit</button>
			</div>	
		</div>	
	</div>
</form>


			
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>