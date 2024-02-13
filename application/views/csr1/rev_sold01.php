<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	$this->load->view("csr/header");
	
?>

<base href="<?php echo base_url();?>" />
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
		<script src="js/modernizr.custom.63321.js"></script>

		<style>	
			.container > header h1,
			.container > header h2 {
				color: #fff;
				text-shadow: 0 1px 1px rgba(0,0,0,0.7);
			}
		</style>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
		
<script type="text/javascript">
	
	$(document).ready(function(e) { 
	
		$('#template_used').change(function(e) {
            if($('#template_used').val()=='1') $('#template_name').show();
			else $('#template_name').hide();
        });
	
		 $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="1") $('#ad-form-s6e').show();
			else $('#ad-form-s6e').hide();
            
        });	 
		if($(this).attr("value")=="1") $('#ad-form-s6e').show();
		else $('#ad-form-s6e').hide(); 
		
		$('input[type="radio"]').click(function(){
            if($(this).attr("value")=="2") $('#ad-form01-s6e').show();
			else $('#ad-form01-s6e').hide();
            
        });
		if($(this).attr("value")=="2") $('#ad-form01-s6e').show();
		else $('#ad-form01-s6e').hide(); 
		
	});

</script>

<script type="text/javascript">
	$(document).ready(function(e) {
        $('#help_desk').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/revision01/';?>" + $('#help_desk').val() ;
        });
    });
</script>
<style>
#slug-view-02 input {
	background: #FFF;
	padding: 5px 10px;
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
  <div id="slug-view-01">
  <div class="form">
 <?php if(isset($form)):?>
 <?php
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$today = date('Y-m-d');
		$rev_sold = $this->db->get_where('rev_sold_jobs',array('help_desk' => $form, 'date' => $today))->result_array();
		$order_count = count($rev_sold);
 ?>
    <form name="form" action="<?php echo base_url().index_page().'csr/home/revision01';?>" method="post">
	
      <h2 style="padding:0; margin:0;">REVISION</h2>
      <div id="slug-view-02">
	  <input  type="text" name="form" id="form" value="<?php echo $form ;?>" readonly style="display:none;" />
      <input class="slug-view-input" type="text" name="id" id="id" placeholder="Copy & Paste Order No" required />
      </div>
	  <p>&nbsp;</p>
	<p style="color:#F00; margin:0; padding:0; padding-top: 3px; font-weight: bold;"><input type="checkbox" name="fastrack" style=" margin-top:-5px;"> Fast Track </p> 
	
	<p>&nbsp;</p>
	<p style="padding: 0; margin: 0; font-weight: bold;">Rush Ads</p>
	<p style="color:#F00; margin:0; padding:0; padding-top: 3px; font-weight: bold;"><input type="checkbox" name="new" value="new" style=" margin-top:-5px;"> New Rush </p> 
	
	<p>&nbsp;</p>
    <p style="padding: 0; margin: 0; font-weight: bold;">Reason for Job Change</p>
    <p>&nbsp;</p>
	<!--
	<div class="radiogrp">
	<p style="padding: 0; margin: 0; font-weight: bold;">
	<input type="radio" name="adtype" id="adtype" value="1" >Correction &nbsp;&nbsp;
	<input type="radio" name="adtype" id="adtype" value="2" >Error &nbsp;&nbsp;
	</p>
	</div>
	</p>
-->

<ul class="dropdown clear">
	<li class="sub"><a href="#">Correction</a>
     <ul><div class="radiogrp">
		<input type="radio" name="error" id="error" value="1" >Adrep Changes <br/>
		<input type="radio" name="error" id="error" value="2" >Advertiser changes &nbsp;&nbsp;	
		</div>
	 </ul>
	</li>
	
	<li class="sub"><a href="#">Error</a>
     <ul><div class="radiogrp">
		<input type="radio" name="error" id="error" value="3" >Design Error <br/>
		<input type="radio" name="error" id="error" value="4" >Instruction Error &nbsp;&nbsp;	
		</div>
	 </ul>
	</li>
</ul>

<!--	<div id="ad-form-s6e" name="ad-form-s6e">	
	<p>&nbsp;</p>
			<select class="select-style gender" id="error" name="error"  >
				<option value=''> Select </option>
				<option value=''> Adrep Changes </option>
				<option value=''> Advertiser changes </option>
			</select>
	</div>	
	
	<div id="ad-form01-s6e" name="ad-form01-s6e">	
	<p>&nbsp;</p>
			<select class="select-style gender" id="error" name="error"  >
				<option value=''> Select </option>
				<option value=''> Design Error </option>
				<option value=''> Instruction Error </option>
			</select>
	</div>
	-->
	<!--	<div class="box" id="ad-form-s6e" name="ad-form-s6e">
			<p>&nbsp;</p>
			<input type="radio" name="error" id="error" value=""  >Adrep Changes &nbsp;&nbsp;
			<input type="radio" name="error" id="error" value=""  >Advertiser changes &nbsp;&nbsp;
		</div>
			
		<div class="box" id="ad-form01-s6e" name="ad-form01-s6e">
			<p>&nbsp;</p>
			<input type="radio" name="error" id="error" value=""  >Design Error &nbsp;&nbsp;
			<input type="radio" name="error" id="error" value=""  >Instruction Error &nbsp;&nbsp;
		</div>
     -->
	  <p>&nbsp; &nbsp;</p>
	  <p>&nbsp; &nbsp;</p>
      <div id="slug-btn">
        <input type="submit" name="submit" id="search" value="Submit" /></div>
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
    
  </div>
  </div>
  <div id="dp-view">
    <form name="form" action="<?php echo base_url().index_page().'csr/home/sold';?>" method="post">
      <h2 style="padding:0; margin:0;">SOLD</h2>
	  <input  type="text" name="form" id="form" value="<?php echo $form ;?>" readonly style="display:none;" />
      <input type="text" name="id" id="id" placeholder="Copy & Paste Order No" required />
      <p style="padding: 0; margin: 0;">&nbsp;</p>
      <div id="dp-view-btn">
        <input type="submit" name="search"  />
      </div>
      <div id="slug-error">
        <?php if(isset($sold_status)) echo "<p>".  $sold_status ."</p>";	?>
      </div>
    </form>
    <div class="span3" style="padding-left: 50px; padding-top: 50px;">
                                    <div class="chart" data-percent="<?php echo $order_count; ?>"><?php echo $order_count; ?></div>
                                    <div class="chart-bottom-heading"><a href="<?php echo base_url().index_page()."csr/home/frontlinetrack_all";?>" target="_blank"><span class="label label-info">Tracker</span></a>

                                    </div>
                                </div>
<?php  endif;?>
</div>
  </div>
<script src="theme001/vendors/jquery-1.9.1.min.js"></script> 
<script src="theme001/bootstrap/js/bootstrap.min.js"></script> 
<script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script> 
<script src="theme001/assets/scripts.js"></script>
<script src="theme001/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
<script>
        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({animate: 1000});
        });
        </script>
<?php
	$this->load->view("csr/footer");
	
?>
