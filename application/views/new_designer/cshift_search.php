<?php
       $this->load->view("new_designer/head"); 
?>

<!-- END HEADER -->

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
 <?php 
	echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';
 if(isset($form)):
 ?>
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold">Search Result</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
						  <table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							 <tr>
				<th style="vertical-align: middle;">Date</th>
				<th style="vertical-align: middle;">Type</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>
				<th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Design</th>
                          </tr>  
							</thead>
							 <tbody name="testTable" id="testTable">
<?php 
	
		foreach($order as $row1)
		{
			$publication = 	$this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			//$cat_result = $this->db->query("SELECT * FROM `designers`,`cat_result` WHERE `order_no`='".$row1['id']."' AND designers.id = cat_result.designer ")->result_array();
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row1['id']))->result_array();
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
			  
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><button type="button" class="btn blue-steel btn-sm"><?php if($order_type[0]['value']=='print') {echo "P";} elseif($order_type[0]['value']=='web'){ echo "W";} else{ echo "P&W";}?></button></td>
<!-- Adwit Id --><td title="view attachments"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row1['id'] ;?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>							
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- Publication -->		<td><?php echo $publication[0]['name']; ?></td>
<!-- Category -->		<td><?php if($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?></td>
<!-- Design -->			<td>
						<?php if($cat_result && $cat_result[0]['cancel']!='0'){ echo "Cancelled"; }
							elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none'){echo "<button type='button' class='btn green-meadow btn-xs'>Question Sent</button>"; }
							elseif($cat_result && $cat_result[0]['pdf_path']!='none'){echo "Uploaded";}
							elseif($cat_result && $cat_result[0]['designer']!='0'){echo $cat_result[0]['designer'];}
							elseif($cat_result){ ?>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'new_designer/home/cshift_dptool/'.$form.'/'.$row1['id'] ;?>'" style="cursor:pointer; text-decoration: none;"><button type="button" class="btn red-sunglo btn-xs">Create Slug</button></a>
							<?php } ?>
						</td>
				 </tr>
   <?php } ?>
            </tbody>
						</table>
						</div>
					</div>
				</div>
        </div>
		<?php  endif; ?>
        </div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<?php
       $this->load->view("new_designer/foot"); 
?>
