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
		
		if(!$this->session->userdata('client'))
			$this->load->view('client/login',$data);
		else
			redirect('client/home');
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
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1){	//client
		
			if($this->input->post('remember')!='remember'){ $this->session->sess_expiration = 7200; }
			
			$username = $this->input->post('username');
			$result = $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			if($result['new_ui'] == '1' ){ //new_client
				$userdata = array('new_client' => $result['username'], 'ncId' => $result['id'], 'ncEmail' => $result['email_id']);
				$this->session->set_userdata($userdata);
				
				//set cookie store username, password
				$this->load->library('encryption');
			    $cookie_name = "userName";
                $cookie_value = $this->encryption->encrypt($username);
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			    
				$this->user_login_session($this->session->userdata('ncId'), 2, 'in'); //log data
				redirect('new_client/home');
			}elseif( $result['new_ui'] == '2' ){	//india_client
				$userdata = array('india_client' => $result['username'], 'icId' => $result['id'], 'icEmail' => $result['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('icId'), 2, 'in'); //log data
				redirect('india_client/home');
			}elseif( $result['new_ui'] == '3' ){	//professional_client
				$userdata = array('professional_client' => $result['username'], 'pcId' => $result['id'], 'pcEmail' => $result['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('pcId'), 2, 'in'); //log data
				redirect('professional_edition/home');
			}elseif( $result['new_ui'] == '4' ){	//lite_client
				$userdata = array('lite_client' => $result['username'], 'lcId' => $result['id'], 'lcEmail' => $result['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('lcId'), 2, 'in'); //log data
				redirect('lite/home');
			}else{	//client
				$userdata = array('client' => $result['username'], 'cId' => $result['id'], 'cEmail' => $result['email_id']);
				$this->session->set_userdata($userdata);
				$this->user_login_session($this->session->userdata('cId'), 2, 'in'); //log data
			}
			$this->index();
			
		}elseif($this->logExists2($this->input->post('username'), $this->input->post('password'))==1){	//redirect to admin
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$username = $this->input->post('username');
			$result = $this->db->query("Select * from admin_users where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			
			$userdata = array('admin' => $result['username'], 'aId' => $result['id'], 'aEmail' => $result['email_id']);
			
			$this->session->set_userdata($userdata);
			$this->user_login_session($this->session->userdata('aId'), 1, 'in'); //log data
			redirect('new_admin/home');
		}elseif($this->logExists3($this->input->post('username'), $this->input->post('password'))==1){	//redirect to designer
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$username = $this->input->post('username');
			$result = $this->db->query("Select * from designers where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			
			$userdata = array('designer' => $result['username'], 'dId' => $result['id'], 'dEmail' => $result['email_id'], 'dLoc' => $result['Join_location'], 'dTeamId' => $result['adwit_teams_id']);
			
			$this->session->set_userdata($userdata);
			$this->user_login_session($this->session->userdata('dId'), 4, 'in'); //log data
			redirect('designer/home');
			
		}elseif($this->logExists4($this->input->post('username'), $this->input->post('password'))==1){	//redirect to csr
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$username = $this->input->post('username');
			$result = $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			
			$userdata = array('csr' => $result['username'], 'sId' => $result['id'], 'sEmail' => $result['email_id']);
			
			$this->session->set_userdata($userdata);
			$this->user_login_session($this->session->userdata('sId'), 3, 'in'); //log data
			redirect('csr/home');
			
		}elseif($this->logExists14($this->input->post('username'), $this->input->post('password'))==1){	//redirect to new csr
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			$username = $this->input->post('username');
			$result = $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			
			$userdata = array('csr' => $result['username'], 'sId' => $result['id'], 'sEmail' => $result['email_id']);
			
			$this->session->set_userdata($userdata);
			
			//session variable to hold teams publication list
			$adwit_teams = $this->db->query("SELECT `adwit_teams_id`, `name` FROM `adwit_teams` WHERE `is_active` = '1'")->result_array();
			foreach($adwit_teams as $row){
			    $adwit_teams_id = $row['adwit_teams_id'];
			    $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications` 
			                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id);")->row_array();
			    if(isset($team_publication['publicationsId'])) $this->session->set_userdata('publicationListTeam'.$adwit_teams_id, $team_publication['publicationsId']);                    
			}
			
			$this->user_login_session($this->session->userdata('sId'), 3, 'in'); //log data
			redirect('new_csr/home');
			
		}elseif($this->logExists5($this->input->post('username'), $this->input->post('password'))==1){	//redirect to bg_head
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('bg_head', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('bg' => $this->input->post('username'), 'bgId' => $result[0]['id'], 'bgEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('bg_head/home');
			
		}elseif($this->logExists6($this->input->post('username'), $this->input->post('password'))==1){	//redirect to art_director
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('art_director', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('art' => $this->input->post('username'), 'aId' => $result[0]['id'], 'aEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('art-director/home');
			
		}elseif($this->logExists10($this->input->post('username'), $this->input->post('password'))==1){ //redirect to new designer
        
		   if($this->input->post('remember')!='remember')
		   {
				$this->session->sess_expiration = 7200;
		   }
		   
		   $username = $this->input->post('username');
			$result = $this->db->query("Select * from designers where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
			
		   $userdata = array('designer' => $result['username'], 'dId' => $result['id'], 'dEmail' => $result['email_id'], 'dLoc' => $result['Join_location'], 'dTeamId' => $result['adwit_teams_id']);
		   
		   $this->session->set_userdata($userdata);
		   
		    //session variable to hold teams publication list
			$adwit_teams = $this->db->query("SELECT `adwit_teams_id`, `name` FROM `adwit_teams` WHERE `is_active` = '1'")->result_array();
			foreach($adwit_teams as $row){
			    $adwit_teams_id = $row['adwit_teams_id'];
			    $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications` 
			                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id);")->row_array();
			    if(isset($team_publication['publicationsId'])) $this->session->set_userdata('publicationListTeam'.$adwit_teams_id, $team_publication['publicationsId']);                    
			}
			
		   $this->user_login_session($this->session->userdata('dId'), 4, 'in'); //log data
		   if($result['designer_role'] == '2'){
		       redirect('new_designer/home/live_new_ads');
		   }else{
		        redirect('new_designer/home');
		   }
		   
       }elseif($this->logExists7($this->input->post('username'), $this->input->post('password'))==1){	//redirect to team_lead
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('team_lead', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('team' => $this->input->post('username'), 'tId' => $result[0]['id'], 'tEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('team-lead/home');
			
		}elseif($this->logExists8($this->input->post('username'), $this->input->post('password'))==1){	//redirect to management
		
			if($this->input->post('remember')!='remember')
			{
				$this->session->sess_expiration = 7200;
			}
			
			$result = $this->db->get_where('management', array('username' => $this->input->post('username')))->result_array();
			$userdata = array('management' => $this->input->post('username'), 'mId' => $result[0]['id'], 'mEmail' => $result[0]['email_id']);
			
			$this->session->set_userdata($userdata);
			redirect('management/home');
			
		}else{
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
		return $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0' and new_csr='0'")->num_rows();
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
		return $this->db->query("Select * from csr where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1' and is_deleted='0' and new_csr='1'")->num_rows();
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
			$data['p_two'] = 'If you have not initiated this request, please ignore this email. This link will expire in 24 hours.';
		
		$secret_key = $this->encrypt->encode($this->input->post('email_id').":".time());
		
		if($this->emailIdExists($this->input->post('email_id'))) //client
		{
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
									
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'client/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists2($this->input->post('email_id')))	//csr
		{
		    $this->db->update('csr',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'new_csr/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists3($this->input->post('email_id')))	//designer
		{
			//$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('designers',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'new_designer/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists4($this->input->post('email_id'))) //team_lead
		{
			//$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('team_lead',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'team-lead/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists5($this->input->post('email_id')))	//art_director
		{
			//$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('art_director',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'art-director/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists6($this->input->post('email_id')))	//bg_head
		{
			//$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
			$this->db->update('bg_head',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'bg_head/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
					$this->index('We have sent you an email, use the link there to reset your password.', 2, 'darkgreen');
			}else{
				$this->index('Unable to send email, please try after some time!',2);
			}
		}elseif($this->emailIdExists7($this->input->post('email_id')))	//management
		{
			//$secret_key = $this->uencrypter->encode($this->input->post('email_id').":".mktime());
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
		return $this->db->query("Select * from designers where email_id='".$email_id."' and is_active='1' and is_deleted='0'")->num_rows();
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
	    //$this->load->library('Encryption');
	    $secret_key = $this->encrypt->decode($encrypted_key);
		$secrets = preg_split('/[\s:]+/', $secret_key);
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
	   // $this->load->library('Encryption');
	    $secret_key = $this->encrypt->decode($encrypted_key);
	    
		$secrets = preg_split('/[\s:]+/', $secret_key);
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
}