<?php
	$this->load->view("designer/header");
?>

<div id="Middle-Div">

<?php
    echo $this->gcharts->ColumnChart('orders')->outputInto('money_div');
    echo $this->gcharts->div();

    if($this->gcharts->hasErrors())
    {
        echo $this->gcharts->getErrors();
    }
?>

</div>

<?php
	$this->load->view("designer/footer");
?>
