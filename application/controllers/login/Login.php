<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller {

	public function index($username = '', $error = '', $page = 1, $color = 'darkred')
	{
		if($username) $data['username'] = $username;
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		$this->load->view('login/login',$data);
	}
	
	function userExists($username)
	{
		return $this->db->query("Select * from users where (username='".$username."' OR email_id='".$username."') and is_active='1'")->num_rows();
	}
	
	public function user_login_session($user_id='', $user_module=''){
		$post = array('user_id'=>$user_id, 'user_module'=>$user_module, 'ip'=>$_SERVER['REMOTE_ADDR'], 'browser'=>$_SERVER['HTTP_USER_AGENT']);
		$this->db->insert('users_login_session', $post);
	}
	
	public function doIt()
	{
		if(isset($_POST['username']) && !isset($_POST['password'])){
			if($this->userExists($this->input->post('username'))==1){
				$this->index($this->input->post('username')); 
			}else{
				$this->session->set_flashdata("message","Username/Email doesn't exists..!!");
				redirect('login/login/index');
			}
		}else{
			$username = $this->input->post('username');
			$userExists = $this->db->query("Select * from users where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			if(isset($userExists['id']) && $userExists['module']=='2' && $this->logExists('adreps', $this->input->post('username'), $this->input->post('password'))==1){	//client
			
				if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
				
				$result = $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
				if($result['new_ui'] == '1' ){ //new_client
					$userdata = array('new_client' => $this->input->post('username'), 'ncId' => $result['id'], 'ncEmail' => $result['email_id']);
					$this->session->set_userdata($userdata);
					$this->user_login_session($this->session->userdata('ncId'), 2);
					redirect('new_client/home');
				}elseif( $result['new_ui'] == '2' ){	//india_client
					$userdata = array('india_client' => $this->input->post('username'), 'icId' => $result['id'], 'icEmail' => $result['email_id']);
					$this->session->set_userdata($userdata);
					$this->user_login_session($this->session->userdata('icId'), 2);
					redirect('india_client/home');
				}elseif( $result['new_ui'] == '3' ){	//professional_client
					$userdata = array('professional_client' => $this->input->post('username'), 'pcId' => $result['id'], 'pcEmail' => $result['email_id']);
					$this->session->set_userdata($userdata);
					$this->user_login_session($this->session->userdata('pcId'), 2);
					redirect('professional_edition/home');
				}elseif( $result['new_ui'] == '4' ){	//retail_client
					$userdata = array('retail_client' => $this->input->post('username'), 'rcId' => $result['id'], 'rcEmail' => $result['email_id']);
					$this->session->set_userdata($userdata);
					$this->user_login_session($this->session->userdata('rcId'), 2);
					redirect('retail_edition/home');
				}else{	//client
					$userdata = array('client' => $this->input->post('username'), 'cId' => $result['id'], 'cEmail' => $result['email_id']);
					$this->session->set_userdata($userdata);
					$this->user_login_session($this->session->userdata('cId'), 2);
					redirect('client/home');
				}
				
			}elseif(isset($userExists['id']) && $userExists['module']=='1' && $this->logExists('admin_users', $this->input->post('username'), $this->input->post('password'))==1){	//redirect to admin
			
				if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
				
				$result = $this->db->query("Select * from admin_users where (username='".$username."' OR email_id='".$username."')")->result_array();
				$userdata = array('admin' => $this->input->post('username'), 'aId' => $result[0]['id'], 'aEmail' => $result[0]['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('aId'), 1);
				redirect('admin/home');
			}elseif(isset($userExists['id']) && $userExists['module']=='3' && $this->logExists('csr', $this->input->post('username'), $this->input->post('password'))==1){	//redirect to new csr
			
				if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
				
				$result = $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."')")->result_array();
				$userdata = array('csr' => $this->input->post('username'), 'sId' => $result[0]['id'], 'sEmail' => $result[0]['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('sId'), 3);
				redirect('new_csr/home');
				
			}elseif(isset($userExists['id']) && $userExists['module']=='6' && $this->logExists('art_director', $this->input->post('username'), $this->input->post('password'))==1){	//redirect to art_director
			
				if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
				
				$result = $this->db->query("Select * from art_director where (username='".$username."' OR email_id='".$username."')")->result_array();
				$userdata = array('art' => $this->input->post('username'), 'aId' => $result[0]['id'], 'aEmail' => $result[0]['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('aId'), 6);
				redirect('art-director/home');
				
			}elseif(isset($userExists['id']) && $userExists['module']=='4' && $this->logExists('designers', $this->input->post('username'), $this->input->post('password'))==1){ //redirect to new designer
			
			   if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
			   
				$result = $this->db->query("Select * from designers where (username='".$username."' OR email_id='".$username."')")->result_array();
			   $userdata = array('designer' => $this->input->post('username'), 'dId' => $result[0]['id'], 'dEmail' => $result[0]['email_id'], 'dLoc' => $result[0]['Join_location']);
			   $this->session->set_userdata($userdata);
			   $this->user_login_session($this->session->userdata('dId'), 4);
			   redirect('new_designer/home');
			   
		   }elseif(isset($userExists['id']) && $userExists['module']=='5' && $this->logExists('team_lead', $this->input->post('username'), $this->input->post('password'))==1){	//redirect to team_lead
			
				if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
				
				$result = $this->db->query("Select * from team_lead where (username='".$username."' OR email_id='".$username."')")->result_array();
				$userdata = array('team' => $this->input->post('username'), 'tId' => $result[0]['id'], 'tEmail' => $result[0]['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('tId'), 5);
				redirect('team-lead/home');
				
			}elseif(isset($userExists['id']) && $userExists['module']=='7' && $this->logExists('management', $this->input->post('username'), $this->input->post('password'))==1){	//redirect to management
			
				if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
				
				$result = $this->db->query("Select * from management where (username='".$username."' OR email_id='".$username."')")->result_array();
				$userdata = array('management' => $this->input->post('username'), 'mId' => $result[0]['id'], 'mEmail' => $result[0]['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('mId'), 7);
				redirect('management/home');
				
			}else{
				$this->index($this->input->post('username'), 'Invalid password!');
			}
		}
	}
	
	function logExists($user, $username, $password)
	{
		return $this->db->query("Select * from $user where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function reset()
	{
		$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'Do Not Reply';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'Do Not Reply';
			$data['subject'] = 'Reset password - adwitads.com';
			$data['recipient'] = $this->input->post('email_id');
			$data['recipient_display'] = 'Adwit Ads';
			$data['headline'] = 'Hello!';
			$data['footline'] = 'Thanks';
			$data['p_one'] = 'We have received a reset password request for your account with adwitads.com. Kindly click on the following link to reset your password.'; 
			$data['p_two'] = 'If you have not initiated this request, please ignore this email. This link will be expired within 2 days.';
		
		if($this->emailIdExists('adreps', $this->input->post('email_id'))) //client
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
									
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'client/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('','We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('','Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists('csr', $this->input->post('email_id')))	//csr
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('csr',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'csr/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('','We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('','Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists('designers', $this->input->post('email_id')))	//designer
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('designers',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'designer/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('','We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('','Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists('team_lead', $this->input->post('email_id'))) //team_lead
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('team_lead',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'team-lead/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('','We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('','Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists('art_director', $this->input->post('email_id')))	//art_director
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('art_director',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'art-director/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('','We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('','Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists('management', $this->input->post('email_id')))	//management
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('management',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'management/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('','We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('','Unable to send email, please try after some time!',2);
			}
		}else
		{
			$this->index('','Invalid Email Id!',2);
		}
	}
	
	function emailIdExists($user, $email_id)	//client
	{
		return $this->db->query("Select * from $user where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function change($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('login/reset',$data);
		}else
		{
			echo $this->index('','The given URL is invalid or it may expired!',2);
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function dochange($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$this->db->update('adreps',array('encrypted_key' => '', 'password' => md5($this->input->post('new_password'))),array('email_id' => $secrets[0], 'encrypted_key' => $encrypted_key));
			$this->index('','Your password has been changed successfully! You may login now.',1,'darkgreen');
		}else
		{
			echo $this->index('','The given URL is invalid or it may expired!',2);
		}
	}
	
	public function shutdown()
	{
	    $this->db->close();
		$this->session->sess_destroy();
		redirect('');
	}
	
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
}
