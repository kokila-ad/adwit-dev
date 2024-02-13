<?php
       $this->load->view("new_csr/header");
?>

<title>GEL-2016</title>
</head>
<body><align-center>
<form method="post" action="<?php echo base_url().index_page().'new_csr/home/regform';?>" enctype="multipart/form-data">
<?php if (isset($message)) { ?>
<CENTER><h3 style="color:green;">Data inserted successfully</h3></CENTER><br/>
<?php } ?>

name:<input type="text" placeholder="reporter" id="dreporter" name="dreporter" style="width: 10%" /><br/><br/>


 <h3>You can attach files here</h3>

<!--<img scr="<?php echo $upload_data['full_path'];?>">-->
<h3>FILE1</h3>
<input type="file" name="userfile"/><br/><br/>

<h3>FILE2</h3>
<input type="file" name="userfile2" accept="/*"/>
  

<br /><br /><br/><br/>



<center><?php echo form_submit(array('id' => 'submit', 'value' => 'Submit')); ?><center/>
</form><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<?php
       $this->load->view("new_csr/footer");
?>

