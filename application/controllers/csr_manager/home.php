<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Cmanager_Controller {

	public function index()
	{
		$this->load->view('csr_manager/home');
	}
	
	public function shutdown()
	{
		$this->session->sess_destroy();
		redirect('');
	}
	public function csrs($edit='')
	{  
	if($edit!='')
		{
		$type = $this->db->get_where('csr',array('id' => $edit))->result_array() ;
			   $data['type'] = $type;	
		       $data['edit'] = $edit;
			    $this->load->view('csr_manager/csr_details', $data);
	} else {
			$csr = $this->db->query("SELECT * FROM `csr` WHERE `is_active`= '1'")->result_array();
			$data['csr'] = $csr;	
			$this->load->view('csr_manager/csrs',$data);
			}	

	}
	public function dactive_csrs()
	{
	        $csr = $this->db->query("SELECT * FROM `csr` WHERE is_active='0'")->result_array();
			$data['csr'] = $csr;	
			$data['value'] = '0';
			$this->load->view('csr_manager/csrs',$data);
	}
	public function add_new()
	{
			$this->load->view('csr_manager/add_new');
	}
	public function active_deactive()
	{ 
	         $csr_id= $this->input->post('csr_id');
		     $result= $this->input->post('result');
		     $tlead_id= $this->input->post('tlead_id');
			 if(!empty($csr_id))
			 {
			if($result=='0'){ $result='1'; }else{ $result='0'; }
			 $data = array( 'is_active' => $result );
			 $this->db->where('id', $csr_id);
			 $this->db->update('csr', $data); 
			 }
			  if(!empty($tlead_id))
			 {
			if($result=='0'){ $result='1'; }else{ $result='0'; }
			 $data = array( 'is_active' => $result );
			 $this->db->where('id', $tlead_id);
			 $this->db->update('team_lead', $data); 
			 }
	}
	public function add_csr()
	{
 if(!empty($_POST['name']) && !empty($_POST['uname']))
		 {
		  $data = array(
						'name' => $_POST['name'],			
                        'gender' => $_POST['gender'],						
                        'email_id' => $_POST['email'],						
                        'mobile_no' => $_POST['mobile'],						
                        'username' => $_POST['uname'],						
                        'Join_location' => $_POST['location'],						
                        'password' => md5($_POST['password']),						
                        'is_active' => $_POST['active']												
				  
		  );
		        
		  	$this->db->insert('csr', $data);
		  
		 }
	       
			$this->load->view('csr_manager/add_new');
	}
	public function teams()
	 {
	     if(!empty($_POST['csr']) && !empty($_POST['team']))
		{
		$data = array(
							'csr_id' => $_POST['csr'],
							'help_desk_id' => $_POST['team']
						);
			$this->db->insert('csr_assign', $data);
		}	
          $this->load->view('csr_manager/teams');
     }	
   public function my_profile()
	 {
          $this->load->view('csr_manager/my_profile');
     }		
   public function lock()
	{
	    $data['hi']="hi";
	    if(!empty($_POST['password']))
		 {
		 $check = $this->db->get_where('csr_manager',array('password' =>md5($_POST['password']), 'id'=>($_POST['aid'])))->result_array();
		 if($check==true)
		 {
		redirect('csr_manager/home');
		 } else { $data['psd'] = "Wrong Password Please Try Again!!";}
		 }
		$this->load->view('csr_manager/lock', $data);
	}
    public function manage()
	{
		
		$this->load->view('csr_manager/teams');
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
		$this->load->view('csr_manager/pub-performance',$data );
	
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
		
		$this->load->view('csr_manager/production',$data);
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
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/New_York');
		}
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$this->load->view('csr_manager/csr-performance',$data );
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
		
		$data['form'] = $form;
		
		if($form == 'sold' )
		{ $this->load->view('csr_manager/frontline-sold', $data); }
		elseif($form == 'fastrack'){
			$this->load->view('csr_manager/frontline-fastrack', $data);			
		}elseif($form == 'new'){
			$this->load->view('csr_manager/frontline-new', $data);			
		}else{
		$this->load->view('csr_manager/frontline-report', $data);
		}
	}	
	Public function delete()
	{
	         $id= $this->input->post('id');
		     $team_id= $this->input->post('team_id');
			 if(!empty($id) && !empty($team_id))
			 {
			$this->db->query("DELETE  FROM `csr_assign` WHERE `csr_id` = '$id' AND  `help_desk_id`='$team_id'");
			 }
			 $this->load->view('csr_manager/teams');
	}		 
	 public function my_account($error = '', $color = 'darkred')
	{
	     if($error) $data['error'] = $error;
		$data['color'] = $color;
		$this->load->view('csr_manager/my_account', $data);
	}	
	public function help()
	{
	
	 $this->load->view('csr_manager/help');
	}
	
	public function savepic()
	{
	  
	    if(!empty($_POST['name']))	
	   {	   
	      $data = array('name' => $_POST['name'],);
	      $this->db->where('id', $_POST['aid']);
		  $this->db->update('csr_manager', $data); 
		 $this->my_account("changed successfully!!", 'darkred');
	   }  
	   
	    elseif(!empty($_POST['mobile_no']))	
	   {	   
	      $data = array('mobile_no' => $_POST['mobile_no'],);
	      $this->db->where('id', $_POST['aid']);
		  $this->db->update('csr_manager', $data); 
		 $this->my_account("changed successfully!!", 'darkred');
	   }
	   elseif(!empty($_FILES['file']['name']))	
	   {
	   $photo=$_FILES['file']['name'];
	$data = array(
				'image_path' => $photo
              );
    
			$this->db->where('id', $_POST['aid']);
			$this->db->update('csr_manager', $data); 
	move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
		echo "<script>window.location.href='".base_url().index_page()."csr_manager/home/my_account#tab_1_2'</script>";	
	   }
	   
	   else{
           $this->my_account("Error!!", 'darkred'); 
       }	   
	}
	public function tracking($form="")
	{
	        $data['from'] = date('Y-m-d 13:30:00', strtotime(' -2 day'));
			$data['to'] = date('Y-m-d 01:29:00');
	  if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
		}
	    if(!empty($form))
			{
				$data['form'] = $form;
			}
		if(!empty($form)){
        $this->load->view('csr_manager/Ptracking', $data);
        }else{		
	    $this->load->view('csr_manager/tracking', $data);
		}
	}
}

		
	
