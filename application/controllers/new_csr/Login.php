<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index($error = '', $page = 1, $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('csr'))
			//$this->load->view('new_csr/login',$data);
			redirect('client/login');
		else
		    redirect('new_csr/home');
	}
	
	public function user_login_session($user_id='', $user_module='', $log='')
	{
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
		if(isset($_GET['un'])){
			$username = $this->input->get('un');
			$usernameExists = $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."') and is_active='1' and is_deleted='0'")->row_array();
			if(isset($usernameExists['id'])){
				$data['username'] = $username;
				//$data['image'] = $usernameExists['image_path']; 
				$this->load->view('new_csr/login',$data);
			}else{
				$this->index('Invalid user name or password!');
			}
		}elseif($this->logExists($this->input->post('username'), $this->input->post('password'))==1){
			if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
			
			$result = $this->db->query("Select * from csr where (username='".$this->input->post('username')."' OR email_id='".$this->input->post('username')."') ")->result_array();
			$userdata = array('csr' => $this->input->post('username'), 'sId' => $result[0]['id'], 'sEmail' => $result[0]['email_id'], 'sName' => $result[0]['name']);
			$this->session->set_userdata($userdata);
			
			//session variable to hold teams publication list
			$adwit_teams = $this->db->query("SELECT `adwit_teams_id`, `name` FROM `adwit_teams` WHERE `is_active` = '1'")->result_array();
			foreach($adwit_teams as $row){
			    $adwit_teams_id = $row['adwit_teams_id'];
			    $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications` 
			                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id);")->row_array();
			    if(isset($team_publication['publicationsId'])) $this->session->set_userdata('publicationListTeam'.$adwit_teams_id, $team_publication['publicationsId']);                    
			}
			
			$this->user_login_session($this->session->userdata('sId'), 3, 'in');
			$this->index();
			
		}else{
			$this->index('Invalid user name or password!');
		}
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function reset()
	{
		if($this->emailIdExists($this->input->post('email_id')))
		{
			$secret_key = $this->encrypt->encode($this->input->post('email_id').":".time());
			$this->db->update('csr',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
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
			$data['p_two'] = 'If you have not initiated this, please ignore this. The link will be expired within 2 days.';
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'new_csr/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
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
		return $this->db->query("Select * from csr where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function change($encrypted_key)
	{
	    $this->load->library('encrypt');
	    //echo $encrypted_key.'<br/>';
	    $secret_key = $this->encrypt->decode($encrypted_key);
	    //echo 'secret_key - '.$secret_key.'<br/>';
	    $secrets = preg_split('/[\s:]+/',$secret_key);
	    //echo $secrets[0].' - '.$secrets[1].'<br/>';
	    
	//	$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > time() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('new_csr/reset',$data);
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from csr where email_id='".$email_id."' and encrypted_key='".$encrypted_key."' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	public function dochange($encrypted_key)
	{
	    $this->load->library('encrypt');
	    $secret_key = $this->encrypt->decode($encrypted_key);
	    $secrets = preg_split('/[\s:]+/',$secret_key);
	    
		//$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		if($secrets[1] + 172800 > time() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$this->db->update('csr',array('encrypted_key' => '', 'password' => md5($this->input->post('new_password')), 'pwd_date' => date('Y-m-d')),array('email_id' => $secrets[0], 'encrypted_key' => $encrypted_key));
			$this->index('Your password has been changed successfully! You may login now.',1,'darkgreen');
		}else
		{
			echo $this->index('The given URL is invalid or it may expired!',2);
		}
	}
	
	public function shutdown()
	{
	    $user_id = $this->session->userdata('sId');
	    if(isset($user_id)){
    	    $this->user_login_session($user_id, 3, 'out');
    	}
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
?>