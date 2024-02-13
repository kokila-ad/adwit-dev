<?php 
	$this->load->view("new_designer/head");
?>
<style>
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
				<div class="col-lg-12 margin-top-15">
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
						
						<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
							<ul class="nav navbar-nav">
							    <?php if($designers[0]['designer_role'] == "1" || $designers[0]['designer_role'] == "3"){ ?>
    							    <li class="tab_menu" data-id="webMyQ" id="webMyQList">
    							        <label>&nbsp; My Q <span class="badge bg-green" id="webMyQ"><?php if(isset($upload_count)){echo $upload_count;}else{'0';}?></span></label>
    								</li> 
    								 <li class="tab_menu" data-id="webGeneralQ" id="webGeneralQList">
    							        <label>&nbsp; General Q <span class="badge bg-blue" id="webGeneralQ"><?php if($designers[0]['designer_role'] == "1"){echo count($orders);}else{echo $design_count; }?></span></label>
    								</li> 
    							<?php } if($designers[0]['designer_role'] == '2') {?>
    							    <li class="tab_menu" data-id="webGeneralQ" id="webGeneralQList">
    							        <label>&nbsp; Assign <span class="badge bg-blue" id="webGeneralQ"><?php if(isset($design_count)){echo $design_count;}?></span></label>
    								</li> 
    							<?php } if($designers[0]['designer_role'] == "1" || $designers[0]['designer_role'] == "2"){?>
    							    <li class="tab_menu" data-id="webDesignCheck" id="webDesignCheckList">
    							        <label>&nbsp; Design Check <span class="badge bg-blue" id="webDesignCheck"><?php if(isset($orders_inproduction)){echo count($orders_inproduction);}else{ echo '0';}?></span></label>
    								</li> 
    								<li class="tab_menu" data-id="webAllPending" id="webAllPendingList">
    							        <label>&nbsp; All Pending <span class="badge bg-blue" id="webAllPending"><?php echo count($orders_pending);?></span></label>
    								</li> 
    							<?php }?>
							</ul>
						</div> 
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
            				    <thead></thead>
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
<!-- BEGIN FOOTER -->
<?php 
	$this->load->view("new_designer/foot");
