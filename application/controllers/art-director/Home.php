<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Art_Controller {

	public function index()
	{	
	/*	$notification = $this->db->get_where('notification',array('users'=>'1', 'job_status'=>'1'))->result_array();
		if($notification)
		{
			foreach($notification as $x)
			{
			
				$end_date = $x['end_date'];
				$datetime1 = new DateTime('2014-01-01');
				$datetime2 = new DateTime(Date('Y-m-d'));
				$interval = $datetime1->diff($datetime2);
				$y = $interval->format('%R%a days');
				echo $y;
				
				if($y>=0)
				{
					$dataa = array('job_status' => 'deactive'); 
					$this->db->where('id', $x['id']);
					$this->db->update('notification', $dataa);
				}
				
			}
		}*/
		$this->load->view('art-director/home');
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('art-director/change',$data);
	}
	
	public function dochange()
	{
		$this->db->query("Update art_director set password='".md5($this->input->post('new_password'))."' where (username='".$this->session->userdata('art')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->my_account('Your password has been changed successfully!', 'darkgreen');
		else
			$this->my_account('Invalid current password!', 'darkred');
	}
	
	public function error_report()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array() ;
		$prev_month = date("Y-m", strtotime("-1 month"));
		
		$data['designer'] = $designer;
		$data['prev_month'] = $prev_month;
		$data['today'] = date("Y-m-d");
		
		$this->load->view('art-director/error-report',$data);
	}
	
	public function report1()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			
			$data['from'] = $from;
			$data['to'] = $to;
			
		}
		$designer = $this->db->get('designers')->result_array();
		$today = date("Y-m-d");
		$data['today'] = $today;
		$data['designer'] = $designer;
		
		$this->load->view('art-director/report1',$data);
	}
	
	public function report2()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			
			$data['from'] = $from;
			$data['to'] = $to;
			
		}
		$csr = $this->db->get('csr')->result_array();
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$data['ystday'] = $ystday;
		$data['csr'] = $csr;
		
		$this->load->view('art-director/report2',$data);
		
	}
	
	
	public function BG_performance()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['business_group'] = $this->db->get('business_groups')->result_array();
		$data['today'] = date('Y-m-d');
		$this->load->view('art-director/BG-performance',$data );
		
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
		$data['today'] = date('Y-m-d');
		$this->load->view('art-director/pub-performance',$data );
	
	}
	

	public function production()
	{ 	
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['today'] = date('Y-m-d');
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array() ;
		
		$data['designer'] = $designer;
		
		$this->load->view('art-director/production',$data);
	}
	
	public function production_table()
	{ 	
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$designer = $this->db->get('designers')->result_array() ;
		
		$data['designer'] = $designer;
		
		$this->load->view('art-director/production-table',$data);
	}
	
	
	public function trouble_ticket()
	{
		$data['hi'] = 'hi';
		if(!empty($_POST['cname']) && !empty($_POST['IT_problem']) && !empty($_POST['description']))
		{
			$data = array(
							'art_director' => $this->session->userdata('aId'),
							'cname' => $_POST['cname'], 
							'IT_problem' => $_POST['IT_problem'],
							'description' => $_POST['description'],
						);
			$this->db->insert('trouble_ticket', $data);
			$data['tt_status'] = "Submitted!!";
		}
		
		$this->load->view('art-director/admin-support',$data);
	}
	
	public function admin_support()
	{
		$data['hi'] = 'hi';
		if(!empty($_POST['department']) && !empty($_POST['description']))
		{
			$data = array(
							'art_director' => $this->session->userdata('aId'),
							'department' => $_POST['department'], 
							'description' => $_POST['description'],
						);
			$this->db->insert('admin_support', $data);
			$data['as_status'] = "Submitted!!";
		}
		$this->load->view('art-director/admin-support',$data);
	}
	
	public function shift_factor()
	{
		$data['hi'] = 'hi';
		
		if(isset($_POST['submit']))
		{
			$data = array( 'status' => 'approved' );
			$this->db->where('id', $_POST['id']);
			$this->db->update('designer_additional_hours', $data);
			
			$data = array( 'shift_factor_status' => $_POST['hours'] );
			$this->db->where('id', $_POST['did']);
			$this->db->update('designers', $data);
			//$this->db->insert('designer_additional_hours', $data);
		}
		$designers = $this->db->get('designer_additional_hours')->result_array();
		if($designers) $data['designers'] = $designers;
		$this->load->view('art-director/shift-factor', $data);
	}

	public function team_report()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['today'] = date('Y-m-d');
		$data['designer'] = $this->db->get('designers')->result_array();
		$this->load->view('art-director/team_report', $data); 
		
	}
	
	public function designer_productivity()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		//$designer = $this->db->get('designers')->result_array() ;
		$designer = $this->db->get_where('designers',array('is_active' => '1'))->result_array() ;
		
		$data['designer'] = $designer;
		
		$this->load->view('art-director/designer-productivity',$data);
	}
	
	public function team_productivity()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$team = $this->db->get('teams')->result_array() ;
		
		$data['team'] = $team;
		
		$this->load->view('art-director/team-productivity',$data);
	}
	
	public function location_productivity()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$location = $this->db->get('location')->result_array() ;
		
		$data['location'] = $location;
		
		$this->load->view('art-director/location-productivity',$data);
	}
	
	public function joblist($form = '')
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -4 day'));
		//$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		if($form!='')
		{
			$data['form'] = $form;
			$data['publications'] = $this->db->get_where('publications',array('group_id' => $form))->result_array();
		}
		//$data['publications'] = $this->db->get_where('publications',array('group_id' => $form))->result_array();
		$this->load->view('art-director/joblist',$data);
	}
	
	public function newadreport()
	{
		if(!empty($_POST['publication'])){
			$publication_id = $_POST['publication'];
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
			}else{
				$from = date('Y-m-d');
				$to = date('Y-m-d', strtotime(' -4 day'));
			}
			$data['publication_id'] = $publication_id;
			$data['from'] = $from;
			$data['to'] = $to;
			$data['orders'] = $this->db->query("SELECT * from `orders` WHERE `publication_id`='$publication_id' AND `crequest`='0' AND `cancel`='0' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 00:00:00' );")->result_array();
			/*SELECT orders.id, orders.width, orders.width, cat_result.category
			FROM orders
			INNER JOIN cat_result
			ON orders.id=cat_result.order_no;*/
			$data['publication_name'] = $this->db->get_where('publications', array('id'=>$publication_id))->result_array();
			//$data['orders'] = $this->db->get_where('orders', array('publication_id'=>$publication_id, 'crequest'=>'0', 'cancel'=>'0'))->result_array();
		}
		$data['publications'] = $this->db->get_where('publications', array('is_active'=>'1'))->result_array();
		$this->load->view('art-director/newadreport',$data);
	}
	
	
	public function perfect_ads()
	{
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -3 day'));
		
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$designer = $this->db->get_where('designers',array('is_active' => '1'))->result_array() ;
		
		$data['designer'] = $designer;
		$this->load->view('art-director/perfect_ads',$data);
	}
	
	public function pending_jobs()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['cat_result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `ddate` BETWEEN '$from' AND '$to' ;")->result_array();
		}else{
			$data['cat_result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `ddate` BETWEEN '2014-11-16' AND '2014-11-22' ;")->result_array();
		}
		$this->load->view('art-director/pending_jobs', $data);
	}
	
	public function pending_design()
	{
		$today = date('Y-m-d', strtotime(' -1 day'));
		$data['cat_result'] = $this->db->get_where('cat_result',array('date' => $today, 'designer' => '0'))->result_array();
		$this->load->view('art-director/pending_design', $data);
	}
	
	public function pending_QA()
	{
		$today = date('Y-m-d', strtotime(' -1 day'));
		$data['cat_result'] = $this->db->get_where('cat_result',array('date' => $today, 'designer !=' => '0'))->result_array();
		$this->load->view('art-director/pending_QA', $data);
	}
	
	public function udupi()
	{
		//$data['designer'] = $this->db->get_where('designers',array('Join_location' => '4'))->result_array() ;
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
		$data['today'] = date('Y-m-d', strtotime(' -1 day'));
		
		$this->load->view('art-director/udupi', $data);
	}
	public function newpublication($edit='')
	{ 
	    if($edit!='')
		{
		$type = $this->db->get_where('publications',array('id' => $edit))->result_array() ;
			   $data['type'] = $type;	
		       $data['edit'] = $edit;
			    $this->load->view('art-director/new_form', $data);
	} else {
	        $newpublication = $this->db->query("SELECT * FROM `publications` WHERE `is_active`= '1'")->result_array();
				$data['newpublication'] = $newpublication;	
				$this->load->view('art-director/newpublication',$data);
	        }

	}

	public function save_form()
    { 
	    if($_POST['pname'] && $_POST['channel'])
		{
		   $data = array(
		                 'name' => $_POST['pname'],
						 'team_lead_id' => $_POST['tlname'],
						 'channel' => $_POST['channel']
						);
		                $this->db->where('id', $_POST['id']);
				        $this->db->update('publications', $data);
		}
		$data['newpublication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active`= '1'")->result_array();
		$this->load->view('art-director/newpublication', $data);
	}		

	public function new_designer($edit='')
	{  
	if($edit!='')
		{
		$type = $this->db->get_where('designers',array('id' => $edit))->result_array() ;
			   $data['type'] = $type;	
		       $data['edit'] = $edit;
			    $this->load->view('art-director/designer_details', $data);
	} else {
			$designer = $this->db->query("SELECT * FROM `designers` WHERE `is_active`= '1'")->result_array();
			$data['designer'] = $designer;	
			$this->load->view('art-director/new_designer',$data);
			}	

	}
	
	public function save_form1()
    { 
	         
			  if($_POST['dname'] && $_POST['location'])
		   {
		   $data = array(
		                     'name' => $_POST['dname'],
							'design_team_lead' => $_POST['tlname'],
							'Join_location' => $_POST['location']
						
		   );
		                 $this->db->where('id', $_POST['id']);
				        $this->db->update('designers', $data);
						
		   }
		    $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active`= '1'")->result_array();
		    $this->load->view('art-director/new_designer', $data);
			
	}		
	public function active_deactive()
	{ 
	         $designer_id= $this->input->post('designer_id');
		     $result= $this->input->post('result');
		     $tlead_id= $this->input->post('tlead_id');
			 if(!empty($designer_id))
			 {
			if($result=='0'){ $result='1'; }else{ $result='0'; }
			 $data = array( 'is_active' => $result );
			 $this->db->where('id', $designer_id);
			 $this->db->update('designers', $data); 
			 }
			  if(!empty($tlead_id))
			 {
			if($result=='0'){ $result='1'; }else{ $result='0'; }
			 $data = array( 'is_active' => $result );
			 $this->db->where('id', $tlead_id);
			 $this->db->update('team_lead', $data); 
			 }
	}
	
	
	public function new_teams($edit='')
	{ 
	if($edit!='')
		{
		$type = $this->db->get_where('team_lead',array('id' => $edit))->result_array() ;
			   $data['type'] = $type;	
		       $data['edit'] = $edit;
			    $this->load->view('art-director/tlead_details', $data);
	} else {
	       $team_lead = $this->db->query("SELECT * FROM `team_lead` WHERE is_active='1'")->result_array();
		   $data['team_lead'] = $team_lead;	
		  $this->load->view('art-director/new_teams' , $data);
	       } 

	}
	 public function update_tlead()
    { 
	         
			  if($_POST['location'])
		   {
		   $data = array(
		                     'Join_location' => $_POST['location']
							
						
		   );
		                 $this->db->where('id', $_POST['id']);
				        $this->db->update('team_lead', $data);
						
		   }
		    $data['team_lead'] = $this->db->query("SELECT * FROM `team_lead`")->result_array();
		    $this->load->view('art-director/new_teams', $data);
			
	}		
	
	public function deactive_designer()
	{
	        $designer = $this->db->query("SELECT * FROM `designers` WHERE is_active='0'")->result_array();
			$data['designer'] = $designer;	
			$data['value'] = '0';
			$this->load->view('art-director/new_designer',$data);
	}
	public function deactive_tlead()
	{
	        $team_lead = $this->db->query("SELECT * FROM `team_lead` WHERE is_active='0'")->result_array();
			$data['team_lead'] = $team_lead;	
			$data['value'] = '0';
			$this->load->view('art-director/new_teams',$data);
	}
	public function add_designer()
	{
 if(!empty($_POST['name']) && !empty($_POST['uname']))
		 {
		  $data = array(
						'name' => $_POST['name'],
                        'design_team_lead' => $_POST['tlead'],						
                        'gender' => $_POST['gender'],						
                        'email_id' => $_POST['email'],						
                        'mobile_no' => $_POST['mobile'],						
                        'username' => $_POST['uname'],						
                        'Join_location' => $_POST['location'],						
                        'password' => md5($_POST['password']),						
                        'is_active' => $_POST['active'],						
                        'shift_factor' => $_POST['shift_factor']						
				  
		  );
		        
		  	$this->db->insert('designers', $data);
		  
		 }
	       
			$this->load->view('art-director/designer_form');
	}
	public function add_tlead()
	{
	      if(!empty($_POST['fname']) && !empty($_POST['uname']))
		 {
		  $data = array(
						'first_name' => $_POST['fname'],
                        'last_name' => $_POST['lname'],						
                        'gender' => $_POST['gender'],						
                        'email_id' => $_POST['email'],						
                        'mobile_no' => $_POST['mobile'],						
                        'username' => $_POST['uname'],						
                        'Join_location' => $_POST['location'],						
                        'password' => md5($_POST['password']),						
                        'is_active' => $_POST['active']						
             );          						
					$this->db->insert('team_lead', $data);  
		  } 
		        
		  	$this->load->view('art-director/add_tlead');
	}	
          public function deshboard()
	{
			$data['today'] = date("Y-m-d");
			//$date = date("Y-m-d");
			$tday= date('Y-m-d');
			$ystday = date('Y-m-d', strtotime(' -1 day'));
			
	$metro = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel', 'cat_result.ddate','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '1' AND cat_result.ddate='$tday'")->result_array();
			$data['metro'] = $metro;	 
	$TS = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel', 'cat_result.ddate','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '2' AND cat_result.ddate='$tday'")->result_array();
			$data['TS'] = $TS;	
   $Softwrite = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel', 'cat_result.ddate','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '3' AND cat_result.ddate='$tday'")->result_array();
			$data['Softwrite'] = $Softwrite;	
   $Canada = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel', 'cat_result.ddate','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '4' AND cat_result.ddate='$tday'")->result_array();
			$data['Canada'] = $Canada;		

			$metro_pending = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel','cat_result.slug', 'cat_result.date','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '1' AND cat_result.date='$tday' AND cat_result.slug = 'none'")->result_array();
			$data['metro_pending'] = $metro_pending;
			$softwrite_pending = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel','cat_result.slug', 'cat_result.date','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '3' AND cat_result.date='$tday' AND cat_result.slug='none'")->result_array();
			$data['softwrite_pending'] = $softwrite_pending;
			$TS_pending = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel','cat_result.slug', 'cat_result.date','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '2' AND cat_result.date='$tday' AND cat_result.slug='none'")->result_array();
			$data['TS_pending'] = $TS_pending;
			$canada_pending = $this->db->query("SELECT 'cat_result.publication_id' ,'publications.channel','cat_result.slug', 'cat_result.date','publications.id' FROM `cat_result` , `publications` WHERE publications.id =cat_result.publication_id AND publications.channel = '4' AND cat_result.date='$tday' AND cat_result.slug='none'")->result_array();
			$data['canada_pending'] = $canada_pending;
	$this->load->view('art-director/deshboard' ,$data);
	
	}
	public function live_ads($channel='',$publication='')
	{
	       $data['display_type'] = 'pending';
		   $today = date('Y-m-d');
			 $ptday = date('Y-m-d', strtotime(' -2 day'));
	      if(!empty($channel))
		  {
		    $data['result'] = $this->db->query("SELECT * FROM `publications`,`cat_result`  WHERE `date` BETWEEN '$ptday' AND '$today' AND publications.id =cat_result.publication_id AND publications.channel='$channel' AND cat_result.pdf_path='none' AND cat_result.cancel!='1' ORDER BY date DESC")->result_array();
		 // $data['result'] = $this->db->query("SELECT `date`,`order_no` ,`slug`, `publication_id`,`job_name`,'cat_result.publication_id' ,'cat_result.slug' ,'cat_result.cancel','publications.channel','cat_result.order_no', 'cat_result.job_name', 'cat_result.date','publications.id' FROM `cat_result` , `publications` WHERE `date` BETWEEN '2015-07-01' AND '$tday' AND publications.id =cat_result.publication_id AND publications.channel='$channel' AND cat_result.slug='none' AND cat_result.cancel!='1'")->result_array();
		  
		 } else {
			$data['result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `date` BETWEEN '$ptday' AND '$today' AND `pdf_path`='none' AND `cancel`!='1' ")->result_array();
	     }   
		   if(!empty($channel) && !empty($publication))
		 {
	        $data['result'] = $this->db->query("SELECT * FROM `publications`,`cat_result` WHERE `date` BETWEEN '$ptday' AND '$today' AND publications.id =cat_result.publication_id AND cat_result.publication_id='$publication' AND publications.channel='$channel' AND cat_result.pdf_path='none' AND cat_result.cancel!='1' ")->result_array();
		 }
			 $data['publication'] = $publication;
			 $data['channel'] = $channel;
			 $this->load->view('art-director/live_ads', $data);
	}
     public function live_ads_pending_all($channel='',$publication='')
	{
	    $today = date('Y-m-d');
	    $ptday = date('Y-m-d', strtotime(' -2 day'));
	
	     if(!empty($channel))
		  {
		   $data['result'] = $this->db->query("SELECT * FROM `publications`,`cat_result` WHERE `date` BETWEEN '$ptday' AND '$today' AND publications.id =cat_result.publication_id AND publications.channel='$channel'")->result_array();
		 //$data['result'] = $this->db->query("SELECT `date`,`order_no` ,`slug`, `publication_id`,`job_name`,'cat_result.publication_id' ,'cat_result.slug' ,'cat_result.cancel','publications.channel','cat_result.order_no', 'cat_result.job_name', 'cat_result.date','publications.id' FROM `cat_result` , `publications` WHERE `date` BETWEEN '$ptday' AND '$today' AND publications.id =cat_result.publication_id AND publications.channel='$channel' AND cat_result.slug='none'")->result_array();
		  } else {
			$data['result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `date` BETWEEN '$ptday' AND '$today'")->result_array();
	     }   
		 if(!empty($channel) && !empty($publication))
		  {
	         $data['result'] = $this->db->query("SELECT * FROM `publications`,`cat_result` WHERE `date` BETWEEN '$ptday' AND '$today' AND publications.id =cat_result.publication_id AND cat_result.publication_id='$publication' AND publications.channel='$channel' ")->result_array();
		  }
		  $data['publication'] = $publication;
		 $data['channel'] = $channel;
		 $data['display_type'] = 'pending';
		 $data['display_type'] = 'all';
		 $this->load->view('art-director/live_ads_pending', $data);
	 
	
	}
	  
	 public function live_ads_view($id='')
	{

		$order = $this->db->get_where('orders',array('id' => $id))->result_array();

		if(isset($order[0]['id']))

		{
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

			$publications = $this->db->get_where('publications',array('id' => $order[0]['publication_id']));
            
				$job = $this->db->get_where('orders',array('id' => $order[0]['id']));
			

			foreach($job->result_array() as $row)
			{
			
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $row['job_no']);
				
			}

			foreach($publications->result_array() as $row)
			{
				$bg_id=$row['business_group_id'];

				$pname=$row['name'];
			}

			$bg=$this->db->get_where('business_groups',array('id' => $bg_id));

			foreach($bg->result_array() as $row)
			{
				$bg_name=$row['name'];
			}
			$ddate=$this->db->get_where('orders',array('id' => $id));
			
			foreach($ddate->result_array() as $row)
			{
				$ddate=$row['created_on'];
			}
			$new_date = date('d-M-Y', strtotime($ddate));
			
			$month = date('M', strtotime($ddate));
 
			$dir="weborders_downloads/".$bg_name;

			$dir1=$dir.'/'.$pname;
        
			$date=date('M-d');
			
			$dir2=$dir1.'/'.$month;
			
			$dir3=$dir2.'/'.$new_date;

			$dir4=$dir3.'/'.$jname.'-'.$id;
			
            $data['dir4'] = $dir4;
		     $data['orderp'] = $id;
			
        $this->load->view('art-director/viewdetails',$data);
    }
        }  	
	 
	    public function live_ads_view_orders($id='')
	{
	  $order = $this->db->get_where('orders',array('id' => $id))->result_array();

		if(isset($order[0]['id']))

		{
			
			$order[0]['publish_date'] = date("d-m-Y", strtotime($order[0]['publish_date']));	

			$order[0]['date_needed'] = date("d-m-Y", strtotime($order[0]['date_needed']));

			//$order[0]['created_on'] = date("d-m-Y", strtotime($order[0]['created_on']));

			$order_type = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();	
			
			$ad_type = $this->db->get_where('ads_type',array('id' => $order[0]['spec_sold_ad']))->result_array();
			
			$html_type = $this->db->get_where('html_type',array('id' => $order[0]['html_type']))->result_array();

			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
            
        
			$data = array();
			
			$data['order_type'] = $order_type[0];
			
			$data['ad_type'] = $ad_type[0];
			
				if ($order_type[0]['value'] == 'html_order')
				{
					$data['html_type'] = $html_type[0];
				}

			$data['order'] = $order[0];
	        $this->load->view('art-director/view_order',$data);

        }
 	}
	public function live_ads_view_sourcefile($id='')
	{
	$order = $this->db->get_where('orders',array('id' => $id))->result_array();

			if(isset($order[0]['id']))

		{
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

			$publications = $this->db->get_where('publications',array('id' => $order[0]['publication_id']));
            
				$job = $this->db->get_where('orders',array('id' => $order[0]['id']));
			

			foreach($job->result_array() as $row)
			{
			
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $row['job_no']);
				
			}

			foreach($publications->result_array() as $row)
			{
				$bg_id=$row['business_group_id'];

				$pname=$row['name'];
			}
           
			$bg=$this->db->get_where('business_groups',array('id' => $bg_id));

			foreach($bg->result_array() as $row)
			{
				$bg_name=$row['name'];
			}
			$ddate=$this->db->get_where('orders',array('id' => $id));
			
			foreach($ddate->result_array() as $row)
			{
				$ddate=$row['created_on'];
			}
			$new_date = date('d-M-Y', strtotime($ddate));
		
			$month = date('M', strtotime($ddate));
          
			$dir="weborders_downloads/".$bg_name;

			$dir1=$dir.'/'.$pname;
        
			$date=date('M-d');
			
			$dir2=$dir1.'/'.$month;
			
			$dir3=$dir2.'/'.$new_date;

			$dir4=$dir3.'/'.$jname.'-'.$id;
			
            
	$dir5=$dir4.'/'."sourcefile";
	

			$dir6=$dir5.'/'."Document fonts";

			$dir7=$dir5.'/'."Links";
				
			
			
			//to create folders
			
			if (@mkdir($dir5,0777))

			{

			}

		
			if	(@mkdir($dir6,0777))

			{

			}
			

			if (@mkdir($dir7,0777))

			{

			}
	    }
	}
	
	public function my_profile($num_days='')
	{
		$data['today'] = date('Y-m-d');
		if($num_days!=''){
			$data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
			$data['to'] = date('Y-m-d');
		}
		$data['num_days'] = $num_days;
		$data['designer'] = $this->db->get_where('designers',array('is_active'=>'1'))->result_array();
		//$data['designer'] = $this->db->query("SELECT * FROM `designers` ")->result_array();
		
		$this->load->view('art-director/my_profile',$data);
	}
	 public function my_account($error = '', $color = 'darkred')
	{
	     if($error) $data['error'] = $error;
		$data['color'] = $color;
		$this->load->view('art-director/my_account', $data);
	}	
	
	public function savepic()
	{
	  
	    if(!empty($_POST['first_name']))	
	   {	   
	      $data = array('first_name' => $_POST['first_name'],);
	      $this->db->where('id', $_POST['aid']);
		  $this->db->update('art_director', $data); 
		 $this->my_account("changed successfully!!", 'darkred');
	   }  
	    elseif(!empty($_POST['last_name']))	
	   {	   
	      $data = array('last_name' => $_POST['last_name'],);
	      $this->db->where('id', $_POST['aid']);
		  $this->db->update('art_director', $data); 
		 $this->my_account("changed successfully!!", 'darkred');
	   }  
	    elseif(!empty($_POST['mobile_no']))	
	   {	   
	      $data = array('mobile_no' => $_POST['mobile_no'],);
	      $this->db->where('id', $_POST['aid']);
		  $this->db->update('art_director', $data); 
		 $this->my_account("changed successfully!!", 'darkred');
	   }
	   elseif(!empty($_FILES['file']['name']))	
	   {
	   $photo=$_FILES['file']['name'];
	$data = array(
				'image_path' => $photo
              );
    
			$this->db->where('id', $_POST['aid']);
			$this->db->update('art_director', $data); 
	move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
		echo "<script>window.location.href='".base_url().index_page()."art-director/home/my_account#tab_1_2'</script>";	
	   }
	   
	   else{
           $this->my_account("Error!!", 'darkred'); 
       }	   
	}

    public function lock()
	{
	    $data['hi']="hi";
	    if(!empty($_POST['password']))
		 {
		 $check = $this->db->get_where('art_director',array('password' =>md5($_POST['password']), 'id'=>($_POST['aid'])))->result_array();
		 if($check==true)
		 {
		redirect('art-director/home');
		 } else { $data['psd'] = "Wrong Password Please Try Again!!";}
		 }
		$this->load->view('art-director/lock', $data);
	}		
	public function help()
	{
		$this->load->view('art-director/help');
	}	
	public function teams()
	{
		$this->load->view('art-director/teams');
	}	
	public function test()
	{
		$this->load->view('art-director/test');
	}	
	public function manage()
	{
		if(!empty($_POST['designer']))
		{
		$data = array(
							'designer_id' => $_POST['designer'],
							'help_desk_id' => $_POST['team']
						);
			$this->db->insert('designer_assign', $data);
		}	
		if(!empty($_POST['tlead']))
		{
		$check = $this->db->get_where('team_lead_assign',array('team_lead_id' => $_POST['tlead'], 'help_desk_id' => $_POST['team']))->result_array();
		if(!$check)
		{
		$data = array(
							'team_lead_id' => $_POST['tlead'],
							'help_desk_id' => $_POST['team']
						);
			$this->db->insert('team_lead_assign', $data);
		}
        }		
		$this->load->view('art-director/teams');
	}
    public function today_load()
	{
		$this->load->view('art-director/today_load');
	}	
    Public function delete()
	{
	         $id= $this->input->post('id');
		     $d_id= $this->input->post('d_id');
		     $t_id= $this->input->post('t_id');
			 if(!empty($id) && !empty($d_id))
			 {
			$this->db->query("DELETE  FROM `designer_assign` WHERE `designer_id` = '$id' AND  `help_desk_id`='$d_id'");
			 }
			 if(!empty($id) && !empty($t_id))
			 {
			$this->db->query("DELETE  FROM `team_lead_assign` WHERE `team_lead_id` = '$id' AND  `help_desk_id`='$t_id'");
			 }
			 $this->load->view('art-director/teams');
	}
	
	public function rev_production($num_days='')
	{
		$data['today'] = date('Y-m-d');
		if($num_days!=''){
			$data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
			$data['to'] = date('Y-m-d');
		}
		$data['num_days'] = $num_days;
		$data['designer'] = $this->db->get_where('designers',array('is_active'=>'1'))->result_array();
		//$data['designer'] = $this->db->query("SELECT * FROM `designers` ")->result_array();
		
		$this->load->view('art-director/rev_production',$data);
	}	
 }	 
