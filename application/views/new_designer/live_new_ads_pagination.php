<?php 
	$this->load->view("new_designer/head");
?>

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
				<div class="col-lg-12 margin-top-15">
				
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
						<!-- count Tab start -->
					<div class="collapse navbar-collapse navbar-ex1-collapse no-space"> 
						<?php if($designers['designer_role'] == '1' || $designers['designer_role'] == '2'){ ?>
							<ul class="nav navbar-nav">
							    <li class="tab_menu" data-id="MyQ" id="MyQList">
							        <label>&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></label>
								</li> 
								<li class="tab_menu" data-id="TotalQ" id="TotalQList">
									<label>&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></label>
								</li>
								<li class="tab_menu" data-id="DesignCheckQ" id="DesignCheckQList">
									<label>&nbsp; Design Check <span class="badge bg-blue" id="DcQ"> </span></label> 
								</li>
								<li class="tab_menu" data-id="DesignPendingQ" id="DesignPendingQList">
									<label>&nbsp; Pending <span class="badge bg-green" id="DpQ"></span></label> 
								</li>
								<li class="tab_menu" data-id="AllQ" id="AllQList">
									<label>&nbsp; All <span class="badge bg-green" id="AllQ"></span></label> 
								</li>
								<li class="tab_menu" data-id="QuestionSentQ" id="QuestionSentQList">
									<label>&nbsp; Question Sent <span class="badge bg-green" id="questionSent"></span></label> 
								</li>
							</ul>
						<?php }elseif($designers['designer_role'] == '3' || $designers['designer_role'] == '4'){ ?>
							<ul class="nav navbar-nav">
								<li class="tab_menu" data-id="MyQ" id="MyQList">
							        <label>&nbsp; My Q <span class="badge bg-green" id="MyQ"></span></label>
								</li> 
								<li class="tab_menu" data-id="TotalQ" id="TotalQList">
									<label>&nbsp; Total Q <span class="badge bg-blue" id="TotalQ"></span></label>
								</li>
								
							</ul>
						<?php } ?>
					</div>
					<!-- count Tab End -->	
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
				<!--<div class="tools">-->
				<!--<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>-->
				<!--</div>-->
			</div>
			<div class="portlet-body">
			    <table class="table table-striped table-bordered table-hover" id="userData">
				    
				</table>
				
			</div>
		</div>
	</div>
</div>
<!--Upload Pending-->	


		</div>
	</div>
</div>

