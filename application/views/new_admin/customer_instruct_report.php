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
		<a href="<?php echo base_url().index_page(). 'new_admin/home/customer_instruct_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> -
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
				/*$query= "SELECT orders.id as ord_id, orders.notes as ord_note, rev_sold_jobs.id as rev_id, rev_sold_jobs.note as rev_note, rev_sold_jobs.version FROM `orders`
				LEFT JOIN `rev_sold_jobs` ON orders.id = rev_sold_jobs.order_id
				WHERE orders.publication_id = '".$p_row['id']."' AND orders.created_on like '$d%' ";*/
				$query= "SELECT orders.id, orders.notes as ord_note FROM `orders` WHERE orders.publication_id = '".$p_row['id']."' AND orders.created_on like '$d%'";	
				$orders = $this->db->query("$query")->result_array();
					
				foreach($orders as $order){
					$note = [];
					$rev_query= "SELECT rev_sold_jobs.id as rev_id, rev_sold_jobs.note as rev_note, rev_sold_jobs.version FROM `rev_sold_jobs` WHERE rev_sold_jobs.order_id = '".$order['id']."'";
					$rev_orders = $this->db->query("$rev_query")->result_array();
					foreach($rev_orders as $rev_order){
						$note[$rev_order['version']] = $rev_order['rev_note'];
				}
			?> 
			<tr>
			
				<td><?php echo $order['id'];?></td>
				<?php
					echo '<td width="10%">'.$order['ord_note'].'</td>';
					if(isset($note['V1a'])){ echo '<td>'.$note['V1a'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1b'])){ echo '<td>'.$note['V1b'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1c'])){ echo '<td>'.$note['V1c'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1d'])){ echo '<td>'.$note['V1d'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1e'])){ echo '<td>'.$note['V1e'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1f'])){ echo '<td>'.$note['V1f'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1g'])){ echo '<td>'.$note['V1g'].'</td>';}else{ echo '<td></td>';}
					if(isset($note['V1h'])){ echo '<td>'.$note['V1h'].'</td>';}else{ echo '<td></td>';}
					
					/*if($version == 'V1b'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1c'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1d'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1e'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1f'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1g'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}
					if($version == 'V1h'){ echo '<td>'.$order['rev_note'].'</td>';}else{ echo '<td></td>';}*/
				?>
			</tr>
			<?php } }  ?>
			</tbody>		
		</table>
	</div>
</div>

<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>