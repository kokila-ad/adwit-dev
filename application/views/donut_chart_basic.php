
<?php
echo "<center>";
    echo $this->gcharts->DonutChart('add')->outputInto('food_div');
    echo $this->gcharts->div(500,300);
    
    if($this->gcharts->hasErrors())
    {
        echo $this->gcharts->getErrors();
    }

	echo "</center>";
?>


