<?php

$this->load->view('new_csr/head');
require_once 'simplexlsx-master/src/SimpleXLSX.php';
?>
<!-- BEGIN PAGE CONTAINER -->
 
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="row">
							<div class="col-md-6">
								Publication Name: <?php echo $publication_details[0]['name']; ?></br>
								Adrep Name: <?php echo $adrep_details[0]['first_name']; ?> <?php echo $adrep_details[0]['last_name']; ?>
							</div>
							<div class="col-md-6 text-right">
							<?php echo $this->session->flashdata('message');?>
								<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
							</div>
						</div>
					</div>
		
					<div class="portlet-body">
						<table class="table table-bordered table-hover" id="sample_6">
						<thead>
							<tr>
								<th>Unique Job Name</th>
								<th>Advertiser Name</th>
								<th>Width</th>
								<th>Height</th>
								<th>print_ad_type</th>
								<th>project_id</th>
								<th>Copy & Content</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php 
								
								$file_path =  'assets/xlsx_files/'.$adrep.'/*.xlsx';
								$files = glob($file_path);
								foreach($files as $filename){ 
								
								$inputFileName = $filename; 
								
								/*$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
								$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
								$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
								$data['arrayCount'] = $arrayCount;*/
								
								if ( $xlsx = SimpleXLSX::parse($inputFileName)) {
                                	// Produce array keys from the array values of 1st array element
                                	$header_values = $rows = [];
                                	foreach ( $xlsx->rows() as $k => $r ) {
                                		if ( $k === 0 ) { 
                                			$header_values = $r;
                                			continue;
                                		}
                                		
                                		$rows[] = array_combine( $header_values, $r );
                                	}
                                
                                	foreach($rows as $row){
                            
						
						?>
							<tr>
							<form name="form" method="post" enctype="multipart/form-data" class="horizontal-form">
								<td>
									<input type="hidden" name="job_name" value="<?php echo $row["Job Name"];?>"/>
									<?php echo $row["Job Name"]; ?>
								</td>
								<td>
									<input type="hidden" name="advertiser" value="<?php echo $row[" Advertiser Name"]; ?>" />
									<?php echo $row[" Advertiser Name"]; ?>
								</td>
								<td>
									<input type="hidden" name="width" value="<?php echo $row["Width"];?>"/>
									<?php echo $row["Width"];?>
								</td>
								<td>
									<input type="hidden" name="height" value="<?php echo $row["Height"];?>"/>
									<?php echo $row["Height"];?>
								</td>
								<td>
									<input type="hidden" name="print_ad_type" value="<?php echo $row["print_ad_type"];?>"/>
									<?php echo $row["print_ad_type"];?>
								</td>
								<td>
									<input type="hidden" name="project_id" value="<?php echo $row["Project_id"];?>"/>
									<?php echo $row["Project_id"];?>
								</td>
								<td>
									<input type="hidden" name="copy_content_description" value="<?php echo $row["Copy&Content"];?>"/>
									<?php echo $row["Copy&Content"];?>
								</td>
								<td><label>Art Instruction</label>
								<select id= "artinst" name="artinst">
									<option value="">Select</option>
									<?php foreach($artinst as $result) { ?>
									<option value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></option> <?php } ?>
									</select>
									</br></br>
									<label>Ad Type</label>
									<select id= "adtype" name="adtype">
									<option value="">Select</option>
									<?php foreach($adtype as $result1) { ?>
									<option value="<?php echo $result1['id']; ?>"><?php echo $result1['name']; ?></option> <?php } ?>
									</select></br></br>
									
									<input type="file" name="ufile[]" id="ufile[]" value="upload" /></br>
									<button type="submit" name="Submit" class="btn bg-red-intense border-radius-5">Submit</button>
								</td>
								</form>	
							</tr>
							   <?php } } } ?>
						</tbody>
						</table>
					</div>	
</div>
</div>	
</div>
</div>	
</div>
</div>

<?php $this->load->view('new_csr/foot')?>
