<?php $this->load->view('new_csr/head');?>
				
							
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="color-picker/jquery.miniColors.css" />
<script language="JavaScript" src="color-picker/jquery.miniColors.js"></script>


 <div class="page-content">
		<div class="container">
        <div class="row">
		<div class="portlet light">
     
      <div id="ad-form-p"><strong>Request Details</strong></div>
      <div id="ad-form-s">
      <form method="post" enctype="multipart/form-data">      
		<div id="ad-form-s-l">
        <p class="contact"><label for="name">Id : </label><label><?php echo $request[0]['id'];?></label></p>
        </div>
		<div id="ad-form-s-l">
        <p class="contact"><label for="name">Adrep Id : </label>
		<label><?php $adrep = $this->db->get_where('adreps',array('id' => $request[0]['adrep_id']))->result_array();
								echo $adrep[0]['first_name']; ?></label></p>
        </div>
	   <div id="ad-form-s-l">
        <p class="contact"><label for="name">Subject : </label><label><?php echo $request[0]['subject'];?></label></p>
        </div>
       <div id="ad-form-s-l">
        <p class="contact"><label for="name">Message : </label><label><?php echo $request[0]['message'];?></label></p>
        </div>
		<div id="ad-form-s-l">
        <p class="contact"><label for="name">Attachments : </label></p>
		<a href="<?php echo base_url().$request[0]['filepath'];?>"><?php echo $request[0]['filepath'];?></a>
		</div>
		<div id="ad-form-s-l">
        <p class="contact"><label for="name">Your Message : </label><input type="text" name="csr_msg"></p>
        </div>
		<div id="ad-form-s-l">
        <p class="contact"><label for="name">New Attachments : </label></p>
		<input type="file" name="userfile" id="userfile" value="upload"/><br/><br/>
		
        </div>
		
		
		<table>
		<?php $request_id = $this->db->get_where('requests_details',array('request_id'=> $request[0]['id'] ))->result_array(); 
		foreach($request_id as $row)
		{
		?>
		<tr>
			<td>Attachments :</td>
			<td><?php if(isset($row['filepath']))
						{	
				?>
				<a href="<?php echo base_url().$row['filepath'];?>"><?php echo $row['filepath'];?></a>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>Message :</td>
			<td><?php if(isset($row['message']))
						{ 
				?>
				<a href="<?php echo base_url().$row['message'];?>"><?php echo $row['message'];?></a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		</table>
		
       <div id="ad-form-s4"> 
		<button type="submit" class="btn btn-primary btn-lg margin-right-15" name="submit" type="submit">  <span>Reply</span> </button>		

        </div>
		
      </form>
      
    </div>   
</div>
</div>
</div>
</div>


<?php $this->load->view('new_csr/foot');?>