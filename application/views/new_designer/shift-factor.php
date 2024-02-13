
<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("designer/header");
	
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
                                <div class="muted pull-left">Designers Shift Status</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th style="width:75px;">Date</th>
												<th>Name</th>
												<th>Code</th>
												<th>Location</th>
                                                <th>Status</th>
												<th>Hours</th>
											</tr>
										</thead>
										<tbody>
<?php $last_status = '0' ;
	if(isset($designers)){ 	
	
		foreach($designers as $row)	
		{
?>									
											<tr class="odd gradeX">
												<td><?php echo $row['date']; ?></td>
												<td><?php echo $dname['name']; ?></td>
												<td><?php echo $dname['username']; ?></td>
												<td class="center"> <?php echo $dlocation['name']; ?></td>
                                                <td class="center">
												<?php if($row['status']=='pending'){ 
													echo "request pending";
												 }else{ echo $row['status']; } ?>
												</td>
												<td class="center"><?php echo $row['hours']; ?></td>
											</tr>
											
<?php $last_status = $row['status']; } }?>	
<?php 
	
	if($last_status != 'pending')
	{
 ?>
											<tr class="odd gradeX">
												<td><?php echo date('Y-m-d'); ?></td>
												<td><?php echo $dname['name']; ?></td>
												<td><?php echo $dname['username']; ?></td>
												<td class="center"> <?php echo $dlocation['name']; ?></td>
                                                <td class="center">
									<form name="form" method="post" enctype="multipart/form-data">
									<label>Select your Shift</label>
									<select name="shift_factor" id="shift_factor" >
										<option value="3">  3</option>
									</select>
									<input type="submit" name="submit" id="submit" value="submit" />
									</form>
												</td>
												<td class="center"><?php echo 'hours'; ?></td>
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
<?php
	$this->load->view("designer/footer");
	
?>
