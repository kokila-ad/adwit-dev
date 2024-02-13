<?php $this->load->view('new_client/header'); ?>
<!-- editor tool bar -->	
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- editor tool bar END-->	

<style>
    .file_li {
       // width: 350px;
    	min-width: 250px;
       // overflow-x: hidden;
    }
    .min-height-155 {
    	min-height: 155px;
    }
</style>
<style>
        	.card {
			  width: 100%;
			  background-color: #fff;
			  border-radius: 5px;
			  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			 
			}
			
			.card-title {
			  font-size: 14px;
			  font-weight: normal;
			  margin-bottom: 10px;
			  background-color: lightgrey;
			  padding: 10px;
			  border-radius: 5px 5px 0 0;
			  color:#ffffff;
			}

			.card-header {
			  padding: 20px;
			  cursor: pointer;
			  position: relative;
			  font-weight: normal;
			  margin-bottom: 10px;
			  background-color: lightgrey;
			  padding: 10px;
			  border-radius: 5px 5px 0 0;
			  color:#ffffff;
			  font-size: 14px;
			}

			.card-header::after {
			  content: '^';
			  font-family: "Font Awesome 6 Free";
			  position: absolute;
			  top: 50%;
			  right: 20px;
			  transform: translateY(-50%) rotate(180deg);
			  transition: transform 0.3s ease;
			  font-size:16px;
			  font-weight: bold;
			}

			.card.open .card-header::after {
			  transform: translateY(-50%);
			}

			.card-body {
			  padding: 20px;
			  display: none;
			}

			.card.open .card-body {
			  display: block;
			}
</style>
<!-- PDF MArkup Style -------->
<style class="cp-pen-styles">

/** LIGHTBOX MARKUP **/

.lightbox {
	/** Default lightbox to hidden */
	display: none;

	/** Position and style */
	position: fixed;
	z-index: 999;
	width: 100%;
	height: 100%;
	text-align: center;
	top: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
}

.lightbox img {
	/** Pad the lightbox image */
	max-width: 90%;
	max-height: 80%;
	margin-top: 2%;
}

.lightbox:target {
	/** Remove default browser outline */
	outline: none;

	/** Unhide lightbox **/
	display: block;
}
.thumbnail {
    display: block;
   /*height: 100px;*/
    width: 120px;
        padding: 0px;
    margin-bottom: 17px;
}
/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
  opacity: 2.2;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}
</style>
<style>
    .active > a{
                color: #d71a22 !important;
                border-color: #333;
                background: #e1e1e100 !important;
            }
    
    .panel-heading .accordion-toggle:after {
        /* symbol for "opening" panels */
        font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
        content: "\e114";    /* adjust as needed, taken from bootstrap.css */
        float: right;        /* adjust as needed */
        color: rgb(255, 255, 255);         /* adjust as needed */
        
    }
    .panel-heading {
       border-top-right-radius: 0px !important;
        border-top-left-radius: 0px !important;
    }
    .panel-default {
        border-color: #808080 !important;
    }
    .panel-group .panel + .panel {
        margin-top: 0px !important;
    }
    .panel-heading .accordion-toggle.collapsed:after {
        /* symbol for "collapsed" panels */
        font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
        content: "\e080";   /* adjust as needed, taken from bootstrap.css */
        float: right;        /* adjust as needed */
        color: rgb(255, 255, 255);  
    }
    .panel-heading {
        background-color: #989898;
    }
    .panel-heading.collapsed {
        background-color: #d8d8d8;
    }
    
    iframe {
        width: 100%;
        height: 300px;
    }
    
    @font-face {
        font-family: 'Glyphicons Halflings';
        src: url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot');  src: url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.woff') format('woff'), url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
    }
</style>
<!-- PDF MArkup Style END-------->

<!-- multiple size select css START-->
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


<div id="main">
<!-- <form method="post">-->
<?php $adrep = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->row_array(); ?>
<section>
    <div class="container margin-top-30"> 
		<div class="row margin-0">	 
			<div class="col-md-2 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				<span class="margin-right-15">AdwitAds ID: <span class="text-dark"><?php echo $order_details[0]['id'];?></span></span>
			</div>
		<?php if($order_details[0]['order_type_id'] == '6'){ ?>
				<div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				    <span>Publication/Edition Name: <span class="text-dark"><?php echo $order_details[0]['advertiser_name'];?></span></span>
			    </div>	        
		<?php }else{ ?>
		        <div class="col-md-4 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-grey">
				    <span>Unique ID: <span class="text-dark"><?php echo $order_details[0]['job_no'];?></span></span>
			    </div>    
		<?php } ?>
			
						
			<div class="col-md-6 col-sm-12 col-xs-12 margin-vertical-10 padding-0 text-right small">
				<span class="margin-right-5 text-grey">
					<a href="javascript:history.back()"><i class="fa fa-mail-reply padding-right-5 text-grey"></i></a> |
				</span>
				<span class="margin-0 text-grey">
					<?php $action_name = $this->db->get_where('adrep_actions',array('id'=> $action_id))->result_array();
					   echo $action_name[0]['name'];
					 ?>
				</span>
			<?php if($action != 'pickup'){ ?>	
				<span class="dropdown margin-left-5 text-grey">|
						<span class="cursor-pointer padding-left-5" type="button" data-toggle="dropdown" id="view">
						    View Uploaded Files
						    <span class="caret margin-left-5"></span>
						</span>
													
						<div class="table-responsive dropdown-menu file_li ">  							 
								<table class="table table-striped table-hover" id="mytable">
								 <tbody>
								<?php if(isset($file_names)) { $i=1;  foreach($file_names as $row)  { $ext = pathinfo(basename($row), PATHINFO_EXTENSION);  ?>
									 <tr>
										<td><?php echo $i ?></td>
										<td><a href="<?php echo base_url().$row;?>" target="_blank"><?php echo basename($row); 	$i++; ?></a></td>
										<td>
											<a href="<?php echo base_url().'download.php?file_source='.$row; ?>" target="_blank"><i class="fa fa-download"></i></a>
										</td>
										<?php if($action_id == '5' && $ext != 'html'){ ?>
										<td>
											<form method="post" action="<?php echo base_url().index_page().'new_client/home/remove_att';?>">
												<input type="hidden" name="filepath" value="<?php echo dirname($row); ?>">
												<input type="hidden" name="filename" value="<?php echo basename($row); ?>">
												<input type="hidden" name="adwitadsid" value="<?php echo $order_details[0]['id']; ?>">
												<button type="submit" name="remove_att" id="remove" class="btn btn-outline padding-0" 
												style="background-color: #f9f9f9;margin-top: -4px;color: #1b1b1b;"><i class="fa fa-close"></i></button>
											</form>
										</td>
										<?php }elseif($action_id == '1' && $ext != 'html'){ ?>
										<td>
											<button type="button" name="remove_att" id="remove" onclick="remove_att_file('<?php echo basename($row); ?>') ;" class="btn btn-outline padding-0" 
												style="background-color: #f9f9f9;margin-top: -4px;color: #1b1b1b;"><i class="fa fa-close"></i></button>
										</td>
										<?php } ?>
										 </tr>
								<?php  } }?> 
								</tbody>
							 </table>
						</div>
					</span>
				<?php } ?>
			</div>
		</div>
	</div>
</section>

