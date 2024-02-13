<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

<!-- pagination -->
		<link rel="stylesheet" type="text/css" href="assets/css/pagination/datatables.min.css"/> 
		<script type="text/javascript" src="assets/css/pagination/datatables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').DataTable( {
					"order": [[ 1, "desc" ]]
				} );
			} );

			$(document).ready(function() {
				$('#example').DataTable();
			} );
			
			
		</script>		
<!-- endpagination -->
<script>
  $(document).ready(function(){
  $("#show-search").hide();
  
  $("#open-search").click(function(){
  $("#show-search").toggle();     
   });
	 
  });
</script>

<section>
      <div class="container margin-top-30">   
					
					<?php echo $this->session->flashdata('message'); ?>	
		<div class="row">
		      <div class="col-md-6"><p class="xlarge">Invoice</p>  </div>
			<form>  
			  <div class="col-md-6 text-right padding-bottom-5">
				 <p class="btn btn-primary text-theme padding-top-10 cursor-pointer" id="open-search">Search</p>
			  </div>
			 </form>
        </div>
		
	   <div class="row margin-0 border"  id="show-search">  		 
		  <div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-left-0">  
             <p class="center margin-top-25 large"> No New Notifications</p>		  
			 <div class="row margin-0 background-color-lightred border-red hide">
			 
                 <div class="col-md-1 col-sm-1 col-xs-1 center background-color-red padding-0"> 
		            <p class=" padding-top-10 text-white"><a href="#"><i class="glyphicon glyphicon-check"></i></a></p>					
		        </div> 					
	        </div>	 
	     </div> 		  
 
			<div class="col-md-6 col-sm-12 col-xs-12 padding-15 padding-right-0  border-left">
				<div id="search">
				<div class="row">
				<form  role="form" method="post" action="<?php echo base_url().index_page().'customer/home/search_box'?>" enctype="multipart/form-data">
					<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
					  <input type="text" name="id" class="form-control height-38 text-theme" title="" placeholder="Search OrderID or JobName" required>
					</div>
					 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
					  <button type="submit" name="search" id="id" class="btn btn-primary  btn-lg btn-block margin-right-15 " required><span>Search</span> </button>
				</form>
					</div>
				 </div>	
				  <p class="text-right margin-top-5">
					<a class="text-theme" id="showadvancesearch">advanced search</a>
				  </p>
				</div>
				 
				 <div class="row margin-0" id="advancesearch">
				  <form  role="form" method="post" action="<?php echo base_url().index_page().'customer/home/advance_search'?>" enctype="multipart/form-data">
					<div class="col-md-12 col-sm-12 col-xs-12 background-color-theme padding-bottom-15">
					  <p class="padding-top-10 margin-bottom-5">Search Keywords</p>
					  <input type="text" name="id" class="form-control height-38 text-theme" title="" placeholder="Search keywords" required> 
					   <div class="row">
					   
						  <div class="col-md-6 col-sm-6 col-xs-12 background-color-theme">
							<p class="padding-top-10 margin-bottom-5">From</p>
							<input type="date" name="from" class="form-control height-38" title="" placeholder="YY-MM-DD">
						  </div>
						  
						  <div class="col-md-6 col-sm-6 col-xs-12 background-color-theme">
							<p class="padding-top-10 margin-bottom-5">To</p>
							<input type="date" name="to" class="form-control height-38" title="" placeholder="YY-MM-DD">
						  </div>	
					   </div>
					   <div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12 background-color-theme">
							<p class="padding-top-10 margin-bottom-5">Select Status</p>
							<input type="number" name="status" class="form-control height-38" title="" placeholder="Status">
						  </div>
						  <div class="col-md-6 col-sm-6 col-xs-12 background-color-theme">
							<button type="submit" name="search" id="id" class="btn btn-dark btn-outline btn-lg margin-top-35 "required> <span>SEARCH</span></button>
							</form>
							<span class="float-right margin-top-55 text-white"><a class="text-theme" id="showsearch">« back</a></span>
						  </div>	
					   </div>					   
					</div>
				 </div>			 
			</div>
		</div>		 
	
	  </div>	  
</section>


<section>
    <div class="container">
		<div class="margin-bottom-30">
			<div class="table-responsive border padding-20 margin-top-10">    
			  <table class="table table-striped table-bordered table-hover" id="example">
				<thead>
				  <tr>
					  <th class="background-color-light">Date</th>
					  <th class="background-color-light">No of Credits</th>
					  <th class="background-color-light">Price</th>
					  <th class="background-color-light">Download</th>
				  </tr>
				</thead>

				<tbody>	
					<tr class="odd">
						<td>2016-07-08</td>
						<td>845</td>
						<td>$ 510</td>
						<td>demo123</td>
					</tr>
				</tbody>      
			  </table>
			</div>
		</div>
    </div>
</section>

<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>