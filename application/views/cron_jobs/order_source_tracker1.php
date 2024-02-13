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
	</select>
</form>
<?php if(isset($src_tracker[0]['id'])){ ?>
<div class="btn">
	<a href="<?php echo base_url().index_page().'cron_jobs/home/action_zip/'.$month; ?>"><button style="background-color:green">ZIP</button></a>
	<a href="<?php echo base_url().index_page().'cron_jobs/home/action_ftp/'.$month; ?>"><button style="background-color:yellow;color:black">FTP</button></a>
	<a href="<?php echo base_url().index_page().'cron_jobs/home/action_delete/'.$month; ?>"><button style="background-color:red">DELETE</button></a>
</div>
	<table border='1'>
		<thead>
		<tr>
			<th>OrderId</th>
			<th>Start</th>
			<th>Zip</th>
			<th>Ftp</th>
			<th>Delete</th>
			<th>Month</th>
		</tr>
		</thead>
		<tbody>
<?php foreach($src_tracker as $row){ ?>		
		<tr>
			<td><?php echo $row['order_id']; ?></td>
			<td><?php echo $row['start']; ?></td>
			<td><?php echo $row['zip']; ?></td>
			<td><?php echo $row['ftp']; ?></td>
			<td><?php echo $row['delete']; ?></td>
			<td><?php echo $row['month']; ?></td>
		</tr>
<?php } } ?>
		</tbody>
	</table>
</body>
</html>