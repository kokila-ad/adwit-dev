<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index($error = '', $page = 1, $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('admin'))
			redirect('client/login');
		else
			redirect('new_admin/home');
	}
	
	public function user_login_session($user_id='', $user_module='', $log=''){
		$this->load->helper('url');
		$this->load->library('user_agent');
				$ip = $this->input->ip_address();
				$browser = $this->agent->browser();
				$browserVersion = $this->agent->version();
				$platform = $this->agent->platform();
				$mobile = $this->agent->is_mobile();
				if($mobile){
					$mobile = $this->agent->mobile();
				}else{
					$mobile = 'Desktop';
				}
				
				$record = array(
								'user_id' => $user_id,
								'user_module' => $user_module,
								'ip' => $ip,
								'browser' => $browser.''.$browserVersion,
								'os' => $platform,
								'device' => $mobile,
								'in_out' => $log,
								);
				$this->db->insert('users_login_session', $record);
	}
	
	public function doIt()
	{
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1)
		{
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('admin_users', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('admin' => $this->input->post('username'), 'aId' => $result[0]['id'], 'aEmail' => $result[0]['email_id']);
			$this->session->set_userdata($userdata);
			$this->user_login_session($this->session->userdata('aId'), 1, 'in'); //log data
			$this->index();
			
		}else
		{
			$this->index('Invalid user name or password!');
		}
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from admin_users where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function reset()
	{
		if($this->emailIdExists($this->input->post('email_id')))
		{
			$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('admin_users',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'Do Not Reply';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'Do Not Reply';
			$data['subject'] = 'Reset password - adwitads.com';
			$data['recipient'] = $this->input->post('email_id');
			$data['recipient_display'] = 'Administrator Adwit Ads';
			$data['headline'] = 'Hello!';
			$data['footline'] = 'Thanks';
			$data['p_one'] = 'We have received a reset password request for your account with adwitads.com. Kindly click on the following link to reset your password.'; 
			$data['p_two'] = 'If you have not initiated this request, please ignore this mail. The link will be expired within 2 days.';
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'admin/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
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
		return $this->db->query("Select * from admin_users where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function change($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('admin/reset',$data);
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from admin_users where email_id='".$email_id."' and encrypted_key='".$encrypted_key."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function dochange($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$this->db->update('admin_users',array('encrypted_key' => '', 'password' => md5($this->input->post('new_password'))),array('email_id' => $secrets[0], 'encrypted_key' => $encrypted_key));
			$this->index('Your password has been changed successfully! You may login now.',1,'darkgreen');
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	public function shutdown()
	{
		$this->user_login_session($this->session->userdata('aId'), 1, 'out'); //log data
		$this->session->sess_destroy();
		$this->db->close();
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