<?php 
if($action == "pickup") {
    if(isset($rev_details_latest['id'])){ //echo 'revision ad - ';
        $annotation_file = basename($rev_details_latest['pdf_path']);
        $annotation_file_ext = pathinfo($annotation_file, PATHINFO_EXTENSION);
        $pdf_annotation_url = base_url().$rev_details_latest['pdf_path'];    
    }else{ //echo 'new ad - ';
        $annotation_file = basename($order_details[0]['pdf']);
        $annotation_file_ext = pathinfo($annotation_file, PATHINFO_EXTENSION);
        $pdf_annotation_url = base_url().$order_details[0]['pdf'];
    }
    $orderId = $order_details[0]['id'];
?>
<section id="pickup">
    <div class="container">
		<form method="post" id="order_form">	      
            <div class="row margin-top-30">
                <div class="card">
                    <div class="card-title">Order Details</div>
			   <div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-15">
                       <p class="margin-bottom-5">Advertiser Name <span class="text-red">*</span> </p>
                       <input type="text" name="advertiser_name" value="<?php echo $order_details[0]['advertiser_name']; ?>" class="form-control input-sm margin-bottom-15" title="" required>
                       
                       <p class="margin-bottom-5">New Unique ID <span class="text-red">*</span> <small class="text-grey">(Add your own number or letters)</small> </p>
                       <input type="text" name="job_no" pattern="[a-zA-Z0-9 ]{1,50}" value="<?php echo $order_details[0]['job_no']; ?>" class="form-control input-sm margin-bottom-15" title="" required>
                </div>
			
    			<div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-15">
    				<p class="margin-bottom-5">Pickup Order Type</p>			
    					<div> 
    						<a href="<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$order_details[0]['id'].'/print';?>"
    							<?php if($pickup == 'print') { ?> class="btn btn-sm btn-dark btn-outline btn-active margin-right-10" <?php } else { ?> class="margin-right-10 btn btn-sm btn-dark btn-outline" <?php } ?> >
    						    Print Ad
    						</a>
    						<a href="<?php echo base_url().index_page().'new_client/home/order_action/pickup/'.$order_details[0]['id'].'/online';?>" 
    							<?php if($pickup == 'online') { ?> class="btn btn-sm btn-dark btn-outline btn-active margin-right-10" <?php } else { ?> class="margin-right-10 btn btn-sm btn-dark btn-outline" <?php } ?> >
    						    Online Ad
    						</a>
    					</div>
    			</div>
    			
    			<!------------------------------- Print Ads START --------------------------------------------------------------------------->	
			<?php if(isset($pickup) && $pickup == 'print') { ?>
			    <div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-15">
			        <p class="margin-bottom-5">Full Color / B&W / Spot<span class="text-red"> *</span></p>
    				<div class="row  margin-bottom-5">
        				<div class="col-sm-12">
        					<div class="btn-group" data-toggle="buttons">
                           <?php $print_ad_type = $this->db->query("SELECT * FROM `print_ad_types`")->result_array();
        					 foreach($print_ad_type as $row){ 
        					?>
        						 
        					 <label <?php if($row['id'] == $order_details[0]['print_ad_type']) { ?> class="active btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } else { ?> class=" btn btn-default btn-sm margin-right-15 margin-bottom-5" <?php } ?>>
        					<input type="radio" name="print_ad_type" value="<?php echo $row['id'];?>"  <?php if($row['id'] == $order_details[0]['print_ad_type']){ echo 'checked="checked"';  } ?> required > <?php echo $row['name'];?>
                            </label> 
        					
        					<?php }	?>
        					 
                          </div>
                        </div>   
                    </div>
                </div>    
			    <div class="col-md-6 col-sm-6 col-xs-12">
    			    <div class="row margin-bottom-15">
                        <div class="col-md-6 col-sm-6 col-xs-6"> 
    					    <p class="margin-bottom-5">New Width <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
    					    <input type="number" name="width" max="99" min="1"  step="0.0001" value="<?php echo $order_details[0]['width']; ?>" class="form-control input-sm" title="width" required>
    				    </div>
    				    <div class="col-md-6 col-sm-6 col-xs-6">
    					    <p class="margin-bottom-5">New Height <span class="text-red">*</span> <small class="text-grey">(in inches)</small></p>
    					    <input type="number" name="height" max="99" min="1"  step="0.0001" value="<?php echo $order_details[0]['height']; ?>" class="form-control input-sm" title="height" required>
    				    </div>
                    </div> 
			    </div> 
            <?php }	?>
			<!------------------------- Print Ads END ------------------------------------------------------------------------------------->
			
			<!------------------------- Online Ads START ---------------------------------------------------------------------------------->
			<?php if(isset($pickup) && $pickup == 'online') { ?>
			    <div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-15">
			        <p class="margin-bottom-5">Ad Type <span class="text-red">* </span><small class="text-grey">(select one)</small></p>
        			<div class="row">
        			   <div class="col-sm-12">
        				 <div class="btn-group" data-toggle="buttons">
        					<label <?php if($order_details[0]['web_ad_type']=='Static') { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } else { ?> class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?> >
        						<input type="radio" name="web_ad_type" value="Static" <?php if($order_details[0]['web_ad_type']=="Static"){ echo 'checked="checked"';  } ?> required=""> Static
        					</label> 
        					<label <?php if($order_details[0]['web_ad_type']=='Animated') { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-15" <?php } else { ?> class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?>>
        						<input type="radio" name="web_ad_type" value="Animated" <?php if($order_details[0]['web_ad_type']=="Animated"){ echo 'checked="checked"';  } ?> required=""> Animated
        					</label> 
        				  </div>
        			   </div>   
        			</div>
        		</div>
        			
			    <div class="col-md-6 col-sm-6 col-xs-12">
        			<p class="margin-bottom-5">Format<span class="text-red"> * </span><small class="text-grey">(select one)</small></p>
        		    <div class="row margin-bottom-5">
        			   <div class="col-sm-12">
        				 <div class="btn-group" data-toggle="buttons">
        				 
                        <?php $web_ad_formats = $this->db->get('web_ad_formats')->result_array();
                			  foreach($web_ad_formats as $result){ ?>
                			  <label onclick="ad_format(<?php echo $result['id']; ?>)" <?php if($result['id'] == $order_details[0]['ad_format']) { ?> class="active btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } else { ?>  class="btn btn-sm btn-default margin-right-10 margin-bottom-10" <?php } ?>>
                				<input type="radio" name="ad_format" value="<?php echo $result['id']; ?>" <?php if($result['id'] == $order_details[0]['ad_format']){ echo 'checked="checked"';  } ?> required="">
                				<?php echo $result['name']; ?>
                			  </label> 
                		<?php } ?>
            
        				  </div>
        				</div>   
        		   </div>
        		   	 		
        			<p class="margin-bottom-5">Maximum File Size <span class="text-red">* </span><small class="text-grey">(In KBs)</small></p>
        	        <input type="text" name="maximum_file_size" value="<?php echo $order_details[0]['maxium_file_size']; ?>" class="form-control input-sm margin-bottom-15" title="" required="">
        		   <!------------------------------ online size -------------------------------------------------->
        		   <div id="size-div" >
            		   <p class="margin-bottom-5">
            		       Size <span class="text-red">* </span><small id="size_unit" class="text-grey">(in Pixels)</small>
            		       <a class="btn red-sunglo btn-link btn-xs  extra-fields-customer" style="float:right;" >
            			    <span class="glyphicon glyphicon-plus"></span> Add Custom Size
            			   </a>
            		   </p>
            		    <div class="row margin-bottom-5">
            		        <div class="col-sm-12"> 
            			        <div class="inline field">
                                    <select name="size_id[]" id="size_id" multiple="" class="form-control  label ui selection fluid dropdown" >
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
            				</div>   
            			</div>
            			<div class="row static-info">
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
        		   <!--<p class="margin-bottom-5">Size <span class="text-red">* </span><small class="text-grey">(in Pixels)</small></p>
        		   <div class="row margin-bottom-15">
        			   <div class="col-sm-12">
        					<select class="form-control input-sm" name="pixel_size" required >
        						<option value="">Select</option>
        						<?php  $pixel_sizes = $this->db->get('pixel_sizes')->result_array();
        								foreach($pixel_sizes as $row)
        								{
        						?>
        						<option value="<?php echo $row['id']; ?>" <?php if($row['id']==$order_details[0]['pixel_size']) echo'selected="selected"'; ?>><?php echo $row['width'].' X '.$row['height'].' ('.$row['name'].')'; ?></option>
        						<?php } ?>
        						<option value="custom" <?php if($order_details[0]['pixel_size']=='custom') echo'selected="selected"'; ?>>Custom</option>
        					</select>
        					
        				</div>   
        			</div>	
        		    
        			<div <?php if($order_details[0]['pixel_size']=='custom') echo'class="row margin-bottom-15"'; else echo'class="row margin-bottom-15 custom box"'; ?> >
        	           <div class="col-md-6 col-sm-6 col-xs-6">
        					 <p class="margin-bottom-5">Width <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
        					 <input type="number" name="custom_width" id="custom_width" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" value="<?php echo $order_details[0]['custom_width']; ?>"></div>
        			   <div class="col-md-6 col-sm-6 col-xs-6"> 
        					<p class="margin-bottom-5">Height <span class="text-red">*</span> <small class="text-grey">(in pixels)</small></p>
        					<input type="number" name="custom_height" id="custom_height" pattern="[1-9]{1,50}" min="1" class="form-control input-sm" value="<?php echo $order_details[0]['custom_height']; ?>"></div>
        			</div> -->
        		<!------------------------------END online size -------------------------------------------------->		 
        		</div> 
        		
			<?php } ?>
            <!------------------------- Online Ads END ---------------------------------------------------------------------------------->
                <div style="clear: both"></div>
            </div>
    			<!----------------- PDF Markup ---------------------------->
    		<?php if(isset($annotation_file) && ($annotation_file_ext == 'pdf' || $annotation_file_ext == 'PDF')){ ?>	
    			<div class="card margin-top-20 padding-bottom-20">
					<div class="card-title">Mark Up PDF</div><!--<div class="card-header" onclick="toggleCard(this)" id="mark-up-tool"> Mark Up PDF </div>-->
    				<!--<div class="card-body padding-0">-->
                		
            				<div class="padding-0">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="docs-tabs-1">
                                        <div class="text-muted">
                                             <div class="panel-group" id="accordion">
                                                <!--div style="font-size:11px;font-style:italic;text-align:right">Mark up the pdf with required changes</div-->	
                                                <div id="adobe-dc-view" style="height: 1000px"></div>
                                                <!--<div style="font-size:11px;font-style:italic;text-align:right">Mark up and save the pdf to enable Submit Revision</div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div style="clear:both"></div>
            <?php } ?>
			</div>
                <!---------------------- copy,content & notes ------------------->
                <div class="card margin-top-20 padding-bottom-20">
					<div class="card-header" onclick="toggleCard(this)" id="additional-instructions"> Additional Instructions </div> <!--<div class="card-title">Additional Instructions</div>-->
					<div class="card-body">
                    <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-15">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p class="margin-bottom-5">Copy/Content/Text </p>
                			   <?php    
                    		        $quill_disable_adrep = array('971','308','307','2195','2716');
                    		        if (in_array($adrep['id'],$quill_disable_adrep, TRUE)){
                    		   ?>
                                    <textarea rows="4" name="copy_content_description" value="<?php echo $order_details[0]['copy_content_description']; ?>" class="form-control margin-bottom-15" title="" ></textarea>
                               <?php }else{ ?>
                                   <textarea name="copy_content_description" id="copy_content_description" type="text" ></textarea>
                    		        <div id="editor" style="height:125px;"></div>
                    		        <div  style="color:red;"> <span class="name" id="txtLimit"></span> </div>
                			    <?php } ?>    
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p>Additional Instructions</p>
                                <textarea rows="7" name="notes" value="<?php echo $order_details[0]['notes']; ?>" class="form-control" title=""></textarea>    
                            </div>
                        </div>
                    </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
            <!-- file upload dropzone START   -->
                <div class="card margin-top-20 padding-bottom-20">
					<div class="card-title">Files</div>
					<div class="col-md-12">
						<div class="row">				
            				<div class="col-md-12 margin-bottom-15 text-right">
            					<span class="dropdown">
            						<a class="cursor-pointer" type="button" data-toggle="dropdown" id="view_cache_files">View Uploaded Files<span class="caret"></span></a>
            						<div class="table-responsive dropdown-menu file_li " id="show"> 
            							<table class="table table-striped table-hover" id="mytable">
            								 <tbody id="tbody">
            								 
            								</tbody>
            							 </table>
            						</div>
            					</span>
            				</div>
            			</div>
            			<div>
            				<div action="<?php echo base_url().index_page().'new_client/home/order_cache/'.$cacheid; ?>" id="dropzonefileupload" class="dropzone margin-top-10 margin-bottom-15" > 
            					<div class="dz-default dz-message margin-top-55 margin-0"><span>You can attach or drag files here</span></div>
            				</div>
            			</div>
					</div>
					<div style="clear: both"></div>
				</div>
			<!-- file upload dropzone END-->
		    <input id="cacheid" type="hidden" class="form-control input-sm" name="cacheid" value="<?php echo $cacheid;?>" >
		<!------------------------------- Print Ads START --------------------------------------------------------------------------->	
			<?php if(isset($pickup) && $pickup == 'print') { ?>
			    <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="submit" class="btn btn-blue btn-sm float-right  margin-top-20" name="print_pickup_submit" id="btn-submit-pickup">Submit</button>
                </div>			
            <?php }	?>
			<!------------------------- Print Ads END ------------------------------------------------------------------------------------->
			
			<!------------------------- Online Ads START ---------------------------------------------------------------------------------->
			<?php if(isset($pickup) && $pickup == 'online') { ?>
			    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-blue btn-sm float-right  margin-top-20" name="web_pickup_submit" id="btn-submit-pickup">Submit</button>
                </div>
			<?php } ?>
            <!------------------------- Online Ads END ---------------------------------------------------------------------------------->
        </div> 
		</form>
    </div>
</section>
<?php } ?>

<?php if($action == "revision") { ?>
<section id="revision">
    <div class="container"> 
	<div class="row margin-top-30">
		
		<form  method="post" >
			<div class="col-md-6 col-sm-6 col-xs-12">
			   <p class="margin-bottom-5">Production Notes <span class="text-red">*</span></p>
			   <span id="show">
					 <textarea rows="7" name="notes" id="note" required class="form-control margin-bottom-15"><?php if(isset($rev_sold_jobs)){ echo $rev_sold_jobs[0]['note']; }  ?></textarea>
			   </span>
			   
				<?php if(isset($rev_sold_jobs)){ ?>
					<input type="text" id="rev_id" name="rev_id"  value="<?php echo $rev_sold_jobs[0]['id'];?>" readonly style="display:none;"/> 
					<button type="submit" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="rev_complete" id="hide">Submit</button>
				<?php }else{ ?>
					<input type="text" id="job_slug" name="job_slug"  value="<?php echo $slug;?>" readonly style="display:none;"/> 
					<button type="submit" class="btn btn-blue btn-sm margin-top-5 margin-bottom-20 pull-right" name="rev_submit" id="hide">Submit</button>
				<?php } ?>
				</div> 
		</form>
			<?php if(isset($rev_sold_jobs) && $rev_sold_jobs[0]['file_path'] != 'none' && file_exists($rev_sold_jobs[0]['file_path'])){  ?>
			<div class="col-md-6 col-sm-6 col-xs-12" id="show-drag">
			   <span class="margin-bottom-10">Attach Files</span>
				
			 <form action="<?php echo base_url().index_page().'new_client/home/order_revision'.'/'.$rev_sold_jobs[0]['id']; ?>"  class="dropzone margin-top-5" > 
				<div class="dz-default dz-message margin-top-50">You can attach or drag files here</div>
			</form>
			
			</div> 
			<?php } ?>
			
		</div> 
	</div>
</section>
<?php } ?>

<?php if($action == "attachments") { ?>
<section id="attachments">
    <div class="container"> 		
		
		<div class="row margin-top-20">
			<div class="col-md-6 col-sm-6 col-xs-6">
			    <label class="text-grey">Additional Attachments</label>	
				<form action="<?php echo base_url().index_page().'new_client/home/additional_att'.'/'.$order_details[0]['id']; ?>" class="dropzone margin-350 drag-bg" method="post">
			</div>
			<!-- Additional Notes & Instructions -->
			<div class="col-md-6 col-sm-6 col-xs-6">
			    <label class="text-grey">Additional Instructions</label>
			    <textarea rows="16" name="notes" 
                			data-max-length-warning="Input must be 5000 characters or less" 
                			data-max-length="5000" 
                			data-max-length-warning-container="name123" class="js-max-char-warning form-control margin-bottom-15 txtLimit2 " type="text" id="yourtextarea2"></textarea>	
                <div  style="color:red;"> <span class="name123"></span></div>
			</div>
		    <div class="col-md-12 col-sm-12 col-xs-12 margin-top-20 text-right">	
				<button type="submit" name = "add_submit" class="btn btn-sm btn-blue margin-bottom-10 btn-md">Submit</button>
			</div>
			</form>
		</div> 
	</div>
</section>
<?php } ?>

<?php if($action == "QA") { ?>
<section id="answers" class="margin-bottom-30">
<div class="container"> 
<div class="row  margin-top-15">
		<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Question</p>
					   <p class="text-grey"><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>			   
				  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Answer</p>
					   <textarea rows="3"  name="answer" id="answer" class="form-control margin-bottom-15"  required=""></textarea>
					   
					   <p class="margin-bottom-5">Attach File</p>
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control">
					   <input type="file" class="form-control margin-top-10">
				  </div> 
			
					<div class="col-md-12 col-sm-6 col-xs-12">
						<input name="id" value="<?php echo $question['id'];?>" readonly style="display:none;" />
						<button type="submit" class="btn btn-blue btn-sm pull-right margin-top-15" name="QA_submit">Submit</button>
					</div>
			</form>
</div> 
</div>	
</section>
<?php } ?>

<?php if($action == "QA_rev") { ?>
<section id="answers" class="margin-bottom-30">
<div class="container"> 
<div class="row  margin-top-15">
			<form id="order_form" name="order_form" method="post" enctype="multipart/form-data">
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Question</p>
					   <p class="text-grey"><?php $question['question'] = str_replace(PHP_EOL,'<br/>', $question['question']); echo $question['question'] ; ?></p>			   
				  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12">
					   <p class="margin-bottom-5">Answer</p>
					   <textarea rows="3"  name="answer" id="answer" class="form-control margin-bottom-15"  required=""></textarea>
					   
					   <p class="margin-bottom-5">Attach File</p>
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control">
					   <input type="file" name="ufile[]" id="ufile[]" value="upload" class="form-control margin-top-10">
				  </div> 
			
					<div class="col-md-12 col-sm-6 col-xs-12">
						<input name="id" value="<?php echo $order_details[0]['id'];?>" readonly style="display:none;" />
						<button type="submit" class="btn btn-blue btn-sm pull-right margin-top-15" name="QA_rev_submit">Submit</button>
					</div>
			</form>


</div> 
</div>	
</section>
<?php } ?>

<!-- order form view --->
<?php if($action == "view") { ?>

<section id="view">
    <div class="container"> 	
	
		<div class="row margin-top-10">
			<div class="col-md-12 col-sm-12 col-xs-12 padding-bottom-10">
				<div class="divider horizontal">
					<small>Order placed succesfully on 
						<b class="text-dark"><?php $order_created_on = strtotime($order_details[0]['created_on']); echo date('M d, Y', $order_created_on);?></b></small>
				</div>
			</div>
		</div>
	<!-- order form -->
		<div class="row  margin-top-25">	
            <div class="col-md-3 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"><?php echo date('h:i:s', $order_created_on).' EST';?></p>			
						<p class="margin-0 medium"></p>	
					</div>
					
				
				</div>
			</div>		
			<div class="col-md-9 col-sm-12 col-xs-12">
				<div class="row">
				<!--Size-->	
					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Copy/Content/Text</p>			
						<p class="margin-0 medium"><?php if($order_details[0]['copy_content_description'] != NULL) echo nl2br($order_details[0]['copy_content_description']);?></p>	
					</div>


					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Production Notes</p>			
						<p class="margin-0 medium">
						    <?php if($order_details[0]['notes'] != NULL) echo nl2br($order_details[0]['notes']); ?>
						</p>	
					</div>
					<?php
                        $additional_instruction = $this->db->query("SELECT * FROM `orders_additional_instruction` WHERE `order_id` = ".$order_details[0]['id'])->result_array();
						if(isset($additional_instruction[0]['id'])){
					?>
					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Additional Instructions</p>
					    <?php
						    foreach($additional_instruction as $instruction){
						        echo '<p class="margin-0 medium">'.nl2br($instruction['instructions']).'</p>';     
						    } 
					    ?>
					</div>
					<?php } ?>
					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
					    <?php if($order_details[0]['order_type_id'] == '6'){ ?>
					        <p class="margin-0 text-grey">Publication/Edition Name</p>
					    <?php }else{ ?>
						    <p class="margin-0 text-grey">Advertiser Name</p>
						<?php } ?>
						<p class="margin-0 medium"><?php echo $order_details[0]['advertiser_name'];?></p>	
					</div>


					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
					    <?php if($order_details[0]['order_type_id'] == '6'){ ?>
					        <p class="margin-0 text-grey">Page Name</p>
					    <?php }else{ ?>
						    <p class="margin-0 text-grey">Unique ID</p>
					    <?php } ?>
						<p class="margin-0 medium"><?php echo $order_details[0]['job_no'];?></p>	
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">		
						<?php if($order_details[0]['order_type_id']=='2') { ?><!--print-->
							<p class="margin-0 text-grey">Width & Height (In Inches)</p>			
							<p class="margin-0 medium"><?php echo $order_details[0]['width'].' X '.$order_details[0]['height'];?></p>	
						<?php } ?>
						
						<?php if($order_details[0]['order_type_id']=='1') {  //web ad
							if($order_details[0]['ad_format']=='5' && empty($order_details[0]['pixel_size'])){ //flexitive ad
							    if(isset($order_details[0]['flexitive_size'])){
								    $flexitive_size = $this->db->get_where('flexitive_size',array('id' => $order_details[0]['flexitive_size']))->row_array();
						?>
								    <p class="margin-0 text-grey">Size</p>			
								    <p class="margin-0 medium"><?php echo $flexitive_size['ratio'];?></p>	
						<?php	
							    }else{ //multiple size
							        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, flexitive_size.ratio FROM `orders_multiple_size`
							                                                    LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
							                                                     WHERE orders_multiple_size.order_id = '".$order_details[0]['id']."'")->result_array();
							        $orders_multiple_custom_size = $this->db->query("SELECT * FROM `orders_multiple_custom_size`
							                                                            WHERE order_id = '".$order_details[0]['id']."'")->result_array();
							        if(isset($orders_multiple_size[0]['id'])){
							            echo '<p class="margin-0 text-grey">Size <small class="text-grey">(in ratio)</small></p>';
							            foreach($orders_multiple_size as $msize){
							                if($msize['size_id'] != NULL){
							                    echo '<p class="margin-0 medium">'.$msize['ratio'].'</p>';
							                }
							            }
							        }
							        if(isset($orders_multiple_custom_size[0]['id'])){
							            //echo '<p class="margin-0 text-grey">Size <small class="text-grey">(in ratio)</small></p>';
							            foreach($orders_multiple_custom_size as $mcsize){
							                echo '<p class="margin-0 medium">'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'</p>';
							            }
							        }
							    }
							}else{
								if($order_details[0]['pixel_size'] == 'custom') { 
						?>
									<p class="margin-0 text-grey">Width & Height </p>			
									<p class="margin-0 medium"><?php echo $order_details[0]['custom_width'].' X '.$order_details[0]['custom_height'];?></p>	
							<?php 
								} elseif($order_details[0]['pixel_size'] != '') { 
									$size = $this->db->get_where('pixel_sizes',array('id' =>$order_details[0]['pixel_size']))->result_array();
							?>
									<p class="margin-0 text-grey">Width & Height </p>			
									<p class="margin-0 medium"><?php echo $size[0]['width'].' X '.$size[0]['height'];?></p>	
							<?php 
								}else{ //multiple size
							        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, pixel_sizes.width, pixel_sizes.height FROM `orders_multiple_size`
							                                                    LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
							                                                     WHERE orders_multiple_size.order_id = '".$order_details[0]['id']."'")->result_array();
							        $orders_multiple_custom_size = $this->db->query("SELECT * FROM `orders_multiple_custom_size`
							                                                            WHERE order_id = '".$order_details[0]['id']."'")->result_array();
							        if(isset($orders_multiple_size[0]['id'])){
							            echo '<p class="margin-0 text-grey">Size <small class="text-grey">(in Pixels)</small></p>';
							            foreach($orders_multiple_size as $msize){
							                if($msize['size_id'] != NULL){
							                    echo '<p class="margin-0 medium">'.$msize['width'].' X '.$msize['height'].'</p>';
							                }
							            }
							        }
								    if(isset($orders_multiple_custom_size[0]['id'])){
							            foreach($orders_multiple_custom_size as $mcsize){
							                echo '<p class="margin-0 medium">'.$mcsize['custom_width'].' X '.$mcsize['custom_height'].'</p>';
							            }
							        }
								} 
							}
						}  ?>
					</div>
				<!--Size End-->
				<!-- Print - Color / B&W / Spot -->
					<?php if($order_details[0]['order_type_id']=='2') { ?>
					 	<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Color Options</p>			
							<p class="margin-0 medium">
							<?php 
								if($order_details[0]['print_ad_type'] == '1'){ 
									echo "Colour"; 
								}elseif($order_details[0]['print_ad_type'] == '2'){ 
									echo "B&W"; 
								}else { 
									echo "Spot"; 
								} 
							?>	
							</p>	
						</div>
					<?php } ?>
				<!-- Web - Maximum File Size -->
					<?php if($order_details[0]['order_type_id']=='1') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Maximum File Size </p>			
							<p class="margin-0 medium"><?php echo $order_details[0]['maxium_file_size'];?></p>	
						</div>
					<?php } ?>
				<!-- Web - Format -->
					<?php if($order_details[0]['order_type_id']=='1') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Format </p>			
							<p class="margin-0 medium">
							<?php 
								$results = $this->db->get_where('web_ad_formats',array('id' =>$order_details[0]['ad_format']))->result_array(); 
								echo $results[0]['name']; 
							?>
							</p>	
						</div>
					<?php } ?>
				<!-- Web - Ad Type -->
					<?php if($order_details[0]['order_type_id']=='1') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Web Ad Type </p>			
							<p class="margin-0 medium"><?php echo $order_details[0]['web_ad_type'];?></p>	
						</div>
					<?php } ?>
				<!--Date needed-->
					<?php if($order_details[0]['date_needed'] != '0000-00-00' && $order_details[0]['date_needed'] != NULL) { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Date needed</p>			
							<p class="margin-0 medium"><?php $date = strtotime($order_details[0]['date_needed']); echo date('M d, Y', $date); ?></p>	
						</div>
					<?php } ?>	
					<!--Publish needed-->					
					<?php if($order_details[0]['publish_date'] != '0000-00-00' && $order_details[0]['publish_date'] != NULL && $order_details[0]['publication_id'] != '580') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Publish Date</p>			
							<p class="margin-0 medium"><?php $date = strtotime($order_details[0]['publish_date']); echo date('M d, Y', $date);  ?></p>	
						</div>
					<?php } ?>
					<!--Publication Name-->
					<?php if($order_details[0]['publication_name'] != '') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Publication Name</p>			
							<p class="margin-0 medium"><?php echo $order_details[0]['publication_name']; ?></p>	
						</div>
					<?php } ?>
					<!--Font Preferences-->
					<?php if($order_details[0]['font_preferences'] != '') { ?>
					<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey">Font Preferences</p>			
						<p class="margin-0 medium"><?php echo $order_details[0]['font_preferences']; ?></p>	
					</div>
					<?php } ?>
					<!--Color Preferences-->
					<?php if($order_details[0]['color_preferences'] != '') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Color Preferences</p>			
							<p class="margin-0 medium"><?php echo $order_details[0]['color_preferences']; ?></p>	
						</div>
					<?php } ?>
					<!--Job Instructions-->
					   <?php if($order_details[0]['job_instruction'] != '0' && $order_details[0]['job_instruction'] != '') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Job Instructions</p>			
							<p class="margin-0 medium">
								<?php 
								if($order_details[0]['job_instruction'] == '1') { echo "Follow Instructions Carefully"; }
									elseif($order_details[0]['job_instruction'] == '2') { echo "Be Creative"; } else { echo "Camera Ready Ad";}
								}?>
							</p>	
						</div>
					<!--Art Work-->
					   <?php if($order_details[0]['art_work'] != '0' && $order_details[0]['art_work'] != '') { ?>
						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
							<p class="margin-0 text-grey">Art Work</p>			
							<p class="margin-0 medium">
								<?php echo $order_details[0]['art_work']==1 ? 'Use additional art if required' : ($order_details[0]['art_work']==2 ? 'Modify art provided if necessary' : 'Use art provided without change'); ?>
							</p>	
						</div>
						<?php } ?>
					<!-- For preorders_waukesha -->
					<?php if(isset($preorders_waukesha['id'])){ ?>
					        <div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
    							<p class="margin-0 text-grey">Keyword <a id="adtitle" class="cursor-pointer small font-color-grey edit"><i class="glyphicon glyphicon-pencil"></i></a></p>			
    							<p class="margin-0 medium" id="adtitle-content"><?php echo $preorders_waukesha['adtitle']; ?></p>
    							<p id="form-adtitle">
    							    <input type="text" name="adtitle" class="form-control input-sm" value="<?php echo $preorders_waukesha['adtitle']; ?>">
    							    <button type="submit" data-id="adtitle" class="btn smedium margin-top-5 padding-vertical-5 btn-primary update">SUBMIT</button>
    							</p>
    						</div>
    						<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
    							<p class="margin-0 text-grey">Ad Type <a id="adtype" class="cursor-pointer small font-color-grey edit"><i class="glyphicon glyphicon-pencil"></i></a></p>			
    							<p class="margin-0 medium" id="adtype-content"><?php echo $preorders_waukesha['adtype']; ?></p>
    							<p id="form-adtype">
    							    <input type="text" name="adtype" class="form-control input-sm" value="<?php echo $preorders_waukesha['adtype']; ?>">
    							    <button type="submit" data-id="adtype" class="btn smedium margin-top-5 padding-vertical-5 btn-primary update">SUBMIT</button>
    							</p>
    						</div>
    						
				    <?php } ?>
				    <?php if($order_details[0]['publication_id'] == '580'){ ?>
				            <div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">
    							<p class="margin-0 text-grey">Publish Date <a id="publish_date" class="cursor-pointer small font-color-grey edit"><i class="glyphicon glyphicon-pencil"></i></a></p>			
    							<p class="margin-0 medium" id="publish_date-content"><?php $date = strtotime($order_details[0]['publish_date']); echo date('M d, Y', $date); ?></p>
    							<div id="form-publish_date">
    							    <div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
        								<input type="text" name="publish_date" value="<?php echo $order_details[0]['publish_date']; ?>" class="form-control input-sm" autocomplete="off">
        								<span class="input-group-btn">
        									<button class="btn btn-blue btn-sm" type="button" name="publish_date"><i class="fa fa-calendar"></i></button>
        								</span>
        							</div>
    							    <button type="submit" data-id="publish_date" class="btn smedium margin-top-5 padding-vertical-5 btn-primary update">SUBMIT</button>
    							</div>
    						</div>
    						<?php 
    						    $project = $this->db->get_where('pub_project',array('id' => $order_details[0]['project_id']))->row_array(); 
    						    if(isset($project['name'])){
    						        echo '<div class="col-md-4 col-sm-4 col-xs-12 margin-bottom-10">';
    						        echo'<p class="margin-0 text-grey">Publication Name</p>';
    						        echo'<p class="margin-0 medium">'.$project['name'].'</p>';
    						        echo '</div>';
    						    }
    						 ?>
				    <?php } ?>
				</div>
			</div>
        
		  
	<!-- Files Uploaded List-->	
	<?php 
		if(isset($order_file_names) && $order_file_names > 0) { 
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $order_details[0]['job_no']);
			$html_file = $jname.".html";
			
			for($i=0; $i < count($order_file_names); ++$i) { 
				if($html_file == $order_file_names[$i]){
					$html_file_time = $order_filemtime[$i];
				}
			}
	?>
		<div class="row  margin-top-25">			
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey"><?php if(isset($html_file_time)) { $date = strtotime($html_file_time); echo date('h:i:s', $date).' EST'; } ?></p>			
				<p class="margin-0 medium"></p>	
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Files Uploaded</p>
				<?php 
				    if($order_details[0]['order_type_id'] == '6'){ //pagination download files display
				        for($i=0; $i < count($order_file_names); ++$i) { 
				?>
				            <p class="margin-0 medium"> 
        						<a href="<?php echo base_url().$order_file_names[$i];?>" target="_blank">
        							<?php echo basename($order_file_names[$i]); ?>
        						</a>
        					</p>
				<?php
				        }
				    }else{
				         for($i=0; $i < count($order_file_names); ++$i) {
				             $ext = pathinfo($order_file_names[$i], PATHINFO_EXTENSION);
				             if($ext != 'xml'){ //restrict ogden xml file display
				?>
        					<p class="margin-0 medium"> 
        						<a href="<?php echo base_url().'downloads/'.$order_details[0]['id'].'-'.$order_details[0]['job_no'].'/'.$order_file_names[$i];?>" target="_blank">
        							<?php echo $order_file_names[$i]; ?>
        						</a>
        					</p>
				<?php 
				             }
				        } 
				    }
				?>
			</div>
		</div>
	
	<?php } ?>
	<!-- Proof Ready-->
	<?php if($order_details[0]['pdf'] != 'none') {
		$proof_ready =  strtotime($order_details[0]['pdf_timestamp']); 
		$order_created_date = date('M d, Y', $order_created_on);
		$proof_ready_date = date('M d, Y', $proof_ready);
		$note_sent = $this->db->query("SELECT * FROM `note_sent` WHERE `order_id` = '".$order_details[0]['id']."'")->row_array();
	?>
		<div class="row  margin-top-25">
			<?php if($order_created_date != $proof_ready_date) { ?>
				<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
					<p class="margin-0 text-grey"><?php echo $proof_ready_date;?></p>			
					<p class="margin-0 medium"></p>	
				</div>
			<?php } ?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey"><?php echo date('h:i:s', $proof_ready).' EST'; ?></p>			
				<p class="margin-0 medium"></p>	
			</div>
			
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">
					<i class="fa fa-cloud-download" aria-hidden="true"></i>&nbsp;
					<a href="<?php echo base_url().$order_details[0]['pdf'];?>" target="_blank">Proof Received</a>
				</p>			
			</div>
		    <?php if(isset($note_sent['id'])){ ?>	
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">Note Sent</p>			
				<p class="margin-0 medium">
					<?php echo nl2br($note_sent['note']); ?>
				</p>			
			</div>
			<?php } ?>
		</div>
	<?php } ?>
	<!-- Approved-->
	<?php if($order_details[0]['approve'] == '1' && $order_details[0]['status']=='7') { ?>
		<div class="row  margin-top-25">
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey"><?php echo date('h:i:s', strtotime($order_details[0]['approved_time'])).' EST';?></p>			
				<p class="margin-0 medium"></p>	
			</div>
			
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
				<p class="margin-0 text-grey">
					<i class="fa fa-cloud-download" aria-hidden="true"></i>&nbsp;
					<a href="<?php echo base_url().$order_details[0]['pdf'];?>" target="_blank">Approved</a>
				</p>			
			</div>
		</div>
	<?php } ?>		
	<!-- Revision Logs-->
		<?php 
		if(isset($rev_details)) { 
			foreach($rev_details as $row) { 
				$rev_filename = array(); $rev_filemtime = array(); 
				$proof_ready_date = date('M d, Y', strtotime($order_details[0]['pdf_timestamp']));
				$revision = date('M d, Y', strtotime($row['date']));?>
				
				<div class="row  margin-top-25">			
					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php if($revision != $proof_ready_date) {?>
						<div class="row  margin-top-25">
							<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
								<p class="margin-0 medium"><?php echo $revision;?></p></br>
							</div>	
						</div>
						<?php } ?>
						<div class="row">			
							<div class="col-md-2 col-sm-6 col-xs-12 margin-bottom-10">
								<p class="margin-0 text-grey"><?php echo $row['time'].' EST';?></p>
							</div>
					
							<div class="col-md-1 col-sm-6 col-xs-12 margin-bottom-10">
								<p class="margin-0 text-grey"> <span class="line"></span></p>
								<p class="margin-0 text-grey"> </p>
							</div>
							<div class="col-md-8 col-sm-6 col-xs-12 margin-bottom-10">
								<p class="margin-0 text-grey"><i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Revision - <b><?php echo $row['version'];?></b></p>
								<p class="margin-0 text-grey"><b><?php echo $row['note'];?></b></p>
							</div>
						</div>
					</div>
				</div>
				
		
				<div class="row  margin-top-25">	
					<div class="col-md-2 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"></p>			
						<p class="margin-0 medium"></p>	
					</div>
					<div class="col-md-1 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"> <span class="line"></span></p>
						<p class="margin-0 text-grey"> </p>
					</div>
					
					<?php $rev_file_path = $row['file_path']; //revision file path
							if($rev_file_path != 'none'){ 
								if(is_dir($rev_file_path)){
									if($dh = opendir($rev_file_path)){
										while(($rev_file = readdir($dh)) !== false) {
											if($rev_file == '.' || $rev_file == '..'){
												continue; }
											if($rev_file){
											    if(is_dir($rev_file) && $dhh = opendir($rev_file_path.'/'.$rev_file)){ //echo $rev_file;
											        while(($rr = readdir($dhh)) !== false) {
											            if($rr == '.' || $rr == '..'){ continue; } 
											            $rev_filename[] = $rev_file.'/'.$rr;
												        $rev_filemtime[]= date("M d Y h:i:s.",filemtime(mb_convert_encoding($rev_file_path."/".$rev_file,'ISO-8859-1', 'UTF-8')));
											        }
											        continue;
											    }
												$rev_filename[] = $rev_file;
												$rev_filemtime[]= date("M d Y h:i:s.",filemtime(mb_convert_encoding($rev_file_path."/".$rev_file,'ISO-8859-1', 'UTF-8')));
											}
										}
										$rev_file_names = $rev_filename;
										$rev_filemtime = $rev_filemtime;
										$rev_file_path = $rev_file_path;
									closedir($dh); } } } ?>
									
					<?php if(isset($rev_file_names) && isset($rev_filemtime)){ ?>				
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp; Files Uploaded</p>
						<?php 
						    for($i=0; $i<count($rev_file_names); ++$i) { 
						       $ext = pathinfo($rev_file_names[$i], PATHINFO_EXTENSION);
				                if($ext != 'xml'){ //restrict ogden xml file display
						?>
						<p class="margin-0 text-blue">&nbsp;&nbsp;&nbsp;&nbsp; 
						    <a href="<?php echo base_url().$row['file_path'].'/'.$rev_file_names[$i];?>" target="_blank"><?php echo $rev_file_names[$i]; ?></a>
						</p>
						<?php } } ?>
					</div>
					<?php } ?>
				</div>
		
			
				<?php 
				    if($row['sent_time'] != '00:00:00') { 
				        $note_sent_rev = $this->db->query("SELECT * FROM `note_sent` WHERE `order_id` = '".$row['id']."'")->row_array();
				?>
				<div class="row  margin-top-25">
					<div class="col-md-2 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"><?php echo $row['sent_time'].' EST';?></p>			
						<p class="margin-0 medium"></p>	
					</div>
					<div class="col-md-1 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"> <span class="line"></span></p>
						<p class="margin-0 text-grey"> </p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10">
						<p class="margin-0 text-grey"><i class="fa fa-cloud-download" aria-hidden="true"></i>&nbsp; 
						<a href="<?php echo base_url().$row['pdf_path'];?>" target="_blank">Proof Received</a></p>			
						<p class="margin-0 text-blue">&nbsp;&nbsp;&nbsp;&nbsp; 
						</p>
					</div>
					<?php if(isset($note_sent_rev['id']) && $note_sent_rev['note'] != NULL){ ?>	
        			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
        				<p class="margin-0 text-grey">Note Sent</p>			
        				<p class="margin-0 medium">
        					<?php echo nl2br($note_sent_rev['note']); ?>
        				</p>			
        			</div>
        			<?php } ?>
				</div>
				<?php 
				} 
			}
		}
	?>	
	 </div>	
	</div>
