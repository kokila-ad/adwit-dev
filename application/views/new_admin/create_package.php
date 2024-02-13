<?php $this->load->view('new_admin/header')?>



<style>

	input[type="text"] { border: 0 !important;}

</style>



<!--<script type="text/javascript">

	$(document).ready(function(){

		$("#save_data").hide();	

		$('#form_data').click(function() {

			$("#save_data").show();

		});

	});		

</script>-->

<div class="col-md-12">



	<div class="portlet light">

		<div class="portlet-title">

			<div class="row">	

				<div class="col-md-6 col-xs-8 margin-bottom-10">

					<p class="font-lg">Lite Packages</p>

				</div>

				

				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	

					<?php if(null != $this->session->flashdata('message')){ ?>						

						<span class="alert alert-success margin-0 padding-5 small"><?php echo $this->session->flashdata('message'); ?></span>

					<?php } ?>

					<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>	

					<!--<button type="submit" class="btn btn-primary btn-xs" name="Save" id="save_data">Save</button>-->

					<!--<span class="btn bg-grey btn-xs" onclick="tableToExcel('tab-data', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</span>-->

				</div>

			</div>

		</div>

		<div class="portlet-body">

			<t	able class="table table-bordered table-hover" id="tab-data">

			<thead>

				<tr>

					<th>Name</th>

					<th>Min Price</th>

					<th>Max Price</th>

					<th>No.Of Days To Expire</th>

					<th>Discount(%)</th>

					<th>Action</th>

				</tr>

			</thead>

			<tbody id="form_data">

			<?php if(isset($lite_package)){?>

				<?php foreach($lite_package as $row){ ?>

				<form method="post" name="order_form" id="order_form">

				<tr>

					<td><?php echo $row['name']; ?></td>

					<td><input type="text" value="<?php echo $row['min_price']; ?>" name="min_price" class="form-control"></td>

					<td><input type="text" value="<?php echo $row['max_price']; ?>" name="max_price" class="form-control"></td>

					<td><input type="text" value="<?php echo $row['num_days']; ?>"  name="num_days" class="form-control"></td>

					<td><input type="text" value="<?php echo $row['discount']; ?>" name="discount" class="form-control"></td>

					<input type="hidden" value="<?php echo $row['id']; ?>" name="id">

					<td><button type="submit" class="btn btn-primary btn-xs" name="Save" id="save_data">Save</button></td>

				</tr>

				</form>

				<?php } } ?>

			</tbody>

			</table>

		</div>

	</div>



</div>

		





<?php $this->load->view('new_admin/footer')?>

<?php $this->load->view('new_admin/datatable')?>
