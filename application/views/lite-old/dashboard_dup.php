<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<!-- pagination -->
<link rel="stylesheet" type="text/css" href="assets/lite/css/pagination/datatables.min.css"/> 
<script type="text/javascript" src="assets/lite/css/pagination/datatables.min.js"></script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').DataTable( {
					"order": [[ 1, "desc" ]]
				} );
			} );

			$(document).ready(function() {
				$('#example').DataTable();
			} );
			
			
</script>		
<!-- endpagination -->
<script>
  $(document).ready(function(){
  $("#show-search").hide();
  
  $("#open-search").click(function(){
  $("#show-search").toggle();     
   });
	 
  });
</script>		
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display').change(function(e) {
            window.location = "<?php echo base_url().index_page().'lite/home/dashboard/';?>" + $('#display').val() ;
        });
    });
</script>		
<section>
      <div class="container margin-top-30">   
			<?php echo $this->session->flashdata('message'); ?>	
		<div class="row">
		      <div class="col-md-6"><p class="xlarge">Order History</p>  </div>
			<form>  
			  <div class="col-md-6 text-right">
				  View <select id="display" class="padding-vertical-5 padding-horizontal-10">
					<option value="">SELECT</option>
					<option value="3" <?php if(isset($num_days) && $num_days=='3') echo "selected"; ?>>3 Days</option>
					<option value="7" <?php if(isset($num_days) && $num_days=='7') echo "selected"; ?>>7 Days</option>
					<option value="14" <?php if(isset($num_days) && $num_days=='14') echo "selected"; ?>>14 Days</option>
					<option value="30" <?php if(isset($num_days) && $num_days=='30') echo "selected"; ?>>30 Days</option>
				  </select>
				  
				  <p class="btn btn-primary text-theme padding-top-10 cursor-pointer" id="open-search">Search</p>
			  </div>
			 </form>
        </div>
		
		<div class="row margin-0 border"  id="show-search">  		 
			<div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-left-0">  
				<p class="center margin-top-25 large"> No New Notifications</p>		  
				<div class="row margin-0 background-color-lightred border-red hide">
			 		<div class="col-md-1 col-sm-1 col-xs-1 center background-color-red padding-0"> 
						<p class=" padding-top-10 text-white"><a href="#"><i class="glyphicon glyphicon-check"></i></a></p>					
					</div> 					
				</div>	 
			</div> 		  
 
			<div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-right-0  border-left">
				<?php $this->load->view("lite/search_view.php"); ?>
			</div>
		</div>		 
	
	  </div>	  
</section>
   

<section>
    <div class="container">
        <div class="margin-bottom-30">
     <div class="border padding-20 margin-top-10">    
      <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
          <tr>
              <th class="background-color-light">Date</th>
              <th class="background-color-light">Order Id</th>
              <th class="background-color-light">Job Name</th>
              <th class="background-color-light">Date Needed</th>
              <th class="background-color-light">Credits Used</th>
			  <th class="background-color-light">Status</th>
			  <th class="background-color-light"></th>
          </tr>
        </thead>
<?php if(isset($orders)){ ?>
        <tbody>
<?php $i=0; foreach($orders as $row){ $i++; 
				$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
				if($orders_rev){
					$order_status = $orders_rev[0]['status'];
					if($order_status!='0'){
						$order_status_name = $this->db->query("SELECT * FROM `rev_order_status` WHERE `id` = $order_status")->result_array();
					}else{ $order_status_name[0]['name']='Incomplete'; }
					
					$pdf_path = $orders_rev[0]['pdf_path'];
					if(!file_exists($pdf_path)){
						$pdf_path = $orders_rev[0]['pdf_path'].'/'.$orders_rev[0]['pdf_file'];
					}
				}else{
					$order_status = $row['status'];
					if($order_status!='0'){
						$order_status_name = $this->db->query("SELECT * FROM `order_status` WHERE `id` = $order_status")->result_array();
					}else{ $order_status_name[0]['name']='Incomplete'; }
					if($row['pdf']!='none'){ 
						$pdf_path = $row['pdf'];
						if(!file_exists($pdf_path)){
							$pdf_path = 'pdf_uploads/'.$row['id'].'/'.$row['pdf']; 
						}
					}
					if($row['crequest']!='0'){ $order_status = 'Cancel Requested'; }//csr order cancellation req
					if($row['cancel']!='0'){ $order_status = 'Cancelled'; }//adrep order cancellation
				}

?>		
		<tr class="odd">
            <td><?php echo $row['created_on'];?></td>
			
            <td><?php if($orders_rev) { ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/revision_details/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
							<?php echo $row['id']; ?>
						</a>
				<?php }else{ echo $row['id']; }  ?>
			</td>
			
            <td><?php echo $row['job_no']; ?></td>
			
            <td><?php echo $row['date_needed'];?></td>
			
			<td><?php echo $row['credits'];?></td>
			
			<td>
						<?php if($row['question']=='1'){ ?>
						<!-- Question sent for Answer -->
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/new_ad_answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<button class="btn-danger btn-sm">Question</button></a>
						<?php }elseif($orders_rev && $orders_rev[0]['question']!='' && $orders_rev[0]['answer']=='none'){ ?>
						<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'lite/home/rev_ad_answer/'.$orders_rev[0]['id'];?>'" style="cursor:pointer; text-decoration: none;">
						<button class="btn-danger btn-sm" title="<?php echo $orders_rev[0]['question']; ?>">Question</button></a>
						<?php } else{ ?>
						<?php echo $order_status_name[0]['name']; ?> 
						<?php } ?>
			</td>
			
<!-- Actions -->				
					<td>
						<span class="dropdown">
						<span class="cursor-pointer" type="button" data-toggle="dropdown">Actions<span class="caret"></span></span>
						<ul class="dropdown-menu">
						<?php 
							$actions = $this->db->get_where('order_adrep_actions',array('order_status_id' => $order_status))->result_array();
							foreach($actions as $data){
								$action_link = $this->db->get_where('adrep_actions',array('id' => $data['adrep_action_id']))->result_array(); 
						?>
						 <li><a href="<?php echo base_url().index_page().'lite/home/order_action/'.$action_link[0]['action'].'/'.$row['id'];?>" data-toggle="tooltip" class="margin-right-25 margin-left-15"><?php echo $action_link[0]['name']; ?></a></li> 
						<?php } ?>
						</ul>
						</span>
					</td>			
			
		</tr>

<?php } ?>
        </tbody>
<?php } ?>		
      </table>
    </div>
             
      </div>
        </div><!-- /.padding-vertical-50 -->

</section><!-- /section -->

 <div id="qa" class="modal fade" role="dialog">
  <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal">&times;</button>
   <h4 class="modal-title">Question & Answers</h4>
    </div>
    
  <form  role="form" method="post" action="<?php echo base_url().index_page().'lite/home/que_ans/'.$row['id']?>" enctype="multipart/form-data">
	<div class="modal-body">
		<textarea rows="4" class="form-control" name="question" placeholder="Message goes here...."></textarea>
    </div>
	<div class="modal-footer">
		<button type="submit" name="submit" id="id" class="btn  btn-primary btn-lg">Submit</button>
	</div>
   </form> 
  
  </div>
  </div>
</div>
		
<script>
    $(function(){
      // bind change event to select
      $('#action<?php echo $i; ?>').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>  
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>
