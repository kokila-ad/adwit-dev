<?php $this->load->view('new_admin/header')?>

<script>
	 $(document).ready(function(){
	  $('#submit_form').hide();
	  
	  $("#form").click(function(){$("#submit_form").show(); }); 
	  
	  $("#add_pub").click(function(){ $("#add_pub_form").css("display", "block"); });
	  $("#add_csr").click(function(){ $("#add_csr_form").css("display", "block"); });
	  $("#add_designer").click(function(){ $("#add_designer_form").css("display", "block"); });
	  
	  $("#add_pub_click").click(function(){
		var user_type = 'publications';
		var user_id = $("#pub_id").val(); //alert("pub_id - "+pub_id);
		if(user_id != ''){ ajax_call(user_type, user_id); }
		return true;		
	  });
	  
	  $("#add_csr_click").click(function(){
		var user_type = 'csr';
		var user_id = $("#csr_id").val(); //alert("pub_id - "+pub_id);
		if(user_id != ''){ ajax_call(user_type, user_id); }
		return true;		
	  });
	  
	  $("#add_designer_click").click(function(){
		var user_type = 'designers';
		var user_id = $("#designer_id").val(); //alert("pub_id - "+pub_id);
		if(user_id != ''){ ajax_call(user_type, user_id); }
		return true;		
	  });
	  
	  function ajax_call(user_type, user_id){
		  var id = <?php echo $id; ?>;
			
				$.ajax({
					url:  "<?php echo base_url().index_page();?>new_admin/home/user_assign_club",
					data: 'club='+id+'&user_type='+user_type+'&id='+user_id,
					type: 'POST',
					success: function(){
						alert("Added");
						window.location.href = "<?php echo base_url().index_page();?>new_admin/home/club/"+id;
					}
				});
			
	  }
	  
	  $(".user_remove").click(function(){ 
	  
		var user_id = $(this).data('user_id'); //alert('Alert : '+x); 
		var user_type = $(this).data('user_type');
		if(user_id != ''){ 
			var r = confirm("Are You Sure??");
			if(r == true){ ajax_remove_call(user_type, user_id); }
		}
		return true;		
	  });
	  
	  function ajax_remove_call(user_type, user_id){
		  var id = <?php echo $id; ?>;
			
				$.ajax({
					url:  "<?php echo base_url().index_page();?>new_admin/home/user_unassign_club",
					data: 'club='+id+'&user_type='+user_type+'&id='+user_id,
					type: 'POST',
					success: function(){
						alert("Removed");
						window.location.href = "<?php echo base_url().index_page();?>new_admin/home/club/"+id;
					}
				});
			
	  }
	  
	  $(".club_delete").click(function(){ 
	   
	        var r = confirm("Are You Sure??");
			if(r == true){ ajax_club_delete(); }
			return false;	
	  });
	  
	  function ajax_club_delete(){
		  var id = <?php echo $id; ?>;
			
				$.ajax({
					url:  "<?php echo base_url().index_page();?>new_admin/home/club_delete/"+id,
					data: 'club='+id,
					type: 'POST',
					success: function(){
						alert("Removed");
						window.location.href = "<?php echo base_url().index_page();?>new_admin/home/club";
					}
				});
	  }
	  
	 });
 </script>
 
 
