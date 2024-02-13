<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grid extends Auth_Controller {

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
		 
		$crud->columns('first_name', 'email_id', 'business_group_id', 'Join_location', 'Work_location');
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('encrypted_key','is_active','is_deleted');
			
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('Work_location','location','{name}');
		
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
		$this->load->view('admin/gridview',$data);
	}
	
	public function businessgroups()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Business Group');
		$crud->set_table('business_groups');
		$crud->where('business_groups.is_active','1');
		$crud->where('business_groups.is_deleted','0');
		 
		$crud->columns('name');
		$crud->unset_fields('is_active','is_deleted');
		
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Business Groups');
		$this->load->view('admin/gridview',$data);
	}
	
	
	public function bg_head()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('BG_Head');
		$crud->set_table('bg_head');
		$crud->where('bg_head.is_active','1');
		$crud->where('bg_head.is_deleted','0');
		 
		$crud->columns('first_name', 'email_id', 'business_group_id', 'Join_location', 'Work_location');
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('encrypted_key','is_active','is_deleted');
			
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('Work_location','location','{name}');
		
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
		
		$data = array('grid' => $output, 'heading' => 'BusinessGroup_Head');
		$this->load->view('admin/gridview',$data);
	}
	
	public function csr()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('CSR');
		$crud->set_table('csr');
		$crud->where('csr.is_active','1');
		$crud->where('csr.is_deleted','0');
		 
		$crud->columns('name', 'email_id', 'business_group_id', 'Join_location', 'Work_location');
		
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('encrypted_key');
		
		$state = $crud->getState();
		
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('Work_location','location','{name}');
		
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->set_rules('business_group_id','Business Group Id','required');
		$crud->set_rules('shift','Shift','trim|numeric');
		
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'CSR');
		$this->load->view('admin/gridview',$data);
	}
	
	public function team_lead()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Team Lead');
		$crud->set_table('team_lead');
		$crud->where('team_lead.is_active','1');
		$crud->where('team_lead.is_deleted','0');
		 
		$crud->columns('first_name', 'email_id', 'bg', 'Join_location', 'Work_location');
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('encrypted_key','is_active','is_deleted');
			
		$crud->set_relation('bg', 'business_groups', '{name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('Work_location','location','{name}');
		
		$crud->set_rules('first_name','Name','trim|required|max_length[50]');
		$crud->set_rules('username','User Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->set_rules('team_lead','Team Lead','required');
		
		$state = $crud->getState();
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Team Lead');
		$this->load->view('admin/gridview',$data);
	}
	
	public function designers()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Designer');
		$crud->set_table('designers');
		//$crud->where('designers.is_active','1');
		//$crud->where('designers.is_deleted','0');
		 
		$crud->columns('design_team_lead','name','username','gender','email_id','mobile_no','Join_location','Work_location', 'is_active');
		$crud->unset_fields('encrypted_key','created_on');
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));

		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));		
		$crud->display_as('design_team_lead','Design Team Lead');
		$crud->set_relation('design_team_lead','team_lead','{first_name}');
		$crud->set_relation('Join_location','location','{name}');
		$crud->set_relation('Work_location','location','{name}');
		$state = $crud->getState();
		
		$crud->set_rules('design_team_lead','Design Team Lead','required');
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('shift','Shift','trim|numeric');
		//$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
			
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Designers');
		$this->load->view('admin/gridview',$data);
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
	
	public function designteams()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Design Team');
		$crud->set_table('design_teams');
		$crud->where('design_teams.is_active','1');
		$crud->where('design_teams.is_deleted','0');
		 
		$crud->columns('name','email_id');
		$crud->unset_fields('is_active','is_deleted');
		
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Design Teams');
		$this->load->view('admin/gridview',$data);
	}

	public function management()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Management');
		$crud->set_table('management');
		$crud->where('management.is_active','1');
		$crud->where('management.is_deleted','0');
		 
		$crud->columns('first_name','email_id');
		$crud->unset_fields('encrypted_key','is_active','is_deleted','created_on');
		
		$crud->set_rules('first_name','First Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->callback_field('password',array($this,'password_callback'));
		
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));	
		
		$state = $crud->getState();
		
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Management');
		$this->load->view('admin/gridview',$data);
	}
	
	public function publications()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Publication');
		$crud->set_table('publications');
		$crud->where('publications.is_active','1');
		$crud->where('publications.is_deleted','0');
		 
		$crud->columns('id', 'business_group_id','name', 'group_id', 'design_team_id', 'advertising_director_email_id', 'initial', 'help_desk', 'ordering_system', 'channel');
		
		$crud->display_as('business_group_id', 'Business Group')
		//->display_as('csr_id', 'CSR')
		->display_as('advertising_director_email_id', 'Advertising Director')
		->display_as('design_team_id', 'Design Team')
		->display_as('time_zone_id', 'Time Zone')
		->display_as('group_id', 'Group Name');
		
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('design_team_id','design_teams','{name}');
		//$crud->set_relation('csr_id','csr','{name}');
		$crud->set_relation('time_zone_id','gmt','{name}');
		$crud->set_relation('slug_type','cat_slug_type','{name}');
		$crud->set_relation('help_desk','help_desk','{name}');
		$crud->set_relation('ordering_system','ordering_system','{name}');
		$crud->set_relation('channel','channels','{name}');
		$crud->set_relation('group_id','Group','{name}');
		
		$crud->unset_fields('is_active','is_deleted');
		
		$crud->set_rules('business_group_id','Business Group','required');
		$crud->set_rules('name','Name','required');
		$crud->set_rules('design_team_id','Design Team','required');
		$crud->set_rules('advertising_director_email_id','Advertising Director Email Id','trim|required|valid_email');
		//$crud->set_rules('csr_id','CSR','required');
		$crud->set_rules('time_zone_id','Time Zone','required');
		$crud->set_rules('city','City','required');
		$crud->set_rules('spec_ads','Spec Ads','trim|required|callback_min_max_value');
		$crud->set_rules('sold_ads','Sold Ads','trim|required|callback_min_max_value');
		$crud->set_rules('slug_type','Slug Type','required');
		$crud->set_rules('help_desk','Help Desk','required');
		$crud->set_rules('ordering_system','Ordering System','required');
		$crud->set_rules('channel','Channel','required');
		$crud->set_rules('initial','Initial','required');
		
		$crud->unset_delete();
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Publications');
		$this->load->view('admin/gridview',$data);
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
	
	function adreps()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Ad Rep');
		$crud->set_table('adreps');
		//$crud->where('adreps.is_active','1');
		//$crud->where('adreps.is_deleted','0');
		 
		$crud->columns('first_name','last_name', 'gender', 'email_id', 'username', 'publication_id', 'is_active');
		$crud->display_as('publication_id', 'Publication');
		
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		
		$crud->unset_fields('encrypted_key','created_on');
		
		$crud->set_relation('publication_id','publications','{name}');
		
		$crud->set_rules('first_name','First Name','trim|required|max_length[50]');
		$crud->set_rules('last_name','Last Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
		$crud->set_rules('publication_id','Publication','trim|required');
		$crud->set_rules('username','User Name','trim|required');
			
		$state = $crud->getState();
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		$crud->unset_delete();
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Ad Reps');
		$this->load->view('admin/gridview',$data);
	}
	
	function gender_callback($value = '', $primary_key = null)
	{
		return '<input type="radio" name="gender" value="1" '.($value!='' || $value==1 ? 'checked="checked"' : '').' /> Male&nbsp;&nbsp;<input type="radio" name="gender" value="0" '.($value==0 ? 'checked="checked"' : '').'  /> Female';
	}
	
	public function gender_column_callback($value, $row)
	{
	  return $value==1 ? 'Male' : 'Female';
	}
	
	public function webads()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Pixel Size');
		$crud->set_table('pixel_sizes');
		$crud->where('pixel_sizes.is_active','1');
		$crud->where('pixel_sizes.is_deleted','0');
		 
		$crud->columns('name','width','height');
		$crud->unset_fields('is_active','is_deleted');
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('width','Width','trim|required|is_numeric');
		$crud->set_rules('height','Height','trim|required|is_numeric');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Web Ads - Pixel Sizes');
		$this->load->view('admin/gridview',$data);
	}
	
	function printads()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Modular Size');
		$crud->set_table('modular_sizes');
		$crud->where('modular_sizes.is_active','1');
		$crud->where('modular_sizes.is_deleted','0');
		 
		$crud->columns('name');
		$crud->unset_fields('is_active','is_deleted');
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Print Ads - Modular Sizes');
		$this->load->view('admin/gridview',$data);
	}
	
	function tscsuploads()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Add New File');
		$crud->set_table('tscs_uploads');
		$crud->where('tscs_uploads.is_active','1');
		$crud->where('tscs_uploads.is_deleted','0');
		 
		$crud->columns('name','created_on');
		$crud->unset_fields('created_on', 'is_active', 'is_deleted');
		$crud->set_rules('file','File','required');
		$crud->field_type('name', 'hidden');
		
		$crud->set_field_upload('file','assets/uploads/tscs');
		$crud->callback_before_insert(array($this,'tscs_callback_before_insert'));
		$crud->callback_after_insert(array($this,'upload_tscs_records'));
		$crud->unset_edit();
		$crud->unset_delete();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'TSCS Uploads');
		$this->load->view('admin/gridview',$data);
	}
	
	function tscs_callback_before_insert($post_array)
	{
		$post_array['name'] = 'TSCS - '.mktime();
		return $post_array;
	}
	
	function upload_tscs_records($post_array, $primary_key)
	{
		$start = false;
		if (($handle = fopen('assets/uploads/tscs/'. $post_array['file'], "r")) !== FALSE) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if($start)
				{
					$data = array();
					$data['tscs_upload_id'] = $primary_key;
					$data['ad_number'] = $row[0];
					$data['advertiser_name'] = $row[1];
					$data['version_size'] = $row[2];
					$data['size_template'] = $row[3];
					$data['color'] = $row[4];
					$data['sales_group'] = $row[5];
					$data['sales_rep'] = $row[6];
					$data['created_on'] = date("Y-m-d");
					$this->db->insert('tscs_records', $data);
				}else
				{
					$start = true;
				}
			}
			fclose($handle);
		}
		fgetcsv();
	 	return true;	
	}
	
	function tscsrecords()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('TSCS Job');
		$crud->set_table('tscs_records');
		$crud->where('tscs_records.is_active','1');
		$crud->where('tscs_records.is_deleted','0');
		$crud->order_by('created_on','desc');
		 
		$crud->columns('ad_number','advertiser_name', 'created_on');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'TSCS Jobs');
		$this->load->view('admin/gridview',$data);
	}
	
	function metrojobs()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Metro Job');
		$crud->set_table('metro_jobs');
		$crud->where('metro_jobs.is_active','1');
		$crud->where('metro_jobs.is_deleted','0');
		$crud->order_by('created_on','desc');
		 
		$crud->columns('od_orderid', 'od_jobno', 'od_currentdate', 'od_dateneeded', 'od_custname', 'od_adname', /*'od_compnayname', */ 'od_publicationname', 'ad_type_name');
		$crud->display_as('od_orderid','Order Id')
		->display_as('od_jobno','Job No.')
		->display_as('od_currentdate','Created On')
		->display_as('od_dateneeded','Dated Need')
		->display_as('od_custname','User')
		->display_as('od_adname','Advertiser')
		//->display_as('od_compnayname','Publisher')
		->display_as('od_publicationname','Publication')
		->display_as('ad_type_name','Type');
		
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		
		$crud->add_action('View', 'images/view.png', 'admin/grid/viewmetro');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Metro Jobs');
		$this->load->view('admin/gridview',$data);
	}
	
	public function viewmetro($id = 0)
	{
		$job = $this->db->get_where('metro_jobs',array('id' => $id))->result_array();
		if(isset($job[0]['id'])) {
			$data = $job[0];
			$this->load->view('admin/metro', $data);
		}
	}
	
	
	public function adwitjobs($form='')
	{
		$this->load->library('grocery_CRUD');
	
		$crud = new grocery_CRUD();
	
		$crud->set_subject('Adwit Job');
		$crud->set_table('orders');
		$crud->order_by('id','desc');
				
		$crud->where('orders.publication_id',$form);
		
		$crud->display_as('adrep_id','Adrep Name');
		$crud->display_as('id','AdwitAds ID');
		$crud->display_as('job_no','Customer Job No');
		$crud->display_as('order_type_id','Ad Type');
		$crud->display_as('advertiser_name','Advertiser Name');
		$crud->columns('created_on','date_needed','id','publication_id','job_no','adrep_id','advertiser_name','width','height','web_ad_type','order_type_id');
		$crud->set_relation('order_type_id','orders_type','{name}');
		$crud->set_relation('adrep_id','adreps','{username}');
		
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->add_action('View', 'images/view.png', 'admin/grid/view');
		 
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Adwit Jobs');
		$this->load->view('admin/gridview',$data);	
	}

	
	public function view($id = 0)
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		
		if(isset($order[0]['id']))
		{
			date_default_timezone_set(@date_default_timezone_get());
			$order[0]['publish_date'] = date("d-m-Y", strtotime($order[0]['publish_date']));	
			$order[0]['date_needed'] = date("d-m-Y", strtotime($order[0]['date_needed']));	
			$type = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();
			$ad_type = $this->db->get_where('ads_type',array('id' => $order[0]['spec_sold_ad']))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array();
			$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
			$data = array();
			
			$data['client'] = $client[0];

			$data['type'] = $type[0];
			
			$data['ad_type'] = $ad_type[0];

			$data['order'] = $order[0];

			$data['publications'] = $publications[0];
			
			
			$this->load->view('admin/vieworder',$data);
		}
	}
	
	
	public function cat_newspaper()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Newspaper Types');
		$crud->set_table('cat_newspaper');
				 
		$crud->columns('id', 'name', 'business_group_id', 'client', 'initials', 'slug_type', 'help_desk', 'channel');
		
		$crud->set_relation('slug_type','cat_slug_type','{name}');
		$crud->set_relation('help_desk','help_desk','{name}');		
		$crud->set_relation('status','status','{name}');
		$crud->set_relation('client','clients','{name}');
		$crud->set_relation('publication','publications','{name}');
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('channel','channels','{name}');
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Newspaper Types');
		$this->load->view('admin/gridview',$data);
	}
	
	public function dp_error()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Errors');
		$crud->set_table('dp_error');
				 
		$crud->columns('id','name','type','degree');
		
		$crud->set_relation('type','dp_error_type','{name}');	
		$crud->set_relation('degree','dp_error_degree','{name}');
		$crud->set_relation('status','status','{name}');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Errors');
		$this->load->view('admin/gridview',$data);
	}
	
	
	public function cat_result()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Category');
		$crud->set_table('cat_result');
		$crud->order_by('id','desc');
				 
		$crud->columns('date','order_no','job_name','width','height','category','csr');
		
		$crud->set_relation('csr','csr','{name}');	

		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Category');
		$this->load->view('admin/gridview',$data);
	}
	
	
	public function designer_dp()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Designer DP');
		$crud->set_table('designer_dp');
		$crud->order_by('id','desc');
				 
		$crud->columns('id','date','designer','start_time','end_time','time_taken','NJ','TT','TA','job_status');
		
		$crud->set_relation('designer','designers','{username}');
		
		$crud->unset_operations();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Designer DP');
		$this->load->view('admin/gridview',$data);
	}
	
	
	public function help_desk()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Help Desk');
		$crud->set_table('help_desk');
				 
		$crud->columns('name');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Help Desk');
		$this->load->view('admin/gridview',$data);
	}
	
	public function error_type()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Error Type');
		$crud->set_table('dp_error_type');
				 
		$crud->columns('id','name');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Error Type');
		$this->load->view('admin/gridview',$data);
	}
	
	
	public function frontline_timer() //frontline_timer table
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Frontline Timer');
		$crud->set_table('frontline_timer');
				 
		$crud->columns('id','cat_name','duration');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Frontline Timer');
		$this->load->view('admin/gridview',$data);
	}
	
	public function notification()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('NOTIFICATION');
		$crud->set_table('notification');
				 
		$crud->columns('headline','users','start_date','end_date','job_status');
		//$crud->field_type('users','multiselect','adwit_users','{name}');
		$crud->set_relation('users','adwit_users','{name}');
		$crud->set_relation('job_status','status','{name}');
		$crud->unset_fields('time');
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Notification');
		$this->load->view('admin/gridview',$data);
	}
	
	public function designer_performance()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Designer_Production');
		$crud->set_table('Designer_Production');
		$crud->order_by('id','desc');
				 
		$crud->columns('date','designer','cat_A','cat_B','cat_C','cat_D','cat_E','cat_F','cat_G','tot_QA');
		
		//$crud->set_relation('csr','csr','{name}');	

		$crud->unset_operations();
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Performance');
		$this->load->view('admin/gridview',$data);
	}
	
	public function cat_adreps()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Category Adreps');
		$crud->set_table('other_adreps');
				 
		$crud->columns('id','name', 'newspaper');
		$crud->set_relation('newspaper','cat_newspaper','{name}');
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Category Adreps');
		$this->load->view('admin/gridview',$data);
	}
	
	public function customers()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Customers');
		$crud->set_table('customers');
				 
		$crud->columns('id', 'name');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Customers');
		$this->load->view('admin/gridview',$data);
	}
	
	public function channels()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Channels');
		$crud->set_table('channels');
				 
		$crud->columns('id', 'name');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Channels');
		$this->load->view('admin/gridview',$data);
	}
	
	public function group()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Group');
		$crud->set_table('Group');
				 
		$crud->columns('id', 'name');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Group');
		$this->load->view('admin/gridview',$data);
	}
}