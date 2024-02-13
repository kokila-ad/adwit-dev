       <footer class="footer">
                <div class="footer-copyright ">
                    <div class="container">
					 <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                            <p class="margin-0"><a href="#" title=""></a></p>
                        </div>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <p class="footer-version margin-0">
							 <?php 
								$footer = $this->db->get_where('footer_copy', array('id'=>'1'))->row_array();
								if(isset($footer['id'])){ echo $footer['footer_name']; } 
							 ?>
							 </p>
                        </div>
                    </div>
				   </div>
                </div><!-- /.footer-copyright -->          
        </footer><!-- /footer -->

        </div><!-- /#wrapper -->
<base href="<?php echo base_url();?>" />
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/dropzone.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datatables.min.js"></script>	  
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/awe-hosoren.js"></script>	
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/jquery-ui.min.js"></script>	
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/plugins/awemenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/plugins/headroom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/plugins/jquery.parallax-1.1.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/plugins/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/plugins/list.min.js"></script>	
    <script src="<?php echo base_url(); ?>assets/professional_edition/js/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datepicker/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datepicker/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datepicker/select2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datepicker/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/professional_edition/js/datepicker/form-validation.js"></script>
	<script>
		jQuery(document).ready(function() {       
		FormValidation.init();
	});
	</script>
	<!-- end:js datepicker -->
    </body>
</html>


