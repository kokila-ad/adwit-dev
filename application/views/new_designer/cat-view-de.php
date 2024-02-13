<?php
	$this->load->view("designer/header");
?>

  
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
 
</script>

  


<style>
input {
	border: none;
	outline: none;
	padding: 5px;
}
select {
	border: none;
	outline: none;
	padding: 5px;
	width: 100%;
}
</style>


<div id="Middle-Div">
   <div id="form">
<?php //echo validation_errors(); ?>
<form name="form" method="post">
  <table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style="width:800px; background-color:#e9e9e9; border-radius: 5px;">
   <tr>
   
   </tr>
   <td style="width: 75px;"><p style="font-size: 18px; font-family: Tahoma, Geneva, sans-serif; padding: 10px;">Category Tool</p></td>
    <tr>
      <td><table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style="width:775px;">
          <tr>
            <td style="width:150px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Order No</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
                <input name="order_no" type="text" value="<?php echo set_value('order_no');?>" style="width:100%;">
              </p></td>
            <td style="width: 75px;">&nbsp;</td>
            <td style="width:150px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Job Name</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
                <input name="job_name" type="text" value="<?php echo set_value('job_name');?>" style="width:100%;">
              </p></td>
          </tr>
          <tr>
            <td colspan="5"><img src="images/spacer.jpg"/></td>
          </tr>
          <tr>
            <td><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Width</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
                <input value="<?php echo set_value('w');?>" onChange="fill()"  id="w" name="w" size="10"   style="width:100%;"/>
              </p></td>
            <td>&nbsp;</td>
            <td><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Height</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
                <input onChange="fill()"  id="h" name="h" value="<?php echo set_value('h');?>" size="10" style="width:100%;"/>
              </p></td>
          </tr>
          <tr>
            <td colspan="5"><img src="images/spacer.jpg"/></td>
          </tr>
          <tr>
            <td><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Size</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
                <input id=size name="size" value="<?php echo set_value('size');?>" size="10" readonly style="width:100%;"/>
              </p></td>
            <td>&nbsp;</td>
            <td><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">No of Pages</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
 
	<select id="no_pages" name="no_pages" >

   	<option value="1" <?php echo set_select('no_pages', '1');?> >1</option>
	<option value="2" <?php echo set_select('no_pages', '2');?> >2</option>
	<option value="3" <?php echo set_select('no_pages', '3');?> >3</option>
	<option value="4" <?php echo set_select('no_pages', '4');?> >4</option>
	<option value="5" <?php echo set_select('no_pages', '5');?> >5</option>      
         
    </select>              


			 </p></td>
          </tr>
                    <tr>
            <td colspan="5"><img src="images/spacer.jpg"/></td>
          </tr>          
			<tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
          	<td colspan="5"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Ad Type :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

  <?php
		
		$results = $this->db->get('cat_adtype')->result_array();
		
		foreach($results as $result)
					{
	
echo '<input type="radio" name="adtype" id="adtype" value="'.$result['weightage'].'" '.set_radio('adtype',$result['weightage']).' onClick="run(this.value);" required="required" ><label>'.$result['adtype'].'</label>';
      
 echo ' &nbsp;&nbsp;&nbsp';
					}
 ?>                   
     
  &nbsp;&nbsp;&nbsp;
          
  
      
    </p></td>
          </tr>
          <tr>
            <td colspan="5"><img src="images/spacer.jpg"/></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
          	<td colspan="5"> 
            <p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">         
                Ad Inst :&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
		
$results = $this->db->get('cat_adinstruction')->result_array();
		
foreach($results as $result)
{
	
echo '<input type="radio" name="adinst" id="adinst" value="'.$result['adinstwt'].'" '.set_radio('adinst',$result['adinstwt']).' onClick="run1(this.value);" required="required"><label>'.$result['adinst'].'</label>';
      
 echo '&nbsp;&nbsp;&nbsp';
}
?>         
       
              &nbsp;&nbsp;
                
          
               
 </p></td>
          </tr>
