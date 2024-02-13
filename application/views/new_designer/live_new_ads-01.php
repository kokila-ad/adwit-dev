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
								<?php if($designers['designer_role'] == '3' || $designers['designer_role'] == '1' || $designers['designer_role'] == '4') { 
									if($display_type == 'upload_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/upload_pending';?>">
									&nbsp; My Q <span class="badge bg-green"><?php echo $MyQ_count; ?></span></a>
								</li>  
								<?php } if($designers['designer_role'] == '1' || $designers['designer_role'] == '2' || $designers['designer_role'] == '3' || $designers['designer_role'] == '4') {
								if($display_type == 'design_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_pending';?>">
									&nbsp; Total Q <span class="badge bg-blue"><?php echo $TotalQ_count; ?></span></a>
								</li>
								<?php  } if($designers['designer_role'] == '1' || $designers['designer_role'] == '2') { 
								  if($display_type == 'design_check'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/design_check';?>">
									&nbsp; Design Check <span class="badge bg-blue"> <?php echo $DcQ_count; ?></span></a> 
								</li>
								<?php if($display_type == 'all_pending'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all_pending';?>">
									&nbsp; Pending <span class="badge bg-green"><?php echo $DpQ_count; ?></span></a> 
								</li>
								<?php if($display_type == 'all'){ echo'<li class="active">'; }else{ echo'<li>'; } ?>
									<a href="<?php echo base_url().index_page().'new_designer/home/live_new_ads/all';?>">
									&nbsp; All <span class="badge bg-green"><?php echo $AllQ_count; ?></span></a> 
								</li>
								<?php } ?>
							</ul>
						</div>
					<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>

<!--Design Pending-->	
<?php if($display_type =='design_pending') { ?> 
<div class="row">
	<div class="col-md-12">
		<form Method="POST" onsubmit="return myFunction(this)">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<?php if($designers['designer_role'] == '2') { ?>
						<span class="caption-subject font-green-sharp bold uppercase">Assign</span>
						<?php }else{ ?>
						<span class="caption-subject font-green-sharp bold uppercase">Design Pending<?php echo "(".$TotalQ_count.")";?></span>
						<?php } ?>
					</div>
					<div class="tools">
					<?php  if($designers['designer_role'] == '1' || $designers['designer_role'] == '2') { 
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
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<th>Category</th>
						<?php if($designers['designer_role'] == '1' || $designers['designer_role'] == '2'){?>
							<th>Assign</th>
							<th>Designer Assign</th>
						<?php } ?>
						<?php if($designers['designer_role'] == '3'){ ?>
							<th>Design</th>
						<?php } ?>
					</tr>
					</thead>
					 <tbody name="testTable" id="testTable">
					 
<?php foreach($dp_orders as $data){
	$row1 = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`help_desk` FROM `orders` WHERE id='".$data['order_id']."'")->row_array();
	/*$cat_result = $this->db->query("SELECT cat_result.id, cat_result.designer, cat_result.tag_designer, cat_result.job_name, cat_result.order_no, cat_result.news_initial, cat_result.category, cat_result.slug, cat_result.slug_type, cat_result.advertiser, cat_result.assign, cat_result.pdf_path FROM `cat_result` 
					WHERE cat_result.order_no = '".$data['order_id']."' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0') ")->row_array();*/
	$cat_result = $this->db->query("SELECT cat_result.id, cat_result.designer, cat_result.tag_designer, cat_result.job_name, cat_result.order_no, cat_result.news_initial, cat_result.category, cat_result.slug, cat_result.slug_type, cat_result.advertiser, cat_result.assign, cat_result.pdf_path FROM `cat_result` 
					WHERE cat_result.order_no = '".$data['order_id']."' ")->row_array();				
	$publication = $this->db->query("SELECT `name`, `design_team_id` FROM `publications` WHERE id='".$row1['publication_id']."'")->result_array();
	$adreps = $this->db->query("SELECT `first_name`, `last_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
	
	if(($designers['designer_role'] == '3' ||  $designers['designer_role'] == '4')) { 
		//New Ad slug 
		if($cat_result['slug']=='none' || $cat_result['slug']==''){
			$version = 'V1';
			$job_name = $row1['job_no'];
			$order_no = $row1['id'];
			$slug_type = $cat_result['slug_type'];
			$news_initial = $cat_result['news_initial'];
			$category = $cat_result['category'];
			$advertiser = $cat_result['advertiser'];
			
			$job_name = str_replace(' ', '_', $job_name);
			if($slug_type == '1')
				$slug = $order_no."_".$news_initial."_".$job_name."_".$category."_".$dId."_".$version;
			elseif($slug_type == '2')
				$slug = $job_name;
			elseif($slug_type == '3')
				$slug = $job_name."_".$news_initial."_".$order_no."_".$category."_".$dId."_".$version;
			elseif($slug_type == '4')
				$slug = $order_no."-".$news_initial."_".$category."_".$dId."-".$version;
			elseif($slug_type == '5')
				$slug = $order_no."_".$job_name."_".$news_initial."_".$category."_".$dId."_".$version;
			elseif($slug_type == '6')
				$slug = $job_name."_".$order_no."_".$category."_".$dId."_".$version;
			elseif($slug_type == '7')
				$slug = $job_name."_".$order_no."_".$news_initial."_".$category."_".$dId."_".$version;
			elseif($slug_type == '8')
				$slug = $order_no."_".$job_name."_".$advertiser."_".$news_initial."_".$category."_".$dId."_".$version;
			elseif($slug_type == '9')
				$slug = $job_name."_".$advertiser."_".$news_initial."_".$order_no."_".$category."_".$dId."_".$version;
			elseif($slug_type == '10')
				$slug = $advertiser."_".$job_name."_".$news_initial."_".$category."_".$dId."_".$version;
			else{
				echo "Slug undefined for this slug type - ".$slug_type;
			} 
			$slug = str_replace(' ', '_', $slug);
		}
?>				
		
			<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
	  
	<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

	<!-- Adwit Id -->		<td><?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $row1['id']; ?></td>							
	<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

	<!-- adrep -->			<td><?php if(isset($adreps[0]['first_name'])){echo $adreps[0]['first_name'].' '.$adreps[0]['last_name'];} ?></td>

	<!-- Publication -->	<td><?php echo $publication[0]['name']; ?></td>
	<!-- Category -->		<td <?php if($row1['question']=='1'){ echo'class="danger"'; } if($row1['question']=='2'){ echo'class="success"'; } ?>><?php if($row1['rush']=='1'){ //rushad
										echo $cat_result['category'].'<span style="display:none;">rush</span>';
									}else{ 
										echo $cat_result['category'];
									} ?>
							</td>

	<!-- Design -->			<?php if($designers['designer_role'] == '3' || $designers['designer_role'] == '4'){ ?>
							<td>
								<?php if((isset($slug)) && ($MyQ_count == '0')){ ?>	
										<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onclick="start_design<?php echo $row1['id']; ?>()" >Start Design</button>
								<?php }else{ ?>
										<button type="button" onClick="conf()" class="btn green-jungle btn-sm">Start Design</button>
								<?php } ?>
							</td>
							<?php } ?>
			</tr>
					
<?php } elseif($designers['designer_role'] == '1' || $designers['designer_role'] == '2') { ?>

			<tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
	  
	<!-- date -->		<td><?php $date = strtotime($row1['created_on']); echo date('d-M', $date); ?></td>

	<!-- Adwit Id -->	<td title="view attachments"><a <?php if($row1['rush']==1){ echo "class='font-grey-cararra'";} ?> href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$row1['help_desk'].'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>
								
	<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

	<!-- adrep -->			<td><?php echo $adreps[0]['first_name'].' '.$adreps[0]['last_name']; ?></td>

	<!-- Publication -->	<td><?php echo $publication[0]['name']; ?></td>

	<!-- Category -->		<td <?php if($row1['question']=='1'){ echo'class="danger"'; } if($row1['question']=='2'){ echo'class="success"'; } ?>><?php if($row1['rush']=='1'){ //rushad
										echo $cat_result['category'].'<span style="display:none;">rush</span>';
									}else{ 
										echo $cat_result['category'];
									} ?>
							</td>
	
	<!-- Assign -->			<td> <?php if($cat_result['assign']!='0') {$design_assign_name = 	$this->db->get_where('design_assign',array('id' => $cat_result['assign']))->result_array(); echo $design_assign_name[0]['name'];} else { ?>
								<input type="checkbox" name="assign[]" id="assign[]" value="<?php echo $cat_result['id']; ?>">
								<input name="cat_id" value="<?php echo $cat_result['id']; ?>" hidden />
								<?php } ?>
							</td>
							
	<!-- Designer Assign --><td>
								<?php 
								$cat_designer_name = $this->db->get_where('designers',array('id' => $cat_result['tag_designer']))->result_array();
								if(isset($cat_designer_name[0]['username'])) echo $cat_designer_name[0]['username'];  ?>
								<input type="checkbox" name="assign_designer[]" id="assign_designer[]" value="<?php echo $cat_result['id']; ?>">
							</td>
	
			</tr>
	<?php } ?>
	<script>
		function start_design<?php echo $row1['id']; ?>(){
			var slug = "<?php echo $slug; ?>";
			var cat_result_id = "<?php echo $cat_result['id']; ?>";
			var confirm_slug = 'none';
			var X = confirm('Confirm Slug : '+slug);	
			if(X == true)	 {
				//ajax
				$.ajax({
					url: "<?php echo base_url().index_page().'new_designer/home/orderview/'.$row1['help_desk'].'/'.$row1['id'];?>",
					data:'slug='+slug+'&cat_result_id='+cat_result_id+'&confirm_slug='+confirm_slug,
					type: "POST",
					success: function(msg) { window.location.href = "<?php echo base_url().index_page().'new_designer/home/orderview/'.$row1['help_desk'].'/'.$row1['id'];?>"; }
				});	
				return true;  
			}else  {    
				return false;  
			}
			//alert("confirm slug<?php echo $row1['id'].'-'.$cat_result['id'].'-'.$slug; ?>");
		}
	</script>
<?php } ?>

			<?php if((isset($tag_designer_teamlead) && count($tag_designer_teamlead) > '0') && ($designers['designer_role'] == '1' || $designers['designer_role'] == '2')) {
				foreach($tag_designer_teamlead as $tag_row){ 
						$designer_name = $this->db->query("SELECT `username` FROM `designers` WHERE `id` = '".$tag_row['designer_id']."' ")->row_array();
						?>
						
						<button class="btn green-haze btn-circle btn-sm" type="submit" name="submit_designer"  value="<?php echo $tag_row['designer_id']; ?>"><?php if(isset($designer_name)) { echo $designer_name['username'];  }?></button>
						
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
							<th>AdwitAds ID</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
							<th>Category</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody name="testTable" id="testTable">
					
				<?php foreach($myq_orders as $data){
					$order_id = $data['order_id'];
					$order = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`help_desk` FROM `orders` WHERE id='".$order_id."'")->row_array();
					$cat_result = $this->db->query("SELECT `pro_status`,`category` FROM `cat_result` WHERE `order_no`='".$order_id."' ;")->row_array();
					$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$order['publication_id']."'")->row_array();
					$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$order['adrep_id']."' ;")->row_array();
					$status = $this->db->query("SELECT `name` FROM `production_status` WHERE id='".$cat_result['pro_status']."'")->row_array();
				?>
					<tr <?php if($order['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
	<!-- date -->			<td><?php $date = strtotime($order['created_on']); echo date('d-M', $date); ?></td>
	<!-- Adwit Id -->		<td><?php if($order['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $order['id']; ?></td>							
	<!-- job_name -->		<td><?php echo $order['job_no']; ?></td>
	<!-- adrep -->			<td><?php echo $adreps['first_name'].' '.$adreps['last_name']; ?></td>
	<!-- Publication -->	<td><?php echo $publication['name']; ?></td>
	<!-- design team -->	<?php if($order['id']=='5' && $publication['design_team_id']=='4'){echo "<td>D6</td>";}elseif($publication['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
	<!-- Category -->		<td <?php if($order['question']=='1') { echo 'class="danger"'; } if($order['question']=='2') { echo 'class="success"'; } ?>>
								<!--rushad--><?php  if($cat_result['category']){echo $cat_result['category'];}else{echo 'Pending';} ?>
							</td>
	<!-- Design -->			<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$order['help_desk'].'/'.$order['id'];?>'" style="cursor:pointer; text-decoration: none;">
									<button class="btn blue-sunglo btn-xs"><?php if($status)echo $status['name']; else echo''; ?></button>
								</a></td>
					</tr>
					<?php  }?>
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
					<th>AdwitAds ID</th>
					<th>Unique Job Name</th>
					<th>Adrep</th>
					<th>Publication</th>
					<th>C</th>
					<th>Status</th>
			   </tr>  
				</thead>
				<tbody>
			<?php foreach($dc_orders as $data){
				$row = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`help_desk` FROM `orders` WHERE id='".$data['order_id']."'")->row_array();
				$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$row['publication_id']."'")->row_array();
				$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
				$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();				
			?>
				<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
					<td><?php echo $row['job_no']; ?></td>
					<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
					<td><?php echo $publication['name'];?></td>
					<?php if($publication['design_team_id']=='4'){echo "<td>D6</td>";}elseif($publication['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $data['category']; ?></td>
					<!--Status-->
					<td>
					<a  class="btn btn-xs btn-success" <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>">
					<?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?>
					</a>
					<!--temp file check in directory-->
						<?php
						$inddtemp1 = $data['source_path'].'/'.'temp1'.".indd";
						$pdftemp1 = $data['source_path'].'/'.'temp1'.".pdf";
						
						$inddtemp2 = $data['source_path'].'/'.'temp2'.".indd";
						$pdftemp2 = $data['source_path'].'/'.'temp2'.".pdf";
						
						$inddtemp3 = $data['source_path'].'/'.'temp3'.".indd";
						$pdftemp3 = $data['source_path'].'/'.'temp3'.".pdf";
						
						if((file_exists($inddtemp1) && file_exists($pdftemp1)) || (file_exists($inddtemp2) && file_exists($pdftemp2)) ||
						(file_exists($inddtemp3) && file_exists($pdftemp3))) { ?>
							<i class="fa fa-flag"></i>
						<?php } else{ echo ' ';}
						?>
					<!--temp file check in directory-->
					</td>
				</tr>
			<?php }?>	
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
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
			 <table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Unique Job Name</th>
						<th>Adrep</th>
						<th>Publication</th>
						<th>C</th>
						<th>Status</th>
				   </tr>  
				</thead>
				<tbody>
			<?php foreach($all_pending as $data)
			{
				$row = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`status`,`help_desk` FROM `orders` WHERE id='".$data['order_id']."'")->row_array();
				$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$row['publication_id']."'")->row_array();
				$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
				if($data['pro_status']!='0'){
					$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();					
				}else{
					$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->row_array();					
				}
				$design_assign = $this->db->get_where('design_assign')->result_array();	
			?>
				<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
					<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
					<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php echo $row['id']; ?></a></td>
					<td><?php echo $row['job_no']; ?></td>
					<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
					<td><?php echo $publication['name'];?></td>
					<?php if($publication['design_team_id']=='4'){echo "<td>D6</td>";}elseif($publication['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
					<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; } ?>><?php echo $data['category']; ?></td>
					<td><a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>"><?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?></a></td>
				</tr>
			<?php  }?>	
				
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
				<div class="tools">
				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_6">
					<thead>
						<tr>
							<th>Date</th>
							<th>AdwitAds ID</th>
							<th>Unique Job Name</th>
							<th>Adrep</th>
							<th>Publication</th>
							<th>C</th>
							 <th>Status</th>
					   </tr>  
					</thead>
					<tbody>
					
				<?php foreach($all_orders as $data){
					$row = $this->db->query("SELECT `publication_id`,`adrep_id`,`rush`,`created_on`,`job_no`,`id`,`question`,`status`,`help_desk` FROM `orders` WHERE id='".$data['order_id']."'")->row_array();
					$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$row['publication_id']."'")->row_array();
					$adreps = $this->db->query("SELECT `first_name`,`last_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
					if($data['pro_status']!='0'){
						$status = $this->db->get_where('production_status',array('id' => $data['pro_status']))->row_array();					
					}else{
						$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->row_array();					
					}
					$design_assign = $this->db->get_where('design_assign')->result_array();					
				 ?>
					<tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
						<td><?php $date = strtotime($row['created_on']); echo date('d-M', $date); ?></td>
						<td><a <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>" ><?php echo $row['id']; ?></a></td>
						<td><?php echo $row['job_no']; ?></td>
						<td><?php echo $adreps['first_name'].' '.$adreps['last_name'];?></td>
						<td><?php echo $publication['name'];?></td>
						<?php if($publication['design_team_id']=='4'){echo "<td>D6</td>";}elseif($publication['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>
						<td <?php if($row['question']=='1') { echo 'class="danger"'; } if($row['question']=='2') { echo 'class="success"'; }?>><?php if($data['category']) { echo $data['category']; } else { echo " " ;} ?></td>
						<td><a class="btn btn-xs btn-success" href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['id']; ?>" ><?php if(isset($status['name'])) { echo $status['name']; } else{ echo"None"; } ?></a></td>
					</tr>
				<?php  }?>	
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>		
<!-- all-->


		</div>
	</div>
</div>
<!-- END PAGE CONTENT -->
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<?php 
	$this->load->view("new_designer/foot");
?>