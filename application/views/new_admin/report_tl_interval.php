<?php $this->load->view('new_admin/header.php'); ?>

<!-- BEGIN PAGE CONTAINER -->
<div class="portlet light">

	<div class="portlet-title">

	<div class="row">

		<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">

			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - 
			<!--<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - -->

			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a>

			<?php  echo '- '.$team_lead[0]['name'].' ('.$team_lead[0]['username'].')' ; ?> -

			<?php if(isset($from) && isset($to)){echo date('M d, Y ',strtotime($from))." to ".date('M d, Y',strtotime($to));}elseif(isset($today)){echo date('M d, Y',strtotime($today));} ?>

		</div>

		<div>

			<?php if(null != $this->session->flashdata('message')){ ?>						

			<div class="alert alert-success padding-5 small margin-bottom-5 text-right"><?php echo '<span style="text-align: left;margin:0;">'.$this->session->flashdata('message').'</span>'; ?></div>

		<?php } ?>

		</div>

		<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">	

				<form method="get" >

					<div class="btn-group left-dropdown">							

						<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">

							<i class="fa fa-filter cursor-pointer"></i> Filter

						</button>

						<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">

						<div class="portlet light">

						<div class="portlet-body">

						<div class="row margin-top-10">
							<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">

								<input type="text" class="form-control border-radius-left" name="csr_id" value="<?php echo $tl_id ;?>" style="display:none;">

								<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" required>

								<input type="text" class="form-control border-radius-right margin-top-10" name="to" placeholder="To Date" required>
							</div>
							<div class="text-right margin-bottom-10">

								<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>

							</div>
						</div>
						</div>
						</div>
						</div>	
					</div>
				</form>
			</div>
			<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	

					<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>

			</div>
	</div>
	</div>

	<div class="portlet-body " >
		<div>
			<table class="table table-bordered table-hover" id="sample_6">
				<thead>					
					<tr>
						<th> Sl.no</th>
						
						<th> Job No</th>

						<th> Category</th>

						<th> TL time </th>
						
					</tr>

				</thead>

				<tbody> 
				<?php 
					foreach($team_lead as $row){
						$tl_id = $row['id'];
						$query = " SELECT cat_result.category, cat_result.order_no,  
						CONCAT(cat_result.tl_date,' ',cat_result.tl_time) as tl 
						FROM `cat_result`
						WHERE cat_result.tl_id = '$tl_id' AND CONCAT(cat_result.tl_date,' ',cat_result.tl_time) BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY cat_result.order_no ORDER BY CONCAT(cat_result.tl_date,' ',cat_result.tl_time) ASC ";
						
						$tl_time = 	$this->db->query($query)->result_array();
						$i=0;
					
						foreach($tl_time as $tl_row){  $i++;
						
						$s = strtotime($tl_row['tl']);
					?>
					<tr>
						<td><?php echo $i;?></td>
						
						<td><?php if(isset($tl_row['order_no'])){echo $tl_row['order_no'];} ?></td><!--Job No -->

						<td><?php if(isset($tl_row['category'])){echo $tl_row['category'];} ?></td><!--Category-->

						<td><?php if(isset($tl_row['tl'])){echo $tl_row['tl'];} ?></td><!--Start Time-->
						
					</tr>
					<?php  } }?>
				</tbody>
			</table>
		</div>
	</div>
</div>	

<?php $this->load->view('new_admin/footer.php'); ?>

<?php $this->load->view('new_admin/datatable.php'); ?>

