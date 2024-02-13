<?php $this->load->view('new_admin/header')?>
<?php $this->load->view('new_admin/amchart')?>

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
					<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>" class="font-lg font-grey-gallery"><u>Publication</u></a>
				</div>
				<div class="col-md-6 col-xs-4 text-right">	
					<form role="form" method = "post">
						<div class="btn-group left-dropdown">
							<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
						</div>
					</form>	
				</div>								
			</div>
		</div>		
		<div class="portlet-body">
			<div class="row">
				 <div class="col-md-6 margin-bottom-20">
					<p class="bold align-center" style="margin-bottom: -20px;">Publication's</p>
					<div id="chartdiv3" style="height: 240px;"></div>
					<p class="align-center margin-bottom-30" style="margin-top: -10px;">
						<small class="font-grey-gallery">
						<a href="<?php echo base_url().index_page().'new_admin/home/publication_internal'?>" class="cursor-pointer" id="pub_internal">Internal - <span class="bold"><?php if(isset($ord_sys_internal)){ echo $ord_sys_internal;} else { echo "-";}?></span> </a> 
						&nbsp; | &nbsp;
						<a href="<?php echo base_url().index_page().'new_admin/home/publication_external'?>"class="cursor-pointer" id="pub_external">External - <span class="bold"><a href="<?php echo base_url().index_page().'new_admin/home/publication_external'?>"><?php if(isset($ord_sys_external)){ echo $ord_sys_external;} else { echo "-";}?></span></a></small></a>
					</p>
				 </div>		
				 <div class="col-md-6">
					<p class="bold align-center" style="margin-bottom: -20px;">AdRep's</p>
					<div id="chartdiv2" style="height: 240px;"></div>	
					<p class="align-center margin-bottom-30" style="margin-top: -10px;">
						<small class="font-grey-gallery">
						<a href="<?php echo base_url().index_page().'new_admin/home/adrep_internal'?>"class="cursor-pointer" id="adrep_internal">Internal - <span class="bold"><?php echo $in_adreps_count; ?></span> </a> 
						&nbsp; | &nbsp;
						<a href="<?php echo base_url().index_page().'new_admin/home/adrep_external'?>"class="cursor-pointer" id="adrep_external">External - <span class="bold"><?php echo $ext_adreps_count; ?></span></small></a>
					</p>
				 </div>						 
			</div>
		</div>
	</div>
