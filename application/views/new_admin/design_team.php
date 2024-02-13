<?php $this->load->view('new_admin/header')?>
<script>
	 $(document).ready(function(){
	  $('#submit_form').hide();
	  
	  $("#form").click(function(){$("#submit_form").show(); }); 
	 });
 </script>

<?php if($id == ''){?>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="<?php echo base_url().index_page().'new_admin/home/design_team'?>" class="font-lg font-grey-gallery"><u>DesignTeam</u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
					<form role="form" method="post"> 
					<div class="btn-group left-dropdown">
						<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<i class="fa fa-filter fa-2x cursor-pointer"></i>
						</span>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<label><input type="checkbox" name="active" value="1" class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users </label>
							<label><input type="checkbox" name="in_active" value="0" class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
							<div class="text-right margin-top-10">
								<button type="submit" name = "submit" class="btn bg-red-flamingo btn-xs"> Submit</button>
							</div>
						</div>
						<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
				 </form>	
				</div>								
			</div>
		</div>				
		<div class="portlet-body">
		<?php if(isset($design_team)){
			$total_count = 0;
				foreach($design_team as $row){
						$dt_count = $this->db->query("SELECT * FROM `publications` WHERE `design_team_id` = '".$row['id']."' AND `is_active` ='1' ;")->num_rows();	
						$total_count = $total_count + $dt_count;
		}}
		?>
			<table class="table table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Design Team Name - <span class="badge"><?php echo count($design_team);?> </th>
						<th>No.of publication - <span class="badge"><?php echo $total_count;?></span></a> </th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($design_team)){?>
				<?php foreach($design_team as $row){
						$dt_count = $this->db->query("SELECT * FROM `publications` WHERE `design_team_id` = '".$row['id']."' AND `is_active` ='1' ;")->num_rows();	
					?>
					<tr>
						<td><a href="<?php echo base_url().index_page().'new_admin/home/design_team/'.$row['id']; ?>"> <?php echo $row['name'] ;?></a></td>
						<td><a href="<?php echo base_url().index_page().'new_admin/home/design_team/'.$row['id']; ?>"> <?php echo $dt_count;?></td>
						
					</tr>
					
				<?php  }}?>
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
					<a href="<?php echo base_url().index_page().'new_admin/home/design_team'?>" class="font-lg font-grey-gallery">DesignTeam</a> -
					<a href="<?php echo base_url().index_page().'new_admin/home/design_team'?>" class="font-lg font-grey-gallery"><u><?php $dt_name = $this->db->get_where('design_teams',array('id' => $id))->row_array(); echo $dt_name['name'];?></u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
					<form role="form" method="post"> 
					<div class="btn-group left-dropdown">
						<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<i class="fa fa-filter fa-2x cursor-pointer"></i>
						</span>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<label><input type="checkbox" name="active" value="1" class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users </label>
							<label><input type="checkbox" name="in_active" value="0" class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
							<div class="text-right margin-top-10">
								<button type="submit" name = "submit" class="btn bg-red-flamingo btn-xs"> Submit</button>
							</div>
						</div>
						<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
				 </form>	
				</div>								
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 col-sm-12 margin-bottom-20">
			<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Publication Name - <span class="badge"><?php echo count($design_team);?></span></a> </p>
				<table class="table table-bordered table-hover" id="sample_6">
					<thead class="hidden">
						<tr><td>Publication </td></tr>
					</thead>
					<tbody>
					<?php if(isset($design_team)){?>
					<?php foreach($design_team as $row){ ?> 
						<tr><td><a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$row['id']; ?>"><?php echo $row['name'];?></a></td></tr>
					<?php } }?>	
					</tbody>
					</table>
			</div>
			<div class="col-md-6 col-sm-12">
				<form method="post" name="order_form" id="order_form">
				<div class="manage-details">
					<ul>
						<div class="margin-bottom-15"><b>Design Team Details</b> 
							<span class="pull-right">
								<button  id="submit_form" type="submit" name="update_dt" class="btn btn-xs btn-primary margin-left-10">Save Changes</button>
							</span>
						</div>
						<li  class="border-top" id="form">
							<div class="title">Design Team Name</div>
							<div class="data">
								<input type="text" value="<?php if($designteam[0]['name']!='')echo $designteam[0]['name']; else echo"-";?>" name="name" class="form-control input-sm" placeholder="">
							</div>
						</li>
						
						<li>
							<div class="title">Total Publication</div>
							<div class="data"><?php echo $pub_dt_count;?></div>
						</li>						
						<li>
							<div class="title">Total Adrep</div>
							<div class="data"><?php echo $adrep_dt_count; ?></div>
						</li>
					</ul>
				</div>
				</form>
			</div>	
		</div>
	</div>
<?php }?>
		

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>