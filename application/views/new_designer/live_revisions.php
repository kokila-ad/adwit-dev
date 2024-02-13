<?php
       $this->load->view("new_designer/head"); 
?>
<!-- END HEADER -->

<script>
setTimeout(function(){
   window.location.reload(1);
}, 50000);
</script>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
		<div class="container">
        <?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>';?>
            <div class="row">
                <div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">Revision Ads</span>
							</div>
							<div class="tools">
							<button class="btn bg-grey btn-sm" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Excel</button>
							<a href="javascript:;" class="reload" data-original-title="" onclick="myFunction()"></a>
							</div>
							
						</div>
						<div class="portlet-body">
				        <table class="table table-striped table-bordered table-hover" id="sample_6">
							<thead>
							<tr>
								<th>No</th>
								<th>Order Id</th>
								<th>Previous Slug</th>
								<th>Designer</th>
								<th>Classification</th>
							</tr>
							</thead>
			<tbody name="testTable" id="testTable">
			<?php	$i=0;
					foreach($orders_rev as $row){ $i--;
					$designer = $this->db->get_where('designers',array('id'=>$row['designer']))->result_array();
					if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
			?>
             <tr <?php if($row['rush']=='0'){ echo'class="odd gradeX"'; }else{ echo'class="bg-red-pink"'; } ?>>
                <td><?php echo $i; ?></td>			
				<td><?php echo $row['order_id']; ?></td>
				<td><?php if($row['rush']==1){ echo "class='font-grey-cararra'";} ?><?php echo $row['order_no']; ?></td>
				<?php if($row['new_slug']=='none' && $designers[0]['designer_role'] != '2') { ?>
				<td><?php if($row['	category'] == 'sold'){ ?>
					<a><input type="button" value="Upload" /></a><?php }else{ ?>
					<form name="myform" method="post" onsubmit="return confirm('Do you really want to submit?');">
						<button type="submit" name="create_slug" class="btn bg-green">Create Slug</button>
						<input name="order_id" value="<?php echo $row['order_id'];?>" readonly style="display:none;" />
					</form>
					<?php } ?>
				</td>
				<?php }else{ ?>
				<td><a <?php if($row['designer']!='0')?>><?php echo $designer[0]['username'] ; ?></a></td>
				<?php } ?>
				<td><?php if($row['classification']!='0'){ echo $rev_classification['name']; } ?></td>
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
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->



<!-- BEGIN FOOTER -->
<?php
       $this->load->view("new_designer/foot"); 
?>