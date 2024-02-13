<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("csr/header");
	
?>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/revision/';?>" + $('#help_desk').val() ;
        });
    });
</script>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<style>
#slug-view-02 input {
	background: #FFF;
	padding: 5px 10px;
	border: 2px solid #38b6ff;
	border-radius: 5px;
	width: 60%;
	outline: none;
}

#slug-view-01 h2 {
font-weight: normal;
padding: 0 0 20px 0;
margin: 0;
}

#slug-view-01 p {
padding: 0 0 5px 0;
margin: 0px
}
#slug-btn input {
	font-size: 14px;
	color: #FFF;
	background: #38b6ff;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}
#dp-view input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #ff7070;
	border-radius: 5px;
	width: 60%;
	outline: none;
}
#dp-view h2 {
	font-weight: normal;
	padding: 0 0 20px 0;
	margin: 0;
}
#dp-view p {
	padding: 0 0 5px 0;
	margin: 0px;
}
#dp-view-btn {
	padding-top: 15px;
	width: 45%;
}
#dp-view-btn input {
	font-size: 14px;
	color: #FFF;
	background: #ff7070;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}
#slug-error input {
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}
#rev-sold {
	clear: both;
	float: left;
	padding: 10px 0;
	margin-left: 5%;
	width: 90%;
	display: block;
}
.input {
	border: 1px solid #333;
}
.required {
	color: red;
	font-size: 12px;
}
#registerDiv {
	display: none;
	margin-top: 10px;
	margin-left: 20px;
	border: 2px solid #333;
	padding: 3px;
	background: #cdcdcd;
	width: 280px;
	text-align: center;
}


</style>

<div id="Middle-Div">
	<p style="text-align:center;">
        	<strong>Select Your HELP DESK:</strong>&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
        </p>
 <?php if(isset($form)):?>
 <div style="width: 100%; position: inherit;">
  <div id="slug-view-01">
  <div class="form">

 <?php
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/Chicago');
		}
		$today = date('Y-m-d');
		$rev_sold = $this->db->get_where('rev_sold_jobs',array('help_desk' => $form, 'date' => $today))->result_array();
		$order_count = count($rev_sold);
 ?>
    <form name="form" action="<?php echo base_url().index_page().'csr/home/revision';?>" method="post">
	
      <h2 style="padding:0; margin:0;">REVISION</h2>
      <div id="slug-view-02">
	  <input  type="text" name="form" id="form" value="<?php echo $form ;?>" readonly style="display:none;" />
      <input class="slug-view-input" type="text" name="id" id="id" placeholder="Copy & Paste Order No" required />
      </div>
	<p style="color:#F00; margin:0; padding:0; padding-top: 3px; font-weight: bold;"><input type="checkbox" name="fastrack" style=" margin-top:-5px;"> Fast Track </p> 
	
	<p style="padding: 0; margin: 0; font-weight: bold;">Rush Ads</p>
	
	<p style="color:#F00; margin:0; padding:0; padding-top: 3px; font-weight: bold;"><input type="checkbox" name="new" value="new" style=" margin-top:-5px;"> New Rush </p> 
	
    <p style="padding: 0; margin: 0; font-weight: bold;">Reason for Job Change</p>
    <div style="font-size: 12px;">
	 <?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '6', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
         </div> 
      <div id="slug-btn">
        <input type="submit" name="submit" id="search" value="Submit" /></div>
      <div id="slug-error">
        <?php 
			if(isset($fastrack_msg))
			{
				echo '<script language="javascript">';
				echo 'alert("Use Fastrack Printer")';
				echo '</script>';
			}
			
			if(isset($rev_status)) echo "<p>".  $rev_status ."</p>";	
		?>
      </div>
    </form>
    
  </div>
  </div>
  <div id="dp-view">
    <form name="form" action="<?php echo base_url().index_page().'csr/home/sold/'.$form;?>" method="post">
      <h2 style="padding:0; margin:0;">SOLD</h2>
	  <input  type="text" name="form" id="form" value="<?php echo $form ;?>" readonly style="display:none;" />
      <input type="text" name="id" id="id" placeholder="Copy & Paste Order No" required />
      <p style="padding: 0; margin: 0;">&nbsp;</p>
      <div id="dp-view-btn">
        <input type="submit" name="search"  />
      </div>
      <div id="slug-error">
        <?php if(isset($sold_status)) echo "<p>".  $sold_status ."</p>";	?>
      </div>
    </form>
    <div class="span3" style="padding-left: 50px; padding-top: 50px;">
                                    <div class="chart" data-percent="<?php echo $order_count; ?>"><?php echo $order_count; ?></div>
                                    <div class="chart-bottom-heading"><a href="<?php echo base_url().index_page()."csr/home/frontlinetrack_all";?>" target="_blank"><span class="label label-info">Tracker</span></a>

                                    </div>
                                </div>

</div>
</div>
<div style="width: 100%; background; #000; position: inherit;">
<form name="form" method="post">
   <div id="ad-form">
   <div id="ad-form-h">Incoming Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
   <input type="text" id="order_chk" name="order_chk"  autocomplete="off">
   <input name="form" value="<?php echo $form;?>" readonly style="display:none;" />
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
												<th>Date</th>
												<th>Adwit ID</th>
												<th>Job Name</th>
												<th>Advertiser</th>
												<th>Publication</th>
												<th>Adrep Name</th>
												<th>Action</th>
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
											<td><?php echo $row['job_no']; ?> </td>
											<td><?php echo $row['advertiser_name']; ?> </td>
											<td><?php echo $publication[0]['name']; ?> </td>
											<td><?php echo $adrep[0]['username']; ?> </td>
											
							<!--Revision --><?php if($slug=='none'){ echo'<td> </td>'; }else{?>
											<td title="Revision"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/rev_orders/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><img src="images/revision.png" alt="revision"/></a></td>
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
<?php  endif;?>
</div>
  </div>
<script src="theme001/vendors/jquery-1.9.1.min.js"></script> 
<script src="theme001/bootstrap/js/bootstrap.min.js"></script> 
<script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script> 
<script src="theme001/assets/scripts.js"></script>
<script src="theme001/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
<script>
        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({animate: 1000});
        });
        </script>
<?php
	$this->load->view("csr/footer");
	
?>
