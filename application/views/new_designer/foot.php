<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 <!--2016 © adwitads. All Rights Reserved. version 4.1-->
		 <?php $footer_copy = $this->db->query("SELECT * FROM `footer_copy`")->result_array(); 
		 echo $footer_copy[0]['footer_name'];  ?>
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->

<script>
	function sluf_confirm(){    
	var X=confirm('Are You Sure ?');	
	if(X==true)	  {    return true;  }else  {    return false;  }} 


function goBack() {   
    var back_tab = localStorage.getItem('go_back_tab');
    var display_type = localStorage.getItem('display_type');
    if (back_tab != "" && back_tab != null) {
        window.location.href = back_tab;
    } else {
        window.history.go(-1); // window.history.back(); 
    }
}


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
    var X=confirm('Before hitting "Submit", take a quick moment to ensure everything looks just right. Thanks!');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 

function warning_confirmation_btn(){
    $("#confirmationModal").modal("show");
}
function confirm_end_design(){
    var submitInput = '<input type="text" name="complete">';
    $('#end_design_form_div').append(submitInput);
    // Close the modal
    $('#confirmationModal').modal('hide');
    // Submit the form
    $('#end_design_form').submit();
}

function tl_warning_confirm(){
   $("#tlConfirmationModal").modal("show"); 
}

function tl_send_to_aq(){
    $('#tlConfirmationModal').modal('hide');
    // Submit the form
    $('#tl_send_to_qa_form').submit();
}

 function rev_warning_confirmation_btn(){
    $("#rev_confirmationModal").modal("show");
}
function rev_confirm_end_design(){
    $('#rev_confirmationModal').modal('hide');
    $('#rev_end_design_form').submit();
}

function showCreateSlugModal(order_id){
    $("#selected_order_id").val(order_id);
    $("#slugConfirmationModal").modal("show");
}
function confirmSlugModal(){
    var selected_order_id = $("#selected_order_id").val();
    $('#slugConfirmationModal').modal('hide');
    // Submit the form
    var form_id = "create_slug_form_" + selected_order_id;
    alert(form_id);
    $('#' + form_id).submit();
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


<!--<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jstree/dist/jstree.min.js"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/scripts/table-advanced.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/scripts/ui-tree.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/scripts/main.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/scripts/layout.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/scripts/ui-general.js" type="text/javascript"></script>
<script src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/scripts/components-pickers.js"></script>
<script type="text/javascript" src="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_designer/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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

<!-- Google tag (gtag.js) --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XT54GQXRZT"></script>
<script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); gtag('config', 'G-XT54GQXRZT'); 
</script>	

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

