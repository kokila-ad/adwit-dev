<?php $this->load->view("new_admin/header.php");?>
<style>
    .tooltip-wrap {
  position: relative;
}
.tooltip-wrap .tooltip-content {
  display: none;
  position: absolute;
  bottom: 5%;
  left: 5%;
  right: 5%;
  background-color: #fff;
  padding: .5em;
}
.tooltip-wrap:hover .tooltip-content {
  display: block;
}

</style>
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

	<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				 
				<div class="portlet light">
					<div class="portlet-body">					
					
					
				<hr>		
			
				<!-- BEGIN PAGE HEADER-->
				<!-- END PAGE HEADER-->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green-haze">
							<div class="portlet-title">
								<div class="caption">
									Category By Designer Report : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>
								</div>
								<div class="tools  margin-left-10">
									<a href="javascript:;" class="collapse">
									</a>
									<a href="javascript:;" class="reload">
									</a>
								</div>
								<div class="margin-top-10 text-right">
									<!--<button class="btn bg-grey btn-xs"><i class="fa fa-file-excel-o"></i> Export</button>-->
									<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
									<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
								</div>
							</div>
							
							<div class="portlet-body">
								<div class="portlet light margin-bottom-5">
								<div class="portlet-body">					
									<div class="row">
									    <div class="col-md-4 col-lg-4">
									        <form method="get">
									        <select id="dateRange" name="dateRange" class="colorselector select2me form-control margin-bottom-10 border-radius-5  select2-offscreen" tabindex="-1" title="">
                        						<option value="">Select</option>
                        						<option value="today" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'today') echo 'selected'; ?>>Today</option>
                        						<option value="one_week" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_week') echo 'selected'; ?>>1 Week</option>
                        						<option value="one_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_month') echo 'selected'; ?>>1 Month</option>
                        						<option value="three_month" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'three_month') echo 'selected'; ?>>3 Month</option>
                        						<option value="one_year" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'one_year') echo 'selected'; ?>>1 Year</option>
                        						<option value="custom" <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom') echo 'selected'; ?>>Custom</option>
                        					</select>
                        					</form>
									    </div>
									    <div class="col-md-8 col-lg-8 text-right" id="customDiv">
									     	<form id="form_date" method="get">
    											
    											<div class="col-md-4">
    												<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
    													<input type="text"  name="from_date" id="from_date" <?php if(isset($_GET['from_date'])) echo"value='".$_GET['from_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" required>
    													<span class="input-group-addon"> to </span>
    													<input type="text" name="to_date" id="to_date" <?php if(isset($_GET['to_date'])) echo"value='".$_GET['to_date']."'"; ?> placeholder="YYYY-MM-DD" class="form-control" autocomplete="off" required>
    												</div>
    											</div>	
    											<div class="">
    											    <input type="hidden" name="dateRange" value="custom">
    												<input type="submit" name="date_submit" class="btn bg-green-haze" value="Submit">
    											</div>
    										</form>
										</div>
									</div>
								</div>
							</div>
				
								<table class="table table-striped table-bordered table-hover" id="sample_6">
								<thead>
								<tr>
									<th>Designer Name</th>
									<th>P</th>
									<th>M</th>
									<th>N</th>
									<th>T</th>
									<th>W</th>
								</tr>
								</thead>
								<tbody>
                                <?php 
                                if(isset($designers[0]['id'])){
                                    $total_p = '0'; $total_m = 0; $total_n = 0; $total_t = 0; $total_w = 0;
                                	foreach($designers as $row ){
                                	    $cat_result = $this->db->query("SELECT category, COUNT(id) AS category_count FROM `cat_result` 
                                               WHERE  `designer`='".$row['id']."' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY `category`;")->result_array();
                                        $p = 0; $m = 0; $n = 0; $t = 0; $w = 0;
                                                    foreach($cat_result as $cat){
                                                        if($cat['category'] == 'P'){ 
                                                            $p= $cat['category_count'];     $total_p = $total_p + $p;  
                                                        }elseif($cat['category'] == 'M'){ 
                                                            $m= $cat['category_count'];     $total_m = $total_m + $m;
                                                        }elseif($cat['category'] == 'N'){ 
                                                            $n = $cat['category_count'];    $total_n = $total_n + $n;
                                                        }elseif($cat['category'] == 'T'){ 
                                                            $t = $cat['category_count'];    $total_t = $total_t + $t; 
                                                        }elseif($cat['category'] == 'W'){ 
                                                            $w = $cat['category_count'];    $total_w = $total_w + $w;
                                                        }
                                                    } 
                                ?>								
                                                		<tr>
                                                			<td><?php echo $row['name']; ?></td>
                                                			
                                                			<td><?php echo $p; ?></td>
                                                			
                                                			<td><?php echo $m; ?></td>
                                                			
                                                            <td><?php echo $n; ?></td>
                                                			
                                                			<td><?php echo $t; ?></td>
                                                			
                                                			<td><?php echo $w; ?></td>
                                                			
                                                		</tr>
                                <?php 
                                    } 
                                } 
                                    if(isset($total_p)){
                                ?>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th><?php echo $total_p; ?></th>
                                                            <th><?php echo $total_m; ?></th>
                                                            <th><?php echo $total_n; ?></th>
                                                            <th><?php echo $total_t; ?></th>
                                                            <th><?php echo $total_w; ?></th>
                                                        </tr>
                                                    </tfoot>
                                <?php } ?>
                                </tbody>
		                    </table>
		                </div>
		            </div>
		<!-- END EXAMPLE TABLE PORTLET-->
		        </div>
	        </div>
	    </div>
    </div>
		<!-- END CONTENT -->
		
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
</div>
	<!-- END CONTAINER -->
<script>
$(document).ready(function(){
    <?php if(isset($_GET['dateRange']) && $_GET['dateRange'] == 'custom'){ ?>
        $('#customDiv').show();
     <?php }else{ ?>
        $('#customDiv').hide();
     <?php } ?>
    $("#dateRange").change(function() {
        var d = $(this).val(); //alert(d);
        if(d == 'custom'){
            $('#customDiv').show();
        }else{
            this.form.submit();
        }
    });

});
        $(function() {
            
        });
        </script>
		<script>
		
			var tableToExcel = (function() {
				
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
		
        </script>
	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

