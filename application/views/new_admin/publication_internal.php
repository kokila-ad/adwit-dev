<?php $this->load->view('new_admin/header')?>
<script>
	 $(document).ready(function(){
	  $('#submit-form').hide();
	  
	  $("#form").click(function(){$("#submit-form").show(); });
	 });
</script>
		
<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12">
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>" class="font-lg">Publication</a> - 
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>" class="font-lg font-grey-gallery"><u>Internal</u></a>
			</div>
			<div class="col-md-6 col-xs-12 text-right">	
				<form role="form" method = "post">
					<div class="btn-group left-dropdown">
						<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<a id="filter"><i class="fa fa-filter fa-2x cursor-pointer"></i></a>
						</span>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<label><input type="checkbox"  name='active' value='1' class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users</label>
							<label><input type="checkbox" name='in_active' value='0' class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
							<div class="text-right margin-top-10">
								<button type="submit" name = "submit" class="btn bg-red-flamingo btn-xs"> Submit</button>
							</div>
						</div>
						<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<div class="portlet-body">
	<?php if(isset($publication_in)){
		$total_count = 0;
			 foreach($publication_in as $in_row){
				$in_adrep = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$in_row['id']."' AND `is_active` = '1';")->num_rows();	
				$total_count = $total_count + $in_adrep;
	} }
	?>
		<table class="table table-bordered table-hover dataTable no-footer" id="sample_6">
			<thead>
				<tr>
					<th>Publication Name - <span class="badge"><?php echo count($publication_in);?></span> </th>
					<th>Group</th>
					<th>Helpdesk</th>
					<th>No of Adreps - <span class="badge"><?php echo $total_count;?></span> </th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($publication_in)){?>
			<?php foreach($publication_in as $in_row){
				$group = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$in_row['group_id']."'")->result_array();
				$helpdesk = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$in_row['help_desk']."'")->result_array();
				$in_adrep = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$in_row['id']."' AND `is_active` = '1';")->num_rows();	
			?>
			<tr>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$in_row['id']; ?>"><?php echo $in_row['name'];?></td>
				<td><?php if(isset($group[0]['name'])){echo $group[0]['name'];}else {echo '';}?></td>
				<td><?php if(isset($helpdesk[0]['name'])){echo $helpdesk[0]['name'];}else {echo '';}?></td>
				<td><a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$in_row['id']; ?>"><?php echo $in_adrep;?></td>											
			</tr>
			<?php } } ?>
			</tbody>
		</table>
	</div>
</div>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>