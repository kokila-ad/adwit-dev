<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>

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
						</tr>  									
					</thead>
					
					<tbody>
					<?php 
					foreach($mycredits_history as $row){ 
						$purpose = $this->db->get_where('lite_credits_purpose', array('id' => $row['purpose']))->row_array();
					?>
						<tr>
							<td><?php $date = strtotime($row['timestamp']); echo date('M d, Y', $date); ?></td>
							<td><?php echo $row['credits_debited']; ?></td>
							<td><?php echo $row['credits_credited']; ?></td>
							<td><?php echo $purpose['name']; ?></td>							
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
<?php $this->load->view("lite/footer.php"); ?>
<?php $this->load->view("lite/foot.php"); ?>
 