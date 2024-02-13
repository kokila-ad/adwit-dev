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
					<a href="<?php echo base_url().index_page().'new_admin/home/help_desk'?>" class="font-lg font-grey-gallery"><u>Helpdesk</u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">
					<form role="form" method="post"> 
					<div class="btn-group left-dropdown">
						<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
							<i class="fa fa-filter fa-2x cursor-pointer"></i>
						</span>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<label><input type="checkbox"  name='active' value='1' class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users</label>
							<label><input type="checkbox" name='in_active' value='0' class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
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
		<?php if(isset($help_desk)){
			$total_count = 0;
			foreach($help_desk as $row){
				$hd_count = $this->db->query("SELECT * FROM `publications` WHERE `help_desk` = '".$row['id']."' AND `is_active` = '1' ;")->num_rows();	
				$total_count = $total_count + $hd_count ;
		}}
		?>
			<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>HelpDesk Name - <span class="badge"><?php echo count($help_desk);?></span></a> </th>
					<th>No.of publication - <span class="badge"><?php echo $total_count;?></span></a> </th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($help_desk)){?>
			<?php foreach($help_desk as $row){
				$hd_count = $this->db->query("SELECT * FROM `publications` WHERE `help_desk` = '".$row['id']."' AND `is_active` = '1' ;")->num_rows();	
				?>
				<tr>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/help_desk/'.$row['id']; ?>"> <?php echo $row['name'] ;?></a></td>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/help_desk/'.$row['id']; ?>"><?php echo $hd_count;?></td>
				</tr>
				
			<?php  }}?>
			</tbody>
			</table>
		</div>
	</div>
<?php } else {?>
	 <div class="portlet light">
		<div class="portlet-title">
			<div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="<?php echo base_url().index_page().'new_admin/home/help_desk'?>" class="font-lg font-grey-gallery">Helpdesk</a> -
						<a href="<?php echo base_url().index_page().'new_admin/home/help_desk'?>" class="font-lg font-grey-gallery"><u><?php $hd_name = $this->db->get_where('help_desk',array('id' => $id))->row_array(); echo $hd_name['name'];?></u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
				<?php if(null != $this->session->flashdata('message')){ ?>						
					<div class="alert alert-success margin-0 padding-5 small"><?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?></div>
				<?php } ?>
				<form method="post" name="order_form" id="order_form">
				<div class="btn-group left-dropdown">
				<span class="dropdown margin-right-10" data-toggle="dropdown" aria-expanded="true">
					<i class="fa fa-filter fa-2x cursor-pointer"></i>
				</span>
				<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
					<label><input type="checkbox"  name='active' value='1' class="form-control margin-bottom-10" <?php if($status == 'active'){ echo 'checked';} elseif($status == 'all'){ echo 'checked';}?>>Active Users</label>
					<label><input type="checkbox" name='in_active' value='0' class="form-control" <?php if($status == 'in_active') {echo 'checked';} elseif($status == 'all') { echo 'checked';}?>>In-Active Users </label>
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
				<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Publication Name - <span class="badge"><?php echo count($help_desk);?></span></a>  </p>
				<table class="table table-bordered table-hover" id="sample_6">
					<thead class="hidden">
						<tr><th>Publication </th></tr>
					</thead>
					<tbody>
					<?php if(isset($help_desk)){?>
					<?php foreach($help_desk as $row){ ?>
						<tr><td><a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$row['id']; ?>"><?php echo $row['name'];?></a></td></tr>
					<?php } }?>	
					</tbody>
					</table>
			</div>
			<div class="col-md-6 col-sm-12">
				<form method="post" name="order_form" id="order_form">
				<div class="manage-details">
					<ul>
						<div class="margin-bottom-15"><b>Helpdesk Details</b> 
							<span class="pull-right">
								<button  id="submit_form" type="submit" name="update_hd" class="btn btn-xs btn-primary margin-left-10">Save Changes</button>
							</span>
						</div>
						<li class="border-top" id="form">
							<div class="title">Helpdesk Name</div>
							<div class="data">
								<input type="text" value="<?php if($helpdesk[0]['name']!='')echo $helpdesk[0]['name']; else echo"-";?>" name="name" class="form-control input-sm" placeholder="">
							</div>
						</li>
						
						<li>
							<div class="title">Total Publication</div>
							<div class="data"><?php echo $pub_hd_count;?></div>
						</li>						
						<li>
							<div class="title">Total Adrep</div>
							<div class="data"><?php echo $adrep_hd_count; ?></div>
						</li>
						<li class="border-top" id="form">
							<div class="title">FTP Host</div>
							<div class="data">
								<input type="text" value="<?php echo $helpdesk[0]['ftp_server']; ?>" name="ftp_server" class="form-control input-sm" placeholder="">
							</div>
						</li>
						<li class="border-top" id="form">
							<div class="title">FTP Username</div>
							<div class="data">
								<input type="text" value="<?php echo $helpdesk[0]['ftp_username']; ?>" name="ftp_username" class="form-control input-sm" placeholder="">
							</div>
						</li>
						<li class="border-top" id="form">
							<div class="title">FTP Password</div>
							<div class="data">
								<input type="text" value="<?php echo $helpdesk[0]['ftp_password']; ?>" name="ftp_password" class="form-control input-sm" placeholder="">
							</div>
						</li>
						<li class="border-top" id="form">
							<div class="title">FTP Folder</div>
							<div class="data">
								<input type="text" value="<?php echo $helpdesk[0]['ftp_folder']; ?>" name="ftp_folder" class="form-control input-sm" placeholder="">
							</div>
						</li>
						<li class="border-top" id="form">
							<div class="title">FTP Public URL</div>
							<div class="data">
								<input type="text" value="<?php echo $helpdesk[0]['ftp_url']; ?>" name="ftp_url" class="form-control input-sm" placeholder="">
							</div>
						</li>
					</ul>
				</div>
				</form>
			</div>
<label>FTP Files</label>
<a href="<?php echo base_url().'ftp_file_upload/Dropzone.zip'?>">Download</a>			
		</div>
	</div>
<?php }?>
	

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
