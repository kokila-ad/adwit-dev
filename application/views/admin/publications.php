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
<link rel="stylesheet" type="text/css" href="pagination/datatables.min.css"/> 
  <script type="text/javascript" src="pagination/datatables.min.js"></script>
  <script type="text/javascript" charset="utf-8">
   $(document).ready(function() {
    $('#paginate').DataTable();
   } );
  </script>		

<div id="Middle-Div">


  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
	<h5 style="color:red;"> <?php echo $this->session->flashdata('message'); ?> </h5>
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        
		<a id="dlink"  style="display:none;"></a>
		
		<div class="muted pull-left">Publications</div>
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'name', 'tester.xls')" value="Export to Excel" /></div>
	  </div>
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="paginate">
            
			<thead>
            <tr>
				<th style="vertical-align: middle;">Publication Name</th>
                <th  style="vertical-align: middle;">Group Name</th>
				<th  style="vertical-align: middle;">Channel Name</th>
				<th  style="vertical-align: middle;">Assign</th>
			</tr>
              
            </thead>
            <tbody name="testTable" id="testTable">
<?php foreach($publications as $row){ 
		$group_name = $this->db->get_where('Group',array('id'=>$row['group_id']))->result_array();
		$channel_name = $this->db->get_where('channels',array('id'=>$row['channel']))->result_array();
?>
              <tr class="odd gradeX">
				<td><?php echo $row['name']; ?></td>
                <td><?php if($group_name){echo $group_name[0]['name'];}else{echo 'none';} ?></td>
                <td><?php if($channel_name){echo $channel_name[0]['name'];}else{echo 'none';} ?></td>
				<td>
				<a href="<?php echo base_url().'index.php/admin/home/publications/'.$row['id']; ?>"><button>Assign</button> </a>
				</td>
			  </tr>
 <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
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
        <script>
		var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()
</script>	
<?php
       $this->load->view("admin/footer");
?>