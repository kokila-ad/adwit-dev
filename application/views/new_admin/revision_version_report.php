<?php $this->load->view('new_admin/header')?>
<?php $this->load->view('new_admin/amchart')?>

<script>
	 $(document).ready(function(){
	  $('#submit_form').hide();
	  
	  $("#form").click(function(){$("#submit_form").show(); }); 
	 });
 </script>
 

			
<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-7 col-xs-12 margin-top-5">
				<a href="#" class="font-lg font-grey-gallery">Revision Classification Report</a> 
			</div>
			
			<div class="col-md-4 col-xs-8 margin-bottom-10 text-right">
			<?php if(null != $this->session->flashdata('message')){ ?>						
				<div class="alert alert-success margin-0 padding-5 small"><?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?></div>
			<?php } ?>
			</div>
		
		</div>
	</div>
	<div class="portlet-body">
	    <div class="row margin-bottom-20">
	        <form method="get">
				<label class="col-lg-1 no-space control-label margin-top-5 " style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Date Range</label>
				<div class="col-md-4">
					<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" id="from_date" name="from_date" placeholder="YYYY-MM-DD" class="form-control" <?php if(isset($_GET['from_date'])) echo 'value = "'.$_GET['from_date'].'"'; ?> autocomplete="off">
						<span class="input-group-addon">to </span>
						<input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" class="form-control" <?php if(isset($_GET['to_date'])) echo 'value = "'.$_GET['to_date'].'"'; ?> autocomplete="off">
					</div>
				</div>	
				<div class="col-md-1">
					<input type="submit" class="btn bg-green-haze" value="Submit">
				</div>
			</form>
		</div>
	<?php if(isset($from)){ ?>	
		<div class="row">
			<div class="col-md-6 col-sm-12 margin-bottom-20">
				<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Revision Classification Count<span class="badge"></span></a> </p>
				                					
										
									
				<table class="table table-bordered table-hover" >
					<thead>
						<tr>
						    <td>Classification</td>
						    <td>Count</td>
						 </tr>
					</thead>
					<tbody>
    					<tr>
    					    <td>5 Mins</td>  
    					    <td class="orderDetails" data-id="1"><?php echo $five_mins; ?></td>
    					</tr>
    					<tr>
    					    <td>Text/Copy Change</td>  
    					    <td class="orderDetails" data-id="2"><?php echo $text_copy; ?></td>
    					</tr>
    					<tr>
    					    <td>Design Challenge</td>  
    					    <td class="orderDetails" data-id="3"><?php echo $design_challenge; ?></td>
    					</tr>
    					<tr>
    					    <td>Extensive</td>  
    					    <td class="orderDetails" data-id="4"><?php echo $extensive; ?></td>
    					</tr>
    					<!--<tr>
    					    <td>Client Dislike</td>  
    					    <td class="orderDetails" data-id="client_dislike"><?php echo $client_dislike; ?></td>
    					</tr>-->
					</tbody>
				</table>						
			</div>
		<?php //if(isset($order_details)){ ?>	
			<div class="col-md-6 col-sm-12">
				<div class="row">
				 	<div class="col-md-12">
						<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Order Details
						</p>										
					</div>
					<div class="col-md-12 col-sm-12" id="records_table">
					        	
					</div>
			    </div>
		  </div>
	    <?php //} ?>	  
	  </div>
	<?php } ?>  
	</div>
</div>
<script>
        $(".orderDetails").click(function(){
            var id = $(this).data('id');
            var to_date =  $('#to_date').val();
            var from_date =  $('#from_date').val();
            //alert('ID ; '+id);
            
            $.ajax({
                url: "<?php echo base_url().index_page().'new_admin/home/revision_version_report_details'; ?>",
                type: "POST",
                data: 'type= details&id='+id+'&from_date='+from_date+'&to_date='+to_date ,
                success: function(respone){
                            $('#records_table').html(respone);
                }
            });
            
        });
        </script>
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
