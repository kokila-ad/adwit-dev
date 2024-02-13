<?php $this->load->view('new_admin/header')?>
<!--
<script type="text/javascript" src="jquery-1.3.2.js" ></script>
<script type="text/javascript" src="html2csv.js" ></script>
-->
<style>
	input[type="text"] { border: 0 !important;}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$("#save_data").hide();	
		$('#form_data').click(function() {
			$("#save_data").show();
		});
	});		
</script>

<div class="col-md-12">
<form method="post" name="order_form" id="order_form">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="#" class="font-lg font-grey-gallery">Production NJ</a> - 
					<a href="#" class="font-lg font-grey-gallery"><u>CSR</u></a>
				</div>
				
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
					<?php if(null != $this->session->flashdata('message')){ ?>						
						<span class="alert alert-success margin-0 padding-5 small"><?php echo $this->session->flashdata('message'); ?></span>
					<?php } ?>
					<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>	
					<button type="submit" class="btn btn-primary btn-xs" name="Save" id="save_data">Save</button>					
					<span class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</span>
				<!--<span class="btn bg-grey btn-xs" onclick=""><i class="fa fa-file-excel-o"></i>Export</span>-->
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<!--<th>Categorize Per Hour </th>
					<th>Quality Check Per Hour</th>
					<th>Double Check Per Hour</th>
					<th>Roving Check Per Hour</th>
					<th>Revision Double Check Per Hour</th>-->
					<th>New Order</th>
					<th>categorized</th>
					<th>QA</th>
					<th>DC</th> 
					<th>Revision Order Created</th>
					<th>Revision Accepted</th>
					<th>Roving Check</th>
					<th>Revision Sent</th>
					<th>Error</th> 
				</tr>
			</thead>
			<tbody id="form_data">
			<?php if(isset($prod_nj)){?>
				<tr>
				<?php foreach($prod_nj as $row){ ?>
					<td>
						<input type="text" value="<?php echo $row['value']; ?>" name="value<?php echo $row['id']; ?>" class="form-control">
						<!--<input type="text" value="<?php echo $row['id']; ?>" name="id<?php echo $row['id']; ?>" style="display:none">-->
					</td>
				<?php } ?>
				</tr>
			<?php }?>
			</tbody>
			</table>
		</div>
	</div>
</form>
</div>

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
<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
