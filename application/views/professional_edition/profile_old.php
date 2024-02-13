<?php $this->load->view('professional_edition/header');?>
  
		
		<script>
			 $(document).ready(function(){
			  $("#advancesearch").hide();
			  $("#show_edit").hide();
		  
			 $("#edit").click(function(){
				$("#show_edit").toggle();  	
			  });

			  $("#showadvancesearch").click(function(){
				$("#advancesearch").toggle();  
				$("#search").toggle();  		
			  });
			 
			 $("#showsearch").click(function(){
				$("#advancesearch").toggle();  
				$("#search").toggle();  		
			  });
			  
			 });
		 </script>
 
   <div id="main">
   
    <section>
     <div class="container margin-top-40">       
	    
		<div class="row">  		
			<div class="col-md-5 col-md-offset-2">
				<p class="xlarge padding-bottom-10">Profile</p>
			</div>
		</div>
		
        <div class="row">      		   	         
			<div class="col-md-2 col-sm-12 col-xs-12 padding-top-10 center margin-bottom-30">
			 <img id="img" class="border-radius-50" src="<?php echo base_url().$adrep_details[0]['image']; ?>" alt="profile" width="180px" height="180px">
			 <div class="padding-top-10 text-center">
			  <small> <a id="edit" class="cursor-pointer"> <i class="glyphicon glyphicon-edit"></i> Edit</a> </small>
			</div>
			</div>		 	
						
			<div class="col-md-5 col-sm-6 col-xs-12 padding-bottom-5">
				<div class="panel panel-default">
					<div class="panel-heading">
						 <span class="large">Your Profile Information</span>
					</div>
					<div class="panel-body">
					   <div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-4 col-xs-12">Full Name</div>
						<div class="col-md-8 col-sm-8 col-xs-12 text-grey"><?php echo $adrep_details[0]['first_name'].' '.$adrep_details[0]['last_name'];?></div>
					   </div>
					   <div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-4 col-xs-12">Username</div>
						<div class="col-md-8 col-sm-8 col-xs-12 text-grey"><?php echo $adrep_details[0]['username'];?></div>
					   </div>
					   <div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-4 col-xs-12">Gender</div>
						<div class="col-md-8 col-sm-8 col-xs-12 text-grey">
						<?php if($adrep_details[0]['gender']== '1') {
						echo "Male"; } else { echo "Female"; }?>			
						</div>
					   </div>
						<div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-4 col-xs-12">Email Id</div>
						<div class="col-md-8 col-sm-8 col-xs-12 text-grey"><?php echo $adrep_details[0]['email_id'];?></div>
					   </div>
					   <div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-4 col-xs-12">Publication</div>
						<div class="col-md-8 col-sm-8 col-xs-12 text-grey">
						<?php $publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
						echo $publication[0]['name']; ?>
												</div>
					   </div> 
					</div>
				</div>
				<div class="panel panel-default" id="show_edit">
					<div class="panel-heading">
						 <span class="large">Change Profile Picture</span>
					</div>
					<div class="panel-body">
					<?php if(isset($error))echo $error;?>
						
					<form method="POST" enctype="multipart/form-data">
							<div class="border padding-10">
								<img id="blah" src="<?php echo base_url().$adrep_details[0]['image']; ?>" alt="profile" width="180px" height="180px"/>
							</div>
							<div class="border padding-10">
								<input type="file" id="docs-input-file" name="Photo" accept="image/gif, image/jpeg, image/x-png"> 
								<span class="small" style="color:green;">Allowed File Types jpeg, gif png </span>
							</div>
							<?php if(isset($error)) { ?>
							<div class="text-red margin-top-5"><small>Image dimension should not exceed 300x300px</small></div>
							<div class="text-red margin-top-5"><small>Image size should not exceed 100Kb</small></div>
							<?php } ?>
							<div class="text-right">
							
								<button type="submit" name="img_upload" class="btn btn-sm btn-primary btn-md margin-top-15">Upload</button>
							</div>
						</form>	
					</div>
			    </div>
			</div>
			 
			 <div class="col-md-5 col-sm-6 col-xs-12 mobile-border-bottom padding-bottom-5">
				<div class="panel panel-default">
					<div class="panel-heading">
						 <span class="large">Change Password</span>
					</div>
					<div class="panel-body">
					   <form method="post">
					   <div class="row padding-bottom-5">
						<div class="col-md-4 col-sm-5 col-xs-12 padding-top-10 padding-left-15">Current Password</div>
						<div class="col-md-8 col-sm-7 col-xs-12 padding-left-15">
						   <div class="input-box">
							   <input type="password" name="current_password" class="form-control" placeholder="Current Password" required="">
						   </div>	
						</div>
					   </div>
						<div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-5 col-xs-12 padding-top-10 padding-left-15">New Password</div>
						<div class="col-md-8 col-sm-7 col-xs-12 padding-left-15">
						   <div class="input-box">
							   <input type="password" name="new_password" class="form-control" placeholder="New Password" required="">
						   </div>	
						</div>
					   </div>
						<div class="row padding-vertical-5">
						<div class="col-md-4 col-sm-5 col-xs-12 padding-top-10 padding-left-15">Re-Type Password</div>
						<div class="col-md-8 col-sm-7 col-xs-12 padding-left-15">
						   <div class="input-box">
							   <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="">
						   </div>	
						</div>
					   </div>
					    <div class="row padding-vertical-5">
						 <div class="col-md-12 col-sm-12 col-xs-12">
						 <?php if(isset($invalid_pwd)) { ?>
						   <div class="alert alert-danger alert-outline margin-bottom-5 padding-5"><p>Current Password Does Not Match.</p></div>	
						 <?php } ?>
						 <!--<div class="alert alert-danger alert-outline margin-bottom-5 padding-5"><p>New & Re-Type Password Does Not Match.</p></div>	
						   --><?php if(isset($pwd_success)){ ?>
						   <div class="alert alert-success alert-outline margin-bottom-5 padding-5"><p>Password Changed Successfully.</p></div>	
						 <?php } ?>
						 </div>
					   </div>
					   <div class="row padding-vertical-5">
						 <div class="col-md-12 col-sm-12 col-xs-12">
						 </div>
					   </div>
					   <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right padding-bottom-15">
						  <button type="submit" name="submit" class="btn btn-sm btn-primary btn-md">
							<span>Submit</span>
						  </button>
						  </div>
					   </div>
					 </form>     
				</div>
				</div>
			 </div> 
	 </div><!-- /.row -->
      </div>

	</section><!-- /section -->
            </div>

			
     
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Profile</h4>
      </div>
	  <div class="modal-body">
    <form>
	   <div class="form-group margin-0">
          <input type="file" id="docs-input-file">
       </div>
	</form>	
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-sm btn-primary btn-lg" data-dismiss="modal">Update</button>
      </div>
    </div>
 </div>
</div>
<script>

function readURL(input) {
	var file = document.getElementById('docs-input-file').files;
	//img size chk
	if(file[0] && file[0].size > 100000) { // 100 KB (this size is in bytes)
        //Prevent default and display error
		alert('File Size is Greater than 100kb. Try Files that are lesser than 100kb..!!');
        evt.preventDefault();
    }
	//img preview
    if (file && file[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(file[0]);
    } 
}

$("#docs-input-file").change(function(){
    readURL(this);
});

</script>
<?php $this->load->view('professional_edition/footer');?>