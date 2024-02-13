<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('new_designer/head');?>
<style>
.dropzone {
    border: 2px dashed #ccc;
    background: white;
    padding: 10px 10px;
}
.dropzone, .dropzone * {
    box-sizing: border-box;
}
.dropzone {
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
</style>
<script>
     Dropzone.options.dropzonepdf = {
        maxFilesize: 250, //mb
    	init: function() {
    		this.on("sending", function(file) 
    		{ 
    			var fileName = file.name;
    		    var extension = fileName.substr( (fileName.lastIndexOf('.') +1) );
    		    if(extension != 'pdf'){
    		        alert("Only PDF Files Allowed..!!");
    				this.removeFile(file);  
    				//return false;
    		    }
    		 });
    		 //response from server
    		 this.on("success", function(responseText) {
                console.log(responseText); // console should show the ID you pointed to
                //if(responseText != 'success'){ alert(responseText); this.removeFile(file); }
            });
            
    		 this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response);
                //alert(response); 
                //return false;
            });
    	}
    };
</script>
<div id="main">
	<section>
		<div class="container margin-top-80">
			<div class="container margin-top-20">
				<div class="row">
				<div class="col-md-7">
					<p>
						<a href="#" class="text-blue">Order</a>
						<span class="padding-horizontal-5"><i class="fa fa fa-angle-double-right"></i></span>
						<a href="#">Id:<?php echo $page_design['id']; ?></a>
					</p>
				</div>
				
			</div>
		</div>
			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<span>PDF File Upload</span>
				<?php if(isset($page_design_pdf) && file_exists($page_design_pdf)){ ?>
					<span class="dropdown margin-left-5 text-grey pull-right">
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="pdf-view">
						    View uploaded files 
							<span class="caret margin-left-5"></span>
						</span>
						<div class="table-responsive dropdown-menu file_li">
							<table class="table table-striped table-hover" id="mytable-pdf">
								<tbody>
									<tr>
										<td>
										    <?php echo '<a href="'.base_url().$page_design_pdf.'" target="_blank">'.basename($page_design_pdf).'</a>'; ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</span>
				<?php } ?>
				    <form action="<?php echo base_url().index_page()."new_designer/home/page_design_upload/".$page_design['id']; ?>" id="dropzonepdf" name="file" class="dropzone dz-clickable"> 
				    	<div class="dz-default dz-message">
				    		<span>
				    			<strong>
				    				Drag files
				    			</strong> 
				    			or click to upload
				    		</span>
				    	</div>
				    </form>
				</div> 
				<div class=" col-md-12 margin-top-15 text-right">
					<form method="post" action="<?php echo base_url().index_page()."new_designer/home/pagination_orders/upload_pending"; ?>">
						<button type="submit" class="btn btn-danger margin-bottom-10 " name="end">End</button>
					</form>
				</div>
			</div> 
		</div>
	</section>
</div>
<?php $this->load->view('new_designer/foot');?>
<script>
	   function RefreshTablePrint() { 
		   $( "#mytable-pdf" ).load( "<?php echo base_url().index_page()."new_designer/home/page_design_upload/".$page_design['id'];?> #mytable-pdf" );
	   }
	    $("#pdf-view").on("click", RefreshTablePrint);
</script>
<!--<script>	

 	function  remove_zip(i) {
 		 var fname =$('#zip'+i).val();
 		 $.ajax({
 		 	url:"<?php echo base_url().index_page().'new_designer/home/page_remove_zip_file/'.$pass_id['id'];?>",
 		 	data:'filename='+fname,
 		 	type:"POST",
 		 });
	}
</script>-->