<?php $this->load->view('new_admin/header')?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12">
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>" class="font-lg">AdRep</a> - 
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
		<table class="table table-bordered table-hover dataTable no-footer" id="sample_8">
			<thead>
				<tr>
					<th>Adrep Name - <span class="badge"><?php echo count($adreps_in);?></span></a> </th>
					<th>Publication Name</th>
					<th>Group Name</th>
					<th>Email ID</th>
					
				</tr>
			</thead>
			<tbody>
			<?php foreach($adreps_in as $adrep_in){
				$group_name= $this->db->query("SELECT `name` FROM `Group` WHERE `id` = '".$adrep_in['group_id']."'")->row_array();
				?>
				<tr>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/adrep_profile/'.$adrep_in['id']; ?>"><?php echo $adrep_in['first_name'].' '.$adrep_in['last_name']; ?></a></td>
					<td><?php echo $adrep_in['name'];?></td>
					<td><?php if(isset($group_name['name'])){ echo $group_name['name']; } else{ echo "";}?></td>
					<td><?php echo $adrep_in['email_id'];?></td>											
				</tr>
			<?php  } ?>	
			</tbody>
		</table>
	</div>
</div>	


<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable.php'); ?>