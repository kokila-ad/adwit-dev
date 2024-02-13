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
.bg-grey-gallery{
	border-radius:4px !important;
}
</style>
 <script>  
       
        	function showhide() 
        {  
            var div = document.getElementById("newpost");  
            if (div.style.display !== "none") {  
                div.style.display = "none";  
            }  
            else {  
                div.style.display = "block";  
            }  
        }  	
    </script>  
	<script>
    var divs = ["Menu1", "Menu2", "Menu3"];
    var visibleDivId = null;
    function toggleVisibility(divId) {
      if(visibleDivId === divId) {
        //visibleDivId = null;
      } else {
        visibleDivId = divId;
      }
      hideNonVisibleDivs();
    }
    function hideNonVisibleDivs() {
      var i, divId, div;
      for(i = 0; i < divs.length; i++) {
        divId = divs[i];
        div = document.getElementById(divId);
        if(visibleDivId === divId) {
          div.style.display = "block";
        } else {
          div.style.display = "none";
        }
      }
    }
</script>
	

<section>
   <div class="page-content">
	<div class="container">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject font-grey-sharp bold ">Revision Reason : <?php if(isset($from) && isset($to)){echo $from." to ".$to;}elseif(isset($today)){echo $today;} ?>  </span>
			</div>
		</div>
	</div>
	<div class="row">
		<form class="form-horizontal" method="get">
			<div class="col-sm-6 col-md-6 col-xs-12 margin-bottom-25 col-md-offset-4">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-xs-12 input-group input-large date-picker input-daterange" data-date="2017-07-10" data-date-format="yyyy-mm-dd">
					<span class="input-group-addon">From </span>
					<input type="text" class="form-control" name="from_date" value="<?php if(isset($from))echo $from; ?>" placeholder="YYYY-MM-DD" required>
					<span class="input-group-addon">to </span>
					<input type="text" class="form-control" id="datepicker"  name="to_date" value="<?php if(isset($to))echo $to; ?>" placeholder="YYYY-MM-DD" required>
				</div>
				<div class="col-sm-6 col-md-6 col-xs-12 margin-top-5">
				<select name="publication_id" class="select2me form-control margin-bottom-10">
					<option value="">SELECT Publication</option>
					<?php foreach($publications as $pub){ ?>
						<option value="<?php echo $pub['id'] ?>" <?php if(isset($_GET['publication_id']) && $_GET['publication_id'] == $pub['id'])echo"selected"; ?>> 
						<?php echo $pub['name'] ?> 
						</option>
					<?php } ?>
					<option value="">ALL</option>
				</select>
				</div>
			</div>	
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4  margin-top-15 margin-bottom-25" id="newpost">
				<button type="submit" name="total_count" class="btn bg-grey-gallery" >Total Count</button>
				<button type="submit" name="designer_count" class="btn bg-grey-gallery"  onclick="toggleVisibility('Menu2');">Designer Count</button>
				<button type="submit" name="csr_count" class="btn bg-grey-gallery"  onclick="toggleVisibility('Menu3');">CSR's Count</button>
			</div>
		</form>	
		<?php if(isset($total_count) && isset($from) && isset($to)){ ?>
		<div class="col-sm-12 margin-top-15 ">
			<div class="col-sm-12" >
				<table class="table table-striped table-bordered table-hover" id="sample_6">
				<thead>
				<tr>
					<th hidden>Id</th>
					<th>Reason Name</th>
					<th>Count</th>
				</tr>
				</thead>
				<tbody>
				<?php if(isset($reason_name)){
					foreach($reason_name as $row){
						if(isset($pub_id)){
							$query = "SELECT rev_order_reason.* FROM `rev_order_reason` 
									JOIN orders ON rev_order_reason.order_id = orders.id
										WHERE orders.publication_id = '$pub_id' AND rev_order_reason.reason_id = '".$row['id']."' AND (rev_order_reason.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
							$reason_count = $this->db->query("$query")->num_rows();
							$url = $row['id'].'/'.$from.'/'.$to.'/'.$pub_id;
						}else{
							$reason_count = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '".$row['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							$url = $row['id'].'/'.$from.'/'.$to;
						}
						
					
				?>
					<tr class="odd gradeX">
						<td hidden><?php echo $row['id'];?></td>
						<td><?php echo $row['name'];?></td>
						<td><a href="<?php echo base_url().index_page().'new_admin/home/revision_reason_details/'.$url; ?>"><?php echo $reason_count;?></a></td>
					</tr>
				<?php } }?>
				</tbody>
				</table>
			</div>
		</div> 
		<?php } ?>
		
		<?php if(isset($designer_count) && isset($from) && isset($to)){ ?>
		<div class="col-sm-12 margin-top-15" >
			<div class="col-sm-12" >
			<table class="table table-striped table-bordered table-hover" id="sample_2">
			<thead>
			<tr>
				<th>Designer Name</th>
				<th>New Picture</th>
				<th>New Size</th>
				<th>Correction</th>
				<th>New Text</th>
				<th>Changes</th>
			</tr>
			</thead>
			<tbody>
					<?php if(isset($designer_name)){
						foreach($designer_name as $row1){
						if(isset($pub_id)){
							$query = "SELECT rev_order_reason.* FROM `rev_order_reason`
										JOIN orders ON rev_order_reason.order_id = orders.id
										WHERE orders.publication_id = '$pub_id' AND rev_order_reason.designer = '".$row1['id']."' AND (rev_order_reason.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
							
							$designer_count1= $this->db->query("$query AND rev_order_reason.reason_id = '1'")->num_rows();
							$designer_count2= $this->db->query("$query AND rev_order_reason.reason_id = '2'")->num_rows();
							$designer_count3= $this->db->query("$query AND rev_order_reason.reason_id = '3'")->num_rows();
							$designer_count4= $this->db->query("$query AND rev_order_reason.reason_id = '4'")->num_rows();
							$designer_count5= $this->db->query("$query AND rev_order_reason.reason_id = '5'")->num_rows();
						}else{
							$designer_count1= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '1' AND designer = '".$row1['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							$designer_count2= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '2' AND designer = '".$row1['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							$designer_count3= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '3' AND designer = '".$row1['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							$designer_count4= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '4' AND designer = '".$row1['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							$designer_count5= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '5' AND designer = '".$row1['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
						}
					?>
				<tr class="odd gradeX">
					<td><?php echo $row1['name'];?></td>
					<td><?php echo $designer_count1;?></td>
					<td><?php echo $designer_count2;?></td>
					<td><?php echo $designer_count3;?></td>
					<td><?php echo $designer_count4;?></td>
					<td><?php echo $designer_count5;?></td>
				</tr>
					<?php } }?>
			</tbody>
			</table>
			</div>
		</div> 
		<?php } ?>
		
			<?php if(isset($csr_count) && isset($from) && isset($to)){ ?>
		<div class="col-sm-12 margin-top-15" >
			<div class="col-sm-12">
			<table class="table table-striped table-bordered table-hover" id="sample_1">
			<thead>
			<tr>
				<th>CSR Name</th>
				<th>New Picture</th>
				<th>New Size</th>
				<th>Correction</th>
				<th>New Text</th>
				<th>Changes</th>
			</tr>
			</thead>
			<tbody>
					<?php if(isset($csr_name)){
						foreach($csr_name as $row2){
							if(isset($pub_id)){
								$query = "SELECT rev_order_reason.* FROM `rev_order_reason`
										JOIN orders ON rev_order_reason.order_id = orders.id
										WHERE orders.publication_id = '$pub_id' AND rev_order_reason.csr = '".$row2['id']."' AND (rev_order_reason.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
								$csr_count1= $this->db->query("$query AND rev_order_reason.reason_id = '1'")->num_rows();
								$csr_count2= $this->db->query("$query AND rev_order_reason.reason_id = '2'")->num_rows();
								$csr_count3= $this->db->query("$query AND rev_order_reason.reason_id = '3'")->num_rows();
								$csr_count4= $this->db->query("$query AND rev_order_reason.reason_id = '4'")->num_rows();
								$csr_count5= $this->db->query("$query AND rev_order_reason.reason_id = '5'")->num_rows();		
							}else{
								$csr_count1= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '1' AND `csr` = '".$row2['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
								$csr_count2= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '2' AND `csr` = '".$row2['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
								$csr_count3= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '3' AND `csr` = '".$row2['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
								$csr_count4= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '4' AND `csr` = '".$row2['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
								$csr_count5= $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '5' AND `csr` = '".$row2['id']."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->num_rows();
							}
							
					?>
				<tr class="odd gradeX">
					<td><?php echo $row2['name'];?></td>
					<td><?php echo $csr_count1;?></td>
					<td><?php echo $csr_count2;?></td>
					<td><?php echo $csr_count3;?></td>
					<td><?php echo $csr_count4;?></td>
					<td><?php echo $csr_count5;?></td>
				</tr>
					<?php } }?>
			</tbody>
			</table>
			</div>
		</div> 
		<?php } ?>
	</div>
</div>
</div>	
</section>

<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php');?>
