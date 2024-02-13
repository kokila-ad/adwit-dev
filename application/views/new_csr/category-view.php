<?php
       $this->load->view("csr/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		



<script type="text/javascript">
	$(document).ready(function(e) {
        $('#hd').change(function(e) {
            window.location = "<?php echo base_url().index_page().'csr/home/category_help/';?>" + $('#hd').val() ;
        });
    });
</script>

<div id="Middle-Div">

<p style="text-align:center;"> 
        	Select Your Help Desk:&nbsp;
        	<select id="hd" name="hd">
            <option value="">Select</option>
        	<?php
			$types = $this->db->get('help_desk')->result_array();
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'" '.($form==$type['id'] ? 'selected="selected"' : '').'>'.$type['name'].'</option>';	
				}
			?>
            </select>
</p>
</div>
                       
<?php
       $this->load->view("csr/footer");
?>