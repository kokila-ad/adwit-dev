<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_designer/head') ?>
<style>
.right{
	float: right;
}
</style>

<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>			

	<div id="main">
		<section>
    		<div class="container margin-top-80"> 
    			<div class="row margin-bottom-20 margin-top-20">  		 
					<div class="col-md-7">
						<p>
							<a href="#" class="text-blue">Order</a>
							<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
							<a href="#">Id:<?php echo $order_id['pd_id']; ?></a>
						</p>
				
					</div>
					  <div class="col-md-5 col-sm-12 col-xs-12">
					   		<form method="get"> 
								<div id="search">
									<div class="row">
										<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
							  				
										</div>
							 			<div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
											<a href="<?php echo base_url().index_page()."new_designer/home/page_index"?>" class="text-blue right"><i class="fa fa fa-angle-double-left"></i> back</a>
										</div>
						 			</div>	
						  			
						 		</div>
						 			
							</form>	 
					 	</div>					 
				</div>
			<div class="portlet-body">
				<?php foreach ($all as $key) 
				{
					$page_id= $this->db->query("SELECT * FROM `pages` WHERE pages.id='".$key['id']."';")->row_array();?>
					<div class="panel-group accordion " id="accordion3">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1<?php echo $key['id'];?>">
										<?php echo $key['page_no'];?> 
									</a>
								</h4>
							</div>
							<div id="collapse_3_1<?php echo $key['id'];?>" class="panel-collapse collapse">
								<div class="panel-body">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<th>Article </th>
											<th>Ads</th>
											<th>Note & Instruction</th>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
													$i=1; 
													$articles_path = $page_id['articles'];
        											if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path)) //check the notnull exitsfile and openfile
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
                												<?php echo "<b>".$i."."; ?>
                												<a href='<?php echo base_url().'page_design/articles'.'/'.$key['pd_id'].'/'.$key['id'].'/'.$file?>' target="_blank"><?php echo $file;?></a>
                											<?php }

                											$i++;
                										}
             											closedir($atp);//dirctry $atp clocsed
        											}
													?>
												</td>
												<td>
													<?php
													$i=1; 
													$articles_path = $page_id['ads'];
        											if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path)) //check the notnull exitsfile and openfile
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
                												<?php echo "<b>".$i."."; ?>
                												<a href='<?php echo base_url().'page_design/ads'.'/'.$key['pd_id'].'/'.$key['id'].'/'.$file?>' target="_blank"><?php echo $file;?></a>
                											<?php }

                											$i++;
                										}
             											closedir($atp);//dirctry $atp clocsed
        											}
													?>
												</td>
												<td>
													<?php echo "<b>".$key['note_instructions']."</b>";?>
												</td>
											</tr>
										</tbody>
									</table>   
								</div>
							</div>
						</div>
				<?php } ?>
					</div>
			</div>
		</div>
			
	</section>
	<section >
		
	</section>
</div>
<?php $this->load->view('new_designer/foot') ?>
					<!-- END ACCORDION PORTLET