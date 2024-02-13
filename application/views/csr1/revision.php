<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("csr/header");
	
?>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/revision';?>" ;
        });
    });
</script>
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<script src="theme001/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<style>
#slug-view-02 input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #38b6ff;
	border-radius: 5px;
	width: 60%;
	outline: none;
}

#slug-view-01 h2 {
font-weight: normal;
padding: 0 0 20px 0;
margin: 0;
}

#slug-view-01 p {
padding: 0 0 5px 0;
margin: 0px
}
#slug-btn input {
	font-size: 14px;
	color: #FFF;
	background: #38b6ff;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}
#dp-view input {
	background: #FFF;
	padding: 12px 10px;
	border: 2px solid #ff7070;
	border-radius: 5px;
	width: 60%;
	outline: none;
}
#dp-view h2 {
	font-weight: normal;
	padding: 0 0 20px 0;
	margin: 0;
}
#dp-view p {
	padding: 0 0 5px 0;
	margin: 0px;
}
#dp-view-btn {
	padding-top: 15px;
	width: 45%;
}
#dp-view-btn input {
	font-size: 14px;
	color: #FFF;
	background: #ff7070;
	padding: 10px 10px;
	border-radius: 5px;
	border: none;
}
#slug-error input {
	background: #FFF;
	padding: 6px 10px;
	color: #e74c3c;
	border: 2px solid #e74c3c;
	border-radius: 5px;
}
#rev-sold {
	clear: both;
	float: left;
	padding: 10px 0;
	margin-left: 5%;
	width: 90%;
	display: block;
}
.input {
	border: 1px solid #333;
}
.required {
	color: red;
	font-size: 12px;
}
#registerDiv {
	display: none;
	margin-top: 10px;
	margin-left: 20px;
	border: 2px solid #333;
	padding: 3px;
	background: #cdcdcd;
	width: 280px;
	text-align: center;
}


</style>

<div id="Middle-Div">
  <div id="slug-view-01">
  <div class="form">
  <!--<form name="form" action="<?php echo base_url().index_page().'csr/home/revision';?>" method="post"> -->
	<p style="text-align:center;">
        	Select Your Ad Type:&nbsp;
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
 <!-- </form>-->
 <?php //if(isset($form)):?>
    <form name="form" action="<?php echo base_url().index_page().'csr/home/revision';?>" method="post">
	
      <h2>REVISION</h2>
      <p>
        <label for="name">Order No</label>
      </p>
      <div id="slug-view-02">
      <input class="slug-view-input" type="text" name="id" id="id" placeholder="Copy & Paste Order No" autocomplete="off" required  />
      </div>
      <p style="padding: 0; margin: 0;">&nbsp;</p>
               <!-- popup window -->
    <div id="myModal" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">&times;</button>
        <h3>Modal header</h3>
      </div>
      <div class="modal-body">
        <p>Modal Example Body</p>
      </div>
    </div>
    <div id="myAlert" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">&times;</button>
        <h3>Reason for Job Change</h3>
      </div>
      <div class="modal-body">
        <p>
     <h3>Design Error</h3>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '1', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
    <h3>Tech Error</h3>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '2', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
    <h3>Text Error</h3>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '3', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
    <h3>Visual Error</h3>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '4', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
        </p>
      </div>
      <div class="modal-footer">
        <input type="submit" name="submit" class="btn btn-primary"/>
        <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
    </div>
     <!-- popup window ends -->
      <div id="slug-btn">
      <a href="#myAlert" data-toggle="modal">
        <input type="button" name="search" id="search" value="Submit" />
        </a> </div>
      <div id="slug-error">
        <?php
			if(isset($fastrack_msg))
			{
				echo '<script language="javascript">';
				echo 'alert("message successfully sent")';
				echo '</script>';
			}
			//if(isset($rev_status)) echo "<p>".  $rev_status ."</p>";	
		?>
      </div>
    </form>
    
  </div>
  <div id="dp-view">
    <form name="form" action="<?php echo base_url().index_page().'csr/home/sold';?>" method="post">
      <h2>SOLD</h2>
      <p>
        <label for="name">Order No</label>
      </p>
      <input type="text" name="id" id="id" placeholder="Copy & Paste Order No" autocomplete="off" required />
      <p style="padding: 0; margin: 0;">&nbsp;</p>
      <div id="dp-view-btn">
        <input type="submit" name="search"  />
      </div>
      <div id="slug-error">
        <?php if(isset($sold_status)) echo "<p>".  $sold_status ."</p>";	?>
      </div>
    </form>
	
</div>
  </div>
</div>
<script src="theme001/vendors/jquery-1.9.1.min.js"></script> 
<script src="theme001/bootstrap/js/bootstrap.min.js"></script> 
<script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script> 
<script src="theme001/assets/scripts.js"></script>

<?php
	$this->load->view("csr/footer");
	
?>
