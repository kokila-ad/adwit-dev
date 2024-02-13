<?php $this->load->view("new_csr/head.php"); ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>    

<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
            <div class="row">
                <div class="col-md-12">
		        <?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="tools">
								<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
								<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
						</div>
						<div class="portlet-body">
				
						    <table class="table table-striped table-bordered table-hover" id="sample_6">
							    <thead>											
								    <tr>
									    <th style="vertical-align: middle;">DATE</th>
									    <th style="vertical-align: middle;">ADWIT ID</th>
									    <th style="vertical-align: middle;">CATEGORY</th>
										<th style="vertical-align: middle;">ACTION</th>
                					    <th style="vertical-align: middle;">SUBJECT LINE</th>
                						<th style="vertical-align: middle;">ADREP REPLY</th>
                						<th style="vertical-align: middle;">CLUB</th>
                						<th style="vertical-align: middle;">ADREP EMAIL</th>
                						<th style="vertical-align: middle;">ADWIT EMAIL</th>
                				    </tr> 
								</thead> 
											
								<tbody name="testTable" id="testTable">	
                                <?php
                                    if(isset($order_mail_draft)){
                                	    foreach($order_mail_draft as $row){
                                ?>										
                							<tr>
                							    <td><?php $date = strtotime($row['CREATED_ON']); echo date('d-M', $date); ?></td>
                							    <td><?php echo $row['ORDER_ID']; ?></td>
                							    <td><?php echo $row['CATEGORY']; ?></td>
                							    <td><?php echo $row['ACTION']; ?></td>
                							    <td><?php echo $row['SUBJECT_LINE']; ?></td>
                							    <td><?php echo $row['ADREP_REPLY']; ?></td>
                							    <td><?php echo $row['name']; ?></td>
                							    <td><?php echo $row['ADREP_EMAIL']; ?></td>
                							    <td><?php echo $row['ADWIT_EMAIL']; ?></td>
                							</tr>
                    <?php  } } ?>											
										</tbody>
									</table>
							
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
 <?php $this->load->view("new_csr/foot.php"); ?> 
