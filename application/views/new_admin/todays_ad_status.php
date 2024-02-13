<?php $this->load->view('new_admin/header')?>

<script type="text/javascript" src="http://adwitdigital.com/adwitads425/assets/management/script/jquery.slimscroll.min.js"></script>	

<link rel="stylesheet" type="text/css" href="http://adwitdigital.com/adwitads425/assets/management/css/dataTables.scroller.min.css">
	
<!-- BEGIN PAGE CONTAINER -->

<div class="row margin-top-15">
	<div class="col-sm-12">
	<div class="portlet-title border-bottom margin-bottom-10">
	<div class="row">	
		<div class="col-md-7 col-xs-12">
			<span class="font-lg">Today's Ads Status</span> 
		</div>				
		<div class="col-md-5 col-xs-12 text-right">	
			<div class="btn-group left-dropdown">
				<span class="btn bg-grey btn-xs dropdown margin-right-10 margin-bottom-10" data-toggle="dropdown" aria-expanded="true">
					<a id="filter">Select Helpdesk <i class="fa fa-angle-down"></i></a>
				</span>
				<ul class="dropdown-menu">
					<?php 
					$types = $this->db->get_where('help_desk', array('active' => '1'))->result_array(); 
					foreach($types as $type) {?>
					<li><a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_status'; ?>/<?php echo $type['id'];?>"> 
					<?php echo $type['name']; ?></a></li>
				<?php } ?>
				</ul>
				<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>

