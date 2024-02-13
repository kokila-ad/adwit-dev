 <?php $this->load->view("new_csr/head"); ?>
<!-- BEGIN PAGE CONTAINER -->
 <script>
	function sluf_confirm123(){    
	    var X=confirm('Confirm To Proof Check!!');	
	    if(X==true){ return true; }else{ return false; }
	} 
	
	function confirm_proof_check(help_desk,order_id){
      $("#selected_help_desk").val(help_desk);
      $("#selected_order_id").val(order_id);
      $("#proofConfirmationModal").modal("show"); 
    }
    
    var base_url = "<?php echo base_url(); ?>";
    var index_page = "<?php echo index_page(); ?>";
    
    function confirm(){
        help_desk = $("#selected_help_desk").val();
        order_id = $("#selected_order_id").val();
        var form = document.getElementById("proof_check_form");
        // Append the input element to the "proof_check_div"
        var submitInput = '<input type="text" name="proof_check">';
        $('#proof_check_div').append(submitInput);
         form.action = base_url + index_page + 'new_csr/home/orderview/' + help_desk + '/' + order_id;
        // Close the modal
        $('#proofConfirmationModal').modal('hide');
        // Submit the form
        form.submit();
    }
     
    function unset_categorised_ad(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_csr/home/unset_categorised_ad';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_csr/home/live_new_ads/category'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}

	function goBack(){ window.history.back(); }

	function myFunction() {
		location.reload();
	}
	

</script>
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
				<div class="col-lg-12"><?php echo $this->session->flashdata('message'); ?>
					<div class="navbar navbar-default" role="navigation">
						<!-- Brand and toggle get grouped for better mobile display -->
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
	<?php $form=''; ?>					
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse no-space">
						    <ul class="nav navbar-nav" style="margin-top: 15px;">
						    <?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3'){ ?>
						        <li class="tab_menu" style="padding-left: 18px !important;" data-id="category" id="categoryList">Order Acceptance  
						            <span class="badge bg-red" id="category" ></span>
						        </li>
						   <?php }?>
						   <?php if($csr['csr_role'] == '1' || $csr['csr_role'] == '2' || $csr['csr_role'] == '3'){ ?>
						        <li class="tab_menu" style="padding-left: 18px !important;" data-id="QA" id="QAList"> My Ads
						            <span class="badge bg-green" id="QA"></span>
						        </li>
						         <li class="tab_menu" style="padding-left: 18px !important;" data-id="total_QA" id="total_QAList"> Team Ads
						            <span class="badge bg-green" id="total_QA"></span>
						        </li>
						   <?php }?>
						   <?php if($csr['csr_role'] == '2' || $csr['csr_role'] == '3'){ ?>
						        <li class="tab_menu" style="padding-left: 18px !important;" data-id="new_pending" id="new_pendingList">All
						            <span class="badge bg-green" id="new_pending"></span>
						        </li>
						   <?php }?>

					
						</ul>
							<span style="margin-left: 20px; padding: 0 10px;" class="font-blue margin-top-10">	
								<?php echo $this->session->flashdata('metro_message'); ?>
							</span>
							<ul class="nav navbar-nav navbar-right  margin-right-10">
							<?php if($form=='2'){ ?>
							<li class="margin-top-10">
								<form class="search-form"  name="form" method="post" action="<?php echo base_url().index_page().'new_csr/home/metro_order_search'; ?>">
									<div class="col-sm-8"  style="padding: 0;">
										<input type="text" class="form-control" placeholder="Metro Order Search" name="id" required>
									</div>
									<div class="col-md-4"   style="padding: 0;">
										<button type="submit" name="search" class="btn blue"><i class="fa fa-search"></i></button>
									</div>
								</form>
					  
							</li>
						
							<li>
								<a href="<?php echo base_url().index_page()."new_csr/home/metro_orders";?>">Aod Orders</a>
							</li>
							<?php }elseif($form=='5'){ ?>	<!-- MAP orders for Design6 help_desk-->
								<li>
									<a href="<?php echo base_url().index_page()."new_csr/home/map_orders";?>" target="_blank">Map Orders</a>
								</li>
							<?php } ?>
							
								<?php if($form=='12'){ ?>
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_entries';?>'" href="javascript:;">
									Vidn Entries </a>
								</li>
							<?php 
								} 
							    $club_id_array = explode(',', $csr['club_id']);
							    if(in_array(4, $club_id_array)){
							?>
						        <li>
									<a href="<?php echo base_url().index_page().'new_csr/home/cshift/2';?>" target="blank">
									Metro Ads </a>
								</li>
							<?php } ?>	
								<li>
									<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/new_cat/'.$form;?>'" href="javascript:;">
									Create New Ad </a>
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

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b>Success</b></center></h5>
      </div>
      <div class="modal-body">
        Ad is successfully categorised <b style="color:#67809F;"><?php echo $this->session->userdata('ad_categorised')?></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="unset_categorised_ad()">Close</button>
      </div>
    </div>
  </div>
