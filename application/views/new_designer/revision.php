<?php
       $this->load->view("new_designer/head"); 
?>
<!-- END HEADER -->

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
        
		
        <div class="row">
        <div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Revision</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
						<div class="form-group">
						<form name="form" action="<?php echo base_url().index_page().'new_designer/home/revision';?>" method="post">
						  <h4>Slug</h4>
						  <input type="text" name="id" id="id" class="form-control input-medium" placeholder="copy & paste slug" required/>
						  <br>
						  <p>Chekker(checked by)</p>
						  <select class="form-control input-medium" id="csr" name="csr" required >
          <option value="">Select</option>
          <?php
					foreach($csr as $result)
					{
						echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>';	
					}
				?>
                         </select>
						   <br>
						   <button type="submit" name="search" class="btn blue">Submit</button>
					<div id="slug-error">
	 <?php if(isset($r_status)) echo "<p>".  $r_status ."</p>";	?>
                   </div>
						   </form>
						</div>
						 </div>
					</div>
				</div>
	<!-- END PAGE CONTENT -->

        <div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Sold</span>
							</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
						<div class="form-group">
						<form name="form" action="<?php echo base_url().index_page().'new_designer/home/sold';?>" method="post">
						  <h4>Slug</h4>
						  <input type="text" name="id" id="id" class="form-control input-medium" placeholder="copy & paste slug" required/>
						  <br>
						  
						   <button type="submit" name="search" class="btn red-intense">Submit</button>
						   <div id="slug-error">
	 <?php if(isset($s_status)) echo "<p>".  $s_status ."</p>";	?>
                            </div>
						 </form>
						</div>
						 </div>
					</div>
		</div>
        </div>
        </div>
</div>
</div>
	<!-- END PAGE CONTENT -->
</div>

<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->
<?php
       $this->load->view("new_designer/foot"); 
?>