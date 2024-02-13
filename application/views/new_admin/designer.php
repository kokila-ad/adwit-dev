<?php $this->load->view('new_admin/header')?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/expToCSV.js" ></script>

<div class="portlet light">					
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-8 margin-bottom-10">
				<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
				<a href="<?php echo base_url().index_page().'new_admin/home/designer'?>" class="font-lg font-grey-gallery"><u>Designer</u></a>
			</div>
			<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
				<form role="form" method="post">
				<!--<span class="btn bg-grey btn-xs margin-right-10" onclick="tableToExcel('sample_6', 'W3C Example Table')">
					<i class="fa fa-file-excel-o"></i> Export
				</span>	-->
				<span><button class="btn bg-grey btn-xs margin-right-10"><a href="#" class="fa fa-file-excel-o" id="exportcsv"> Export</a></button></span>
				
				<div class="btn-group left-dropdown margin-top-5">
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
		<input type="text" id="csv_tab_name" value="designer.csv" style="display:none">
		<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Designer Name - <span class="badge"><?php echo count($designer);?></th>
					<th>Role</th>
					<th>Username</th>
					<th>Location</th>
					
				</tr>
			</thead>
			<tbody>
			<?php if(isset($designer)){?>
			<?php foreach($designer as $row){
				$location_name = $this->db->query("SELECT * FROM `location` WHERE `id` = '".$row['Join_location']."'")->result_array();
				?>
				<tr>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/designer_profile/'.$row['id']; ?>"> <?php echo $row['name'] ;?></a></td>
					<td><?php echo $row['drole']; ?></td>
					<td><?php echo $row['username']; ?></td>
					<td><?php if($row['Join_location']=='0'|| $row['Join_location']==''){ echo ""; }else { echo $location_name[0]['name']; }?></td>
				</tr>
				
			<?php  }}?>
			</tbody>
		</table>
	</div>
</div>
		 	
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>