<?php 
	$this->load->view("new_designer/head");
?>
<script type="text/javascript">
  function myFunction() {
        var checkbox= document.querySelector('input[name="assign[]"]:checked');
		var checkbox1= document.querySelector('input[name="assign_designer[]"]:checked');
  if(!checkbox && !checkbox1) {
    alert('Please select!');
    return false;
  }

}
</script>

<script type="text/javascript"> function conf() { var con=confirm("Please complete 'My Q' before you take a new ad."); } </script> 
<style>
.tabletools-btn-group {
 display:none;
}
</style>
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<?php $help_desk_name = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$form'")->result_array(); ?>
				<a style= "color:black; text-decoration:none; font-size: 13px;" href="<?php echo base_url().index_page().'new_csr/home/cshift/';?>">New Ad</a> -
				<a style= "text-decoration:none; font-size: 13px;" ><?php echo $help_desk_name[0]['name'];?>	</a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 margin-top-15">
					<div class="navbar navbar-default" role="navigation">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">
							Toggle navigation </span>
							<span class="icon-bar">
							</span>
							<span class="icon-bar">
							</span>
							<span class="icon-bar">
							</span>
							</button>
						</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
							<ul class="nav navbar-nav">
								<?php if($designers[0]['designer_role'] == '3' || $designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '4') { 
									if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$form.'/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green"><?php echo $upload_count; ?></span></a>
								</li>  
								<?php } if($designers[0]['designer_role'] == '3' || $designers[0]['designer_role'] == '4') { 
									if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$form.'/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue"> <?php echo $design_count; ?></span></a>
								</li>
								<?php } elseif($designers[0]['designer_role'] == '2' || $designers[0]['designer_role'] == '1') {
								  if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$form.'/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue"> <?php echo count($orders); ?></span></a>
								</li>
								<?php } if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { 
								  if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$form.'/design_check';?>">
									&nbsp; Design Check <span class="badge bg-blue"> <?php echo $DC_order_count; ?></span></a> 
								</li>
								<?php } if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') {
								  if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$form.'/all_pending';?>">
									&nbsp; Pending <span class="badge bg-green"> <?php echo count($orders_pending); ?></span></a> 
								</li>
								<?php } if($designers[0]['designer_role'] == '2' || $designers[0]['designer_role'] == '1') { 
								  if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$form.'/all';?>">
									&nbsp; All <span class="badge bg-green"> <?php echo count($all_orders); ?></span></a> 
								</li>
								<?php } ?>
							</ul>
							<ul class="nav navbar-nav navbar-right margin-right-10">
								<li class="dropdown">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									&nbsp; Select Group &nbsp;<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
									<?php
									$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
										foreach($types as $type)
										{ 
									?>
										<li>
											<a href="<?php echo base_url().index_page().'new_designer/home/cshift/'.$type['id'];?>">
											<?php echo $type['name']; ?> </a>
										</li>
									<?php } ?>									
									</ul>
								</li>
							</ul>
						</div>
					<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';if(isset($form)): ?>
	<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('success_message').'</h5>'; ?>

<!--Design Pending-->	
<?php if($display_type =='design_pending') { ?> 
<div class="row">
	<div class="col-md-12">
		<form Method="POST" onsubmit="return myFunction(this)">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<?php if($designers[0]['designer_role'] == '2') { ?>
						<span class="caption-subject font-green-sharp bold uppercase">Assign</span>
						<?php }else{ ?>
						<span class="caption-subject font-green-sharp bold uppercase">Design Pending<?php echo "(".count($orders).")";?></span>
						<?php } ?>
					</div>
					<div class="tools">
					<?php  if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { 
						$design_assign = $this->db->get_where('design_assign')->result_array();		
						foreach($design_assign as $result){ ?>
						<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit" value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></button>
					<?php } } ?>
					<a class="reload" onclick="myFunction()"></a>
					</div>
					
				</div>
				<div class="portlet-body">
				  <table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead> 
					<tr>
						<th>Date</th>
						<th>Type</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
						<th>Category</th>
						<?php if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2'){?>
						<th>Assign</th>
						<th>Designer Assign</th><?php } ?>
						<?php if($designers[0]['designer_role'] == '3'){?>
						<th>Design</th><?php } ?>
					</tr>
					</thead>
					 <tbody name="testTable" id="testTable">
