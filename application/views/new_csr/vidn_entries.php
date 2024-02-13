<?php $this->load->view('new_csr/head'); ?>

<div class="row">
    <div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('sucess_message'); ?>	
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
				<div class="tools no-space">
					<button class="btn bg-grey btn-sm"><i class="fa fa-file-excel-o"></i> Excel</button>
					<button onclick="printPage()" class="btn bg-grey btn-sm"><i class="fa fa-print"></i> Print</button>
					<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()">
					</a>
				</div>
			</div>
			<div class="portlet-body">
			<!-- Revision -->
			<?php if($type=='revision'){ ?>
				<table class="table table-striped table-bordered table-hover" id="sample_6"> 
					<thead>
					<tr>
						<th style="vertical-align: middle;">Type</th>
						<th style="vertical-align: middle;">adrep</th>
						<th style="vertical-align: middle;">Job Name</th>
						<th style="vertical-align: middle;">Edit</th>
					</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
					<?php foreach($vidn_entries as $row){ ?>
					<tr>
						<td><?php echo $row['vidn_type']; ?></td>
						<td><?php echo $row['adrep_id']; ?></td>
						<td><?php echo $row['job_no']; ?></td>
						<td> 
							<a href="<?php echo base_url().index_page().'new_csr/home/vidn_revad_form/'.$row['id']; ?>"><button>Edit</button></a>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php }else{ ?>
			<!-- New -->
				<table class="table table-striped table-bordered table-hover" id="sample_6"> 
					<thead>
					<tr>
						<th style="vertical-align: middle;">Type</th>
						<th style="vertical-align: middle;">adrep</th>
						<th style="vertical-align: middle;">Job Name</th>
						<th style="vertical-align: middle;">Edit</th>
					</tr>              
					</thead>
					<tbody name="testTable" id="testTable">
					<?php foreach($vidn_entries as $row){ ?>
					<tr>
						<td><?php echo $row['vidn_type']; ?></td>
						<td><?php echo $row['adrep_id']; ?></td>
						<td><?php echo $row['job_no']; ?></td>
						<td>
							<a href="<?php echo base_url().index_page().'new_csr/home/vidn_newad_form/'.$row['id']; ?>"><button>Edit</button></a>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				
			<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('new_csr/foot'); ?>