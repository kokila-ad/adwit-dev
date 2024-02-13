<?php $this->load->view('new_admin/header')?>
<div id="main">

<section>
<div class="container margin-top-50">
	<div class="row">
		<div class="col-md-7">
				<p><a href="" class="text-blu">My Credit History</a></p>
		</div>
		<div class="col-md-12 margin-top-20">
			<div class="table-responsive border padding-15">     
				<table class="table table-striped table-bordered table-hover" id="example1">
					<thead>
						<tr>
							<td>Date</td>
							<td>Credits Purchased </td>
							<td>Credits Used</td>
							<td>Description</td>							
							<td>Expiry Date</td>
							
						</tr>  									
					</thead>
					
					<tbody>
					<?php 
					foreach($mycredits_history as $row){ 
						$purpose = $this->db->get_where('lite_credits_purpose', array('id' => $row['purpose']))->row_array();						
						//$expire_on = $this->db->get_where('lite_credits_added', array('id' => $row['credits_added_id']))->row_array();
						$expire_on = $this->db->query("SELECT `expiry` FROM `lite_credits_added` WHERE `id` = '".$row['credits_added_id']."'")->row_array();
					?>
						<tr>
							<td><?php $date = strtotime($row['timestamp']); echo date('M d, Y', $date); ?></td>
							<td><?php echo $row['credits_debited']; ?></td>
							<td><?php echo $row['credits_credited']; ?></td>
							<td><?php echo $purpose['name']; ?></td>

							<td><?php if(isset($expire_on['expiry'])) echo $expire_on['expiry']; ?></td>
						</tr>
					<?php } ?>	
				   </tbody>  
				</table>
			</div>
		</div>
	 </div>
  </div>
</section>
 
</div>
	
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>			
<?php $this->load->view('new_admin/footer')?>