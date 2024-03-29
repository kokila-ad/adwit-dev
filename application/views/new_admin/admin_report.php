<?php $this->load->view('new_admin/header.php'); ?>
<style>
	.option-theme5 {
		border: 1px solid #444d58 !important;
		color: #444d58 !important;
	}
	
	.option-theme5:hover, .active .option-theme5 {
		background-color: #444d58;
		color: #fff !important;
	}
	.only_mob{
		display: none;
	}
	.mob_hide{
		display: block;
	}
	@media only screen and (max-width: 500px){
		.only_mob{
			display: block;
		}
		.mob_hide{
			display: none;
		}
	}
	.btn-dark.btn-active {
    color: #fff;
    border-color: #333;
    background: #333;
	    font-size: 14px;
    padding: 8px 12px;
}
.btn:hover,.btn:active{
	background-color: #333333;
    color: white;
	    font-size: 14px;
    padding: 8px 12px;
}
.btn-dark{
border: 1px solid #333333;
    background-color: white;
	    font-size: 14px;
    padding: 8px 12px;
}
.hidden {
     display:none;
}
.form-group{
	    margin-bottom: 10px;
}
.left{
	right: 10px;
    position: relative;
}
</style>

<script>
    function deskView() {
		$(".mob_hide input").attr('required', true);
		$(".only_mob input").attr('required', false);
	}
	function mobView() {
		$(".mob_hide input").attr('required', false);
		$(".only_mob input").attr('required', true);
	}
	function toggler(divId) {
    $("#" + divId).toggle();
}
</script>

<script>
 $(document).ready(function(){
	if($('#adrep_id').val() != ''){ 
		$("#date_demo").show();
	} else {
		$("#date_demo").hide();
	}
	
	if($('#publication_id').val() != ''){ 
		$("#date_demo1").show();
	} else {
		$("#date_demo1").hide();
	}
	if($('#group_id').val() != ''){ 
		$("#date_demo2").show();
	} else {
		$("#date_demo2").hide();
	}
	if($('#csr_id').val() != ''){ 
		$("#cdate_demo").show();
	} else {
		$("#cdate_demo").hide();
	}
	if($('#ppcsr_id').val() != ''){ 
		$("#ppdate_demo").show();
	} else {
		$("#ppdate_demo").hide();
	}
	if($('#designer_id').val() != ''){ 
		$("#ddate_demo").show();
	} else {
		$("#ddate_demo").hide();
	}
	if($('#help_desk_id').val() != ''){ 
		$("#hdate_demo").show();
	} else {
		$("#hdate_demo").hide();
	}
	if($('#cgroup_id').val() != ''){ 
		$("#date_compare").show();
	} else {
		$("#date_compare").hide();
	}
	if($('#chd_id').val() != ''){ 
		$("#hd_date_compare").show();
	} else {
		$("#hd_date_compare").hide();
	}
	if($('#tl_hd_id').val() != ''){ 
		$("#tl_hd_date_compare").show();
	} else {
		$("#tl_hd_date_compare").hide();
	}
	
	$('#user_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/';?>" + $('#user_id').val() ;
	});
	
	$('#adrep_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#adrep_id').val() ;
	});
	
	$('#adrep_custom_date').change(function() {
		if($('#adrep_custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/report_sales_adrep/'.$type.'/'.$user.'/'.$id.'/';?>" + $('#adrep_custom_date').val() ;
		}
	});
	
	$('#publication_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#publication_id').val() ;
	});
	
	$('#pub_custom_date').change(function() {
		if($('#pub_custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/report_sales_publication/'.$type.'/'.$user.'/'.$id.'/';?>" + $('#pub_custom_date').val() ;
		}
	});
	
	$('#group_id').change(function() { 
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#group_id').val() ;
	});
	
	$('#grp_custom_date').change(function() {
		if($('#grp_custom_date').val() != 'custom'){
			window.location = "<?php echo base_url().index_page().'new_admin/home/report_sales_group/'.$type.'/'.$user.'/'.$id.'/';?>" + $('#grp_custom_date').val() ;
		}
	});
	
	$('#csr_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#csr_id').val() ;
	});
	
	$('#designer_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#designer_id').val() ;
	});
	
	$('#help_desk_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#help_desk_id').val() ;
	});
	
	$('#cgroup_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#cgroup_id').val() ;
	});
	
	$('#chd_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#chd_id').val() ;
	});
	$('#ppcsr_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#ppcsr_id').val() ;
	});
	
	$('#tl_hd_id').change(function() {
	window.location = "<?php echo base_url().index_page().'new_admin/home/admin_report/'.$type.'/'.$user.'/';?>" + $('#tl_hd_id').val() ;
	});
	
});
</script>

