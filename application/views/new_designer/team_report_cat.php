<?php $this->load->view('new_designer/head')?>
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12 margin-top-10">
				<?php echo $designer[0]['name']; ?>
				<spam class="text-center bold">
					<?php 
					    if(isset($from) && isset($to)){
							$d_from = strtotime($from); $d_to = strtotime($to); 
							echo ' - '.date('d M Y', $d_from).' To '.date('d M Y', $d_to); 
						}else{ 
							$d_today = strtotime($today);
						    echo ' - '.date('d M Y', $d_today); 
						} 
					?>
				</spam>
			</div>				
			<div class="col-md-5 col-xs-12 margin-top-10 text-right">	
				<button onclick="goBack()" class="btn btn-default btn-xs">← Back</button>
			</div>
		</div>
	</div>
		
	<div class="portlet-body">
		<table class="table table-bordered table-hover" id="sample_6">
		<thead>
			<tr>
				<th>P</th>
				<th>M</th>
				<th>N</th>
				<th>T</th>
				<th>W</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		        $p_count = 0; $m_count = 0; $n_count = 0; $t_count = 0; $w_count = 0;
				foreach($cat_result as $c_row){
            	    if($c_row['category'] == 'P'){ $p_count = $c_row['ad_count']; }
            	    if($c_row['category'] == 'M'){ $m_count = $c_row['ad_count']; }
            	    if($c_row['category'] == 'N'){ $n_count = $c_row['ad_count']; }
            	    if($c_row['category'] == 'T'){ $t_count = $c_row['ad_count']; }
            	    if($c_row['category'] == 'W'){ $w_count = $c_row['ad_count']; }
            	}	
		?>
		
			<tr>
				<td><?php echo $p_count; ?></td><!--P -->
				<td><?php echo $m_count; ?></td><!--M-->
				<td><?php echo $n_count; ?></td><!--N-->
				<td><?php echo $t_count; ?></td><!--T-->
				<td><?php echo $w_count; ?></td><!--W-->
			</tr>
		</tbody>
		</table>
	</div>	
</div>
</div>	
</div>
</div>
<?php $this->load->view('new_designer/foot')?>
