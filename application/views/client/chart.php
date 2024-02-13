<?php
	$this->load->view("client/header1");
?>

<div id="Middle-Div">
<p style="padding: 20px; text-align: center; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:16px; color: #F00;">
</p>

<div style="padding-left: 30px; padding-top: 20px;">
    <form method="post" style="padding:0; margin:0;">
		<input type="submit" name="prevmonth" value="Last Month" />
		<input type="submit" name="last3month" value="Last 3 Months" />
		<input type="submit" name="total" value="Total" />
    </form>
</div>

<?php
echo "<center>";
    echo $this->gcharts->DonutChart('add')->outputInto('food_div');
    echo $this->gcharts->div(500,300);
    /* if(isset($count))
	{
		if($count<='0') echo $count."No Data Available.";
	} */
    if($this->gcharts->hasErrors())
    {
        echo $this->gcharts->getErrors();
    }
if(isset($date)){echo "<h2>".$date."</h2>";}
echo "</center>";

?>

</div>

<?php
	$this->load->view("client/footer");
?>
