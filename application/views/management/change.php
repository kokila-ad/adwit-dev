<?php
	$this->load->view("management/header");
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
  <?php
	$manager_name=$this->db->get_where('management',array('id' => $this->session->userdata('mId')))->result_array();
	?>
    <div id="cp-div">
      <div id="cp-div-h">
      <h2>Management</h2>
      </div>
      <div id="cp-div-p">
      <img src="images/ad-img.jpg" width="180px" height="180px"/>
      </div>
      <div id="cp-div-l">
      <div><h3>Basic Information</h3></div>
      <div id="cp-div-l-c">
      <table border="0">
      	<tbody>
          <tr>
          	<th class="_c3">Full Name</th>
            <td class="_c4"><?php echo $manager_name[0]['first_name'];?></td>
          </tr>
        </tbody>
  	  </table>
      </div>
      <p>&nbsp;</p>
      <div><h3>Office Information</h3></div>
      <div id="cp-div-l-c">
      <table border="0">
      	<tbody>
          <tr>
          	<th class="_c3">Username</th>
            <td class="_c4"><?php echo $manager_name[0]['username'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Email id</th>
            <td class="_c4"><?php echo $manager_name[0]['email_id'];?></td>
          </tr>
        </tbody>
  	  </table>
      </div>
</div>
      <div id="cp-div-r">
      <h3>Change Password</h3>
      <div id="cp-div-l-c">
        <form id="do-change" action="<?php echo base_url().index_page()."management/home/dochange";?>" method="post">
        <table border="0">
      	<tbody>
        <div>
          <?php if(isset($error)): ?>
    	<p class="msg" style="color:<?php echo $color;?>"><?php echo $error;?></p>
    <?php endif;?>
      </div>

          <tr>
          	<th class="_c3">Current Password</th>
            <td class="_c4"><input type="password" placeholder="Current Password" required id="current_password" name="current_password"  /></td>
          </tr>
          <tr>
          	<th class="_c3">New Password</th>
            <td class="_c4"><input type="password" placeholder="New Password" required id="new_password" name="new_password" /></td>
          </tr>
          <tr>
          	<th class="_c3">Re-Type Password</th>
            <td class="_c4"><input type="password" placeholder="Confirm Password" required id="confirm_password" name="confirm_password" /></td>
          </tr>
          <tr>
          <th>&nbsp;</th>
          <td><button type="submit">submit</button></td>
          </tr>
        </tbody>
  	  </table>
          </form>
      </div>
      </div>
      
    </div>
</div>
    </section>
			
<?php
	$this->load->view("management/footer");
?>