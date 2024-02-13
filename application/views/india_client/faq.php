<?php $this->load->view('india_client/header'); ?>
<style>
video {  
   width:100%; 
   max-width:500px; 
   height:auto;
   border: 1px solid #eee;
}
iframe {  
   width:100%; 
   max-width:500px;   
   height: 280px;
   border: 1px solid #eee;
}
</style>

<script>
	 function onOver(x) {
		x.style.background="#ccc";
	 }
	 function onOut(x) {
		x.style.background="#eee";
	 }

     $(document).ready(function(){
     $("#video2").hide();

  
     $("#tab1").click(function(){
        $("#video1").show();
        $("#video2").hide();  
		$("#tab1-active").show();
		$("#tab2-active").css('background-color', 'red');
      });
	 
     $("#tab2").click(function(){
        $("#video1").hide();  
        $("#video2").show();  	
      });
	  
	 });
  </script>
  
   <div id="main">
   
  <section>
      <div class="container margin-top-20">         
        <div class="row">      		   	 
			          
			<div class="col-md-12">	
				<p class="margin-vertical-25 xlarge"> FAQ's</p>  
			</div>

				<div class="col-md-4 col-sm-8 col-xs-12 margin-bottom-10">				
					<div id="tab1-active">
						<div class="background-color-grey border cursor-pointer margin-bottom-5" id="tab1">
							<div class="padding-10" onmouseover="onOver(this)" onmouseout="onOut(this)">1a. How to place an Order</div>
						</div>
					</div>
					<div id="tab2-active">
						<div class="background-color-grey border cursor-pointer" id="tab2">
							<div class="padding-10" onmouseover="onOver(this)" onmouseout="onOut(this)">1b. How to use your Dashboard</div>
						</div>	
					</div>
				</div>
			   
				<div class="col-md-8 col-sm-8 col-xs-12">  			
				<div class="padding-20 border">
					 <div id="video1" class="center">
						<iframe src="https://www.youtube.com/embed/olFEpeMwgHk" frameborder="0" allowfullscreen></iframe>
						<p>1a. How to place an Order</p>
					 </div>
					 
					 <div id="video2" class="center">
						 <video controls>
							  <source src="video.mp4" type="video/mp4">
							   Your browser does not support the video tag.	   
						 </video>
						 <p>1b. How to use your Dashboard</p>
					 </div>
				</div>	 
					 
				</div>      
     
		</div><!-- /.row -->
      </div><!-- /.container -->
  </section><!-- /section -->
            </div>

            
<?php $this->load->view('india_client/footer'); ?>


