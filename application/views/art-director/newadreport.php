<?php
       $this->load->view("art-director/head.php"); 
?>

<!-- BEGIN HEADER -->
<?php
       $this->load->view("art-director/top_menu.php"); 
?>
<!-- END HEADER -->



<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
		        <div class="row">
        <div class="col-lg-12">
        <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									<h4>Select Publication & Date</h4>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->	
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<form class="navbar-form navbar-left" role="search" method="post">
									<div class="form-group">
									<select class="form-control" name="publication" required>
												<option value="">Select</option>
												<?php foreach($publications as $type) { ?>
												<option value="<?php echo $type['id'];?>" <?php if(isset($publication_id) && ($publication_id==$type['id']))echo 'selected'; ?> ><?php echo $type['name']; ?></option>
												<?php } ?>	
									</select>
									</div>
										<div class="form-group">
										<div class="input-group input-large date-picker input-daterange" data-date="2012/11/10" data-date-format="yyyy/mm/dd"> 
												<input type="text" class="form-control" name="from_date" id="from_date" value="<?php if(isset($from)) echo $from; ?>" >
												<span class="input-group-addon">
												to </span>
												<input type="text" class="form-control" id="to_date" name="to_date" value="<?php if(isset($to)) echo $to; ?>" >
											</div>
											<!-- /input-group -->
											<span></span>
									</div>
										<button type="submit"  value="Submit"class="btn blue">Search</button> 
									</form>
								</div>
								
							
								
								<!-- /.navbar-collapse -->
	</div>
	    </div>
        </div>
<?php if(isset($orders)): ?>
        <div class="row">
        <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Result</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th>Publication Name</th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<th>Total Ads</th>
								<th>Total Revision</th>
								<th>Sq Inch</th>
                                <th>Avg Sq Inch</th>
								</tr>
							</thead>
							<tbody name="testTable" id="testTable">
				<?php
				$total_ads = 0; $total_sq_inch = 0; $avg_sq_inch = 0;
				$cat_a = 0; $cat_b = 0; $cat_c = 0; $cat_d = 0; $cat_e = 0; $cat_f = 0; $cat_g = 0;
				$total_ads = count($orders);
						foreach($orders as $row){
							$sq_inch = 0; 
							$order_id = $row['id'];
							$sq_inch = ($row['width'] * $row['height']);
							$total_sq_inch = $total_sq_inch + $sq_inch;
							$cat_id = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` LIKE '%$order_id%' ;")->result_array();
							foreach($cat_id as $row1){
								if($row1['category'] == 'A' || $row1['category'] == 'a')
								{
									$cat_a++; 
								}
								if($row1['category'] == 'B' || $row1['category'] == 'b')
								{
									$cat_b++; 
								}
								if($row1['category'] == 'C' || $row1['category'] == 'c')
								{
									$cat_c++; 
								}
								if($row1['category'] == 'D' || $row1['category'] == 'd')
								{
									$cat_d++; 
								}
								if($row1['category'] == 'E' || $row1['category'] == 'e')
								{
									$cat_e++; 
								}
								if($row1['category'] == 'F' || $row1['category'] == 'f')
								{
									$cat_f++; 
								}
								if($row1['category'] == 'G' || $row1['category'] == 'g')
								{
									$cat_g++; 
								}
							}
						}
						if($total_ads != '0'){ $avg_sq_inch = $total_sq_inch / $total_ads; }
				?>
              <tr class="odd gradeX">
                <td><?php echo $publication_name[0]['name']; ?></td>
				<td><?php echo $cat_a; ?></td>
				<td><?php echo $cat_b; ?></td>
				<td><?php echo $cat_c; ?></td>
				<td><?php echo $cat_d; ?></td>
				<td><?php echo $cat_e; ?></td>
				<td><?php echo $cat_f; ?></td>
				<td><?php echo $cat_g; ?></td>
				<td><?php echo $total_ads; ?></td>
				<td>&nbsp;</b></td>
				<td><?php echo round($total_sq_inch, 2); ?></td>
				<td><?php echo round($avg_sq_inch, 2); ?></td>
			</tr>
			
            </tbody>
							
							</table>
						</div>
					</div>
				</div>
        </div>

<?php endif ?>		
        </div>
        </div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<?php
       $this->load->view("art-director/foot.php"); 
?>


