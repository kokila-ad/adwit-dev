<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../../../../ui_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<?php
	$this->load->view("new_csr/head");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>


<div class="container"> 
 
  <div class="row-fluid" style="width:96%; margin: 0 auto;">
        <!-- block -->
      <div class="block">
		 <div id="ad-form">
		 <div>
		 &nbsp;
		 </div>
		 <div id="ad-form-h" class="alert alert-danger"> <strong>Order No : <?php echo $order['id']; ?></strong></div>
		<div id="confirm" style="width:300px; margin: 0 auto; text-align: center;">
         <p class="contact"><b>Attachments </b></p>
		 <ul>
		<?php if(isset($order) && $order['file_path']!='none'){
			
				$this->load->helper('directory');
				$map = directory_map($order['file_path'].'/');
				if($map){ foreach($map as $row){
		?>
		<li>
	<a href="<?php echo $order['file_path'].'/'.$row;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><?php echo $row; ?></a>
		<br/>
		</li>
		<?php  } ?>
			<form method="post" action="<?php echo base_url().index_page().'csr/home/zip_folder';?>" style="text-align: center;">
				<input name="file_path" value="<?php echo($order['file_path'])?>" readonly style="visibility:hidden" />
				<input name="file_name" value="<?php echo($order['id'].'-'.$order['job_no'])?>" readonly style="visibility:hidden" />
				<input class="buttom" type="submit" name="Submit" value="Download Attachments" />
			</form>
		<?php } } ?> 
		</ul>
		</div>
		<!-- Softwrite Attachments -->
		<?php if(isset($soft_attachments)){ ?>
		<div id="confirm" style="width:300px; margin: 0 auto; text-align: center;">
         <p class="contact"><b>Softwrite Attachments </b></p>
		 <ul>
		<?php 
				$this->load->helper('directory');
				$map = directory_map($soft_attachments[0]['path'].'/');
				if($map){ foreach($map as $row){
		?>
		<li>
		<a href="<?php echo $soft_attachments[0]['path'].'/'.$row;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><?php echo $row; ?></a>
		<br/>
		</li>
		<?php  }  ?>
			<form method="post" action="<?php echo base_url().index_page().'csr/home/zip_folder';?>" style="text-align: center;">
				<input name="file_path" value="<?php echo($soft_attachments[0]['path'])?>" readonly style="visibility:hidden" />
				<input name="file_name" value="<?php echo($order['id'].'-'.$order['job_no'])?>" readonly style="visibility:hidden" />
				<input class="buttom" type="submit" name="Submit" value="Download Attachments" />
			</form>
		<?php } ?> 
		</ul>
		</div>
		<?php } ?>
		
		<?php if(isset($order) && $order['rush']=='0'){ ?>
		<form name="myform" method="post" >
			<input name="rush" value="1" style="width:20px;" type="checkbox" onchange="this.form.submit()"><label for="name"><span></span>Rush</label>
		</form>
		<?php } ?>
		</div>
     </div>
  </div>
</div>
  
<?php
	$this->load->view("new_csr/foot");
?>