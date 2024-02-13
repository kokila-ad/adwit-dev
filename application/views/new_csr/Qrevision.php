<?php
       $this->load->view("csr/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">

<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="http://www.formmail-maker.com/var/demo/jquery-popup-form/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://www.formmail-maker.com/var/demo/jquery-popup-form/jquery.colorbox-min.js"></script>

<div id="Middle-Div">
 
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Qrevision  <?php if(isset($from) && isset($to)){echo $from." to ".$to;} ?></div>
		<div style="float: right;">
		<form name="form" method="post">
			<input type="submit" name="all" value="All" />
			<input type="submit" name="pday" value="Previousday" />
			<input type="submit" name="yday" value="Yesterday" />
			<input type="submit" name="today" value="Today" />
		</form>
		</div>
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
			
				<th rowspan="2" style="vertical-align: middle;">Slug</th>
				<th rowspan="2" style="vertical-align: middle;">Version</th>
				<th rowspan="2" style="vertical-align: middle;">Pdf</th>
			   
           </tr>
            </thead>
            <tbody name="testTable" id="testTable">
 <?php foreach($rev_orders as $row){ ?>    
              <tr class="odd gradeX">
               
				<td><?php echo $row['job_slug']; ?></td>
				<td><?php echo $row['version']; ?></td> 
<?php if($row['csr_upload']!='0'){ echo '<td> uploaded </td>'; }else{ ?>				
				<td>
					<form method="post" enctype="multipart/form-data">
						<input type="file" name="pdf" id="pdf" value="upload PDF" accept="application/pdf" />
						<input type="submit" name="Submit" value="Submit" onclick="return confirm('Are you sure you want to Upload ?');" />
						<input name="order_id" value="<?php echo $row['order_no'];?>" readonly style="display:none;" />
						<input name="job_slug" value="<?php echo $row['job_slug'];?>" readonly style="display:none;" />
						<input name="version" value="<?php echo $row['version'];?>" readonly style="display:none;" />
						<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
					</form>
				</td>
<?php } ?>				
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
       $this->load->view("csr/footer");
?>