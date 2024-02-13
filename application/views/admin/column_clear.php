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

<script>
function Adp_confirm(){
    var X=confirm('Are You Sure ?');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 
</script>
  <div id="Middle-Div">
  <div class="span12">
   <div style="padding-left: 30px; padding-top: 20px;">
   <h3>Orders Table</h3>
   <?php echo "<h4 style='color:green'>".$this->session->flashdata("message")."</h4>"; ?>
	<form class="form-horizontal" method="post">
		 <fieldset>
		 <div class="control-group">
         <label class="control-label" for="focusedInput">Columns</label>
         <div class="controls">
            <select name="column_name" required>
				<option value="">Select</option>
			<?php foreach($order_column as $row){ ?>
				<option value="<?php echo $row; ?>"><?php echo $row; ?></option>
			<?php } ?>
			</select>
         </div>
         </div>
		 <div class="control-group">
          <label class="control-label">From</label>
          <div class="controls">
			<input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;" required/>
          </div>
         </div>
		 <div class="control-group">
          <label class="control-label">To</label>
          <div class="controls">
			<input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;" required/>
          </div>
         </div>
			<div style="padding-left: 180px;">
			<input type="submit" value="clear" name="clear" onclick="return Adp_confirm();" class="btn btn-primary" />
			</div>
		 </fieldset>
	</form>
		
   </div>
   
  </div> 
  </div>
<?php
      $this->load->view("admin/footer");
?>