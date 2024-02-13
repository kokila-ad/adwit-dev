<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Home extends CI_Controller {

	public function index()
	{
		if(isset($_POST['publication'])){
			if(!empty($_POST['publication']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email_id']))
			{
				$adrep = $this->db->get_where('adreps', array('email_id' => $this->input->post('email_id'), 'is_active' => '1'))->row_array();
				if(isset($adrep['id'])){
					$this->session->set_flashdata('message','<label style="color:red">Account Already Exists..!!</label>');
					redirect('marketing/home/index');
				}else{
					$this->insert();
				}
				
			}else{
				$this->session->set_flashdata('message','<label style="color:red">Fill Up the Form Fields..!!</label>');
				redirect('marketing/home/index');
			}
		}
		$this->load->view('marketing/form');
	}
	
	public function insert()
	{
		if(!empty($_POST['publication']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email_id']))
		{
			$publication_name = $this->input->post('publication');
			$initial = substr($publication_name,0,1);
			$post_pub = array(
								'name' => $publication_name,
								'group_id' => '22',
								'design_team_id' => '4',
								'help_desk' => '17',
								'channel' => '3',
								'initial' => $initial,
								'slug_type' => '5'
							);
			$this->db->insert('publications', $post_pub);
			$pId = $this->db->insert_id();					
			
			if($pId){
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$email_id = $this->input->post('email_id');
				$username = strtolower($first_name).strtolower($last_name);
				$password = $username.'123';
			
				$post_adrep = array(
									'first_name' => $first_name,
									'last_name' => $last_name,
									'publication_id' => $pId,
									'email_id' => $email_id,
									'new_ui' => '1',
									'username' => $username,
									'password' => MD5($password),
									'is_active'  => '1'
								);
				$this->db->insert('adreps', $post_adrep);
				$aId = $this->db->insert_id();
				if($aId){
					$this->send_reg_link($aId, $password);
					//$this->session->set_flashdata('message','<label style="color:red">created user</label>');
					//redirect('marketing/home/index');
				}else{
					$this->session->set_flashdata('message','<label style="color:red">Unable to create user</label>');
					redirect('marketing/home/index');
				}
			}else{
				$this->session->set_flashdata('message','<label style="color:red">Unable to create Publication</label>');
				redirect('marketing/home/index');
			}
		}else{
			$this->session->set_flashdata('message','<label style="color:red">Fill Up the Form Fields..!!</label>');
			redirect('marketing/home/index');
		}
	}
	
	function send_reg_link($aId, $password)
	{ 
		$adrep = $this->db->get_where('adreps', array('id' => $aId, 'is_active' => '1'))->row_array();	
		if(isset($adrep['id'])){
			$email = $adrep['email_id'];
			/*
			$mktime = time();
			$secret_key = $this->uencrypter->encode($email.":".$mktime);
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('id' => $aId));
			*/
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'AdwitAds';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'designteam';
			$data['subject'] = 'Account Details - AdwitAds';
			$data['recipient'] = $email;
			//$data['recipient'] = 'sudarshan@adwitads.com';
			$data['recipient_display'] = 'adwitads.com';
			
			$data['first_name'] = $adrep['first_name'];
            $data['username'] = $adrep['username'];
            $data['password'] = $password;
			/*
			$data['link'] = '<a href="'.base_url().index_page().'marketing/home/activate/'.$secret_key.'" 
			style="background-color: #3CBC8D;color: #fff;padding: 4px 10px;border-radius: 3px;border: 1px solid #3CBC8D;text-decoration: none;">
			Click To Activate Your Account</a>';
			*/
			if($this->send_mail($data) == true ){
				//$this->session->set_flashdata('message','Thank you for sign up, please check your email we have sent a<br>
				//	confirmation link along with username & password to place an order');
				redirect('marketing/home/success');
			}else{
				$this->session->set_flashdata('message','Unable to send activation link to : '.$email);
				redirect('marketing/home/index');
			}
			
		}
	}
	
	public function send_mail($data) {
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->from($data['from'], $data['from_display']);
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		$this->email->subject($data['subject']);
		$this->email->message($this->load->view('marketing/e-account-template',$data, TRUE));
		$this->email->set_alt_message('This is the alternative message');
		
		$path = 'assets/marketing/OrderingInformation.pdf';
		$this->email->attach($path);
		
		if(!$this->email->send())
            return false;
        else 
            return true;
	}
	
	public function activate($encrypted_key)
	{ 
		$secrets = preg_split('/[\s:]+/',$this->uencrypter->decode($encrypted_key));
		$mktime = time();
		if($secrets[1] + 172800 > $mktime && $this->secretExists($secrets[0],$encrypted_key)==1){			
			$email_id = $secrets[0];
			$this->db->update('adreps',array('encrypted_key' => '', 'is_active' => '1'),array('email_id' => $email_id, 'encrypted_key' => $encrypted_key));
			$this->session->set_flashdata("message","<p style='color:#3CBC8D;'>Congratulations! Your account has been activated successfully, login to continue.</p>");
			redirect('client/login/index');
		}else{
			$this->session->set_flashdata("message","The given URL is invalid or it might have expired!"); 
			redirect('marketing/home/index');
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."';")->num_rows();
	}
	
	public function success()
	{
		$this->load->view('marketing/success');
	}
	
	public function activated()
	{
		$this->load->view('marketing/activated');
	}
}