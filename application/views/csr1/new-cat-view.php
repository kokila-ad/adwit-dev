<?php
	$this->load->view("csr/header1");
?>
<script type="text/javascript">
	
	$(document).ready(function(e) {    

		
		$('#priority').change(function(e) {
            if($("#priority").attr("checked")) $('#ad-form-sr-custom').show();
			else $('#ad-form-sr-custom').hide();
        });	
		
		 if($("#priority").attr("checked")) $('#ad-form-sr-custom').show();
		else $('#ad-form-sr-custom').hide();
		
		
	});
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
      <form name="form" method="post" action="<?php echo base_url().index_page().'csr/home/adwit_category';?>">
   <div id="ad-form">
         <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
        <input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no'); ?><?php if(isset($order))echo $order[0]['id'];?>" autocomplete="off" >


	<p class="contact"><label for="name">Job Name</label></p>
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?><?php if(isset($order)){if($order[0]['publication_id']=='26'){echo $order[0]['job_no'];}else{echo $order[0]['job_no']."_".$order[0]['advertiser_name'];}}?>" autocomplete="off" required >
        
            <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('width');?><?php if(isset($order))echo $order[0]['width'];?>" id="width" name="width" autocomplete="off" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input onChange="fill()"  id="height" name="height" value="<?php echo set_value('height');?><?php if(isset($order))echo $order[0]['height'];?>" autocomplete="off"  />
	
	<p class="contact"><label for="name">Adrep Name</label></p>
		<?php if(isset($order)){ $adrep = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array(); } ?>
        <input name="adrep" type="text" value="<?php echo set_value('adrep');?><?php if(isset($order))echo $adrep[0]['first_name'];?>" autocomplete="off" required >
        	
   
	<p class="contact"><label for="name">Advertiser Name</label></p>
        <input name="adv_name" type="text" value="<?php echo set_value('adv_name');?><?php if(isset($order))echo $order[0]['advertiser_name'];?>" autocomplete="off" required >
        
        	<p class="contact" style="padding-top:15px;"><label for="name">Newspaper</label></p>
	<?php
	$newspaper = $this->db->query("SELECT * FROM `cat_newspaper` WHERE `status`='1' ORDER BY `name` ASC;")->result_array();
	?>
	<select class="select-style gender"  name="cat_news" id="cat_news" >
	<option value=""> select </option>
	<?php
	foreach($newspaper as $cn)
	{
		echo '<option value="'.$cn['id'].'" '.($order[0]['publication_id']==$cn['publication'] ? 'selected="selected"': '').set_select('cat_news',$cn['id']).'>'.$cn['name'].'</option>';	
	}	
	?>
	</select>

 
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
	
		<p class="contact" style="padding-top:15px; padding-bottom: 10px;"><label for="name">CSR Instruction</label></p>
	<textarea name="instruction" rows="2" cols="50" ><?php echo set_value('instruction');?></textarea>

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
		<input value="<?php echo set_value('publication');?><?php if(isset($order))echo $order[0]['publication_id'];?>" id="publication" name="publication" autocomplete="off" readonly style="visibility:hidden" />
        <input class="buttom" type="submit" name="submit" value="SUBMIT" style="width:20%" />
       <a href= "http://www.adwitads.com/weborders/index.php/csr/home/new_category"><input class="buttom" id="button" type="button" name="button" value="Reset" style="width:20%"></a>
        </div>
  

<div id="confirm" style="width:300px; margin: 0 auto; text-align: center;">
<?php
	if(isset($error))
	{
		echo "<div style='font-weight: bold; color:#F00;'>".$error."</div>";
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

  <?php
	$this->load->view("csr/footer");
?>









