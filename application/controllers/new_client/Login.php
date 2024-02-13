<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	}
	
	public function index($error = '', $page = 1, $color = 'darkred')
	{
	    $this->load->library('encryption');
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('new_client')){		
			$this->load->view('new_client/login',$data);
		}else{
			redirect('new_client/home');
		}
	}
	
	/*public function check_captcha($captcha){		$expiration = time()-7200; 		$this->db->query("DELETE FROM captcha WHERE time < ".$expiration);					$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND time > ?";		$binds = array($captcha, $this->input->ip_address(), $expiration);		$query = $this->db->query($sql, $binds);		$row = $query->row();		return $row->count;	}*/
	
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
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1){
			if($this->input->post('remember')!='remember'){
				$this->session->sess_expiration = 7200;
			}
			$result = $this->db->get_where('adreps', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('new_client' => $this->input->post('username'), 'ncId' => $result['id'], 'ncEmail' => $result['email_id']);
			$this->session->set_userdata($userdata);
			
			//set cookie store username, password
			    $this->load->library('encryption');
			    $cookie_name = "userName";
                $cookie_value = $this->encryption->encrypt($username);
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
                
			$this->user_login_session($this->session->userdata('ncId'), 2, 'in'); //log data
			$this->index(); 
		}else{
			$this->index('Invalid user name or password!');
		}		
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and new_ui='1' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function reset()
	{
	    //$this->load->library('Encryption');
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
		
		if($this->emailIdExists($this->input->post('email_id'))) // New client
		{
			$secret_key = $this->encrypt->encode($this->input->post('email_id').":".time());
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
									
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'client/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
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
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and new_ui='1' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function change($encrypted_key)
	{
	   // $this->load->library('Encryption');
	    $secret_key = $this->encrypt->decode($encrypted_key);
	    
		$secrets = preg_split('/[\s:]+/', $secret_key);
		
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
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
	    $this->load->library('Encryption');
	    $secret_key = $this->encrypt->decode($encrypted_key);
	    
		$secrets = preg_split('/[\s:]+/', $secret_key);
		
		if($secrets[1] + 172800 > mktime() && $this->secretExists($secrets[0],$encrypted_key)==1)
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
		//$this->user_login_session($this->session->userdata('ncId'), 2, 'out'); //log data
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