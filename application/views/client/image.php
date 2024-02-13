<?php
	$this->load->view("client/header1");
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#img_prev')
.attr('src', e.target.result)
.width(150)
.height(200);
};

reader.readAsDataURL(input.files[0]);
}
}
</script>
<?php
	$client_name=$this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
?>
<?php if(isset($error))echo $error;?>
<p><label>NOTE : Image Size Allowed Not More Than 180px * 180px</label></p>
<img id="img_prev" src="<?php echo $client_name[0]['image'];?>" alt="your image" width="180px" height="180px"/>
<form name="Image" enctype="multipart/form-data"  method="POST">

<input type="file" name="Photo" size="2000000" accept="image/gif, image/jpeg, image/x-ms-bmp, image/x-png" size="26" onchange="readURL(this);" ><br/>
<INPUT type="submit" class="button" name="Submit" value="Submit" > 
&nbsp;&nbsp;
<a href="<?php echo base_url().index_page()."client/home/change";?>" ><input type="button" value="Cancel" /></a>
</form>

<?php
	$this->load->view("client/footer");
?>