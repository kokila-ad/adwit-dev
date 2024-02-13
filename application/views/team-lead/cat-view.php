<?php
	$this->load->view("team-lead/header"); 
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
<script type='text/javascript' src='js/jquery-1.6.1.min.js'></script>
<script type="text/javascript">

function Search(){
								
	var order_Number = document.getElementById("order_no").value;
	//alert(order_Number);
	jQuery.ajax({
					url:		"/application/Search.php",
					data: 		'action=getStaff&order_Number='+order_Number, 
					cache:		false, 
					type: 		'POST', 									
					success:	function(msg){
									jQuery('#txt_Search').html(msg);
									} 
				});
			
	}
	
</script>

<style>

#confirm input {
	background: #333; color: #FFF; border: 0;
}

</style>

	<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
 

<div id="Middle-Div">
		<p style="padding:0 0 0 10px; margin:0;"><?php echo validation_errors(); ?></p>
   <div id="order_form">
 
   <div id="ad-form">
         <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
        <input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no');?>" autocomplete="off">
	
<button  class="Search"  id="Search" onclick="Search()" style="margin-left: 200px;">Search</button>

<div id="txt_Search"> </div>

</div>
<form name="form" method="post">
<div id="ad-form">	
   <p class="contact"><label for="name">Job Name</label></p>
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?>" autocomplete="off">

   <p class="contact"><label for="name">Ad Type</label></p>
   <?php $results = $adtype;
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="adtype" id="adtype" value="'.$result['id'].'" '.set_radio('adtype',$result['id']).' onClick="run(this.value);" required="required" style="width:5%;"><label>'.$result['name'],'</label>';
     		echo '<br/>';
		}
	?>
 
   </div>
   
   <div id="ad-form-s-r">
    <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('width');?>" id="width" name="width" autocomplete="off" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input onChange="fill()"  id="height" name="height" value="<?php echo set_value('height');?>" autocomplete="off" />
 	<p class="contact"><label for="name">No of Options</label></p>
        <select class="select-style gender" id="no_pages" name="no_pages" >

   	<option value="1" <?php echo set_select('no_pages', '1');?> >1</option>
	<!--<option value="2" <?php echo set_select('no_pages', '2');?> >2</option>
	<option value="3" <?php echo set_select('no_pages', '3');?> >3</option>
	<option value="4" <?php echo set_select('no_pages', '4');?> >4</option>
	<option value="5" <?php echo set_select('no_pages', '5');?> >5</option>      
     -->   
    </select>


	<p class="contact" style="padding-top:15px;"><label for="name">Art Instruction</label></p>
        <?php $results = $artinst;
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="artinst" id="artinst" value="'.$result['id'].'" '.set_radio('artinst',$result['id']).' onClick="run1(this.value);" required="required" style="width:5%;"><label>'.$result['name'].'</label>';
     		echo '&nbsp';
		}
		?>
	<p class="contact" style="padding-top:15px;"><label for="name">Newspaper</label></p>
        <?php $cat_news = $newspaper;?>
		
	<select class="select-style gender"  name="cat_news" id="cat_news">
	<option value=""> select </option>
	<?php
	foreach($cat_news as $cn)
	{
		echo '<option value="'.$cn['initials'].'|'. $cn['slug_type'].'" '.set_select('cat_news',$cn['initials'].'|'. $cn['slug_type']).' >' .$cn['name'].'</option>';
	}
	?>
	</select>
	
     </div>
   <div id="ad-form-s4">        
        <input class="buttom" type="submit" name="submit" value="SUBMIT" style="width:20%" />
       <a href="http://www.adwitads.com/weborders/index.php/team-lead/home/category"><input class="buttom" id="button" type="button" name="button" value="Reset" style="width:20%"></a>
	   <div style="display:none;">
       </div>
        </div>
   </div>


<div id="Back-btn"><a href="<?php echo base_url().index_page().'team-lead/home/';?>">Back</a></div>
  
  
 <div id="confirm" style="width:300px; margin: 0 auto; text-align: center;">
<?php
	if(isset($error))
	{
		echo $error;
	}
	elseif(isset($category))
	{
		echo "Category : ".$category;
?>		
<div style="padding-top: 15px;">
<input  type="submit" name="confirm" id="confirm" value="Confirm">
<!--<a href="http://www.adwitads.com/weborders/index.php/team-lead/home/category"><input id="button" type="button" name="button" value="Reset"></a>-->
<input name="category" value="<?php echo($category)?>" readonly style="visibility:hidden" />
</div>
<?php
	}
?>
</div>
</form>
</div>
</div>
  <?php
	$this->load->view("team-lead/footer");
?>









