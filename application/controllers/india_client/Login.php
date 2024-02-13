<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends India_Client_Controller {

	public function index($error = '', $page = 1, $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('client')){		
		$this->load->view('india_client/login',$data);
		}else{			redirect('india_client/home');		}
	}
	/*public function check_captcha($captcha){		$expiration = time()-7200; 		$this->db->query("DELETE FROM captcha WHERE time < ".$expiration);					$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND time > ?";		$binds = array($captcha, $this->input->ip_address(), $expiration);		$query = $this->db->query($sql, $binds);		$row = $query->row();		return $row->count;	}*/
	public function doIt()
	{		
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1)
		{
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('adreps', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('client' => $this->input->post('username'), 'cId' => $result[0]['id'], 'cEmail' => $result[0]['email_id']);
			$this->session->set_userdata($userdata);
			if( $result[0]['new_ui'] == '1' )
			{
				redirect('india_client/home');
			}
			else
			{
				
			$this->index();
			}
		}elseif($this->logExists2($this->input->post('username'), $this->input->post('password'))==1)	//redirect to admin
		{
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('admin_users', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('admin' => $this->input->post('username'), 'aId' => $result[0]['id'], 'aEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('admin/home');
		}elseif($this->logExists3($this->input->post('username'), $this->input->post('password'))==1)	//redirect to designer
		{
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('designers', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('designer' => $this->input->post('username'), 'dId' => $result[0]['id'], 'dEmail' => $result[0]['email_id'], 'dLoc' => $result[0]['Join_location']);
			
			$this->session->set_userdata($userdata);
			redirect('designer/home');
			
		}elseif($this->logExists4($this->input->post('username'), $this->input->post('password'))==1)	//redirect to csr
		{
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('csr', array('email_id' => $this->input->post('username')))->result_array();
			$userdata = array('csr' => $this->input->post('username'), 'sId' => $result[0]['id'], 'sEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('csr/home');
			
		}elseif($this->logExists14($this->input->post('username'), $this->input->post('password'))==1)	//redirect to new csr
		{
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('csr', array('email_id' => $this->input->post('username')))->result_array();
			$userdata = array('csr' => $this->input->post('username'), 'sId' => $result[0]['id'], 'sEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('new_csr/home');
			
		}
		elseif($this->logExists5($this->input->post('username'), $this->input->post('password'))==1)	//redirect to bg_head
		{
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('bg_head', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('bg' => $this->input->post('username'), 'bgId' => $result[0]['id'], 'bgEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('bg_head/home');
			
		}elseif($this->logExists6($this->input->post('username'), $this->input->post('password'))==1)	//redirect to art_director
		{
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('art_director', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('art' => $this->input->post('username'), 'aId' => $result[0]['id'], 'aEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('art-director/home');
			
		}elseif($this->logExists10($this->input->post('username'), $this->input->post('password'))==1) //redirect to new designer
          {
		   if($this->input->post('remember')!='remember')
		   {
			$this->session->sess_expiration = 7200;
		   }
		   
		   $result = $this->db->get_where('designers', array('username' => $this->input->post('username')))->result_array();
		   $userdata = array('designer' => $this->input->post('username'), 'dId' => $result[0]['id'], 'dEmail' => $result[0]['email_id'], 'dLoc' => $result[0]['Join_location']);
		   
		   $this->session->set_userdata($userdata);
		   redirect('new_designer/home');
		   
      }elseif($this->logExists7($this->input->post('username'), $this->input->post('password'))==1)	//redirect to team_lead
		{
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('team_lead', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('team' => $this->input->post('username'), 'tId' => $result[0]['id'], 'tEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('team-lead/home');
			
		}elseif($this->logExists8($this->input->post('username'), $this->input->post('password'))==1)	//redirect to management
		{
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('management', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('management' => $this->input->post('username'), 'mId' => $result[0]['id'], 'mEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('management/home');
			
		}else
		{
			$this->index('Invalid user name or password!');
		}		
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function logExists2($username,$password)
	{
		return $this->db->query("Select * from admin_users where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function logExists3($username,$password)
	{
		return $this->db->query("Select * from designers where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0' and new_d='0'")->num_rows();
	}
	
	function logExists4($username,$password)
	{
		return $this->db->query("Select * from csr where (email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0' and new_csr='0'")->num_rows();
	}

	function logExists5($username,$password)
	{
		return $this->db->query("Select * from bg_head where (username='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function logExists6($username,$password)
	{
		return $this->db->query("Select * from art_director where (username='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function logExists7($username,$password)
	{
		return $this->db->query("Select * from team_lead where (username='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function logExists8($username,$password)
	{
		return $this->db->query("Select * from management where (username='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	function logExists10($username,$password)
    {
  return $this->db->query("Select * from designers where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0' and new_d='1'")->num_rows();
    }
	function logExists14($username,$password)
	{
		return $this->db->query("Select * from csr where (email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0' and new_csr='1'")->num_rows();
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
		
		if($this->emailIdExists($this->input->post('email_id'))) //client
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
									
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'client/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists2($this->input->post('email_id')))	//csr
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('csr',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'csr/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists3($this->input->post('email_id')))	//designer
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('designers',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'designer/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists4($this->input->post('email_id'))) //team_lead
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('team_lead',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'team-lead/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists5($this->input->post('email_id')))	//art_director
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('art_director',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'art-director/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists6($this->input->post('email_id')))	//bg_head
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('bg_head',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'bg_head/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists7($this->input->post('email_id')))	//management
		{
			$secret_key = $this->encryption->encrypt($this->input->post('email_id').":".time());
			$this->db->update('management',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'management/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}else
		{
			$this->index('Invalid Email Id!',2);
		}
	}
	
	function emailIdExists($email_id)	//client
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function emailIdExists2($email_id)	//csr
	{
		return $this->db->query("Select * from csr where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function emailIdExists3($email_id)	//designer
	{
		return $this->db->query("Select * from designers where email_id='".$email_id."' and is_active='1' and is_deleted='0' and new_d='0'")->num_rows();
	}
	
	function emailIdExists4($email_id) //team_lead
	{
		return $this->db->query("Select * from team_lead where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function emailIdExists5($email_id)	//art_director
	{
		return $this->db->query("Select * from art_director where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function emailIdExists6($email_id)	//bg_head
	{
		return $this->db->query("Select * from bg_head where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	function emailIdExists7($email_id)	//management
	{
		return $this->db->query("Select * from management where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}


	public function change($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->encryption->decrypt($encrypted_key));
		if($secrets[1] + 172800 > time() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('client/reset',$data);
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
		$secrets = preg_split('/[\s:]+/',$this->encryption->decrypt($encrypted_key));
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