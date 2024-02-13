<?php
       $this->load->view("designer/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
		
<?php if(isset($form)){ ?>
<meta http-equiv="refresh" content="60;URL='<?php echo base_url().index_page().'designer/home/Qrevision/'.$form; ?>'">
<?php } ?>

<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="http://www.formmail-maker.com/var/demo/jquery-popup-form/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://www.formmail-maker.com/var/demo/jquery-popup-form/jquery.colorbox-min.js"></script>
<!--
<script type="text/javascript">
	
	$(document).ready(function($) {    

   		$( "#from_date" ).datepicker({ minDate: "-8D", maxDate: 0, dateFormat: 'yy-mm-dd' });
		
		$( "#to_date" ).datepicker({ minDate: "-8D", maxDate: 0, dateFormat: 'yy-mm-dd'});
		
		
		
	});

</script>
-->
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'designer/home/Qrevision/';?>" + $('#help_desk').val() ;
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
<?php echo '<h3 style="color:#900;">'.$this->session->flashdata('message').'</h3>';
if(isset($form)):?>



<div class="row-fluid" style="width:96%; margin: 0 auto;">
<div style="padding-bottom: 20px;">
	<!--search-->
  <div style="float: right;">
	<form name="form" method="post" action="<?php echo base_url().index_page().'designer/home/Qrevision_search'; ?>">
       <p class="contact">Search History
        <input name="order_id" type="text" autocomplete="off" required/>
		<input name="form" value="<?php echo $form;?>" readonly style="display:none;" />
        <input type="submit" name="search" /></p>
	</form>
  </div>
	<!-- date panel -->
	<div style="float: left;">
		<form name="form" method="post" action="<?php echo base_url().index_page().'designer/home/Qrevision/'.$form; ?>">
			<input type="submit" name="pday" value="<?php echo $pystday; ?>" />
			<input type="submit" name="yday" value="<?php echo $ystday; ?>" />
			<input type="submit" name="today" value="<?php echo $today; ?>" />
		</form>
	</div>	
</div>
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Qrevision : <?php /*if(isset($from) && isset($to)){echo $from." to ".$to;}*/if(isset($to)){echo $to;} if(isset($count)){echo '&nbsp;&nbsp;<b style="color:blue"> Count : '.$count.'</b>';}?> </div>
		
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" />&nbsp;</div>
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
                <th>No</th>
				<th>Order Id</th>
				<th>Previous Slug</th>
                <!--<th>Version</th>-->
                <th>Designer</th>
				 <th>Category</th>
				<th>Inst/Attch</th>
              </tr>
             </thead>
            <tbody name="testTable" id="testTable">
<?php
$i=0;
foreach($orders_rev as $row){ $i--;
	$designer = $this->db->get_where('designers',array('id'=>$row['designer']))->result_array();
?>
              <tr class="odd gradeX">
                <td><?php echo $i; ?></td>
				<td><?php echo $row['order_id']; ?></td>
				<td><?php echo $row['order_no']; ?></td>
				
				<?php if($row['new_slug']=='none' && $row['order_id']!=''){ ?>
				<td>
					<form name="myform" method="post" action="<?php echo base_url().index_page().'designer/home/Qrevision/'.$form; ?>" >
						<input type="submit" name="create_slug" value="Create Slug" />
						<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
						<input name="order_id" value="<?php echo $row['order_id'];?>" readonly style="display:none;" />
						<input name="prev_slug" value="<?php echo $row['order_no'];?>" readonly style="display:none;" />
						<input name="version" value="<?php echo $row['version'];?>" readonly style="display:none;" />
					</form>
				</td>
				<?php }elseif($row['order_id']=='' && $row['designer']=='0'){ ?> 
				<td><!--without order id-->
					<div class="form-group">
						<form name="form" action="<?php echo base_url().index_page().'designer/home/revision_v2/'.$form;?>" method="post">
						  <select class="form-control input-medium" id="csr" name="csr" required >
							<option value="">Select Chekker</option>
							<?php foreach($csr as $result){ echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>'; } ?>
						  </select>
						  
						   <input name="rev_id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
						   <input name="category" value="<?php echo $row['category'];?>" readonly style="display:none;" />
						   <input type="text" name="id" id="id" value="<?php echo $row['order_no'];?>" readonly style="display:none;" />
						   <input type="submit" name="submit_order" value="Submit" />
						</form>
					</div>
				</td>
				<?php }elseif($row['order_id']!='' && $row['designer']!='0' && $row['QA_csr']=='0'){ ?> 
				<td><!--with order id-->
					<div class="form-group">
						<form name="form" action="<?php echo base_url().index_page().'designer/home/revision_v2/'.$form;?>" method="post">
						  
						  <select class="form-control input-medium" id="csr" name="csr" required >
							<option value="">Select Chekker</option>
							<?php foreach($csr as $result){ echo '<option value="'.$result['id'].'" >'.$result['name'].'</option>'; } ?>
                         </select>
						   <input name="rev_id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
						   <input type="submit" name="submit_QA_csr" value="Submit" />
						</form>
					</div>
				</td>
				<?php }else{ ?>
				<td title="<?php echo $row['new_slug']; ?>" style='cursor:pointer;'>
				<?php if($row['designer']!='0')echo $designer[0]['username']; ?>
				</td>
				<?php } ?>
				<td><?php if($row['category']=='revision') echo '<b style="color:blue">'.$row['category'].'</b>'; elseif($row['category']=='sold') echo '<b style="color:green">'.$row['category'].'</b>'; ?></td>
				<td><a onclick="window.open('<?php echo base_url().index_page().'designer/home/frontline_instruction/'.$row['id'];?>')" style="cursor:pointer; text-decoration: none;">Click</a></td>
              </tr>
<?php } ?>
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

<script>
  $(document).ready(function(){
	$(".iframe").colorbox({iframe:true, fastIframe:false, width:"450px", height:"480px", transition:"fade", scrolling : false});
  });
</script>
 
 <style>
  #cboxOverlay{ background:#666666; }
 </style>
                                 
<?php
       $this->load->view("designer/footer");
?>