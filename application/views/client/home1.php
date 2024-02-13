<?php
       $this->load->view("client/header1");
?>
	<style>
		.container {
			width: 1170px;
			display: block;
			margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
		}
		.roww {
			width: 100%;
			float: left;
			display: block;
			margin: 0 15px;
		}
		.col-12 {
			width: 96%;
			float: left;
			padding-left: 10px;
            padding-right: 10px;
		}
		.col-6 {
			width: 46%;
			float: left;
			padding-left: 10px;
            padding-right: 10px;
		}
		.notify {
			float: left;
			display: block;
			padding: 15px;
			width:96%;
		}	
		.notification {
			float: left;
			display: block;
			width:96%;
			padding:15px;
			border: 1px solid #ddd;
			border-bottom: 0px;
		}	
		.notification:hover {
			cursor: pointer;
			background-color: #f5f5f5;
		}
		.center { text-align: center;}
		.img-full {max-width:100%; height:auto;}
		.img-size {width:100%; max-width:60px; height:60px;}
		.border {border: 1px solid #ddd;}
		.border-top {border-top: 1px solid #ddd;}
		.border-bottom {border-bottom: 1px solid #ddd;}
		.float-left {float:left;}
		.float-right {float:right;}
		.margin-right-15{ margin-right:15px;}
		.small {font-size:12px;}
		.medium {font-size:16px;}
		.xlarge {font-size:20px;}
		.margin-0{margin:0;}
		.margin-top-5{margin:5px 0 0 0;}
		.margin-top-10{margin:10px 0 0 0;}
		.padding-5{padding:0px 15px 2px 15px;}
		.padding-bottom-10{padding-bottom: 10px;}
		.margin-bottom-15{margin-bottom: 15px;}
	</style>

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
	echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';
	$client_name=$this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array()
	?>
  
    <div id="Middle-text">Welcome <?php echo $client_name[0]['first_name']." ".$client_name[0]['last_name'];?>
<!-- search -->
<div style="width: 400px; margin: 0 auto; padding-top: 50px;">
<?php if($client_name[0]['team_orders']=='1'){ ?>

<form method="post" action="<?php echo base_url().index_page().'client/home/myteam_orders';?>">
	<span>Search:  </span><input type="text" name="search" id="search" placeholder="search" />
               <input type="submit" value="Submit" />
   </form>

<?php }else{ ?>

<form method="post" action="<?php echo base_url().index_page().'client/home/search_orders';?>">
    <input type="text" name="search" id="search" placeholder="search order"  style="padding: 5px; outline:none;" required /> 
    <input type="submit" value="Search" />
</form>

<?php } ?>
<br><br>
<?php if($client_name[0]['ad_search']=='1') { ?> <p style="font-size: 12px;"><a href="<?php echo base_url().index_page()."client/home/advanced_search";?>">Advanced Search</a></p> <?php } ?>
</div>
<!-- search -->
</div>

<!-- Notification -->    
<?php if(isset($notification_list)){ ?>    
<div class="roww">
<?php      foreach($notification_list as $list){ ?>
		<div class="col-12">
			<a href="<?php echo base_url().index_page().'client/home/notification'; ?>">
				<div class="notification">
				<?php if($list['image']!='none'){ ?>
					<div class="float-left margin-right-15">
						<img class="img-size" src="<?php echo base_url().$list['image']; ?>" alt="image">
					</div>
				<?php } ?>
					<div class="float-left">
						<p class="xlarge margin-bottom-5"><?php echo $list['headline']; ?></p>
						<!--<p class="medium margin-top-5">Lorem Ipsum is simply dummy text of the printing and...</p>-->
					</div>
				</div>
			</a>
		</div>		
<?php } ?>
		<div class="col-12">
			<a href="<?php echo base_url().index_page().'client/home/notification'; ?>">
				<div class="notification border-bottom padding-5">
					<div class="center">
						<p class="small margin-top-5">View All</p>
					</div>
				</div>
			</a>
		</div>
	</div>  
<?php } ?>
<!-- Notification --> 
  
  </div>
         
<script src="theme001/vendors/jquery-1.9.1.min.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script>
        <script src="theme001/assets/scripts.js"></script>  
		 
<?php
       $this->load->view("client/footer");
?>