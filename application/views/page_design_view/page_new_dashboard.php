<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $this->load->view('new_client/header') 
?>
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css'>	
	<link href="<?php echo base_url();?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url();?>assets/js/scripts.bundle.js"></script>
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
        
        div#DataTables_Table_0_filter {
            float: right;
        }
        div.dataTables_wrapper div.dataTables_filter {
            padding: 0.2rem 0;
        }
        div.dataTables_wrapper div.dataTables_length {
            padding: 0.2rem 0;
        }
        .sub-table {
            border: 1px solid #444 !important;
            border-bottom-color: rgb(68, 68, 68);
            border-bottom-style: solid;
            border-bottom-width: 1px;
            background: #daeae6 !important;
            border-bottom: 1px solid #333 !important;
        }
        #DataTables_Table_0_processing {
            transform: translateX(-1.6%) translateY(-0%);
            width: 100%;
            text-align: center;
            margin: auto !important;
            background-color: #00000017 !important;
            box-shadow: 0 0 160px 0px rgba(11, 11, 11, 0.33) !important;
            position: absolute;
            bottom: 0px !important;
            border-radius: 0rem !important;
            height: 100%;
            padding-top:200px !important;
        }
            
        .pagination > .disabled > a{
                         background-color: #fff0;
        }
        .action-img {
            max-width: 20px;
        }
        /*drop down arrow */
        .arrow {
    	  width: 12px;
    	  height: 12px;
    	  position: absolute;
    	 
    	  font-size: 12px;
    	}
    	.arrow span {
    	  
    	  position: absolute;
    	  width: 8px;
    	  height: 2px;
    	  background-color: rgb(0, 0, 0);
    	  display: inline-block;
    	  transition: all 0.2s ease;
    	}
    	.arrow span:first-of-type {
    	  left: 0;
    	  transform: scale(0.9) rotate(45deg);
    	}
    	.arrow span:last-of-type {
    	  right: 2px;
    	  transform: scale(0.9) rotate(-45deg);
    	}
    	.arrow.active span:first-of-type {
    	  transform: scale(0.9) rotate(-45deg);
    	}
    	.arrow.active span:last-of-type {
    	  transform: scale(0.9) rotate(45deg);
    	}
    	.arrow:hover {
    	  cursor: pointer;
    	}
    </style>
<div id="main">
    <section>
        <div class="container margin-top-50"> 
		
				<div class="row">  		 
					
					<div class="col-md-7">
					<span>Team Orders  </span>
						<label class="switch">
							<input type="checkbox" id="team_orders" <?php if(isset($adrep_detail) && $adrep_detail['team_orders'] == '1')echo'checked'; ?>>
							<small></small>
						</label>
					</div>
					  <div class="col-md-5 col-sm-12 col-xs-12 right">
						<a href="<?php echo base_url().index_page().'new_client/home/dashboard'; ?>" class="btn btn-sm btn-dark btn-outline">Back</a>
	
					 	</div>			
						 
					</div>	  
		
					<div class="row">
						<div class="col-md-9 padding-15">
							<div class="btn-group w-100 " data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
							<!--    
								<label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success active all" data-kt-button="true">
									
									<input class="btn-check status" type="radio" name="status" checked="checked" value="all">
									
									All<span class="badge bg-green" id="All"></span>
								</label>
								
								<label class="production btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success " data-kt-button="true">
									
									<input class="btn-check status" type="radio" name="status" value="inproduction">
									
								   In Production<span class="badge bg-green" id="InProduction"></span>
								</label>
							

								
								<label class="proof btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
								
									<input class="btn-check status" type="radio" name="status" value="proofready">
									
								   Proof Ready<span class="badge bg-green" id="ProoReady"></span>
								</label>
								

								
								<label class="questions btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
									
									<input class="btn-check status" type="radio" name="status" value="question">
									
									Questions<span class="badge bg-green" id="Question"></span>
								</label>
								
								 <label class="approved btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
									
									<input class="btn-check status" type="radio" name="status" value="approved">
									
									Approved<span class="badge bg-green" id="Approved"></span>
								</label>
								
								-->
							</div>
						</div>
						<div class="col-md-3 padding-15">
						    <p  class="margin-bottom-5">Select date range</p>
							<input class="form-control form-control-solid " placeholder="Pick date rage" id="kt_daterangepicker_4"/>
						</div>
					</div>
   
		<div class="row ">	 

			 		  
		    <div class="col-md-12  alltable">
			    <div class="table-responsive border padding-15">     
					<table class="kt_datatable_example_5 table table-striped table-bordered table-hover table-row-bordered gy-5 gs-7 border rounded " >
						<thead>
							<tr class="fw-bolder fs-6 text-gray-800 px-7">
								<!--<td>Adwitads ID</td>-->
								<td>Page Design ID</td>
								<td>Publish Date</td>
								<td>Page Name / Number</td>
								<td>Publication/Edition Name</td>
								<td>Ad Rep Name</td>
								<td>Status</td>
								<td width="20%">Action</td>
						   </tr>  									
						</thead>
						
					</table>
					
							
				</div>
			</div>
			
	  	  </div>
        
	    </div>
    </section>

