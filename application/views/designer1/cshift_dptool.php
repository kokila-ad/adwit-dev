<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("designer/header");
	
?>


        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>

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
<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>
<form name="form" method="post">
 <div id="slug-view">
    <h2>Create Slug Here</h2>
    <p><label for="name">Order No</label></p>
    <input type="text" name="id" id="id" value="<?php if(isset($id))echo $id; ?>" readonly />
    <p style="padding: 0; margin: 0;">&nbsp;</p>

    <div class="alert alert-success alert-block">
		<h4 class="alert-heading" style="padding-bottom:6px;">Your Slug!</h4>
		<?php if(isset($slug)){	echo $slug."&nbsp;&nbsp;&nbsp;&nbsp;".$cat[0]['width']."x".$cat[0]['height'];?>
	</div>

	<input name="slug" value="<?php echo $slug;?>" readonly style="display:none;" />
	
    <button type="submit" name="confirm" value="Confirm" class="btn btn-primary">Confirm your ad slug</button>
	<?php  } ?>
    </div>
    </form>
	
	
    <div id="dp-view">
    <div class="alert alert-info">
     <button class="close" data-dismiss="alert">×</button>
    <strong>CSR Instruction!</strong>
	    <?php if(isset($cat[0]['instruction'])){ echo $cat[0]['instruction'];}else{echo "None";}	?>
		
	</div>
	<?php if(isset($jobs)) { ?>
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
	<h4 class="alert-heading" style="padding-bottom:6px;">Jobs Of The Day</h4>
	 <tr>
		<th>Order Id</th>
		<th>Slug</th>
		<th>Date</th>
		
	 </tr>
	 <?php foreach($jobs as $row){ ?>
	 <tr>
		<td><?php  echo $row['order_no']; ?></td>
		<td><?php  echo $row['slug']; ?></td>
		<td><?php  echo $row['ddate']; ?></td>
		
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

<?php
	$this->load->view("designer/footer");
	
?>