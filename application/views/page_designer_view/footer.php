<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 <!--2016 © adwitads. All Rights Reserved. version 4.1-->
		 2017 © adwitads. All Rights Reserved. version 4.8.12	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
</div>
<!-- END FOOTER -->
<script>
	function sluf_confirm(){    
	var X=confirm('Are You Sure ?');	
	if(X==true)	  {    return true;  }else  {    return false;  }} 

	function goBack() {    window.history.back();}

	function myFunction() {
		location.reload();
	}
</script>
<script type="text/javascript">
  function myFunction() {
        var checkbox= document.querySelector('input[name="assign[]"]:checked');
		var checkbox1= document.querySelector('input[name="assign_designer[]"]:checked');
  if(!checkbox && !checkbox1) {
    alert('Please select!');
    return false;
  }

}
</script>
<script>
function warning_confirm(){
    var X=confirm('Warning!!! Your performance will be based on the quality of this ad, please double check.');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 
</script>
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


<!--<script src="assets/designer/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/designer/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/jstree/dist/jstree.min.js"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/table-advanced.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/ui-tree.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/main.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/ui-general.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/designer/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/designer/scripts/bootstrap-fileinput.js"></script>
<script>
        jQuery(document).ready(function() {       
           Metronic.init();
           Layout.init();
           Demo.init();
           UITree.init();
		   TableAdvanced.init();
		   ComponentsPickers.init();
        });
</script>
	

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