<?php 

foreach($orders as $row1)
{
	$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
	//$cat_result = $this->db->query("SELECT * FROM `designers`,`cat_result` WHERE `order_no`='".$row1['id']."' AND designers.id = cat_result.designer ")->result_array();
	$cat_result = $this->db->get_where('cat_result',array('order_no' => $row1['id']))->result_array();
	//$designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat_result[0]['designer']."'")->result_array();
	$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row1['publication_id']."'")->result_array();
	$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
	$designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
	if($cat_result && $cat_result[0]['cancel']=='0' && $cat_result[0]['pdf_path']=='none' && ($cat_result[0]['tag_designer'] == $dId || $cat_result[0]['tag_designer'] == '0') && ($designers[0]['designer_role'] == '3' ||  $designers[0]['designer_role'] == '4')) { 
		//New Ad slug 
		if($cat_result[0]['slug']=='none' || $cat_result[0]['slug']==''){
			$version = 'V1';
			$cat_result[0]['job_name'] = str_replace(' ', '_', $cat_result[0]['job_name']);
			if($cat_result[0]['slug_type'] == '1')
				$slug = $cat_result[0]['order_no']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['job_name']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '2')
				$slug = $cat_result[0]['job_name'];
			elseif($cat_result[0]['slug_type'] == '3')
				$slug = $cat_result[0]['job_name']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['order_no']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '4')
				$slug = $cat_result[0]['order_no']."-".$cat_result[0]['news_initial']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."-".$version;
			elseif($cat_result[0]['slug_type'] == '5')
				$slug = $cat_result[0]['order_no']."_".$cat_result[0]['job_name']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '6')
				$slug = $cat_result[0]['job_name']."_".$cat_result[0]['order_no']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '7')
				$slug = $cat_result[0]['job_name']."_".$cat_result[0]['order_no']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '8')
				$slug = $cat_result[0]['order_no']."_".$cat_result[0]['job_name']."_".$cat_result[0]['advertiser']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '9')
				$slug = $cat_result[0]['job_name']."_".$cat_result[0]['advertiser']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['order_no']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			elseif($cat_result[0]['slug_type'] == '10')
				$slug = $cat_result[0]['advertiser']."_".$cat_result[0]['job_name']."_".$cat_result[0]['news_initial']."_".$cat_result[0]['category']."_".$this->session->userdata('designer')."_".$version;
			else{
				echo "Slug undefined for this slug type - ".$cat_result[0]['slug_type'];
			} 
			$slug = str_replace(' ', '_', $slug);
		}
?>				
		
					<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
	  
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
<!-- Adwit Id -->		<td><?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $row1['id']; ?></td>							
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- adrep -->			<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name']; ?></td>
<!-- Publication -->		<td><?php echo $publication[0]['name']; ?></td>

