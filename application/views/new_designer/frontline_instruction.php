<?php
	$this->load->view("designer/header");
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
                                     <fieldset>
                                        <legend>Instruction/Attachment</legend>
                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Order No : <b><?php echo $rev_sold['order_id'];?></b></label>
       
										 </div>
										 <div class="control-group">
                                          <label class="control-label" for="focusedInput">Previsions Slug: <b><?php echo $rev_sold['order_no'];?></b>  </label>

                                        </div>
                                        <div class="control-group">
                                          <label class="control-label">Instruction : <b><?php echo $rev_sold['note'];?></b> </label>
                                        </div>
										<div class="control-group">
                                          <label class="control-label">Attachment</label>
                                          <div class="controls">
											<?php 
												if($rev_sold['file_path']=='none'){
													echo "<b>No Attachments</b>";
												}else{
													$this->load->helper('directory');
													$map = directory_map($rev_sold['file_path'].'/');
													if($map){ foreach($map as $row){
											?>
	<a href="<?php echo $rev_sold['file_path'].'/'.$row;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><?php echo $row; ?></a>
										  <?php } } } ?>
										 </div>
                                        </div>
                                        <div style="padding-left: 180px;">
                                        <button onclick="javascript:window.close()" type="reset" class="btn">Close</button>
                                        </div>
                                     </fieldset>
                                   
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