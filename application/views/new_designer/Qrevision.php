<?php
       $this->load->view("new_designer/head"); 
?>
<!-- END HEADER -->

<script>
setTimeout(function(){
   window.location.reload(1);
}, 50000);
</script>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
           <div class="row">
              <div class="col-lg-12">
                <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									<?php if(isset($form)) $types = $this->db->get_where('help_desk',array('id'=>$form))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php if(isset($form)) echo $types[0]['name']; ?></a>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									
									<?php if(!isset($form_demo)) { ?>
									<ul class="nav navbar-nav navbar-right">
									<!--<li><a href="<?php echo base_url().index_page().'new_designer/home/revision'; ?>">REV/SOLD</a></li>-->
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Group &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
			<?php
			$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
				foreach($types as $type)
				{ ?>
												<li>
													<a href="<?php echo base_url().index_page().'new_designer/home/Qrevision/'.$type['id'];?>">
													<?php echo $type['name']; ?> </a>
												</li>
			<?php } ?>									
												
											</ul>
										</li>
									</ul>
								<?php } ?>			
								</div>
								
							
								
								<!-- /.navbar-collapse -->
		        </div>
	          </div>
           </div>
 <?php 
	echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';
 if(isset($form)):
 ?>
            <div class="row">
                <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<form name="form" method="post" >
								<span class="caption-subject font-green-sharp bold uppercase">Revision Ads</span>
									<input type="submit" name="pday" value="<?php echo $pystday; ?>" class="btn btn-xs green"/>
									<input type="submit" name="yday" value="<?php echo $ystday; ?>" class="btn btn-xs green"/>
									<input type="submit" name="today" value="<?php echo $today; ?>" class="btn btn-xs green"/>
								</form>
							</div>
							<div class="tools">
							<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
							
						</div>
						<div class="portlet-body">
				            <table class="table table-striped table-bordered table-hover" id="sample_6">
							  <thead>
							 <tr>
								<th>No</th>
								<th>Order Id</th>
								<th>Type</th>
								<th>Previous Slug</th>
								<!--<th>Version</th>-->
								<th>Designer</th>
							<!--	<th>Category</th>-->
								<th>Classification</th>
								<!--<th>Inst/Attch</th>-->
                             </tr>
							  </thead>
							  <tbody name="testTable" id="testTable">
<?php
$i=0;
foreach($orders_rev as $row){ $i--;
	$designer = $this->db->get_where('designers',array('id'=>$row['designer']))->result_array();
	//$order_detail = $this->db->query("SELECT `order_type_id` FROM `orders` WHERE orders.id = '".$row['order_id']."'")->row_array();
	if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
?>
             <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
                 
                <td><?php echo $i; ?></td>
                
				<td><?php echo $row['order_id']; ?></td>
				
				<td>
					<span class="badge bg-blue"><?php if($row['order_type_id']=='2') {echo "P";} elseif($row['order_type_id']=='1'){ echo "W";}elseif($row['order_type_id']=='6'){ echo "P&G";} else{ echo "P&W";}?></span>
				</td>
				
				<td>
    				 <?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $row['order_no']; ?>
				</td>
				
				<?php if($row['new_slug']=='none' && $designers[0]['designer_role'] != '2') { ?>
    				<td>
        				<?php if($row['category'] == 'sold'){ ?>
            				<a href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row['order_id'];?>">
            					<input type="button" value="Upload" />
            				</a>
        				<?php }else{ ?>
            				<form name="myform" method="post" onsubmit="return confirm('Do you really want to submit?');">
            					<button type="submit" name="create_slug" class="btn bg-green">Create Slug</button>
            					<input name="order_id" value="<?php echo $row['order_id'];?>" readonly style="display:none;" />
            				</form>
        				<?php } ?>
    				</td>
				<?php }else{ ?>
					<td>
        				<a <?php if($row['designer']!='0')?> href="<?php echo base_url().index_page().'new_designer/home/orderview/'.$form.'/'.$row['order_id'];?>">
        				    <?php if(isset($designer[0]['username'])) echo $designer[0]['username'] ; else echo ''; ?> 
        				</a>
    				</td>
    			<?php } ?>
			
				<td>
				    <?php if($row['classification']!='0'){ echo $rev_classification['name']; } ?>
				</td>
				
              </tr>
   <?php }?>
            </tbody>
							</table>
						</div>
					</div>
			    </div>
            </div>
		<?php  endif; ?>
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
<script>
     $(document).ready(function () {
         localStorage.removeItem('d_selected_display');
         localStorage.removeItem('d_selected_date');
     });
</script>