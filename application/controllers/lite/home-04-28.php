<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends Lite_Controller {
	
	public function index()
	{
		$data['hi'] = 'hello';
		//credits expiry check
		$this->lite_client_model->expiry_check();
		
		//credits display
		$credits = $this->lite_client_model->check_credits();
		if($credits){ 
			$data['credits'] = $credits; 
		}
		
		//dashboard data
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$num_days = $client[0]['display_orders'];
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$publication_id = $client[0]['publication_id'];
		$today = date('Y-m-d');     
		$pday = date('Y-m-d', strtotime(" -$num_days day"));
		$pyday = date('Y-m-d', strtotime(' -6 day'));
		if($client[0]['team_orders']=='1'){
			$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id'  ORDER BY `id` DESC LIMIT 5;")->result_array();
		}else{
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('lcId')."' ORDER BY `id` DESC LIMIT 5;")->result_array();
		}
		$data['client'] = $client;
		$this->load->view('lite/home',$data);
	}

	public function order_search()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$publication_id = $client[0]['publication_id'];
		if($client[0]['team_orders']=='1' ){
			if(isset($_POST['search'])){ //search
				$tl_orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`id` = '".$_POST['input']."' OR `advertiser_name` LIKE '%".$_POST['input']."%' OR `job_no` LIKE '%".$_POST['input']."%') ;")->result_array();
				if($tl_orders)
				{
					$data['tl_orders'] = $tl_orders;
				}/*elseif($publication[0]['id']=='43' || $publication[0]['id']=='47' || $publication[0]['id']=='13')
				{
					$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$_POST['input']."%' OR `advertiser` LIKE '%".$_POST['input']."%');")->result_array();
					if($preorder){ 
					$data['preorder'] = $preorder; }
					else{ $this->session->set_flashdata('message',"No Orders Found for ".$_POST['input']);
					redirect('lite/home/dashboard'); }
				}*/
			}			
			elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
				 	$adrep_id = $this->session->userdata('lcId');
					$keyword = $_POST['keyword'];
					$tl_orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					if($tl_orders){	$data['tl_orders'] = $tl_orders; }
					/*elseif($publication[0]['id']=='43' || $publication[0]['id']=='47' || $publication[0]['id']=='13')
					{
					$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$keyword."%' OR `advertiser` LIKE '%".$keyword."%');")->result_array();
					if($preorder){ 
						$data['preorder'] = $preorder; }
						else{ 
						$this->session->set_flashdata('message',"No Orders Found for". $_POST['keyword']);
						redirect('lite/home/dashboard'); 
						}
						
					}*/
				}  
			
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' ;")->result_array();
					}else{
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
			}
				
		}else{
			if(isset($_POST['search'])){ //search
					$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('lcId')." AND (`id` = '".$_POST['input']."' OR `advertiser_name` LIKE '%".$_POST['input']."%' OR `job_no` LIKE '%".$_POST['input']."%') ;")->result_array();
					if($orders){
						$data['orders'] = $orders;
					}/*elseif($publication[0]['id']=='43' || $publication[0]['id']=='47'  || $publication[0]['id']=='13')
					{
						$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$_POST['input']."%' OR `advertiser` LIKE '%".$_POST['input']."%');")->result_array();
						if($preorder){ 
						$data['preorder'] = $preorder; }
						else{ 
						$this->session->set_flashdata('message',"No Orders Found for ". $_POST['input']);
						redirect('lite/home/dashboard'); }
					}*/		
			}elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
					$adrep_id = $this->session->userdata('lcId');
					$keyword = $_POST['keyword'];
					$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$adrep_id."' AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%')")->result_array();
					if($orders)
					{
						$data['orders'] = $orders;
					}
				}  
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('lcId')." AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('lcId')." ;")->result_array();
					}else{
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('lcId')." AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
			} 
			
		}
		$this->load->view('lite/dashboard',$data);
	}
	
	public function dashboard() 
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$num_days = $client[0]['display_orders'];
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$publication_id = $client[0]['publication_id'];
		$today = date('Y-m-d');     
		$pday = date('Y-m-d', strtotime(" -$num_days day"));
		$pyday = date('Y-m-d', strtotime(' -6 day'));
		//$data['preorder_count'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$pyday 00:00:00' AND '$today 23:59:59';")->num_rows();
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ORDER BY `id` DESC;")->result_array();										
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('lcId')."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ORDER BY `id` DESC;")->result_array();										
			}
		}else{
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('lcId')."' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}
		}
		$this->load->view('lite/dashboard',$data);
	}

	
	public function order($pick_num = "")
	{
		if($pick_num != ""){
			$order = $this->lite_client_model->pick_up($pick_num);
			if($order){
				 $data['order']= $order[0];
			}else{
				$this->session->set_flashdata('message',$pick_num.' Order not found');
				redirect('lite/home/order');
			}
		}
		$check_credits = $this->lite_client_model->customer_credit_details();
		$data['check_credits']=$check_credits;
		if($check_credits && $check_credits[0]['free_credits'] > '0')
		{
			$min_date = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
			$data['min_date'] = $min_date;
			$max_date = strtotime("+5 day", strtotime($min_date));
			$data['max_date'] = date('Y-m-d', $max_date);
		  	
			$data['lite_credit_date'] = $this->db->get('lite_credit_date')->result_array();
			$data['color_preference'] = $this->db->get('lite_color_preference')->result_array();
			
			if(isset($_POST['submit'])){
				$ad_credits = $this->lite_client_model->credit_calc(); 
				$order_id = $this->lite_client_model->order_insert($ad_credits); //order insert
				if($order_id){
					$this->order_html_form($order_id); //html order form
					if($ad_credits && $ad_credits < $check_credits[0]['free_credits'])
					{
						//send mail
						$data_mail['orders'] = $this->db->query("Select * from `orders` where `id`= '$order_id';")->result_array();
						$this->send_mail($data_mail);
						redirect('lite/home/preorder/'.$order_id); 
					}else{
						$this->session->set_flashdata('message','Insufficient Credit Balance');
						redirect('lite/home/buycredit');
					}
				}else{
					$this->session->set_flashdata('message','Order not placed.. Error..!!');
					redirect('lite/home/order');
				}
			}
			$this->load->view('lite/neworder', $data);
		}else{
			$this->session->set_flashdata('message','Insufficient Credit Balance');
			redirect('lite/home/buycredit');
		}
	}
	
	public function print_ad()
	{
		$check_credits = $this->lite_client_model->check_credits();
		//$data['check_credits']=$check_credits;
		if($check_credits && $check_credits >= '0'){ 
			$data['min'] = date('Y-m-d');
			$data['max'] = date("Y-m-d",strtotime("+30 days"));
			
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
			$data['publication'] = 	$publication[0];
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			$this->form_validation->set_rules('date_needed', 'Date Needed', 'trim');
			$this->form_validation->set_rules('notes', 'Notes', 'trim');
			$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric|greater_than[0]');
			$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric|greater_than[0]');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			$this->form_validation->set_rules('rush', 'Rush', 'trim');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('lite/print_ad',$data);
			}else{
				if(isset($_POST['submit'])){ 
					$ad_credits = $this->lite_client_model->credit_calc(); 
					$order_id = $this->lite_client_model->order_insert($ad_credits); //order insert
					if($order_id){
						//$this->order_html_form($order_id); //html order form
						$this->orders_folder($order_id);//html order form
						$this->view($order_id, true); // mail
						redirect('lite/home/preorder/'.$order_id);//preorder
						/*if($ad_credits && $ad_credits <= $check_credits)
						{
							//send mail
							$this->view($order_id, true); // mail
							redirect('lite/home/preorder/'.$order_id);//preorder
						}else{
							redirect('lite/home/preorder/'.$order_id);//preorder
						}*/
					}else{
						$this->session->set_flashdata('message','Order not placed.. Error..!!');
						redirect('lite/home/print_ad');
					}
				}
			}
		}else{
			$this->session->set_flashdata('message','Insufficient Credit Balance');
			redirect('lite/home/buycredit');
		}
	} 
	
	public function online_ad()
	{
		$check_credits = $this->lite_client_model->check_credits();
		
		if($check_credits && $check_credits >= '0'){ 
			$data['min'] = date('Y-m-d');
			$data['max'] = date("Y-m-d",strtotime("+30 days"));

			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
			$data['publication'] = 	$publication[0];

			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');

			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			$this->form_validation->set_rules('date_needed', 'Date Needed', 'trim');
			$this->form_validation->set_rules('notes', 'Notes', 'trim');
			$this->form_validation->set_rules('maxium_file_size', 'Maximum File Size', 'trim|required');
			$this->form_validation->set_rules('ad_format', 'Ad Format', 'trim|required');
			$this->form_validation->set_rules('web_ad_type', 'Web Ad Type', 'trim|required');
			$this->form_validation->set_rules('pixel_size', 'Pixel Size', 'trim|required');
			$this->form_validation->set_rules('custom_width', 'Custom Width', 'trim');
			$this->form_validation->set_rules('custom_height', 'Custom Height', 'trim');
			$this->form_validation->set_rules('rush', 'Rush', 'trim');
		
			if ($this->form_validation->run() == FALSE){
				$this->load->view('lite/online_ad',$data);
			}else{
				if(isset($_POST['submit'])){ 
					$ad_credits = $this->lite_client_model->online_credit_calc(); 
					$order_id = $this->lite_client_model->online_order_insert($ad_credits); //order insert
					if($order_id){
						$this->orders_folder($order_id);//html order form
						$this->view($order_id, true); // mail
						redirect('lite/home/preorder/'.$order_id);//preorder
					}else{
						$this->session->set_flashdata('message','Order not placed.. Error..!!');
						redirect('lite/home/online_ad');
					}
				}
			}
		}else{
			$this->session->set_flashdata('message','Insufficient Credit Balance');
			redirect('lite/home/buycredit');
		}
	} 

	
	/*public function print_ads()
	{
		$check_credits = $this->lite_client_model->customer_credit_details();
		$data['check_credits']=$check_credits;
		if($check_credits && $check_credits[0]['free_credits'] > '0'){ 
			$data['min'] = date('Y-m-d');
			$data['max'] = date("Y-m-d",strtotime("+30 days"));
			
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
			$data['publication'] = 	$publication[0];
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			$this->form_validation->set_rules('date_needed', 'Date Needed', 'trim');
			$this->form_validation->set_rules('notes', 'Notes', 'trim');
			$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric|greater_than[0]');
			$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric|greater_than[0]');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			$this->form_validation->set_rules('rush', 'Rush', 'trim');
			
			if ($this->form_validation->run() == FALSE) 
			{
				$this->load->view('lite/print_ad',$data);
			}else{
				if(isset($_POST['submit'])){ //echo 'date_needed : '.$_POST['date_needed'];
					$ad_credits = $this->lite_client_model->credit_calc(); 
					$order_id = $this->lite_client_model->order_insert($ad_credits); //order insert
					if($order_id){
						//$this->order_html_form($order_id); //html order form
						$this->orders_folder($order_id);//html order form
						if($ad_credits && $ad_credits < $check_credits[0]['free_credits'])
						{
							//send mail
							$this->view($order_id, true); // mail
							$data['order_credit'] = $this->db->get_where('orders', array('id' => $order_id))->row_array();
							//$this->load->view('lite/print_ad',$data);
							redirect('lite/home/preorder/'.$order_id);//preorder
						}else{
							$this->session->set_flashdata('message','Insufficient Credit Balance');
							redirect('lite/home/buycredit');
						}
					}else{
						$this->session->set_flashdata('message','Order not placed.. Error..!!');
						redirect('lite/home/print_ads');
					}
				}
			}
		}else{
			$this->session->set_flashdata('message','Insufficient Credit Balance');
			redirect('lite/home/buycredit');
		}
		
	} */
	/*public function online_ad()
	{
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication[0];	
		
		if(isset($_POST['submit']))
		{
			
			 if(empty($_POST['rush'])){ $_POST['rush']='0'; }
			$advertiser = preg_replace('/[^A-Za-z0-9]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9]/','',$_POST['job_no']);
			
			$data = array( 
			'adrep_id' =>$this->session->userdata('lcId'),
			'publication_id' => $publication[0]['id'],
			'group_id' => $publication[0]['group_id'],
			'help_desk' => $publication[0]['help_desk'],
			'order_type_id' => '1',
			//'advertiser_name' => $_POST['advertiser_name'],
			//'job_no' => $_POST['job_no'],
			'advertiser_name' => $advertiser,
			'job_no' => $job_number,
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
			if($publication[0]['id']=='43' || $publication[0]['id']=='13'){ if(empty($_POST['rush'])) $_POST['rush']='0';  }		
			
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
			
			 if($orderid){
				$this->view($orderid, true);
				$this->orders_folder($orderid);
				redirect('lite/home/order_success/'.$orderid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("lite/home/online_ad");
			} 
		}
		$this->load->view('lite/online_ad',$data);
	}
	*/
	
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
			//ftp sourceFile path
			if($cat_result && $cat_result[0]['ftp_source_path']!='none'){ 
				$data['ftp_source_path'] = $cat_result[0]['ftp_source_path']; 
				if($orders_rev){
					$data['last_orders_rev'] =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
				}
			}
			$this->load->view('lite/revision_details', $data);
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
		
		//$data['order'] = $this->db->get_where('orders',array('id' => $id))->result_array();
		
		//Uploading files
		if (!empty($_FILES)) {
				//$path = $data['order'][0]['file_path'];
				if (@mkdir($path,0777)){}
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$targetPath = getcwd().'/'.$path.'/';
					$targetFile = $targetPath . $fileName ;
					
					if(!move_uploaded_file($tempFile, $targetFile)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					}
					else
					{ echo "success";}
		}
		
		if(isset($_POST['add_submit']))
		{
			if($path != '0')
			{
				if(is_dir($path))
				{
					if($dh = opendir($path))
					{
						while(($file = readdir($dh)) !== false) {
						if($file == '.' || $file == '..'){
						continue; }
						$datecheck = date('F d Y');
						if($file)
						{
							$lastmodified = date("F d Y",filemtime(utf8_decode($path."/".$file)));
							if($lastmodified == $datecheck)
							{ $filename[] = $file;}
						}	}
						closedir($dh);
					}
					$data['filename'] = $filename;
				} 
			}
			$this->additional_att_view($id, true,$data);
		}
		}
		redirect('lite/home/dashboard');
	
	}
	
	public function additional_att_view($id = 0, $email = false,$data)
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
			if(!$email)
			{
				$this->load->view('lite/dashboard');
			}else{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				$data['orders'] = $this->db->get_where('orders',array('id' => $id))->result_array();
				//$data['adrep'] = $this->db->query("Select * from adreps where id='".$data['orders'][0]['adrep_id']."'")->result_array();
				
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				$data['from'] = $design_team[0]['email_id'];
				$data['from_display'] = 'Design Team';
				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo2'] = $design_team[0]['email_id'];
				$data['replyTo_display'] = 'Do not reply';
				$data['replyTo_display2'] = 'Reply to';
				$data['subject'] = 'Order:'.$data['orders'][0]['id'];
				$data['attachment'] = $path;
				//Client
				$data['recipient'] = $client[0]['email_id'];
				$data['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				$data['ad_recipient'] = $client[0]['email_cc'];
				$data['ad_recipient_display'] = 'Advertising Director';
				
				$this->csrmail($data);
				//Design Team
				//$this->send_mail($data);

			}
		}
	}
	
	public function csrmail($data) 
	{
       $this->load->library('MyMailer');
       $mail = new PHPMailer();
       $mail->SetFrom($data['from'], $data['from_display']);  
       $mail->AddReplyTo($data['replyTo2'],$data['replyTo_display2']);
       $mail->Subject    = $data['subject'];   
       $mail->Body      = $this->load->view('additional_att_view',$data, TRUE);
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($data['recipient'], $data['recipient_display']);
	   $mail->AddAttachment($data['attachment'],'file.jpg');
	   $mail->Addcc($data['ad_recipient'], $data['ad_recipient_display']);
	   $mail->Addbcc($data['from'], $data['from_display']);
	   
       if(!$mail->Send())
		return false;
	   else
		return true;
	}
		
	public function alpha_dash_space($str)
	{
		if( preg_match('/[^a-z \0-9]/i', $str)){
			$this->form_validation->set_message('alpha_dash_space', 'The job_no field is required & must be alphanumeric only.');
			return FALSE;
		}else{
			return TRUE;
		}//return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}
	
	public function view($id = 0, $email = false)
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($order[0]['id']))
		{
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
			$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();

			$data = array();
			$data['client'] = $client[0];
			$data['order'] = $order[0];
			$data['publications'] = $publications[0];

			if(!$email)
			{
				$this->load->view('lite/dashboard');
			}else
			{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
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
				
				if($data['order']['rush'] == '1')
				{
					$data['subject'] = 'AdwitAds Order #'.$data['order']['id'].' - Rush Ad';
				}
				else{
					$data['subject'] = 'AdwitAds Order #'.$data['order']['id'];
				
				}
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
        
		$this->load->library('email');
		$this->email->set_mailtype("html");
        //$this->load->library('email');
		//$this->email->initialize($config);
 		$this->email->from($data['from'], $data['from_display']);
		$this->email->reply_to($data['replyTo2'],$data['replyTo_display2']);
		$this->email->subject($data['subject']);  
		$this->email->message($this->load->view('lite-emailer/newad_placed_notification_emailer_lite',$data, TRUE));
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
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($order[0]['id'])){
			//$order = $this->db->get_where('orders',array('id' => $id))->result_array();
			$data['order'] = $order;
			$data['order_type'] = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();			$data['publications'] = $publication[0];
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $order[0]['job_no']);
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
	
	/*public function send_mail($data_mail)
	{ 
	    	$from_email = 'unnati115@gmail.com'; 
			$to_email ='unnati115@gmail.com'; 
   
			//Load email library 
			$config = Array( 'mailtype' => 'html' );
			$this->load->library('email', $config);
			
			$this->email->from($from_email,'Unnathi'); 
			$this->email->to($to_email);
			$this->email->subject('Adwit lite');
			$this->email->message($this->load->view('lite/html_order_view',$data_mail,TRUE));
			
			if($this->email->send()){
				return true;
			}else{
				return false;
			}
	}*/
	
	public function preorder($order_id='')
	{
		if($order_id!=''){
			$order_check = $this->lite_client_model->order_check_preorder($order_id);
			if(isset($order_check[0]['id'])){
				$check_credits = $this->lite_client_model->check_credits();
				if($check_credits && $check_credits >= $order_check[0]['credits']){
					//decline
					if(isset($_POST['decline'])){
						redirect('lite/home/dashboard');
					}
					//proceed
					if(isset($_POST['proceed'])){
						//orders table update
						$post_order = array('status' => '1');
						$this->db->where('id', $order_id);
						$this->db->update('orders', $post_order); 
						//credits update
						$post = array('uid' => $this->session->userdata('lcId'), 'order_id' => $order_id, 'credits_credited' => $order_check[0]['credits'], 'purpose'=>'3');
						$this->db->insert('lite_mycredits_history', $post);
								
						redirect('lite/home/order_success/'.$order_id);	
						//redirect('lite/home/order_assets/'.$order_id);
					}
					//$data['check_credits'] = $check_credits;
					//$data['order_check'] = $order_check[0];
					$data['order_id'] = $order_id;
					//$this->load->view('lite/preorder', $data);
				}else{
					$data['insufficient_bal'] = 'Insufficient credits balance';
					//$data['check_credits'] = $check_credits;
					//$data['order_check'] = $order_check[0];
					//$this->load->view('lite/preorder', $data);
				}
				$data['check_credits'] = $check_credits;
				$data['order_check'] = $order_check[0];
				$this->load->view('lite/preorder', $data);
			}
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
					redirect('lite/home/order_success/'.$orderid);
				}else{ $data['file_sucess']="file sucessful!!"; }
			}
			
		}else{
			$this->orders_folder( $orderid ); //if download folder doesnt exists
			redirect('lite/home/order_success/'.$orderid);
		}
		$this->load->view('lite/order_success',$data);
	}
	
	public function order_assets($order_id='')
	{
		
		$order_check = $this->lite_client_model->order_check($order_id);
		if($order_id!='' && $order_check){
			$data['order_id'] = $order_id;
			
			if(isset($_POST['order_submit'])){
				$this->session->set_flashdata('message',
				'<div class="alert alert-danger  padding-10">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<span>Order Placed Sucessfully with ID :'.$order_id.'</span>
				</div>');
				redirect('lite/home/dashboard');
			}
			if (!empty($_FILES)) {
				if($order_check[0]['file_path']!='none' && file_exists($order_check[0]['file_path'])){
					$path = $order_check[0]['file_path'];
				}else{
					$id = $order_check[0]['id'];
					$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $order_check[0]['job_no']);
					$path = "downloads/".$id."-".$jname;
					if (@mkdir($path,0777)){}
					$data_post = array( 'file_path' => $path );
					$this->db->where('id', $order_id);
					$this->db->update('orders', $data_post);
				}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$path.'/';
				$targetFile = $targetPath . $fileName ;
				if(!move_uploaded_file($tempFile, $targetFile)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					redirect('lite/home/order_assets/'.$order_id);
				}
			}
			if($order_check[0]['file_path']!='none' && file_exists($order_check[0]['file_path'])){
				if($dh = opendir($order_check[0]['file_path'])){
					while(($file = readdir($dh)) !== false) {
						if($file == '.' || $file == '..'){ continue; }
						if($file){ $filename[] = $file; }
						$data['file_names'] = $filename;
					}
					closedir($dh);
				}
			}
			$this->load->view('lite/order_assets', $data);
		}else{ 
			echo "error"; 
		}
	}
	
	public function order_html_form($order_id)
	{
		if($order_id!=''){
			//$path = 'order_form/'.$order_id;	
			$orders = $this->db->query("Select * from `orders` where `id`= '$order_id';")->result_array();
			$data['orders'] = $orders;
			$id = $orders[0]['id'];
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $orders[0]['job_no']);
			$path = "downloads/".$id."-".$jname; //path specification
			
			if (@mkdir($path,0777)){}
			//to store the form
			$myFile = $path."/".$jname.".html";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = $this->load->view('lite/html_order_view',$data,TRUE);
			fwrite($fh, $stringData);
			fclose($fh);
				//save path
			$post = array('file_path' => $path);
			$this->db->where('id', $id);
			$this->db->update('orders', $post);
		}
	}
	
	/*public function order_action($action = '', $orderid = 0)
	{
		if($orderid != 0){
			if($action == 'view' ){ $this->order_view($orderid); }
			if($action == 'attachments' ){ $this->order_assets($orderid); }
		}
	}*/
	
	public function order_action($action = '', $orderid = 0, $pickup='')
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$action_id = $this->db->query("SELECT * FROM `adrep_actions` WHERE `action` = '$action'")->result_array();
				
		if(isset($order_details[0]['id']) && isset($action_id[0]['id'])){
			$data['orderid'] = $orderid;
			$data['order_details'] = $order_details;
			$data['action_id'] = $action_id[0]['id']; $data['action'] = $action_id[0]['action'];
			//$data['pickup'] = $pickup;
			
			if($pickup==''){
				if($order_details[0]['order_type_id'] == '1')
					{ $data['pickup'] = 'online'; }
					elseif($order_details[0]['order_type_id'] == '2')
					{ $data['pickup'] = 'print'; }
			}else{ 
				$data['pickup'] = $pickup; 
			}
			
				
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
						redirect('lite/home/dashboard');
					}
				}
			}
			
			//pickup
			if($action == 'pickup' && isset($_POST['print_pickup_submit'])){
				$this->order_pickup($orderid);
			}

			if($action == 'pickup' && isset($_POST['web_pickup_submit'])){
				$this->order_pickup($orderid);
			}
			
			$this->load->view('lite/order_action',$data);
		}
		
	}
	
	public function order_pickup($orderid)
	{
		$check_credits = $this->lite_client_model->check_credits();
		$data['check_credits']=$check_credits;
		if($check_credits && $check_credits >= '0'){
			if(isset($_POST['print_pickup_submit'])){	//print ads
				$ad_credits = $this->lite_client_model->credit_calc(); 
				$order_id = $this->lite_client_model->pickup_order_insert($ad_credits, $orderid); //order insert
				if($order_id){
					$this->orders_folder($order_id);//html order form
					//if($ad_credits && $ad_credits < $check_credits[0]['free_credits']){
						$this->view($order_id, true); // mail
						redirect('lite/home/preorder/'.$order_id);//preorder
					/*}else{
						$this->session->set_flashdata('message','Insufficient Credit Balance');
						redirect('lite/home/buycredit');
					}*/
				}else{
					$this->session->set_flashdata('message','Order not placed.. Error..!!');
					redirect('lite/home/dashboard');
				}
			}
			if(isset($_POST['web_pickup_submit'])){	//web ads
				$ad_credits = $this->lite_client_model->online_credit_calc(); 
				$order_id = $this->lite_client_model->pickup_online_order_insert($ad_credits, $orderid); //order insert
				if($order_id){
					//$this->order_html_form($order_id); //html order form
					$this->orders_folder($order_id);//html order form
					$this->view($order_id, true); // mail
						
					redirect('lite/home/preorder/'.$order_id);//preorder
				}else{
					$this->session->set_flashdata('message','Order not placed.. Error..!!');
					redirect('lite/home/dashboard');
				}
			}
		}else{
			$this->session->set_flashdata('message','Insufficient Credit Balance');
			redirect('lite/home/buycredit');
		}
	}
	/*
	public function order_pickup($orderid)
	{
		$check_credits = $this->lite_client_model->customer_credit_details();
		$data['check_credits']=$check_credits;
		if($check_credits && $check_credits[0]['free_credits'] > '0'){
			if(isset($_POST['print_pickup_submit']))
			{
				$ad_credits = $this->lite_client_model->credit_calc(); 
				$order_id = $this->lite_client_model->pickup_order_insert($ad_credits, $orderid); //order insert
				
				if($order_id){
					//$this->order_html_form($order_id); //html order form
					$this->orders_folder($order_id);//html order form
					if($ad_credits && $ad_credits < $check_credits[0]['free_credits'])
					{
						$this->view($order_id, true); // mail
						$data['order_credit'] = $this->db->get_where('orders', array('id' => $order_id))->row_array();
						$order_details = $this->db->get_where('orders',array('id' => $order_id))->result_array();
						$action_id = $this->db->query("SELECT * FROM `adrep_actions` WHERE `action` = 'pickup'")->result_array();
						$data['order_details'] = $order_details;
						$data['action_id'] = $action_id[0]['id']; $data['action'] = $action_id[0]['action'];
						$data['orderid'] = $order_id;
						
						//$this->load->view('lite/order_action',$data);
					}else{
						$this->session->set_flashdata('message','Insufficient Credit Balance');
						redirect('lite/home/buycredit');
					}
				}else{
					$this->session->set_flashdata('message','Order not placed.. Error..!!');
					redirect('lite/home/dashboard');
				}
			}
		}else{
			$this->session->set_flashdata('message','Insufficient Credit Balance');
			redirect('lite/home/buycredit');
		}
	}
	public function order_pickup_web($orderid)
	{
		if(isset($_POST['web_pickup_submit']))
		{
			$adrep = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
			
			
			$advertiser = preg_replace('/[^A-Za-z0-9]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9]/','',$_POST['job_no']);
			
			 $order_details = array(
				'adrep_id' => $this->session->userdata('lcId'),
				'publication_id' => $adrep[0]['publication_id'],
				'help_desk' => $publication[0]['help_desk'],
				'group_id' => $publication[0]['group_id'],
				'order_type_id' =>  '1', 
				'advertiser_name' => $advertiser,
				'job_no' => $job_number,
				'maxium_file_size' => $_POST['maximum_file_size'],	
				'copy_content_description' => $_POST['copy_content_description'],
				'ad_format' => $_POST['ad_format'],
				'web_ad_type' => $_POST['web_ad_type'],
				'pixel_size' => $_POST['pixel_size'],
				'custom_width' => $_POST['custom_width'],
				'custom_height' => $_POST['custom_height'],
				'notes' => $_POST['notes'],
				'pickup_adno' => $orderid,
				'status' => '1',
			); 
			
			$this->db->insert('orders', $order_details);
			$pickupid = $this->db->insert_id();
			if($pickupid){
				$this->view($pickupid, true);
				$this->orders_folder($pickupid);
				redirect('lite/home/order_success/'.$pickupid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("lite/home/place_order");
			}
		}
		
	}
	*/
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
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			
			
			$rev_data = array(
				'order_id'=>$orderid,
				'order_no' => $_POST['job_slug'],
				'adrep'=>$this->session->userdata('lcId'),
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
					$dataa['body'] = $this->load->view('lite-emailer/revad_placed_notification_emailer_lite',$data, TRUE);
					$dataa['ad_recipient'] = $client[0]['email_cc'];
					$dataa['ad_recipient_display'] = 'Advertising Director';
				
					//Client
					$dataa['recipient'] = $this->session->userdata('lcEmail');
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$this->rev_jobs_mail($dataa);
					
					return $rev_id;
					}else{
				$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Revision Not Submitted : '.$orderid.'-'.$this->db->_error_message().' !! </button>');
				redirect('lite/home/dashboard');
			}
		}
	}
	
	public function rev_jobs_mail($dataa) 
	{
		$this->load->library('email'); 
		$this->email->set_mailtype("html"); 
		$this->email->from($dataa['from'], $dataa['from_display']); 
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		$this->email->subject($dataa['subject']);
		$this->email->message($dataa['body']);
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
	   
	    if(isset($dataa['ad_recipient'])){ $this->email->cc($dataa['ad_recipient'], $dataa['ad_recipient_display']); }
	    $this->email->bcc($dataa['from'], $dataa['from_display']);
		
		if(!$this->email->send())
               return false;
               else
               return true; 
		
	}
	
	/*
	public function upload()
	{
        if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $targetPath = getcwd() . '/doc_files/';
        $targetFile = $targetPath . $fileName ;
        move_uploaded_file($tempFile, $targetFile);
		
        // if you want to save in db,where here
        // with out model just for example
        // $this->load->database(); // load database
        // $this->db->insert('file_table',array('file_name' => $fileName));
        }
		 $this->load->view('lite/order_assets');
    }
	*/
	
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
								if($file == '.' || $file == '..'){
								continue; }
								if($file)
								{
								$filename[] = $file;}
								$data['file_names'] = $filename;
								}
								closedir($dh);
							}
						} 
					}
			}
			$this->load->view('lite/order_action',$data);
			
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
	
	public function delete_file()
	{
		if(isset($_POST['submit'])){
			$fname = $_POST['file_name'];
			$order_id = $_POST['order_id'];
			$order = $this->lite_client_model->order_check($order_id);
			if(isset($order[0]['id']) && file_exists($order[0]['file_path'])){
				$path = $order[0]['file_path'].'/'.$fname;
				if(file_exists($path)) unlink($path);
			}
		}
		redirect('lite/home/order_assets/'.$order_id);
	}	
	
	public function order_view($id='')
	{
		if($id!=''){
			$orders = $this->lite_client_model->view_check($id);
			if($orders){
				$data['orders'] = $orders;
				$path = $orders[0]['file_path'];
				$this->load->helper('directory');
				$map = directory_map($path);
				if($map){ $data['map']=$map; }
				$this->load->view('lite/order_view',$data);
			}
		}
	}
	
	public function buycredit()
	{
		/*if(isset($_POST['buynow'])){
			$lite_mycredits_history = $this->lite_client_model->assign_paid_credits();
			if($lite_mycredits_history){
				$this->session->set_flashdata('message','Paid Credits Credited..!!');
				redirect('lite/home/buycredit');
			}
		}*/
		$data['lite_package']= $this->lite_client_model->customer_buy_details();
		$data['price_per_credit']= $this->lite_client_model->price_per_credit();
		$this->load->view('lite/buycredit',$data);
	}

    public function mycredits()
	{
		$uid = $this->session->userdata('lcId');
		$data['balance_credits'] = $this->lite_client_model->check_credits();
		$free_credits = $this->db->query("SELECT * FROM `lite_credits_added` WHERE `uid` = '$uid' AND `credits_type`='1' AND `is_active` = '1'")->row_array();
		$data['free_credits_expire'] = $free_credits['expiry'];
		$this->load->view('lite/mycredits', $data);
	}
	
	public function freecredits()
	{
		$data['hi']="hello";
		$cust_free = $this->lite_client_model->lite_free_credits();
		if($cust_free){ $data['cust_free'] = $cust_free; }
		$this->load->view('lite/mycredits',$data);
	}
	
	public function invite_friends()
	{
		if(isset($_POST['invite'])){
			$emailId = $_POST['email'];
			$data = array('adrep_id' => $this->session->userdata('lcId'), 'email' => $emailId);
			$this->db->insert('lite_invite_friends',$data);
			$id =  $this->db->insert_id();
			if($id){
				//send mail 
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->row_array();
				//$publication = $this->db->query("Select * from publications where id='".$client['publication_id']."'")->row_array();
				//$design_team = $this->db->query("Select * from design_teams where id='".$publication['design_team_id']."'")->row_array();
			
				$dataa['from'] = 'donotreply@adwitads.com';
				$dataa['from_display'] = $client['first_name'].''.$client['last_name'];
				$dataa['replyTo'] = 'donotreply@adwitads.com';
				$dataa['replyTo_display'] = 'do not reply';
				$dataa['subject'] = 'Refer a friend' ;
				$dataa['body'] = 'Refer a friend';
						
				//client
				$dataa['recipient'] = $emailId;
				$dataa['recipient_display'] = '';
				
				$this->test_mail($dataa); 
			}
			redirect('lite/home/mycredits');
		}
	}
	
	/*public function date()
	{
		$data['hi']="hello";
		$cust_date = $this->lite_client_model->lite_date();
		if($cust_date){$data['cust_date']=$cust_date;}
		$this->load->view('lite/mycredits',$data);
	}*/
	
	public function search_box()
	{
		if(isset($_POST['search'])&& !empty($_POST['id'])){
			$id = $_POST['id'];
			$order = $this->lite_client_model->search_details();
			if(isset($order[0]['id'])){
				redirect('lite/home/dashboard/0/'.$order[0]['id']);
			}else{
				$this->session->set_flashdata('srch_message','<button type="button" class="form-control btn  btn-danger">No Details Found For :'.$id.'</button>');
				redirect('lite/home/dashboard');
			}
		} 
	}
  
	public function advance_search()
	{
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$this->lite_client_model->advance_details();
			$orders = $this->lite_client_model->advance_details();
			if($orders){
				$data['orders'] = $orders;
				$data['date'] =  date("Y-m-d",strtotime($orders[0]['created_on']));
				$this->load->view('lite/dashboard',$data);
			}else{
				$this->session->set_flashdata('srch_message','<button type="button" class="form-control btn  btn-danger">No Details Found For : '.$id.'</button>');
				redirect('lite/home/dashboard');
			}
		}
	}
	 
	public function que_ans($order_id='')
	{
		 if(isset($_POST['submit']))
		 { 
			$timestamp = date('Y-m-d H:i:s');
			$this->lite_client_model->que_details($order_id);
		 }
		 redirect('lite/home/dashboard');
	}
	
	public function revision($order_id='')
	{
		if(isset($_POST['submit']))
		{
			$this->lite_client_model->rev_details($order_id);
		}
		if (!empty($_FILES)) {
			$path = 'rev_files/'.$order_id;
			if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$path.'/';
				$targetFile = $targetPath . $fileName ;
			if(!move_uploaded_file($tempFile, $targetFile)){
				redirect('lite/home/revision/'.$order_id);
			}
		}	
		$orders = $this->db->query("Select * from `orders` where `id`= '".$order_id."';")->result_array();
		$data['orders'] = $orders;
		
		$lite_orders = $this->db->query("Select * from `lite_orders` where `id`= '".$order_id."';")->result_array();
		//$data['color_preference'] = $this->db->get_where('lite_color_preference',array('id' => $lite_orders[0]['color_preference']))->result_array();
		$path = $orders[0]['file_path'];
		$this->load->helper('directory');
		$map = directory_map($path);
		if($map){ $data['map']=$map; }
		
		$this->load->view("lite/rev_view",$data);
	}
	
	public function search()
	{
		if(isset($_POST['search'])&& !empty($_POST['id'])){
			
			$lite_orders = $this->lite_client_model->search_view();
			if($lite_orders){
				redirect('lite/home/order_view/'.$id);
			}else{
				$this->session->set_flashdata('srch_message','<button type="button" class="form-control btn  btn-danger">No Details Found For : '.$id.'</button>');
				redirect('lite/home/dashboard');
			}
		} 
	}
	/*
	public function add_wishlist($id='')
	{ 
		if($id!=''){
			$user_id = $this->lite_client_model->check_login(); 
			if($user_id!=false)
			{
				if($this->lite_client_model->check_list($id, $user_id)==false){
					$this->lite_client_model->addToWishlist($id, $user_id);	
				}else{ echo '<b>Already Added To Wishlist!!</b>'; }
			}else{
				echo "<b>Please Login</b>";
			}
		}
	}
	*/
	
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
				$post_cancel = array('adrep' => $this->session->userdata('lcId'), 'Atimestamp' => $timestamp);
				$this->db->where('id', $orders_cancel[0]['id']);
				$this->db->update('orders_cancel', $post_cancel);
			}else{
				//if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/Chicago');}
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('order_id' => $order_id, 'adrep' => $this->session->userdata('lcId'), 'Atimestamp' => $timestamp);
				$this->db->insert('orders_cancel', $post_cancel);
			}
			//credits update
			$post = array('uid' => $this->session->userdata('lcId'), 'order_id' => $order_id, 'credits_debited' => $order[0]['credits'], 'purpose'=>'5');
			$this->db->insert('lite_mycredits_history', $post);
						
			$this->session->set_flashdata("message","Order Cancellation for $order_id Submitted!!");
			redirect('lite/home/dashboard');
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
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('lcId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//send mail 
					$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
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
						$dataa['recipient'] = $this->session->userdata('lcEmail');
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					
						//Cc
						$dataa['cc_recipient'] = $client[0]['email_cc'];
						
						//Design team 
						 
						$dataa['design_recipient'] = $design_team[0]['email_id'];
						$dataa['design_recipient_display'] = 'Design Team';
						$this->test_mail($dataa); 
					} 
					redirect('lite/home/dashboard');
				}
	   
				$data['question'] = $question[0];//cat_result 
				$this->load->view('lite/ad_answer', $data);
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
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('lcId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//send mail 
					 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
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
						$dataa['recipient'] = $this->session->userdata('lcEmail');
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					
						//Cc
						$dataa['cc_recipient'] = $client[0]['email_cc'];
						
						
						
						//Design team	
						
						$dataa['design_recipient'] = $design_team[0]['email_id'];
						$dataa['design_recipient_display'] = 'Design Team';
						$this->test_mail($dataa); 
					} 
					redirect('lite/home/dashboard');
				}
				$data['rev_sold_jobs'] = $rev_order; //revision
		
				$data['question'] = $question[0];
				$this->load->view('lite/ad_answer', $data);
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
				$post_cancel = array('adrep' => $this->session->userdata('lcId'), 'Rreason' => $_POST['reason'], 'Atimestamp' => $timestamp);
				$this->db->where('id', $_POST['id']);
				$this->db->update('orders_cancel', $post_cancel);
				
				//send mail
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
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
				redirect('lite/home/dashboard');
			}else{
				$data['orders_cancel'] = $this->db->get_where('orders_cancel',array('order_id' => $order_id))->result_array();
				$data['order'] = $order[0];
			}
			
			$this->load->view('lite/reject_v2',$data);
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
	   
	    if(isset($dataa['cc_recipient'])){ $this->email->cc($dataa['cc_recipient']); }
	    if(isset($dataa['design_recipient'])){ $this->email->bcc($dataa['design_recipient'], $dataa['design_recipient_display']); }
		if(isset($dataa['attachment'])){ $this->email->attach($dataa['attachment']); }
		
		if(!$this->email->send())
               return false;
               else
               return true; 
		
	}
	
	public function jRate($order='')
	{
		echo 'Approve not in use';
	}
		
	public function unapprove_order($order = '')
	{
		echo 'Unapprove Order Not in Use';
	}
		
	public function profile()
	{
		
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('lcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
		$design_team = $this->db->get_where('design_teams',array('id'=>$publication[0]['design_team_id']))->result_array();
		if($adrep_details[0]['team_orders']=='1'){
			$data['orders_count'] = $this->db->get_where('orders',array('publication_id' => $publication[0]['id']))->num_rows();
		}else{
			$data['orders_count'] = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('lcId')))->num_rows();
		}
		
		if($publication[0]['enable_source']=='1'){
			$data['storage_space'] = $this->storage_space();
		}
		
		$data['adrep_details'] = $adrep_details;
		$data['publication'] = $publication;
		$data['design_team'] = $design_team;
		
		if(isset($_POST['gender_submit']))
		{
			$this->db->query("Update adreps set gender='".$this->input->post('gender')."' where (id='".$this->session->userdata('lcId')."') ");
			redirect('lite/home/profile');
		}
		if(isset($_POST['submit_phone']))
		{
			$this->db->query("Update adreps set phone_1='".$this->input->post('phone')."' where (id='".$this->session->userdata('lcId')."') ");
			redirect('lite/home/profile');
		}
		
		if(isset($_POST['address_submit']))
		{
			$this->db->query("Update adreps set address='".$this->input->post('address')."' where (id='".$this->session->userdata('lcId')."') ");
			redirect('lite/home/profile');
		}
		
		if(isset($_POST['submit_pwd']))
		{
			$this->db->query("Update adreps set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('lcEmail')."' or username='".$this->session->userdata('lite_client')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
			if($this->db->affected_rows())
				$data['pwd_success'] = "success";
			else
				$data['invalid_pwd'] = "Invalid";
		}
		if(isset($_POST['img_upload']))
		{
			$uploadDir = "images/adreps/".$this->session->userdata('lcId')."/";
		
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES['Photo']["name"]);
			$extension = end($temp);
			if ((($_FILES['Photo']['type'] == "image/gif")
			|| ($_FILES['Photo']['type'] == "image/jpeg")
			|| ($_FILES['Photo']['type'] == "image/jpg")
			|| ($_FILES['Photo']['type'] == "image/pjpeg")
			|| ($_FILES['Photo']['type'] == "image/x-png")
			|| ($_FILES['Photo']['type'] == "image/png"))
			&& ($_FILES['Photo']['size'] < 32400)
			&& in_array($extension, $allowedExts))
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
					exit;
				}
				$data = array('image' => $filePath);
				$this->db->where('id', $this->session->userdata('lcId'));
				$this->db->update('adreps', $data); 
				redirect('lite/home/profile');
				}else{ $data['error']= "Invalid file type";}
		
		}
		$this->load->view('lite/profile',$data);
	}
	
	public function storage_space()
	{	
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('lcId')))->row_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details['publication_id']))->row_array();
		if($adrep_details['team_orders']=='1'){
			$orders = $this->db->get_where('orders',array('publication_id'=>$publication['id'], 'pdf !=' =>'none'))->result_array();
		}else{
			$orders = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('lcId'), 'pdf !=' =>'none'))->result_array();
		}
		//$orders = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('lcId'), 'pdf !=' =>'none'))->result_array();
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
	
	public function change_password()
	{
		if($this->input->post('new_password')!= $this->input->post('confirm_password')){
			$this->session->set_flashdata('pwd_message','<p style="color:#FCA13F;">Confirm Password doesnt match the New Password!!</p>');
			redirect('lite/home/profile');
		}else{
			$this->lite_client_model->change_password();
		}
	}
	
	public function shutdown()
	{
		$this->session->sess_destroy();
		redirect('home/index');
	}

	public function help()
	{
		$this->load->view('lite/help');
	}
	
	public function privacy_policy()
	{
		$this->load->view('lite/privacy_policy');
	}
	
	public function terms()
	{
		$this->load->view('lite/terms');
	}
	
	public function about_us()
	{
		$this->load->view('lite/about_us');
	}
	
	public function contact_us()
	{
		$this->load->view('lite/contact_us');
	}
	
	public function site_map()
	{
		$this->load->view('lite/site_map');
	}
	
	public function invoice()
	{
		$this->load->view('lite/invoice');
	}
	
	/*public function dragdrop()
	{
		
			$ftp_server = 'ftps1a4l1.adwitads.com';
			$ftp_user_name='metroaod';
			$ftp_user_pass='adwit@123';
		
		$destination_file = 'pdf-uploads';
		
		$source_file = 'pdf_uploads/194839/demojob06_demoad06_dm_194839_D_999_V1.pdf';

		// set up basic connection
		$conn_id = ftp_connect($ftp_server);
		

		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

		// check connection
		if ((!$conn_id) || (!$login_result)) { 
			echo "FTP connection has failed!";
			echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
			exit; 
		} else {
			echo "Connected to $ftp_server, for user $ftp_user_name";
			ftp_pasv($conn_id, true); 
		}
		//folder
		$path = $destination_file.'/demo'.date('Y-m-d');
		if(@ftp_chdir($conn_id, $path)){ echo"<br/>dir exists"; }else{ if (@ftp_mkdir($conn_id, $path)){  } }
		
		// upload the file
		$fname = 'demotest.pdf';
		$upload = ftp_put($conn_id, $fname, $source_file, FTP_BINARY);
		
		// check upload status
		if (!$upload) { 
			echo "FTP upload has failed!";
		} else {
			echo "Uploaded $source_file to $ftp_server as $destination_file";
		}

		// close the FTP stream 
		ftp_close($conn_id);
	}*/
	public function dragdrop()
	{
			$ftp_server = 'ftps1a4l1.adwitads.com';
			$ftp_user_name='metroaod';
			$ftp_user_pass='adwit@123';
		
		$destination_file = 'pdf-uploads';
		
		$source_file = $_FILES['file']['tmp_name'];

		// set up basic connection
		$conn_id = ftp_connect($ftp_server);
		 

		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
		ftp_pasv($conn_id, true);
		// check connection
		/*if ((!$conn_id) || (!$login_result)) { 
			echo "FTP connection has failed!";
			echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
			exit; 
		} else {
			echo "Connected to $ftp_server, for user $ftp_user_name";
			
		}*/
		//folder
		$path = $destination_file.'/demo'.date('Y-m-d');
		if(@ftp_chdir($conn_id, $path)){ /*echo"<br/>dir exists";*/ }else{ if (@ftp_mkdir($conn_id, $path)){  } }
		
		// upload the file
		$fname = $_FILES['file']['name'];
		$upload = ftp_put($conn_id, $fname, $source_file, FTP_BINARY);
		
		// check upload status
		/*if (!$upload) { 
			echo "FTP upload has failed!";
		} else {
			echo "Uploaded $source_file to $ftp_server as $destination_file";
		}*/

		// close the FTP stream 
		ftp_close($conn_id);
	}
	
	public function ftpFileUpload()
	{
		$this->load->view('lite/ftpFileUpload');
		/*$ftp_server = "115.248.71.109";
		$ftp_user_name = "annexe3";
		$ftp_user_pass = "adwit@123";
		$destination_file = "adwitads-test";
		$source_file = $_POST['file']['tmp_name'];

		// set up basic connection
		$conn_id = ftp_connect($ftp_server);
		ftp_pasv($conn_id, true); 

		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

		// check connection
		if ((!$conn_id) || (!$login_result)) { 
			echo "FTP connection has failed!";
			echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
			exit; 
		} else {
			echo "Connected to $ftp_server, for user $ftp_user_name";
		}

		// upload the file
		$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY); 

		// check upload status
		if (!$upload) { 
		echo "FTP upload has failed!";
		} else {
		echo "Uploaded $source_file to $ftp_server as $destination_file";
		}

		// close the FTP stream 
		ftp_close($conn_id);*/
	}
	
	//payment gateway functions
	
	public function ccavRequestHandler()
	{
		$merchant_data='122893';
		$working_key='E1427513DACA0EEE39C745FB06E20FEA';//Shared by CCAVENUES
		$access_code='AVDK69EA02CN07KDNC';//Shared by CCAVENUES
		
		if(isset($_POST['amount']) && !empty($_POST['amount'])){ 
			$post = array(
							'customer_id' => $this->session->userdata('lcId'),
							'currency' => 'USD',
							'amount' =>	$_POST['amount'],
							'credits' => $_POST['credits']
						);
			$this->db->insert('lite_payment_transaction',$post);					
			$id =  $this->db->insert_id();
			if($id){
				$cd['tid'] = strtotime(date('Y-m-d H:i:s'));
				$cd['merchant_id'] = $merchant_data;
				$cd['order_id'] = $id;
				$cd['amount'] = $_POST['amount'];
				$cd['currency'] = 'USD';
				$cd['redirect_url'] = base_url().index_page().'lite/home/ccavResponseHandler';
				$cd['cancel_url'] = base_url().index_page().'lite/home/ccavResponseHandler';
				$cd['language'] = "EN";
				
				foreach ($cd as $key => $value){
					$merchant_data.=$key.'='.$value.'&';
				}

				$encrypted_data = $this->encrypt($merchant_data,$working_key); // Method for encrypting the data.
				$data['access_code'] = $access_code;
				$data['encrypted_data'] = $encrypted_data;
				$this->load->view('lite/ccavRequestHandler', $data);
			}
		}
	}
	
	public function ccavResponseHandler()
	{	
		$workingKey='E1427513DACA0EEE39C745FB06E20FEA';		//Working Key should be provided here.
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=$this->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);
		
		//save reponse data in table
		for($i = 0; $i < $dataSize; $i++) 
		{
			$information = explode('=',$decryptValues[$i]);
	    	$attribute[] = $information[0]; 
			$value[] = $information[1];
		}

		$post = array(
						$attribute[1] => $value[1],	//tracking_id
						$attribute[2] => $value[2],	//bank_ref
						$attribute[3] => $value[3],	//order_status
						$attribute[4] => $value[4],	//failure_msg
						$attribute[5] => $value[5],	//payment_mode
						$attribute[6] => $value[6],	//card_name
						$attribute[7] => $value[7],	//status_code
						$attribute[8] => $value[8],	//status_message
						$attribute[9] => $value[9],	//currency
						$attribute[10] => $value[10] //amount	
					);
		$this->db->where('id', $value[0]);	//order_id
		$this->db->update('lite_payment_transaction', $post);
		//credits update
		if(isset($value[3]) && $value[3]=='Success'){
			$lite_payment_transaction = $this->db->get_where('lite_payment_transaction',array('id' => $value[0]))->row_array();
			$param['credits'] = $lite_payment_transaction['credits'];
			$param['amount'] = $value[10];
			$lite_mycredits_history = $this->lite_client_model->assign_paid_credits($param);
		}	
		$data['attribute'] = $attribute;
		$data['value'] = $value;		
		$data['decryptValues'] = $decryptValues;
		$data['dataSize'] = $dataSize;
		$data['order_status'] = $order_status;
		$this->load->view('lite/ccavResponseHandler', $data);
	}
	
	function encrypt($plainText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = $this->pkcs5_pad($plainText, $blockSize);
	  	if(mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
	}

	function decrypt($encryptedText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText = $this->hextobin($encryptedText);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
		mcrypt_generic_init($openMode, $secretKey, $initVector);
		$decryptedText = mdecrypt_generic($openMode, $encryptedText);
		$decryptedText = rtrim($decryptedText, "\0");
	 	mcrypt_generic_deinit($openMode);
		return $decryptedText;
		
	}
	//*********** Padding Function *********************

	function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

	//********** Hexadecimal to Binary function for php 4.0 version ********

	function hextobin($hexString) 
   	{ 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0){
					$binString=$packedString;
				}else{
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
	} 
	//payment gateway end
	
	public function mycredits_history()
	{
		$data['mycredits_history'] = $this->lite_client_model->mycredits_history();
		$this->load->view('lite/mycredits_history', $data);
	}
	
	public function calc()
	{
		if(isset($_POST['w']) && !empty($_POST['w'])){
			$total_credit = 0;
			//lite_credit_sqinch
			$sqinches = $_POST['w'] * $_POST['h'];
			
			$lite_credit_sqinch = $this->db->get('lite_credit_sqinch')->result_array();
			$max = $this->db->query('SELECT MAX(`max_inch`), MAX(`credits`)  FROM `lite_credit_sqinch`')->row_array();
			
			$max_inch_value = $max['MAX(`max_inch`)'];
			$max_inch_credit = $max['MAX(`credits`)'];
			
			if($sqinches > $max_inch_value){
				$sqinches_credits = round($max_inch_credit,1);
			}else{
				foreach($lite_credit_sqinch as $row){
					if($sqinches >= $row['min_inch'] && $sqinches <= $row['max_inch']){
						$sqinches_credits = $row['credits'];
						break;
					}
				}
			}
			echo ($_POST['num'] * $sqinches_credits);
		}else{ echo '0'; }
	}
	
	public function calc_online()
	{
		if(!empty($_POST['ad_format']) && !empty($_POST['web_ad_type'])){
			$ad_credits = $this->lite_client_model->online_credit_calc();
			$total_credits = ($_POST['num_ads'] * $ad_credits);
			echo $total_credits;
		}else{
			echo '0';
		}
	}
	
	public function stripePay($payId='')
	{	
		//$data["message"] = "";
		if(isset($_POST['buynow']) && !empty($_POST['amount'])){ 
			$post = array(
							'customer_id' => $this->session->userdata('lcId'),
							'currency' => 'USD',
							'amount' =>	$_POST['amount'],
							'credits' => $_POST['credits']
						);
			$this->db->insert('lite_payment_transaction',$post);					
			$id =  $this->db->insert_id();
			if($id){
				$payId = MD5($id);
				$post = array('md5_id' => $payId);
				$this->db->where('id', $id);
				$this->db->update('lite_payment_transaction', $post);
				redirect('lite/home/stripePay/'.$payId);
			}else{
				$this->session->set_flashdata('message','<p style="color:#FCA13F;">error : '.$this->db->error().' </p>');
				redirect('lite/home/buycredit');
			}
		}
		
		if($payId != ''){
			$pay_details = $this->db->get_where('lite_payment_transaction',array('md5_id' => $payId))->row_array();
			if(isset($pay_details['id']) && isset($_POST['btnsubmit'])){
				$data = array(
							'number' => $this->input->post('cardnumber'),
							'exp_month' => $this->input->post('expirymonth'),
							'exp_year'=> $this->input->post('expiryyear'),
							'amount' => $pay_details['amount']
						);
				$message = $this->stripegateway->checkout($data);
				//var_dump($message);
				if(isset($message->id)){
					if($message->status == 'succeeded'){
						$order_status = 'success';
					}elseif($message->failure_message != null){
						$order_status = 'failed';
					}
					
					$post = array(
						'tracking_id' 		=> $message->id,	
						'order_status' 		=> $order_status,	
						'failure_message' 	=> $message->failure_message,	
						'card_name'	 		=> $this->input->post('cardnumber'),	
						'status_message' 	=> $message->status,	
						//$attribute[9] 		=> $message->currency,	//currency
						//$attribute[5] 		=> $value[5],	//payment_mode
						//$attribute[7] 		=> $value[7],	//status_code
						//$attribute[10] 		=> $value[10] //amount
						//$attribute[2] 		=> $value[2],	//bank_ref
					);
					$this->db->where('id', $pay_details['id']);	
					$this->db->update('lite_payment_transaction', $post);
					if($this->db->affected_rows()){
						//credits update
						$param['credits'] = $pay_details['credits'];
						$param['amount'] = $pay_details['amount'];
						$lite_mycredits_history = $this->lite_client_model->assign_paid_credits($param);
						if($lite_mycredits_history){							$this->session->set_flashdata('message','<p style="color:#FCA13F;">$'.$pay_details['amount'].' Payment Successful! we have added '.$pay_details['credits'].' Credits to your account. </p>');
							redirect('lite/home/payment_success');
						}	
					}else{
						$this->session->set_flashdata('message','<p style="color:#FCA13F;">error : '.$this->db->error().' </p>');
						redirect('lite/home/buycredit');
					}
				}else{
					$data['message'] = $message->getMessage();
				}
			}
			$data['pay_details'] = $pay_details;
			$this->load->view('lite/stripePay',$data);
		}
	}
	
	public function payment_success()	
	{		
		$this->load->view('lite/payment_success');	
	}
}



