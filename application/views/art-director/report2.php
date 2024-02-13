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
     <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
						<!--	<div class="form">
							<form method="post">
							From<input type="text" name="from_date" id="from_date" /> To<input type="text" name="to_date" id="to_date" />
							<input type="submit" value="Submit" />
							</form> 
							</div>	-->
                                <div class="muted pull-left">Daily Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $ystday;} ?> </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th>CSR Email-Id</th>
												<th>Name</th>
												<th>Total Jobs Categorised</th>
												<!--<th>No Of Jobs</th>-->
											</tr>
										</thead>
										<tbody>
<?php 

foreach($csr as $row)
{
	$id = $row['id'];
	$num_jobs = 0;
	if(isset($from) && isset($to))
	{
		//$dp = 	$this->db->query("SELECT * FROM `designer_dp` WHERE  `designer`='$id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
	}else{
			$cat = $this->db->get_where('cat_result',array('csr' => $id, 'date' => $ystday))->result_array();
	}
	
	if(!$cat)
	{
		$num_jobs = '0';
	}else
	{
		$num_jobs = count($cat);
	}
	?>									
											<tr class="odd gradeX">
												<td><?php echo $row['email_id']; ?></td>
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $num_jobs; ?></td>
											<!--	<td class="center"> <?php echo $num_jobs; ?></td>-->
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
                       
<?php
       $this->load->view("art-director/footer");
?>