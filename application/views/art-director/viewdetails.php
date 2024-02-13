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

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});
	
	
	
</script>
  <div id="Middle-Div">
  <div style="padding-left: 30px; padding-top: 20px;">
   </div>
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
												<div style="padding-bottom: 20px;">
<div style="float: right;">
                         
                            </div></div>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                    
                            </div>
                            <div class="block-content collapse in">
						
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
										<thead>
											<tr>
											    <th>Order</th>
												<th>Attachments</th>
												<th>Source File</th>
												<th>PDF</th>
											</tr>
										</thead>
									<tbody>
											<tr class="odd gradeX">
											        <td> <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'art-director/home/live_ads_view_orders/'.$orderp;?>'" style="cursor:pointer; text-decoration: none;"><?php echo $orderp;  ?></a> </td>
												<td><?php 
																	if(isset($dir4))
																	{
																		
																		$this->load->helper('directory');

																		$map = directory_map($dir4.'/');
																		if($map){
																			foreach($map as $row)
																			{ ?>
																				<a href="<?php echo $dir4 ?>/<?php echo $row; ?>"  target="_Blank"><?php echo $row ?></a></br>
																		<?php 	}
																		}else{ echo "None"; }
																	} ?></td>
												<td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'art-director/home/live_ads_view_sourcefile/'.$orderp;?>'" style="cursor:pointer; text-decoration: none;"><button>Source File</button></a></td>
												<td></td>
											</tr>
										
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
                       
<?php
       $this->load->view("art-director/footer");
?>
