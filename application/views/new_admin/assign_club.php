<?php $this->load->view('new_admin/header')?>
<style>
.table-responsive.border.padding-15 {
overflow: scroll;
height: auto;
}
.userdetails .col-md-6 {
   
    border-right: 0px solid #ccc;
}
#club_id{
overflow: scroll;
height: auto;
}

</style>

<div class="portlet light">
	<form method="post" name="order_form" id="order_form">
	<div class="row">
		<div class="col-sm-6 margin-top-5 font-grey-gallery"><b><?php if(isset($user_details)){ echo $user_details['name'].' (',$user_details['id'].')';}?> - Add - Club</b></div>
		<div class="col-sm-6 text-right">
			<button  id="submit_form" type="submit" name="submit" class="btn btn-xs btn-primary margin-bottom-5 margin-left-10">Save Changes</button>
		</div>
	</div>
	<div class="border-top"></div>
	<div class="row userdetails portlet-body" id="form">
		<div class="">
			<div class="col-md-6 col-sm-6 margin-top-20 ">
			<p class="border-bottom"><b>All - Club </b></p>
			<div class="table-responsive border padding-15"> 
				<table class="table table-striped table-bordered table-hover" id="tracker_table">
					<thead>
						<tr>
							<td width="30%">Name</td>
						</tr>  									
					</thead>
					<tbody>
					<?php if(isset($club)){
						foreach($club as $row){
						
						?>
						<tr> 
							<td>
							<div>
							<?php if(isset($club_id) && in_array($row['id'], $club_id)){ ?>
								<p><input type="checkbox" class="individual" name="club[]" value="<?php echo $row['id']; ?>" checked="checked" >
								<?php echo $row['name']; ?> </p> 
							<?php } else {?>
								<p><input type="checkbox" class="individual" name="club[]" value="<?php echo $row['id']; ?>" >
								<?php echo $row['name']; ?> </p> 
							<?php }?>
							</div>
							</td>
						</tr>
						<?php  } } ?>	
					</tbody> 
				</table>
			</div>	
			</div>
			
			
			
			<div class="col-md-1 col-sm-1 margin-top-20">
			&nbsp;
			

			</div>
			
			<?php if($user_details['club_id']!= ''){ ?>
			<div class="col-md-5 col-sm-5  margin-top-20">
			  <p class=" border-bottom"><b>Added Club</b></p>
			
			   <div id="club_id" class="table-responsive border padding-15">
			   <?php $club_id = explode(",",$user_details['club_id']);
						foreach($club_id as $row){
							$clubname = $this->db->query("SELECT `id`,`name` FROM `club` WHERE `id`='".$row."'")->row_array();
				?>
			   <span id="showin1"><?php echo $clubname['name']; ?> </span>
			   </br><?php } ?>
			   </div>
				
            </div>
			<?php } ?>
		</div>
	</div>
	</form>
</div>
					
<?php $this->load->view('new_admin/footer')?>		
<?php $this->load->view('new_admin/datatable')?>

	  
