<style>
	.download {cursor: pointer; float: right;}
	.download:hover {color: #4ef5c7;}
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/justifiedGallery.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/colorbox.css" type="text/css" media="screen" />

<script src="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/justifiedGallery.min.js"></script>	
<script src="<?php echo base_url(); ?>assets/new_admin/plugins/imagebank/colorbox-min.js"></script>

	 <script>
        $(document).ready(function () {
            $('#jgs-form').submit(false);

            $('#imagebank').justifiedGallery({
                rowHeight: 150,
                maxRowHeight: null,
                margins: 3,
                border: 0,
                rel: 'imagebank',
                lastRow: 'nojustify',
                captions: true,
                randomize: false,
                
            }).on('jg.complete', function () {
                $(this).find('a').colorbox({
                    maxWidth: '80%',
                    maxHeight: '80%',
                    opacity: 0.8,
                    transition: 'elastic',
                    current: ''
                });
            });

            $('#jgs-form #jgs-rowHeight').on('keyup', function () {
                var m = parseInt($(this).val(), 10);
                if (!isNaN(m) && m > 0) {
                    $('#imagebank').justifiedGallery({rowHeight: m});
                    $('#jgs-form #jgs-rowHeight-container').removeClass('has-error');
                } else {
                    $('#jgs-form #jgs-rowHeight-container').addClass('has-error');
                }
            });

            $('#jgs-form #jgs-maxRowHeight').on('keyup', function () {
                var m = parseInt($(this).val(), 10);
                if (!isNaN(m) && m >= 0) {
                    $('#imagebank').justifiedGallery({maxRowHeight: m});
                    $('#jgs-form #jgs-maxRowHeight-container').removeClass('has-error');
                } else {
                    $('#jgs-form #jgs-maxRowHeight-container').addClass('has-error');
                }
            });

            $('#jgs-form #jgs-margins').on('keyup', function () {
                var m = parseInt($(this).val(), 10);
                if (!isNaN(m) && m >= 0) {
                    $('#imagebank').justifiedGallery({margins: m});
                    $('#jgs-form #jgs-margins-container').removeClass('has-error');
                } else {
                    $('#jgs-form #jgs-margins-container').addClass('has-error');
                }
            });

            $('#jgs-form #jgs-border').on('keyup', function () {
                var b = parseInt($(this).val(), 10);
                if (!isNaN(b)) {
                    $('#imagebank').justifiedGallery({border: b});
                    $('#jgs-form #jgs-border-container').removeClass('has-error');
                } else {
                    $('#jgs-form #jgs-border-container').addClass('has-error');
                }
            });

            $('#jgs-form input[name="jgs-lastRow"]').on('change', function (e) {
                $('#imagebank').justifiedGallery({lastRow: $(this).val()});
            });

            $('#jgs-form #jgs-captions').on('change', function (e) {
                if (!$(this).prop('checked')) $('#imagebank .caption').remove();
                $('#imagebank').justifiedGallery({captions: $(this).prop('checked')});
            });

            $('#jgs-form #jgs-randomize').on('change', function (e) {
                $('#imagebank').justifiedGallery({randomize: $(this).prop('checked')});
            });

        });
		</script>		
			
		</div>
	</div>
</div>
<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
		 2016 &copy; AdwitAds. All Rights Reserved.
	</div>
</div>

<div class="scroll-to-top">
	<i class="fa fa-arrow-circle-up"></i>
</div>
<!-- END FOOTER -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/jquery-migrate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/scripts/awemenu.js"/></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/scripts/metronic.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/scripts/layout.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new_admin/plugins/select2/select2.min.js"></script>
<script>
	jQuery(document).ready(function() {    
	   Metronic.init(); 
	   Layout.init();   
	});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
