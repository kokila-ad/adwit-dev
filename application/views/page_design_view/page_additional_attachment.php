<?php $this->load->view('new_client/header'); ?>

<div id="main">
<section>
    <div class="container margin-top-30"> 
		<div class="row margin-0">	 
			<div class="col-md-2 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span class="margin-right-15">AdwitAds ID: <span class="text-dark"><?php echo $order_detail['id'];?></span></span>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span>Publication/Edition Name: <span class="text-dark"><?php echo $order_detail['advertiser_name'];?></span></span>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span>Page Name / Number: <span class="text-dark"><?php echo $order_detail['job_no'];?></span></span>
			</div>
			
			<div class="col-md-2 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right small">
				<span class="margin-right-5 text-grey">
					<a href="javascript:history.back()"><i class="fa fa-mail-reply padding-right-5 text-grey"></i></a>
				</span>
			</div>
		</div>
		<hr>
	</div>
</section>
		<!--<div class="container margin-top-5"> <?php echo $this->session->flashdata('message');?> -->
		
<section id="additional_attachments">
    <div class="container"> 
	<div class="row margin-top-10">
		
		<form  method="post" >
		    <div class="row">
        		<div class="col-md-6 col-sm-4 col-xs-12">
				<div class="form-group">
					<span>Articles / Images</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="article-view" >
							View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">
							<table class="table table-striped table-hover" >
								<tbody id="mytable-article">
									
								</tbody>
							</table>
						</div>
					</span>
					<div id="attachments">
						<span><?php //echo $a ;?></span>
						<div action="<?php echo base_url().index_page()."new_client/home/page_artical_upload/".$order_detail['id'];?>" class="dropzone"> </div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-4 col-xs-12">
				<div class="form-group">
					<span>Ads</span>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="ads-view">
							View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">  							 
							<table class="table table-striped table-hover" >
								<tbody id="mytable-ads">
									
								</tbody>
							</table>
						</div>
					</span>
					<div id="attachments">
						<span><?php //echo $a ;?></span>
						<div action="<?php echo base_url().index_page()."new_client/home/page_ads_upload/".$order_detail['id'];?>" class="dropzone"> </div>
					</div>
				</div>
			</div>
    		</div>
    		
		    <button type="submit" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="additional_attachment_submit" id="hide">Submit</button>
		</form>
		
	</div> 
	</div>
</section>
</div>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); }  ?>
<!-- Listout files -->
<script>
        var order_id = '<?php echo $order_detail['id']; ?>';
	   $("#article-view").on("click", function(){ 
	       $.post('<?php echo base_url().index_page().'new_client/home/page_list_attachments'; ?>', {'order_id':order_id, 'type':'articles'}, function(result){
	            var response = JSON.parse(result);
	            $('#mytable-article').html(response);    
	       });
	   });
	   //$("#ads-view").on("click",RefreshTablePrint);
	   $("#ads-view").on("click", function(){ 
	       $.post('<?php echo base_url().index_page().'new_client/home/page_list_attachments'; ?>', {'order_id':order_id, 'type':'ads'}, function(result){
	            var response = JSON.parse(result);
	            $('#mytable-ads').html(response);    
	       });
	   });
	   
	   function remove_attachment(filename) { 
            var fname = filename;
            //alert('fname : '+fname);
     		 $.ajax({
     		 	url:"<?php echo base_url().index_page().'new_client/home/page_remove_attachment_file/'.$order_detail['id'];?>",
     		 	data:'filename='+fname,
     		 	type:"POST",
     		 });
	    }
</script>