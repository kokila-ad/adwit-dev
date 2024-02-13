<?php $this->load->view('new_admin/header.php'); ?>
<style>
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
.btn-xxs{
	padding: 5px;
	font-size: 12px;
	line-height: .8;
}
.no-border{
	border: 0px !important;
}
.btn-xs {
    margin-bottom: 5px;
}
</style>


<script>
   function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php 
				$current_time = date("H:i:s"); 
		?>
    }
</script>
			
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
			<?php if(null != $this->session->flashdata('message')){ ?>						
				<div class="alert alert-success margin-0 padding-5 small"><?php echo $this->session->flashdata('message'); ?></div>
			<?php } ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption ">
								<form method="post">
									<input type="submit" name="timestamp" class="btn btn-xs green" value="<?php echo $qystday; ?>" /> 
									<input type="submit" name="timestamp" class="btn btn-xs green" value="<?php echo $pystday; ?>" /> 
									<input type="submit" name="timestamp" class="btn btn-xs green" value="<?php echo $ystday; ?>" /> 
									<input  id="time" type="submit" name="timestamp" class="btn btn-xs green" value="<?php echo $today; ?>" /> 
								</form>
							</div>
							<div class="tools">
								<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
							</div>
						</div>
						<div class="portlet-body no-space">						
							<table class="table table-bordered table-hover" >
								<thead>											
									<tr>
										<th>Adwitads ID</th>				
										<th>HelpDesk</th>
										<th>Version</th>	
										<th>Notes</th>
										<th>Attachments</th>
										<th>Proof</th>
										<th>Error_Type</th>
									</tr>
								</thead> 
								<tbody>	
<?php
$count = '0';
	if($display_type=='all')
	{
		if(isset($timestamp)){
			$this->db->order_by("id", "asc");
			//$jobs = $this->db->get_where('rev_order_reason',array('rev_id !=' => '', 'timestamp'=> $timestamp, 'reason_id'=> '3'))->result_array();
			$jobs = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `rev_id`!='' AND `reason_id`='3' AND `timestamp` LIKE '$timestamp%'")->result_array(); 
		}else{
			$this->db->order_by("id", "asc");
			$jobs = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `rev_id`!='' AND `reason_id`='3' AND `timestamp` = '$today'")->result_array(); 
			//$jobs = $this->db->get_where('rev_order_reason',array('rev_id' => '326958', 'timestamp'=> '2017-08-08', 'reason_id'=> '3'))->result_array();
		}
	} 
	foreach($jobs as $row){ $count++; 
		$rev_sold_id = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id` = '".$row['rev_id']."'")->row_array();
		
		if($rev_sold_id){
				$version = $rev_sold_id['version'];
				if($version == 'V1a'){ $version = 'V1'; }
				elseif($version == 'V1b'){ $version = 'V1a'; }
				elseif($version == 'V1c'){ $version = 'V1b'; }
				elseif($version == 'V1d'){ $version = 'V1c'; }
				elseif($version == 'V1e'){ $version = 'V1d'; }
				elseif($version == 'V1f'){ $version = 'V1e'; }
				elseif($version == 'V1g'){ $version = 'V1f'; }
				elseif($version == 'V1h'){ $version = 'V1g'; }
				elseif($version == 'V1i'){ $version = 'V1h'; }
				elseif($version == 'V1j'){ $version = 'V1i'; }
				elseif($version == 'V1k'){ $version = 'V1j'; }
				elseif($version == 'V1l'){ $version = 'V1k'; }
				elseif($version == 'V1m'){ $version = 'V1l'; }
				elseif($version == 'V1n'){ $version = 'V1m'; }
				elseif($version == 'V1o'){ $version = 'V1n'; }
				elseif($version == 'V1p'){ $version = 'V1o'; }
				elseif($version == 'V1q'){ $version = 'V1p'; }
				elseif($version == 'V1r'){ $version = 'V1q'; }
				elseif($version == 'V1s'){ $version = 'V1r'; }
				elseif($version == 'V1t'){ $version = 'V1s'; }
				elseif($version == 'V1u'){ $version = 'V1t'; }
				elseif($version == 'V1v'){ $version = 'V1u'; }
				elseif($version == 'V1w'){ $version = 'V1v'; }
				elseif($version == 'V1x'){ $version = 'V1w'; }
				elseif($version == 'V1y'){ $version = 'V1x'; }
				elseif($version == 'V1z'){ $version = 'V1y'; }
	}
	if($version == 'V1'){
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `id` = '".$rev_sold_id['order_id']."'")->row_array();
		$pdf = $orders['pdf'];
	}else{
		$prev_rev_sold = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$rev_sold_id['order_id']."' AND `version`='$version' LIMIT 1")->row_array();
		$pdf = $prev_rev_sold['pdf_file'];
	}
	?>										
	<tr>
	
		<td class="word-wrap-name">
			<?php echo $row['order_id']; ?>
		</td>
		<?php if(isset($rev_sold_id['id'])){
				$hd = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$rev_sold_id['help_desk']."'")->result_array();
		?>		
		<td><?php if(isset($hd)){ echo $hd[0]['name'];} else {echo " ";}?></td>	
		<td><?php if(isset($rev_sold_id['version'])){ echo $rev_sold_id['version']; }?></td>
		<td>								
			<?php if(isset($rev_sold_id)){echo $rev_sold_id['note'];} ?>
		</td>
		<td>	
			<?php 
				if($rev_sold_id['file_path'] != 'none'){ 
					$filepath = $rev_sold_id['file_path'];
					$this->load->helper('directory');
					$map = glob($filepath.'/*',GLOB_BRACE);
					if($map){ 
					
						$i=0; foreach($map as $file_row){$i++;
			?>								
			<a href="<?php echo base_url().$file_row; ?>" target="_Blank" class="btn btn-xxs bg-grey-cascade">Attachments <?php echo $i;?></a>
		<?php } } } ?>
		</td> 
		<?php  } else{?>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<?php }?>
		<td>
			<a href="<?php echo base_url().$pdf?>" target="_Blank" type="button" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i></a>
		</td>
		<!--<td><?php echo $pdf;?></td> -->
		<form method="post">
		<td id="savechanges<?php echo $count; ?>">
		
			<input type ="text" value="<?php echo $row['id'];?>" name="id" style="display:none">
			<select class="select2m form-control" name="error_id">
				<option value=""></option>
				<?php foreach($error_type as $error_row){ ?>
					<option value="<?php echo($error_row['id'])?>" <?php if($row['error_type']==$error_row['id']){ echo "selected"; } ?> ><?php echo($error_row['name']); ?></option>
				<?php } ?>
			</select>
			<span class="pull-right">
				<button id="submit_form<?php echo $count; ?>" type="submit" name="update_status" class="margin-top-5 btn btn-xs btn-primary" style="display: inline-block;">Save Changes</button>
			</span>
		
		</td>
	</form>
	</tr>
<script> 
$(document).ready(function(){
	$('#submit_form<?php echo $count; ?>').hide(); 
	
	$("#savechanges<?php echo $count; ?>").click(function(){
		$("#submit_form<?php echo $count; ?>").show(); 
	});

});
</script>	
	<?php } ?>	
		</tbody>
	</table>	
</div>
</div>
</div>
</div>	
	</div>
  </div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>