<!-- confirmation modal starts here-->
<div class="modal fade" id="slugConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <form method="post">
    <div class="modal-content" style="width:85%">
      <div class="modal-header  portlet blue-hoki box" style="border-bottom: 0 !important;">
        <h5 class="modal-title portlet-title margin-top-10" style="margin-top: 0px !important; padding:10px !important;"  id="confirmationModalTitle"><center><b>Confirm Slug</b></center></h5>
      
      </div>
      <div class="modal-body"> 
      <div id="message"></div>
      <div class="text-center">
          <p name="slug_url" id="slug_url"> </p><i class="fa fa-clipboard" onclick="copySlug()" title="copy to clipboard"></i>
        </div>
      <div id="input_div" style="display:none;">
          <input name="cat_id" id="cat_id"> 
          <input name="help_desk_id" id="help_desk_id"> 
          <input name="slug_order_id" id="slug_order_id"> 
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="confirmSlug()">Confirm</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- confirmation modal ends here-->
<!-- END PAGE CONTENT -->
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<script type="text/javascript">
    $(document).ready(function(){
        // $('#userDataMyQ').hide();
        // $('#userDataTotalQ').hide();
        // $('#userDataDesignCheckQ').hide();
        // $('#userDataDesignPendingQ').hide();
        // $('#userDataAllQ').hide();
        if((localStorage.getItem('go_back_tab') != "" && localStorage.getItem('go_back_tab') != null) && (localStorage.getItem('display_type') != "" && localStorage.getItem('display_type') != null) ){
           loadTable(localStorage.getItem('display_type'));
           
        } 
    	$('.adwitad_id').on('hover',function(){ var id = $(this).data('adwitad_id'); alert('ID : '+id); });
    	getAdCount();//call for Tab Ad count
    	//call for datatable
    	//loadTable('MyQ');
    });
    
    function getAdCount(){
        	$.ajax({
        		url: "<?php echo base_url().index_page().'new_designer/home/tab_count_pagination';?>",
        		//cache: false,
        		success: function(data){
        			var myObj = JSON.parse(data);
        			$('#MyQ').html(myObj.MyQCount);
        			$('#TotalQ').html(myObj.TotalQCount);
        			$('#DcQ').html(myObj.DcQCount);
        			$('#DpQ').html(myObj.DpQCount);
        			$('#AllQ').html(myObj.AllQCount);
        			$('#questionSent').html(myObj.questionSentCount);	
        		}
        	});
        	//$('#MyQ').html('110');
        }
        
    function myFunction() {
        var checkbox= document.querySelector('input[name="assign[]"]:checked');
    	var checkbox1= document.querySelector('input[name="assign_designer[]"]:checked');
        if(!checkbox && !checkbox1) {
            alert('Please select!');
            return false;
        }
    
    }
    
    $(".tab_menu").on('click', function(){
        var display_type = $(this).data('id'); //alert(display_type);
        loadTable(display_type);
        var back_tab= "<?php echo base_url().index_page().'new_designer/home/live_new_ads/'?>";
        localStorage.setItem('go_back_tab',back_tab);
        localStorage.setItem('display_type',display_type);
    });
    
    function loadTable(display_type){
        //var dataTable;
        $('#caption').html(display_type);
        $('.tab_menu').removeClass('active');
        $('#'+display_type+'List').addClass('active');
        //$('#userData'+display_type).show();
        $.ajax({
    		url:"<?php echo base_url().index_page().'new_designer/home/live_new_ads_pagination_columns/'; ?>"+display_type, 
    		//cache: false,
    		success: function(data){
    		    columnNames = JSON.parse(data);
                 var columns = [];               
                                for (var i in columnNames) {
                                    columns.push({title:columnNames[i]});
                                }
                //console.log(columns);                
    			var dataTable = $('#userData').DataTable({  
                  "processing":true,  
                  "serverSide":true,  
                  "order":[],  
                  "ajax":{  
                        url:"<?php echo base_url().index_page().'new_designer/home/live_new_ads_pagination_details/'; ?>"+display_type,  
                        type:"GET",
                  },  
                  "columnDefs":[  
                        {  
                            // "targets":[],  
                            // "orderable":false, 
                            //hide the second column
                            'visible': false, 'targets': [0],
        
                        },  
                  ],
                  createdRow: function (row, data, index) {
                    //   console.dir(data[0]);
                    $(row).addClass(data[0]);
                },
                  "columns": columns,
                  "pageLength": 25,
                  "bDestroy": true
                });
                dataTable.column(0).visible(false);
                getAdCount();//call for Tab Ad count
    		}
    	});
        	
        
    }
    
    
</script>

