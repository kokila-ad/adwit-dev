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

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});

</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'admin/home/web_bill_report/';?>" + $('#help_desk').val() ;
        });
    });
</script>

<div id="Middle-Div">


<div class="row-fluid" style="width: 96%; margin: 0 auto; ">
  <!--<p style="text-align:center;"> 
        	Select Your Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('publications')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
	</p>-->
  <div style=" float: right;">
	<form method="post" >
		<input type="text" name="order_id" id="order_id" placeholder="search order"  style="padding: 5px; outline:none;" required /> 
		<input type="submit" value="Search" name="search" />
	</form>
  </div>
</div>

<?php //if(isset($form)){ ?>
<div class="row-fluid" style="width: 96%; margin: 0 auto; ">
  <div style=" float: left;">
    <form method="post" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      <input type="submit" value="Submit" />
    </form>
  </div>
  <!--<div style=" float: right;">
	<form method="post" >
		<input type="text" name="order_id" id="order_id" placeholder="search order"  style="padding: 5px; outline:none;" required /> 
		<input type="submit" value="Search" name="search" />
	</form>
  </div>-->
</div>
  <div class="row-fluid" style="width:96%; margin: 0 auto;">  
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        
		<a id="dlink"  style="display:none;"></a>
		
		<div class="muted pull-left">BILL Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?></div>
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'name', 'tester.xls')" value="Export to Excel" /></div>
	  </div>
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            
			<thead>
            <tr>
				<th rowspan="2" style="vertical-align: middle;">Date</th>
                <th rowspan="2" style="vertical-align: middle;">Adwit Id</th>
				<th rowspan="2" style="vertical-align: middle;">Ad Type</th>
				<th rowspan="2" style="vertical-align: middle;">Job Name</th>
				<th rowspan="2" style="vertical-align: middle;">Adrep</th>
				<th rowspan="2" style="vertical-align: middle;">Advertiser</th>
				<th rowspan="2" style="vertical-align: middle;">Width</th>
				<th rowspan="2" style="vertical-align: middle;">Height</th>
				<th rowspan="2" style="vertical-align: middle;">Publication</th>
				<th rowspan="2" style="vertical-align: middle;">Group</th>
			</tr>
              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 	
		foreach($orders as $row)
		{	
			$tot_size = 0;
			$ad_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row['id']))->result_array();
			$adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
			$group = $this->db->get_where('Group',array('id' => $publication[0]['group_id']))->result_array();
			if($row['pixel_size'] != 'custom'){
				$pixel_size = $this->db->get_where('pixel_sizes',array('id' => $row['pixel_size']))->result_array();
				$width = $pixel_size[0]['width'];
				$height = $pixel_size[0]['height'];
			}else{
				$width = $row['custom_width'];
				$height = $row['custom_height'];
			}
			//$tot_size = $row['width'] * $row['height'];
?>
              <tr class="odd gradeX">
				<td><?php echo $row['created_on']; ?></td>
                <td><?php echo $row['id']; ?></td>
				<td><?php echo $ad_type[0]['name']; ?></td>
				<td><?php echo $row['job_no']; ?></td>
				<td><?php echo $adrep[0]['first_name']; ?></td>
				<td><?php echo $row['advertiser_name']; ?></td>
                <td><?php echo $width; ?></td>
                <td><?php echo $height; ?></td>
				<td><?php echo $publication[0]['name']; ?></td>
                <td><?php echo $group[0]['name']; ?></td>
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