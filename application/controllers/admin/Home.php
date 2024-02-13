<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Auth_Controller {

	public function index()
	{
		$this->load->view('admin/home');
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		//$aId = $this->session->userdata('aId');
		$data['admin_users'] = $this->db->query("SELECT * from `admin_users` WHERE `is_active` = '1'")->result_array();
		$this->load->view('admin/change',$data);
	}
	
	public function change_profile()
	{
		$aid = $this->session->userdata('aId');
		if(isset($_POST['change_avatar']) && !empty($_FILES['file']['name'])){
			$file_size = $_FILES['file']['size'];
			if($file_size > 100000){
				 $this->session->set_flashdata('size_message',"Image size should not exceed 150KB!!");
					redirect('admin/home/change'); 
			} else {
			$uploadDir = "images/admin/".$aid.".jpg";
			if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadDir)){
				$data = array( 'image_path' => $uploadDir );
				$this->db->where('id', $aid);
				$this->db->update('admin_users', $data);  
			}else{
				$data['error'] = "Error Uploading!!";
				$data['color'] = 'darkred';
			}  
			}
		}redirect('admin/home/change');
	}
	
	public function adreps()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['last_name']) && !empty($_POST['first_name'])&& !empty($_POST['username']) && !empty($_POST['publication_id'])){
			$_POST['password'] = MD5($_POST['password']);
			$adreps_successful = $this->admin_model->adreps_insert();
			if($adreps_successful){
				$this->session->set_flashdata("adreps_successful","Adrep Added successfully!");
				redirect('admin/home/adreps');
			}else{
				$this->session->set_flashdata("adreps_successful",$this->db->_error_message());
				redirect('admin/home/adreps');
			}
		}
		$data['adreps_list'] = $this->admin_model->adreps_list();
		$data['publications_list'] = $this->admin_model->publications_list();
		$this->load->view('admin/adreps',$data);
	}
	
	
	
	public function adreps_add()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['last_name']) && !empty($_POST['first_name'])&& !empty($_POST['username']) && !empty($_POST['publication_id'])){
			
			$adreps_successful = $this->admin_model->adreps_insert();
			if($adreps_successful){
				$this->session->set_flashdata("adreps_successful","Adrep Added successfully!");
				redirect('admin/home/adreps');
			}else{
				$this->session->set_flashdata("adreps_successful",$this->db->_error_message());
				redirect('admin/home/adreps');
			}
		}
		$data['adreps_list'] = $this->admin_model->adreps_list();
		$data['publications_list'] = $this->admin_model->publications_list();
		$this->load->view('admin/adreps_add',$data);
	}
	
	public function adreps_edit($id)
	{
		$adrep = $this->db->get_where('adreps',array('id' => $id))->row_array();
		if(isset($adrep['id'])){
			$data['adrep'] = $adrep;
		if($id!='' && !empty($_POST['first_name']) && !empty($_POST['username']) && !empty($_POST['publication_id']))
		{
			if($adrep['password'] != $_POST['password']){
				$_POST['password'] = MD5($_POST['password']);
			}
			$adrep = $this->admin_model->adreps_check($id);
			if($adrep == '1'){
				$this->admin_model->adreps_update($id);
				redirect('admin/home/adreps');
			}else{
				$this->session->set_flashdata("adreps_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/adreps');
			}
			
		}
		$data['adreps_list'] = $this->admin_model->adreps_list();
		$data['publications_list'] = $this->admin_model->publications_list();
		$this->load->view('admin/adreps_edit',$data);
	}
	}
	
	
	public function publications_list()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['business_group_id']) && !empty($_POST['group_id'])&& !empty($_POST['name']) && !empty($_POST['design_team_id'])){
			$publications_successful = $this->admin_model->publications_insert();
			
			if($publications_successful){
				$this->session->set_flashdata("publications_successful","Publication Added successfully!");
				redirect('admin/home/publications_list');
			}else{
				$this->session->set_flashdata("publications_successful",$this->db->_error_message());
				redirect('admin/home/publications_list');
			}
		}
		$data['business_groups'] = $this->admin_model->business_groups();
		$data['design_team'] = $this->admin_model->design_team();
		$data['teams'] = $this->admin_model->teams();
		$data['help_desk'] = $this->admin_model->help_desk();
		$data['ordering_system'] = $this->admin_model->ordering_system();
		$data['channels'] = $this->admin_model->channels();
		$data['group'] = $this->admin_model->group();
		$data['publications_list'] = $this->admin_model->publications_list();
		$this->load->view('admin/publications_list',$data);
	}
	
	public function publications_add()
	{
		$this->load->helper(array('form', 'url'));
		
		if(!empty($_POST['group_id'])&& !empty($_POST['name']) && !empty($_POST['design_team_id'])){
			$publications_successful = $this->admin_model->publications_insert();
			
			if($publications_successful){
				$this->session->set_flashdata("publications_successful","Publication Added successfully!");
				redirect('admin/home/publications_list');
			}else{
				$this->session->set_flashdata("publications_successful",$this->db->_error_message());
				redirect('admin/home/publications_list');
			}
		}
		$data['design_team'] = $this->admin_model->design_team();
		$data['teams'] = $this->admin_model->teams();
		$data['help_desk'] = $this->admin_model->help_desk();
		$data['ordering_system'] = $this->admin_model->ordering_system();
		$data['channels'] = $this->admin_model->channels();
		$data['group'] = $this->admin_model->group();
		$data['publications_list'] = $this->admin_model->publications_list();
		$data['slug_type'] = $this->db->query("SELECT * FROM `cat_slug_type` ORDER BY `name`")->result_array();
		$this->load->view('admin/publications_add',$data);
	}
	
	public function publications_edit($id='')
	{
		$publication = $this->db->get_where('publications',array('id' => $id))->row_array();
		if(isset($publication['id'])){
			$data['publication'] = $publication;
			if($id!='' && !empty($_POST['group_id'])&& !empty($_POST['name']) && !empty($_POST['design_team_id']))
			{
				$publications = $this->admin_model->publications_check($id);
				if($publications == '1'){
					$this->admin_model->publications_update($id);
					redirect('admin/home/publications_list');
				}else{
					$this->session->set_flashdata("publications_updated_successful","No Data Found for ID : $id ..!!");
					redirect('admin/home/publications_list');
				}
			}
			$data['business_groups'] = $this->admin_model->business_groups();
			$data['design_team'] = $this->admin_model->design_team();
			$data['teams'] = $this->admin_model->teams();
			$data['help_desk'] = $this->admin_model->help_desk();
			$data['ordering_system'] = $this->admin_model->ordering_system();
			$data['channels'] = $this->admin_model->channels();
			$data['group'] = $this->admin_model->group();
			$data['slug_type'] = $this->db->query("SELECT * FROM `cat_slug_type` ORDER BY `name`")->result_array();
			$this->load->view('admin/publications_edit', $data);
		}
	}
	
	public function designers_list()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['name']) && !empty($_POST['name']))
		{
			$_POST['password'] = MD5($_POST['password']);
			//$designers_successful = $this->admin_model->designers_insert();
			$this->db->insert('designers', $_POST);
			$designers_successful = $this->db->insert_id();
			if($designers_successful){
				$this->session->set_flashdata("designers_successful","Designer Added successfully with ID : ".$designers_successful);
				redirect('admin/home/designers_list');
			}else{
				$this->session->set_flashdata("designers_successful", $this->db->_error_message());
				redirect('admin/home/designers_list');
			}
		} 
		
		$data['team_lead'] = $this->admin_model->team_lead();
		$data['design_team'] = $this->admin_model->design_team();
		$data['designers_list'] = $this->admin_model->designers_list();
		$data['location'] = $this->admin_model->location();
		
		$this->load->view('admin/designers_list',$data);
	}
	
	public function designers_update($id)
	{
		if($id!='' && !empty($_POST['name'])){
			$designers_list = $this->admin_model->designers_check($id);
			if($designers_list == '1'){
				$this->admin_model->designers_update($id);
				redirect('admin/home/designers_list');
			}else{
				$this->session->set_flashdata("designers_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/designers_list');
			}
		} 
		redirect('admin/home/designers_list'); 
	}
	
	public function teamlead_list()
	{
		$this->load->helper(array('form', 'url'));
		//new entry
		if(isset($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['art_director']) && !empty($_POST['email_id']) && !empty($_POST['username']))
		{
			$_POST['password'] = MD5($_POST['password']);
			$teamlead_successful = $this->admin_model->teamlead_insert();
			if($teamlead_successful){
				$this->session->set_flashdata("teamlead_successful","TeamLead Added successfully!");
				redirect('admin/home/teamlead_list');
			}else{
				$this->session->set_flashdata("teamlead_successful",$this->db->_error_message());
				redirect('admin/home/teamlead_list');
			}
		}
		$data['team_lead'] = $this->admin_model->team_lead();
		$data['business_groups'] = $this->admin_model->business_groups();
		$data['location'] = $this->admin_model->location();
		$this->load->view('admin/teamlead_list',$data);
	}
	
	public function teamlead_update($id)
	{
		//update existing
		if($id!=''){
			$teamlead = $this->admin_model->teamlead_check($id);
			if($teamlead == '1'){
				$this->admin_model->teamlead_update($id);
				redirect('admin/home/teamlead_list');	
			}else{
				$this->session->set_flashdata("teamlead_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/teamlead_list');
			}
		} 
		redirect('admin/home/teamlead_list'); 
	}
	
	
	public function customers()
	{
		$this->load->helper(array('form', 'url'));
		//new entry
		if(isset($_POST['name']))
		{
			$customers_successful = $this->admin_model->customers_insert();
			if($customers_successful){
				$this->session->set_flashdata("customers_successful","Customer Added successfully!");
				redirect('admin/home/customers');
			}else{
				$this->session->set_flashdata("customers_successful",$this->db->_error_message());
				redirect('admin/home/customers');
			}
		}
		$data['customers'] = $this->admin_model->customers();
		$this->load->view('admin/customers',$data);
	}
	
	public function customers_update($id)
	{
		//update existing
		if($id!='' && isset($_POST['name'])){
			 $customers = $this->admin_model->customers_check($id);
			if($customers == '1'){
				$this->admin_model->customers_update($id);
				redirect('admin/home/customers');
			}else{
				$this->session->set_flashdata("customers_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/customers');
			}
		} 
		redirect('admin/home/customers'); 
	}
	
	public function new_adreps_list()
	{
		if(isset($_POST['send_mail']))
		{
		$adrep = $this->db->query("SELECT * FROM `adreps` WHERE `id`='".$_POST['id']."';")->result_array();	
		$to      = 'usha.rukmini18@gmail.com';
		$subject = 'New Username & Password';
		//$qDecoded->decryptIt($adrep[0]['password']);
		$message = 'Your Username & Password Username:'.$adrep[0]['username'].' & Password is '.$adrep[0]['password'].'';
		$headers = 'From: hello@example.com' . "\r\n" .
			'Reply-To: hello@example.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
       mail($to, $subject, $message, $headers);
		}
		$data['adreps'] = $this->admin_model->adreps();
		$this->load->view('admin/new_adreps_list',$data);
	}
	
	public function channels_list()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['name']) && !empty($_POST['display_report'])&& !empty($_POST['display_report_priority'])){
			$channels_successful = $this->admin_model->channels_insert();
			if($channels_successful){
				$this->session->set_flashdata("channels_successful","Channel Added successfully!");
				redirect('admin/home/channels_list');
			}else{
				$this->session->set_flashdata("channels_successful",$this->db->_error_message());
				redirect('admin/home/channels_list');
			}
		}
		$data['channels'] = $this->admin_model->channels();
		$this->load->view('admin/channels_list',$data);
	}
	
	public function channels_update($id)
	{
		if($id!='' && !empty($_POST['display_report'])&& !empty($_POST['display_report_priority']))
		{
			$channels = $this->admin_model->channels_check($id);
			if($channels == '1'){
				 $this->admin_model->channels_update($id);
				 redirect('admin/home/channels_list');
			}else{
				$this->session->set_flashdata("channels_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/channels_list');
			}
		} 
		redirect('admin/home/channels_list'); 
	}
	
	
	public function designteams_list()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['name']) && !empty($_POST['email_id'])&& !empty($_POST['newad_template'])){
			$designteams_successful = $this->admin_model->designteams_insert();
			if($designteams_successful){
				$this->session->set_flashdata("designteams_successful","Channel Added successfully!");
				redirect('admin/home/designteams_list');
			}else{
				$this->session->set_flashdata("designteams_successful",$this->db->_error_message());
				redirect('admin/home/designteams_list');
			}
		}
		$data['design_team'] = $this->admin_model->design_team();
		$this->load->view('admin/designteams_list',$data);
	}
	
	public function designteams_update($id)
	{
		if($id!='' && !empty($_POST['email_id'])&& !empty($_POST['newad_template']))
		{
			$designteams = $this->admin_model->designteams_check($id);
			if($designteams == '1'){
				$this->admin_model->designteams_update($id);
				redirect('admin/home/designteams_list');
			}else{
				$this->session->set_flashdata("designteams_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/designteams_list');
			}
		} 
		redirect('admin/home/designteams_list'); 
	}
	
	public function help_desk()
	{
		 $this->load->helper(array('form', 'url'));
		
		if(isset($_POST['name']) && !empty($_POST['d_name'])&& !empty($_POST['team'])){
			$hd_successful = $this->admin_model->help_desk_insert();
			if($hd_successful){
				$this->session->set_flashdata("hd_successful","Help Desk Added successfully!");
				redirect('admin/home/help_desk');
			}else{
				$this->session->set_flashdata("hd_successful", $this->db->_error_message());
				redirect('admin/home/help_desk');
			}
		} 
		$data['help_desk'] = $this->admin_model->help_desk();
		$data['teams'] = $this->admin_model->teams();
		$this->load->view('admin/help_desk',$data);
	}
	
	public function help_desk_update($id)
	{
		if($id!='' && !empty($_POST['d_name'])&& !empty($_POST['team']))
		{
			$help_desk = $this->admin_model->help_desk_check($id);
			if($help_desk == '1'){
				$this->admin_model->help_desk_update($id);
				redirect('admin/home/help_desk');
			}else{
				$this->session->set_flashdata("hd_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/help_desk');
			}
		} 
		redirect('admin/home/help_desk'); 
	}
	
	public function art_director_list()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['gender']) && !empty($_POST['business_group_id']) && !empty($_POST['email_id'])){
			$_POST['password'] = MD5($_POST['password']);
			$art_director_successful = $this->admin_model->art_director_insert();
			if($art_director_successful){
				$this->session->set_flashdata("art_director_successful","Art Director Added successfully!");
				redirect('admin/home/art_director_list');
			}else{
				$this->session->set_flashdata("art_director_successful", $this->db->_error_message());
				redirect('admin/home/art_director_list');
			}
		} 
		$data['art_director'] = $this->admin_model->art_director();
		$data['business_groups'] = $this->admin_model->business_groups();
		$data['location'] = $this->admin_model->location();
		$this->load->view('admin/art_director_list',$data);
	}
	
	public function art_director_update($id)
	{
		if($id!='')
		{
			$art_director = $this->admin_model->art_director_check($id);
			if($art_director == '1'){
				$this->admin_model->art_director_update($id);
					redirect('admin/home/art_director_list');
			}else{
				$this->session->set_flashdata("art_director_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/art_director_list');
			}
		} else{ echo"<script>alert('no values posted')</script>"; }
		redirect('admin/home/art_director_list'); 
	}
	
	public function bg_head()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email_id']) && !empty($_POST['username']) && !empty($_POST['password']))
		{
			$_POST['password'] = MD5($_POST['password']);
			$bg_head_successful = $this->admin_model->bg_head_insert();
			if($bg_head_successful){
				$this->session->set_flashdata("bg_head_successful","BG Head Added successfully!");
				redirect('admin/home/bg_head');
			}else{
				$this->session->set_flashdata("bg_head_successful", $this->db->_error_message());
				redirect('admin/home/bg_head');
			}
		} 
		$data['location'] = $this->admin_model->location();
		$data['bg_head'] = $this->admin_model->bg_head();
		$data['business_groups'] = $this->admin_model->business_groups();
		$this->load->view('admin/bg_head',$data);
	}
	
	public function bg_head_update($id)
	{
		if($id!='')
		{
			$bg_head = $this->admin_model->bg_head_check($id);
			if($bg_head == '1'){
				$this->admin_model->bg_head_update($id);
				redirect('admin/home/bg_head');	
			}else{
				$this->session->set_flashdata("bg_head_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/bg_head');
			}
		} else{ echo"<script>alert('no values posted')</script>"; }
		redirect('admin/home/bg_head'); 
	}
	
	public function csr_list()
	{
		$this->load->helper(array('form', 'url'));
		
		if(isset($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email_id']) && !empty($_POST['business_group_id']) && !empty($_POST['password'])){
			$_POST['password'] = MD5($_POST['password']);
			$csr_successful = $this->admin_model->csr_insert();
			if($csr_successful){
				$this->session->set_flashdata("csr_successful","CSR Added successfully!");
				redirect('admin/home/csr_list');
			}else{
				$this->session->set_flashdata("csr_successful", $this->db->_error_message());
				redirect('admin/home/csr_list');
			}
		} 
		$data['business_groups'] = $this->admin_model->business_groups();
		$data['csr'] = $this->admin_model->csr();
		$data['location'] = $this->admin_model->location();
		$this->load->view('admin/csr_list',$data);
	}
	
	public function csr_update($id)
	{
		if($id!='')
		{
			//$_POST['password'] = MD5($_POST['password']);
			$csr_head = $this->admin_model->csr_check($id);
			if($csr_head == '1'){
				$this->admin_model->csr_update($id);
				redirect('admin/home/csr_list');
			}else{
				$this->session->set_flashdata("csr_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/csr_list');
			}
		} else{ echo"<script>alert('no values posted')</script>"; }
		redirect('admin/home/csr_list'); 
	}
	
	public function management_list()
	{
		if(isset($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['Join_location']) && !empty($_POST['Work_location'])){
			$_POST['password'] = MD5($_POST['password']);
			$management_successful = $this->admin_model->management_insert();
			if($management_successful){
				$this->session->set_flashdata("management_successful","Management Added successfully!");
				redirect('admin/home/management_list');
			}else{
				$this->session->set_flashdata("management_successful", $this->db->_error_message());
				redirect('admin/home/management_list');
			}
		} 
		$data['location'] = $this->admin_model->location();
		$data['management'] = $this->admin_model->management();
		$this->load->view('admin/management_list',$data);
	}
	
	public function management_update($id)
	{
		if($id!='')
		{
			$management = $this->admin_model->management_check($id);
			if($management == '1'){
				$this->admin_model->management_update($id);
				redirect('admin/home/management_list');
			}else{
				$this->session->set_flashdata("management_updated_successful","No Data Found for ID : $id ..!!");
				redirect('admin/home/management_list');
			}
		} else{ echo"<script>alert('no values posted')</script>"; }
		redirect('admin/home/management_list'); 
	}

	public function notification_list()
	{
		$data['notification'] = $this->admin_model->notification();
		$this->load->view('admin/notification_list',$data);
	}
	
	public function notification_add()
	{
		if(isset($_POST['headline']) && !empty($_POST['message']) && !empty($_POST['users']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['job_status'])){
			$successful = $this->admin_model->notify_insert();
			if($successful){
				$this->session->set_flashdata("successful","Notification Added successfully!");
				redirect('admin/home/notification_list');
			}else{
				$this->session->set_flashdata("successful", $this->db->_error_message());
				redirect('admin/home/notification_list');
			}
		} 
		$data['adwit_users'] = $this->admin_model->adwit_users();
		$this->load->view('admin/notification_add',$data);
	}
	

	public function notification_edit($id='')
	{
		if($id!='')
		{
			if(isset($_POST['headline']) && !empty($_POST['message']))
			{
				$notification_edit = $this->admin_model->notification_check($id);
				if($notification_edit == '1'){
					$this->admin_model->notification_update($id);
					redirect('admin/home/notification_list');
				}else{
					$this->session->set_flashdata("updated_successful","No Data Found for ID : $id ..!!");
					redirect('admin/home/notification_list');
				}
			}
			$notification= $this->db->get_where('notification',array('id'=>$id))->result_array();
			$data['row'] = $notification[0];
			$data['adwit_users'] = $this->admin_model->adwit_users();
			$this->load->view('admin/notification_edit',$data);
		}
	}
	
	public function notification_new($display_type='')
	{
		$data['display_type'] = $display_type;
		if(isset($_POST['submit']) && isset($_POST['display_type']) && !empty($_POST['headline']) && !empty($_POST['message']))
		{ //echo $_POST['aId'][0];
			$successful = $this->admin_model->notification_insert($display_type);
			if($successful){
				$this->session->set_flashdata("successful","Notification Added successfully!");
				redirect('admin/home/notification_new');
			}else{
				$this->session->set_flashdata("successful", $this->db->_error_message());
				redirect('admin/home/notification_new');
			}	
	   }
		$adrep = $this->db->query("select * from `adreps` where `is_active` = '1'")->result_array();
		$publication = $this->db->query("select * from `publications` where `is_active` = '1'")->result_array();
		$data['adrep'] = $adrep;	
		$data['publication'] = $publication;
		$this->load->view('admin/notification_new',$data);	
	}
	
	public function delete_downloads()
	{
		$this->load->view('admin/delete_downloads');
	}
	
	public function dochange()
	{
		$this->db->query("Update admin_users set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('admin')."' or username='".$this->session->userdata('admin')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->change('Your password has been changed successfully!', 'darkgreen');
		else
			$this->change('Invalid current password!', 'darkred');
	}
		
	public function corporate()
	{
		$ad_user = "AD Reps";
		$ad_count = $this->db->count_all('adreps');
		$ad_users = $this->db->get('adreps');
		/*
		$ad_users1 = $this->db->get_where('adreps',array('publication_id' => 1))->result_array();
		$ad_users2 = $this->db->get_where('adreps',array('publication_id' => 2))->result_array();
		$ad_users3 = $this->db->get_where('adreps',array('publication_id' => 3))->result_array();
		$ad_users9 = $this->db->get_where('adreps',array('publication_id' => 9))->result_array();
		$ad_users10 = $this->db->get_where('adreps',array('publication_id' => 10))->result_array();
		$ad_users12 = $this->db->get_where('adreps',array('publication_id' => 12))->result_array();
		$ad_users14 = $this->db->get_where('adreps',array('publication_id' => 14))->result_array();
		$ad_users15 = $this->db->get_where('adreps',array('publication_id' => 15))->result_array();
		*/
		$data['ad_count'] = $ad_count;
		$data['ad_users'] = $ad_users;
		/*
		$data['ad_users1'] = $ad_users1;
		$data['ad_users2'] = $ad_users2;
		$data['ad_users3'] = $ad_users3;
		$data['ad_users9'] = $ad_users9;
		$data['ad_users10'] = $ad_users10;
		$data['ad_users12'] = $ad_users12;
		$data['ad_users14'] = $ad_users14;
		$data['ad_users15'] = $ad_users15;
		*/
		$data['ad_user'] = $ad_user;
		
		$pub_user = "Publication";
		$pub_count = $this->db->count_all('publications');
		$pub_users = $this->db->get('publications')->result_array();;
		
		$data['pub_count'] = $pub_count;
		$data['pub_users'] = $pub_users;
		$data['pub_user'] = $pub_user;
		
		$this->load->view('admin/corporate',$data);
	}
	
	public function atypeads()
	{
		$atype_user = "A Typeads";
		$atype_count = $this->db->count_all('orders');
		$atype_users = $this->db->get('orders');
		$atype_users1 = $this->db->get_where('orders',array('order_type_id' => 1))->result_array();
		$atype_users2 = $this->db->get_where('orders',array('order_type_id' => 2))->result_array();
		$atype_users3 = $this->db->get_where('orders',array('order_type_id' => 3))->result_array();
		$atype_users4 = $this->db->get_where('orders',array('order_type_id' => 4))->result_array();
		
		$data['atype_count'] = $atype_count;
		$data['atype_users'] = $atype_users;
		$data['atype_users1'] = $atype_users1;
		$data['atype_users2'] = $atype_users2;
		$data['atype_users3'] = $atype_users3;
		$data['atype_users4'] = $atype_users4;
		$data['atype_user'] = $atype_user;
		
		$this->load->view('admin/a-type-ads',$data);
	}
	
	public function atypecat()
	{
		$atcat_user = "Type Category";
		$atcat_count = $this->db->count_all('cat_result');
		$atcat_users = $this->db->get('cat_result');
		$atcat_users2 = $this->db->get_where('cat_result',array('category' => 'D'))->result_array();
		$atcat_users3 = $this->db->get_where('cat_result',array('category' => 'E'))->result_array();
		
		$data['atcat_count'] = $atcat_count;
		$data['atcat_users'] = $atcat_users;
		$data['atcat_user'] = $atcat_user;
		$data['atcat_users2'] = $atcat_users2;
		$data['atcat_users3'] = $atcat_users3;
		
		$this->load->view('admin/atypecat',$data);
	}
		
	public function adwitusers()
	{
		$ad_user = "AD Reps";
		$ad_count = $this->db->count_all('adreps');
		$ad_users = $this->db->get('adreps');
		
		$data['ad_count'] = $ad_count;
		$data['ad_users'] = $ad_users;
		$data['ad_user'] = $ad_user;
		
		$pub_user = "Publication";
		$pub_count = $this->db->count_all('publications');
		$pub_users = $this->db->get('publications');
		
		$data['pub_count'] = $pub_count;
		$data['pub_users'] = $pub_users;
		$data['pub_user'] = $pub_user;
		
		$a_user = "Art Director";
		$a_count = $this->db->count_all('art_director');
		$a_users = $this->db->get('art_director');
		
		$data['a_count'] = $a_count;
		$data['a_users'] = $a_users;
		$data['a_user'] = $a_user;
	
		$b_user = "BG Head";
		$b_count = $this->db->count_all('bg_head');
		$b_users = $this->db->get('bg_head');
		
		$data['b_count'] = $b_count;
		$data['b_users'] = $b_users;
		$data['b_user'] = $b_user;
	
		$t_user = "Team Lead";
		$t_count = $this->db->count_all('team_lead');
		$t_users = $this->db->get('team_lead');
		
		$data['t_count'] = $t_count;
		$data['t_users'] = $t_users;
		$data['t_user'] = $t_user;
	
		$c_user = "CSR";
		$c_count = $this->db->count_all('csr');
		$c_users = $this->db->get('csr');
		
		$data['c_count'] = $c_count;
		$data['c_users'] = $c_users;
		$data['c_user'] = $c_user;
	
		$dt_user = "Design Teams";
		$dt_count = $this->db->count_all('design_teams');
		$dt_users = $this->db->get('design_teams');
		
		$data['dt_count'] = $dt_count;
		$data['dt_users'] = $dt_users;
		$data['dt_user'] = $dt_user;
	
		$d_user = "Designers";
		$d_count = $this->db->count_all('designers');
		$d_users = $this->db->get('designers');
		
		$data['d_count'] = $d_count;
		$data['d_users'] = $d_users;
		$data['d_user'] = $d_user;
		
		$total_users = $a_count + $b_count + $c_count + $dt_count + $t_count + $d_count;
		$data['total_users'] = $total_users;
		$this->load->view('admin/adwitusers',$data);
	}
	
	public function DP_report()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			
			$data['from'] = $from;
			$data['to'] = $to;
		//	echo $from;
		//	exit;
		}
		$designer = $this->db->get('designers')->result_array();
		$prev_month = date("Y-m", strtotime("-1 month"));
		$data['prev_month'] = $prev_month;
		$data['designer'] = $designer;
		
		$this->load->view('admin/DP-report',$data);
	}
		
	public function QA_report()
	{ 
	
		$this->load->view('admin/QA-report');
	}
	
	public function Designer_production01()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array() ;
		
		$data['designer'] = $designer;
		
		$data['today'] = date("Y-m-d");
	
		$this->load->view('admin/Designer-production',$data);
	}

	public function Designer_Production()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('Asia/Calcutta');
		}
		$today = date('Y-m-d');
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
		}
		$designer = $this->db->get('designers')->result_array() ;
		$data['designer'] = $designer;
		$data['today'] = $today;
		$this->load->view('admin/Designer-production',$data);
	}
	
	public function Designer_Production_table()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('Asia/Calcutta');
		}
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			//$result = $this->db->query("SELECT * FROM `Designer_Production` WHERE `date` BETWEEN '$from' AND '$to' ;")->result_array();
			 
		}
			//$result = $this->db->get_where('Designer_Production',array('date' => $ystday))->result_array();
		$designer = $this->db->get('designers')->result_array() ;
		$data['designer'] = $designer;
		$data['ystday'] = $ystday;
		$this->load->view('admin/Designer-production-table',$data);
	}	
	
	public function job_status($display_type='')
	{
		$data['display_type'] = $display_type;
		$today = date('Y-m-d');
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$pystday = date('Y-m-d', strtotime(' -2 day'));
		
		$data['cat_id'] = $this->db->query("SELECT * FROM `cat_result` WHERE `timestamp` BETWEEN '$ystday' AND '$today' ;")->result_array();			
		$data['today'] = $today;
		$data['ystday'] = $ystday;
		$data['pystday'] = $pystday;
		
		/*if($display_type=='pending')
		{
			$this->load->view('admin/job-status-pending',$data);
		}elseif($display_type=='sent'){
			$this->load->view('admin/job-status-sent',$data);
		}else{
			$this->load->view('admin/job-status-all',$data);
		}*/
		$this->load->view('admin/job_status',$data);
	}
	
	/*public function job_statusdemo($display_type='all')
	{
		$data['display_type'] = $display_type;
		$today = date('Y-m-d'); $data['today'] = $today;
		$ystday = date('Y-m-d', strtotime(' -1 day')); $data['ystday'] = $ystday;
		$pystday = date('Y-m-d', strtotime(' -2 day')); $data['pystday'] = $pystday;
		
		$data['cat_id'] = $this->db->query("SELECT * FROM `cat_result` WHERE `timestamp` BETWEEN '$ystday' AND '$today' ;")->result_array();			
		
		$this->load->view('admin/job_status',$data);
	}*/
	
	public function Designer_nosnj()
	{	
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array() ;
		
		$data['designer'] = $designer;
		
		$data['today'] = date("Y-m-d");
		
		$this->load->view('admin/Designer-nosnj',$data);
	}
		
	public function Designer_QA_Production()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array() ;
		
		$data['designer'] = $designer;
		
		$data['today'] = date("Y-m-d");
	
		$this->load->view('admin/Designer-production',$data);
	}
			
	public function notification()
	{
		if(isset($_POST['headline']))
		{
			if(!empty($_POST['users']))
			{
				if (function_exists('date_default_timezone_set'))
				{
				  date_default_timezone_set('Asia/Calcutta');
				}
				foreach($_POST['users'] as $row)
				{
					$data = array(
									'headline' => $_POST['headline'],
									'message' => $_POST['message'], 
									'users' => $row,
									'start_date' => $_POST['start_date'],
									'end_date' => $_POST['end_date'],
									//'time' => date("His"),
									'job_status' => '1'
									);
					if($this->db->insert('notification', $data)){
						$this->session->set_flashdata('message','Notification Sent Sucessfully!!');
						redirect('admin/home/notification');
					}
				}
			}
		}
		$this->load->view('admin/notification');
	}
		
	public function frontline($form = '')
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			if($form == 'all')
			{
				$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `time_taken`!='0' AND `job_status`='1' AND `date` BETWEEN '$from' AND '$to';")->result_array();			 
			}else{
				$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `time_taken`!='0' AND `job_status`='1' AND `category`='$form' AND `date` BETWEEN '$from' AND '$to';")->result_array();			 
			}
		}else{
			$today = date("Y-m-d");
			if($form == 'all')
			{
				$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `date` = '$today' AND  `time_taken`!='0' AND `job_status`='1' ;")->result_array();
			}else{
				$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `date` = '$today' AND  `time_taken`!='0' AND `job_status`='1' AND `category`='$form';")->result_array();
			}
			$data['today'] = $today;
		}
		
		$data['form'] = $form;
		
		if($form == 'sold' )
		{ $this->load->view('admin/frontline-sold', $data); }
		elseif($form == 'fastrack'){
			$this->load->view('admin/frontline-fastrack', $data);			
		}elseif($form == 'new'){
			$this->load->view('admin/frontline-new', $data);			
		}else{
		$this->load->view('admin/frontline-report', $data);
		}
	}
		
	public function performance_pay()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
		}
		$designer = $this->db->get('designers')->result_array() ;
		
		$data['designer'] = $designer;
		
		$data['today'] = date("Y-m-d");
	
		$this->load->view('admin/performance-pay',$data);
	}
	
	public function csr_performance_table()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		//$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$data['csr'] = $this->db->get_where('csr',array('is_active'=>'1'))->result_array();
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('admin/csr-performance-table',$data );
	}
	
	public function csr_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		//$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$data['csr'] = $this->db->get('csr')->result_array();
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('admin/csr-performance',$data );
	}
	
	public function incoming_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		
		$data['csr'] = $this->db->get('csr')->result_array();
		$data['today'] = date('Y-m-d');
		$this->load->view('admin/incoming-performance',$data );
	}
	
	public function outgoing_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		
		$data['csr'] = $this->db->get('csr')->result_array();
		$data['today'] = date('Y-m-d');
		$this->load->view('admin/outgoing-performance',$data );
	}
	
	public function QA_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		
		$data['csr'] = $this->db->get('csr')->result_array();
		$data['today'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('admin/QA-performance',$data );
	}
	
	public function bill_report($form = '')
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_id'])){
				$temp = array();
				$temp = explode(",", $_POST['order_id']);
				$count = count($temp);
				$clause = " WHERE (";//Initial clause
				$sql="SELECT * FROM `orders`  ";//Query stub
				for($i=0; $i<$count; $i++){
					$c = $temp[$i];	
					$sql .= $clause."`id` = '$c'";
					$clause = " OR ";//Change  to OR after 1st WHERE
				}
				$sql = $sql.')';//echo $sql;
				$data['search_orders'] = $this->db->query("$sql;")->result_array();
		}elseif($form!='')
		{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['orders'] = $this->db->query("SELECT  * FROM `orders` WHERE `publication_id`='$form' AND `pdf`!='none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$data['orders'] = $this->db->query("SELECT  * FROM `orders` WHERE `publication_id`='$form' AND `pdf`!='none' AND `created_on` LIKE '$today%';")->result_array();
				$data['today'] = $today;
			}
			$data['form'] = $form;
		}
		$this->load->view('admin/bill-view',$data);
	}
	 
	public function bill_report_helpdesk($form = '')
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_id'])){
				$temp = array();
				$temp = explode(",", $_POST['order_id']);
				$count = count($temp);
				$clause = " WHERE (";//Initial clause
				$sql="SELECT * FROM `orders`  ";//Query stub
				for($i=0; $i<$count; $i++){
					$c = $temp[$i];	
					$sql .= $clause."`id` = '$c'";
					$clause = " OR ";//Change  to OR after 1st WHERE
				}
				$sql = $sql.')';//echo $sql;
				$data['search_orders'] = $this->db->query("$sql;")->result_array();
		}elseif($form!='')
		{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['orders'] = $this->db->query("SELECT  * FROM `orders` WHERE `help_desk`='$form' AND `pdf`!='none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$data['orders'] = $this->db->query("SELECT  * FROM `orders` WHERE `help_desk`='$form' AND `pdf`!='none' AND `created_on` LIKE '$today%';")->result_array();
				$data['today'] = $today;
			}
			$data['form'] = $form;
		}
		$this->load->view('admin/bill_help_desk',$data);
	}
	
	public function bill_grp_report($form = '')
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_id'])){
				$temp = array();
				$temp = explode(",", $_POST['order_id']);
				$count = count($temp);
				$clause = " WHERE (";//Initial clause
				$sql="SELECT * FROM `orders`  ";//Query stub
				for($i=0; $i<$count; $i++){
					$c = $temp[$i];	
					$sql .= $clause."`id` = '$c'";
					$clause = " OR ";//Change  to OR after 1st WHERE
				}
				$sql = $sql.')';//echo $sql;
				$data['search_orders'] = $this->db->query("$sql;")->result_array();
		}elseif($form!='')
		{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$data['from'] = $_POST['from_date'];
				$data['to'] = $_POST['to_date'];
			}else{
				$today = date('Y-m-d');
				$data['today'] = $today;
			}
			$data['grp_pub'] = $this->db->get_where('publications',array('group_id' => $form))->result_array();
			$data['form'] = $form;
		}
		$this->load->view('admin/bill-grp-view',$data);
	}
	public function billing_revision_report($form = '')
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_id'])){
				$temp = array();
				$temp = explode(",", $_POST['order_id']);
				$count = count($temp);
				$clause = " WHERE (";//Initial clause
				$sql="SELECT * FROM `rev_sold_jobs`  ";//Query stub
				for($i=0; $i<$count; $i++){
					$c = $temp[$i];	
					$sql .= $clause."`order_id` = '$c'";
					$clause = " OR ";//Change  to OR after 1st WHERE
				} 
				$sql = $sql.')';//echo $sql;
				$data['search_orders'] = $this->db->query("$sql;")->result_array();
		}elseif($form!=''){
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['rev_orders'] = $this->db->query("SELECT  * FROM `rev_sold_jobs` WHERE `help_desk`='$form' AND `pdf_path`!='none' AND `date` BETWEEN '$from' AND '$to' ;")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$data['rev_orders'] = $this->db->query("SELECT  * FROM `rev_sold_jobs` WHERE `help_desk`='$form' AND `pdf_path`!='none' AND `date`='$today';")->result_array();
				$data['today'] = $today;
			}
			$data['form'] = $form;
		}
		$this->load->view('admin/billing_revision_report',$data);
	}
	 
	public function helpdesk_hourly_report($form = '')
	{
		$data['hi'] = 'hello';
		if($form != ''){
			$data['form'] = $form;
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date']; //start date
				$to = $_POST['to_date']; //end date
				
				$data['from'] = $from;
				$data['to'] = $to;
			
				$dates = array();
				$from = $current = strtotime($from);
				$to = strtotime($to);

				while ($current <= $to) {
				$dates[] = date('Y-m-d', $current);
				$current = strtotime('+1 days', $current);
				}
				$data['dates'] = $dates;
				
			}else{
				$dates[] = date('Y-m-d');
				$data['dates'] = $dates;
			
			}
		}
		$this->load->view('admin/helpdesk_hourly_report',$data);
	}	
	
	public function newads_hourly_report($form = '')
	{
		$data['hi'] = 'hello';
		if($form != ''){
			$data['form'] = $form;
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date']; //start date
				$to = $_POST['to_date']; //end date
				
				$data['from'] = $from;
				$data['to'] = $to;
			
				$dates = array();
				$from = $current = strtotime($from);
				$to = strtotime($to);

				while ($current <= $to) {
				$dates[] = date('Y-m-d', $current);
				$current = strtotime('+1 days', $current);
				}
				$data['dates'] = $dates;
				
			}else{
				$dates[] = date('Y-m-d');
				$data['dates'] = $dates;
			
			}
		}
		$this->load->view('admin/newads_hourly_report',$data);
	}	
	
	public function web_bill_report()
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_id'])){
				$temp = array();
				$temp = explode(",", $_POST['order_id']);
				$count = count($temp);
				$clause = " WHERE `order_type_id`='1' AND(";//Initial clause
				$sql="SELECT * FROM `orders`  ";//Query stub
				for($i=0; $i<$count; $i++){
					$c = $temp[$i];	
					$sql .= $clause."`id` = '$c'";
					$clause = " OR ";//Change  to OR after 1st WHERE
				}
				$sql = $sql.')';//echo $sql;
				$data['orders'] = $this->db->query("$sql;")->result_array();
		}else{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['orders'] = $this->db->query("SELECT  * FROM `orders` WHERE `order_type_id`='1' AND `pdf`!='none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$data['orders'] = $this->db->query("SELECT  * FROM `orders` WHERE `order_type_id`='1' AND `pdf`!='none' AND `created_on` LIKE '$today%';")->result_array();
				$data['today'] = $today;
			}
			//$data['form'] = $form;
		}
		$this->load->view('admin/web-bill-view',$data);
	}
	
	public function web_soft_report()
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']) && !empty($_POST['order_id'])){
				$temp = array();
				$temp = explode(",", $_POST['order_id']);
				$count = count($temp);
				$clause = " WHERE `web_ad_type`!='0' AND(";//Initial clause
				$sql="SELECT * FROM `soft_orders`  ";//Query stub
				for($i=0; $i<$count; $i++){
					$c = $temp[$i];	
					$sql .= $clause."`id` = '$c'";
					$clause = " OR ";//Change  to OR after 1st WHERE
				}
				$sql = $sql.')';//echo $sql;
				$data['orders'] = $this->db->query("$sql;")->result_array();
		}else{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['orders'] = $this->db->query("SELECT  * FROM `soft_orders` WHERE `web_ad_type`!='0' AND `approve`='1' AND `timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$data['orders'] = $this->db->query("SELECT  * FROM `soft_orders` WHERE `web_ad_type`!='0' AND `approve`='1' AND `timestamp` LIKE '$today%';")->result_array();
				$data['today'] = $today;
			}
			//$data['form'] = $form;
		}
		$this->load->view('admin/web_soft_report',$data);
	}
	
	public function soft_publication()
	{
		//$data['publication'] = $this->db->get('soft_publications')->result_array();
		$data['publication'] = $this->db->query('SELECT  soft_publications.id, soft_publications.name AS spname, soft_publications.adwit_publication_id, publications.name AS pname  
							FROM soft_publications 
								left outer join publications on soft_publications.adwit_publication_id = publications.id ;')->result_array();
		$this->load->view('admin/soft_publication', $data);
	}
	
	public function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
        }
	
	public function new_adreps()
	{
	    if(isset($_POST['sent_mail']))
		{
		$adrep = $this->db->query("SELECT * FROM `adreps` WHERE `id`='".$_POST['id']."';")->result_array();	
		$to      = 'jdpgupta4@gmail.com';
		$subject = 'New Username & Password';
		//$qDecoded->decryptIt($adrep[0]['password']);
		$message = 'Your Username & Password Username:'.$adrep[0]['username'].' & Password is '.$adrep[0]['password'].'';
		$headers = 'From: hello@example.com' . "\r\n" .
			'Reply-To: hello@example.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
       mail($to, $subject, $message, $headers);
		}
		$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active`='1';")->result_array();			 
        $this->load->view('admin/new_adreps' , $data);
	
	}
	
	public function add_soft_publication() 
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			
			$this->form_validation->set_rules('business_group_id', 'Business Group', 'trim|required');

			$this->form_validation->set_rules('name', 'Publication Name', 'trim|max_length[100]|required');
			
			$this->form_validation->set_rules('advertising_director_email_id', 'Advertising Director', 'trim|required|valid_email');
			
			$this->form_validation->set_rules('design_team_id', 'Design Team', 'trim|required');
			
			$this->form_validation->set_rules('team_lead_id', 'Team Lead', 'trim|required|is_numeric');
			
			$this->form_validation->set_rules('spec_ads', 'Spec ads', 'trim');
			
			$this->form_validation->set_rules('sold_ads', 'Sold ads', 'trim');
			
			$this->form_validation->set_rules('slug_type', 'Slug type', 'trim|required');
			
			$this->form_validation->set_rules('news_id', 'News id', 'trim|required|is_numeric');
			
			$this->form_validation->set_rules('initial', 'Initial', 'trim|required');
			
			$this->form_validation->set_rules('help_desk', 'Help desk', 'trim|required');
			
			$this->form_validation->set_rules('ordering_system', 'Ordering system', 'trim');
			
			$this->form_validation->set_rules('channel', 'Channel ', 'trim|required');
			
			$this->form_validation->set_rules('time_zone_id', 'Time Zone', 'trim');

			$this->form_validation->set_rules('city', 'City ', 'trim');
			
		$data['help_desk'] = $this->db->get_where('help_desk',array('active'=>'1'))->result_array();
		$data['ordering_system'] = $this->db->get('ordering_system')->result_array();
		$data['channel'] = $this->db->get('channels')->result_array();
		$data['time_zone'] = $this->db->get('gmt')->result_array();
		$data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
		$data['tl'] = $this->db->get('team_lead')->result_array();
		$data['dt'] = $this->db->get('design_teams')->result_array();
		$data['bg'] = $this->db->get('business_groups')->result_array();
		if($this->form_validation->run() == FALSE){
			$this->load->view('admin/add_soft_publication', $data);
		}else{
			$this->db->insert('publications', $_POST);
			$id=$this->db->insert_id();
			if($id){
				$post = array('name' => $_POST['name'], 'adwit_publication_id' => $id);
				$this->db->insert('soft_publications', $post);
				
				$this->session->set_flashdata("message","A New Publication Added Sucessfully!");
				redirect('admin/home/soft_publication');
			}else{
				$this->session->set_flashdata("message","Internal Error.. Data Not Submitted.. Try Again!");
				redirect('admin/home/add_soft_publication');
			}
		}
	}

	public function soft_adrep()
	{
		//$data['adrep'] = $this->db->get('soft_users')->result_array();
		$data['adrep'] = $this->db->query('SELECT  soft_users.id, soft_users.first_name AS sname, soft_users.adwit_adrep_id, soft_users.publication, adreps.first_name AS aname  
							FROM soft_users 
								left outer join adreps on soft_users.adwit_adrep_id = adreps.id ;')->result_array();
		$this->load->view('admin/soft_adrep', $data);
	}
	
	public function add_soft_adrep() 
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
			
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');

			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[100]|required');
			
			$this->form_validation->set_rules('publication_id', 'Publication', 'trim|required');
						
			$this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email');
			
			//$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
						
			$this->form_validation->set_rules('username', 'User Name', 'trim|required');
			
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			
			$this->form_validation->set_rules('phone_1', 'Phone Number-1', 'trim|is_numeric');
			
			$this->form_validation->set_rules('phone_2', 'Phone Number-2', 'trim|is_numeric');
			
			$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|is_numeric');
			
		$data['soft_publications'] = $this->db->get('soft_publications')->result_array();
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('admin/add_soft_adrep', $data);
		}else{
			$_POST['password'] = MD5($_POST['password']);
			$this->db->insert('adreps', $_POST);
			$id=$this->db->insert_id();
			if($id){
				$post = array('adwit_adrep_id' => $id,
							  'first_name' => $_POST['first_name'],
							  'last_name' => $_POST['last_name'], 
							  'publication' => $_POST['publication_id'], 
							  'email_id' => $_POST['email_id'],
							  'username' => $_POST['username'],
							  'password' => $_POST['password'],
							);
				$this->db->insert('soft_users', $post);
				
				$this->session->set_flashdata("message","A New Adrep Added Sucessfully!");
				redirect('admin/home/soft_adrep');
			}else{
				$this->session->set_flashdata("message","Internal Error.. Data Not Submitted.. Try Again!");
				redirect('admin/home/add_soft_adrep');
			} 
		}
	}
	
	public function designer_team_assign()
	{
		//Delete
		if(isset($_POST['delete'])){ $this->db->delete('designer_assign', array('id' => $_POST['id']));  }
		//team search
		if(isset($_POST['team_search'])  || isset($_POST['tId'])){
			if(isset($_POST['tId'])){ $tId = $_POST['tId']; }else{ $tId = $_POST['team']; }
				$data['tId'] = $tId;
				$data['list1'] = $this->db->get_where('designer_assign', array('team_id' => $tId))->result_array();
		}
		//designer search
		if(isset($_POST['designer_search']) || isset($_POST['dId'])){
			if(isset($_POST['dId'])){ $dId = $_POST['dId']; }else{ $dId = $_POST['designer']; }
				$data['dId'] = $dId;
				$data['list2'] = $this->db->get_where('designer_assign', array('designer_id' => $dId))->result_array();
		}
		//assign
		if(isset($_POST['submit']) && !empty($_POST['designer']) && !empty($_POST['team'])){
			$dId = $_POST['designer'];
			$tId = $_POST['team'];
			$check = $this->db->get_where('designer_assign', array('designer_id' => $dId, 'team_id' => $tId))->result_array();
			if($check){
				$this->session->set_flashdata("message","Designer already assigned to the Team!!");
				redirect('admin/home/designer_team_assign');
			}else{
				$post = array('designer_id' => $dId, 'team_id' => $tId);
				$this->db->insert('designer_assign', $post);
				$this->session->set_flashdata("message","Sucessful!!");
				redirect('admin/home/designer_team_assign');
			}
		}
		$data['designers'] = $this->db->get_where('designers',array('is_active'=>'1'))->result_array();
		$data['teams'] = $this->db->get('teams')->result_array();
		$this->load->view('admin/designer_team_assign', $data);
	}
	
	public function teamlead_team_assign()
	{
		//Delete
		if(isset($_POST['delete'])){ $this->db->delete('team_lead_assign', array('id' => $_POST['id']));  }
		//team search
		if(isset($_POST['team_search'])  || isset($_POST['tId'])){
			if(isset($_POST['tId'])){ $tId = $_POST['tId']; }else{ $tId = $_POST['team']; }
				$data['tId'] = $tId;
				$data['list1'] = $this->db->get_where('team_lead_assign', array('team_id' => $tId))->result_array();
		}
		//team_lead_assign search
		if(isset($_POST['teamlead_search']) || isset($_POST['dId'])){
			if(isset($_POST['dId'])){ $dId = $_POST['dId']; }else{ $dId = $_POST['team_lead']; }
				$data['dId'] = $dId;
				$data['list2'] = $this->db->get_where('team_lead_assign', array('team_lead_id' => $dId))->result_array();
		}
		//assign
		if(isset($_POST['submit']) && !empty($_POST['team_lead']) && !empty($_POST['team'])){
			$dId = $_POST['team_lead'];
			$tId = $_POST['team'];
			$check = $this->db->get_where('team_lead_assign', array('team_lead_id' => $dId, 'team_id' => $tId))->result_array();
			if($check){
				$this->session->set_flashdata("message","teamlead already assigned to the Team!!");
				redirect('admin/home/teamlead_team_assign');
			}else{
				$post = array('team_lead_id' => $dId, 'team_id' => $tId);
				$this->db->insert('team_lead_assign', $post);
				$this->session->set_flashdata("message","Sucessful!!");
				redirect('admin/home/teamlead_team_assign');
			}
		}
		$data['team_lead'] = $this->db->get_where('team_lead',array('is_active'=>'1'))->result_array();
		$data['teams'] = $this->db->get('teams')->result_array();
		$this->load->view('admin/teamlead_team_assign', $data);
	}
	
	public function publications($id='')
	{
		if($id!=''){
			$publications = $this->db->get_where('publications',array('id'=>$id, 'is_active'=>'1'))->result_array();
			if($publications){
				if(isset($_POST['assign'])){
					$post = array('group_id' => $_POST['group'], 'channel' => $_POST['channel']);
					$this->db->where('id', $publications[0]['id']);
					$this->db->update('publications', $post);
					
					$this->session->set_flashdata("message","Sucessful!!");
					redirect('admin/home/publications');
				}
				$data['publications'] = $publications;
				$data['group'] = $this->db->get_where('Group',array('is_active'=>'1'))->result_array();
				$data['channel'] = $this->db->get('channels')->result_array();
				$this->load->view('admin/publication_edit', $data);
			}
		}else{
			$data['publications'] = $this->db->get_where('publications',array('is_active'=>'1'))->result_array();
			$this->load->view('admin/publications', $data); 
		}
	}
	
	public function column_clear()
	{
		if(isset($_POST['clear']) && !empty($_POST['column_name']) && !empty($_POST['from_date']) && !empty($_POST['to_date'])){
			$column_name = $_POST['column_name'];
			$from = $_POST['from_date']; $to = $_POST['to_date'];
			$update = $this->db->query("UPDATE `orders` SET `$column_name` = '' WHERE `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59';");
			if($update){
				$this->session->set_flashdata("message", $column_name." Data Cleared..!!");
				redirect('admin/home/column_clear');
			}
		}
		$data['order_column'] = $this->db->query('SELECT `copy_content_description`, `notes` FROM `orders`')->list_fields(); 
		$this->load->view('admin/column_clear', $data);
	}
	
	public function preorder_move()
	{
		$data['hi'] = 'hello';
		if(isset($_POST['submit'])){
			$from = $_POST['from_date']; $to = $_POST['to_date'];
			$data['from_date'] = $from; $data['to_date'] = $to; 
			$data['count'] = $this->db->query("SELECT * FROM `preorder` WHERE `time_stamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->num_rows;
		}
		if(isset($_POST['Move'])){
			$from = $_POST['from_date']; $to = $_POST['to_date'];
			$move = $this->db->query("INSERT INTO `archive_preorder` 
										SELECT * from `preorder` WHERE `time_stamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59' 
											AND `id` NOT IN (SELECT `id` FROM `archive_preorder`);");
			if($move){
				$delete =  $this->db->query("DELETE FROM `preorder` WHERE `time_stamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';");
				$this->session->set_flashdata("message", " Data Moved..!!");
				redirect('admin/home/preorder_move');
			}
		}
		$this->load->view('admin/preorder_move', $data);
	}
	
	public function revision_report()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
			$from = $_POST['from_date']; $to = $_POST['to_date'];
			$data['rev_orders'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `date` BETWEEN '$from' AND '$to';")->result_array();
			$data['from'] = $from; $data['to'] = $to;
		}else{
			$today = date('Y-m-d');
			$ystday = date('Y-m-d', strtotime(' -1 day'));
			$data['rev_orders'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `date` BETWEEN '$ystday' AND '$today';")->result_array();
		}
		$this->load->view('admin/revision_report', $data);
	}
	
	public function rev_new($form = '')
	{
		$data['types'] = $this->db->get_where('Group', array('is_active'=>'1'))->result_array();
		if($form!='')
		{
			if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
				$data['from'] = $_POST['from_date'];
				$data['to'] = $_POST['to_date'];
			}else{
				$today = date('Y-m-d');
				$data['today'] = $today;
			}
			$data['grp_pub'] = $this->db->get_where('publications',array('group_id' => $form))->result_array();
			$data['form'] = $form;
		}
		$this->load->view('admin/rev_new',$data);
	}
	
	public function list_adrep()
	{
		$adreps = $this->db->get_where('adreps',array('is_active'=>'1'))->result_array();
		$path = "downloads/adreps.txt";
		$handle = fopen($path,'wb');
		foreach($adreps as $row){
			//$this->storeInTextFile($row,$path);
			fwrite($handle, $this->arrayToString($row));
		}
		 fclose($handle);
	}
	
	public function list_adrep_display(){
		$this->load->helper('file');
		$path = "downloads/adreps.txt";
		$string = read_file($path); 
		$explodedString = explode(PHP_EOL,$string);
		echo $explodedString[1];
		$returnArray = array();
		/*foreach($explodedString as $arrayValue) {
			list($key,$value) = explode(' => ',$arrayValue);
			$returnArray[$key] = $value;
			
		}*/

		//return $returnArray;
	}
	
	/*function storeInTextFile($array,$path) {
		if(file_exists($path)) {
			 $handle = fopen($path,'wb');
			 fwrite($handle, $this->arrayToString($array));
			 fclose($handle);
		}
	}*/
	
	function arrayToString($array) {
		$string = '';
		foreach($array as $key => $value) {
			$string .= "{$key} => {$value}\n";
		}
		return $string;
	}

	function stringToArray($string) {
		$explodedString = explode('\n',$string);
		$returnArray = array();
		foreach($explodedString as $arrayValue) {
			list($key,$value) = explode(' => ',$arrayValue);
			$returnArray[$key] = $value;
		}

		return $returnArray;
	}

}
