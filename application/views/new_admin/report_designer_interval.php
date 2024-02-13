<?php $this->load->view('new_admin/header.php'); ?>

<?php
    function foo($seconds) {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
    }
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="portlet light">

	<div class="portlet-title">

	<div class="row">

		<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">

			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - 
			<!--<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - -->

			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a>

			<?php  echo '- '.$designers[0]['name'].' ('.$designers[0]['username'].')' ; ?> -

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

								<input type="text" class="form-control border-radius-left" name="designer_id" value="<?php echo $designer_id ;?>" style="display:none;">

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
			<table class="table table-bordered table-hover" >
				<thead>					
					<tr>
						<th hidden> Sl.no</th>
						
						<th> Job No</th>

						<th> Category</th>

						<th> Designer Start time </th>

						<th> Designer End time </th>
						
						<th> Designer time taken </th>

						<th> Designer Interval </th>
						
					</tr>

				</thead>

				<tbody> 
				
				<?php 
					foreach($designers as $row){
						$des_id = $row['id'];
						$query = " SELECT cat_result.category, cat_result.order_no, designer_ads_time.start_time AS s, 
						CONCAT(designer_ads_time.end_date,' ',designer_ads_time.end_time) as dtl 
						FROM `cat_result`
						LEFT JOIN `designer_ads_time` ON cat_result.order_no = designer_ads_time.order_id 
						WHERE cat_result.designer = '$des_id' AND cat_result.ddate BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY designer_ads_time.order_id ORDER BY designer_ads_time.start_time ASC ";
						
						$design_time = 	$this->db->query($query)->result_array();
						$prev_dtl=0; $i=0; $counter=0; $s_p=0; $prev_end =0;$break_time_taken1=0;
						
						$s_p = date('Y-m-d',strtotime($from.'-1 day'));
						$dtl_p = date('Y-m-d',strtotime($to.'-1 day'));
						
						
						$query1 = " SELECT cat_result.category, cat_result.order_no, designer_ads_time.start_time AS start, 
						CONCAT(designer_ads_time.end_date,' ',designer_ads_time.end_time) as end ,
						CONCAT(cat_result.ddate,' ',cat_result.start_time) as p_date
						FROM `cat_result`
						LEFT JOIN `designer_ads_time` ON cat_result.order_no = designer_ads_time.order_id 
						WHERE cat_result.designer = '$des_id' AND CONCAT(cat_result.ddate,' ',cat_result.start_time) like '%".$s_p."%' GROUP BY designer_ads_time.order_id ORDER BY designer_ads_time.start_time DESC LIMIT 1";
						
						$design_time1 = $this->db->query($query1)->result_array();
						
						
						if(isset($design_time1) && isset($design_time[0]['s']) && isset($design_time1[0]['end'])){
						    $start = strtotime($design_time[0]['s']);
						    $prev_end = strtotime($design_time1[0]['end']);
						    $diff1 = $start - $prev_end;
						    $break_time_taken1 = foo($diff1); //floor(($diff1 / 60));
						}
						
						foreach($design_time as $d_row){  $i++;
						$designer_time_taken = 0; $break_time_taken = 0;  
						$s = strtotime($d_row['s']);
						$dtl = strtotime($d_row['dtl']);
						
						//designer time taken DTL1 minus S1
						$diff = $dtl - $s;
						$designer_time_taken = foo($diff);//floor(($diff / 60));
					
						//Break Time between jobs S2 minus DTL1(prev order dtl)
						
						$diff = $s - $prev_dtl;
						$break_time_taken = foo($diff);//floor(($diff / 60));
						
					?>
					<tr>
						<td hidden><?php echo $i; ?></td>
						
						<td><?php if(isset($d_row['order_no'])){echo $d_row['order_no'];}?></td><!--Job No -->

						<td><?php if(isset($d_row['category'])){echo $d_row['category'];}?></td><!--Category-->

						<td><?php if(isset($d_row['s'])){echo $d_row['s'];} ?></td><!--Start Time-->

						<td><?php if(isset($d_row['dtl'])){echo $d_row['dtl'];} ?></td><!--Send to DTL-->
						
						<td><?php echo $designer_time_taken;?></td><!--Designer Time taken(mins)-->
						
						<td><?php if($counter == 0){
										echo $break_time_taken1;
										$counter++;
								  }else{
									echo $break_time_taken ;}
							?>
						</td>
						<!--Break time between time(mins)-->
						
					</tr>
					<?php 
						$prev_dtl = $dtl;
					} }
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>	

<?php $this->load->view('new_admin/footer.php'); ?>

<?php $this->load->view('new_admin/datatable.php'); ?>

