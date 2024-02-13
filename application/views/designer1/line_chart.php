<?php
	$this->load->view("designer/header");
?>

<div id="Middle-Div">

<?php
    echo $this->gcharts->LineChart('orders')->outputInto('stock_div');
	echo $this->gcharts->div(600, 300);

	if($this->gcharts->hasErrors())
	{
		echo $this->gcharts->getErrors();
	}
?>

</div>

<?php
	$this->load->view("designer/footer");
?>
