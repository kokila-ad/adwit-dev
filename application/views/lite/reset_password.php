<?php $this->load->view('header.html'); ?>
<!--<script type="text/javascript">
        $(document).ready(function(){
        
            $.extend($.validator.messages, {
                equalTo: "These passwords don't match. Try again?"
            });
        
            $("#do-change").validate({
                rules: {
                    "new_password": {
                        minlength: 5,
                        maxlength: 20
                    },
                    "confirm_password": {
                        equalTo: "#new_password"
                    }
                }
            });
            
        });
</script>-->
<div class="container margin-bottom-60 margin-top-30">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12">
             <form name="reset_password" id="do-change" method="POST" action="<?php echo base_url().index_page()."/login/change_password/".$encrypted_key;?>" >
                    
                    <div class="form-group">
                        <label for="register-password">New Password <sup>*</sup></label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="register-confirm-password">Confirm Password <sup>*</sup></label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
						<span id='message'></span>
					</div><!-- /.form-group -->

                    <div class="form-button">
                        <button type="submit" name="signup" class="btn btn-lg btn-primary btn-block">SUBMIT</button> 
                    </div><!-- /.form-button -->
					
               </form>
</div>
</div>			   
</div>



<?php $this->load->view('footer.html'); ?>