
<HTML>
<HEAD>
<title><?php echo $this->session->userdata('client');?> @ Adwit Ads - Client</title>

<style>
body{width:610;}
.demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>

<base href="<?php echo base_url();?>" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="js/rate.js" type="text/javascript"></script>

<script>
function highlightStar(obj,id) {
	removeHighlight(id);		
	$('.demo-table #tutorial-'+id+' li').each(function(index) {
		$(this).addClass('highlight');
		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
			return false;	
		}
	});
}

function removeHighlight(id) {
	$('.demo-table #tutorial-'+id+' li').removeClass('selected');
	$('.demo-table #tutorial-'+id+' li').removeClass('highlight');
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
	if($('#tutorial-'+id+' #rating').val() != 0) {
		$('.demo-table #tutorial-'+id+' li').each(function(index) {
			$(this).addClass('selected');
			if((index+1) == $('#tutorial-'+id+' #rating').val()) {
				return false;	
			}
		});
	}
} 
</script>

</HEAD>
<BODY>
<table class="demo-table">
<tbody>
<tr>
<th><strong>Job Rating</strong></th>
</tr>

<tr>
<td valign="top">
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
	<li class='<?php echo $selected; ?>' onmouseover="highlightStar(this,0);" onmouseout="removeHighlight(0);" onClick="addRating(this,<?php echo $order; ?>);">&#9733;</li>  
	<?php }  ?>
	<ul>
</div>
<div>
<?php if(isset($filename)){ ?>
	<a onclick="window.location.href = '<?php echo base_url().index_page().'client/home/download_files/'.$filename; ?>'" style="cursor:pointer; text-decoration: none;">pdf Download</a>
<?php } ?>	
</div>
</td>
</tr>

</tbody>
</table>
</BODY>
</HTML>
