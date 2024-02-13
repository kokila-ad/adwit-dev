<?php $this->load->view('new_admin/header')?>

<!--print ad start-->				
	
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="col-md-12 margin-bottom-15">			
			<div class="caption font-red"><?php echo $this->session->flashdata('message'); ?></div>
		</div>
			<form name="form" method="post" enctype="multipart/form-data">
				<div class="">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Unique Job Name</label>
								<input type="text" name="job_name" type="text" autocomplete="off" class="form-control" required="required">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Advertiser Name</label>
							<input type="text" name="advertiser" autocomplete="off" class="form-control" required="required">
						</div>
					</div>
					<div class="col-md-6">
						<label class="control-label">Publication</label>
						<select id="publication_id" name="publication_id" class="select2me form-control margin-bottom-5">
							<option value="">Select</option>
							<?php foreach($publications as $p_row) { ?>
							<option value="<?php echo $p_row['id']?>"><?php echo $p_row['name']; ?></option>
							<?php } ?>
						</select>
					 </div>
					<div class="col-md-6">
						<div class="form-group">
						<label class="control-label">Adrep</label>	
						<select id="adrep_id" name="adrep_id" class="select2me form-control margin-bottom-5">
							<option value="">Select</option>
							<?php foreach($adreps as $a_row) { ?>
							<option value="<?php echo $a_row['id']?>"><?php echo $a_row['first_name'].' '.$a_row['last_name']; ?></option>
							<?php } ?>
						</select>
						</div>
					 </div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Width<small> (In inches) </small></label>
							<input type="number" step="0.0001" min=0 id="width" name="width" autocomplete="off" onchange="handleChange(this);" class="form-control" required="required">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Height<small> (In inches) </small></label>
							<input type="number" step="0.0001" min=0 id="height" name="height" autocomplete="off" onchange="handleChange(this);" class="form-control" required="required">
						</div>
					</div>
					<div class="col-md-6">
						 <div class="form-group">
						  <label for="exampleInputFile1">Upload File</label>
						  <input type="file" name="file" class="form-control" id="file" value="upload" />
						 </div>
					 </div>
					<div class="col-md-6">
						 <div class="form-group">
							<label class="control-label">Project</label>
						<select id="project_id" name="project_id" class="select2me form-control margin-bottom-5">
							<option value="">Select Project</option>
							<?php foreach($pub_project as $pro_row) { ?>
							<option value="<?php echo $pro_row['id']?>"><?php echo $pro_row['name']; ?></option>
							<?php } ?>
						</select>
					 </div>
					 </div>
				</div>
				<div class="pull-right margin-top-20">
					<a  onclick="goBack()" type="button" class="btn default">Cancel</a>
					<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		<!-- END FORM-->
	</div>	

<!--print ad end-->	

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/foot')?>