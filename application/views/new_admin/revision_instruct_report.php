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
	<div class="row">
		<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
			<a href="<?php echo base_url().index_page(). 'new_admin/home/revision_instruct_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> -
			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report_production/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a>
				<?php if($publication_id != 'all') { echo '- '.$publications[0]['name'] ; }?>-
				<?php if(isset($d)){ $from1 = strtotime($d); echo date('M d, Y', $from1); } ?>
			
		</div>

		<div></div>

		<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">
				<form method="get">
					<div class="btn-group left-dropdown">							
					<div class="btn-group left-dropdown">
					<div class="btn-group left-dropdown">							
						<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
							<i class="fa fa-filter cursor-pointer"></i> Filter
						</button>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
							<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
							<input type="text" class="form-control border-radius-left" name="publication_id" value="<?php echo $publication_id ;?>" style="display:none;">
							<input type="text" class="form-control border-radius-left" name="date" placeholder="From Date">
							
								<div class="text-right margin-top-10">
									<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
								</div>
							</div>
						</div>
					</div></div>
					</div>
				</form>
			</div>

			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">	
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>

			<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
	</div>
	<!--<div class="row">
	<div class="col-md-8 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/revision_instruct_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> 
				<?php if($publication_id != 'all') { echo '- '.$publications[0]['name'] ; }?>-
				<?php if(isset($d)){ $from1 = strtotime($d); echo date('M d, Y', $from1); } ?>
			
				
			</div>
		<div class="col-md-4 col-xs-9 margin-bottom-10  text-right">
			
			
				<form method="get">
				<div class="btn-group left-dropdown">
					<div class="btn-group left-dropdown">							
						<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
							<i class="fa fa-filter cursor-pointer"></i> Filter
						</button>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
							<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
							<input type="text" class="form-control border-radius-left" name="publication_id" value="<?php echo $publication_id ;?>" style="display:none;">
							<input type="text" class="form-control border-radius-left" name="date" placeholder="From Date">
							
								<div class="text-right margin-top-10">
									<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
								</div>
							</div>
						</div>
					</div></div>
			
			
				</form>
			<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			
		</div>
	</div>-->
	</div>
	<div class="portlet-body">	
		<table class="table table-striped table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>AdwitAds ID</th>
					<th>V1</th>
					<th>V1a</th>
					<th>V1b</th>
					<th>V1c</th>
					<th>V1d</th>
					<th>V1e</th>
					<th>V1f</th>
					<th>V1g</th>
					<th>V1h</th>
					
				</tr>
			</thead>
			<tbody>
			<?php foreach($publications as $p_row){
					$orders = $this->db->query("SELECT cat_result.id, cat_result.order_no, note_sent.note, note_sent.revision_id, rev_sold_jobs.id as rev_id, rev_sold_jobs.version FROM `cat_result` 
					LEFT JOIN `note_sent` ON cat_result.order_no = note_sent.order_id
					LEFT JOIN `rev_sold_jobs` ON note_sent.revision_id = rev_sold_jobs.id
					WHERE cat_result.publication_id = '".$p_row['id']."' AND cat_result.date = '$d'; ")->result_array();
					foreach($orders as $order){
						$version = $order['version'];
			?> 
			<tr>
				<td><?php echo $order['order_no'];?></td>
				<?php
					if($order['revision_id'] == '0'){ echo '<td>'.$order['note'].'</td>'; }else{ echo '<td></td>'; }
					if($version == 'V1a'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1b'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1c'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1d'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1e'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1f'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1g'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1h'){ echo '<td>'.$order['note'].'</td>';}else{ echo '<td></td>';}
				?>
			</tr>
			<?php } }  ?>
			</tbody>		
		</table>
	</div>
</div>

	
<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>