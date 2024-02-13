<?php
       $this->load->view("admin/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script>
function Adp_confirm(){
    var X=confirm('Are You Sure ?');
	if(X==true){
    return true;
  }
else
  {
    return false;
  }
} 
</script>
  <div id="Middle-Div">
  <div class="span12">
   <div style="padding-left: 30px; padding-top: 20px;">
   <h3><?php echo $publications[0]['name']; ?></h3>
   
	<form class="form-horizontal" action="<?php echo base_url().'index.php/admin/home/publications/'.$publications[0]['id']; ?>"  method="post">
		 <fieldset>
		 <div class="control-group">
         <label class="control-label" for="focusedInput">Group</label>
         <div class="controls">
            <select name="group">
				<option value="">Select</option>
			<?php foreach($group as $row){ ?>
				<option value="<?php echo $row['id']; ?>" <?php if($publications[0]['group_id']==$row['id'])echo "selected"; ?>>
					<?php echo $row['name']; ?>
				</option>
			<?php } ?>
			</select>
         </div>
         </div>
		 <div class="control-group">
          <label class="control-label">Channels</label>
          <div class="controls">
			<select name="channel">
				<option value="">Select</option>
			<?php foreach($channel as $row){ ?>
				<option value="<?php echo $row['id']; ?>" <?php if($publications[0]['channel']==$row['id'])echo "selected"; ?>>
					<?php echo $row['name']; ?>
				</option>
			<?php } ?>
			</select>
          </div>
         </div>
			<div style="padding-left: 180px;">
			<input type="submit" value="Assign" name="assign" onclick="return Adp_confirm();" class="btn btn-primary" />
			</div>
		 </fieldset>
	</form>
		
   </div>
   
  </div> 
  </div>
<?php
      $this->load->view("admin/footer");
?>