<?php
	$this->load->view("csr/header");
?>

<link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
<link href="theme001/vendors/jGrowl/jquery.jgrowl.css" rel="stylesheet" media="screen">

<div id="Middle-Div">
<?php echo '<h4 style="color:#900;">'.$this->session->flashdata('message').'</h4>'; ?>

 <div id="slug-view">
    <h2>QA TOOL</h2>
    <p><label for="name">Order Id</label></p>
    <input type="text" name="id" id="id" value="<?php echo $order_id; ?>" readonly />
    <p>&nbsp;</p>
  
    <div id="slug-created">
		<?php if(isset($slug)) echo "<p>".$slug."</p>";	?>
	</div>
 </div>
    
    <div id="dp-view"> 
		<form name="form1" method="post" > 

<h3 style="padding:0; padding-bottom: 5px; padding-top:20px; margin: 0; font-size: 18px;">Select one of the following:</h3>
	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '1', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '2', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>
    

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '3', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '4', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '5', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '6', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '7', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>
    

	<?php
		$dp_error= $this->db->get_where('dp_error',array('group' => '8', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<span style="font-size: 12px; color: #999; font-weight: normal;">(<a href="#designErrors" data-toggle="modal" style="text-decoration: none; color: #999; outline: none;">Help</a>)</span>'.'<br/>';
		}
	?>
	
	<?php
		$dp_error= $this->db->get_where('dp_error',array('type' => '5', 'status'=>'1'))->result_array();
		foreach($dp_error as $row)
		{
			echo '<input type="checkbox" name="error[]" value="'.$row["id"].'">'."&nbsp;&nbsp;&nbsp;".$row["name"].'<br/>';
		}
	?>
		<div id="slug-btn">
        <input type="submit" name="end_time" id="end_time" value="Submit" onclick="return confirm('Are you sure you want to end the job?');" />
    	</div>
       
		
		</form>
	
	</div>
    <div id="designErrors" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">&times;</button>
        <h4 style="padding:0; margin:0;">Design Errors</h4>
      </div>
      <div class="modal-body">
        <p style="padding-top:5px;"><b>1. No Design Uniformity (Multi-listing)  - Minor</b></p>
        <ul>
        	<li>Criteria for judging Design in Multi listing ad is uniformity and consistencies in formatting text and images in the ad.</li>
<li>Font sizes, color, and placement of copy should be uniform.</li>
<li>When Template is provided for styling - the fonts, colors, sizes should be strictly followed.</li>
        </ul>
         <p style="padding-top:5px;"><b>2. Alignment Rhythm- Minor</b></p>
        <ul>
        	<li>The Center, Right, Left, Justified alignments used for the the copy and info should have uniformity.</li>
<li>The size of the ad and images used determine the alignments to be used in the ad.</li>
<li>Text that is out of bounds in the ad is an alignment error.</li>
<li>The indentations for text should be uniform.	</li>
<p>Exception: Not applicable for pickup and customer supplied Ads</p>
        </ul>
         <p style="padding-top:5px;"><b>3. Too many Fonts (if More than 3 fonts) - Minor</b></p>
        <ul>
        	<li>There should not be more than 3 different fonts in the entire ad.</li>
			<li>Different Font style that belongs to the same font family can be used (For Ex. Regular, Bold, Bold condensed).</li>
            <p><em>Exception: Not applicable for pickup and customer supplied Ads</em></p>
            <p><em>* Fonts not matched to pick up will not be considered an error. In most cases the designer will try to match the closest font available.
If in doubt please check with Design Team lead. </em></p>
        </ul>
        <p style="padding-top:5px;"><b>4. Wrong Pickup ad or Wrong Version - Major</b></p>
        <ul>
        	<li> It is a mandatory to use the specified pick up ad mentioned in the order form.</li>
<li>The latest version of the mentioned ad or the ad as specified by the customer in the order form should be used to make changes to the ad.</li>
<li>The ad is completely wrong if a wrong pick up ad is used.</li>
</li>
        </ul>
         <p style="padding-top:5px;"><b>5. White Space Balance - Minor</b></p>
        <ul>
         	<li> There should not be any odd spaces in the ad.</li>
<li>As a general rule, the text and pictures/images used in the ad should be well balanced.</li>
<li>There are no specific rules to be followed for spacing.</li>
<li>Judging an error on white space is subjective. Please check with the Design Team lead if you are unsure.</li>
<p><em>Exception: Not applicable for pickup and customer supplied Ads</em>
</p>
        </ul>
      </div>
    </div>
    <div id="visualErrors" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">&times;</button>
        <h4 style="padding:0; margin:0;">Visual Errors</h4>
      </div>
      <div class="modal-body">
        <p style="padding-top:5px;"><b>1. Mixing of Raster and Vector Images:</b></p>
        <ul>
        	<li>Usage of both Raster & Vector images in an ad is not advisable</li>
<li>Raster Images are in variety of formats as ".tiff and .jpg "</li>
<li>Vector Images have no fixed resolution, these images are based on geometrical patterns and the format is ".eps"</li>
        </ul>
         <p style="padding-top:5px;"><b>2. Poor Image Cut out</b></p>
        <ul>
        	<li>The white space around the image after cropping should be cropped.</li>
<li>After cropping the image has to blend with the background.</li>
        </ul>
         <p style="padding-top:5px;"><b>3. Wrong Color Mode</b></p>
        <ul>
        	<li>CMYK is the preferred color mode for the print ads. (RGB Color Mode - Error)</li>
			<li>Spot color & Pantone color modes are used upon customer request.</li>
            <li>RGB color mode is only for web ads. </li>
        </ul>
        <p style="padding-top:5px;"><b>4. Wrong Image Selection</b></p>
        <ul>
        	<li>Image selected for the ad should go along with the subject to be focused/ highlighted in the ad.</li>
            <p><em>Example:  An Image of woman in her tracksuit can't be used for an ad which focuses on Shopping.</em></p>
        </ul>
         <p style="padding-top:5px;"><b>5. Wrong Theme</b></p>
        <ul>
         	<li> The theme for the ad should be as per customer request.</li>
<p><em>Example:  Customer might request for a winter themed ad but it might not necessarily be Christmas themed Instructions should be followed accordingly. If Christmas theme is used for a winter themed ad is an error.</em>
</p>
</ul>
 <p style="padding-top:5px;"><b>6. Image Missing</b></p>
        <ul>
         	<li>It is an error if the image has not been linked properly and Image is not found in the ad</li>
            <li>Image to be provided later by the client or image not provided is not considered an error</li>
        </ul>
 <p style="padding-top:5px;"><b>7. Wrong Logo</b></p>
        <ul>
         	<li>The logo provided by client should be used as is in the ad unless the client has specifically asked the logo to be rebuilt</li>
            <li>The correct logo of the business should be used in the ad when the logo is sourced from the internet.</li>
                    <p><em>Example:  If logo for an ad spells "Hy- Vee Drug Store" and the logo used in the ad is “Hy- Vee Stores", it is considered as a logo error.</em></p>
        </ul>
      </div>
    </div>
    <div id="textErrors" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">&times;</button>
        <h4 style="padding:0; margin:0;">Text Errors</h4>
      </div>
      <div class="modal-body">
        <p style="padding-top:5px;"><b>1. Missing a word – Minor</b></p>
        <ul>
        	<li>Missing a word makes the whole sentence incomplete and does not make any sense to the reader</li>
<li>All of the copy provided by the client meant to be used in the ad should be included. </li>
        </ul>
         <p style="padding-top:5px;"><b>2. Missing more than a word – Major</b></p>
        <ul>
        	<li>Every word is important in an ad and if more than a word is missed then the purpose of the whole ad is not met.</li>
<li>The sentence/message will be incomplete when words are missing from the copy. </li>
<li>A good design is rendered incomplete when copy is missing from the ad.</li>
        </ul>
         <p style="padding-top:5px;"><b>3. Adding irrelevant word – Minor</b></p>
        <ul>
        	<li>Adding irrelevant word can happen while copying the text from some other source or while typing the text.</li>
			<li>Additional and unrelated text cannot be included in the ad. </li>
        </ul>
        <p style="padding-top:5px;"><b>4. Adding irrelevant text, more than a word – Major</b></p>
        <ul>
        	<li>The message of the ad will be distorted and this error is unacceptable.</li>
            <li>Additional and unrelated text cannot be included in the ad. </li>
        </ul>
         <p style="padding-top:5px;"><b>5. Wrong Theme</b></p>
        <ul>
         	<li> The theme for the ad should be as per customer request.</li>
<p><em>Example:  Customer might request for a winter themed ad but it might not necessarily be Christmas themed Instructions should be followed accordingly. If Christmas theme is used for a winter themed ad is an error.</em>
</p>
</ul>
 <p style="padding-top:5px;"><b>6. Image Missing</b></p>
        <ul>
         	<li>It is an error if the image has not been linked properly and Image is not found in the ad</li>
            <li>Image to be provided later by the client or image not provided is not considered an error</li>
        </ul>
 <p style="padding-top:5px;"><b>7. Wrong Logo</b></p>
        <ul>
         	<li>The logo provided by client should be used as is in the ad unless the client has specifically asked the logo to be rebuilt</li>
            <li>The correct logo of the business should be used in the ad when the logo is sourced from the internet.</li>
                    <p><em>Example:  If logo for an ad spells "Hy- Vee Drug Store" and the logo used in the ad is “Hy- Vee Stores", it is considered as a logo error.</em></p>
        </ul>
      </div>
    </div>
    <div id="instructionErrors" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">&times;</button>
        <h4 style="padding:0; margin:0;">Instruction Errors</h4>
      </div>
      <div class="modal-body">
        <p style="padding-top:5px;"><b>1. Size - Major Error</b></p>
        <ul>
        	<li>The ad size should be exactly as indicated on the order form. </li>
<li>Bleed sizes should be accurately followed, otherwise parts of the ad might get cut off when printed. The size mentioned on the order form should be followed to point precision.  </li>
        </ul>
         <p style="padding-top:5px;"><b>2. Color Type - Major Error </b></p>
        <ul>
        	<li>Color - The ad should be designed in full color. All the colors used except black should be a combination of CMYK.</li>
<li>B/W - Only black and white is used. Text and images used should be a 100% Black and not a combination of CMYK</li>
<li>Spot - Only 1 color is used predominantly in the ad. </li>
<p><em>Example: If we have been asked to use Spot Red and not a combination of CMYK. The photographs used in the ad will be in Black & White.</em></p>
<p><em>*CMYK = Cyan Magenta Yellow Blac</em>k</p>
        </ul>
         <p style="padding-top:5px;"><b>3. Preference on color - Minor Error</b></p>
        <ul>
        	<li>If the customer wants us to use a specific color in the ad, we have to design the ad using the same color preference. </li>
			<li>We cannot use either one of the colors, nor can we use any other color; like yellow or green as a combination.</li>
            <p><em>Example: If the color preference says “Use Red, White and Blue” the designer has to only use these colors dominantly in the ad.</em></p>
        </ul>
        <p style="padding-top:5px;"><b>4. Preference on font - Minor Error</b></p>
        <ul>
        	<li>If the customer specifically requests for a particular font to be used, the instructions for the usage of font must be followed. </li>
            <p><em>Example: If the font preference says “Use Edwardian Script”, this particular font has to be used in the ad in an attractive way.</em></p>
            <p><em>Exception: It is not necessary that all the text in the ad should be in this font style. A complementary font can be used to make the ad look appealing.</em></p>
        </ul>
         <p style="padding-top:5px;"><b>5. Use art without change or as provided - Major Error</b></p>
        <ul>
         	<li>The customer will provide us with artwork that needs to be used in the ad without any alterations.</li>
            <li>Where Instructions for use of artwork is provided it should be used without making any changes to the material given to us.</li>
<p><em>Example: Should not be compressed and stretched. </em></p>
</ul>
 <p style="padding-top:5px;"><b>6. Job type instruction (wrong Job type) - Major Error</b></p>
        <ul>
         	<li>There are 5 Job Types - Be Creative-Sophisticated, Be Creative-Edgy, Be Creative-Standard, Non-Photo & Follow Instructions Carefully. </li>
            <li>Each of the Job type has specific design guidelines that need to be followed to achieve the desired quality. </li>
            <p><em>Example: If the Job Type requested is “Be Creative Sophisticated” and the designer has created a “Non-Photo” ad, it becomes a Major Error.</em></p>
        </ul>
 <p style="padding-top:5px;"><b>7. Copy/Content Instructions - Major Error</b></p>
        <ul>
         	<li>Customers often provide us with instructions for use of text in the ad.</li>
                    <p><em>Examples:
 “Make the offer stand out” or a detailed set of instructions like “The Headline should be Helvetica Lt Std Black 15pt in navy blue color. The Subheadline should be Helvetica Lt Std Roman 10pt in cherry red. The line spacing should be 10”.</em></p>
        </ul>
 <p style="padding-top:5px;"><b>8. Notes & Instructions (Small Instruction missed) - Minor Error</b></p>
        <ul>
         	<li>The customer often provide us with “Notes & Instructions” that help us understand what exactly he is looking for. </li>
            <li>Not following these instructions completely might not affect the ad design but will still be a minor error as it is not what the customer asked for. </li>
                    <p><em>Example: “The offer should be have a dashed line outline with a scissor along the border”, but the designer has not used the scissor art, it becomes a minor error. </em></p>
                    <p><em>Exception: In multi-listing ads or ads with complicated instructions, if the designer has followed all the instructions but missed one instruction, it is taken as a Minor Error.</em></p>
        </ul>
 <p style="padding-top:5px;"><b>9. Notes & Instructions (Important Instruction not followed) - Major Error</b></p>
        <ul>
         	<li>Not following important instructions will have a direct impact on the ad design. </li>
            <li>Important instructions are when the ad is incomplete and the basic expectations for the design of the ad are not met</li>
                    <p><em>Example: “Please use the attached photo as the layout that I would like to use. It is meant for guidance for design.” If the designed layout is completely different than the template provided, it becomes a Major Error.</em></p>
        </ul>
      </div>
    </div>
</div>

<script src="theme001/vendors/jquery-1.9.1.min.js"></script> 
<script src="theme001/bootstrap/js/bootstrap.min.js"></script> 
<script src="theme001/vendors/jGrowl/jquery.jgrowl.js"></script> 
<script src="theme001/assets/scripts.js"></script>
<script>
var lastChecked = null;
    
            $(document).ready(function() {
                var $chkboxes = $('.chkbox');
                $chkboxes.click(function(e) {
                    if(!lastChecked) {
                        lastChecked = this;
                        return;
                    }
    
                    if(e.shiftKey) {
                        var start = $chkboxes.index(this);
                        var end = $chkboxes.index(lastChecked);

                        $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
    
                    }
    
                    lastChecked = this;
                });
            });
	
</script>
<?php
	$this->load->view("csr/footer");
?>