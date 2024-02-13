<?php $this->load->view('new_csr/head'); ?>
<script>
function goBack() {
 var x = confirm("Are You Sure to Go Back");
 if(x==true)
  {
 window.history.back();
  return true; } else {
  return false;
  }  
}
</script> 

<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
		<?php if(isset($hd)): ?>	
        <div class="row">
				<div class="col-md-12">
                <div class="portlet light">
					<!-- Begin: life time stats -->
					<!-- Adrep search -->
					<form method="post" class="alert alert-danger alert-borderless">
						<div class="input-group">
							<div class="input-cont">
								<input type="text"  name="adrep" id="adrep"  placeholder="Search..." class="form-control" required="required">
							</div>
							<span class="input-group-btn">
							<button type="submit"  name="Search"  class="btn green-haze">
								Search Adrep &nbsp; <i class="m-icon-swapright m-icon-white"></i>
							</button>
							</span>
						</div>
					</form>
					
					<!-- Pickup order search -->
					<form method="post" action="<?php echo base_url().index_page().'new_csr/home/pickup/'.$hd; ?>" class="alert alert-danger alert-borderless">
						<div class="input-group">
							<div class="input-cont">
								<input type="text"  name="order_id" id="order_id"  placeholder="Search..." class="form-control" required="required" autocomplete="off"/>
							</div>
							<span class="input-group-btn">
							<button type="submit"  name="order_Search"  class="btn green-haze">
								Search Pickup &nbsp; <i class="m-icon-swapright m-icon-white"></i>
							</button>
							</span>
						</div>
					</form>
					
<?php 	
	echo '<h3 style="color:#900;">'.$this->session->flashdata('message2').'</h3>'; 
	if(isset($hd) && isset($adrep_list)){ 
?>
     <div class="table-responsive">
		<table class="table table-striped table-bordered table-advance table-hover">
			<thead>
				<tr>
					<th> Fullname </th>
					<th> Username </th>
					<th> User Publication </th>
					<th> Action </th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($adrep_list as $row){ $pub_name = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();?>
				<tr>
					<td> <?php echo $row['first_name']; ?> <?php  echo $row['last_name']; ?> </td>
					<td><?php  echo $row['username']; ?> </td>
					<td> <?php  echo $pub_name[0]['name']; ?> </td>
					<td>
						<a class="btn default btn-xs blue-stripe" href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/new_cat/'.$hd.'/'.$row['publication_id'].'/'.$row['id'];?>'">
							Select 
						</a>
						<a class="btn default btn-xs blue-stripe" href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'new_csr/home/multiple_orders/'.$hd.'/'.$row['publication_id'].'/'.$row['id'];?>'">
							Multiple 
						</a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>
<!-- End: life time stats -->
</div>
</div>
<?php 
	if(isset($hd) && isset($publication) && isset($adrep) && isset($adrep_details) && isset($publication_details)){
		echo validation_errors();
		echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>';

		if($hd =='web'){ 								
			$this->load->view('new_csr/web_ad_form');	//web ad form new&pickup
		}else{ 											
			$this->load->view('new_csr/print_ad_form');	//print ad form new&pickup
		} 
	}
?>			
	</div>
<?php  endif;?>

</div>
		<!----------------------------------------------- for PICKUP ------------------------------------------------->

 						
<!-- END PAGE CONTENT -->

<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->

<!-- END BODY -->
	 <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<script type="text/javascript">
<?php if(!isset($hd)){?>
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'new_csr/home/new_cat/';?>" + $('#help_desk').val() ;
        });
    });
	
<?php }elseif(isset($hd) && !isset($publication)){ ?>	

	$(document).ready(function(e) {
        $('#publication').change(function(e) {
            window.location = "<?php echo base_url().index_page().'new_csr/home/new_cat/'.$hd.'/';?>" + $('#publication').val() ;
        });
    });
<?php }else{ ?>	
	$(document).ready(function(e) {
        $('#adrep').change(function(e) {
            window.location = "<?php echo base_url().index_page().'new_csr/home/new_cat/'.$hd.'/'.$publication.'/';?>" + $('#adrep').val() ;
        });
    });
<?php } ?>
</script>

<script>
function handleChange(input) {
    if (input.value <= 0) input.value = 0;
    if (input.value >= 100) input.value = 99;
  } 
</script>

<style>
#confirm input {
	background: #333; color: #FFF; border: 0;
}
</style>

</div>
	<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
</div>	
<?php $this->load->view('new_csr/foot'); ?>