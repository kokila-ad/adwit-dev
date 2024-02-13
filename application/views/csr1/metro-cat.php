<?php
	$this->load->view("csr/header");
?>
<body>
<div id="container">
<div id="form">


  <form enctype='multipart/form-data' method='post'>

  File name to import:<br />

  <input size='50' type='file' name='filename'><br />

  <input type='submit' name='filesubmit' value='Upload'>
  </form>

</div>
</div>
</body>
<?php
if(isset($handle)):
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
			$order_no = $data[0];
			$job_name = $data[2];
			$width = $data[17];
			$height = $data[18];
			$advertiser = $data[10];
		} 
		fclose($handle); 
?>

<div id="Middle-Div">
		<p style="padding:0 0 0 10px; margin:0;"><?php //echo validation_errors(); ?></p>
   <div id="order_form">
      <form name="form" method="post">
   <div id="ad-form">
         <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
        <input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no', $order_no);?>" autocomplete="off">
   <p class="contact"><label for="name">Job Name</label></p>
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?>" autocomplete="off">
		
        <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('width');?>" id="width" name="width" autocomplete="off" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input onChange="fill()"  id="height" name="height" value="<?php echo set_value('height');?>" autocomplete="off" />

	<p class="contact"><label for="name">Advertiser Name(Client Name)</label></p>
        <input name="advertiser" type="text" value="<?php echo set_value('advertiser');?>" autocomplete="off">
        
           <p class="contact"><label for="name">Adrep Name(Sales rep)</label></p>
        <select class="select-style gender"  name="adrep" id="adrep">
	<option value=""> select </option>
	<?php
	foreach($adreps as $row)
	{
		
		echo '<option value="'.$row['id'].'" '.set_select('adrep',$row['id']).' >' .$row['name'].'</option>';
	}
	?>
	</select>
        
            <p class="contact"><label for="name">CSR Instruction</label></p>
	<textarea name="instruction" rows="2" cols="50" ><?php echo set_value('instruction');?></textarea>
        
 
   </div>
   
   <div id="ad-form-s-r">  
    
 
<div style=" display: none;">	<p class="contact"><label for="name">No of Options</label></p>
        <select class="select-style gender" id="no_pages" name="no_pages" >

   	<option value="1" <?php echo set_select('no_pages', '1');?> >1</option>
	<!--<option value="2" <?php echo set_select('no_pages', '2');?> >2</option>
	<option value="3" <?php echo set_select('no_pages', '3');?> >3</option>
	<option value="4" <?php echo set_select('no_pages', '4');?> >4</option>
	<option value="5" <?php echo set_select('no_pages', '5');?> >5</option> -->     
         
    </select> </div>
    
       <p class="contact"><label for="name">Ad Type</label></p>
        <?php $results = $adtype;
		
		foreach($results as $result)
		{
			echo '<input type="radio" name="adtype" id="adtype" value="'.$result['id'].'" '.set_radio('adtype',$result['id']).' onClick="run(this.value);" required="required" style="width:5%;"><label>'.$result['name'],'</label>';
     		echo '<br/>';
		}
	?>

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
		//echo '<option value="'.$cn['initials'].'|'. $cn['slug_type'].'" '.set_select('cat_news',$cn['initials'].'|'. $cn['slug_type']).' >' .$cn['name'].'</option>';
		echo '<option value="'.$cn['id'].'" '.set_select('cat_news',$cn['id']).' >' .$cn['name'].'</option>';
	}
	?>
	</select>
   
	
	<div style="font-weight: bold; color:#F00;">Frontline Immediate&nbsp;<input type="checkbox" name="priority" id="priority" value="1"<?php echo set_checkbox('priority', '1');?> style=" padding:0; margin-left: -200px; margin-top: -10px;" /></div>
	 <div id="ad-form-sr-custom">
		Select Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('help_desk')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.set_select('help_desk',$type['id']).'>'.$type['name'].'</option>';	
				}
			?>
            </select>
	 
	 </div>
	  </div>
   <div id="ad-form-s4">        
        <input class="buttom" type="submit" name="submit" value="SUBMIT" style="width:20%" />
       <a href="http://www.adwitads.com/weborders/index.php/csr/home/category"><input class="buttom" id="button" type="button" name="button" value="Reset" style="width:20%"></a>
        </div>
   </div>


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


<?php endif; ?>


<?php
	$this->load->view("csr/footer");
?>