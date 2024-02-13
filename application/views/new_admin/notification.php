<?php $this->load->view("new_admin/header");?>
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

   		$( "#start_date" ).datepicker({ minDate: 0, maxDate: "6M", dateFormat: 'yy-mm-dd' });
		
		$( "#end_date" ).datepicker({ minDate: 0, maxDate: "6M", dateFormat: 'yy-mm-dd'});
				
	});
	
</script>

  <div id="Middle-Div">
  <div class="span12">
   <div style="padding-left: 30px; padding-top: 20px;">
		<form class="form-horizontal"  method="post">
		 <fieldset>
		 <div class="control-group">
         <label class="control-label" for="focusedInput">Headline</label>
         <div class="controls">
            <input type="text" id="headline" name="headline" required />
         </div>
         </div>
		 <div class="control-group">
          <label class="control-label">Message</label>
          <div class="controls">
		  <textarea name="message" style="width:270px;" required></textarea>
          </div>
         </div>
		 <div class="control-group">
          <label class="control-label" for="focusedInput">User Selection</label>
          <div class="controls">
		  <p><input type="checkbox" name="users[]" value="5" /> Designers</p>
		  <p><input type="checkbox" name="users[]" value="3" /> CSR</p>
		  <p><input type="checkbox" name="users[]" value="4" /> Team Lead</p>
		  <p><input type="checkbox" name="users[]" value="1" /> Art Director</p>
          </div>
         </div>
		<div class="control-group">
		<label class="control-label">Duration</label>
		<div class="controls">
		<span>From &nbsp;</span><input type="text" name="start_date" id="start_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="end_date" name="end_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		 </div>
		 </div>
		 <div style="padding-left: 180px;">
		<input type="submit" value="Submit" class="btn btn-primary" />
		</div>
		 </fieldset>
		</form>
   </div>
   
  </div> 
  </div>
<?php$this->load->view("new_admin/footer");?>