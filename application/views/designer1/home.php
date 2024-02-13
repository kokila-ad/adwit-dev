<?php
	$this->load->view("designer/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="theme001/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<div id="Middle-Div">
<?php
	$designer_name=$this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array()
	?>

    <?php 
	$notification = $this->db->get_where('notification',array('users'=>'5', 'job_status'=>'1'))->result_array();
	if($notification)
	{
		foreach($notification as $row)
		{
	?>
    <div class="alert alert-info alert-block" style="width: 80%; margin: 0 auto;">
										
										<h4 class="alert-heading"><?php echo $row['headline'] ; ?></h4>
										<?php echo $row['message'] ; ?>
									</div>
    <?php } }?>

    <div id="Middle-text">Welcome <?php echo $designer_name[0]['name'];?></div>
    
    	<p>&nbsp;</p>
    <?php 
	$notification = $this->db->get_where('notification',array('users'=>'1', 'job_status'=>'1'))->result_array();
	if($notification)
	{
		foreach($notification as $row)
		{
	?>
    <div class="alert alert-info alert-block" style="width: 80%; margin: 0 auto;">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4 class="alert-heading"><?php echo $row['headline'] ; ?></h4>
										<?php echo $row['message'] ; ?>
									</div>
    <?php } }?>
    <div id="dpdd">
	
	  <div id="dpddg5">
      <h2 style=" color: green;"><?php echo $date; ?></h2>
      <p>Date [EST]</p>
      </div>
	  
	  <div id="dpddg6">
      <h2 style=" color: brown;"><?php echo $time; ?></h2>
      <p>Time [EST]</p>
      </div>
	     	  
    </div>
  </div>
  
    <script src="theme001/vendors/jquery-1.9.1.min.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script>
        <script src="theme001/assets/scripts.js"></script> 
		<?php
	$this->load->view("designer/footer");
?>