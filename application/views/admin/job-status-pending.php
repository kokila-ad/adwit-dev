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

<script type="text/javascript">	//all pending
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'admin/home/job_status/';?>" + $('#display_type').val() ;
        });
    });
</script>
<!--<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-3D", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-3D", maxDate: 0, dateFormat: 'yy-mm-dd'});
				
	});
</script>-->

<div id="Middle-Div">
  <div style="padding-left: 30px; padding-top: 20px;">
  
  <!--  <form method="post" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      <input type="submit" value="Submit" />
    </form>-->
  <div style="padding-bottom: 20px;">
  <div style="float: right;">
		<select id="display_type" name="display_type" style="width:80px; height:20px;" >
			<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
			<option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
			<option value="sent" <?php echo ($display_type=='sent' ? 'selected="selected"' : ''); ?> >Sent</option>
		</select>
  </div>
   </div>
  </div>
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Cshift Tracker : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $ystday."  to  ".$today ;} ?></div>
		<!--<div style="float: right;">
		<form name="form" method="post">
			<input type="submit" name="pday" value="Previousday" />
			<input type="submit" name="yday" value="Yesterday" />
			<input type="submit" name="today" value="Today" />
		</form>
		</div>-->
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle;">Adwit Id</th>
				<th rowspan="2" style="vertical-align: middle;">Job Name</th>
				<th rowspan="2" style="vertical-align: middle;">Publication</th>
				<th rowspan="2" style="vertical-align: middle;">Date</th>
								
                <th rowspan="2" style="text-align: center;">Category</th>
                <th rowspan="2" style="text-align: center;">Design</th>
                <th rowspan="2" style="text-align: center;">QA</th>
                <th rowspan="2" style="text-align: center;">Upload</th>
				<th rowspan="2" style="vertical-align: middle;">Cancel</th>
              </tr>
              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
		$i=1;
		foreach($cat_id as $row1)
		{	
			$orders = $this->db->get_where('orders',array('id' => $row1['order_no']))->result_array();
			$cat_csr = $this->db->get_where('csr',array('id' => $row1['csr']))->result_array();
			$cat_designer = $this->db->get_where('designers',array('id' => $row1['designer']))->result_array();
			$job_status = $this->db->get_where('cp_tool',array('order_no' => $row1['order_no']))->result_array();
			$cat_news = $this->db->get_where('cat_newspaper',array('id' => $row1['news_id']))->result_array();
			
			if($job_status)
			{
				$cp_csr = $this->db->get_where('csr',array('id' => $job_status[0]['csr']))->result_array();
				$upload_csr = $this->db->get_where('csr',array('id' => $job_status[0]['upload_csr']))->result_array();
			}
			
			if((!$job_status || $job_status[0]['upload_csr']=='0')){ 
?>
              <tr class="odd gradeX">
<!-- order_no --> 		<td><?php echo $row1['order_no']; ?></td>
<!-- job_name -->		<td><?php echo $row1['job_name']; ?></td>
<!-- newspaper -->		<td><?php echo $cat_news[0]['name']; ?></td>
<!-- date -->			<td><?php echo $row1['date']; ?></td>
				
<!-- category -->       <td title="<?php echo $cat_csr[0]['name']; ?>" style="cursor:pointer;" ><?php echo $row1['category']; ?></td>
               
<!-- design -->         <?php if($row1['slug']=='none'){ echo "<td>Pending</td>"; }else{ echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>"; } ?>
				                
<!-- QA -->             <?php if($job_status){ echo "<td title='".$cp_csr[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }else{ echo "<td>Pending</td>"; } ?>
			
<!-- upload -->		 <td>
						<?php if(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{ echo''; } } ?>
					</td>
                <!--<td><?php if($job_status && $upload_csr){echo $upload_csr[0]['name'];}else{echo "None";} ?></td>-->
<!--cancel -->	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($row1['pdf_path']!='none')
							{ $pdf_path = 'http://www.adwitads.com/weborders/'.$row1['pdf_path']; 
				?>
								<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a></td>
				<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($orders && $orders[0]['cancel']!='0') || $row1['cancel']!='0')
						{ echo"<td>Cancelled</td>"; }else{ 
				?>
				<td></td>
                <?php } ?>
			  </tr>
   <?php } } ?>
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