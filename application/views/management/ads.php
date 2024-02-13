<?php $this->load->view("management/head"); ?>

<style>
.box .table>tbody>tr>td , .box .table>thead>tr>th{padding:4px;}
.box .table>thead>tr>th{font-size:13px;}
.box input[type="search"]{padding:4px;font-size:12px;height:25px;}
</style>

<!-- Start of Script to hide one page and pop the other -->
<script type="text/javascript">
$(document).ready(function(){
	//$("#pub_count").hide();
	$("#pub_details").hide();
	
	$("#publi_count").change(function(){
		$("#pub_count").toggle();
		$("#pub_details").hide();
	});
	
	$("#publi_details").change(function(){
		$("#pub_details").show();
		$("#pub_count").hide();  	
	});
	
	//$("#group_count").hide();
	$("#group_details").hide();
	
	$("#group_count").change(function(){
		$("#group_count").toggle();
		$("#group_details").hide();
	});
	
	$("#group_details").change(function(){
		$("#group_details").show();
		$("#group_count").hide();  	
	});
	
	//$("#adrep_count").hide();
	$("#adrep_details").hide();
	
	$("#adrep_count").change(function(){
		$("#adrep_count").toggle();
		$("#adrep_details").hide();
	});
	
	$("#adrep_details").change(function(){
		$("#adrep_details").show();
		$("#adrep_count").hide();  	
	});
		
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="publication"){
                $(".box").not(".publication").hide();
                $(".publication").show();
            }
            else if($(this).attr("value")=="group"){
                $(".box").not(".group").hide();
                $(".group").show();
            }
            else if($(this).attr("value")=="adrep"){
                $(".box").not(".adrep").hide();
                $(".adrep").show();
            }
            else{
                $(".box").hide();
            }
        });
    }).change();
});

</script>
<!-- End of script-->
<!-- Start of Script to display type in dropdown-->
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'management/home/ads/';?>" + $('#display_type').val() ;
        });
    });
</script>
<!-- End of script-->

