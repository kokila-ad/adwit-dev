<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('new_client/header') ?>
<style>
.right{
	float: right;
}
</style>
<link href="<?php echo base_url();?>assets/new_client/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/new_client/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>	

<div id="main">
	<section>
    	<div class="container margin-top-80"> 
    		<div class="row margin-bottom-20">  		 
				<div class="col-md-7">
					<p>
						<a href="#">Pagination ID: <?php echo $order_id['pd_id'];?></a>
					</p>
				</div>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<div id="search">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0"></div>
							 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
								<a href="<?php echo base_url().index_page()."new_client/home/page_dashboard/"?>" class="text-blue right"><i class="fa fa fa-angle-double-left"></i> back</a>
							</div>
						 </div>	
					</div>
				</div>					 
			</div>
			
			<div class="portlet-body">
			<?php 
				foreach ($all as $value) 
				{
					$page_id= $this->db->query("SELECT * FROM `pages` WHERE pages.id='".$value['id']."';")->row_array();
					
			?>
				<div class="panel-group accordion margin-bottom-5" id="accordion3">
					<div class="panel panel-default">
					    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1<?php echo $value['id'];?>">
    						<div class="panel-heading">
    							<h4 class="panel-title"><?php echo $value['page_no']; ?> <span class="caret right"></span></h4>
    						</div>
						</a>
						<div id="collapse_3_1<?php echo $value['id'];?>" class="panel-collapse collapse">
							<div class="panel-body">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th>Article / Images</th>
										<th>Ads</th>
										<th>Notes & Instruction</th>
									</thead>
									<tbody>
										<tr>
											<td><?php
												$i=1; 
												$articles_path = $page_id['articles'];
        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
        										{
            										while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            										{
                										if ($file == '.' || $file == '..')  //.,.. get 
                										{
                    										continue; // left that and continue next
                										}?>
                									<?php
                										if($file) // file get 
                										{?>
                											<table>
                												<tr>
		                											<?php echo $i."."; ?>
		                											<a href='<?php echo base_url().'page_design/articles'.'/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
		                												<?php echo $file;?>
		                											</a>
		                										</tr>
		                									</table>
                								<?php   }
                										$i++;
                									}
             										closedir($atp);//dirctry $atp clocsed
        										}?></td>
											<td><?php
												$i=1; 
												$articles_path = $page_id['ads'];
        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
        										{
            										while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            										{
                										if ($file == '.' || $file == '..')  //.,.. get 
                										{
                    										continue; // left that and continue next
                										}?>
                									<?php
                										if($file) // file get 
                										{?>
                											<table>
                												<tr>
		                											<?php echo $i."."; ?>
		                											<a href='<?php echo base_url().'page_design/ads'.'/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
		                												<?php echo $file;?>
		                											</a>
                												</tr>
                											</table>
                								<?php   }
                										$i++;
                									}
             										closedir($atp);//dirctry $atp clocsed
        										}?></td>
											<td><?php echo $value['note_instructions'];?></td>
										</tr>
									</tbody>
								</table>   
							</div>  
							
							<?php 
							    $mess = $this->db->query("SELECT pages.attch_article, pages.attch_ads, page_message.message FROM `pages` INNER JOIN `page_message` ON page_message.pages_id = pages.id WHERE page_message.pages_id ='".$value['id']."' ")->result_array();
							    foreach ($mess as $key) {
							?>
							
							<div class="panel-body">
							    <div>
								    <p class="margin-bottom-5">Additional Attachments</p>
							    </div>
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th>Article / Images</th>
										<th>Ads</th>
										<th>Notes & Instruction</th>
									</thead>
									<tbody>
										<tr>
											<td>
                							<table class="table table-striped table-bordered table-hover">
												<tbody>
											<?php
												$i=1; 
												$articles_path = $key['attch_article'];

        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
        										{
            										while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            										{
            											
                										if ($file == '.' || $file == '..')  //.,.. get 
                										{
                    										continue; // left that and continue next
                										}?>
                									<?php
                										if($file) // file get 
                										{?>
	                												<tr>
	                													<td>
			                												<?php echo "<b>".$i.".";date_default_timezone_set('Asia/Kolkata');?>
			                											</td>
			                											<td>
			                												<?php echo $dat =date("F d/h:i A",filemtime($articles_path.'/'.$file));?>
			                											</td>
	                													<td>
			                												<a href='<?php echo base_url().'page_design/attachments/articles/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
																				<?php echo $file;?>
			                												</a>
			                											</td>
			                										</tr>
			                										<?php   }
                										$i++;
                									}
             										closedir($atp);//dirctry $atp clocsed
        										}?>
		                										</tbody>
		                									</table>
                								</td>
											<td>
                								<table class="table table-striped table-bordered table-hover">
                								    <tbody>
                							<?php
												$i=1; 
												$articles_path = $key['attch_ads'];
        										if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path))
        										{
            										while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            										{
                										if ($file == '.' || $file == '..')  //.,.. get 
                										{
                    										continue; // left that and continue next
                										}
                									    if($file) { 
                							?>
	                												<tr>
	                													<td>
	                														<?php echo "<b>".$i.".";?>
	                													</td>
			                											<td>
			                												<?php echo $dat =date("F d/h:i A",filemtime($articles_path.'/'.$file));?>
			                											</td>
			                											<td>
			                												<a href='<?php echo base_url().'page_design/attachments/ads'.'/'.$value['pd_id'].'/'.$value['id'].'/'.$file?>' target="_blank">
			                													<?php echo $file;?>
			                												</a>
			                											</td>
	                												</tr>
	                						<?php           }
                										    $i++;
                									    }
             										    closedir($atp);
        									    	}
        									   ?>
        									            </tbody>
                								    </table>
                								</td>
											<td><?php echo $key['message'];?></td>
										</tr>
									</tbody>
								</table>   
							</div> 
							<?php } ?> 
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view('new_client/footer') ?>