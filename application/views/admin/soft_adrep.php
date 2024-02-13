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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<div id="Middle-Div">
<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?>
		
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
  <div style="padding-bottom: 20px;">
	<div style="float: left;">
		<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'admin/home/add_soft_adrep';?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Add Adrep</button></a>
	</div>
  </div>
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Softwrite Adreps</div>
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
				<th style="vertical-align: middle;">ID</th>
				<th style="vertical-align: middle;">Name</th>
                <th style="vertical-align: middle;">Adwit Adrep</th>
				<th style="vertical-align: middle;">Publication</th>
            </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
	foreach($adrep as $row)
	{
				
?>
            <tr >
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['sname']; ?></td>
				<td><?php echo $row['aname']; ?></td>
				<td><?php echo $row['publication']; ?></td>
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
		var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,'
					, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
					, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
					, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		return function(table, name) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
		window.location.href = uri + base64(format(template, ctx))
		}
		})()
        </script>

                                  
<?php
       $this->load->view("admin/footer");
?>