<?php }else {?>
			
<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12 margin-top-5">
				<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>" class="font-lg font-grey-gallery">Publication</a> -
				<a href="<?php echo base_url().index_page().'new_admin/home/publication'?>" class="font-lg font-grey-gallery"><u><?php $pub_name = $this->db->get_where('publications',array('id' => $id))->row_array(); echo $pub_name['name'];?></u></a>
			</div>
			
			<div class="col-md-4 col-xs-8 margin-bottom-10 text-right"></div>
			
			<div class="col-md-1 col-xs-4 margin-top-5 text-right">	
				<form role="form" method="post">
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
						<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<div class="row">
		    <div class="col-md-12 col-xs-8 margin-bottom-10 text-right">
    			<?php if(null != $this->session->flashdata('message')){ ?>						
    				<div class="alert alert-success margin-0 padding-5 small"><?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?></div>
    			<?php } ?>
			</div>
		</div>
	<div class="portlet-body">	
		<div class="row">
			<div class="col-md-6 col-sm-12 margin-bottom-20">
				<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">AdRep Name - <span class="badge"><?php echo count($adrep);?></span></a> </p>
				<table class="table table-bordered table-hover" id="sample_6">
					<thead >
						<tr>
						    <th>Name</th>
						    <th>Email Id</th>
						    <th>UserName</th>
					    </tr>
					</thead>
					<tbody>
					<?php if(isset($adrep)){?>
					<?php foreach($adrep as $row){ ?> 
						<tr>
						    <td><a href="<?php echo base_url().index_page().'new_admin/home/adrep_profile/'.$row['id']; ?>"><?php echo $row['first_name'].' '.$row['last_name'];?></a></td>
						    <td><?php echo $row['email_id']; ?></td>
						    <td><?php echo $row['username']; ?></td>
						</tr>
					<?php } }?>	
					</tbody>
				</table>						
			</div>
			
			<div class="col-md-6 col-sm-12">
				<div class="row">
				 <form method="post" name="order_form" id="order_form">
					
					<div class="col-md-12">
						<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Publication Details
							<span class="pull-right"><button  id="submit_form" type="submit" name="update_pub" class="btn btn-xs btn-primary margin-left-10">Save Changes</button></span> 
						</p>										
					</div><div class="col-md-12 col-sm-12">
						<div class="manage-details"  id="form">
							<ul>
								<li class="border-top">
									<div class="title">Publication Name</div>
									<div class="data">
										<input type="text" value="<?php if($publication[0]['name']!='')echo $publication[0]['name']; else echo"-";?>" name="name" class="form-control input-sm" placeholder="" required>
									</div>
								</li>
								<li>
									<div class="title">Channel Name</div>
									<div class="data">
									<select class="form-control input-sm" name="channel" required>
									    <option value="">Select</option>
											<?php foreach($channels as $ch_row){ ?>
										<option value="<?php echo($ch_row['id'])?>" <?php if($publication[0]['channel']==$ch_row['id']){ echo "selected"; } ?> ><?php echo($ch_row['name']); ?></option>
											<?php } ?>
									</select>				
									</div>
								</li>
								
								<li>
									<div class="title">Group Name</div>
									<div class="data">
									<select class="form-control input-sm" name="group" required>
									    <option value="">Select</option>
											<?php foreach($group as $grp_row){ ?>
										<option value="<?php echo($grp_row['id'])?>" <?php if($publication[0]['group_id']==$grp_row['id']){ echo "selected"; } ?> ><?php echo($grp_row['name']); ?></option>
											<?php } ?>
									</select>				
									</div>
								</li>
								
								<li>
									<div class="title">Helpdesk Name</div>
									<div class="data">
									<select class="form-control input-sm" name="help_desk" required>
									    <option value="">Select</option>
											<?php foreach($helpdesk as $hd_row){ ?>
										<option value = "<?php echo($hd_row['id'])?>"  <?php if($publication[0]['help_desk']==$hd_row['id']){ echo "selected"; } ?> ><?php echo($hd_row['name']); ?></option>
											<?php } ?>
									</select>
									</div>
								</li>
								
								<li>
									<div class="title">Initial</div>
									<div class="data">
									<input type="text" name="initial" class="form-control input-sm" value="<?php if($publication[0]['initial']!='')echo $publication[0]['initial']; else echo"-";?>"></div>
								</li>
								
								<li>
									<div class="title">Design Team</div>
									<div class="data">
									<select class="form-control input-sm" name="design_team_id" required>
									    <option value="">Select</option>
											<?php foreach($design_team as $design_row){ ?>
										<option value = "<?php echo($design_row['id'])?>" <?php if($publication[0]['design_team_id']==$design_row['id']){ echo "selected"; } ?>><?php echo($design_row['name']); ?></option>
										<?php } ?>
									</select>
									</div>
								</li>
								<li>
									<div class="title">Advertising Director Email</div>
									<div class="data">
										<input type="email" name = "advertising_director_email_id" class="form-control input-sm" value="<?php if($publication[0]['advertising_director_email_id']!='')echo $publication[0]['advertising_director_email_id'];?>" >
									</div>
								</li>
								<li>
									<div class="title">Slug Type</div>
									<div class="data">
									<select class="form-control input-sm" name="slug_type" required>
									    <option value="">Select</option>
											<?php foreach($slug_type as $slug_type_row){ ?>
										<option value = "<?php echo ($slug_type_row['id'])?>" <?php if($publication[0]['slug_type']==$slug_type_row['id']){ echo "selected"; } ?>><?php echo($slug_type_row['name']);?></option>
											<?php }?>	
									</select>
									</div>
								</li>
								
								<li>
									<div class="title">Source File</div>
									<div class="data">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-xs btn-default <?php if($publication[0]['enable_source']== '1')echo"active";?> ">
											<input type="radio" name="enable_source" value="1" <?php if($publication[0]['enable_source']== '1')echo"checked";?> class="toggle"> Enable </label>
											<label class="btn btn-xs btn-default <?php if($publication[0]['enable_source']== '0')echo"active";?> ">
											<input type="radio" name="enable_source" value="0" <?php if($publication[0]['enable_source']== '0')echo"checked";?> class="toggle"> Disable </label>
										</div>	
									</div>	
								</li>
								<li>
									<div class="title">Revision Submission Limit No.of Days</div>
									<div class="data">
										<input type="number" value="<?php if($publication[0]['rev_days']!='')echo $publication[0]['rev_days']; else echo"-";?>" name="rev_days" class="form-control input-sm" >
									</div>
								</li>
								<li>
									<div class="title">Account Status</div>
									<div class="data">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-xs btn-default <?php if($publication[0]['is_active']== '1')echo"active";?> ">
										<input type="radio" name="is_active" value="1" <?php if($publication[0]['is_active']== '1')echo"checked";?> class="toggle"> Active </label>
										<label class="btn btn-xs btn-default <?php if($publication[0]['is_active']== '0')echo"active";?>">
										<input type="radio" name="is_active" value="0" <?php if($publication[0]['is_active']== '0')echo"checked";?> class="toggle"> In Active </label>
									</div>
									</div>
								</li>
								<li>
									<div class="title">Ordering System</div>
									<div class="data">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-xs btn-default <?php if($publication[0]['ordering_system']== '1')echo"active";?> ">
										<input type="radio" name="ordering_system" value="1" <?php if($publication[0]['ordering_system']== '1')echo"checked";?> class="toggle" required> Internal </label>
										<label class="btn btn-xs btn-default <?php if($publication[0]['ordering_system']== '2')echo"active";?>">
										<input type="radio" name="ordering_system" value="2" <?php if($publication[0]['ordering_system']== '2')echo"checked";?> class="toggle" required> External </label>
									</div>
									</div>
								</li>
								<!--idml Starts-->
								<li>
									<div class="title">IDML</div>
									<div class="data">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-xs btn-default <?php if($publication[0]['idml']== '1')echo"active";?> ">
											<input type="radio" name="idml" value="1" <?php if($publication[0]['idml']== '1')echo"checked";?> class="toggle"> Enable </label>
											<label class="btn btn-xs btn-default <?php if($publication[0]['idml']== '0')echo"active";?> ">
											<input type="radio" name="idml" value="0" <?php if($publication[0]['idml']== '0')echo"checked";?> class="toggle"> Disable </label>
										</div>	
									</div>
								</li>
								<!--idml Ends-->
								
								<!--Club Interface -->
								<li>
									<div class="title">Club Name</div>
									<div class="data">
									<select class="form-control input-sm" name="club" required>
									<option value="">Select</option>
											<?php foreach($club as $club_row){ ?>
										<option value = "<?php echo $club_row['id'];?>" <?php if($publication[0]['club_id']==$club_row['id']){ echo "selected"; } ?>><?php echo($club_row['name']);?></option>
											<?php }?>	
									</select>
									</div>
								</li>
								<!--Pdf review-->
								<li>
									<div class="title">PDF Review</div>
									<div class="data">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-xs btn-default <?php if($publication[0]['pdf_review']== '1')echo"active";?> ">
											<input type="radio" name="pdf_review" value="1" <?php if($publication[0]['pdf_review']== '1')echo"checked";?> class="toggle"> Enable </label>
											<label class="btn btn-xs btn-default <?php if($publication[0]['pdf_review']== '0')echo"active";?> ">
											<input type="radio" name="pdf_review" value="0" <?php if($publication[0]['pdf_review']== '0')echo"checked";?> class="toggle"> Disable </label>
										</div>	
									</div>
								</li>
								<!-- Time zone For prioritising ads -->
								<li>
									<div class="title">Time Zone</div>
									<div class="data">
    									<select class="form-control input-sm" name="time_zone" required>
        									<?php foreach($time_zone as $tz){ ?>
        										<option value = "<?php echo ($tz['time_zone_id'])?>" <?php if($publication[0]['time_zone_id']==$tz['time_zone_id']){ echo "selected"; } ?>><?php echo($tz['time_zone_name']);?></option>
        									<?php } ?>	
    									</select>
									</div>
								</li>
								<!--mood board enable-->
								<li>
									<div class="title">Mood Board</div>
									<div class="data">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-xs btn-default <?php if($publication[0]['is_mood_board_enable']== '1')echo"active";?> ">
											<input type="radio" name="is_mood_board_enable" value="1" <?php if($publication[0]['is_mood_board_enable']== '1')echo"checked";?> class="toggle"> Enable </label>
											<label class="btn btn-xs btn-default <?php if($publication[0]['is_mood_board_enable']== '0')echo"active";?> ">
											<input type="radio" name="is_mood_board_enable" value="0" <?php if($publication[0]['is_mood_board_enable']== '0')echo"checked";?> class="toggle"> Disable </label>
										</div>	
									</div>
								</li>
							</ul>
						</div>
					</div>
				 </form>	
			 <?php }?>
				 
				<?php if($id != ''){ ?>
					 <div class="col-md-12 col-sm-12 margin-top-30">
						<form method="post" name="order_form" id="order_form" action="<?php echo base_url().index_page().'new_admin/home/create_adrep/'.$id; ?>">
						<p class="font-md bold">Create Adrep</p>
							<div class="row ">
								<div class="col-md-6 margin-bottom-10">
									<input type="text" pattern="[a-zA-Z]+" style="text-transform: capitalize;" title="Only Alphabets" name="first_name" class="form-control" required="" placeholder="First Name">
								</div>

								<div class="col-md-6 margin-bottom-10">
									<input type="text" pattern="[a-zA-Z]+" style="text-transform: capitalize;" title="Only Alphabets" name="last_name" class="form-control" required="" placeholder="Last Name">
								</div>								
								<div class="col-md-6 margin-bottom-10">
									<input type="email" name="email_id" class="form-control" placeholder="Email Address" required>
								</div>
												
								<div class="col-md-6 margin-bottom-10">
									<input type="text" name="username" class="form-control" placeholder="Username" required>
								</div>
							</div>
							
							<div class="col-md-12 text-right"><hr>
								<label><input type="checkbox" name="send_mail" value="1">Send mail to adrep &nbsp;</label>
								<button type="submit" name ="submit" class="btn bg-red-intense border-radius-5">Create</button>
							</div>	
							<div class="col-md-7 col-md-offset-7 margin-top-10 text-center"></div>
						</form>
					</div> 
				<?php } ?>
			</div>
		  </div>						
	  </div>
	</div>