<div class="portlet light">
	<div class="portlet-body">		
	
			<div class="col-md-12 col-md-offset-2">	
				<?php if((isset($type)) && ($type == 'sales')) { ?>
				<div class="row">
				<div class="form-group has-success col-md-4 col-md-offset-2">
					<select id="user_id" name="user_id" class="select2me form-control">
						<option value="">Select</option>
						<!--<option value="channels" <?php if($user=='channels') echo 'selected';?>>Channels</option>-->
						<option value="groups" <?php if($user=='groups') echo 'selected';?>>Groups</option>
						<option value="publications" <?php if($user=='publications') echo 'selected';?>>Publications</option>
						<option value="adrep" <?php if($user=='adrep') echo 'selected';?> >Adrep</option>
						<option value="web_ads" <?php if($user=='web_ads') echo 'selected';?> >Web Ads</option>
					</select>
				</div>
				</div>
				<!---web_ads Report starts--->
				<?php if(isset($web_ads)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_web_ads/'.$type.'/'.$user;?>">
				<div class="row">
					<div id="web_date_demo" class="col-md-4 col-md-offset-2 ">	
					
						<div class="only_mob">
							<label>From Date:</label> 
							<input type="date" class="form-control margin-bottom-15" name="from" autocomplete="off"/>
							<label>To Date:</label> 
							<input type="date" class="form-control margin-bottom-15" name="to" autocomplete="off"/>
						</div>	
						
						<div class="mob_hide">
							<div class="input-group date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd"  data-date-end-date="+0d">
								<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off"/>
								<span class="input-group-addon">
								to </span>
								<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off"/>
							</div>
						</div>	
						
						<div class="margin-bottom-10 pull-right">
							<button type="submit" onclick="deskView()" name="search" class="mob_hide btn bg-red-intense border-radius-5">Submit</button>
							<button type="submit" onclick="mobView()" name="search" class="only_mob btn bg-red-intense border-radius-5">Submit</button>			
						</div>
					</div>
					</div>
			</form>
				<?php } ?>
			<!---web_ads Report ends--->
			
			<!---Adrep Report starts--->
				<?php if(isset($adrep)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_adrep/'.$type.'/'.$user.'/'.$id.'/custom';?>">
				<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<select id="adrep_id" name="adrep_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<?php foreach($adrep as $row) { 
						$pub_name = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$row['publication_id']."'")->row_array();
						?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['first_name'].' '.$row['last_name'].' '.'('.$pub_name['name'].')'; ?></option>
						<?php } ?>
					</select>
				</div>
				</div>
					<div id="date_demo">
					
					<div class="row">
					<div class="col-md-4 col-md-offset-2">
					<select id="adrep_custom_date"  name="adrep_custom_date" class="colorselector select2me form-control margin-bottom-10 border-radius-5 ">
						<option value="">Select</option>
						<option value="today">Today</option>
						<option value="one_week">1 Week</option>
						<!--<option value="two_week">2 Week</option>-->
						<option value="one_month">1 Month</option>
						<option value="three_month">3 Month</option>
						<!--<option value="six_month">6 Month</option>-->
						<option value="one_year">1 Year</option>
						<option value="custom">Custom</option>
					</select>
					</div>
						
					  </div></div>
					<div class="row " >
                        <div class="col-md-4 col-md-offset-2 colors" id="custom" style="display:none">
					  <div  class="input-group  date-picker input-daterange margin-bottom-15  " data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" name="order_type" value="2" style="display:none">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					<div class="margin-bottom-10  pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
					
					</div>
					<div class="row " >
    				    <div id="red" style="display:none" class="col-md-4 col-md-offset-5 left margin-bottom-10 colors ">
    						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit2</button>
    					</div>
					</div>
				</form>
				<?php } ?>
			<!---Adrep Report ends--->
			
			<!---Publication Report starts--->
				<?php if(isset($publications)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_publication/'.$type.'/'.$user.'/'.$id.'/custom';?>">
				<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<select id="publication_id" name="publication_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<?php foreach($publications as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name'] ; ?></option>
						<?php } ?>
					</select>
					</div>
				</div>
				<div id="date_demo1">	
				
					<div class="row">
					<div class="col-md-4 col-md-offset-2">
					<select id="pub_custom_date" name="pub_custom_date" class="colorselector select2me form-control margin-bottom-10 border-radius-5 ">
						<option value="">Select</option>
						<option value="today">Today</option>
						<option value="one_week">1 Week</option>
						<!--<option value="two_week">2 Week</option>-->
						<option value="one_month">1 Month</option>
						<option value="three_month">3 Month</option>
						<!--<option value="six_month">6 Month</option>-->
						<option value="one_year">1 Year</option>
						<option value="custom">Custom</option>
					</select>
					</div>
					  </div>
					  </div>
					<div class="row " >
                        <div class="col-md-4 col-md-offset-2 colors" id="custom" style="display:none">
					  <div  class="input-group  date-picker input-daterange margin-bottom-15  " data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" name="order_type" value="2" style="display:none">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					<div   class="margin-bottom-10  pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
					
					</div>
					<div class="row " >
				<div  id="red" style="display:none" class="col-md-4 col-md-offset-5 left margin-bottom-10 colors ">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
				</form>
				<?php } ?>
			<!---Publication Report ends--->
			
		
			<!---Group Report starts--->
				<?php if(isset($groups)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_group/'.$type.'/'.$user.'/'.$id.'/custom';?>">
				<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<select id="group_id" name="group_id" class="select2me form-control margin-bottom-10 border-radius-5 ">
						<option value="">Select</option>
						<?php foreach($groups as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name'] ; ?></option>
						<?php } ?>
					</select>
					</div>
				</div>
				<div id="date_demo2">
					<div class="row">
					<div class="col-md-4 col-md-offset-2">
					<select name="grp_custom_date" id="grp_custom_date" class="colorselector select2me form-control margin-bottom-10 border-radius-5 ">
						<option value="">Select</option>
						<option value="today">Today</option>
						<option value="one_week">1 Week</option>
						<!--<option value="two_week">2 Week</option>-->
						<option value="one_month">1 Month</option>
						<option value="three_month">3 Month</option>
						<!--<option value="six_month">6 Month</option>-->
						<option value="one_year">1 Year</option>
						<option value="custom">Custom</option>
					</select>
					</div>
					  </div>
				</div>
					<div class="row " >
                        <div class="col-md-4 col-md-offset-2 colors" id="custom" style="display:none">
					  <div  class="input-group  date-picker input-daterange margin-bottom-15  " data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" name="order_type" value="2" style="display:none">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					<div   class="margin-bottom-10  pull-right">
						<button type="submit"  class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
					
					</div>
					<div class="row " >
					<div  id="red" style="display:none" class="col-md-4 col-md-offset-5 left margin-bottom-10 colors ">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit2</button>
					</div>
					</div>
				</form>
				<?php } ?>
			<!---Group Report ends--->
			<?php } ?>
				
				<?php if((isset($type)) && ($type == 'csr_performance')) { ?>
				<div class="form-group has-success">
				
					<select id="user_id" name="user_id" class="select2me form-control">
						<option value="">Select</option>
						<option value="pcsr" <?php if($user=='pcsr') echo 'selected';?>>CSR</option>
					</select>
				</div>
			
				<!---CSR Performance starts--->
				<?php if(isset($pcsr)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_csr_performance/'.$type.'/'.$user;?>">
				<div class="row col-md-4 ">
					<select id="ppcsr_id" name="ppcsr_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($pcsr as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name']; ?></option>
						<?php } ?>
					</select>
					</div>
				<div id="ppdate_demo">
					<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon">
						to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
				</form>
				<?php } ?>
			<!---CSR Performance ends--->
				<?php } ?>
				
				<?php if((isset($type)) && ($type == 'production')) { ?>
				<div class="form-group has-success">
				
					<select id="user_id" name="user_id" class="select2me form-control">
						<option value="">Select</option>
						<option value="csr" <?php if($user=='csr') echo 'selected';?>>CSR</option>
						<option value="designer" <?php if($user=='designer') echo 'selected';?>>Designer</option>
						<option value="help_desk" <?php if($user=='help_desk') echo 'selected';?> >Helpdesk</option>
					</select>
				</div>
				
				<!---CSR Report starts--->
				<?php if(isset($csr)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_csr/'.$type.'/'.$user;?>">
					<select id="csr_id" name="csr_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($csr as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name']; ?></option>
						<?php } ?>
					</select>
				<div id="cdate_demo">
					<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon">
						to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
				</form>
				<?php } ?>
			<!---CSR Report ends--->
			
			<!---Designer Report starts--->
				<?php if(isset($designers)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_designer/'.$type.'/'.$user;?>">
					<select id="designer_id" name="designer_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($designers as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name']; ?></option>
						<?php } ?>
					</select>
				<div id="ddate_demo">
					<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon">
						to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
				</form>
				<?php } ?>
			<!---Designer Report ends--->
			
			<!---Helpdesk Report starts--->
				<?php if(isset($help_desk)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_sales_hd/'.$type.'/'.$user;?>">
					<select id="help_desk_id" name="help_desk_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($help_desk as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name']; ?></option>
						<?php } ?>
					</select>
				<div id="hdate_demo">
					<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon">
						to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
				</form>
				<?php } ?>
			<!---Helpdesk Report ends--->
				<?php } ?>
			
			<!---compare--->
			<?php if((isset($type)) && ($type == 'compare')) { ?>
				<div class="form-group has-success">
					<select id="user_id" name="user_id" class="select2me form-control">
						<option value="">Select</option>
						<!--<option value="channels" <?php if($user=='channels') echo 'selected';?>>Channels</option>-->
						<option value="groups" <?php if($user=='groups') echo 'selected';?>>Groups</option>
						<option value="help_desk" <?php if($user=='help_desk') echo 'selected';?> >Help desk</option>
					</select>
				</div>
			
			<!---Group Report starts--->
				<?php if(isset($groups)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_compare/'.$type.'/'.$user;?>">
					<select id="cgroup_id" name="cgroup_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($groups as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name'] ; ?></option>
						<?php } ?>
					</select>
				<div id="date_compare">
						<div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
						
					<div class="row">
					<div class="col-md-4 col-md-offset-2">
					<select id="custom_date" class="colorselector select2me form-control margin-bottom-10 border-radius-5 ">
						<option value="">Select</option>
						<option value="red"  value="">Today</option>
						<option value="red" value="">1 Week</option>
						<!--<option value="red"  value="">2 Week</option>-->
						<option value="red"  value="">1 Month</option>
						<option value="red"  value="">3 Month</option>
						<!--<option value="red"  value="">6 Month</option>-->
						<option value="red"  value="">1 Year</option>
						<option value="yellow"  value="">Custom</option>
					</select>
					</div>
						
					  </div></div>
					<div class="row " >
                        <div class="col-md-4 col-md-offset-2 colors" id="yellow" style="display:none">
					  <div  class="input-group  date-picker input-daterange margin-bottom-15  " data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" name="order_type" value="2" style="display:none">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					<div   class="margin-bottom-10  pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
					
					</div>
					<div class="row " >
				<div  id="red" style="display:none" class="col-md-4 col-md-offset-5 left margin-bottom-10 colors ">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
					</div>
				</form>
				<?php } ?>
			<!---Group Report ends--->
			
			<!---HD Report starts--->
				<?php if(isset($help_desk)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/report_compare/'.$type.'/'.$user;?>">
					<select id="chd_id" name="chd_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($help_desk as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name'] ; ?></option>
						<?php } ?>
					</select> 
				<div id="hd_date_compare">
					<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<!--<input type="text" name="order_type" value="2" style="display:none">-->
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon"> to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div> 
				</form>
				<?php } ?>
			<!---HD Report ends--->
			<?php } ?>
			<!---compare--->
			
			<!---tl qa--->
			
			<!--------- Publication count report starts------------->
    	
		<?php if((isset($type)) && ($type == 'Publication')) {
       ?>
		<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/publication_count/'.$type.'/'.$user;?>">
					
				<div id="yr_publication">
				
					<div style="float:left">
						<!--<input type="text" name="order_type" value="2" style="display:none">-->
						
						<select id="year" name="nm_year" class="select2me form-control margin-bottom-10 border-radius-5" placeholder="Date">
						<option value="">Select</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2016">2016</option>
						<option value="2015">2015</option>
						<option value="2014">2014</option>
						<option value="2013">2013</option>
						
					</select> 
					</div>	
			<div style="float:right">					
							<select id="month" name="nm_month" class="select2me form-control margin-bottom-10 border-radius-5" placeholder="Date">
						<option value="">Select</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">october</option>
						<option value="11">November</option>
						<option value="12">December</option>
						
					</select> 
					</div>
					<div style="float:right; clear: left;">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div> 
				</form>
	   <?php	
		}
		?>
			
		
		
