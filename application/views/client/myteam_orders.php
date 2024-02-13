<?php
       $this->load->view("client/header1");
?>
 
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/New_York');
				}
				$current_time = date("H:i:s"); 
		?>
    }
</script>
<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
	
	});

</script>

  <div id="Middle-Div">
  <?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
  <form method="post" style="padding:0px; margin:0px; float: right;" >
               <span>Search:  </span><input type="text" name="search" id="search" placeholder="search" />
               <input type="submit" value="Submit" />
   </form></br>
  <div style="padding-left: 30px; padding-top: 20px;">
		<form method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" value="Submit" />
		</form>
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">My Team Orders </div>
                            <div style="float: right;">
								<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" />
								<a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img title="Refresh" src="images/refresh_trackingsheet.png"/></a>
							</div>
						</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											
                                            <tr>
												<th rowspan="2" style=" vertical-align:middle;">Date</th>
												<th rowspan="2" style=" vertical-align:middle;">Type</th>
												<th rowspan="2" style=" vertical-align:middle;">Adwit Ads ID</th>
												<th rowspan="2" style=" vertical-align:middle;">Unique Job ID</th>
												<th rowspan="2" style=" vertical-align:middle;">Advertiser Name</th>
												<th rowspan="2" style=" vertical-align:middle;">Publish Date</th>
	
												<th rowspan="2" style=" vertical-align:middle;">Status</th>
												<th colspan="6" style=" text-align: center;">Actions</th>
											</tr>
											
										</thead>
										<tbody name="testTable" id="testTable">
<?php
	foreach($orders as $row)
	{ 
		$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
		$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
		//$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $row['id']))->result_array();
		$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
		$pdf_path = 'none';
		if($orders_rev)
		{
			$order_status = 'Revision Submitted';
			if($orders_rev[0]['new_slug']!='none'){ $order_status = 'In Production'; }
			if($orders_rev[0]['pdf_path']!='none'){ 
				$order_status = 'Proof Ready'; 
				
				$pdf_path = $orders_rev[0]['pdf_path'];
				if(!file_exists($pdf_path)){
					$pdf_path = $orders_rev[0]['pdf_path'].'/'.$orders_rev[0]['pdf_file'];
				}
			}
			if($orders_rev[0]['approve']!='0'){ $order_status = 'Approved'; }
			//note sent revision
			$note = $this->db->get_where('note_sent',array('revision_id' => $orders_rev[0]['id']))->row_array();
		}else{ 
			
			$order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->result_array();
			$order_status = $order_status[0]['name'];
				if($row['pdf']!='none'){ 
					$pdf_path = $row['pdf'];
					if(!file_exists($pdf_path)){
						$pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; 
					}
				}		
			//note sent newad
			$note = $this->db->get_where('note_sent',array('order_id' => $row['id'], 'revision_id' => '0'))->row_array();
		}
		if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
		
		
?>    									
											<tr class="odd gradeX">
												<td><?php $date = strtotime($row['created_on']); echo date('Y-m-d', $date); ?></td>
												<td title="<?php echo $order_type[0]['name']; ?>"><img src="<?php echo $order_type[0]['src']; ?>" alt="<?php echo $order_type[0]['name']; ?>"/></td>
										<?php if($cat_result && $cat_result[0]['slug']!='none'){  ?>
												<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row['id']; ?></a></td>
										<?php }else{ echo '<td>'.$row['id'].'</td>'; }  ?>	
												<td><?php echo $row['job_no']; ?></td>
												<td><?php echo $row['advertiser_name']; ?></td>
												<td><?php echo $row['publish_date']; ?></td>
									<!-- order status -->
												<?php if($orders_rev && $orders_rev[0]['question']!='' && $orders_rev[0]['answer']=='none'){ ?>
												<td> <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/answer/'.$orders_rev[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn tooltip-top" title="<?php echo $orders_rev[0]['question']; ?>">Question</button></a> </td>
												<?php } else{ ?>
												<td title="<?php if($order_status == 'Cancel Requested'){echo $cat_result[0]['reason'];} ?>" style="cursor:pointer;"> <?php echo $order_status; ?> </td> 
												<?php } ?>
												
												<?php if($order_status == 'Proof Ready' || $order_status == 'Approved') {?>
								<!-- pickup --><td title="Pickup"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/order_form/'.$order_type[0]['value'].'/pickup-ads/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/pickup.png" alt="pickup"/></a></td>
												<?php }else{ echo "<td> </td>"; }?>
												
												<?php if($order_status == 'Proof Ready') {?>
							  <!-- revision --><td title="Revision"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/rev_orders/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/revision.png" alt="revision"/></a></td>
												<?php }else{ echo "<td> </td>"; }?>
												
							<!-- view -->		<td title="View"> <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/view/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/order_view.png" alt="view"/></a> </td>
												
												<?php if($order_status == 'Proof Ready') {?>
							<!-- file attach --><td title="Attach File"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/additional_file_uploads/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/attachment.png" alt="Attach file"/></a></td>
								<!--<td title="Attach File"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/file_uploads/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/attachment.png" alt="Attach file"/></a></td>-->
												<?php }else{ echo "<td> </td>"; } ?>
												

					<?php if($pdf_path != 'none' && file_exists($pdf_path)){ ?>
<!-- PDF View -->	<td>
					<a href="<?php echo base_url().$pdf_path;?>" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" target="_blank" style="cursor:pointer; text-decoration: none;">
						<img src="images/pdf.png" alt="pdf"/>
					</a></td>
					<?php }else{ echo '<td> </td>'; }?>
	
					<?php if($pdf_path != 'none'){ ?>
					
<!-- Job Rating -->	<?php if($order_status == 'Approved'){ ?>
						<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/unapprove_teamorder/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn btn-danger btn-mini">Unapprove</button></a>
						</td> 
					<?php }else{ ?>
                <td title="Job Approval"><a href="<?php echo base_url().index_page().'client/home/jRate/'.$row['id'] ;?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'client/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
                  <button class="btn btn-success btn-mini">Approve</button></a>
				</td>
				
<!-- cancel -->		<?php } }elseif($order_status == 'Cancelled'){ echo '<td></td>';}
					elseif($order_status == 'Cancel Requested'){ 
					?>
					<td style="cursor:pointer;">
					<form method="post" action="<?php echo base_url().index_page().'client/home/order_cancel/'.$row['id'];?>">
						<button type="submit" name="remove" id="remove" class="btn btn-primary btn-mini" onclick="return confirm('Are you sure you want to accept order cancellation ?');">Accept</button>
					</form>	 
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/reject/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Reject</button></a>
					</td>
					<?php
					}elseif(!$orders_rev && $order_status != 'Proof Ready'){ ?>
					<td title="Job Cancel">
						<form method="post" action="<?php echo base_url().index_page().'client/home/order_cancel/'.$row['id'];?>">
							<button type="submit" name="remove" id="remove" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure you want to cancel ?');">Cancel</button>
						</form>
					</td>
					<?php }else{ echo'<td></td>'; } ?>

											</tr>
<?php }?>											
										</tbody>
									</table>
                               </div>
                            </div>
                        </div>
                        </div>
  </div>
 
    <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        
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
		  
<?php
       $this->load->view("client/footer");
?>

