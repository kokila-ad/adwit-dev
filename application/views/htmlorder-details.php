<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>HTML Order Details | AdwitAds</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		

		
		<link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link href="https://adshub-adwit.s3.ap-south-1.amazonaws.com/adwit_adrep_v1/assets/css/adrep-custom.css" rel="stylesheet" type="text/css" />
		<!--begin::Page Vendor Stylesheets(used by this page)-->
	
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed">

	
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid" id="kt_wrapper">

					
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">

							
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
                                <div class="card mb-10">
									<div class="card-body  p-5 p-lg-8">
										
                                        <div class="row ">
                                            <div class="col-md-6  pb-6 pt-2 ps-4 pe-4">
                                                <div class="border border-radius-4 ">
                                                <div class="order-head fw-bolder ">
                                                    Order No : <?php echo $order[0]['id'];?>
                                                </div>
                                               <div class="row p-2">
                                               		<table class="table table-hover table-striped mt-2">
                                               			<tr>
                                               				<td class="p-2"><b>Ad Type : </b></td>
                                               				<td class="p-2">
                                               				<?php 
                                                                 if($order[0]['spec_sold_ad']==0){
                                                    			 echo 'New ad';
                                                    			 }
                                                    			 if($order[0]['spec_sold_ad']==1){ 
                                                    			 echo'Pickup/Template ad';
                                                    			 }
                                                    			 if($order[0]['spec_sold_ad']==2){
                                                    			 echo'Resize ad';
                                                    			 }
                                                             ?>
                                               				</td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Adrep Email id : </b></td>
                                               				<td class="p-2"><?php echo $client['email_id'];?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Adrep Name : </b></td>
                                               				<td class="p-2"><?php echo $client['first_name'].' '.$client['last_name'];?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Advertiser Name : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['advertiser_name'];?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Publication Name : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['publication_name'];?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Unique ID :  </b></td>
                                               				<td class="p-2"><?php echo $order[0]['job_no'];?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Width : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['width']; ?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Height : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['height']; ?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Date Needed : </b></td>
                                               				<td class="p-2">
                                               				    <?php if($order[0]['date_needed'] == '0000-00-00' || $order[0]['date_needed'] === NULL)
	{ echo ""; } else { $date = strtotime($order[0]['date_needed']); echo date('M d, Y', $date); // $order[0]['date_needed']; 
						}?>
                                               				</td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Publish Date : </b></td>
                                               				<td class="p-2">
                                               				    <?php if($order[0]['publish_date'] == '0000-00-00')
	{ echo ""; } else { $date = strtotime($order[0]['publish_date']); echo date('M d, Y', $date); //echo $order[0]['publish_date']; 
						} ?>
                                               				</td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Job Instruction : </b></td>
                                               				<td class="p-2">
                                               				<?php 
	
		 if($order[0]['job_instruction'] == '0' || $order[0]['job_instruction'] == ''){echo "";} else {
		 echo $order[0]['job_instruction']==1 ? 'Follow Instructions Carefully' : ($order[0]['job_instruction']==2 ? 'Be Creative' : 'Camera Ready Ad');
		 }
	  ?>
                                               				</td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Art Work : </b></td>
                                               				<td class="p-2">
                                               				<?php if($order[0]['art_work']==0 || $order[0]['art_work']=='' ){ echo ""; }else {
	  echo $order[0]['art_work']==1 ? 'Use additional art if required' : ($order[0]['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change');}
		?>
                                               				</td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Color Options : </b></td>
                                               				<td class="p-2">
                                               				<?php 
                                                   				if($order[0]['print_ad_type'] == '1')
                                                            	{ echo "Color"; }
                                                            		elseif($order[0]['print_ad_type'] == '2')
                                                            		{ echo "B&W"; }
                                                            		else { echo "Spot"; } 
                                                            ?>
                                                            </td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Color Preferences : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['color_preferences'];?></td>
                                               			</tr>
                                               			<tr>
                                               				<td class="p-2"><b>Font Preferences : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['font_preferences'];?></td>
                                               			</tr>
                                                        <?php if($order[0]['pickup_adno']!='') { ?>
                                                        <tr>
                                               				<td class="p-2"><b>Pickup Ad No. : </b></td>
                                               				<td class="p-2"><?php echo $order[0]['pickup_adno'];?></td>
                                               			</tr>
                                                        <?php } ?>
                                               		</table>
                                                   
                                               </div>
                                            </div>
                                              </div>
                                            <div class="col-md-6 pb-6 pt-2 ps-4 pe-4">
												<div class="border border-radius-4 ">
													<div class="order-head fw-bolder ">
														Copy/Content
													</div>
												   <div class="row">
													   <div class="col-md-12 ps-6 pt-6 pb-6">
														  <p>
														  <?php 
	//$order[0]['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $order[0]['copy_content_description']);echo $order[0]['copy_content_description']; 
	echo nl2br($order[0]['copy_content_description']);?>
														  </p>
														  
														</div>
												   </div>
												</div>

												<div class="border border-radius-4 mt-5">
													<div class="order-head fw-bolder ">
														Production Notes
													</div>
												   <div class="row">
													   <div class="col-md-12 ps-6 pt-6 pb-6">
														  <p><?php echo nl2br($order[0]['notes']); 
			//echo htmlspecialchars($order[0]['notes'], ENT_QUOTES, 'UTF-8');
			?></p>
														  
														</div>
												   </div>
												</div>
												<div id="sit-div"></div>
                                            <!--
												<div class="border border-radius-4 mt-5">
													<div class="order-head fw-bolder ">
														SIT
													</div>
												   <div class="row">
													   <div class="col-md-12 ps-6 pt-6 pb-6">
														  <p>Advertiser Name:</p>
														  
														</div>
												   </div>
												</div>
                                            -->  
                                                      
                                                        </div>
                                        </div>
                                <!--                
                                              </div>
                                        </div>

									
								
								
							</div>
							</div>
							
								
							</div>
						
						</div>
					
					
				</div>
				
			</div>
			
		</div>
		
	</body>
	
</html>-->