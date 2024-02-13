<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends India_Controller {

	public function index($error = '', $page = 1, $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('india'))
			$this->load->view('india/login',$data);
		else
			redirect('india/home');
	}
	
	public function doIt()
	{
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1)
		{
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('india_users', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('india' => $this->input->post('username'), 'iId' => $result[0]['id'], 'iEmail' => $result[0]['email_id']);
			$this->session->set_userdata($userdata);
			$this->index();
			
		}elseif($this->logExists2($this->input->post('username'), $this->input->post('password'))==1)	//redirect to iadmin
		{
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('iadmin_users', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('iadmin' => $this->input->post('username'), 'iaId' => $result[0]['id'], 'iaEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('iadmin/home');
			//$this->index();
			
		}
		else
		{
			$this->index('Invalid user name or password!');
		}
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from india_users where (username='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	
	function logExists2($username,$password)
	{
		return $this->db->query("Select * from iadmin_users where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	
	public function reset()
	{
		if($this->emailIdExists($this->input->post('email_id')))
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('india_users',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'Do Not Reply';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'Do Not Reply';
			$data['subject'] = 'Reset password - adwitads.com';
			$data['recipient'] = $this->input->post('email_id');
			$data['recipient_display'] = 'india Adwit Ads';
			$data['headline'] = 'Hello!';
			$data['footline'] = 'Thanks';
			$data['p_one'] = 'We have received a reset password request for your account with adwitads.com. Kindly click on the following link to reset your password.'; 
			$data['p_two'] = 'If you have not initiated this request, please ignore this email. This link will be expired within 2 days.';
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'india/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
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
	
	function emailIdExists($email_id)
	{
		return $this->db->query("Select * from india_users where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function change($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('india/reset',$data);
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from india_users where email_id='".$email_id."' and encrypted_key='".$encrypted_key."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function dochange($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$this->db->update('india_users',array('encrypted_key' => '', 'password' => md5($this->input->post('new_password'))),array('email_id' => $secrets[0], 'encrypted_key' => $encrypted_key));
			$this->index('Your password has been changed successfully! You may login now.',1,'darkgreen');
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	public function shutdown()
	{
		$this->session->sess_destroy();
		redirect('india/login');
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