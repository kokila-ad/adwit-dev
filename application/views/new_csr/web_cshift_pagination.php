<?php $this->load->view("new_csr/head"); ?>
<!-- BEGIN PAGE CONTAINER -->
  <style>
  .tab_menu:hover{
    cursor:pointer;
}
    .tabletools-btn-group {
     display:none;
    }
    .active{
      color: #555;
      background-color: #e7e7e7;
    }
    .navbar-default .navbar-nav > li > label {
      color: #777;
    }
    .navbar-nav > li > label {
      padding-top: 10px;
      padding-bottom: 10px;
      line-height: 20px;
    }
    .nav > li > label {
      position: relative;
      display: block;
      padding: 10px 15px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    li > label {
      text-shadow: none;
      color: #5b9bd1;
    }
    li > label {
      text-shadow: none;
      color: #5b9bd1;
    }
    li > label {
      color: #337ab7;
      text-decoration: none;
    }
    li > label {
      background-color
    : transparent;
    }
</style>
<div class="page-container"> 
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row"> 
				<div class="col-lg-12">
					<div class="navbar navbar-default" role="navigation">
					    <div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">
							Toggle navigation </span>
							<span class="icon-bar">
							</span>
							<span class="icon-bar">
							</span>
							<span class="icon-bar">
							</span>
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse">
							<ul class="nav navbar-nav"  style="margin-top: 15px;">
							    <li class="tab_menu" style="padding-left: 18px !important;margin-left: 10px;" data-id="category" id="categoryList">Category
						            <span class="badge bg-red" id="category" ></span>
						        </li>
							     <li class="tab_menu" style="padding-left: 18px !important;margin-left: 12px;" data-id="QA" id="QAList">QA
						            <span class="badge bg-green" id="QA" ></span>
						        </li>
						        <li class="tab_menu" style="padding-left: 18px !important;margin-left: 12px;" data-id="new_pending" id="new_pendingList">All
						            <span class="badge bg-green" id="new_pending" ></span>
						        </li>
							
							</ul>
							<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
								<?php echo $this->session->flashdata('metro_message'); ?>
							</span>
							<ul class="nav navbar-nav navbar-right">
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/web';?>'" href="javascript:;">
									Web New Ad </a>
								</li>
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
	    
	    <div class="row">
            	<div class="col-md-12">
            		<div class="portlet light">
            			<div class="portlet-title">
            				<div class="caption">
            				    
            					<span class="caption-subject font-green-sharp bold" id="caption"></span>
            				</div>
            				<div class="tools">
            				<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
            				</div>
            			</div>
            			<div class="portlet-body">
            				<table class="table table-striped table-bordered table-hover" id="userData">
            				</table>
            			</div>
            		</div>
            	</div>
            </div>	
		</div>
		
</div>

</div>
	<!-- END PAGE CONTENT -->

</div>

<!-- END PAGE CONTAINER -->
<?php $this->load->view("new_csr/foot"); ?>

<script>
     
 $(".tab_menu").on('click', function(){
        var display_type = $(this).data('id'); 
        /*var back_tab= "<?php echo base_url().index_page().'new_csr/home/web_cshift_pagination/'?>";
        localStorage.setItem('go_back_tab',back_tab);
        localStorage.setItem('display_type',display_type);*/
        loadTable(display_type);
        webad_tab_count();
    });
    
    function loadTable(display_type){
        $('.tab_menu').removeClass('active');
        $('#'+display_type+'List').addClass('active');
        
        if(display_type == "category"){
            $('#caption').html("Category Pending List");
        }else if(display_type == "QA"){
           $('#caption').html("QA Pending List"); 
        }else{
           $('#caption').html("All Pending List"); 
        }
        
        var target;
        if(display_type == 'category'){ //category
            var columns = [ 
                        { title: '' },
                        { title: 'Date' },
                        { title: 'AdwitAds ID' },
                        { title: 'Unique Job Name' },
                        { title: 'Adrep' },
                        { title: 'Publication' },       
                        { title: 'view' }
                      ];
                    target =[0,6];
                      
        }else if(display_type == 'QA'){ //QA
                var columns = [
                    { title: '' },
                    { title: 'Date' },
                    // { title: 'Type' },
                    { title: 'AdwitAds ID' },
                    { title: 'Unique Job Name' },
                    { title: 'Adrep' },
                    { title: 'Publication' },
                    { title: 'QA' },
                   
                ];
                 target =[0,6];
            }else if(display_type == 'new_pending'){ //new_pending
            var columns = [ 
                        { title: '' },
                        { title: 'Date' },
                        // { title: 'Type' },
                       { title: 'AdwitAds ID' },
                       { title: 'Unique Job Name' },
                       { title: 'Adrep' },
                       { title: 'Publication' },       
                       { title: 'Status' }
                       
                      ];
                      target =[0,6];
        }
        // console.log(display_type);
        var dataTable = $('#userData').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_csr/home/web_cshift_pagination_details/'; ?>"+display_type,  
                type:"GET",
           },  
           'columnDefs': [ {
                'targets': target,
                'orderable': false,
             }],
           "columns": columns,
           createdRow: function (row, data, index) {
                if (data[0] == "1") {
                    $(row).addClass('bg-red-pink');
                }
            },
           "pageLength": 25,
           "bDestroy": true
        });	
        dataTable.column(0).visible(false);
    }
    
    function webad_tab_count(){
        $.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/webad_tab_count';?>",
    		//cache: false,
    		success: function(data){
    			var myObj = JSON.parse(data);
    			    $('#category').html(myObj.cat_count);
    			    $('#QA').html(myObj.QA_count);
    			    $('#new_pending').html(myObj.new_pending_count);
    		}
    	});
    }
    
    $(document).ready(function(){
             webad_tab_count();
    });
    
</script>