<?php if($id == ''){?>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="<?php echo base_url().index_page().'new_admin/home/club'?>" class="font-lg font-grey-gallery"><u>Club</u></a>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">
				    <a href="<?php echo base_url().index_page().'new_admin/home/assign_publication_club'; ?>" style="color:#fbf1f1;" class="btn btn-primary">Unassigned Publication</a>
				    <a href="<?php echo base_url().index_page().'new_admin/home/assign_csr_club'; ?>" style="color:#fbf1f1;" class="btn btn-primary">Unassigned Csr</a>
				    <a href="<?php echo base_url().index_page().'new_admin/home/assign_designer_club'; ?>" style="color:#fbf1f1;" class="btn btn-primary">Unassigned Designer</a>
					<form role="form" method="post"> 
					<div class="btn-group left-dropdown">
						<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
				 </form>	
				</div>								
			</div>
		</div>
		<div class="portlet-body">
		<?php /*if(isset($club)){
			$total_count = 0;
			foreach($club as $row){
				$pub_count = $this->db->query("SELECT * FROM `publications` WHERE `club_id` = '".$row['id']."' ;")->num_rows();	
				$total_count = $total_count + $pub_count ;
		}}*/
		?>
			<table class="table table-bordered table-hover" id="sample_6">
			<thead>
				<tr>
					<th>Club Name  - <span class="badge"><?php echo count($club);?></span></a></th>
					<th>No.of Publication</th>
					<th>No.of CSR</th>
					<th>No.of Designer</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if(isset($club)){ 
				foreach($club as $row){
					$pub_count = 0; $csr_count = 0; $designer_count = 0;
					$pub = $this->db->query("SELECT `club_id` FROM `publications` WHERE `club_id` LIKE '%".$row['id']."%' ;")->result_array();
					foreach($pub as $row1){ 
						$club_id_list = explode(',', $row1['club_id']);
						$u_club_id_list = array_unique($club_id_list);
						if(($key = array_search($row['id'], $u_club_id_list)) !== false){
							$pub_count++;
						}
					}
					
					$csr = $this->db->query("SELECT `club_id` FROM `csr` WHERE `club_id` LIKE '%".$row['id']."%' ;")->result_array();
					foreach($csr as $row1){ 
						$club_id_list = explode(',', $row1['club_id']);
						$u_club_id_list = array_unique($club_id_list);
						if(($key = array_search($row['id'], $u_club_id_list)) !== false){
							$csr_count++;
						}
					}
					$designer = $this->db->query("SELECT `club_id` FROM `designers` WHERE `club_id` LIKE '%".$row['id']."%' ;")->result_array();
					foreach($designer as $row1){ 
						$club_id_list = explode(',', $row1['club_id']);
						$u_club_id_list = array_unique($club_id_list);
						if(($key = array_search($row['id'], $u_club_id_list)) !== false){
							$designer_count++;
						}
					}
			?>
				<tr>
					<td><a href="<?php echo base_url().index_page().'new_admin/home/club/'.$row['id']; ?>"><?php echo $row['name'] ;?></a></td>
					<td><?php echo $pub_count;?></td>
					<td><?php echo $csr_count;?></td>
					<td><?php echo $designer_count;?></td>
				</tr>
				
		<?php  } } ?>
			</tbody>
			</table>
		</div>
	</div>
<?php } else {?>
	 <div class="portlet light">
		<div class="portlet-title">
			<div class="row">	
				<div class="col-md-6 col-xs-8 margin-bottom-10">
					<a href="<?php echo base_url().index_page().'new_admin/home/manage'?>" class="font-lg font-grey-gallery">Manage</a> - 
					<a href="<?php echo base_url().index_page().'new_admin/home/club'?>" class="font-lg font-grey-gallery">Club</a> -
					<a href="<?php echo base_url().index_page().'new_admin/home/club'?>" class="font-lg font-grey-gallery">
						<u><?php $cb_name = $this->db->get_where('club',array('id' => $id))->row_array(); echo $cb_name['name'];?></u>
					</a>
					<i class="fa fa-remove club_delete" title="Delete Club" ></i>
				</div>
				<div class="col-md-6 col-xs-4 margin-bottom-10 text-right">	
				<?php if(null != $this->session->flashdata('message')){ ?>						
					<div class="alert alert-success margin-0 padding-5 small"><?php echo '<span style="color:#900;">'.$this->session->flashdata('message').'</span>'; ?></div>
				<?php } ?>
				<form method="post" name="order_form" id="order_form">
				<div class="btn-group left-dropdown">
				<span class=" cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
				</div>
				</form>	
				</div>									
			</div>
		</div>
		<div class="row">
		
			<div class="col-md-4 col-sm-12 margin-bottom-20">
				<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Publication <i id="add_pub" title="Add" class="fa fa-plus" aria-hidden="true"></i></p>
				<div id="add_pub_form" style="display:none;">
					<select id="pub_id">
						<option value="">Select</option>
						<?php foreach($publications as $row){ ?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
						<?php } ?>
					</select>
					<button id="add_pub_click">Add</button>
				</div>
				<table class="table table-bordered table-hover sample_6">
					<thead class="hidden">
						<tr><th>Publication </th></tr>
					</thead>
					<tbody>
					
					<?php 
					foreach($publication as $row){ 
						$club_id_list = explode(',', $row['club_id']);
						$u_club_id_list = array_unique($club_id_list);
						if(($key=array_search($id, $u_club_id_list)) !== false){
					?>
						<tr><td><i class="fa fa-remove user_remove" title="Remove" data-user_id="<?php echo $row['id'];?>" data-user_type="publications"></i> <a href="<?php echo base_url().index_page().'new_admin/home/publication/'.$row['id']; ?>"><?php echo $row['name'];?></a></td></tr>
					<?php } } ?>	
					</tbody>
				</table>
			</div>
		
			<div class="col-md-4 col-sm-12 margin-bottom-20">
				<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">CSR <i id="add_csr" title="Add" class="fa fa-plus" aria-hidden="true"></i> </p>
				<div id="add_csr_form" style="display:none;">
					<select id="csr_id">
						<option value="">Select</option>
						<?php foreach($csrs as $row){ ?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'].' ('.$row['username'].')';?></option>
						<?php } ?>
					</select>
					<button id="add_csr_click">Add</button>
				</div>
				<table class="table table-bordered table-hover sample_6" >
					<thead class="hidden">
						<tr><th>CSR </th></tr>
					</thead>
					<tbody>
					
					<?php 
						foreach($csr as $row){ 
							$club_id_list = explode(',', $row['club_id']);
							$u_club_id_list = array_unique($club_id_list);
							if(($key=array_search($id, $u_club_id_list)) !== false){
					?>
						<tr><td><i class="fa fa-remove user_remove" title="Remove" data-user_id="<?php echo $row['id'];?>" data-user_type="csr"></i> <a href="<?php echo base_url().index_page().'new_admin/home/csr_profile/'.$row['id']; ?>"><?php echo $row['name'].' ('.$row['username'].')';?></a></td></tr>
					<?php } } ?>
					
					</tbody>
				</table>
			</div>
		
			<div class="col-md-4 col-sm-12 margin-bottom-20">
				<p class="bold border-bottom" style="margin: 0 0 10px 0; padding-bottom: 10px; font-size: 15px;">Designer  <i id="add_designer" title="Add" class="fa fa-plus" aria-hidden="true"></i>  </p>
				
				<div id="add_designer_form" style="display:none;">
					<select id="designer_id">
						<option value="">Select</option>
						<?php foreach($designers as $row){ ?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'].' ('.$row['username'].')';?></option>
						<?php } ?>
					</select>
					<button id="add_designer_click">Add</button>
				</div>
				
				<table class="table table-bordered table-hover sample_6">
					<thead class="hidden">
						<tr><th>Designer </th></tr>
					</thead>
					<tbody>
					
					<?php 
						foreach($designer as $row){ 
							$club_id_list = explode(',', $row['club_id']);
							$u_club_id_list = array_unique($club_id_list);
							if(($key=array_search($id, $u_club_id_list)) !== false){
					?>
						<tr><td><i class="fa fa-remove user_remove" title="Remove" data-user_id="<?php echo $row['id'];?>" data-user_type="designers"></i> <a href="<?php echo base_url().index_page().'new_admin/home/designer_profile/'.$row['id']; ?>"><?php echo $row['name'].' ('.$row['username'].')';?></a></td></tr>
					<?php } } ?>	
					</tbody>
				</table>
			</div>	
		
		</div>
	</div>
<?php }?>
	

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable')?>
