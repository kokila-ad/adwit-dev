<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php
	$this->load->view("client/header1");
	
?>
 <div id="container"> 
<div id="content">
    <div class="form">
	<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #090;">

<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('client/home/sendThisFile', 'Upload Another File!'); ?></p>

       	<p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">or &nbsp;<a href="<?php echo base_url().index_page()."client/home/neworder";?>" style="text-decoration:none; font-weight: bold; color:#C33;">Place New Order</a></p>        </div>
        
    </div>
</div><!-- #content-->
		
<?php
	$this->load->view("client/footer");
?>

</body>
</html>