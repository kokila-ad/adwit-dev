<?php $this->load->view('new_client/header');?>
<style>

    .hidden {
        display: block !important;
    }
    
    ul.pagination {
        float: right;
        margin: 0px 0 !important;
    }
    div#user_data_filter {
        float: right;
    }
    
    .btn.btn-xs, .btn-xs.search-submit {
        font-size: 13px !important;
        padding: 6px 10px !important;
    }
</style>

<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="https://adwitads.s3.ap-south-1.amazonaws.com/adwitadsassets/new_csr/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>


<div id="main">

<section>
    <div class="container margin-top-20">
        <div class="row">
	 <?php 
	    $method_active = $this->uri->segment(3);  
	 ?>
		  <div class="col-md-7" id="heading">
		      <p>
		          <a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/dashboard';?>">
        								    Dashboard</a>
        		  <a class="btn btn-xs btn-dark margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/list_preorders_waukesha'; ?>">
        								    Pre-order</a>
			  </p>
		  </div>
		</div>
		<div class="row">		
			  <div class="col-md-12 margin-top-20">
				 <div class="table-responsive border padding-15">     
						<table class="table table-striped table-bordered table-hover" id="user_data">
						<thead>
							<tr>
								<th>Unique Job ID</th>
								<th>Advertiser Name</th>
								<th>AdRep Name</th>
								<th>Keyword</th>
								<th>Account No.</th>
								<th>Publication Name</th>
								<th>Publish Date</th>
								<th>Width</th>
								<th>Height</th>
								<th>Action</th>
						   </tr>  									
						</thead>
						<!--<tbody id="load_content">	
							
					   </tbody> -->        
					</table>
				 </div>
			 </div>
	  	  </div>
        </div>
	</div>
	</section>


<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>

<script>
$(document).ready(function(){ 
    //load table data
      var dataTable = $('#user_data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_client/home/list_preorders_waukesha_content'; ?>",  
                type:"POST"  
           },
            "ordering": true,
           "columnDefs":[  
                {  
                     "targets":[0, 1, 2, 3, 7, 8, 9],  
                     "orderable":false,  
                },  
           ],  
      }); 
      
    setInterval( function () {
        dataTable.ajax.reload();
    }, 120000 );

});
 

 
</script>