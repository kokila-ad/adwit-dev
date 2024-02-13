<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grid extends Bg_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('grocery_CRUD');	
	}
	
	
	public function bg_head()
	{
		$crud = new grocery_CRUD();
		$crud->set_subject('BG_Head');
		$crud->set_table('bg_head');
		$crud->where('bg_head.is_active','1');
		$crud->where('bg_head.is_deleted','0');
		 
		$crud->columns('first_name','email_id','business_group_id');
		$crud->callback_column('gender',array($this,'gender_column_callback'));
		
		$crud->callback_field('gender',array($this,'gender_callback'));
		
		$crud->callback_field('password',array($this,'password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_update_callback'));
		$crud->unset_fields('is_active','is_deleted');
			
		$crud->set_relation('business_group_id','business_groups','{name}');
		
		$crud->set_rules('first_name','Fname','trim|required|max_length[50]');
		$crud->set_rules('username','Name','trim|required|max_length[50]');
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
		$this->load->view('bg_head/gridview',$data);
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
	
	
	public function adwitjobs()
	{
	
	
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_subject('Adwit Job');
		
		$bg_id = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$p_id = $this->db->get_where('publications',array('business_group_id' => $bg_id[0]['business_group_id']))->result_array();
		
		$x=0;
		foreach($p_id as $result)
		{
		
			$adrep_id[$x] = $this->db->get_where('adreps',array('publication_id' => $p_id[$x]['id']))->result_array();

			foreach($adrep_id[$x] as $result1)
			{
				
				$crud->or_where('orders.adrep_id',$result1['id']);
				
			}
			$x++;
			
		}
		
		$crud->set_table('orders');
				
		$crud->order_by('id','desc');
		$crud->display_as('adrep_id','Adrep_name');
		$crud->display_as('id','AdwitAds_id');
		$crud->display_as('job_no','customer job_no');
		$crud->display_as('order_type_id','Ad_type');
		$crud->display_as('publication_name','publisher');
		$crud->columns('created_on','date_needed','id','job_no','adrep_id','advertiser_name','order_type_id','publication_id','designer_head');
						
		//multiselect with multi relation between tables
		/*	$crud->set_relation_n_n('publication_id', 'adreps',  
						'publications','id', 'publication_id', 
						'name','name');					
		*/
		
		$crud->set_relation('order_type_id','orders_type','{name}');
		$crud->set_relation('adrep_id','adreps','{username}');
		$crud->set_relation('publication_name','publications','{name}');
		
		
	/*	$crud->unset_fields('adrep_id','order_type_id','publication','advertiser_name','publication_name','publish_date','date_needed','copy_content',
		'job_instruction','art_work','no_fax_items','no_email_items','job_no','is_requested_before','can_use_previous',
		'is_change_previous','color_preferences','font_preferences','copy_content_description','notes','spec_sold_ad',
		'width','height','size_inches','num_columns','modular_size','print_ad_type','template_used','file_name','pixel_size',
		'web_ad_type','ad_format','maxium_file_size','custom_width','custom_height','created_on','with_form');
		
		
		$crud->set_relation('designer_head','designers','{name}');
		$crud->set_rules('designer_head','Design Id','required');
	*/	
		$crud->unset_add();
		$crud->unset_delete();
		$crud->unset_edit();
		$crud->add_action('View', 'images/view.png', 'admin/grid/view');
		
		$output = $crud->render();
		
		//display as grid
		$data = array('grid' => $output, 'heading' => 'Adwit Jobs');
		$this->load->view('bg_head/gridview',$data);	

		}
		
	public function search()
	{
	
		if(isset($_POST['search']))
		{
		$field=$_POST['field'];
		$value=$_POST['search'];

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_subject('Adwit Job');
		//$crud->set_table('orders');
		
		$bg_id = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
		$p_id = $this->db->get_where('publications',array('business_group_id' => $bg_id[0]['business_group_id']))->result_array();
		
		$x=0;
		foreach($p_id as $result)
		{
			
			$adrep_id[$x] = $this->db->get_where('adreps',array('publication_id' => $p_id[$x]['id'],))->result_array();
			
			foreach($adrep_id[$x] as $result)
		{
			//echo $result['id'];
			//$this->db->get_where('orders',array('adrep_id' => $result['id'],'created_on'=>$value))->result_array();
			//$this->db->query("SELECT * FROM 'orders'  WHERE 'adrep_id' = $result['id'] OR 'created_on'= $value ");
			
			$query[$x] = $this->db->where('adrep_id', $adrep_id[$x]['id'])->or_where('created_on', $value)->get('orders');
			
			//$crud->where($field,$value);
			//$crud->or_where('orders.adrep_id',$result['id']);
			foreach($query[$x] as $result)
			{
				$crud->or_where('orders.adrep_id',$result['id']);
			}
		}
			//$x++;
			
		}
		//$crud->or_where('orders.'.$field,$value);
		
		$crud->set_table('orders');
		$crud->order_by('id','desc');
		$crud->display_as('adrep_id','Adrep_name');
		$crud->display_as('id','AdwitAds_id');
		$crud->display_as('job_no','customer job_no');
		$crud->display_as('order_type_id','Ad_type');
		$crud->display_as('publication_name','publisher');
		$crud->columns('created_on','date_needed','id','job_no','adrep_id','advertiser_name','width','height',
						'size_inches','web_ad_type','order_type_id','publication','publication_name','designer_head');
		
		$crud->set_relation('order_type_id','orders_type','{name}');
		$crud->set_relation('adrep_id','adreps','{username}');
		$crud->set_relation('publication_name','publications','{name}');
		
		$crud->unset_add();
		$crud->unset_delete();
		$crud->unset_edit();
		
		
		$output = $crud->render();
		
		//display as grid
		$data = array('grid' => $output, 'heading' => 'Adwit Jobs');
		$this->load->view('bg_head/gridview',$data);
		}		
		else{
		redirect('bg_head/grid/adwitjobs');
		}
		
	}	
		
	public function all_jobs()
	{
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Category');
		$crud->set_table('cat_result');
		$crud->order_by('id','desc');
				 
		$crud->columns('date','order_no','job_name','width','height','category','csr');
		
		$crud->set_relation('csr','csr','{name}');	
		
		$crud->unset_add();
		$crud->unset_delete();
		$crud->unset_edit();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Category');
		$this->load->view('bg_head/gridview',$data);
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
			/*$data = array();
			$data['type'] = $type[0];
			$data['order'] = $order[0];*/
			
			$this->load->view('bg_head/vieworder',$data);
		}
	}
	
	
	public function cat_result()
	{/*
		$this->load->library('grocery_CRUD');
		
		$crud = new grocery_CRUD();
		$crud->set_subject('Category');
		$crud->set_table('cat_result');
		
		$crud->where("cat_result.news_id in (3,10,15,17,18,24)");
		
		$crud->order_by('id','desc');
		$crud->display_as('category','NJ-Category');		 
		$crud->columns('date','order_no','job_name','width','height','category','slug','designer','csr');
		
		$crud->set_relation('csr','csr','{name}');	
		$crud->set_relation('designer','designers','{username}');	
		$crud->set_relation('category','print','{wt} - {name}');
		
		$crud->unset_add();
		$crud->unset_delete();
		$crud->unset_edit();
		
		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'Category');
		$this->load->view('bg_head/gridview',$data);
	*/
		$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$news_bg = $this->db->get_where('cat_newspaper',array('business_group_id' => $bg_grp[0]['business_group_id']))->result_array();
		foreach($news_bg as $row)
		{
			$cat_bg = $this->db->get_where('cat_result',array('news_id' => $row['id']))->result_array();
			foreach($cat_bg as $row1)
			{
				echo $row1['order_no']." - ".$row1['news_id']." - ".$row1['news_initial']."<br/>";
			}
		}
	
	}
	
}