<?php $this->load->view('new_admin/header.php'); ?>
<style>
.tabletools-btn-group {
		display: none !important;
}
.word-wrap-name{
	max-width: 250px;
	word-wrap: break-word;
}
.btn-xxs{
	padding: 5px;
	font-size: 12px;
	line-height: .8;
}
.no-border{
	border: 0px !important;
}
.btn-xs {
    margin-bottom: 5px;
}
#myDIV{
  display: none;
}
</style>		
<script type="text/javascript">

function myFunction() { 
var x = document.getElementById('myDIV');
    if (x.style.display === 'block') {
        x.style.display = 'none';
    } else {
        x.style.display = 'block';
    }
}
</script>
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-16">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption ">
								
									<button  onclick="myFunction()" class="btn btn-md grey" >Adreps</button>
								
							</div>
						</div>
						<div class="portlet-body no-space" id="myDIV">						
							<table class="table table-bordered table-hover" id="sample_6">
								<thead>											
									<tr>
										<th>Adrep Name</th>				
										<th>Email ID</th>
										<th>Publication Name </th>	
									</tr>
								</thead> 
								<tbody>	
								<?php foreach($adreps as $row){
										$publication_name = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
								?>
									<tr>
										<td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
										<td><?php echo $row['email_id'];?></td>
										<td><?php if($row['publication_id']!='0'){echo $publication_name[0]['name'];}?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>	
		</div>
  </div>
</div>

	

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>