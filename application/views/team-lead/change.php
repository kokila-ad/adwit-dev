<?php
	$this->load->view("team-lead/header");
?>
<!--
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
        <form id="do-change" action="<?php echo base_url().index_page()."team-lead/home/dochange";?>" method="post">
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
</div>
    </div>
    </section>
-->		
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
	$team_name=$this->db->get_where('team_lead',array('id' => $this->session->userdata('tId')))->result_array();
	$art_name=$this->db->get_where('art_director',array('id' => $team_name[0]['art_director']))->result_array();
	?>
    <div id="cp-div">
      <div id="cp-div-h">
      <h2>Profile</h2>
      </div>
      <div id="cp-div-p">
	  
      <img src="<?php echo $team_name[0]['image'];?>" width="180px" height="180px"/>
	  <p><a href="<?php echo base_url().index_page()."team-lead/home/image";?>" >Change Picture</a>
	  </p>
      </div>
      <div id="cp-div-l">
      <div><h3>Basic Information</h3></div>
      <div id="cp-div-l-c">
      <table border="0">
      	<tbody>
          <tr>
          	<th class="_c3">Full Name</th>
            <td class="_c4"><?php echo $team_name[0]['first_name'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Gender</th>
            <td class="_c4">
			<?php
           echo $team_name[0]['gender']==0 ? 'Female'  : 'Male' ;
			 ?>
            </td>
          </tr>
          <tr>
          	<th class="_c3">Mobile No</th>
            <td class="_c4"><?php echo $team_name[0]['mobile_no'];?></td>
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
          	<th class="_c3">Employee Code</th>
            <td class="_c4"><?php echo $team_name[0]['username'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Email id</th>
            <td class="_c4"><?php echo $team_name[0]['email_id'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Art Director</th>
            <td class="_c4"><?php echo $art_name[0]['first_name']." ".$art_name[0]['last_name'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Joined Location</th>
            <td class="_c4"><?php //echo $team_name[0]['Join_location'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Working Location</th>
            <td class="_c4"><?php //echo $team_name[0]['Work_location'];?></td>
          </tr>
        </tbody>
  	  </table>
      </div>
</div>
      <div id="cp-div-r">
      <h3>Change Password</h3>
      <div id="cp-div-l-c">
        <form id="do-change" action="<?php echo base_url().index_page()."team_lead/home/dochange";?>" method="post">
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
    <div id="Back-btn"><a href="<?php echo base_url().index_page().'team_lead/home/';?>">Back</a></div>
</div>
			
			
			
<?php
	$this->load->view("team-lead/footer");
?>