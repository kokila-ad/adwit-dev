<?php $this->load->view("new_csr/head.php"); ?>
<style>
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
</style>


<script>
   function Refresh() {
        window.parent.location = window.parent.location.href;
		<?php 
				$current_time = date("H:i:s"); 
		?>
    }
</script>

<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--<div class="navbar navbar-default" role="navigation">
            			<div class="navbar-header">
            				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            					<span class="sr-only">Toggle navigation </span>
            					<span class="icon-bar"></span>
            					<span class="icon-bar"></span>
            					<span class="icon-bar"></span>
            				</button>
            			</div>
            		</div>-->
                </div>
            </div>
		
        <div class="row">
        <div class="col-md-12">
		<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<!--<div class="portlet-title">
							<div class="tools">
								<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>-->
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="user_data">
								<thead>											
									<tr>
									    <th>Date</th>
										<th>Publication</th>
										<th>Job Name</th>
										<th>Advertiser Name</th>
										<th>Width</th>
										<th>Height</th>
										<th>AdColorInfo</th>
										<th>Notes</th>
										<th></th>
									</tr>
								</thead> 
							</table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>

<?php $this->load->view("new_csr/foot.php"); ?>

<script>
    $(document).ready(function(){ 
        //load table data
          var dataTable = $('#user_data').DataTable({  
               "processing":true,  
               "serverSide":true,  
               "order":[],
               "lengthMenu": [15, 25, 50, 75, 100],
                "pageLength": 15,
               "ajax":{  
                    url:"<?php echo base_url().index_page().'new_csr/home/tscs_preorder_list_content'; ?>",  
                    type:"GET",
                },
               "columnDefs":[  
                    {  
                         "targets":[],  
                         "orderable":false,  
                    },  
               ],
               /*"aoColumns": [
                    null,
                    { "sClass": "word-wrap-name" },
                ]*/
          }); 
       /*   
        setInterval( function () {
            dataTable.ajax.reload();
        }, 10000 ); //in milliseconds for every 30sec
        
        */
    });
</script>