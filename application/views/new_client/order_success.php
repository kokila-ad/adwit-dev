<?php $this->load->view('new_client/header'); ?>

 <style>
	.dropzone {
    display: block;
    background-image: url(../img/attachment.png);
}

.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}

.lightbox-opened {
  background-color: #333;
  background-color: rgba(51, 51, 51, 0.9);
  cursor: pointer;
  height: 100%;
  left: 0;
  overflow-y: scroll;
  padding: 24px;
  position: fixed;
  text-align: center;
  top: 0;
  width: 100%;
}
.lightbox-opened:before {
  background-color: #333;
  background-color: rgba(51, 51, 51, 0.9);
  color: #eee;
  content: "x";
  font-family: sans-serif;
  padding: 6px 12px;
  position: fixed;
  text-transform: uppercase;
}
.lightbox-opened img {
  box-shadow: 0 0 6px 3px #333;
}

.no-scroll {
  overflow: hidden;
}
.awemenu-nav {
   z-index: 0 !important;
}
#header{
    display: contents !important;
	}
</style>

<script>
Dropzone.options.moodboard_upload = {
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 8, // MB
  clickable : true,
  uploadMultiple :true,
  addRemoveLinks:true,
  dictRemoveFile="Remove File",
  dictDefaultMessage="Hey Yo"
 
};
</script>
<style class="cp-pen-styles">



/** LIGHTBOX MARKUP **/

.lightbox {
	/** Default lightbox to hidden */
	display: none;

	/** Position and style */
	position: fixed;
	z-index: 999;
	width: 100%;
	height: 100%;
	text-align: center;
	top: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
}

.lightbox img {
	/** Pad the lightbox image */
	max-width: 90%;
	max-height: 80%;
	margin-top: 2%;
}

.lightbox:target {
	/** Remove default browser outline */
	outline: none;

	/** Unhide lightbox **/
	display: block;
}
.thumbnail {
    display: block;
   /*height: 100px;*/
    width: 120px;
        padding: 0px;
    margin-bottom: 17px;
}
/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
  opacity: 2.2;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}
</style>


<style>
.side_alignr{
    position: relative !important;
    left: 5px !important;
	}
	.side_alignl{
    position: relative !important;
    right: 5px !important;
	}
.thumbnail {
    display: block;
       padding: 0px !important;
    margin-bottom: 20px;
    line-height: 1.42857;
    background-color: #fff !important;
    border: 0px solid #ddd !important;
    border-radius: 0px !important;
    transition: border 0.2s ease-in-out;
}
.file_li {
   // width: 350px;
	min-width: 250px;
   // overflow-x: hidden;
}
.radiobtn {
    margin-left: 40.66667% !important;
	
}
.outer{
    line-height: 1.42857;
    background-color: #fff;
    border: 1px solid #fff;
	}

	.margin-top-70 {
    margin-top: 35px !important;
}

 .col-md-4{
    padding-left: 5px !important;
    padding-right: 5px !important;
}
.headfont{
text-align:center; font-weight: 600;   margin-top: 10px;
}
#moodboard_upload{
       height: 593px !important;
    margin-bottom: 24px;
	}
	 .dropzone .dz-message {
   
    margin-top: 120% ;
  
}
@media only screen and (min-width: 426px) and (max-width: 768px) {
.thumbnail{
margin-left: 40px;
}
#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
}
@media only screen and (min-width: 376px) and (max-width: 425px) {


#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
    right: 12px ;
}
}
@media only screen and (max-width: 320px) {

#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
}
@media only screen and (min-width: 321px) and (max-width: 375px) {

#moodboard_upload {
    height: 160px !important;
    margin-bottom: 17px;
}
.dropzone .dz-message {
    margin-top: 9%;
}
.clean {
    border-top: solid 0px #000000 !important;
    border-bottom: solid 0px #000000 !important;
	border-right: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
}
.different {
    border-top: solid 1px #000000 !important;
    border-left: solid 1px #000000 !important;
    border-bottom: solid 0px #000000 !important;
    border-right: 1px solid #000000 !important;
}
.headfont {
    text-align: center;
    font-weight: 600;
    margin-top: 0px !important;
    position: relative !important;
    top: 5px !important;
	    right: 15px;
}
.headfont {
  
    right: 4px;
}
}
.radbtn{
  margin-left: 47.66667% !important;
  }
  .clean{
    border-top: solid 1px #000000;
    border-bottom: solid 1px #000000;
	}
	.different{
	  border-top: solid 1px #000000; border-left: solid 1px #000000;
    border-bottom: solid 1px #000000;
	}
	.tabhead{
	    text-align: center;
    position: relative;
       border-bottom: 1px solid black;
    background-color: #929191;
    color: white;
    padding: 5px;
	}
	.border {
    border: solid 1px #000000;
}
.img_row{
    margin-right: -5px !important;
	}
	
