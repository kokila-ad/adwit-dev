<?php $this->load->view('new_csr/head');?>


<div class="page-container">
 <div class="page-content">
		<div class="container">
        <div class="row">
		<div class="portlet light">

							<table class="table table-scrollable table-striped table-hover" border="1">
							<thead>
							<tr>
								<th>Id	</th>
								<th>Adrep</th>
								<th>Subject</th>
								<th>Status</th>
								<th>View</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($request as $row)
								{
							?>
							<tr>
								  					    		      													   		       
								<td><?php echo $row['id']; ?></td>
								<td><?php $adrep = $this->db->get_where('adreps',array('id' => $row['adrep_id']))->result_array();
								echo $adrep[0]['first_name']; ?></td>
								<td><?php echo $row['subject']; ?></td>
								<td><?php $status = $this->db->get_where('requests_status',array('id' => $row['status']))->result_array();
									echo $status[0]['name'];?></td>
								<td><a href="<?php echo base_url().index_page().'new_csr/home/request_details/'.$row['id'];?>">View</a></td>
							</tr>
							
								<?php } ?>
							
							</tbody>
							</table> 

</div>
</div>
</div>
</div>
</div>

<?php $this->load->view('new_csr/foot');?>