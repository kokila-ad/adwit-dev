<?php $this->load->view('new_admin/header.php'); ?>

<form role="form" method="post" enctype="multipart/form-data" >		
<div class="row">
		<div class="col-md-6">		
			<div class="caption">
				<span class="font-md font-grey-gallery bold"><h3>Request Form</h3></span>
			</div>
		</div>
		<div class="col-md-6">
			<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
		</div>
	</div>
<hr class="margin-top-10">	
<div class="row margin-top-15">
	<div class="col-md-6">
		<label>Type <span class="font-red">*</span></label>
			<select name="type" class="form-control margin-bottom-15" required>
				<option value="">Select</option>
				<?php foreach($request_type as $rqt_row){ ?>
						<option value = "<?php echo($rqt_row['id'])?>" ><?php echo($rqt_row['name']); ?></option>
				<?php } ?>
			</select>										
		
		
		<label>Date <span class="font-red"></span></label>
			<input type="text" name="date" value ="<?php if(isset($today)){echo $today;}?>" class="form-control margin-bottom-15" >
		
		<label>Upload <span class="font-red"></span></label>
			<input type="file" name="file" class="form-control margin-bottom-15" >	
	</div>

	<div class="col-md-6"> 
		<label>Description <span class="font-red">*</span></label>
			<textarea rows="5" name="message" class="form-control margin-bottom-30" required=""></textarea>
		
		<div class="text-right padding-top-5">
			<button type="submit"  name="submit" onclick="myFunction()" class="btn blue">Submit</button>
		</div>	
	</div>	
</div>
</form>


			
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>