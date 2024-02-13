<?php
       $this->load->view("new_designer/head");
?>
<div class="page-container">
 <!-- BEGIN PAGE CONTENT -->
 <div class="page-content">
	<div class="container">
   
   
   <!-- BEGIN PROFILE -->
    <div class="row margin-top-10">
		<div class="col-md-12">
			<!-- BEGIN PROFILE CONTENT -->
			<div class="profile-content">
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN PORTLET -->
						<div class="portlet light ">
						 <div class="portlet-body margin-bottom-25 ">
							<?php if(isset($notification)){ foreach($notification as $row){ ?>
							
							 <div class="note note-info note-bordered">
								<h3 class="block"><?php echo $row['headline']; ?></h3>
								<p><?php echo $row['message']; ?></p>
								<div class="text-right"><small>From Admin on <?php echo $row['time']; ?></small></div>
							 </div>
							 
							<?php } }else{ ?>
								<div class="note note-info note-bordered">
									<p><?php echo $message; ?></p>
								</div>
							<?php } ?> 
						 </div>
						</div>
						<!-- END PORTLET -->
						<!-- BEGIN PORTLET -->
						<div class="portlet light ">
						 <div class="portlet-body">
							
							<h4 class="no-space">Password Change Notification</h4>
							<div class="note note-info note-bordered margin-bottom-10 margin-top-10">
							<p><?php if($today < $date1){ ?>
							<?php echo 'Your password will Expire on '.$date1 ; 
							} else {
							echo "<h5>Time to change Your Password!!!!</h5>";?></br>
							<h4><a class="font-red" href="<?php echo base_url().index_page()."new_designer/home/my_account#tab_1_3";?>">click here to change your Password!</a></h4>
							<?php } ?></p>
								</div>
						 </div>
						</div>
						<!-- END PORTLET -->
				</div>
			</div>
		</div>
     <!-- END PROFILE CONTENT -->
    </div>
    </div>
   <!-- END PROFILE -->
	</div>   
 
 <!-- END PAGE CONTENT -->
 </div>
<!-- END PAGE CONTAINER -->
</div>
<?php
       $this->load->view("new_designer/foot");
?>