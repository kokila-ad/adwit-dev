<?php
	$this->load->view("client/header1");
?>
<!-- Middle Starts -->
<div id="Middle-Div">
<div id="stf-m">
    Your order has been placed. Please attach files here!
    </div>
    <div id="stf-f">&nbsp;</div>
     <form action="index.php/client/home/setfolder" method="POST" enctype="multipart/form-data">
    <div id="stf-fa">
    <h2>Upload File!</h2>
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
    <input type="submit" name="submit" class="submit" value="Upload" onclick="show_me(this.form.file_name)" />
    </div>
    </div>
    </form>
    <div id="stf-fb">&nbsp;</div>
    <div id="stf-npb">
    or <a href="<?php echo base_url().index_page()."client/home/neworder";?>" >Place New Order</a>
    </div>
  <div id="Back-btn"><a href="client_tab.html">Back</a></div>              
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