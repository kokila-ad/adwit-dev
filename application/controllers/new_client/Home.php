<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends New_Client_Controller {

	public function index()
	{   //echo CI_VERSION;
	    if($this->session->userdata('url_method')){
	        $session_url_method = $this->session->userdata('url_method');
	        $this->session->unset_userdata('url_method');
	        redirect('new_client/home/'.$session_url_method);    
	    }
	    
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
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$data['client'] = $client;
		
		$this->load->view('new_client/home', $data);
	}
/*	
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
		 	if(isset($data['ad_recipient'])){		
			$this->email->cc(array($data['ad_recipient']));
		}		}
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		} 
	}
*/
	public function billing()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		if($client[0]['billing'] == '1')
		{
			$this->load->view('new_client/billing');
		}
		else
		{
			echo "Access Denied";
		}
		
	}

	//payment gateway functions
	
	public function ccavRequestHandler()
	{
		$merchant_data='122893';
		$working_key='E1427513DACA0EEE39C745FB06E20FEA';//Shared by CCAVENUES
		$access_code='AVDK69EA02CN07KDNC';//Shared by CCAVENUES
		
		if(isset($_POST['amount']) && !empty($_POST['amount'])){ 
			$post = array(
							'customer_id' => $this->session->userdata('ncId'),
							'currency' => 'USD',
							'amount' =>	$_POST['amount']
						);
			$this->db->insert('payment_transaction',$post);					
			$id =  $this->db->insert_id();
			if($id){
				$_POST['merchant_id'] = $merchant_data;
				$_POST['order_id'] = $id;
				//$_POST['amount'] = "1.00";
				$_POST['currency'] = 'USD';
				$_POST['redirect_url'] = base_url().index_page().'new_client/home/ccavResponseHandler';
				$_POST['cancel_url'] = base_url().index_page().'new_client/home/ccavResponseHandler';
				
				foreach ($_POST as $key => $value){
					$merchant_data.=$key.'='.$value.'&';
				}

				$encrypted_data = $this->encrypt($merchant_data,$working_key); // Method for encrypting the data.
				$data['access_code'] = $access_code;
				$data['encrypted_data'] = $encrypted_data;
				$this->load->view('new_client/ccavRequestHandler', $data);
			}
		}
	}
	
	public function page_ad()
	{
		$data['hi'] = 'hello';
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		if(isset($_POST['submit']) && isset($_POST['orderid'])){
			$orderid = $_POST['orderid'];
			$post = array(
						'job_no' => $_POST['job_no'],
						'print_ad_type' => $_POST['print_ad_type'],
						'section' => $_POST['section'],
						'notes' => $_POST['notes'],
						'status' => '1'
						);
			$this->db->where('id', $orderid);			
			$this->db->update('orders', $post);
			if($this->db->affected_rows()){
				//send mail
				$order = $this->db->query("SELECT `job_no` FROM `orders` WHERE `id`='".$orderid."'")->row_array();
				$design_team = $this->db->query("Select email_id from design_teams where id='".$publication[0]['design_team_id']."'")->row_array();
				
				$from = $design_team['email_id'];
				$from_display = 'Design Team';

				$replyTo = 'do_not_reply@adwitads.com';
				$replyTo_display = 'Do not reply';
				
				$subject = 'AdwitAds Order #'.$data['order']['id'];
				
				$recipient = $client[0]['email_id'];
				$recipient_display = $client[0]['first_name'].' '.$client[0]['last_name'];
								
				$this->load->library('email');
				//$this->email->initialize($config);
				$this->email->from($from, $from_display);
				$this->email->reply_to($replyTo, $replyTo_display);
				$this->email->subject($subject);  
				$this->email->message("An order with page number: ".$order['job_no']." has been placed");
				$this->email->set_alt_message("Unable to load text!");
				$this->email->to($recipient, $recipient_display);
				
				
				if(!$this->email->send()){
					echo"<script>alert('email notification failed')</script>";
				}
				
				$this->session->set_flashdata("message","order placed sucessful");
				redirect("new_client/home/dashboard");
			}else{
				// $this->session->set_flashdata("message",$this->db->_error_message());
				$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
				redirect("new_client/home/dashboard");
			}
		}else{
			//create entry in orders table
			$data = array(
							'adrep_id' => $this->session->userdata('ncId'),
							'publication_id' => $publication[0]['id'],
							'group_id' => $publication[0]['group_id'],
							'help_desk' => $publication[0]['help_desk'],
							'order_type_id' => '5',
							'status' => '0',
							'club_id'=> $publication[0]['club_id']
						);
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
			if(isset($orderid)){
				//Live_tracker updation
						$tracker_data = array(
                        						'pub_id'=> $publication[0]['id'],
                        						'order_id'=> $orderid,
                        						'club_id'=> $publication[0]['club_id'],
                        						'status' => '1'
                    						);
						$this->db->insert('live_orders', $tracker_data);
				
			}
			$data['orderid'] = $orderid;
		}
		
		$this->load->view('new_client/page_ad', $data); 
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
			$this->db->update('payment_transaction', $post);
		$data['attribute'] = $attribute;
		$data['value'] = $value;		
		$data['decryptValues'] = $decryptValues;
		$data['dataSize'] = $dataSize;
		$data['order_status'] = $order_status;
		$this->load->view('new_client/ccavResponseHandler', $data);
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
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
	} 
	
	
	//payment gateway functions END
	
	public function report_template_GM()
    {
        $data['hi'] = 'hi';
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $key = $this->input->get('id'); 
            $keywords = explode(' ', $key);
            $rowsPerPage = 12; 
            $num = $_GET['num'];  
            $offset = ($num - 1) * $rowsPerPage;
            $id_where = "template_tags.name LIKE '" . implode("%' OR template_tags.name LIKE '", $keywords) . "%'";
            if(isset($_GET['size_id'])){
                $size_id = $_GET['size_id']; $data['size_id'] = $size_id;
                $sql = "SELECT
                        DISTINCT template_bank.id, template_bank.url 
                        FROM `template_tags`, `template_bank_tag`, `template_bank`
                        WHERE ({$id_where})
                        and template_bank_tag.tag_id = template_tags.id and template_bank.id = template_bank_tag.template_bank_id and template_bank.size_id = $size_id ORDER BY template_bank.id DESC LIMIT $offset, $rowsPerPage";
            }else{
                $sql = "SELECT
                        DISTINCT template_bank.id, template_bank.url 
                        FROM `template_tags`, `template_bank_tag`, `template_bank`
                        WHERE ({$id_where})
                        and template_bank_tag.tag_id = template_tags.id and template_bank.id = template_bank_tag.template_bank_id ORDER BY template_bank.id DESC LIMIT $offset, $rowsPerPage";
            }
 
            $templates = $this->db->query($sql)->result_array();
			$data['templates_count'] = count($templates);
			$data['num'] = $num; 
            $data['id'] = $key;
			$data['rowsPerPage'] = $rowsPerPage;
			
			if(isset($templates[0]['id'])){
				$data['templates'] = $templates;
            }else{
				$this->session->set_flashdata('message','Oops! We could\'t locate an order with the provided OrderID. Please double-check and try again.');
                redirect('new_client/home/report_template_GM');
            }
        }
        $this->load->view('new_client/report_template_GM',$data);
    }


    public function template_multiple_image()
	{
		if(!empty($_FILES['img_url']['name'])){
			$path = 'template_bank/csv_files/'.$_FILES['img_url']['name'];
			if(!copy($_FILES['img_url']['tmp_name'], $path))
			{
				//$this->session->set_flashdata('message','Error uploading image file.. Try again..!!');
				$this->session->set_flashdata('message','Hang on! There seems to be a hiccup with the file upload. Ensure your file is the right format and size, and then give it another whirl.');
				redirect('new_client/home/report_template_GM');
			}
			
			if(file_exists($path))
			{ 
				$handle = fopen($path, "r");
				$csv_row = '1';
				while (($data = fgetcsv($handle, 100000, ",")) !== FALSE)
				{
					if($csv_row == 1){ $csv_row++; continue; }
					for($i=0;$i<1;$i++){
						$data[$i] = str_replace("'","",$data[$i]);
					}
					//image URL
					$img_url = $this->db->get_where('template_bank', array('url'=>$data[1]))->result_array();
					if(count($img_url) == 0 && !empty($data[1])){
						 $post = array('url'=>$data[1]);
						$this->db->insert('template_bank', $post);
						$template_bank_id = $this->db->insert_id(); 
						
						$data[0] = str_replace(', ',',',$data[0]);
						$dep = EXPLODE(',',$data[0]);
						foreach($dep as $row){ 
							$template_tags = $this->db->get_where('template_tags', array('name'=>$row))->result_array();
							if(count($template_tags) == 0){
								//$slug = str_replace(' ','_',$row);
								$post = array('name' => $row);
								$this->db->insert('template_tags', $post);
								$tag_id = $this->db->insert_id();
							}else{ $tag_id =$template_tags[0]['id']; }
							
							if($template_bank_id && $tag_id){
								//image_bank_tag
								$post = array('template_bank_id'=>$template_bank_id, 'tag_id'=>$tag_id);
								$this->db->insert('template_bank_tag', $post);
							}
						} 
					} 
				} 
				fclose($handle); 
			}
			
			$this->session->set_flashdata('message','file uploaded successfuly');
			redirect('new_client/home/report_template_GM');
		}
		
	}
	
    public function template_add_tag() 
	{
		if(isset($_POST['tags']) && !empty($_POST['tags'])){ 
			$tags = str_replace(', ',',',$_POST['tags']);
			$temp = array();
			$temp = explode(",", $tags);
			$ct = count($temp);
			for($i=0; $i<$ct; $i++){
				$this->db->where('name', $temp[$i]);
				$query = $this->db->get('template_tags', 1);
				if($query->num_rows() == 0){
					//$slug = str_replace(' ','_',$temp[$i]);
					$post = array('name'=>$temp[$i]);	
					$this->db->insert('template_tags', $post);
					$tag_id= $this->db->insert_id();
					
					//template_bank_tag
					$tag_id_post = array('template_bank_id'=>$_POST['id'], 'tag_id' => $tag_id);
					$this->db->insert('template_bank_tag', $tag_id_post);
					
				}elseif($query->num_rows() > 0){
					$result = $query->result_array();
					//order_tags
					$order_tags = $this->db->get_where('template_bank_tag',array('template_bank_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']))->row_array();
					if(!isset($order_tags['id'])){
						$data = array('template_bank_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']);
						$this->db->insert('template_bank_tag', $data);
						
					}
				}
			}
			/* $order_tags = $this->db->get_where('template_bank_tag',array('template_bank_id'=>$_POST['id']))->result_array(); 
			foreach($order_tags as $row_tag){
				$tag = $this->db->get_where('template_tags',array('id'=>$row_tag['tag_id']))->row_array();
				echo $tag['name'].' , ';	
			}  */
		}
	}

    public function resubmit_form($id,$adtype='')
	{	
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication[0];	
		
		$order_details = $this->db->get_where('orders',array('id' => $id))->result_array();
		if($order_details[0]['status'] == '6')
		{
			if($adtype=='')
			{
				if($order_details[0]['order_type_id'] == '1')
				{ $data['adtype'] = 'online'; }
				elseif($order_details[0]['order_type_id'] == '2')
				{ $data['adtype'] = 'print'; }
			} else {
				$data['adtype'] = $adtype;
			}
			
			$data['order_details'] = $order_details;
			
			
			if(isset($_POST['print_submit']))
			{
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				if(!empty($_POST['date_needed']))
				{ $date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
				} else {
					$date_needed = '0000-00-00';
				}
				
				if(!empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				} else {
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				/* if($publication[0]['custom_sizes'] == '1')
				{   if($_POST['orders_custom_sizes'] != 'custom')
					{	$custom_sizes = $this->db->get_where('orders_custom_sizes',array('id' => $_POST['orders_custom_sizes']))->result_array();
						$width = $custom_sizes[0]['width'];
						$height = $custom_sizes[0]['height'];
					} else {
						$width = $_POST['width'];
						$height = $_POST['height'];
					}  
				} else {  	
						$width = $_POST['width'];
						$height = $_POST['height'];
						} */
				
				 $data = array( 
				'adrep_id' =>$this->session->userdata('ncId'),
				'publication_id' => $publication[0]['id'],
				'group_id' => $publication[0]['group_id'],
				'help_desk' => $publication[0]['help_desk'],
				'order_type_id' => '2',
				'size_inches' => $_POST['width'] * $_POST['height'],
				'advertiser_name' => $advertiser,
				'job_no' => $job_number,
				'copy_content_description' => $_POST['copy_content_description'],
				'width' => $_POST['width'],
				'height' => $_POST['height'],
				'print_ad_type' => $_POST['print_ad_type'],
				'notes' => $_POST['notes'],
				'date_needed' => $date_needed, 
				'publish_date' => $publish_date,
				'club_id'=> $publication[0]['club_id']
				); 
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				if($orderid){
					//Live_tracker updation
					
						$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id'=> $orderid,
						'job_no' => $job_number,
						'club_id'=> $publication[0]['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					
					$this->view($orderid, true);
					$this->orders_folder($orderid);
					redirect('new_client/home/order_success/'.$orderid);
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/dashboard");
				}  
				
			  
			}
			if(isset($_POST['online_submit']))
			{
			
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				
				$data = array( 
				'adrep_id' =>$this->session->userdata('ncId'),
				'publication_id' => $publication[0]['id'],
				'group_id' => $publication[0]['group_id'],
				'help_desk' => $publication[0]['help_desk'],
				'order_type_id' => '1',
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
				'club_id'=> $publication[0]['club_id']
				);
				
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				 if($orderid){
					 //Live_tracker updation
					$tracker_data = array(
                    						'pub_id'=> $publication[0]['id'],
                    						'order_id'=> $orderid,
                    						'job_no' => $job_number,
                    						'club_id'=> $publication[0]['club_id'],
                    						'status' => '1'
                						);
					$this->db->insert('live_orders', $tracker_data);
				
					$this->view($orderid, true);
					$this->orders_folder($orderid);
					redirect('new_client/home/order_success/'.$orderid);
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/dashboard");
				} 
			}
			$this->load->view('new_client/resubmit_form',$data);
			
		}
	}

   public function order_search()
	{
		$adrep_id = $this->session->userdata('ncId');
		$client = $this->db->get_where('adreps',array('id' => $adrep_id))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$publication_id = $client[0]['publication_id'];
		$data['client'] = $client; $data['pre_next'] = '1';

		if($client[0]['team_orders']=='1' ) //team orders
		{
			if(isset($_POST['search'])){ //search
				$keyword = $_POST['input'];
				$tl_orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') ;")->result_array();
				if($tl_orders){
					$data['tl_orders'] = $tl_orders;
				}elseif($publication[0]['id']=='43' || $publication[0]['id']=='47' || $publication[0]['id']=='13')
				{
					$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$keyword."%' OR `advertiser` LIKE '%".$keyword."%');")->result_array();
					if($preorder){ 
					$data['preorder'] = $preorder; }
					else{ $this->session->set_flashdata('message',"No Orders Found for ".$keyword);
					redirect('new_client/home/dashboard'); }
				}
			}elseif(isset($_POST['adv_search'])){ //advance search
			
				if(!empty($_POST['keyword']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['status']) && !empty($_POST['project'])){ //kdps
					$keyword = $_POST['keyword'];
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
					$project = $_POST['project'];
					
						
					if($status == "All" && $project == "All" ){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}elseif($status != "All" && $project == "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`status` = '".$_POST['status']."');")->result_array();
					}elseif($status == "All" && $project != "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`project_id` = '".$_POST['project']."');")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`status` = '".$_POST['status']."')
							AND (`project_id` = '".$_POST['project']."' );")->result_array();
					}
					
				}elseif(!empty($_POST['keyword']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['status'])){ //kds
					$keyword = $_POST['keyword'];
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
					
					if($status == "All"){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`status` = '$status');")->result_array();	
					}
				}elseif(!empty($_POST['keyword']) && !empty($_POST['status']) && !empty($_POST['project'])){ //ksp
					$keyword = $_POST['keyword'];
					$status = $_POST['status'];
					$project = $_POST['project'];
					
					if($status == "All" && $project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					}elseif($status != "All" && $project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`status` = '$status');")->result_array();
					}elseif($status == "All" && $project != "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`project_id` = '$project');")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`status` = '$status')
							AND (`project_id` = '$project');")->result_array();	
					}
				}elseif(!empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['status']) && !empty($_POST['project'])){ //dsp
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
					$project = $_POST['project'];
						
					if($status == "All" && $project == "All" ){ 	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
					}elseif($status != "All" && $project == "All" ){ 	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`status` = '$status');")->result_array();
					}elseif($status == "All" && $project != "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`project_id` = '$project');")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`status` = '$status')
							AND (`project_id` = '$project');")->result_array();	
					}
				}elseif(!empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['project']) && !empty($_POST['keyword'])){ //dpk
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$project = $_POST['project'];
					$keyword = $_POST['keyword'];
					
					if($project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`project_id` = '$project');")->result_array();	
					}
				}elseif(!empty($_POST['keyword']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt'])){ //kd
					$keyword = $_POST['keyword'];
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
						
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
				}elseif(!empty($_POST['keyword']) && !empty($_POST['status'])){ //ks
					$keyword = $_POST['keyword'];
					$status = $_POST['status'];
						
					if($status == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`status` = '$status') ;")->result_array();
					}
				}elseif(!empty($_POST['keyword']) && !empty($_POST['project'])){ //kp
					$keyword = $_POST['keyword'];
					$project = $_POST['project'];
						
					if($project == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`project_id` = '$project') ;")->result_array();
					}
				}elseif(!empty($_POST['status']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt'])){ //sd
					//echo "status&date";
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
						
					if($status == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`status` = '$status') ;")->result_array();
					}
				}elseif(!empty($_POST['project']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt'])){ //pd
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$project = $_POST['project'];
						
					if($project == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`project_id` = '$project') ;")->result_array();
					}
				}elseif(!empty($_POST['status']) && !empty($_POST['project'])){ //sp
					$status = $_POST['status'];
					$project = $_POST['project'];
					
						
					if($status == "All" && $project == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id';")->result_array();
					}elseif($status != "All" && $project == "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`status` = '$status') ;")->result_array();
					}elseif($status == "All" && $project != "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`project_id` = '$project') ;")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `publication_id` = '$publication_id' 
							AND (`status` = '$status')
							AND (`project_id` = '$project');")->result_array();
					}
				}elseif(!empty($_POST['keyword'])){ //k
					$keyword = $_POST['keyword'];
					$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%')")->result_array();
					if($orders){
						$data['tl_orders'] = $orders;
					}elseif($publication[0]['id']=='43' || $publication[0]['id']=='47'  || $publication[0]['id']=='13'){
						$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$keyword."%' OR `advertiser` LIKE '%".$keyword."%');")->result_array();
						if($preorder){ 
							$data['preorder'] = $preorder; 
						}else{ 
							$this->session->set_flashdata('message',"No Orders Found for ". $_POST['keyword']);
							redirect('new_client/home/dashboard'); 
						}
					}
						
				}elseif(!empty($_POST['from_dt']) && !empty($_POST['to_dt'])){ //d
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
						
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
						
				}elseif(!empty($_POST['status'])){ //s
					if($_POST['status'] == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' ;")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}elseif(!empty($_POST['project'])){ //p
					if($_POST['project'] == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' ;")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`project_id` = '".$_POST['project']."');")->result_array();
					}
				}
				
			}
				
		}
		else //Adrep specific orders
		{
			if(isset($_POST['search'])){ //search
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('ncId')." AND (`id` = '".$_POST['input']."' OR `advertiser_name` LIKE '%".$_POST['input']."%' OR `job_no` LIKE '%".$_POST['input']."%') ;")->result_array();
				if($orders)
				{
					$data['orders'] = $orders;
				}elseif($publication[0]['id']=='43' || $publication[0]['id']=='47'  || $publication[0]['id']=='13')
				{
					$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$_POST['input']."%' OR `advertiser` LIKE '%".$_POST['input']."%');")->result_array();
					if($preorder){ 
						$data['preorder'] = $preorder; }
					else{ 
						$this->session->set_flashdata('message',"No Orders Found for ". $_POST['input']);
						redirect('new_client/home/dashboard'); }
				}		
			}elseif(isset($_POST['adv_search']))
			
			{
			 //advance search
				if(!empty($_POST['keyword']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['status']) && !empty($_POST['project'])){
					$keyword = $_POST['keyword'];
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
					$project = $_POST['project'];
					
						
					if($status == "All" && $project == "All" ){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}elseif($status != "All" && $project == "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`status` = '".$_POST['status']."');")->result_array();
					}elseif($status == "All" && $project != "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`project_id` = '".$_POST['project']."');")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`status` = '".$_POST['status']."')
							AND (`project_id` = '".$_POST['project']."' );")->result_array();
					}
					
				}elseif(!empty($_POST['keyword']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['status'])){
					$keyword = $_POST['keyword'];
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
					
					if($status == "All"){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`status` = '$status');")->result_array();	
					}
				}elseif(!empty($_POST['keyword']) && !empty($_POST['status']) && !empty($_POST['project'])){
					$keyword = $_POST['keyword'];
					$status = $_POST['status'];
					$project = $_POST['project'];
					
					if($status == "All" && $project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					}elseif($status != "All" && $project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`status` = '$status');")->result_array();
					}elseif($status == "All" && $project != "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`project_id` = '$project');")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`status` = '$status')
							AND (`project_id` = '$project');")->result_array();	
					}
				}elseif(!empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['status']) && !empty($_POST['project'])){
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
					$project = $_POST['project'];
						
					if($status == "All" && $project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
					}elseif($status != "All" && $project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`status` = '$status');")->result_array();
					}elseif($status == "All" && $project != "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`project_id` = '$project');")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`status` = '$status')
							AND (`project_id` = '$project');")->result_array();	
					}
				}elseif(!empty($_POST['from_dt']) && !empty($_POST['to_dt']) && !empty($_POST['project']) && !empty($_POST['keyword'])){
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$project = $_POST['project'];
					$keyword = $_POST['keyword'];
					
					if($project == "All" ){	
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
					}else{
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' )
							AND (`project_id` = '$project');")->result_array();	
					}
				}elseif(!empty($_POST['keyword']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt'])){
					$keyword = $_POST['keyword'];
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
						
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
				}elseif(!empty($_POST['keyword']) && !empty($_POST['status'])){
					$keyword = $_POST['keyword'];
					$status = $_POST['status'];
						
					if($status == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`status` = '$status') ;")->result_array();
					}
				}elseif(!empty($_POST['keyword']) && !empty($_POST['project'])){
					$keyword = $_POST['keyword'];
					$project = $_POST['project'];
						
					if($project == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%');")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%') 
							AND (`project_id` = '$project') ;")->result_array();
					}
				}elseif(!empty($_POST['status']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt'])){
					//echo "status&date";
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$status = $_POST['status'];
						
					if($status == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`status` = '$status') ;")->result_array();
					}
				}elseif(!empty($_POST['project']) && !empty($_POST['from_dt']) && !empty($_POST['to_dt'])){
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					$project = $_POST['project'];
						
					if($project == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' );")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`created_on` BETWEEN '$from' AND '$to' ) 
							AND (`project_id` = '$project') ;")->result_array();
					}
				}elseif(!empty($_POST['status']) && !empty($_POST['project'])){
					$status = $_POST['status'];
					$project = $_POST['project'];
					
						
					if($status == "All" && $project == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' ;")->result_array();
					}elseif($status != "All" && $project == "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`status` = '$status') ;")->result_array();
					}elseif($status == "All" && $project != "All"){
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`project_id` = '$project') ;")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` 
							WHERE `adrep_id` = '$adrep_id' 
							AND (`status` = '$status')
							AND (`project_id` = '$project');")->result_array();
					}
				}elseif(!empty($_POST['keyword'])){
					$keyword = $_POST['keyword'];
					$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$adrep_id' AND (`id` = '".$keyword."' OR `advertiser_name` LIKE '%".$keyword."%' OR `job_no` LIKE '%".$keyword."%')")->result_array();
					if($orders){
						$data['tl_orders'] = $orders;
					}elseif($publication[0]['id']=='43' || $publication[0]['id']=='47'  || $publication[0]['id']=='13'){
						$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$keyword."%' OR `advertiser` LIKE '%".$keyword."%');")->result_array();
						if($preorder){ 
							$data['preorder'] = $preorder; 
						}else{ 
							$this->session->set_flashdata('message',"No Orders Found for ". $_POST['keyword']);
							redirect('new_client/home/dashboard'); 
						}
					}
						
				}elseif(!empty($_POST['from_dt']) && !empty($_POST['to_dt'])){
					$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
						
					$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$adrep_id' AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
						
				}elseif(!empty($_POST['status'])){
					if($_POST['status'] == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$adrep_id';")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$adrep_id' AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}elseif(!empty($_POST['project'])){
					if($_POST['project'] == "All"){	
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$adrep_id';")->result_array();
					}else{
						$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$adrep_id' AND (`project_id` = '".$_POST['project']."');")->result_array();
					}
				}
				
			}
		}
		
		if(isset($preorder)){
			$this->load->view('new_client/preorders', $data);
		}else{
			$this->load->view('new_client/dashboard',$data);
		}
		
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
	
	public function print_ad()
	{ 
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = 	$publication[0];
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
			if($publication[0]['custom_sizes'] == '0' || (isset($_POST['orders_custom_sizes']) && $_POST['orders_custom_sizes'] == 'custom'))
			{
				$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric|greater_than[0]');
				$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric|greater_than[0]');
			}
			if($publication[0]['custom_sizes'] == '1' ){
				$this->form_validation->set_rules('orders_custom_sizes', 'Size', 'trim|required');
			}
			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			$this->form_validation->set_rules('rush', 'Rush', 'trim');
			
		if ($this->form_validation->run() == FALSE){
			$data['num_errors'] = $this->form_validation->error_count();
			$this->load->view('new_client/print_ad',$data);
		}else{	
			if(isset($_POST['submit']))
			{
				 
				if(empty($_POST['rush'])){ $_POST['rush']='0'; }
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				if(!empty($_POST['date_needed'])){ 
					$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
				} else {
					$date_needed = '0000-00-00';
				}
				if(!empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				} else {
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				if($publication[0]['custom_sizes'] == '1')
				{   if($_POST['orders_custom_sizes'] != 'custom')
					{	$custom_sizes = $this->db->get_where('orders_custom_sizes',array('id' => $_POST['orders_custom_sizes']))->result_array();
						$width = $custom_sizes[0]['width'];
						$height = $custom_sizes[0]['height'];
					} else {
						$width = $_POST['width'];
						$height = $_POST['height'];
					}  
				} else {  	
						$width = $_POST['width'];
						$height = $_POST['height'];
				}
				if(isset($_POST['publication_name'])){ $publication_name = $_POST['publication_name']; }else{ $publication_name = ''; }
				if(isset($_POST['project_id'])){ $project_id = $_POST['project_id']; }else{ $project_id = '0'; }
				
				 $data = array( 
				'adrep_id' =>$this->session->userdata('ncId'),
				'publication_id' => $publication[0]['id'],
				'group_id' => $publication[0]['group_id'],
				'help_desk' => $publication[0]['help_desk'],
				'order_type_id' => '2',
				'size_inches' => $width * $height,
				'advertiser_name' => $advertiser,
				'job_no' => $job_number,
				'copy_content_description' => $_POST['copy_content_description'],
				'width' => $width,
				'height' => $height,
				'print_ad_type' => $_POST['print_ad_type'],
				'notes' => $_POST['notes'],
				'rush'	=> $_POST['rush'],
				'date_needed' => $date_needed, 
				'publish_date' => $publish_date, 
				'publication_name' => $publication_name,
				'font_preferences' => $_POST['font_preferences'],
				'color_preferences' => $_POST['color_preferences'],
				'job_instruction' => $_POST['job_instruction'],
				'art_work' => $_POST['art_work'],
				'project_id' => $project_id,
				'activity_time' => date('Y-m-d h:i:s'),
				'club_id'=> $publication[0]['club_id']
				); 
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				if($orderid){
					//Live_tracker updation
						$tracker_data = array(
    						'pub_id'=> $publication[0]['id'],
    						'order_id'=> $orderid,
    						'job_no' => $job_number,
    						'club_id'=> $publication[0]['club_id'],
    						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					
					$this->view($orderid, true);
					$this->orders_folder($orderid);
					redirect('new_client/home/order_success/'.$orderid);
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/print_ad");
				}  
				
			 
			} 
		} 
		//$this->load->view('new_client/print_ad',$data);
	} 
	
	public function moodboard($orderid='')
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->row_array();
		$path = $order_details['file_path'].'/'.'Theme';
		
		//Uploading files
		if(!empty($_FILES)) {
			if(file_exists($path)){
				array_map('unlink', glob($path."/*.*"));
				rmdir($path);
				$this->db->query("DELETE FROM `order_mood` WHERE `order_id`= '".$orderid."'");
			}
			
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$path.'/';
				$targetFile = $targetPath . $fileName ;
				if(move_uploaded_file($tempFile, $targetFile)){
					$md = array(
					'order_id' => $orderid,
					'mood_id' => '4',
					'path' => $path.'/'.$fileName,
					);
					$this->db->insert('order_mood', $md);
					$data['file_sucess']="file sucessful!!"; 
				}else{ 
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					redirect('new_client/home/order_success/'.$orderid);
				}	
			
			
		}
		if(isset($_POST['os_submit'])){
			if(isset($_POST['mood_board'])){
				if($_POST['mood_board'] == '4'){
					//redirect('new_client/home');
					
				}else{
					$md = array(
					'order_id' => $orderid,
					'mood_id' => $_POST['mood_board'],
					'path' => $_POST['path']
					);
					$this->db->insert('order_mood', $md);
					//redirect('new_client/home');
				}
			}
		}
	}
	
	public function view($id = 0, $email = false)
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($order[0]['id']))
		{
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
			$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();

			$data = array();
			$data['order_id'] = $id;
			$data['client'] = $client[0];
			$data['order'] = $order[0];
			$data['publications'] = $publications[0];

			if(!$email){
				$this->load->view('new_client/dashboard');
			}else{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
				
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				if($order[0]['order_type_id'] == '6'){
				    $data['from'] = 'pagination@adwitads.com';
				    $data['replyTo2'] = 'pagination@adwitads.com';   
				}else{
				    $data['from'] = $design_team[0]['email_id'];
				    $data['replyTo2'] = $design_team[0]['email_id'];
				}
				$data['from_display'] = 'Design Team';

				$data['replyTo'] = 'do_not_reply@adwitads.com';
				
				
				$data['replyTo_display'] = 'Do not reply';
				$data['replyTo_display2'] = 'Reply to';
				
				if($publication[0]['id'] == '47'){
					if($data['order']['rush'] == '1'){
						$data['subject'] = 'AdwitAds Unique Job ID'.$data['order']['job_no'].' '.$data['order']['advertiser_name'].' - Rush Ad';
					}else{
						$data['subject'] = 'AdwitAds Unique Job ID'.$data['order']['job_no'].' '.$data['order']['advertiser_name'];
					}
				}else{
					if($data['order']['rush'] == '1'){
						$data['subject'] = 'AdwitAds Order #'.$data['order']['id'].' - Rush Ad';
					}else{
						$data['subject'] = 'AdwitAds Order #'.$data['order']['id'];
					}
				}
				//Client

				$data['recipient'] = $client[0]['email_id'];
				$data['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
				
				$this->newad_send_mail($data);
		    	
				
				//if($this->session->userdata('ncId') == '36'){
				    if(isset($client[0]['email_cc']) && !empty($client[0]['email_cc'])){
    				    $ccdb = $client[0]['email_cc'];
            			$cc = explode(',', $ccdb);
            			if(count($cc)>1){
            				$i=1;
            				foreach($cc as $c){
            					$data['recipient'] = $c;
        				        $data['recipient_display'] = 'Advertising Director';
        				
        				        $this->newad_send_mail($data);
            				}    
            			}else{
            			   $data['recipient'] = $client[0]['email_cc'];
    				        $data['recipient_display'] = 'Advertising Director';
    				
    				        $this->newad_send_mail($data);
            			}
            		}   
			/*	}else{
				    if(isset($client[0]['email_cc']) && !empty($client[0]['email_cc'])){
    				    $data['recipient'] = $client[0]['email_cc'];
    				    $data['recipient_display'] = 'Advertising Director';
    				
    				    $this->newad_send_mail($data);
    				}    
				}*/
			}
		}

	}
	
	public function newad_send_mail($data) 
	{
	   include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
 
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($data['from'], $data['from_display']);
		$email->setReplyTo($data['replyTo2'],$data['replyTo_display2']);
		$email->setSubject($data['subject']);
		
		//if($this->session->userdata('ncId') == 36 || $data['order']['publication_id'] == '3' || $data['order']['group_id'] == '18'){
		    $email->setSubject("Order Confirmation - ".$data['order']['id']." - ".$data['order']['advertiser_name']." - ".$data['order']['job_no']);
		    $email->addContent("text/html", $this->load->view('email_template/OrderConfirmation',$data, TRUE));
		/*}else{
		    $email->addContent("text/html", $this->load->view('newad_placed_notification_emailer',$data, TRUE));
		}*/
		
		$email->addTo($data['recipient'], $data['recipient_display']);
        
		/*if(isset($data['design_recipient']) && !empty($data['design_recipient'])){		
			$email->addBCC($data['design_recipient']); 
		} */
		
		if(isset($data['ad_recipient']) && !empty($data['ad_recipient'])){	
			$email->addCC($data['ad_recipient']); 	
		}
        
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		
	    /*notification log
	    $stringData = "Success - END.";
	    
		fwrite($fh, $stringData."\n");
		fclose($fh);*/
	}
	
	public function test_newad_send_mail() 
	{
	    include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
 
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($data['from'], $data['from_display']);
		$email->setReplyTo($data['replyTo2'],$data['replyTo_display2']);
		$email->setSubject($data['subject']);
		
		//$email->setFrom('webmaster@adwitglobal.com', 'DeignTeam');
		//$email->setSubject("Multiple CC");
		
		$email->setSubject("Order Confirmation - ".$data['order']['id']." - ".$data['order']['advertiser_name']." - ".$data['order']['job_no']);
		$email->addContent("text/html", $this->load->view('email_template/OrderConfirmation',$data, TRUE));
			
		//$email->addContent("text/html", "<p>TEST EMAIL</p>"); 
		
		$email->addTo($data['recipient'], $data['recipient_display']);
		if(isset($data['ad_recipient']) && !empty($data['ad_recipient'])){	
			$ccdb = $data['ad_recipient'];
			$cc = explode(',', $ccdb);
			if(count($cc)>1){
				$i=1;
				foreach($cc as $c){
					$tos[$c] = "User".$i;
				}    
			}else{
			   $tos[$ccdb] = "User";
			}
			
			
			$email->addCcs($tos); 	
		}
		
		//$email->addTo("sudarshan@adwitads.com", "recipient_display");
        
		
		$sendgrid = new \'');
		$response = $sendgrid->send($email);
		
		print_r($response) ;
	}
	
	public function orders_folder($id = '')
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($order[0]['id'])){
			//$order = $this->db->get_where('orders',array('id' => $id))->result_array();
			$data['order'] = $order;
			$data['order_type'] = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
			$data['publications'] = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->row_array();
			$jname = $order[0]['job_no'];
			$data['client'] = $client[0];
				
			$path = "downloads/".$id."-".$jname; //path specification
			if (@mkdir($path,0777)){}
			
			//save path
				$post = array('file_path' => $path);
				$this->db->where('id', $id);
				$this->db->update('orders', $post);
				
				//to store the form
				$myFile = $path."/".$jname.".html";
				$fh = fopen($myFile, 'w') or die("can't open file");
				if($order[0]['order_type_id'] == '2'){
				    $stringData = $this->load->view('htmlorder-details',$data, TRUE);    
				}else{
				    $stringData = $this->load->view('newclientorder',$data, TRUE);    
				}
				
				fwrite($fh, $stringData);
				fclose($fh);
				
				
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
					redirect('new_client/home/order_success/'.$orderid);
				}else{ $data['file_sucess']="file sucessful!!"; }
			}
			
		}else{
			$this->orders_folder( $orderid ); //if download folder doesnt exists
			redirect('new_client/home/order_success/'.$orderid);
		}
		/* if(isset($_POST['submit']))
		{
			$md = array(
			'order_id' => $orderid,
			'mood_id' => $_POST['mood_board'],
			);
			$this->db->insert('order_mood', $md);
			redirect('new_client/home');
		} */
		$this->load->view('new_client/order_success',$data);
	}
	
	public function live_tracker()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$live_orders = $this->db->query("SELECT order_id,status FROM `live_orders` WHERE `pub_id`='".$publication[0]['id']."'")->result_array();
		$data['live_orders'] = $live_orders;
		$this->load->view('new_client/live_tracker',$data);
	}
	
	public function newad_remove_att()
	{
		if(isset($_POST['remove_att']))
		{
			$filename = $_POST['filename'];
			$filepath = $_POST['filepath'];
			$adwitadsid = $_POST['adwitadsid'];
			$dirhandle = opendir($filepath);
			while ($file = readdir($dirhandle)) {
				if($file==$filename) {
				unlink($filepath.'/'.$filename);
				}
			}
			redirect('new_client/home/order_success/'.$adwitadsid);
		}		
	}
	
	public function online_ad()
	{
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication[0];	
		
		if(isset($_POST['submit']))
		{
			if(empty($_POST['rush'])){ $_POST['rush']='0'; }
			
			if(!empty($_POST['publish_date'])){
				$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
			} else {
				$next_day =  date('D', strtotime(' +1 day'));
				if($next_day == 'Sat' || $next_day == 'Sun'){
					$publish_date = date('Y-m-d', strtotime('next monday'));
				}else{
					$publish_date = date('Y-m-d', strtotime(' +1 day'));
				}
			}
			$advertiser = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
			
			$data = array( 
			'adrep_id' =>$this->session->userdata('ncId'),
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
			'publish_date' => $publish_date,
			'publication_name' => $_POST['publication_name'],
			'font_preferences' => $_POST['font_preferences'],
			'color_preferences' => $_POST['color_preferences'],
			'job_instruction' => $_POST['job_instruction'],
			'art_work' => $_POST['art_work'],
			'rush'	=> $_POST['rush'],
			'activity_time' => date('Y-m-d h:i:s'),
			'flexitive_size' => $_POST['flexitive_size'],
			'club_id'=> $publication[0]['club_id']
			);
			if($publication[0]['id']=='43' || $publication[0]['id']=='13'){ if(empty($_POST['rush'])) $_POST['rush']='0';  }		
			
			
			
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
			
			 if($orderid){
				//Live_tracker updation
					$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id'=> $orderid,
						'job_no' => $job_number,
						'club_id'=> $publication[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
				$this->view($orderid, true);
				$this->orders_folder($orderid);
				redirect('new_client/home/order_success/'.$orderid);
			}else{
				// $this->session->set_flashdata("message",$this->db->_error_message());
				$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
				redirect("new_client/home/online_ad");
			}  
		}
		$this->load->view('new_client/online_ad',$data);
	}
	
	public function dashboard($count='0') 
	{
	    $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$num_days = $client[0]['display_orders'];
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$data['client'] = $client;
		
		$publication_id = $client[0]['publication_id'];
		$today = date('Y-m-d');     
		
		$pday = date('Y-m-d', strtotime(" -$num_days day"));
		$pyday = date('Y-m-d', strtotime(' -6 day'));
		$data['count'] =  $count;
		$data['preorder_count'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$pyday 00:00:00' AND '$today 23:59:59';")->num_rows();
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND (`activity_time` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `order_type_id` != '6' ORDER BY `id` DESC;")->result_array();										
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('ncId')."' AND (`activity_time` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `order_type_id` != '6' ORDER BY `id` DESC;")->result_array();										
			}
		}else{
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND `order_type_id` != '6' ORDER BY `activity_time` DESC LIMIT 10;")->result_array();
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('ncId')."' AND `order_type_id` != '6' ORDER BY `activity_time` DESC LIMIT 10;")->result_array();
			}
		}
	
		if(isset($_POST['order_display_submit']))
		{
			$post = array('team_orders' => $_POST['orders'] );
			$this->db->where('id', $this->session->userdata('ncId'));
			$this->db->update('adreps', $post);
			redirect('new_client/home/dashboard/0');
		}
		
		if(isset($_GET['previous']))
		{
				$count = $count - '10';
				$data['count'] =  $count;
				if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND `order_type_id` != '6' ORDER BY `activity_time` DESC LIMIT 10 OFFSET $count;")->result_array();
				}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('ncId')."' AND `order_type_id` != '6' ORDER BY `activity_time` DESC LIMIT 10 OFFSET $count;")->result_array();
			}
		}
		
		if(isset($_GET['next']))
		{
			$count = $count + '10';
			$data['count'] =  $count;
			if($client[0]['team_orders']=='1'){
				$data['tl_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$publication_id' AND `order_type_id` != '6' ORDER BY `activity_time` DESC LIMIT 10 OFFSET $count;")->result_array();
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('ncId')."' AND `order_type_id` != '6' ORDER BY `activity_time` DESC LIMIT 10 OFFSET $count;")->result_array();
			}
		} 
		
		$this->load->view('new_client/dashboard',$data); 
	} 
	
	public function preorders()
	{
		if(isset($_POST['search'])){ //search
		$data['preorder'] = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`advertiser` LIKE '".$_POST['input']."%' OR `job_name` LIKE '".$_POST['input']."%');")->result_array();
		}elseif(isset($_POST['adv_search'])){ //advance search
		if(!empty($_POST['keyword'])){
		$keyword = $_POST['keyword'];
		$data['preorder'] = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`advertiser` LIKE '".$keyword."%' OR `job_name` LIKE '".$keyword."%');")->result_array();
		}  
		if(!empty($_POST['from_dt']) && !empty($_POST['to_dt']))
		{ 
			$from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
			$to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
			$data['preorder'] = $this->db->query("SELECT * from `preorder` WHERE `accept`='0' AND (`time_stamp` BETWEEN '$from' AND '$to');")->result_array();
		
		$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('ncId')." AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				
		}
		} 
		else {
			$today = date('Y-m-d');
			$pday = date('Y-m-d', strtotime(' -6 day'));
			$data['preorder'] = $this->db->query("SELECT * from `preorder` WHERE `accept`='0' AND (`time_stamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59');")->result_array();
			
		 }
		 $this->load->view('new_client/preorders', $data);
	}
	
	public function preorderform()
	{
		if(isset($_POST['Submit']) && isset($_POST['id']))
		  {
			$data['preorder_details'] = $this->db->get_where('preorder',array('id' => $_POST['id']))->result_array();
			$this->load->view('new_client/preorderform', $data);
		  }
		  else{
			if(isset($_POST['order_submit']) && isset($_POST['id']))
			{
				$preorder = $this->db->get_where('preorder',array('id' => $_POST['id']))->result_array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
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
					'adrep_id' => $this->session->userdata('ncId'),
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
					'club_id' => $publication_hd[0]['club_id']
					);
				$this->db->insert('orders',$post); 
				$order_no = $this->db->insert_id(); 
				if($order_no){
					//Live_tracker updation
					
					$tracker_data = array(
						'pub_id' => $publication_hd[0]['id'],
						'order_id' => $order_no,
						'job_no' => $preorder[0]['job_name'],
						'club_id' => $publication_hd[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
					 $post = array('accept' => '1');
					 $this->db->where('job_name', $preorder[0]['job_name']);
					 $this->db->update('preorder', $post);
					 
					 $this->view($order_no,true); //send mail
					 $this->orders_folder($order_no); //folder creation
					 redirect('new_client/home/order_success/'.$order_no);//File upload
				}else{ 
					$this->session->set_flashdata("message","Internal Error: Order not placed!");
					redirect('new_client/home');
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
				$data['preorder'] = $this->db->query("SELECT * FROM `preorder` WHERE `adrep_id` = ".$this->session->userdata('ncId')." AND (`advertiser_name` LIKE '".$_POST['input']."%' OR `job_no` LIKE '".$_POST['input']."%' OR `id` LIKE '".$_POST['input']."%' ) ;")->result_array();
			}elseif(isset($_POST['adv_search'])){ //advance search
				if(!empty($_POST['keyword'])){
					$adrep_id = $this->session->userdata('ncId');
					$keyword = $_POST['keyword'];
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$adrep_id."' AND (`id` LIKE '".$keyword."%' OR `advertiser_name` LIKE '".$keyword."%' OR `job_no` LIKE '".$keyword."%')")->result_array();
				}  
			
				if(!empty($_POST['from_dt']) && !empty($_POST['from_dt']))
				{ 
					 $from = date('Y-m-d',strtotime($_POST['from_dt'])). " 00:00:00";
					 $to = date('Y-m-d',strtotime($_POST['to_dt'])). " 23:59:59";
					
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('ncId')." AND (`created_on` BETWEEN '$from' AND '$to' ) ;")->result_array();
				}
				if(!empty($_POST['status'])){ 
					if($_POST['status'] == "All"){	
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('ncId')." ;")->result_array();
					}else{
						$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = ".$this->session->userdata('ncId')." AND (`status` = '".$_POST['status']."');")->result_array();
					}
				}
			}  */
		   $this->load->view('new_client/preorders', $data);
		}
	}
	
/*public function order_action($action = '', $orderid = 0, $pickup='')
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$action_id = $this->db->query("SELECT * FROM `adrep_actions` WHERE `action` = '$action'")->result_array();
		
		
		if(isset($order_details[0]['id']) && isset($action_id[0]['id'])){
			$data['orderid'] = $orderid;
			$data['order_details'] = $order_details;
			$data['action_id'] = $action_id[0]['id']; $data['action'] = $action_id[0]['action'];
			//$data['pickup'] = $pickup;
			
			if($pickup=='')
			{
				if($order_details[0]['order_type_id'] == '1')
					{ $data['pickup'] = 'online'; }
					elseif($order_details[0]['order_type_id'] == '2')
					{ $data['pickup'] = 'print'; }
			}
			else
			{ 	$data['pickup'] = $pickup; }
			
				
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
						redirect('new_client/home/dashboard');
					}
				}
			}
			
			//pickup
			if($action == 'pickup' && isset($_POST['print_pickup_submit'])){
				$this->order_pickup($orderid);
			}

			if($action == 'pickup' && isset($_POST['web_pickup_submit'])){
				$this->order_pickup_web($orderid);
			}
			
			$this->load->view('new_client/order_action',$data);
		}
		
	}*/
	public function order_action($action = '', $orderid = 0, $pickup='')
	{
		$order_details = $this->db->get_where('orders', array('id' => $orderid))->result_array();
		$action_id = $this->db->query("SELECT * FROM `adrep_actions` WHERE `action` = '$action'")->result_array();
		$data['actionname'] = $action_id[0]['action'];
		
		if(isset($order_details[0]['id']) && isset($action_id[0]['id'])){
			$data['orderid'] = $orderid;
			$data['order_details'] = $order_details;
			$data['action_check'] = $action_id;
			$data['action_id'] = $action_id[0]['id'];
			$data['action'] = $action_id[0]['action'];
			//preorders waukesha publication
			$data['preorders_waukesha'] = $this->db->query("SELECT * FROM `preorders_waukesha` WHERE `adwit_id` = '$orderid'")->row_array();
				
			//revision
			 if($action == 'revision'){
				if(isset($_POST['rev_complete'])){
					$rev_id = $_POST['rev_id'];
					$rev_update = array(
					'note' => $_POST['notes']);
					$this->db->where('id',$rev_id);
					$this->db->update('rev_sold_jobs', $rev_update); 
					redirect('new_client/home/dashboard');
				}
				if(isset($_POST['rev_submit'])){
					$rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
					if($rev){
						if($rev['status'] == '5'){
							$rev_id = $this->order_revision( $orderid );
							$data['rev_sold_jobs'] = $this->db->get_where('rev_sold_jobs',array('id'=>$rev_id))->result_array();
						}else{ 
						redirect('new_client/home/dashboard'); }
					}else{
							$rev_id = $this->order_revision( $orderid );
							$data['rev_sold_jobs'] = $this->db->get_where('rev_sold_jobs',array('id'=>$rev_id))->result_array();
					}
				}else{
					$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
					if(isset($orders_rev['id'])){
						$slug = $orders_rev['new_slug'];
					}else{
						$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->row_array();
						$slug = $cat_result['slug'];
					}
					if($slug!='none'){ 
						$data['order_details'] = $order_details;
						$data['slug'] = $slug;
					}else{
						$this->session->set_flashdata("message","Heads up! The order with this OrderID is currently in production status, so certain actions may not be permitted. Review the order's status for more details.");
						redirect('new_client/home/dashboard');
					}
				}
			}
			
			//pickup
			if($action == 'pickup'){
			    if($pickup == ''){
    			    if($order_details[0]['order_type_id'] == '1'){ 
        				$pickup = 'online'; 
        			}elseif($order_details[0]['order_type_id'] == '2'){ 
        				$pickup = 'print';
        			}
			    }
    		
			    $data['rev_details_latest'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
			    if(!isset($_POST['cacheid'])){	
            		$post_data = array(
            					'adrep_id' => $this->session->userdata('ncId'),
            					'order_type_id' => '1',
            					);
            		$this->db->insert('order_cache', $post_data);
            		$cacheid = $this->db->insert_id();
            		$data['cacheid'] = $cacheid;
            	}
            		
			    if(isset($_POST['print_pickup_submit'])){
    			    $this->order_pickup($orderid);
    			}
    
    			if(isset($_POST['web_pickup_submit'])){
    				$this->order_pickup_web($orderid);
    			}    
		    }
			
			//View uploaded file
			
			if($order_details){
				$order_file_path = $order_details[0]['file_path'];
				
				if($order_file_path != 'none'){ //order file path
				    if($order_details[0]['order_type_id'] == '6'){ //pagination new order files
				        $order_filename =[];
				        $html_order_form = $order_file_path.'/'.$order_details[0]['job_no'].'.html'; //html file
				        if(file_exists($html_order_form)){
				            $order_filename[] = $order_details[0]['job_no'].'.html';
				            $order_filemtime[] = date("M d Y h:i:s.", @filemtime(mb_convert_encoding($html_order_form,'ISO-8859-1', 'UTF-8')));
				            $data['order_filemtime'] = $order_filemtime;
				        }
				        
				        $articles_path = $order_file_path.'/articles';
            			$ads_path = $order_file_path.'/ads';
            				        if(file_exists($articles_path) && $atp = opendir($articles_path)){
            				           	while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
                        				{
                        					if ($file == '.' || $file == '..'){  continue; }
                        					if($file){ $order_filename[]=$articles_path.'/'.$file; }
                        					//$order_filename[] = $articlename;// array of name will stored in articles_name
                        				}
                        				closedir($atp);//dirctry $atp clocsed
                        			}
                        			if(file_exists($ads_path) && $atp = opendir($ads_path)){
                        			   	while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
                        				{
                        					if ($file == '.' || $file == '..'){  continue; }
                        					if($file){ $order_filename[]=$ads_path.'/'.$file; }
                        					//$order_filename[] = $adsname;// array of name will stored in articles_name
                        				}
                        				closedir($atp);//dirctry $atp clocsed
                        			}
                        			
                        	    $data['order_file_names'] = $order_filename;
                    }else{
				    	if(is_dir($order_file_path)){
    						if($dh = opendir($order_file_path)){
    						    $order_filemtime[]='';
    							while(($order_file = readdir($dh)) !== false) {
        							if($order_file == '.' || $order_file == '..'){ continue; }
        							if($order_file){ $order_filename[] = $order_file; }
        							foreach($order_filename as $row){
        							    $fl = $order_file_path."/".$row;
        									if(file_exists($fl)){
        									    $order_filemtime[]= date("M d Y h:i:s.", @filemtime(mb_convert_encoding($fl,'ISO-8859-1', 'UTF-8')));
        									}
        								//$order_filemtime[]= date("M d Y h:i:s.",filemtime(utf8_decode($order_file_path."/".$row)));
        							}
        							
        							$data['order_file_names'] = $order_filename;
        							$data['order_filemtime'] = $order_filemtime;
        							$data['order_file_path'] = $order_file_path;
    							}
    							closedir($dh);
    						}
    					} 
				    }
				}
				
				$rev_details = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$orderid'")->result_array();
				$data['rev_details'] = $rev_details;
				$data['pickup'] = $pickup; 
			} 
			if($this->session->userdata('ncId') == '36'){
			    $this->load->view('new_client/order_action',$data);//$this->load->view('new_client/order_action_annotation',$data);
			}else{
			    $this->load->view('new_client/order_action',$data);
			}
		}
	}
	
    public function pickup_order_annotation($orderId)
    {
        $order_detail = $this->db->query("SELECT `id` FROM `orders` WHERE `id` = '$orderId'")->row_array();
        if(isset($order_detail['id'])){
            //order annotation
    		   $content =  $_POST['content'];
               $decode_content = base64_decode($content);
               
            //Writing marked-up PDF file to revision_order_cache/revision_order_cache_id/order_annotation/order_id.pdf   
                $myFile = "pickup_order_annotation/".$orderId.".pdf";
    		    $fh = fopen($myFile, 'w+') or die("can't open file");
    		    fwrite($fh, $decode_content);
    		    fclose($fh);
    	}
        echo "success";
    }
    
	public function remove_att()
	{
		if(isset($_POST['remove_att']))
		{
			$filename = $_POST['filename'];
			$filepath = $_POST['filepath'];
			$adwitadsid = $_POST['adwitadsid'];
			$dirhandle = opendir($filepath);
			while ($file = readdir($dirhandle)) {
				if($file==$filename) {
				unlink($filepath.'/'.$filename);
				}
			}
			redirect('new_client/home/order_action/attachments/'.$adwitadsid);
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
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			
			
			$rev_data = array(
				'order_id'=>$orderid,
				'order_no' => $_POST['job_slug'],
				'adrep'=>$this->session->userdata('ncId'),
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
			
			//Live_tracker Revision updation
				
				$tracker_data = array(
					'pub_id'=> $publication[0]['id'],
					'order_id' => $orderid,
					'revision_id'=> $rev_id,
					'status' => '1'
				);
				$this->db->insert('live_revisions', $tracker_data);
				
			if($rev_id)	
			{
				$revision = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
				//Revision details of the order
				$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
				$rev_count = $order_details[0]['rev_count'];
				
				$rev_count_data = array(
				'rev_count' => $rev_count + '1', 
				'rev_id' =>$rev_id,
				'activity_time' => date('Y-m-d h:i:s'),
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
				    $dataa['orders'] = $order_details[0];
					$dataa['from'] = $design_team[0]['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team[0]['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
					
					if($publication[0]['id'] == '47'){
						$dataa['subject'] = 'AdwitAds Unique Job ID #'.$order_details[0]['job_no'].' '.$order_details[0]['advertiser_name'];
					}else{
						$dataa['subject'] = 'AdwitAds Revision #'.$revision[0]['order_no'];
					}
									
					$dataa['body'] = $this->load->view('revad_placed_notification_emailer',$data, TRUE);
					$dataa['ad_recipient'] = $client[0]['email_cc'];
					$dataa['ad_recipient_display'] = 'Advertising Director';
				
					//Client
					//$dataa['recipient'] = $this->session->userdata('ncEmail');
					$dataa['recipient'] = $client[0]['email_id'];
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					if(isset($revision[0]['start_timestamp'])) $dataa['rev_submission_time'] = $revision[0]['start_timestamp'];
					$this->rev_jobs_mail($dataa);
					
					return $rev_id;
					}else{
				// $this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Revision Not Submitted : '.$orderid.'-'.$this->db->_error_message().' !! </button>');
				$this->session->set_flashdata('message','Uh-oh! We faced an issue adding your revision to our database. It might be a temporary glitch, but if it continues, let our IT support team know. - Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.');
				redirect('new_client/home/dashboard');
			}
		}
	}
	
	public function order_pickup($orderid)
	{
		if(isset($_POST['print_pickup_submit']))
		{
		    $cacheid = $_POST['cacheid'];
			$adrep = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
			
			
			$advertiser = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
			
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
				
			 $order_details = array(
				'adrep_id' => $this->session->userdata('ncId'),
				'publication_id' => $adrep[0]['publication_id'],
				'help_desk' => $publication[0]['help_desk'],
				'group_id' => $publication[0]['group_id'],
				'order_type_id' =>  '2', 
				//'publication_name' => $_POST['publication_name'],
				//'job_instruction' => $_POST['job_instruction'],
				'print_ad_type' => $_POST['print_ad_type'],
				//'date_needed' => date('Y-m-d',strtotime($_POST['date_needed'])),
				//'job_no' => $_POST['job_no'],
				//'advertiser_name' => $_POST['advertiser_name'],
				'advertiser_name' => $advertiser,
				'job_no' => $job_number,
				'copy_content_description' => $_POST['copy_content_description'],
				'notes' => $_POST['notes'],
				'width' => $_POST['width'] ,
				'height' => $_POST['height'],
				//'size_inches' => $_POST['width'] * $_POST['height'] * 0.3937 ,
				'size_inches' => $_POST['width'] * $_POST['height'] ,
				'pickup_adno' => $orderid,
				'status' => '1',
				'publish_date' => $publish_date,
				'club_id'=> $publication[0]['club_id'],
				'activity_time' => date('Y-m-d h:i:s')
			); 
			
			$this->db->insert('orders', $order_details);
			$pickupid = $this->db->insert_id();
			
			if($pickupid){
				//Live_tracker updation
				$tracker_data = array(
					'pub_id'=> $publication[0]['id'],
					'order_id'=> $pickupid,
					'job_no' => $job_number,
					'club_id'=> $publication[0]['club_id'],
					'status' => '1'
				);
				$this->db->insert('live_orders', $tracker_data);
				
				$this->view($pickupid, true);
				$this->orders_folder($pickupid);
				
				/*********** move order cache to orders *************************************/
				$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
				if(isset($cache['id'])){
				    //updating order id to order_cache table
					$order_cache = array('order_id' =>$pickupid );
					$this->db->where('id', $cacheid);
					$this->db->update('order_cache', $order_cache);
						
				    $cache_file_path = $cache['file_path'];
					if(!empty($cache_file_path) && $cache_file_path != "none"){
						$cache_path = getcwd().'/'.$cache_file_path;
							
						//copying files from order_cache folder to downloads folder
						$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$pickupid'")->row_array();
						$order_file_path = $order_details['file_path'];
						$download_path = getcwd().'/'.$order_file_path;
							
						if(!empty($order_file_path) && $order_file_path != "none"){
							 if(is_dir($cache_path)){
								if($dh = opendir($cache_path)){
									while(($file = readdir($dh)) !== false){
										if($file== '.' || $file== '..') { continue; } 
										if(is_dir($cache_path.'/'.$file)) { continue; } //if mood board theme uploaded ignore Theme folder
										//copy($cache_path.'/'.$file, $download_path.'/'.$file);
										@rename($cache_path.'/'.$file, $download_path.'/'.$file);
									}
									closedir($dh);
								}
							} 
						}
							
						//Delete order_cache files
						if(isset($cache_path) && is_dir($cache_path)){
							    if(file_exists($cache_path.'/Theme')){
							        array_map('unlink', glob("$cache_path/Theme/*.*"));
							        rmdir($cache_path.'/Theme');  
							    }
							    array_map('unlink', glob("$cache_path/*.*"));
							    rmdir($cache_path);
						}
					}	
				}
				/***************move order annotation file from pickup_order_annotation folder to downloads****************/
				$pickup_order_annotation = 'pickup_order_annotation/'.$orderid.'.pdf';
				if(file_exists($pickup_order_annotation)){
				    $order_detail = $this->db->query("SELECT `file_path`, `job_no` FROM `orders` WHERE `id` = '$pickupid'")->row_array();
				    if(file_exists($order_detail['file_path'])){
				        @rename($pickup_order_annotation, $order_detail['file_path'].'/'.$order_detail['job_no'].'-PdfMarkup.pdf'); 
				    }
				}
				$this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID :  ".$pickupid."</p>");
				redirect('new_client/home/dashboard');
			}else{
				// $this->session->set_flashdata("message",$this->db->_error_message());
				$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
				redirect("new_client/home/dashboard");
			} 
		}
		
	}
	
	public function order_pickup_web($orderid)
	{
		
		if(isset($_POST['web_pickup_submit']))
		{
		    if(isset($_POST['cacheid'])) $cacheid = $_POST['cacheid'];
			$adrep = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
			$publication = $this->db->get_where('publications',array('id' => $adrep[0]['publication_id']))->result_array();
			
			$advertiser = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
			
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
			
			 $order_details = array(
				'adrep_id' => $this->session->userdata('ncId'),
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
				//'pixel_size' => $_POST['pixel_size'],
				//'custom_width' => $_POST['custom_width'],
				//'custom_height' => $_POST['custom_height'],
				'notes' => $_POST['notes'],
				'pickup_adno' => $orderid,
				'status' => '1',
				'publish_date' => $publish_date,
				'club_id'=> $publication[0]['club_id'],
				'activity_time' => date('Y-m-d h:i:s')
			); 
			
			$this->db->insert('orders', $order_details);
			$pickupid = $this->db->insert_id();
			
			
			if($pickupid){
			    /******************* size insertion*********************/
				    $count_size_id = 0; $count_custom = 0;
				    
        		    if(isset($_POST['size_id'])) $count_size_id = count($_POST['size_id']); 
        		    if(isset($_POST['custom_width'])) $count_custom = count($_POST['custom_width']) - 1;
        		    
        		    $total_size_count = $count_size_id + $count_custom;
        		    
        		    if($total_size_count > 1){  //multiple size insertion
        		        if(isset($_POST['size_id']) && !empty($_POST['size_id']) && $_POST['size_id'] != ''){
            		        //echo'Size Id- '.count($_POST['size_id']).'<br/>';
            		        foreach ($_POST['size_id'] as $size){ 
            		            $post_size = array('order_id' => $pickupid, 'size_id' => $size);
            		            $this->db->insert('orders_multiple_size', $post_size);
            		        }
            		        
            		    }
            		    //custom size
            		    if(isset($_POST['custom_width']) && isset($_POST['custom_height'])){
            		        //echo'<br/>Custom  Size - '.count($_POST['custom_width']).'<br/>';
            		        for ($i=1; $i < count($_POST['custom_width']); $i++){ 
            		            //echo $_POST['custom_width'][$i].'x'.$_POST['custom_height'][$i]."<br/>";
            		            $post_size = array('order_id' => $pickupid, 'custom_width' => $_POST['custom_width'][$i], 'custom_height' => $_POST['custom_height'][$i]);
            		            $this->db->insert('orders_multiple_custom_size', $post_size);
            		        }
            		    }
    				}else{
				        //if single size consider normal web ad
				        if(isset($_POST['size_id']) && !empty($_POST['size_id']) && $_POST['size_id'] != ''){
				            if($_POST['ad_format'] == 5){ //flexitive
				                $post_update = array( 'flexitive_size' => $_POST['size_id'][0] );
				            }else{  //pixel
				                $post_update = array( 'pixel_size' => $_POST['size_id'][0] );
				            }
				        }else{
				            $post_update = array(
				                            'pixel_size' => 'custom',
				                            'custom_width' => $_POST['custom_width'][1],
					                        'custom_height' => $_POST['custom_height'][1],
					                        );
				        }
				        $this->db->where('id', $pickupid);
					    $this->db->update('orders', $post_update);
				    }
				 /*******************END multiple size insertion*********************/
					//Live_tracker updation
						$tracker_data = array(
                    						'pub_id'=> $publication[0]['id'],
                    						'order_id'=> $pickupid,
                    						'job_no' => $job_number,
                    						'club_id'=> $publication[0]['club_id'],
                    						'status' => '1'
                    					);
						$this->db->insert('live_orders', $tracker_data);
					
				$this->view($pickupid, true);
				$this->orders_folder($pickupid);
				
				/*********** move order cache to orders *************************************/
				if(isset($cacheid)){
				$cache = $this->db->get_where('order_cache',array('id' => $cacheid))->row_array();
				if(isset($cache['id'])){
				    //updating order id to order_cache table
					$order_cache = array('order_id' =>$pickupid );
					$this->db->where('id', $cacheid);
					$this->db->update('order_cache', $order_cache);
						
				    $cache_file_path = $cache['file_path'];
					if(!empty($cache_file_path) && $cache_file_path != "none"){
						$cache_path = getcwd().'/'.$cache_file_path;
							
						//copying files from order_cache folder to downloads folder
						$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$pickupid'")->row_array();
						$order_file_path = $order_details['file_path'];
						$download_path = getcwd().'/'.$order_file_path;
							
						if(!empty($order_file_path) && $order_file_path != "none"){
							 if(is_dir($cache_path)){
								if($dh = opendir($cache_path)){
									while(($file = readdir($dh)) !== false){
										if($file== '.' || $file== '..') { continue; } 
										if(is_dir($cache_path.'/'.$file)) { continue; } //if mood board theme uploaded ignore Theme folder
										//copy($cache_path.'/'.$file, $download_path.'/'.$file);
										@rename($cache_path.'/'.$file, $download_path.'/'.$file);
									}
									closedir($dh);
								}
							} 
						}
							
						//Delete order_cache files
						if(isset($cache_path) && is_dir($cache_path)){
							    if(file_exists($cache_path.'/Theme')){
							        array_map('unlink', glob("$cache_path/Theme/*.*"));
							        rmdir($cache_path.'/Theme');  
							    }
							    array_map('unlink', glob("$cache_path/*.*"));
							    rmdir($cache_path);
						}
					}	
				}
			    }
				/***************move order annotation file from pickup_order_annotation folder to downloads****************/
				$pickup_order_annotation = 'pickup_order_annotation/'.$orderid.'.pdf';
				if(file_exists($pickup_order_annotation)){
				    $order_detail = $this->db->query("SELECT `file_path`,`job_no` FROM `orders` WHERE `id` = '$pickupid'")->row_array();
				    if(file_exists($order_detail['file_path'])){
				        @rename($pickup_order_annotation, $order_detail['file_path'].'/'.$order_detail['job_no'].'-PdfMarkup.pdf'); 
				    }
				}
				
				$this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID :  ".$pickupid."</p>");
				redirect('new_client/home/dashboard');
			}else{
				// $this->session->set_flashdata("message",$this->db->_error_message());
				$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
				redirect("new_client/home/dashboard");
			}
		}
		
	}
	
	public function additional_att($id='')
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		$data['order'] = $order;
		if(isset($order[0]['id'])){
		    $rev_id = 0;
			$rev_details = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$id' ORDER BY `id` DESC")->result_array();
			if($rev_details){
			    $rev_id = $rev_details[0]['id'];
				$path = $rev_details[0]['file_path'];
				
				if($path == 'none'){    //if file_path is none create directory
				    //folder creation
				   	$path = "revision_downloads/".$id.'-'.$rev_id; 
					if (@mkdir($path,0777))	{}
					//save path
					$post = array('file_path' => $path);
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post);   
				}
			}else{
				$path = $order[0]['file_path'];
				
				if($path == 'none'){    //if file_path is none create directory
				    $jname = $order[0]['job_no'];
    	            $path = "downloads/".$id."-".$jname; //path specification
    			    if (@mkdir($path,0777)){}
    			
    			    //save path
    				$post = array('file_path' => $path);
    				$this->db->where('id', $id);
    				$this->db->update('orders', $post);
				}
			}
		
    		//$data['order'] = $this->db->get_where('orders',array('id' => $id))->result_array();
    		
    		//Uploading files
    		if (!empty($_FILES)) {
    				//$path = $data['order'][0]['file_path'];
    				//if (@mkdir($path,0777)){}
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
    		    $filename[] = '';
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
    						    $lastmodified = date("F d Y",filemtime(mb_convert_encoding($path."/".$file,'ISO-8859-1', 'UTF-8')));
    							//$lastmodified = date("F d Y",filemtime(utf8_decode($path."/".$file)));
    							if($lastmodified == $datecheck)
    							{ $filename[] = $file;}
    						}	}
    						closedir($dh);
    					}
    					$data['filename'] = $filename;
    				} 
    			}
    			$this->additional_att_view($data, $id, true);
    			//insert additional instructions
    			if(isset($_POST['notes']) && !empty($_POST['notes']) && strlen($_POST['notes']) != 0){
    			   $post_note = array('order_id' => $id, 'revision_id' => $rev_id, 'instructions' => $_POST['notes']); 
    			   $this->db->insert('orders_additional_instruction', $post_note);
    			   
    			   //html file update
                    $html_file = $order[0]['file_path'].'/'.$order[0]['job_no'].'.html';
                    if(file_exists($html_file)){
                        $fh = fopen($html_file, 'a') or die("can't open file");
                        if($order[0]['order_type_id'] == '2'){
                            $content ='<div class="row"><div class="col-md-12 pb-6 pt-2 ps-4 pe-4">
                                            <div class="border border-radius-4 mt-5">
													<div class="order-head fw-bolder ">
														Additional Instructions
													</div>
												   <div class="row">
													   <div class="col-md-12 ps-6 pt-6 pb-6">
														  <p>'.$_POST['notes'].'</p>
														</div>
												   </div>
												</div></div></div>';
                        }else{
                            $content = '<div>
                                        <table>
                                            <tr style="background-color:#eee; vertical-align: top;">
                                                <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;"><b>Additional Instructions</b></p></td>
                                            </tr>
                                            <tr style="background-color:#eee; vertical-align: top;">
                                                <td colspan="4" align="center">
                                                    <p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
                                                    '.$_POST['notes'].'
                                            		</p>
                                            	</td>
                                            </tr> 
                                        </table>
                                    </div>';
                        }
                        fwrite($fh, $content);
        				fclose($fh);
                    }
    			}
    		}
		}
		redirect('new_client/home/dashboard');
	}
	
	public function order_cancel($order_id = '', $type='normal')
	{
		$order = $this->db->get_where('orders', array('id' => $order_id))->result_array();
		if(isset($order[0]['id']) && isset($_POST['remove'])){
			$post = array('cancel' => '1', 'crequest' => '0', 'status' => '6');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post);
			
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
			    $this->db->query("DELETE FROM `live_orders` WHERE `id`= '".$update_order['id']."'");
			}
			
						
			//orders_cancel
			$orders_cancel = $this->db->query("SELECT * FROM `orders_cancel` WHERE `order_id`='$order_id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($orders_cancel){
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('adrep' => $this->session->userdata('ncId'), 'Atimestamp' => $timestamp);
				$this->db->where('id', $orders_cancel[0]['id']);
				$this->db->update('orders_cancel', $post_cancel);
			}else{
				//if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/Chicago');}
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('order_id' => $order_id, 'adrep' => $this->session->userdata('ncId'), 'Atimestamp' => $timestamp);
				$this->db->insert('orders_cancel', $post_cancel);
			}
			$this->session->set_flashdata("message","Order Cancellation for $order_id Submitted!!");
			if($type == 'pagination'){
			    redirect('new_client/home/page_new_dashboard');
			}else{
			    redirect('new_client/home/dashboard');
			}
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
					$post_status = array('question' => '2','activity_time' => date('Y-m-d h:i:s'));
					$this->db->where('id', $id);
					$this->db->update('orders', $post_status); 
					
					//orders_Q_A
					
					$timestamp = date('Y-m-d H:i:s');
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('ncId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//Live_tracker Updation
					$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('question' => '2');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
					
					//send mail 
					$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
					if($client){
						$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
						$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						if($order[0]['order_type_id'] == '6'){
						    $dataa['from'] = 'pagination@adwitads.com';
						    $dataa['replyTo'] = 'pagination@adwitads.com';
						}else{
						    $dataa['from'] = $design_team[0]['email_id']; 
						    $dataa['replyTo'] = $design_team[0]['email_id'];
						} 
						
						$dataa['from_display'] = 'Design Team';
						
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
					if($order[0]['order_type_id'] == '6'){
					    redirect('new_client/home/page_new_dashboard');
					}else{
					    redirect('new_client/home/dashboard');
					}
				}
	   
				$data['question'] = $question[0];//cat_result 
				$this->load->view('new_client/ad_answer', $data);
			}else{
			   if($order[0]['order_type_id'] == '6'){
				    redirect('new_client/home/page_new_dashboard');
				}else{
				    redirect('new_client/home/dashboard');
				}
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
					
					//orders activity_time updation
					$post1 = array('activity_time' => date('Y-m-d h:i:s') );
					$this->db->where('id',$rev_order[0]['order_id']);
					$this->db->update('orders', $post1);
						
					//orders_Q_A
					$timestamp = date('Y-m-d H:i:s');
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('ncId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//send mail 
					 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
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
					redirect('new_client/home/dashboard');
				}
				$data['rev_sold_jobs'] = $rev_order; //revision
		
				$data['question'] = $question[0];
				$this->load->view('new_client/ad_answer', $data);
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
				$post_cancel = array('adrep' => $this->session->userdata('ncId'), 'Rreason' => $_POST['reason'], 'Atimestamp' => $timestamp);
				$this->db->where('id', $_POST['id']);
				$this->db->update('orders_cancel', $post_cancel);
				
				//Live_tracker Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
				if(isset($update_order['id'])){
					$tracker_data = array('crequest' => '0');
					$this->db->where('id', $update_order['id']);
					$this->db->update('live_orders', $tracker_data);
				}
				
				//send mail
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				if($client)
				{
					
					$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					if($order[0]['order_type_id'] == '6'){
					    $dataa['from'] = 'pagination@adwitads.com';
					    $dataa['replyTo'] = 'pagination@adwitads.com';
					}else{
					    $dataa['from'] = $design_team[0]['email_id'];
					    $dataa['replyTo'] = $design_team[0]['email_id'];
					}
					$dataa['from_display'] = 'Design Team';

					

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
				if($order[0]['order_type_id'] == '6'){
				    redirect('new_client/home/page_new_dashboard');
				}else{
				    redirect('new_client/home/dashboard');
				}
			}else{
				$data['orders_cancel'] = $this->db->get_where('orders_cancel',array('order_id' => $order_id))->result_array();
				$data['order'] = $order[0];
			}
			
			$this->load->view('new_client/reject_v2',$data);
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
		//$order_details = $this->db->get_where('orders', array('id' => $order, 'status'=>'5', 'pdf !=' => 'none'))->result_array();
		$order_details = $this->db->get_where('orders', array('id' => $order, 'pdf !=' => 'none'))->result_array();
		$pub_permit = array(48, 49, 45, 50, 58, 62, 408, 61, 63, 59, 60, 13); //Aprove ad popup allowed publications
		$output = '';
		if(isset($order_details[0]['id'])){ 
		    $publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
			
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order' ORDER BY `id` DESC LIMIT 1")->row_array();
			
			$client = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->result_array();
			if($orders_rev){
				$filename = $orders_rev['pdf_path'];
				$rev_id = $orders_rev['id'];
				$rev_approve = $orders_rev['approve'];
				
				if($rev_approve=='0'){
					$post = array('approve'=>'1', 'status'=>'9');
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post);
					
					//update rev status in orders table
					$order_rev_status_update = array('rev_order_status' => '9');
					$this->db->where('id', $order);
					$this->db->update('orders', $order_rev_status_update);
					
					//Live_tracker Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$rev_id."' ")->row_array();
					if(isset($update_revision['id'])){
						$tracker_data = array('status' => '9');
						$this->db->where('id', $update_revision['id']);
						$this->db->update('live_revisions', $tracker_data);
					}
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
					
				//Live_tracker Updation
				$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_details[0]['id']."' ")->row_array();
				if(isset($update_order['id'])){
					$tracker_data = array('status' => '7');
					$this->db->where('id', $update_order['id']);
					$this->db->update('live_orders', $tracker_data);
				}	
					
				} 
			}
			$activity_data = array('activity_time' => date('Y-m-d h:i:s'));
		    $this->db->where('id', $order);
			$this->db->update('orders', $activity_data);
			$ftp_server = 'none';
			//ftp upload
			if($order_details[0]['publication_id']=='41'){	//Estevan Mercury
				$ftp_server = 'ftp.adwitads.com';
				$ftp_username='estevanmercury@adwitads.com';
				$ftp_userpass='ftp@123';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='43'){	//Desert shoppers
				$ftp_server = '76.79.110.53';
				$ftp_username='adwit';
				$ftp_userpass='DisplayAd5';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='47'){		//Imperial valley press
				$ftp_server = '12.147.19.253';
				$ftp_username='adwit';
				$ftp_userpass='!VPr3$$123';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='580'){ //Waukesha Freeman
			    $ftp_server = 'ftp.adwitads.com';
				$ftp_username='wfp@adwitads.com';
				$ftp_userpass='adwit@123';
				$folder_name = 'PDF/';
			}elseif(in_array($order_details[0]['publication_id'], $pub_permit)){   //Medicinehatnews lethbridge herald, taber times etc..
			    $ftp_server = 'ftp.medicinehatnews.com';
				$ftp_username= 'adwit';
				$ftp_userpass= '!QaZxsw@';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='206'){	//The pilot news
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
				$dataa['recipient'] = $this->session->userdata('ncEmail');
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}elseif($order_details[0]['publication_id']=='27'){ //Yuma sun
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
			}elseif($order_details[0]['publication_id']=='451'){ //Yuma sun
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
				
				$dataa['recipient'] = 'sales@thechronicle.com';
				//$dataa['Cc'] = 'webmaster@adwitads.com';
				
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}elseif($order_details[0]['publication_id']=='190'){ //VIDN
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Approved  Order';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';

				$dataa['subject'] = $order_details[0]['id'].' - '.$jname.' - '.$order_details[0]['publication_name'] ;
				$dataa['body'] = 'Hi '.$client[0]['first_name'].' '.$client[0]['last_name'].',<br/><br/>Attached is the approved Hi-Res PDF for Unique Job Name : '.$jname.' with AdwitAds ID : '.$order.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				//Design Team
				
				$dataa['recipient'] = $this->session->userdata('ncEmail');
				
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}elseif($order_details[0]['publication_id']=='538'){ //glacier
				$ftp_server = '115.248.71.109';
				$ftp_username='annexe2017';
				$ftp_userpass='ftp@123';
				$folder_name = 'test-pdf/';
			}else{
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Approved  Order';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';

				$dataa['subject'] = $order_details[0]['id'].' - '.$jname.' - '.$order_details[0]['publication_name'] ;
				$dataa['body'] = 'Hi '.$client[0]['first_name'].' '.$client[0]['last_name'].',<br/><br/>Attached is the approved Hi-Res PDF for Unique Job Name : '.$jname.' with AdwitAds ID : '.$order.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				if($order_details[0]['publication_id']=='428'){ //publication- New Britain/Bristol - Central Communications
				    $dataa['recipient'] = 'artdept@centralctcommunications.com';   
				}else{
				    $dataa['recipient'] = $this->session->userdata('ncEmail');
				}
				$dataa['filename'] = $filename;
				
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}
			if($ftp_server != 'none'){
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
				
				ftp_pasv($ftp_conn, true);
				
				$file = $filename;
				$path_parts = pathinfo($file);
				$fname = $order_details[0]['job_no'].'.pdf';
				
				// upload file
				if(in_array($order_details[0]['publication_id'], $pub_permit)){    //lethbridge herald, taber times etc..
				    if(isset($_POST['pub'])){
				       $pcount = count($_POST['pub']);
				       $job_name = strtok($order_details[0]['job_no'], " "); //consider char only before first space
				       $advertiser_name = preg_replace('/[^A-Za-z0-9\-]/', '', $order_details[0]['advertiser_name']); // Removes special chars.
				       if($pcount > 0){
    				       for($i=0; $i<$pcount; $i++){
    				            $pub = $_POST['pub'][$i];
    				            $fname = $pub.''.$job_name.''.$advertiser_name.'.pdf';
    				            if (ftp_put($ftp_conn, $folder_name.$fname, $file, FTP_BINARY)){
                					$output .= "<br/>Successfully uploaded $fname.";
                				}else{
                					$output .= "<br/>Error uploading $fname .";
                				}
    				       }
				       }
				    }
				    // close connection
				    ftp_close($ftp_conn);
				    $this->session->set_flashdata('message', $output);
				    redirect('new_client/home/dashboard');
				}else{
    				if (ftp_put($ftp_conn, $folder_name.$fname, $file, FTP_BINARY)){
    					echo "Successfully uploaded $fname.";
    				}else{
    					echo "Error uploading $fname .";
    				}
				}
				// close connection
				ftp_close($ftp_conn);
			}
		}else{
		   // $this->session->set_flashdata('message', "Approved");
		    redirect('new_client/home/dashboard');
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
        	    
        if(isset($dataa['filename']) && isset($dataa['fname'])){
        	 $this->email->attach($dataa['filename'], $dataa['fname']); 
        }elseif(isset($dataa['filename'])){
        	 $this->email->attach($dataa['filename']);
        }
        	    
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function unapprove_order($order = '')
	{
		$order_details = $this->db->get_where('orders',array('id' => $order))->result_array();
		if(isset($order_details[0]['id'])){
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order' ORDER BY `id` DESC LIMIT 1")->row_array();
			if($orders_rev){
				if($orders_rev['approve']=='1' || $orders_rev['status']=='9'){
					$post = array('approve'=>'0', 'status'=>'5');
					$this->db->where('id', $orders_rev['id']);
					$this->db->update('rev_sold_jobs', $post); 
					
					//update rev status in orders table
            		$order_rev_status_update = array('rev_order_status' => '5');
            		$this->db->where('id', $order);
            		$this->db->update('orders', $order_rev_status_update);
					
					//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$orders_rev['id']."' ")->row_array();
					if(isset($update_revision['id'])){
						$this->db->query("DELETE FROM `live_revisions` WHERE `id`= '".$update_revision['id']."'");
					}
							
				}
			}elseif($order_details[0]['status']=='7'){
				$post = array('approve'=>'0', 'status'=>'5');
				$this->db->where('id', $order_details[0]['id']);
				$this->db->update('orders', $post);
				
				//Live_tracker Updation
					$update_orders = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_details[0]['id']."' ")->row_array();
					if(isset($update_orders['id'])){
						$this->db->query("DELETE FROM `live_orders` WHERE `id`= '".$update_orders['id']."'");
					}
				
			}
		}
		redirect('new_client/home/dashboard');
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
			if(isset($cat_result[0]['id'])){
			$data['cat_result'] = $cat_result;
			if(($order[0]['status']=='5' || $order[0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
				$data['slug'] = $cat_result[0]['slug'];
				$sourcefilepath = $cat_result[0]['source_path'];
				$data['sourcefilepath'] = $sourcefilepath;
			}}
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC;")->result_array();
			$data['orders_rev'] = $orders_rev;
			$first_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` LIMIT 1;")->result_array();
						if(isset($first_rev[0]['id']))
					{	$data['$first_rev'] = $first_rev; }
		
            if($orders_rev){
					$last_orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' AND `status`='5' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
					if(isset($last_orders_rev[0]['id']))
					{	$data['$last_orders_rev'] = $last_orders_rev; }
					$first_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` LIMIT 1;")->result_array();
						if(isset($first_rev[0]['id']))
					{	$data['$first_rev'] = $first_rev; }
				
					if(isset($last_orders_rev[0]['id']))
					{	$data['latest'] = $last_orders_rev; }
					elseif(isset($first_rev[0]['id']))
					{	$data['latest'] = $first_rev; }
			}



			//ftp sourceFile path
			if($cat_result && $cat_result[0]['ftp_source_path']!=''){ 
				$data['ftp_source_path'] = $cat_result[0]['ftp_source_path']; 
			}
			
			$data['client'] = $this->db->query("SELECT `page` FROM `adreps` WHERE `id` = '".$this->session->userdata('ncId')."'")->row_array();
			
			$this->load->view('new_client/revision_details', $data);
		}
	}
	
	public function additional_att_view($data, $id = 0, $email = false)
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
				$this->load->view('new_client/dashboard');
			}else{
			    $data = array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
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
				$data['recipient'] = $design_team[0]['email_id'];
				$data['recipient_display'] = 'Design Team';
				$data['ad_recipient'] = '';
				$data['ad_recipient_display'] = '';
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
		
		$this->email->attach($data['attachment'],'file.jpg'); //php 8.0  stream_get_contents(): Read of 8192 bytes failed with errno=21 Is a directory
		
		if(isset($data['ad_recipient']) && !empty($data['ad_recipient'])){ $this->email->cc(array($data['ad_recipient'])); }
		
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
		//if($this->session->userdata('ncId') == 36 || $dataa['orders']['publication_id'] == '3' || $dataa['orders']['group_id'] == '18'){ //coast news group
		    $this->email->subject("Revision Confirmation - ".$dataa['orders']['id']." - ".$dataa['orders']['advertiser_name']." - ".$dataa['orders']['job_no']);
		    $this->email->message($this->load->view('email_template/RevisionConfirmation',$dataa, TRUE));
	/*	}else{		
		    $this->email->message($dataa['body']);
		}*/		
		$this->email->set_alt_message("Unable to load text!");
				
		$this->email->to($dataa['recipient']);
				
		$this->email->cc($dataa['ad_recipient']);
        	    
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function view_uploaded_files($orderid='0', $action_id='0')
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
		$data['order_details'] = $order_details;
		$data['action_id'] = $action_id;
		if($order_details){
			$rev_details = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$orderid' ORDER BY `id` DESC")->result_array();
			if($rev_details){
				$file_path = $rev_details[0]['file_path'];
			}else{
				$file_path = $order_details[0]['file_path'];
			}
			
		
			    if($file_path != 'none'){ //to display download file list in view uploaded file tab
			        if($order_details[0]['order_type_id'] == '6' && !isset($rev_details[0]['file_path'])){ //only for pagination new ads
			            $order_files = array();
			            $articles_path = $file_path.'/articles';
            			$ads_path = $file_path.'/ads';
            				        if(file_exists($articles_path) && $atp = opendir($articles_path)){
            				            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
                        				{
                        					if ($file == '.' || $file == '..'){  continue; }
                        					if($file){ $order_files[]=$articles_path.'/'.$file; }
                        				}
                        				closedir($atp);//dirctry $atp clocsed
                        			}
                        			if(file_exists($ads_path) && $atp = opendir($ads_path)){
                        			    while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
                        				{
                        					if ($file == '.' || $file == '..'){  continue; }
                        					if($file){ $order_files[]=$ads_path.'/'.$file; }
                        				}
                        				closedir($atp);//dirctry $atp clocsed
                        			}
                        			$data['file_names'] = $order_files;
			        }else{
						if(is_dir($file_path)){
							if($dh = opendir($file_path)){
								while(($file = readdir($dh)) !== false) {
								    $ext = pathinfo($file, PATHINFO_EXTENSION);
								    if($ext != 'xml'){ //restrict ogden xml file display
        								if($file == '.' || $file == '..'){ continue; }
        								if($file){ $filename[] = $file_path.'/'.$file; }
        								$data['file_names'] = $filename;
        								$data['file_path'] = $file_path;
								    }
								}
								closedir($dh);
							}
						}
			        }
				}
			}
			$this->load->view('new_client/order_action',$data);
			
	}
	
	public function rev_remove_att($orderid, $filename)
	{ 
		$order_details = $this->db->query("SELECT orders.id, rev_sold_jobs.file_path FROM orders
											JOIN rev_sold_jobs ON rev_sold_jobs.order_id = orders.id 
											WHERE orders.id = '$orderid'")->row_array();
		if(isset($order_details['file_path']) && $order_details['file_path'] != 'none'){
			$filepath = $order_details['file_path'];
			$dirhandle = opendir($filepath);
			while ($file = readdir($dirhandle)) { 
				if($file==$filename){ unlink($filepath.'/'.$filename); }
			}
		}
	}
	
	public function zzip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			$SourceFilePath = $_POST['source_path'] ;
			$source_file = $_POST['source_file'];
			$pdf_file = $new_slug.'.pdf';
			$idml_file = $new_slug.'.idml';
			
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			$idml_path =  $SourceFilePath.'/'.$idml_file;
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}//else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
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
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}
	
	public function profile()
	{
		
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
		$design_team = $this->db->get_where('design_teams',array('id'=>$publication[0]['design_team_id']))->result_array();
		if($adrep_details[0]['team_orders']=='1'){
			$data['orders_count'] = $this->db->get_where('orders',array('publication_id' => $publication[0]['id']))->num_rows();
		}else{
			$data['orders_count'] = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('ncId')))->num_rows();
		}
		/*
		if($publication[0]['enable_source']=='1'){
			$size_bytes = $this->storage_space();
			$data['storage_space'] = $this->formatSizeUnits($size_bytes);
		}
		*/
		$data['adrep_details'] = $adrep_details;
		$data['publication'] = $publication;
		$data['design_team'] = $design_team;
		
		if(isset($_POST['gender_submit']))
		{
			$this->db->query("Update adreps set gender='".$this->input->post('gender')."' where (id='".$this->session->userdata('ncId')."') ");
			redirect('new_client/home/profile');
		}
		if(isset($_POST['submit_phone']))
		{
			$this->db->query("Update adreps set phone_1='".$this->input->post('phone')."' where (id='".$this->session->userdata('ncId')."') ");
			redirect('new_client/home/profile');
		}
		
		if(isset($_POST['address_submit']))
		{
			$this->db->query("Update adreps set address='".$this->input->post('address')."' where (id='".$this->session->userdata('ncId')."') ");
			redirect('new_client/home/profile');
		}
		
		if(isset($_POST['submit_pwd']))
		{
			$this->db->query("Update adreps set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('ncEmail')."' or username='".$this->session->userdata('client')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
			if($this->db->affected_rows())
				$data['pwd_success'] = "success";
			else
				$data['invalid_pwd'] = "Invalid";
		}
		if(isset($_POST['img_upload']))
		{
			$uploadDir = "images/adreps/".$this->session->userdata('ncId')."/";
		
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
				$this->db->where('id', $this->session->userdata('ncId'));
				$this->db->update('adreps', $data); 
				redirect('new_client/home/profile');
				}else{ $data['error']= "Invalid file type";}
		
		}
		$data['migrate_adrep_list'] = $this->db->query("SELECT id, first_name, last_name FROM `adreps` WHERE `id` != '".$this->session->userdata('ncId')."' AND `is_active` = '1' ORDER BY first_name ASC")->result_array();
		$this->load->view('new_client/profile',$data);
	}
// to calculate storage space START	
	public function storage_space()
	{	
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->row_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details['publication_id']))->row_array();
		$q = "SELECT orders.id, orders.file_path, orders.pdf, cat_result.id AS catId, cat_result.source_path FROM `orders`
		        JOIN `cat_result` ON orders.id = cat_result.order_no";
		if($adrep_details['team_orders']=='1'){
			$q .= " WHERE orders.publication_id = '".$publication['id']."' AND orders.pdf != 'none'";
			$orders = $this->db->query("$q")->result_array();
		}else{
			$q .= " WHERE orders.adrep_id = '".$this->session->userdata('ncId')."' AND orders.pdf != 'none'";
			$orders = $this->db->query("$q")->result_array();
		}
		//echo $q;
		$total_space = '0'; $d_tot_size = '0'; $s_tot_size = '0'; $p_tot_size = '0';
		
		foreach($orders as $row_order){ 
			$downloads = $row_order['file_path'];
			if(isset($row_order['catId'])){ 
				$source = $row_order['source_path'];
			}
			$pdf = $row_order['pdf'];	
			//Downloads folder
			if($downloads != 'none' && file_exists($downloads)){
				$d_tot_size = $d_tot_size + $this->GetDirectorySize($downloads);
			}
			clearstatcache();
			//Source file folder
			if(isset($source) && file_exists($source)){ 
			    $s_tot_size = $s_tot_size+ $this->GetDirectorySize($source);
			}
			clearstatcache();
			//pdf_uploads folder
			if(file_exists($pdf)){ 
				$p_size = '0';
				$p_size = filesize($pdf); 
				$p_tot_size = $p_tot_size + $p_size;
			}
		} 
		$total_space = $d_tot_size + $s_tot_size + $p_tot_size;
		$total_space = number_format($total_space / 1048576, 2) . ' MB';
		//echo $total_space;
		return $total_space;
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
    
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
// to calculate storage space END
	public function notification()
	{
		$data['hi'] = 'hello';
		$notifications = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1'")->result_array();
		$ncId = $this->session->userdata('ncId');
		$client = $this->db->get_where('adreps',array('id' => $ncId))->row_array();
		$notification_list = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1' AND (`adrep`='$ncId' OR `publication`='".$client['publication_id']."') ORDER BY `id` DESC")->result_array();
		if(isset($notification_list[0]['id'])){ $data['notification_list'] = $notification_list; }
		$this->load->view('new_client/notification', $data);
	}
	
	public function faq()
	{
		$this->load->view('new_client/faq');
	}
	
	public function help()
	{
		$adrep_details = $this->db->get_where('adreps',array('id'=>$this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
		$design_team = $this->db->get_where('design_teams',array('id'=>$publication[0]['design_team_id']))->result_array();
		$data['design_team'] = $design_team;
		$this->load->view('new_client/help',$data);
	}
	
	public function templates()
    {
        $data['hi'] = 'hello'; 
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $this->input->get('id');
            $keywords = explode(' ', $id);
            
            $rowsPerPage = 12; 
            $num = $_GET['num'];  
            $offset = ($num - 1) * $rowsPerPage; 
            //where statments
            
            $id_where = "`id` LIKE '%" . implode("%' AND `id` LIKE '%", $keywords) . "%'";
            $job_no_where = "`job_no` LIKE '%" . implode("%' AND `job_no` LIKE '%", $keywords) . "%'";  
            $advertiser_name_where = "`advertiser_name` LIKE '%" . implode("%' AND `advertiser_name` LIKE '%", $keywords) . "%'";     
            $copy_content_description_where = "`copy_content_description` LIKE '%" . implode("%' AND `copy_content_description` LIKE '%", $keywords) . "%'"; 
            $notes_where = "`notes` LIKE '%" . implode("%' AND `notes` LIKE '%", $keywords) . "%'";
        
            $sql = "SELECT * FROM `orders`
                    WHERE `pdf` != 'none' AND ( ({$id_where})
                    OR ({$job_no_where}) 
                    OR ({$advertiser_name_where})             
                    OR ({$copy_content_description_where})
                    OR ({$notes_where}) ) ORDER BY `id` DESC LIMIT $offset, $rowsPerPage";
            
            $orders = $this->db->query($sql)->result_array();
            
            //$orders = $this->db->query("SELECT * FROM `orders` WHERE `pdf` != 'none' AND (`id` LIKE '%$id%' OR `job_no` LIKE '%$id%' OR `advertiser_name` LIKE '%$id%' OR `copy_content_description` LIKE '%$id%' OR `notes` LIKE '%$id%') ORDER BY `id` DESC LIMIT $offset, $rowsPerPage")->result_array();
            
            if(isset($orders[0]['id'])){
                $data['orders'] = $orders;
            }else{
                $this->session->set_flashdata('message','Oops! We couldn\'t locate an order with the provided OrderID. Please double-check and try again.');
                redirect('new_client/home/templates');
            }
            $data['id'] = $id;
            $data['num'] = $num;
        }
        $this->load->view('new_client/templates', $data);
    }
	
	public function add_tag()
	{
		if(isset($_POST['tags']) && !empty($_POST['tags'])){ 
			$tags = str_replace(', ',',',$_POST['tags']);
			$temp = array();
			$temp = explode(",", $tags);
			$ct = count($temp);
			for($i=0; $i<$ct; $i++){
				$this->db->where('title', $temp[$i]);
				$query = $this->db->get('tags', 1);
				if($query->num_rows() == 0){
					//$slug = str_replace(' ','_',$temp[$i]);
					$post = array('title'=>$temp[$i]);	
					$this->db->insert('tags', $post);
					$tag_id= $this->db->insert_id();
					//order_tags
					$data = array('order_id'=>$_POST['id'], 'tag_id'=>$tag_id);
					$this->db->insert('order_tags', $data);
				}elseif($query->num_rows() > 0){
					$result = $query->result_array();
					//order_tags
					$order_tags = $this->db->get_where('order_tags',array('order_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']))->row_array();
					if(!isset($order_tags['id'])){
						$data = array('order_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']);
						$this->db->insert('order_tags', $data);
						
					}
				}
			}
			$order_tags = $this->db->get_where('order_tags',array('order_id'=>$_POST['id']))->result_array(); 
			foreach($order_tags as $row_tag){
				$tag = $this->db->get_where('tags',array('id'=>$row_tag['tag_id']))->row_array();
				echo $tag['title'].' ';	
			}
		}
		
	}
	
	public function about()
	{
		$this->load->view('new_client/about');
	}
	
	public function contact_us()
	{
		$this->load->view('new_client/contact_us');
	}
	
	public function terms_of_use()
	{
		$this->load->view('new_client/terms_of_use');
	}
	
	public function privacy_policy()
	{
		$this->load->view('new_client/privacy_policy');
	}
	
	/*public function vidn_form($type = 'new')
	{
		
		if(!isset($_POST['vidn_id'])){
			$vidn_order = $this->db->query("SELECT * FROM `vidn_orders` WHERE `adrep_id`='".$this->session->userdata('ncId')."' AND `vidn_type`='$type' AND `job_no`='' ")->row_array();
			if(isset($vidn_order['id'])){
				$vidn_id = $vidn_order['id'];
			}else{
				$data = array(
				'adrep_id' => $this->session->userdata('ncId'),
				'vidn_type' => $type,
				);
				$this->db->insert('vidn_orders', $data);
				$vidn_id = $this->db->insert_id();
			}
			$data['vidn_id'] = $vidn_id;
		}else{
			$vidn_id = $_POST['vidn_id'];
			$data['vidn_id'] = $vidn_id;
		}
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('width', 'Width', 'trim|is_numeric|greater_than[0]');
			$this->form_validation->set_rules('height', 'Height', 'trim|is_numeric|greater_than[0]');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim');
			
		if ($this->form_validation->run() == FALSE){
			$data['type'] = $type;
			//$data['num_errors'] = $this->form_validation->error_count();
			$this->load->view('new_client/vidn_form',$data);
		}else{	
			if(isset($_POST['submit']) || isset($_POST['without_file_submit']))
			{
				if(!isset($_POST['advertiser_name'])) $_POST['advertiser_name']='';
				if(!isset($_POST['width'])) $_POST['width']='0';
				if(!isset($_POST['height'])) $_POST['height']='0';
				if(!isset($_POST['print_ad_type'])) $_POST['print_ad_type']='0';
				 $post = array( 
							'adrep_id' =>$this->session->userdata('ncId'),
							'vidn_type' => $type,
							'advertiser_name' => $_POST['advertiser_name'],
							'job_no' => $_POST['job_no'],
							'copy_content_description' => $_POST['copy_content_description'],
							'width' => $_POST['width'],
							'height' => $_POST['height'],
							'print_ad_type' => $_POST['print_ad_type'],
						);
				$this->db->where('id', $vidn_id);
				$this->db->update('vidn_orders', $post);
				
				if($this->db->affected_rows()){
					redirect("new_client/home");
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect("new_client/home/vidn_form");
				}  
				
			}
		}
	}
	*/
	
	public function vidn_form()
	{
		if(!isset($_POST['cacheid']))
		{	
			$data = array(
			'adrep_id' => $this->session->userdata('ncId'),
			'order_type_id' => '2',
			);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}else{
			$cacheid = $_POST['cacheid'];
			$data['cacheid'] = $_POST['cacheid'];
		}
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = 	$publication[0];
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
				$this->form_validation->set_rules('width', 'Width', 'trim|is_numeric|required|greater_than[0]');
				$this->form_validation->set_rules('height', 'Height', 'trim|is_numeric|required|greater_than[0]');
		
			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			
			
		if ($this->form_validation->run() == FALSE){
			$data['num_errors'] = $this->form_validation->error_count();
			$this->load->view('new_client/vidn_form',$data);
		}else{	
			if(isset($_POST['submit']) || isset($_POST['without_file_submit']))
			{
				if(empty($_POST['print_ad_type'])){ $_POST['print_ad_type']='0'; }
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				$width = $_POST['width'];
				$height = $_POST['height'];
				
				if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				}else{
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
			
				 $data = array( 
							'adrep_id' =>$this->session->userdata('ncId'),
							'publication_id' => $publication[0]['id'],
							'group_id' => $publication[0]['group_id'],
							'help_desk' => $publication[0]['help_desk'],
							'order_type_id' => '2',
							'size_inches' => $width * $height,
							'advertiser_name' => $advertiser,
							'job_no' => $job_number,
							'copy_content_description' => $_POST['copy_content_description'],
							'width' => $width,
							'height' => $height,
							'print_ad_type' => $_POST['print_ad_type'],
							'publish_date' => $publish_date,
							'club_id'=> $publication[0]['club_id']
						); 
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				
				
				if($orderid){
					//Live_tracker updation
					
					$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id'=> $orderid,
						'job_no' => $job_number,
						'club_id'=> $publication[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
					//$this->order_filemove($orderid, $cacheid);
					//updating order id to order_cache table
					$order_cache = array('order_id' =>$orderid );
					$this->db->where('id', $cacheid);
					$this->db->update('order_cache', $order_cache);
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->result_array();
					if($cache[0]['file_path'] != ""){
						$cache_path = getcwd().'/'.$cache[0]['file_path'];
						//Uploading files
						$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
						 $download_path = getcwd().'/'.$order_details[0]['file_path'];
						
						if($download_path != " "){
							 if(is_dir($cache_path)){
								if($dh = opendir($cache_path)){
									while(($file = readdir($dh)) !== false){
										if($file== '.' || $file== '..') { continue; } 
										//copy($cache_path.'/'.$file,$download_path.'/'.$file);
										@rename($cache_path.'/'.$file, $download_path.'/'.$file);
									}
									closedir($dh);
								}
							} 
						}
					}
					redirect("new_client/home/dashboard");
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/vidn_form");
				}  
				
			}
		}
	}
		
	public function order_fileupload($cacheid)
	{
		if(!empty($_FILES)) {
			$download_path = 'order_cache/'.$cacheid;//path
			if (@mkdir($download_path,0777)){} //folder creation
			$data = array('file_path'=>$download_path);
			$this->db->where('id',$cacheid);
			$this->db->update('order_cache',$data);
			
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$download_path.'/';
				$targetFile = $targetPath . $fileName ;
				if(!move_uploaded_file($tempFile, $targetFile)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					redirect('new_client/home/home');
				}else{ $data['file_sucess']="file sucessful!!"; }
		} 
	}
	
	public function vidn_order_fileupload($cacheid)
	{
		if(!empty($_FILES)) {
			$download_path = 'vidn_files/'.$cacheid;//path
			if (@mkdir($download_path,0777)){} //folder creation
			$data = array('file_path'=>$download_path);
			$this->db->where('id',$cacheid);
			$this->db->update('vidn_orders',$data);
			
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$download_path.'/';
				$targetFile = $targetPath . $fileName ;
				if(!move_uploaded_file($tempFile, $targetFile)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					redirect('new_client/home/home');
				}else{ $data['file_sucess']="file sucessful!!"; }
		} 
	}
	
    public function approval($order_id = 0)
	{
		$order_details = $this->db->get_where('orders',array('id' => $order_id, 'status'=>'5', 'pdf !=' => 'none'))->result_array();
		if(isset($order_details[0]['id']))
		{
			$data['order_id'] = $order_details[0]['id'];
			$approve_details_chk = $this->db->get_where('send_for_approval', array('order_id' => $order_id))->row_array();
			if(isset($approve_details_chk['id'])){ $data['approve_details'] = $approve_details_chk; }
			if(isset($_POST['send'])){
				
				if(isset($approve_details_chk['id'])){
					$post = array( 
									'adrep_id' => $this->session->userdata('ncId'),
									'order_id' => $order_id,
									'ad_num' => $_POST['ad_num'],
									'name' => $_POST['name'],
									'email' => $_POST['email_id'],
									);
					$this->db->where('id', $approve_details_chk['id']);
					$this->db->update('send_for_approval',$post);
					$approve_id = $approve_details_chk['id'];
				}else{
					$post = array( 
									'adrep_id' => $this->session->userdata('ncId'),
									'order_id' => $order_id,
									'ad_num' => $_POST['ad_num'],
									'name' => $_POST['name'],
									'email' => $_POST['email_id'],
									); 
					$this->db->insert('send_for_approval', $post);
					$approve_id = $this->db->insert_id();
				}
				if($approve_id){
					$approve_details = $this->db->get_where('send_for_approval', array('id' => $approve_id))->row_array();
					//send mail
						$client = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->row_array();
						$publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
						$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						$dataa['approve_details'] = $approve_details;
						$dataa['client'] = $client;
						$dataa['order_id'] = $order_id;
						
						$dataa['from'] = $client['email_id'];

						$dataa['from_display'] = $client['first_name'].' '.$client['last_name'];

						$dataa['replyTo'] = $client['email_id'];

						$dataa['replyTo_display'] = $client['first_name'].' '.$client['last_name'];
 
						$dataa['subject'] = 'VI Daily News Artwork For Your Approval Ad #'.$approve_details['ad_num'] ;
						
						/*$dataa['body'] = 'Hi '.$approve_details['name'].',<br/><br/>Please <a href="'.base_url().index_page().'approval/home/'.$this->uencrypter->encode($order_id).'">click here
						</a> to check your advertise design.<br/>
						<br/><br/> Thank you, <br/>'.$client['first_name'].' '.$client['last_name'].'.' ;*/
						
						//Design Team
						$dataa['recipient'] = $approve_details['email'];
						//$dataa['filename'] = $filename;
						if(!$this->approval_mail($dataa)){
							$this->session->set_flashdata('message',"Error sending Email");
							redirect('new_client/home/approval/'.$order_id);
						}
					redirect('new_client/home/dashboard');
				}
			}
			if(isset($_POST['only_update'])){
				//update approval
			    $orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order_id' ORDER BY `id` DESC LIMIT 1")->row_array();
				if($orders_rev){
							$filename = $orders_rev['pdf_path'];
							$rev_id = $orders_rev['id'];
							$rev_approve = $orders_rev['approve'];
							
							if($rev_approve=='0'){
								$post = array('approve'=>'1', 'status'=>'9');
								$this->db->where('id', $rev_id);
								$this->db->update('rev_sold_jobs', $post); 
								
								//update rev status in orders table
            					$order_rev_status_update = array('rev_order_status' => '9');
            					$this->db->where('id', $order_id);
            					$this->db->update('orders', $order_rev_status_update);
					
								//Live_tracker Revision Updation
								$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$rev_id."' ")->row_array();
								if(isset($update_revision['id'])){
									$tracker_data = array('status' => '9');
									$this->db->where('id', $update_revision['id']);
									$this->db->update('live_revisions', $tracker_data);
								}
							}
				}else{
							/*$filename = $order_details[0]['pdf'];
							if(!file_exists($filename)){
								$this->load->helper('directory');
								$map = directory_map('pdf_uploads/'.$order_id.'/');
								if($map){ foreach($map as $file){ $filename = 'pdf_uploads/'.$order_id.'/'.$file; }}
							}*/
							if($order_details[0]['approve']=='0'){
								$post = array('approve'=>'1', 'status'=>'7');
								$this->db->where('id', $order_details[0]['id']);
								$this->db->update('orders', $post);
								
								//Live_tracker Updation
								$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_details[0]['id']."' ")->row_array();
								if(isset($update_order['id'])){
									$tracker_data = array('status' => '7');
									$this->db->where('id', $update_order['id']);
									$this->db->update('live_orders', $tracker_data);
								}
								
							} 
				}
				$this->session->set_flashdata('message',"Approved ".$order_id);
				redirect('new_client/home/dashboard');
			}
			$this->load->view('new_client/approval', $data);
		}else{ redirect('new_client/home/dashboard'); }	
	}
	
	public function send_vidn_approval($order_id = 0)
	{
		$order_details = $this->db->get_where('orders',array('id' => $order_id, 'status'=>'5', 'pdf !=' => 'none'))->result_array();
		if(isset($order_details[0]['id']))
		{
			$approve_details_chk = $this->db->get_where('send_for_approval', array('order_id' => $order_id))->row_array();
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order_id' ORDER BY `id` DESC LIMIT 1")->row_array();
			if($orders_rev){
				$filename = $orders_rev['pdf_path'];
				$rev_id = $orders_rev['id'];
				$rev_approve = $orders_rev['approve'];
			}else{
				$filename = $order_details[0]['pdf'];
				if(!file_exists($filename)){
					$this->load->helper('directory');
					$map = directory_map('pdf_uploads/'.$order_id.'/');
					if($map){ foreach($map as $file){ $filename = 'pdf_uploads/'.$order_id.'/'.$file; }}
				}
			}
			$data['order_id'] = $order_details[0]['id'];
			$client = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
			$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				//$dataa['design_team'] = $design_team[0];
				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Approved Order';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';
		
				//$dataa['subject'] = 'Approved Hi-Res PDF : '.$jname ;
				//$dataa['subject'] = $order_details[0]['id'].' - '.$jname.' - '.$order_details[0]['publication_name'] ;
				
    			if(isset($_POST['ad_num'])){
					$adv_name = $order_details[0]['advertiser_name']; 
					$publish_date = date('M d', strtotime($order_details[0]['publish_date']));
					if($order_details[0]['order_type_id'] == '1'){
						if($order_details[0]['pixel_size']=='custom'){
							$ad_size = $order_details[0]['custom_width'].' x '.$order_details[0]['custom_height'];
						}else{
							$size_px = $this->db->get_where('pixel_sizes',array('id' => $order_details[0]['pixel_size']))->row_array();
							$ad_size = $size_px['width'].' x '.$size_px['height'];
						}
					}else{
						$ad_size = $order_details[0]['width'].' x '.$order_details[0]['height'];
					}
					
					$pname = $order_details[0]['publication_name'];
					if(!empty($order_details[0]['project_id'])){
						$project_id = $this->db->get_where('pub_project',array('id' => $order_details[0]['project_id']))->row_array();
						if(isset($project_id['name'])) $pname = $project_id['name'];
					}
					
					$dataa['subject'] = $_POST['ad_num'].' - '.$adv_name.' - '.$publish_date.' - '.$pname.' - '.$ad_size ;				
					$dataa['body'] = 'Hi '.$client[0]['first_name'].' '.$client[0]['last_name'].',<br/><br/>Please find approved Hi-Res PDF For Order ID: '.$_POST['ad_num'].' & Unique Job Name: '.$jname.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				}else{
					$dataa['subject'] = $order_details[0]['id'].' - '.$jname.' - '.$order_details[0]['publication_name'] ;
					$dataa['body'] = 'Hi '.$client[0]['first_name'].' '.$client[0]['last_name'].',<br/><br/>Please find approved Hi-Res PDF For Unique Job Name: '.$jname.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				}
				
				$dataa['recipient'] = 'advertising@dailynews.vi'; 
				$dataa['Cc'] = $client[0]['email_id'];
				
				$dataa['filename'] = $filename;
				if(isset($_POST['ad_num'])){ $dataa['fname'] = $_POST['ad_num'].'.pdf'; }
				
				if(!$this->ftp_mail($dataa)){
					$this->session->set_flashdata('message',"Error sending Email");
					redirect('new_client/home/approval/'.$order_id);
				}
				//update
				if(isset($rev_approve) && $rev_approve == '0'){
					$post = array('approve'=>'1', 'status'=>'9');
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post); 
					
					//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$rev_id."' ")->row_array();
					if(isset($update_revision['id'])){
						$tracker_data = array('status' => '9');
						$this->db->where('id', $update_revision['id']);
						$this->db->update('live_revisions', $tracker_data);
					}
				}elseif($order_details[0]['approve']=='0'){
					$post = array('approve'=>'1', 'status'=>'7');
					$this->db->where('id', $order_details[0]['id']);
					$this->db->update('orders', $post);
					
					//Live_tracker Updation
					$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_details[0]['id']."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('status' => '7');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
					
					
				}
				if(isset($approve_details_chk['id'])){
					$post = array('approve' => '1');
					$this->db->where('id', $approve_details_chk['id']);
					$this->db->update('send_for_approval',$post);
					$approve_id = $approve_details_chk['id'];
				}else{
					$post = array( 'adrep_id' => $this->session->userdata('ncId'),
									'order_id' => $order_id,
									'ad_num' => $_POST['ad_num'],
									'approve' => '1'
									); 
					$this->db->insert('send_for_approval', $post);
				}
			$this->session->set_flashdata('message',"Approved ".$order_id);
			redirect('new_client/home/dashboard');
		}
		redirect('new_client/home/dashboard');
	}
		
	public function approval_mail($dataa) 
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
				
		$this->email->message($this->load->view('vidn_emailer/approval_mailer.php',$dataa, TRUE));
				
		$this->email->set_alt_message("Unable to load text!");
				
		$this->email->to($dataa['recipient']);
				
		if(isset($dataa['Cc'])){
			$this->email->cc(array($dataa['Cc']));
        }
        	    
        if(isset($dataa['filename']) && isset($dataa['fname'])){
        	 $this->email->attach($dataa['filename'], $dataa['fname']); 
        }elseif(isset($dataa['filename'])){
        	 $this->email->attach($dataa['filename']);
        }
        	    
        if(!$this->email->send())
            return false;
        else
            return true;
        
	}
	
	public function maporders()
	{
			$today = date('Y-m-d');
			$pday = date('Y-m-d', strtotime(' -6 day'));
			//$data['preorder'] = $this->db->query("SELECT * from `preorder` WHERE `accept`='0' AND (`time_stamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59');")->result_array();
			$data['maporders'] = $this->db->query("Select map_orders.*, orders_type.name from `map_orders`
														JOIN `orders_type` ON map_orders.order_type_id = orders_type.id
														where `approve`='0' AND (`timestamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59');")->result_array();

		 $this->load->view('new_client/maporders', $data);
	}
	
	public function maporderform($id = 0)
	{
		$maporder_details = $this->db->get_where('map_orders',array('id' => $id, 'approve' => '0'))->row_array();
		if(isset($maporder_details['id'])){
		    $map_order_id = $maporder_details['map_id'];
			if(isset($_POST['order_submit']) && isset($_POST['id']))
			{
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				$publication_hd = $this->db->query("SELECT * FROM `publications` WHERE `id`='".$client[0]['publication_id']."' ;")->result_array();  
			
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
				/*$preorder[0]['publish_date'] = date("Y-m-d", strtotime($preorder[0]['publish_date']));
				if($preorder[0]['publish_date'] != '0000-00-00'){
					//echo $preorder[0]['publish_date'];
					$priority = date('Y-m-d', strtotime('-3 day', strtotime($preorder[0]['publish_date'])));
				}else{
					$priority= date('Y-m-d');
				}*/
				//$preorder[0]['date_needed'] = date("Y-m-d", strtotime($preorder[0]['date_needed']));
				if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; }
				if($maporder_details['order_type_id'] == '2'){	//print
					$post = array(
					    'map_order_id' => $map_order_id,
						'adrep_id' => $this->session->userdata('ncId'),
						'publication_id' => $client[0]['publication_id'],
						'group_id' => $publication_hd[0]['group_id'],
						'help_desk' => $publication_hd[0]['help_desk'],
						'order_type_id' => 2, 
						'advertiser_name' => $maporder_details['adv_id'],
						//'date_needed' => $preorder[0]['date_needed'],
						'publish_date' => $publish_date,
						'job_no' => $maporder_details['job_name'],
						'copy_content_description' => $_POST['copy_content_description'],
						'notes' => $_POST['notes'],
						'width' => $_POST['width'],
						'height' => $_POST['height'],
						'print_ad_type' => $_POST['print_ad_type'],
						'rush' => $rush,
						'activity_time' => date('Y-m-d h:i:s'),
						'club_id'=> $publication_hd[0]['club_id']
						//'priority' => $priority,
						);
				}
				if($maporder_details['order_type_id'] == '1'){	//online
					$post = array(
					    'map_order_id' => $map_order_id,
						'adrep_id' => $this->session->userdata('ncId'),
						'publication_id' => $client[0]['publication_id'],
						'group_id' => $publication_hd[0]['group_id'],
						'help_desk' => $publication_hd[0]['help_desk'],
						'order_type_id' => 1, 
						'advertiser_name' => $maporder_details['adv_id'],
						//'date_needed' => $preorder[0]['date_needed'],
						'publish_date' => $publish_date,
						'job_no' => $maporder_details['job_name'],
						'copy_content_description' => $_POST['copy_content_description'],
						'notes' => $_POST['notes'],
						'pixel_size' => $_POST['pixel_size'],
						'custom_width' => $_POST['custom_width'],
						'custom_height' => $_POST['custom_height'],
						'web_ad_type' => $_POST['web_ad_type'],
						'spec_sold_ad' => '0',
						'ad_format' => $_POST['ad_format'], 
						'maxium_file_size' => $_POST['maximum_file_size'],
						'rush' => $rush,
						'activity_time' => date('Y-m-d h:i:s'),
						'club_id'=> $publication_hd[0]['club_id']
						//'priority' => $priority,
						);
				}
				$this->db->insert('orders',$post); 
				$order_no = $this->db->insert_id(); 
				
				if($order_no){
					//Live_tracker updation
					$tracker_data = array(
						'pub_id'=> $publication_hd[0]['id'],
						'order_id'=> $order_no,
						'job_no' => $maporder_details['job_name'],
						'club_id'=> $publication_hd[0]['club_id'],
						'status' => '1'
					);
					$this->db->insert('live_orders', $tracker_data);
					
					$post = array('approve' => '1');
					$this->db->where('id', $_POST['id']);
					$this->db->update('map_orders', $post);
				
				 $this->view($order_no,true); //send mail
				 $this->orders_folder($order_no); //folder creation
				 redirect('new_client/home/order_success/'.$order_no);//File upload
				 
				}else{ 
				 $this->session->set_flashdata("message","Internal Error: Order not placed! ".$this->db->_error_message());
				 redirect('new_client/home/maporders');
				} 
		  } 
			$data['maporder_details'] = $maporder_details;
			$this->load->view('new_client/maporderform', $data);
		}else{
			$this->session->set_flashdata("message","Not in edit list");
			redirect('new_client/home/maporders');
		}
		
	}

	public function new_print_ad()
	{
	    //if new ad not in cache create a cache order
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '2',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		//echo $_POST['cacheid'];
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['pub_list'] = $this->db->query("SELECT * FROM `pub_project` WHERE `pub_id` = '538'")->result_array();
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
		$this->load->helper(array('form', 'url'));
		$this->load->library('Form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
			if($publication[0]['custom_sizes'] == '0' || (isset($_POST['orders_custom_sizes']) && $_POST['orders_custom_sizes'] == 'custom'))
			{
				$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric|greater_than[0]');
				$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric|greater_than[0]');
			}
			if($publication[0]['custom_sizes'] == '1' ){
				$this->form_validation->set_rules('orders_custom_sizes', 'Size', 'trim|required');
			}
			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			$this->form_validation->set_rules('rush', 'Rush', 'trim');
			
		if ($this->form_validation->run() == FALSE){
			$data['num_errors'] = $this->form_validation->error_count();
			if(isset($_POST['cacheid'])) $data['cacheid'] = $_POST['cacheid'];
			
			$this->load->view('new_client/new_print_ad',$data);
			
		}elseif(isset($_POST['os_submit'])){	
				$cacheid = $_POST['cacheid'];
					
				if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				if(!empty($_POST['date_needed'])){ 
					$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
				} else {
					$date_needed = '0000-00-00';
				}
				if(!empty($_POST['publish_date'])){
					$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
				} else {
					$next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				if($publication[0]['custom_sizes'] == '1'){   
					if($_POST['orders_custom_sizes'] != 'custom'){	
						$custom_sizes = $this->db->get_where('orders_custom_sizes',array('id' => $_POST['orders_custom_sizes']))->result_array();
						$width = $custom_sizes[0]['width'];
						$height = $custom_sizes[0]['height'];
					} else {
						$width = $_POST['width'];
						$height = $_POST['height'];
					}  
				} else {  	
					$width = $_POST['width'];
					$height = $_POST['height'];
				}
				if(isset($_POST['publication_name'])){ $publication_name = $_POST['publication_name']; }else{ $publication_name = ''; }
				if(isset($_POST['project_id'])){ $project_id = $_POST['project_id']; }else{ $project_id = '0'; }
				
				$data = array( 
						'adrep_id' =>$this->session->userdata('ncId'),
						'publication_id' => $publication[0]['id'],
						'group_id' => $publication[0]['group_id'],
						'help_desk' => $publication[0]['help_desk'],
						'order_type_id' => '2',
						'size_inches' => $width * $height,
						'advertiser_name' => $advertiser,
						'job_no' => $job_number,
						'copy_content_description' => $_POST['copy_content_description'],
						'width' => $width,
						'height' => $height,
						'print_ad_type' => $_POST['print_ad_type'],
						'notes' => $_POST['notes'],
						'rush'	=> $_POST['rush'],
						'date_needed' => $date_needed, 
						'publish_date' => $publish_date, 
						'publication_name' => $publication_name,
						'font_preferences' => $_POST['font_preferences'],
						'color_preferences' => $_POST['color_preferences'],
						'job_instruction' => $_POST['job_instruction'],
						'art_work' => $_POST['art_work'],
						'project_id' => $project_id,
						'activity_time' => date('Y-m-d h:i:s'),
						'club_id'=> $publication[0]['club_id']
						); 
							
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				if($orderid){
				    //add advertiser if NEW - suggestion box
					$this_adrep = $this->session->userdata('ncId');
					$this_publication = $client[0]['publication_id'];
					if($client[0]['team_orders'] == '1'){
						$advertiser_detail = $this->db->query("SELECT `advertiser_id` FROM `advertiser` WHERE `fullname` = '$advertiser' AND `publication_id` = '$this_publication'")->row_array();
					}else{
						$advertiser_detail = $this->db->query("SELECT `advertiser_id` FROM `advertiser` WHERE `fullname` = '$advertiser' AND `adrep_id` = '$this_adrep'")->row_array();
					}
					
					if(!isset($advertiser_detail['advertiser_id'])){
						$post_detail = array('fullname' => $advertiser, 
											'adrep_id' => $this->session->userdata('ncId'), 
											'publication_id' => $publication[0]['id'],
											'status' => '1');
						$this->db->insert('advertiser', $post_detail);					
					}
					
					//Live_tracker updation
					$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
					$this->db->insert('live_orders', $tracker_data);
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//copying files from order_cache folder to downloads folder
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											if(is_dir($cache_path.'/'.$file)) { continue; } //if mood board theme uploaded ignore Theme folder
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								} 
							}
							
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
								
							}
							//Delete order_cache files
							if(isset($cache_path) && is_dir($cache_path)){
							    if(file_exists($cache_path.'/Theme')){
							        array_map('unlink', glob("$cache_path/Theme/*.*"));
							        rmdir($cache_path.'/Theme');  
							    }
							    array_map('unlink', glob("$cache_path/*.*"));
							    rmdir($cache_path);
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
						//if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['path'];
						if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['mood_board'];
						$md = array(
									'order_id' => $orderid,
									//'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					
					$this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID :  ".$orderid."</p>");
					redirect("new_client/home/dashboard");
					
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/new_print_ad");
				} 
		}
								
	}
	
	public function new_online_ad()
	{
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '1',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		//echo $_POST['cacheid'];
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
		
		if(isset($_POST['os_submit'])){
			$cacheid = $_POST['cacheid'];
					
			if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
			
			$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				
			if(!empty($_POST['publish_date'])){
				$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
			} else {
				$next_day =  date('D', strtotime(' +1 day'));
				if($next_day == 'Sat' || $next_day == 'Sun'){
					$publish_date = date('Y-m-d', strtotime('next monday'));
				}else{
					$publish_date = date('Y-m-d', strtotime(' +1 day'));
				}
			}
			if(isset($_POST['publication_name'])){ $publication_name = $_POST['publication_name']; }else{ $publication_name = ''; }	
			$data = array( 
					'adrep_id' =>$this->session->userdata('ncId'),
					'publication_id' => $publication[0]['id'],
					'group_id' => $publication[0]['group_id'],
					'help_desk' => $publication[0]['help_desk'],
					'order_type_id' => '1',
					'advertiser_name' => $advertiser,
					'job_no' => $job_number,
					'maxium_file_size' => $_POST['maximum_file_size'],	
					'copy_content_description' => $_POST['copy_content_description'],
					'ad_format' => $_POST['ad_format'],
					'web_ad_type' => $_POST['web_ad_type'],
					'notes' => $_POST['notes'],
					'date_needed' =>$_POST['date_needed'],
					'publish_date' => $publish_date,
					'publication_name' => $publication_name,
					'font_preferences' => $_POST['font_preferences'],
					'color_preferences' => $_POST['color_preferences'],
					'job_instruction' => $_POST['job_instruction'],
					'art_work' => $_POST['art_work'],
					'rush'	=> $_POST['rush'],
					'activity_time' => date('Y-m-d h:i:s'),
					'club_id'=> $publication[0]['club_id']
					);
							
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
				
				if($orderid){
				    //multiple size insertion
				    $count_size_id = 0; $count_custom = 0;
				    
        		    if(isset($_POST['size_id'])) $count_size_id = count($_POST['size_id']); 
        		    if(isset($_POST['custom_width'])) $count_custom = count($_POST['custom_width']) - 1;
        		    
        		    $total_size_count = $count_size_id + $count_custom;
        		    
        		    if($total_size_count > 1){
        		        if(isset($_POST['size_id']) && !empty($_POST['size_id']) && $_POST['size_id'] != ''){
            		        //echo'Size Id- '.count($_POST['size_id']).'<br/>';
            		        foreach ($_POST['size_id'] as $size){ 
            		            //echo $selectedOption."<br/>"; 
            		            $post_size = array('order_id' => $orderid, 'size_id' => $size);
            		            $this->db->insert('orders_multiple_size', $post_size);
            		        }
            		        
            		    }
            		    //custom size
            		    if(isset($_POST['custom_width']) && isset($_POST['custom_height'])){
            		        //echo'<br/>Custom  Size - '.count($_POST['custom_width']).'<br/>';
            		        for ($i=1; $i < count($_POST['custom_width']); $i++){ 
            		            //echo $_POST['custom_width'][$i].'x'.$_POST['custom_height'][$i]."<br/>";
            		            $post_size = array('order_id' => $orderid, 'custom_width' => $_POST['custom_width'][$i], 'custom_height' => $_POST['custom_height'][$i]);
            		            $this->db->insert('orders_multiple_custom_size', $post_size);
            		        }
            		    }
    				}else{
				        //if single size consider normal web ad
				        if(isset($_POST['size_id']) && !empty($_POST['size_id']) && $_POST['size_id'] != ''){
				            if($_POST['ad_format'] == 5){ //flexitive
				                $post_update = array( 'flexitive_size' => $_POST['size_id'][0] );
				            }else{  //pixel
				                $post_update = array( 'pixel_size' => $_POST['size_id'][0] );
				            }
				        }else{
				            $post_update = array(
				                            'pixel_size' => 'custom',
				                            'custom_width' => $_POST['custom_width'][1],
					                        'custom_height' => $_POST['custom_height'][1],
					                        );
				        }
				        $this->db->where('id', $orderid);
					    $this->db->update('orders', $post_update);
				    }
				    
				    //add advertiser if NEW - suggestion box
					$this_adrep = $this->session->userdata('ncId');
					$this_publication = $client[0]['publication_id'];
					if($client[0]['team_orders'] == '1'){
						$advertiser_detail = $this->db->query("SELECT `advertiser_id` FROM `advertiser` WHERE `fullname` = '$advertiser' AND `publication_id` = '$this_publication'")->row_array();
					}else{
						$advertiser_detail = $this->db->query("SELECT `advertiser_id` FROM `advertiser` WHERE `fullname` = '$advertiser' AND `adrep_id` = '$this_adrep'")->row_array();
					}
					
					if(!isset($advertiser_detail['advertiser_id'])){
						$post_detail = array('fullname' => $advertiser, 
											'adrep_id' => $this->session->userdata('ncId'), 
											'publication_id' => $publication[0]['id'],
											'status' => '1');
						$this->db->insert('advertiser', $post_detail);					
					}
					
					//Live_tracker updation
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
						//copying files from order_cache folder to downloads folder
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								} 
							}
						
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
							}
							//Delete order_cache files
							if(isset($cache_path) && is_dir($cache_path)){
							    if(file_exists($cache_path.'/Theme')){
							        array_map('unlink', glob("$cache_path/Theme/*.*"));
							        rmdir($cache_path.'/Theme');  
							    }
							    array_map('unlink', glob("$cache_path/*.*"));
							    rmdir($cache_path);
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
					    if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['mood_board'];
						$md = array(
									'order_id' => $orderid,
									//'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					
					$this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID: ".$orderid."</p>");
					redirect("new_client/home/dashboard");
					
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/test_new_online_ad");//redirect("new_client/home/new_online_ad");
				} 
		}
		$this->load->view('new_client/new_online_ad',$data);//$this->load->view('new_client/new_online_ad',$data);					
	}
	
	public function test_new_online_ad()
	{
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '1',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		//echo $_POST['cacheid'];
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
		
		if(isset($_POST['os_submit'])){	
			$cacheid = $_POST['cacheid'];
					
			if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
			
			$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				
			if(!empty($_POST['publish_date'])){
				$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
			} else {
				$next_day =  date('D', strtotime(' +1 day'));
				if($next_day == 'Sat' || $next_day == 'Sun'){
					$publish_date = date('Y-m-d', strtotime('next monday'));
				}else{
					$publish_date = date('Y-m-d', strtotime(' +1 day'));
				}
			}
			if(isset($_POST['publication_name'])){ $publication_name = $_POST['publication_name']; }else{ $publication_name = ''; }	
			$data = array( 
					'adrep_id' =>$this->session->userdata('ncId'),
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
					'publish_date' => $publish_date,
					'publication_name' => $publication_name,
					'font_preferences' => $_POST['font_preferences'],
					'color_preferences' => $_POST['color_preferences'],
					'job_instruction' => $_POST['job_instruction'],
					'art_work' => $_POST['art_work'],
					'rush'	=> $_POST['rush'],
					'activity_time' => date('Y-m-d h:i:s'),
					'flexitive_size' => $_POST['flexitive_size'],
					'club_id'=> $publication[0]['club_id']
					);
							
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
				
				if($orderid){
					//Live_tracker updation
						
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
						//copying files from order_cache folder to downloads folder
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								} 
							}
							
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
								
							}
							//Delete order_cache files
							if(isset($cache_path) && is_dir($cache_path)){
							    if(file_exists($cache_path.'/Theme')){
							        array_map('unlink', glob("$cache_path/Theme/*.*"));
							        rmdir($cache_path.'/Theme');  
							    }
							    array_map('unlink', glob("$cache_path/*.*"));
							    rmdir($cache_path);
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
					    if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['mood_board'];
						$md = array(
									'order_id' => $orderid,
									//'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					
					$this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID: ".$orderid."</p>");
					redirect("new_client/home/dashboard");
					
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/new_online_ad");
				} 
		}
		$this->load->view('new_client/new_online_ad',$data);					
	}
	
	public function order_cache($cacheid)
	{
		$order_details = $this->db->get_where('order_cache',array('id' => $cacheid))->result_array();
		$data['order_details'] = $order_details;
		$download_path = $order_details[0]['file_path'];
		if($download_path != 'none' && file_exists($download_path)){
			$filename = array();
			if($dh = opendir($data['order_details'][0]['file_path'])){
				while(($file = readdir($dh)) !== false) {
					if($file == '.' || $file == '..'){ continue; }
					if($file){ 
					$filename[] = "<tr> 
					                   <td>".$file."</td>
					                   <td><a href='".base_url()."download.php?file_source=".$download_path."/".$file."' target='_blank'><i class='fa fa-download'></i></a></td>
					                   <td onclick=remove_att_cache('".$file."')><i class='fa fa-close'></i></td> 
					               </tr>"; 
					    
					}
					
				}
				closedir($dh);
				echo json_encode($filename);
			}
		}
		//Uploading files
			if(!empty($_FILES)) {
				$download_path = 'order_cache/'.$cacheid;//path
				if (@mkdir($download_path,0777)){} //folder creation
				$data = array('file_path'=>$download_path);
				$this->db->where('id',$cacheid);
				$this->db->update('order_cache',$data);
				
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$targetPath = getcwd().'/'.$download_path.'/';
					$targetFile = $targetPath . $fileName ;
					if(!move_uploaded_file($tempFile, $targetFile)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						redirect('new_client/home/home');
					}else{ $data['file_sucess']="file sucessful!!"; }
			}
	}
	
	public function order_cache2($cacheid) //for Ad2
	{
		$order_details = $this->db->get_where('order_cache',array('id' => $cacheid))->result_array();
		$data['order_details'] = $order_details;
		$download_path = $order_details[0]['file_path'].'/Ad2';
		if($download_path != 'none' && file_exists($download_path)){
			$filename = '';
			if($dh = opendir($download_path)){
				while(($file = readdir($dh)) !== false) {
					if($file == '.' || $file == '..'){ continue; }
					if($file){ $filename[] = '<tr> <td>'.$file.'</td><td><a href="'.base_url().'download.php?file_source='.$download_path.'/'.$file.'" target="_blank"><i class="fa fa-download"></i></a></td> <td onclick=remove_att_cache("'.$file.'")><i class="fa fa-close"></i></td> </tr>'; }
					
				}
				closedir($dh);
				echo json_encode($filename);
			}
		}
		//Uploading files
			if(!empty($_FILES)) {
				$download_path_ad1 = 'order_cache/'.$cacheid;
				$download_path = $download_path_ad1.'/Ad2';//path
				if (@mkdir($download_path,0777)){} //folder creation
				
				if($order_details[0]['file_path'] == 'none'){
					$data = array('file_path'=>$download_path_ad1);
					$this->db->where('id',$cacheid);
					$this->db->update('order_cache',$data);
				}
				
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$targetPath = getcwd().'/'.$download_path.'/';
					$targetFile = $targetPath . $fileName ;
					if(!move_uploaded_file($tempFile, $targetFile)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
						redirect('new_client/home/home');
					}else{ $data['file_sucess']="file sucessful!!"; }
			}
	}
	
	public function remove_att_cache($cacheid, $filename)
	{ 
		$order_details = $this->db->get_where('order_cache',array('id' => $cacheid))->row_array();
		if(isset($order_details['file_path'])){ 
			$filepath = $order_details['file_path'];
			
			$dirhandle = opendir($filepath);
			while ($file = readdir($dirhandle)) { 
				if($file==$filename){ unlink($filepath.'/'.$filename); }
			}
		}		
	}
	
	public function moodboard_cache($cacheid='')
	{
		$order_details = $this->db->get_where('order_cache',array('id' => $cacheid))->row_array();
		if(isset($order_details['file_path'])){
			$path = $order_details['file_path'].'/'.'Theme';
			if($order_details['file_path'] == 'none'){
				$download_path = 'order_cache/'.$cacheid;//path
					if (@mkdir($download_path,0777)){} //folder creation
					$data = array('file_path'=>$download_path);
					$this->db->where('id',$cacheid);
					$this->db->update('order_cache',$data);
				$path = $download_path.'/'.'Theme';
			}
			//Uploading files
			if(!empty($_FILES)) {
				if(file_exists($path)){
					array_map('unlink', glob($path."/*.*"));
					rmdir($path);
				}
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$path.'/';
				$targetFile = $targetPath . $fileName ;
				move_uploaded_file($tempFile, $targetFile);
			}
		}
	}

    public function glacier_order_print()
	{
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '2',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		
		$data['pub_list'] = $this->db->query("SELECT * FROM `pub_project` WHERE `pub_id` = '538'")->result_array();
		$data['section_list'] = $this->db->query("SELECT * FROM `glacier_section`")->result_array();
		
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
			if($publication[0]['custom_sizes'] == '0' || (isset($_POST['orders_custom_sizes']) && $_POST['orders_custom_sizes'] == 'custom'))
			{
				$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric|greater_than[0]');
				$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric|greater_than[0]');
			}
			if($publication[0]['custom_sizes'] == '1' ){
				$this->form_validation->set_rules('orders_custom_sizes', 'Size', 'trim|required');
			}
			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			$this->form_validation->set_rules('rush', 'Rush', 'trim');
			
		if ($this->form_validation->run() == FALSE){
			$data['num_errors'] = $this->form_validation->error_count();
			if(isset($_POST['cacheid'])) $data['cacheid'] = $_POST['cacheid'];
			
			$this->load->view('new_client/glacier_order_form',$data);
			
		}elseif(isset($_POST['os_submit'])){	
				$cacheid = $_POST['cacheid'];
					
				if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				if(!empty($_POST['date_needed'])){ 
					$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
				} else {
					$date_needed = '0000-00-00';
				}
				
				if($publication[0]['custom_sizes'] == '1'){   
					if($_POST['orders_custom_sizes'] != 'custom'){	
						$custom_sizes = $this->db->get_where('orders_custom_sizes',array('id' => $_POST['orders_custom_sizes']))->result_array();
						$width = $custom_sizes[0]['width'];
						$height = $custom_sizes[0]['height'];
					} else {
						$width = $_POST['width'];
						$height = $_POST['height'];
					}  
				} else {  	
					$width = $_POST['width'];
					$height = $_POST['height'];
				}
				if(isset($_POST['publication_name'])){ $publication_name = $_POST['publication_name']; }else{ $publication_name = ''; }
				
				if(!empty($_POST['publish_date'])){	$dt = explode(',', $_POST['publish_date']); $publish_date = date("Y-m-d", strtotime($dt[0])); }else{ $publish_date = ''; }
				
				if($_POST['section_id'] == 'other_section'){
					if(!empty($_POST['add_section'])){
						$new_section = $_POST['add_section'];
						$s = array('name' => $new_section);
						$this->db->insert('glacier_section', $s);
						$_POST['section_id'] = $this->db->insert_id();
					}
				}
				
				$data = array( 
						'adrep_id' =>$this->session->userdata('ncId'),
						'publication_id' => $publication[0]['id'],
						'group_id' => $publication[0]['group_id'],
						'help_desk' => $publication[0]['help_desk'],
						'order_type_id' => '2',
						'size_inches' => $width * $height,
						'advertiser_name' => $advertiser,
						'job_no' => $job_number,
						'copy_content_description' => $_POST['copy_content_description'],
						'width' => $width,
						'height' => $height,
						'print_ad_type' => $_POST['print_ad_type'],
						'notes' => $_POST['notes'],
						'rush'	=> $_POST['rush'],
						'date_needed' => $date_needed, 
						'publish_date' => $publish_date, 
						'publication_name' => $publication_name,
						//'font_preferences' => $_POST['font_preferences'],
						//'color_preferences' => $_POST['color_preferences'],
						//'job_instruction' => $_POST['job_instruction'],
						//'art_work' => $_POST['art_work'],
						//'project_id' => $project_id,
						'activity_time' => date('Y-m-d h:i:s'),
						'section' => $_POST['section_id'],
						'club_id'=> $publication[0]['club_id']
						); 
							
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				if($orderid){
					//Live_tracker updation
					
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					if(isset($_POST['pub_project_id'])){ //project id
						$n = count($_POST['pub_project_id']);
						for($i=0;$i<$n;$i++){
							$d = array(
								 'order_id'  => $orderid,
								 'pub_project_id'  => $_POST['pub_project_id'][$i],
								 
								);
							$this->db->insert('order_project_id', $d);
						}
					}
					
					if(!empty($_POST['publish_date'])){
						$dt = explode(',', $_POST['publish_date']);
						foreach($dt as $row){
							$arr = array(
										'order_id'  => $orderid,
										'publish_date'  => date("Y-m-d", strtotime($row)),
										);
							$this->db->insert('order_publish_date', $arr);
						}
					}
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//Uploading files
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								} 
							}
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
								
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
						if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['path'];
						$md = array(
									'order_id' => $orderid,
									'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					
					$this->session->set_flashdata("message","Order Placed : ".$orderid);
					redirect("new_client/home/dashboard");
					
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/glacier_order_print");
				} 
		}
								
	}
	
	public function glacier_order_print02()
	{
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '2',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		
		$data['pub_list'] = $this->db->query("SELECT * FROM `pub_project` WHERE `pub_id` = '538'")->result_array();
		$data['section_list'] = $this->db->query("SELECT * FROM `glacier_section`")->result_array();
		
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
			
		if(isset($_POST['os_submit'])){	
			$cacheid = $_POST['cacheid'];
					
				/*if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
				if($_POST['advertiser_name'] == 'other_advertiser'){
					if(!empty($_POST['add_advertiser'])){
						$new_advertiser = $_POST['add_advertiser'];
						$adv = array('name' => $new_advertiser);
						$this->db->insert('glacier_advertiser_list', $adv);
						$_POST['advertiser_name'] = $new_advertiser;
					}
				}*/
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				
				$width = $_POST['width'];
				$height = $_POST['height'];
				
				if(!empty($_POST['publish_date'])){	$dt = explode(',', $_POST['publish_date'][0]); $publish_date = date("Y-m-d", strtotime($dt[0])); }else{ $publish_date = ''; }
				
				/*if($_POST['section_id'] == 'other_section'){
					if(!empty($_POST['add_section'])){
						$new_section = $_POST['add_section'];
						$s = array('name' => $new_section);
						$this->db->insert('glacier_section', $s);
						$_POST['section_id'] = $this->db->insert_id();
					}
				}*/
				
				$data = array( 
						'adrep_id' =>$this->session->userdata('ncId'),
						'publication_id' => $publication[0]['id'],
						'group_id' => $publication[0]['group_id'],
						'help_desk' => $publication[0]['help_desk'],
						'order_type_id' => '2',
						'size_inches' => $width * $height,
						'advertiser_name' => $advertiser,
						'job_no' => $job_number,
						'copy_content_description' => $_POST['copy_content_description'],
						'width' => $width,
						'height' => $height,
						'print_ad_type' => $_POST['print_ad_type'],
						'notes' => $_POST['notes'],
						//'rush'	=> $_POST['rush'],
						//'date_needed' => $date_needed, 
						'publish_date' => $publish_date, 
						//'publication_name' => $publication_name,
						//'font_preferences' => $_POST['font_preferences'],
						//'color_preferences' => $_POST['color_preferences'],
						//'job_instruction' => $_POST['job_instruction'],
						//'art_work' => $_POST['art_work'],
						//'project_id' => $project_id,
						'activity_time' => date('Y-m-d h:i:s'),
						'section' => $_POST['section_id'][0],
						'club_id'=> $publication[0]['club_id']
						); 
							
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				if($orderid){
					//Live_tracker updation
						
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					if(isset($_POST['pub_project_id'])){ //project id
						$n = count($_POST['pub_project_id']);
						for($i=0; $i<$n; $i++){
							$format = array();
							$ex = explode(',', $_POST['publish_date'][$i]);
							foreach($ex as $row){
								$format[] = date("Y-m-d", strtotime($row));
							}
							$publish_date = implode(',', $format);
							$d = array(
								 'order_id'  => $orderid,
								 'pub_project_id'  => $_POST['pub_project_id'][$i],
								 'publish_date' =>	$publish_date,
								 'section_id' => $_POST['section_id'][$i]
								);
							$this->db->insert('order_project_id', $d);
						}
					}
					
					/*if(!empty($_POST['publish_date'])){
						$dt = explode(',', $_POST['publish_date']);
						foreach($dt as $row){
							$arr = array(
										'order_id'  => $orderid,
										'publish_date'  => date("Y-m-d", strtotime($row)),
										);
							$this->db->insert('order_publish_date', $arr);
						}
					}*/
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//Uploading files
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file == '.' || $file == '..' || $file== 'Ad2') { continue; } 
											copy($cache_path.'/'.$file, $download_path.'/'.$file);
											
										}
										closedir($dh);
									}
								} 
							}
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
								
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
						if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['path'];
						$md = array(
									'order_id' => $orderid,
									'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					
					$this->session->set_flashdata("message","Order Placed : ".$orderid);
				//Ad2
					if(isset($_POST['job_no2']) && !empty($_POST['job_no2'])){
						$this->ad2();
					}
					redirect("new_client/home/dashboard");
					
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message())
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/glacier_order_print");
				} 	
		}
		$this->load->view('new_client/glacier_print_order_form',$data);						
	}
	
	public function ad2()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		if(isset($_POST['cacheid']) && isset($_POST['job_no2']) && !empty($_POST['job_no2'])){
			$cacheid = $_POST['cacheid'];
			
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no2']);
				
				$width = $_POST['width2'];
				$height = $_POST['height2'];
				
				if(!empty($_POST['publish_date2'])){	$dt = explode(',', $_POST['publish_date2'][0]); $publish_date = date("Y-m-d", strtotime($dt[0])); }else{ $publish_date = ''; }
				
				$data = array( 
						'adrep_id' =>$this->session->userdata('ncId'),
						'publication_id' => $publication[0]['id'],
						'group_id' => $publication[0]['group_id'],
						'help_desk' => $publication[0]['help_desk'],
						'order_type_id' => '2',
						'size_inches' => $width * $height,
						'advertiser_name' => $advertiser,
						'job_no' => $job_number,
						'copy_content_description' => $_POST['copy_content_description2'],
						'width' => $width,
						'height' => $height,
						'print_ad_type' => $_POST['print_ad_type'],
						'notes' => $_POST['notes'],
						'publish_date' => $publish_date, 
						'activity_time' => date('Y-m-d h:i:s'),
						'section' => $_POST['section_id2'][0],
						'club_id'=> $publication[0]['club_id']
						); 
							
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				if($orderid){
					//Live_tracker updation
					
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					if(isset($_POST['pub_project_id2'])){ //project id
						$n = count($_POST['pub_project_id2']);
						for($i=0; $i<$n; $i++){
							$format = array();
							$ex = explode(',', $_POST['publish_date2'][$i]);
							foreach($ex as $row){
								$format[] = date("Y-m-d", strtotime($row));
							}
							$publish_date = implode(',', $format);
							$d = array(
								 'order_id'  => $orderid,
								 'pub_project_id'  => $_POST['pub_project_id2'][$i],
								 'publish_date' =>	$publish_date,
								 'section_id' => $_POST['section_id2'][$i]
								);
							$this->db->insert('order_project_id', $d);
						}
					}
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_file_path = $cache_file_path.'/Ad2';
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//Uploading files
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file == '.' || $file == '..' || $file== 'Ad2') { continue; } 
											copy($cache_path.'/'.$file, $download_path.'/'.$file);
											
										}
										closedir($dh);
									}
								} 
							}
							
						}
					}
					
					$this->session->set_flashdata("message2","<br/>Order Placed : ".$orderid);
				
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					
				} 
		}
	}
	
    public function glacier_order_online()
	{
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '1',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$data['min'] = date('Y-m-d');
		$data['max'] = date("Y-m-d",strtotime("+30 days"));
		//echo $_POST['cacheid'];
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		
		$data['pub_list'] = $this->db->query("SELECT * FROM `pub_project` WHERE `pub_id` = '538'")->result_array();
		$data['section_list'] = $this->db->query("SELECT * FROM `glacier_section`")->result_array();
		
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
		
		if(isset($_POST['os_submit'])){	
			$cacheid = $_POST['cacheid'];
					
			if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
			$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				
			if(!empty($_POST['publish_date'])){	$dt = explode(',', $_POST['publish_date']); $publish_date = $dt[0]; }else{ $publish_date = ''; }
			
			if(isset($_POST['publication_name'])){ $publication_name = $_POST['publication_name']; }else{ $publication_name = ''; }
			
			$data = array( 
					'adrep_id' =>$this->session->userdata('ncId'),
					'publication_id' => $publication[0]['id'],
					'group_id' => $publication[0]['group_id'],
					'help_desk' => $publication[0]['help_desk'],
					'order_type_id' => '1',
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
					//'date_needed' =>$_POST['date_needed'],
					'publish_date' => $publish_date,
					'publication_name' => $publication_name,
					//'font_preferences' => $_POST['font_preferences'],
					//'color_preferences' => $_POST['color_preferences'],
					//'job_instruction' => $_POST['job_instruction'],
					//'art_work' => $_POST['art_work'],
					'rush'	=> $_POST['rush'],
					'activity_time' => date('Y-m-d h:i:s'),
					'section' => $_POST['section_id'],
					'club_id'=> $publication[0]['club_id']
					);
							
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
				
				if($orderid){
					//Live_tracker updation
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					if(isset($_POST['pub_project_id'])){ //project id
						$n = count($_POST['pub_project_id']);
						for($i=0;$i<$n;$i++){
							$d = array(
								 'order_id'  => $orderid,
								 'pub_project_id'  => $_POST['pub_project_id'][$i],
								 
								);
							$this->db->insert('order_project_id', $d);
						}
					}
					
					if(!empty($_POST['publish_date'])){
						$dt = explode(',', $_POST['publish_date']);
						foreach($dt as $row){
							$arr = array(
										'order_id'  => $orderid,
										'publish_date'  => $row,
										);
							$this->db->insert('order_publish_date', $arr);
						}
					}
					
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//Uploading files
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											copy($cache_path.'/'.$file, $download_path.'/'.$file);
											
										}
										closedir($dh);
									}
								} 
							}
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
								
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
						if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['path'];
						$md = array(
									'order_id' => $orderid,
									'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					
					$this->session->set_flashdata("message","Order Placed : ".$orderid);
					redirect("new_client/home/dashboard");
					
				}else{
				// 	$this->session->set_flashdata("message",$this->db->_error_message());
					$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					redirect("new_client/home/glacier_order_online");
				} 
		}
		$this->load->view('new_client/glacier_order_online_form',$data);					
	}
	
	public function glacier_order_online02()
	{
		if(!isset($_POST['cacheid'])){	
			$data = array(
					'adrep_id' => $this->session->userdata('ncId'),
					'order_type_id' => '1',
					);
			$this->db->insert('order_cache', $data);
			$cacheid = $this->db->insert_id();
			$data['cacheid'] = $cacheid;
		}
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		
		$data['pub_list'] = $this->db->query("SELECT * FROM `pub_project` WHERE `pub_id` = '538'")->result_array();
		$data['section_list'] = $this->db->query("SELECT * FROM `glacier_section`")->result_array();
		
		$data['client'] = $client[0];
		$data['publication'] = $publication[0];
			
		if(isset($_POST['os_submit'])){	
			$cacheid = $_POST['cacheid'];
					
				/*if(!isset($_POST['rush']) || empty($_POST['rush'])){ $_POST['rush']='0'; }
				if($_POST['advertiser_name'] == 'other_advertiser'){
					if(!empty($_POST['add_advertiser'])){
						$new_advertiser = $_POST['add_advertiser'];
						$adv = array('name' => $new_advertiser);
						$this->db->insert('glacier_advertiser_list', $adv);
						$_POST['advertiser_name'] = $new_advertiser;
					}
				}*/
				$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
				$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no']);
				
				if(!empty($_POST['publish_date'])){	$dt = explode(',', $_POST['publish_date'][0]); $publish_date = date("Y-m-d", strtotime($dt[0])); }else{ $publish_date = ''; }
								
				$data = array( 
							'adrep_id' =>$this->session->userdata('ncId'),
							'publication_id' => $publication[0]['id'],
							'group_id' => $publication[0]['group_id'],
							'help_desk' => $publication[0]['help_desk'],
							'order_type_id' => '1',
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
							//'date_needed' =>$_POST['date_needed'],
							'publish_date' => $publish_date,
							//'publication_name' => $publication_name,
							//'font_preferences' => $_POST['font_preferences'],
							//'color_preferences' => $_POST['color_preferences'],
							//'job_instruction' => $_POST['job_instruction'],
							//'art_work' => $_POST['art_work'],
							'activity_time' => date('Y-m-d h:i:s'),
							'section' => $_POST['section_id'][0],
							'club_id'=> $publication[0]['club_id']
						);
				
				$this->db->insert('orders', $data);
				$orderid = $this->db->insert_id();
				
				if($orderid){
					if(isset($_POST['pub_project_id'])){ //project id
						$n = count($_POST['pub_project_id']);
						for($i=0; $i<$n; $i++){
							$format = array();
							$ex = explode(',', $_POST['publish_date'][$i]);
							foreach($ex as $row){
								$format[] = date("Y-m-d", strtotime($row));
							}
							$publish_date = implode(',', $format);
							$d = array(
								 'order_id'  => $orderid,
								 'pub_project_id'  => $_POST['pub_project_id'][$i],
								 'publish_date' =>	$publish_date,
								 'section_id' => $_POST['section_id'][$i]
								);
							$this->db->insert('order_project_id', $d);
						}
					}
				
					$this->view($orderid, true); //email notification
					$this->orders_folder($orderid);//html file creation
					
					$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					$order_theme_file = '';
					if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//Uploading files
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file == '.' || $file == '..' || $file== 'Ad2') { continue; } 
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								} 
							}
							//mood_board update
							if(isset($_POST['mood_board']) && $_POST['mood_board'] == '4'){
								$cache_theme_path = $cache['file_path'].'/'.'Theme';
								if(file_exists($cache_theme_path)){
									$order_theme_path = $order_details['file_path'].'/'.'Theme';
									if (@mkdir($order_theme_path,0777)){}
										
									if($dh = opendir($cache_theme_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											$order_theme_file = $order_theme_path.'/'.$file;
										}
										closedir($dh);
									}
								}
								
							}
						}
					}
					//mood_board update
					if(isset($_POST['mood_board'])){
						if($_POST['mood_board'] == '4') $theme = $order_theme_file; else $theme = $_POST['path'];
						$md = array(
									'order_id' => $orderid,
									'mood_id' => $_POST['mood_board'],
									'path' => $theme
									);
						$this->db->insert('order_mood', $md);
					}
					//Live_tracker updation
					
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
					
					$this->session->set_flashdata("message","Order Placed : ".$orderid);
				//Ad2
					if(isset($_POST['job_no2']) && !empty($_POST['job_no2'])){
						$this->online_ad2();
					}
					redirect("new_client/home/dashboard");
					
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect("new_client/home/glacier_order_online");
				} 	
		}
		$this->load->view('new_client/glacier_order_online_form02',$data);						
	}
	
	public function online_ad2()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		if(isset($_POST['cacheid']) && isset($_POST['job_no2']) && !empty($_POST['job_no2'])){
			$cacheid = $_POST['cacheid'];
			
			$advertiser = preg_replace('/[^A-Za-z0-9& ]/','',$_POST['advertiser_name']);
			$job_number = preg_replace('/[^A-Za-z0-9 ]/','',$_POST['job_no2']);
				
			if(!empty($_POST['publish_date2'])){	$dt = explode(',', $_POST['publish_date2'][0]); $publish_date = date("Y-m-d", strtotime($dt[0])); }else{ $publish_date = ''; }
				
			$data = array( 
							'adrep_id' =>$this->session->userdata('ncId'),
							'publication_id' => $publication[0]['id'],
							'group_id' => $publication[0]['group_id'],
							'help_desk' => $publication[0]['help_desk'],
							'order_type_id' => '1',
							'advertiser_name' => $advertiser,
							'job_no' => $job_number,
							'maxium_file_size' => $_POST['maximum_file_size2'],	
							'copy_content_description' => $_POST['copy_content_description2'],
							'ad_format' => $_POST['ad_format'],
							'web_ad_type' => $_POST['web_ad_type'],
							'pixel_size' => $_POST['pixel_size2'],
							'custom_width' => $_POST['custom_width2'],
							'custom_height' => $_POST['custom_height2'],
							'notes' => $_POST['notes'],
							'publish_date' => $publish_date,
							'activity_time' => date('Y-m-d h:i:s'),
							'section' => $_POST['section_id2'][0],
							'club_id'=> $publication[0]['club_id']
						);
			$this->db->insert('orders', $data);
			$orderid = $this->db->insert_id();
			if($orderid){
				if(isset($_POST['pub_project_id2'])){ //project id
						$n = count($_POST['pub_project_id2']);
						for($i=0; $i<$n; $i++){
							$format = array();
							$ex = explode(',', $_POST['publish_date2'][$i]);
							foreach($ex as $row){
								$format[] = date("Y-m-d", strtotime($row));
							}
							$publish_date = implode(',', $format);
							$d = array(
								 'order_id'  => $orderid,
								 'pub_project_id'  => $_POST['pub_project_id2'][$i],
								 'publish_date' =>	$publish_date,
								 'section_id' => $_POST['section_id2'][$i]
								);
							$this->db->insert('order_project_id', $d);
						}
				}
					
				$this->view($orderid, true); //email notification
				$this->orders_folder($orderid);//html file creation
					
				$cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
				$order_theme_file = '';
				if(isset($cache['id'])){
						//updating order id to order_cache table
							$order_cache = array('order_id' =>$orderid );
							$this->db->where('id', $cacheid);
							$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
					if(!empty($cache_file_path) && $cache_file_path != "none"){
							$cache_file_path = $cache_file_path.'/Ad2';
							$cache_path = getcwd().'/'.$cache_file_path;
							
							//Uploading files
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
						if(!empty($order_file_path) && $order_file_path != "none"){
							if(is_dir($cache_path)){
								if($dh = opendir($cache_path)){
									while(($file = readdir($dh)) !== false){
											if($file == '.' || $file == '..' || $file== 'Ad2') { continue; } 
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
									}
									closedir($dh);
								}
							} 
						}
							
					}
				}
				//Live_tracker updation
				
						$tracker_data = array(
											'pub_id'=> $publication[0]['id'],
											'order_id'=> $orderid,
											'job_no' => $job_number,
											'club_id'=> $publication[0]['club_id'],
											'status' => '1'
											);
						$this->db->insert('live_orders', $tracker_data);
			
				$this->session->set_flashdata("message2","<br/>Order Placed : ".$orderid);
				
			}else{
				// $this->session->set_flashdata("message",$this->db->_error_message());
				$this->session->set_flashdata("message","Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.");
					
			} 
		}
	}
	
	
    public function search_order($num = '1')
	{
		//pagination
		$rowsPerPage = 10;
		$offset = ($num - 1) * $rowsPerPage;
		$adrep_id = $this->session->userdata('ncId');
		$client = $this->db->get_where('adreps',array('id' => $adrep_id))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		$publication_id = $client[0]['publication_id'];
		$data['client'] = $client; $data['pre_next'] = '1';
		$data['advance'] = 'advance';
		$keyword = $from = $to = $status_id = $team_adrep_id = $project_id = $ad_type = NULL;
		if(isset($_GET['search'])){ //search
				$keyword = $_GET['input'];
				
				if($client[0]['team_orders']=='1' ){
					$q = "SELECT orders.* FROM `orders` WHERE orders.publication_id = '$publication_id'";
					$q .= " AND (orders.id = '".$this->db->escape_like_str($keyword)."' OR orders.advertiser_name LIKE '%".$this->db->escape_like_str($keyword)."%' OR orders.job_no LIKE '%".$this->db->escape_like_str($keyword)."%') ";
				}else{
					$q = "SELECT orders.* FROM `orders` WHERE orders.adrep_id = '".$this->session->userdata('ncId')."'";
					$q .= " AND (orders.id = '".$this->db->escape_like_str($keyword)."' OR orders.advertiser_name LIKE '%".$this->db->escape_like_str($keyword)."%' OR orders.job_no LIKE '%".$this->db->escape_like_str($keyword)."%') ";
				}
				
		}elseif(isset($_GET['adv_search'])){ //advance search
				if(isset($_GET['project_id']) && !empty($_GET['project_id'])){
					if($client[0]['team_orders']=='1' ){
						$q = "SELECT orders.* FROM `orders` 
						JOIN order_project_id ON order_project_id.order_id = orders.id 
						WHERE orders.publication_id = '$publication_id'";
					}else{
						$q = "SELECT orders.* FROM `orders` 
						JOIN order_project_id ON order_project_id.order_id = orders.id 
						WHERE orders.adrep_id = '".$this->session->userdata('ncId')."'";
					}
					
					$project_id = $_GET['project_id'];
					$q .= " AND order_project_id.pub_project_id = '$project_id'";
					
				}else{
					if($client[0]['team_orders']=='1' ){
						$q = "SELECT * FROM `orders` WHERE orders.publication_id = '$publication_id'";
					}else{
						$q = "SELECT * FROM `orders` WHERE orders.adrep_id = '".$this->session->userdata('ncId')."'";
					}
				}
				
				if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
					$keyword = $_GET['keyword'];
					$q .= " AND (orders.id = '".$keyword."' OR orders.advertiser_name LIKE '%".$keyword."%' OR orders.job_no LIKE '%".$keyword."%') ";
				}
				
				if(!empty($_GET['from_dt']) && !empty($_GET['to_dt'])){
					$from = $_GET['from_dt']; //$from = date('Y-m-d',strtotime($_GET['from_dt'])). " 00:00:00";
					$to = $_GET['to_dt']; //$to = date('Y-m-d',strtotime($_GET['to_dt'])). " 23:59:59";
					$q .= " AND (orders.publish_date BETWEEN '$from' AND '$to' )";
				}
				if(isset($_GET['team_adrep_id']) && !empty($_GET['team_adrep_id'])){
					$team_adrep_id = $_GET['team_adrep_id'];
					$q .= " AND orders.adrep_id = '$team_adrep_id'";
					
				}
				
				if(!empty($_GET['status'])){
					$status_id = $_GET['status'];
					$q .= " AND orders.status = '$status_id'";
					
				}
				if(!empty($_GET['ad_type'])){
					$ad_type = $_GET['ad_type'];
					$q .= " AND orders.order_type_id = '$ad_type'";
					
				}
				
		}
		//echo $q;
			$data['order_count'] = $this->db->query("$q")->num_rows();
			if($client[0]['team_orders']=='1' ){
				$tl_orders = $this->db->query("$q ORDER BY orders.activity_time DESC LIMIT $offset, $rowsPerPage;")->result_array();
			}else{
				$orders = $this->db->query("$q ORDER BY orders.activity_time DESC LIMIT $offset, $rowsPerPage;")->result_array();
			}
			
			if(isset($tl_orders[0]['id'])){
				$data['tl_orders'] = $tl_orders;
				$data['num'] = $num;
				$data['rowsPerPage'] = $rowsPerPage;
				$data['offset'] = $offset;
			}elseif(isset($orders[0]['id'])){
				$data['orders'] = $orders;
				$data['num'] = $num;
				$data['rowsPerPage'] = $rowsPerPage;
				$data['offset'] = $offset;
			}elseif(isset($keyword) && ($publication[0]['id']=='43' || $publication[0]['id']=='47' || $publication[0]['id']=='13')){
				$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '%".$this->db->escape_like_str($keyword)."%' OR `advertiser` LIKE '%".$this->db->escape_like_str($keyword)."%');")->result_array();
				if(isset($preorder[0]['id'])){ 
					$data['preorder'] = $preorder; 
				}else{ 
				// 	$this->session->set_flashdata('message',"No Orders Found ".$keyword);
					$this->session->set_flashdata('message', 'Oops! We couldn\'t locate an order with the provided OrderID. Please double-check and try again.');
					redirect('new_client/home/dashboard'); 
				}
			}
		$data['keyword'] = $keyword; $data['project_id'] = $project_id; $data['from'] = $from; $data['to'] = $to; $data['team_adrep_id'] = $team_adrep_id; $data['status'] = $status_id; $data['ad_type'] = $ad_type;		
		if(isset($preorder)){
			$this->load->view('new_client/preorders', $data);
		}else{
			$this->load->view('new_client/dashboard',$data);
		}
		
	}
	
//page design start
    public function page_proceed() //order form page-1
    {
        $aId = $this->session->userdata('ncId');
		if (isset($_POST['proceed'])){
            //post the array of data into database page_design
            $publication_id = $this->input->post('publication');
            $publication_detail = $this->db->query("SELECT `name` FROM `publications` WHERE `id` = $publication_id")->row_array();
    		$data = array(
        				'user_id' => $aId,
        				'publication_id' => $publication_id,
            			'unique_job_name' => $publication_detail['name'], //$this->input->post('unique_job_name'),
                        'publish_date' => $this->input->post('publish_date'),
                        'No_of_pages' => $this->input->post('No_of_pages')                 
                    );
            
    		$this->db->insert('page_design',$data);
            $page_design_id = $this->db->insert_id();  //process($data) it is model function it stored in $id variable
			
    		redirect('new_client/home/page_order/'.$page_design_id);		 //page_design redirect to the page_order with id of page_design
    	}
    	//list publication on order form
    	$publication_list = $this->db->query("SELECT publications.id, publications.name FROM `adrep_publication`
    	                                       JOIN `publications` ON publications.id = adrep_publication.publication_id
    	                                        WHERE adrep_publication.adrep_id = '$aId' AND adrep_publication.is_active = '1' ORDER BY publications.id")->result_array();
    	if(!isset($publication_list[0]['id'])){
    	    $publication_list = $this->db->query("SELECT publications.id, publications.name FROM `adreps`
    	                                       JOIN `publications` ON publications.id = adreps.publication_id
    	                                        WHERE adreps.id = '$aId'")->result_array();    
    	}
    	$data['publication_list'] = $publication_list;
    	
        $this->load->view('page_design_view/page_design', $data);		 //view the page_design 
    }
/************* Section - april-2023 ******************/    
	public function page_proceed_section() //order form page-1
    {
		if (isset($_POST['proceed'])){
            //post the array of data into database page_design
    		$data = array(
        				'user_id' => $this->session->userdata('ncId'),
            			'unique_job_name' => $this->input->post('unique_job_name'),
                        'publish_date' => $this->input->post('publish_date'),
                        'No_of_pages' => $this->input->post('No_of_pages')                 
                    );
            
    		$this->db->insert('page_design',$data);
            $page_design_id = $this->db->insert_id();  //process($data) it is model function it stored in $id variable
            if(isset($page_design_id)){
                $page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
                $num_section = $page_design['No_of_pages'];
                for($i=1; $i<=$num_section ; $i++){
                    $post_data = array('page_design_id' => $page_design_id, 'section_name' => 'Section '.$i, 'adrep_id' => $this->session->userdata('ncId'));
                    $this->db->insert('page_design_section', $post_data);
                }    
            }
			$first_section_detail = $this->db->query("SELECT `id` FROM page_design_section where page_design_section.page_design_id = $page_design_id ;")->row_array();
    		//redirect('new_client/home/page_order/'.$page_design_id);		 //page_design redirect to the page_order with id of page_design
    		redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$first_section_detail['id']);
    	}
        $this->load->view('page_design_view/page_design_section');		 //view the page_design 
    }
    
    public function page_add_section($page_design_id='0') //Add new aection
    {
        $page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
        if(isset($page_design['id'])){
            if(isset($_POST['section_name']) && !empty($_POST['section_name'])){
                $section_name = $_POST['section_name'];
            }else{
                $section_name = 'New Section';
            }
            $post_data = array('page_design_id' => $page_design_id, 'section_name' => $section_name, 'adrep_id' => $this->session->userdata('ncId'));
            $this->db->insert('page_design_section', $post_data);
            $section_id = $this->db->insert_id();
            //update number of section 
            $replace_num_section = $this->db->query("SELECT `id` FROM `page_design_section` WHERE page_design_section.page_design_id = '$page_design_id'")->num_rows();
                
            $data = array('No_of_pages' => $replace_num_section);
            $this->db->where('id', $page_design_id);
            $this->db->update('page_design', $data);
        }
        redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id); //redirect('new_client/home/page_section/'.$page_design_id);
    }
    
    public function page_section($page_design_id='')
    {
        $page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
        
        $data['page_design'] = $page_design;
        $data['page_design_section'] = $this->db->query("SELECT * FROM page_design_section where page_design_section.page_design_id = $page_design_id ;")->result_array();
        $this->load->view('page_design_view/page_order_placed_section', $data);
    }
    
    public function page_order_view_section($page_design_id='0', $section_id='0', $order_id='0')     //order form page-2	//receiving the id and pid
    {
        $page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
        if(isset($page_design['id'])){
            $data['page_design_section'] = $this->db->query("SELECT * FROM page_design_section where page_design_section.page_design_id = $page_design_id ;")->result_array();
            $statusinf = $this->db->query("SELECT orders.status FROM `orders` WHERE orders.id = $order_id")->row_array();
            //shifting the pending to selected if completed the order this is exited
            $edit_not_allowed_status = array(1,2,3,4,5,6,7,8);
            if (isset($statusinf['status']) && !in_array($statusinf['status'], $edit_not_allowed_status) )//if status not equal to submitted(order recieved) 
            {
                $data1 = array('status' => '10'); //change to selected
                $this->db->where('id', $order_id);
                $this->db->update('orders', $data1);
    			//echo 'pages01 : '.$this->db->_error_message();
            }
    
            $order_detail = $this->db->query("SELECT * FROM `orders` WHERE orders.id = $order_id")->row_array();
            if(isset($order_detail['id'])){
                /*$orders_detail = $this->db->query("SELECT orders.id, orders.job_no, orders.id, orders.id, orders.status, order_status.name  FROM `orders`
                                                JOIN `order_status` ON order_status.id = orders.status
                                                WHERE orders.page_design_id = $section_id;")->result_array(); // $page_no will fetch the section_id    
                */
                //shifting the select or pending
                if ($order_detail['status'] == '10' )//if status equal to selected, condition exits if not 
                {
                    $data1 = array('status' => '9'); // change into 0 - pending
                    $this->db->where('id', $order_id);
                    $this->db->update('orders', $data1);
        			//echo 'pages02 : '.$this->db->_error_message();
                }
                //file list
        		$download_file_path = $order_detail['file_path'];
        		if($download_file_path != 'none' && file_exists($download_file_path)){
        			//articles list
        			$articles_path = $download_file_path.'/articles';
        			if(file_exists($articles_path) && $atp = opendir($articles_path)){
        				while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
        				{
        					if ($file == '.' || $file == '..')  //.,.. get 
        					{
        						continue; // left that and continue next
        					}
        					if($file) // file get 
        					{ 
        						$articlename[]=$file;//store all article name in array
        					}
        					$data['articles_name'] = $articlename;// array of name will stored in articles_name
        				}
        				closedir($atp);//dirctry $atp clocsed
        			}
        			//ads list
        			$ads_path = $download_file_path.'/ads';
        			if(file_exists($ads_path) && $dh = opendir($ads_path)){ //check the notnull exitsfile and openfile
        				while(($file = readdir($dh)) !== false)  //loop to read the file path then store it
        				{
        					if($file == '.' || $file == '..') //.,.. get 
        					{ 
        						continue;  // left that and continue next
        					}
        					if($file) // file get 
        					{ 
        						$filename[] = $file;  //store all file name in array
        					}
        					$data['file_names1'] = $filename;  // array of name will stored in file_name1
        				}
        				closedir($dh); //dirctry $dh clocsed
        			}
        		}
        		
                $data['order_detail'] = $order_detail;  //$data will store the page_design id result array
                //$data['orders'] = $orders_detail;	//$data will store the page_design id row array
                $data['order_id'] = $order_id;	//$pid of pages	
            }
    		$data['page_design'] = $page_design;
    		$data['page_design_id'] = $page_design_id;    //$id of page_design
    		$data['section_id'] = $section_id;
    		$data['page_count'] = $this->db->query("SELECT page_design.No_of_pages, page_design.unique_job_name FROM `page_design` WHERE page_design.id = '$page_design_id'")->row_array();
            $this->load->view('page_design_view/page_order_placed_section', $data);		//view the page_order_placed with $data 
        }
    }
    
    public function page_add_new($section_id='') // Add new page 
    {
        //if(isset($_POST['add_page_order'])){
            $section_detail = $this->db->query("SELECT * FROM page_design_section where page_design_section.id = $section_id ;")->row_array();
            
            if(isset($section_detail['id'])){
                $page_design_id = $section_detail['page_design_id'];
                $page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
                if(isset($_POST['page_name']) && !empty($_POST['page_name'])){
                    $page_name = $_POST['page_name'];
                }else{
                    $page_name = 'New Page';
                }
                $adrep_id = $this->session->userdata('ncId'); 
                $query = "SELECT adreps.publication_id, publications.group_id, publications.help_desk, publications.club_id FROM `adreps`
        	   				JOIN `publications` ON  publications.id = adreps.publication_id
        	   				WHERE adreps.id = '$adrep_id'";
        	    $adrep_details = $this->db->query("$query")->row_array();
        		if(isset($adrep_details['publication_id']) && $page_design['unique_job_name']){   
            	    $data1 = array(						//post the array of data into database pages
                				'adrep_id' => $adrep_id,
                				'publication_id' => $adrep_details['publication_id'],
                				'group_id' => $adrep_details['group_id'],
                				'help_desk' => $adrep_details['help_desk'],
                				'order_type_id' => '6',
                				'advertiser_name' => $page_design['unique_job_name'],
                				'job_no' => $page_name,
                				'publish_date' => $page_design['publish_date'], 
                				'activity_time' => date('Y-m-d h:i:s'),
                				'page_design_id' => $section_id, //instead of page_design_id we save section id
                				'status' => '9',
                				'club_id' => $adrep_details['club_id']
                            );
                    $this->db->insert('orders', $data1);
            		$order_id = $this->db->insert_id();
            		if(isset($order_id)){
            		    $replace_no_of_page = $this->db->query("SELECT `id` FROM `orders` WHERE orders.page_design_id = '$section_id'")->num_rows();
                    
                        $data = array('num_pages' => $replace_no_of_page);
                        $this->db->where('id', $section_id);
                        $this->db->update('page_design_section', $data);
                           
                        redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id.'/'.$order_id);    
            	    }
                }
            }
        //}
    }
    
    public function page_section_edit_section($page_design_id = '', $section_id = '')  // edit the any page name
    {
        if (isset($_POST['editit'])) 
        {
            $data = array('section_name' => $this->input->post('editrow'));
            $this->db->where('id', $section_id);
            $this->db->update('page_design_section', $data);
        }
        redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id); 
    }
    
    public function page_section_delete($page_design_id = '', $section_id = '') //Section Deletion
    {
        //if(isset($_POST['delete_section'])){
            $aId = $this->session->userdata('ncId');
            $page_design_section = $this->db->query("SELECT * FROM `page_design_section` WHERE page_design_section.id = '$section_id'")->row_array();
            if(isset($page_design_section['id'])){
                //delete - orders related to the section
                $orders = $this->db->query("SELECT `id` FROM `orders` WHERE page_design_id = '$section_id'")->result_array();
                foreach($orders as $row){
                    //Delete order entry from live_orders table if exists
                    $live_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$row['id']."' ")->row_array();
                    if(isset($live_order['id'])){
                        $this->db->where('order_id', $row['id']);
                        $this->db->delete('live_orders');    
                    }
                     //Delete order from orders table
                    $this->db->where('id', $row['id']);
                    $this->db->delete('orders');
                }
                //section delete
                $this->db->where('id', $section_id);
                $this->db->delete('page_design_section');
                
                //update page_design count
                $replace_num_section = $this->db->query("SELECT `id` FROM `page_design_section` WHERE page_design_section.page_design_id = '$page_design_id'")->num_rows();
                $data = array('No_of_pages' => $replace_num_section);
                $this->db->where('id', $page_design_id);
                $this->db->update('page_design', $data);
                
                //page_section_delete_history 
                $del_data = array('section_id'=> $section_id, 'adrep_id'=> $aId); 
                $this->db->insert('page_section_delete_history', $del_data);
                
                //notification mail
                $client_publication_design_team = $this->db->query("SELECT adreps.first_name, adreps.last_name, adreps.email_id AS adrepEmailId, design_teams.name AS designTeamName, design_teams.email_id AS designTeamEmailId
				                                                        FROM `adreps`
				                                                    JOIN `publications` ON publications.id = adreps.publication_id
				                                                    JOIN `design_teams` ON design_teams.id = publications.design_team_id
				                                                    WHERE adreps.id = '".$aId."'")->row_array();
                include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
        	    $email = new \SendGrid\Mail\Mail();
        		$email->setFrom($client_publication_design_team['designTeamEmailId'], $client_publication_design_team['designTeamName']);
        		$email->setReplyTo('do_not_reply@adwitads.com', 'Do Not Reply');
        		$email->setSubject('Page Design Id - '.$page_design_id.' Section - '.$page_design_section['section_name'].' Deletion Notification.');
        		$email->addContent("text/html", 'Page Design Id - '.$page_design_id.' Section - '.$page_design_section['section_name'].' Deletion Notification.');
        		$email->addTo($client_publication_design_team['adrepEmailId'], $client_publication_design_team['first_name'].' '.$client_publication_design_team['last_name']);
                if($page_design_section['adrep_id'] != $aId){
                    $adrep_detail = $this->db->query("SELECT adreps.email_id FROM `adreps` WHERE adreps.id = '".$page_design_section['adrep_id']."'")->row_array();
                    $email->addCC($adrep_detail['email_id']);     
                }
        		$sendgrid = new \SendGrid('');
        		$response = $sendgrid->send($email);
                
            }    
        //}
        redirect('new_client/home/page_order_view_section/'.$page_design_id);
    }
    
    public function page_edit_section($page_design_id = '', $section_id = '', $order_id = '')  // edit the any page name
    {
        if (isset($_POST['editit'])) 
        {
            $data = array('job_no' => $this->input->post('editrow'));
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
            
            //update live orders content
            $live_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
            if(isset($live_order['id'])){
                $this->db->where('order_id', $order_id);
                $this->db->update('live_orders', $data);    
            }
        }
        redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id.'/'.$order_id);
    }
    
    public function page_remove_section($page_design_id='', $section_id = '', $order_id='') // Page deletion
    {
        //Delete order from orders table
        $this->db->where('id', $order_id);
        $this->db->delete('orders');
        //Delete order entry from live_orders table if exists
        $live_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
        if(isset($live_order['id'])){
            $this->db->where('order_id', $order_id);
            $this->db->delete('live_orders');    
        }
        
        $next_order_detail = $this->db->query("SELECT `id` FROM `orders` WHERE `page_design_id` = '$section_id';")->row_array();

        $replace_no_of_page = $this->db->query("SELECT * FROM `orders` WHERE orders.page_design_id = $section_id")->num_rows();
        
        $data = array('num_pages' => $replace_no_of_page);
        $this->db->where('id', $section_id);
        $this->db->update('page_design_section', $data);
        
        redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id.'/'.$next_order_detail['id']);
    }
    
    public function page_note_section($page_design_id = '', $section_id = '',$order_id = '')    
	{
		if(isset($_POST['complete']))	//if we post the data into database 
		{
			$data = array(
                'notes' => trim($_POST['notes']),
                'status' => '1'
            );     			//store the note_instructions into colun and update it
			$this->db->where('id', $order_id);
			$this->db->update('orders', $data);
			
			if($this->db->affected_rows()){ //if note_instructions insert successful then go next id or else part 
			    //insert the completed order details in live_orders
			    $live_orders = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			    if(!isset($live_orders['id'])){
			        $order_detail = $this->db->query("SELECT orders.publication_id, orders.job_no, orders.club_id FROM `orders` WHERE orders.id = '$order_id'")->row_array();
			        $tracker_data = array(
                            				'pub_id' => $order_detail['publication_id'],
                            				'order_id' => $order_id,
                            				'job_no' => $order_detail['job_no'],
                            				'club_id' => $order_detail['club_id'],
                            				'status' => '1'
                            				);
    			    $this->db->insert('live_orders', $tracker_data);    
			    }
			    redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id.'/'.$order_id);
			}else{
			    redirect('new_client/home/page_order_view_section/'.$page_design_id.'/'.$section_id.'/'.$order_id);
			}
		}
	}
	
	public function page_new_dashboard_section($status = '')
    {
        $aId = $this->session->userdata('ncId');
	    $data['adrep_detail'] = $this->db->query("SELECT adreps.team_orders, adreps.publication_id FROM `adreps` WHERE adreps.id = '".$aId."'")->row_array();
        $this->load->view('page_design_view/page_new_dashboard_section', $data);
    }
   
    public function page_dashboard_content_section()
	{
	    $aId = $this->session->userdata('ncId');
	    $adrep_detail = $this->db->query("SELECT adreps.team_orders, adreps.publication_id FROM `adreps` WHERE adreps.id = '".$aId."'")->row_array();
		if(isset($_GET['from_date'], $_GET['to_date'])){
			$from = date("Y-m-d", strtotime($_GET['from_date'])). " 00:00:00";
            $to = date("Y-m-d", strtotime($_GET['to_date'])). " 23:59:59";
            //main order query(page_design)
            $page_design_query = "SELECT page_design.id, page_design.unique_job_name, page_design.publish_date, CONCAT(adreps.first_name, ' ', adreps.last_name) AS adrepName, page_design_status.name AS page_design_status_name FROM page_design
				                            JOIN `adreps` ON adreps.id = page_design.user_id
						                    JOIN `page_design_status` ON page_design_status.id = page_design.status
				                            WHERE (page_design.created_on BETWEEN '$from' AND '$to')" ;
			//if($adrep_detail['team_orders'] == '1'){
			    $page_design_query .= " AND adreps.publication_id = '".$adrep_detail['publication_id']."'";   
			/*}else{
			    $page_design_query .= " AND page_design.user_id = '".$aId."'";    
			}*/	                            
			$page_design_query .= " AND (";
		    //search or Filter
			if(isset($_GET['search']['value'])){
			    $page_design_query .= ' page_design.unique_job_name LIKE "%'.$_GET["search"]["value"].'%"';

				$page_design_query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';

				$page_design_query .= ' OR page_design.id LIKE "%'.$_GET["search"]["value"].'%"';

				//$page_design_query .= ' OR page_design.advertiser_name LIKE "%'.$_GET["search"]["value"].'%"';

			}
			$page_design_query .= ") ";
			
			//ORDER BY
			//$order_column = array("id", "publish_date", null, "unique_job_name", "adrepName");
			if(isset($_GET['order'])){
				$page_design_query .= ' ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
			}else{
				$page_design_query .= ' ORDER BY page_design.created_on DESC';
			}
			
			$extra_query = '';
			if($_GET['length'] != -1){
				$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
			}
			//echo $page_design_query;
			$filtered_rows = $this->db->query($page_design_query)->num_rows();
			$page_design_query .= $extra_query;
			
			$page_design_orders = $this->db->query("$page_design_query")->result_array();
			$total_rows = $this->db->query($page_design_query)->num_rows();
			
			$data = array();
			foreach($page_design_orders as $page_design_order){
			    $page_design_id = $page_design_order['id'];
			    //sub order query(orders table)
			    //main order row array                            
			    $sub_array = array();
			    $sub_array[] = '<i class="icon fas fa-chevron-circle-down" data-toggle="tooltip" title="Section Details" onclick="LoadOrders($(this), '.$page_design_id.')" ></i>';
			    
				$sub_array[] = $page_design_order['id']; // page_design_id
				$sub_array[] = $page_design_order['unique_job_name'];	// job_no/page name/ publication name
				$sub_array[] = date("M d, Y", strtotime($page_design_order['publish_date']));	// publish_date
				$sub_array[] = '';//$page_design_order['page_design_status_name'];	//status
			//	$sub_array[] = '';
    		//	$sub_array[] = '';
    			
    		//	$sub_array[] = $page_design_order['adrepName'];	// Adrep Name
    			
    			//action items
    		
    			$sub_array[] = '<span><a href="'.base_url().index_page().'new_client/home/page_add_section/'.$page_design_id.'">
    			                    <button type="button" class="btn btn-blue btn-xs btn-circle blue">Add Section </button>
    			                </a></span>
    			                <!--<span data-toggle="modal" data-target=".add-page-modal">
    			                    <button type="button" class="btn btn-blue btn-xs btn-circle blue openBtn" data-page-design-id="'.$page_design_id.'" data-toggle="tooltip" data-bs-placement="top">Add New Page</button>
    			                </span>-->
    			                
				                <span><button type="button" class="btn btn-green btn-xs btn-circle green ">Approve</button></span>
				                
				                <!--<i title="View Details" class="fa fa-chevron-down padding-left-15 pointer" data-toggle="collapse" id="row'.$page_design_id.'" data-target=".row'.$page_design_id.'"></i>-->
				                <!-- <span class="arrow margin-top-10 padding-left-15 margin-left-10 pointer " data-toggle="collapse" id="row'.$page_design_id.'" data-target=".row'.$page_design_id.'" (click)="toggleOpen($event)">
										<span></span>
										<span></span>
								</span>-->';
				$data[] = $sub_array;
			/*	
				$query = "SELECT orders.id, orders.job_no, orders.pdf, orders.status, orders.rev_order_status, orders.page_design_id AS section_id, orders.publish_date, orders.rev_id, 
			    orders.question, orders.crequest, order_status.name AS order_status_name, rev_order_status.name AS rev_order_status_name, rev_sold_jobs.id AS rev_sold_jobs_id, 
			    rev_sold_jobs.question AS rev_question, rev_sold_jobs.pdf_path AS revision_pdf_path,
			    page_design_section.section_name FROM orders
			                                JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
				                            JOIN `order_status` ON order_status.id = orders.status
						                    LEFT JOIN `rev_sold_jobs` ON rev_sold_jobs.id = orders.rev_id
						                    LEFT JOIN `rev_order_status` ON rev_order_status.id = orders.rev_order_status
				                            WHERE page_design_section.page_design_id = '$page_design_id' ORDER BY orders.page_design_id";
				//Individual order details
				$orders = $this->db->query("$query")->result_array();
				$section_id = 0;
				foreach($orders as $order){ 
    			    $pdf_path = $order['pdf']; //initial $pdf_path orders pdf_path
    			    $status = $order['status'];
    			    $revision_status = 0;
    			    if(isset($order['rev_sold_jobs_id'])){ 
    			        $revision_status = $order['rev_order_status'];
    			        $pdf_path = $order['revision_pdf_path']; //overwrite var $pdf_path with revision pdf path value
    			    }
    			    //sub order row array 
    				$sub_array = array();
    				$sub_array[] = ''; //order id
    				$sub_array[] = $page_design_id; //order page_design_id
        			$sub_array[] = date("M d, Y", strtotime($order['publish_date']));	//order publish_date
        			$sub_array[] = '<b>'.$order['section_name'];
        			$sub_array[] = $order['job_no'];	//order job_no/page name
        			$sub_array[] = '';//$order['advertiser_name']; //order advertiser_name
        			$sub_array[] = $page_design_order['adrepName']; //order Adrep Name
        			
        			//Order Status START
        			$pending_status = array(9, 10, 11);
        			if(in_array($status, $pending_status)){ //pending or draft
        			    $order_status = '<a href="'.base_url().index_page().'new_client/home/page_order_view_section/'.$page_design_id.'/'.$order['section_id'].'/'.$order['id'].'">Pending</a>';
        			//}elseif($order['question'] == '1' || $order['rev_question'] == '1'){ //Question sent
        			 //   $order_status = 'Question';	
        			}else{
        			    if(isset($order['rev_order_status_name'])){ //if in revision get revision status
        			        $order_status = $order['rev_order_status_name'];
        			    }else{
            			    $order_status = $order['order_status_name'];
        			    }
        			    if($order['question'] == '1' || $order['rev_question'] == '1') $order_status .= '<p><small>(Question)</small></p>'; //order in question
            			if($order['crequest']!='0') $order_status .= '<p><small>(Cancel Requested)</small></p>'; //order cancel request
        			}
        			$sub_array[] = $order_status;	//order Status
        			//Order Status END
        			
        			//Order Action START
        			$order_add_new = ''; $order_detail_view = ''; $order_additional_attachment = ''; $order_question_answer = ''; $order_view_pdf = ''; $order_submit_revision = ''; $order_approve = '';
        			if($section_id != $order['section_id']){
        			    $order_add_new = '<span><a href="'.base_url().index_page().'new_client/home/page_add_new/'.$order['section_id'].'">
    			                    <button type="button" class="btn btn-blue btn-xs btn-circle blue">Add New Page</button>
    			                </a></span>';
        			}
        			$order_detail_view = '
            			                    <a href="'.base_url().index_page().'new_client/home/order_action/view/'.$order['id'].'" >
            			                    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/order_view.png">
        									<!--<i class="bi bi-eye-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="View Order"></i>-->
        									</a>
        							';
        			if($status == '1' || $status == '2' || $status == '3') {
        			    $order_additional_attachment = '
                        								    <a href="'.base_url().index_page().'new_client/home/page_additional_attachment/'.$order['id'].'" >
                        								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/attachment.png">
                        									<!--<i class="bi bi-paperclip fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Additional Attachment"></i>-->
                        									</a>
                        								';
                        								
        			}
        			//Question START 
        			if($order['question']=='1'){
        			    $order_question_answer = '
                    								    <a href="'.base_url().index_page().'new_client/home/new_ad_answer/'.$order['id'].'" >
                    										<i class="bi bi-chat fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Answer Question"></i>
                    									</a>
                    								';
        			}elseif($order['rev_question'] == '1'){
        			    $order_question_answer = '
                    								    <a href="'.base_url().index_page().'new_client/home/rev_ad_answer/'.$order['rev_id'].'" >
                    										<i class="bi bi-chat fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Answer Question"></i>
                    									</a>
                    								';
        			}
        			//Question END
        			$order_pdf_status = array(5, 7); $revision_pdf_status = array(0, 5, 9);
        			if(in_array($status, $order_pdf_status) && in_array($revision_status, $revision_pdf_status) && $pdf_path != 'none' && file_exists($pdf_path)){
        			    $order_view_pdf = '
    								    <a href="'.base_url().$pdf_path.'" target="_blank">
    								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/pdf.png">
    									    <!--<i class="bi bi-file-earmark-pdf-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="View PDF"></i>-->
    									</a>
    								';    
        			}
        			if($status == '5' && ($revision_status == '0' || $revision_status == '5')){
        			   $order_submit_revision = '
                								    <a href="'.base_url().index_page().'new_client/home/new_order_revision/'.$order['id'].'" >
                								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/revision.png">
                									    <!--<i class="bi bi-gear-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Submit Revision"></i>-->
                								    </a>
                								'; 
        			}
        			if($status == '5' && ($revision_status == '0' || $revision_status == '5')){
        			    $order_approve = '<span data-toggle="modal" data-target=".bs-example-modal-new">
        								    <i class="bi bi-pen-fill fs-2 p-2" data-toggle="tooltip" data-bs-placement="top" title="Approve ad" ></i>
        								</span>';
        			}
        			$order_action = $order_add_new.$order_detail_view.$order_additional_attachment.$order_question_answer.$order_view_pdf.$order_submit_revision.$order_approve;
        			$sub_array[] = $order_action;	//order Action
    				//Order Action END
    				
        			$data[] = $sub_array;
        			$section_id = $order['section_id'];
    			}*/
			}
			$output = array(
							"draw"    => intval($_GET["draw"]),
							"recordsTotal"  => $total_rows,
							"recordsFiltered" => $filtered_rows,
							"data"    => $data
						   );
			echo json_encode($output);
		}
	}
	
	public function page_orders_section($page_design_id='')
	{
	    $output = '';
	  	$query = "SELECT orders.id, orders.job_no, orders.pdf, orders.status, orders.rev_order_status, orders.page_design_id AS section_id, orders.publish_date, orders.rev_id, 
			    orders.question, orders.crequest, order_status.name AS order_status_name, rev_order_status.name AS rev_order_status_name, rev_sold_jobs.id AS rev_sold_jobs_id, 
			    rev_sold_jobs.question AS rev_question, rev_sold_jobs.pdf_path AS revision_pdf_path,
			    page_design_section.section_name, CONCAT(adreps.first_name,' ',adreps.last_name) AS adrepName FROM orders
			                                JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
				                            JOIN `order_status` ON order_status.id = orders.status
						                    LEFT JOIN `rev_sold_jobs` ON rev_sold_jobs.id = orders.rev_id
						                    LEFT JOIN `rev_order_status` ON rev_order_status.id = orders.rev_order_status
						                    JOIN `adreps` ON adreps.id = orders.adrep_id
				                            WHERE page_design_section.page_design_id = '$page_design_id' ORDER BY orders.page_design_id";
		//Individual order details
		$orders = $this->db->query("$query")->result_array();  
		if(isset($orders[0]['id'])){
		    $section_id = 0; 
		    $output .= '<tr id="row1" class="sub-table">
		            <td></td>
					<td colspan="5">
						<table class="table">
							<thead>
								<tr>
									<th><i>Section</i></th>
									<th><i>Page</i></th>
									<th><i>Adrep</i></th>
									<th><i>Status</i></th>
									<th><i>Action</i></th>
								</tr>
							</thead>
							<tbody>';
			foreach($orders as $order){ 
    		    $pdf_path = $order['pdf']; //initial $pdf_path orders pdf_path
    		    $status = $order['status'];
    		    $revision_status = 0;
    		    if(isset($order['rev_sold_jobs_id'])){ 
    			    $revision_status = $order['rev_order_status'];
    			    $pdf_path = $order['revision_pdf_path']; //overwrite var $pdf_path with revision pdf path value
    			}
    			$output .= '<tr>';
    			
				
        		$output .= '<td>'.$order['section_name'].'</td>';
        		$output .= '<td>'.$order['job_no'].'</td>';//order job_no/page name
        		$output .= '<td>'.$order['adrepName'].'</td>'; //order Adrep Name
        			
        			//Order Status START
        			$pending_status = array(9, 10, 11);
        			if(in_array($status, $pending_status)){ //pending or draft
        			    $order_status = '<a href="'.base_url().index_page().'new_client/home/page_order_view_section/'.$page_design_id.'/'.$order['section_id'].'/'.$order['id'].'">Pending</a>';
        			//}elseif($order['question'] == '1' || $order['rev_question'] == '1'){ //Question sent
        			 //   $order_status = 'Question';	
        			}else{
        			    if(isset($order['rev_order_status_name'])){ //if in revision get revision status
        			        $order_status = $order['rev_order_status_name'];
        			    }else{
            			    $order_status = $order['order_status_name'];
        			    }
        			    if($order['question'] == '1' || $order['rev_question'] == '1') $order_status .= '<p><small>(Question)</small></p>'; //order in question
            			if($order['crequest']!='0') $order_status .= '<p><small>(Cancel Requested)</small></p>'; //order cancel request
        			}
        		$output .= '<td>'.$order_status.'</td>';	//order Status
        			//Order Status END
        			
        			//Order Action START
        			$order_add_new = ''; $order_detail_view = ''; $order_additional_attachment = ''; $order_question_answer = ''; $order_view_pdf = ''; $order_submit_revision = ''; $order_approve = '';
        			if($section_id != $order['section_id']){
        			    $order_add_new = '<span><a href="'.base_url().index_page().'new_client/home/page_add_new/'.$order['section_id'].'">
            			                    <i class="icon fas fa-plus" data-toggle="tooltip" title="Add New Page"></i>
            			                </a></span>';
        			}
        			$order_detail_view = '
            			                    <a href="'.base_url().index_page().'new_client/home/order_action/view/'.$order['id'].'" >
            			                    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/order_view.png">
        									<!--<i class="bi bi-eye-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="View Order"></i>-->
        									</a>
        							';
        			if($status == '1' || $status == '2' || $status == '3') {
        			    $order_additional_attachment = '
                        								<a href="'.base_url().index_page().'new_client/home/page_additional_attachment/'.$order['id'].'" >
                        								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/attachment.png">
                        									<!--<i class="bi bi-paperclip fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Additional Attachment"></i>-->
                        								</a>
                        								';
                        								
        			}
        			//Question START 
        			if($order['question']=='1'){
        			    $order_question_answer = '
                    								    <a href="'.base_url().index_page().'new_client/home/new_ad_answer/'.$order['id'].'" >
                    										<i class="bi bi-chat fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Answer Question"></i>
                    									</a>
                    								';
        			}elseif($order['rev_question'] == '1'){
        			    $order_question_answer = '
                    								    <a href="'.base_url().index_page().'new_client/home/rev_ad_answer/'.$order['rev_id'].'" >
                    										<i class="bi bi-chat fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Answer Question"></i>
                    									</a>
                    								';
        			}
        			//Question END
        			$order_pdf_status = array(5, 7); $revision_pdf_status = array(0, 5, 9);
        			if(in_array($status, $order_pdf_status) && in_array($revision_status, $revision_pdf_status) && $pdf_path != 'none' && file_exists($pdf_path)){
        			    $order_view_pdf = '
    								    <a href="'.base_url().$pdf_path.'" target="_blank">
    								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/pdf.png">
    									    <!--<i class="bi bi-file-earmark-pdf-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="View PDF"></i>-->
    									</a>
    								';    
        			}
        			if($status == '5' && ($revision_status == '0' || $revision_status == '5')){
        			   $order_submit_revision = '
                								    <a href="'.base_url().index_page().'new_client/home/new_order_revision/'.$order['id'].'" >
                								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/revision.png">
                									    <!--<i class="bi bi-gear-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Submit Revision"></i>-->
                								    </a>
                								'; 
        			}
        			if($status == '5' && ($revision_status == '0' || $revision_status == '5')){
        			    $order_approve = '<span data-toggle="modal" data-target=".bs-example-modal-new">
        								    <i class="bi bi-pen-fill fs-2 p-2" data-toggle="tooltip" data-bs-placement="top" title="Approve ad" ></i>
        								</span>';
        			}
        			$order_action = $order_add_new.$order_detail_view.$order_additional_attachment.$order_question_answer.$order_view_pdf.$order_submit_revision.$order_approve;
        			$output .= '<td>'.$order_action.'</td>';	//order Action
				
				$output .= '</tr>';
			}
			$output .= '</tbody>
						</table>
					</td>
				</tr>';
				
		}else{
		    $output .= '<tr id="row1" class="sub-table">
		            <td></td>
					<td colspan="5">No Data Available</td>
				</tr>';
		}
		echo $output;
	}
	
/****************** Section END *********************/    
    public function page_order( $page_design_id='')		//page_order is receive the id of page_design //order form page-2
    {
    	$page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
        //get the id of single row then it store the $No_of_pages
        $num_pages = $page_design['No_of_pages']; 	
        // $No_of_pages get the id of page  ('No_of_pages') will give the value stored in num_pages
        $adrep_id = $this->session->userdata('ncId');
        $publication_id = $page_design['publication_id'];
        
        if($publication_id != 0){
            $query = "SELECT publications.id AS publication_id, publications.group_id, publications.help_desk, publications.club_id 
		                                            FROM `publications` WHERE publications.id = '$publication_id'";    
        }else{
            $query = "SELECT adreps.publication_id, publications.group_id, publications.help_desk, publications.club_id FROM `adreps`
	   				JOIN `publications` ON  publications.id = adreps.publication_id
	   				WHERE adreps.id = '$adrep_id'";
        }
		$adrep_details = $this->db->query("$query")->row_array();
		
        for ($i=1; $i <=$num_pages ; $i++)   //$num_pages we get the value that value to get number of pages     
		{ 
            $data1 = array(						//post the array of data into database pages
				'adrep_id' => $adrep_id,
				'publication_id' => $adrep_details['publication_id'],
				'group_id' => $adrep_details['group_id'],
				'help_desk' => $adrep_details['help_desk'],
				'order_type_id' => '6',
				'advertiser_name' => $page_design['unique_job_name'],
				'job_no' => 'Page '.$i,
				'publish_date' => $page_design['publish_date'], 
				'activity_time' => date('Y-m-d h:i:s'),
				'page_design_id' => $page_design_id,
				'status' => '9',
				'club_id' => $adrep_details['club_id']
                //'pd_id'=>$page_design_id,
                //'page_no'=>'Page '.$i,
                //'status'=>'0'                   
            );
            $this->db->insert('orders',$data1);
            $order_id = $this->db->insert_id();
        }

		$order_details = $this->db->query("SELECT * FROM `orders` where `page_design_id`= '$page_design_id';")->row_array();  //$pid will fetch the pd_id[id]
		redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$order_details['id']);// redirect to the page_oreder_view with page_design id and pages id
    }   
    
    public function page_order_view($page_design_id = '', $order_id = '')     //order form page-2	//receiving the id and pid
    {
        $statusinf = $this->db->query("SELECT orders.status FROM `orders` WHERE orders.id = $order_id")->row_array();
        //shifting the pending to selected if completed the order this is exited
        $edit_not_allowed_status = array(1,2,3,4,5,6,7,8);
        if (!in_array($statusinf['status'], $edit_not_allowed_status) )//if status not equal to submitted(order recieved) 
        {
            $data1 = array('status' => '10'); //change to selected
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data1);
			//echo 'pages01 : '.$this->db->_error_message();
        }

        $orders_detail = $this->db->query("SELECT orders.id, orders.job_no, orders.id, orders.id, orders.status, order_status.name  FROM `orders`
                                            JOIN `order_status` ON order_status.id = orders.status
                                            WHERE orders.page_design_id = $page_design_id;")->result_array(); // $page_no will fetch the pd_id
        $order_detail = $this->db->query("SELECT * FROM `orders` WHERE orders.id = $order_id")->row_array();

        //shifting the select or pending
        if ($order_detail['status'] == '10' )//if status equal to selected, condition exits if not 
        {
            $data1 = array('status' => '9'); // change into 0 - pending
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data1);
			//echo 'pages02 : '.$this->db->_error_message();
        }
        //file list
		$download_file_path = $order_detail['file_path'];
		if($download_file_path != 'none' && file_exists($download_file_path)){
			//articles list
			$articles_path = $download_file_path.'/articles';
			if(file_exists($articles_path) && $atp = opendir($articles_path)){
				while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
				{
					if ($file == '.' || $file == '..')  //.,.. get 
					{
						continue; // left that and continue next
					}
					if($file) // file get 
					{ 
						$articlename[]=$file;//store all article name in array
					}
					$data['articles_name'] = $articlename;// array of name will stored in articles_name
				}
				closedir($atp);//dirctry $atp clocsed
			}
			//ads list
			$ads_path = $download_file_path.'/ads';
			if(file_exists($ads_path) && $dh = opendir($ads_path)){ //check the notnull exitsfile and openfile
				while(($file = readdir($dh)) !== false)  //loop to read the file path then store it
				{
					if($file == '.' || $file == '..') //.,.. get 
					{ 
						continue;  // left that and continue next
					}
					if($file) // file get 
					{ 
						$filename[] = $file;  //store all file name in array
					}
					$data['file_names1'] = $filename;  // array of name will stored in file_name1
				}
				closedir($dh); //dirctry $dh clocsed
			}
		}
		
        $data['order'] = $order_detail;  //$data will store the page_design id result array
        $data['orders'] = $orders_detail;	//$data will store the page_design id row array
		$data['pid'] = $order_id;	//$pid of pages																	
		$data['id'] = $page_design_id;    //$id of page_design
		$data['page_design_page_count'] = $this->db->query("SELECT page_design.No_of_pages, page_design.unique_job_name FROM `page_design` WHERE page_design.id = '$page_design_id'")->row_array();
        $this->load->view('page_design_view/page_order_placed', $data);		//view the page_order_placed with $data 
    }
    
	public function page_artical_upload($order_id = '')          //receive the pages id and page_design id  upload the articles
    {
		$order_details = $this->db->get_where('orders', array('id' => $order_id))->row_array();
		if(isset($order_details['id'])){
			if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
			{
				$name = $_FILES['file']['name'];
				$temp_name = $_FILES['file']['tmp_name'];

				if($order_details['file_path'] == 'none'){
					$download_path = "downloads/".$order_details['id']."-".$order_details['job_no']; //path specification
					if (@mkdir($download_path,0777)){}
					
					//save path
						$post = array('file_path' => $download_path);
						$this->db->where('id', $order_id);
						$this->db->update('orders', $post);	
				}else{ $download_path = $order_details['file_path']; }
				
				$articles_path = $download_path."/articles";        // articles folder 
				if(!file_exists($articles_path)){
					if(@mkdir($articles_path,0777)){} 
				}                                     
				
				date_default_timezone_set('Asia/Kolkata');
				$filepath = $articles_path.'/'. date('d_m_Y_h_i_s') . '_'.$name; 

				move_uploaded_file($temp_name, $filepath);   
			}
		}
    }
   
	public function page_remove_att($order_id='') // remove the articles  files
    {
       $order_details = $this->db->query("SELECT orders.id, orders.file_path FROM orders WHERE orders.id = '$order_id'")->row_array();

        if (isset($order_details['id'])&& isset($_POST['filename'])) 
        {
            $filename = $_POST['filename']; //get filename
            $filepath = $order_details['file_path'].'/articles';  //in database articles column we get the path
			if(file_exists($filepath)){
				$dirhandle = opendir($filepath);    //open the directry using FILEPATH 
				while ($file = readdir($dirhandle))  // read the FILEPATH
				{
					if ($file == $filename) //in filepath location get filename 
					{
						unlink($filepath.'/'.$filename);    // unlink it
					}
				}
			}
        }
	}
    
    public function page_ads_upload($order_id = '')   //receive the pages id and page_design id  upload the ads
    {
		$order_details = $this->db->get_where('orders',array('id' => $order_id))->row_array();
		if(isset($order_details['id'])){
			if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
			{
				$name = $_FILES['file']['name'];
				$temp_name = $_FILES['file']['tmp_name'];

				if($order_details['file_path'] == 'none'){
					$download_path = "downloads/".$order_details['id']."-".$order_details['job_no']; //path specification
					if (@mkdir($download_path,0777)){}
					
					//save path
						$post = array('file_path' => $download_path);
						$this->db->where('id', $order_id);
						$this->db->update('orders', $post);	
				}else{ $download_path = $order_details['file_path']; }
				
				$ads_path = $download_path."/ads";        // articles folder 
				if(!file_exists($ads_path)){
					if(@mkdir($ads_path,0777)){} 
				}                                     
				
				date_default_timezone_set('Asia/Kolkata');
				$filepath = $ads_path.'/'. date('d_m_Y_h_i_s') . '_'.$name; 
				
				move_uploaded_file($temp_name, $filepath);   
			}
		}
    }
    
	public function page_remove_ads($order_id = '') // remove the ads file uploads 
    {
        $order_details = $this->db->query("SELECT orders.id, orders.file_path FROM orders WHERE orders.id = '$order_id'")->row_array();

        if (isset($order_details['id'])&& isset($_POST['filename'])) 
        {
            $filename = $_POST['filename']; //get filename
            $filepath = $order_details['file_path'].'/ads';  //get ads path
			if(file_exists($filepath)){
				$dirhandle = opendir($filepath);    //open the directry using FILEPATH 
				while ($file = readdir($dirhandle))  // read the FILEPATH
				{
					if ($file == $filename) //in filepath location get filename 
					{
						unlink($filepath.'/'.$filename);    // unlink it
					}
				}
			}
        }
    }
	
	public function page_note($page_design_id = '',$order_id = '')    //receive the pages id and page_design id 
	{
		if(isset($_POST['complete']))	//if we post the data into database 
		{
		    $current_timestamp = date('Y-m-d H:i:s');
			$data = array(
                'notes' => trim($_POST['notes']),
                'status' => '1',
                'created_on' => $current_timestamp
            );     			//store the note_instructions into colun and update it
			$this->db->where('id', $order_id);
			$this->db->update('orders', $data);
			if($this->db->affected_rows()){ //if note_instructions insert successful then go next id or else part 
			    
			    //insert the completed order details in live_orders
			    $live_orders = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			    if(!isset($live_orders['id'])){
			        $order_detail = $this->db->query("SELECT orders.publication_id, orders.job_no, orders.club_id FROM `orders` WHERE orders.id = '$order_id'")->row_array();
			        $tracker_data = array(
                            				'pub_id' => $order_detail['publication_id'],
                            				'order_id' => $order_id,
                            				'job_no' => $order_detail['job_no'],
                            				'club_id' => $order_detail['club_id'],
                            				'status' => '1'
                            				);
    			    $this->db->insert('live_orders', $tracker_data);  
    			    $this->orders_folder($order_id);//html file creation
			    }
			    redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$order_id);
			}else{
			     redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$order_id);
			}
		}
	}
   
	public function page_add($page_design_id='') // add new page 
    {
        //if (isset($_POST['add'])){
            $page_design = $this->db->query("SELECT * FROM page_design where page_design.id = $page_design_id ;")->row_array();
            if(isset($page_design['id'])){
                    if(isset($_POST['addrow']) && !empty($_POST['addrow'])){
                        $page_name = $_POST['addrow'];
                    }else{
                        $page_name = 'New Page';
                    }
                    $adrep_id = $this->session->userdata('ncId');
                    $publication_id = $page_design['publication_id'];
        
                    if($publication_id != 0){
                        $query = "SELECT publications.id AS publication_id, publications.group_id, publications.help_desk, publications.club_id 
            		                                            FROM `publications` WHERE publications.id = '$publication_id'";    
                    }else{
                        $query = "SELECT adreps.publication_id, publications.group_id, publications.help_desk, publications.club_id FROM `adreps`
            	   				JOIN `publications` ON  publications.id = adreps.publication_id
            	   				WHERE adreps.id = '$adrep_id'";
                    }
                    $adrep_details = $this->db->query("$query")->row_array();
        		    
        		    $data1 = array(						//post the array of data into database pages
        				'adrep_id' => $adrep_id,
        				'publication_id' => $adrep_details['publication_id'],
        				'group_id' => $adrep_details['group_id'],
        				'help_desk' => $adrep_details['help_desk'],
        				'order_type_id' => '6',
        				'advertiser_name' => $page_design['unique_job_name'],
        				'job_no' => $page_name,
        				'publish_date' => $page_design['publish_date'], 
        				'activity_time' => date('Y-m-d h:i:s'),
        				'page_design_id' => $page_design_id,
        				'status' => '9',
        				'club_id' => $adrep_details['club_id']
                    );
                    $this->db->insert('orders', $data1);
        			$order_id = $this->db->insert_id();
        		    if(isset($order_id)){
        		        $replace_no_of_page = $this->db->query("SELECT `id` FROM `orders` WHERE orders.page_design_id = '$page_design_id'")->num_rows();
                
                        $data = array('No_of_pages' => $replace_no_of_page);
                        $this->db->where('id', $page_design_id);
                        $this->db->update('page_design', $data);
                       
                        redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$order_id);    
        		    }
            }
        //}
    }
    
	public function page_edit($page_design_id = '',$order_id = '')  // edit the any page name
    {
        if (isset($_POST['editit'])) 
        {
            $data = array('job_no' => $this->input->post('editrow'));
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
            
            //update live orders content
            $live_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
            if(isset($live_order['id'])){
                $this->db->where('order_id', $order_id);
                $this->db->update('live_orders', $data);    
            }
        }
        redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$order_id);
    }
    
	public function page_remove($page_design_id='', $order_id='') // remove the any page 
    {
        //Delete order from orders table
        $this->db->where('id', $order_id);
        $this->db->delete('orders');
        //Delete order entry from live_orders table if exists
        $live_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
        if(isset($live_order['id'])){
            $this->db->where('order_id', $order_id);
            $this->db->delete('live_orders');    
        }
        
        $next_order_detail = $this->db->query("SELECT `id` FROM `orders` WHERE `page_design_id` = '$page_design_id';")->row_array();

        $replace_no_of_page = $this->db->query("SELECT * FROM `orders` WHERE orders.page_design_id = $page_design_id")->result_array();
        $i=0;
        foreach ($replace_no_of_page as $key) {
            $i++;
        }
        $data = array('No_of_pages' => $i);
        $this->db->where('id', $page_design_id);
        $this->db->update('page_design', $data);

        redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$next_order_detail['id']);
    }
    
	public function page_complete_orders($page_design_id='',$order_id='')// complete all page orders //order form page-2
    {
        if (isset($_POST['complete_order']))
        {
            $page_design = $this->db->query("SELECT * FROM `page_design` WHERE `id` = '".$page_design_id."'")->row_array();
            $order_details = $this->db->query("SELECT orders.id, orders.job_no FROM `orders` 
                                                WHERE orders.page_design_id = $page_design_id 
                                                AND orders.status IN(SELECT orders.status FROM `orders` WHERE orders.status='9' or orders.status='10');")->row_array(); //pages.pd_id will check the id of page design subquery is checking the status 0 or 1  
            if(isset($order_details['id'])){ // if we get 0 or 1 the which page is 0 or 1 that will shown
                $message = "<div class='margin-bottom-20'><div class='flashmsg'><font color='000' value=".$order_details['id'].">".$order_details['job_no']."</font> is Pending.</div></div>";
                $this->session->set_flashdata('item',$message );
                redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$order_id);
            }else{// else submitted the orders
             	//email notification to adrep and itsupport@adwitads.com
				$client_publication_design_team = $this->db->query("SELECT adreps.first_name, adreps.last_name, adreps.email_id AS adrepEmailId,
				                                                        design_teams.name AS designTeamName, design_teams.email_id AS designTeamEmailId
				                                                        FROM `adreps`
				                                                    JOIN `publications` ON publications.id = adreps.publication_id    
				                                                    JOIN `design_teams` ON design_teams.id = publications.design_team_id
				                                                    WHERE adreps.id = '".$this->session->userdata('ncId')."'")->row_array();
				//$this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->row_array();
				$publication_detail = $this->db->query("SELECT publications.id, publications.club_id FROM `publications`
				                                            WHERE publications.id = '".$page_design['publication_id']."'")->row_array();
				//Live_tracker updation
		        
		            $orders = $this->db->query("SELECT orders.id, orders.job_no FROM `orders` 
                                                WHERE orders.page_design_id = '$page_design_id';")->result_array();
                    foreach($orders as $order){
                        $tracker_data = array(
                            				'pub_id' => $publication_detail['id'],
                            				'order_id' => $order['id'],
                            				'job_no' => $order['job_no'],
                            				'club_id' => $publication_detail['club_id'],
                            				'status' => '1'
                            				);
    					$this->db->insert('live_orders', $tracker_data);
    					    
                    }                            
		       
				//$design_team = $this->db->query("SELECT `name`, `email_id` FROM `design_teams` where `id` = '".$publication['design_team_id']."'")->row_array();
				
				$data['from'] = 'pagination@adwitads.com';
				$data['from_display'] = 'Design Team';

				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo_display'] = 'Do not reply';
				
				$data['subject'] = 'AdwitAds Pagination Order #'.$page_design_id;
				
				$data['recipient'] = $client_publication_design_team['adrepEmailId'];
				$data['recipient_display'] = $client_publication_design_team['first_name'].' '.$client_publication_design_team['last_name'];
				$data['client_publication_design_team'] = $client_publication_design_team;
				$data['order'] = $page_design;
				//$data['design_team'] = $design_team;
				
				$this->page_newad_send_mail($data);
				
				$message = "Order No.".$page_design_id." is Successfully Completed. Please visit Dashboard to view the Status.";
                $this->session->set_flashdata('item',$message );
                redirect('new_client/home/page_change/'.$page_design_id.'/completed');
            }   
        }
    } 
    
    public function page_newad_send_mail($data) 
	{
	    include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
 
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($data['from'], $data['from_display']);
		$email->setReplyTo($data['replyTo'],$data['replyTo_display']);
		$email->setSubject($data['subject']);
		$email->addContent("text/html", $this->load->view('pagination_emailer/newad_placed_notification_emailer', $data, TRUE));
		$email->addTo($data['recipient'], $data['recipient_display']);

		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		
	}
	
	public function page_change($page_design_id = '',$order_id = '') // It show the all page orders details
    {
        
        $pagedesignId = $this->db->query("SELECT * FROM `page_design` WHERE page_design.id = '$page_design_id' ;")->row_array();
		//check for any pending orders
        $orders_check = $this->db->query("SELECT orders.id FROM `orders` WHERE orders.page_design_id = '$page_design_id' AND orders.status IN (9,10);")->row_array(); //pending, selected
		
		if(isset($pagedesignId['id'])){
			if(isset($orders_check['id'])){
				$this->session->set_flashdata('item', "There are Still Pending Orders Left..!!" );
				redirect('new_client/home/page_order_view/'.$page_design_id.'/'.$orders_check['id']);
			}else{
				//update page design status to 2
				$data = array('status' => '2' );
				$this->db->where('id', $page_design_id);
				$this->db->update('page_design', $data);
				
				//update order status individually
				$orders = $this->db->query("SELECT * FROM  `orders` WHERE orders.page_design_id = $page_design_id;")->result_array();
				foreach($orders as $order){
					$order_data = array('status' => '1' );// update order status to 1(order recieved)
					$this->db->where('id', $order['id']);
					$this->db->update('orders', $order_data);
				}
					
				$data['pagedesignId'] = $pagedesignId;
				$data['pagesId'] = $orders;
				$this->load->view('page_design_view/place_changes',$data);
			}
		}
    }
    
	public function page_dashboard($num = '1') // dashboard and it list the all Page Design Data and you will search and advance search an do it
    {
        $this->load->library('pagination'); // library import
        
        //pagination
        $rowsPerPage = 10; //each page 10 row
        $offset = ($num - 1) * $rowsPerPage; //num - 1 is page 1

        $query = "SELECT * FROM `page_design` WHERE `user_id` != '0'"; //select the all recordes
        if (isset($_GET['search'])){  // get button search
		
            $keyword = $_GET['input']; // key work input any id or name
            if (isset($keyword) and !empty($keyword)){ // not empty and set keyword
                $query .=" AND (`id` = '$keyword' OR `unique_job_name` LIKE '%".$keyword."%')"; // query runs
            } 
        }elseif(isset($_GET['adv_search'])){ //get button adv_search
		
            $keyword = $_GET['keyword'];// key work input any id or name
            $from = $_GET['from_dt']; // from date
            $to = $_GET['to_dt'];// to date
            $status = $_GET['status'];// status
            if(!empty($keyword)){//if keyword set goes here
			
                $query .=" AND (`id` = '$keyword' OR`unique_job_name` LIKE '%".$keyword."%')";// query runs
            }
			
			if(!empty($from) && !empty($to)){ //if keyword not set but date set then goes here
			
                $from = date('Y-m-d',strtotime($from));
                $to = date('Y-m-d',strtotime($to));
                $query .= " AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ";
            }
            if(!empty($status) && $status != "All"){//if only status set goes here
			
                $query .= " AND `status` = '".$status."'";
            }
            $data['keyword'] = $keyword;
            $data['from'] = $from;
            $data['to'] = $to;
            $data['status'] = $status;
        }
        $data['order_count'] = $this->db->query("$query")->num_rows(); //$query give the number of rows 
        $page_design = $this->db->query("$query ORDER BY `id` DESC LIMIT $offset, $rowsPerPage;")->result_array(); 
        if(isset($page_design[0]['id']))
        {
            $data['all'] = $page_design;
            $data['num'] = $num;
            $data['rowsPerPage'] = $rowsPerPage;
            $data['offset'] = $offset;
        }
        $this->load->view('page_design_view/dashboard',$data);
    }
    
	public function page_ads_details($id)
	{
		$page_design = $this->db->query("SELECT * FROM `page_design` WHERE page_design.id = $id ;")->row_array();
		$pages = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id = $id ;")->result_array();
		$page_revision = $this->db->query("SELECT * FROM `page_revision` WHERE `pd_id` = $id AND `status`!='0' ;")->result_array();
		//$pages = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id = $id;")->result_array(); 
		if(isset($page_design['id'])){
		    $data['id'] = $id;
			$data['page_design'] = $page_design;
			$data['pages'] = $pages;
			$data['page_revision'] = $page_revision;
			$this->load->view('page_design_view/page_ads_details',$data);
		}
	}
	//approve page for production
	public function page_approve($id)
	{
	    if(isset($_POST['id'])){
	        $page_id = $_POST['id'];
	        $data = array('approve' => '1' );
            $this->db->where('id', $page_id);
            $this->db->update('pages',$data);
            echo "success";
	        //echo 'pd : '.$id.' page: '.$page_id;
	    }
	    
	}
	
	public function no_of_pages($id='')
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id = $id;")->result_array();
        $data['all'] = $page;
        $this->load->view('page_design_view/no_of_pages',$data);
    }
    
    //new(22 Apr 2022)
    public function page_order_revision($order_id='')
    {
        $order_details = $this->db->query("SELECT orders.id, orders.job_no, orders.advertiser_name, cat_result.slug FROM `orders`
                                            JOIN `cat_result` ON cat_result.order_no = orders.id
                                            WHERE orders.id = '$order_id' AND orders.status = '5'")->row_array();
        if(isset($order_details['id'])){
            $rev_sold_job =  $this->db->query("SELECT rev_sold_jobs.id, rev_sold_jobs.new_slug, rev_sold_jobs.status FROM `rev_sold_jobs` 
                                                WHERE rev_sold_jobs.order_id = '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->row_array(); //pick the recent revision
                                                
			if(isset($rev_sold_job['id'])){
			    if($rev_sold_job['status'] != '5'){ //check status for recent revision
			        $this->session->set_flashdata("message", "Heads up! The order with this OrderID is currently in production status, so certain actions may not be permitted. Review the order's status for more details.");
				    redirect('new_client/home/page_new_dashboard'); 
			    }
				$slug = $rev_sold_job['new_slug'];
			}else{
				$slug = $order_details['slug'];
			}
			
			if($slug == 'none'){
				$this->session->set_flashdata("message", "Heads up! The order with this OrderID is currently in production status, so certain actions may not be permitted. Review the order's status for more details.");
				redirect('new_client/home/page_new_dashboard');
			}
			
			if(!isset($_POST['cacheid'])){	
				$post_data = array(
						'order_id' => $order_id,
						'order_slug' => $slug,
						'adrep' => $this->session->userdata('ncId')
						);
				$this->db->insert('revision_order_cache', $post_data);
				$cacheid = $this->db->insert_id();
				$data['cacheid'] = $cacheid;
			}
			
			if(isset($_POST['rev_submit'])){
				$cacheid = $_POST['cacheid'];
				$version = 'V1a'; //initialse version 
				
				if(isset($rev_sold_job['id'])){ //if there is already revision data then update version 
					
					$version = $rev_sold_job['version'];
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
				}
				//$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				$adrep_publication_detail = $this->db->query("SELECT adreps.id AS adrep_id,adreps.first_name, adreps.last_name, adreps.email_id, adreps.email_cc, publications.id AS publication_id, publications.help_desk, publications.design_team_id FROM `adreps`
				                                    JOIN `publications` ON publications.id = adreps.publication_id
				                                    WHERE adreps.id = '".$this->session->userdata('ncId')."'")->row_array();
				
				$rev_data = array(
					'order_id'  => $order_id,
					'order_no'  => $_POST['job_slug'],
					'adrep'     => $this->session->userdata('ncId'),
					'help_desk' => $adrep_publication_detail['help_desk'],
					'date'      => date('Y-m-d'),
					'time'      => date("H:i:s"),
					'category'  => 'revision',
					'version'   => $version,
					'note'      => $_POST['notes'],
					'status'    => '1',
					);
				$this->db->insert('rev_sold_jobs', $rev_data);
				$rev_id = $this->db->insert_id(); 
				
				if($rev_id){
					//Live_tracker Revision updation
					$tracker_data = array(
						'pub_id'=> $adrep_publication_detail['publication_id'],
						'order_id' => $order_id,
						'revision_id'=> $rev_id,
						'status' => '1'
					);
					$this->db->insert('live_revisions', $tracker_data);
					
					$revision = $this->db->query("SELECT rev_sold_jobs.id, rev_sold_jobs.order_no, rev_sold_jobs.file_path FROM `rev_sold_jobs` 
					                                WHERE rev_sold_jobs.id`= '$rev_id';")->row_array();
					//Revision details of the order
					$rev_count = $order_details['rev_count'];
					if(empty($rev_count)){ $rev_count = 0; }
					$rev_count_data = array(
                    					    'rev_count' => $rev_count + 1, 
                    					    'rev_id' => $rev_id,
                    					    'rev_order_status' => '1', //Revision Submitted
                    					    'activity_time' => date('Y-m-d h:i:s'),
                    					);
					$this->db->where('id', $order_id);
					$this->db->update('orders', $rev_count_data);
					
					//folder creation
					$path="revision_downloads/".$order_id.'-'.$rev_id; 
					if (@mkdir($path,0777))	{}
					//save path
					$post = array('file_path' => $path);
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post);
					
					//move files
					$cache = $this->db->get_where('revision_order_cache', array('id' => $cacheid))->row_array();
						if(isset($cache['id'])){
							//updating rev_sold_jobs id to revision_order_cache table
								$r_order_cache = array('rev_sold_jobs_id' => $rev_id );
								$this->db->where('id', $cacheid);
								$this->db->update('revision_order_cache', $r_order_cache);
							    
							//copying files from revision_order_cache folder to revision downloads folder
							$cache_file_path = $cache['file_path'];
							if(!empty($cache_file_path) && $cache_file_path != "none"){
								$cache_path = getcwd().'/'.$cache_file_path;
								//for article
								
								//for ads
								
								//Uploading files
								$order_file_path = $revision['file_path'];
								$download_path = getcwd().'/'.$order_file_path;
								
								if(!empty($order_file_path) && $order_file_path != "none"){
									if(is_dir($cache_path)){
										if($dh = opendir($cache_path)){
											while(($file = readdir($dh)) !== false){
												if($file== '.' || $file== '..') { continue; } 
												@rename($cache_path.'/'.$file, $download_path.'/'.$file);
											}
											closedir($dh);
										}
										//Delete rev_order_cache files
							            array_map('unlink', glob("$cache_path/*.*"));
							            rmdir($cache_path);
									} 
								}
							}
						}
					
					//send mail
					$data['order'] = $order_details;
					$data['client'] = $adrep_publication_detail;
					$design_team = $this->db->query("Select * from design_teams where id='".$adrep_publication_detail['design_team_id']."'")->result_array();
					$data['design_team'] = $design_team[0];
					    $dataa['orders'] = $order_details;
						$dataa['from'] = 'pagination@adwitads.com';
						$dataa['from_display'] = 'Design Team';
						$dataa['replyTo'] = 'pagination@adwitads.com';
						$dataa['replyTo_display'] = 'Design Team';
						
						if($adrep_publication_detail['publication_id'] == '47'){
							$dataa['subject'] = 'AdwitAds Unique Job ID #'.$order_details['job_no'].' '.$order_details['advertiser_name'];
						}else{
							$dataa['subject'] = 'AdwitAds Revision #'.$revision['order_no'];
						}
										
						$dataa['body'] = $this->load->view('revad_placed_notification_emailer', $data, TRUE);
						$dataa['ad_recipient'] = $adrep_publication_detail['email_cc'];
						$dataa['ad_recipient_display'] = 'Advertising Director';
					
						//Client
						//$dataa['recipient'] = $this->session->userdata('ncEmail');
						$dataa['recipient'] = $adrep_publication_detail['email_id'];
						$dataa['recipient_display'] = $adrep_publication_detail['first_name'].' '.$adrep_publication_detail['last_name'];
						if(isset($revision['start_timestamp'])) $dataa['rev_submission_time'] = $revision['start_timestamp'];
						$this->rev_jobs_mail($dataa);
						
						//return $rev_id;
						redirect('new_client/home/page_new_dashboard');
				}else{
					$this->session->set_flashdata('message','Uh-oh! We faced an issue adding your revision to our database. It might be a temporary glitch, but if it continues, let our IT support team know. - Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.');
					redirect('new_client/home/page_new_dashboard');
				}
			    $this->load->view('page_design_view/attachment',$data);
			}
        }else{
            $this->session->set_flashdata('message','Revision not allowed. Order Details not found!..');
		    redirect('new_client/home/page_new_dashboard');
        }
    }
    /*
	public function page_revision($id='')
    {
        $revision_version ='V1a';
        $rev_page = $this->db->query("SELECT * FROM `page_revision` WHERE `pd_id` = $id ORDER BY `id` DESC LIMIT 1;")->result_array();
        if($rev_page) 
        {
            $revision_version = $rev_page[0]['revision_version'];
            if ($revision_version == 'V1a'){ $revision_version = 'V1b';
                }elseif($revision_version == 'V1b'){$revision_version = 'V1c';
                }elseif($revision_version == 'V1c'){$revision_version = 'V1d';
                }elseif ($revision_version == 'V1d'){$revision_version = 'V1e';
                }elseif ($revision_version == 'V1e'){$revision_version = 'V1f';
                }elseif ($revision_version == 'V1f'){$revision_version = 'V1g';
                }elseif($revision_version == 'V1g'){$revision_version = 'V1h';
                }elseif ($revision_version == 'V1h'){$revision_version = 'V1i';
                }elseif ($revision_version == 'V1i'){$revision_version = 'V1j';
                }elseif ($revision_version == 'V1j'){ $revision_version = 'V1k';
                }elseif($revision_version == 'V1k'){$revision_version = 'V1l';
                }elseif ($revision_version == 'V1l'){$revision_version = 'V1m';
                }elseif ($revision_version == 'V1m'){$revision_version = 'V1n';
                }elseif ($revision_version == 'V1n'){$revision_version = 'V1o';
                }elseif ($revision_version == 'V1o'){$revision_version = 'V1p';
                }elseif ($revision_version == 'V1p'){$revision_version = 'V1q';
                } elseif ($revision_version == 'V1q'){$revision_version = 'V1r';
                }elseif ($revision_version == 'V1r'){$revision_version = 'V1s';
                }elseif ($revision_version == 'V1s'){$revision_version = 'V1t';
                }elseif ($revision_version == 'V1t'){$revision_version = 'V1u';
                }elseif ($revision_version == 'V1u'){$revision_version = 'V1v';
                }elseif ($revision_version == 'V1v'){$revision_version = 'V1w';
                }elseif ($revision_version == 'V1w'){$revision_version = 'V1x';
                }elseif ($revision_version == 'V1x'){$revision_version = 'V1y';
                }elseif ($revision_version == 'V1y'){$revision_version = 'V1z';
                }elseif ($revision_version == 'V1z'){$revision_version = 'V1.1';}
        }
        $data = array(
                'pd_id' => $id,
                'revision_version' => $revision_version,
                'status' => '0'
				);
        $this->db->insert('page_revision',$data);
        $rev_id = $this->db->insert_id();
        redirect('new_client/home/page_revision_note/'.$id.'/'.$rev_id);
    }
    */
	public function page_revision_note($id='',$rev_id='')
    {
        $revID = $this->db->query("SELECT * FROM `page_revision` WHERE `pd_id`=$id AND `id`=$rev_id AND `status`='0'")->row_array();
        $page_design = $this->db->query("SELECT * FROM `page_design` WHERE `id` = '".$id."'")->row_array();
		if(isset($revID['id'])){
		
			$articles_path = $revID['articles'];
			if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path)) //check the notnull exitsfile and openfile
			{
				while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
				{
					if ($file == '.' || $file == '..')  //.,.. get 
					{
						continue; // left that and continue next
					}
					if($file) // file get 
					{ 
						$articlename[]=$file;//store all article name in array
					}
					$data['articles_name'] = $articlename;// array of name will stored in articles_name
				}
				 closedir($atp);//dirctry $atp clocsed
			}
			$ads_path = $revID['ads'];  //path of the database column 
			// if ($ads_path) 
			// {
			if($ads_path != null && file_exists($ads_path) && $dh = opendir($ads_path)) //check the notnull exitsfile and openfile
			{
				while(($file = readdir($dh)) !== false)  //loop to read the file path then store it
				{
					if($file == '.' || $file == '..') //.,.. get 
					{ 
						continue;  // left that and continue next
					}
					if($file) // file get 
					{ 
						$filename[] = $file;  //store all file name in array
					}
					$data['file_names1'] = $filename;  // array of name will stored in file_name1
				}
				closedir($dh); //dirctry $dh clocsed
			}
			if (isset($_POST['submit']))
			{
				$data = array('note' => trim($_POST['notes']), 'status' => '1');
					$this->db->where('id',$rev_id);
					$this->db->update('page_revision',$data);
				
				//email notification to adrep and itsupport@adwitads.com
				
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->row_array();
				$publication = $this->db->get_where('publications',array('id' => $client['publication_id']))->row_array();
		
				$design_team = $this->db->query("Select name, email_id from design_teams where id='".$publication['design_team_id']."'")->row_array();
				
				$from = 'pagination@adwitads.com';
				$from_display = 'Design Team';

				$replyTo = 'do_not_reply@adwitads.com';
				$replyTo_display = 'Do not reply';
				
				$subject = 'AdwitAds Pagination Order #'.$id.' Revision - '.$revID['revision_version'];
				
				$recipient = $client['email_id'];
				$recipient_display = $client['first_name'].' '.$client['last_name'];
				$data['client'] = $client;
				$data['rev_note'] = $_POST['notes'];
				$data['order'] = $page_design;
				$data['design_team'] = $design_team;
				
				$this->load->library('email');
				$config = array();
                $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;
                
				$this->email->initialize($config);
				$this->email->from($from, $from_display);
				$this->email->reply_to($replyTo, $replyTo_display);
				$this->email->subject($subject); 
				$body = $this->load->view('pagination_emailer/revad_placed_notification_emailer',$data, TRUE);
				$this->email->message($body);
				$this->email->set_alt_message("Unable to load text!");
				$this->email->to($recipient, $recipient_display);
				$this->email->cc(array('itsupport@adwitads.com'));
				
				$this->session->set_flashdata("message","Revision Submitted for Order - $id");
				$this->email->send();
				//email notification end
				
				redirect('new_client/home/page_dashboard/');	
				/*	
				$article = $this->db->query("SELECT * FROM page_revision WHERE `id`=$rev_id AND `articles` is NULL;")->row_array();
				$ads = $this->db->query("SELECT * FROM page_revision WHERE `id`=$rev_id AND `ads` is NULL;")->row_array();
				if ($article || $ads){
					$this->session->set_flashdata("message",'<span class="alert alert-danger" style="padding: 5px 10px !important; margin-left: 20px; font-size: 14px;">Articles or Ads missing..</span>');
					redirect('new_client/home/page_revision_note/'.$id.'/'.$rev_id);
				}else{
					$sdata = array('status' => '1');
					$this->db->where('id',$rev_id);
					$this->db->update('page_revision',$sdata);
					//$this->session->set_flashdata("message","Revision Submitted.");
					redirect('new_client/home/page_dashboard/');
				}*/
			}
			$data['Id']=$id;
			$data['rId']=$rev_id;
			$this->load->view('page_design_view/revision',$data);
		}else{
			$this->session->set_flashdata("message","Revision not allowed.");
			redirect('new_client/home/page_dashboard/');
		}
    }
    
	public function page_revision_artical_upload($rId='')
    {
        $pages = $this->db->get_where('page_revision',array('id'=>$rId))->row_array();
        if (isset($_FILES['file']['tmp_name']))
        {
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $path = "page_design/revision/articles/".$pages['pd_id'];
            if(@mkdir($path,0777)){}
            $path = "page_design/revision/articles/".$pages['pd_id'].'/'.$pages['id'];
            if(@mkdir($path,0777)){}
            $filepath = $path.'/'.$name;
            if (move_uploaded_file($temp_name, $filepath)){
                $arrayName = array('articles' => $path);
                $this->db->WHERE('id',$rId);
                $this->db->update('page_revision',$arrayName);
            }
        }
    }
    
	public function page_revision_ads_upload($rId='')
    {
        $pages = $this->db->get_where('page_revision',array('id'=>$rId))->row_array();
        if (isset($_FILES['file']['tmp_name']))
        {
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $path = "page_design/revision/ads/".$pages['pd_id'];
            if(@mkdir($path,0777)){}
            $path = "page_design/revision/ads/".$pages['pd_id'].'/'.$pages['id'];
            if(@mkdir($path,0777)){}
            $filepath = $path.'/'.$name;
            if (move_uploaded_file($temp_name, $filepath))
            {
                $arrayName = array('ads' => $path);
                $this->db->WHERE('id',$rId);
                $this->db->update('page_revision',$arrayName);
            }
        }
    }
    
	public function page_remove_rev_att($id='') // remove the articles  files
    {
        $articlespath = $this->db->get_where('page_revision',array('id' => $id))->row_array();

        if (isset($articlespath['id'])&& isset($_POST['filename'])) 
        {
            $filename = $_POST['filename']; //get filename
            $filepath = $articlespath['articles'];  //in database articles column we get the path
            $dirhandle = opendir($filepath);    //open the directry using FILEPATH 
            while ($file = readdir($dirhandle))  // read the FILEPATH
            {
                if ($file == $filename) //in filepath location get filename 
                {
                    unlink($filepath.'/'.$filename);    // unlink it
                }
            }
        } 
    }
    
	public function page_remove_rev_ads($id='') // remove the articles  files
    {
        $articlespath = $this->db->get_where('page_revision',array('id' => $id))->row_array();

        if (isset($articlespath['id'])&& isset($_POST['filename'])) 
        {
            $filename = $_POST['filename']; //get filename
            $filepath = $articlespath['ads'];  //in database articles column we get the path
            $dirhandle = opendir($filepath);    //open the directry using FILEPATH 
            while ($file = readdir($dirhandle))  // read the FILEPATH
            {
                if ($file == $filename) //in filepath location get filename 
                {
                    unlink($filepath.'/'.$filename);    // unlink it
                }
            }
        } 
    }
    
	public function view_pages($id='')//match the page design id in pages table then list pages
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id = $id;")->result_array();
        $order_id = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id = $id;")->row_array();
        $data['all'] =$page;
        $data['order_id']=$order_id;
        $this->load->view('page_design_view/view_pages',$data);
    }
    
    public function page_additional_attachment($order_id = '')
    {
        $order_detail = $this->db->query("SELECT orders.id, orders.job_no, orders.advertiser_name FROM `orders` WHERE orders.id = $order_id;")->row_array();
        if(isset($order_detail['id'])){
            if (isset($_POST['additional_attachment_submit'])){
                redirect('new_client/home/page_new_dashboard');
            }
            
            $data['order_detail'] = $order_detail;
            $this->load->view('page_design_view/page_additional_attachment', $data);    
        }else{
            $this->session->set_flashdata("message", "Hmmm... No order found with the given OrderID. Ensure you've entered the right ID and retry.");
			redirect('new_client/home/page_new_dashboard');
        }
    }
    
    public function page_list_attachments(){
        if(isset($_POST['order_id']) && isset($_POST['type'])){
            $order_id = $_POST['order_id'];  $type = $_POST['type'];
            $order_detail = $this->db->query("SELECT orders.id, orders.job_no, orders.file_path FROM `orders` 
                                                WHERE orders.id = '$order_id' AND orders.file_path != 'none';")->row_array();
            if(isset($order_detail['id'])){
                $file_path = $order_detail['file_path'];
                $type_path = $file_path.'/'.$type; // articles path or ads path depending on type value passed 
                $attachments = array();
                if(file_exists($type_path) && $atp = opendir($type_path)){
                    while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
                    {
                        if($file == '.' || $file == '..'){ continue; }
                        if($file){ $attachments[] = $type_path.'/'.$file; }
                        //$data['attachments'] = $attachments;// array of name will stored in articles_name
                    }
                    closedir($atp);//dirctry $atp clocsed    
                }
            
                $output = '';
                $i = 1;
                foreach($attachments as $row){
                    $output .= '<tr>';
    				$output .= '<td>'.$i.'</td>';
    				$output .= '<td> 
    				                <a href="'.base_url().$row.'" target="_blank">'.basename($row).'</a>
    				            </td>';
    				$output .= '<td>
    				                <a href="'.base_url().$row.'" download target="_blank"><i class="fa fa-download"></i></a>
    							</td>';									
    				$output .= '<td>
    							    <input type="hidden" name="filename" id="article_name'.$i.'" value="'.$row.'">
    								<input type="button" name="remove" value="Remove" onclick="remove_attachment(\''.$row.'\')">
    							</td>';
    				$output .= '</tr>';
    				$i++;
                }
                echo json_encode($output);
            }
        }
    }
    
    /*
	public function page_attachment($id='')
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->row_array();
        $data['all'] =$page;
        $data['Id']=$id;
        $order_id = $this->db->query(" SELECT * FROM `pages` WHERE pages.pd_id=$id;")->result_array();
        $data['order_id']=$order_id;
        $this->load->view('page_design_view/attachment',$data);
    }
    */
    public function page_attachment_files($id='',$pid='')      			//receiving the id and pid
    {
        $pageID = $this->db->query("SELECT * FROM `pages` WHERE pages.id = $pid")->row_array();

        //articles file list
		$articles_path = $pageID['attch_article'];
        if ($articles_path != null && file_exists($articles_path) && $atp = opendir($articles_path)) //check the notnull exitsfile and openfile
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                { 
                    $articlename[]=$file;//store all article name in array
                }
                $data['articles_name'] = $articlename;// array of name will stored in articles_name
            }
             closedir($atp);//dirctry $atp clocsed
        }
		
        //Ads file list
        $ads_path = $pageID['attch_ads'];  //path of the database column 
        // if ($ads_path) 
        // {
        if($ads_path != null && file_exists($ads_path) && $dh = opendir($ads_path)) //check the notnull exitsfile and openfile
        {
            while(($file = readdir($dh)) !== false)  //loop to read the file path then store it
            {
                if($file == '.' || $file == '..') //.,.. get 
                { 
                    continue;  // left that and continue next
                }
                if($file) // file get 
                { 
                    $filename[] = $file;  //store all file name in array
                }
                $data['ads_name'] = $filename;  // array of name will stored in file_name1
            }
            closedir($dh); //dirctry $dh clocsed
        }
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->row_array();
        $data['all'] =$page;
        $data['Id']=$id;
        $order_id = $this->db->query(" SELECT * FROM `pages` WHERE pages.pd_id=$id;")->result_array();
        $data['order_id']=$order_id;
		
        $this->load->view('page_design_view/attachment',$data);		//view the page_order_placed with $data 
    }
    
	public function page_message($pid='')
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.id=$pid;")->row_array();
        if (isset($_POST['submit'])) //message sending 
        {
            $data = array(
                'pages_id' => $pid,
                'pd_id' => $page['pd_id'],
                'message' => trim($_POST['message'])
            );
            $this->db->insert('page_message',$data);
            $p_id = $this->db->insert_id();
            $message = "<div class='alert alert-info'>
                            <font color='000' value=".$page['id'].">".$page['page_no']."</font> 
                            Message Successfuly Submitted.</div>";
            $this->session->set_flashdata('item',$message );
        }
        redirect('new_client/home/page_attachment/'.$page['pd_id']);
    }
    
    public function page_attachment_upload($pid='',$count='0')
    {
    }
    
	public function page_artical_attch($pid='',$count='0')
    {
        $page = $this->db->get_where('pages',array('id'=>$pid))->row_array();

        if (isset($_FILES['file']['tmp_name']))
        {
            $filename = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $path = 'page_design/attachments/articles/'.$page['pd_id'];
            if (@mkdir($path,0777)){}
            $path = 'page_design/attachments/articles/'.$page['pd_id'].'/'.$page['id'];
            if (@mkdir($path,0777)){}
            $filepath=$path.'/'.$filename;
            if (move_uploaded_file($temp_name, $filepath))
            {
                $att_ar = array('attch_article'=>$path);
                $this->db->where('id',$pid);
                $this->db->update('pages',$att_ar);
            }
        }

    }
    
	public function page_ads_attch($pid='')
    {
        $page = $this->db->get_where('pages',array('id'=>$pid))->row_array();
        if (isset($_FILES['file']['tmp_name']))
        {
            $filename = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $path = 'page_design/attachments/ads/'.$page['pd_id'];
            if (@mkdir($path,0777)){}
            $path = 'page_design/attachments/ads/'.$page['pd_id'].'/'.$page['id'];
            if (@mkdir($path,0777)){}
            $filepath=$path.'/'.$filename;
            if (move_uploaded_file($temp_name, $filepath))
            {
                $att_ar = array('attch_ads'=>$path);
                $this->db->where('id',$pid);
                $this->db->update('pages',$att_ar);
            }
        }
    }
   
	public function page_pdf($id='')
    {
        $query = $this->db->query("SELECT * FROM page_design WHERE `id` = $id;")->row_array();
        $filename = $query['pdf'];
        $path = "page_sourcefile/".$query['id'].'/v1/'.$filename;
        if (file_exists($path))
        {
            header("Content-type: application/pdf");
            header('Content-Disposition: inline;filename="'.$filename.'"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($path);
        }
        else
        {
            echo"error - ". $filename;
        }
        
    }
	
	public function page_remove_attachment_file($order_id = '') // remove the articles  files
    {
        $order_detail = $this->db->query("SELECT orders.id FROM `orders` WHERE orders.id = '$order_id' ")->row_array();
        if(isset($order_detail['id'])){
            if(isset($_POST['filename']) && file_exists($_POST['filename'])){
                $filename = $_POST['filename'];
                unlink($filename);
            }    
        }
    }
    /*
	public function page_remove_att_art($pid='') // remove the articles  files
    {
        $articlespath = $this->db->get_where('pages',array('id' => $pid))->row_array();

        if (isset($articlespath['id'])&& isset($_POST['filename'])) 
        {
            $filename = $_POST['filename']; //get filename
            $filepath = $articlespath['attch_article'];  //in database articles column we get the path
            $dirhandle = opendir($filepath);    //open the directry using FILEPATH 
            while ($file = readdir($dirhandle))  // read the FILEPATH
            {
                if ($file == $filename) //in filepath location get filename 
                {
                    unlink($filepath.'/'.$filename);    // unlink it
                }
            }
        } 
    }
    
    public function page_remove_att_ads($pid='') // remove the ads file uploads 
    {
        $articlespath = $this->db->get_where('pages',array('id' => $pid))->row_array();

        if (isset($articlespath['id'])&& isset($_POST['filename'])) 
        {
            $filename = $_POST['filename']; //get filename
            $filepath = $articlespath['attch_ads']; //in database ads column we get the path
            $dirhandle = opendir($filepath);  //open the directry using FILEPATH 
            while ($file = readdir($dirhandle)) // read the FILEPATH
            {
                if ($file == $filename)     //in filepath location get filename 
                {
                    unlink($filepath.'/'.$filename); // unlink it
                }
            }
        } 
        
    }
    */
   public function page_approve_unapprove($pd_id='')
	{
		if($pd_id !='' && isset($_POST['action']) && $_POST['action'] == 'approve'){
			$status_update = array('status' => '7');
            $this->db->where('id',$pd_id);
            $this->db->update('page_design',$status_update);
			
			echo '<button class="btn btn-block btn-xs padding-5 btn-danger btn_unapprove" data-pid="'.$pd_id.'">Unapprove</button>';
		}
		
		if($pd_id !='' && isset($_POST['action']) && $_POST['action'] == 'unapprove'){
			$status_update = array('status' => '5');
            $this->db->where('id', $pd_id);
            $this->db->update('page_design',$status_update);
			
			echo '<button class="btn btn-block btn-xs padding-5 btn-danger btn_approve" data-pid="'.$pd_id.'">Approve</button>';
		}
	}
//page design END

    //revision
	public function new_order_revision($orderid)
	{
	    $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
	    $publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
	    $order_details = $this->db->get_where('orders',array('id' => $orderid))->row_array();
	    
	    if($publication[0]['pdf_review'] == '1' && $order_details['order_type_id'] != '1'){ //enable pdf review tool  publication 
	        redirect('new_client/home/test_new_order_revision/'.$orderid);
	    }
	    
		
		if(isset($order_details['id'])){
		    if($order_details['status'] == '7'){
		        $this->session->set_flashdata("message", "Hold on! The order with this OrderID has been approved, which means revisions are off the table. To discuss further, please touch base with your design team.");
				redirect('new_client/home/dashboard');
		    }
		    
			$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
			if(isset($orders_rev['id'])){
				$slug = $orders_rev['new_slug'];
			}else{
				$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->row_array();
				$slug = $cat_result['slug'];
			}
			
			$data['order_details'] = $order_details;
			$data['slug'] = $slug;
			
			if($slug == 'none'){
				$this->session->set_flashdata("message","Heads up! The order with this OrderID is currently in production status, so certain actions may not be permitted. Review the order's status for more details.");
				redirect('new_client/home/dashboard');
			}
			
			if(!isset($_POST['cacheid'])){	
				$post_data = array(
						'order_id' => $orderid,
						'order_slug' => $slug,
						'adrep' => $this->session->userdata('ncId')
						);
				$this->db->insert('revision_order_cache', $post_data);
				$cacheid = $this->db->insert_id();
				$data['cacheid'] = $cacheid;
			}
			
			if(isset($_POST['rev_submit'])){
				$cacheid = $_POST['cacheid'];
				$version = 'V1a'; 
				$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' AND `status` = '5' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
				
				if(isset($orders_rev[0]['id'])){
					
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
				}
				//$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				//$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				
				
				$rev_data = array(
					'order_id'=>$orderid,
					'order_no' => $_POST['job_slug'],
					'adrep'=>$this->session->userdata('ncId'),
					'help_desk'=>$publication[0]['help_desk'],
					'date'=> date('Y-m-d'),
					'time'=>date("H:i:s"),
					'category'=>'revision',
					'version'=>$version,
					'note'=>$_POST['notes'],
					'status'=>'1',
					);
				$this->db->insert('rev_sold_jobs', $rev_data);
				$rev_id = $this->db->insert_id(); 
				
				if($rev_id){
					//Live_tracker Revision updation
					$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id' => $orderid,
						'revision_id'=> $rev_id,
						'status' => '1'
					);
					$this->db->insert('live_revisions', $tracker_data);
					
					//Revision details of the order
					
					//$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
					$rev_count = $order_details['rev_count'];
					if(empty($rev_count)){ $rev_count = 0; }
					$rev_count_data = array(
					    'rev_count' => $rev_count + 1, 
					    'rev_id' => $rev_id,
					    'rev_order_status' => '1', //Revision Submitted
					    'activity_time' => date('Y-m-d h:i:s'),
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
					
					//move files
					$cache = $this->db->get_where('revision_order_cache',array('id' => $cacheid))->row_array();
					if(isset($cache['id'])){
							//updating rev_sold_jobs id to revision_order_cache table
								$r_order_cache = array('rev_sold_jobs_id' => $rev_id );
								$this->db->where('id', $cacheid);
								$this->db->update('revision_order_cache', $r_order_cache);
							    
							//copying files from revision_order_cache folder to revision downloads folder
							$cache_file_path = $cache['file_path'];
							if(!empty($cache_file_path) && $cache_file_path != "none"){
								$cache_path = getcwd().'/'.$cache_file_path;
								
								//Uploading files
								$rev_details = $this->db->query("SELECT `file_path` FROM `rev_sold_jobs` WHERE `id` = '$rev_id'")->row_array();
								$order_file_path = $rev_details['file_path'];
								$download_path = getcwd().'/'.$order_file_path;
								
								if(!empty($order_file_path) && $order_file_path != "none"){
									if(is_dir($cache_path)){
										if($dh = opendir($cache_path)){
											while(($file = readdir($dh)) !== false){
												if($file== '.' || $file== '..') { continue; } 
												//copy($cache_path.'/'.$file, $download_path.'/'.$file);
												@rename($cache_path.'/'.$file, $download_path.'/'.$file);
											}
											closedir($dh);
										}
										//Delete rev_order_cache files
							            array_map('unlink', glob("$cache_path/*.*"));
							            rmdir($cache_path);
									} 
								}
							}
					}
					$revision = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
					//send mail
					$data['order'] = $order_details;
					$data['client'] = $client[0];
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$data['design_team'] = $design_team[0];
					    $dataa['orders'] = $order_details;
					    if($order_details['order_type_id'] == '6'){
					        $dataa['from'] = 'pagination@adwitads.com';
					        $dataa['replyTo'] = 'pagination@adwitads.com';
					    }else{
					        $dataa['from'] = $design_team[0]['email_id'];
					        $dataa['replyTo'] = $design_team[0]['email_id'];
					    }
						
						$dataa['from_display'] = 'Design Team';
						
						$dataa['replyTo_display'] = 'Design Team';
						
						if($publication[0]['id'] == '47'){
							$dataa['subject'] = 'AdwitAds Unique Job ID #'.$order_details['job_no'].' '.$order_details['advertiser_name'];
						}else{
							$dataa['subject'] = 'AdwitAds Revision #'.$revision[0]['order_no'];
						}
										
						$dataa['body'] = $this->load->view('revad_placed_notification_emailer',$data, TRUE);
						$dataa['ad_recipient'] = $client[0]['email_cc'];
						$dataa['ad_recipient_display'] = 'Advertising Director';
					
						//Client
						//$dataa['recipient'] = $this->session->userdata('ncEmail');
						$dataa['recipient'] = $client[0]['email_id'];
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
						if(isset($revision[0]['start_timestamp'])) $dataa['rev_submission_time'] = $revision[0]['start_timestamp'];
						if(isset($revision[0]['file_path']) && file_exists($revision[0]['file_path'])){
						    $dataa['revision_attachments'] = array_diff(scandir($revision[0]['file_path']), array('.', '..'));
						    $dataa['revision_attachment_path'] = $revision[0]['file_path'];
						}
						$dataa['notes_instruction'] = $revision[0]['note'];
						$this->rev_jobs_mail($dataa);
						
						//return $rev_id;
						redirect('new_client/home/dashboard');
				}else{
					$this->session->set_flashdata('message','Uh-oh! We faced an issue adding your revision to our database. It might be a temporary glitch, but if it continues, let our IT support team know. - Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.');
					redirect('new_client/home/dashboard');
				}
			
			}
			$this->load->view('new_client/new_order_revision', $data);
		}
	}
	
	public function test_new_order_revision($orderid) //pdf review- order annotation
	{
		$order_details = $this->db->get_where('orders',array('id' => $orderid))->row_array();
		if(isset($order_details['id'])){
		    //retrieve partially saved pdf annotation
		    $latest_order_cache =  $this->db->query("SELECT * FROM `revision_order_cache` 
		                          WHERE revision_order_cache.order_id = '$orderid' AND revision_order_cache.file_path != 'none' ORDER BY `id` DESC LIMIT 1;")->row_array();
			$data['latest_order_cache'] = $latest_order_cache; 
			//check for latest revision if any exist
			$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
			
			if(isset($orders_rev['id'])){
				$slug = $orders_rev['new_slug'];
				$data['orders_rev'] = $orders_rev;
			}else{
				$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->row_array();
				$slug = $cat_result['slug'];
			}
			
			$data['order_details'] = $order_details;
			$data['slug'] = $slug;
			
			if($slug == 'none'){
				$this->session->set_flashdata("message","Heads up! The order with this OrderID is currently in production status, so certain actions may not be permitted. Review the order's status for more details.");
				redirect('new_client/home/dashboard');
			}
			
			if(!isset($_POST['cacheid'])){	
				$post_data = array(
						'order_id' => $orderid,
						'order_slug' => $slug,
						'adrep' => $this->session->userdata('ncId')
						);
				$this->db->insert('revision_order_cache', $post_data);
				$cacheid = $this->db->insert_id();
				$data['cacheid'] = $cacheid;
			}
			
			if(isset($_POST['rev_submit'])){
				$cacheid = $_POST['cacheid'];
				$version = 'V1a'; 
				$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' AND `status` = '5' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
				
				if(isset($orders_rev[0]['id'])){
					
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
				}
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
				
				
				$rev_data = array(
					'order_id'=>$orderid,
					'order_no' => $_POST['job_slug'],
					'adrep'=>$this->session->userdata('ncId'),
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
				
				if($rev_id){
					//Live_tracker Revision updation
					$tracker_data = array(
						'pub_id'=> $publication[0]['id'],
						'order_id' => $orderid,
						'revision_id'=> $rev_id,
						'status' => '1'
					);
					$this->db->insert('live_revisions', $tracker_data);
					
					//Revision details of the order
					$order_details = $this->db->get_where('orders',array('id' => $orderid))->result_array();
					$rev_count = $order_details[0]['rev_count'];
					if(empty($rev_count)){ $rev_count = 0; }
					
					$rev_count_data = array(
					    'rev_count' => $rev_count + 1, 
					    'rev_id' => $rev_id,
					    'rev_order_status' => '1', //Revision Submitted
					    'activity_time' => date('Y-m-d h:i:s'),
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
					
					//move files
					$cache = $this->db->get_where('revision_order_cache',array('id' => $cacheid))->row_array();
						if(isset($cache['id'])){
						    //updating rev_sold_jobs id to revision_order_cache table
								$r_order_cache = array('rev_sold_jobs_id' => $rev_id );
								$this->db->where('id', $cacheid);
								$this->db->update('revision_order_cache', $r_order_cache);
							    
							//copying files from revision_order_cache folder to revision downloads folder
							$cache_file_path = $cache['file_path'];
							
							if(!empty($cache_file_path) && $cache_file_path != "none") {
								$cache_path = getcwd().'/'.$cache_file_path;
								
								//Uploading files
								$rev_details = $this->db->query("SELECT `file_path` FROM `rev_sold_jobs` WHERE `id` = '$rev_id'")->row_array();
								$order_file_path = $rev_details['file_path'];
								$download_path = getcwd().'/'.$order_file_path;
								
								if(!empty($order_file_path) && $order_file_path != "none"){
									if(is_dir($cache_path)){
										if($dh = opendir($cache_path)){
											while(($file = readdir($dh)) !== false){
												if($file== '.' || $file== '..') { continue; } 
												//copy($cache_path.'/'.$file, $download_path.'/'.$file);
												@rename($cache_path.'/'.$file, $download_path.'/'.$file);
											}
											closedir($dh);
										}
									} 
								}
								
								//order annotation file copy
								$cache_order_annotation_path = $cache_path.'/order_annotation';
								if(file_exists($cache_order_annotation_path)){
								    $order_annotation_path = $order_file_path.'/order_annotation';
									if (@mkdir($order_annotation_path,0777)){}
									
									if($dh = opendir($cache_order_annotation_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											//copy($cache_theme_path.'/'.$file, $order_theme_path.'/'.$file);
											@rename($cache_order_annotation_path.'/'.$file, $order_annotation_path.'/'.$file);
										}
										closedir($dh);
									}
								}else{  //check for partially saved annotation
    							   $this->retrieve_partially_saved_annotation($orderid, $rev_id, $cacheid); 
    							}
								//Delete rev_order_cache files
    							if(isset($cache_path) && is_dir($cache_path)){
    							    if(file_exists($cache_path.'/order_annotation')){
    							        array_map('unlink', glob("$cache_path/order_annotation/*.*"));
    							        rmdir($cache_path.'/order_annotation');  
    							    }
    							    array_map('unlink', glob("$cache_path/*.*"));
    							    rmdir($cache_path);
    							}
							}elseif(isset($latest_order_cache['file_path']) && file_exists($latest_order_cache['file_path'])){  //check for partially saved annotation
							   $this->retrieve_partially_saved_annotation($orderid, $rev_id, $cacheid); 
							}
						}
					$revision = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
					//send mail
					$data['order'] = $order_details[0];
					$data['client'] = $client[0];
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$data['design_team'] = $design_team[0];
					    $dataa['orders'] = $order_details[0];
					    if($order_details[0]['order_type_id'] == '6'){
					        $dataa['from'] = 'pagination@adwitads.com';
					        $dataa['replyTo'] = 'pagination@adwitads.com';
					    }else{
					        $dataa['from'] = $design_team[0]['email_id'];
					        $dataa['replyTo'] = $design_team[0]['email_id'];
					    }
						
						$dataa['from_display'] = 'Design Team';
						$dataa['replyTo_display'] = 'Design Team';
						
						if($publication[0]['id'] == '47'){
							$dataa['subject'] = 'AdwitAds Unique Job ID #'.$order_details[0]['job_no'].' '.$order_details[0]['advertiser_name'];
						}else{
							$dataa['subject'] = 'AdwitAds Revision #'.$revision[0]['order_no'];
						}
										
						$dataa['body'] = $this->load->view('revad_placed_notification_emailer',$data, TRUE);
						$dataa['ad_recipient'] = $client[0]['email_cc'];
						$dataa['ad_recipient_display'] = 'Advertising Director';
					
						//Client
						//$dataa['recipient'] = $this->session->userdata('ncEmail');
						$dataa['recipient'] = $client[0]['email_id'];
						$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
						if(isset($revision[0]['start_timestamp'])) $dataa['rev_submission_time'] = $revision[0]['start_timestamp'];
						$revision_attachment_path = $revision[0]['file_path'];
						if(isset($revision_attachment_path) && file_exists($revision_attachment_path)){
						    $dataa['revision_attachments'] = array_diff(scandir($revision_attachment_path), array('.', '..', 'order_annotation'));
						    $dataa['revision_attachment_path'] = $revision_attachment_path;
						}
						$revision_pdf_annotation_path = $revision_attachment_path.'/order_annotation/'.$orderid.'.pdf';
						if(isset($revision_pdf_annotation_path) && file_exists($revision_pdf_annotation_path)){
						    $dataa['revision_pdf_annotation_path'] = $revision_pdf_annotation_path;
						     $dataa['revision_pdf_annotation_attachment'] = $orderid.'.pdf';
						}
						$dataa['notes_instruction'] = $revision[0]['note'];
						$this->rev_jobs_mail($dataa);
						
						//return $rev_id;
						redirect('new_client/home/dashboard');
				}else{
					$this->session->set_flashdata('message','Uh-oh! We faced an issue adding your revision to our database. It might be a temporary glitch, but if it continues, let our IT support team know. - Tech snag! There was an issue with updating or inserting the provided data into our system. Confirm your entries and try again or reach out to itsupport@adwitads.com.');
					redirect('new_client/home/dashboard');
				}
			
			}
			$this->load->view('new_client/test_new_order_revision', $data);
		}
	}
	
	function retrieve_partially_saved_annotation($orderid = '', $rev_id = '', $cacheid = ''){
	    //get the previous latest revision_order_cache id
	    $latest_order_cache =  $this->db->query("SELECT * FROM `revision_order_cache` 
		                          WHERE revision_order_cache.id != '$cacheid' AND revision_order_cache.order_id = '$orderid' AND revision_order_cache.file_path != 'none' ORDER BY `id` DESC LIMIT 1;")->row_array();
		
		
		if(isset($latest_order_cache['file_path']) && file_exists($latest_order_cache['file_path'])){ 
		    //get current revision file_path
		    $rev_details = $this->db->query("SELECT `file_path` FROM `rev_sold_jobs` WHERE `id` = '$rev_id'")->row_array();
		    $order_file_path = $rev_details['file_path'];
		
			$latest_order_cache_path = getcwd().'/'.$latest_order_cache['file_path'];
			$cache_order_annotation_path = $latest_order_cache_path.'/order_annotation';
			if(file_exists($cache_order_annotation_path)){
			    //create directory 'order_annotation' in revision downloads
    			$order_annotation_path = $order_file_path.'/order_annotation';
    			if (@mkdir($order_annotation_path,0777)){}
    									
    			if($dh = opendir($cache_order_annotation_path)){
    				while(($file = readdir($dh)) !== false){
    					if($file== '.' || $file== '..') { continue; } 
    					@rename($cache_order_annotation_path.'/'.$file, $order_annotation_path.'/'.$file);
    				}
    				closedir($dh);
    			}
    		}
    		//remove directory
    		if(file_exists($cache_order_annotation_path)){
    		    array_map('unlink', glob("$cache_order_annotation_path/*.*"));
    			rmdir($cache_order_annotation_path);    
    		}
    	}
		return true;
	}
	
	public function revision_order_fileupload($cacheid)
	{
		if(!empty($_FILES)) {
			$download_path = 'revision_order_cache/'.$cacheid; //path
			if (@mkdir($download_path,0777)){}  //folder creation
			$data = array('file_path'=>$download_path);
			$this->db->where('id',$cacheid);
			$this->db->update('revision_order_cache',$data);
			
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$targetPath = getcwd().'/'.$download_path.'/';
				$targetFile = $targetPath . $fileName ;
				move_uploaded_file($tempFile, $targetFile);
		} 
	}
	
	public function revision_order_annotation($cacheid)
	{
	    $cache = $this->db->get_where('revision_order_cache',array('id' => $cacheid))->row_array(); 
	    if(isset($cache['order_id']) && isset($_POST['content'])){
	       //order annotation
    		   $content =  $_POST['content'];
               $decode_content = base64_decode($content);
               
            //Writing marked-up PDF file to revision_order_cache/revision_order_cache_id/order_annotation/order_id.pdf   
               $download_path = 'revision_order_cache/'.$cacheid; //path
    			if (@mkdir($download_path,0777)){}  //folder creation
    		    $order_annotation = $download_path.'/order_annotation';
    		    if (@mkdir($order_annotation,0777)){}  //folder creation
    		    
                $myFile = $order_annotation."/".$cache['order_id'].".pdf";
    		    $fh = fopen($myFile, 'w+') or die("can't open file");
    		    fwrite($fh, $decode_content);
    		    fclose($fh);
    		    
    		//updating  revision_order_cache file_path column
    		    $data = array('file_path' => $download_path);
    			$this->db->where('id', $cacheid);
    			$this->db->update('revision_order_cache', $data);
    			
             //order annotation log 
                $data_log = array('order_id' => $cache['order_id'], 'adrep_id' => $this->session->userdata('ncId'), 'path' => $order_annotation);
                $this->db->insert('order_annotation_log', $data_log);
	    }
	    echo 'success';
	}
	//preorder Waukesha
	public function list_preorders_waukesha()
	{
	    $today = date('Y-m-d');
		$pday = date('Y-m-d', strtotime(' -6 day'));
		$this->load->view('new_client/list_preorders_waukesha');
	}
	
	public function list_preorders_waukesha_content()
	{
	    /*$this->load->model("Preorder");  
        $fetch_data = $this->Preorder->make_datatables();  */
        
        $query = "SELECT `id`, `ad_number`, `customer_name`, `user`, `adtitle`, `width`, `height`, `run_date`, `accept`, `account_number`, date_format(str_to_date(`run_date`, '%m/%d/%Y'), '%Y-%m-%d') AS runDate
                    FROM `preorders_waukesha`
                        WHERE `preorders_waukesha`.`accept` = '0'";
        $query .= " AND (";
		    //search or Filter
			if(isset($_POST['search']['value'])){
			    $query .= '`ad_number` LIKE "%'.$_POST["search"]["value"].'%"';

				$query .= ' OR `adtitle` LIKE "%'.$_POST["search"]["value"].'%"';

				$query .= ' OR `customer_name` LIKE "%'.$_POST["search"]["value"].'%"';
				
				$query .= ' OR `user` LIKE "%'.$_POST["search"]["value"].'%"';
				
				$query .= ' OR `account_number` LIKE "%'.$_POST["search"]["value"].'%"';
			}
			$query .= ") ";
			//ORDER BY
			$order_column = array("ad_number", "customer_name", "user", "adtitle", "account_number", "width", "runDate", "width", "height");
			if(isset($_POST['order'])){
				$query .= ' ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$query .= ' ORDER BY `id` DESC';
			}
			$filtered_rows = $this->db->query($query)->num_rows();
			$extra_query = '';
			if($_POST['length'] != -1){
				$extra_query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			//echo $query;
			
			$query .= $extra_query;
			
			$fetch_data = $this->db->query("$query")->result_array();
			$total_rows = $this->db->query($query)->num_rows();
			
	        //$xml_file_data = $this->db->query("SELECT * from `preorders_waukesha` WHERE `accept`='0' ORDER BY `id` DESC ;")->result_array();
		    $data = array();
		    foreach($fetch_data as $row)
            {
                $xml_file_data_publication = $this->db->query("SELECT DISTINCT `publication` FROM `preorders_waukesha_publication` WHERE `xml_file_data_id`='".$row['id']."' ;")->result_array();
                $publication_list = '';
                foreach($xml_file_data_publication as $p){
    			    $publication_list .= $p['publication'].'<br/>';
    			}
    			$form_tab = '<form name="myform" action="'.base_url().index_page().'new_client/home/preorders_waukesha_form" method="post">
										<input type="submit" name="Submit" value="Submit" class="btn btn-xs padding-5 btn-blue" />
										<input name="id" value="'.$row['id'].'" readonly style="display:none;"/>
									</form>';
                $sub_array = array();
                $sub_array[] = $row['ad_number'];
                $sub_array[] = $row['customer_name'];
                $sub_array[] = $row['user'];
                $sub_array[] = $row['adtitle'];
                $sub_array[] = $row['account_number'];
                $sub_array[] = $publication_list;
                $sub_array[] = date("M d, Y",strtotime($row['run_date']));
                $sub_array[] = $row['width'];
                $sub_array[] = $row['height'];
                $sub_array[] = $form_tab;
                
                $data[] = $sub_array;
            }
            $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $total_rows,  
                "recordsFiltered"   =>     $filtered_rows,  
                "data"              =>     $data  
           );  
           echo json_encode($output);  
    }
	
	public function preorders_waukesha_form()
	{
		if(isset($_POST['Submit']) && isset($_POST['id'])){
			$data['xml_file_data'] = $this->db->get_where('preorders_waukesha',array('id' => $_POST['id']))->result_array();
			$data['xml_file_data_publication'] = $this->db->query("SELECT DISTINCT `publication` FROM `preorders_waukesha_publication` WHERE `xml_file_data_id`='".$_POST['id']."' ;")->result_array();
			//if new ad not in cache create a cache order
    		if(!isset($_POST['cacheid'])){	
    			$dataa = array(
    					'adrep_id' => $this->session->userdata('ncId'),
    					'order_type_id' => '2',
    					);
    			$this->db->insert('order_cache', $dataa);
    			$cacheid = $this->db->insert_id();
    			$data['cacheid'] = $cacheid;
    		}
			$this->load->view('new_client/preorders_waukesha_form', $data);
		}else{
			if(isset($_POST['order_submit']) && isset($_POST['id']))
			{
				$xml_file_data = $this->db->get_where('preorders_waukesha',array('id' => $_POST['id']))->row_array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				$publication_hd = $this->db->query("SELECT * FROM `publications` WHERE `id`='".$client[0]['publication_id']."' ;")->result_array();  
			    $cacheid = $_POST['cacheid'];
			    //date needed
			    if(isset($_POST['date_needed']) && !empty($_POST['date_needed'])){ 
					$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
				} else {
					$date_needed = '0000-00-00';
				}
			    
				//publish date
				if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
				    $publish_date = date('Y-m-d', strtotime($_POST['publish_date']));
				}else{
				    $next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				
				if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; }
				
				$order_type = 'Print'; //initialise to print ads
				if(isset($xml_file_data['order_type']) && !empty($xml_file_data['order_type'])){
				    $order_type = $xml_file_data['order_type'];    
				}
				$project_id = '0';
				if(isset($_POST['project_id'])){ $project_id = $_POST['project_id']; }
				
				if($order_type == 'Online'){ //Online ad
				    $post = array(
                					'adrep_id' => $this->session->userdata('ncId'),
                					'publication_id' => $client[0]['publication_id'],
                					'group_id' => $publication_hd[0]['group_id'],
                					'help_desk' => $publication_hd[0]['help_desk'],
                					'order_type_id' => '1', 
                					'advertiser_name' => $_POST['advertiser_name'],
                					'date_needed' => $date_needed,
                					'publish_date' => $publish_date,
                					'job_no' => $_POST['job_no'],
                					'copy_content_description' => $_POST['copy_content_description'],
                					'notes' => $_POST['notes'],
                					'pixel_size' => 'custom',
				                    'custom_width' => $_POST['width'],
					                'custom_height' => $_POST['height'],
                					'rush' => $rush,
                					'activity_time' => date('Y-m-d h:i:s'),
                					'pickup_adno' => $_POST['pickupadnumber'],
                					'maxium_file_size' => $_POST['maximum_file_size'],
                					'ad_format' => $_POST['ad_format'],
                					'web_ad_type' => $_POST['web_ad_type'],
                					'club_id'=> $publication_hd[0]['club_id'],
                					'project_id' => $project_id,
                				);   
				}else{                      //Print ad
    				$post = array(
                					'adrep_id' => $this->session->userdata('ncId'),
                					'publication_id' => $client[0]['publication_id'],
                					'group_id' => $publication_hd[0]['group_id'],
                					'help_desk' => $publication_hd[0]['help_desk'],
                					'order_type_id' => '2', 
                					'advertiser_name' => $_POST['advertiser_name'],
                					'date_needed' => $date_needed,
                					'publish_date' => $publish_date,
                					'job_no' => $_POST['job_no'],
                					'copy_content_description' => $_POST['copy_content_description'],
                					'notes' => $_POST['notes'],
                					'width' => $_POST['width'],
                					'height' => $_POST['height'],
                					'print_ad_type' => $_POST['color'],
                					'rush' => $rush,
                					'activity_time' => date('Y-m-d h:i:s'),
                					'pickup_adno' => $_POST['pickupadnumber'],
                					'club_id'=> $publication_hd[0]['club_id'],
                					'project_id' => $project_id,
                				);
    				
				}
				$this->db->insert('orders',$post); 
    			$order_no = $this->db->insert_id();
    			
				if($order_no){
					//Live_tracker updation
					
						$tracker_data = array(
                        						'pub_id' => $publication_hd[0]['id'],
                        						'order_id' => $order_no,
                        						'job_no' => $_POST['job_no'],
                        						'club_id' => $publication_hd[0]['club_id'],
                        						'status' => '1'
                        						);
						$this->db->insert('live_orders', $tracker_data);
					
					 $post = array('accept' => '1', 'adwit_id' => $order_no);
					 $this->db->where('ad_number', $_POST['job_no']);
					 $this->db->update('preorders_waukesha', $post);
					 
					 $this->view($order_no,true); //send mail
					 $this->orders_folder($order_no); //folder creation
					 
					 $cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					 $order_theme_file = '';
					 if(isset($cache['id'])){
					     //updating order id to order_cache table
						$order_cache = array('order_id' =>$order_no );
						$this->db->where('id', $cacheid);
						$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						
						if(!empty($cache_file_path) && $cache_file_path != "none"){
						    $cache_path = getcwd().'/'.$cache_file_path;
							
							//copying files from order_cache folder to downloads folder
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$order_no'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											if(is_dir($cache_path.'/'.$file)) { continue; } //if mood board theme uploaded ignore Theme folder
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								}
								//Delete order_cache files
    							if(isset($cache_path) && is_dir($cache_path)){
    							    if(file_exists($cache_path.'/Theme')){
    							        array_map('unlink', glob("$cache_path/Theme/*.*"));
    							        rmdir($cache_path.'/Theme');  
    							    }
    							    array_map('unlink', glob("$cache_path/*.*"));
    							    rmdir($cache_path);
    							}
							}    
						}
					 }
					 $this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID :  ".$order_no."</p>");
					 redirect("new_client/home/dashboard");
					 //redirect('new_client/home/order_success/'.$order_no);//File upload
				}else{ 
					$this->session->set_flashdata("message","Internal Error: Order not placed!");
					redirect('new_client/home');
				} 
		  } 
		  //$this->load->view('new_client/list_xml_file_data', $data);
		}
	}
//START preorder Desert Shoppers - 43
	public function list_preorders_desert_shoppers()
	{
	    $today = date('Y-m-d');
		$pday = date('Y-m-d', strtotime(' -6 day'));
		$this->load->view('new_client/list_preorders_desert_shoppers');
	}
	
	public function list_preorders_desert_shoppers_content()
	{
	    $this->load->model("Preorder_desert_shoppers");  
        $fetch_data = $this->Preorder_desert_shoppers->make_datatables();  
	    
		$data = array();
		    foreach($fetch_data as $row)
            {
                $xml_file_data_publication = $this->db->query("SELECT DISTINCT `publication` FROM `preorders_desert_shoppers_publication` WHERE `xml_file_data_id`='".$row['id']."' ;")->result_array();
                $publication_list = '';
                foreach($xml_file_data_publication as $p){
    			    $publication_list .= $p['publication'].'<br/>';
    			}
    			$form_tab = '<form name="myform" action="'.base_url().index_page().'new_client/home/preorders_desert_shoppers_form" method="post">
										<input type="submit" name="Submit" value="Submit" class="btn btn-xs padding-5 btn-blue" />
										<input name="id" value="'.$row['id'].'" readonly style="display:none;"/>
									</form>';
                $sub_array = array();
                $sub_array[] = $row['ad_number'];
                $sub_array[] = $row['customer_name'];
                $sub_array[] = $row['user'];
                $sub_array[] = $row['adtitle'];
                $sub_array[] = $row['account_number'];
                $sub_array[] = $publication_list;
                $sub_array[] = date("M d, Y",strtotime($row['run_date']));
                $sub_array[] = $row['width'];
                $sub_array[] = $row['height'];
                $sub_array[] = $form_tab;
                
                $data[] = $sub_array;
            }
            $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>      $this->Preorder_desert_shoppers->get_all_data(),  
                "recordsFiltered"   =>     $this->Preorder_desert_shoppers->get_filtered_data(),  
                "data"              =>     $data  
           );  
           echo json_encode($output);  
            
	}
	
	public function preorders_desert_shoppers_form()
	{
		if(isset($_POST['Submit']) && isset($_POST['id'])){
			$data['xml_file_data'] = $this->db->get_where('preorders_desert_shoppers',array('id' => $_POST['id']))->result_array();
			$data['xml_file_data_publication'] = $this->db->query("SELECT DISTINCT `publication` FROM `preorders_desert_shoppers_publication` WHERE `xml_file_data_id`='".$_POST['id']."' ;")->result_array();
			//if new ad not in cache create a cache order
    		if(!isset($_POST['cacheid'])){	
    			$dataa = array(
    					'adrep_id' => $this->session->userdata('ncId'),
    					'order_type_id' => '2',
    					);
    			$this->db->insert('order_cache', $dataa);
    			$cacheid = $this->db->insert_id();
    			$data['cacheid'] = $cacheid;
    		}
			$this->load->view('new_client/preorders_desert_shoppers_form', $data);
		}
		 else
		 {
			if(isset($_POST['order_submit']) && isset($_POST['id']))
			{
				$xml_file_data = $this->db->get_where('preorders_desert_shoppers',array('id' => $_POST['id']))->row_array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('ncId')))->result_array();
				$publication_hd = $this->db->query("SELECT * FROM `publications` WHERE `id`='".$client[0]['publication_id']."' ;")->result_array();  
			    $cacheid = $_POST['cacheid'];
			    //date needed
			    if(isset($_POST['date_needed']) && !empty($_POST['date_needed'])){ 
					$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
				} else {
					$date_needed = '0000-00-00';
				}
			    
				//publish date
				if(isset($_POST['publish_date']) && !empty($_POST['publish_date'])){
				    $publish_date = date('Y-m-d', strtotime($_POST['publish_date']));
				}else{
				    $next_day =  date('D', strtotime(' +1 day'));
					if($next_day == 'Sat' || $next_day == 'Sun'){
						$publish_date = date('Y-m-d', strtotime('next monday'));
					}else{
						$publish_date = date('Y-m-d', strtotime(' +1 day'));
					}
				}
				
				if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; }
				
				$order_type = 'Print'; //initialise to print ads
				if(isset($xml_file_data['order_type']) && !empty($xml_file_data['order_type'])){
				    $order_type = $xml_file_data['order_type'];    
				}
				
				if($order_type == 'Online'){ //Online ad
				    $post = array(
                					'adrep_id' => $this->session->userdata('ncId'),
                					'publication_id' => $client[0]['publication_id'],
                					'group_id' => $publication_hd[0]['group_id'],
                					'help_desk' => $publication_hd[0]['help_desk'],
                					'order_type_id' => '1', 
                					'advertiser_name' => $_POST['advertiser_name'],
                					'date_needed' => $date_needed,
                					'publish_date' => $publish_date,
                					'job_no' => $_POST['job_no'],
                					'copy_content_description' => $_POST['copy_content_description'],
                					'notes' => $_POST['notes'],
                					'pixel_size' => 'custom',
				                    'custom_width' => $_POST['width'],
					                'custom_height' => $_POST['height'],
                					'rush' => $rush,
                					'activity_time' => date('Y-m-d h:i:s'),
                					'pickup_adno' => $_POST['pickupadnumber'],
                					'maxium_file_size' => $_POST['maximum_file_size'],
                					'ad_format' => $_POST['ad_format'],
                					'web_ad_type' => $_POST['web_ad_type'],
                					'club_id'=> $publication_hd[0]['club_id']
                				);   
				}else{                      //Print ad
    				$post = array(
                					'adrep_id' => $this->session->userdata('ncId'),
                					'publication_id' => $client[0]['publication_id'],
                					'group_id' => $publication_hd[0]['group_id'],
                					'help_desk' => $publication_hd[0]['help_desk'],
                					'order_type_id' => '2', 
                					'advertiser_name' => $_POST['advertiser_name'],
                					'date_needed' => $date_needed,
                					'publish_date' => $publish_date,
                					'job_no' => $_POST['job_no'],
                					'copy_content_description' => $_POST['copy_content_description'],
                					'notes' => $_POST['notes'],
                					'width' => $_POST['width'],
                					'height' => $_POST['height'],
                					'print_ad_type' => $_POST['color'],
                					'rush' => $rush,
                					'activity_time' => date('Y-m-d h:i:s'),
                					'pickup_adno' => $_POST['pickupadnumber'],
                					'club_id'=> $publication_hd[0]['club_id']
                					//'priority' => $priority,
                				);
    				
				}
				$this->db->insert('orders',$post); 
    			$order_no = $this->db->insert_id();
    			
				if($order_no){
					//Live_tracker updation
						$tracker_data = array(
                        						'pub_id' => $publication_hd[0]['id'],
                        						'order_id' => $order_no,
                        						'job_no' => $_POST['job_no'],
                        						'club_id' => $publication_hd[0]['club_id'],
                        						'status' => '1'
                        						);
						$this->db->insert('live_orders', $tracker_data);
					
					 $post = array('accept' => '1', 'adwit_id' => $order_no);
					 $this->db->where('ad_number', $_POST['job_no']);
					 $this->db->update('preorders_desert_shoppers', $post);
					 
					 $this->view($order_no,true); //send mail
					 $this->orders_folder($order_no); //folder creation
					 
					 $cache = $this->db->get_where('order_cache',array('id'=>$cacheid))->row_array();
					 $order_theme_file = '';
					 if(isset($cache['id'])){
					     //updating order id to order_cache table
						$order_cache = array('order_id' =>$order_no );
						$this->db->where('id', $cacheid);
						$this->db->update('order_cache', $order_cache);
						$cache_file_path = $cache['file_path'];
						
						if(!empty($cache_file_path) && $cache_file_path != "none"){
						    $cache_path = getcwd().'/'.$cache_file_path;
							
							//copying files from order_cache folder to downloads folder
							$order_details = $this->db->query("SELECT `file_path` FROM `orders` WHERE `id` = '$order_no'")->row_array();
							$order_file_path = $order_details['file_path'];
							$download_path = getcwd().'/'.$order_file_path;
							
							if(!empty($order_file_path) && $order_file_path != "none"){
								 if(is_dir($cache_path)){
									if($dh = opendir($cache_path)){
										while(($file = readdir($dh)) !== false){
											if($file== '.' || $file== '..') { continue; } 
											if(is_dir($cache_path.'/'.$file)) { continue; } //if mood board theme uploaded ignore Theme folder
											//copy($cache_path.'/'.$file, $download_path.'/'.$file);
											@rename($cache_path.'/'.$file, $download_path.'/'.$file);
										}
										closedir($dh);
									}
								}
								//Delete order_cache files
    							if(isset($cache_path) && is_dir($cache_path)){
    							    if(file_exists($cache_path.'/Theme')){
    							        array_map('unlink', glob("$cache_path/Theme/*.*"));
    							        rmdir($cache_path.'/Theme');  
    							    }
    							    array_map('unlink', glob("$cache_path/*.*"));
    							    rmdir($cache_path);
    							}
							}    
						}
					 }
					 $this->session->set_flashdata("message","<p> Your order has been placed - AdwitAds ID :  ".$order_no."</p>");
					 redirect("new_client/home/dashboard");
					 //redirect('new_client/home/order_success/'.$order_no);//File upload
				}else{ 
					$this->session->set_flashdata("message","Internal Error: Order not placed!");
					redirect('new_client/home');
				} 
		  } 
		  
		}
	}
//END preorder Desert Shoppers - 43	
	public function dashboard_report()
	{
	    if(isset($_GET['from_date']) && isset($_GET['to_date'])){
	        $date = 'custom';
	        $from = $_GET['from_date'];
			$to =  $_GET['to_date']; 
			$data['from'] = $from; $data['to'] = $to;
			
			$date1=date_create($from);
            $date2=date_create($to);
            $diff=date_diff($date1,$date2);
            $operand = $diff->format("%R");
            $day_diff = $diff->format("%a");
            //echo $diff->format("%R%a days");
            
            if($operand == '+'){
               if($day_diff <= 30){
                    $query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
    				            FROM orders 
    				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND adrep_id = '".$this->session->userdata('ncId')."'
    				            GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
                }else{
                    $query = "SELECT MONTHNAME(created_on) as MONTH, COUNT(*) as ad_count 
    				            FROM orders 
    				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND adrep_id = '".$this->session->userdata('ncId')."'
    				            GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
                } 
            }else{
                $this->session->set_flashdata("message","Specify proper From and To date..!!");
                redirect('new_client/home/dashboard_report');
            }
				       
	    }elseif(isset($_GET['date_range'])){
	        $date = $_GET['date_range'];
	        if($date == 'yesterday'){
				$from = date('Y-m-d', strtotime("-1 day"));
				$to =  date('Y-m-d');
				$query = "SELECT DAY(created_on) as MONTH, COUNT(*) as ad_count 
				            FROM orders 
				            WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND adrep_id = '".$this->session->userdata('ncId')."'
				            GROUP BY DAY(created_on)";
    		}elseif($date == 'last_week'){
    				$from = date('Y-m-d', strtotime("-1 week +1 day"));
    				$to =  date('Y-m-d');
    			$query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY DAY(created_on) ORDER BY `created_on` ASC";	
    		}elseif($date == 'last_month'){
    				$from = date('Y-m-d', strtotime("-1 month"));
    				$to =  date('Y-m-d');
    			$query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'three_month'){
    				$from = date('Y-m-d', strtotime("-3 month"));
    				$to =  date('Y-m-d');
    				$query = "SELECT MONTHNAME(created_on) as MONTH, COUNT(*) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'six_month'){
    				$from = date('Y-m-d', strtotime("-6 month"));
    				$to =  date('Y-m-d');
    				$query = "SELECT MONTHNAME(created_on) as MONTH, COUNT(*) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'one_year'){
    		    $curr_year = date('Y');
    		    $query = "SELECT MONTHNAME(created_on) MONTH, COUNT(*) as ad_count 
                            FROM orders 
                            WHERE YEAR(created_on) = '$curr_year' AND adrep_id = '".$this->session->userdata('ncId')."'
                            GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'custom' && isset($_GET['from'])){
    				$from = $_GET['from'];
    				$to =  $_GET['to'];
    				$data['custom'] = date('Y-m-d');
    		}
	    }else{	
    	
    	    $date = 'last_week';
    	    $query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
                	    FROM orders 
                	    WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND adrep_id = '".$this->session->userdata('ncId')."'
                	    GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
	    }
	    
        $orders = $this->db->query($query)->result_array();
        foreach($orders as $row){
            $values[] = $row['ad_count']; 
            $months[] = $row['MONTH']; 
        }
            //echo $query;
       if(isset($values) && !empty($values)) $data['order_count'] = join(',', $values); else $data['order_count'] = '';
        if(isset($months) && !empty($months)) $data['month_list'] = json_encode($months); else $data['month_list'] = '';
        $data['date'] = $date;
	    
	    $this->load->view('new_client/dashboard_report', $data); 
	}
	
	public function bar_chart()
	{
	    if(isset($_GET['from_date']) && isset($_GET['to_date'])){
	        $date = 'custom';
	        $from = $_GET['from_date'];
			$to =  $_GET['to_date']; 
			$data['from'] = $from; $data['to'] = $to;
			
			$date1=date_create($from);
            $date2=date_create($to);
            $diff=date_diff($date1,$date2);
            $operand = $diff->format("%R");
            $day_diff = $diff->format("%a");
            //echo $diff->format("%R%a days");
            
            if($operand == '+'){
               if($day_diff <= 30){
                    $query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, AVG(`width`*`height`) as ad_count 
				            FROM orders 
				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND adrep_id = '".$this->session->userdata('ncId')."'
				            GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
                }else{
                    $query = "SELECT MONTHNAME(created_on) as MONTH, AVG(`width`*`height`) as ad_count 
				            FROM orders 
				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND adrep_id = '".$this->session->userdata('ncId')."'
				            GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
                } 
            }else{
                $this->session->set_flashdata("message","Specify proper From and To date..!!");
                redirect('new_client/home/bar_chart');
            }
        		       
	    }elseif(isset($_GET['date_range'])){
	        $date = $_GET['date_range'];
	        if($date == 'yesterday'){
				$query = "SELECT DAY(created_on) as MONTH, AVG(`width`*`height`) as ad_count 
				            FROM orders 
				            WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND adrep_id = '".$this->session->userdata('ncId')."'
				            GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'last_week'){
    			$query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, AVG(`width`*`height`) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY DAY(created_on) ORDER BY `created_on` ASC";	
    		}elseif($date == 'last_month'){
    			$query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, AVG(`width`*`height`) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'three_month'){
    			$query = "SELECT MONTHNAME(created_on) as MONTH, AVG(`width`*`height`) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'six_month'){
    			$query = "SELECT MONTHNAME(created_on) as MONTH, AVG(`width`*`height`) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
    		}elseif($date == 'one_year'){
    		    $curr_year = date('Y');
    		    $query = "SELECT MONTHNAME(created_on) MONTH, AVG(`width`*`height`) as ad_count 
                            FROM orders 
                            WHERE YEAR(created_on) = '$curr_year' AND adrep_id = '".$this->session->userdata('ncId')."'
                            GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
    		}
	    }else{	
    	
    	    $date = 'last_week';
    	    $query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, AVG(`width`*`height`) as ad_count 
                	    FROM orders 
                	    WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND adrep_id = '".$this->session->userdata('ncId')."'
                	    GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
	    }
	    
        $orders = $this->db->query($query)->result_array();
        foreach($orders as $row){
            $month_value[] = "['".$row['MONTH']."', ".$row['ad_count']."]";
        }
            //echo $query;
        if(isset($month_value) && !empty($month_value)) $data['month_value'] = join(',', $month_value); else $data['month_value'] = '';
        
        $data['date'] = $date;
	    $this->load->view('new_client/bar_graph', $data);
	}
	
	public function report_ad_type()
	{
	    if(isset($_GET['from_date']) && isset($_GET['to_date'])){
	        $date = 'custom';
	        $from = $_GET['from_date'];
			$to =  $_GET['to_date']; 
			$data['from'] = $from; $data['to'] = $to;
			
            $query1 = "SELECT COUNT(id) as ad_count 
				            FROM orders 
				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND adrep_id = '".$this->session->userdata('ncId')."'
				            AND `print_ad_type` = '1'";
			$query2 = "SELECT COUNT(id) as ad_count 
				            FROM orders 
				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND adrep_id = '".$this->session->userdata('ncId')."'
				            AND `print_ad_type` = '2'";
            		       
	    }elseif(isset($_GET['date_range'])){
	        $date = $_GET['date_range'];
	        if($date == 'yesterday'){
				$query1 = "SELECT COUNT(id) as ad_count 
				            FROM orders 
				            WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND `adrep_id` = '".$this->session->userdata('ncId')."'
				            AND `print_ad_type` = '1'";
				$query2 = "SELECT COUNT(id) as ad_count 
				            FROM orders 
				            WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND `adrep_id` = '".$this->session->userdata('ncId')."'
				            AND `print_ad_type` = '2'";
    		}elseif($date == 'last_week'){
    			$query1 = "SELECT COUNT(id) as ad_count  
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '1'";	
                $query2 = "SELECT COUNT(id) as ad_count  
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '2'";	
    		}elseif($date == 'last_month'){
    			$query1 = "SELECT COUNT(id) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '1'";	
                $query2 = "SELECT COUNT(id) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '2'";	
    		}elseif($date == 'three_month'){
    			$query1 = "SELECT COUNT(id) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '1'";	
                $query2 = "SELECT COUNT(id) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '2'";	
    		}elseif($date == 'six_month'){
    			$query1 = "SELECT COUNT(id) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '1'";	
                $query2 = "SELECT COUNT(id) as ad_count 
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '2'";	
    		}elseif($date == 'one_year'){
    		    $curr_year = date('Y');
    		    $query1 = "SELECT COUNT(id) as ad_count  
                            FROM orders 
                            WHERE YEAR(created_on) = '$curr_year' AND adrep_id = '".$this->session->userdata('ncId')."'
                            AND `print_ad_type` = '1'";	
                $query2 = "SELECT COUNT(id) as ad_count  
                            FROM orders 
                            WHERE YEAR(created_on) = '$curr_year' AND adrep_id = '".$this->session->userdata('ncId')."'
                            AND `print_ad_type` = '2'";	
    		}
	    }else{	
    	
    	    $date = 'last_week';
    	    $query1 = "SELECT COUNT(id) as ad_count  
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '1'";	
            $query2 = "SELECT COUNT(id) as ad_count  
                			FROM orders 
                			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND adrep_id = '".$this->session->userdata('ncId')."'
                			AND `print_ad_type` = '2'";	
	    }
	    
        $orders_color = $this->db->query($query1)->row_array();
        $orders_bw = $this->db->query($query2)->row_array();
        
        $data['color_count'] = $orders_color['ad_count'];
        $data['bw_count'] = $orders_bw['ad_count'];;
        
        $data['date'] = $date;
	    $this->load->view('new_client/report_ad_type', $data);
	}
	
	public function report_advertiser($advertiser = '')
	{
	   $advertiser = urldecode($advertiser);
	   $data['advertiser'] = $advertiser;
	   
	   $q = "SELECT DISTINCT `advertiser_name` FROM orders WHERE `adrep_id` = '".$this->session->userdata('ncId')."' ORDER BY `advertiser_name` ASC"; 
	   $data['advertiser_list'] = $this->db->query($q)->result_array();
	   
	   if(isset($advertiser) && $advertiser != ''){
	       if(isset($_GET['from_date']) && isset($_GET['to_date'])){
    	        $date = 'custom';
    	        $from = $_GET['from_date'];
    			$to =  $_GET['to_date']; 
    			$data['from'] = $from; $data['to'] = $to;
    			
    			$date1=date_create($from);
                $date2=date_create($to);
                $diff=date_diff($date1,$date2);
                $operand = $diff->format("%R");
                $day_diff = $diff->format("%a");
                //echo $diff->format("%R%a days");
                
                if($operand == '+'){
                   if($day_diff <= 30){
                        $query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
        				            FROM orders 
        				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND advertiser_name = '".$advertiser."'
        				            GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
                    }else{
                        $query = "SELECT MONTHNAME(created_on) as MONTH, COUNT(*) as ad_count 
        				            FROM orders 
        				            WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND advertiser_name = '".$advertiser."'
        				            GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
                    } 
                }else{
                    $this->session->set_flashdata("message","Specify proper From and To date..!!");
                    redirect('new_client/home/report_advertiser/'.$advertiser);
                }
    				       
    	    }elseif(isset($_GET['date_range'])){
    	        $date = urldecode($_GET['date_range']); 
    	        if($date == 'yesterday'){
    				$from = date('Y-m-d', strtotime("-1 day"));
    				$to =  date('Y-m-d');
    				$query = "SELECT DAY(created_on) as MONTH, COUNT(*) as ad_count 
    				            FROM orders 
    				            WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND advertiser_name = '".$advertiser."'
    				            GROUP BY DAY(created_on)";
        		}elseif($date == 'last_week'){
        				$from = date('Y-m-d', strtotime("-1 week +1 day"));
        				$to =  date('Y-m-d');
        			$query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
                    			FROM orders 
                    			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND advertiser_name = '".$advertiser."'
                    			GROUP BY DAY(created_on) ORDER BY `created_on` ASC";	
        		}elseif($date == 'last_month'){
        				$from = date('Y-m-d', strtotime("-1 month"));
        				$to =  date('Y-m-d');
        			$query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
                    			FROM orders 
                    			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND advertiser_name = '".$advertiser."'
                    			GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
        		}elseif($date == 'three_month'){
        				$from = date('Y-m-d', strtotime("-3 month"));
        				$to =  date('Y-m-d');
        				$query = "SELECT MONTHNAME(created_on) as MONTH, COUNT(*) as ad_count 
                    			FROM orders 
                    			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND advertiser_name = '".$advertiser."'
                    			GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
        		}elseif($date == 'six_month'){
        				$from = date('Y-m-d', strtotime("-6 month"));
        				$to =  date('Y-m-d');
        				$query = "SELECT MONTHNAME(created_on) as MONTH, COUNT(*) as ad_count 
                    			FROM orders 
                    			WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND advertiser_name = '".$advertiser."'
                    			GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
        		}elseif($date == 'one_year'){
        		    $curr_year = date('Y');
        		    $query = "SELECT MONTHNAME(created_on) MONTH, COUNT(*) as ad_count 
                                FROM orders 
                                WHERE YEAR(created_on) = '$curr_year' AND advertiser_name = '".$advertiser."'
                                GROUP BY MONTH(created_on) ORDER BY `created_on` ASC";
        		}elseif($date == 'custom' && isset($_GET['from'])){
        				$from = $_GET['from'];
        				$to =  $_GET['to'];
        				$data['custom'] = date('Y-m-d');
        		}
    	    }else{	
        	
        	    $date = 'last_week';
        	    $query = "SELECT CONCAT(MONTHNAME(created_on), '-', DAY(created_on)) as MONTH, COUNT(*) as ad_count 
                    	    FROM orders 
                    	    WHERE  `created_on` >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND advertiser_name = '".$advertiser."'
                    	    GROUP BY DAY(created_on) ORDER BY `created_on` ASC";
    	    }
    	    
            $orders = $this->db->query($query)->result_array();
            foreach($orders as $row){
                $values[] = $row['ad_count']; 
                $months[] = $row['MONTH']; 
            }
                //echo $query;
           if(isset($values) && !empty($values)) $data['order_count'] = join(',', $values); else $data['order_count'] = '';
            if(isset($months) && !empty($months)) $data['month_list'] = json_encode($months); else $data['month_list'] = '';
            $data['date'] = $date;
    	    
	   }
	   
	   $this->load->view('new_client/report_advertiser', $data);
	}
	
	//skip and download fuctionality START
	
	public function zip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			if(isset($_POST['order_id'])){ $order_id = $_POST['order_id']; }
			
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
			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
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
				
				//create folder in pdf_uploads and upload file
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
				
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}

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

    public function ttest_mail($dataa) 
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

		if(isset($dataa['template'])){
			$email->addContent("text/html", $this->load->view($dataa['template'],$dataa, TRUE)); 
		  if($dataa['template']!='order_rating_mailer'){
			if(isset($dataa['temp'])){ 
			    $file_encoded = base64_encode(file_get_contents($dataa['temp']));
                $email->addAttachment(
                                    $file_encoded,
                                    "application/pdf",
                                    basename($dataa['fname']),
                                    "attachment"
                                );
				//$email->addAttachment($dataa['temp'], "application/pdf", $dataa['fname'], "attachment");
			}  
		  }
		}
		
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);   
	   
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

    public function skip_and_download()
    {
        if(isset($_POST['end_time']))
        {
            $order_id = $_POST['order_id'];
            $orders = $this->db->get_where('orders', array('id' => $order_id))->result_array();
            $job_name = $orders[0]['job_no'];
            $advertiser_name = $orders[0]['advertiser_name'];
            $source_path = $_POST['source_path'];
            $hd = $_POST['hd'];
            $source_file = $_POST['source_file'];
            $slug = $_POST['new_slug'];
            $pdf_file = $_POST['pdf_file'];
            
			//File upload in pdf_upload folder
			
			if($this->zip_folder_select()==true){
				$pdf_uploads = "pdf_uploads/".$order_id;
			}else{ 
				$this->session->set_flashdata("message","Error uploading source to Adrep!!");
				redirect('new_client/home/dashboard');
			}
				
			$map_pdf_uploads = directory_map($pdf_uploads.'/');
			if($map_pdf_uploads)
			{
				$map_pdf_jpg = glob($pdf_uploads.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
				if($map_pdf_jpg){ 
                    foreach($map_pdf_jpg as $row){
					    $pdf_file = $row; $pdf = $row;
				    } 
                }

				if($orders[0]['help_desk']=='2'){
					$check_mail = $this->metro_ftp($pdf_file);
				}else{
				    $client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
					$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
					$dataa['template'] = $design_team[0]['newad_template'];
						
					if($publication[0]['id'] == '47'){ 
						if(($design_team[0]['newad_template'] == 'order_rating_mailer') ){
							$dataa['subject'] = 'New Ad(Note): '.$job_name.'_'.$advertiser_name;
						}else{
							$dataa['subject'] = 'New Ad: '.$job_name.'_'.$advertiser_name;
						}
					}else{
						if(($design_team[0]['newad_template'] == 'order_rating_mailer')){
							$dataa['subject'] = 'New Ad(Note): '.$slug ;
						}else{
							$dataa['subject'] = 'New Ad: '.$slug ;
						}
					}
					$dataa['alias'] = '';
					$dataa['from'] = $design_team[0]['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team[0]['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
						
					if(!empty($client[0]['email_cc']) || $client[0]['email_cc'] != ''){ 
                        $dataa['client_Cc'] = $client[0]['email_cc']; 
                    }
						
					$dataa['ad_type'] = 'new' ; 
					
					//Client
					$dataa['recipient'] = $client[0]['email_id'];
					
					$dataa['fname'] = $pdf_file; 
					$dataa['temp'] = $pdf_file; 
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					$dataa['client'] = $client[0];
					$dataa['design_team_id'] = $design_team[0]['id'];
					$dataa['order_id'] = $order_id;
					$this->load->library('Encryption');
					$dataa['url']= base_url().index_page().'order_rating/home/new_order_rating/'.$this->encryption->encrypt($order_id);
						
					$this->ttest_mail($dataa);
						
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
					$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/order_status_update'; //adwitmap
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
			}else{ 
                $this->session->set_flashdata("message",$order_id." - Pdf Not Found"); 
            }
			
			$this->session->set_flashdata("sucess_message",$order_id." - Uploaded & Sent To Adrep..!!");
			redirect('new_client/home/dashboard');
		}
    }
	//skip and download fuctionality END
	
//pagination NEW START
    public function page_new_dashboard($status = '')
    {
        $aId = $this->session->userdata('ncId');
	    $data['adrep_detail'] = $this->db->query("SELECT adreps.team_orders FROM `adreps` WHERE adreps.id = '".$aId."'")->row_array();
        $this->load->view('page_design_view/page_new_dashboard', $data);
    }
    
    public function page_dashboard_ads_count()
    {
        $AllCount = 0; $InProductionCount = 0; $ProoReadyCount = 0; $QuestionCount = 0; $ApprovedCount = 0;
        $aId = $this->session->userdata('ncId');
	    $adrep_detail = $this->db->query("SELECT adreps.team_orders, adreps.publication_id FROM `adreps` WHERE adreps.id = '".$aId."'")->row_array();
	    
        if(isset($_POST['from_date'], $_POST['to_date'])){
            $from = date("Y-m-d", strtotime($_POST['from_date'])). " 00:00:00";
            $to = date("Y-m-d", strtotime($_POST['to_date'])). " 23:59:59";
            
            $query = "SELECT COUNT(orders.id) AS adCount, orders.rev_order_status FROM `orders`
                        LEFT JOIN `rev_sold_jobs` ON rev_sold_jobs.id = orders.rev_id 
                        WHERE orders.order_type_id = '6' AND (orders.created_on BETWEEN '$from' AND '$to')" ;
                        
            if($adrep_detail['team_orders'] == '1'){
			    $query .= " AND (orders.adrep_id = '".$aId."' OR orders.publication_id = '".$adrep_detail['publication_id']."')";   
			}else{
			    $query .= " AND orders.adrep_id = '".$aId."'";    
			}
			
            $AllCountQ = $this->db->query($query." AND orders.question != '1'")->row_array();
            $AllCount = $AllCountQ['adCount'];
            
            $InProductionCountQ = $this->db->query($query." AND (orders.status = '3' || orders.rev_order_status = '3') AND orders.question != '1'")->row_array();
            $InProductionCount = $InProductionCountQ['adCount'];
            
            $ProoReadyCountQ = $this->db->query($query." AND (orders.status = '5' AND orders.rev_order_status IN ('5', '0')) AND orders.question != '1'")->row_array();
            $ProoReadyCount = $ProoReadyCountQ['adCount'];
            
            $QuestionCountQ = $this->db->query($query." AND (orders.question = '1' OR rev_sold_jobs.question = '1')")->row_array();
            $QuestionCount = $QuestionCountQ['adCount'];
            
            $ApprovedCountQ = $this->db->query($query." AND (orders.status = '7' OR orders.rev_order_status = '9') AND orders.question != '1'")->row_array();
            $ApprovedCount = $ApprovedCountQ['adCount'];
        }
        
       $data['AllCount'] = $AllCount;
       $data['InProductionCount'] = $InProductionCount;
       $data['ProoReadyCount'] = $ProoReadyCount;
       $data['QuestionCount'] = $QuestionCount;
       $data['ApprovedCount'] = $ApprovedCount;
       $data['query'] = $query;
       echo json_encode($data);
    }
    
    public function page_dashboard_content()
	{
	    $aId = $this->session->userdata('ncId');
	    $adrep_detail = $this->db->query("SELECT adreps.team_orders, adreps.publication_id FROM `adreps` WHERE adreps.id = '".$aId."'")->row_array();
		if(isset($_GET['from_date'], $_GET['to_date'])){
			$from = date("Y-m-d", strtotime($_GET['from_date'])). " 00:00:00";
            $to = date("Y-m-d", strtotime($_GET['to_date'])). " 23:59:59";
            //main order query(page_design)
            $page_design_query = "SELECT page_design.id, page_design.unique_job_name, page_design.publish_date, CONCAT(adreps.first_name, ' ', adreps.last_name) AS adrepName, page_design_status.name AS page_design_status_name FROM page_design
				                            JOIN `adreps` ON adreps.id = page_design.user_id
						                    JOIN `page_design_status` ON page_design_status.id = page_design.status
				                            WHERE (page_design.created_on BETWEEN '$from' AND '$to')" ;
			if($adrep_detail['team_orders'] == '1'){
			    $page_design_query .= " AND (page_design.user_id = '".$aId."' OR adreps.publication_id = '".$adrep_detail['publication_id']."')";   
			}else{
			    $page_design_query .= " AND page_design.user_id = '".$aId."'";    
			}	                            
			$page_design_query .= " AND (";
		    //search or Filter
			if(isset($_GET['search']['value'])){
			    $page_design_query .= ' page_design.unique_job_name LIKE "%'.$_GET["search"]["value"].'%"';

				$page_design_query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';

				$page_design_query .= ' OR page_design.id LIKE "%'.$_GET["search"]["value"].'%"';

				//$page_design_query .= ' OR page_design.advertiser_name LIKE "%'.$_GET["search"]["value"].'%"';

			}
			$page_design_query .= ") ";
			
			//ORDER BY
			//$order_column = array("id", "publish_date", null, "unique_job_name", "adrepName");
			if(isset($_GET['order'])){
				$page_design_query .= ' ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
			}else{
				$page_design_query .= ' ORDER BY page_design.created_on DESC';
			}
			
			$extra_query = '';
			if($_GET['length'] != -1){
				$extra_query .= ' LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
			}
			//echo $page_design_query;
			$filtered_rows = $this->db->query($page_design_query)->num_rows();
			$page_design_query .= $extra_query;
			
			$page_design_orders = $this->db->query("$page_design_query")->result_array();
			$total_rows = $this->db->query($page_design_query)->num_rows();
			
			$data = array();
			foreach($page_design_orders as $page_design_order){
			    $page_design_id = $page_design_order['id'];
			    //sub order query(orders table)
			    $query = "SELECT orders.id, orders.job_no, orders.pdf, orders.status, orders.rev_order_status, orders.page_design_id, orders.publish_date, orders.rev_id, 
			    orders.question, orders.crequest, orders.cancel, order_status.name AS order_status_name, rev_order_status.name AS rev_order_status_name, rev_sold_jobs.id AS rev_sold_jobs_id, 
			    rev_sold_jobs.question AS rev_question, rev_sold_jobs.pdf_path AS revision_pdf_path FROM orders
				                            JOIN `order_status` ON order_status.id = orders.status
						                    LEFT JOIN `rev_sold_jobs` ON rev_sold_jobs.id = orders.rev_id
						                    LEFT JOIN `rev_order_status` ON rev_order_status.id = orders.rev_order_status
				                            WHERE orders.page_design_id = '$page_design_id' AND orders.cancel = '0'" ;
				$orders = $this->db->query("$query")->result_array();
				if(isset($orders[0]['id'])){
    				//main order row array                            
    			    $sub_array = array();
    				$sub_array[] = $page_design_order['id']; // page_design_id
        			$sub_array[] = date("M d, Y", strtotime($page_design_order['publish_date']));	// publish_date
        			$sub_array[] = '';
        			$sub_array[] = $page_design_order['unique_job_name'];	// job_no/page name
        			$sub_array[] = $page_design_order['adrepName'];	// Adrep Name
        			$sub_array[] = '';//$page_design_order['page_design_status_name'];	//status
        			//action items
        		
        			$sub_array[] = '<span><a href="'.base_url().index_page().'new_client/home/page_add/'.$page_design_id.'">
        			                    <button type="button" class="btn btn-blue btn-xs btn-circle blue">Add New Page</button>
        			                </a></span>
        			                <!--<span data-toggle="modal" data-target=".add-page-modal">
        			                    <button type="button" class="btn btn-blue btn-xs btn-circle blue openBtn" data-page-design-id="'.$page_design_id.'" data-toggle="tooltip" data-bs-placement="top">Add New Page</button>
        			                </span>-->
    				                <span><button type="button" class="btn btn-green btn-xs btn-circle green ">Approve</button></span>
    				                <!--<i title="View Details" class="fa fa-chevron-down padding-left-15 pointer" data-toggle="collapse" id="row'.$page_design_id.'" data-target=".row'.$page_design_id.'"></i>-->
    				                <span class="arrow margin-top-10 padding-left-15 margin-left-10 pointer " data-toggle="collapse" id="row'.$page_design_id.'" data-target=".row'.$page_design_id.'" (click)="toggleOpen($event)">
    										<span></span>
    										<span></span>
    								</span>';
    				$data[] = $sub_array;
    				//Individual order details
    				
    				foreach($orders as $order){
        			    $pdf_path = $order['pdf']; //initial $pdf_path orders pdf_path
        			    $status = $order['status'];
        			    $revision_status = 0;
        			    if(isset($order['rev_sold_jobs_id'])){ 
        			        $revision_status = $order['rev_order_status'];
        			        $pdf_path = $order['revision_pdf_path']; //overwrite var $pdf_path with revision pdf path value
        			    }
        			    //sub order row array 
        				$sub_array = array();
        				//$sub_array[] = $order['id']; //order id
        				$sub_array[] = $order['page_design_id']; //order page_design_id
            			$sub_array[] = date("M d, Y", strtotime($order['publish_date']));	//order publish_date
            			
    					if($order['status']=='5' || $order['status']=='7'){
    					    $sub_array[] = '<a href="'.base_url().index_page().'new_client/home/revision_details/'.$order['id'].'" style="cursor:pointer; text-decoration: underline;">'
    					        .$order['job_no'].'</a>';
    					}else{
            			    $sub_array[] = $order['job_no'];	//order job_no/page name
            			}
            			$sub_array[] = '';//$order['advertiser_name']; //order advertiser_name
            			$sub_array[] = $page_design_order['adrepName']; //order Adrep Name
            			
            			//Order Status START
            			$pending_status = array(9, 10, 11);
            			if(in_array($status, $pending_status)){ //pending or draft
            			    $order_status = '<a href="'.base_url().index_page().'new_client/home/page_order_view/'.$order['page_design_id'].'/'.$order['id'].'">Pending</a>';
            			//}elseif($order['question'] == '1' || $order['rev_question'] == '1'){ //Question sent
            			 //   $order_status = 'Question';	
            			}else{
            			    if(isset($order['rev_order_status_name'])){ //if in revision get revision status
            			        $order_status = $order['rev_order_status_name'];
            			    }else{
                			    $order_status = $order['order_status_name'];
            			    }
            			    if($order['question'] == '1' || $order['rev_question'] == '1') $order_status .= '<p><small>(Question)</small></p>'; //order in question
                			if($order['crequest']!='0') $order_status .= '<p><small>(Cancel Requested)</small></p>'; //order cancel request
            			}
            			$sub_array[] = $order_status;	//order Status
            			//Order Status END
            			
            			//Order Action START
            			$order_detail_view = ''; $order_additional_attachment = ''; $order_question_answer = ''; $order_view_pdf = ''; $order_submit_revision = ''; $order_approve = ''; $order_cancel = '';
            			$order_detail_view = '
                			                    <a href="'.base_url().index_page().'new_client/home/order_action/view/'.$order['id'].'" >
                			                    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/order_view.png">
            									<!--<i class="bi bi-eye-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="View Order"></i>-->
            									</a>
            							';
            			if($status == '1' || $status == '2' || $status == '3') {
            			    $order_additional_attachment = '
                            								    <a href="'.base_url().index_page().'new_client/home/page_additional_attachment/'.$order['id'].'" >
                            								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/attachment.png">
                            									<!--<i class="bi bi-paperclip fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Additional Attachment"></i>-->
                            									</a>
                            								';
                            								
            			}
            			//Question START 
            			if($order['question']=='1'){
            			    $order_question_answer = '
                        								    <a href="'.base_url().index_page().'new_client/home/new_ad_answer/'.$order['id'].'" >
                        										<i class="bi bi-chat fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Answer Question"></i>
                        									</a>
                        								';
            			}elseif($order['rev_question'] == '1'){
            			    $order_question_answer = '
                        								    <a href="'.base_url().index_page().'new_client/home/rev_ad_answer/'.$order['rev_id'].'" >
                        										<i class="bi bi-chat fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Answer Question"></i>
                        									</a>
                        								';
            			}
            			//Question END
            			$order_pdf_status = array(5, 7); $revision_pdf_status = array(0, 5, 9);
            			if(in_array($status, $order_pdf_status) && in_array($revision_status, $revision_pdf_status) && $pdf_path != 'none' && file_exists($pdf_path)){
            			    $order_view_pdf = '
        								    <a href="'.base_url().$pdf_path.'" target="_blank">
        								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/pdf.png">
        									    <!--<i class="bi bi-file-earmark-pdf-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="View PDF"></i>-->
        									</a>
        								';    
            			}
            			if($status == '5' && ($revision_status == '0' || $revision_status == '5')){
            			   $order_submit_revision = '
                    								    <a href="'.base_url().index_page().'new_client/home/new_order_revision/'.$order['id'].'" >
                    								    <img class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/revision.png">
                    									    <!--<i class="bi bi-gear-fill fs-2 p-2 padding-right-5" data-toggle="tooltip" data-bs-placement="top" title="Submit Revision"></i>-->
                    								    </a>
                    								'; 
            			}
            			if($status == '5' && ($revision_status == '0' || $revision_status == '5')){
            			    $order_approve = '<span data-toggle="modal" data-target=".bs-example-modal-new">
            								    <i class="bi bi-pen-fill fs-2 p-2" data-toggle="tooltip" data-bs-placement="top" title="Approve ad" ></i>
            								</span>';
            			}
            			//order cancel
            			if($order['pdf'] == 'none'){
            			    if($order['crequest']!='0'){
            			        $order_cancel = '<div style="float:right">
                        							<form method="post" action="'.base_url().index_page().'new_client/home/order_cancel/'.$order['id'].'/pagination">
                        								<input type="submit" name="remove" value="" title="Accept Cancel Request"
                        								    style="background-image: url(\'https://adwitads.com/weborders/assets/new_client/img/Accept.png\');width: 25px; height: 25px; background-color:transparent;border:none;margin-right:0px"
                        								    onclick="return confirm(\'Are you sure you want to accept order cancellation ?\');">
                        							       <a href="'.base_url().index_page().'new_client/home/reject_v2/'.$order['id'].'" style="cursor:pointer; text-decoration: none;position:relative;top:-9px;">
            								                    <img title="Reject Cancel Request" class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/Cross.png">
            								                </a>
                        							</form>	 
    								                
    								                </div>
    							                ';    
            			    }elseif(!isset($order['rev_sold_jobs_id']) && $order['status'] != '5' && $order['cancel'] == '0'){
            			        $order_cancel = '
                    								<span class="dropdown text-grey">
                    								
                    								    <img title="Cancel Order" data-toggle="dropdown" id="view" class="action-img" src="https://adwitads.com/weborders/assets/new_client/img/Cancel.png">
                    							
                    										<div class="dropdown-menu file_li padding-10">  							 
                    											<p class="margin-bottom-5">Are you sure you want to cancel the order?</p>
                    											<div class="row margin-0">
                    												<div class="col-xs-6 padding-right-5 padding-left-0">
                    													<form method="post" action="'.base_url().index_page().'new_client/home/order_cancel/'.$order['id'].'">
                    														<button type="submit" name="remove" id="remove" class="btn btn-danger btn-xs padding-5 padding-horizontal-20 margin-right-5 btn-block">Yes</button>
                    													</form>
                    												</div>	
                    												<div class="col-xs-6 padding-left-5 padding-right-0">
                    													<button class="btn btn-blue btn-xs padding-5 padding-horizontal-20 btn-block">No</button>
                    												</div>
                    										</div>
                    								</span>
                    							';    
            			    }
            			}
            			
            			$order_action = $order_detail_view.$order_additional_attachment.$order_question_answer.$order_view_pdf.$order_submit_revision.$order_approve.$order_cancel;
            			$sub_array[] = $order_action;	//order Action
        				//Order Action END
        				
            			$data[] = $sub_array;
        			}
    			}
			}
			$output = array(
							"draw"    => intval($_GET["draw"]),
							"recordsTotal"  => $total_rows,
							"recordsFiltered" => $filtered_rows,
							"data"    => $data
						   );
			echo json_encode($output);
			
		}
	}
	
	public function adrep_team_orders_status()
	{
	    if(isset($_POST['team_orders_status']))
		{
		    $status = $_POST['team_orders_status'];
			$post = array('team_orders' => $status );
			$this->db->where('id', $this->session->userdata('ncId'));
			$this->db->update('adreps', $post);
			echo $status;
		}  
	}
//pagination END
	public function waukesha_preorder_update($order_id = '')
	{
	    $order_detail = $this->db->query("SELECT `id` FROM `orders` WHERE `id`='$order_id'")->row_array();
	    if(isset($order_detail['id'])){
	        if(isset($_POST['title'])){
        	    $column = $_POST['title'];
                $value = $_POST['value'];
                if($column == 'publish_date'){
                    $order_post = array('publish_date' => $value );
			        $this->db->where('id', $order_id);
			        $this->db->update('orders', $order_post);
			        
                    $post = array('run_date' => date('m/d/y', strtotime($value)) );
			        $this->db->where('adwit_id', $order_id);
			        $this->db->update('preorders_waukesha', $post);
			        
                }else{
                    $post = array($column => $value );
			        $this->db->where('adwit_id', $order_id);
			        $this->db->update('preorders_waukesha', $post);
                }
			    echo $column." Updated";
        	}else{
        	   echo "no post";
        	} 
	    }
	}
	
	public function order_detail($order_id='', $num = '1')
	{
	        //pagination
    		$rowsPerPage = 10;
    		$offset = ($num - 1) * $rowsPerPage;
    		$adrep_id = $this->session->userdata('ncId');
    		$client = $this->db->get_where('adreps',array('id' => $adrep_id))->result_array();
    		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
    		$data['publication'] = $publication;
    		$publication_id = $client[0]['publication_id'];
    		$data['client'] = $client; $data['pre_next'] = '1';
    		$data['advance'] = 'advance';
    		$keyword = $from = $to = $status_id = $team_adrep_id = $project_id = $ad_type = NULL;
    		if(isset($order_id)){ //search
    				$keyword = $order_id;
    				
    				if($client[0]['team_orders']=='1' ){
    					$q = "SELECT orders.* FROM `orders` WHERE orders.publication_id = '$publication_id'";
    					$q .= " AND (orders.id = '".$this->db->escape_like_str($keyword)."') ";
    				}else{
    					$q = "SELECT orders.* FROM `orders` WHERE orders.adrep_id = '".$this->session->userdata('ncId')."'";
    					$q .= " AND (orders.id = '".$this->db->escape_like_str($keyword)."') ";
    				}
    				
    		}
    		//echo $q;
    			$data['order_count'] = $this->db->query("$q")->num_rows();
    			if($client[0]['team_orders']=='1' ){
    				$tl_orders = $this->db->query("$q ORDER BY orders.activity_time DESC LIMIT $offset, $rowsPerPage;")->result_array();
    			}else{
    				$orders = $this->db->query("$q ORDER BY orders.activity_time DESC LIMIT $offset, $rowsPerPage;")->result_array();
    			}
    			
    			if(isset($tl_orders[0]['id'])){
    				$data['tl_orders'] = $tl_orders;
    				$data['num'] = $num;
    				$data['rowsPerPage'] = $rowsPerPage;
    				$data['offset'] = $offset;
    			}else{
    				$data['orders'] = $orders;
    				$data['num'] = $num;
    				$data['rowsPerPage'] = $rowsPerPage;
    				$data['offset'] = $offset;
    			}
    	$data['keyword'] = $keyword; $data['project_id'] = $project_id; $data['from'] = $from; $data['to'] = $to; $data['team_adrep_id'] = $team_adrep_id; $data['status'] = $status_id; $data['ad_type'] = $ad_type;		
        $this->load->view('new_client/dashboard',$data);		
	}
    
    public function fetch_advertiser()
    {
        $adrep_id = $this->session->userdata('ncId');
		$adrep_detail = $this->db->query("SELECT *  FROM `adreps` WHERE `id` = '$adrep_id'")->row_array();
		$publication_id = $adrep_detail['publication_id'];
        if(isset($_POST['name'])){
            $key = $_POST['name'];
			if($adrep_detail['team_orders'] == '1'){
				$query = $this->db->query("SELECT * FROM `advertiser` WHERE ( `fullname` LIKE '$key%') AND `publication_id` = '$publication_id' ORDER BY `fullname` ASC"); 
			}else{
				$query = $this->db->query("SELECT * FROM `advertiser` WHERE ( `fullname` LIKE '$key%') AND `adrep_id` = '$adrep_id' ORDER BY `fullname` ASC"); 
			}
            
            if($query->num_rows() > 0){
			   foreach($query->result_array() as $row){
			       $output[] = $row["fullname"];
				/*	$output[] = array(
					 'name'  => $row["fullname"]
					);*/
			   }
			   echo json_encode($output);
		  }
        }
    }
    /****************** Advertiser List functions ************************/
    public function advertiser_list()
    {
        $this->load->view('new_client/advertiser_list');
    }
    
    public function advertiser_list_fetch()
    {
        $adrep_id = $this->session->userdata('ncId');
        $query = "SELECT advertiser.advertiser_id, advertiser.fullname, advertiser.email, advertiser.phone_number, advertiser_category.category FROM `advertiser` 
                    LEFT JOIN `advertiser_category` ON advertiser_category.id = advertiser.category
                    WHERE advertiser.adrep_id = $adrep_id "; 
        
		//search or Filter
			if(isset($_POST['search']['value']) && !empty($_POST['search']['value'])){
			    $query .= " AND (";
			    $query .= 'advertiser.fullname LIKE "%'.$_POST["search"]["value"].'%"';

				$query .= ' OR advertiser.email LIKE "%'.$_POST["search"]["value"].'%"';

				$query .= ' OR advertiser.phone_number LIKE "%'.$_POST["search"]["value"].'%"';
				
				$query .= ' OR advertiser.category LIKE "%'.$_POST["search"]["value"].'%"';
				$query .= ") ";
			}
		//ORDER BY
			$order_column = array("fullname", "email", "phone_number", "category");
			if(isset($_POST['order'])){
				$query .= ' ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$query .= ' ORDER BY advertiser.fullname';
			}	
		$filtered_rows = $this->db->query($query)->num_rows();
		$extra_query = '';
		if($_POST['length'] != -1){
			$extra_query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$query .= $extra_query;
		//echo $query;	
		$fetch_data = $this->db->query("$query")->result_array();
		$total_rows = $this->db->query($query)->num_rows();
		$data = array();
		foreach($fetch_data as $row)
        {
            $edit_delete = '<span onclick="editAdvertiser(' . $row['advertiser_id'] . ')" style="cursor: pointer;text-decoration: underline; color: #3366cc;">Edit</span>| <span id="advertiserDelete" style="cursor: pointer;" data-id="'.$row['advertiser_id'].'">Delete</span>';
            $sub_array = array();
            $sub_array[] = $row['fullname'];
            $sub_array[] = $row['email'];
            $sub_array[] = $row['category'];
            $sub_array[] = $row['phone_number'];
            $sub_array[] = $edit_delete;
            $data[] = $sub_array;
        }
        $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $total_rows,  
                "recordsFiltered"   =>     $filtered_rows,  
                "data"              =>     $data  
        );  
        echo json_encode($output); 
    }
    
    public function advertiser_add($advertiserId = '0')
    {
        $data['hi'] = 'hello';
        $response_array=array();
	    $response_array['response_status']="failed";
	    $response_array['message']="Something went worng Please try again!";
	    
        $advertiser = $this->db->query("SELECT * FROM `advertiser` WHERE `advertiser_id` = $advertiserId ")->row_array(); 
        if(isset($advertiser['advertiser_id'])){
            $data['advertiser']  =   $advertiser;
        }
        
        if(isset($_POST['edit']) && isset($_POST['advertiser_name']) && !empty($_POST['advertiser_name'])){
            $post = array('fullname' => $_POST['advertiser_name'], 
                            'email' => $_POST['emailId'], 
                            'phone_number' => $_POST['phoneNumber'],
                            'category' => $_POST['category']
						); 
			$this->db->where('advertiser_id', $_POST['advertiser_id']);
			$this->db->update('advertiser', $post);
			$response_array['response_status']="success";
	        $response_array['message']="Advertiser Entry Updated..";
        }
        
        if(isset($_POST['new']) && isset($_POST['advertiser_name']) && !empty($_POST['advertiser_name'])){
            $adrep_id = $this->session->userdata('ncId');
		    $adrep_detail = $this->db->query("SELECT *  FROM `adreps` WHERE `id` = '$adrep_id'")->row_array();
		    $publication_id = $adrep_detail['publication_id'];
            $post = array('fullname' => $_POST['advertiser_name'], 
                            'email' => $_POST['emailId'], 
                            'phone_number' => $_POST['phoneNumber'],
                            'adrep_id' => $adrep_id, 
							'publication_id' => $publication_id,
							'category' => $_POST['category'],
							'status' => '1'
						);  
            $this->db->insert('advertiser', $post);					
			$id =  $this->db->insert_id();
			if($id){
			    $response_array['response_status']="success";
	            $response_array['message']="New Advertiser Added..";
			}
        }
        echo json_encode($response_array);
    }
    public function edit_advertiser(){
	   $advertiserId = $this->input->post('advertiser_id'); 
	   $advertiser = $this->db->query("SELECT * FROM `advertiser` WHERE `advertiser_id` = $advertiserId ")->row_array(); 
        if(isset($advertiser['advertiser_id'])){
            $data['advertiser']  =  $advertiser;
        }
	    $this->load->view('new_client/advertiser_add_new',$data); 
	}
    
    public function advertiser_delete()
    {
        if(isset($_POST['advertiserId'])){
           $advertiserId =  $_POST['advertiserId']; 
           $this->db->query("DELETE FROM `advertiser` WHERE `advertiser_id`= '".$advertiserId."'");
           echo 'Advertiser Deleted..';
        }
    }
    /****************** END Advertiser List functions ************************/
}