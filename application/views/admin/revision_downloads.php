<?php $this->load->view("admin/header") ?>
   <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});
	
	
	
</script>
 <div class="navbar navbar-inner block-header">
<h4>Revision Download Folder Deletion </h4>
</div>
  <div style="padding-left: 30px; padding-top: 20px;">
		<form method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="date" name="from_date" id="from_date" placeholder="YYYY-MM-DD" value="<?php if(isset($from)) echo $from; ?>" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;
		<span>To &nbsp;</span><input type="date" id="to_date" name="to_date" placeholder="YYYY-MM-DD" value="<?php if(isset($to)) echo $to; ?>" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" name="submit" value="Submit" />
		</form>
   </div>
   
<?php 
		if(isset($message)){ echo '<p>'.$message.'</p>'; }
		 
?>
   
   <script src="theme001/assets/scripts.js"></script>
   <script src="theme001/assets/DT_bootstrap.js"></script>



<?php $this->load->view("admin/footer") ?>