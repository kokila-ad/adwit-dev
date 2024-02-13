<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_Model {

	public function customer()
	{
		$query = $this->db->get('retail_users');
		return $query->result_array();
		//$this->load->view('welcome_message', $data);
	}
	
	public function validate_customer()
	{ 
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$pwd = $this->input->post('password');
		$phonenumber = $this->input->post('phonenumber');
		$publisher = $this->input->post('publisher');
		
		$query = $this->db->query("select * from `retail_users` where `username`='$username' or `email_id`='$email';")->result_array();
		if($query){
			return true;
		} else{
			$data = array(
					'username'      => $username,
					'password'     => md5($pwd),
					'email_id'   => $email,
					'phonenumber' => $phonenumber,
					'publisher' => $publisher
				);
			$this->db->insert('retail_users', $data);
		}
	}
	
	public function logExists($username,$password)
	{
		return $this->db->query("Select * from retail_users where (username='".$username."' OR email_id='".$username."') and password='".md5($password)."' and is_active='1'")->num_rows();
	}
	
	function emailIdExists($email_id)
	{
		return $this->db->query("Select * from retail_users where email_id='".$email_id."';")->num_rows();
	}
	
	public function retail_free_credits()
	{
		return $this->db->query("Select * from `retail_free_credits`;")->result_array();
	}
	
	public function retail_free_credits_added($email_id)
	{
		$user = $this->db->get_where('retail_users', array('email_id'=>$email_id))->result_array();
		$result = $this->db->query("Select * from `retail_free_credits`;")->result_array();
		$expire = $result[0]['num_days'];
		$current_date = date('Y-m-d');
		
		$expire_date = date('Y-m-d', strtotime("+$expire day", strtotime($current_date)));
			$data = array(
					'uid'      => $user[0]['id'],
					'free_credits'  => $result[0]['credits'],
					'expiry'   => $expire_date
				);
				
		return $this->db->insert('retail_free_credits_added', $data);
	}
}
?>