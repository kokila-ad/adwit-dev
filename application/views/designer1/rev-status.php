<?php
	$this->load->view("designer/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
	<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'designer/home/rev_status/';?>" + $('#help_desk').val() ;
        });
    });
</script>

<div id="Middle-Div">
<p style="text-align:center;">
        	Select Your Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('help_desk')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
</p>

<?php if(isset($form)):?>
<div class="row-fluid" style="width:96%; margin: 0 auto;">

<div style="padding-bottom: 20px;">							
<div style="float: left;">
 <form method="post">
	<input type="submit" name="date" value="<?php echo "$pystday"; ?>" /> 
	<input type="submit" name="date" value="<?php echo "$ystday"; ?>" /> 
	<input type="submit" name="date" value="<?php echo "$today"; ?>" /> 
 </form>
</div>							
</div>							
                               
						
                        <!-- block -->
                        <div class="block">
						
                            <div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Revision List - <?php if(isset($date)){ echo $date; }else{ echo $today;} ?></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th>Id</th>
												<th>Job Name</th>
												<th>Version</th>
												<th>CSR</th>
                                                <th>Slug</th>
												<th>Designer</th>
												<th>Checked</th>
											</tr>
										</thead>
										<tbody>
<?php foreach($rev_status as $row)	
		{
			$csr = $this->db->get_where('csr',array('id' => $row['csr']))->result_array();
			
			$designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
		?>									
											<tr class="odd gradeX">
												<td><?php echo $row['order_id']; ?></td>
												<td><?php echo "job name"; ?></td>
												<td><?php echo $row['version']; ?></td>
												<td class="center"> <?php echo $csr[0]['name']; ?></td>
												
                                                <td class="center">
													<?php if($row['slug']!='none'){ echo $row['slug']; }else{?>
												<form method="post">
												<input type="submit" name="Submit" value="Create Slug" onclick="return confirm('Are you sure ?');" />
												<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
												
												</form>
												<?php } ?>
												</td>
												
												<td class="center"><?php if($row['designer']=='0'){echo 'none';}else{echo $designer[0]['name'];} ?></td>
												<td>
												<?php if($row['designer']=='0'){ echo 'Pending'; }else{
												if($row['QA_check']!='pending'){$QA_csr = $this->db->get_where('csr',array('id' => $row['QA_check']))->result_array(); echo $QA_csr[0]['name']; } else{  ?>
												<form method="post">
												<select id="QA_check" name="QA_check">
													<option value="pending">Select</option>
													<?php
														foreach($rep as $csrep)
														{
															echo '<option value="'.$csrep['id'].'" >'.$csrep['name'].'</option>';	
														}
													?>
												</select>
												<input type="submit" name="select" value="Submit" onclick="return confirm('Are you sure ?');" />
												<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
												
												</form><?php } } ?>
												</td>
											</tr>
<?php }?>											
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
		<?php
	$this->load->view("designer/footer");
?>