?>
<script>
 
    
    function loadTable(display_type){
       
        var designer_role  = "<?php echo  $designers[0]['designer_role'];?>";
        if((designer_role == "1" || designer_role =="2") && display_type=="webGeneralQ"){
            $('#caption').html("ASSIGN");
        }else if((designer_role != "1" || designer_role !="2") && display_type=="webGeneralQ"){
             $('#caption').html("DESIGN PENDING");
        }
        if(display_type == "webMyQ"){
            $('#caption').html("UPLOAD PENDING");
        }
        
        $('.tab_menu').removeClass('active');
        $('#'+display_type+'List').addClass('active');
        var target;
        //clear the local storage
       /* localStorage.removeItem('go_back_tab');
        localStorage.removeItem('display_type');*/
        if(display_type == 'webMyQ' && (designer_role == "1" || designer_role =="3")){ //upload_pending
            var columns = [ 
                        { title: 'No' },
                        { title: 'Date' },
                        { title: 'Type' },
                        { title: 'AdwitAds ID' },
                        { title: 'Unique Job Name' },
                        { title: 'Adrep' },
                        { title: 'Publication' },       
                        { title: 'Category' },
                        { title: 'Status' },
                        { title: 'Format' },
                        { title: 'Priority' }
                      ];
                    target =[0,7,8,9];
                      
        }else if(display_type == 'webGeneralQ' && (designer_role == "1" || designer_role =="2") ){ //design_pending
                var columns = [
                    { title: 'No' },
                    { title: 'Date' },
                    { title: 'Type' },
                    { title: 'AdwitAds ID' },
                    { title: 'Unique Job Name' },
                    // { title: 'Adrep' },
                    { title: 'Publication' },
                    { title: 'Category' },
                    { title: 'Ad Type' },
                    { title: 'Format' },
                    { title: 'DT' },
                    { title: 'Priority' }
                ];
                 target =[0,7,8,9];
            }else if(display_type == 'webGeneralQ' && designer_role != "1" && designer_role != "2"){
                var columns = [
                   { title: 'No' },
                    { title: 'Date' },
                    { title: 'Type' },
                    { title: 'AdwitAds ID' },
                    { title: 'Unique Job Name' },
                    // { title: 'Adrep' },
                    { title: 'Publication' },
                    { title: 'Category' },
                    // { title: 'Ad Type' },
                    { title: 'Format' },
                    { title: 'Design' },
                    { title: 'Status' },
                    { title: 'Priority' }
                ];
                target =[0,7,8,9];
            
        }else if(display_type == 'webDesignCheck' && (designer_role == "1" || designer_role =="2")){ //web_design_check
            var columns = [ 
                        { title: 'No' },
                        { title: 'Date' },
                        { title: 'T' },
                       { title: 'AdwitAds ID' },
                       { title: 'Unique Job Name' },
                       { title: 'Adrep' },
                       { title: 'Publication' },       
                       { title: 'DT' },
                       { title: 'C' },
                       { title: 'Status' },
                       { title: 'Priority' }
                      ];
                      target =[0,7,8,9];
        }else if(display_type == 'webAllPending' && (designer_role == "1" || designer_role =="2")){ //web_all_pending
            var columns = [
                       { title: 'No' },
                       { title: 'Date' },
                       { title: 'T' },
                       { title: 'AdwitAds ID' },
                       { title: 'Unique Job Name' },
                       { title: 'Adrep' },
                       { title: 'Publication' },       
                       { title: 'DT' },
                       { title: 'C' },
                       { title: 'Status' },
                       { title: 'Priority' }
                      ];
                      target =[0,7,8,9];
        }
       
        var dataTable = $('#userData').DataTable({  
           "processing":true,
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_designer/home/web_cshift_pagination_details/'; ?>"+display_type,  
                type:"GET",
                //data:{"fromDate":fromDate, "toDate":toDate, "action":'completed'}
           },  
           'columnDefs': [ {
                'targets': target, /* column index */
                'orderable': false, /* true or false */
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
        // $('#userData').DataTable().destroy();
    }
    
    $(".tab_menu").on('click', function(){
        var display_type = $(this).data('id'); 
        loadTable(display_type);
         var back_tab= "<?php echo base_url().index_page().'new_designer/home/web_cshift_pagination/'?>";
        localStorage.setItem('go_back_tab',back_tab);
        localStorage.setItem('display_type',display_type);
         /*var dataTableParams = $('#userData').DataTable().ajax.params();
        // Convert DataTable parameters to a query string
        var queryString = $.param(dataTableParams);
       localStorage.setItem('queryString',queryString);*/
        web_tab_count();
    });
    
    function web_tab_count(){
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/web_tab_count';?>",
    		//cache: false,
    		success: function(data){
    			var myObj = JSON.parse(data);
    			if(myObj.designer_role == '1'){
			    	$('#webMyQ').html(myObj.upload_count);
        			$('#webGeneralQ').html(myObj.orders);
        			$('#webDesignCheck').html(myObj.orders_inproduction);
        			$('#webAllPending').html(myObj.orders_pending);
    			}else if(myObj.designer_role == '2'){
    			    $('#webGeneralQ').html(myObj.design_count);
    			    $('#webDesignCheck').html(myObj.orders_inproduction);
        			$('#webAllPending').html(myObj.orders_pending);
    			}else if(myObj.designer_role == '3'){
    			    $('#webMyQ').html(myObj.upload_count);
    			    $('#webGeneralQ').html(myObj.design_count);
    			}
    			
    		}
    	});
    	    
    }
    
     $(document).ready(function(){
        if((localStorage.getItem('go_back_tab') != "" && localStorage.getItem('go_back_tab') != null) && (localStorage.getItem('display_type') != "" && localStorage.getItem('display_type') != null) ){
           loadTable(localStorage.getItem('display_type'));
           web_tab_count(); 
        } 
     });
    
</script>