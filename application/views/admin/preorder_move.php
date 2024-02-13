<?php
       $this->load->view("admin/header");
?>
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

   		$( "#from_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd'});
	});

</script>

<div id="Middle-Div">
<?php echo $this->session->flashdata("message"); ?>
<div class="row-fluid" style="width: 96%; margin: 0 auto; ">
  <div style=" float: left;">
    <form method="post" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" <?php if(isset($from_date)){echo"value='$from_date'";} ?> placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;" required/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" <?php if(isset($to_date)){echo"value='$to_date'";} ?> placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;" required/>
      <input type="submit" name="submit" value="submit"/>
    </form>
	<?php if(isset($count)){ ?>
		<form method="post" >
			<input type="text" name="from_date" value="<?php echo $from_date; ?>" style="display:none;" />
			<input type="text" name="to_date" value="<?php echo $to_date; ?>" style="display:none;" />
			<label> Move 
			<input type="submit" name="Move" value="<?php echo $count; ?>"/>
			Entrie(s) To Archive Table </label>
		</form>
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
 
<?php
       $this->load->view("admin/footer");
?>