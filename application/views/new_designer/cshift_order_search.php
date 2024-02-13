<?php $this->load->view("new_designer/head.php"); ?>

<script type="text/javascript"> function conf(ad_count) { var con = alert("Please complete 'My Q' before you take a new ad(Allowed Limit In-Production: 3, In-QA: 10 Ads) - "+ad_count); } </script> 

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">

		<?php if(isset($msg)) echo "<h3 style='color:#900;'>No Orders Found!! </h3>"; ?>
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold">Orders Search Result</span>
							</div>
							<div class="tools">
							</div>
							
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
							<tr>
								<th>Date</th>
								<th>Adwit Id</th>
								<th>Job Name</th>
								<th>Advertiser</th>
								<th>Publication</th>
								<th>PDF</th>
                                <th>View</th>
							</tr>
							</thead>
		<tbody name="testTable" id="testTable">
								
<?php if(isset($orders)){
		
		foreach($orders as $row1)
		{	
			$designer = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
			if(isset($rev_orders)){
				$order_status = 'Revision Submitted';
				if($rev_orders[0]['new_slug']!='none'){ $order_status = 'In Production'; }
				if($rev_orders[0]['pdf_path']!='none'){ $order_status = 'Proof Ready'; }
				if($rev_orders[0]['approve']!='0'){ $order_status = 'Approved'; }
				$publication = 	$this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
				$location = base_url().index_page().'new_designer/home/orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}else{
				$order_status = $this->db->get_where('order_status',array('id' => $row1['status']))->result_array();
				$order_status = $order_status[0]['name'];
				//echo $order_status;
				$publication = 	$this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
				$location = base_url().index_page().'new_designer/home/orderview/'.$row1['help_desk'].'/'.$row1['id'] ;
			}
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			
			$cat_pdf = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row1['id']."' AND `pdf_path` != 'none'")->result_array();
			if($cat_result){ 
				$form = $cat_result[0]['help_desk'];
				$cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
			}
			if($cat_result) { 
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
			//$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
						
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>

<!-- order_no --> 		<td><?php echo $row1['id']; ?></td>

<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- Advertiser -->		<td><?php echo $row1['advertiser_name']; ?></td>

<!-- newspaper -->		<td><?php if(isset($publication)) { echo $publication[0]['name']; } ?></td>

					
						<?php if(!isset($rev_orders)){ ?>
						<td>
							<?php if((isset($cat_pdf[0]['id'])) && $cat_pdf[0]['pdf_path']!='none' && file_exists($cat_pdf[0]['pdf_path'])){ ?>
							<a href="<?php echo base_url()?><?php echo $cat_pdf[0]['pdf_path'];?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
							<?php }else{ echo' '; }  ?> 
						</td><?php }else{ ?>
						<td>
							<?php if($rev_orders[0]['pdf_path']!='none' && file_exists($rev_orders[0]['pdf_path'])){ ?>
							<a href="<?php echo base_url()?><?php echo $rev_orders[0]['pdf_path'];?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
							<?php }else{ echo' '; }  ?> 
						</td><?php } ?>
						
<!-- View -->           <?php 
                            if((isset($slug) && $designer[0]['designer_role'] == '1' || $designer[0]['designer_role'] == '3' || $designer[0]['designer_role'] == '4') && $row1['status'] =='2' ){         
                        ?>
							<td>
							    <button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="createSlug(<?php echo $row1['id']; ?>);" >Start Design</button>
							</td>
						<?php }elseif(($designer[0]['designer_role'] == '1' || $designer[0]['designer_role'] == '3' || $designer[0]['designer_role'] == '4') 
						                && $row1['status'] !='2'){ ?>
							<td> 
							    <a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;">
							        <button type="button" class="btn blue btn-xs">View</button>
							    </a>
							</td>
						<?php } elseif($designer[0]['designer_role'] == '2'){ ?>
							<td> 
							    <a href="javascript:;" onclick="window.location = '<?php echo $location; ?>'" style="cursor:pointer; text-decoration: none;">
							        <button type="button" class="btn blue btn-xs">View</button>
							    </a>
							</td>
						<?php } ?>
			 </tr>
<?php  } } } ?>
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
            </tbody>
							</table>
						</div>
					</div>
				</div>
                </div>
        
		</div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script type="text/javascript"> 
    
    function createSlug(order_id){
	//ajax
			$.ajax({
					url: "<?php echo base_url().index_page();?>new_designer/home/createSlug/"+order_id,
					success: function(data) { 
					    var myObj = JSON.parse(data);
							var slug = myObj.slug;
							var alert_msg = myObj.msg;
							if(alert_msg != ''){
								alert(alert_msg);
								return false;
							}
					   		var X = confirm('Confirm Slug : '+slug);
						    if(X == true && slug != '')	 {
						     	var data_id = myObj.cat_id;
                    			var confirm_slug = 'none';
                    			var help_desk = myObj.help_desk;
                				//ajax
                				$.ajax({
                					url: "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id,
                					data:'slug='+slug+'&data_id='+data_id+'&confirm_slug='+confirm_slug,
                					type: "POST",
                					success: function(msg) { window.location.href = "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id; }
                				});	
                				return true;  
                			}else { 
								return false;  
                			}
					}
			});	
			return true;  
		
	}
	
</script>
<?php $this->load->view("new_designer/foot.php"); ?>