<?php $this->load->view("management/head"); ?>
<script type="text/javascript">
	$(document).ready(function($) {    
   		$( "#from_date" ).datepicker({ minDate: "-9M", maxDate: 0, dateFormat: 'yy-mm-dd' });	
		$( "#to_date" ).datepicker({ minDate: "-9M", maxDate: 0, dateFormat: 'yy-mm-dd'});	
	});	
	
</script>

 <div class="page-container">
	<div class="page-content">
		<div class="container">
		
			<div class="row margin-top-15">
				<div class="col-sm-12">
					<div class="portlet light">
					    <div class="portlet-title">
							<div class="row static-info">
							<form method="post">
								<div class="col-md-7 value margin-top-10">CSR Performance :  <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $today;} ?></div>
								<div class="col-md-4 no-space">
									<div class="input-group input-large date-picker input-daterange pull-right" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" id="from_date" placeholder="YYYY-MM-DD" name="from_date">
												<span class="input-group-addon">to</span>
												<input type="text" class="form-control" id="to_date" placeholder="YYYY-MM-DD" name="to_date">
									</div>
								</div>
								<div class="col-md-1 text-right">
									<button type="submit" name="submit" class="btn btn-primary btn-md btn-block">Submit</button>
								</form>
								</div>
							</div>
						</div>
								
								  <div class="portlet-body">
  									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
											<tr>
												<th rowspan="2" style="vertical-align: middle;">CSR</th>
											
												<th colspan="7" style=" text-align: center;">Catergory(QA)</th>
												<th colspan="1" style=" text-align: center;">Total</th>
                                               
                                            </tr>
                                            <tr>
												<th>A</th>
												<th>B</th>
                                                <th>C</th>
												<th>D</th>
                                                <th>E</th>
												<th>F</th>
												<th>G</th>
                                                <th style=" text-align: center;">QA</th>
                                                
                                            </tr>
										</thead>
										<tbody name="testTable" id="testTable">
<?php

foreach($csr as $row)
{	
	
	$cp_job_count = 0;
	$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0;
	
			$csr_id = $row['id'];
			if(isset($from) && isset($to))
			{
				$cp = $this->db->query("SELECT * FROM `cat_result` WHERE  `csr_QA`='$csr_id' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
			}else{
				$cp = $this->db->get_where('cat_result',array('csr_QA' => $csr_id, 'date' => $today))->result_array();
			}
			$cp_job_count = count($cp);
			foreach($cp as $row2)
			{
				$cat = $this->db->get_where('cat_result',array('order_no' => $row2['order_no']))->result_array();
				if($cat){
					if($cat[0]['category'] == 'A')
					{
						$cat_a++;
					}
					if($cat[0]['category'] == 'B')
					{
						$cat_b++;
					}
					if($cat[0]['category'] == 'C' || $cat[0]['category'] == 'c')
					{
						$cat_c++;
					}
					if($cat[0]['category'] == 'D')
					{
						$cat_d++;
					}
					if($cat[0]['category'] == 'E')
					{
						$cat_e++;
					}
					if($cat[0]['category'] == 'F')
					{
						$cat_f++;
					}
					if($cat[0]['category'] == 'G')
					{
						$cat_g++;
					}
				}
			}
			
	
	?>    									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												
												<td><?php echo $cat_a; ?></td>
												<td><?php echo $cat_b; ?></td>
												<td><?php echo $cat_c; ?></td>
												<td><?php echo $cat_d; ?></td>
												<td><?php echo $cat_e; ?></td>
												<td><?php echo $cat_f; ?></td>
												<td><?php echo $cat_g; ?></td>
												<td><?php echo $cp_job_count; ?></td>
												
											</tr>
										  <?php }?>											
										</tbody>
									</table>
                                </div>
                            </div>
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
		
                       
<?php $this->load->view("management/foot"); ?>










