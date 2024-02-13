<?php
       $this->load->view("art-director/header");
?>
 <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  <link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css"  />

  <div id="Middle-Div">
 
<form Method="POST" action="<?php echo base_url().index_page()."art-director/home/save_form";?>">
    <div class="form-group">
      <label>Publication Name:</label>
	<?php   
	foreach($type as $row)
	?>
      <input type="text" class="form-control" id="pname" name="pname" value="<?php echo $row['name']?>" readonly>
	   <input type="text" hidden class="form-control" id="id" name="id" value="<?php echo $row['id']?>">
    </div></br>
<div class="form-group">
      <label>Team Lead:</label>
	  <select id="tlname" name="tlname">
	  <?php   
	  if(!empty($row['team_lead_id']))
	  {
$type3 = $this->db->get_where('team_lead',array('id'=>$row['team_lead_id']))->result_array();
				foreach($type3 as $typ)
				{
					echo '<option value="'.$typ['id'].'">'.$typ['first_name'].'</option>';	
				}
		} else {
                    echo'<option value="">select</option>';
}		 ?>
	
	  <?php
			$type1 = $this->db->query("SELECT * FROM `team_lead`")->result_array();
		
				foreach($type1 as $type11)
				{
					echo '<option value="'.$type11['id'].'">'.$type11['first_name'].'</option>';	
						
				}
			?>
	 
      </select>
    </div></br>
	<?php if(!empty($row['channel'])) {  ?>
<div class="form-group">
      <label>Channel:</label>
	  <select id="channel" name="channel">
	   <?php
			$type2 = $this->db->get_where('channels',array('id'=>$row['channel']))->result_array();
				foreach($type2 as $typess)
				{
					echo '<option value="'.$typess['id'].'">'.$typess['name'].'</option>';	
				}
			?>
			 <?php
			$type1 = $this->db->query("SELECT * FROM `channels`")->result_array();
		
				foreach($type1 as $type11)
				{
					echo '<option value="'.$type11['id'].'">'.$type11['name'].'</option>';	
						
				}
			?>
	  </select>
    </div><?php } ?></br>
		<?php if(!empty($row['Join_location'])) {  ?>
<div class="form-group">
      <label>Location:</label>
	  <select id="location" name="location">
	   <?php
			$type2 = $this->db->get_where('location',array('id'=>$row['Join_location']))->result_array();
				foreach($type2 as $typess)
				{
					echo '<option value="'.$typess['id'].'">'.$typess['name'].'</option>';	
				}
			?>
			 <?php
			$type1 = $this->db->query("SELECT * FROM `location`")->result_array();
		
				foreach($type1 as $type11)
				{
					echo '<option value="'.$type11['id'].'">'.$type11['name'].'</option>';	
						
				}
			?>
	  </select>
    </div><?php } ?>

<label><input type="submit" name="submit" id="submit" value="submit"></label>
</form>
</div>
<?php
       $this->load->view("art-director/footer");
?>