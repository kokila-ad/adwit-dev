<?php $thhis->load->view("admin/head") ?>

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});
	
	
	
</script>
  <div style="padding-left: 30px; padding-top: 20px;">
		<form method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" value="Submit" />
		</form>
   </div>




















<?php $this->load->view("admin/foot") ?>