<?php
	$this->load->view("csr/header");
?>
	 <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<script type="text/javascript">
<?php if(!isset($hd)){?>
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/new_cat/';?>" + $('#help_desk').val() ;
        });
    });
	
<?php }elseif(isset($hd) && !isset($publication)){ ?>	

	$(document).ready(function(e) {
        $('#publication').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/new_cat/'.$hd.'/';?>" + $('#publication').val() ;
        });
    });
<?php }else{ ?>	
	$(document).ready(function(e) {
        $('#adrep').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/new_cat/'.$hd.'/'.$publication.'/';?>" + $('#adrep').val() ;
        });
    });
<?php } ?>
</script>

<script>
function handleChange(input) {
    if (input.value <= 0) input.value = 0;
    if (input.value >= 100) input.value = 99;
  } 
</script>

<style>
#confirm input {
	background: #333; color: #FFF; border: 0;
}
</style>

	<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">

<div id="Middle-Div">
<p style="text-align:center;"> 
<?php if(!isset($hd)){?>
        	Select Your Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($hd==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
<?php }elseif(isset($hd) && !isset($publication)){ ?>	
			Select Your Publication:&nbsp;
        	<select id="publication" name="publication">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get_where('publications',array('help_desk'=>$hd, 'is_active'=>'1'))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($publication==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
<?php }else{ ?>	
			Select Your Adrep:&nbsp;
        	<select id="adrep" name="adrep">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get_where('adreps',array('publication_id'=>$publication, 'is_active'=>'1'))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($adrep==$type['id'] ? 'selected="selected"' : '').'>'.$type['first_name'].' '.$type['last_name'].'</option>';	
				}
			?>
            </select>
<?php } ?>	OR	
</p>

<p><form method="post" style="text-align: center;">
               <span>Adrep Search:  </span><input type="text" name="adrep" id="adrep" placeholder="search" />
               <input type="submit" name="Search" value="Submit" />
   </form></p>
<div class="block">
<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; ?>
<?php if(isset($hd) && isset($adrep_list)){ ?>	<!--adrep search-->

<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<div class="block" style="width: 85%; margin:0 auto;">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Ad Rep List</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span9">
  									<table class="table">
						              <thead>
						                <tr>
						                  <th>Name</th>
						                  <th>Publication</th>
                                          <th>Action</th>
						                </tr>
						              </thead>
						              <tbody>
                                      <?php foreach($adrep_list as $row){ $pub_name = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();?>
						                <tr>
						                  <td><?php echo $row['first_name']; ?> <?php  echo $row['last_name']; ?></td>
						                  <td><?php  echo $pub_name[0]['name']; ?></td>
                                          <td><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/new_cat/'.$hd.'/'.$row['publication_id'].'/'.$row['id'];?>'" style="cursor:pointer; text-decoration: none;">Select</a></td>
						                </tr>
                                        <?php } ?>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
	
<?php  } ?>
</div>

<?php if(isset($hd)&&isset($publication)&&isset($adrep)): 
	$publications = $this->db->get_where('publications',array('id' => $publication))->result_array();
	$adreps = $this->db->get_where('adreps',array('id' => $adrep))->result_array();

	echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>';
?>
		
		<p style="padding:0 0 0 10px; margin:0;"><?php echo validation_errors(); ?></p>
   <div id="order_form">
      <form name="form" method="post" enctype="multipart/form-data">
   <div id="ad-form"> 
         <div id="ad-form-h">Publication Name: <?php echo $publications[0]['name']; ?></div>
		 <div id="ad-form-h">Adrep Name: <?php echo $adreps[0]['first_name']; ?></div>
   <div id="ad-form-s-l">
   <!--<p class="contact"><label for="name">Order No</label></p> -->
        <input type="text" id="order_no" name="order_no" value="<?php if(isset($order_no))echo $order_no; ?>" autocomplete="off" readonly style="visibility:hidden" /> 
   <p class="contact"><label for="name">Unique Job Name Number</label></p>
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?>" autocomplete="off">
		
        <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('width');?>" id="width" name="width" autocomplete="off" onchange="handleChange(this);" />
	
	<p class="contact"><label for="name">Height</label></p>
        <input id="height" name="height" value="<?php echo set_value('height');?>" autocomplete="off" onchange="handleChange(this);" />

<!--<?php if($hd=='2') { $modular_size = $this->db->get('modular_sizes')->result_array(); ?>
	<p class="contact"><label for="name">Modular Size</label></p>
        <select class="select-style gender"  name="mod_size" id="mod_size" required >
			<option value=""> select </option>
			<?php
			foreach($modular_size as $row)
			{
				echo '<option value="'.$row['id'].'" '.set_select('mod_size',$row['id']).' >' .$row['name'].'</option>';
			}
			?>
		</select>
<?php }?>

<?php if($hd=='0') { $classification = $this->db->get('cat_classification')->result_array(); ?>
	<p class="contact" style="padding-top:15px;"><label for="name">Classification</label></p>
	<select class="select-style gender"  name="cat_class" id="cat_class" required >
	<option value=""> select </option>
	<?php
	foreach($classification as $row)
	{
		echo '<option value="'.$row['id'].'" '.set_select('cat_class',$row['id']).' >' .$row['name'].'</option>';
	}
	?>
	</select>
<?php }?>-->
		
	<p class="contact"><label for="name">Advertiser Name(Client Name)</label></p>
        <input name="advertiser" type="text" value="<?php echo set_value('advertiser');?>" autocomplete="off">
        
   <!-- <p class="contact"><label for="name">Date Needed</label></p>
       <input name="date_needed" type="text" value="<?php echo set_value('date_needed');?>" > -->
	   
	<p class="contact"><label for="name">Copy/Content <span class="mandatory">*</span></label></p>
        <textarea name="copy_content_description" id="copy_content_description" ><?php echo set_value('copy_content_description');?></textarea>
    <!--<p class="contact"><label for="name">Notes & Instructions</label></p>
        <textarea id="notes" name="notes"><?php echo set_value('notes');?></textarea>-->
        
   </div>
   
   <div id="ad-form-s-r">  
  
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
	<p class="contact" style="padding-top:15px;"><label for="name">Order Type</label></p>
        <?php $results = $order_type;
		
		foreach($results as $result)
		{
		?>
			<input type="radio" name="order_type" id="order_type" value="<?php echo $result['id']; ?>" <?php echo set_radio('order_type',$result['id']); if($result['id']=='2')echo"checked='checked'"; ?> style="width:5%;"><label><?php echo $result['name']; ?></label>
     	<?php	
			echo '&nbsp';
		}
		?>
		
	<!--   <p class="contact"><label for="name">CSR Instruction</label></p>
	<textarea name="instruction" rows="2" cols="50" ><?php echo set_value('instruction');?></textarea>
   -->
	<p class="contact"><label for="name">Full Color/B&W/Spot <span class="mandatory">*</span></label></p>
        <select class="select-style gender" id="print_ad_type" name="print_ad_type">
          <option value="">Select</option>
          <?php
					$results = $print_ad_types;
					foreach($results as $result)
					{
						echo '<option value="'.$result['id'].'" '.set_select('print_ad_type',$result['id']).' >'.$result['name'].'</option>';	
					}
				?>
        </select>
	<!--<p class="contact"><label for="name">Job Instruction </label></p>
        <select class="select-style gender" id="job_instruction" name="job_instruction">
        <option value="">Select</option>
        <option value="1" <?php echo set_select('job_instruction','1');?> >Follow Instructions Carefully</option>
        <option value="2" <?php echo set_select('job_instruction','2');?> >Be Creative</option>
      </select>
	  -->
	  
  
     
	<!--<div style="font-weight: bold; color:#F00;">Frontline Immediate&nbsp;<input type="checkbox" name="priority" id="priority" value="1"<?php echo set_checkbox('priority', '1');?> style=" padding:0; margin-left: -200px; margin-top: -10px;" /></div>
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
	 
	 </div>-->
	  </div>
	
	<div id="ad-form-s3">
       <div style="max-width: 400px; margin: 0 auto;">
       <p style="text-align: center;"><label for="name">Attach File</label></p>
      
		<label for="name">File 1 </label> <input class="input-file uniform_on" type="file" name="ufile[]" id="ufile[]" value="upload" /> <br><br>
        <label for="name"> File 2 </label> <input type="file" name="ufile[]" id="ufile[]" value="upload" />
        </div>
    </div>
	 
   <div id="ad-form-s4">        
        <input class="buttom" type="submit" name="Submit" value="SUBMIT" style="width:20%" />
       <a href="<?php echo base_url().index_page().'csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep; ?>"><input class="buttom" id="button" type="button" name="button" value="Reset" style="width:20%"></a>
        </div>
   </div>

<!--
<div id="confirm" style="width:300px; margin: 0 auto; text-align: center;">
<?php
	if(isset($error))
	{
		echo $error;
	}
	elseif(isset($category))
	{
		//echo "Category : ".$category;
?>		
<div style="padding-top: 15px;">
<input  type="submit" name="confirm" id="confirm" value="Confirm">
<input name="category" value="<?php echo($category)?>" readonly style="visibility:hidden" />
</div>
</div>-->
</form>
</div>
<div id="Back-btn"><a href="<?php echo base_url().index_page().'csr/home/';?>">Back</a></div>
<?php
	}
?>
<?php  endif;?>
</div>

  <?php
	$this->load->view("csr/footer");
?>









