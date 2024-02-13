<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("designer/header");
	
?>

<style>
#slug-view input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #38b6ff;
	border-radius: 5px;
}

#slug-btn input {
	font-size: 14px;
	color: #FFF;
	background: #38b6ff;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}

#dp-view input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #ff7070;
	border-radius: 5px;
	width: 60%;
	outline: none;
}
#dp-view h2 {
	font-weight: normal;
	padding: 0 0 20px 0;
	margin: 0;
}

#dp-view p {
	padding: 0 0 5px 0;
	margin: 0px;
}

#dp-view-btn {
	padding-top: 15px;
	width: 45%;
}

#dp-view-btn input {
	font-size: 14px;
	color: #FFF;
	background: #ff7070;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}

#slug-error input{
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}

#rev-sold {
	clear: both;
	float: left;
	padding: 10px 0;
	margin-left: 5%;
	width: 90%;
	display: block;
}

</style>

<div id="Middle-Div">
<div id="slug-view">
<form name="form" action="<?php echo base_url().index_page().'designer/home/revision';?>" method="post">
 
    <h2>REVISION</h2>
    <p><label for="name">Slug</label></p>
    <input type="text" name="id" id="id" placeholder="Copy & Paste Slug" required />
    <p style="padding: 0; margin: 0;">&nbsp;</p>
	<p><label for="name">Chekker (Checked By) </label></p>
	<p style="padding: 0; margin: 0;">&nbsp;</p>
	<select class="select-style gender" id="csr" name="csr" required >
          <option value="">Select</option>
          <?php
					foreach($csr as $result)
					{
						echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>';	
					}
				?>
     </select>
	  <p style="padding: 0; margin: 0;">&nbsp;</p>
    <div id="slug-btn">
    <input type="submit" name="search"  />
    <p style="padding: 0; margin: 0;">&nbsp;</p>
    </div>
<div id="slug-error">
	 <?php if(isset($r_status)) echo "<p>".  $r_status ."</p>";	?>
</div>
 </form>
 </div>
 
<div id="dp-view">
<form name="form" action="<?php echo base_url().index_page().'designer/home/sold';?>" method="post">
 
    <h2>SOLD</h2>
    <p><label for="name">Slug</label></p>
    <input type="text" name="id" id="id" placeholder="Copy & Paste Slug" required />
    <p style="padding: 0; margin: 0;">&nbsp;</p>
    <div id="dp-view-btn">
    <input type="submit" name="search"  />
    </div>
<div id="slug-error">
	 <?php if(isset($s_status)) echo "<p>".  $s_status ."</p>";	?>
</div>
 </form>
</div>

<div id="Back-btn"><a href="<?php echo base_url().index_page().'designer/home/';?>">Back</a></div>
</div>

<?php
	$this->load->view("designer/footer");
	
?>