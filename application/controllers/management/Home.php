<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Management_Controller {

	public function index()
	{
		/*if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$this->load->view('management/home');*/
		/*$data['hi']="hello";
		$mId = $this->session->userdata('mId');
		$var = $this->db->get_where('group',array('mid'=>$this->session->userdata('mId'), 'is_active'=>'1'))->result_array();
		if($var){
		$data['var']=$var;}*/
		redirect('management/home/dashboard'); 
	}
	
	public function dashboard()
	{
		$data['order_ratings5'] = $this->db->query("select * from `order_rating` where `rating` = '5'")->num_rows();
		$data['order_ratings4'] = $this->db->query("select * from `order_rating` where `rating` = '4'")->num_rows();
		$data['order_ratings3'] = $this->db->query("select * from `order_rating` where `rating` = '3'")->num_rows();
		$data['order_ratings2'] = $this->db->query("select * from `order_rating` where `rating` = '2'")->num_rows();
		$data['order_ratings1'] = $this->db->query("select * from `order_rating` where `rating` = '1'")->num_rows();
		$data['groups'] = $this->db->query("select * from `Group` where `is_active`='1'")->result_array();
		$data['publication'] = $this->db->query("select * from `publications` where `is_active` = '1'")->num_rows();
		$data['adrep'] = $this->db->query("select * from `adreps` where `is_active` = '1'")->num_rows();
		$data['designer'] = $this->db->query("select * from `designers` where `is_active` = '1'")->num_rows();
		$data['csr'] = $this->db->query("select * from `csr` where `is_active` = '1'")->num_rows();
		$data['teamlead'] = $this->db->query("select * from `team_lead` where `is_active` = '1'")->num_rows();
		// Orders Count
		$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
			$ystday_time = $today_date_time[0]['time'];
			$today_time = $today_date_time[1]['time'];
			$tomo_time = $today_date_time[2]['time'];
			 
			$current_date = date("Y-m-d");
			$ysterday = date("Y-m-d", strtotime(' -1 day'));
			$tomo = date("Y-m-d", strtotime(' +1 day'));
			$ct = date("H:i:s");
			if($ct >= '00:00:00' && $ct <= '08:29:59'){
				$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id`!='1' AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
			}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
				$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE  `order_type_id`!='1' AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
			}
			
		$this->load->view('management/dashboard',$data);
	}
	
	public function my_profile($tab='1')
	{
		$data['tab'] = $tab;
		
		if(isset($_POST['personal_info']) && (!empty($_POST['first_name']) || !empty($_POST['mobile_no']))){
			$post = array();
			if(!empty($_POST['first_name'])){$post['first_name'] = $_POST['first_name']; }
			if(!empty($_POST['last_name'])){$post['last_name'] = $_POST['last_name'];}
			if(!empty($_POST['mobile_no'])){$post['mobile_no'] = $_POST['mobile_no']; }
			$this->db->where('id', $_POST['mid']);
			$this->db->update('management', $post); 
			$data['error'] = "changed successfully!!";
			$data['color'] = 'darkred';
		}
		if(isset($_POST['change_avatar']) && !empty($_FILES['file']['name'])){
			$file_size = $_FILES['file']['size'];
			if($file_size > '150000'){
				 $this->session->set_flashdata('size_message',"Image size should not exceed 150KB!!");
					redirect('management/home/my_profile#tab_1_2'); 
			}else{
				$uploadDir = "images/management/".$this->session->userdata('mId').".jpg";
				if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadDir)){
					$data = array( 'image' => $uploadDir );
					$this->db->where('id', $_POST['mid']);
					$this->db->update('management', $data);
				}else{
					$data['error'] = "Error Uploading!!";
					$data['color'] = 'darkred';
				}
				$data['tab'] = '2'; 
			}	
		}
		if(isset($_POST['remove_pic']) && !empty($_POST['management_id'])){ 
			$default_path = "images/ad-img.jpg";
			$m_id = $_POST['management_id'];
			$this->db->query("Update management set image = '$default_path' where id = '$m_id'");
			redirect('management/home/my_profile#tab_1_2');
		}
		$data['management'] = $this->db->get_where('management',array('id' => $this->session->userdata('mId')))->row_array();
		$this->load->view('management/my_profile', $data);
	}
	
	public function ads($display_type='') 
	{
		$data['display_type'] = $display_type;
		if(isset($_POST['pub_submit']) && !empty($_POST['pId']) && $display_type=='publication' && !empty($_POST['from']) && !empty($_POST['to']))
		{
			$data['publication'] = $this->db->query("select * from `publications` where `is_active` = '1'")->result_array();
			$data['from'] = date('Y-m-d 00:00:00', strtotime($_POST['from']));
			$data['to'] = date('Y-m-d 23:59:59', strtotime($_POST['to']));
			$data['publication_details'] = $this->pub_search();
			$data['pub_display'] = $_POST['display'];
		}elseif($display_type=='publication'){
			$publication = $this->db->query("select * from `publications` where `is_active` = '1'")->result_array();
			$data['publication'] = $publication;	
		}
		
		if(isset($_POST['grp_submit']) && !empty($_POST['gId']) && $display_type=='group' && !empty($_POST['from']) && !empty($_POST['to']))
		{
			$data['groups'] = $this->db->query("select * from `Group` where `is_active` = '1'")->result_array();		
			$data['from'] = date('Y-m-d 00:00:00', strtotime($_POST['from']));
			$data['to'] = date('Y-m-d 23:59:59', strtotime($_POST['to']));
			$data['group_details'] = $this->grp_search();
			$data['grp_display'] = $_POST['grp_display'];
		}elseif($display_type=='group'){
			$group = $this->db->query("select * from `Group` where `is_active` = '1'")->result_array();
			$data['groups'] = $group;
		}
		
		if(isset($_POST['adrp_submit']) && !empty($_POST['aId'])&& $display_type=='adrep' && !empty($_POST['from']) && !empty($_POST['to']))
		{
			$data['adrep'] = $this->db->query("select * from `adreps` where `is_active` = '1'")->result_array();
			$data['from'] = date('Y-m-d 00:00:00', strtotime($_POST['from']));
			$data['to'] = date('Y-m-d 23:59:59', strtotime($_POST['to']));
			$data['adrep_details'] = $this->adrp_search();
			$data['adrp_display'] = $_POST['adrp_display'];
		}elseif($display_type=='adrep'){
			$adrep = $this->db->query("select * from `adreps` where `is_active` = '1'")->result_array();
			$data['adrep'] = $adrep;
		}
		$this->load->view('management/ads', $data);
	}
		
	public function pub_search()
	{
		if(isset($_POST['pub_submit']) && !empty($_POST['pId']))
		{
			$ids = $_POST['pId'];
			$ids = join(', ', $ids);
			$query = $this->db->query("SELECT * FROM `publications` WHERE `id` IN ($ids)")->result_array();
			return $query;
		}	
	}
	
	public function grp_search()
	{
		if(isset($_POST['grp_submit']) && !empty($_POST['gId']))
		{
			$ids = $_POST['gId'];
			$ids = join(', ', $ids);
			$query = $this->db->query("SELECT * FROM `Group` WHERE `id` IN ($ids)")->result_array();
			return $query;
		}	
	}
	
	public function adrp_search()
	{
		if(isset($_POST['adrp_submit']) && !empty($_POST['aId']))
		{
			$ids = $_POST['aId'];
			$ids = join(', ', $ids);
			$query = $this->db->query("SELECT * FROM `adreps` WHERE `id` IN ($ids)")->result_array();
			return $query;
		}	
	}
	
	public function publication()
	{
		$data['cur_date'] = date("Y-m-d");
		$data['past_month'] = date("Y-m-d", strtotime('-6 month'));
		
		$data['publication']= $this->db->query("select * from `publications` where `is_active` = '1'")->result_array(); 
		$data['groups'] = $this->db->query("select * from `Group` where `is_active` = '1' ")->result_array();
		$this->load->view('management/publication',$data); 
	}
	
	public function publication_search()
	{
		if(isset($_POST['search']) && !empty($_POST['search_id']))
		{
			$id = $_POST['search_id'];
			$pub_name = $this->db->query("select * from `publications` where `name`= '$id' ")->result_array();
			if($pub_name){
				redirect('management/home/publication');
			}
		} 
	}
	
	public function adrep()
	{
		$data['cur_date'] = date("Y-m-d");
		$data['past_month'] = date("Y-m-d", strtotime('-6 month'));
		
		$data['adrep'] = $this->db->query("select * from `adreps` where `is_active` = '1'")->result_array();
		$data['publication'] = $this->db->query("select * from `publications` where `is_active` = '1'")->result_array();
		$data['groups'] = $this->db->query("select * from `Group` where `is_active` = '1'")->result_array();
		$this->load->view('management/adrep',$data);
	}
	
	public function employee()
	{
		$this->load->view('management/employee');
	}
	
	public function pro()
	{
		$this->load->view('manage/production');
	}
	
	public function announcement()
	{
		$this->load->view('management/announcement');
	}
	
	public function hd_hourly_report($form = '')
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
		$this->load->view('management/hd_hourly_report',$data);
	}	
	public function lock()
	{
		$this->load->view('management/lock');
	}

	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('management/change',$data);
	}
	
	public function dochange()
	{
		$this->db->query("Update management set password='".md5($this->input->post('new_password'))."' where (username='".$this->session->userdata('management')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows()){
			$this->session->set_flashdata("pwd_message","Your password has been changed successfully!", "darkgreen");
			redirect('management/home/my_profile#tab_1_3');
		}
		else{
			$this->session->set_flashdata("pwd_message","Invalid current password!","darkred");
			redirect('management/home/my_profile#tab_1_3');
		}
	}

	public function BG_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['bg_head'] = $this->db->get('business_groups')->result_array();
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date('Y-m-d');
		$this->load->view('management/BG-performance',$data );
		//$this->load->view('management/mgnt',$data );
	}
		 
	public function pub_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['business_group'] = $this->db->get('business_groups')->result_array();
		$data['publication'] = $this->db->get('cat_newspaper')->result_array();
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date('Y-m-d');
		$this->load->view('management/pub-performance',$data );
	
	}
	 	
	public function design_performance()
	{ 
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array();
		//$prev_month = date("Y-m", strtotime("-1 month"));
		
		$data['designer'] = $designer;
		
		$data['today'] = date("Y-m-d");
		
		$this->load->view('management/design-performance',$data);
	}
	
	public function team_performance()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$data['team_lead'] = $this->db->get('team_lead')->result_array() ;
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date("Y-m-d");
		
		$this->load->view('management/team-performance',$data);
	}
	
	public function trouble_ticket()
	{
		$data['hi'] = 'hi';
		if(!empty($_POST['cname']) && !empty($_POST['IT_problem']) && !empty($_POST['description']))
		{
			$data = array(
							'manager' => $this->session->userdata('mId'),
							'cname' => $_POST['cname'], 
							'IT_problem' => $_POST['IT_problem'],
							'description' => $_POST['description'],
						);
			$this->db->insert('trouble_ticket', $data);
			$id=$this->db->insert_id();
			if($id){ $data['tt_status'] = "Submitted!!"; }else{ $data['tt_status'] = "Submission Failed!!"; }
		}
		$this->load->view('management/admin-support',$data);
	}
	
	public function admin_support()
	{
		$data['hi'] = 'hi';
		
		if(!empty($_POST['department']) && !empty($_POST['description']))
		{
			if (function_exists('date_default_timezone_set'))
			{
				date_default_timezone_set('America/New_York');
			}
			$data = array(
							'manager' => $this->session->userdata('mId'),
							'department' => $_POST['department'], 
							'description' => $_POST['description'],
						);
			$this->db->insert('admin_support', $data);
			$id=$this->db->insert_id();
			if($id){ $data['as_status'] = "Submitted!!"; }else{ $data['as_status'] = "Submission Failed!!"; }
		}
		$this->load->view('management/admin-support',$data);
	}
	 	 
	public function csr_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		//$bg_grp = $this->db->get_where('bg_head',array('id' => $this->session->userdata('bgId')))->result_array();
		$csr = $this->db->get_where('csr',array('is_active'=>'1'))->result_array();
		$data['csr'] = $csr;
		$today = date('Y-m-d');
		$data['today'] = $today;
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('management/csr-performance',$data );
	}
	
	public function incoming_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		
		$data['csr'] = $this->db->get('csr')->result_array();
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date('Y-m-d');
		$this->load->view('management/incoming-performance',$data );
	}
		
	public function outgoing_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		
		$data['csr'] = $this->db->get('csr')->result_array();
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('management/outgoing-performance',$data );
	}
	
	public function QA_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		
		$data['csr'] = $this->db->get('csr')->result_array();
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('management/QA-performance',$data );
	}
	
	public function production()
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
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date("Y-m-d");
		
		$this->load->view('management/production',$data);
	}
	
	public function frontline_dup($form = '')//old
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
			if (function_exists('date_default_timezone_set'))
			{
				date_default_timezone_set('America/New_York');
			}
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
		{ $this->load->view('management/frontline-sold', $data); }
		elseif($form == 'fastrack'){
			$this->load->view('management/frontline-fastrack', $data);			
		}elseif($form == 'new'){
			$this->load->view('management/frontline-new', $data);			
		}else{
		$this->load->view('management/frontline-report', $data);
		}
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
			if (function_exists('date_default_timezone_set'))
			{
				date_default_timezone_set('America/New_York');
			}
			$today = date("Y-m-d");
			if($form == 'all')
			{
				$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `date` = '$today' AND  `time_taken`!='0' AND `job_status`='1' ;")->result_array();
			}else{
				$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `date` = '$today' AND  `time_taken`!='0' AND `job_status`='1' AND `category`='$form';")->result_array();
			}
			$data['today'] = $today;
		}
		$data['help_desk'] = $this->db->get_where('help_desk', array('active'=>'1'))->result_array();
		$data['form'] = $form;
		
		if($form == 'sold' ){
			$this->load->view('management/frontline-sold-dup', $data); 
		}elseif($form == 'fastrack'){
			$this->load->view('management/frontline-fastrack-dup', $data);			
		}elseif($form == 'new'){
			$this->load->view('management/frontline-new-dup', $data);			
		}else{
			$this->load->view('management/frontline-report-dup', $data);
		}
	}
	
	
	public function tst_details()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		// $designer = $this->db->get_where('designers',array('id'=>'78'))->result_array() ;
		
		// $data['designer'] = $designer;
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date("Y-m-d");
		
		$this->load->view('management/tst_details',$data);
	
	}
	
	public function adrep_orders()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$clients = $this->db->get('clients')->result_array();
		foreach($clients as $rows)
		{	
			
			$news_id = $this->db->get_where('cat_newspaper',array('client' => $rows['id']))->result_array();
			$count = 0;
			foreach($news_id as $rows1)
			{
				
				if(isset($_POST['total']))
				{
					$d1 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` ASC LIMIT 1")->result_array();
					$d2 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
					foreach($d1 as $rows2) $from= $rows2['date']; 
					foreach($d2 as $rows3) $to= $rows3['date'];
					$dte = $from.' to '.$to;
					$dated = date('M Y', strtotime($from)).' to '.date('M Y', strtotime($to)) ;
					$sql = $this->db->get_where('cat_result',array('news_id' => $rows1['id']))->result_array();			
				
				}elseif(isset($_POST['prevmonth']))
				{
					$dte = date('Y-m', strtotime(' -1 month'));
					$dated = date('M Y', strtotime(' -1 month'));
					$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id` = '".$rows1['id']."' AND `date` LIKE '$dte%' ")->result_array();
				
				}elseif(isset($_POST['last3month']))
				{
					$from = date('Y-m-01', strtotime(' -2 month'));
					$to = date('Y-m-d');
					$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
					$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id` = '".$rows1['id']."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
				
				}else{
					$dte = date('Y-m');
					$dated = date('M Y');
					$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id` = '".$rows1['id']."' AND `date` LIKE '$dte%' ")->result_array();
				
				}
				
				//$sql = $this->db->get_where('cat_result',array('news_id' => $rows1['id']))->result_array();
				$count = count($sql) + $count;
			}
			$r = (100 * $count)/100 ;
			$this->gcharts->DataTable('add')
                 ->addColumn('string', 'add', 'adrep_orders')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addRow(array($rows['name'] , $r));
		}
		     
		$config = array(
            'title' => '',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		$data['date'] = $dated;
        $this->load->view('management/chart', $data);
		
	}
	
	public function helpdesk_orders()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$hd_id = $this->db->get('help_desk')->result_array();
		foreach($hd_id as $rows)
		{
			
			$news_id = $this->db->get_where('cat_newspaper',array('help_desk' => $rows['id']))->result_array();
			$count = 0;
			foreach($news_id as $rows1)
			{
				if(isset($_POST['total']))
				{
					$d1 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` ASC LIMIT 1")->result_array();
					$d2 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
					foreach($d1 as $rows2) $from= $rows2['date']; 
					foreach($d2 as $rows3) $to= $rows3['date'];
					$dte = $from.' to '.$to;
					$dated = date('M Y', strtotime($from)).' to '.date('M Y', strtotime($to)) ;
					$sql = $this->db->get_where('cat_result',array('news_id' => $rows1['id']))->result_array();			
				
				}elseif(isset($_POST['prevmonth']))
				{
					$dte = date('Y-m', strtotime(' -1 month'));
					$dated = date('M Y', strtotime(' -1 month'));
					$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id` = '".$rows1['id']."' AND `date` LIKE '$dte%' ")->result_array();
				
				}elseif(isset($_POST['last3month']))
				{
					$from = date('Y-m-01', strtotime(' -2 month'));
					$to = date('Y-m-d');
					$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
					$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id` = '".$rows1['id']."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
				
				}else{
					$dte = date('Y-m');
					$dated = date('M Y');
					$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id` = '".$rows1['id']."' AND `date` LIKE '$dte%' ")->result_array();
				
				}
				//$sql = $this->db->get_where('cat_result',array('news_id' => $rows1['id']))->result_array();
				$count = count($sql) + $count;
			}
			$r = (100 * $count)/100 ;
			$this->gcharts->DataTable('add')
                 ->addColumn('string', 'add', 'helpdesk_orders')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addRow(array($rows['name'] , $r));
		}
		     
		$config = array(
            'title' => '',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		$data['date'] = $dated;
        $this->load->view('management/chart', $data);
		
	}
	
	public function category_orders()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$category = $this->db->get('print')->result_array();
		foreach($category as $rows)
		{	
			if(isset($_POST['total']))
			{
				$d1 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` ASC LIMIT 1")->result_array();
				$d2 = $this->db->query("SELECT `date` FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
				foreach($d1 as $rows2) $from= $rows2['date']; 
				foreach($d2 as $rows3) $to= $rows3['date'];
				$dte = $from.' to '.$to;
				$dated = date('M Y', strtotime($from)).' to '.date('M Y', strtotime($to)) ;
				//$sql = $this->db->get_where('cat_result',array('news_id' => $rows1['id']))->result_array();			
				$sql = $this->db->get_where('cat_result',array('category' => $rows['name']))->result_array();
			}elseif(isset($_POST['prevmonth']))
			{
				$dte = date('Y-m', strtotime(' -1 month'));
				$dated = date('M Y', strtotime(' -1 month'));
				$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `category` = '".$rows['name']."' AND `date` LIKE '$dte%' ")->result_array();
				
			}elseif(isset($_POST['last3month']))
			{
				$from = date('Y-m-01', strtotime(' -2 month'));
				$to = date('Y-m-d');
				$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
				$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `category` = '".$rows['name']."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
				
			}else{
				$dte = date('Y-m');
				$dated = date('M Y');
				$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `category` = '".$rows['name']."' AND `date` LIKE '$dte%' ")->result_array();
				
			}
				
			//$sql = $this->db->get_where('cat_result',array('category' => $rows['name']))->result_array();
			
			$r = (100 * count($sql))/100 ;
			$this->gcharts->DataTable('add')
                 ->addColumn('string', 'add', 'category_orders')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addRow(array($rows['name'] , $r));
		}
		     
		$config = array(
            'title' => '',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		$data['date'] = $dated;
        $this->load->view('management/chart', $data);
		
	}
	
	public function QA_error_chart()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$err_type = $this->db->get('dp_error_type')->result_array();
		foreach($err_type as $rows)
		{			
			$sql = $this->db->get_where('cp_error_result',array('error_type' => $rows['id']))->result_array();
			
			$r = (100 * count($sql))/100 ;
			$this->gcharts->DataTable('add')
                 ->addColumn('string', 'add', 'category_orders')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addRow(array($rows['name'] , $r));
		}
		     
		$config = array(
            'title' => '',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		
        $this->load->view('management/chart');
		
	}
	
	/* public function ordertype_chart()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$types = $this->db->get('orders_type')->result_array();
		
		foreach($types as $rows)
		{
			$sql = $this->db->get_where('orders',array('order_type_id' => $rows['id']))->result_array();
			$r = (100 * count($sql))/100 ;
			$this->gcharts->DataTable('add')
                      ->addColumn('string', 'add', 'addtype')
                      ->addColumn('string', 'Amount', 'amount')
                      ->addColumn('string', 'Amount', 'amount')
                      ->addRow(array($rows['name'] , $r));
		}
		     
		$config = array(
            'title' => 'Orders Type',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
        $this->load->view('management/chart');
		
	} */
	
	public function avgsq_inches01()
    {
		$this->load->library('gcharts');
		$this->gcharts->load('ColumnChart');
		
		$this->gcharts->DataTable('orders')
              ->addColumn('date', 'Year', 'month')
              ->addColumn('number', 'Avg SqInches', 'avg_sqinches');
			  
		$s = $this->db->query("SELECT * FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['date']; 
		 
		$created_on= '2014-12-11 12:11:20';
		$date_ts = date('Y-m-d', strtotime($created_on));
		//$d = date_parse_from_format("Y-m-d", $created_on);
		
		$data = array( 'mm' => date('m', strtotime($created_on)) ,'dd' => date('d', strtotime($created_on)) ,'yy' => date('Y', strtotime($created_on)) ,'date' => $date_ts  );
  		
		$month = $data['mm'];
		$day = $data['dd'];
		$year = $data['yy'];
		$date = $data['date'];
		
		for($a=1; $a <= $month; $a++)
		{
			$x = $month - $a;
			$dt = date('Y-m', strtotime(' -'.$x.' month', strtotime($date)));
			//$dt = date($date, strtotime(' -'.$a.' day'));
	
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `date` LIKE '$dt%' ")->result_array();	//web
			$size = 0; $avg = 0;
			foreach($sql as $rows1)
			{
				$size = $size + ($rows1['width'] * $rows1['height']);
			}
			if(count($sql)!='0'){$avg = $size / count($sql);}
			
			/*  echo 'size : '.$size."<br/>";
			echo 'count : '.count($sql)."<br/>";
			echo 'avg : '.round($avg, 2)."<br/>";
			echo 'date : '.$dt."<br/>"; */ 
			
			$data1 = array(
			//new jsDate($year,$month-$a,$a ,$date),
				new jsDate($year,$a), //Year
				round($avg, 2) 			
			);

			$this->gcharts->DataTable('orders')->addRow($data1);
		}

		//Either Chain functions together to setup configuration objects
		$titleStyle = $this->gcharts->textStyle()
                            ->color('#55BB9A')
                            ->fontName('Georgia')
                            ->fontSize(22);

		$legendStyle = $this->gcharts->textStyle()
                             ->color('#F3BB00')
                             ->fontName('Arial')
                             ->fontSize(16);

		//Or pass an array with configuration options
		$legend = new legend(array(
			'position' => 'right',
			'alignment' => 'start',
			'textStyle' => $legendStyle
		));

		$tooltipStyle = new textStyle(array(
			'color' => '#000000',
			'fontName' => 'Courier New',
			'fontSize' => 10
		));

		$tooltip = new tooltip(array(
			'showColorCode' => TRUE,
			'textStyle' => $tooltipStyle
		));

		$config = array(
			'axisTitlesPosition' => 'in',
			'backgroundColor' => new backgroundColor(array(
				'stroke' => '#CDCDCD',
				'strokeWidth' => 6,
				'fill' => '#EEFFCC'
			)),
			'barGroupWidth' => '10%',
			'chartArea' => new chartArea(array(
				'left' => 80,
				'top' => 80,
				'width' => '80%',
				'height' => '60%'
			)),
			'titleTextStyle' => $titleStyle,
			'legend' => $legend,
			'tooltip' => $tooltip,
			'title' => 'My Orders',
			'titlePosition' => 'out',
			'width' => 1000,
			'height' => 650,
			'colors' => array('#00A100', '#FF0000', '#00FF00'),
			'hAxis' => new hAxis(array(
				'baselineColor' => '#BB99BB',
				'gridlines' => array(
					'color' => '#ABCDEF',
					'count' => 1
				),
				'minorGridlines' => array(
					'color' => '#FEBCDA',
					'count' => 12
				),
				'textPosition' => 'out',
				'textStyle' => new textStyle(array(
					'color' => '#C42B5F',
					'fontName' => 'Tahoma',
					'fontSize' => 14
				)),
				'slantedText' => TRUE,
				'slantedTextAngle' => 70,
				'title' => 'Months',
				'titleTextStyle' => new textStyle(array(
					'color' => '#BB33CC',
					'fontName' => 'Impact',
					'fontSize' => 18
				)),
				'maxAlternation' => 2,
				'maxTextLines' => 10,
				'showTextEvery' => 1
			)),
			'vAxis' => new vAxis(array(
				'baseline' => 1,
				'baselineColor' => '#5F0BB1',
				'format' => '',
				'textPosition' => 'out',
				'textStyle' => new textStyle(array(
					'color' => '#DDAA88',
					'fontName' => 'Verdana',
					'fontSize' => 10
				)),
				'title' => 'Orders',
				'titleTextStyle' => new textStyle(array(
					'color' => 'blue',
					'fontName' => 'Verdana',
					'fontSize' => 14
					)),
			))
		);

		$this->gcharts->ColumnChart('Finances')->setConfig($config);

		$this->load->view('management/column_chart');
	}
	
	public function avgsq_inches()
	{
		$this->load->library('gcharts');
		$this->gcharts->load('LineChart');

		$dataTable = $this->gcharts->DataTable('orders');

		$dataTable->addColumn('date', 'Year', 'month');
		$dataTable->addColumn('number', 'Avg SqInches', 'avg_sqinches');
		
		$s = $this->db->query("SELECT * FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['date']; 
		 
		$created_on= '2014-12-11 12:11:20';
		$date_ts = date('Y-m-d', strtotime($created_on));
		//$d = date_parse_from_format("Y-m-d", $created_on);
		
		$data = array( 'mm' => date('m', strtotime($created_on)) ,'dd' => date('d', strtotime($created_on)) ,'yy' => date('Y', strtotime($created_on)) ,'date' => $date_ts  );
  		
		$month = $data['mm'];
		$day = $data['dd'];
		$year = $data['yy'];
		$date = $data['date'];
		
		for($a=1; $a <= $month; $a++)
		{
			$x = $month - $a;
			$dt = date('Y-m', strtotime(' -'.$x.' month', strtotime($date)));
			//$dt = date($date, strtotime(' -'.$a.' day'));
	
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `date` LIKE '$dt%' ")->result_array();	//web
			$size = 0; $avg = 0;
			foreach($sql as $rows1)
			{
				$size = $size + ($rows1['width'] * $rows1['height']);
			}
			if(count($sql)!='0'){$avg = $size / count($sql);}
			
			/*  echo 'size : '.$size."<br/>";
			echo 'count : '.count($sql)."<br/>";
			echo 'avg : '.round($avg, 2)."<br/>";
			echo 'date : '.$dt."<br/>"; */ 
			
			$data1 = array(
			//new jsDate($year,$month-$a,$a ,$date),
				new jsDate($year,$a), //Year
				round($avg, 2) 			
			);

			$this->gcharts->DataTable('orders')->addRow($data1);
		}

		$config = array(
			'title' => 'Stocks'
		);

		$this->gcharts->LineChart('Stocks')->setConfig($config);
		$this->load->view('management/line_chart');
	}
	
	public function num_ads01()
    {
		$this->load->library('gcharts');
		$this->gcharts->load('ColumnChart');
		
		$this->gcharts->DataTable('orders')
              ->addColumn('date', 'Year', 'month')
              ->addColumn('number', 'No Of Ads', 'num_ads');
			  
		$s = $this->db->query("SELECT * FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['date']; 
		 
		$created_on= '2014-12-11 23:11:20';
		$date_ts = date('Y-m-d', strtotime($created_on));
		//$d = date_parse_from_format("Y-m-d", $created_on);
		
		$data = array( 'mm' => date('m', strtotime($created_on)) ,'dd' => date('d', strtotime($created_on)) ,'yy' => date('Y', strtotime($created_on)) ,'date' => $date_ts  );
  		
		$month = $data['mm'];
		$day = $data['dd'];
		$year = $data['yy'];
		$date = $data['date'];
		
		for($a=1; $a <= $month; $a++)
		{
			$count = 0; 
			$x = $month - $a; 
			$dt = date('Y-m', strtotime(' -'.$x.' month', strtotime($date)));
			//$dt = date($date, strtotime(' -'.$a.' day'));
	
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `date` LIKE '$dt%' ")->result_array();	//web
						
			echo 'date : '.$dt."<br/>";  
			$count = count($sql); 
			echo 'count : '.$count."<br/>";
			$data1 = array(
			//new jsDate($year,$month-$a,$a ,$date),
				new jsDate($year,$a), //Year
				$count 			
			);

			$this->gcharts->DataTable('orders')->addRow($data1);
		}

		//Either Chain functions together to setup configuration objects
		$titleStyle = $this->gcharts->textStyle()
                            ->color('#55BB9A')
                            ->fontName('Georgia')
                            ->fontSize(22);

		$legendStyle = $this->gcharts->textStyle()
                             ->color('#F3BB00')
                             ->fontName('Arial')
                             ->fontSize(16);

		//Or pass an array with configuration options
		$legend = new legend(array(
			'position' => 'right',
			'alignment' => 'start',
			'textStyle' => $legendStyle
		));

		$tooltipStyle = new textStyle(array(
			'color' => '#000000',
			'fontName' => 'Courier New',
			'fontSize' => 10
		));

		$tooltip = new tooltip(array(
			'showColorCode' => TRUE,
			'textStyle' => $tooltipStyle
		));

		$config = array(
			'axisTitlesPosition' => 'in',
			'backgroundColor' => new backgroundColor(array(
				'stroke' => '#CDCDCD',
				'strokeWidth' => 6,
				'fill' => '#EEFFCC'
			)),
			'barGroupWidth' => '10%',
			'chartArea' => new chartArea(array(
				'left' => 80,
				'top' => 80,
				'width' => '80%',
				'height' => '60%'
			)),
			'titleTextStyle' => $titleStyle,
			'legend' => $legend,
			'tooltip' => $tooltip,
			'title' => 'My Orders',
			'titlePosition' => 'out',
			'width' => 1000,
			'height' => 650,
			'colors' => array('#00A100', '#FF0000', '#00FF00'),
			'hAxis' => new hAxis(array(
				'baselineColor' => '#BB99BB',
				'gridlines' => array(
					'color' => '#ABCDEF',
					'count' => 1
				),
				'minorGridlines' => array(
					'color' => '#FEBCDA',
					'count' => 12
				),
				'textPosition' => 'out',
				'textStyle' => new textStyle(array(
					'color' => '#C42B5F',
					'fontName' => 'Tahoma',
					'fontSize' => 14
				)),
				'slantedText' => TRUE,
				'slantedTextAngle' => 70,
				'title' => 'Months',
				'titleTextStyle' => new textStyle(array(
					'color' => '#BB33CC',
					'fontName' => 'Impact',
					'fontSize' => 18
				)),
				'maxAlternation' => 2,
				'maxTextLines' => 10,
				'showTextEvery' => 1
			)),
			'vAxis' => new vAxis(array(
				'baseline' => 1,
				'baselineColor' => '#5F0BB1',
				'format' => '',
				'textPosition' => 'out',
				'textStyle' => new textStyle(array(
					'color' => '#DDAA88',
					'fontName' => 'Verdana',
					'fontSize' => 10
				)),
				'title' => 'Orders',
				'titleTextStyle' => new textStyle(array(
					'color' => 'blue',
					'fontName' => 'Verdana',
					'fontSize' => 14
					)),
			))
		);

		$this->gcharts->ColumnChart('Finances')->setConfig($config);

		$this->load->view('management/column_chart');
	}

	public function num_ads()
	{
		$this->load->library('gcharts');
		$this->gcharts->load('LineChart');

		$dataTable = $this->gcharts->DataTable('orders');

		$dataTable->addColumn('date', 'Year', 'month');
		$dataTable->addColumn('number', 'No Of Ads', 'num_ads');
		
		$s = $this->db->query("SELECT * FROM `cat_result` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['date']; 
		 
		$created_on= '2014-12-11 23:11:20';
		$date_ts = date('Y-m-d', strtotime($created_on));
		//$d = date_parse_from_format("Y-m-d", $created_on);
		
		$data = array( 'mm' => date('m', strtotime($created_on)) ,'dd' => date('d', strtotime($created_on)) ,'yy' => date('Y', strtotime($created_on)) ,'date' => $date_ts  );
  		
		$month = $data['mm'];
		$day = $data['dd'];
		$year = $data['yy'];
		$date = $data['date'];
		
		for($a=1; $a <= $month; $a++)
		{
			$count = 0; 
			$x = $month - $a; 
			$dt = date('Y-m', strtotime(' -'.$x.' month', strtotime($date)));
			//$dt = date($date, strtotime(' -'.$a.' day'));
	
			$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `date` LIKE '$dt%' ")->result_array();	//web
						
			//echo 'date : '.$dt."<br/>";  
			$count = count($sql); 
			//echo 'count : '.$count."<br/>";
			$data1 = array(
			//new jsDate($year,$month-$a,$a ,$date),
				new jsDate($year,$a), //Year
				$count 			
			);

			$this->gcharts->DataTable('orders')->addRow($data1);
		}

		$config = array(
			'title' => 'Stocks'
		);

		$this->gcharts->LineChart('Stocks')->setConfig($config);
		$this->load->view('management/line_chart');
	}
	
	public function emp()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$sql1 = $this->db->get_where('csr',array('is_active' => '1'))->result_array();
		$sql2 = $this->db->get_where('designers',array('is_active' => '1'))->result_array();
		/* foreach($err_type as $rows)
		{			
			
			
			$r = (100 * count($sql))/100 ;
			$this->gcharts->DataTable('add')
                 ->addColumn('string', 'add', 'category_orders')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addRow(array($rows['name'] , $r));
		} */
			$r = (100 * count($sql1))/100 ;
			$s = (100 * count($sql2))/100 ;
			$this->gcharts->DataTable('add')
                 ->addColumn('string', 'add', 'category_orders')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addColumn('string', 'Amount', 'amount')
                 ->addRow(array('CSR' , $r))
				 ->addRow(array('Designer' , $s));
			 
		$config = array(
            'title' => '',
            'pieHole' => .2
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		
        $this->load->view('management/chart');
		
	}

	public function billing_view($form = '', $display_type = 'approved')
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		if($form!='')
		{
			$data['form'] = $form;
			$data['display_type'] = $display_type;
			if(isset($_POST['id']))
			{
				$dataa = array('billing_status' => $_POST['status']);
				$this->db->where('id', $_POST['id']);
				$this->db->update('archive_catresult', $dataa);
			}
			//$data['form'] = $form;
		}
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['today'] = date('Y-m-d');
		// $data['ystday'] = date('y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		
		
		$this->load->view('management/billing_view',$data);
	}

	public function billing()
	{
		$data['hi'] = 'hello';
		if(isset($_POST['search']))
		{
			$order = $this->db->get_where('cat_result',array('order_no' => $_POST["order_chk"]))->result_array();
			if($order)
			{
				$data['order'] = $order;
			}else{
				$data['error_data'] = "No result found!!";
			}
		}
		if(isset($_POST['status']))
		{
			$dataa = array('billing_status' => $_POST['status']);
			$this->db->where('id', $_POST['id']);
			$this->db->update('cat_result', $dataa);
			if(!empty($_POST['reason']))
			{
				$data2 = array( 'order_no' => $_POST['order_no'],
								'cat_result_id' => $_POST['id'],
								'reason' => $_POST['reason'],
								'status' => $_POST['status'] );
				$this->db->insert('orders_billing_status', $data2);
			}
		}
		$this->load->view('management/billing',$data);
			
	}
	
	public function billing_monthly($form = '')
	{
		$data['hi'] = 'hello';
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		if($form != '')
		{
			$data['form'] = $form;
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$data['from'] = $_POST['from_date'];
				$data['to'] = $_POST['to_date'];
				$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$form' AND (`date` BETWEEN '".$_POST['from_date']."' AND '".$_POST['to_date']."') ;")->result_array();
			}else{
				$today = date('Y-m-d');
				$pystday = date('Y-m-d', strtotime('-3 day'));
				$data['today'] = $today;
				$data['pystday'] = $pystday;
				$cat = $this->db->query("SELECT * FROM `cat_result` WHERE `news_id`='$form' AND (`date` BETWEEN '$today' AND '$pystday') ;")->result_array();
			}
			$data['cat'] = $cat;
		}
		$this->load->view('management/billing_monthly',$data);
	}
	
}