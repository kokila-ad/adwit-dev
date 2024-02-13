
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
	function goBack(){ window.history.back(); }
	function closeWin(){ myWindow.close(); }
	function Adp_confirm(){
		var X=confirm('Warning!!! Your performance will be based on the quality of this ad, please double check.');
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
</script>


<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/jquery.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/jquery-migrate.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/jquery.blockui.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/jquery.cokie.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/scripts/dropzone.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/scripts/metronic.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/scripts/layout.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/scripts/demo.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/scripts/table-advanced.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://www.adwit.in/adwitadsassets/new_csr/plugins/components-pickers.js"></script> 
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
</body>
</html>
