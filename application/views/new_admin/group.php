<?php $this->load->view('new_admin/header')?>


<?php if($id == ''){?>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="<?php echo base_url().index_page().'new_admin/home/group'?>" class="font-lg font-grey-gallery"><u>Groups</u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
					<div class="btn-group left-dropdown">
						<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<i class="fa fa-filter fa-2x cursor-pointer"></i>
						</span>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
						<form role="form" method="post">
							<label><input type="checkbox" name='active' value='1' class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users </label>
							<label><input type="checkbox" name='in_active' value='0' class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
							<div class="text-right margin-top-10">
								<button type="submit" name= "submit" class="btn bg-red-flamingo btn-xs"> Submit</button>
							</div>
						</form>
						</div>
						<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
					
				</div>								
			</div>
		</div>
		<div class="portlet-body">
		<?php if(isset($group)){
			 $total_count = 0; 
				  foreach($group as $row){
					  $grp_count = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$row['id']."' AND `is_active` ='1';")->num_rows();	
					  $total_count = $total_count + $grp_count;
			} } 
		?>
			<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Group Name - <span class="badge"><?php echo count($group);?></span> </th>
					<th>No.of Publications - <span class="badge"><?php echo $total_count;?></span> </th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($group)){
					foreach($group as $row){
						$grp_count = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$row['id']."' AND `is_active` ='1';")->num_rows();	
			?>
				<tr>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/group/'.$row['id']; ?>"><?php echo $row['name'];?></a></td>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/group/'.$row['id']; ?>"><?php echo $grp_count;?></td>
				</tr>
			<?php  } }?>
			</tbody>
			</table>
			
		</div>
	</div>
					
<?php }else {?>
	 <div class="portlet light">
		 <div class="portlet-title">
			 <div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="<?php echo base_url().index_page().'new_admin/home/group'?>" class="font-lg font-grey-gallery">Groups</a> -
					<a href="<?php echo base_url().index_page().'new_admin/home/group'?>" class="font-lg font-grey-gallery"><u><?php $group_name = $this->db->get_where('Group',array('id' => $id))->row_array(); echo $group_name['name'];?></u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
					<div class="btn-group left-dropdown">
						<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<i class="fa fa-filter fa-2x cursor-pointer"></i>
						</span>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
						<form role="form" method="post">
							<label><input type="checkbox" name='active' value='1' class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users </label>
							<label><input type="checkbox" name='in_active' value='0' class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
							<div class="text-right margin-top-10">
								<button type="submit" name= "submit" class="btn bg-red-flamingo btn-xs"> Submit</button>
							</div>
						</form>
						</div>
						<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
					
				</div>									
			</div>
		</div>
		 <div class="portlet-body">
		 <?php if(isset($publications)){
			  $total_count_adrep = 0; 
				foreach($publications as $row){
					$adrep_count = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$row['id']."' AND `is_active` ='1';")->num_rows();	
					$total_count_adrep = $total_count_adrep + $adrep_count; 
		 } }
		 ?>
			 <div class="row">
				<div class="col-md-6 col-sm-12 margin-bottom-20">
				
					<table class="table table-bordered table-hover" id="sample_6">
						<thead>
							<tr>
								<th>Publication Name - <span class="badge"><?php echo count($publications);?></span></th>
								<th>Adrep - <span class="badge"><?php echo $total_count_adrep;?></span></th>
							</tr>
						</thead>
							<tbody>
							<?php if(isset($publications)){
								foreach($publications as $row){
								$adrep_count = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$row['id']."' AND `is_active` ='1';")->num_rows();	
							?> 
								<tr>
								<td><a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$row['id']; ?>"><?php echo $row['name'];?></a></td>
								<td><?php echo $adrep_count;?></a></td>
								</tr>
							<?php } }?>	
							</tbody>
					</table>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="manage-details">
					<?php if(isset($group)){?>
						<ul>
							<div class="margin-bottom-15"><b>Group Details</b></div>
							<hr>
							<?php foreach($group as $row1){?>
							<li class="border-top">
								<div class="title">Channel</div>
								<div class="data"><?php echo $row1['channel'];?></div>
							</li>
							<li>
								<div class="title">Display Publication</div>
								<div class="data"><?php echo $row1['display_pub'];?></div>
							</li>
						<?php }?>
						</ul>
					</div>
						<?php }?>
				</div>
			 </div>
		 </div>
	</div>
<?php }?>		


<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
