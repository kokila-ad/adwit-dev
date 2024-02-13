<?php
	$this->load->view("designer/header");
?>
	<link href="ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
  <script>

    function fill() {
        var txt8 = document.getElementById("w").value-0;
        var txt9 = document.getElementById("h").value-0;
        document.getElementById("size").value = txt8 * txt9;
		//document.getElementById("totalwt").value = txt8 + txt9;
		//var a = txt8 * txt9;
		
	}
	
	
	function fill2() {
        var txt1 = document.getElementById("srt2").value-0;
        var txt2 = document.getElementById("imgmax").value-0;
        document.getElementById("size1").value = txt1 * txt2;
		//var b = txt1 * txt2;
	}
	
	
		

	function run(adwt) {
	     document.getElementById("adtw").value = adwt;
	}
 
	function run1(adinstwt) {
     document.getElementById("adiw").value = adinstwt;
	}
 
	function run2() {
     document.getElementById("srt2").value = document.getElementById("imgsrc").value;
	}
	function run3(dvalue) {
     document.getElementById("design_type").value = dvalue;
	}
 
 
</script>

<div id="Middle-Div">
		<p style="padding:0 0 0 10px; margin:0;"><?php echo validation_errors(); ?></p>
   <div id="order_form">
      <form name="form" method="post">
   <div id="ad-form">
         <div id="ad-form-h">Category Tool</div>
   <div id="ad-form-s-l">
   <p class="contact"><label for="name">Order No</label></p>
        <input type="text" id="order_no" name="order_no" value="<?php echo set_value('order_no');?>" autocomplete="off">
   <p class="contact"><label for="name">Job Name</label></p>
        <input name="job_name" type="text" value="<?php echo set_value('job_name');?>" autocomplete="off">
<p class="contact"><label for="name">No of Pages</label></p>
  <select class="select-style gender" id="no_pages" name="no_pages" >

   	<option value="1" <?php echo set_select('no_pages', '1');?> >1</option>
	<option value="2" <?php echo set_select('no_pages', '2');?> >2</option>
	<option value="3" <?php echo set_select('no_pages', '3');?> >3</option>
	<option value="4" <?php echo set_select('no_pages', '4');?> >4</option>
	<option value="5" <?php echo set_select('no_pages', '5');?> >5</option>      
         
    </select>
   <p class="contact"><label for="name">Ad Type</label></p>
        <?php
		
		$results = $this->db->get('cat_adtype')->result_array();
		
		foreach($results as $result)
					{
	
echo '<input type="radio" name="adtype" id="adtype" value="'.$result['weightage'].'" '.set_radio('adtype',$result['weightage']).' onClick="run(this.value);" required="required" style="width:5%;"><label>'.$result['adtype'],'</label>';
      
 echo '&nbsp;&nbsp;&nbsp;';
					}
 ?>
 <p class="contact" style="padding-top:15px;"><label for="name">Ad Instruction</label></p>
        <?php
		
		$results = $this->db->get('cat_adinstruction')->result_array();
		
		foreach($results as $result)
		{
	
			echo '<input type="radio" name="adinst" id="adinst" value="'.$result['adinstwt'].'" '.set_radio('adinst',$result['adinstwt']).' onClick="run1(this.value);" required="required" style="width:5%;"><label>'.$result['adinst'].'</label>';
      
			echo '&nbsp';
		}
	?>
	
	
	<p class="contact" style="padding-top:15px;"><label for="name">Newspaper</label></p>
	<?php
		
		$cat_news = $this->db->get('cat_newspaper')->result_array();
	
		?>
	<select class="select-style gender"  name="cat_news" required="required" >
	<option value=""> select </option>
	<?php
	foreach($cat_news as $cn)
		{
	?>
	<option value='<?php echo $cn['initials'] ?>|<?php echo $cn['slug_type'] ?>' <?php echo set_select('cat_news',$cn['initials']);?> > <?php echo $cn['name']; ?> </option>
	<?php
		}
	?>
	</select>
	
   </div>
   <div id="ad-form-s-r">
   <p class="contact"><label for="name">Width</label></p>
        <input value="<?php echo set_value('w');?>" onChange="fill()"  id="w" name="w" autocomplete="off"/>
	<p class="contact"><label for="name">Height</label></p>
        <input onChange="fill()"  id="h" name="h" value="<?php echo set_value('h');?>" autocomplete="off"/>
        <div style="display: none;">
	<p class="contact"><label for="name">Size</label></p>
        <input id=size name="size" value="<?php echo set_value('size');?>" readonly/>
        </div>
    <p class="contact"><label for="name">No. of Images provided</label></p>
        <input onChange="" name="no_img" id="no_img" value="<?php echo set_value("no_img"); ?>" autocomplete="off"/>
    <p class="contact"><label for="name">No. of Images source</label></p>
        <input onChange="" id="imgmax" name="imgmax" value="<?php echo set_value("imgmax");?>" autocomplete="off"/>
