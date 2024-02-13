<?php $this->load->view('new_admin/header.php'); ?>



<script>

$(document).ready(function(){	    

	$(".dropdown-checkboxes").hide();	

	$('.date-picker').click(function() {

		$(".cursor-pointer").addClass(" filter ");

	});	

	$('#filter').click(function() {

		$(".dropdown-checkboxes").toggle();

	});	

});

</script>





<!-- BEGIN PAGE CONTAINER -->



<div class="portlet light">

	<div class="portlet-title">

	<div class="row">

		
		<div>

			<?php if(null != $this->session->flashdata('message')){ ?>						

			<div class="alert alert-success padding-5 small margin-bottom-5 text-right"><?php echo '<span style="text-align: left;margin:0;">'.$this->session->flashdata('message').'</span>'; ?></div>

		<?php } ?>

		</div>


	</div>



	</div>

	<div class="portlet-body " >

		<div>

			<table class="table table-bordered table-hover" id="sample_6"> 

				<thead>					

					<tr>

						<th>Order Id</th>
						
						<th>Start Time</th>

						<th>End Time</th>
						
						<th>Time Taken(in mins)</th>

					</tr>

				</thead>

				<tbody> 

				<?php 
					//$des_id = $designer['id'];
					foreach($design_time as $row2){
				?>		
					<tr>
						<td><?php echo $row2['order_id']; ?></td><!--order_id-->

						<td><?php echo $row2['start_time']; ?></td><!--start_time-->
						
						<td><?php echo $row2['end_date'].' '.$row2['end_time']; ?></td><!--end_date&end_time-->

						<td><?php echo $row2['time_taken']; ?></td><!--time_taken-->

					</tr>
				<?php } ?>

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

