<?php
	$this->load->view("csr/header");
?>
<script type="text/javascript">
function closeWin()
{
	myWindow.close();
}
</script>
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
                                          <label class="control-label" for="focusedInput">Job No</label>
                                          <div class="controls">
                                            <input type="text" id="order_no" name="order_no"  value="<?php echo $rev_sold['order_no'];?>" readonly />
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label">Reson/Remarks</label>
                                          <div class="controls">
                                            <textarea name="reason"  value="<?php echo $rev_sold['reason'];?>" style="width:270px;" required></textarea>
                                          </div>
                                        </div>
                                        <div style="padding-left: 180px;">
                                        <!--<button type="submit" name="Submit" value="Submit" class="btn btn-primary">Save changes</button>-->
                                          <button name="remove" value="Remove" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove ?');">Remove</button>
                                          <button onclick="javascript:if(confirm('Close window?'))window.close()" type="reset" class="btn">Close</button>
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
	$this->load->view("csr/footer");
?> 