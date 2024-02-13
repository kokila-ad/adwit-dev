
<title><?php echo $this->session->userdata('client');?> @ Adwit Ads - Client</title>
<base href="<?php echo base_url();?>" />
<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="js/rate.js" type="text/javascript"></script>
<style>
body{width:550px; padding: 0;}
.demo-table {width: 100%;border-spacing: initial;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>
<script>
function highlightStar(obj,id) {
	removeHighlight(id);		
	$('.demo-table #tutorial-1 li').each(function(index) {
		$(this).addClass('highlight');
		if(index == $('.demo-table #tutorial-1 li').index(obj)) {
			return false;	
		}
	});
}

function removeHighlight(id) {
	$('.demo-table #tutorial-1 li').removeClass('selected');
	$('.demo-table #tutorial-1 li').removeClass('highlight');
}

function addRating(obj,id) {
	$('.demo-table #tutorial-1 li').each(function(index) {
		$(this).addClass('selected');
		$('#tutorial-1 #rating').val((index+1));
		if(index == $('.demo-table #tutorial-1 li').index(obj)) {
			return false;	
		}
	});
	$.ajax({
	url: "<?php echo base_url().index_page().'client/home/add_rating';?>",
	data:'id='+id+'&rating='+$('#tutorial-1 #rating').val(),
	type: "POST"
	});
	
}

function resetRating(id) {
	if($('#tutorial-1 #rating').val() != 0) {
		$('.demo-table #tutorial-1 li').each(function(index) {
			$(this).addClass('selected');
			if((index+1) == $('#tutorial-1 #rating').val()) {
				return false;	
			}
		});
	}
} 
</script>
<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script>

	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />

    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
                <link rel="stylesheet" href="flatmenu/flatmenu.css" type="text/css" />
<body>
<table class="demo-table" align="center" width="0" border="0" cellspacing="0" cellpadding="0" style=" width:702px; border:#000 solid 1px;">
  <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:702px;">
  <tr>
    <td align="center" style="background-color:#000;"><img src="images/logo.png" width="189" height="50"></td>
  </tr>
   <tr>
    <td><table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style="width:682px; border-bottom:#cccccc solid 1px;">
  <tr>
    <td style=" width:176px;"><p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; margin:0px; padding:15px 0 15px 5px; ">Adwit Ads ID: <b><?php echo $order_details['id']; ?></b></p></td>
    
     <td align="center" style=" width:340px;"><p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; margin:0px; padding:15px 0 15px 5px; ">Unique Job ID: <b><?php echo $order_details['job_no']; ?></b></p></td>
     
      <td align="right" style=" width:166px;"><p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; margin:0px; padding:15px 5px 15px 0px; ">Date: <strong><?php $date = strtotime($order_details['created_on']); echo date('Y-m-d', $date); ?></strong></p></td>
  </tr>
</table>
</td>
  </tr> 
  
  <tr><!-- star rating -->
  
    <td align="center"><p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:14px; margin:0px; padding:20px 0 5px 0;">Your feedback is important to us</p>
	<p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:14px; margin:0px; padding:0px 0 10px 0;">Rate this ad</p>
	<div id="tutorial-1">
		<input type='hidden' name="rating" id="rating" value="0" />
		<input type='hidden' name="order_id" id="order_id" value="<?php echo $order; ?>" />
		
		<ul onMouseOut="resetRating(0);">
		<?php
			for($i=1;$i<=5;$i++) {
			$selected = "";
			if( $i<=0) {
				$selected = "selected";
			}
		?>
		<li class='<?php echo $selected; ?>' onmouseover="highlightStar(this,1);" onmouseout="removeHighlight(1);" onClick="addRating(this,<?php echo $order; ?>);">&#9733;</li>  
		<?php }  ?>
		</ul>
	</div>
	</td>
    
  </tr>  
 </table>
 
 </tr>
   <tr>
    <td><table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style="width:682px;">
  <tr>
    
     <?php if(isset($filename)){ ?>
		<td align="right" style=" width:338px;"><a href="<?php echo 'download.php?file_source='.$filename ; ?>"><button class="btn btn-danger"><i class="icon-download-alt"></i> Download PDF</button></a></td>
	 	
	 <td style=" width:8px;">&nbsp;</td>
    <td align="left" style=" width:338px;">
	<?php if($order_details['publication_id']=='43'){ ?>
	<a href="<?php echo 'ftp_desert.php?file_source='.$filename ; ?>" onclick="load();" ><button class="btn btn-primary">Send to Production</button></a>
	<?php }else{ ?>
<a href="<?php echo 'ftp_upload.php?file_source='.$filename ; ?>" onclick="load();" ><button class="btn btn-primary">Send to Production</button></a>
	</td>
	<?php } } ?>
  </tr>
</table>
</td>
  </tr>
  
   <tr>
    <td align="center"><p style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:14px; margin:0px; padding:30px 0; color:#666666; "><a href="javascript:closeWindow();">Close window</a></p></td>
  </tr>
  
   <tr>
    <td style=" background-color:#000">&nbsp;</td>
  </tr>
  
</td>
  </tr>
</table>

          <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>
        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
                <script>
        $(function() {
            
        });
        </script>
<script language="javascript" type="text/javascript">

	function load() {

	if ($('#loading_image').length == 0) { //is the image on the form yet?

					// add it just before the submit button

	$(':submit').after('<img src="images/up.gif" alt="Uploading...." id="loading_image" >')

	}

		$('#loading_image').show(); // show the animated image    

		 // disable double submits

		return true; // allow regular form submission

	};

</script>

</body>

