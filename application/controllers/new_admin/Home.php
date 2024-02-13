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
			if(!empty($_GET['publication_id'])){
				$data['pub_id'] = $_GET['publication_id'];
			}
			$data['from'] = $from;
			$data['to'] = $to;
			$data['total_count'] = $_GET['total_count'];
		}
		if(isset($_GET['designer_count']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])){
			
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			if(!empty($_GET['publication_id'])){
				$data['pub_id'] = $_GET['publication_id'];
			}
			$data['from'] = $from;
			$data['to'] = $to;
			$data['designer_count'] = $_GET['designer_count'];
		}
		if(isset($_GET['csr_count']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])){
			
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			if(!empty($_GET['publication_id'])){
				$data['pub_id'] = $_GET['publication_id'];
			}
			$data['from'] = $from;
			$data['to'] = $to;
			$data['csr_count'] = $_GET['csr_count'];
		}
		$data['reason_name'] = $this->db->query("SELECT `id`,`name` FROM `rev_reason` ORDER BY `id` DESC ")->result_array();
		$data['designer_name'] = $this->db->query("SELECT `id`,`name` FROM `designers` WHERE `is_active` = '1'")->result_array();
		$data['csr_name'] = $this->db->query("SELECT `id`,`name` FROM `csr` WHERE `is_active` = '1'")->result_array();
		$data['publications'] = $this->db->query("SELECT id, name FROM publications WHERE is_active='1'")->result_array();
		$this->load->view('new_admin/revision_reason',$data);
	}

	public function revision_reason_details($reason_id='', $from='', $to='', $pub_id='')
	{
		if(!empty($pub_id)){
			$query = "SELECT rev_order_reason.* FROM `rev_order_reason` 
						JOIN orders ON rev_order_reason.order_id = orders.id
							WHERE orders.publication_id = '$pub_id' AND rev_order_reason.reason_id = '".$reason_id."' AND (rev_order_reason.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
			$reason_details = $this->db->query("$query")->result_array();
		}else{
			$reason_details = $this->db->query("SELECT * FROM `rev_order_reason` WHERE `reason_id` = '".$reason_id."' AND (`timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
		}
		$data['reason_details'] = $reason_details;
		
		$this->load->view('new_admin/revision_reason_details',$data);
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
        $data['hi'] = 'hello';
        if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
            $from = $_GET['from_date'];
            $to = $_GET['to_date'];
            
            $data['from'] = $from;
            $data['to'] = $to;
        /*$data['total_rev'] = $this->db->query("SELECT `id` FROM `rev_sold_jobs` 
						              WHERE `date` BETWEEN '$from' AND '$to'  ")->num_rows();
		*/				              
        $data['five_mins'] = $this->db->query("SELECT `id` FROM `rev_sold_jobs` 
						              WHERE `classification` = '1' AND `date` BETWEEN '$from' AND '$to'  ")->num_rows();
		$data['text_copy'] = $this->db->query("SELECT `id` FROM `rev_sold_jobs` 
						              WHERE `classification` = '2' AND `date` BETWEEN '$from' AND '$to'  ")->num_rows();
		$data['design_challenge'] = $this->db->query("SELECT `id` FROM `rev_sold_jobs` 
						              WHERE `classification` = '3' AND `date` BETWEEN '$from' AND '$to'  ")->num_rows();
		$data['extensive'] = $this->db->query("SELECT `id` FROM `rev_sold_jobs` 
						              WHERE `classification` = '4' AND `date` BETWEEN '$from' AND '$to'  ")->num_rows();
				
						              
	    /*$query = "SELECT rev_sold_jobs.id FROM `rev_sold_jobs` 
					RIGHT JOIN `rev_classification_new_content` ON rev_classification_new_content.rev_id = rev_sold_jobs.id
					    WHERE rev_sold_jobs.date BETWEEN '$from' AND '$to'";
		$data['client_dislike'] = $this->db->query($query." AND  rev_classification_new_content.yes_or_no = '1'")->num_rows();*/
		/*			    
		$design_change_Y = $this->db->query($query." AND rev_sold_jobs.classification = '3' AND  rev_classification_new_content.yes_or_no = '1'")->num_rows();
		$design_change_N = $this->db->query($query." AND rev_sold_jobs.classification = '3' AND  rev_classification_new_content.yes_or_no = '0'")->num_rows();
						     
		$extensive_Y = $this->db->query($query." AND rev_sold_jobs.classification = '4' AND  rev_classification_new_content.yes_or_no = '1'")->num_rows();
		$extensive_N = $this->db->query($query." AND rev_sold_jobs.classification = '4' AND  rev_classification_new_content.yes_or_no = '0'")->num_rows();
						     
		$data['new_content'] = $text_copy + $design_change_Y + $extensive_Y;
		$data['client_dislike'] = $design_change_N + $extensive_N;
		*/
		//echo $text_copy.'-'.$design_change_Y.'-'.$extensive_Y;			     
       // $data['classification'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
        }
        $this->load->view('new_admin/revision_version_report',$data);
    }
    
    public function revision_version_report_details()
    {
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $from = $_POST['from_date'];
            $to = $_POST['to_date'];
            $output = '';
            if($id == 'client_dislike'){
                $query = "SELECT rev_sold_jobs.id, rev_sold_jobs.order_id, rev_sold_jobs.version FROM `rev_sold_jobs` 
					RIGHT JOIN `rev_classification_new_content` ON rev_classification_new_content.rev_id = rev_sold_jobs.id
					    WHERE rev_sold_jobs.date BETWEEN '$from' AND '$to'";
		        $order_details = $this->db->query($query." AND  rev_classification_new_content.yes_or_no = '1'")->result_array();    
            }else{
                $order_details = $this->db->query("SELECT `id`, `order_id`, `version` FROM `rev_sold_jobs` 
						              WHERE `classification` = '$id' AND `date` BETWEEN '$from' AND '$to'  ")->result_array();
            }
			$output .= '<table class="table table-bordered table-hover" id="sample_6">
					        <thead>
        						<tr>
        						    <td>Order Id</td>
        						    <td>Version</td>
        						 </tr>
        					</thead>
					        <tbody>';			              
			foreach($order_details as $row){
			    $output .= '<tr>
			                    <td><a href="'.base_url().index_page().'new_admin/home/order_review_history/'.$row['order_id'].'">'.$row['order_id'].'</a></td>
			                    <td>'.$row['version'].'</td></tr>';
			}
			$output .= '</tbody></table> ';
			echo $output;
        }
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
	   $today_date_time = $this->db->query("SELECT `time` FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		$current_time = date("H:i:s");
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date)); //echo $day.' '.$current_time;
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		if($day == 'Mon'){ //Friday To Monday
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $day_before_yyday.' '.$ystday_time; //Friday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    	        //$from_date_range = $day_before_yyday.' '.$today_time;   //Friday 08:29:59
    	        $from_date_range = $current_date.' '.$today_time;   //Friday 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
			}
		}elseif($day == 'Sun'){ //Saturday To Sunday
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $day_before_yday.' '.$ystday_time;   //saturday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    		    $from_date_range = $day_before_yday.' '.$today_time;    //saturday 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
			 }    
		}else{
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $ysterday.' '.$ystday_time;          //yesterday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			    //date range for yesterdays ads
			    $yst_from_date_range = $day_before_yday.' '.$ystday_time ;  
			    $yst_to_date_range = $ysterday.' '.$today_time;  
			 }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    	        $from_date_range = $current_date.' '.$today_time;      //today 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //tomorrow 08:29:59
			    //date range for yesterdays ads
			    $yst_from_date_range = $ysterday.' '.$today_time ;  
			    $yst_to_date_range = $current_date.' '.$tomo_time; 
			 }
		}
		//Today Ads Count Start
		$data['today_from_date_range'] = $from_date_range;    $data['today_to_date_range'] = $to_date_range;
		//Total Print Ads count
		$total_ads_q = "SELECT COUNT(orders.id) AS total_Ads FROM `orders`
    			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    									                           AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id != '6';";
    									                                        
    	//Pending Print Ads count
    	$pending_ads_q = "SELECT COUNT(orders.id) AS pending_Ads FROM `orders` 
    			                    WHERE (orders.status BETWEEN '1' AND '4') 
    										                          AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    										                              AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';";
    										                                    
    	//Sent Print Ads count
    	$sent_ads_q = "SELECT COUNT(orders.id) AS sent_Ads FROM `orders`
    			                    WHERE (orders.status BETWEEN '5' AND '7') 
    										                      AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    										                          AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';";
    	
    	//Question count
    	$question_ads_q = "SELECT COUNT(orders.id) AS question_Ads FROM `orders`
    			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    			                        AND orders.question = '1' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';";
    	//cancel request count
    	$cancel_ads_q = "SELECT COUNT(orders.id) AS cancel_Ads FROM `orders`
    			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') AND orders.crequest = '1' AND orders.order_type_id != '6';";		                    
    	//echo $total_ads_q;									                          
		$data['total_ads'] = $this->db->query("$total_ads_q")->row_array();
		$data['pending_ads'] = $this->db->query("$pending_ads_q")->row_array();
		$data['sent_ads'] = $this->db->query("$sent_ads_q")->row_array();
		$data['question_ads'] = $this->db->query("$question_ads_q")->row_array();
		$data['cancel_ads'] = $this->db->query("$cancel_ads_q")->row_array();
		//Today Ads Count End
		
		//yesterday's Ads count start
		if(isset($yst_from_date_range)){
    		//Total Print Ads count
    		$yst_total_ads_q = "SELECT COUNT(orders.id) AS total_Ads FROM `orders`
        			                    WHERE (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range') 
        									                           AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id != '6';";
        									                                        
        	//Pending Print Ads count
        	$yst_pending_ads_q = "SELECT COUNT(orders.id) AS pending_Ads FROM `orders` 
        			                    WHERE (orders.status BETWEEN '1' AND '4') 
        										                          AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range') 
        										                              AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';";
        										                                    
        	//Sent Print Ads count
        	$yst_sent_ads_q = "SELECT COUNT(orders.id) AS sent_Ads FROM `orders`
        			                    WHERE (orders.status BETWEEN '5' AND '7') 
        										                      AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range') 
        										                          AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';";
        	//echo '<br/>'.$yst_total_ads_q;									                          
    		$data['yst_total_ads'] = $this->db->query("$yst_total_ads_q")->row_array();
    		$data['yst_pending_ads'] = $this->db->query("$yst_pending_ads_q")->row_array();
    		$data['yst_sent_ads'] = $this->db->query("$yst_sent_ads_q")->row_array();
    		$data['yst_from_date_range'] = $yst_from_date_range;    $data['yst_to_date_range'] = $yst_to_date_range;
		
    	//status wise yst ads count START
    		$yst_q_status = "SELECT COUNT(orders.id) as ad_count, order_status.name, order_status.id FROM `orders` 
        								JOIN order_status ON order_status.id = orders.status
        									WHERE (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range')
        									AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id != '6'
        									GROUP by orders.status";
        	//echo $q_status;
        	$data['yst_order_status_count'] = $this->db->query("$yst_q_status")->result_array();
    	//status wise yst ads count END
		}
		//category wise pending ads count START
		$q = "SELECT COUNT(orders.id) as ad_count, cat_result.category FROM `orders` 
    								JOIN cat_result ON cat_result.order_no = orders.id
    									WHERE orders.pdf = 'none' AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    									AND orders.crequest!='1' AND orders.cancel!='1' 
    									GROUP by cat_result.category";
    									
		$data['order_cat_count'] = $this->db->query("$q")->result_array();
		//category wise pending ads count End
		
		//status wise todays ads count START
		$q_status = "SELECT COUNT(orders.id) as ad_count, order_status.name, order_status.id FROM `orders` 
    								JOIN order_status ON order_status.id = orders.status
    									WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range')
    									AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id != '6'
    									GROUP by orders.status";
    	//echo $q_status;
    	$data['order_status_count'] = $this->db->query("$q_status")->result_array();
		//status wise todays ads count END
		$data['adwit_teams'] = $this->db->query("SELECT `adwit_teams_id`,`name` FROM `adwit_teams` WHERE `is_active`='1' ORDER BY `orderBy`")->result_array();
		
		if(isset($_POST['help_desk']) && !empty($_POST['help_desk'])){
		    $data['help_desk_id'] = $this->db->query("SELECT `id` FROM `help_desk` WHERE `id` = '".$_POST['help_desk']."'")->result_array();
		    $data['hd_id'] = $_POST['help_desk'];
		}
		
		$this->load->view('new_admin/dashboard',$data);
	}
	/*********************************** Pagination *******************************/
	public function get_dashboard_pagination_ad_count()
	{
	     //Dashboard Ads Count
		 $today_date_time = $this->db->query("SELECT `time` FROM `today_date_time`")->result_array();
    		//Time	
    		$ystday_time = $today_date_time[0]['time'];
    		$today_time = $today_date_time[1]['time'];
    		$tomo_time = $today_date_time[2]['time'];
    		$current_time = date("H:i:s");
    		//Day
    		$current_date = date("Y-m-d");
    		$day = date("D", strtotime($current_date)); //echo $day.' '.$current_time;
    		$ysterday = date("Y-m-d", strtotime(' -1 day'));
    		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
    		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
    		$tomo = date("Y-m-d", strtotime(' +1 day'));
    		
    		if($day == 'Mon'){ //Friday To Monday
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $day_before_yyday.' '.$ystday_time; //Friday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        	        $from_date_range = $day_before_yyday.' '.$today_time;   //Friday 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
    			}
    		}elseif($day == 'Sun'){ //Saturday To Sunday
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $day_before_yday.' '.$ystday_time;   //saturday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        		    $from_date_range = $day_before_yday.' '.$today_time;    //saturday 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
    			 }    
    		}else{
    		    if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $ysterday.' '.$ystday_time;          //yesterday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			    //date range for yesterdays ads
    			    $yst_from_date_range = $day_before_yday.' '.$ystday_time ;  
    			    $yst_to_date_range = $ysterday.' '.$today_time;  
    			 }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        	        $from_date_range = $current_date.' '.$today_time;      //today 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //tomorrow 08:29:59
    			    //date range for yesterdays ads
    			    $yst_from_date_range = $ysterday.' '.$today_time ;  
    			    $yst_to_date_range = $current_date.' '.$tomo_time; 
    			 }
    		}
    	
		    $output_yst_status = '';
		    //Todays Print Ads count
		    $total_ads_q = "SELECT COUNT(orders.id) AS total_Ads FROM `orders`
    			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') AND orders.status NOT IN (9,10,11)
    									                           AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id = '6';";
    		
        	//Pending Print Ads count
        	$pending_ads_q = "SELECT COUNT(orders.id) AS pending_Ads FROM `orders` 
    			                    WHERE (orders.status BETWEEN '1' AND '4') 
    										                          AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    										                              AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id = '6';";
    										                                    
        	//Sent Print Ads count
        	$sent_ads_q = "SELECT COUNT(orders.id) AS sent_Ads FROM `orders`
        			                    WHERE (orders.status BETWEEN '5' AND '7') 
        										                      AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
        										                          AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id = '6';";
        	
        	//Question count
        	$question_ads_q = "SELECT COUNT(orders.id) AS question_Ads FROM `orders`
        			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
        			                        AND orders.question = '1' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id = '6';";
        	//cancel request count
        	$cancel_ads_q = "SELECT COUNT(orders.id) AS cancel_Ads FROM `orders`
        			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') AND orders.crequest = '1' AND orders.order_type_id = '6';";		                    
        	//echo $total_ads_q;
        	
        	$todays_total_ads = $this->db->query($total_ads_q)->row_array();
		    $todays_pending_ads = $this->db->query($pending_ads_q)->row_array();
		    $todays_sent_ads = $this->db->query($sent_ads_q)->row_array();
		    $todays_question_ads = $this->db->query($question_ads_q)->row_array();
		    $todays_cancel_ads = $this->db->query($cancel_ads_q)->row_array();
		    
		    $yesterdays_total_ads_count = 0; $yesterdays_pending_ads_count = 0; $yesterdays_sent_ads_count = 0;
		    if(isset($yst_from_date_range)){
		        //order recieved status 
                $yst_order_recieved = $this->db->query("SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                                            LEFT JOIN `order_status` ON orders.status = order_status.id
                                                             WHERE orders.status = 1 AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' AND orders.order_type_id = '6' 
                                                             GROUP BY orders.status;")->row_array();
            	$yst_order_recieved_count = (!empty($yst_order_recieved['ad_count'])) ? $yst_order_recieved['ad_count'] : 0;
            	
		        $yst_order_status = $this->db->query("SELECT COUNT(orders.id) as ad_count, order_status.name as statusName, order_status.id FROM `orders` 
            								JOIN order_status ON order_status.id = orders.status
            									WHERE (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range') AND orders.order_type_id = '6' AND orders.status NOT IN (9,10,11)
            									GROUP by orders.status")->result_array();
            									
            	$output_yst_status ='<div class="col-md-2 col-sm-2 col-xs-6">
    								<div class="uppercase font-hg font-black-flamingo">'.$yst_order_recieved_count.'</div>
    								<div class="font-grey-mint font-sm">Order Received</div>
    							</div>';
            	foreach($yst_order_status as $ystatus){ 
        		    $output_yst_status .= '<div class="col-md-2 col-sm-2 col-xs-6">
        								        <div class="uppercase font-hg font-black-flamingo">'.$ystatus['ad_count'].'</div>
        								        <div class="font-grey-mint font-sm">'.$ystatus['statusName'].'</div>
        							        </div>';
        							
        		} 
		    }
		    
		    //status wise ads count START
    		$q_status_wise = "SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName, order_status.id FROM `orders` 
                                LEFT JOIN `order_status` ON orders.status = order_status.id
                                            WHERE orders.order_type_id = '6' AND orders.status NOT IN (9,10,11)
                                                AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;";
            //order recieved status 
            $order_recieved = $this->db->query("SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                                        LEFT JOIN `order_status` ON orders.status = order_status.id
                                                         WHERE orders.status = 1 AND orders.order_type_id = '6'
                                                            AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;")->row_array();
        	$order_recieved_count = (!empty($order_recieved['ad_count'])) ? $order_recieved['ad_count'] : 0;
        	$total_count = $order_recieved_count;
        	$status_wise_volume = $this->db->query("$q_status_wise")->result_array();
        	
        	$output_status ='<div class="col-md-2 col-sm-2 col-xs-6">
        	                    <a href="'.base_url().index_page().'new_admin/home/todays_ad_details_pagination?status=1&from='.$from_date_range.'&to='.$to_date_range.'" target="_blank">
    								<div class="uppercase font-hg font-black-flamingo">'.$order_recieved_count.'</div>
    								<div class="font-grey-mint font-sm">Order Received</div>
    							</a>
    						</div>';
        	foreach($status_wise_volume as $status){ 
        	    $total_count = $total_count + $status['ad_count'];
    		    $output_status .= '<div class="col-md-2 col-sm-2 col-xs-6">
    		                          <a href="'.base_url().index_page().'new_admin/home/todays_ad_details_pagination?status='.$status['id'].'&from='.$from_date_range.'&to='.$to_date_range.'" target="_blank">
        								<div class="uppercase font-hg font-black-flamingo">'.$status['ad_count'].'</div>
        								<div class="font-grey-mint font-sm">'.$status['statusName'].'</div>
        							</a>
    							  </div>';
    							
    		} 
        	//todays
    		$data['todays_total_ads_count'] = $todays_total_ads['total_Ads'];
		    $data['todays_pending_ads_count'] = $todays_pending_ads['pending_Ads'];
		    $data['todays_sent_ads_count'] = $todays_sent_ads['sent_Ads'];
		    $data['question_ads_count'] = $todays_question_ads['question_Ads'];
		    $data['cancel_ads_count'] = $todays_cancel_ads['cancel_Ads'];
		    //yesterdays count
		    $data['yst_status_wise_count_div'] = $output_yst_status;
		    //category wise ad
		   // $data['category_wise_count_div'] = $output_category;
		    //status wise ad
		    $data['status_wise_count_div'] = $output_status;
		    $data['total_count'] = $total_count;
            echo json_encode($data);
	   // }
	 }
	 
	public function todays_ad_details_pagination($status='')
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		//Current Time
		$current_time = date("H:i:s");
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date));
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		if($day == 'Mon'){ //Friday To Monday
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $day_before_yyday.' '.$ystday_time; //Friday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        	        $from_date_range = $day_before_yyday.' '.$today_time;   //Friday 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
    			}
    		}elseif($day == 'Sun'){ //Saturday To Sunday
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $day_before_yday.' '.$ystday_time;   //saturday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        		    $from_date_range = $day_before_yday.' '.$today_time;    //saturday 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
    			 }    
    		}else{
    		    if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $ysterday.' '.$ystday_time;          //yesterday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			    //date range for yesterdays ads
    			    $yst_from_date_range = $day_before_yday.' '.$ystday_time ;  
    			    $yst_to_date_range = $ysterday.' '.$today_time;  
    			 }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        	        $from_date_range = $current_date.' '.$today_time;      //today 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //tomorrow 08:29:59
    			    //date range for yesterdays ads
    			    $yst_from_date_range = $ysterday.' '.$today_time ;  
    			    $yst_to_date_range = $current_date.' '.$tomo_time; 
    			 }
    		}
    		
		
		
		if(isset($_GET['status']) && isset($_GET['from']) && isset($_GET['to'])){ //Status wise ads count
	        $from = $_GET['from'];
	        $to = $_GET['to'];
	        $status = $_GET['status'];
	        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
	                                    JOIN `publications` ON publications.id = orders.publication_id
                        				JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                            WHERE (orders.created_on BETWEEN '$from' AND '$to') 
				                            AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id = '6'
				                            AND orders.status = '".$status."'";
			//echo $q;	                            
			$data['all_orders'] = $this->db->query("$q;")->result_array();
			
	    }else{
	        //total ads
		    $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
		                    JOIN `publications` ON publications.id = orders.publication_id
                        	JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    									                           AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id = '6'";
    		if($status == 'total'){
    		    $q .= " AND orders.status NOT IN (9,10,11);";
    		}elseif($status == 'pending'){
    		    $q .= " AND (orders.status BETWEEN '1' AND '4') AND orders.pdf = 'none';";    
    		}elseif($status == 'sent'){
    		    $q .= " AND (orders.status BETWEEN '5' AND '7');";    
    		}elseif($status == 'question'){
    		    $q .= " AND orders.question = '1';";    
    		}elseif($status == 'cancel'){
    		    $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    		                JOIN `publications` ON publications.id = orders.publication_id
                        	JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
        			                    WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') AND orders.crequest = '1' AND orders.order_type_id = '6';";    
    		}
    				                    
        	$data['all_orders'] = $this->db->query("$q;")->result_array();		                    
	    }
		$this->load->view('new_admin/todays_ad_details', $data);
	}
	
	/*********************************** END Pagination *******************************/ 
	public function todays_ad_details($cat='')
	{
		$today_date_time = $this->db->query("SELECT * FROM `today_date_time`")->result_array();
		$data['cat'] = $cat;								
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
		
		if(isset($_GET['status']) && isset($_GET['from']) && isset($_GET['to'])){ //Status wise ads count
	        $from = $_GET['from'];
	        $to = $_GET['to'];
	        $status = $_GET['status'];
	        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
	                                    JOIN `publications` ON publications.id = orders.publication_id
                        				JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                            WHERE (orders.created_on BETWEEN '$from' AND '$to') 
				                            AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6'
				                            AND orders.status = '".$status."'";
			//echo $q;	                            
			$data['all_orders'] = $this->db->query("$q;")->result_array();
			
	    }elseif(isset($_GET['category']) && isset($_GET['from']) && isset($_GET['to'])){ //Category wise ads count
	        $from = $_GET['from'];
	        $to = $_GET['to'];
	        $category = $_GET['category'];
	        
	        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
	                                    JOIN `publications` ON publications.id = orders.publication_id
                        				JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
        								JOIN cat_result ON cat_result.order_no = orders.id
        									WHERE (orders.created_on BETWEEN '$from' AND '$to') 
        									AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND cat_result.category = '$category'";
        	//echo $q;	                            
			$data['all_orders'] = $this->db->query("$q;")->result_array();
			
	    }else{
		    //old category wise ads count need to be deleted later
    		if($cat != ''){
    		    if($day == 'Mon'){
    			    if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    			                JOIN `publications` ON publications.id = orders.publication_id
                        		JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    			                JOIN cat_result ON cat_result.order_no = orders.id
    				                WHERE (orders.created_on BETWEEN '$day_before_yyday 00:00:00' AND '$current_date $today_time') 
    				                AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND cat_result.category='$cat' AND orders.order_type_id != '6'"; 
    			    }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    			        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    			                    JOIN `publications` ON publications.id = orders.publication_id
                        			JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    			                    JOIN cat_result ON cat_result.order_no = orders.id
    				                WHERE (orders.created_on BETWEEN '$day_before_yyday 00:00:00' AND '$current_date $tomo_time') 
    				                AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND cat_result.category='$cat' AND orders.order_type_id != '6'"; 
    			    }
    			}elseif($day == 'Sun'){
    			    if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    			                    JOIN `publications` ON publications.id = orders.publication_id
                        			JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    			                    JOIN cat_result ON cat_result.order_no = orders.id
    				                WHERE (orders.created_on BETWEEN '$day_before_yday 00:00:00' AND '$current_date $today_time') 
    				                AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND cat_result.category='$cat' AND orders.order_type_id != '6'"; 
    			    }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    			        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    			                JOIN `publications` ON publications.id = orders.publication_id
                        		JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    			                JOIN cat_result ON cat_result.order_no = orders.id
    				                WHERE (orders.created_on BETWEEN '$day_before_yday 00:00:00' AND '$current_date $tomo_time') 
    				                AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' AND cat_result.category='$cat' AND orders.order_type_id != '6'"; 
    			    }   
    			}else{
        			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
        				$q = "SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
        				                JOIN `publications` ON publications.id = orders.publication_id
                        				JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
        								JOIN cat_result ON cat_result.order_no = orders.id
        									WHERE orders.pdf = 'none' AND (orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') 
        									AND orders.crequest!='1' AND orders.cancel!='1' AND cat_result.category='$cat' AND orders.order_type_id != '6'";
        							
        			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        				$q = "SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders` 
        				                JOIN `publications` ON publications.id = orders.publication_id
                        				JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
        								JOIN cat_result ON cat_result.order_no = orders.id
        									WHERE orders.pdf = 'none' AND (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') 
        									AND orders.crequest!='1' AND orders.cancel!='1' 
        									AND cat_result.category='$cat' AND orders.order_type_id != '6'";
        			}
    			}
    			$data['cat_orders'] = $this->db->query("$q")->result_array();
    						
    		}else{
    			if($day == 'Mon'){
    				$data['dbyst_all_orders'] = $this->db->query("SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    				                                                JOIN `publications` ON publications.id = orders.publication_id
                        					                        JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                                                WHERE orders.created_on LIKE '$day_before_yyday%' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//Monday
    			}
    			if($day == 'Mon' || $day == 'Sun'){
    				$data['dbyyst_all_orders'] = $this->db->query("SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    				                                                JOIN `publications` ON publications.id = orders.publication_id
                        					                        JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                                                WHERE orders.created_on LIKE '$day_before_yday%' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();// Monday OR Sunday
    			}
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    				$data['all_orders'] = $this->db->query("SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    				                                            JOIN `publications` ON publications.id = orders.publication_id
                        				                    	JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                                            WHERE (orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    				$data['all_orders'] = $this->db->query("SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders`
    				                                        JOIN `publications` ON publications.id = orders.publication_id
                        					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                                        WHERE (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
    			}
    		}
		
	    }
		$this->load->view('new_admin/todays_ad_details', $data);
	}
	
	public function yesterdays_ad_details($status = '', $cat='')
	{
	    if(isset($_GET['from']) && isset($_GET['to'])){
	        $from = $_GET['from'];
	        $to = $_GET['to'];
	        $q = "SELECT orders.id, orders.group_id, orders.help_desk, orders.status, orders.publication_id, orders.created_on, time_zone.priority AS time_zone_priority FROM `orders` 
	                        JOIN `publications` ON publications.id = orders.publication_id
                        		JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                            WHERE (orders.created_on BETWEEN '$from' AND '$to') 
				                            AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6'";
			if($status == 'pending'){
			    $q .= " AND (orders.status BETWEEN '1' AND '4')";
			}elseif($status == 'sent'){
			    $q .= " AND (orders.status BETWEEN '5' AND '7')";
			}	                            
	        $data['all_orders'] = $this->db->query("$q;")->result_array();//All
	        $this->load->view('new_admin/yesterdays_ad_details', $data);
	    }
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
			$data['dbyst_all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                JOIN `publications` ON publications.id = orders.publication_id
                        				    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                WHERE (orders.status BETWEEN '1' AND '4') AND orders.created_on LIKE '$day_before_yyday%' 
			                                AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                JOIN `publications` ON publications.id = orders.publication_id
                        				    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                                			WHERE (orders.status BETWEEN '1' AND '4') AND orders.created_on LIKE '$day_before_yday%' 
                                			AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                        WHERE (orders.status BETWEEN '1' AND '4') AND orders.created_on BETWEEN '$ysterday $ystday_time' 
			                                        AND '$current_date $today_time' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                        WHERE (orders.status BETWEEN '1' AND '4') AND orders.created_on BETWEEN '$current_date $today_time' 
			                                        AND '$tomo $tomo_time' AND orders.crequest != '1' AND orders.cancel !='1' AND orders.order_type_id != '6';")->result_array();//All
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
			$data['dbyst_all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                                WHERE (orders.status BETWEEN '5' AND '7') AND orders.created_on LIKE '$day_before_yyday%' 
			                                                AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id 
			                                                WHERE (orders.status BETWEEN '5' AND '7') AND orders.created_on LIKE '$day_before_yday%' 
			                                                AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id 
			                                        WHERE (orders.status BETWEEN '5' AND '7') AND orders.created_on BETWEEN '$ysterday $ystday_time' 
			                                        AND '$current_date $today_time' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id 
			                                        WHERE (orders.status BETWEEN '5' AND '7') AND  orders.created_on BETWEEN '$current_date $today_time'
			                                        AND '$tomo $tomo_time' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
		}
		$this->load->view('new_admin/sent_status',$data);
	}
	
	public function question_status()
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
			$data['dbyst_all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                                WHERE orders.created_on LIKE '$day_before_yyday%' 
			                                                AND orders.question = '1' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//Monday
		}
		if($day == 'Mon' || $day == 'Sun'){
			$data['dbyyst_all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id 
			                                                WHERE orders.created_on LIKE '$day_before_yday%' 
			                                                AND orders.question = '1' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();// Monday OR Sunday
		}
		if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			$data['all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id 
			                                        WHERE orders.question = '1' AND orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time' 
			                                        AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
		}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
			$data['all_orders'] = $this->db->query("SELECT orders.*, time_zone.priority AS time_zone_priority FROM `orders`
			                                        JOIN `publications` ON publications.id = orders.publication_id
                        				            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id 
			                                        WHERE orders.question = '1' AND  orders.created_on BETWEEN '$current_date $today_time'
			                                        AND '$tomo $tomo_time' AND orders.crequest != '1' AND orders.cancel != '1' AND orders.order_type_id != '6';")->result_array();//All
		}
		$this->load->view('new_admin/question_status',$data);
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
			$data['dbyst_all_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `help_desk` = '".$id."' AND `created_on` LIKE '$day_before_yyday%' AND `crequest`!='1' AND `cancel`!='1' ;")->result_array();//Monday
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
							    'advertising_director_email_id' => $_POST['advertising_director_email_id'],
							    'club_id' => $_POST['club']
					       );
						$this->db->insert('publications',$pub_insert);	
						$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Publication has been created successfully");
				redirect('new_admin/home/sales_manage');
			}else{
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
						  'ordering_system' => $_POST['ordering_system'],
						  'idml' => $_POST['idml'],
						  'club_id' => $_POST['club'],
						  'pdf_review' => $_POST['pdf_review'],
						  'time_zone_id' => $_POST['time_zone'],
						  'is_mood_board_enable' => $_POST['is_mood_board_enable']
					);
					$this->db->where('id',$id);	
					$this->db->update('publications', $data);
					$pub_status = $this->db->affected_rows();
					if($pub_status){
						//if publication is inactive - then all adreps associated with that should be updated to inactive
							if($_POST['is_active']=='0'){
							    $adrep_actives = $this->db->query("UPDATE `adreps` SET `is_active` = '0' WHERE `publication_id` = '$id'");
							}elseif($_POST['is_active']=='1'){
								$adrep_actives = $this->db->query("UPDATE `adreps` SET `is_active` = '1' WHERE `publication_id` = '$id'");
							}
							/*if(isset($adrep_actives[0]['id'])){
								foreach($adrep_actives as $adrep_active){
									$post = array('is_active' => $_POST['is_active']);
									$this->db->where('id',$adrep_active['id']);	
									$this->db->update('adreps', $post);
								}
							}*/
						$this->session->set_flashdata("message"," Publication Details Updated successfully!");
						redirect('new_admin/home/publication/'.$id);
					}else{
					    $e = $this->db->error();
					    $this->session->set_flashdata("message",$e['message']);
						redirect('new_admin/home/publication/'.$id);
					}
		}
		$data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		$data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1' ORDER BY `name`")->result_array();
		$data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		$data['slug_type'] = $this->db->query(" SELECT * FROM `cat_slug_type` ORDER BY `name`")->result_array();
		$data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		$data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$id'  ORDER BY `name`")->result_array();
		$data['ord_sys_internal'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '1' AND `is_active` = '1'")->num_rows();
		$data['ord_sys_external'] = $this->db->query("SELECT * FROM `publications` WHERE `ordering_system` = '2' AND `is_active` = '1'")->num_rows();
		$data['in_adreps_count'] = $this->db->query("SELECT * FROM adreps
												left outer join publications on publications.id = adreps.publication_id
												WHERE publications.ordering_system='1' AND adreps.is_active='1'")->num_rows();
		$data['ext_adreps_count'] = $this->db->query("SELECT * FROM adreps
												left outer join publications on publications.id = adreps.publication_id
												WHERE publications.ordering_system='2' AND adreps.is_active='1'")->num_rows();										
		$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'")->result_array();
		$data['club'] = $this->db->query("SELECT `id`,`name` FROM `club` ORDER BY `name` ASC")->result_array();
		$data['time_zone'] = $this->db->query("SELECT * FROM `time_zone`")->result_array();
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
                $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
			$chk_dup = $this->db->query("SELECT `id` FROM `adreps` WHERE `email_id` = '".$_POST['email_id']."'")->num_rows();
			if($chk_dup == 0){
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
    			    $e = $this->db->error();
    				$this->session->set_flashdata("message",$e['message']);
    				redirect('new_admin/home/publication/'.$pId);
    			}    
			}else{
			    $this->session->set_flashdata("message","Account with email id - ".$_POST['email_id']." already exist..");
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
                $data = array( 'password' => $pwd, 'pwd_date' => date('Y-m-d') );
                $this->db->where('id', $id);
                $this->db->update('designers', $data);
                $status = $this->db->affected_rows();
                if($status > 0){
                    $this->session->set_flashdata("message","Password updated successfully!");
                    redirect('new_admin/home/designer_profile/'.$id);
                }else{
                    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/designer_profile/'.$id);
				}
            }
			
			if(isset($_POST['Save'])){
				if(isset($_POST['category_level'])){
				    $cl = implode(",", $_POST['category_level']);
    				$cl_data = array('category_level'=> $cl);
    				$this->db->where('id', $id);    
					$this->db->update('designers', $cl_data);
    			}
    			
    			if(isset($_POST['adwit_teams_id'])){
				   	$team_data = array('adwit_teams_id'=> $_POST['adwit_teams_id'], 'isEnabled_adwit_teams'=> $_POST['isEnabled_adwit_teams']);
    				$this->db->where('id', $id);    
					$this->db->update('designers', $team_data);
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
                    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/designer_profile/'.$id);
                }
            }
            
            if(isset($_POST['tl_category_submit'])){
                $teamlead_volume_new = $this->db->query("SELECT * FROM `teamlead_volume_new` WHERE `designer_id` = '$id';")->row_array();
                $result = implode (",", $_POST['tl_category_level'] );
    			$tl_data = array('category'=> $result, 'designer_id' => $id);
                if(isset($teamlead_volume_new['id'])){
                    $this->db->where('id', $teamlead_volume_new['id']);    
					$this->db->update('teamlead_volume_new', $tl_data);    
                }else{
                    $this->db->insert('teamlead_volume_new', $tl_data);    
                }
            }
            
            $data['id'] = $id;
            $design_list = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$id'")->result_array();
            if($design_list[0]['pub_id'] != null){
    			$pub_id = $design_list[0]['pub_id'];
    			$data['pub_assign'] = $this->db->query("SELECT `name` FROM `publications` WHERE `id` IN (".$pub_id.")")->result_array();
    		}
    		if($design_list[0]['club_id'] != null){
    			$club_id = $design_list[0]['club_id'];
    			$data['club_assign'] = $this->db->query("SELECT `name` FROM `club` WHERE `id` IN (".$club_id.")")->result_array();
    		}
            $data['location'] = $this->db->query("SELECT * FROM `location` ORDER BY `name` ")->result_array();
            $data['d_role'] = $this->db->query("SELECT * FROM `designer_role` ORDER BY `name`")->result_array();
            $data['d_level'] = $this->db->query("SELECT * FROM `designer_level` ORDER BY `name`")->result_array();
            $order_count = $this->db->query("SELECT * FROM `cat_result` WHERE `designer` = '$id' ")->num_rows();    
             $data['category_level'] = $this->db->query("SELECT * FROM `category_level`")->result_array();
             $data['adwit_teams'] = $this->db->query("SELECT * FROM `adwit_teams`")->result_array();
            $data['order_count'] = $order_count;
            $data['design_list'] = $design_list;
            $data['designers_list'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `is_active`='1' ORDER BY `name` ASC")->result_array();
            $data['teamlead_volume_new'] = $this->db->query("SELECT * FROM `teamlead_volume_new` WHERE `designer_id` = '$id';")->row_array();
            $this->load->view('new_admin/designer_profile', $data);
        }
    }
	
	public function csr_profile($id = '')
	{
		if($id!='')
		{
			if(isset($_POST['pwd_submit']) && !empty($_POST['newpassword'])){
				$pwd = MD5($_POST['newpassword']);
				$data = array( 'password' => $pwd, 'pwd_date' => date('Y-m-d') );
				$this->db->where('id', $id);
				$this->db->update('csr', $data);
				$status = $this->db->affected_rows();
				if($status){
					$this->session->set_flashdata("message","Password updated successfully!");
					redirect('new_admin/home/csr_profile/'.$id);
				}else{
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/csr_profile/'.$id);
				}
			}
			
			if(isset($_POST['alias']) && isset($_POST['mobile_no']) && isset($_POST['Join_location'])){
			   $cl = implode(",", $_POST['category_level']);
				$data = array('mobile_no' => $_POST['mobile_no'],
						  'alias' => $_POST['alias'],
						  'gender' => $_POST['gender'],
						  'Join_location' => $_POST['Join_location'],
						  'Work_location' => $_POST['Work_location'],
						  'shift_factor' => $_POST['shift_factor'],
						  'web_ad' => $_POST['web_ad'],
						  'csr_role' => $_POST['csr_role'],
						  'saral_id' => $_POST['saral_id'],
						  'category_level' => $cl,
						  'is_active' => $_POST['is_active'],
						  'pdf_review_tool' => $_POST['pdf_review_tool']
						);
						$this->db->where('id',$id);	
						$this->db->update('csr', $data);
						$csr_status = $this->db->affected_rows();
				if($csr_status){
					$this->session->set_flashdata("message"," Details Updated successfully!");
					redirect('new_admin/home/csr_profile/'.$id);
				}else{
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/csr_profile/'.$id);
				}
			}
			
			$data['id'] = $id;
			$csr_list = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$id' ORDER BY `name`")->result_array();
			if($csr_list[0]['pub_id'] != null){
    			$pub_id = $csr_list[0]['pub_id'];
    			$data['pub_assign'] = $this->db->query("SELECT `name` FROM `publications` WHERE `id` IN (".$pub_id.")")->result_array();
    		}
    		if($csr_list[0]['club_id'] != null){
    			$club_id = $csr_list[0]['club_id'];
    			$data['club_assign'] = $this->db->query("SELECT `name` FROM `club` WHERE `id` IN (".$club_id.")")->result_array();
    		}
			$data['csr_list'] = $csr_list;
			$data['location'] = $this->db->query("SELECT * FROM `location` ORDER BY `name`")->result_array();
			$data['c_role'] = $this->db->query("SELECT * FROM `csr_role` ORDER BY `name`")->result_array();
			$data['category_level'] = $this->db->query("SELECT * FROM `category_level`")->result_array();
			$data['csrs_list'] = $this->db->query("SELECT `id`, `name`, `username` FROM `csr` WHERE `is_active`='1' ORDER BY `name` ASC")->result_array();
			$order_count = $this->db->query("SELECT * FROM `orders` WHERE `csr` = '$id'")->num_rows();	
			
			$data['order_count'] = $order_count;
			$this->load->view('new_admin/csr_profile', $data);
		}
	}
	
	public function adrep_profile($id = '')
	{
		if($id!=''){
			if(isset($_POST['pwd_submit']) && !empty($_POST['newpassword'])){
			    $pwd = MD5(trim($_POST['newpassword']));
				$dataa = array( 'password' => $pwd );
				$this->db->where('id', $id);
				$this->db->update('adreps', $dataa);
				$status = $this->db->affected_rows();
				if($status > 0){
					$this->session->set_flashdata("message","Password updated successfully!");
					redirect('new_admin/home/adrep_profile/'.$id);
				}else{
				    $e = $this->db->error(); // Gets the last error that has occured
                    $mess = $e['message'];

					$this->session->set_flashdata("message",$mess);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
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
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/adrep_profile/'.$id);
				}
			}
			
			if(isset($_POST['phone_1']) && isset($_POST['mobile_no']) && isset($_POST['email_cc'])){
			    $email_cc = preg_replace('/\s+/', '', $_POST['email_cc']);
			    
			    $data = array('phone_1' => $_POST['phone_1'],
						  'mobile_no' => $_POST['mobile_no'],
						  'email_cc' => $email_cc,
						  'gender' => $_POST['gender'],
						  'display_orders' => $_POST['display_orders'],
						  'new_ui' => $_POST['new_ui'],
						  'team_orders' => $_POST['team_orders'],
						  'rush' => $_POST['rush'],
						  'template' => $_POST['template'],
						  'is_active' => $_POST['is_active'],
						  'print_ad' => $_POST['print_ad'],
						  'online_ad' => $_POST['online_ad'],
						  'pagedesign_ad' => $_POST['pagedesign_ad'],
						  'premium' => $_POST['premium'],
						  'color_code' => $_POST['color_code'],
						);
						$this->db->where('id',$id);	
						$this->db->update('adreps', $data);
						$adrep_status = $this->db->affected_rows();
			    if($adrep_status > 0){
					$this->session->set_flashdata("message"," Details Updated successfully!");
					redirect('new_admin/home/adrep_profile/'.$id);
				}else{
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/adrep_profile/'.$id);
				}
			}
			
			if(isset($_POST['migrate_to_adrep']) && !empty($_POST['migrate_to_adrep'])){
				$from = $id;
				$to = $_POST['migrate_to_adrep'];
				$this->db->query("UPDATE `orders` SET `adrep_id`='$to', `oldadrep_id`='$from' WHERE `adrep_id`='$from'");
				if($this->db->affected_rows()){
					$this->session->set_flashdata('message','<label style="color:red">'.$this->db->affected_rows().' Orders Moved..!!</label>');
				}
				redirect('new_admin/home/adrep_profile/'.$id);
			}
			
			$data['migrate_adrep_list'] = $this->db->query("SELECT id, first_name, last_name FROM `adreps` WHERE `id` != '".$id."' AND `is_active` = '1' ORDER BY first_name ASC")->result_array();
			
			$data['id'] = $id;
			$data['adreps_list'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id'")->result_array();
			
			$adrep_details = $this->db->get_where('adreps',array('id'=> $id))->result_array();
			$publication = $this->db->get_where('publications',array('id'=>$adrep_details[0]['publication_id']))->result_array();
			if($adrep_details[0]['team_orders']=='1'){
				$orders_count = $this->db->query("SELECT COUNT(id) AS orderCount FROM `orders` WHERE orders.publication_id = '".$publication[0]['id']."'")->row_array();
			}else{
			    $orders_count = $this->db->query("SELECT COUNT(id) AS orderCount FROM `orders` WHERE orders.adrep_id = '".$id."'")->row_array();
			}
		    $data['orders_count'] = $orders_count['orderCount'];
    		if($publication[0]['enable_source']=='1'){
    			$data['storage_space'] = $this->storage_space($id);
    		}
    		$data['adrep_details'] = $adrep_details;
    		$data['publication'] = $publication;
    		$data['migrate_adrep_list'] = $this->db->query("SELECT id, first_name, last_name FROM `adreps` WHERE `id` != '".$id."' AND `is_active` = '1' AND `publication_id` = '".$publication[0]['id']."' ORDER BY first_name ASC")->result_array();		
    		$data['color_code'] = $this->db->get('color_code')->result_array();
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
					    if(is_array($row)) continue;
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
								  'pwd_date' => date('Y-m-d'),
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
                $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
            $q = "SELECT designers.*, designer_role.name AS drole FROM `designers` 
                                                        JOIN `designer_role` ON designer_role.id = designers.designer_role";
            if(isset($_POST['active']) && isset($_POST['in_active'])){
                $data['status'] = 'all';
                $data['designer'] = $this->db->query("$q")->result_array(); 
            }elseif(isset($_POST['in_active'])){
                $data['status'] = 'in_active';
                $q .= " WHERE `is_active` = '0'";
                $data['designer'] = $this->db->query("$q")->result_array(); 
            }else{
                $data['status'] = 'active';
                $q .= " WHERE `is_active` = '1'";
                $data['designer'] = $this->db->query("$q")->result_array(); 
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
								'pwd_date' => date('Y-m-d'),
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
			/*if(empty($_POST['ftp_server']) || empty($_POST['ftp_username']) ||empty($_POST['ftp_password']) ||empty($_POST['ftp_url'])){
				$this->session->set_flashdata("message","Provide Proper FTP Values");
				redirect('new_admin/home/production_manage');
			}*/
			$hd_insert = array( 'name' => $_POST['name'] );
				$this->db->insert('help_desk',$hd_insert);	
				$inserted_id= $this->db->insert_id();
			if($inserted_id){
				$this->session->set_flashdata("message","Helpdesk has been created successfully");
				redirect('new_admin/home/production_manage');
			}else{
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
					    $e = $this->db->error();
					    $this->session->set_flashdata("message",$e['message']);
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
					    $e = $this->db->error();
					    $this->session->set_flashdata("message",$e['message']);
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
				redirect('new_admin/home/manage');
			}
		} 
		$data['adwit_users'] = $this->db->query("SELECT * FROM `adwit_users` ORDER BY `name`")->result_array();
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
					    $e = $this->db->error();
					    $this->session->set_flashdata("message",$e['message']);
						redirect('new_admin/home/notification_list');
					}
				}else{
					$this->session->set_flashdata("message","No Data Found for ID : $id ..!!");
					redirect('new_admin/home/notification_list');
				}	
			}
		$notification= $this->db->get_where('notification',array('id'=>$id))->result_array();
		$data['row'] = $notification[0];
		$data['adwit_users'] = $this->db->query("SELECT * FROM `adwit_users` ORDER BY `name`")->result_array();
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
				redirect('new_admin/home/manage');
			}	
	   }
	   $adrep = $this->db->query("select * from `adreps` where `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
	   $publication = $this->db->query("select * from `publications` where `is_active` = '1' ORDER BY `name`")->result_array();
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
        if(isset($_GET['id']) && !empty($_GET['id'])){
            
            $order_id = $_GET['id'];
            $data['order_id'] = $order_id;
            $orders = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$order_id'")->result_array();
            $data['orders']= $orders;
            
            $data['rev_order_id'] = $order_id;
            if(isset($orders[0]['id'])){
                $data['rev_sold_jobs'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '".$order_id."'")->result_array();
            }
        }
        /*
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
        */
        $data['rev_order_status'] = $this->db->query("SELECT * FROM `rev_order_status`")->result_array();
        $data['order_status'] = $this->db->query("SELECT * FROM `order_status`")->result_array();
        
        
        $this->load->view('new_admin/order_rev_status', $data);    
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
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
				$e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
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
				$orders = $this->db->query("SELECT orders.*, publications.name AS publication_name, adreps.first_name, adreps.last_name, orders_type.name, orders_type.value  FROM `orders`
				                            JOIN `publications` ON publications.id = orders.publication_id
				                            JOIN `adreps` ON adreps.id = orders.adrep_id
				                            JOIN `orders_type` ON orders_type.id = orders.order_type_id
				                            WHERE orders.adrep_id = '$id' AND (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none') 
				                            ORDER BY orders.id ASC")->result_array();
			    
			}else{
				$orders = $this->db->query("SELECT orders.*, publications.name AS publication_name, adreps.first_name, adreps.last_name, orders_type.name, orders_type.value  FROM `orders`
				                            JOIN `publications` ON publications.id = orders.publication_id
				                            JOIN `adreps` ON adreps.id = orders.adrep_id
				                            JOIN `orders_type` ON orders_type.id = orders.order_type_id
				                            WHERE orders.order_type_id = '$order_type' AND orders.adrep_id = '$id' AND (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') 
				                                AND (orders.pdf != 'none') ORDER BY orders.id ASC")->result_array();
			}
			$data['orders'] = $orders;
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '$id'")->result_array();
        }
		
        if($user == 'publications'){
			if($order_type == '0'){ //all
			    $q = "SELECT * FROM `orders` WHERE `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')";
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}else{
			    $q = "SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')";
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `order_type_id` = '$order_type' AND `publication_id` = '$id' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
			}
			//echo $q;
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
	
	public function order_form($id)
	{
		$order_details = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$id' ")->result_array();
		if(isset($order_details[0]['id'])){
			$data['order'] = $order_details;
			$data['client'] = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->row_array();
			$data['publications'] = $this->db->get_where('publications',array('id' => $order_details[0]['publication_id']))->row_array();
			$this->load->view('new_admin/order_form',$data);
		}
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
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1' ORDER BY `first_name`,`last_name`")->result_array();
		}
		if($user == 'web_ads'){
			$data['web_ads'] = 'web_ads';
		}
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		}
		if($user == 'groups'){
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		}
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		}
		if($user == 'pcsr'){
			$data['pcsr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1' ORDER BY `name`")->result_array();
		}
		if($user == 'tl_qa'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1' ORDER BY `name`")->result_array();
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
	
	public function report_sales_adrep($type='', $user='', $id='', $date='', $order_type='all')
	{
		$adrep_id = $id; 
		$data['adrep_id'] = $adrep_id; 
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		if(isset($_GET['order_type'])){  $data['order_type'] = $_GET['order_type']; }else{ $data['order_type'] = $order_type; }
		if(isset($_GET['date'])){  $date = $_GET['date']; }
		$data['custom'] = date('Y-m-d');
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}elseif($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}
		if($date == 'custom' || (isset($_GET['from']) && !empty($_GET['from']))){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		
		$data['from'] = $from;
		$data['to'] = $to;
		
		$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$adrep_id."'")->result_array();
		
		$this->load->view('new_admin/report_sales_adrep',$data);
	}
	
	public function report_sales_publication($type='', $user='', $id='', $date='')
	{
		$publication_id = $id; 
		$data['publication_id'] = $publication_id; 
		$data['type'] = $type;
		$data['user'] = $user;
		$data['date'] = $date;
		$data['custom'] = date('Y-m-d');
		
		if($date == 'custom' || isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}elseif($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}elseif($date == 'one_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'two_week'){
				$from = date('Y-m-d', strtotime("-2 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}else{
		        $data['date'] = 'today';
		        $from = date('Y-m-d');
				$to =  date('Y-m-d');
		}
		//echo 'date:'.$date.'From : '.$from.'To : '.$to;
		
		if(!isset($_GET['order_type'])){ $data['order_type'] = '0'; }else{ $data['order_type'] = $_GET['order_type']; }
		
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
		
		if($order_type == 'all'){
			$query = "SELECT `id`, `created_on`, `pdf_timestamp` FROM `orders` WHERE `group_id` = '".$group_id."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')";
		}else{
			$query = "SELECT `id`, `created_on`, `pdf_timestamp` FROM `orders` WHERE `order_type_id` = '$order_type' AND `group_id` = '".$group_id."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')";
		}
		//echo $query;
		$data['orders'] = $this->db->query("$query")->result_array();
		
		$data['groups'] = $this->db->query("SELECT `id`, `name` FROM `Group` WHERE `id` = '".$group_id."' ")->row_array();
		$data['publication'] = $this->db->query("SELECT `id` FROM `publications` WHERE `group_id` = '".$group_id."' AND `is_active` = '1'")->num_rows();
		
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
		$order_query = "SELECT `id` FROM `orders` WHERE `order_type_id` = '$order_type' AND `group_id` = '".$group_id."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')";
		
		$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.category FROM `cat_result`
						WHERE cat_result.order_no IN ($order_query) GROUP BY cat_result.category";
		/*$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.category FROM `orders` 
		LEFT JOIN `cat_result` ON orders.id = cat_result.order_no
		WHERE orders.group_id = '".$group_id."' AND orders.order_type_id = '$order_type' AND (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none') GROUP BY cat_result.category";*/
		//echo $query;
		$data['orders'] = $this->db->query("$query")->result_array();
		
		$data['groups'] = $this->db->query("SELECT `id`,`name` FROM `Group` WHERE `id` = '".$group_id."' ")->result_array();
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
		$data['groups'] = $this->db->query("SELECT `id`, `name` FROM `Group` WHERE `id` = '".$group_id."' ")->result_array();
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
        //$DB2 = $this->load->database('otherdb', TRUE);
        $DB2 = $this->db ;
        $designer_id = $_GET['designer_id'];
        $data['designer_id'] = $designer_id;
        $data['type'] = $type;
        $data['user'] = $user;
        
        if($designer_id == 'all'){ 
            $data['designers'] = $DB2->query("SELECT `id`, `name`, `username`,`level` FROM `designers` WHERE `is_active` = '1'")->result_array();
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
        }else{
            $data['designers'] = $DB2->query("SELECT `id`, `name`, `username`,`level` FROM `designers` WHERE `id` = '".$_GET['designer_id']."'")->result_array();
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
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$publication_id' AND `is_active` = '1'")->result_array();
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
			$data['adreps'] = $this->db->query("SELECT * FROM `adreps` WHERE `publication_id` = '$publication_id'  AND `is_active` = '1' ")->result_array();
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
			$orders = $this->db->query("SELECT * FROM `orders` 
			                            WHERE `pdf` != 'none' AND `spec_sold_ad` = '0' 
			                            AND (`id` LIKE '%$id%' OR `job_no` LIKE '%$id%' OR `advertiser_name` LIKE '%$id%' OR `copy_content_description` LIKE '%$id%' OR `notes` LIKE '%$id%') 
		                            	ORDER BY `id` DESC LIMIT $offset, $rowsPerPage")->result_array();
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
				redirect('new_admin/home/order_review_history/'.$order_id);
		}
		
		// Error Type Update
		if(isset($_POST['submit_error'])){
			$rev_id = $_POST['rev_id'];
			//echo "<script>alert($rev_id)</script>";
			 $complaint_data = array('complaint_type'=> $_POST['complaint']);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $complaint_data); 
				redirect('new_admin/home/order_review_history/'.$order_id);
			}
			
		//Complaint Update
		if(isset($_POST['submit_complaint'])){
			$c_complaint_id = $_POST['c_complaint'];
			$rev_id = $_POST['rev_id'];
			//echo "<script>alert($rev_id)</script>";
			 $c_post1 = array('c_complaint' => $c_complaint_id);
				$this->db->where('id', $rev_id);
				$this->db->update('rev_sold_jobs', $c_post1); 
				redirect('new_admin/home/order_review_history/'.$order_id);
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
        $data['team_lead'] = $this->db->query("SELECT * FROM `team_lead` where `is_active` = '1' ")->result_array();
        $data['designers_list'] = $this->db->query("SELECT * FROM `designers` where `is_active` = '1' ORDER BY `name`")->result_array();
        $data['location'] = $this->db->query("SELECT * FROM `location` ORDER BY `name`")->result_array();
        $data['ordering_system'] = $this->db->query("SELECT * FROM `ordering_system`")->result_array();
        $data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
        $data['publications_list'] = $this->db->query("SELECT * FROM `publications` where `is_active` = '1' ORDER BY `name`")->result_array();
        $data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
        $data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
        $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
        $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
        $data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1' ORDER BY `name`")->result_array();
        $data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
        $data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
        $data['template'] = $this->db->query("SELECT `id` FROM `orders` WHERE `spec_sold_ad` = '0' AND `order_type_id` = '2' AND pdf!='none'")->num_rows();
        $data['designer_role'] = $this->db->query("SELECT * FROM `designer_role`  ORDER BY `name`")->result_array();
        $data['csr_role'] = $this->db->query("SELECT * FROM `csr_role`  ORDER BY `name`")->result_array();
        $data['designer_level'] = $this->db->query("SELECT * FROM `designer_level`  ORDER BY `name`")->result_array();
        
        $aid = $this->session->userdata('aId');
        $data['admin_users'] = $this->db->query("SELECT * FROM `admin_users` WHERE `id` = '$aid' ")->result_array();
        $data['club'] = $this->db->query("SELECT `id`,`name` FROM `club` ORDER BY `name` ASC")->result_array();
		$this->load->view('new_admin/sales_manage', $data);
	}
	
	public function production_manage()
	{
		$data['business_groups'] = $this->db->query("SELECT * FROM `business_groups` ")->result_array();
        $data['team_lead'] = $this->db->query("SELECT * FROM `team_lead` where `is_active` = '1'")->result_array();
        $data['designers_list'] = $this->db->query("SELECT * FROM `designers` where `is_active` = '1'")->result_array();
        $data['location'] = $this->db->query("SELECT * FROM `location`  ORDER BY `name` ")->result_array();
        $data['ordering_system'] = $this->db->query("SELECT * FROM `ordering_system`")->result_array();
        $data['channels'] = $this->db->query("SELECT * FROM `channels` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['publications_list'] = $this->db->query("SELECT * FROM `publications` where `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['group'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['publication'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['helpdesk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1' ORDER BY `name`")->result_array();
        $data['design_team'] = $this->db->query("SELECT * FROM `design_teams` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
        $data['slug_type'] = $this->db->get('cat_slug_type')->result_array();
        $data['template'] = $this->db->query("SELECT `id` FROM `orders` WHERE `spec_sold_ad` = '0' AND `order_type_id` = '2' AND pdf!='none'")->num_rows();
        $data['designer_role'] = $this->db->query("SELECT * FROM `designer_role`  ORDER BY `name`")->result_array();
        $data['csr_role'] = $this->db->query("SELECT * FROM `csr_role`  ORDER BY `name`")->result_array();
        $data['designer_level'] = $this->db->query("SELECT * FROM `designer_level`  ORDER BY `name`")->result_array();
        $data['club'] = $this->db->query("SELECT * FROM `club`  ORDER BY `name`")->result_array();
        
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
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `is_active` = '1'  ORDER BY `first_name`,`last_name`")->result_array();
		}
		if($user == 'web_ads'){
			$data['web_ads'] = 'web_ads';
		}
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		if($user == 'groups'){
			$data['groups'] = $this->db->query("SELECT * FROM `Group` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		if($user == 'pcsr'){
			$data['pcsr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'  ORDER BY `name`")->result_array();
		}
		if($user == 'tl_qa'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'  ORDER BY `name`")->result_array();
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
		if($pub_id == 'all'){
			$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.category FROM `cat_result` 
						LEFT JOIN `orders` ON cat_result.order_no = orders.id
							WHERE (cat_result.date BETWEEN '$from' AND '$to') AND (orders.pdf != 'none' AND orders.order_type_id = '$order_type') GROUP BY cat_result.category"; 
		}else{
			$query = "SELECT COUNT(cat_result.id) AS cat_count, cat_result.category FROM `cat_result` 
						LEFT JOIN `orders` ON cat_result.order_no = orders.id
							WHERE cat_result.publication_id = '$pub_id' AND (cat_result.date BETWEEN '$from' AND '$to') AND (orders.pdf != 'none' AND orders.order_type_id = '$order_type') GROUP BY cat_result.category";
		 }
		//echo $query;
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
	
	public function customer_instruction($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		if($user == 'publications'){
			$data['publications'] = $this->db->query("SELECT * FROM `publications` WHERE `is_active` = '1'")->result_array();
		}
		
		$this->load->view('new_admin/customer_instruction',$data);
	}
	
	public function customer_instruct_report($type="",$user="")
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
		
		$this->load->view('new_admin/customer_instruct_report',$data);
	}
	public function revision_verification($type="",$date="")
	{
		$data['type'] = $type;
		$data['date'] = $date;
	
		$this->load->view('new_admin/revision_verification',$data);
	}
	
    public function revision_verify_report($type="",$date="")
	{
		//var_dump($date);die;
		
		$data['type'] = $type;
		$data['date'] = $date;
		
		if($date == 'yesterday'){
				$from = date('Y-m-d', strtotime("-1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}elseif($date == 'custom' && isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
				$data['custom'] = date('Y-m-d');
		}
		$data['from'] = $from;
		$data['to'] = $to;

		$query= "SELECT rev_sold_jobs.id as rev_id, rev_sold_jobs.order_id, rev_sold_jobs.note as rev_note,rev_sold_jobs.version,rev_sold_jobs.verify,
		                rev_sold_jobs.help_desk, 
		                cat_result.category AS cat_result_category, cat_result.designer AS cat_result_designer, cat_result.version AS cat_result_version,
		                publications.name AS publicationName
		                FROM `rev_sold_jobs` 
		                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
		                JOIN `publications` ON publications.id = cat_result.publication_id
		                WHERE  rev_sold_jobs.version !='' AND `verify` != '2' AND `verify` != '3' AND (rev_sold_jobs.date BETWEEN '$from 00:00:00' AND '$to 23:59:59') 
		                ORDER BY rev_sold_jobs.order_id";
		
		$rev_orders = $this->db->query("$query")->result_array();
	
		if(isset($_POST['submit'])){
			$verify_data = array('verify' => $_POST['verify']);
			$this->db->where('id', $_POST['id']);
			$this->db->update('rev_sold_jobs', $verify_data);
			
			if($_POST['verify'] == '1'){
				$this->session->set_flashdata('message','Verifying Adwitads ID: '.$_POST['order_id']);
				redirect('new_admin/home/revision_verify_type/'.$type.'/'.$_POST['id'].'/'.$date.'?from='.$from.'&to='.$to.'');
			}else{
				$this->session->set_flashdata('message','Ignored!! Adwitads ID: '.$_POST['id']);
				redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');
			}
		}
		$data['rev_orders'] = $rev_orders;
		
		$this->load->view('new_admin/revision_verify_report',$data);
	}
	
    public function revision_verify_type($type="",$id="",$date="")
	{
		$data['type'] = $type;
		//$data['date'] = $date;
		$rev_id = $id; 
		$data['rev_id'] = $rev_id; 
		
		if($date == 'yesterday'){
				$from = date('Y-m-d', strtotime("-1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}elseif($date == 'custom' && isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
				$data['custom'] = date('Y-m-d');
		}
		
		// Verification Type
		if(isset($_POST['search']))
		{
			$aId = $this->session->userdata('aId');
			$comment = array( 
							'rev_id' => $_POST['rev_id'], 
							'admin_id' => $aId,
							'designer_id' => $_POST['designer_id'],
							'tl_designer_id' => $_POST['dtl_id'],
							'csr_id' => $_POST['csr_id'],
							'rov_csr_id' => $_POST['rov_csr_id'],
							'hi_b_designer_id' => $_POST['hi_b_designer_id'],
							'comment' => $_POST['comment']
						);
			$this->db->insert('rev_verify_comment', $comment);
			$comment_id = $this->db->insert_id();
			if($comment_id){
					$verify_type = implode(',', $_POST['verification_type']);
					
					$update_post = array( 'verification_type' => $verify_type, 'verify' => '3' );
					
					$this->db->where('id', $_POST['rev_id']);
					$this->db->update('rev_sold_jobs', $update_post);
					
					$this->session->set_flashdata('message','Success!! Adwitads ID: '.$_POST['order_id']);
					//redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');	
			}else{
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
				//redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');
			}
		}
		
		//Ignore
		if(isset($_POST['ignore'])){
			
			$ignore_data = array('verify' => '3');
			$this->db->where('id', $_POST['rev_id']);
			$this->db->update('rev_sold_jobs', $ignore_data);
			$this->session->set_flashdata('message','Ignored!!! Adwitads ID: '.$_POST['id']);
			redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');
		}
		
		$rev_sold_jobs = $this->db->query("SELECT rev_sold_jobs.id as rev_id, rev_sold_jobs.order_id, rev_sold_jobs.designer,rev_sold_jobs.QA_csr , rev_sold_jobs.note,rev_sold_jobs.version,rev_sold_jobs.verify,rev_sold_jobs.verification_type FROM `rev_sold_jobs` WHERE rev_sold_jobs.id = '".$rev_id."' AND rev_sold_jobs.version !='' AND `verify` != '2'")->row_array();
		
		$data['order_id'] = $rev_sold_jobs['order_id'];
		$data['version'] = $rev_sold_jobs['version'];
		$data['note'] = $rev_sold_jobs['note'];
		$data['verify'] = $rev_sold_jobs['verify'];
		
		if(isset($rev_sold_jobs) && $rev_sold_jobs['version'] == 'V1a'){
			
			$cat_result = $this->db->query("SELECT cat_result.id AS cat_id,cat_result.order_no,cat_result.designer ,cat_result.tl_id , cat_result.csr_QA ,cat_result.version, cat_result.publication_id, cat_result.adrep FROM `cat_result` WHERE cat_result.order_no = '".$rev_sold_jobs['order_id']."'")->row_array(); 
			$data['cat_result'] = $cat_result;
			
			$data['publication_name'] = $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `id` = '".$cat_result['publication_id']."'")->row_array();
			
			$data['adrep_name'] =  $this->db->query("SELECT `id`, `first_name`,`last_name` FROM `adreps` WHERE `id` = '".$cat_result['adrep']."'")->row_array();

			$designer_name = $this->db->query("SELECT `id`, `name` FROM `designers` WHERE `id` = '".$cat_result['designer']."' AND `designer_role` = '3'")->row_array();
			$data['designer_name'] = $designer_name;
			
			$data['designer_tl_name'] = $this->db->query("SELECT `id`, `name` FROM `designers` WHERE `id` = '".$cat_result['tl_id']."'")->row_array();
			
			$hi_b_designer_name = $this->db->query("SELECT `id`, `name` FROM `designers` WHERE `id` = '".$cat_result['designer']."' AND `designer_role` = '4'")->row_array();
			$data['hi_b_designer_name'] = $hi_b_designer_name;
			
			$csr_name = $this->db->query("SELECT `id`, `name` FROM `csr` WHERE `id` = '".$cat_result['csr_QA']."'")->row_array();
			$data['csr_name'] = $csr_name ;
			$prev_ver = $cat_result['version'];
 		}else{
			$cur_ver = $rev_sold_jobs['version'];
			$str = substr($cur_ver, -1);
			$str_prev = chr(ord($str)-1);
			$prev_ver = 'V1'.$str_prev;
			//echo $prev_ver;
			$prev_rev_details = $this->db->query("SELECT * FROM `rev_sold_jobs` 
													WHERE rev_sold_jobs.order_id = '".$rev_sold_jobs['order_id']."' AND rev_sold_jobs.version = '$prev_ver'")->row_array();
			$designer_name = $this->db->query("SELECT `id`, `name` FROM `designers` WHERE `id` = '".$prev_rev_details['designer']."'")->row_array();
			$data['designer_name']= $designer_name;
			
			$csr_name = $this->db->query("SELECT `id`, `name` FROM `csr` WHERE `id` = '".$prev_rev_details['QA_csr']."'")->row_array();
			$data['csr_name'] = $csr_name ;
			
			$rov_csr = $this->db->query("SELECT `id`, `name` FROM `csr` WHERE `id` = '".$prev_rev_details['rov_csr']."'")->row_array();
			$data['rov_csr'] = $rov_csr;
			
		}
		$data['prev_ver'] = $prev_ver;
		$data['verification_type'] = $this->db->query("SELECT * FROM `verification_type`")->result_array();
		
		if(isset($_POST['search']))
		{
	        if(isset($_POST['verification_type']) && $_POST['verification_type'][0] == "1" && count($_POST['verification_type']) == "1"){
		        
    			$from_email = 'itsupport@adwitads.com'; 
    			$to_email =  'acharya@adwitglobal.com, jalvares@adwitglobal.com, ashok@adwitglobal.com';
    			
    			$msg =  $this->load->view('new_admin/error_mail',$data,TRUE);
    			
    			//Load email library 
    			
    			$config = Array( 'mailtype' => 'html' );
    			$this->load->library('email', $config);
    			
    			$this->email->from($from_email,'IT Support'); 
    			$this->email->to($to_email);
    			
    			$order_id = 'Complaint : ' . $rev_sold_jobs['order_id'];
				if(isset($designer_name) && isset($designer_name['name'])){
					$des_name = 'D: ' .'('. $designer_name['name'].')';
				}else{
					$des_name='';
				}
				
				if(isset($csr_name) && isset($csr_name['name'])){
					$prf_name = ' '.'PR: ' . '('.$csr_name['name'].')' ;
				}else{
					$prf_name='';
				}
				
				if(isset($rov_csr) && isset($rov_csr['name'])){
					$rov_csr_name = ' '.'RCSR: ' . '('.$rov_csr['name'].')' ;
				}else{
					$rov_csr_name='';
				}
				
				if(isset($hi_b_designer_name) && isset($hi_b_designer_name['name'])){
					$hi_des_name = ' '.'HyD: ' .'('. $hi_b_designer_name['name'].')';
				}else{
					$hi_des_name='';
				}
				
    			$this->email->subject($order_id .' '. $des_name .' '. $prf_name .' '. $rov_csr_name .' '. $hi_des_name );
    			$this->email->message($msg);
    			if($this->email->send()){
    				$this->session->set_flashdata('message','Success!! Adwitads ID: '.$_POST['order_id']);
					redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');	
			    }else{
					$e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');
			    }
	        }
	        redirect('new_admin/home/revision_verify_report/'.$type.'/'.$date.'?from='.$from.'&to='.$to.'');
    	}
		$this->load->view('new_admin/revision_verify_type',$data);
	}  
	
	public function revision_error($type="",$date="", $id="")
	{
		$data['type'] = $type;
		$data['date'] = $date;
		$data['id'] = $id;
		
		$this->load->view('new_admin/revision_error',$data);
	}
	
	public function revision_error_report($type="",$date="")
	{
		$data['type'] = $type;
		$data['date'] = $date;
		
		if($date == 'yesterday'){
				$from = date('Y-m-d', strtotime("-1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}elseif($date == 'custom' && isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
		}
		
		$aId = $this->session->userdata('aId');
		$data['aId'] = $aId;
		
		$query = "SELECT rev_sold_jobs.order_id, rev_verify_comment.*, designers.name as d_name, designers.username as du_name, csr.name as c_name, csr.username as cu_name, tl.name as tl_name, tl.username as tlu_name, 
		rov_csr.name as r_name, hi_b.name as hi_b_name, hi_b.username as hi_b_uname, qa_csr.name as qa_csr_name
		FROM `rev_sold_jobs`
		LEFT JOIN `rev_verify_comment` ON rev_sold_jobs.id = rev_verify_comment.rev_id
		LEFT JOIN `designers` AS tl ON tl.id = rev_verify_comment.tl_designer_id
		LEFT JOIN `designers` ON designers.id = rev_verify_comment.designer_id
		
	    LEFT JOIN `designers` AS hi_b ON hi_b.id = rev_verify_comment.hi_b_designer_id
	    
	    LEFT JOIN `csr` AS rov_csr ON rov_csr.id = rev_verify_comment.rov_csr_id
		LEFT JOIN `csr` ON csr.id = rev_verify_comment.csr_id
		LEFT JOIN `csr` AS qa_csr ON qa_csr.id = rev_sold_jobs.QA_csr
		
		WHERE  rev_sold_jobs.version !='' AND rev_sold_jobs.verify = '3'  AND rev_sold_jobs.verification_type!='0' AND rev_sold_jobs.date BETWEEN '$from 00:00:00' AND '$to 23:59:59' AND rev_verify_comment.error IS NULL ORDER BY  rev_sold_jobs.order_id "; 
		
		//echo $query;
		if(isset($_POST['search']))
		{
			$error_data = array('error' => $_POST['error']);
			$this->db->where('rev_id',$_POST['id']);
			$this->db->update('rev_verify_comment', $error_data);
			$error_status = $this->db->affected_rows();
			
			if($error_status){
				$this->session->set_flashdata("message"," Error Updated Successfully!");
				redirect('new_admin/home/revision_error_report/'.$type.'/'.$id.'/'.$date.'?from='.$from.'&to='.$to.'');
			}else{
				$this->session->set_flashdata("message","Error!!!");
				redirect('new_admin/home/revision_error_report/'.$type.'/'.$id.'/'.$date.'?from='.$from.'&to='.$to.'');
			} 
		}
		$data['rev_orders'] = $this->db->query("$query")->result_array();
			
		$data['from'] = $from;
		$data['to'] = $to;
		
		$this->load->view('new_admin/revision_error_report',$data);
	}
	
	public function revision_error_update()
	{
		if(isset($_POST['comment_id']))
		{
			$error_data = array('error' => $_POST['error']);
			$this->db->where('id', $_POST['comment_id']);
			$this->db->update('rev_verify_comment', $error_data);
			$error_status = $this->db->affected_rows();
			
			if($error_status){
				echo "Status Updated";
			}else{
				echo "No Change in Status";
			} 
		}
	}
	
	public function order_review_history($order_id="")
	{
		
		$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
												FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		if(isset($orders[0]['id']))
		{
			$this->load->helper('directory');
			
			$data['order_id']= $order_id; 
			
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
			//$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_classification`")->result_array();
			$data['cancel_reason'] = $this->db->get('cancel_reason')->result_array();			
			$data['note_csr_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_designer'))->result_array();
			$data['note_csr_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'csr_dc'))->result_array();
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
			$this->load->view('new_admin/order_review_history', $data);			
		}			
	}
	
	public function advocate_w_m_report($date="yesterday")
	{
		$data['date'] = $date;
		if($date == 'yesterday')
		{
			$from = date('Y-m-d', strtotime("-1 day"));
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
		if($date == 'search' || isset($_GET['from'])){
		
				$from = $_GET['from'];
				$to =  $_GET['to'];
				$data['custom'] = date('Y-m-d');
		}
		
		
		/*$query = "SELECT cat_result.id AS cat_id,cat_result.order_no AS cat_order_no,cat_result.designer AS cat_designer,cat_result.tl_designer_id AS cat_tl_designer,cat_result.csr AS cat_csr, rev_sold_jobs.verification_type,rev_sold_jobs.id as rev_id,rev_sold_jobs.order_id,rev_verify_comment.error FROM `cat_result` 
		LEFT JOIN `rev_sold_jobs` ON cat_result.order_no = rev_sold_jobs.order_id 
		LEFT JOIN `rev_verify_comment` ON rev_sold_jobs.id = rev_verify_comment.rev_id
		WHERE  rev_verify_comment.c_timestamp  BETWEEN '$from 00:00:00' AND '$to 23:59:59' ORDER BY rev_sold_jobs.order_id DESC ";*/
		
		$query = "SELECT rev_sold_jobs.order_id,rev_sold_jobs.verification_type,rev_sold_jobs.note, rev_verify_comment.*, designers.name as d_name, designers.username as du_name, csr.name as c_name, csr.username as cu_name, tl.name as tl_name,rov_csr.name as r_name,designers.name as hi_b_name
		FROM `rev_sold_jobs`
		LEFT JOIN `rev_verify_comment` ON rev_sold_jobs.id = rev_verify_comment.rev_id
		LEFT JOIN `designers` AS tl ON tl.id = rev_verify_comment.tl_designer_id
		LEFT JOIN `designers` ON designers.id = rev_verify_comment.designer_id
		
		LEFT JOIN `csr` AS rov_csr ON rov_csr.id = rev_verify_comment.rov_csr_id
		LEFT JOIN `csr` ON csr.id = rev_verify_comment.csr_id
		WHERE rev_verify_comment.timestamp  BETWEEN '$from 00:00:00' AND '$to 23:59:59' ORDER BY rev_sold_jobs.order_id  "; 
		 
		$report = $this->db->query("$query")->result_array();
		
		$data['report'] = $report;
		$data['from'] = $from;
		$data['to'] = $to;
		 //echo $query;
		$this->load->view('new_admin/advocate_w_m_report',$data);
	}
	
	public function admin_report_designer_interval($type="", $user="", $id="")
	{
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		
		
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT `id`,`name` FROM `designers` WHERE `is_active` = '1' ORDER BY `name`")->result_array();
		}
		
		$this->load->view('new_admin/admin_report_designer_interval',$data);
	}
	
	/*public function report_designer_interval($type='', $user='',$id='',$date='')
	{
		$designer_id = $id;
        $data['designer_id'] = $designer_id; 
		
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
		
		//echo 'date '.$date.'To : '.$to.'From : '.$from;
		$data['from'] = $from;
		$data['to'] = $to;
	
        //$query = "SELECT `id`, `name`, `username` FROM `designers` WHERE `id` = '$designer_id'"; 
        
		$data['designers'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `id` = '$designer_id' ORDER BY `name`")->result_array();
		
		$this->load->view('new_admin/report_designer_interval',$data);
	}*/
	
	public function report_designer_interval($type='', $user='',$id='',$date='')
	{
		$designer_id = $id;
        $data['designer_id'] = $designer_id; 
		
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
		
		//echo 'date '.$date.'To : '.$to.'From : '.$from;
		$data['from'] = $from;
		$data['to'] = $to;
	
		$data['designers'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `id` = '$designer_id' ORDER BY `name`")->result_array();
		
		$this->load->view('new_admin/report_designer_interval',$data);
	}
	
	public function report_csr_interval($type='', $user='',$id='',$date='')
	{
		$csr_id = $id;
        $data['csr_id'] = $csr_id; 
		
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
		
		//echo 'date '.$date.'To : '.$to.'From : '.$from;
		$data['from'] = $from;
		$data['to'] = $to;
	
		$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE  `id` = '$csr_id' AND `is_active` = '1'  ORDER BY `name`")->result_array();
			
		$this->load->view('new_admin/report_csr_interval',$data);
	}
	
	public function report_tl_interval($type='', $user='',$id='',$date='')
	{
		$tl_id = $id;
        $data['tl_id'] = $tl_id; 
		
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
		
		//echo 'date '.$date.'To : '.$to.'From : '.$from;
		$data['from'] = $from;
		$data['to'] = $to;
	
		$data['team_lead'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1' AND  `id` = '$tl_id' AND `designer_role` = '2' ORDER BY `name`")->result_array();
			
		
		$this->load->view('new_admin/report_tl_interval',$data);
	}
	
	
	public function interval_verify($type="",$date="")
	{
		$data['type'] = $type;
		$data['date'] = $date;
	
		$this->load->view('new_admin/interval_verify',$data);
	}
	
	public function interval_verify_report($type="",$date=""){
		$data['type'] = $type;
		$data['date'] = $date;
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}elseif($date == 'last_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}elseif($date == 'custom' && isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
				$data['custom'] = date('Y-m-d');
		}
		$data['from'] = $from;
		$data['to'] = $to;

		$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ")->result_array();
		$this->load->view('new_admin/interval_verify_report',$data);
	}
	
	//New changes in Reports starts
	
	public function production_report($type="", $user="", $id=""){
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		$this->load->view('new_admin/production_report',$data);
	}
	
	public function management_report($type="", $user="", $id=""){
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		$this->load->view('new_admin/management_report',$data);
	}
	
	public function others_report($type="", $user="", $id=""){
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		$this->load->view('new_admin/others_report',$data);
	}
	
	public function report_designer_production($type="", $user="", $id=""){
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		
		if($user == 'designer'){
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		$this->load->view('new_admin/report_designer_production',$data);
		
	}
	
	public function report_csr_production($type="", $user="", $id=""){
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		
		if($user == 'csr'){
			$data['csr'] = $this->db->query("SELECT * FROM `csr` WHERE `is_active` = '1'  ORDER BY `name`")->result_array();
		}
		$this->load->view('new_admin/report_csr_production',$data);
		
	}
	
	public function report_hd_production($type="", $user="", $id=""){
		$data['type'] = $type;
		$data['user'] = $user;
		$data['id'] = $id;
		
		if($user == 'help_desk'){
			$data['help_desk'] = $this->db->query("SELECT * FROM `help_desk` WHERE `active` = '1'  ORDER BY `name`")->result_array();
		}
		
		$this->load->view('new_admin/report_hd_production',$data);
		
	}
	
	//New changes in Reports Ends
	
	// Size Report Starts
	
	public function size_date($type="",$date="")
	{
		$data['type'] = $type;
		$data['date'] = $date;
		
		$this->load->view('new_admin/size_date',$data);
	}
	
	public function size_report($type="",$date=""){
		$data['type'] = $type;
		$data['date'] = $date;
		
		if($date == 'today'){
				$from = date('Y-m-d');
				$to =  date('Y-m-d');
		}elseif($date == 'last_week'){
				$from = date('Y-m-d', strtotime("-1 week +1 day"));
				$to =  date('Y-m-d');
		}elseif($date == 'last_month'){
				$from = date('Y-m-d', strtotime("-1 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'three_month'){
				$from = date('Y-m-d', strtotime("-3 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'six_month'){
				$from = date('Y-m-d', strtotime("-6 month"));
				$to =  date('Y-m-d');
		}elseif($date == 'one_year'){
				$from = date('Y-m-d', strtotime("-1 year"));
				$to =  date('Y-m-d');
		}elseif($date == 'custom' && isset($_GET['from'])){
				$from = $_GET['from'];
				$to =  $_GET['to'];
				$data['custom'] = date('Y-m-d');
		}
		$data['from'] = $from;
		$data['to'] = $to;
		$orders = "SELECT `created_on` ,`width`, `height`, `size_inches` FROM `orders` WHERE `width`!='none' AND `height`!='none' AND `size_inches`!='none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59'";

		$data['orders'] = $this->db->query($orders)->result_array();
		//var_dump($orders);
		$this->load->view('new_admin/size_report',$data);
	}
	// Size Report Ends
	//Assiging Publication to Designer Starts
	public function assign_publication($user_type = '', $id = '')
	{
		if($user_type != '' && $id != ''){
		    $user_details = $this->db->query("SELECT * FROM $user_type WHERE `id` = '$id'")->row_array();
		    if(isset($user_details['id'])){
				$data['group_details'] = $this->db->query("SELECT `id`,`name` FROM `Group` WHERE `is_active` = '1' ORDER BY `name` ASC")->result_array();
    			$data['user_details'] = $user_details;
    			if($user_details['pub_id'] != null){
    				$pub_id = explode(',', $user_details['pub_id']);
    				$data['pub_id'] = $pub_id;
    			}
    			if(isset($_POST['submit'])){
    				if(isset($_POST['publication'])){
    					$pub_id=implode(",",$_POST['publication']);
    					$pub_data = array('pub_id'=> $pub_id);
    					$this->db->where('id',$id);
    					$this->db->update($user_type, $pub_data);
    					redirect('new_admin/home/assign_publication/'.$user_type.'/'.$id);
					}
    			}
    			$this->load->view('new_admin/assign_publication',$data);
    		}
		}
	}

//Assiging Publication to Designer Ends

	public function user_log($user_type='', $user_id='all')
	{
		if($user_type != ''){
			if($user_type == 1){ $user_module = 'admin_users'; //admin
				$query = "SELECT id, CONCAT(first_name,' ',last_name) AS name FROM `admin_users` WHERE is_active='1' ORDER BY `name` ASC";
			}elseif($user_type == 2){ $user_module = 'adreps'; //adrep
				$query = "SELECT id, CONCAT(first_name,' ',last_name) AS name FROM `adreps` WHERE is_active='1' ORDER BY `name` ASC";
			}elseif($user_type == 3){ $user_module = 'csr';	//csr
				$query = "SELECT id, name FROM `csr` WHERE is_active='1' ORDER BY `name` ASC";
			}elseif($user_type == 4){ $user_module = 'designers';	//designer
				$query = "SELECT id, name FROM `designers` WHERE is_active='1' ORDER BY `name` ASC";
			}
			$data['user_list'] = $this->db->query($query)->result_array();
			
			$query_log = "SELECT * FROM `users_login_session` WHERE `user_module` = '$user_type'";
			if($user_id != 'all'){
				$query_log .= " AND `user_id` = '$user_id'";
			}
			if(isset($_GET['from'])){
				$data['from'] = $_GET['from'].' 00:00:00'; $data['to'] = $_GET['to'].' 23:59:59';
			}else{
				$data['from'] = date('Y-m-d', strtotime("-1 days")).' 00:00:00'; $data['to'] = date('Y-m-d').' 23:59:59';
			}
			$query_log .= " AND `timestamp` BETWEEN '".$data['from']."' AND '".$data['to']."' ORDER BY `id` DESC"; 
			$data['user_log_details'] = $this->db->query($query_log)->result_array();
			$data['user_module'] = $user_module;
		}
		$data['user_type'] = $user_type;
		$data['user_id'] = $user_id;
		$this->load->view('new_admin/user_log', $data);
	}
	
	//Club Interface
	public function club($id='')
	{
		if(isset($_POST['submit'])){
			if(isset($_POST['name'])){
				$data = array('name' => $_POST['name']);
				$this->db->insert('club',$data);
				$inserted_id= $this->db->insert_id();
				if($inserted_id){
					$this->session->set_flashdata("message","Club has been created successfully");
					redirect('new_admin/home/production_manage');
				}else{
				    $e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
				    redirect('new_admin/home/production_manage');
				} 
			}
		}
		$data['club'] = $this->db->query("SELECT `id`,`name` FROM `club` ORDER BY `name` ASC")->result_array();
    	if($id!=''){
			$data['publication'] = $this->db->query("SELECT id, name, club_id FROM `publications` WHERE `club_id` LIKE '%".$id."%' ORDER BY name ASC;")->result_array();
			$data['csr'] = $this->db->query("SELECT id, name, username, club_id FROM `csr` WHERE `club_id` Like '%".$id."%' ORDER BY name ASC;")->result_array();
			$data['designer'] = $this->db->query("SELECT id, name, username, club_id FROM `designers` WHERE `club_id` Like '%".$id."%' ORDER BY name ASC;")->result_array();
			
			$data['publications'] = $this->db->query("SELECT id, name FROM `publications` WHERE `is_active` = '1' ORDER BY name ASC;")->result_array();
			$data['csrs'] = $this->db->query("SELECT id, name, username FROM `csr` WHERE `is_active` = '1' ORDER BY name ASC;")->result_array();
			$data['designers'] = $this->db->query("SELECT id, name, username FROM `designers` WHERE `is_active` = '1' ORDER BY name ASC;")->result_array();
		}
		$data['id'] = $id;		
		$this->load->view('new_admin/club',$data);
	}
	
	public function user_assign_club()
	{
		$user_type = $_POST['user_type'];
		$id = $_POST['id'];
		if($user_type != '' && $id != ''){
			$q = "SELECT * FROM $user_type WHERE `id` = '$id'";
		    $user_details = $this->db->query($q)->row_array();
		    if(isset($user_details['id'])){
				
    			if($user_details['club_id'] != null && $user_details['club_id'] != 0){
    				$club_id = explode(',', $user_details['club_id']);
    				array_push($club_id, $_POST['club']);
					$u_club_id = array_unique($club_id);
					$new_club_id = implode(",",$u_club_id);
					$club_data = array('club_id'=> $new_club_id);
    				$this->db->where('id',$id);
    				$this->db->update($user_type, $club_data);
    			}else{
					$club_data = array('club_id'=> $_POST['club']);
    				$this->db->where('id',$id);
    				$this->db->update($user_type, $club_data);
					if($this->db->affected_rows()){
						echo 'table changes done';
					}
				}
    		}
			echo $q;
		}else{ echo 'empty';}
	}
	
	public function user_unassign_club()
	{
		$user_type = $_POST['user_type'];
		$id = $_POST['id'];
		if($user_type != '' && $id != ''){
			$q = "SELECT * FROM $user_type WHERE `id` = '$id'";
		    $user_details = $this->db->query($q)->row_array();
		    if(isset($user_details['id'])){
				if($user_details['club_id'] != null && $user_details['club_id'] != 0){
    				$club_id = explode(',', $user_details['club_id']);
    				//array_pop($club_id, $_POST['club']);
					$u_club_id = array_unique($club_id);
					if(($key = array_search($_POST['club'], $u_club_id)) !== false){
						unset($u_club_id[$key]);
					}
					$new_club_id = implode(",",$u_club_id);
					$club_data = array('club_id'=> $new_club_id);
    				$this->db->where('id',$id);
    				$this->db->update($user_type, $club_data);
					if($this->db->affected_rows()){
						echo 'table changes done';
					}
    			}
    		}
			echo $q;
		}else{ echo 'empty';}
	}
	
	public function assign_club($user_type = '', $id = '')
	{
		if($user_type != '' && $id != ''){
		    $user_details = $this->db->query("SELECT * FROM $user_type WHERE `id` = '$id'")->row_array();
		    if(isset($user_details['id'])){
				$data['club'] = $this->db->query("SELECT `id`,`name` FROM `club` ORDER BY `name` ASC")->result_array();
    			$data['user_details'] = $user_details;
    			if($user_details['club_id'] != null){
    				$club_id = explode(',', $user_details['club_id']);
    				$data['club_id'] = $club_id;
    			}
    			if(isset($_POST['submit'])){
    				if(isset($_POST['club'])){
    					$club_id=implode(",",$_POST['club']);
    					$club_data = array('club_id'=> $club_id);
    					$this->db->where('id',$id);
    					$this->db->update($user_type, $club_data);
    					redirect('new_admin/home/assign_club/'.$user_type.'/'.$id);
					}
    			}
    			$this->load->view('new_admin/assign_club',$data);
    		}
		}
	}
	
  public function yearly_count_report()
	{
		$groups = $this->db->query("SELECT `id`, `name` FROM `Group` WHERE `is_active` = '1' ORDER BY `name` ASC")->result_array();
		if(isset($_GET['group']) && isset($_GET['select_year'])){
			$group_id = $_GET['group'];
			$select_year = $_GET['select_year'];
			$order_type = $_GET['order_type'];
			$data['months'] = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			if($group_id == 'all'){
				if($order_type == 'revision'){  //revision
					foreach($groups as $row){ $g_id = $row['id'];
						for($i = 1 ; $i <= 12; $i++){ 
							$from = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-01";
							$to = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-31";
							
							$q = "SELECT rev_sold_jobs.id AS count FROM `rev_sold_jobs` 
								JOIN `orders` ON orders.id = rev_sold_jobs.order_id
								WHERE orders.group_id='".$g_id."' AND orders.order_type_id='2' AND rev_sold_jobs.pdf_file != 'none' AND rev_sold_jobs.date BETWEEN '$from' AND '$to'";
							
							//echo $q.'<br/>';
							$order_count[$g_id][$i] = $this->db->query("$q")->num_rows();
						}
					}
				}else{ //new
					foreach($groups as $row){ $g_id = $row['id'];
						for($i = 1 ; $i <= 12; $i++){ 
							$from = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-01";
							$to = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-31";
							
							$q = "SELECT `id` AS count FROM `orders` 
							        WHERE `group_id`='".$g_id."' AND `order_type_id`='2' AND `pdf` != 'none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
							
							//echo $q.'<br/>';
							$order_count[$g_id][$i] = $this->db->query("$q")->num_rows();
						}
					}
				}
			}else{
				$publications =  $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `group_id` = '$group_id' AND `is_active` = '1' ORDER BY `name` ASC")->result_array();
				if($order_type == 'revision'){ //revision
					foreach($publications as $row){ 
						$pub_id = $row['id'];
						for($i = 1 ; $i <= 12; $i++){ 
							$from = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-01";
							$to = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-31";
							$q = "SELECT rev_sold_jobs.id AS count FROM `rev_sold_jobs` 
								JOIN `orders` ON orders.id = rev_sold_jobs.order_id
								WHERE orders.publication_id='".$pub_id."' AND orders.order_type_id='2' AND rev_sold_jobs.pdf_file != 'none' AND rev_sold_jobs.date BETWEEN '$from' AND '$to'";
							
							//echo $q.'<br/>';
							$order_count[$pub_id][$i] = $this->db->query("$q")->num_rows();
						}
					}
				}else{ //New
					foreach($publications as $row){ 
						$pub_id = $row['id'];
						for($i = 1 ; $i <= 12; $i++){ 
							$from = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-01";
							$to = $select_year."-".str_pad($i, 2, "0", STR_PAD_LEFT)."-31";
							$q = "SELECT `id` AS count FROM `orders` WHERE `publication_id`='".$pub_id."' AND `order_type_id`='2' AND `pdf` != 'none' AND `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
							
							//echo $q.'<br/>';
							$order_count[$pub_id][$i] = $this->db->query("$q")->num_rows();
						}
					}
				}
				$data['publications'] = $publications;
			}
			$data['order_count'] = $order_count;
			
			$data['group_id'] = $group_id;
			$data['select_year'] = $select_year;
			$data['order_type'] = $order_type;
		}
		$data['groups'] = $groups;
		$this->load->view('new_admin/yearly_count_report',$data);
	}
	
    public function rev_ratio()
	{
		$data['hi'] = 'hello';
		if(isset($_GET['type']) && !empty($_GET['from']) && !empty($_GET['to'])){
			$from = $_GET['from'];
			$to =  $_GET['to'];
			$output = '';
			if($_GET['type'] == 'publication'){
				$publications = $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `is_active` = '1' ORDER BY `name` ASC")->result_array();
				foreach($publications as $row){
						$ratio = 0; $new_count = 0; $rev_count = 0;
						
						$orders = $this->db->query("SELECT `id` FROM `orders` WHERE `publication_id` = '".$row['id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (`pdf` != 'none')")->result_array();
						$new_count = count($orders); 
						foreach($orders as $order_row){ 
							$revision = $this->db->query("SELECT `id` FROM `rev_sold_jobs` WHERE `order_id` = '".$order_row['id']."' AND (`pdf_path` != 'none')")->result_array();
							$rev_count = $rev_count + count($revision);
						}
						
						if(($rev_count !='0') && $new_count !='0'){ 
							$ratio = ($rev_count / $new_count); 
						}
				
					$output .= '<tr>';
					$output .= '<td>'.$row['name'].'</td>';
					$output .= '<td>'.round($ratio,2).'</td>';
					$output .= '</tr>';
				}
			}elseif($_GET['type'] == 'designer'){
				$designers = $this->db->query("SELECT `id`, `name` FROM `designers` WHERE `is_active` = '1' ORDER BY `name` ASC")->result_array();
				foreach($designers as $row){
						$ratio = 0; $new_count = 0; $rev_count = 0;
						$orders = $this->db->query("SELECT COUNT(orders.id) AS new_ad_count FROM `orders` JOIN `cat_result` ON cat_result.order_no = orders.id WHERE cat_result.designer = '".$row['id']."' AND (orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND (orders.pdf != 'none')")->row_array();
						$revision = $this->db->query("SELECT COUNT(id) AS rev_ad_count FROM `rev_sold_jobs` WHERE `designer` = '".$row['id']."' AND (`pdf_path` != 'none') AND (rev_sold_jobs.date BETWEEN '$from 00:00:00' AND '$to 23:59:59')")->row_array();
						$new_count = $orders['new_ad_count'];//count($orders);
						$rev_count = $revision['rev_ad_count'];//count($revision);
						
						if(($rev_count !='0') && $new_count !='0'){ 
							$ratio = ($rev_count / $new_count); 
						}
				
					$output .= '<tr>';
					$output .= '<td>'.$row['name'].'</td>';
					$output .= '<td>'.round($ratio,2).'</td>';
					$output .= '</tr>';
				}
			}
			
			$data['output'] = $output;
			$data['type'] = $_GET['type'];
			$data['from'] = $from;
			$data['to'] = $to;
		}
		$this->load->view('new_admin/rev_ratio', $data);
	}
	
	public function subject_classification()
	{
		$pub = $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `is_active` = '1' ORDER BY `name` ASC")->result_array();
		if(isset($_GET['id']) && !empty($_GET['from']) && !empty($_GET['to'])){
			$id = $_GET['id'];
			$from = $_GET['from'].' 00:00:00';
			$to = $_GET['to'].' 23:59:59';
			//foreach($pub as $row){
			if($id == 'ALL'){
				$q = "SELECT subject_templates.subject_id, ad_subject.subject, COUNT(subject_templates.order_id) AS ad_count 
						FROM orders 
						JOIN subject_templates ON subject_templates.order_id = orders.id 
						JOIN ad_subject ON ad_subject.id = subject_templates.subject_id 
						WHERE orders.created_on BETWEEN '$from' AND '$to' GROUP BY subject_templates.subject_id ORDER BY ad_subject.subject ASC";
			}else{
				$q = "SELECT subject_templates.subject_id, ad_subject.subject, COUNT(subject_templates.order_id) AS ad_count 
						FROM orders 
						JOIN subject_templates ON subject_templates.order_id = orders.id 
						JOIN ad_subject ON ad_subject.id = subject_templates.subject_id 
						WHERE orders.publication_id = '$id' AND orders.created_on BETWEEN '$from' AND '$to' GROUP BY subject_templates.subject_id ORDER BY ad_subject.subject ASC";
			}
				//echo $q;
				$orders = $this->db->query("$q")->result_array();
			//}	
			$data['output'] = $orders;
				$data['id'] = $id;
				$data['from'] = $_GET['from'];
				$data['to'] = $_GET['to'];
		}
		$data['publications'] = $pub;
		$this->load->view('new_admin/subject_classification', $data);
	}
	
	public function assign_publication_club()
	{
		//$unassigned_pub = $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `club_id` = '0' AND `is_active` = '1'")->result_array();
		$unassigned_pub = $this->db->query("SELECT publications.id, publications.name, `Group`.name AS gname FROM `publications` 
		LEFT JOIN `Group` ON `Group`.id = publications.group_id
		WHERE (publications.club_id = '0' OR publications.club_id = '' OR publications.club_id IS NULL) AND publications.is_active = '1'")->result_array();
		$data['unassigned_pub'] = $unassigned_pub;
		$this->load->view('new_admin/assign_publication_club',$data);
	}
	
	public function assign_csr_club()
	{
		$data['unassigned_csr'] = $this->db->query("SELECT `id`, `name`, `username` FROM `csr` WHERE `club_id` = '' AND `is_active` = '1' ORDER BY `name` ASC")->result_array();
		$this->load->view('new_admin/assign_csr_club',$data);
	}
	
	public function assign_designer_club()
	{
		$data['unassigned_designer'] = $this->db->query("SELECT `id`, `name`, `username` FROM `designers` WHERE `club_id` = '' AND `is_active` = '1' ORDER BY `name` ASC")->result_array();
		$this->load->view('new_admin/assign_designer_club',$data);
	}
	
	public function bill_report_publication_wise()
	{
		$data['hi'] = 'hello';
		
			$q = "SELECT orders.id, orders.order_type_id, orders.created_on, orders.job_no, orders.advertiser_name, orders.width, orders.height, orders.pixel_size, orders.custom_width, orders.custom_height, orders.pdf, orders_type.name AS adType, CONCAT(adreps.first_name, ' ', adreps.last_name) AS adrepName, publications.name AS publicationName, `Group`.name AS groupName, pixel_sizes.width AS pwidth, pixel_sizes.height AS pheight
			FROM `orders` 
				LEFT JOIN `orders_type` ON orders_type.id = orders.order_type_id
				LEFT JOIN `adreps` ON adreps.id = orders.adrep_id
				LEFT JOIN `publications` ON publications.id = orders.publication_id
				LEFT JOIN `Group` ON `Group`.id = orders.group_id
				LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders.pixel_size";
				
			if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
				$from = $_GET['from_date'];
				$to = $_GET['to_date'];
				$q .= " WHERE orders.pdf!='none' AND orders.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
				$data['orders'] = $this->db->query("$q")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$q .= " WHERE orders.pdf!='none' AND orders.created_on LIKE '$today%'";
				//echo $q;
				$data['orders'] = $this->db->query("$q")->result_array();
				$data['today'] = $today;
			}
			//echo $q;
		$this->load->view('new_admin/bill_report_publication_wise',$data);
	}
	
	//pagination billing report
	public function pagination_bill_report()
	{
		$data['hi'] = 'hello';
		
			$q = "SELECT page_design.*, CONCAT(adreps.first_name, ' ', adreps.last_name) AS adrepName, publications.name AS publicationName 
			        FROM `page_design` 
				    LEFT JOIN `adreps` ON adreps.id = page_design.user_id
				    LEFT JOIN `publications` ON publications.id = adreps.publication_id";
				
			if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
				$from = $_GET['from_date'];
				$to = $_GET['to_date'];
				$q .= " WHERE page_design.pdf!='none' AND page_design.created_on BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
				$data['orders'] = $this->db->query("$q")->result_array();
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date('Y-m-d');
				$q .= " WHERE page_design.pdf!='none' AND page_design.created_on LIKE '$today%'";
				//echo $q;
				$data['orders'] = $this->db->query("$q")->result_array();
				$data['today'] = $today;
			}
			
		$this->load->view('new_admin/pagination_bill_report', $data);
	}
	
	public function club_delete($club_id = '0')
	{
		$club = $this->db->query("SELECT `id` FROM `club` WHERE `id` = '$club_id';")->row_array();
		$pub_status = 0; $csr_status = 0; $designer_status = 0;
		if(isset($club['id'])){
			//unassign publication
			$q = "SELECT id, name, club_id FROM `publications` WHERE `club_id` = '$club_id'";
		    $pub = $this->db->query($q)->result_array();
			if(isset($pub[0]['id'])){
				foreach($pub as $row){
					if($row['club_id'] == $club_id){
						$club_data = array('club_id' => '');
						$this->db->where('id', $row['id']);
						$this->db->update('publications', $club_data);
						if($this->db->affected_rows()){
							$pub_status = 1;
						}
					}else{ $pub_status = 1; }
				}
			}else{ $pub_status = 1; }
			//unassign csr
			$csr = $this->db->query("SELECT id, name, username, club_id FROM `csr` WHERE `club_id` Like '%".$club_id."%' ;")->result_array();
			if(isset($csr[0]['id'])){
				foreach($csr as $row){
					if($row['club_id'] != null && $row['club_id'] != 0){
						$club_ids = explode(',', $row['club_id']);
						//array_pop($club_id, $_POST['club']);
						$u_club_id = array_unique($club_ids);
						if(($key = array_search($club_id, $u_club_id)) !== false){
							unset($u_club_id[$key]);
						}
						$new_club_id = implode(",",$u_club_id);
						$club_data = array('club_id' => $new_club_id);
						$this->db->where('id', $row['id']);
						$this->db->update('csr', $club_data);
						if($this->db->affected_rows()){
							$csr_status = 1;
						}
					}else{ $csr_status = 1; }
				}
			}else{ $csr_status = 1; }
			//unassign designer
			$designers = $this->db->query("SELECT id, name, username, club_id FROM `designers` WHERE `club_id` Like '%".$club_id."%' ;")->result_array();
			if(isset($designers[0]['id'])){
				foreach($designers as $row){
					if($row['club_id'] != null && $row['club_id'] != 0){
						$club_ids = explode(',', $row['club_id']);
						//array_pop($club_id, $_POST['club']);
						$u_club_id = array_unique($club_ids);
						if(($key = array_search($club_id, $u_club_id)) !== false){
							unset($u_club_id[$key]);
						}
						$new_club_id = implode(",",$u_club_id);
						$club_data = array('club_id' => $new_club_id);
						$this->db->where('id', $row['id']);
						$this->db->update('designers', $club_data);
						if($this->db->affected_rows()){
							$designer_status = 1;
						}
					}else{ $designer_status = 1; }
				}
			}else{ $designer_status = 1; }
			
			//delete club
			if($pub_status == 1 && $csr_status == 1 && $designer_status == 1){
				$this->db->query("DELETE FROM `club` WHERE `id`='".$club_id."';");
				$this->session->set_flashdata('message','Deleted successfully');
				redirect('new_admin/home/club');
			}
		}
	}
	
	public function final_revision()
	{
		$data = '';
		if(isset($_GET['from_date'], $_GET['to_date'])){
			$data['from_date'] = $_GET['from_date'].' 00:00:00';
			$data['to_date'] = $_GET['to_date'].' 23:59:59';
		}
		$this->load->view('new_admin/final_revision', $data);
	}
	
	public function ajax_action()
	{
		if(isset($_GET['from_date'], $_GET['to_date'])){
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			
			$query = "SELECT rev_sold_jobs.order_id, orders.job_no, adreps.first_name, adreps.last_name, publications.name, max(rev_sold_jobs.version) AS version FROM rev_sold_jobs 
			JOIN orders ON orders.id = rev_sold_jobs.order_id
			JOIN adreps ON orders.adrep_id = adreps.id
			JOIN publications ON orders.publication_id = publications.id
			WHERE (rev_sold_jobs.start_timestamp BETWEEN '$from' AND '$to') AND ("; 
			
			//search
			if(isset($_GET['search']['value'])){
				$query .= 'orders.id LIKE "%'.$_GET["search"]["value"].'%" ';

				$query .= 'OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%" ';

				$query .= 'OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%" ';

				$query .= 'OR adreps.last_name LIKE "%'.$_GET["search"]["value"].'%" ';

				$query .= 'OR publications.name LIKE "%'.$_GET["search"]["value"].'%" ';

				$query .= 'OR rev_sold_jobs.version LIKE "%'.$_GET["search"]["value"].'%" ';
			}
			$query .= ") GROUP BY rev_sold_jobs.order_id ";
			
			//ORDER BY
			if(isset($_GET['order'])){
				$query .= 'ORDER BY '.$_GET['order']['0']['column'].' '.$_GET['order']['0']['dir'].' ';
			}else{
				$query .= 'ORDER BY rev_sold_jobs.order_id DESC ';
			}
			
			$extra_query = '';
			if($_GET['length'] != -1){
				$extra_query .= 'LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
			}
			//echo $query;
			$filtered_rows = $this->db->query($query)->num_rows();
			$query .= $extra_query;
			
			$orders = $this->db->query("$query")->result_array();
			
			//echo $query;
			$query = "SELECT rev_sold_jobs.order_id, max(rev_sold_jobs.version) FROM rev_sold_jobs
						WHERE (rev_sold_jobs.start_timestamp BETWEEN '$from' AND '$to') GROUP BY rev_sold_jobs.order_id";
						   
			$total_rows = $this->db->query($query)->num_rows();
			
			$data = array();
			foreach($orders as $row){
				
				$sub_array = array();
				
					$sub_array[] = $row['order_id'];
					$sub_array[] = $row['job_no'];
					$sub_array[] = $row['first_name'].' '.$row['last_name'];
					$sub_array[] = $row['name'];
					$sub_array[] = $row['version'];
				
				$data[] = $sub_array;
			}
			
			$output = array(
							"draw"    => intval($_GET["draw"]),
							"recordsTotal"  => $total_rows,
							"recordsFiltered" => $filtered_rows,
							"data"    => $data
						   );
			echo json_encode($output);
		}
	}
	
	public function scorecard()
	{
		$new_order_count = 0; $new_order_nj = 0; $rev_order_count = 0; $rev_order_nj = 0; $new_and_rev_ratio = 0;
		if(isset($_GET['from_date'], $_GET['to_date'])){
			$from = $_GET['from_date'].' 00:00:00';
			$to = $_GET['to_date'].' 23:59:59';
			
			$query = "SELECT COUNT(orders.id) AS new_count, SUM(print.wt) AS new_nj FROM orders 
						INNER JOIN cat_result ON cat_result.order_no = orders.id
						INNER JOIN print ON print.name = cat_result.category
						WHERE orders.status != '6' AND orders.created_on BETWEEN '$from' AND '$to'";
			//echo $query.'</br>';
			$new_order = $this->db->query("$query")->row_array();
			
			$query = "SELECT COUNT(rev_sold_jobs.id) AS rev_count FROM rev_sold_jobs 
						WHERE rev_sold_jobs.status != '6' AND rev_sold_jobs.start_timestamp BETWEEN '$from' AND '$to'";
			//echo $query.'</br>';
			$rev_order = $this->db->query("$query")->row_array();
			
			$new_order_count = $new_order['new_count'];
			$new_order_nj = $new_order['new_nj'];
			$rev_order_count = $rev_order['rev_count'];
			$rev_order_nj = ($rev_order['rev_count']*0.25);
			if($new_order_count != 0 || $rev_order_count != 0){ 
				$new_and_rev_ratio = round(($rev_order_count / $new_order_count), 2);
			}
		}
		$data['new_order_count'] = $new_order_count;
		$data['new_order_nj'] = $new_order_nj;
		$data['rev_order_count'] = $rev_order_count;
		$data['rev_order_nj'] = $rev_order_nj;
		$data['new_and_rev_ratio'] = $new_and_rev_ratio;		
		
		$this->load->view('new_admin/scorecard', $data);
	}
	
	public function QandA()
	{
		$new_order_count = 0; $question_sent_count = 0;
		if(isset($_GET['pub_id'], $_GET['from_date'], $_GET['to_date'])){
			$pub_id = $_GET['pub_id'];
			$from = $_GET['from_date'].' 00:00:00';
			$to = $_GET['to_date'].' 23:59:59';
			if($pub_id == 'all'){
				$query = "SELECT COUNT(orders.id) AS new_count, COUNT(orders_Q_A.id) AS Q_count FROM orders 
						LEFT JOIN orders_Q_A ON orders_Q_A.order_id = orders.id
						WHERE orders.created_on BETWEEN '$from' AND '$to'";
			}else{
				$query = "SELECT COUNT(orders.id) AS new_count, COUNT(orders_Q_A.id) AS Q_count FROM orders 
						LEFT JOIN orders_Q_A ON orders_Q_A.order_id = orders.id
						WHERE orders.publication_id = '$pub_id' AND orders.created_on BETWEEN '$from' AND '$to'";
			}
			
			//echo $query.'</br>';
			$new_order = $this->db->query("$query")->row_array();
			
			$new_order_count = $new_order['new_count'];
			$question_sent_count = $new_order['Q_count'];
		}
		$data['new_order_count'] = $new_order_count;
		$data['question_sent_count'] = $question_sent_count;
		$data['publications'] = $this->db->query("SELECT * FROM `publications` where `is_active` = '1'")->result_array();
		$this->load->view('new_admin/QandA', $data);
	}
	
	public function rev_review()
	{
		$data['new_order_count'] = '';
		if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
			$data['from'] = $_GET['from_date'].' 00:00:00';
			$data['to'] = $_GET['to_date'].' 23:59:59';
			/*$query = "SELECT COUNT(order_revision_review.id) AS new_count 
						FROM order_revision_review 
							WHERE order_revision_review.timestamp BETWEEN '$from' AND '$to'";
			$new_order = $this->db->query("$query")->row_array();*/
		}
		$this->load->view('new_admin/rev_review', $data);
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
		$this->load->view('new_admin/billing_revision_report',$data);
	}
	
	public function designer_nj()
	{
	    $data['hi'] = 'hello';
		if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
		    $data['from'] = $_GET['from_date'];
		    $data['to'] = $_GET['to_date'];
		    $data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		    $rev_cat = $this->db->get_where('print',array('name' => 'REVISION'))->row_array();
		    $data['rev_wt'] = $rev_cat['wt'];
		    /*
		    $new_ad = "SELECT cat_result.id, cat_result.order_no, designer_ads_time.designer_id, designers.name, designers. username,
		                    TIMESTAMPDIFF(SECOND, designer_ads_time.start_time, CONCAT(designer_ads_time.end_date,' ',designer_ads_time.end_time)) AS TimeTaken 
                                FROM `cat_result`
		                            JOIN `designer_ads_time` ON designer_ads_time.order_id = cat_result.order_no
		                            JOIN `designers` ON designers.id = designer_ads_time.designer_id
		                            WHERE cat_result.ddate BETWEEN '".$_GET['from_date']."' AND '".$_GET['to_date']."' GROUP BY designer_ads_time.designer_id";
		    $rev_ad = "";
		    echo $new_ad;
		    $data['new_ad'] = $this->db->query($new_ad)->result_array();
		    */
		}
		$this->load->view('new_admin/designer_nj', $data);
	}
	
	public function designer_nj_details()
	{
	   if(!empty($_GET['designer_id']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])){
	        $dId = $_GET['designer_id'] ;
	        $from = $_GET['from_date'] ;
	        $to = $_GET['to_date'] ;
	        $new_ad_query = "SELECT cat_result.id, cat_result.order_no, cat_result.job_name, cat_result.version, designer_ads_time.designer_id, 
		                        TIMESTAMPDIFF(SECOND, designer_ads_time.start_time, CONCAT(designer_ads_time.end_date,' ',designer_ads_time.end_time)) AS TimeTaken, print.wt
                                    FROM `cat_result`
                    		          JOIN `designer_ads_time` ON cat_result.order_no = designer_ads_time.order_id
                    		            JOIN `print` ON cat_result.category = print.name
                    		                WHERE cat_result.designer = '".$dId."' AND cat_result.ddate BETWEEN '".$from."' AND '".$to."'";
            $rev_ad_query = "SELECT rev_sold_jobs.order_id, rev_sold_jobs.id, rev_sold_jobs.version, rev_sold_jobs.time_taken FROM rev_sold_jobs
                                    WHERE rev_sold_jobs.designer = '".$dId."' AND rev_sold_jobs.date BETWEEN '".$from."' AND '".$to."'";            		              
            $data['new_ad'] = $this->db->query($new_ad_query)->result_array();
            $data['rev_ad'] = $this->db->query($rev_ad_query)->result_array();
            
            $this->load->view('new_admin/designer_nj_details', $data);
	   }
	}
	
	function foo($seconds) {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
    }

    public function orderview_history($hd="",$order_id="",$id="",$type="",$user="", $from="",$to="",$order_type="",$EA="")
	{
		//$sId = $this->session->userdata('sId');
		//$csr = $this->db->query("SELECT * FROM `csr` WHERE `id` = '$sId'")->result_array();
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
			//$redirect = 'new_csr/home/orderview/'.$hd.'/'.$order_id;
			//$data['redirect']= $redirect;
			$data['order_id']= $order_id; 
			$data['hd']= $hd;
			if(!$orders){
				$this->session->set_flashdata("message","Order: Details not Found!!");
				redirect('new_admin/home');
			}
			$data['adrep'] = $this->db->query("SELECT * FROM `adreps` WHERE `id` = '".$orders[0]['adrep_id']."'")->result_array();
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
	
	public function back_to_designer()
	{
	    $this->load->view('new_admin/back_to_designer');
	}
	
	public function back_to_designer_content()
	{
	    if(!empty($_GET['dateRange'])){
	        $date = $_GET['dateRange'];
        	    if($date == 'today'){
        				$from = date('Y-m-d');
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_week'){
        				$from = date('Y-m-d', strtotime("-1 week +1 day"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_month'){
        				$from = date('Y-m-d', strtotime("-1 month"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'three_month'){
        				$from = date('Y-m-d', strtotime("-3 month"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_year'){
        				$from = date('Y-m-d', strtotime("-1 year"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'custom' && isset($_GET['from_date'])){
        				$from = $_GET['from_date'];
        				$to =  $_GET['to_date'];
        		}
                
		    $from = $from.' 00:00:00';
		    $to = $to.' 23:59:59';
		    $data['from'] = $from;
    		    $data['to'] = $to;
    		    
	        $q = "SELECT production_conversation.*, csr.name, new_ad_designer.name AS designer_name  FROM `production_conversation`
	                    JOIN `cat_result` ON cat_result.order_no = production_conversation.order_id
	                    JOIN `designers` AS `new_ad_designer` ON new_ad_designer.id = cat_result.designer
	                    JOIN `csr` ON csr.id = production_conversation.csr_id
	                   WHERE production_conversation.operation = 'QA_designer' AND production_conversation.time BETWEEN '$from' AND '$to'";
	                   
	       $tot_q = "SELECT DISTINCT(production_conversation.order_id), production_conversation.*, csr.name  FROM `production_conversation`
	                    JOIN `csr` ON csr.id = production_conversation.csr_id
	                   WHERE production_conversation.operation = 'QA_designer' AND production_conversation.time BETWEEN '$from' AND '$to'";
	                   
	       if(isset($_GET["search"]["value"]) && !empty($_GET["search"]["value"]))  
           {  
               $key = $_GET["search"]["value"];
                $q .= " AND (csr.name LIKE '$key%'";
                $q .= " OR production_conversation.message LIKE '$key%')";
           }
           $filtered_q = $q;
            $q .= " ORDER BY production_conversation.order_id DESC";
           if(isset($_GET["length"]) && $_GET["length"] != -1)  
           {  
                $q .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start']; 
           }
           
          
	       echo $q;
	       $fetch_data = $this->db->query($q)->result_array();
	       $data = array();
		   foreach($fetch_data as $row)
           { 
               $sub_array = array();
                $sub_array[] = '<a href="'.base_url().index_page().'new_admin/home/order_review_history/'.$row['order_id'].'" target="_blank">'.$row['order_id'].'</a>';
                $sub_array[] = $row['designer_name'];
                $sub_array[] = $row['name'];
                $sub_array[] = $row['message'];
                $sub_array[] = date('M d, Y', strtotime($row['time']));
                
                $data[] = $sub_array;
           }
           //$data[] = $q;
           $recordsTotal = $this->db->query($tot_q)->num_rows();
           $recordsFiltered = $this->db->query($filtered_q)->num_rows();
           $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $recordsFiltered,  
                "data"              =>     $data  
           );  
           echo json_encode($output); 
	        //$data['order_list'] = $this->db->query($q)->result_array();
		}
	}
	//new ads reports
	public function new_ads_report()
	{
	    $this->load->view('new_admin/new_ads_report');
	}
	
	public function category_by_designer()
	{
	    $data['hi'] = "hello";
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
    	    $date = $_GET['dateRange'];
    	    if($date == 'today'){
    				$from = date('Y-m-d');
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_week'){
    				$from = date('Y-m-d', strtotime("-1 week +1 day"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_month'){
    				$from = date('Y-m-d', strtotime("-1 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'three_month'){
    				$from = date('Y-m-d', strtotime("-3 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_year'){
    				$from = date('Y-m-d', strtotime("-1 year"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'custom' || isset($_GET['from_date'])){
    				$from = $_GET['from_date'];
    				$to =  $_GET['to_date'];
    		}
    		$data['from'] = $from;
    		$data['to'] = $to;
    		$q = "SELECT `id`, `name` FROM `designers` WHERE is_active='1'";
	        $data['designers'] = $this->db->query($q)->result_array();
    	}
	    $this->load->view('new_admin/category_by_designer', $data);
	    /*if(isset($_POST['load']) && !empty($_POST['from_date']) && !empty($_POST['to_date'])){
	        $from = $_POST['from_date'].' 00:00:00';
		    $to = $_POST['to_date'].' 23:59:59';
	        $q = "SELECT `id`, `name` FROM `designers` WHERE is_active='1'";
	                   
	       $tot_q = $q;
	                   
	       if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]))  
           {  
               $key = $_POST["search"]["value"];
                $q .= " AND (`name` LIKE '$key%')";
                //$q .= " OR production_conversation.message LIKE '$key%')";
           }
           $filtered_q = $q;
           if(isset($_POST["order"])){  
                $q .= " ORDER BY `name` ".$_POST['order']['0']['dir']; 
           }else{  
                $q .= " ORDER BY `name` ASC";
           } 
           
            //$q .= " ORDER BY `name` ASC";
           if(isset($_POST["length"]) && $_POST["length"] != -1)  
           {  
                $q .= " LIMIT ".$_POST['length']." OFFSET ".$_POST['start']; 
           }
           
          
	       //echo $q;
	       $fetch_data = $this->db->query($q)->result_array();
	       $data = array();
	       $total_p = 0; $total_m = 0; $total_n = 0; $total_t = 0; $total_w = 0;
		   foreach($fetch_data as $row)
           { 
               $cat_result = $this->db->query("SELECT category, COUNT(id) AS category_count FROM `cat_result` 
               WHERE  `designer`='".$row['id']."' AND `ddate` BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY `category`;")->result_array();
               $sub_array = array();
               
                    $p = 0; $m = 0; $n = 0; $t = 0; $w = 0;
                    foreach($cat_result as $cat){
                        if($cat['category'] == 'P'){ 
                            $p= $cat['category_count']; $total_p = $total_p + $p;  
                        }elseif($cat['category'] == 'M'){ 
                            $m= $cat['category_count'];  
                        }elseif($cat['category'] == 'N'){ 
                            $n = $cat['category_count'];  
                        }elseif($cat['category'] == 'T'){ 
                            $t = $cat['category_count']; 
                        }elseif($cat['category'] == 'W'){ 
                            $w = $cat['category_count'];
                        }
                    } 
                    $sub_array[] = $row['name']; //designer name
                    $sub_array[] = $p; //P
                    $sub_array[] = $m; //M
                    $sub_array[] = $n; //N
                    $sub_array[] = $t; //T
                    $sub_array[] = $w; //W
               
               $data[] = $sub_array;
           }
           //$data[] = $q;
           $recordsTotal = $this->db->query($tot_q)->num_rows();
           $recordsFiltered = $this->db->query($filtered_q)->num_rows();
           $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $recordsFiltered,  
                "data"              =>     $data,
                "totalP"            =>     $total_p
           );  
           echo json_encode($output);
	    }else{
	        $this->load->view('new_admin/category_by_designer');
	    }*/
	}
	
	public function hourly_production_report()
	{
	    $data['hi'] = "hello";
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
    	    $date = $_GET['dateRange'];
    	    if($date == 'today'){
    				$from = date('Y-m-d');
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_week'){
    				$from = date('Y-m-d', strtotime("-1 week +1 day"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_month'){
    				$from = date('Y-m-d', strtotime("-1 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'three_month'){
    				$from = date('Y-m-d', strtotime("-3 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_year'){
    				$from = date('Y-m-d', strtotime("-1 year"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'custom' && isset($_GET['from_date'])){
    				$from = $_GET['from_date'];
    				$to =  $_GET['to_date'];
    		}
    		$data['from'] = $from;
    		$data['to'] = $to;
    		/*
    		$q = "SELECT  hour( orders.pdf_timestamp ) , date( orders.pdf_timestamp ), count(*) FROM `orders` 
                    JOIN `cat_result` ON cat_result.order_no = orders.id 
                        WHERE orders.pdf_timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59' 
                        GROUP BY hour( orders.pdf_timestamp ) , day( orders.pdf_timestamp ) ORDER BY orders.pdf_timestamp ASC";

    		echo $q;
    		*/
    		$team_query = '';
    		if(isset($_GET['team']) && $_GET['team'] != ''){
    		    $adwit_teams_id = trim($_GET['team']);
    		    $team_club_id = "SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id`=".$adwit_teams_id; 
    		    $team_query = " AND orders.club_id IN ($team_club_id) ";
    		}
    		
    		$period = new DatePeriod(
                                     new DateTime($from.' 00:00:00'),
                                     new DateInterval('P1D'),
                                     new DateTime($to.' 23:59:59')
                                );
           
            $output = array();
            foreach ($period as $key => $value) {
                $sub_array = array();
                $DateValue = $value->format('Y-m-d');
                for($i=0;$i<24;$i++){ $p[$i] = '0'; }
                
				    $q = "SELECT  hour( orders.pdf_timestamp ) AS hourValue , date( orders.pdf_timestamp ) AS dateValue, count(*) AS adCount FROM `orders` 
                    JOIN `cat_result` ON cat_result.order_no = orders.id 
                        WHERE orders.pdf_timestamp BETWEEN '$DateValue 00:00:00' AND '$DateValue 23:59:59' $team_query
                        GROUP BY hour( orders.pdf_timestamp ) , day( orders.pdf_timestamp ) ORDER BY orders.pdf_timestamp ASC";
                    //echo $q.'<br/>';
                    
                    $orders = $this->db->query("$q")->result_array();
                    foreach($orders as $order_row){
                        $hourValue = $order_row['hourValue'];
                        $p[$hourValue] = $order_row['adCount'];
                    }
                    $sub_array['dateValue'] = $DateValue;
                    $sub_array['adCount'] = $p;
                    
                    $output[] = $sub_array;
            }
            
            $data['output'] = $output;
    	}
	    $data['adwit_teams'] = $this->db->query("SELECT * FROM `adwit_teams` WHERE `is_active` = 1")->result_array();
		$this->load->view('new_admin/hourly_production_report',$data);    
	}
	
	public function hourly_production_report_category()
	{
	    $data['hi'] = "hello";
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
    	    $date = $_GET['dateRange'];
    	    if($date == 'today'){
    				$from = date('Y-m-d');
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_week'){
    				$from = date('Y-m-d', strtotime("-1 week +1 day"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_month'){
    				$from = date('Y-m-d', strtotime("-1 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'three_month'){
    				$from = date('Y-m-d', strtotime("-3 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_year'){
    				$from = date('Y-m-d', strtotime("-1 year"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'custom' || isset($_GET['from_date'])){
    				$from = $_GET['from_date'];
    				$to =  $_GET['to_date'];
    		}
    		$data['from'] = $from;
    		$data['to'] = $to;
    		
    		$q = "SELECT orders.id, orders.pdf_timestamp, cat_result.category FROM `orders`
    		        JOIN `cat_result` ON cat_result.order_no = orders.id
    		        WHERE orders.pdf_timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59' ";
    		//echo $q;
    		//$q = "SELECT orders.id, orders.pdf_timestamp FROM `orders`  WHERE orders.pdf_timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
    		$data['orders'] = $this->db->query("$q")->result_array();
    	}
	   
		$this->load->view('new_admin/hourly_production_report_category',$data);    
	}
	
	//Revision ads reports
	public function revision_ads_report()
	{
	    $this->load->view('new_admin/revision_ads_report');
	}
	
	public function number_of_revision_by_category()
	{
	    $data['hi'] = "hello";
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
    	    $date = $_GET['dateRange'];
    	    if($date == 'today'){
    				$from = date('Y-m-d');
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_week'){
    				$from = date('Y-m-d', strtotime("-1 week +1 day"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_month'){
    				$from = date('Y-m-d', strtotime("-1 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'three_month'){
    				$from = date('Y-m-d', strtotime("-3 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_year'){
    				$from = date('Y-m-d', strtotime("-1 year"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'custom' || isset($_GET['from_date'])){
    				$from = $_GET['from_date'];
    				$to =  $_GET['to_date'];
    		}
    		$data['from'] = $from;
    		$data['to'] = $to;
    		
    		$version_list = $this->db->query("SELECT rev_sold_jobs.version FROM `rev_sold_jobs`
    		                                    WHERE rev_sold_jobs.date BETWEEN '$from' AND '$to' 
    		                                    GROUP BY `rev_sold_jobs`.`version` ORDER BY `rev_sold_jobs`.`version` ASC;")->result_array();
    		$output = array();
    		$total_m = '0'; $total_n = '0'; $total_p = '0'; $total_t = '0'; $total_w = '0';
    		foreach($version_list as $version){
    		    $sub_array = array();
    		    $q = "SELECT cat_result.category, COUNT(rev_sold_jobs.id) AS ad_count  FROM `rev_sold_jobs`
    		            JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
    		            WHERE rev_sold_jobs.version = '".$version['version']."' AND rev_sold_jobs.date BETWEEN '$from' AND '$to' 
    		            GROUP BY cat_result.category ORDER BY cat_result.category ASC;";
    		    $rev_sold_jobs = $this->db->query("$q")->result_array();
    		    $m = '0'; $n = '0'; $p = '0'; $t = '0'; $w = '0';
    		    foreach($rev_sold_jobs as $row){
    		        if($row['category'] == 'M'){ $m = $row['ad_count'];  $total_m = $total_m + $m; }
    		        if($row['category'] == 'N'){ $n = $row['ad_count'];  $total_n = $total_n + $n; } 
    		        if($row['category'] == 'P'){ $p = $row['ad_count'];  $total_p = $total_p + $p; }
    		        if($row['category'] == 'T'){ $t = $row['ad_count'];  $total_t = $total_t + $t; }
    		        if($row['category'] == 'W'){ $w = $row['ad_count'];  $total_w = $total_w + $w; }
    		    }
    		        $sub_array[] = $version['version']; //version
                    $sub_array[] = $p; //P
                    $sub_array[] = $m; //M
                    $sub_array[] = $n; //N
                    $sub_array[] = $t; //T
                    $sub_array[] = $w; //W
                $output[] = $sub_array;
    		}
    		/*foreach($data as $d){
    		    echo $d[0].' - '.$d[1].'<br/>';
    		}*/
    		//var_dump($data);
    		$data['output'] = $output;
    		$data['total_m'] = $total_m;
    		$data['total_n'] = $total_n;
    		$data['total_p'] = $total_p;
    		$data['total_t'] = $total_t;
    		$data['total_w'] = $total_w;
    	}
	    $this->load->view('new_admin/number_of_revision_by_category', $data);
	}
//adwit_team_report START	
	public function adwit_team_report()
	{
	    $this->load->view('new_admin/adwit_team_report');
	}
	
	public function adwit_team_report_content()
	{
	    $output = '';
	    if(isset($_GET['status_wise'])){
	        $status_wise = $_GET['status_wise'];
	        $from = date("Y-m-d", strtotime($_GET['from'])). " 00:00:00";
            $to = date("Y-m-d", strtotime($_GET['to'])). " 23:59:59";
            
	        if($status_wise == 'category_team'){
	            $query = "SELECT count(cat_result.category) as cat_count, cat_result.adwit_teams_id, cat_result.category, adwit_teams.name FROM cat_result
	                        JOIN adwit_teams ON adwit_teams.adwit_teams_id = cat_result.adwit_teams_id
	                        WHERE cat_result.timestamp BETWEEN '$from' AND '$to' AND cat_result.adwit_teams_id>0 group by cat_result.category, cat_result.adwit_teams_id 
	                        ORDER BY cat_result.adwit_teams_id, cat_result.category ASC;";
	            $output .= '<thead>';
            	$output .= '<tr>';
            	$output .= '<th title="Team name">Team</th>';
            	$output .= '<th title="Category">Category</th>';
            	$output .= '<th title="Ad Count">Count</th>';
            	$output .= '</tr>';
            	$output .= '</thead>';
            	
            	$report = $this->db->query($query)->result_array();
    	    
            	$output .= '<tbody>';
        	    foreach($report as $data){
        	        $output .= '<tr>';
                    $output .= '<td>'.$data['name'].'</td>';
                    $output .= '<td>'.$data['category'].'</td>';
                    $output .= '<td>'.$data['cat_count'].'</td>';
                    $output .= '</tr>';
        	    }
        	    $output .= '</tbody>';
	        }elseif($status_wise == 'category'){
	            $query = "SELECT count(category) as cat_count, category FROM adwitac_weborders.cat_result 
	                        WHERE timestamp BETWEEN '$from' AND '$to' AND adwit_teams_id>0 group by category;";
	            $output .= '<thead>';
            	$output .= '<tr>';
            	$output .= '<th title="Category">Category</th>';
            	$output .= '<th title="Ad Count">Count</th>';
            	$output .= '</tr>';
            	$output .= '</thead>';
            	
            	$report = $this->db->query($query)->result_array();
    	    
            	$output .= '<tbody>';
        	    foreach($report as $data){
        	        $output .= '<tr>';
                    $output .= '<td>'.$data['category'].'</td>';
                    $output .= '<td>'.$data['cat_count'].'</td>';
                    $output .= '</tr>';
        	    }
        	    $output .= '</tbody>';
	        }elseif($status_wise == 'team'){
	            $query = "SELECT count(cat_result.category) as cat_count, cat_result.adwit_teams_id, adwit_teams.name FROM cat_result
	                        JOIN adwit_teams ON adwit_teams.adwit_teams_id = cat_result.adwit_teams_id
	                        WHERE cat_result.timestamp BETWEEN '$from' AND '$to' AND cat_result.adwit_teams_id>0 group by cat_result.adwit_teams_id;"; 
	            $output .= '<thead>';
            	$output .= '<tr>';
            	$output .= '<th title="Team name">Team</th>';
            	$output .= '<th title="Ad Count">Count</th>';
            	$output .= '</tr>';
            	$output .= '</thead>';
            	
            	$report = $this->db->query($query)->result_array();
    	    
            	$output .= '<tbody>';
        	    foreach($report as $data){
        	        $output .= '<tr>';
                    $output .= '<td>'.$data['name'].'</td>';
                    $output .= '<td>'.$data['cat_count'].'</td>';
                    $output .= '</tr>';
        	    }
        	    $output .= '</tbody>';
	        }
	        //echo  $query;                   
    	    echo json_encode($output);
	    }
	 }
	 
	 public function hourly_order_count_graph()
	 {
	    $current_date = date("Y-m-d"); $ysterday = date("Y-m-d", strtotime(' -1 day'));
	    if(isset($_GET['from']) && isset($_GET['to'])){
	        $from = date("Y-m-d", strtotime($_GET['from']));
            $to = date("Y-m-d", strtotime($_GET['to']));   
	    }else{
	        $from = $current_date;
            $to = $current_date;
	    }
	    $q = "SELECT * FROM `hourly_order_count` WHERE `date` BETWEEN '$from' AND '$to' GROUP BY `hour` ORDER BY `hour` ASC;";
	    //echo $q;
	    $hourly_order_count = $this->db->query("$q")->result_array();
	    
	    $hourly_order_count_ist = $this->db->query("SELECT * FROM `hourly_order_count` WHERE `date_ist` BETWEEN '$from' AND '$to' GROUP BY `hour_ist` ORDER BY `hour_ist` ASC;")->result_array();
	    
	    $order_receive_count = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $order_accepted_count = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $inproduction_count = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $quality_check_count = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $proof_ready_count = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $approved_count = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    //foreach()
	    foreach($hourly_order_count as $row){
	        for($i=0; $i<24; $i++){
	            if($row['hour'] == $i){
	               $order_receive_count[$i] = $row['order_received_count'];
	               $order_accepted_count[$i] = $row['order_accepted_count'];
	               $inproduction_count[$i] = $row['inproduction_count'];
	               $quality_check_count[$i] = $row['quality_check_count'];
	               $proof_ready_count[$i] = $row['proof_ready_count'];
	               $approved_count[$i] = $row['approved_count'];
	            }
	        }
	    }
	    $data['order_receive_count'] = $order_receive_count;
	    $data['order_accepted_count'] = $order_accepted_count;
	    $data['inproduction_count'] = $inproduction_count;
	    $data['quality_check_count'] = $quality_check_count;
	    $data['proof_ready_count'] = $proof_ready_count;
	    $data['approved_count'] = $approved_count;
    	
    	//IST Graph data
    	$order_receive_count_ist = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $order_accepted_count_ist = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $inproduction_count_ist = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $quality_check_count_ist = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $proof_ready_count_ist = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    $approved_count_ist = array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
	    //foreach()
	    foreach($hourly_order_count_ist as $row){
	        for($i=0; $i<24; $i++){
	            if($row['hour_ist'] == $i){
	               $order_receive_count_ist[$i] = $row['order_received_count'];
	               $order_accepted_count_ist[$i] = $row['order_accepted_count'];
	               $inproduction_count_ist[$i] = $row['inproduction_count'];
	               $quality_check_count_ist[$i] = $row['quality_check_count'];
	               $proof_ready_count_ist[$i] = $row['proof_ready_count'];
	               $approved_count_ist[$i] = $row['approved_count'];
	            }
	        }
	    }
	    $data['order_receive_count_ist'] = $order_receive_count_ist;
	    $data['order_accepted_count_ist'] = $order_accepted_count_ist;
	    $data['inproduction_count_ist'] = $inproduction_count_ist;
	    $data['quality_check_count_ist'] = $quality_check_count_ist;
	    $data['proof_ready_count_ist'] = $proof_ready_count_ist;
	    $data['approved_count_ist'] = $approved_count_ist;
    /*	for($i=0; $i<24; $i++){
    	    echo $order_receive_count[$i].' '.$order_accepted_count[$i].' '.$inproduction_count[$i].' '.$quality_check_count[$i].' '.$proof_ready_count[$i].' '.$approved_count[$i].'<br/>';
    	}*/
    	
	    $this->load->view("new_admin/hourly_order_count_graph", $data);
	 }
	
	public function teamwise_ad_volume()
    {
        $data['adwit_teams'] = $this->db->query("SELECT * FROM `adwit_teams` WHERE `is_active` = 1")->result_array();
        $this->load->view('new_admin/teamwise_ad_volume', $data);
    }
    
	public function teamwise_ad_volume_content($adwit_teams_id='')
	{
	     $today_date_time = $this->db->query("SELECT `time` FROM `today_date_time`")->result_array();
    		//Time	
    		$ystday_time = $today_date_time[0]['time'];
    		$today_time = $today_date_time[1]['time'];
    		$tomo_time = $today_date_time[2]['time'];
    		$current_time = date("H:i:s");
    		//Day
    		$current_date = date("Y-m-d");
    		$day = date("D", strtotime($current_date)); //echo $day.' '.$current_time;
    		$ysterday = date("Y-m-d", strtotime(' -1 day'));
    		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
    		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
    		$tomo = date("Y-m-d", strtotime(' +1 day'));
    		
    		if($day == 'Mon'){ //Friday To Monday
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $day_before_yyday.' '.$ystday_time; //Friday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        	        $from_date_range = $day_before_yyday.' '.$today_time;   //Friday 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
    			}
    		}elseif($day == 'Sun'){ //Saturday To Sunday
    			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $day_before_yday.' '.$ystday_time;   //saturday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        		    $from_date_range = $day_before_yday.' '.$today_time;    //saturday 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
    			 }    
    		}else{
    		    if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
    			    $from_date_range = $ysterday.' '.$ystday_time;          //yesterday 08:30:00
    			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
    			    //date range for yesterdays ads
    			    $yst_from_date_range = $day_before_yday.' '.$ystday_time ;  
    			    $yst_to_date_range = $ysterday.' '.$today_time;  
    			 }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
        	        $from_date_range = $current_date.' '.$today_time;      //today 08:29:59
    			    $to_date_range = $tomo.' '.$tomo_time;                  //tomorrow 08:29:59
    			    //date range for yesterdays ads
    			    $yst_from_date_range = $ysterday.' '.$today_time ;  
    			    $yst_to_date_range = $current_date.' '.$tomo_time; 
    			 }
    		}
    	
		//TeamLead Ad volume Dashboard
		$adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
		if(isset($adwit_team['category'])){
		    $team_club_id = "SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id`=".$adwit_teams_id;
		    
		    $cat_id = explode(',', $adwit_team['category']);
			$category_level = "'" . implode ( "', '", $cat_id ) . "'";
		    //Todays Print Ads count
		    $total_ads_q = "SELECT COUNT(orders.id) AS total_Ads FROM `orders`
		                        JOIN cat_result ON cat_result.order_no = orders.id
    			                    WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    			                        AND orders.crequest != '1' AND orders.cancel !='1'";
    		
        	//Pending Print Ads count
        	$pending_ads_q = "SELECT COUNT(orders.id) AS pending_Ads FROM `orders` 
        	                    JOIN cat_result ON cat_result.order_no = orders.id
    			                    WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    			                        AND (orders.status BETWEEN '1' AND '4') 
    									AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1'";
        										                                    
        	//Sent Print Ads count
        	$sent_ads_q = "SELECT COUNT(orders.id) AS sent_Ads FROM `orders`
        	                    JOIN cat_result ON cat_result.order_no = orders.id
    			                    WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    			                        AND (orders.status BETWEEN '5' AND '7') 
    										AND orders.crequest != '1' AND orders.cancel != '1' ";
    										
        	//Question count
    	    $question_ads =  $this->db->query("SELECT COUNT(orders.id) AS question_Ads FROM `orders`
    	                                                JOIN cat_result ON cat_result.order_no = orders.id
    	                                                    WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    										                      AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    										                          AND orders.question = '1' AND orders.crequest != '1' AND orders.cancel != '1' ;")->row_array();
    			                        
        	$todays_total_ads = $this->db->query($total_ads_q. " AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range'); ")->row_array();
		    $todays_pending_ads = $this->db->query($pending_ads_q. " AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') ")->row_array();
		    $todays_sent_ads = $this->db->query($sent_ads_q. " AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') ")->row_array();
		    $yesterdays_total_ads_count = 0; $yesterdays_pending_ads_count = 0; $yesterdays_sent_ads_count = 0;
		    if(isset($yst_from_date_range)){
		        /*$yesterdays_total_ads = $this->db->query($total_ads_q. " AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range'); ")->row_array();
		        $yesterdays_pending_ads = $this->db->query($pending_ads_q. " AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range') ")->row_array();
		        $yesterdays_sent_ads = $this->db->query($sent_ads_q. " AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range') ")->row_array();
		        $yesterdays_total_ads_count = $yesterdays_total_ads['total_Ads'];
		        $yesterdays_pending_ads_count = $yesterdays_pending_ads['pending_Ads'];
		        $yesterdays_sent_ads_count = $yesterdays_sent_ads['sent_Ads'];*/
		        //order recieved status 
                $yst_order_recieved = $this->db->query("SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                                            LEFT JOIN `order_status` ON orders.status = order_status.id
                                                             WHERE orders.status = 1
                                                             AND orders.club_id IN ($team_club_id) 
                                                                AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;")->row_array();
            	$yst_order_recieved_count = (!empty($yst_order_recieved['ad_count'])) ? $yst_order_recieved['ad_count'] : 0;
		        $yst_order_status = $this->db->query("SELECT COUNT(orders.id) as ad_count, order_status.name as statusName, order_status.id FROM `orders` 
            								JOIN order_status ON order_status.id = orders.status
            								JOIN cat_result ON cat_result.order_no = orders.id
            									WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level) 
            									AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range')
            									GROUP by orders.status")->result_array();
            	$output_yst_status ='<div class="col-md-2 col-sm-2 col-xs-6">
    								<div class="uppercase font-hg font-black-flamingo">'.$yst_order_recieved_count.'</div>
    								<div class="font-grey-mint font-sm">Order Received</div>
    							</div>';
            	foreach($yst_order_status as $ystatus){ 
        		    $output_yst_status .= '<div class="col-md-2 col-sm-2 col-xs-6">
        								        <div class="uppercase font-hg font-black-flamingo">'.$ystatus['ad_count'].'</div>
        								        <div class="font-grey-mint font-sm">'.$ystatus['statusName'].'</div>
        							        </div>';
        							
        		} 
		    }
		    
        	//Category wise pending ads count START
        	$q_category_wise = "SELECT COUNT(orders.id) as ad_count, cat_result.category FROM `orders` 
                                                JOIN cat_result ON cat_result.order_no = orders.id
                                                WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
                                                         AND orders.pdf = 'none' AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
                                                			AND orders.crequest!='1' AND orders.cancel!='1' 
                                                				GROUP by cat_result.category;";
    									
		    $category_wise_volume = $this->db->query("$q_category_wise")->result_array();
		    $output_category="";
		    foreach($category_wise_volume as $cat){ 
                $output_category .= '<div class="col-md-2 col-sm-2 col-xs-4">
    								    <div class="uppercase font-hg font-blue">'.$cat['ad_count'].'</div>
    								    <div class="font-grey-mint font-sm">'.$cat['category'].'</div>
    							 </div>';
    							
    		}
    		
		    //status wise ads count START
    		$q_status_wise = "SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                LEFT JOIN `order_status` ON orders.status = order_status.id
                                JOIN cat_result ON cat_result.order_no = orders.id
                                            WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
                                                AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;";
            //order recieved status 
            $order_recieved = $this->db->query("SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                                        LEFT JOIN `order_status` ON orders.status = order_status.id
                                                         WHERE orders.status = 1
                                                         AND orders.club_id IN ($team_club_id) 
                                                            AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;")->row_array();
        	$order_recieved_count = (!empty($order_recieved['ad_count'])) ? $order_recieved['ad_count'] : 0;
        	$total_count = $order_recieved_count;
        	$status_wise_volume = $this->db->query("$q_status_wise")->result_array();
        	
        	$output_status ='<div class="col-md-2 col-sm-2 col-xs-6">
    								<div class="uppercase font-hg font-black-flamingo">'.$order_recieved_count.'</div>
    								<div class="font-grey-mint font-sm">Order Received</div>
    							</div>';
        	foreach($status_wise_volume as $status){ 
        	    $total_count = $total_count + $status['ad_count'];
    		    $output_status .= '<div class="col-md-2 col-sm-2 col-xs-6">
    								<div class="uppercase font-hg font-black-flamingo">'.$status['ad_count'].'</div>
    								<div class="font-grey-mint font-sm">'.$status['statusName'].'</div>
    							  </div>';
    							
    		} 
        
    		//todays
    		$data['todays_total_ads_count'] = $todays_total_ads['total_Ads'];
		    $data['todays_pending_ads_count'] = $todays_pending_ads['pending_Ads'];
		    $data['todays_sent_ads_count'] = $todays_sent_ads['sent_Ads'];
		    $data['question_ads_count'] = $question_ads['question_Ads'];
		    //yesterdays count
		    $data['yst_status_wise_count_div'] = $output_yst_status;
		    //category wise ad
		    $data['category_wise_count_div'] = $output_category;
		    //status wise ad
		    $data['status_wise_count_div'] = $output_status;
		    $data['total_count'] = $total_count;
            echo json_encode($data);
	    }
	 }
	 
	public function revision_ratio_report() //Team & Version wise 06Feb2023
	{
	    $data['adwit_teams'] = $this->db->query("SELECT * FROM `adwit_teams` WHERE `is_active` = 1 ORDER BY `orderBy` ASC")->result_array();
	    $this->load->view('new_admin/revision_ratio_report', $data);                    
	}
	
	public function revision_ratio_report_detail($adwit_team_id='')//dateRange,team,from_date,to_date,version
	{
	   if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
	        //$adwit_team_id = $_GET['team'];
	        $version = $_GET['version'];
    	    $date = $_GET['dateRange'];
    	    if($date == 'today'){
    				$from = date('Y-m-d');
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_week'){
    				$from = date('Y-m-d', strtotime("-1 week +1 day"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_month'){
    				$from = date('Y-m-d', strtotime("-1 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'three_month'){
    				$from = date('Y-m-d', strtotime("-3 month"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'one_year'){
    				$from = date('Y-m-d', strtotime("-1 year"));
    				$to =  date('Y-m-d');
    		}elseif($date == 'custom' && isset($_GET['from_date'])){
    				$from = $_GET['from_date'];
    				$to =  $_GET['to_date'];
    		}
    		$data['from'] = $from;
    		$data['to'] = $to;
    		
    		$team_designers_list = $this->db->query("SELECT `id`, `name` FROM `designers` 
    		                                            WHERE `adwit_teams_id`='$adwit_team_id' AND `isEnabled_adwit_teams` = 1 AND `is_active` = 1")->result_array();
    	    $totalDesigner = 0; $totalNewAdCount = 0; $totalRevisionAdCount = 0;
    	    //$teamOutput = array(); 
    	    $output = '<table class="table table-striped table-bordered table-hover" id="sample_6">
                    			<thead>
                    				<tr>
                    				    <th></th>
                    					<th>New Ads</th>
                    					<th>Revisions</th>
                    					<th>Ratio (%)</th>
                    				</tr>
                    			</thead>
                    			<tbody>';
    	    foreach($team_designers_list as $team_designer){ 
    	       // $sub_array = array();
    	        if($version == 'V1a'){ //V1a-V1b
    	            $Nquery = "SELECT COUNT(rV1a.id) AS new_ad_count FROM `rev_sold_jobs` As rV1a 
    	                            WHERE  rV1a.designer='".$team_designer['id']."' AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' ";
    	                            
    	            $Rquery = "SELECT COUNT(rV1a.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1a 
    	                            JOIN `rev_sold_jobs` As rV1b ON rV1a.order_id = rV1b.order_id AND rV1b.version='V1b'
    	                                WHERE  rV1a.designer='".$team_designer['id']."' AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' ";                
    	        }elseif($version == 'V1b'){ //V1b-V1c
    	            $Nquery = "SELECT COUNT(rV1b.id) AS new_ad_count FROM `rev_sold_jobs` As rV1b 
    	                            WHERE  rV1b.designer='".$team_designer['id']."' AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' ";
    	                            
    	            $Rquery = "SELECT COUNT(rV1b.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1b 
    	                            JOIN `rev_sold_jobs` As rV1c ON rV1b.order_id = rV1c.order_id AND rV1c.version='V1c'
    	                                WHERE  rV1b.designer='".$team_designer['id']."' AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' ";    
    	        }else{  //V1-V1a
        	        $Nquery = "SELECT COUNT(cat_result.order_no) AS new_ad_count FROM cat_result 
                            WHERE cat_result.designer='".$team_designer['id']."' AND (cat_result.ddate BETWEEN '$from' AND '$to') "; 
                    //echo $Nquery.'<br/>';
                    /*$Rquery = "SELECT COUNT(rev_sold_jobs.id) AS rev_ad_count FROM rev_sold_jobs 
                                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                                WHERE rev_sold_jobs.version='V1a' AND rev_sold_jobs.designer='".$team_designer['id']."' AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5";*/
                    $Rquery = "SELECT COUNT(cat_result.order_no) AS rev_ad_count FROM cat_result 
                            JOIN rev_sold_jobs ON cat_result.order_no = rev_sold_jobs.order_id AND rev_sold_jobs.version='V1a' 
                            WHERE cat_result.designer='".$team_designer['id']."' AND (cat_result.ddate BETWEEN '$from' AND '$to') "; 
    	        }        
                $new_ad = $this->db->query($Nquery)->row_array();
                $revision_ad = $this->db->query($Rquery)->row_array(); 
                
                $new_ad_count = $new_ad['new_ad_count'];
                $rev_ad_count = $revision_ad['rev_ad_count'];
                if($rev_ad_count > 0) $ratio = round(($rev_ad_count / $new_ad_count) * 100, 2); else $ratio = '-';
                
                $output .= '<tr>
			                    <td>'.strtoupper($team_designer['name']).'</td>
			                    <td>'.$new_ad_count.'</td>
			                    <td>'.$rev_ad_count.'</td>
			                    <td>'.$ratio.'</td>
			             </tr>';
                /*
                $sub_array['name'] = strtoupper($team_designer['name']);
                $sub_array['NewAdCount'] = $new_ad_count;
                $sub_array['RevisionAdCount'] = $rev_ad_count;
                if($rev_ad_count > 0) $sub_array['ratio'] = round(($rev_ad_count / $new_ad_count) * 100, 2); else $sub_array['ratio'] = '-';
                
                $output[] = $sub_array;
                */
                $totalNewAdCount = $totalNewAdCount + $new_ad_count;
                $totalRevisionAdCount = $totalRevisionAdCount + $rev_ad_count;
                $totalDesigner++;
                
    	    }
    	    
    	    //print_r($output);
    	    //Total
    	    $data['totalDesigner'] = $totalDesigner;
            $data['totalNewAdCount'] = $totalNewAdCount;
            $data['totalRevisionAdCount'] = $totalRevisionAdCount;
            
            if($totalRevisionAdCount > 0) $totalRatio = round(($totalRevisionAdCount / $totalNewAdCount) * 100, 2); else $totalRatio = '';
	        $output .= '<tfoot>
                    			    <tr style="color: #e14e6a;">
                        			    <td><b>'.$totalDesigner.'</b></td> 
                        			    <td><b>'.$totalNewAdCount.'</b></td> 
                        			    <td><b>'.$totalRevisionAdCount.'</b></td>
                        			    <td><b>'.$totalRatio.'</b></td> 
                        			</tr>
                        		</tfoot>';
                        		
	        $output .= '</tbody>	
                    		</table>'; 
            if(isset($from) && isset($to)){ 
                $fromDateDisplay = strtotime($from); 
                $toDateDisplay = strtotime($to); 
                $data['DateRangeDisplay'] =  "<b>".date('M d, Y', $fromDateDisplay)."</b> to <b>".date('M d, Y', $toDateDisplay)."</b>" ;
            }
            
    	    $data['output'] = $output;
    	    
    	    echo json_encode($data);
    	}
	}

	public function publication_revision_ratio_report() //Publication & Version wise 09Feb2023
	{
	    $data['hi'] = 'all';
	    $totalDesigner = 0; $totalNewAdCount = 0; $totalRevisionAdCount = 0;
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
	        $publication_list = "SELECT publications.id FROM `publications` WHERE publications.is_active = 1";
    	    $version = $_GET['version'];
            $date = $_GET['dateRange'];
        	    if($date == 'today'){
        				$from = date('Y-m-d');
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_week'){
        				$from = date('Y-m-d', strtotime("-1 week +1 day"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_month'){
        				$from = date('Y-m-d', strtotime("-1 month"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'three_month'){
        				$from = date('Y-m-d', strtotime("-3 month"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_year'){
        				$from = date('Y-m-d', strtotime("-1 year"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'custom' && isset($_GET['from_date'])){
        				$from = $_GET['from_date'];
        				$to =  $_GET['to_date'];
        		}
                $data['from'] = $from;
    		    $data['to'] = $to;
                if($version == 'V1a'){
        	            $Nquery = "SELECT publications.name, COUNT(rV1a.id) AS new_ad_count FROM `rev_sold_jobs` As rV1a 
        	                        JOIN `orders` ON orders.id = rV1a.order_id
        	                        JOIN publications ON publications.id = orders.publication_id
        	                            WHERE  orders.publication_id IN ($publication_list) AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";
        	                            
        	            $Rquery = "SELECT publications.name, COUNT(rV1a.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1a 
        	                            JOIN `orders` ON orders.id = rV1a.order_id
        	                            JOIN publications ON publications.id = orders.publication_id
        	                            JOIN `rev_sold_jobs` As rV1b ON rV1a.order_id = rV1b.order_id AND rV1b.version='V1b'
        	                                WHERE  orders.publication_id IN ($publication_list) AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";                
        	    }elseif($version == 'V1b'){
        	            $Nquery = "SELECT publications.name, COUNT(rV1b.id) AS new_ad_count FROM `rev_sold_jobs` As rV1b 
        	                        JOIN `orders` ON orders.id = rV1b.order_id
        	                        JOIN publications ON publications.id = orders.publication_id
        	                            WHERE  orders.publication_id IN ($publication_list) AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";
        	                            
        	            $Rquery = "SELECT publications.name, COUNT(rV1b.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1b 
        	                            JOIN `orders` ON orders.id = rV1b.order_id
        	                            JOIN publications ON publications.id = orders.publication_id
        	                            JOIN `rev_sold_jobs` As rV1c ON rV1b.order_id = rV1c.order_id AND rV1c.version='V1c'
        	                                WHERE  orders.publication_id IN ($publication_list) AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";    
        	    }else{
            	        $Nquery = "SELECT publications.name, COUNT(cat_result.order_no) AS new_ad_count FROM cat_result
            	                    JOIN publications ON publications.id = cat_result.publication_id
                                        WHERE cat_result.publication_id IN ($publication_list) AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
                              
                        $Rquery = "SELECT publications.name, COUNT(cat_result.order_no) AS rev_ad_count FROM cat_result
                                    JOIN publications ON publications.id = cat_result.publication_id
                                    JOIN rev_sold_jobs ON cat_result.order_no = rev_sold_jobs.order_id AND rev_sold_jobs.version='V1a' 
                                        WHERE cat_result.publication_id IN ($publication_list) AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
        	    } 
        	    //echo $Nquery.'<br/>' ;   echo $Rquery.'<br/>' ; 
        	     $Nquery .= " Group BY publications.id Order BY publications.name ASC";
        	     $Rquery .= " Group BY publications.id Order BY publications.name ASC";
        	     
    		    $new_ad = $this->db->query($Nquery)->result_array();
                $revision_ad = $this->db->query($Rquery)->result_array(); 
            
        	$data['new_ad'] = $new_ad;
        	$data['revision_ad'] = $revision_ad;
	    }
	    $this->load->view('new_admin/publication_revision_ratio_report', $data);                    
	}
	
	public function back_to_designer_report() // 16Feb2023
	{
	    $data['adwit_teams'] = $this->db->query("SELECT * FROM `adwit_teams` WHERE `is_active` = 1 ORDER BY `orderBy` ASC")->result_array();
	    $this->load->view('new_admin/back_to_designer_report', $data); 
	}
	
	public function back_to_designer_report_detail($adwit_team_id) // 16Feb2023
	{
	    $totalDesigner = 0; $totalAdCount = 0; 
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
	        $date = $_GET['dateRange'];
        	    if($date == 'today'){
        				$from = date('Y-m-d');
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_week'){
        				$from = date('Y-m-d', strtotime("-1 week +1 day"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_month'){
        				$from = date('Y-m-d', strtotime("-1 month"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'three_month'){
        				$from = date('Y-m-d', strtotime("-3 month"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'one_year'){
        				$from = date('Y-m-d', strtotime("-1 year"));
        				$to =  date('Y-m-d');
        		}elseif($date == 'custom' && isset($_GET['from_date'])){
        				$from = $_GET['from_date'];
        				$to =  $_GET['to_date'];
        		}
                $data['from'] = $from;
    		    $data['to'] = $to;
    		    
    		    $team_designers_list = "SELECT `id` FROM `designers` 
    		                                WHERE `adwit_teams_id`='$adwit_team_id' AND `isEnabled_adwit_teams` = 1 AND `is_active` = 1";
    		                                            
    		    $q = "SELECT COUNT(DISTINCT production_conversation.order_id) as adCount, designers.name FROM `production_conversation` 
                        RIGHT JOIN cat_result ON cat_result.order_no = production_conversation.order_id
                        JOIN designers ON designers.id = cat_result.designer
                        WHERE cat_result.designer IN ($team_designers_list) AND production_conversation.operation IN ('QA_designer','DC_designer','tl_designer') 
                        AND production_conversation.time BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY cat_result.designer ORDER BY adCount DESC;";
                
                $result = $this->db->query($q)->result_array(); 
                $output = '<table class="table table-striped table-bordered table-hover" id="sample_6">
                    			<thead>
                    				<tr>
                    				    <th>Designer</th>
                    					<th>Count</th>
                    				</tr>
                    			</thead>
                    			<tbody>';
                foreach($result as $row){
                    $totalDesigner++;
                    $totalAdCount = $totalAdCount + $row['adCount'];
                	$output .= '<tr>
    			                    <td>'.strtoupper($row['name']).'</td>
    			                    <td>'.$row['adCount'].'</td>
    			             </tr>';
                }
                
                $output .= '<tfoot>
                    			    <tr style="color: #e14e6a;">
                        			    <td><b>'.$totalDesigner.'</b></td> 
                        			    <td><b>'.$totalAdCount.'</b></td>  
                        			</tr>
                        		</tfoot>';
                        		
	        $output .= '</tbody>	
                    		</table>';
                    		
            if(isset($from) && isset($to)){ 
                $fromDateDisplay = strtotime($from); 
                $toDateDisplay = strtotime($to); 
                $data['DateRangeDisplay'] =  "<b>".date('M d, Y', $fromDateDisplay)."</b> to <b>".date('M d, Y', $toDateDisplay)."</b>" ;
            }
            $data['totalDesigner'] = $totalDesigner;
            $data['totalAdCount'] = $totalAdCount;
    	    $data['output'] = $output;
    	    
    	    echo json_encode($data);
	    }
	                       
	}
}
