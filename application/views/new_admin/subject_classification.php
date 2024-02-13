<?php $this->load->view('new_admin/header.php'); ?>

<div class="portlet light">
	<div class="portlet-body">		
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				<div class="form-group has-success"></div>
				<form id="report-form" method="get">
				<div class="row margin-bottom-15">
					<div class="col-md-4 " >
						 <select id="type" class="colorselector form-control " name="id" required>
							<option value="">Select</option>
							<option value="ALL" <?php if(isset($id) && $id == "ALL")echo'selected'; ?>>ALL</option>
							<?php foreach($publications as $pub){ ?>
							<option value="<?php echo $pub['id']; ?>" <?php if(isset($id) && $pub['id'] == $id)echo'selected'; ?> ><?php echo $pub['name']; ?></option>
							<?php } ?>
						 </select>
					</div>
					<div class="col-md-6" id="year-box">
						<div  class="input-group  date-picker input-daterange "  data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
							<input type="text" class="form-control border-radius-left" name="from" <?php if(isset($from))echo"value='$from'"; ?> placeholder="From Date" required/>
							<span class="input-group-addon"> to </span>
							<input type="text" class="form-control border-radius-right" name="to" <?php if(isset($to))echo"value='$to'"; ?> placeholder="To Date" required/>
						</div>
					</div>
					<div class="col-md-2 pull-right">
						<button type="submit"  class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
<?php if(isset($output)){ if(!isset($output[0]['subject']))echo"No Data Available For This Publication..!!"; ?>
	<div class="portlet-body " >
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				
			</div>
		</div>
		<div class="margin-top-15">
		
			<table class="table table-bordered table-hover" >
				<tbody>
				<?php foreach($output as $row){ 
					echo'<tr>';
					
						echo '<td>'.$row['subject'].'</th>';
						echo '<td>'.$row['ad_count'].'</td>';
					 	
					echo '</tr>';
				} ?>
				</tbody>
				
			</table>
		
		</div>
	</div>
<?php } ?>	
</div>
	 
<script>

$('#select_year').on('change',function(){
	var value = $(this).val();
	if(value != '') {
		$('form#report-form').submit();
	}
});
</script>	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

