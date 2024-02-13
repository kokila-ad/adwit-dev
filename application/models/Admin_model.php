<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database('default', TRUE);
		$this->load->library('session');
    }
	
	public function adreps_list()
	{
		return $this->db->query("SELECT * FROM `adreps` where `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
	}
	
	public function publications_list()
	{
		return $this->db->query("SELECT * FROM `publications` where `is_active` = '1' ORDER BY `name`")->result_array();
		
	}
	
	public function business_groups()
	{
		return $this->db->query("SELECT * FROM `business_groups` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		
	}
	
	public function art_director()
	{
		return $this->db->query("SELECT * FROM `art_director` WHERE `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
		
	}
	
	public function bg_head()
	{
		return $this->db->query("SELECT * FROM `bg_head` WHERE `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
	}
	
	public function csr()
	{
		return $this->db->query("SELECT * FROM `csr` where `is_active` = '1' ORDER BY `name` ")->result_array();
	}
	
	public function adreps_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('adreps', $_POST);
		return $this->db->insert_id();
	} 
	
	public function publications_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('publications', $_POST);
		return $this->db->insert_id();
	} 
	
	public function designers_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('designers', $_POST);
		return $this->db->insert_id();
	}
	
	public function teamlead_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('team_lead', $_POST);
		return $this->db->insert_id();
	}
	
	public function customers_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('customers', $_POST);
		return $this->db->insert_id();
	}
	
	public function channels_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('channels', $_POST);
		return $this->db->insert_id();
	}
	
	public function designteams_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('design_teams', $_POST);
		return $this->db->insert_id();
	}
	
	public function help_desk_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('help_desk', $_POST);
		return $this->db->insert_id();
	}
	
	public function art_director_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('art_director', $_POST);
		return $this->db->insert_id();
	}
	
	public function bg_head_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('bg_head', $_POST);
		return $this->db->insert_id();
	}
	
	public function csr_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('csr', $_POST);
		return $this->db->insert_id();
	}
	
	public function management_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('management', $_POST);
		return $this->db->insert_id();
	}
	
	public function notify_insert()
	{
		$this->load->helper(array('form', 'url'));
		$this->db->insert('notification', $_POST);
		return $this->db->insert_id();
	}
	
	public function notification_insert($display_type='')
	{	//echo count($_POST['aId']).$_POST['display_type'].$_POST['start_date'];
		if($_POST['display_type'] == 'publication')
		{
			$count = count($_POST['pId']);
			for($i=0; $i<$count; $i++){
				$post = array(	'publication'=> $_POST['pId'][$i],
								'headline' => $_POST['headline'], 
								'message' => $_POST['message'],
								'start_date' => $_POST['start_date'],
								'end_date' => $_POST['end_date']
							 );
				$this->db->insert('notification',$post);
				$id = $this->db->insert_id();
				if($id){
					$path = "notifications/".$id;
					if (@mkdir($path,0777)){}
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						$targetPath = getcwd().'/'.$path.'/';
						$targetFile = $targetPath . $fileName ;
						if(copy($tempFile, $targetFile))
						{
							$fname = $path.'/'.$fileName;
							$data = array('image' => $fname);
							$this->db->where('id', $id);
							$this->db->update('notification', $data);
						}
					}	
				}
		}elseif($_POST['display_type']== 'adrep')
		{
			$count = count($_POST['aId']);
			for($i=0; $i<$count; $i++){
				$post = array(	'adrep'=> $_POST['aId'][$i],
								'headline' => $_POST['headline'], 
								'message' => $_POST['message'],
								'start_date' => $_POST['start_date'],
								'end_date' => $_POST['end_date']
								);
				$this->db->insert('notification',$post);
				$id = $this->db->insert_id();
				if($id){
					$path = "notifications/".$id;
					if (@mkdir($path,0777)){}
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						$targetPath = getcwd().'/'.$path.'/';
						$targetFile = $targetPath . $fileName ;
						if(copy($tempFile, $targetFile))
						{
							$fname = $path.'/'.$fileName;
							$data = array('image' => $fname);
							$this->db->where('id', $id);
							$this->db->update('notification', $data);
						}
				}	
			}
		}
		return $id;	
	}
	
	public function adreps_check($id)
	{
		return $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id';")->num_rows();
	}
	
	public function publications_check($id)
	{
		return $this->db->query("SELECT * FROM `publications` WHERE `id` = '$id';")->num_rows();
	}
	
	public function designers_check($id)
	{
		return $this->db->query("SELECT * FROM `designers` WHERE `id` = '$id';")->num_rows();
	}
	
	public function teamlead_check($id)
	{
		return $this->db->query("SELECT * FROM `team_lead` WHERE `id` = '$id';")->num_rows();
	}
	
	public function customers_check($id)
	{
		return $this->db->query("SELECT * FROM `customers` WHERE `id` = '$id';")->num_rows();
	}
	
	public function channels_check($id)
	{
		return $this->db->query("SELECT * FROM `channels` WHERE `id` = '$id';")->num_rows();
	}
	
	public function designteams_check($id)
	{
		return $this->db->query("SELECT * FROM `design_teams` WHERE `id` = '$id';")->num_rows();
	}
	
	public function help_desk_check($id)
	{
		return $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$id';")->num_rows();
	}
	
	public function art_director_check($id)
	{
		return $this->db->query("SELECT * FROM `art_director` WHERE `id` = '$id';")->num_rows();
	}
	
	public function bg_head_check($id)
	{
		return $this->db->query("SELECT * FROM `bg_head` WHERE `id` = '$id';")->num_rows();
	}
	
	public function csr_check($id)
	{
		return $this->db->query("SELECT * FROM `csr` WHERE `id` = '$id';")->num_rows();
	}
	
	public function management_check($id)
	{
		return $this->db->query("SELECT * FROM `management` WHERE `id` = '$id';")->num_rows();
	}
	
	public function notification_check($id)
	{
		return $this->db->query("SELECT * FROM `notification` WHERE `id` = '$id';")->num_rows();
	}
	
	public function adreps_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('adreps', $_POST);
		$adreps_updated_successful = $this->db->affected_rows();
		if($adreps_updated_successful > 0){
			$this->session->set_flashdata("adreps_updated_successful","Adrep : $id Updated successfully!");
		}else{
			$this->session->set_flashdata("adreps_updated_successful", $this->db->_error_message());
		}
		
	} 
	
	public function publications_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('publications', $_POST);
		$publications_updated_successful = $this->db->affected_rows();
		if($publications_updated_successful > 0){
			$this->session->set_flashdata("publications_updated_successful","Publication : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("publications_updated_successful",$this->db->_error_message());
			
		}
	}
	
	public function designers_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('designers', $_POST);
		$designers_updated_successful= $this->db->affected_rows();
		if($designers_updated_successful > 0){
			$this->session->set_flashdata("designers_updated_successful","Designer : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("designers_updated_successful",$this->db->_error_message());
			
		}
	} 
	
	public function teamlead_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('team_lead', $_POST);
		$teamlead_updated_successful = $this->db->affected_rows();
		if($teamlead_updated_successful > 0){
			$this->session->set_flashdata("teamlead_updated_successful","TeamLead : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("teamlead_updated_successful", $this->db->_error_message());
			
		}
	}
	
	public function customers_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('customers', $_POST);
		$customers_updated_successful = $this->db->affected_rows();
		if($customers_updated_successful > 0){
			$this->session->set_flashdata("customers_updated_successful","Customer : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("customers_updated_successful", $this->db->_error_message());
			
		}
	}
	
	public function channels_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('channels', $_POST);
		$channels_updated_successful = $this->db->affected_rows();
		if($channels_updated_successful > 0){
			$this->session->set_flashdata("channels_updated_successful","Channel : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("channels_updated_successful",$this->db->_error_message());
			
		}
	}
	
	public function designteams_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('design_teams', $_POST);
		$designteams_updated_successful = $this->db->affected_rows();
		if($designteams_updated_successful > 0){
			$this->session->set_flashdata("designteams_updated_successful","DesignTeam : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("designteams_updated_successful",$this->db->_error_message());
			
		}
	}
	
	public function help_desk_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('help_desk', $_POST);
		$hd_updated_successful = $this->db->affected_rows();
		if($hd_updated_successful > 0){
			$this->session->set_flashdata("hd_updated_successful","HelpDesk : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("hd_updated_successful",$this->db->_error_message());
			
		}
	}
	
	public function art_director_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('art_director', $_POST);
		$art_director_updated_successful = $this->db->affected_rows();
		if($art_director_updated_successful > 0){
			$this->session->set_flashdata("art_director_updated_successful","Art Director : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("art_director_updated_successful", $this->db->_error_message());
			
		}
	}
	
	public function bg_head_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('bg_head', $_POST);
		$bg_head_updated_successful= $this->db->affected_rows();
		if($bg_head_updated_successful > 0){
			$this->session->set_flashdata("bg_head_updated_successful","BG head : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("bg_head_updated_successful", $this->db->_error_message());
		
		}
	}
	
	public function csr_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('csr', $_POST);
		$csr_updated_successful = $this->db->affected_rows();
		if($csr_updated_successful > 0){
			$this->session->set_flashdata("csr_updated_successful","CSR : $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("csr_updated_successful",$this->db->_error_message());
			
		}
	}
	
	public function management_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('management', $_POST);
		if($management_updated_successful > 0){
			$this->session->set_flashdata("management_updated_successful","Management: $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("management_updated_successful", $this->db->_error_message());
			
		}
	}
	
	public function notification_update($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->db->where('id', $id);
		$this->db->update('notification', $_POST);
		if($updated_successful > 0){
			$this->session->set_flashdata("updated_successful","Notification: $id Updated successfully!");
			
		}else{
			$this->session->set_flashdata("updated_successful", $this->db->_error_message());
			
		}
	}
	
	public function design_team()
	{
		return $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
	}
	
	public function teams()
	{
		return $this->db->query("SELECT * FROM `teams` ORDER BY `name`")->result_array();
	}
	
	public function adreps()
	{
		return $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
	}
	
	public function help_desk()
	{
		return $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1' ORDER BY `name`")->result_array();
	}
	
	public function ordering_system()
	{
		return $this->db->query("SELECT * FROM `ordering_system`")->result_array();
	}
	
	public function channels()
	{
		return $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
	}
	
	public function group()
	{
		return $this->db->query("SELECT * FROM `group` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
	}
	
	public function designers_list()
	{
		return $this->db->query("SELECT * FROM `designers` where `is_active` = '1' ")->result_array();
	}
	
	public function team_lead()
	{
		return $this->db->query("SELECT * FROM `team_lead` where `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
	}
	
	public function location()
	{ 
		return $this->db->query("SELECT * FROM `location` ORDER BY `name`")->result_array();
	}
	
	public function customers()
	{
		return $this->db->query("SELECT * FROM `customers` ORDER BY `name`")->result_array();
	}
	
	public function management()
	{
		return $this->db->query("SELECT * FROM `management` WHERE `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
	}
	
	public function notification()
	{
		return $this->db->query("SELECT * FROM `notification` ")->result_array();
	}
	
	public function adwit_users()
	{
		return $this->db->query("SELECT * FROM `adwit_users` ORDER BY `name`")->result_array();
	}
	 /* public function adreps_update()
	 {
		 $this->load->helper(array('form', 'url'));
		 if(isset($_POST['first_name'])){
			$this->db->insert('adreps', $_POST);
		 }
	 } */
	
	/* public function update_adrep()
	{
		$this->load->helper(array('form', 'url'));
		if(isset($_POST['save_submit'])){
			$this->db->insert('adreps', $_POST);
		}
	} */
	
	public function retail_price_per_credit() 
	{
		return $this->db->get('retail_price_per_credit')->result_array();
	}
	
	public function retail_color_preference() //Ad Format(regular,premium etc)
	{
		return $this->db->get('retail_color_preference')->result_array();
	}
	
	public function retail_credit_date() //Print Ad Type
	{
		return $this->db->get('retail_credit_date')->result_array();
	}
	
	public function retail_credit_sqinch()	//Web Ad Type
	{
		return $this->db->get('retail_credit_sqinch')->result_array();
	}
	
	public function retail_free_credits() //Web Size Type(rect,mobile etc)
	{
		return $this->db->get('retail_free_credits')->result_array();
	}
	
	public function create_package()
	{
		$discount_credit = $_POST['discount'];
		$post = array(	'uid'=> $this->session->userdata('daId'),
						'credits' => $_POST['credits'],
						'credits_price'=> $_POST['price_credit'],
						'discount'=> $_POST['discount'],
						'per_discount'=> round($_POST['discount_percentage'], 2),
						'total_price'=>$_POST['total_price']
					 );
		$this->db->insert('retail_package',$post);
		$id = $this->db->insert_id();
		return $id;
	}
	public function package_update()
	{
		if(isset($_POST['Update_Package'])){
			$post =  array(	'uid'=> $this->session->userdata('daId'),
						'credits' => $_POST['credits'],
						'credits_price'=> $_POST['price_credit'],
						'discount'=> $_POST['discount'],
						'per_discount'=> round($_POST['discount_percentage'], 2),
						'total_price'=>$_POST['total_price']
					  );	
			$this->db->where('id', $_POST['id']);
			$this->db->update('retail_package', $post);
			redirect('new_admin/home/retail_dashboard');
	    }
	}
	
	public function package_view()
	{
		$id = $this->session->userdata('daId');
		return $this->db->get('retail_package')->result_array();
	}
	public function add_category()
	{
		$value = $this->input->post('value');
		$data = array('name' => $value);
		$this->db->insert('category', $data);
	}
	
	public function add_sub_category($sub_category)
	{
		$data = array('name' => $sub_category);
		$this->db->insert('sub_category', $data);
	}
	
}
?>