<?php
	$this->load->view("team-lead/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'team-lead/home/job_table/';?>" + $('#help_desk').val() ;
        });
    });
</script>
 <script language="javascript" type="text/javascript">
var scrt_var =1024; 
</script>
<div id="Middle-Div">
<div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                                                                            <div class="navbar navbar-inner block-header">
                                <a href="http://localhost/weborders/index.php/team-lead/home/pending_list">Pending Lists</a> 
								
								<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
                            </div>
                           
                            <div class="block-content collapse in">
							
							<div style="float:right;">
							Filter:&nbsp;
								<select id="help_desk" name="help_desk">
								<option value="">All</option>
								
								<?php
			$types = $this->db->get_where('publications',array('team_lead_id'=>$this->session->userdata('tId')))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
								</select>
								</div>
								
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th style="width:75px;">Date</th>
												<th>Order Id</th>
												<th>Job Name</th>
												<th>Width</th>
                                                <th>Height</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										
										<tbody name="testTable" id="testTable">
<?php foreach($list as $row)	
		{?>									
											<tr class="odd gradeX">
												<td><?php echo $row['date']; ?></td>
												<td><?php echo $row['order_no']; ?></td>
												<td><?php echo $row['job_name']; ?></td>
												<td class="center"> <?php echo $row['width']; ?></td>
                                                <td class="center"> <?php echo $row['height']; ?></td>
												<td><?php  echo"Pending"; ?></td>
												<td></td>
											</tr>
<?php }?>											
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
	$this->load->view("team-lead/footer");
?>