<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Professional_Controller {

	public function index($error = '', $page = 1, $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('professional_client')){		
			$this->load->view('professional_edition/login',$data);
		}else{
			redirect('professional_edition/home');
		}
	}
	//registration
	public function registration()
	{
		if(!$this->session->userdata('professional_client')){		
			$this->load->view('professional_edition/register');
		}else{
			redirect('professional_edition/home');
		}
	}
	
	public function register()
	{
		if(!empty($_POST['publication']) && !empty($_POST['username']) && !empty($_POST['email_id']) && !empty($_POST['password']))
		{
			if($this->input->post('password') != $this->input->post('confirm_password')){
				$this->session->set_flashdata('message','<label style="color:red">The Confirm Password field does not match the Password field!</label>');
				redirect('professional_edition/login/registration');
			}
			$username = $this->input->post('username');
			$email_id = $this->input->post('email_id');
			$UserExists = $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$email_id."') ")->row_array();
			if(isset($UserExists['id'])){
				if($UserExists['is_active']=='0'){
					$this->send_reg_link($email_id, $UserExists['id'], '<label style="color:red">User Already Registered..!!</label>');
				}else{
					$this->session->set_flashdata('message','<label style="color:red">Username/EmailId Already Exists</label> <a style="text-decoration:underline" href='.base_url().index_page().'professional_edition/login>Click To Login </a>');
					redirect('professional_edition/login/registration');
				}
			}else{
				$post_pub = array('name'=>$this->input->post('publication'), 'is_active'=>'0');
				$this->db->insert('publications', $post_pub);
				$pId = $this->db->insert_id();
				if($pId){
					$this->addAdrep($pId);		
				}else{
					$this->session->set_flashdata('message','<label style="color:red">Unable to create Publication</label>');
					redirect('professional_edition/login/registration');
				}
			}
		}
	}
	
	/*function UserExists($username, $email_id)
	{
		return $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$email_id."') ")->num_rows();
	}*/
	
	function addAdrep($pId)
	{
		$publication = $this->db->get_where('publications',array('id' => $pId))->row_array();
		if(isset($publication['id'])){
			$post = array(	'publication_id' => $pId,
							'first_name' => $this->input->post('first_name'),
							'last_name'  => $this->input->post('last_name'),
							'username'   => $this->input->post('username'),
							'email_id'   => $this->input->post('email_id'),
							'password'   => md5($this->input->post('password')),
							'new_ui' 	 => '3',	//professional_edition
							'is_active'  => '0',
						);
			$this->db->insert('adreps', $post);
			$adrep_id = $this->db->insert_id();
			if($adrep_id){
				$this->send_reg_link($this->input->post('email_id'), $adrep_id);
			}else{
				$this->session->set_flashdata('message','<label style="color:red">Unable to create user</label>');
				redirect('professional_edition/login/registration');
			}
		}		
	}
	
	function send_reg_link($email, $adrep_id, $error='')
	{ 
			$mktime = time();
			$secret_key = $this->encrypt->encode($email.":".$mktime);
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $email));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'Account Activation';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'Account Activation';
			$data['subject'] = 'Account Activation - AdwitAds Professional';
			$data['recipient'] = $email;
			//$data['recipient'] = 'sudarshan@adwitads.com';
			$data['recipient_display'] = 'AdwitAds Professional';
			$data['headline'] = 'Hello!';
			//$data['footline'] = 'Thanks';
			//$data['p_one'] = 'Thank you for registering. Before we start your service you must click the button below or use the following copy paste link to Confirm Registration:';
            //$data['p_two'] = 'If you have not initiated this, please ignore this. The link will expire in 2 days.';
           
		   $data['p_three'] = '<a href="'.base_url().index_page().'professional_edition/login/activate/'.$secret_key.'" style="text-decoration:none;font-size:14px;background:#30a6c6;padding:8px 30px;border-radius:3px;color:white;outline:none;border:none;cursor:pointer;">Click Here</a>';
			
			//$data['p_four'] = '<a href="'.base_url().index_page().'professional_edition/login/activate/'.$secret_key.'" style="background-color: #3CBC8D;color: #fff;padding: 4px 10px;border-radius: 3px;border: 1px solid #3CBC8D;text-decoration: none;">Verify Now</a>';
						
			if($this->registration_mail($data) != true ){
				$post['email_error'] = "Unable to send activation link to $email";
			}
			$post['email'] = $email;
			$post['adrep_id'] = $adrep_id;
			$post['error'] = $error;
			$this->load->view('professional_edition/registration_msg', $post);
	}
	
	function resend_link($adrep_id){
		$adrep = $this->db->query("Select * from adreps where id='".$adrep_id."' and is_active='0' and is_deleted='0'")->row_array();
		if(isset($adrep['id'])){
			$this->send_reg_link($adrep['email_id'], $adrep['id']);
		}else{
			echo $this->index('The given URL is invalid or it might have expired!',2);
		}
	}
	
	public function activate($encrypted_key)
	{ 
		$secrets = preg_split('/[\s:]+/',$this->encrypt->decode($encrypted_key));
		$mktime = time();
		if($secrets[1] + 172800 > $mktime && $this->secretExists_reg($secrets[0],$encrypted_key)==1){			
			$email_id = $secrets[0];
			$this->db->update('adreps',array('encrypted_key' => '', 'is_active' => '1'),array('email_id' => $email_id, 'encrypted_key' => $encrypted_key));
			$this->session->set_flashdata("message","<p style='color:#3CBC8D;'>Congratulations! Your account has been activated successfully, Log in to continue.</p>");
			redirect('professional_edition/login/index');
		}else{
			$this->session->set_flashdata("message","The given URL is invalid or it might have expired!"); 
			redirect('professional_edition/login/index');
		}
	}
	
	function secretExists_reg($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."';")->num_rows();
	}
	
	//login
	public function doIt()
	{		
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1){
			if($this->input->post('remember')!='remember'){
				$this->session->sess_expiration = 7200;
			}
			$result = $this->db->get_where('adreps', array('username' => $this->input->post('username')))->row_array();
			$userdata = array('professional_client' => $this->input->post('username'), 'pcId' => $result['id'], 'pcEmail' => $result['email_id']);
			$this->session->set_userdata($userdata);
			
			$this->index(); 
		}else{
			$this->index('Invalid user name or password!');
		}		
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and new_ui='3' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function reset()
	{
		$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'Do Not Reply';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'Do Not Reply';
			$data['subject'] = 'Reset password - AdwitAds Professional';
			$data['recipient'] = $this->input->post('email_id');
			$data['recipient_display'] = 'AdwitAds Professional';
			$data['headline'] = 'Hello!';
			$data['footline'] = 'Thanks';
			$data['p_one'] = 'We have received a reset password request for your account with adwitads.com. Kindly click on the following link to reset your password.'; 
			$data['p_two'] = 'If you have not initiated this request, please ignore this email. This link will be expired within 2 days.';
		
		if($this->emailIdExists($this->input->post('email_id'))) // New client
		{
			$secret_key = $this->encrypt->encode($this->input->post('email_id').":".time());
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
									
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'professional_edition/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->reset_password_emailer($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}else{
			$this->index('Invalid Email Id!',2);
		}
	}
	
	function emailIdExists($email_id)	//New client
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and new_ui='3' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function change($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/', $this->encrypt->decode($encrypted_key));
		if($secrets[1] + 172800 > time() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('professional_edition/reset',$data);
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function dochange($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/', $this->encrypt->decode($encrypted_key));
		if($secrets[1] + 172800 > time() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$this->db->update('adreps',array('encrypted_key' => '', 'password' => md5($this->input->post('new_password'))),array('email_id' => $secrets[0], 'encrypted_key' => $encrypted_key));
			$this->index('Your password has been changed successfully! You may login now.',1,'darkgreen');
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	public function shutdown()
	{
		$this->session->sess_destroy();
		redirect('');
	}
	/*
	public function send_mail($data) {
		$this->load->library('MyMailer');
		
        $mail = new PHPMailer();
        $mail->SetFrom($data['from'], $data['from_display']);  
        $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);
        $mail->Subject    = $data['subject'];  
        $mail->Body      = $this->load->view('e-template',$data, TRUE);
        $mail->AltBody    = "Unable to load text!";
        $mail->AddAddress($data['recipient'], $data['recipient_display']);

        if(!$mail->Send())
            return false;
        else 
            return true;
    }
	*/
	public function send_mail($data) 
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
		$this->email->reply_to($data['replyTo'],$data['replyTo_display']);
		$this->email->subject($data['subject']);  
		$this->email->message($this->load->view('e-template',$data, TRUE));
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		}
	}
	
	/*public function registration_mail($data) {
		$this->load->library('MyMailer');
		
        $mail = new PHPMailer();
        $mail->SetFrom($data['from'], $data['from_display']);  
        $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);
        $mail->Subject    = $data['subject'];  
        $mail->Body      = $this->load->view('confirm_registration_emailer',$data, TRUE);
        $mail->AltBody    = "Unable to load text!";
        $mail->AddAddress($data['recipient'], $data['recipient_display']);

        if(!$mail->Send())
            return false;
        else 
            return true;
    }
	*/
	public function registration_mail($data) 
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
		$this->email->reply_to($data['replyTo'],$data['replyTo_display']);
		$this->email->subject($data['subject']);  
		$this->email->message($this->load->view('confirm_registration_emailer',$data, TRUE));
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		}
	}
	/*
	public function reset_password_emailer($data) {
		$this->load->library('MyMailer');
		
        $mail = new PHPMailer();
        $mail->SetFrom($data['from'], $data['from_display']);  
        $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);
        $mail->Subject    = $data['subject'];  
        $mail->Body      = $this->load->view('reset_password_emailer',$data, TRUE);
        $mail->AltBody    = "Unable to load text!";
        $mail->AddAddress($data['recipient'], $data['recipient_display']);

        if(!$mail->Send())
            return false;
        else 
            return true;
    }
	*/
	public function reset_password_emailer($data) 
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
		$this->email->reply_to($data['replyTo'],$data['replyTo_display']);
		$this->email->subject($data['subject']);  
		$this->email->message($this->load->view('reset_password_emailer',$data, TRUE));
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		if(!$this->email->send()){
			return false;
		}else{
			return true;
		}
	}
}