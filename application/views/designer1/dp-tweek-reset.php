<?php
	$this->load->view("designer/header");
?>

<div id="Middle-Div">
<div id="slug-view">
	<h2>Tweek Pending</h2>
	<p><label for="name">Job Slug</label></p>
    <input type="text" name="id" id="id" value="<?php echo $pending_job['job_name']; ?>" readonly />
    <p>&nbsp;</p>
  
</div>

<div id="dp-view">
	
	<form name="form1" action="<?php echo base_url().index_page().'designer/home/dp_tweek_end';?>" method="post" >
	<?php
		//echo "<p>".$pending_job['slug']."</p>";
		echo "<p>".$pending_job['start_time']."</p>";
		
		$dp_error= $this->db->get('dp_error')->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'.$row["name"].'<br/>';
		}
	?>
	
	<input type="text" name="oid" id="oid" value="<?php echo $pending_job['id']; ?>" readonly style="visibility:hidden" />
	
	<br/><input type="submit" name="end_time" id="end_time" value="End Time" onclick="return confirm('Are you sure you want to end the job?');" />
	</form>

</div>

<div id="Back-btn"><a href="<?php echo base_url().index_page().'designer/home/';?>">Back</a></div>
</div>   

<?php
	$this->load->view("designer/footer");
?>