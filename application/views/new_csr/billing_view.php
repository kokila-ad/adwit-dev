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

<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-1Y", maxDate: 0, dateFormat: 'yy-mm-dd'});
	
	});

</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/billing_view/';?>" + $('#help_desk').val() ;
        });
    });
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'csr/home/billing_view/';?>" + "<?php echo $form.'/'; ?>" + $('#display_type').val() ;
        });
    });
</script>

<div id="Middle-Div">

<p style="text-align:center;"> 
        	Select Your Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('clients')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
</p>
<?php if(isset($form)):?>
 <div style="padding-left: 30px; padding-top: 20px;">
    <form method="post" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      <input type="submit" value="Submit" />
    </form>
	 <div style="float: right;">
		<select id="display_type" name="display_type" style="width:80px; height:20px;" >
            <option value="approved" <?php echo ($display_type=='approved' ? 'selected="selected"' : ''); ?> >Approved</option>
        	<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
			<option value="cancelled" <?php echo ($display_type=='cancelled' ? 'selected="selected"' : ''); ?> >Cancelled</option>
        </select>
	</div>
  </div> 
  
  <div class="row-fluid" style="width:96%; margin: 0 auto;">  
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        
		<a id="dlink"  style="display:none;"></a>
		
		<div class="muted pull-left">BILL Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $pystday." - ".$today;} ?></div>
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'name', 'tester.xls')" value="Export to Excel" /></div>
	  </div>
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            
			<thead>
            <tr>
				
                <th rowspan="2" style="vertical-align: middle;">Order Id</th>
				<th rowspan="2" style="vertical-align: middle;">Publication</th>
				<th rowspan="2" style="vertical-align: middle;">Adrep</th>
				<th rowspan="2" style="vertical-align: middle;">Advertiser</th>
				<th rowspan="2" style="vertical-align: middle;">Date</th>
				<th rowspan="2" style="vertical-align: middle;">Height</th>
				<th rowspan="2" style="vertical-align: middle;">Width</th>
				<th rowspan="2" style="vertical-align: middle;">Size</th>
				
			</tr>
              
            </thead>
            <tbody name="testTable" id="testTable">
              <?php 
		$newspaper = $this->db->get_where('cat_newspaper',array('client' => $form))->result_array();
	foreach($newspaper as $row)
	{
			$newspaper_id = $row['id'];
			//echo "newspaper_id : ".$row['name'];
		 if(isset($from) && isset($to))
			{
				if($display_type == 'approved'){ $cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$newspaper_id' AND `billing_status`='1' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array(); }
				elseif($display_type == 'cancelled'){ $cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$newspaper_id' AND `billing_status`='2' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array(); }
				else { $cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$newspaper_id' AND `billing_status`='0' AND (`date` BETWEEN '$from' AND '$to') ;")->result_array(); }
				
			}else{
				//$cat_id = $this->db->get_where('cat_result',array('news_id' => $newspaper_id, 'date' => $today))->result_array();
				if($display_type == 'approved'){ $cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$newspaper_id' AND `billing_status`='1' AND (`date` BETWEEN '$pystday' AND '$today') ;")->result_array(); }
				elseif($display_type == 'cancelled'){ $cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$newspaper_id' AND `billing_status`='2' AND (`date` BETWEEN '$pystday' AND '$today') ;")->result_array(); }
				else { $cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$newspaper_id' AND `billing_status`='0' AND (`date` BETWEEN '$pystday' AND '$today') ;")->result_array(); }
			} 
		
		
		foreach($cat_id as $row1)
		{	
			$tot_size = 0;
			$adrep = $this->db->get_where('other_adreps',array('id' => $row1['adrep']))->result_array();
			$newsp = $this->db->get_where('cat_newspaper',array('id' => $row1['news_id']))->result_array();
			$tot_size = $row1['width'] * $row1['height'];
?>
              <tr class="odd gradeX">
				
				
                <td><?php echo $row1['order_no']; ?></td>
				<td><?php echo $newsp[0]['name']; ?></td>
				<td>
				<?php 
				if($adrep){ echo $adrep[0]['name']; }else{ echo $row1['adrep']; } 
				?>
				</td>
				<td><?php echo $row1['advertiser']; ?></td>
				<td><?php echo date('m-d-Y', strtotime($row1['date'])); ?></td>
				<td><?php echo $row1['height']; ?></td>
                <td><?php echo $row1['width']; ?></td>
				<td><?php echo round($tot_size,2); ?></td>
               <!-- <td>
				
					<form method="post">
						<input name="id" value="<?php echo $row1['id']; ?>" readonly style="display:none;" />
						<?php if(isset($from) && isset($to)){ echo '<input name="from_date" value="'.$from.'" readonly style="display:none;" />'; echo '<input name="to_date" value="'.$to.'" readonly style="display:none;" />';	}?>
						<select name="status" id="status" onchange="this.form.submit()">
							<option value="0">Pending</option>
							<option value="1" <?php if($row1['billing_status']=='1')echo"selected"; ?> >Approved</option>
							<option value="2" <?php if($row1['billing_status']=='2')echo"selected"; ?> >Cancelled</option>
						</select>
						
					</form> 
				</td>-->
              </tr>
 <?php } }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
 <?php  endif;?>
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
       $this->load->view("csr/footer");
?>