@media only screen and  (max-width: 990px) {
.dropzone .dz-message {
   margin-top: 14% !important;
}
#moodboard_upload {
   height: 222px !important;
   margin-bottom: 24px;
}
}
@media only screen and (min-width: 991px) and (max-width: 1200px) {
#moodboard_upload {
   height: 488px !important;
   margin-bottom: 24px;
}
}	
</style>


<script>
function myFunction() {
    location.reload();
}
</script>

<script>
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."new_client/home/order_success/".$order_details[0]['id'];?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	   
	   $("#mood_board_opt").hide();	
        $("#show_mood_board").click(function(){
			$("#mood_board_opt").toggle(); 
			$("#no_os_submit").toggle();
        });
	});
</script>
  
 <div id="main">
    <section>
      <div class="container margin-top-40 center">                        
			<p>Your order has been placed</p>  
            <div> <span class="border-radius padding-horizontal-70 padding-vertical-5 margin-top-20"> AdwitAds Id: <a href="#" class="text-red"><?php echo $order_details[0]['id'];?></a></span></div>
		<?php echo $this->session->flashdata('message'); ?>
	  </div><!-- /.container-->
	</section><!-- /section -->
  
 	 <section>
		<div class="container margin-top-60">     
			<div class="row">				
				<div class="col-md-12 margin-bottom-15 text-right">
					<span class="dropdown">
						<a class="cursor-pointer" type="button" data-toggle="dropdown" id="view">View Uploaded Files<span class="caret"></span></a>
						<div class="table-responsive dropdown-menu file_li " id="show"> 
							<table class="table table-striped table-hover" id="mytable">
								 <tbody>
								 <?php if(isset($file_names)) { $i=1;  foreach($file_names as $row) { ?>
									 <tr>
										<td><?php echo $i ?></td>
										<td><a href="<?php echo base_url().'downloads/'.$order_details[0]['id'].'-'.$order_details[0]['job_no'].'/'.$row;?>" target="_blank"><?php echo $row; 	$i++; ?></a></td>
										<td>
											<a href="<?php echo base_url().'download.php?file_source='.$order_details[0]['file_path'].'/'.$row; ?>" target="_blank"><i class="fa fa-download"></i></a>
										</td>
										<td>
											<form method="post" action="<?php echo base_url().index_page().'new_client/home/newad_remove_att';?>">
												<input type="hidden" name="filepath" value="<?php echo $order_details[0]['file_path']; ?>">
												<input type="hidden" name="filename" value="<?php echo $row; ?>">
												<input type="hidden" name="adwitadsid" value="<?php echo $order_details[0]['id']; ?>">
												<button type="submit" name="remove_att" id="remove" class="btn btn-outline padding-0" 
												style="background-color: #f9f9f9;margin-top: -4px;color: #1b1b1b;"><i class="fa fa-close"></i></button>
											</form>
										</td>
									</tr>
								 <?php } } ?> 
								</tbody>
							 </table>
						</div>
					</span>
				</div>
			</div>
			<div>
				<form id="uploadfile" action="<?php echo base_url().index_page().'new_client/home/order_success'.'/'.$orderid; ?>"  class="dropzone"> 
					<?php if(isset($file_sucess)){ echo $file_sucess; } ?>
					<div class="dz-default dz-message margin-top-70">You can attach or drag files here</div>
				</form>
					<!--<div class="row float-left margin-top-10">	
						<div class="col-md-12" style="text-color: red;">
Attach sample for "Inspiration".
						</div>
					</div>
					<div class="row float-right margin-top-10">	
						<div class="col-md-12">
