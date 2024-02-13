<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends New_Csr_Controller {
    
    public function __construct() {
    	parent:: __construct();
    	$this->load->helper("url");
    	$this->load->model("Pagination");
    	$this->load->library("pagination");
	}

	public function index() 
	{ //echo CI_VERSION;
		$csr_id = $this->session->userdata('sId');
		
		$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->row_array();
		$data['csr_alias'] = $csr_alias;
		
		$query = "SELECT rev_verify_comment.*, rev_sold_jobs.order_id, rev_sold_jobs.verification_type FROM `rev_verify_comment` 
			JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
			WHERE (rev_verify_comment.csr_id = '$csr_id' AND rev_verify_comment.csr_reply IS NULL ) OR (rev_verify_comment.rov_csr_id = '$csr_id' AND rev_verify_comment.rov_csr_reply IS NULL )"; 
		
		
		$data['r_review'] = $this->db->query("$query")->result_array();
		if($csr_id == 68){
		//pasword expiry
    		if(isset($csr_alias['pwd_date'])){
    			$now = time(); // or your date as well
    			$your_date = strtotime($csr_alias['pwd_date']);
    			$datediff = $now - $your_date;
    			$datediff = round($datediff / (60 * 60 * 24));
    			if($datediff > 30){
    				//echo'<script>alert("Reset Your Password..!!")</script>';
    				redirect('new_csr/home/pwd_expiry');
    			}
    		}
		}
			//order review for csr
		$from = date('Y-m-d', strtotime('-4 day'));
		$to = date('Y-m-d');
		//for v1a revision
		$data['cat_result'] = $this->db->query("SELECT cat_result.order_no, cat_result.version, cat_result.help_desk FROM `cat_result`
		                                           RIGHT JOIN `rev_sold_jobs` ON rev_sold_jobs.order_id = cat_result.order_no
		                                            WHERE cat_result.csr_QA = '$csr_id' AND (cat_result.date BETWEEN '$from' AND '$to') AND rev_sold_jobs.version = 'V1a'")->result_array();
		//for other revision                                            
		$data['csr_rev_list'] = $this->db->query("SELECT `id`, `order_id`, `version`, `help_desk` FROM rev_sold_jobs 
		                                            WHERE `rov_csr` = $csr_id AND `start_timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59'")->result_array();
		
		$this->load->view('new_csr/home',$data);
	}
	
	public function pwd_expiry()
	{
	    $this->load->library('encrypt');
		$secret_key = $this->encrypt->encode($this->session->userdata('sEmail').":".time());
		$this->db->update('csr',array('encrypted_key' => $secret_key), array('email_id' => $this->session->userdata('sEmail')));
		$this->session->sess_destroy();
		redirect('new_csr/login/change/'.$secret_key);
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('new_csr/change',$data);
	}
	
	public function dochange()
	{           
	    if($this->input->post('new_password')==$this->input->post('confirm_password'))
	    {
		   $admin_pwd_date = $this->db->query("SELECT `num_days` from `pwd_expiry_date` WHERE `user` = 'csr'")->result_array();
			$num_days = $admin_pwd_date[0]['num_days'];
			$today = date('Y-m-d');
			$date_update = date('Y-m-d', strtotime("$num_days day"));
			$this->db->query("Update csr set password='".md5($this->input->post('new_password'))."', pwd_date = '$today', pwd_expiry_date='$date_update' where (email_id='".$this->session->userdata('csr')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
			if($this->db->affected_rows()){
				$this->session->set_flashdata("pwd_message","Your password has been changed successfully!");
				redirect('new_csr/home/my_account#tab_1_3');
			}else{
				$this->session->set_flashdata("pwd_message","Invalid current password!");
				redirect('new_csr/home/my_account#tab_1_3');
			}
	    }
		$this->session->set_flashdata("pwd_message","These passwords don't match Try again?");
		redirect('new_csr/home/my_account#tab_1_3');
	}

	public function ordercshift_retain_cancel($hd = '', $order_id = '')
	{
		if($hd!='' && $order_id!='' && isset($_POST['retain']) && isset($_POST['retain_reason']))
		{
			$reason = $_POST['retain_reason'];
			//order status Qrequest
			$post_status = array('crequest' => '0');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status);
			
			//orders_cancel
			$timestamp = date('Y-m-d H:i:s');
			$post_cancel = array('order_id' => $order_id, 'csr' => $this->session->userdata('sId'), 'retain_reason' => $reason, 'Ctimestamp' => $timestamp);
			$this->db->insert('orders_cancel', $post_cancel);
			
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('crequest' => '0');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			redirect('new_csr/home/orderview/'.$hd.'/'.$order_id);
		}
	}
	 	
	public function request()
	{
		$data['request'] = $this->db->query("SELECT * FROM `requests` ;")->result_array();
		$this->load->view('new_csr/request',$data);
	}	
	
	public function request_details($id='')
	{
		$data['request'] = $this->db->query("SELECT * FROM `requests` WHERE id = '$id' ")->result_array();
		
		if(isset($_POST['submit']))
		{
			$details = array(
			'csr_msg' => $_POST['csr_msg'],
			'status' => '2'
			);
			$this->db->where('id', $id);
			$this->db->update('requests', $details);
			
			//request_table insertion
					$data1 = array(
					'csr_id' => $this->session->userdata('cId'),
					'message' => $_POST['csr_msg'],
					'filepath' => 'hi',
					'request_id' =>$id,
					);
					
					$this->db->insert('requests_details', $data1);
					$inserted_id= $this->db->insert_id();
			 // folder creation
				if (!empty($_FILES['userfile']['tmp_name']))
				{
				$dir = "requests/".$id;
					if (@mkdir($dir,0777))
					{}
					$path= $dir.'/'.$_FILES['userfile']['name'];
					if(!copy($_FILES['userfile']['tmp_name'], $path))
					{
						echo "<script>alert('Error: " . $_FILES['userfile']['tmp_name']["error"] ."')</script>";
					}else
					{ 
						$post = array( 'filepath' => $path );		//save file path to table
						$this->db->where('id', $inserted_id);
						$this->db->update('requests_details', $post); 
						//echo $path;
						
						
					}
				}
			redirect('new_csr/home/request');				
			
		}
		
		$this->load->view('new_csr/request_details',$data);
	}
	
	public function my_account($tab='1')
	{
		$data['tab'] = $tab;		
		$id = $this->session->userdata('sId');
		
		if(isset($_POST['personal_info']) && (!empty($_POST['name']) || !empty($_POST['mobile_no']))){
			$post = array();
			if(!empty($_POST['name'])){ $post['name'] = $_POST['name']; }
			if(!empty($_POST['mobile_no'])){ $post['mobile_no'] = $_POST['mobile_no']; }
			$this->db->where('id', $id);
			$this->db->update('csr', $post);  
			$data['error'] = "changed successfully!!";
			$data['color'] = 'darkred';
		}
		if(isset($_POST['change_avatar']) && !empty($_FILES['file']['name'])){
			$file_size = $_FILES['file']['size'];
			if($file_size > 100000){
				 $this->session->set_flashdata('size_message',"Image size should not exceed 150KB!!");
					redirect('new_csr/home/my_account#tab_1_2'); 
			} else {
			$uploadDir = "images/csr/".$id.".jpg";
			if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadDir)){
				$data = array( 'image_path' => $uploadDir );
				$this->db->where('id', $id);
				$this->db->update('csr', $data);  
			}else{
				$data['error'] = "Error Uploading!!";
				$data['color'] = 'darkred';
			} 
		 $data['tab'] = '2'; 
			}
		}
		if(isset($_POST['remove_pic']) && !empty($_POST['csr_id'])){ 
			$default_path = "images/ad-img.jpg";
			$c_id = $_POST['csr_id'];
			$this->db->query("Update csr set image_path = '$default_path' where id = '$c_id'");
			redirect('new_csr/home/my_account#tab_1_2');
		    }
		$csr_name = $this->db->get_where('csr',array('id' => $id))->result_array();
		$club_id = $csr_name[0]['club_id'];
		if($club_id != null && $club_id != 0){ 
			$assigned_pub = '';
			$q = "SELECT * FROM `publications` WHERE `club_id` IN (".$club_id.")";
			$publications = $this->db->query("$q")->result_array();
			foreach($publications as $publication){
				$assigned_pub .= $publication['name'].', ';
			}
			$data['assigned_pub'] = $assigned_pub;
		}
		
		$data['csr_name'] = $csr_name;
		$this->load->view('new_csr/my_account', $data);
	}
	
	public function notifications()  
	{
		$this->load->helper('date');
		$sId = $this->session->userdata('sId');
		$today = date('Y-m-d');
		$notification1 = $this->db->query("SELECT * FROM `notification` WHERE `users` = '3' AND `job_status` = '1'")->result_array();
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
		$notification = $this->db->query("SELECT * FROM `notification` WHERE ('$today' BETWEEN `start_date` AND `end_date`) AND `users` = '3' AND `job_status` = '1'")->result_array();
		if($notification){ $data['notification'] = $notification; }else{ $data['message'] = 'No Notifications!!'; }
		$pwd_notification = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		if($pwd_notification){
		$data['pwd_notification'] = $pwd_notification; 
		$date1 = $pwd_notification[0]['pwd_expiry_date'];
		$data['today'] = $today;
		$data['date1'] = $date1;
		}
		$this->load->view('new_csr/notifications',$data); 
	}
	
	public function reports($num_days='') 
	{  
		$data['today'] = date('Y-m-d');
		$sId = $this->session->userdata('sId');
		if($num_days!=''){
			if($num_days == 'curr_month'){
				$data['from'] = date('Y-m-01');
				$data['to'] = date('Y-m-d');
			}elseif($num_days == 'prev_month'){
				$data['from'] = date('Y-m-01', strtotime(' -1 month'));
				$data['to'] = date("Y-m-d", strtotime("last day of previous month"));
			}else{
				$data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
				$data['to'] = date('Y-m-d');
			}
		}
		$data['num_days'] = $num_days;
		$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		$this->load->view('new_csr/reports', $data);
	}
	
	public function csr_reports($num_days='') 
	{  
		$data['today'] = date('Y-m-d');
		$sId = $this->session->userdata('sId');
		if($num_days!=''){
			if($num_days == 'curr_month'){
				$data['from'] = date('Y-m-01');
				$data['to'] = date('Y-m-d');
			}elseif($num_days == 'prev_month'){
				$data['from'] = date('Y-m-01', strtotime(' -1 month'));
				$data['to'] = date("Y-m-d", strtotime("last day of previous month"));
			}else{
				$data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
				$data['to'] = date('Y-m-d');
			}
		}
		$print = $this->db->query("SELECT `name`, `csr_wt` FROM `print`")->result_array();
        foreach($print as $print_row){
            $name = $print_row['name'];
            $weight[$name] = $print_row['csr_wt'];
        }
        $data['weight'] = $weight;
		$data['num_days'] = $num_days;
		$data['csr'] = $this->db->query("SELECT `id`,`name`,`username` FROM `csr` WHERE `is_active` = '1'")->result_array();
		$this->load->view('new_csr/csr_reports', $data);
	}
	 
	public function new_category_old()
	{	
		if(isset($_POST['search']))
		{
			$order = $this->db->get_where('orders',array('id' => $_POST["order_chk"]))->result_array();
			if($order)
			{
				$data['order'] = $order;
				$this->adwit_category($data);
			}else{ 
				$error_data = "No result found!!";
				$data['error_data'] = $error_data;
				$this->load->view('new_csr/newcat-view',$data);
			}
		}else{	
			$this->load->view('new_csr/newcat-view');
		}
		
	}
		
	public function adwit_category_old($data = '')
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			
			$this->form_validation->set_rules('order_no', 'Order Number', 'trim');
			
			$this->form_validation->set_rules('width', 'Width', 'trim|is_numeric');
			
			$this->form_validation->set_rules('height', 'Height', 'trim|is_numeric');
			
			//$this->form_validation->set_rules('size', 'Size', 'trim|is_numeric');
			
			$this->form_validation->set_rules('job_name', 'job_name', 'trim');
			
			$this->form_validation->set_rules('adv_name', 'adv_name', 'trim');
			
			$this->form_validation->set_rules('adrep', 'Adrep', 'trim');
			
			$this->form_validation->set_rules('no_pages', 'No Pages', 'trim');
			
			$this->form_validation->set_rules('adtype', 'Adtype', 'trim');
			
			$this->form_validation->set_rules('artinst', 'Artinst', 'trim');
				
			$this->form_validation->set_rules('cat_news', 'Newspaper', 'trim|required');
			
			$this->form_validation->set_rules('priority', 'Priority', 'trim');
			
			$this->form_validation->set_rules('help_desk', 'Help Desk', 'trim');
			
			$this->form_validation->set_rules('instruction', 'Instruction', 'trim');
			
			$this->form_validation->set_rules('publication', 'Publication', 'trim');
		
		$adtype = $this->db->get('cat_new_adtype')->result_array();
		$artinst = $this->db->get('cat_artinstruction')->result_array();
		

		$data['adtype'] = $adtype;
		$data['artinst'] = $artinst;
		
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('new_csr/new-cat-view', $data);
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
						redirect('new_csr/home/cat_hd');
					}
					
					if($adtype == '2')
					{
						if($size <= '20')
						{
							$category = "A";
							if($art == 2) $category = "B";
						}elseif($size <= '75' )
						{
							$category = "B";
							if($art == 2) $category = "C";
						}else{ $category = "C";
								if($art == 2) $category = "D";
						}
					}
					
					if($adtype == '4')
					{
						if($size <= '20')
						{
							$category = "B";
							if($art == 2) $category = "B";
						}elseif($size <= '75' )
						{
							$category = "B";
							if($art == 2) $category = "C";
						}else{ $category = "C";
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
					
					if($adtype == '10')
					{
						$category = "D";
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
					$rest = $this->db->get_where('cat_newspaper',array('id' => $_POST['cat_news']))->result_array();
					$initial = $rest[0]['initials'];
					$slug_type = $rest[0]['slug_type'];
					$team = $rest[0]['team'];
				}
				$publication = $this->db->get_where('publications',array('id' => $_POST['publication']))->result_array();
				if($publication){ 
					$help_desk = $publication[0]['help_desk']; 
				}else{ $help_desk = '0'; }
				
				
				
				$dataa = array(
							'order_no' => $_POST['order_no'],
							'job_name' => $_POST['job_name'],
							'adrep' => $_POST['adrep'],
							'advertiser' => $_POST['adv_name'],
							'width' => $_POST['width'],
							'height' => $_POST['height'],
							'num_pages' => $_POST['no_pages'],
							'artinstruction' => $_POST['artinst'],
							'adtypewt' => $_POST['adtype'],
							'help_desk' => $help_desk,
							'news_id' => $_POST['cat_news'],
							'news_initial' => $initial,
							'team' => $team,
							'slug_type' => $slug_type,
							'category' => $_POST['category'],
							'instruction' => $_POST['instruction'],
							'csr' => $this->session->userdata('sId'),
							'date' => Date("Ymd"),
							'time' => date("His")
							);
				$this->db->insert('cat_result',$dataa);	
				$cat_id = $this->db->insert_id();
				
				if(isset($_POST['priority']))
				{
					
					if($_POST['adtype']=='1' || $_POST['adtype']=='2' || $_POST['adtype']=='3')
					{
						$status = 'pickup';
					}else{
						$status = 'new';
					}
					$data = array(
								'order_no' => $_POST['order_no'],
								'csr' => $this->session->userdata('sId'),
								'help_desk'  => $_POST['help_desk'],
								'date' => Date("Ymd"),
								'time' => date("His"),
								'category' => $status,
								);
					$this->db->insert('rev_sold_jobs',$data);
					$rev_id = $this->db->insert_id(); 
			
					$help_desk  = $_POST['help_desk'];
					
				}else{
					
					
					$data2 = array(
								'order_no' => $_POST['order_no'],
								'csr' => $this->session->userdata('sId'),
								'help_desk' => $help_desk,
								'news_id'  => $_POST['cat_news'],
								'date' => Date("Ymd"),
								'time' => date("His"),
								'category' => $_POST['category'],
								);
					$this->db->insert('cshift',$data2);
					//$help_desk  = $help_desk;
					$status = 'v1';
					
				}
				
				if($cat_id)
				{
					//order status
					$post_status = array('status' => '2');
					$this->db->where('id', $_POST['order_no']);
					$this->db->update('orders', $post_status);
					
					//Live_tracker Updation
					$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$_POST['order_no']."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $_POST['category'], 'status' => '2');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
				}
				redirect('new_csr/home/new_category');
			}
			$this->load->view('new_csr/new-cat-view', $data);
		}
	}
	
/*	public function cshift_category_org($order_id = 0)
	{
		//$orders = $this->db->query("SELECT * FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		$orders = $this->db->get_where('orders', array('id' => $order_id))->result_array();
		if(isset($orders[0]['id'])){
    		$sId = $this->session->userdata('sId');
    		$data['cancel_reason'] = $this->db->get('cancel_reason')->result_array();
    		$data['orders'] = $orders;
    		$data['order_id'] = $order_id;
    	    $hd = $orders[0]['help_desk'];
    		$data['hd'] = $hd;
    		$redirect = 'new_csr/home/cshift_category/'.$order_id;
    		$data['redirect']= $redirect;
    		$this->load->helper('directory');
    		$pickup_downloads = "downloads/pickup/".$order_id;
    			$pickup_map_downloads = directory_map($pickup_downloads.'/');
    			if($pickup_map_downloads){ 
    				$data['file_format']= $this->db->get('file_format')->result_array();
    				$data['pickup_downloads']= $pickup_downloads; 
    			}
    		 // For Attachment Files
    			   $job_no= $orders[0]['job_no'];
    			   $dir="downloads/".$order_id."-".$job_no;
    			if($dir){
    				$data['file_format']= $this->db->get('file_format')->result_array();
    				$data['dir'] = $dir; 
    			}
    		 
    		$this->load->helper(array('form', 'url'));
    
    		$this->load->library('form_validation');
    		
    		$this->form_validation->set_error_delimiters('<li>', '</li>');
    
    		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			
			$this->form_validation->set_rules('order_no', 'Order Number', 'trim');
			
			$this->form_validation->set_rules('width', 'Width', 'trim|is_numeric');
			
			$this->form_validation->set_rules('height', 'Height', 'trim|is_numeric');
			
			//$this->form_validation->set_rules('size', 'Size', 'trim|is_numeric');
			
			$this->form_validation->set_rules('job_name', 'job_name', 'trim');
			
			$this->form_validation->set_rules('adv_name', 'adv_name', 'trim');
			
			$this->form_validation->set_rules('adrep', 'Adrep', 'trim');
			
			$this->form_validation->set_rules('no_pages', 'No Pages', 'trim');
			
			$this->form_validation->set_rules('adtype', 'Adtype', 'trim');
			
			$this->form_validation->set_rules('artinst', 'Artinst', 'trim');
				
			//$this->form_validation->set_rules('cat_news', 'Newspaper', 'trim|required');
			
			$this->form_validation->set_rules('priority', 'Priority', 'trim');
			
			$this->form_validation->set_rules('help_desk', 'Help Desk', 'trim');
			
			$this->form_validation->set_rules('instruction', 'Instruction', 'trim');
			
			$this->form_validation->set_rules('publication', 'Publication', 'trim');
			
			$this->form_validation->set_rules('color_preferences', 'Color Preference', 'trim');

			$this->form_validation->set_rules('font_preferences', 'Font Preference', 'trim');
				
			$this->form_validation->set_rules('copy_content', 'Copy Content', 'trim');
			
			$this->form_validation->set_rules('job_instruction', 'Job Instruction', 'trim');

			$this->form_validation->set_rules('art_work', 'Art Work', 'trim');
			
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim');
			
			$this->form_validation->set_rules('notes', 'Notes', 'trim');
		
		$adtype = $this->db->get('cat_new_adtype')->result_array();
		$artinst = $this->db->get('cat_artinstruction')->result_array();
		
		$data['adtype'] = $adtype;
		$data['artinst'] = $artinst;
		
		if($this->form_validation->run() == FALSE){
			$data['order'] = $this->db->get_where('orders',array('id' => $order_id))->result_array();
			$this->load->view('new_csr/cshift_category', $data);
		}else{
			if(isset($_POST['order_no']) && isset($_POST['confirm'])){
				$cat_check = $this->db->get_where('cat_result',array('order_no' => $_POST["order_no"]))->result_array();
				if($cat_check){
					$data['error'] = "Duplicate entry!!";
				}else{
					$art = $_POST['artinst'];
					$adtype = $_POST['adtype'];
					if($orders[0]['order_type_id']){
					   $width = '0'; $height = '0'; $size = '0'; 
					}else{
    					if(isset($_POST['width']) && isset($_POST['height'])) {
    					    $width = $_POST['width'];
    					    $height = $_POST['height'];
    					    $size = $width * $height;
    			            if($size == '0'){
    					    	$this->session->set_flashdata('message','<button type="button" class="form-control btn btn-danger">Valid Width and Height value required!!</button>');
    					        redirect('new_csr/home/orderview/'.$hd.'/'.$order_id);
    			            }
    					}else{
    					    $this->session->set_flashdata('message','<button type="button" class="btn red-sunglo btn-xs margin-right-10"> Width and Height value required!!</button>');
    					    redirect('new_csr/home/orderview/'.$hd.'/'.$order_id);
    					}
					}	
					$category = $this->cat_calc($adtype);	//cat_calc()
					$data['category'] = $category;
					
					//assign order to team 24 may 2022
					$rush = 0; 
					if(isset($_POST['rush']) && !empty($_POST['rush'])){ $rush = $_POST['rush']; }
				    
					$publication = $this->db->get_where('publications',array('id' => $_POST['publication']))->result_array();
					if($publication){
						$news_id = $publication[0]['news_id'];
						$initial = $publication[0]['initial'];
						$help_desk = $publication[0]['help_desk'];
						$publication_id = $_POST['publication'];
						//$initial = $publication[0]['initial'];
						$slug_type = $publication[0]['slug_type'];
						$team = $publication[0]['design_team_id']; 
					}else{ 
					    $help_desk = '0'; $publication_id = '0'; $slug_type = '0'; $team = '0'; $news_id = '0'; $initial = '0'; 
					}
					
					$dataa = array(
								'order_no' => $_POST['order_no'],
								'job_name' => $_POST['job_name'],
								'adrep' => $_POST['adrep'],
								'advertiser' => $_POST['adv_name'],
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								'num_pages' => $_POST['no_pages'],
								'artinstruction' => $_POST['artinst'],
								'adtypewt' => $_POST['adtype'],
								'help_desk' => $help_desk,
								'publication_id' => $publication_id,
								'news_id' => $news_id,
								'news_initial' => $initial,
								'team' => $team,
								'slug_type' => $slug_type,
								'category' => $category,
								'instruction' => $_POST['instruction'],
								'csr' => $this->session->userdata('sId'),
								'date' => Date("Ymd"),
								'time' => date("His")
								);
					$this->db->insert('cat_result',$dataa);	
					$cat_id = $this->db->insert_id();
					
					if(isset($_POST['priority']))
					{
						
						if($_POST['adtype']=='1' || $_POST['adtype']=='2' || $_POST['adtype']=='3')
						{
							$status = 'pickup';
						}else{
							$status = 'new';
						}
						$data = array(
									'order_no' => $_POST['order_no'],
									'csr' => $this->session->userdata('sId'),
									'help_desk'  => $_POST['help_desk'],
									'date' => Date("Ymd"),
									'time' => date("His"),
									'category' => $status,
									);
						$this->db->insert('rev_sold_jobs',$data);
						$rev_id = $this->db->insert_id(); 
						if($rev_id){
							//Live_tracker Revision updation
							
								$tracker_data = array(
								'pub_id'=> $publication[0]['id'],
								'order_id' => $orders[0]['id'],
								'revision_id'=> $rev_id,
								'status' => '1'
								);
								$this->db->insert('live_revisions', $tracker_data);
							
							$help_desk  = $_POST['help_desk'];
						}
					}else{
						
						$data2 = array(
									'order_no' => $_POST['order_no'],
									'csr' => $this->session->userdata('sId'),
									'help_desk' => $help_desk,
									'news_id'  => $news_id,
									'publication_id' => $publication_id,
									'date' => Date("Ymd"),
									'time' => date("His"),
									'category' => $category,
									);
						$this->db->insert('cshift',$data2);
						//$help_desk  = $help_desk;
						$status = 'v1';
					}
					if($cat_id)
					{
						//order status
						$post = array('rush' => $rush, 'status' => '2');
						$this->db->where('id', $_POST['order_no']);
						$this->db->update('orders', $post); 

						//Live_tracker Updation
						$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$_POST['order_no']."' ")->row_array();
						if(isset($update_order['id'])){
							$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
							$this->db->where('id', $update_order['id']);
							$this->db->update('live_orders', $tracker_data);
						}
						
						
					} 
						
					if($orders[0]['order_type_id']=='1'){
						$this->session->set_flashdata('sucess_message',$order_id.' - '.$category);
						redirect('new_csr/home/web_cshift/category');
					}elseif($orders[0]['order_type_id']=='6'){
					    $this->session->set_flashdata('sucess_message',$order_id.' - '.$category);
						redirect('new_csr/home/live_new_ads/category');
					}else{ 
						$this->session->set_flashdata('sucess_message',$order_id.' - '.$category);
						redirect('new_csr/home/cshift/'.$help_desk.'/category');
						//redirect('new_csr/home/live_new_ads/category');
					}
				}
			}
			
			$this->load->view('new_csr/cshift_category', $data);
		}
	  }
			else{ redirect("new_csr/home"); } 
	}
*/	
	public function cshift_category($order_id = 0)
	{
	    $sId = $this->session->userdata('sId');
		$orders = $this->db->query("SELECT orders.*, adreps.first_name FROM `orders` 
		                            JOIN `adreps` ON orders.adrep_id = adreps.id
		                            WHERE orders.id = '$order_id' ")->row_array();
		if(isset($orders['id'])){
    		if(isset($_POST['confirm'])){
				$cat_check = $this->db->get_where('cat_result',array('order_no' => $order_id))->row_array();
				if(isset($_POST['artinst'])) $art = $_POST['artinst']; else $art = '0';
				$adtype = $_POST['adtype'];
				$category = $this->cat_calc($adtype);	//cat_calc()
				$rush = $orders['rush']; 
				if(isset($_POST['rush']) && !empty($_POST['rush'])){ $rush = $_POST['rush']; }
					
				if(isset($cat_check['id'])){
				    //update entries - recategorise
				    $cat_id = $cat_check['id'];
				    $dataa = array(
								'artinstruction' => $art,
								'adtypewt' => $adtype,
								'category' => $category,
								'csr' => $this->session->userdata('sId'),
								'date' => Date("Ymd"),
								'time' => date("His"),
								);
					$this->db->where('id', $cat_id);
					$this->db->update('cat_result', $dataa); 
					
				}else{
					$publication = $this->db->get_where('publications',array('id' => $orders['publication_id']))->row_array();
					if($publication){
						$news_id = $publication['news_id'];
						$initial = $publication['initial'];
						$help_desk = $publication['help_desk'];
						$publication_id = $publication['id'];
						$slug_type = $publication['slug_type'];
						$team = $publication['design_team_id']; 
					}else{ 
					    $help_desk = '0'; $publication_id = '0'; $slug_type = '0'; $team = '0'; $news_id = '0'; $initial = '0'; 
					}
					
					$dataa = array(
								'order_no' => $order_id,
								'job_name' => $orders['job_no'],
								'adrep' => $orders['first_name'],
								'advertiser' => $orders['advertiser_name'],
								'num_pages' => $_POST['no_pages'],
								'artinstruction' => $art,
								'adtypewt' => $_POST['adtype'],
								'help_desk' => $help_desk,
								'publication_id' => $publication_id,
								'news_id' => $news_id,
								'news_initial' => $initial,
								'team' => $team,
								'slug_type' => $slug_type,
								'category' => $category,
								//'instruction' => $_POST['instruction'],
								'csr' => $this->session->userdata('sId'),
								'date' => Date("Ymd"),
								'time' => date("His"),
								'order_type_id' => $orders['order_type_id']
								);
					$this->db->insert('cat_result',$dataa);	
					$cat_id = $this->db->insert_id();
					
					if(isset($_POST['priority'])){
						
						if($_POST['adtype']=='1' || $_POST['adtype']=='2' || $_POST['adtype']=='3'){
							$status = 'pickup';
						}else{
							$status = 'new';
						}
						$data = array(
									'order_no' => $order_id,
									'csr' => $this->session->userdata('sId'),
									'help_desk'  => $_POST['help_desk'],
									'date' => Date("Ymd"),
									'time' => date("His"),
									'category' => $status,
									);
						$this->db->insert('rev_sold_jobs',$data);
						$rev_id = $this->db->insert_id(); 
						if($rev_id){
							//Live_tracker Revision updation
							$tracker_data = array(
								'pub_id'=> $publication['id'],
								'order_id' => $orders['id'],
								'revision_id'=> $rev_id,
								'status' => '1'
								);
							$this->db->insert('live_revisions', $tracker_data);
							
							$help_desk  = $_POST['help_desk'];
						}
					}
				}
					if($cat_id){
						//order status
						$post = array('rush' => $rush, 'status' => '2');
						$this->db->where('id', $order_id);
						$this->db->update('orders', $post); 

						//Live_tracker Updation
						$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
						if(isset($update_order['id'])){
							$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
							$this->db->where('id', $update_order['id']);
							$this->db->update('live_orders', $tracker_data);
						}
						
						//assign order to team 24 may 2022
						/*
						if($rush == 0){ //if rush ad skip auto assigning to teams
    				        $club_id = $update_order['club_id'];
    				        $assign_order = $this->db->query("SELECT `designers_id` FROM `assign_order` 
    				                                            WHERE `club_id` = '$club_id' AND `category` = '$category' 
    				                                            ORDER BY `assigned_on` DESC LIMIT 1;")->row_array();
    				        $query = "SELECT `id` FROM `designers` 
    				                    WHERE (`club_id` LIKE '$club_id,%' OR `club_id` LIKE '%,$club_id' OR `club_id` LIKE '%,$club_id,%') 
    				                    AND `category_level` LIKE '%".$category."%' AND `is_active` = 1 AND `isEnabled_adwit_teams` = 1";
    				        if(isset($assign_order['designers_id'])){
    				            $query .= " AND `id`>".$assign_order['designers_id'];
    				        }
    				        $assign_designer = $this->db->query($query." ORDER BY `id` LIMIT 1 ;")->row_array();
    				        
    				        if(isset($assign_designer['id'])){
    				            //assign_order 
    				            $assign_order_array = array(
    				                                        'category' => $category,
    				                                        'club_id' => $club_id,
    				                                        'designers_id' => $assign_designer['id']
    				                                        );
    				            $this->db->insert('assign_order', $assign_order_array);
    				        }
    				    }
    				    */
					    //assign order to team 24 may 2022
						$this->session->set_flashdata('sucess_message',$order_id.' - '.$category);
					} 
						
					if($orders['order_type_id']=='1'){
						redirect('new_csr/home/live_new_ads/category');//redirect('new_csr/home/web_cshift/category');
					}elseif($orders['order_type_id']=='6'){
					    redirect('new_csr/home/live_new_ads/category');
					}else{ 
						redirect('new_csr/home/live_new_ads/category');//redirect('new_csr/home/cshift/'.$help_desk.'/category');
					}
				//	redirect('new_csr/home/live_new_ads/category');
			
			}
		
		}
			
	}
	
	public function attach_file($order_id='')
	{
		$order = $this->db->get_where('orders', array('id' => $order_id))->row_array();
		if(isset($order['id']))
		{
			if(!file_exists($order['file_path'])){
				$this->orders_folder($order_id);
			}
			if (!empty($_FILES['ufile']['tmp_name'][0]) || !empty($_FILES['ufile']['tmp_name'][1]))
			{
				$data = array(); //file data sent to file_upload function
				for($i=0;$i<2;$i++) 
				{
					if (!empty($_FILES['ufile']['tmp_name'][$i]))
					{
					  $data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
					  $data['fname'.$i] = $_FILES['ufile']['name'][$i];
					 }
			}
			$data['id'] = $order_id;
			$this->file_upload($data); //file uploads
		   }
		 } //redirect('new_csr/home/cshift_category/'.$order_id);
		 if(isset($_POST['redirect'])) redirect($_POST['redirect']);
	}
	
	public function rev_attach_file($rev_id='')
	{
		$rev_order = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
		if(isset($rev_order[0]["id"]))
		{
			$filetype = $_POST['file_type'];
			if($filetype)
			{
				if(!empty($_FILES))
				{
					
					if($rev_order[0]['file_path'] != 'none' && file_exists($rev_order[0]['file_path'])){
					$dir = $rev_order[0]['file_path'];
					}else{
						$dir = "revision_downloads/".$rev_order[0]["order_no"];
						if (@mkdir($dir,0777)){ }
						$fpost = array('file_path' => $dir);
						$this->db->where('id', $rev_order[0]['id']);
						$this->db->update('rev_sold_jobs', $fpost);
					}
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					if(!move_uploaded_file($tempFile, $dir.'/'.$fileName)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						if(isset($_POST['redirect'])) redirect($_POST['redirect']); }
				}
			} if(isset($_POST['redirect'])) redirect($_POST['redirect']);
		} 
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
	
	/*public function rev_jobs_mail($dataa)
	{
	  $config = array();
	  $config['useragent'] = "CodeIgniter";
	  $config['mailtype']  = 'html';
	  $config['charset']   = 'utf-8';
	  $config['newline']   = "\r\n";
	  $config['wordwrap']  = TRUE;
	  $this->load->library('email');
	  $this->email->initialize($config);

	  $this->email->from($dataa['from'], $dataa['from_display']); // change it to yours
	  $this->email->to($dataa['replyTo'],$dataa['replyTo_display']);// change it to yours
	  $this->email->subject($dataa['subject']);
	  $this->email->message($dataa['body']);
		//$this->email->bcc($dataa['from'], $dataa['from_display']);
		//$this->email->cc($dataa['ad_recipient'], $dataa['ad_recipient_display']);

		if($this->email->send()){
			return true;
		}else{
			return false;
		}
		
	}*/
	
	public function rev_jobs_mail($dataa)
	{
	    include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
	    $email = new \SendGrid\Mail\Mail();

	    $email->setFrom($dataa['from'], $dataa['from_display']); 
	    $email->addTo($dataa['replyTo'],$dataa['replyTo_display']); 
	    $email->setSubject($dataa['subject']); 
	    $email->addContent("text/html", $dataa['body']); 
	
        $sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		
	    return true;
	}
	
	public function cshift_question_v2($hd = '', $order_id='')
	{
		$orders = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		if($hd!='' && $order_id!='' && isset($orders[0]['id']))
		{
			if($orders[0]['question']=='1'){
				$this->session->set_flashdata('question_message','Question Already Sent For This Order..!!');
				redirect('new_csr/home/orderview/'.$hd.'/'.$order_id);
			}
			//order status question
			$post_status = array('question' => '1', 'activity_time' => date('Y-m-d h:i:s'));
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status); 
				
			//orders_Q_A
			$timestamp = date('Y-m-d H:i:s');
			$Qpost = array( 'order_id' => $order_id,
							'question' => $_POST['question'], 
							'csr' => $this->session->userdata('sId'),
							'Qtimestamp' => $timestamp
							);
			$this->db->insert('orders_Q_A', $Qpost);
			
			//Live_tracker Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('question' => '1');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
			
			if($orders[0]['publication_id'] == '656'){ //Ogden News XML
			    //create xml
			    $this->load->dbutil();
			     $data = $this->db->query('SELECT orders.id AS orderId, orders_Q_A.question FROM `orders` 
                                                LEFT JOIN `orders_Q_A` ON orders_Q_A.order_id = orders.id
                                                WHERE orders.id = "'.$order_id.'" AND orders_Q_A.rev_id = "0" ORDER BY orders_Q_A.id DESC LIMIT 1');
                    $config = array (
                            'root'    => 'Ads',
                            'element' => 'Ad',
                            'newline' => "\n",
                            'tab'     => "\t"
                     );
                     $xml = $this->dbutil->xml_from_result($data, $config);
                     $this->load->helper('file');
                     $xmlFileName = $orders[0]['job_no'].'.xml';
                     write_file('Ogden_ftp_xml/question/'.$xmlFileName, '<?xml version="1.0" ?>'.PHP_EOL);
                     write_file('Ogden_ftp_xml/question/'.$xmlFileName, $xml, 'a'); 
			    //ftp connect and transfer
			    $this->Ogden_ftp_connect_post('question', $xmlFileName);
			}else{		
			//send mail
				 //$orders = $this->db->get_where('orders',array('id' => $order_id))->result_array();
				$client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
				if($client)
				{
					//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
					//$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select design_teams.id, design_teams.name, design_teams.email_id from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					if($orders[0]['order_type_id'] == '6'){
					    $dataa['from'] = 'pagination@adwitads.com';
					    $dataa['replyTo'] = 'pagination@adwitads.com';
					}else{
					    $dataa['from'] = $design_team[0]['email_id'];
					    $dataa['replyTo'] = $design_team[0]['email_id'];
					}
					$dataa['from_display'] = 'Design Team';

					

					$dataa['replyTo_display'] = 'Design Team';
				
					$dataa['subject'] = 'Question for AdwitAds Order# '.$order_id;
					//$dataa['subject'] = 'Question for Unique Ad No :'.$_POST['job_name'] ;
					
					$_POST['question'] = str_replace(PHP_EOL,'<br/>', $_POST['question']);
					$dataa['question'] = $_POST['question'];
					//Client
					$dataa['recipient'] = $client[0]['email_id'];
					//$dataa['recipient'] = 'sudarshan@adwitads.com';
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$dataa['client'] = $client[0];
					$dataa['order'] = $orders[0];
					$dataa['design_team'] = $design_team[0]['name'];
					$this->question_mail($dataa); 
				} 
			}
			$this->session->set_flashdata('question_message','Question Sent Successfully');
			redirect('new_csr/home/orderview/'.$hd.'/'.$order_id);
		}else{ 
			echo "<script>alert('Direct Access Denied..')</script>";
			//$this->session->set_flashdata("message","Internal Error: Order not placed!");
			$this->index();
		}
	}
	
	public function cshift_answer_v2($order_id='')
	{
		$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		if($order_id!='' && isset($_POST['qid']) && isset($order[0]['id']))
		{
			if (!empty($_FILES['ufile']['tmp_name'][0])) //file upload to downloads
			{ 
				$path1 = $order[0]['file_path'].'/'.$_FILES['ufile']['name'][0];
				if(!copy($_FILES['ufile']['tmp_name'][0], $path1))
				{
					echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
					exit();
				}        
			}
		
			//order status question
			$post_status = array('question' => '2', 'activity_time' => date('Y-m-d h:i:s'));//Q answered
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status); 
			
			
			$timestamp = date('Y-m-d H:i:s');
			$Apost = array( 'answer' => $_POST['answer'], 
							'Acsr' => $this->session->userdata('sId'),
							'Atimestamp' => $timestamp
							);
			$this->db->where('id', $_POST['qid']);
			$this->db->update('orders_Q_A', $Apost);
			//Live_tracker Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('question' => '2');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
					
			if(isset($_POST['redirect'])) redirect($_POST['redirect']);
			//redirect('new_csr/home/cshift_category/'.$order_id);
		}
	}
	
	public function frontline_question($hd = '', $rev_id='') 
	{
		$rev_sold_jobs = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
		if($hd!='' && $rev_id!='' && $rev_sold_jobs && $rev_sold_jobs[0]['order_id']!='')
		{
			$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id`='$rev_id' ORDER BY `id` DESC")->result_array();
			if($question && $rev_sold_jobs[0]['question']=='1'){
				$this->session->set_flashdata('message','<p class="btn green btn-xs margin-right-10">Question Already Sent For This Order..!!</p>');
				//redirect('new_csr/home/rev_orderview/'.$hd.'/'.$rev_sold_jobs[0]['order_id']);
				if(isset($_POST['redirect'])) redirect($_POST['redirect']);
			}
				//order status question
				$post_status = array('question' => '1');
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $post_status); 
				
				//order activity time 
				$post_status1 = array('activity_time' => date('Y-m-d h:i:s'));
				$this->db->where('id', $rev_sold_jobs[0]['order_id']);
				$this->db->update('orders', $post_status1); 
				
				//orders_Q_A
				
				$timestamp = date('Y-m-d H:i:s');
				$Qpost = array( 'rev_id' => $rev_id,
								'question' => $_POST['question'], 
								'csr' => $this->session->userdata('sId'),
								'Qtimestamp' => $timestamp
							 );
				$this->db->insert('orders_Q_A', $Qpost);
				$orders = $this->db->get_where('orders',array('id' => $rev_sold_jobs[0]['order_id']))->result_array();
				
				if($orders[0]['publication_id'] == '656'){ //Ogden News XML
    			    //create xml
    			    $this->load->dbutil();
    			     $data = $this->db->query('SELECT rev_sold_jobs.order_id AS orderId, orders_Q_A.question FROM `rev_sold_jobs` 
                                                    LEFT JOIN `orders_Q_A` ON orders_Q_A.rev_id = rev_sold_jobs.id
                                                    WHERE rev_sold_jobs.id = "'.$rev_id.'" ORDER BY orders_Q_A.id DESC LIMIT 1');
                        $config = array (
                                'root'    => 'Ads',
                                'element' => 'Ad',
                                'newline' => "\n",
                                'tab'     => "\t"
                         );
                         $xml = $this->dbutil->xml_from_result($data, $config);
                         $this->load->helper('file');
                         $xmlFileName = $orders[0]['job_no'].'.xml';
                         write_file('Ogden_ftp_xml/question/'.$xmlFileName, '<?xml version="1.0" ?>'.PHP_EOL);
                         write_file('Ogden_ftp_xml/question/'.$xmlFileName, $xml, 'a'); 
    			    //ftp connect and transfer
    			    $this->Ogden_ftp_connect_post('question', $xmlFileName);
    			}else{
    				//send mail
    				 
    				 $client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
    				if($client)
    				{
    					//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
    					//$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
    					$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
    					$design_team = $this->db->query("Select design_teams.id, design_teams.name, design_teams.email_id from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
    					
    					$dataa['order'] = $orders[0];
    					$dataa['design_team'] = $design_team[0]['name'];
    					$dataa['from'] = $design_team[0]['email_id'];
    					
    					$dataa['from_display'] = 'Design Team';
    
    					$dataa['replyTo'] = $design_team[0]['email_id'];
    
    					$dataa['replyTo_display'] = 'Design Team';
    
    					$dataa['subject'] = 'Question for Unique Ad No :'.$rev_sold_jobs[0]['order_id'] ;
    					
    					$_POST['question'] = str_replace(PHP_EOL,'<br/>', $_POST['question']);
    					$dataa['question'] = $_POST['question'];
    					//Client
    					$dataa['recipient'] = $client[0]['email_id'];
    					//$dataa['recipient'] = 'sudarshan@adwitads.com';
    					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
    					$dataa['client'] = $client[0];
    					if($this->question_mail($dataa)=='true'){
    						$this->session->set_flashdata('message','<p class="btn green btn-xs margin-right-10">Question Sent Successfully</p>');
    						//redirect('new_csr/home/rev_orderview/'.$hd.'/'.$rev_sold_jobs[0]['order_id']);
    						if(isset($_POST['redirect'])) redirect($_POST['redirect']);
    					}else{
    						$this->session->set_flashdata('message','<p class="btn green btn-xs margin-right-10">Adrep Mail sending Failed..!!</p>');
    						//redirect('new_csr/home/rev_orderview/'.$hd.'/'.$rev_sold_jobs[0]['order_id']);
    						if(isset($_POST['redirect'])) redirect($_POST['redirect']);
    					}
    				}
    			}
				$this->session->set_flashdata('question_message','Question Sent Successfully');
				//redirect('new_csr/home/rev_orderview/'.$hd.'/'.$rev_sold_jobs[0]['order_id']);
				if(isset($_POST['redirect'])) redirect($_POST['redirect']);
		}else{ 
				echo "<script>alert('No Details Found.')</script>"; $this->index();
		}
	}
	
	public function frontline_answer($rev_id='')
	{
		$rev_order = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
		if($rev_id!='' && isset($_POST['qid']) && isset($rev_order[0]["id"]))
		{
			if (!empty($_FILES['ufile']['tmp_name'][0])) //file upload to revision_downloads
			{ 
				if($rev_order[0]['file_path'] != 'none' && file_exists($rev_order[0]['file_path'])){
					$dir = $rev_order[0]['file_path'];
				}else{
					$dir = "revision_downloads/".$rev_order[0]["order_no"];
					if (@mkdir($dir,0777)){ }
					$fpost = array('file_path' => $dir);
					$this->db->where('id', $rev_order[0]['id']);
					$this->db->update('rev_sold_jobs', $fpost);
				}
				$path1 = $dir.'/'.$_FILES['ufile']['name'][0];
				if(!copy($_FILES['ufile']['tmp_name'][0], $path1)){
					echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
					exit();
				}       
			}
			//order status question
			$post_status = array('question' => '2');//Q answered
			$this->db->where('id', $rev_id);
			$this->db->update('rev_sold_jobs', $post_status); 
			
			//order activity time 
			$post_status1 = array('activity_time' => date('Y-m-d h:i:s'));
			$this->db->where('id', $rev_order[0]['order_id']);
			$this->db->update('orders', $post_status1); 
			
			$timestamp = date('Y-m-d H:i:s');
			$Apost = array( 'answer' => $_POST['answer'], 
							'Acsr' => $this->session->userdata('sId'),
							'Atimestamp' => $timestamp
							);
			$this->db->where('id', $_POST['qid']);
			$this->db->update('orders_Q_A', $Apost);
			if(isset($_POST['redirect'])) redirect($_POST['redirect']);
			//redirect('new_csr/home/cshift_category/'.$order_id);
		}
	}
	
	public function ordercshift_cancel_v2($hd = '', $order_id = '')
	{
		if($hd!='' && $order_id!='' && isset($_POST['remove']) && isset($_POST['Creason']))
		{
			if($_POST['Creason'] == 'others'){
				$reason = $_POST['reason'];
			}else{
				$reason = $_POST['Creason'];	
			}
			
			//order status Qrequest
			$post_status = array('crequest' => '1');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status);
			
			//orders_cancel
			
			$timestamp = date('Y-m-d H:i:s');
			$post_cancel = array('order_id' => $order_id, 'csr' => $this->session->userdata('sId'), 'Creason' => $reason, 'Ctimestamp' => $timestamp);
			$this->db->insert('orders_cancel', $post_cancel);
			
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('crequest' => '1');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//send mail for order cancel request to adrep
			$orders = $this->db->get_where('orders',array('id' => $order_id))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
			//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			//$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
			
			$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
			$design_team = $this->db->query("Select design_teams.id, design_teams.email_id from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
			if($orders[0]['order_type_id'] == '6'){
			    $dataa['from'] = 'pagination@adwitads.com';
			    $dataa['replyTo'] = 'pagination@adwitads.com';
			}else{		
			    $dataa['from'] = $design_team[0]['email_id'];
			    $dataa['replyTo'] = $design_team[0]['email_id'];
			}
			$dataa['from_display'] = 'Design Team';
			
			$dataa['replyTo_display'] = 'Design Team';
			$dataa['subject'] = 'Order Cancel Request:';
			$dataa['orders'] = $orders[0];
			$dataa['reason'] = $reason; 
			//Client
			$dataa['recipient'] = $client[0]['email_id'];
			/* if($this->session->userdata('sId')=='25'){
				$dataa['recipient'] = "webmaster@adwitglobal.com";
			}else{
				$dataa['recipient'] = $client[0]['email_id'];
			} */
			$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
			$dataa['client'] = $client[0];
			$dataa['design_team_id'] = $design_team[0]['id'];
			if($this->order_cancel_mail($dataa)==false){ $this->session->set_flashdata("message","Adrep Mail sending Failed : ".$order_id); }
			redirect('new_csr/home/live_new_ads');
		}
	}
	
 	/*public function order_cancel_mail($dataa) 
	{ 
	    $config = array();
                $config['useragent'] = "CodeIgniter";
                $config['mailpath']  = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']  = "smtp";
                $config['smtp_host'] = "localhost";
                $config['smtp_port'] = "25";
                $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;

        $this->load->library('email');
		$this->email->initialize($config);
 		$this->email->from($dataa['from'], $dataa['from_display']);
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		$this->email->subject($dataa['subject']);  
		$this->email->message($this->load->view('order_cancel_mail',$dataa, TRUE));
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
		
		if(isset($dataa['Cc'])){
		    $this->email->cc(array($dataa['Cc']));
		}
		
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		}
	}*/
	
	public function order_cancel_mail($dataa) 
	{ 
	    include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
		$email = new \SendGrid\Mail\Mail();
		
 		$email->setFrom($dataa['from'], $dataa['from_display']); 
		$email->setReplyTo($dataa['replyTo'],$dataa['replyTo_display']); 
		$email->setSubject($dataa['subject']); 
		//if($this->session->userdata('sId') == 68 || $dataa['orders']['publication_id'] == '3' || $dataa['orders']['group_id'] == '18'){
		    $email->setSubject("Cancellation Request - ".$dataa['orders']['id']." - ".$dataa['orders']['advertiser_name']." - ".$dataa['orders']['job_no']);
		    $email->addContent("text/html", $this->load->view('email_template/CancellationRequest',$dataa, TRUE));
	/*	}else{
		    $email->addContent("text/html", $this->load->view('order_cancel_mail',$dataa, TRUE));
		}*/
		$email->addTo($dataa['recipient'], $dataa['recipient_display']);
		
		if(isset($dataa['Cc'])){
		    $email->addCC($dataa['Cc']);
		}
		
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		
		return true;
	}
	
	public function category_help($hd = '')
	{
		if($hd!=''){echo $hd; exit();}
		$this->load->view('new_csr/category-view');
	}
			
	public function cshift_cp_tool($hd = '', $order_id = '') 
	{
		if($order_id != '')
		{
		    //$data['orders']= $this->db->query("SELECT * FROM `orders` WHERE `id`= '$order_id' ")->result_array();
			$data['orders']= $this->db->get_where('orders', array('id' => $order_id))->result_array();
			$data['order_id'] = $order_id;
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id, 'slug !=' => 'none'))->result_array();
			if(!$cat)
			{
				$this->session->set_flashdata("message","Order: ".$order_id." No data found!!");
				redirect('new_csr/home/cshift_cp_tool');
			}else{
			    $data['slug'] = $cat[0]['slug'];
				if($cat[0]['cancel']!='0')
				{
					$this->session->set_flashdata("message","Order: ".$order_id." Cancelled.. QA not allowed!!");
					redirect('new_csr/home/cshift_cp_tool');
				}
			}
			
		         //$dir="downloads/".$order_id."-".$job_no;
				 $dir1="sourcefile/".$order_id.'/'.$cat[0]['slug'];
				// if($dir) { $data['dir'] = $dir; }
				 if($dir1) { $data['dir1'] = $dir1; }
			if(isset($_POST['sent_designer']) && isset($_POST['msg']))
	         {
				if(!empty($_FILES['file2']['name']))	
	          {
				$dir1="sourcefile/".$order_id.'/'.$cat[0]['slug'];
				$dir2 = $dir1.'/csr_change';
				if (@mkdir($dir2,0777))
				{}
				move_uploaded_file($_FILES['file2']['tmp_name'],$dir2.'/'.$_FILES['file2']['name']);
			  }	
			  $time=date("Y:m:d H:i:s");
				 $data2 = array('order_id'=> $order_id , 'message'=>  $_POST['msg'] ,  'csr_id'=>$cat[0]['csr'] , 'time'=>$time);
				$this->db->insert('ads_designcheck_msg', $data2);
				// Status Update
				$data1 = array('pro_status'=> '7');
				$this->db->where('order_no', $order_id); 
				$this->db->update('cat_result', $data1);
				//Live_tracker Pro-status Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('pro_status' => '7');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
					
				$this->session->set_flashdata("message","Sent successfully!!!");
				redirect('new_csr/home/cshift/'.$hd);
	         }
				  $csr_path="sourcefile/".$order_id.'/'.$cat[0]['slug'].'/csr_change';		
	              $data['csr_path'] = $csr_path;
			if(isset($_POST['end_time']))
			{
				
				$date = date('Y-m-d');
				$data['slug'] = $cat[0]['slug'];
				$st_time = 	date("H:i:s");
				$data['st_time'] = $st_time;
				$dataa = array(
								'csr' => $this->session->userdata('sId'),
								'designer' => $cat[0]['designer'], 
								'order_no' => $order_id,
								'cat_result_id' => $cat[0]['id'],
								'start_time' => $st_time,
								'date' => $date,
								'job_status' => 'Inprogress',
								);

				$this->db->insert('cp_tool', $dataa);
				$cp_tool_id = $this->db->insert_id();
				
				$end_time = date("H:i:s");				
				
				$cp = $this->db->get_where('cp_tool',array('id' => $cp_tool_id,'csr' => $this->session->userdata('sId')))->result_array();
				$dp_wt = $this->db->get_where('print',array('name' => 'TWEAK'))->result_array();
				
				$stime = $cp[0]['start_time'];
				$etime = $end_time;
				
				$nextDay=$stime>$etime?1:0;
				 $dep=EXPLODE(':',$stime);
				 $arr=EXPLODE(':',$etime);
				 $diff=ABS(TIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-TIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
				 $hours=FLOOR($diff/(60*60));
				 $mins=FLOOR(($diff-($hours*60*60))/(60));
				 $secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
				 IF(STRLEN($hours)<2){$hours="0".$hours;}
				 IF(STRLEN($mins)<2){$mins="0".$mins;}
				 IF(STRLEN($secs)<2){$secs="0".$secs;}
				$time_min=$hours*60+$mins;
				
				$time_hr = $time_min / 60 ;
				$cp = $time_hr / $dp_wt[0]['wt'];
				
				$data = array(
							'end_time' => $end_time,
							'time_taken' => $time_min,
							'cp' => $cp,
							'job_status' => "Done",
							);
				$this->db->where('id', $cp_tool_id);
				$this->db->update('cp_tool', $data); 
				
				if($cp_tool_id){
					//order status
					$post_status = array('status' => '4');
					$this->db->where('id', $order_id);
					$this->db->update('orders', $post_status);
					
					//Production status
					$pro_status = array('pro_status' => '4');
					$this->db->where('order_no', $order_id);
					$this->db->update('cat_result', $pro_status);
					
					//Live_tracker Pro-status Updation
					$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('status' => '4', 'pro_status' => '4');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
				}
				if(isset($_POST['error']))
				{
					//$cat = $this->db->get_where('cat_result',array('order_no' => $order_id, 'slug !=' => 'none'))->result_array();
					$cat_wt = $this->db->get_where('print',array('name' => $cat[0]['category']))->result_array();
					foreach($_POST['error'] as $result)
					{
						$eor = $this->db->get_where('dp_error',array('id' => $result))->result_array();
						$cp = $this->db->get_where('cp_tool',array('id' => $cp_tool_id))->result_array();
						$data = array(
										'cp_result_id' => $cp_tool_id,
										'error_name' => $result, 
										'error_type' => $eor[0]['type'],
										'error_degree' => $eor[0]['degree'],
										'cat_result_id' => $cp[0]['cat_result_id'],
										'designer'	=> $cp[0]['designer'],
										'error_catwt' => $cat_wt[0]['wt'],
										);
						$this->db->insert('cp_error_result', $data);
					}
				}
				redirect('new_csr/home/cshift/'.$hd);	//redirect to cshift page
			}
			$this->load->view('new_csr/cshift-cp-view',$data);				
		}
	}
	
	public function cshift($form = '', $display_type='')
	{
		$sId = $this->session->userdata('sId');
		$data['display_type'] = $display_type ;
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59'; $data['today'] = $today;
		//$today = date('Y-m-d 23:59:59'); 
		$no_of_order = $this->input->post('no_of_order');
		
		if($form!='')
		{
		  	//metro ad sent
			if(isset($_POST['ad_sent'])){
				$curr_timestamp = date("Y-m-d H:i:s");
				$ad_sent = array('sent' => '1', 'csr_id' => $sId, 'timestamp' => $curr_timestamp);
				$this->db->where('order_id', $_POST['order_id']);
				$this->db->update('metro_sent_ads', $ad_sent);
				redirect('new_csr/home/cshift/'.$form.'/'.$display_type);
			}
			
			$data['csr'] = $this->db->query("SELECT id, csr_role FROM `csr` WHERE `id` = '$sId'")->row_array();
			$tracker_date = $this->db->query("SELECT * FROM `print_ad_tracker_date` WHERE `hd` = '".$form."'")->row_array();
			$data['help_desk_name'] = $this->db->query("SELECT name FROM `help_desk` WHERE `id` = '$form'")->row_array();
			$data['help_desk'] = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
			
			$num_days = $tracker_date['num_days'];
			if($num_days != '0'){
				$ystday = date('Y-m-d 00:00:00', strtotime("-$num_days day")); $data['ystday'] = $ystday; //in days
			}else{
				$ystday =  ($tracker_date['date'].' 00:00:00'); $data['ystday'] = $ystday; //in date
			}
			
			$data['form'] = $form;
		/*	$query = "SELECT orders.id, orders.order_type_id, orders.status, orders.job_no, orders.created_on, orders.rush, orders.cancel, orders.question, orders.help_desk,
			publications.name AS publicationName, adreps.first_name AS adrepName,  
			cat_result.id AS cat_result_id, cat_result.cancel AS cat_result_cancel, cat_result.pro_status, cat_result.timestamp, cat_result.csr_QA 
			FROM `live_orders`
			            LEFT JOIN `orders` ON orders.id = live_orders.order_id 
            			LEFT JOIN `publications` ON publications.id = orders.publication_id
			            LEFT JOIN `adreps` ON adreps.id = orders.adrep_id
			            LEFT JOIN `cat_result` ON cat_result.order_no = orders.id
			            WHERE orders.order_type_id != '1' AND live_orders.crequest != '1' 
													AND (live_orders.timestamp BETWEEN '$ystday' AND '$today')";
		*/										
			$query = "SELECT orders.id, orders.order_type_id, orders.status, orders.job_no, orders.created_on, orders.rush, orders.cancel, orders.question, orders.help_desk,
			publications.name AS publicationName, adreps.first_name AS adrepName,  
			cat_result.id AS cat_result_id, cat_result.cancel AS cat_result_cancel, cat_result.pro_status, cat_result.timestamp, cat_result.csr_QA 
			FROM `orders`
			            LEFT JOIN `publications` ON publications.id = orders.publication_id
			            LEFT JOIN `adreps` ON adreps.id = orders.adrep_id
			            LEFT JOIN `cat_result` ON cat_result.order_no = orders.id
			            WHERE orders.order_type_id != '1' AND orders.cancel = '0' AND orders.crequest != '1' 
													AND (orders.created_on BETWEEN '$ystday' AND '$today')";
			//echo $query;
			if($display_type == 'new_pending'){
			    //new pending - All
			    $data['All_pending'] = $this->db->query($query." AND orders.help_desk ='".$form."' AND (orders.status BETWEEN '1' AND '4');")->result_array();
			}elseif($display_type == 'QA'){
			    //My QA - My Q
			    $data['QA_order_pending'] = $this->db->query($query." AND (orders.status BETWEEN '1' AND '4') AND cat_result.pro_status != '5' AND cat_result.csr_QA = '$sId';")->result_array();
			}elseif($display_type == 'total_QA'){
			    //Total QA - General Q
			    $data['csr_QA_pending'] = $this->db->query($query." AND orders.help_desk ='".$form."' AND (orders.status != '5') AND cat_result.pro_status = '3' AND cat_result.csr_QA = '0';")->result_array();
			}elseif($display_type == 'category'){
			    //display_type == 'category'
			   // $data['c_orders'] = $this->db->query($query." AND orders.help_desk ='".$form."' AND orders.status = '1' ;")->result_array();
			   $data['c_orders'] = $this->db->query("SELECT orders.id, orders.publication_id, orders.adrep_id, orders.order_type_id, orders.status, orders.job_no, orders.created_on, orders.rush, orders.cancel, orders.question, orders.help_desk
													FROM `orders` 
													WHERE `order_type_id`!='1' AND `help_desk`='".$form."' AND `status`='1' AND `cancel`='0' AND `crequest`!='1' 
													AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();
			}
			
		/*	$data['email_failed_orders'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE `order_type_id`!='1' AND `help_desk`='".$form."' AND `cancel`='0' AND `crequest`!='1' 
													AND `status`= '5' AND (`created_on` BETWEEN '$ystday' AND '$today') ;")->result_array();
		*/	
			//metro ad sent
			if($form == 2) {
			   /* $data['metro_sent'] = $this->db->query("SELECT A.order_id, A.sent, P.order_type_id, P.publication_id, P.adrep_id, P.status, P.created_on, P.id, P.rush, P.job_no, P.question FROM `metro_sent_ads` AS A
											left outer join `orders` AS P on P.id = A.order_id
											WHERE P.status='5' AND P.help_desk='".$form."' AND A.sent='0'
											AND (`timestamp` BETWEEN '$ystday' AND '$today')")->result_array();*/
				#pagination code starts here
				$config = array();
				$config["base_url"] = base_url() . "index.php/new_csr/home/cshift/2/metro_ad_sent/";
				if($this->input->get('metrosend_ads') != null){
					$search = $this->input->get('metrosend_ads');
					$this->session->set_userdata('metroad_val', $search);
					$config["total_rows"] = $this->Pagination->get_metrosend_ad_count($form,$ystday,$today,$search);
				}else if($this->session->userdata("metroad_val") !== "" && $this->input->get('metrosend_ads') == null){
					$search =  $this->session->userdata("metroad_val");
					$config["total_rows"] = $this->Pagination->get_metrosend_ad_count($form,$ystday,$today,$search);
					
				}else{
					$config["total_rows"] = $this->Pagination->get_metrosend_ad_count($form,$ystday,$today,null);
				}
				
				if($no_of_order != "" && $no_of_order != null){
				  	$config["per_page"] = $no_of_order;  
				  	$this->session->set_userdata('no_of_metro_ad', $no_of_order);
				}else if($no_of_order == "" && $this->session->userdata('no_of_metro_ad') != ""){
				    $config["per_page"] = $this->session->userdata('no_of_metro_ad');
				}else{
				    unset($_SESSION['no_of_metro_ad']);
				   	$config["per_page"] = 25; 
				} 

				$config["uri_segment"] = 6;
				$this->get_pagination_config($config);
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
				if($this->input->get('metrosend_ads') != null){
					$search = $this->input->get('metrosend_ads');
					$data["metro_sent"] = $this->Pagination->
					get_metrosend_ad($config["per_page"], $page,$form,$ystday,$today,$search);
				}else if($this->session->userdata("metroad_val") != "" && $this->input->get('metrosend_ads') == null){
					$search =  $this->session->userdata("metroad_val");
					$data["metro_sent"] = $this->Pagination->
					get_metrosend_ad($config["per_page"], $page,$form,$ystday,$today,$search);
					
				}else{
					$data["metro_sent"] = $this->Pagination->
					get_metrosend_ad($config["per_page"], $page,$form,$ystday,$today,null);
				} 
				$data["links"] = $this->pagination->create_links();
				$data["metroad_count"] = $this->Pagination->get_metrosend_ad_count($form,$ystday,$today,null);
				#pagination code ends here
			}								
			
			
		} 
		if($form!=''){
			$this->load->view('new_csr/cshift',$data);
		}else{
			$this->load->view('new_csr/cshift_hd',$data);	//only helpdesk
		}
	}
	
	public function cshift_tab_ad_count($form = '')
	{
	    $sId = $this->session->userdata('sId');
	    if(!empty($form)){
	        $today = date('Y-m-d 23:59:59');
	        $tracker_date = $this->db->query("SELECT * FROM `print_ad_tracker_date` WHERE `hd` = '".$form."'")->row_array();
	        $num_days = $tracker_date['num_days'];
			if($num_days != '0'){
				$ystday = date('Y-m-d 00:00:00', strtotime("-$num_days day"));  //in days
			}else{
				$ystday =  ($tracker_date['date'].' 00:00:00'); //in date
			}
			
            $query = "SELECT COUNT(*) AS adCount FROM `orders`
			            LEFT JOIN `cat_result` ON cat_result.order_no = orders.id
			            WHERE orders.order_type_id != '1' AND orders.cancel = '0' AND orders.crequest != '1' 
													AND (orders.created_on BETWEEN '$ystday' AND '$today')";	        
	        
	        //display_type - 'category'
		    $c_orders = $this->db->query($query." AND orders.help_desk ='".$form."' AND orders.status = '1' ;")->row_array();
		    
			//new pending - All
			$All_pending = $this->db->query($query." AND orders.help_desk ='".$form."' AND (orders.status BETWEEN '1' AND '4');")->row_array();
		
			//My QA - MY Q
			$QA_order_pending = $this->db->query($query." AND (orders.status BETWEEN '1' AND '4') AND cat_result.pro_status != '5' AND cat_result.csr_QA = '$sId';")->row_array();
		
	        //Total QA - General Q
			$csr_QA_pending = $this->db->query($query." AND orders.help_desk ='".$form."' AND (orders.status != '5') AND cat_result.pro_status = '3' AND cat_result.csr_QA = '0';")->row_array();
			
			$data['category_count'] = $c_orders['adCount'];
			$data['QA_count'] = $QA_order_pending['adCount'];
			$data['generalQ_count'] = $csr_QA_pending['adCount'];
			$data['all_count'] = $All_pending['adCount']; 
			
			echo json_encode($data);
		} 
	}
	
	public function web_cshift($display_type = '')
	{
		$data['display_type'] = $display_type ;
		$sId = $this->session->userdata('sId');
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59'; //$today = date('Y-m-d 23:59:59'); 
		$data['today'] = $today;
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		$data['csr'] = $csr;
		//$order_days = $this->db->query("SELECT * FROM `web_ad_tracker_date`")->result_array();
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00'; $data['ystday'] = $ystday; //$ystday = ($order_days[0]['date'].' 00:00:00'); $data['ystday'] = $ystday;
		
		$no_of_order = $this->input->post('no_of_order');
		$csr_id = $csr[0]['id'];
        $order_type = $this->input->post('order_type');
        $order_by = null;
        $sort_by = null;
        
		//'category' query
	/*	$cat_q = "SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, publications.name, adreps.first_name FROM `orders` 
		                            JOIN `publications` ON orders.publication_id = publications.id
		                            JOIN `adreps` ON orders.adrep_id = adreps.id
	                                WHERE orders.order_type_id = '1' AND orders.status = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
	                                AND (orders.created_on BETWEEN '$ystday' AND '$today') ;";
		//'QA' query
		$QA_q = "SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, cat_result.id AS catId, cat_result.timestamp, cat_result.csr_QA, publications.name, adreps.first_name FROM `orders`
		                                            RIGHT JOIN `cat_result` ON orders.id = cat_result.order_no
		                                            JOIN `publications` ON orders.publication_id = publications.id
		                                            JOIN `adreps` ON orders.adrep_id = adreps.id
		                                            WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
		                                            AND (orders.status BETWEEN '1' AND '4' OR orders.status = '8') AND (orders.created_on BETWEEN '$ystday' AND '$today')
		                                            AND cat_result.pro_status = '3' AND (cat_result.csr_QA = '".$csr[0]['id']."' OR cat_result.csr_QA = '0');";
		//'new_pending' query
		$new_pending_q = "SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, orders.status, publications.name, adreps.first_name, order_status.d_name FROM `orders`
		                                                JOIN `publications` ON orders.publication_id = publications.id
		                                                JOIN `adreps` ON orders.adrep_id = adreps.id
		                                                JOIN `order_status` ON orders.status = order_status.id
		                                                WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
		                                                AND (orders.status BETWEEN '1' AND '4') AND (orders.created_on BETWEEN '$ystday' AND '$today') ;";*/
		//Count For Tab
		$data['cat_count'] = $this->Pagination->get_web_categorise_ad_count($ystday,$today,null);
		$data['QA_count'] = $this->Pagination->get_web_qa_ad_count($ystday,$today,$csr_id,null);
		$data['new_pending_count'] = $this->Pagination->get_web_new_ad_count($ystday,$today,null);
		
		if($display_type == 'category'){
		  //  $data['order_list'] = $this->db->query("$cat_q")->result_array();
		  #pagination code starts here
		  if(isset($_POST['c_web_order_by'])){
               $order_by  =  $_POST['c_web_order_by'];
               $this->session->set_userdata("c_web_order_by",$order_by);
            }
            if(isset($_POST['c_web_sort_by'])){
                $sort_by = $_POST['c_web_sort_by'];
                $this->session->set_userdata("c_web_sort_by",$sort_by);
            }
			$config = array();
			$config["base_url"] = base_url() . "index.php/new_csr/home/web_cshift/category/";
			if($this->input->get('web_category_search') != null){
				$search = $this->input->get('web_category_search');
				$this->session->set_userdata('web_search_val', $search);
				$config["total_rows"] = $this->Pagination->get_web_categorise_ad_count($ystday,$today,$search);
			}else if($this->session->userdata("web_search_val") !== "" && $this->input->get('web_category_search') == null){
				$search =  $this->session->userdata("web_search_val");
				$config["total_rows"] = $this->Pagination->get_web_categorise_ad_count($ystday,$today,$search);
				
			}else{
				$config["total_rows"] = $this->Pagination->get_web_categorise_ad_count($ystday,$today,null);
			}
			
			#filter part starts here
			if($no_of_order != "" && $no_of_order != null){
				  	$config["per_page"] = $no_of_order;  
				  	$this->session->set_userdata('no_of_cat_webad_order', $no_of_order);
				}else if($no_of_order == "" && $this->session->userdata('no_of_cat_webad_order') != ""){
				    $config["per_page"] = $this->session->userdata('no_of_cat_webad_order');
				}else{
				    unset($_SESSION['no_of_cat_webad_order']);
				   	$config["per_page"] = 25; 
				} 
			#filter part ends here
			$config["uri_segment"] = 5;
		     $this->get_pagination_config($config);
		     
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			if($this->input->get('web_category_search') != null){
				$search = $this->input->get('web_category_search');
				$data["order_list"] = $this->Pagination->
				get_web_categorise_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
			}else if($this->session->userdata("web_search_val") != "" && $this->input->get('web_category_search') == null){
				$search =  $this->session->userdata("web_search_val");
				$data["order_list"] = $this->Pagination->
				get_web_categorise_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
				
			}else{
				$data["order_list"] = $this->Pagination->
				get_web_categorise_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,null);
			} 
			$data["web_cat_links"] = $this->pagination->create_links();
			$end_index = min($config["per_page"] +$page, $config["total_rows"]);
            $data["web_cat_result"] = "Showing " . $page+1 . " to " . $end_index . " of {$config['total_rows']} entries.";

			#pagination code ends here
		}elseif($display_type == 'QA'){
		  //  $data['order_list'] = $this->db->query("$QA_q")->result_array();
		  $csr_id = $csr[0]['id'];
		    #pagination code starts here
		    if(isset($_POST['c_qa_order_by'])){
               $order_by  =  $_POST['c_qa_order_by'];
               $this->session->set_userdata("c_qa_order_by",$order_by);
            }
            if(isset($_POST['c_qa_sort_by'])){
                $sort_by = $_POST['c_qa_sort_by'];
                $this->session->set_userdata("c_qa_sort_by",$sort_by);
            }
			$config = array();
			$config["base_url"] = base_url() . "index.php/new_csr/home/web_cshift/QA/";
			if($this->input->get('web_qa_search') != null){
				$search = $this->input->get('web_qa_search');
				$this->session->set_userdata('web_qa_search_val', $search);
				$config["total_rows"] = $this->Pagination->get_web_qa_ad_count($ystday,$today,$csr_id,$search);
			}else if($this->session->userdata("web_qa_search_val") !== "" && $this->input->get('web_qa_search') == null){
				$search =  $this->session->userdata("web_qa_search_val");
				$config["total_rows"] = $this->Pagination->get_web_qa_ad_count($ystday,$today,$csr_id,$search);
				
			}else{
				$config["total_rows"] = $this->Pagination->get_web_qa_ad_count($ystday,$today,$csr_id,null);
			}
			
			#filter part starts here
			if($no_of_order != "" && $no_of_order != null){
				  	$config["per_page"] = $no_of_order;  
				  	$this->session->set_userdata('no_of_web_qa_order', $no_of_order);
				}else if($no_of_order == "" && $this->session->userdata('no_of_web_qa_order') != ""){
				    $config["per_page"] = $this->session->userdata('no_of_web_qa_order');
				}else{
				    unset($_SESSION['no_of_web_qa_order']);
				   	$config["per_page"] = 25; 
				} 
			#filter part ends here
			$config["uri_segment"] = 5;
		    $this->get_pagination_config($config);

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			if($this->input->get('web_qa_search') != null){
				$search = $this->input->get('web_qa_search');
				$data["order_list"] = $this->Pagination->
				get_web_qa_ad($config["per_page"], $page,$ystday,$today,$csr_id,$sort_by,$order_by,$search);
			}else if($this->session->userdata("web_qa_search_val") != "" && $this->input->get('web_qa_search') == null){
				$search =  $this->session->userdata("web_qa_search_val");
				$data["order_list"] = $this->Pagination->
				get_web_qa_ad($config["per_page"], $page,$ystday,$today,$csr_id,$sort_by,$order_by,$search);
				
			}else{
				$data["order_list"] = $this->Pagination->
				get_web_qa_ad($config["per_page"], $page,$ystday,$today,$csr_id,$sort_by,$order_by,null);
			} 
			$data["web_qa_links"] = $this->pagination->create_links();
			$end_index = min($config["per_page"] +$page, $config["total_rows"]);
            $data["web_qa_result"] = "Showing " . $page+1 . " to " . $end_index . " of {$config['total_rows']} entries.";

			#pagination code ends here
		}else{
		  //  $data['order_list'] = $this->db->query("$new_pending_q")->result_array();
		  #pagination code starts here
		  if(isset($_POST['c_new_order_by'])){
               $order_by  =  $_POST['c_new_order_by'];
               $this->session->set_userdata("c_new_order_by",$order_by);
            }
            if(isset($_POST['c_new_sort_by'])){
                $sort_by = $_POST['c_new_sort_by'];
                $this->session->set_userdata("c_new_sort_by",$sort_by);
            }
			$config = array();
			$config["base_url"] = base_url() . "index.php/new_csr/home/web_cshift/new_pending/";
			if($this->input->get('web_newpending_search') != null){
				$search = $this->input->get('web_newpending_search');
				$this->session->set_userdata('web_newpending_search_val', $search);
				$config["total_rows"] = $this->Pagination->get_web_new_ad_count($ystday,$today,$search);
			}else if($this->session->userdata("web_newpending_search_val") !== "" && $this->input->get('web_newpending_search') == null){
				$search =  $this->session->userdata("web_newpending_search_val");
				$config["total_rows"] = $this->Pagination->get_web_new_ad_count($ystday,$today,$search);
				
			}else{
				$config["total_rows"] = $this->Pagination->get_web_new_ad_count($ystday,$today,null);
			}
			
		    #filter part starts here
			if($no_of_order != "" && $no_of_order != null){
				  	$config["per_page"] = $no_of_order;  
				  	$this->session->set_userdata('no_of_web_newpending_order', $no_of_order);
				}else if($no_of_order == "" && $this->session->userdata('no_of_web_newpending_order') != ""){
				    $config["per_page"] = $this->session->userdata('no_of_web_newpending_order');
				}else{
				    unset($_SESSION['no_of_web_newpending_order']);
				   	$config["per_page"] = 25; 
				} 
			#filter part ends here
			$config["uri_segment"] = 5;
		     $this->get_pagination_config($config);
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			if($this->input->get('web_newpending_search') != null){
				$search = $this->input->get('web_newpending_search');
				$data["order_list"] = $this->Pagination->
				get_web_new_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
			}else if($this->session->userdata("web_newpending_search_val") != "" && $this->input->get('web_newpending_search') == null){
				$search =  $this->session->userdata("web_newpending_search_val");
				$data["order_list"] = $this->Pagination->
				get_web_new_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
				
			}else{
				$data["order_list"] = $this->Pagination->
				get_web_new_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,null);
			} 
			$data["web_new_links"] = $this->pagination->create_links();
			$end_index = min($config["per_page"] +$page, $config["total_rows"]);
            $data["web_new_result"] = "Showing " . $page+1 . " to " . $end_index . " of {$config['total_rows']} entries.";

			
			#pagination code ends here
		}
		
		$this->load->view('new_csr/web_cshift',$data);
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
				$this->load->view('new_csr/attachments',$data);
			}else{
				$this->session->set_flashdata('message','No Attachments For Order : '.$id);
				redirect('new_csr/home/cshift/'.$form);
			}
			if(isset($_POST['rush'])){
				$post = array('rush'=>$_POST['rush']);
				$this->db->where('id', $id);
				$this->db->update('orders', $post);
				redirect('new_csr/home/cshift/'.$form);
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
	
	/*public function cshift_order_search() 
	{
		if(isset($_POST['search']) && !empty($_POST['search_id'])){
			$search_id = $_POST['search_id'];	
			$orders = $this->db->get_where('orders', array('id' => $search_id))->result_array();
			if(isset($orders[0]['id']) && $orders[0]['id'] == $search_id){
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$search_id' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ 
					$data['rev_orders'] = $rev_orders; 
					}
					$data['orders'] = $orders;
				$this->load->view('new_csr/cshift_order_search',$data);
			}else{
				$this->session->set_flashdata("message","Order not Found!!");
				redirect('new_csr/home/cshift');
			}
		}
	}
	
	public function cshift_advance_search()
	{
		if(isset($_POST['advance_search']) && !empty($_POST['advance_search_id'])){
			$search_id = $_POST['advance_search_id'];
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE (`id` LIKE '%".$search_id."%' OR `advertiser_name` LIKE '%".$search_id."%' OR `job_no` LIKE '%".$search_id."%')")->result_array();
			if(isset($orders[0]['id'])){
				$id = $orders[0]['id'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '$id' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ $data['rev_orders'] = $rev_orders; }
				$data['orders'] = $orders;
				$this->load->view('new_csr/cshift_order_search',$data);	
			}else{
				$data['msg'] = "hello";
				$this->load->view('new_csr/cshift_order_search',$data);
			}
		}
	}*/
	
	public function cshift_order_search() 
	{
		if(isset($_POST['search']) && !empty($_POST['search_id'])){
			$search_id = $_POST['search_id'];	
			$orders = $this->db->get_where('orders', array('id' => $search_id))->result_array();
			if(isset($orders[0]['id']) && $orders[0]['id'] == $search_id){
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$search_id' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ 
					redirect('new_csr/home/orderview/'.$orders[0]['help_desk'].'/'.$orders[0]['id']);
				}else{
					redirect('new_csr/home/orderview/'.$orders[0]['help_desk'].'/'.$orders[0]['id']);
				}
			}else{
			   	$this->session->set_userdata("order_not_found","Order not Found!!");
				$current_url = $this->input->post('current_url');
				$segments = explode('/', $current_url);
                $key = array_search('home', $segments);
            
                if ($key !== false && isset($segments[$key + 1])) {
                    // Check if "home" is found in the segments, and if there's a value after it
                    $valueAfterHome = implode('/', array_slice($segments, $key + 1));
                    redirect('new_csr/home/'.$valueAfterHome);
                } else {
                    // Handle the case when "home" is not found or there's no value after it
                   redirect('new_csr/home/live_new_ads/category');
                }
			}
		}
	}
	
	public function cshift_advance_search()
	{
		if(isset($_POST['advance_search']) && !empty($_POST['advance_search_id'])){
			$search_id = $_POST['advance_search_id'];
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE (`id` LIKE '%".$search_id."%' OR `advertiser_name` LIKE '%".$search_id."%' OR `job_no` LIKE '%".$search_id."%')")->result_array();
			if(isset($orders[0]['id'])){
				$id = $orders[0]['id'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '$id' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ $data['rev_orders'] = $rev_orders; }
				$data['orders'] = $orders;
				$this->load->view('new_csr/cshift_order_search',$data);	
			}else{
				$data['msg'] = "hello";
				$this->load->view('new_csr/cshift_order_search',$data);
			}
		}
		
		if(isset($_GET['advance_search']) && !empty($_GET['advance_search_id'])){
			$search_id = $_GET['advance_search_id'];
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE (`id` LIKE '%".$search_id."%' OR `advertiser_name` LIKE '%".$search_id."%' OR `job_no` LIKE '%".$search_id."%')")->result_array();
			if(isset($orders[0]['id'])){
				$id = $orders[0]['id'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '$id' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ $data['rev_orders'] = $rev_orders; }
				$data['orders'] = $orders;
				$this->load->view('new_csr/cshift_order_search',$data);	
			}else{
				$data['msg'] = "hello";
				$this->load->view('new_csr/cshift_order_search',$data);
			}
		}
	}

	public function ordercshift_cancel($hd = '', $cat_id = '')
	{
		if($cat_id!='')
		{
			if(isset($_POST['remove']))
			{
				$post = array(  'reason' => $_POST['reason'],
								'cancel' => '1',
								);
				$this->db->where('id', $cat_id);
				$this->db->update('cat_result', $post);
				
				//order status Qrequest
				$post_status = array('crequest' => '1');
				$this->db->where('id', $_POST['order_no']);
				$this->db->update('orders', $post_status);
				
				//Live_tracker Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$_POST['order_no']."' ")->row_array();
				if(isset($update_order['id'])){
					$tracker_data = array('crequest' => '1');
					$this->db->where('id', $update_order['id']);
					$this->db->update('live_orders', $tracker_data);
				}
				
				redirect('new_csr/home/cshift/'.$hd);
				//redirect('new_csr/home/job_status/'.$hd);
			}else{
				$cat_result = $this->db->get_where('cat_result',array('id' => $cat_id))->result_array();
				$data['cat_result'] = $cat_result[0];
			}
		}
		$this->load->view('new_csr/ordercshift_cancel',$data);
	}
	
	public function test_mail($dataa) 
	{ 
		include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
		
	    $dataa['from'] = trim($dataa['from']);
	    $dataa['replyTo'] = trim($dataa['replyTo']);
	    $dataa['recipient'] = trim($dataa['recipient']);
	    
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($dataa['from'], $dataa['from_display']);
		$email->setReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
		$email->setSubject($dataa['subject']);

		$email->addTo($dataa['recipient'], $dataa['recipient_display']);

        if(isset($dataa['client_Cc']) && !empty($dataa['client_Cc'])){
			$email->addCC($dataa['client_Cc']);  
		}
		
		if(isset($dataa['template'])){
		    $email->setSubject("Proof Ready - ".$dataa['orders']['id']." - ".$dataa['orders']['advertiser_name']." - ".$dataa['orders']['job_no']);
		    $email->addContent("text/html", $this->load->view('email_template/ProofReady',$dataa, TRUE)); 
		    
    		if($dataa['template']!='order_rating_mailer'){
    			if(isset($dataa['temp'])){ 
    			    $file_encoded = base64_encode(file_get_contents($dataa['temp']));
                    $email->addAttachment(
                                        $file_encoded,
                                        "application/pdf",
                                        basename($dataa['fname']),
                                        "attachment"
                                    );
    			}  
    		}
		}
		
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);   
	   
	}
	
	public function new_resend($order_id='0')
	{
		$order = $this->db->get_where('orders',array('id' => $order_id))->row_array();
		//$rev = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->row_array();
		if(isset($order['id'])){
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $order_id))->row_array();
			$client = $this->db->get_where('adreps',array('id' => $order['adrep_id']))->result_array();
			if($client){	
				$dataa['attachment'] = $order['pdf']; 
						
				//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				//$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				
				$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select design_teams.id, design_teams.newad_template, design_teams.email_id from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
				$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
				$note = $this->db->get_where('note_sent',array('order_id'=>$order_id))->row_array();
				
				$dataa['template'] = $design_team[0]['newad_template'];
				$dataa['alias'] = $csr_alias[0]['alias'];
				$dataa['from'] = $design_team[0]['email_id'];
				if(($design_team[0]['newad_template'] == 'order_rating_mailer') && isset($note['id'])){
					$dataa['subject'] = 'New Ad (Note) :'.$cat_result['slug'] ;
				}else{
					$dataa['subject'] = 'New Ad: '.$cat_result["slug"] ; 
				}
				$dataa['from_display'] = 'Design Team';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';
						
				$dataa['ad_type'] = 'new' ;
				if(isset($note['id'])){ $dataa['note'] = $note['note']; } 
					//Client
				if($this->session->userdata('sId')=='25'){
					$dataa['recipient'] = 'webmaster@adwitglobal.com';
				}else{
					$dataa['recipient'] = $client[0]['email_id'];
				}
						
				$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				$dataa['client'] = $client[0];
				$dataa['design_team_id'] = $design_team[0]['id'];
				$dataa['order_id'] = $order_id ;
				$this->load->library('Encryption');
				$dataa['url']= base_url().index_page().'order_rating/home/new_order_rating/'.$this->encryption->encrypt($order_id);		
						
				if($this->demo_mail($dataa) == False){
					$resend_link = '<a href='.base_url().index_page().'new_csr/home/new_resend/'.$order_id.'> CLICK TO RESEND</a>';
					$this->session->set_flashdata('message', $order_id.' : Mail not Sent.'.$resend_link);
				}else{
					$this->session->set_flashdata('message', 'Mail Sent Sucessfully.');
				}
				//redirect('new_csr/home/cshift/'.$order['help_desk']);
				redirect('new_csr/home/cshift/'.$order['help_desk'].'/mail_notification');
			}
		}
	}
	
	public function rev_resend($order_id='0', $rev_id='0')
	{
		$order = $this->db->get_where('orders',array('id' => $order_id))->row_array();
		$rev = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->row_array();
		if(isset($order['id']) && isset($rev['id'])){
			$client = $this->db->get_where('adreps',array('id' => $order['adrep_id']))->result_array();
			if($client){	
				//$dataa['fname'] = $rev['pdf_path']; 
				//$dataa['temp'] = $rev['pdf_path']; 
				$dataa['attachment'] =	$rev['pdf_path']; 
				//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				//$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				
				$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select design_teams.id, design_teams.revad_template, design_teams.email_id from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				
				$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
				$note = $this->db->get_where('note_sent',array('revision_id'=>$rev_id))->row_array();
				
				$dataa['template'] = $design_team[0]['revad_template'];
				$dataa['alias'] = $csr_alias[0]['alias'];
				$dataa['from'] = $design_team[0]['email_id'];
				if(($design_team[0]['revad_template'] == 'order_rating_mailer') && isset($note['id'])){
					$dataa['subject'] = 'Revised Ad (Note): '.$rev['new_slug'] ;
				}else{
					$dataa['subject'] = 'Revised Ad: '.$rev["new_slug"] ; 
				}
				$dataa['from_display'] = 'Design Team';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';
						
				$dataa['ad_type'] = 'revised' ;
				if(isset($note['id'])){ $dataa['note'] = $note['note']; } 
					//Client
				if($this->session->userdata('sId')=='25'){
					$dataa['recipient'] = 'webmaster@adwitglobal.com';
				}else{
					$dataa['recipient'] = $client[0]['email_id'];
				}
						
				$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				$dataa['client'] = $client[0];
				$dataa['design_team_id'] = $design_team[0]['id'];
				$dataa['order_id'] = $order_id ;
				$dataa['rev_id'] = $rev_id ;
				$this->load->library('Encryption');
				$rev_id = $this->encryption->encrypt($rev_id);
				$dataa['url']= base_url().index_page().'order_rating/home/rev_order_rating/'.$rev_id;
						
				if($this->demo_mail($dataa) == False){
					$resend_link = '<a href='.base_url().index_page().'new_csr/home/rev_resend/'.$order_id.'/'.$rev_id.'> CLICK TO RESEND</a>';
					$this->session->set_flashdata('message', $order_id.' : Mail not Sent.'.$resend_link);
				}else{
					$this->session->set_flashdata('message', 'Mail Sent Sucessfully.');
				}
				redirect('new_csr/home/frontlinetrack_order_list/'.$order['help_desk']);
			}
		}
	}
	
/*	public function demo_mail($dataa) 
	{
		$config = array();
                $config['useragent'] = "CodeIgniter";
                $config['mailpath']  = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']  = "smtp";
                $config['smtp_host'] = "localhost";
                $config['smtp_port'] = "25";
                $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;

        $this->load->library('email');
		$this->email->initialize($config);
 		$this->email->from($dataa['from'], $dataa['from_display']);
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		
		if(isset($dataa['Cc'])){
			$this->email->cc(array($dataa['Cc']));
		}
		
		if(isset($dataa['template'])){
		  $this->email->message($this->load->view($dataa['template'],$dataa, TRUE));
		  if($dataa['template']!='order_rating_mailer'){
			if(isset($dataa['attachment'])){ 
				$this->email->attach($dataa['attachment']);
			}  
		  }
		}
		$this->email->subject($dataa['subject']); $this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
		
		if($dataa['ad_type'] == 'new'){
			$myFile = "newad_notification/".$dataa['order_id'].".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			if(!$this->email->send()){
				$stringData = $dataa['order_id']." - Mail Not Sent - ";
				fwrite($fh, $stringData);
				fclose($fh);
				return FALSE;
			}else{
				$stringData = $dataa['order_id']." - Mail Sent ";
				fwrite($fh, $stringData);
				fclose($fh);
				return TRUE;
			} 
		}elseif($dataa['ad_type'] == 'revised'){
			$myFile = "email_notification/".$dataa['rev_id'].".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			if(!$this->email->send()){
				$stringData = $dataa['order_id']." - Mail Not Sent - ";
				fwrite($fh, $stringData);
				fclose($fh);
				return FALSE;
			}else{
				$stringData = $dataa['order_id']." - Mail Sent ";
				fwrite($fh, $stringData);
				fclose($fh);
				return TRUE;
			}
		}
	}*/
	
	public function demo_mail($dataa) 
	{
	    include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
	    
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($dataa['from'], $dataa['from_display']);
		$email->setReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
		
		if(isset($dataa['Cc'])){
		    $email->addCC($dataa['Cc']);
		}
		
		if(isset($dataa['template'])){
		    $email->addContent("text/html", $this->load->view($dataa['template'],$dataa, TRUE));
		    
		  if($dataa['template']!='order_rating_mailer'){
			if(isset($dataa['attachment'])){ 
			    $file_encoded = base64_encode(file_get_contents($dataa['attachment']));
                $email->addAttachment(
                                    $file_encoded,
                                    "application/pdf",
                                    basename($dataa['attachment']),
                                    "attachment"
                                );
			}  
		  }
		}
		$email->setSubject($dataa['subject']);
		$email->addTo($dataa['recipient'], $dataa['recipient_display']);
		
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		
		return TRUE;
	}

	public function question_mail($dataa) 
	{
	    $dataa['from'] = trim($dataa['from']);
	    $dataa['replyTo'] = trim($dataa['replyTo']);
	    $dataa['recipient'] = trim($dataa['recipient']);
	    
		include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
	    
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($dataa['from'], $dataa['from_display']);
		$email->setReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
		$email->setSubject($dataa['subject']);
		/*if($this->session->userdata('sId') == 68 || $dataa['order']['publication_id'] == '3' || $dataa['order']['group_id'] == '18'){
		    $email->setSubject("Question - ".$dataa['order']['id']." - ".$dataa['order']['advertiser_name']." - ".$dataa['order']['job_no']);
    		$email->addContent("text/html", $this->load->view('email_template/Question',$dataa, TRUE));
    	}else{
    	    if(isset($dataa['msg'])){
    			$email->addContent("text/html", $dataa['msg']);
    	    }else{
    			$email->addContent("text/html", $this->load->view('questionE',$dataa, TRUE)); 
            }
    	}*/
    	if(isset($dataa['msg'])){
    		$email->addContent("text/html", $dataa['msg']);
    	}else{
    	    $email->setSubject("Question - ".$dataa['order']['id']." - ".$dataa['order']['advertiser_name']." - ".$dataa['order']['job_no']);
    		$email->addContent("text/html", $this->load->view('email_template/Question',$dataa, TRUE));
    		//$email->addContent("text/html", $this->load->view('questionE',$dataa, TRUE)); 
        }
        $email->addTo($dataa['recipient'], $dataa['recipient_display']); 
		
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		 return true;
	}
/*	
	public function question_mail($dataa) 
	{
		$this->load->library('email'); 
		$this->email->set_mailtype("html"); 
		$this->email->from($dataa['from'], $dataa['from_display']); 
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		$this->email->subject($dataa['subject']);
		
		if(isset($dataa['msg'])){
			$this->email->message($dataa['msg']); 
	    }else{
			$this->email->message($this->load->view('questionE',$dataa, TRUE)); 
        }
        $this->email->to($dataa['recipient'], $dataa['recipient_display']); 
		$this->email->set_alt_message("Unable to load text!");
		
		if(!$this->email->send())
               return false;
               else
               return true; 
		   
		
	}
*/	
	public function revision($form = '')
	{
		$data['hi'] = "hi";
		if($form!='' || isset($_POST['form']))
		{
			if(!empty($_POST['id']))
			{
				$check = $this->db->get_where('rev_sold_jobs',array('order_no' => $_POST['id'], 'category' => 'revision'))->result_array();
				$form = $_POST['form'];
				if(!$check)
				{
					
					$tday = date('Y-m-d');
					$time = date("H:i:s");
					if(!empty($_POST['error']))
					{
						$values = implode(',',array_values($_POST['error']));
					}else{ $values = '0'; }
					
					if(!empty($_POST['fastrack']))
					{
						$cat_rev = "fastrack";
						$data['fastrack_msg'] = "fastrack msg";
					}elseif(!empty($_POST['new']))
					{
						$cat_rev = "new";
					}else{
						$cat_rev = "revision";
					}
					$dataa = array(
							'csr' => $this->session->userdata('sId'),
							'help_desk' => $_POST['form'],
							'order_no' => $_POST['id'], 
							'date' => $tday,
							'time' => $time,
							'category' => $cat_rev,
							'error' => $values,
							);
					$this->db->insert('rev_sold_jobs', $dataa);
					$data['rev_status'] = "Submitted";
					//$data['form'] = $_POST['form'];
				}else{
					$data['rev_status'] = "Already Revised";
				}
			}
			if(isset($_POST['search']) && !empty($_POST['order_chk']))
			{
				$form = $_POST['form'];
				$order_no = $_POST['order_chk'];
				$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,
				orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,
				orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,
				orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,
				orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,
				orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,
				orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,
				orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
											FROM `orders` WHERE `id` LIKE '$order_no%' OR `job_no` LIKE '$order_no%' OR `advertiser_name` LIKE '$order_no%'")->result_array();
				if($orders){ $data['orders'] = $orders; }
				else{
					$this->session->set_flashdata("message","No Orders Found for $order_no");
					redirect('new_csr/home/revision/'.$form);
				}
			}
			$data['form'] = $form;
		}	
		$this->load->view('new_csr/rev_sold',$data);
	}
    
    public function revision_new()
	{
		$data['hi'] = "hi";
		
		if(isset($_POST['search']) && !empty($_POST['order_chk'])){
				$order_no = $_POST['order_chk'];
				$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,
				orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,
				orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,
				orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,
				orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,
				orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,
				orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,
				orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
											FROM `orders` WHERE `id` LIKE '$order_no%' OR `job_no` LIKE '$order_no%' OR `advertiser_name` LIKE '$order_no%'")->result_array();
				if($orders){ 
				    $data['orders'] = $orders; 
				}else{
					$this->session->set_flashdata("message","No Orders Found for $order_no");
					redirect('new_csr/home/revision/'.$form);
				}
		}
			
		$this->load->view('new_csr/rev_sold_new',$data);
	}
	
	public function sold()
	{
		$data['hi'] = "hi";
		
		if(!empty($_POST['id']))
		{
			$check = $this->db->get_where('rev_sold_jobs',array('order_no' => $_POST['id'], 'category' => 'sold'))->result_array();
			if(!$check)
			{
				
				$tday = date('Y-m-d');
				$time = date("H:i:s");
				$data = array(
						'csr' => $this->session->userdata('sId'),
						'help_desk' => $_POST['form'],
						'order_no' => $_POST['id'], 
						'date' => $tday,
						'time' => $time,
						'category' => 'sold',
						);
				$this->db->insert('rev_sold_jobs', $data);
				$data['sold_status'] = "Submitted";
				$data['form'] = $_POST['form'];
			}else{
				$data['sold_status'] = "Already Revised";
				$data['form'] = $_POST['form'];
			}
		}
		$this->load->view('new_csr/rev_sold',$data);
	}
	
	public function frontlinetrack_order_list($help_desk_id = '')
	{
	    $data['help_desk_id'] = $help_desk_id;
	  
	    $today = date('Y-m-d'); $data['today'] = $today;
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
		
		$no_of_order = $this->input->post('no_of_order');
		$selected_date = $this->input->post('selected_date');
		$order_by = null;
        $sort_by = null;
	   $help_desk_detail = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
	   if(isset($help_desk_detail['id'])){
	       $adwit_teams_id = $help_desk_detail['adwit_teams_id'];
	       $adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
	       $cat_id = explode(',',($adwit_team['category']));
		    $category_level = "'" . implode ( "', '", $cat_id ) . "'";
		     $ad_order_type ="";
                    if(isset($_GET['ad_order_type'])){
                        if($_GET['ad_order_type'] == "rush"){
                            $ad_order_type = "rush";
                        }
                    }
		    
		   if(isset($_GET['display_type'])){ $display_type = $_GET['display_type'];  }else{ $display_type = 'all'; } 
	       if(isset($_GET['date'])){ $order_date = $_GET['date'];  }else{ $order_date = $today; }
	       
	       $data['date'] = $order_date;
	       if($selected_date != "" && $selected_date != null && $selected_date != 'rush'){
	           $data['date'] = $selected_date;
	           $order_date = $selected_date;
	       }
	       
	       $data['selected_date']=$selected_date;
	       if($order_date == 'rush'  || $ad_order_type == "rush"){
	           $q = "SELECT orders.id, orders.created_on, orders.order_type_id, orders.status, orders.advertiser_name, orders.job_no, orders.question, orders.help_desk,
	            publications.name AS Pname, CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname FROM orders 
	                    JOIN `publications` ON publications.id = orders.publication_id
	                    JOIN `adreps` ON adreps.id = orders.adrep_id
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.crequest != '1' AND orders.help_desk != '0'
	                    AND orders.club_id IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ) AND DATE(orders.created_on) > '2023-01-01'
	                    ORDER BY orders.id DESC;" ; 
	            /*$q = "SELECT orders.id, orders.created_on, orders.order_type_id, orders.status, orders.advertiser_name, orders.job_no, orders.question, orders.help_desk,
	            publications.name AS Pname, CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname FROM orders 
	                    JOIN `publications` ON publications.id = orders.publication_id
	                    JOIN `adreps` ON adreps.id = orders.adrep_id
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.crequest != '1' AND orders.question != '1' AND orders.help_desk != '0'
	                    AND orders.publication_id IN (SELECT `id`  FROM `publications` WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ))
	                    ORDER BY orders.id DESC;" ;   */
	                    
	           #pagination code starts here
                $config = array();
				$config['base_url'] = base_url() . "index.php/new_csr/home/frontlinetrack_order_list/" . $help_desk_id;
				$config["suffix"]='?date=' . $order_date . '&display_type=' . $display_type;
				$config['first_url'] = $config['base_url'] . $config['suffix'];
				
				if($this->input->get('rush_order_search') != null){
				    $data['date'] =  "rush";
					$search = $this->input->get('rush_order_search');
					$this->session->set_userdata('rush_search_val', $search);
					$config["total_rows"] = $this->Pagination->get_rush_ad_count($adwit_teams_id,$search);
				}else if($this->session->userdata("rush_search_val") !== "" && $this->input->get('rush_order_search') == null){
				    $data['date'] =  "rush";
					$search =  $this->session->userdata("rush_search_val");
					$config["total_rows"] = $this->Pagination->get_rush_ad_count($adwit_teams_id,$search);
				}else{
					$config["total_rows"] = $this->Pagination->get_rush_ad_count($adwit_teams_id,null);
				}
				
				if($no_of_order != "" && $no_of_order != null){
				  	$config["per_page"] = $no_of_order;  
				  	$this->session->set_userdata('rush_no_of_order', $no_of_order);
				}else if($no_of_order == "" && $this->session->userdata('rush_no_of_order') != ""){
				    $config["per_page"] = $this->session->userdata('rush_no_of_order');
				}else{
				    unset($_SESSION['rush_no_of_order']);
				   	$config["per_page"] = 25; 
				} 
				
				$config["uri_segment"] = 5;
                $config['reuse_query_string'] = false;
				
				$this->get_pagination_config($config);

				$this->pagination->initialize($config);
				$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
				if($this->input->get('rush_order_search') != null){
					$search = $this->input->get('rush_order_search');
					$data["rev_sold_jobs"] = $this->Pagination->
					get_rush_ad($config["per_page"], $page,$adwit_teams_id,$search);
				}else if($this->session->userdata("rush_search_val") != "" && $this->input->get('rush_order_search') == null){
					$search =  $this->session->userdata("rush_search_val");
					$data["rev_sold_jobs"] = $this->Pagination->
					get_rush_ad($config["per_page"], $page,$adwit_teams_id,$search);
					
				}else{
					$data["rev_sold_jobs"] = $this->Pagination->
					get_rush_ad($config["per_page"], $page,$adwit_teams_id,null);
				} 
				$data["rush_ad_links"] = $this->pagination->create_links(); 
            #pagination code ends here
	       }else{
	          /* if($help_desk_id == '20'){ //pagination
	               $q = "SELECT rev_sold_jobs.*, cat_result.order_type_id FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                        WHERE cat_result.category = 'G'
                        AND rev_sold_jobs.date = '$order_date' ";
	           }else{
    	            $q = "SELECT rev_sold_jobs.*, cat_result.order_type_id FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                        WHERE cat_result.publication_id IN (SELECT `id`  FROM `publications` WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ))
                        AND cat_result.category IN ($category_level)
                        AND rev_sold_jobs.date = '$order_date' ";
	           }    
                if($display_type == 'pending'){
                   $q .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
                }elseif($display_type == 'sent'){
                   $q .= " AND rev_sold_jobs.status IN ('5','9') "; 
                }elseif($display_type == 'QA'){
                   $q .= " AND rev_sold_jobs.status IN ('4','7') "; 
                }
                
                $q .= " ORDER BY rev_sold_jobs.id ASC;";  */
                /* if($this->session->userdata('publicationListTeam'.$adwit_teams_id)!== null){
	                  $publicationListTeam = $this->session->userdata('publicationListTeam'.$adwit_teams_id); //echo $publicationListTeam;
	               }else{
	                   $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications`
	                                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id)")->row_array();
	                  $publicationListTeam =  $team_publication['publicationsId'];
	               }
	               $q = "SELECT rev_sold_jobs.*, cat_result.order_type_id FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                        WHERE cat_result.publication_id IN ($publicationListTeam)
                        AND cat_result.category IN ($category_level)
                        AND rev_sold_jobs.date = '$order_date' ";
                        
                 if($display_type == 'pending'){
                   $q .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
                }elseif($display_type == 'sent'){
                   $q .= " AND rev_sold_jobs.status IN ('5','9') "; 
                }elseif($display_type == 'QA'){
                   $q .= " AND rev_sold_jobs.status IN ('4','7') "; 
                }
                
                $q .= " ORDER BY rev_sold_jobs.id ASC;"; */
                if($this->session->userdata('publicationListTeam'.$adwit_teams_id)!== null){
	                  $publicationListTeam = $this->session->userdata('publicationListTeam'.$adwit_teams_id); //echo $publicationListTeam;
	               }else{
	                   $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications`
	                                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id)")->row_array();
	                  $publicationListTeam =  $team_publication['publicationsId'];
	               }
                #pagination code starts here
                 if(isset($_POST['csr_r_order_by'])){
                   $order_by  =  $_POST['csr_r_order_by'];
                   $this->session->set_userdata("csr_r_order_by",$order_by);
                }
                if(isset($_POST['csr_r_sort_by'])){
                    $sort_by = $_POST['csr_r_sort_by'];
                    $this->session->set_userdata("csr_r_sort_by",$sort_by);
                }
                $config = array();
				$config['base_url'] = base_url() . "index.php/new_csr/home/frontlinetrack_order_list/" . $help_desk_id;
				$config["suffix"]='?date=' . $order_date . '&display_type=' . $display_type;
				// $config["use_global_url_suffix"] = false;
				$config['first_url'] = $config['base_url'] . $config['suffix'];
				// $config["enable_query_strings"] = true;
				if($this->input->get('rev_order_search') != null){
					$search = $this->input->get('rev_order_search');
					$this->session->set_userdata('rev_search_val', $search);
					$config["total_rows"] = $this->Pagination->get_revision_ad_count($adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$search);
				}else if($this->session->userdata("rev_search_val") !== "" && $this->input->get('rev_order_search') == null){
					$search =  $this->session->userdata("rev_search_val");
					$config["total_rows"] = $this->Pagination->get_revision_ad_count($adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$search);
				}else{
					$config["total_rows"] = $this->Pagination->get_revision_ad_count($adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,null);
				}
				
				if($no_of_order != "" && $no_of_order != null){
				    $data['date1'] = $order_date;
				  	$config["per_page"] = $no_of_order;  
				  	$this->session->set_userdata('rev_no_of_order', $no_of_order);
				}else if($no_of_order == "" && $this->session->userdata('rev_no_of_order') != ""){
				    $config["per_page"] = $this->session->userdata('rev_no_of_order');
				}else{
				    unset($_SESSION['rev_no_of_order']);
				   	$config["per_page"] = 25; 
				} 
				
				$config["uri_segment"] = 5;
                $config['reuse_query_string'] = false;
                
                $this->get_pagination_config($config);
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
				if($this->input->get('rev_order_search') != null){
					$search = $this->input->get('rev_order_search');
					$data["rev_sold_jobs"] = $this->Pagination->
					get_rev_ad($config["per_page"], $page,$adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$sort_by,$order_by,$search);
				}else if($this->session->userdata("rev_search_val") != "" && $this->input->get('rev_order_search') == null){
					$search =  $this->session->userdata("rev_search_val");
					$data["rev_sold_jobs"] = $this->Pagination->
					get_rev_ad($config["per_page"], $page,$adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$sort_by,$order_by,$search);
					
				}else{
					$data["rev_sold_jobs"] = $this->Pagination->
					get_rev_ad($config["per_page"], $page,$adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$sort_by,$order_by,null);
				} 
				$data["links"] = $this->pagination->create_links(); 
				$end_index = min($config["per_page"] +$page, $config["total_rows"]);
                $data["result_range"] = "Showing " . $page+1 . " to " . $end_index . " of {$config['total_rows']} entries.";
                #pagination code ends here
	        } 
	        
            //echo $q;
            // $rev_sold_jobs = $this->db->query($q)->result_array();
            // $data['rev_sold_jobs'] = $rev_sold_jobs;
            $data['display_type'] = $display_type;
            // print_r($data);exit();
	   }
	   $this->load->view('new_csr/frontlinetrack_order_list',$data);
	}
	
	public function frontlinetrack_all($form = '' ,$display_type = 'all')
	{ 
		$data['display_type'] = $display_type;
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
		
		if($form!=''){
		    if($form >= 23 ){ redirect('new_csr/home/frontlinetrack_order_list/'.$form); }
			$data['form'] = $form;
			if(isset($_POST['date'])){ $data['date'] = $_POST['date']; }
			
			if(isset($_POST['accept'])){	//new
				$rev_sold_jobs = $this->db->get_where('rev_sold_jobs', array('id' => $_POST['id']))->row_array();
				$post = array( 'job_accept' => '1', 'csr' => $this->session->userdata('sId'), 'status' => '2' );
				$this->db->where('id', $_POST['id']);
				$this->db->update('rev_sold_jobs', $post);
				
				//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['id']."' ")->row_array();
					if(isset($update_revision['id'])){
						$tracker_data = array('status' => '2');
						$this->db->where('id', $update_revision['id']);
						$this->db->update('live_revisions', $tracker_data);
					}
				
				
				//map orders status update via cURL
					if(isset($rev_sold_jobs['map_revorder_id']) && $rev_sold_jobs['map_revorder_id'] != NULL && $rev_sold_jobs['map_revorder_id'] != '0'){
						$fields = array(
										'status' => '2', 
										'map_revorder_id' => $rev_sold_jobs['map_revorder_id'],
										'adwitads_rev_id' => $rev_sold_jobs['id']
										);
						$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/revorder_status_update';
						$this->curl_post($url, $fields); //API using cURL 
					}
			}
			
			if(isset($_POST['display_type'])){
				$data['display_type'] = $_POST['display_type'];
			}
		
			$this->load->view('new_csr/frontlinetrack',$data);
		}else{
			$this->load->view('new_csr/frontlinetrack_desk');
		}
	}
	
	public function frontlinetrack_new($hd = '')
	{ 
	    $selected_help_desk = '';
	    $helpDesks = array();
		$data['today'] = $today = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
		
		$data['help_desk_data'] = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
		
		$data['selected_help_desk'] = $selected_help_desk;
		$data['helpDesks'] = $helpDesks;
		$data['frontline_timer'] = $this->db->get('frontline_timer')->result_array();
	
		$this->load->view('new_csr/frontlinetrack_new', $data);
	}
	
	public function frontlinetrack_new_content()
	{
	    $today = date('Y-m-d');
	    
	    $selected_help_desk = ''; $session_hd = '';
	    $helpDesks = array();
	    
	    $query = "SELECT rev_sold_jobs.*, orders.order_type_id, frontline_timer.duration, help_desk.name AS DeskName FROM `rev_sold_jobs` 
		            LEFT JOIN `orders` ON orders.id = rev_sold_jobs.order_id
		            LEFT JOIN `frontline_timer` ON frontline_timer.cat_name = rev_sold_jobs.category
		            LEFT JOIN `help_desk` ON help_desk.id = rev_sold_jobs.help_desk
		            WHERE rev_sold_jobs.order_id != ''";
		
		if(isset($_GET['helpDesks']) && !empty($_GET['helpDesks']) && !empty($_GET['helpDesks'][0])){
		    $helpDesks = $_GET['helpDesks'];
		    $session_hd = explode(',', $helpDesks[0]);
		    $selected_help_desk = join($helpDesks, ',');
		    $query .= " AND rev_sold_jobs.help_desk IN ($selected_help_desk)";   
		}
		//store hd session
		$this->session->set_userdata('helpDesks', $session_hd);
		
		if(isset($_GET['date_selection'])){
		    $selected_date = $_GET['date_selection'];
		    $query .= " AND rev_sold_jobs.date = '$selected_date'";   
		}else{
		    $query .= " AND rev_sold_jobs.date = '$today'"; 
		}
		
        $query .= " AND (";
		//search or Filter
		if(isset($_GET['search']['value'])){
			$query .= ' rev_sold_jobs.order_no LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR help_desk.name LIKE "%'.$_GET["search"]["value"].'%"';
		}
		$query .= ") ";
			
		//ORDER BY
			if(isset($_GET['order'])){
				$query .= ' ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
			}else{
				$query .= ' ORDER BY rev_sold_jobs.id DESC';
			}
			
			$extra_query = '';
			if($_GET['length'] != -1){
				$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
			}
			//echo '<script>console.log('.$query.')</script>';//echo $query;
			$filtered_rows = $this->db->query($query)->num_rows();
			$query .= $extra_query;
			
			$revision_orders = $this->db->query("$query")->result_array();
						   
			$total_rows = $this->db->query($query)->num_rows();
			
			$data = array(); $total_record_count = $filtered_rows; $start_record = $_GET['start'];
			//$data[] = $query;
			foreach($revision_orders as $row){
			    $count = $total_record_count - $start_record; $form = $row['help_desk'];
			    $start_record++;
			  //Type column
			    if($row['order_type_id']=='2') {
			        $order_type_display = "P";
			    }elseif($row['order_type_id']=='1'){ 
			        $order_type_display = "W";
			    }else{ 
			        $order_type_display = "P&W";
			    }
    		//Job No. column
    			if($row['rush'] == 1){
    			    $job_no_tab = '<a class="bg-red-pink" href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">'.$row['order_no'].'</a>'; 
    			}else{
    			    $job_no_tab = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">'.$row['order_no'].'</a>';
    			}
			  //Revision Column
			    if($row['category']=='revision'){ $rev_tab = $row['time']; }else{ $rev_tab = ''; }
			  //Designer Column
			    if($row['designer']!='0'){
			        $designer = $this->db->query("SELECT designers.username FROM `designers` WHERE designers.id = ".$row['designer'])->row_array();
			        $designer_username = $designer['username']; 
			    }else{ $designer_username = ''; }
			  //Time Left Column
			    if($row['status']=='5' || $row['status']=='8'){
					$time_left_tab = '';
	            }elseif(isset($cat_time) && ($time_left < $cat_time && $row['sent_time']=='00:00:00')){ 
					$timer = $cat_time - $time_left ;  
				    if($timer<= '5'){
					    $time_left_tab = "<font color='red'>". round($timer,0)." min </font>";
					}else{ 
					    $time_left_tab =  round($timer,0)." mins"; 
					}
				}else{ 
				    $time_left_tab = "Elapsed"; 
				} 
				
				if($row['job_status']=='1'){ 
					if($row['question']=='1'){ 
						$time_sent_tab = '<button>Question Sent</button>';
					}elseif($row['sent_time']!='00:00:00' && $row['status'] != '8'){ 
						$time_sent_tab = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
					                        <button type="button" id="accept" class="btn btn-sm btn-primary">Sent</button>
						                  </a>';
					}elseif($row['sent_time']!='00:00:00' && $row['status'] == '8'){ 
					    $time_sent_tab = $row['sent_time'] ; 
					}else{
					    if($row['sold_pdf'] != 'none' && $row['frontline_csr'] == '0' && $row['status'] == '8') { 
							$button_display = '<button type="submit" name="Submit" class="btn btn-sm btn-primary">Send</button>';
						}elseif($row['sold_pdf'] != 'none' && $row['status'] == '4') { 
							$button_display = '<button type="submit" name="send_sold" class="btn btn-sm btn-primary">Send</button>';
						}elseif($row['sold_pdf']=='none' && $row['status'] == '8'){ 
							$button_display = '<div class="btn-group">
													<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
														<button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
													</a>
												</div>';
						}elseif($row['job_accept']=='0' && $row['order_id']!=''){
							$button_display = '<div class="btn-group">
													<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
													    <button type="button" id="accept" class="btn btn-sm btn-primary">Accept</button>
													</a>
												</div>';
						}elseif($row['source_file']!='none'&&$row['status']=='4'){  
							$button_display = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
													<button type="button" id="accept" class="btn btn-sm btn-primary">ReadyForQA</button>
												</a>';
						}elseif($row['sold_pdf']!='none'&&$row['status']=='4'){
							$button_display = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
													<button type="button" id="accept" class="btn btn-sm btn-primary">ReadyForQA</button>
												</a>';
						}elseif($row['sold_pdf']!='none'&&$row['status']=='5'&&$row['new_slug']!='none'){ 
							$button_display = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
													<button type="button" id="accept" class="btn btn-sm btn-primary">ProofReady</button>
												</a>';
						}elseif($row['new_slug']!='none'){ 
							$button_display = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
												    <button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
												</a>';
						}elseif($row['status']=='2'){ 
							$button_display = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$form.'/'.$row['order_id'].'">
													<button type="button" id="accept" class="btn btn-sm btn-primary">Accepted</button>
												</a>';
						}
						
						if(isset($date)){ 
						    $date_input = '<input name="date" value="'.$date.'" readonly style="display:none;" />';
						}else{
						    $date_input = '';
						}
						
						$time_sent_tab = '<form method="post" enctype="multipart/form-data">'
						                    .$button_display.'
											<input name="id" value="'.$row['id'].'" readonly style="display:none;" />
											<input name="new_slug" value="'.$row['new_slug'].'" readonly style="display:none;" />
											<input name="adrep" value="'.$row['adrep'].'" readonly style="display:none;" />
											'.$date_input.'
										   </form>';
												
					} 
				}else{ 
				    $time_sent_tab = "<font color='blue'>removed</font>"; 
				} 
			    
			   //Time taken 
			    if($row['time_taken']!='0'){ 
					//calculating hours, minutes and seconds (as floating point values)
					$hours = $row['time_taken'] / 3600; //one hour has 3600 seconds
					$minutes = ($hours - floor($hours)) * 60;
					$seconds = ($minutes - floor($minutes)) * 60;

					//formatting hours, minutes and seconds
					$final_hours = floor($hours);
					$final_minutes = floor($minutes);
					$final_seconds = floor($seconds);

					//output
					$time_taken_tab = $final_hours . ":" . $final_minutes . ":" . $final_seconds; 
				}else{
				    $time_taken_tab = '';
				} 
			//PDF
			    if($row['category']!='sold') { 
				    if($row['pdf_path']!='none' && file_exists($row['pdf_path'])){
							$pdf_path = base_url().$row['pdf_path'];  
							$pdf_tab =	'<a href="'.$pdf_path.'" target="_blank" style="cursor:pointer; text-decoration: none;">
							                <img src="'.base_url().'images/pdf.png" alt="pdf"/></a>';
					}else{ 
					    $pdf_tab = ' '; 
					} 
				}else{
				    $cat_result = $this->db->query("SELECT cat_result.slug FROM `cat_result` WHERE cat_result.order_no = '".$row['order_id']."'")->row_array();
					$sold_pdf_path = 'sold_pdf/'.$row['order_id'].'/'.$cat_result['slug'];
					if(isset($sold_pdf_path) && $row['sold_pdf']!='none'){ 
						$map1 = $sold_pdf_path.'/'.$row['sold_pdf'];
						if(file_exists($map1)){
							$pdf_tab =	'<a href="'.base_url().$map1.'" target="_blank" style="cursor:pointer; text-decoration: none;">
							                <img src="'.base_url().'images/pdf.png" alt="pdf"/></a>';
						}else{ 
						    $pdf_tab = ' '; 
						} 
					}else{ 
						 $pdf_tab = ' '; 
					} 
				}
			//Classification 	
			    if($row['classification']!='0'){
			        $rev_classification = $this->db->query("SELECT rev_classification.name FROM `rev_classification` WHERE rev_classification.id = '".$row['classification']."'")->row_array();
			        $classification_tab = $rev_classification['name']; 
			    }else{
			        $classification_tab = '';
			    } 						
				$sub_array = array();
				
				$sub_array[] = $count; 
    			$sub_array[] = '<span class="badge bg-blue">'.$order_type_display.'</span>';
    			$sub_array[] = $row['DeskName'];	//order job_no/page name
    			$sub_array[] = $job_no_tab;
    			$sub_array[] = $rev_tab;	
    			
    			$sub_array[] = $designer_username;	//order Status
    			$sub_array[] = $time_left_tab;
    			$sub_array[] = $time_sent_tab;
    			$sub_array[] = $time_taken_tab;
    			$sub_array[] = $pdf_tab;
    			$sub_array[] = $classification_tab;
    			
    			$data[] = $sub_array;
			}
			
			$output = array(
							"draw"    => intval($_GET["draw"]),
							"recordsTotal"  => $total_rows,
							"recordsFiltered" => $filtered_rows,
							"data"    => $data
						   );
			echo json_encode($output);
	}
	
	public function frontline_instruction($hd = '', $rev_id = '')
	{
		$rev_sold = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id, 'job_status' => '1'))->result_array();
		if($rev_sold)
		{
			$data['rev_sold'] = $rev_sold[0];
			$this->load->view('new_csr/frontline_instruction',$data);
		}else{
			$this->session->set_flashdata("message","Order Details Not Found!!");
			redirect('new_csr/home/frontlinetrack_order_list/'.$hd);
		}
	}
	
	public function orderfrontline_cancel($order = '')
	{
		if($order!='')
		{
			$data['order'] = $order;
			
			if(isset($_POST['remove']))
			{
				$data = array(  'frontline_csr' => $this->session->userdata('sId'),
								'reason' => $_POST['reason'],
								'job_status' => '0',
								'cancel' => '1',
								);
				$this->db->where('id', $order);
				$this->db->update('rev_sold_jobs', $data);
				
				redirect('new_csr/home/frontlinetrack_all');
			}else{
				$rev_sold = $this->db->get_where('rev_sold_jobs',array('id' => $order))->result_array();
				$data['rev_sold'] = $rev_sold[0];
			}
		}
		$this->load->view('new_csr/orderfrontline_cancel',$data);
	}
	
	public function category_edit($order = '')
	{
		if($order!='')
		{
			$cat_result = $this->db->get_where('cat_result',array('id' => $order))->result_array();
			if($cat_result && $cat_result[0]['slug']=='none')
			{
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('order_no', 'Order Number', 'trim');
			
				$this->form_validation->set_rules('width', 'Width', 'trim|is_numeric');
				
				$this->form_validation->set_rules('height', 'Height', 'trim|is_numeric');
				
				$this->form_validation->set_rules('job_name', 'job_name', 'trim');
				
				$this->form_validation->set_rules('adtype', 'Adtype', 'trim');
				
				$this->form_validation->set_rules('artinstruction', 'ArtInstruction', 'trim');
					
				$this->form_validation->set_rules('cat_news', 'Newspaper', 'trim');
				
				$this->form_validation->set_rules('oid', 'id', 'trim');
				//$data['order'] = $order;
				
				if ($this->form_validation->run() == FALSE)
				{
					$data['order'] = $cat_result;
					//$this->load->view('new_csr/category-edit', $data);
				}
			
			}else{
				$data['error1'] = "slug created!! access denied" ;
				//$this->load->view('new_csr/category-edit', $data);
			}
			if(isset($_POST['Submit']))
			{
				
					$width = $_POST['width'];
					$height = $_POST['height'];
					$art = $_POST['artinstruction'];
					$adtype = $_POST['adtype'];
					
					$size = $width * $height;
					if($size == '0')
					{	
						$data['error']='width & height fields shouldnot be zero';
						//$this->load->view('new_csr/category-edit', $data);
					}
					
					if($adtype == '2')
					{
						if($size <= '20')
						{
							$category = "A";
							if($art == 2) $category = "B";
						}elseif($size <= '75' )
						{
							$category = "B";
							if($art == 2) $category = "C";
						}else{ $category = "C";
								if($art == 2) $category = "D";
						}
					}
					
					if($adtype == '4')
					{
						if($size <= '20')
						{
							$category = "B";
							if($art == 2) $category = "B";
						}elseif($size <= '75' )
						{
							$category = "B";
							if($art == 2) $category = "C";
						}else{ $category = "C";
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
					//$this->load->view('new_csr/category-edit', $data);
			}	
				if(isset($_POST['confirm']))
				{
					if($_POST['cat_news']!="")
					{
						$rest = $this->db->get_where('cat_newspaper',array('id' => $_POST['cat_news']))->result_array();
						$initial = $rest[0]['initials'];
						$slug_type = $rest[0]['slug_type'];
						$team = $rest[0]['team'];
					}
					
					$dataa = array(
								'order_no' => $_POST['order_no'],
								'job_name' => $_POST['job_name'],
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								
								'artinstruction' => $_POST['artinstruction'],
								'adtypewt' => $_POST['adtype'],
								'news_id' => $_POST['cat_news'],
								'news_initial' => $initial,
								'team' => $team,
								'slug_type' => $slug_type,
								'category' => $_POST['category'],
								//'csr' => $this->session->userdata('sId'),
								//'date' => Date("Ymd"),
								//'time' => date("His")
								);
					$this->db->where('id', $order);
					$this->db->update('cat_result', $dataa); 
					//Live_tracker Category Updation
					$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$_POST['order_no']."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $_POST['category']);
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
					redirect('new_csr/home');	
				}
			$this->load->view('new_csr/category-edit', $data);
		}	
	}
	
	public function other_adreps()
	{
		$data['hi'] = "hi";
		if(isset($_POST['name']))
		{
			$data = array('name' => $_POST['name']);
			$this->db->insert('other_adreps', $data);
			$id = $this->db->insert_id();
			if($id){ $data['msg']="Adrep <h3>".$_POST['name']."</h3> sucessfully inserted to the list!!"; }else{ $data['msg']="Insertion failed!!"; }
		}
		$this->load->view('new_csr/other-adreps',$data);
	}
	
	public function other_advertiser()
	{
		$data['hi'] = "hi";
		if(isset($_POST['name']))
		{
			$data = array('name' => $_POST['name']);
			$this->db->insert('other_advertiser', $data);
			$id = $this->db->insert_id();
			if($id){ $data['msg']="Advertiser <h3>".$_POST['name']."</h3> sucessfully inserted to the list!!"; }else{ $data['msg']="Insertion failed!!"; }
		}
		$this->load->view('new_csr/other-advertiser',$data);
	}
	
	public function billing_view($form = '', $display_type = 'approved')
	{
		
		if($form!='')
		{
			$data['form'] = $form;
			$data['display_type'] = $display_type;
			if(isset($_POST['id']))
			{
				$dataa = array('billing_status' => $_POST['status']);
				$this->db->where('id', $_POST['id']);
				$this->db->update('cat_result', $dataa);
			}
			$data['form'] = $form;
		}
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['today'] = date('Y-m-d');
		// $data['ystday'] = date('y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		
		
		$this->load->view('new_csr/billing_view',$data);
	}

	public function billing()
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']))
		{
			$order = $this->db->get_where('cat_result',array('order_no' => $_POST["order_chk"]))->result_array();
			if($order)
			{
				$data['order'] = $order;
			}else{
				$data['error_data'] = "No result found!!";
			}
		}
		if(isset($_POST['status']))
		{
			$dataa = array('billing_status' => $_POST['status']);
			$this->db->where('id', $_POST['id']);
			$this->db->update('cat_result', $dataa);
			if(!empty($_POST['reason']))
			{
				$data2 = array( 'order_no' => $_POST['order_no'],
								'cat_result_id' => $_POST['id'],
								'reason' => $_POST['reason'],
								'status' => $_POST['status'] );
				$this->db->insert('orders_billing_status', $data2);
			}
		}
		$this->load->view('new_csr/billing',$data);
			
	}
	
	public function chart()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
			
		if(isset($_POST['total']))
		{
			$d1 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` ASC LIMIT 1")->result_array();
			$d2 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
			foreach($d1 as $rows2) $from= $rows2['date']; 
			foreach($d2 as $rows3) $to= $rows3['date'];
			$dte = $from.' to '.$to;
			$dated = date('M Y', strtotime($from)).' to '.date('M Y', strtotime($to)) ;
			
			$sql = $this->db->get_where('cat_result',array('csr' => $this->session->userdata('sId')))->result_array();
			$sql1 = $this->db->get_where('cp_tool',array('csr' => $this->session->userdata('sId')))->result_array();
			$sql2 = $this->db->get_where('cp_tool',array('upload_csr' => $this->session->userdata('sId')))->result_array();
		
		}elseif(isset($_POST['prevmonth']))
		{
			$dte = date('Y-m', strtotime(' -1 month'));
			$dated = date('M Y', strtotime(' -1 month'));
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `csr` = '".$this->session->userdata('sId')."' AND `date` LIKE '$dte%' ")->result_array();
			$sql1 = $this->db->query("SELECT * FROM `cp_tool` WHERE `csr` = '".$this->session->userdata('sId')."' AND `date` LIKE '$dte%' ")->result_array();
			$sql2 = $this->db->query("SELECT * FROM `cp_tool` WHERE `upload_csr` = '".$this->session->userdata('sId')."' AND `date` LIKE '$dte%' ")->result_array();
				
		}elseif(isset($_POST['last3month']))
		{
			$from = date('Y-m-01', strtotime(' -2 month'));
			$to = date('Y-m-d');
			$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `csr` = '".$this->session->userdata('sId')."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
			$sql1 = $this->db->query("SELECT * FROM `cp_tool` WHERE `csr` = '".$this->session->userdata('sId')."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
			$sql2 = $this->db->query("SELECT * FROM `cp_tool` WHERE `upload_csr` = '".$this->session->userdata('sId')."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();	
		
		}else{
			$dte = date('Y-m');
			$dated = date('M Y');
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `csr` = '".$this->session->userdata('sId')."' AND `date` LIKE '$dte%' ")->result_array();
			$sql1 = $this->db->query("SELECT * FROM `cp_tool` WHERE `csr` = '".$this->session->userdata('sId')."' AND `date` LIKE '$dte%' ")->result_array();
			$sql2 = $this->db->query("SELECT * FROM `cp_tool` WHERE `upload_csr` = '".$this->session->userdata('sId')."' AND `date` LIKE '$dte%' ")->result_array();	
		}
		
		$r = (100 * count($sql))/100 ;
		$s = (100 * count($sql1))/100 ;
		$t = (100 * count($sql2))/100 ;
			
		$this->gcharts->DataTable('add')
					  ->addColumn('string', 'add', 'category_orders')
					  ->addColumn('string', 'Amount', 'amount')
                      ->addColumn('string', 'Amount', 'amount')
					  ->addRow(array('Category' , $r))
					  ->addRow(array('QA' , $s))
					  ->addRow(array('Uploads' , $t));
		
		     
		$config = array(
            'title' => '',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		$data['date'] = $dated;
        $this->load->view('new_csr/chart', $data);
		
	}

	public function new_cat($hd='0', $publication='', $adrep='', $order_id='')
    {
		if($hd!='' && isset($_POST['Search'])){
			$adrep_list = $this->db->query("SELECT * FROM `adreps` WHERE (`first_name` LIKE '%".$_POST['adrep']."%' OR `username` LIKE '%".$_POST['adrep']."%') AND `is_active`='1';")->result_array();
			if($adrep_list)
			{
				$data['adrep_list'] = $adrep_list;
				
			}else{
				$this->session->set_flashdata("message2","Adrep not found!!");
				redirect('new_csr/home/new_cat/'.$hd); 
			}
		}
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			
			if (isset($_POST['order_no'])) $this->form_validation->set_rules('order_no', 'Order Number', 'trim');
			
			if($hd=="web"){
				if (isset($_POST['pixel_size'])) $this->form_validation->set_rules('pixel_size', 'Pixel Size', 'trim|required');
				
				if (isset($_POST['custom_width'])) $this->form_validation->set_rules('custom_width', 'Custom Width', 'trim');

				if (isset($_POST['custom_height'])) $this->form_validation->set_rules('custom_height', 'Custom Height', 'trim');
			
				if (isset($_POST['maxium_file_size'])) $this->form_validation->set_rules('maxium_file_size', 'maxium file size', 'trim|required');
				
				if (isset($_POST['web_ad_type'])) $this->form_validation->set_rules('web_ad_type', 'Web Ad Type', 'trim|required');
				
				if (isset($_POST['ad_format'])) $this->form_validation->set_rules('ad_format', 'Web Ad Format', 'trim|required');
			}else{
				if (isset($_POST['width'])) $this->form_validation->set_rules('width', 'Width', 'trim|required');
			
				if (isset($_POST['height'])) $this->form_validation->set_rules('height', 'Height', 'trim|required');
				
				if (isset($_POST['print_ad_type'])) $this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			}
			
			if (isset($_POST['job_name'])) $this->form_validation->set_rules('job_name', 'job_name', 'trim|required');
			
			if (isset($_POST['advertiser'])) $this->form_validation->set_rules('advertiser', 'Advertiser', 'trim|required');
			
			if (isset($_POST['adtype'])) $this->form_validation->set_rules('adtype', 'Adtype', 'trim|required');
			
// 			if (isset($_POST['artinst'])) $this->form_validation->set_rules('artinst', 'Artinst', 'trim|required');
			
			//$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
		
		if($order_id!=''){
			$order = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE `id` = '".$order_id."'")->result_array();
			if($order){
				$data['order']=$order[0];
			}else{
				$this->session->set_flashdata("message","Invalid Order Id...!!");
				redirect('new_csr/home/new_cat/'.$hd);
			}
		}
		$adtype = $this->db->get('cat_new_adtype')->result_array();
		$artinst = $this->db->get('cat_artinstruction')->result_array();
		$print_ad_types = $this->db->get('print_ad_types')->result_array();
		$data['adtype'] = $adtype;
		$data['artinst'] = $artinst;
		$data['print_ad_types'] = $print_ad_types;
		if($hd!=''){
			$data['hd'] = $hd;
			if($publication!='' && $adrep!=''){
				$data['adrep'] = $adrep;
				$data['publication'] = $publication;
				$pub_details = $this->db->get_where('publications',array('id' => $publication))->result_array();
				if($pub_details){ $data['publication_details'] = $pub_details; }else{ echo'<script>alert("publication Details Unknown")</script>'; }
				$adrep_details = $this->db->get_where('adreps',array('id' => $adrep))->result_array();
				if($adrep_details){ $data['adrep_details'] = $adrep_details; }else{ echo'<script>alert("Adrep Details Unknown")</script>'; }
				$data['order_id'] = $order_id;
			}
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('new_csr/cat_new', $data); 
		}else{
				if(isset($_POST['Submit']))
				{
					
					
					if(isset($_POST['artinst'])) $artinstruction = $_POST['artinst']; else $artinstruction = '0';
					$adtype = $_POST['adtype'];
					if($hd=='web'){
						$pixel_size = $_POST['pixel_size'];
						if($pixel_size == 'custom'){
							$w = $_POST['custom_width'];
							$h = $_POST['custom_height'];
						}else{
							$pix_size = $this->db->query("SELECT * from `pixel_sizes` WHERE `id`='$pixel_size'")->result_array();
							$w = $pix_size[0]['width'];
							$h = $pix_size[0]['height'];
						}
					}else{
						$w = $_POST['width'];
						$h = $_POST['height'];
					}
					$size = $w * $h;
					if($size == '0')
					{
						$this->session->set_flashdata("message","Provide Proper values for Width and Height!!!");
						redirect('new_csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep);
					}
						
					$category = $this->cat_calc($adtype); //cat_calc()
					
				    //assign order to team 24 may 2022
				/*
				   	$adwit_teams_id = '';
					$assign_order = $this->db->query("SELECT * FROM `assign_order` WHERE assign_order.category = '$category'")->row_array();
					if(isset($assign_order['category'])){
					    $adwit_teams_id = $assign_order['adwit_teams_id'];    //get the current team id and use in cat_result table
					    //update adwit_teams_id increment to next id
					    $last_adwit_teams_id = $this->db->query("SELECT `adwit_teams_id` FROM `adwit_teams` ORDER BY `adwit_teams_id` DESC LIMIT 1;")->row_array();
					    if($assign_order['adwit_teams_id'] == $last_adwit_teams_id['adwit_teams_id']){
					        $next_adwit_teams_id = 1;   //assign to team 1  
					    }else{
					        $next_adwit_teams_id = $assign_order['adwit_teams_id'] + 1;
					    }
					    
					    $update_team_id = array('adwit_teams_id' => $next_adwit_teams_id);
						$this->db->where('assign_order_id ', $assign_order['assign_order_id']);
						$this->db->update('assign_order', $update_team_id);
					}
				*/
					//assign order to team 24 may 2022
					
					$_POST['job_name'] = preg_replace('/[^A-Za-z0-9\s]/','',$_POST['job_name']);	//replace special char
					//$_POST['job_name'] = preg_replace('!\s+!', ' ', $_POST['job_name']); //remove additional spaces
					
				/*	$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
					if($orders){
						$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
						redirect('new_csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep);
					}else{*/
						if(empty($_POST['rush'])){ $_POST['rush']='0'; }
						//publish date
							$next_day =  date('D', strtotime(' +1 day'));
							if($next_day == 'Sat' || $next_day == 'Sun'){
								$publish_date = date('Y-m-d', strtotime('next monday'));
							}else{
								$publish_date = date('Y-m-d', strtotime(' +1 day'));
							}
						
						$pub_details = $this->db->get_where('publications',array('id' => $publication))->result_array();
						$help_desk = $pub_details[0]['help_desk'];
						if($hd=='web'){ 
						$help_desk = $pub_details[0]['help_desk'];
							$post = array(
								'adrep_id' => $adrep,
								'csr' => $this->session->userdata('sId'), 
								'publication_id' => $publication,
								'group_id' => $pub_details[0]['group_id'],
								'help_desk' => $help_desk,
								'order_type_id' => '1', 	//web ad
								'advertiser_name' => $_POST['advertiser'],
								'job_no' => $_POST['job_name'],
								'copy_content_description' => $_POST['copy_content_description'],
								'pixel_size' => $pixel_size,
								'ad_format' => $_POST['ad_format'],
								'maxium_file_size' => $_POST['maxium_file_size'],
								'web_ad_type' => $_POST['web_ad_type'],
								'activity_time' => date('Y-m-d h:i:s'),
								'rush' => $_POST['rush'],
								'publish_date' => $publish_date,
								'club_id'=> $pub_details[0]['club_id'],
								);
							if($pixel_size == 'custom'){
								$post['custom_width'] = $w;
								$post['custom_height'] = $h;
							}
							if(isset($_POST['pickup_adno']) && !empty($_POST['pickup_adno'])){
								$post['pickup_adno'] = $_POST['pickup_adno'];
							}
						}else{
							$post = array(
								'adrep_id' => $adrep,
								'csr' => $this->session->userdata('sId'), 
								'publication_id' => $publication,
								'group_id' => $pub_details[0]['group_id'],
								'help_desk' => $help_desk,
								'order_type_id' => '2', 	//print ad
								'advertiser_name' => $_POST['advertiser'],
								'job_no' => $_POST['job_name'],
								'copy_content_description' => $_POST['copy_content_description'],
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								'print_ad_type' => $_POST['print_ad_type'],
								'activity_time' => date('Y-m-d h:i:s'),
								'rush' => $_POST['rush'],
								'publish_date' => $publish_date,
								'club_id'=> $pub_details[0]['club_id'],
								);
							if(isset($_POST['pickup_adno']) && !empty($_POST['pickup_adno'])){
								$post['pickup_adno'] = $_POST['pickup_adno'];
							}
						}
						$this->db->insert('orders',$post);	
						$order_no = $this->db->insert_id();

						if($order_no)
						{
							//Live_tracker updation
							$tracker_data = array(
								'pub_id'=> $pub_details[0]['id'],
								'order_id'=> $order_no,
								'job_no' => $_POST['job_name'],
								'club_id'=> $pub_details[0]['club_id'],
								'status' => '1'
							);
							$this->db->insert('live_orders', $tracker_data);
							
							$this->orders_folder($order_no, $help_desk);	// folder creation, html_form
							if (!empty($_FILES['ufile']['tmp_name'][0]) || !empty($_FILES['ufile']['tmp_name'][1]))
							{
								$data = array();	//file data sent to file_upload function
								for($i=0;$i<10;$i++)	
								{
									if (!empty($_FILES['ufile']['tmp_name'][$i]))
									{
										$data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
										$data['fname'.$i] = $_FILES['ufile']['name'][$i];
									}
								}
								$data['id'] = $order_no;
								$this->file_upload($data); //file uploads
							}
							$help_desk = $pub_details[0]['help_desk']; 
							$news_id = $pub_details[0]['news_id'];
							$initial = $pub_details[0]['initial'];
							$slug_type = $pub_details[0]['slug_type'];
							$team = $pub_details[0]['design_team_id'];
						
							
						
							$dataa = array(
									'order_no' => $order_no,
									'job_name' => $_POST['job_name'],
									'adrep' => $adrep,
									'advertiser' => $_POST['advertiser'], 
									'width' => $w,
									'height' => $h,
									'artinstruction' => $artinstruction,
									'adtypewt' => $_POST['adtype'],
									'help_desk' => $help_desk,
									'publication_id' => $publication,
									'news_id' => $news_id,
									'news_initial' => $initial,
									'team' => $team,
									'slug_type' => $slug_type,
									'category' => $category,
									'csr' => $this->session->userdata('sId'),
									'date' => Date("Ymd"),
									'time' => date("His"),
									//'adwit_teams_id' => $adwit_teams_id
									);
							$this->db->insert('cat_result',$dataa);	
							$cat_id = $this->db->insert_id();
							
							$data2 = array(
										'order_no' => $order_no,
										'csr' => $this->session->userdata('sId'),
										'news_id' => $news_id,
										'publication_id'  => $publication,
										'help_desk'  => $help_desk,
										'date' => Date("Ymd"),
										'time' => date("His"),
										'category' => $category,
										);
							$this->db->insert('cshift',$data2);
							$status = 'v1';
						
							if($cat_id)
							{
								//order status
								$post_status = array('status' => '2');
								$this->db->where('id', $order_no);
								$this->db->update('orders', $post_status);
								
								//Live_tracker Updation
								$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
								if(isset($update_order['id'])){
									$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
									$this->db->where('id', $update_order['id']);
									$this->db->update('live_orders', $tracker_data);
								}
								
								
								$this->session->set_flashdata("message","Order No: ".$order_no." Submitted!!");
								redirect('new_csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep);
							}else{ 
								$this->session->set_flashdata("message","Order not categorised Try Again.. Had some problem with database..!!!");
								redirect('new_csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep); 
							}
						}else{
							$this->session->set_flashdata("message","Internal Error!! Order not placed.. Try again..");
							redirect('new_csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep);
						}
					//}		
				}
		}
	}
	
	public function multiple_orders($hd='', $publication='', $adrep='', $order_id='')
	{
		$pub_details = $this->db->get_where('publications',array('id' => $publication))->result_array();
		if($pub_details){ $data['publication_details'] = $pub_details; }
		$adrep_details = $this->db->get_where('adreps',array('id' => $adrep))->result_array();
		if($adrep_details){ $data['adrep_details'] = $adrep_details; }
			if(!empty($_FILES['upload_multiple']['name']))	
			{
			    $path_parts = pathinfo($_FILES["upload_multiple"]["name"]);
                $extension = $path_parts['extension'];
                if($extension != 'xlsx'){
                   $this->session->set_flashdata('message','Upload xlsx File.. Try Again..!!');
					redirect('new_csr/home/multiple_orders/'.$hd.'/'.$publication.'/'.$adrep);  
                }
				$dir = 'assets/xlsx_files/'.$adrep;
				if (@mkdir($dir,0777)){}
				$tempFile = $_FILES['upload_multiple']['tmp_name'];
				$fileName = $_FILES['upload_multiple']['name'];
				if(!move_uploaded_file($tempFile, $dir.'/'.$fileName)){
					$this->session->set_flashdata('message','Error Uploading File.. Try Again..!!');
					redirect('new_csr/home/multiple_orders/'.$hd.'/'.$publication.'/'.$adrep); 
				}else{
					redirect('new_csr/home/testexcel/'.$hd.'/'.$publication.'/'.$adrep);
				}
					
			}		
		$this->load->view('new_csr/multiple_orders',$data);
	}
	
	
	public function testexcel($hd='', $publication='', $adrep='', $order_id='')
    {
		$data['hi'] = '';
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
		$this->form_validation->set_rules('order_no', 'Order Number', 'trim');
		if($hd=="web"){
			$this->form_validation->set_rules('pixel_size', 'Pixel Size', 'trim|required');
			$this->form_validation->set_rules('custom_width', 'Custom Width', 'trim');
			$this->form_validation->set_rules('custom_height', 'Custom Height', 'trim');
			$this->form_validation->set_rules('maxium_file_size', 'maxium file size', 'trim|required');
			$this->form_validation->set_rules('web_ad_type', 'Web Ad Type', 'trim|required');
			$this->form_validation->set_rules('ad_format', 'Web Ad Format', 'trim|required');
		}else{
			$this->form_validation->set_rules('width', 'Width', 'trim|required');
			$this->form_validation->set_rules('height', 'Height', 'trim|required');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
		}
		$this->form_validation->set_rules('job_name', 'job_name', 'trim|required');
		$this->form_validation->set_rules('advertiser', 'Advertiser', 'trim|required');
		$this->form_validation->set_rules('adtype', 'Adtype', 'trim|required');
		$this->form_validation->set_rules('artinst', 'Artinst', 'trim|required');
		
		if(isset($_POST['Submit']))
		{
			$art = $_POST['artinst'];
			$adtype = $_POST['adtype'];
			if($hd=='web'){
				$pixel_size = $_POST['pixel_size'];
				if($pixel_size == 'custom'){
					$w = $_POST['custom_width'];
					$h = $_POST['custom_height'];
				}else{
					$pix_size = $this->db->query("SELECT * from `pixel_sizes` WHERE `id`='$pixel_size'")->result_array();
					$w = $pix_size[0]['width'];
					$h = $pix_size[0]['height'];
				}
			}else{
				$w = $_POST['width'];
				$h = $_POST['height'];
			}
			$size = $w * $h;
			if($size == '0')
			{
				$this->session->set_flashdata("message","Provide Proper values for Width and Height!!!");
				redirect('new_csr/home/testexcel/'.$hd.'/'.$publication.'/'.$adrep);
			}
				
			$category = $this->cat_calc($adtype); //cat_calc()
			
			$_POST['job_name'] = preg_replace('/[^A-Za-z0-9\s]/', ' ', $_POST['job_name']);	//replace special char
			
			$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
			if($orders){
				$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
				redirect('new_csr/home/testexcel/'.$hd.'/'.$publication.'/'.$adrep);
			}else{
				
				if(empty($_POST['rush'])){ $_POST['rush']='0'; }
				$pub_details = $this->db->get_where('publications',array('id' => $publication))->result_array();
				$help_desk = $pub_details[0]['help_desk'];
				
				if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				} else {
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				
				if($hd=='web'){ 
				$help_desk = $pub_details[0]['help_desk'];
					$post = array(
						'adrep_id' => $adrep,
						'csr' => $this->session->userdata('sId'), 
						'publication_id' => $publication,
						'group_id' => $pub_details[0]['group_id'],
						'help_desk' => $help_desk,
						'order_type_id' => '1', 	//web ad
						'advertiser_name' => $_POST['advertiser'],
						'job_no' => $_POST['job_name'],
						'copy_content_description' => $_POST['copy_content_description'],
						'pixel_size' => $pixel_size,
						'ad_format' => $_POST['ad_format'],
						'maxium_file_size' => $_POST['maxium_file_size'],
						'web_ad_type' => $_POST['web_ad_type'],
						'publish_date' => $publish_date,
						'club_id'=> $pub_details[0]['club_id'],
						//'rush' => $_POST['rush'],
						);
					if($pixel_size == 'custom'){
						$post['custom_width'] = $w;
						$post['custom_height'] = $h;
					}
					if(isset($_POST['pickup_adno']) && !empty($_POST['pickup_adno'])){
						$post['pickup_adno'] = $_POST['pickup_adno'];
					}
				}else{ 
					$post = array(
						'adrep_id' => $adrep,
						'csr' => $this->session->userdata('sId'), 
						'publication_id' => $publication,
						'group_id' => $pub_details[0]['group_id'],
						'help_desk' => $help_desk,
						'order_type_id' => '2', 	//print ad
						'advertiser_name' => $_POST['advertiser'],
						'job_no' => $_POST['job_name'],
						'copy_content_description' => $_POST['copy_content_description'],
						'width' => $_POST['width'],
						'height' => $_POST['height'],
						'print_ad_type' => $_POST['print_ad_type'],
						'publish_date' => $publish_date,
						'club_id'=> $pub_details[0]['club_id'],
						//'rush' => $_POST['rush'],
						);
					if(isset($_POST['pickup_adno']) && !empty($_POST['pickup_adno'])){
						$post['pickup_adno'] = $_POST['pickup_adno'];
					}
				}
				$this->db->insert('orders',$post);	
				$order_no = $this->db->insert_id();	
				
				
				
				if($order_no)
				{
					//Live_tracker updation
					$tracker_data = array(
						'pub_id'=> $pub_details[0]['id'],
						'order_id'=> $order_no,
						'job_no' => $_POST['job_name'],
						'club_id'=> $pub_details[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
					$this->orders_folder($order_no);	// folder creation, html_form
					if (!empty($_FILES['ufile']['tmp_name'][0]))
					{
						$data = array();	//file data sent to file_upload function
						for($i=0;$i<2;$i++)	
						{
							if (!empty($_FILES['ufile']['tmp_name'][$i]))
							{
								$data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
								$data['fname'.$i] = $_FILES['ufile']['name'][$i];
							}
						}
						$data['id'] = $order_no;
						$this->file_upload($data); //file uploads
					}
					$help_desk = $pub_details[0]['help_desk']; 
					$news_id = $pub_details[0]['news_id'];
					$initial = $pub_details[0]['initial'];
					$slug_type = $pub_details[0]['slug_type'];
					$team = $pub_details[0]['design_team_id'];
				
					
				
					$dataa = array(
							'order_no' => $order_no,
							'job_name' => $_POST['job_name'],
							'adrep' => $adrep,
							'advertiser' => $_POST['advertiser'], 
							'width' => $w,
							'height' => $h,
							'artinstruction' => $_POST['artinst'],
							'adtypewt' => $_POST['adtype'],
							'help_desk' => $help_desk,
							'publication_id' => $publication,
							'news_id' => $news_id,
							'news_initial' => $initial,
							'team' => $team,
							'slug_type' => $slug_type,
							'category' => $category,
							'csr' => $this->session->userdata('sId'),
							'date' => Date("Ymd"),
							'time' => date("His")
							);
					$this->db->insert('cat_result',$dataa);	
					$cat_id = $this->db->insert_id();
				 
					$data2 = array(
								'order_no' => $order_no,
								'csr' => $this->session->userdata('sId'),
								'news_id' => $news_id,
								'publication_id'  => $publication,
								'help_desk'  => $help_desk,
								'date' => Date("Ymd"),
								'time' => date("His"),
								'category' => $category,
								);
					$this->db->insert('cshift',$data2);
					$status = 'v1';
				
					if($cat_id)
					{
						//order status
						$post_status = array('status' => '2');
						$this->db->where('id', $order_no);
						$this->db->update('orders', $post_status);
						
						
						//Live_tracker Updation
						$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
						if(isset($update_order['id'])){
							$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
							$this->db->where('id', $update_order['id']);
							$this->db->update('live_orders', $tracker_data);
						}
						
						$this->session->set_flashdata("message","Order No: ".$order_no." Submitted!!");
						redirect('new_csr/home/testexcel/'.$hd.'/'.$publication.'/'.$adrep);
					}else{ 
						$this->session->set_flashdata("message","Order not categorised Try Again.. Had some problem with database..!!!");
						redirect('new_csr/home/testexcel/'.$hd.'/'.$publication.'/'.$adrep); 
					}
				}else{
					$this->session->set_flashdata("message","Internal Error!! Order not placed.. Try again..");
					redirect('new_csr/home/testexcel/'.$hd.'/'.$publication.'/'.$adrep);
				}
			}		
		}
		$adtype = $this->db->get('cat_new_adtype')->result_array();
		$artinst = $this->db->get('cat_artinstruction')->result_array();
		$data['adtype'] = $adtype;
		$data['artinst'] = $artinst;
		$data['adrep'] = $adrep;
		$pub_details = $this->db->get_where('publications',array('id' => $publication))->result_array();
		if($pub_details){ $data['publication_details'] = $pub_details; }
		$adrep_details = $this->db->get_where('adreps',array('id' => $adrep))->result_array();
		if($adrep_details){ $data['adrep_details'] = $adrep_details; }
        
		$this->load->view('new_csr/testexcel',$data);
                
    }
	
	function import()
	{
	    $this->load->library('excel');
	
			$path = 'assets/xlsx_files/36/Set toma 1.xlsx';
			if(file_exists($path)){ echo'file_exists'; }
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$customer_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$address = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$city = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$postal_code = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$country = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$data[] = array(
						'CustomerName'		=>	$customer_name,
						'Address'			=>	$address,
						'City'				=>	$city,
						'PostalCode'		=>	$postal_code,
						'Country'			=>	$country
					);
				}
				var_dump($data);
			}
			//$this->excel_import_model->insert($data);
			echo 'Data Imported successfully';
		
	}
	
	public function incoming_tool() 
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_chk']))
		{
			$order_no = $_POST['order_chk'];
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE `id` = '$order_no' OR `job_no` = '$order_no'")->result_array();
			if($orders){ $data['orders'] = $orders; }
			else{
				$this->session->set_flashdata("message","No Orders Found for $order_no");
				redirect('new_csr/home/incoming_tool');}
		}
		$this->load->view('new_csr/incoming_tool',$data);
	}
	
    public function rev_orders($order='')
	{
		if(isset($_POST["submit"]) && !empty($_POST['order_id']))
		{
			$data['hi'] = 'hello';
			$version = 'V1a'; $file_path = 'none';
			$orders = $this->db->get_where('orders',array('id' => $_POST['order_id']))->result_array();//adrep details
			if(!$orders){
				$this->session->set_flashdata("message","Revision not placed.. Incomplete Adrep Details for order: ".$_POST['order_id']);
				redirect('new_csr/home/incoming_tool');
			}
			//order activity time
			$post_status = array('activity_time' => date('Y-m-d h:i:s'));
			$this->db->where('id', $_POST['order_id']);
			$this->db->update('orders', $post_status);
			$oid = $_POST['order_id'];
			$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$oid' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			if(isset($orders_rev[0]['id']) && $orders_rev[0]['new_slug']=='none'){ 
				$this->session->set_flashdata("message","Revision not Allowed for order: ".$_POST['order_id']);
				redirect('new_csr/home/orderview/'.$orders_rev[0]['help_desk'].'/'.$oid); 
			}
			if($orders_rev){
				$version = $orders_rev[0]['version'];
				if($version == 'V1'){ $version = 'V1a'; }
				elseif($version == 'V1a'){ $version = 'V1b'; }
				elseif($version == 'V1b'){ $version = 'V1c'; }
				elseif($version == 'V1c'){ $version = 'V1d'; }
				elseif($version == 'V1d'){ $version = 'V1e'; }
				elseif($version == 'V1e'){ $version = 'V1f'; }
				elseif($version == 'V1f'){ $version = 'V1g'; }
				elseif($version == 'V1g'){ $version = 'V1h'; }
				elseif($version == 'V1h'){ $version = 'V1i'; }
				elseif($version == 'V1i'){ $version = 'V1j'; }
				elseif($version == 'V1j'){ $version = 'V1k'; }
				elseif($version == 'V1k'){ $version = 'V1l'; }
				elseif($version == 'V1l'){ $version = 'V1m'; }
				elseif($version == 'V1m'){ $version = 'V1n'; }
				elseif($version == 'V1n'){ $version = 'V1o'; }
				elseif($version == 'V1o'){ $version = 'V1p'; }
				elseif($version == 'V1p'){ $version = 'V1q'; }
				elseif($version == 'V1q'){ $version = 'V1r'; }
				elseif($version == 'V1r'){ $version = 'V1s'; }
				elseif($version == 'V1s'){ $version = 'V1t'; }
				elseif($version == 'V1t'){ $version = 'V1u'; }
				elseif($version == 'V1u'){ $version = 'V1v'; }
				elseif($version == 'V1v'){ $version = 'V1w'; }
				elseif($version == 'V1w'){ $version = 'V1x'; }
				elseif($version == 'V1x'){ $version = 'V1y'; }
				elseif($version == 'V1y'){ $version = 'V1z'; }
			}
			if (!empty($_FILES['ufile']['tmp_name'][0])){	//file upload to revision_downloads
				$dir = "revision_downloads/".$_POST["job_slug"];
				$file_path = $dir;
			    if (@mkdir($dir,0777))
				{

				}
				$path1= $dir.'/'.$_FILES['ufile']['name'][0];
				$path2= $dir.'/'.$_FILES['ufile']['name'][1];
								
				if(!copy($_FILES['ufile']['tmp_name'][0], $path1))
				{
					$this->session->set_flashdata("message2","error uploading file : ". $_FILES['ufile']['tmp_name'][0]);
					redirect('new_csr/home/rev_orders/'.$_POST['order_id']);
				}
					
				if (!empty($_FILES['ufile']['tmp_name'][1]))
				{
					if(!copy($_FILES['ufile']['tmp_name'][1], $path2)){
						$this->session->set_flashdata("message2","error uploading file : ". $_FILES['ufile']['tmp_name'][1]);
						redirect('new_csr/home/rev_orders/'.$_POST['order_id']);
					}
				}
			}			
			$client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			//rev_sold_jobs
			$tday = date('Y-m-d');
			$time = date("H:i:s");
			if(!empty($_POST['copy_content_description'])){
				$note = $_POST['copy_content_description'];
			}else{ $note = 'none'; }
			if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; }
			$reason_id = $_POST['reason_option'];
			$post = array(
							'order_id' => $_POST['order_id'],
							'order_no' => $_POST['job_slug'],
							'c_create' => $this->session->userdata('sId'),
							'adrep' => $orders[0]['adrep_id'],
							'help_desk' => $publication[0]['help_desk'],
							'date' => $tday,
							'time' => $time,
							'category' => 'revision',
							'version' => $version,
							'note' => $note,
							'rush' => $rush,
							'file_path' => $file_path,
							'job_accept' => '1',
							'status' => '2',
							'classification' => $reason_id
							);
			$this->db->insert('rev_sold_jobs', $post); 
			$rev_id = $this->db->insert_id();
			
			if($rev_id)	
			{
			    //update rev status in orders table(new 21 Apr 2022)
			    $rev_count = $orders[0]['rev_count'];
				if(empty($rev_count)){ $rev_count = 0; }
				$order_rev_status_upadate = array(
                        					    'rev_count' => $rev_count + 1, 
                        					    'rev_id' => $rev_id,
                        					    'rev_order_status' => '2', //Revision Accepted
                        					    'activity_time' => date('Y-m-d h:i:s'),
                        					);
				$this->db->where('id', $_POST['order_id']);
				$this->db->update('orders', $order_rev_status_upadate);
					
				//Live_tracker Revision updation
				$tracker_data = array(
					'pub_id'=> $publication[0]['id'],
					'order_id' => $_POST['order_id'],
					'revision_id'=> $rev_id,
					'status' => '2'
				);
				$this->db->insert('live_revisions', $tracker_data);
				
				//new content yes or no for design_challenge and extensive
			/*	if(isset($_POST['new_content']) && !empty($_POST['new_content'])){
				   $add_col = array('rev_id' => $rev_id, 'rev_classification' => $reason_id, 'yes_or_no' => $_POST['new_content']); 
				   $this->db->insert('rev_classification_new_content', $add_col);
				}*/
				
				$revision = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
				//Revision details of the order
				$order_details = $this->db->get_where('orders',array('id' => $oid))->result_array();
				//send mail
				$data['order'] = $order_details[0];  
				$data['client'] = $client[0];
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				$data['design_team'] = $design_team[0];
				$data['rev_note'] = $revision[0];
				
					$dataa['from'] = $design_team[0]['email_id'];
					$dataa['from_display'] = 'Design Team';
					//Client
					$dataa['replyTo'] = $client[0]['email_id'];
					$dataa['replyTo_display'] = 'Adrep';
					$dataa['subject'] = 'AdwitAds Revision #'.$revision[0]['order_no'];
					$dataa['body'] = $this->load->view('revad_placed_notification_emailer',$data, TRUE);
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$this->rev_jobs_mail($dataa);
			}else{ 
				$this->session->set_flashdata("message2","Internal Error: Order could not be placed!");
				redirect('new_csr/home/rev_orders/'.$_POST['order_id']); 
			}
			
			if(isset($_POST['redesign']) && !empty($_POST['redesign']))	//redesign
			{
				$post2 = array( 'order_id' => $_POST['order_id'], 'rev_sold_id' => $rev_id );
				$this->db->insert('redesign_nj', $post2);
			}
			$this->session->set_flashdata("message","Revision Submitted!!");
			redirect('new_csr/home/frontlinetrack_order_list/'.$publication[0]['help_desk']);
			
		}elseif($order!=''){
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order))->result_array();
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $order))->result_array();
			if($orders_rev)
			{
				foreach($orders_rev as $row){ 
					$slug = $row['new_slug']; 
				}
			}elseif($cat_result && $cat_result[0]['slug']!='none'){
				$slug = $cat_result[0]['slug'];
			} 
			 if($slug!='none'){ 
				$data['order'] = $order;
				$data['cat_result'] = $cat_result[0];
				$data['slug'] = $slug;
				$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
				$this->load->view('new_csr/rev_orders', $data);
			}else{
				echo "<script>alert('Revision not yet allowed to this Order.!!')</script>";
				$this->index();
			} 
		}
	} 
	
	
	public function pickup($hd='')
	{
		$data['hd'] = $hd;
		if(isset($_POST['order_Search']) && !empty($_POST['order_id']))
		{
			$order = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
												FROM `orders` WHERE `id` = '".$_POST['order_id']."'")->result_array();
			if($order){
				$order_id = $order[0]['id'];
				$publication = $order[0]['publication_id'];
				$adrep = $order[0]['adrep_id'];
				redirect('new_csr/home/new_cat/'.$hd.'/'.$publication.'/'.$adrep.'/'.$order_id);
			}else{
				$this->session->set_flashdata("message","Order Not Found!!");
				redirect('new_csr/home/new_cat/'.$hd);
			}
		}
	}
	
	public function cat_calc($adtype)
	{
	    if($adtype == '1'){
			$category = "P";
		}elseif($adtype == '2'){
		    $category = "M";
		}elseif($adtype == '3'){
		    $category = "N";
		}elseif($adtype == '4'){
		    $category = "T";
		}elseif($adtype == '5'){
		    $category = "W";
		}elseif($adtype == '6'){
		    $category = "G";
		}
		
		return $category;
	}
	
	public function softwrite_orders()
	{
		if(isset($_POST['Submit']) && isset($_POST['id']))
		{
			redirect('new_csr/home/softwrite_orders_submit/'.$_POST['id']);
		}else{
			
			
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['softwrite_orders'] = $this->db->query("Select * from `soft_orders` where `approve`='0' AND `timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->result_array();
			}else{
				$today = date('Y-m-d');
				$pday = date('Y-m-d', strtotime(' -30 day'));
				$data['softwrite_orders'] = $this->db->query("Select * from `soft_orders` where `approve`='0' AND `timestamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
			}
			$this->load->view('new_csr/softwrite_orders', $data);
		}
	}
	
	public function softwrite_orders_submit($id='')
	{
		if(isset($_POST['order_submit']) && isset($_POST['id']))
		{
			
					
			$art = $_POST['artinst'];
			$adtype = $_POST['adtype'];
						
			$size = $_POST['width'] * $_POST['height'];
			if($size == '0')
			{
				$this->session->set_flashdata("message","Provide Proper values for Width and Height!!!");
				redirect('new_csr/home/softwrite_orders_submit/'.$_POST['id']);
			}
			$category = $this->cat_calc($adtype);	
						
			$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
			if($orders){
				$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
				redirect('new_csr/home/softwrite_orders');
			}else{
				$adrep = $this->db->get_where('adreps',array('id' => $_POST['job_name']))->result_array();
				$pub_details = $this->db->get_where('publications',array('id' => $_POST['publication_id']))->result_array();
				
				if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				} else {
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				
				//orders table
				$post = array(
								'adrep_id' => $_POST['adrep_id'],
								'csr' => $this->session->userdata('sId'),
								'publication_id' => $_POST['publication_id'],
								'group_id' => $pub_details[0]['group_id'],
								'help_desk' => $pub_details[0]['help_desk'],
								'order_type_id' => '2', 
								'advertiser_name' => $_POST['advertiser'],
								'job_no' => $_POST['job_name'],
								'copy_content_description' => $_POST['copy_content_description'],
								'notes' => $_POST['notes'],
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								'print_ad_type' => $_POST['color'],
								'publish_date' => $publish_date,
								'club_id'=> $pub_details[0]['club_id'],
							);
				$this->db->insert('orders',$post);	
				$order_no = $this->db->insert_id();	
				
				//cat_result table
				if($order_no)
				{
					//Live_tracker updation
					$tracker_data = array(
						'pub_id'=> $pub_details[0]['id'],
						'order_id'=> $order_no,
						'job_no' => $_POST['job_name'],
						'club_id'=> $pub_details[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
					$post = array('approve' => '1');
					$this->db->where('id', $_POST['id']);
					$this->db->update('soft_orders', $post);
					
					$data = array();
					for($i=0;$i<5;$i++)	//file data sent to create_folder function
					{
						if (!empty($_FILES['ufile']['tmp_name'][$i]))
						{
							$data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
							$data['fname'.$i] = $_FILES['ufile']['name'][$i];
						}
					}
					//new
					$this->orders_folder($order_no);// folder, html_form
					$data['id'] = $order_no;
					$this->file_upload($data); //file uploads
					//$pub_details = $this->db->get_where('publications',array('id' => $_POST['publication_id']))->result_array();
						$help_desk = $pub_details[0]['help_desk'];
						$news_id = $pub_details[0]['news_id'];
						$initial = $pub_details[0]['initial'];
						$slug_type = $pub_details[0]['slug_type'];
						$team = $pub_details[0]['design_team_id'];
					$dataa = array(
								'order_no' => $order_no,
								'job_name' => $_POST['job_name'],
								'adrep' => $_POST['adrep_id'],
								'advertiser' => $_POST['advertiser'], 
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								'artinstruction' => $_POST['artinst'],
								'adtypewt' => $_POST['adtype'],
								'help_desk' => $help_desk,
								'publication_id' => $_POST['publication_id'],
								'news_id' => $news_id,
								'news_initial' => $initial,
								'team' => $team,
								'slug_type' => $slug_type,
								'category' => $category,
								'csr' => $this->session->userdata('sId'),
								'date' => Date("Ymd"),
								'time' => date("His")
								);
					$this->db->insert('cat_result',$dataa);	
					$cat_id = $this->db->insert_id();
					
					//softwrite attachments
					//if($this->session->userdata('sId')=='25'){
						$path = '../softwritetechnologies.com/login/forms/'.$_POST['id'] ;
						$fpost = array('order_no' => $order_no, 'path' => $path);
						$this->db->insert('soft_attachments', $fpost);
					//}
					if($cat_id)
					{
						//order status
						$post_status = array('status' => '2');
						$this->db->where('id', $order_no);
						$this->db->update('orders', $post_status);
						
						//Live_tracker Updation
						$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
						if(isset($update_order['id'])){
							$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
							$this->db->where('id', $update_order['id']);
							$this->db->update('live_orders', $tracker_data);
						}
						
						$data2 = array(
									'order_no' => $order_no,
									'csr' => $this->session->userdata('sId'),
									'news_id' => $news_id,
									'publication_id'  => $_POST['publication_id'],
									'help_desk'  => $help_desk,
									'date' => Date("Ymd"),
									'time' => date("His"),
									'category' => $category
									);
						$this->db->insert('cshift',$data2);
					}else{ 
						$this->session->set_flashdata("message","Order not been categorised!!!");
						redirect('new_csr/home/softwrite_orders'); 
					}
				}else{
					$this->session->set_flashdata("message","Order not Placed.. Try again!!!");
					redirect('new_csr/home/softwrite_orders');
				}
				$this->session->set_flashdata("message","Order Placed and Categorised Sucessfully!!!<br/>Order No: $order_no<br/>Category: $category");
				redirect('new_csr/home/softwrite_orders');
			}	
		}elseif($id!=''){
			$softwrite_orders = $this->db->get_where('soft_orders',array('id' => $id))->result_array();
			$data['soft_users'] = $this->db->get_where('soft_users',array('id' => $softwrite_orders[0]['user']))->result_array();
			$data['soft_publications'] = $this->db->get_where('soft_publications',array('id' => $softwrite_orders[0]['publication']))->result_array();
			$data['softwrite_orders'] = $softwrite_orders;
			$this->load->view('new_csr/softwrite_submit', $data);
		}
	}
		
	public function orders_folder($id = '', $hd = '') //new
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();

		if(isset($order[0]['id']))
		{
			if($order[0]['publish_date']!='0000-00-00')$order[0]['publish_date'] = date("d-m-Y", strtotime($order[0]['publish_date']));	

			if($order[0]['date_needed']!='0000-00-00')$order[0]['date_needed'] = date("d-m-Y", strtotime($order[0]['date_needed']));	

			$order_type = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();//print, web, print-web	

			$ad_type = $this->db->get_where('ads_type',array('id' => $order[0]['spec_sold_ad']))->result_array();//new, resize,pickup
			
			$client = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array();

            $publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
				
			$data = array();
			
			$data['client'] = $client[0];

			$data['order_type'] = $order_type[0];

			$data['ad_type'] = $ad_type[0];
			
			$data['order'] = $order[0];

			$data['publications'] = $publication[0];
			
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $order[0]['job_no']);
			
			//path specification
			
			$dir4="downloads/".$id.'-'.$jname;

			if (@mkdir($dir4,0777))
			{

			}
			//to store the form
			if($hd != '2'){
				$myFile = $dir4."/".$jname.".html";
				//if(fopen($myFile)){ if (file_exists("C:/xampplite/htdocs/site/upload/" . $_FILES["file"]["name"]))
					$fh = fopen($myFile, 'w') or die("can't open file");
				//}else{}
				$stringData = $this->load->view('e-order',$data, TRUE);
				fwrite($fh, $stringData);
				fclose($fh);
			}
			//save path in orders table
			$post = array('file_path' => $dir4);
				$this->db->where('id', $id);
				$this->db->update('orders', $post);
		}	
	}
	
	public function file_upload($data) //new
	{
		if(isset($data['id']))
		{
			$order = $this->db->get_where('orders',array('id' => $data['id']))->result_array();
			if($order && $order[0]['file_path']!='none')
			{
				$dir4 = $order[0]['file_path'];
				//file upload
				for($i=0;$i<5;$i++)
				{
					if(isset($data['temp'.$i]) && isset($data['fname'.$i]))
					{
						$path= $dir4.'/'.$data['fname'.$i];
						if(!copy($data['temp'.$i], $path))
						{
							$this->session->set_flashdata("message","Error: ".$data['fname'.$i]." Upload Failed!");
							redirect('new_csr/home');
						}
					}
				}
				
				if(isset($data['attachfile_count'])){
					for($i=0;$i<$data['attachfile_count'];$i++)
					{
						$attachfname = basename($data['attachfile'.$i]);
						$path= $dir4.'/'.$attachfname;
						if(file_exists($path)){
							$ext = pathinfo($attachfname, PATHINFO_EXTENSION);
							$filename = basename($attachfname, $ext);
							$old = $path;
							$new = $dir4.'/'.$filename.'_01.'.$ext;
							rename($old , $new);
						}
						if(!copy($data['attachfile'.$i], $path))
						{
							$this->session->set_flashdata("message","Error: ".$data['attachfile'.$i]." Upload Failed!");
							redirect('csr/home');
						}
					}
				}
			}
			
		}
	}

	public function delay_msg($hd='', $order_id='')
	{
		if($order_id!=''){
			$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
			if(!$order){
				$this->session->set_flashdata("message","Order Details Not Found!!");
				redirect('new_csr/home/cshift/'.$hd);
			}
			if(isset($_POST['submit'])){
				$client = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array();
				//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				//$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				
				$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select design_teams.id, design_teams.email_id from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
					$dataa['from'] = $design_team[0]['email_id'];
					
					$dataa['from_display'] = 'Design Team';

					$dataa['replyTo'] = $design_team[0]['email_id'];

					$dataa['replyTo_display'] = 'Design Team';

					$dataa['subject'] = 'Delay of Unique Ad No :'.$_POST['job_name'] ;
					
					$_POST['msg'] = str_replace(PHP_EOL,'<br/>', $_POST['msg']);
					$dataa['msg'] = $_POST['msg'];
					//Client
					$dataa['recipient'] = $client[0]['email_id'];
					//$dataa['recipient'] = 'webmaster@adwitglobal.com';
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$dataa['client'] = $client[0];
					$dataa['order'] = $order[0];
					$this->question_mail($dataa); 
				redirect('new_csr/home/cshift/'.$hd);
			}
			$data['order'] = $order[0];
			$this->load->view('new_csr/delay_msg', $data);
		}
	}
	
	public function my_profile()
	{
		$data['csr_name'] = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
		$this->load->view('new_csr/my_profile', $data);
	}	
		
	
	public function help()
	{
		$data['csr_name'] = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
		$this->load->view('new_csr/help', $data);
	}	
	
	public function lock()
	{
	    $data['hi']="hi";
	    if(!empty($_POST['password']))
		 {
			 $check = $this->db->get_where('csr',array('password' =>md5($_POST['password']), 'email_id'=>($_POST['username']) , 'id' => $this->session->userdata('sId')))->result_array();
			 if($check==true)
			 {
				redirect('new_csr/home');
			 } else { $data['psd'] = "Wrong Password Please Try Again!!";}
		 }
		$this->load->view('new_csr/lock', $data);
	}
	
	public function rev_orderview($hd='',$order_id='')
	{
		if($hd != '' && $hd != '0' && $order_id != '')
		{
			$help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
			$data['help_desk']= $help_desk;
			$redirect = 'new_csr/home/rev_orderview/'.$hd.'/'.$order_id; $data['redirect']= $redirect;
			$data['order_id']= $order_id; 
			$data['hd']= $hd;
			$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE `id`= '$order_id' ")->result_array();
			$extensive_revision = $this->db->query("SELECT * FROM `extensive_revision` WHERE `order_id`= '$order_id' ")->result_array();
			if($extensive_revision){
				$data['extensive_revision'] = $extensive_revision;
			}
			$data['order_form'] = $orders[0]['file_path'];
			$rev_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			$data['rev_rev'] =  $rev_rev;
			if(!$orders){
				$this->session->set_flashdata("message", $order_id."Order: Details not Found..!!"); 
				redirect('new_csr/home/frontlinetrack_order_list/'.$hd);
			}
			
			if($orders[0]['order_type_id'] == '1'){ //multiple size web ads
    		    if($orders[0]['ad_format']=='5'){ //flexitive ad (flexitive size)
    		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, flexitive_size.ratio, flexitive_size.ratio AS name FROM `orders_multiple_size`
                    							                LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
                    							                    WHERE orders_multiple_size.order_id = '".$orders[0]['id']."'")->result_array();
    		    }else{ //pixel size
    		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, pixel_sizes.width, pixel_sizes.height, CONCAT(pixel_sizes.width,'x',pixel_sizes.height) AS name FROM `orders_multiple_size`
                    							            LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
                    							                WHERE orders_multiple_size.order_id = '".$orders[0]['id']."'")->result_array();
    		    }
    		    
    		    $orders_multiple_custom_size = $this->db->query("SELECT *, CONCAT(custom_width,'x',custom_height) AS name FROM `orders_multiple_custom_size` WHERE `order_id` = '".$orders[0]['id']."'")->result_array();
                
                if(isset($orders_multiple_size[0]['id'])){
                   $data['orders_multiple_size'] = $orders_multiple_size;
                }
                if(isset($orders_multiple_custom_size[0]['id'])){
                   $data['orders_multiple_custom_size'] = $orders_multiple_custom_size; 
                }
    		}
			/**************** Revision Cancel **********************************/
			if(isset($_POST['cancel_submit']))
			{
				$post = array(  'frontline_csr' => $this->session->userdata('sId'),
								'reason' => $_POST['reason'],
								'job_status' => '0',
								'cancel' => '1',
								'status' => '6'
								);
				$this->db->where('id', $_POST['rev_id']);
				$this->db->update('rev_sold_jobs', $post);
				
				//update rev status in orders table(new 21 Apr 2022)
				    $order_rev_status_upadate = array( 'rev_order_status' => '6' ); //Revision Cancelled
					$this->db->where('id', $order_id);
					$this->db->update('orders', $order_rev_status_upadate);
					
				//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
					if(isset($update_revision['id'])){
					    $this->db->query("DELETE FROM `live_revisions` WHERE `id`= '".$update_revision['id']."'");
						/*$tracker_data = array('status' => '6');
						$this->db->where('id', $update_revision['id']);
						$this->db->update('live_revisions', $tracker_data);*/
					}
				
			}
			/**************** Revision Accept **********************************/
			if(isset($_POST['accept']))	//accept
			{
				$reason_id = $_POST['reason_option'];
				if(isset($_POST['rush']) && !empty($_POST['rush'])) $rush = $_POST['rush']; else $rush = '0';
				$post = array( 'job_accept' => '1', 'csr' => $this->session->userdata('sId'), 'c_create' => $this->session->userdata('sId'), 'status' => '2', 'classification' => $reason_id, 'rush' => $rush );
				$this->db->where('id', $_POST['rev_id']);
				$this->db->update('rev_sold_jobs', $post);
				
				//update rev status in orders table(new 21 Apr 2022)
				    $order_rev_status_upadate = array( 'rev_order_status' => '2' ); //Revision Accepted
					$this->db->where('id', $order_id);
					$this->db->update('orders', $order_rev_status_upadate);
					
				//new content yes or no for design_challenge and extensive
			/*	if(isset($_POST['new_content']) && !empty($_POST['new_content'])){
				   $add_col = array('rev_id' => $_POST['rev_id'], 'rev_classification' => $reason_id, 'yes_or_no' => $_POST['new_content']); 
				   $this->db->insert('rev_classification_new_content', $add_col);
				}*/
					//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
					if(isset($update_revision['id'])){
						$tracker_data = array('status' => '2');
						$this->db->where('id', $update_revision['id']);
						$this->db->update('live_revisions', $tracker_data);
					}
				
				
				
				//map orders status update via cURL
				if(isset($rev_rev[0]['map_revorder_id']) && $rev_rev[0]['map_revorder_id'] != NULL && $rev_rev[0]['map_revorder_id'] != '0'){
					$fields = array(
									'status' => '2', 
									'map_revorder_id' => $rev_rev[0]['map_revorder_id'],
									'adwitads_rev_id' => $rev_rev[0]['id']
									);
					$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/revorder_status_update';
					$this->curl_post($url, $fields); //API using cURL 
				}
				if(isset($_POST['redesign']) && !empty($_POST['redesign']))	//redesign
				{
					$post2 = array( 'order_id' => $order_id, 'rev_sold_id' => $_POST['rev_id'] );
					$this->db->insert('redesign_nj', $post2);
				}
				redirect('new_csr/home/frontlinetrack_order_list/'.$hd);
			}
			/************************** Revision Back to designer **************/
			if(isset($_POST['rev_sent_designer']) && isset($_POST['msg']))	//Back to designer
	        {				
				$file_path = 'none';
				$rev_id = $_POST['rev_id'];
				$sourcefile = $_POST['sourcefile'];
				if(!empty($_FILES['file2']['name']))	
				{
					
						$dir2 = $sourcefile.'/csr_change_'.$rev_id; 
						if (@mkdir($dir2,0777)){}
						move_uploaded_file($_FILES['file2']['tmp_name'],$dir2.'/'.$_FILES['file2']['name']);
						$file_path = $dir2.'/'.$_FILES['file2']['name'];
					
				}	
				$time=date("Y:m:d H:i:s");
				if($_POST['msg'] == 'others'){				
				    $msg = $_POST['csr_msg'];				
				}else{ 					
				    $msg = $_POST['msg'].'-'.$_POST['csr_msg'];		
				}
				$data2 = array('revision_id'=> $rev_id , 'message'=>  $msg ,  'csr_id'=>$this->session->userdata('sId') , 'time'=>$time, 'file_path' => $file_path, 'operation' => 'revcsr_designer');
				$this->db->insert('production_conversation', $data2);
				
				$data1 = array('status'=> '7');
				$this->db->where('id', $rev_id); 
				$this->db->update('rev_sold_jobs', $data1);
				
				//update rev status in orders table(new 21 Apr 2022)
				    $order_rev_status_upadate = array( 'rev_order_status' => '7' ); //Revision Changes from CSR
					$this->db->where('id', $order_id);
					$this->db->update('orders', $order_rev_status_upadate);
					
				//Live_tracker Revision Updation
				$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$rev_id."' ")->row_array();
				if(isset($update_revision['id'])){
					$tracker_data = array('status' => '7');
					$this->db->where('id', $update_revision['id']);
					$this->db->update('live_revisions', $tracker_data);
				}

				$this->session->set_flashdata("message",$order_id." Sent Back To Designer!!!");
				redirect('new_csr/home/frontlinetrack_order_list/'.$hd);
	        }
	        /************************** Revision sendToadrep **************/
			if(isset($_POST['sendToadrep']) && !empty($_POST['rev_id']))
			{
			    if($rev_rev[0]['status'] == '7'){
			        $this->session->set_flashdata("message", "Order in 'Changes from CSR' status.."); 
				    redirect('new_csr/home/orderview/'.$hd.'/'.$order_id);       
			    }
				$pdf_path = 'none' ;
				//File upload to pdf_upload folder
				$slug = $_POST['new_slug'];
				if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
    				if($this->multiple_zip_folder_select($order_id)==true){
        				$pdf_uploads = "pdf_uploads/".$order_id;
        			}else{ 
        				$this->session->set_flashdata("message","Error uploading source to Adrep!!");
        				redirect($redirect);
        			}
    			}else{
					if($this->zip_folder_select()==true){
						$pdf_uploads = "pdf_uploads/".$order_id;
						//$pdf_path = "pdf_uploads/".$order_id.'/'.$_POST['pdf_file'];
					}else{ 
						$this->session->set_flashdata("message","Error uploading source to Adrep!!");
						redirect($redirect);
					}
				}
				
				$map_pdf_uploads = directory_map($pdf_uploads.'/');
				if($map_pdf_uploads){
					if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
						$map_zip = $pdf_uploads.'/'.$slug.'.zip';
						if(file_exists($map_zip)){
				          $pdf_path = $map_zip; $pdf = $map_zip; 
						  //update rev_sold_jobs - pdf_file to zip file instead of image file
							$post = array('pdf_file' => basename($pdf_path));
							$this->db->where('id', $_POST['rev_id']);
							$this->db->update('rev_sold_jobs', $post);
						}
					   
    				}else{
    					$map_pdf_jpg = glob($pdf_uploads.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
						if($map_pdf_jpg){ foreach($map_pdf_jpg as $row){	$pdf_path = $row; $pdf = $row;	} }
    				}
				}
				
				if(file_exists($pdf_path)){ 
				    //tscs send to adrep flow
				    if(($orders[0]['group_id']=='2' || $orders[0]['group_id']=='4') && ($orders[0]['order_type_id']=='2')){
    				    $type_of_ad = 'revision_ad';
    				    $revision_order_id = $_POST['rev_id'];
    					$response = $this->tscs_send_to_adrep($revision_order_id, $type_of_ad);
    					if($response != 'success'){
    						$this->session->set_flashdata("message",$response);
    			             redirect($redirect);    
    					}
    				}
    				
					$end_timestamp = date("Y-m-d H:i:s");
					$sent_time = date("H:i:s");
					
					$data1 = array( 'sent_time' => $sent_time,
									'frontline_csr' => $this->session->userdata('sId'),
									'pdf_path' => $pdf_path,
									'status' => '5',
									'end_timestamp' => $end_timestamp
									);
					$this->db->where('id', $_POST['rev_id']);
					$this->db->update('rev_sold_jobs', $data1);
					
					//update rev status in orders table(new 21 Apr 2022)
				    $order_rev_status_upadate = array( 'rev_order_status' => '5' ); //Revision Proof Ready
					$this->db->where('id', $order_id);
					$this->db->update('orders', $order_rev_status_upadate);
					
					//revision order reason
            		if(isset($_POST['revision_reason']) && !empty($_POST['revision_reason'])){
                		$reason_data = $_POST['revision_reason'];
                		$timestamp = date('Y-m-d H:i:s');
                		foreach($reason_data as $data_row){
                    		$post_revision_reason = array( 'rev_id' => $_POST['rev_id'], 
                                                    		'order_id' => $order_id, 
                                                    		'reason_id' => $data_row, 
                                                    		'csr' => $this->session->userdata('sId'),
                                                    		'timestamp' => $timestamp
                                                    	);
                    		$this->db->insert('rev_order_reason', $post_revision_reason);
                		}
            		}
            		
					//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
					if(isset($update_revision['id'])){
						$this->db->query("DELETE FROM `live_revisions` WHERE `id`= '".$update_revision['id']."'");
					}
					
					$jobs = $this->db->get_where('rev_sold_jobs',array('id' => $_POST['rev_id'], 'job_status' => '1'))->result_array();
					$time = ($jobs[0]['date'].' '.$jobs[0]['time']) ;
					
					 //converting to time
					$start = strtotime($time);
					$end = strtotime($end_timestamp);

					//calculating the difference
					$time_taken = abs($end - $start);

					$data2 = array( 'time_taken' => $time_taken );
					$this->db->where('id', $_POST['rev_id']);
					$this->db->update('rev_sold_jobs', $data2);
					
					//map orders status update via cURL
					if(isset($jobs[0]['map_revorder_id']) && $jobs[0]['map_revorder_id'] != 0){
						$source = null;
						if(isset($_POST['source_path']) && isset($_POST['new_slug'])){
							$chk_source = $_POST['source_path'].'/'.$_POST['new_slug'].'.zip';
							if(file_exists($chk_source)){ $source = 'https://adwitads.com/weborders/'.$chk_source; }
						}
						$fields = array(
										'status' => '5', 
										'map_revorder_id' => $jobs[0]['map_revorder_id'],
										'source' => $source,
										'file' => new \CurlFile($pdf_path), //pdf send
										);
						$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/revorder_status_update';
						$this->curl_post($url, $fields); //API using cURL 
					}
					
					//send mail
					$client = $this->db->get_where('adreps',array('id' => $_POST['adrep']))->result_array();
					if($client)
					{	
						$dataa['fname'] = $pdf_path; 
						$dataa['temp'] = $pdf_path;
						$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
						
						$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
						$design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.revad_template from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
						$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
						$dataa['template'] = $design_team[0]['revad_template'];
						$dataa['alias'] = $csr_alias[0]['alias'];
						$dataa['from'] = $design_team[0]['email_id'];
						
						$job_name = $cat[0]['job_name'];
						$advertiser_name = $cat[0]['advertiser'];
						if($publication[0]['id'] == '47'){ 
    						if(($design_team[0]['revad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
    						    $dataa['subject'] = 'Revised Ad (Note) '.$job_name.'_'.$advertiser_name;
    						}else{
    						    $dataa['subject'] = 'Revised Ad# '.$job_name.'_'.$advertiser_name;
    						}
						}else{
    						if(($design_team[0]['revad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
    						    $dataa['subject'] = 'Revised Ad (Note) :'.$_POST["new_slug"] ;
    						}else{
    						    $dataa['subject'] = 'Revised Ad: '.$_POST["new_slug"] ; 
    						}
    					}
						$dataa['from_display'] = 'Design Team';

						$dataa['replyTo'] = $design_team[0]['email_id'];

						$dataa['replyTo_display'] = 'Design Team';
						
						//$dataa['subject'] = 'Revised Ad :'.$_POST["new_slug"] ;
						
						$dataa['ad_type'] = 'revised' ;
						if(isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){ $dataa['note'] = $_POST['note']; } 
						//Client
						if($this->session->userdata('sId')=='25'){
							$dataa['recipient'] = 'webmaster@adwitglobal.com';
						}else{
							$dataa['recipient'] = $client[0]['email_id'];
						}
						
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
						$dataa['client'] = $client[0];
						$dataa['design_team_id'] = $design_team[0]['id'];
						if(!empty($client[0]['email_cc']) || $client[0]['email_cc'] != ''){ $dataa['client_Cc'] = $client[0]['email_cc']; }
						$dataa['order_id'] = $order_id ;
						$dataa['rev_id'] = $_POST['rev_id'] ;
						$dataa['version'] = $rev_rev[0]['version'] ;
						$dataa['orders'] = $orders[0] ;
						$this->load->library('Encryption');
						$rev_id = $this->encryption->encrypt($_POST['rev_id']);
						$dataa['url']= base_url().index_page().'order_rating/home/rev_order_rating/'.$rev_id;
						$this->test_mail($dataa);
						
						//Note Sent 
						if (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){
							$post_note = array( 'order_id' => $order_id, 'revision_id' => $_POST['rev_id'], 'note' => $_POST['note'] );
							$this->db->insert('note_sent', $post_note);
						}
					}else{ echo "<script>alert('client unidentified')</script>"; }
					
					//For Ftp xml files 16-OCT-2023
        			if($orders[0]['publication_id'] == '656'){ //Ogden
        			    $this->Ogden_create_xml_proofReady('revision', $order_id);    
        			}
				}else{ echo "<script>alert('PDF/Image File Not Found..Try Uploading Again')</script>"; }
				
				redirect('new_csr/home/frontlinetrack_order_list/'.$hd);
			}
			
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->result_array();
			if(!$rev_orders){
				$this->session->set_flashdata("message","Order: Details not Found..!!");
				redirect('new_csr/home/frontlinetrack_order_list/'.$hd);
			}
			$designer_message = $this->db->query("SELECT * from `designer_message` where `rev_id` = '".$rev_orders[0]['id']."' ")->result_array();
		 	 if($designer_message){
				$data['designer_message'] = $designer_message;
			} 
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			//$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
			$data['rev_orders']= $rev_orders;
			$data['orders']= $orders;
			$data['cat']= $cat;
			if($cat[0]['source_path']!='none'){
				$data['SourcePath']= $cat[0]['source_path'];
			}else{ $data['SourcePath']= 'sourcefile/'.$order_id.'/'.$cat[0]['slug']; }
			
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			//$this->load->view('new_csr/rev_orderview', $data);
		}
	}
	
	public function zip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			if(isset($_POST['order_id'])){ $order_id = $_POST['order_id']; }
			/*else{ //revision $order_id = $new_slug;}*/
			
			$SourceFilePath = $_POST['source_path'] ;
			$source_file = $_POST['source_file'];
			if(isset($_POST['pdf_file'])){
				$pdf_file = $_POST['pdf_file'];
			}else{
				$pdf_file = $new_slug.'.pdf';
			}
			
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			$idml_path = $SourceFilePath.'/'.$new_slug.'.idml';
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}else{ echo"<script>alert('$src_path source file not founddd');</script>"; }
			
			if(file_exists($idml_path)){
				$this->zip->read_file($idml_path);
			}
			
			if(file_exists($pdf_path)){
				$this->zip->read_file($pdf_path);
			}else{ 
				$this->load->helper('directory');	
				$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
				if($map){ foreach($map as $row){
					$this->zip->read_file($row);
				} } 
			}
			
			$map_font = directory_map($font_path.'/');
			$map_link = directory_map($links_path.'/');
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){ 
				$this->zip->read_dir($links_path, FALSE);
			}
			 
			if(isset($_POST['download'])){
				$this->zip->archive($SourceFilePath.'/'.$new_slug.'.zip');
				$this->zip->download($new_slug.'.zip');
			}else{
				//send source zip to ftp( metro design6 design7)
				if(isset($_POST['hd']) && isset($order_id) && ($_POST['hd']=='2')){
					$post = array('order_id' => $order_id, 'hd' => $_POST['hd'], 'slug' => $new_slug, 'path' => $SourceFilePath);
					$this->db->insert('sourcefile_move', $post);
					
				}   
				if(isset($_POST['archive'])){
				$this->zip->archive($SourceFilePath.'/'.$new_slug.'.zip');
					//unlink($SourceFilePath.'/'.$new_slug.'.zip');
				}
				//send to adrep
				$zip_folder = glob($SourceFilePath.'/*.zip',GLOB_BRACE);
				//if($zip_folder){ foreach($zip_folder as $row_zip){ unlink($row_zip); }} //zip folder deletion
				 
				$pdf_uploads = "pdf_uploads/".$order_id ;
				if (@mkdir($pdf_uploads,0777)){}
					if(file_exists($pdf_path)){
						$pdf_uploads = $pdf_uploads.'/'.$pdf_file;
						copy($pdf_path, $pdf_uploads);
					}else{
							$this->load->helper('directory');	
							$map_jpg = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
							if($map_jpg){ foreach($map_jpg as $row){
									$pdf_uploads = $pdf_uploads.'/'.basename($row);
									$pdf_path = $SourceFilePath.'/'.$row;
									copy($row, $pdf_uploads);
							} }else{ return false; } 
					}	
					return true;
				//}else{ return false; }
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}
	
	function multiple_zip_folder_select($order_id = 0) //multiple web ads
	{
	    $order_details = $this->db->query('SELECT * FROM `orders` WHERE `id` = "'.$order_id.'"')->row_array();
	    if(isset($order_details['id'])){
	       $new_slug = $_POST['new_slug'] ;
	       //if(isset($_POST['order_id'])){ $order_id = $_POST['order_id']; }
	       if($order_details['ad_format']=='5'){ //flexitive ad (flexitive size)
		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.id, flexitive_size.ratio AS name FROM `orders_multiple_size`
                							                LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
                							                    WHERE orders_multiple_size.order_id = '".$order_details['id']."'")->result_array();
		    }else{ //pixel size
		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.id, CONCAT(pixel_sizes.width,'x',pixel_sizes.height) AS name FROM `orders_multiple_size`
                							                LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
                							                WHERE orders_multiple_size.order_id = '".$order_details['id']."'")->result_array();
		    }
		    $orders_multiple_custom_size = $this->db->query("SELECT *, CONCAT(custom_width,'x',custom_height) AS name FROM `orders_multiple_custom_size` 
		                                                        WHERE `order_id` = '".$order_details['id']."'")->result_array();
            
            if(isset($orders_multiple_size[0]['id'])  || isset($orders_multiple_custom_size[0]['id'])){
	           $this->load->library('zip');
			   $this->load->helper('directory');
	           
	           if(isset($orders_multiple_size[0]['id'])){
    	           foreach($orders_multiple_size as $msize){
    	               $slug_fname = $new_slug.'_'.$msize['name'];
    	               $SourceFilePath = $_POST['source_path'].'/'.$msize['name'] ;
    	               //$this->zip->read_dir($SourceFilePath, FALSE);
    	               $font_path = $SourceFilePath.'/Document fonts/';
            			$links_path = $SourceFilePath.'/Links/';
            			$src_path =  $SourceFilePath.'/'.$slug_fname.'.psd';
            			//$pdf_path =  $SourceFilePath.'/'.$pdf_file;
            			$idml_path = $SourceFilePath.'/'.$new_slug.'.idml';
            			
            			if(file_exists($src_path)){
            			    $new_path = $msize['name'].'/'.$slug_fname.'.psd';
            				$this->zip->read_file($src_path, $new_path);
            			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
            			
            			if(file_exists($idml_path)){
            				$this->zip->read_file($idml_path);
            			}
            			
            				$this->load->helper('directory');	
            				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
            				if($map){ foreach($map as $row){
            				    $new_path = $msize['name'].'/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            				} } 
            			
            			
            			$map_font = glob($font_path.'*',GLOB_BRACE);
            			$map_link = glob($links_path.'*',GLOB_BRACE); 
            			if($map_font){
            			    foreach($map_font as $row){
            			        $new_path = $msize['name'].'/Document fonts/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            				//$this->zip->read_dir($font_path, FALSE);
            			}	
            			if($map_link){ 
            			    foreach($map_link as $row){
            			        $new_path = $msize['name'].'/Links/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            				//$this->zip->read_dir($links_path, FALSE);
            			}
    	           }
	           }
	           
	           if(isset($orders_multiple_custom_size[0]['id'])){
    	           foreach($orders_multiple_custom_size as $mcsize){
    	               $slug_fname = $new_slug.'_'.$mcsize['name'];
    	               $SourceFilePath = $_POST['source_path'].'/'.$mcsize['name'] ;
    	               //$this->zip->read_dir($SourceFilePath, FALSE);
    	               
    	               $font_path = $SourceFilePath.'/Document fonts/';
            			$links_path = $SourceFilePath.'/Links/';
            			$src_path =  $SourceFilePath.'/'.$slug_fname.'.psd';
            			//$pdf_path =  $SourceFilePath.'/'.$pdf_file;
            			$idml_path = $SourceFilePath.'/'.$new_slug.'.idml';
            			
            			if(file_exists($src_path)){
            				$new_path = $mcsize['name'].'/'.$slug_fname.'.psd';
            				$this->zip->read_file($src_path, $new_path);
            			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
            			
            			if(file_exists($idml_path)){
            				$this->zip->read_file($idml_path);
            			}
            			
            				$this->load->helper('directory');	
            				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
            				if($map){ foreach($map as $row){
            					$new_path = $mcsize['name'].'/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            				} } 
            			
            			
            			$map_font = glob($font_path.'*',GLOB_BRACE);
            			$map_link = glob($links_path.'*',GLOB_BRACE); 
            			if($map_font){
            			    foreach($map_font as $row){
            			        $new_path = $mcsize['name'].'/Document fonts/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            			}	
            			if($map_link){ 
            			    foreach($map_link as $row){
            			        $new_path = $mcsize['name'].'/Links/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            			}
    	           }
	           }
	           
        	    if(isset($_POST['download'])){
        			$this->zip->archive($_POST['source_path'].'/'.$new_slug.'.zip');
        			$this->zip->download($new_slug.'.zip');
        		}else{
        		    $this->zip->archive($_POST['source_path'].'/'.$new_slug.'.zip');
        		    
        			//send source zip to ftp( metro design6 design7)
        			if(isset($_POST['hd']) && isset($order_id) && ($_POST['hd']=='2')){
        				$post = array('order_id' => $order_id, 'hd' => $_POST['hd'], 'slug' => $new_slug, 'path' => $_POST['source_path']);
        				$this->db->insert('sourcefile_move', $post);
        			}
        			
        			//send to adrep
        				 
        			$pdf_uploads = "pdf_uploads/".$order_id ;
        			if (@mkdir($pdf_uploads,0777)){}
        			$this->load->library('zip');
        			$this->zip->clear_data();

        			foreach($orders_multiple_size as $msize){ //multiple web ads
        			    $slug_fname = $new_slug.'_'.$msize['name'];
        			    $SourceFilePath = $_POST['source_path'].'/'.$msize['name'] ;
        				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
        				
            			if($map){ foreach($map as $row){
            			    $new_path = $msize['name'].'/'.basename($row);
            				$this->zip->read_file($row, $new_path);    
            			} }
        			}
        			foreach($orders_multiple_custom_size as $mcsize){ //multiple custom
        			    $slug_fname = $new_slug.'_'.$mcsize['name'];
        			   	$SourceFilePath = $_POST['source_path'].'/'.$mcsize['name'] ;
        				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
        				
            			if($map){ foreach($map as $row){
            			    $new_path = $mcsize['name'].'/'.basename($row);
            				$this->zip->read_file($row, $new_path); 
            			} }
        			}
        			
        			if($this->zip->archive($pdf_uploads.'/'.$new_slug.'.zip') == TRUE){
        			    return true;
        			}else{
        			    return false;
        			}
        			
        			return true;
        		}
	        }
	    }
						
	}
	
	function rrmdir($dir) { 
       if (is_dir($dir)) { 
         $objects = scandir($dir);
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
               $this->rrmdir($dir. DIRECTORY_SEPARATOR .$object);
             else
               unlink($dir. DIRECTORY_SEPARATOR .$object); 
           } 
         }
         rmdir($dir); 
       } 
    }
    
	public function ftp_zip_folder_select() 
	{
		$hd = $_POST['hd'];
		$help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
		if($help_desk['ftp_server'] != 'none'){
			$order_id = $_POST['order_id'] ;
			$order_detail = $this->db->get_where('orders', array('id'=>$order_id))->row_array();
			$order_type = $order_detail['order_type_id'] ;
			$cat_slug = $_POST['cat_slug'] ;
			$slug = $_POST['new_slug'] ;
			
				$ftp_server = $help_desk['ftp_server'];
				$ftp_user_name = $help_desk['ftp_username'];
				$ftp_user_pass = $help_desk['ftp_password'];
				//$ftp_folder = $fileuploadstatus[0]['source_path'];
				$ftp_folder = 'Dropzone/sourcefile/'.$order_id.'/'.$cat_slug;
				$conn_id = ftp_connect($ftp_server)or die("couldnt connect to $ftp_server");
				$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("couldnt login to $ftp_server");
				ftp_pasv($conn_id, true);
				if($order_type == '1'){
					$jpgfile = $ftp_folder.'/'.$slug.'.jpg';
					$giffile = $ftp_folder.'/'.$slug.'.gif';
					
					$chk_jpgfile = ftp_size($conn_id, $jpgfile);
					$chk_giffile = ftp_size($conn_id, $giffile);
					
					if($chk_jpgfile != '-1'){
						$ext = 'jpg';
						$pdf_file = $jpgfile;
					}elseif($chk_giffile != '-1'){
						$ext = 'gif';
						$pdf_file = $giffile;
					}
				}else{
					$pdf_file = $ftp_folder.'/'.$slug.".pdf";
					$ext = 'pdf';
				}
				$chk_pdfFile = ftp_size($conn_id, $pdf_file);
				if($chk_pdfFile == '-1'){
					$this->session->set_flashdata("message","PDF File not found in Ftp!!!");
					redirect($redirect);
				}
				//create zip
				$response = file_get_contents("https://ftps1a4l1.adwitads.com/adwitadslivetest/Dropzone/source_zip_folder.php?order_id=$order_id&slug=$cat_slug&new_slug=$slug");
				
				$SourceFilePath = $ftp_server.'/adwitadslivetest/'.$ftp_folder;
			  
				//pdf upload to pdfuploads
				$pdf_uploads = "pdf_uploads/".$order_id ;
					if (@mkdir($pdf_uploads,0777)){}
					$pdf_uploads = $pdf_uploads.'/'.$slug.'.'.$ext ;
					
					if (!@ftp_get($conn_id, $pdf_uploads, $pdf_file, FTP_BINARY)){
						return false;
					}
				return $ext;
		}
	}
	
	
	public function assign_designer() 
	{
		if(isset($_POST['update']) && isset($_POST['action']) && !empty($_POST['did'])){
			$post = array('new_d' => $_POST['action']);
			$this->db->where('id', $_POST['did']);
			$this->db->update('designers', $post);
			redirect('new_csr/home/assign_designer');
		}
		$designers = $this->db->get_where('designers',array('is_active'=>'1'))->result_array(); 
		$data['designers'] = $designers;
		$this->load->view('new_csr/assign_designer',$data);
	}
	/************************ tscs send to adrep START*****************************/
	function unzip_file($source_path, $destination_path)
	{
	    $zip = new ZipArchive;
        $res = $zip->open($source_path);
        if ($res === TRUE) {
          $zip->extractTo($destination_path);
          $zip->close();
          return true; //echo 'woot!';
        } else {
          return false; //echo 'doh!';
        }
	}
	
	function zip_ffile($source_path, $destination_path)
	{
	    $this->load->library('zip');
	    $this->zip->clear_data();
		if($this->zip->read_dir($source_path, FALSE)){
            if($this->zip->archive($destination_path) == true){ 
                return true;
        	}else{
        		return false;
            }
        }else{ return false; }
	}
	//outgoing upload proof zip file to ftp
	public function tscs_outgoing_ftp($file_to_be_sent, $type_of_ad)             
	{
	    define('FTP_URL', 'ftp.timesshamrock.com');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'MapleCarFish!');
        define('FTP_DIRECTORY', './RETURN_TO_TRACK');
        if($type_of_ad == 'new_ad'){
            $local_path = "temp_tscs/OUTGOING/NEW";
        }elseif($type_of_ad == 'revision_ad'){
            $local_path = "temp_tscs/OUTGOING/CORRECTION";
        }
        $file_with_path = $local_path.'/'.$file_to_be_sent;
        if(file_exists($file_with_path)){ //ftp connect only if folder not empty
            //Connect ot FTP
            $ftp = ftp_connect(FTP_URL);
            //Login to FTP
            ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
            ftp_pasv($ftp, true);
            
            if(ftp_put($ftp, FTP_DIRECTORY.'/'.$file_to_be_sent, $file_with_path, FTP_BINARY)) {
                return true;//echo "SUCCESS";//unlink($file_with_path);
            }else{
                return false;//echo "There was a problem while uploading $file\n"; exit;
            }
            
            ftp_close($ftp);
        }
	}
	
    public function tscs_send_to_adrep($id, $type_of_ad) //$id = order_id/rev_sold_job_id, $type_of_ad = new_ad/revision_ad
	{ 
	    $message = 'success';
	    if($type_of_ad == 'new_ad'){
	        $q = "SELECT orders.job_no, orders.file_path, cat_result.source_path, cat_result.slug FROM `orders`
	                JOIN `cat_result` ON cat_result.order_no = orders.id
	                    WHERE orders.id = $id";
	         $outgoing_path = 'temp_tscs/OUTGOING/NEW'; 
	         $outgoing_path_archive = 'temp_tscs/OUTGOING/NEW_archive';
	    }else{
	        $q = "SELECT orders.job_no, rev_sold_jobs.file_path, cat_result.source_path, rev_sold_jobs.new_slug AS slug FROM `rev_sold_jobs`
	                JOIN `orders` ON orders.id = rev_sold_jobs.order_id
	                JOIN `cat_result` ON cat_result.order_no = orders.id
	                    WHERE rev_sold_jobs.id = $id ORDER BY rev_sold_jobs.id DESC LIMIT 1";
	       $outgoing_path = 'temp_tscs/OUTGOING/CORRECTION';
	       $outgoing_path_archive = 'temp_tscs/OUTGOING/CORRECTION_archive';
	    }
		$order_detail = $this->db->query("$q")->row_array();
		//check for zip file(one we got from ftp) in downloads folder- match job_no.zip
		if(isset($order_detail['file_path'])){
		    $job_name = $order_detail['job_no'];
		    $zip_fname = $job_name.'.zip' ;
		    $zip_file_path = $order_detail['file_path'].'/'.$zip_fname;
		    if(!file_exists($zip_file_path)){ //in case job name renamed by csr 
		        $split_job_name = str_split($order_detail['job_no'], strlen($order_detail['job_no']) - 1);
		        $job_name = $split_job_name[0];
		        $zip_fname = $job_name.'.zip' ;
		        $zip_file_path = $order_detail['file_path'].'/'.$zip_fname; 
		    }
		    if(file_exists($zip_file_path)){
		        //unzip the zip file
		        $zip_source_path = $zip_file_path;
		        $unzip_destination_path = 'temp_tscs/OUTGOING/unzip';
		        $response = $this->unzip_file($zip_source_path, $unzip_destination_path);
		        if($response === true){
		            //get indd file details from unzipped folder
		            $ftp_unzip_path = $unzip_destination_path.'/'.$job_name; //$ftp_unzip_path = $unzip_destination_path.'/'.$order_detail['job_no'];
		            $map_indd = glob($ftp_unzip_path.'/*.{indd,INDD}',GLOB_BRACE);
		            if($map_indd){
    		            foreach($map_indd as $row){
    		                $ftp_unzip_indd = basename($row);   
    		            }
        		        if(file_exists($order_detail['source_path']) && isset($ftp_unzip_indd)){
        		            $source_path = $order_detail['source_path'];
        		            $slug = $order_detail['slug'];
        		            $source_indd_file = $slug.'.indd';
        		            $map_source_indd = glob($source_path.'/'.$slug.'.{indd,INDD}',GLOB_BRACE);
        		            if($map_source_indd){ $source_indd_file = basename($map_source_indd[0]);  }
        		            $source_indd_path = $source_path.'/'.$source_indd_file;
        		            //check for sourcepath for slug.indd file
        		            if(file_exists($source_indd_path)){
        		                //rename sourcepath/slug.indd file to zip file indd file and replace the zip file indd file so that its the one designed by adwitads design team
        		                copy($source_indd_path, $ftp_unzip_path.'/'.$ftp_unzip_indd);
        		                
        		                //??? and also upload any additional link files by renaming it to the job_no
        		                $link_file_path = $source_path.'/Links';
        		                if ($handle = opendir($link_file_path)) {
                                    while (false !== ($entry = readdir($handle))) {
                                        if ($entry != "." && $entry != "..") {
                                            $ext = pathinfo($entry, PATHINFO_EXTENSION);
                                            if(strtoupper($ext) != 'INDD'){
                                                $name = basename($entry,$ext);
                                                if(strcmp($job_name, substr($name,0,strlen($job_name))) == 0){ //check whether the link name starts with job_no
                                                    $source_link_path = $link_file_path.'/'.$entry;
                                                    $destination_link_path = $ftp_unzip_path.'/'.$entry;
                                                }else{
                                                    //rename and copy
                                                    $source_link_path = $link_file_path.'/'.$entry;
                                                    $rename = $job_name.'_'.$name.$ext;
                                                    $destination_link_path = $ftp_unzip_path.'/'.$rename;    
                                                }
                                                copy($source_link_path, $destination_link_path); 
                                            }
                                        }
                                    }
                                    closedir($handle);
                                }
        		                //zip the files (job_no.zip) into NEW/CORRECTION folder 
        		                $save_zip_to_path = $outgoing_path.'/'.$zip_fname;
        		                $save_zip_to_path_archive = $outgoing_path_archive.'/'.$zip_fname;
        		                if($this->zip_ffile($ftp_unzip_path, $save_zip_to_path) === true){
        		                    //ftp upload
                                    if($this->tscs_outgoing_ftp($zip_fname, $type_of_ad) === true){
            		                    //delete unzip folder and files
                                        $di = new RecursiveDirectoryIterator($ftp_unzip_path, FilesystemIterator::SKIP_DOTS);
                                        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
                                        foreach ( $ri as $file ) {
                                            $file->isDir() ?  rmdir($file) : unlink($file);
                                        }
                                        rmdir($ftp_unzip_path);
                                        //move the package to archive folder
                                        rename($save_zip_to_path , $save_zip_to_path_archive);
                                    }else{ $message = "ftp upload failed.."; }
                                }else{ $message = "zip operation failed.."; }
        		            }else{ $message = "source file missing"; }
        		        }else{ $message = "source folder missing"; }
		            }else{ $message = "ftp indd missing"; }
		        }else{ $message = "unzip operation failed.."; }
		    }else{ $message = "downloads zip file missing - ".$zip_fname; }
		}else{ $message = "downloads folder missing"; }
		return $message;
	}
	
	public function display_tscs_package($id, $type_of_ad) //$id = order_id/rev_sold_job_id, $type_of_ad = new_ad/revision_ad
	{ 
	    $message = 'success';
	    if($type_of_ad == 'new_ad'){
	        $q = "SELECT orders.job_no, orders.file_path, cat_result.source_path, cat_result.slug FROM `orders`
	                JOIN `cat_result` ON cat_result.order_no = orders.id
	                    WHERE orders.id = $id";
	         $outgoing_path = 'temp_tscs/OUTGOING/NEW';           
	    }else{
	        $q = "SELECT orders.job_no, rev_sold_jobs.file_path, cat_result.source_path, rev_sold_jobs.new_slug AS slug FROM `rev_sold_jobs`
	                JOIN `orders` ON orders.id = rev_sold_jobs.order_id
	                JOIN `cat_result` ON cat_result.order_no = orders.id
	                    WHERE rev_sold_jobs.id = $id ORDER BY rev_sold_jobs.id DESC LIMIT 1";
	       $outgoing_path = 'temp_tscs/OUTGOING/CORRECTION';
	    }
		$order_detail = $this->db->query("$q")->row_array();
		//check for zip file(one we got from ftp) in downloads folder- match job_no.zip
		if(isset($order_detail['file_path'])){
		    $zip_fname = $order_detail['job_no'].'.zip' ;
		    $zip_file_path = $order_detail['file_path'].'/'.$zip_fname;
		    if(file_exists($zip_file_path)){
		        //unzip the zip file
		        $zip_source_path = $zip_file_path;
		        $unzip_destination_path = 'temp_tscs/OUTGOING/unzip';
		        $response = $this->unzip_file($zip_source_path, $unzip_destination_path);
		        if($response === true){
		            //get indd file details from unzipped folder
		            $ftp_unzip_path = $unzip_destination_path.'/'.$order_detail['job_no'];
		            $map_indd = glob($ftp_unzip_path.'/*.{indd,INDD}',GLOB_BRACE);
		            if($map_indd){
    		            foreach($map_indd as $row){
    		                $ftp_unzip_indd = basename($row);   
    		            }
        		        if(file_exists($order_detail['source_path']) && isset($ftp_unzip_indd)){
        		            $source_path = $order_detail['source_path'];
        		            $slug = $order_detail['slug'];
        		            $source_indd_file = $slug.'.indd';
        		            $map_source_indd = glob($source_path.'/'.$slug.'.{indd,INDD}',GLOB_BRACE);
        		            if($map_source_indd){ $source_indd_file = basename($map_source_indd[0]);  }
        		            $source_indd_path = $source_path.'/'.$source_indd_file;
        		            //check for sourcepath for slug.indd file
        		            if(file_exists($source_indd_path)){
        		                //rename sourcepath/slug.indd file to zip file indd file and replace the zip file indd file so that its the one designed by adwitads design team
        		                copy($source_indd_path, $ftp_unzip_path.'/'.$ftp_unzip_indd);
        		                
        		                //??? and also upload any additional link files by renaming it to the job_no
        		                $link_file_path = $source_path.'/Links';
        		                if ($handle = opendir($link_file_path)) {
                                    while (false !== ($entry = readdir($handle))) {
                                        if ($entry != "." && $entry != "..") {
                                            $ext = pathinfo($entry, PATHINFO_EXTENSION);
                                            $name = basename($entry,$ext);
                                            if(strcmp($order_detail['job_no'], substr($name,0,strlen($order_detail['job_no']))) == 0){ //check whether the link name starts with job_no
                                                $source_link_path = $link_file_path.'/'.$entry;
                                                $destination_link_path = $ftp_unzip_path.'/'.$entry;
                                            }else{
                                                //rename and copy
                                                $source_link_path = $link_file_path.'/'.$entry;
                                                $rename = $order_detail['job_no'].'_'.$name.$ext;
                                                $destination_link_path = $ftp_unzip_path.'/'.$rename;    
                                            }
                                            copy($source_link_path, $destination_link_path); 
                                        }
                                    }
                                    closedir($handle);
                                }
        		            }else{ $message = "source file missing"; }
        		        }else{ $message = "source folder missing"; }
		            }else{ $message = "ftp indd missing"; }
		        }else{ $message = "unzip operation failed.."; }
		    }else{ $message = "downloads zip file missing - ".$zip_fname; }
		}else{ $message = "downloads folder missing"; }
		return $message;
	}
	/************************ tscs send to adrep END*****************************/
	public function metro_ftp($pdf_file)
	{ 
		//FTP for Metro help desk(2)
		if(isset($pdf_file) && $pdf_file!=''){
			$path = '/home/adwitac/public_html/metroaod/outgoing/PROOF';
			//$path = 'outgoing/PROOF/';
			if(file_exists($path)){
				$file = $pdf_file;
				$fname = basename($file);
				$fname = str_replace('_','-',$fname);
				// upload file
				if(copy($file, $path.'/'.$fname)){
					return true;
				}else{
					return false;;
				}
			}
		}
	}
	/*
	public function metro_ftp($pdf_file)
	{ 
		//FTP for Metro help desk(2)
		if(isset($pdf_file) && $pdf_file!=''){
			$ftp_server1 = 'ftp.adwitads.com';
			//$ftp_server2 = 'ftps1a4l2.adwitads.com';
			//$ftp_server3 = 'ftps1a4l3.adwitads.com';
			
			if (!@ftp_connect($ftp_server1)) {
				
				if (!@ftp_connect($ftp_server2)){ 
					
					$ftp_conn = @ftp_connect($ftp_server3) or die("couldnt connect to $ftp_server3");
				}else{
					$ftp_conn = ftp_connect($ftp_server2) or die("Could not connect to $ftp_server2");
				}
			}else{
				$ftp_conn = ftp_connect($ftp_server1) or die("Could not connect to $ftp_server1");
			}
			
			$ftp_username='aod@adwitads.com';
			$ftp_userpass='adwit@123';
			$folder_name = 'PROOF';
			//$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			$path = 'outgoing/PROOF/';
			if(!ftp_nlist($ftp_conn, $path)){ 
				if (@ftp_mkdir($ftp_conn, $path))
				{
					
				}
			}
			
			$file = $pdf_file;
			$fname = basename($file);
			$fname = str_replace('_','-',$fname);
			// upload file
			if (@ftp_put($ftp_conn, $path.'/'.$fname, $file, FTP_BINARY)){
				return true;
			}else{
				return false;;
			}
			// close connection
			ftp_close($ftp_conn);
		}
	}
	*/
    public function map_orders()
	{
		$data['hi'] = 'hello';
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['map_orders'] = $this->db->query("Select map_orders.*, orders_type.name from `map_orders`
														JOIN `orders_type` ON map_orders.order_type_id = orders_type.id
														where `approve`='0' AND `timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->result_array();
		}else{
				$today = date('Y-m-d');
				$pday = date('Y-m-d', strtotime(' -30 day'));
				$data['map_orders'] = $this->db->query("Select map_orders.*, orders_type.name from `map_orders`
														JOIN `orders_type` ON map_orders.order_type_id = orders_type.id
														where `approve`='0' AND `timestamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
		}
		$this->load->view('new_csr/map_orders', $data);
		
	}
	
    public function map_orders_submit($id='')
	{
		$map_orders = $this->db->get_where('map_orders',array('id' => $id, 'approve' => '0'))->row_array();
		$data['publication_id'] = '3'; //coast news
		if(isset($map_orders['id'])){
			if(isset($_POST['order_submit']) && isset($_POST['id']))
			{
				$art = $_POST['artinst'];
				$adtype = $_POST['adtype'];
							
				/*$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
				if($orders){
					$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
					redirect('new_csr/home/map_orders');
				}else{*/
					$map_order_id = $_POST['map_order_id'];
					$adrep_id = $_POST['adrep'];
					$publication_id = $_POST['publication_name'];
					$pub_details = $this->db->get_where('publications',array('id' => $publication_id))->result_array();
					$help_desk = $pub_details[0]['help_desk'];
					//orders table
					$_POST['job_name'] = preg_replace('/[^A-Za-z0-9\+s]/', '_', $_POST['job_name']);
					
					if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
						$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
					} else {
						$next_day =  date('D', strtotime(' +1 day'));
						if($next_day == 'Sat' || $next_day == 'Sun'){
							$publish_date = date('Y-m-d', strtotime('next monday'));
						}else{
							$publish_date = date('Y-m-d', strtotime(' +1 day'));
						}
					}
					
					if(isset($map_orders['adwitads_pickup_id']) && $map_orders['adwitads_pickup_id'] != 0 && $map_orders['adwitads_pickup_id'] != ''){
						$pickup_adno = $map_orders['adwitads_pickup_id'];
					}else{
						$pickup_adno = '';
					}
					
					if($_POST['order_type'] == '1'){ //web
						if($_POST['pixel_size'] == 'custom'){
							$w = $_POST['custom_width'];
							$h = $_POST['custom_height'];
						}else{
							$pixel_sizes = $this->db->get_where('pixel_sizes', array('id' => $_POST['pixel_size']))->row_array();
							$w = $pixel_sizes['width'];
							$h = $pixel_sizes['height'];
						}
					
						$post = array(
									'map_order_id' => $map_order_id,
									'adrep_id' => $adrep_id,
									'csr' => $this->session->userdata('sId'),
									'publication_id' => $publication_id,
									'group_id' => $pub_details[0]['group_id'],
									'help_desk' => $help_desk,
									'publication_name' => $pub_details[0]['name'],
									'order_type_id' => '1', //web
									'advertiser_name' => $_POST['advertiser'],
									'job_no' => $_POST['job_name'],
									'pixel_size' => $_POST['pixel_size'],
									'custom_width' => $_POST['custom_width'],
									'custom_height' => $_POST['custom_height'],
									'web_ad_type' => $_POST['web_ad_type'],
									'publish_date' => $publish_date,
									'spec_sold_ad' => '0',
									'pickup_adno' => $pickup_adno,
									'activity_time' => date('Y-m-d h:i:s'),
									'club_id'=> $pub_details[0]['club_id'],
								);
					}else{ //print
						$w = $_POST['width'];
						$h = $_POST['height'];
						$post = array(
									'map_order_id' => $map_order_id,
									'adrep_id' => $adrep_id,
									'csr' => $this->session->userdata('sId'),
									'publication_id' => $publication_id,
									'group_id' => $pub_details[0]['group_id'],
									'help_desk' => $help_desk,
									'publication_name' => $_POST['publication_name'],
									'order_type_id' => '2', //default print
									'advertiser_name' => $_POST['advertiser'],
									'job_no' => $_POST['job_name'],
									'width' => $_POST['width'],
									'height' => $_POST['height'],
									'print_ad_type' => $_POST['print_ad_type'],
									'publish_date' => $publish_date,
									'spec_sold_ad' => '0',
									'pickup_adno' => $pickup_adno,
									'activity_time' => date('Y-m-d h:i:s'),
									'club_id'=> $pub_details[0]['club_id'],
								);
					}
					$this->db->insert('orders',$post);	
					$order_no = $this->db->insert_id();	
					
					
					
					//cat_result table
					if($order_no)
					{
						//Live_tracker updation
						$tracker_data = array(
							'pub_id'=> $pub_details[0]['id'],
							'order_id'=> $order_no,
							'job_no' => $_POST['job_name'],
							'club_id'=> $pub_details[0]['club_id'],
							'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					
						$post = array('approve' => '1');
						$this->db->where('id', $_POST['id']);
						$this->db->update('map_orders', $post);
						
						$data = array();
						for($i=0;$i<5;$i++)	//file data sent to file_upload function
						{
							if (!empty($_FILES['ufile']['tmp_name'][$i]))
							{
								$data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
								$data['fname'.$i] = $_FILES['ufile']['name'][$i];
							}
						}
						
						$this->orders_folder($order_no);// folder, html_form
						$data['id'] = $order_no;
						$this->file_upload($data); //file uploads
						if(isset($_POST['attachfile'])){
							$file_path = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$order_no'")->row_array();
							$download_path = $file_path['file_path'];
							$map_download = $_POST['attachfile'];
							if(file_exists($map_download) && file_exists($download_path)){
								if(copy($map_download, $download_path.'/'.basename($map_download))){
									//delete the xml file
									unlink($map_download);
								}
							}
						}
						$size = $w * $h;
						$category = $this->cat_calc($adtype);	//category calculation			
							$news_id = $pub_details[0]['news_id'];
							$initial = $pub_details[0]['initial'];
							$slug_type = $pub_details[0]['slug_type'];
							$team = $pub_details[0]['design_team_id'];
						$dataa = array(
									'order_no' => $order_no,
									'job_name' => $_POST['job_name'],
									'adrep' => $adrep_id,
									'advertiser' => $_POST['advertiser'], 
									'width' => $w,
									'height' => $h,
									'artinstruction' => $_POST['artinst'],
									'adtypewt' => $_POST['adtype'],
									'help_desk' => $help_desk,
									'publication_id' => $publication_id,
									'news_id' => $news_id,
									'news_initial' => $initial,
									'instruction' => $_POST['instruction'],
									'team' => $team,
									'slug_type' => $slug_type,
									'category' => $category,
									'csr' => $this->session->userdata('sId'),
									'date' => Date("Ymd"),
									'time' => date("His")
									);
						$this->db->insert('cat_result',$dataa);	
						$cat_id = $this->db->insert_id();
						
						if($cat_id)
						{
							//order status
							$post_status = array('status' => '2');
							$this->db->where('id', $order_no);
							$this->db->update('orders', $post_status);
							
							//Live_tracker Updation
							$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
							if(isset($update_order['id'])){
								$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
								$this->db->where('id', $update_order['id']);
								$this->db->update('live_orders', $tracker_data);
							}
							//map db update cURL
							$fields = array('status' => '2', 'map_order_id' => $map_order_id, 'adwitads_id' => $order_no);
							$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/order_status_update';
							$this->curl_post($url, $fields); //API using cURL
							$status = 'v1';
							$data2 = array(
										'order_no' => $order_no,
										'csr' => $this->session->userdata('sId'),
										'news_id' => $news_id,
										'publication_id'  => $publication_id,
										'help_desk'  => $help_desk,
										'date' => Date("Ymd"),
										'time' => date("His"),
										'category' => $category
										);
							$this->db->insert('cshift',$data2);
						}else{ 
							$this->session->set_flashdata("message","Order not been categorised!!!".$this->db->_error_message());
							redirect('new_csr/home/map_orders'); 
						}
					}else{
						$this->session->set_flashdata("message","Order not Placed.. Try again!!!".$this->db->_error_message());
						redirect('new_csr/home/map_orders');
					}
					$this->session->set_flashdata("message","Order Placed and Categorised Sucessfully!!!<br/>Order No: $order_no");
					redirect('new_csr/home/map_orders');
				//}	
			}
			$data['map_orders'] = $map_orders;
			$this->load->view('new_csr/map_submit', $data);
		}
	}
	
	public function metro_orders()
	{
		if(isset($_POST['Submit']) && isset($_POST['id']))
		{
			redirect('new_csr/home/metro_orders_submit/'.$_POST['id']);
		}else{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['metro_orders'] = $this->db->query("Select * from `metro_orders` where `approve`='0' AND `timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->result_array();
			}else{
				$today = date('Y-m-d');
				$pday = date('Y-m-d', strtotime(' -30 day'));
				$data['metro_orders'] = $this->db->query("Select * from `metro_orders` where `approve`='0' AND `timestamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
			}
			$this->load->view('new_csr/metro_orders', $data);
		}
	}
	
	public function metro_orders_submit($id='')
	{
		if(isset($_POST['order_submit']) && isset($_POST['id']))
		{
			$art = $_POST['artinst'];
			$adtype = $_POST['adtype'];
			
			$size = $_POST['width'] * $_POST['height'];
			if($size == '0')
			{
				$this->session->set_flashdata("message","Provide Proper values for Width and Height!!!");
				redirect('csr/home/metro_orders_submit/'.$_POST['id']);
			}
				
						
			$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
			if($orders){
				$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
				redirect('new_csr/home/metro_orders');
			}else{
				$adrep_pub = EXPLODE('_',$_POST['adrep']);
				$adrep_id = $adrep_pub[0];
				$publication_id = $adrep_pub[1];
				$pub_details = $this->db->get_where('publications',array('id' => $publication_id))->result_array();
				$help_desk = $pub_details[0]['help_desk'];
				//orders table
				//$metro_slug_name1 = str_replace(' ', '_', $_POST['job_name']); // Replaces all spaces with underscores.
				$_POST['job_name'] = preg_replace('/[^A-Za-z0-9\+s]/', '_', $_POST['job_name']);
				//$metro_orders = $this->db->get_where('metro_orders',array('id' => $id))->result_array();
				
				if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				} else {
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				
				if($_POST['order_type'] == '1'){ //web
					$post = array(
								'adrep_id' => $adrep_id,
								'csr' => $this->session->userdata('sId'),
								'publication_id' => $publication_id,
								'group_id' => $pub_details[0]['group_id'],
								'help_desk' => $help_desk,
								'publication_name' => $_POST['publication_name'],
								'order_type_id' => '1', //web
								'advertiser_name' => $_POST['advertiser'],
								'job_no' => $_POST['job_name'],
								'pixel_size' => 'custom',
								'custom_width' => $_POST['width'],
								'custom_height' => $_POST['height'],
								'print_ad_type' => $_POST['color'],
								'publish_date' => $publish_date,
								'club_id'=> $pub_details[0]['club_id'],
							);
				}else{ //print
					$post = array(
								'adrep_id' => $adrep_id,
								'csr' => $this->session->userdata('sId'),
								'publication_id' => $publication_id,
								'group_id' => $pub_details[0]['group_id'],
								'help_desk' => $help_desk,
								'publication_name' => $_POST['publication_name'],
								'order_type_id' => '2', //default print
								'advertiser_name' => $_POST['advertiser'],
								'job_no' => $_POST['job_name'],
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								'print_ad_type' => $_POST['color'],
								'publish_date' => $publish_date,
								'club_id'=> $pub_details[0]['club_id'],
							);
				}
				$this->db->insert('orders',$post);	
				$order_no = $this->db->insert_id();	
				//cat_result table
				if($order_no)
				{
					//Live_tracker updation
					$tracker_data = array(
						'pub_id'=> $pub_details[0]['id'],
						'order_id'=> $order_no,
						'job_no' => $_POST['job_name'],
						'club_id'=> $pub_details[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
					$post = array('approve' => '1');
					$this->db->where('id', $_POST['id']);
					$this->db->update('metro_orders', $post);
					
					$data = array();
					for($i=0;$i<5;$i++)	//file data sent to file_upload function
					{
						if (!empty($_FILES['ufile']['tmp_name'][$i]))
						{
							$data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
							$data['fname'.$i] = $_FILES['ufile']['name'][$i];
						}
					}
					if(isset($_POST['attachfile'])){
						$attachfile_count = count($_POST['attachfile']);
						if($attachfile_count > '0'){
							$data['attachfile_count'] = $attachfile_count;
							for($i=0;$i<$attachfile_count;$i++)	//metro attach file data sent to file_upload function
							{
								$data['attachfile'.$i] = $_POST['attachfile'][$i]; 
							}
						}
					}
					$this->orders_folder($order_no);// folder, html_form
					$data['id'] = $order_no;
					$this->file_upload($data); //file uploads
					
					$category = $this->cat_calc($adtype);	//category calculation			
						$news_id = $pub_details[0]['news_id'];
						$initial = $pub_details[0]['initial'];
						$slug_type = $pub_details[0]['slug_type'];
						$team = $pub_details[0]['design_team_id'];
					$dataa = array(
								'order_no' => $order_no,
								'job_name' => $_POST['job_name'],
								'adrep' => $adrep_id,
								'advertiser' => $_POST['advertiser'], 
								'width' => $_POST['width'],
								'height' => $_POST['height'],
								'artinstruction' => $_POST['artinst'],
								'adtypewt' => $_POST['adtype'],
								'help_desk' => $help_desk,
								'publication_id' => $publication_id,
								'news_id' => $news_id,
								'news_initial' => $initial,
								'instruction' => $_POST['instruction'],
								'team' => $team,
								'slug_type' => $slug_type,
								'category' => $category,
								'csr' => $this->session->userdata('sId'),
								'date' => Date("Ymd"),
								'time' => date("His")
								);
					$this->db->insert('cat_result',$dataa);	
					$cat_id = $this->db->insert_id();
					
					if($cat_id)
					{
						//order status
						$post_status = array('status' => '2');
						$this->db->where('id', $order_no);
						$this->db->update('orders', $post_status);
						
						//Live_tracker Updation
						$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
						if(isset($update_order['id'])){
							$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
							$this->db->where('id', $update_order['id']);
							$this->db->update('live_orders', $tracker_data);
						}
				
						
						$status = 'v1';
						$data2 = array(
									'order_no' => $order_no,
									'csr' => $this->session->userdata('sId'),
									'news_id' => $news_id,
									'publication_id'  => $publication_id,
									'help_desk'  => $help_desk,
									'date' => Date("Ymd"),
									'time' => date("His"),
									'category' => $category
									);
						$this->db->insert('cshift',$data2);
					}else{ 
						$this->session->set_flashdata("message","Order not been categorised!!!");
						redirect('new_csr/home/metro_orders'); 
					}
				}else{
					$this->session->set_flashdata("message","Order not Placed.. Try again!!!");
					redirect('new_csr/home/metro_orders');
				}
				$this->session->set_flashdata("message","Order Placed and Categorised Sucessfully!!!<br/>Order No: $order_no");
				redirect('new_csr/home/metro_orders');
			}	
		}elseif($id!=''){
			$metro_orders = $this->db->get_where('metro_orders',array('id' => $id))->result_array();
			$data['metro_orders'] = $metro_orders;
			$this->load->view('new_csr/metro_submit', $data);
		}
	}
	
	public function metro_order_search() 
	{
		if(isset($_POST['search']) && !empty($_POST['id'])){
			$metro_id = str_replace('-','_',$_POST['id']);
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
									FROM `orders` WHERE `help_desk` = '2' AND (`job_no` LIKE '%$metro_id%');")->result_array();
			if($orders){
				redirect('new_csr/home/orderview/'.$orders[0]['help_desk'].'/'.$orders[0]['id']);
			}else{
				$this->session->set_flashdata("metro_message","Order not Found for : ".$_POST['id']);
				redirect('new_csr/home/cshift/2');
			}
		}
	}
	
	public function metro_job_search() 
	{ 
		if(isset($_POST['search2']) && !empty($_POST['id2'])){
			$metro_id = str_replace('-','_',$_POST['id2']);
			$data['metro_id'] = explode(' ',$metro_id);
		}
		$this->load->view('new_csr/metro_job_search',$data);
	}
	
	public function metro_revision($form)
	{
		if(!empty($_GET['orderId']))
		{ 
			$order_no = str_replace('-','_',$_GET['orderId']);
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE `id` LIKE '$order_no%' OR `job_no` LIKE '%$order_no%' OR `advertiser_name` LIKE '$order_no%'")->result_array();
			//$orders = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '2' AND (`job_no` LIKE '%$order_no%');")->result_array();
			if($orders){ 
				$data['orders'] = $orders;  $data['form'] = $form;
			}else{
				$this->session->set_flashdata("message","No Orders Found for $order_no");
				redirect('new_csr/home/frontlinetrack_order_list/'.$form);
			}
			$this->load->view('new_csr/metro_revision',$data);
		}
		 
	}


	public function metro_sold($form='')
	{
		if(isset($_POST['order_id'])){ $order_id = $_POST['order_id']; }
		//Send to adrep process for sold ad
		if(isset($_POST['end_sold_QA'])){
			$end_timestamp = date("Y-m-d H:i:s");
			$sent_time = date("H:i:s");
					
			$data3 = array( 'sent_time' => $sent_time,
							'frontline_csr' => $this->session->userdata('sId'),
							'status' => '5',
							'end_timestamp' => $end_timestamp
							);
			$this->db->where('id', $_POST['rev_id']);
			$this->db->update('rev_sold_jobs', $data3);
			
			//Live_tracker Revision Updation
			$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
					if(isset($update_revision['id'])){
						$this->db->query("DELETE FROM `live_revisions` WHERE `id`= '".$update_revision['id']."'");
					}
			
			$jobs = $this->db->get_where('rev_sold_jobs',array('id' => $_POST['rev_id'], 'job_status' => '1'))->result_array();
			$time = ($jobs[0]['date'].' '.$jobs[0]['time']) ;
			
			 //converting to time
			$start = strtotime($time);
			$end = strtotime($end_timestamp);

			//calculating the difference
			$time_taken = abs($end - $start);

			$data2 = array( 'time_taken' => $time_taken );
			$this->db->where('id', $_POST['rev_id']);
			$this->db->update('rev_sold_jobs', $data2);
			$this->session->set_flashdata('sold_status','<span class="alert alert-success" style="padding: 5px 10px !important; margin-left: 20px; font-size: 14px;">Completed</span>');
			redirect('new_csr/home/frontlinetrack_order_list/'.$form);
		}
		//cancel sold
		if(isset($_POST['cancel_sold']) && !empty($_POST['rev_id'])){
			$this->db->query("DELETE FROM `rev_sold_jobs` WHERE `id` = '".$_POST['rev_id']."'");
			redirect('new_csr/home/orderview/'.$form.'/'.$_POST['order_id']);
		}
		
		//submit sold
		$check = $this->db->get_where('rev_sold_jobs',array('order_id' => $order_id, 'category' => 'sold'))->result_array();
		$orders = $this->db->get_where('orders',array('id' => $order_id))->result_array();//adrep details
		$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
		if(!$orders_rev){
			$version = 'V1';
		}else{
			$version = $orders_rev[0]['version'];
		}
		//if(!$check)
		//{
			if (function_exists('date_default_timezone_set'))
			{
				//date_default_timezone_set('America/New_York');
			}
			$tday = date('Y-m-d');
			$time = date("H:i:s");
			$data = array(
					'adrep' => $orders[0]['adrep_id'],
					'csr' => $this->session->userdata('sId'),
					'order_id' => $order_id,
					'help_desk' => $form,
					'order_no' => $_POST['order_no'], 
					'date' => $tday,
					'time' => $time,
					'version' => $version,
					'category' => 'sold',
					'job_accept' => '1',
					'status' => '8'
					);
			$this->db->insert('rev_sold_jobs', $data);
			$this->session->set_flashdata('sold_status','<span class="alert alert-success" style="padding: 5px 10px !important; margin-left: 20px; font-size: 14px;">Submitted</span>');
			redirect('new_csr/home/frontlinetrack_order_list/'.$form);
		//}else{
		//	$this->session->set_flashdata('sold_status','<span class="alert alert-success" style="padding: 5px 10px !important; margin-left: 20px; font-size: 14px;">Already Revised</span>');
			redirect('new_csr/home/frontlinetrack_order_list/'.$form);
		//}		
	}

	public function metro_sold_order($form='',$order_id='')
	{
		$order_id = $order_id; 
		$sId = $this->session->userdata('sId');
		$date = date("Y-m-d");
		$timestamp = date("H:i:s");
		if(!empty($_POST['rev_id'])){ $rev_id = $_POST['rev_id']; }else{ $rev_id = '0'; }
		$data = array(
				'order_id' => $order_id,
				'csr' => $sId,
				'rev_id' => $rev_id,
				'timestamp' =>$timestamp,
				'help_desk' => $form,
				'date' => $date,
				'sold_pdf' => $_POST['sold_pdf'],
				'job_no' => $_POST['job_name']
				);
		$this->db->insert('sold_orders', $data);
		$sold_orders_id = $this->db->insert_id();
		if($sold_orders_id){
			$this->session->set_flashdata('sold_status','<span class="alert alert-success" style="padding: 5px 10px !important; margin-left: 20px; font-size: 14px;">Submitted</span>');
			redirect('new_csr/home/sold_track/'.$form);
		}else{
			$this->session->set_flashdata('sold_status','<span class="alert alert-success" style="padding: 5px 10px !important; margin-left: 20px; font-size: 14px;">Error..!!</span>');
			redirect('new_csr/home/sold_track/'.$form);
		}
		
		
	}
	
	public function sold_track($form = '' ,$display_type = 'all')
	{
		$data['display_type'] = $display_type;
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
		
		if($form!='')
		{
			$data['form'] = $form;
			$timestamp = date("H:i:s");
			if(isset($_POST['date'])){ $data['date'] = $_POST['date']; }
			if(isset($_POST['end']))	//new
			{
				$post = array( 'end_timestamp' => $timestamp, 'end_csr' => $this->session->userdata('sId') );
				$this->db->where('id', $_POST['id']);
				$this->db->update('sold_orders', $post);
				redirect('new_csr/home/sold_track/'.$form);
			}
			
			if(isset($_POST['display_type']))
			{
				$data['display_type'] = $_POST['display_type'];
			}
			$this->load->view('new_csr/sold_track',$data);
		}
	}
	
	public function metro_source_move() 
	{
		if(isset($_POST['move_source'])){
		$metro_orders = $this->db->get_where('sourcefile_move',array('status'=>'0'))->result_array();
		if($metro_orders){
		foreach($metro_orders as $row){
			$order_id = $row['order_id'];
			$new_slug = $row['slug'];
			$SourceFilePath = $row['path'];
			$source_file = $new_slug.'.indd';
			$pdf_file = $new_slug.'.pdf';
				
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path, FALSE);
			}else{ 
				$this->load->helper('directory');	
				$map = glob($SourceFilePath.'/'.$new_slug.'.{indd,psd}',GLOB_BRACE);
				if($map){ foreach($map as $row_src){
					$this->zip->read_file($row_src, FALSE);
				} } 
			}
			
			if(file_exists($pdf_path)){
				$this->zip->read_file($pdf_path, FALSE);
			}else{ 
				$this->load->helper('directory');	
				$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
				if($map){ foreach($map as $row_pdf){
					$this->zip->read_file($row_pdf, FALSE);
				} } 
			}
			
			$map_font = directory_map($font_path.'/');
			$map_link = directory_map($links_path.'/');
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){
				$this->zip->read_dir($links_path, FALSE);
			}
			$zip_file = $SourceFilePath.'/'.$new_slug.'.zip';
			$this->zip->archive($zip_file);
			$this->zip->clear_data();
			
			if(file_exists($zip_file)){
				//if($row['hd']=='2'){ $hd = 'Metro'; }elseif($row['hd']=='5'){ $hd = 'Design6'; }elseif($row['hd']=='16'){ $hd = 'Design7'; }else{ $hd = 'Demo'; }
				if($row['hd']=='2'){ $hd = 'Metro'; }/* elseif($row['hd']=='5'){ $hd = 'Design6'; }elseif($row['hd']=='16'){ $hd = 'Design7'; } */
						
				$ftp_server = 'ftps1a4l1.adwitads.com';
				if(!ftp_connect($ftp_server)){
					$ftp_server = 'ftps1a4l2.adwitads.com';
					if(!ftp_connect($ftp_server)){
						$ftp_server = 'ftps1a4l3.adwitads.com';
					}
				}
				$ftp_username='annexe2017';
				$ftp_userpass='ftp@123';
				$folder_name = 'Adwit-source/'.$hd;
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
						
				$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
				$path = $folder_name.'/'.date('Y-m-d');
						
				if(ftp_size($ftp_conn, $path) < '0'){ //file doesnt exists
					if (@ftp_mkdir($ftp_conn, $path))
					{
									
					}
				}	
				$fname = $new_slug.'.zip';
				if(@ftp_put($ftp_conn, $path.'/'.$fname, $zip_file, FTP_BINARY)){ }else{ }
						
				//ftp_close($ftp_conn); // close connection 
				
				$data = array('status' => '1');
				$this->db->where('id', $row['id']);
				$this->db->update('sourcefile_move', $data);
			}
			
		}ftp_close($ftp_conn); // close connection 
		}else{ echo"No Orders To Move"; }
		}else{
			$this->load->view('new_csr/metro_source_move');
		}
	} 
	
	public function orderview($hd="",$order_id="")
	{ 
		$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,
		orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,
		orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,
		orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,
		orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,
		orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,
		orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,
		orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,
		orders.project_id,orders.approved_time,orders.activity_time,orders.flexitive_size,orders.club_id
																FROM `orders` WHERE `id`= '$order_id' ")->result_array();
																
		$help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
		$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
		$data['help_desk']= $help_desk;
		if($hd != '' && $hd != '0' && $order_id != '' && isset($orders[0]['id']))
		{ 
		    //PDF Annotation
		    $order_annotation = "order_annotation/csrProof-".$order_id."-".$orders[0]['job_no'].".pdf";
    		if(file_exists($order_annotation)){
    			$data['oa_fname'] = basename($order_annotation);
    			$data['oa_url'] = base_url().$order_annotation;
    		}
		    $data['csr_to_adrep_options'] = $this->db->query("SELECT * FROM `csr_to_adrep_options` WHERE `is_active`='1'")->result_array(); //for pdf review
		    if($orders[0]['order_type_id'] == '1'){ //multiple size web ads
    		    if($orders[0]['ad_format']=='5'){ //flexitive ad (flexitive size)
    		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, flexitive_size.ratio, flexitive_size.ratio AS name FROM `orders_multiple_size`
                    							                LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
                    							                    WHERE orders_multiple_size.order_id = '".$orders[0]['id']."'")->result_array();
    		    }else{ //pixel size
    		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, pixel_sizes.width, pixel_sizes.height, CONCAT(pixel_sizes.width,'x',pixel_sizes.height) AS name FROM `orders_multiple_size`
                    							            LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
                    							                WHERE orders_multiple_size.order_id = '".$orders[0]['id']."'")->result_array();
    		    }
    		    
    		    $orders_multiple_custom_size = $this->db->query("SELECT *, CONCAT(custom_width,'x',custom_height) AS name FROM `orders_multiple_custom_size` WHERE `order_id` = '".$orders[0]['id']."'")->result_array();
                
                if(isset($orders_multiple_size[0]['id'])){
                   $data['orders_multiple_size'] = $orders_multiple_size;
                }
                if(isset($orders_multiple_custom_size[0]['id'])){
                   $data['orders_multiple_custom_size'] = $orders_multiple_custom_size; 
                }
    		}
    		
		    if($orders[0]['publication_id'] == 580){ //Waukesha Freeman publication
		        $preorders_waukesha = $this->db->query("SELECT * FROM `preorders_waukesha` WHERE `adwit_id` = '$order_id'")->row_array();
		    }
			// Mood Board/Theme Code starts 
        		$order_mood = $this->db->query("SELECT * FROM `order_mood` WHERE `order_id`= '$order_id' ")->row_array();
        		if(isset($order_mood['id'])){
        			$data['order_mood'] = $order_mood;
        			
        			if(file_exists($order_mood['path'])){
        				$data['moodboard_path'] = $order_mood['path'];
        				$data['moodboard_filename'] = basename($data['moodboard_path']);
        			}
        		}
    		//Mood Board/Theme Code ends
			
			$this->load->helper('directory');
			$redirect = 'new_csr/home/orderview/'.$hd.'/'.$order_id;
			$data['redirect']= $redirect;
			
			$redirect_cshift = 'new_csr/home/live_new_ads/QA';	//redirect to live_new_ads page
			/*if($csr_alias[0]['club_id'] != null) {
				$redirect_cshift = 'new_csr/home/live_new_ads';	//redirect to live_new_ads page
			}elseif($orders[0]['order_type_id']=='1'){
				$redirect_cshift = 'new_csr/home/web_cshift/QA';	//redirect to web_cshift page
			}else{
				$redirect_cshift = 'new_csr/home/cshift/'.$hd.'/QA';	//redirect to cshift QA page
			}*/
		
			$data['order_id']= $order_id; 
			$data['hd']= $hd;
			if(!$orders){
				$this->session->set_flashdata("message","Order: Details not Found!!");
				redirect($redirect_cshift);
			}
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->result_array();
			if(isset($rev_orders[0]['id'])){
				$data['rev_orders'] = $rev_orders;
			}
				//$data['rev_order_form'] = $rev_orders[0]['file_path'];
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			$rev_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			$data['rev_rev'] = $rev_rev;
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			$data['orders'] = $orders; 
			$data['fname'] = $this->db->get_where('print_ad_types',array('id' => $orders[0]['print_ad_type']))->result_array();
			$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
			$data['adrep_name'] = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
			
			$data['csr_alias'] = $csr_alias; 
			$job_no= $orders[0]['job_no'];
			$downloads = $orders[0]['file_path'];
			$pickup_downloads = "downloads/pickup/".$order_id;
			$pickup_map_downloads = directory_map($pickup_downloads.'/');
			if($pickup_map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['pickup_downloads']= $pickup_downloads; 
			}
			$map_downloads = directory_map($downloads.'/');
			if($map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['downloads']= $downloads; 
			}
			/************************************ categorise order ****************************************/
			if(isset($order_id) && isset($_POST['confirm'])){ //categorise order
				$this->cshift_category($order_id);
			}
			/************************************ revision-submit *****************************************/
			if(isset($_POST["submit"]) && !empty($_POST['order_id'])){	
				$this->rev_orders($order_id);
			}
			/************************************ revision send to designer, adrep ************************/
			if((isset($_POST['sendToadrep']) && !empty($_POST['rev_id'])) || (isset($_POST['rev_sent_designer']) && isset($_POST['msg'])) ||
			(isset($_POST['accept'])) || (isset($_POST['cancel_submit']))){
				$this->rev_orderview($hd, $order_id);
			}
			//revision proof check CSR entry
			if(isset($_POST['revision_proof_check']) && !empty($_POST['revision_id'])){
    		    if($rev_rev[0]['frontline_csr'] == '0'){
    					$csr_QA_timestamp = date("Y:m:d H:i:s");
    					$proof_data = array('frontline_csr' => $this->session->userdata('sId'));
    					$this->db->where('id', $_POST['revision_id']); 
    					$this->db->update('rev_sold_jobs', $proof_data);
    			}else{
    				$this->session->set_flashdata("message","Proof Check already assigned!!");
    			}
    			redirect($redirect);
			}
			/************************************ To Designer - Back to Designer  **************************/
			if(isset($_POST['sent_designer']) && isset($_POST['msg']))
	        {			
				$csr_file_path = 'none'; $dc_file_path = 'none';
				if(isset($_FILES['file2']['name']) && !empty($_FILES['file2']['name']))	
				{ 
					$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['file2']['name']); 
					$ext = '.'.$ext;
					$file_format = $this->db->get('file_format')->result_array();
					$up_load = '0';
					foreach($file_format as $format){
						if($format['name'] == $ext){ $up_load = '1'; }
					}
					if($up_load == '1'){
						
							$sourcefile = $_POST['sourcefile'];
							
							$dir2 = $sourcefile.'/csr_change'; 
							$csr_file_path = $dir2.'/'.$_FILES['file2']['name'];
							
							$dir3 = $sourcefile.'/DC_change';
							$dc_file_path = $dir3.'/'.$_FILES['file2']['name'];
							
							if($_POST['sent_designer']=='3'){
							    if (@mkdir($dir2,0777)){}
								move_uploaded_file($_FILES['file2']['tmp_name'], $csr_file_path);
							}else{
							    if (@mkdir($dir3,0777)){}
								move_uploaded_file($_FILES['file2']['tmp_name'], $dc_file_path);
							}
						
					}else{
						$this->session->set_flashdata("ext_message", $ext." Extension not allowed.. Please upload only allowed file types.. Try Again!!");
						redirect($redirect);
					}
				}				
				$time = date("Y:m:d H:i:s");
				if($_POST['msg'] == 'others'){
					$msg = $_POST['csr_msg'];
				}else{
					$msg = $_POST['msg'].'-'.$_POST['csr_msg'];
				}
				if($_POST['sent_designer']=='3'){
					$data2 = array('order_id'=> $order_id , 'message'=>  $msg ,  'csr_id'=>$this->session->userdata('sId') , 'operation' =>'QA_designer', 'file_path' => $csr_file_path);
				}else{ 
					$data2 = array('order_id'=> $order_id , 'message'=>  $msg ,  'dc_id'=>$this->session->userdata('sId') , 'operation' =>'DC_designer', 'file_path' => $dc_file_path);
				}
				$this->db->insert('production_conversation', $data2);
				$data1 = array('pro_status'=> '7'); //changes from CSR
				$this->db->where('order_no', $order_id); 
				$this->db->update('cat_result', $data1);
				
				if($cat[0]['csr_QA'] == '0'){
					$data2 = array('csr_QA'=> $this->session->userdata('sId')); //changes from CSR
					$this->db->where('order_no', $order_id); 
					$this->db->update('cat_result', $data2);
				}
				$post_status = array('status' => '3'); //inproduction status
				$this->db->where('id', $order_id); 
				$this->db->update('orders', $post_status);
				
				//Live_tracker Updation
				$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
				if(isset($update_order['id'])){
					$tracker_data = array('status' => '3', 'pro_status'=> '7', 'csr_QA'=> $this->session->userdata('sId'));
					$this->db->where('id', $update_order['id']);
					$this->db->update('live_orders', $tracker_data);
				}
				
				$this->session->set_flashdata("message","Sent successfully!!!");
				redirect($redirect_cshift);
	        }   
			
			if(isset($_POST['send_DC']) && isset($_POST['QA_msg']))
			{				
				if($_POST['QA_msg'] == 'others'){		
				$msg = $_POST['DC_reason'];			
				}else{				
				$msg = $_POST['QA_msg'];			
				}
				//reason insertion
				$dataa = array(
					'order_id' => $order_id,
					'csr_id' => $this->session->userdata('sId'),
					'message' => $msg,
					'operation' =>'QA_DC'
				);
				$this->db->insert('production_conversation',$dataa);
				/* $dataa = array(
					'order_id' => $order_id,
					'csr' => $this->session->userdata('sId'),
					'reason' => $_POST['DC_reason'],
				);
				$this->db->insert('dc_reason',$dataa); */
				//Production status
				$pro_status = array('pro_status' => '4');
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $pro_status);
				
				//Live_tracker Pro-status Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('pro_status' => '4', 'csr_QA'=> $this->session->userdata('sId'));
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
				if($cat[0]['csr_QA'] == '0'){
					$data2 = array('csr_QA'=> $this->session->userdata('sId')); //changes from CSR
					$this->db->where('order_no', $order_id); 
					$this->db->update('cat_result', $data2);
				}
				
				redirect($redirect_cshift);
			}  
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			$adtype = $this->db->get('cat_new_adtype')->result_array();
				$artinst = $this->db->get('cat_artinstruction')->result_array();
				$data['adtype'] = $adtype;
				$data['artinst'] = $artinst;
			if(!$cat)
			{
				$data['cat_pending']='cat_pending';
				
				$data['ad_subject'] = $this->db->query("SELECT * FROM `ad_subject` ORDER BY `subject` ASC ")->result_array();
			}else{
    			$data['cat'] = $cat;
    			if($cat[0]['designer']!='0') $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();
    			if($cat[0]['csr']!='0') $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr']."'")->result_array();
    			if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
    			//if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
    			$cp_tool = $this->db->query("SELECT * from `cp_tool` where `order_no` = '$order_id' ")->result_array();
    			if($cp_tool){
    				$data['cp_tool'] = $cp_tool;
    				$data['csr_name1'] = $this->db->get_where('csr',array('id' => $cp_tool[0]['csr']))->result_array();
    			}
    			$log_csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$cat[0]['csr_QA']."' ")->result_array();
    			if(($log_csr) && ($cat[0]['csr_QA']!= $this->session->userdata('sId'))){
    				$log_csr_name = $log_csr[0]['name'];
    				$data['proofing_msg'] = "$log_csr_name is Proofing this Ad";
    			} 
    			//$data['tag_csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
    			$dc_reason = $this->db->query("SELECT * from `dc_reason` where `order_id` = '$order_id' ")->result_array();
    		 	if($dc_reason){
    				$data['dc_reason'] = $dc_reason;
    			} 
    			$qa_reason = $this->db->query("SELECT * from `qa_reason` where `order_id` = '$order_id' ")->result_array();
    		 	if($qa_reason){
    				$data['qa_reason'] = $qa_reason;
    			}
    			$designer_message = $this->db->query("SELECT * from `designer_message` where `order_id` = '$order_id' ")->result_array();
    		 	if($designer_message){
    				$data['designer_message'] = $designer_message;
    			} 
    			//$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
    			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
    			$data['cancel_reason'] = $this->db->get('cancel_reason')->result_array();			
    			$data['note_csr_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_designer'))->result_array();			
    			$data['note_csr_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_dc'))->result_array();
    			/******************proof check for untagged CSRs************************/
    			if(isset($_POST['proof_check']) && !empty($_POST['order_id'])){
    				if($cat[0]['csr_QA'] == '0'){
    					$csr_QA_timestamp = date("Y:m:d H:i:s");
    					$proof_data = array('csr_QA' => $this->session->userdata('sId'), 'csr_QA_timestamp' => $csr_QA_timestamp);
    					$this->db->where('order_no', $order_id); 
    					$this->db->update('cat_result', $proof_data);
    					
    					//Live_tracker Pro-status Updation
    					$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
    					if(isset($update_order['id'])){
    						$tracker_data = array('csr_QA'=> $this->session->userdata('sId'));
    						$this->db->where('id', $update_order['id']);
    						$this->db->update('live_orders', $tracker_data);
    					}
    					//change status from In queue for QA to Quality check
    					if($orders[0]['publication_id'] == '13'){ 
    					    $post_status = array('status' => '4'); //Quality check status
        					$this->db->where('id', $order_id); 
        					$this->db->update('orders', $post_status);
        					
        					if(isset($update_order['id'])){
    						    $tracker_data = array('status'=> '4');
    						    $this->db->where('id', $update_order['id']);
    						    $this->db->update('live_orders', $tracker_data);
    					    }
    					}
    				}else{
    					$this->session->set_flashdata("message","Proof Check already assigned!!");
    				}
    				redirect($redirect);
			    }
    			/**************************** Take Over csr *****************************/
    			if(isset($_POST['untag_csr']) && !empty($_POST['order_id'])){
    				$untag_data = array('csr_QA'=> $this->session->userdata('sId'));
    				$this->db->where('order_no', $order_id); 
    				$this->db->update('cat_result', $untag_data);
    				//Live_tracker Pro-status Updation
    				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
    					if(isset($update_order['id'])){
    						$tracker_data = array('csr_QA'=> $this->session->userdata('sId'));
    						$this->db->where('id', $update_order['id']);
    						$this->db->update('live_orders', $tracker_data);
    					}
    				redirect($redirect);
    			}
    			//tag csr
    			if(isset($_POST['tag_csr'])){
    			$tag_data = array('tag_csr'=> $_POST['tag_csr']);
    				$this->db->where('order_no', $order_id); 
    				$this->db->update('cat_result', $tag_data);
    				redirect($redirect);
    			}
    			//note sent
    			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
    			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
    			if($orders[0]['file_path'] != 'none'){
    			    $data['order_form'] = $orders[0]['file_path'];
    			}
    			if($cat[0]['slug']!='none' || $cat[0]['slug']!=''){
    				$slug = $cat[0]['slug'];
    				$job_name = $cat[0]['job_name'];
    				$advertiser_name = $cat[0]['advertiser'];
    				$data['slug'] = $slug;
    				$sourcefile = "sourcefile/".$order_id.'/'.$slug;
    				$map_sourcefile = directory_map($sourcefile.'/');
    				if($map_sourcefile){ 
    					$data['sourcefile']= $sourcefile;
    					//pdf annotation
    					$this->load->helper('directory');	
        			    $map_src_pdf_file = glob($sourcefile.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
        			    if($map_src_pdf_file){ 
        			       foreach($map_src_pdf_file as $rowMap){ 
        			           $pdf_src_file = $rowMap; $data['pdf_name'] = basename($rowMap); 
        			       }
        			       $data['pdf_annotation_url'] = base_url().$pdf_src_file; //echo $data['pdf_annotation_url'];
        			    }
    				}
    				$data['tl_path'] = $sourcefile.'/Tl_change';
    				$data['csr_path'] = $sourcefile.'/csr_change';
    				$data['dc_path'] = $sourcefile.'/DC_change';
    				//changes from TL
    				$tl_path = $sourcefile.'/Tl_change';
    				$map_tl_path = directory_map($tl_path.'/');
    				if($map_tl_path){ $data['tl_path']= $tl_path; }
    				
    				//changes from CSR
    				$csr_path = $sourcefile.'/csr_change'; 
    				$map_csr_path = directory_map($csr_path.'/');
    				if($map_csr_path){ $data['csr_path']= $csr_path; }
    				
    				if($rev_orders){
    				    $rev_csr_path = $sourcefile.'/csr_change_'.$rev_orders[0]['id'];
    				    $map_rev_csr_path = directory_map($rev_csr_path.'/');
    				    if($map_rev_csr_path){ $data['rev_csr_path']= $rev_csr_path; }
    				    if(isset($rev_rev[0]['id']) && $rev_rev[0]['pdf_file'] != 'none'){
    				        $rev_slug = $rev_rev[0]['new_slug'];
    				        $rev_pdf_full_path = $sourcefile.'/'.$rev_slug.'.pdf';
            			    if(file_exists($rev_pdf_full_path)){ 
            			       $data['pdf_name'] = basename($rev_pdf_full_path);  
            			       $data['pdf_annotation_url'] = base_url().$rev_pdf_full_path; //echo $data['pdf_annotation_url'];
            			    }    
            		    }
    				}
    				//changes from DC CSR
    				$dc_csr_path = $sourcefile.'/DC_change'; 
    				$map_dc_csr_path = directory_map($dc_csr_path.'/');
    				if($map_dc_csr_path){ $data['dc_csr_path']= $dc_csr_path; } 
    			}
		    }
		    
		    /************************* Send To Adrep ****************************/
    		if(isset($_POST['end_time']))
    		{
    			//orderview lock screen table entry deletion
    			/* if(isset($log_details) && $log_details){
    			$this->db->where('id', $log_details[0]['id']);
    			$this->db->delete('orderview_log_csr');
    			} */
    			
    			$date = date('Y-m-d');
    			$st_time = 	date("H:i:s");
    			$data['st_time'] = $st_time;
    			$dataa = array(
    							'csr' => $this->session->userdata('sId'),
    							'designer' => $cat[0]['designer'], 
    							'order_no' => $order_id,
    							'cat_result_id' => $cat[0]['id'],
    							'start_time' => $st_time,
    							'date' => $date,
    							'job_status' => 'Inprogress',
    							);
    			$this->db->insert('cp_tool', $dataa);
    			$cp_tool_id = $this->db->insert_id();
    			/*if($cp_tool_id)
    			{
    				$end_time = date("H:i:s");				
    				$cp = $this->db->get_where('cp_tool',array('id' => $cp_tool_id,'csr' => $this->session->userdata('sId')))->result_array();
    				$dp_wt = $this->db->get_where('print',array('name' => 'TWEAK'))->result_array();
    				$stime = $cp[0]['start_time'];
    				$etime = $end_time;
    				$nextDay=$stime>$etime?1:0;
    				 $dep=EXPLODE(':',$stime);
    				 $arr=EXPLODE(':',$etime);
    				 
    				 $diff=ABS(TIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-TIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
    				 
    				 $hours=FLOOR($diff/(60*60));
    				 $mins=FLOOR(($diff-($hours*60*60))/(60));
    				 $secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
    				 IF(STRLEN($hours)<2){$hours="0".$hours;}
    				 IF(STRLEN($mins)<2){$mins="0".$mins;}
    				 IF(STRLEN($secs)<2){$secs="0".$secs;}
    				$time_min=$hours*60+$mins;
    				$time_hr = $time_min / 60 ;
    				//$cp = $time_hr / $dp_wt[0]['wt'];
    				$data = array(
    							'end_time' => $end_time,
    							'time_taken' => $time_min,
    							'cp' => $cp,
    							'job_status' => "Done",
    							);
    				$this->db->where('id', $cp_tool_id);
    				$this->db->update('cp_tool', $data);
    			}*/
    			//File upload in pdf_upload folder
    			
    			$sourcefile = "sourcefile/".$order_id.'/'.$slug;
    			//$map_sourcefile = directory_map($sourcefile.'/');
    			
    				    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
    				        /*$package_zip_file = $sourcefile.'/'.$slug.'.zip';
    				        if(file_exists($package_zip_file)){
    				            $pdf_uploads = "pdf_uploads/".$order_id ;
        			            if (@mkdir($pdf_uploads,0777)){} 
        			            copy($package_zip_file, $pdf_uploads.'/'.$slug.'.zip');
    				        }else{
        				        if($this->multiple_zip_folder_select($order_id)==true){
            						$pdf_uploads = "pdf_uploads/".$order_id;
            					}else{ 
            						$this->session->set_flashdata("message","Error uploading source to Adrep!!");
            						redirect($redirect);
            					}
    				        }*/	
    				        
    				        if($this->multiple_zip_folder_select($order_id)==true){
        						$pdf_uploads = "pdf_uploads/".$order_id;
        					}else{ 
        						$this->session->set_flashdata("message","Error uploading source to Adrep!!");
        						redirect($redirect);
        					}
    				    }else{
    				       /* if($order_id == '1202760'){
    				        $pdf_uploads = "pdf_uploads/".$order_id;
    				        $pdf_file = $slug.'.pdf';
    				        $pdf_path = "sourcefile/".$order_id.'/'.$slug.'/'.$slug.'.pdf';
            				if (@mkdir($pdf_uploads,0777)){}
            					if(file_exists($pdf_path)){
            						$upload_pdf = $pdf_uploads.'/'.$pdf_file;
            						copy($pdf_path, $upload_pdf);
            					}
    				        }else{*/
        					if($this->zip_folder_select()==true){
        						$pdf_uploads = "pdf_uploads/".$order_id;
        					}else{ 
        						$this->session->set_flashdata("message","Error uploading source to Adrep!!");
        						redirect($redirect);
        					}
    				        //}
    				    }
    			
    				//if($map_sourcefile){ 
    				
    					$map_pdf_uploads = directory_map($pdf_uploads.'/');
    					if($map_pdf_uploads)
    					{
    						//$pdf_file = "pdf_uploads/".$order_id.'/'.$slug.'.pdf';
    						//$pdf = $slug.'.pdf';
    						if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
    						    $map_pdf_jpg = glob($pdf_uploads.'/'.$slug.'.zip',GLOB_BRACE);
    							if($map_pdf_jpg){ 
    							    foreach($map_pdf_jpg as $row){
    								    $pdf_file = $row; $pdf = $row;
    							    } 
    							}
    						}else{
    						    $map_pdf_jpg = glob($pdf_uploads.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
    							if($map_pdf_jpg){ foreach($map_pdf_jpg as $row){
    								$pdf_file = $row; $pdf = $row;
    							} }
    						}
    						
    						if($orders[0]['help_desk']=='2'){
    							$check_mail = $this->metro_ftp($pdf_file);
    							
    						}elseif(($orders[0]['group_id']=='2' || $orders[0]['group_id']=='4') && ($orders[0]['order_type_id']=='2')){
    						    $type_of_ad = 'new_ad';
    							$response = $this->tscs_send_to_adrep($order_id, $type_of_ad);
    							if($response != 'success'){
    							    $this->session->set_flashdata("message",$response);
    			                    redirect($redirect_cshift);    
    							}
    						}
    						else{
    						    $client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
    						    $publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
    						    $design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
    						    
    					    	$dataa['template'] = $design_team[0]['newad_template'];
    						
        						if($publication[0]['id'] == '47'){ 
        							if(($design_team[0]['newad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
        							    $dataa['subject'] = 'New Ad(Note): '.$job_name.'_'.$advertiser_name;
        							}else{
        							    $dataa['subject'] = 'New Ad: '.$job_name.'_'.$advertiser_name;
        							}
        						}else{
        							if(($design_team[0]['newad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
        							    $dataa['subject'] = 'New Ad(Note): '.$slug ;
        							}else{
        							    $dataa['subject'] = 'New Ad: '.$slug ;
        							}
        						}
        						$dataa['alias'] = $csr_alias[0]['alias'];
        						if($orders[0]['order_type_id'] == '6'){
        						    $dataa['from'] = 'pagination@adwitads.com';
        						    $dataa['replyTo'] = 'pagination@adwitads.com';
        						}else{
        						    $dataa['from'] = $design_team[0]['email_id'];
        						    $dataa['replyTo'] = $design_team[0]['email_id'];
        						}
        						$dataa['from_display'] = 'Design Team';
        						
        						$dataa['replyTo_display'] = 'Design Team';
        						
        						if(!empty($client[0]['email_cc']) || $client[0]['email_cc'] != ''){ $dataa['client_Cc'] = $client[0]['email_cc']; }
        						
        						//$dataa['subject'] = 'New Ad: '.$slug ;
        						$dataa['ad_type'] = 'new' ; 
        						if(isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){ $dataa['note'] = $_POST['note']; } 
        						//Client
        						if($this->session->userdata('sId')=='25'){
        							$dataa['recipient'] = "webmaster@adwitglobal.com";
        						}else{
        							$dataa['recipient'] = $client[0]['email_id']; 
        						}
        						$dataa['version'] = 'V1' ;
						        $dataa['orders'] = $orders[0] ;
        						$dataa['fname'] = $pdf_file; 
        						$dataa['temp'] = $pdf_file; 
        						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
        						$dataa['client'] = $client[0];
        						$dataa['design_team_id'] = $design_team[0]['id'];
        						$dataa['order_id'] = $order_id;
        						if($publication[0]['id'] == '580'){    //Waukesha Freeman
        						    $preorders_waukesha = $this->db->query("SELECT DISTINCT preorders_waukesha.id, preorders_waukesha.adtitle, preorders_waukesha.account_number,  preorders_waukesha_publication.publication FROM `preorders_waukesha`
                                                                                JOIN preorders_waukesha_publication ON preorders_waukesha_publication.xml_file_data_id = preorders_waukesha.id
                                                                                    WHERE preorders_waukesha.adwit_id = '$order_id'")->result_array();
                                    if(isset($preorders_waukesha[0]['id'])){
                                        $dataa['job_num'] = $orders[0]['job_no'];
                                        $dataa['advertiser_name'] = $orders[0]['advertiser_name'];
                                        $dataa['adtitle'] = $preorders_waukesha[0]['adtitle'];
                                        $dataa['preorders_waukesha'] = $preorders_waukesha;
                                        $dataa['publish_date'] = $orders[0]['publish_date'];
                                        $dataa['account_number'] = $preorders_waukesha[0]['account_number'];
                                    }
        						}
        						$this->load->library('Encryption');
        						$dataa['url']= base_url().index_page().'order_rating/home/new_order_rating/'.$this->encryption->encrypt($order_id);
        						
        						$this->test_mail($dataa);
    						
    					    }
        					//order status
        					$pdf_timestamp = date("Y-m-d H:i:s");
        					$post_status = array('status' => '5' , 'pdf' => $pdf, 'activity_time' => date('Y-m-d h:i:s'), 'pdf_timestamp' => $pdf_timestamp);
        					$this->db->where('id', $order_id);
        					$this->db->update('orders', $post_status);
        					
        					//Live_tracker  Updation
        					$update_orders = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
        					if(isset($update_orders['id'])){
        						$this->db->query("DELETE FROM `live_orders` WHERE `id`= '".$update_orders['id']."'");
        					}
    					
        					//map orders status update via cURL
        					if(isset($orders[0]['map_order_id']) && $orders[0]['map_order_id'] != NULL && $orders[0]['map_order_id'] != '0'){
        						$source = null;
        						if(isset($_POST['source_path']) && isset($_POST['new_slug'])){
        							$chk_source = $_POST['source_path'].'/'.$_POST['new_slug'].'.zip';
        							if(file_exists($chk_source)){ $source = 'https://adwitads.com/weborders/'.$chk_source; }
        						}
        						$fields = array(
        										'status' => '5', 
        										'map_order_id' => $orders[0]['map_order_id'],
        										'source' => $source,
        										'file' => new \CurlFile($pdf_file), //pdf send
        										);
        						$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/order_status_update';
        						$this->curl_post($url, $fields); //API using cURL 
        					}
    		
        					//Production status
        					$pro_status = array('pro_status' => '5','pdf_path' => $pdf_file);
        					$this->db->where('order_no', $order_id);
        					$this->db->update('cat_result', $pro_status);
        					
        					//metro_sent_ads insertion
        					if($orders[0]['help_desk']=='2'){
        						$metro_sent_ads = array( 'order_id' => $order_id, 'sent' => '0' );
        						$this->db->insert('metro_sent_ads', $metro_sent_ads);
        					}
        					//Note Sent
        					if (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){
        						$post_note = array( 'order_id' => $order_id, 'note' => $_POST['note'] );
        						$this->db->insert('note_sent', $post_note);
        					}
        					//csr_to_adrep_option
        					if (isset($_POST['csr_to_adrep_option'])){
        						$post_change = array( 'order_id' => $order_id, 'csr' => $this->session->userdata('sId'), 'csr_to_adrep_option' => $_POST['csr_to_adrep_option'] );
        						$this->db->insert('csr_source_changes', $post_change);
        					}
    					}else{ $this->session->set_flashdata("message",$order_id." - Pdf Not Found"); }
    			
    			//For Ftp xml files 16-OCT-2023
    			if($orders[0]['publication_id'] == '656'){ //Ogden
    			    $this->Ogden_create_xml_proofReady('new', $order_id);    
    			}
    			$this->session->set_flashdata("sucess_message",$order_id." - Uploaded & Sent To Adrep..!!");
    			redirect($redirect_cshift);
    		}
    		$this->load->view('new_csr/orderview', $data);			
		}			
	}
	
	public function csr_pdf_review($order_id)
	{
	    $order = $this->db->get_where('orders',array('id' => $order_id))->row_array(); 
	    if(isset($order['id']) && isset($_POST['content'])){
	       //order annotation
	           $output = '';
    		   $content =  $_POST['content'];
               $decode_content = base64_decode($content);
               
                $myFile = "order_annotation/csrProof-".$order['id']."-".$order['job_no'].".pdf";
    		    $fh = fopen($myFile, 'w+') or die("can't open file");
    		    fwrite($fh, $decode_content);
    		    fclose($fh);
    		    
    		$order_annotation = $myFile;
    		if(file_exists($order_annotation)){
    			$oa_fname = basename($order_annotation);
    			$oa_url = base_url().$order_annotation;
    		
    		    $output .= '<div class="row margin-top-10 margin-bottom-10">
						    <div class="col-sm-12">
							    <span class="font-red">CSR marked PDF changes - </span>';
				$output .= '<a href="'.$oa_url.'" target="_Blank">'.$oa_fname.'</a></div></div>';
				echo $output;
	        }
	    }
	}
	
	public function orderview_QA($order_id="") //In QA status- pdf review, To Designer, To Adrep
	{
	    $sId = $this->session->userdata('sId');
	    $q = "SELECT orders.id, orders.help_desk, orders.ad_format, orders.order_type_id, cat_result.csr_QA, cat_result.source_path, cat_result.slug, cat_result.pro_status, csr.name, production_status.name AS pname FROM `orders` 
	            JOIN `cat_result` ON cat_result.order_no = orders.id
	            JOIN `csr` ON csr.id = cat_result.csr_QA
	            JOIN `production_status` ON production_status.id = cat_result.pro_status
	                WHERE orders.id = '$order_id'";
	    $orders = $this->db->query("$q")->row_array();
	        
	    if(isset($orders['id'])){
	       if($orders['pro_status'] == '3'){
    	       if($orders['csr_QA'] == $sId) {
    	           $data['orders'] = $orders;
    	           //$data['note_csr_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_dc'))->result_array();
    	           //$data['note_csr_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_designer'))->result_array();	
    	           $slug = $orders['slug'];
    	           $src_path = $orders['source_path'];
    	           if(file_exists($src_path)){ $sourcefile = $src_path; }
    	           $this->load->helper('directory');	
    			   $map_src_pdf_file = glob($src_path.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE); //pdf/image
    			   if($map_src_pdf_file){ 
    			       foreach($map_src_pdf_file as $row_map){ 
    			           $pdf_file = $row_map; $data['pdf_name'] = basename($row_map); 
    			       }
    			       $data['pdf_annotation_url'] = base_url().$pdf_file; //echo $data['pdf_annotation_url'];
    			   }
    	          
    	           $this->load->view('new_csr/orderview_QA', $data);   
    	       }else{
    	            $this->session->set_flashdata("message","Order already taken by CSR - ".$orders['name']);
    		        redirect('new_csr/home/orderview/'.$orders['help_desk'].'/'.$orders['id']);  
    	       }
	       }else{
	           $this->session->set_flashdata("message","Order Not In Quality Check status. In - ".$orders['pname']);
		        redirect('new_csr/home/orderview/'.$orders['help_desk'].'/'.$orders['id']); 
	       }
	    }else{
	        $this->session->set_flashdata("message","Order: Details not Found!!");
			redirect('new_csr/home');    
	    }
	    
	}
	
    public function orderview_history($hd="",$order_id="")
	{
		$sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		/* if($csr[0]['csr_role'] != '3') {
			//echo "<script>alert('no access')</script>";
			$this->session->set_flashdata('alert_message','<div class="alert alert-danger text-center" style="margin: 40px 0 0 20px;">No Access</div>');
			redirect('new_csr/home');
		} */ 
		$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
												FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		
		//$data['order_revision_review'] = $this->db->query("SELECT * FROM order_revision_review_csr WHERE order_id='$order_id'")->row_array();
		if(isset($_POST['submit_mistake']) && !empty($_POST['mistake'])){
			$review_data = array(	'order_id' => $order_id, 
									'csr_id' => $this->session->userdata('sId'), 
									'csr_mistake' => $_POST['mistake'],
									'version' => $_POST['version'],
									'rev_id' => $_POST['rev_id']
								);
			$this->db->insert('order_revision_review_csr', $review_data);
			redirect('new_csr/home/orderview_history/'.$hd.'/'.$order_id);
		}
		
		if($hd != '' && $hd != '0' && $order_id != '' && isset($orders[0]['id']))
		{
			$this->load->helper('directory');
			$redirect = 'new_csr/home/orderview/'.$hd.'/'.$order_id;
			$data['redirect']= $redirect;
			$data['order_id']= $order_id; 
			$data['hd']= $hd;
			if(!$orders){
				$this->session->set_flashdata("message","Order: Details not Found!!");
				redirect('new_csr/home/cshift/'.$hd);
			}
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->result_array();
			if(isset($rev_orders[0]['id'])){ $data['rev_orders'] = $rev_orders; }
			
			$pro_conversation = $this->db->query("SELECT * from `production_conversation` where `order_id` = '$order_id' ")->result_array();
				if($pro_conversation){
					$data['pro_conversation'] = $pro_conversation;
				}
				//$data['rev_order_form'] = $rev_orders[0]['file_path'];
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			$data['rev_rev'] =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			
			$data['orders'] = $orders; 
			$data['fname'] = $this->db->get_where('print_ad_types',array('id' => $orders[0]['print_ad_type']))->result_array();
			$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
			$data['adrep_name'] = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
			$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
			$data['csr_alias'] = $csr_alias; 
			$job_no= $orders[0]['job_no'];
			$downloads="downloads/".$order_id."-".$job_no;
			$pickup_downloads = "downloads/pickup/".$order_id;
			$pickup_map_downloads = directory_map($pickup_downloads.'/');
			$t1 = strtotime($orders[0]['created_on']); $t2 = strtotime($orders[0]['pdf_timestamp']); $time_taken = abs($t2 - $t1); 
			
			$time = $time_taken;//echo $time;
			$seconds = $time%60;
			$mins = floor($time/60)%60;
			$hours = floor($time/60/60)%24;
			$days = floor($time/60/60/24);
			$data['days'] = $days;
			$data['hours'] = $hours;
			$data['mins'] = $mins;
			$data['seconds'] = $seconds;
			if($pickup_map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['pickup_downloads']= $pickup_downloads; 
			}
			$map_downloads = directory_map($downloads.'/');
			if($map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['downloads']= $downloads; 
			}
			 
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			if(!$cat)
			{
				$data['cat_pending']='cat_pending';
				$adtype = $this->db->get('cat_new_adtype')->result_array();
				$artinst = $this->db->get('cat_artinstruction')->result_array();
				$data['adtype'] = $adtype;
				$data['artinst'] = $artinst;
			}else{
			$data['cat'] = $cat;
			if($cat[0]['designer']!='0') $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();
			if($cat[0]['csr']!='0') $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr']."'")->result_array();
			if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
			if($cat[0]['csr_QA']!='0') $data['qa_name'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr_QA']."'")->result_array();
			$cp_tool = $this->db->query("SELECT * from `cp_tool` where `order_no` = '$order_id' ")->result_array();
			if($cp_tool){
				$data['cp_tool'] = $cp_tool;
				$data['csr_name1'] = $this->db->get_where('csr',array('id' => $cp_tool[0]['csr']))->result_array();
			} 
			//$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
			$data['cancel_reason'] = $this->db->get('cancel_reason')->result_array();			
			$data['note_csr_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_designer'))->result_array();			
			$data['note_csr_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_dc'))->result_array();
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			if($orders[0]['file_path'] != 'none'){
			$data['order_form'] = $orders[0]['file_path'];
			}
			if($cat[0]['slug']!='none' || $cat[0]['slug']!=''){
				$slug = $cat[0]['slug'];
				$data['slug'] = $slug;
				$sourcefile = "sourcefile/".$order_id.'/'.$slug;
				$map_sourcefile = directory_map($sourcefile.'/');
				if($map_sourcefile){ $data['sourcefile']= $sourcefile; }
				
				$data['tl_path'] = $sourcefile.'/Tl_change';
				$data['csr_path'] = $sourcefile.'/csr_change';
				$data['dc_path'] = $sourcefile.'/DC_change';
				//changes from TL
				$tl_path = $sourcefile.'/Tl_change';
				$map_tl_path = directory_map($tl_path.'/');
				if($map_tl_path){ $data['tl_path']= $tl_path; }
				
				//changes from CSR
				$csr_path = $sourcefile.'/csr_change'; 
				$map_csr_path = directory_map($csr_path.'/');
				if($map_csr_path){ $data['csr_path']= $csr_path; }
				
				if($rev_orders){
				$rev_csr_path = $sourcefile.'/csr_change_'.$rev_orders[0]['id'];
				$map_rev_csr_path = directory_map($rev_csr_path.'/');
				if($map_rev_csr_path){ $data['rev_csr_path']= $rev_csr_path; }
				}
				//changes from DC CSR
				$dc_csr_path = $sourcefile.'/DC_change'; 
				$map_dc_csr_path = directory_map($dc_csr_path.'/');
				if($map_dc_csr_path){ $data['dc_csr_path']= $dc_csr_path; } 
			}
		}
			$this->load->view('new_csr/orderview_history', $data);			
		}			
	}
	
	public function production_details($id="", $from="",$to="") //Order details for Report
	{
		$data['id'] = $id;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$id'")->result_array();
		$data['cat_result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `csr_QA` = '$id' AND (`date` BETWEEN '$from' AND '$to')")->result_array();
		$this->load->view('new_csr/production_details',$data);
	}
	
	/*public function vidn_entries()
	{
		$vidn_entries = $this->db->get_where('vidn_orders', array('job_no !=' => '','status' => '0'))->result_array();
		$data['vidn_entries'] = $vidn_entries;
		$this->load->view('new_csr/vidn_entries', $data);
	}*/
	
	public function vidn_newad_form($id='0')
	{
		$vidn = $this->db->get_where('vidn_orders', array('id' => $id))->row_array();
		if(isset($vidn['id'])){
			$adrep = $this->db->get_where('adreps', array('id' => $vidn['adrep_id']))->row_array();
			if(isset($_POST['Submit']))
			{
				$art = $_POST['artinst'];
				$adtype = $_POST['adtype'];
				$w = $_POST['width'];
				$h = $_POST['height'];
						
				$size = $w * $h;
				if($size == '0'){
					$this->session->set_flashdata("message","Provide Proper values for Width and Height!!!");
					redirect('new_csr/home/vidn_newad_form/'.$id);
				}
				$category = $this->cat_calc($adtype); //cat_calc()
				$_POST['job_name'] = preg_replace('/[^A-Za-z0-9\s]/', ' ', $_POST['job_name']);	//replace special char
				$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
				if($orders){
					$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
					redirect('new_csr/home/vidn_newad_form/'.$id);
				}else{
					$pub_details = $this->db->get_where('publications',array('id' => $adrep['publication_id']))->row_array();
					$help_desk = $pub_details['help_desk'];
					
					if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
						$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
					} else {
						$next_day =  date('D', strtotime(' +1 day'));
						if($next_day == 'Sat' || $next_day == 'Sun'){
							$publish_date = date('Y-m-d', strtotime('next monday'));
						}else{
							$publish_date = date('Y-m-d', strtotime(' +1 day'));
						}
					}
							$post = array(
									'adrep_id' => $adrep['id'],
									'csr' => $this->session->userdata('sId'), 
									'publication_id' => $pub_details['id'],
									'group_id' => $pub_details['group_id'],
									'help_desk' => $help_desk,
									'order_type_id' => '2', 	//print ad
									'advertiser_name' => $_POST['advertiser'],
									'job_no' => $_POST['job_name'],
									'copy_content_description' => $_POST['copy_content_description'],
									'width' => $_POST['width'],
									'height' => $_POST['height'],
									'print_ad_type' => $_POST['print_ad_type'],
									'publish_date' => $publish_date,
									'club_id'=> $pub_details['club_id'],
									);
					$this->db->insert('orders',$post);	
					$order_no = $this->db->insert_id();	
					
					if($order_no){
						
						//Live_tracker updation
						$tracker_data = array(
							'pub_id'=> $pub_details['id'],
							'order_id'=> $order_no,
							'job_no' => $_POST['job_name'],
							'club_id'=> $pub_details['club_id'],
							'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
						
						$this->orders_folder($order_no);	// folder creation, html_form
							//file move
						if($vidn['file_path'] != "none"){
							$cache_path = getcwd().'/'.$vidn['file_path'];
							$order_details = $this->db->get_where('orders', array('id' => $order_no))->row_array();
							 $download_path = getcwd().'/'.$order_details['file_path'];
							
							if($download_path != " "){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											copy($cache_path.'/'.$file,$download_path.'/'.$file);
										}
										closedir($dh);
									}
								} 
							}
						}
						$help_desk = $pub_details['help_desk']; 
						$news_id = $pub_details['news_id'];
						$initial = $pub_details['initial'];
						$slug_type = $pub_details['slug_type'];
						$team = $pub_details['design_team_id'];
							//cat_result table
								$dataa = array(
										'order_no' => $order_no,
										'job_name' => $_POST['job_name'],
										'adrep' => $adrep['id'],
										'advertiser' => $_POST['advertiser'], 
										'width' => $w,
										'height' => $h,
										'artinstruction' => $_POST['artinst'],
										'adtypewt' => $_POST['adtype'],
										'help_desk' => $help_desk,
										'publication_id' => $pub_details['id'],
										'news_id' => $news_id,
										'news_initial' => $initial,
										'team' => $team,
										'slug_type' => $slug_type,
										'category' => $category,
										'csr' => $this->session->userdata('sId'),
										'date' => Date("Ymd"),
										'time' => date("His")
										);
								$this->db->insert('cat_result',$dataa);	
								$cat_id = $this->db->insert_id();
								
								
							//cshift table	
								$data2 = array(
											'order_no' => $order_no,
											'csr' => $this->session->userdata('sId'),
											'news_id' => $news_id,
											'publication_id'  => $pub_details['id'],
											'help_desk'  => $help_desk,
											'date' => Date("Ymd"),
											'time' => date("His"),
											'category' => $category,
											);
								$this->db->insert('cshift',$data2);
								$status = 'v1';
							
								if($cat_id)
								{
									//order status
									$post_status = array('status' => '2');
									$this->db->where('id', $order_no);
									$this->db->update('orders', $post_status);
									
									//Live_tracker Updation
									$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
									if(isset($update_order['id'])){
										$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
										$this->db->where('id', $update_order['id']);
										$this->db->update('live_orders', $tracker_data);
									}
									
									
									//vidn orders status
									$post_status = array('status' => '1');
									$this->db->where('id', $vidn['id']);
									$this->db->update('vidn_orders', $post_status);
									
									$this->session->set_flashdata("message","Order No: ".$order_no." Submitted!!");
									redirect('new_csr/home/vidn_entries/');
								}else{ 
									$this->session->set_flashdata("message","Order not categorised Try Again.. Had some problem with database..!!!");
									redirect('new_csr/home/vidn_newad_form/'.$id); 
								}
							}else{
								$this->session->set_flashdata("message","Internal Error!! Order not placed.. Try again..");
								redirect('new_csr/home/vidn_newad_form/'.$id);
							}
						}		
					}
			$adtype = $this->db->get('cat_new_adtype')->result_array();
			$artinst = $this->db->get('cat_artinstruction')->result_array();
			$print_ad_types = $this->db->get('print_ad_types')->result_array();
			$data['vidn'] = $vidn;
			$data['adrep'] = $adrep;
			$data['adtype'] = $adtype;
			$data['artinst'] = $artinst;
			$data['print_ad_types'] = $print_ad_types;
			$this->load->view('new_csr/vidn_newad_form', $data);
		}
	}
	
	public function vidn_entries($type='new')
    {
        if($type=='revision'){
            $vidn_entries = $this->db->get_where('vidn_orders', array('job_no !=' => '','status' => '0', 'vidn_type' => 'revision'))->result_array();
        }elseif($type=='new'){
			$vidn_entries = $this->db->get_where('vidn_orders', array('job_no !=' => '','status' => '0', 'vidn_type' => 'new'))->result_array();
		}else{
            $vidn_entries = $this->db->get_where('vidn_orders', array('job_no !=' => '','status' => '0'))->result_array();
        }
        $data['type'] = $type;
        $data['vidn_entries'] = $vidn_entries;
        $this->load->view('new_csr/vidn_entries', $data);
    }


	public function vidn_revad_form($id='0')
    {
        $vidn = $this->db->get_where('vidn_orders', array('id' => $id))->row_array();
        if(isset($vidn['id'])){
            if(isset($_POST['order_search']) && !empty($_POST['order_id'])){
                $order_id = $_POST['order_id'];
                $orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
														FROM `orders` WHERE `id` LIKE '$order_id%' OR `job_no` LIKE '$order_id%' OR `advertiser_name` LIKE '$order_id%'")->result_array();
                if($orders){
                    $data['order_id'] = $order_id;
                    $data['orders'] = $orders; 
                }else{
                    $this->session->set_flashdata("message","No Orders Found for $order_id");
                    redirect('new_csr/home/vidn_revad_form/'.$id);
                }
            }
        //revision submit
        if(isset($_POST["rev_submit"]))
        {
            $version = 'V1a'; $file_path = 'none';
            
            if(empty($_POST['adwit_order_id'])){
                $this->session->set_flashdata("message","AdwitAds Order Id Not Provided");
                redirect('new_csr/home/vidn_revad_form/'.$id);
            }
            $oid = $_POST['adwit_order_id'];
            $orders = $this->db->get_where('orders',array('id' => $oid))->result_array();//adrep details
            if(!$orders){
                $this->session->set_flashdata("message","Revision not placed.. Incomplete Details for order: ".$oid);
                redirect('new_csr/home/vidn_revad_form');
            }
            $orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$oid' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
            
            if($orders_rev){
                $slug = $orders_rev[0]['new_slug'];
                $version = $orders_rev[0]['version'];
                if($version == 'V1a'){ $version = 'V1b'; }
                elseif($version == 'V1b'){ $version = 'V1c'; }
                elseif($version == 'V1c'){ $version = 'V1d'; }
                elseif($version == 'V1d'){ $version = 'V1e'; }
                elseif($version == 'V1e'){ $version = 'V1f'; }
                elseif($version == 'V1f'){ $version = 'V1g'; }
                elseif($version == 'V1g'){ $version = 'V1h'; }
                elseif($version == 'V1h'){ $version = 'V1i'; }
                elseif($version == 'V1i'){ $version = 'V1j'; }
                elseif($version == 'V1j'){ $version = 'V1k'; }
                elseif($version == 'V1k'){ $version = 'V1l'; }
                elseif($version == 'V1l'){ $version = 'V1m'; }
                elseif($version == 'V1m'){ $version = 'V1n'; }
                elseif($version == 'V1n'){ $version = 'V1o'; }
                elseif($version == 'V1o'){ $version = 'V1p'; }
                elseif($version == 'V1p'){ $version = 'V1q'; }
                elseif($version == 'V1q'){ $version = 'V1r'; }
                elseif($version == 'V1r'){ $version = 'V1s'; }
                elseif($version == 'V1s'){ $version = 'V1t'; }
                elseif($version == 'V1t'){ $version = 'V1u'; }
                elseif($version == 'V1u'){ $version = 'V1v'; }
                elseif($version == 'V1v'){ $version = 'V1w'; }
                elseif($version == 'V1w'){ $version = 'V1x'; }
                elseif($version == 'V1x'){ $version = 'V1y'; }
                elseif($version == 'V1y'){ $version = 'V1z'; }
            }else{
                $cat_result = $this->db->get_where('cat_result',array('order_no' => $oid))->result_array();
                if(isset($cat_result[0]['slug'])){ $slug = $cat_result[0]['slug']; }else{ $slug = 'none'; }
            }
             if($slug == 'none'){ 
                $this->session->set_flashdata("message","Revision Not Allowed To This OrderId : ".$oid);
                redirect('new_csr/home/vidn_revad_form/'.$id);
             }
            $client = $this->db->get_where('adreps',array('id' => $vidn['adrep_id']))->result_array();
            $publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
            //rev_sold_jobs
            $tday = date('Y-m-d');
            $time = date("H:i:s");
            if(!empty($_POST['copy_content_description'])){
                $note = $_POST['copy_content_description'];
            }else{ $note = 'none'; }
            
            $reason_id = $_POST['reason_option'];
            $post = array(
                            'order_id' => $oid,
                            'order_no' => $slug,
                            'csr' => $this->session->userdata('sId'),
                            'adrep' => $vidn['adrep_id'],
                            'help_desk' => $publication[0]['help_desk'],
                            'date' => $tday,
                            'time' => $time,
                            'category' => 'revision',
                            'version' => $version,
                            'note' => $note,
                            //'rush' => $rush,
                            'file_path' => $file_path,
                            'job_accept' => '1',
                            'status' => '2',
                            //'reason_c' => $reason_id
							'classification' => $reason_id
                            );
            $this->db->insert('rev_sold_jobs', $post); 
            $rev_id = $this->db->insert_id();
            if($rev_id){
			//Live_tracker Revision updation
				$tracker_data = array(
					'pub_id'=> $publication[0]['id'],
					'order_id' => $oid,
					'revision_id'=> $rev_id,
					'status' => '1'
				);
				$this->db->insert('live_revisions', $tracker_data);
			}
            if(!$rev_id){ 
                $this->session->set_flashdata("message2","Internal Error: Order could not be placed! ".$this->db->error());
                redirect('new_csr/home/vidn_revad_form/'.$id);
            }
            //file move
            if($vidn['file_path'] != "none")
            {
                $cache_path = getcwd().'/'.$vidn['file_path'];
                $dir = "revision_downloads/".$slug;
                if (@mkdir($dir,0777)){ }
                $download_path = getcwd().'/'.$dir;
                            
                if($download_path != " "){
                    if(is_dir($cache_path)){
                        if($dh = opendir($cache_path)){
                            while(($file = readdir($dh)) !== false){
                                if($file== '.' || $file== '..') { continue; } 
                                copy($cache_path.'/'.$file,$download_path.'/'.$file);
                            }
                        closedir($dh);
                        }
                    } 
                }
            }
            //file upload to revision_downloads
            if (!empty($_FILES['ufile']['tmp_name'][0]) || !empty($_FILES['ufile']['tmp_name'][1]))
            {    
                $dir = "revision_downloads/".$slug;
                $file_path = $dir;
                if(@mkdir($dir,0777)){ }
                
                $path1= $dir.'/'.$_FILES['ufile']['name'][0];
                $path2= $dir.'/'.$_FILES['ufile']['name'][1];
                if (!empty($_FILES['ufile']['tmp_name'][0])){                
                    if(!copy($_FILES['ufile']['tmp_name'][0], $path1)){
                        $this->session->set_flashdata("message2","error uploading file : ". $_FILES['ufile']['tmp_name'][0]);
                        redirect('new_csr/home/vidn_revad_form/'.$id);
                    }
                }    
                if (!empty($_FILES['ufile']['tmp_name'][1])){
                    if(!copy($_FILES['ufile']['tmp_name'][1], $path2)){
                        $this->session->set_flashdata("message2","error uploading file : ". $_FILES['ufile']['tmp_name'][1]);
                        redirect('new_csr/home/vidn_revad_form/'.$id);
                    }
                }
            }
            
            
            if(isset($_POST['redesign']) && !empty($_POST['redesign']))    //redesign
            {
                $post2 = array( 'order_id' => $_POST['order_id'], 'rev_sold_id' => $rev_id );
                $this->db->insert('redesign_nj', $post2);
            }
            //vidn orders status
                $post_status = array('status' => '1');
                $this->db->where('id', $vidn['id']);
                $this->db->update('vidn_orders', $post_status);
            $this->session->set_flashdata("message","Revision Submitted!!");
            redirect('new_csr/home/vidn_entries/revision');
        }
            
            $adrep = $this->db->get_where('adreps', array('id' => $vidn['adrep_id']))->row_array();
            //$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
            $data['vidn'] = $vidn;
            $data['adrep'] = $adrep;
            $this->load->view('new_csr/vidn_revad_form',$data);
        }
    }
	
	public function curl_post($url='', $fields='') //API via cURL
	{
		if($url != '' && $fields != ''){
			$fields_string = $fields;
			/*foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');*/

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
		}
	}
	
	public function check_post(){
			$fields = array(
										'status' => '2', 
										'map_revorder_id' => '10',
										);
						$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/revorder_status_update';
						$this->curl_post($url, $fields); //API using cURL 
			
	}
	public function comment($comment_id='')
	{
		$csr_id = $this->session->userdata('sId');
		
		$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->row_array();
		$data['csr_alias'] = $csr_alias;
		
		$query = "SELECT rev_verify_comment.*, rev_sold_jobs.verification_type, rev_sold_jobs.order_id,
					CONCAT(admin_users.first_name,' ',admin_users.last_name) as admin_name, designers.name as d_name,csr.name as c_name,tl.name as tl_name,rov_csr.name as r_name,designers.name as hi_b_name
					FROM `rev_verify_comment` 
					JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id 
					LEFT JOIN `admin_users` ON admin_users.id = rev_verify_comment.admin_id 
					LEFT JOIN `designers` AS tl ON tl.id = rev_verify_comment.tl_designer_id
					LEFT JOIN `designers` ON designers.id = rev_verify_comment.designer_id
					LEFT JOIN `designers` AS hi_b ON designers.id = rev_verify_comment.hi_b_designer_id
					LEFT JOIN `csr` AS rov_csr ON rov_csr.id = rev_verify_comment.rov_csr_id
					LEFT JOIN `csr` ON csr.id = rev_verify_comment.csr_id
					WHERE rev_verify_comment.id = '$comment_id' AND (rev_verify_comment.csr_id='$csr_id' OR rev_verify_comment.rov_csr_id='$csr_id')"; 
		 //echo $query;
		$r_review = $this->db->query("$query")->row_array();
		if(isset($r_review['csr_id']) && $r_review['csr_id'] != '0' && $r_review['csr_id'] == $csr_id){
			$csr_role = "QA_csr";
		}elseif(isset($r_review['rov_csr_id']) && $r_review['rov_csr_id'] != '0' && $r_review['rov_csr_id'] == $csr_id){
			$csr_role = "rov_csr";
		}
		$data['r_review'] = $r_review;
			if(isset($_POST['c_search']))
			{
				if(isset($r_review['csr_id']) && $r_review['csr_id'] != '0' && $r_review['csr_id'] == $csr_id){
					$c_reply = array( 
							'csr_reply' => $_POST['reply'],
						);
				}elseif(isset($r_review['rov_csr_id']) && $r_review['rov_csr_id'] != '0' && $r_review['rov_csr_id'] == $csr_id){
					$c_reply = array( 
							'rov_csr_reply' => $_POST['reply'],
						);
				}
				
				//var_dump($comment);die();		
				$this->db->where('id', $_POST['comment_id']);
				$this->db->update('rev_verify_comment', $c_reply);	
				redirect('new_csr/home');	
			}
		
		$this->load->view('new_csr/comment',$data);
	}
	
	public function order_review_history($order_id="")
	{
		
		$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
												FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		if(isset($orders[0]['id']))
		{
			$this->load->helper('directory');
			
			$data['order_id']= $order_id; 
			
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->result_array();
			if(isset($rev_orders[0]['id'])){ $data['rev_orders'] = $rev_orders; }
			
			$pro_conversation = $this->db->query("SELECT * from `production_conversation` where `order_id` = '$order_id' ")->result_array();
				if($pro_conversation){
					$data['pro_conversation'] = $pro_conversation;
				}
				//$data['rev_order_form'] = $rev_orders[0]['file_path'];
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			$data['rev_rev'] =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			
			$data['orders'] = $orders; 
			$data['fname'] = $this->db->get_where('print_ad_types',array('id' => $orders[0]['print_ad_type']))->result_array();
			$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
			$data['adrep_name'] = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
			
			$job_no= $orders[0]['job_no'];
			$downloads="downloads/".$order_id."-".$job_no;
			$pickup_downloads = "downloads/pickup/".$order_id;
			$pickup_map_downloads = directory_map($pickup_downloads.'/');
			$t1 = strtotime($orders[0]['created_on']); $t2 = strtotime($orders[0]['pdf_timestamp']); $time_taken = abs($t2 - $t1); 
			
			$time = $time_taken;//echo $time;
			$seconds = $time%60;
			$mins = floor($time/60)%60;
			$hours = floor($time/60/60)%24;
			$days = floor($time/60/60/24);
			$data['days'] = $days;
			$data['hours'] = $hours;
			$data['mins'] = $mins;
			$data['seconds'] = $seconds;
			if($pickup_map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['pickup_downloads']= $pickup_downloads; 
			}
			$map_downloads = directory_map($downloads.'/');
			if($map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['downloads']= $downloads; 
			}
			 
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			if(!$cat)
			{
				$data['cat_pending']='cat_pending';
				$adtype = $this->db->get('cat_new_adtype')->result_array();
				$artinst = $this->db->get('cat_artinstruction')->result_array();
				$data['adtype'] = $adtype;
				$data['artinst'] = $artinst;
			}else{
			$data['cat'] = $cat;
			if($cat[0]['designer']!='0') $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();
			if($cat[0]['csr']!='0') $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr']."'")->result_array();
			if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
			if($cat[0]['csr_QA']!='0') $data['qa_name'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr_QA']."'")->result_array();
			$cp_tool = $this->db->query("SELECT * from `cp_tool` where `order_no` = '$order_id' ")->result_array();
			if($cp_tool){
				$data['cp_tool'] = $cp_tool;
				$data['csr_name1'] = $this->db->get_where('csr',array('id' => $cp_tool[0]['csr']))->result_array();
			} 
			//$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
			$data['cancel_reason'] = $this->db->get('cancel_reason')->result_array();			
			$data['note_csr_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_designer'))->result_array();
			$data['note_csr_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_dc'))->result_array();
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			if($orders[0]['file_path'] != 'none'){
			$data['order_form'] = $orders[0]['file_path'];
			}
			if($cat[0]['slug']!='none' || $cat[0]['slug']!=''){
				$slug = $cat[0]['slug'];
				$data['slug'] = $slug;
				$sourcefile = "sourcefile/".$order_id.'/'.$slug;
				$map_sourcefile = directory_map($sourcefile.'/');
				if($map_sourcefile){ $data['sourcefile']= $sourcefile; }
				
				$data['tl_path'] = $sourcefile.'/Tl_change';
				$data['csr_path'] = $sourcefile.'/csr_change';
				$data['dc_path'] = $sourcefile.'/DC_change';
				//changes from TL
				$tl_path = $sourcefile.'/Tl_change';
				$map_tl_path = directory_map($tl_path.'/');
				if($map_tl_path){ $data['tl_path']= $tl_path; }
				
				//changes from CSR
				$csr_path = $sourcefile.'/csr_change'; 
				$map_csr_path = directory_map($csr_path.'/');
				if($map_csr_path){ $data['csr_path']= $csr_path; }
				
				if($rev_orders){
				$rev_csr_path = $sourcefile.'/csr_change_'.$rev_orders[0]['id'];
				$map_rev_csr_path = directory_map($rev_csr_path.'/');
				if($map_rev_csr_path){ $data['rev_csr_path']= $rev_csr_path; }
				}
				//changes from DC CSR
				$dc_csr_path = $sourcefile.'/DC_change'; 
				$map_dc_csr_path = directory_map($dc_csr_path.'/');
				if($map_dc_csr_path){ $data['dc_csr_path']= $dc_csr_path; } 
			}
		}
			$this->load->view('new_csr/order_review_history', $data);			
		}
	}
	
	//Live_tracker_New_Ads Starts
	public function live_new_ads($display_type = '')
    {    
        $sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array(); 
        //$pub_id = "(".$csr['pub_id'].")";
        
        $no_of_order = $this->input->post('no_of_order');
        $order_type = $this->input->post('order_type');
        $order_by = null;
        $sort_by = null;
        
        if($csr['category_level'] != null && $csr['club_id'] != null){
            $club_id = "(".$csr['club_id'].")";
			
			$cat_id = explode(',', $csr['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			/*
			$cat_id = $csr['category_level'];
			//$cat_series = "('".$cat_id."')";
			
        	if($cat_id == 'P'){ $cat_series = "('P')"; }
			elseif($cat_id == 'M'){ $cat_series = "('P', 'M')"; }
			elseif($cat_id == 'N'){ $cat_series = "('P', 'M', 'N')"; }
			elseif($cat_id == 'T'){ $cat_series = "('P', 'M', 'N', 'T')"; }
			elseif($cat_id == 'W'){ $cat_series =  "('P', 'M', 'N', 'T', 'W')"; }*/
			//echo $cat_series;
        
            if(isset($cat_series)){
    			//Categorise orders -->  order_status = 1
    		/*	$categorise_orders_query ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.adrep_id, orders.order_type_id, orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name, time_zone.priority AS time_zone_priority, orders.page_design_id	
                        			        FROM `live_orders`
                        					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
                        					JOIN `publications` ON publications.id = orders.publication_id
                        					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                        					WHERE live_orders.club_id IN $club_id AND live_orders.status = '1' AND live_orders.crequest != '1' AND orders.cancel != '1'; ";*/
    			
    			//myQ order_status = 2  My Q
    			$myQ_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, time_zone.priority AS time_zone_priority
    			                        FROM `live_orders` 
    									JOIN `publications` ON publications.id = live_orders.pub_id
    									JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    									WHERE live_orders.club_id IN $club_id AND live_orders.csr_QA = '$sId' AND (live_orders.status IN('1','2','3','4','8'))
    									AND live_orders.pro_status != '5' AND live_orders.crequest != '1'";
    						
    			//GeneralQ total_QA
    			$generalQ_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.csr_QA, time_zone.priority AS time_zone_priority
    			        FROM `live_orders` 
    					JOIN `publications` ON publications.id = live_orders.pub_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status != '5' 
    					AND live_orders.pro_status = '3' AND live_orders.csr_QA IS NULL AND live_orders.crequest != '1'";
    			
    			//All STARTS
    			/*$all_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, 
    			live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.order_type_id, orders.advertiser_name, 
    			orders.rush, orders.adrep_id, orders.question, orders.help_desk, orders.created_on, orders.status, time_zone.priority AS time_zone_priority, orders.page_design_id
    			        FROM `live_orders`
    					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    					JOIN `publications` ON publications.id = orders.publication_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status BETWEEN '1' AND '4' 
    					AND live_orders.crequest != '1'";*/
    			
    			if($display_type == 'category'){	//Category
    			
    			    if(isset($_POST['c_order_by'])){
                       $order_by  =  $_POST['c_order_by'];
                       $this->session->set_userdata("c_order_by",$order_by);
                    }
                    if(isset($_POST['c_sort_by'])){
                        $sort_by = $_POST['c_sort_by'];
                        $this->session->set_userdata("c_sort_by",$sort_by);
                    }
                    
    				#pagination code starts here
					$config = array();
					$config["base_url"] = base_url() . "index.php/new_csr/home/live_new_ads/category/";
					if($this->input->get('category_search') != null){
						$search = $this->input->get('category_search');
						$this->session->set_userdata('search_val', $search);
						$config["total_rows"] = $this->Pagination->get_categorise_ad_count($club_id,$search);
					}else if($this->session->userdata("search_val") !== "" && $this->input->get('category_search') == null){
						$search =  $this->session->userdata("search_val");
						$config["total_rows"] = $this->Pagination->get_categorise_ad_count($club_id,$search);
					}else{
						$config["total_rows"] = $this->Pagination->get_categorise_ad_count($club_id,null);
					}
					
					if($no_of_order != "" && $no_of_order != null){
					  	$config["per_page"] = $no_of_order;  
					  	$this->session->set_userdata('no_of_order', $no_of_order);
					}else if($no_of_order == "" && $this->session->userdata('no_of_order') != ""){
					    $config["per_page"] = $this->session->userdata('no_of_order');
					}else{
					    unset($_SESSION['no_of_order']);
					   	$config["per_page"] = 25; 
					} 
					$config["uri_segment"] = 5;
					$this->get_pagination_config($config);
					
					#bootstrap links ends here
					$this->pagination->initialize($config);
					$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
					if($this->input->get('category_search') != null){
						$search = $this->input->get('category_search');
						$data["category_orders"] = $this->Pagination->
						get_categorise_ad($config["per_page"], $page,$club_id,$sort_by,$order_by,$search);
					}else if($this->session->userdata("search_val") != "" && $this->input->get('category_search') == null){
						$search =  $this->session->userdata("search_val");
						$data["category_orders"] = $this->Pagination->
						get_categorise_ad($config["per_page"], $page,$club_id,$sort_by,$order_by,$search);
						
					}else{
						$data["category_orders"] = $this->Pagination->
						get_categorise_ad($config["per_page"], $page,$club_id,$sort_by,$order_by,null);
					} 
                    $end_index = min($config["per_page"] +$page, $config["total_rows"]);
                    $data["result_range"] = "Showing " . $page+1 . " to " . $end_index . " of {$config['total_rows']} entries.";

					$data["links"] = $this->pagination->create_links();
					#pagination code ends here
					
    				// $data['category_orders'] = $this->db->query($categorise_orders_query)->result_array();
    				
    				
    				
    			}elseif($display_type == 'QA'){		//myQA
    				
    				$data['myQ_orders'] = $this->db->query($myQ_orders_query)->result_array(); //echo $myQ_orders_query;
    				 
    			}elseif($display_type == 'new_pending'){ //All
    			 if(isset($_POST['n_order_by'])){
                       $order_by  =  $_POST['n_order_by'];
                       $this->session->set_userdata("n_order_by",$order_by);
                    }
                    if(isset($_POST['n_sort_by'])){
                        $sort_by = $_POST['n_sort_by'];
                        $this->session->set_userdata("n_sort_by",$sort_by);
                    }
                    
    			    #pagination code starts here
					$config = array();
					$config["base_url"] = base_url() . "index.php/new_csr/home/live_new_ads/new_pending/";
					if($this->input->get('newpending_ads') != null){
						$search = $this->input->get('newpending_ads');
						$this->session->set_userdata('newad_val', $search);
						$config["total_rows"] = $this->Pagination->get_newpending_ad_count($club_id,$cat_series,$search);
					}else if($this->session->userdata("newad_val") !== "" && $this->input->get('newpending_ads') == null){
						$search =  $this->session->userdata("newad_val");
						$config["total_rows"] = $this->Pagination->get_newpending_ad_count($club_id,$cat_series,$search);
						
					}else{
						$config["total_rows"] = $this->Pagination->get_newpending_ad_count($club_id,$cat_series,null);
					}
					
					if($no_of_order != "" && $no_of_order != null){
					  	$config["per_page"] = $no_of_order;  
					  	$this->session->set_userdata('no_of_newpending_order', $no_of_order);
					}else if($no_of_order == "" && $this->session->userdata('no_of_newpending_order') != ""){
					    $config["per_page"] = $this->session->userdata('no_of_newpending_order');
					}else{
					    unset($_SESSION['no_of_newpending_order']);
					   	$config["per_page"] = 25; 
					} 
					$config["uri_segment"] = 5;
					
					$this->get_pagination_config($config);

					#bootstrap links ends here
					$this->pagination->initialize($config);
					$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
					if($this->input->get('newpending_ads') != null){
						$search = $this->input->get('newpending_ads');
						$data["all_orders"] = $this->Pagination->
						get_newpending_ad($config["per_page"], $page,$club_id,$cat_series,$sort_by,$order_by,$search);
					}else if($this->session->userdata("newad_val") != "" && $this->input->get('newpending_ads') == null){
						$search =  $this->session->userdata("newad_val");
						$data["all_orders"] = $this->Pagination->
						get_newpending_ad($config["per_page"], $page,$club_id,$cat_series,$sort_by,$order_by,$search);
						
					}else{
						$data["all_orders"] = $this->Pagination->
						get_newpending_ad($config["per_page"], $page,$club_id,$cat_series,$sort_by,$order_by,null);
					} 
					$data["newad_links"] = $this->pagination->create_links();
					$end_index = min($config["per_page"] +$page, $config["total_rows"]);
                    $data["new_result_range"] = "Showing " . $page+1 . " to " . $end_index . " of {$config['total_rows']} entries.";
					#pagination code ends here
    				
    				// $data['all_orders'] = $this->db->query($all_orders_query)->result_array();
    				
    			}elseif($display_type == 'total_QA'){ //GeneralQ
    				
    				$data['generalQ_orders'] = $this->db->query($generalQ_orders_query)->result_array();
    				
    			}elseif($display_type == 'metro_ad_sent'){
    				
    				$data['metro_orders'] = '';
    				
    			}
    			//counts
    			$data['category_count'] 	= 	$this->Pagination->get_categorise_ad_count($club_id,null);
    			$data['myQ_count']   		= 	$this->db->query($myQ_orders_query)->num_rows();
    			$data['generalQ_count'] 	= 	$this->db->query($generalQ_orders_query)->num_rows();
    			$data['all_count'] 			= 	$this->Pagination->get_newpending_ad_count($club_id,$cat_series,null);
    			$data['metro_count']	 	= 	'';
    			
    			$data['sId'] = $sId;
    			$data['display_type'] = $display_type;
    			$data['csr'] = $csr; 
    					
    			$this->load->view('new_csr/live_new_ads',$data);
            }else{
                $this->session->set_flashdata("message","Category Level Not Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		        redirect('new_csr/home');    
            }
		}else{
		    $this->session->set_flashdata("message","No Publication Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		    redirect('new_csr/home');
		}
    }
    
    public function deconstruction()
	{
		if(isset($_POST['button_action'])){
			$post = array( 
				'CompNL' => $_POST['CompNL'], 
				'HeadLine' => $_POST['HeadLine'],
				'CallToAction' => $_POST['CallToAction'],
				'SpecialMessage' => $_POST['SpecialMessage'],
				'ContactInfo' => $_POST['ContactInfo']
				);
            $this->db->insert('deconstruction', $post);
			$id = $this->db->insert_id(); 
			$this->exportCSV($id);
			redirect('new_csr/home/deconstruction');
		}
		
		$this->load->view('new_csr/deconstruction');
	}
	
	// Export data in CSV format 
	public function exportCSV($id)
	{ 
		   // file name 
		   $filename = $id.'_'.date('Ymd').'.csv'; 
		   $path = "deconstruction/".$filename; //path specification
		   
		   /*header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   */
		   // get data 
		   $query = 'SELECT CompNL, HeadLine, CallToAction, SpecialMessage, ContactInfo FROM deconstruction WHERE id = "'.$id.'"';
		   $usersData = $this->getUserDetails($query);

		   // file creation 
		   $file = fopen($path, 'w');
		 
		   $header = array("CompNL","HeadLine","CallToAction","SpecialMessage","ContactInfo"); 
		   fputcsv($file, $header);
		   foreach ($usersData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   
		   
		   fclose($file);
		   
		if(file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            flush(); // Flush system output buffer
            readfile($path);
            die();
        }
		   exit; 
	}
//A category	
	public function a_category()
	{
		if(isset($_POST['button_action'])){
			$post = array( 
				'HeadlineFlavour' => $_POST['HeadlineFlavour'], 
				'FlavourImage1' => $_POST['FlavourImage1'],
				'BodyCopy' => $_POST['BodyCopy'],
				'BenefitText' => $_POST['BenefitText'],
				'SpecialMessageText1' => $_POST['SpecialMessageText1'],
				'CallToActionText1' => $_POST['CallToActionText1'],
				'CompanyName' => $_POST['CompanyName'],
				'CompanyLogo' => $_POST['CompanyLogo'],
				'ContactInfoText' => $_POST['ContactInfoText'],
				);
            $this->db->insert('a_category', $post);
			$id = $this->db->insert_id(); 
			$this->a_category_exportCSV($id);
			
			redirect('new_csr/home/a_category');
		}
		
		$this->load->view('new_csr/a_category');
	}
	
	// Export data in CSV format 
	public function a_category_exportCSV($id)
	{ 
		   // file name 
		   $filename = $id.'_'.date('Ymd').'.csv'; 
		   $path = "a_category/".$filename; //path specification
		   
		   // get data 
		   $query = 'SELECT HeadlineFlavour, FlavourImage1, BodyCopy, BenefitText, SpecialMessageText1, CallToActionText1, CompanyName, CompanyLogo, ContactInfoText FROM a_category WHERE id = "'.$id.'"';
		   $usersData = $this->getUserDetails($query);

		   // file creation 
		   $file = fopen($path, 'w');
		 
		   $header = array("HeadlineFlavour","@FlavourImage1","BodyCopy","BenefitText","SpecialMessageText1","CallToActionText1","CompanyName","@CompanyLogo","ContactInfoText"); 
		   fputcsv($file, $header);
		   foreach ($usersData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   
		   
		   fclose($file);
		   
		if(file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            flush(); // Flush system output buffer
            readfile($path);
            die();
        }
		   exit; 
	}
//B category	
	public function b_category()
	{
		if(isset($_POST['button_action'])){
			$post = array( 
				'HeadlineFlavour' => $_POST['HeadlineFlavour'], 
				'FlavourImage1' => $_POST['FlavourImage1'],
				'FlavourImage2' => $_POST['FlavourImage2'],
				'BodyCopy' => $_POST['BodyCopy'],
				'BenefitText' => $_POST['BenefitText'],
				'SpecialMessageText1' => $_POST['SpecialMessageText1'],
				'CallToActionText1' => $_POST['CallToActionText1'],
				'CompanyName' => $_POST['CompanyName'],
				'CompanyLogo' => $_POST['CompanyLogo'],
				'ContactInfoText' => $_POST['ContactInfoText'],
				);
            $this->db->insert('b_category', $post);
			$id = $this->db->insert_id(); 
			$this->b_category_exportCSV($id);
			
			redirect('new_csr/home/b_category');
		}
		
		$this->load->view('new_csr/b_category');
	}
	
	// Export data in CSV format 
	public function b_category_exportCSV($id)
	{ 
		   // file name 
		   $filename = $id.'_'.date('Ymd').'.csv'; 
		   $path = "b_category/".$filename; //path specification
		   
		   // get data 
		   $query = 'SELECT HeadlineFlavour, FlavourImage1, FlavourImage2, BodyCopy, BenefitText, SpecialMessageText1, CallToActionText1, CompanyName, CompanyLogo, ContactInfoText FROM b_category WHERE id = "'.$id.'"';
		   $usersData = $this->getUserDetails($query);

		   // file creation 
		   $file = fopen($path, 'w');
		 
		   $header = array("HeadlineFlavour","@FlavourImage1","@FlavourImage2","BodyCopy","BenefitText","SpecialMessageText1","CallToActionText1","CompanyName","@CompanyLogo","ContactInfoText"); 
		   fputcsv($file, $header);
		   foreach ($usersData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   
		   
		   fclose($file);
		   
		if(file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            flush(); // Flush system output buffer
            readfile($path);
            die();
        }
		   exit; 
	}
		
	function getUserDetails($query)
	{
		$response = array();
	 
		// Select record
		$q = $this->db->query("$query");
		$response = $q->result_array();
	 
		return $response;
	}

    public function order_form_details($id)
	{
		$order_details = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$id' ")->result_array();
		if(isset($order_details[0]['id'])){
			$data['order'] = $order_details;
			$data['client'] = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->row_array();
			$data['publications'] = $this->db->get_where('publications',array('id' => $order_details[0]['publication_id']))->row_array();
			$this->load->view('new_csr/order_form_details',$data);
		}
	}
	
	public function communication()
	{
	    if(isset($_GET['order_id'])){
			$output = '';
	        $order_id = $_GET['order_id'];
	        $order_details = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$order_id'")->row_array();
	        if(isset($order_details['id'])){
	            
	            if(isset($_GET['search'])){
    	            $communication = $this->db->query("SELECT * FROM `communication` WHERE `is_active` = '1'")->result_array();
    	            
    				$output .= '<div class="awe-nav-responsive"><ul class="awe-nav" role="tablist">';
                        if(isset($communication[0]['id'])){
                            foreach($communication as $row){
                                $output .= '<li role="presentation" class="">';
                                $output .= '<a title="" class="btn_list" role="tab" data-toggle="tab" data-cid="'.$row['id'].'"><span class="padding-right-5"></span>'.$row['button'].'</a>';
								//$output .= '<button class="btn grey btn-sm margin-right-10 margin-bottom-5 btn_list" value="'.$row['id'].'">'.$row['button'].'</button><br/>';
    							$output .= '</li>';
                            }
                        } 
    				$output .= '</ul></div>';
	            }
	            if(isset($_GET['cid'])){
        	        $communication_details = $this->db->query("SELECT * FROM `communication` WHERE `id` = '".$_GET['cid']."'")->row_array();
        	        $q = "SELECT CONCAT(first_name, ' ', last_name) AS name, email_id, publication_id FROM `adreps` WHERE `id` = '".$order_details['adrep_id']."'";
	                $adrep_details = $this->db->query("$q")->row_array();
	                $publication = $this->db->query("SELECT name, design_team_id FROM `publications` WHERE `id` = '".$adrep_details['publication_id']."'")->row_array();
	                $design_team = $this->db->query("SELECT name, email_id FROM design_teams WHERE id='".$publication['design_team_id']."'")->row_array();
        	        $output .= '<div class="padding-20 border-bottom border-right left-2 border-left back_white">
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane fade in active" id="docs-tabs-1">
										<div class="text-muted">
											<div class="panel-group margin-left-30" id="accordion">												
												<div class="row">';
        	        
        	        $output .= '<div class="col-md-12 col-sm-12 no-space"><b>Adrep : </b>'.$adrep_details['name'].' <b>Publication : </b>'.$publication['name'].'</b></div><br/>';
        	        $output .= '<div class="col-md-8 col-sm-8 no-space"><b>Title : </b>'.$communication_details['button'].'</div><br/>';
        	        $output .= '<form action="'.base_url().index_page().'new_csr/home/communication_mail" method="post">';
        	        $output .= '<div class="col-md-8 col-sm-8 no-space"><b>From : </b> <input class="form-control" type="text" name="from" value="'.$design_team['email_id'].'" readonly> </div>';
        	        $output .= '<div class="col-md-8 col-sm-8 no-space"><b>Recipient : </b> <input class="form-control" type="text" name="recipient" value="'.$adrep_details['email_id'].'" readonly> </div>';
        	        $output .= '<div class="col-md-8 col-sm-8 no-space"><b>Subject : </b><input class="form-control" type="text" name="subject" value="'.$communication_details['subject'].' '.$order_id.'"</div>';
        	        $output .= '<div class="col-md-12 col-sm-12 no-space"><b>Body : </b>
                        	        <textarea class="form-control" name="body" rows="6">'.$communication_details['body'].'</textarea>
                        	   </div>';
                    $output .= '<input class="form-control" type="text" name="order_id" value="'.$order_id.'" style="display: none;">';    	   
                    $output .= '<input class="form-control" type="text" name="adrep_name" value="'.$adrep_details['name'].'" style="display: none;">';
                    $output .= '<input class="form-control" type="text" name="design_team_name" value="'.$design_team['name'].'" style="display: none;">';
                    $output .= '<input class="form-control" type="text" name="design_team_email" value="'.$design_team['email_id'].'" style="display: none;">';
                    $output .= '<input class="form-control" type="text" name="communication_id" value="'.$_GET['cid'].'" style="display: none;">';
                    $output .= '<button type="submit" name="submit" class="btn btn-primary btn-sm margin-top-10 right">Send Mail</button>';    	   
        	        $output .= '</form>';
        	        $output .= '</div> </div> </div> </div> </div> </div>';
        	    }
				echo $output;
	        }
	    }else{
			$this->load->view('new_csr/communication');
		}
	}
	
	public function communication_mail() 
	{ 
	    if(isset($_POST['from'], $_POST['recipient'])){
	        $order_id = $_POST['order_id'];
    	    $from = trim($_POST['from']);
    	    $to = trim($_POST['recipient']);
    	    $subject = $_POST['subject'];
    	    $body = $_POST['body'];
    	    $adrep_name = $_POST['adrep_name'];
    	    $data['design_team_name'] = $_POST['design_team_name'];
    	    $data['design_team_email'] = $_POST['design_team_email'];
    	    
    	    $data['adrep_name'] = $adrep_name;
    	    $data['body'] = $body;
    	    $data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$order_id'")->row_array();
    	    
    		include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
    	    
    	    $email = new \SendGrid\Mail\Mail();
    		$email->setFrom($from, 'Design Team');
    		$email->setReplyTo($from, 'Design Team');
    		$email->setSubject($subject);
    
    		$email->addTo($to, $adrep_name);
    		
    		//if($this->session->userdata('sId') == 68 || $data['orders']['publication_id'] == '3' || $data['orders']['group_id'] == '18'){
    		    if(isset($_POST['communication_id']) && ($_POST['communication_id'] == 2 || $_POST['communication_id'] == 4)){ 
    		        $email->setSubject("Delayed Delivery - ".$data['orders']['id']." - ".$data['orders']['advertiser_name']." - ".$data['orders']['job_no']);
    		        $email->addContent("text/html", $this->load->view('email_template/DelayedDelivery',$data, TRUE));
    		    }else{
    		        $email->addContent("text/html", $this->load->view('communication_emailer',$data, TRUE));     
    		    }
    		/*}else{
                $email->addContent("text/html", $this->load->view('communication_emailer',$data, TRUE)); 
    		}*/
    		$sendgrid = new \SendGrid('');
    		try {
                $response = $sendgrid->send($email);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
    		//$response = $sendgrid->send($email);
    		//print_r($response);
    		$this->session->set_flashdata("message","Email Sent..!");
	    }
	    redirect('new_csr/home/communication');
	    
	}
	
	public function check_test_mail() 
	{ 
		include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
	    
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom("sudarshan@adwitads.com", "from");
		//$email->setReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
		$email->setSubject("test email01");

		$email->addTo("sudarshan@adwitads.com", "recipient");
        $email->addContent("text/html", "email bodyy..!!");
        $attachment_path = 'images/ad-img.jpg';
        if(file_exists($attachment_path)){
            $file_encoded = base64_encode(file_get_contents($attachment_path));
            $email->addAttachment(
                                $file_encoded,
                                "application/pdf",
                                "ad-img.jpg",
                                "attachment"
                            );

        }else{
            echo "file not found";
        }
		$sendgrid = new \SendGrid('');
		
		try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


		//$response = $sendgrid->send($email);   
	   
	   //print_r($response);
	}
	
	public function check_setup( $order_id){
	    $orders = $this->db->get_where('orders', array('id' => $order_id))->result_array();
	    $slug = "testorder";
						    $client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
						    $publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
						    $design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						    $dataa['template'] = $design_team[0]['newad_template'];
						
    					
    							if(($design_team[0]['newad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
    							    $dataa['subject'] = 'New Ad(Note): '.$slug ;
    							}else{
    							    $dataa['subject'] = 'New Ad: '.$slug ;
    							}
    						
    						//$dataa['alias'] = $csr_alias[0]['alias'];
    						$dataa['from'] = $design_team[0]['email_id'];
    						$dataa['from_display'] = 'Design Team';
    						$dataa['replyTo'] = $design_team[0]['email_id'];
    						$dataa['replyTo_display'] = 'Design Team';
    						
    						if(!empty($client[0]['email_cc']) || $client[0]['email_cc'] != ''){ $dataa['client_Cc'] = $client[0]['email_cc']; }
    						
    						//$dataa['subject'] = 'New Ad: '.$slug ;
    						$dataa['ad_type'] = 'new' ; 
    						//if(isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){ $dataa['note'] = $_POST['note']; } 
    						//Client
    						if($this->session->userdata('sId')=='25'){
    							$dataa['recipient'] = "webmaster@adwitglobal.com";
    						}else{
    							$dataa['recipient'] = $client[0]['email_id']; 
    						}
    						
    						//$dataa['fname'] = $pdf_file; 
    						//$dataa['temp'] = $pdf_file; 
    						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
    						$dataa['client'] = $client[0];
    						$dataa['design_team_id'] = $design_team[0]['id'];
    						$dataa['order_id'] = $order_id;
    						if($publication[0]['id'] == '580'){    //Waukesha Freeman
    						    $preorders_waukesha = $this->db->query("SELECT DISTINCT preorders_waukesha.id, preorders_waukesha.adtitle,  preorders_waukesha_publication.publication FROM `preorders_waukesha`
                                                                            JOIN preorders_waukesha_publication ON preorders_waukesha_publication.xml_file_data_id = preorders_waukesha.id
                                                                                WHERE preorders_waukesha.adwit_id = '$order_id'")->result_array();
                                if(isset($preorders_waukesha[0]['id'])){
                                    $dataa['job_num'] = $orders[0]['job_no'];
                                    $dataa['adtitle'] = $preorders_waukesha[0]['adtitle'];
                                    $dataa['preorders_waukesha'] = $preorders_waukesha;
                                    $dataa['publish_date'] = $orders[0]['publish_date'];
                                }
    						}
    						$this->load->library('Encryption');
    						$dataa['url']= base_url().index_page().'order_rating/home/new_order_rating/'.$this->encryption->encrypt($order_id);
    						
    						$this->test_mail($dataa);
						
	}
	
	function GetDirectorySize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }
    
	public function new_fileuploads($order_id)
	{
		$cat_result = $this->db->query("Select `id`, `slug`, `source_path` FROM `cat_result` WHERE `order_no` = '$order_id'")->row_array();
		if(isset($cat_result['id']) && !empty($cat_result['source_path']) && file_exists($cat_result['source_path']) && !empty($_FILES)){
			$slug = $cat_result['slug'];
			$sourcefile = $cat_result['source_path'];
			
			$filetype = $_POST['file_type'];
			
			//Links folder
			$link_path = $sourcefile.'/Links';
			
			//Document fonts folder
			$font_path = $sourcefile.'/Document fonts';
			
			//check for file size
			   $source_package_size = $this->GetDirectorySize($sourcefile); //In bytes  folder size
			   $tsize = $source_package_size + $_FILES['file']['size'] ; //In bytes total folder size + uploaded file size
			   $tsize_mb = number_format($tsize / 1048576, 2); //In MB
			   $allowed_fsize = '400'; //In MB
		    if($tsize_mb > $allowed_fsize){
			     $source_package_size = number_format($source_package_size / 1048576, 2) . ' MB';
			     $uploaded_fsize = number_format($_FILES['file']['size'] / 1048576, 2) . ' MB';
			     echo "File Upload failed...Allowed Max Size for pacakage is 400 MB. The package already contains files of size - ".$source_package_size.". The uploaded file size is ".$uploaded_fsize;  
		    }else{
		            $tempFile = $_FILES['file']['tmp_name'];   
        			$fileName = $_FILES['file']['name'];
        				if($filetype == 'indd' || $filetype == 'pdf') 
            			{
            				$path_parts = pathinfo($_FILES['file']['name']);
            				$fName = $path_parts['filename'];
            					
            					if(strcmp($fName, $slug) == 0){
            						$path = $sourcefile;
            						$fileExt = $path_parts['extension'];
            						$fileExt = strtolower($fileExt);
            					}else{ echo "File name(".$fName.") is not same as slug name(".$slug.")..!!"; }
            			
            			}elseif($filetype == 'fonts'){
            			    $path = $font_path;
            			}elseif($filetype == 'links'){
            				$path = $link_path;
            			}
			        if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
            			echo "Error Uploading File.. Try Again..!!";
            		}else{ echo "success"; }
			   		
		    }
	    }			
	}
	
	/*page design start */
	
	public function pagination_orders($display_type = '') /******** April 28-2023 **************/
    {    
        $sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array(); 
        
        if($csr['category_level'] != null && $csr['club_id'] != null){
            $club_id = "(".$csr['club_id'].")";
			
			$cat_id = explode(',', $csr['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			$query = "SELECT orders.id, orders.publication_id, orders.adrep_id, orders.job_no, orders.status, orders.club_id, orders.adrep_id, orders.order_type_id, 
    			                         orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name,
    			                         cat_result.category, cat_result.designer, cat_result.csr, cat_result.pro_status, 
    			                         page_design_section.section_name, page_design_section.page_design_id
    			                    FROM `orders`
    			                        JOIN `cat_result` ON cat_result.order_no = orders.id
    			                        JOIN `page_design_section` ON page_design_section.id = orders.page_design_id";
            if(isset($cat_series)){
    			//Categorise orders -->  order_status = 1
    			$categorise_orders_query = "SELECT orders.id, orders.publication_id, orders.adrep_id, orders.job_no, orders.status, orders.club_id, orders.adrep_id, orders.order_type_id, 
    			                         orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name,
    			                         page_design_section.section_name, page_design_section.page_design_id
    			                    FROM `orders`
    			                        JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
    			                        WHERE orders.order_type_id = 6 AND orders.club_id IN $club_id AND orders.status = '1' AND orders.crequest != '1'; ";
    			
    			//myQ order_status = 2  TOTAL Q
    			$myQ_orders_query = $query." WHERE orders.order_type_id = 6 AND orders.club_id IN $club_id AND (orders.status BETWEEN '1' AND '4') AND orders.crequest != '1'
    									AND cat_result.pro_status != '5'AND cat_result.csr_QA = '$sId' ";
    						
    			//GeneralQ total_QA
    			$generalQ_orders_query = $query." WHERE orders.order_type_id = 6 AND orders.club_id IN $club_id AND cat_result.category IN ($cat_series) AND orders.status != '5' 
                    					AND cat_result.pro_status = '3' AND cat_result.csr_QA IS NULL AND orders.crequest != '1'";
    			
    			//All STARTS
    			$all_orders_query = $query." WHERE orders.order_type_id = 6 AND orders.club_id IN $club_id AND cat_result.category IN ($cat_series) 
    					            AND (orders.status BETWEEN '1' AND '4') AND orders.crequest != '1'";
    			
    			if($display_type == 'category'){	//Category
    				
    				$data['category_orders'] = $this->db->query($categorise_orders_query)->result_array();
    				
    			}elseif($display_type == 'QA'){		//myQA
    				
    				$data['myQ_orders'] = $this->db->query($myQ_orders_query)->result_array();
    				 
    			}elseif($display_type == 'new_pending'){ //All
    				
    				$data['all_orders'] = $this->db->query($all_orders_query)->result_array();
    				
    			}elseif($display_type == 'total_QA'){ //GeneralQ
    				
    				$data['generalQ_orders'] = $this->db->query($generalQ_orders_query)->result_array();
    				
    			}
    			//counts
    			$data['category_count'] 	= 	$this->db->query($categorise_orders_query)->num_rows();
    			$data['myQ_count']   		= 	$this->db->query($myQ_orders_query)->num_rows();
    			$data['generalQ_count'] 	= 	$this->db->query($generalQ_orders_query)->num_rows();
    			$data['all_count'] 			= 	$this->db->query($all_orders_query)->num_rows();
    			
    			$data['sId'] = $sId;
    			$data['display_type'] = $display_type;
    			$data['csr'] = $csr; 
    					
    			$this->load->view('new_csr/pagination_orders',$data);
            }else{
                $this->session->set_flashdata("message","Category Level Not Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		        redirect('new_csr/home');    
            }
		}else{
		    $this->session->set_flashdata("message","No Publication Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		    redirect('new_csr/home');
		}
    }
    
	public function page_index()
	{
	    if(isset($_GET['table_load'])){
	        $query = "SELECT orders.*, adreps.first_name AS adrepName, order_status.name AS order_status_name FROM orders
				                            JOIN `adreps` ON adreps.id = orders.adrep_id
						                    JOIN `order_status` ON order_status.id = orders.status
						                    JOIN `page_design` ON page_design.id = orders.page_design_id
				                            WHERE orders.order_type_id = '6'" ;
				                            
			$query .= " AND (";
		    //search or Filter
			if(isset($_GET['search']['value'])){
			    $this->db->group_start();
				$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

				$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';

				$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';

				$query .= ' OR orders.page_design_id LIKE "%'.$_GET["search"]["value"].'%"';

				$query .= ' OR orders.advertiser_name LIKE "%'.$_GET["search"]["value"].'%"';

			}
			$query .= ") ";
			
			//ORDER BY
			if(isset($_GET['order'])){
				$query .= ' ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
			}else{
				$query .= ' ORDER BY orders.activity_time DESC';
			}
			
			$extra_query = '';
			if($_GET['length'] != -1){
				$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
			}
			//echo $query;
			$filtered_rows = $this->db->query($query)->num_rows();
			$query .= $extra_query;
			
			$orders = $this->db->query("$query")->result_array();
			
			$total_rows = $this->db->query($query)->num_rows();
			
			$data = array();
			foreach($orders as $order){
			    $pdf_path = $order['pdf'];
			    $status = $order['status'];
			    $action = '';
				$sub_array = array();
				$sub_array[] = date("M d, Y", strtotime($order['created_on']));	//order created_on
				$sub_array[] = $order['id']; //order id
				$sub_array[] = $order['page_design_id']; //order page_design_id
				$sub_array[] = $order['job_no'];;	//order job_no/page name
				$sub_array[] = $order['publish_date'];;	//order publish_date
				$sub_array[] = $order['advertiser_name']; //order advertiser_name
    			$sub_array[] = $order['adrepName'];	//order Adrep Name
    			$sub_array[] = $order['order_status_name'];	//order Status Name
    			if($status <= '2' && $status != '0') {
    			    $action = '<form method="post" action="'.base_url().index_page().'new_csr/home/page_start_end/'.$order['id'].'">
							   	    <button type="submit" name="start" class="btn btn-primary btn-sm">Start Design</button>
							   </form>';
    			}elseif ($status == '3') {
    			    $action =   '<a href="'.base_url().index_page().'new_csr/home/pages_details/'.$order['id'].'" class="btn btn-success btn-sm">
							        View
						        </a>';
    			}
    			$sub_array[] = $action;	//order Start Design / View
    			
    			$data[] = $sub_array;
    		}
    		$output = array(
							"draw"    => intval($_GET["draw"]),
							"recordsTotal"  => $total_rows,
							"recordsFiltered" => $filtered_rows,
							"data"    => $data
						   );
			echo json_encode($output);
	    }else{
	        $this->load->view('page_csr_view/page_index'); 
	    }
	}

	function pagedesign($num = '1')
	{
        $rowsPerPage = 10; //each page 10 row
        $offset = ($num - 1) * $rowsPerPage; //num - 1 is page 1
		$page ="SELECT * FROM `page_design` WHERE `status` != '0'";
        if(isset($_GET['search'])){
            $search_id = $_GET['search_id'];
            if(isset($search_id) && !empty($search_id)){
                $page.=" AND `id` = '$search_id'";
            }
        }
        if(isset($_GET['advance_search'])){
            $advance_search_id = $_GET['advance_search_id'];
            if(isset($advance_search_id) && !empty($advance_search_id)){
                $page.=" AND `unique_job_name` LIKE '%".$advance_search_id."%'";
            }
            $data['advance_search_id']=$advance_search_id;
        }
        $data['order_count'] = $this->db->query("$page")->num_rows(); //$query give the number of rows 
        $page_design = $this->db->query("$page ORDER BY `id` DESC LIMIT $offset, $rowsPerPage;")->result_array(); 
        if(isset($page_design[0]['id'])){
            $data['all'] = $page_design;
            $data['rowsPerPage'] = $rowsPerPage;
            $data['offset'] = $offset;
            $data['num'] = $num;
        } 
		$this->load->view('page_csr_view/index',$data);
	}
	
    function pages_details($id='')//match the page design id in pages table then list pages
    {
        $page = $this->db->query("SELECT * FROM `orders` WHERE orders.pd_id=$id;")->result_array();
        $order_id = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->row_array();
        $data['all'] = $page;
        $data['order_id'] = $order_id;
        $this->load->view('page_csr_view/pages_details',$data);
    }
	
    function page_start_end($id='')
    {
        date_default_timezone_set('Asia/Kolkata');
        $time = date('h:i:s');
        $data = array(
            'start_time'=>$time,
            'status'=>'3');
        $this->db->where('id',$id);
        $this->db->update('page_design',$data);
        redirect("new_csr/home/page_end/".$id);
    }
	
    function page_zip_upload($id = '')  //receive the pages id and page_design id  upload the articles
    {
        $page_design = $this->db->get_where('page_design',array('id'=>$id))->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("zip");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a zip file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$page_design['id'];
                if(@mkdir($path,0777)){}
                $path = "page_sourcefile/".$page_design['id'].'/'.'v1';
                if(@mkdir($path,0777)){}
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $zip = array('zip'=>$path);    //only store the path of the file
                    $this->db->where('id', $id);
                    $this->db->update('page_design', $zip);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
	
    function page_pdf_upload($id = '')  //receive the pages id and page_design id  upload the articles
    {
        $page_design = $this->db->get_where('page_design',array('id'=>$id))->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("pdf");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a PDF file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$page_design['id'];
                if(@mkdir($path,0777)){}
                $path = "page_sourcefile/".$page_design['id'].'/'.'v1';
                if(@mkdir($path,0777)){}
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $pdf = array('pdf'=>$name);    //only store the path of the file
                    $this->db->where('id', $id);
                    $this->db->update('page_design', $pdf);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
	
    public function page_remove_zip_file($id='')
    {
        $zipremove = $this->db->get_where('page_design',array('id' => $id))->row_array();
        if (isset($_POST['filename']) && isset($zipremove['id']))
        {
            $filename = $_POST['filename'];
            $filepath = $zipremove['zip'];
            $dirhandle = opendir($filepath);
            while ($file = readdir($dirhandle))
            {
                if ($file == readdir($filename))
                {
                    unlink($filepath.'/'.$filename);
                }
            }
        }
    }
	
    function page_end($id='')
    {
        $this->load->library('zip');
        $view_uploads = $this->db->query("SELECT * FROM `page_design` WHERE `id`= $id;")->row_array();
        $zip_view = $view_uploads['zip'];
        if ($zip_view != null && file_exists($zip_view) && $atp = opendir($zip_view)) //check the notnull exitsfile and openfile
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                { 
                    $allowedExts = array("zip");
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if(in_array($extension, $allowedExts))
                    {
                        $zipname[]=$file;
                        $data['zip_name'] = $zipname;
                    }
                }
                
            }
             closedir($atp);//dirctry $atp clocsed
        }
        
        $file_upload = $this->db->query("SELECT * FROM `page_design` WHERE `id` = $id")->row_array();
        $data['pass_id']=$file_upload;
        $page_list =$this->db->query("SELECT * FROM `pages` WHERE `pd_id`=$id;")->result_array();
        $data['list']=$page_list;
        if (isset($_POST['end']))
        {
            $IN_Production = $this->db->query("SELECT * FROM page_design WHERE page_design.id=$id AND page_design.zip is null ;")->row_array() ;
            $IN_Production1 = $this->db->query("SELECT * FROM page_design WHERE page_design.id=$id AND page_design.pdf is null ;")->row_array() ;
            if ($IN_Production || $IN_Production1){
                redirect('new_csr/home/page_start_end/'.$id);
            }else{
                date_default_timezone_set('Asia/Kolkata');
                $time = date('h:i:s');
				//copy pdf file from page_source to page_pdf folder
				$source_path = "page_sourcefile/".$file_upload['id'].'/v1/'.$file_upload['pdf'];
				$dest_path = 'page_pdf/'.$file_upload['id'];
				if (@mkdir($dest_path,0777)){}
				
				if(file_exists($source_path)){
					copy($source_path, $dest_path.'/'.$file_upload['pdf']);
				}
                $data = array(
						   'end_time'=>$time,
						   'status'=>'5');
                $this->db->where('id',$id);
                $this->db->update('page_design',$data);
				
				//send mail
				$client = $this->db->get_where('adreps',array('id' => $file_upload['user_id']))->row_array();
				
				$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client['publication_id']."'")->row_array();
				
				$design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication['design_team_id']."'")->row_array();
				
				$dataa['subject'] = 'New Ad: '.$id ;
				$dataa['from'] = $design_team['email_id'];
				$dataa['from_display'] = 'Design Team';
				$dataa['replyTo'] = $design_team['email_id'];
				$dataa['replyTo_display'] = 'Design Team';
				$dataa['recipient'] = $client['email_id']; 
				$dataa['fname'] = $file_upload['pdf']; 
				$dataa['temp'] = $dest_path.'/'.$file_upload['pdf']; 
				$dataa['recipient_display'] = $client['first_name'].' '.$client['last_name'];
				$this->page_test_mail($dataa);
				
                redirect('new_csr/home/page_index');
            }
        }
        $this->load->view('page_csr_view/start_end',$data);
    }
	
	public function page_test_mail($dataa) 
	{ 
		$config = array();
                $config['useragent'] = "CodeIgniter";
                $config['mailpath']  = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']  = "smtp";
                $config['smtp_host'] = "localhost";
                $config['smtp_port'] = "25";
                $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;

        $this->load->library('email');
		$this->email->initialize($config);
		
		$this->email->from($dataa['from'], $dataa['from_display']);
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		
		if(isset($dataa['Cc'])){
		    $this->email->bcc($dataa['Cc']);
		}else{ $this->email->bcc('itsupport@adwitads.com');  }
	   
		$this->email->subject($dataa['subject']);  
	    $this->email->message("The High-Res version of ad is attached for your perusal. If approved you may forward this pdf to production.");
	    
	    if(isset($dataa['temp'])){ $this->email->attach($dataa['temp'],$dataa['fname']); }  
		
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
		
		$this->email->send();
	}
	
    function view_pages($id='')//match the page design id in pages table then list pages
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->result_array();
        $order_id = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->row_array();
        $data['all'] =$page;
        $data['order_id']=$order_id;
        $this->load->view('page_csr_view/view_pages',$data);
    }
	
    function page_revision_design($num = '1')
    {
        $rowsPerPage = 10; //each page 10 row
        $offset = ($num - 1) * $rowsPerPage; //num - 1 is page 1
        $page ="SELECT * FROM `page_revision` WHERE note is not null";
        if (isset($_GET['search'])) 
        {
            $search_id = $_GET['search_id'];
            if (isset($search_id) && !empty($search_id)) 
            {
                $page.="WHERE `id` = '$search_id'";
            }
        }
        if (isset($_GET['advance_search'])) 
        {
            $advance_search_id = $_GET['advance_search_id'];
            if (isset($advance_search_id) && !empty($advance_search_id)) 
            {
                $page.="WHERE `pd_id` = '$advance_search_id'";
            }
            $data['advance_search_id']=$advance_search_id;
        }
        $data['order_count'] = $this->db->query("$page")->num_rows(); //$query give the number of rows 
        $page_design = $this->db->query("$page ORDER BY `id` DESC LIMIT $offset, $rowsPerPage;")->result_array(); 
        if(isset($page_design[0]['id']))
        {
            $data['all'] =$page_design;
            $data['rowsPerPage'] = $rowsPerPage;
            $data['offset'] = $offset;
            $data['num'] = $num;
        }
        $this->load->view("page_csr_view/revision_design",$data);
    }
	
    function page_rev_start_end($revid = '')
    {
        $zip_view = $this->db->query("SELECT * FROM `page_revision` WHERE `id` = $revid;")->row_array();
        $zip_view = $zip_view['zip_path'];
        if ($zip_view != null && file_exists($zip_view) && $atp = opendir($zip_view))
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
				$zipname = '';
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                {
                    $allowedExts = array("zip");
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if(in_array($extension, $allowedExts))
                    $zipname[]=$file; 
                    //$zipname[]=$file;//store all article name in array
                }
                $data['zip_name'] = $zipname;// array of name will stored in articles_name
            }
             closedir($atp);
        } 
        $zip_view = $this->db->query("SELECT * FROM `page_revision` WHERE `id` = $revid;")->row_array();
        $pdf_view = "page_sourcefile/".$zip_view['pd_id'].'/'.$zip_view['revision_version'];
        if ($pdf_view != null && file_exists($pdf_view) && $atp = opendir($pdf_view))
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                { 
                    $allowedExts = array("pdf");
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if(in_array($extension, $allowedExts))
                    {
                        $pdfname[] = $file;
                        $data['pdf_name'] = $pdfname;
                    } 
                }
                //$data['pdf_name'] = $zipname;// array of name will stored in articles_name
            }
             closedir($atp);
        } 
        if (isset($_POST['start']))
        {
            $data1 = array('status' => '4');
            $this->db->where('id',$revid);
            $this->db->update('page_revision',$data1);
            
        }
        $order_id = $this->db->query("SELECT * FROM page_revision WHERE `id`=$revid;")->row_array();
        $data['all'] = $order_id;
        $this->load->view("page_csr_view/rev_start_end",$data);
    }
	
    function page_rev_zip_upload($id = '',$pdid='')  //receive the pages id and page_design id  upload the articles
    {
        $revision = $this->db->query("SELECT page_revision.revision_version,page_design.id,page_design.zip FROM `page_design` INNER JOIN `page_revision` ON page_revision.pd_id=page_design.id WHERE page_revision.id=$id;")->row_array();
        //$revision = $this->db->get_where('revision',array('id'=>$id))->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {

            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("zip");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$pdid;
				if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
                $path = $path.'/'.$revision['revision_version'];
                if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
				
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $zip = array('zip_path'=>$path);    //only store the path of the file
                    $this->db->where('id',$id);
                    $this->db->update('page_revision', $zip);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
	
    function page_rev_pdf_upload($id = '',$pdid='')  //receive the pages id and page_design id  upload the articles
    {
       $revision = $this->db->query("SELECT page_revision.revision_version,page_design.id,page_design.zip FROM `page_design` INNER JOIN `page_revision` ON page_revision.pd_id=page_design.id WHERE page_revision.id=$id;")->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {

            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("pdf");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$pdid;
				if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
                $path = $path.'/'.$revision['revision_version'];
                if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
				
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $pdf = array('pdf_path' => $name);    //only store the path of the file
                    $this->db->where('id', $id);
                    $this->db->update('page_revision', $pdf);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
		
    function page_rev_end($revid='')
    {
		$rev_details = $this->db->query("SELECT * FROM `page_revision` WHERE `id`='$revid' AND `pdf_path` IS NOT NULL")->row_array();
        if (isset($_POST['end']) && isset($rev_details['id']))
        {
			$path = 'page_sourcefile/'.$rev_details['pd_id'].'/'.$rev_details['revision_version'].'/'.$rev_details['pdf_path'];
			if(file_exists($path)){
				//copy pdf file from page_source to page_pdf folder
				$source_path = $path;
				$dest_path = 'page_pdf/'.$rev_details['pd_id'];
				if(!file_exists($dest_path)){
					if (@mkdir($dest_path,0777)){}
				}
				
				if(copy($source_path, $dest_path.'/'.$rev_details['pdf_path'])){
					$data1 = array('status' => '3');
					$this->db->where('id', $revid);
					$this->db->update('page_revision', $data1);
					
					//send email notification
					$page_design = $this->db->query("SELECT * FROM `page_design` WHERE `id`= '".$rev_details['pd_id']."'")->row_array();
					if(isset($page_design['user_id'])){
					$client = $this->db->get_where('adreps',array('id' => $page_design['user_id']))->row_array();
				
					$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client['publication_id']."'")->row_array();
					
					$design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication['design_team_id']."'")->row_array();
					
					$dataa['subject'] = 'Revision Ad: '.$rev_details['pd_id'].'-'.$rev_details['revision_version'] ;
					$dataa['from'] = $design_team['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
					$dataa['recipient'] = $client['email_id']; 
					$dataa['fname'] = $rev_details['pdf_path']; 
					$dataa['temp'] = $dest_path.'/'.$rev_details['pdf_path']; 
					$dataa['recipient_display'] = $client['first_name'].' '.$client['last_name'];
					$this->page_test_mail($dataa);
					}
					
					$this->session->set_flashdata('message',$rev_details['pd_id'].' Revision Completed..');
					redirect("new_csr/home/page_revision_design");
				}else{
					$this->session->set_flashdata('message','PDF File copy error..');
					redirect("new_csr/home/page_rev_start_end/".$revid);
				}
			}else{
				$this->session->set_flashdata('message','PDF not found..');
				redirect("new_csr/home/page_rev_start_end/".$revid);
			}
        } else {
			$this->session->set_flashdata('message','PDF File Missing..');
			redirect("new_csr/home/page_rev_start_end/".$revid);
		} 
    }
	
    function page_source($id='')
    {
        $version = $this->db->query("SELECT page_revision.revision_version,page_design.zip FROM `page_design` INNER JOIN `page_revision` ON page_revision.pd_id=page_design.id WHERE page_design.id=$id;")->row_array();
        $pdf_view =$version['zip'];
        if (file_exists($pdf_view))
        {
            $zip_path = $pdf_view.'.zip';
            $this->load->library('zip');
            $this->zip->read_dir($pdf_view.'/', true);
            if (preg_match('/\bv1\b/',$zip_path)){
            $this->zip->download('v1');
            }elseif (preg_match('/\bV1a\b/',$zip_path)) {$this->zip->download('V1a');
            }elseif (preg_match('/\bV1b\b/',$zip_path)) {$this->zip->download('V1b');
            }elseif (preg_match('/\bV1c\b/',$zip_path)) {$this->zip->download('V1c');
            }elseif (preg_match('/\bV1d\b/',$zip_path)) {$this->zip->download('V1d');
            }elseif (preg_match('/\bV1e\b/',$zip_path)) { $this->zip->download('V1e');
            }elseif (preg_match('/\bV1f\b/',$zip_path)) { $this->zip->download('V1f');
            }elseif (preg_match('/\bV1g\b/',$zip_path)) { $this->zip->download('V1g');
            }elseif (preg_match('/\bV1h\b/',$zip_path)) { $this->zip->download('V1h');
            }elseif (preg_match('/\bV1i\b/',$zip_path)) { $this->zip->download('V1i');
            }elseif (preg_match('/\bV1j\b/',$zip_path)) { $this->zip->download('V1j');
            }elseif (preg_match('/\bV1k\b/',$zip_path)) { $this->zip->download('V1k');
            }elseif (preg_match('/\bV1l\b/',$zip_path)) { $this->zip->download('V1l');
            }elseif (preg_match('/\bV1m\b/',$zip_path)) { $this->zip->download('V1m');
            }elseif (preg_match('/\bV1n\b/',$zip_path)) { $this->zip->download('V1n');
            }elseif (preg_match('/\bV1o\b/',$zip_path)) { $this->zip->download('V1o');
            }elseif (preg_match('/\bV1p\b/',$zip_path)) { $this->zip->download('V1p');
            }elseif (preg_match('/\bV1q\b/',$zip_path)) { $this->zip->download('V1q');
            }elseif (preg_match('/\bV1r\b/',$zip_path)) { $this->zip->download('V1r');
            }elseif (preg_match('/\bV1s\b/',$zip_path)) { $this->zip->download('V1s');
            }elseif (preg_match('/\bV1t\b/',$zip_path)) { $this->zip->download('V1t');
            }elseif (preg_match('/\bV1u\b/',$zip_path)) { $this->zip->download('V1u');
            }elseif (preg_match('/\bV1v\b/',$zip_path)) { $this->zip->download('V1v');
            }elseif (preg_match('/\bV1w\b/',$zip_path)) { $this->zip->download('V1w');
            }elseif (preg_match('/\bV1x\b/',$zip_path)) { $this->zip->download('V1x');
            }elseif (preg_match('/\bV1y\b/',$zip_path)) { $this->zip->download('V1y');
            }elseif (preg_match('/\bV1z\b/',$zip_path)) { $this->zip->download('V1z');
            }else{echo"error - ". $zip_path;}
            
        }
    }
	
    public function page_pdf($id='')
    {
        $query = $this->db->query("SELECT * FROM page_design WHERE `id`=$id;")->row_array();
        $filename = $query['pdf'];
        $path = "page_sourcefile/".$query['id'].'/v1/'.$filename;
        if (file_exists($path)){
            header("Content-type: application/pdf");
            header('Content-Disposition: inline;filename="'.$filename.'"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($path);
        }else{
          echo"error - ". $filename;
        }
    }

/*page design end */

    public function order_status_notification()
    {
        $this->load->view('new_csr/order_status_notification');
    }
    
    public function order_status_notification_content() 
    { 
       $query = "SELECT a.*, orders.help_desk FROM order_status_change_notification a 
                     LEFT JOIN `orders` ON orders.id = a.order_id
                    INNER JOIN (SELECT order_id, max(id) as maxid FROM order_status_change_notification GROUP BY order_id ORDER BY timestamp DESC) as b 
                    on a.id = b.maxid";
       
       $query .= " AND (";
		//search or Filter
		if(isset($_GET['search']['value'])){
			$query .= ' a.order_id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR a.notification LIKE "%'.$_GET["search"]["value"].'%"';
		}
		$query .= ") ";
		
		if(isset($_GET['order'])){
			$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
		}else{
			$query .= 'ORDER BY a.id DESC';
		}
			
		$extra_query = '';
		if($_GET['length'] != -1){
			$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
		}
			//echo '<script>console.log('.$query.')</script>';//echo $query;
		$filtered_rows = $this->db->query($query)->num_rows();
		$query .= $extra_query;
			
		$notifications = $this->db->query("$query")->result_array();
						   
		$total_rows = $this->db->query($query)->num_rows();
		
		$data = array(); 
			//$data[] = $query;
		foreach($notifications as $row){
		    $sub_array = array();
				
			$sub_array[] = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$row['help_desk'].'/'.$row['order_id'].'">'.$row['order_id'].'</a>'; 
    		$sub_array[] = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$row['help_desk'].'/'.$row['order_id'].'">'.$row['notification'].'</a>'; 
    		
    		$data[] = $sub_array;
		}
		
		$output = array(
						"draw"    => intval($_GET["draw"]),
						"recordsTotal"  => $total_rows,
						"recordsFiltered" => $filtered_rows,
						"data"    => $data
						);
		echo json_encode($output);
    }
    
    public function test_assign()
    {
        $club_id = 20;
        $category = 'T';
    				        $assign_order = $this->db->query("SELECT `designers_id` FROM `assign_order` 
    				                                            WHERE `club_id` = '$club_id' AND `category` = '$category' 
    				                                            ORDER BY `assigned_on` DESC LIMIT 1;")->row_array();
    				        $query = "SELECT `id` FROM `designers` 
    				                    WHERE (`club_id` LIKE '$club_id,%' OR `club_id` LIKE '%,$club_id' OR `club_id` LIKE '%,$club_id,%') 
    				                    AND `category_level` LIKE '%".$category."%' AND `is_active` = 1 AND `isEnabled_adwit_teams` = 1";
    				        if(isset($assign_order['designers_id'])){
    				            $query .= " AND `id`>".$assign_order['designers_id'];
    				        }
    				        $assign_designer = $this->db->query($query." ORDER BY `id` LIMIT 1 ;")->row_array();
    				        
    				        if(isset($assign_designer['id'])){
    				            //assign_order 
    				            $assign_order_array = array(
    				                                        'category' => $category,
    				                                        'club_id' => $club_id,
    				                                        'designers_id' => $assign_designer['id']
    				                                        );
    				            $this->db->insert('assign_order', $assign_order_array);
    				        }
    				        echo $query;
    }
//tscs preorder START    
    public function tscs_preorder_list()
    {
        $this->load->view('new_csr/tscs_preorder_list');
    }
    
    public function tscs_preorder_list_content()
	{
        $query = "SELECT a.* FROM `tscs_preorder` a WHERE a.status = '0'";
       
        $query .= " AND (";
		//search or Filter
		if(isset($_GET['search']['value'])){
			$query .= ' a.job_no LIKE "%'.$_GET["search"]["value"].'%"';

			//$query .= ' OR a.notification LIKE "%'.$_GET["search"]["value"].'%"';
		}
		$query .= ") ";
		
		if(isset($_GET['order'])){
			$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
		}else{
			$query .= 'ORDER BY a.timestamp DESC';
		}
			
		$extra_query = '';
		if($_GET['length'] != -1){
			$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
		}
		
		$filtered_rows = $this->db->query($query)->num_rows();
		$query .= $extra_query;
			
		$tscs_preorder = $this->db->query("$query")->result_array();
						   
		$total_rows = $this->db->query($query)->num_rows();
		$data = array();
		foreach($tscs_preorder as $row){
		    $publication_detail = $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `id` = ".$row['publication_id'])->row_array();
		    $publication_name = '';
		    if(isset($publication_detail['id'])){
		        $publication_name = $publication_detail['name'];    
		    }
            $form_tab = '<a href="'.base_url().index_page().'new_csr/home/tscs_order_form/'.$row['id'].'"><button class="btn btn-xs padding-5 btn-blue">Submit</button></a>';
            $sub_array = array();
            $sub_array[] = date("M d, Y",strtotime($row['timestamp']));
            $sub_array[] = $publication_name;
            $sub_array[] = $row['job_no'];
            $sub_array[] = $row['advertiser_name'];
            $sub_array[] = $row['width'];
            $sub_array[] = $row['height'];
            $sub_array[] = $row['ad_color_info'];
            $sub_array[] = $row['notes'];
            $sub_array[] = $form_tab;
                
            $data[] = $sub_array;
        }
        
            $output = array(  
                "draw"              =>     intval($_GET["draw"]),  
                "recordsTotal"      =>     $total_rows,  
                "recordsFiltered"   =>     $filtered_rows,  
                "data"              =>     $data  
           );  
           echo json_encode($output);  
            
	}
	
	public function tscs_correction_preorder_list()
    {
        $this->load->view('new_csr/tscs_correction_preorder_list');
    }
    
    public function tscs_correction_preorder_list_content()
	{
        $query = "SELECT a.* FROM `tscs_correction_preorder` a WHERE a.status = '0'";
       
        $query .= " AND (";
		//search or Filter
		if(isset($_GET['search']['value'])){
			$query .= ' a.job_no LIKE "%'.$_GET["search"]["value"].'%"';
		}
		$query .= ") ";
		
		if(isset($_GET['order'])){
			$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
		}else{
			$query .= 'ORDER BY a.timestamp DESC';
		}
			
		$extra_query = '';
		if($_GET['length'] != -1){
			$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
		}
		
		$filtered_rows = $this->db->query($query)->num_rows();
		$query .= $extra_query;
			
		$tscs_preorder = $this->db->query("$query")->result_array();
						   
		$total_rows = $this->db->query($query)->num_rows();
		$data = array();
		foreach($tscs_preorder as $row){
		    $form_tab = '<a href="'.base_url().index_page().'new_csr/home/tscs_correction_order_form/'.$row['id'].'"><button class="btn btn-xs padding-5 btn-blue">Submit</button></a>';
            $sub_array = array();
            $sub_array[] = date("M d, Y",strtotime($row['timestamp']));
            $sub_array[] = $row['order_id'];
            $sub_array[] = $row['job_no'];
            $sub_array[] = $row['notes'];
            $sub_array[] = $form_tab;
                
            $data[] = $sub_array;
        }
        
            $output = array(  
                "draw"              =>     intval($_GET["draw"]),  
                "recordsTotal"      =>     $total_rows,  
                "recordsFiltered"   =>     $filtered_rows,  
                "data"              =>     $data  
           );  
           echo json_encode($output);  
            
	}
	
	public function tscs_order_form($tscs_preorder_id = '')
	{
	    $tscs_preorder_detail = $this->db->query("SELECT a.*, publications.name AS publicationName, adreps.id AS adrepId, CONCAT(adreps.first_name,'',adreps.last_name) AS adrepName  FROM `tscs_preorder` a 
	                                                JOIN `publications` ON publications.id = a.publication_id
	                                                JOIN `adreps` ON adreps.publication_id = publications.id
	                                                WHERE a.id = $tscs_preorder_id AND a.status = '0'")->row_array();
        if(isset($tscs_preorder_detail['id'])){
            $data['tscs_preorder_detail'] = $tscs_preorder_detail;
            $publication_id = $tscs_preorder_detail['publication_id'];
            $adrep_id = $tscs_preorder_detail['adrepId'];
            $zip_file_path = $tscs_preorder_detail['zip_file_path'];
            
            if(isset($_POST['cancelSubmit'])){ //cancel preorder
                //update tscs_preorder status
				$update_status = array('status' => '2'); //order cancel
				$this->db->where('id', $tscs_preorder_id);
				$this->db->update('tscs_preorder', $update_status);
									
				$this->session->set_flashdata("message","Order Cancelled!!");
				redirect('new_csr/home/tscs_preorder_list');    
			}
			
            if(isset($_POST['Submit']))
			{
				$art = $_POST['artinst'];
				$adtype = $_POST['adtype'];
				
				$w = $_POST['width'];
				$h = $_POST['height'];
				
				$size = $w * $h;
				if($size == '0'){
					$this->session->set_flashdata("message","Provide Proper values for Width and Height!!!");
					redirect('new_csr/home/tscs_order_form/'.$tscs_preorder_id);
				}
						
				$category = $this->cat_calc($adtype); //cat_calc()
					
				$_POST['job_name'] = preg_replace('/[^A-Za-z0-9\s]/','',$_POST['job_name']);	//replace special char
					
				$orders = $this->db->query("SELECT `id` FROM `orders` WHERE `job_no` = '".$_POST['job_name']."'")->row_array();
				if(isset($orders['id'])){
					$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
					redirect('new_csr/home/tscs_order_form/'.$tscs_preorder_id);
				}else{
						if(empty($_POST['rush'])){ $_POST['rush']='0'; }
						//publish date
							$next_day =  date('D', strtotime(' +1 day'));
							if($next_day == 'Sat' || $next_day == 'Sun'){
								$publish_date = date('Y-m-d', strtotime('next monday'));
							}else{
								$publish_date = date('Y-m-d', strtotime(' +1 day'));
							}
						
						$pub_details = $this->db->get_where('publications',array('id' => $publication_id))->row_array();
						$help_desk = $pub_details['help_desk']; 
						$news_id = $pub_details['news_id'];
						$initial = $pub_details['initial'];
						$slug_type = $pub_details['slug_type'];
						$team = $pub_details['design_team_id'];
						$group_id = $pub_details['group_id'];
						$club_id = $pub_details['club_id'];
						
						$post = array(
    								'adrep_id' => $adrep_id,
    								'csr' => $this->session->userdata('sId'), 
    								'publication_id' => $publication_id,
    								'group_id' => $group_id,
    								'help_desk' => $help_desk,
    								'order_type_id' => '2', 	//print ad
    								'advertiser_name' => $_POST['advertiser'],
    								'job_no' => $_POST['job_name'],
    								'copy_content_description' => $_POST['copy_content_description'],
    								'width' => $_POST['width'],
    								'height' => $_POST['height'],
    								'print_ad_type' => $_POST['print_ad_type'],
    								'activity_time' => date('Y-m-d h:i:s'),
    								'rush' => $_POST['rush'],
    								'publish_date' => $publish_date,
    								'club_id'=> $club_id,
								);
							
						$this->db->insert('orders',$post);	
						$order_no = $this->db->insert_id();

						if($order_no){
							//Live_tracker updation
								$tracker_data = array(
                    								'pub_id'=> $publication_id,
                    								'order_id'=> $order_no,
                    								'job_no' => $_POST['job_name'],
                    								'club_id'=> $club_id,
                    								'status' => '1'
                    								);
								$this->db->insert('live_orders', $tracker_data);
							
							$this->orders_folder($order_no, $help_desk);	// folder creation, html_form
							
							//move preorder zip file to downloads folder
							$order_detail = $this->db->query("SELECT `id`, `file_path` FROM `orders` WHERE `id` = ".$order_no)->row_array(); //need file_path updated details
							$source_path = $zip_file_path; $destination_path = $order_detail['file_path'].'/'.basename($zip_file_path);
							rename($source_path, $destination_path);
							
							if (!empty($_FILES['ufile']['tmp_name'][0]) || !empty($_FILES['ufile']['tmp_name'][1]))
							{
								$data = array();	//file data sent to file_upload function
								for($i=0;$i<10;$i++){
									if (!empty($_FILES['ufile']['tmp_name'][$i])){
										$data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
										$data['fname'.$i] = $_FILES['ufile']['name'][$i];
									}
								}
								$data['id'] = $order_no;
								$this->file_upload($data); //file uploads
							}
						
							$dataa = array(
    									'order_no' => $order_no,
    									'job_name' => $_POST['job_name'],
    									'adrep' => $adrep_id,
    									'advertiser' => $_POST['advertiser'], 
    									'width' => $w,
    									'height' => $h,
    									'artinstruction' => $_POST['artinst'],
    									'adtypewt' => $_POST['adtype'],
    									'help_desk' => $help_desk,
    									'publication_id' => $publication_id,
    									'news_id' => $news_id,
    									'news_initial' => $initial,
    									'team' => $team,
    									'slug_type' => $slug_type,
    									'category' => $category,
    									'csr' => $this->session->userdata('sId'),
    									'date' => Date("Ymd"),
    									'time' => date("His"),
    									//'adwit_teams_id' => $adwit_teams_id
									);
							$this->db->insert('cat_result',$dataa);	
							$cat_id = $this->db->insert_id();
							
							$data2 = array(
										'order_no' => $order_no,
										'csr' => $this->session->userdata('sId'),
										'news_id' => $news_id,
										'publication_id'  => $publication_id,
										'help_desk'  => $help_desk,
										'date' => Date("Ymd"),
										'time' => date("His"),
										'category' => $category,
										);
							$this->db->insert('cshift',$data2);
							$status = 'v1';
						
							if($cat_id){
								//order status
								$post_status = array('status' => '2');
								$this->db->where('id', $order_no);
								$this->db->update('orders', $post_status);
								
								//Live_tracker Updation
								$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_no."' ")->row_array();
								if(isset($update_order['id'])){
									$tracker_data = array('csr_id' => $this->session->userdata('sId'), 'category' => $category, 'status' => '2');
									$this->db->where('id', $update_order['id']);
									$this->db->update('live_orders', $tracker_data);
								}
								
								//update tscs_preorder status
								$update_status = array('status' => '1'); //order accepted
								$this->db->where('id', $tscs_preorder_id);
								$this->db->update('tscs_preorder', $update_status);
									
								$this->session->set_flashdata("message","Order No: ".$order_no." Submitted!!");
								redirect('new_csr/home/tscs_preorder_list');
							}else{ 
								$this->session->set_flashdata("message","Order not categorised Try Again.. Had some problem with database..!!!");
								redirect('new_csr/home/tscs_order_form/'.$tscs_preorder_id);
							}
						}else{
							$this->session->set_flashdata("message","Internal Error!! Order not placed.. Try again..");
							redirect('new_csr/home/tscs_order_form/'.$tscs_preorder_id);
						}
					}		
				}
            $this->load->view('new_csr/tscs_order_form', $data);
	    }else{
    	    $this->session->set_flashdata("message","Order not in Queue");
    		redirect('new_csr/home/tscs_preorder_list');
	    }
    }
        
//tscs preorder START 
    public function revision_order_deletion()
    {
        $rev_id = $_POST['rev_id'];
        $revision_detail = $this->db->query("SELECT `id`, `order_id`, `version` FROM `rev_sold_jobs` WHERE `id` = $rev_id;")->row_array();
        if(isset($revision_detail['id'])){
            $order_id = $revision_detail['order_id'];
            $order_detail = $this->db->query("SELECT `id`, `job_no`, `rev_count` FROM `orders` WHERE `id` = $order_id;")->row_array();
            if(isset($order_detail['id'])){
                //delete the entry of order from rev_sold_jobs
                $this->db->query("DELETE FROM `rev_sold_jobs` WHERE `id`= '".$rev_id."'");
                
                $previous_revision_details = $this->db->query("SELECT `id`, `order_id`, `status` FROM `rev_sold_jobs` WHERE `order_id` = $order_id ORDER BY `id` DESC LIMIT 1;")->row_array();
                if(isset($previous_revision_details['id'])){
                    $rev_count = $order_detail['rev_count'] - 1;
                    $rev_id = $previous_revision_details['id'];
                    $rev_order_status = $previous_revision_details['status'];
                }else{
                    $rev_count = '';
                    $rev_id = '';
                    $rev_order_status = 0; 
                }
                $update_data = array(
                                        'rev_count' => $rev_count,
                                        'rev_id' => $rev_id,
                                        'rev_order_status' => $rev_order_status,
                                    ); 
                $this->db->where('id', $order_id);
				$this->db->update('orders', $update_data); 
				
				$post_data = array('order_id' => $order_id, 'job_number' => $order_detail['job_no'], 'csr_id' => $this->session->userdata('sId'));
				$this->db->insert('tscs_orders_deleted_csr', $post_data);
				
				echo 'Deleted Job No - '.$order_detail['job_no'].' - '.$revision_detail['version'];
            }
        }
        //echo 'Deleted - '.$_POST['rev_id'];
    }
    
    public function remove_attachment($order_id, $filename) //downloads file delete option for TSCS orders
	{ 
		$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = $order_id")->row_array();
		if(isset($order_details['file_path'])){ 
			$filepath = $order_details['file_path'];
			
			$dirhandle = opendir($filepath);
			while ($file = readdir($dirhandle)) { 
				if($file==$filename){ unlink($filepath.'/'.$filename); }
			}
		}		
	}
	
	public function sit($order_id) //simplified Instruction Toll
	{
	    $order_details = $this->db->query("SELECT `id`, `notes`, `help_desk`, `file_path`, `job_no` FROM `orders` WHERE `id` = $order_id")->row_array();
	    if(isset($order_details['id'])){
	        if(isset($_POST['custom_notes']) && !empty($_POST['custom_notes'])){
	            $notes = str_replace(array("\r\n", "\n", "\r"), ' ', $_POST['custom_notes']);    
	        }else{
    	        $notes = str_replace(array("\r\n", "\n", "\r"), ' ', $order_details['notes']); 
	        }
    	    //echo $notes;
    	    $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://admin.adwitads.com/chat-ai/v1/api',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "chatRequest": "'.$notes.'"
            }',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: JSESSIONID=86CF622F21D890F94175D179423358FF'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
           // echo 'API Response - '.$response;
           // echo '<br/>Order Notes - '.$notes.'<br/>'; 
           if(isset($_POST['revision_id'])){
                $path = 'SIT_notes/'.$order_id.'-'.$_POST['revision_id'].'.txt';
           }else{
                $path = 'SIT_notes/'.$order_id.'.txt';
           }
             
            file_put_contents($path, $response);
            
            //html file update
            if(!empty($response)){
                $html_file = $order_details['file_path'].'/'.$order_details['job_no'].'.html';
                if(file_exists($html_file)){
                    $fh = fopen($html_file, 'a') or die("can't open file");
                   /* $content = '<div>
                                    <table>
                                        <tr style="background-color:#eee; vertical-align: top;">
                                            <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;"><b>Simplified Instructions</b></p></td>
                                        </tr>
                                        <tr style="background-color:#eee; vertical-align: top;">
                                            <td colspan="4" align="center">
                                                <p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
                                                '.$response.'
                                        		</p>
                                        	</td>
                                        </tr> 
                                    </table>
                                </div>';
                     */           
                    $content =  '<div class="border border-radius-4 mt-5">
									<div class="order-head fw-bolder ">SIT</div>
									<div class="row">
										<div class="col-md-12 ps-6 pt-6 pb-6">
										    '.$response.'
										</div>
								    </div>
								</div>';
                    fwrite($fh, $content);
    				fclose($fh);
                }
	        }
	    }
	    redirect('new_csr/home/orderview/'.$order_details['help_desk'].'/'.$order_id);
	}
	
	public function add_extra_sizes($order_id)
	{
	    $order_detail = $this->db->query("SELECT orders.id, orders.help_desk, orders.order_type_id, orders.job_no, orders.ad_format, orders.pixel_size, orders.flexitive_size, orders.custom_width, orders.custom_height,
	                                        CONCAT(adreps.first_name,' ',adreps.last_name) AS adrepName, publications.name AS publicationName FROM `orders` 
	                                        JOIN `adreps` ON adreps.id = orders.adrep_id
	                                        JOIN `publications` ON publications.id = orders.publication_id
	                                        WHERE orders.id =  '$order_id'")->row_array();
	    if(isset($order_detail['id'])){
	        $data['order_detail'] = $order_detail;
	        if($order_detail['order_type_id'] == '1'){
	            if($order_detail['ad_format']=='5'){ //flexitive ad (flexitive size)
    		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, flexitive_size.ratio, flexitive_size.ratio AS name FROM `orders_multiple_size`
                    							                LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
                    							                    WHERE orders_multiple_size.order_id = '".$order_detail['id']."'")->result_array();
    		    }else{ //pixel size
    		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, pixel_sizes.width, pixel_sizes.height, CONCAT(pixel_sizes.width,'x',pixel_sizes.height) AS name FROM `orders_multiple_size`
                    							            LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
                    							                WHERE orders_multiple_size.order_id = '".$order_detail['id']."'")->result_array();
    		    }
    		    
    		    $orders_multiple_custom_size = $this->db->query("SELECT *, CONCAT(custom_width,'x',custom_height) AS name FROM `orders_multiple_custom_size` WHERE `order_id` = '".$order_detail['id']."'")->result_array();
                
                if(isset($orders_multiple_size[0]['id'])){
                   $data['orders_multiple_size'] = $orders_multiple_size;
                }
                if(isset($orders_multiple_custom_size[0]['id'])){
                   $data['orders_multiple_custom_size'] = $orders_multiple_custom_size; 
                }
                
	            //multiple size insertion
				    $count_size_id = 0; $count_custom = 0;
			    if(isset($_POST['size_id']) || isset($_POST['custom_width'])){	    
        		    if(isset($_POST['size_id'])) $count_size_id = count($_POST['size_id']); //echo $count_size_id.'<br/>';
        		    if(isset($_POST['custom_width'])) $count_custom = count($_POST['custom_width']) - 1; //echo $count_custom.'<br/>';
        		    
        		    $total_size_count = $count_size_id + $count_custom; //echo $total_size_count;
        		    
        		    //clear column pixel_size
                    $this->db->query("UPDATE `orders` SET `pixel_size` = '' WHERE `orders`.`id` = $order_id;");
        		        if(isset($_POST['size_id']) && !empty($_POST['size_id']) && $_POST['size_id'] != ''){
            		        //echo'Size Id- '.count($_POST['size_id']).'<br/>';
            		        foreach ($_POST['size_id'] as $size){ 
            		            //echo $selectedOption."<br/>"; 
            		            $post_size = array('order_id' => $order_id, 'size_id' => $size);
            		            $this->db->insert('orders_multiple_size', $post_size);
            		        }
            		        
            		    }
            		    //custom size
            		    if(isset($_POST['custom_width']) && isset($_POST['custom_height'])){
            		        //echo'<br/>Custom  Size - '.count($_POST['custom_width']).'<br/>';
            		        for ($i=1; $i < count($_POST['custom_width']); $i++){ 
            		            //echo $_POST['custom_width'][$i].'x'.$_POST['custom_height'][$i]."<br/>";
            		            $post_size = array('order_id' => $order_id, 'custom_width' => $_POST['custom_width'][$i], 'custom_height' => $_POST['custom_height'][$i]);
            		            $this->db->insert('orders_multiple_custom_size', $post_size);
            		        }
            		    }
            		redirect('new_csr/home/orderview/'.$order_detail['help_desk'].'/'.$order_id);    
    			}
	        }else{
	            $this->session->set_flashdata("message","print order - Multiple Size not allowed..");
    		    redirect('new_csr/home/orderview/'.$order_detail['help_desk'].'/'.$order_id);     
	        }
	        $this->load->view('new_csr/add_extra_sizes', $data);
	    }else{
	        $this->session->set_flashdata("message","Order not Found - ".$order_id);
    		redirect('new_csr/home'); 
	    }
	}
	
	public function JWTtoken()
	{
		 // Include the Composer autoloader
		require 'vendor/autoload.php';
	 //use Firebase\JWT\JWT;
		$logger = new \Firebase\JWT\JWT();
		
		// Set the key and other required claims
		$key = 'f26e587c28064d0e855e72c0a6a0e618';
		$payload = array(
			"iss" => "issuer",
			"aud" => "audience",
			"iat" => time(), // Issued at claim
			"exp" => time() + (60 * 60), // Expiration time claim (1 hour from now)
			"userName" => "JohnDoe", // Your userName value
			"adRepId" => 12345 // Your adRepId value
		);

		// Generate the JWT token
		$jwt = $logger::encode($payload, $key, 'HS256');

		echo $jwt;
		/*$decoded = $logger::decode($jwt, new Key($key, 'HS256'));
		echo '<br/>'.$decoded;*/
	}
	
	public function GmailDraft()
	{
	    $sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array(); 
		if($csr['category_level'] != null && $csr['club_id'] != null){
            $club_id = "(".$csr['club_id'].")";
			
			$cat_id = explode(',', $csr['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			
			$q = "SELECT order_mail_draft.*, club.name FROM `order_mail_draft` 
			JOIN `club` ON order_mail_draft.CLUB_ID = club.id
			WHERE order_mail_draft.STATUS = '1' AND order_mail_draft.CLUB_ID IN $club_id"; //echo $q;
			$data['order_mail_draft'] = $this->db->query("$q")->result_array();
			$this->load->view('new_csr/GmailDraft', $data);
		}
	}
	
	public function updateOrderRush($order_id)
	{
        $order_detail = $this->db->query("SELECT `id` FROM `orders` WHERE `id` = '$order_id' ")->row_array();  
    	if(isset($order_detail['id'])){
    	    $update_data = array('rush' => '1');
    	    $this->db->where('id', $order_id);
			$this->db->update('orders', $update_data); 
    	}
	}
	
	public function Ogden_create_xml_proofReady($type='', $order_id = '') //For ftp xml ads Ogden publication
	{
        $this->load->dbutil();
        $order_detail = $this->db->query("SELECT orders.id, orders.order_type_id, orders.job_no, cat_result.slug, cat_result.source_path FROM `orders` 
                                            JOIN `cat_result` ON cat_result.order_no = orders.id
                                            WHERE orders.id = '$order_id'")->row_array();
        if(isset($order_detail['id'])){
            if($type == 'revision'){
                $outgoing_path = 'Ogden_ftp_xml/revision_out';
                $rev_sold_jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' AND `status` = '5' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
                $new_slug = $rev_sold_jobs['new_slug'];
                $q = 'SELECT rev_sold_jobs.order_id AS orderId, note_sent.note AS notes, CONCAT("https://adwitads.com/weborders/",rev_sold_jobs.pdf_path) AS pdf, 
                    CONCAT("https://adwitads.com/weborders/", cat_result.source_path, "/", rev_sold_jobs.new_slug,".zip") AS package FROM `rev_sold_jobs` 
                                        LEFT JOIN `note_sent` ON note_sent.revision_id = rev_sold_jobs.id
                                        LEFT JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                                        WHERE rev_sold_jobs.id = "'.$rev_sold_jobs['id'].'"';   
            }else{
                $outgoing_path = 'Ogden_ftp_xml/Outgoing';
                $new_slug = $order_detail['slug']; 
                $q = 'SELECT orders.id AS orderId, note_sent.note AS notes, CONCAT("https://adwitads.com/weborders/",orders.pdf) AS pdf, 
                    CONCAT("https://adwitads.com/weborders/", cat_result.source_path, "/", cat_result.slug,".zip") AS package FROM `orders` 
                                        LEFT JOIN `note_sent` ON note_sent.order_id = orders.id
                                        LEFT JOIN `cat_result` ON cat_result.order_no = orders.id
                                        WHERE orders.id = "'.$order_id.'"';
            }
            
			$SourceFilePath = $order_detail['source_path'];
            $zip_file = $SourceFilePath.'/'.$new_slug.'.zip';
            
            if($order_detail['order_type_id'] == 1 && file_exists($zip_file)){ //web multiple size ad
                $source_zip =  $zip_file;   
            }else{
                //zip source start
                $this->load->library('zip');
    			$this->load->helper('directory');
    			
    			$font_path = $SourceFilePath.'/Document fonts/';
    			$links_path = $SourceFilePath.'/Links/';
    			
    			$this->load->helper('directory');	
    			
    			$map = glob($SourceFilePath.'/'.$new_slug.'.{indd,psd}',GLOB_BRACE);
    			if($map){ foreach($map as $row_src){
    				$src_path = $row_src;
    			} } 
    			
    			$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
    			if($map){ foreach($map as $row_pdf){
    				$pdf_path = $row_pdf;
    			} } 
    			
    			$this->zip->read_file($src_path, FALSE);
    			$this->zip->read_file($pdf_path, FALSE);
    			
    			$map_font = directory_map($font_path.'/');
    			$map_link = directory_map($links_path.'/');
    			if($map_font){
    				$this->zip->read_dir($font_path, FALSE);
    			}	
    			if($map_link){
    				$this->zip->read_dir($links_path, FALSE);
    			}
    			
    			$this->zip->archive($zip_file);
    			$this->zip->clear_data();
    			//zip source END
            }
            
            $data = $this->db->query($q);
            $config = array (
                    'root'    => 'Ads',
                    'element' => 'Ad',
                    'newline' => "\n",
                    'tab'     => "\t"
             );
             $xml = $this->dbutil->xml_from_result($data, $config);
             $this->load->helper('file');
             $xmlFileName = $order_detail['job_no'].'.xml';
             write_file($outgoing_path.'/'.$xmlFileName, '<?xml version="1.0" ?>'.PHP_EOL);
             write_file($outgoing_path.'/'.$xmlFileName, $xml, 'a');
              //$this->output->set_content_type('text/xml');
              //$this->output->set_output($xml); 
            if($type == 'revision'){
                $this->Ogden_ftp_connect_post('revision', $xmlFileName);
            }
	    }
	}
	
	public function Ogden_ftp_connect_post($action = '', $fileName = '') //To UPLOAD XML file to FTP 
	{
	    if($action == 'question'){
	      $ftp_folder = "adwit_question" ;
	      $local_path = "Ogden_ftp_xml/question";
	      $entry = $fileName;
	    }elseif($action == 'revision'){
	      $ftp_folder = "revision_out" ;
	      $local_path = "Ogden_ftp_xml/revision_out";
	      $entry = $fileName;  
	    }
	    define('FTP_URL', 'ftp.oweb.net');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'Aw-1013');
        define('FTP_DIRECTORY', './'.$ftp_folder);
        
        //Connect to FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        /*if ($handle = opendir($local_path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {*/
                    if(ftp_put($ftp, FTP_DIRECTORY.'/'.$entry, $local_path.'/'.$entry, FTP_BINARY)) {
                        //echo "SUCCESS";
                        //unlink($local_path.'/'.$entry); //Delete local entry
                    }else{
                        echo "There was a problem while uploading FTP - $file\n"; exit; //return false;//
                    }
               /* }
            }
        
            closedir($handle);
        } */  
        
        ftp_close($ftp);
	}
	
	public function unset_ordernot_found(){
	    unset($_SESSION['order_not_found']);
	}
	
	public function unset_sess(){
		unset($_SESSION['search_val']);
		unset($_SESSION['no_of_order']);
		unset($_SESSION['c_order_by']);
		unset($_SESSION['c_sort_by']);
	}
	public function reset_newpendingads(){
		unset($_SESSION['newad_val']);
		unset($_SESSION['no_of_newpending_order']);
		unset($_SESSION['n_order_by']);
		unset($_SESSION['n_sort_by']);
	}
	public function unsetmetro_ads(){
	    unset($_SESSION['metroad_val']);
	    unset($_SESSION['no_of_metro_ad']);
	}
	public function unset_webad_sess(){
        unset($_SESSION['web_search_val']);
        unset($_SESSION['no_of_cat_webad_order']);
        unset($_SESSION['c_web_order_by']);
		unset($_SESSION['c_web_sort_by']);
	}
	public function unset_webqa_sess(){
        unset($_SESSION['web_qa_search_val']);
        unset($_SESSION['no_of_web_qa_order']);
        unset($_SESSION['c_qa_order_by']);
		unset($_SESSION['c_qa_sort_by']);
	}
	public function unset_web_newpending_sess(){
        unset($_SESSION['web_newpending_search_val']);
        unset($_SESSION['no_of_web_newpending_order']);
        unset($_SESSION['c_new_order_by']);
		unset($_SESSION['c_new_sort_by']);
	}
	public function reset_rev_search(){
	    unset($_SESSION['rev_no_of_order']);
	    unset($_SESSION['rev_search_val']);
	}
	public function reset_rush_search(){
	    unset($_SESSION['rush_no_of_order']);
	    unset($_SESSION['rush_search_val']);
	}
	
	
	#excel export starts here for new pending ads
    public function getNewpendingAdsExcel() {
    $sId = $this->session->userdata('sId');
    $csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array();

    if ($csr['category_level'] != null && $csr['club_id'] != null) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach (range('A', 'F') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $sheet->setCellValue('A1', "Type");
        $sheet->setCellValue('B1', "AdwitAds ID");
        $sheet->setCellValue('C1', "Unique Job Name");
        $sheet->setCellValue('D1', "Adrep");
        $sheet->setCellValue('E1', "Publication");
        $sheet->setCellValue('F1', "Priority");

        $club_id = "(" . $csr['club_id'] . ")";
        $cat_id = explode(',', $csr['category_level']);
        $cat_series = "'" . implode("', '", $cat_id) . "'";

        $sql = "SELECT live_orders.id, live_orders.pub_id,live_orders.order_id, live_orders.job_no, live_orders.category, 
            live_orders.designer_id, live_orders.csr_id,live_orders.status, live_orders.pro_status,live_orders.club_id, orders.order_type_id, orders.advertiser_name, orders_type.value, order_status.d_name, 
            orders.rush, orders.adrep_id,orders.question, orders.help_desk, orders.created_on,orders.status, publications.name, adreps.first_name, orders.page_design_id, time_zone.priority AS time_zone_priority
            FROM `live_orders`
            RIGHT JOIN `orders` ON orders.id = live_orders.order_id
            JOIN `publications` ON publications.id = orders.publication_id
            JOIN `adreps` ON adreps.id = orders.adrep_id
            JOIN `orders_type` ON orders_type.id  = orders.order_type_id
            JOIN `order_status` ON order_status.id  = orders.status
            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
            WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status BETWEEN '1' AND '4' 
            AND live_orders.crequest != '1'";

        $newPendingAds = $this->db->query($sql)->result_array();
        $x = 2;
        if ($newPendingAds) {
            foreach ($newPendingAds as $row) {
                if ($row['value'] == "print") {
                    $type = 'P';
                } elseif ($row['value'] == "web") {
                    $type = 'W';
                } elseif ($row['value'] == "pagination") {
                    $type = 'PG';
                } else {
                    $type = "P&W";
                }

                if ($row['order_type_id'] == '6') {
                    $job_no = $row['advertiser_name'] . '/' . $row['job_no'];
                } else {
                    $job_no =  $row['job_no'];
                }

                $sheet->setCellValue('A' . $x, $type);
                $sheet->setCellValue('B' . $x, $row['order_id']);
                $sheet->setCellValue('C' . $x, $job_no);
                $sheet->setCellValue('D' . $x, $row['first_name']);
                $sheet->setCellValue('E' . $x, $row['name']);
                $sheet->setCellValue('F' . $x, $row['time_zone_priority']);
                $x++;
            }

            // Instantiate Xlsx
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            // Define the filename and set the headers
            $filename = "New-pending-ads.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename );
            header('Cache-Control: max-age=0');
        
            // Save and output the Excel file
            $writer->save('php://output');
           
            }
        }
    }
	
    #excel export for metro sent ads
    public function getMetroSendAdsExcel() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach (range('A', 'D') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $sheet->setCellValue('A1', "AdwitAds ID");
        $sheet->setCellValue('B1', "Unique Job Name");
        $sheet->setCellValue('C1', "Adrep");
        $sheet->setCellValue('D1', "Publication");
       
        $form = 2;
        $today = date("Y-m-d", strtotime('+1 day')).' 23:59:59';
    	$tracker_date = $this->db->query("SELECT * FROM `print_ad_tracker_date` WHERE `hd` = '".$form."'")->row_array();
    	$num_days = $tracker_date['num_days'];
		if($num_days != '0'){
			$ystday = date('Y-m-d 00:00:00', strtotime("-$num_days day")); //in days
		}else{
			$ystday =  ($tracker_date['date'].' 00:00:00');  //in date
		}
        $sql = "SELECT A.order_id, A.sent, P.order_type_id, P.publication_id, P.adrep_id, P.status, P.created_on, P.id, P.rush, P.job_no, P.question,publications.name,adreps.first_name FROM `metro_sent_ads` AS A
					left outer join `orders` AS P on P.id = A.order_id
					LEFT join publications on publications.id = P.publication_id
					LEFT join adreps on adreps.id = P.adrep_id
					WHERE P.status='5' AND P.help_desk='".$form."' AND A.sent='0'  AND (`timestamp` BETWEEN '$ystday' AND '$today')";

        $sendmetroads = $this->db->query($sql)->result_array();
        $x = 2;
        if ($sendmetroads) {
            foreach ($sendmetroads as $row) {
                $sheet->setCellValue('A' . $x, $row['order_id']);
                $sheet->setCellValue('B' . $x, $row['job_no']);
                $sheet->setCellValue('C' . $x, $row['first_name']);
                $sheet->setCellValue('D' . $x, $row['name']);
                $x++;
            }

            // Instantiate Xlsx
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            // Define the filename and set the headers
            $filename = "Metro-sent-ads.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename );
            header('Cache-Control: max-age=0');
        
            // Save and output the Excel file
            $writer->save('php://output');
           
        }/*else{
            $this->session->set_flashdata("ExcelData","Data Not Found");
            
        }*/
    
    }
    
    # revision ads excel starts here 
    public function getRevisionAdsExcel() {
        // print_r($_POST);exit();
        $selected_date = $this->input->post("selected_date");
        $display_type = $this->input->post("display_type");
        $help_desk_id = $this->input->post("selected_help_desk");
        
         $help_desk_detail = $this->db->query("SELECT id,adwit_teams_id FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
         $adwit_teams_id = $help_desk_detail['adwit_teams_id'];
         $adwit_team = $this->db->query("SELECT category FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
         $cat_id = explode(',', $adwit_team['category']);
	     $category_level = "'" . implode ( "', '", $cat_id ) . "'";
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        if($selected_date == "rush"){
           foreach (range('A', 'F') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $sheet->setCellValue('A1', "Date");
        $sheet->setCellValue('B1', "Type");
        $sheet->setCellValue('C1', "AdwitAds ID");
        $sheet->setCellValue('D1', "Unique Job Name");
        $sheet->setCellValue('E1', "Adrep");
        $sheet->setCellValue('F1', "Publication");
       
         $sql ="SELECT orders.id, orders.created_on, orders.order_type_id, orders.status, orders.advertiser_name, orders.job_no, orders.question, orders.help_desk,
	            publications.name AS Pname, CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname FROM orders 
	                    JOIN `publications` ON publications.id = orders.publication_id
	                    JOIN `adreps` ON adreps.id = orders.adrep_id
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.crequest != '1'  AND orders.help_desk != '0'
	                    AND orders.club_id IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ) AND DATE(orders.created_on) > '2023-01-01'";
     

        $revision_ads = $this->db->query($sql)->result_array();
        $x = 2;
        if ($revision_ads) {
            foreach ($revision_ads as $row) {
                
                $order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->row_array();
            	$order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->row_array();
            	if($order_type['value']=='print') {$type =  "P";} elseif($order_type['value']=='web'){ $type =  "W";}elseif($order_type['value']=='pagination'){ $type =  "PG";}else{ $type =  "P&W";}   
            	 if($row['order_type_id'] == '6'){
                    $job_name =  $row['advertiser_name'].'/'.$row['job_no'];
                 }else{
                    $job_name =  $row['job_no'];
                 }

            	 
                $sheet->setCellValue('A' . $x, date('d-M', strtotime($row['created_on'])));
                $sheet->setCellValue('B' . $x, $type);
                $sheet->setCellValue('C' . $x, $row['id']);
                $sheet->setCellValue('D' . $x, $job_name);
                $sheet->setCellValue('E' . $x, $row['Aname']);
                $sheet->setCellValue('F' . $x, $row['Pname']);
                $x++;
            }
        }
        
         $filename = "Rush-Ads.xlsx";
        }else{
            
            $count = '0'; $cat_time = '0'; $timer = '0'; $i=0; $designer_name="";

            foreach (range('A', 'H') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
            }
    
            $sheet->setCellValue('A1', "Type");
            $sheet->setCellValue('B1', "Job No");
            $sheet->setCellValue('C1', "Revision");
            $sheet->setCellValue('D1', "Designer");
            $sheet->setCellValue('E1', "Time Left");
            $sheet->setCellValue('F1', "Time Sent");
            $sheet->setCellValue('G1', "Time Taken");
            $sheet->setCellValue('H1', "Classification");
           
             if($help_desk_id == "20"){
                 $sql = "SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
        	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
        	                left join `designers` ON designers.id = rev_sold_jobs.designer
                            WHERE cat_result.category = 'G'
                            AND rev_sold_jobs.date = '$selected_date' ";
             }else{
                $sql ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
    	                 left join `designers` ON designers.id = rev_sold_jobs.designer
                        WHERE cat_result.publication_id IN (SELECT `id`  FROM `publications` WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ))
                        AND cat_result.category IN ($category_level)
                        AND rev_sold_jobs.date = '$selected_date'";  
             }
        
             if($display_type == 'pending'){
                       $sql .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
                    }elseif($display_type == 'sent'){
                       $sql .= " AND rev_sold_jobs.status IN ('5','9') "; 
                    }elseif($display_type == 'QA'){
                       $sql .= " AND rev_sold_jobs.status IN ('4','7') "; 
                    } 
            $sql .= " ORDER BY rev_sold_jobs.id ASC ";
            
            // print_r($sql);exit();
            $revisionAds = $this->db->query($sql)->result_array();
            $x = 2;
            $current_time = date("H:i:s");

            if ($revisionAds) {
                foreach ($revisionAds as $row) {
                    
                    $time_left = '0';
                    $time_taken='';
            		//$count = sprintf('%03d',$count);
            		$start = strtotime($row['time']);
            		$end = strtotime($current_time);
            		$time_left = $end - $start ; 
            		$time_left = $time_left / 60;
            		$time_left_rnd = round($time_left,0);
            		$frontline_timer = $this->db->get('frontline_timer')->result_array();
            		if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
            		foreach($frontline_timer as $row1){
            			if($row['category'] == $row1['cat_name']){ $cat_time = $row1['duration']; }
            		}
            		
                    if($row['order_type_id']=='2'){$type = "P";} elseif($row['order_type_id']=='1'){ $type = "W";} elseif($row['order_type_id']=='6'){ $type = "PG";} else{ $type =  "P&W";}
                    if($row['category']=='revision'){ $revision =  $row['time'];}
                    if($row['designer']!='0'){ $designer_name =  $designer[0]['username']; }
                    if($row['status']=='5' || $row['status']=='8'){
						$is_time_left = '';
					}elseif($time_left < $cat_time && $row['sent_time']=='00:00:00'){ 
						$timer = $cat_time - $time_left ;  
						if($timer<= '5'){
							$is_time_left = round($timer,0)." min";
						}else{ $is_time_left=  round($timer,0)." mins"; }
					}else{ $is_time_left = "Elapsed"; }
					
					if($row['time_taken']!='0')
    				  { 
    					//calculating hours, minutes and seconds (as floating point values)
    					$hours = $row['time_taken'] / 3600; //one hour has 3600 seconds
    					$minutes = ($hours - floor($hours)) * 60;
    					$seconds = ($minutes - floor($minutes)) * 60;
    
    					//formatting hours, minutes and seconds
    					$final_hours = floor($hours);
    					$final_minutes = floor($minutes);
    					$final_seconds = floor($seconds);
    
    					//output
    					$time_taken =  $final_hours . ":" . $final_minutes . ":" . $final_seconds; 
    				  } 
					if($row['classification']!='0'){ $classification = $rev_classification['name']; }							  
                    
                    $sheet->setCellValue('A' . $x, $type);
                    $sheet->setCellValue('B' . $x, $row['order_no']);
                    $sheet->setCellValue('C' . $x, $revision);
                    $sheet->setCellValue('D' . $x, $designer_name);
                    $sheet->setCellValue('E' . $x, $is_time_left);
                    $sheet->setCellValue('F' . $x, "");
                    $sheet->setCellValue('G' . $x, $time_taken);
                    $sheet->setCellValue('H' . $x, $classification);
                    $x++;
                }
            }
             $filename = "Revision-ads-".$selected_date.".xlsx";
            
            }
        
        
            // Instantiate Xlsx
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            // Define the filename and set the headers
           
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename );
            header('Cache-Control: max-age=0');
        
            // Save and output the Excel file
            $writer->save('php://output');
           
        
    
    }
    # revision ads excel ends here 
    public function get_pagination_config(&$config){
		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class="page-item">';        
        $config['first_tag_close'] = '</li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="page-item">';        
        $config['prev_tag_close'] = '</li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class="page-item">';        
        $config['next_tag_close'] = '</li>';        
        $config['last_tag_open'] = '<li class="page-item">';        
        $config['last_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class="page-item">';        
        $config['num_tag_close'] = '</li>';


    }
    
    public function get_subcategory()
    {
        if(isset($_GET['adtypeId'])){
            $adtypeId = $_GET['adtypeId']; $output = '';
            $sub_category = $this->db->query("SELECT *  FROM `sub_category` WHERE `cat_new_adtype_id` = '$adtypeId'")->result_array();
            if(isset($sub_category[0]['id'])){
                $output .= '<div><label>Sub Category</label></div>';
                $output .= '<div id="ad_subcat_error_div"></div>';
    			$output .= '<div class="btn-group" data-toggle="buttons">';
    												
                foreach($sub_category as $row){
                    $output .= '<label class="btn grey margin-right-10 margin-bottom-5">';
    				$output .= '<input type="radio" name="sub_category" id="sub_category" value="'.$row['id'].'" required="required">' ;
    				$output .=  $row['name'];
    				$output .= '</label>';    
                }
                $output .= '</div>';
            }
            echo $output;
        }
    }
     public function live_new_ads_pagination()
    {    
        $sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array(); 
        
        if($csr['category_level'] != null && $csr['club_id'] != null){
            $club_id = "(".$csr['club_id'].")";
			
			$cat_id = explode(',', $csr['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
            if(isset($cat_series)){
    		
    			$data['sId'] = $sId;
    			$data['csr'] = $csr; 
    					
    			$this->load->view('new_csr/live_new_ads_pagination',$data);
            }else{
                $this->session->set_flashdata("message","Category Level Not Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		        redirect('new_csr/home');    
            }
		}else{
		    $this->session->set_flashdata("message","No Publication Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		    redirect('new_csr/home');
		}
    }
    
    public function live_new_ads_pagination_details($display_type=''){
        $sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array(); 
        $club_id = "(".$csr['club_id'].")";
		$cat_id = explode(',', $csr['category_level']);
		$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
		$data =array();
		//category
		if($display_type == "category"){
		     $query = "SELECT orders.created_on,live_orders.order_id,live_orders.job_no,adreps.first_name, orders.advertiser_name,publications.name,live_orders.id,time_zone.priority AS time_zone_priority,live_orders.pub_id,  live_orders.category, live_orders.designer_id, live_orders.csr_id, 
		     live_orders.status, live_orders.pro_status, live_orders.club_id, orders.adrep_id, orders.order_type_id, orders.rush,orders.question, 
		     orders.help_desk, orders.page_design_id	
    			        FROM `live_orders`
    					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    					JOIN `publications` ON publications.id = orders.publication_id
    					join `adreps` on adreps.id = orders.adrep_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.status = '1' AND live_orders.crequest != '1' AND orders.cancel != '1' ";
		
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.advertiser_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
       
        $category_orders = $this->db->query($query)->result_array();
        foreach($category_orders as $row1){
            $publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['pub_id']."' ;")->result_array();		
			$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();		
			$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();
			$adrep_name = '';
			if(isset($adreps[0]['id'])){
			   $adrep_name = $adreps[0]['first_name'];
			   $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array(); 
			}
		    
		   	$row0 = '';
		   	if(isset($color_code['id'])){
		   	   $row0 = $color_code['code']; 
		   	}
		   	if($row1['rush']=='1'){
		   	    $row0 = 1;
		   	}
		    	
		    $created_on = strtotime($row1['created_on']); $date=date('d-M', $created_on);
		    //order no
		    $adwit_id = $row1['order_id']; if(isset($row1['page_design_id'])){$adwit_id = $row1['order_id']." / ".$row1['page_design_id'];}
		    // job no
		     if($row1['order_type_id'] == '6'){
               $job_no = $row1['advertiser_name'].'/'.$row1['job_no'];
            }else{
                $job_no = $row1['job_no'];
            }
            //publication
            $publication_name ="";
            if(isset($publication)){
               $publication_name =$publication[0]['name'];
            }
            //category
            $category = '';
            if ($row1['question'] == '1') {
                $category .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="15%">';
            } elseif ($row1['question'] == '2') {
                $category .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="15%">';
            }
            $categoryContent = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$row1['help_desk']. '/' . $row1['order_id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">' . ($order_status ? $order_status[0]['d_name'] : '') . '</button>
                            </a>';
            $category .= $categoryContent;

			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = $date;
	        $sub_array[] = $adwit_id;
	        $sub_array[] = $job_no;
	        $sub_array[] = $adrep_name;
	        $sub_array[] = $row1['advertiser_name'];
	        $sub_array[] = $publication_name;
	        $sub_array[] = $category;
	        $sub_array[] = $row1['time_zone_priority'];
		    
		    $data[] = $sub_array;
        }
		}
		else if($display_type == "QA"){
		     $query = "SELECT orders.created_on,orders_type.value,live_orders.order_id,live_orders.job_no,adreps.first_name,publications.name,time_zone.priority AS time_zone_priority,live_orders.id, live_orders.pub_id, live_orders.category, live_orders.designer_id, 
		                live_orders.csr_id, live_orders.status, orders.order_type_id,orders.adrep_id,live_orders.pro_status, live_orders.club_id 
                        FROM `live_orders` 
                        JOIN `orders` ON orders.id = live_orders.order_id
                        JOIN `orders_type` ON orders_type.id = orders.order_type_id
                        join `adreps` on adreps.id = orders.adrep_id
						JOIN `publications` ON publications.id = live_orders.pub_id
						JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
						WHERE live_orders.club_id IN $club_id AND live_orders.csr_QA = '$sId' AND (live_orders.status IN('1','2','3','4','8'))
						AND live_orders.pro_status != '5' AND live_orders.crequest != '1' ";
		
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR orders_type.value LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        $myQ_orders = $this->db->query($query)->result_array();
        foreach($myQ_orders as $row){
           $order =  $this->db->query("SELECT id, advertiser_name, job_no, order_type_id, rush, adrep_id, question, help_desk, page_design_id FROM `orders` WHERE `id`='".$row['order_id']."' ;")->row_array();		
    	if(isset($order['id'])){
    		$order_type = $this->db->get_where('orders_type',array('id' => $order['order_type_id']))->result_array();
    		$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['pub_id']."' ;")->result_array();		
    		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$order['adrep_id']."' ;")->result_array();
    		$order_status = $this->db->get_where('production_status',array('id'=>$row['pro_status']))->result_array();
    		$adrep_name = '';
    			if(isset($adreps[0]['id'])){
    			   $adrep_name = $adreps[0]['first_name'];
    			   $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array();
    			}
		    $created_on = strtotime($row['created_on']); $date=date('d-M', $created_on);
		    
		    $row0 = '';
		   	if(isset($color_code['id'])){
		   	   $row0 = $color_code['code']; 
		   	}
		   	if($order['rush']=='1'){
		   	    $row0 = 1;
		   	}
		   	
		    //type
		    $type = "";
            if($order_type[0]['value']=='print'){$type ="P";}else if($order_type[0]['value']=='web'){$type ="W";}else if($order_type[0]['value']=='pagination'){$type ="PG";}else{$type ="P&W";}
                
		    //order no
		    $adwit_id = $order['id']; if(isset($order['page_design_id'])){$adwit_id = $order['id']." / ".$order['page_design_id'];}
		    // job no
		     if($order['order_type_id'] == '6'){
               $job_no = $order['advertiser_name'].'/'.$order['job_no'];
            }else{
                $job_no = $order['job_no'];
            }
            //publication
            $publication ="";
            if(isset($publication_name)){
               $publication =$publication_name[0]['name'];
            }
            //QA
            $category = '';
            if ($order['question'] == '1') {
                $category .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="10%">';
            } elseif ($order['question'] == '2') {
                $category .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="10%">';
            }
            if($order_status){
                if($row['pro_status'] == '3') {
                    $categoryContent = '<a  title="OrderView" href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$order['help_desk']. '/' . $order['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                            <button class="btn blue btn-xs">' . $order_status[0]['d_name'] . '</button>
                                        </a>';
                }else{
                     $categoryContent = '<button title="OrderView" class="btn grey btn-xs">' . $order_status[0]['d_name'] . '</button>';
                }
            }
            $category .= $categoryContent;

			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = $date;
	        $sub_array[] = '<span title="'.$order_type[0]['name'].'" class="badge bg-blue">' . $type . '</span>';
	        $sub_array[] = $adwit_id;
	        $sub_array[] = $job_no;
	        $sub_array[] = $adrep_name;
	        $sub_array[] = $publication;
	        $sub_array[] = $category;
	        $sub_array[] = $row['time_zone_priority'];
		    
		    $data[] = $sub_array;
        }
		}
		    
		}elseif($display_type == "new_pending"){
		     $query = "SELECT orders.created_on, orders_type.value,live_orders.order_id, live_orders.job_no,adreps.first_name,publications.name, time_zone.priority AS time_zone_priority,live_orders.id, live_orders.pub_id, live_orders.category, 
    			live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.order_type_id, orders.advertiser_name, 
    			orders.rush, orders.adrep_id, orders.question, orders.help_desk, orders.status,orders.page_design_id
    			        FROM `live_orders`
    					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    					JOIN `orders_type` ON orders_type.id = orders.order_type_id
    					JOIN `publications` ON publications.id = live_orders.pub_id
    					JOIN `adreps` ON adreps.id = orders.adrep_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status BETWEEN '1' AND '4' 
    					AND live_orders.crequest != '1' ";
		
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }else{
            $query .= " ORDER BY orders.rush DESC, time_zone.priority";
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        // print_R($query);exit();
        
        $all_orders = $this->db->query($query)->result_array();
        foreach($all_orders as $row1){
           $order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
    		$publication = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row1['pub_id']."' ;")->result_array();		
    		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
    		$order_status = $this->db->get_where('order_status',array('id'=>$row1['status']))->result_array();
            $adrep_name = '';
    		if(isset($adreps[0]['id'])){
    		    $adrep_name = $adreps[0]['first_name'];
    		    $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array();
    		}
    		$row0 = '';
		   	if(isset($color_code['id'])){
		   	   $row0 = $color_code['code']; 
		   	}
		   	if($row1['rush']=='1'){
		   	    $row0 = 1;
		   	}
    		
		    $created_on = strtotime($row1['created_on']); $date=date('d-M', $created_on);
		    //type
		     if($order_type[0]['value']=='print'){$type ="P";}else if($order_type[0]['value']=='web'){$type ="W";}else if($order_type[0]['value']=='pagination'){$type ="PG";}else{$type ="P&W";}
            
		    //order no
		    $order_id = $row1['order_id'];if(isset($row1['page_design_id'])){$order_id = $row1['order_id']. ' / '.$row1['page_design_id'];}
		    $order_no = '<a ';
		    if($row1['rush']==1){
		        $order_no .= 'class="font-grey-cararra"';
		    }
		    $order_no .= ' title="view attachments" href="javascript:;" onclick="window.location=\''  . base_url() . index_page() . 'new_csr/home/orderview/' . $row1['help_desk'] . '/' . $row1['order_id']. '\'" style="cursor:pointer; text-decoration: none;">'
            
            . $order_id . '</a>';

            
		    $adwit_id = $row1['order_id']; if(isset($row1['page_design_id'])){$adwit_id = $row1['order_id']." / ".$row1['page_design_id'];}
		    // job no
		     if($row1['order_type_id'] == '6'){
               $job_no = $row1['advertiser_name'].'/'.$row1['job_no'];
            }else{
                $job_no = $row1['job_no'];
            }
            //publication
            $publication_name ="";
            if(isset($publication)){
               $publication_name =$publication[0]['name'];
            }
            //status
            $category = '';
            if ($row1['question'] == '1') {
                // $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                $category .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="10%">';
            } elseif ($row1['question'] == '2') {
                // $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                $category .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="10%">';
            }
            
            if($row1['status']=='1' || $row1['status']=='2' || $row1['status']=='3'){
                $categoryContent = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$row1['help_desk']. '/' . $row1['order_id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">' . ($order_status ? $order_status[0]['d_name'] : '') . '</button>
                            </a>';
            }
            else if($row1['status']=='4' ){
                $categoryContent = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$row1['help_desk']. '/' . $row1['order_id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">' . ($order_status ? $order_status[0]['d_name'] : '') . '</button>
                            </a>'; 
                $cat_result = $this->db->query("SELECT csr.name FROM `cat_result`
																JOIN `csr` ON cat_result.csr_QA = csr.id
																WHERE cat_result.order_no = '".$row1['order_id']."' AND cat_result.pro_status = '3'")->row_array();
							 if(isset($cat_result['name'])){$categoryContent .=	$cat_result['name'];  } 
            }

           /* $category = '<span ' . $classAttribute . '>';
            $category .= $categoryContent;
            $category .= '</span>'*/;
            $category .= $categoryContent;
                
            
			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = $date;
	        $sub_array[] = '<span title="'.$order_type[0]['name'].'" class="badge bg-blue">' . $type . '</span>';
	        $sub_array[] = $order_no;
	        $sub_array[] = $job_no;
	        $sub_array[] = $adrep_name;
	        $sub_array[] = $publication_name;
	        $sub_array[] = $category;
	        $sub_array[] = $row1['time_zone_priority'];
		    
		    $data[] = $sub_array;
        }
		} 
		elseif($display_type == "total_QA"){
		     $query = "SELECT orders_type.value,live_orders.order_id, live_orders.job_no,adreps.first_name,publications.name,live_orders.id, live_orders.pub_id,time_zone.priority AS time_zone_priority,orders.order_type_id,
		     live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status,
		     live_orders.club_id, live_orders.csr_QA,orders.rush
    			        FROM `live_orders`
    			        RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    					JOIN `orders_type` ON orders_type.id = orders.order_type_id
    					JOIN `adreps` ON adreps.id = orders.adrep_id
    					JOIN `publications` ON publications.id = live_orders.pub_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status != '5' 
    					AND live_orders.pro_status = '3' AND live_orders.csr_QA IS NULL AND live_orders.crequest != '1' ";
		
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders_type.value LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }else{
            $query .= " ORDER BY orders.rush DESC, time_zone.priority" ;
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        $generalQ_orders = $this->db->query($query)->result_array();
        foreach($generalQ_orders as $row){
           $order =  $this->db->query("SELECT id, order_type_id, rush, adrep_id, question, help_desk, created_on, job_no, status, page_design_id FROM `orders` WHERE `id`='".$row['order_id']."' ;")->row_array();
    	    if(isset($order['id'])){
    		$order_type = $this->db->get_where('orders_type',array('id' => $order['order_type_id']))->result_array();
    		$publication_name = $this->db->query("SELECT `name` FROM `publications` WHERE `id`='".$row['pub_id']."' ;")->result_array();		
    		$adreps = $this->db->query("SELECT `id`, `first_name`, `color_code` FROM `adreps` WHERE `id`='".$order['adrep_id']."' ;")->result_array();
    		$order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->result_array();
    		$adrep_name = '';
    		if(isset($adreps[0]['id'])){
    		    $adrep_name = $adreps[0]['first_name'];
    		    $color_code = $this->db->get_where('color_code',array('id' => $adreps[0]['color_code']))->row_array();
    		}
    		
    		$row0 = '';
		   	if(isset($color_code['id'])){
		   	   $row0 = $color_code['code']; 
		   	}
		   	if($order['rush']=='1'){
		   	    $row0 = 1;
		   	}
		   	
		    //type
		     if($order_type[0]['value']=='print'){$type ="P";}else if($order_type[0]['value']=='web'){$type ="W";}else if($order_type[0]['value']=='pagination'){$type ="PG";}else{$type ="P&W";}
            $order_id='<span ';
		    if($order['rush']==1){
		        $order_id .= 'class="font-grey-cararra" ';
		    }
		     $order_id .= ' >'.$order['id'].'';
		     if(isset($order['page_design_id'])){
		       $order_id .= '"/"' . $order['page_design_id']; 
		     }
		      $order_id .= '</span>';

            //publication
            $publication ="";
            if(isset($publication_name)){
               $publication =$publication_name[0]['name'];
            }
            //click to
            $click_to = '';
            if ($order['question'] == '1') {
                $click_to .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="10%">';
            } elseif ($order['question'] == '2') {
                $click_to .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="10%">';
            }
            if($order_status){
                $categoryContent = '<form method="post" id="proof_check_form"> 
                        <button type="button" id="proof_check" name="proof_check" class="btn blue btn-xs" onclick="confirm_proof_check(\'' . $order['help_desk'] . '\', \'' . $order['id'] . '\')">Proof Check</button>
                        <input type="text" name="order_id" value="' . $order['id'] . '" style="display:none;">
                        <div style="display:none" id="proof_check_div"> </div>
                    </form>';
            }
           
            if($row['csr_QA'] == $csr['id']) {
                $categoryContent .='<i class="fa fa-flag"></i>';
            }else{
                $categoryContent .= " ";
            }
            $click_to .= $categoryContent;

			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = '<span class="badge bg-blue">' . $type . '</span>';
	        $sub_array[] = $order_id;
	        $sub_array[] = $row['job_no'];
	        $sub_array[] = $adrep_name;
	        $sub_array[] = $publication;
	        $sub_array[] = $row['category'];
	        $sub_array[] = $click_to;
	        $sub_array[] = $row['time_zone_priority'];
		    
		    $data[] = $sub_array;
        }
		}
		
    }
    $output = array(  
            "draw"              =>     intval($_GET["draw"]),  
            "recordsTotal"      =>     $recordsTotal,  
            "recordsFiltered"   =>     $recordsFiltered,  
            "data"              =>     $data  
       );  
       echo json_encode($output);
}
    
    public function newad_tab_count(){
       $sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->row_array(); 
        $data =array();
        if($csr['category_level'] != null && $csr['club_id'] != null){
            $club_id = "(".$csr['club_id'].")";
			
			$cat_id = explode(',', $csr['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
            if(isset($cat_series)){
    			//Categorise orders -->  order_status = 1
    		    $categorise_orders_query ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.adrep_id, orders.order_type_id, orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name, time_zone.priority AS time_zone_priority, orders.page_design_id	
                        			        FROM `live_orders`
                        					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
                        					JOIN `publications` ON publications.id = orders.publication_id
                        					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                        					WHERE live_orders.club_id IN $club_id AND live_orders.status = '1' AND live_orders.crequest != '1' AND orders.cancel != '1'; ";
    			
    				
    			//myQ order_status = 2  My Q
    			$myQ_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, time_zone.priority AS time_zone_priority
    			                        FROM `live_orders` 
    									JOIN `publications` ON publications.id = live_orders.pub_id
    									JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    									WHERE live_orders.club_id IN $club_id AND live_orders.csr_QA = '$sId' AND (live_orders.status IN('1','2','3','4','8'))
    									AND live_orders.pro_status != '5' AND live_orders.crequest != '1'";
    						
    			//GeneralQ total_QA
    			$generalQ_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.csr_QA, time_zone.priority AS time_zone_priority
    			        FROM `live_orders` 
    					JOIN `publications` ON publications.id = live_orders.pub_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status != '5' 
    					AND live_orders.pro_status = '3' AND live_orders.csr_QA IS NULL AND live_orders.crequest != '1'";
    			
    		//All STARTS
    			$all_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, 
    			live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.order_type_id, orders.advertiser_name, 
    			orders.rush, orders.adrep_id, orders.question, orders.help_desk, orders.created_on, orders.status, time_zone.priority AS time_zone_priority, orders.page_design_id
    			        FROM `live_orders`
    					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    					JOIN `publications` ON publications.id = orders.publication_id
    					JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status BETWEEN '1' AND '4' 
    					AND live_orders.crequest != '1'";
    		
    			//counts
    			if($csr['csr_role'] == '1'){
			  		$data['myQ_count']   		= 	$this->db->query($myQ_orders_query)->num_rows();
			        $data['generalQ_count'] 	= 	$this->db->query($generalQ_orders_query)->num_rows();
    			}else if($csr['csr_role'] == '2' ||$csr['csr_role'] == '3' ){
    			  	$data['category_count'] 	= 	$this->db->query($categorise_orders_query)->num_rows();
        			$data['myQ_count']   		= 	$this->db->query($myQ_orders_query)->num_rows();
        			$data['generalQ_count'] 	= 	$this->db->query($generalQ_orders_query)->num_rows();
        			$data['all_count'] 			= 	$this->db->query($all_orders_query)->num_rows();  
    			}
    			    $data['metro_count']	 	= 	''; 
    			    $data['csr_role']	 	    = $csr['csr_role']; 
            }
            
        }
        echo json_encode($data);
    }
    
	public function web_cshift_pagination()
	{
		$sId = $this->session->userdata('sId');
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59'; //$today = date('Y-m-d 23:59:59'); 
		$data['today'] = $today;
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		$data['csr'] = $csr;
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00'; $data['ystday'] = $ystday; //$ystday = ($order_days[0]['date'].' 00:00:00'); $data['ystday'] = $ystday;
		$this->load->view('new_csr/web_cshift_pagination',$data);
	}
	public function webad_tab_count(){
	    $data = array();
       	$sId = $this->session->userdata('sId');
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59'; //$today = date('Y-m-d 23:59:59'); 
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00'; //$ystday = ($order_days[0]['date'].' 00:00:00'); $data['ystday'] = $ystday;
		//'category' query
		$cat_q = "SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, publications.name, adreps.first_name FROM `orders` 
		                            JOIN `publications` ON orders.publication_id = publications.id
		                            JOIN `adreps` ON orders.adrep_id = adreps.id
	                                WHERE orders.order_type_id = '1' AND orders.status = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
	                                AND (orders.created_on BETWEEN '$ystday' AND '$today') ;";
		//'QA' query
		$QA_q = "SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, cat_result.id AS catId, cat_result.timestamp, cat_result.csr_QA, publications.name, adreps.first_name FROM `orders`
		                                            RIGHT JOIN `cat_result` ON orders.id = cat_result.order_no
		                                            JOIN `publications` ON orders.publication_id = publications.id
		                                            JOIN `adreps` ON orders.adrep_id = adreps.id
		                                            WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
		                                            AND (orders.status BETWEEN '1' AND '4' OR orders.status = '8') AND (orders.created_on BETWEEN '$ystday' AND '$today')
		                                            AND cat_result.pro_status = '3' AND (cat_result.csr_QA = '".$csr[0]['id']."' OR cat_result.csr_QA = '0');";
		//'new_pending' query
		$new_pending_q = "SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, orders.status, publications.name, adreps.first_name, order_status.d_name FROM `orders`
		                                                JOIN `publications` ON orders.publication_id = publications.id
		                                                JOIN `adreps` ON orders.adrep_id = adreps.id
		                                                JOIN `order_status` ON orders.status = order_status.id
		                                                WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
		                                                AND (orders.status BETWEEN '1' AND '4') AND (orders.created_on BETWEEN '$ystday' AND '$today') ;";
		//Count For Tab
		$data['cat_count'] = $this->db->query($cat_q)->num_rows();
		$data['QA_count'] = $this->db->query($QA_q)->num_rows();
		$data['new_pending_count'] = $this->db->query($new_pending_q)->num_rows();
        echo json_encode($data);
    }
	
	public function web_cshift_pagination_details($display_type=''){
	    $sId = $this->session->userdata('sId');
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59'; //$today = date('Y-m-d 23:59:59'); 
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00';
		$data =array();
		
    	if($display_type == "category"){
	     $query = "SELECT orders.created_on,orders.id, orders.job_no,adreps.first_name,publications.name, orders.help_desk, orders.rush,  orders.crequest, orders.question, orders.cancel FROM `orders` 
                JOIN `publications` ON orders.publication_id = publications.id
                JOIN `adreps` ON orders.adrep_id = adreps.id
                WHERE orders.order_type_id = '1' AND orders.status = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                AND (orders.created_on BETWEEN '$ystday' AND '$today') ";
	
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        $order_list = $this->db->query($query)->result_array();
        foreach($order_list as $row1){
            $form = $row1['help_desk'];
            
            $row0='';
		   	if($row1['rush']=='1'){
		   	    $row0 = 1;
		   	}
		   	
		    $created_on = strtotime($row1['created_on']); $date=date('d-M', $created_on);
		    //order no
		    $adwit_id = '<a ';
		  if($row1['rush']==1){
		      $adwit_id .= "class='font-grey-cararra'";
		  }
		  $adwit_id .= ' href="javascript:;" onclick="window.location=\''  . base_url() . index_page() . 'new_csr/home/orderview/' . $form . '/' . $row1['id']. '\'" style="cursor:pointer; text-decoration: none;">'
            
            . $row1['id'] . '</a>';
	
            //category
            $categoryContent = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$form. '/' . $row1['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">view</button> </a>';
            if($row1['crequest']=='1'){
               $categoryContent .=" Cancel Request Sent"; 
            }else if($row1['question']=='1'){
                 $categoryContent .="  Question Sent";
            }else if($row1['question']=='2'){
                 $categoryContent .="  Question Answered";
            }
            
            
			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = $date;
	        $sub_array[] = $adwit_id;
	        $sub_array[] = $row1['job_no'];
	        $sub_array[] = $row1['first_name'];
	        $sub_array[] = $row1['name'];
	        $sub_array[] = $categoryContent;
	       
		    $data[] = $sub_array;
        }
		}else if($display_type == "QA"){
	     $query = "SELECT orders.created_on,orders.help_desk,orders.id, orders.job_no, adreps.first_name,publications.name,orders.rush, orders.crequest, orders.question, orders.cancel, cat_result.id AS catId, cat_result.timestamp, cat_result.csr_QA FROM `orders`
                    RIGHT JOIN `cat_result` ON orders.id = cat_result.order_no
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.status BETWEEN '1' AND '4' OR orders.status = '8') AND (orders.created_on BETWEEN '$ystday' AND '$today')
                    AND cat_result.pro_status = '3' AND (cat_result.csr_QA = '".$csr[0]['id']."' OR cat_result.csr_QA = '0') ";
	
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        $order_list = $this->db->query($query)->result_array();
        foreach($order_list as $row){
            $form = $row['help_desk'];
            if(isset($row['catId'])){
            
            $row0='';
		   	if($row['rush']=='1'){
		   	    $row0 = 1;
		   	}   
            
		    $created_on = strtotime($row['timestamp']); $date=date('d-M', $created_on);
		    //order no
		    $adwit_id = '<a ';
    		  if($row['rush']==1){
    		      $adwit_id .= "class='font-grey-cararra'";
    		  }
    		  $adwit_id .= 'title="OrderView" href="javascript:;" onclick="window.location=\''  . base_url() . index_page() . 'new_csr/home/orderview/' . $form . '/' . $row['id']. '\'" style="cursor:pointer; text-decoration: none;">'
                
                . $row['id'] . '</a>';
	
            //category
            $categoryContent = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$form. '/' . $row['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">QA</button> </a>';
            if($row['csr_QA'] == $csr[0]['id']){
               $categoryContent .='<i class="fa fa-flag"></i>'; 
            }else{
                $categoryContent .=' ';
            }
            
            
			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = $date;
	       // $sub_array[] = '<span title="web" class="badge bg-blue">W</span>';
	        $sub_array[] = $adwit_id;
	        $sub_array[] = $row['job_no'];
	        $sub_array[] = $row['first_name'];
	        $sub_array[] = $row['name'];
	        $sub_array[] = $categoryContent;
	       
		    $data[] = $sub_array;
        }
		}
		    
		}else if($display_type == "new_pending"){
	     $query = "SELECT  orders.created_on,orders.help_desk,orders.id, orders.job_no, adreps.first_name,publications.name,orders.rush, orders.crequest, orders.question, orders.cancel, orders.status,order_status.d_name FROM `orders`
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    JOIN `order_status` ON orders.status = order_status.id
                    WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.status BETWEEN '1' AND '4') AND (orders.created_on BETWEEN '$ystday' AND '$today')";
	
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        $order_list = $this->db->query($query)->result_array();
        foreach($order_list as $row1){
            $form = $row1['help_desk'];
            
            $row0='';
		   	if($row1['rush']=='1'){
		   	    $row0 = 1;
		   	} 
		   	
		    $created_on = strtotime($row1['created_on']); $date=date('d-M', $created_on);
		    
		    //order_id
		     $adwit_id = '<a ';
    		  if($row1['rush']==1){
    		      $adwit_id .= "class='font-grey-cararra'";
    		  }
    		  $adwit_id .= ' title="view attachments" href="javascript:;" onclick="window.location=\''  . base_url() . index_page() . 'new_csr/home/orderview/' . $form . '/' . $row1['id']. '\'" style="cursor:pointer; text-decoration: none;">'
                
                . $row1['id'] . '</a>';
            
            //status
            $status ="";
            if($row1['status']=='1' || $row1['status']=='2' || $row1['status']=='3' ){
                //alternate for span tag ...need to discuss
               if($row1['question']=='1'){
                   $status .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="10%">';
               } 
               if($row1['question']=='2'){
                   $status .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="10%">';
               } 
              $status .='<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$form. '/' . $row1['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">'.$row1['d_name'].'</button> </a>';
            }
            if($row1['status']=='4'){
                if($row1['question']=='1'){
                    $status .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="10%">'; 
                }
                if($row1['question']=='2'){
                   $status .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="10%">';
               } 
                $status .='<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$form. '/' . $row1['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue btn-xs">'.$row1['d_name'].'</button> </a>';
            
                $cat_result = $this->db->query("SELECT cat_result.id, cat_result.csr_QA, csr.name FROM `cat_result`
    	                                    RIGHT JOIN `csr` ON cat_result.csr_QA = csr.id
    	                                    WHERE cat_result.order_no = '".$row1['id']."' AND cat_result.pro_status = '3'")->row_array();
		        if(isset($cat_result['name'])){ $status .= $cat_result['name']; } 
            }
            
           
            
			$sub_array = array();
	        $sub_array[] = $row0;
	        $sub_array[] = $date;
	       // $sub_array[] = '<span title="web" class="badge bg-blue">W</span>';
	        $sub_array[] = $adwit_id;
	        $sub_array[] = $row1['job_no'];
	        $sub_array[] = $row1['first_name'];
	        $sub_array[] = $row1['name'];
	        $sub_array[] = $status;
	       
		    $data[] = $sub_array;
        
		}
		    
		}
		
		
		$output = array(  
            "draw"              =>     intval($_GET["draw"]),  
            "recordsTotal"      =>     $recordsTotal,  
            "recordsFiltered"   =>     $recordsFiltered,  
            "data"              =>     $data  
       );  
       echo json_encode($output);
	    
	}
	
	public function frontlinetrack_order_list_pagination($help_desk_id = '')
	{
	    $data['help_desk_id'] = $help_desk_id;
	  
	    $today = date('Y-m-d'); $data['today'] = $today;
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
	
	   $help_desk_detail = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
	   if(isset($help_desk_detail['id'])){
	       $adwit_teams_id = $help_desk_detail['adwit_teams_id'];
	       $adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
	       if(isset($adwit_team['adwit_teams_id'])){
	           $cat_id = explode(',',($adwit_team['category']));
		       $category_level = "'" . implode ( "', '", $cat_id ) . "'";
		       if(isset($_GET['display_type'])){ $display_type = $_GET['display_type']; }else{ $display_type = 'all'; } 
	           if(isset($_GET['date'])){ $order_date = $_GET['date']; }else{ $order_date = $today; }
    	        $data['date'] = $order_date;
                $data['display_type'] = $display_type;
                $this->load->view('new_csr/frontlinetrack_order_list_pagination',$data);
	   }else{
	       $this->session->set_flashdata('message', 'No Teams assigned for Help Desk.');    
	       redirect('new_csr/home/frontlinetrack_all');
	   }
	   
	   }else{
	       redirect('new_csr/home/frontlinetrack_all');
	   }
	}
	
	public function frontlinetrack_order_list_pagination_details($help_desk_id = ''){
	    $data = array();
	    $today = date('Y-m-d'); 
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$pystday = date('Y-m-d', strtotime(' -2 day'));
		$qystday = date('Y-m-d', strtotime(' -3 day'));
	    $help_desk_detail = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
	    $adwit_teams_id = $help_desk_detail['adwit_teams_id'];
	    $adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
	       if(isset($adwit_team['adwit_teams_id'])){
	           $cat_id = explode(',',($adwit_team['category']));
		       $category_level = "'" . implode ( "', '", $cat_id ) . "'";
		       if(isset($_GET['display_type'])){ $display_type = $_GET['display_type'];   }else{ $display_type = 'all'; } 
	           if(isset($_GET['date'])){ $order_date = $_GET['date'];  }else{ $order_date = $today; } 
	           
	           if($this->session->userdata('publicationListTeam'.$adwit_teams_id)!== null){
                  $publicationListTeam = $this->session->userdata('publicationListTeam'.$adwit_teams_id); 
               }else{
                   $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications`
                                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id)")->row_array();
                  $publicationListTeam =  $team_publication['publicationsId'];
               }
	           
    	       if($order_date == 'rush'){
    	          /* $query = "SELECT orders.created_on,orders_type.value,orders.id,orders.job_no,CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname, publications.name AS Pname,
    	           orders.order_type_id, orders.status, orders.advertiser_name,  orders.question, orders.help_desk,orders_type.name FROM orders
	                    JOIN `publications` ON publications.id = orders.publication_id
	                    JOIN `adreps` ON adreps.id = orders.adrep_id
	                    JOIN `orders_type` ON orders_type.id = orders.order_type_id
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.crequest != '1' AND orders.help_desk != '0'
	                    AND orders.publication_id IN ($publicationListTeam) AND DATE(orders.created_on) > '2023-01-01' ";*/
	                    
	                $query = "SELECT orders.created_on,orders.order_type_id,orders.id,orders.job_no,orders.adrep_id,orders.publication_id,
    	           orders.status, orders.advertiser_name,  orders.question, orders.help_desk FROM orders
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.crequest != '1' AND orders.help_desk != '0'
	                    AND orders.publication_id IN ($publicationListTeam) AND DATE(orders.created_on) > '2023-01-01' ";
	                   
        	       $recordsTotal = $this->db->query($query)->num_rows();
                    if(isset($_GET['search']['value']) && $_GET['search']['value'] != null){
                        $query .= " AND (";
                       
                        $query .= ' orders.id  LIKE "%'.$_GET["search"]["value"].'%"';
                       
                        $query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
                        
                        // $query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
                        
                        // $query .= ' OR CONCAT(adreps.first_name, " ", adreps.last_name) LIKE "%' . $_GET["search"]["value"] . '%"';
                        
                        $query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
                        
                        $query .= ") ";
                    }
                    
                    if(isset($_GET["order"])){
                        $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir'];
                    }else{
                         $query .="  ORDER BY orders.id DESC";
                    }
                    $recordsFiltered = $this->db->query($query)->num_rows();
                    if(isset($_GET["length"]) && $_GET["length"] != -1){  
                        $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                    }
        
                    $i =0;
                    // print_r($query);exit();
                    $rev_sold_jobs = $this->db->query($query)->result_array();
                    foreach($rev_sold_jobs as $row){
                        $publication_id = $row['publication_id'];
                        $adrep_id = $row['adrep_id'];
                        $order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->row_array();
                        $publication_name = $this->db->query("SELECT publications.name AS Pname  from publications where publications.id =$publication_id ")->row_array();
                        $adrep_name = $this->db->query("SELECT CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname  from adreps where adreps.id =$adrep_id")->row_array();
                        $order_status = $this->db->get_where('order_status',array('id'=>$row['status']))->row_array();
                        
                        $row0="1";
                        $created_on = strtotime($row['created_on']); $date=date('d-M', $created_on);
                        //type
                        if($order_type['value']=='print'){$type ="P";}elseif($order_type['value']=='web'){ $type = "W";}elseif($order_type['value']=='pagination'){ $type = "PG";}else{ $type = "P&W";}
                        //job_no
                        if($row['order_type_id'] == '6'){
                            $job_no = $row['advertiser_name'].'/'.$row['job_no'];
                         }else{
                            $job_no = $row['job_no'];
                         }
                         //status
                         $status ='';
                         if($row['question']=='1'){
                            $status .= '<img title="Question sent" src="'.base_url().'assets/media.png" alt="Image" width="10%">'; 
                         }
                         if($row['question']=='2'){
                            $status .= '<img title="Answered" src="'.base_url().'assets/answer-icon.png" alt="Image" width="10%">';
                         } 
                            $status .='<a title="OrderView" href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_csr/home/orderview/' .$row['help_desk']. '/' . $row['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                            <button class="btn blue btn-xs">'.$order_status['d_name'].'</button> </a>';
                         
                        $sub_array = array();
                        $sub_array[] = $row0;
                        $sub_array[] = $date;
                        $sub_array[] = '<span title="'.$order_type['name'].'" class="badge bg-blue">' . $type . '</span>';
                        $sub_array[] = $row['id'];
                        $sub_array[] = $job_no;
                        $sub_array[] = $adrep_name['Aname'];
                        $sub_array[] = $publication_name['Pname'];
                        $sub_array[] = $status;
                        $sub_array[] = "";
                        $sub_array[] = "";
                        $sub_array[] = "";
                        $sub_array[] = "";
                        
                        $data[] = $sub_array;
                        
                    }    
    	       }else{
    	           
    	          if($help_desk_id == '20'){ //pagination
        	              /* $query = "SELECT cat_result.order_type_id,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,rev_sold_jobs.designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.category,rev_sold_jobs.rush,rev_sold_jobs.rush,rev_sold_jobs.order_id,rev_sold_jobs.order_no,rev_sold_jobs.status,rev_sold_jobs.sent_time,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM rev_sold_jobs
            	                left JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
            	                left JOIN `designers` ON designers.id = rev_sold_jobs.designer
                                WHERE cat_result.category = 'G'
                                AND rev_sold_jobs.date = '$order_date' ";*/
                                
                            $query = "SELECT live_revisions.category as order_cat,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,live_revisions.designer_id as designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.rush,live_revisions.order_id,live_revisions.status,rev_sold_jobs.sent_time,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM live_revisions
            	                left JOIN `rev_sold_jobs` ON rev_sold_jobs.id = live_revisions.revision_id
            	                left JOIN `designers` ON designers.id = rev_sold_jobs.designer
                                WHERE live_revisions.category = 'G'
                                AND rev_sold_jobs.date = '$order_date' ";
        	           }else{
        	             
            	           /*$query = "SELECT cat_result.order_type_id,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,rev_sold_jobs.designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.category,rev_sold_jobs.rush,rev_sold_jobs.rush,rev_sold_jobs.order_id,rev_sold_jobs.order_no,rev_sold_jobs.status,rev_sold_jobs.sent_time,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM rev_sold_jobs
            	                left JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
            	                left JOIN `designers` ON designers.id = rev_sold_jobs.designer
                                WHERE cat_result.publication_id IN ($publicationListTeam)
                                AND cat_result.category IN ($category_level)
                                AND rev_sold_jobs.date = '$order_date' "; */
                                
                            $query = "SELECT live_revisions.category as order_cat,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,live_revisions.designer_id as designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.rush,live_revisions.order_id,live_revisions.status,rev_sold_jobs.sent_time,rev_sold_jobs.category,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM live_revisions
            	                left JOIN `designers` ON designers.id = live_revisions.designer_id
            	                left JOIN `rev_sold_jobs` ON rev_sold_jobs.id = live_revisions.revision_id
                                WHERE live_revisions.pub_id IN ($publicationListTeam)
                                AND live_revisions.category IN ($category_level)
                                AND rev_sold_jobs.date = '$order_date' "; 
        	           }
        	           if($order_date == 'question'){ //question tab 
        	               $week = date('Y-m-d', strtotime(' -7 day'));
        	               /*$query = "SELECT cat_result.order_type_id,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,rev_sold_jobs.designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.category,rev_sold_jobs.rush,rev_sold_jobs.rush,rev_sold_jobs.order_id,rev_sold_jobs.order_no,rev_sold_jobs.status,rev_sold_jobs.sent_time,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM rev_sold_jobs
            	                left JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
            	                left JOIN `designers` ON designers.id = rev_sold_jobs.designer
                                WHERE cat_result.publication_id IN ($publicationListTeam)
                                AND cat_result.category IN ($category_level)
                                AND rev_sold_jobs.date BETWEEN '$week' AND '$ystday' AND  rev_sold_jobs.status NOT IN ('5','9') AND rev_sold_jobs.question IN ('1','2')";*/
                            $query = "SELECT live_revisions.category as order_cat,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,live_revisions.designer_id as designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.rush,live_revisions.order_id,live_revisions.status,rev_sold_jobs.sent_time,rev_sold_jobs.category,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM live_revisions
            	                left JOIN `designers` ON designers.id = live_revisions.designer_id
            	                left JOIN `rev_sold_jobs` ON rev_sold_jobs.id = live_revisions.revision_id
                                WHERE live_revisions.pub_id IN ($publicationListTeam)
                                AND live_revisions.category IN ($category_level)
                                AND rev_sold_jobs.date BETWEEN '$week' AND '$ystday' AND  live_revisions.status NOT IN ('5','9') AND rev_sold_jobs.question IN ('1','2')";
        	           }else{
                            if($display_type == 'pending'){
                               $query .= " AND live_revisions.status NOT IN ('5','9') ";
                            }elseif($display_type == 'sent'){
                               $query = "SELECT orders.order_type_id,rev_sold_jobs.order_no,rev_sold_jobs.time,designers.username,rev_sold_jobs.designer,rev_sold_jobs.classification,
            	                rev_sold_jobs.category,rev_sold_jobs.rush,rev_sold_jobs.rush,rev_sold_jobs.order_id,rev_sold_jobs.order_no,rev_sold_jobs.status,rev_sold_jobs.sent_time,
            	                rev_sold_jobs.job_status,rev_sold_jobs.question,rev_sold_jobs.sold_pdf,rev_sold_jobs.frontline_csr,rev_sold_jobs.job_accept,rev_sold_jobs.source_file,rev_sold_jobs.id,
            	                rev_sold_jobs.new_slug,rev_sold_jobs.adrep,rev_sold_jobs.time_taken,rev_sold_jobs.pdf_path FROM rev_sold_jobs
            	                left JOIN `orders` ON orders.id = rev_sold_jobs.order_id
            	                left JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
            	                left JOIN `designers` ON designers.id = rev_sold_jobs.designer
                                WHERE cat_result.publication_id IN ($publicationListTeam)
                                AND cat_result.category IN ($category_level)
                                AND rev_sold_jobs.date = '$order_date' AND rev_sold_jobs.status IN ('5','9') "; 
                            }elseif($display_type == 'QA'){
                               $query .= " AND rev_sold_jobs.status IN ('4','7') "; 
                            }
        	           }
        	   $recordsTotal = $this->db->query($query)->num_rows();
        		//search or Filter
        		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
        		    $query .= " AND (";
        		    
        			$query .= ' rev_sold_jobs.order_no LIKE "%'.$_GET["search"]["value"].'%"';
        			
        			$query .= ' OR designers.username LIKE "%'.$_GET["search"]["value"].'%"';
        			
        		    $query .= ") ";
        		}
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{
                    $query .= " ORDER BY rev_sold_jobs.id ASC "; 
                }
                $recordsFiltered = $this->db->query($query)->num_rows();
                
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                $rev_sold_jobs = $this->db->query($query)->result_array();
                $count = '0'; $cat_time = '0'; $timer = '0'; $i=0;
                $current_time = date("H:i:s"); 
        	     foreach($rev_sold_jobs as $row){
        	         if($row['designer']!='0'){
            		    $designer = $this->db->get_where('designers',array('id' => $row['designer']))->result_array();
            		   }
            		$count--; 
            		$time_left = '0';
            		$start = strtotime($row['time']);
            		$end = strtotime($current_time);
            		$time_left = $end - $start ; 
            		$time_left = $time_left / 60;
            		$time_left_rnd = round($time_left,0);
            		$frontline_timer = $this->db->get('frontline_timer')->result_array();
            		if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
            		foreach($frontline_timer as $row1){
            			if($row['category'] == $row1['cat_name']){ $cat_time = $row1['duration']; }
            		}
            		
            		$row0='';
            		if($row['rush']=='1'){
            		   $row0='1'; 
            		}
            		//type
            		$type ="";
            		if($display_type == 'sent'){
            		if($row['order_type_id']=='2'){$type= "P";} elseif($row['order_type_id']=='1'){ $type= "W";} elseif($row['order_type_id']=='6'){ $type= "PG";} else{ $type= "P&W";}
            		}else{
            		  $type = $row['order_cat'];  
            		}
            		//order_no
            		 $job_no = '<a  class="word-wrap-name"'; 
            		if($row['rush'] == 1){
    			        $job_no .= 'class="font-grey-cararra" ';
    			       
    			    }
    			     $job_no .= 'href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">'.$row['order_no'].'</a>'; 
    			    //revision    
    			    $revision ="";    
            		if($row['category']=='revision'){
        	            $revision = $row['time'];
        	        }
        	        //designer
        	        $designer_name ="";    
            		if($row['username']!=null){
        	            $designer_name =$row['username'];
        	        }
            		//time left
            		if($row['status']=='5' || $row['status']=='8'){
						$time_left =  '';
					}elseif($time_left < $cat_time && $row['sent_time']=='00:00:00'){ 
						$timer = $cat_time - $time_left ;  
						if($timer<= '5'){
							$time_left =  "<font color='red'>". round($timer,0)." min </font>";
						}else{ $time_left = round($timer,0)." mins"; }
					}else{ $time_left =  "Elapsed"; }
					
					//time sent
					if($row['job_status']=='1'){
					    $time_sent ='';
					    if($row['question']=='1'){ 
							$time_sent = '<button>Question Sent</button>';
						}else if($row['sent_time']!='00:00:00' && $row['status'] != '8'){
						    $time_sent = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
											<button type="button" id="accept" class="btn btn-sm btn-primary">Sent</button>
										 </a>';
						}elseif($row['sent_time']!='00:00:00' && $row['status'] == '8'){ 
						    $time_sent = $row['sent_time']; 
						}else{
						    if($row['sold_pdf'] != 'none' && $row['frontline_csr'] == '0' && $row['status'] == '8') { 
						       $time_sent ='<button name="Submit" class="btn btn-sm btn-primary">Send</button>'; 
						    }elseif($row['sold_pdf'] != 'none' && $row['status'] == '4') {
						       $time_sent = '<button name="send_sold" class="btn btn-sm btn-primary">Send</button>';
						    }else if($row['sold_pdf']=='none' && $row['status'] == '8'){
						       $time_sent = '<div class="btn-group">
											 <a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
												<button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
											 </a>
											</div>';
						    }elseif($row['job_accept']=='0' && $row['order_id']!=''){
						       $time_sent = '<div class="btn-group">
											 <a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
												<button type="button" id="accept" class="btn btn-sm btn-primary">Accept</button>
											 </a>
											</div>';
						    }elseif($row['source_file']!='none' && $row['status']=='4'){
						       if($row['frontline_csr'] == '0'){
                                        $time_sent = '<form method="post" id="proof_check_form"> 
                                                        <button type="button" name="revision_proof_check" class="btn btn-sm btn-warning" onclick="confirm_qa(' . $help_desk_id . ', \'' . $row['order_id'] . '\')">In QA</button>
                                                        <input type="text" name="revision_id" value="' . $row['id'] . '" style="display:none;">
                                                        <div style="display:none" id="proof_check_div"></div>
                                                    </form>';
						       }else{
						           $time_sent ='<a href="'. base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
												    <button type="button" id="accept" class="btn btn-sm btn-warning">In QA</button>
												</a> ';
						       } 
						    }elseif($row['sold_pdf']!='none' && $row['status']=='4'){ 
						        if($row['frontline_csr'] == '0'){
						            $time_sent = '<form method="post" id="proof_check_form"> 
                            						<button type="button" name="revision_proof_check" class="btn btn-sm btn-warning" onclick="confirm_qa(' . $help_desk_id . ', \'' . $row['order_id'] . '\')">In QA</button>
                            						<input type="text" name="revision_id" value="'.$row['id'].'" style="display:none;">
                            						<div style="display:none" id="proof_check_div"></div>
                            					</form> ';
						        }else{
						            $time_sent = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
												    <button type="button" id="accept" class="btn btn-sm btn-primary">In QA</button>
												</a>';
						        }
						    }elseif($row['sold_pdf']!='none'&&$row['status']=='5'&&$row['new_slug']!='none'){
						       $time_sent = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
											    <button type="button" id="accept" class="btn btn-sm btn-primary">ProofReady</button>
											</a>'; 
						    }elseif($row['new_slug']!='none'){
						        $time_sent ='<a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
											    <button type="button" id="accept" class="btn btn-sm btn-primary">In Production</button>
											</a>';
						    }elseif($row['status']=='2'){
						        $time_sent = '<a href="'.base_url().index_page().'new_csr/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
											    <button type="button" id="accept" class="btn btn-sm btn-primary">Accepted</button>
											</a>';
						    }
						    $time_sent .='<input name="id" value="'.$row['id'].'" readonly style="display:none;" />
										 <input name="new_slug" value="'. $row['new_slug'].'" readonly style="display:none;" />
										 <input name="adrep" value="'.$row['adrep'].'" readonly style="display:none;" />';
							if(isset($date)){
							    $time_sent .='<input name="date" value="'.$date.'" readonly style="display:none;" />';
							}
						}
						
					}else{
					    $time_sent = '<font color="blue">removed</font>';
					}
					
					//time_taken
					$time_taken ='';
					if($row['time_taken']!='0'){
					    //calculating hours, minutes and seconds (as floating point values)
						$hours = $row['time_taken'] / 3600; //one hour has 3600 seconds
						$minutes = ($hours - floor($hours)) * 60;
						$seconds = ($minutes - floor($minutes)) * 60;

						//formatting hours, minutes and seconds
						$final_hours = floor($hours);
						$final_minutes = floor($minutes);
						$final_seconds = floor($seconds);

						//output
						$time_taken = $final_hours . ":" . $final_minutes . ":" . $final_seconds; 
					}
					//pdf
					if($row['category']!='sold') {
					    $pdf = '';
					    if($row['pdf_path']!='none' && file_exists($row['pdf_path'])){
					        $pdf_path = base_url().$row['pdf_path'];
					        $pdf ='<a href="'.$pdf_path.'" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="'.base_url.'images/pdf.png" alt="pdf"/></a>';
					    }
					}else{
					    $cat = $this->db->get_where('cat_result',array('order_no' => $row['order_id']))->result_array();
						$sold_pdf_path = 'sold_pdf/'.$row['order_id'].'/'.$cat[0]['slug'];
						if(isset($sold_pdf_path) && $row['sold_pdf']!='none'){ 
						$map1 = $sold_pdf_path.'/'.$row['sold_pdf'];
    					    if(file_exists($map1)){
    					        $pdf ='<a href="'.base_url().$map1.'" target="_blank" style="cursor:pointer; text-decoration: none;"><img src="'.base_url().'images/pdf.png" alt="pdf"/></a>';
    					    }
						}
					}
					//classification
					$classification ='';
					if($row['classification']!='0'){
					    $classification = $rev_classification['name'];
					}
					
					
        			$sub_array = array();
        	        $sub_array[] = $row0;
        	        $sub_array[] = $count;
        	        $sub_array[] = '<span class="badge bg-blue">'.$type.'</span>';
        	        $sub_array[] = $job_no;
        	        $sub_array[] = $row['time'];
        	        $sub_array[] = $designer_name;
        	        $sub_array[] = $time_left;
        	        $sub_array[] = $time_sent;
        	        $sub_array[] = $time_taken;
        	        $sub_array[] = $pdf;
        	        $sub_array[] = $classification;
        	        if($this->session->userdata('sId') == '68'){
				        if($row['status'] != '5'){
				          $sub_array[] = '<td><button onclick="deleteItem(\'' . $row['id'] . '\')">Delete</button></td>';
				        }else{ 
				           $sub_array[] = '<td></td>';  
				        }
				    }
        	        
        		    $data[] = $sub_array;
        	     }      
        	           
    	        } 
    	   }
    	    $output = array(  
                        "draw"              =>     intval($_GET["draw"]),  
                        "recordsTotal"      =>     $recordsTotal,  
                        "recordsFiltered"   =>     $recordsFiltered,  
                        "data"              =>     $data  
           ); 
         echo json_encode($output);
	    
	}
	
	public function frontlinetrack_order_list_pagination_columns($date){
	    
	    $sId = $this->session->userdata('sId');
	    
	    if($date == "rush"){
	         $columns = array('','Date','Type','AdwitAds ID','Unique Job Name','Adrep','Publication'); 
	    }else{
	        $columns = array('','No','Type','Job No','Revision','Designer','Time Left','Time Sent','Time Taken','PDF','Classification'); 
	        if($sId == '68'){array_push($columns,"Action");}
	    }
	     echo json_encode($columns);
	    
	}
}	

