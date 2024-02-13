
<html class="">

<head>
   

	<link rel="stylesheet" href="stylesheet/style_fluid.css" type="text/css" />

    	<link rel="stylesheet" href="stylesheet/boilerplate.css" type="text/css" />
                <link rel="stylesheet" href="flatmenu/flatmenu.css" type="text/css" />


 <script type="text/javascript" src="js/jquery.min.js"></script>

<script src="js/respond.min.js"></script>
        <script type="text/javascript" src="flatmenu/flatmenu-responsive.js"></script>
        <script type="text/javascript" src="flatmenu/flatmenu-ie6.js"></script>


</head>

<body>
<div class="gridContainer clearfix">
	<div id="Middle-Div">
	<?php
	if	($order_type['value'] == 'html_order')
		{
			$this->load->view('client/'.$order_type['value'].'-'.$html_type['value'].'-fluid-view');
		}
			else {
		$this->load->view('client/'.$order_type['value'].'-'.$ad_type['value'].'-fluid-view');
			}
	?>	
	</div>
</div>
</body>
</html>