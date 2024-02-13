<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grid extends Iadmin_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('grocery_CRUD');	
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
		$this->load->view('iadmin/gridview',$data);
	}
	
	public function csr()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('CSR');
		$crud->set_table('csr');
		$crud->where('csr.is_active','1');
		$crud->where('csr.is_deleted','0');
		 
		$crud->columns('name','email_id');
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('is_active','is_deleted');
		
		$state = $crud->getState();
		
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
			
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'CSR');
		$this->load->view('iadmin/gridview',$data);
	}
	
	public function designers()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Designer');
		$crud->set_table('designers');
		$crud->where('designers.is_active','1');
		$crud->where('designers.is_deleted','0');
		 
		$crud->columns('design_team_id','name','email_id');
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('encrypted_key','created_on','is_active','is_deleted');
		
		$crud->display_as('design_team_id','Design Team');
		$crud->set_relation('design_team_id','design_teams','{name}');
		
		$state = $crud->getState();
		
		$crud->set_rules('design_team_id','Design Team','required');
		$crud->set_rules('name','Name','trim|required|max_length[50]');
		$crud->set_rules('email_id','Email Id','trim|required|max_length[50]|valid_email');
			
		if($state=="insert_validation"){
			$crud->set_rules('password','Password','trim|required|min_length[5]|max_length[50]');
		}else if($state=="update_validation"){
			$crud->set_rules('password','Password','min_length[5]|max_length[50]');
		}
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Designers');
		$this->load->view('iadmin/gridview',$data);
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
		$this->load->view('iadmin/gridview',$data);
	}

	public function publications()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Publication');
		$crud->set_table('india_bg');
		$crud->where('india_bg.is_active','1');
		$crud->where('india_bg.is_deleted','0');
		 
		$crud->columns('business_group_id','name', 'design_team_id', 'advertising_director_email_id', 'csr');
		
		$crud->display_as('business_group_id', 'Business Group')
		->display_as('csr_id', 'CSR')
		->display_as('advertising_director_email_id', 'Advertising Director (Email Id)')
		->display_as('design_team_id', 'Design Team')
		->display_as('time_zone_id', 'Time Zone');
		
		$crud->set_relation('business_group_id','business_groups','{name}');
		$crud->set_relation('design_team_id','design_teams','{name}');
		$crud->set_relation('csr_id','csr','{name}');
		$crud->set_relation('time_zone_id','gmt','{name}');
		
		$crud->unset_fields('is_active','is_deleted');
		
		$crud->set_rules('business_group_id','Business Group','required');
		$crud->set_rules('name','Name','required');
		$crud->set_rules('design_team_id','Design Team','required');
		$crud->set_rules('advertising_director_email_id','Advertising Director Email Id','trim|required|valid_email');
		$crud->set_rules('csr_id','CSR','required');
		$crud->set_rules('time_zone_id','Time Zone','required');
		$crud->set_rules('city','City','required');
		$crud->set_rules('spec_ads','Spec Ads','trim|required|callback_min_max_value');
		$crud->set_rules('sold_ads','Sold Ads','trim|required|callback_min_max_value');
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Publications');
		$this->load->view('iadmin/gridview',$data);
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
	
	function india_users()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('Ad Rep');
		$crud->set_table('india_users');
		$crud->where('india_users.is_active','1');
		$crud->where('india_users.is_deleted','0');
		 
		$crud->columns('first_name','last_name', 'gender', 'email_id', 'username', 'publication_id');
		$crud->display_as('publication_id', 'Publication');
		
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		 
		$crud->unset_fields('encrypted_key','created_on','is_active','is_deleted');
		
		$crud->set_relation('publication_id','india_bg','{name}');
		
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
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Ad Reps');
		$this->load->view('iadmin/gridview',$data);
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
		$this->load->view('iadmin/gridview',$data);
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
		$this->load->view('iadmin/gridview',$data);
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
		$this->load->view('iadmin/gridview',$data);
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
					$data['client_name'] = $row[1];
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
		 
		$crud->columns('ad_number','client_name', 'created_on');
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
	
	public function adwitjobs()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Adwit Job');
		$crud->set_table('india_orders');
		
		/*$crud->where('india_orders.is_active','1');
		$crud->where('india_orders.is_deleted','0');*/
		
		$crud->order_by('id','desc');
		$crud->display_as('acc_mgr_id','Adrep_name');
		$crud->display_as('id','AdwitAds_id');
		//$crud->display_as('job_no','customer job_no');
		$crud->display_as('order_type_id','Ad_type');
		$crud->columns('created_on','dead_line_date','id','acc_mgr_id','client_name','width','height','order_type_id');
		
		//$crud->unset_fields('is_active','is_deleted');
		
		$crud->set_relation('order_type_id','india_orders_type','{name}');
		$crud->set_relation('acc_mgr_id','india_users','{username}');
		//$crud->set_relation('is_requested_before', 'india_orders', '{width}+{height}');
		
$crud->set_relation_n_n('{pname}', 'india_users', 'india_bg', 'id', 'publication_id', '{name}','gender');
		//$crud->set_relation('acc_mgr_id','india_users','{publication_id}','publications','{name}');
		//$crud->set_relation('publication_id','publications','{name}');
		//$crud->unset_operations();
		
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->add_action('View', 'images/view.png', 'iadmin/grid/view');
		 
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Adwit Jobs');
		$this->load->view('iadmin/gridview',$data);	

		}
		
	
	
	public function view($id = 0)
	{
		$order = $this->db->get_where('india_orders',array('id' => $id))->result_array();
		
		if(isset($order[0]['id']))
		{
			$order[0]['release_date'] = date("d-m-Y", strtotime($order[0]['release_date']));	
			$order[0]['dead_line'] = date("d-m-Y", strtotime($order[0]['dead_line_date']));	
			$type = $this->db->get_where('india_orders_type',array('id' => $order[0]['order_type_id']))->result_array();	
	 		$client = $this->db->get_where('india_users',array('id' => $order[0]['acc_mgr_id']))->result_array();
			$publications = $this->db->get_where('india_bg',array('id' => $client[0]['publication_id']))->result_array();

			$data = array();
			
			$data['client'] = $client[0];

			$data['type'] = $type[0];

			$data['order'] = $order[0];

			$data['publications'] = $publications[0];
			/*$data = array();
			$data['type'] = $type[0];
			$data['order'] = $order[0];*/
			
			$this->load->view('iadmin/vieworder',$data);
		}
	}
}