</div>
					
<!--metro ad sent-->

<!--metro ad sent-->	
		</div>
	</div>
</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- Modal starts here-->
<div class="modal fade" id="proofConfirmationModal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="confirmationModalTitle" style="margin-top: 0px !important; padding:10px !important;"><center><b></b></center></h5>
      </div>
      <div class="modal-body">
       <center><b>Confirm To Proof Check!!</b></center>
      </div>
      <input style="display:none"  id="selected_help_desk" name="selected_help_desk">
      <input style="display:none" id="selected_order_id" name="selected_order_id">
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="confirm()">Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal ends here-->

<script>
function printPage() {
    window.print();
} 
</script>
<script>
        
        var tableToExcel = (function() {
                
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, filename) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: filename || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<?php $this->load->view("new_csr/foot"); ?>

<script>
 $(document).ready(function(){
if((localStorage.getItem('go_back_tab') != "" && localStorage.getItem('go_back_tab') != null) && (localStorage.getItem('display_type') != "" && localStorage.getItem('display_type') != null) ){
           loadTable(localStorage.getItem('display_type'));
           newad_tab_count();
           localStorage.removeItem('new_ads');
            
        }else{newad_tab_count();} });
        
 $(".tab_menu").on('click', function(){
        var display_type = $(this).data('id'); //alert(display_type);
        var back_tab= "<?php echo base_url().index_page().'new_csr/home/live_new_ads_pagination/'?>";
        localStorage.setItem('go_back_tab',back_tab);
        localStorage.setItem('display_type',display_type);
        localStorage.setItem('new_ads',"new_ads");
        loadTable(display_type);
        newad_tab_count();
    });
    
    function loadTable(display_type){
        
        $('.tab_menu').removeClass('active');
        $('#'+display_type+'List').addClass('active');
        var target;
        if(display_type == 'category'){ //category
            var columns = [ 
                        { title: '' },
                        { title: 'Date' },
                        { title: 'AdwitAds ID' },
                        { title: 'Unique Job Name' },
                        { title: 'Adrep' },
                        { title: 'Advertiser Name' },
                        { title: 'Publication' },       
                        { title: 'click to' },
                        { title: 'Priority' }
                      ];
                    target =[0,7];
                      
        }else if(display_type == 'QA'){ //QA
                var columns = [
                    { title: '' },
                    { title: 'Date' },
                    { title: 'Type' },
                    { title: 'AdwitAds ID' },
                    { title: 'Unique Job Name' },
                    { title: 'Adrep' },
                    { title: 'Publication' },
                    { title: 'click to' },
                    { title: 'Priority' }
                ];
                 target =[0,7];
            }else if(display_type == 'new_pending'){ //new_pending
            var columns = [ 
                        { title: '' },
                        { title: 'Date' },
                        { title: 'Type' },
                       { title: 'AdwitAds ID' },
                       { title: 'Unique Job Name' },
                       { title: 'Adrep' },
                       { title: 'Publication' },       
                       { title: 'click to' },
                       { title: 'Priority' }
                      ];
                      target =[0,4,7];
        }else if(display_type == 'total_QA'){ //total_QA
            var columns = [
                       { title: '' },
                       { title: 'Type' },
                       { title: 'AdwitAds ID' },
                       { title: 'Unique Job Name' },
                       { title: 'Adrep' },
                       { title: 'Publication' },       
                       { title: 'Category' },
                       { title: 'Click To' },
                       { title: 'Priority' }
                      ];
                      target =[0,7];
        }
        // console.log(display_type);
        var dataTable = $('#userData').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_csr/home/live_new_ads_pagination_details/'; ?>"+display_type,  
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
                if(data[0] != "1" && data[0] != ""){
                    $(row).addClass(data[0]); 
                }
            },
           "pageLength": 25,
           "bDestroy": true
        });	
        dataTable.column(0).visible(false);
    }
    
    
    function newad_tab_count(){
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_csr/home/newad_tab_count';?>",
    		//cache: false,
    		success: function(data){
    			var myObj = JSON.parse(data);
    			if(myObj.csr_role == '1'){
			    	   $('#QA').html(myObj.myQ_count);
    			       $('#total_QA').html(myObj.generalQ_count);
    			}else if(myObj.csr_role == '2'  || myObj.csr_role == '3'){
    			    $('#category').html(myObj.category_count);
    			    $('#QA').html(myObj.myQ_count);
    			    $('#total_QA').html(myObj.generalQ_count);
        			$('#new_pending').html(myObj.all_count);
    			}
    		}
    	});
    	    
    }
</script>