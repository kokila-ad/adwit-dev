<!DOCTYPE html>
<body style="margin: 0; padding: 0;">
<table align="center" border="0" cellspacing="0" cellpadding="0" 
style="width: 650px; border: 1px solid #CCC; margin-top: 20px;">
  <tbody style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
	<tr>
	  <td bgcolor="#3dbd8c" style="color:#fff; font-size:17px; font-weight:600; padding:8px;">AD DETAILS</td>
	  <td bgcolor="#3dbd8c" style="color:#fff; font-size:13px; text-align:right; padding:8px;"><?php echo $orders[0]['created_on']; ?></td>
	</tr>
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Job Name:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"> <?php echo $orders[0]['job_no']; ?></td>
	</tr>
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Date Needed:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"><?php echo $orders[0]['date_needed']; ?></td>
	</tr>
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Width:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"><?php echo $orders[0]['width']; ?></td>
	</tr>
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Height:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"><?php echo $orders[0]['height']; ?></td>
	</tr>
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Color:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"><?php $color_preference = $this->db->get_where('lite_color_preference',array('id' => $orders[0]['print_ad_type']))->result_array(); ?>
	   <span class="value"><?php echo $color_preference[0]['name']; ?></span>
	  </td>
	</tr>
	<!--<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Uploaded Files:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;">
	  <p style="padding:2px 0; margin:0;">
	  <?php /*
		if($orders[0]['file_path']!='none' && file_exists($orders[0]['file_path'])){
			$this->load->helper('directory');
			$map = directory_map($orders[0]['file_path']);
			if($map){ 
				foreach($map as $row){ echo $row; }
			} 
		}
		*/	
	  ?>
	  </p>
	  </td>
	</tr>-->
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Copy/Content:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"><?php echo $orders[0]['copy_content_description']; ?></td>
	</tr>
	<tr>
	  <td style="width: 150px; color:#000; font-size:14px; font-weight:600; padding:10px 8px; border-bottom: 1px solid #CCC;">Instructions:</td>
	  <td style="width: 500px; color:#333; font-size:14px; text-align:right; padding:10px 8px; border-bottom: 1px solid #CCC;"><?php echo $orders[0]['notes']; ?></td>
	</tr>
  </tbody>
</table>

</body>