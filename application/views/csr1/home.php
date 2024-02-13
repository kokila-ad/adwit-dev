<?php
	$this->load->view("csr/header");
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
	$csr_name=$this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array()
	?>


        <?php 
	$notification = $this->db->get_where('notification',array('users'=>'3', 'job_status'=>'1'))->result_array();
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

    <div id="Middle-text">
<p>Welcome <?php echo $csr_name[0]['name'];?></p>

</div>


	<?php //if($this->session->userdata('sId')=='25'){ 
		echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>';
	?>
	
      <form name="form" method="post" action="<?php echo base_url().index_page().'csr/home/cshift_order_search'; ?>">
      <div id="ad-form">
       <p class="contact"><label for="name">Search</label></p>
        <input name="id" type="text" autocomplete="off" required/>
        <input type="submit" name="search" />
      </div>
      </form>
      
	<?php  //} ?>


</div>

		
<?php
	$this->load->view("csr/footer");
?>