<?php
	$this->load->view("admin/header");
	
	
?>

    <div id="container">          
        <div id="content">
          <p style="padding:10px;"><a href="<?php echo base_url().index_page().'admin/grid/metrojobs';?>" style="text-decoration:none;">Back</a></p>
          <iframe src="http://www.metroadsondemand.com/metro-view.asp?id=<?php echo $od_orderid;?>" width="100%" height="100%"></iframe>
        </div><!-- #content-->
    </div>
    </section>
			
<?php
	$this->load->view("admin/footer");
?>