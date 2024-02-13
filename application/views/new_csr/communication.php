<?php $this->load->view('new_csr/head'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new_csr/css/awe_menu.css">
<div class="page-container">
	<div class="page-content">
		<div class="container">
		    <div class="row">
		        <div class="col-md-4">
					<?php echo '<p style="color:#900;">'.$this->session->flashdata('message').'</p>'; ?>
				</div>
			</div>
			<div class="row">
		        <div class="col-md-4 col-sm-4">
		           	<div class="text-right">
					    <form id="search_form">
                            <input type="text" name="order_id" id="order_id" class="form-control" placeholder="Enter Adwitads Id" <?php if(isset($order_id)) echo'value="'.$order_id.'"'; ?> required>
                            <button type="submit" class="btn green btn-sm form-control" name="submit">SUBMIT</button>
                        </form>  
					</div>
				</div>
            </div>
            
            <div class=" margin-top-20">
                <div class="row border-top margin-0">
					<div role="tabpanel">
					    <!-- list div-->
                        <div class="col-md-4 padding-0 border-left zindex" id="communication_btn"></div>
                        
                        <!-- email fields -->
                        <div class="col-md-8 padding-0" id="email_details"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        $("#search_form").on("submit", function(){
            var order_id = $('#order_id').val(); 
            
            $.ajax({
                	url: "<?php echo base_url().index_page();?>new_csr/home/communication",
                	data:'order_id='+order_id+'&search=search',
                	type: "GET",
                	success: function(data) { 
                        $('#communication_btn').html(data);
                        }
                });

            return false;
        });
        
        $("#communication_btn").on("click", ".btn_list", function(event){   //click only works for elements already on the page.
            var order_id = $('#order_id').val(); 
            //var cid = $(this).val(); 
            var cid = $(this).data("cid") ;  //alert('hello... '+cid);
            $.ajax({
                	url: "<?php echo base_url().index_page();?>new_csr/home/communication",
                	data: 'order_id='+order_id+'&cid='+cid+'&details=details',
                	type: "GET",
                	success: function(data) { 
                            $('#email_details').html(data);
                        }
                });
        });
</script>
<?php $this->load->view('new_csr/foot'); ?>