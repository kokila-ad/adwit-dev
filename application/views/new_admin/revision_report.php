<?php $this->load->view('new_admin/header.php'); ?>

	
<div class="page-content">
	<div class="container">
		<div class="row margin-top-15">
			<form method="get">
				<div class="row margin-bottom-15">
					<div class="col-md-6">
						<p class="margin-bottom-5">Select Date Range<span class="text-red">*</span></p>	 
						<div class="input-group date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd"  data-date-end-date="+0d">
								<input type="text" class="form-control border-radius-left" name="from" value="<?php if(isset($from))echo $from; ?>" placeholder="From Date" required/>
								<span class="input-group-addon">
								to </span>
								<input type="text" class="form-control border-radius-right" name="to" value="<?php if(isset($to))echo $to; ?>" placeholder="To Date" required/>
						</div>
						<button type="submit" name="search" class="mob_hide btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
			</form>
			<?php if(isset($count)){ ?>
			<h4>V1 Count : <b><?php echo $count; ?></b></h4>
			<?php } ?>
		</div>
	</div>
</div>

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>
