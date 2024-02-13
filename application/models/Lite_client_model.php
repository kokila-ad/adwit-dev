<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lite_client_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database('default', TRUE);
		$this->load->library('session');
    }
	
	public function customer_free_credit_details()
	{
		return $this->db->get_where('lite_credits_added',array('uid'=>$this->session->userdata('lcId'), 'credits_type'=>'1', 'is_active'=>'1'))->result_array();
	}
	
	public function customer_paid_credit_details()
	{
		return $this->db->get_where('lite_credits_added',array('uid'=>$this->session->userdata('lcId'), 'credits_type'=>'2', 'is_active'=>'1'))->result_array();
	}
	
    public function order_insert($ad_credits)
	{
		//$ad_credits = $ad_credits;
		/*$days = $_POST['date_needed'];
		$date_needed = date('Y-m-d', strtotime(' +'.$days.' day'));//echo $date_needed;
		*/
		if(!empty($_POST['date_needed'])){ 
			$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
		} else {
			$date_needed = '0000-00-00';
		}
						
		if(empty($_POST['rush'])){ $_POST['rush']='0'; }
		$advertiser = preg_replace('/[^A-Za-z0-9]/','',$_POST['advertiser_name']);
		$job_number = preg_replace('/[^A-Za-z0-9]/','',$_POST['job_no']);
				
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->row_array();
		$data2 = array(
						'adrep_id' 						=> $this->session->userdata('lcId'),
						'publication_id' 				=> $publication['id'],
						'group_id' 						=> $publication['group_id'],
						'help_desk' 					=> $publication['help_desk'],
						'advertiser_name' 				=> $advertiser,
						'job_no' 						=> $job_number,
						'size_inches' 					=> $_POST['width'] * $_POST['height'],
						'width'     					=> $_POST['width'],
						'height'    					=> $_POST['height'],
						'print_ad_type'    				=> $_POST['print_ad_type'],
						//'date_needed' 					=> $date_needed,
						'credits' 						=> $ad_credits,
						'copy_content_description' 		=> $_POST['copy_content_description'],
						'notes' 						=> $_POST['notes'],
						'rush'							=> $_POST['rush'],
						'date_needed' 					=> $date_needed,
						//'publish_date' 					=> $publish_date,
						'publication_name' 				=> $_POST['publication_name'],
						'font_preferences' 				=> $_POST['font_preferences'],
						'color_preferences' 			=> $_POST['color_preferences'],
						'job_instruction' 				=> $_POST['job_instruction'],
						'art_work' 						=> $_POST['art_work'],
						'status'						=> '0', //order status waiting for confirmation
						'order_type_id'					=>'2'
					  );
		$this->db->insert('orders',$data2);					
		$order_id =  $this->db->insert_id();
		if($order_id){
			if($publication['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication['id'],
						'order_id'=> $order_id,
						'job_no' => $job_number,
						'club_id'=> $publication['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
		}
		return $order_id;
	}
	
	public function pickup_order_insert($ad_credits, $orderid)
	{
		if(!empty($_POST['date_needed'])){ 
			$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
		} else {
			$date_needed = '0000-00-00';
		}
		
		//if(empty($_POST['rush'])){ $_POST['rush']='0'; }
		$advertiser = preg_replace('/[^A-Za-z0-9]/','',$_POST['advertiser_name']);
		$job_number = preg_replace('/[^A-Za-z0-9]/','',$_POST['job_no']);
				
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->row_array();
		$publication = $this->db->get_where('publications',array('id' => $client['publication_id']))->row_array();
		$data2 = array(
						'adrep_id' 						=> $this->session->userdata('lcId'),
						'publication_id' 				=> $publication['id'],
						'group_id' 						=> $publication['group_id'],
						'help_desk' 					=> $publication['help_desk'],
						'advertiser_name' 				=> $advertiser,
						'job_no' 						=> $job_number,
						'size_inches' 					=> $_POST['width'] * $_POST['height'],
						'width'     					=> $_POST['width'],
						'height'    					=> $_POST['height'],
						'print_ad_type'    				=> $_POST['print_ad_type'],
						'credits' 						=> $ad_credits,
						'copy_content_description' 		=> $_POST['copy_content_description'],
						'notes' 						=> $_POST['notes'],
						'date_needed' 					=> $date_needed,
						//'rush'							=> $_POST['rush'],
						//'publish_date' 					=> $_POST['publish_date'],
						//'publication_name' 				=> $_POST['publication_name'],
						//'font_preferences' 				=> $_POST['font_preferences'],
						//'color_preferences' 				=> $_POST['color_preferences'],
						//'job_instruction' 				=> $_POST['job_instruction'],
						//'art_work' 						=> $_POST['art_work'],
						'status'						=> '0',
						'order_type_id'					=> '2',
						'pickup_adno' 					=> $orderid,
					  );
		$this->db->insert('orders',$data2);					
		$order_id =  $this->db->insert_id();
		if($order_id){
			if($publication['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication['id'],
						'order_id'=> $order_id,
						'job_no' => $job_number,
						'club_id'=> $publication['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
		}
		return $order_id;
	}
	
	public function online_order_insert($ad_credits)
	{
		if(!empty($_POST['date_needed'])){ 
			$date_needed = date('Y-m-d',strtotime($_POST['date_needed']));
		} else {
			$date_needed = '0000-00-00';
		}
		
		if(!empty($_POST['publish_date'])){ 
			$publish_date = date('Y-m-d',strtotime($_POST['publish_date']));
		} else {
			$publish_date = date('Y-m-d', strtotime(' +1 day')); 
		}
		
		if(empty($_POST['rush'])){ $_POST['rush']='0'; }
		$advertiser = preg_replace('/[^A-Za-z0-9]/','',$_POST['advertiser_name']);
		$job_number = preg_replace('/[^A-Za-z0-9]/','',$_POST['job_no']);
				
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->row_array();
		$data2 = array(
						'adrep_id' 						=> $this->session->userdata('lcId'),
						'publication_id' 				=> $publication['id'],
						'group_id' 						=> $publication['group_id'],
						'help_desk' 					=> $publication['help_desk'],
						'advertiser_name' 				=> $advertiser,
						'job_no' 						=> $job_number,
						'maxium_file_size' 			=> $_POST['maxium_file_size'],
						'pixel_size' 					=> $_POST['pixel_size'],
						'custom_width'     				=> $_POST['custom_width'],
						'custom_height'    				=> $_POST['custom_height'],
						'ad_format'    					=> $_POST['ad_format'],
						'web_ad_type'    				=> $_POST['web_ad_type'],
						'credits' 						=> $ad_credits,
						'copy_content_description' 		=> $_POST['copy_content_description'],
						'notes' 						=> $_POST['notes'],
						'rush'							=> $_POST['rush'],
						'date_needed' 					=> $date_needed,
						'publish_date' 					=> $publish_date,
						'publication_name' 				=> $_POST['publication_name'],
						'font_preferences' 				=> $_POST['font_preferences'],
						'color_preferences' 			=> $_POST['color_preferences'],
						'job_instruction' 				=> $_POST['job_instruction'],
						'art_work' 						=> $_POST['art_work'],
						'status'						=> '0',
						'order_type_id'					=>'1'
					  );
		$this->db->insert('orders',$data2);					
		$order_id =  $this->db->insert_id();
		if($order_id){
			if($publication['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication['id'],
						'order_id'=> $order_id,
						'job_no' => $job_number,
						'club_id'=> $publication['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
		}
		/*if($order_id){
			return $order_id;
		}else{
			$this->session->set_flashdata("message", $this->db->_error_message());
			redirect("lite/home/online_ad");
		}*/
		return $order_id;
	}
		
	public function pickup_online_order_insert($ad_credits, $orderid)
	{
		//$ad_credits = round($ad_credits,0);
		
		//if(empty($_POST['rush'])){ $_POST['rush']='0'; }
		$advertiser = preg_replace('/[^A-Za-z0-9]/','',$_POST['advertiser_name']);
		$job_number = preg_replace('/[^A-Za-z0-9]/','',$_POST['job_no']);
				
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('lcId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->row_array();
		$data2 = array(
						'adrep_id' 						=> $this->session->userdata('lcId'),
						'publication_id' 				=> $publication['id'],
						'group_id' 						=> $publication['group_id'],
						'help_desk' 					=> $publication['help_desk'],
						'advertiser_name' 				=> $advertiser,
						'job_no' 						=> $job_number,
						'maxium_file_size' 				=> $_POST['maximum_file_size'],
						'pixel_size' 					=> $_POST['pixel_size'],
						'custom_width'     				=> $_POST['custom_width'],
						'custom_height'    				=> $_POST['custom_height'],
						'ad_format'    					=> $_POST['ad_format'],
						'web_ad_type'    				=> $_POST['web_ad_type'],
						'credits' 						=> $ad_credits,
						'copy_content_description' 		=> $_POST['copy_content_description'],
						'notes' 						=> $_POST['notes'],
						//'date_needed' 					=> $date_needed,
						//'rush'							=> $_POST['rush'],
						//'publish_date' 					=> $publish_date,
						//'publication_name' 				=> $_POST['publication_name'],
						//'font_preferences' 				=> $_POST['font_preferences'],
						//'color_preferences' 				=> $_POST['color_preferences'],
						//'job_instruction' 				=> $_POST['job_instruction'],
						//'art_work' 						=> $_POST['art_work'],
						'status'						=> '0',
						'order_type_id'					=> '1',
						'pickup_adno' 					=> $orderid,
					  );
		$this->db->insert('orders',$data2);					
		$order_id =  $this->db->insert_id();
		if($order_id){
			if($publication['live_tracker']=='1'){	//Live_tracker updation
						$tracker_data = array(
						'pub_id'=> $publication['id'],
						'order_id'=> $order_id,
						'job_no' => $job_number,
						'club_id'=> $publication['club_id'],
						'status' => '1'
						);
						$this->db->insert('live_orders', $tracker_data);
					}
		}
		return $order_id;
	}
	
	public function price_per_credit()
	{
		//$id = $this->session->userdata('daId');
		return $this->db->get('lite_price_per_credit')->result_array();
	}

	public function customer_buy_details()
	{
		//$id = $this->session->userdata('daId');
		return $this->db->get('lite_package')->result_array();
	}
	
	public function credit_calc()
	{
		$total_credit = 0;
		//lite_credit_sqinch
		$sqinches = $_POST['width'] * $_POST['height'];
		
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
		
		//lite_color_preference
		$lite_color_preference = $this->db->get_where('lite_color_preference',array('id'=>$_POST['print_ad_type']))->row_array();
		//$color_preference_credit = $lite_color_preference['credits'];
		$color_preference_credit = 0;
		//lite_credit_date
		$lite_credit_date = $this->db->get_where('lite_credit_date', array('num_days' => $_POST['date_needed']))->row_array();
		//$date_credit = $lite_credit_date['credits'];
		$date_credit = 0;
		
		$total_credit = $sqinches_credits + $color_preference_credit + $date_credit;
		//$total_credit = $sqinches_credits + $color_preference_credit;
		$total_credit = $total_credit;
		return($total_credit);
	}
	
	public function online_credit_calc()
	{
		$total_credit = 0;
		$ad_format = $_POST['ad_format'];
		$web_ad_type = $_POST['web_ad_type'];
		$online_format = $this->db->get_where('lite_online_format', array('id' => $ad_format))->row_array();
		if(isset($online_format['id'])){
			if($web_ad_type == 'Static'){
				$total_credit = $online_format['s_credits'];
			}elseif($web_ad_type == 'Animated'){
				$total_credit = $online_format['a_credits'];
			}
		}
		return($total_credit);
	}
	
	public function pick_up($pick_num = "")
	{
		return $this->db->query("Select * from `orders` where `id`= '".$pick_num."'")->result_array();
	}
	
	public function assign_paid_credits($param)
	{
		//Add paid credits
			$paid_credits = $param['credits'];
			$amount = $param['amount'];
			$expiry = '0';
			$post = array(	'uid'=> $this->session->userdata('lcId'), 
							'credits'=> $paid_credits, 
							'price'=> $amount,
							'credits_type'=> '2',	//paid
							'expiry'=> $expiry
						);
			$this->db->insert('lite_credits_added', $post);
			$credits_added_id = $this->db->insert_id();
		//lite_mycredits_history
			if($credits_added_id){
				$data = array(	'uid'=> $this->session->userdata('lcId'), 
								'credits_added_id'=> $credits_added_id,
								'credits_debited'=> $paid_credits,
								'purpose' => '2' 	//paid
							);	
				$this->db->insert('lite_mycredits_history', $data);
				return $this->db->insert_id();
			}
	}
	
	public function assign_free_credits()
	{
		//Add free credits
			$free_credits = $this->db->get('lite_free_credits')->row_array();
			$today = date("Y-m-d");
			//$num_days = $free_credits['num_days'];
			//$expiry = date( "Y-m-d", strtotime( "$today +$num_days day" ) );
			$expiry = date('Y-m-d', strtotime('next sunday'));
			$post = array(	'uid'=> $this->session->userdata('lcId'), 
							'credits'=> $free_credits['credits'], 
							'price'=> '0',
							'credits_type'=> '1',
							'expiry'=> $expiry
						);
			$this->db->insert('lite_credits_added', $post);
			$credits_added_id = $this->db->insert_id();
			//lite_mycredits_history
			if($credits_added_id){
				$data = array(	'uid'=> $this->session->userdata('lcId'), 
								'credits_added_id'=> $credits_added_id,
								'credits_debited'=> $free_credits['credits'],
								'purpose' => '1');
				$this->db->insert('lite_mycredits_history', $data);
			}
	}
	
	public function expiry_check()
	{
		$uid = $this->session->userdata('lcId');
		$today = date('Y-m-d');
		$credits_list = $this->db->query("SELECT * FROM `lite_credits_added` WHERE `uid` = '$uid' AND `credits_type`='1' AND `is_active` = '1' AND `expiry` < '$today' ")->row_array(); //only one freecredits active at a time & expiration applied only for freecredits
		if($credits_list){
			//mark as inactive
				$data = array('is_active' => '0');
				$this->db->where('id', $credits_list['id']);
				$this->db->update('lite_credits_added', $data);
			// last free credits added
			$last_free_credits = $this->db->query("SELECT * FROM `lite_mycredits_history` WHERE `uid` = $uid AND `credits_added_id` = ".$credits_list['id'])->row_array();
			
			$lite_mycredits_history = $this->db->query("SELECT SUM(`credits_credited`) FROM `lite_mycredits_history` WHERE `id` > '".$last_free_credits['id']."' AND `uid` = '$uid' ")->row_array();
			
			$total_credits_credited = $lite_mycredits_history['SUM(`credits_credited`)'];
			$balance_credit = $credits_list['credits'] - $total_credits_credited ;
			
			if($balance_credit <= 0){
				$credits_credited = '0';
			}else{
				$credits_credited = $balance_credit;
			}
			//credits update lite_mycredits_history
				$post = array('uid' => $this->session->userdata('lcId'), 'credits_credited' => $credits_credited, 'purpose' => '4');
				$this->db->insert('lite_mycredits_history', $post);
			//assign free credits
				$this->assign_free_credits();
		}
	}
    
	public function check_credits()
	{
		$uid = $this->session->userdata('lcId');
		$credits_details = $this->db->query("SELECT SUM(`credits_debited`), SUM(`credits_credited`) FROM `lite_mycredits_history` WHERE `uid` = '$uid'")->row_array();
		
		$debit_value = $credits_details['SUM(`credits_debited`)'];
        $debit = $debit_value !== null ? round($debit_value, 1) : null;
        
		$credit_value = $credits_details['SUM(`credits_credited`)'];
        $credit = $credit_value !== null ? round($credit_value, 1) : null;
                
		$balance_credits = ($debit !== null && $credit !== null) ? ($debit - $credit) : null;
        
		 return $balance_credits !== null ? round($balance_credits, 1) : null;	
	}
	
	public function order_check($order_id)
	{
		return $this->db->get_where('orders',array('id'=> $order_id, 'adrep_id'=>$this->session->userdata('lcId')))->result_array();
	}
	
	public function order_check_preorder($order_id)
	{
		return $this->db->get_where('orders',array('id'=> $order_id, 'adrep_id'=>$this->session->userdata('lcId'), 'status'=>'0' ))->result_array();
	}
	
	public function view_check($id='')
	{
		if($id!=''){
			return $this->db->query("Select * from `orders` where `id`= '$id';")->result_array();
		}
	}
	
	public function dashboard_view($num_days, $order_id)
	{
		if($order_id != ''){
			$lcId = $this->session->userdata('lcId');
			return $this->db->query("SELECT * from `orders` WHERE `adrep_id`= '$lcId' AND `id`='$order_id'")->result_array();
		}else{
			$from = date('Y-m-d 00:00:00', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
			$to= date('Y-m-d H:i:s');
			$lcId = $this->session->userdata('lcId');
			return $this->db->query("SELECT * from `orders` WHERE `adrep_id`= '$lcId' AND (`created_on` BETWEEN '$from' AND '$to') ORDER BY `id` DESC")->result_array();
		}
	}
	
	public function search_details()
	{
	   $id = $_POST['id'];
	   return  $this->db->query("Select * from `orders` where `adrep_id`='".$this->session->userdata('lcId')."' AND (`id`='$id' OR `job_no`='$id');")->result_array();
	}
	
	public function advance_details()
	{
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$from = date('Y-m-d', strtotime($_POST['from']));
			$to = date('Y-m-d', strtotime($_POST['to']));
			return $this->db->query("SELECT * FROM `orders` WHERE `job_no`='$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `status`='1'")->result_array();
		}
	}
	
	public function search_view()
	{
		return $this->db->query("Select * from `orders` where `id`='".$id."';")->result_array();
	}
	
	public function profile_view()
	{
		$id = $this->session->userdata('lcId');
		return $this->db->query("Select * from `adreps` where `id` = '$id' AND `is_active`='1';")->result_array();
	}
	
	public function que_details($order_id='')
	{
		$post = array('uid'=> $this->session->userdata('lcId'),
			'question' => $_POST['question'], 
			'que_timestamp' => $timestamp
			);
			return $this->db->insert('lite_QA',$post);
	}
	
	public function rev_details($order_id='')
	{
		$post = array('order_id' => $order_id,
			'reason' => $_POST['reason'],
			);
			return $this->db->insert('lite_revision',$post);
	}
	
	public function change_password()
	{
		$query = $this->db->get_where('adreps',array('id'=>$this->session->userdata('lcId'), 'password'=>MD5($this->input->post('current_password')), 'is_active'=>'1'));
		if($query->num_rows() > 0){
			$this->db->query("Update adreps set password='".md5($this->input->post('new_password'))."' where (id='".$this->session->userdata('lcId')."' and password='".md5($this->input->post('current_password'))."' and is_active='1'); ");
			if($this->db->affected_rows()){
				$this->session->set_flashdata('pwd_message','<p style="color:#FCA13F;">Your password has been changed successfully!</p>');
			}else{
				$this->session->set_flashdata('pwd_message',"<p style='color:#FCA13F;'>Invalid current password!</p>");
			}
			redirect('customer/home/profile');
		}else{
			$this->session->set_flashdata('pwd_message','<p style="color:#FCA13F;">Wrong Password Provided!!</p>');
			redirect('customer/home/profile');
		}
	}
	
	public function mycredits_history()
	{
		return $this->db->get_where('lite_mycredits_history', array('uid' => $this->session->userdata('lcId')))->result_array();
	}

	public function credit_calculator()
	{
		$total_credit = 0;
		//lite_credit_sqinch
		$sqinches = $_POST['width'] * $_POST['height'];
		
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
		return $sqinches_credits;
	}
}
	
?>