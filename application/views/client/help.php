<?php
       $this->load->view("client/header1");
?>
<style>
video {  
   width:100%; margin:0 auto; height:280px; background: #ccc;
	}
</style>

  <div id="Middle-Div">
    <h2 style="text-align: center;">FAQ's</h2>
    <p style="text-align: center;">1a. How to place an order</p>
    <video controls><source type="video/mp4" src="video/How_to_place_an_order.mp4"></video>
    <p style="text-align: center; padding-top: 20px;">1b. How to use your dashboard</p>
    <video controls><source type="video/mp4" src="video/Dashboard.mp4"></video>
    
 </div>
<?php
       $this->load->view("client/footer");
?>