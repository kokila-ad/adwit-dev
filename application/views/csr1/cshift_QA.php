<?php
       $this->load->view("csr/header"); 
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
<?php if(isset($form)){?>
<!--<meta http-equiv="refresh" content="<?php echo "60"; ?>;URL='<?php echo base_url().index_page().'csr/home/cshift/'.$form; ?>'">-->
<?php } ?>
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
    function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php /*if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('America/Chicago');
				}*/
				$current_time = date("H:i:s"); 
		?>
    }
</script>
<script type="text/javascript">

function flip(id)
{
 if($("#priority-"+id+"").is(':checked') )
   $("#notes-"+id+"").show();
 else
    $("#notes-"+id+"").hide();
	
} 

</script>

<script type="text/javascript">
	$(document).ready(function(e) {
	
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/cshift/';?>" + $('#help_desk').val() ;
        });
		
		
    });
	
</script>

<script type="text/javascript">	//all pending
	$(document).ready(function(e) {
        $('#display_type').change(function(e) {
		
            window.location = "<?php echo base_url().index_page().'csr/home/cshift/'.$form.'/';?>" + $('#display_type').val() ;
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
	echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>';
 if(isset($form)):
 ?>
		
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
  <div style="padding-bottom: 30px;"> 
  <div style="float: right;">
  <form name="form" method="post" action="<?php echo base_url().index_page().'csr/home/cshift_order_search'; ?>">
      
       <p class="contact">Search History
        <input name="id" type="text" autocomplete="off" required/>
        <input type="submit" name="search" /></p>
      
  </form>
  </div>
  </div>
  <div style="padding-bottom: 20px;"> 
  <div style="float: right;">
  
		<select id="display_type" name="display_type" style="width:80px; height:20px;" >
			<!--<option value="pending" <?php echo ($display_type=='pending' ? 'selected="selected"' : ''); ?> >Pending</option>-->
			<option value="new_pending" <?php echo ($display_type=='new_pending' ? 'selected="selected"' : ''); ?> >All pending</option>
			<option value="category" <?php echo ($display_type=='category' ? 'selected="selected"' : ''); ?> >Category</option>
			<option value="inproduction" <?php echo ($display_type=='inproduction' ? 'selected="selected"' : ''); ?> >Inproduction</option>
			<option value="QA" <?php echo ($display_type=='QA' ? 'selected="selected"' : ''); ?> >QA</option>
			<option value="upload" <?php echo ($display_type=='upload' ? 'selected="selected"' : ''); ?> >Upload</option>
			<!--<option value="all" <?php echo ($display_type=='all' ? 'selected="selected"' : ''); ?> >All</option>
			<option value="sent" <?php echo ($display_type=='sent' ? 'selected="selected"' : ''); ?> >Sent</option>-->
		</select>
		
	<a onclick="Refresh()" style="cursor: pointer;">&nbsp;<img title="Refresh" src="images/refresh_trackingsheet.png"/></a>
  </div>
  <div style="float: left;">
		<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/new_cat/'.$form;?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >New Ad</button></a>
		<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/pickup';?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-info btn-mini" >Pickup Ad</button></a>
		<?php if($form=='15'){ ?>
			<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/softwrite_orders';?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Design8 Ad</button></a>
		<?php } ?>
		<?php if($form=='2'){ ?>
			<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/metro_orders';?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Metro Ad</button></a>
		<?php } ?>
  </div>
   </div>
   
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Cshift Tracker : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}else{echo $ystday."  to  ".$today ;} ?></div>
		<!--<div style="float: right;">
		<form name="form" method="post">
			<input type="submit" name="pday" value="Previousday" />
			<input type="submit" name="yday" value="Yesterday" />
			<input type="submit" name="today" value="Today" />
		</form>
		</div>-->
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
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
                <!--<th style="text-align: center;">Category</th>
                <th style="text-align: center;">Design</th>-->
                <th style="text-align: center;">QA</th>
                <!--<th style="text-align: center;">Upload</th>
				<th style="vertical-align: middle;">Actions</th>-->
              </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
<?php 
	
			if(isset($from) && isset($to)){
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='".$form."' AND `status`='3' AND `cancel`!='1' AND `crequest`!='1' AND (`created_on` BETWEEN '$from' AND '$to') ;")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='".$form."' AND `status`='3' AND `cancel`!='1' AND `crequest`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();		
			}
		
		$i=1;
		foreach($orders as $row1)
		{
			$order_type = $this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['publication_id']."' ;")->result_array();		
			$cat_result = $this->db->query("SELECT * FROM `csr`,`cat_result` WHERE `order_no`='".$row1['id']."' AND csr.id = cat_result.csr ")->result_array();
			
			if($cat_result){ $cat_designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array(); }
			
?>
              <tr <?php if($row1['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="odd gradeX error"'; } ?>>

<!-- date -->			<td><?php $date = strtotime($row1['created_on']); echo date('Y-m-d', $date); ?></td>

<!-- type -->			<td title="<?php echo $order_type[0]['name']; ?>"><img src="<?php echo $order_type[0]['src']; ?>" alt="<?php echo $order_type[0]['name']; ?>"/><span style="display:none;"><?php echo $order_type[0]['name']; ?></span></td>

<!-- order_no --> 		<td title="view attachments"><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/attachments/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><?php echo $row1['id']; ?></a></td>

<!-- job_name -->		<td><?php echo $row1['job_no']; ?></td>

<!-- newspaper -->		<td><?php echo $publication_name[0]['name']; ?></td>

<!-- category 		<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ 
								echo'<td>Cancelled</td>';
							}elseif($cat_result && $row1['rush']=='1'){ //rushad
								echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'<span style="display:none;">rush</span></td>';
							}elseif($cat_result) echo'<td title="'.$cat_result[0]['name'].'">'.$cat_result[0]['category'].'</td>'; 
						?>
-->							
<!-- design          <?php if($cat_result && $cat_result[0]['slug']!='none'){ 
								echo "<td title='".$cat_designer[0]['username']."'style='cursor:pointer;'>Completed</td>";
							}else{ echo"<td>Pending</td>"; } ?>
-->				           
<!-- QA -->             <?php if( ($row1['cancel']=='0' || $row1['cancel']=='2') && $cat_result && $cat_result[0]['slug']!='none' && $cat_result[0]['cancel']=='0' ){ ?>
							<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_cp_tool/'.$form.'/'.$row1['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >QA</button></a></td>     
						<?php	}elseif($row1['crequest']=='1'){echo "<td>Cancel Request Sent</td>";}elseif($row1['question']=='1'){echo "<td>Question Sent</td>";}else{ echo "<td>Pending</td>"; } ?>
			 
<!-- upload		 <td>
						<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0'){ echo "Cancelled" ; }elseif($job_status){
						if($job_status[0]['upload_csr']!='0'){ echo "uploaded" ; }else{  ?>
								<a href="<?php echo base_url().index_page().'csr/home/pdf_upload/'.$row1['id'].'/'.$job_status[0]['id'];?>" onclick="javascript:void window.open('<?php echo base_url().index_page().'csr/home/pdf_upload/'.$row1['id'].'/'.$job_status[0]['id'];?>','1432728298066','width=800,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=50,top=20');return false;"><button class="btn btn-success btn-mini">Upload</button></a>
							
						<?php } } ?>
					</td> -->

<!--action:cancel 	<?php if(($cat_result && $cat_result[0]['cancel']!='0') || $row1['cancel']!='0')
							  { 
								echo"<td>Cancelled</td>"; 
							  }elseif($cat_result && $cat_result[0]['question']!='none' && $cat_result[0]['answer']=='none')
							  { ?> 
								<td><a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/cshift_answer/'.$form.'/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Question Sent</button></a></td>
						<?php }elseif($cat_result){ ?>
					<td>
					<div class="btn-group">
						<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'csr/home/ordercshift_cancel/'.$form.'/'.$cat_result[0]['id'];?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-danger btn-mini" >Cancel</button></a>
						<button data-toggle="dropdown" class="btn btn-danger btn-mini dropdown-toggle"><span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/cshift_question/'.$cat_result[0]['id'];?>'" >Question</a></li>
							<li><a href="javascript:;" onclick="window.location = '<?php echo base_url().index_page().'csr/home/delay_msg/'.$form.'/'.$row1['id'];?>'" >Delay</a></li>
						</ul>
					</div>
					</td>
				<?php }else{ echo"<td></td>"; } ?>
			-->	
			  </tr>
   <?php $i++; } ?>
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
       $this->load->view("csr/footer");
?>