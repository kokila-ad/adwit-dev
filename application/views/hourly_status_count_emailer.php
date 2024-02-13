<html>
<body>
<table align="center" width="250" border="0" cellspacing="0.5" cellpadding="0.5" style="background-color:#eeeeee; font-family:Tahoma, Geneva, sans-serif; border: thin solid #ccc;">
<thead>
	<tr>
		<th>Order Status Count</th>
	</tr>
</thead>
<hr>
    <tbody>

        <tr>
            <td><?php echo 'Order Received - <b>'.$order_received_count.'</b>'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'Order Accepted - <b>'.$order_accepted_count.'</b>'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'In Production - <b>'.$inproduction_count.'</b>'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'Quality Check - <b>'.$quality_check_count.'</b>'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'Proof Ready - <b>'.$proof_ready_count.'</b>'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'Approved - <b>'.$approved_count.'</b>'; ?></td>
        </tr>
    
    </tbody>
</table>
</body>
</html>