</section>

<?php } ?>

<!--</form>-->


<?php if($action == "native_files") { ?>
<section id="view_sec">
    <div class="container"> 	
		<div class="row  margin-top-30">	
		
			<div class="col-md-6 col-sm-6 col-xs-12">

					<!-- <div class="col-md-6 col-sm-6 col-xs-12">						
						<?php $order = $this->db->get_where('orders',array('id' => $orderid))->result_array();?>	
						<?php if($order!='' && isset($order[0]['id']))
						{
							$publication = $this->db->get_where('publications',array('id' => $order[0]['publication_id']))->result_array();
							$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->result_array();
							if(($order[0]['status']=='5' || $order[0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
								$slug = $cat_result[0]['slug'];
				
								$sourcefilepath = $cat_result[0]['source_path'];
							$sourcefilepath = $sourcefilepath;
								}
						} ?>
								
					</div> -->
							<!--Source File Download -->
							<?php if($publication[0]['enable_source']=='1' && isset($sourcefilepath)){ 
							$this->load->helper('directory');
							$map2 = glob($sourcefilepath.'/'.$slug.'.{indd,psd}',GLOB_BRACE);	//source indd/psd
							if($map2){
							foreach($map2 as $row_map2){ $source_file = basename($row_map2); } 
							?>
												
							<form action="<?php echo base_url().'index.php/new_client/home/zip_folder_select'?>" method="post">
								<input name="source_file" value="<?php echo $source_file;?>" readonly style="display:none;" />
								<input name="new_slug" value="<?php echo $slug;?>" readonly style="display:none;" />
								<input name="source_path" value="<?php echo $sourcefilepath;?>" readonly style="display:none;" />
								<input name="download" value="download" readonly style="display:none;" />
								<button type="submit" name="SourceDownload" class="btn green">Download Package</button>
							</form>
						<?php } } ?>
	
				
				
							
			</div>
					
		
		</div>

	</div>
</section>
<?php } ?>
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

<script> //waukesha
    $(".edit").on("click", function(){
        var title = $(this).attr('id');
        $("#" + title + "-content").toggle();
        $("#form-" + title).toggle();     
    });
    
    $(".update").on("click", function(){
        var title = $(this).data('id');
        var value = $('[name="'+title+'"]').val();
        //alert('value : '+value);
        $.post("<?php echo base_url().index_page().'new_client/home/waukesha_preorder_update/'.$order_details[0]['id'];?>", {'title':title, 'value':value}, function(response){
            alert(response);
            location.reload();
        });
    });
</script> 
<!-- text limit for notes and instructions -->
<script>
    $("#yourtextarea2").keyup(function(){
     
    });
    $(document).ready(function() {
        $('.txtLimit2').on('input propertychange', function() {
            CharLimit(this,5000);
        });
        
    });

    function CharLimit(input, maxChar) {
        var len = $(input).val().length;
        if (len > maxChar) {
            $(input).val($(input).val().substring(0, maxChar));
        }
    }
	
	
	
	$.fn.maxCharWarning = function() {

      return this.each(function() {
        var el                    = $(this),
            maxLength             = el.data('max-length'),
            warningContainerClass = el.data('max-length-warning-container'),
            warningContainer      = $('.'+warningContainerClass),
            maxLengthMessage      = el.data('max-length-warning')
        ;
        el.keyup(function() {
          var length = el.val().length;      
          if (length >= maxLength & warningContainer.is(':empty')){
            warningContainer.html(maxLengthMessage);
            el.addClass('input-error');
          }
          else if (length < maxLength & !(warningContainer.is(':empty'))) {
            warningContainer.html('');
            el.removeClass('input-error');
          }
        });
      });
    };

$('.js-max-char-warning').maxCharWarning();
$('.js-max-char-warning123').maxCharWarning();


</script>
<!-- editor tool bar -->	
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

<script>
		// Initialize Quill editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],  
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],  
                [{ 'color': [] }]
            ]
        }
    });
    
    var maxLength = 5000;

    quill.on('text-change', function() {
      var text = quill.getText();
      $("#txtLimit").html("");
      if (text.length > maxLength) {
        quill.deleteText(maxLength, text.length);
        $("#txtLimit").html("Input must be 5000 characters or less");//alert("TextLimit");
      }
    });
    
    $("#order_form").submit(function () {
        var content = quill.root.innerHTML;
        
        $("#copy_content_description").val(content);
        
       /* var copy_content_description = $('#copy_content_description').val(); 
        if(copy_content_description.length <= 11){
            $("#txtLimit").html("Copy Content Required!");
            return false;
        } else {
            $("#txtLimit").html("");
            return true;
        }
        */
        //validation for multiple size - onlineAds 
        <?php if($pickup == 'online'){ ?>
            if( $('#size_id :selected').length > 0 ){
                return true;
        	} else {
        		if($('.custom_height').length > 1){
        		    return true;
                }
        	    alert("Please Select Size. Size is Mandatory");
        		return false;
        	}
    	<?php } ?>	
    		
        if ($(this).valid()) {
            return true;
        } else {
            alert("Please fill all the Mandatory Fields");
            return false;
        }
    });
    
