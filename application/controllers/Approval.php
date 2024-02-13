<?php

class Approval extends CI_Controller {

	public function index()
	{
		redirect(base_url());
	}
	
	public function home($order_id = 0)
	{
		$order_id = $this->uencrypter->decode($order_id);
		$order = $this->db->get_where('orders',array('id' => $order_id, 'status'=>'5', 'pdf !=' => 'none'))->result_array();
		$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		if(isset($order[0]['id'])){
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order_id' ORDER BY `id` DESC LIMIT 1")->row_array();
			if($orders_rev){
				$filename = $orders_rev['pdf_path'];
				$rev_id = $orders_rev['id'];
				$rev_approve = $orders_rev['approve'];
			}else{
				$filename = $order[0]['pdf'];
				if(!file_exists($filename)){
					$this->load->helper('directory');
					$map = directory_map('pdf_uploads/'.$order_id.'/');
					if($map){ foreach($map as $file){ $filename = 'pdf_uploads/'.$order_id.'/'.$file; }}
				}
			}
				if(isset($_POST['submit_form'])){
					$approve_details = $this->db->get_where('send_for_approval', array('order_id' => $order_id, 'approve' => '0'))->row_array();
					if(!isset($approve_details['id'])){
						$this->session->set_flashdata('message',"Already Approved ");
						redirect('approval/home/'.$this->uencrypter->encode($order_id));
					}
					
					$client = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->row_array();
					$publication = $this->db->query("Select * from publications where id='".$order[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$jname= $order[0]['job_no'];
						if($_POST['submit_form'] == 'decline'){ //decline mailer data
							$dataa['from'] = 'do_not_reply@adwitads.com';
							
							$dataa['from_display'] = 'Declined Ad';
							
							$dataa['replyTo'] = $design_team[0]['email_id'];

							$dataa['replyTo_display'] = 'Do Not Reply';
							
							$dataa['subject'] =  'Declined Ad #'.$approve_details['ad_num'] ;
							
							$dataa['body'] = 'Hi '.$client['first_name'].' '.$client['last_name'].',<br/><br/>Artwork Declined Reason : '.$_POST['decline_reason'].'.' ;
							
							$dataa['recipient'] = $client['email_id'];
							//$dataa['Cc'] = $client['email_id'];
						}else{	//approve mailer data		
							$dataa['from'] = 'do_not_reply@adwitads.com';
							
							$dataa['from_display'] = 'Approved Ad';
							
							$dataa['replyTo'] = $design_team[0]['email_id'];

							$dataa['replyTo_display'] = 'Do Not Reply';
							
							$dataa['subject'] =  'Approved Ad #'.$approve_details['ad_num'] ;
							
							$dataa['body'] = 'Hi '.$client['first_name'].' '.$client['last_name'].',<br/><br/>Please find approved Hi-Res PDF For Order ID: '.$approve_details['ad_num'].' & Unique Job Name: '.$jname.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
							
							$dataa['recipient'] = 'advertising@dailynews.vi';
							$dataa['Cc'] = $client['email_id'];
						}	
							$dataa['filename'] = $filename;
							if($approve_details['ad_num'] != ''){ 
								$dataa['fname'] = $approve_details['ad_num'].'.pdf'; 
							}
							if(!$this->send_mail($dataa)){
								$this->session->set_flashdata('message',"Error sending Email");
								redirect('approval/home/'.$this->uencrypter->encode($order_id));
							}
					//decline update approval 
					if($_POST['submit_form'] == 'decline'){
						$post = array('decline_reason' => $_POST['decline_reason']);
						$this->db->where('id', $approve_details['id']);
						$this->db->update('send_for_approval', $post);	
						$this->session->set_flashdata('message',"Declined ".$order_id);
						redirect('approval/home/'.$this->uencrypter->encode($order_id));
					}
					//approve update approval 		
					if(isset($rev_approve) && $rev_approve == '0'){
						$post = array('approve'=>'1', 'status'=>'7');
						$this->db->where('id', $rev_id);
						$this->db->update('rev_sold_jobs', $post); 
					}elseif($order[0]['approve']=='0'){
						$post = array('approve'=>'1', 'status'=>'7');
						$this->db->where('id', $order[0]['id']);
						$this->db->update('orders', $post);
					}
						$post = array('approve'=>'1');
						$this->db->where('id', $approve_details['id']);
						$this->db->update('send_for_approval', $post);
						
					$this->session->set_flashdata('message',"Thank You For Approving Ad #".$approve_details['ad_num']);
					redirect('approval/home/'.$this->uencrypter->encode($order_id));
				}
			
			$data['order_id'] = $order[0]['id'];
			$data['pdf_file'] = $filename;
			$data['order']= $order[0];
			$this->load->view('new_client/approval_link', $data);
		}
	}
	
	public function send_mail($dataa) 
	{
       $this->load->library('MyMailer');
               
       $mail = new PHPMailer();
       $mail->SetFrom($dataa['from'], $dataa['from_display']);  
       $mail->AddReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
       $mail->Subject    = $dataa['subject'];  
       $mail->Body      = $dataa['body'];
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($dataa['recipient']);
	   if(isset($dataa['Cc'])){
		  $mail->AddCC($dataa['Cc']); 
	   }
	   
	   if(isset($dataa['filename']) && isset($dataa['fname'])){
			$mail->AddAttachment($dataa['filename'], $dataa['fname']); 
	   }elseif(isset($dataa['filename'])){
			$mail->AddAttachment($dataa['filename']);
	   }
	   
	   if(!$mail->Send())
               return false;
               else
               return true;
	}
}	
?>