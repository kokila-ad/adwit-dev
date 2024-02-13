<?php $this->load->view("head.php"); ?>
<?php $this->load->view("customer/header.php"); ?>
<style>
.min-height-155{
	min-height: 155px;
}
</style>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<section>
    <div class="container">

        <div class="padding-vertical-50">
            <div class="row">
                                     
    <div class="col-md-12 padding-0 border-theme">
        <div class="portfolio-content">
		<form method="post">
        <div class="row background-color-theme margin-0">
                <div class="col-sm-6"><h4>AD DETAILS</h4></div>
                <div class="col-sm-6 text-right" ><p class="padding-top-10"> <small><?php echo $orders[0]['created_on']; ?></small></p></div>
        </div>
             <div class="col-sm-6"> 
				<ul class="portfolio-list margin-0">
					<li class="no-border-top">
						<span class="name">Job Name:</span>
						<span class="value"><?php echo $orders[0]['job_no']; ?></span>
					</li>

					<li>
						<span class="name">Width:</span>
						<span class="value"> <?php echo $orders[0]['width']; ?></span>
					</li>
					
					<li class="no-border-bottom">
						<span class="name">Color:</span>
						<?php $color_preference = $this->db->get_where('lite_color_preference',array('id' => $orders[0]['print_ad_type']))->result_array(); ?>
						<span class="value"> <?php echo $color_preference[0]['name']; ?></span>
					</li>
				</ul>
             </div>
             <div class="col-sm-6"> 
				<ul class="portfolio-list margin-0">
					<li class="no-border-top">
						<span class="name">Date Needed:</span>
						<span class="value"><?php echo $orders[0]['date_needed']; ?></span>
					</li>
					
					<li>
						<span class="name">Height:</span>
						<span class="value"> <?php echo $orders[0]['height']; ?></span>
					</li>
					
					<li class="no-border-bottom">
                                <span class="name">Uploaded Files:</span>
                                <span class="value dropdown">
									<span class="cursor-pointer" type="button" data-toggle="dropdown">View FIles
										<span class="caret"></span>
									</span>
									<div class="table-responsive dropdown-menu file_li ">  
										<table class="table table-striped table-hover" id="mytable">
											 <tbody>
											 <?php if(isset($map)) { $i=1;  foreach($map as $fmap)  { ?>
												 <tr>
													<td><?php echo $i ?></td>
													<td><?php echo $fmap; 	$i++; ?></td>												
												 </tr>
											 <?php  } } ?> 
											</tbody>
										</table>
									</div>	
								</span>
                            </li>
				</ul>        
             </div>
              <div class="col-sm-12"> 
                  <div class="center border-thicktop"> 
                      <h5>Copy/Content:</h5>
                      <p class="lightgray"><?php echo $orders[0]['copy_content_description']; ?></p>
                  </div>
              </div>
             <div class="col-sm-12 margin-bottom-15 "> 
                  <div class="center border-thicktop "> 
                  <h5>Instructions:</h5>
                  <p class="lightgray"><?php echo $orders[0]['notes']; ?></p>
                  </div>
             </div>
			</div>
			
				<div class="col-sm-6 margin-bottom-15"> 
                  <div class="center"> 
                  <h5>Reason:</h5>
                  <textarea rows="5" name="reason" class="form-control min-height-155"></textarea>
				 <div class="text-right">
				<button type="submit" name="submit" class="btn btn-info  margin-top-20"> Submit </button>
				 </form>
			 </div>
                  </div>
             </div>	  
			
				<div class="col-sm-6 margin-bottom-20"> 
					<div class="center"> 
						<h5 >File Upload:</h5>  
						<form  action="<?php echo site_url('/customer/home/revision/'.$orders[0]['id']); ?>"  class="dropzone" > 
							<div class="dz-default dz-message margin-top-50"><span><strong>Choose a file</strong> or drag it here</span></div>
						</form>
						
					</div>
				</div>
			</div>   
      </div>
        </div><!-- /.padding-vertical-50 -->


    </div><!-- /.container -->
</section><!-- /section -->
  
 <?php $this->load->view("customer/footer.php"); ?>
 <?php $this->load->view("foot.php"); ?>
 

