<?php
	$this->load->view("client/header1");
?>

 <div id="Middle-Div">
<?php
	if	($order_type['value'] == 'html_order')
	{
		$this->load->view('client/'.$order_type['value'].'-'.$html_type['value'].'-fluid-view');
	}else{
		$data['file_path'] = $order['file_path'];
		$this->load->view('client/'.$order_type['value'].'-'.$ad_type['value'].'-fluid-view', $data);
	}
	?>	
</div>
			
<?php
	$this->load->view("client/footer");
?>