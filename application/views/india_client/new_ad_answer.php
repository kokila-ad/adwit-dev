<?php $this->load->view('india_client/header'); ?>

 <link href="<?php echo base_url(); ?>assets/india_client/css/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/india_client/js/dropzone/dropzone.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

 <div id="main">
   
    <section>
      <div class="container margin-top-40 center">                        
			   	<p class="xlarge">Answer</p>  
      </div><!-- /.container -->
    </section><!-- /section -->
	
	 <section>
	 <form method="post">
	 <form method="post">
      <div class="container margin-top-10">   
	  <?php if(isset($question))?>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">			   
			   <p class="large margin-bottom-5">Question <span class="text-red">*</span> </p>
			   <p>
			   <?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>	
			</div>

			<div class="col-md-6 col-sm-6 col-xs-12">
				<p class="large margin-bottom-5">Answer <span class="text-red">*</span></p>
				<input type="text" name="answer" class="form-control margin-bottom-15" title="" style="height: 46px;" required >
					
					 <div class="row text-right">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />
							<button type="submit" name="submit" class="btn btn-primary btn-lg">SUBMIT</button>
					    </div>
					</div>
					 	 </form>
					<div class="row margin-top-20">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<form id="uploadfile" action="<?php echo base_url().index_page().'india_client/home/new_ad_answer'.'/'.$question['order_id']; ?>"  class="dropzone"> 
								<div class="col-md-12" id="drag">
									<div class="dz-default dz-message"><span><strong>Choose a file</strong> or drag it here</span></div>
								</div>
							</form>
						</div>
					</div>
			</div> 
		</div> 

	  </div>
	</section>
	</div>
	  
    
<?php $this->load->view('india_client/footer'); ?>
  

  
 