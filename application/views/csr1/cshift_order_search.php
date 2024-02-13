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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php /*if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/Chicago');
				}*/
				$current_time = date("H:i:s"); 
		?>
    }
</script>
<script type="text/javascript">

function flip(id)
{
 if($("#priority-"+id+"").is(':checked') )
   $("#notes-"+id+"").show();
 else
    $("#notes-"+id+"").hide();
	
} 

</script>

<div id="Middle-Div">

  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
  <div style="padding-bottom: 20px;">
  <div style="float: right;">
		<form name="form" method="post" action="<?php echo base_url().index_page().'csr/home/cshift_order_search'; ?>">
			<p class="contact">Search History
				<input name="id" type="text" autocomplete="off" required/>
				<input type="submit" name="search" /></p>
		</form>
		<!--<a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img title="Refresh" src="images/refresh_trackingsheet.png"/></a>-->
  </div>
  
   </div>
   
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Cshift Tracker</div>
		
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
				<th style="vertical-align: middle;">Date</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>											
                <th style="text-align: center;">Category</th>
                <th style="text-align: center;">Design</th>
                <th style="text-align: center;">QA</th>
                <th style="text-align: center;">Upload</th>
				<th style="vertical-align: middle;">Actions</th>
              </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
	
		$i=1;
		foreach($orders as $row1)
		{	
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			if($cat_result){ 
				$form = $cat_result[0]['help_desk'];
				$cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
			}else{ $form = $row1['help_desk']; }
			$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
						
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>
<!-- order_no --> 		<td><?php echo $row1['id']; ?></td>
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- newspaper -->		<td><?php echo $publication[0]['name']; ?></td>
<!-- category -->		<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ 
								echo'<td></td>';
							}elseif($cat_result){  
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'</td>';
							}else{?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_category_v2/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >category</button></a></td>
						 <?php } ?>
<!-- design -->         <?php if($cat_result && $cat_result[0]['slug']!='none'){ 
								echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>";
							}else{ echo"<td>Pending</td>"; } ?>
				           
<!-- QA -->             <?php if($job_status){ echo "<td title='".$job_status[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }
							elseif($cat_result && $cat_result[0]['slug']!='none'){
							?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_cp_tool/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >QA</button></a></td>     
						<?php	}else{ echo "<td>Pending</td>"; } ?>
			 
<!-- upload -->		 <td>
						<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{  ?>
								<a href="<?php echo base_url().index_page().'csr/home/pdf_upload/'.$row1['id'].'/'.$job_status[0]['id'];?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'csr/home/pdf_upload/'.$row1['id'].'/'.$job_status[0]['id'];?>','1432728298066','width=800,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;"><button class="btn btn-success btn-mini">Upload</button></a>
							
						<?php } } ?>
					</td>
					
                <!--<td><?php if($job_status && $upload_csr){echo $upload_csr[0]['name'];}else{echo "None";} ?></td>-->
				
<!--action:cancel -->	<?php if($job_status && $job_status[0]['upload_csr']!='0'){
							if($cat_result[0]['pdf_path']!='none')
							{ $pdf_path = 'http://www.adwitads.com/weborders/'.$cat_result[0]['pdf_path']; 
				?>
								<td><a href="<?php echo $pdf_path;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="images/pdf.png" alt="pdf"/></a></td>
				<?php
							}else{ echo "<td>Uploaded</td>";} 
						}elseif(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0')
						{ 
							echo"<td>Cancelled</td>"; 
						}elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none')
						{ 
							echo'<td>Question Sent</td>';
						}elseif($cat_result){ 
				?>
				<td>
				<div class="btn-group">
					<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/QC/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Question</button></a>
					<button data-toggle="dropdown" class="btn btn-danger btn-mini dropdown-toggle"><span class="caret"></span></button>
					<!--<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/ordercshift_cancel/'.$form.'/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Cancel</button></a>
					<button data-toggle="dropdown" class="btn btn-danger btn-mini dropdown-toggle"><span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="javascript:;" onclick="#" >Question</a></li>
						<li><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/cshift_question/'.$cat_result[0]['id'];?>'" >Question</a></li>
					</ul>-->
				</div>
				</td>
				<?php }else{ echo"<td></td>"; } ?>
			  </tr>
   <?php $i++; }  ?>
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