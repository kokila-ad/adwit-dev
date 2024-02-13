<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Team_Controller {

	public function index()
	{
		$this->load->view('team-lead/home');
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('team-lead/change',$data);
	}
	
	public function dochange()
	{
		$admin_pwd_date = $this->db->query("SELECT * from `pwd_expiry_date` WHERE `user` = 'teamlead'")->result_array();
			$num_days = $admin_pwd_date[0]['num_days'];
			$date_update = date('Y-m-d', strtotime("$num_days day"));
		$this->db->query("Update team_lead set password='".md5($this->input->post('new_password'))."' , pwd_expiry_date='$date_update' where (username='".$this->session->userdata('team')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->change('Your password has been changed successfully!', 'darkgreen');
		else
			$this->change('Invalid current password!', 'darkred');
	}
	
	public function my_account($tab='1')
	{
		$data['tab'] = $tab;
		$id = $this->session->userdata('tId');
		
		if(isset($_POST['personal_info']) && (!empty($_POST['first_name']) || !empty($_POST['last_name']) || !empty($_POST['mobile_no']))){
			$post = array();
			if(!empty($_POST['first_name'])){ $post['first_name'] = $_POST['first_name']; }
			if(!empty($_POST['last_name'])){ $post['last_name'] = $_POST['last_name']; }
			if(!empty($_POST['mobile_no'])){ $post['mobile_no'] = $_POST['mobile_no']; }
			$this->db->where('id', $id);
			$this->db->update('team_lead', $post);  
			$data['error'] = "changed successfully!!";
			$data['color'] = 'darkred';
		}
		//avatar
		if(isset($_POST['change_avatar']) && !empty($_FILES['file']['name'])){
			$file_size = $_FILES['file']['size'];
			if($file_size > 100000){
				 $this->session->set_flashdata('size_message',"Image size should not exceed 150KB!!");
					redirect('team-lead/home/my_account#tab_1_2'); 
			} else {
			$uploadDir = "images/team_lead/".$id.".jpg";
			if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadDir)){
				$data = array( 'image' => $uploadDir );
				$this->db->where('id', $id);
				$this->db->update('team_lead', $data);  
			}else{
				$data['error'] = "Error Uploading!!";
				$data['color'] = 'darkred';
			}
			$data['tab'] = '2'; 
		}
		}
		if(isset($_POST['remove_pic']) && !empty($_POST['team_id'])){ 
			$default_path = "images/ad-img.jpg";
			$t_id = $_POST['team_id'];
			$this->db->query("Update team_lead set image = '$default_path' where id = '$t_id'");
			redirect('team-lead/home/my_account#tab_1_2');
		    }
		$data['team'] = $this->db->get_where('team_lead',array('id' => $id))->result_array();
		$this->load->view('team-lead/my_account', $data);
	}
	
	public function add_designer()
	{
		$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		$tid = $this->session->userdata('tId');
		if(isset($_POST['add_button']) && !empty($_POST['did'])){
			$dataa = array(
			'teamlead_id' => $tid,
			'designer_id' => $_POST['did'],
			);
			$this->db->insert('tag_designer_teamlead',$dataa);
			redirect('team-lead/home/add_designer');
		}
		if(isset($_POST['remove_button']) && !empty($_POST['rid'])){
			$id = $_POST['rid'];
			$this->db->query("DELETE FROM `tag_designer_teamlead` WHERE `id` = '$id'");
			redirect('team-lead/home/add_designer');
		}
		$this->load->view('team-lead/add_designer',$data);
	}
	
	public function notifications()
	{
		$this->load->helper('date');
		$today = date('Y-m-d');
		$tid = $this->session->userdata('tId');
		$notification1 = $this->db->query("SELECT * FROM `notification` WHERE `users` = '4' AND `job_status` = '1'")->result_array();
		if($notification1){
			foreach($notification1 as $row ){
				if($today > $row['end_date'])
				{
					$dataa = array('job_status' => 0);
					$this->db->where('id', $row['id']);
					$this->db->update('notification', $dataa);
				}
			}
		}
		$notification = $this->db->query("SELECT * FROM `notification` WHERE ('$today' BETWEEN `start_date` AND `end_date`) AND `users` = '4' AND `job_status` = '1'")->result_array();
		if($notification){ $data['notification'] = $notification; }else{ $data['message'] = 'No Notifications!!'; }
		$pwd_notification = $this->db->query("SELECT * FROM `team_lead` WHERE `id` = '$tid'")->result_array();
				if($pwd_notification){
				$data['pwd_notification'] = $pwd_notification; 
				$date1 = $pwd_notification[0]['pwd_expiry_date'];
				$data['today'] = $today;
				$data['date1'] = $date1;
				}
		$this->load->view('team-lead/notifications', $data);
	}
	
	public function meetings()
	{
		$this->load->view('team-lead/meetings');
	}
	
	public function meetups()
	{
		$this->load->view('team-lead/meetups');
	}
	
	public function reports()
	{
		$this->load->view('team-lead/reports');
	}
	
	public function image()
	{
		$uploadDir = "images/team_lead/".$this->session->userdata('tId')."/";
		
		if(isset($_POST['Submit']))
		{
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES['Photo']["name"]);
			$extension = end($temp);
			if ((($_FILES['Photo']['type'] == "image/gif")
			|| ($_FILES['Photo']['type'] == "image/jpeg")
			|| ($_FILES['Photo']['type'] == "image/jpg")
			|| ($_FILES['Photo']['type'] == "image/pjpeg")
			|| ($_FILES['Photo']['type'] == "image/x-png")
			|| ($_FILES['Photo']['type'] == "image/png"))
			&& ($_FILES['Photo']['size'] < 30000)
			&& in_array($extension, $allowedExts))
			{
				$fileName = $_FILES['Photo']['name'];
				$tmpName  = $_FILES['Photo']['tmp_name'];
				$fileSize = $_FILES['Photo']['size'];
				$fileType = $_FILES['Photo']['type'];
				
				if (@mkdir($uploadDir,0777))
				{}
				
				$filePath = $uploadDir . 'profile.png';
				$result = move_uploaded_file($tmpName, $filePath);
				if (!$result) {
					echo "Error uploading file";
					exit;
				}
				$data = array('image' => $filePath);
				$this->db->where('id', $this->session->userdata('tId'));
				$this->db->update('team_lead', $data); 
				redirect('team-lead/home/change');
			}else{ echo "Invalid file type";}
		}
		$this->load->view('team-lead/image');
		
	}
	
	public function jobtrack()
	{
		$team_id = $this->db->get_where('team_lead',array('id' => $this->session->userdata('tId')))->result_array();
		$order_id = $this->db->get_where('orders_dup',array('team_lead' => $team_id[0]['username'], 'job_status' => 'unchecked'))->result_array();
		$count = $this->db->get_where('orders_dup',array('team_lead' => $team_id[0]['username'], 'job_status' => 'unchecked'))->num_rows();
		$cat = $this->db->get('cat_minmax')->result_array();
		$data['order_id']=$order_id;
		$data['cat']=$cat;
		$data['count']=$count;
		$this->load->view('team-lead/job-assign',$data);
		
	}
	
	public function category()
	{
	
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			
			$this->form_validation->set_rules('order_no', 'Order Number', 'trim|required');
			
			$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric');
			
			$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric');
			
			$this->form_validation->set_rules('job_name', 'job_name', 'trim|required');
			
			$this->form_validation->set_rules('no_pages', 'No Pages', 'trim|required');
			
			$this->form_validation->set_rules('adtype', 'Adtype', 'trim|required');
			
			$this->form_validation->set_rules('artinst', 'Artinst', 'trim|required');
				
			$this->form_validation->set_rules('cat_news', 'Newspaper', 'trim|required');
			
		
		$adtype = $this->db->get('cat_new_adtype')->result_array();
		$artinst = $this->db->get('cat_artinstruction')->result_array();
		$newspaper = $this->db->get('cat_newspaper')->result_array();
		
		$data['adtype'] = $adtype;
		$data['artinst'] = $artinst;
		$data['newspaper'] = $newspaper;
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('team-lead/cat-view', $data);
		}
		else
		{
			if(isset($_POST['order_no']))
			{
				$cat_check = $this->db->get_where('cat_result',array('order_no' => $_POST["order_no"]))->result_array();
				if($cat_check)
				{
					$error = "Duplicate entry!!";
					$data['error'] = $error;
				}
				else
				{
					$width = $_POST['width'];
					$height = $_POST['height'];
					$art = $_POST['artinst'];
					$adtype = $_POST['adtype'];
					
					$size = $width * $height;
					if($size == '0')
					{
						redirect('team-lead/home/category');
					}
					
					if($adtype == '2'|| $adtype == '4')
					{
						if($size <= '20')
						{
							$category = "A";
							if($art == 2) $category = "B";
						}elseif($size <= '75' )
						{
							$category = "B";
							if($art == 2) $category = "C";
						}else{ $category = "c";
								if($art == 2) $category = "D";
						}
					}
					
					if($adtype == '3')
					{
						if($size <= '40')
						{
							$category = "C";
							if($art == 2) $category = "D";
						}elseif($size <= '100')
						{
							$category = "D";
							if($art == 2) $category = "E";
						}elseif($size <= '150')
						{
							$category = "E";
							if($art == 2) $category = "F";
						}else{ $category = "F";
								if($art == 2) $category = "G";
						}
					}
							
					if($adtype == '5')
					{
						$category = "B";
						if($art == 2) $category = "C";
					}
					
					if($adtype == '6')
					{
						if($size <= '20')
						{
							$category = "A";
							if($art == 2) $category = "B";
						}elseif($size <= '75' )
						{
							$category = "B";
							if($art == 2) $category = "C";
						}else{ $category = "c";
								if($art == 2) $category = "D";
						}
					}
					
					if($adtype == '7')
					{
						if($size <= '100')
						{
							$category = "D";
							if($art == 2) $category = "E";
						}elseif($size <= '150')
						{
							$category = "E";
							if($art == 2) $category = "F";
						}else{ $category = "F";
								if($art == 2) $category = "G";
						}
					}
					
					if($adtype == '8')
					{
						if($size <= '20')
						{
							$category = "B";
							if($art == 2) $category = "C";
						}elseif($size <= '75' )
						{
							$category = "C";
							if($art == 2) $category = "D";
						}else{ $category = "D";
								if($art == 2) $category = "E";
						}
					}
					
					if($adtype == '1')
					{
						$category = "A";
						if($art == 2) $category = "B";
					}
					
					$data['category'] = $category;
				}	
			}
			
			if(isset($_POST['confirm']))
			{
				if($_POST['cat_news']!="")
				{
					$rest = $_POST['cat_news'];
					$result_explode = explode('|', $rest);
					$initial = $result_explode[0];
					$slug_type = $result_explode[1];
				}
				$dataa = array(
							'order_no' => $_POST['order_no'],
							'job_name' => $_POST['job_name'],
							'width' => $_POST['width'],
							'height' => $_POST['height'],
							'num_pages' => $_POST['no_pages'],
							'artinstruction' => $_POST['artinst'],
							'adtypewt' => $_POST['adtype'],
							'news_initial' => $initial,
							'slug_type' => $slug_type,
							'category' => $_POST['category'],
							);
				$this->db->insert('cat_result',$dataa);	
				redirect('team-lead/home/category');
			}
			$this->load->view('team-lead/cat-view', $data);
		}
	}

	public function search()
	{
		$order_num = $_POST['order_num'];
		echo "order number :".$order_num;
	}
	
	public function job_list()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('Asia/Calcutta');
		}
		$tday= date('Y-m-d');
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `date`= '$tday ' OR `date`='$ystday' ;")->result_array();
		
		$data['cat_result'] = $cat_result;
		
		$this->load->view('team-lead/job-list',$data);
	}	
	
	public function QA_report()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$tday= date('Y-m-d');
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$pystday = date('Y-m-d', strtotime(' -2 day'));
		$designer = $this->db->get_where('designers',array('design_team_lead' => $this->session->userdata('tId')))->result_array();
		
		$data['tday'] = $tday;
		$data['ystday'] = $ystday;
		$data['pystday'] = $pystday;
		$data['designer'] = $designer;
		
		$this->load->view('team-lead/QA-report',$data);
	}
	
	public function shift_factor()
	{
		$data['hi'] = 'hi';
		
		if(isset($_POST['submit']))
		{
			$data = array( 'shift_factor_status' => '1' );
			$this->db->where('id', $this->session->userdata('dId'));
			$this->db->update('designers', $data);
			
		}
		$designers = $this->db->get_where('designers',array('design_team_lead' => $this->session->userdata('tId'), 'shift_factor_status !=' => '1'))->result_array();
		if($designers) $data['designers'] = $designers;
		$this->load->view('team-lead/shift-factor', $data);
	}

	public function production_table($form = '')
	{ 
		$data['hi'] = 'hello';
		if($form!='')
		{	
			$data['form'] = $form;
			
			$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['from'] = $from;
				$data['to'] = $to;
			 
			}
			$designer = $this->db->get_where('designers',array('team' => $form))->result_array() ;
			$data['designer'] = $designer;	
		}
		$this->load->view('team-lead/production',$data);
	}
	
	public function team()
	{
				$tid = $this->session->userdata('tId');
				$teams = $this->db->query("SELECT * FROM `designers` WHERE `team`= '$tid';")->result_array();
				$data['teams'] = $teams;	
					$this->load->view('team-lead/team',$data);
	}
	
	public function job_table($form='')
	{
	  
	    if($form!='')
	  	  {
			$tid = $this->session->userdata('tId');
			$list = $this->db->get_where('cat_result',array('publication_id' => $form))->result_array() ;
			$data['list'] = $list;	
	   }else{
			$tid = $this->session->userdata('tId');
			$list = $this->db->query("SELECT `date`,`order_no` , `designer` , `publication_id`,`job_name` ,`height` ,`width` , publications.team_lead_id FROM `cat_result` , `publications` WHERE publications.team_lead_id = '$tid' AND cat_result.publication_id = publications.id")->result_array();
			$data['list'] = $list;	
		  }
		   $data['form'] = $form;
		   $this->load->view('team-lead/job_table',$data);
	  }
	  
	public function pending_list()
	{
		  $tid = $this->session->userdata('tId');
		  $list = $this->db->query("SELECT `date`,`order_no` ,`job_name` ,'cat_result.designer',`height` ,`width` , publications.team_lead_id FROM `cat_result` , `publications` WHERE publications.team_lead_id = '$tid' AND cat_result.publication_id = publications.id AND cat_result.designer='0'")->result_array();
		  $data['list'] = $list;	
		  $this->load->view('team-lead/job_table',$data);	
	  }  

	public function cshift($form = '', $display_type='')
	{
		$tId = $this->session->userdata('tId');
		$data['display_type'] = $display_type ;
		$data['form'] = $form;
		if($form!='' /* && $display_type!='' */)
		{
			$tracker_date = $this->db->query("SELECT * FROM `print_ad_tracker_date` WHERE `hd` = '".$form."'")->result_array();
			$num_days = $tracker_date[0]['num_days'];

			if($num_days != '0'){
				$ystday = date('Y-m-d 00:00:00', strtotime("-$num_days day")); $data['ystday'] = $ystday; //in days
			}else{
				$ystday =  ($tracker_date[0]['date'].' 00:00:00'); $data['ystday'] = $ystday; //in date
			}
			$today = date('Y-m-d 23:59:59');
			
			//Assign Annex
			if(isset($_POST['submit']) && isset($_POST['cat_id'])){
				foreach($_POST['assign'] as $item) 
				{
					$post = array('assign' => $_POST['submit']);
					$this->db->where('id', $item);
					$this->db->update('cat_result', $post);
				}
			}
			//Tag Designer
			if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
				foreach($_POST['assign_designer'] as $item_id) 
				{
					$post1 = array('tag_designer' => $_POST['submit_designer']);
					$this->db->where('id', $item_id);
					$this->db->update('cat_result', $post1);
				}
			}
			$data['form'] = $form;
			$data['today'] = $today;
			$data['ystday'] = $ystday;
			$data['orders_pending'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4' OR `status` ='8')  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All pending
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Assign
			
			$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `teamlead_id` = '$tId' ")->result_array();	
			$data['orders_upload'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='3' OR `status`='4') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//data for Pending upload passing to view
			$data['orders_inproduction'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND  `status`='3'  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//design check
			$data['DC_order_count'] = $this->db->query("SELECT * FROM orders 
				left outer join cat_result on orders.id = cat_result.order_no
					WHERE orders.order_type_id!='1' AND orders.help_desk='".$form."' AND orders.cancel='0' AND orders.crequest!='1' AND orders.status = '3'
						AND (orders.created_on BETWEEN '$ystday' AND '$today') AND (cat_result.pro_status = '2' OR cat_result.pro_status = '8')")->num_rows(); 
			
			$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
			$ystday_time = $today_date_time[0]['time'];
			$today_time = $today_date_time[1]['time'];
			$tomo_time = $today_date_time[2]['time'];
			 
			$current_date = date("Y-m-d");
			$ysterday = date("Y-m-d", strtotime(' -1 day'));
			$tomo = date("Y-m-d", strtotime(' +1 day'));
			$ct = date("H:i:s");
			if($ct >= '00:00:00' && $ct <= '08:29:59'){
				$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
			}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
				$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
			}
			$data['design_assign'] = $this->db->get('design_assign')->result_array();
			$this->load->view('team-lead/cshift',$data);
			} else { 
			$this->load->view('team-lead/cshift_hd');	//only helpdesk
		} 
	}
	
	function all_orders()
	{
		$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
			$ystday_time = $today_date_time[0]['time'];
			$today_time = $today_date_time[1]['time'];
			$tomo_time = $today_date_time[2]['time'];
			 
			$current_date = date("Y-m-d");
			$ysterday = date("Y-m-d", strtotime(' -1 day'));
			$tomo = date("Y-m-d", strtotime(' +1 day'));
			$ct = date("H:i:s");
			if($ct >= '00:00:00' && $ct <= '08:29:59'){
				$all_orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id`!='1' AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
			}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
				$all_orders = $this->db->query("SELECT * FROM `orders` WHERE  `order_type_id`!='1' AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
			}
			echo count($all_orders);
			$demo = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id`!='1' AND (`created_on` BETWEEN '2016-09-22 08:30:00' AND '2016-09-23 08:29:59') AND `crequest`!='1' AND `cancel`!='1'")->num_rows();
			
	}
	
	public function web_cshift($display_type = '')
	{
	 	$data['display_type'] = $display_type ;
		$tId = $this->session->userdata('tId');
		$today = date('Y-m-d 23:59:59'); $data['today'] = $today;
		if(isset($_POST['submit']) && isset($_POST['cat_id'])){
			foreach($_POST['assign'] as $item) 
				{
				 $post = array('assign' => $_POST['submit']);
				 $this->db->where('id', $item);
				 $this->db->update('cat_result', $post);
			}
		}
		
		//Tag Designer
			if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
				foreach($_POST['assign_designer'] as $item_id) 
				{
					$post1 = array('tag_designer' => $_POST['submit_designer']);
					$this->db->where('id', $item_id);
					$this->db->update('cat_result', $post1);
				}
			}
		   $order_days = $this->db->query("SELECT * FROM `web_ad_tracker_date`")->result_array();
		   $ystday = ($order_days[0]['date'].' 00:00:00'); $data['ystday'] = $ystday;
		   $data['orders_pending'] = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4')  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All pending
		   $data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id`='1' AND  (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Assign
		   $data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `teamlead_id` = '$tId' ")->result_array();
		   $data['orders_inproduction'] = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND  `status`='3'  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//design check
			$this->load->view('team-lead/web_cshift',$data);
		
	}
	
	public function attachments($form = '', $id = '')
	{
		if($id != '')
		{
			$order = $this->db->get_where('orders',array('id' => $id))->result_array();
			if($order && $order[0]['file_path']!='none')
			{
				$soft_attachments = $this->db->get_where('soft_attachments',array('order_no' => $id))->result_array();
				if($soft_attachments){ $data['soft_attachments'] = $soft_attachments; }
				$data['order'] = $order[0];
				$this->load->view('team-lead/attachments',$data);
			}else{
				$this->session->set_flashdata('message','No Attachments For Order : '.$id);
				redirect('team-lead/home/cshift/'.$form);
			}
		}
	}
	
	public function zip_folder() 
	{
		if(isset($_POST['file_path']) && !empty($_POST['file_path']))
		{
			$this->load->library('zip');
		
			$path = $_POST['file_path'].'/';
			if($this->zip->read_dir($path, FALSE)){
				$this->zip->download($_POST['file_name']); 
			}else{
				echo "<script>alert('Couldnt Actually Download!!')</script>";
			}
		}
	}
	
	public function cshift_search($form='')
	{
		if(isset($_POST['search']) && !empty($_POST['id'])){
			$order = $this->db->query("SELECT * FROM `orders` WHERE `id`='".$_POST['id']."' OR `job_no`='".$_POST['id']."';")->result_array();
			if($order){
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='".$_POST['id']."' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ $data['rev_orders'] = $rev_orders; }
				$data['form'] = $order[0]['help_desk'];
				$data['order'] = $order;
				$this->load->view('team-lead/cshift_search',$data);	
			}else{
				$data['msg'] = "hello";
				$this->load->view('team-lead/cshift_search',$data);
			}
		}
	}
	
	public function my_profile($num_days='') 
	{  
	  $data['today'] = date('Y-m-d');
	  $tId = $this->session->userdata('tId');
	  if($num_days!=''){
	   $data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
	   $data['to'] = date('Y-m-d');
	  }
	  $data['num_days'] = $num_days;
	  $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `design_team_lead` = '$tId' AND `is_active`='1' ")->result_array();
	  $this->load->view('team-lead/my_profile',$data);		
	}
	
	public function lock()
	{
	    $data['hi']="hi";
	    if(!empty($_POST['password']))
		 {
		 $check = $this->db->get_where('team_lead',array('password' =>md5($_POST['password']), 'id'=>($_POST['aid'])))->result_array();
		 if($check==true)
		 {
		redirect('team-lead/home');
		 } else { $data['psd'] = "Wrong Password Please Try Again!!";}
		 }
		$this->load->view('team-lead/lock', $data);
	}		
	
	public function help() 
	{
		$this->load->view('team-lead/help');		
	}
	
public function orderview($hd="",$order_id="")
	{
		$redirect = 'team-lead/home/orderview/'.$hd.'/'.$order_id;
		$data['order_id']= $order_id;
		$data['hd']= $hd;
		$redirect = 'team-lead/home/orderview/'.$hd.'/'.$order_id;
		$data['redirect'] = $redirect;
		$orders= $this->db->query("SELECT * FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		$this->load->helper('directory');
			$pickup_downloads = "downloads/pickup/".$order_id;
			$pickup_map_downloads = directory_map($pickup_downloads.'/');
			if($pickup_map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['pickup_downloads']= $pickup_downloads; 
			}
		$data['fname']=$this->db->get_where('print_ad_types',array('id' => $orders[0]['print_ad_type']))->result_array();
		$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`= '$order_id' ")->result_array();
		if(!$cat){
		   $this->session->set_flashdata('message','Order not Yet Categorized');
			redirect('team-lead/home/cshift/'.$hd.'/all');
		}
		$data['orders']= $orders;
		$data['cat']= $cat;
		$slug = $cat[0]['slug'];
		$sourcefile="sourcefile/".$order_id.'/'.$slug;
		$data['sourcefile']= $sourcefile;
		$data['note_tl_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'tl_designer'))->result_array();
		$data['note_tl_qa'] = $this->db->get_where('note_teamlead_designer',array('display' => 'tl_qa'))->result_array();
		$data['note_tl_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'tl_dc'))->result_array();
		if($cat[0]['designer']!='0') $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();
		if($cat[0]['csr']!='0') $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr']."'")->result_array();
		//if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
		if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
		$cp_tool = $this->db->query("SELECT * from `cp_tool` where `order_no` = '$order_id' ")->result_array();
		if($cp_tool)
		{
			$data['cp_tool'] = $cp_tool;
			$data['csr_name1'] = $this->db->get_where('csr',array('id' => $cp_tool[0]['csr']))->result_array();
		}
		$dc_reason = $this->db->query("SELECT * from `dc_reason` where `order_id` = '$order_id' ")->result_array();
		if($dc_reason){ $data['dc_reason'] = $dc_reason; }
		
		$qa_reason = $this->db->query("SELECT * from `qa_reason` where `order_id` = '$order_id' ")->result_array();
		if($qa_reason){ $data['qa_reason'] = $qa_reason; }
		
		$designer_message = $this->db->query("SELECT * from `designer_message` where `order_id` = '$order_id' ")->result_array();
		 if($designer_message){
			$data['designer_message'] = $designer_message;
			} 
		if(!empty($order_id) && !empty($hd))
	    {
			$job_no= $orders[0]['job_no'];
			$dir= "downloads/".$order_id."-".$job_no;
			$dir1= $sourcefile;
			if($dir) { $data['dir'] = $dir;
			$data['file_format']= $this->db->get('file_format')->result_array();
			}
			if($dir1) { $data['dir1'] = $dir1; }
        }	
		if(isset($_POST['reassign']))
		{
		   $dataa = array(
				 'designer' => '0',
				 'dlocation' => '0',
				 'version' => '', 
				 'slug' => 'none',
				 'ddate' => '0000-00-00',
				 'start_time' => '',
				 'shift_factor' => '',
				 'pro_status' => '0',
				  );
			 $this->db->where('order_no', $order_id);
			 $this->db->update('cat_result', $dataa); 
				 
			 //QA
			 $cat_id = $_POST['cat_result_id'];
			 $this->db->query("DELETE FROM `QA` WHERE `order_no` = '$order_id' AND `cat_result_id` = '$cat_id'");
			 
			 //designer_ads_time deletion
			 $designer_ads_time = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`= '$order_id' ")->result_array();
			 if($designer_ads_time){
				 $this->db->query("DELETE FROM `designer_ads_time` WHERE `order_id` = '$order_id'");
			 }
			 
			 
			//order status
			$post_status = array('status' => '2');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status);
			
			$path = "sourcefile/".$order_id;
			if(is_dir($path)){
				$this->emptyDir($path);
				rmdir($path);
			}
			redirect('team-lead/home/cshift/'.$hd);
		}  
		if(isset($_POST['sent']))
		{
			$tl_time = 	date("H:i:s");
			$tl_date = 	date("Y:m:d");
			$data1 = array('pro_status'=> '3', 'tl_time'=>  $tl_time , 'tl_date'=>  $tl_date , 'tl_id'=>$this->session->userdata('tId'));
			$this->db->where('order_no', $_POST['order_id']); 
			$this->db->update('cat_result', $data1);
			
			if(!empty($_POST['tl_QA_reason']) && strlen(trim($_POST['tl_QA_reason'])) != 0){
			//QA reason 
			if($_POST['tl_QA_reason'] == 'others'){
				$msg = $_POST['QA_reason'];
				}else{
				$msg = $_POST['tl_QA_reason'];
				}
			$qa_data = array('order_id' => $order_id, 'tl_id' => $this->session->userdata('tId'), 'message' => $msg, 'operation' =>'tl_QA');	
			$this->db->insert('production_conversation',$qa_data);
			}
			//Tag CSR
			$pub_id = $_POST['publication_id'];
			$tag_publication = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$pub_id'")->result_array();
			if($tag_publication && $cat[0]['tag_csr'] == '0'){
				$csr_id = $tag_publication[0]['tag_csr'];
				$tag_data = array('tag_csr'=> $csr_id); 
				$this->db->where('order_no', $order_id); 
				$this->db->update('cat_result', $tag_data);
			}
			// Order Status
			$data1 = array('status'=> '4');
			$this->db->where('id', $order_id); 
			$this->db->update('orders', $data1);
			if($orders[0]['order_type_id']=='1'){
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('team-lead/home/web_cshift/'.$hd.'/design_check');	//redirect to web_cshift page
				}else{
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('team-lead/home/cshift/'.$hd.'/design_check');	//redirect to cshift page
				}
		}
		
		if(isset($_POST['sent_designer']) && isset($_POST['tl_msg']))
	    {
			$file_path = 'none';
			if(!empty($_FILES['file2']['name'])) 
			{
				$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['file2']['name']); $ext = '.'.$ext;
				$file_format = $this->db->get('file_format')->result_array();
				$up_load = '0';
				foreach($file_format as $format){
				 if($format['name'] == $ext){ $up_load = '1'; }
				}
				if($up_load == '1'){
					$dir1="sourcefile/".$order_id.'/'.$slug;
					$dir2 = $dir1.'/Tl_change';
					$file_path = $dir2.'/'.$_FILES['file2']['name'];
					if (@mkdir($dir2,0777))
					{}
					move_uploaded_file($_FILES['file2']['tmp_name'],$dir2.'/'.$_FILES['file2']['name']);
				}else{
					$this->session->set_flashdata("ext_message",$ext." Extension not allowed.. Please upload only allowed file types.. Try Again!!");
					redirect($redirect);
				}
			}
			$time=date("Y:m:d H:i:s"); 
			if($_POST['tl_msg'] == 'others'){
				$msg = $_POST['tl_note'];
			}else{
				$msg = $_POST['tl_msg'];
			}
			$data2 = array('order_id'=> $order_id , 'message'=>$msg ,  'tl_id'=>$this->session->userdata('tId') , 'time'=>$time, 'operation' => 'tl_designer', 'file_path' => $file_path);
			$this->db->insert('production_conversation', $data2);
				// Status Update
			$data1 = array('pro_status'=> '6');
			$this->db->where('order_no', $order_id); 
			$this->db->update('cat_result', $data1);
			if($orders[0]['order_type_id']=='1'){
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('team-lead/home/web_cshift/'.$hd.'/design_check');	//redirect to web_cshift page
				}else{
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('team-lead/home/cshift/'.$hd.'/design_check');	//redirect to cshift page
				} 
		}		
			if(isset($_POST['send_DC']) && isset($_POST['tl_dc_reason'])){	
				if($_POST['tl_dc_reason'] == 'others'){
				$msg = $_POST['DC_reason'];
				}else{
				$msg = $_POST['tl_dc_reason'];
				}
				$dc_data = array('order_id' => $order_id, 'tl_id' => $this->session->userdata('tId'), 'message' => $msg, 'operation'=>'tl_DC');	
				$this->db->insert('production_conversation',$dc_data);
				
				$pro_status = array('pro_status' => '4');			
				$this->db->where('order_no', $order_id);		
				$this->db->update('cat_result', $pro_status);	
				// Order Status
				$data2 = array('status'=> '4');
				$this->db->where('id', $order_id); 
				$this->db->update('orders', $data2);	
				if($orders[0]['order_type_id']=='1'){
					$this->session->set_flashdata("ext_message","Sent To DC successfully!!!");
					redirect('team-lead/home/web_cshift/'.$hd.'/design_check');	//redirect to web_cshift page
				}else{
					$this->session->set_flashdata("ext_message","Sent To DC successfully!!!");
					redirect('team-lead/home/cshift/'.$hd.'/design_check');	//redirect to cshift page
				}
			}  
			
		if(isset($_POST['make_changes']))
		{
			$data3 = array('pro_status'=> '8');
					$this->db->where('order_no', $order_id);  
					$this->db->update('cat_result', $data3);
					redirect('team-lead/home/orderview/'.$hd.'/'.$order_id);
		}
		 		 //Source Files upload
		if(isset($_POST['sourceUpload']) && isset($_POST['sourcefile']))
		{
			$fileuploadstatus = $this->db->get_where('cat_result',array('order_no'=>$order_id))->result_array();
				if($fileuploadstatus[0]['source_path'] != 'none')
				{
					$source_path = $fileuploadstatus[0]['source_path'];
					$slug = $_POST['slug'];
					
					if($orders[0]['order_type_id'] == '1'){
						$inddfile = $source_path.'/'.$slug.".psd";
						$pdffile = glob($source_path.'/'.$slug.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
						if(!file_exists($inddfile)){
							$this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!");
							redirect($redirect);
						}elseif(!$pdffile){
							$this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!");
							redirect($redirect);
						}
					}else{
						$inddfile = $source_path.'/'.$slug.".indd";
						$pdffile = $source_path.'/'.$slug.".pdf";
						if(!file_exists($inddfile)){
							$this->session->set_flashdata("file_message","SourceFile(indd) Missing..!!");
							redirect($redirect);
						}elseif(!file_exists($pdffile)){
							$this->session->set_flashdata("file_message","PDF File Missing..!!");
							redirect($redirect);
						}
					}
					$link_path = $source_path.'/Links';
					$font_path = $source_path.'/Document fonts';
					}else{ redirect($redirect); $this->session->set_flashdata("file_message","Source Files Missing..!!");  } 

					// cat Result status Update
					$pro_status = array('pro_status' => '2', 'source_path' => $sourcefile);//In design check
					$this->db->where('order_no', $order_id);
					$this->db->update('cat_result', $pro_status);
					$this->session->set_flashdata("file_message","files uploaded successfully..!!");
					redirect('team-lead/home/orderview/'.$hd.'/'.$order_id);				
		} 
		
		if(isset($_POST['upload_complete']) && isset($_POST['order_id'])){ 
			$data4 = array('pro_status'=> '2');
						$this->db->where('order_no', $order_id); 
						$this->db->update('cat_result', $data4);
						redirect('team-lead/home/orderview/'.$hd.'/'.$order_id);
		}
		
		//changes from TL
		$tl_path = $sourcefile.'/Tl_change';
		$map_tl_path = directory_map($tl_path.'/');
		if($map_tl_path){ $data['tl_path']= $tl_path; }
		//changes from CSR
		$csr_path = $sourcefile.'/csr_change'; 
		$map_csr_path = directory_map($csr_path.'/');
		if($map_csr_path){ $data['csr_path']= $csr_path; }
		//changes from DC CSR
		$dc_csr_path = $sourcefile.'/DC_change'; 
		$map_dc_csr_path = directory_map($dc_csr_path.'/');
		if($map_dc_csr_path){ $data['dc_csr_path']= $dc_csr_path; } 
		$this->load->view('team-lead/orderview', $data);	
	 } 
	 
	public function new_fileuploads($order_id)
	{
		$slug = $_POST['slug_name'];
		$filetype = $_POST['file_type'];
		//Links folder
		$link_path = 'sourcefile'.'/'.$order_id.'/'.$slug.'/Links';
		if (@mkdir($link_path,0777)){}
		
		//Document fonts folder
		$font_path = 'sourcefile'.'/'.$order_id.'/'.$slug.'/Document fonts';
		if (@mkdir($font_path,0777)){}	
			
			$sourcefile = 'sourcefile'.'/'.$order_id.'/'.$slug;
					$pro_status = array('source_path' => $sourcefile);
					$this->db->where('order_no', $order_id);
					$this->db->update('cat_result', $pro_status);
					
		if($filetype == 'indd' || $filetype == 'psd' || $filetype == 'pdf' || $filetype == 'images' )
		{
				if(!empty($_FILES))
					{
						$path = 'sourcefile'.'/'.$order_id.'/'.$slug;
						if (@mkdir($path,0777)){}
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
							$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						redirect('team-lead/home'); }
					}
		}
					
		elseif($filetype == 'fonts')
		{
			if(!empty($_FILES))
						{
							$path = 'sourcefile'.'/'.$order_id.'/'.$slug.'/Document fonts';
							if (@mkdir($path,0777)){}
							$tempFile = $_FILES['file']['tmp_name'];
							$fileName = $_FILES['file']['name'];
							if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
								$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
							redirect('team-lead/home'); }
						}
		}elseif($filetype == 'links')
		{
			if(!empty($_FILES))
						{
							$path = 'sourcefile'.'/'.$order_id.'/'.$slug.'/Links';
							if (@mkdir($path,0777)){}
							$tempFile = $_FILES['file']['tmp_name'];
							$fileName = $_FILES['file']['name'];
							if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
								$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
							redirect('team-lead/home'); }
						}
		}
					
	}
	 
	public function rev_orderview($hd="",$order_id="")
	{
		$data['hi']= 'hello';
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		if(isset($orders[0]['id']) && $hd!='' && $order_id!='')
		{
			$redirect = 'team-lead/home/rev_orderview/'.$hd.'/'.$order_id;
			$data['order_form'] = $orders[0]['file_path'].'/'.$orders[0]['job_no'].".html";
			
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `job_accept`='1' AND `cancel`='0' ORDER BY `id` DESC")->result_array();
			$data['prev_rev_orders'] = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `pdf_path`!='none' ORDER BY `id` DESC LIMIT 1")->result_array();
			if(!$rev_orders){
				$this->session->set_flashdata("message","Order: Details not Found..!!");
				redirect('team-lead/home');
			}
			
		if(isset($_POST['reassign']))
		{
		   $dataa = array(
				 'designer' => '0',
				 'new_slug' => 'none',
				 'ddate' => '0000-00-00',
				 'status' => '2',
				  );
			 $this->db->where('order_id', $order_id);
			 $this->db->update('rev_sold_jobs', $dataa); 
			 redirect('team-lead/home/cshift/'.$hd);
		}
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			$data['cat']= $cat;
			$data['hd']= $hd;
			$data['order_id']= $order_id;
			$data['rev_orders']= $rev_orders;
			$data['orders']= $orders;
			$sourcefile = 'sourcefile/'.$order_id.'/'.$cat[0]['slug'] ;
			$data['sourcefile'] = $sourcefile;
			
		}else{
			$this->session->set_flashdata("message", $order_id." Order: Details not Found..!!");
			redirect('team-lead/home');
		}
		$this->load->view('team-lead/rev_orderview', $data);
	}
		 
	function source_file_uploads($redirect)
	{
		$sourcefile = $_POST['sourcefile']; $count=0;
		//Links folder
		$link_path = $sourcefile.'/Links';
		if (@mkdir($link_path,0777))
		{

		}
		//Document fonts folder
		$font_path = $sourcefile.'/Document fonts';
		if (@mkdir($font_path,0777))
		{

		}	
		//Source
			if(isset($_FILES['src_file']['name']) && !empty($_FILES['src_file']['tmp_name'])){
					$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['src_file']['name']);
					$fname = $_POST['slug'].'.'.$ext;
					if($_FILES['src_file']['name']==$fname){
						$sourcePath = $_FILES['src_file']['tmp_name'];
						$targetPath =  $sourcefile.'/'.$_FILES['src_file']['name'];
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Source file.. Try Again!!");
							redirect($redirect);
						}
					}else{
						$this->session->set_flashdata("msg", "<p class='alert alert-danger text-center'>Sorry Wrong File.. Make sure that the file names are same as the slug!!</p>");
						redirect($redirect); 
					}
				}
			//PDF
			if(isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['tmp_name'])){
					$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['pdf_file']['name']);
					$fname = $_POST['slug'].'.'.$ext; 
					if($_FILES['pdf_file']['name']==$fname){
						$sourcePath = $_FILES['pdf_file']['tmp_name'];
						$targetPath =  $sourcefile.'/'.$_FILES['pdf_file']['name'];
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Pdf file.. Try Again!!");
							redirect($redirect);
						}
					}else{
						$this->session->set_flashdata("msg", "<p class='alert alert-danger text-center'>Sorry Wrong File.. Make sure that the file names are same as the slug!!</p>");
						redirect($redirect); 
					}
				}	
			//Links
			if(isset($_FILES['link_file']['tmp_name']) && !empty($_FILES['link_file']['tmp_name'][0])){
					$link_path = $sourcefile.'/Links';
					if (@mkdir($link_path,0777))
					{

					}
					$count= count($_FILES['link_file']['name']);
					for($i=0;$i<$count;$i++){
						$sourcePath = $_FILES['link_file']['tmp_name'][$i];
						$targetPath =  $link_path.'/'.$_FILES['link_file']['name'][$i];
						 
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Link files.. Try Again!!".$count);
							redirect($redirect);
						}
					}
				}
			//Fonts
			if(isset($_FILES['font_file']['tmp_name']) && !empty($_FILES['font_file']['tmp_name'][0])){
					$font_path = $sourcefile.'/Document fonts';
					if (@mkdir($font_path,0777))
					{

					}
					$count= count($_FILES['font_file']['name']);
					for($i=0;$i<$count;$i++){
						$sourcePath = $_FILES['font_file']['tmp_name'][$i];
						$targetPath =  $font_path.'/'.$_FILES['font_file']['name'][$i];
						 
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Font files.. Try Again!!");
							redirect($redirect);
						}
					}
				}
				
		return true;
			
	}
	
	public function attach_pickup_file($order_id='')
	{
		if(isset($_POST['pickup_submit']))
	    {
			$dir1="downloads/pickup/".$order_id;
			if (!is_dir($dir1)) {
            mkdir($dir1, 0777, true);
			}
			$file = array(); $path = array();
			for($i=0;$i<5;$i++)	//file data sent to create_folder function
			{
				if (!empty($_FILES['file']['tmp_name'][$i]))
				{
					//replace filename with special char with '_'
					$file[] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $_FILES['file']['name'][$i]);
					
					//upload path
					$path[]= $dir1.'/'.$file[$i];
					
					//copy file 
					if(!copy($_FILES['file']['tmp_name'][$i], $path[$i]))
					{
						$this->session->set_flashdata("pickup_message","File upload has encountered an error!! Try Again...");
						if(isset($_POST['redirect'])) redirect($_POST['redirect']);
					}else{
						$this->session->set_flashdata('pickup_message','<p class="btn green btn-xs margin-right-10">File Uploaded Successfully</p>');
						//$this->session->set_flashdata("message","File Uploaded Successfully");
						if(isset($_POST['redirect'])) redirect($_POST['redirect']);
					}
				} 
			}
		}
			  if(isset($_POST['redirect'])) redirect($_POST['redirect']);
	}
	
	public function cshift_tracker($form='', $display_type='assign')
	{
		$today = date('Y-m-d 23:59:59');
		$data['display_type'] = $display_type;
		if($form!='')
		{
			$tracker_date = $this->db->query("SELECT * FROM `print_ad_tracker_date` WHERE `hd` = '".$form."'")->result_array();
			$num_days = $tracker_date[0]['num_days'];
			if($num_days != '0'){
				$ystday = date('Y-m-d 00:00:00', strtotime("-$num_days day")); $data['ystday'] = $ystday; //in days
			}else{
				$ystday =  ($tracker_date[0]['date'].' 00:00:00'); $data['ystday'] = $ystday; //in date
			}
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//In assign count
			$data['orders_inproduction'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND  `status`='3'  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//design check
			$data['orders_pending'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4')  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All pending
			$data['form'] = $form;
			$this->load->view('team-lead/cshift_tracker' , $data);
		}else{
			$this->load->view('team-lead/helpdesk' , $data);
		}
	} 
	
	public function zip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			if(isset($_POST['order_id'])){
				//new ad
				$order_id = $_POST['order_id'];
			}else{
				//revision
				$order_id = $new_slug;
			}
			
			$SourceFilePath = $_POST['source_path'] ;
			$source_file = $_POST['source_file'];
			$pdf_file = $new_slug.'.pdf';
			
			if(!isset($_POST['download'])){
				//source download option
				$pdf_uploads = "pdf_uploads/".$order_id ;
				if (@mkdir($pdf_uploads,0777)){}
			}
			
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
			if(file_exists($pdf_path)){
				$this->zip->read_file($pdf_path);
			}else{ 
				$this->load->helper('directory');	
				$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
				if($map){ foreach($map as $row){
					$this->zip->read_file($row);
				} }
			}
			$map_font = directory_map($font_path);
			$map_link = directory_map($links_path);
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){
				$this->zip->read_dir($links_path, FALSE);
			}	
			
			 
			if(isset($_POST['download'])){
				$this->zip->archive($SourceFilePath.'/'.$new_slug.'.zip');
				$this->zip->download($new_slug.'.zip');
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
	}
	
	function emptyDir($dir)
	{
		if (is_dir($dir)) {
			$scn = scandir($dir);
			foreach ($scn as $files) {
				if ($files !== '.') {
					if ($files !== '..') {
						if (!is_dir($dir . '/' . $files)) {
							unlink($dir . '/' . $files);
						} else {
							$this->emptyDir($dir . '/' . $files);
							rmdir($dir . '/' . $files);
						}
					}
				}
			}
		}
	}
	
	public function team_lead_NJ($num_days='')
	{  
	  $data['today'] = date('Y-m-d');
	  $tId = $this->session->userdata('tId');
	  if($num_days!=''){
	   $data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
	   $data['to'] = date('Y-m-d');
	  }
	  $data['num_days'] = $num_days;
	  $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `design_team_lead` = '$tId' AND `is_active`='1' ")->result_array();

	  $this->load->view('team-lead/team_lead_NJ',$data);
	 }
	 
	 
}