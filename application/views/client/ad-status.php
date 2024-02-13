<?php

	$this->load->view("client/header1");

?>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<style>
#slug-view input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #2ecc71;
	border-radius: 5px;
}

#slug-btn input {
	font-size: 14px;
	color: #FFF;
	background: #2ecc71;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}


#dp-view-btn {
	width: 200px;
	margin: 0 auto;
	padding-top: 60px;
}

#dp-view-btn input {
	width: 100%;
	padding: 13px 10px;
	background: #e74c3c;
	border: #000;
	color: #FFF;
	border-radius: 5px;
}

#slug-error input{
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}

</style>


<div id="Middle-Div">

<form name="form" method="post">
 <div id="slug-view">
    <h2>Status Check</h2>
    <p><label for="name">Order No</label></p>
    <input type="text" name="id" id="id" value="<?php echo set_value("id"); ?>" placeholder="Copy & Paste Order No" required />
    <p style="padding: 0; margin: 0;">&nbsp;</p>
    <div id="slug-btn">
    <input type="submit" name="search"  />
    </div>
	
    <div id="slug-error">
    <?php if(isset($error)){ echo "<font color='red' style='font-family:Tahoma, Geneva, sans-serif' size='+3'>".$error."</font>"; } ?>
    </div>
 </div>
</form>
	
	
<div id="dp-view">
	
 <?php if(isset($status_check)): ?>
		
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
											
	<tr>
		<th>JOB</th>
		<th>Order Id</th>
		<th>Version</th>
		<th>Time In</th>
		<th>ETD</th>
		<th>Status</th>
	</tr>
											
	<?php foreach($status_check as $row){ 
			$in_time = gmdate('H:i:s',(hoursToSecods($row['in_time']) - 420));
			$time_left = '0';
			$ta = '0';
			if($row['status'] != 'sent')
			{
				if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/New_York');
				}
				$current_time = date("H:i:s");
				$start = strtotime($row['in_time']);
				$end = strtotime($current_time);
				$time_left = $end - $start ;
				$time_left = $time_left / 60;
			}
			if($row['status'] == 'QA_complete')
			{
				$ta = '10';
			}elseif($row['status'] == 'sent')
			{
				$ta = '0';
			}else{ $ta = '120'; }
	
	?>									
	<tr>
		<td><?php echo ucfirst($row['category']); ?></td>
		<td><?php echo $row['order_id']; ?></td>
		<td><?php echo $row['version']; ?></td>
		<td><?php echo $in_time; ?></td>
		
		<td><?php if($time_left < $ta && $row['out_time']=='00:00:00')
				  { 
					$timer = $ta - $time_left ; 
					if($timer<= '5'){
						echo "<font color='red'>". round($timer,0)." min </font>";
					}else{ echo round($timer,0)." mins"; }
				  }else{echo "Elapsed"; } 
														 ?>
		</td>
		
		<td><?php echo $row['status']; ?></td>
	</tr>
	<?php  } ?>	
											
	</table>
	
 <?php endif; 
	
 ?>
	
</div>
	

<div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/';?>">Back</a></div>
</div>
<?php 
	function hoursToSecods ($hour) 
	{ 
		// $hour must be a string type: "HH:mm:ss"
		$parse = array();
		if (!preg_match ('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#',$hour,$parse)) {
         // Throw error, exception, etc
			throw new RuntimeException ("Hour Format not valid");
		}

        return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60 + (int) $parse['secs'];

	}
	
?>

<?php

	$this->load->view("client/footer");

?>