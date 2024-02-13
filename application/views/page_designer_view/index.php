<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_designer/head');?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
		<div class="container">
		<?php echo $this->session->flashdata('message');?> 
		    <section>
              <!--<div class="container margin-top-40 center"> 
        		 <a href="<?php echo base_url().index_page().'new_designer/home/page_index';?>" class="btn btn-sm btn-dark btn-outline">New Ads</a>
        		 <a href="<?php echo base_url().index_page().'new_designer/home/page_revision_design';?>" class="btn btn-sm btn-dark btn-outline">Revision Ads</a>
              </div>-->
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
											<td>ID</td>
											<td>Unique Job Name</td>
											<td>Publish Date</td>
											<td>No of Pages</td>
											<td>Status</td>
											<td colspan="2"></td>
											<!-- <td>Status</td> -->
										</tr>  									
									</thead>
									<tbody>
									<?php 
									if(isset($all[0]['id'])){
										foreach ($all as $value) { ?>
											<tr>
												<td>
													<?php  
														$date = strtotime($value['created_on']); 
														echo date('F/d', $date);?>
												</td>	
												<td><?php echo $value['id'];?></td>
												<td>
													<a href="<?php echo base_url().index_page()."new_designer/home/pages_details".'/'.$value['id'];?>">
														<?php echo $value['unique_job_name'];?>
													</a>
												</td>
												<td><?php echo $value['publish_date'];?></td>
												<td><?php echo $value['No_of_pages'];?></td>
												<td><?php 
							   							$status_name= $this->db->query("SELECT name FROM `page_design_status` WHERE page_design_status.id ='".$value['status']."';")->row_array();
							   							echo $status_name['name'];?>
							   					</td>
							   					<td style="text-align: center;">
							   						<?php if ($value['status'] <= '2' && $value['status']!='0') {?>
							   						<form method="post" action="<?php echo base_url().index_page()."new_designer/home/page_start_end/".$value['id'];?>">
							   							<button type="submit" name="start" class="btn btn-primary btn-sm">Start Design</button>
							   						</form>
							   						<?php }elseif ($value['status']=='3') {?>
							   							<a href="<?php echo base_url().index_page()."new_designer/home/pages_details/".$value['id'];?>" class="btn btn-success btn-sm">View</button>
							   					<?php	} ?>
							   					</td>
							   					
							   					<td style="text-align: center;">
							   						<?php if ($value['pdf']!=NULL) 
							   							{
							   								$pid= $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id ='".$value['id']."';")->row_array();?>
							   								<a target="_blank" href="<?php echo base_url().index_page()."new_designer/home/page_pdf".'/'.$pid['pd_id'];?>" data-toggle="tooltip" data-original-title="pdf">
							   								<img class="action-img" src="<?php echo base_url(); ?>assets/new_designer/img/pdf.png">
															</a>
							   					<?php	} ?>
							   					</td>
							   					<!--<td>
							   						<img class="action-img" src="<?php echo base_url(); ?>/assets/designer/img/close_icon.png">
							   					</td> -->
											</tr>
										<?php } } ?>
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
										<a href="<?php echo base_url().index_page().'new_designer/home/page_index/'.$back.$key; ?>" title="Back">
											<button class="btn btn-dark btn-outline btn-sm margin-right-5"><i class="fa fa-arrow-left"></i></button>
										</a>
							 		<?php } ?>
									<?php if(isset($next))
									{ ?>
										<a href="<?php echo base_url().index_page().'new_designer/home/page_index/'.$next.$key; ?>" title="Next">
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
			</section>
		</div>
	</div>
</div>
<?php $this->load->view('new_designer/foot');?>
