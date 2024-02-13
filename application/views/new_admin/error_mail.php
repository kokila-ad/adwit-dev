<html>
<head>
<style>
.table-bordered {
    border: 1px solid #ddd;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
     text-align:center;
}
.table thead tr th {
    font-size: 14px;
    font-weight: 600;
    
}
.table-striped>tbody>tr:nth-child(odd) {
    background-color: #f9f9f9;
  
}
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #ddd;
}
</style>
    </head>
    <body>


	<div class="portlet-body">	
	<form method ="POST" id= "demo"> 
		<table class="table table-striped table-bordered table-hover ">
			<thead>
				<tr>
					<th>AdwitAds ID</th>
					<th>Publication</th>
					<th>AdRep</th>
					<th><?php echo $prev_ver; ?> - Details </th> 
					
					<th>Feedback </th>
					
				</tr>
			</thead>
			<tbody>
				<td><?php echo $order_id; ?></td>
				<td><?php if(isset($publication_name['name'])){echo $publication_name['name'];}else {echo '';}?></td>
				<td>
					<?php if(isset($adrep_name['first_name'])){echo $adrep_name['first_name'];}else {echo '';}
						  if(isset($adrep_name['last_name'])){ echo ' '.$adrep_name['last_name'];}else {echo '';}?>
				</td>
				<td>
				<table class="table table-striped table-bordered table-hover ">
				<thead>
				<tr>
					<th>Designer </th>
					<th>Designer Team Lead </th>
					<th>Proof Reader </th>
					<th>Rov Check</th>
					<th>Hybrid Designer</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td><?php if(isset($designer_name['name'])){echo $designer_name['name'];}else{echo'';} ?></td>
				<td><?php if(isset($designer_tl_name['name'])){echo $designer_tl_name['name'];}else{echo'';} ?></td>
				<td><?php if(isset($csr_name['name'])){echo $csr_name['name'];}else{echo'' ;} ?></td>
				<td><?php if(isset($rov_csr['name'])){echo $rov_csr['name'];}else{echo'' ;}  ?></td>
				<td><?php if(isset($hi_b_designer_name['name'])){echo $hi_b_designer_name['name'];}else{echo'' ;}  ?></td>
				</tr>
				</tbody>
				</table>
				</td> 
				<td><?php echo $note; ?></td>
				
			</tbody>		
			</table>
			</form>
			</div>
	
</div>


<script>
$(document).ready(function() {
    $("#demo").on('submit',function(){
		var c = $('.verification_type:checked').length;
		if(c > 0){
			return true;
		}else{
			alert("Check Atleast One Verification Type..!!");
			return false;
		}
     });
});
</script>
   </body>
</html>