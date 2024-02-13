<?php $this->load->view('new_csr/head'); ?>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css'>

<!-- multiple size select css -->

<style>
    .dropdown-check-list {
      display: block;
    }
    .dropdown-check-list .anchor {
      position: relative;
      cursor: pointer;
      display: block;
      padding: 5px 50px 5px 10px;
      border: 1px solid #ccc;
    }
    .dropdown-check-list .anchor:after {
      position: absolute;
      content: "";
      border-left: 2px solid black;
      border-top: 2px solid black;
      padding: 5px;
      right: 10px;
      top: 20%;
      -moz-transform: rotate(-135deg);
      -ms-transform: rotate(-135deg);
      -o-transform: rotate(-135deg);
      -webkit-transform: rotate(-135deg);
      transform: rotate(-135deg);
    }
    .dropdown-check-list .anchor:active:after {
      right: 8px;
      top: 21%;
    }
    .dropdown-check-list ul.items {
      padding: 2px;
      display: none;
      margin: 0;
      border: 1px solid #ccc;
      border-top: none;
    }
    .dropdown-check-list ul.items li {
      list-style: none;
    }
    .checkbox_check{
    margin-right: 10px !important;
    margin-left: 10px !important;
        margin-top: 5px !important;
    }
    span.ui-icon.ui-icon-circle-triangle-w {
        -webkit-transition: none !important;
        transition: none;
    }
    .ui-datepicker-inline.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
    display:none !important;
    }
    td.ui-datepicker-unselectable.ui-state-disabled {
        color: #d4d4d4;
    }
    a.ui-state-default.ui-state-highlight.ui-state-active, a.ui-state-default.ui-state-active {
       background-color: grey;
        color: white;   
    }
    .ui-datepicker { width: 17em; padding: .2em .2em 0; display: none;background-color: white;
        border: 1px solid #c1c1c1; }
    .ui-datepicker .ui-datepicker-header { position:relative; padding:.2em 0; }
    .ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { position:absolute; top: 10px; width: 1.8em; height: 1.8em; }
    .ui-datepicker, .ui-datepicker .ui-datepicker-next-hover { //top: 1px; }
    .ui-datepicker .ui-datepicker-prev { //left:2px; }
    .ui-datepicker .ui-datepicker-next { right:2px; }
    .ui-datepicker .ui-datepicker-prev-hover { //left:1px; }
    .ui-datepicker .ui-datepicker-next-hover { //right:1px; }
    .ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span {     display: block;
        position: absolute;
        left: 50%;
        margin-left: -14px;
        top: 20%;
        background-color: #333333;
        color: white;
        padding: 1px;
        font-size: 15px;
        cursor: pointer;
        margin-top: -8px;  }
    .ui-datepicker .ui-datepicker-title { margin: 0 2.3em; line-height: 1.8em; text-align: center; }
    .ui-datepicker .ui-datepicker-title select { font-size:1em; margin:1px 0; }
    .ui-datepicker select.ui-datepicker-month-year {width: 100%;}
    .ui-datepicker select.ui-datepicker-month, 
    .ui-datepicker select.ui-datepicker-year { width: 49%;}
    .ui-datepicker table {width: 100%; font-size: .9em; border-collapse: collapse; margin:0 0 .4em; }
    .ui-datepicker th { padding: .7em .3em; text-align: center; font-weight: bold; border: 0;  }
    .ui-datepicker td { border: 0; padding: 1px; }
    .ui-datepicker td span, .ui-datepicker td a { display: block; padding: .2em; text-align: center; text-decoration: none; }
    .ui-datepicker .ui-datepicker-buttonpane { background-image: none; margin: .7em 0 0 0; padding:0 .2em; border-left: 0; border-right: 0; border-bottom: 0; }
    .ui-datepicker .ui-datepicker-buttonpane button { float: right; margin: .5em .2em .4em; cursor: pointer; padding: .2em .6em .3em .6em; width:auto; overflow:visible; }
    .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current { float:left; }
    
    /* with multiple calendars */
    .ui-datepicker.ui-datepicker-multi { width:auto; }
    .ui-datepicker-multi .ui-datepicker-group { float:left; }
    .ui-datepicker-multi .ui-datepicker-group table { width:95%; margin:0 auto .4em; }
    .ui-datepicker-multi-2 .ui-datepicker-group { width:50%; }
    .ui-datepicker-multi-3 .ui-datepicker-group { width:33.3%; }
    .ui-datepicker-multi-4 .ui-datepicker-group { width:25%; }
    .ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header { border-left-width:0; }
    .ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header { border-left-width:0; }
    .ui-datepicker-multi .ui-datepicker-buttonpane { clear:left; }
    .ui-datepicker-row-break { clear:both; width:100%; font-size:0em; }
    
    /* RTL support */
    .ui-datepicker-rtl { direction: rtl; }
    .ui-datepicker-rtl .ui-datepicker-prev { right: 2px; left: auto; }
    .ui-datepicker-rtl .ui-datepicker-next { left: 2px; right: auto; }
    .ui-datepicker-rtl .ui-datepicker-prev:hover { right: 1px; left: auto; }
    .ui-datepicker-rtl .ui-datepicker-next:hover { left: 1px; right: auto; }
    .ui-datepicker-rtl .ui-datepicker-buttonpane { clear:right; }
    .ui-datepicker-rtl .ui-datepicker-buttonpane button { float: left; }
    .ui-datepicker-rtl .ui-datepicker-buttonpane button.ui-datepicker-current { float:right; }
    .ui-datepicker-rtl .ui-datepicker-group { float:right; }
    .ui-datepicker-rtl .ui-datepicker-group-last .ui-datepicker-header { border-right-width:0; border-left-width:1px; }
    .ui-datepicker-rtl .ui-datepicker-group-middle .ui-datepicker-header { border-right-width:0; border-left-width:1px; }
    
    /* IE6 IFRAME FIX (taken from datepicker 1.5.3 */
    .ui-datepicker-cover {
        display: none; /*sorry for IE5*/
        display/**/: block; /*sorry for IE5*/
        position: absolute; /*must have*/
        z-index: -1; /*must have*/
        filter: mask(); /*must have*/
        top: -4px; /*must have*/
        left: -4px; /*must have*/
        width: 200px; /*must have*/
        height: 200px; /*must have*/
    }/*

</style>  
<style>
    .active > a{
        color: #d71a22 !important;
        border-color: #333;
        background: #e1e1e100 !important;
    }
	.ui.dropdown:not(.button)>.default.text {
        color: rgba(82, 82, 82, 0.87);
    }
    .ui.selection.dropdown{
    border: 1px solid rgb(193, 193, 193);
        border-radius: 0;
    }
      .customer_records{
      display:none;
    }
    .remove {
        padding: 0px 10px 25px 0px;
        position: relative;
        top: 5px;
    }
    a.btn.red-sunglo.btn-link.btn-xs.extra-fields-customer {
        background-color: grey;
        color: white;
        margin-bottom: 6px;
    }
      .customer_records1{
      display:none;
    }
    .remove1{
        padding: 5px 15px 10px 0px;
    }
    a.btn.red-sunglo.btn-link.btn-xs.extra-fields-customer1 {
        background-color: grey;
        color: white;
        margin-bottom: 6px;
    }
    a.remove-field.btn-remove-customer {
        position: relative;
        top: 5px;
    }
    
</style>
<!-- multiple size select css END--> 

<div class="page-container">
	<div class="page-content">
		<div class="container">
		    <div class="portlet-body margin-top-10">
				<div class="row">
					<div class="col-md-6 col-sm-12">
					    <div class="portlet blue-hoki box">
					        <div class="portlet-title">
								<div class="caption">Order Info</div>
							</div>
							<div class="portlet-body">
							    <div class="row static-info margin-top-10">
									<div class="col-md-5 col-xs-5 name">Adwit ID:</div>
									<div class="col-md-7 col-xs-7 value word-break"><?php echo $order_detail['id'];?></div>
								</div>
								<div class="row static-info margin-top-10">
									<div class="col-md-5 col-xs-5 name">Unique Job Name:</div>
									<div class="col-md-7 col-xs-7 value word-break"><?php echo $order_detail['job_no'];?></div>
								</div>
								<div class="row static-info margin-top-10">
									<div class="col-md-5 col-xs-5 name">AdRep:</div>
									<div class="col-md-7 col-xs-7 value word-break"><?php echo $order_detail['adrepName'];?></div>
								</div>
								<div class="row static-info margin-top-10">
									<div class="col-md-5 col-xs-5 name">Publication:</div>
									<div class="col-md-7 col-xs-7 value word-break"><?php echo $order_detail['publicationName'];?></div>
								</div>
								<div class="row static-info margin-top-10">
									<div class="col-md-5 col-xs-5 name">Ad Format:</div>
									<div class="col-md-7 col-xs-7 value word-break">
									<?php 
									    $ad_format = $this->db->get_where('web_ad_formats',array('id' => $order_detail['ad_format']))->row_array();
									    echo $ad_format['name'];
									?>
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 col-xs-5 name">Ad Size:</div>
										<?php 
											if($order_detail['ad_format']=='5' && empty($order_detail['pixel_size'])){ //Flexitive ad
											    
    											if(isset($order_detail['flexitive_size']) && $order_detail['flexitive_size'] > 0){
    												$flexitive_size = $this->db->get_where('flexitive_size',array('id' => $order_detail['flexitive_size']))->row_array();
    												$fs = explode('x', $flexitive_size['ratio']);
    												
    												echo'<div class="col-md-3 col-xs-3 value">'.$flexitive_size['ratio'].'</div>';
    											}else{  //multiple size
                							        echo '<div class="col-md-7 col-xs-7 value ">';
                							        if(isset($orders_multiple_size[0]['id'])){
                							            foreach($orders_multiple_size as $msize){
                							                echo '<p>'.$msize['ratio'].'</p>';
                							            }
                							        }
    											    if(isset($orders_multiple_custom_size[0]['id'])){
    											        foreach($orders_multiple_custom_size as $mcsize){
    											            echo '<p>'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'</p>';
    											        }
    											    }
    											    echo '</div>';
    											}
										    
										    }else{
											
												if($order_detail['pixel_size']=='custom'){
										?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $order_detail['custom_width']; ?>
												</div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $order_detail['custom_height']; ?></div>
										<?php 	} elseif($order_detail['pixel_size'] != '') { 
												$size_px = $this->db->get_where('pixel_sizes',array('id'=>$order_detail['pixel_size']))->result_array();
											?>
												<div class="col-md-3 col-xs-3 value">W: <?php echo $size_px[0]['width']; ?></div>
												<div class="col-md-4 col-xs-4 value">H: <?php echo $size_px[0]['height']; ?></div>
										<?php 
											    }else{ //multiple size
                							         echo '<div class="col-md-7 col-xs-7 value ">';
                							        if(isset($orders_multiple_size[0]['id'])){
                							            foreach($orders_multiple_size as $msize){
                							                echo '<p>'.$msize['width'].' X '.$msize['height'].'</p>';
                							            }
                							        }
                								    if(isset($orders_multiple_custom_size[0]['id'])){
    											        foreach($orders_multiple_custom_size as $mcsize){
    											            echo '<p>'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'</p>';
    											        }
    											    }
    											    echo '</div>';
                								} 
											}
											
										?>
										</div>
							</div>
					    </div>
					</div>
					<div class="col-md-6 col-sm-12">
					    <div class="portlet blue-hoki box">
					        <div class="portlet-title">
								<div class="caption">Add Size</div>
							</div>
							<div class="portlet-body">
							    <form method="post">
							    <!--<div class="row static-info margin-top-10">
									<div class="col-md-12 col-xs-12 value word-break">
									    <p>Format<small class="text-grey">(select one)</small></p>
									    <div class="btn-group" data-toggle="buttons">
                        				<?php 
                        					$results = $this->db->get('web_ad_formats')->result_array();
                        					  foreach($results as $result){
                        				?>
                        							<label class="btn btn-sm btn-default margin-right-10 margin-bottom-10" onclick="ad_format(<?php echo $result['id']; ?>)">
                        								<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" required=""> 
                        								<?php echo $result['name']; ?>
                        							</label> 
                        				<?php } ?>
                            
                        				 </div>
								    </div>
								</div>-->
								<div class="row static-info margin-top-10">
								    <div class="col-md-12 col-xs-12 value word-break">
								        <div id="size-div" >    
    								        <p class="margin-bottom-5">
                                		       Size <span class="text-red">* </span><small id="size_unit" class="text-grey">(in Pixels)</small>
                                		       <a class="btn red-sunglo btn-link btn-xs  extra-fields-customer" style="float:right;" >
                                			    <span class="glyphicon glyphicon-plus"></span> Add Custom Size
                                			   </a>
                                		   </p>
                                		    <div class="inline field">
                                                <select name="size_id[]" id="size_id" multiple="" class="form-control label ui selection fluid dropdown">
                                                    <?php  
                                					   $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
                                					    foreach($pixel_sizes as $row){
                                					?>
                                						<option value="<?php echo $row['id']; ?>" ><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>
                                					 <?php } ?>
                                				  
                        					    </select>
                                            </div>
                			
                        			        <div id="list1" class="dropdown-check-list checkbox-group required" tabindex="100" style="display:none;">
                                                <span class="anchor">Select</span>
                                                <ul id="items" class="items" >
                        	                        
                                                </ul>
                                            </div>
                                            <div class="">
                                				<div class="customer_records">
                                                    <div class="col-md-5 col-xs-3 value margin-bottom-10">  
                                                        <input type="number" pattern="[1-9]{1,50}" min="1" name="custom_width[]" class="col-md-12 decimal form-control input-sm custom_width"  placeholder="width">
                                                    </div>
                                  	                <div class="col-md-5 col-xs-4 value margin-bottom-10">  
                                  	                    <input type="number" pattern="[1-9]{1,50}" min="1" name="custom_height[]" class="col-md-12 decimal form-control input-sm custom_height"  placeholder="height">
                                  	                </div>
                                                </div>
                                                <div class="customer_records_dynamic"></div>  
                                            </div>
                            		   </div>
								    </div>    
								</div>
								<div class="row static-info margin-top-10">
								    <div class="col-md-12 col-xs-12 value word-break">
								        <button class="btn btn-sm btn-primary pull-right" name="add_size" type="submit">SUBMIT</button>
								    </div>
								</div>
								</form>
							</div>
					    
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- multiple size -->
<script src='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js'></script>

<script>
    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.visibility = 'visible';
        }
        else document.getElementById('ifYes').style.visibility = 'hidden';
    
    }
    			//decimal number restriction
    $(function() {
      $('.decimal').on('input', function() {
        this.value = this.value
          .replace(/[^\d]/g, '')             // numbers and decimals only
          .replace(/(^[\d]{4})[\d]/g, '$1')   // not more than 2 digits at the beginning
       
      });
    });

    $('.datepickerautoff').on('click', function(e) {
				e.preventDefault();
				$(this).attr("autocomplete", "off");  
			});

		jQuery(document).ready(function() {       
		FormValidation.init();
	});
	
    $('.extra-fields-customer').click(function() {
      $('.customer_records').clone().appendTo('.customer_records_dynamic');
      $('.customer_records_dynamic .customer_records').addClass('single remove');
      $('.single .extra-fields-customer').remove();
      $('.single').append('<a href="#" class="remove-field btn-remove-customer">X</a>');
      $('.customer_records_dynamic > .single').attr("class", "remove");
    
      $('.customer_records_dynamic input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        $(this).attr('required', 'required'); // add required
        count++;
      });
    
    });
    
    $(document).on('click', '.remove-field', function(e) {
      $(this).parent('.remove').remove();
      e.preventDefault();
    });
    
    /*
    $('.extra-fields-customer1').click(function() {
      $('.customer_records').clone().appendTo('.customer_records_dynamic1');
      $('.customer_records_dynamic1 .customer_records').addClass('single remove');
      $('.single .extra-fields-customer1').remove();
      $('.single').append('<a href="#" class="remove-field btn-remove-customer">X</a>');
      $('.customer_records_dynamic1 > .single').attr("class", "remove");
    
      $('.customer_records_dynamic1 input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        
        count++;
      });
    
    });
    
    $(document).on('click', '.remove-field', function(e) {
      $(this).parent('.remove1').remove();
      e.preventDefault();
    });
    */
	
    var checkList = document.getElementById('list1');
    var items = document.getElementById('items');
    checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
      if (items.classList.contains('visible')) {
        items.classList.remove('visible');
        items.style.display = "none";
      } else {
        items.classList.add('visible');
        items.style.display = "block";
      }
    
    }
    /*
    var checkList = document.getElementById('list2');
    var items2 = document.getElementById('items2');
    checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
      if (items2.classList.contains('visible')) {
        items2.classList.remove('visible');
        items2.style.display = "none";
      } else {
        items2.classList.add('visible');
        items2.style.display = "block";
      }
    
    }
    items2.onblur = function(evt) {
      items2.classList.remove('visible');
    }
    */
    items.onblur = function(evt) {
      items.classList.remove('visible');
    }
    
    $('.label.ui.dropdown')
      .dropdown();
    
    $('.no.label.ui.dropdown')
      .dropdown({
      useLabels: false
    });
    
    $('.ui.button').on('click', function () {
      $('.ui.dropdown')
        .dropdown('restore defaults')
    });
</script>
<script src="http://code.jquery.com/jquery.js"></script>
<script>
    function ad_format(id){
	    //$('#size-div').show();
		$('#size_id').val('');
		$(".item").removeClass("filtered"); $(".item").removeClass("active");
		$("a.ui.label.transition.visible").remove();
		$(".customer_records_dynamic").empty(); // clear custom size div customer_records_dynamic
		$('#size_id').empty();
		if(id == 5){
			//Load flexitive_size option to dropdown
		    $('#size_unit').html("(in ratio)");
			<?php 
				$flexitive_size = $this->db->get('flexitive_size')->result_array(); 
			    foreach($flexitive_size as $result){ 
			?>
			        $("#size_id").append("<option value='<?php echo $result['id']; ?>'><?php echo $result['ratio'].' ('.$result['text'].')'; ?></option>");
			<?php        
				}
			?>
			
		}else{
		    //Load pixel_size options to dropdown
    		$('#size_unit').html("(in Pixels)");
    		<?php  
                $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
    			foreach($pixel_sizes as $row){
    		?>
    		    $("#size_id").append("<option value='<?php echo $row['id']; ?>'><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>");
    		<?php } ?>
		}
	}
</script>
<!-- multiple size END -->
<?php $this->load->view('new_csr/foot'); ?>