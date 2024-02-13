<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Iadmin_Controller {

	public function index()
	{
		$this->load->view('iadmin/home');
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('iadmin/change',$data);
	}
	
	public function dochange()
	{
		$this->db->query("Update iadmin_users set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('iadmin')."' or username='".$this->session->userdata('iadmin')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->change('Your password has been changed successfully!', 'darkgreen');
		else
			$this->change('Invalid current password!', 'darkred');
	}
}