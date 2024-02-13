<?php
       $this->load->view("designer/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<div id="Middle-Div">
	
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
  <div style="padding-bottom: 30px;"> 
  <div style="float: right;">
  <form name="form" method="post">
       <p class="contact">Search History
        <input name="id" type="text" autocomplete="off" required/>
        <input type="submit" name="search" /></p>
  </form>
  </div>
  </div>
 
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Cshift Tracker</div>
	</div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
				<th style="vertical-align: middle;">Date</th>
				<th style="vertical-align: middle;">Type</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>
				<th style="vertical-align: middle;">Category</th>
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
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><img src="<?php echo $order_type[0]['src']; ?>" alt="<?php echo $order_type[0]['name']; ?>"/></td>
<!-- Adwit Id --><td title="view attachments"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'designer/home/attachments/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>							
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- Publication -->		<td><?php echo $publication[0]['name']; ?></td>
<!-- Category -->		<td><?php if($cat_result){echo $cat_result[0]['category'];}else{echo 'Pending';} ?></td>
<!-- Design -->			<td>
						<?php if($cat_result && $cat_result[0]['cancel']!='0'){ echo "Cancelled"; }
							elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none'){echo "<b>Question Sent</b>"; }
							elseif($cat_result && $cat_result[0]['pdf_path']!='none'){echo "Uploaded";}
							elseif($cat_result && $cat_result[0]['designer']!='0'){echo $cat_result[0]['designer'];}
							elseif($cat_result){ ?>
							<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'designer/home/cshift_dptool/'.$form.'/'.$row1['id'] ;?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Create Slug</button></a>
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
                            
<?php
       $this->load->view("designer/footer");
?>