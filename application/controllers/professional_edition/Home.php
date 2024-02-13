<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Professional_Controller {

	public function index()
	{
		$data['hi'] = "hello";
		$notifications = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1'")->result_array();
		if($notifications){
			$to_date = date('Y-m-d');
			foreach($notifications as $row){
				if($to_date >= $row['end_date']){
					$this->db->update('notification',array('job_status' => '0'), array('id' => $row['id']));
				}
			}
		}
		$this->load->view('professional_edition/home', $data);
	}
	
	public function activate_account()
	{
		if(isset($_POST['code']) && !empty($_POST['code'])){
			$code = $this->input->post('code');
			$design_team = $this->db->get_where('design_teams',array('code'=>$code, 'is_active'=>'1'))->row_array();
			if(isset($design_team['id'])){
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId'), 'new_ui' => '3'))->row_array();
				$group = $this->db->get_where('group', array('id'=>$design_team['group_id'], 'is_active'=>'1'))->row_array();
				$publication_id = $client['publication_id'];
				$post = array(
								'design_team_id' => $design_team['id'],
								'group_id' => $design_team['group_id'],
								'channel' => $group['channel'],
								'slug_type' => $group['slug_type'],
								'help_desk' => $group['help_desk_id'],
								'is_active'=>'1'
							);
				$this->db->where('id', $publication_id);
				$this->db->update('publications', $post);
				if($this->db->affected_rows() > 0){
					$this->session->set_flashdata('message','You have successfully assigned a designer to your account. You can now start ordering ads.');
					redirect('professional_edition/home');
				}
			}else{
				$this->session->set_flashdata('message','Invalid code.. Provide Valid Graphic Designer Code..!!');
				redirect('professional_edition/home/activate_account');
			}
		}
		$this->load->view('professional_edition/activate_account');
	}
	
	public function order_search()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
		$data['publication'] = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$publication_id = $client[0]['publication_id'];
		if($client[0]['team_orders']=='1' ){
			if(isset($_POST['search'])){ //search
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`advertiser_name` LIKE '".$_POST['input']."%' OR `job_no` LIKE '".$_POST['input']."%' OR `id` LIKE '".$_POST['input']."%' ) ;")->result_array();
			}elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
				 	$adrep_id = $this->session->userdata('pcId');
					$keyword = $_POST['keyword'];
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`id` LIKE '".$keyword."%' OR `advertiser_name` LIKE '".$keyword."%' OR `job_no` LIKE '".$keyword."%')")->result_array();
				}  
			
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' ;")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
			} 
		}else{
			if(isset($_POST['search'])){ //search
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." AND (`advertiser_name` LIKE '".$_POST['input']."%' OR `job_no` LIKE '".$_POST['input']."%' OR `id` LIKE '".$_POST['input']."%' ) ;")->result_array();
			}elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
					$adrep_id = $this->session->userdata('pcId');
					$keyword = $_POST['keyword'];
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$adrep_id."' AND (`id` LIKE '".$keyword."%' OR `advertiser_name` LIKE '".$keyword."%' OR `job_no` LIKE '".$keyword."%')")->result_array();
				}  
			
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." ;")->result_array();
					}else{
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
			} 
		}
		$this->load->view('professional_edition/dashboard',$data);
	}
	
	public function print_ad()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId'), 'new_ui' => '3'))->row_array();
		$publication = $this->db->get_where('publications',array('id' => $client['publication_id']))->row_array();
		if($publication['design_team_id']=='0'){
			$data['activate_notification'] = 'inactive';
		}
		
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		$data['client'] = $client; $data['publication'] = $publication;
		if(isset($_POST['submit']))
		{
			if(empty($_POST['rush'])){ $_POST['rush']='0'; }
			
			 $data = array( 
			'adrep_id' =>$this->session->userdata('pcId'),
			'publication_id' => $publication['id'],
			'group_id' => $publication['group_id'],
			'help_desk' => $publication['help_desk'],
			'order_type_id' => '2',
			'size_inches' => $_POST['width'] * $_POST['height'],
			'advertiser_name' => $_POST['advertiser_name'],
			'job_no' => $_POST['job_no'],
			'copy_content_description' => $_POST['copy_content_description'],
			'width' => $_POST['width'],
			'height' => $_POST['height'],
			'print_ad_type' => $_POST['print_ad_type'],
			'notes' => $_POST['notes'],
			'rush'	=> $_POST['rush'],
			'date_needed' => $_POST['date_needed'],
			'publish_date' => $_POST['publish_date'],
			'publication_name' => $_POST['publication_name'],
			'font_preferences' => $_POST['font_preferences'],
			'color_preferences' => $_POST['color_preferences'],
			'job_instruction' => $_POST['job_instruction'],
			'art_work' => $_POST['art_work'],
			); 
			
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
			
			 if($orderid){
				 if($publication[0]['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id'=> $orderid,
						'job_no' => $_POST['job_no'],
						'club_id'=> $publication[0]['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
					
				$this->view($orderid, true);
				$this->orders_folder($orderid);
				redirect('professional_edition/home/order_success/'.$orderid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("professional_edition/home/print_ad");
			}  
		}
		$this->load->view('professional_edition/print_ad',$data);
	}
	
	public function view($id = 0, $email = false)
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($order[0]['id']))
		{
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
			$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();

			$data = array();
			$data['client'] = $client[0];
			$data['order'] = $order[0];
			$data['publications'] = $publications[0];

			if(!$email)
			{
				$this->load->view('professional_edition/dashboard');
			}else
			{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				$data['from'] = $design_team[0]['email_id'];
				$data['from_display'] = 'Design Team';

				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo2'] = $design_team[0]['email_id'];
				
				$data['replyTo_display'] = 'Do not reply';
				$data['replyTo_display2'] = 'Reply to';

				$data['subject'] = 'Adwitads Order #'.$data['order']['id'];
				//Client

				$data['recipient'] = $client[0]['email_id'];
				$data['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				
				$data['design_recipient'] = $design_team[0]['email_id'];
				$data['design_recipient_display'] = 'Design Team';
				
				$data['ad_recipient'] = $client[0]['email_cc'];
				$data['ad_recipient_display'] = 'Advertising Director';
				
				$this->newad_send_mail($data);
				
			}

		}

	}
	
	public function newad_send_mail($data) 
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
 		$this->email->from($data['from'], $data['from_display']);
		$this->email->reply_to($data['replyTo2'],$data['replyTo_display2']);
		$this->email->subject($data['subject']);  
		$this->email->message($this->load->view('professional_emailer/professional_newad_placed_notification_emailer.php',$data, TRUE));
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		if(isset($data['design_recipient'])){		
			$this->email->bcc(array($data['design_recipient']));
		} 
		 	if(isset($data['ad_recipient'])){		
			$this->email->cc(array($data['ad_recipient']));
		}
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		}
	}
	
	public function orders_folder($id = '')
	{
		if($id != ''){
			$order = $this->db->get_where('orders',array('id' => $id))->result_array();
			$data['order'] = $order;
			$data['order_type'] = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $data['order'][0]['job_no']);
			$data['client'] = $client[0];
				
			$path = "downloads/".$id."-".$jname; //path specification
			if (@mkdir($path,0777)){}
				//to store the form
				$myFile = $path."/".$jname.".html";
				$fh = fopen($myFile, 'w') or die("can't open file");
				$stringData = $this->load->view('newclientorder',$data, TRUE);
				fwrite($fh, $stringData);
				fclose($fh);
				//save path
				$post = array('file_path' => $path);
				$this->db->where('id', $id);
				$this->db->update('orders', $post);
		}
	}
	
	public function order_success($orderid='',$id='')
	{
		$data['orderid'] = $orderid;
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$data['order_details'] = $order_details;
		$download_path = $order_details[0]['file_path'];
		if($download_path != 'none' && file_exists($download_path)){
			if($dh = opendir($data['order_details'][0]['file_path'])){
				while(($file = readdir($dh)) !== false) {
					if($file == '.' || $file == '..'){ continue; }
					if($file){ $filename[] = $file; }
					$data['file_names'] = $filename;
				}
				closedir($dh);
			}
			//Uploading files
			if(!empty($_FILES)) {
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$download_path.'/';
				$targetFile = $targetPath . $fileName ;
				if(!move_uploaded_file($tempFile, $targetFile)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					redirect('professional_edition/home/order_success/'.$orderid);
				}else{ $data['file_sucess']="file sucessful!!"; }
			}
			
		}else{
			$this->orders_folder( $orderid ); //if download folder doesnt exists
			redirect('professional_edition/home/order_success/'.$orderid);
		}
		$this->load->view('professional_edition/order_success',$data);
	}
	
	public function online_ad()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId'), 'new_ui' => '3'))->row_array();
		$publication = $this->db->get_where('publications',array('id' => $client['publication_id']))->row_array();
		if($publication['design_team_id']=='0'){
			$data['activate_notification'] = 'inactive';
		}
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		$data['client'] = $client; $data['publication'] = $publication;	
		
		if(isset($_POST['submit']))
		{
			if(empty($_POST['rush'])){ $_POST['rush']='0'; }
			
			$data = array( 
			'adrep_id' =>$this->session->userdata('pcId'),
			'publication_id' => $publication['id'],
			'group_id' => $publication['group_id'],
			'help_desk' => $publication['help_desk'],
			'order_type_id' => '1',
			'advertiser_name' => $_POST['advertiser_name'],
			'job_no' => $_POST['job_no'],
			'maxium_file_size' => $_POST['maximum_file_size'],	
			'copy_content_description' => $_POST['copy_content_description'],
			'ad_format' => $_POST['ad_format'],
			'web_ad_type' => $_POST['web_ad_type'],
			'pixel_size' => $_POST['pixel_size'],
			'custom_width' => $_POST['custom_width'],
			'custom_height' => $_POST['custom_height'],
			'notes' => $_POST['notes'],
			'date_needed' =>$_POST['date_needed'],
			'publish_date' => $_POST['publish_date'],
			'publication_name' => $_POST['publication_name'],
			'font_preferences' => $_POST['font_preferences'],
			'color_preferences' => $_POST['color_preferences'],
			'job_instruction' => $_POST['job_instruction'],
			'art_work' => $_POST['art_work'],
			'rush'	=> $_POST['rush']
			);
			//if($publication[0]['id']=='43' || $publication[0]['id']=='13'){ if(empty($_POST['rush'])) $_POST['rush']='0';  }		
			
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
			
			 if($orderid){
				 if($publication[0]['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id'=> $orderid,
						'job_no' => $_POST['job_no'],
						'club_id'=> $publication[0]['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
				$this->view($orderid, true);
				$this->orders_folder($orderid);
				redirect('professional_edition/home/order_success/'.$orderid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("professional_edition/home/online_ad");
			}  
		}
		$this->load->view('professional_edition/online_ad',$data);
	}
	
	public function dashboard() 
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
		$num_days = $client[0]['display_orders'];
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$publication_id = $client[0]['publication_id'];
		$today = date('Y-m-d');     
		$pday = date('Y-m-d', strtotime(" -$num_days day"));
		$pyday = date('Y-m-d', strtotime(' -6 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ORDER BY `id` DESC;")->result_array();										
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('pcId')."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ORDER BY `id` DESC;")->result_array();										
			}
		}else{
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('pcId')."' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}
		}
		$this->load->view('professional_edition/dashboard',$data);
	}

	public function preorders()
	{
		$today = date('Y-m-d');
		$pday = date('Y-m-d', strtotime(' -6 day'));
		$data['preorder'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
		$this->load->view('professional_edition/preorders', $data);
	
	}
	
	public function preorderform()
	{
		if(isset($_POST['Submit']) && isset($_POST['id']))
		  {
			$data['preorder_details'] = $this->db->get_where('preorder',array('id' => $_POST['id']))->result_array();
			$this->load->view('professional_edition/preorderform', $data);
		  }
		  else{
			if(isset($_POST['order_submit']) && isset($_POST['id']))
			{
				$preorder = $this->db->get_where('preorder',array('id' => $_POST['id']))->result_array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
				$publication_hd = $this->db->query("SELECT * FROM `publications` WHERE `id`='".$client[0]['publication_id']."' ;")->result_array();  
			
				$preorder[0]['publish_date'] = date("Y-m-d", strtotime($preorder[0]['publish_date']));
				if($preorder[0]['publish_date'] != '0000-00-00'){
					//echo $preorder[0]['publish_date'];
					$priority = date('Y-m-d', strtotime('-3 day', strtotime($preorder[0]['publish_date'])));
				}else{
					$priority= date('Y-m-d');
				}
				$preorder[0]['date_needed'] = date("Y-m-d", strtotime($preorder[0]['date_needed']));
				if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; }
				$post = array(
					'adrep_id' => $this->session->userdata('pcId'),
					'publication_id' => $client[0]['publication_id'],
					'group_id' => $publication_hd[0]['group_id'],
					'help_desk' => $publication_hd[0]['help_desk'],
					'order_type_id' => '2', 
					'advertiser_name' => $preorder[0]['advertiser'],
					'date_needed' => $preorder[0]['date_needed'],
					'publish_date' => $preorder[0]['publish_date'],
					'job_no' => $preorder[0]['job_name'],
					'copy_content_description' => $_POST['copy_content_description'],
					'notes' => $_POST['notes'],
					'width' => $_POST['width'],
					'height' => $_POST['height'],
					'print_ad_type' => $_POST['color'],
					'rush' => $rush,
					'priority' => $priority,
					);
				$this->db->insert('orders',$post); 
				$order_no = $this->db->insert_id(); 
				
				if($order_no){
					if($publication_hd[0]['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication_hd[0]['id'],
						'order_id'=> $order_no,
						'job_no' => $preorder[0]['job_name'],
						'club_id'=> $publication_hd[0]['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
					
				 $post = array('accept' => '1');
				 $this->db->where('job_name', $preorder[0]['job_name']);
				 $this->db->update('preorder', $post);
				 
				 $this->view($order_no,true); //send mail
				 $this->orders_folder($order_no); //folder creation
				 redirect('professional_edition/home/order_success/'.$order_no);//File upload
				 redirect('professional_edition/home');
				}else{ 
				 $this->session->set_flashdata("message","Internal Error: Order not placed!");
				 redirect('professional_edition/home');
				} 
		  } 
		   /* if(!empty($_POST['from_dt']) && !empty($_POST['to_dt']))
		   {
				$from = $_POST['from_dt'];
				$to = $_POST['to_dt'];
				$data['preorder'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->result_array();
		   }else{
				$today = date('Y-m-d');
				$pday = date('Y-m-d', strtotime(' -6 day'));
				$data['preorder'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
		   } */
		   /* if(isset($_POST['search'])){ //search
				$data['preorder'] = $this->db->query("SELECT * FROM `preorder` WHERE `adrep_id` = ".$this->session->userdata('pcId')." AND (`advertiser_name` LIKE '".$_POST['input']."%' OR `job_no` LIKE '".$_POST['input']."%' OR `id` LIKE '".$_POST['input']."%' ) ;")->result_array();
			}elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
					$adrep_id = $this->session->userdata('pcId');
					$keyword = $_POST['keyword'];
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$adrep_id."' AND (`id` LIKE '".$keyword."%' OR `advertiser_name` LIKE '".$keyword."%' OR `job_no` LIKE '".$keyword."%')")->result_array();
				}  
			
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." ;")->result_array();
					}else{
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('pcId')." AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
			}  */
		   $this->load->view('professional_edition/preorders', $data);
		}
	}
	
	public function order_action($action = '', $orderid = 0)
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$action_id = $this->db->query("SELECT * FROM `adrep_actions` WHERE `action` = '$action'")->result_array();
		//$order_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$orderid' ORDER BY `id` DESC LIMIT 1")->result_array();
		
		if(isset($order_details[0]['id']) && isset($action_id[0]['id'])){
			$data['orderid'] = $orderid;
			$data['order_details'] = $order_details;
			$data['action_id'] = $action_id[0]['id']; $data['action'] = $action_id[0]['action'];
			/*if($order_details[0]['question']=='1')
			{
				$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id`='$orderid' ORDER BY `id` DESC LIMIT 1")->result_array();
				$data['question'] = $question[0];
			} elseif(isset($order_rev[0]['id']) && $order_rev[0]['question']=='1')
			{
				$rev_id = $order_rev[0]['id'];
				$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id`='$rev_id' ORDER BY `id` DESC LIMIT 1")->result_array();
				$data['question'] = $question[0];
			}*/
			//revision
			if($action == 'revision'){
				if(isset($_POST['rev_submit'])){
					$rev_id = $this->order_revision( $orderid );
					$data['rev_sold_jobs'] = $this->db->get_where('rev_sold_jobs',array('id'=>$rev_id))->result_array();
				}else{
					$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
					if(isset($orders_rev['id'])){
						$slug = $orders_rev['new_slug'];
					}else{
						$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->row_array();
						$slug = $cat_result['slug'];
					}
					
					if($slug!='none')
					{ 
						$data['order_details'] = $order_details;
						$data['slug'] = $slug;
					}else{
						$this->session->set_flashdata("message",$orderid." : Revision not yet allowed..!!");
						redirect('professional_edition/home/dashboard');
					}
				}
			}
			
			//pickup
			if($action == 'pickup' && isset($_POST['pickup_submit'])){
				$this->order_pickup($orderid);
			}

			/*//QA
			if($action == 'QA' && isset($_POST['QA_submit']))
			{$this->new_ad_answer($orderid);}
		
			
			//QA_revision
			if($action == 'QA_rev' && isset($_POST['QA_rev_submit']))
			{$this->rev_ad_answer($order_rev[0]['id']);}
			*/
			$this->load->view('professional_edition/order_action',$data);
		}
		
	}
	
	public function order_revision($orderid = 0)
	{
		//Uploading files
		if ($orderid != '0' && !empty($_FILES)){ //Arg orderid contains rev id
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('id' => $orderid))->result_array();
			if(isset($orders_rev[0]['file_path'])){
				$path = $orders_rev[0]['file_path'];
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$path.'/';
				$targetFile = $targetPath . $fileName ;
				if(!move_uploaded_file($tempFile, $targetFile)){
					echo"<script>alert('Error Uploading File')</script>";
				}
			}
		}
		//revision submit
		if($orderid != '0' && isset($_POST['rev_submit']))
		{ 
			$version = 'V1a'; 
			$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			if($orders_rev){
				/*foreach($orders_rev as $last_row){ $version = $last_row['version']; }*/
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
			}
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			
			
			$rev_data = array(
				'order_id'=>$orderid,
				'order_no' => $_POST['job_slug'],
				'adrep'=>$this->session->userdata('pcId'),
				'help_desk'=>$publication[0]['help_desk'],
				'date'=> date('Y-m-d'),
				'time'=>date("H:i:s"),
				'category'=>'revision',
				'version'=>$version,
				'note'=>$_POST['notes'],
				'status'=>'1',
				);
			$this->db->insert('rev_sold_jobs',$rev_data);
			$rev_id = $this->db->insert_id(); 
			if($rev_id)	
			{
				$revision = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
				//Revision details of the order
				$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
				$rev_count = $order_details[0]['rev_count'];
				
				$rev_count_data = array(
				'rev_count' => $rev_count + '1', 
				'rev_id' =>$rev_id,
				);
				$this->db->where('id', $orderid);
				$this->db->update('orders', $rev_count_data);
				
				//folder creation
				$path="revision_downloads/".$orderid.'-'.$rev_id; 
				if (@mkdir($path,0777))	{}
				//save path
				$post = array('file_path' => $path);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $post);
				//send mail
				$data['order'] = $order_details[0];
				$data['client'] = $client[0];
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				$data['design_team'] = $design_team[0];
				
					$dataa['from'] = $design_team[0]['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team[0]['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
					$dataa['subject'] = 'AdwitAds Revision #'.$revision[0]['order_no'];
					$dataa['body'] = $this->load->view('professional_emailer/professional_revad_placed_notification_emailer',$data, TRUE);
					$dataa['ad_recipient'] = $client[0]['email_cc'];
					$dataa['ad_recipient_display'] = 'Advertising Director';
				
					//Client
					$dataa['recipient'] = $this->session->userdata('pcEmail');
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$this->rev_jobs_mail($dataa);
					
					return $rev_id;
			}else{
				$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Revision Not Submitted : '.$orderid.'-'.$this->db->_error_message().' !! </button>');
				redirect('professional_edition/home/dashboard');
			}
		}
	}
	
	public function order_pickup($orderid)
	{
		
		if(isset($_POST['pickup_submit']))
		{
			$adrep = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
			
			$order_details = array(
				'adrep_id' => $this->session->userdata('pcId'),
				'publication_id' => $adrep[0]['publication_id'],
				'help_desk' => $publication[0]['help_desk'],
				'group_id' => $publication[0]['group_id'],
				'order_type_id' =>  $_POST['order_type_id'],
				'advertiser_name' => $_POST['advertiser_name'],
				//'publication_name' => $_POST['publication_name'],
				//'job_instruction' => $_POST['job_instruction'],
				'print_ad_type' => $_POST['print_ad_type'],
				//'date_needed' => date('Y-m-d',strtotime($_POST['date_needed'])),
				'job_no' => $_POST['job_no'],
				'copy_content_description' => $_POST['copy_content_description'],
				'notes' => $_POST['notes'],
				'width' => $_POST['width'] ,
				'height' => $_POST['height'],
				//'size_inches' => $_POST['width'] * $_POST['height'] * 0.3937 ,
				'size_inches' => $_POST['width'] * $_POST['height'] ,
				'pickup_adno' => $orderid,
				'status' => '1',
			);
			$this->db->insert('orders', $order_details);
			$pickupid = $this->db->insert_id();
			if($pickupid){
				if($publication[0]['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id'=> $pickupid,
						'job_no' => $_POST['job_no'],
						'club_id'=> $publication[0]['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
				$this->view($pickupid, true);
				$this->orders_folder($pickupid);
				redirect('professional_edition/home/order_success/'.$pickupid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("professional_edition/home/place_order");
			} 
		}
		
	}
	
	public function additional_att($id='')
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		$data['order'] = $order;
		if(isset($order[0]['id'])){
			$rev_details = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$id' ORDER BY `id` DESC")->result_array();
			if($rev_details){
				$path = $rev_details[0]['file_path'];
			}else{
				$path = $order[0]['file_path'];
			}
		
			//Uploading files
			if (!empty($_FILES)) {
					//$path = $order[0]['file_path'];
					if (@mkdir($path,0777)){}
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						$targetPath = getcwd().'/'.$path.'/';
						$targetFile = $targetPath . $fileName ;
						
						if(!move_uploaded_file($tempFile, $targetFile)){
							$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						}else{ echo "success";}
			}
			
			if(isset($_POST['add_submit'])) {
				if($path != 'none') {
					if(is_dir($path)) {
						if($dh = opendir($path)) {
							while(($file = readdir($dh)) !== false) {
								if($file == '.' || $file == '..'){ continue; }
								$datecheck = date('F d Y');
								if($file) {
									$lastmodified = date("F d Y",filemtime(mb_convert_encoding($path."/".$file,'ISO-8859-1', 'UTF-8')));
									if($lastmodified == $datecheck){ $filename[] = $file;}
								}	
							}
							closedir($dh);
						}
						$data['filename'] = $filename;
					} 
				}
				$this->additional_att_view($id, true,$data);
			}
		}
		redirect('professional_edition/home/dashboard');
	}
		
	public function order_cancel($order_id = '')
	{
		$order = $this->db->get_where('orders', array('id' => $order_id))->result_array();
		if(isset($order[0]['id']) && isset($_POST['remove'])){
			$post = array('cancel' => '1', 'crequest' => '0', 'status' => '6');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post);
						
			//orders_cancel
			$orders_cancel = $this->db->query("SELECT * FROM `orders_cancel` WHERE `order_id`='$order_id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($orders_cancel){
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('adrep' => $this->session->userdata('pcId'), 'Atimestamp' => $timestamp);
				$this->db->where('id', $orders_cancel[0]['id']);
				$this->db->update('orders_cancel', $post_cancel);
			}else{
				//if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/Chicago');}
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('order_id' => $order_id, 'adrep' => $this->session->userdata('pcId'), 'Atimestamp' => $timestamp);
				$this->db->insert('orders_cancel', $post_cancel);
			}
			$this->session->set_flashdata("message","Order Cancellation for $order_id Submitted!!");
			redirect('professional_edition/home/dashboard');
		}
	}
	
	public function new_ad_answer($id='') 
	{
		$order = $this->db->get_where('orders', array('id' => $id))->result_array();
		$data['order_details'] = $order[0]['id'];
		if(isset($order[0]['id'])){
			$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id`='$id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($question){
				if(isset($_POST['submit'])){
					if (!empty($_FILES['ufile']['tmp_name'][0])) //file upload to downloads
					{ 
		 				$path1 = $order[0]['file_path'].'/'.$_FILES['ufile']['name'][0];
						if(!copy($_FILES['ufile']['tmp_name'][0], $path1)){
							echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
							exit();
						}else{
							$dataa['attachment'] = $path1;
						}        
					}
		
		
					//order status
					$post_status = array('question' => '2');
					$this->db->where('id', $id);
					$this->db->update('orders', $post_status); 
					
					//orders_Q_A
					
					$timestamp = date('Y-m-d H:i:s');
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('pcId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//send mail 
					$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
					if($client){
						$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
						$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						 
						$dataa['from'] = $design_team[0]['email_id'];
						$dataa['from_display'] = 'Design Team';
						$dataa['replyTo'] = $design_team[0]['email_id'];
						$dataa['replyTo_display'] = 'Design Team';
						$dataa['subject'] = 'Question Answered for Unique Ad No: '.$order[0]['job_no'] ;
						$_POST['answer'] = str_replace(PHP_EOL,'<br/>', $_POST['answer']);
						$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Answer : '.$_POST['answer'];
						
						//client
						$dataa['recipient'] = $this->session->userdata('ncEmail');
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					
						//Cc
						$dataa['cc_recipient'] = $client[0]['email_cc'];
						
						//Design team 
						 
						$dataa['design_recipient'] = $design_team[0]['email_id'];
						$dataa['design_recipient_display'] = 'Design Team';
						$this->test_mail($dataa); 
					} 
					redirect('professional_edition/home/dashboard');
				}
	   
				$data['question'] = $question[0];//cat_result 
				$this->load->view('professional_edition/ad_answer', $data);
				}
		}else{ 
			echo "<script>alert('Direct Access Denied..')</script>";
			//$this->session->set_flashdata("message","Internal Error: Order not placed!");
			$this->index();
		}
	}
	
	public function rev_ad_answer($id='') 
	{ 
		$rev_order = $this->db->get_where('rev_sold_jobs',array('id' => $id))->result_array();
		
		$data['order_details'] = $rev_order[0]['order_id'];
		
		if(isset($rev_order[0]['id'])){
			$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id`='$id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($question){
				if(isset($_POST['submit'])){
					//$order = $this->db->get_where('orders',array('id' => $id))->result_array();
					if (!empty($_FILES['ufile']['tmp_name'][0])) //file upload to downloads
					{ 
		 				$path1 = $rev_order[0]['file_path'].'/'.$_FILES['ufile']['name'][0];
						if(!copy($_FILES['ufile']['tmp_name'][0], $path1)){
							echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
							exit();
						}else{
							$dataa['attachment'] = $path1;
						}        
					}
		
					//rev order status
					$post = array( 'question' => '2' );
					$this->db->where('id', $id);
					$this->db->update('rev_sold_jobs', $post);
				
					//orders_Q_A
					$timestamp = date('Y-m-d H:i:s');
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('pcId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//send mail 
					 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
					if($client)
					{
						$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
						$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						
						$dataa['from'] = $design_team[0]['email_id'];
						$dataa['from_display'] = 'Design Team';
						$dataa['replyTo'] = $design_team[0]['email_id'];
						$dataa['replyTo_display'] = 'Design Team';
						$dataa['subject'] = 'Question Answered for Unique Ad No: '.$_POST['order_id'] ;
						
						$_POST['answer'] = str_replace(PHP_EOL,'<br/>', $_POST['answer']);
						$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Answer : '.$_POST['answer'];
						
							//client
						$dataa['recipient'] = $this->session->userdata('ncEmail');
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					
						//Cc
						$dataa['cc_recipient'] = $client[0]['email_cc'];
						
						//Design team	
						
						$dataa['design_recipient'] = $design_team[0]['email_id'];
						$dataa['design_recipient_display'] = 'Design Team';
						$this->test_mail($dataa); 
					} 
					redirect('professional_edition/home/dashboard');
				}
				$data['rev_sold_jobs'] = $rev_order; //revision
		
				$data['question'] = $question[0];
				$this->load->view('professional_edition/ad_answer', $data);
			} 
			}else{ 
			echo "<script>alert('Direct Access Denied..')</script>";
			//$this->session->set_flashdata("message","Internal Error: Order not placed!");
			$this->index();
		}
	}
	
	public function reject_v2($order_id = '')
	{
		$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		if(isset($order[0]['id'])){
			if(isset($_POST['reject']))
			{
				if (!empty($_FILES['ufile']['tmp_name'][0]))	//file attach to mail
				{	
					$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
					$dataa['fname1'] = $_FILES['ufile']['name'][0];
				}
				
				/* $post = array('cancel' => '0', 'reason' => $_POST['reason']);
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $post); */
				
				//order status Qrequest
				$post_status = array('crequest' => '0');
				$this->db->where('id', $order_id);
				$this->db->update('orders', $post_status);
				
				//orders_cancel
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('adrep' => $this->session->userdata('pcId'), 'Rreason' => $_POST['reason'], 'Atimestamp' => $timestamp);
				$this->db->where('id', $_POST['id']);
				$this->db->update('orders_cancel', $post_cancel);
				
				//send mail
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
				if($client)
				{
					
					$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
					$dataa['from'] = $design_team[0]['email_id'];
					
					$dataa['from_display'] = 'Design Team';

					$dataa['replyTo'] = $design_team[0]['email_id'];

					$dataa['replyTo_display'] = 'Design Team';

					$dataa['subject'] = 'Ad Request For Cancellation of order : '.$_POST['order_no'].' Not Approved' ;
					
					$_POST['reason'] = str_replace(PHP_EOL,'<br/>', $_POST['reason']);
					$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Reason : '.$_POST['reason'];
					//Design team	
					
					$dataa['recipient'] = $design_team[0]['email_id'];
					//$dataa['recipient'] = 'sudarshan@adwitads.com';
					$dataa['recipient_display'] = 'Design Team';
					$this->test_mail($dataa); 
				}
				$this->session->set_flashdata("message","Order Cancellation Request Rejected!!");
				redirect('professional_edition/home/dashboard');
			}else{
				$data['orders_cancel'] = $this->db->get_where('orders_cancel',array('order_id' => $order_id))->result_array();
				$data['order'] = $order[0];
			}
			
			$this->load->view('professional_edition/reject_v2',$data);
		} 
	}
	
	public function test_mail($dataa) 
	{
		$this->load->library('email'); 
		$this->email->set_mailtype("html"); 
		$this->email->from($dataa['from'], $dataa['from_display']); 
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		$this->email->subject($dataa['subject']);
		$this->email->message($dataa['body']);
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
	   
	    if(isset($dataa['design_recipient'])){ $this->email->bcc($dataa['design_recipient']); }
	   
		if(isset($dataa['temp1'])){ $this->email->attach($dataa['temp1'], 'attachment', $dataa['fname1']); }
		if(isset($dataa['temp2'])){ $this->email->attach($dataa['temp2'], 'attachment', $dataa['fname2']); }
		
		if(!$this->email->send())
               return false;
               else
               return true;
	}
	
	public function jRate($order='')
	{
		$order_details = $this->db->get_where('orders',array('id' => $order, 'status'=>'5', 'pdf !=' => 'none'))->result_array();
		if(isset($order_details[0]['id'])){  
			//$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order))->result_array();
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order' ORDER BY `id` DESC LIMIT 1")->row_array();
			//$order_details = $this->db->get_where('orders',array('id' => $order))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->result_array();
			if($orders_rev){
				$filename = $orders_rev['pdf_path'];
				$rev_id = $orders_rev['id'];
				$rev_approve = $orders_rev['approve'];
				
				if($rev_approve=='0'){
					$post = array('approve'=>'1');
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post); 
				}
			}else{
				$filename = $order_details[0]['pdf'];
				if(!file_exists($filename)){
					$this->load->helper('directory');
					$map = directory_map('pdf_uploads/'.$order.'/');
					if($map){ foreach($map as $file){ $filename = 'pdf_uploads/'.$order.'/'.$file; }}
				}
				if($order_details[0]['approve']=='0'){
					$post = array('approve'=>'1', 'status'=>'7');
					$this->db->where('id', $order_details[0]['id']);
					$this->db->update('orders', $post);
				} 
			}
			$ftp_server = 'none';
			//ftp upload
			if($order_details[0]['publication_id']=='41'){	//Estevan Mercury
				$ftp_server = 'ftp.adwitads.com';
				$ftp_username='estevanmercury@adwitads.com';
				$ftp_userpass='ftp@123';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='43'){	//Desert shoppers
				$ftp_server = '65.60.71.83';
				$ftp_username='adwit';
				$ftp_userpass='DisplayAd5';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='47'){		//Imperial valley press
				$ftp_server = '64.167.186.41';
				$ftp_username='adwit';
				$ftp_userpass='!VPr3$$123';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='206'){	//The pilot news
				$publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				//$dataa['design_team'] = $design_team[0];
				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Order Confirmation';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';

				$dataa['subject'] = 'Approved Hi-Res PDF : '.$jname ;
				$dataa['body'] = 'Hi AdRep,<br/><br/>Attached is the approved Hi-Res PDF for Unique Job Name : '.$jname.' with AdwitAds ID : '.$order.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				//Design Team
				$dataa['recipient'] = $this->session->userdata('pcEmail');
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}elseif($order_details[0]['publication_id']=='27'){ //Yuma sun
				$publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				//$dataa['design_team'] = $design_team[0];
				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Approved  Order';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';

				$dataa['subject'] = 'Approved Hi-Res PDF : '.$jname ;
				$dataa['body'] = 'Hi '.$client[0]['first_name'].' '.$client[0]['last_name'].',<br/><br/>Attached is the approved Hi-Res PDF for Unique Job Name : '.$jname.' with AdwitAds ID : '.$order.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				//Design Team
				
				$dataa['recipient'] = 'ads@yumasun.com';
				//$dataa['Cc'] = 'webmaster@adwitads.com';
				
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}else{
				$ftp_server = '115.248.71.109';
				$ftp_username='annexe3';
				$ftp_userpass='adwit@123';
				$folder_name = 'adwitads-test';
			}
			if($ftp_server != 'none'){
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

				$file = $filename;
				$path_parts = pathinfo($file);
				$fname = $order_details[0]['job_no'].'.pdf';
				// upload file
				if (ftp_put($ftp_conn, $folder_name.'/'.$fname, $file, FTP_BINARY)){
					echo "Successfully uploaded $fname.";
			    }else{
					echo "Error uploading $fname .";
				}
				// close connection
				ftp_close($ftp_conn);
			}
		}
	}
	
	public function ftp_mail($dataa) 
	{
	    $config = array();
               $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;
                
	    $this->load->library('email');
	    
		$this->email->initialize($config);
				
		$this->email->from($dataa['from'], $dataa['from_display']);
		
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
				
		$this->email->subject($dataa['subject']); 
				
		$this->email->message($dataa['body']);
				
		$this->email->set_alt_message("Unable to load text!");
				
		$this->email->to($dataa['recipient']);
				
		if(isset($dataa['Cc'])){
			$this->email->cc(array($dataa['Cc']));
        }
        	    
        $this->email->attach($dataa['filename']);
        	    
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function unapprove_order($order = '')
	{
		$order_details = $this->db->get_where('orders',array('id' => $order, 'status' => '7'))->result_array();
		if(isset($order_details[0]['id'])){
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order' ORDER BY `id` DESC LIMIT 1")->row_array();
			if($orders_rev){
				if($orders_rev['approve']=='1'){
					$post = array('approve'=>'0');
					$this->db->where('id', $orders_rev['id']);
					$this->db->update('rev_sold_jobs', $post); 
				}
			}else{
				$post = array('approve'=>'0', 'status'=>'5');
				$this->db->where('id', $order_details[0]['id']);
				$this->db->update('orders', $post);
			}
		}
		redirect('professional_edition/home/dashboard');
	}
	
	public function revision_details($order_id='')
	{
		$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		if($order!='' && isset($order[0]['id']))
		{
			$data['order'] = $order;
			$publication = $this->db->get_where('publications',array('id' => $order[0]['publication_id']))->result_array();
			$data['publication'] = $publication[0];
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			$data['cat_result'] = $cat_result;
			if(($order[0]['status']=='5' || $order[0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
				$data['slug'] = $cat_result[0]['slug'];
				$sourcefilepath = $cat_result[0]['source_path'];
				$data['sourcefilepath'] = $sourcefilepath;
			}
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order_id))->result_array();
			$data['orders_rev'] = $orders_rev;
			$this->load->view('professional_edition/revision_details', $data);
		}
	}
	
	public function additional_att_view($id = 0, $email = false, $data)
	{
		$orders = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($orders[0]['id']))
		{
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$id' ORDER BY `id` DESC LIMIT 1")->row_array();
			if(isset($orders_rev[0]['id'])){
				$path = $orders_rev[0]['file_path'];
			}else{
				$path = $orders[0]['file_path'];
			}
			
			if(!$email){
				$this->load->view('india_client/dashboard');
			}else{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('pcId')))->result_array();
				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				$data['orders'] = $orders;
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				
				$data['from'] = $design_team[0]['email_id'];
				$data['from_display'] = 'Design Team';
				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo2'] = $design_team[0]['email_id'];
				$data['replyTo_display'] = 'Do not reply';
				$data['replyTo_display2'] = 'Reply to';
				$data['subject'] = 'Order:'.$orders[0]['id'];
				$data['attachment'] = $path;
				//Client
				$data['recipient'] = $client[0]['email_id'];
				$data['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				$data['ad_recipient'] = $client[0]['email_cc'];
				$data['ad_recipient_display'] = 'Advertising Director';
				
				$this->csrmail($data);
			}
		}
	}
	
	public function csrmail($data) 
	{
        $config = array();
               $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;
                
	    $this->load->library('email');
	    
		$this->email->initialize($config);
				
		$this->email->from($data['from'], $data['from_display']); 
		
		$this->email->reply_to($data['replyTo2'],$data['replyTo_display2']);
				
		$this->email->subject($data['subject']); 
				
		$this->email->message($this->load->view('additional_att_view',$data, TRUE));
				
		$this->email->set_alt_message("Unable to load text!");
				
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		$this->email->attach($data['attachment'],'file.jpg'); 
		
		$this->email->cc(array($data['ad_recipient']));
		
		$this->email->bcc($data['from']);
			    
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function rev_jobs_mail($dataa) 
	{
       $config = array();
               $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;
                
	    $this->load->library('email');
	    
		$this->email->initialize($config);
				
		$this->email->from($dataa['from'], $dataa['from_display']);
		
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
				
		$this->email->subject($dataa['subject']); 
				
		$this->email->message($dataa['body']);
				
		$this->email->set_alt_message("Unable to load text!");
				
		$this->email->to($dataa['recipient']);
				
		$this->email->cc($dataa['ad_recipient']);
        
        $this->email->bcc($dataa['from']); 
        
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function view_uploaded_files($orderid='')
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$data['order_details'] = $order_details;
		if($order_details){
			$rev_details = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$orderid' ORDER BY `id` DESC")->result_array();
			if($rev_details){
				$file_path = $rev_details[0]['file_path'];
			}else{
				$file_path = $order_details[0]['file_path'];
			}
		
			if($file_path != '0')
			{
				if(is_dir($file_path))
				{
					if($dh = opendir($file_path))
					{
						while(($file = readdir($dh)) !== false) {
							if($file == '.' || $file == '..'){ continue; }
							if($file){ $filename[] = $file; }
							$data['file_names'] = $filename;
						}
						closedir($dh);
					}
				} 
			}
		}
		$this->load->view('professional_edition/order_action',$data);
	}
	
	public function zip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			$SourceFilePath = $_POST['source_path'] ;
			$source_file = $_POST['source_file'];
			$pdf_file = $new_slug.'.pdf';
			
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}//else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
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
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}
	
	public function profile()
	{
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('pcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
		if($adrep_details[0]['team_orders']=='1'){
			$data['orders_count'] = $this->db->get_where('orders',array('publication_id' => $publication[0]['id']))->num_rows();
		}else{
			$data['orders_count'] = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('pcId')))->num_rows();
		}
		
		if($publication[0]['design_team_id']=='0'){
			$data['activate_notification'] = 'inactive';
		}else{
			$design_team = $this->db->get_where('design_teams',array('id' => $publication[0]['design_team_id']))->row_array();
			$data['design_team_code'] = $design_team['code']; 
		}
		
		if($publication[0]['enable_source']=='1'){
			$data['storage_space'] = $this->storage_space();
		}
		$data['adrep_details'] = $adrep_details;
		$data['publication'] = $publication;
		if(isset($_POST['submit_gender'])){
			$this->db->query("Update adreps set gender='".$this->input->post('gender')."' where (id='".$this->session->userdata('pcId')."') ");
			redirect('professional_edition/home/profile');
		}
		if(isset($_POST['submit_phone'])){
			$this->db->query("Update adreps set phone_1='".$this->input->post('phone')."' where (id='".$this->session->userdata('pcId')."') ");
			redirect('professional_edition/home/profile');
		}
		if(isset($_POST['submit_address'])){
			$this->db->query("Update adreps set address='".$this->input->post('address')."' where (id='".$this->session->userdata('pcId')."') ");
			redirect('professional_edition/home/profile');
		}
		if(isset($_POST['submit_pwd']))
		{
			$this->db->query("Update adreps set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('pcEmail')."' or username='".$this->session->userdata('client')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
			if($this->db->affected_rows())
				$data['pwd_success'] = "success";
			else
				$data['invalid_pwd'] = "Invalid";
		}
		if(isset($_POST['img_upload']))
		{
			$uploadDir = "images/adreps/".$this->session->userdata('pcId')."/";
		
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$extension = pathinfo($_FILES['Photo']["name"], PATHINFO_EXTENSION); 
			
			if (in_array($extension, $allowedExts))
			{
				$fileName = $_FILES['Photo']['name'];
				$tmpName  = $_FILES['Photo']['tmp_name'];
				$fileSize = $_FILES['Photo']['size'];
				$fileType = $_FILES['Photo']['type'];
				
				if (@mkdir($uploadDir,0777)){}
				$filePath = $uploadDir . 'profile.png';
				$result = move_uploaded_file($tmpName, $filePath);
				if (!$result) {
					$data['error']= "Error uploading file";
					//exit;
				}
				$data = array('image' => $filePath);
				$this->db->where('id', $this->session->userdata('pcId'));
				$this->db->update('adreps', $data); 
				redirect('professional_edition/home/profile');
			}else{ $data['error']= "Invalid file type";}
		
		}
		$this->load->view('professional_edition/profile',$data);
	}
	
	public function storage_space()
	{	
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('pcId')))->row_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details['publication_id']))->row_array();
		if($adrep_details['team_orders']=='1'){
			$orders = $this->db->get_where('orders',array('publication_id'=>$publication['id'], 'pdf !=' =>'none'))->result_array();
		}else{
			$orders = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('pcId'), 'pdf !=' =>'none'))->result_array();
		}
		
		$total_space = '0'; $d_tot_size = '0'; $s_tot_size = '0'; $p_tot_size = '0';
		foreach($orders as $row_order){ //echo $row_order['id'].' - ';
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row_order['id']))->row_array();
			$downloads = $row_order['file_path'];
			if(isset($cat_result['id'])){ 
				$source = $cat_result['source_path'];
			}
			$pdf = $row_order['pdf'];	
			//Downloads folder
			if(file_exists($downloads)){
				//$d_tot_size = '0';
				$this->load->helper('directory');
				$map = directory_map($downloads.'/');
				if($map){ 
					foreach($map as $row){
						$d_size = '0';
						$d_size = filesize($downloads.'/'.$row);
						$d_tot_size = $d_tot_size + $d_size;
					}
					//echo 'Downloads : '.$d_tot_size;
				}
			}
			clearstatcache();
			//Source file folder
			if(isset($source) && file_exists($source)){ 
				//$s_tot_size = '0';
				$this->load->helper('directory');
				$map_source = directory_map($source.'/');
				$map_doc = directory_map($source.'/Document fonts/');
				$map_link = directory_map($source.'/Links/');
				//Source file
				if($map_source){ 
					foreach($map_source as $row){ 
						$s_size = '0';
						if(!is_array($row)){
							$s_size = filesize($source.'/'.$row);
							$s_tot_size = $s_tot_size + $s_size;
						}
					}
				}
				//Source Document fonts file
				if($map_doc){ 
					foreach($map_doc as $row){ 
						$s_size = '0';
						if(!is_array($row)){
							$s_size = filesize($source.'/Document fonts/'.$row);
							$s_tot_size = $s_tot_size + $s_size;
						}
					}
				}
				//Source Links file
				if($map_link){ 
					foreach($map_link as $row){ 
						$s_size = '0';
						if(!is_array($row)){
							$s_size = filesize($source.'/Links/'.$row);
							$s_tot_size = $s_tot_size + $s_size;
						}
					}
				}
				//echo 'Source : '.$s_tot_size;
			}
			clearstatcache();
			//pdf_uploads folder
			if(file_exists($pdf)){ 
				$p_size = '0';
				$p_size = filesize($pdf); 
				$p_tot_size = $p_tot_size + $p_size;
				//echo "pdf : ".$p_tot_size; 
			}
		} 
		$total_space = $d_tot_size + $s_tot_size + $p_tot_size;
		$total_space = number_format($total_space / 1048576, 2) . ' MB';
		//echo $total_space;
		return $total_space;
	}
	
	public function notification()
	{
		$data['hi'] = 'hello';
		$notifications = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1'")->result_array();
		$pcId = $this->session->userdata('pcId');
		$client = $this->db->get_where('adreps',array('id' => $pcId))->row_array();
		$notification_list = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1' AND (`adrep`='$pcId' OR `publication`='".$client['publication_id']."') ORDER BY `id` DESC")->result_array();
		if(isset($notification_list[0]['id'])){ $data['notification_list'] = $notification_list; }
		$this->load->view('professional_edition/notification', $data);
	}
	
	public function faq()
	{
		$this->load->view('professional_edition/faq');
	}
	
}