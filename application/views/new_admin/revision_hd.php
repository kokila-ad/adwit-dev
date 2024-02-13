<?php $this->load->view('new_admin/header.php'); ?>

<style>
.tabletools-btn-group {
    margin: 0 0 10px 0;
    display: none;
}
.tabletools-dropdown-on-portlet > .btn:last-child {
    margin-right: 0;
    display: none;
}
</style>

<div class="page-content">
	<div class="container">

		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-grey-sharp bold">Revision Version Details </span>
				</div>
				<div class="actions btn-set">
					<span class=" cursor-pointer right"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>
			</div>
		</div>
	<div class="row">
			<div class="col-sm-6 ">
				<div class="portlet light">
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover " id="sample_6">
						<thead>
						<tr>
							<th>Version</th>
							<th>Count</th>
							
						</tr>
						</thead>
						<tbody>
							<tr>
								<th>V1a</th>
								<td><?php if(isset($rev_v1a)){echo count($rev_v1a);}?></td>
							</tr>
							<tr>
								<th>V1b</th>
								<td><?php if(isset($rev_v1b)){echo count($rev_v1b);}?></td>
							</tr>
							<tr>
								<th>V1c</th>
								<td><?php if(isset($rev_v1c)){echo count($rev_v1c);}?></td>
							</tr>
							<tr>
								<th>V1d</th>
								<td><?php if(isset($rev_v1d)){echo count($rev_v1d);}?></td>
							</tr>
							<tr>
								<th>V1e</th>
								<td><?php if(isset($rev_v1e)){echo count($rev_v1e);}?></td>
							</tr>
							<tr>
								<th>V1f</th>
								<td><?php if(isset($rev_v1f)){echo count($rev_v1f);}?></td>
							</tr>
							<tr>
								<th>V1g</th>
								<td><?php if(isset($rev_v1g)){echo count($rev_v1g);}?></td>
							</tr>
							<tr>
								<th>V1h</th>
								<td><?php if(isset($rev_v1h)){echo count($rev_v1h);}?></td>
							</tr>
							<tr>
								<th>V1i</th>
								<td><?php if(isset($rev_v1i)){echo count($rev_v1i);}?></td>
							</tr>
							<tr>
								<th>V1j</th>
								<td><?php if(isset($rev_v1j)){echo count($rev_v1j);}?></td>
							</tr>
							<tr>
								<th>V1k</th>
								<td><?php if(isset($rev_v1k)){echo count($rev_v1k);}?></td>
							</tr>
							<tr>
								<th>V1l</th>
								<td><?php if(isset($rev_v1l)){echo count($rev_v1l);}?></td>
							</tr>
							<tr>
								<th>V1m</th>
								<td><?php if(isset($rev_v1m)){echo count($rev_v1m);}?></td>
							</tr>
							<tr>
								<th>V1n</th>
								<td><?php if(isset($rev_v1n)){echo count($rev_v1n);}?></td>
							</tr>
							<tr>
								<th>V1o</th>
								<td><?php if(isset($rev_v1o)){echo count($rev_v1o);}?></td>
							</tr>
							<tr>
								<th>V1p</th>
								<td><?php if(isset($rev_v1p)){echo count($rev_v1p);}?></td>
							</tr>
							<tr>
								<th>V1q</th>
								<td><?php if(isset($rev_v1q)){echo count($rev_v1q);}?></td>
							</tr>
							<tr>
								<th>V1r</th>
								<td><?php if(isset($rev_v1r)){echo count($rev_v1r);}?></td>
							</tr>
							<tr>
								<th>V1s</th>
								<td><?php if(isset($rev_v1s)){echo count($rev_v1s);}?></td>
							</tr>
							<tr>
								<th>V1t</th>
								<td><?php if(isset($rev_v1t)){echo count($rev_v1t);}?></td>
							</tr>
							<tr>
								<th>V1u</th>
								<td><?php if(isset($rev_v1u)){echo count($rev_v1u);}?></td>
							</tr>
							<tr>
								<th>V1v</th>
								<td><?php if(isset($rev_v1v)){echo count($rev_v1v);}?></td>
							</tr>
							<tr>
								<th>V1w</th>
								<td><?php if(isset($rev_v1w)){echo count($rev_v1w);}?></td>
							</tr>
							<tr>
								<th>V1x</th>
								<td><?php if(isset($rev_v1x)){echo count($rev_v1x);}?></td>
							</tr>
							<tr>
								<th>V1y</th>
								<td><?php if(isset($rev_v1y)){echo count($rev_v1y);}?></td>
							</tr>
							<tr>
								<th>V1z</th>
								<td><?php if(isset($rev_v1z)){echo count($rev_v1z);}?></td>
							</tr>
						
						</tbody>
						
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php');?>
