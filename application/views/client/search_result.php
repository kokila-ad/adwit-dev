<?php

	$this->load->view("client/header1");

	
?>

<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>



  <div id="Middle-Div">
  <p>&nbsp;</p>
  <p>&nbsp;</p>

	<p style="font-size: 24px; text-align: center; color: #C50003;">No Orders Found</p>
      <p>&nbsp;</p>
    <div style="text-align:center;"><a href="<?php echo base_url().index_page().'client/home/order_form/print/new-ads/';?>"><button class="btn btn-success">Submit a New Order</button></a>
    <a href="<?php echo base_url().index_page().'client/home/myorders_v2/';?>"><button class="btn btn-warning"> Back to Dashboard </button></a></div>
    <p>&nbsp;</p>



  </div>

		

<?php

	$this->load->view("client/footer");

?>