</script>
<!-- editor tool bar END-->	
<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>

<!------------------ PDF MArkup ---------------------->
<?php if(isset($pdf_annotation_url)){ ?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script> 

<script type="text/javascript">

	document.addEventListener("adobe_dc_view_sdk.ready", function(){ 

		var adobeDCView = new AdobeDC.View({clientId: "9962a6efddab4b0391adc0fd311e55ab", divId: "adobe-dc-view"});

		adobeDCView.previewFile({

			//content:{location: {url: "<%=pdfName%>"}},

			content:{location: {url: "<?php echo $pdf_annotation_url; ?>"}},

			//content:{location: {url: "https://documentcloud.adobe.com/view-sdk-demo/PDFs/Bodea Brochure.pdf"}},

			metaData:{fileName: "<?php echo $annotation_file; ?>"},
			
			defaultViewMode: "FIT_PAGE"

		}, {});//IN_LINE

	/* Register save callback */ 

        adobeDCView.registerCallback(

            AdobeDC.View.Enum.CallbackType.SAVE_API,

            function (metaData, content, options) {

                console.log(metaData);

                console.log(content);

                

                var base64PDF = arrayBufferToBase64(content);

                var formData = new FormData();

                formData.append('content', base64PDF);

                var submitPickup = document.getElementById('btn-submit-pickup');
                
                submitPickup.disabled = true;
                submitPickup.innerHTML = 'Saving..';


                $.ajax({  

		  		       url : "<?php echo base_url().index_page().'new_client/home/pickup_order_annotation/'.$orderId; ?>",  

		  		       type : 'POST',

		  		     enctype: 'multipart/form-data',

		  		     data: formData,

		  		   processData: false,

		            contentType: false,

		            cache: false,

		            timeout: 600000, 

		  		   success : function(response) {
                        //submitRevision.style.display = 'block';
		  			    submitPickup.disabled = false; //console.log(response);
		  			    submitPickup.innerHTML = 'Submit';

		  		   }

				});

                

				console.log('Uploaded a file!');

				

                return new Promise(function (resolve, reject) {

                    /* Dummy implementation of Save API, replace with your business logic */

                    setTimeout(function () {

                        var response = {

                            code: AdobeDC.View.Enum.ApiResponseCode.SUCCESS,

                            data: {

                                metaData: Object.assign(metaData, { updatedAt: new Date().getTime() })

                            },

                        };

                        resolve(response);

                    }, 2000);

                });

            }

        );

		adobeDCView.registerCallback(
                AdobeDC.View.Enum.CallbackType.EVENT_LISTENER,
                function(event) {
                    console.log(event.type);
                    var submitPickup = document.getElementById('btn-submit-pickup');
                    switch(event.type) {
                        case "ANNOTATION_ADDED":
                        console.log("ANNOTATION_ADDED...")
                        submitPickup.disabled = true;
                        break;
                    }
                },
                {
                    //Pass the events to receive.
                    //If no event is passed in listenOn, then all annotation events will be received.
                     listenOn: [ AdobeDC.View.Enum.AnnotationEvents.ANNOTATION_ADDED, AdobeDC.View.Enum.AnnotationEvents.ANNOTATION_UPDATED ],
                    enableAnnotationEvents: true,
                    includePDFAnnotations: true,
                    
                }
            );
        



	});


	function arrayBufferToBase64(buffer) {

        var binary = "";

        var bytes = new Uint8Array(buffer);

        var len = bytes.byteLength;

        for (var i = 0; i < len; i++) {

            binary += String.fromCharCode(bytes[i]);

        }

        return window.btoa(binary);

    }

</script>

<?php } ?>
<script type="text/javascript">

	$(document).ready(function(){
		$("#copy_content_description").hide();
			    
				$("select").change(function(){
					$(this).find("option:selected").each(function(){
						if($(this).attr("value")=="custom"){
							$(".box").not(".custom").hide();
							$(".custom").show();
							$('#custom_width').attr('required', 'required');
							$('#custom_height').attr('required', 'required');
						}
					   else{
						    $('#custom_width').removeAttr('required');
							$('#custom_height').removeAttr('required');
							$(".box").hide();
						}
					});
				}).change();
				//waukesha
				$("#form-adtitle").hide();
				$("#form-adtype").hide();
				$("#form-publish_date").hide();
				
	});
	
	function RefreshTable() {
        $( "#mytable" ).load( "<?php echo base_url().index_page()."new_client/home/view_uploaded_files/".$order_details[0]['id'].'/'.$action_id;?> #mytable" );
    }
    $("#view").on("click", RefreshTable);

	//list attachments
    <?php if(isset($cacheid)){ ?>
	   function attachment_list(){
		   $.ajax({
			  url: "<?php echo base_url().index_page()."new_client/home/order_cache/".$cacheid;?>",
			  dataType: "json",
			  success: function(data){
				  $('#tbody').html('');
				  var count = data.length;
				  console.log(count);
				  for(var i=0;i<count;i++){
					  $('#tbody').append(data[i]);
				  }
			  }
			 
		   });
	   }
	   
	   $("#view_cache_files").on("click", function(){ 
		   attachment_list();
	   });
	   
	   //remove order cache attachment
		function remove_att_cache(fname){  
			var x = confirm("Delete the item "+fname+" ?")
			if(x == true){
			   $.ajax({
				  url: "<?php echo base_url().index_page()."new_client/home/remove_att_cache/".$cacheid;?>/"+fname,
				  success: function(data){
					  //attachment_list();
				  }
				 
			   });
			}
		}
    <?php } ?>
            	
	
</script>										

<script>
    //remove attachment
		function remove_att_file(fname){ 
			var x = confirm("Delete the item "+fname+" ?")
			if(x == true){
			   $.ajax({
				  url: "<?php echo base_url().index_page()."new_client/home/rev_remove_att/".$order_details[0]['id'];?>/"+fname,
				  success: function(data){
					  //attachment_list();
				  }
				 
			   });
			}
		}
		
		function toggleCard(cardHeader) { 
		var markUpId = cardHeader.attributes.id.nodeValue; //console.log(markUpId);
		if(markUpId == 'mark-up-tool'){ 
		    //alert('markUp'); 
		}
          cardHeader.parentNode.classList.toggle("open");
        }
</script>