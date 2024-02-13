<?php $this->load->view('new_admin/header')?>
<style>
.table-responsive.border.padding-15 {
overflow: scroll;
height: 420px;
}
.userdetails .col-md-6 {
   
    border-right: 0px solid #ccc;
}
#addedpub{
overflow: scroll;
height: 420px;
}

</style>

<div class="portlet light">
	<form method="post" name="order_form" id="order_form">
	<div class="row">
		<div class="col-sm-6 margin-top-5 font-grey-gallery"><b><?php if(isset($user_details)){ echo $user_details['name'].' (',$user_details['id'].')';}?> - Add Publication</b></div>
		<div class="col-sm-6 text-right">
			<button  id="submit_form" type="submit" name="submit" class="btn btn-xs btn-primary margin-bottom-5 margin-left-10">Save Changes</button>
		</div>
	</div>
	<div class="border-top"></div>
	<div class="row userdetails portlet-body" id="form">
		<div class="">
			<div class="col-md-6 col-sm-6 margin-top-20 ">
			<p class="border-bottom"><b>All Publication</b></p>
			<div class="table-responsive border padding-15"> 
				<table class="table table-striped table-bordered table-hover" id="tracker_table">
					<thead>
						<tr>
							<td width="30%">Name</td>
						</tr>  									
					</thead>
					<tbody>
					<?php if(isset($group_details)){
						foreach($group_details as $row){ 
						$pub_name = $this->db->query("SELECT `id`,`name`,`group_id` FROM `publications` WHERE `group_id` = '".$row['id']."' AND `is_active` = '1' ORDER BY `name` ASC")->result_array();	
						if(count($pub_name)!='0'){
					?>
						<tr> 
							<td>
							
							<div class="group" data-row_id="<?php echo $row['id'];?>">
							<span  class="btn btn-xs btn-primary margin-bottom-10 margin-top-5" ><?php echo $row['name'].' - '.count($pub_name); ?></span>
							</div>
							<?php if(isset($pub_name[0]['id'])) { ?>
							<div id="groupcontent<?php echo $row['id'];?>" class="group-content">
								<p><input type="checkbox" class="selectall" data-row_id="<?php echo $row['id'];?>" > Select All </p>
								
								<?php 
								foreach($pub_name as $row1){ 
									if(isset($pub_id) && in_array($row1['id'], $pub_id)){ 
								?>
								    <p>
								        <input type="checkbox" class="individual<?php echo $row['id'];?>" name="publication[]" value="<?php echo $row1['id']; ?>" checked="checked">
								        <?php echo $row1['name']; ?> 
								    </p>
								<?php }else{ ?>
								    <p>
								        <input type="checkbox" class="individual<?php echo $row['id'];?>" name="publication[]" value="<?php echo $row1['id']; ?>"> <?php echo $row1['name']; ?> 
								    </p>
								<?php 
								    } 
								} 
								?>
							
							</div>
							<?php } ?>
							</td>
							
						</tr>
						<?php } } } ?>	
					</tbody> 
				</table>
			</div>	
			</div>
			
			
			
			<div class="col-md-1 col-sm-1 margin-top-20">
			&nbsp;
			

			</div>
			
			<?php if($user_details['pub_id']!= ''){ ?>
			<div class="col-md-5 col-sm-5  margin-top-20">
			  <p class=" border-bottom"><b>Added Publication</b></p>
			
			   <div id="addedpub">
    			   <?php        
    			        $pub_id = explode(",",$user_details['pub_id']);
    					foreach($pub_id as $row){
    						$pname = $this->db->query("SELECT `id`,`name`,`group_id` FROM `publications` WHERE `id` = $row")->row_array();
    						$groupname = $this->db->query("SELECT `id`,`name` FROM `Group` WHERE `id`='".$pname['group_id']."'")->row_array();
    				?>
    			   <span id="showin1" class="btn btn-xs btn-primary margin-bottom-10 margin-top-5"><?php echo $groupname['name'] ?> </span>
    			   <span id="showin1"><?php echo $pname['name'] ?> </span>
    			   </br>
    			   <?php } ?>
			   </div>
				
            </div>
			<?php } ?>
		</div>
	</div>
	</form>
</div>
					
<?php $this->load->view('new_admin/footer')?>		
<?php $this->load->view('new_admin/datatable')?>
<script>
$(document).ready(function(){
	
	$(".group-content").hide();
	$(".group").click(function(){
		var group_id = $(this).data("row_id");
		$("#groupcontent"+group_id).toggle();
	});
});

$(".selectall").click(function () { 
		var group_id = $(this).data("row_id");
		
		if($(this).prop("checked") == true){
			$(".individual"+group_id).parent().addClass("checked");
			$(".individual"+group_id).prop("checked", $(this).prop("checked"));
		}else{
			$(".individual"+group_id).parent().removeClass("checked");
			$(".individual"+group_id).prop("checked", $(this).prop("checked"));
		}
	 });
//# sourceURL=pen.js
</script>
	  
