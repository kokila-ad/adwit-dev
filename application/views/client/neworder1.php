<?php
	$this->load->view("client/header1");
?>


 <div id="Middle-Div">
 <form accept-charset="utf-8" method="post" action="<?php echo base_url().index_page().'client/home/neworder';?>">
  <div id="Select_Form">
      <div id="Select-Form-Txt">
	  
      Select Your Order Type&nbsp;&nbsp;
	  
      </div>
<div id="Select-Form-Tab">
<select id="ad_type" name="ad_type" onchange="this.form.submit()">
	<option value="">Select</option>
	
	<?php
				foreach($types as $type)
				{
					echo '<option value="'.$type['value'].'" '.($form==$type['value'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>

</select>
</div>
    </div>
    </form>
    <div id="Back-btn"><a href="<?php echo base_url().index_page().'client/home/home/';?>">Back</a></div>
</div>



<?php
	$this->load->view("client/footer");
?>