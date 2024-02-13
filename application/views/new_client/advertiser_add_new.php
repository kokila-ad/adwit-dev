<div class="modal-dialog modal-dialog-centered" role="document" style="width:700px;">
    <div class="modal-content" style="width:85%">
      <div class="modal-header" style="border-bottom: 0 !important;background-color:#333 !important;">
        <h5 class="modal-title portlet-title margin-top-10" id="dashboardModal" style="color: white;"><center><b>Edit  Advertiser</b></center></h5>
      </div>
      <div class="modal-body" style="padding: 15px 16px;">
        <form class="border padding-15" method="post" id="edit_advertiser_modal">
          <div class="row" id="edit_form_div">
             <div class="col-md-12" id="e_error_div"></div>
            <div class="col-md-6">
              <p class="margin-bottom-5">Name <span class="text-red">*</span></p>
              <input type="text" name="advertiser_name" id="e_advertiser_name" <?php if(isset($advertiser)) echo 'value="'.$advertiser['fullname'].'"'; ?> class="form-control input-sm margin-bottom-15" required="" id="autocomplete-input" autocomplete="off">
            </div>
            
            <div class="col-md-6">
              <p class="margin-bottom-5">Email <span class="text-red">*</span><small class="text-grey"> (add advertiser communication email id)</small></p>
              <input type="email" name="emailId" id="e_emailId" <?php if(isset($advertiser)) echo 'value="'.$advertiser['email'].'"'; ?> class="form-control input-sm margin-bottom-15" required="" id="autocomplete-input" autocomplete="off">
            </div>
            <div class="col-md-6">
              <p class="margin-bottom-5">Phone number <span class="text-red">*</span></p>
              <input type="number" name="phoneNumber" id="e_phoneNumber" <?php if(isset($advertiser)) echo 'value="'.$advertiser['phone_number'].'"'; ?> class="form-control input-sm margin-bottom-15" required="" id="autocomplete-input" autocomplete="off">
            </div>
            <div class="col-md-6">
              <p class="margin-bottom-5">Category <span class="text-red">*</span></p>
               <select name="category" id="e_category" class="form-control input-sm margin-bottom-15">
                <option value=''>Select</option>
                <?php 
                    $category = $this->db->query("SELECT * FROM `advertiser_category`")->result_array();
                    foreach($category as $row){
                ?>
                        <option value="<?php echo $row['id']; ?>" <?php if(isset($advertiser) && $advertiser['category'] == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['category']; ?>
                        </option>
                <?php } ?>
                 </select>
            </div>
            <input hidden id="e_advertiser_id" name="e_advertiser_id'" readonly value="<?php echo $advertiser['advertiser_id'];?>">
            <div class="col-md-12 text-center">
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" >Close</button>
              </div>
              <div class="col-md-2">
                <!--<button type="submit" name="new" id="os_submit" class="btn btn-blue btn-sm margin-bottom-5">Submit</button>-->
                <button type="button"  id="os_submit" onclick="update_advertiser()" class="btn btn-blue btn-sm margin-bottom-5">Update</button>
               </div>
            </div>
          </div>
          <div id="e_msg_form_div" style="display:none;"></div>
        </form>
      </div>
    </div>
  </div>
  
  <script>
      function update_advertiser(){
      var advertiser_name = $("#e_advertiser_name").val();
      var emailId = $("#e_emailId").val();
      var phoneNumber = $("#e_phoneNumber").val();
      var category = $("#e_category").val();
      var advertiser_id = $("#e_advertiser_id").val();
      if(advertiser_name == ""){
           $("#e_error_div").html('<font color="#cc0000">Advertiser name is required</font>');
      }else if(emailId == ""){
          $("#e_error_div").html('<font color="#cc0000">Email id is required</font>');
      }else if (IsEmail(emailId) == false) {
          $("#e_error_div").html('<font color="#cc0000">Valid Email id is required</font>');
      }else if(phoneNumber == ""){
          $("#e_error_div").html('<font color="#cc0000">Phonenumber is required</font>');
      }else if(category == ""){
          $("#e_error_div").html('<font color="#cc0000">Please Select Category</font>');
      }else{
          var dataString = "advertiser_name="+advertiser_name+"&emailId="+emailId+"&phoneNumber="+phoneNumber+"&category="+category+"&edit="+"edit"+"&advertiser_id="+advertiser_id;
          $.ajax({
			type : "POST",
			url  : '<?php echo base_url().index_page().'new_client/home/advertiser_add'; ?>',		          	
			data :dataString,
			success: function(responseJsonStr){
				 var myObj = JSON.parse(responseJsonStr);
				 var responseStatus = myObj["response_status"];
				 var message = myObj["message"];
				   if(responseStatus == "success"){
				       $("#edit_form_div").css("display","none");
				       $("#e_msg_form_div").css("display","block");
				      $("#e_msg_form_div").html('<span style="color: #12b01a;">' + message + '</span>');
				       setTimeout(function () {
                        $("#edit_advertiser_modal").modal('hide');
					    location.reload();
                        }, 1000);
                            					  
				   }
				   else{
				       $("#edit_form_div").css("display","none");
				       $("#e_msg_form_div").css("display","block");
					  $("#e_msg_form_div").html('<span style="color: #cc0000;">' + message + '</span>');
					  setTimeout(function () {
					     $("#edit_advertiser_modal").modal('hide');
					    location.reload();
                        }, 1000);
				   }
				   
			}
	  });
      }
    }
    
    function IsEmail() {
          var email = $("#e_emailId").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                return false;
            }
            else {
                return true;
            }
        }
    
  </script>