</div>


 <!-- Approve action pop up window -->
    <div class="modal fade bs-example-modal-new" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    	<div class="modal-dialog">
    	  <!-- Modal Content: begins -->
    	    <div class="modal-content">
        		<!-- Modal Header -->
        		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="gridSystemModalLabel">Approve page</h4>
        		</div>
    	  
        		<!-- Modal Body -->  
        		<div class="modal-body">
        		  <div class="body-message">
        			<p></p>
        		  </div>
        		</div>
    	  
        		<!-- Modal Footer -->
        		<div class="modal-footer">
        		  <button type="button" class="btn btn-blue btn-sm btn-circle blue " data-dismiss="modal">Submit</button>
        		</div>
    	    </div>
    	  <!-- Modal Content: ends -->
    	</div>
	</div>
 <!-- Add new page pop up window 
    <div class="modal fade add-page-modal" id = "add-page-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    	<div class="modal-dialog">
    	  
    	    <div class="modal-content">
    	        
        		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="gridSystemModalLabel"></h4>
        		</div>
        		<div class="modal-body">
    	            
        		</div>
    	    </div>
    	  
    	</div>
	</div> 
Add new page pop up window END -->

<!-- Trigger the modal with a button -->

 <?php //$this->load->view('new_client/privacy_footer') ?>

    <footer class="footer">
           <div class="footer-copyright ">
               <div class="page-footer">
					<div class="container">
						<div class="copyright">
							<p>2020 © adwitads. All Rights Reserved. version 5.0</p>
						</div>
						<div class="footer-nav margin-top-5">
							<nav class="padding-0">
								<ul>
									<li><a href="https://adwitads.com/weborders/index.php/new_client/home/about">About Us</a></li>
									<li><a href="https://adwitads.com/weborders/index.php/new_client/home/contact_us">Contact Us</a></li>
									<li><a href="https://adwitads.com/weborders/index.php/new_client/home/terms_of_use">Terms of Use</a></li>
									<li><a href="https://adwitads.com/weborders/index.php/new_client/home/privacy_policy">Privacy Policy</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
           </div>     
    </footer>
</div>
  
    <script src="https://adwitads.com/weborders/assets/new_client/js/awe-hosoren.js"></script>	
	<script src="https://adwitads.com/weborders/assets/new_client/js/jquery-ui.min.js"></script>	
	<script src="https://adwitads.com/weborders/assets/new_client/js/plugins/bootstrap.min.js"></script>
    <script src="https://adwitads.com/weborders/assets/new_client/js/plugins/awemenu.min.js"></script>
    <script src="https://adwitads.com/weborders/assets/new_client/js/plugins/headroom.min.js"></script>
    <script src="https://adwitads.com/weborders/assets/new_client/js/plugins/jquery.parallax-1.1.3.min.js"></script>
    <script src="https://adwitads.com/weborders/assets/new_client/js/plugins/jquery.nanoscroller.min.js"></script>
    <script src="https://adwitads.com/weborders/assets/new_client/js/plugins/list.min.js"></script>	
    <script src="https://adwitads.com/weborders/assets/new_client/js/main.js"></script>

    <script src="<?php echo base_url();?>assets/js/plugins.bundle.js"></script>
	<script src="<?php echo base_url();?>assets/js/datatables.bundle.js"></script>

<script>
		/*18/5/2022*/
		$(document).on("click", '.arrow', function(event) {
    		if ($(this).hasClass('active')) {
    			$(this).removeClass('active');
    		} else {
    			$(this).addClass('active');
    		}
		});
		/*18/5/2022*/

</script>