<!-- design team -->	<?php if($form=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

<!-- Category -->		<td <?php if($row1['question']=='1') { echo 'class="danger"'; } if($row1['question']=='2') { echo 'class="success"'; } ?>><?php if($cat_result && $row1['rush']=='1'){ //rushad
							echo $cat_result[0]['category'].'<span style="display:none;">rush</span>';
						}elseif($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?></td>

<!-- Designer Assign <?php if($designers[0]['designer_role'] == '1') { ?>
						<td>
							<?php if($cat_result[0]['tag_designer']=='0'){ ?>
							<input type="checkbox" name="assign_designer[]" id="assign_designer[]" value="<?php echo $cat_result[0]['id']; ?>">
							<?php }else{ 
							$cat_designer_name = $this->db->get_where('designers',array('id' => $cat_result[0]['tag_designer']))->result_array();
							echo $cat_designer_name[0]['username']; } ?>
						</td><?php } ?>-->
				
<!-- Design -->			<?php if($designers[0]['designer_role'] == '3' || $designers[0]['designer_role'] == '4'){ ?>
						<td>
							
						<?php if((isset($slug)) && $upload_count=='0'){ ?>	
								<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onclick="start_design<?php echo $row1['id']; ?>()" >Start Design</button>
						<?php }else{ ?>
								<button type="button" onClick="conf()" class="btn green-jungle btn-sm">Start Design</button>
						<?php } ?>
							
						</td>
						<?php } ?>
					</tr>
<?php } elseif($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2') { ?>
					<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
	  
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
<!-- Adwit Id -->		<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>							
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- adrep -->			<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name']; ?></td>
<!-- Publication -->		<td><?php echo $publication[0]['name']; ?></td>

<!-- design team -->	<?php if($form=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

<!-- Category -->		<td <?php if($row1['question']=='1') { echo 'class="danger"'; } if($row1['question']=='2') { echo 'class="success"'; } ?>><?php if($cat_result && $row1['rush']=='1'){ //rushad
							echo $cat_result[0]['category'].'<span style="display:none;">rush</span>';
						}elseif($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?></td>
					
				
						
			<?php if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2'){?>
<!-- Assign -->			<td> <?php if($cat_result[0]['assign']!='0') {$design_assign_name = 	$this->db->get_where('design_assign',array('id' => $cat_result[0]['assign']))->result_array(); echo $design_assign_name[0]['name'];} else { ?>
							<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result[0]['id']; ?>">
							<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" hidden />
							<?php } ?>
						</td>
<!-- Designer Assign --><td>
							<?php if($cat_result[0]['tag_designer']=='0'){ ?>
							<input type="checkbox" name="assign_designer[]" id="assign_designer[]" value="<?php echo $cat_result[0]['id']; ?>">
							<?php }else{ 
							$cat_designer_name = $this->db->get_where('designers',array('id' => $cat_result[0]['tag_designer']))->result_array();
							echo $cat_designer_name[0]['username']; } ?>
						</td><?php } ?>
						
<!-- Design -->			<?php if($designers[0]['designer_role'] == '3') { ?>
							<td>
							<?php if(isset($slug)){ ?>	
								<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onclick="start_design<?php echo $row1['id']; ?>()" >Start Design</button>
							<?php }else{ ?>
								<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn green-jungle btn-sm">Start Design</button></a>
							<?php } ?>
							<?php if($cat_result && $designer){ echo $designer[0]['username'];} ?>
							<?php if($cat_result[0]['tag_designer'] == $dId) { ?>
								<i class="fa fa-flag"></i>
							<?php } else { echo ' '; } ?>
							</td>
						<?php }?>
					</tr>
	<?php } ?>
	<script>
		function start_design<?php echo $row1['id']; ?>(){
			var slug = "<?php echo $slug; ?>";
			var cat_result_id = "<?php echo $cat_result[0]['id']; ?>";
			var confirm_slug = 'none';
			var X = confirm('Confirm Slug : '+slug);	
			if(X == true)	 {
				//ajax
				$.ajax({
					url: "<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>",
					data:'slug='+slug+'&cat_result_id='+cat_result_id+'&confirm_slug='+confirm_slug,
					type: "POST",
					success: function(msg) { window.location.href = "<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'];?>"; }
				});	
				return true;  
			}else  {    
				return false;  
			}
			//alert("confirm slug<?php echo $row1['id'].'-'.$cat_result[0]['id'].'-'.$slug; ?>");
		}
	</script>
	<?php } ?>
			<?php if((isset($tag_designer_teamlead) && count($tag_designer_teamlead) > '0') && ($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2')) {
				foreach($tag_designer_teamlead as $tag_row){ 
						$designer_name = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$tag_row['designer_id']."' ")->result_array();
						?>
						
						<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit_designer"  value="<?php echo $tag_row['designer_id']; ?>"><?php if(isset($designer_name)) { echo $designer_name[0]['username'];  }?></button>
						
						<?php } } ?>
					</tbody>
				</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?php } ?>
