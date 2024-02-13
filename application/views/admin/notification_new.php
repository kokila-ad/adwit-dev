<?php $this->load->view('admin/head1')?>
<script type="text/javascript" src="assets/admin/scripts/jquery.1.12.min.js"></script> 

<style>
.padding-5 {padding: 5px;}
</style>

<script type="text/javascript">
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="publication"){
                $(".box").not(".publication").hide();
                $(".publication").show();
            }
            else if($(this).attr("value")=="adrep"){
                $(".box").not(".adrep").hide();
                $(".adrep").show();
            }
            else{
                $(".box").hide();
            }
        });
    }).change();
	
	 $('#display_type').change(function() {
		    window.location = "<?php echo base_url().index_page().'admin/home/notification_new/';?>" + $('#display_type').val() ;
        });
		
});

</script>
		<div class="page-content-wrapper">
			<div class="page-content">	 
				<div class="portlet light">
					<div class="portlet-title">
						<div class="row">
							<div class="col-md-4">
							<h3 class="page-title no-space">Notifications</h3>
							</div>
							<div class="col-md-4 text-center margin-top-5">
							<?php echo '<span style="color:#900;">'.$this->session->flashdata('successful').'</span>'; ?>
							</div>
						</div>
					</div>
					<div class="portlet-body">
					<div class="row">
						<form role="form" method="post" enctype="multipart/form-data" onsubmit="return checkTheBox();">
						<div class="col-sm-4">
							<select id="display_type" name="display_type" class="padding-5 margin-bottom-10 bg-blue-chambray">
								<option value="">Select</option>
								<option value="publication" <?php echo ($display_type=='publication' ? 'selected="selected"' : ''); ?>>Publication</option>
								<option value="adrep" <?php echo ($display_type=='adrep' ? 'selected="selected"' : ''); ?>>AdRep</option>
							</select>
							
							<?php if($display_type=='publication'){?>	
							<div class="publication box" style="display: block;">				
								<div class="scroller" style="height:296px;" data-always-visible="1" data-rail-visible="0">	
									<table class="table table-hover" id="sample_3">
										<thead>
											<tr>
												<th class="group-checkable" data-set="#sample_3 "/></th>
												<th>Select</th>
											</tr>
										</thead>
										<tbody>
										<?php if(isset($publication)){?>
										<?php foreach($publication as $row){?>
											<tr class="odd gradeX">
												<td><input type="checkbox" name="pId[]" class="checkboxes" value="<?php echo $row['id'];?>"/></td>
												<td><?php echo $row['name'];?></td>
											</tr>
											<?php }?>
											<?php }?>
										</tbody>
									</table>
								</div>
								
							</div>
							<?php }?>
							
							<?php if($display_type=='adrep'){?>	
							<div class="adrep box">
								<div class="scroller" style="height:296px;" data-always-visible="1" data-rail-visible="0">	
									<table class="table table-hover" id="sample_5">
										<thead>
											<tr>
												<th class="group-checkable" data-set="#sample_5 "/></th>
												<th>Select</th>
											</tr>
										</thead>
										<tbody>
										<?php if(isset($adrep)){?>
										<?php foreach($adrep as $row){?>
											<tr class="odd gradeX">
												<td><input type="checkbox" name="aId[]" class="checkboxes" value="<?php echo $row['id'];?>"  value="1"/></td>
												<td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
											</tr>
											<?php }?>
											<?php }?>
										</tbody>
									</table>
								</div>
							</div>	
							<?php }?>							
						</div>
						
						<div class="col-md-4">
						<!--<label>To:</label>
						<input type="text" name ="to_select" class="form-control margin-bottom-15">-->
						
						<label>Headline:</label>
						<input type="text" name="headline" class="form-control margin-bottom-15" required>
						<label>Message:</label>
						<textarea name="message" class="form-control margin-bottom-15" required></textarea>
						</div>
						<div class="col-md-4">
							<label>Start Date:</label>
							<div class="input-group date date-picker margin-bottom-15" data-date="2016-10-12" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
								<input type="text"  name="start_date"  placeholder="YYYY-MM-DD" class="form-control">
								<span class="input-group-btn">
								<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
							<label>End Date:</label>
							<div class="input-group date date-picker margin-bottom-15" data-date="2016-10-12" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
								<input type="text"  name="end_date" placeholder="YYYY-MM-DD" class="form-control">
								<span class="input-group-btn">
								<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
							<label>Attach Image:</label>
							<input type="file" name="file" class="form-control margin-bottom-15 padding-5">
							<div class="text-right">
								<button type="submit" name="submit" class="btn btn-primary margin-bottom-15">Submit</button>
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
<?php $this->load->view('admin/foot')?>