<?php
	$this->load->view("bg_head/header");
?>

<script type="text/javascript" src="js/validate.js"></script>

<script type="text/javascript">
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
</script>
    <div id="container">          
<div id="content">
    <?php if(isset($error)): ?>
    	<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
    <?php endif;?>
    <div class="login">
        <form id="do-change" action="<?php echo base_url().index_page()."bg_head/home/dochange";?>" method="post">
             <h3>Enter new password.</h3>
              <div>
                 <input type="password" placeholder="Current Password" required id="current_password" name="current_password"  />
             </div>
             <div>
                 <input type="password" placeholder="New Password" required id="new_password" name="new_password" />
             </div>
              <div>
                 <input type="password" placeholder="Confirm Password" required id="confirm_password" name="confirm_password" />
             </div>
             <div>
                 <button type="submit">Submit</button>
             </div>
         </form>
    </div>
</div><!-- #content-->
    </div>
    </section>
			
<?php
	$this->load->view("bg_head/footer");
?>