<script type="text/javascript"> 
    function conf() { var con = alert("Please complete 'My Q' before you take a new ad(Allowed Limit In-Production: 3, In-QA: 10 Ads)."); } 

    function catconf() { var con=confirm("Lower category ads Not allowed.. As You still have higher category ads pending.."); }

    function createSlug(order_id){
	//ajax
			$.ajax({
					url: "<?php echo base_url().index_page();?>new_designer/home/createSlug/"+order_id,
					success: function(data) { 
					    var myObj = JSON.parse(data);
							var slug = myObj.slug;
							var alert_msg = myObj.msg;
							if(alert_msg != ''){
								alert(alert_msg);
								return false;
							}
					   		var X = confirm('Confirm Slug : '+slug);
						    if(X == true && slug != '')	 {
						     	var data_id = myObj.cat_id;
                    			var confirm_slug = 'none';
                    			var help_desk = myObj.help_desk;
                				//ajax
                				$.ajax({
                					url: "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id,
                					data:'slug='+slug+'&data_id='+data_id+'&confirm_slug='+confirm_slug,
                					type: "POST",
                					success: function(msg) { window.location.href = "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id; }
                				});	
                				return true;  
                			}else { 
								return false;  
                			}
					}
			});	
			return true;  
		
	}
    
    function create_slug(order_id){
    	$.ajax({
				url: "<?php echo base_url().index_page();?>new_designer/home/createSlug/"+order_id,
				success: function(data) { 
				    var myObj = JSON.parse(data);
						var alert_msg = myObj.msg;
						if(alert_msg != ''){
						  $('#message').text(alert_msg);
						  $('#slugConfirmationModal').modal('show');
						}else{
						   	var slug = myObj.slug;
						   	var data_id = myObj.cat_id;
                			var help_desk = myObj.help_desk;
                			$("#slug_url").text(slug);
                			$("#cat_id").text(data_id);
                			$("#help_desk_id").text(help_desk);
                			$("#slug_order_id").text(order_id);
                			$('#slugConfirmationModal').modal('show');
						}
				}
		});	
	}
	
	function confirmSlug(){
        var slug = $('#slug_url').text();
        var data_id =  $("#cat_id").text();
        var confirm_slug = 'none';
        var help_desk = $("#help_desk_id").text();
        var order_id = $("#slug_order_id").text();
    	$.ajax({
			url: "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id,
			data:'slug='+slug+'&data_id='+data_id+'&confirm_slug='+confirm_slug,
			type: "POST",
			success: function(msg) { 
			    $('#slugConfirmationModal').modal('hide');
			    window.location.href = "<?php echo base_url().index_page();?>new_designer/home/orderview/"+help_desk+"/"+order_id; 
			    
			}
		});	
	}
	
	function copySlug() {
        var text = $('#slug_url').text();
        // Create a temporary input element to copy the text
        var tempInput = document.createElement('input');
        tempInput.value = text;
        // Append the input element to the body
        document.body.appendChild(tempInput);
        // Select and copy the text
        tempInput.select();
        document.execCommand("copy");
        // Remove the temporary input element
        document.body.removeChild(tempInput);
        // alert("Copied the text: " + text);
    
    }
</script>

<?php 
	$this->load->view("new_designer/foot");
?>

<script>

 function getOrder(order_type){
	  var order_type = order_type;
	  if(order_type == "design_pending"){
	     var no_of_order = $("#new_design_pending_order").val();  
	  }else if (order_type == "upload_pending"){
	     var no_of_order = $("#new_upload_pending_order").val();   
	  }else if (order_type == "all_pending"){
	     var no_of_order = $("#new_all_pending_order").val();   
	  }
	  var dataString = "no_of_order="+no_of_order;
        // console.log(dataString);
    	$.ajax({
    		url: "<?php echo base_url().index_page().'new_designer/home/live_new_ads/';?>"+order_type,
    		type: 'POST',
    		data: dataString,
            success: function(response) {
                // Redirect the user to the new location
                window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/live_new_ads/'; ?>"+order_type;
            },
            error: function() {
                alert('Something went wrong!!');
            }
        }); 
        
	}
	
    function unset_new_upload_pending_session(){
	  $.ajax({
        type: 'POST',
		url: "<?php echo base_url().index_page().'new_designer/home/unset_new_upload_pending_session';?>",
        success: function(response) {
            // Redirect the user to the new location
            window.location.href = "<?php echo base_url() . index_page() . 'new_designer/home/live_new_ads/upload_pending'; ?>";
        },
        error: function() {
            alert('Something went wrong!!');
        }
    });  
	}
    
</script>