<?php
	$this->load->view("designer/header");
?>



<div id="container">
<div id="content">
<div class="form">

<div id="Middle-Div">
 <div id="txt_Sold_Search"></div>

<table>
	<tr><td> <br/> </td>
		<td> <?php echo "Job Count : ".$count; ?> </td>
		<td> <br/> </td>
	</tr>
	
	<tr><td> <br/> </td></tr>
	<tr><td>JOB NAME &nbsp; &nbsp; </td>
		<td>CATEGORY &nbsp; &nbsp; </td>
		<td>PUBLICATION &nbsp; &nbsp; </td>
		<td>EMPLOYEE-CODE &nbsp; &nbsp; </td>
		
	</tr>
	<tr><td> <br/> </td></tr>
	<?php
 
			foreach($order_id as $result1)
			{
	?>
	<form id="update_form" name="update_form" method="post">
	
	<tr>
	<td><?php echo $result1['id']."-".$result1['job_no']; ?> &nbsp; &nbsp; &nbsp; </td>
	
	
	<td><?php echo $result1['category']; ?>
	</td>
	
	<td> <?php 
			$p_id = $this->db->get_where('publications',array('id' => $result1['publication_id']))->result_array();
				foreach($p_id as $pid)
				{
				
					echo $pid['name']; 
				}	
		?>
	&nbsp; </td>
	
	<td><?php echo($result1['designer']) ?> </td>
	<td><input name="id" id="id" value="<?php echo($result1['id'])?>"  style="visibility:hidden" /></td>
	
	<td><input type='submit' name='submit' id='submit' value='checked' /></td>

	</tr>
</form>	
	<?php

		}

	?>
</table>	

</div><!-- #content-->
</div>
</div>	
</div>

		
<?php
	$this->load->view("designer/footer");
?>