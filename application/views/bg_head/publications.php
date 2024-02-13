<?php
	$this->load->view("bg_head/header");
?>
    
	        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<div id="Middle-Div">
   <div class="row-fluid" style="width:80%; margin: 0 auto; ">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Publications</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table table-hover">
						              <thead>
						                <tr>
						                  <th>#</th>
						                  <th>Publication Name</th>
						                  <th>Initials</th>
						                  <th>Slug Type</th>
						                </tr>
						              </thead>
						              <tbody>
<?php
	$x = 1;
	foreach($news_bg as $row)
	{
?>									  
						                <tr>
						                  <td><?php echo $x; ?></td>
						                  <td><?php echo $row['name']; ?></td>
						                  <td><?php echo $row['initials']; ?></td>
						                  <td><?php echo $row['slug_type']; ?></td>
						                </tr>
<?php $x++; } ?>					
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                    <div class="row-fluid" style="width: 80%; margin: 0 auto;">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Slug Order</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table">
						              <tbody>
						                <tr class="success">
						                  <td>1</td>
						                  <td>Order Id</td>
                                          <td>Publication Initial</td>
						                  <td>Job Name</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
										<tr class="success">
						                  <td>2</td>
						                  <td>Order Id</td>
                                          <td>Publication Initial</td>
						                  <td>&nbsp;</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
                                        <tr class="success">
						                  <td>3</td>
						                  <td>Job Name</td>
                                          <td>Publication Initial</td>
						                  <td>Order Id</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
                                        <tr class="success">
						                  <td>4</td>
						                  <td>Order Id</td>
                                          <td>&nbsp;</td>
						                  <td>&nbsp;</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
                                        <tr class="success">
						                  <td>5</td>
						                  <td>Order Id</td>
                                          <td>Job Name</td>
						                  <td>&nbsp;</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
                                        <tr class="success">
						                  <td>6</td>
						                  <td>Job Name</td>
                                          <td>&nbsp;</td>
						                  <td>&nbsp;</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
                                        <tr class="success">
						                  <td>7</td>
						                  <td>Job Name</td>
                                          <td>Publication Initial</td>
						                  <td>&nbsp;</td>
						                  <td>Category</td>
                                          <td>Designer Code</td>
                                          <td>Version</td>
						                </tr>
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
  </div> 

        <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>
<?php
	$this->load->view("bg_head/footer");
?>