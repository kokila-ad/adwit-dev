<?php $this->load->view('india_client/header'); ?>
<script>
  $(document).ready(function(){
  $("#show-add1").hide();
  $("#show-add2").hide();
  $("#show-add3").hide();
  $("#show-add4").hide();
  
  $("#add1").click(function(){
  $("#show-add1").show();     
   });
   
  $("#add2").click(function(){
  $("#show-add2").show();     
   });
   
  $("#add3").click(function(){
  $("#show-add3").show();     
   });
   
  $("#add4").click(function(){
  $("#show-add4").show();     
   });
     
  });
</script>
 <div id="main">
   
    <section>
      <div class="container margin-top-40 center">                        
			   	<p class="xlarge">Request Order</p>  
      </div><!-- /.container -->
    </section><!-- /section -->
	
	 <section>
      <div class="container margin-top-10">   
	  <form method="post" enctype="multipart/form-data">
	   <div class="row">
	    <div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Subject<span class="text-red">*</span></p>
	       <input type="text" name="subject" class="form-control input-sm margin-bottom-15" title="" style="height: 46px;" required>
		   
		   <p class="margin-bottom-5">Message <span class="text-red">*</span> </p>
	       <textarea rows="3" name="message" class="form-control margin-bottom-15"required></textarea>	
		 </div>

		<div class="col-md-6 col-sm-6 col-xs-12">
		   <p class="margin-bottom-5">Attachments <span class="text-red">*</span></p>
	      
		<div class="row margin-0">
				<div class="col-md-11 col-sm-11 col-xs-10 padding-0">
					<div class="border padding-10  margin-bottom-15"><input type="file" name="userfile[]" id="userfile" value="upload" required/></div>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-2 padding-0">
					<button type="button" class="btn btn-dark btn-sm btn-block padding-15" id="add1"><i class="fa fa-plus"></i></button>
				</div>
		   </div>
			<div class="row margin-0" id="show-add1">
				<div class="col-md-11 col-sm-11 col-xs-10 padding-0">
					<div class="border padding-10  margin-bottom-15"><input type="file" name="userfile[]" id="userfile" value="upload"/></div>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-2 padding-0">
					<button type="button" class="btn btn-dark btn-sm btn-block padding-15" id="add2"><i class="fa fa-plus"></i></button>
				</div>
		   </div>
		   <div class="row margin-0" id="show-add2">
				<div class="col-md-11 col-sm-11 col-xs-10 padding-0">
					<div class="border padding-10  margin-bottom-15"><input type="file" name="userfile[]" id="userfile" value="upload"/></div>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-2 padding-0">
					<button type="button" class="btn btn-dark btn-sm btn-block padding-15" id="add3"><i class="fa fa-plus"></i></button>
				</div>
		   </div>
		   <div class="row margin-0" id="show-add3">
				<div class="col-md-11 col-sm-11 col-xs-10 padding-0">
					<div class="border padding-10  margin-bottom-15"><input type="file" name="userfile[]" id="userfile" value="upload"/></div>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-2 padding-0">
					<button type="button" class="btn btn-dark btn-sm btn-block padding-15" id="add4"><i class="fa fa-plus"></i></button>
				</div>
		   </div>
		   <div class="row margin-0" id="show-add4">
				<div class="col-md-12 col-sm-12 col-xs-12 padding-0">
					<div class="border padding-10  margin-bottom-15"><input type="file" name="userfile[]" id="userfile" value="upload"/></div>
				</div>
			</div>
		    <div class="row text-right">
				<div class="col-md-12 col-sm-12 col-xs-12 ">
					<button type="submit" name="submit" class="btn btn-primary btn-sm">SUBMIT</button>
				</div>
			</div>
		</div> 
	
	</div> 
	 <?php if(isset($status)) { ?>
		<div class="alert alert-info alert-outline center padding-5 margin-top-20" id="show">
            <p>Your request has been submited, <a href="<?php echo base_url().index_page()."india_client/home/dashboard/2";?> " class="text-grey"><small>click to view</small></a></p>
        </div>
	<?php } ?>
	  </div>
	</section>
	</div>
	</form>   
    
<?php $this->load->view('india_client/footer'); ?>
  
  