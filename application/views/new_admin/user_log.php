<?php $this->load->view('new_admin/header')?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/expToCSV.js" ></script>

<div class="portlet light">					
	<div class="portlet-title">
		<div class="row">
		<form method='GET'>		
			<div class="col-md-12 col-xs-12 margin-bottom-10">
				<span class="font-lg font-grey-gallery">User Type</span> - 
				<select id="user_type" name="user_type">
					<option value="">Select</option>
					<option value="1" <?php if($user_type == 1)echo"selected"; ?>>Admin</option>
					<option value="2" <?php if($user_type == 2)echo"selected"; ?>>Adrep</option>
					<option value="3" <?php if($user_type == 3)echo"selected"; ?>>CSR</option>
					<option value="4" <?php if($user_type == 4)echo"selected"; ?>>Designer</option>
				</select>
				<?php if(isset($user_list)){ ?>
				<span class="font-lg font-grey-gallery">User List</span> -
				<select id="user_id" name="user_id">
					<option value="all">All</option>
					<?php foreach($user_list as $row){ ?>
						<option value="<?php echo $row['id']; ?>" <?php if($user_id == $row['id'])echo"selected"; ?>><?php echo $row['name']; ?></option>
					<?php } ?>
				</select>
				
					<div  class="date-picker input-daterange margin-top-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
					<span class="font-lg font-grey-gallery">Date Range</span> -
						<input type="text" id="from_date" name="from" placeholder="From Date" value="<?php if(isset($from))echo $from; ?>" required />
						<span> to </span>
						<input type="text" id="to_date" name="to" placeholder="To Date" value="<?php if(isset($to))echo $to; ?>" required />
					</div>
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				<?php } ?>
			</div>
		</form>
		</div>
	</div>
	<div class="portlet-body">
		<input type="text" id="csv_tab_name" value="designer.csv" style="display:none">
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Date</th>
					<?php if($user_type == 3 || $user_type == 4)echo'<th>Name</th>'; ?>
					<th>IP Address</th>
					<th>Browser</th>
					<th>OS</th>
					<th>Device</th>
					<th>LogIn-LogOut</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if(isset($user_log_details)){ foreach($user_log_details as $row){ 
					if($user_type == 3 || $user_type == 4){
						$user_name = $this->db->query("SELECT name FROM $user_module WHERE id='".$row['user_id']."'")->row_array();
					}
			?>
				<tr>
					<td><?php echo $row['timestamp']; ?></td>
					<?php if(isset($user_name['name']))echo '<td>'.$user_name['name'].'</td>'; ?>
					<td><?php echo $row['ip']; ?></td>
					<td><?php echo $row['browser']; ?></td>
					<td><?php echo $row['os']; ?></td>
					<td><?php echo $row['device']; ?></td>
					<td><?php echo $row['in_out']; ?></td>
				</tr>
			<?php } } ?>
			</tbody>
		</table>
	</div>
</div>
		 	
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
<script>
$(document).ready(function(){
	$('#user_type').on('change',function(){
		var user_type = $(this).val();
		window.location = "<?php echo base_url().index_page().'new_admin/home/user_log/';?>" + user_type ;
	});
	
	$('#user_id').on('change',function(){
		var user_id = $(this).val();
		window.location = "<?php echo base_url().index_page().'new_admin/home/user_log/'.$user_type.'/';?>" + user_id ;
	});
	
});
</script>