<!--Design Pending--> 

<!--Upload Pending-->		
<?php if($display_type=='upload_pending') { ?> 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-green-sharp bold uppercase">upload Pending</span>
				</div>
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th>Date</th>
							<th>Type</th>
							<th>AdwitAds ID</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
							<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
							<th>Category</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody name="testTable" id="testTable">
<?php 

foreach($orders_upload as $row)
{
$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `designer` ='".$this->session->userdata('dId')."'; ")->result_array();
if($cat_result && ($cat_result[0]['pro_status']=='1'|| $cat_result[0]['pro_status']=='6' || $cat_result[0]['pro_status']=='7') && ($cat_result[0]['tag_designer'] == $dId || $cat_result[0]['tag_designer'] == '0'))
{
$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat_result[0]['pro_status']."'")->result_array();
?>
  <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
<!-- Adwit Id -->		<td><?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $row['id']; ?></td>							
<!-- job_name -->		<td><?php echo $row['job_no']; ?></td>
<!-- adrep -->			<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name']; ?></td>
<!-- Publication -->	<td><?php echo $publication[0]['name']; ?></td>

<!-- design team -->	<?php if($row['id']=='5' && $publication[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk'] == '5' && $publication[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

<!-- Category -->		<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>>
				<!--rushad-->
				<?php  if($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?>
			</td>
					
<!-- Design -->			<td>
			<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
				<button class="btn blue-sunglo btn-xs"><?php if($status)echo $status[0]['name']; else echo''; ?></button>
			</a>
			</td>
	 </tr>
<?php  } 
}  ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--Upload Pending-->	
	
<!--design check-->	
<?php if($display_type=='design_check') { ?>  
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
						<?php echo $type[0]['name']; ?>
					</p>
					<?php echo '<span style="color:#900;">'.$this->session->flashdata('ext_message').'</span>'; ?>
				</div>
				<div class="tools">				
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			  <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
				<tr>
					<th>Date</th>
					<th>T</th>
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Adrep</th>
					<th>Publication</th>
				<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
					 <th>C</th>
					 <th>Designer</th>
					<th>Status</th>
			   </tr>  
				</thead>
				<tbody>
			<?php 
			foreach($orders_inproduction as $row){
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND (`pro_status` ='2' OR `pro_status` = '8'); ")->result_array();
				foreach($cat_result as $row1)
				{
					$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
					$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
					$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
					$status = $this->db->get_where('production_status',array('id' => $row1['pro_status']))->result_array();				
					$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
					$designer = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$row1['designer']."' ;")->result_array();								
								
			?>
				<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
					<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
					<td><?php echo $row['job_no']; ?></td>
					<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];?></td>
					<td><?php echo $publication[0]['name'];?></td>
					<?php if($form=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $row1['category']; ?></td>
					<!--Status-->
					<td><?php echo $designer[0]['username'];?></td>
					<td>
					<a  class="btn btn-xs btn-success" <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
					<?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?>
					</a>
					<!--temp file check in directory-->
						<?php
						$inddtemp1 = $row1['source_path'].'/'.'temp1'.".indd";
						$pdftemp1 = $row1['source_path'].'/'.'temp1'.".pdf";
						
						$inddtemp2 = $row1['source_path'].'/'.'temp2'.".indd";
						$pdftemp2 = $row1['source_path'].'/'.'temp2'.".pdf";
						
						$inddtemp3 = $row1['source_path'].'/'.'temp3'.".indd";
						$pdftemp3 = $row1['source_path'].'/'.'temp3'.".pdf";
						
						if((file_exists($inddtemp1) && file_exists($pdftemp1)) || (file_exists($inddtemp2) && file_exists($pdftemp2)) ||
						(file_exists($inddtemp3) && file_exists($pdftemp3))) { ?>
							<i class="fa fa-flag"></i>
						<?php } else{ echo ' ';}
						?>
					<!--temp file check in directory-->
					</td>
				</tr>
			<?php } } ?>	
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>	
<?php } ?>
<!--design check-->	
	
<!--All Pending-->	
<?php if($display_type=='all_pending') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
						<?php echo $type[0]['name']; ?>
					</p>
				</div>
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			 <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Date</th>
						<th>T</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
						 <th>C</th>
						 <th>Designer</th>
						 <th>Status</th>
				   </tr>  
				</thead>
				<tbody>
			<?php foreach($orders_pending as $row){
			
				$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
				$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
				$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
				//$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();
				if($cat_result && $cat_result[0]['pro_status']!='0'){
					$status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
				}else{
					$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
				}
				$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();					
				$design_assign = $this->db->get_where('design_assign')->result_array();	
				if(isset($cat_result[0]['id']) && $cat_result[0]['designer'] != '0'){				
					$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$cat_result[0]['designer']."' ;")->row_array();
				}								
			?>
			
				<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
					<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
					<td><?php echo $row['job_no']; ?></td>
					<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];?></td>
					
					<td><?php echo $publication[0]['name'];?></td>
					
					<?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $cat_result[0]['category']; ?></td>
					<td><?php if($cat_result[0]['designer'] != '0' && isset($designer_pending)){ echo $designer_pending['username']; } else { echo ' ' ; }?></td>
					<!--Status-->
					<td>
					<a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
					<?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?>
					</a>
					</td>
				</tr>
		<?php } ?>	
				
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!--All Pending-->	      

