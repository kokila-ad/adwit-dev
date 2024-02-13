<?php
       $this->load->view("client/header1");
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

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: -1, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: -1, dateFormat: 'yy-mm-dd'});
		
		
		
	});
	
	
	
</script>

  <div id="Middle-Div">
  <div style="padding-left: 30px; padding-top: 20px;">
		<form method="post" style="padding:0; margin:0;">
		<span>From &nbsp;</span><input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/> &nbsp;&nbsp;<span>To &nbsp;</span><input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
		<input type="submit" value="Submit" />
		</form>
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Revision Orders </div>
                            <div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
						</div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
                                            	<th>Adwit Ads ID</th>
												<th>Unique Job ID</th>
												<th>Version</th>
												<th>Status</th>
												<th>PDF</th>
												<?php if($publication['enable_source']=='1' && isset($sourcefilepath)){ ?><th>Native File</th><?php } ?>
											</tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php
	
	$order_status = $this->db->get_where('order_status',array('id'=>$order[0]['status']))->result_array();
	$pdf_path = $order[0]['pdf'];
	if(!file_exists($pdf_path)){
		$pdf_path = 'pdf_uploads/'.$order[0]['id'].'/'.$order[0]['pdf']; 
	}
	//note sent newad
	$note = $this->db->get_where('note_sent',array('order_id' => $order[0]['id'], 'revision_id' => '0'))->row_array();	
?>										
										<tr class="odd gradeX">
                                        		<td><?php echo $order[0]['id']; ?></td>
												<td><?php echo $order[0]['job_no']; ?></td>
												<td><?php echo 'V1'; ?></td>
												<td><?php echo $order_status[0]['name']; ?></td>
												<td><?php if($order[0]['pdf'] != 'none' && file_exists($pdf_path)){ ?>
															<a onclick="window.open('<?php echo base_url().$pdf_path;?>')" data-toggle="tooltip" title="<?php if(isset($note['id'])){ echo $note['note']; }else{ echo"PDF"; } ?>" data-placement="top" style="cursor:pointer; text-decoration: none;">
															<img src="images/pdf.png" alt="pdf"/>
															</a>
													<?php }else{ echo ''; }?>

												</td>
												<!--Source File Download -->
												<?php 
													if($publication['enable_source']=='1' && $order[0]['source_del']=='1' && isset($ftp_source_path) && !isset($last_orders_rev['id']))
													{ 	 //ftp source path
												?>
													<td>	
														<a href="<?php echo $ftp_source_path; ?>">
														<button class="btn green">Download</button>
														</a>
													</td>
												<?php }elseif($publication['enable_source']=='1' && isset($sourcefilepath)){ 
														$this->load->helper('directory');
														$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
														if($map2){
															foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
												?>
												<td>
													<form action="<?php echo base_url().'index.php/client/home/zip_folder_select'?>" method="post">
														<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
														<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
														<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
														<input name="download" value="download" readonly style="display:none;" />
														<button type="submit" name="SourceDownload" class="btn green">Download</button>
													</form>
												</td>
											<?php } }else{ echo '<td> </td>'; } ?>
										</tr>
<?php
	foreach($orders_rev as $row){
		$source_file_path='none';
		$rev_status = 'Revision Submitted';
		if($row['new_slug']!='none'){ $rev_status = 'In Production'; }
		if($row['pdf_path']!='none'){ 
			$rev_status = 'Proof Ready';
			$rev_path = $row['pdf_path'];
			if(!file_exists($pdf_path)){ $rev_path = $row['pdf_path'].'/'.$row['pdf_file']; }
		}
		if(isset($sourcefilepath) && $row['status']=='5' && $row['source_file']!='none'){
			$source_file_path = $sourcefilepath.'/'.$row['source_file'];
		}
		//note sent revision
		$note_rev = $this->db->get_where('note_sent',array('revision_id' => $row['id']))->row_array();
?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['order_id']; ?></td>
												<td><?php echo $order[0]['job_no']; ?></td>
												<td><?php echo $row['version']; ?></td>
												<td>
												<?php if($row['question']!='' && $row['answer']=='none'){ ?>
												<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/answer/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn tooltip-top" title="<?php echo $row['question']; ?>">Question</button></a> 
												<?php }else{ echo $rev_status; }?>
												</td>
												<td>
												<?php if($row['pdf_path']!='none' && file_exists($rev_path)){ ?>			
													<a onclick="window.open('<?php echo base_url().$rev_path; ?>')" data-toggle="tooltip" title="<?php if(isset($note_rev['id'])){ echo $note_rev['note']; }else{ echo"PDF"; } ?>" data-placement="top" style="cursor:pointer; text-decoration: none;">
														<img src="images/pdf.png" alt="pdf"/>
													</a>
												<?php  }else{ echo ''; } ?>
												</td>
												<!--Source File Download -->
												<?php  if($publication['enable_source']=='1' && $order[0]['source_del']=='1' && isset($ftp_source_path) && isset($last_orders_rev['id']) && $last_orders_rev['id']==$row['id'])
													  {  //ftp source path
												?>
													<td>	
														<a href="<?php echo $ftp_source_path; ?>">
														<button class="btn green">Download</button>
														</a>
													</td>
												<?php }elseif($publication['enable_source']=='1' && $row['source_file']!='none' && isset($source_file_path) && file_exists($source_file_path)){ ?>
												<td>
													<form action="<?php echo base_url().'index.php/client/home/zip_folder_select'?>" method="post">
														<input name="source_file" value="<?php echo $row['source_file'];?>" readonly style="display:none;" />
														<input name="pdf_file" value="<?php echo $row['pdf_file'];?>" readonly style="display:none;" />
														<input name="new_slug" value="<?php echo $row['new_slug'];?>" readonly style="display:none;" />
														<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
														<input name="download" value="download" readonly style="display:none;" />
														<button type="submit" name="SourceDownload" class="btn green">Download</button>
													</form>
												</td>
												<?php }else{ echo'<td></td>'; } ?>
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
		
		<script type="text/javascript">
		// Popup window code
		function newPopup(url) {
			popupWindow = window.open(
				url,'popUpWindow','height=700,width=1000,left=15,top=15,resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no')
		}
		</script>
                       
<?php
       $this->load->view("client/footer");
?>

