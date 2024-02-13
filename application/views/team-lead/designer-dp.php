<?php
	$this->load->view("team-lead/header"); 
?>
<label>DESIGNER DP DETAILS</label> <br/> <br/>
<label>Last Session TT :  </label> <?php echo $tt; ?> <br/>
<label>Total NJ :  </label> <?php echo $sum_nj; ?> <br/>
<label>Avg TT :  </label> <?php echo $avg_tt; ?> <br/>
<label>Avg NJ :  </label> <?php echo $avg_nj; ?> <br/>

<?php
	$this->load->view("team-lead/footer"); 
?>
