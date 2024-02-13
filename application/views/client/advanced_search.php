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
<!--<script type="text/javascript">
	
	$(document).ready(function(e) {    
		$('#ad-form-sr-custom').hide();
		$('#column').change(function(e) {
            if($('#column').val()=='spec_sold_ad') $('#ad-form-sr-custom').show();
			else $('#ad-form-sr-custom').hide();
        });	
		
		$('#ad-form-sr-custom01').hide();
		$('#column').change(function(e) {
            if($('#column').val()=='status') $('#ad-form-sr-custom01').show();
			else $('#ad-form-sr-custom01').hide();
        });	
		
	});
</script>-->

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
	
	});

</script>

<div id="Middle-Div">
  <?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
  <!-- top bar serach -->
 <div class="row-fluid" style="width: 96%; margin: 0 auto; ">
 <div style=" float: left;">
<h2>Advanced Search</h2>
    <form method="post" style="padding:0; margin:0;">
		<input type="text" name="id" id="id" placeholder="Search"  style="padding: 10px; width: 200px;" autocomplete="off" required />
		<br><br><br>
		<select  id="column" name="column" style="width: 100px; margin-right: 10px;" required>
			<option value="">Select</option>
            <option value="id">Adwit Id</option>
			<option value="job_no">Unique Job Id</option>
			<option value="advertiser_name">Advertiser</option>
			<option value="publication_name">Publication Name</option>
		</select>
		<!-- order type -->
		<select  id="order_type" name="order_type" style="width: 100px; margin-right: 10px;">
			<option value="">All Ad Type</option>
			<?php
				$results = $this->db->get('orders_type')->result_array();
				foreach($results as $result)
				{
					echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>';	
				}
			?>
		</select>
		
		<!-- ad status -->
		<select  id="status" name="status" style="width: 100px;">
			<option value="">All Status</option>
			<?php
				$results = $this->db->get('order_status')->result_array();
				foreach($results as $result)
				{
					echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>';	
				}
			?>
		</select>
<br><br><br>
				
		<input type="text" name="from_date" id="from_date" placeholder="From: YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		&nbsp;&nbsp;
		<input type="text" id="to_date" name="to_date" placeholder="To: YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>

<br><br><br>
		
		<input type="submit" name="search" value="Search" style="padding: 10px 50px;" />
    </form>
 </div>
</div>
 <div class="block-content collapse in">
   <div class="span12">
