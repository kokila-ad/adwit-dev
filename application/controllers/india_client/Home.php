<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends India_Client_Controller {

	public function index()
	{	
		$this->load->view('india_client/home');
	}
	public function place_order()
	{	
		$this->load->helper(array('form', 'url'));
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		if(isset($_POST['job_no']))
		{
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
			$_POST['adrep_id'] = $this->session->userdata('icId');
			$_POST['publication_id'] = $publication[0]['id'];
			$_POST['group_id'] = $publication[0]['group_id'];
			$_POST['help_desk'] = $publication[0]['help_desk'];
			$_POST['order_type_id'] = '2';
			$_POST['date_needed'] = date('Y-m-d',strtotime($_POST['date_needed']));
			$_POST['size_inches'] = $_POST['width'] * $_POST['height'] ;
			/* $_POST['size_inches'] = $_POST['width'] * $_POST['height'] * 0.3937 ;
			$_POST['width'] = $_POST['width'] * 0.3937;
			$_POST['height'] = $_POST['height'] * 0.3937; */
			
			$this->db->insert('orders', $_POST);
			$orderid = $this->db->insert_id();
			
			if($orderid){
				$this->view($orderid, true);
				$this->orders_folder($orderid);
				redirect('india_client/home/order_success/'.$orderid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("india_client/home/place_order");
			} 
		}
		$this->load->view('india_client/place_order',$data);
	}
	public function view($id = 0, $email = false)
	{
		$data = array();
		$data['order'] = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($data['order'][0]['id']))
		{
				$order_type = $this->db->get_where('orders_type',array('id' => $data['order'][0]['order_type_id']))->result_array();	
				$ad_type = $this->db->get_where('ads_type',array('id' => $data['order'][0]['spec_sold_ad']))->result_array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
				$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
				
				$data['client'] = $client[0];
				$data['order_type'] = $order_type[0];
				$data['ad_type'] = $ad_type[0];
				$data['publications'] = $publications[0];
				if(!$email)
				{
				$this->load->view('india_client/dashboard');
				}else
				{
					$design_team = $this->db->query("Select * from design_teams where id='".$data['publications']['design_team_id']."'")->result_array();
					$data['design_team'] = $design_team[0];
					$jname=$data['order'][0]['job_no'];
					$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
					$data['from'] = $design_team[0]['email_id'];
					$data['from_display'] = 'Design Team';
					$data['replyTo'] = 'do_not_reply@adwitads.com';
					$data['replyTo2'] = $design_team[0]['email_id'];
					$data['replyTo_display'] = 'Do not reply';
					$data['replyTo_display2'] = 'Reply to';
					$data['subject'] = 'Your order no. '.$data['order'][0]['id'].' with Unique Job No. '.$jname.' from '.$publications[0]['name'].' has been received';
					//Client
					$data['recipient'] = $this->session->userdata('icEmail');
					$data['recipient_display'] = $data['client']['first_name'].' '.$data['client']['last_name'];
					$data['cc_recipient'] = $data['client']['email_cc'];
					$data['user'] = 'client';
					$this->place_order_mail($data);
					//Design Team
					$data['recipient'] = $design_team[0]['email_id'];
					$data['recipient_display'] = 'Design Team';
					$data['user'] = 'design_team';
					$this->place_order_mail($data);
				}
		}
	}
public function place_order_mail($data) 
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
		
		if($data['user'] == 'client'){
			$this->email->reply_to($data['replyTo2'],$data['replyTo_display2']);
			$this->email->message($this->load->view('india_client_order',$data, TRUE));
		}elseif($data['user'] == 'design_team'){
			$this->email->reply_to($data['replyTo'],$data['replyTo_display2']);
			$this->email->message($this->load->view('india-client-order2',$data, TRUE));
		}
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($data['recipient'], $data['recipient_display']);
		if($data['user'] == 'client'){
		 	if(isset($data['cc_recipient'])){		
			$this->email->cc(array($data['cc_recipient']));
		}		}
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		} 
	}
	
	public function orders_folder($id = '')
	{
		if($id != ''){
			$data['order'] = $this->db->get_where('orders',array('id' => $id))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $data['order'][0]['job_no']);
			$data['client'] = $client[0];
				
			$path = "downloads/".$id."-".$jname; //path specification
			if (@mkdir($path,0777)){}
				//to store the form
				$myFile = $path."/".$jname.".html";
				$fh = fopen($myFile, 'w') or die("can't open file");
				$stringData = $this->load->view('india_order',$data, TRUE);
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
					redirect('india_client/home/order_success/'.$orderid);
				}else{ $data['file_sucess']="file sucessful!!"; }
			}
			
		}else{
			$this->orders_folder( $orderid ); //if download folder doesnt exists
			redirect('india_client/home/order_success/'.$orderid);
		}
		$this->load->view('india_client/order_success',$data);
	}
	
	public function order_action($action = '', $orderid = 0)
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$action_id = $this->db->query("SELECT * FROM `adrep_actions` WHERE `action` = '$action'")->result_array();
		
		if(isset($order_details[0]['id']) && isset($action_id[0]['id'])){
			$data['orderid'] = $orderid;
			$data['order_details'] = $order_details;
			$data['action_id'] = $action_id[0]['id']; $data['action'] = $action_id[0]['action'];
			$check = $this->db->get_where('order_adrep_actions', array('order_status_id'=>$order_details[0]['status']))->result_array();
			$flag = '0';
			foreach($check as $row){
				//echo $row['order_status_id'].' - '.$row['adrep_action_id'];
				if($row['adrep_action_id'] == $action_id[0]['id']){ $flag = '1'; }
			}
			if($flag == '0'){ 
				$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">'.$action_id[0]['action'].' not allowed for : '.$orderid.' !! </button>');
				redirect('india_client/home/dashboard');
			}
			//revision
			if($action == 'revision' && isset($_POST['rev_submit'])){
				$rev_id = $this->order_revision( $orderid );
				$data['rev_sold_jobs'] = $this->db->get_where('rev_sold_jobs',array('id'=>$rev_id))->result_array();
			}
			//pickup
			if($action == 'pickup' && isset($_POST['pickup_submit'])){
				$this->order_pickup($orderid);
			}
			$this->load->view('india_client/order_action',$data);
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
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $orderid))->result_array();
			if($orders_rev){
				foreach($orders_rev as $last_row){ $version = $last_row['version']; }
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
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			
			
			$rev_data = array(
				'order_id'=>$orderid,
				'adrep'=>$this->session->userdata('icId'),
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
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$dataa['from'] = $design_team[0]['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team[0]['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
					$dataa['subject'] = 'Revision :'.$rev_id;
					$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Email Id : '.$this->session->userdata('icEmail').'<br/> Publication : '.$publication[0]['name'].'<br/> Note & Instructions : '.$_POST['notes'];

					//Client
					$dataa['recipient'] = $this->session->userdata('icEmail');
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$this->rev_jobs_mail($dataa);
					
					//Design team	
					$dataa['recipient'] = $design_team[0]['email_id'];
					$dataa['recipient_display'] = 'Design Team';
					$this->rev_jobs_mail($dataa); 
					return $rev_id;
					//$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Revision Submitted For : '.$orderid.' !! </button>');
					//redirect('india_client/home/dashboard');
			}else{
				$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Revision Not Submitted : '.$orderid.'-'.$this->db->_error_message().' !! </button>');
				redirect('india_client/home/dashboard');
			}
		}
	}
	public function order_pickup($orderid)
	{
		if(isset($_POST['pickup_submit']))
		{
			$adrep = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
			
			$order_details = array(
				'adrep_id' => $this->session->userdata('icId'),
				'publication_id' => $adrep[0]['publication_id'],
				'help_desk' => $publication[0]['help_desk'],
				'group_id' => $publication[0]['group_id'],
				'order_type_id' => '1', //'1-Print Ad'
				'publication_name' => $_POST['publication_name'],
				'job_instruction' => $_POST['job_instruction'],
				'print_ad_type' => $_POST['print_ad_type'],
				'date_needed' => date('Y-m-d',strtotime($_POST['date_needed'])),
				'job_no' => $_POST['job_no'],
				'copy_content_description' => $_POST['copy_content_description'],
				'notes' => $_POST['notes'],
				//'width' => $_POST['width'] * 0.3937,
				//'height' => $_POST['height'] * 0.3937,
				//'size_inches' => $_POST['width'] * $_POST['height'] * 0.3937 ,
				'size_inches' => $_POST['width'] * $_POST['height'] ,
				'pickup_adno' => $orderid,
				'status' => '1',
			);
			$this->db->insert('orders', $order_details);
			$pickupid = $this->db->insert_id();
		//redirect('india_client/home/order_success/'.$pickupid);
		if($pickupid){
				$this->view($pickupid, true);
				redirect('india_client/home/order_success/'.$pickupid);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect("india_client/home/place_order");
			} 
		}
	}
	
	public function view_uploaded_files($orderid='')
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
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
			$this->load->view('india_client/order_action',$data);
			
	}
	
	public function rev_jobs_mail($dataa)
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
	  $this->email->to($dataa['recipient'],$dataa['recipient_display']);// change it to yours
	  $this->email->subject($dataa['subject']);
	  $this->email->message($dataa['body']);
		//$this->email->bcc($dataa['from'], $dataa['from_display']);
		//$this->email->cc($dataa['ad_recipient'], $dataa['ad_recipient_display']);

		if($this->email->send()){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function revision_details($order='')
	{
		if(isset($_POST['submit']))
		{
			if(!empty($_POST['from_dt']) && !empty($_POST['to_dt']))
			{ 
				$created_from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
				$created_to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
				$rev_from = date('Y-m-d',strtotime($_POST['from_dt']));
				$rev_to = date('Y-m-d',strtotime($_POST['to_dt']));
				$data['order'] = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$order'  AND (`created_on` BETWEEN '$created_from' AND '$created_to' ) ;")->result_array();
				$data['orders_rev'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '$order'  AND (`date` BETWEEN '$rev_from' AND '$rev_to')")->result_array();
				$this->load->view('india_client/revision_details', $data);
			}
		}
		else
		{
			if($order!='')
			{
			$data['order'] = $this->db->get_where('orders',array('id' => $order))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $data['order'][0]['publication_id']))->result_array();
			$data['publication'] = $publication[0];
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $order))->result_array();
			$data['cat_result'] = $cat_result;
			if(($data['order'][0]['status']=='5' || $data['order'][0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
				$data['slug'] = $cat_result[0]['slug'];
				$sourcefilepath = $cat_result[0]['source_path'];
				$data['sourcefilepath'] = $sourcefilepath;
			}
			$data['orders_rev'] = $this->db->get_where('rev_sold_jobs',array('order_id' => $order))->result_array();
			$this->load->view('india_client/revision_details', $data);
			}
			
		}
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
			redirect('india_client/home/dashboard');
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}
	public function additional_att($id='')
	{
		$data['order'] = $this->db->get_where('orders',array('id' => $id))->result_array();
		
		//Uploading files
		if (!empty($_FILES)) {
				$path = $data['order'][0]['file_path'];
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
		if($data['order'][0]['file_path'] != '0')
		{
			if(is_dir($data['order'][0]['file_path']))
			{
				if($dh = opendir($data['order'][0]['file_path']))
				{
					while(($file = readdir($dh)) !== false) {
					if($file == '.' || $file == '..'){
					continue; }
					$datecheck = date('F d Y');
					if($file)
					{
						$lastmodified = date("F d Y",filemtime(utf8_decode($data['order'][0]['file_path']."/".$file)));
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
		redirect('india_client/home/dashboard');
	
	}
	public function additional_att_view($id = 0, $email = false,$data)
	{
		$orders = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($orders[0]['id']))
		{
			if(!$email)
			{
				$this->load->view('india_client/dashboard');
			}else
			{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				$data['orders'] = $this->db->get_where('orders',array('id' => $id))->result_array();
				$data['adrep'] = $this->db->query("Select * from adreps where id='".$data['orders'][0]['adrep_id']."'")->result_array();
				
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				$data['from'] = $design_team[0]['email_id'];
				$data['from_display'] = 'Design Team';
				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo2'] = $design_team[0]['email_id'];
				$data['replyTo_display'] = 'Do not reply';
				$data['replyTo_display2'] = 'Reply to';
				$data['subject'] = 'Order:'.$data['orders'][0]['id'];
				$data['attachment'] = $data['orders'][0]['file_path'];
				//Client
				$data['recipient'] = $data['adrep'][0]['email_id'];
				$data['recipient_display'] = $data['adrep'][0]['first_name'].' '.$data['adrep'][0]['last_name'];
				$this->csrmail($data);
				//Design Team
				$data['recipient'] = $design_team[0]['email_id'];
				$data['recipient_display'] = 'Design Team';
				$this->send_mail($data);

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
		
		//$this->email->cc(array($data['ad_recipient']));
		
		//$this->email->bcc($data['from']);
			    
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function send_mail($data) 
	{
         $config = array();
               $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;
                
	    $this->load->library('email');
	    
		$this->email->initialize($config);
		
		$this->email->from($data['from'], $data['from_display']);  
		
		$this->email->reply_to($data['replyTo'],$data['replyTo_display']); 
		
		$this->email->subject($data['subject']);
		
	    $this->email->message($this->load->view('additional_att_view',$data, TRUE)); 
	
		$this->email->set_alt_message("Unable to load text!");
		
		$this->email->to($data['recipient'], $data['recipient_display']); 
		
		if(!$this->email->send())
		return false;
		else 
		return true;

    }
    
	public function order_table()
	{
		$data['order_details'] = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('icId')))->result_array();
		$this->load->view('india_client/order_table',$data);
	}
	public function request_order()
	{
		$data['hi']="HI";
		if(isset($_POST['submit']))
		{
			$requests_details = array(
								'adrep_id' => $this->session->userdata('icId'),
								'subject' => $_POST['subject'],
								'message' => $_POST['message'],
								'status' => '1'
								);
			$this->db->insert('requests', $requests_details);
			$requests_id = $this->db->insert_id();
			if($requests_id){
				if (!empty($_FILES)){
					$count = count(array_filter($_FILES['userfile']['tmp_name']));
					$path = 'requests/'.$requests_id;
					if (@mkdir($path,0777)){}
					for($i=0; $i<$count; $i++)
					{
						$tempFile = $_FILES['userfile']['tmp_name'][$i];
						$fileName = $_FILES['userfile']['name'][$i];
						if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
							$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
							redirect('india_client/home/request_order');
						}
					}	
					$post = array( 'filepath' => $path );		//save file path to table
					$this->db->where('id', $requests_id);
					$this->db->update('requests', $post); 
					$data['status'] = "Success";
				}
			}else{
				$this->session->set_flashdata('message', $this->db->_error_message());
				redirect('india_client/home/request_order');
			}
			$this->request_order_view($requests_id);
		}
		$this->load->view('india_client/request_order',$data);
	}
	public function request_order_view($id = 0)
	{
		$request = $this->db->get_where('requests',array('id' => $id))->result_array();
		if(isset($request[0]['id']))
		{
			$data['request'] = $request;
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
			$data['publication'] = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			$design_team = $this->db->query("Select * from design_teams where id='".$data['publication'][0]['design_team_id']."'")->result_array();
				
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				$data['from'] = $design_team[0]['email_id'];
				$data['from_display'] = 'Design Team';
				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo_display'] = 'Do not reply';
				
				//Client
				$data['subject'] = 'Your request no. '.$request[0]['id'].' has been received';
				$data['recipient'] = $this->session->userdata('icEmail');
				$data['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				$data['user'] = 'client';
				$this->request_order_mail($data);
				//Design Team
				$data['subject_design'] = 'A request no. '.$request[0]['id'].' has been Placed by '.$client[0]['first_name'].' '.$client[0]['last_name'];
				$data['recipient'] = $design_team[0]['email_id'];
				$data['recipient_display'] = 'Design Team';
				$data['user'] = 'design_team';
				$this->request_order_mail($data);
		}
	}
	public function request_order_mail($data) 
	{
		$config = array();
               $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;
                
	    $this->load->library('email');
	    
		$this->email->initialize($config);
		
		$this->email->from($data['from'], $data['from_display']); 
		
		$this->email->reply_to($data['replyTo'],$data['replyTo_display']);
		
		if($data['user'] == 'client'){
		    $this->email->subject($data['subject']); 
				
		    $this->email->message($this->load->view('request-order1',$data, TRUE));
				
		    $this->email->to($data['recipient'], $data['recipient_display']);
		}elseif($data['user'] == 'design_team'){
		    $this->email->subject($data['subject_design']); 
				
		    $this->email->message($this->load->view('request-order2',$data, TRUE));
				
		    $this->email->to($data['recipient'], $data['recipient_display']);
		}
		$this->email->set_alt_message("Unable to load text!");
		
		if(!$this->email->send()) return false; else return true;
	}
	
	public function download($dir='',$dir1='',$file='')
	{
		$data['name'] = $dir.'/'.$dir1.'/'.$file;
		$this->load->view('india_client/download',$data);
	}
	public function dashboard($value='')
	{
		$from = date('Y-m-d', strtotime(' -3 day'));
		$to = date('Y-m-d');
		
		if($value == '1' || $value== null)
		{	$team_lead = $this->db->query("SELECT * FROM `adreps` WHERE `id` = ".$this->session->userdata('icId')." ;")->result_array();
			if($team_lead[0]['team_orders'] == '1')
			{
			$publication_id = $team_lead[0]['publication_id'];
			$data['tl_order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id'  and `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ORDER BY `id` DESC;")->result_array();
			}
			else
			{
				$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('icId')."  and `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ORDER BY `id` DESC;")->result_array();
			}
		}
		elseif($value == '2'){
			$data['requests_details'] = $this->db->query("SELECT * FROM `requests` WHERE `adrep_id` = ".$this->session->userdata('icId')." ORDER BY `id` DESC;")->result_array();
		}
		$this->load->view('india_client/dashboard',$data);
	}
	public function new_ad_answer($id='')	
	{
		if($id!='')
		{
			$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id`='$id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($question){
			$order = $this->db->get_where('orders',array('id' => $id))->result_array();
				
			//Uploading files
				if(!empty($_FILES)) {
					$tempFile = $_FILES['file']['tmp_name'];
					//$fileName = $_FILES['file']['name'];
					$path = $order[0]['file_path'].'/'.$_FILES['file']['name'];
					if(!move_uploaded_file($tempFile, $path)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						redirect('india_client/home');
					}else{ $dataa['temp1'] = $_FILES['file']['tmp_name']; 
							$dataa['fname1'] = $_FILES['file']['name'];
					 }
				} 
				
			if(isset($_POST['submit'])) 
			{
				//order status
				$post_status = array('question' => '2');
				$this->db->where('id', $id);
				$this->db->update('orders', $post_status); 
				
				//orders_Q_A
				if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/New_York');}
				$timestamp = date('Y-m-d H:i:s');
				$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('icId'), 'Atimestamp' => $timestamp );
				$this->db->where('id', $_POST['id']);
				$this->db->update('orders_Q_A', $Apost);
				
				//send mail 
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
				if($client)
				{
					
					$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$dataa['from'] = $design_team[0]['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team[0]['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
					$dataa['subject'] = 'Question Answered for Unique Ad No: '.$order[0]['job_no'] ;
					$_POST['answer'] = str_replace(PHP_EOL,'<br/>', $_POST['answer']);
					$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Answer : '.$_POST['answer'];
					
					 //Design team	
				//	$dataa['recipient'] = $design_team[0]['email_id'];
					$dataa['recipient'] = 'kavitha@adwit.co.uk';
					$dataa['recipient_display'] = 'Design Team';
					$this->test_mail($dataa); 
				} 
				redirect('india_client/home/dashboard');
			}
			
			$data['question'] = $question[0];//cat_result 
			$this->load->view('india_client/new_ad_answer', $data);
			}
		}	else{ 
				echo "<script>alert('Direct Access Denied..')</script>";
				$this->index();
				}
	}
	public function rev_ad_answer($id='')	
	{
		if($id!='')
		{
			$rev_sold_jobs = $this->db->get_where('rev_sold_jobs',array('id' => $id))->result_array();
			
			//Uploading files
				if(!empty($_FILES)) {
					$tempFile = $_FILES['file']['tmp_name'];
					$path = $rev_sold_jobs[0]['file_path'].'/'.$_FILES['file']['name'];
					if(!move_uploaded_file($tempFile, $path)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						redirect('india_client/home');
					}else{ $dataa['temp1'] = $_FILES['file']['tmp_name']; 
							$dataa['fname1'] = $_FILES['file']['name'];
					 }
				} 
			
			if(isset($_POST['submit']))
			{	
				/* if (!empty($_FILES['ufile']['tmp_name'][0]))	//file upload to revision_downloads
				{	
					$dir = "revision_downloads/".$_POST["job_slug"];
					//$file_path = $dir;
					if (@mkdir($dir,0777))
					{

					}
					$path1= $dir.'/'.$_FILES['ufile']['name'][0];
					//$path2= $dir.'/'.$_FILES['ufile']['name'][1];
									
					if(!copy($_FILES['ufile']['tmp_name'][0], $path1))
					{
						echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
						exit();
					}else{
						$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
						$dataa['fname1'] = $_FILES['ufile']['name'][0];
					}								
				} */
				$post = array( 'answer' => $_POST['answer'] );
				$this->db->where('id', $_POST['id']);
				$this->db->update('rev_sold_jobs', $post);
				
				//send mail
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('icId')))->result_array();
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
					//Design team	
					//$dataa['recipient'] = $design_team[0]['email_id'];
					$dataa['recipient'] = 'kavitha@adwit.co.uk';
					$dataa['recipient_display'] = 'Design Team';
					$this->test_mail($dataa); 
				} 
				redirect('india_client/home/dashboard');
			}
			
			$data['rev_sold_jobs'] = $rev_sold_jobs[0];
			$this->load->view('india_client/rev_ad_answer', $data);
		}else{ 
				echo "<script>alert('Direct Access Denied..')</script>";
				$this->index();
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
	   
	    if(isset($dataa['temp1'])){ $this->email->attach($dataa['temp1'],$dataa['fname1']); }
	    if(isset($dataa['temp2'])){ $this->email->attach($dataa['temp2'],$dataa['fname2']); }
	   	
		if(!$this->email->send())
               return false;
               else
               return true; 
	}
	
	public function order_search()
	{
			$team_lead = $this->db->query("SELECT * FROM `adreps` WHERE `id` = ".$this->session->userdata('icId')." ;")->result_array();
			if($team_lead[0]['team_orders'] == '1')
			{
				$publication_id = $team_lead[0]['publication_id'];
				if(isset($_POST['search'])){ //search
				$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`advertiser_name` LIKE '".$_POST['input']."%' OR `job_no` LIKE '".$_POST['input']."%' OR `id` LIKE '".$_POST['input']."%' ) ;")->result_array();
				}
				elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
					$adrep_id = $this->session->userdata('icId');
					$keyword = $_POST['keyword'];
					$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`id` LIKE '".$keyword."%' OR `advertiser_name` LIKE '".$keyword."%' OR `job_no` LIKE '".$keyword."%')")->result_array();
				}  
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' ;")->result_array();
					}else{
						$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
				} 
				
				
			}else {
				if(isset($_POST['search'])){ //search
				$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('icId')." AND (`advertiser_name` LIKE '".$_POST['input']."%' OR `job_no` LIKE '".$_POST['input']."%' OR `id` LIKE '".$_POST['input']."%' ) ;")->result_array();
				}
				elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
					$adrep_id = $this->session->userdata('icId');
					$keyword = $_POST['keyword'];
					$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$adrep_id."' AND (`id` LIKE '".$keyword."%' OR `advertiser_name` LIKE '".$keyword."%' OR `job_no` LIKE '".$keyword."%')")->result_array();
				}  
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('icId')." AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('icId')." ;")->result_array();
					}else{
						$data['order_details'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('icId')." AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
				} 
			}
		
		
		$this->load->view('india_client/dashboard',$data);
	}
	public function profile()
	{
		$data['adrep_details'] = $this->db->get_where('adreps',array('id'=>$this->session->userdata('icId')))->result_array();
		if(isset($_POST['submit']))
		{
			$this->db->query("Update adreps set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('icEmail')."' or username='".$this->session->userdata('client')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
			if($this->db->affected_rows())
				$data['pwd_success'] = "success";
			else
				$data['invalid_pwd'] = "Invalid";
		}
		if(isset($_POST['img_upload']))
		{
			//echo "image upload";
			$uploadDir = "images/adreps/".$this->session->userdata('icId')."/";
		
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
				$this->db->where('id', $this->session->userdata('icId'));
				$this->db->update('adreps', $data); 
				redirect('india_client/home/profile');
				}else{ $data['error']= "Invalid file type";}
		
		}
		$this->load->view('india_client/profile',$data);		
		
		}
	public function faq()
	{
		$this->load->view('india_client/faq');
	}
	}