<script type="text/javascript">

    $(document).ready(function(){
        // pre defined date range//
        var start = moment().subtract(1, 'days');
        var end = moment();
        
        $('#kt_daterangepicker_4').daterangepicker({
           buttonClasses: ' btn',
           applyClass: 'btn-primary',
           cancelClass: 'btn-secondary',
        
           startDate: start,
           endDate: end,
           ranges: {
              'Today': [moment(), moment()],
              //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 14 Days': [moment().subtract(13, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'Last 60 Days': [moment().subtract(59, 'days'), moment()],
              'Last 90 Days': [moment().subtract(89, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
        }, function(start, end, label) {
           $('#kt_daterangepicker_4 .form-control').val( start.format('DD MMMM, YYYY') + ' / ' + end.format('DD MMMM, YYYY'));
           
           $("#dashboard_v3").html("Loading Productivity by Designer...");
           
            var dateRange = start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD');
            //console.log('dateRange : '+dateRange);
            
            //Load table content and ads count
            var status = $('input[name="status"]:checked').val();   //get status(radio button checked)
            var from_date = start.format('MM/DD/YYYY');
            var to_date = end.format('MM/DD/YYYY');
            
            //called when there is change in daterange
            LoadTableContent(status, from_date, to_date); //load table content
            //adsCount(from_date, to_date); //load/refresh ads count
        });
        
        //When initial document load get time range from datepicker
            var dval = $('#kt_daterangepicker_4').val();
            var array = dval.split(' - ');
            var from_date = array[0];
            var to_date = array[1];
            
            LoadTableContent('all', from_date, to_date); //load table content
            //adsCount(from_date, to_date); //load/refresh ads count
    });
    
    //on click(change) of status tab
        $('.status').on('change', function(){
        //get time range from datepicker
        var dval = $('#kt_daterangepicker_4').val();
        var array = dval.split(' - ');
        var from_date = array[0];
        var to_date = array[1];
            var status = $(this).val();
            //alert('status : '+status);
            LoadTableContent(status, from_date, to_date); //load table content
            //adsCount(from_date, to_date); //load/refresh ads count
        });
        
//dashboard ads count    
    function adsCount(from_date, to_date){
        //dashboard ads count
        
        //console.log('from_date : '+from_date+' to_date : '+to_date);
        $.post('page_dashboard_ads_count', {'from_date':from_date, 'to_date':to_date}, function(result){
            //alert(result);
            var myObj = JSON.parse(result);
    			$('#All').html(myObj.AllCount);
    			$('#InProduction').html(myObj.InProductionCount);
    		    $('#ProoReady').html(myObj.ProoReadyCount);
    			$('#Question').html(myObj.QuestionCount);
    			$('#Approved').html(myObj.ApprovedCount);
    			//console.log(query);
        });    
    }
    
//dashboard table content    
    function LoadTableContent(status, from_date, to_date){ //alert(status);
        var order_status = status;
        
        //console.log('from_date : '+from_date+' to_date : '+to_date);
        //load data table
        var dataTable = $('.kt_datatable_example_5').DataTable({
            "destroy": true, //reinitialise the table content
            "processing": true,
            "language": { 
               "loadingRecords": "&nbsp;",
               "processing": "<img src='<?php echo base_url()."assets/page_design/img/adwit-loading.gif"; ?>'>"
            },
            "serverSide": true,
            "order": [],  
            "ajax": {  
                url:"<?php echo base_url().index_page().'new_client/home/page_dashboard_content'; ?>",  
                type:"GET",
                data: {'status':order_status, 'from_date':from_date, 'to_date':to_date}
            },
            "columnDefs": [  
                {  
                     "targets":[0, 1, 2, 3],  
                     "orderable":false,  
                },  
            ],
            createdRow: function (row, data, index) { //add class for row-tr
                if (data[2] != "") { //page column is not empty consider it as sub order and add the below class for collapse css
                    //console.dir(row);
                    $(row).addClass('sub-table collapse row'+data[0]);
                }
            }
            
        });     
    }
    
    $('#team_orders').on('change', function(){
        var status = '0';
        if($(this).is(':checked')){
          status = '1'; //alert('checked');  
        }
       
        $.post('adrep_team_orders_status', {'team_orders_status':status}, function(result){
            if(result == '1'){
                $(this).prop('checked', true); // Checks it   
            }else{
                $(this).prop('checked', false); // UnChecks it 
            }
            
            //when there is change in team_orders status, ReLoad table content and ads count
            var status = $('input[name="status"]:checked').val();   //get status(radio button checked)
            var dval = $('#kt_daterangepicker_4').val();
            var array = dval.split(' - ');
            var from_date = array[0];
            var to_date = array[1];
            
            LoadTableContent(status, from_date, to_date); //load table content
            adsCount(from_date, to_date); //load/refresh ads count
        });
    });
</script>

<!-- Add new page modal window 
<script>
$(document).on("click", '.openBtn', function(event) {
    var page_design_id = $(this).data("page-design-id");
    var title = 'Add New Page For Page Design Id - '+page_design_id;
    var body =  '<form method="post" action="https://adwitads.com/weborders/index.php/new_client/home/page_add/'+page_design_id+'">';
     body +=                '<div class="col-md-6">';
	 body +=					'<div class="row" id="clickshow">';
	 body +=						'<div class="col-md-12">';
	 body +=							'<input type="text" name="addrow" placeholder="Enter New Page Name" class="form-control input-sm margin-top-10" title="" required="" autocomplete="off">';	 	
	 body +=						'</div>';
	 body +=					'</div>';
	 body +=				'</div>';
	 body +=				'<div class="modal-footer">';
     body +=        		    '<button type="submit"  name="add" class="btn btn-sm btn-blue margin-top-10" id="submit_form" >Submit</button> '; 
     body +=        		'</div>';    
     body +=            '</form>';
    // reference my modal 
    var modal1=$('#add-page-modal');
    // use `.html(content)` or `.text(content)` if you want to the html content 
    // or text content respectively.
    $(modal1).find('.modal-title').html(title);
    $(modal1).find('.modal-body').html(body);

    // show the modal 
    $(modal1).modal();
});
 
</script>
-->
<script>
//to over write js hidding the filter makin filter visible
(function(l,q){var d=function(b,c){b.extend(!0,c.defaults,{dom:"<'row'<'col-sm-6 hidden'l><'col-sm-6 hidden 'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",renderer:"bootstrap"});b.extend(c.ext.classes,{sWrapper:"dataTables_wrapper form-inline dt-bootstrap",sFilterInput:"form-control input-sm",sLengthSelect:"form-control input-sm"});c.ext.renderer.pageButton.bootstrap=function(g,d,r,s,i,m){var t=new c.Api(g),u=g.oClasses,j=g.oLanguage.oPaginate,e,f,n=0,p=function(c,d){var k,h,o,a,l=function(a){a.preventDefault();
b(a.currentTarget).hasClass("disabled")||t.page(a.data.action).draw("page")};k=0;for(h=d.length;k<h;k++)if(a=d[k],b.isArray(a))p(c,a);else{f=e="";switch(a){case "ellipsis":e="&hellip;";f="disabled";break;case "first":e=j.sFirst;f=a+(0<i?"":" disabled");break;case "previous":e=j.sPrevious;f=a+(0<i?"":" disabled");break;case "next":e=j.sNext;f=a+(i<m-1?"":" disabled");break;case "last":e=j.sLast;f=a+(i<m-1?"":" disabled");break;default:e=a+1,f=i===a?"active":""}e&&(o=b("<li>",{"class":u.sPageButton+
" "+f,id:0===r&&"string"===typeof a?g.sTableId+"_"+a:null}).append(b("<a>",{href:"#","aria-controls":g.sTableId,"data-dt-idx":n,tabindex:g.iTabIndex}).html(e)).appendTo(c),g.oApi._fnBindAction(o,{action:a},l),n++)}},h;try{h=b(d).find(q.activeElement).data("dt-idx")}catch(l){}p(b(d).empty().html('<ul class="pagination"/>').children("ul"),s);h&&b(d).find("[data-dt-idx="+h+"]").focus()};c.TableTools&&(b.extend(!0,c.TableTools.classes,{container:"DTTT btn-group",buttons:{normal:"btn btn-default",disabled:"disabled"},
collection:{container:"DTTT_dropdown dropdown-menu",buttons:{normal:"",disabled:"disabled"}},print:{info:"DTTT_print_info"},select:{row:"active"}}),b.extend(!0,c.TableTools.DEFAULTS.oTags,{collection:{container:"ul",button:"li",liner:"a"}}))};"function"===typeof define&&define.amd?define(["jquery","datatables"],d):"object"===typeof exports?d(require("jquery"),require("datatables")):jQuery&&d(jQuery,jQuery.fn.dataTable)})(window,document);

</script>
