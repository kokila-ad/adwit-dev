<html>
<head>
<style>
*{ margin:0px; padding:0px;}
body{ margin:30px;}
select{ margin:30px 0; padding:5px 20px; }
table{ border-collapse:collapse; }
table td{ padding:5px 50px; }
.btn{ float:left; width:500px; padding:0px 0 10px; }
.button{ padding:5px 40px;color:white;border:none; border-radius:2px; }
</style>
</head>
<body>
<form method="GET" >
	<!-- displaying the dropdown list -->
	<select name="year">
		<option value="">Select Year</option>
		<?php
		foreach ($yearArray as $y) {
			// if you want to select a particular year
			$selected = ($y == $year) ? 'selected' : '';
			echo '<option '.$selected.' value="'.$y.'">'.$y.'</option>';
		}
		?>
	</select>

	<select name="month" onchange="this.form.submit()">
		<option value="">Select Month</option>
		<?php
		foreach ($monthArray as $m) {
			// padding the month with extra zero
			$monthPadding = str_pad($m, 2, "0", STR_PAD_LEFT);
			$fdate = date("F", strtotime("2015-$monthPadding-01"));
			 $selected = ($m == $month) ? 'selected' : '';
			echo '<option '.$selected.' value="'.$monthPadding.'">'.$fdate.'</option>';
		}
		?>
	</select>
	
	<?php if(isset($month)){ ?>
		<input type="submit" style="background-color:green" class="button" value="Move" name="move" onclick="return confirm('Are you sure?')">
	<?php } ?>
</form>
<?php if(isset($orders)){ echo "<br/>Orders Count : ".$orders; } ?>
<?php if(isset($rev_sold_jobs)){ echo "<br/>Revision Count : ".$rev_sold_jobs; }?>
</body>
</html>