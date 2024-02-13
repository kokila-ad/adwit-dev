<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_designer/head');?>
<!-- BEGIN PAGE CONTAINER -->
<div id="main">
	<section>
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
	<?php echo $this->session->flashdata('message');?> 
		<div class="container">
		    <section>
              <div class="hor-menu ">
    				<ul class="nav navbar-nav" >
    					<li class="">
    						<a href="<?php echo base_url().index_page().'new_designer/home/page_index';?>" class="active">New Design</a>
    					</li>
    					<li class="">
    						<a href="<?php echo base_url().index_page().'new_designer/home/page_revision_design';?>">Revision Design</a>
    					</li>
    					
    				</ul>
			    </div>
            </section>
			<section>
    			<div class="container"> 
					<div class="row">	 			  
			  			<div class="col-md-12 margin-top-20 margin-bottom-20 border">
				 			<div class="">     
								<table class="margin-top-20 table table-striped table-bordered table-hover" id="example1">
									<thead>
										<tr>
											<td>Date</td>
											<td>Order ID</td>
											<td>Version</td>
											<td>Status</td>
											<td></td>
										</tr>  									
									</thead>
									<tbody>
										<?php foreach ($all as $value) {?>
											<tr>
												<td>
													<?php  
														$date = strtotime($value['created_on']); 
														echo date('F/d', $date);?>
												</td>	
												<td>
													<a href="<?php echo base_url().index_page()."new_designer/home/pages_details".'/'.$value['id'];?>">
														<?php echo $value['pd_id'];?>
													</a>
												</td>
												<td><?php echo $value['revision_version'];?></td>
												<td><?php 
							   							$status_name= $this->db->query("SELECT name FROM `page_rev_status` WHERE page_rev_status.id ='".$value['status']."';")->row_array();
							   							echo $status_name['name'];?>
							   					</td>
							   					<td>
							   						<?php if($value['status']=='1'){?>
							   						<form method="post" action="<?php echo base_url().index_page()."new_designer/home/page_rev_start_end/".$value['id'];?>">
							   							<button type="submit" name="start" class="btn btn-primary btn-sm">Start Revision</button>
							   						</form>
							   						<?php }elseif ($value['status']=='4') { ?>
							   							<a href="<?php echo base_url().index_page()."new_designer/home/pages_details".'/'.$value['id'];?>" class="btn btn-success btn-sm">View</button>
													<?php	
														}elseif($value['status']=='3'){
															$path = 'page_pdf/'.$value['pd_id'].'/'.$value['pdf_path'];
															if(file_exists($path)){
													?>
															<a target="_blank" href="<?php echo base_url().$path;?>" data-toggle="tooltip" data-original-title="pdf">
							   								<img class="action-img" src="<?php echo base_url(); ?>assets/new_designer/img/pdf.png">
															</a>
													<?php } } ?>
							   					</td>
											</tr>
										<?php }?>
									</tbody> 
								</table>
								<?php if(isset($all[0]['id'])){ ?>	
						<div class="row margin-top-10">  	
							<div class=" ">  	
								<div class="col-md-6 pull-right text-right prev-next-page">
									<?php $a = $offset + 1;
										if(count($all) == $rowsPerPage)
										{ 
											$next = $num + 1; $z = $offset + $rowsPerPage; 
										}else
										{ 
											$z = $order_count; 
										}
										if($num > 1)
										{ 
											$back = $num - 1; 
										}
										$key = "";
										if(isset($search_id))
										{ 
											$key = "?input=&keyword=".$search_id.""; 
										}
									?>
									<?php if(isset($back))
									{?>
										<a href="<?php echo base_url().index_page().'new_designer/home/page_revision_design/'.$back.$key; ?>" title="Back">
											<button class="btn btn-dark btn-outline btn-sm margin-right-5"><i class="fa fa-arrow-left"></i></button>
										</a>
							 		<?php } ?>
									<?php if(isset($next))
									{ ?>
										<a href="<?php echo base_url().index_page().'new_designer/home/page_revision_design/'.$next.$key; ?>" title="Next">
											<button class="btn btn-dark btn-outline btn-sm"><i class="fa fa-arrow-right"></i></button>
										</a>
					 				<?php } ?>
								</div>
								<div class="col-md-6 margin-bottom-20">
									<?php  echo "Showing ".$a." to ".$z." of ".$order_count." entries"; ?>
				    <?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
</div>
</div>
</section>
</div>
<?php $this->load->view('new_designer/foot');?>
