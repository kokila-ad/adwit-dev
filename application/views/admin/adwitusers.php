<?php
	$this->load->view("admin/header");
	
?>

  <div id="Middle-Div">
  <?php echo $ad_user." - ".$ad_count ?>

<li><a><?php echo "Total Users : ".$total_users; ?></a>

&nbsp;
&nbsp;

<li><a><?php echo $a_user." - ".$a_count ?></a>
<ul>
	<?php
			
			foreach ($a_users->result() as $a_users) {
	?>
	<li><a><?php echo $a_users->first_name;?></a></li>
	<?php
	}
	?>
</ul>
</li>

<li><a><?php echo $b_user." - ".$b_count ?></a>
<ul>
	<?php
			
			foreach ($b_users->result() as $b_users) {
	?>
	<li><a><?php echo $b_users->first_name;?></a></li>
	<?php
	}
	?>
</ul>
</li>

<li><a><?php echo $c_user." - ".$c_count ?></a>
<ul>
	<?php
			
			foreach ($c_users->result() as $c_users) {
	?>
	<li><a><?php echo $c_users->name;?></a></li>
	<?php
	}
	?>
</ul>
</li>


<li><a><?php echo $t_user." - ".$t_count ?></a>
<ul>
	<?php
			
			foreach ($t_users->result() as $t_users) {
	?>
	<li><a><?php echo $t_users->first_name;?></a></li>
	<?php
	}
	?>
</ul>
</li>


<li><a><?php echo $dt_user." - ".$dt_count ?></a>
<ul>
	<?php
			
			foreach ($dt_users->result() as $dt_users) {
	?>
	<li><a><?php echo $dt_users->name;?></a></li>
	<?php
	}
	?>
</ul>
</li>


<li><a><?php echo $d_user." - ".$d_count ?></a>
<ul>
	<?php
			
			foreach ($d_users->result() as $d_users) {
	?>
	<li><a><?php echo $d_users->name;?></a></li>
	<?php
	}
	?>
</ul>
</li>


</div>
<?php
	$this->load->view("admin/footer");
?>