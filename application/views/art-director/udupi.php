<?php
       $this->load->view("art-director/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});

</script>

<div id="Middle-Div">

  <div style="padding-left: 30px; padding-top: 20px;">
    <form method="post" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      <input type="submit" value="Submit" />
    </form>
  </div>
  <div class="row-fluid" style="width:96%; margin: 0 auto;">  
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        
		<a id="dlink"  style="display:none;"></a>
		
		<div class="muted pull-left">BILL Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?></div>
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'name', 'tester.xls')" value="Export to Excel" /></div>
	  </div>
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            
			<thead>
            <tr>
				<th rowspan="2" style="vertical-align: middle;">Designer</th>
                
				<th rowspan="2" style="vertical-align: middle;">Job Name</th>
				<th rowspan="2" style="vertical-align: middle;">Location</th>
				<th rowspan="2" style="vertical-align: middle;">NJ</th>
				<th rowspan="2" style="vertical-align: middle;">Date</th>
				<th rowspan="2" style="vertical-align: middle;">Time</th>
			</tr>
              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
			if(isset($from) && isset($to))
			{
				$cat_result = 	$this->db->query("SELECT * FROM `archive_catresult` WHERE  `dlocation`='4' AND `ddate` BETWEEN '$from' AND '$to' ORDER BY `ddate` ;")->result_array();
				
			}else{
				$cat_result = $this->db->get_where('archive_catresult',array('dlocation' => '4', 'ddate' => $today))->result_array();
				
			}
foreach($cat_result as $row)
{
	$pub_nj = 0;
	
		$category = $this->db->get_where('print',array('name' => $row['category']))->result_array();
		$pub_nj = $pub_nj + $category[0]['wt'];
			
	$designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
	$dloc = $this->db->get_where('location',array('id' => $row['dlocation']))->result_array();
?>
              <tr class="odd gradeX">
				
                <td><?php echo $designer[0]['name']; ?></td>
				<td><?php echo $row['job_name']; ?></td>
				<td><?php echo $dloc[0]['name']; ?></td>
				<td><?php echo $pub_nj; ?></td>
                <td><?php echo $row['ddate']; ?></td>
				<td><?php echo $row['start_time']; ?></td>
				
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
       $this->load->view("art-director/footer");
?>