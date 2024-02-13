<?php
	$this->load->view("india/header");
	
?>
 <div id="container"> 
<div id="content">
    <div class="form">
	
	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #F00;">
	<?php
		// check the upload status
		$count=0;
		if($file1)
		{
		
			$count++;
		}
		if($file2)
		{
		
			$count++;
		}
		if($file3)
		{
		
			$count++;
		}
		if($file4)
		{
		
			$count++;
		}
		if($file5)
		{
		
			$count++;
		}
		
		$this->load->helper('directory');
		$map = directory_map($dir3.'/');
		
		foreach($map as $row)
		{
			echo $row."<br/>";
		}
		
	?></p>
	
	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #090;">
	<?php
	echo $count." File(s) Successfully Uploaded. <br/> ";
	?></p>
	
<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;"><a href="<?php echo base_url().index_page()."india/home/sendThisFile";?>" style="text-decoration:none; color: #000;">Click to upload another file</a></p>

	
        	<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">or &nbsp;<a href="<?php echo base_url().index_page()."india/home/neworder";?>" style="text-decoration:none; font-weight: bold; color:#C33;">Place New Order</a></p>        </div>
        
    </div>
</div><!-- #content-->
		
<?php
	$this->load->view("india/footer");
?>