<!-- all-->
<?php if($display_type=='all') { ?> 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<p><?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
						<?php echo $type[0]['name']; ?>
					</p>
				</div>
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th>Date</th>
							<th>T</th>
							<th>AdwitAds ID</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
						<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
							 <th>C</th>
							 <th>Status</th>
					   </tr>  
					</thead>
					<tbody>
					
				<?php foreach($all_orders as $row){
				
					$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
					$publication = $this->db->query("SELECT * FROM `publications` WHERE id='".$row['publication_id']."'")->result_array();
					$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
					$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
					//$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();
					if($cat_result && $cat_result[0]['pro_status']!='0'){
						$status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
					}else{
						$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
					}
					$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();					
					$design_assign = $this->db->get_where('design_assign')->result_array();					
				 ?>
				
					<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
						<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
						<td title="<?php echo $order_type[0]['name']; ?>"><span class="badge bg-blue"><?php if($order_type[0]['id']=='1') {echo "W"; } if($order_type[0]['id']=='2') { echo "P"; } if($order_type[0]['id']=='3') { echo "P&W";}?></span></td>
						<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
						<td><?php echo $row['job_no']; ?></td>
						<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];?></td>
						<td><?php echo $publication[0]['name'];?></td>
						<?php if($row['help_desk']=='5' && $dteam[0]['design_team_id']=='4'){echo "<td>D6</td>";}elseif($row['help_desk']=='5' && $dteam[0]['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
						<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php if($cat_result) { echo $cat_result[0]['category'] ;} else { echo " " ;} ?></td>
						<!--Status-->
						<td>
						<a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
						<?php if(isset($status[0]['name'])) { echo $status[0]['name']; } else{ echo"None"; } ?>
						</a>
						</td>
					</tr>
			<?php } ?>	
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>		
<!-- all-->
		
<?php  endif; ?>
		</div>
	</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<?php 
	$this->load->view("new_designer/foot");
?>