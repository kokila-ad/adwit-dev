<?php
	$this->load->view("team-lead/header");
?>

<?php
	$team_name=$this->db->get_where('team_lead',array('id' => $this->session->userdata('tId')))->result_array();
?>
<?php if(isset($error))echo $error;?>
<img src="<?php echo $team_name[0]['image'];?>" width="180px" height="180px"/>

<form name="Image" enctype="multipart/form-data"  method="POST">
<input type="file" name="Photo" size="2000000" accept="image/gif, image/jpeg, image/x-ms-bmp, image/x-png" size="26"><br/>
<INPUT type="submit" class="button" name="Submit" value="Submit" > 
&nbsp;&nbsp;<INPUT type="reset" class="button" value="Cancel">
</form>

<?php
	$this->load->view("team-lead/footer");
?>