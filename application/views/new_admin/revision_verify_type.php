<?php $this->load->view("new_admin/header"); ?>

<script>
$(document).ready(function(){	    
	$(".dropdown-checkboxes").hide();	
	$('.date-picker').click(function() {
		$(".cursor-pointer").addClass(" filter ");
	});	
	$('#filter').click(function() {
		$(".dropdown-checkboxes").toggle();
	});
});
</script>

<div class="portlet light">
	<div class="portlet-title">
	<div  class="col-xs-12 text-center">
		<?php echo '<span style=" color:#900;">'.$this->session->flashdata('message').'</span>'; ?> 
	</div>
	<div class="row">
	<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
		<a href="<?php echo base_url().index_page(). 'new_admin/home/revision_verify_type/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?> Details</a> 
		<!--<span><?php $f = strtotime($from) ; $t = strtotime($to); echo "From "." - ".date('M d, Y', $f)." ". "  To " . " - " .date('M d, Y', $t);?> </span> -->
	</div>

	<div>
	</div>
	

	<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">
		<form method="get">
			<div class="btn-group left-dropdown">							
			<div class="btn-group left-dropdown">
			<div class="btn-group left-dropdown">							
				<!--<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
					<i class="fa fa-filter cursor-pointer"></i> Filter
				</button> -->
			<!--<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
				<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
					
					<input type="text" class="form-control border-radius-left" name="date" placeholder="From Date">
							
					<div class="text-right margin-top-10">
						<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
					</div>
				</div> 
			</div> -->
			</div></div>
			</div>
		</form>
	</div>

	<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">	
		<!--<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>-->
	</div> 

	<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
		<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
	</div>
	</div>
	</div>
	<div class="portlet-body">	
	<form method ="POST" id= "demo">
		<table class="table table-striped table-bordered table-hover" >
			<thead>
				<tr>
					<th>AdwitAds ID</th>
					<th>Publication </th>
					<th>AdRep</th>
					<th><?php echo $prev_ver; ?> - Details </th> 
					<!--<th>Version</th>-->
					<th>Feedback </th>
					<th width="14%">The Comment</th>
				</tr>
			</thead>
			<tbody>
				<td><?php echo $order_id; ?></td>
				<td><?php if(isset($publication_name['name'])){echo $publication_name['name'];}else {echo '';}?></td>
				<td>
					<?php if(isset($adrep_name['first_name'])){echo $adrep_name['first_name'];}else {echo '';}
						  if(isset($adrep_name['last_name'])){ echo ' '.$adrep_name['last_name'];}else {echo '';}?>
				</td>
				<td>
				<table class="table table-striped table-bordered table-hover" >
				<thead>
				<tr>
					<th>Designer </th>
					<th>Designer Team Lead </th>
					<th>Proof Reader </th>
					<th>Rov Check</th>
					<th>Hybrid Designer</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td><?php if(isset($designer_name['name'])){echo $designer_name['name'];}else{echo'';} ?></td>
				<td><?php if(isset($designer_tl_name['name'])){echo $designer_tl_name['name'];}else{echo'';} ?></td>
				<td><?php if(isset($csr_name['name'])){echo $csr_name['name'];}else{echo'' ;} ?></td>
				<td><?php if(isset($rov_csr['name'])){echo $rov_csr['name'];}else{echo'' ;}  ?></td>
				<td><?php if(isset($hi_b_designer_name['name'])){echo $hi_b_designer_name['name'];}else{echo'' ;}  ?></td>
				</tr>
				</tbody>
				</table>
				</td> 
			<!--	<td><?php echo $version; ?></td>-->
				<td><?php echo $note; ?></td>
				<td>
				<textarea rows="2" name="comment"  placeholder="Write a comment" class=" form-control input-sm margin-bottom-10"></textarea>
				
				<?php foreach($verification_type as $v_row){?>
					<div>
					<input type="checkbox" class="verification_type" name="verification_type[]" id ="verification_type" value="<?php echo $v_row['id']; ?>"><?php echo $v_row['name']; ?>
					</div>
				<?php }?>
				<div>
				<input type="hidden" value="<?php echo $rev_id; ?>" name="rev_id">
				<input type="hidden" value="<?php echo $order_id; ?>" name="order_id">
				<input type="hidden" value="<?php if(isset($designer_name['id'])){echo $designer_name['id'];}else{echo'0';}?>" name="designer_id">
				<input type="hidden" value="<?php if(isset($designer_tl_name['id'])){echo $designer_tl_name['id'];}else{echo'0';}?>" name="dtl_id">
				<input type="hidden" value="<?php if(isset($csr_name['id'])){echo $csr_name['id'];}else{echo'0';}?>" name="csr_id">
				<input type="hidden" value="<?php if(isset($rov_csr['id'])){echo $rov_csr['id'];}else{echo'0';}?>" name="rov_csr_id">
				<input type="hidden" value="<?php if(isset($hi_b_designer_name['id'])){echo $hi_b_designer_name['id'];}else{echo'0';}?>" name="hi_b_designer_id">
				
				<button type="submit" name="search" class=" btn btn-xs blue  pull-right  margin-top-20">Submit </button>
				</td>
			</tbody>		
		</table>
	</form>
	</div>
	<div class="row">
		<div class="col-xs-6  ">
		<form method ="POST" action="">
		    <input type="hidden" value="<?php echo $rev_id; ?>" name="rev_id">
			<input type="hidden" value="<?php echo $order_id; ?>" name="id">
			<button type="submit" name="ignore" class=" btn btn-md red  pull-left ">Ignore </button>
		</form>
		</div>
	</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("#demo").on('submit',function(){
		var c = $('.verification_type:checked').length;
		if(c > 0){
			return true;
		}else{
			alert("Check Atleast One Verification Type..!!");
			return false;
		}
     });
});
</script>
<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>