<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $this->load->view('new_csr/head');
 ?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-content">
		<div class="container">
		<?php echo $this->session->flashdata('message');?> 
		    <section>
                <div class="hor-menu ">
				    <ul class="nav navbar-nav" >
					    <li class="active">
						    <a href="<?php echo base_url().index_page().'new_csr/home/page_index';?>" class="active">New Design</a>
					    </li>
				    	<li class="">
						    <a href="<?php echo base_url().index_page().'new_csr/home/page_revision_design';?>">Revision Design</a>
				    	</li>
					</ul>
			    </div>
            </section>
    
			<section>
    			<div class="container"> 
					<div class="row">	 			  
			  			<div class="col-md-12 margin-top-20 margin-bottom-20 border">
				 			<div class="">     
								<table class="margin-top-20 table table-striped table-bordered table-hover" id="user_data">
									<thead class="darkgrey">
										<tr>
											<td>Date</td>
											<td>ID</td>
											<td>Page Design ID</td>
											<td>Unique Job Name</td>
											<td>Publish Date</td>
											<td>Advertiser</td>
											<td>Adrep</td>
											<td>Status</td>
											<td>Action</td>
										</tr>  									
									</thead>
									
								</table>
							</div>
						</div>
	                </div>
                </div>	
			</section>
		</div>
	</div>
</div>

<?php $this->load->view('new_csr/foot');?>

<script type="text/javascript">

    $(document).ready(function(){
        LoadTableContent();    
    });

    function LoadTableContent(){ //alert(status);
        
        //load data table
        var dataTable = $('#user_data').DataTable({
            "destroy": true, //reinitialise the table content
           "processing":true,  
           "serverSide":true,
           "order":[],  
           "ajax":{  
                url: "<?php echo base_url().index_page().'new_csr/home/page_index'; ?>",  
                type: "GET",
                data: {'table_load':'content'}
           },  
           "columnDefs":[  
                {  
                     "targets":[0],  
                     "orderable":false,  
                },  
           ],  
      });     
    }
    
</script>