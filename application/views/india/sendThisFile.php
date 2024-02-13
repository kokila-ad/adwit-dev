<?php
	$this->load->view("india/header");
?>
<div id="container">
<div id="content">
    <div class="form">

    <p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #090;">Your order has been placed. Please attach files here!</p>      
	<p style="padding: 10px; text-align:center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px;"><?php if (isset($error)){echo $error; } ?></p>
    
    <form action="index.php/india/home/setfolder" method="POST" enctype="multipart/form-data" style="width: 400px; margin:0 auto;">
	<table align="center" width="400px" border="0" cellspacing="0" cellpadding="0" style="background-color:#e8e8e8; border:1px solid #333; font-family:Tahoma, Geneva, sans-serif; padding:0; margin:0;">
	<tr>
		<td style="background-color:#000;"><p style="text-align:center; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#FFF; padding: 10px; margin: 0;">Upload File</p></td>
	</tr>
	
	<!--<tr>
		<td style="text-align:center;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><b style="font-size:12px;">&nbsp;&nbsp;File 1</b> 
		<input type="file" size="20" name="userfile[]" id="filename1" onkeypress="this.click(); return false;" class="input" required="required" multiple><br/>
	-->
	<tr> 
		<td style="text-align:center;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><b style="font-size:12px;">&nbsp;&nbsp;File 1</b> 
		<input type="file" name="ufile[]" id="ufile[]" value="upload" onkeypress="this.click(); return false;" class="input" required="required"/>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><b style="font-size:12px;">&nbsp;&nbsp;File 2</b> 
		<input type="file" name="ufile[]" id="ufile[]" value="upload"/><br/>
   		</td>
	</tr>
    <tr>
		<td style="text-align:center;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><b style="font-size:12px;">&nbsp;&nbsp;File 3</b> 
		<input type="file" name="ufile[]" id="ufile[]" value="upload" /><br/>
   		</td>
	</tr>
    <tr>
		<td style="text-align:center;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><b style="font-size:12px;">&nbsp;&nbsp;File 4</b> 
		    <input type="file" name="ufile[]" id="ufile[]" value="upload" /><br/>
   		</td>
	</tr>
    <tr>
		<td style="text-align:center;"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;"><b style="font-size:12px;">&nbsp;&nbsp;File 5</b> 
		<input type="file" name="ufile[]" id="ufile[]" value="upload"/><br/>
   		</td>
	</tr> 
		<br/>
        <tr>
		<td><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">
        <input type="submit" name="submit" class="submit" value="Upload" onclick="show_me(this.form.file_name)" />
		<br/></p></td>
	</tr>
			
         <tr>
    	<td><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;">
        	Or&nbsp;<a href="<?php echo base_url().index_page()."india/home/neworder";?>" style="text-decoration:none; font-weight: bold; color:#C33;">Place New Order</a>
        </p></td>
    </tr>
</table>
</form> 
<div>&nbsp;</div> 
      <!--  <iframe src="https://www.sendthisfile.com/filebox/index.jsp?widgetcode=x9vKYbjIi8OCHEnwkSSa8AHu" marginwidth="0" marginheight="0" width="350" height="350" scrolling="no" frameborder="0"></iframe> -->
                
    </div>
</div></div><!-- #content-->

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
	$this->load->view("india/footer");
?>