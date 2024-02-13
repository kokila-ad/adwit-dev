<?php $this->load->view('new_admin/header')?>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
<div class="page-content">
	<div class="container">
		<div class="row margin-top-10">
			<div class="font-lg margin-bottom-5 margin-left-15">	Sales</div>
			 <div class="col-md-6 col-sm-6">				
				<div class="row option option-blue">
					<div class="col-md-5 col-sm-12 col-xs-12 count">							
						<a href="groups.html"><span><?php echo count($group);?></span><p>Groups</p><a>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 select">							
						<select name="name" class="select2me form-control margin-bottom-10">
							<option value="all">Select</option>
								<?php foreach($group as $grp_row){ ?>
									<option value = "<?php echo($grp_row['id'])?>" ><?php echo($grp_row['name']); ?></option>
								<?php } ?>
						</select>
					</div>   
					<div class="col-md-3 col-sm-6 col-xs-12 create">							
						<form>
							<div class="btn-group left-dropdown">
								<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
									<a ><span>+</span> <p> Create</p></a>
								</div>
								<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
									<div class="row">
										<div class="col-md-5 col-sm-12">
											<label>Name</label>
											<input type="text" class="form-control">
										</div>
										<div class="col-md-7 col-sm-12">
											<label>Channel <span class="font-red">*</span> <small>(Select One)</small></label>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 1 </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 2 </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 3 </label>
											</div>
										</div>
										<div class="col-md-5 col-sm-12">
											<label>Initial</label>
											<input type="text" class="form-control">
										</div>
										<div class="col-md-7 col-sm-12">
											<label>Display Publication List <small>(Group Report Email)</small></label>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Yes </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> No </label>
											</div>
										</div>
										<div class="col-md-12 col-sm-12 text-right">
											<input type="button" class="btn btn-primary btn-sm" value="Create">
										</div>
									</div>
								</div>
							</div>
						 </form>	
					</div>
				</div>
			  </div>
			  
			 <div class="col-md-6 col-sm-6">				
				<div class="row option option-yellow">
					<div class="col-md-5 col-sm-12 col-xs-12 count">						
						<span><?php echo count($publication);?></span><p>Publications</p>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 select">							
						<select name="name" class="select2me form-control margin-bottom-10">
							<option value="all">Select</option>
								<?php foreach($publication as $pub_row){ ?>
							<option value = "<?php echo($pub_row['id'])?>" ><?php echo($pub_row['name']); ?></option>
						<?php } ?>
						</select>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 create">							
						<form>
							<div class="btn-group left-dropdown">
								<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
									<a ><span>+</span> <p> Create</p></a>
								</div>
								<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
									<div class="row">
										<div class="col-md-5 col-sm-12">
											<label>Name</label>
											<input type="text" class="form-control">
										</div>
										<div class="col-md-7 col-sm-12">
											<label>Channel <span class="font-red">*</span> <small>(Select One)</small></label>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 1 </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 2 </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 3 </label>
											</div>
										</div>
										<div class="col-md-5 col-sm-12">
											<label>Initial</label>
											<input type="text" class="form-control">
										</div>
										<div class="col-md-7 col-sm-12">
											<label>Display Publication List <small>(Group Report Email)</small></label>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Yes </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> No </label>
											</div>
										</div>
										<div class="col-md-5 col-sm-12">
											<label>Name</label>
											<input type="text" class="form-control">
										</div>
										<div class="col-md-7 col-sm-12">
											<label>Channel <span class="font-red">*</span> <small>(Select One)</small></label>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 1 </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 2 </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Metro 3 </label>
											</div>
										</div>
										<div class="col-md-5 col-sm-12">
											<label>Initial</label>
											<input type="text" class="form-control">
										</div>
										<div class="col-md-7 col-sm-12">
											<label>Display Publication List <small>(Group Report Email)</small></label>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default">
												<input type="radio" class="toggle"> Yes </label>
												<label class="btn btn-default">
												<input type="radio" class="toggle"> No </label>
											</div>
										</div>
										<div class="col-md-12 col-sm-12 text-right">
											<input type="button" class="btn btn-primary btn-sm" value="Create">
										</div>
									</div>
								</div>
							</div>
						 </form>
					</div>
				</div>
			  </div>
		</div>
		
		<div class="row margin-top-10">
			<div class="font-lg margin-bottom-5 margin-left-15">	Production</div>
			 <div class="col-md-6 col-sm-6">				
				<div class="row option option-red">
					<div class="col-md-5 col-sm-12 col-xs-12 count">							
						<span><?php echo count($designer);?></span><p>Designers</p>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 select">							
						<select name="name" class="select2me form-control margin-bottom-10">
							<option value="all">Select</option>
								<?php foreach($designer as $desgn_row){ ?>
									<option value = "<?php echo($desgn_row['id'])?>" ><?php echo($desgn_row['name']); ?></option>
								<?php } ?>
						</select>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 create">							
						<form>
							<div class="btn-group left-dropdown">
								<div class="dropdown" data-toggle="dropdown" aria-expanded="true">
									<a ><span>+</span> <p> Create</p></a>
								</div>
								<!--<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
									<div class="row">
										<div class="col-md-10 col-sm-12">
											<input type="text" class="form-control" placeholder="Name">
										</div>
										<div class="col-md-2 col-sm-12">
											<input type="button" class="btn btn-primary btn-sm btn-block" value="Create">
										</div>
									</div>
								</div>-->
							</div>
						 </form>	
					</div>
				</div>
			  </div>
			  
			 <div class="col-md-6 col-sm-6">				
				<div class="row option option-green">
					<div class="col-md-5 col-sm-12 col-xs-12 count">						
						<span><?php echo count($csr);?></span><p>CSR</p>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 select">							
						<select name="name" class="select2me form-control margin-bottom-10">
									<option value="all">Select</option>
									<?php foreach($csr as $row3){ ?>
									<option value = "<?php echo($row3['id'])?>" ><?php echo($row3['name']); ?></option>
								<?php } ?>
						</select>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 create">							
						<span>+</span><p>Create</p>
					</div>
				</div>
			  </div>
			  
			  <div class="col-md-6 col-sm-6">				
				<div class="row option option-blue-cadet">
					<div class="col-md-5 col-sm-12 col-xs-12 count">						
						<span><?php echo count($helpdesk);?></span><p>Helpdesk</p>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 select">							
						<select name="name" class="select2me form-control margin-bottom-10">
							<option value="">Select</option>
								<?php foreach($helpdesk as $hd_row){ ?>
									<option value = "<?php echo($hd_row['id'])?>" ><?php echo($hd_row['name']); ?></option>
								<?php } ?>
						</select>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 create">							
						<span>+</span><p>Create</p>
					</div>
				</div>
			  </div>
			  
			  <div class="col-md-6 col-sm-6">				
				<div class="row option option-brown">
					<div class="col-md-5 col-sm-12 col-xs-12 count">						
						<span><?php echo count($design_team);?></span><p>Design Team </p>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 select">							
						<select name="name" class="select2me form-control margin-bottom-10">
									<option value="">Select</option>
									<?php foreach($design_team as $dt_row){ ?>
									<option value = "<?php echo($dt_row['id'])?>" ><?php echo($dt_row['name']); ?></option>
								<?php } ?>
								</select>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 create">							
						<span>+</span><p>Create</p>
					</div>
				</div>
			  </div>
		</div>
		
	</div>
</div>
</div>

<?php $this->load->view('new_admin/footer')?>