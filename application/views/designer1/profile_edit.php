<?php
	$this->load->view("designer/header");
?>

<script type="text/javascript" src="js/validate.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#img_prev')
.attr('src', e.target.result)
.width(150)
.height(200);
};

reader.readAsDataURL(input.files[0]);
}
}
</script>


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
	$designer_name=$this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
	$team_lead=$this->db->get_where('team_lead',array('id' => $designer_name[0]['design_team_lead']))->result_array();
	$work_loc = $this->db->get_where('location',array('id' => $designer_name[0]['Work_location']))->result_array();
	$join_loc = $this->db->get_where('location',array('id' => $designer_name[0]['Join_location']))->result_array();
	?>
    <div id="cp-div">
      <div id="cp-div-h">
      <h2>Profile</h2>
      </div>
      <div id="cp-div-p">
	  <!-- <a href="<?php echo base_url().index_page()."designer/home/image";?>" >
     <img src="images/ad-img.jpg" width="180px" height="180px"/>
	  <img src="<?php echo $designer_name[0]['image'];?>" width="180px" height="180px"/>
	  </a>-->
	  <?php if(isset($error))echo $error;?>
	<!--<img src="<?php echo $designer_name[0]['image'];?>" width="180px" height="180px"/>-->
<img id="img_prev" src="<?php echo $designer_name[0]['image'];?>" alt="your image" width="180px" height="180px" />
	<form name="Image" enctype="multipart/form-data" action= "<?php echo base_url().index_page()."designer/home/image";?>" method="POST">
	<input type="file" name="Photo" size="2000000" accept="image/gif, image/jpeg, image/x-ms-bmp, image/x-png" size="26" onchange="readURL(this);"><br/>
	<INPUT type="submit" class="button" name="Submit_Img" value="Submit" > 
	&nbsp;&nbsp;<INPUT type="reset" class="button" value="Cancel">
	</form>
      </div>
      <div id="cp-div-l">
      <div><h3>Basic Information </h3></div>
      <div id="cp-div-l-c">
	   <form name="my_form" method="post" >
      <table border="0">
      	<tbody>
          <tr>
          	<th class="_c3">Full Name</th>
            <td class="_c4"><input type="text" name="name" id="name"  value="<?php echo $designer_name[0]['name'] ;?>" /></td>
          </tr>
          <tr>
          	<th class="_c3">Gender</th>
            <td class="_c4">
			<input type="radio" name="gender" value="0" <?php if($designer_name[0]['gender']=='0') echo ' checked="checked" '; ?> />Female
			<input type="radio" name="gender" value="1" <?php if($designer_name[0]['gender']=='1') echo ' checked="checked" '; ?> />Male
            </td>
          </tr>
          <tr>
          	<th class="_c3">Mobile No</th>
            <td class="_c4"><input type="text" name="mobile_no" id="mobile_no" value="<?php echo $designer_name[0]['mobile_no'] ;?>" /></td>
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
            <td class="_c4"><?php echo $designer_name[0]['username'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Email id</th>
            <td class="_c4"><?php echo $designer_name[0]['email_id'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Team Lead</th>
            <td class="_c4"><?php echo $team_lead[0]['first_name']." ".$team_lead[0]['last_name'];?></td>
          </tr>
          <tr>
          	<th class="_c3">Joined Location</th>
            <td class="_c4">
			<select id="Join_location" name="Join_location">
			<option value="<?php echo $designer_name[0]['Join_location']; ?>"><?php echo $join_loc[0]['name']; ?></option>
          <?php
					$results = $this->db->get('location')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'"  >'.$result['name'].'</option>';	
					}
				?>
        </select>
			
			</td>
          </tr>
          <tr>
          	<th class="_c3">Working Location</th>
            <td class="_c4">
			<select id="Work_location" name="Work_location">
			<option value="<?php echo $designer_name[0]['Work_location']; ?>"><?php echo $work_loc[0]['name']; ?></option>
          <?php
					$results = $this->db->get('location')->result_array();
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>';	
					}
				?>
        </select>
			</td>
          </tr>
		   <tr>
			<td style="width: 192px;">&nbsp;</td>
			<td align="left" style="width: 288px; background-color: #fff;">&nbsp;</td>
			<td style="width: 192px;">&nbsp;</td>
		   </tr>
		  <tr>
		  <td align="center" style="width: 288px; background-color: #fff;"><input type="submit" name="submit" value="Submit" class="submit" /></td>
		 <!-- <td align="center" style="width: 288px; background-color: #fff;"><a href="<?php echo base_url().index_page().'designer/home/change';?>"><input type="button" value="Back" /></a></td>-->
		  </tr>
        </tbody>
  	  </table>
	  </form>
      </div>
</div>
   
      
    </div>
    <div id="Back-btn"><a href="<?php echo base_url().index_page().'designer/home/';?>">Back</a></div>
</div>

			
<?php
	$this->load->view("designer/footer");
?>