<?php
       $this->load->view("team-lead/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<?php if(isset($form)){?>
<meta http-equiv="refresh" content="<?php echo "60"; ?>;URL='<?php echo base_url().index_page().'team-lead/home/cshift/'.$form; ?>'">
<?php }?>
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
            window.location = "<?php echo base_url().index_page().'team-lead/home/cshift/';?>" + $('#help_desk').val() ;
        });
		
		
    });
	
</script>

<script type="text/javascript">	//all pending
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'team-lead/home/cshift/'.$form.'/';?>" + $('#display_type').val() ;
        });
    });
</script>

<div id="Middle-Div">
		
<p style="text-align:center;"> 
        	Select Your Help Desk:&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
</p>
<?php 
	echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';
 if(isset($form)):
 ?>
		
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
  <div style="padding-bottom: 30px;"> 
  <div style="float: right;">
  <!--<form name="form" method="post" action="<?php echo base_url().index_page().'team-lead/home/cshift_search/'.$form; ?>">
      
       <p class="contact">Search History
        <input name="id" type="text" autocomplete="off" required/>
        <input type="submit" name="search" /></p>
      
  </form>-->
  </div>
  </div>
  
  <div style="padding-bottom: 20px;"> 
  <div style="float: right;">
  
		<select id="display_type" name="display_type" style="width:80px; height:20px;" >
			<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>
			<option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
			<!--<option value="sent" <?php echo ($display_type=='sent' ? 'selected="selected"' : ''); ?> >Sent</option>-->
		</select>
	<a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img title="Refresh" src="images/refresh_trackingsheet.png"/></a>
  </div>
 
   </div>
   
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Cshift Tracker : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($ystday) && isset($today)){echo $ystday."  to  ".$today ;} ?></div>
		<!--<div style="float: right;">
		<form name="form" method="post">
			<input type="submit" name="pday" value="Previousday" />
			<input type="submit" name="yday" value="Yesterday" />
			<input type="submit" name="today" value="Today" />
		</form>
		</div>-->
		<div style="float: right;"><input type="button" onclick="tableToExcel('example', 'W3C Example Table')" value="Export to Excel" /></div>
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
				<th style="vertical-align: middle;">Date</th>
				<th style="vertical-align: middle;">Type</th>
                <th style="vertical-align: middle;">Adwit Id</th>
				<th style="vertical-align: middle;">Job Name</th>
				<th style="vertical-align: middle;">Publication</th>
				<?php if($form=='5')echo '<th style="vertical-align: middle;">Design Team</th>'; ?>
				<th style="text-align: center;">Assign</th>
                <th style="text-align: center;">Category</th>
                <th style="text-align: center;">Design</th>
                <!--<th style="text-align: center;">QA</th>-->
                <th style="text-align: center;">Upload</th>
				
              </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
	foreach($publication as $row)
	{
			if(isset($from) && isset($to))
			{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='".$row['id']."' AND (`created_on` BETWEEN '$from' AND '$to') ;")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='".$row['id']."' AND `cancel`='0' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();		
				//$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='".$row['id']."' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();		
			}
		
		$i=1;
		foreach($orders as $row1)
		{
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			
			if($cat_result){
				$cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
			}
			$job_status = $this->db->query("SELECT * FROM `csr`,`cp_tool` WHERE `order_no`='".$row1['id']."' AND csr.id = cp_tool.csr ")->result_array();
			
			//if((!$job_status || $job_status[0]['upload_csr']=='0') && ($row1['cancel']=='0') && (!$cat_result || $cat_result[0]['cancel']=='0') ){ 
			//if($cat_result && $cat_result[0]['cancel']=='0' && $cat_result[0]['pdf_path']=='none')
			//{
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>
<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>
<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><img src="<?php echo $order_type[0]['src']; ?>" alt="<?php echo $order_type[0]['name']; ?>"/><span style="display:none;"><?php echo $order_type[0]['name']; ?></span></td>
<td title="view attachments"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'team-lead/home/attachments/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>							
<!-- order_no --> 		<!--<td><?php echo $row1['id']; ?></td>-->
<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>
<!-- newspaper -->		<td><?php echo $row['name']; ?></td>

<!-- design team -->	<?php if($form=='5' && $row['design_team_id']=='4'){echo "<td>D6</td>";}elseif($form=='5' && $row['design_team_id']=='5'){ echo "<td>D7</td>"; } ?>

<!-- assign --> 		<td><?php if($cat_result){ ?>
							<form name="myform" method="post">
								<select name="design_assign" onchange="this.form.submit()" style="width: 50px;">
									<option value="" >Select</option>
								<?php foreach($design_assign as $result){
									echo "<option value='".$result['id']."'".($result['id']==$cat_result[0]['assign'] ? 'selected=selected': '').">".$result['name']."</option>" ;
										
								} ?>
								<input name="cat_id" value="<?php echo $cat_result[0]['id']; ?>" readonly style="display:none;" />
								</select>
							</form>
							<?php } ?>
						</td>

<!-- category -->		<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ 
								echo'<td></td>';
							}elseif($cat_result){  
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'</td>';
							}else{?>
							<td>Pending</td>
						 <?php } ?>
<!-- design -->         <?php if($cat_result && $cat_result[0]['slug']!='none'){ echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>"; }
							  elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none'){echo "<td><b>Question Sent</b></td>"; }
							  else{ echo"<td>Pending</td>"; } ?>
				           
<!-- QA            <?php if($job_status){ echo "<td title='".$job_status[0]['name']."' style='cursor:pointer;'>".$job_status[0]['job_status']."</td>"; }
							elseif($cat_result && $cat_result[0]['slug']!='none'){
							?>
							<td>Pending</td>     
						<?php }else{ echo "<td>Pending</td>"; } ?>
			 -->
<!-- upload -->		<td>
						<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0')
						{ echo "Cancelled" ; }elseif($job_status && $job_status[0]['upload_csr']!='0')
						{ echo "uploaded" ; } ?>
					</td>
				 </tr>
   <?php $i++; //} 
    } }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
 <?php  endif;?>
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
        <script>
		//tableToExcel('testTable', 'W3C Example Table')
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

                                  
<?php
       $this->load->view("team-lead/footer");
?>