<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grid extends Art_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('grocery_CRUD');	
	}
	
	public function art_director()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Art Director');
		$crud->set_table('art_director');
		$crud->where('art_director.is_active','1');
		$crud->where('art_director.is_deleted','0');
		 
		$crud->columns('first_name','email_id','business_group_id');
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('is_active','is_deleted');
			
		$crud->set_relation('business_group_id','business_groups','{name}');
		
		$crud->set_rules('first_name','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->set_rules('business_group_id','Business Group Id','required');
		
		$state = $crud->getState();
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Art Director');
		$this->load->view('art-director/gridview',$data);
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
	
	public function designers_shift()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Designers Shift');
		$crud->set_table('designers');
		$crud->where('designers.is_active','1');
		$crud->where('designers.is_deleted','0');
		 
		$crud->columns('name','username','shift_factor');
		
		$crud->unset_fields('design_team_lead','gender','email_id','mobile_no','password','Join_location','Work_location','encrypted_key','image','shift_factor_status','created_on','is_active','is_deleted');
		
		$crud->set_rules('shift_factor','Shift','trim|required|is_numeric|max_length[2]');
				
		$state = $crud->getState();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Designers Shift');
		$this->load->view('art-director/gridview',$data);
	}
	
	public function designers()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Designer');
		$crud->set_table('designers');
		$crud->where('designers.is_active','1');
		$crud->where('designers.is_deleted','0');
		
		$crud->display_as('username','Code');
		$crud->display_as('Join_location','Location');
		$crud->display_as('design_team_lead','Teamlead');
		
		$crud->columns('name','username','gender','email_id','mobile_no','Join_location','shift_factor','design_team_lead');
		$crud->unset_fields('encrypted_key','shift_factor_status','created_on','is_deleted','Work_location');
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));

		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));		
		$crud->display_as('design_team_lead','Design Team Lead');
		$crud->set_relation('design_team_lead','team_lead','{first_name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('team','teams','{name}');
		//$crud->set_relation('Work_location','location','{name}');
		$crud->unset_delete();
		$state = $crud->getState();
		
		$crud->set_rules('design_team_lead','Design Team Lead','required');
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		//$crud->set_rules('shift','Shift','trim|numeric'); 
		$crud->set_rules('shift_factor','Shift','trim|required');
		//$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
			
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Designers');
		$this->load->view('art-director/gridview',$data);
	}

	public function team_lead()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Team Lead');
		$crud->set_table('team_lead');
		$crud->where('team_lead.is_active','1');
		$crud->where('team_lead.is_deleted','0');
		
		$crud->display_as('Join_location','Location');
		$crud->display_as('first_name','Name');
		$crud->columns('first_name', 'gender', 'email_id', 'mobile_no', 'Join_location');
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		
		 $crud->callback_field('password',array($this,'password_callback'));
		/*$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback')); */
		$crud->unset_fields('image', 'encrypted_key','is_deleted','Work_location');
			
		$crud->set_relation('bg','business_groups','{name}'); 
		$crud->set_relation('Join_location','location','{name}');
		//$crud->set_relation('Work_location','location','{name}');
		
		$crud->set_rules('first_name','Name','trim|required|max_length[50]');
		$crud->set_rules('username','User Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->set_rules('team_lead','Team Lead','required');
		$crud->set_rules('phone','Phone','trim|numeric');
		$crud->set_rules('mobile_no','Mobile','trim|numeric');
		$crud->set_rules('ext_no','Extension','trim|numeric');
		$crud->unset_delete();
		$state = $crud->getState();
		/* if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		 */
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Team Lead');
		$this->load->view('art-director/gridview',$data);
	}
	
	public function teams()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Teams');
		$crud->set_table('teams');
		
		$crud->columns('name', 'team_lead');
		$crud->set_relation('team_lead','team_lead','{first_name}'); 
		
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('team_lead','Team Lead','required');
		
		$crud->unset_delete();
		$state = $crud->getState();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Team Lead');
		$this->load->view('art-director/gridview',$data);
	}
	
}