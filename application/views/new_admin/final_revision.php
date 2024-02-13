<?php $this->load->view("new_admin/header"); ?>

<div class="portlet light">
	<div class="portlet-title">
	    <div class='row'>
        	<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">	
        		<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
        	</div>
    	</div>
		<div class="row margin-bottom-10 margin-top-10">
			<div class="text-right padding-right-0">
			<form method="get">	
				<div class="date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
					<div class="col-md-4 col-xs-6"> 
						<input type="text" class="form-control border-radius-left" name="from_date" 
						<?php if(isset($_GET['from_date'])) echo 'value="'.$_GET['from_date'].'"'; ?> placeholder="From Date" required>
					</div>
					<div class="col-md-4 col-xs-6">
						<input type="text" class="form-control border-radius-left" name="to_date"
						<?php if(isset($_GET['to_date'])) echo 'value="'.$_GET['to_date'].'"'; ?> placeholder="To Date" required>
					</div>					
					<div class="col-md-4 text-right">
						<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	<div class="row">
	<div class="portlet-body">	
		
		<table class="table table-striped table-bordered table-hover" id="sample6">
		
			<thead>
				<tr>
					<th>AdwitAds ID</th>
					<th>Job No</th>
					<th>Adrep</th>
					<th>Publication</th>
					<th>Final Version</th>
				</tr>
			</thead>
					
		</table>
		
	</div>
</div>

<?php $this->load->view("new_admin/footer"); ?>
<?php $this->load->view("new_admin/datatable"); ?>

<script>
//initialize datatable

$(document).ready(function(){
	var dataTable = $('#sample6').DataTable({
						"processing" : true,
						"serverSide" : true,
						"searchable" : false,
						"order" : [],
						"ajax" : {
							url: "<?php echo base_url().index_page().'new_admin/home/ajax_action'; ?>",
							method: "GET",
							data: {action:'fetch', page:'exam', from_date:'<?php echo $from_date ?>', to_date:'<?php echo $to_date ?>'}
						},
						"columnDef" : [
							{
								"targets" : [7],
								"orderable" : false
							}
						]
					});
					

});
</script>