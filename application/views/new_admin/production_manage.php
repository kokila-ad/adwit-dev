<?php $this->load->view('new_admin/header')?>
<style>
	.msg { min-height: 22px;}
		@media only screen and (max-width: 767px){
	#input {
  left: 0px !important;
 }
		}
</style>

<script type="text/javascript">
	$(document).ready(function(e) {
        $('#group_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/group/';?>" + $('#group_list').val() ;
        });
		
		$('#pub_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/publication/';?>" + $('#pub_list').val() ;
        });
		
		$('#designer_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/designer_profile/';?>" + $('#designer_list').val() ;
        });
		
		$('#csr_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/csr_profile/';?>" + $('#csr_list').val() ;
        });
		
		$('#helpdesk_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/help_desk/';?>" + $('#helpdesk_list').val() ;
        });
		$('#club_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/club/';?>" + $('#club_list').val() ;
        });
		
		$('#designteam_list').change(function(e) {		
            window.location = "<?php echo base_url().index_page().'new_admin/home/design_team/';?>" + $('#designteam_list').val() ;
        });

		$('#submit_form').hide();
		$("#form").click(function(){$("#submit_form").show(); }); 
			
		$(".approve select").change(function(){
			$(this).find("option:selected").each(function(){
				if($(this).attr("value")=="0"){
					$(".box").not(".noaction").hide();
					$(".noaction").show();
				}
				else if($(this).attr("value")=="2"){
					$(".box").not(".email").hide();
					$(".email").show();
				}
				else if($(this).attr("value")=="1"){
					$(".box").not(".ftp").hide();
					$(".ftp").show();
				}
				else{
					$(".box").hide();
				}
			});
		}).change(); 
	 });
 </script>


