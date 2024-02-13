<html>
<body>
<table align="center" width="250" border="0" cellspacing="0.5" cellpadding="0.5" style="background-color:#eeeeee; font-family:Tahoma, Geneva, sans-serif; border: thin solid #ccc;">
<thead>
	<tr>
		<th>List of the ads</th>
	</tr>
</thead>
<tbody>
<?php foreach($order_array as $order){ ?>
  <tr>
    <td><?php echo $order; ?></td>
  </tr>
<?php } ?>
  </tbody>
</table>
</body>
</html>