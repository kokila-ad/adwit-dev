<html>
<head>
<style>
*{ margin:0px; padding:0px;}
body{ margin:30px;}
select{ margin:30px 0; padding:5px 20px; }
table{ border-collapse:collapse; }
table td{ padding:5px 50px; }
.btn{ float:left; width:500px; padding:0px 0 10px; }
button{ padding:5px 40px;color:white;border:none; border-radius:2px; }
</style>
</head>
<body>
<form method="GET" >
	<select name="month" onchange="this.form.submit()">
		<option value="">SELECT</option>
		<option value="<?php echo $month1 ;?>" <?php if(isset($month) && $month == $month1) echo 'selected';?>><?php echo date('M Y', strtotime($month1)) ;?></option>
        <option value="<?php echo $month2 ;?>" <?php if(isset($month) && $month == $month2) echo 'selected';?>><?php echo date('M Y', strtotime($month2)) ;?></option>
        <option value="<?php echo $month3 ;?>" <?php if(isset($month) && $month == $month3) echo 'selected';?>><?php echo date('M Y', strtotime($month3)) ;?></option>
		<option value="<?php echo $month4 ;?>" <?php if(isset($month) && $month == $month4) echo 'selected';?>><?php echo date('M Y', strtotime($month4)) ;?></option>
        <option value="<?php echo $month5 ;?>" <?php if(isset($month) && $month == $month5) echo 'selected';?>><?php echo date('M Y', strtotime($month5)) ;?></option>
        <option value="<?php echo $month6 ;?>" <?php if(isset($month) && $month == $month6) echo 'selected';?>><?php echo date('M Y', strtotime($month6)) ;?></option>
		<option value="<?php echo $month7 ;?>" <?php if(isset($month) && $month == $month7) echo 'selected';?>><?php echo date('M Y', strtotime($month7)) ;?></option>
        <option value="<?php echo $month8 ;?>" <?php if(isset($month) && $month == $month8) echo 'selected';?>><?php echo date('M Y', strtotime($month8)) ;?></option>
        <option value="<?php echo $month9 ;?>" <?php if(isset($month) && $month == $month9) echo 'selected';?>><?php echo date('M Y', strtotime($month9)) ;?></option>
		<option value="<?php echo $month10 ;?>" <?php if(isset($month) && $month == $month10) echo 'selected';?>><?php echo date('M Y', strtotime($month10)) ;?></option>
        <option value="<?php echo $month11 ;?>" <?php if(isset($month) && $month == $month11) echo 'selected';?>><?php echo date('M Y', strtotime($month11)) ;?></option>
	</select>
</form>
<?php 
    echo $this->session->flashdata('message');
    if(isset($result[0]['id'])){ 
        
        echo"COUNT : ".count($result); 
?>
<div class="btn">
	<a href="<?php echo base_url().index_page().'cron_jobs/home/action_move_sourcearchive_ftp/'.$month; ?>"><button style="background-color:green">Move&Delete</button></a>
</div>
	<table border='1'>
		<thead>
		<tr>
			<th>Order Id</th>
			<th>Path</th>
		</tr>
		</thead>
		<tbody>
<?php 
    foreach($result as $row){
        $path = $row['ftp_source_path'];
		$filename = basename($path);
		$file_path = "sourcearchive/".$filename;
        if(file_exists($file_path)){
?>		
		<tr>
			<td><?php echo $row['order_no']; ?></td>
			<td><?php echo $row['ftp_source_path']; ?></td>
		</tr>
<?php } }  ?>
		</tbody>
	</table>
<?php } ?>
</body>
</html>