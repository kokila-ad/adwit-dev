		</div>
	</div>
</div>
<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		<?php $footer_copy = $this->db->query("SELECT * FROM `footer_copy`")->result_array(); 
		 echo $footer_copy[0]['footer_name'];  ?>
	</div>
</div>

<div class="scroll-to-top">
	<i class="fa fa-arrow-circle-up"></i>
</div>
<!-- END FOOTER -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/jquery-migrate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/scripts/awemenu.js"/></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/scripts/metronic.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/scripts/layout.js"></script>

