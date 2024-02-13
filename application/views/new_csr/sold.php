<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("csr/header");
	
?>
<style>

#slug-error input{
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}

</style>

<div id="Middle-Div">

<form name="form" method="post">
 
    <h2>SOLD</h2>
    <p><label for="name">Order No</label></p>
    <input type="text" name="id" id="id" placeholder="Copy & Paste Order No" required />
    <p style="padding: 0; margin: 0;">&nbsp;</p>
    <div id="slug-btn">
    <input type="submit" name="search"  />
    </div>
<div id="slug-error">
	 <?php if(isset($status)) echo "<p>".  $status ."</p>";	?>
</div>
 </form>

<div id="Back-btn"><a href="<?php echo base_url().index_page().'csr/home/';?>">Back</a></div>
</div>

<?php
	$this->load->view("csr/footer");
	
?>