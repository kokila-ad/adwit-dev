<?php
	$this->load->view("client/header1");
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
	$this->load->view("client/footer");
?>
