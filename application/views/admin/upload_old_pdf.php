<?php echo $this->session->set_flashdata('message');?>
<center><form name="form" method="post">
		<label>Enter Adwit Id here</label><input type="text" placeholder="Search" name="adwit_id" required>
		<button type="submit" name="search">Search</button>

</form> 

<?php if(isset($orders)) { ?>
<form method="post" enctype="multipart/form-data">
<input type="file" name="ufile" id="ufile" required>
<input type="text" name="pdf_id" id="pdf_id" value="<?php echo $orders[0]['id']; ?>"  readonly style="display:none" />
<input type="submit" name="file_submit" value="Submit">
</form>
<?php } ?> 
</center>