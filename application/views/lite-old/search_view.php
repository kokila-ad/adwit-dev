
				<div id="search">
				<div class="row">
				<form  role="form" method="post" action="<?php echo base_url().index_page().'lite/home/search_box'?>" >
					<div class="col-md-8 col-sm-8 col-xs-8 padding-right-0">
					  <input type="text" name="id" class="form-control height-38 text-theme" title="" placeholder="Search OrderID or JobName" required>
					</div>
					 <div class="col-md-4 col-sm-4 col-xs-4 padding-left-0">
					  <button type="submit" name="search" id="id" class="btn btn-primary  btn-lg btn-block margin-right-15 " required><span>Search</span> </button>
					</div>
				</form>
				</div>	
				  <p class="text-right margin-top-5">
					<a class="text-theme" id="showadvancesearch">advanced search</a>
				  </p>
				</div>
				 
				 <div class="row margin-0" id="advancesearch">
				  <form  role="form" method="post" action="<?php echo base_url().index_page().'lite/home/advance_search'?>" enctype="multipart/form-data">
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

	