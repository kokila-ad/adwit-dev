<?php
	$this->load->view("client/header1");
?>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		
    }
</script>
<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-6M", maxDate: 0, dateFormat: 'yy-mm-dd'});
	
	});

</script>

<div id="Middle-Div">
<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>

 <div class="row-fluid" style="width: 96%; margin: 0 auto; "> 
<div style=" float: left;">
    <form method="post" action="<?php echo base_url().index_page().'client/home/preorders';?>" style="padding:0; margin:0;">
      <span>From &nbsp;</span>
      <input type="text" name="from_date" id="from_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      &nbsp;&nbsp;<span>To &nbsp;</span>
      <input type="text" id="to_date" name="to_date" placeholder="YYYY-MM-DD" style="border: thin solid #CCC; padding:5px; outline: none; margin:0;"/>
      <input type="submit" value="Submit" name="duration" />
    </form>
  </div>
  <div style=" float: right;">
  <form method="post" action="<?php echo base_url().index_page().'client/home/search_orders';?>" style="padding:0px; margin:0px; float: right;" >
    <span>Search </span>
    <input type="text" name="search" id="search" placeholder="search" style="padding: 5px;" required />
    <input type="submit" value="Submit" />
  </form>
  </div>
  
 </div>
  
  
  
<div class="row-fluid" style="width:96%; margin: 0 auto;">
<div style="padding-bottom: 20px;">


<!-- Pre Order Table Starts -->
<div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                <a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/myorders_v2';?>'" style="cursor:pointer; text-decoration: none;"><button>All</button></a> 
								<!--
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/myorders/proofready';?>'" style="cursor:pointer; text-decoration: none;"><button>Proof Ready</button></a> 
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/myorders/approved';?>'" style="cursor:pointer; text-decoration: none;"><button>Approved</button></a> 
									-->
									<a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'client/home/preorders';?>'" style="cursor:pointer; text-decoration: none;"><button>Booked-<?php if(isset($preorder)) echo count($preorder); ?></button></a>
                                </div>
                                  <div style="float: right;">
									<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" />
									<a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img title="Refresh" src="images/refresh_trackingsheet.png"/></a> 
								</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  									<table class="table table-bordered">
						              <thead>
						                <tr>
												<th>S</th>
												<th>Unique Job ID</th>
												<th>Advertiser Name</th>
												<th>Publish Date</th>
												<th>Status</th>
												<th>Action</th>
						                </tr>
						              </thead>
						              <tbody>
                                      <?php
	foreach($preorder as $row){
		
?>	
						                <tr>
												<td><?php echo $row['status']; ?></td>
												<td><?php echo $row['job_name']; ?></td>
												<td><?php echo $row['advertiser']; ?></td>
												<td><?php echo $row['publish_date']; ?></td>
												<td><?php echo "Booked"; ?></td>
												<td><form name="myform" action="<?php echo base_url().index_page().'client/home/preorders';?>" method='post'><input type="submit" name="Submit" value="Submit" /><input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" /></form></td>					
						                </tr>
                                        <?php } ?>	
						              </tbody>
						            </table>
                                </div>
                            </div>
                        </div>
                        <!-- Pre Order Table Ends -->

                        </div>
						
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
	$this->load->view("client/footer");
?> 