</div>
		
		
<script>	
	var chart2Data = [
	{ type1: "External", ads1: <?php echo $ext_adreps_count; ?>},
	{ type1: "Internal", ads1: <?php echo $in_adreps_count; ?>}
	];
	AmCharts.ready(function () {
	
	// PIE CHART
    var chart2 = new AmCharts.AmPieChart();
    chart2.dataProvider = chart2Data;
    chart2.titleField = "type1";
	chart2.fontFamily = "Open Sans";
    chart2.valueField = "ads1";
    chart2.sequencedAnimation = true;
    chart2.innerRadius = "0%";   
	chart2.startDuration = .9;
    chart2.labelText = "[[title]]"
    chart2.hideLabelsPercent = 4;
    chart2.labelRadius = 5;
    chart2.write("chartdiv2");
});
</script>

<script>	
	var chart3Data = [
	{ type: "External", ads:<?php if(isset($ord_sys_external)){ echo $ord_sys_external;} else { echo "-";}?>},
	{ type: "Internal", ads: <?php if(isset($ord_sys_internal)){ echo $ord_sys_internal;} else { echo "-";}?>}
	];
	AmCharts.ready(function () {
	
	// PIE CHART
    var chart3 = new AmCharts.AmPieChart();
    chart3.dataProvider = chart3Data;
    chart3.titleField = "type";
    chart3.valueField = "ads";
    chart3.sequencedAnimation = true;
    chart3.innerRadius = "0%";
    chart3.startDuration = .9;
    chart3.labelText = "[[title]]"
    chart3.hideLabelsPercent = 4;
    chart3.labelRadius = 5;
	//chart3.balloonText = "[[type]]:[[value]]";
    chart3.write("chartdiv3");
});
</script>

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>