<!----------Publication count report Ends------------->		
			
			
			<?php if((isset($type)) && ($type == 'tl_qa')) { ?>
				<div class="form-group has-success">
					<select id="user_id" name="user_id" class="select2me form-control">
						<option value="">Select</option>
						<option value="help_desk" <?php if($user=='help_desk') echo 'selected';?> >Help desk</option>
					</select>
				</div>
			
			<!---HD Report starts--->
				<?php if(isset($help_desk)) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/tl_qa_report/'.$type.'/'.$user;?>">
					<select id="tl_hd_id" name="tl_hd_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($help_desk as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name'] ; ?></option>
						<?php } ?>
					</select> 
				<div id="tl_hd_date_compare">
					<div class="input-group1  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<!--<input type="text" name="order_type" value="2" style="display:none">-->
						<input type="text" class="form-control border-radius-left" name="date" placeholder="Date" required/>
					</div>
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div> 
				</form>
				<?php } ?>
			<!---HD Report ends--->
			<?php } ?>
			
			<!---Design time--->
			<?php if((isset($type)) && ($type == 'design_time')) { ?>
				<form method="GET" action="<?php echo base_url().index_page().'new_admin/home/design_time/'.$type.'/'.$user;?>">
					<select id="designer_id" name="designer_id" class="select2me form-control margin-bottom-10 border-radius-5">
						<option value="">Select Designer</option>
						<option value="all" <?php if($id=='all') echo 'selected';?>>All</option>
						<?php foreach($designers as $row) { ?>
						<option value="<?php echo $row['id']?>" <?php if($id == $row['id']) echo 'selected';?> ><?php echo $row['name']; ?></option>
						<?php } ?>
					</select>
				<div id="ddate_demo">
					<div class="input-group  date-picker input-daterange margin-bottom-15" data-date="2012/11/10" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
						<input type="text" class="form-control border-radius-left" name="from" placeholder="From Date" autocomplete="off" required/>
						<span class="input-group-addon">
						to </span>
						<input type="text" class="form-control border-radius-right" name="to" placeholder="To Date" autocomplete="off" required/>
					</div>
					
					<div class="margin-bottom-10 pull-right">
						<button type="submit" name="search" class="btn bg-red-intense border-radius-5">Submit</button>
					</div>
				</div>
				</form>
			
			<!---Designer Report ends--->	
			<?php } ?>
			</div>	
			
			
			
		</div>	 
	</div>
</div>
<script>
 $(function() {
        $('.colorselector').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>	
				
<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>

