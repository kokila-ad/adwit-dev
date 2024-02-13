<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends Professional_Controller {

	public function index()
	{
		if(!$this->session->userdata('professional_client')){		
			$this->load->view('professional_client/register');
		}else{
			redirect('professional_client/home');
		}
	}
	 
	public function register()
	{
		if($this->UserExists($this->input->post('username'), $this->input->post('email_id'))==1){
			$this->session->set_flashdata('message','<label style="color:red">Username/EmailId Already Exists</label>');
			redirect('professional_client/registration/index');
		}else{
			$post_pub = array('name'=>$this->input->post('publication'), 'is_active'=>'0');
			$this->db->insert('publications', $post_pub);
			$pId = $this->db->insert_id();
			if($pId){
				$this->addAdrep($pId);		
			}else{
				$this->session->set_flashdata('message','<label style="color:red">Unable to Publication</label>');
				redirect('professional_client/registration/index');
			}
		}
	}
	
	function UserExists($username, $email_id)
	{
		return $this->db->query("Select * from adreps where (username='".$username."' OR email_id='".$email_id."') and is_active='1' and is_deleted='0'")->num_rows();
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
							'new_ui' 	 => '3',	//professional_client
							'is_active'  => '0',
						);
			$this->db->insert('adreps', $post);
			if($this->db->insert_id()){
				$this->send_reg_link($this->input->post('email_id'));
			}else{
				$this->session->set_flashdata('message','<label style="color:red">Unable to create user</label>');
				redirect('professional_client/registration/index');
			}
		}		
	}
	
	function send_reg_link($email)
	{ 
			$mktime = time();
			$secret_key = $this->encrypt->encode($email.":".$mktime);
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $email));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'designteam';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'designteam';
			$data['subject'] = 'Confirm Registration - adwitads.com';
			//$data['recipient'] = $email;
			$data['recipient'] = 'sudarshan@adwitads.com';
			$data['recipient_display'] = 'adwitads.com';
			$data['headline'] = 'Hello!';
			$data['footline'] = 'Thanks';
			$data['p_one'] = 'Thank you for registering. Before we start your service you must click the button below or use the following copy paste link to Confirm Registration:';
            $data['p_two'] = 'If you have not initiated this, please ignore this. The link will expire in 2 days.';
            $data['p_three'] = '<a href="'.base_url().index_page().'professional_client/registration/activate/'.$secret_key.'" 
			style="text-decoration:none;color:#0794A0;">click</a>';
			$data['p_four'] = '<a href="'.base_url().index_page().'professional_client/registration/activate/'.$secret_key.'" style="background-color: #3CBC8D;color: #fff;padding: 4px 10px;border-radius: 3px;border: 1px solid #3CBC8D;text-decoration: none;">Verify Now</a>';
						
			if($this->send_mail($data) == true ){
				$post['email'] = $email;
			}else{
				$post['email_error'] = "Unable to send activation link to $email";
			}
			$this->load->view('professional_client/registration_msg', $post);
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
	
	public function activate($encrypted_key)
	{ 
		$secrets = preg_split('/[\s:]+/', $this->encrypt->decode($encrypted_key));
		$mktime = time();
		if($secrets[1] + 172800 > $mktime && $this->secretExists($secrets[0],$encrypted_key)==1){			
			$email_id = $secrets[0];
			$this->db->update('adreps',array('encrypted_key' => '', 'is_active' => '1'),array('email_id' => $email_id, 'encrypted_key' => $encrypted_key));
			$this->session->set_flashdata("message","<p style='color:#3CBC8D;'>Congratulations! Your account has been activated successfully, login to continue.</p>");
			redirect('professional_client/login/index');
		}else{
			$this->session->set_flashdata("message","The given URL is invalid or it might have expired!"); 
			redirect('professional_client/registration/index');
		}
	}
	
	function secretExists($email_id,$encrypted_key)
	{
		return $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."';")->num_rows();
	}
}