Please wait for all files to upload before submitting. <a href="<?php echo base_url().index_page().'new_client/home'; ?>" name="submit" class="btn btn-blue">Submit</a>
						</div>
					</div>-->
				
		   </div>	 			
	  </div>
	 </section>
	 
	 <div class="container margin-top-20 margin-bottom-40">  
			<div class="row margin-bottom-5">
				<div class="col-md-6 col-sm-6 col-xs-6 text-grey">   
					<label class="cursor-pointer" >
						<input id="show_mood_board" type="checkbox" class="margin-right-5"> 
						<span class="text-grey">Tell us if you have a particular type of ad in mind.</span>
					</label>
				</div>
				<div id="no_os_submit" class="col-md-6 col-sm-6 col-xs-6 text-right ">	
					<span >Please wait for all files to upload before submitting.
						<a href="<?php echo base_url().index_page().'new_client/home'; ?>" name="no_os_submit" class="btn btn-sm btn-blue">Submit</a>
					</span>
				</div>
			</div>	
		</div>
		
	 <!-- Mood_board Starts
	<section>
		<div class="container margin-top-20" id="mood_board_opt">  
			<div class="row">
				<form method="post" action="<?php echo base_url().index_page().'new_client/home/moodboard'.'/'.$orderid; ?>">		
					<div class="col-md-12 margin-bottom-15">
						<table class="table table-striped table-bordered table-hover" id="">
							<tbody>
								<?php $mood_board = $this->db->query("SELECT * FROM `mood_board`;")->result_array(); ?>
								<?php if(isset($mood_board)) { ?>
								<tr>
									<?php foreach($mood_board as $row){?>
										<th><p><input type="radio" name="mood_board" value="<?php echo $row['id'];?>" required><?php echo ' '.$row['name'];?></p></th>
									<?php } ?>
								</tr>
								<tr>
									<?php foreach($mood_board as $row){
									if($row['id']!='4') { ?>
									<td>
										<a href="#<?php echo base_url().$row['path'];?>" ><img src="<?php echo base_url().$row['path'];?>" class="thumbnail" height="150" width="150"></a>
										
										<a href="#_" class="lightbox" id="<?php echo base_url().$row['path'];?>"><span class="close cursor" onclick="closeModal()">&times;</span>
										<img src="<?php echo base_url().$row['path'];?>"></a>
									</td>
									<?php } elseif($row['id']==4) { ?>
									<td style="width: 285px;"> <p style="    padding: 80px 10px 0px 0px ;   margin-bottom: 0px;min-height: 250px;" id="moodboard_upload" action="<?php echo base_url().index_page().'new_client/home/moodboard'.'/'.$orderid; ?>"  class="dropzone"></p>
									</td> <?php } } ?>
								</tr>
								<?php }	?>
							</tbody>
						</table>
						
						<span class="float-right ">Please wait for all files to upload before submitting.
							<button type="submit" name="os_submit" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
						</span>
					</div>
				</form>
			</div>
		</div>
	</section>
	 Mood_board Ends-->
	
	 <!-- Mood_board Starts-->
	 
	<section>
		<div class="container " id="mood_board_opt"> 
			<div class="row">
				<!--<form method="post" action="<?php echo base_url().index_page().'new_client/home/moodboard'.'/'.$orderid; ?>">	-->
					<div class="col-md-12 margin-bottom-20">
					<?php 
						$mood_board_bold = $this->db->query("SELECT * FROM `mood_board` WHERE `id` = '1';")->row_array();
						if(isset($mood_board_bold)) {
					?>
					<!---------------------- BOLD ----------------------------------------------------------------------->
					   <div class="col-md-3 border">
							<div class="row">
								<p class="tabhead"><?php echo $mood_board_bold['name']; ?></p>
							</div>
						   <div class="row img_row">
						   <?php 
								$path = $mood_board_bold['path'].'/';
								if(file_exists($path)){
									$files = scandir($path);
									foreach($files as $file){ 
										if (!in_array($file,array(".",".."))){
						   ?>
								<div class="col-md-4 col-sm-4 col-xs-4 side_alignr">
									<input type="radio" class="radiobtn mood_board" name="mood_board" data-mood_board_id="<?php echo $mood_board_bold['id']; ?>" value="<?php echo $path.$file;?>" required>
									<a href="#<?php echo base_url().$path.$file;?>" >
										
										<img src="<?php echo base_url().$path.$file;?>" class="thumbnail" >
									</a>
									<!-- lightbox container hidden with CSS -->
									<a href="#_" class="lightbox" id="<?php echo base_url().$path.$file;?>"><span class="close cursor" onclick="closeModal()">&times;</span>
									<img src="<?php echo base_url().$path.$file;?>"></a>
								</div>
						<?php 	} } } ?>	
							</div>	
						 				
						</div>
					<?php } ?> 
					
					<!---------------------- CLEAN ----------------------------------------------------------------------->
					<?php 
						$mood_board_clean = $this->db->query("SELECT * FROM `mood_board` WHERE `id` = '2';")->row_array();
						if(isset($mood_board_clean)) {
					?>
					   <div class="col-md-3 border">
							<div class="row">
								<p class="tabhead"><?php echo $mood_board_clean['name']; ?></p>
							</div>
						   <div class="row img_row">
						   <?php 
								$path = $mood_board_clean['path'].'/';
								if(file_exists($path)){
									$files = scandir($path);
									foreach($files as $file){ 
										if (!in_array($file,array(".",".."))){
						   ?>
								<div class="col-md-4 col-sm-4 col-xs-4 side_alignr">
									<input type="radio" class="radiobtn mood_board" name="mood_board" data-mood_board_id="<?php echo $mood_board_clean['id']; ?>" value="<?php echo $path.$file;?>" required>
									<a href="#<?php echo base_url().$path.$file;?>" >
										<img src="<?php echo base_url().$path.$file;?>" class="thumbnail" >
									</a>
									<!-- lightbox container hidden with CSS -->
									<a href="#_" class="lightbox" id="<?php echo base_url().$path.$file;?>"><span class="close cursor" onclick="closeModal()">&times;</span>
									<img src="<?php echo base_url().$path.$file;?>"></a>
								</div>
						<?php 	} } } ?>	
							</div>	
						 				
						</div>
					<?php } ?>
					
					<!---------------------- DIFFERENT ----------------------------------------------------------------------->
					<?php 
						$mood_board_different = $this->db->query("SELECT * FROM `mood_board` WHERE `id` = '3';")->row_array();
						if(isset($mood_board_different)) {
					?>
					   <div class="col-md-3 border">
							<div class="row">
								<p class="tabhead"><?php echo $mood_board_different['name']; ?></p>
							</div>
						   <div class="row img_row">
						   <?php 
								$path = $mood_board_different['path'].'/';
								if(file_exists($path)){
									$files = scandir($path);
									foreach($files as $file){ 
										if (!in_array($file,array(".",".."))){
						   ?>
								<div class="col-md-4 col-sm-4 col-xs-4 side_alignr">
									<input type="radio" class="radiobtn mood_board" name="mood_board" data-mood_board_id="<?php echo $mood_board_different['id']; ?>" value="<?php echo $path.$file;?>" required>
									<a href="#<?php echo base_url().$path.$file;?>" >
										<img src="<?php echo base_url().$path.$file;?>" class="thumbnail" >
									</a>
									<!-- lightbox container hidden with CSS -->
									<a href="#_" class="lightbox" id="<?php echo base_url().$path.$file;?>"><span class="close cursor" onclick="closeModal()">&times;</span>
									<img src="<?php echo base_url().$path.$file;?>"></a>
								</div>
						<?php 	} } } ?>	
							</div>	
						 				
						</div>
					<?php } ?>
					
					<!---------------------- ANY OTHERS ----------------------------------------------------------------------->
					   <div class="col-md-3 border ">
					    <div class="row" >
						   <p class="tabhead">Any Others</p>
						   <div style="padding-left: 15px; padding-right: 15px;">
								<input type="radio" id="other_file" class="radiobtn radbtn mood_board" name="mood_board" data-mood_board_id="4" value="4" required>
								<p id="moodboard_upload" action="<?php echo base_url().index_page().'new_client/home/moodboard'.'/'.$orderid; ?>"  class="dropzone" style="visibility:hidden;"></p>
						   </div> 
						</div>
					   </div>
					
					</div>
					
					<div class="col-md-12">	
						<span class="float-right ">Please wait for all files to upload before submitting.
							<button type="button" name="os_submit" id="os_submit" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
						</span>
					</div>
				<!--</form>-->
			</div>
		</div>
	</section>

	<!-- Mood_board Ends-->
  </div>
 
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
<script>
$("#os_submit").click(function(){
	 if ($('input[name="mood_board"]:checked').length == 0) {
		 alert('Please Select Type of AD');
	 } else {
		 var mood_board_file = $('input[name="mood_board"]:checked').val();
		 var mood_board_id = $('input[name="mood_board"]:checked').data('mood_board_id');
		 //alert('checked : '+val+' - '+id);
		 if(mood_board_id == 4){
			 window.location.href = "<?php echo base_url().index_page();?>new_client/home";
		 }
		 
		 $.ajax({
			 url: "<?php echo base_url().index_page().'new_client/home/moodboard'.'/'.$orderid; ?>",
			 type: "POST",
			 data: 'mood_board='+mood_board_id+'&path='+mood_board_file+'&os_submit=',
			 success : function(){
					window.location.href = "<?php echo base_url().index_page();?>new_client/home";
			 }
		 });
	 }
});

$(".mood_board").click(function(){
	var mood_board_id = $(this).data('mood_board_id'); 
	if(mood_board_id == 4){
		$('#moodboard_upload').css("visibility", "visible");
	}else{
		$('#moodboard_upload').css("visibility", "hidden");
	}
	
});
</script>