<body>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<div class="page-content">
		<div class="container">
		
			<div class="row margin-top-15">
				<div class="col-sm-3">
					<div class="portlet light">
						<div class="portlet-body">
						<form role="form" >
								<select id="display_type" name="display_type" class="form-control margin-bottom-10 bg-blue-chambray">
								  <option value="">Select</option>
								   <option value="group" <?php echo ($display_type=='group' ? 'selected="selected"' : ''); ?> >Group</option>
								  <option value="publication" <?php echo ($display_type=='publication' ? 'selected="selected"' : ''); ?> >Publication</option>
								   <option value="adrep" <?php echo ($display_type=='adrep' ? 'selected="selected"' : ''); ?> >AdRep</option>
								</select>
						</form>
							<?php if($display_type=='publication'){?>
							 
								<div class="publication box" style="display: block;">
								<form role="form" method="post" onsubmit="return checkTheBox();" >
									<div class="scroller" style="height:296px;" data-always-visible="1" data-rail-visible="0">	
										<table class="table table-hover" id="sample_3">
											<thead>
												<tr>
													<th class="table-checkbox"><input type="checkbox" name="pall" class="group-checkable" data-set="#sample_3 .checkboxes"/></th>
													<th>Select All</th>
												</tr>
											</thead>
											<tbody>
											<?php if(isset($publication_details)){ ?>
											<?php foreach($publication_details as $row_details){ ?>
												<tr class="odd gradeX">
												<td><input type="checkbox" name="pId[]" class="checkboxes" value="<?php echo $row_details['id'];?>" checked="checked"/></td>
													<td><?php echo $row_details['name'];?></td>
												</tr>
											<?php } ?>
											<?php } ?>
											<?php if(isset($publication)){?>
												<?php foreach($publication as $row){?>
												<tr class="odd gradeX">
												<td><input type="checkbox" name="pId[]" class="checkboxes" value="<?php echo $row['id'];?>" /></td>
													<td><?php echo $row['name'];?></td>
												</tr>
											<?php }?>
											<?php }?>
											</tbody>
										</table>
									</div>
									<hr class="no-space">
									<div class="row margin-top-10">
										<div class="col-xs-12 no-space">
											<div class="input-group input-sm date date-picker" data-date="2016-08-01" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												<span class="input-group-btn">
												<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="from" class="form-control input-sm" <?php if(isset($from)){echo "value='$from'"; } ?> placeholder="From Date" required />												
											</div>
										</div>
										<div class="col-xs-12 no-space">
											<div class="input-group input-sm date date-picker" data-date="2016-08-01" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												<span class="input-group-btn">
												<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="to" class="form-control input-sm" <?php if(isset($to)){echo "value='$to'"; } ?> placeholder="To Date" required />												
											</div>
										</div>
										<div class="col-xs-12 margin-top-5 margin-bottom-5 text-center">
											<span class="margin-right-10">
												<label><input type="radio" id="publi_count" name="display" value="count" <?php if(isset($pub_display) && $pub_display=='count'){echo "checked"; } ?> required />&nbsp;Count</label>
											</span>
												<label>&nbsp;<input type="radio" id="publi_details" name="display" value="details" <?php if(isset($pub_display) && $pub_display=='details'){echo "checked"; } ?>  />&nbsp;Details</label>
										</div>
										<div class="col-xs-8 col-xs-offset-2 margin-bottom-10 text-center">
											<button type="submit" name="pub_submit" class="btn blue-chambray btn-sm btn-block">Search</button>
										</div>
									</div>
									</form>
								</div>
							
							<?php } ?>
							
							 
					<?php if($display_type=='group'){?>	
										
								<div class="group box" style="display: block;">
								<form role="form" method="post" onsubmit="return checkTheBox();">
									<div class="scroller" style="height:296px;" data-always-visible="1" data-rail-visible="0">	
										<table class="table table-hover" id="sample_4">
											<thead>
												<tr>
													<th class="table-checkbox"><input type="checkbox" name="gall" class="group-checkable" data-set="#sample_4 .checkboxes"/></th>
													<th>Select All</th>
												</tr>
											</thead>
											<tbody>
											<?php if(isset($group_details)){ ?>
											<?php foreach($group_details as $row_details){ ?>
												<tr class="odd gradeX">
												<td><input type="checkbox" name="gId[]" class="checkboxes" value="<?php echo $row_details['id'];?>" checked="checked"/></td>
													<td><?php echo $row_details['name'];?></td>
												</tr>
											<?php } ?>
											<?php } ?>
											<?php if(isset($groups)){?>
												<?php foreach($groups as $row){?>
												<tr class="odd gradeX">
												<td><input type="checkbox" name="gId[]" class="checkboxes" value="<?php echo $row['id'];?>" /></td>
													<td><?php echo $row['name'];?></td>
												</tr>
											<?php }?>
											<?php }?>
											</tbody>
										</table>
									</div>
									<hr class="no-space">
									<div class="row margin-top-10">
										<div class="col-xs-12 no-space">
											<div class="input-group input-sm date date-picker" data-date="2016-08-01" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												<span class="input-group-btn">
												<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name= "from" class="form-control input-sm" <?php if(isset($from)){echo "value='$from'"; } ?> placeholder="From Date" required>												
											</div>
										</div>
										<div class="col-xs-12 no-space">
											<div class="input-group input-sm date date-picker" data-date="2016-08-01" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												<span class="input-group-btn">
												<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name= "to" class="form-control input-sm" <?php if(isset($to)){echo "value='$to'"; } ?> placeholder="To Date" required>												
											</div>
										</div>
										<div class="col-xs-12 margin-top-5 margin-bottom-5 text-center">
											<span class="margin-right-10">
												<label><input type="radio" id="group_count" name="grp_display" value="count" <?php if(isset($grp_display) && $grp_display=='count'){echo "checked"; } ?> required/> &nbsp;Count</label>
											</span>
												<label>&nbsp;<input type="radio" id="group_details" name="grp_display" value="details" <?php if(isset($grp_display) && $grp_display=='details'){echo "checked"; } ?>/>&nbsp;Details</label>
										</div>
										<div class="col-xs-8 col-xs-offset-2 margin-bottom-10 text-center">
											<button type="submit" name="grp_submit" class="btn blue-chambray btn-sm btn-block">Search</button>
										</div>
									</div>
									</form>
								</div>
							
					<?php } ?>
										 
					<?php if($display_type=='adrep'){?>	
											
								<div class="adrep box">
								<form role="form" method="post" onsubmit="return checkTheBox();">
									<div class="scroller" style="height:296px;" data-always-visible="1" data-rail-visible="0">	
										<table class="table table-hover" id="sample_5">
											<thead>
												<tr>
													<th class="table-checkbox"><input type="checkbox" name="aall" class="group-checkable" data-set="#sample_5 .checkboxes"/></th>
													<th>Select All</th>
												</tr>
											</thead>
											<tbody>
											<?php if(isset($adrep_details)){ ?>
											<?php foreach($adrep_details as $row_details){ ?>
												<tr class="odd gradeX">
												<td><input type="checkbox" name="aId[]" class="checkboxes" value="<?php echo $row_details['id'];?>" checked="checked"/></td>
													<td><?php echo $row_details['first_name'].' '.$row_details['last_name'];?></td>
												</tr>
											<?php } ?>
											<?php } ?>
											<?php if(isset($adrep)){?>
												<?php foreach($adrep as $row){?>
												<tr class="odd gradeX">
												<td><input type="checkbox" name = "aId[]" class="checkboxes" value="<?php echo $row['id'];?>" /></td>
													<td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
												</tr>
											<?php }?>
											<?php }?>
											</tbody>
										</table>
									</div>
									<hr class="no-space">
									<div class="row margin-top-10">
										<div class="col-xs-12 no-space">
											<div class="input-group input-sm date date-picker" data-date="01-08-2016" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
												<span class="input-group-btn">
												<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="from" class="form-control input-sm" <?php if(isset($from)){echo "value='$from'"; } ?> placeholder="From Date" required>												
											</div>
										</div>
										<div class="col-xs-12 no-space">
											<div class="input-group input-sm date date-picker" data-date="01-08-2016" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
												<span class="input-group-btn">
												<button class="btn default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="to" class="form-control input-sm" <?php if(isset($to)){echo "value='$to'"; } ?> placeholder="To Date" required>												
											</div>
										</div>
										<div class="col-xs-12 margin-top-5 margin-bottom-5 text-center">
											<span class="margin-right-10">
												<label><input type="radio" id="adrep_count" name="adrp_display" value="count" <?php if(isset($adrp_display) && $adrp_display=='count'){echo "checked"; } ?>>&nbsp;Count</label>
											</span>
												<label>&nbsp;<input type="radio" id="adrep_details" name="adrp_display" value="details" <?php if(isset($adrp_display) && $adrp_display=='details'){echo "checked"; } ?>>&nbsp;Details</label>
										</div>
										<div class="col-xs-8 col-xs-offset-2 margin-bottom-10 text-center">
											<button type="submit" name="adrp_submit" class="btn blue-chambray btn-sm btn-block">Search</button>
										</div>
									</div>
									</form>
								</div>							
					<?php } ?> 
							<!--</form>-->
						</div>
					</div>
				</div>
				
				
