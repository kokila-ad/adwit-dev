<?php $this->load->view("new_csr/head.php"); ?>
<style>
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
</style>
<script>
setTimeout(function(){
   window.location.reload(1);
}, 50000);
</script>

<script>
   function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php 
				$current_time = date("H:i:s"); 
		?>
    }
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/';?>" + $('#help_desk').val() ;
        });
    });
</script>

<script type="text/javascript">
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'new_csr/home/frontlinetrack_';?>" + $('#display_type').val() + "<?php echo '/'.$form; ?>" ;
        });
    });
</script>

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
									<?php  $type = $this->db->get_where('help_desk',array('active'=>'1','id'=>$form))->result_array(); ?>
									<a class="navbar-brand" href="javascript:;">
									<?php echo $type[0]['name']; ?> </a>
									<a class="navbar-brand" href="javascript:;"><?php echo $this->session->flashdata('sold_status');?></a>
									
									
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<ul class="nav navbar-nav navbar-right">
									
									<?php if($form=='12'){ ?>
										<li>
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_rev_entries';?>'" href="javascript:;">
											Vidn Entries </a>
										</li>
									<?php } ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/sold_track/'.$form;?>" target="_blank" href="javascript:;">				
										Sold Orders</a>								
									</li>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/revision/'.$form;?>" target="_blank" href="javascript:;">				
										Incoming</a>								
									</li>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/'.$form;?>" href="javascript:;">All</a>						
									</li>
									<?php if(isset($rev_classification) && $form == '10'){ foreach($rev_classification as $classification){ ?>
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/'.$form.'/'.$display_type.'/'.$classification['id'];?>" href="javascript:;">				
										<?php echo $classification['name']; ?></a>								
									</li>
									<?php } } ?>
								<!--		<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Desk &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											<?php 
											$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
											foreach($types as $type)
				{ ?>
				                                
												<li>
													<a href="<?php echo base_url().index_page().'new_csr/home/frontlinetrack_all/';?><?php echo $type['id']; ?>">
													<?php echo $type['name']; ?> </a>
												</li>
												<?php } ?>
											</ul>
										</li>-->
										
									</ul>
								</div>
								<!-- /.navbar-collapse -->
							</div>
        </div>
        </div>
		
        <div class="row">
        <div class="col-md-12">
		<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption margin-right-10">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase"><?php echo $display_type; ?></span>
							</div> 
							<div class="caption">
								<form method="post">
								<input type="submit" name="date" class="btn btn-xs green" value="<?php echo $qystday; ?>" /> 
								<input type="submit" name="date" class="btn btn-xs green" value="<?php echo $pystday; ?>" /> 
								<input type="submit" name="date" class="btn btn-xs green" value="<?php echo $ystday; ?>" /> 
								<input type="submit" name="date" class="btn btn-xs green" value="<?php echo $today; ?>" /> 
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
											<th>No.</th>
											<th>Job No.</th>  
											<th>Sold</th>
											<th>PDF</th>
											<th>End</th>											
										</tr>
										</thead> 
											
										<tbody name="testTable" id="testTable">	
										
<?php
$count = '0' ;
 if($display_type=='all')
	{ 
		if(isset($date)){
			$this->db->order_by("id", "asc");
				$jobs = $this->db->get_where('sold_orders',array('order_id !=' => '', 'date'=> $date, 'help_desk' => $form))->result_array();
			}else{
				$jobs = $this->db->get_where('sold_orders',array('order_id !=' => '', 'date'=> $today, 'help_desk' => $form))->result_array();
			} 
	}
		foreach($jobs as $row){
		$count--;
		/* $cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no` = '".$row['order_id']."'")->result_array();
		$rev_sold_jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `id` = '".$row['rev_id']."'")->result_array();
		if($row['rev_id'] != '0'){
			$pdf_path = $rev_sold_jobs[0]['sold_pdf'];
		}else{
			$pdf_path = $cat_result[0]['sold_pdf'];
		} */
	?> 
										 <tr>
											<td><?php echo $count;?></td>
											<td><?php echo $row['job_no']; ?></td>
											<td><?php echo $row['timestamp']; ?></td>
											<td>
											<?php if(file_exists($row['sold_pdf'])){ ?>
													<a href="<?php echo base_url()?><?php echo $row['sold_pdf'] ;?>" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="<?php echo base_url()?>images/pdf.png" alt="pdf"/></a>
													<?php  }else{ echo' '; }  ?> 
											</td>
											<td><?php if($row['end_timestamp'] != '00:00:00') { 
											echo $row['end_timestamp']; }else{?>
											<form method="post">
												<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
												<button type="submit" name="end" class="btn btn-sm btn-primary">Send</button>
											</form>
											<?php } ?>
											</td>												
										</tr>
		<?php } ?>
										</tbody>
									</table>
                                </div>
                            </div>
                        </div>
                        </div>
						
  </div>
  </div>
  </div>
 <?php $this->load->view("new_csr/foot.php"); ?> 
 
