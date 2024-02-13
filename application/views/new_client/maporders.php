<?php $this->load->view('new_client/header');?>

<style>
    .btn.btn-xs, .btn-xs.search-submit {
        font-size: 13px !important;
        padding: 6px 10px !important;
    }
</style>

<div id="main">
	<div class="portlet-title">
		<div class="caption"><?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?> </div>
	</div>
    <section>
        <div class="container margin-top-50"> 
    		<form method="post" action="<?php echo base_url().index_page().'new_client/home/order_search';?>"> 
    			<div class="row">  		 
    				<div class="col-md-7">
    					<p>
    					    <a class="btn btn-xs btn-dark btn-outline margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/dashboard';?>">
            								    Dashboard</a>
            		        <a class="btn btn-xs btn-dark margin-right-10"  href="<?php echo base_url().index_page().'new_client/home/maporders'; ?>">
            								    MAP Orders-<?php if(isset($maporders)) echo count($maporders); ?></a>
    					</p>
    				</div>
    			</div>	 
    		</form> 
    	</div>
    </section>

    <section>
        <div class="container"> 
    		<div class="row">		
    			  <div class="col-md-12 margin-top-20">
    				 <div class="table-responsive border padding-15">     
    					<table class="table table-striped table-bordered table-hover" id="example1">
    						<thead>
    							<tr>
    								<th>Date</th>
    								<th>Order Type</th>
    								<th>Job Name</th>
    								<th>Action</th>
    						   </tr>  									
    						</thead>
    						<tbody>	
    						 <?php foreach($maporders as $row){ ?>	
    							<tr>
    										<td><?php echo $row['timestamp']; ?></td>
    										<td><?php echo $row['name']; ?></td>
    										<td><?php echo $row['job_name']; ?></td>
    										<?php if($row['approve']!='0'){ echo '<td> uploaded </td>'; }else{ ?>	
    										<td>
    											<a href="<?php echo base_url().index_page()."new_client/home/maporderform/".$row['id']; ?>" class="btn btn-primary btn-xs">Submit</a>
    										</td>
    									<?php } ?>	
    							</tr>
    							 <?php } ?>	
    					   </tbody>         
    					</table>
    				 </div>
    			 </div>
    	  	  </div>
            </div>
    	</div>
	</section>


<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>
