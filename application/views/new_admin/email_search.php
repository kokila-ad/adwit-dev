<?php $this->load->view('new_admin/header')?>
<script> 
$(document).ready(function(){ 
	$('#submit_form').hide(); 
	
	$(".savechanges").click(function(){
		$("#submit_form").show(); 
	});
});
</script>

<?php if(isset($user) && $user == 'adrep'){?>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		 <form method="get" name="order_form" id="order_form" >
			<div class="col-md-6">
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Username</th>
						<th>User Type</th>
						<th>Email Id</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($email_user)){
					foreach($email_user as $row){
					?>
					<tr>
						<td><?php echo $row['username'];?></td>
						<td><?php if(isset($user)){ echo $user;}?></td>
						<td><?php echo $row['email_id'];?></td>
						<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/adrep_profile/".$row['id'];?>'">View</a>
					</tr>
				<?php } }?>
				</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
</div>
<?php }elseif(isset($user) && $user == 'designer'){?>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		 <form method="get" name="order_form" id="order_form" >
			<div class="col-md-6">
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Username</th>
						<th>User Type</th>
						<th>Email Id</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($email_user)){
					foreach($email_user as $row){
					?>
					<tr>
						<td><?php echo $row['username'];?></td>
						<td><?php if(isset($user)){ echo $user;}?></td>
						<td><?php echo $row['email_id'];?></td>
						<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/designer_profile/".$row['id'];?>'">View</a>
					</tr>
				<?php } }?>
				</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
</div>
<?php }elseif(isset($user) && $user == 'csr'){?>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		 <form method="get" name="order_form" id="order_form" >
			<div class="col-md-6">
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Username</th>
						<th>User Type</th>
						<th>Email Id</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($email_user)){
					foreach($email_user as $row){
					?>
					<tr>
						<td><?php echo $row['username'];?></td>
						<td><?php if(isset($user)){ echo $user;}?></td>
						<td><?php echo $row['email_id'];?></td>
						<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/csr_profile/".$row['id'];?>'">View</a>
					</tr>
				<?php } }?>
				</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
</div>
<?php }elseif(isset($user) && $user == 'admin_users'){?>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		 <form method="get" name="order_form" id="order_form" >
			<div class="col-md-6">
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Username</th>
						<th>User Type</th>
						<th>Email Id</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($email_user)){
					foreach($email_user as $row){
					?>
					<tr>
						<td><?php echo $row['username'];?></td>
						<td><?php if(isset($user)){ echo $user;}?></td>
						<td><?php echo $row['email_id'];?></td>
						<td><a href="javascript:;" class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url().index_page()."new_admin/home/admin_profile/".$row['id'];?>'">View</a>
					</tr>
				<?php } }?>
				</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
</div>
<?php }else{?>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-4 margin-bottom-15"><?php echo 'ERROR!! Email_Address Not Found'; ?></div>
		</div>
	</div>
</div>
<?php }?>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/foot')?>
