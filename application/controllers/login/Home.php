<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index($username = '', $error = '', $page = 1, $color = 'darkred')
	{
		if($username) $data['username'] = $username;
		if($error) $data['error'] = $error;
		$data['page'] = $page;
		$data['color'] = $color;
		$this->load->view('login/login',$data);
	}
	
	function userExists($username)
	{
		return $this->db->query("Select * from users where (username='".$username."' OR email_id='".$username."') and is_active='1'")->num_rows();
	}
	
	public function user_login_session($user_id='', $user_module=''){
		$post = array('user_id'=>$user_id, 'user_module'=>$user_module, 'ip'=>$_SERVER['REMOTE_ADDR'], 'browser'=>$_SERVER['HTTP_USER_AGENT']);
		$this->db->insert('users_login_session', $post);
	}
	
	public function doIt()
	{
		$username = $this->input->post('username');
		$user = $this->db->query("Select * from users where (username='".$username."' OR email_id='".$username."') and is_active='1'")->row_array();
		if(isset($user['id'])){
			redirect($user['path'].'?un='.$username);
		}else{
			$this->session->set_flashdata("message","Username/Email doesn't exists..!!");
			redirect('login/home/index');
		}
		
	}
	
}