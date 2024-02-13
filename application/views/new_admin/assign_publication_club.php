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
	<!--<div class="row">
		<div class="col-sm-6 margin-top-5 font-grey-gallery"><b> Add - Club</b></div>
		<div class="col-sm-6 text-right">
			<button  id="submit_form" type="submit" name="submit" class="btn btn-xs btn-primary margin-bottom-5 margin-left-10">Save Changes</button>
		</div>
	</div>-->
	<div class="border-top"></div>
	<div class="row userdetails portlet-body" id="form">
		<div class="">
			<div class="col-md-6 col-sm-6 margin-top-20 ">
			<p class="border-bottom"><b>Unassigned Publications </b>(<?php echo count($unassigned_pub); ?>)</p>
			<div class="table-responsive border padding-15"> 
				<table class="table table-striped table-bordered table-hover" id="tracker_table">
					<thead>
						<tr>
							<td width="30%">Name</td>
							<td width="30%">Group</td>
						</tr>  									
					</thead>
					<tbody>
					<?php 
					if(isset($unassigned_pub)){
						foreach($unassigned_pub as $row){
						
						?>
						<tr> 
							<td><?php echo $row['name']; ?>
							<!--<div>
								<p><input type="checkbox" class="individual" name="pub[]" value="<?php echo $row['id']; ?>" >
								<?php echo $row['name']; ?> </p> 
							</div>-->
							</td>
							<td><?php echo $row['gname']; ?></td>
						</tr>
					<?php  } } ?>	
					</tbody> 
				</table>
			</div>	
			</div>
		
		</div>
	</div>
	</form>
</div>
					
<?php $this->load->view('new_admin/footer')?>		
<?php $this->load->view('new_admin/datatable')?>

	  
