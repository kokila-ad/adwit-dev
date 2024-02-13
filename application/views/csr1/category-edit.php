<?php
	$this->load->view("csr/header1");
?>

<style>
#confirm input {
	background: #333; color: #FFF; border: 0;
}
</style>
<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	
<p style="padding:0 0 0 20px; margin:0;">
 <?php if(isset($error1))
	   {
		 echo "<div style='font-weight: bold; color:#F00;'>".$error1."</div>";
	   }
 ?>
</p>
<div id="Middle-Div">

	<p style="padding:0 0 0 10px; margin:0;"><?php echo validation_errors(); ?> </p>
	
   <div id="order_form">
      <form name="form" method="post" >
   <div id="ad-form">
         <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
        <input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no'); ?><?php if(isset($order))echo $order[0]['order_no'];?>" autocomplete="off" >

   <p class="contact"><label for="name">Job Name</label></p>
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?><?php if(isset($order))echo $order[0]['job_name'];?>" autocomplete="off" required >

	
   <p class="contact"><label for="name">Ad Type</label></p>
	<?php $adtypes = $this->db->get('cat_new_adtype')->result_array(); ?>
     <select class="select-style gender"  name="adtype" id="adtype" >
			<option value=""> select </option>
			<?php
				foreach($adtypes as $adtype)
				{
					echo '<option value="'.$adtype['id'].'" '.($adtype['id']==$order[0]['adtypewt'] ? 'selected="selected"': '').set_select('adtype',$adtype['id']).'>'.$adtype['name'].'</option>';	
				}	
			?>
	</select>
 
   </div>
   
   <div id="ad-form-s-r">
    <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('width');?><?php if(isset($order))echo $order[0]['width'];?>" id="width" name="width" autocomplete="off" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input   id="height" name="height" value="<?php echo set_value('height');?><?php if(isset($order))echo $order[0]['height'];?>" autocomplete="off"  />
 
	<p class="contact" style="padding-top:15px;"><label for="name">Art Instruction</label></p>
		<?php $artinstructions = $this->db->get('cat_artinstruction')->result_array(); ?>
        <select class="select-style gender"  name="artinstruction" id="artinstruction" >
			<option value=""> select </option>
			<?php
				foreach($artinstructions as $artinstruction)
				{
					echo '<option value="'.$artinstruction['id'].'" '.($artinstruction['id']==$order[0]['artinstruction'] ? 'selected="selected"': '').set_select('artinstruction',$artinstruction['id']).'>'.$artinstruction['name'].'</option>';	
				}	
			?>
		</select>

	
	
	
	<p class="contact" style="padding-top:15px;"><label for="name">Newspaper</label></p>
	<?php
	$newspaper = $this->db->query("SELECT * FROM `cat_newspaper` WHERE `status`='1' ORDER BY `name` ASC;")->result_array();
	?>
	<select class="select-style gender"  name="cat_news" id="cat_news" >
	<option value=""> select </option>
	<?php
	foreach($newspaper as $cn)
	{
		echo '<option value="'.$cn['id'].'" '.($order[0]['news_id']==$cn['id'] ? 'selected="selected"': '').set_select('cat_news',$cn['id']).'>'.$cn['name'].'</option>';	
	}	
	?>
	</select>
	</div>

   <div id="ad-form-s4">        
        <input class="buttom" type="submit" name="Submit" value="SUBMIT" style="width:20%" />
		<input class="buttom" type="reset" value="CLOSE" style="width:20%" onclick="javascript:if(confirm('Close window?'))window.close();"/>
	</div>
  

<div id="confirm" style="width:300px; margin: 0 auto; text-align: center;">
<?php
	if(isset($error))
	{
		echo "<div style='font-weight: bold; color:#F00;'>".$error."</div>";
	}
	elseif(isset($category))
	{
		echo "<div style='font-weight: bold; color:#0000FF;'> Category : ".$category."</div>";
?>		
<div style="padding-top: 15px;">
<input  type="submit" name="confirm" id="confirm" value="Confirm">
<input name="category" value="<?php echo($category)?>" readonly style="visibility:hidden" />
</div>
</div>
</form>
</div>
<div id="Back-btn"><a href="<?php echo base_url().index_page().'csr/home/';?>">Back</a></div>
<?php
	}
?>
</div>

  <?php
	$this->load->view("csr/footer");
?>









