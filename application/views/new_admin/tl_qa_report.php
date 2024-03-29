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
		<div class="caption">
			<label>Date: <?php if(isset($d)){ $from1 = strtotime($d); echo date('M d, Y', $from1); } ?> (EST)</label>
		</div>
		<div class="margin-top-10 margin-bottom-10 text-right">
			<div class="btn-group left-dropdown">
				<form method="get">
					<div class="btn-group left-dropdown">							
						<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
							<i class="fa fa-filter cursor-pointer"></i> Filter
						</button>
						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu" id="show_filter">
							<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
							<input type="text" class="form-control border-radius-left" name="tl_hd_id" value="<?php echo $tl_hd_id ;?>" style="display:none;">
							<input type="text" class="form-control border-radius-left" name="date" placeholder="From Date">
							
								<div class="text-right margin-top-10">
									<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
		</div>
		
	</div>
	<div class="portlet-body">	
		<table class="table table-striped table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Help Desk</th>
					<th>0-1</th>
					<th>1-2</th>
					<th>2-3</th>
					<th>3-4</th>
					<th>4-5</th>
					<th>5-6</th>
					<th>6-7</th>
					<th>7-8</th>
					<th>8-9</th>
					<th>9-10</th>
					<th>10-11</th>
					<th>11-12</th>
					<th>12-13</th>
					<th>13-14</th>
					<th>14-15</th>
					<th>15-16</th>
					<th>16-17</th>
					<th>17-18</th>
					<th>18-19</th>
					<th>19-20</th>
					<th>20-21</th>
					<th>21-22</th>
					<th>22-23</th>
					<th>23-24</th>	
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach($hd as $h_row){
						for($i=1;$i<=24;$i++){ $t[$i] = '0'; }
						$orders = $this->db->query("SELECT  * FROM `cat_result` WHERE `help_desk` = '".$h_row['id']."' AND `tl_date` = '$d';")->result_array();
						foreach($orders as $row){
							$time_range = $this->db->get('time_range')->result_array();
							$order_time = strtotime($row['tl_time']);
							$i=0;
							foreach($time_range as $tr){ $i++;
								if($order_time >= strtotime($tr['from']) && $order_time <= strtotime($tr['to'])){ $t[$i]++ ;}
							}
							$tot_jobs = count($orders);
						}	
						?>
					<tr>
					<td><?php echo $h_row['name']; ?></td>
					<?php for($i=1;$i<=24;$i++){ ?> 
					<td><?php echo $t[$i]; ?> </td> 
					<?php } ?>
					<td><?php echo count($orders);?></td>
					</tr>
			<?php } ?>
			</tbody>		
		</table>
	</div>
</div>

	
<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>