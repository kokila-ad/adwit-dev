<?php
	$this->load->view("designer/header");
?>

<div id="Middle-Div">

<form name="form" method="post">
 <div id="slug-view">
    <h2>Tweek Here</h2>
    <p><label for="name">Order Id</label></p>
    <input type="text" name="id" id="id" value="<?php echo set_value("id"); ?>" required />
    <p>&nbsp;</p>
  
    <div id="slug-btn">
    <input type="submit" name="search"  />
    </div>
	
    <div id="slug-error">
    <?php if(isset($error)) echo $error; ?>
    </div>
    <div id="slug-created">
	
    <?php if(isset($slug)) echo "<p>".$slug."</p>";	?>
	
	</div>
    </div>
    </form>
    <div id="dp-view">
	<?php 
	if(isset($id)) 
	{	
		echo '<form name="form1" action="'.base_url().index_page().'designer/home/dp_tweek_end" method="post" >';
		echo "<p>".$slug."</p>";
		echo "<p>".$st_time."</p>";
		echo '<input type="text" name="oid" id="oid" value="'.$id.'" readonly style="visibility:hidden"/><br/>';
		
		$dp_error= $this->db->get('dp_error')->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	
	?>
		<div id="slug-btn">
        <input type="submit" name="end_time" id="end_time" value="End Time" onclick="return confirm('Are you sure you want to end the job?');" />
    	</div>
       
	<?php	
		echo '</form>';
	}
	?>
	
	</div>
	

<div id="Back-btn"><a href="<?php echo base_url().index_page().'designer/home/';?>">Back</a></div>
</div>

<?php
	$this->load->view("designer/footer");
?>