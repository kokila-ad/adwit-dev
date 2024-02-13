<?php 

	$this->load->view("new_designer/head");

?>
<div class="row">

        <div class="col-md-12">

					<div class="portlet light">

						<div class="portlet-title">

							<div class="caption">

								<span class="caption-subject font-green-sharp bold uppercase">Job List (latest 3days job)</span>

							</div>

							<div class="tools">

							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>

							</div>

						</div>

						<div class="portlet-body">

						  <table class="table table-striped table-bordered table-hover" id="sample_6">

							<thead>
											<tr>
												<th style="width:75px;">Date</th>
												<th>Order Id</th>
												<th>Job Name</th>
												<th>Width</th>
                                                <th>Height</th>
												<!--<th>category</th>-->
											</tr>
							</thead>
							<tbody name="testTable" id="testTable">
<?php foreach($orders as $row)	
		{?>									
											<tr class="odd gradeX">
												<td><?php echo date('Y-m-d',strtotime($row['created_on'])); ?></td>
												<td><?php echo $row['id']; ?></td>
												<td><?php echo $row['job_no']; ?></td>
												<td class="center"> <?php echo $row['width']; ?></td>
                                                <td class="center"> <?php echo $row['height']; ?></td>
												<!--<td class="center"><?php echo $row['category']; ?></td>-->
											</tr>
<?php }?>											
										</tbody>
	


						</table>

						</div>

					</div>

				</div>

        </div>
<?php 

	$this->load->view("new_designer/foot");

?>
