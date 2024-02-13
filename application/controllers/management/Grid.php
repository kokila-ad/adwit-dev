<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grid extends Management_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('grocery_CRUD');	
	}
	
	
	public function bg_head()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Management');
		$crud->set_table('management');
		$crud->where('management.is_active','1');
		$crud->where('management.is_deleted','0');
		 
		$crud->columns('first_name','email_id');
		
		
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('is_active','is_deleted');
		
		
		$crud->set_rules('first_name','Fname','trim|required|max_length[50]');
		$crud->set_rules('username','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
				
		$state = $crud->getState();
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Management');
		$this->load->view('management/gridview',$data);
	}
	


	function encrypt_password_insert_callback($post_array) {
		$post_array['password'] = md5($post_array['password'], $key);
		return $post_array;
	}        
	
	function encrypt_password_update_callback($post_array, $primary_key)
	{
		if($post_array['password']){
			$post_array['password'] = md5($post_array['password'], $key);
		}else{
			$result = $this->db->get_where('csr',array('id' => $primary_key))->result_array();
			$post_array['password']	= $result['password'];
		}	
		
		return $post_array;
	}
	
	function password_callback($value = '', $primary_key = null)
	{
    	return '<input type="text" maxlength="50" name="password">';
	}
	
	
	
	public function min_max_value($str)
	{
		if ((int)$str >= 0 && (int)$str <= 100)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('min_max_value', 'The %s field should be 0 to 100');
			return FALSE;
		}
	}
	
	
	function gender_callback($value = '', $primary_key = null)
	{
		return '<input type="radio" name="gender" value="1" '.($value!='' || $value==1 ? 'checked="checked"' : '').' /> Male&nbsp;&nbsp;<input type="radio" name="gender" value="0" '.($value==0 ? 'checked="checked"' : '').'  /> Female';
	}
	
	public function gender_column_callback($value, $row)
	{
	  return $value==1 ? 'Male' : 'Female';
	}
	
	
	public function view($id = 0)
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		
		if(isset($order[0]['id']))
		{
			$order[0]['publish_date'] = date("d-m-Y", strtotime($order[0]['publish_date']));	
			$order[0]['date_needed'] = date("d-m-Y", strtotime($order[0]['date_needed']));	
			$type = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();	
	 		$client = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array();
			$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();

			$data = array();
			
			$data['client'] = $client[0];

			$data['type'] = $type[0];

			$data['order'] = $order[0];

			$data['publications'] = $publications[0];
			
			$this->load->view('management/vieworder',$data);
		}
	}
	
	public function csr()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('CSR');
		$crud->set_table('csr');
		$crud->where('csr.is_active','1');
		$crud->where('csr.is_deleted','0');
		 
		$crud->columns('name', 'email_id', 'business_group_id', 'team', 'Join_location');
		
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('password','encrypted_key','is_deleted');
		$crud->unset_delete();
		$state = $crud->getState();
		
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('Work_location','location','{name}');
		$crud->set_relation('team','teams','{name}');
		
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->set_rules('business_group_id','Business Group Id','required');
		$crud->set_rules('shift','Shift','trim|numeric');
		$crud->set_rules('mobile_no','Mobile','trim|numeric');
		$crud->set_rules('ext_no','Extension','trim|numeric');
		
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'CSR');
		$this->load->view('management/gridview',$data);
	}
}