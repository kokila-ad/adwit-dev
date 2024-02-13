<?php
	$this->load->view("bg_head/header");
?>



<div id="container">
<div id="content">
<div class="form">
<div id="Middle-Div">
 <div id="txt_Sold_Search"></div>

<table>
	<tr><td> <br/> </td></tr>
	<tr><td>JOB NAME  </td>
		<td>CATEGORY </td>
		<td>PUBLICATION </td>
		<td>EMPLOYEE-CODE </td>
		
	</tr>
	<tr><td> <br/> </td></tr>
	<?php

		foreach($p_id as $result)
		{
			$order_id = $this->db->query("Select * from orders_dup where publication_id='".$result['id']."' and csr='none' limit 0 , 10")->result_array();
			$count = $this->db->query("Select * from orders_dup where publication_id='".$result['id']."' and csr='none'")->num_rows();
			 echo $result['name']."-".$count."&nbsp;&nbsp;";
			foreach($order_id as $result1)
			{
	?>
	<form id="update_form" name="update_form" method="post">
	
	<tr>
	<td><?php echo $result1['id']."-".$result1['job_no']; ?></td>
	
	<td><select id="category" name="category">
		<option value="none"> select </option>
	<?php
		foreach($cat as $row)
		{
	?>
	<option value="<?php echo $row['cat']; ?>" > <?php echo $row['cat'];?> </option>
	
	<?php
	}
	?>
	</select></td>
	
	<td> <?php echo $result['name']; ?> </td>
	
	<td><select id="csr" name="csr">
		<option value="none"> select </option>
		
		<?php
		foreach($c_id as $row1)
		{
	?>
	<option value="<?php echo $row1['name']; ?>" > <?php echo $row1['name'];?> </option>
	
	<?php
	}
	?>
	
		</select>
	</td>
	<td><input name="id" id="id" value="<?php echo($result1['id'])?>"  style="visibility:hidden" /></td>
	
	<td><input type='submit' name='submit' id='submit' value='submit' /></td>

	</tr>
</form>	
	<?php

		}
	}
	?>
</table>	

</div><!-- #content-->
</div>
</div>	
</div>


		
<?php
	$this->load->view("bg_head/footer");
?>