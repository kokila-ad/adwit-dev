<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	}
    
	public function index($error = '', $page = 1, $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		
		if(!$this->session->userdata('lite_client')){		
			$this->load->view('lite/login',$data);
		}else{
			redirect('lite/home');
		}
	}
	
	//Login
	public function doIt()
	{		
		if($this->logExists($this->input->post('username'), $this->input->post('password'))==1){
			if($this->input->post('remember')!='remember'){
				$this->session->sess_expiration = 7200;
			}
			$result = $this->db->get_where('adreps', array('username' => $this->input->post('username')))->row_array();
			$userdata = array('lite_client' => $this->input->post('username'), 'lcId' => $result['id'], 'lcEmail' => $result['email_id']);
			$this->session->set_userdata($userdata);
			
			$this->index(); 
		}else{
			$this->session->set_flashdata('message','Invalid user name or password!');
			redirect('lite/login');
			//$this->index('Invalid user name or password!');
		}		
	}
	
	function logExists($username,$password)
	{
		return $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and new_ui='4' and is_active='1' and is_deleted='0'")->num_rows();
	}
	
	//Registration
	public function registration()
	{
		if(!$this->session->userdata('lite_client')){		
			$this->load->view('lite/register');
		}else{
			redirect('lite/home');
		}
	}
	
	public function register()
	{
		if(!empty($_POST['publication']) && !empty($_POST['username']) && !empty($_POST['email_id']) && !empty($_POST['password']))
		{
			if($this->input->post('password') != $this->input->post('confirm_password')){
				$this->session->set_flashdata('signup_message','<label style="color:red">The Confirm Password field does not match the Password field!</label>');
				redirect('lite/login/registration');
			}
			$username = $this->input->post('username');
			$email_id = $this->input->post('email_id');
			$UserExists = $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$email_id."') ")->row_array();
			if(isset($UserExists['id'])){
				if($UserExists['is_active']=='0'){
					$this->send_reg_link($email_id, $UserExists['id'], '<label style="color:red">User Already Registered..!!</label>');
				}else{
					$this->session->set_flashdata('signup_message','<label style="color:red">Username/EmailId Already Exists</label> <a style="text-decoration:underline" href='.base_url().index_page().'lite/login>Click To Login </a>');
					redirect('lite/login/registration');
				}
			}else{	//$this->addAdrep('13');
				$post_pub = array('name' => $this->input->post('publication'),
								  'design_team_id' => '13',
								  'group_id' =>	'23',
								  'help_desk' => '18',
								  'channel' => '3',
								  'is_active' => '0'
								);
				$this->db->insert('publications', $post_pub);
				$pId = $this->db->insert_id();
				if($pId){
					$this->addAdrep($pId);		
				}else{
					$this->session->set_flashdata('signup_message','<label style="color:red">Unable to create Publication : '. $this->db->_error_message().'</label>');
					redirect('lite/login/registration');
				}
			}
		}else{ echo "empty"; }
	}
	
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
							'new_ui' 	 => '4',	//lite
							'is_active'  => '0',
						);
			$this->db->insert('adreps', $post);
			$adrep_id = $this->db->insert_id();
			if($adrep_id){
				$this->send_reg_link($this->input->post('email_id'), $adrep_id);
			}else{
				$this->session->set_flashdata('signup_message','<label style="color:red">Unable to create user</label>');
				redirect('lite/login/registration');
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
			$data['subject'] = 'Account Activation - AdwitAds lite';
			$data['recipient'] = $email;
			//$data['recipient'] = 'sudarshan@adwitads.com';
			$data['recipient_display'] = 'AdwitAds lite';
			$data['headline'] = 'Hello!';
			$data['p_three'] = '<a href="'.base_url().index_page().'lite/login/activate/'.$secret_key.'" style="text-decoration:none;color:#0794A0;">Click Here</a>';
						
			if($this->registration_mail($data) == true ){
				$post['email'] = $email;
				$post['adrep_id'] = $adrep_id;
			}else{
				$post['email_error'] = "Unable to send activation link to $email";
			}
			$post['error'] = $error;
			$this->load->view('lite/registration_msg', $post);
	}
	
	function registration_msg()
	{
		$post['error'] = "reg sucessful...!!";
			$this->load->view('lite/registration_msg', $post);
	}
	
	function resend_link($adrep_id)
	{
		$adrep = $this->db->query("Select * from adreps where id='".$adrep_id."' and is_active='0' and is_deleted='0'")->row_array();
		if(isset($adrep['id'])){
			//$this->send_reg_link($adrep['email_id'], $adrep['id']);
			$this->confirm_link($adrep['id']);
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
			
			//make adrep active
			$this->db->update('adreps',array('encrypted_key' => '', 'is_active' => '1'),array('email_id' => $email_id, 'encrypted_key' => $encrypted_key));
			
			//make publication active
			$adrep = $this->db->query("Select * from adreps where email_id='".$email_id."' and is_active='1';")->row_array();
			$this->db->update('publications', array('is_active' => '1'), array( 'id' => $adrep['publication_id'] ));
			
			//assign free credits
			$this->assign_free_credits($adrep['id']);
			
			//$this->session->set_flashdata("message","<p style='color:#3CBC8D;'>Congratulations! Your account has been activated successfully, Log in to continue.</p>");
			$adrepId = urlencode(base64_encode($adrep['id']));
			redirect('lite/login/set_password/'.$adrepId);
		}else{
			$this->session->set_flashdata("message", "The given URL is invalid or it might have expired!"); 
			redirect('lite/login/index');
		}
	}
	
	public function assign_free_credits($adrep_id)
	{
		//Add free credits
			$free_credits = $this->db->get('lite_free_credits')->row_array();
			$today = date("Y-m-d");
			//$num_days = $free_credits['num_days'];
			//$expiry = date( "Y-m-d", strtotime( "$today +$num_days day" ) );
			$expiry = date('Y-m-d', strtotime('next sunday'));
			$post = array(	'uid'=> $adrep_id, 
							'credits'=> $free_credits['credits'], 
							'price'=> '0',
							'credits_type'=> '1',
							'expiry'=> $expiry
						);
			$this->db->insert('lite_credits_added', $post);
			$credits_added_id = $this->db->insert_id();
			//lite_mycredits_history
			if($credits_added_id){
				$data = array(	'uid'=> $adrep_id, 
								'credits_added_id'=> $credits_added_id,
								'credits_debited'=> $free_credits['credits'],
								'purpose' => '1');
				$this->db->insert('lite_mycredits_history', $data);
			}
	}
	
	public function set_password($adrep_id)
	{
		$adrep_id = base64_decode(urldecode($adrep_id));
		$adrep = $this->db->query("Select * from adreps where id='".$adrep_id."' and is_active='1';")->row_array();
		if(isset($adrep['id'])){
			if(isset($_POST['set_password'])){
				if($this->input->post('password') != $this->input->post('confirm_password')){
					$this->session->set_flashdata('message',"The Confirm Password field does not match the Password field!");
					redirect('lite/login/set_password/'.$adrep_id);
				}
				$this->db->update('adreps', array('password' => MD5($this->input->post('password'))), array('id' => $adrep_id));
				$this->doIt();
			}else{
				$data['adrep'] = $adrep;
				$this->load->view('lite/set_password', $data);
			}			
		}else{ echo'adrep not found'; }
	}
	
	function secretExists_reg($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."';")->num_rows();
	}
	
	public function registration_mail($data) 
	{
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
	
	public function publication_chk( $pname='' )
	{
		$publication_chk = $this->db->get_where('publications',array('name' => $pname))->row_array();
		if(isset($publication_chk['id'])){
			$pId = $publication_chk['id'];
		}else{
			$post_pub = array(	'name' => $pname,
								'design_team_id' => '4',
								 'group_id' =>	'23',
								 'help_desk' => '18',
								 'channel' => '3',
								 'is_active' => '0',
								 'slug_type' => '5'
							);
			$this->db->insert('publications', $post_pub);
			$pId = $this->db->insert_id();
		}
		return $pId;
	}
	
	public function adrep_chk( $pId='', $email_id='' )
	{
		$publication = $this->db->get_where('publications',array('id' => $pId))->row_array();
		$adrep_chk = $this->db->get_where('adreps',array('email_id' => $email_id))->row_array();
		if(isset($publication['id']) && !isset($adrep_chk['id'])){
			$post = array(	'publication_id' => $pId,
							'first_name' => $this->input->post('first_name'),
							'last_name'  => $this->input->post('last_name'),
							'username'   => $this->input->post('email_id'),
							'email_id'   => $this->input->post('email_id'),
							//'password'   => md5($this->input->post('password')),
							'new_ui' 	 => '4',	//lite
							'is_active'  => '0',
						);
			$this->db->insert('adreps', $post);
			$adrep_id = $this->db->insert_id();
			//return $adrep_id;
			if($adrep_id){
				return $adrep_id;
			}else{
				$this->session->set_flashdata('signup_message','<label style="color:red">Unable to create Adrep : '. $this->db->_error_message().'</label>');
				redirect('lite/login/free_trial_signup');
			}
		}else{
			if($adrep_chk['is_active']=='1'){ //active adrep already exists
				redirect('lite/login/lite_account_registered/'.$adrep_chk['id']);
			}else{	//adrep already exists but inactive
				$this->session->set_flashdata('signup_message', 'Adrep Entry Exists. 
							Check for Confirmation Link sent to your mail ('.$adrep_chk['email_id'].') Or 
							<a href="'.base_url().index_page().'lite/login/resend_link/'.$adrep_chk['id'].'">
							Click Here</a>');
				redirect('lite/login/free_trial_signup');
			}
		}
	}
	
	public function free_trial_signup()
	{	
		if(isset($_POST['signup']))
		{
		    //check in publications table for entry or insert new and return publication_id
			$pId = $this->publication_chk($this->input->post('publication'));
			if($pId){
			    //check in adreps table for entry or insert new and return adrep_id
				$adrep_id = $this->adrep_chk($pId, $this->input->post('email_id'));
				if($adrep_id){
					$this->confirm_link($adrep_id);
				}
			}else{
				$this->session->set_flashdata('signup_message','<label style="color:red">Unable to create Publication : '. $this->db->_error_message().'</label>');
				redirect('lite/login/free_trial_signup');
			}
		}else{
			//redirect('home/index');
			$this->load->view('lite/free_trial_signup');
		}
	}
	
	function emailIdExists($email_id)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."';")->num_rows();
	}
	
	function confirm_link($adrep_id)
	{
		$adrep = $this->db->query("Select * from adreps where id='".$adrep_id."';")->row_array();
		if(isset($adrep['id']))
		{ 
			$email = $adrep['email_id'];
			$mktime = time();
			$secret_key = $this->encrypt->encode($email.":".$mktime);
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $email));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'AdwitAds';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'adwitads';
			$data['subject'] = 'Adwit Lite Account Activation';
			$data['recipient'] = $email;
			$data['recipient_display'] = 'adwitads.com';
			$data['p_one'] = '<p style="color:#2e2c2c;margin:0px;padding-top:20px;font-size:14px;">To activate your account and set your password, please 
			<a href="'.base_url().index_page().'lite/login/activate/'.$secret_key.'" target="_blank" style="color:#0066ff; text-decoration:none;">click here</a>. </p>';
			
			$data['adrep'] = $adrep;
			
			if($this->send_confirm_mail($data) == true) {
				redirect('lite/login/thankyou/'.$adrep['id']);
			}else{
				$this->session->set_flashdata("message","Unable to send email.");
				redirect('lite/login/alert');
			}
		}else{
			$this->session->set_flashdata("message","Invalid Email Id!");
			redirect('lite/login/alert');
		}
	}
	
	public function send_confirm_mail($data) 
	{
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->from($data['from'], $data['from_display']);
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		$this->email->subject($data['subject']);
		$this->email->message($this->load->view('lite-emailer/Emailer.php',$data, TRUE));
		$this->email->set_alt_message('This is the alternative message');
		$this->email->attach('lite_email_pdf/ordering_information.pdf');
		//$this->email->send();
		if(!$this->email->send())
            return false;
        else 
            return true;
		
    }
	
	function thankyou($adrep_id)
	{
		$adrep = $this->db->get_where('adreps', array('id' => $adrep_id))->row_array();
		if(isset($adrep['id'])){
			$data['adrep'] = $adrep;
			$this->load->view('lite/thankyou', $data);
		}
	}
	
	/*
	public function activate($encrypted_key)
	{ 
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		$mktime = time();
		if($secrets[1] + 172800 > $mktime && $this->secretExists($secrets[0],$encrypted_key)==1)
		{			
			$this->dochange($secrets[0],$encrypted_key);
			//$this->load->view('client/reset',$data);
		}else
		{
			$this->session->set_flashdata("message","The given URL is invalid or it might have expired!"); 
			redirect('login/alert');
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."';")->num_rows();
	}
	*/
	
	public function dochange($email_id,$encrypted_key)
	{
		$this->db->update('adreps',array('encrypted_key' => '', 'is_active' => '1'),array('email_id' => $email_id, 'encrypted_key' => $encrypted_key));
		//$this->lite_login_model->lite_credits_added($email_id);
		$this->session->set_flashdata("message","<p style='color:#3CBC8D;'>Your Account has been Activated successfully! You may login now.</p>");
		redirect('lite/login/alert');
	}
	
	public function reset()
	{
		if($this->lite_login_model->emailIdExists($this->input->post('email_id')))
		{
			$mktime = time();
			$secret_key = $this->encrypt->encode($this->input->post('email_id').":".$mktime);
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $this->input->post('email_id')));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'adwitads';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'Do Not Reply';
			$data['subject'] = 'Reset password - adwitads.com';
			$data['recipient'] = $this->input->post('email_id');
			$data['recipient_display'] = 'Customer adwitads';
			$data['headline'] = 'Hello!';
			$data['footline'] = 'Thanks';
			$data['p_one'] = 'We got an reset password request for your account with adwitads.com. Kindly use the following link to reset your password.'; 
			$data['p_two'] = 'If you have not initiated this, please ignore this. The link will be expired within 2 days.';
			$data['p_three'] = 'Click Here to <a href="'.base_url().index_page().'/login/change/'.$secret_key.'" style="text-decoration:none;color:#fcb400;">Reset Your Password</a>';
			
			if($this->send_mail($data)) {
				$this->session->set_flashdata("message","<p style='color:#FCA13F;'>We have sent you an email, use the link there to Reset your Password.</p>");
				redirect('lite/login/alert');
			}else{
				//$this->index('Unable to send email, please try after some time!',2);
				$this->session->set_flashdata("message","Unable to send email, please try after some time!");
				redirect('lite/login/alert');
			}
		}else{
			$this->session->set_flashdata("message","Invalid Email Id!");
			redirect('lite/login/alert');
		}
	}
	
	public function send_mail($data) {
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->from($data['from'], $data['from_display']);
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		$this->email->subject($data['subject']);
		$this->email->message($this->load->view('e-template',$data, TRUE));
		$this->email->set_alt_message('This is the alternative message');

		//$this->email->send();
		if(!$this->email->send())
            return false;
        else 
            return true;
		
    }
	
	public function change($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->encrypt->decode($encrypted_key));
		$mktime = time();
		if($secrets[1] + 172800 > $mktime && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$data['encrypted_key'] = $encrypted_key;
			$data['email_id'] = $secrets[0];
			$this->load->view('reset_password',$data);
		}else
		{
			$this->session->set_flashdata("message","The given URL is invalid or it might have expired!"); 
			redirect('lite/login/alert');
		}
	}
	
	public function change_password($encrypted_key)
	{
		$secrets = preg_split('/[\s:]+/',$this->encrypt->decode($encrypted_key));
		if($secrets[1] + 172800 > time() && $this->secretExists($secrets[0],$encrypted_key)==1)
		{
			$this->db->update('adreps',array('encrypted_key' => '', 'password' => md5($this->input->post('new_password'))),array('email_id' => $secrets[0], 'encrypted_key' => $encrypted_key));
			//$this->index('Your password has been changed successfully! You may login now.',1,'darkgreen');
			$this->session->set_flashdata("message","Your password has been changed successfully! You may login now.");
			redirect('lite/login/alert');
		}else{
			$this->session->set_flashdata("message","The given URL is invalid or it may expired!");
			redirect('lite/login/alert');
		}
	}
	
	public function shutdown()
	{
		//$this->session->unset_userdata(); 
		$this->db->close();
		$this->session->sess_destroy();
		redirect('');
	}
	
	public function alert()
	{
		$this->load->view('alert');
	}
	
	public function lite_account_registered($adrep_id='')
	{
		$adrep = $this->db->get_where('adreps', array('id' => $adrep_id))->row_array();
		if(isset($adrep['id'])){
			$data['adrep'] = $adrep;
			$this->load->view('lite/lite_account_registered', $data);
		}
		
	}
	
	public function landing_page()
	{
		if(isset($_POST['signup']))
		{
			$pId = $this->publication_chk($this->input->post('publication'));
			if($pId){
				$adrep_id = $this->landing_adrep_chk($pId, $this->input->post('email_id'));
				if($adrep_id){
					$this->confirm_link($adrep_id);
				}
			}else{
				$this->session->set_flashdata('signup_message','<label style="color:red">Unable to create Publication : '. $this->db->_error_message().'</label>');
				redirect('lite/login/landing_page');
			}
		}else{
			$this->load->view('lite/landing_page');
		}
		//$this->load->view('lite/landing_page');
	}
	
	public function landing_adrep_chk( $pId='', $email_id='' )
	{
		$publication = $this->db->get_where('publications',array('id' => $pId))->row_array();
		$adrep_chk = $this->db->get_where('adreps',array('email_id' => $email_id))->row_array();
		if(isset($publication['id']) && !isset($adrep_chk['id'])){
			$post = array(	'publication_id' => $pId,
							'first_name' => $this->input->post('first_name'),
							'last_name'  => $this->input->post('last_name'),
							'username'   => $this->input->post('email_id'),
							'email_id'   => $this->input->post('email_id'),
							//'password'   => md5($this->input->post('password')),
							'new_ui' 	 => '4',	//lite
							'is_active'  => '0',
						);
			$this->db->insert('adreps', $post);
			$adrep_id = $this->db->insert_id();
			return $adrep_id;
		}else{
			if($adrep_chk['is_active']=='1'){ //active adrep already exists
				redirect('lite/login/lite_account_registered/'.$adrep_chk['id']);
			}else{	//adrep already exists but inactive
				$this->session->set_flashdata('signup_message', 'Adrep Entry Exists. 
							Check for Confirmation Link sent to your mail ('.$adrep_chk['email_id'].') Or 
							<a href="'.base_url().index_page().'lite/login/resend_link/'.$adrep_chk['id'].'">
							Click Here</a>');
				redirect('lite/login/landing_page');
			}
		}
	}
}
