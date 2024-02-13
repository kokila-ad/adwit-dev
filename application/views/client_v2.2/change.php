<?php
	$this->load->view("client/header1");
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


<div id="Middle-Div">
    <div id="Login-div">
    <?php if(isset($error)): ?>
    	<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
    <?php endif;?>
      <div id="Login-h1">
      Enter new password</div>
      <form id="do-change" action="<?php echo base_url().index_page()."client/home/dochange";?>" method="post">
      <div id="Login-input">
      <input type="password" placeholder="Current Password" required id="current_password" name="current_password"  /><br/><br/>
      <input type="password" placeholder="New Password" required id="new_password" name="new_password" /><br/><br/>
      <input type="password" placeholder="Confirm Password" required id="confirm_password" name="confirm_password" /><br/><br/>
     </div>  
      <div id="Login-button">
      <button type="submit">submit</button>      
      </div>
      <p>&nbsp;</p>
      </form>
     </div>
    <div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/home/';?>">Back</a></div>
  </div>
			
<?php
	$this->load->view("client/footer");
?>