
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		<!-- 2016 © adwitads. All Rights Reserved. version 4.1-->
		<?php $footer_copy = $this->db->query("SELECT * FROM `footer_copy`")->result_array(); 
		 echo $footer_copy[0]['footer_name'];  ?>
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->

<base href="<?php echo base_url();?>" />
<script type="text/javascript">
	function myFunction(){ location.reload(); }
	
// 	function goBack(){ window.history.back(); }
	function goBack() {   
    var back_tab = localStorage.getItem('go_back_tab');
    var display_type = localStorage.getItem('display_type');
    var new_ads = localStorage.getItem('new_ads');
    // var seelcted_date = localStorage.getItem('selected_date');
    if (back_tab != "" && back_tab != null  && back_tab != "revision" && new_ads == "new_ads") {
        window.location.href = back_tab;
    }else {
        window.history.go(-1); // window.history.back(); 
    }
    }
	
	function closeWin(){ myWindow.close(); }
	function Adp_confirm(){
		var X=confirm('Before hitting "Submit", take a quick moment to ensure everything looks just right. Thanks!');
		if(X==true){
		return true;
	  }
	else
	  {
		return false;
	  }
	} 
	function sold_confirm(){
		var X=confirm('Are You Sure??');
		if(X==true){
		return true;
	  }
	else
	  {
		return false;
	  }
	}

	function showConfirmationModal() {
	    var adType = $('input[name="adtype"]:checked').val();
	   if($('input[name="adtype"]:checked').length == 0){
            $('#ad_type_error_div').html('<font color="#cc0000"> Please Select Ad type</font>');	
	   }else if(($('input[name="sub_category"]:checked').length == 0) && (adType != '5') && (adType != '6')){
	       $('#ad_subcat_error_div').html('<font color="#cc0000"> Please Select Sub Category</font>');
	   }else{
	       $('#confirmationModal').modal('show'); 
	   }
    }
    
    function submitForm() {
       // Append the input element to the "cat_form_div"
        var submitInput = '<input type="text" name="confirm">';
        $('#cat_form_div').append(submitInput);
        // Close the modal
        $('#confirmationModal').modal('hide');
        // Submit the form
        $('#ad_categorise').submit();
    }
    
      function sendToAdrepmodal(){
      $('#sendToAdrepConfirmationModal').modal('show'); 
    }
    
    function sendToAdrep() {
        $('#sendToAdrepConfirmationModal').modal('hide');
        $('#send_to_adrep_form').submit();
    }
	

</script>


<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/jquery.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/jquery-migrate.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/jquery.blockui.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/jquery.cokie.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/scripts/dropzone.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/scripts/metronic.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/scripts/layout.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/scripts/demo.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/scripts/table-advanced.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/components-pickers.js"></script> 
<script>
        
        var tableToExcel = (function() {
                
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, filename) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: filename || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>
<script>
	jQuery(document).ready(function() {       
	   Metronic.init(); // init metronic core components
	   Layout.init(); // init current layout
	   Demo.init(); // init demo features
	   TableAdvanced.init();
	   ComponentsPickers.init();
	});
</script>
<!-- Google tag (gtag.js) --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XT54GQXRZT"></script>
<script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); gtag('config', 'G-XT54GQXRZT'); 
</script>

</body>
</html>
