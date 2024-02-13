<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("csr/header");
	
?>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/rs/';?>" + $('#help_desk').val() ;
        });
    });
</script>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<style>
#slug-view input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #2ecc71;
	border-radius: 5px;
}

#slug-btn input {
	font-size: 14px;
	color: #FFF;
	background: #2ecc71;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}


#dp-view-btn {
	width: 200px;
	margin: 0 auto;
	padding-top: 60px;
}

#dp-view-btn input {
	width: 100%;
	padding: 13px 10px;
	background: #e74c3c;
	border: #000;
	color: #FFF;
	border-radius: 5px;
}

#slug-error input{
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}

</style>


<div id="Middle-Div">
<p style="text-align:center;">
        	<strong>Select Your HELP DESK:</strong>&nbsp;
        	<select id="help_desk" name="help_desk">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('help_desk')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
</p>
<?php if(isset($form)):?>

<div id="slug-view">
 <form name="form" method="post">
    <h2>INCOMING</h2>
    <p><label for="name">Order No</label></p>
    <input type="text" name="id" id="id" value="<?php echo set_value("id"); ?>" placeholder="Copy & Paste Order No" required />
    <p style="padding: 0; margin: 0;">&nbsp;</p>
	<?php if(!isset($status_check)){ ?>
    <div id="slug-btn">
    <input type="submit" name="search"  />
    </div>
	<?php } ?>
 </form>

</div>
	
	
    <div id="dp-view">
	<?php 
		if(isset($error)){ echo "<font color='red' style='font-family:Tahoma, Geneva, sans-serif' size='+3'>".$error."</font>"; }
		if(isset($status_check))
		{
	?>
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
	 <tr>
		<th>Version</th>
		<th>Slug</th>
		<th>Date</th>
		<th>Designer_Id</th>
		<th>Category</th>
	 </tr>
	 <?php foreach($status_check as $row){ ?>
	 <tr>
		<td><?php  echo $row['version']; ?></td>
		<td><?php  echo $row['slug']; ?></td>
		<td><?php  echo $row['date']; ?></td>
		<td><?php  echo $row['designer']; ?></td>
		<td><?php  echo $row['category']; ?></td>
	</tr>
	<?php } ?>
	</table>
	<br/>
	<form name="form" action="<?php echo base_url().index_page().'csr/home/rs_sold';?>" method="post">
      <input  type="text" name="form" id="form" value="<?php echo $form ;?>" readonly style="display:none;"  />
      <input type="text" name="id" id="id" value="<?php echo set_value("id"); ?>" readonly style="display:none;"  />
      
      <div id="dp-view-btn">
        <input type="submit" name="search" value="SOLD" />
      </div>
      <div id="slug-error">
        <?php if(isset($sold_status)) echo "<p>".  $sold_status ."</p>";	?>
      </div>
    </form>
	
<form name="form" action="<?php echo base_url().index_page().'csr/home/rs_revision';?>" method="post">
	
      <h2 style="padding:0; margin:0;">REVISION</h2>
      <div id="slug-view-02">
	  <input  type="text" name="form" id="form" value="<?php echo $form ;?>" readonly style="display:none;" />
      <input class="slug-view-input" type="text" name="id" id="id" value="<?php echo set_value("id"); ?>" readonly style="display:none;" />
      </div>
	<p style="color:#F00; margin:0; padding:0; padding-top: 3px; font-weight: bold;"><input type="checkbox" name="fastrack" style=" margin-top:-5px;"> Fast Track </p> 
	
	<p style="padding: 0; margin: 0; font-weight: bold;">Rush Ads</p>
	
	<p style="color:#F00; margin:0; padding:0; padding-top: 3px; font-weight: bold;"><input type="checkbox" name="new" value="new" style=" margin-top:-5px;"> New Rush </p> 
	
    <p style="padding: 0; margin: 0; font-weight: bold;"></p>
    <div style="font-size: 12px;">
     <p style="padding: 0; margin: 0; padding-top: 5px; font-weight: bold;">Instruction Error</p>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '7', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
    <p style="padding: 0; margin: 0; padding-top: 5px; font-weight: bold;">Visual Error</p>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '4', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
    <p style="padding: 0; margin: 0; padding-top: 5px; font-weight: bold;">Design Error</p>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '1', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
    <p style="padding: 0; margin: 0; padding-top: 5px; font-weight: bold;">Tech Error</p>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '2', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
        </div> 
      <div id="slug-btn">
        <input type="submit" name="submit" id="search" value="REVISION" /></div>
      <div id="slug-error">
        <?php 
			if(isset($fastrack_msg))
			{
				echo '<script language="javascript">';
				echo 'alert("Use Fastrack Printer")';
				echo '</script>';
			}
			
			if(isset($rev_status)) echo "<p>".  $rev_status ."</p>";	
		?>
      </div>
</form>
	
	<?php
		}
	?>
   
	</div>
	

<div id="Back-btn"><a href="<?php echo base_url().index_page().'csr/home/';?>">Back</a></div>
<?php  endif;?>
 <div id="slug-error">
        <?php if(isset($sold_status)) echo "<p>".  $sold_status ."</p>";	?>
      </div>

</div>

<?php
	$this->load->view("csr/footer");
	
?>