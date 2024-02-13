<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
											
<script>
	$(document).ready(function() {
	   function RefreshTable() {
		   $( "#mytable" ).load( "<?php echo base_url().index_page()."lite/home/view_uploaded_files/".$order_details;?> #mytable" );
	   }
	   $("#view").on("click", RefreshTable);
	});
	
	
</script>

<div id="main">


<section>
    <div class="container margin-top-30"> 
		<div class="row margin-0">	 
			
			<div class="col-md-12 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right small">
				<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view">View Uploaded Files
					<span class="caret margin-left-5"></span></span>
												
					<div class="table-responsive dropdown-menu file_li ">  							 
							<table class="table table-striped table-hover" id="mytable">
							 <tbody>
							 <?php if(isset($file_names)) { $i=1;  foreach($file_names as $row)  { ?>
								 <tr>
									<td><?php echo $i ?></td>
									<td><a href="<?php echo base_url().'downloads/'.$order_details[0]['id'].'-'.$order_details[0]['job_no'].'/'.$row;?>" target="_blank"><?php echo $row; 	$i++; ?></a></td>
									<td><a href="<?php echo base_url().'download.php?file_source='.$order_details[0]['file_path'].'/'.$row; ?>" target="_blank"><i class="fa fa-download"></i></a></td>
								</tr>
							<?php  } }?> 
							</tbody>
						 </table>
					</div>
				
			</div>  
		</div>
	</div>
</section>


<section id="question">
    <div class="container"> 
		<div class="row  margin-top-15">
			
	<?php if(isset($rev_sold_jobs)){ ?>
			<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
				  <div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="order_id" name="order_id" value="<?php echo $rev_sold_jobs[0]['order_id']; ?>" hidden />
		
					   <p class="margin-bottom-5">Question</p>
					   <p class="text-grey"><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>			   
				  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Answer</p>
					   <textarea rows="3"  name="answer" id="answer" class="form-control margin-bottom-15"  required=""></textarea>
					   
					   <p class="margin-bottom-5">Attach File</p>
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control">
					   </div> 
			
					<div class="col-md-12 col-sm-6 col-xs-12">
						<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />
						<button type="submit" class="btn btn-blue btn-sm pull-right margin-top-15" name="submit">Submit</button>
					</div>
			</form>

	<?php }else{ ?>	
			<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Question</p>
					   <p class="text-grey"><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>			   
				  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Answer</p>
					   <textarea rows="3"  name="answer" id="answer" class="form-control margin-bottom-15"  required=""></textarea>
					   
					   <p class="margin-bottom-5">Attach File</p>
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control">
					    </div> 
			
					<div class="col-md-12 col-sm-6 col-xs-12">
						<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />
						<button type="submit" class="btn btn-blue btn-sm pull-right margin-top-15" name="submit">Submit</button>
					</div>
			</form>
	<?php } ?>			
		</div> 
	</div>
</section>

</div>
<?php $this->load->view("lite/footer.php"); ?>
 <?php $this->load->view("lite/foot.php"); ?>	