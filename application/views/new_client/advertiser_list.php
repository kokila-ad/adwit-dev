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
        <div class="container margin-top-20">
            <div class="row padding-15">
             	<h2 class="col-md-11">Advertiser List</h2>
             	<button type="button" class="col-md-1 btn btn-sm btn-dark btn-outline" data-toggle="modal" data-target="#add_advertiser_modal">
                  Add New
                </button>
        		<!--<a class="col-md-1 btn btn-sm btn-dark btn-outline" href="<?php echo base_url().index_page().'new_client/home/advertiser_add'; ?>">Add New</a>-->
            </div>

		<div class="row">	
		<?php echo $this->session->flashdata('message'); ?>
			  <div class="col-md-12 margin-top-20">
				 <div class="table-responsive border padding-15">     
						<table class="table table-striped table-bordered table-hover" id="user_data">
						<thead>
    						<tr>
    							<th class="center">Advertiser Name</th>
    							<th class="center">Email</th>
    							<th class="center">Category</th>
    							<th class="center">Phone number</th>
    							<th class="center">Action</th>
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
	

<!-- Modal starts here-->
<style>
    .modal-backdrop {
    display:none;
    }

</style>

<div class="modal" id="add_advertiser_modal" tabindex="-1"  data-backdrop="static" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width:700px;">
    <div class="modal-content" style="width:85%">
      <div class="modal-header" style="border-bottom: 0 !important; background-color:#333 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="dashboardModal" style="color: white;"> <center><b>Add New Advertiser</b></center></h5>
      </div>
      <div class="modal-body" style="padding: 15px 16px;">
        <form class="border padding-15" method="post" id="add_advertiser_form">
          <div class="row" id="add_form_div">
             <div class="col-md-12" id="error_div"></div>
            <div class="col-md-6">
              <p class="margin-bottom-5">Name <span class="text-red">*</span></p>
              <input type="text" name="advertiser_name" id="advertiser_name" class="form-control input-sm margin-bottom-15" required="" id="autocomplete-input" autocomplete="off">
            </div>
            
            <div class="col-md-6">
              <p class="margin-bottom-5">Email <span class="text-red">*</span><small class="text-grey"> (add advertiser communication email id)</small></p>
              <input type="email" name="emailId" id="emailId" class="form-control input-sm margin-bottom-15" required="" id="autocomplete-input" autocomplete="off">
            </div>
            <div class="col-md-6">
              <p class="margin-bottom-5">Phone number <span class="text-red">*</span></p>
              <input type="number" name="phoneNumber" id="phoneNumber" class="form-control input-sm margin-bottom-15" required="" id="autocomplete-input" autocomplete="off">
            </div>
            <div class="col-md-6">
              <p class="margin-bottom-5">Category <span class="text-red">*</span></p>
              <select name="category" id="category" class="form-control input-sm margin-bottom-15">
                <option value=''>Select</option>
                <?php 
                  $category = $this->db->query("SELECT * FROM `advertiser_category`")->result_array();
                  foreach($category as $row){  ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['category']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12 text-center"> 
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" >Close</button>
              </div>
              <div class="col-md-2">
                <!--<button type="submit" name="new" id="os_submit" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>-->
                <button type="button"  id="os_submit" onclick="add_advertiser()" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>
               </div>
            </div>
          </div>
          <div id="msg_form_div" style="display:none;"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal ends here-->
<!--Edit Modal -->
<div class="modal" id="edit_advertiser_modal" tabindex="-1"  role="dialog" aria-labelledby="confirmationModalTitle"></div>


<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>

<script>
$(document).ready(function(){ 
    $('#AddAdvertiser').modal('hide');
    //load table data
      var dataTable = $('#user_data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_client/home/advertiser_list_fetch'; ?>",  
                type:"POST"  
           },
            "ordering": true,
           "columnDefs":[  
                {  
                     "targets":[3],  
                     "orderable":false,  
                },  
           ],  
      }); 
    /*  
    setInterval( function () {
        dataTable.ajax.reload();
    }, 120000 );
    */
    


$(document).on("click", "#advertiserDelete", function(e){
    var advertiserId = $(this).data("id"); 
   if(confirm("Are you sure you want to delete this?")){  
       $.post('advertiser_delete', {'advertiserId':advertiserId}, function(result){
            alert(result); 
            dataTable.ajax.reload();
       });
   }
});

});


function add_advertiser(){
      var advertiser_name = $("#advertiser_name").val();
      var emailId = $("#emailId").val();
      var phoneNumber = $("#phoneNumber").val();
      var category = $("#category").val();
      if(advertiser_name == ""){
           $("#error_div").html('<font color="#cc0000">Advertiser name is required</font>');
      }else if(emailId == ""){
          $("#error_div").html('<font color="#cc0000">Email id is required</font>');
      }else if (IsEmail(emailId) == false) {
          $("#error_div").html('<font color="#cc0000">Valid Email id is required</font>');
      }else if(phoneNumber == ""){
          $("#error_div").html('<font color="#cc0000">Phonenumber is required</font>');
      }else if(category == ""){
          $("#error_div").html('<font color="#cc0000">Please Select Category</font>');
      }else{
          var dataString = "advertiser_name="+advertiser_name+"&emailId="+emailId+"&phoneNumber="+phoneNumber+"&category="+category+"&new="+"new";
          $.ajax({
			type : "POST",
			url  : '<?php echo base_url().index_page().'new_client/home/advertiser_add'; ?>',		          	
			data :dataString,
		
			success: function(responseJsonStr){
				
				 var myObj = JSON.parse(responseJsonStr);
				 var responseStatus = myObj["response_status"];
				 var message = myObj["message"];
				 
				// alert(responseStatus);
				   if(responseStatus == "success"){
				       $("#add_form_div").css("display","none");
				       $("#msg_form_div").css("display","block");
				      $("#msg_form_div").html('<span style="color: #12b01a;">' + message + '</span>');
				      setTimeout(function () {
                        $("#add_advertiser_modal").modal('hide');
					    location.reload();
				      }, 1000);				  
				   }
				   else{
				       $("#add_form_div").css("display","none");
				       $("#msg_form_div").css("display","block");
					  $("#msg_form_div").html('<span style="color: #cc0000;">' + message + '</span>');
					   setTimeout(function () {
					     $("#add_advertiser_modal").modal('hide');
					    location.reload();
					   }, 1000);
                       
				   }
				   
			}
	  });
      }
      
    }
    function editAdvertiser(advertiser_id){
        var dataString = "advertiser_id="+advertiser_id;
		$.ajax({
			method: "POST",
			url: '<?php echo base_url().index_page().'new_client/home/edit_advertiser'; ?>',
			data: dataString,
			cache: false,
			error: function(data){
				alert("error");
				console.log(data);
			},
			success: function(data){
			$("#edit_advertiser_modal").html(data);
			$("#edit_advertiser_modal").modal({backdrop: 'static', keyboard: false});
			
		}
    			
		});
    }
    
      function IsEmail() {
          var email = $("#emailId").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                return false;
            }
            else {
                return true;
            }
        }
    
</script>
