
<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("art-director/header");
	
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
<?php 
	if(isset($designers)){ 	
	
		foreach($designers as $row)	
		{
			$designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
			$location = $this->db->get_where('location',array('id' => $designer[0]['Join_location']))->result_array();
?>									
											<tr class="odd gradeX">
												<td><?php echo $row['date']; ?></td>
												<td><?php echo $designer[0]['name']; ?></td>
												<td><?php echo $designer[0]['username']; ?></td>
												<td class="center"> <?php echo $location[0]['name']; ?></td>
                                                <td class="center">
												<?php if($row['status']=='pending'){ ?>
													<form name="form" method="post">
														<input type="text" name="id" value="<?php echo $row['id']; ?>" readonly style="display:none" />
														<input type="text" name="did" value="<?php echo $row['designer']; ?>" readonly style="display:none" />
														<input type="text" name="hours" value="<?php echo $row['hours']; ?>" readonly style="display:none" />
														<input type="submit" name="submit" id="submit" value="Pending" />
													</form>
												<?php }else{ echo $row['status']; } ?>
												</td>
												<td class="center"><?php echo $row['hours']; ?></td>
											</tr>
<?php } }?>											
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