<?php if(isset($orders)){ ?>
<table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered" id="example">
			<thead>
              <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Adwit Ads ID</th>
                <th>Unique Job ID</th>
                <th>Advertiser Name</th>
                <th>Publish Date</th>
                <th>Status</th>
                <th colspan="6" style="text-align: center;">Actions</th>
              </tr>
			</thead>
			<tbody name="testTable" id="testTable">
<?php
	foreach($orders as $row)
	{ 
		$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
		$orderstatus = $this->db->get_where('order_status',array('id'=>$row['status']))->result_array();
		$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
		$pdf_path = 'none';
		if($orders_rev){
			$order_status = 'Revision Submitted';
			if($orders_rev[0]['new_slug']!='none'){ $order_status = 'In Production'; }
			if($orders_rev[0]['pdf_path']!='none'){ 
				$order_status = 'Proof Ready'; 
				$pdf_path = 'http://www.adwitads.com/weborders/'.$orders_rev[0]['pdf_path'];
			}
			if($orders_rev[0]['approve']!='0'){ $order_status = 'Approved'; }
		}else{
			$order_status = $orderstatus[0]['name'];
			if($row['pdf']!='none'){ $pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; }
			if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
			if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
		}
		
?>    									
			<tr class="odd gradeX">
		
				<td><?php $date = strtotime($row['created_on']); echo date('Y-m-d', $date); ?></td>
				
				<td title="<?php echo $order_type[0]['name']; ?>"><img src="<?php echo $order_type[0]['src']; ?>" alt="<?php echo $order_type[0]['name']; ?>"/></td>
				<!--<td><?php echo $row['name']; ?></td>						-->
				
				<?php if($order_status!='Order Received' || $order_status!='Order Accepted'){ ?>
                <td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row['id']; ?></a></td>
                <?php }else{ echo '<td>'.$row['id'].'</td>'; }  ?>
				
				<td><?php echo $row['job_no']; ?></td>
				
				<td><?php echo $row['advertiser_name']; ?></td>
				
				<td><?php echo $row['publish_date']; ?></td>
				
<!--STATUS order status -->
				<td>
					<?php if($row['question']=='1'){ ?>
					<!-- Question sent for Answer -->
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/cshift_answer_v2/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
					<button class="btn tooltip-top">Question</button>
					</a>
					<?php }elseif($orders_rev && $orders_rev[0]['question']!='' && $orders_rev[0]['answer']=='none'){ ?>
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/answer_v2/'.$orders_rev[0]['id'];?>'" style="cursor:pointer; text-decoration: none;">
                  <button class="btn tooltip-top" title="<?php echo $orders_rev[0]['question']; ?>">Question</button>
                  </a>
                <?php } else{ ?>
					<?php echo $order_status; ?> 
					<?php } ?>
				</td> 
				
<!-- Actions -->			
					<!-- pickup -->	
				<td title="Pickup">
					<?php if($order_status == 'Proof Ready' || $order_status == 'Approved') {
						if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/order_form/'.$order_type[0]['value'].'/pickup-ads/'.$row['job_no'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/pickup.png" alt="pickup"/></a>
					<?php }else{ ?>
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/order_form/'.$order_type[0]['value'].'/pickup-ads/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/pickup.png" alt="pickup"/></a>
					<?php } }else{ echo ""; }?>
				</td>
				
					<!-- revision -->
				<td title="Revision">
					<?php if($order_status == 'Proof Ready') {?>
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/rev_orders/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<img src="images/revision.png" alt="revision"/>
					</a>
					<?php }else{ echo ""; }?>
				</td>
				
					<!-- view -->			
				<td title="View"> 
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/view/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<img src="images/order_view.png" alt="view"/>
					</a> 
				</td>
												
					<!-- file attach -->
				<td title="Attach File">
					<?php if(($order_status == 'Order Received' || $order_status == 'Order Accepted' || $order_status == 'IN Production'|| ($orders_rev && $orders_rev[0]['question']!='' && $orders_rev[0]['answer']=='none')) && $row['question']=='0') {?>
					<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/additional_file_uploads/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/attachment.png" alt="Attach file"/></a>
					<?php }else{ echo ""; } ?>
				</td>
				
					<!-- PDF View -->
				<td title="PDF">
					<?php if($pdf_path != 'none'){ ?>
					<a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a>
					<?php }else{ echo ''; }?>
				</td>
				
					<!-- Job Rating -->	
				<?php if($pdf_path != 'none'){ ?>
					<?php if($order_status == 'Approved'){ ?>
						<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/unapprove_order/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<button class="btn btn-danger btn-mini">Unapprove</button></a>
						</td> 
				<?php }else{ ?>
                <td title="Job Approval"><a href="<?php echo base_url().index_page().'client/home/jRate/'.$row['id'] ;?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'client/home/jRate/'.$row['id'];?>','1432728298066','width=515,height=228,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;">
                  <button class="btn btn-success btn-mini">Approve</button></a>
				</td>
				
                <!-- cancel -->
                <?php } }elseif($row['cancel'] != '0'){
					//Resubmit 
					if($publication[0]['design_team_id']=='8' || $publication[0]['id']=='43'){ ?>
					
					<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/order_form/'.$order_type[0]['value'].'/new-ads/'.$row['job_no'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Resubmit</button></a></td>
					<?php }else{ ?>
					<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/order_form/'.$order_type[0]['value'].'/new-ads/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Resubmit</button></a></td>
					
					<?php }	}elseif($order_status == 'Cancel Requested'){ ?>
					<td style="cursor:pointer;">
					<form method="post" action="<?php echo base_url().index_page().'client/home/order_cancel/'.$row['id'];?>">
<!--cancel req accept --><button type="submit" name="remove" id="remove" class="btn btn-primary btn-mini" onclick="return confirm('Are you sure you want to accept order cancellation ?');">Accept</button>
					</form>	 
<!--cancel req reject --><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/reject_v2/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Reject</button></a>
					</td>
					<?php
					}elseif(!$orders_rev && $order_status != 'Proof Ready'){ ?>
<!--cancel button --><td title="Job Cancel">
						<form method="post" action="<?php echo base_url().index_page().'client/home/order_cancel/'.$row['id'];?>">
							<button type="submit" name="remove" id="remove" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure you want to cancel ?');">Cancel</button>
						</form>
					</td>
					<?php }else{ echo'<td></td>'; } ?>

		</tr>
<?php } ?>											
										</tbody>
									</table>
<?php } ?>    
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