<div class="row">	
	<div class="col-md-6 col-xs-12">
	<div class="portlet light border padding-top-0">					
	<div class="portlet-title">					
		<div class="caption">
			<span class="font-md font-grey-gallery bold">total</span>
		</div>
		<?php if(isset($today_ad_status)){?>
		<div class="tools">
		<?php $total_count = 0;
				  $today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
						
					//Time	
					$ystday_time = $today_date_time[0]['time'];
					$today_time = $today_date_time[1]['time'];
					$tomo_time = $today_date_time[2]['time'];
					
					//Day
					$current_date = date("Y-m-d");
					$day = date("D", strtotime($current_date));
					$ysterday = date("Y-m-d", strtotime(' -1 day'));
					$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
					$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
					
					$tomo = date("Y-m-d", strtotime(' +1 day'));
					
					$current_time = date("H:i:s");
					
					$dbyst_all_orders = '0'; $dbyyst_all_orders = '0'; $all_orders = '0';
					if($day == 'Mon'){
						$dbyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4' OR '5' AND '7') AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
					}
					if($day == 'Mon' || $day == 'Sun'){
						$dbyyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4' OR '5' AND '7') AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1'  AND `group_id`!='0';")->num_rows();// Monday OR Sunday
					}
					if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
						$all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4' OR '5' AND '7') AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//All
					}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
						$all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4' OR '5' AND '7') AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//All
					}
					$total_count = $total_count + $all_orders + $dbyst_all_orders + $dbyyst_all_orders ;
					
			?>
		<a href="<?php echo base_url().index_page().'new_admin/home/todays_ad_details'; ?>">
		<span class="badge"><?php echo $total_count; ?></span></a> 
		</div>
		<?php }?>
	</div>
	
	<div class="portlet-body form">
		<div data-spy="scroll"  style="height:100px" data-target="#navbar-example2" data-offset="0" >
			<?php if(isset($today_ad_status)){?>
			<ul class="list-group">
			<?php 
				$dbyst_all_orders = '0'; $dbyyst_all_orders = '0'; $all_orders = '0';
				$dbyst_all_order = '0'; $dbyyst_all_order = '0'; $all_order = '0';
				
				if($day == 'Mon'){
					$dbyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4') AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
					$dbyst_all_order = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '5' AND '7') AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
				}
				if($day == 'Mon' || $day == 'Sun'){
					$dbyyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status`BETWEEN '1' AND '4') AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();// Monday OR Sunday
					$dbyyst_all_order = $this->db->query("SELECT * FROM `orders` WHERE (`status`BETWEEN '5' AND '7') AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();// Monday OR Sunday
				}
				if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
					$all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4') AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Yday and today
					$all_order = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '5' AND '7') AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Yday and today
				}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
					$all_orders = $this->db->query("SELECT * FROM `orders` WHERE (`status`BETWEEN '1' AND '4') AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//today and tomorrow
					$all_order = $this->db->query("SELECT * FROM `orders` WHERE (`status`BETWEEN '5' AND '7') AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//today and tomorrow
				}
			?>
			<li class="list-group-item">Pending 
				<a href="<?php echo base_url().index_page().'new_admin/home/pending_status'; ?>"><span class="pull-right"><?php echo $all_orders + $dbyst_all_orders + $dbyyst_all_orders;?>&nbsp;</span></a>
			</li>
			<li class="list-group-item">Sent 
				<a href="<?php echo base_url().index_page().'new_admin/home/sent_status'; ?>"><span class="pull-right"><?php echo $all_order + $dbyst_all_order + $dbyyst_all_order;?>&nbsp;</span></a>
			</li>
			<?php }?>
			</ul>				
		</div>
	</div>
	</div>
	</div>

	<?php if($id!=''){?>
	<div class="col-md-6 col-xs-12">
	<div class="portlet light border padding-top-0" >					
	<div class="portlet-title">					
		<div class="caption">
			<span class="font-md font-grey-gallery bold"><?php $hd_name = $this->db->get_where('help_desk',array('id' => $id))->row_array(); echo $hd_name['name'];?> Status </span>
		</div>
		<?php if(isset($today_status)){?>
		<div class="tools">
		<?php $total_count = 0; $sent_total_count = 0;
			  $today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
					
				//Time	
				$ystday_time = $today_date_time[0]['time'];
				$today_time = $today_date_time[1]['time'];
				$tomo_time = $today_date_time[2]['time'];
				
				//Day
				$current_date = date("Y-m-d");
				$day = date("D", strtotime($current_date));
				$ysterday = date("Y-m-d", strtotime(' -1 day'));
				$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
				$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
				
				$tomo = date("Y-m-d", strtotime(' +1 day'));
				
				$current_time = date("H:i:s");
				foreach($today_status as $row){
					$dbyst_all_orders = '0'; $dbyyst_all_orders = '0'; $all_orders = '0';
					
					if($day == 'Mon'){
						$dbyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row['id']."' AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
					}
					if($day == 'Mon' || $day == 'Sun'){
						$dbyyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row['id']."' AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();// Monday OR Sunday
					}if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
						$all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row['id']."' AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Yday and today
					}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
						$all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row['id']."' AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1'  AND `group_id`!='0';")->num_rows();//today and tomorrow
					}
					$total_count = $total_count + $all_orders + $dbyst_all_orders + $dbyyst_all_orders ;
			}	
			
			$sent_dbyst_all_orders = '0'; $sent_dbyyst_all_orders = '0'; $sent_all_orders = '0';
			
			if($day == 'Mon'){
					$sent_dbyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7')  AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
			}
			if($day == 'Mon' || $day == 'Sun'){
				$sent_dbyyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7')  AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();// Monday OR Sunday
			}
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
				$sent_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Yday and today
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
				$sent_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//today and tomorrow
			}
			$sent_total_count = $sent_total_count + $sent_all_orders + $sent_dbyst_all_orders + $sent_dbyyst_all_orders ;
		?>
		Total: <a href="<?php echo base_url().index_page().'new_admin/home/hd_total_status/'.$id; ?>"><span class="badge"><?php echo $total_count + $sent_total_count ; ?></span></a> 
		</div>
		<?php }?>
	</div>

	<div class="portlet-body form">
		<div data-spy="scroll"  style="height:230px" data-target="#navbar-example2" data-offset="0" class="scrollspy-example">
			<?php if(isset($today_status)){?>
			<ul class="list-group">
		<?php 
				foreach($today_status as $row1){
				$dbyst_all_orders = '0'; $dbyyst_all_orders = '0'; $all_orders = '0';
				
				if($day == 'Mon'){
					$dbyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row1['id']."'  AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
				}
				if($day == 'Mon' || $day == 'Sun'){
					$dbyyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row1['id']."'  AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();// Monday OR Sunday
				}
				if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
					$all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row1['id']."'  AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Yday and today
				}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
					$all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status` = '".$row1['id']."' AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//today and tomorrow
				}
		?>
		<li class="list-group-item"> <?php echo $row1['name'];?>
		<a href="<?php echo base_url().index_page().'new_admin/home/pending_hd_status/'.$id.'/'.$row1['id']; ?>"><span class="pull-right"> <?php echo $all_orders + $dbyst_all_orders + $dbyyst_all_orders;?>&nbsp;</span></a>
		</li>
			<?php } 
			$sent_dbyst_all_orders = '0'; $sent_dbyyst_all_orders = '0'; $sent_all_orders = '0';
				
				if($day == 'Mon'){
					$sent_dbyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7')  AND (`created_on` LIKE '$day_before_yyday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Monday
				}
				if($day == 'Mon' || $day == 'Sun'){
					$sent_dbyyst_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7')  AND (`created_on` LIKE '$day_before_yday%') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();// Monday OR Sunday
				}
				if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
					$sent_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//Yday and today
				}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
					$sent_all_orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1' AND `group_id`!='0';")->num_rows();//today and tomorrow
				}
			?>
		<li class="list-group-item"> <?php echo 'Sent';?> 
		<a href="<?php echo base_url().index_page().'new_admin/home/sent_hd_status/'.$id; ?>">	<span class="pull-right"> <?php echo $sent_all_orders + $sent_dbyst_all_orders + $sent_dbyyst_all_orders;?>&nbsp;</span></a>
		</li>	
			<?php } ?>
		</ul>
		</div>
	</div>
	</div>
	</div>
</div>

<?php }?>

<?php $this->load->view('new_admin/footer')?>
