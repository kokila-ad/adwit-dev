<?php
       $this->load->view("admin/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

  <div id="Middle-Div">
   <div class="row-fluid" style="width:96%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
							<div>
							<form method="post">
							From<input type="text" name="from_date" placeholder="YY-MM-DD"/> To<input type="text" name="to_date" placeholder="YY-MM-DD"/>
							<input type="submit" value="Submit" />
							</form>
							</div>
                                <div class="muted pull-left">Job List (From Sep 16 to 30)</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th>Designer</th>
												<th>Code</th>
												<th>Total NJ</th>
												<th>Average DP</th>
											</tr>
										</thead>
										<tbody>
<?php foreach($designer as $row)
	  {
		$id = $row['id'];
		if(isset($from) && isset($to))
		{
			$dp = 	$this->db->query("SELECT * FROM `cat_result` WHERE `designer`='$id' AND `ddate`>='$from' AND `ddate`<='$to' ;")->result_array();
		}else{
			$dp = 	$this->db->query("SELECT * FROM `cat_result` WHERE `designer`='$id' AND `ddate`>='2013-09-16' AND `ddate`<='2013-09-30' ;")->result_array();
		}	
			$nj = 0;
			foreach($dp as $row1)
			{
				$cat_wt = $this->db->get_where('print',array('name'=> $row1['category']))->result_array();
				//echo $row1['id']." - ".$row['name']." - ".$cat_wt[0]['wt']." - ".$row1['ddate']."<br/>";
				$nj = $nj + $cat_wt[0]['wt'];
			}
?>									
											<tr class="odd gradeX">
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $nj; ?></td>
												<td class="center"> <?php echo "tt"; ?></td>
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
       $this->load->view("admin/footer");
?>