<tr>
            <td colspan="5">&nbsp;</td>
          </tr>
           <tr>
           <td colspan="5"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Design Type :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   
	 <input type="radio" name="design_type" id="design_type" value="0.5" <?php echo set_radio('design_type', '0.5'); ?> onMouseDown="this.__chk = this.checked" onClick="if (this.__chk) this.checked = false" required="required">&nbsp;<label>Standard</label>&nbsp;&nbsp;&nbsp;
	 <input type="radio" name="design_type" id="design_type" value="0.6" <?php echo set_radio('design_type', '0.6'); ?> onMouseDown="this.__chk = this.checked" onClick="if (this.__chk) this.checked = false" required="required" >&nbsp;<label>Multilisting</label>&nbsp;
   
		   
		   <?php
	/*	
$results = $this->db->get('design_type')->result_array();
		
foreach($results as $result)
{
	
echo '<input type="radio" name="design_type" id="design_type" value="'.$result['value'].'" '.set_radio('design_type',$result['value']).'  required="required"><label>'.$result['name'].'</label>';
      
 echo '&nbsp;&nbsp;&nbsp';
}*/
?>      
		   
		   
		   </p></td>          	
          
		  </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
                      
          
          
 <tr>
<td colspan="5"><img src="images/spacer.jpg"/></td> 
  </tr>          
<tr style="vertical-align: top;">
            <td><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000; ">No. of Images provided</p></td>
            <td style="width:200px;"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#000;">
                <input onChange="" name="no_img" id="no_img" value="<?php echo set_value("no_img"); ?>" size="10" style="width:100%;"/>
</p></td>

<td>&nbsp;</td>

<td><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Number of Images source</p>
</td>
<td style="width:200px;">
<input onChange="" id="imgmax" name="imgmax" value="<?php echo set_value("imgmax");?>" size="10" style="width:100%;"/></td>
    </tr>
              <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
    <tr>
    	<td align="center" colspan="5"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:18px; color:#000;"><input type="submit" name="submit1" value="SUBMIT" style=" cursor: pointer; background-color:#000; color:#FFF; padding:3px 6px 3px 6px;" class="submit">&nbsp;&nbsp;
        <a href="http://www.adwitads.com/weborders/index.php/designer/home/category"><input type="button" name="Reset" value="RESET" style=" cursor: pointer; background-color:#000; color:#FFF; padding:3px 6px 3px 6px;"></a></p></td>
    </tr>
    <tr>
    
    	<td colspan="5"><input id="adtw" name="adtw" value="<?php echo set_value('adtw');?>" size="10" readonly style="visibility:hidden"  /><input id="adiw" name="adiw" value="<?php echo set_value('adiw');?>" readonly style="visibility:hidden" ><input value="8" id="imgwt" name="imgwt" readonly style="visibility:hidden" /><input id="size1" name="img_wt" value="15" readonly style="visibility:hidden"  /></td>
    </tr>
  </table>
  
  </td>
  </tr>
  </table>
</form>


</div>

<table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style="width:700px;">
<tr>
            <td colspan="5" align="center"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; color:#000; padding-bottom:10px; ">
            
            
            
            
            
            
<?php
if(isset($_POST["design_type"]))
{
$order_no=$_POST['order_no'];
$job_name=$_POST['job_name'];
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

<form name="myform" action="index.php/designer/home/category" method="post">
<tr>
<td align="center" colspan="5"><p style="font-family:Tahoma, Geneva, sans-serif; font-size:18px; color:#000;"><input  type="submit" name="confirm" id="confirm" value="confirm">
<a href="http://www.adwitads.com/weborders/index.php/designer/home/category"><input id="button" type="button" name="button" value="reset"></a></p>
</td></tr>

<input type="text" name="order" value="<?php echo($order_no)?>" readonly style="visibility:hidden" />
<input name="job" value="<?php echo($job_name)?>" readonly style="visibility:hidden" />
<input name="swt" value="<?php echo($AdSizeWt)?>" readonly style="visibility:hidden" />
<input name="twt" value="<?php echo($adtypewt)?>" readonly style="visibility:hidden"/>
<input name="iwt" value="<?php echo($adinstwt)?>" readonly style="visibility:hidden" />
<input name="wtg" value="<?php echo($weightage)?>" readonly style="visibility:hidden" />
<input name="totwt" value="<?php echo($w)?>" readonly style="visibility:hidden" />
<input name="cat" value="<?php echo($category)?>" readonly style="visibility:hidden" />


</form>
<?php

}


?>

</p></td>
          </tr>
</table>
  </div>





<?php
	$this->load->view("designer/footer");
?>