<p class="contact"><label for="name">Design Type</label></p>
        <input type="radio" name="design_type" id="design_type" value="0.5" <?php echo set_radio('design_type', '0.5'); ?>  required="required" style="width:5%;">&nbsp;<label for="design_type">Standard</label>&nbsp;&nbsp;&nbsp;
		   <input type="radio" name="design_type" id="design_type" value="0.6" <?php echo set_radio('design_type', '0.6'); ?> required="required"  style="width:5%;"/>&nbsp;<label>Multilisting</label>
   </div>
   <div id="ad-form-s4">        
        <input class="buttom" type="submit" value="SUBMIT" style="width:20%" />
        <a href="http://www.adwitads.com/weborders/index.php/designer/home/category"><input class="buttom" name="Reset" type="reset" value="RESET" style="width:20%"  /></a>
       <div style="display:none;">
       <input id="adtw" name="adtw" value="<?php echo set_value('adtw');?>" size="10" readonly style="visibility:hidden"  /><input id="adiw" name="adiw" value="<?php echo set_value('adiw');?>" readonly style="visibility:hidden" ><input value="8" id="imgwt" name="imgwt" readonly style="visibility:hidden" /><input id="size1" name="img_wt" value="15" readonly style="visibility:hidden"  />
       
	   </div>
        </div>
   </div>
</form>
</div>