<!-- publication count -->
<?php if(isset($pub_display) && $pub_display == 'count'){ ?>
<?php if(isset($publication_details)){ ?>
	<div class="col-sm-9">
<!-----Start: Table 1---->
					<div class="portlet light" >
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-6 value margin-top-5">Publication Count</div>		
								<div class="col-md-6 text-right margin-top-5">
									<!--<button type="button" class="btn default btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
								</div>									
							</div>
						</div>
						<div class="portlet-body">
							<div class="portlet light no-space">
								<div class="portlet-body">										
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
										
											<tr>
												<th>Publication Name</th>
												<th>Total Number Of Ads</th>
												<th>Number Of Revisions</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($publication_details as $row){
												$order_count = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->num_rows();	
												$rev_count = $this->db->query("SELECT * FROM rev_sold_jobs left outer join orders on rev_sold_jobs.order_id = orders.id WHERE `publication_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->num_rows();												
										?>
											<tr>
												<td><?php echo $row['name'];?></td>
												<td><?php echo $order_count;?></td>
												<td><?php echo $rev_count;?></td>
											</tr>
										<?php }?>											
										</tbody>
									</table>														
								</div>
							</div>
						</div>
					</div>
<!-----End: Table 1---->
			</div>
<?php }?>
<?php } ?>
<!-- publication count END-->	

<!-- publication details -->
<?php if(isset($pub_display) && $pub_display == 'details'){ ?>
<?php if(isset($publication_details)){ ?>
	<div class="col-sm-9">
<!-----Start: Table 2---->
					<div class="portlet light">
						<div class="portlet-body form">
							<div class="portlet light no-space">
								<div class="portlet-title">
									<div class="row static-info">
										<div class="col-md-6 value margin-top-5">Publication Details</div>		
										<div class="col-md-6 text-right margin-top-5">
											<!--<button type="button" class="btn default btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>-->
											<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
										</div>												
									</div>
								</div>
								<div class="portlet-body">										
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
											<tr>
												<th>Publication Name</th>
												<th>AdwitAds Id</th>
												<th>Adrep Name</th>
												<th>Job Name</th>
												<th>Width</th>
												<th>Height</th>
												
											</tr>
										</thead>
										<tbody>
										<?php foreach($publication_details as $row){	
												$order_details = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->result_array();	
												
											  foreach($order_details as $row_order){
												  $adrep = $this->db->get_where('adreps',array('id' =>  $row_order['adrep_id']))->result_array();
										?>
											<tr>
												<td><?php echo $row['name'];?></td>
												<td><?php echo $row_order['id'] ?></td>
												<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
												<td><?php echo $row_order['job_no'] ?></td>
												<td><?php echo round($row_order['width'], 1); ?></td>
												<td><?php echo round($row_order['height'], 1); ?></td>					
											</tr>
										<?php } } ?>											
										</tbody>
									</table>														
								</div>
							</div>
						</div>
					</div>
<!-----End: Table 2---->
	</div>			
<?php }?>
<?php } ?>
<!-- publication details END-->		


<!-- Group count -->
<?php if(isset($grp_display) && $grp_display == 'count'){ ?>
<?php if(isset($group_details)){ ?>
	<div class="col-sm-9">
<!-----Start: Table 1---->
					<div class="portlet light" >
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-6 value margin-top-5">Group Count</div>		
								<div class="col-md-6 text-right margin-top-5">
									<!--<button type="button" class="btn default btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
								</div>									
							</div>
						</div>
						<div class="portlet-body">
							<div class="portlet light no-space">
								<div class="portlet-body">										
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
										
											<tr>
												<th>Group Name</th>
												<th>Total Number Of Ads</th>
												<th>Number Of Revisions</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($group_details as $row){
												$grp_order_count = $this->db->query("SELECT * FROM `orders` WHERE `group_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->num_rows();	
												$grp_rev_count = $this->db->query("SELECT * FROM rev_sold_jobs left outer join orders on rev_sold_jobs.order_id = orders.id WHERE `group_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->num_rows();												
										?>
											<tr>
												<td><?php echo $row['name'];?></td>
												<td><?php echo $grp_order_count;?></td>
												<td><?php echo $grp_rev_count;?></td>
											</tr>
										<?php }?>											
										</tbody>
									</table>														
								</div>
							</div>
						</div>
					</div>
<!-----End: Table 1---->
			</div>
<?php }?>
<?php } ?>
<!-- Group count END-->	

<!-- Group details -->
<?php if(isset($grp_display) && $grp_display == 'details'){ ?>
<?php if(isset($group_details)){ ?>
	<div class="col-sm-9">
<!-----Start: Table 2---->
					<div class="portlet light">
						<div class="portlet-body form">
							<div class="portlet light no-space">
								<div class="portlet-title">
									<div class="row static-info">
										<div class="col-md-6 value margin-top-5"> Group Details</div>		
										<div class="col-md-6 text-right margin-top-5">
											<!--<button type="button" class="btn default btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>-->
											<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
										</div>												
									</div>
								</div>
								<div class="portlet-body">										
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
											<tr>
												<th>Group Name</th>
												<th>AdwitAds Id</th>
												<th>Adrep Name</th>
												<th>Job Name</th>
												<th>Width</th>
												<th>Height</th>	
											</tr>
										</thead>
										<tbody>
										<?php foreach($group_details as $row){	
												$grp_order_details = $this->db->query("SELECT * FROM `orders` WHERE `group_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->result_array();	
												
											  foreach($grp_order_details as $row_order){
												  $adrep = $this->db->get_where('adreps',array('id' =>  $row_order['adrep_id']))->result_array();
										?>
											<tr>
												<td><?php echo $row['name'];?></td>
												<td><?php echo $row_order['id'] ?></td>
												<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
												<td><?php echo $row_order['job_no'] ?></td>
												<td><?php echo round($row_order['width'], 1); ?></td>
												<td><?php echo round($row_order['height'], 1); ?></td>		
											</tr>
										<?php } } ?>											
										</tbody>
									</table>														
								</div>
							</div>
						</div>
					</div>
<!-----End: Table 2---->
	</div>			
<?php }?>
<?php } ?>
<!-- Group details END-->

<!-- Adrep count -->
<?php if(isset($adrp_display) && $adrp_display == 'count'){ ?>
<?php if(isset($adrep_details)){ ?>
	<div class="col-sm-9">
<!-----Start: Table 1---->
					<div class="portlet light" >
						<div class="portlet-title">
							<div class="row static-info">
								<div class="col-md-6 value margin-top-5">Adrep Count</div>		
								<div class="col-md-6 text-right margin-top-5">
									<!--<button type="button" class="btn default btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
								</div>									
							</div>
						</div>
						<div class="portlet-body">
							<div class="portlet light no-space">
								<div class="portlet-body">										
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
										
											<tr>
												<th>Adrep Name</th>
												<th>Publication Name</th>
												<th>Total Number Of Ads</th>
												<th>Number Of Revisions</th>
												<th>Revision Rate</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($adrep_details as $row){
												$rev_rate = 0;
												$publi_name = $this->db->get_where('publications',array('id'=> $row['publication_id']))->result_array();
												$adrp_order_count = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->num_rows();	
												$adrp_rev_count = $this->db->query("SELECT * FROM rev_sold_jobs left outer join orders on rev_sold_jobs.order_id = orders.id WHERE `adrep_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->num_rows();	
											    if($adrp_order_count != '0'){
													$rev_rate = ($adrp_rev_count / $adrp_order_count);
												}
									   ?>
											<tr <?php if($rev_rate > '1'){ echo 'style="background:#CCFFFF;"'; } ?>>
												<td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
												<td><?php echo $publi_name[0]['name'];?></td>
												<td><?php echo $adrp_order_count;?></td>
												<td><?php echo $adrp_rev_count;?></td>
												<td><?php echo round($rev_rate,2); ?></td>
											</tr>
										<?php } ?>											
										</tbody>
									</table>														
								</div>
							</div>
						</div>
					</div>
<!-----End: Table 1---->
			</div>
<?php }?>
<?php } ?>
<!-- Adrep count END-->	

<!-- Adrep details -->
<?php if(isset($adrp_display) && $adrp_display == 'details'){ ?>
<?php if(isset($adrep_details)){ ?>
	<div class="col-sm-9">
<!-----Start: Table 2---->
					<div class="portlet light">
						<div class="portlet-body form">
							<div class="portlet light no-space">
								<div class="portlet-title">
									<div class="row static-info">
										<div class="col-md-6 value margin-top-5">Adrep Details</div>		
										<div class="col-md-6 text-right margin-top-5">
											<!--<button type="button" class="btn default btn-xs"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>-->
											<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_2', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
										</div>												
									</div>
								</div>
								<div class="portlet-body">										
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
											<tr>
												<th>Name</th>
												<th>AdwitAds Id</th>
												<th>Adrep Name</th>
												<th>Job Name</th>
												<th>Width</th>
												<th>Height</th>
												
											</tr>
										</thead>
										<tbody>
										<?php foreach($adrep_details as $row){	
												$adrp_order_details = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$row['id']."' AND `created_on` BETWEEN '$from' AND '$to' ;")->result_array();	
												
											  foreach($adrp_order_details as $row_order){
												  $adrep = $this->db->get_where('adreps',array('id' =>  $row_order['adrep_id']))->result_array();
										?>
											<tr>
												<td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
												<td><?php echo $row_order['id'] ?></td>
												<td><?php echo $adrep[0]['first_name'].' '.$adrep[0]['last_name']; ?></td>
												<td><?php echo $row_order['job_no'] ?></td>
												<td><?php echo round($row_order['width'], 1); ?></td>
												<td><?php echo round($row_order['height'], 1); ?></td>		
											</tr>
										<?php } } ?>											
										</tbody>
									</table>														
								</div>
							</div>
						</div>
					</div>
<!-----End: Table 2---->
	</div>			
<?php }?>
<?php } ?>
<!-- Adrep details END-->		

			
			</div>
				
		</div>
	</div>
</div>

<script type="text/javascript">
function getCheckedCheckboxesFor(pId) {
    var checkboxes = document.querySelectorAll('input[name="' + pId + '"]:checked'), values = [];
    Array.prototype.forEach.call(checkboxes, function(el) {
        values.push(el.value);
    });
    return values;
}
</script>

<script type="text/javascript">
function getCheckedCheckboxesFor(gId) {
    var checkboxes = document.querySelectorAll('input[name="' + gId + '"]:checked'), values = [];
    Array.prototype.forEach.call(checkboxes, function(el) {
        values.push(el.value);
    });
    return values;
}
</script>

<script type="text/javascript">
function getCheckedCheckboxesFor(aId) {
    var checkboxes = document.querySelectorAll('input[name="' + aId + '"]:checked'), values = [];
    Array.prototype.forEach.call(checkboxes, function(el) {
        values.push(el.value);
    });
    return values;
}
</script>

<!-- Start of Script for Excel download-->
<script>
        $(function() {
            
        });
        </script>
		<script>
		
			var tableToExcel = (function() {
				
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
		
</script>
<!-- End of script -->
<?php $this->load->view("management/foot"); ?>

