<?php
	$this->load->view("client/header1");
?>

<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script> 

<div id="Middle-Div">
<div class="span12">
                                     <form class="form-horizontal"  method="post">
                                      <fieldset>
                                        <legend>Remarks/Remove</legend>
                                        <div class="control-group">
										<label class="control-label" for="focusedInput">Order No</label>
                                          <div class="controls">
                                            <input type="text" id="order_no" name="order_no"  value="<?php echo $orders['id'];?>" readonly />
                                          </div>
										  </div>
										  
										  <div class="control-group">
                                          <label class="control-label" for="focusedInput">Job No</label>
                                          <div class="controls">
                                            <input type="text" id="order_no" name="order_no"  value="<?php echo $orders['job_no'];?>" readonly />
                                          </div>
										 </div>
                                        <div class="control-group">
                                          <label class="control-label">Reson/Remarks</label>
                                          <div class="controls">
                                            <textarea name="reason"  style="width:270px;" required></textarea>
                                          </div>
                                        </div>
                                        <div style="padding-left: 180px;">
                                          <button name="remove" value="Remove" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove ?');">Remove</button>
                                         <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/myorders';?>'" style="cursor:pointer; text-decoration: none;"><button class="btn">Cancel</button></a>
                                        </div>
                                      </fieldset>
                                    </form>

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
	$this->load->view("client/footer");
?> 