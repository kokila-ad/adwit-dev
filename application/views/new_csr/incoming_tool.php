<?php $this->load->view("new_csr/head.php"); ?>

         <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

  <div id="Middle-Div">
  
  <form name="form" method="post">
   <div id="ad-form">
   <div id="ad-form-h">Incoming Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
   <input type="text" id="order_chk" name="order_chk"  autocomplete="off">
	<input class="buttom" type="submit" name="search" id="search" value="search">
    <p>&nbsp;</p>
   <?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
</div>
</div>
</form>
  <?php if(isset($orders)):?>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Order Details </div>
                            
						</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											
                                            <tr>
												<th rowspan="2" style=" vertical-align:middle;">Date</th>
												<th rowspan="2" style=" vertical-align:middle;">Adwit Ads ID</th>
												<th rowspan="2" style=" vertical-align:middle;">Slug</th>
												<th rowspan="2" style=" vertical-align:middle;">Publication</th>
												<th rowspan="2" style=" vertical-align:middle;">Unique Job ID</th>
												<th rowspan="2" style=" vertical-align:middle;">Adrep Name</th>
												<th rowspan="2" style=" vertical-align:middle;">Revision</th>
											</tr>
										
										</thead>
										<tbody name="testTable" id="testTable">
<?php
	foreach($orders as $row)
	{
		$slug = 'none';
		$adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
		$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id`=(SELECT MAX(`id`) FROM `rev_sold_jobs` WHERE `order_id`='".$row['id']."')")->result_array();
		$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
		if($orders_rev)
		{
			$slug = $orders_rev[0]['new_slug'];
		}elseif($cat_result){
			$slug = $cat_result[0]['slug'];
		}
		
?>    									
											<tr class="odd gradeX">
											<td><?php $date = strtotime($row['created_on']); echo date('Y-m-d', $date); ?></td>
											<td><?php echo $row['id']; ?> </td>
											<td><?php echo $slug; ?> </td>
											<td><?php echo $publication[0]['name']; ?> </td>
											<td><?php echo $row['job_no']; ?> </td>
											<td><?php echo $adrep[0]['username']; ?> </td>
											
							<!--Revision --><?php if($slug=='none'){ echo'<td> </td>'; }else{?>
											<td title="Revision"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/rev_orders/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/revision.png" alt="revision"/></a></td>
											<?php } ?>
											
											</tr>
<?php } ?>											
										</tbody>
									</table>
                               </div>
                            </div>
                        </div>
                        </div>
<?php endif; ?>						
  </div>
 
    <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        
		  
<?php $this->load->view("new_csr/foot.php"); ?>
