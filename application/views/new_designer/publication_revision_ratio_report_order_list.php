<?php $this->load->view('new_designer/head')?>

<style>
    @media (max-width: 767px)
    {
        .list-separated {
            position: relative;
            left: 36px;
        }
    }
    
</style>

<!-- BEGIN PAGE CONTAINER -->

	<div class="page-content">
		<div class="container">
		    <div class="portlet light">
		        <div class="portlet-title">
            		<div class="caption">
            			<label><?php if(isset($order_list[0]['name'])) echo $order_list[0]['name']; ?> 
            			Revision Ratio Report : <?php echo $version.' : '; if(isset($from) && isset($to)){ $from1 = strtotime($from); $to1 = strtotime($to); echo "<b>".date('M d, Y', $from1)."</b> to <b>".date('M d, Y', $to1)."</b>" ;} ?></label>
            		</div>
            		<div class="margin-top-10 margin-bottom-10 text-right">
            			<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
            			<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
            		</div>
            	</div>
            	
        		<div class="portlet-body">
        			    
					<table class="table table-striped table-bordered" id="sample_6">
						<thead>
							<tr>
								<th>Order Id</th>
								<th>Job Name</th>
						   </tr>  									
						</thead>
						<tbody>
						    <?php 
						      foreach($order_list as $row){
						    ?>
						    <tr>
						        <td>
						            <a href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['order_id']; ?>">
						                <?php echo $row['order_id']; ?>
						            </a>
						        </td>
						        <td><?php echo $row['job_no']; ?></td>
						    </tr>
						     
						    <?php } ?>
						</tbody>     
					</table>
				 
			 
	  	        </div>
	  	    </div>  
	    </div>
    </div>
<?php $this->load->view('new_designer/foot')?>