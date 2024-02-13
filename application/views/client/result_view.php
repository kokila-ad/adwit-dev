<?php

	$this->load->view("client/header1");

	
?>



  <div id="Middle-Div">

&nbsp;

&nbsp;	

	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #F00;">

	<?php

		// check the upload status

		$count=0;

		$this->load->helper('directory');

		$map = directory_map($dir4.'/');

		if($map)
		{
			foreach($map as $row)
			{
				echo $row."<br/>";
			}
			$count = count($map);
		}

	?></p>

	

	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #0C0;">

	<?php

	

	   echo $count." File(s) Successfully Uploaded. <br/> ";

	   

	?></p>

	

	<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;"><a href="<?php echo base_url().index_page()."client/home/sendThisFile";?>" style="text-decoration:none; color: #000;">Click to upload another file</a></p>



	

	<!--<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">or &nbsp;<a href="<?php echo base_url().index_page()."client/home/neworder";?>" style="text-decoration:none; font-weight: bold; color:#C33;">Place New Order</a></p>-->

    <p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">or &nbsp;<a onclick="window.open('<?php echo base_url().index_page().'client/home/myorders_v2';?>')" style="text-decoration:none; font-weight: bold; color:#C33; cursor:pointer;">Click for Order Confirmation</a></p>
	
  
<div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/home/';?>">Back</a></div>
  </div>

		

<?php

	$this->load->view("client/footer");

?>