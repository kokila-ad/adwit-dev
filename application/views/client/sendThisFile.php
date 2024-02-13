<?php

	$this->load->view("client/header1");

?>

<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<!-- Middle Starts -->

<div id="Middle-Div">

<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>'; ?>

    <div id="stf-f">&nbsp;</div>
	
	<form action="index.php/client/home/sendfile" method="POST" enctype="multipart/form-data">
	
     <!--<form action="index.php/client/home/setfolder" method="POST" enctype="multipart/form-data">-->
	
    <div id="stf-fa">

    <h2>You can attach files here</h2>

    <div id="stf-faa">

    <p><?php if (isset($error)){echo $error; } ?></p>

	File 1 

    <input type="file" name="ufile[]" id="ufile[]" value="upload" onkeypress="this.click(); return false;" class="input" required/><br/><br/>

    File 2 

    <input type="file" name="ufile[]" id="ufile[]" value="upload"/><br/><br/>

    File 4 

    <input type="file" name="ufile[]" id="ufile[]" value="upload" /><br/><br/>

    File 3 

    <input type="file" name="ufile[]" id="ufile[]" value="upload" /><br/><br/>

    File 5 

    <input type="file" name="ufile[]" id="ufile[]" value="upload"/>

   </div>

    <div id="stf-fab">
	<?php 
	if(isset($order_id)) 
	{	
		echo '<input type="text" name="oid" id="oid" value="'.$order_id.'" readonly style="visibility:hidden"/><br/>';
	}
	?> 
    

    <input type="submit" name="submit" class="submit" value="Send" onclick="show_me(this.form.file_name)" />
    <p style="color: #333;">Real-estate/Auto/Grocery images to be zipped or compressed</p>
    <a href="<?php echo base_url().index_page().'client/home/home/';?>"><button type="button" class="btn btn-primary">Submit order without files</button></a>
    </div>

    </div>

    </form>
    
    

    <div id="stf-fb">&nbsp;
	<?php 
	if(isset($dir4))
	{
		echo "<p> Files Already Uploaded</p>";
		$this->load->helper('directory');

		$map = directory_map($dir4.'/');
		if($map){
			foreach($map as $row)
			{
				echo $row."<br/>";
			}
		}else{ echo "None"; }
	} ?>
	</div>

    <!-- <div id="stf-npb">
    or <a href="<?php echo base_url().index_page()."client/home/neworder";?>" >Place New Order</a>
    </div> -->

  <div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/home/';?>">Back</a></div>              

  </div>

  <!-- Middle Ends -->



<script language="javascript" type="text/javascript">

$("form").submit(function() {

if ($('#loading_image').length == 0) { //is the image on the form yet?

                // add it just before the submit button

$(':submit').after('<img src="images/up.gif" alt="Uploading...." id="loading_image" >')

}

    $('#loading_image').show(); // show the animated image    

     // disable double submits

    return true; // allow regular form submission

});

</script>



<?php

	$this->load->view("client/footer");

?>