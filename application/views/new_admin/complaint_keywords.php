<?php $this->load->view('new_admin/header')?>

<style>
	.dropdown-menu{
		position: relative !important;
	}
	.btn-xxs{
		padding: 5px;
		font-size: 12px;
		line-height: .8;
	}
	.no-border{
		border: 0px !important;
	}
</style>


 <div class="col-md-12">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row margin-bottom-5">	
			<div class="col-md-4 col-xs-4">
				<a href="<?php echo base_url().index_page().'new_admin/home/reports_complaint';?>" class="font-lg font-grey-gallery">Complaints</a>
			</div>		
			<div class="col-md-4 col-xs-4">
			<span><?php echo $this->session->flashdata('message');?></span>
			</div>			
			<div class="col-md-4 col-xs-4 text-right">
					<div class="btn-group">  
						<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
			</div>			
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-bordered table-hover" id="sample_6">
				<thead>
					<tr>
						<th>Keyword</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody> 
				<?php $i=0; foreach($keywords as $row){ $i++; ?>
				<tr>
					<form method="post">
						<td>
							<input id="form<?php echo $i; ?>" type="text" value="<?php if($row['name']!='')echo $row['name']; else echo"-";?>" name="keyword" class="form-control input-sm" placeholder="">
						</td>
						<td>
							<button  id="submit_form<?php echo $i ; ?>" type="submit" name="update_key" class="btn btn-primary btn-sm margin-left-10">Save Changes</button>
							<input type="text" name="id" value="<?php echo $row['id'] ;?>" style="display:none;">
							<button type="submit" name="delete" class="btn bg-blue-flamingo btn-sm margin-right-5">Delete</button>
						</td>
					</form>
				</tr> 
				<script>
					 $(document).ready(function(){
					  $('#submit_form<?php echo $i; ?>').hide();
					  $("#form<?php echo $i; ?>").click(function(){$("#submit_form<?php echo $i; ?>").show(); });
					 });
				</script>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div> 
 </div>
 
 
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable.php'); ?>
