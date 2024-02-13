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
  <?php
	$client_name=$this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
	$publications=$this->db->get_where('publications',array('id' => $client_name[0]['publication_id']))->result_array();
	?>
    <div id="cp-div">
      <div id="cp-div-h">
      <h2>Profile</h2>
      </div>
      <div id="cp-div-p">
      <img src="<?php echo $client_name[0]['image']; ?>" width="180px" height="180px" />
	 <p> <a href="<?php echo base_url().index_page()."client/home/image";?>" ><input type="button" value="Edit" /></a> </p>
      </div>
      <div id="cp-div-l">
      <div><h3>Basic Information</h3></div>
      <div id="cp-div-l-c">
      <table border="0">
      	<tbody>
          <tr>
          	<th class="_c3">Full Name</th>
            <td class="_c4"><?php echo $client_name[0]['first_name']." ".$client_name[0]['last_name'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Username</th>
            <td class="_c4"><?php echo $client_name[0]['username'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Gender</th>
            <td class="_c4">
			<?php
           echo $client_name[0]['gender']==0 ? 'Female'  : 'Male' ;
			 ?>
            </td>
          </tr>
          <tr>
          	<th class="_c3">Email id</th>
            <td class="_c4"><?php echo $client_name[0]['email_id'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Publication</th>
            <td class="_c4"><?php echo $publications[0]['name'];?></td>
          </tr>
        </tbody>
  	  </table>
      </div>
<p></p></div>
      <div id="cp-div-r">
      <h3>Change Password</h3>
      <div id="cp-div-l-c">
        <form id="do-change" action="<?php echo base_url().index_page()."client/home/dochange";?>" method="post">
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
    <div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/';?>">Back</a></div>
</div>
<?php
	$this->load->view("client/footer");
?>