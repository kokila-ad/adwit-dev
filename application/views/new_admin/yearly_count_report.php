<?php $this->load->view('new_admin/header.php'); ?>
<style>
	.option-theme5 {
		border: 1px solid #444d58 !important;
		color: #444d58 !important;
	}
	
	.option-theme5:hover, .active .option-theme5 {
		background-color: #444d58;
		color: #fff !important;
	}
	.only_mob{
		display: none;
	}
	.mob_hide{
		display: block;
	}
	@media only screen and (max-width: 500px){
		.only_mob{
			display: block;
		}
		.mob_hide{
			display: none;
		}
	}
</style>
<?php
$curr = date("Y"); 
$prev = date("Y",strtotime("-1 year")); 
$pprev = date("Y",strtotime("-2 year")); 
?>
<div class="portlet light">
<?php if(!isset($order_count)){ ?>
	<div class="portlet-body">		
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group has-success"></div>
				<form id="report-form" method="get">
				<div class="row">
					<div class="col-md-12 col-md-offset-1 margin-bottom-15" >
						 <select id="order_type" class="colorselector form-control " name="order_type">
							<option value="new">New</option>
							<option value="revision">Revision</option>
						 </select>
					</div>
					<div class="col-md-12 col-md-offset-1" >
						 <select id="group" class="colorselector form-control" name="group">
							<option value="">Select GROUP</option>
							<option value="all">All</option>
							<?php foreach($groups as $group){ ?>
							<option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
							<?php } ?>
						 </select>
					</div>
					<div class="col-md-12 col-md-offset-1 margin-top-15" id="year-box" style="display:none">
						 <select id="select_year" class="colorselector form-control " name="select_year">
							<option value="">Select YEAR</option>
							<option value="<?php echo $curr; ?>"><?php echo $curr; ?></option>
							<option value="<?php echo $prev; ?>"><?php echo $prev; ?></option>
							<option value="<?php echo $pprev; ?>"><?php echo $pprev; ?></option>
						 </select>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>	
<?php }else{ ?>	
	<div class="portlet-body " >
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				<div class="form-group has-success"></div>
				<form id="report-form" method="get">
				<div class="row">
					<div class="col-md-4 " >
						 <select id="group" class="colorselector form-control" name="group">
							<option value="">Select GROUP</option>
							<option value="all" <?php if($group_id == 'all')echo"selected"; ?>>All</option>
							<?php foreach($groups as $group){ ?>
							<option value="<?php echo $group['id']; ?>" <?php if($group['id'] == $group_id)echo"selected"; ?>>
								<?php echo $group['name']; ?>
							</option>
							<?php } ?>
						 </select>
					</div>
					<div class="col-md-3 " id="year-box" >
						 <select id="select_year" class="colorselector form-control " name="select_year">
							<option value="">Select YEAR</option>
							<option value="<?php echo $curr; ?>" <?php if($curr == $select_year)echo"selected"; ?>><?php echo $curr; ?></option>
							<option value="<?php echo $prev; ?>" <?php if($prev == $select_year)echo"selected"; ?>><?php echo $prev; ?></option>
							<option value="<?php echo $pprev; ?>" <?php if($pprev == $select_year)echo"selected"; ?>><?php echo $pprev; ?></option>
						 </select>
					</div>
					<div class="col-md-2 " >
						 <select id="order_type" class="colorselector form-control " name="order_type">
							<option value="new" <?php if($order_type == 'new')echo"selected"; ?>>New</option>
							<option value="revision" <?php if($order_type == 'revision')echo"selected"; ?>>Revision</option>
						 </select>
					</div>
					<div class="col-md-3 " id="year-box" >
					    <button type="submit">SUBMIT</button>
					</div>
				</div>
				</form>
			</div>
		</div>
		<div class="margin-top-15">
		<?php if($group_id == 'all'){ ?>
		
			<table class="table table-bordered table-hover" >
				<thead>
					<tr>
						<th>Group</th>
						<?php for($i = 0 ; $i < 12; $i++){ ?>
						<th><?php echo $months[$i]; ?></th>
						<?php } ?>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach($groups as $row){ $g_id = $row['id']; ?>
				    <tr>
						<td><?php echo $row['name']; ?></td>
						<?php for($i = 1 ; $i <= 12; $i++){ ?>
							<td><?php echo $order_count[$g_id][$i]; ?></td>
						<?php } ?>
				    </tr>
				<?php } ?>	
				</tbody>
			</table>
			
		<?php }else{ ?>
		
			<table class="table table-bordered table-hover" >
				<thead>
					<tr>
						<th>Publication</th>
						<?php for($i = 0 ; $i < 12; $i++){ ?>
							<th><?php echo $months[$i]; ?></th>
						<?php } ?>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach($publications as $row){ $pub_id = $row['id']; ?>
				    <tr>
						<td><?php echo $row['name']; ?></td>
						<?php for($i = 1 ; $i <= 12; $i++){ ?>
							<td><?php echo $order_count[$pub_id][$i]; ?></td>
						<?php } ?>
				    </tr>
				<?php } ?>	
				</tbody>
			</table>
			
		<?php } ?>
		</div>
	</div>
<?php } ?>	
</div>	 
<script>
$('#group').on('change',function(){
	var value = $(this).val();
	if(value != '') {
		$('#year-box').show();
	} else {
		$('#year-box').hide();
	}
});

$('#select_year').on('change',function(){
	var value = $(this).val();
	if(value != '') {
		$('form#report-form').submit();
	}
});
</script>	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