<div style="width:300px; margin: 0 auto; text-align: center;">
<?php
if(isset($_POST["design_type"]))
{
	$order_no=$_POST['order_no'];
	$job_name=$_POST['job_name'];
	
	$width=$_POST['w'];
	$height=$_POST['h'];
		
	$size = $_POST['size'];
	$adtypewt1 = $_POST['adtw'];
	$adinstwt = $_POST['adiw'];
	$type=$_POST['design_type'];
	//$weightage = $_POST['wt'];
	//$date=Date("Ymd");
	//$time=date("His");
	$pages=$_POST['no_pages'];
	$no_imgs_prov=$_POST['no_img'];
	$wt_imgs_prov=$_POST['imgwt'];
	$no_imgs_src=$_POST['imgmax'];
	$wt_imgs_src=$_POST['img_wt'];
	
	if($_POST['cat_news']!="")
	{
		$rest = $_POST['cat_news'];
		$result_explode = explode('|', $rest);
		$initial = $result_explode[0];
		$slug_type = $result_explode[1];
	}else{
		$initial = "none";
		$slug_type = "none";
	}

	$adtypewt=$adtypewt1*$type;

	$x1=$no_imgs_prov*$wt_imgs_prov;
	$x2=$no_imgs_src*$wt_imgs_src;

	$weightage=$x1+$x2;
	//echo "SIZE                : ",$size,"<br/>";


	//connection to the database


	$result1 = mysql_query("SELECT * FROM cat_sizeminmax");
	$num_rows1 = mysql_num_rows($result1);

	//echo "$num_rows Rows\n";


	$i=0; $j=0; $k=0;
	while ($row = mysql_fetch_array($result1, MYSQL_NUM)) {  //MYSQL_ASSO

		$x[$i]=$row[0];
		$y[$j]=$row[1];
		$z[$k]=$row[2];
		   //printf("name: %s  id: %s ", $a[$i], $b[$j]); 
			$i++; $j++; $k++; 
			//echo "<br/>";
	}


	function rang1($size,$x,$y,$z,$num_rows1)
	{
		$w=$size;
		if($w<=0)
		echo "Please fill the Fields: Fields Empty..!",exit();
		if($w>=$x[$num_rows1-1])
		{
		//echo " [ > ",$x[$num_rows1-1],"] : ";
		return $z[$num_rows1-1];
		}
		for($i=0; $i<$num_rows1; $i++)
		{
		if($w>=$x[$i] && $w<=$y[$i])
		{
		//echo " [",$x[$i],"-",$y[$i],"] : ";
		return $z[$i];
		}
		}
	}

	function rang2($size,$x,$y,$z,$num_rows1)
	{
		$w=$size;
		//echo "size:",$size;
		if($w>=$x[$num_rows1-1])
		{
		echo " [ > ",$x[$num_rows1-1],"] : ";
		return $z[$num_rows1-1];
		}
		for($i=0; $i<$num_rows1; $i++)
		{
		if($w>=$x[$i] && $w<=$y[$i])
		{
		//echo " [",$x[$i],"-",$y[$i],"] : ";
		return $z[$i];
		}
		//i++;
		}
	}
	$sizewt=rang1($size,$x,$y,$z,$num_rows1);
	//echo "No of pages : ".$pages."<br/>";
	//echo "SIZEWT : ",rang2($size,$x,$y,$z,$num_rows1),"<br/>";

	$AdSizeWt = rang2($size,$x,$y,$z,$num_rows1);

	$result = mysql_query("SELECT * FROM cat_minmax");
	$num_rows = mysql_num_rows($result);

	//echo "$num_rows Rows\n";


	$i=0; $j=0; $k=0;
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {  //MYSQL_ASSOC

		$a[$i]=$row[0];
		$b[$j]=$row[1];
		$c[$k]=$row[2];
		   //printf("name: %s  id: %s ", $a[$i], $b[$j]); 
			$i++; $j++; $k++; 
			//echo "<br/>";
	}

	$w = ($AdSizeWt+$adtypewt+$adinstwt+$weightage)*$pages; //total

	function rang($AdSizeWt,$adt,$adi,$num,$a,$b,$c,$num_rows,$w)
	{
		//$w=$AdSizeWt+$adt+$adi+$num;
		//echo "size:",$size;
		if($w>=$a[$num_rows-1])
		{
		echo " [ > ",$a[$num_rows-1],"] : ";
		return $c[$num_rows-1];
		}
		for($i=0; $i<$num_rows; $i++)
		{
		if($w>=$a[$i] && $w<=$b[$i])
		{
		echo " [",$a[$i],"-",$b[$i],"] : ";
		return $c[$i];
		}
		//i++;
		}
	}

	function cat_rang($AdSizeWt,$adt,$adi,$num,$a,$b,$c,$num_rows,$w)
	{
		//$w=$AdSizeWt+$adt+$adi+$num;
		//echo "size:",$size;
		if($w>=$a[$num_rows-1])
		{
		//echo " [ > ",$a[$num_rows-1],"] : ";
		return $c[$num_rows-1];
		}
		for($i=0; $i<$num_rows; $i++)
		{
		if($w>=$a[$i] && $w<=$b[$i])
		{
		//echo " [",$a[$i],"-",$b[$i],"] : ";
		return $c[$i];
		}
		//i++;
		}
	}

	$category = cat_rang($AdSizeWt,$adtypewt,$adinstwt,$weightage,$a,$b,$c,$num_rows,$w);
	//echo "CATEGORY : ".$category;
	echo"CATEGORY : ",rang($AdSizeWt,$adtypewt,$adinstwt,$weightage,$a,$b,$c,$num_rows,$w);

?>

<form name="myform" action="index.php/designer/home/upload" method="post">
<div style="padding-top: 5px;">
<input  type="submit" name="confirm" id="confirm" value="Confirm">
<a href="http://www.adwitads.com/weborders/index.php/designer/home/category"><input id="button" type="button" name="button" value="Reset"></a>
</div>
<div style="display: none;">
<input type="text" name="order" value="<?php echo($order_no)?>" readonly style="visibility:hidden" />
<input name="job" value="<?php echo($job_name)?>" readonly style="visibility:hidden" />
<input name="swt" value="<?php echo($AdSizeWt)?>" readonly style="visibility:hidden" />
<input name="twt" value="<?php echo($adtypewt)?>" readonly style="visibility:hidden"/>
<input name="iwt" value="<?php echo($adinstwt)?>" readonly style="visibility:hidden" />
<input name="wtg" value="<?php echo($weightage)?>" readonly style="visibility:hidden" />
<input name="totwt" value="<?php echo($w)?>" readonly style="visibility:hidden" />
<input name="cat" value="<?php echo($category)?>" readonly style="visibility:hidden" />
<input name="width" value="<?php echo($width)?>" readonly style="visibility:hidden" />
<input name="height" value="<?php echo($height)?>" readonly style="visibility:hidden" />
<input name="num_pages" value="<?php echo($pages)?>" readonly style="visibility:hidden" />
<input name="num_img_prov" value="<?php echo($no_imgs_prov)?>" readonly style="visibility:hidden" />
<input name="num_img_src" value="<?php echo($no_imgs_src)?>" readonly style="visibility:hidden" />
<input name="design_type" value="<?php echo($type)?>" readonly style="visibility:hidden" />
<input name="initial" value="<?php echo($initial)?>" readonly style="visibility:hidden" />
<input name="slug_type" value="<?php echo($slug_type)?>" readonly style="visibility:hidden" />
</div>

</form>
</div>
<?php

}


?>
  </div>
  
  
  
<?php
	$this->load->view("designer/footer");
?>









