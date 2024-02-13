       <footer class="footer">
           <div class="footer-copyright ">
               <div class="page-footer">
					<div class="container">
						<div class="copyright">
							<p><?php $footer_copy = $this->db->query("SELECT * FROM `footer_copy`")->result_array(); 
		 echo $footer_copy[0]['footer_name'];  ?></p>
						</div>
						<div class="footer-nav margin-top-5">
							<nav class="padding-0">
								<ul>
									<li><a href="<?php echo base_url().index_page()."new_client/home/about"?>">About Us</a></li>
									<li><a href="<?php echo base_url().index_page()."new_client/home/contact_us"?>">Contact Us</a></li>
									<li><a href="<?php echo base_url().index_page()."new_client/home/terms_of_use"?>">Terms of Use</a></li>
									<li><a href="<?php echo base_url().index_page()."new_client/home/privacy_policy"?>">Privacy Policy</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
           </div><!-- /.footer-copyright -->          
        </footer>
        </div><!-- /#wrapper -->

	<script src="<?php echo base_url(); ?>assets/new_client/js/dropzone.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datatables.min.js"></script>	  
    <script src="<?php echo base_url(); ?>assets/new_client/js/awe-hosoren.js"></script>	
	<script src="<?php echo base_url(); ?>assets/new_client/js/jquery-ui.min.js"></script>	
	<script src="<?php echo base_url(); ?>assets/new_client/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/awemenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/headroom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/jquery.parallax-1.1.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_client/js/plugins/list.min.js"></script>	
    <script src="<?php echo base_url(); ?>assets/new_client/js/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/select2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/new_client/js/datepicker/form-validation.js"></script>
	<script>
		jQuery(document).ready(function() {       
		FormValidation.init();
	});
	</script>
	<!-- end:js datepicker -->
    </body>
</html>


