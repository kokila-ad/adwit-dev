<?php
       $this->load->view("team-lead/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>


<div id="Middle-Div">
 
  <div class="row-fluid" style="width:96%; margin: 0 auto;">
        <!-- block -->
      <div class="block">
		 <div id="ad-form">
		 <div id="ad-form-h">Order No : <?php echo $order['id']; ?></div>
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
			<form method="post" action="<?php echo base_url().index_page().'team-lead/home/zip_folder';?>" style="text-align: center;">
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
			<form method="post" action="<?php echo base_url().index_page().'team-lead/home/zip_folder';?>" style="text-align: center;">
				<input name="file_path" value="<?php echo($soft_attachments[0]['path'])?>" readonly style="visibility:hidden" />
				<input name="file_name" value="<?php echo($order['id'].'-'.$order['job_no'])?>" readonly style="visibility:hidden" />
				<input class="buttom" type="submit" name="Submit" value="Download Attachments" />
			</form>
		<?php } ?> 
		</ul>
		</div>
		<?php } ?>
		</div>
     </div>
  </div>
</div>
  
                    
<?php
       $this->load->view("team-lead/footer");
?>

