<?php $this->load->view("admin/header"); ?>

<div id="Middle-Div">
	<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?>
	<div id="slug-view">
		<h2>DESIGNER TEAM ASSIGN</h2>
		<form method="post">
			<p style="margin: 5px 0;">Designers</p>
			<select class="select-style" id="designer" name="designer" required>
			<option value=''>Select</option>
			<?php foreach($designers as $row){ ?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
			<?php } ?>
			</select>

			<p style="margin: 5px 0;">Teams</p>
			<select class="select-style" id="team" name="team" required>
			<option value=''>Select</option>
			<?php foreach($teams as $row){ ?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
			<?php } ?>
			</select>

			<div id="slug-btn">
			 <input name="submit" type="submit" value="Submit">
			</div>
		</form>
	</div>

	<div id="dp-view">
		<div style="width:50%; float: left; margin: 0">
			<h2>Team Check</h2>
			<form method="post">
				<p style="margin: 5px 0;">Teams</p><br/>
				<select class="select-style" id="team" name="team" required>
					<option value=''>Select</option>
				<?php foreach($teams as $row){ ?>
					<option value="<?php echo $row['id']; ?>" <?php if(isset($tId)&&($row['id']==$tId)){echo'selected';} ?>>
						<?php echo $row['name']; ?>
					</option>
				<?php } ?>
				</select>
				<div id="slug-btn">
				 <input name="team_search" type="submit" value="search">
				</div>
				<br/>
			</form>
		</div>

		<div style="width:50%; float: left; margin: 0">
		<h2>Designer Check</h2>
			<form method="post">
				<p style="margin: 5px 0;">Designers</p><br/>
				<select class="select-style" id="designer" name="designer" required>
					<option value=''>Select</option>
				<?php foreach($designers as $row){ ?>
						<option value="<?php echo $row['id']; ?>" <?php if(isset($dId)&&($row['id']==$dId)){echo'selected';} ?>>
						<?php echo $row['username']; ?>
						</option>
				<?php } ?>
				</select>
				<div id="slug-btn">
				 <input name="designer_search" type="submit" value="search">
				</div>
				<br/>
			</form>
		</div>

	<?php if(isset($list)){ ?>
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
		<tr>
			<th>Designer</th>
			<th>Team</th>
			<th>Action</th>
		</tr>
	<?php foreach($list as $row){ ?>		
		<tr>
			<td>
				<?php 
					$designer_name = $this->db->get_where('designers',array('id' => $row['designer_id']))->result_array();
					echo $designer_name[0]['username']; 
				?>
			</td>
			<td>
				<?php 
					$team_name = $this->db->get_where('teams',array('id' => $row['team_id']))->result_array();
					echo $team_name[0]['name']; 
				?>
			</td>
			<td><form method="post">
					<?php if(isset($tId)){ ?>
					<input name="tId" value="<?php echo $tId;?>" readonly style="display:none;" />
					<?php }elseif(isset($dId)){ ?>
					<input name="dId" value="<?php echo $dId;?>" readonly style="display:none;" />
					<?php } ?>
					<input name="id" value="<?php echo $row['id'];?>" readonly style="display:none;" />
					<button type="submit" name="delete">delete</button>
				</form>
			</td>
		</tr>
	<?php } ?>	
	</table>
	<?php } ?>
	</div>
</div>
    <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>
<?php $this->load->view("admin/footer"); ?>
