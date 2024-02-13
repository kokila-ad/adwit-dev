
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
<!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="ui_assetss/global/plugins/respond.min.js"></script>
<script src="ui_assetss/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script>
function goBack() {
    window.history.back();
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
    function check() {
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2").value;
        if (pass1 != pass2) {
            alert("Passwords Do not match");
			 return false;  }

    }
</script>	
<script>
function QA_confirm(){
    var X=confirm('Are You Sure ?');
	if(X==true)
  {
    return true;
  }
else
  {
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
<script>
function Make_confirm(){
    var X=confirm('Do you want to continue ?');
	if(X==true)
  {
    return true;
  }
else
  {
    return false;
  }
} 
</script>
<base href="<?php echo base_url();?>" />
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/icheck/icheck.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>ui_assetss/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>ui_assetss/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>ui_assetss/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>ui_assetss/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>ui_assetss/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();  ?>ui_assetss/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script type="text/javascript" src="ui_assetss/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php  echo base_url();  ?>ui_assetss/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/admin/pages/scripts/form-icheck.js"></script>
<script src="<?php  echo base_url();  ?>ui_assetss/admin/pages/scripts/table-advanced.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() { 
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   TableAdvanced.init();
});
</script>
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Demo.init(); // init demo(theme settings page)
   Index.init(); // init index page
   Tasks.initDashboardWidget(); // init tash dashboard widget
});
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