<?php if($admin_users[0]['admin_role']== '1'){?>
<div class="row margin-top-20">		
	<div class="col-md-4 col-md-offset-8 col-sm-12">
		<?php if(null != $this->session->flashdata('message')){ ?>						
			<div class="alert alert-success padding-5 small margin-bottom-5 text-right"><?php echo '<span style="text-align: left;margin:0;">'.$this->session->flashdata('message').'</span>'; ?></div>
		<?php } ?>
	</div>	
<!-- Groups -->	

			
		
			
										
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/group'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						
						
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								
								
								<div class="col-md-12 col-sm-12 text-right">
									<input type="submit" id="submit_form" class="btn btn-primary btn-sm" value="Create">
								</div>
							</div>
						</div>
					</div>
				 </form>	
		
		
	
<!-- End Groups-->

<!-- Publication -->				
	<!--<div class="col-md-6 col-sm-6">	
		<div class="row option option-yellow">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>"><span><?php echo count($publication);?></span></a><p>Publications</p>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 select">							
				<select name="name" id = "pub_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
						<?php foreach($publication as $pub_row){ ?>
					<option value = "<?php echo($pub_row['id'])?>" ><?php echo($pub_row['name']); ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 create">							
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/publication'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
							<a ><span>+</span> <p> Create</p></a>
						</div>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Name <span class="font-red">*</span></label>
									<input type="text" name="name" class="form-control" style="text-transform: capitalize;" required>
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Initial</label>
									<input type="text" name="initial" class="form-control">
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Design Team <span class="font-red">*</span></label>
									<select class="form-control" name="design_team_id" required>
										<option value="">Select Design Team</option>
											<?php foreach($design_team as $design_row){ ?>
										<option value = "<?php echo($design_row['id'])?>" ><?php echo($design_row['name']); ?></option>
											<?php } ?>
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Group <span class="font-red">*</span></label>
									<select class="form-control" name="group_id" required>
										<option value="">Select Group</option>
											<?php foreach($group as $group_row){ ?>
										<option value = "<?php echo($group_row['id'])?>" ><?php echo($group_row['name']); ?></option>
											<?php } ?>
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Helpdesk <span class="font-red">*</span></label>
									<select class="form-control" name="help_desk" required>
										<option value="">Select Help Desk</option>
											<?php foreach($helpdesk as $hd_row){ ?>
										<option value = "<?php echo($hd_row['id'])?>" ><?php echo($hd_row['name']); ?></option>
											<?php } ?>
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Channel <span class="font-red">*</span></label>
									<select class="form-control" name="channel" required>
										<option value="">Select Channels</option>
											<?php foreach($channels as $ch_row){ ?>
										<option value = "<?php echo($ch_row['id'])?>" ><?php echo($ch_row['name']); ?></option>
											<?php } ?>
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Slug Type <span class="font-red">*</span></label>
									<select class="form-control" name="slug_type" required>
										<option value="">Select Slug Type</option>
											<?php foreach($slug_type as $slug_type_row){ ?>
										<option value = "<?php echo ($slug_type_row['id'])?>"><?php echo($slug_type_row['name']);?></option>
											<?php }?>	
									</select>
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Ordering System <span class="font-red">*</span> </label>
									<div class="clearfix">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-default margin-right-10">
											<input type="radio" value="1" name="ordering_system" required> Internal </label>
											<label class="btn btn-default">
											<input type="radio" value="2" name="ordering_system" required> External </label>
										</div>
									</div>	
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10">
									<label>Advertising Director </label>
									<input type="email" name="advertising_director_email_id" class="form-control">
								</div>
								
								<div class="col-md-6 col-sm-12 margin-bottom-10 approve">
									<label>Approve</label>
									<select class="form-control" name="approve">
											<option value ="0">No Action</option>
											<option value ="1">FTP</option>
											<option value ="2">Email</option>
									</select>
								</div>
							</div>
							
							<div class="row ftp box">
								<div class="col-md-6 col-sm-12 margin-bottom-5">
									<label>Ftp Server </label>
									<input type="text" name="ftp_server" class="form-control">
								</div>
								<div class="col-md-6 col-sm-12 margin-bottom-5">
									<label>Ftp Username </label>
									<input type="text" name="ftp_username" class="form-control">
								</div>
								<div class="col-md-6 col-sm-12 margin-bottom-5">
									<label>Ftp Password </label>
									<input type="text" name="ftp_password" class="form-control">
								</div>
								<div class="col-md-6 col-sm-12 margin-bottom-5">
									<label>Ftp Folder </label>
									<input type="text" name="ftp_folder" class="form-control">
								</div>
							</div>
							
							<div class="row email box">
								<div class="col-md-6 col-sm-12 margin-bottom-5">
									<label>Email ID</label>
									<input type="email" name="email" class="form-control" placeholder="Enter email id">
								</div>								
							</div>
							
							<div class="row margin-top-10">	
								<div class="col-md-12 col-sm-12 text-right">
									<input type="submit" class="btn btn-primary btn-sm" value="Create">
								</div>
							</div>
						</div>
					</div>
				 </form>
			</div>
		</div>
	</div>
</div>-->
<!-- End Publication-->

<div class="row">
<!-- Designer -->	
	<div class="col-md-6 col-sm-6">	
		<div class="row option option-red">
			<div class="col-md-5 col-sm-12 col-xs-12 count">							
				<a href="<?php echo base_url().index_page().'new_admin/home/designer_details'?>"><span><?php echo count($designer);?></span><p>Designers</p></a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 select">							
				<select name="name" id = "designer_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
						<?php foreach($designer as $desgn_row){ ?>
							<option value = "<?php echo($desgn_row['id'])?>" ><?php echo($desgn_row['name']); ?> (<?php echo ($desgn_row['username']);?>)</option>
						<?php } ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 create">							
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/designer'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
							<a ><span>+</span> <p> Create</p></a>
						</div>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								
								<div class="col-md-6 col-sm-12">
									<label>Name <span class="font-red">*</span></label>
									<input type="text" name="name" class="form-control" style="text-transform: capitalize;" required/>
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Gender</label>
									<div class="clearfix">
									<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-success active">
										<input type="radio" value="1" name="gender" class="toggle" checked > Male </label>
										<label class="btn btn-success margin-right-10">
										<input type="radio" value="0" name="gender" class="toggle"> Female </label>
									</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Email Id <span class="font-red">*</span></label>
									<input type="email" name="email_id" class="form-control" required/>
								</div>
							
								<div class="col-md-6 col-sm-12">
									<label>Username <span class="font-red">*</span></label>
										<input type="text" name="username" class="form-control" required/>
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Join Location <span class="font-red">*</span></label>
									<select class="form-control" name="Join_location" required>
										<option value="">Select Join Location</option>
										<?php foreach($location as $loc_row) { ?>
										<option value="<?php echo $loc_row['id'] ;?>"><?php echo $loc_row['name'];?></option>
										<?php } ?>
									</select>	
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Role<span class="font-red">*</span></label>
									<select class="form-control" name="designer_role" required>
										<option value="">Select Role</option>
										<?php foreach($designer_role as $role_row) { ?>
										<option value="<?php echo $role_row['id'] ;?>"><?php echo $role_row['name'];?></option>
										<?php } ?>
									</select>	
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Level<span class="font-red">*</span></label>
									<select class="form-control" name="level" required>
										<option value="">Select Level</option>
										<?php foreach($designer_level as $level_row) { ?>
										<option value="<?php echo $level_row['id'] ;?>"><?php echo $level_row['name'];?></option>
										<?php } ?>
									</select>	
								</div>

								<div class="col-md-12 col-sm-12 text-right margin-top-10">
									<input type="checkbox" name="send_mail_designer" value="1">Send mail to Designer &nbsp;
									<input type="submit" id ="submit_form" class="btn btn-primary btn-sm" value="Create">
								</div>
							</div>
						</div>
					</div>
				</form>	
			</div>
		</div>					
	</div>
<!-- End Designer-->

<!-- CSR -->				
	<div class="col-md-6 col-sm-6">		 
		<div class="row option option-green">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/csr_admin_details'?>"><span><?php echo count($csr);?></span><p>CSR</p></a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 select">							
				<select name="name" id = "csr_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
					<?php foreach($csr as $row3){ ?>
					<option value = "<?php echo($row3['id'])?>" ><?php echo($row3['name']); ?> (<?php echo($row3['username']); ?>)</option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 create">							
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/csr'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
							<a><span>+</span> <p> Create</p></a>
						</div>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label>Name <span class="font-red">*</span></label>
										<input type="text" class="form-control" name="name" style="text-transform: capitalize;" required/>
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Gender</label>
									<div class="clearfix">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-success active margin-right-10">
										<input type="radio" value="1" name="gender" class="toggle" checked> Male </label>
										<label class="btn btn-success">
										<input type="radio" value="0" name="gender" class="toggle"> Female </label>
									</div>
								</div>
								</div>
						
								<div class="col-md-6 col-sm-12">
									<label>Email Id <span class="font-red">*</span></label>
									<input type="email" class="form-control" name="email_id" required/>
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Username <span class="font-red">*</span></label>
										<input type="text" class="form-control" name="username" required/>
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Join Location</label>
								<select class="form-control" name="Join_location" >
									<option value="">Select Join Location</option>
									<?php foreach($location as $loc_row) { ?>
									<option value="<?php echo $loc_row['id'] ;?>"><?php echo $loc_row['name'];?></option>
									<?php } ?>
								</select>	
								</div>
								
								<div class="col-md-6 col-sm-12">
									<label>Role<span class="font-red">*</span></label>
									<select class="form-control" name="csr_role" required>
										<option value="">Select Role</option>
										<?php foreach($csr_role as $crole_row) { ?>
										<option value="<?php echo $crole_row['id'] ;?>"><?php echo $crole_row['name'];?></option>
										<?php } ?>
									</select>	
								</div>	
							
								<div class="col-md-12 col-sm-12 text-right margin-top-10">
									<input type="checkbox" name="send_mail_csr" value="1">Send mail to CSR &nbsp;
									<input type="submit" id ="submit_form" class="btn btn-primary btn-sm" value="Create">
								</div>	
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>		
<!-- End CSR-->
</div>

<div class="row">	
<!-- Helpdesk -->	
	 <div class="col-md-6 col-sm-6">					
		<div class="row option option-blue-cadet">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/help_desk'?>"><span><?php echo count($helpdesk);?></span><p>Helpdesk</p></a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 select">							
				<select name="name" id="helpdesk_list" class="select2me form-control margin-bottom-10">
					<option value="">Select</option>
						<?php foreach($helpdesk as $hd_row){ ?>
							<option value = "<?php echo($hd_row['id'])?>" ><?php echo($hd_row['name']); ?></option>
						<?php } ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 create">							
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/help_desk'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
							<a ><span>+</span> <p> Create</p></a>
						</div>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label>Name <span class="font-red">*</span></label>
									<input type="text" name="name" class="form-control" style="text-transform: capitalize;" required/>
								</div>
								
								<div class="col-md-12 col-sm-12 text-right">
									<input type="submit" id="submit_form" name="create" class="btn btn-primary btn-sm" value="Create">
								</div>
							</div>
						</div>
					</div>
				 </form>
			</div>
		</div>
	</div>	
<!-- End Helpdesk-->
<!--Club Interface Starts-->
<div class="col-md-6 col-sm-6">					
		<div class="row option option-blue-cadet">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/club'?>"><span><?php echo count($club);?></span><p>Club</p></a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 select">							
				<select name="name" id="club_list" class="select2me form-control margin-bottom-10">
					<option value="">Select</option>
						<?php foreach($club as $cb_row){ ?>
							<option value = "<?php echo($cb_row['id'])?>" ><?php echo($cb_row['name']); ?></option>
						<?php } ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 create">							
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/club'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
							<a ><span>+</span> <p> Create</p></a>
						</div>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label>Name <span class="font-red">*</span></label>
									<input type="text" name="name" class="form-control" style="text-transform: capitalize;" required/>
								</div>
								
								<div class="col-md-12 col-sm-12 text-right">
									<input type="submit" name="submit" id="submit_form" class="btn btn-primary btn-sm" value="Create">
								</div>
							</div>
						</div>
					</div>
				 </form>
			</div>
		</div>
	</div>	
<!--Club Interface -->
<!-- Design Team -->
	<!--<div class="col-md-6 col-sm-6">
		<div class="row option option-brown">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/design_team'?>"><span><?php echo count($design_team);?></span><p>Design Team </p></a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 select">							
				<select name="name" id ="designteam_list" class="select2me form-control margin-bottom-10">
					<option value="">Select</option>
					<?php foreach($design_team as $dt_row){ ?>
					<option value = "<?php echo($dt_row['id'])?>" ><?php echo($dt_row['name']); ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 create">							
				<form method="post" action="<?php echo base_url().index_page().'new_admin/home/design_team'; ?>" name="order_form" id="order_form">
					<div class="btn-group left-dropdown">
						<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
							<a ><span>+</span> <p> Create</p></a>
						</div>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label>Name <span class="font-red">*</span></label>
									<input type="text" name="name" class="form-control" style="text-transform: capitalize;" required/>
								</div>
								<div class="col-md-6 col-sm-12">
									<label>Email Id <span class="font-red">*</span></label>
									<input type="email" name="email_id" class="form-control" required/>
								</div>
								<div class="col-md-6 col-sm-12">
									<label>Newad Template <span class="font-red">*</span></label>
									<select class="form-control" name="newad_template" required>
										<option value="">Select Newad Template</option>
										<option value = "revisionE-order">revisionE-order</option>
										<option value = "E-upload14">E-upload14</option>
										<option value = "order_rating_mailer">order_rating_mailer</option>
										<option value = "E-upload12">E-upload12</option>
									</select>
								</div>
								<div class="col-md-6 col-sm-12">
									<label>Revad Template <span class="font-red">*</span></label>
									<select class="form-control" name="revad_template" required>
										<option value="">Select Revad Template</option>
										<option value = "revisionE-order">revisionE-order</option>
										<option value = "E-upload14">E-upload14</option>
										<option value = "order_rating_mailer">order_rating_mailer</option>
									</select>
								</div>
								
								<div class="col-md-12 col-sm-12 text-right margin-top-10">
									<input type="submit" id="submit_form" class="btn btn-primary btn-sm" value="Create">
								</div>
							</div>
						</div>
					</div>
				 </form>
			</div>
		</div>
	</div>-->
<!-- End Design Team-->
</div>	

<!-- Templates, Image bank, Complaint --> 
<div class="row">		
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/report_templates' ?>"><div class="option-theme1">Templates</div></a>
	</div>			 
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/report_imagebank' ?>"><div class="option-theme2">Image Bank</div></a>
	</div>
	<!--<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/reports_complaint' ?>"><div class="option-theme3">Complaints</div></a>
	</div>-->
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM' ?>"><div class="option-theme4">Coupon Library</div></a>
	</div>
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/notification_list' ?>"><div class="option-theme3">Notification</div></a>
	</div>
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/production_nj' ?>"><div class="option-theme5">Production NJ</div></a>
	</div>
	<!-- <div class="col-md-3 col-sm-6 margin-bottom-20">
		<div class="option-theme1 padding-0">
		<form  role="form" method="get" action="<?php echo base_url().index_page().'new_admin/home/order_rev_status'?>" enctype="multipart/form-data">
			<div class="input-group padding-10">
				<input type="text" class="form-control" name="id" placeholder="Enter Order ID" >
				<span class="input-group-btn">
					<button type="submit" name="search" class="btn bg-grey-gallery">Search</button>
				</span>
			</div>
		</form>	
		</div>
	</div> -->
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<div class="option-theme1 padding-0">
		<form  role="form" method="get" action="<?php echo base_url().index_page().'new_admin/home/search_email'?>" enctype="multipart/form-data">
			<div class="input-group padding-10" id="input">
				<input type="email" class="form-control" name="email_id" placeholder="Enter Email Address" >
				<span class="input-group-btn">
					<button type="submit" name="search" class="btn bg-grey-gallery">Search</button>
				</span>
			</div>
		</form>
		</div>
	</div>
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/in_active_users' ?>"><div class="option-theme5">In-Active Users</div></a>
	</div>
</div>
</div>
<!-- End -->
<?php }elseif($admin_users[0]['admin_role'] == '2' || $admin_users[0]['admin_role']=='3'){?>
<div class="row margin-top-10">		
	<div class="col-md-4 col-md-offset-8 col-sm-12">
		<?php if(null != $this->session->flashdata('message')){ ?>						
			<div class="alert alert-success padding-5 small margin-bottom-5 text-right"><?php echo '<span style="text-align: left;margin:0;">'.$this->session->flashdata('message').'</span>'; ?></div>
		<?php } ?>
	</div>	
<!-- Groups -->	
	<div class="col-md-6 col-sm-6">				
		<div class="row option option-blue">
			<div class="col-md-5 col-sm-12 col-xs-12 count">							
				<a href="<?php echo base_url().index_page().'new_admin/home/group'?>"><span><?php echo count($group);?></span><p>Groups</p></a>
			</div>
			<div class="col-sm-6 col-xs-12 select">							
				<select name="name" id="group_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
						<?php foreach($group as $grp_row){ ?>
							<option value = "<?php echo($grp_row['id'])?>" ><?php echo($grp_row['name']); ?></option>
						<?php } ?>
				</select>
			</div>  
		</div>
	</div>
<!-- End Groups-->

<!-- Publication -->				
	<div class="col-md-6 col-sm-6">	
		<div class="row option option-yellow">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>"><span><?php echo count($publication);?></span></a><p>Publications</p>
			</div>
			<div class="col-sm-6 col-xs-12 select">							
				<select name="name" id = "pub_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
						<?php foreach($publication as $pub_row){ ?>
					<option value = "<?php echo($pub_row['id'])?>" ><?php echo($pub_row['name']); ?></option>
				<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
<!-- End Publication-->

<!-- Designer -->	
<div class="row">
	<div class="col-md-6 col-sm-6">	
		<div class="row option option-red">
			<div class="col-md-5 col-sm-12 col-xs-12 count">							
				<a href="<?php echo base_url().index_page().'new_admin/home/designer_details'?>"><span><?php echo count($designer);?></span><p>Designers</p></a>
			</div>
			<div class="col-sm-6 col-xs-12 select">							
				<select name="name" id = "designer_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
						<?php foreach($designer as $desgn_row){ ?>
							<option value = "<?php echo($desgn_row['id'])?>" ><?php echo($desgn_row['name']); ?>(<?php echo ($desgn_row['username']);?>)</option>
						<?php } ?>
				</select>
			</div>
		</div>					
	</div>
<!-- End Designer-->

<!-- CSR -->				
	<div class="col-md-6 col-sm-6">		 
		<div class="row option option-green">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/csr_admin_details'?>"><span><?php echo count($csr);?></span><p>CSR</p></a>
			</div>
			<div class="col-sm-6 col-xs-12 select">							
				<select name="name" id = "csr_list" class="select2me form-control margin-bottom-10">
					<option value="all">Select</option>
					<?php foreach($csr as $row3){ ?>
					<option value = "<?php echo($row3['id'])?>" ><?php echo($row3['name']); ?>(<?php echo($row3['username']); ?>)</option>
				<?php } ?>
				</select>
			</div>
		</div>
	</div>		
</div>
<!-- End CSR-->

<!-- Helpdesk -->	
<div class="row">	
	 <div class="col-md-6 col-sm-6">					
		<div class="row option option-blue-cadet">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/help_desk'?>"><span><?php echo count($helpdesk);?></span><p>Helpdesk</p></a>
			</div>
			<div class="col-sm-6 col-xs-12 select">							
				<select name="name" id="helpdesk_list" class="select2me form-control margin-bottom-10">
					<option value="">Select</option>
						<?php foreach($helpdesk as $hd_row){ ?>
							<option value = "<?php echo($hd_row['id'])?>" ><?php echo($hd_row['name']); ?></option>
						<?php } ?>
				</select>
			</div>
		</div>
	</div>		
<!-- End Helpdesk-->

<!-- Design Team -->
	<div class="col-md-6 col-sm-6">
		<div class="row option option-brown">
			<div class="col-md-5 col-sm-12 col-xs-12 count">						
				<a href="<?php echo base_url().index_page().'new_admin/home/design_team'?>"><span><?php echo count($design_team);?></span><p>Design Team </p></a>
			</div>
			<div class="col-sm-6 col-xs-12 select">							
				<select name="name" id ="designteam_list" class="select2me form-control margin-bottom-10">
					<option value="">Select</option>
					<?php foreach($design_team as $dt_row){ ?>
					<option value = "<?php echo($dt_row['id'])?>" ><?php echo($dt_row['name']); ?></option>
				<?php } ?>
				</select>
			</div>
		
		</div>
	</div>
</div>	
<!-- End Design Team-->

<!-- Templates, Image bank, Complaint --> 
<div class="row">		
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/report_templates' ?>"><div class="option-theme1">Templates</div></a>
	</div>			 
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/report_imagebank' ?>"><div class="option-theme2">Image Bank</div></a>
	</div>
	<!--<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/reports_complaint' ?>"><div class="option-theme3">Complaints</div></a>
	</div>-->
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/report_template_GM' ?>"><div class="option-theme4">Coupon Library</div></a>
	</div>
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/notification_list' ?>"><div class="option-theme3">Notification</div></a>
	</div>
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<a href="<?php echo base_url().index_page().'new_admin/home/production_nj' ?>"><div class="option-theme5">Production NJ</div></a>
	</div>
	<!--<div class="col-md-3 col-sm-6 margin-bottom-20">
		<div class="option-theme1 padding-0">
		<form  role="form" method="get" action="<?php echo base_url().index_page().'new_admin/home/order_rev_status'?>" enctype="multipart/form-data">
			<div class="input-group padding-10">
				<input type="text" class="form-control" name="id" placeholder="Enter Order ID" >
				<span class="input-group-btn">
					<button type="submit" name="search" class="btn bg-grey-gallery">Search</button>
				</span>
			</div>
		</form>	
		</div>
	</div> -->
	
	<div class="col-md-3 col-sm-6 margin-bottom-20">
		<div class="option-theme2 padding-0">
		<form  role="form" method="get" action="<?php echo base_url().index_page().'new_admin/home/search_email'?>" enctype="multipart/form-data">
			<div class="input-group padding-10">
				<input type="email" class="form-control" name="email_id" placeholder="Enter Email Address" >
				<span class="input-group-btn">
					<button type="submit" name="search" class="btn bg-grey-gallery">Search</button>
				</span>
			</div>
		</form>
		</div>
	</div>
</div>
</div>
<!-- End -->
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