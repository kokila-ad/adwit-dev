<?php
	$this->load->view("india/header");
?>

<script type="text/javascript">
	$(document).ready(function(e) {
        $('#ad_type').change(function(e) {
            window.location = "<?php echo base_url().index_page().'india/home/neworder/';?>" + $('#ad_type').val();
        });
    });
</script>

<div id="container">
<div id="content">
    <div class="form">
    <p>&nbsp;</p>
    	<p style="text-align:center;">
        	Select Your Creative Requirement:&nbsp;
        	<select id="ad_type" name="ad_type">
            <option value="">Select</option>
        	<?php
				foreach($types as $type)
				{
					echo '<option value="'.$type['value'].'" '.($form==$type['value'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
        </p>
        <div id="form">
        	<?php if(isset($form)):?>
            	<form id="order_form" name="order_form" method="post">
                	<?php if(isset($num_errors) && $num_errors!=0):?>
                   	 	<h3 style="color:#900;">Please check for the errors below!</h3>
						<div class="errors_list">
                            <ul >
                                <?php echo validation_errors();?>
                            </ul>
                    	</div>
                     <?php endif;?>
                    <?php $this->load->view('india/'.$form);?>
				</form>
			<?php endif;?>
             <p>&nbsp;</p>
        </div>
    </div>
</div><!-- #content-->
    </div>
    </section>
			
<?php
	$this->load->view("india/footer");
?>