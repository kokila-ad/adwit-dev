<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Bg_Controller {

	public function index()
	{
		$bg1_news = $this->db->get_where('cat_newspaper',array('business_group_id' => '1'))->result_array();
		$bg2_news = $this->db->get_where('cat_newspaper',array('business_group_id' => '2'))->result_array();
		$bg3_news = $this->db->get_where('cat_newspaper',array('business_group_id' => '3'))->result_array();
		$bg4_news = $this->db->get_where('cat_newspaper',array('business_group_id' => '6'))->result_array();
		$data['bg1_news']=$bg1_news;
		$data['bg2_news']=$bg2_news;
		$data['bg3_news']=$bg3_news;
		$data['bg4_news']=$bg4_news;
		$this->load->view('bg_head/home',$data );
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('bg_head/change',$data);
	}
	
	public function dochange()
	{
		$this->db->query("Update bg_head set password='".md5($this->input->post('new_password'))."' where (username='".$this->session->userdata('bg')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->change('Your password has been changed successfully!', 'darkgreen');
		else
			$this->change('Invalid current password!', 'darkred');
	}
/*	
	public function adwitjobs()
	{
		
		if(!isset($_POST["csr"]))
		{
			$bg_id = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
			$p_id = $this->db->get_where('publications',array('business_group_id' => $bg_id[0]['business_group_id']))->result_array();
			$c_id = $this->db->get_where('csr',array('business_group_id' => $bg_id[0]['business_group_id']))->result_array();
			$cat = $this->db->get('cat_minmax')->result_array();
			
			$data['bg_id']=$bg_id;
			$data['p_id']=$p_id;
			$data['c_id']=$c_id;
			$data['cat']=$cat;
						
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			
			$this->load->view('bg_head/job-assign',$data);
		}else
		{
			$category = $_POST['category'];
			$csr = $_POST['csr'];
			$id = $_POST['id'];
			$data = array(
               'category' => $category,
               'csr' => $csr,
              );

			$this->db->where('id', $id);
			$this->db->update('orders_dup', $data); 
		
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=adwitjobs">';		
			
		}
		
	}
*/

	public function adwitjobs()
	{
		
		if(isset($_POST["csr"]))
		{
			$category = $_POST['category'];
			$csr = $_POST['csr'];
			$id = $_POST['id'];
			$data = array(
               'category' => $category,
               'csr' => $csr,
              );

			$this->db->where('id', $id);
			$this->db->update('orders_dup', $data);
		
		}
		
			$bg_id = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
			$p_id = $this->db->get_where('publications',array('business_group_id' => $bg_id[0]['business_group_id']))->result_array();
			$c_id = $this->db->get_where('csr',array('business_group_id' => $bg_id[0]['business_group_id']))->result_array();
			$cat = $this->db->get('cat_minmax')->result_array();
			
			$data['bg_id']=$bg_id;
			$data['p_id']=$p_id;
			$data['c_id']=$c_id;
			$data['cat']=$cat;
						
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			
			$this->load->view('bg_head/job-assign',$data);
	}

	public function publications()
	{
		$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$news_bg = $this->db->get_where('cat_newspaper',array('business_group_id' => $bg_grp[0]['business_group_id']))->result_array();
		$data['news_bg'] = $news_bg;
		
		$this->load->view('bg_head/publications',$data);
	}	
	
	public function job_list()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('Asia/Calcutta');
		}
		$tday= date('Y-m-d');
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$pystday = date('Y-m-d', strtotime(' -2 day'));
		$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `date`= '$tday' OR `date`='$ystday'  OR `date`='$pystday';")->result_array();
		
		$data['cat_result'] = $cat_result;
		
		$this->load->view('bg_head/job-list',$data);
	}	
	
	
	public function jobs_pub()
	{
		$bg_grp = $this->db->get_where('business_groups',array('id' => $this->session->userdata('bgId')))->result_array();
		$news_bg = $this->db->get_where('cat_newspaper',array('business_group_id' => $bg_grp[0]['business_group_id']))->result_array();
		
		$data['bg_grp'] = $bg_grp;
		$data['news_bg'] = $news_bg;
		
		$this->load->view('bg_head/job-pub',$data);
		
	}
	
	
	public function pub_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$data['publication'] = $this->db->get_where('cat_newspaper',array('business_group_id' => $bg_grp[0]['business_group_id']))->result_array();
		$data['today'] = date('Y-m-d');
		$this->load->view('bg_head/pub-performance',$data );
	}
	
	
	public function csr_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$data['csr'] = $this->db->get_where('csr',array('business_group_id' => $bg_grp[0]['business_group_id']))->result_array();
		$data['today'] = date('Y-m-d');
		$this->load->view('bg_head/csr-performance',$data );
	}
	
	
	public function jobs_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$data['publication'] = $this->db->get_where('cat_newspaper',array('business_group_id' => $bg_grp[0]['business_group_id']))->result_array();
		$data['today'] = date('Y-m-d');
		$this->load->view('bg_head/jobs-performance',$data );
	}
	
	
	public function trouble_ticket()
	{
		$data['hi'] = 'hi';
		if(!empty($_POST['cname']) && !empty($_POST['IT_problem']) && !empty($_POST['description']))
		{
			$data = array(
							'bg_head' => $this->session->userdata('bgId'),
							'cname' => $_POST['cname'], 
							'IT_problem' => $_POST['IT_problem'],
							'description' => $_POST['description'],
						);
			$this->db->insert('trouble_ticket', $data);
			$data['tt_status'] = "Submitted!!";
		}
		
		$this->load->view('bg_head/admin-support',$data);
	}
	
	public function admin_support()
	{
		$data['hi'] = 'hi';
		if(!empty($_POST['department']) && !empty($_POST['description']))
		{
			$data = array(
							'bg_head' => $this->session->userdata('bgId'),
							'department' => $_POST['department'], 
							'description' => $_POST['description'],
						);
			$this->db->insert('admin_support', $data);
			$data['as_status'] = "Submitted!!";
		}
		$this->load->view('bg_head/admin-support',$data);
	}
	
}