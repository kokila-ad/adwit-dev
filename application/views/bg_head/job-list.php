<?php
	$this->load->view("bg_head/header");
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
                                <div class="muted pull-left">Job List (latest 3days job)</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th style="width:75px;">Date</th>
												<th>Order Id</th>
												<th>Job Name</th>
												<th>Width</th>
                                                <th>Height</th>
												<th>category</th>
											</tr>
										</thead>
										<tbody>
<?php foreach($cat_result as $row)	
		{?>									
											<tr class="odd gradeX">
												<td><?php echo $row['date']; ?></td>
												<td><?php echo $row['order_no']; ?></td>
												<td><?php echo $row['job_name']; ?></td>
												<td class="center"> <?php echo $row['width']; ?></td>
                                                <td class="center"> <?php echo $row['height']; ?></td>
												<td class="center"><?php echo $row['category']; ?></td>
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
	$this->load->view("bg_head/footer");
?>