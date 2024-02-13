<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Nadmin_Controller {
		
	public function index()
	{
		redirect('new_admin/home/dashboard'); 
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		$aid = $this->session->userdata('aId');
		$data['admin_users'] = $this->db->query("SELECT `id`,`image_path`,`first_name`,`username`,`email_id` from `admin_users` WHERE `id` = '$aid'")->result_array();
		$this->load->view('new_admin/change',$data);
	}
	
	public function in_active_users()
    {
        $data['adreps'] = $this->db->query("SELECT `publication_id`,`first_name`,`last_name`,`email_id` FROM `adreps` WHERE `is_active` = '0'")->result_array();
        $this->load->view('new_admin/in_active_users',$data);
    }
	
		
	public function publication_count($type="",$user="")
	{
		$data['nm_year'] = $_GET['nm_year'];
		
	/*-------------------Modified on 29-12-2017------------------*/
  
  /*------It checks All Publication or one publication-----------*/
		
		$data['nm_month'] = $_GET['nm_month'];
	    
		$this->load->view('new_admin/report_publication_count',$data);
	}
	
	public function revision_reason() //Revision Reason 
	{
		if(isset($_GET['total_count']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])){
			
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			
			$data['from'] = $from;
			$data['to'] = $to;
			$data['total_count'] = $_GET['total_count'];
		}
		if(isset($_GET['designer_count']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])){
			
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			
			$data['from'] = $from;
			$data['to'] = $to;
			$data['designer_count'] = $_GET['designer_count'];
		}
		if(isset($_GET['csr_count']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])){
			
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			
			$data['from'] = $from;
			$data['to'] = $to;
			$data['csr_count'] = $_GET['csr_count'];
		}
		$data['reason_name'] = $this->db->query("SELECT `id`,`name` FROM `rev_reason` ORDER BY `id` DESC ")->result_array();
		$data['designer_name'] = $this->db->query("SELECT `id`,`name` FROM `designers` WHERE `is_active` = '1'")->result_array();
		$data['csr_name'] = $this->db->query("SELECT `id`,`name` FROM `csr` WHERE `is_active` = '1'")->result_array();
		
		$this->load->view('new_admin/revision_reason',$data);
	}

	
	public function revision_others($display_type = 'all'){
        
        $data['hi'] = 'hi';
        
        $data['today'] = date("Y-m-d"); 
    
        $data['display_type'] = $display_type;
        $data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
        $data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
        $data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
        
        if(isset($_POST['timestamp'])){
            $data['timestamp'] = $_POST['timestamp']; 
            //echo $_POST['timestamp'];
        }
        
        if(isset($_POST['update_status'])){
            
            $err_status = array('error_type' => $_POST['error_id']);
            $this->db->where('id', $_POST['id']);
            $this->db->update('rev_order_reason', $err_status);
            $this->session->set_flashdata("message",'Error Type Updated Successfully!!');
            redirect('new_admin/home/revision_others');
        }
        $data['error_type'] = $this->db->query("SELECT `id`,`name` FROM `rev_error_type`")->result_array();
        
        $this->load->view('new_admin/revision_others',$data);
    }
	
	public function total_hd_pending_status($id='')
    {
        $today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
                                        
        //Time    
        $ystday_time = $today_date_time[0]['time'];
        $today_time = $today_date_time[1]['time'];
        $tomo_time = $today_date_time[2]['time'];
        
        //Day
        $current_date = date("Y-m-d");
        $day = date("D", strtotime($current_date));
        $ysterday = date("Y-m-d", strtotime(' -1 day'));
        $day_before_yday = date("Y-m-d", strtotime(' -2 day'));
        $day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
        $tomo = date("Y-m-d", strtotime(' +1 day'));
        
        //Current Time
        $current_time = date("H:i:s");
        
        if($day == 'Mon'){
            $data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '1' AND '4') AND`created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
        }
        if($day == 'Mon' || $day == 'Sun'){
            $data['dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND(`status` BETWEEN '1' AND '4') AND `created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
        }
        if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
            $data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND(`status` BETWEEN '1' AND '4') AND `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
        }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
            $data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND(`status` BETWEEN '1' AND '4') AND `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
        }
        $this->load->view('new_admin/total_hd_pending_status',$data);
    }
	
	public function revision_hd($id='',$from='',$to='')
    {
        $data['revision'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none')")->result_array(); 
        $data['rev_v1a'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1a'")->result_array(); 
        $data['rev_v1b'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1b'")->result_array(); 
        $data['rev_v1c'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1c'")->result_array(); 
        $data['rev_v1d'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1d'")->result_array(); 
        $data['rev_v1e'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1e'")->result_array(); 
        $data['rev_v1f'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1f'")->result_array(); 
        $data['rev_v1g'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1g'")->result_array(); 
        $data['rev_v1h'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1h'")->result_array(); 
        $data['rev_v1i'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1i'")->result_array(); 
        $data['rev_v1j'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1j'")->result_array(); 
        $data['rev_v1k'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1k'")->result_array(); 
        $data['rev_v1l'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1l'")->result_array(); 
        $data['rev_v1m'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1m'")->result_array(); 
        $data['rev_v1n'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1n'")->result_array(); 
        $data['rev_v1o'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1o'")->result_array(); 
        $data['rev_v1p'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1p'")->result_array(); 
        $data['rev_v1q'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1q'")->result_array(); 
        $data['rev_v1r'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1r'")->result_array(); 
        $data['rev_v1s'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1s'")->result_array(); 
        $data['rev_v1t'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1t'")->result_array(); 
        $data['rev_v1u'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1u'")->result_array(); 
        $data['rev_v1v'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1v'")->result_array(); 
        $data['rev_v1w'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1w'")->result_array(); 
        $data['rev_v1x'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1x'")->result_array(); 
        $data['rev_v1y'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1y'")->result_array(); 
        $data['rev_v1z'] = $this->db->query("SELECT `id`,`time_taken` FROM `rev_sold_jobs` WHERE `help_desk` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf_path` != 'none') AND `version` = 'V1z'")->result_array(); 

        
        $this->load->view('new_admin/revision_hd',$data);
    }
    
	public function dochange()
	{
		$this->db->query("Update admin_users set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('admin')."' or username='".$this->session->userdata('admin')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->change('Your password has been changed successfully!', 'darkgreen');
		else
			$this->change('Invalid current password!', 'darkred');
	}
	
	public function revision_version_report()
    {
        if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
            $from = $_GET['from_date'];
            $to = $_GET['to_date'];
            
            $data['from'] = $from;
            $data['to'] = $to;
        }
        $data['classification'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
        
        $this->load->view('new_admin/revision_version_report',$data);
    }
    public function revision_versionv1a_report($id='',$from='',$to='')
    {
        
        $data['classification'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `classification` = '$id' AND `version` = 'V1a' AND `date` BETWEEN '$from' AND '$to'  ")->result_array();
        
        $this->load->view('new_admin/revision_versionv1a_report',$data);
    }
	public function change_profile()
    {
        $aid = $this->session->userdata('aId');
        if(isset($_POST['change_avatar']) && !empty($_FILES['file']['name'])){
            if ((($_FILES['file']['type'] == "image/gif")
            || ($_FILES['file']['type'] == "image/jpeg")
            || ($_FILES['file']['type'] == "image/jpg")
            || ($_FILES['file']['type'] == "image/pjpeg")
            || ($_FILES['file']['type'] == "image/x-png")
            || ($_FILES['file']['type'] == "image/png")))
            {
                $imagename = $aid.'.jpg';
                $source = $_FILES['file']['tmp_name'];
                $target = "images/new_admin/".$imagename;
                move_uploaded_file($source, $target);
                $data = array( 'image_path' => $target );
                        $this->db->where('id', $aid);
                        $this->db->update('admin_users', $data);
                $imagepath = $imagename;
                $save = "images/new_admin/" . $imagepath; //This is the new file you saving
                $file = "images/new_admin/" . $imagepath; //This is the original file

                list($width, $height) = getimagesize($file) ;
                $modwidth = 500;
                //echo $width.'--'.$height;
                $diff = $width / $modwidth;

                $modheight = $height / $diff;
                $tn = imagecreatetruecolor($modwidth, $modheight) ;
                $image = imagecreatefromjpeg($file) ;
                imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

                imagejpeg($tn, $save, 100) ;
            }else{
                $this->session->set_flashdata('size_message',"Only Image Types(gif, jpeg, png) allowed!!");
                redirect('new_admin/home/change');
            }
        }
        redirect('new_admin/home/change');
    }
	
	/*public function dashboard()
	{
		$data['order_ratings5'] = $this->db->query("SELECT * FROM `order_rating` WHERE `rating` = '5'")->num_rows();
		$data['order_ratings4'] = $this->db->query("SELECT * FROM `order_rating` WHERE `rating` = '4'")->num_rows();
		$data['order_ratings3'] = $this->db->query("SELECT * FROM `order_rating` WHERE `rating` = '3'")->num_rows();
		$data['order_ratings2'] = $this->db->query("SELECT * FROM `order_rating` WHERE `rating` = '2'")->num_rows();
		$data['order_ratings1'] = $this->db->query("SELECT * FROM `order_rating` WHERE `rating` = '1'")->num_rows();
		$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active`='1'")->result_array();
		$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->num_rows();
		$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->num_rows();
		$data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->num_rows();
		$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->num_rows();
		$data['teamlead'] = $this->db->query("SELECT * FROM `team_lead` WHERE `is_active` = '1'")->num_rows();
		$data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active`='1'")->result_array();
		
		if(isset($_POST['help_desk']) && !empty($_POST['help_desk'])){
		$data['help_desk_id'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$_POST['help_desk']."'")->result_array();
		$data['hd_id'] = $_POST['help_desk'];
		}
		
		$this->load->view('new_admin/dashboard',$data);
	}*/
	
	public function dashboard()
	{
		$data['order_ratings5'] = $this->db->query("SELECT `id` FROM `order_rating` WHERE `rating` = '5'")->num_rows();
		$data['order_ratings4'] = $this->db->query("SELECT `id` FROM `order_rating` WHERE `rating` = '4'")->num_rows();
		$data['order_ratings3'] = $this->db->query("SELECT `id` FROM `order_rating` WHERE `rating` = '3'")->num_rows();
		$data['order_ratings2'] = $this->db->query("SELECT `id` FROM `order_rating` WHERE `rating` = '2'")->num_rows();
		$data['order_ratings1'] = $this->db->query("SELECT `id` FROM `order_rating` WHERE `rating` = '1'")->num_rows();
		$data['groups'] = $this->db->query("SELECT `id` FROM `Group` WHERE `is_active`='1'")->result_array();
		$data['helpdesk'] = $this->db->query("SELECT `id`,`name` FROM `help_desk` WHERE `active`='1'")->result_array();
		
		if(isset($_POST['help_desk']) && !empty($_POST['help_desk'])){
		$data['help_desk_id'] = $this->db->query("SELECT `id` FROM `help_desk` WHERE `id` = '".$_POST['help_desk']."'")->result_array();
		$data['hd_id'] = $_POST['help_desk'];
		}
		
		$this->load->view('new_admin/dashboard',$data);
	}
	
	public function todays_ad_details()
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		//Current Time
		$current_time = date("H:i:s");
		
		if($day == 'Mon'){
			$data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE  `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}
		$this->load->view('new_admin/todays_ad_details',$data);
	}
	
	public function todays_ad_status($id='')
	{
		$data['id'] = $id;
		$data['today_status'] = $this->db->query("SELECT * FROM `order_status` WHERE `id` BETWEEN '1' AND '4'")->result_array(); 
		
		$data['today_ad_status'] = $this->db->query("SELECT * FROM `order_status`")->result_array();
		$this->load->view('new_admin/todays_ad_status',$data);
	}
	 
	public function pending_status()
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		//Current Time
		$current_time = date("H:i:s");
		
		if($day == 'Mon'){
			$data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4') AND`created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4') AND `created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4') AND `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '1' AND '4') AND `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}
		$this->load->view('new_admin/pending_status',$data);
	}
	 
	public function sent_status()
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		//Current Time
		$current_time = date("H:i:s");
		
		if($day == 'Mon'){
			$data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '5' AND '7') AND `created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '5' AND '7') AND `created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '5' AND '7') AND `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE (`status` BETWEEN '5' AND '7') AND  `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}
		$this->load->view('new_admin/sent_status',$data);
	}
	
	public function hd_total_status($id='')
	{
		
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		//Current Time
		$current_time = date("H:i:s");
		
		if($day == 'Mon'){
			$data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND`created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}
		$this->load->view('new_admin/hd_total_status',$data);
	}
	
	public function sent_hd_status($id='')
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		//Current Time
		$current_time = date("H:i:s");
		
		if($day == 'Mon'){
			$data['sent_dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND`created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['sent_dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND `created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['sent_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['sent_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND (`status` BETWEEN '5' AND '7') AND `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}
		
		$this->load->view('new_admin/sent_hd_status',$data);
	}
	
	public function pending_hd_status($id='',$status_id='')
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
		
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		//Current Time
		$current_time = date("H:i:s");
		
		if($day == 'Mon'){
			$data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status`='".$status_id."' AND `created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status`='".$status_id."' AND `created_on` LIKE '$day_before_yday%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status`='".$status_id."' AND `created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `status`='".$status_id."' AND `created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
		}
		$this->load->view('new_admin/pending_hd_status',$data);
	}
	
	public function new_ads()
	{
		$data['new_ads'] = $this->db->query("SELECT * FROM `orders` WHERE `status` BETWEEN '1' AND '4' AND `created_on` LIKE '2017%' AND `crequest`!='1' AND `cancel`!='1';")->result_array();
		
		$this->load->view('new_admin/new_ads',$data);
	}
	
	public function manage()
    {
        $data['business_groups'] = $this->db->query("SELECT * FROM `business_groups`")->result_array();
        $data['team_lead'] = $this->db->query("SELECT * FROM `team_lead` where `is_active` = '1'")->result_array();
        $data['designers_list'] = $this->db->query("SELECT * FROM `designers` where `is_active` = '1'")->result_array();
        $data['location'] = $this->db->query("SELECT * FROM `location`")->result_array();
        $data['ordering_system'] = $this->db->query("SELECT * FROM `ordering_system`")->result_array();
        $data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1'")->result_array();
        $data['publications_list'] = $this->db->query("SELECT * FROM `publications` where `is_active` = '1'")->result_array();
        $data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
        $data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
        $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
        $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
        $data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
        $data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1'")->result_array();
        $data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
        $data['template'] = $this->db->query("SELECT `id` FROM `orders` WHERE `spec_sold_ad` = '0' AND `order_type_id` = '2' AND pdf!='none'")->num_rows();
        $data['designer_role'] = $this->db->get('designer_role')->result_array();
        $data['csr_role'] = $this->db->get('csr_role')->result_array();
        $data['designer_level'] = $this->db->get('designer_level')->result_array();;
        
        $aid = $this->session->userdata('aId');
        $data['admin_users'] = $this->db->query("SELECT * FROM `admin_users` WHERE `id` = '$aid'")->result_array();
       
        $this->load->view('new_admin/manage',$data);
    }
	
	public function group($id='')
	{
		if(isset($_POST['name'])){
			$priority = $this->db->query("SELECT MAX(priority) FROM `Group`")->row_array();
			$group_insert = array('name' => $_POST['name'], 
								  'priority' => ($priority['MAX(priority)'] + 1)
								  );
								$this->db->insert('Group',$group_insert);	
								$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Group has been created successfully");
				redirect('new_admin/home/sales_manage');
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/sales_manage');
			}   
		}
	
		$data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '$id'")->result_array(); 
		
		$data['id'] = $id;
		if($id!=''){
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' ;")->result_array();
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' AND `is_active` ='0'")->result_array();
			}else{
				$data['status'] = 'active';
				$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' AND `is_active` ='1'")->result_array();
			}
		}else{
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['group'] = $this->db->query("SELECT * FROM `Group`")->result_array(); 
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '0'")->result_array(); 
			}else{
				$data['status'] = 'active';
				$data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array(); 
			}
		}
		$this->load->view('new_admin/group',$data);
	}
	
	public function publication($id='')
	{
		if(!empty($_POST['group_id'])&& !empty($_POST['name']) && !empty($_POST['design_team_id'])){
			$pub_insert = array('name' => $_POST['name'],
							    'initial' => $_POST['initial'],
							    'design_team_id' => $_POST['design_team_id'],
							    'group_id' => $_POST['group_id'],
							    'help_desk' => $_POST['help_desk'],
							    'channel' => $_POST['channel'],
							    'slug_type' => $_POST['slug_type'],
							    'ordering_system' => $_POST['ordering_system'],
							    'advertising_director_email_id' => $_POST['advertising_director_email_id']
					       );
						$this->db->insert('publications',$pub_insert);	
						$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Publication has been created successfully");
				redirect('new_admin/home/sales_manage');
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/sales_manage');
			}   
		}
		if(isset($_POST['update_pub'])){
			
			$data = array('name' =>$_POST['name'],
						  'channel' => $_POST['channel'],
						  'group_id' => $_POST['group'],
						  'initial' => $_POST['initial'],
						  'design_team_id' => $_POST['design_team_id'],
						  'help_desk' => $_POST['help_desk'],
						  'slug_type' => $_POST['slug_type'],
						  'enable_source' => $_POST['enable_source'],
						  'rev_days' => $_POST['rev_days'],
						  'advertising_director_email_id' => $_POST['advertising_director_email_id'],
						  'is_active' => $_POST['is_active'],
						  'ordering_system' => $_POST['ordering_system']
					);
					$this->db->where('id',$id);	
					$this->db->update('publications', $data);
					$pub_status = $this->db->affected_rows();
					if($pub_status){
						//if inactive
							if($_POST['is_active']=='0'){
								$adrep_actives = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '$id' AND `is_active`='1' ")->result_array();
							}elseif($_POST['is_active']=='1'){
								$adrep_actives = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '$id' AND `is_active`='0' ")->result_array();
							}
							if(isset($adrep_actives[0]['id'])){
								foreach($adrep_actives as $adrep_active){
									$post = array('is_active' => $_POST['is_active']);
									$this->db->where('id',$adrep_active['id']);	
									$this->db->update('adreps', $post);
								}
							}
						$this->session->set_flashdata("message"," Publication Details Updated successfully!");
						redirect('new_admin/home/publication/'.$id);
					}else{
						$this->session->set_flashdata("message",$this->db->_error_message());
						redirect('new_admin/home/publication/'.$id);
					}
		}
		$data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
		$data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		$data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1'")->result_array();
		$data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
		$data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1'")->result_array();
		$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$id'")->result_array();
		$data['ord_sys_internal'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '1' AND `is_active` = '1'")->num_rows();
		$data['ord_sys_external'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '2' AND `is_active` = '1'")->num_rows();
		$data['in_adreps_count'] = $this->db->query("SELECT * FROM adreps
												left outer join publications on publications.id = adreps.publication_id
												WHERE publications.ordering_system='1' AND adreps.is_active='1'")->num_rows();
		$data['ext_adreps_count'] = $this->db->query("SELECT * FROM adreps
												left outer join publications on publications.id = adreps.publication_id
												WHERE publications.ordering_system='2' AND adreps.is_active='1'")->num_rows();										
		$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		$data['id'] = $id;
		if($id!=''){
			//$data['order_type'] = $this->db->get('orders_type')->result_array();
			
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$id."';")->result_array();
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$id."' AND `is_active` ='0' ;")->result_array();
			}else{
				$data['status'] = 'active';
				$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '".$id."' AND `is_active` ='1' ;")->result_array();
			}
		}else{
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['publication'] = $this->db->query("SELECT * FROM `publications`")->result_array();  
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '0'")->result_array(); 
			}else{
				$data['status'] = 'active';
				$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array(); 
			}
		}
		$this->load->view('new_admin/publication',$data);
	}
	
	/*public function order_form()
	{
		//publication_order_form
		if(isset($_POST['pId'])){
			$pId = $_POST['pId'];
			//insert checked values
			foreach($_POST['order_type'] as $type) {
				$publication_order_form = $this->db->get_where('publication_order_form', array('publication_id'=>$pId, 'order_type_id'=>$type))->row_array();
				if(!isset($publication_order_form['id'])){
					$post = array('publication_id' => $pId, 'order_type_id' => $type);
					$this->db->insert('publication_order_form',$post);
				}
			}
			//delete unchecked values
			foreach($_POST['order_type_hidden'] as $type_id) {
				if(!in_array($type_id, $_POST['order_type'])){
					$this->db->query("DELETE FROM `publication_order_form` WHERE `publication_id`='$pId' AND `order_type_id`='$type_id';");
				}
			}
			redirect('new_admin/home/publication/'.$pId);
		}
		//adrep_order_form
		if(isset($_POST['aId'])){
			$aId = $_POST['aId'];
			//insert checked values
			foreach($_POST['order_type'] as $type) {
				$adrep_order_form = $this->db->get_where('adrep_order_form', array('adrep_id'=>$aId, 'order_type_id'=>$type))->row_array();
				if(!isset($adrep_order_form['id'])){
					$post = array('adrep_id' => $aId, 'order_type_id' => $type);
					$this->db->insert('adrep_order_form',$post);
				}
			}
			//delete unchecked values
			foreach($_POST['order_type_hidden'] as $type_id) {
				if(!in_array($type_id, $_POST['order_type'])){
					$this->db->query("DELETE FROM `adrep_order_form` WHERE `adrep_id`='$aId' AND `order_type_id`='$type_id';");
				}
			}
			redirect('new_admin/home/adrep_profile/'.$aId);
		}
	}*/
	
	public function publication_internal($status = 'active')
	{
		if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['publication_in'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '1' ")->result_array();
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['publication_in'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '1' AND `is_active` ='0' ;")->result_array();
			}else{
				$data['status'] = 'active';
				$data['publication_in'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '1' AND `is_active` ='1' ;")->result_array();
			}
		$this->load->view('new_admin/publication_internal',$data);
	}
	
	public function publication_external($status = 'active')
	{
		if(isset($_POST['active']) && isset($_POST['in_active'])){
			$data['status'] = 'all';
			$data['publication_ex'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '2' ")->result_array();
		}elseif(isset($_POST['in_active'])){
			$data['status'] = 'in_active';
			$data['publication_ex'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '2' AND `is_active` ='0' ;")->result_array();
		}else{
			$data['status'] = 'active';
			$data['publication_ex'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '2' AND `is_active` ='1' ;")->result_array();
		}
		$this->load->view('new_admin/publication_external',$data);
	}
	
	public function advance_search()
    {
        if(isset($_GET['advance_search_id']) && !empty($_GET['advance_search_id'])){
            
            $advance_search_id = $_GET['advance_search_id'];
            $data['order_id'] = $advance_search_id;
            $orders = $this->db->query("SELECT * FROM `orders` WHERE (`id` LIKE '%".$advance_search_id."%' OR `advertiser_name` LIKE '%".$advance_search_id."%' OR `job_no` LIKE '%".$advance_search_id."%')")->result_array();
            $data['orders']= $orders;
            
            $data['rev_order_id'] = $advance_search_id;
            if(isset($orders[0]['id'])){
                $data['rev_sold_jobs'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$orders[0]['id']."' ORDER BY `id` DESC LIMIT 1;")->result_array();
            }
        }
        $data['rev_order_status'] = $this->db->query("SELECT * FROM `rev_order_status`")->result_array();
        $data['order_status'] = $this->db->query("SELECT * FROM `order_status`")->result_array();
        
        if(isset($_POST['update_status'])){
            
            $ad_ord_status = array('status' => $_POST['status_id']);
            $this->db->where('id', $_POST['order_id']);
            $this->db->update('orders', $ad_ord_status);
            $ad_status = $this->db->affected_rows();
            if($ad_status){
                $this->session->set_flashdata("message",'Order Status Updated Successfully!!');
                redirect('new_admin/home/advance_search?advance_search_id='.$_POST['order_id']);
            }else{
                $this->session->set_flashdata("message",$this->db->_error_message());
                redirect('new_admin/home/advance_search?advance_search_id='.$_POST['order_id']);
            }
        }
        if(isset($_POST['update_rev_status'])){
            
            $ad_rev_status = array('status' => $_POST['rev_status_id']);
            $this->db->where('id', $_POST['rev_order_id']);
            $this->db->update('rev_sold_jobs', $ad_rev_status);
            $this->session->set_flashdata("message",'Revision Status Updated Successfully!!');
            redirect('new_admin/home/order_rev_status?id='.$_POST['order_id']);
        }
        $this->load->view('new_admin/order_rev_status',$data);    
    }
	
	public function adrep_internal($status = 'active')
	{
		if(isset($_POST['active']) && isset($_POST['in_active'])){ //all
			$data['status'] = 'all';
			$data['adreps_in'] = $this->db->query("SELECT A.id, A.first_name, A.last_name, A.email_id, A.publication_id, P.name, P.group_id FROM `adreps` AS A
											left outer join `publications` AS P on P.id = A.publication_id
											WHERE P.ordering_system='1'")->result_array();
		}elseif(isset($_POST['in_active'])){ //in active
			$data['status'] = 'in_active';
			$data['adreps_in'] = $this->db->query("SELECT A.id, A.first_name, A.last_name, A.email_id, A.publication_id, P.name, P.group_id  FROM `adreps` AS A
											left outer join `publications` AS P on P.id = A.publication_id
											WHERE P.ordering_system='1' AND A.is_active='0'")->result_array();
		}else{ //active
			$data['status'] = 'active';
			$data['adreps_in'] = $this->db->query("SELECT A.id, A.first_name, A.last_name, A.email_id, A.publication_id, P.name, P.group_id  FROM `adreps` AS A
											left outer join `publications` AS P on P.id = A.publication_id
											WHERE P.ordering_system='1' AND A.is_active='1'")->result_array();
		}
		$this->load->view('new_admin/adrep_internal',$data);
	}
	
public function adrep_external($status = 'active')
	{
		if(isset($_POST['active']) && isset($_POST['in_active'])){// all
		
			$data['status'] = 'all';
			$data['adreps_ex'] = $this->db->query("SELECT A.id, A.first_name, A.last_name, A.email_id, A.publication_id, P.name, P.group_id  FROM `adreps` AS A
											left outer join `publications` AS P on P.id = A.publication_id
											WHERE P.ordering_system='2' ")->result_array();
		}elseif(isset($_POST['in_active'])){ //in_active
			
			$data['status'] = 'in_active';
			$data['adreps_ex'] = $this->db->query("SELECT A.id, A.first_name, A.last_name, A.email_id, A.publication_id, P.name, P.group_id  FROM `adreps` AS A
											left outer join `publications` AS P on P.id = A.publication_id
											WHERE P.ordering_system='2' AND A.is_active='0'")->result_array();
		}else{ // active
			
			$data['status'] = 'active';
			$data['adreps_ex'] = $this->db->query("SELECT A.id, A.first_name, A.last_name, A.email_id, A.publication_id, P.name, P.group_id  FROM `adreps` AS A
											left outer join `publications` AS P on P.id = A.publication_id
											WHERE P.ordering_system='2' AND A.is_active='1'")->result_array();
		}
		$this->load->view('new_admin/adrep_external',$data);
	}
	
	public function create_adrep($pId = '')
	{
		if($pId != '' && isset($_POST['last_name']) && !empty($_POST['first_name'])&& !empty($_POST['email_id']) && !empty($_POST['username'])){
			
			$adrep_insert = array('first_name' => $_POST['first_name'],
							      'last_name' => $_POST['last_name'],
							      'email_id' => $_POST['email_id'],
								  'publication_id' => $pId,
								  'new_ui' => '1',
							      'username' => $_POST['username'],
								  'password' => MD5($_POST['username'].'123')
					            );
								$this->db->insert('adreps',$adrep_insert);	
								$inserted_id= $this->db->insert_id();
			if($inserted_id){
				if(isset($_POST['send_mail']) && $_POST['send_mail']=='1'){
					$this->send_mail_adrep($inserted_id);
				}
				$this->session->set_flashdata("message",$_POST['first_name'].' '.$_POST['last_name']." account has been created successfully");
				redirect('new_admin/home/publication/'.$pId);
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/publication/'.$pId);
			}
		}
	}
	
	public function send_mail_adrep($adrep_id)
	{ 
		$adrep = $this->db->get_where('adreps', array('id' => $adrep_id))->row_array();
		$publication = $this->db->query("Select * from publications where id='".$adrep['publication_id']."'")->row_array();
		$design_team = $this->db->query("Select * from design_teams where id='".$publication['design_team_id']."'")->row_array();
		$data['adrep'] = $adrep;	
		$data['pwd'] = $adrep['username'].'123';
		$data['name'] = $adrep['first_name'];
		
		$ad_recipient = 'itsupport@adwitads.com';
		$from_email = $design_team['email_id']; 
		$to_email =  $adrep['email_id'];
		
		//Load email library 
		$config = Array( 'mailtype' => 'html' );
		$this->load->library('email', $config);
		
		$this->email->from($from_email,'Design Team'); 
		$this->email->to($to_email);
		$this->email->bcc($ad_recipient);
		$this->email->subject('Welcome to AdwitAds');
		$this->email->message($this->load->view('new_admin_emailer/adrep_create_mail',$data, TRUE));
		
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}
	
	public function send_mail_csr($csr_id)
	{ 
		$csr = $this->db->get_where('csr', array('id' => $csr_id))->row_array();
		$pwd = $csr['username'].'123';
		$from_email = 'itsupport@adwitads.com'; 
		$name = $csr['name'];
		$to_email =  $csr['email_id'];
		$ad_recipient = 'itsupport@adwitads.com';
		$msg = 'Hi '.$name.',<br/><br/> Your Adwitads Account Credentials: <br/><br/> Username: '.$csr['username'].' <br/><br/> password: '.$pwd;
		
		//Load email library 
		
		$config = Array( 'mailtype' => 'html' );
		$this->load->library('email', $config);
		
		$this->email->from($from_email,'IT Support'); 
		$this->email->to($to_email);
		$this->email->cc($ad_recipient);
		$this->email->subject('CSR Account Created Successfully');
		$this->email->message($msg);
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}
	
	public function send_mail_designer($designer_id)
	{ 
		$designer = $this->db->get_where('designers', array('id' => $designer_id))->row_array();
		$pwd = $designer['username'].'123';
		$from_email = 'itsupport@adwitads.com'; 
		$name = $designer['name'];
		$to_email =  $designer['email_id'];
		$ad_recipient = 'itsupport@adwitads.com';
		$msg = 'Hi '.$name.',<br/><br/> Your Adwitads Account Credentials: <br/><br/> Username: '.$designer['username'].' <br/><br/> password: '.$pwd;
		
		//Load email library 
		
		$config = Array( 'mailtype' => 'html' );
		$this->load->library('email', $config);
		
		$this->email->from($from_email,'IT Support'); 
		$this->email->to($to_email);
		$this->email->cc($ad_recipient);
		$this->email->subject('Designer Account Created Successfully');
		$this->email->message($msg);
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}
	
	public function admin_profile($id = '')
	{
		if($id!='')
		{
			if(isset($_POST['pwd_submit']) && !empty($_POST['newpassword'])){
				$pwd = MD5($_POST['newpassword']);
				$data = array( 'password' => $pwd );
				$this->db->where('id', $id);
				$this->db->update('admin_users', $data);
				$status = $this->db->affected_rows();
				if($status){
					$this->session->set_flashdata("message","Password updated successfully!");
					redirect('new_admin/home/admin_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/admin_profile/'.$id);
				}
			}
			if(isset($_POST['name_submit'])){
				$f_name = $_POST['first_name'];
				$l_name = $_POST['last_name'];
				
				$data = array('first_name' => $f_name,
							  'last_name'=>$l_name);
				$this->db->where('id', $id);
				$this->db->update('admin_users', $data);
				$admin_name_status = $this->db->affected_rows();
				if($admin_name_status){
					$this->session->set_flashdata("message",'Admin Name Updated Successfully!!');
					redirect('new_admin/home/admin_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/admin_profile/'.$id);
				}
			}
			if(isset($_POST['email_submit'])){
				$email_id = $_POST['email_id'];
				
				$data = array('email_id' => $email_id );
				$this->db->where('id', $id);
				$this->db->update('admin_users', $data);
				$admin_email_status = $this->db->affected_rows();
				if($admin_email_status){
					$this->session->set_flashdata("message",'Email Updated Successfully!!');
					redirect('new_admin/home/admin_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/admin_profile/'.$id);
				}
			}
			$data['id'] = $id;
			$data['admin_user'] = $this->db->query("SELECT * FROM `admin_users` WHERE `id` = '$id'")->result_array();
			
			$this->load->view('new_admin/admin_profile', $data);
		}
	}
	
	public function designer_profile($id = '')
    {
        if($id!='')
        {
            if(isset($_POST['pwd_submit']) && !empty($_POST['newpassword'])){
                $pwd = MD5($_POST['newpassword']);
                $data = array( 'password' => $pwd );
                $this->db->where('id', $id);
                $this->db->update('designers', $data);
                $status = $this->db->affected_rows();
                if($status > 0){
                    $this->session->set_flashdata("message","Password updated successfully!");
                    redirect('new_admin/home/designer_profile/'.$id);
                }else{
                    $this->session->set_flashdata("message",$this->db->_error_message());
                    redirect('new_admin/home/designer_profile/'.$id);
                }
            }
            if(isset($_POST['email_submit'])){
                $email_id = $_POST['email_id'];
                
                $data = array('email_id' => $email_id );
                $this->db->where('id', $id);
                $this->db->update('designers', $data);
				$designer_email_status = $this->db->affected_rows();
				if($designer_email_status > 0){
					$this->session->set_flashdata("message",'Email Updated Successfully!!');
					redirect('new_admin/home/designer_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
                    redirect('new_admin/home/designer_profile/'.$id);
				}
            }
			
            if(isset($_POST['name_submit'])){
                $name = $_POST['name'];
            
                $data = array('name' => $name);
                $this->db->where('id', $id);
                $this->db->update('designers', $data);
				$designer_name_status = $this->db->affected_rows();
				if($designer_name_status > 0){
					$this->session->set_flashdata("message",'Designer Name Updated Successfully!!');
					redirect('new_admin/home/designer_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
                    redirect('new_admin/home/designer_profile/'.$id);
				}
            }
            if(isset($_POST['Join_location']) && isset($_POST['mobile_no']) && isset($_POST['Work_location']) && isset($_POST['level'])){
            
            $data = array('mobile_no' => $_POST['mobile_no'],
                          'gender' => $_POST['gender'],
                          'Join_location' => $_POST['Join_location'],
                          'Work_location' => $_POST['Work_location'],
                          'designer_role' => $_POST['designer_role'],
                          'level' => $_POST['level'],
                          'saral_id' => $_POST['saral_id'],
                          'online_ad' => $_POST['online_ad'],
                          'is_active' => $_POST['is_active']
                        );
                        $this->db->where('id',$id);    
                        $this->db->update('designers', $data);
                        $design_status = $this->db->affected_rows();
            if($design_status){
                    $this->session->set_flashdata("message"," Details Updated successfully!");
                    redirect('new_admin/home/designer_profile/'.$id);
                }else{
                    $this->session->set_flashdata("message",$this->db->_error_message());
                    redirect('new_admin/home/designer_profile/'.$id);
                }
            }
            $data['id'] = $id;
            $data['design_list'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$id'")->result_array();
            $data['location'] = $this->db->query("SELECT * FROM `location`")->result_array();
            $data['d_role'] = $this->db->query("SELECT * FROM `designer_role`")->result_array();
            $data['d_level'] = $this->db->query("SELECT * FROM `designer_level`")->result_array();
            $order_count = $this->db->query("SELECT * FROM `cat_result` WHERE `designer` = '$id' ")->num_rows();    
        
            $data['order_count'] = $order_count;
            $this->load->view('new_admin/designer_profile', $data);
        }
    }
	
	public function csr_profile($id = '')
	{
		if($id!='')
		{
			if(isset($_POST['pwd_submit']) && !empty($_POST['newpassword'])){
				$pwd = MD5($_POST['newpassword']);
				$data = array( 'password' => $pwd );
				$this->db->where('id', $id);
				$this->db->update('csr', $data);
				$status = $this->db->affected_rows();
				if($status){
					$this->session->set_flashdata("message","Password updated successfully!");
					redirect('new_admin/home/csr_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/csr_profile/'.$id);
				}
			}
			if(isset($_POST['email_submit'])){
				$email_id = $_POST['email_id'];
				
				$data = array('email_id' => $email_id );
				$this->db->where('id', $id);
				$this->db->update('csr', $data);
				$csr_email_status = $this->db->affected_rows();
				if($csr_email_status){
					$this->session->set_flashdata("message",'Email Updated Successfully!!');
					redirect('new_admin/home/csr_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/csr_profile/'.$id);
				}
			}
			if(isset($_POST['name_submit'])){
				$name = $_POST['name'];
			
				$data = array('name' => $name);
				$this->db->where('id', $id);
				$this->db->update('csr', $data);
				$csr_name_status = $this->db->affected_rows();
				if($csr_name_status){
					$this->session->set_flashdata("message",'CSR Name Updated Successfully!!');
					redirect('new_admin/home/csr_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/csr_profile/'.$id);
				}
			}
			if(isset($_POST['alias']) && isset($_POST['mobile_no']) && isset($_POST['Join_location'])){
			
			$data = array('mobile_no' => $_POST['mobile_no'],
						  'alias' => $_POST['alias'],
						  'gender' => $_POST['gender'],
						  'Join_location' => $_POST['Join_location'],
						  'Work_location' => $_POST['Work_location'],
						  'shift_factor' => $_POST['shift_factor'],
						  'web_ad' => $_POST['web_ad'],
						  'csr_role' => $_POST['csr_role'],
						  'saral_id' => $_POST['saral_id'],
						  'is_active' => $_POST['is_active']
						);
						$this->db->where('id',$id);	
						$this->db->update('csr', $data);
						$csr_status = $this->db->affected_rows();
			if($csr_status){
					$this->session->set_flashdata("message"," Details Updated successfully!");
					redirect('new_admin/home/csr_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/csr_profile/'.$id);
				}
			}
			$data['id'] = $id;
			$data['csr_list'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$id'")->result_array();
			$data['location'] = $this->db->query("SELECT * FROM `location`")->result_array();
			$data['c_role'] = $this->db->query("SELECT * FROM `csr_role`")->result_array();
			
			$order_count = $this->db->query("SELECT * FROM `orders` WHERE `csr` = '$id'")->num_rows();	
			
			$data['order_count'] = $order_count;
			$this->load->view('new_admin/csr_profile', $data);
		}
	}
	
	public function adrep_profile($id = '')
	{
		if($id!='')
		{
			if(isset($_POST['pwd_submit']) && !empty($_POST['newpassword'])){
				$pwd = MD5($_POST['newpassword']);
				$data = array( 'password' => $pwd );
				$this->db->where('id', $id);
				$this->db->update('adreps', $data);
				$status = $this->db->affected_rows();
				if($status > 0){
					$this->session->set_flashdata("message","Password updated successfully!");
					redirect('new_admin/home/adrep_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/adrep_profile/'.$id);
				}
			}
			if(isset($_POST['name_submit'])){
				$f_name = $_POST['first_name'];
				$l_name = $_POST['last_name'];
				
				$data = array('first_name' => $f_name,
							  'last_name'=>$l_name);
				$this->db->where('id', $id);
				$this->db->update('adreps', $data);
				$adrep_name_status = $this->db->affected_rows();
				if($adrep_name_status > 0){
					$this->session->set_flashdata("message",'Adrep Name Updated Successfully!!');
					redirect('new_admin/home/adrep_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/adrep_profile/'.$id);
				}
			}
			
			if(isset($_POST['email_submit'])){
				$email_id = $_POST['email_id'];
				
				$data = array('email_id' => $email_id );
				$this->db->where('id', $id);
				$this->db->update('adreps', $data);
				$email_status = $this->db->affected_rows();
				if($email_status > 0){
					$this->session->set_flashdata("message",'Email Updated Successfully!!');
					redirect('new_admin/home/adrep_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/adrep_profile/'.$id);
				}
			}
			
			if(isset($_POST['phone_1']) && isset($_POST['mobile_no']) && isset($_POST['email_cc'])){
			
			$data = array('phone_1' => $_POST['phone_1'],
						  'mobile_no' => $_POST['mobile_no'],
						  'email_cc' => $_POST['email_cc'],
						  'gender' => $_POST['gender'],
						  'display_orders' => $_POST['display_orders'],
						  'new_ui' => $_POST['new_ui'],
						  'team_orders' => $_POST['team_orders'],
						  'rush' => $_POST['rush'],
						  'template' => $_POST['template'],
						  'is_active' => $_POST['is_active']
						);
						$this->db->where('id',$id);	
						$this->db->update('adreps', $data);
						$adrep_status = $this->db->affected_rows();
			if($adrep_status > 0){
					$this->session->set_flashdata("message"," Details Updated successfully!");
					redirect('new_admin/home/adrep_profile/'.$id);
				}else{
					$this->session->set_flashdata("message",$this->db->_error_message());
					redirect('new_admin/home/adrep_profile/'.$id);
				}
			}
			$data['id'] = $id;
			$data['adreps_list'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id'")->result_array();
			
			$adrep_details = $this->db->get_where('adreps',array('id'=> $id))->result_array();
			$publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
			if($adrep_details[0]['team_orders']=='1'){
				$data['orders_count'] = $this->db->get_where('orders',array('publication_id' => $publication[0]['id']))->num_rows();
			}else{
				$data['orders_count'] = $this->db->get_where('orders',array('adrep_id'=>$id))->num_rows();
		}
		if($publication[0]['enable_source']=='1'){
			$data['storage_space'] = $this->storage_space($id);
		}
		$data['adrep_details'] = $adrep_details;
		$data['publication'] = $publication;
		//$data['publication_order_form'] = $this->db->get_where('publication_order_form', array('publication_id'=>$adrep_details[0]['publication_id']))->result_array();		
		$this->load->view('new_admin/adrep_profile', $data);
		}
	}
	 
	public function storage_space($id = '')
	{	
		$adrep_details = $this->db->get_where('adreps',array('id'=> $id))->row_array();
		$publication = $this->db->get_where('publications',array('id'=> $adrep_details['publication_id']))->row_array();
		if($adrep_details['team_orders']=='1'){
			$orders = $this->db->get_where('orders',array('publication_id'=>$publication['id'], 'pdf !=' =>'none'))->result_array();
		}else{
			$orders = $this->db->get_where('orders',array('adrep_id'=> $id, 'pdf !=' =>'none'))->result_array();
		}
		//$orders = $this->db->get_where('orders',array('adrep_id'=>$this->session->userdata('ncId'), 'pdf !=' =>'none'))->result_array();
		$total_space = '0'; $d_tot_size = '0'; $s_tot_size = '0'; $p_tot_size = '0';
		foreach($orders as $row_order){ //echo $row_order['id'].' - ';
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row_order['id']))->row_array();
			$downloads = $row_order['file_path'];
			if(isset($cat_result['id'])){ 
				$source = $cat_result['source_path'];
			}
			$pdf = $row_order['pdf'];	
			//Downloads folder
			if($downloads!='none' && file_exists($downloads)){
				//$d_tot_size = '0';
				$this->load->helper('directory');
				$map = directory_map($downloads.'/');
				if($map){ 
					foreach($map as $row){
						$fpath = $downloads.'/'.$row;
						if(file_exists($fpath)){
							$d_size = '0';
							$d_size = filesize($fpath);
							$d_tot_size = $d_tot_size + $d_size;
						}
					}
					//echo 'Downloads : '.$d_tot_size;
				}
			}
			clearstatcache();
			//Source file folder
			if(isset($source) && file_exists($source)){ 
				//$s_tot_size = '0';
				$this->load->helper('directory');
				$map_source = directory_map($source.'/');
				$map_doc = directory_map($source.'/Document fonts/');
				$map_link = directory_map($source.'/Links/');
				//Source file
				if($map_source){ 
					foreach($map_source as $row){ 
						$s_size = '0';
						if(!is_array($row)){
							$s_size = filesize($source.'/'.$row);
							$s_tot_size = $s_tot_size + $s_size;
						}
					}
				}
				//Source Document fonts file
				if($map_doc){ 
					foreach($map_doc as $row){ 
						$s_size = '0';
						if(!is_array($row)){
							$s_size = filesize($source.'/Document fonts/'.$row);
							$s_tot_size = $s_tot_size + $s_size;
						}
					}
				}
				//Source Links file
				if($map_link){ 
					foreach($map_link as $row){ 
						$s_size = '0';
						if(!is_array($row)){
							$s_size = filesize($source.'/Links/'.$row);
							$s_tot_size = $s_tot_size + $s_size;
						}
					}
				}
				//echo 'Source : '.$s_tot_size;
			}
			clearstatcache();
			//pdf_uploads folder
			if(file_exists($pdf)){ 
				$p_size = '0';
				$p_size = filesize($pdf); 
				$p_tot_size = $p_tot_size + $p_size;
				//echo "pdf : ".$p_tot_size; 
			}
		} 
		$total_space = $d_tot_size + $s_tot_size + $p_tot_size;
		$total_space = number_format($total_space / 1048576, 2) . ' MB';
		//echo $total_space;
		return $total_space;
	}

public function designer($id='')
    {
        if(isset($_POST['name'])){
            $desgn_insert = array('name' => $_POST['name'],
                                  'gender' => $_POST['gender'],
                                  'email_id' => $_POST['email_id'],
                                  'username' => $_POST['username'],
                                  'new_d' => '1',
                                  'password' => MD5($_POST['username'].'123'),
                                  'Join_location' => $_POST['Join_location'],
                                  'designer_role' =>$_POST['designer_role'],
                                  'level'=> $_POST['level'],
                                  'is_active' => '1'
                           );
                        $this->db->insert('designers',$desgn_insert);    
                        $inserted_id= $this->db->insert_id();
            if($inserted_id){
                if(isset($_POST['send_mail_designer']) && $_POST['send_mail_designer']=='1'){
                    $this->send_mail_designer($inserted_id);
                }
                $this->session->set_flashdata("message","Designer has been created successfully");
                redirect('new_admin/home/production_manage');
            }else{
                $this->session->set_flashdata("message",$this->db->_error_message());
                redirect('new_admin/home/production_manage');
            }   
        }
        if($id!=''){
            if(isset($_POST['active']) && isset($_POST['in_active'])){
                $data['status'] = 'all';
                $data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' ;")->result_array();
            }elseif(isset($_POST['in_active'])){
                $data['status'] = 'in_active';
                $data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' AND `is_active` ='0'")->result_array();
            }else{
                $data['status'] = 'active';
                $data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' AND `is_active` ='1'")->result_array();
            }
        }else{
            if(isset($_POST['active']) && isset($_POST['in_active'])){
                $data['status'] = 'all';
                $data['designer'] = $this->db->query("SELECT * FROM `designers`")->result_array(); 
            }elseif(isset($_POST['in_active'])){
                $data['status'] = 'in_active';
                $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '0'")->result_array(); 
            }else{
                $data['status'] = 'active';
                $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array(); 
            }
        }
        $this->load->view('new_admin/designer',$data);
    }
	
	public function designer_details()
	{
		$data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		$data['locations'] = $this->db->query("SELECT `Join_location` FROM `designers` WHERE `is_active` = '1'")->result_array();
		
		$data['designer_role'] = $this->db->get('designer_role')->result_array();
		$data['location'] = $this->db->get('location')->result_array();
		
		$this->load->view('new_admin/designer_details',$data);
	}
	
	public function csr($id='')
	{
		if(isset($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email_id']))
		{
			$csr_insert = array('name' => $_POST['name'],
							    'gender' => $_POST['gender'],
							    'email_id' => $_POST['email_id'],
							    'username' => $_POST['username'],
							    'password' => MD5($_POST['username'].'123'),
							    'new_csr' => '1',
							    'Join_location' => $_POST['Join_location'],
								'csr_role' => $_POST['csr_role'],
							    'is_active' => '1'
					       );
						$this->db->insert('csr',$csr_insert);	
						$inserted_id= $this->db->insert_id();
			if($inserted_id){
				if(isset($_POST['send_mail_csr']) && $_POST['send_mail_csr']=='1'){
					$this->send_mail_csr($inserted_id);
				}
				$this->session->set_flashdata("message","CSR has been created successfully");
				redirect('new_admin/home/production_manage');
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/production_manage');
			}
		}
		if($id!=''){
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' ;")->result_array();
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' AND `is_active` ='0'")->result_array();
			}else{
				$data['status'] = 'active';
				$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '".$id."' AND `is_active` ='1'")->result_array();
			}
		}else{
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['csr'] = $this->db->query("SELECT * FROM `csr`")->result_array(); 
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '0'")->result_array(); 
			}else{
				$data['status'] = 'active';
				$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array(); 
			}
		}
		$this->load->view('new_admin/csr',$data);
	}
	
	public function csr_admin_details()
	{
		$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		$data['locations'] = $this->db->query("SELECT `Join_location` FROM `csr` WHERE `is_active` = '1'")->result_array();
		
		$data['csr_role'] = $this->db->get('csr_role')->result_array();
		$data['location'] = $this->db->get('location')->result_array();
		
		$this->load->view('new_admin/csr_admin_details',$data);
	}
	
	public function help_desk($id='')
	{
		if(isset($_POST['create']) && isset($_POST['name'])){
			if(empty($_POST['ftp_server']) || empty($_POST['ftp_username']) ||empty($_POST['ftp_password']) ||empty($_POST['ftp_url'])){
				$this->session->set_flashdata("message","Provide Proper FTP Values");
				redirect('new_admin/home/production_manage');
			}
			$hd_insert = array(
								'name' => $_POST['name'],
								'ftp_server' => $_POST['ftp_server'],
								'ftp_username' => $_POST['ftp_username'],
								'ftp_password' => $_POST['ftp_password'],
								'ftp_folder' => $_POST['ftp_folder'],
								'ftp_url' => $_POST['ftp_url'],
							);
				$this->db->insert('help_desk',$hd_insert);	
				$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Helpdesk has been created successfully");
				redirect('new_admin/home/production_manage');
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/production_manage');
			}   
		}
		
		if(isset($_POST['update_hd'])){
			if(empty($_POST['ftp_server']) || empty($_POST['ftp_username']) ||empty($_POST['ftp_password']) ||empty($_POST['ftp_url'])){
				$this->session->set_flashdata("message","Provide Proper FTP Values");
				redirect('new_admin/home/help_desk/'.$id);
			}
			$data = array(	'name' =>$_POST['name'],
							'ftp_server' => $_POST['ftp_server'],
							'ftp_username' => $_POST['ftp_username'],
							'ftp_password' => $_POST['ftp_password'],
							'ftp_folder' => $_POST['ftp_folder'],
							'ftp_url' => $_POST['ftp_url'],
						);
					$this->db->where('id', $id);	
					$this->db->update('help_desk', $data);
					$hd_status = $this->db->affected_rows();
					if($hd_status){
						$this->session->set_flashdata("message"," Helpdesk Name Updated successfully!");
						redirect('new_admin/home/help_desk/'.$id);
					}else{
						$this->session->set_flashdata("message",$this->db->_error_message());
						redirect('new_admin/home/help_desk/'.$id);
					}
		}
		$data['id'] = $id;
		$data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$id' ")->result_array();
		$data['pub_hd_count'] = $this->db->query("SELECT * FROM `publications` WHERE `help_desk` = '".$id."' AND `is_active` = '1'")->num_rows();
		$data['adrep_hd_count'] = $this->db->query("SELECT adreps.id FROM adreps left outer join publications on 
								 publications.id = adreps.publication_id WHERE publications.help_desk ='$id' 
								 AND publications.is_active='1' AND adreps.is_active='1'")->num_rows();
		if($id!=''){
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['help_desk'] = $this->db->query("SELECT * FROM `publications` WHERE `help_desk` = '".$id."' ;")->result_array();	
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['help_desk'] = $this->db->query("SELECT * FROM `publications` WHERE `help_desk` = '".$id."' AND `is_active` ='0';")->result_array();	
			}else{
				$data['status'] = 'active';
				$data['help_desk'] = $this->db->query("SELECT * FROM `publications` WHERE `help_desk` = '".$id."' AND `is_active` ='1';")->result_array();	 
			}
		}else{
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` ")->result_array();  
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '0'")->result_array(); 
			}else{
				$data['status'] = 'active';
				$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array(); 
			}
		}
		$this->load->view('new_admin/help_desk',$data);
	}
	
	
	public function design_team($id='')
	{
		if(isset($_POST['name']) && !empty($_POST['email_id'])&& !empty($_POST['newad_template'])){
			$dt_insert = array('name' => $_POST['name'],
							   'email_id' => $_POST['email_id'],
							   'newad_template' => $_POST['newad_template'],
							   'revad_template' => $_POST['revad_template']
					          );
								$this->db->insert('design_teams',$dt_insert);	
								$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Design Team has been created successfully");
				redirect('new_admin/home/sales_manage');
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/sales_manage');
			}   
		}
		if(isset($_POST['update_dt'])){
			$data = array('name' =>$_POST['name'] );
					$this->db->where('id',$id);	
					$this->db->update('design_teams', $data);
					$dt_status = $this->db->affected_rows();
					if($dt_status){
						$this->session->set_flashdata("message"," Design Team Name Updated successfully!");
						redirect('new_admin/home/design_team/'.$id);
					}else{
						$this->session->set_flashdata("message",$this->db->_error_message());
						redirect('new_admin/home/design_team/'.$id);
					}
		}
		$data['id'] = $id;
		$data['designteam'] = $this->db->query("SELECT * FROM `design_teams` WHERE `id` = '$id' ")->result_array();
		$data['pub_dt_count'] = $this->db->query("SELECT * FROM `publications` WHERE `design_team_id` = '".$id."' AND `is_active` = '1'")->num_rows();
		$data['adrep_dt_count'] = $this->db->query("SELECT adreps.id FROM adreps left outer join publications on 
								 publications.id = adreps.publication_id WHERE publications.design_team_id='$id' 
								 AND publications.is_active='1' AND adreps.is_active='1'")->num_rows();
		
		if($id!=''){
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['design_team'] = $this->db->query("SELECT * FROM `publications` WHERE `design_team_id` = '".$id."' ;")->result_array();	
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['design_team'] = $this->db->query("SELECT * FROM `publications` WHERE `design_team_id` = '".$id."'  AND `is_active` ='0'")->result_array();	
			}else{
				$data['status'] = 'active';
				$data['design_team'] = $this->db->query("SELECT * FROM `publications` WHERE `design_team_id` = '".$id."'  AND `is_active` ='1'")->result_array();	
			}
		}else{
			if(isset($_POST['active']) && isset($_POST['in_active'])){
				$data['status'] = 'all';
				$data['design_team'] = $this->db->query("SELECT * FROM `design_teams` ")->result_array();  
			}elseif(isset($_POST['in_active'])){
				$data['status'] = 'in_active';
				$data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '0'")->result_array(); 
			}else{
				$data['status'] = 'active';
				$data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1'")->result_array(); 
			}
		}
		$this->load->view('new_admin/design_team',$data);
	}
	
	public function notification_list()
	{
		$data['notification'] = $this->db->query("SELECT * FROM `notification`")->result_array();
		$this->load->view('new_admin/notification_list',$data);
	}
	
	public function notification_add()
	{
		if(isset($_POST['headline']) && !empty($_POST['message']) && !empty($_POST['users']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['job_status'])){
			$notify_insert = array('headline' => $_POST['headline'],
								   'message' => $_POST['message'],
								   'users' => $_POST['users'],
								   'start_date' => $_POST['start_date'],
								   'end_date' => $_POST['end_date'],
								   'job_status' => $_POST['job_status']
					         );
			$this->db->insert('notification',$notify_insert);	
			$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Notification Added successfully");
				redirect('new_admin/home/manage');
			}else{
				$this->session->set_flashdata("message", $this->db->_error_message());
				redirect('new_admin/home/manage');
			}
		} 
		$data['adwit_users'] = $this->db->query("SELECT * FROM `adwit_users`")->result_array();
		$this->load->view('new_admin/notification_add',$data);
	}
	
	
	public function notification_edit($id='')
	{
		if($id!='')
		{
			if(isset($_POST['headline']) && !empty($_POST['message'])){
				$notification_edit = $this->db->query("SELECT * FROM `notification` WHERE `id` = '$id';")->num_rows();
				if($notification_edit == '1'){
					$data = array( 'headline' => $_POST['headline'],
								   'message' => $_POST['message'],
								   'users' => $_POST['users'],
								   'start_date' => $_POST['start_date'],
								   'end_date' => $_POST['end_date'],
								   'job_status' => $_POST['job_status']
								  );
					$this->db->where('id', $id);
					$this->db->update('notification', $data);
					$status = $this->db->affected_rows();
					if($status > 0){
						$this->session->set_flashdata("message","Notification: $id Updated successfully!");
						redirect('new_admin/home/notification_list');
					}else{
						$this->session->set_flashdata("message",$this->db->_error_message());
						redirect('new_admin/home/notification_list');
					}
				}else{
					$this->session->set_flashdata("message","No Data Found for ID : $id ..!!");
					redirect('new_admin/home/notification_list');
				}	
			}
		$notification= $this->db->get_where('notification',array('id'=>$id))->result_array();
		$data['row'] = $notification[0];
		$data['adwit_users'] = $this->db->query("SELECT * FROM `adwit_users`")->result_array();
		$this->load->view('new_admin/notification_edit',$data);
		}
	}
	
	public function notification_new($display_type='')
	{
		$data['display_type'] = $display_type;
		if(isset($_POST['submit']) && isset($_POST['display_type']) && !empty($_POST['headline']) && !empty($_POST['message']))
		{ 
			$successful = $this->admin_model->notification_insert($display_type);
			if($successful){
				$this->session->set_flashdata("message","Notification Added successfully!");
				redirect('new_admin/home/manage');
			}else{
				$this->session->set_flashdata("message", $this->db->_error_message());
				redirect('new_admin/home/manage');
			}	
	   }
	   $adrep = $this->db->query("select * from `adreps` where `is_active` = '1'")->result_array();
	   $publication = $this->db->query("select * from `publications` where `is_active` = '1'")->result_array();
	   $data['adrep'] = $adrep;	
       $data['publication'] = $publication;
	   $this->load->view('new_admin/notification_new',$data);	
	}
	
	public function production_nj()
	{
		$prod_nj = $this->db->get('nj_parameter')->result_array();
		if(isset($_POST['Save'])){
			foreach($prod_nj as $row){
				$data = array('value' => $_POST['value'.$row['id']]);
						$this->db->where('id',$row['id']);
						$this->db->update('nj_parameter', $data);
			}
			$prod_nj_status = $this->db->affected_rows();
			if($prod_nj_status){
				$this->session->set_flashdata("message","Production NJ Updated successfully!");
				redirect('new_admin/home/production_nj');
			}else{
				$this->session->set_flashdata("message",$this->db->_error_message());
				redirect('new_admin/home/production_nj');
			}
		}
		$data['prod_nj'] = $prod_nj;
		$this->load->view('new_admin/production_nj',$data);
	}
	
	public function lite_dashboard()
	{
		$data['lite_packages'] = $this->db->get('lite_package')->result_array();
		
		$lite_price_per_credit = $this->db->get('lite_price_per_credit')->result_array();
		$data['lite_price_per_credit'] = $lite_price_per_credit;
		$data['price_credit'] = $lite_price_per_credit[0]['price'];
		$data['lite_color_preference'] = $this->db->get('lite_color_preference')->result_array();
		$data['lite_credit_date'] = $this->db->get('lite_credit_date')->result_array();
		$data['lite_credit_sqinch'] = $this->db->get('lite_credit_sqinch')->result_array();
		$data['lite_free_credits'] = $this->db->get('lite_free_credits')->result_array();
		$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `new_ui` = '4' AND `is_active` = '1'")->result_array();
		
		$this->load->view('new_admin/lite_dashboard', $data); 
	}
	
	public function lite_credit_update()
	{
		if(isset($_POST['freecredits_update']) && !empty($_POST['id'])){
			$post = array('credits' => $_POST['credits'], 'num_days' => '7');
			$this->db->where('id', $_POST['id']);
			$this->db->update('lite_free_credits', $post);
		}
		if(isset($_POST['price_update']) && !empty($_POST['id']) && !empty($_POST['price'])){
			$post = array('price' => $_POST['price']);
			$this->db->where('id', $_POST['id']);
			$this->db->update('lite_price_per_credit', $post);
		}
		if(isset($_POST['credit_update']) && !empty($_POST['id']) && !empty($_POST['credits']) && !empty($_POST['table'])){
			$post = array('credits' => $_POST['credits']);
			$this->db->where('id', $_POST['id']);
			$this->db->update($_POST['table'], $post);
		}
		redirect('new_admin/home/lite_dashboard');
	}
	
	public function lite_adrep(){
		
		$data['lite_adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `new_ui` = '4' AND `is_active` = '1'")->result_array();
		
		$this->load->view('new_admin/lite_adrep',$data);
	}
	
	public function create_package()
	{
		$lite_package = $this->db->query("SELECT * FROM `lite_package` ")->result_array();
		$data['lite_package'] = $lite_package;
		if(isset($_POST['Save'])){
			$post = array('min_price' => $_POST['min_price'],
						'max_price'=> $_POST['max_price'],
						'num_days' => $_POST['num_days'],
						'discount'=> $_POST['discount']
					  );	
					$this->db->where('id',$_POST['id']);
					$this->db->update('lite_package', $post);
				redirect('new_admin/home/create_package');
			}
		$this->load->view('new_admin/create_package',$data);
	}

  public function order_rev_status()
	{
		if(isset($_GET['id'])&& !empty($_GET['id']))
		{
			$id = $_GET['id'];

			$data['order_id'] = $id;
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$id'")->result_array();
			$data['orders']= $orders;
			
			$data['rev_order_id'] = $id;
			if(isset($orders[0]['id'])){
				$data['rev_sold_jobs'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$orders[0]['id']."'")->result_array();
			}
		}
		if(isset($_POST['update_status'])){
			
			$ord_status = array('status' => $_POST['status_id']);
			$this->db->where('id', $_POST['order_id']);
			$this->db->update('orders', $ord_status);
			$this->session->set_flashdata("message",'Order Status Updated Successfully!!');
			redirect('new_admin/home/order_rev_status?id='.$_POST['order_id']);
		}
		if(isset($_POST['update_rev_status'])){
			
			$rev_status = array('status' => $_POST['rev_status_id']);
			$this->db->where('id', $_POST['rev_order_id']);
			$this->db->update('rev_sold_jobs', $rev_status);
			$this->session->set_flashdata("message",'Revision Status Updated Successfully!!');
			redirect('new_admin/home/order_rev_status?id='.$_POST['order_id']);
		}
		$data['rev_order_status'] = $this->db->query("SELECT * FROM `rev_order_status`")->result_array();
		$data['order_status'] = $this->db->query("SELECT * FROM `order_status`")->result_array();
		
		$this->load->view('new_admin/order_rev_status',$data);
	}
	
	public function search() 
    {
        if(isset($_POST['id']) && !empty($_POST['id'])){
            
            $id = $_POST['id'];
            $data['order_id'] = $id;
            $orders = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$id'")->result_array();
            $data['orders']= $orders;
            
            $data['rev_order_id'] = $id;
            if(isset($orders[0]['id'])){
                $data['rev_sold_jobs'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$orders[0]['id']."'")->result_array();
            }
        }
        if(isset($_POST['update_status'])){
            
            $ord_status = array('status' => $_POST['status_id']);
            $this->db->where('id', $_POST['order_id']);
            $this->db->update('orders', $ord_status);
            $this->session->set_flashdata("message",'Order Status Updated Successfully!!');
            redirect('new_admin/home/order_rev_status?id='.$_POST['order_id']);
        }
        if(isset($_POST['update_rev_status'])){
            
            $rev_status = array('status' => $_POST['rev_status_id']);
            $this->db->where('id', $_POST['rev_order_id']);
            $this->db->update('rev_sold_jobs', $rev_status);
            $this->session->set_flashdata("message",'Revision Status Updated Successfully!!');
            redirect('new_admin/home/order_rev_status?id='.$_POST['order_id']);
        }
        $data['rev_order_status'] = $this->db->query("SELECT * FROM `rev_order_status`")->result_array();
        $data['order_status'] = $this->db->query("SELECT * FROM `order_status`")->result_array();
        
        
        $this->load->view('new_admin/order_rev_status',$data);    
    }
	
	public function search_email()
	{
		$data['hi'] = 'hello';
		if(isset($_GET['email_id']) && !empty($_GET['email_id']))
		{
			$id = $_GET['email_id'];
			
			$email_adrep = $this->db->query("SELECT * FROM `adreps` WHERE `email_id` = '$id'")->result_array();
			$email_design = $this->db->query("SELECT * FROM `designers` WHERE `email_id` = '$id'")->result_array();
			$email_csr = $this->db->query("SELECT * FROM `csr` WHERE `email_id` = '$id'")->result_array();
			$email_admin = $this->db->query("SELECT * FROM `admin_users` WHERE `email_id` = '$id'")->result_array();
			
			if($email_adrep){
				$data['email_user'] = $email_adrep;
				$data['user'] = 'adrep';
			}elseif($email_design){
				$data['email_user'] = $email_design;
				$data['user'] = 'designer';
			}elseif($email_csr){
				$data['email_user'] = $email_csr;
				$data['user'] = 'csr';
			}elseif($email_admin){
				$data['email_user'] = $email_admin;
				$data['user'] = 'admin_users';
			}else{
				$this->session->set_flashdata('message','ERROR!! Email_Address Not Found');
				redirect('new_admin/home/production_manage');
			}	
		}
		$this->load->view('new_admin/email_search',$data);
	}
	
	public function request_form()
	{
		$today = date('Y-m-d');
		$data['today'] = $today;
		
		if(isset($_POST['submit']) && !empty($_POST['type']) && !empty($_POST['message']))
		{
			$aid = $this->session->userdata('aId');
			$request_insert = array('type' => $_POST['type'],
									'adrep_id' => $aid,			
								    'description' => $_POST['message'], 
									'date' => $_POST['date']
					         );
			$this->db->insert('request_form',$request_insert);	
			$id = $this->db->insert_id();
			if($id){
				if (!empty($_FILES['file']['name'])) {
					$path = 'request_files/'.$id;
					if (@mkdir($path,0777)){}
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						$targetPath = getcwd().'/'.$path.'/';
						$targetFile = $targetPath . $fileName ;
						if(copy($tempFile, $targetFile))
						{
							$fname = $path.'/'.$fileName;
							$data = array('attachment' => $fname);
							$this->db->where('id', $id);
							$this->db->update('request_form', $data);
						}
					if(!move_uploaded_file($tempFile, $targetFile)){
						redirect('new_admin/home/request_details');
					}
				}	
			}
			if($id){
				$this->session->set_flashdata("message","Request Added successfully!");
				redirect('new_admin/home/request_details');
			}else{
				$this->session->set_flashdata("message", $this->db->_error_message());
				redirect('new_admin/home/request_form');
			}
		} 
		$data['request_type'] = $this->db->query("SELECT * FROM `request_type`")->result_array();
		$this->load->view('new_admin/request_form',$data);
	}
	
	public function request_details()
	{
		$data['rqt_details'] = $this->db->query("SELECT * FROM `request_form` ")->result_array();
		
		$this->load->view('new_admin/request_details',$data);
	}
	
	public function request_develop($id='')
	{
		$data['hi'] = 'hello';
		if(isset($_POST['submit']) && !empty($_POST['con_table']) && !empty($_POST['condition']) && !empty($_POST['action']) && !empty($_POST['page']) && !empty($_POST['comment']))
		{
			$rqt_insert = array('rid' => $_POST['rqt_id'],
								'connected_table' => $_POST['con_table'],
								'conditions' => $_POST['condition'],
								'actions' => $_POST['action'],
								'pages' => $_POST['page'],
								'comments' => $_POST['comment']
					         );
			$this->db->insert('request_developer',$rqt_insert);	
			$rqt_id = $this->db->insert_id();
			if($rqt_id)
			{
				$path = "flow_chart/".$rqt_id;
				if (@mkdir($path,0777)){}
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$targetPath = getcwd().'/'.$path.'/';
					$targetFile = $targetPath . $fileName ;
					if(copy($tempFile, $targetFile))
					{
						$fname = $path.'/'.$fileName;
						$data = array('flow_chart' => $fname);
						$this->db->where('id', $rqt_id);
						$this->db->update('request_developer', $data);
					}
			}	
			if($rqt_id){
				$this->session->set_flashdata("message","Develop Form Added successfully! ID:".$id);
				redirect('new_admin/home/request_details');
			}else{
				$this->session->set_flashdata("message", $this->db->_error_message());
				redirect('new_admin/home/request_details');
			}
		}
		$rqt_display = $this->db->query("SELECT * FROM `request_form` WHERE `id` = '$id'")->result_array();
		if(isset($rqt_display[0]['id']))
		{
			$data['rqt_display'] = $rqt_display;
		}
		
		$develop_display = $this->db->query("SELECT * FROM `request_developer` WHERE `id` = '$id'")->result_array();
		if(isset($develop_display[0]['id']))
		{ 
			$data['develop_display'] = $develop_display;
		}
		$this->load->view('new_admin/request_develop',$data);
	}
	
	public function project_head_details()
	{
		$pro_details = $this->db->query("SELECT * FROM  `request_form` WHERE `approved` = '0'")->result_array();
		$data['pro_details'] = $pro_details ;
		if(isset($_POST['submit'])){

			$pro_data = array('approved' => $_POST['approved']);
						$this->db->where('id', $_POST['id']);
						$this->db->update('request_form', $pro_data);
						$this->session->set_flashdata('message','Approved Successfully!! Request ID: '.$_POST['id']);
			redirect('new_admin/home/project_head_details');
		}
		$this->load->view('new_admin/project_head_details',$data);
	}	

	
	public function details($id="",$type="",$user="",$order_type="",$date="")
    {
        $data['type'] = $type;
        $data['user'] = $user;
		$data['date'] = $date;
        $data['id'] = $id;
        $data['order_type'] = $order_type;
		$data['custom']= date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		$data['from'] = $from;
		$data['to'] = $to; 
		
		//echo 'date:'.$date.'From : '.$from.'To : '.$to;
			 
        if($user == 'adrep'){
			if($order_type == 'all'){
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none') ORDER BY `id` ASC")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `adrep_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none') ORDER BY `id` ASC")->result_array();
			}
			$data['orders'] = $orders;
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id'")->result_array();
        }
		
        if($user == 'publications'){
			if($order_type == 'all'){
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}	
			$data['orders'] = $orders;
			$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$id'")->result_array();
        }
		
        if($user == 'groups'){
			if($order_type == 'all'){
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `group_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `group_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}
			$data['orders'] = $orders;
			$data['group_name'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '$id'")->result_array();
		}
        $this->load->view('new_admin/details',$data);
    } 
	
	public function rev_details($id="",$type="",$user="", $order_type="",$date="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		$data['date'] = $date;
		$data['order_type'] = $order_type;
		
		$data['custom'] = date('Y-m-d');
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		$data['from'] = $from;
		$data['to'] = $to;
		
		if($user == 'adrep'){
		if($order_type == 'all'){
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		}else{
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `adrep_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		}
		$data['orders'] = $orders;
		$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id'")->result_array();
		}
		if($user == 'publications'){
		if($order_type == 'all'){
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		}else{
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		}
		$data['orders'] = $orders;
		$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$id'")->result_array();
		}
		if($user == 'groups'){
		if($order_type == 'all'){
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `group_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		}else{
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `group_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		}
		$data['orders'] = $orders;
		$data['group_name'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '$id'")->result_array();
		}
		$this->load->view('new_admin/rev_details',$data);
	}
	
	public function admin_report($type='', $user='', $id='', $date='')
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		$data['id'] = $id;
	
		if($user == 'adrep'){
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'web_ads'){
			$data['web_ads'] = 'web_ads';
		}
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'groups'){
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1' ")->result_array();
		}
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'pcsr'){
			$data['pcsr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		if($user == 'tl_qa'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		$this->load->view('new_admin/admin_report',$data);
	}
	
	/********************Modified on 12-12-2017***********************/
	
	public function report_sales_newreport($type='', $user='', $id='', $date='')
	{
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom'){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		//$data['adrep_id'] = $_GET['adrep_id'];
		$data['type'] = $type;
		$data['user'] = $user;
		$data['new_report_id']= $_GET['new_report_id'];
		$data['new_pub_id']= $_GET['new_pub_id'];
		$data['from'] = $_GET['from'];
		$data['to'] = $_GET['to'];
				
		/*$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '1' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();*/
		//$data['order_type'] = $_GET['order_type'];
		//$data['from'] = $_GET['from'];
		//$data['to'] = $_GET['to'];
		$this->load->view('new_admin/report_sales_new_report',$data);
		
	}
		
/********************Modified on 12-12-2017***********************/
	
	public function tl_qa_report($type="",$user="")
	{
		if($_GET['tl_hd_id'] == 'all'){ 
            $data['hd'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
            $data['d'] = $_GET['date'];
        }else{
            $data['hd'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$_GET['tl_hd_id']."'")->result_array();
            $data['d'] = $_GET['date'];
        }
		$data['tl_hd_id'] = $_GET['tl_hd_id'];
		$this->load->view('new_admin/tl_qa_report',$data);
	}
	
	public function report_sales_web_ads($type="",$user="")
	{
		//$data['adrep_id'] = $_GET['adrep_id'];
		$data['type'] = $type;
		$data['user'] = $user;
		$from = $_GET['from'];
		$to = $_GET['to'];
		$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '1' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
		//$data['order_type'] = $_GET['order_type'];
		$data['from'] = $_GET['from'];
		$data['to'] = $_GET['to'];
		$this->load->view('new_admin/report_sales_web_ads',$data);
	}
	
	public function report_sales_adrep($type='', $user='', $id='', $date='',$order_type='')
	{
		$adrep_id = $id; 
		$data['adrep_id'] = $adrep_id; 
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		$data['custom'] = date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		
		//echo 'date: '.$date.'To : '.$to.'From : '.$from;
		
		if(!isset($_GET['order_type'])){ $data['order_type'] = '2'; }else{ $data['order_type'] = $_GET['order_type']; }
		
		$data['from'] = $from;
		$data['to'] = $to;
		
		$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$adrep_id."'")->result_array();
		
		$this->load->view('new_admin/report_sales_adrep',$data);
	}
	
	public function report_sales_publication($type='', $user='', $id='', $date='',$order_type='')
	{
		$publication_id = $id; 
		$data['publication_id'] = $publication_id; 
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		$data['custom'] = date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		//echo 'date:'.$date.'From : '.$from.'To : '.$to;
		
		if(!isset($_GET['order_type'])){ $data['order_type'] = '2'; }else{ $data['order_type'] = $_GET['order_type']; }
		
		$data['from'] = $from;
		$data['to'] = $to;
		
		$data['revision_detail'] = "revision_detail";
		$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$publication_id."'")->result_array();
		
		$this->load->view('new_admin/report_sales_publication',$data);
	}
	
	public function report_sales_group($type='', $user='',$id='',$date='',$order_type='2')
	{
		$group_id = $id; 
		$data['group_id'] = $group_id; 
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		$data['custom'] = date('Y-m-d');
		
		if(isset($_GET['order_type']) && !empty($_GET['order_type'])){ $order_type = $_GET['order_type']; }
		$data['order_type'] = $order_type;
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		//echo 'date '.$date.'To : '.$to.'From : '.$from;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$group_id."' ")->result_array();
		
		$this->load->view('new_admin/report_sales_group',$data);
	}
	
	
	/*public function grp_category_wise($id="",$type="",$user="",$date="")
    {
        $data['type'] = $type;
        $data['user'] = $user;
		$data['date'] = $date;
        $data['id'] = $id;
		$group_id = $id; 
		$data['group_id'] = $group_id; 
		
		$data['custom']= date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		
		$data['from'] = $from;
		$data['to'] = $to; 
		
		$print_cat = $this->db->query("SELECT `id`,`name` FROM `print` LIMIT 8 ")->result_array();
		//$pub_group = $this->db->query("SELECT `id` FROM `publications` WHERE `group_id` = '$user' ")->result_array();
		$pub_group = $this->db->query("SELECT `id` FROM `publications` WHERE `group_id` = '".$group_id."' AND `is_active` = '1' ")->result_array();
		
		
		$darr = array();
		foreach($pub_group as $row){
			$darr[] = $row['id'];
		}	
		if(!empty($darr)){
			$tot_pub = implode(',', $darr);
			$data['tot_pub'] = $tot_pub;
			$data['print_cat'] = $print_cat;
		}
        $this->load->view('new_admin/grp_category_wise',$data);
    }*/
	
	public function grp_category_wise($id="",$type="",$user="",$order_type="",$date="")
    {
		$data['type'] = $type;
        $data['user'] = $user;
		$data['order_type'] = $order_type;
		$data['date'] = $date;
	
        $data['id'] = $id;
		$group_id = $id; 
		$data['group_id'] = $group_id; 
		
		$data['custom']= date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		$data['from'] = $from;
		$data['to'] = $to; 
		$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.category FROM `orders` 
		LEFT JOIN `cat_result` ON orders.id = cat_result.order_no
		WHERE orders.group_id = '".$group_id."' AND orders.order_type_id = '$order_type' AND (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none') GROUP BY cat_result.category";
		
		$data['orders'] = $this->db->query("$query")->result_array();
		
		$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$group_id."' ")->result_array();
		$this->load->view('new_admin/grp_category_wise',$data);
	}
	
	public function category_grp_design_details($id="",$cat="",$type="",$user="",$order_type="",$date="")
	{
        $data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
        $data['cat'] = $cat;
		$data['order_type'] = $order_type;
		$data['id'] = $id;
		$group_id = $id; 
		$data['group_id'] = $group_id; 
      
		$data['custom']= date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		$data['from'] = $from;
		$data['to'] = $to; 
		
			
		$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.designer, designers.name,username FROM `orders` 
		LEFT JOIN `cat_result` ON orders.id = cat_result.order_no
		LEFT JOIN `designers` ON cat_result.designer = designers.id
		WHERE cat_result.category = '$cat' AND orders.group_id = '".$group_id."' AND orders.order_type_id = '$order_type' AND (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none') GROUP BY cat_result.designer";
		
		$data['result'] = $this->db->query("$query")->result_array();
		$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$group_id."' ")->result_array();
		$this->load->view('new_admin/category_grp_design_details',$data);
	}
	
	public function report_sales_csr($type="",$user="")
    {
        $data['csr_id'] = $_GET['csr_id'];
        $data['type'] = $type;
        $data['user'] = $user;
        if($_GET['csr_id'] == 'all'){ 
            $data['csr'] = $this->db->query("SELECT `id`, `name`, `username` FROM `csr` WHERE `is_active` = '1'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }else{
            $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$_GET['csr_id']."'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }
        $print = $this->db->query("SELECT `name`, `csr_wt` FROM `print`")->result_array();
        foreach($print as $print_row){
            $name = $print_row['name'];
            $weight[$name] = $print_row['csr_wt'];
        }
        $data['weight'] = $weight;
        $this->load->view('new_admin/report_sales_csr',$data);
    }
	
	public function csr_report()
    {
        $csr_id = $_GET['csr_id'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        
        $data['new'] = $this->db->query("SELECT * FROM `cat_result` WHERE `csr_QA` = '$csr_id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();

        $data['revision'] = $this->db->query("SELECT * from `rev_sold_jobs` WHERE `rov_csr` = '$csr_id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
        
        $this->load->view('new_admin/csr_report',$data);
    }
    
	
	public function report_csr_performance($type="",$user="")
	{
		$data['ppcsr_id'] = $_GET['ppcsr_id'];
		$data['type'] = $type;
		$data['user'] = $user;
		if($_GET['ppcsr_id'] == 'all'){ 
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}else{
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$_GET['ppcsr_id']."'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}
		$this->load->view('new_admin/report_csr_performance',$data);
	}
	
	public function report_sales_designer($type="",$user="")
    {
        $designer_id = $_GET['designer_id'];
        $data['designer_id'] = $designer_id;
        $data['type'] = $type;
        $data['user'] = $user;
        
        if($designer_id == 'all'){ 
            $data['designers'] = $this->db->query("SELECT `id`, `name`, `username`,`level` FROM `designers` WHERE `is_active` = '1'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }else{
            $data['designers'] = $this->db->query("SELECT `id`, `name`, `username`,`level` FROM `designers` WHERE `id` = '".$_GET['designer_id']."'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }
    
        $this->load->view('new_admin/report_sales_designer',$data);
    }
	
public function designer_report()
    {
        $designer_id = $_GET['designer_id'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        
        $data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$designer_id' AND `is_active` = '1'")->result_array();
        
        $data['rj'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `designer` = '$designer_id' AND `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' AND  `category` = 'REVISION' ;")->result_array();
        
        $data['ads'] =  $this->db->query("SELECT * FROM `cat_result` WHERE  `designer` = '$designer_id' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array(); 
        
        $this->load->view('new_admin/designer_report',$data);
    }

	
	public function report_sales_hd($type="",$user="")
	{
		$data['help_desk_id'] = $_GET['help_desk_id'];
		$data['type'] = $type;
		$data['user'] = $user;
		if($_GET['help_desk_id'] == 'all'){ 
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}else{
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$_GET['help_desk_id']."'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}
		$this->load->view('new_admin/report_sales_hd',$data);
	}
	
	public function report_compare($type="",$user="")
	{
		if($user == 'groups'){
		$data['cgroup_id'] = $_GET['cgroup_id']; 
		if($_GET['cgroup_id'] == 'all'){ 
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}else{
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$_GET['cgroup_id']."'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}
		}else{
			$data['chd_id'] = $_GET['chd_id']; 
			if($_GET['chd_id'] == 'all'){ 
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}else{
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$_GET['chd_id']."'")->result_array();
			$data['from'] = $_GET['from'];
			$data['to'] = $_GET['to'];
		}
		}
		$data['type'] = $type;
		$data['user'] = $user;
		
		//$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '".$_GET['cgroup_id']."'")->result_array();
		//$data['order_type'] = $_GET['order_type'];
		$data['from'] = $_GET['from'];
		$data['to'] = $_GET['to'];
		$this->load->view('new_admin/report_compare',$data);
	}
	
	public function frontline()
	{
		$id = $_GET['id'];
		$from = $_GET['from'];
		$to = $_GET['to'];
		$data['id'] = $id;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$id' AND `active` = '1'")->result_array();
		$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `time_taken`!='0' AND `job_status`='1' AND `help_desk`='$id' AND `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->result_array();
		$this->load->view('new_admin/frontline',$data);
	}
	
	public function hd_hourly_report()
	{
		$from = $_GET['from'];
		$to = $_GET['to'];
		$id = $_GET['id'];
		$data['from'] = $from;
		$data['to'] = $to;
		$data['id'] = $id;
		$dates = array();
		$from = $current = strtotime($from);
		$to = strtotime($to);

		while ($current <= $to) {
		$dates[] = date('Y-m-d', $current);
		$current = strtotime('+1 days', $current);
		}
		$data['dates'] = $dates;
			
		$this->load->view('new_admin/hd_hourly_report',$data);
	}
	
	public function orderview_history($hd="",$order_id="",$id="",$type="",$user="", $from="",$to="",$order_type="",$EA="")
	{
		$sId = $this->session->userdata('sId');
		$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		$data['from'] = $from;
		$data['EA'] = 'Error';
		//$data['complaint'] = $id;
		$data['to'] = $to;
		$data['order_id'] = $order_id; 
		$data['order_type'] = $order_type;
		$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$id'")->result_array();
		$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$id'")->result_array();
		$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id'")->result_array();
		$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$id'")->result_array();
		$data['group_name'] = $this->db->query("SELECT * FROM `Group` WHERE `id` = '$id'")->result_array();
		$orders= $this->db->query("SELECT * FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
		$data['adrep_name'] = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
		if($hd != '' && $hd != '0' && $order_id != '' && isset($orders[0]['id']))
		{
			$this->load->helper('directory');
			$redirect = 'new_csr/home/orderview/'.$hd.'/'.$order_id;
			$data['redirect']= $redirect;
			$data['order_id']= $order_id; 
			$data['hd']= $hd;
			if(!$orders){
				$this->session->set_flashdata("message","Order: Details not Found!!");
				redirect('new_csr/home/cshift/'.$hd);
			}
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->result_array();
			if(isset($rev_orders[0]['id'])){ $data['rev_orders'] = $rev_orders; }
			
			$pro_conversation = $this->db->query("SELECT * from `production_conversation` where `order_id` = '$order_id' ")->result_array();
				if($pro_conversation){
					$data['pro_conversation'] = $pro_conversation;
				}
				//$data['rev_order_form'] = $rev_orders[0]['file_path'];
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			$data['rev_rev'] =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			
			$data['orders'] = $orders; 
			$data['fname'] = $this->db->get_where('print_ad_types',array('id' => $orders[0]['print_ad_type']))->result_array();
			$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
			$data['adrep_name'] = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
			$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
			$data['csr_alias'] = $csr_alias; 
			$job_no= $orders[0]['job_no'];
			$downloads="downloads/".$order_id."-".$job_no;
			$pickup_downloads = "downloads/pickup/".$order_id;
			$pickup_map_downloads = directory_map($pickup_downloads.'/');
			$t1 = strtotime($orders[0]['created_on']); $t2 = strtotime($orders[0]['pdf_timestamp']); $time_taken = abs($t2 - $t1); 
			
			$time = $time_taken;//echo $time;
			$seconds = $time%60;
			$mins = floor($time/60)%60;
			$hours = floor($time/60/60)%24;
			$days = floor($time/60/60/24);
			$data['days'] = $days;
			$data['hours'] = $hours;
			$data['mins'] = $mins;
			$data['seconds'] = $seconds;
			//echo $days.' '.$hours.' '.$mins.' '.$seconds; 
			if($pickup_map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['pickup_downloads']= $pickup_downloads; 
			}
			$map_downloads = directory_map($downloads.'/');
			if($map_downloads){ 
				$data['file_format']= $this->db->get('file_format')->result_array();
				$data['downloads']= $downloads; 
			}
			  
			$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			if(!$cat)
			{
				$data['cat_pending']='cat_pending';
				$adtype = $this->db->get('cat_new_adtype')->result_array();
				$artinst = $this->db->get('cat_artinstruction')->result_array();
				$data['adtype'] = $adtype;
				$data['artinst'] = $artinst;
			}else{
			$data['cat'] = $cat;
			if($cat[0]['designer']!='0') $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array();
			if($cat[0]['csr']!='0') $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr']."'")->result_array();
			if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
			if($cat[0]['csr_QA']!='0') $data['qa_name'] = $this->db->query("SELECT * FROM `csr` WHERE `id`='".$cat[0]['csr_QA']."'")->result_array();
			$cp_tool = $this->db->query("SELECT * from `cp_tool` where `order_no` = '$order_id' ")->result_array();
			if($cp_tool){ 
				$data['cp_tool'] = $cp_tool;
				$data['csr_name1'] = $this->db->get_where('csr',array('id' => $cp_tool[0]['csr']))->result_array();
			} 
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
			$data['cancel_reason'] = $this->db->get('cancel_reason')->result_array();			$data['note_csr_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_designer'))->result_array();			$data['note_csr_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_dc'))->result_array();
			//note sent
			$note_newad = $this->db->get_where('note_sent',array('order_id'=>$order_id, 'revision_id'=>'0'))->result_array();
			if($note_newad){ $data['note_newad'] = $note_newad[0]; }
			if($orders[0]['file_path'] != 'none'){
			$data['order_form'] = $orders[0]['file_path'];
			}
			if($cat[0]['slug']!='none' || $cat[0]['slug']!=''){
				$slug = $cat[0]['slug'];
				$data['slug'] = $slug;
				$sourcefile = "sourcefile/".$order_id.'/'.$slug;
				$map_sourcefile = directory_map($sourcefile.'/');
				if($map_sourcefile){ $data['sourcefile']= $sourcefile; }
				
				$data['tl_path'] = $sourcefile.'/Tl_change';
				$data['csr_path'] = $sourcefile.'/csr_change';
				$data['dc_path'] = $sourcefile.'/DC_change';
				//changes from TL
				$tl_path = $sourcefile.'/Tl_change';
				$map_tl_path = directory_map($tl_path.'/');
				if($map_tl_path){ $data['tl_path']= $tl_path; }
				
				//changes from CSR
				$csr_path = $sourcefile.'/csr_change'; 
				$map_csr_path = directory_map($csr_path.'/');
				if($map_csr_path){ $data['csr_path']= $csr_path; }
				
				if($rev_orders){
				$rev_csr_path = $sourcefile.'/csr_change_'.$rev_orders[0]['id'];
				$map_rev_csr_path = directory_map($rev_csr_path.'/');
				if($map_rev_csr_path){ $data['rev_csr_path']= $rev_csr_path; }
				}
				//changes from DC CSR
				$dc_csr_path = $sourcefile.'/DC_change'; 
				$map_dc_csr_path = directory_map($dc_csr_path.'/');
				if($map_dc_csr_path){ $data['dc_csr_path']= $dc_csr_path; } 
			}
		}
			$this->load->view('new_admin/orderview_history', $data);			
		}			
	}
	
	public function publication_details01()
	{
		$data['type'] = $_GET['type'];
		$data['user'] = $_GET['user'];
		$publication_id = $_GET['publication_id'];
		$data['publication_id'] = $publication_id;
		$data['order_type'] = $_GET['order_type'];
		$data['from'] = $_GET['from'];
		$data['to'] = $_GET['to'];
		
		if($_GET['user'] == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$publication_id'")->result_array();
		}
		$this->load->view('new_admin/publication_details',$data);
	}
	
	public function publication_details($id="",$type="",$user="", $from="",$to="",$order_type="")
	{
		$data['type'] = $_GET['type'];
		$data['user'] = $_GET['user'];
		$publication_id = $_GET['publication_id'];
		$data['from'] = $from;
		$data['to'] = $to;
		$data['publication_id'] = $publication_id;
		if(!isset($_GET['order_type'])){ $data['order_type'] = '2'; }else{ $data['order_type'] = $_GET['order_type']; }
		$data['order_type'] = $_GET['order_type'];
		//$data['from'] = $_GET['from'];
		//$data['to'] = $_GET['to'];
		
		if($_GET['user'] == 'publications'){
			//$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$publication_id'")->result_array();
			$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '$publication_id'")->result_array();
		}
		$this->load->view('new_admin/publication_details',$data);
	}
	
	public function group_publication_details($id="",$type="",$user="",$order_type="", $date="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		$data['id'] = $id;
		$data['order_type'] = $order_type;
		$data['custom']= date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		$data['from'] = $from;
		$data['to'] = $to; 
		
		//echo 'date:'.$date. 'From : '.$from. 'To : '.$to;
		
		$data['from'] = $from;
		$data['to'] = $to;
		
		if($user == 'groups'){
		$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = '$id' AND `is_active` = '1'")->result_array();
		}
		$this->load->view('new_admin/group_publication_details',$data);
	}
	
	public function production_details($id="",$type="",$user="", $from="",$to="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		$data['from'] = $from;
		$data['to'] = $to;
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$id'")->result_array();
			$data['cat_result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `csr_QA` = '$id' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$id'")->result_array();
			$data['cat_result'] = 	$this->db->query("SELECT * FROM `cat_result` WHERE  `designer`='$id' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$id'")->result_array();
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			
		}
		$this->load->view('new_admin/production_details',$data);
	} 
	
public function reports_complaint($date="")
	{
		$data['hi'] = 'hi';
		if(isset($_POST['generate'])){
			$rev_sold_jobs = $this->db->query("SELECT `id`,`note` FROM `rev_sold_jobs` WHERE `checked` = '0';")->result_array(); 
			$order_complaint_words = $this->db->query("SELECT * FROM `order_complaint_words`")->result_array();
			if($rev_sold_jobs){
				foreach($rev_sold_jobs as $rev_row){
					$affected_rows = 0;
					foreach($order_complaint_words as $word_row){
						$word = $word_row['name'];
						$string = $rev_row['note'];

						if(strpos($string, ' '.$word.' ') !== FALSE){ 
							$post = array('complaints' => '1',
										  'checked' => '1'
									);
							$this->db->where('id', $rev_row['id']);
							$this->db->update('rev_sold_jobs', $post);
							$affected_rows = $this->db->affected_rows();
							break;
						}
					} 
					if($affected_rows == 0){
						$post = array('complaints' => '0', 
									  'checked' => '1'
								);
						$this->db->where('id', $rev_row['id']);
						$this->db->update('rev_sold_jobs', $post); 
					}
				}
			}		
		}
		if(isset($_POST['c_submit'])){
			$c_error_id = $_POST['c_error'];
			$rev_id = $_POST['rev_id'];
			$c_post = array('c_error' => $c_error_id);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $c_post);
		}
		if($date != ''){
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `complaints` = '1' AND `date` = '$date' ;")->result_array();
		
		}else{
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `complaints` = '1' ORDER BY `id` DESC")->result_array();
		}		
		$this->load->view('new_admin/reports_complaint',$data);
	}
	
	public function complaint_keywords()
	{
		$data['keywords'] = $this->db->query("SELECT * FROM `order_complaint_words`")->result_array();
		if(isset($_POST['update_key']) && !empty($_POST['keyword'])){
			$update = array('name' => $_POST['keyword']);
			$this->db->where('id',$_POST['id']);
			$this->db->update('order_complaint_words',$update);
			$this->session->set_flashdata('message','Updated successfully');
			redirect('new_admin/home/complaint_keywords');
		}
		if(isset($_POST['delete'])){
			$this->db->query("DELETE FROM `order_complaint_words` WHERE `id`='".$_POST['id']."';");
			$this->session->set_flashdata('message','Deleted successfully');
			redirect('new_admin/home/complaint_keywords');
		}
		$this->load->view('new_admin/complaint_keywords',$data);
	}
	public function report_templates()
	{
		$data['template'] = $this->db->query("SELECT `id` FROM `orders` WHERE `spec_sold_ad` = '0' AND `order_type_id` = '2' AND pdf!='none'")->num_rows();
		$data['user_count'] = $this->db->query("SELECT `id` FROM `adreps` WHERE `template` != 'none' AND `is_active` = '1'")->num_rows();
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = $this->input->get('id');
			$rowsPerPage = 12; 
			$num = $_GET['num'];  
			$offset = ($num - 1) * $rowsPerPage; 
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `pdf` != 'none' AND `spec_sold_ad` = '0' AND (`id` LIKE '%$id%' OR `job_no` LIKE '%$id%' OR `advertiser_name` LIKE '%$id%' OR `copy_content_description` LIKE '%$id%' OR `notes` LIKE '%$id%') ORDER BY `id` DESC LIMIT $offset, $rowsPerPage")->result_array();
			if(isset($orders[0]['id'])){
				$data['orders'] = $orders;
			}else{
				$this->session->set_flashdata('message','<label style="color:red">No Orders Found..!!</label>');
				redirect('new_admin/home/report_templates');
			}
			$data['id'] = $id;
			$data['num'] = $num;
		}
		$this->load->view('new_admin/report_templates',$data);
	}
	
	public function add_tag()
	{
		if(isset($_POST['tags']) && !empty($_POST['tags'])){ 
			$tags = str_replace(', ',',',$_POST['tags']);
			$temp = array();
			$temp = explode(",", $tags);
			$ct = count($temp);
			for($i=0; $i<$ct; $i++){
				$this->db->where('name', $temp[$i]);
				$query = $this->db->get('tags', 1);
				if($query->num_rows() == 0){
					//$slug = str_replace(' ','_',$temp[$i]);
					$post = array('name'=>$temp[$i]);	
					$this->db->insert('tags', $post);
					$tag_id= $this->db->insert_id();
					
					//order_tags
					$data = array('order_id'=>$_POST['id'], 'tag_id'=>$tag_id);
					$this->db->insert('order_tags', $data);
					
				}elseif($query->num_rows() > 0){
					$result = $query->result_array();
					//order_tags
					$order_tags = $this->db->get_where('order_tags',array('order_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']))->row_array();
					if(!isset($order_tags['id'])){
						$data = array('order_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']);
						$this->db->insert('order_tags', $data);
						
					}
				}
			}
			 $order_tags = $this->db->get_where('order_tags',array('order_id'=>$_POST['id']))->result_array(); 
			foreach($order_tags as $row_tag){
				$tag = $this->db->get_where('tags',array('id'=>$row_tag['tag_id']))->row_array();
				echo $tag['name'].' ';	
			}
		}
		
	}
	
	public function report_template_GM_old()
	{
		$data['hi'] = 'hi';
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$key = $this->input->get('id'); 
			$keywords = explode(' ', $key);
			$keyword_count = count($keywords);
			$rowsPerPage = 12; 
			$num = $_GET['num'];  
			$offset = ($num - 1) * $rowsPerPage;
			//$id_where = "('" . implode("' ,'", $keywords) . "')";
			//$id_where = "template_tags.name LIKE '" . implode("%' OR template_tags.name LIKE '", $keywords) . "%'";
			$id_where = "('" . implode("' ,'", $keywords) . "')";
			$id_where1 = "'" . implode("%' OR '", $keywords) . "%'";
			
			$sql = "SELECT template_bank_id FROM template_bank_tag WHERE (tag_id IN (SELECT id FROM template_tags WHERE name IN $id_where)) OR (tag_id IN (SELECT id FROM template_tags WHERE name LIKE $id_where1))  GROUP BY template_bank_id HAVING COUNT(tag_id) = $keyword_count LIMIT $offset, $rowsPerPage";
			echo $sql;
			$templates = $this->db->query($sql)->result_array();
			if(isset($templates[0]['template_bank_id'])){
				$data['templates'] = $templates;
			}else{
				$this->session->set_flashdata('t_message','<label style="color:red">No Orders Found..!!</label>');
				redirect('new_admin/home/report_template_GM');
			} 
			$data['num'] = $num;
			$data['id'] = $key;  
		}
		$this->load->view('new_admin/report_template_GM',$data);
	}
	
	public function report_template_GM()
    {
        $data['hi'] = 'hi';
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $key = $this->input->get('id'); 
            $keywords = explode(' ', $key);
            $rowsPerPage = 12; 
            $num = $_GET['num'];  
            $offset = ($num - 1) * $rowsPerPage;
            $id_where = "template_tags.name LIKE '" . implode("%' OR template_tags.name LIKE '", $keywords) . "%'";
            if(isset($_GET['size_id']) && $_GET['size_id'] != 'all'){ //echo  $_GET['size_id'].' - '.$_GET['id'].' - '.$_GET['num'];
                $size_id = $_GET['size_id']; 
                $sql = "SELECT
                        DISTINCT template_bank.id, template_bank.url 
                        FROM `template_tags`, `template_bank_tag`, `template_bank`
                        WHERE ({$id_where})
                        and template_bank_tag.tag_id = template_tags.id and template_bank.id = template_bank_tag.template_bank_id and template_bank.size_id = $size_id ORDER BY template_bank.id DESC LIMIT $offset, $rowsPerPage";
            }else{  
				$sql = "SELECT
                        DISTINCT template_bank.id, template_bank.url 
                        FROM `template_tags`, `template_bank_tag`, `template_bank`
                        WHERE ({$id_where})
                        and template_bank_tag.tag_id = template_tags.id and template_bank.id = template_bank_tag.template_bank_id ORDER BY template_bank.id DESC LIMIT $offset, $rowsPerPage";
            }
			$data['size_id'] = $_GET['size_id'];
            $templates = $this->db->query($sql)->result_array();
			$data['templates_count'] = count($templates);
			$data['num'] = $num; 
            $data['id'] = $key;
			$data['rowsPerPage'] = $rowsPerPage;
			
			if(isset($templates[0]['id'])){
				$data['templates'] = $templates;
            }else{
				$this->session->set_flashdata('t_message','<label style="color:red">No templates Found..!!</label>');
                redirect('new_admin/home/report_template_GM');
            } 
        }
        $this->load->view('new_admin/report_template_GM',$data);
    }
	
	public function template_multiple_image()
	{
		if(!empty($_FILES['img_url']['name'])){
			$path = 'template_bank/csv_files/'.$_FILES['img_url']['name'];
			if(!copy($_FILES['img_url']['tmp_name'], $path))
			{
				//$this->session->set_flashdata('message','Error uploading image file.. Try again..!!');
				$this->session->set_flashdata('message','<span class="alert alert-success" >Error uploading image file.. Try again..!!</span>');
				redirect('new_admin/home/report_template_GM');
			}
			
			if(file_exists($path))
			{ 
				$handle = fopen($path, "r"); 
				$csv_row = '1';
				while (($data = fgetcsv($handle, 100000, ",")) !== FALSE)
				{
					if($csv_row == 1){ $csv_row++; continue; }
					for($i=0;$i<1;$i++){
						$data[$i] = str_replace("'","",$data[$i]);
					}
					//image URL
					$img_url = $this->db->get_where('template_bank', array('url'=>$data[1]))->result_array();
					if(count($img_url) == 0 && !empty($data[1])){
						 $post = array('url'=>$data[1]);
						$this->db->insert('template_bank', $post);
						$template_bank_id = $this->db->insert_id(); 
						
						$data[0] = str_replace(', ',',',$data[0]);
						$dep = EXPLODE(',',$data[0]);
						foreach($dep as $row){ 
							$template_tags = $this->db->get_where('template_tags', array('name'=>$row))->result_array();
							if(count($template_tags) == 0){
								//$slug = str_replace(' ','_',$row);
								$post = array('name' => $row);
								$this->db->insert('template_tags', $post);
								$tag_id = $this->db->insert_id();
							}else{ $tag_id =$template_tags[0]['id']; }
							
							if($template_bank_id && $tag_id){
								//image_bank_tag
								$post = array('template_bank_id'=>$template_bank_id, 'tag_id'=>$tag_id);
								$this->db->insert('template_bank_tag', $post);
							}
						} 
					} 
				} 
				fclose($handle); 
			}
			
			$this->session->set_flashdata('message','<span class="alert alert-success" >file uploaded successfuly</span>');
			redirect('new_admin/home/report_template_GM');
		}
		
	}
	
	public function template_add_tag() 
	{
		if(isset($_POST['tags']) && !empty($_POST['tags'])){ 
			$tags = str_replace(', ',',',$_POST['tags']);
			$temp = array();
			$temp = explode(",", $tags);
			$ct = count($temp);
			for($i=0; $i<$ct; $i++){
				$this->db->where('name', $temp[$i]);
				$query = $this->db->get('template_tags', 1);
				if($query->num_rows() == 0){
					//$slug = str_replace(' ','_',$temp[$i]);
					$post = array('name'=>$temp[$i]);	
					$this->db->insert('template_tags', $post);
					$tag_id= $this->db->insert_id();
					
					//template_bank_tag
					$tag_id_post = array('template_bank_id'=>$_POST['id'], 'tag_id' => $tag_id);
					$this->db->insert('template_bank_tag', $tag_id_post);
					
				}elseif($query->num_rows() > 0){
					$result = $query->result_array();
					//order_tags
					$order_tags = $this->db->get_where('template_bank_tag',array('template_bank_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']))->row_array();
					if(!isset($order_tags['id'])){
						$data = array('template_bank_id'=>$_POST['id'], 'tag_id'=>$result[0]['id']);
						$this->db->insert('template_bank_tag', $data);
						
					}
				}
			}
			 /* $order_tags = $this->db->get_where('template_bank_tag',array('template_bank_id'=>$_POST['id']))->result_array(); 
			foreach($order_tags as $row_tag){
				$tag = $this->db->get_where('template_tags',array('id'=>$row_tag['tag_id']))->row_array();
				echo $tag['name'].' , ';	
			}  */
		}
	}
	
	public function report_imagebank()
	{
		$data['hi'] = 'hi';
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$key = $this->input->get('id'); 
			$keywords = explode(' ', $key);
			$id_where = "image_tags.name LIKE '" . implode("%' OR image_tags.name LIKE '%", $keywords) . "'";
			$sql = "SELECT
			DISTINCT image_bank.id, image_bank.url, image_bank.thumbnail_url 
			FROM `image_tags`, `image_bank_tag`, `image_bank`
			WHERE ({$id_where})
			and image_bank_tag.tag_id = image_tags.id and image_bank.id = image_bank_tag.image_bank_id";
			$data['image'] = $this->db->query($sql)->result_array();
		}
		$this->load->view('new_admin/report_imagebank',$data);
	}
	
	function UR_exists($url)
	{
	   $headers=get_headers($url);
	   return stripos($headers[0],"200 OK")?true:false;
	}
	
	public function multiple_image()
	{
		if(isset($_POST['generate'])){
			$thumbnail_bank = $this->db->query("SELECT * FROM `image_bank` WHERE (`thumbnail_url` = 'none' OR `thumbnail_url` = '')")->result_array();
			if($thumbnail_bank){
				foreach($thumbnail_bank as $r){
					$url_path = $r['url'];
					$url_path = str_replace(" ", "%20", $url_path);
					$ext = pathinfo($url_path, PATHINFO_EXTENSION);
					$file = 'img/'.$r['id'].'.'.$ext;
					if($this->UR_exists($url_path)){
						if(!copy($url_path, $file))
						{
							$this->session->set_flashdata('message','<span class="alert alert-success" >Error uploading file.. Try again..!!</span>');
							redirect('new_admin/home/report_imagebank');
						}
						if(file_exists($file)){
							//$this->load->library('Image_magician');
							$source_path = $file;
							$target_path = 'img/resized/'.$r['id'].'.jpg'; 
							//$width = '100'; 
							//$height = '100';
							//$this->image_magician->is_animated($source_path);
							//$imagick = new Imagick();
							$img = new Imagick($source_path); 
							$img->setImageResolution(72,72); 
							$img->resampleImage(72,72,imagick::FILTER_UNDEFINED,1); 
							$img->scaleImage(800,0); 
							$d = $img->getImageGeometry(); 
							$h = $d['height']; 
							if($h > 600) { 
							$img->scaleImage(0,600); 
							$img->writeImage($target_path); 
							} else { 
							$img->writeImage($target_path); 
							} 
							$img->destroy();
							/* $imagick->readImage($source_path);
							$imagick->resizeImage(100,100, imagick::FILTER_CATROM, 1);
							$imagick->setImageFormat('jpg');
							$imagick->writeImage($target_path); */ 
							$t_data = array( 'thumbnail_url' => $target_path );
							$this->db->where('id', $r['id']);
							$this->db->update('image_bank', $t_data); 
						}
					}
				}
			}
			$this->session->set_flashdata('message','<span class="alert alert-success" >Generated successfuly</span>');
			redirect('new_admin/home/report_imagebank');
		}
		
		if(!empty($_FILES['img_url']['name'])){
			$path = 'image_bank/csv_files/'.$_FILES['img_url']['name'];
			if(!copy($_FILES['img_url']['tmp_name'], $path))
			{
				//$this->session->set_flashdata('message','Error uploading image file.. Try again..!!');
				$this->session->set_flashdata('message','<span class="alert alert-success" >Error uploading image file.. Try again..!!</span>');
				redirect('new_admin/home/report_imagebank');
			}
			
			if(file_exists($path))
			{ 
				$handle = fopen($path, "r");
				$csv_row = '1';
				while (($data = fgetcsv($handle, 100000, ",")) !== FALSE)
				{
					if($csv_row == 1){ $csv_row++; continue; }
					for($i=0;$i<1;$i++){
						$data[$i] = str_replace("'","",$data[$i]);
					}
					//image URL
					$img_url = $this->db->get_where('image_bank', array('url'=>$data[1]))->result_array();
					if(count($img_url) == 0 && !empty($data[1])){
						 $post = array('url'=>$data[1]);
						$this->db->insert('image_bank', $post);
						$img_bank_id = $this->db->insert_id(); 
						
						$data[0] = str_replace(', ',',',$data[0]);
						$dep = EXPLODE(',',$data[0]);
						foreach($dep as $row){ 
							$image_tags = $this->db->get_where('image_tags', array('name'=>$row))->result_array();
							if(count($image_tags) == 0){
								$slug = str_replace(' ','_',$row);
								$post = array('name' => $row, 'slug' => $slug);
								$this->db->insert('image_tags', $post);
								$tag_id = $this->db->insert_id();
							}else{ $tag_id =$image_tags[0]['id']; }
							
							if($img_bank_id && $tag_id){
								//image_bank_tag
								$post = array('image_bank_id'=>$img_bank_id, 'tag_id'=>$tag_id);
								$this->db->insert('image_bank_tag', $post);
							}
						} 
					} 
				} 
				fclose($handle); 
			}
			$this->session->set_flashdata('message','<span class="alert alert-success" >file uploaded successfuly</span>');
			redirect('new_admin/home/report_imagebank');
		}
		
	}
	
	public function thumb_generate()
	{
		//if(isset($_POST['generate'])){
			$thumbnail_bank = $this->db->query("SELECT * FROM `image_bank` WHERE (`thumbnail_url` = 'none' OR `thumbnail_url` = '')")->result_array();
			if($thumbnail_bank){
				foreach($thumbnail_bank as $r){
					$url_path = $r['url'];
					$url_path = str_replace(" ", "%20", $url_path);
					$ext = pathinfo($url_path, PATHINFO_EXTENSION);
					$file = 'img/'.$r['id'].'.'.$ext;
					/* $image = new Imagick($file);
					$d = $image->getImageGeometry();
					$w = $d['width'];
					$h = $d['height']; 
					echo $w.'-'.$h; */
					//$size = getimagesize($file);
					if($this->UR_exists($url_path)){
						if(!copy($url_path, $file))
						{
							//$this->session->set_flashdata('message','<span class="alert alert-success" >Error uploading file.. Try again..!!</span>');
							echo "Error uploading file.. Try again..!!";
							redirect('new_admin/home/thumb_generate');
						}
						if(file_exists($file)){
							//$this->load->library('Image_magician');
							$source_path = $file;
							$target_path = 'img/resized/'.$r['id'].'.jpg'; 
							//$width = '100'; 
							//$height = '100';
							//$this->image_magician->is_animated($source_path);
							//$imagick = new Imagick();
							$img = new Imagick($source_path); 
							$img->setImageResolution(72,72); 
							$img->resampleImage(72,72,imagick::FILTER_UNDEFINED,1); 
							$img->scaleImage(800,0); 
							$d = $img->getImageGeometry(); 
							$h = $d['height']; 
							if($h > 600) { 
							$img->scaleImage(0,600); 
							$img->writeImage($target_path); 
							} else { 
							$img->writeImage($target_path); 
							} 
							$img->destroy();
							/* $imagick->readImage($source_path);
							$imagick->resizeImage(100,100, imagick::FILTER_CATROM, 1);
							$imagick->setImageFormat('jpg');
							$imagick->writeImage($target_path); */ 
							$t_data = array( 'thumbnail_url' => $target_path );
							$this->db->where('id', $r['id']);
							$this->db->update('image_bank', $t_data); 
						} 
					}
				}
			}
			//$this->session->set_flashdata('message','<span class="alert alert-success" >Generated successfuly</span>');
			//redirect('new_admin/home/report_imagebank');
		//}
	}
	
	public function zip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			if(isset($_POST['order_id'])){ $order_id = $_POST['order_id']; }
			/*else{ //revision $order_id = $new_slug;}*/
			
			$SourceFilePath = $_POST['source_path'] ;
			$source_file = $_POST['source_file'];
			if(isset($_POST['pdf_file'])){
				$pdf_file = $_POST['pdf_file'];
			}else{
				$pdf_file = $new_slug.'.pdf';
			}
			
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
			if(file_exists($pdf_path)){
				$this->zip->read_file($pdf_path);
			}else{ 
				$this->load->helper('directory');	
				$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
				if($map){ foreach($map as $row){
					$this->zip->read_file($row);
				} } 
			}
			
			$map_font = directory_map($font_path.'/');
			$map_link = directory_map($links_path.'/');
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){ 
				$this->zip->read_dir($links_path, FALSE);
			}
			 
			if(isset($_POST['download'])){
				$this->zip->archive($SourceFilePath.'/'.$new_slug.'.zip');
				$this->zip->download($new_slug.'.zip');
			}else{
				//send source zip to ftp( metro design6 design7)
				if(isset($_POST['hd']) && isset($order_id) && ($_POST['hd']=='2')){
					$post = array('order_id' => $order_id, 'hd' => $_POST['hd'], 'slug' => $new_slug, 'path' => $SourceFilePath);
					$this->db->insert('sourcefile_move', $post);
					
				}   
				if(isset($_POST['archive'])){
				$this->zip->archive($SourceFilePath.'/'.$new_slug.'.zip');
					//unlink($SourceFilePath.'/'.$new_slug.'.zip');
				}
				//send to adrep
				$zip_folder = glob($SourceFilePath.'/*.zip',GLOB_BRACE);
				//if($zip_folder){ foreach($zip_folder as $row_zip){ unlink($row_zip); }} //zip folder deletion
				 
				$pdf_uploads = "pdf_uploads/".$order_id ;
				if (@mkdir($pdf_uploads,0777)){}
					if(file_exists($pdf_path)){
						$pdf_uploads = $pdf_uploads.'/'.$pdf_file;
						copy($pdf_path, $pdf_uploads);
					}else{
							$this->load->helper('directory');	
							$map_jpg = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
							if($map_jpg){ foreach($map_jpg as $row){
									$pdf_uploads = $pdf_uploads.'/'.basename($row);
									$pdf_path = $SourceFilePath.'/'.$row;
									copy($row, $pdf_uploads);
							} }else{ return false; } 
					}	
					return true;
				//}else{ return false; }
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}
	
	public function zip_folder() 
	{
		if(isset($_POST['file_path']) && !empty($_POST['file_path']))
		{
			$this->load->library('zip');
		
			$path = $_POST['file_path'].'/';
			if($this->zip->read_dir($path, FALSE)){
				$this->zip->download($_POST['file_name']); 
			}else{
				echo "<script>alert('Couldnt Actually Download!!')</script>";
			}
		}
	}
	
	public function live_ads()
	{
		$this->load->view('new_admin/live_ads');
	}
	
public function revision_frontlinetrack($date = '')
	{
		
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
		
		if($date == ''){
			$date = $data['today'];
		}
		
		$data['date'] = $date;
		
		if(isset($_POST['update_status'])){
			$err_status = array('error_type' => $_POST['error_id']);
			$this->db->where('id', $_POST['id']);
			$this->db->update('rev_order_reason', $err_status);
			if($this->db->affected_rows()){
					$this->session->set_flashdata("message",'Error Type Updated Successfully!!');
					redirect('new_admin/home/revision_frontlinetrack');
			}else{
					$this->session->set_flashdata("message",'Invalid Error Type!!');
					redirect('new_admin/home/revision_frontlinetrack');
			}
		}
		
		$data['jobs'] = $this->db->query("SELECT `id`, `version`, `order_id`, `note`, `file_path`, `order_no`, `help_desk`, `pdf_path` FROM `rev_sold_jobs` WHERE `order_id` != '' AND `date` = '$date' " )->result_array();
		
		$data['error_type'] = $this->db->query("SELECT * FROM `rev_error_type`")->result_array();
		
		$this->load->view('new_admin/revision_frontlinetrack', $data);
	}

	public function complaint_list($date="")
	{
		$data['hi'] = 'hi';
		$data['complaint_type'] = $this->db->get_where('complaint_type')->result_array();
		if($date != ''){
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `c_error` = '1' AND `date` = '$date' ;")->result_array();
			//$data['date'] = $date;
		}else{
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `c_error` = '1'")->result_array();
		}
		/* if(isset($_POST['complaint'])){
			$rev_id = $_POST['rev_id'];
			$complaint_data = array('complaint_type'=> $_POST['complaint']);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $complaint_data);
				redirect('new_admin/home/complaint_list/'.$date);
			} */
		$this->load->view('new_admin/complaint_list',$data);
	}
	
	public function error_report($type="",$user="")
    {
        $designer_id = $_GET['designer_id'];
        $data['designer_id'] = $designer_id;
        $data['type'] = $type;
        $data['user'] = $user;
        
        if($designer_id == 'all'){ 
            $data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }else{
            $data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '".$_GET['designer_id']."'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }
        $this->load->view('new_admin/error_report',$data);
    }
    
    
	public function error_report_csr($type="",$user="")
    {
        $data['csr_id'] = $_GET['csr_id'];
        $data['type'] = $type;
        $data['user'] = $user;
        if($_GET['csr_id'] == 'all'){ 
            $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }else{
            $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `id` = '".$_GET['csr_id']."'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }
        $this->load->view('new_admin/error_report_csr',$data);
    }

	
	public function error_list($date="")
	{
		$data['hi'] = 'hi';
		$data['EA'] = 'Error';
		if($date != ''){
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE (`reason_c` = '2' OR `reason_c` = '3') AND (`c_error` = '0') AND `date` = '$date' ;")->result_array();
			//$data['date'] = $date;
		}else{
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE (`reason_c` = '2' OR `reason_c` = '3') AND (`c_error` = '0')")->result_array();
		}
		/* if(isset($_POST['c_submit'])){
			$c_error_id = $_POST['c_error'];
			$rev_id = $_POST['rev_id'];
			//echo "<script>alert($rev_id)</script>";
			$c_post = array('c_error' => $c_error_id);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $c_post);
		} */
		$this->load->view('new_admin/error_list',$data);
	}
	
	public function error_analysis($hd='',$order_id='',$EA='')
	{
		// Error Update
		if(isset($_POST['c_submit'])){
			$c_error_id = $_POST['c_error'];
			$rev_id = $_POST['rev_id'];
			//echo "<script>alert($rev_id)</script>";
			 $c_post = array('c_error' => $c_error_id);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $c_post); 
				redirect('new_admin/home/orderview_history/'.$hd.'/'.$order_id.'/'.$EA);
		}
		
		// Error Type Update
		if(isset($_POST['submit_error'])){
			$rev_id = $_POST['rev_id'];
			//echo "<script>alert($rev_id)</script>";
			 $complaint_data = array('complaint_type'=> $_POST['complaint']);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $complaint_data); 
				redirect('new_admin/home/orderview_history/'.$hd.'/'.$order_id.'/'.$EA);
			}
			
		//Complaint Update
		if(isset($_POST['submit_complaint'])){
			$c_complaint_id = $_POST['c_complaint'];
			$rev_id = $_POST['rev_id'];
			//echo "<script>alert($rev_id)</script>";
			 $c_post1 = array('c_complaint' => $c_complaint_id);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $c_post1); 
				redirect('new_admin/home/orderview_history/'.$hd.'/'.$order_id.'/'.$EA);
		}
	}
	
	public function newad_upload()
	{
		//echo date('Y-m-01', strtotime('-3 month'));
		$data['hi'] = 'hi';
		$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		$data['pub_project'] = $this->db->query("SELECT * FROM `pub_project`")->result_array();
		if(isset($_POST['Submit'])){
		$orders = $this->db->get_where('orders',array('job_no' => $_POST['job_name']))->result_array();
		if($orders){
			$this->session->set_flashdata("message","Order with Unique Job Name: ".$_POST['job_name']." already exists!!");
			redirect('new_admin/home/newad_upload');
		}else{
		$pub_details = $this->db->get_where('publications',array('id' => $_POST['publication_id']))->result_array();
		$date = date('Y-m-01', strtotime('-3 month'));
		$post = array('adrep_id' => $_POST['adrep_id'],
					 'publication_id' => $_POST['publication_id'],
					 'group_id' => $pub_details[0]['group_id'],
					 'help_desk' => $pub_details[0]['help_desk'],
					 'order_type_id' => '2', 	//print ad
					 'advertiser_name' => $_POST['advertiser'],
					 'job_no' => $_POST['job_name'],
					 'width' => $_POST['width'],
					 'height' => $_POST['height'],
					 'created_on' => $date,
					 'status' => '5',
					 'project_id' => $_POST['project_id']
				);
				$this->db->insert('orders',$post);
				$insert_id = $this->db->insert_id();
				if($insert_id){
					if(!empty($_FILES['file']['name']))
					{
						$dir = "pdf_uploads/".$insert_id;
						if (@mkdir($dir,0777)){ }
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						if(move_uploaded_file($tempFile, $dir.'/'.$fileName)){
							$pdf_timestamp = date("Y-m-d H:i:s");
							$pdf = $dir.'/'.$fileName;
							$dataa = array( 'pdf' => $pdf, 'pdf_timestamp' => $date);
							$this->db->where('id', $insert_id);
							$this->db->update('orders', $dataa); 
						}else{ 
							$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
							redirect('new_admin/home/newad_upload');
						}
					}
					$this->session->set_flashdata("message","Order No: ".$insert_id." Submitted!!");
					redirect('new_admin/home/newad_upload');
				}
			}
		}
		$this->load->view('new_admin/newad_upload',$data);
	}
	
	public function trends()
	{
		$data['hi'] = 'hi';
		$data['to'] = date('Y-m-d');
		$data['from'] = date('Y-m-d', strtotime("-90 days"));
		$data['adreps'] = $this->db->get_where('adreps',array('is_active' => '1'))->result_array();
		$this->load->view('new_admin/trends',$data);
	}
	
	public function vidn_upload()
	{
		$orders = $this->db->get_where('orders',array('project_id'=>'1', 'pdf'=>'none'))->result_array();
		$ftp_server = 'ftps1a4l1.adwitads.com';
		$ftp_user_name = 'adwitadstest';
		$ftp_user_pass = 'ftp@123';
		$ftp_folder = 'vidn';
			$conn_id = ftp_connect($ftp_server)or die("couldnt connect to $ftp_server");
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("couldnt login to $ftp_server");
		ftp_pasv($conn_id, true);
		
		foreach($orders as $order){
			$order_id = $order['id'];
			$slug = $order['job_no'];
			$pdf_file = $ftp_folder.'/'.$slug.".pdf";
			$pdf_uploads = "pdf_uploads/".$order_id ;
			
			$chk_pdffile = ftp_size($conn_id, $pdf_file);
			if($chk_pdffile != '-1'){
				if (@mkdir($pdf_uploads,0777)){}
					$pdf_uploads = $pdf_uploads.'/'.$slug.'.pdf';
					
				if (!@ftp_get($conn_id, $pdf_uploads, $pdf_file, FTP_BINARY)){
					echo $order_id.'-file exists but upload error<br/>';
					continue;
				}else{
					//order status
					$pdf_timestamp = date("Y-m-d H:i:s");
					$post_status = array('pdf' => $pdf_uploads, 'pdf_timestamp' => $pdf_timestamp, 'project_id' => '0');
					$this->db->where('id', $order_id);
					$this->db->update('orders', $post_status);
				}
				
			}else{
				echo $order_id.'-ftp pdf file nit found<br/>';
				continue;
			}
					
		}
		ftp_close($conn_id);
	}
	
	public function credits_history( $adrep_id = '0')
	{
		$data['mycredits_history'] = $this->db->get_where('lite_mycredits_history', array('uid' => $adrep_id))->result_array();
		$this->load->view('new_admin/credits_history', $data);
	}
	
	public function revision_report()
	{
		$data['hi'] = "hello";
		if(isset($_GET['search']) && !empty($_GET['from']) && !empty($_GET['to'])){
			$from = $_GET['from'];
			$to = $_GET['to'];
			$query = "SELECT orders.id FROM `orders` 
										LEFT JOIN `rev_sold_jobs` ON orders.id = rev_sold_jobs.order_id
										 WHERE (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND rev_sold_jobs.id IS NULL";
			$data['count'] = $this->db->query($query)->num_rows();
			$data['from'] = $from;
			$data['to'] = $to;
			//echo $query;
		}
		$this->load->view('new_admin/revision_report', $data);
	}
	
	public function design_time($type="",$user="")
	{
		$designer_id = $_GET['designer_id'];
        $data['designer_id'] = $designer_id;
        $data['type'] = $type;
        $data['user'] = $user;
        
        if($designer_id == 'all'){ 
            $data['designers'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `is_active` = '1'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }else{
            $data['designers'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `id` = '".$_GET['designer_id']."'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }
        
        $this->load->view('new_admin/design_time',$data);
		//$query = "SELECT cat_result.id, cat_result.category FROM `cat_result`  WHERE (cat_result.ddate BETWEEN '$from' AND '$to')";
			
	}
	
	//mamatha 16/5/18
	
	public function report_sales($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		//$data['month3'] = date('Y-m', strtotime('-3 month'));
		//$data['month2'] = date('Y-m', strtotime('-2 month'));
		//$data['month1'] = date('Y-m', strtotime('-1 month'));
		if($user == 'adrep'){
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'web_ads'){
			$data['web_ads'] = 'web_ads';
		}
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'groups'){
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'pcsr'){
			$data['pcsr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		if($user == 'tl_qa'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		$this->load->view('new_admin/report_sales',$data);
	}
	
	public function report_production($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		//$data['month3'] = date('Y-m', strtotime('-3 month'));
		//$data['month2'] = date('Y-m', strtotime('-2 month'));
		//$data['month1'] = date('Y-m', strtotime('-1 month'));
		if($user == 'adrep'){
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'web_ads'){
			$data['web_ads'] = 'web_ads';
		}
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'groups'){
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'pcsr'){
			$data['pcsr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		if($user == 'tl_qa'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		$this->load->view('new_admin/report_production',$data);
	}
	
	
	public function sales_manage()
	{
		$data['business_groups'] = $this->db->query("SELECT * FROM `business_groups`")->result_array();
        $data['team_lead'] = $this->db->query("SELECT * FROM `team_lead` where `is_active` = '1'")->result_array();
        $data['designers_list'] = $this->db->query("SELECT * FROM `designers` where `is_active` = '1'")->result_array();
        $data['location'] = $this->db->query("SELECT * FROM `location`")->result_array();
        $data['ordering_system'] = $this->db->query("SELECT * FROM `ordering_system`")->result_array();
        $data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1'")->result_array();
        $data['publications_list'] = $this->db->query("SELECT * FROM `publications` where `is_active` = '1'")->result_array();
        $data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
        $data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
        $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
        $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
        $data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
        $data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1'")->result_array();
        $data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
        $data['template'] = $this->db->query("SELECT `id` FROM `orders` WHERE `spec_sold_ad` = '0' AND `order_type_id` = '2' AND pdf!='none'")->num_rows();
        $data['designer_role'] = $this->db->get('designer_role')->result_array();
        $data['csr_role'] = $this->db->get('csr_role')->result_array();
        $data['designer_level'] = $this->db->get('designer_level')->result_array();;
        
        $aid = $this->session->userdata('aId');
        $data['admin_users'] = $this->db->query("SELECT * FROM `admin_users` WHERE `id` = '$aid'")->result_array();
		$this->load->view('new_admin/sales_manage', $data);
	}
	
	public function production_manage()
	{
		$data['business_groups'] = $this->db->query("SELECT * FROM `business_groups`")->result_array();
        $data['team_lead'] = $this->db->query("SELECT * FROM `team_lead` where `is_active` = '1'")->result_array();
        $data['designers_list'] = $this->db->query("SELECT * FROM `designers` where `is_active` = '1'")->result_array();
        $data['location'] = $this->db->query("SELECT * FROM `location`")->result_array();
        $data['ordering_system'] = $this->db->query("SELECT * FROM `ordering_system`")->result_array();
        $data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1'")->result_array();
        $data['publications_list'] = $this->db->query("SELECT * FROM `publications` where `is_active` = '1'")->result_array();
        $data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
        $data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
        $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
        $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
        $data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
        $data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1'")->result_array();
        $data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
        $data['template'] = $this->db->query("SELECT `id` FROM `orders` WHERE `spec_sold_ad` = '0' AND `order_type_id` = '2' AND pdf!='none'")->num_rows();
        $data['designer_role'] = $this->db->get('designer_role')->result_array();
        $data['csr_role'] = $this->db->get('csr_role')->result_array();
        $data['designer_level'] = $this->db->get('designer_level')->result_array();;
        
        $aid = $this->session->userdata('aId');
        $data['admin_users'] = $this->db->query("SELECT * FROM `admin_users` WHERE `id` = '$aid'")->result_array();
		$this->load->view('new_admin/production_manage', $data);
	}
	
	public function admin_report_production($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		//$data['month3'] = date('Y-m', strtotime('-3 month'));
		//$data['month2'] = date('Y-m', strtotime('-2 month'));
		//$data['month1'] = date('Y-m', strtotime('-1 month'));
		if($user == 'adrep'){
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'web_ads'){
			$data['web_ads'] = 'web_ads';
		}
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'groups'){
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'pcsr'){
			$data['pcsr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		if($user == 'tl_qa'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'")->result_array();
		}
		$this->load->view('new_admin/admin_report_production',$data);
	}
	
	/*public function report_production_new($type='overview',$date='today')
	{
		$data['type'] = $type;
		$data['date'] = $date;
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		
		if($date == 'last_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		//echo 'date:'.$date.'From : '.$from.'To : '.$to;
		if($type == 'overview'){
			$data['print_ads'] = $this->db->query("SELECT orders.id,count(orders.id) as count_print_id FROM `orders` WHERE `order_type_id` = '1' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			//echo 'print_ads:'.count($print_ads); 
		
			$data['web_ads'] = $this->db->query("SELECT orders.id,count(orders.id) as count_web_id FROM `orders` WHERE `order_type_id` = '2' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->result_array();
			//echo 'web_ads:'.count($web_ads); 
		
			$data['nj'] = $this->db->query("SELECT cat_result.order_no,count(cat_result.order_no) as count_order_no FROM `cat_result` WHERE `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ")->result_array(); 
			//echo 'nj:'.count($nj); 
		}
		if($type == 'category'){
			$data['cat_A']= $this->db->query("SELECT count(category) as count_A FROM cat_result WHERE category = 'A' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['cat_B']= $this->db->query("SELECT count(category) as count_B FROM cat_result WHERE category = 'B' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['cat_C']= $this->db->query("SELECT count(category) as count_C FROM cat_result WHERE category = 'C' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['cat_D']= $this->db->query("SELECT count(category) as count_D FROM cat_result WHERE category = 'D' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['cat_E']= $this->db->query("SELECT count(category) as count_E FROM cat_result WHERE category = 'E' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['cat_F']= $this->db->query("SELECT count(category) as count_F FROM cat_result WHERE category = 'F' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['cat_G']= $this->db->query("SELECT count(category) as count_G FROM cat_result WHERE category = 'G' AND (`date` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			
			//print_r($data['cat_A']);
			//echo count($cat_A);	
		}
		
		if($type == 'new_revision'){
			$data['new_ads_count'] = $this->db->query("SELECT orders.id,count(orders.id) as count_new_id FROM `orders` WHERE  (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
			$data['rev_count'] = $this->db->query("SELECT rev_sold_jobs.order_id,count(rev_sold_jobs.order_id) as count_rev_id  FROM `rev_sold_jobs` WHERE `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
		}
		$data['custom'] = date('Y-m-d');
		$data['from'] = $from;
		$data['to'] = $to;
		
		$this->load->view('new_admin/report_production_new',$data);
	}*/
	
	
	/* ------Designer Avg NJ Starts------*/
	
	public function report_designer_avg_nj($type="",$user="")
	{
		//$designer_id = $_GET['designer_id'];
		//$data['designer_id'] = $designer_id;
		
        $data['type'] = $type;
        $data['user'] = $user;
        $data['designers'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `is_active` = '1'")->result_array();
        $data['from'] = $_GET['from'];
        $data['to'] = $_GET['to'];
		
		$time1 = strtotime($data['from']);
		$time2 = strtotime($data['to']);
			$diff = $time2-$time1;
			$data['days']    = floor($diff / 86400);
			
		$data['designer_level'] = $this->db->query("SELECT `id`,`name` FROM `designer_level` ORDER BY `id` DESC ")->result_array();
		$this->load->view("new_admin/report_designer_avg_nj",$data);
	}
	
	public function designer_avg_nj_details($type="",$user="",$level="")
	{
        $data['type'] = $type;
        $data['user'] = $user;
		$data['level'] = $level;
	
		$data['from'] = $_GET['from'];
        $data['to'] = $_GET['to'];
		
		$query = "SELECT `id`, `name`, `username` FROM `designers` WHERE `level` = '$level' AND `is_active` = '1'";
		$data['designers'] = $this->db->query("$query")->result_array();
		
		$this->load->view("new_admin/designer_avg_nj_details",$data);
	}
	
	public function admin_report_designer_avg_nj($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		
		
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		}
		
		$this->load->view('new_admin/admin_report_designer_avg_nj',$data);
	}
	
	/* ------Designer Avg NJ Ends------- */
	
	
	public function report_category($type="",$user="",$order_type='2')
	{
		$data['type'] = $type;
        $data['user'] = $user;
		
		$pub_id =  $_GET['publication_id'];
		$data['pub_id'] = $pub_id; 
		if(isset($_GET['from'])){
			$from = $_GET['from'];
			$to = $_GET['to'];
		}
		$data['from'] = $_GET['from'];
        $data['to'] = $_GET['to'];
		
		if(isset($_GET['order_type']) && !empty($_GET['order_type'])){ 
			$order_type = $_GET['order_type']; 
		}
		$data['order_type'] = $order_type;
		 
		$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.category FROM `cat_result` 
		LEFT JOIN `orders` ON cat_result.order_no = orders.id
		WHERE cat_result.publication_id = '$pub_id' AND (cat_result.date BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none' AND orders.order_type_id = '$order_type') GROUP BY cat_result.category";
		
		$data['orders'] = $this->db->query("$query")->result_array();
		//echo($query);
        $data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$pub_id'")->result_array();
       
		$this->load->view("new_admin/report_category",$data);
	}
	
	public function admin_report_category($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		
		$this->load->view('new_admin/admin_report_category',$data);
	}
	
	public function category_pub_design_details($type="",$user="",$order_type='2',$pub_id="",$cat="")
	{
		$data['type'] = $type;
        $data['user'] = $user;
		$data['cat'] = $cat;
		
		$data['pub_id'] = $pub_id; 
		if(isset($_GET['from'])){
			$from = $_GET['from'];
			$to = $_GET['to'];
		}
		$data['from'] = $_GET['from'];
        $data['to'] = $_GET['to'];
		
		if(isset($_GET['order_type']) && !empty($_GET['order_type'])){ 
			$order_type = $_GET['order_type']; 
		}
		$data['order_type'] = $order_type;
		
		$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.designer, designers.name,username FROM `cat_result` 
		LEFT JOIN `orders` ON cat_result.order_no = orders.id
		LEFT JOIN `designers` ON cat_result.designer = designers.id
		WHERE cat_result.category = '$cat' AND cat_result.publication_id = '".$pub_id."' AND (cat_result.date BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none' AND orders.order_type_id = '$order_type') GROUP BY cat_result.designer";
		
		$data['orders'] = $this->db->query("$query")->result_array();
		$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$pub_id'")->result_array();
		
		$this->load->view('new_admin/category_pub_design_details',$data);
	}
	
	
	public function revision_instruction($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		
		$this->load->view('new_admin/revision_instruction',$data);
	}
	
	public function revision_instruct_report($type="",$user="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		if($_GET['publication_id'] == 'all'){ 
            $data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
            $data['d'] = $_GET['date'];
        }else{
            $data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$_GET['publication_id']."'")->result_array();
            $data['d'] = $_GET['date'];
        }
		$data['publication_id'] = $_GET['publication_id'];
		
		$this->load->view('new_admin/revision_instruct_report',$data);
	}
	
}
