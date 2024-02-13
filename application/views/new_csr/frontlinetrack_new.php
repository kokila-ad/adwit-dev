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
        <div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">
									Toggle navigation </span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									<span class="icon-bar">
									</span>
									</button>
									
									<div id="display_selected_hd"></div>
									
									<a class="navbar-brand" href="javascript:;"><?php echo $this->session->flashdata('sold_status');?></a>
									<?php if(isset($_SESSION['helpDesks'])) print_r($_SESSION['helpDesks']); ?>
									
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse navbar-ex1-collapse">
									<ul class="nav navbar-nav navbar-right">
									<?php //if(!empty($helpDesks) && in_array(2, $helpDesks)){ ?>
									<li class="margin-top-10" id="metro_search_tab" style="display:none">
									   <form class="search-form"  name="form" method="get" action="<?php echo base_url().index_page()."new_csr/home/metro_revision/2"; ?>">
											<div class="col-sm-8"  style="padding: 0;">
												<input type="text" class="form-control" placeholder="Metro Order Search" name="orderId" required>
												<!--<input name="form" value="<?php echo $form;?>" readonly style="display:none;" />-->
											</div>
											<div class="col-sm-4"  style="padding: 0;">
												<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
											</div>		
									   </form>
									</li>
									 <?php //} ?>
									
								    <!--
										<li style="display:none !important" id="vidn_link">
											<a onclick="window.location ='<?php echo base_url().index_page().'new_csr/home/vidn_rev_entries';?>'" href="javascript:;">
											Vidn Entries </a>
										</li>
									-->
									
									<?php 
									if(!empty($selected_help_desk)){ 
									    $help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` IN ($selected_help_desk) AND `sold` = '1'")->result_array();
									    if(isset($help_desk1[0]['id'])){ 
									?>
    									<li>
    										<a href="<?php echo base_url().index_page().'new_csr/home/sold_track/'.$help_desk1[0]['id'];?>" target="_blank" href="javascript:;">				
    										Sold Orders</a>								
    									</li>
									<?php } } ?>
									
									<li>
										<a href="<?php echo base_url().index_page().'new_csr/home/revision_new';?>" target="_blank" href="javascript:;">				
										Create Revision</a>								
									</li>
									
										<li class="dropdown">
											<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											Select Desk &nbsp;<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu">
											    <form method="post" id="select_hd">    
        											<?php foreach($help_desk_data as $type){ ?>
        												<li>
        				                            	    <p>
            												    <input class="multiple_hd_select" type="checkbox" name="helpDesks[]" value="<?php echo $type['id']; ?>" 
            												        <?php if(isset($_SESSION['helpDesks']) && !empty($_SESSION['helpDesks']) && in_array($type['id'], $_SESSION['helpDesks'])) echo'checked="checked"'; ?>>
            												    <?php echo $type['name']; ?>
        													</p>
        												</li>
        											<?php } ?>
        											<button type="button" id="select_hd_submit">SUBMIT</button>
											    </form>
											</ul>
										</li>
										
									</ul>
								</div>
								<!-- /.navbar-collapse -->
							</div>
        </div>
        </div>
		
        <div class="row">
        <div class="col-md-12">
		<?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption margin-right-10">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">ALL</span>
							</div> 
							<div class="caption">
								<form>
    								<input type="button" name="date_selection" class="btn btn-xs green date_selection" value="<?php echo $qystday; ?>" /> 
    								<input type="button" name="date_selection" class="btn btn-xs green date_selection" value="<?php echo $pystday; ?>" /> 
    								<input type="button" name="date_selection" class="btn btn-xs green date_selection" value="<?php echo $ystday; ?>" /> 
    								<input type="button" name="date_selection" id="today_date" class="btn btn-xs green date_selection" value="<?php echo $today; ?>" /> 
    							</form>
							</div>
							<div class="tools">
								<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="user_data">
								<thead>											
									<tr>
									    <th>No.</th>
										<th>Type</th>
										<th>Desk</th>
										<th>Job No.</th>												
										<th>Revision</th> 										
				                        <th>Designer</th>
										<th>Time Left</th>
										<th>Time Sent</th>
										<th>Time Taken</th>
										<th>PDF</th>
										<th>Classification</th>
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
        var selected_hd_arr = [];
        var selected_date = $.datepicker.formatDate('yy-mm-dd', new Date()); 
        //initially set today date button selected
        $('#today_date').removeClass('green');
        $('#today_date').addClass('blue');
        
        <?php 
            if(isset($_SESSION['helpDesks']) && !empty($_SESSION['helpDesks'])){
                //foreach($_SESSION['helpDesks'] as $row){
        ?>
                selected_hd_arr = <?php echo json_encode($_SESSION['helpDesks']); ?>; 
                
        <?php  }  //} ?>
        
        //Load DataTable According to date selected
        $('.date_selection').click(function(){  
           var selected_date = $(this).val(); //alert(selected_date);
           
           reloadDataTable(selected_date);
           
           //change color of date button selected
               $('.date_selection').removeClass('blue');
               $('.date_selection').addClass('green');
               $(this).removeClass('green');
                $(this).addClass('blue');
           
        });
        
        //Load DataTable According to multiple help desk selected
        $('#select_hd_submit').click(function(){
            
            reloadDataTable(selected_date);
            
             $('.date_selection').each(function(){
                var dd = $(this).val(); //console.log(dd +''+ selected_date);
                if(dd == selected_date){
                    console.log('selected date : '+selected_date);
                    //change color of date button selected
                    
                    $('.date_selection').removeClass('blue');
                    $('.date_selection').addClass('green');
                    $(this).removeClass('green');
                    $(this).addClass('blue');
                }
            });
        });
        
        function reloadDataTable(selected_date = ''){
            var total_hd_seleted = $("#select_hd").find('input[name="helpDesks[]"]:checked').length; //alert(total_hd_seleted);
            
            if(total_hd_seleted > 0){
                selected_hd_arr = $.map($('input[name="helpDesks[]"]:checked'), function(c){return c.value; });
            }else{
                selected_hd_arr = [];
            }
            
            dataTable.ajax.url("<?php echo base_url().index_page().'new_csr/home/frontlinetrack_new_content'; ?>?helpDesks[]=" + selected_hd_arr+"&date_selection=" + selected_date).load();
            
            //console.log(selected_hd_arr);
           //vidn vidn_rev_entries function link
            /*if(selected_hd_arr.includes('12') == true){
               $('#vidn_link').removeAttr('style');
               $('#vidn_link').attr('style','display: block !important');
            }*/
           //if selected help desk is metro enable metro search tab
            if(selected_hd_arr.includes('2') == true){
               $('#metro_search_tab').removeAttr('style');
               $('#metro_search_tab').attr('style','display: block !important');
            }
        }
        
        //load table data
          var dataTable = $('#user_data').DataTable({  
               "processing":true,  
               "serverSide":true,  
               "order":[],  
               "ajax":{  
                    url:"<?php echo base_url().index_page().'new_csr/home/frontlinetrack_new_content'; ?>?helpDesks[]=" + selected_hd_arr,  
                    type:"GET",
                    /*'data': {
                              // helpDesks: selected_hd_arr,
                               datedata: '2022-01-09'
                            }*/
               },
               "columnDefs":[  
                    {  
                         "targets":[0,1],  
                         "orderable":false,  
                    },  
               ],
               "aoColumns": [
                    null,
                    null,
                    null,
                    { "sClass": "word-wrap-name" },
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ]
          }); 
       /*   
        setInterval( function () {
            dataTable.ajax.reload();
        }, 120000 ); //for every 2mins
        */
        
    });
    
    
    
</script>