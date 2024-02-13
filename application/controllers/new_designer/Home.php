<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends New_Designer_Controller {
    public function __construct() {
    	parent:: __construct();
    	$this->load->helper("url");
    	$this->load->model("Pagination");
    	$this->load->library("pagination");
	}

	public function index()
	{
		$dId = $this->session->userdata('dId');
		
		$data['time'] = date("H:i:s");
		$data['date'] = date('d-m-Y');
		$from = date('Y-m-d', strtotime(' -4 day'));
		$to = date('Y-m-d');
		$this->load->helper('directory');
	    
	    //revision review
		$cat_result = $this->db->query("SELECT cat_result.order_no, cat_result.version, cat_result.help_desk FROM `cat_result`
		                                           RIGHT JOIN `rev_sold_jobs` ON rev_sold_jobs.order_id = cat_result.order_no
		                                            WHERE cat_result.designer = '$dId' AND (cat_result.date BETWEEN '$from' AND '$to') AND rev_sold_jobs.version = 'V1a'")->result_array();
		if(isset($cat_result[0]['order_no'])){
			$data['cat_result'] = $cat_result; 
		}
		//for other revision                                            
		$data['designer_rev_list'] = $this->db->query("SELECT `id`, `order_id`, `version`, `help_desk` FROM rev_sold_jobs 
		                                            WHERE `designer` = $dId AND `start_timestamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59'")->result_array();
		                                            
		$data['dId'] = $dId ;
		
		//Rev verify comment
		$designer_alias = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->row_array();
		$data['designer_alias'] = $designer_alias;
		
		if($designer_alias['designer_role'] == '3'){    //designer
    		$query = "SELECT rev_verify_comment.*, rev_sold_jobs.order_id, rev_sold_jobs.verification_type FROM `rev_verify_comment` 
            		JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
            		WHERE rev_verify_comment.designer_id = '$dId'  AND rev_verify_comment.designer_reply IS NULL "; 
		}elseif($designer_alias['designer_role'] == '2'){   //TL
			$query = "SELECT rev_verify_comment.*, rev_sold_jobs.order_id, rev_sold_jobs.verification_type FROM `rev_verify_comment` 
            		JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
            		WHERE rev_verify_comment.tl_designer_id = '$dId'  AND rev_verify_comment.dtl_reply IS NULL ";
		}elseif($designer_alias['designer_role'] == '4'){	//Hi-B Designer
			$query = "SELECT rev_verify_comment.*, rev_sold_jobs.order_id, rev_sold_jobs.verification_type FROM `rev_verify_comment` 
            		JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
            		WHERE rev_verify_comment.hi_b_designer_id = '$dId'  AND rev_verify_comment.hi_b_designer_reply IS NULL "; 
		}
		if(isset($query)){
		    $data['r_review'] = $this->db->query("$query ORDER BY rev_sold_jobs.id DESC")->result_array();
		}
		//pasword expiry
		if($dId == 180){
    		if(isset($designer_alias['pwd_date'])){
    			$now = time(); // or your date as well
    			$your_date = strtotime($designer_alias['pwd_date']);
    			$datediff = $now - $your_date;
    			$datediff = round($datediff / (60 * 60 * 24));
    			if($datediff > 30){
    				$this->session->set_flashdata('message','<label style="color:red">Reset Your Password..!!</label>');
    				redirect('new_designer/home/pwd_expiry');
    			}
    		}
    	}
		//Dashboard Ads Count date range input
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
    	
		$data['from_date_range'] = $from_date_range;
        $data['to_date_range'] = $to_date_range;
        //END Dashboard Ads Count date range input
        
		$this->load->view('new_designer/home',$data);
	}
	
	public function pwd_expiry()
	{
	    //$this->load->library('Encryption');
		$secret_key = $this->encrypt->encode($this->session->userdata('dEmail').":".time());
		$this->db->update('designers',array('encrypted_key' => $secret_key), array('email_id' => $this->session->userdata('dEmail')));
		$this->session->sess_destroy();
		redirect('new_designer/login/change/'.$secret_key);
	}
	
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		$this->load->view('new_designer/change',$data);
	}


	public function imagebank()
	{ 
		$data['hi'] = 'hi';
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$key = $this->input->get('id'); 
			$data['key'] = $key;
			$keywords = explode(' ', $key);
			$id_where = "image_tags.name LIKE '" . implode("%' OR image_tags.name LIKE '%", $keywords) . "'";
			$sql = "SELECT
			DISTINCT image_bank.id, image_bank.url, image_bank.thumbnail_url 
			FROM `image_tags`, `image_bank_tag`, `image_bank`
			WHERE ({$id_where})
			and image_bank_tag.tag_id = image_tags.id and image_bank.id = image_bank_tag.image_bank_id";
			$image = $this->db->query($sql)->result_array(); //$data['image'] = $image;
			if(isset($image[0]['id'])){
				$data['image'] = $image;
            }else{
				$this->session->set_flashdata('message','<label style="color:red">Search result not found..</label>');
                redirect('new_designer/home/imagebank');
            } 
		}
		$this->load->view('new_designer/imagebank',$data);
	}
	
	public function dochange()
	{
		$admin_pwd_date = $this->db->query("SELECT * from `pwd_expiry_date` WHERE `user` = 'designers'")->result_array();
			$num_days = $admin_pwd_date[0]['num_days'];
			$today = date('Y-m-d');
			$date_update = date('Y-m-d', strtotime("$num_days day"));
		$this->db->query("Update designers set password='".md5($this->input->post('new_password'))."' , pwd_expiry_date='$date_update', pwd_date='$today' where (email_id='".$this->session->userdata('designer')."' or username='".$this->session->userdata('designer')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows()){
			$this->session->set_flashdata("pwd_message","Your password has been changed successfully!");
			redirect('new_designer/home/my_account#tab_1_3');
		}else{
			$this->session->set_flashdata("pwd_message","Invalid current password!");
			redirect('new_designer/home/my_account#tab_1_3');
		}
	}
	
	public function my_account($tab='1')
	{
		$data['tab'] = $tab;
		if(isset($_POST['personal_info']) && (!empty($_POST['name']) || !empty($_POST['mobile_no']))){
			$post = array();
			if(!empty($_POST['name'])){ $post['name'] = $_POST['name']; }
			if(!empty($_POST['mobile_no'])){ $post['mobile_no'] = $_POST['mobile_no']; }
			$this->db->where('id', $_POST['aid']);
			$this->db->update('designers', $post); 
			$data['error'] = "changed successfully!!";
			$data['color'] = 'darkred';
		}
		if(isset($_POST['change_avatar']) && !empty($_FILES['file']['name'])){
			$file_size = $_FILES['file']['size'];
			if($file_size > 100000){
				 $this->session->set_flashdata('size_message',"Image size should not exceed 150KB!!");
					redirect('new_designer/home/my_account#tab_1_2'); 
			} else {
    			$uploadDir = "images/designers/".$this->session->userdata('dId').".jpg";
    			if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadDir)){
    				$data = array( 'image' => $uploadDir );
    				$this->db->where('id', $_POST['aid']);
    				$this->db->update('designers', $data);
    			}else{
    				$data['error'] = "Error Uploading!!";
    				$data['color'] = 'darkred';
    			}
    			$data['tab'] = '2'; 
    		}	
		}
		if(isset($_POST['remove_pic']) && !empty($_POST['designer_id'])){ 
			$default_path = "images/ad-img.jpg";
			$d_id = $_POST['designer_id'];
			$this->db->query("Update designers set image = '$default_path' where id = '$d_id'");
			redirect('new_designer/home/my_account#tab_1_2');
		}
		$designer_name=$this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
		$club_id = $designer_name[0]['club_id'];
		if($club_id != null && $club_id != 0){ 
			$assigned_pub = '';
			$q = "SELECT * FROM `publications` WHERE `club_id` IN (".$club_id.")";
			$publications = $this->db->query("$q")->result_array();
			foreach($publications as $publication){
				$assigned_pub .= $publication['name'].', ';
			}
			$data['assigned_pub'] = $assigned_pub;
		}
		$data['designer_name'] = $designer_name;
		
		$this->load->view('new_designer/my_account', $data);
	}
	
	public function notifications()
	{
		$this->load->helper('date');
		$today = date('Y-m-d');
		$dId = $this->session->userdata('dId');
		$notification1 = $this->db->query("SELECT * FROM `notification` WHERE `users` = '5' AND `job_status` = '1'")->result_array();
		if($notification1){
			foreach($notification1 as $row ){
				if($today > $row['end_date'])
				{
					$dataa = array('job_status' => 0);
					$this->db->where('id', $row['id']);
					$this->db->update('notification', $dataa);
				}
			}
		}
		$notification = $this->db->query("SELECT * FROM `notification` WHERE ('$today' BETWEEN `start_date` AND `end_date`) AND `users` = '5' AND `job_status` = '1'")->result_array();
		if($notification){ $data['notification'] = $notification; }else{ $data['message'] = 'No Notifications!!'; }
			$pwd_notification = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$dId'")->result_array();
				if($pwd_notification){
				$data['pwd_notification'] = $pwd_notification; 
				$date1 = $pwd_notification[0]['pwd_expiry_date'];
				$data['today'] = $today;
				$data['date1'] = $date1;
				}
		$this->load->view('new_designer/notifications', $data);
	}
	
	public function add_designer()
	{
		$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active` = '1'")->result_array();
		$dId = $this->session->userdata('dId');
		if(isset($_POST['add_button']) && !empty($_POST['did'])){
			$dataa = array(
			'd_id' => $dId,
			'designer_id' => $_POST['did'],
			);
			$this->db->insert('tag_designer_teamlead',$dataa);
			redirect('new_designer/home/add_designer');
		}
		if(isset($_POST['remove_button']) && !empty($_POST['rid'])){
			$id = $_POST['rid'];
			$this->db->query("DELETE FROM `tag_designer_teamlead` WHERE `id` = '$id'");
			redirect('new_designer/home/add_designer');
		}
		$this->load->view('new_designer/add_designer',$data);
	}
	
	public function meetings()
	{
		$this->load->view('new_designer/meetings');
	}
	
	public function newsold_pdf_upload($order_id)
	{
		//upload file to sold pdf
		$slug = $_POST['slug_name'];
		$filetype = $_POST['file_type'];
		if($filetype == 'indd' || $filetype == 'psd' || $filetype == 'pdf' || $filetype == 'images' )
		{
			if(!empty($_FILES))
			{
				$path = 'sold_pdf'.'/'.$order_id;
				if (@mkdir($path,0777)){}
				$path1 = 'sold_pdf'.'/'.$order_id.'/'.$slug;
				//echo $path;
				if (@mkdir($path1,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				if(!move_uploaded_file($tempFile, $path1.'/'.$fileName)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
				redirect('new_designer/home'); }
				$post = array('sold_pdf' => $path1.'/'.$fileName);
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $post);
			}
		}
	}
	
	public function revsold_pdf_upload($order_id)
	{
		//upload file to sold pdf
		$slug = $_POST['cat_slug'];
		$filetype = $_POST['file_type'];
		if($filetype == 'indd' || $filetype == 'psd' || $filetype == 'pdf' || $filetype == 'images' ) 
		{
			if(!empty($_FILES))
			{
				
				$path = 'sold_pdf'.'/'.$order_id;
				if (@mkdir($path,0777)){}
				$path1 = 'sold_pdf'.'/'.$order_id.'/'.$slug;
				//echo $path;
				if (@mkdir($path1,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				if(!move_uploaded_file($tempFile, $path1.'/'.$fileName)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
				redirect('new_designer/home'); }
				$post = array('sold_pdf' => $path1.'/'.$fileName);
				$this->db->where('id', $_POST['rev_id']);
				$this->db->update('rev_sold_jobs', $post);
			}
		}
		
	}
	
	public function idml_rev_upload($order_id)
	{
		$slug = $_POST['cat_slug'];
		$filetype = $_POST['file_type'];
					
		if($filetype == 'idml')
		{
			if(!empty($_FILES))
			{
				$path = 'sourcefile'.'/'.$order_id.'/'.$slug;
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$path_parts = pathinfo($_FILES['file']['name']);
				$fileName = $path_parts['filename'];
				$fileExt = $path_parts['extension'];
				$fileExt = strtolower($fileExt);
				if($fileExt == 'idml' || $fileExt == 'psd'){
					$upload_path = $fileName.'.'.$fileExt;
					if(!move_uploaded_file($tempFile, $path.'/'.$fileName.'.'.$fileExt)){
						$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
					redirect('new_designer/home'); }
				}
			}
		}
					
			
	}
	
	public function metro_sold_pdf($order_id)
	{
		//sold Ad End design
		if(isset($_POST['end_sold']))
		{
		 $fileuploadstatus = $this->db->get_where('rev_sold_jobs',array('id'=> $_POST['rev_id']))->result_array();
		 $cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
		 $redirect = 'new_designer/home/orderview/'.$_POST['hd'].'/'.$order_id;
		 $slug_file = $_POST['slug'];
			if($fileuploadstatus[0]['sold_pdf'] != 'none')
			{
				$pdf_path = 'sold_pdf/'.$order_id.'/'.$cat[0]['slug'];
				$pdffile = $pdf_path.'/'.$slug_file.".pdf";
				if(!file_exists($pdffile)){
					$this->session->set_flashdata("sold_file_message","PDF Missing..!!");
					redirect($redirect);
				}
			} else{ $this->session->set_flashdata("sold_file_message","Source Files Missing..!!"); redirect($redirect); }  
			
			$post = array('status' => '4');
						$this->db->where('id', $_POST['rev_id']);
						$this->db->update('rev_sold_jobs', $post);
		
		    //update rev status in orders table(new 21 Apr 2022)
			$order_rev_status_upadate = array( 'rev_order_status' => '4' ); //Revision InQA
			$this->db->where('id', $order_id);
			$this->db->update('orders', $order_rev_status_upadate);
					
			//Live_tracker Revision Updation
			$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
			if(isset($update_revision['id'])){
				$tracker_data = array('status' => '4');
				$this->db->where('id', $update_revision['id']);
				$this->db->update('live_revisions', $tracker_data);
			}
		
		
		$this->session->set_flashdata("message"," Job Completed!!");
		redirect('new_designer/home/frontlinetrack_order_list/'.$_POST['hd']); 
		}
		//upload file to sold pdf
		$slug = $_POST['cat_slug'];
		$filetype = $_POST['file_type'];
		if($filetype == 'pdf' || $filetype == 'images' ) 
		{
			if(!empty($_FILES))
			{
				
				$path = 'sold_pdf'.'/'.$order_id;
				if (@mkdir($path,0777)){}
				$path1 = 'sold_pdf'.'/'.$order_id.'/'.$slug;
				//echo $path;
				if (@mkdir($path1,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				if(!move_uploaded_file($tempFile, $path1.'/'.$fileName)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
				redirect('new_designer/home'); }
				$post = array('sold_pdf' => $fileName);
				$this->db->where('id', $_POST['rev_id']);
				$this->db->update('rev_sold_jobs', $post);
			}
		}
		
	}
	
	public function reports($tab='')
	{  
		$data['tab'] = $tab;
		$dId = $this->session->userdata('dId');
		$this->load->helper('date');
		$today = date('Y-m-d');
		$data['previous_month'] = date('M', strtotime(' -1 month'));
		$data['current_month'] = date('M');
		if($tab=='2'){
			$prev_month = date('Y-m', strtotime(' -1 month'));
			$from = $prev_month.'-01';
			$to = $prev_month.'-31';
			$data['cat_result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `designer` = '$dId' AND `ddate` BETWEEN '$from' AND '$to'")->result_array();
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `designer` = '$dId' AND `ddate` BETWEEN '$from' AND '$to'")->result_array();
		}elseif($tab=='1'){
			$month = date('Y-m');
			$from = $month.'-01';
			$to = $today;
			$data['cat_result'] = $this->db->query("SELECT * FROM `cat_result` WHERE `designer` = '$dId' AND `ddate` BETWEEN '$from' AND '$to'")->result_array();
			$data['rev_sold'] = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `designer` = '$dId' AND `ddate` BETWEEN '$from' AND '$to'")->result_array();
		}else{
			$data['cat_result'] = $this->db->get_where('cat_result',array('designer'=>$dId, 'ddate'=>$today))->result_array();
			$data['rev_sold'] = $this->db->get_where('rev_sold_jobs',array('designer'=>$dId, 'ddate'=>$today))->result_array();
		}
		
		$this->load->view('new_designer/reports', $data);
	}
	
	public function profile_edit()
	{
		if(isset($_POST['submit']))
		{
			$data = array(
						'name' => $_POST['name'],
						'gender' => $_POST['gender'], 
						'mobile_no' => $_POST['mobile_no'],
						'Join_location' => $_POST['Join_location'],
						'Work_location' => $_POST['Work_location'],
						);
			$this->db->where('id', $this->session->userdata('dId'));
			$this->db->update('designers', $data);
			
			redirect('new_designer/home/change');
		}		
		$this->load->view('new_designer/profile_edit');
	}
	
	public function image()
	{
		$uploadDir = "images/designers/".$this->session->userdata('dId')."/";
		
		if(isset($_POST['Submit_Img']))
		{
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES['Photo']["name"]);
			$extension = end($temp);
			if ((($_FILES['Photo']['type'] == "image/gif")
			|| ($_FILES['Photo']['type'] == "image/jpeg")
			|| ($_FILES['Photo']['type'] == "image/jpg")
			|| ($_FILES['Photo']['type'] == "image/pjpeg")
			|| ($_FILES['Photo']['type'] == "image/x-png")
			|| ($_FILES['Photo']['type'] == "image/png"))
		//	&& ($_FILES['Photo']['size'] < 30000)
			&& in_array($extension, $allowedExts))
			{
				$fileName = $_FILES['Photo']['name'];
				$tmpName  = $_FILES['Photo']['tmp_name'];
				$fileSize = $_FILES['Photo']['size'];
				$fileType = $_FILES['Photo']['type'];
				
				if (@mkdir($uploadDir,0777))
				{}
				
				$filePath = $uploadDir . 'profile.png';
				$result = move_uploaded_file($tmpName, $filePath);
				
							
				if (!$result) {
					$data['error']= "Error uploading file";
					exit;
				}
			
				$data = array('image' => $filePath);
				
				$this->db->where('id', $this->session->userdata('dId'));
				$this->db->update('designers', $data); 
				
				//redirect('new_designer/home/change');
				redirect('new_designer/home/profile_edit');
			}else{ $data['error']= "Invalid file type";}
		}
		$this->load->view('new_designer/profile_edit',$data);
		
	}
	
	public function jobtrack()
	{
	
		if(isset($_POST["submit"]))
		{
			$job_status = $_POST['submit'];
			$id = $_POST['id'];
			
			$data = array(
               
               'job_status' => $job_status,
              );

			$this->db->where('id', $id);
			$this->db->update('orders_dup', $data); 
			
		}	
		$designer_id = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
		$order_id = $this->db->get_where('orders_dup',array('designer' => $designer_id[0]['username'], 'job_status' => 'unchecked' ))->result_array();
		$count = $this->db->get_where('orders_dup',array('designer' => $designer_id[0]['username'], 'job_status' => 'unchecked'))->num_rows();
		//$p_id = $this->db->get_where('publications',array('id' => $order_id[0]['publication_id']))->result_array();
		//$cat = $this->db->get('cat_minmax')->result_array();
		$data['order_id']=$order_id;
		$data['designer_id']=$designer_id;
		//$data['team']=$team;
		//$data['cat']=$cat;
		//$data['p_id']=$p_id;
		$data['count']=$count;
		
		
		$this->load->view('new_designer/job-assign',$data);
	}
	
	public function dp_tool01()
	{
		$data['hi']= "hi";
		$data['jobs'] = $this->db->get_where('cat_result',array('designer' => $this->session->userdata('dId'), 'ddate' => date('Y-m-d') ))->result_array();
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
			
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');
				
		$this->form_validation->set_rules('id', 'Order id', 'trim');
				
		$this->form_validation->run();
			
			
		if(isset($_POST['id']))
		{
			if(!empty($_POST['id']))
			{
				$cat = $this->db->get_where('cat_result',array('order_no' => $_POST['id']))->result_array();
				$slug_type = $this->db->get('cat_newspaper');
				//$status_check = $this->db->get_where('status_check',array('order_id' => $_POST['id']))->result_array();
				
				if(!$cat)
				{
					$this->session->set_flashdata("message","Order: ".$_POST['id']." not found!!");
					redirect('new_designer/home/dp_tool01');
				}
				else
				{
					if($cat[0]['cancel']!='0')
					{
						$this->session->set_flashdata("message","Order: ".$_POST['id']." Cancelled.. Slug not allowed!!");
						redirect('new_designer/home/dp_tool01');
					}
					if($cat[0]['slug'] == 'none' || $cat[0]['slug'] == "" )
					{				
						
						$st_time = 	date("H:i:s");
						$data['st_time'] = $st_time;
						
					}else{ $data['slug_exists']='yes'; }
						$version = 'V1' ;
							if($cat[0]['slug_type'] == '1')
							$slug = $cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
							elseif($cat[0]['slug_type'] == '2')
							$slug = $cat[0]['job_name'];
							elseif($cat[0]['slug_type'] == '3')
							$slug = $cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
							elseif($cat[0]['slug_type'] == '4')
							$slug = $cat[0]['order_no']."-".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."-".$version;
							elseif($cat[0]['slug_type'] == '5')
							$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
							elseif($cat[0]['slug_type'] == '6')
							$slug = $cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
							elseif($cat[0]['slug_type'] == '7')
							$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
							elseif($cat[0]['slug_type'] == '8')
							$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
							elseif($cat[0]['slug_type'] == '9')
							$slug = $cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_V1";
							elseif($cat[0]['slug_type'] == '10')
							$slug = $cat[0]['advertiser']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
							else{
								$this->session->set_flashdata("message","Slug undefined for this slug type....<br/> provide valid slug type for Publication.");
								redirect('new_designer/home/dp_tool01');
							} 
							
						if(isset($_POST['slug']))
						{
							$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
							$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
							if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; } 
				
							if($cat[0]['slug'] == 'none' || $cat[0]['slug'] == "" )
							{
								$dataa = array(
										'designer' => $this->session->userdata('dId'),
										'dlocation' => $this->session->userdata('dLoc'),
										'version' => 'V1', 
										'slug' => $_POST['slug'],
										'ddate' => date('Y-m-d'),
										'start_time' => $st_time,
										'shift_factor' => $tot_shift,
										//'designer_dp_id' => $designer_dp[0]['id'],
											
										);

								$this->db->where('order_no', $_POST['id']);
								$this->db->update('cat_result', $dataa); 
							
								$dataaa = array(
										'order_no' => $_POST['id'],
										'cat_result_id' => $cat[0]['id'], 
										);
								$this->db->insert('QA', $dataaa);
							 
							}
							
							//order status
							$post_status = array('status' => '3');
							$this->db->where('id', $_POST['id']);
							$this->db->update('orders', $post_status);
							
							//Live_tracker Updation
							$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$_POST['id']."' ")->row_array();
							if(isset($update_order['id'])){
								$tracker_data = array('status' => '3', 'designer_id' => $this->session->userdata('dId'));
								$this->db->where('id', $update_order['id']);
								$this->db->update('live_orders', $tracker_data);
							}
							redirect('new_designer/home/dp_tool01');
						}
						
						$data['slug'] = $slug;
						$data['cat'] = $cat;
				}
					
			}			
		}
		$this->load->view('new_designer/dp-view01',$data);
	}
	
	public function job_list()
	{
		$tday= date('Y-m-d 23:59:59');
		$ystday = date('Y-m-d 00:00:00', strtotime(' -5 day'));
		$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
										FROM `orders` WHERE  `help_desk` = '2' AND (`created_on` BETWEEN '$ystday' AND '$tday') ;")->result_array();
		$data['orders'] = $orders;
		
		$this->load->view('new_designer/job-list',$data);
	}	
	
	public function it_support()
	{
		$this->load->view('new_designer/it-support');
	}
	
	public function trouble_ticket()
	{
		if(!empty($_POST['cname']) && !empty($_POST['IT_problem']) && !empty($_POST['description']))
		{
			$data = array(
							'designer' => $this->session->userdata('dId'),
							'cname' => $_POST['cname'], 
							'IT_problem' => $_POST['IT_problem'],
							'description' => $_POST['description'],
						);
			$this->db->insert('trouble_ticket', $data);
		}
		$this->load->view('new_designer/admin-support');
	}
	
	public function admin_support()
	{
		if(!empty($_POST['department']) && !empty($_POST['description']))
		{
			$data = array(
							'designer' => $this->session->userdata('dId'),
							'department' => $_POST['department'], 
							'description' => $_POST['description'],
						);
			$this->db->insert('admin_support', $data);
		}
		$this->load->view('new_designer/admin-support');
	}
		 
	public function revision()
	{
		$data['hi'] = "hi";
		
		if(!empty($_POST['id']))
		{
			$check = $this->db->get_where('ptrands',array('text' => $_POST['id'], 'category' => 'REVISION'))->result_array();
			if(!$check)
			{
				
				$tday = date('Y-m-d');
				$time = date("H:i:s");
				
				$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
				$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
				if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; }
				$data = array(
								'text' => $_POST['id'],
								'designer' => $this->session->userdata('dId'),
								'csr' => $_POST['csr'],
								'date' => $tday,
								'time' => $time,
								'category' => 'REVISION',
								'shift_factor' => $tot_shift,
							);
				$this->db->insert('ptrands', $data);
				$data['r_status'] = "Submitted";
			}else{
				$data['r_status'] = "Already Revised";
			}
		}
		$data['csr'] = $this->db->query('SELECT * FROM `csr` ORDER BY `name` ASC;')->result_array();
		$this->load->view('new_designer/revision',$data);
	}
		
	public function sold()
	{
		$data['hi'] = "hi";
		if(!empty($_POST['id']))
		{
			$check = $this->db->get_where('ptrands',array('text' => $_POST['id'], 'category' => 'SOLD'))->result_array();
			if(!$check)
			{
				
				$tday = date('Y-m-d');
				$time = date("H:i:s");
				
				$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
				$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
				if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; }
				$data = array(
								'text' => $_POST['id'],
								'designer' => $this->session->userdata('dId'),
								'date' => $tday,
								'time' => $time,
								'category' => 'SOLD',
								'shift_factor' => $tot_shift,
							);
				$this->db->insert('ptrands', $data);
				$data['s_status'] = "Submitted";
			}else{
				$data['s_status'] = "Already Sold";
			}
		}
		$data['csr'] = $this->db->query('SELECT * FROM `csr` ORDER BY `name` ASC;')->result_array();
		//$this->load->view('new_designer/sold',$data);
		$this->load->view('new_designer/revision',$data);
	}

	public function production()
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
		}
		$designer = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array() ;
		$data['designer'] = $designer;
		$data['ystday'] = $ystday;
		$this->load->view('new_designer/production-table',$data);
	}
	
	public function error()
	{ 
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['from'] = $from;
			$data['to'] = $to;
			 
		}
		$tday= date('Y-m-d');
		$ystday = date('Y-m-d', strtotime(' -1 day'));
		$pystday = date('Y-m-d', strtotime(' -2 day'));
		$designer = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
		
		$data['tday'] = $tday;
		$data['ystday'] = $ystday;
		$data['pystday'] = $pystday;
		$data['designer'] = $designer;
		
		$this->load->view('new_designer/error',$data);
	}
	
	public function links()
	{
		$this->load->view('new_designer/links');
	}
	
	public function rev_status($form = '')
	{
		$data['hi']='hi';
		if($form!='')
		{
			//if(isset($_POST['date'])){ $data['date'] = $_POST['date']; }
			if(isset($_POST['Submit']))
			{
				$status_check = $this->db->get_where('status_check',array('id' => $_POST['id']))->result_array();
				$cat = $this->db->get_where('cat_result',array('id' => $status_check[0]['cat_id']))->result_array();
				if($status_check)
				{
					foreach($status_check as $row)
					{
						$version = $status_check[0]['version'];
								
						if($cat[0]['slug_type'] == '1')
						$slug = $cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
						elseif($cat[0]['slug_type'] == '2')
						$slug = $cat[0]['job_name'];
						elseif($cat[0]['slug_type'] == '3')
						$slug = $cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
						elseif($cat[0]['slug_type'] == '4')
						$slug = $cat[0]['order_no']."-".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."-".$version;
						elseif($cat[0]['slug_type'] == '5')
						$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
						elseif($cat[0]['slug_type'] == '6')
						$slug = $cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
						elseif($cat[0]['slug_type'] == '7')
						$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
						elseif($cat[0]['slug_type'] == '8')
						$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
						elseif($cat[0]['slug_type'] == '9')
						$slug = $cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_V1";
						elseif($cat[0]['slug_type'] == '10')
						$slug = $cat[0]['advertiser']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
						else{
							echo "slug undefined for this slug type....<br/> provide valid slug type for Publication....";
							exit();
							} 
					}
					$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
					$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
					if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; }		
					$data = array(
								'designer' => $this->session->userdata('dId'),
								'dlocation' => $this->session->userdata('dLoc'),
								'slug' => $slug,
								'status' => 'with_designer',
								'shift_factor' => $tot_shift,
								);

					$this->db->where('id', $_POST['id']);
					$this->db->update('status_check', $data); 
							
				}
			}
			
			if(isset($_POST['select']))
			{
				$data = array('QA_check' => $_POST['QA_check'],
							  'status' => 'QA_complete',	
							  );

					$this->db->where('id', $_POST['id']);
					$this->db->update('status_check', $data);
			}
			
			
			$today = date('Y-m-d');
			$data['today'] = $today;
			$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
			$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
			$data['rep'] = $this->db->get('csr')->result_array(); 
			if(isset($_POST['date']))
			{
				$data['date'] = $_POST['date'];
				$data['rev_status'] = $this->db->query("SELECT * FROM `status_check` WHERE `version`!='V1' AND `help_desk`='".$form."' AND `date` LIKE '".$_POST['date']."%';")->result_array();
			}else{ 
				$data['rev_status'] = $this->db->query("SELECT * FROM `status_check` WHERE `version`!='V1' AND `help_desk`='".$form."' AND `date` LIKE '".$today."%';")->result_array();
			}
			$data['form'] = $form ;
		}	
		$this->load->view('new_designer/rev-status',$data);
	}
		
	public function shift_factor()
	{
		
		$date = date('Y-m-d');
		if(isset($_POST['submit']))
		{
			$time = date("H:i:s");
			
			$data = array(  'designer' => $this->session->userdata('dId'), 
							'hours' => $_POST['shift_factor'], 
							'date' => $date,
							'time' => $time,
							'status' => 'pending'
						 );
			$this->db->insert('designer_additional_hours', $data);
		}
		$data['designers'] = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => $date))->result_array();
		//$data['request'] = $this->db->get_where('designer_additional_hours',array('id' => $this->session->userdata('dId'), 'status' => 'pending'))->result_array();
		$dname = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
		$dlocation = $this->db->get_where('location',array('id' => $dname[0]['Join_location']))->result_array();
		$data['dname'] = $dname[0];
		$data['dlocation'] = $dlocation[0];
		$this->load->view('new_designer/shift-factor',$data);
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
				$sql = $this->db->get_where('cat_result',array('category' => $rows['name'], 'designer' => $this->session->userdata('dId')))->result_array();
			}elseif(isset($_POST['prevmonth']))
			{
				$dte = date('Y-m', strtotime(' -1 month'));
				$dated = date('M Y', strtotime(' -1 month'));
				$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `category` = '".$rows['name']."' AND `designer` = '".$this->session->userdata('dId')."' AND `date` LIKE '$dte%' ")->result_array();
				
			}elseif(isset($_POST['last3month']))
			{
				$from = date('Y-m-01', strtotime(' -2 month'));
				$to = date('Y-m-d');
				$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
				$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `category` = '".$rows['name']."' AND `designer` = '".$this->session->userdata('dId')."' AND (`date` BETWEEN '$from' AND '$to') ")->result_array();
				
			}else{
				$dte = date('Y-m');
				$dated = date('M Y');
				$sql = $this->db->query("SELECT * FROM `cat_result` WHERE `category` = '".$rows['name']."' AND `designer` = '".$this->session->userdata('dId')."' AND `date` LIKE '$dte%' ")->result_array();
				
			}
			
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
        $this->load->view('new_designer/chart', $data);
		
	}
	
	public function QA_error_chart()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$err_type = $this->db->get('dp_error_type')->result_array();
		foreach($err_type as $rows)
		{			
			$sql = $this->db->get_where('cp_error_result',array('error_type' => $rows['id'], 'designer' => $this->session->userdata('dId')))->result_array();
			
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
		
        $this->load->view('new_designer/chart');
		
	}
	
	public function col_chart()
    {
		$this->load->library('gcharts');
		$this->gcharts->load('ColumnChart');
		
		$this->gcharts->DataTable('orders')
              ->addColumn('date', 'Year', 'month')
              ->addColumn('number', 'Total NJ', 'tot_NJ');
			  
		$s = $this->db->query("SELECT * FROM `Designer_Production` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['date']; 
		 
		$created_on= '2019-01-01 12:11:20';
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
	
			$sql = $this->db->query("SELECT * FROM `Designer_Production` WHERE `designer` = '".$this->session->userdata('dId')."' AND `date` LIKE '$dt%' ")->result_array();
			$tot_NJ = 0; $avg = 0;
			foreach($sql as $rows1)
			{
				$tot_NJ = $tot_NJ + $rows1['tot_NJ'];
			}
			if(count($sql)!='0'){ $avg = $tot_NJ / count($sql);}
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

		$this->load->view('new_designer/column_chart');
	}
		
	public function NJ_chart()
	{
		$this->load->library('gcharts');
		$this->gcharts->load('LineChart');


		$dataTable = $this->gcharts->DataTable('orders');

		$dataTable->addColumn('date', 'Year', 'month');
		$dataTable->addColumn('number', 'Total NJ', 'tot_NJ');
		
		$s = $this->db->query("SELECT * FROM `Designer_Production` ORDER BY `id` DESC LIMIT 1")->result_array();
		$created_on= '2019-01-01 12:11:20';
		$date_ts = date('Y-m-d', strtotime($created_on));

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
	
			$sql = $this->db->query("SELECT * FROM `Designer_Production` WHERE `designer` = '".$this->session->userdata('dId')."' AND `date` LIKE '$dt%' ")->result_array();
			$tot_NJ = 0; $avg = 0;
			foreach($sql as $rows1)
			{
				$tot_NJ = $tot_NJ + $rows1['tot_NJ'];
			}
			if(count($sql)!='0'){ $avg = $tot_NJ / count($sql);}
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
		$this->load->view('new_designer/line_chart');
	}
	
	public function frontlinetrack_order_list($help_desk_id = '')
	{     
	    $dId = $this->session->userdata('dId');
	    $data['help_desk_id'] = $help_desk_id;
	    $today = date('Y-m-d'); $data['today'] = $today;
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['qystday'] = date('Y-m-d', strtotime(' -3 day'));
// 		$data['designer_details'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
	   $help_desk_detail = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
	   if(isset($help_desk_detail['id'])){
	       if(isset($_POST['create_slug'])){
    			$order_id = $_POST['order_id'];
    			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `job_accept`='1' AND `cancel`='0' ORDER BY `id` DESC LIMIT 1")->row_array();
    			$_POST['prev_slug'] = $rev_orders['order_no'];
    			$_POST['version'] = $rev_orders['version'];
    			$_POST['id'] = $rev_orders['id'];
    			$return_msg = $this->Qrevision_slug();
    			$this->session->set_flashdata("message",$return_msg);
    			redirect('new_designer/home/orderview/'.$help_desk_id.'/'.$order_id);
    	    }
		   if(isset($_GET['display_type'])){ $display_type = $_GET['display_type'];  }else{ $display_type = 'all'; } 
	       if(isset($_GET['date'])){ $order_date = $_GET['date'];  }else{ $order_date = $today; }
	       $data['date'] = $order_date;
           $data['display_type'] = $display_type;
           if($help_desk_detail['adwit_teams_id'] != 0){
                 $this->load->view('new_designer/frontlinetrack_order_list',$data);
           }else{
               $this->session->set_flashdata('message', 'No Teams assigned for Help Desk.');  
               redirect('new_designer/home/Qrevision');
           }
	   }
	 
	}
	
	public function Qrevision($form = '')
	{
	    if($form >= 23 ){ redirect('new_designer/home/frontlinetrack_order_list/'.$form); }
		if(isset($_POST['create_slug']))
		{
			$order_id = $_POST['order_id'];
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `job_accept`='1' AND `cancel`='0' ORDER BY `id` DESC LIMIT 1")->row_array();
			$_POST['prev_slug'] = $rev_orders['order_no'];
			$_POST['version'] = $rev_orders['version'];
			$_POST['id'] = $rev_orders['id'];
			$return_msg = $this->Qrevision_slug();
			$this->session->set_flashdata("message",$return_msg);
			redirect('new_designer/home/orderview/'.$form.'/'.$order_id);
		}
		
		if(isset($_POST['yday'])){
			//$from = date('Y-m-d', strtotime(' -2 day'));
			$to = date('Y-m-d', strtotime(' -1 day'));
		}elseif(isset($_POST['pday'])){
			//$from = date('Y-m-d', strtotime(' -3 day'));
			$to = date('Y-m-d', strtotime(' -2 day'));
		}else{
			//$from = date('Y-m-d');
			$to = date('Y-m-d');
		}
				
		$data['today'] = date('Y-m-d');
		$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
		$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
		$data['to'] = $to;
		//$data['from'] = $from;
		
		if($form!=''){
			$dId = $this->session->userdata('dId');
			$data['form'] = $form;
			$this->db->order_by("id", "asc");
			$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array(); 
			$query = "SELECT rev_sold_jobs.*, orders.order_type_id  FROM rev_sold_jobs
	                JOIN `orders` ON orders.id = rev_sold_jobs.order_id ";
	       if($form == '20'){ //if pagination help desk display oly pagination orders irrespective of hd
                $query .= "WHERE rev_sold_jobs.order_id != '' AND orders.order_type_id = '6' AND rev_sold_jobs.job_accept = '1' AND rev_sold_jobs.date = '$to'";    
            }else{
                $query .= "WHERE rev_sold_jobs.order_id != '' AND rev_sold_jobs.help_desk = '$form' AND orders.order_type_id != '6' AND rev_sold_jobs.job_accept = '1' AND rev_sold_jobs.date = '$to'";
            }
			$data['orders_rev'] = $this->db->query($query)->result_array();
			$data['designer_alias'] = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
			
			$this->load->view('new_designer/Qrevision', $data);
		}else{
			$this->load->view('new_designer/Qrevision_desk', $data);
		}
	}
	
	public function Qrevision_slug()
	{
		if(isset($_POST['create_slug']))
		{	
			$cat = $this->db->get_where('cat_result',array('order_no' => $_POST['order_id']))->result_array();
			//check slug created or not
			$rev_check = $this->db->get_where('rev_sold_jobs',array('id' => $_POST['id'], 'new_slug' => 'none'))->result_array();
			if(isset($rev_check[0]['id'])){
				if(isset($_POST['sold']) && !empty($_POST['sold'])){
					$slug = $_POST['prev_slug'];
				}elseif($cat[0]['slug_type'] == '1')
					$slug = $cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['job_name']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '2')
					$slug = $cat[0]['job_name'];
				elseif($cat[0]['slug_type'] == '3')
					$slug = $cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '4')
					$slug = $cat[0]['order_no']."-".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."-".$_POST['version'];
				elseif($cat[0]['slug_type'] == '5')
					$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '6')
					$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '7')
					$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '8')
					$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '9')
					$slug = $cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				elseif($cat[0]['slug_type'] == '10')
					$slug = $cat[0]['advertiser']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$_POST['version'];
				else{
					echo "<script>alert('slug undefined for this slug type in Publication...!!')</script>";
					exit();
				} 
				$slug = str_replace(' ', '_', $slug);
				//rev_sold_jobs
				$post = array('designer' => $this->session->userdata('dId'), 'ddate' => date('Y-m-d'), 'new_slug' => $slug, 'status' => '3');
				$this->db->where('id', $_POST['id']);
				$this->db->update('rev_sold_jobs', $post);
				
				//update rev status in orders table(new 21 Apr 2022)
				    $order_rev_status_upadate = array( 'rev_order_status' => '3' ); //Revision InProduction
					$this->db->where('id', $_POST['order_id']);
					$this->db->update('orders', $order_rev_status_upadate);
					
				//Live_tracker Revision Updation
					$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['id']."' ")->row_array();
					if(isset($update_revision['id'])){
						$tracker_data = array('status' => '3');
						$this->db->where('id', $update_revision['id']);
						$this->db->update('live_revisions', $tracker_data);
					}
				//map orders status update via cURL
				if(isset($rev_check[0]['map_revorder_id']) && $rev_check[0]['map_revorder_id'] != NULL && $rev_check[0]['map_revorder_id'] != '0'){
					$fields = array(
									'status' => '3',
									'slug' => $slug,
									'map_revorder_id' => $rev_check[0]['map_revorder_id'],
									);
					//$url = 'http://23.235.222.72/~adwitac/map1/index.php/Cron_jobs/revorder_status_update';
					$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/revorder_status_update';
					$this->curl_post($url, $fields); //API using cURL 
				}
				//echo "<script>alert('New Slug: " . $slug ."')</script>";
				$msg = '<label class="font-red">New Slug: ' . $slug.'</label>';
			}else{
				//echo "<script>alert('Slug already created..')</script>";
				$msg = '<label class="font-red"> Slug already created.. </label>';
			}
			return $msg;
		}
	}
	
	public function Qrevision_search()
	{
		if(isset($_POST['search']) && !empty($_POST['order_id']))
		{
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $_POST['order_id'], 'job_status' => '1'))->result_array();
			if($orders_rev){
				$data['orders_rev'] = $orders_rev;
				$data['form'] = $orders_rev[0]['help_desk'];
				$data['today'] = date('Y-m-d');
				$data['ystday'] = date('Y-m-d', strtotime(' -1 day'));
				$data['pystday'] = date('Y-m-d', strtotime(' -2 day'));
				$data['form_demo'] ="hi";
				$this->load->view('new_designer/Qrevision', $data);
			}else{
				$this->session->set_flashdata("message","Order Details Not Found!!");
				redirect('new_designer/home/Qrevision/');
			}
		}
	}
	
	public function frontline_instruction($rev_id = '')
	{
		$rev_sold = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id, 'job_status' => '1'))->result_array();
		if($rev_sold)
		{
			$data['rev_sold'] = $rev_sold[0];
			$this->load->view('new_designer/frontline_instruction',$data);
		}else{
			$this->session->set_flashdata("message","Order Details Not Found!!");
			redirect('new_designer/home/Qrevision');
		}
	}
	
	public function cshift($form = '', $display_type = '')
	{
		$dId = $this->session->userdata('dId');
		$designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array(); 
		$data['dId'] = $dId;
		$data['display_type'] = $display_type;
		if($form!='')
		{
			$tracker_date = $this->db->query("SELECT * FROM `print_ad_tracker_date` WHERE `hd` = '".$form."'")->result_array();
			$num_days = $tracker_date[0]['num_days'];
			if($num_days != '0'){
				$ystday = date('Y-m-d 00:00:00', strtotime("-$num_days day")); $data['ystday'] = $ystday; //in days
			}else{
				$ystday =  ($tracker_date[0]['date'].' 00:00:00'); $data['ystday'] = $ystday; //in date
			}
			
			//Assign Annex
			if(isset($_POST['submit']) && isset($_POST['cat_id'])){
				foreach($_POST['assign'] as $item) 
				{
					$post = array('assign' => $_POST['submit']);
					$this->db->where('id', $item);
					$this->db->update('cat_result', $post);
				}
			}
			
			//Tag Designer
			if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
				foreach($_POST['assign_designer'] as $item_id) 
				{
					$post1 = array('tag_designer' => $_POST['submit_designer']);
					$this->db->where('id', $item_id);
					$this->db->update('cat_result', $post1);
				}
			}
				$today = date('Y-m-d 23:59:59');
				$data['today'] = $today;
				$data['form'] = $form;
				$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `d_id` = '$dId' ")->result_array();	
				$data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array(); 
				//For Design Pending
				$data['orders'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
													FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//data for Pending design passing to view
				//For all_pending
				$data['orders_pending'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
																FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4' OR `status` ='8')  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All pending
				//For Upload Pending
				$data['orders_upload'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
																	FROM `orders` WHERE `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='3' OR `status`='4') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//data for Pending upload passing to view
				//For design_check
				$data['orders_inproduction'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
																	FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND  `status`='3'  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//design check
				
				//Design Pending count
				$data['design_count'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
				FROM orders 
					left outer join cat_result on orders.id = cat_result.order_no 
						WHERE orders.order_type_id!='1' AND orders.help_desk='$form' AND orders.cancel!='1' AND orders.crequest!='1' AND orders.status='2'
							AND (orders.created_on BETWEEN '$ystday' AND '$today') AND cat_result.pdf_path = 'none' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0')")->num_rows();
				//Upload Pending count
				$data['upload_count'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
				FROM orders 
											left outer join cat_result on orders.id = cat_result.order_no 
												WHERE orders.order_type_id!='1' AND orders.cancel!='1' 
						AND orders.crequest!='1' AND (orders.status='3') AND (orders.created_on BETWEEN '$ystday' AND '$today') AND (cat_result.pro_status = '1' OR cat_result.pro_status = '6' OR cat_result.pro_status = '7')  AND cat_result.designer = '$dId' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0');")->num_rows();
				//Design Check count
				$data['DC_order_count'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
				FROM orders 
												left outer join cat_result on orders.id = cat_result.order_no
													WHERE orders.order_type_id!='1' AND orders.help_desk='".$form."' AND orders.cancel='0' AND orders.crequest!='1' AND orders.status = '3'
														AND (orders.created_on BETWEEN '$ystday' AND '$today') AND (cat_result.pro_status = '2' OR cat_result.pro_status = '8')")->num_rows(); 
				//For All STARTS
				$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
				$ystday_time = $today_date_time[0]['time'];
				$today_time = $today_date_time[1]['time'];
				$tomo_time = $today_date_time[2]['time'];
				$current_date = date("Y-m-d");
				$ysterday = date("Y-m-d", strtotime(' -1 day'));
				$tomo = date("Y-m-d", strtotime(' +1 day'));
				$ct = date("H:i:s");
				if($ct >= '00:00:00' && $ct <= '08:29:59'){
					$data['all_orders'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
					FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
				}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
					$data['all_orders'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
					FROM `orders` WHERE `help_desk`='$form' AND `order_type_id`!='1' AND (`created_on` BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All
				}
				//For All ENDS
				$this->load->view('new_designer/cshift',$data);
		}else{
			$this->load->view('new_designer/cshift_hd',$data);
		} 
	}
	
	public function web_cshift($display_type = '')
	{
		$dId = $this->session->userdata('dId');
		$designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array();		
		$data['dId']= $dId;
		$data['display_type'] = $display_type;
		$data['designers'] = $designers; 
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59';//$today = date('Y-m-d 23:59:59'); 
		$data['today'] = $today;
		//$order_days = $this->db->query("SELECT * FROM `web_ad_tracker_date`")->result_array();
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00';//$ystday = ($order_days[0]['date'].' 00:00:00'); 
		$data['ystday'] = $ystday;
		$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `d_id` = '$dId' ")->result_array();
		$no_of_order = $this->input->post('no_of_order');
		
		if(isset($_POST['submit']) && isset($_POST['cat_id'])){
			foreach($_POST['assign'] as $item){
				 $post = array('assign' => $_POST['submit']);
				 $this->db->where('id', $item);
				 $this->db->update('cat_result', $post);
			}
		}
		//Tag Designer
		if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
			foreach($_POST['assign_designer'] as $item_id) 
			{
				$post1 = array('tag_designer' => $_POST['submit_designer']);
				$this->db->where('id', $item_id);
				$this->db->update('cat_result', $post1);
			}
		}
		//Design Pending

        if($display_type == "design_pending"){
		   /* $data['orders'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//data for Pending design passing to view
*/      
        $order_by = null;
        $sort_by = null;
        if(isset($_POST['d_order_by'])){
                   $order_by  =  $_POST['d_order_by'];
                   $this->session->set_userdata("d_order_by",$order_by);
                }
                if(isset($_POST['d_sort_by'])){
                    $sort_by = $_POST['d_sort_by'];
                    $this->session->set_userdata("d_sort_by",$sort_by);
                }
		#pagination code starts here
		$config = array();
		$config["base_url"] = base_url() . "index.php/new_designer/home/web_cshift/design_pending/";
		if($this->input->post('design_pending_search') != null){
			$search = $this->input->post('design_pending_search');
			$this->session->set_userdata('pending_search_val', $search);
			$config["total_rows"] = $this->Pagination->get_pending_ad_count($ystday,$today,$dId,$search);
		}else if($this->session->userdata("pending_search_val") !== "" && $this->input->post('design_pending_search') == null){
			$search =  $this->session->userdata("pending_search_val");
			$config["total_rows"] = $this->Pagination->get_pending_ad_count($ystday,$today,$dId,$search);
		}else{
			$config["total_rows"] = $this->Pagination->get_pending_ad_count($ystday,$today,$dId,null);
		}
		
		if($no_of_order != "" && $no_of_order != null){
		  	$config["per_page"] = $no_of_order;  
		  	$this->session->set_userdata('pending_no_of_orders', $no_of_order);
		}else if($no_of_order == "" && $this->session->userdata('pending_no_of_orders') != ""){
		    $config["per_page"] = $this->session->userdata('pending_no_of_orders');
		}else{
		    unset($_SESSION['pending_no_of_orders']);
		   	$config["per_page"] = 25; 
		} 
		
		$config["uri_segment"] = 5;
		$this->get_pagination_config($config);
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		if($this->input->post('design_pending_search') != null){
			$search = $this->input->post('design_pending_search');
			$data["orders"] = $this->Pagination->
			get_design_pending_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
		}else if($this->session->userdata("pending_search_val") != "" && $this->input->post('design_pending_search') == null){
			$search =  $this->session->userdata("pending_search_val");
			$data["orders"] = $this->Pagination->
			get_design_pending_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
			
		}else{
			$data["orders"] = $this->Pagination->
			get_design_pending_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,null);
		} 
		$data["design_pending_links"] = $this->pagination->create_links();
		#pagination code ends here
		
		    
		}
        
		//upload_pending
		 if($display_type == "upload_pending"){
		/*$data['orders_upload'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='3' OR `status`='4') AND `crequest`!='1' AND `cancel`!='1';")->result_array();//data for Pending upload passing to view
		*/ 
		
		$order_by = null;
        $sort_by = null;
        if(isset($_POST['wu_order_by'])){
                   $order_by  =  $_POST['wu_order_by'];
                   $this->session->set_userdata("wu_order_by",$order_by);
                }
                if(isset($_POST['wu_sort_by'])){
                    $sort_by = $_POST['wu_sort_by'];
                    $this->session->set_userdata("wu_sort_by",$sort_by);
                }
		 #pagination code starts here
		$config = array();
		$config["base_url"] = base_url() . "index.php/new_designer/home/web_cshift/upload_pending/";
		if($this->input->post('udesign_pending_search') != null){
			$search = $this->input->post('udesign_pending_search');
			$this->session->set_userdata('upending_search_val', $search);
			$config["total_rows"] = $this->Pagination->get_upending_ad_count($ystday,$today,$dId,$search);
		}else if($this->session->userdata("upending_search_val") !== "" && $this->input->post('udesign_pending_search') == null){
			$search =  $this->session->userdata("upending_search_val");
			$config["total_rows"] = $this->Pagination->get_upending_ad_count($ystday,$today,$dId,$search);
		}else{
			$config["total_rows"] = $this->Pagination->get_upending_ad_count($ystday,$today,$dId,null);
		}
		
		if($no_of_order != "" && $no_of_order != null){
		  	$config["per_page"] = $no_of_order;  
		  	$this->session->set_userdata('upending_no_of_orders', $no_of_order);
		}else if($no_of_order == "" && $this->session->userdata('upending_no_of_orders') != ""){
		    $config["per_page"] = $this->session->userdata('upending_no_of_orders');
		}else{
		    unset($_SESSION['upending_no_of_orders']);
		   	$config["per_page"] = 25; 
		} 
		
		$config["uri_segment"] = 5;
	    $this->get_pagination_config($config);
	    
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		if($this->input->post('udesign_pending_search') != null){
			$search = $this->input->post('udesign_pending_search');
			$data["orders_upload"] = $this->Pagination->
			get_udesign_pending_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
		}else if($this->session->userdata("upending_search_val") != "" && $this->input->post('udesign_pending_search') == null){
			$search =  $this->session->userdata("upending_search_val");
			$data["orders_upload"] = $this->Pagination->
			get_udesign_pending_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,$search);
			
		}else{
			$data["orders_upload"] = $this->Pagination->
			get_udesign_pending_ad($config["per_page"], $page,$ystday,$today,$sort_by,$order_by,null);
		} 
		$data["udesign_pending_links"] = $this->pagination->create_links();
		#pagination code ends here
		     
		 }
		//Upload Pending count
		$data['upload_count'] = $this->db->query("SELECT orders.id FROM orders 
											    LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
												WHERE orders.order_type_id = '1' AND orders.cancel!='1' 
						                        AND orders.crequest!='1' AND (orders.status='3' OR orders.status='4') 
						                        AND (orders.created_on BETWEEN '$ystday' AND '$today') 
						                        AND (cat_result.pro_status = '1' OR cat_result.pro_status = '3' OR cat_result.pro_status = '6' OR cat_result.pro_status = '7')  
						                        AND cat_result.designer = '$dId' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0');")->num_rows();
		//Design Pending count
		$data['design_count'] = $this->db->query("SELECT orders.id FROM orders 
					                                LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
						                            WHERE orders.order_type_id = '1' AND orders.cancel!='1' AND orders.crequest!='1' AND orders.status='2'
							                        AND (orders.created_on BETWEEN '$ystday' AND '$today') AND cat_result.pdf_path = 'none' 
							                        AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0')")->num_rows();
		
		//web_design_check
		$data['orders_inproduction'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND  `status`='3'  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//design check
		
		//web_all_pending
		$data['orders_pending'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4')  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All pending
		
		$this->load->view('new_designer/web_cshift',$data);
	}
	
	public function attachments($form = '', $id = '')
	{
		if($id != '')
		{
			$order = $this->db->get_where('orders',array('id' => $id))->result_array();
			if($order && $order[0]['file_path']!='none')
			{
				$soft_attachments = $this->db->get_where('soft_attachments',array('order_no' => $id))->result_array();
				if($soft_attachments){ $data['soft_attachments'] = $soft_attachments; }
				$data['order'] = $order[0];
				$this->load->view('new_designer/attachments',$data);
			}else{
				$this->session->set_flashdata('message','No Attachments For Order : '.$id);
				redirect('new_designer/home/live_new_ads');//redirect('new_designer/home/cshift/'.$form);
			}
		}
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
	
	public function cshift_search() 
	{
		if(isset($_POST['search']) && !empty($_POST['id'])){	
			$order = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
			FROM `orders` WHERE (`id`='".$_POST['id']."' OR `job_no`='".$_POST['id']."') AND `cancel`='0' ;")->result_array();
			if(isset($order[0]['id'])){
				$order_id = $order[0]['id'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='".$order_id."' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ 
					redirect('new_designer/home/orderview/'.$order[0]['help_desk'].'/'.$order_id);
				}else{
					redirect('new_designer/home/orderview/'.$order[0]['help_desk'].'/'.$order_id);
				}
			}else{
				$this->session->set_flashdata("message","Order not Found!!");
				redirect('new_designer/home/live_new_ads');//redirect('new_designer/home/cshift');
			}
		}
	}
	/* {
		if(isset($_POST['search']) && !empty($_POST['id'])){
			$order = $this->db->query("SELECT * FROM `orders` WHERE (`id`='".$_POST['id']."' OR `job_no`='".$_POST['id']."') AND `cancel`='0' ;")->result_array();
			if($order){
				$order_id = $order[0]['id'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='".$order_id."' ORDER BY `id` DESC LIMIT 1;")->result_array();
				$hd = $order[0]['help_desk'];
				$data['form'] = $hd;
				$data['order'] = $order;
				if($rev_orders){ 
					redirect('new_designer/home/orderview/'.$hd.'/'.$order_id);
				}else{
					redirect('new_designer/home/orderview/'.$hd.'/'.$order_id);	
				}
				//$this->load->view('new_designer/cshift_search',$data);
			}else{
				$this->session->set_flashdata("message","Order not Found!!");
				redirect('new_designer/home/cshift/'.$form);
			}
		}
	} */
	
	public function cshift_dptool($form='', $id = '') 
	{
		if($id!='')
		{
			$cat = $this->db->get_where('cat_result',array('order_no' => $id))->result_array();
			
			if(isset($_POST['confirm']) && isset($_POST['slug']))
			{
				
				$st_time = 	date("H:i:s");
				
				$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
				$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
				if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; } 
				
				if($cat[0]['slug'] == 'none' || $cat[0]['slug'] == "" )
				{
					$dataa = array(
									'designer' => $this->session->userdata('dId'),
									'dlocation' => $this->session->userdata('dLoc'),
									'version' => 'V1', 
									'slug' => $_POST['slug'],
									'ddate' => date('Y-m-d'),
									'start_time' => $st_time,
									'shift_factor' => $tot_shift,
									);

					$this->db->where('order_no', $_POST['id']);
					$this->db->update('cat_result', $dataa); 
							
					$dataaa = array(
									'order_no' => $_POST['id'],
									'cat_result_id' => $cat[0]['id'], 
									);
					$this->db->insert('QA', $dataaa);
							 
				}else{ 
					$this->session->set_flashdata("message","Slug for : ".$id." Already Exists!!");
					redirect('new_designer/home/live_new_ads');//redirect('new_designer/home/cshift/'.$form);
				}
				
				//order status
				$post_status = array('status' => '3');
				$this->db->where('id', $id);
				$this->db->update('orders', $post_status);
				
				//Live_tracker Updation
				$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$id."' ")->row_array();
				if(isset($update_order['id'])){
						$tracker_data = array('status' => '3', 'designer_id' => $this->session->userdata('dId'));
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
				}
				
				$this->session->set_flashdata("message","Slug : ".$_POST['slug']);			
				redirect('new_designer/home/live_new_ads'); //redirect('new_designer/home/cshift/'.$form);
			}
			
			$data['jobs'] = $this->db->get_where('cat_result',array('designer' => $this->session->userdata('dId'), 'ddate' => date('Y-m-d') ))->result_array();
			//$slug_type = $this->db->get('cat_newspaper');
			//$status_check = $this->db->get_where('status_check',array('order_id' => $_POST['id']))->result_array();
			
			if($cat[0]['cancel']!='0')
			{
				$this->session->set_flashdata("message","Order: ".$id." Cancelled.. Slug not allowed!!");
				redirect('new_designer/home/live_new_ads'); //redirect('new_designer/home/cshift/'.$form);
			}
			
			$version = 'V1';
			
			if($cat[0]['slug_type'] == '1')
					$slug = $cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
			elseif($cat[0]['slug_type'] == '2')
					$slug = $cat[0]['job_name'];
			elseif($cat[0]['slug_type'] == '3')
					$slug = $cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
			elseif($cat[0]['slug_type'] == '4')
					$slug = $cat[0]['order_no']."-".$cat[0]['news_initial']."[".$cat[0]['category']."]_".$this->session->userdata('designer')."-".$version;
			elseif($cat[0]['slug_type'] == '5')
					$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
			elseif($cat[0]['slug_type'] == '6')
					$slug = $cat[0]['job_name']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
			elseif($cat[0]['slug_type'] == '7')
					$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
			elseif($cat[0]['slug_type'] == '8')
					$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_".$version;
			elseif($cat[0]['slug_type'] == '9')
					$slug = $cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_[".$cat[0]['category']."]_".$this->session->userdata('designer')."_V1";
			elseif($cat[0]['slug_type'] == '10')
					$slug = $cat[0]['advertiser']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
			else{
					$this->session->set_flashdata("message","Slug undefined for this slug type....<br/> provide valid slug type for Publication.");
					redirect('new_designer/home/dp_tool01');
			} 
			$data['id'] = $id;
			$data['slug'] = $slug;
			$data['cat'] = $cat;
			$this->load->view('new_designer/cshift_dptool', $data);
		}
	}
	
	public function sign_out()
	{
		$this->load->view('new_designer/sign-out');
	}
	
	public function my_profile($num_days='')
	{ 	
	    $today = date('Y-m-d');
		$data['today'] = $today;
		$dId = $this->session->userdata('dId');
		if($num_days!=''){
			if($num_days == 'curr_month'){
				$data['from'] = $from = date('Y-m-01');
				$data['to'] = $to =  date('Y-m-d');
			}elseif($num_days == 'prev_month'){
				$data['from'] = $from = date('Y-m-01', strtotime(' -1 month'));
				$data['to'] = $to = date("Y-m-d", strtotime("last day of previous month"));
			}else{
				$data['from'] = $from = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
				$data['to'] = $to = date('Y-m-d');
			}
			$q = "SELECT cat_result.category, COUNT(cat_result.id) AS ad_count FROM cat_result 
		            WHERE cat_result.designer = '$dId' AND cat_result.ddate BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY cat_result.category;";
		    $rev_q = "SELECT * FROM `rev_sold_jobs` WHERE  `designer`='$dId' AND `date` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;";        
		}else{
		    $q = "SELECT cat_result.category, COUNT(cat_result.id) AS ad_count FROM cat_result 
		            WHERE cat_result.designer = '$dId' AND cat_result.ddate = '$today' GROUP BY cat_result.category;";
		    $rev_q = "SELECT * FROM `rev_sold_jobs` WHERE  `designer`='$dId' AND `date`='$today' ;";
		}
		//echo $q;
		$data['cat_result'] = $this->db->query($q)->result_array();
		$data['rev_sold'] = $this->db->query($rev_q)->result_array();
		$data['num_days'] = $num_days;
		$data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$dId' AND `is_active`='1' ")->row_array();
		
		$this->load->view('new_designer/my_profile', $data);
	}
		
	public function lock()
	{
	    $data['hi']="hi";
	    if(!empty($_POST['password']))
		 {
		 $check = $this->db->get_where('designers',array('password' =>md5($_POST['password']), 'id'=>($_POST['aid'])))->result_array();
		 if($check==true)
		 {
		redirect('new_designer/home');
		 } else { $data['psd'] = "Wrong Password Please Try Again!!";}
		 }
		$this->load->view('new_designer/lock', $data);
	}
	
    public function help()
	{
		$this->load->view('new_designer/help');
	}
	
	public function orderview($hd="", $order_id="", $value="")
	{
	    // Mood Board/Theme Code starts 
		$order_mood = $this->db->query("SELECT * FROM `order_mood` WHERE `order_id`= '$order_id' ")->row_array();
		if(isset($order_mood['id'])){
			$data['order_mood'] = $order_mood;
				if(file_exists($order_mood['path'])){
					$data['moodboard_path'] = $order_mood['path'];
					$data['moodboard_filename'] = basename($data['moodboard_path']);
				}
		}
		//Mood Board/Theme Code ends
		$designer_alias = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
		$redirect = 'new_designer/home/orderview/'.$hd.'/'.$order_id;
		if($designer_alias[0]['club_id'] != null) {
			$redirect_cshift = 'new_designer/home/live_new_ads';	//redirect to live_new_ads page
		}elseif($orders[0]['order_type_id']=='1'){
			$redirect_cshift = 'new_designer/home/web_cshift';	//redirect to web_cshift page
		}else{
			$redirect_cshift = 'new_designer/home/live_new_ads'; //$redirect_cshift = 'new_designer/home/cshift/'.$hd;	//redirect to cshift page
		}  
		
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		if(isset($orders[0]['id'])){
			$rev_sold_jobs = $this->db->get_where('rev_sold_jobs',array('order_id' => $order_id))->result_array();
		}else{
			$this->session->set_flashdata("message", $order_id." Order: Details not Found..!!");
			redirect($redirect_cshift);
		}
		//PDF Annotation
		    $order_annotation = "order_annotation/csrProof-".$order_id."-".$orders[0]['job_no'].".pdf";
    		if(file_exists($order_annotation)){
    			$data['oa_fname'] = basename($order_annotation);
    			$data['oa_url'] = base_url().$order_annotation;
    		}
    		
		if($orders[0]['order_type_id'] == '1'){ //multiple size web ads
		    if($orders[0]['ad_format']=='5'){ //flexitive ad (flexitive size)
		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, flexitive_size.ratio, flexitive_size.ratio AS name FROM `orders_multiple_size`
                							                LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
                							                    WHERE orders_multiple_size.order_id = '".$orders[0]['id']."'")->result_array();
		    }else{ //pixel size
		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.*, pixel_sizes.width, pixel_sizes.height, CONCAT(pixel_sizes.width,'x',pixel_sizes.height) AS name FROM `orders_multiple_size`
                							                LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
                							                WHERE orders_multiple_size.order_id = '".$orders[0]['id']."'")->result_array();
		    }
		    $orders_multiple_custom_size = $this->db->query("SELECT *, CONCAT(custom_width,'x',custom_height) AS name FROM `orders_multiple_custom_size` 
		                                                        WHERE `order_id` = '".$orders[0]['id']."'")->result_array();
            if(isset($orders_multiple_size[0]['id'])){
               $data['orders_multiple_size'] = $orders_multiple_size;
            }
            if(isset($orders_multiple_custom_size[0]['id'])){
               $data['orders_multiple_custom_size'] = $orders_multiple_custom_size;
            }
		}
		
		if($orders[0]['publication_id'] == 580){ //Waukesha Freeman publication
		    $preorders_waukesha = $this->db->query("SELECT * FROM `preorders_waukesha` WHERE `adwit_id` = '$order_id'")->row_array();
		}
		
		$help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
		$data['help_desk']= $help_desk;
		
		$this->load->helper('directory');
		
		$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
		if(!$cat){
			$this->session->set_flashdata("message","Order Yet To Be Categorized!!");
			redirect($redirect_cshift);
		}
		
		$data['designer_alias'] = $designer_alias;
		$slug = $cat[0]['slug'];
		$data['hd']= $hd;
		$data['order_id']= $order_id;
		$data['cat']= $cat;
		if(isset($orders[0]['id']) && !isset($rev_sold_jobs[0]['id'])){ //only new order
		
		$data['redirect'] = $redirect;
		$pickup_downloads = "downloads/pickup/".$order_id;
		$pickup_map_downloads = directory_map($pickup_downloads.'/');
		if($pickup_map_downloads){ 
			$data['file_format']= $this->db->get('file_format')->result_array();
			$data['pickup_downloads']= $pickup_downloads; 
		}
		if(isset($value) && $value==''){
			$data['value'] = $value;
		}
		/************************************ categorise order ****************************************/
			if(isset($_POST['confirm'])){ //categorise order
				$this->cshift_category($order_id);
			}
		/*********************************** New Ad slug creation ****************************************/
		if(isset($_POST['confirm_slug']) && isset($_POST['slug']) && $cat[0]['slug']=='none')
		{
			$st_time = 	date("H:i:s");
			
			$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
			$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
			if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; }
			
			    $dir4 = "sourcefile/".$order_id;
				$dir5 = $dir4.'/'.$_POST['slug'];
				$data['dir5'] = $dir5;
				//to create folders
				
				if (@mkdir($dir4,0777))
				{

				}
				if (@mkdir($dir5,0777))
				{

				}
				
				//cat_result
				$dataa = array(
				'designer' => $this->session->userdata('dId'),
				'dlocation' => $this->session->userdata('dLoc'),
				'version' => 'V1', 
				'slug' => $_POST['slug'],
				'ddate' => date('Y-m-d'),
				'start_time' => $st_time,
				'shift_factor' => $tot_shift,
				'pro_status' => '1',
				'source_path' => $dir5
				  );
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $dataa); 
			
			//order status
			$post_status = array('status' => '3');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status);
			
			//status notification entry
			$notification = $order_id." Status InProduction - ".$this->session->userdata('dId');
			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
			$this->db->insert('order_status_change_notification', $status_notification);
			
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('status' => '3', 'pro_status' => '1', 'designer_id' => $this->session->userdata('dId'));
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//QA	
			$dataaa = array( 'order_no' => $order_id, 'cat_result_id' => $_POST['cat_result_id'] );
			$this->db->insert('QA', $dataaa);
			
			//indesign script
			if($this->session->userdata('dId') == '180'){
			    $this->indesign_script($order_id);
			}
			$this->session->set_flashdata("message","Slug : ".$_POST['slug']);	
			redirect($redirect);
		}
		
		//slug reassign
		if(isset($_POST['reassign']))
		{
			  $dataa = array(
    			 'designer' => '0',
    			 'dlocation' => '0',
    			 'version' => '', 
    			 'slug' => 'none',
    			 'ddate' => '0000-00-00',
    			 'start_time' => '',
    			 'shift_factor' => '',
    			 'pro_status' => '0',
    			 'source_path' => 'none'
			  );
			 $this->db->where('order_no', $order_id);
			 $this->db->update('cat_result', $dataa); 
			 
			 //QA
			 $cat_id = $_POST['cat_result_id'];
			 $this->db->query("DELETE FROM `QA` WHERE `order_no` = '$order_id' AND `cat_result_id` = '$cat_id'");
			 
			 //designer_ads_time deletion
			 $designer_ads_time = $this->db->query("SELECT * FROM `designer_ads_time` WHERE `order_id`= '$order_id' ")->result_array();
			 if($designer_ads_time){
			    $this->db->query("DELETE FROM `designer_ads_time` WHERE `order_id` = '$order_id'");
			 }
			//order status
			$post_status = array('status' => '2');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post_status);
			
			//status notification entry
			$notification = $order_id." Order Reassign. Status - Order Accepted";
			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
			$this->db->insert('order_status_change_notification', $status_notification);
			
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('status' => '2', 'pro_status' => '0');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			$path = "sourcefile/".$order_id;
			if(is_dir($path)){
			$this->emptyDir($path);
			rmdir($path);
			} 
			redirect($redirect);
		}
		
		//New Ad refresh folder structure
		if(isset($_POST['file_submit']))
		{
			$fileuploadstatus = $this->db->get_where('cat_result',array('order_no'=>$order_id))->result_array();
				if($fileuploadstatus[0]['source_path'] != 'none')
				{
    				$source_path = $fileuploadstatus[0]['source_path'];
    				$slug = $_POST['slug'];
    				
    				if($orders[0]['order_type_id'] == '1'){
    				    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
    				        if(isset($orders_multiple_size[0]['id'])){
        				        foreach($orders_multiple_size as $msize){
        				            $slug_fname = $slug.'_'.$msize['name'];
        				            $inddfile = $source_path.'/'.$msize['name'].'/'.$slug_fname.".psd";
                    				$pdffile = glob($source_path.'/'.$msize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                    				if(!file_exists($inddfile)){
                    				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$msize['name']);
                    				    redirect($redirect);
                    				}elseif(!$pdffile){
                    				    $this->session->set_flashdata("file_message","Image File Missing..!!".$msize['name']);
                    				    redirect($redirect);
                    				}    
        				        }
    				        }
    				        if(isset($orders_multiple_custom_size[0]['id'])){
        				        foreach($orders_multiple_custom_size as $mcsize){
        				            $slug_fname = $slug.'_'.$mcsize['name'];
        				            $inddfile = $source_path.'/'.$mcsize['name'].'/'.$slug_fname.".psd";
                    				$pdffile = glob($source_path.'/'.$mcsize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                    				if(!file_exists($inddfile)){
                    				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$mcsize['name']);
                    				    redirect($redirect);
                    				}elseif(!$pdffile){
                    				    $this->session->set_flashdata("file_message","Image File Missing..!!".$mcsize['name']);
                    				    redirect($redirect);
                    				}    
        				        }
        				    }
    				    }else{
            				$inddfile = $source_path.'/'.$slug.".psd";
            				$pdffile = glob($source_path.'/'.$slug.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
            				if(!file_exists($inddfile)){
            				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!");
            				    redirect($redirect);
            				}elseif(!$pdffile){
            				    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!");
            				    redirect($redirect);
            				}
    				    }
    				}else{  //Print ads
        				$inddfile = $source_path.'/'.$slug.".indd";
        				$pdffile = $source_path.'/'.$slug.".pdf";
        				if(!file_exists($inddfile)){
        				    $this->session->set_flashdata("file_message","SourceFile(indd) Missing..!!");
        				    redirect($redirect);
        				}elseif(!file_exists($pdffile)){
        				    $this->session->set_flashdata("file_message","PDF File Missing..!!");
        				    redirect($redirect);
        				}
    				}
				}else{ $this->session->set_flashdata("file_message","Source Files Missing..!!"); redirect($redirect); }
		
		}
		
		//TL Send To QA
		if(isset($_POST['sent']))
		{
			$tl_time = 	date("H:i:s");
			$tl_date = 	date("Y:m:d");
			$data1 = array('pro_status'=> '3', 'tl_time'=>  $tl_time , 'tl_date'=>  $tl_date , 'tl_id'=>$this->session->userdata('dId'));
			$this->db->where('order_no', $_POST['order_id']); 
			$this->db->update('cat_result', $data1);
			
			if(!empty($_POST['tl_QA_reason']) && strlen(trim($_POST['tl_QA_reason'])) != 0){
				//QA reason 
				if($_POST['tl_QA_reason'] == 'others'){
				$msg = $_POST['QA_reason'];
				}else{
				$msg = $_POST['tl_QA_reason'];
				}
				$qa_data = array('order_id' => $order_id, 'tl_designer_id' => $this->session->userdata('dId'), 'message' => $msg, 'operation' =>'tl_QA');	
				$this->db->insert('production_conversation',$qa_data);
			}
			//Tag CSR
			$pub_id = $_POST['publication_id'];
			$tag_publication = $this->db->query("SELECT * FROM `publications` WHERE `id` = '$pub_id'")->result_array();
			if($tag_publication && $cat[0]['tag_csr'] == '0'){
				$csr_id = $tag_publication[0]['tag_csr'];
				$tag_data = array('tag_csr'=> $csr_id); 
				$this->db->where('order_no', $order_id); 
				$this->db->update('cat_result', $tag_data);
			}
			// Order Status
			if($orders[0]['publication_id'] == '13'){ //In Queue for QC- 8
			    $data1 = array('status'=> '8');
    			$this->db->where('id', $order_id); 
    			$this->db->update('orders', $data1);
    			
    			//Live_tracker Updation
    			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
    			if(isset($update_order['id'])){
    				$tracker_data = array('status' => '8', 'pro_status'=> '3');
    				$this->db->where('id', $update_order['id']);
    				$this->db->update('live_orders', $tracker_data);
    			}
    			
    			//status notification entry
    			$notification = $order_id." Status - In Queue for QC";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
			}else{                                   //Quality check
    			$data1 = array('status'=> '4'); 
    			$this->db->where('id', $order_id); 
    			$this->db->update('orders', $data1);
    			
    			//Live_tracker Updation
    			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
    			if(isset($update_order['id'])){
    				$tracker_data = array('status' => '4', 'pro_status'=> '3');
    				$this->db->where('id', $update_order['id']);
    				$this->db->update('live_orders', $tracker_data);
    			}
    			
    			//status notification entry
    			$notification = $order_id." Status - Quality Check";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
			}
			if($designer_alias[0]['club_id'] != null) {
				$this->session->set_flashdata("message","Sent successfully!!!");
				redirect('new_designer/home/live_new_ads/design_check');
			}else{
				if($orders[0]['order_type_id']=='1'){
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('new_designer/home/web_cshift/'.$hd.'/design_check');	//redirect to web_cshift page
				}else{
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('new_designer/home/live_new_ads/design_check'); //redirect('new_designer/home/cshift/'.$hd.'/design_check');	//redirect to cshift page
				}
			}
		}
		
		//TL Back to Designer
		if(isset($_POST['sent_designer']) && isset($_POST['tl_msg']))
		{
			$file_path = 'none';
			if(isset($_FILES['file2']['name']) && !empty($_FILES['file2']['name'])) 
			{
    			$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['file2']['name']); $ext = '.'.$ext;
    			$file_format = $this->db->get('file_format')->result_array();
    			$up_load = '0';
    			foreach($file_format as $format){
    			 if($format['name'] == $ext){ $up_load = '1'; }
    			}
    			if($up_load == '1'){
        			$dir1="sourcefile/".$order_id.'/'.$slug;
        			$dir2 = $dir1.'/Tl_change';
        			$file_path = $dir2.'/'.$_FILES['file2']['name'];
        			if (@mkdir($dir2,0777))
        			{}
        			move_uploaded_file($_FILES['file2']['tmp_name'],$dir2.'/'.$_FILES['file2']['name']);
    			}else{
    			    $this->session->set_flashdata("ext_message",$ext." Extension not allowed.. Please upload only allowed file types.. Try Again!!");
    			    redirect($redirect);
    			}
			}
			$time=date("Y:m:d H:i:s"); 
			if($_POST['tl_msg'] == 'others'){
			    $msg = $_POST['tl_note'];
			}else{
			    $msg = $_POST['tl_msg'];
			}
			$data2 = array('order_id'=> $order_id , 'message'=>$msg ,  'tl_designer_id'=>$this->session->userdata('dId') , 'operation' => 'tl_designer', 'file_path' => $file_path);
			$this->db->insert('production_conversation', $data2);
			// Status Update
			$data1 = array('pro_status'=> '6');
			$this->db->where('order_no', $order_id); 
			$this->db->update('cat_result', $data1);
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('pro_status'=> '6');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//status notification entry
    			$notification = $order_id." Status - Changes from TL. Back to designer";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
    			
			if($designer_alias[0]['club_id'] != null) {
				$this->session->set_flashdata("message","Sent successfully!!!");
				redirect('new_designer/home/live_new_ads/design_check');
			}else{
				if($orders[0]['order_type_id']=='1'){
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('new_designer/home/web_cshift/'.$hd.'/design_check');	//redirect to web_cshift page
				}else{
					$this->session->set_flashdata("message","Sent successfully!!!");
					redirect('new_designer/home/live_new_ads/design_check'); //redirect('new_designer/home/cshift/'.$hd.'/design_check');	//redirect to cshift page
				}
			}
		}	
		
		//TL Send To DC
		if(isset($_POST['send_DC']) && isset($_POST['tl_dc_reason'])){	
			if($_POST['tl_dc_reason'] == 'others'){
			    $msg = $_POST['DC_reason'];
			}else{
			    $msg = $_POST['tl_dc_reason'];
			}
			$dc_data = array('order_id' => $order_id, 'tl_designer_id' => $this->session->userdata('dId'), 'message' => $msg, 'operation'=>'tl_DC');	
			$this->db->insert('production_conversation',$dc_data);
			
			$pro_status = array('pro_status' => '4');	
			$this->db->where('order_no', $order_id);	
			$this->db->update('cat_result', $pro_status);	
			// Order Status
			$data2 = array('status'=> '4');
			$this->db->where('id', $order_id); 
			$this->db->update('orders', $data2);

			//Live_tracker Updation
			$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('status' => '4', 'pro_status' => '4');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//status notification entry
    			$notification = $order_id." Status - In DC.";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
			
			if($designer_alias[0]['club_id'] != null) {
				$this->session->set_flashdata("ext_message","Sent successfully!!!");
				redirect('new_designer/home/live_new_ads/design_check');
			}else{
				if($orders[0]['order_type_id']=='1'){
					$this->session->set_flashdata("ext_message","Sent To DC successfully!!!");
					redirect('new_designer/home/web_cshift/'.$hd.'/design_check');	//redirect to web_cshift page
				}else{
					$this->session->set_flashdata("ext_message","Sent To DC successfully!!!");
					redirect('new_designer/home/live_new_ads/design_check'); //redirect('new_designer/home/cshift/'.$hd.'/design_check');	//redirect to cshift page
				}
			}
		}  
		
		//TL make changes
		if(isset($_POST['make_changes']))
		{
			//rename files
			$slug = $_POST['new_slug'];
			$zip_demo = $cat[0]['source_path'].'/'.$slug.".zip";
			
			//$this->zip_folder_select(); 
			
			if($orders[0]['order_type_id'] == '1'){ //web AD
			    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
			        $this->multiple_zip_folder_select($order_id);
			        
			        if(isset($orders_multiple_size[0]['id'])){
    				    foreach($orders_multiple_size as $msize){
    				        $slug_fname = $slug.'_'.$msize['name'];
    				        $inddfile = $cat[0]['source_path'].'/'.$msize['name'].'/'.$slug_fname.".psd";
        					$pdffile = glob($cat[0]['source_path'].'/'.$msize['name'].'/'.$slug_fname.'.{jpg,gif,png}', GLOB_BRACE);
        					foreach($pdffile as $row){
        						$ext = pathinfo(basename($row), PATHINFO_EXTENSION);
        						$pdffile = $row;
        					} 
        					$inddtemp1 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp1'.".psd";
            			    $pdftemp1 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp1'.".".$ext;
            					
            				$inddtemp2 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp2'.".psd";
            				$pdftemp2 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp2'.".".$ext;
            					
            				$inddtemp3 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp3'.".psd";
            				$pdftemp3 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp3'.".".$ext;
            					
            				if(file_exists($inddfile) && file_exists($pdffile)){
            					if(file_exists($inddtemp1) && file_exists($pdftemp1)){
            						rename($inddfile,$inddtemp2);
            						rename($pdffile,$pdftemp2);
            					}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
            						rename($inddfile,$inddtemp3);
            						rename($pdffile,$pdftemp3);
            					}else{
            						rename($inddfile,$inddtemp1);
            						rename($pdffile,$pdftemp1);
            					} 
            				}
    				    }
			        }
			        if(isset($orders_multiple_custom_size[0]['id'])){   //custom multiple size
    				    foreach($orders_multiple_custom_size as $mcsize){
    				        $slug_fname = $slug.'_'.$mcsize['name'];
    				        $inddfile = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.$slug_fname.".psd";
        					$pdffile = glob($cat[0]['source_path'].'/'.$mcsize['name'].'/'.$slug_fname.'.{jpg,gif,png}', GLOB_BRACE);
        					foreach($pdffile as $row){
        						$ext = pathinfo(basename($row), PATHINFO_EXTENSION);
        						$pdffile = $row;
        					} 
        					$inddtemp1 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp1'.".psd";
            			    $pdftemp1 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp1'.".".$ext;
            					
            				$inddtemp2 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp2'.".psd";
            				$pdftemp2 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp2'.".".$ext;
            					
            				$inddtemp3 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp3'.".psd";
            				$pdftemp3 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp3'.".".$ext;
            					
            				if(file_exists($inddfile) && file_exists($pdffile)){
            					if(file_exists($inddtemp1) && file_exists($pdftemp1)){
            						rename($inddfile,$inddtemp2);
            						rename($pdffile,$pdftemp2);
            					}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
            						rename($inddfile,$inddtemp3);
            						rename($pdffile,$pdftemp3);
            					}else{
            						rename($inddfile,$inddtemp1);
            						rename($pdffile,$pdftemp1);
            					} 
            				}
    				    }
			        }
				}else{
				    $this->zip_folder_select(); 
				    
    				$inddfile = $cat[0]['source_path'].'/'.$slug.".psd";
    				$pdffile = glob($cat[0]['source_path'].'/'.$slug.'.{jpg,gif}', GLOB_BRACE);
    				foreach($pdffile as $row){
    					$ext = pathinfo(basename($row), PATHINFO_EXTENSION);
    					$pdffile = $row;
    				}
    				$inddtemp1 = $cat[0]['source_path'].'/'.'temp1'.".psd";
    				$pdftemp1 = $cat[0]['source_path'].'/'.'temp1'.".".$ext;
    				
    				$inddtemp2 = $cat[0]['source_path'].'/'.'temp2'.".psd";
    				$pdftemp2 = $cat[0]['source_path'].'/'.'temp2'.".".$ext;
    				
    				
    				$inddtemp3 = $cat[0]['source_path'].'/'.'temp3'.".psd";
    				$pdftemp3 = $cat[0]['source_path'].'/'.'temp3'.".".$ext;
    				
    				if(file_exists($inddfile) && file_exists($pdffile)){
    					if(file_exists($inddtemp1) && file_exists($pdftemp1)){
    						rename($inddfile,$inddtemp2);
    						rename($pdffile,$pdftemp2);
    					}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
    						rename($inddfile,$inddtemp3);
    						rename($pdffile,$pdftemp3);
    					}else{
    						rename($inddfile,$inddtemp1);
    						rename($pdffile,$pdftemp1);
    					} 
    				}
    			}
			}else{	//print AD
			    $this->zip_folder_select(); 
				$inddfile = $cat[0]['source_path'].'/'.$slug.".indd";
				$pdffile = $cat[0]['source_path'].'/'.$slug.".pdf";
					
				$inddtemp1 = $cat[0]['source_path'].'/'.'temp1'.".indd";
				$pdftemp1 = $cat[0]['source_path'].'/'.'temp1'.".pdf";
					
				$inddtemp2 = $cat[0]['source_path'].'/'.'temp2'.".indd";
				$pdftemp2 = $cat[0]['source_path'].'/'.'temp2'.".pdf";
					
				$inddtemp3 = $cat[0]['source_path'].'/'.'temp3'.".indd";
				$pdftemp3 = $cat[0]['source_path'].'/'.'temp3'.".pdf";
				if(file_exists($inddfile) && file_exists($pdffile)){
					if(file_exists($inddtemp1) && file_exists($pdftemp1)){
						rename($inddfile,$inddtemp2);
						rename($pdffile,$pdftemp2);
					}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
						rename($inddfile,$inddtemp3);
						rename($pdffile,$pdftemp3);
					}else{
						rename($inddfile,$inddtemp1);
						rename($pdffile,$pdftemp1);
					} 
				}
			}
			//db update
			$data3 = array('pro_status'=> '8');
			$this->db->where('order_no', $order_id);  
			$this->db->update('cat_result', $data3);
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			
			if(isset($update_order['id'])){
				$tracker_data = array('pro_status' => '8');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//status notification entry
    			$notification = $order_id." Status - In Design TL.";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
    // 		print_r($update_order);exit();	
			if($cat[0]['sold_pdf'] != 'none'){
				$path_to_file = $cat[0]['sold_pdf'];
				if(file_exists($path_to_file)){
					unlink($path_to_file);
				}
				$sold_data1 = array('sold_pdf'=> 'none'); 
				$this->db->where('order_no', $order_id);  
				$this->db->update('cat_result', $sold_data1);
			}
			if($cat[0]['source_path'] != 'none'){
					$source_path = $cat[0]['source_path'];
					$slug = $_POST['new_slug'];
					$idmlfile_path = $source_path.'/'.$slug.".idml";
					if(file_exists($idmlfile_path)){
						unlink($idmlfile_path);
					}
			}
			redirect('new_designer/home/orderview/'.$hd.'/'.$order_id);
		}
		
		if($cat[0]['source_path'] != 'none'){ 
			$sourcefile = $cat[0]['source_path']; 
			$map_sourcefile = directory_map($sourcefile.'/');
			if($map_sourcefile){ $data['sourcefile']= $sourcefile; 	}
			if(file_exists($sourcefile) && !empty($sourcefile)){
			   $source_package_size = $this->GetDirectorySize($sourcefile); //In bytes
			   $data['source_package_size_mb'] = number_format($source_package_size / 1048576, 2); //In MB    
			}
		}
		
		$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
		$data['adrep_name'] = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
		if($cat[0]['designer'] != '0'){ $data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['designer']."'")->result_array(); }
		$data['fname']=$this->db->get_where('print_ad_types',array('id' => $orders[0]['print_ad_type']))->result_array();
		$data['orders']= $orders;
		$data['note_tl_designer'] = $this->db->get_where('note_teamlead_designer',array('display' => 'tl_designer'))->result_array();
		$data['note_tl_qa'] = $this->db->get_where('note_teamlead_designer',array('display' => 'tl_qa'))->result_array();
		$data['note_tl_dc'] = $this->db->get_where('note_teamlead_designer',array('display' => 'tl_dc'))->result_array();
		$cp_tool = $this->db->query("SELECT * from `cp_tool` where `order_no` = '$order_id' ")->result_array();
		if($cp_tool)
		{
			$data['cp_tool'] = $cp_tool;
			$data['csr_name1'] = $this->db->get_where('csr',array('id' => $cp_tool[0]['csr']))->result_array();
		}
		//if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `team_lead` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
		if($cat[0]['tl_id']!='0') $data['tl'] = $this->db->query("SELECT * FROM `designers` WHERE `id`='".$cat[0]['tl_id']."'")->result_array();
		$job_no = $orders[0]['job_no'];
		$this->load->helper('directory');
		$downloads = $orders[0]['file_path']; //$downloads = "downloads/".$order_id."-".$job_no;
		$sourcefile="sourcefile/".$order_id.'/'.$slug;
		$map_downloads = directory_map($downloads.'/');
		if($map_downloads){
			$data['downloads']= $downloads; 
			$data['file_format']= $this->db->get('file_format')->result_array();
		}
		//New Ad slug 
		if($cat[0]['slug']=='none' || $cat[0]['slug']==''){
		$version = 'V1';
		$cat[0]['job_name'] = str_replace(' ', '_', $cat[0]['job_name']);
		if($cat[0]['slug_type'] == '1')
		$slug = $cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['job_name']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '2')
		$slug = $cat[0]['job_name'];
		elseif($cat[0]['slug_type'] == '3')
		$slug = $cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '4')
		$slug = $cat[0]['order_no']."-".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."-".$version;
		elseif($cat[0]['slug_type'] == '5')
		$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '6')
		$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '7')
		$slug = $cat[0]['job_name']."_".$cat[0]['order_no']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '8')
		$slug = $cat[0]['order_no']."_".$cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '9')
		$slug = $cat[0]['job_name']."_".$cat[0]['advertiser']."_".$cat[0]['news_initial']."_".$cat[0]['order_no']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		elseif($cat[0]['slug_type'] == '10')
		$slug = $cat[0]['advertiser']."_".$cat[0]['job_name']."_".$cat[0]['news_initial']."_".$cat[0]['category']."_".$this->session->userdata('designer')."_".$version;
		else{
		$this->session->set_flashdata("message","Slug undefined for this slug type....<br/> provide valid slug type for Publication.");
		redirect($redirect);
		} 
		$slug = str_replace(' ', '_', $slug);
		$data['slug']= $slug;
		}else{
		$data['slug']= $cat[0]['slug'];
		$dc_reason = $this->db->query("SELECT * from `dc_reason` where `order_id` = '$order_id' ")->result_array();
		if($dc_reason){ $data['dc_reason'] = $dc_reason; }
		
		$qa_reason = $this->db->query("SELECT * from `qa_reason` where `order_id` = '$order_id' ")->result_array();
		if($qa_reason){ $data['qa_reason'] = $qa_reason; }
		
		$designer_message = $this->db->query("SELECT * from `designer_message` where `order_id` = '$order_id' ")->result_array();
		if($designer_message){
		$data['designer_message'] = $designer_message;
		} 
		
		//changes from TL
		$tl_path = "sourcefile/".$order_id.'/'.$cat[0]['slug'].'/Tl_change';
		$map_tl_path = directory_map($tl_path.'/');
		if($map_tl_path){ $data['tl_path']= $tl_path; }
		
		//changes from CSR
		$csr_path = "sourcefile/".$order_id.'/'.$cat[0]['slug'].'/csr_change';
		$map_csr_path = directory_map($csr_path.'/');
		if($map_csr_path){ $data['csr_path']= $csr_path; }
		
		//changes from DC CSR
		$dc_csr_path = "sourcefile/".$order_id.'/'.$cat[0]['slug'].'/DC_change';
		$map_dc_csr_path = directory_map($dc_csr_path.'/');
		if($map_dc_csr_path){ $data['dc_csr_path']= $dc_csr_path; }
		
		// New Ad CSR and TL changes 
		if(isset($_POST['csr_tl_changes']))
		{
			$slug = $_POST['new_slug'];
				$zip_demo = $cat[0]['source_path'].'/'.$slug.".zip";
				
				if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				    if(!file_exists($zip_demo)){  $this->multiple_zip_folder_select($order_id); } 
				}else{
    			    if(!file_exists($zip_demo)){  $this->zip_folder_select(); }
				}
				
				if($orders[0]['order_type_id'] == '1'){
				    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				        if(isset($orders_multiple_size[0]['id'])){
    				        foreach($orders_multiple_size as $msize){
    				            $slug_fname = $slug.'_'.$msize['name'];
    				            $inddfile = $cat[0]['source_path'].'/'.$msize['name'].'/'.$slug_fname.".psd";
        					    $pdffile = glob($cat[0]['source_path'].'/'.$msize['name'].'/'.$slug_fname.'.{jpg,gif,png}', GLOB_BRACE);
        					    foreach($pdffile as $row){
        						    $ext = pathinfo(basename($row), PATHINFO_EXTENSION);
        						    $pdffile = $row;
        					    } 
        					    $inddtemp1 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp1'.".psd";
            					$pdftemp1 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp1'.".".$ext;
            					
            					$inddtemp2 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp2'.".psd";
            					$pdftemp2 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp2'.".".$ext;
            					
            					
            					$inddtemp3 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp3'.".psd";
            					$pdftemp3 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'temp3'.".".$ext;
            					
            					if(file_exists($inddfile) && file_exists($pdffile)){
            						if(file_exists($inddtemp1) && file_exists($pdftemp1)){
            							rename($inddfile,$inddtemp2);
            							rename($pdffile,$pdftemp2);
            						}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
            							rename($inddfile,$inddtemp3);
            							rename($pdffile,$pdftemp3);
            						}else{
            							rename($inddfile,$inddtemp1);
            							rename($pdffile,$pdftemp1);
            						} 
            					}
    				        }
				        }
				        if(isset($orders_multiple_custom_size[0]['id'])){
    				        foreach($orders_multiple_custom_size as $mcsize){
    				            $slug_fname = $slug.'_'.$mcsize['name'];
    				            $inddfile = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.$slug_fname.".psd";
        					    $pdffile = glob($cat[0]['source_path'].'/'.$mcsize['name'].'/'.$slug_fname.'.{jpg,gif,png}', GLOB_BRACE);
        					    foreach($pdffile as $row){
        						    $ext = pathinfo(basename($row), PATHINFO_EXTENSION);
        						    $pdffile = $row;
        					    } 
        					    $inddtemp1 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp1'.".psd";
            					$pdftemp1 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp1'.".".$ext;
            					
            					$inddtemp2 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp2'.".psd";
            					$pdftemp2 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp2'.".".$ext;
            					
            					
            					$inddtemp3 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp3'.".psd";
            					$pdftemp3 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'temp3'.".".$ext;
            					
            					if(file_exists($inddfile) && file_exists($pdffile)){
            						if(file_exists($inddtemp1) && file_exists($pdftemp1)){
            							rename($inddfile,$inddtemp2);
            							rename($pdffile,$pdftemp2);
            						}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
            							rename($inddfile,$inddtemp3);
            							rename($pdffile,$pdftemp3);
            						}else{
            							rename($inddfile,$inddtemp1);
            							rename($pdffile,$pdftemp1);
            						} 
            					}
    				        }
				        }
				    }else{ //web psd
    					$inddfile = $cat[0]['source_path'].'/'.$slug.".psd";
    					$pdffile = glob($cat[0]['source_path'].'/'.$slug.'.{jpg,gif}', GLOB_BRACE);
    					foreach($pdffile as $row){
    						$ext = pathinfo(basename($row), PATHINFO_EXTENSION);
    						$pdffile = $row;
    					}
    					$inddtemp1 = $cat[0]['source_path'].'/'.'temp1'.".psd";
    					$pdftemp1 = $cat[0]['source_path'].'/'.'temp1'.".".$ext;
    					
    					$inddtemp2 = $cat[0]['source_path'].'/'.'temp2'.".psd";
    					$pdftemp2 = $cat[0]['source_path'].'/'.'temp2'.".".$ext;
    					
    					
    					$inddtemp3 = $cat[0]['source_path'].'/'.'temp3'.".psd";
    					$pdftemp3 = $cat[0]['source_path'].'/'.'temp3'.".".$ext;
    					
    					if(file_exists($inddfile) && file_exists($pdffile)){
    						if(file_exists($inddtemp1) && file_exists($pdftemp1)){
    							rename($inddfile,$inddtemp2);
    							rename($pdffile,$pdftemp2);
    						}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
    							rename($inddfile,$inddtemp3);
    							rename($pdffile,$pdftemp3);
    						}else{
    							rename($inddfile,$inddtemp1);
    							rename($pdffile,$pdftemp1);
    						} 
    					}
				    }
				}else{ //print indd
					$inddfile = $cat[0]['source_path'].'/'.$slug.".indd";
					$pdffile = $cat[0]['source_path'].'/'.$slug.".pdf";
					
					$inddtemp1 = $cat[0]['source_path'].'/'.'temp1'.".indd";
					$pdftemp1 = $cat[0]['source_path'].'/'.'temp1'.".pdf";
					
					$inddtemp2 = $cat[0]['source_path'].'/'.'temp2'.".indd";
					$pdftemp2 = $cat[0]['source_path'].'/'.'temp2'.".pdf";
					
					$inddtemp3 = $cat[0]['source_path'].'/'.'temp3'.".indd";
					$pdftemp3 = $cat[0]['source_path'].'/'.'temp3'.".pdf";
					if(file_exists($inddfile) && file_exists($pdffile)){
						if(file_exists($inddtemp1) && file_exists($pdftemp1)){
							rename($inddfile,$inddtemp2);
							rename($pdffile,$pdftemp2);
						}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
							rename($inddfile,$inddtemp3);
							rename($pdffile,$pdftemp3);
						}else{
							rename($inddfile,$inddtemp1);
							rename($pdffile,$pdftemp1);
						} 
					}
				}
		
			if($cat[0]['sold_pdf'] != 'none'){
				$path_to_file = $cat[0]['sold_pdf'];
				if(file_exists($path_to_file)){
					unlink($path_to_file);
				}
				$sold_data = array('sold_pdf'=> 'none'); 
				$this->db->where('order_no', $order_id);  
				$this->db->update('cat_result', $sold_data);
			}
			if($cat[0]['source_path'] != 'none'){
				$source_path = $cat[0]['source_path'];
				$slug = $_POST['new_slug'];
				$idmlfile_path = $source_path.'/'.$slug.".idml";
				if(file_exists($idmlfile_path)){
					unlink($idmlfile_path);
				}
			}
			
			$st_time = 	date("H:i:s");
			$st_date = 	date("Y:m:d");
			$to_time1 = date("Y-m-d h:i:s");
			$to_time = strtotime($to_time1);
			$from_time = strtotime($_POST['start_time']);
			$time_taken =  round(abs($to_time - $from_time) / 60,2);
			 
			$dataa1 = array(
                			'order_id' => $order_id,
                			'designer_id' => $_POST['designer_id'],
                			'start_time' => $_POST['start_time'],
                			'end_date' => $st_date,
                			'end_time' => $st_time,
                			'time_taken' => $time_taken
                			);
			$this->db->insert('designer_ads_time', $dataa1); 
			
			$data3 = array('pro_status'=> '1'); 
			$this->db->where('order_no', $order_id);  
			$this->db->update('cat_result', $data3);
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('pro_status' => '1');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//status notification entry
    			$notification = $order_id." Status - In Design.";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
    			
			redirect($redirect);
		}
		
		//TL make changes File upload
		if(isset($_POST['sourceUpload']) && isset($_POST['sourcefile']))
		{
			$fileuploadstatus = $this->db->get_where('cat_result',array('order_no'=>$order_id))->result_array();
			
			//$sourcefile="sourcefile/".$order_id."/".$fileuploadstatus[0]['slug'];
			if($fileuploadstatus[0]['source_path'] != 'none')
			{
				$source_path = $fileuploadstatus[0]['source_path'];
				$slug = $_POST['slug'];
				 
					if($orders[0]['order_type_id'] == '1'){
					    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
					        if(isset($orders_multiple_size[0]['id'])){
    					        foreach($orders_multiple_size as $msize){
    					            $slug_fname = $slug.'_'.$msize['name'];
        				            $inddfile = $source_path.'/'.$msize['name'].'/'.$slug_fname.".psd";
                    				$pdffile = glob($source_path.'/'.$msize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                    				if(!file_exists($inddfile)){
                    				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$slug_fname);
                    				    redirect($redirect);
                    				}elseif(!$pdffile){
                    				    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!".$slug_fname);
                    				    redirect($redirect);
                    				}    
        				        }
					        }
					        if(isset($orders_multiple_custom_size[0]['id'])){   //multiple custom size web ads
    					        foreach($orders_multiple_custom_size as $mcsize){
    					            $slug_fname = $slug.'_'.$mcsize['name'];
        				            $inddfile = $source_path.'/'.$mcsize['name'].'/'.$slug_fname.".psd";
                    				$pdffile = glob($source_path.'/'.$mcsize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                    				if(!file_exists($inddfile)){
                    				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$slug_fname);
                    				    redirect($redirect);
                    				}elseif(!$pdffile){
                    				    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!".$slug_fname);
                    				    redirect($redirect);
                    				}    
        				        }
					        }
					    }else{
    						$inddfile = $source_path.'/'.$slug.".psd";
    						$pdffile = glob($source_path.'/'.$slug.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
    						if(!file_exists($inddfile)){
    							$this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!");
    							redirect($redirect);
    						}elseif(!$pdffile){
    							$this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!");
    							redirect($redirect);
    						}
					    }
					}else{
						$inddfile = $source_path.'/'.$slug.".indd";
						$pdffile = $source_path.'/'.$slug.".pdf";
						if(!file_exists($inddfile)){
							$this->session->set_flashdata("file_message","SourceFile(indd) Missing..!!");
							redirect($redirect);
						}elseif(!file_exists($pdffile)){
							$this->session->set_flashdata("file_message","PDF File Missing..!!");
							redirect($redirect);
						}
					}
					$link_path = $source_path.'/Links';
					$font_path = $source_path.'/Document fonts';
				
			}else{ redirect($redirect); $this->session->set_flashdata("file_message","Source Files Missing..!!");  } 
			$help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
			if($help_desk1)
			{ 
				if($fileuploadstatus[0]['sold_pdf'] != 'none')
				{
					if(!file_exists($fileuploadstatus[0]['sold_pdf'])){
						$this->session->set_flashdata("file_message","Sold PDF Missing..!!");
						redirect($redirect);
					}
				} else{ $this->session->set_flashdata("file_message","Sold Source Files Missing..!!"); redirect($redirect); }
			}
			//idml file check
			$idml_pub2 = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$cat[0]['publication_id']."' AND `idml` = '1'")->result_array();
			if(isset($idml_pub2[0]['id']) && $orders[0]['order_type_id'] != '1'){ 
				if($fileuploadstatus[0]['source_path'] != 'none')
				{
					$source_path = $fileuploadstatus[0]['source_path'];
					$slug = $_POST['slug'];
					//if($orders[0]['order_type_id'] != '1'){ // no idml for web ads
					    $idmlfile = glob($source_path.'/'.$slug.'.{idml,IDML}', GLOB_BRACE);
    					if(!$idmlfile){
    						$this->session->set_flashdata("file_message","IDML file Missing..!!");
    						redirect($redirect);
    					}
					//}
					
				} else{ $this->session->set_flashdata("file_message","IDML Source Files Missing..!!"); redirect($redirect); }
			}
			// cat Result status Update
			$pro_status = array('pro_status' => '2', 'source_path' => $sourcefile);//In design check
			$this->db->where('order_no', $order_id);
			$this->db->update('cat_result', $pro_status);
			
			//Live_tracker Updation
			$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
			if(isset($update_order['id'])){
				$tracker_data = array('pro_status' => '2');
				$this->db->where('id', $update_order['id']);
				$this->db->update('live_orders', $tracker_data);
			}
			
			//status notification entry
    			$notification = $order_id." Status - In Design Check.";
    			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
    			$this->db->insert('order_status_change_notification', $status_notification);
    			
			$this->session->set_flashdata("file_message","files uploaded successfully..!!");
			redirect('new_designer/home/orderview/'.$hd.'/'.$order_id);	
		}
		
		//New Ad End design
		if(isset($_POST['complete']) && isset($_POST['designer_id']))
		{
			$fileuploadstatus = $this->db->get_where('cat_result',array('order_no'=>$order_id))->result_array();
			if($fileuploadstatus[0]['source_path'] != 'none')
			{
					$source_path = $fileuploadstatus[0]['source_path'];
					$slug = $_POST['slug'];
					
					$inddfile = $source_path.'/'.$slug.".indd";
					$pdffile = $source_path.'/'.$slug.".pdf";
					$link_path = $source_path.'/Links';
					$font_path = $source_path.'/Document fonts';
					
					if($orders[0]['order_type_id'] == '1'){
					    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
					        if(isset($orders_multiple_size[0]['id'])){
        					    foreach($orders_multiple_size as $msize){
        					        $slug_fname = $slug.'_'.$msize['name'];
        					        $inddfile = $source_path.'/'.$msize['name'].'/'.$slug_fname.".psd";
                					$pdffile = glob($source_path.'/'.$msize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                					if(!file_exists($inddfile)){
                					    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}elseif(!$pdffile){
                					    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}    
        					    }
					        }
					        if(isset($orders_multiple_custom_size[0]['id'])){
        					    foreach($orders_multiple_custom_size as $mcsize){
        					        $slug_fname = $slug.'_'.$mcsize['name'];
        					        $inddfile = $source_path.'/'.$mcsize['name'].'/'.$slug_fname.".psd";
                					$pdffile = glob($source_path.'/'.$mcsize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                					if(!file_exists($inddfile)){
                					    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}elseif(!$pdffile){
                					    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}    
        					    }
					        }
    					}else{
        					$inddfile = $source_path.'/'.$slug.".psd";
        					$pdffile = glob($source_path.'/'.$slug.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
        					if(!file_exists($inddfile)){
        					    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!");
        					    redirect($redirect);
        					}elseif(!$pdffile){
        					    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!");
        					    redirect($redirect);
        					}
    					}
					}else{
    					$inddfile = $source_path.'/'.$slug.".indd";
    					$pdffile = $source_path.'/'.$slug.".pdf";
    					if(!file_exists($inddfile)){
    					    $this->session->set_flashdata("file_message","SourceFile(indd) Missing..!!");
    					    redirect($redirect);
    					}elseif(!file_exists($pdffile)){
    					    $this->session->set_flashdata("file_message","PDF File Missing..!!");
    					    redirect($redirect);
    					}
					}
				
			}else{ $this->session->set_flashdata("file_message","Source Files Missing..!!"); redirect($redirect);  } 
			
		$help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
		if($help_desk1)
		{
			if($fileuploadstatus[0]['sold_pdf'] != 'none')
			{
				if(!file_exists($fileuploadstatus[0]['sold_pdf'])){
					$this->session->set_flashdata("file_message","Sold PDF Missing..!!");
					redirect($redirect);
				}
			} else{ $this->session->set_flashdata("file_message","Sold Source Files Missing..!!"); redirect($redirect); }
		}
		//idml file check
		$idml_pub = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$cat[0]['publication_id']."' AND `idml` = '1'")->result_array();
		if(isset($idml_pub[0]['id']) && $orders[0]['order_type_id'] != '1'){ 
			if($fileuploadstatus[0]['source_path'] != 'none'){
				$source_path = $fileuploadstatus[0]['source_path'];
				$slug = $_POST['slug'];
				//if($orders[0]['order_type_id'] != '1'){ // no idml for web ads
    				$idmlfile = glob($source_path.'/'.$slug.'.{idml,IDML}', GLOB_BRACE);
    				if(!$idmlfile){
    					$this->session->set_flashdata("file_message","IDML file Missing..!!");
    					redirect($redirect);
    				}
				//}
			} else{ $this->session->set_flashdata("file_message","IDML Source Files Missing..!!"); redirect($redirect); }
		}
			$st_time = 	date("H:i:s");
			 $st_date = 	date("Y:m:d");
			 $to_time1 = date("Y-m-d h:i:s");
			 $to_time = strtotime($to_time1);
			 $from_time = strtotime($_POST['start_time']);
			 $time_taken =  round(abs($to_time - $from_time) / 60,2);
			 
			 $dataa1 = array(
                			'order_id' => $order_id,
                			'designer_id' => $_POST['designer_id'],
                			'start_time' => $_POST['start_time'],
                			'end_date' => $st_date,
                			'end_time' => $st_time,
                			'time_taken' => $time_taken
			                );
			$this->db->insert('designer_ads_time', $dataa1);
			 
			// cat Result status Update
			if($fileuploadstatus[0]['tl_id'] == '0'){
				
			    if($fileuploadstatus[0]['category'] == 'P' || $fileuploadstatus[0]['category'] == 'T'){
			        //For P, T Category, once the designer ends the ad should change to Quality Check.
					$pro_status = array('pro_status' => '3'); //QA
					$this->db->where('order_no', $order_id); 
					$this->db->update('cat_result', $pro_status);
					
					if($orders[0]['publication_id'] == '13'){ //In Queue for QC- 8
					    $post_status = array('status' => '8'); 
    					$this->db->where('id', $order_id); 
    					$this->db->update('orders', $post_status);
    					
    					//Live_tracker Updation
    					$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
    					if(isset($update_order['id'])){
    						$tracker_data = array('status' => '8', 'pro_status' => '3');
    						$this->db->where('id', $update_order['id']);
    						$this->db->update('live_orders', $tracker_data);
    					}
    					
    					//status notification entry
            			$notification = $order_id." Status - In Queue for QC.";
            			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
            			$this->db->insert('order_status_change_notification', $status_notification);
    			
					}else{
    					$post_status = array('status' => '4'); //Quality check status
    					$this->db->where('id', $order_id); 
    					$this->db->update('orders', $post_status);
    					
    					//Live_tracker Updation
    					$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
    					if(isset($update_order['id'])){
    						$tracker_data = array('status' => '4', 'pro_status' => '3');
    						$this->db->where('id', $update_order['id']);
    						$this->db->update('live_orders', $tracker_data);
    					}
    					
    					//status notification entry
            			$notification = $order_id." Status - In Queue Check.";
            			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
            			$this->db->insert('order_status_change_notification', $status_notification);
					}
				}else{
				//For other Category, once the designer ends the ad should change to Design Check.    
					$pro_status = array('pro_status' => '2');
					$this->db->where('order_no', $order_id);
					$this->db->update('cat_result', $pro_status);
					
					//Live_tracker Updation
					$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
					if(isset($update_order['id'])){
						$tracker_data = array('pro_status' => '2');
						$this->db->where('id', $update_order['id']);
						$this->db->update('live_orders', $tracker_data);
					}
					
					//status notification entry
            			$notification = $order_id." Status - In Design Check.";
            			$status_notification = array('order_id' => $order_id, 'notification' => $notification);
            			$this->db->insert('order_status_change_notification', $status_notification);
				}
			}elseif($fileuploadstatus[0]['tl_id'] != '0'){
				$pro_status = array('pro_status' => '3'); //QA
				$this->db->where('order_no', $order_id); 
				$this->db->update('cat_result', $pro_status);
				
				$post_status = array('status' => '4'); //Quality check status
				$this->db->where('id', $order_id); 
				$this->db->update('orders', $post_status);
				
				//Live_tracker Updation
				$update_order = $this->db->query("SELECT `id` FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
				if(isset($update_order['id'])){
					$tracker_data = array('status' => '4', 'pro_status' => '3');
					$this->db->where('id', $update_order['id']);
					$this->db->update('live_orders', $tracker_data);
				}
				
				//status notification entry
            	$notification = $order_id." Status - In Queue Check.";
            	$status_notification = array('order_id' => $order_id, 'notification' => $notification);
            	$this->db->insert('order_status_change_notification', $status_notification);
			}
			
			//note
			$dId = $this->session->userdata('dId');
			if (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){
			    $post_note = array( 'order_id' => $order_id, 'designer_id' => $dId, 'message' => $_POST['note'] );
			    $this->db->insert('production_conversation', $post_note);
			}
			//redirect($redirect_cshift);
			
			/*****************Send to adrep - H-B-Designer **************************/
			$designer_alias = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->result_array();
			
			//if($designer_alias[0]['designer_role'] == '4') // Send to Adrep for Hi-B Designer 
			if($designer_alias[0]['designer_role'] == '4' || ($designer_alias[0]['designer_role'] == '2' && ($cat[0]['category'] == 'P' || $cat[0]['category'] == 'T'))) 
			{
				$date = date('Y-m-d');
				$st_time = 	date("H:i:s");
				$data['st_time'] = $st_time;
				$dataa = array(
								'designer' => $this->session->userdata('dId'), 
								'order_no' => $order_id,
								'cat_result_id' => $cat[0]['id'],
								'start_time' => $st_time,
								'date' => $date,
								'job_status' => 'Inprogress',
								);
				$this->db->insert('cp_tool', $dataa);
				$cp_tool_id = $this->db->insert_id();
				/*
				if($cp_tool_id)
				{
					$end_time = date("H:i:s");				
					$cp = $this->db->get_where('cp_tool',array('id' => $cp_tool_id,'designer' => $this->session->userdata('dId')))->result_array();
					$dp_wt = $this->db->get_where('print',array('name' => 'TWEAK'))->result_array();
					$stime = $cp[0]['start_time'];
					$etime = $end_time;
					$nextDay=$stime>$etime?1:0;
					 $dep=EXPLODE(':',$stime);
					 $arr=EXPLODE(':',$etime);
					 $diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
					 $hours=FLOOR($diff/(60*60));
					 $mins=FLOOR(($diff-($hours*60*60))/(60));
					 $secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
					 IF(STRLEN($hours)<2){$hours="0".$hours;}
					 IF(STRLEN($mins)<2){$mins="0".$mins;}
					 IF(STRLEN($secs)<2){$secs="0".$secs;}
					$time_min=$hours*60+$mins;
					$time_hr = $time_min / 60 ;
					$cp = $time_hr / $dp_wt[0]['wt'];
					$data = array(
								'end_time' => $end_time,
								'time_taken' => $time_min,
								'cp' => $cp,
								'job_status' => "Done",
								);
					$this->db->where('id', $cp_tool_id);
					$this->db->update('cp_tool', $data);
				}
				*/
				//File upload in pdf_upload folder
			
				$_POST['source_file'] = basename($inddfile);
				$_POST['order_id'] = $order_id;
				$_POST['source_path'] = $source_path;
				if(!is_array($pdffile)) $_POST['pdf_file'] = basename($pdffile);
				
				if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				    if($this->multiple_zip_folder_select($order_id)==true){
    					$pdf_uploads = "pdf_uploads/".$order_id;
    				}else{ 
    					$this->session->set_flashdata("message","Zip Error uploading source to Adrep!!");
    					redirect($redirect_cshift);//redirect($redirect);
    				}    
				}else{
					
    					if($this->zip_folder_select()==true){
    						$pdf_uploads = "pdf_uploads/".$order_id;
    						//echo $pdf_uploads;
    					}else{ 
    						$this->session->set_flashdata("message","Zip Error uploading source to Adrep!!");
    						redirect($redirect_cshift);//redirect($redirect);
    					}
    			
    			}
				
				$map_pdf_uploads = directory_map($pdf_uploads.'/');
				if($map_pdf_uploads)
				{
				    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				       $map_zip = $pdf_uploads.'/'.$slug.'.zip';
				       if(file_exists($map_zip)){
				          $pdf_file = $map_zip; $pdf = $map_zip; 
				       }
				    }else{
    					$map_pdf_jpg = glob($pdf_uploads.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
    					if($map_pdf_jpg){
    						foreach($map_pdf_jpg as $row){
    							$pdf_file = $row; $pdf = $row;
    						}
    					}
				    }
						if($orders[0]['help_desk']=='2'){
							$check_mail = $this->metro_ftp($pdf_file);
							
						}elseif(($orders[0]['group_id']=='2' || $orders[0]['group_id']=='4') && ($orders[0]['order_type_id']=='2')){
    						    $type_of_ad = 'new_ad';
    							$response = $this->tscs_send_to_adrep($order_id, $type_of_ad);
    							if($response != 'success'){
    							    $this->session->set_flashdata("message",$response);
    			                    redirect($redirect_cshift);    
    							}
    					}
    					else{
							$client = $this->db->get_where('adreps',array('id' => $orders[0]['adrep_id']))->result_array();
							$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
							$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
							$dataa['template'] = $design_team[0]['newad_template'];
						
							if($publication[0]['id'] == '47'){ 
								if(($design_team[0]['newad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
									$dataa['subject'] = 'New Ad(Note): '.$job_name.'_'.$advertiser_name;
								}else{
									$dataa['subject'] = 'New Ad: '.$job_name.'_'.$advertiser_name;
								}
							}else{
								if(($design_team[0]['newad_template'] == 'order_rating_mailer') && (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0)){
									$dataa['subject'] = 'New Ad(Note): '.$slug ;
								}else{
									$dataa['subject'] = 'New Ad: '.$slug ;
								}
							}
							$dataa['alias'] = $designer_alias[0]['alias'];
							$dataa['from'] = $design_team[0]['email_id'];
							$dataa['from_display'] = 'Design Team';
							$dataa['replyTo'] = $design_team[0]['email_id'];
							$dataa['replyTo_display'] = 'Design Team';
							$dataa['client_Cc'] = $client[0]['email_cc'];
							//$dataa['subject'] = 'New Ad: '.$slug ;
							$dataa['ad_type'] = 'new' ; 
							if(isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){ $dataa['note'] = $_POST['note']; } 
							
							//Client
							if($this->session->userdata('sId')=='25'){
								$dataa['recipient'] = "webmaster@adwitglobal.com";
							}else{
								$dataa['recipient'] = $client[0]['email_id']; 
							}
							$dataa['fname'] = $pdf_file; 
							$dataa['temp'] = $pdf_file; 
							$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
							$dataa['client'] = $client[0];
							$dataa['design_team_id'] = $design_team[0]['id'];
							$dataa['order_id'] = $order_id;
							$this->load->library('Encryption');
							$dataa['url']= base_url().index_page().'order_rating/home/new_order_rating/'.$this->encryption->encrypt($order_id);
							$dataa['orders'] = $orders[0] ;
							$dataa['version'] = 'V1';
							$this->test_mail($dataa);	
						}
						//order status
						$pdf_timestamp = date("Y-m-d H:i:s");
						$post_status = array('status' => '5' , 'pdf' => $pdf, 'activity_time' => date('Y-m-d h:i:s'), 'pdf_timestamp' => $pdf_timestamp);
						$this->db->where('id', $order_id);
						$this->db->update('orders', $post_status);
						
						//Live_tracker  Updation
						$update_orders = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
						if(isset($update_orders['id'])){
							$this->db->query("DELETE FROM `live_orders` WHERE `id`= '".$update_orders['id']."'");
						}
						
						//status notification entry
            	        $notification = $order_id." Status - Proof Sent.";
            	        $status_notification = array('order_id' => $order_id, 'notification' => $notification);
            	        $this->db->insert('order_status_change_notification', $status_notification);
            	
						//map orders status update via cURL
						if(isset($orders[0]['map_order_id']) && $orders[0]['map_order_id'] != NULL && $orders[0]['map_order_id'] != '0'){
							$source = null;
							if(isset($_POST['source_path']) && isset($_POST['new_slug'])){
								$chk_source = $_POST['source_path'].'/'.$_POST['new_slug'].'.zip';
								if(file_exists($chk_source)){ $source = 'https://adwitads.com/weborders/'.$chk_source; }
							}
							$fields = array(
											'status' => '5', 
											'map_order_id' => $orders[0]['map_order_id'],
											'source' => $source,
											'file' => new \CurlFile($pdf_file), //pdf send
											);
							$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/order_status_update';
							$this->curl_post($url, $fields); //API using cURL 
						}
					
						//Production status
						$pro_status = array('pro_status' => '5','pdf_path' => $pdf_file);
						$this->db->where('order_no', $order_id);
						$this->db->update('cat_result', $pro_status);
						//metro_sent_ads insertion
						if($orders[0]['help_desk']=='2'){
							$metro_sent_ads = array( 'order_id' => $order_id, 'sent' => '0' );
							$this->db->insert('metro_sent_ads', $metro_sent_ads);
						}
						//Note Sent
						if (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){
							$post_note = array( 'order_id' => $order_id, 'note' => $_POST['note'] );
							$this->db->insert('note_sent', $post_note);
						}	
				}else{ 
						$this->session->set_flashdata("message",$order_id." - Pdf Not Found");
				}
				//For Ftp xml files 16-OCT-2023
    			if($orders[0]['publication_id'] == '656'){ //Ogden
    			    $this->Ogden_create_xml_proofReady('new', $order_id);    
    			}
				$this->session->set_flashdata("success_message",$order_id." - Uploaded & Sent To Adrep..!!");
				redirect($redirect_cshift);
			}//designer role 4 end
			
			$this->session->set_flashdata("success_message",$order_id." - Uploaded..!!");
			redirect($redirect_cshift);
		}
		//end of End design
		} 
		}elseif(isset($orders[0]['id']) && isset($rev_sold_jobs[0]['id'])){ //new & revision
		//rev_orderview
		$data['pub_name'] = $this->db->get_where('publications',array('id' => $orders[0]['publication_id']))->result_array();
		if($orders[0]['file_path'] != 'none'){
		$data['order_form'] = $orders[0]['file_path'];
		}
		/*******************Revision Ad slug creation*************************/
		if(isset($_POST['create_slug']))
		{
		    //$this->Qrevision_slug();
		    $return_msg = $this->Qrevision_slug();
			$this->session->set_flashdata("message",$return_msg);
		}
		if($rev_sold_jobs[0]['source_file'] != 'none' && $rev_sold_jobs[0]['pdf_file'] != 'none'){ 
		$sourcefile = "sourcefile/".$order_id.'/'.$cat[0]['slug'];
		$map_sourcefile = directory_map($sourcefile.'/');
		if($map_sourcefile){ $data['sourcefile']= $sourcefile; 	}
		}
		/*******************Revision Ad folder Refresh**************************/
		if(isset($_POST['rev_file_submit']))
		{	
			$fileuploadstatus = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1")->result_array();
			$new_slug = $_POST['slug'];
			
				if($fileuploadstatus[0]['source_file'] != 'none' && $fileuploadstatus[0]['pdf_file'] != 'none')
				{
    				$source_path = 'sourcefile/'.$order_id.'/'.$cat[0]['slug'];
    				$slug = $_POST['slug'];
    				
    				if($orders[0]['order_type_id'] == '1'){
    				    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
    				        if(isset($orders_multiple_size[0]['id'])){
        				        foreach($orders_multiple_size as $msize){
        				            $slug_fname = $slug.'_'.$msize['name'];
        				            $inddfile = $source_path.'/'.$msize['name'].'/'.$slug_fname.".psd";
                    				$pdffile = glob($source_path.'/'.$msize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                    				if(!file_exists($inddfile)){
                    				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$msize['name']);
                    				    redirect($redirect);
                    				}elseif(!$pdffile){
                    				    $this->session->set_flashdata("file_message","Image File Missing..!!".$msize['name']);
                    				    redirect($redirect);
                    				}    
        				        }
    				        }
    				        if(isset($orders_multiple_custom_size[0]['id'])){
        				        foreach($orders_multiple_custom_size as $mcsize){
        				            $slug_fname = $slug.'_'.$mcsize['name'];
        				            $inddfile = $source_path.'/'.$mcsize['name'].'/'.$slug_fname.".psd";
                    				$pdffile = glob($source_path.'/'.$mcsize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                    				if(!file_exists($inddfile)){
                    				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$mcsize['name']);
                    				    redirect($redirect);
                    				}elseif(!$pdffile){
                    				    $this->session->set_flashdata("file_message","Image File Missing..!!".$mcsize['name']);
                    				    redirect($redirect);
                    				}    
        				        }
        				    }
        				    //echo $inddfile.'<br/>'; print_r($pdffile);
    				    }else{
            				$inddfile = $source_path.'/'.$slug.".psd";
            				$pdffile = glob($source_path.'/'.$slug.'.{pdf,jpg,gif,png,jpeg,zip}', GLOB_BRACE);
            				if(!file_exists($inddfile)){
            				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!");
            				    redirect($redirect);
            				}elseif(!$pdffile){
            				    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!");
            				    redirect($redirect);
            				}
    				    }
    				}else{
    				    //print
        				$inddfile = $source_path.'/'.$slug.".indd";
        				$pdffile = $source_path.'/'.$slug.".pdf";
        				if(!file_exists($inddfile)){
        				    $this->session->set_flashdata("file_message","SourceFile(indd) Missing..!!");
        				    redirect($redirect);
        				}elseif(!file_exists($pdffile)){
        				    $this->session->set_flashdata("file_message","PDF File Missing..!!");
        				    redirect($redirect);
        				}
    				}
    				
				}else{ $this->session->set_flashdata("file_message","Source Files Missing..!!"); redirect($redirect); } 
			
		}
		
		/********************Revision Ad End design*****************************/
		if(isset($_POST['rev_complete']))
		{
			$fileuploadstatus = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1")->result_array();
			//check updated src & pdf
			if($_POST['source_file'] == 'none' || $_POST['pdf_file'] == 'none'){
				$_POST['source_file'] = $fileuploadstatus[0]['source_file'];
				$_POST['pdf_file'] = $fileuploadstatus[0]['pdf_file'];
			}
			$new_slug = $_POST['new_slug'];
			
				if($fileuploadstatus[0]['source_file'] != 'none' && $fileuploadstatus[0]['pdf_file'] != 'none')
				{
    				$source_path = 'sourcefile/'.$order_id.'/'.$cat[0]['slug'];
    				$slug = $_POST['new_slug'];
    				
    				if($orders[0]['order_type_id'] == '1'){
    				    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
					        if(isset($orders_multiple_size[0]['id'])){
        					    foreach($orders_multiple_size as $msize){
        					        $slug_fname = $slug.'_'.$msize['name'];
        					        $inddfile = $source_path.'/'.$msize['name'].'/'.$slug_fname.".psd";
                					$pdffile = glob($source_path.'/'.$msize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                					if(!file_exists($inddfile)){
                					    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}elseif(!$pdffile){
                					    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}    
        					    }
					        }
					        if(isset($orders_multiple_custom_size[0]['id'])){
        					    foreach($orders_multiple_custom_size as $mcsize){
        					        $slug_fname = $slug.'_'.$mcsize['name'];
        					        $inddfile = $source_path.'/'.$mcsize['name'].'/'.$slug_fname.".psd";
                					$pdffile = glob($source_path.'/'.$mcsize['name'].'/'.$slug_fname.'.{pdf,jpg,gif,png,jpeg}', GLOB_BRACE);
                					if(!file_exists($inddfile)){
                					    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}elseif(!$pdffile){
                					    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!".$slug_fname);
                					    redirect($redirect);
                					}    
        					    }
					        }
    					}else{
            				$inddfile = $source_path.'/'.$slug.".psd";
            				$pdffile = glob($source_path.'/'.$slug.'.{pdf,jpg,gif,png,jpeg,zip}', GLOB_BRACE);
            				if(!file_exists($inddfile)){
            				    $this->session->set_flashdata("file_message","SourceFile(psd) Missing..!!");
            				    redirect($redirect); 
            				}elseif(!$pdffile){
            				    $this->session->set_flashdata("file_message","Image{pdf,jpg,gif,png,jpeg} File Missing..!!");
            				    redirect($redirect);
            				}
    					}
    				}else{
        				$inddfile = $source_path.'/'.$slug.".indd";
        				$pdffile = $source_path.'/'.$slug.".pdf";
        				if(!file_exists($inddfile)){
        				    $this->session->set_flashdata("file_message","SourceFile(indd) Missing..!!");
        				    redirect($redirect);
        				}elseif(!file_exists($pdffile)){
        				    $this->session->set_flashdata("file_message","PDF File Missing..!!");
        				    redirect($redirect);
        				}
    				}
				}else{ $this->session->set_flashdata("file_message","Source Files Missing..!!"); redirect($redirect); }  
			
			$help_desk1 = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '".$cat[0]['help_desk']."' AND `sold` = '1'")->result_array();
			if(isset($help_desk1[0]['id']))
			{ 
				if($fileuploadstatus[0]['sold_pdf'] != 'none')
				{
					if(!file_exists($fileuploadstatus[0]['sold_pdf'])){
						$this->session->set_flashdata("file_message","Sold PDF Missing..!!");
						redirect($redirect);
					}
				} else{ $this->session->set_flashdata("file_message","Sold Source Files Missing..!!"); redirect($redirect); }
			}
			//idml file check
			$idml_pub1 = $this->db->query("SELECT * FROM `publications` WHERE `id` = '".$cat[0]['publication_id']."' AND `idml` = '1'")->result_array();
			if($idml_pub1 && $orders[0]['order_type_id'] != '1'){
				$source_path = 'sourcefile/'.$order_id.'/'.$cat[0]['slug'];
				if($source_path){
					$slug1 = $_POST['new_slug'];
					//if($orders[0]['order_type_id'] != '1'){ // no idml for web ads
    					$idmlfile = glob($source_path.'/'.$slug1.'.{idml,IDML}', GLOB_BRACE);
    					if(!$idmlfile){
    						$this->session->set_flashdata("file_message","IDML file Missing..!!");
    						redirect($redirect);
    					}
					//}
				} else{ $this->session->set_flashdata("file_message","IDML Source Files Missing..!!"); redirect($redirect); }
			}
    		$dId = $this->session->userdata('dId');
    		//Note to adrep
    		if (isset($_POST['note']) && strlen(trim($_POST['note'])) != 0){
    		    $post_note = array( 'revision_id' => $_POST['rev_id'], 'designer_id' => $dId, 'message' => $_POST['note'], 'operation' => 'revdesigner_QA' );
    		    $this->db->insert('production_conversation', $post_note);
    		}
    		//revision order reason
    		/*if (isset($_POST['revision_reason']) && !empty($_POST['revision_reason'])){
        		$reason_data = $_POST['revision_reason'];
        		$timestamp = date('Y-m-d H:i:s');
        		foreach($reason_data as $data_row){
            		$post_revision_reason = array( 'rev_id' => $_POST['rev_id'], 
                                            		'order_id' => $_POST['order_id'], 
                                            		'reason_id' => $data_row, 
                                            		'csr' => $_POST['rev_csr_id'], 
                                            		'designer' => $_POST['rev_designer_id'], 
                                            		'timestamp' => $timestamp
                                            	);
            		$this->db->insert('rev_order_reason', $post_revision_reason);
        		}
    		}*/
    		
    			/************** send to adrep SKIP QA *****************/
    		
    		if($designer_alias[0]['designer_role'] == '4'){ //Hybrid Designer send to adrep
    		    //Rovchecker(csr)
    		    if(isset($_POST['csr'])){
        		$tday = date('Y-m-d');
        		$time = date("H:i:s");
        		$shift_factor = $this->db->get_where('designers',array('id'=>$this->session->userdata('dId')))->result_array();
        		$additional_hr = $this->db->get_where('designer_additional_hours',array('designer' => $this->session->userdata('dId'), 'date' => date('Y-m-d')))->result_array();
        		if($additional_hr){ $tot_shift = $shift_factor[0]['shift_factor'] + $additional_hr[0]['hours'] ; }else{ $tot_shift = $shift_factor[0]['shift_factor']; }
        		$post_ptrands = array(
                            		'text' => $_POST['new_slug'],
                            		'designer' => $this->session->userdata('dId'),
                            		'csr' => $_POST['csr'],
                            		'date' => $tday,
                            		'time' => $time,
                            		'category' => 'revision',
                            		'shift_factor' => $tot_shift,
                        		);
        		$this->db->insert('ptrands', $post_ptrands);
    		    }
        		$pdf_path = 'none' ;
        		//File upload to pdf_upload folder
        		$_POST['source_file'] = basename($inddfile);
				$_POST['order_id'] = $order_id;
				$_POST['source_path'] = $source_path;
        		if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				    if($this->multiple_zip_folder_select($order_id)==true){
    					$pdf_uploads = "pdf_uploads/".$order_id;
    				}else{ 
    					$this->session->set_flashdata("message","Zip Error uploading source to Adrep!!");
    					redirect($redirect_cshift);//redirect($redirect);
    				}    
				}else{
        			if($this->zip_folder_select()==true){
        			    $pdf_uploads = "pdf_uploads/".$order_id;
        				//$pdf_path = "pdf_uploads/".$order_id.'/'.$_POST['pdf_file'];
        			}else{ 
        				$this->session->set_flashdata("message","Error uploading source to Adrep!!");
        				redirect($redirect);
        			}
				}
				
			    $map_pdf_uploads = directory_map($pdf_uploads.'/');
        		if($map_pdf_uploads){
        		    if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				       $map_zip = $pdf_uploads.'/'.$slug.'.zip';
				       if(file_exists($map_zip)){
				          $pdf_path = $map_zip; $pdf = $map_zip;
							//update rev_sold_jobs - pdf_file to zip file instead of image file
							$post = array('pdf_file' => basename($pdf_path));
							$this->db->where('id', $_POST['rev_id']);
							$this->db->update('rev_sold_jobs', $post);
				       }
				    }else{
    					$map_pdf_jpg = glob($pdf_uploads.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
    					if($map_pdf_jpg){
    						foreach($map_pdf_jpg as $row){
    							$pdf_path = $row; $pdf = $row;
    						}
    					}
				    }
        		}
        		
        		if(file_exists($pdf_path)){
        		     //tscs send to adrep flow
        			if(($orders[0]['group_id']=='2' || $orders[0]['group_id']=='4') && ($orders[0]['order_type_id']=='2')){
            				    $type_of_ad = 'revision_ad';
            				    $revision_order_id = $_POST['rev_id'];
            					$response = $this->tscs_send_to_adrep($revision_order_id, $type_of_ad);
            					if($response != 'success'){
            						$this->session->set_flashdata("message",$response);
            			             redirect($redirect);    
            					}
            		}
        			$end_timestamp = date("Y-m-d H:i:s");
        			$sent_time = date("H:i:s");
        			
        			$data1 = array( 'sent_time' => $sent_time,
        							//'frontline_csr' => $this->session->userdata('sId'),
        							'rov_csr' => $_POST['csr'],
        							'pdf_path' => $pdf_path,
        							'status' => '5',
        							'end_timestamp' => $end_timestamp
        							);
        			$this->db->where('id', $_POST['rev_id']);
        			$this->db->update('rev_sold_jobs', $data1);
        			
        			//update rev status in orders table(new 21 Apr 2022)
        				    $order_rev_status_upadate = array( 'rev_order_status' => '5' ); //Revision Proof Ready
        					$this->db->where('id', $order_id);
        					$this->db->update('orders', $order_rev_status_upadate);
        					
        			//Live_tracker Revision Updation
        			$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
        			if(isset($update_revision['id'])){
        				$this->db->query("DELETE FROM `live_revisions` WHERE `id`= '".$update_revision['id']."'");
        			}
        			
        			$jobs = $this->db->get_where('rev_sold_jobs',array('id' => $_POST['rev_id'], 'job_status' => '1'))->result_array();
        			$time = ($jobs[0]['date'].' '.$jobs[0]['time']) ;
        			
        			 //converting to time
        			$start = strtotime($time);
        			$end = strtotime($end_timestamp);
        
        			//calculating the difference
        			$time_taken = abs($end - $start);
        
        			$data2 = array( 'time_taken' => $time_taken );
        			$this->db->where('id', $_POST['rev_id']);
        			$this->db->update('rev_sold_jobs', $data2);
        			
        			//map orders status update via cURL
        			if(isset($jobs[0]['map_revorder_id']) && $jobs[0]['map_revorder_id'] != 0){
        				$source = null;
        				if(isset($_POST['source_path']) && isset($_POST['new_slug'])){
        					$chk_source = $_POST['source_path'].'/'.$_POST['new_slug'].'.zip';
        					if(file_exists($chk_source)){ $source = 'https://adwitads.com/weborders/'.$chk_source; }
        				}
        				$fields = array(
        								'status' => '5', 
        								'map_revorder_id' => $jobs[0]['map_revorder_id'],
        								'source' => $source,
        								'file' => new \CurlFile($pdf_path), //pdf send
        							);
        				$url = 'https://adwit.in/adwitmap/index.php/Cron_jobs/revorder_status_update';
        				$this->curl_post($url, $fields); //API using cURL 
        			}
        			
        			//order activity time
        			$post_status = array('activity_time' => date('Y-m-d h:i:s'));
        			$this->db->where('id', $order_id);
        			$this->db->update('orders', $post_status);
        			
        			//send mail
        			$client = $this->db->get_where('adreps',array('id' => $_POST['adrep']))->result_array();
        			if($client)
        			{	
        				$dataa['fname'] = $pdf_path; 
        				$dataa['temp'] = $pdf_path;
        				$cat = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
        				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
        				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
        				//$csr_alias = $this->db->get_where('csr',array('id' => $this->session->userdata('sId')))->result_array();
        				$dataa['template'] = $design_team[0]['revad_template'];
        				//$dataa['alias'] = $csr_alias[0]['alias'];
        				$dataa['from'] = $design_team[0]['email_id'];
        				
        				$job_name = $cat[0]['job_name'];
        				$advertiser_name = $cat[0]['advertiser'];
        				if($publication[0]['id'] == '47'){ 
            				if(($design_team[0]['revad_template'] == 'order_rating_mailer') && (isset($_POST['adrep_note']) && strlen(trim($_POST['adrep_note'])) != 0)){
            				    $dataa['subject'] = 'Revised Ad (Note) '.$job_name.'_'.$advertiser_name;
            				}else{
            				    $dataa['subject'] = 'Revised Ad# '.$job_name.'_'.$advertiser_name;
            				}
        				}else{
            				if(($design_team[0]['revad_template'] == 'order_rating_mailer') && (isset($_POST['adrep_note']) && strlen(trim($_POST['adrep_note'])) != 0)){
            				    $dataa['subject'] = 'Revised Ad (Note) :'.$_POST["new_slug"] ;
            				}else{
            				    $dataa['subject'] = 'Revised Ad: '.$_POST["new_slug"] ; 
            				}
            			}
        				$dataa['from_display'] = 'Design Team';
        
        				$dataa['replyTo'] = $design_team[0]['email_id'];
        
        				$dataa['replyTo_display'] = 'Design Team';
        				
        				$dataa['ad_type'] = 'revised' ;
        				if(isset($_POST['adrep_note']) && strlen(trim($_POST['adrep_note'])) != 0){ $dataa['note'] = $_POST['adrep_note']; } 
        				//Client
        				if($this->session->userdata('sId')=='25'){
        					$dataa['recipient'] = 'webmaster@adwitglobal.com';
        				}else{
        					$dataa['recipient'] = $client[0]['email_id'];
        				}
        				$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
        				$dataa['client'] = $client[0];
        				$dataa['design_team_id'] = $design_team[0]['id'];
        				$dataa['client_Cc'] = $client[0]['email_cc'];
        				$dataa['order_id'] = $order_id ;
        				$dataa['rev_id'] = $_POST['rev_id'] ;
        				$this->load->library('Encryption');
        				$rev_id = $this->encryption->encrypt($_POST['rev_id']);
        				$dataa['url']= base_url().index_page().'order_rating/home/rev_order_rating/'.$rev_id;
        				$dataa['orders'] = $orders[0] ;
        				$dataa['version'] = $fileuploadstatus[0]['version'];
        				$this->test_mail($dataa);
        				
        				//Note Sent 
        				if (isset($_POST['adrep_note']) && strlen(trim($_POST['adrep_note'])) != 0){
        					$post_note = array( 'order_id' => $order_id, 'revision_id' => $_POST['rev_id'], 'note' => $_POST['adrep_note'] );
        					$this->db->insert('note_sent', $post_note);
        				} 
        			}else{ echo "<script>alert('client unidentified')</script>"; }
        			//For Ftp xml files 16-OCT-2023
        			if($orders[0]['publication_id'] == '656'){ //Ogden
        			    $this->Ogden_create_xml_proofReady('revision', $order_id);    
        			}
        		}else{ 
        		    echo "<script>alert('PDF/Image File Not Found..Try Uploading Again')</script>"; 
        		}
        		
    		    $this->session->set_flashdata("message"," Job Completed!!");
    		    redirect('new_designer/home/frontlinetrack_order_list/'.$hd);
    		}else{
    		    
    		    /************* Send To QA *************/
    			$post1 = array('status' => '4'); //$post1 = array('status' => '4', 'rov_csr' => $_POST['csr']);
    			$this->db->where('id', $_POST['rev_id']);
    			$this->db->update('rev_sold_jobs', $post1);
    			
    			//update rev status in orders table(new 21 Apr 2022)
    			$order_rev_status_upadate = array( 'rev_order_status' => '4' ); //Revision InQA
    			$this->db->where('id', $order_id);
    			$this->db->update('orders', $order_rev_status_upadate);
    					
    			//Live_tracker Revision Updation
    			$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
    			if(isset($update_revision['id'])){
    				$tracker_data = array('status' => '4');
    				$this->db->where('id', $update_revision['id']);
    				$this->db->update('live_revisions', $tracker_data);
    			}				
    							
    		    $this->session->set_flashdata("message"," Job Completed!!");
    		    redirect('new_designer/home/frontlinetrack_order_list/'.$hd);
    		}
		}
		
		// Revision Ad CSR  changes 
		if(isset($_POST['csr_changes']))
		{
			$slug = $_POST['new_slug'];
		
				$zip_demo = $cat[0]['source_path'].'/'.$slug.".zip";
				if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				    if(!file_exists($zip_demo)){  $this->multiple_zip_folder_select($order_id); } 
				}else{
    				if(!file_exists($zip_demo)){ $this->zip_folder_select(); }
				}
				if($orders[0]['order_type_id'] == '1'){
					if((isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])) && $orders[0]['ad_format']!='5'){  //multiple size web ads
				        if(isset($orders_multiple_size[0]['id'])){
    				        foreach($orders_multiple_size as $msize){
    				            $slug_fname = $slug.'_'.$msize['name'];
    				            $inddfile = $cat[0]['source_path'].'/'.$msize['name'].'/'.$slug_fname.".psd";
        					    $pdffile = glob($cat[0]['source_path'].'/'.$msize['name'].'/'.$slug_fname.'.{jpg,gif,png}', GLOB_BRACE);
        					    foreach($pdffile as $row){
        						    $ext = pathinfo(basename($row), PATHINFO_EXTENSION);
        						    $pdffile = $row;
        					    } 
        					    $inddtemp1 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'revtemp1'.".psd";
            					$pdftemp1 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'revtemp1'.".".$ext;
            					
            					$inddtemp2 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'revtemp2'.".psd";
            					$pdftemp2 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'revtemp2'.".".$ext;
            					
            					
            					$inddtemp3 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'revtemp3'.".psd";
            					$pdftemp3 = $cat[0]['source_path'].'/'.$msize['name'].'/'.'revtemp3'.".".$ext;
            					
            					if(file_exists($inddfile) && file_exists($pdffile)){
            						if(file_exists($inddtemp1) && file_exists($pdftemp1)){
            							rename($inddfile,$inddtemp2);
            							rename($pdffile,$pdftemp2);
            						}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
            							rename($inddfile,$inddtemp3);
            							rename($pdffile,$pdftemp3);
            						}else{
            							rename($inddfile,$inddtemp1);
            							rename($pdffile,$pdftemp1);
            						} 
            					}
    				        }
				        }
				        if(isset($orders_multiple_custom_size[0]['id'])){
    				        foreach($orders_multiple_custom_size as $mcsize){
    				            $slug_fname = $slug.'_'.$mcsize['name'];
    				            $inddfile = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.$slug_fname.".psd";
        					    $pdffile = glob($cat[0]['source_path'].'/'.$mcsize['name'].'/'.$slug_fname.'.{jpg,gif,png}', GLOB_BRACE);
        					    foreach($pdffile as $row){
        						    $ext = pathinfo(basename($row), PATHINFO_EXTENSION);
        						    $pdffile = $row;
        					    } 
        					    $inddtemp1 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'revtemp1'.".psd";
            					$pdftemp1 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'revtemp1'.".".$ext;
            					
            					$inddtemp2 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'revtemp2'.".psd";
            					$pdftemp2 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'revtemp2'.".".$ext;
            					
            					
            					$inddtemp3 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'revtemp3'.".psd";
            					$pdftemp3 = $cat[0]['source_path'].'/'.$mcsize['name'].'/'.'revtemp3'.".".$ext;
            					
            					if(file_exists($inddfile) && file_exists($pdffile)){
            						if(file_exists($inddtemp1) && file_exists($pdftemp1)){
            							rename($inddfile,$inddtemp2);
            							rename($pdffile,$pdftemp2);
            						}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
            							rename($inddfile,$inddtemp3);
            							rename($pdffile,$pdftemp3);
            						}else{
            							rename($inddfile,$inddtemp1);
            							rename($pdffile,$pdftemp1);
            						} 
            					}
    				        }
				        }
				    }else{ //web
						$inddfile = $cat[0]['source_path'].'/'.$slug.".psd";
						$pdffile = glob($cat[0]['source_path'].'/'.$slug.'.{jpg,gif}', GLOB_BRACE);
						foreach($pdffile as $row){
							$ext = pathinfo(basename($row), PATHINFO_EXTENSION);
							$pdffile = $row;
						}
						$inddtemp1 = $cat[0]['source_path'].'/'.'revtemp1'.".psd";
						$pdftemp1 = $cat[0]['source_path'].'/'.'revtemp1'.".".$ext;
						
						$inddtemp2 = $cat[0]['source_path'].'/'.'revtemp2'.".psd";
						$pdftemp2 = $cat[0]['source_path'].'/'.'revtemp2'.".".$ext;
						
						
						$inddtemp3 = $cat[0]['source_path'].'/'.'revtemp3'.".psd";
						$pdftemp3 = $cat[0]['source_path'].'/'.'revtemp3'.".".$ext;
						
						if(file_exists($inddfile) && file_exists($pdffile)){
							if(file_exists($inddtemp1) && file_exists($pdftemp1)){
								rename($inddfile,$inddtemp2);
								rename($pdffile,$pdftemp2);
							}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
								rename($inddfile,$inddtemp3);
								rename($pdffile,$pdftemp3);
							}else{
								rename($inddfile,$inddtemp1);
								rename($pdffile,$pdftemp1);
							} 
						}
					}
				}else{ //print
    				$inddfile = $cat[0]['source_path'].'/'.$slug.".indd";
    				$pdffile = $cat[0]['source_path'].'/'.$slug.".pdf";
    				
    				$inddtemp1 = $cat[0]['source_path'].'/'.'revtemp1'.".indd";
    				$pdftemp1 = $cat[0]['source_path'].'/'.'revtemp1'.".pdf";
    				
    				$inddtemp2 = $cat[0]['source_path'].'/'.'revtemp2'.".indd";
    				$pdftemp2 = $cat[0]['source_path'].'/'.'revtemp2'.".pdf";
    				
    				$inddtemp3 = $cat[0]['source_path'].'/'.'revtemp3'.".indd";
    				$pdftemp3 = $cat[0]['source_path'].'/'.'revtemp3'.".pdf";
    				if(file_exists($inddfile) && file_exists($pdffile)){
        				if(file_exists($inddtemp1) && file_exists($pdftemp1)){
        				    rename($inddfile,$inddtemp2);
        				    rename($pdffile,$pdftemp2);
        				}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
        				    rename($inddfile,$inddtemp3);
        				    rename($pdffile,$pdftemp3);
        				}else{
        				    rename($inddfile,$inddtemp1);
        				    rename($pdffile,$pdftemp1);
        				} 
    				}
				}
			
			//sold pdf deleting
			if(isset($_POST['sold_pdf_path']) && ($_POST['sold_pdf_path'] != 'none')){
				$path_to_file = $_POST['sold_pdf_path'];
				if(file_exists($path_to_file)){
					unlink($path_to_file);
				}
				$sold_data2 = array('sold_pdf'=> 'none'); 
				$this->db->where('id', $_POST['rev_id']);  
				$this->db->update('rev_sold_jobs', $sold_data2);
			}
			//idml deleting
			if($cat[0]['source_path'] != 'none'){
				$source_path = $cat[0]['source_path'];
				$slug1 = $_POST['new_slug'];
				$idmlfile_path = $source_path.'/'.$slug1.".idml";
				if(file_exists($idmlfile_path)){
					unlink($idmlfile_path);
				}
			}
			$data3 = array('status'=> '3'); 
			$this->db->where('id', $_POST['rev_id']);  
			$this->db->update('rev_sold_jobs', $data3);
			
			//update rev status in orders table(new 21 Apr 2022)
				$order_rev_status_upadate = array( 'rev_order_status' => '3' ); //Revision InProduction
				$this->db->where('id', $order_id);
				$this->db->update('orders', $order_rev_status_upadate);
			
			//Live_tracker Revision Updation
			$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
			if(isset($update_revision['id'])){
				$tracker_data = array('status' => '3');
				$this->db->where('id', $update_revision['id']);
				$this->db->update('live_revisions', $tracker_data);
			}
			
			redirect($redirect);
		}
		
		//Revision Reassign for designer role 2
		if(isset($_POST['reassign']))
		{
    	    $dataa = array(
                		 'designer' => '0',
                		 'new_slug' => 'none',
                		 'ddate' => '0000-00-00',
                		 'status' => '2',
                		  );
    		 $this->db->where('id', $_POST['rev_id']);
    		 $this->db->update('rev_sold_jobs', $dataa); 
    		 
    		//update rev status in orders table(new 21 Apr 2022)
			$order_rev_status_upadate = array( 'rev_order_status' => '2' ); //Revision Accepted
			$this->db->where('id', $order_id);
			$this->db->update('orders', $order_rev_status_upadate);
					
    		//Live_tracker Revision Updation
    		$update_revision = $this->db->query("SELECT * FROM `live_revisions` Where `revision_id`='".$_POST['rev_id']."' ")->row_array();
    		if(isset($update_revision['id'])){
    			$tracker_data = array('status' => '2');
    			$this->db->where('id', $update_revision['id']);
    			$this->db->update('live_revisions', $tracker_data);
    		}
    		 redirect('new_designer/home/frontlinetrack_order_list/'.$hd);
		}
		$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `job_accept`='1' AND `cancel`='0' ORDER BY `id` DESC")->result_array();
		$data['prev_rev_orders'] = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `pdf_path`!='none' ORDER BY `id` DESC LIMIT 1")->result_array();
		$prev_rev_orders1 = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `pdf_path`!='none'")->result_array();
		if(isset($prev_rev_orders1[0]['id']))
		{
		$data['prev_rev_orders1'] = $prev_rev_orders1;
		}
		if(!$rev_orders){
		$this->session->set_flashdata("message","Revision Details not Found..!!");
		redirect('new_designer/home/frontlinetrack_order_list/'.$hd);
		}else{
		$data['rev_orders']= $rev_orders; 
		}
		$data['csr'] = $this->db->query('SELECT * FROM `csr` WHERE `is_active` = "1" ORDER BY `name` ASC;')->result_array();
		$data['orders']= $orders;
		$sourcefile = 'sourcefile/'.$order_id.'/'.$cat[0]['slug'] ;
		$map_sourcefile = directory_map($sourcefile.'/');
		if($map_sourcefile){ $data['sourcefile']= $sourcefile; 	}
		//$data['sourcefile'] = $sourcefile;
		}
		
		$this->load->view('new_designer/orderview', $data);
	}
	
	public function test_mail($dataa) 
	{ 
		include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
		
	    $dataa['from'] = trim($dataa['from']);
	    $dataa['replyTo'] = trim($dataa['replyTo']);
	    $dataa['recipient'] = trim($dataa['recipient']);
	    
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($dataa['from'], $dataa['from_display']);
		$email->setReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
		$email->setSubject($dataa['subject']);

		$email->addTo($dataa['recipient'], $dataa['recipient_display']);

        if(isset($dataa['client_Cc']) && !empty($dataa['client_Cc'])){
			$email->addCC($dataa['client_Cc']);  
		}
		
		if(isset($dataa['template'])){
		    //if($this->session->userdata('dId') == 83 || $dataa['orders']['publication_id'] == '3' || $dataa['orders']['group_id'] == '18'){
		        $email->setSubject("Proof Ready - ".$dataa['orders']['id']." - ".$dataa['orders']['advertiser_name']." - ".$dataa['orders']['job_no']);
		        $email->addContent("text/html", $this->load->view('email_template/ProofReady',$dataa, TRUE)); 
		   /* }else{
			    $email->addContent("text/html", $this->load->view($dataa['template'],$dataa, TRUE));
		    }*/
		  if($dataa['template']!='order_rating_mailer'){
			if(isset($dataa['temp'])){ 
			    $file_encoded = base64_encode(file_get_contents($dataa['temp']));
                $email->addAttachment(
                                    $file_encoded,
                                    "application/pdf",
                                    basename($dataa['fname']),
                                    "attachment"
                                );
				//$email->addAttachment($dataa['temp'], "application/pdf", $dataa['fname'], "attachment");
			}  
		  }
		}
		
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);   
	   
	}
	
	public function ftp_zip_folder_select() 
	{
		$hd = $_POST['hd'];
		$help_desk = $this->db->get_where('help_desk',array('id' => $hd))->row_array();
		if($help_desk['ftp_server'] != 'none'){
			$order_id = $_POST['order_id'] ;
			$order_detail = $this->db->get_where('orders', array('id'=>$order_id))->row_array();
			$order_type = $order_detail['order_type_id'] ;
			$cat_slug = $_POST['cat_slug'] ;
			$slug = $_POST['new_slug'] ;
			
				$ftp_server = $help_desk['ftp_server'];
				$ftp_user_name = $help_desk['ftp_username'];
				$ftp_user_pass = $help_desk['ftp_password'];
				//$ftp_folder = $fileuploadstatus[0]['source_path'];
				$ftp_folder = 'Dropzone/sourcefile/'.$order_id.'/'.$cat_slug;
				$conn_id = ftp_connect($ftp_server)or die("couldnt connect to $ftp_server");
				$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("couldnt login to $ftp_server");
				ftp_pasv($conn_id, true);
				if($order_type == '1'){
					$jpgfile = $ftp_folder.'/'.$slug.'.jpg';
					$giffile = $ftp_folder.'/'.$slug.'.gif';
					
					$chk_jpgfile = ftp_size($conn_id, $jpgfile);
					$chk_giffile = ftp_size($conn_id, $giffile);
					
					if($chk_jpgfile != '-1'){
						$ext = 'jpg';
						$pdf_file = $jpgfile;
					}elseif($chk_giffile != '-1'){
						$ext = 'gif';
						$pdf_file = $giffile;
					}
				}else{
					$pdf_file = $ftp_folder.'/'.$slug.".pdf";
					$ext = 'pdf';
				}
				$chk_pdfFile = ftp_size($conn_id, $pdf_file);
				if($chk_pdfFile == '-1'){
					$this->session->set_flashdata("message","PDF File not found in Ftp!!!");
					redirect($redirect);
				}
				//create zip
				$response = file_get_contents("https://ftps1a4l1.adwitads.com/adwitadslivetest/Dropzone/source_zip_folder.php?order_id=$order_id&slug=$cat_slug&new_slug=$slug");
				
				$SourceFilePath = $ftp_server.'/adwitadslivetest/'.$ftp_folder;
			  
				//pdf upload to pdfuploads
				$pdf_uploads = "pdf_uploads/".$order_id ;
					if (@mkdir($pdf_uploads,0777)){}
					$pdf_uploads = $pdf_uploads.'/'.$slug.'.'.$ext ;
					
					if (!@ftp_get($conn_id, $pdf_uploads, $pdf_file, FTP_BINARY)){
						return false;
					}
				return $ext;
		}
	}
	
	function GetDirectorySize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }

	public function new_fileuploads_test($order_id)
	{
		$cat_result = $this->db->query("Select `id`, `slug`, `source_path` FROM `cat_result` WHERE `order_no` = '$order_id'")->row_array();
		if(isset($cat_result['id'])){
			
			$order_path = 'sourcefile'.'/'.$order_id; //directory creation by order Id
			if(!file_exists($order_path)){
				if (@mkdir($order_path,0777)){}
			}
			
			$slug = $cat_result['slug'];
			
			$sourcefile = 'sourcefile'.'/'.$order_id.'/'.$slug; //directory creation by slug name
			if(!file_exists($sourcefile)){
			    if (@mkdir($sourcefile,0777)){}
			}
			
			if($cat_result['source_path'] == 'none'){   //update the source path in cat_result 
				$pro_status = array('source_path' => $sourcefile);
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $pro_status);
			}
			
			if(isset($_POST['msize_id'])){  //multiple size web ad
			    $msize_name = $_POST['msize_id'];
			    $sourcefile .= '/'.$msize_name;
        		if(!file_exists($sourcefile)){
        		    if (@mkdir($sourcefile,0777)){}
        		}
			}
			
			$filetype = $_POST['file_type'];
			//Links folder
			$link_path = $sourcefile.'/Links';
			if (@mkdir($link_path,0777)){}
			
			//Document fonts folder
			$font_path = $sourcefile.'/Document fonts';
			if (@mkdir($font_path,0777)){}	
			
			if($filetype == 'indd' || $filetype == 'psd' || $filetype == 'pdf' || $filetype == 'images' ) 
			{
				if(!empty($_FILES))
				{
					$path_parts = pathinfo($_FILES['file']['name']);
					$fileName = $path_parts['filename'];
					if(isset($_POST['slug_name'])){  //multiple size web ad
					    $slug = $_POST['slug_name'];
					}
					if(strcmp($fileName, $slug) == 0){
						$path = $sourcefile;
						if(!file_exists($path)){ if (@mkdir($path,0777)){} }
						$tempFile = $_FILES['file']['tmp_name'];
						
						$fileExt = $path_parts['extension'];
						$fileExt = strtolower($fileExt);
						if(!move_uploaded_file($tempFile, $path.'/'.$fileName.'.'.$fileExt)){
						    echo "Error Uploading File.. Try Again..!!";
						}else{ echo "success"; }
					}else{ echo "File name(".$fileName.") is not same as slug name(".$slug.")..!!"; }
				}
			}elseif($filetype == 'fonts'){
				if(!empty($_FILES))
				{
					$path = $sourcefile.'/Document fonts';
					if (@mkdir($path,0777)){}
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
					    echo "Error Uploading File.. Try Again..!!";
					}else{ echo "success"; }
				}
			}elseif($filetype == 'links'){
				if(!empty($_FILES))
				{
					$path = $sourcefile.'/Links';
					if (@mkdir($path,0777)){}
					$tempFile = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
					    echo "Error Uploading File.. Try Again..!!";
					}else{ echo "success"; }
				}
			}
		}			
	}
	
	public function new_fileuploads($order_id)
	{
		$cat_result = $this->db->query("Select `id`, `slug`, `source_path` FROM `cat_result` WHERE `order_no` = '$order_id'")->row_array();
		if(isset($cat_result['id'])){
			
			$order_path = 'sourcefile'.'/'.$order_id; //directory creation by order Id
			if(!file_exists($order_path)){
				if (@mkdir($order_path,0777)){}
			}
			
			$slug = $cat_result['slug'];
			
			$sourcefile = 'sourcefile'.'/'.$order_id.'/'.$slug; //directory creation by slug name
			if(!file_exists($sourcefile)){
			    if (@mkdir($sourcefile,0777)){}
			}
			
			if($cat_result['source_path'] == 'none'){   //update the source path in cat_result 
				$pro_status = array('source_path' => $sourcefile);
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $pro_status);
			}
			
			if(isset($_POST['msize_id'])){  //multiple size web ad
			    $msize_name = $_POST['msize_id'];
			    $sourcefile .= '/'.$msize_name;
        		if(!file_exists($sourcefile)){
        		    if (@mkdir($sourcefile,0777)){}
        		}
			}
			
			$filetype = $_POST['file_type'];
			//Links folder
			$link_path = $sourcefile.'/Links';
			if (@mkdir($link_path,0777)){}
			
			//Document fonts folder
			$font_path = $sourcefile.'/Document fonts';
			if (@mkdir($font_path,0777)){}	
			
			if(file_exists($sourcefile) && !empty($sourcefile)){ 
			    //check for file size
			   $source_package_size = $this->GetDirectorySize($sourcefile); //In bytes
			   $tsize = $source_package_size + $_FILES['file']['size'] ; //In bytes
			   $tsize_mb = number_format($tsize / 1048576, 2); //In MB
			   $allowed_fsize = '800'; //In MB
			   if($tsize_mb > $allowed_fsize){
			     $source_package_size = number_format($source_package_size / 1048576, 2) . ' MB';
			     $uploaded_fsize = number_format($_FILES['file']['size'] / 1048576, 2) . ' MB';
			     echo "File Upload failed...Allowed Max Size for package is ".$allowed_fsize." MB. The package already contains files of size - ".$source_package_size.". The uploaded file size is ".$uploaded_fsize;  
			   }else{
			   		if($filetype == 'indd' || $filetype == 'psd' || $filetype == 'pdf' || $filetype == 'images' ) 
        			{
        				if(!empty($_FILES))
        				{
        					$path_parts = pathinfo($_FILES['file']['name']);
        					$fileName = $path_parts['filename'];
        					if(isset($_POST['slug_name'])){  //multiple size web ad
        					    $slug = $_POST['slug_name'];
        					}
        					if(strcmp($fileName, $slug) == 0){
        						$path = $sourcefile;
        						if(!file_exists($path)){ if (@mkdir($path,0777)){} }
        						$tempFile = $_FILES['file']['tmp_name'];
        						
        						$fileExt = $path_parts['extension'];
        						$fileExt = strtolower($fileExt);
        						if(!move_uploaded_file($tempFile, $path.'/'.$fileName.'.'.$fileExt)){
        						    echo "Error Uploading File.. Try Again..!!";
        						}else{ echo "success"; }
        					}else{ echo "File name(".$fileName.") is not same as slug name(".$slug.")..!!"; }
        				}
        			}elseif($filetype == 'fonts'){
        				if(!empty($_FILES))
        				{
        				    $font_file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            if(strtoupper($font_file_ext) != 'INDD'){ //disallow .indd files 15March2023
            					$path = $sourcefile.'/Document fonts';
            					if (@mkdir($path,0777)){}
            					$tempFile = $_FILES['file']['tmp_name'];
            					$fileName = $_FILES['file']['name'];
            					if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
            					    echo "Error Uploading File.. Try Again..!!";
            					}else{ echo "success"; }
                            }
        				}
        			}elseif($filetype == 'links'){
        				if(!empty($_FILES))
        				{
        				    $link_file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            if(strtoupper($link_file_ext) != 'INDD'){ //disallow .indd files 15March2023
                            	$path = $sourcefile.'/Links';
            					if (@mkdir($path,0777)){}
            					$tempFile = $_FILES['file']['tmp_name'];
            					$fileName = $_FILES['file']['name'];
            					if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
            					    echo "Error Uploading File.. Try Again..!!";
            					}else{ echo "success"; }
                            }
        				}
        			}
		        }
	        }
		}			
	}
	
	public function idml_upload($order_id)
	{
		$slug = $_POST['slug_name'];
		$filetype = $_POST['file_type'];
		if($filetype == 'idml')
		{
			if(!empty($_FILES))
			{
				$path = 'sourcefile'.'/'.$order_id.'/'.$slug;
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				
				$path_parts = pathinfo($_FILES['file']['name']);
				$fileName = $path_parts['filename'];
				$fileExt = $path_parts['extension'];
				$fileExt = strtolower($fileExt);
				if(!move_uploaded_file($tempFile, $path.'/'.$fileName.'.'.$fileExt)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
				redirect('new_designer/home'); }
			}
		}		
	}
	
	public function attach_pickup_file($order_id='')
	{
		$filetype = $_POST['file_type'];
		if($filetype)
		{
			if(!empty($_FILES))
			{
				//pickup folder
				$path="downloads/pickup/".$order_id;
				if (!is_dir($path)) {
				mkdir($path, 0777, true);
				}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
					$this->session->set_flashdata('message','<button type="button" class="form-control btn  btn-danger">Error Uploading File.. Try Again..!! </button>');
				redirect('new_designer/home'); }
			}
		} if(isset($_POST['redirect'])) redirect($_POST['redirect']);
	}
	
	public function unzip_folder($path, $fname, $redirect) 
	{
		$path = $path.'/';
		$zip = new ZipArchive;
		$file = $path.''.$fname;
		chmod($file,0777);
		if($zip->open($file) === TRUE){
			$zip->extractTo($path);
			$zip->close();
				//echo 'ok';
			$this->load->helper('directory');
			$map = glob($path.'/*.{indd,ai,psd}',GLOB_BRACE);
			if($map){
				foreach($map as $row)
				{
					return basename($row);
				}
			}else{ 
				$this->session->set_flashdata("message","No Source File(indd,ai,psd) Found");			
				redirect($redirect);
			}
		}else{
				$this->session->set_flashdata("message","Unable to open File ".$file);			
				redirect($redirect);
		}
		
	}
	
	public function rev_new_fileuploads($order_id)
	{
		$order_path = 'sourcefile'.'/'.$order_id;
		if(!file_exists($order_path)){
			if (@mkdir($order_path,0777)){}
		}
		$slug = $_POST['cat_slug'];
		$filetype = $_POST['file_type'];
		$slug_name = $_POST['slug_name'];
		
		$sourcefile = $order_path.'/'.$slug;
		
		if(isset($_POST['msize_id'])){  //multiple size web ad
		    $msize_name = $_POST['msize_id'];
			$sourcefile .= '/'.$msize_name;
            if(!file_exists($sourcefile)){
        	    if (@mkdir($sourcefile,0777)){}
        	}
	    }
			
		//Links folder
		$link_path = $sourcefile.'/Links';
		if (@mkdir($link_path,0777)){}
		
		//Document fonts folder
		$font_path = $sourcefile.'/Document fonts';
		if (@mkdir($font_path,0777)){}	
					
		if($filetype == 'indd' || $filetype == 'psd')
		{
			if(!empty($_FILES)){
				$path_parts = pathinfo($_FILES['file']['name']);
				$fileName = $path_parts['filename'];
				if(strcmp($fileName, $slug_name) == 0){
					$path = $sourcefile;
					if (@mkdir($path,0777)){}
					$tempFile = $_FILES['file']['tmp_name'];
					//$fileName = $_FILES['file']['name'];
					
					$fileExt = $path_parts['extension'];
					$fileExt = strtolower($fileExt);
					//$end = preg_split("/[.]+/", $fileName);
					//$ext = end($end);
					if($fileExt == 'indd' || $fileExt == 'psd'){
						$upload_path = $fileName.'.'.$fileExt;
						if(!move_uploaded_file($tempFile, $path.'/'.$fileName.'.'.$fileExt)){
							echo "Error Uploading File.. Try Again..!!";
						}else{ echo "success"; }
						$post = array('source_file' => $upload_path);
						$this->db->where('id', $_POST['rev_id']);
						$this->db->update('rev_sold_jobs', $post);
					}
				}else{ echo"slugname-filename error"; }
			}
		}elseif($filetype == 'pdf' || $filetype == 'images' ){
			if(!empty($_FILES)){
				$path_parts = pathinfo($_FILES['file']['name']);
				$fileName = $path_parts['filename'];
				if(strcmp($fileName, $slug_name) == 0){
					$path = $sourcefile;
					if (@mkdir($path,0777)){}
					$tempFile = $_FILES['file']['tmp_name'];
					//$fileName = $_FILES['file']['name'];
					
					$fileExt = $path_parts['extension'];
					$fileExt = strtolower($fileExt);
					//$end = preg_split("/[.]+/", $fileName);
					//$ext = end($end);
					if($fileExt == 'pdf' || $filetype == 'images'){
						$upload_path = $fileName.'.'.$fileExt;
						if(!move_uploaded_file($tempFile, $path.'/'.$fileName.'.'.$fileExt)){
							echo "Error Uploading File.. Try Again..!!";
						}else{ echo "success"; }
						$post = array('pdf_file' => $upload_path);
						$this->db->where('id', $_POST['rev_id']);
						$this->db->update('rev_sold_jobs', $post);
					}
				}else{ echo"slugname-filename error"; }
			}
		}elseif($filetype == 'fonts'){
			if(!empty($_FILES))
			{
				$path = $sourcefile.'/Document fonts';
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
					echo "Error Uploading File.. Try Again..!!"; 
				}else{ echo "success"; }
			}
		}elseif($filetype == 'links'){
			if(!empty($_FILES))
			{
				$path = $sourcefile.'/Links';
				if (@mkdir($path,0777)){}
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				if(!move_uploaded_file($tempFile, $path.'/'.$fileName)){
					echo "Error Uploading File.. Try Again..!!";
				}else{ echo "success"; }
			}
		}
	}
	
	
	function source_file_uploads($redirect)
	{
		$sourcefile = $_POST['sourcefile']; $count=0;
		//Links folder
		$link_path = $sourcefile.'/Links';
		if (@mkdir($link_path,0777))
		{

		}
		//Document fonts folder
		$font_path = $sourcefile.'/Document fonts';
		if (@mkdir($font_path,0777))
		{

		}	
		//Source
			if(isset($_FILES['src_file']['name']) && !empty($_FILES['src_file']['tmp_name'])){
					$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['src_file']['name']);
					$fname = $_POST['slug'].'.'.$ext;
					if($_FILES['src_file']['name']==$fname){
						$sourcePath = $_FILES['src_file']['tmp_name'];
						$targetPath =  $sourcefile.'/'.$_FILES['src_file']['name'];
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Source file.. Try Again!!");
							redirect($redirect);
						}
					}else{
						$this->session->set_flashdata("msg", "Sorry Wrong File.. Make sure that the file names are same as the slug!!");
						redirect($redirect); 
					}
				}
		//PDF
			if(isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['tmp_name'])){
					$ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['pdf_file']['name']);
					$fname = $_POST['slug'].'.'.$ext;
					//$fname = $_POST['slug'].'.pdf';
					if($_FILES['pdf_file']['name']==$fname){
						$sourcePath = $_FILES['pdf_file']['tmp_name'];
						$targetPath =  $sourcefile.'/'.$_FILES['pdf_file']['name'];
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Pdf file.. Try Again!!");
							redirect($redirect);
						}
					}else{
						$this->session->set_flashdata("msg", "Sorry Wrong File.. Make sure that the file names are same as the slug!!");
						redirect($redirect); 
					}
				}	
		//Links
			if(isset($_FILES['link_file']['tmp_name']) && !empty($_FILES['link_file']['tmp_name'][0])){
					$link_path = $sourcefile.'/Links';
					if (@mkdir($link_path,0777))
					{

					}
					$count= count($_FILES['link_file']['name']);
					for($i=0;$i<$count;$i++){
						$sourcePath = $_FILES['link_file']['tmp_name'][$i];
						$targetPath =  $link_path.'/'.$_FILES['link_file']['name'][$i];
						 
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Link files.. Try Again!!".$count);
							redirect($redirect);
						}
					}
				}
		//Fonts
			if(isset($_FILES['font_file']['tmp_name']) && !empty($_FILES['font_file']['tmp_name'][0])){
					$font_path = $sourcefile.'/Document fonts';
					if (@mkdir($font_path,0777))
					{

					}
					$count= count($_FILES['font_file']['name']);
					for($i=0;$i<$count;$i++){
						$sourcePath = $_FILES['font_file']['tmp_name'][$i];
						$targetPath =  $font_path.'/'.$_FILES['font_file']['name'][$i];
						 
						if(!move_uploaded_file($sourcePath,$targetPath)){
							$this->session->set_flashdata("message", "Error Uploading Font files.. Try Again!!");
							redirect($redirect);
						}
					}
				}
				
		return true;
			
	}
	
	public function attach_pickup_fileold($order_id='')
	{
		if(isset($_POST['pickup_submit']))
	    {
			$dir1="downloads/pickup/".$order_id;
			/* if (@mkdir($dir1,0777))
				{} */
			if (!is_dir($dir1)) {
            mkdir($dir1, 0777, true);
			}
			$file = array(); $path = array();
			for($i=0;$i<5;$i++)	//file data sent to create_folder function
			{
				if (!empty($_FILES['file']['tmp_name'][$i]))
				{
					//replace filename with special char with '_'
					$file[] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $_FILES['file']['name'][$i]);
					
					//upload path
					$path[]= $dir1.'/'.$file[$i];
					
					//copy file 
					if(!copy($_FILES['file']['tmp_name'][$i], $path[$i]))
					{
						$this->session->set_flashdata("message","File upload has encountered an error!! Try Again...");
						if(isset($_POST['redirect'])) redirect($_POST['redirect']);
					}
				}
			}
		}
		 if(isset($_POST['redirect'])) redirect($_POST['redirect']);
	}
	/************************ tscs send to adrep END*****************************/
	function unzip_file($source_path, $destination_path)
	{
	    $zip = new ZipArchive;
        $res = $zip->open($source_path);
        if ($res === TRUE) {
          $zip->extractTo($destination_path);
          $zip->close();
          return true; //echo 'woot!';
        } else {
          return false; //echo 'doh!';
        }
	}
	
	function zip_ffile($source_path, $destination_path)
	{
	    $this->load->library('zip');
	    $this->zip->clear_data();
		if($this->zip->read_dir($source_path, FALSE)){
            if($this->zip->archive($destination_path) == true){ 
                return true;
        	}else{
        		return false;
            }
        }else{ return false; }
	}
	
    //outgoing upload proof zip file to ftp
	public function tscs_outgoing_ftp($file_to_be_sent, $type_of_ad)             
	{
	    define('FTP_URL', 'ftp.timesshamrock.com');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'MapleCarFish!');
        define('FTP_DIRECTORY', './RETURN_TO_TRACK');
        if($type_of_ad == 'new_ad'){
            $local_path = "temp_tscs/OUTGOING/NEW";
        }elseif($type_of_ad == 'revision_ad'){
            $local_path = "temp_tscs/OUTGOING/CORRECTION";
        }
        $file_with_path = $local_path.'/'.$file_to_be_sent;
        if(file_exists($file_with_path)){ //ftp connect only if folder not empty
            //Connect ot FTP
            $ftp = ftp_connect(FTP_URL);
            //Login to FTP
            ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
            ftp_pasv($ftp, true);
            
            if(ftp_put($ftp, FTP_DIRECTORY.'/'.$file_to_be_sent, $file_with_path, FTP_BINARY)) {
                return true;//echo "SUCCESS";//unlink($file_with_path);
            }else{
                return false;//echo "There was a problem while uploading $file\n"; exit;
            }
            
            ftp_close($ftp);
        }
	}
	
    public function tscs_send_to_adrep($id, $type_of_ad) //$id = order_id/rev_sold_job_id, $type_of_ad = new_ad/revision_ad
	{ 
	    $message = 'success';
	    if($type_of_ad == 'new_ad'){
	        $q = "SELECT orders.job_no, orders.file_path, cat_result.source_path, cat_result.slug FROM `orders`
	                JOIN `cat_result` ON cat_result.order_no = orders.id
	                    WHERE orders.id = $id";
	         $outgoing_path = 'temp_tscs/OUTGOING/NEW'; 
	         $outgoing_path_archive = 'temp_tscs/OUTGOING/NEW_archive';
	    }else{
	        $q = "SELECT orders.job_no, rev_sold_jobs.file_path, cat_result.source_path, rev_sold_jobs.new_slug AS slug FROM `rev_sold_jobs`
	                JOIN `orders` ON orders.id = rev_sold_jobs.order_id
	                JOIN `cat_result` ON cat_result.order_no = orders.id
	                    WHERE rev_sold_jobs.id = $id ORDER BY rev_sold_jobs.id DESC LIMIT 1";
	       $outgoing_path = 'temp_tscs/OUTGOING/CORRECTION';
	       $outgoing_path_archive = 'temp_tscs/OUTGOING/CORRECTION_archive';
	    }
		$order_detail = $this->db->query("$q")->row_array();
		//check for zip file(one we got from ftp) in downloads folder- match job_no.zip
		if(isset($order_detail['file_path'])){
		    $job_name = $order_detail['job_no'];
		    $zip_fname = $job_name.'.zip' ;
		    $zip_file_path = $order_detail['file_path'].'/'.$zip_fname;
		    if(!file_exists($zip_file_path)){ //in case job name renamed by csr 
		        $split_job_name = str_split($order_detail['job_no'], strlen($order_detail['job_no']) - 1);
		        $job_name = $split_job_name[0];
		        $zip_fname = $job_name.'.zip' ;
		        $zip_file_path = $order_detail['file_path'].'/'.$zip_fname; 
		    }
		    if(file_exists($zip_file_path)){
		        //unzip the zip file
		        $zip_source_path = $zip_file_path;
		        $unzip_destination_path = 'temp_tscs/OUTGOING/unzip';
		        $response = $this->unzip_file($zip_source_path, $unzip_destination_path);
		        if($response === true){
		            //get indd file details from unzipped folder
		            $ftp_unzip_path = $unzip_destination_path.'/'.$job_name; //$ftp_unzip_path = $unzip_destination_path.'/'.$order_detail['job_no'];
		            $map_indd = glob($ftp_unzip_path.'/*.{indd,INDD}',GLOB_BRACE);
		            if($map_indd){
    		            foreach($map_indd as $row){
    		                $ftp_unzip_indd = basename($row);   
    		            }
        		        if(file_exists($order_detail['source_path']) && isset($ftp_unzip_indd)){
        		            $source_path = $order_detail['source_path'];
        		            $slug = $order_detail['slug'];
        		            $source_indd_file = $slug.'.indd';
        		            $map_source_indd = glob($source_path.'/'.$slug.'.{indd,INDD}',GLOB_BRACE);
        		            if($map_source_indd){ $source_indd_file = basename($map_source_indd[0]);  }
        		            $source_indd_path = $source_path.'/'.$source_indd_file;
        		            //check for sourcepath for slug.indd file
        		            if(file_exists($source_indd_path)){
        		                //rename sourcepath/slug.indd file to zip file indd file and replace the zip file indd file so that its the one designed by adwitads design team
        		                copy($source_indd_path, $ftp_unzip_path.'/'.$ftp_unzip_indd);
        		                
        		                //??? and also upload any additional link files by renaming it to the job_no
        		                $link_file_path = $source_path.'/Links';
        		                if ($handle = opendir($link_file_path)) {
                                    while (false !== ($entry = readdir($handle))) {
                                        if ($entry != "." && $entry != "..") {
                                            $ext = pathinfo($entry, PATHINFO_EXTENSION);
                                            if(strtoupper($ext) != 'INDD'){
                                                $name = basename($entry,$ext);
                                                if(strcmp($job_name, substr($name,0,strlen($job_name))) == 0){ //check whether the link name starts with job_no
                                                    $source_link_path = $link_file_path.'/'.$entry;
                                                    $destination_link_path = $ftp_unzip_path.'/'.$entry;
                                                }else{
                                                    //rename and copy
                                                    $source_link_path = $link_file_path.'/'.$entry;
                                                    $rename = $job_name.'_'.$name.$ext;
                                                    $destination_link_path = $ftp_unzip_path.'/'.$rename;    
                                                }
                                                copy($source_link_path, $destination_link_path); 
                                            }
                                        }
                                    }
                                    closedir($handle);
                                }
        		                //zip the files (job_no.zip) into NEW/CORRECTION folder 
        		                $save_zip_to_path = $outgoing_path.'/'.$zip_fname;
        		                $save_zip_to_path_archive = $outgoing_path_archive.'/'.$zip_fname;
        		                if($this->zip_ffile($ftp_unzip_path, $save_zip_to_path) === true){
        		                    //ftp upload
                                    if($this->tscs_outgoing_ftp($zip_fname, $type_of_ad) === true){
            		                    //delete unzip folder and files
                                        $di = new RecursiveDirectoryIterator($ftp_unzip_path, FilesystemIterator::SKIP_DOTS);
                                        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
                                        foreach ( $ri as $file ) {
                                            $file->isDir() ?  rmdir($file) : unlink($file);
                                        }
                                        rmdir($ftp_unzip_path);
                                        //move the package to archive folder
                                        rename($save_zip_to_path , $save_zip_to_path_archive);
                                    }else{ $message = "ftp upload failed.."; }
                                }else{ $message = "zip operation failed.."; }
        		            }else{ $message = "source file missing"; }
        		        }else{ $message = "source folder missing"; }
		            }else{ $message = "ftp indd missing"; }
		        }else{ $message = "unzip operation failed.."; }
		    }else{ $message = "downloads zip file missing - ".$zip_fname; }
		}else{ $message = "downloads folder missing"; }
		return $message;
	}
	
	/************************ tscs send to adrep END*****************************/
	public function metro_ftp($pdf_file)
	{ 
		//FTP for Metro help desk(2)
		if(isset($pdf_file) && $pdf_file!=''){
			$ftp_server1 = 'ftp.adwitads.com';
			//$ftp_server2 = 'ftps1a4l2.adwitads.com';
			//$ftp_server3 = 'ftps1a4l3.adwitads.com';
			
			if (!@ftp_connect($ftp_server1)) {
				
				if (!@ftp_connect($ftp_server2)){ 
					
					$ftp_conn = @ftp_connect($ftp_server3) or die("couldnt connect to $ftp_server3");
				}else{
					$ftp_conn = ftp_connect($ftp_server2) or die("Could not connect to $ftp_server2");
				}
			}else{
				$ftp_conn = ftp_connect($ftp_server1) or die("Could not connect to $ftp_server1");
			}
			
			$ftp_username='aod@adwitads.com';
			$ftp_userpass='adwit@123';
			$folder_name = 'PROOF';
			//$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			$path = 'outgoing/PROOF/';
			if(!ftp_nlist($ftp_conn, $path)){ 
				if (@ftp_mkdir($ftp_conn, $path))
				{
					
				}
			}
			
			$file = $pdf_file;
			$fname = basename($file);
			$fname = str_replace('_','-',$fname);
			// upload file
			if (@ftp_put($ftp_conn, $path.'/'.$fname, $file, FTP_BINARY)){
				return true;
			}else{
				return false;;
			}
			// close connection
			ftp_close($ftp_conn);
		}
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
			$idml_path = $SourceFilePath.'/'.$new_slug.'.idml';
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
			if(file_exists($idml_path)){
				$this->zip->read_file($idml_path);
			}
			
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
	
	function multiple_zip_folder_select($order_id) //multiple web ads
	{
	    $order_details = $this->db->query('SELECT * FROM `orders` WHERE `id` = "'.$order_id.'"')->row_array();
	    if(isset($order_details['id'])){
	       $new_slug = $_POST['new_slug'] ;
	       //if(isset($_POST['order_id'])){ $order_id = $_POST['order_id']; }
	       if($order_details['ad_format']=='5'){ //flexitive ad (flexitive size)
		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.id, flexitive_size.ratio AS name FROM `orders_multiple_size`
                							                LEFT JOIN `flexitive_size` ON flexitive_size.id = orders_multiple_size.size_id
                							                    WHERE orders_multiple_size.order_id = '".$order_details['id']."'")->result_array();
		    }else{ //pixel size
		        $orders_multiple_size = $this->db->query("SELECT orders_multiple_size.id, CONCAT(pixel_sizes.width,'x',pixel_sizes.height) AS name FROM `orders_multiple_size`
                							                LEFT JOIN `pixel_sizes` ON pixel_sizes.id = orders_multiple_size.size_id
                							                WHERE orders_multiple_size.order_id = '".$order_details['id']."'")->result_array();
		    }
		    $orders_multiple_custom_size = $this->db->query("SELECT *, CONCAT(custom_width,'x',custom_height) AS name FROM `orders_multiple_custom_size` WHERE `order_id` = '".$order_details['id']."'")->result_array();
            
	       //$orders_multiple_size = $this->db->query('SELECT * FROM `orders_multiple_size` WHERE `order_id` = "'.$order_id.'"')->result_array();
	       if(isset($orders_multiple_size[0]['id']) || isset($orders_multiple_custom_size[0]['id'])){
	           $this->load->library('zip');
			   $this->load->helper('directory');
	           
	           if(isset($orders_multiple_size[0]['id'])){
    	           foreach($orders_multiple_size as $msize){
    	               $SourceFilePath = $_POST['source_path'].'/'.$msize['name'] ;
    	               $slug_fname = $new_slug.'_'.$msize['name'];
    	               //$this->zip->read_dir($SourceFilePath, FALSE);
    	               $font_path = $SourceFilePath.'/Document fonts/';
            			$links_path = $SourceFilePath.'/Links/';
            			$src_path =  $SourceFilePath.'/'.$slug_fname.'.psd';
            			//$pdf_path =  $SourceFilePath.'/'.$pdf_file;
            			$idml_path = $SourceFilePath.'/'.$new_slug.'.idml';
            			
            			if(file_exists($src_path)){
            			    $new_path = $msize['name'].'/'.$slug_fname.'.psd';
            				$this->zip->read_file($src_path, $new_path);
            			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
            			
            			if(file_exists($idml_path)){
            				$this->zip->read_file($idml_path);
            			}
            			
            				$this->load->helper('directory');	
            				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
            				if($map){ foreach($map as $row){
            				    $new_path = $msize['name'].'/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            				} } 
            			
            			$map_font = glob($font_path.'*',GLOB_BRACE);
            			$map_link = glob($links_path.'*',GLOB_BRACE); 
            			if($map_font){
            			    foreach($map_font as $row){
            			        $new_path = $msize['name'].'/Document fonts/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            			}	
            			if($map_link){ 
            			    foreach($map_link as $row){
            			        $new_path = $msize['name'].'/Links/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            			}
    	           }
	           }
	           if(isset($orders_multiple_custom_size[0]['id'])){
    	           foreach($orders_multiple_custom_size as $mcsize){
    	               $SourceFilePath = $_POST['source_path'].'/'.$mcsize['name'] ;
    	               $slug_fname = $new_slug.'_'.$mcsize['name'];
    	               //$this->zip->read_dir($SourceFilePath, FALSE);
    	               
    	               $font_path = $SourceFilePath.'/Document fonts/';
            			$links_path = $SourceFilePath.'/Links/';
            			$src_path =  $SourceFilePath.'/'.$slug_fname.'.psd';
            			//$pdf_path =  $SourceFilePath.'/'.$pdf_file;
            			$idml_path = $SourceFilePath.'/'.$new_slug.'.idml';
            			
            			if(file_exists($src_path)){
            				$new_path = $mcsize['name'].'/'.$slug_fname.'.psd';
            				$this->zip->read_file($src_path, $new_path);
            			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
            			
            			if(file_exists($idml_path)){
            				$this->zip->read_file($idml_path);
            			}
            			
            				$this->load->helper('directory');	
            				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
            				if($map){ foreach($map as $row){
            					$new_path = $mcsize['name'].'/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            				} } 
            			
            			
            			$map_font = glob($font_path.'*',GLOB_BRACE);
            			$map_link = glob($links_path.'*',GLOB_BRACE); 
            			if($map_font){
            			    foreach($map_font as $row){
            			        $new_path = $mcsize['name'].'/Document fonts/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            			}	
            			if($map_link){ 
            			    foreach($map_link as $row){
            			        $new_path = $mcsize['name'].'/Links/'.basename($row);
            					$this->zip->read_file($row, $new_path);
            			    }
            			}
    	           }
	           }
        	    if(isset($_POST['download'])){
        			$this->zip->archive($_POST['source_path'].'/'.$new_slug.'.zip');
        			$this->zip->download($new_slug.'.zip');
        		}else{
        		    $this->zip->archive($_POST['source_path'].'/'.$new_slug.'.zip');
        		    
        			//send source zip to ftp( metro design6 design7)
        			if(isset($_POST['hd']) && isset($order_id) && ($_POST['hd']=='2')){
        				$post = array('order_id' => $order_id, 'hd' => $_POST['hd'], 'slug' => $new_slug, 'path' => $_POST['source_path']);
        				$this->db->insert('sourcefile_move', $post);
        			}   
        			
        			//send to adrep
        				 
        			$pdf_uploads = "pdf_uploads/".$order_id ;
        			if (@mkdir($pdf_uploads,0777)){}
        			$this->load->library('zip');
        			$this->zip->clear_data();

        			foreach($orders_multiple_size as $msize){ //multiple web ads
        			    $SourceFilePath = $_POST['source_path'].'/'.$msize['name'] ;
        			    $slug_fname = $new_slug.'_'.$msize['name'];
        				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
        				
            			if($map){ foreach($map as $row){
            			    $new_path = $msize['name'].'/'.basename($row);
            				$this->zip->read_file($row, $new_path);    
            			} }
        			}
        			foreach($orders_multiple_custom_size as $mcsize){ //multiple custom
        			   	$SourceFilePath = $_POST['source_path'].'/'.$mcsize['name'] ;
        			   	$slug_fname = $new_slug.'_'.$mcsize['name'];
        				$map = glob($SourceFilePath.'/'.$slug_fname.'.{pdf,jpg,gif,png}',GLOB_BRACE);
        				
            			if($map){ foreach($map as $row){
            			    $new_path = $mcsize['name'].'/'.basename($row);
            				$this->zip->read_file($row, $new_path); 
            			} }
        			}
        			
        			if($this->zip->archive($pdf_uploads.'/'.$new_slug.'.zip') == TRUE){
        			    return true;
        			}else{
        			    return false;
        			}
        			
        			return true;
        		}
	        }
	    }
						
	}
	
	function rrmdir($dir) { 
       if (is_dir($dir)) { 
         $objects = scandir($dir);
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
               $this->rrmdir($dir. DIRECTORY_SEPARATOR .$object);
             else
               unlink($dir. DIRECTORY_SEPARATOR .$object); 
           } 
         }
         rmdir($dir); 
       } 
    }

	public function designer_NJ($num_days='')
	{ 	
		$data['today'] = date('Y-m-d');
		$dId = $this->session->userdata('dId');
		if($num_days!=''){
			$data['from'] = date('Y-m-d', strtotime("-$num_days day", strtotime(date('Y-m-d'))));
			$data['to'] = date('Y-m-d');
		}
		$data['num_days'] = $num_days;
		$data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$dId' AND `is_active`='1' ")->result_array();
		
		$this->load->view('new_designer/designer_NJ',$data);
	}

	public function frename()
	{
		$cat[0]['source_path']='sourcefile/182314/unidemoadjob01_advtdemoad01_dm_182314_C_999_V1';
		$slug = 'unidemoadjob01_advtdemoad01_dm_182314_C_999_V1';
		$inddfile = $cat[0]['source_path'].'/'.$slug.".psd";
		$pdffile = glob($cat[0]['source_path'].'/'.$slug.'.{jpg,gif}', GLOB_BRACE);
		
		foreach($pdffile as $row){
			$ext = pathinfo(basename($row), PATHINFO_EXTENSION);
			$pdffile = $row;
		}				
		$inddtemp1 = $cat[0]['source_path'].'/'.'temp1'.".psd";
		$pdftemp1 = $cat[0]['source_path'].'/'.'temp1'.".".$ext;
		
		$inddtemp2 = $cat[0]['source_path'].'/'.'temp2'.".psd";
		$pdftemp2 = $cat[0]['source_path'].'/'.'temp2'.".".$ext;
		
		$inddtemp3 = $cat[0]['source_path'].'/'.'temp3'.".psd";
		$pdftemp3 = $cat[0]['source_path'].'/'.'temp3'.".".$ext;
		
			if(file_exists($inddfile) && file_exists($pdffile)){
			if(file_exists($inddtemp1) && file_exists($pdftemp1)){
				rename($inddfile,$inddtemp2);
				rename($pdffile,$pdftemp2);
			}elseif(file_exists($inddtemp2) && file_exists($pdftemp2)){
				rename($inddfile,$inddtemp3);
				rename($pdffile,$pdftemp3);
			}else{
				rename($inddfile,$inddtemp1);
				rename($pdffile,$pdftemp1);
			} 
		}
	}
	
	function emptyDir($dir) {
		if (is_dir($dir)) {
			$scn = scandir($dir);
			foreach ($scn as $files) {
				if ($files !== '.') {
					if ($files !== '..') {
						if (!is_dir($dir . '/' . $files)) {
							unlink($dir . '/' . $files);
						} else {
							$this->emptyDir($dir . '/' . $files);
							rmdir($dir . '/' . $files);
						}
					}
				}
			}
		}
	}
	//cshift order search START
	public function cshift_order_search() //Id - search by order id
	{
		if(isset($_GET['search']) && !empty($_GET['search_id'])){
			$upload_count = 0;
			$today = date('Y-m-d 23:59:59');
			$dId = $this->session->userdata('dId');
		
			$data['dId'] = $dId;
			$search_id = $_GET['search_id'];	
			$orders = $this->db->get_where('orders', array('id' => $search_id))->result_array();
			
			if(isset($orders[0]['id']) && $orders[0]['id'] == $search_id){
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE  `order_id`='$search_id' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
				if($rev_orders){ 
					$data['rev_orders'] = $rev_orders; 
					}
					$data['orders'] = $orders;
				$this->load->view('new_designer/cshift_order_search',$data);	
			}else{
				$data['msg'] = "hello";
				$this->load->view('new_designer/cshift_order_search',$data);
			}
			
		}
	}
	
	public function cshift_advance_search() //All - search by id, advt, job
	{
		if(isset($_GET['advance_search']) && !empty($_GET['advance_search_id'])){
		    $upload_count = 0;
			$today = date('Y-m-d 23:59:59');
			$dId = $this->session->userdata('dId');
			$data['dId'] = $dId;
			
			$search_id = $_GET['advance_search_id'];
			$orders = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
			FROM `orders` WHERE (`id` LIKE '%".$search_id."%' OR `advertiser_name` LIKE '%".$search_id."%' OR `job_no` LIKE '%".$search_id."%')")->result_array();
			if(isset($orders[0]['id'])){
				$id = $orders[0]['id'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id` = '$id' ORDER BY `id` DESC LIMIT 1;")->result_array();
				if($rev_orders){ $data['rev_orders'] = $rev_orders; }
				$data['orders'] = $orders;
				$this->load->view('new_designer/cshift_order_search',$data);	
			}else{
				$data['msg'] = "hello";
				$this->load->view('new_designer/cshift_order_search',$data);
			}
		}
	}
	//cshift order search END
	public function orderview_history($hd="",$order_id="")
	{
		$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		
		//$data['order_revision_review'] = $this->db->query("SELECT * FROM order_revision_review WHERE order_id='$order_id'")->row_array();
		if(isset($_POST['submit_mistake']) && !empty($_POST['mistake'])){
			$review_data = array(	'order_id' => $order_id, 
									'designer_id' => $this->session->userdata('dId'), 
									'designer_mistake' => $_POST['mistake'],
									'version' => $_POST['version'],
									'rev_id' => $_POST['rev_id']
								);
			$this->db->insert('order_revision_review', $review_data);
			redirect('new_designer/home/orderview_history/'.$hd.'/'.$order_id);
		}
		
		if($hd != '' && $hd != '0' && $order_id != '' && isset($orders[0]['id']))
		{
			$this->load->helper('directory');
			$redirect = 'new_designer/home/orderview/'.$hd.'/'.$order_id;
			$data['redirect']= $redirect;
			$data['order_id']= $order_id; 
			$data['hd']= $hd;
			if(!$orders){
				$this->session->set_flashdata("message","Order: Details not Found!!");
				redirect('new_designer/home/live_new_ads'); //redirect('new_designer/home/cshift/'.$hd);
			}
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->result_array();
			if(isset($rev_orders[0]['id'])){ $data['rev_orders'] = $rev_orders; }
			
			$pro_conversation = $this->db->query("SELECT * from `production_conversation` where `order_id` = '$order_id' ")->result_array();
				if($pro_conversation){
					$data['pro_conversation'] = $pro_conversation;
				}
			
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
			$data['rev_reason'] = $this->db->query("SELECT * FROM `rev_reason`")->result_array();
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
			$this->load->view('new_designer/orderview_history', $data);			
		}			
	}
	
/*	public function team_report($num_days='')
	{
		$data['today'] = date('Y-m-d');
		$dId = $this->session->userdata('dId');
		if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
			$from = $_GET['from_date'];
			$to = $_GET['to_date'];
			$data['from'] = $from;
            $data['to'] = $to;
		}
		$data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `is_active`='1' ")->result_array();
		
		$this->load->view('new_designer/team_report', $data);
	}
	*/
	public function team_report($num_days='')
	{
		$today = date('Y-m-d');
		$dId = $this->session->userdata('dId');
		$data['from_date_range'] = $today.' 00:00:00';
        $data['to_date_range'] = $today.' 23:59:59';
		$this->load->view('new_designer/team_report', $data);
	}
	
	public function team_report_details()
	{
	    $date = $_POST['dateRange'];
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
        		}elseif($date == 'custom' && isset($_POST['from_date'])){
        				$from = $_POST['from_date'];
        				$to =  $_POST['to_date'];
        		}
        		
	   $dId = $this->session->userdata('dId');
	   $adwit_team_id = $this->session->userdata('dTeamId');
	   
        $designer_list = "SELECT d2.id FROM `designers` d1
                                                INNER JOIN `designers` d2 ON d1.adwit_teams_id = d2.adwit_teams_id
                                                    WHERE d1.id = $dId AND d2.designer_role != 2";                                            
	   //$designer_id = $_POST['designerId'];
	   //$pro_status = $_POST['proStatus'];
	   //$from_date_range = $_POST['fromDate'];
	   //$to_date_range = $_POST['toDate'];
	   $data = array();
	   //teamlead designer ad volume dashboard teamlead_designer_volume_new

    	if($dId != '187'){ //for kishore login
			$qq = "SELECT COUNT(cat_result.order_no) AS adCount, CONCAT(designers.name,' (',designers.username,')') AS name, designers.id, cat_result.pro_status FROM `designers`
			LEFT JOIN cat_result ON designers.id = cat_result.designer
			  AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND cat_result.pro_status != 1
				  WHERE designers.is_active= 1 ";  
		}else{
			$qq = "SELECT COUNT(cat_result.order_no) AS adCount, CONCAT(designers.name,' (',designers.username,')') AS name, designers.id, cat_result.pro_status FROM `designers`
			LEFT JOIN cat_result ON designers.id = cat_result.designer
			  AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND cat_result.pro_status != 1
				  WHERE designers.adwit_teams_id = $adwit_team_id and designers.is_active= 1 ";  
		}
    	
    	
    
    	$recordsTotal = $this->db->query($qq)->num_rows();
    	//search query
        if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])){ 
           $qq .= " AND (designers.name LIKE '".$_POST["search"]["value"]."%')"; 
        }
        $qq .= " GROUP BY designers.id";
        //search query order by
        if(isset($_POST["order"])){ 
            $qq .= " ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']; 
        }else{  
            $qq .= " ORDER BY adCount DESC" ;
        } 
        
        $recordsFiltered = $this->db->query($qq)->num_rows();
        //Limit range
        if($_POST["length"] != -1){  
            $qq .= " LIMIT ".$_POST['length']." OFFSET ".$_POST['start'];  
        } 
        
    	 //echo $qq;
    	 $web_Ad =0;
        $teamlead_designer_volume_new = $this->db->query($qq)->result_array();
        foreach($teamlead_designer_volume_new as $row){
            $rev_count = $this->db->query("SELECT COUNT(rev_sold_jobs.order_id) AS adCount FROM `rev_sold_jobs` 
                            WHERE rev_sold_jobs.designer = '".$row['id']."' and (rev_sold_jobs.ddate BETWEEN '$from' AND '$to') AND rev_sold_jobs.status NOT IN (1,2)")->row_array();
        
        //web ad
       /* $web_ad_count = $this->db->query("SELECT COUNT(cat_result.order_type_id) AS web_ad_count FROM `cat_result` WHERE cat_result.order_type_id =1 AND  cat_result.designer = '".$row['id']."' 
         AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND cat_result.pro_status != 1 ")->row_array();*/
         
         // back to designer
         
       
         $sub_array = array();
            
        $sub_array[] = $row['name'];
        $sub_array[] = $row['adCount'];
        $sub_array[] = $rev_count['adCount'];
        // $sub_array[] = $web_ad_count['web_ad_count'];
                
            $data[] = $sub_array;
            
        }
        
            
            $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $recordsFiltered,  
                "data"              =>     $data  
           );  
           echo json_encode($output);
        
	}
	
	public function team_report_cat($designer_id='', $from='', $to='')
	{
		$today = date('Y-m-d'); $data['today'] = $today;
		$data['hi'] = '';
		$data['designer_id'] = $designer_id;
		if($from != '' && $to != ''){
			$data['from'] = $from;
			$data['to'] = $to;
			$q = "SELECT cat_result.category, COUNT(cat_result.id) AS ad_count FROM cat_result 
		            WHERE cat_result.designer = '$designer_id' AND cat_result.ddate BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY cat_result.category;";
		}else{
		   $q = "SELECT cat_result.category, COUNT(cat_result.id) AS ad_count FROM cat_result 
		            WHERE cat_result.designer = '$designer_id' AND cat_result.ddate = '$today' GROUP BY cat_result.category;"; 
		}
		$data['cat_result'] = $this->db->query($q)->result_array();
		$data['designer'] = $this->db->query("SELECT `name` FROM `designers` WHERE `id`= '$designer_id'")->result_array();
		
		$this->load->view('new_designer/team_report_cat',$data);
	}
	
    public function curl_post($url='', $fields='') //API via cURL
	{
		if($url != '' && $fields != ''){
			$fields_string = $fields;
			/*foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');*/

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
		}
	}
	public function comment($comment_id = '')
	{
		$dId = $this->session->userdata('dId');
	
		$designer_alias = $this->db->get_where('designers',array('id' => $this->session->userdata('dId')))->row_array();
		$data['designer_alias'] = $designer_alias;
		if($designer_alias['designer_role'] == '2'){//Designer Team lead
			$query = "SELECT rev_verify_comment.*, rev_sold_jobs.verification_type, rev_sold_jobs.order_id,CONCAT(admin_users.first_name,' ',admin_users.last_name) as admin_name, designers.name as d_name, csr.name as c_name,tl.name as tl_name,designers.name as hi_b_name FROM `rev_verify_comment` 
			JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
			LEFT JOIN `admin_users` ON admin_users.id = rev_verify_comment.admin_id
			LEFT JOIN `designers` AS tl ON tl.id = rev_verify_comment.tl_designer_id
			LEFT JOIN `designers` ON designers.id = rev_verify_comment.designer_id
			LEFT JOIN `designers` AS hi_b ON designers.id = rev_verify_comment.hi_b_designer_id
			LEFT JOIN `csr` AS rov_csr ON rov_csr.id = rev_verify_comment.rov_csr_id
			LEFT JOIN `csr` ON csr.id = rev_verify_comment.csr_id
			WHERE rev_verify_comment.id = '$comment_id' AND rev_verify_comment.dtl_reply IS NULL "; 
			$data['r_review'] = $this->db->query("$query")->row_array();

		}elseif($designer_alias['designer_role'] == '3'){ //Designer
			$query = "SELECT rev_verify_comment.*, rev_sold_jobs.verification_type, rev_sold_jobs.order_id,CONCAT(admin_users.first_name,' ',admin_users.last_name) as admin_name, designers.name as d_name, csr.name as c_name,tl.name as tl_name,designers.name as hi_b_name FROM `rev_verify_comment` 
			JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
			LEFT JOIN `admin_users` ON admin_users.id = rev_verify_comment.admin_id
			LEFT JOIN `designers` AS tl ON tl.id = rev_verify_comment.tl_designer_id
			LEFT JOIN `designers` ON designers.id = rev_verify_comment.designer_id
			LEFT JOIN `designers` AS hi_b ON designers.id = rev_verify_comment.hi_b_designer_id
			LEFT JOIN `csr` AS rov_csr ON rov_csr.id = rev_verify_comment.rov_csr_id
			LEFT JOIN `csr` ON csr.id = rev_verify_comment.csr_id
			WHERE rev_verify_comment.id = '$comment_id' AND rev_verify_comment.designer_reply IS NULL "; 
			$data['r_review'] = $this->db->query("$query")->row_array();
			
		}elseif($designer_alias['designer_role'] == '4'){ //Hi_B_Designer
			$query = "SELECT rev_verify_comment.*, rev_sold_jobs.verification_type, rev_sold_jobs.order_id,CONCAT(admin_users.first_name,' ',admin_users.last_name) as admin_name, designers.name as d_name, csr.name as c_name,tl.name as tl_name,designers.name as hi_b_name FROM `rev_verify_comment` 
			JOIN `rev_sold_jobs` ON rev_sold_jobs.id = rev_verify_comment.rev_id
			LEFT JOIN `admin_users` ON admin_users.id = rev_verify_comment.admin_id
			LEFT JOIN `designers` AS tl ON tl.id = rev_verify_comment.tl_designer_id
			LEFT JOIN `designers` ON designers.id = rev_verify_comment.designer_id
			LEFT JOIN `designers` AS hi_b ON designers.id = rev_verify_comment.hi_b_designer_id
			LEFT JOIN `csr` AS rov_csr ON rov_csr.id = rev_verify_comment.rov_csr_id
			LEFT JOIN `csr` ON csr.id = rev_verify_comment.csr_id
			WHERE rev_verify_comment.id = '$comment_id' AND rev_verify_comment.hi_b_designer_reply IS NULL "; 
			
			$data['r_review'] = $this->db->query("$query")->row_array();
		}
		
		
		// 2 -Designer TL and 3 -Designer and 4 -Hi-b designer
		if($designer_alias['designer_role'] == '2'){
			if(isset($_POST['c_search']))
			{
				$timestamp = date('Y-m-d H:i:s');
				$aId = $this->session->userdata('aId');
				$dtl_reply = array( 
							'dtl_reply' => $_POST['reply']
						);
				$this->db->where('id', $_POST['comment_id']);
				$this->db->update('rev_verify_comment', $dtl_reply);		
				
				redirect('new_designer/home');	
			}
		}elseif($designer_alias['designer_role'] == '3'){
			if(isset($_POST['c_search']))
			{
				$timestamp = date('Y-m-d H:i:s');
				$aId = $this->session->userdata('aId');
				$d_reply = array( 
							'designer_reply' => $_POST['reply']
						);
				$this->db->where('id', $_POST['comment_id']);
				$this->db->update('rev_verify_comment', $d_reply);		
				
				redirect('new_designer/home');	
			}
		}elseif($designer_alias['designer_role'] == '4'){	//Hi-B Designer
			if(isset($_POST['c_search']))
			{
				$timestamp = date('Y-m-d H:i:s');
				$aId = $this->session->userdata('aId');
				$hi_b_reply = array( 
							'hi_b_designer_reply' => $_POST['reply']
						);
				$this->db->where('id', $_POST['comment_id']);
				$this->db->update('rev_verify_comment', $hi_b_reply);		
				
				redirect('new_designer/home');	
			}
		}
		
		$this->load->view('new_designer/comment',$data);
	}
	
	public function designer_rev_review($num_days='')
	{
		$data['ystdy'] = date('Y-m-d', strtotime(' -1 day'));
		$dId = $this->session->userdata('dId');
		
		if($num_days == 'sevenday'){
			$d = date('Y-m-d', strtotime(' -7 day'));
			$data['from'] = $d;
			$data['to'] = date('Y-m-d');
		}elseif($num_days == 'yesterday'){
			$d = date('Y-m-d', strtotime(' -1 day'));
			$data['from'] = $d;
			$data['to'] = date('Y-m-d');
		}else{
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}
		$data['num_days'] = $num_days;
		$data['designer'] = $this->db->query("SELECT * FROM `designers` WHERE `id` = '$dId' AND `is_active`='1' ")->result_array();
		$this->load->view('new_designer/designer_rev_review',$data);
	}
	
	public function order_review_history($order_id="")
	{
		
		$orders= $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
												FROM `orders` WHERE `id`= '$order_id' ")->result_array();
		if(isset($orders[0]['id']))
		{
			$this->load->helper('directory');
			
			$data['order_id']= $order_id; 
			$data['hd']= $orders[0]['help_desk'];
			
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
			$this->load->view('new_designer/order_review_history', $data);			
		}			
	}
	
	//Live_tracker_New_Ads Starts
	/*public function live_new_ads($display_type = '')
    {    
        $dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
        $pub_id = "(".$designers['pub_id'].")";
        
		//Assign Annex
            if(isset($_POST['submit']) && isset($_POST['cat_id'])){
                foreach($_POST['assign'] as $item) 
                {
                    $post = array('assign' => $_POST['submit']);
                    $this->db->where('id', $item);
                    $this->db->update('cat_result', $post);
                }
            }
            
        //Tag Designer
            if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
                foreach($_POST['assign_designer'] as $item_id) 
                {
                    $post1 = array('tag_designer' => $_POST['submit_designer']);
                    $this->db->where('id', $item_id);
                    $this->db->update('cat_result', $post1);
                }
            }
			
        if($designers['category_level'] != null){
            $cat_id = $designers['category_level'];
			
        	if($cat_id == 'A'){ $cat_series = "('A')"; }
			elseif($cat_id == 'B'){ $cat_series = "('A', 'B')"; }
			elseif($cat_id == 'C'){ $cat_series = "('A', 'B', 'C')"; }
			elseif($cat_id == 'D'){ $cat_series = "('A', 'B', 'C', 'D')"; }
			elseif($cat_id == 'E'){ $cat_series =  "('A', 'B', 'C', 'D', 'E')"; }
			elseif($cat_id == 'F'){ $cat_series = "('A', 'B', 'C', 'D', 'E', 'F')"; }
			elseif($cat_id == 'G'){ $cat_series = "('A', 'B', 'C', 'D', 'E', 'F', 'G')"; }
			elseif($cat_id == 'H'){ $cat_series = "('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H')"; }
			//echo $cat_series;
        
			//My_Q orders -->  order_status = 3 or 4  and pro_status= 1 or 6 or 7
		
			$myq_orders_query = "SELECT live_orders.* FROM `live_orders`
				                 WHERE live_orders.pub_id IN $pub_id AND live_orders.category IN $cat_series AND live_orders.designer_id = '$dId'; ";
			//For Design Pending Starts order_status = 2  TOTAL Q
			$dp_orders_query = "SELECT live_orders.* FROM `live_orders` 
									WHERE live_orders.pub_id IN $pub_id AND live_orders.category IN $cat_series AND live_orders.status = '2' ";
			//Design_check Orders
			$dc_orders_query = "SELECT live_orders.*, cat_result.id, cat_result.pro_status, cat_result.source_path, cat_result.category 
			FROM `live_orders`
				JOIN cat_result on live_orders.order_id = cat_result.order_no 
					WHERE live_orders.pub_id IN $pub_id AND live_orders.category IN $cat_series AND live_orders.status = '3'";
			
			//Pending_Orders starts order_status = 2 or 3 or 4 or 8
			$pending_orders_query = "SELECT live_orders.*, cat_result.pro_status, cat_result.category
			FROM `live_orders`
				JOIN cat_result on live_orders.order_id = cat_result.order_no 
					WHERE live_orders.pub_id IN $pub_id AND live_orders.category IN $cat_series AND (live_orders.status = '2' OR live_orders.status = '3' OR live_orders.status = '4' OR live_orders.status = '8')";
			
			//All STARTS
			$all_orders_query = "SELECT live_orders.*,  cat_result.pro_status, cat_result.category
			FROM `live_orders`
				JOIN cat_result on live_orders.order_id = cat_result.order_no 
					WHERE live_orders.pub_id IN $pub_id AND live_orders.category IN $cat_series";
			
			if($display_type == 'upload_pending'){
				
				$data['myq_orders'] = $this->db->query($myq_orders_query)->result_array();
				
			}elseif($display_type == 'design_pending'){ //totalQ
				
				$data['dp_orders'] = $this->db->query($dp_orders_query)->result_array();
				 
			}elseif($display_type == 'design_check'){
				
				$data['dc_orders'] = $this->db->query($dc_orders_query)->result_array();
				
			}elseif($display_type == 'all_pending'){
				
				$data['all_pending'] = $this->db->query($pending_orders_query)->result_array();
				
			}elseif($display_type == 'all'){
				
				$data['all_orders'] = $this->db->query($all_orders_query)->result_array();
				
			}
			//counts
			$data['MyQ_count'] 		= 	$this->db->query($myq_orders_query)->num_rows();
			$data['TotalQ_count']   = 	$this->db->query($dp_orders_query)->num_rows();
			$data['DcQ_count'] 		= 	0;//$this->db->query($dc_orders_query)->num_rows();
			$data['DpQ_count'] 		= 	0;//$this->db->query($pending_orders_query)->num_rows();
			$data['AllQ_count']	 	= 	0;//$this->db->query($all_orders_query)->num_rows();
			
			$data['dId'] = $dId;
			$data['display_type'] = $display_type;
			$data['designers'] = $designers; 
			$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `d_id` = '$dId' ")->result_array();			
			$this->load->view('new_designer/live_new_ads',$data);
		}
    }*/
    
    public function tab_count()
	{
		$MyQ = 0; $TotalQ = 0; $DcQ = 0; $DpQ = 0; $AllQ = 0;
		$dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
        $pub_id = "(".$designers['pub_id'].")";
		
		 if($designers['category_level'] != null && $designers['club_id'] != null){
			$club_id = "(".$designers['club_id'].")";
			
			$cat_id = explode(',', $designers['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			
            //$cat_id = $designers['category_level'];
            //$cat_series = "('".$cat_id."')";
           /* 
            if($cat_id == 'P'){ $cat_series = "('P')"; }
			elseif($cat_id == 'M'){ $cat_series = "('P', 'M')"; }
			elseif($cat_id == 'N'){ $cat_series = "('P', 'M', 'N')"; }
			elseif($cat_id == 'T'){ $cat_series = "('P', 'M', 'N', 'T')"; }
			elseif($cat_id == 'W'){ $cat_series =  "('P', 'M', 'N', 'T', 'W')"; }
			
			
        	if($cat_id == 'A'){ $cat_series = "('A')"; }
			elseif($cat_id == 'B'){ $cat_series = "('A', 'B')"; }
			elseif($cat_id == 'C'){ $cat_series = "('A', 'B', 'C')"; }
			elseif($cat_id == 'D'){ $cat_series = "('D')"; }
			elseif($cat_id == 'E'){ $cat_series =  "('D', 'E')"; }
			elseif($cat_id == 'F'){ $cat_series = "('D', 'E', 'F')"; }
			elseif($cat_id == 'G'){ $cat_series = "('D', 'E', 'F', 'G')"; }
			elseif($cat_id == 'H'){ $cat_series = "('D', 'E', 'F', 'G', 'H')"; }
			*/
			//tab='MyQ' display_type = 'upload_pending' 
			$myq_orders_query = "SELECT live_orders.id, live_orders.order_id FROM `live_orders`
								RIGHT JOIN `orders` ON orders.id = live_orders.order_id
				                 WHERE live_orders.designer_id = '$dId' AND live_orders.crequest != '1'; ";
			
			//tab=TotalQ display_type = 'design_pending' 
			$dp_orders_query = "SELECT live_orders.id, live_orders.order_id FROM `live_orders` 
			                    RIGHT JOIN `orders` ON orders.id = live_orders.order_id
									WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
									AND live_orders.crequest != '1' AND live_orders.question != '1';";
				
			//tab=Design_check(DcQ) display_type = 'design_check' 
			$dc_orders_query = "SELECT live_orders.id FROM `live_orders`
									WHERE live_orders.status = '3' AND (live_orders.pro_status ='2' OR live_orders.pro_status = '8') 
									AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id AND live_orders.crequest != '1';";
			
			//tab=Pending(DpQ) display_type = 'all_pending' 
			$pending_orders_query = "SELECT live_orders.id, live_orders.order_id FROM `live_orders`
					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
					WHERE live_orders.category IN ($cat_series) AND live_orders.status IN (2,3,4,8) AND live_orders.club_id IN $club_id 
					AND live_orders.crequest != '1' AND live_orders.question != '1'";
			
			//tab=All(AllQ) display_type = 'all' 
				/*$all_orders_query = "SELECT live_orders.id FROM `live_orders` 
						WHERE live_orders.category IN $cat_series AND live_orders.club_id IN $club_id AND live_orders.crequest != '1'";*/
				$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
					$ystday_time = $today_date_time[0]['time'];
					$today_time = $today_date_time[1]['time'];
					$tomo_time = $today_date_time[2]['time'];
					$current_date = date("Y-m-d");
					$ysterday = date("Y-m-d", strtotime(' -1 day'));
					$tomo = date("Y-m-d", strtotime(' +1 day'));
					$ct = date("H:i:s");
				if($ct >= '00:00:00' && $ct <= '08:29:59'){		
					$all_orders_query = "SELECT orders.id FROM `orders`
						LEFT JOIN `publications` on publications.id = orders.publication_id
						 WHERE publications.club_id IN $club_id AND (orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') 
						 AND orders.crequest!='1' AND orders.cancel!='1'";
				}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
					$all_orders_query = "SELECT orders.id FROM `orders`
						LEFT JOIN `publications` on publications.id = orders.publication_id
						 WHERE publications.club_id IN $club_id AND (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') 
						 AND orders.crequest!='1' AND orders.cancel!='1'";	
				}
				
				$question_sent_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
		                            	FROM `live_orders`
			                            LEFT JOIN orders ON orders.id = live_orders.order_id
			                            JOIN `publications` ON publications.id = live_orders.pub_id
    					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                            WHERE live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
				                                AND live_orders.crequest != '1' AND live_orders.question = '1'";
			
			if($designers['designer_role'] == '1'){ 		//Asst TL
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				$data['DcQCount'] 		= 	$this->db->query($dc_orders_query)->num_rows();
				$data['DpQCount'] 		= 	$this->db->query($pending_orders_query)->num_rows();
				$data['AllQCount']	 	= 	$this->db->query($all_orders_query)->num_rows();
				$data['questionSentCount']	 	= 	$this->db->query($question_sent_query)->num_rows();
			}elseif($designers['designer_role'] == '2'){	//TL
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				$data['DcQCount'] 		= 	$this->db->query($dc_orders_query)->num_rows();
				$data['DpQCount'] 		= 	$this->db->query($pending_orders_query)->num_rows();
				$data['AllQCount']	 	= 	$this->db->query($all_orders_query)->num_rows();
				$data['questionSentCount']	 	= 	$this->db->query($question_sent_query)->num_rows();
			}elseif($designers['designer_role'] == '3'){	//Designer
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				
			}elseif($designers['designer_role'] == '4'){	//Hi_B_Designer
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
			}
			
		 }
		
		echo json_encode($data);
	}
	
    public function live_new_ads1($display_type = '')
    {    
        $dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
        $pub_id = "(".$designers['pub_id'].")";
        $adwit_teams_id = $designers['adwit_teams_id'];
        $adwit_teams_and_club = $this->db->query("SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id'")->result_array();
        
        $order_by = null;
        $sort_by = null;
            // print_r($_POST);exit();
        $no_of_order = $this->input->post('no_of_order');
        if(isset($_POST['order_by'])){
           $order_by  =  $_POST['order_by'];
           $this->session->set_userdata("order_by",$order_by);
        }
        if(isset($_POST['sort_by'])){
            $sort_by = $_POST['sort_by'];
            $this->session->set_userdata("sort_by",$sort_by);
        }
      
		//Assign Annex
            if(isset($_POST['submit']) && isset($_POST['cat_id'])){
                foreach($_POST['assign'] as $item) 
                {
                    $post = array('assign' => $_POST['submit']);
                    $this->db->where('id', $item);
                    $this->db->update('cat_result', $post);
                }
            }
            
        //Tag Designer
            if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
                foreach($_POST['assign_designer'] as $item_id) 
                {
                    $post1 = array('tag_designer' => $_POST['submit_designer']);
                    $this->db->where('id', $item_id);
                    $this->db->update('cat_result', $post1);
                }
            }
			
        if($designers['category_level'] != null && $designers['club_id'] != null){
			$club_id = "(".$designers['club_id'].")";
            
            $cat_id = explode(',', $designers['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";

				 
    		if($display_type == 'upload_pending'){
    			//tab='MyQ' display_type = 'upload_pending'
    		/*	$myq_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
    			                        FROM `live_orders`
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
        					            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                    WHERE live_orders.designer_id = '$dId' AND live_orders.crequest != '1'; ";
    			
    			$data['MyQ'] 				= 	$this->db->query($myq_orders_query)->result_array();*/
    			
                if(isset($_POST['u_order_by'])){
                   $order_by  =  $_POST['u_order_by'];
                   $this->session->set_userdata("u_order_by",$order_by);
                }
                if(isset($_POST['u_sort_by'])){
                    $sort_by = $_POST['u_sort_by'];
                    $this->session->set_userdata("u_sort_by",$sort_by);
                }
                #pagination code starts here
            		$config = array();
            		$config["base_url"] = base_url() . "index.php/new_designer/home/live_new_ads/upload_pending/";
            		if($this->input->post('new_upload_pending_search') != null){
            			$search = $this->input->post('new_upload_pending_search');
            			$this->session->set_userdata('new_upload_pending_search_val', $search);
            			$config["total_rows"] = $this->Pagination->get_upload_pending_ad_count($dId,$search);
            		}else if($this->session->userdata("new_upload_pending_search_val") !== "" && $this->input->post('new_upload_pending_search') == null){
            			$search =  $this->session->userdata("new_upload_pending_search_val");
            			$config["total_rows"] = $this->Pagination->get_upload_pending_ad_count($dId,$search);
            		}else{
            			$config["total_rows"] = $this->Pagination->get_upload_pending_ad_count($dId,null);
            		}
            		
            		if($no_of_order != "" && $no_of_order != null){
            		  	$config["per_page"] = $no_of_order;  
            		  	$this->session->set_userdata('new_upload_pending_order', $no_of_order);
            		}else if($no_of_order == "" && $this->session->userdata('new_upload_pending_order') != ""){
            		    $config["per_page"] = $this->session->userdata('new_upload_pending_order');
            		}else{
            		    unset($_SESSION['new_upload_pending_order']);
            		   	$config["per_page"] = 25; 
            		} 
            		
            		$config["uri_segment"] = 5;
            		$this->get_pagination_config($config);
            		
            		$this->pagination->initialize($config);
            		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            		if($this->input->post('new_upload_pending_search') != null){
            			$search = $this->input->post('new_upload_pending_search');
            			$data["MyQ"] = $this->Pagination->
            			get_upload_pending_ad($config["per_page"], $page,$dId,$sort_by,$order_by,$search);
            		}else if($this->session->userdata("new_upload_pending_search_val") != "" && $this->input->post('new_upload_pending_search') == null){
            			$search =  $this->session->userdata("new_upload_pending_search_val");
            			$data["MyQ"] = $this->Pagination->
            			get_upload_pending_ad($config["per_page"], $page,$dId,$sort_by,$order_by,$search);
            			
            		}else{
            			$data["MyQ"] = $this->Pagination->
            			get_upload_pending_ad($config["per_page"], $page,$dId,$sort_by,$order_by,null);
            		} 
            		$data["upload_pending_links"] = $this->pagination->create_links();
            		#pagination code ends here
    			
    		}elseif($display_type == 'design_pending'){
    			//tab=TotalQ display_type = 'design_pending' 
    			//get myQ count
    			/*
    			$myq_orders_query = "SELECT live_orders.id FROM `live_orders`
    				                 WHERE live_orders.designer_id = '$dId' AND live_orders.category IN $cat_series AND live_orders.club_id IN $club_id AND live_orders.crequest != '1' AND live_orders.question != '1'; ";
    			$data['MyQcount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
    			*/
    			/*$dp_orders_query = "SELECT live_orders.pub_id AS publication_id, live_orders.order_id AS oid, live_orders.job_no, live_orders.category, live_orders.designer_id, 
    			                        live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question,
    			                        orders.id, orders.order_type_id, orders.rush, orders.help_desk, orders.adrep_id, orders.advertiser_name,
    			                        publications.name, publications.design_team_id, time_zone.priority AS time_zone_priority
    			                        FROM `live_orders`
    			                        JOIN `orders` ON orders.id = live_orders.order_id
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
    					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
        					                WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
    									        AND live_orders.crequest != '1' AND live_orders.question != '1' 
    									ORDER BY orders.rush DESC, time_zone.priority;";*/
    									/*"SELECT live_orders.id, live_orders.pub_id AS publication_id, live_orders.order_id AS oid, live_orders.job_no, live_orders.category, live_orders.designer_id, 
    			                        live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
    			                        FROM `live_orders`
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
        					            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    									WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
    									        AND live_orders.crequest != '1' AND live_orders.question != '1' 
    									ORDER BY live_orders.category DESC;";*/
    			
    // 			$data['TotalQ']   = 	$this->db->query($dp_orders_query)->result_array();
                    #pagination code starts here
            		$config = array();
            		$config["base_url"] = base_url() . "index.php/new_designer/home/live_new_ads/design_pending/";
            		if($this->input->post('new_design_pending_search') != null){
            			$search = $this->input->post('new_design_pending_search');
            			$this->session->set_userdata('new_design_pending_search_val', $search);
            			$config["total_rows"] = $this->Pagination->get_design_pending_ad_count($cat_series,$club_id,$search);
            		}else if($this->session->userdata("new_design_pending_search_val") !== "" && $this->input->post('new_design_pending_search') == null){
            			$search =  $this->session->userdata("new_design_pending_search_val");
            			$config["total_rows"] = $this->Pagination->get_design_pending_ad_count($cat_series,$club_id,$search);
            		}else{
            			$config["total_rows"] = $this->Pagination->get_design_pending_ad_count($cat_series,$club_id,null);
            		}
            		
            		if($no_of_order != "" && $no_of_order != null){
            		  	$config["per_page"] = $no_of_order;  
            		  	$this->session->set_userdata('new_design_pending_order', $no_of_order);
            		}else if($no_of_order == "" && $this->session->userdata('new_design_pending_order') != ""){
            		    $config["per_page"] = $this->session->userdata('new_design_pending_order');
            		}else{
            		    unset($_SESSION['new_design_pending_order']);
            		   	$config["per_page"] = 25; 
            		} 
            		
            		$config["uri_segment"] = 5;

            	    $this->get_pagination_config($config);
            		$this->pagination->initialize($config);
            		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            		if($this->input->post('new_design_pending_search') != null){
            			$search = $this->input->post('new_design_pending_search');
            			$data["TotalQ"] = $this->Pagination->
            			get_new_design_pending_ad($config["per_page"], $page,$cat_series,$club_id,$sort_by,$order_by,$search);
            		}else if($this->session->userdata("new_design_pending_search_val") != "" && $this->input->post('new_design_pending_search') == null){
            			$search =  $this->session->userdata("new_design_pending_search_val");
            			$data["TotalQ"] = $this->Pagination->
            			get_new_design_pending_ad($config["per_page"], $page,$cat_series,$club_id,$sort_by,$order_by,$search);
            			
            		}else{
            			$data["TotalQ"] = $this->Pagination->
            			get_new_design_pending_ad($config["per_page"], $page,$cat_series,$club_id,$sort_by,$order_by,null);
            		} 
            		$data["design_pending_links"] = $this->pagination->create_links();
            // 		print_r($data["TotalQ"]);exit();
    			
    		}elseif($display_type == 'design_check'){
    			//tab=Design_check(DcQ) display_type = 'design_check' 
    			$dc_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
    			                        FROM `live_orders`
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
        					            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    									    WHERE live_orders.status = '3' AND (live_orders.pro_status ='2' OR live_orders.pro_status = '8') 
    									    AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id AND live_orders.crequest != '1'
    									    ORDER BY time_zone.priority ASC;";
    			$data['DcQ'] 		= 	$this->db->query($dc_orders_query)->result_array();
    			//echo $dc_orders_query;							
    		}elseif($display_type == 'all_pending'){
    			//tab=Pending(DpQ) display_type = 'all_pending' 
    			$pending_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
    		                            	FROM `live_orders`
    			                            LEFT JOIN orders ON orders.id = live_orders.order_id
    			                            JOIN `publications` ON publications.id = live_orders.pub_id
        					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                            WHERE live_orders.category IN ($cat_series) AND live_orders.status IN (2,3,4,8) AND live_orders.club_id IN $club_id 
    				                                AND live_orders.crequest != '1' AND live_orders.question != '1'
    				                                ORDER BY time_zone.priority ASC;";
    			$data['DpQ'] 		= 	$this->db->query($pending_orders_query)->result_array();
    			
    			#pagination code starts here
            		$config = array();
            		$config["base_url"] = base_url() . "index.php/new_designer/home/live_new_ads/all_pending/";
            		if($this->input->post('new_all_pending_search') != null){
            			$search = $this->input->post('new_all_pending_search');
            			$this->session->set_userdata('new_all_pending_search_val', $search);
            			$config["total_rows"] = $this->Pagination->get_all_pending_ad_count($cat_series,$club_id,$search);
            		}else if($this->session->userdata("new_all_pending_search_val") !== "" && $this->input->post('new_all_pending_search') == null){
            			$search =  $this->session->userdata("new_all_pending_search_val");
            			$config["total_rows"] = $this->Pagination->get_all_pending_ad_count($cat_series,$club_id,$search);
            		}else{
            			$config["total_rows"] = $this->Pagination->get_all_pending_ad_count($cat_series,$club_id,null);
            		}
            		
            		if($no_of_order != "" && $no_of_order != null){
            		  	$config["per_page"] = $no_of_order;  
            		  	$this->session->set_userdata('new_all_pending_order', $no_of_order);
            		}else if($no_of_order == "" && $this->session->userdata('new_all_pending_order') != ""){
            		    $config["per_page"] = $this->session->userdata('new_all_pending_order');
            		}else{
            		    unset($_SESSION['new_all_pending_order']);
            		   	$config["per_page"] = 25; 
            		} 
            		
            		$config["uri_segment"] = 5;
            	    $this->get_pagination_config($config);
            	    
            		$this->pagination->initialize($config);
            		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            		if($this->input->post('new_all_pending_search') != null){
            			$search = $this->input->post('new_all_pending_search');
            			$data["DpQ"] = $this->Pagination->
            			get_new_all_pending_ad($config["per_page"], $page,$cat_series,$club_id,$search);
            		}else if($this->session->userdata("new_all_pending_search_val") != "" && $this->input->post('new_all_pending_search') == null){
            			$search =  $this->session->userdata("new_all_pending_search_val");
            			$data["DpQ"] = $this->Pagination->
            			get_new_all_pending_ad($config["per_page"], $page,$cat_series,$club_id,$search);
            			
            		}else{
            			$data["DpQ"] = $this->Pagination->
            			get_new_all_pending_ad($config["per_page"], $page,$cat_series,$club_id,null);
            		} 
            		$data["all_pending_links"] = $this->pagination->create_links();
            	
    		}elseif($display_type == 'all'){
    			//tab=All(AllQ) display_type = 'all' 
    			/*$all_orders_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question
    			FROM `live_orders` 
    					WHERE live_orders.category IN $cat_series AND live_orders.club_id IN $club_id AND live_orders.crequest != '1'";*/
    					
    			$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
    					$ystday_time = $today_date_time[0]['time'];
    					$today_time = $today_date_time[1]['time'];
    					$tomo_time = $today_date_time[2]['time'];
    					$current_date = date("Y-m-d");
    					$ysterday = date("Y-m-d", strtotime(' -1 day'));
    					$tomo = date("Y-m-d", strtotime(' +1 day'));
    					$ct = date("H:i:s");
    				if($ct >= '00:00:00' && $ct <= '08:29:59'){		
    					$all_orders_query = "SELECT orders.id, orders.order_type_id, orders.created_on, orders.job_no, publications.name, publications.club_id, orders.status, orders.adrep_id, orders.rush, orders.question, orders.help_desk, orders.group_id, time_zone.priority AS time_zone_priority
    					                        FROM `orders`
    						                    LEFT JOIN `publications` on publications.id = orders.publication_id
    						                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    						                    WHERE publications.club_id IN $club_id AND (orders.created_on BETWEEN '$ysterday $ystday_time' 
    						                    AND '$current_date $today_time') AND orders.crequest!='1' AND orders.cancel!='1'";
    				}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
    					$all_orders_query = "SELECT orders.id, orders.order_type_id, orders.created_on, orders.job_no, publications.name, publications.club_id, orders.status, orders.adrep_id, orders.rush, orders.question, orders.help_desk, orders.group_id, time_zone.priority AS time_zone_priority
    					                        FROM `orders`
    						                    LEFT JOIN `publications` on publications.id = orders.publication_id
    						                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    						                    WHERE publications.club_id IN $club_id AND (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') 
    						                    AND orders.crequest!='1' AND orders.cancel!='1'";	
    				}
    			//echo 	$all_orders_query;
    			$data['AllQ']	 	= 	$this->db->query($all_orders_query." ORDER BY orders.rush DESC, time_zone.priority ASC")->result_array();
    		}elseif($display_type == 'question_sent'){
    		    $question_sent_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category,live_orders.sub_category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
    		                            	FROM `live_orders`
    			                            LEFT JOIN orders ON orders.id = live_orders.order_id
    			                            JOIN `publications` ON publications.id = live_orders.pub_id
        					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                            WHERE live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
    				                                AND live_orders.crequest != '1' AND live_orders.question = '1'
    				                                ORDER BY time_zone.priority ASC;";
    			$data['question_sent'] 		= 	$this->db->query($question_sent_query)->result_array();   
    		}			
    		
			$data['dId'] = $dId;
			$data['display_type'] = $display_type;
			$data['designers'] = $designers; 
			$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `d_id` = '$dId' ")->result_array();			
			$this->load->view('new_designer/live_new_ads',$data);
		}else{
		    $this->session->set_flashdata("message","No Publication Assigned..!! Contact Acharya or Jeevan regarding the issue..!! Also check for Club and Category level assignment.");
		    redirect('new_designer/home');
		}
    }
    
      public function tab_count_pagination()
	{
		$MyQ = 0; $TotalQ = 0; $DcQ = 0; $DpQ = 0; $AllQ = 0;
		$dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
        $adwit_teams_id = $designers['adwit_teams_id'];
        $adwit_team_detail = $this->db->query("SELECT `category`  FROM `adwit_teams` WHERE `adwit_teams_id` = $adwit_teams_id AND `is_active` = 1")->row_array();
        
		 if(isset($adwit_team_detail['category'])){
			if($this->session->userdata('clubList')!== null){
                $adwit_team_club = $this->session->userdata('clubList');
            }else{
                $adwit_teams_and_club = $this->db->query("SELECT GROUP_CONCAT(club_id) AS clubList FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id';")->row_array(); 
                $adwit_team_club = $adwit_teams_and_club['clubList'];
            }
            $club_id = $adwit_team_club;
            $cat_id = explode(',', $adwit_team_detail['category']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			
			//tab='MyQ' display_type = 'upload_pending' 
			$myq_orders_query = "SELECT live_orders.id, live_orders.order_id FROM `live_orders`
								RIGHT JOIN `orders` ON orders.id = live_orders.order_id
				                 WHERE live_orders.designer_id = '$dId' AND live_orders.crequest != '1'; ";
			
			//tab=TotalQ display_type = 'design_pending' 
			$dp_orders_query = "SELECT live_orders.id, live_orders.order_id FROM `live_orders` 
			                    RIGHT JOIN `orders` ON orders.id = live_orders.order_id
									WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN ($club_id) 
									AND live_orders.crequest != '1' AND live_orders.question != '1';";
				
			//tab=Design_check(DcQ) display_type = 'design_check' 
			$dc_orders_query = "SELECT live_orders.id FROM `live_orders`
									WHERE live_orders.status = '3' AND (live_orders.pro_status ='2' OR live_orders.pro_status = '8') 
									AND live_orders.category IN ($cat_series) AND live_orders.club_id IN ($club_id) AND live_orders.crequest != '1';";
			
			//tab=Pending(DpQ) display_type = 'all_pending' 
			$pending_orders_query = "SELECT live_orders.id, live_orders.order_id FROM `live_orders`
					RIGHT JOIN `orders` ON orders.id = live_orders.order_id
					WHERE live_orders.category IN ($cat_series) AND live_orders.status IN (2,3,4,8) AND live_orders.club_id IN ($club_id) 
					AND live_orders.crequest != '1' AND live_orders.question != '1'";
			
			//tab=All(AllQ) display_type = 'all' 
				/*$all_orders_query = "SELECT live_orders.id FROM `live_orders` 
						WHERE live_orders.category IN $cat_series AND live_orders.club_id IN $club_id AND live_orders.crequest != '1'";*/
				$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
					$ystday_time = $today_date_time[0]['time'];
					$today_time = $today_date_time[1]['time'];
					$tomo_time = $today_date_time[2]['time'];
					$current_date = date("Y-m-d");
					$ysterday = date("Y-m-d", strtotime(' -1 day'));
					$tomo = date("Y-m-d", strtotime(' +1 day'));
					$ct = date("H:i:s");
				if($ct >= '00:00:00' && $ct <= '08:29:59'){		
					$all_orders_query = "SELECT orders.id FROM `orders`
						LEFT JOIN `publications` on publications.id = orders.publication_id
						 WHERE publications.club_id IN ($club_id) AND (orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') 
						 AND orders.crequest!='1' AND orders.cancel!='1'";
				}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
					$all_orders_query = "SELECT orders.id FROM `orders`
						LEFT JOIN `publications` on publications.id = orders.publication_id
						 WHERE publications.club_id IN ($club_id) AND (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') 
						 AND orders.crequest!='1' AND orders.cancel!='1'";	
				}
				
				$question_sent_query = "SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
		                            	FROM `live_orders`
			                            LEFT JOIN orders ON orders.id = live_orders.order_id
			                            JOIN `publications` ON publications.id = live_orders.pub_id
    					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
				                            WHERE live_orders.category IN ($cat_series) AND live_orders.club_id IN ($club_id)
				                                AND live_orders.crequest != '1' AND live_orders.question = '1'";
			
			if($designers['designer_role'] == '1'){ 		//Asst TL
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				$data['DcQCount'] 		= 	$this->db->query($dc_orders_query)->num_rows();
				$data['DpQCount'] 		= 	$this->db->query($pending_orders_query)->num_rows();
				$data['AllQCount']	 	= 	$this->db->query($all_orders_query)->num_rows();
				$data['questionSentCount']	 	= 	$this->db->query($question_sent_query)->num_rows();
			}elseif($designers['designer_role'] == '2'){	//TL
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				$data['DcQCount'] 		= 	$this->db->query($dc_orders_query)->num_rows();
				$data['DpQCount'] 		= 	$this->db->query($pending_orders_query)->num_rows();
				$data['AllQCount']	 	= 	$this->db->query($all_orders_query)->num_rows();
				$data['questionSentCount']	 	= 	$this->db->query($question_sent_query)->num_rows();
			}elseif($designers['designer_role'] == '3'){	//Designer
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				
			}elseif($designers['designer_role'] == '4'){	//Hi_B_Designer
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
			}
			
		 }
		
		echo json_encode($data);
	} 
    
     public function live_new_ads()
    {
        $dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array();
        $data['dId'] = $dId;
 		$data['designers'] = $designers; 
        $this->load->view('new_designer/live_new_ads_pagination',$data);
    }
    
    public function live_new_ads_pagination_details($display_type = '')
    {    
        $dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array();
        $adwit_teams_id = $designers['adwit_teams_id'];
        $adwit_team_detail = $this->db->query("SELECT `category`  FROM `adwit_teams` WHERE `adwit_teams_id` = $adwit_teams_id AND `is_active` = 1")->row_array();
        $data =array();	
        if(isset($adwit_team_detail['category'])){
            if($this->session->userdata('clubList')!== null){
                $adwit_team_club = $this->session->userdata('clubList');
            }else{
                $adwit_teams_and_club = $this->db->query("SELECT GROUP_CONCAT(club_id) AS clubList FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id';")->row_array(); 
                $adwit_team_club = $adwit_teams_and_club['clubList'];
            }
            $club_id = $adwit_team_club;
            $cat_id = explode(',', $adwit_team_detail['category']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			 $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','Category','Sub Category','Status','Club','Priority'); 
    		if($display_type == 'MyQ'){
    			//tab='MyQ' display_type = 'upload_pending'
    			$query = "SELECT live_orders.id, live_orders.pub_id AS publication_id, live_orders.order_id AS orderId, live_orders.category, live_orders.sub_category, 
                			live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, 
                			live_orders.job_no,
                			publications.name AS publicationName, publications.design_team_id,
                			club.name AS clubName,
                			time_zone.priority AS time_zone_priority
    			         FROM `live_orders`
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
    			                        JOIN `club` ON club.id = live_orders.club_id
        					            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				    WHERE live_orders.designer_id = '$dId' AND live_orders.crequest != '1'";
    									
    		    $recordsTotal = $this->db->query($query)->num_rows();
                //search or Filter
    			if(isset($_GET['search']['value'])){
    			    $query .= " AND (";
    			    
    				$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';
    
    				$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR live_orders.timestamp LIKE "%'.$_GET["search"]["value"].'%"';
    				//$query .= ' OR orders.page_design_id LIKE "%'.$_GET["search"]["value"].'%"';
    				$query .= ' OR live_orders.category LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR club.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    			    $query .= ") ";
    			}
    			//squery order by
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{  
                    $query .= " ORDER BY time_zone.priority" ;
                } 
                
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                // 	echo $query;
                $orders = $this->db->query($query)->result_array();
                foreach($orders as $row){
                    $order = $this->db->query("SELECT `adrep_id`,`rush`,`created_on`,`question`,`help_desk`, `advertiser_name`, `order_type_id` FROM `orders` 
    			                                WHERE id = '".$row['orderId']."'")->row_array();
					
					//$cat_result = $this->db->query("SELECT `pro_status`,`category` FROM `cat_result` WHERE `order_no`='".$row['orderId']."' ;")->row_array();
					
    				$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
    					                            JOIN color_code ON color_code.id = adreps.color_code
		                                             WHERE adreps.id = '".$order['adrep_id']."' ;")->row_array();
    			
					$status = $this->db->query("SELECT `name` FROM `production_status` WHERE id='".$row['pro_status']."'")->row_array();
                    $sub_array = array();
                    $created_on_date = strtotime($order['created_on']);
                    if($order['rush']=='1'){ 
                        $rowClass = "bg-red-pink"; 
                    }elseif($adreps['premium']=='1'){ 
                        $rowClass = "bg-yellow"; 
                    }elseif(isset($adreps['code'])){ 
                        $rowClass = $adreps['code']; 
                    }else{ 
                        $rowClass = "odd gradeX"; 
                    }
                    $sub_array[] = $rowClass;
                    $sub_array[] = date('d-M', $created_on_date); 
                    $sub_array[] = $row['orderId'];
                    if($order['order_type_id'] == '6'){
                        $sub_array[] = $order['advertiser_name'].'/'.$row['job_no'];
                    }else{
                        $sub_array[] = $row['job_no'];
                    }
                    $sub_array[] = $row['publicationName'];
                    
                     if(isset($row['category'])){ $categoryContent =  $row['category']; }else{ $categoryContent =  'Pending'; } 
                    //category
                        $classAttribute = '';
                        if ($row['question'] == '1') {
                            $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                        } elseif ($row['question'] == '2') {
                            $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                        }
                       
                        $category = '<button ' . $classAttribute . 'disabled>';
                        $category .= $categoryContent;
                        $category .= '</button>';
                        $sub_array[] = $category;

                    if($designers['designer_role'] == '2'){ 
                        $sub_category = $this->db->query("SELECT `name` FROM `sub_category` WHERE `id` = '".$row['sub_category']."'")->row_array();
                        if(isset($sub_category['name'])) $sub_array[] = $sub_category['name']; else $sub_array[] = '';
                    }
                    if(isset($status['name'])){
                        $sub_array[] = '<a href="'.base_url().index_page().'new_designer/home/orderview/'.$order['help_desk'].'/'.$row['orderId'].'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue-sunglo btn-xs">'.
								$status['name']
								.'</button>
							</a>';
                    }else{
                        $sub_array[] = '<a href="javascript:;" onclick="window.location = '.base_url().index_page().'new_designer/home/orderview/'.$order['help_desk'].'/'.$row['orderId'].'" style="cursor:pointer; text-decoration: none;">
								<button class="btn blue-sunglo btn-xs"></button>
							</a>';
                    }
				    $sub_array[] = $row['clubName']; 
				    $sub_array[] = $row['time_zone_priority'];
				
                    $data[] = $sub_array;
                }
            }elseif($display_type == 'TotalQ'){    	
    			//TotalQ - design pending
    			$query = "SELECT live_orders.order_id AS orderId, orders.order_type_id, live_orders.job_no, publications.name AS publicationName, 
    			                live_orders.category, live_orders.sub_category, live_orders.pro_status,
    			                time_zone.priority AS time_zone_priority,
    			                live_orders.pub_id AS publication_id, live_orders.designer_id, 
    			                        live_orders.csr_id, live_orders.status,  live_orders.club_id, live_orders.question,
    			                        orders.rush, orders.help_desk, orders.adrep_id, orders.advertiser_name,
    			                         publications.design_team_id, 
    			                        time_zone.priority AS time_zone_priority
    			                        FROM `live_orders`
    			                        JOIN `orders` ON orders.id = live_orders.order_id
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
    					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
        					                WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN ($club_id) 
    									        AND live_orders.crequest != '1' AND live_orders.question != '1' ";
    			
        	    $recordsTotal = $this->db->query($query)->num_rows();
                //search or Filter
    			if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
    			    $query .= " AND (";
    			    
    				$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';
    
    				$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR live_orders.timestamp LIKE "%'.$_GET["search"]["value"].'%"';
    				//$query .= ' OR orders.page_design_id LIKE "%'.$_GET["search"]["value"].'%"';
    				$query .= ' OR live_orders.category LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				//$query .= ' OR club.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    			    $query .= ") ";
    			}
    			
                
                //squery order by
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{  
                    $query .= " ORDER BY orders.rush DESC, time_zone.priority" ;
                } 
                
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
            //     echo 'recordsTotal - '.$recordsTotal.'<br/>';
            //     echo 'recordsFiltered - '.$recordsFiltered.'<br/>';
            // 	echo $query;
                $orders = $this->db->query($query)->result_array();
                foreach($orders as $row){
                    $order_type = 	$this->db->get_where('orders_type', array('id' => $row['order_type_id']))->row_array();	
		            $club_name = $this->db->query("SELECT `name` FROM `club` WHERE id='".$row['club_id']."'")->row_array();
        		    $adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
            					                            JOIN color_code ON color_code.id = adreps.color_code
        		                                             WHERE adreps.id = '".$row['adrep_id']."' ;")->row_array();
                    $sub_array = array();
                    if($row['rush']=='1'){ 
                        $rowClass = "bg-red-pink"; 
                    }elseif($adreps['premium']=='1'){ 
                        $rowClass = "bg-yellow"; 
                    }elseif(isset($adreps['code'])){ 
                        $rowClass = $adreps['code']; 
                    }else{ 
                        $rowClass = "odd gradeX"; 
                    }
                    //order_id
                	$adwitadId = '<a';
                    if ($row['rush'] == 1) {
                        $adwitadId .= ' class="font-grey-cararra"';
                    }
                    $adwitadId .= ' href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $row['help_desk'] . '/' . $row['orderId'] . '\'" style="cursor:pointer; text-decoration: none;">' . $row['orderId'] . '</a>';
                    
                    
                    $sub_array[] = $rowClass;
                    
                        $sub_array[] = $adwitadId;
                        $sub_array[] = '<span class="badge bg-blue">'.$order_type['icon'].'</span>';
                        $sub_array[] = $row['job_no'];
                        $sub_array[] = $row['publicationName']; 
                         //category
                        $classAttribute = '';
                        if ($row['question'] == '1') {
                            $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                        } elseif ($row['question'] == '2') {
                            $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                        }
                        $category = '<button ' . $classAttribute . 'disabled>';
                        $category .= $row['category'];
                        $category .= '</button>';
                        $sub_array[] = $category;
                        
                        if($designers['designer_role'] == '2'){ 
                            $sub_category = $this->db->query("SELECT `name` FROM `sub_category` WHERE `id` = '".$row['sub_category']."'")->row_array();
                            if(isset($sub_category['name'])) $sub_array[] = $sub_category['name']; else $sub_array[] = '';
                        }
                        if($row['designer_id'] == null || $row['designer_id'] == "null"){
                          $sub_array[] = '<button type="button" name="confirm_slug" class="btn green-jungle btn-sm" onClick="create_slug('.$row['orderId'].');" >Start Design</button>';  
                        }else{
                            $sub_array[] = '';
                        }
                        
                        $sub_array[] = $club_name['name']; 
    				    $sub_array[] = $row['time_zone_priority'];
                    
                    $data[] = $sub_array;
                }
            }elseif($display_type == 'DesignCheckQ'){    	
    			//Design Check - design_check
    			$query = "SELECT live_orders.timestamp, live_orders.order_id AS orderId, live_orders.job_no, publications.name AS publicationName, live_orders.category, 
    			            live_orders.sub_category, live_orders.designer_id, live_orders.pro_status, time_zone.priority AS time_zone_priority,
    			            live_orders.csr_id, live_orders.status, 
    			            live_orders.club_id, live_orders.question, live_orders.pub_id
    			                FROM `live_orders`
    			                        JOIN `publications` ON publications.id = live_orders.pub_id
        					            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    									    WHERE live_orders.status = '3' AND (live_orders.pro_status ='2' OR live_orders.pro_status = '8') 
    									    AND live_orders.category IN ($cat_series) AND live_orders.club_id IN ($club_id) AND live_orders.crequest != '1' ";
    			
        	    $recordsTotal = $this->db->query($query)->num_rows();
                //search or Filter
    			if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
    			    $query .= " AND (";
    			    
    				$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';
    
    				$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR live_orders.timestamp LIKE "%'.$_GET["search"]["value"].'%"';
    				//$query .= ' OR orders.page_design_id LIKE "%'.$_GET["search"]["value"].'%"';
    				$query .= ' OR live_orders.category LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				//$query .= ' OR club.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    			    $query .= ") ";
    			}
    			//query order by
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{  
                    $query .= " ORDER BY time_zone.priority ASC" ;
                } 
                
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                // 	echo $query;
                $orders = $this->db->query($query)->result_array();
                foreach($orders as $row){
                    $order_detail = $this->db->query("SELECT `help_desk`,`created_on`,`rush`,`id`,`question`,`adrep_id` FROM `orders` 
									WHERE id='".$row['orderId']."'")->row_array();
            		//$publication = $this->db->query("SELECT `name`,`design_team_id` FROM `publications` WHERE id='".$data['pub_id']."'")->row_array();
            		//$adreps = $this->db->query("SELECT `first_name`,`last_name`,`premium` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->row_array();
            		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
                					                            JOIN color_code ON color_code.id = adreps.color_code
            		                                             WHERE adreps.id = '".$order_detail['adrep_id']."' ;")->row_array();
            		$status = $this->db->get_where('production_status',array('id' => $row['pro_status']))->row_array();
            		if(isset($row['designer_id'])){				
            			$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$row['designer_id']."' ;")->row_array();
            		}
                    $sub_array = array();
                    $created_on_date = strtotime($order_detail['created_on']);
                    if($order_detail['rush']=='1'){ 
                        $rowClass = "bg-red-pink"; 
                    }elseif($adreps['premium']=='1'){ 
                        $rowClass = "bg-yellow"; 
                    }elseif(isset($adreps['code'])){ 
                        $rowClass = $adreps['code']; 
                    }else{ 
                        $rowClass = "odd gradeX"; 
                    }
                    //order_id
                	$adwitadId = '<a';
                    if ($order_detail['rush'] == 1) {
                        $adwitadId .= ' class="font-grey-cararra"';
                    }
                    $adwitadId .= ' href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $order_detail['help_desk'] . '/' . $row['orderId'] . '\'" style="cursor:pointer; text-decoration: none;">' . $row['orderId'] . '</a>';
                    
                    
                    $sub_array[] = $rowClass;
                        $sub_array[] = date('d-M', $created_on_date); 
                        $sub_array[] = $adwitadId;
                        $sub_array[] = $row['job_no'];
                        $sub_array[] = $row['publicationName']; 
                        //category
                        $classAttribute = '';
                        if ($row['question'] == '1') {
                            $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                        } elseif ($row['question'] == '2') {
                            $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                        }
                        $category = '<button ' . $classAttribute . 'disabled>';
                        $category .= $row['category'];
                        $category .= '</button>';
                        $sub_array[] = $category;
                        
                        if($designers['designer_role'] == '2'){ 
                            $sub_category = $this->db->query("SELECT `name` FROM `sub_category` WHERE `id` = '".$row['sub_category']."'")->row_array();
                            if(isset($sub_category['name'])) $sub_array[] = $sub_category['name']; else $sub_array[] = '';
                        }
                        if(isset($designer_pending['username'])){ $sub_array[] =  $designer_pending['username']; } else { $sub_array[] =  ' ' ; }
                        if($order_detail['rush'] == 1){
                            $sub_array[] = '<a  class="btn btn-xs btn-success font-grey-cararra"  href="'.base_url().index_page().'new_designer/home/orderview/'.$order_detail['help_desk'].'/'.$row['orderId'].'">
    							'.$status['name'].'</a>';
						}else{
						    $sub_array[] = '<a  class="btn btn-xs btn-success"  href="'.base_url().index_page().'new_designer/home/orderview/'.$order_detail['help_desk'].'/'.$row['orderId'].'">
    							'.$status['name'].'</a>';
						}
						$sub_array[] = $row['time_zone_priority'];
                    
                    $data[] = $sub_array;
                }
            }elseif($display_type == 'DesignPendingQ'){    	
    			//pending
    			$query = "SELECT live_orders.timestamp, live_orders.order_id AS orderId, live_orders.job_no, publications.name AS publicationName, 
    			live_orders.category, live_orders.sub_category, live_orders.designer_id, live_orders.pro_status, time_zone.priority AS time_zone_priority, 
    			            live_orders.csr_id, live_orders.status, live_orders.club_id, live_orders.question, publications.design_team_id,
    			            orders.adrep_id, orders.rush, orders.created_on, orders.status, orders.help_desk
    		                  FROM `live_orders`
    		                         JOIN `orders` ON orders.id = live_orders.order_id
    			                     JOIN `publications` ON publications.id = live_orders.pub_id
        					         JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                            WHERE live_orders.category IN ($cat_series) AND live_orders.status IN (2,3,4,8) AND live_orders.club_id IN ($club_id) 
    				                                AND live_orders.crequest != '1' AND live_orders.question != '1' ";
    			
        	    $recordsTotal = $this->db->query($query)->num_rows();
                //search or Filter
    			if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
    			    $query .= " AND (";
    			    
    				$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';
    
    				$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR live_orders.timestamp LIKE "%'.$_GET["search"]["value"].'%"';
    				//$query .= ' OR orders.page_design_id LIKE "%'.$_GET["search"]["value"].'%"';
    				$query .= ' OR live_orders.category LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				//$query .= ' OR club.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    			    $query .= ") ";
    			}
    			//query order by
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{  
                    $query .= " ORDER BY orders.rush DESC, time_zone.priority" ;
                } 
                
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                // 	echo $query;
                $orders = $this->db->query($query)->result_array();
                foreach($orders as $row){
        //             $order_detail = $this->db->query("SELECT `adrep_id`,`rush`,`created_on`,`status`,`help_desk` FROM `orders` 
								// 	WHERE id='".$row['orderId']."'")->row_array();
            		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
                					                            JOIN color_code ON color_code.id = adreps.color_code
            		                                             WHERE adreps.id = '".$row['adrep_id']."' ;")->row_array();
            		if(isset($row['pro_status']) && $row['pro_status'] != '0'){
						$status = $this->db->get_where('production_status',array('id' => $row['pro_status']))->row_array();					
					}else{
						$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->row_array();					
					}
            		if(isset($row['designer_id'])){				
            			$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$row['designer_id']."' ;")->row_array();
            		}
                    $sub_array = array();
                    $created_on_date = strtotime($row['created_on']);
                        if($row['rush']=='1'){ 
                            $rowClass = "bg-red-pink"; 
                        }elseif($adreps['premium']=='1'){ 
                            $rowClass = "bg-yellow"; 
                        }elseif(isset($adreps['code'])){ 
                            $rowClass = $adreps['code']; 
                        }else{ 
                            $rowClass = "odd gradeX"; 
                        }
                        
                         //order_id
                    	$adwitadId = '<a';
                        if ($row['rush'] == 1) {
                            $adwitadId .= ' class="font-grey-cararra"';
                        }
                        $adwitadId .= ' href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $row['help_desk'] . '/' . $row['orderId'] . '\'" style="cursor:pointer; text-decoration: none;">' . $row['orderId'] . '</a>';
                    
                        
                        $sub_array[] = $rowClass;
                        $sub_array[] = date('d-M', $created_on_date); 
                        $sub_array[] = $adwitadId;
                        $sub_array[] = $row['job_no'];
                        $sub_array[] = $row['publicationName']; 
                         //category
                        $classAttribute = '';
                        if ($row['question'] == '1') {
                            $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                        } elseif ($row['question'] == '2') {
                            $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                        }
                        $category = '<button ' . $classAttribute . 'disabled>';
                        $category .= $row['category'];
                        $category .= '</button>';
                        $sub_array[] = $category;
                            
                        if($designers['designer_role'] == '2'){ 
                            $sub_category = $this->db->query("SELECT `name` FROM `sub_category` WHERE `id` = '".$row['sub_category']."'")->row_array();
                            if(isset($sub_category['name'])) $sub_array[] = $sub_category['name']; else $sub_array[] = '';
                        }else{
                            $sub_array[] = '';
                        }
                        if(isset($designer_pending['username']) && isset($row['designer_id'])){ $sub_array[] =  $designer_pending['username']; } else { $sub_array[] =  ' ' ; }
                        if($row['rush'] == 1){
                            $sub_array[] = '<a  class="btn btn-xs btn-success font-grey-cararra"  href="'.base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['orderId'].'">
    							'.$status['name'].'</a>';
						}else{
						    $sub_array[] = '<a  class="btn btn-xs btn-success"  href="'.base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['orderId'].'">
    							'.$status['name'].'</a>';
						}
						$sub_array[] = $row['time_zone_priority'];
                    
                    $data[] = $sub_array;
                }
            }elseif($display_type == 'AllQ'){    	
    			//all
    			$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
    				$ystday_time = $today_date_time[0]['time'];
    				$today_time = $today_date_time[1]['time'];
    				$tomo_time = $today_date_time[2]['time'];
    				$current_date = date("Y-m-d");
    				$ysterday = date("Y-m-d", strtotime(' -1 day'));
    				$tomo = date("Y-m-d", strtotime(' +1 day'));
    				$ct = date("H:i:s");
    			if($ct >= '00:00:00' && $ct <= '08:29:59'){		
    			    $from = $ysterday.' '.$ystday_time; 
    				$to = $current_date.' '.$today_time;
    			}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
    			    $from = $current_date.' '.$today_time; 
    				$to = $tomo.' '.$tomo_time;
    			}
    			$query = "SELECT orders.id AS orderId, orders.order_type_id, orders.created_on, orders.job_no, 
    			    publications.name AS publicationName, publications.club_id, orders.status, orders.adrep_id, orders.rush, 
    			    orders.question, orders.help_desk, orders.group_id, time_zone.priority AS time_zone_priority, club.name AS clubName
    					                        FROM `orders`
    						                    LEFT JOIN `publications` on publications.id = orders.publication_id
    						                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    						                    JOIN `club` ON club.id = orders.club_id
    						                    WHERE publications.club_id IN ($club_id) AND (orders.created_on BETWEEN '$from' AND '$to') 
    						                    AND orders.crequest!='1' AND orders.cancel!='1' ";	
    			
        	    $recordsTotal = $this->db->query($query)->num_rows();
                //search or Filter
    			if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
    			    $query .= " AND (";
    			    
    				$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';
    
    				$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR orders.created_on LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR club.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    			    $query .= ") ";
    			}
    			//query order by
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{  
                    $query .= " ORDER BY orders.rush DESC, time_zone.priority ASC" ;
                } 
                
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                // 	echo $query;
                $orders = $this->db->query($query)->result_array();
                foreach($orders as $row){
                    
            		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
                					                            JOIN color_code ON color_code.id = adreps.color_code
            		                                             WHERE adreps.id = '".$row['adrep_id']."' ;")->row_array();
            		$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->row_array();					
					
					$group = $this->db->query("SELECT `name` FROM `Group` WHERE `id` = '".$row['group_id']."'")->row_array();
					
					$order_type = 	$this->db->get_where('orders_type', array('id' => $row['order_type_id']))->row_array();
					
                    $sub_array = array();
                    $created_on_date = strtotime($row['created_on']);
                        if($row['rush']=='1'){ 
                            $rowClass = "bg-red-pink"; 
                        }elseif($adreps['premium']=='1'){ 
                            $rowClass = "bg-yellow"; 
                        }elseif(isset($adreps['code'])){ 
                            $rowClass = $adreps['code']; 
                        }else{ 
                            $rowClass = "odd gradeX"; 
                        }
                       
                        $sub_array[] = $rowClass;
                        $sub_array[] = date('d-M', $created_on_date); 
                        $sub_array[] = '<span class="badge bg-blue">'.$order_type['icon'].'</span>';
                        if($row['rush'] == '1'){
                            $sub_array[] = '<a class="font-grey-cararra" href="'.base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['orderId'].'" >
                                            '.$row['orderId'].'</a>';
                        }else{
                            $sub_array[] = '<a href="'.base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['orderId'].'" >
                                            '.$row['orderId'].'</a>';
                        }
                        
                        $sub_array[] = $row['job_no'];
                        //$sub_array[] = $adreps['first_name']; 
                        $sub_array[] = $row['publicationName']; 
                        $sub_array[] = $group['name'];
                        $sub_array[] = '<a class="btn btn-xs btn-success" href="'.base_url().index_page().'new_designer/home/orderview/'.$row['help_desk'].'/'.$row['orderId'].'" >
                                        '.$status['name'].'</a>';
                        $sub_array[] = $row['clubName']; 
                        $sub_array[] = $row['time_zone_priority'];
                    
                    $data[] = $sub_array;
                }
            }elseif($display_type == 'QuestionSentQ'){    	
    			//QuestionSent
    			
    			$query = "SELECT live_orders.timestamp, live_orders.order_id AS orderId, live_orders.job_no, publications.name AS publicationName, 
    			live_orders.category, live_orders.sub_category, live_orders.designer_id, live_orders.pro_status, time_zone.priority AS time_zone_priority, 
    			            live_orders.csr_id, live_orders.status, live_orders.club_id, live_orders.question, publications.design_team_id
    		                  FROM `live_orders`
    		                         JOIN `publications` ON publications.id = live_orders.pub_id
        					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    				                             WHERE live_orders.category IN ($cat_series) AND live_orders.club_id IN ($club_id)
				                                AND live_orders.crequest != '1' AND live_orders.question = '1' ";
    			
        	    $recordsTotal = $this->db->query($query)->num_rows();
                //search or Filter
    			if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
    			    $query .= " AND (";
    			    
    				$query .= ' live_orders.order_id LIKE "%'.$_GET["search"]["value"].'%"';
    
    				$query .= ' OR live_orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR live_orders.timestamp LIKE "%'.$_GET["search"]["value"].'%"';
    				//$query .= ' OR orders.page_design_id LIKE "%'.$_GET["search"]["value"].'%"';
    				$query .= ' OR live_orders.category LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    				//$query .= ' OR club.name LIKE "%'.$_GET["search"]["value"].'%"';
    				
    			    $query .= ") ";
    			}
    			//query order by
                if(isset($_GET["order"])){ 
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
                }else{  
                    $query .= " ORDER BY time_zone.priority ASC" ;
                } 
                
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                // 	echo $query;
                $orders = $this->db->query($query)->result_array();
                foreach($orders as $row){
                    $order_detail = $this->db->query("SELECT `id`,`adrep_id`,`rush`,`created_on`,`status`,`help_desk` FROM `orders` 
									WHERE id='".$row['orderId']."'")->row_array();
					if(isset($order_detail['id'])){				
                		$adreps = $this->db->query("SELECT adreps.first_name, adreps.last_name , adreps.premium, color_code.code FROM `adreps`
                    					                            JOIN color_code ON color_code.id = adreps.color_code
                		                                             WHERE adreps.id = '".$order_detail['adrep_id']."' ;")->row_array();
                		if(isset($row['pro_status']) && $row['pro_status'] != '0'){
    						$status = $this->db->get_where('production_status',array('id' => $row['pro_status']))->row_array();					
    					}else{
    						$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->row_array();					
    					}
                		if(isset($row['designer_id'])){				
                			$designer_pending = $this->db->query("SELECT `username` FROM `designers` WHERE `id`='".$row['designer_id']."' ;")->row_array();
                		}
                        $sub_array = array();
                        $created_on_date = strtotime($order_detail['created_on']);
                            if($order_detail['rush']=='1'){ 
                                $rowClass = "bg-red-pink"; 
                            }elseif($adreps['premium']=='1'){ 
                                $rowClass = "bg-yellow"; 
                            }elseif(isset($adreps['code'])){ 
                                $rowClass = $adreps['code']; 
                            }else{ 
                                $rowClass = "odd gradeX"; 
                            }
                            $sub_array[] = $rowClass;
                            $sub_array[] = date('d-M', $created_on_date); 
                            if($order_detail['rush'] == '1'){
                            $sub_array[] = '<a class="font-grey-cararra" href="'.base_url().index_page().'new_designer/home/orderview/'.$order_detail['help_desk'].'/'.$row['orderId'].'" >
                                            '.$row['orderId'].'</a>';
                            }else{
                                $sub_array[] = '<a href="'.base_url().index_page().'new_designer/home/orderview/'.$order_detail['help_desk'].'/'.$row['orderId'].'" >
                                                '.$row['orderId'].'</a>';
                            }
                            $sub_array[] = $row['job_no'];
                            $sub_array[] = $row['publicationName']; 
                            //category
                            $classAttribute = '';
                            if ($row['question'] == '1') {
                                $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                            } elseif ($row['question'] == '2') {
                                $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                            }
                            $category = '<button ' . $classAttribute . 'disabled>';
                            $category .= $row['category'];
                            $category .= '</button>';
                            
                            $sub_array[] = $category;
                            
                            if($designers['designer_role'] == '2'){ 
                                $sub_category = $this->db->query("SELECT `name` FROM `sub_category` WHERE `id` = '".$row['sub_category']."'")->row_array();
                                if(isset($sub_category['name'])) $sub_array[] = $sub_category['name']; else $sub_array[] = '';
                            }else{
                                $sub_array[] = '';
                            }
                            if(isset($designer_pending['username'])){ $sub_array[] =  $designer_pending['username']; } else { $sub_array[] =  ' ' ; }
                            if($order_detail['rush'] == 1){
                                $sub_array[] = '<a  class="btn btn-xs btn-success font-grey-cararra"  href="'.base_url().index_page().'new_designer/home/orderview/'.$order_detail['help_desk'].'/'.$row['orderId'].'">
        							'.$status['name'].'</a>';
    						}else{
    						    $sub_array[] = '<a  class="btn btn-xs btn-success"  href="'.base_url().index_page().'new_designer/home/orderview/'.$order_detail['help_desk'].'/'.$row['orderId'].'">
        							'.$status['name'].'</a>';
    						}
    						$sub_array[] = $row['time_zone_priority'];
                        
                        $data[] = $sub_array;
                    }
                }
            }
            
    		$output = array(  
                        "draw"              =>     intval($_GET["draw"]),  
                        "recordsTotal"      =>     $recordsTotal,  
                        "recordsFiltered"   =>     $recordsFiltered,  
                        "data"              =>     $data, 
                        "title"              =>     $columns 
                   );  
                   echo json_encode($output);
		}else{
		    $this->session->set_flashdata("message","No Team Assigned..!! Contact Acharya or Jeevan regarding the issue..!!");
		    redirect('new_designer/home');
		}
    }
    
    public function live_new_ads_pagination_columns($display_type)
    {
        $dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array();
        if($designers['designer_role'] == '2'){
            if($display_type == 'MyQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','Category','Sub Category','Status','Club','Priority'); 
            }elseif($display_type == 'TotalQ'){
                $columns = array('','AdwitAds ID','Type','Unique Job Name','Publication','Category','Sub Category','Design','Club','Priority'); 
            }elseif($display_type == 'DesignCheckQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','C','Sub Category','Designer','Status','Priority'); 
            }elseif($display_type == 'DesignPendingQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','C','Sub Category','Designer','Status','Priority'); 
            }elseif($display_type == 'AllQ'){
                $columns = array('','Date','Type','AdwitAds ID','Unique Job Name','Publication','Group','Status','Club','Priority'); 
            }elseif($display_type == 'QuestionSentQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','C','Sub Category','Designer','Status','Priority'); 
            }
        }else{
            if($display_type == 'MyQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','Category','Status','Club','Priority'); 
            }elseif($display_type == 'TotalQ'){
                $columns = array('','AdwitAds ID','Type','Unique Job Name','Publication','Category','Design','Club','Priority'); 
            }elseif($display_type == 'DesignCheckQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','C','Designer','Status','Priority'); 
            }elseif($display_type == 'DesignPendingQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','C','Designer','Status','Priority'); 
            }elseif($display_type == 'AllQ'){
                $columns = array('','Date','Type','AdwitAds ID','Unique Job Name','Publication','Group','Status','Club','Priority'); 
            }elseif($display_type == 'QuestionSentQ'){
                $columns = array('','Date','AdwitAds ID','Unique Job Name','Publication','C','Designer','Status','Priority'); 
            }
        }
        echo json_encode($columns);
    }
    
	public function createSlug($order_id)
	{
		$q = "SELECT orders.id AS oid, orders.job_no, orders.help_desk, cat_result.id AS cat_id, cat_result.designer, cat_result.tag_designer, cat_result.job_name, cat_result.order_no, cat_result.news_initial, cat_result.category, cat_result.slug, cat_result.slug_type, cat_result.advertiser, cat_result.assign, cat_result.pdf_path  FROM `orders` 
									LEFT JOIN cat_result on orders.id = cat_result.order_no
									WHERE  orders.id = '$order_id' AND orders.status = '2'";
		$order = $this->db->query($q)->row_array();
		if(isset($order['oid'])){
		    //check for production and QA count of designer
		    //In QA count
		    $dId = $this->session->userdata('dId');
		    /*
			$QA_count = $this->db->query("SELECT COUNT(live_orders.id) AS QA_count FROM `live_orders`
			                    RIGHT JOIN `orders` ON orders.id = live_orders.order_id
								    WHERE live_orders.designer_id = '$dId' AND live_orders.pro_status = '3' AND live_orders.crequest != '1' 
								    AND live_orders.question != '1'; ")->row_array();
			*/
			//In production count
			$production_count = $this->db->query("SELECT COUNT(live_orders.id) AS production_count FROM `live_orders`
			                            RIGHT JOIN `orders` ON orders.id = live_orders.order_id
										    WHERE live_orders.designer_id = '$dId' AND live_orders.pro_status = '1' AND live_orders.crequest != '1' 
										    AND live_orders.question != '1'; ")->row_array();
            $in_production_count = $production_count['production_count'];
            //$in_QA_count = $QA_count['QA_count']; 
            $allowed_limit = 3;
            if($dId==312)$allowed_limit = 30;//increased limit for acharya as he recieves pagination order.
            
			if($in_production_count < $allowed_limit){        //Allowed In production-3 and In QA- 15
			    //New Ad slug
    			$slug = ''; $help_desk = ''; $cat_id = ''; $msg = '';
    			if($order['slug']=='none' || $order['slug']==''){
    				$version = 'V1';
    				$job_name = $order['job_no'];
    				$order_no = $order['oid'];
    				$slug_type = $order['slug_type'];
    				$news_initial = $order['news_initial'];
    				$category = $order['category'];
    				$advertiser = $order['advertiser'];
    				$dId = $this->session->userdata('designer');
    				$help_desk = $order['help_desk'];
    				$cat_id = $order['cat_id'];
    				$job_name = str_replace(' ', '_', $job_name);
    				if($slug_type == '1')
    					$slug = $order_no."_".$news_initial."_".$job_name."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '2')
    					$slug = $job_name;
    				elseif($slug_type == '3')
    					$slug = $job_name."_".$news_initial."_".$order_no."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '4')
    					$slug = $order_no."-".$news_initial."_".$category."_".$dId."-".$version;
    				elseif($slug_type == '5')
    					$slug = $order_no."_".$job_name."_".$news_initial."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '6')
    					$slug = $job_name."_".$order_no."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '7')
    					$slug = $job_name."_".$order_no."_".$news_initial."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '8')
    					$slug = $order_no."_".$job_name."_".$advertiser."_".$news_initial."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '9')
    					$slug = $job_name."_".$advertiser."_".$news_initial."_".$order_no."_".$category."_".$dId."_".$version;
    				elseif($slug_type == '10')
    					$slug = $advertiser."_".$job_name."_".$news_initial."_".$category."_".$dId."_".$version;
    				else{
    					$msg = "Slug undefined for this slug type - ".$slug_type." provide valid slug type in Publication";
    				} 
    				$slug = str_replace(' ', '_', $slug);
    			}
    			$data = array('slug' => $slug, 'help_desk' => $help_desk, 'cat_id' => $cat_id, 'msg' => $msg);
			}else{
    		   // $msg =  "You Already have In-Production: ".$in_production_count." and In-QA: ".$in_QA_count." Ads. Complete 'My Q' before you take a new ad(Allowed Limit In-Production: 3, In-QA: 15 Ads)";
    		    $msg =  "You Already have In-Production: ".$in_production_count.". Complete 'My Q' before you take a new ad(Allowed Limit In-Production: $allowed_limit)";
			    $data = array('msg' => $msg);
			}
		}else{
			$msg =  'Order not in slug creation state..!!';
			$data = array('msg' => $msg);
		}
		
		echo json_encode($data);
	}
	
	public function live_revisions()
    {	
	
		$dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array(); 
        $pub_id = "(".$designers[0]['pub_id'].")";
        $data['orders_rev'] = $this->db->query("SELECT live_revisions.*, rev_sold_jobs.classification, rev_sold_jobs.designer, rev_sold_jobs.rush, rev_sold_jobs.order_no, rev_sold_jobs.new_slug, rev_sold_jobs.category
		FROM `live_revisions`
		left outer join rev_sold_jobs on live_revisions.order_id = rev_sold_jobs.order_id WHERE live_revisions.pub_id IN $pub_id")->result_array();
		
		if(isset($_POST['create_slug']))
		{
			$order_id = $_POST['order_id'];
			$rev_orders = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' AND `job_accept`='1' AND `cancel`='0' ORDER BY `id` DESC LIMIT 1")->row_array();
			$_POST['prev_slug'] = $rev_orders['order_no'];
			$_POST['version'] = $rev_orders['version'];
			$_POST['id'] = $rev_orders['id'];
			//$this->Qrevision_slug();
			$return_msg = $this->Qrevision_slug();
			$this->session->set_flashdata("message",$return_msg);
			redirect('new_designer/live_revisions',$data);
		}
		$this->load->view('new_designer/live_revisions',$data);
	}
	
/*page design start */

	public function pagination_tab_count()
	{
		$MyQ = 0; $TotalQ = 0; $DcQ = 0; $DpQ = 0; $AllQ = 0;
		$dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
        $pub_id = "(".$designers['pub_id'].")";
		
		 if($designers['category_level'] != null && $designers['club_id'] != null){
			$club_id = "(".$designers['club_id'].")";
			
			$cat_id = explode(',', $designers['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";
			
			//tab='MyQ' display_type = 'upload_pending' 
			$myq_orders_query = "SELECT orders.id FROM `orders`
								 JOIN `cat_result` ON cat_result.order_no = orders.id
								 JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
				                 WHERE orders.order_type_id = '6' AND cat_result.designer = '$dId' AND orders.crequest != '1'; ";
				                 
			//tab=TotalQ display_type = 'design_pending' 
			$dp_orders_query = "SELECT orders.id FROM `orders` 
			                        RIGHT JOIN `cat_result` ON cat_result.order_no = orders.id
			                        JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
									WHERE orders.order_type_id = '6' AND orders.status = '2' AND orders.club_id IN $club_id 
									AND orders.crequest != '1' AND orders.question != '1';";
				
			//tab=Design_check(DcQ) display_type = 'design_check' 
			$dc_orders_query = "SELECT orders.id FROM `orders`
			                         RIGHT JOIN `cat_result` ON cat_result.order_no = orders.id
			                         JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
									WHERE orders.order_type_id = '6' AND orders.status = '3' AND (cat_result.pro_status ='2' OR cat_result.pro_status = '8') 
									AND orders.club_id IN $club_id AND orders.crequest != '1';";
			
			//tab=Pending(DpQ) display_type = 'all_pending' 
			$pending_orders_query = "SELECT orders.id FROM `orders`
                    					RIGHT JOIN `cat_result` ON cat_result.order_no = orders.id
                    					JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
                    					WHERE orders.order_type_id = '6' AND orders.status IN (2,3,4,8) AND orders.club_id IN $club_id 
                    					AND orders.crequest != '1' AND orders.question != '1'";
			
			$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
					$ystday_time = $today_date_time[0]['time'];
					$today_time = $today_date_time[1]['time'];
					$tomo_time = $today_date_time[2]['time'];
					$current_date = date("Y-m-d");
					$ysterday = date("Y-m-d", strtotime(' -1 day'));
					$tomo = date("Y-m-d", strtotime(' +1 day'));
					$ct = date("H:i:s");
				if($ct >= '00:00:00' && $ct <= '08:29:59'){		
					$all_orders_query = "SELECT orders.id FROM `orders`
						LEFT JOIN `publications` on publications.id = orders.publication_id
						JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
						 WHERE orders.order_type_id = '6' AND publications.club_id IN $club_id AND (orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') 
						 AND orders.crequest!='1' AND orders.cancel!='1'";
				}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
					$all_orders_query = "SELECT orders.id FROM `orders`
						LEFT JOIN `publications` on publications.id = orders.publication_id
						JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
						 WHERE orders.order_type_id = '6' AND publications.club_id IN $club_id AND (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') 
						 AND orders.crequest!='1' AND orders.cancel!='1'";	
				}
				
				$question_sent_query = "SELECT orders.id, orders.publication_id, orders.job_no, cat_result.category, cat_result.designer, cat_result.csr, orders.status, cat_result.pro_status, 
				                            orders.club_id, orders.question, time_zone.priority AS time_zone_priority
		                            	FROM `orders`
			                            LEFT JOIN `cat_result` ON cat_result.order_no = orders.id
			                            JOIN `publications` ON publications.id = orders.publication_id
    					                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    					                JOIN `page_design_section` ON page_design_section.id = orders.page_design_id
				                        WHERE orders.order_type_id = '6' AND orders.club_id IN $club_id AND orders.crequest != '1' AND orders.question = '1'";
			
			if($designers['designer_role'] == '1'){ 		//Asst TL
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				$data['DcQCount'] 		= 	$this->db->query($dc_orders_query)->num_rows();
				$data['DpQCount'] 		= 	$this->db->query($pending_orders_query)->num_rows();
				$data['AllQCount']	 	= 	$this->db->query($all_orders_query)->num_rows();
				$data['questionSentCount']	 	= 	$this->db->query($question_sent_query)->num_rows();
			}elseif($designers['designer_role'] == '2'){	//TL
				//counts
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				$data['DcQCount'] 		= 	$this->db->query($dc_orders_query)->num_rows();
				$data['DpQCount'] 		= 	$this->db->query($pending_orders_query)->num_rows();
				$data['AllQCount']	 	= 	$this->db->query($all_orders_query)->num_rows();
				$data['questionSentCount']	 	= 	$this->db->query($question_sent_query)->num_rows();
			}elseif($designers['designer_role'] == '3'){	//Designer
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
				
			}elseif($designers['designer_role'] == '4'){	//Hi_B_Designer
				//counts
				$data['MyQCount'] 		= 	$this->db->query($myq_orders_query)->num_rows();
				$data['TotalQCount']   = 	$this->db->query($dp_orders_query)->num_rows();
			}
			
		 }
		
		echo json_encode($data);
	}
	
    public function pagination_orders($display_type = '')
    {    
        $dId = $this->session->userdata('dId');
        $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->row_array(); 
        $pub_id = "(".$designers['pub_id'].")";
        $adwit_teams_id = $designers['adwit_teams_id'];
        $adwit_teams_and_club = $this->db->query("SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id'")->result_array(); 
		//Assign Annex
            if(isset($_POST['submit']) && isset($_POST['cat_id'])){
                foreach($_POST['assign'] as $item) 
                {
                    $post = array('assign' => $_POST['submit']);
                    $this->db->where('id', $item);
                    $this->db->update('cat_result', $post);
                }
            }
            
        //Tag Designer
            if(isset($_POST['submit_designer']) && isset($_POST['assign_designer'])){
                foreach($_POST['assign_designer'] as $item_id) 
                {
                    $post1 = array('tag_designer' => $_POST['submit_designer']);
                    $this->db->where('id', $item_id);
                    $this->db->update('cat_result', $post1);
                }
            }
			
        if($designers['category_level'] != null && $designers['club_id'] != null){
			$club_id = "(".$designers['club_id'].")";
            
            $cat_id = explode(',', $designers['category_level']);
			$cat_series = "'" . implode ( "', '", $cat_id ) . "'";

			$query = "SELECT orders.id, orders.publication_id, orders.adrep_id, orders.job_no, orders.status, orders.club_id, orders.adrep_id, orders.order_type_id, 
    			                         orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name,
    			                         cat_result.category, cat_result.designer, cat_result.csr, cat_result.pro_status, 
    			                         page_design_section.id AS sectionId, page_design_section.section_name, page_design_section.page_design_id
    			                    FROM `orders`
    			                        JOIN `cat_result` ON cat_result.order_no = orders.id
    			                        JOIN `page_design_section` ON page_design_section.id = orders.page_design_id";
    			                        
    		if($display_type == 'upload_pending'){
    			//tab='MyQ' display_type = 'upload_pending'
    			$myq_orders_query = $query." WHERE orders.order_type_id = '6' AND cat_result.designer = '$dId' AND orders.crequest != '1'; ";
    			//echo $myq_orders_query;
    			$data['MyQ'] 	  = $this->db->query($myq_orders_query)->result_array();
    			
    		}elseif($display_type == 'design_pending'){
    			
    			$dp_orders_query = $query." WHERE orders.order_type_id = '6' AND orders.status = '2' AND orders.club_id IN $club_id 
    									        AND orders.crequest != '1' AND orders.question != '1';" ;
    			
    			$data['TotalQ']   = 	$this->db->query($dp_orders_query)->result_array();
    		}elseif($display_type == 'design_check'){
    			//tab=Design_check(DcQ) display_type = 'design_check' 
    			$dc_orders_query = $query." WHERE orders.order_type_id = '6' AND orders.status = '3' AND (cat_result.pro_status ='2' OR cat_result.pro_status = '8') 
    									    AND orders.club_id IN $club_id AND orders.crequest != '1';";
    			$data['DcQ'] 		= 	$this->db->query($dc_orders_query)->result_array();
    			//echo $dc_orders_query;							
    		}elseif($display_type == 'all_pending'){
    			//tab=Pending(DpQ) display_type = 'all_pending' 
    			$pending_orders_query = $query." WHERE orders.order_type_id = '6' AND orders.status IN (2,3,4,8) AND orders.club_id IN $club_id 
    				                                AND orders.crequest != '1' AND orders.question != '1'";
    			$data['DpQ'] 		= 	$this->db->query($pending_orders_query)->result_array();
    			
    		}elseif($display_type == 'all'){
    			//tab=All(AllQ) display_type = 'all' 
    			$today_date_time = $this->db->query("select * from `today_date_time`")->result_array();
    					$ystday_time = $today_date_time[0]['time'];
    					$today_time = $today_date_time[1]['time'];
    					$tomo_time = $today_date_time[2]['time'];
    					$current_date = date("Y-m-d");
    					$ysterday = date("Y-m-d", strtotime(' -1 day'));
    					$tomo = date("Y-m-d", strtotime(' +1 day'));
    					$ct = date("H:i:s");
    				if($ct >= '00:00:00' && $ct <= '08:29:59'){		
    					$all_orders_query = "SELECT orders.id, orders.order_type_id, orders.created_on, orders.job_no, publications.name, publications.club_id, orders.status, orders.adrep_id, orders.rush, 
    					                        orders.question, orders.help_desk, orders.group_id, time_zone.priority AS time_zone_priority
    					                        FROM `orders`
    						                    LEFT JOIN `publications` on publications.id = orders.publication_id
    						                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    						                    WHERE orders.order_type_id = '6' AND publications.club_id IN $club_id AND (orders.created_on BETWEEN '$ysterday $ystday_time' AND '$current_date $today_time') 
    						                    AND orders.crequest!='1' AND orders.cancel!='1'";
    				}elseif($ct >= '08:30:00' && $ct <= '23:59:59'){
    					$all_orders_query = "SELECT orders.id, orders.order_type_id, orders.created_on, orders.job_no, publications.name, publications.club_id, orders.status, orders.adrep_id, orders.rush, 
    					                        orders.question, orders.help_desk, orders.group_id, time_zone.priority AS time_zone_priority
    					                        FROM `orders`
    						                    LEFT JOIN `publications` on publications.id = orders.publication_id
    						                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    						                    WHERE orders.order_type_id = '6' AND publications.club_id IN $club_id AND (orders.created_on BETWEEN '$current_date $today_time' AND '$tomo $tomo_time') 
    						                    AND orders.crequest!='1' AND orders.cancel!='1'";	
    				}
    			//echo 	$all_orders_query;
    			$data['AllQ']	 	= 	$this->db->query($all_orders_query)->result_array();
    		}elseif($display_type == 'question_sent'){
    		    $question_sent_query = $query." WHERE orders.order_type_id = '6' AND orders.club_id IN $club_id 
    				                                AND orders.crequest != '1' AND orders.question = '1'";
    			$data['question_sent'] 		= 	$this->db->query($question_sent_query)->result_array();   
    		}			
    		
			$data['dId'] = $dId;
			$data['display_type'] = $display_type;
			$data['designers'] = $designers; 
			$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `d_id` = '$dId' ")->result_array();			
			$this->load->view('new_designer/pagination_orders', $data);
		}else{
		    $this->session->set_flashdata("message","No Publication Assigned..!! Contact Acharya or Jeevan regarding the issue..!! Also check for Club and Category level assignment.");
		    redirect('new_designer/home');
		}
    }
    
    public function page_design_upload($page_design_id)
    {
        $page_design = $this->db->query("SELECT `id`, `pdf` FROM `page_design` WHERE `id` = $page_design_id")->row_array();   
        if(isset($page_design['id'])){
            //List files
            $page_design_pdf = $page_design['pdf'];
            if (file_exists($page_design_pdf)){
                $data['page_design_pdf'] = $page_design_pdf;    
            }
        
            if (isset($_FILES['file']['tmp_name']) && isset($_FILES['file']['name'])){        // file upload if is it file
                $name = $_FILES['file']['name'];
                $temp_name = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
                $expensions = array("pdf");
                if(in_array($file_ext,$expensions)=== false){
                   $errors[] = "Extension not allowed, Please choose a PDF file.";
                }
                if(empty($errors)==true){
                    $full_path = "page_sourcefile/".$page_design_id.'/v1';
                    if(file_exists($full_path)){ 
                        //remove exisiting files from the folder
                        $files = glob($full_path.'/*'); // get all file names
                        foreach($files as $file){ // iterate files
                          if(is_file($file)) {
                            unlink($file); // delete file
                          }
                        }
                    }else{
                        $path = "page_sourcefile/".$page_design_id;
                        if(@mkdir($path,0777)){}
                       
                        if(@mkdir($full_path,0777)){}
                    }
                    $filepath = $full_path.'/'.$name;   
                    if(move_uploaded_file($temp_name, $filepath)){
                        $pdf = array('pdf' => $filepath);    //only store the path of the file
                        $this->db->where('id', $page_design_id);
                        $this->db->update('page_design', $pdf);
                    }else{
                        echo"error - ". $name;
                    } 
                }else{
                    print_r($errors);
                } 
            }else{
                $data['page_design'] = $page_design; 
                $this->load->view('new_designer/page_design_upload', $data); 
            }
        }
    }
    
    public function page_section_upload($section_id)
    {
        $page_design_section = $this->db->query("SELECT `id`, `page_design_id`, `pdf_file` FROM `page_design_section` WHERE `id` = $section_id")->row_array();   
        if(isset($page_design_section['id'])){
            $page_design_id = $page_design_section['page_design_id'];
            //List files
            $page_section_pdf = $page_design_section['pdf_file'];
            if (file_exists($page_section_pdf)){
                $data['page_section_pdf'] = $page_section_pdf;    
            }
        
            if (isset($_FILES['file']['tmp_name']) && isset($_FILES['file']['name'])){        // file upload if is it file
                $name = $_FILES['file']['name'];
                $temp_name = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
                $expensions = array("pdf");
                if(in_array($file_ext,$expensions)=== false){
                   $errors[] = "Extension not allowed, Please choose a PDF file.";
                }
                if(empty($errors)==true){
                    $full_path = "page_sourcefile/".$page_design_id.'/v1/'.$section_id;
                    if(file_exists($full_path)){ 
                        //remove exisiting files from the folder
                        $files = glob($full_path.'/*'); // get all file names
                        foreach($files as $file){ // iterate files
                          if(is_file($file)) {
                            unlink($file); // delete file
                          }
                        }
                    }else{
                        $path = "page_sourcefile/".$page_design_id;
                        if(@mkdir($path,0777)){}
                        
                        $path_v = $path.'/v1';
                        if(@mkdir($path,0777)){}
                        
                        if(@mkdir($full_path,0777)){}
                    }
                    $filepath = $full_path.'/'.$name;   
                    if(move_uploaded_file($temp_name, $filepath)){
                        $pdf = array('pdf_file' => $filepath);    //only store the path of the file
                        $this->db->where('id', $section_id);
                        $this->db->update('page_design_section', $pdf);
                    }else{
                        echo"error - ". $name;
                    } 
                }else{
                    print_r($errors);
                } 
            }else{
                $data['page_design_section'] = $page_design_section; 
                $this->load->view('new_designer/page_section_upload', $data); 
            }
        }
    }
    
	function page_index($num = '1')
	{
        $rowsPerPage = 10; //each page 10 row
        $offset = ($num - 1) * $rowsPerPage; //num - 1 is page 1
		$page ="SELECT * FROM `page_design` WHERE `status` != '0'";
        if(isset($_GET['search'])){
            $search_id = $_GET['search_id'];
            if (isset($search_id) && !empty($search_id)){
                $page.=" AND `id` = '$search_id'";
            }
        }
        if(isset($_GET['advance_search'])){
            $advance_search_id = $_GET['advance_search_id'];
            if(isset($advance_search_id) && !empty($advance_search_id)){
                $page.=" AND `unique_job_name` LIKE '%".$advance_search_id."%'";
            }
            $data['advance_search_id']=$advance_search_id;
        }
        $data['order_count'] = $this->db->query("$page")->num_rows(); //$query give the number of rows 
        $page_design = $this->db->query("$page ORDER BY `id` DESC LIMIT $offset, $rowsPerPage;")->result_array(); 
        if(isset($page_design[0]['id'])){
            $data['all'] =$page_design;
            $data['rowsPerPage'] = $rowsPerPage;
            $data['offset'] = $offset;
            $data['num'] = $num;
        }
		$this->load->view('page_designer_view/index',$data);
	}
	
	function pagedesign($num = '1')
	{
        $rowsPerPage = 10; //each page 10 row
        $offset = ($num - 1) * $rowsPerPage; //num - 1 is page 1
		$page ="SELECT * FROM `page_design` WHERE `status` != '0'";
        if(isset($_GET['search'])){
            $search_id = $_GET['search_id'];
            if(isset($search_id) && !empty($search_id)){
                $page.=" AND `id` = '$search_id'";
            }
        }
        if(isset($_GET['advance_search'])){
            $advance_search_id = $_GET['advance_search_id'];
            if(isset($advance_search_id) && !empty($advance_search_id)){
                $page.=" AND `unique_job_name` LIKE '%".$advance_search_id."%'";
            }
            $data['advance_search_id']=$advance_search_id;
        }
        $data['order_count'] = $this->db->query("$page")->num_rows(); //$query give the number of rows 
        $page_design = $this->db->query("$page ORDER BY `id` DESC LIMIT $offset, $rowsPerPage;")->result_array(); 
        if(isset($page_design[0]['id'])){
            $data['all'] = $page_design;
            $data['rowsPerPage'] = $rowsPerPage;
            $data['offset'] = $offset;
            $data['num'] = $num;
        } 
		$this->load->view('page_designer_view/index',$data);
	}
	
    function pages_details($id='')//match the page design id in pages table then list pages
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->result_array();
        $order_id = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->row_array();
        $data['all'] =$page;
        $data['order_id']=$order_id;
        $this->load->view('page_designer_view/pages_details',$data);
    }
	
    function page_start_end($id='')
    {
        date_default_timezone_set('Asia/Kolkata');
        $time = date('h:i:s');
        $data = array(
            'start_time'=>$time,
            'status'=>'3');
        $this->db->where('id',$id);
        $this->db->update('page_design',$data);
        redirect("new_designer/home/page_end/".$id);
    }
	
    function page_zip_upload($id = '')  //receive the pages id and page_design id  upload the articles
    {
        $page_design = $this->db->get_where('page_design',array('id'=>$id))->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("zip");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a zip file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$page_design['id'];
                if(@mkdir($path,0777)){}
                $path = "page_sourcefile/".$page_design['id'].'/'.'v1';
                if(@mkdir($path,0777)){}
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $zip = array('zip'=>$path);    //only store the path of the file
                    $this->db->where('id', $id);
                    $this->db->update('page_design', $zip);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
	
    function page_pdf_upload($id = '')  //receive the pages id and page_design id  upload the articles
    {
        $page_design = $this->db->get_where('page_design',array('id'=>$id))->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("pdf");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a PDF file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$page_design['id'];
                if(@mkdir($path,0777)){}
                $path = "page_sourcefile/".$page_design['id'].'/'.'v1';
                if(@mkdir($path,0777)){}
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $pdf = array('pdf'=>$name);    //only store the path of the file
                    $this->db->where('id', $id);
                    $this->db->update('page_design', $pdf);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
	
    public function page_remove_zip_file($id='')
    {
        $zipremove = $this->db->get_where('page_design',array('id' => $id))->row_array();
        if (isset($_POST['filename']) && isset($zipremove['id']))
        {
            $filename = $_POST['filename'];
            $filepath = $zipremove['zip'];
            $dirhandle = opendir($filepath);
            while ($file = readdir($dirhandle))
            {
                if ($file == readdir($filename))
                {
                    unlink($filepath.'/'.$filename);
                }
            }
        }
    }
	
    function page_end($id='')
    {
        $this->load->library('zip');
        $view_uploads = $this->db->query("SELECT * FROM `page_design` WHERE `id`= $id;")->row_array();
        $zip_view = $view_uploads['zip'];
        if ($zip_view != null && file_exists($zip_view) && $atp = opendir($zip_view)) //check the notnull exitsfile and openfile
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                { 
                    $allowedExts = array("zip");
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if(in_array($extension, $allowedExts))
                    {
                        $zipname[]=$file;
                        $data['zip_name'] = $zipname;
                    }
                }
                
            }
             closedir($atp);//dirctry $atp clocsed
        }
        
        $file_upload = $this->db->query("SELECT * FROM `page_design` WHERE `id` = $id")->row_array();
        $data['pass_id']=$file_upload;
        $page_list =$this->db->query("SELECT * FROM `pages` WHERE `pd_id`=$id;")->result_array();
        $data['list']=$page_list;
        if (isset($_POST['end']))
        {
            $IN_Production = $this->db->query("SELECT * FROM page_design WHERE page_design.id=$id AND page_design.zip is null ;")->row_array() ;
            $IN_Production1 = $this->db->query("SELECT * FROM page_design WHERE page_design.id=$id AND page_design.pdf is null ;")->row_array() ;
            if ($IN_Production || $IN_Production1){
                redirect('new_designer/home/page_start_end/'.$id);
            }else{
                date_default_timezone_set('Asia/Kolkata');
                $time = date('h:i:s');
				//copy pdf file from page_source to page_pdf folder
				$source_path = "page_sourcefile/".$file_upload['id'].'/v1/'.$file_upload['pdf'];
				$dest_path = 'page_pdf/'.$file_upload['id'];
				if (@mkdir($dest_path,0777)){}
				
				if(file_exists($source_path)){
					copy($source_path, $dest_path.'/'.$file_upload['pdf']);
				}
                $data = array(
						   'end_time'=>$time,
						   'status'=>'5');
                $this->db->where('id',$id);
                $this->db->update('page_design',$data);
				
				//send mail
				$client = $this->db->get_where('adreps',array('id' => $file_upload['user_id']))->row_array();
				
				$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client['publication_id']."'")->row_array();
				
				$design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication['design_team_id']."'")->row_array();
				
				$dataa['client'] = $client;
				$dataa['subject'] = 'New Ad: '.$id ;
				$dataa['from'] = $design_team['email_id'];
				$dataa['from_display'] = 'Design Team';
				$dataa['replyTo'] = $design_team['email_id'];
				$dataa['replyTo_display'] = 'Design Team';
				$dataa['recipient'] = $client['email_id']; 
				$dataa['fname'] = $file_upload['pdf']; 
				$dataa['temp'] = $dest_path.'/'.$file_upload['pdf']; 
				$dataa['recipient_display'] = $client['first_name'].' '.$client['last_name'];
				$this->page_test_mail($dataa);
				
                redirect('new_designer/home/page_index');
            }
        }
        $this->load->view('page_designer_view/start_end',$data);
    }
	
	public function page_test_mail($dataa) 
	{ 
		$config = array();
                $config['useragent'] = "CodeIgniter";
                $config['mailpath']  = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']  = "smtp";
                $config['smtp_host'] = "localhost";
                $config['smtp_port'] = "25";
                $config['mailtype']  = 'html';
                $config['charset']   = 'utf-8';
                $config['newline']   = "\r\n";
                $config['wordwrap']  = TRUE;

        $this->load->library('email');
		$this->email->initialize($config);
		
		$this->email->from($dataa['from'], $dataa['from_display']);
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		
		if(isset($dataa['Cc'])){
		    $this->email->bcc($dataa['Cc']);
		}else{ $this->email->bcc('itsupport@adwitads.com');  }
	   
		$this->email->subject($dataa['subject']);  
	    //$this->email->message("The High-Res version of ad is attached for your perusal. If approved you may forward this pdf to production.");
	    $this->email->message($this->load->view('pagination_emailer/revisionE-order.php', $dataa, TRUE));
	    
	    if(isset($dataa['temp'])){ $this->email->attach($dataa['temp'],$dataa['fname']); }  
		
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
		
		$this->email->send();
	}
	
	
    function view_pages($id='')//match the page design id in pages table then list pages
    {
        $page = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->result_array();
        $order_id = $this->db->query("SELECT * FROM `pages` WHERE pages.pd_id=$id;")->row_array();
        $data['all'] =$page;
        $data['order_id']=$order_id;
        $this->load->view('page_designer_view/view_pages',$data);
    }
	
    function page_revision_design($num = '1')
    {
        $rowsPerPage = 10; //each page 10 row
        $offset = ($num - 1) * $rowsPerPage; //num - 1 is page 1
        $page ="SELECT * FROM `page_revision` WHERE note is not null";
        if (isset($_GET['search'])) 
        {
            $search_id = $_GET['search_id'];
            if (isset($search_id) && !empty($search_id)) 
            {
                $page.="WHERE `id` = '$search_id'";
            }
        }
        if (isset($_GET['advance_search'])) 
        {
            $advance_search_id = $_GET['advance_search_id'];
            if (isset($advance_search_id) && !empty($advance_search_id)) 
            {
                $page.="WHERE `pd_id` = '$advance_search_id'";
            }
            $data['advance_search_id']=$advance_search_id;
        }
        $data['order_count'] = $this->db->query("$page")->num_rows(); //$query give the number of rows 
        $page_design = $this->db->query("$page ORDER BY `id` DESC LIMIT $offset, $rowsPerPage;")->result_array(); 
        if(isset($page_design[0]['id']))
        {
            $data['all'] =$page_design;
            $data['rowsPerPage'] = $rowsPerPage;
            $data['offset'] = $offset;
            $data['num'] = $num;
        }
        $this->load->view("page_designer_view/revision_design",$data);
    }
	
    function page_rev_start_end($revid = '')
    {
        $zip_view = $this->db->query("SELECT * FROM `page_revision` WHERE `id` = $revid;")->row_array();
        $zip_view = $zip_view['zip_path'];
        if ($zip_view != null && file_exists($zip_view) && $atp = opendir($zip_view))
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
				$zipname = '';
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                {
                    $allowedExts = array("zip");
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if(in_array($extension, $allowedExts))
                    $zipname[]=$file; 
                    //$zipname[]=$file;//store all article name in array
                }
                $data['zip_name'] = $zipname;// array of name will stored in articles_name
            }
             closedir($atp);
        } 
        $zip_view = $this->db->query("SELECT * FROM `page_revision` WHERE `id` = $revid;")->row_array();
        $pdf_view = "page_sourcefile/".$zip_view['pd_id'].'/'.$zip_view['revision_version'];
        if ($pdf_view != null && file_exists($pdf_view) && $atp = opendir($pdf_view))
        {
            while (($file = readdir($atp)) !== false)  //loop to read the file path then store it
            {
                if ($file == '.' || $file == '..')  //.,.. get 
                {
                    continue; // left that and continue next
                }
                if($file) // file get 
                { 
                    $allowedExts = array("pdf");
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if(in_array($extension, $allowedExts))
                    {
                        $pdfname[] = $file;
                        $data['pdf_name'] = $pdfname;
                    } 
                }
                //$data['pdf_name'] = $zipname;// array of name will stored in articles_name
            }
             closedir($atp);
        } 
        if (isset($_POST['start']))
        {
            $data1 = array('status' => '4');
            $this->db->where('id',$revid);
            $this->db->update('page_revision',$data1);
            
        }
        $order_id = $this->db->query("SELECT * FROM page_revision WHERE `id`=$revid;")->row_array();
        $data['all'] = $order_id;
        $this->load->view("page_designer_view/rev_start_end",$data);
    }
	
   function page_rev_zip_upload($id = '',$pdid='')  //receive the pages id and page_design id  upload the articles
    {
        $revision = $this->db->query("SELECT page_revision.revision_version,page_design.id,page_design.zip FROM `page_design` INNER JOIN `page_revision` ON page_revision.pd_id=page_design.id WHERE page_revision.id=$id;")->row_array();
        //$revision = $this->db->get_where('revision',array('id'=>$id))->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {

            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("zip");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$pdid;
				if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
                $path = $path.'/'.$revision['revision_version'];
                if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
				
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $zip = array('zip_path'=>$path);    //only store the path of the file
                    $this->db->where('id',$id);
                    $this->db->update('page_revision', $zip);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
	
    function page_rev_pdf_upload($id = '',$pdid='')  //receive the pages id and page_design id  upload the articles
    {
       $revision = $this->db->query("SELECT page_revision.revision_version,page_design.id,page_design.zip FROM `page_design` INNER JOIN `page_revision` ON page_revision.pd_id=page_design.id WHERE page_revision.id=$id;")->row_array();
       
        if (isset($_FILES['file']['tmp_name']))        // file upload if is it file
        {

            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            $expensions= array("pdf");
            if(in_array($file_ext,$expensions)=== false)
            {
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if(empty($errors)==true)
            {
                $path = "page_sourcefile/".$pdid;
				if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
                $path = $path.'/'.$revision['revision_version'];
                if(!file_exists($path)){
					if(@mkdir($path,0777)){}
				}
				
                $filepath = $path.'/'.$name;   
                if(move_uploaded_file($temp_name,$filepath))
                {
                    $pdf = array('pdf_path' => $name);    //only store the path of the file
                    $this->db->where('id', $id);
                    $this->db->update('page_revision', $pdf);
                }
                else
                {
                    echo"error - ". $name;
                } 
            }else
            {
                print_r($errors);
            } 
        }
    }
		
    function page_rev_end($revid='')
    {
		$rev_details = $this->db->query("SELECT * FROM `page_revision` WHERE `id`='$revid' AND `pdf_path` IS NOT NULL")->row_array();
        if (isset($_POST['end']) && isset($rev_details['id']))
        {
			$path = 'page_sourcefile/'.$rev_details['pd_id'].'/'.$rev_details['revision_version'].'/'.$rev_details['pdf_path'];
			if(file_exists($path)){
				//copy pdf file from page_source to page_pdf folder
				$source_path = $path;
				$dest_path = 'page_pdf/'.$rev_details['pd_id'];
				if(!file_exists($dest_path)){
					if (@mkdir($dest_path,0777)){}
				}
				
				if(copy($source_path, $dest_path.'/'.$rev_details['pdf_path'])){
					$data1 = array('status' => '3');
					$this->db->where('id', $revid);
					$this->db->update('page_revision', $data1);
					
					//send email notification
					$page_design = $this->db->query("SELECT * FROM `page_design` WHERE `id`= '".$rev_details['pd_id']."'")->row_array();
					if(isset($page_design['user_id'])){
					$client = $this->db->get_where('adreps',array('id' => $page_design['user_id']))->row_array();
				
					$publication = $this->db->query("Select publications.id, publications.design_team_id from publications where id='".$client['publication_id']."'")->row_array();
					
					$design_team = $this->db->query("Select design_teams.id, design_teams.email_id, design_teams.newad_template from design_teams where id='".$publication['design_team_id']."'")->row_array();
					
					$dataa['subject'] = 'Revision Ad: '.$rev_details['pd_id'].'-'.$rev_details['revision_version'] ;
					$dataa['from'] = $design_team['email_id'];
					$dataa['from_display'] = 'Design Team';
					$dataa['replyTo'] = $design_team['email_id'];
					$dataa['replyTo_display'] = 'Design Team';
					$dataa['recipient'] = $client['email_id']; 
					$dataa['fname'] = $rev_details['pdf_path']; 
					$dataa['temp'] = $dest_path.'/'.$rev_details['pdf_path']; 
					$dataa['recipient_display'] = $client['first_name'].' '.$client['last_name'];
					$this->page_test_mail($dataa);
					}
					
					$this->session->set_flashdata('message',$rev_details['pd_id'].' Revision Completed..');
					redirect("new_designer/home/page_revision_design");
				}else{
					$this->session->set_flashdata('message','PDF File copy error..');
					redirect("new_designer/home/page_rev_start_end/".$revid);
				}
			}else{
				$this->session->set_flashdata('message','PDF not found..');
				redirect("new_designer/home/page_rev_start_end/".$revid);
			}
        } else {
			$this->session->set_flashdata('message','PDF File Missing..');
			redirect("new_designer/home/page_rev_start_end/".$revid);
		} 
    }
	
    function page_source($id='')
    {
        $version = $this->db->query("SELECT page_revision.revision_version,page_design.zip FROM `page_design` INNER JOIN `page_revision` ON page_revision.pd_id=page_design.id WHERE page_design.id=$id;")->row_array();
        $pdf_view =$version['zip'];
        if (file_exists($pdf_view))
        {
            $zip_path = $pdf_view.'.zip';
            $this->load->library('zip');
            $this->zip->read_dir($pdf_view.'/', true);
            if (preg_match('/\bv1\b/',$zip_path)){
            $this->zip->download('v1');
            }elseif (preg_match('/\bV1a\b/',$zip_path)) {$this->zip->download('V1a');
            }elseif (preg_match('/\bV1b\b/',$zip_path)) {$this->zip->download('V1b');
            }elseif (preg_match('/\bV1c\b/',$zip_path)) {$this->zip->download('V1c');
            }elseif (preg_match('/\bV1d\b/',$zip_path)) {$this->zip->download('V1d');
            }elseif (preg_match('/\bV1e\b/',$zip_path)) { $this->zip->download('V1e');
            }elseif (preg_match('/\bV1f\b/',$zip_path)) { $this->zip->download('V1f');
            }elseif (preg_match('/\bV1g\b/',$zip_path)) { $this->zip->download('V1g');
            }elseif (preg_match('/\bV1h\b/',$zip_path)) { $this->zip->download('V1h');
            }elseif (preg_match('/\bV1i\b/',$zip_path)) { $this->zip->download('V1i');
            }elseif (preg_match('/\bV1j\b/',$zip_path)) { $this->zip->download('V1j');
            }elseif (preg_match('/\bV1k\b/',$zip_path)) { $this->zip->download('V1k');
            }elseif (preg_match('/\bV1l\b/',$zip_path)) { $this->zip->download('V1l');
            }elseif (preg_match('/\bV1m\b/',$zip_path)) { $this->zip->download('V1m');
            }elseif (preg_match('/\bV1n\b/',$zip_path)) { $this->zip->download('V1n');
            }elseif (preg_match('/\bV1o\b/',$zip_path)) { $this->zip->download('V1o');
            }elseif (preg_match('/\bV1p\b/',$zip_path)) { $this->zip->download('V1p');
            }elseif (preg_match('/\bV1q\b/',$zip_path)) { $this->zip->download('V1q');
            }elseif (preg_match('/\bV1r\b/',$zip_path)) { $this->zip->download('V1r');
            }elseif (preg_match('/\bV1s\b/',$zip_path)) { $this->zip->download('V1s');
            }elseif (preg_match('/\bV1t\b/',$zip_path)) { $this->zip->download('V1t');
            }elseif (preg_match('/\bV1u\b/',$zip_path)) { $this->zip->download('V1u');
            }elseif (preg_match('/\bV1v\b/',$zip_path)) { $this->zip->download('V1v');
            }elseif (preg_match('/\bV1w\b/',$zip_path)) { $this->zip->download('V1w');
            }elseif (preg_match('/\bV1x\b/',$zip_path)) { $this->zip->download('V1x');
            }elseif (preg_match('/\bV1y\b/',$zip_path)) { $this->zip->download('V1y');
            }elseif (preg_match('/\bV1z\b/',$zip_path)) { $this->zip->download('V1z');
            }else{echo"error - ". $zip_path;}
            
        }
    }
	
    public function page_pdf($id='')
    {
        $query = $this->db->query("SELECT * FROM page_design WHERE `id`=$id;")->row_array();
        $filename = $query['pdf'];
        $path = "page_sourcefile/".$query['id'].'/v1/'.$filename;
        if (file_exists($path)){
            header("Content-type: application/pdf");
            header('Content-Disposition: inline;filename="'.$filename.'"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($path);
        }else{
          echo"error - ". $filename;
        }
    }

/*page design end */

    public function order_form_details($id)
	{
		$order_details = $this->db->query("SELECT * FROM `orders` WHERE `id` = '$id' ")->result_array();
		if(isset($order_details[0]['id'])){
			$data['order'] = $order_details;
			$data['client'] = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->row_array();
			$data['publications'] = $this->db->get_where('publications',array('id' => $order_details[0]['publication_id']))->row_array();
			$this->load->view('new_designer/order_form_details',$data);
		}
	}
	
	public function revision_review_report()
	{
	    $dId = $this->session->userdata('dId');
	    $query = "SELECT order_revision_review.*, adreps.first_name, adreps.last_name, publications.name FROM `order_revision_review`
	                JOIN orders ON orders.id = order_revision_review.order_id
	                JOIN adreps ON orders.adrep_id = adreps.id
	                JOIN publications ON orders.publication_id = publications.id
	                WHERE order_revision_review.designer_id = '$dId' AND order_revision_review.designer_mistake = 'yes' GROUP BY order_revision_review.order_id";
	    $data['order_revision_review'] = $this->db->query("$query")->result_array();
	    $this->load->view('new_designer/revision_review_report', $data);
	}
	
	public function indesign_script($order_id = '')
	{
	    $order_details = $this->db->get_where('orders', array('id' => $order_id))->row_array();
	    if(isset($order_details['id']) && $order_details['order_type_id']=='2'){
	       $width = $order_details['width'];
	       $height = $order_details['height'];
	       $note_content = json_encode($order_details['copy_content_description']);
	       $path = "indesign_script";
	       $jname = $order_details['id'];
	       //create jsx file with following content
	        $myFile = $path."/".$jname.".jsx";
	        $fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = "var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*".$width.",72*".$height."]);
                            myDocument.viewPreferences.horizontalMeasurementUnits = MeasurementUnits.inches;  
                            myDocument.viewPreferences.verticalMeasurementUnits = MeasurementUnits.inches;
                                
                            for(var j =0;j<myDocument.pages.length;j++)  
                            { 
                                
                                // gather data
                                var pageW=myDocument.documentPreferences.pageWidth;  
                                var pageH=myDocument.documentPreferences.pageHeight;  
                                
                                alert('pageH : '+pageH+ ' | pageW : '+pageW);
                            }
                            var myTextFrame = myDocument.pages.item(0).textFrames.add();
                                myTextFrame.geometricBounds = ['6p', '6p', '24p', '24p'];
                                myTextFrame.contents = ".$note_content.";";
				fwrite($fh, $stringData);
				fclose($fh); 
			//check for file and download
			$fullPath = $myFile;
            if($fullPath) {
                $fsize = filesize($fullPath);
                $path_parts = pathinfo($fullPath);
                $ext = strtolower($path_parts["extension"]);
                switch ($ext) {
                    case "jsx":
                    header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
                    header("Content-type: application/pdf"); // add here more headers for diff. extensions
                    break;
                    default;
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
                }
                if($fsize) {//checking if file size exist
                  header("Content-length: $fsize");
                }
                readfile($fullPath);
                exit;
            }
	    }
	}
	
	public function create_revision_source($rev_id = '')
	{
	    $rev_sold_jobs = $this->db->query("SELECT `order_id`, `order_no`, `new_slug` FROM rev_sold_jobs WHERE `id` = '".$rev_id."'")->row_array();
	    if(isset($rev_sold_jobs['new_slug'])){
	       $prev_version_slug = $rev_sold_jobs['order_no'];
	       $new_version_slug = $rev_sold_jobs['new_slug'];
	       
	       $prev_rev_sold_jobs = $this->db->query("SELECT `order_id`, `source_file` FROM rev_sold_jobs WHERE `new_slug` = '".$prev_version_slug."' AND `source_file` != 'none'")->row_array();
	       $cat_result = $this->db->query("SELECT `slug`, `source_path`, `ftp_source_path` FROM `cat_result` WHERE `order_no` = '".$rev_sold_jobs['order_id']."'")->row_array();
	       $source_path = $cat_result['source_path'];
	       
	       //check for previous source file
	       if(isset($prev_rev_sold_jobs['source_file'])){ 
	          $prev_source_file =  $prev_rev_sold_jobs['source_file'];
	       }else{
	           if(isset($cat_result['source_path'])){
	               $slug = $cat_result['slug'];
	               $get_sourcefile = glob($source_path.'/'.$slug.'.{indd, psd}', GLOB_BRACE);
    				foreach($get_sourcefile as $row){
    				    $prev_source_file = basename($row);
    				}
	           }else{ echo 'source path '.$source_path; }
	       }
	       
	       //check if previous source file exists
	       $full_path = $source_path.'/'.$prev_source_file;
	       if(file_exists($full_path)){
	           $ext = pathinfo($prev_source_file, PATHINFO_EXTENSION);
	           $fname = $new_version_slug.'.'.$ext;
	           
	           $this->load->library('zip');
	           $this->load->helper('directory');
	           
	           $font_path = $source_path.'/Document fonts/';
			    $links_path = $source_path.'/Links/';
			
    			$map_font = directory_map($font_path.'/');
    			$map_link = directory_map($links_path.'/');
    			if($map_font){
    				$this->zip->read_dir($font_path, FALSE);
    			}	
    			if($map_link){ 
    				$this->zip->read_dir($links_path, FALSE);
    			}
    			
               $this->zip->read_file($full_path, $fname);
               $this->zip->download($new_version_slug.'.zip');

	       }else{ echo 'file not exists '.$full_path.' END'; }
	    }else{ echo 'slug not exists'; }
	}
	
	public function create_indesign_template($order_id='')
	{
	    $order = $this->db->query("SELECT `id`, `order_type_id` FROM `orders` WHERE `id` = '".$order_id."'")->row_array();
	    if(isset($order['id'])){
    	   $cat_result = $this->db->query("SELECT `slug` FROM `cat_result` WHERE `order_no` = '".$order_id."'")->row_array();
    	    if(isset($cat_result['slug']) && $cat_result['slug'] != 'none'){
    	        $slug = $cat_result['slug'];
    	        
    	        if($order['order_type_id'] == 1){
    	           $template_path = 'template_indesign/psd_template.psd';
    	           $rename = $slug.'.psd';
    	        }else{
    	            $template_path = 'template_indesign/indesign_template.indd';
    	            $rename = $slug.'.indd';
    	        }
    	        
    	        $this->load->helper('download'); 
    	        force_download($rename, file_get_contents($template_path));
    	    }
	    }
	}
/*--------------- TeamLead Dashboard Content ------------------------------------*/	
	public function teamlead_dashboard_designer_adcount()
	{
	   $dId = $this->session->userdata('dId');
	   $adwit_team_id = $this->session->userdata('dTeamId');
	   /*$designer_detail = $this->db->query("SELECT d2.id FROM `designers` d1
                                                INNER JOIN `designers` d2 ON d1.adwit_teams_id = d2.adwit_teams_id
                                                    WHERE d1.id = 67 AND d2.designer_role != 2;")->result_array();*/
        $designer_list = "SELECT d2.id FROM `designers` d1
                                                INNER JOIN `designers` d2 ON d1.adwit_teams_id = d2.adwit_teams_id
                                                    WHERE d1.id = $dId AND d2.designer_role != 2";                                            
	   //$designer_id = $_POST['designerId'];
	   //$pro_status = $_POST['proStatus'];
	   $from_date_range = $_POST['fromDate'];
	   $to_date_range = $_POST['toDate'];
	   $data = array();
	   //teamlead designer ad volume dashboard teamlead_designer_volume_new
    	
    	//Inproduction
    	if($_POST['action'] == 'inproduction'){
    	    $qq = "SELECT COUNT(cat_result.order_no) AS adCount, CONCAT(designers.name,' (',designers.username,')') AS name, designers.id, cat_result.pro_status FROM `designers`
    		          LEFT JOIN cat_result ON designers.id = cat_result.designer 
    		            AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from_date_range' AND '$to_date_range') AND cat_result.pro_status = 1
    		                WHERE designers.adwit_teams_id = $adwit_team_id and designers.isEnabled_adwit_teams= 1 ";        
    	}elseif($_POST['action'] == 'completed'){
    	    $qq = "SELECT COUNT(cat_result.order_no) AS adCount, CONCAT(designers.name,' (',designers.username,')') AS name, designers.id, cat_result.pro_status FROM `designers`
    		          LEFT JOIN cat_result ON designers.id = cat_result.designer
    		            AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from_date_range' AND '$to_date_range') AND cat_result.pro_status != 1
    		                WHERE designers.adwit_teams_id = $adwit_team_id and designers.isEnabled_adwit_teams= 1 ";   
    	    /*$qq = "SELECT COUNT(cat_result.order_no) AS adCount, designers.name, designers.id, cat_result.pro_status
    		        FROM `teamlead_designer_volume_new`
    		          JOIN `cat_result` ON cat_result.designer = teamlead_designer_volume_new.designer_id
    		              JOIN `designers` ON designers.id = teamlead_designer_volume_new.designer_id
    		                WHERE teamlead_designer_volume_new.teamlead_designer_id = '$dId' AND cat_result.pro_status != '1' 
    		                AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from_date_range' AND '$to_date_range')";*/
    	}
    	
    	$recordsTotal = $this->db->query($qq)->num_rows();
    	//search query
        if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])){ 
           $qq .= " AND (designers.name LIKE '".$_POST["search"]["value"]."%')"; 
        }
        $qq .= " GROUP BY designers.id";
        //search query order by
        if(isset($_POST["order"])){ 
            $qq .= " ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']; 
        }else{  
            $qq .= " ORDER BY adCount DESC" ;
        } 
        
        $recordsFiltered = $this->db->query($qq)->num_rows();
        //Limit range
        if($_POST["length"] != -1){  
            $qq .= " LIMIT ".$_POST['length']." OFFSET ".$_POST['start'];  
        } 
        
    	 //echo $qq;
        $teamlead_designer_volume_new = $this->db->query($qq)->result_array();
        foreach($teamlead_designer_volume_new as $row){
            $sub_array = array();
            
            $sub_array[] = $row['name'];
            $sub_array[] = $row['adCount'];
                
            $data[] = $sub_array;
        }
            $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $recordsFiltered,  
                "data"              =>     $data  
           );  
           echo json_encode($output);
        
	}
	
	public function get_dashboard_ad_count($adwit_teams_id='')
	{
	     $dId = $this->session->userdata('dId');
	     $designer_alias = $this->db->get_where('designers',array('id' => $dId))->row_array();
	     if($adwit_teams_id == ''){
	        $adwit_teams_id = $designer_alias['adwit_teams_id'];
	     }
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
    	
		//TeamLead Ad volume Dashboard
		$adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
		$output_yst_status = '';
		if($designer_alias['designer_role'] == '2' && isset($adwit_team['category'])){
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
	 
	 public function assigned_vs_produced()
	 {
        $adwit_team_id = $this->session->userdata('dTeamId');
        $from_date_range = date("Y-m-d", strtotime($_GET['from_date'])). " 08:00:00";
        $to_date_range = date("Y-m-d", strtotime($_GET['to_date'])). " 08:00:00";
	    
	     $data = array();
	     
	    $adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_team_id."")->row_array();
	    $cat_id = explode(',', $adwit_team['category']);
		$category_level = "'" . implode ( "', '", $cat_id ) . "'";
	    //produced query
        $query_produced = "SELECT cat_result.category, count(*) AS adCount FROM `orders` 
                    JOIN cat_result ON cat_result.order_no = orders.id 
                    WHERE orders.created_on between  '$from_date_range' AND '$to_date_range' 
                    and orders.question=0 AND orders.cancel!='1'  
                    and cat_result.designer in  (select id from designers where adwit_teams_id='$adwit_team_id') GROUP BY cat_result.category;";

        //assigned query
        $query_assigned = "SELECT cat_result.category, count(*) AS adCount FROM `orders` 
                            JOIN cat_result ON cat_result.order_no = orders.id 
                            WHERE orders.created_on between  '$from_date_range' AND '$to_date_range' 
                            and orders.question=0 AND orders.cancel!='1'  
                            and orders.club_id in  (SELECT club_id FROM adwitac_weborders.adwit_teams_and_club where adwit_teams_id ='$adwit_team_id') 
                            and cat_result.category in ($category_level) GROUP BY cat_result.category;";
	   
	   $produced_ads = $this->db->query($query_produced)->result_array();
	   $assigned_ads = $this->db->query($query_assigned)->result_array();
	   $M_count_produced = 0; $N_count_produced = 0; $P_count_produced = 0; $T_count_produced = 0; $W_count_produced = 0;
	   $M_count_assigned = 0; $N_count_assigned = 0; $P_count_assigned = 0; $T_count_assigned = 0; $W_count_assigned = 0;
	   foreach($produced_ads as $row){
	       if($row['category'] == 'M') $M_count_produced = $row['adCount'];
	       elseif($row['category'] == 'N') $N_count_produced = $row['adCount'];
	       elseif($row['category'] == 'P') $P_count_produced = $row['adCount'];
	       elseif($row['category'] == 'T') $T_count_produced = $row['adCount'];
	       elseif($row['category'] == 'W') $W_count_produced = $row['adCount'];
       }
        $sub_array = array();
            
            $sub_array[] = 'Produced';
            $sub_array[] = $M_count_produced;
            $sub_array[] = $N_count_produced;
            $sub_array[] = $P_count_produced;
            $sub_array[] = $T_count_produced;
            $sub_array[] = $W_count_produced;
                
            $data[] = $sub_array;
            
        foreach($assigned_ads as $row){
	       if($row['category'] == 'M') $M_count_assigned = $row['adCount'];
	       elseif($row['category'] == 'N') $N_count_assigned = $row['adCount'];
	       elseif($row['category'] == 'P') $P_count_assigned = $row['adCount'];
	       elseif($row['category'] == 'T') $T_count_assigned = $row['adCount'];
	       elseif($row['category'] == 'W') $W_count_assigned = $row['adCount'];
        }
        $sub_array = array();
            
            $sub_array[] = 'Assigned';
            $sub_array[] = $M_count_assigned;
            $sub_array[] = $N_count_assigned;
            $sub_array[] = $P_count_assigned;
            $sub_array[] = $T_count_assigned;
            $sub_array[] = $W_count_assigned;
                
            $data[] = $sub_array;    
      
       
            $output = array(  
                "draw"              =>     intval($_GET["draw"]),  
                "recordsTotal"      =>     0,  
                "recordsFiltered"   =>     0,  
                "data"              =>     $data  
           );  
           echo json_encode($output);
	 }
	 
/*---------------END TeamLead Dashboard Content ------------------------------------*/		

	public function teamwise_ad_volume_dev()
	{
	    //$dId = $this->session->userdata('dId');
	    //$designer_detail = $this->db->query("SELECT designers.adwit_teams_id FROM `designers` WHERE designers.id = $dId")->row_array();
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
		//Today Ads Count Start
		$data['today_from_date_range'] = $from_date_range;    $data['today_to_date_range'] = $to_date_range;
		
		$adwit_teams = $this->db->query("SELECT * FROM `adwit_teams` WHERE `is_active` = 1")->result_array();
		foreach($adwit_teams as $adwit_team){
		    $sub_array = array();
		    $cat_id = explode(',', $adwit_team['category']);
			$category_level = "'" . implode ( "', '", $cat_id ) . "'";
		    $team_club_id = "SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id`=".$adwit_team['adwit_teams_id'];
		    //team name
		    $sub_array[] = $adwit_team['name'];
		    //status wise ad count
		    $sub_array[] = $this->db->query("SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                                        LEFT JOIN `order_status` ON orders.status = order_status.id
                                                         WHERE orders.status = 1
                                                         AND orders.club_id IN ($team_club_id) 
                                                            AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;")->row_array();
		    $sub_array[] = $this->db->query("SELECT COUNT(orders.id) AS ad_count, order_status.name AS statusName FROM `orders` 
                                            LEFT JOIN `order_status` ON orders.status = order_status.id
                                            JOIN cat_result ON cat_result.order_no = orders.id
                                            WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
                                                AND orders.created_on BETWEEN '$from_date_range' AND '$to_date_range' GROUP BY orders.status;")->result_array();
           //total ads                                     
            $sub_array[] = $this->db->query("SELECT COUNT(orders.id) AS total_Ads FROM `orders`
                                                JOIN cat_result ON cat_result.order_no = orders.id
    			                                    WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    			                                            AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    									                           AND orders.crequest != '1' AND orders.cancel !='1';")->row_array();
    		//pending ads							                                        
    	    $sub_array[] = $this->db->query("SELECT COUNT(orders.id) AS pending_Ads FROM `orders` 
    	                                        JOIN cat_result ON cat_result.order_no = orders.id
    			                                WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    			                                    AND (orders.status BETWEEN '1' AND '4') 
    										                          AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    										                              AND orders.pdf = 'none' AND orders.crequest != '1' AND orders.cancel != '1' ;")->row_array();
    		//sent ads								                                    
    	    $sub_array[] = $this->db->query("SELECT COUNT(orders.id) AS sent_Ads FROM `orders`
    	                                        JOIN cat_result ON cat_result.order_no = orders.id
    			                                    WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level)
    			                                        AND (orders.status BETWEEN '5' AND '7') 
    										                      AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
    										                          AND orders.crequest != '1' AND orders.cancel != '1' ;")->row_array(); 
    		//category_wise_ad_count								                          
    		$sub_array[] = $this->db->query("SELECT COUNT(orders.id) as ad_count, cat_result.category FROM `orders` 
                                                JOIN cat_result ON cat_result.order_no = orders.id
                                                WHERE orders.club_id IN ($team_club_id)
                                                         AND orders.pdf = 'none' AND (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range') 
                                                			AND cat_result.category IN ($category_level) AND orders.crequest!='1' AND orders.cancel!='1' 
                                                				GROUP by cat_result.category;")->result_array();
            if(isset($yst_from_date_range)){
            //status wise yst ads count START
        		$sub_array[] = $this->db->query("SELECT COUNT(orders.id) as ad_count, order_status.name, order_status.id FROM `orders` 
            								JOIN order_status ON order_status.id = orders.status
            								JOIN cat_result ON cat_result.order_no = orders.id
            									WHERE orders.club_id IN ($team_club_id) AND cat_result.category IN ($category_level) 
            									AND (orders.created_on BETWEEN '$yst_from_date_range' AND '$yst_to_date_range')
            									GROUP by orders.status")->result_array();
            }
    		$output[] = $sub_array;								                          
		}
		$data['output'] = $output;
        									                          
        $this->load->view("new_designer/teamwise_ad_volume_dev", $data);	                
	 }
	 
    public function teamwise_ad_volume()
    {
        $data['adwit_teams'] = $this->db->query("SELECT * FROM `adwit_teams` WHERE `is_active` = 1")->result_array();
        $this->load->view('new_designer/teamwise_ad_volume', $data);
    }
     
	public function hourly_designer_production_report()
	{
	    $data['hi'] = "hello";
	    $adwit_team_id = $this->session->userdata('dTeamId');
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
    		
    		$designer_query = '';
    		if(isset($_GET['designer_id']) && $_GET['designer_id'] != ''){
    		    $designer_id = trim($_GET['designer_id']);
    		    //$team_club_id = "SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id`=".$adwit_teams_id; 
    		    $designer_query = " AND cat_result.designer = $designer_id ";
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
                                WHERE orders.pdf_timestamp BETWEEN '$DateValue 00:00:00' AND '$DateValue 23:59:59' $designer_query
                                    GROUP BY hour( orders.pdf_timestamp ) , day( orders.pdf_timestamp ) ORDER BY orders.pdf_timestamp ASC";
                                    
                   /* $qq = "SELECT COUNT(cat_result.order_no) AS adCount, CONCAT(designers.name,' (',designers.username,')') AS name, designers.id, cat_result.pro_status FROM `designers`
    		          LEFT JOIN cat_result ON designers.id = cat_result.designer
    		            AND (CONCAT(TRIM(cat_result.ddate), ' ', TRIM(cat_result.start_time)) BETWEEN '$from_date_range' AND '$to_date_range') AND cat_result.pro_status != 1
    		                WHERE designers.adwit_teams_id = $adwit_team_id and designers.isEnabled_adwit_teams= 1 ";   
    		        */
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
	    $data['designers'] = $this->db->query("SELECT * FROM `designers` WHERE `adwit_teams_id`='$adwit_team_id' AND `isEnabled_adwit_teams` = 1 AND `is_active` = 1")->result_array();
		$this->load->view('new_designer/hourly_designer_production_report', $data);    
	}
	
	public function revision_ratio_report($version = 'V1')
	{
	    $data['version'] = $version;
	    $dId = $this->session->userdata('dId');
	    $designer_detail = $this->db->get_where('designers',array('id' => $dId))->row_array();
	    if($designer_detail['designer_role'] == 2){
	        $adwit_team_id = $designer_detail['adwit_teams_id'];
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
        		
        		$team_designers_list = $this->db->query("SELECT `id`, `name` FROM `designers` WHERE `adwit_teams_id`='$adwit_team_id' AND `isEnabled_adwit_teams` = 1 AND `is_active` = 1")->result_array();
        	    $totalDesigner = 0; $totalNewAdCount = 0; $totalRevisionAdCount = 0;
        	    foreach($team_designers_list as $team_designer){
        	        if($version == 'V1a'){
        	            $Nquery = "SELECT COUNT(rV1a.id) AS new_ad_count FROM `rev_sold_jobs` As rV1a 
        	                            WHERE  rV1a.designer='".$team_designer['id']."' AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";
        	                            
        	            $Rquery = "SELECT COUNT(rV1a.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1a 
        	                            JOIN `rev_sold_jobs` As rV1b ON rV1a.order_id = rV1b.order_id AND rV1b.version='V1b'
        	                                WHERE  rV1a.designer='".$team_designer['id']."' AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";                
        	        }elseif($version == 'V1b'){
        	            $Nquery = "SELECT COUNT(rV1b.id) AS new_ad_count FROM `rev_sold_jobs` As rV1b 
        	                            WHERE  rV1b.designer='".$team_designer['id']."' AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";
        	                            
        	            $Rquery = "SELECT COUNT(rV1b.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1b 
        	                            JOIN `rev_sold_jobs` As rV1c ON rV1b.order_id = rV1c.order_id AND rV1c.version='V1c'
        	                                WHERE  rV1b.designer='".$team_designer['id']."' AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";    
        	        }else{
            	        $Nquery = "SELECT COUNT(cat_result.order_no) AS new_ad_count FROM cat_result 
                                WHERE cat_result.designer='".$team_designer['id']."' AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
                        //echo $Nquery.'<br/>';        
                        $Rquery = "SELECT COUNT(cat_result.order_no) AS rev_ad_count FROM cat_result 
                                JOIN rev_sold_jobs ON cat_result.order_no = rev_sold_jobs.order_id AND rev_sold_jobs.version='V1a' 
                                WHERE cat_result.designer='".$team_designer['id']."' AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
        	        }        
                    $new_ad = $this->db->query($Nquery)->row_array();
                    $revision_ad = $this->db->query($Rquery)->row_array(); 
                    
                    $new_ad_count = $new_ad['new_ad_count'];
                    $rev_ad_count = $revision_ad['rev_ad_count'];
                    
                    $sub_array['name'] = strtoupper($team_designer['name']);
                    $sub_array['NewAdCount'] = $new_ad_count;
                    $sub_array['RevisionAdCount'] = $rev_ad_count;
                    if($rev_ad_count > 0) $sub_array['ratio'] = round(($rev_ad_count / $new_ad_count) * 100, 2); else $sub_array['ratio'] = '-';
                    
                    $output[] = $sub_array;
                    
                    $totalNewAdCount = $totalNewAdCount + $new_ad_count;
                    $totalRevisionAdCount = $totalRevisionAdCount + $rev_ad_count;
                    $totalDesigner++;
        	    }
        	    //Total
        	    $data['totalDesigner'] = $totalDesigner;
                $data['totalNewAdCount'] = $totalNewAdCount;
                $data['totalRevisionAdCount'] = $totalRevisionAdCount;
                if($totalRevisionAdCount > 0) $data['totalRatio'] = round(($totalRevisionAdCount / $totalNewAdCount) * 100, 2); else $data['totalRatio'] = '';
                
        	    $data['output'] = $output;
        	}
    	    
    	    $this->load->view('new_designer/revision_ratio_report', $data); 
	    }
	}
	
	public function publication_revision_ratio_report($version = 'V1') //Publication & Version wise 09Feb2023
	{
	    $dId = $this->session->userdata('dId');
	    $data['version'] = $version;
	    $totalDesigner = 0; $totalNewAdCount = 0; $totalRevisionAdCount = 0;
	    if(isset($_GET['dateRange']) && !empty($_GET['dateRange'])){
	        $designer_publication_detail = "SELECT publications.id AS publicationId FROM `designers`
                                            JOIN `adwit_teams_and_club` ON adwit_teams_and_club.adwit_teams_id = designers.adwit_teams_id
                                            JOIN `publications` ON publications.club_id IN (adwit_teams_and_club.club_id)
                                                WHERE designers.id = $dId";
    	        //$version = $_GET['version'];
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
        	            $Nquery = "SELECT publications.id AS publicationId, publications.name, COUNT(rV1a.id) AS new_ad_count FROM `rev_sold_jobs` As rV1a 
        	                        JOIN `orders` ON orders.id = rV1a.order_id
        	                        JOIN publications ON publications.id = orders.publication_id
        	                            WHERE  orders.publication_id IN ($designer_publication_detail) AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";
        	                            
        	            $Rquery = "SELECT publications.id AS publicationId, publications.name, COUNT(rV1a.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1a 
        	                            JOIN `orders` ON orders.id = rV1a.order_id
        	                            JOIN publications ON publications.id = orders.publication_id
        	                            JOIN `rev_sold_jobs` As rV1b ON rV1a.order_id = rV1b.order_id AND rV1b.version='V1b'
        	                                WHERE  orders.publication_id IN ($designer_publication_detail) AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";                
        	    }elseif($version == 'V1b'){
        	            $Nquery = "SELECT publications.id AS publicationId, publications.name, COUNT(rV1b.id) AS new_ad_count FROM `rev_sold_jobs` As rV1b 
        	                        JOIN `orders` ON orders.id = rV1b.order_id
        	                        JOIN publications ON publications.id = orders.publication_id
        	                            WHERE  orders.publication_id IN ($designer_publication_detail) AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";
        	                            
        	            $Rquery = "SELECT publications.id AS publicationId, publications.name, COUNT(rV1b.id) AS rev_ad_count FROM `rev_sold_jobs` As rV1b 
        	                            JOIN `orders` ON orders.id = rV1b.order_id
        	                            JOIN publications ON publications.id = orders.publication_id
        	                            JOIN `rev_sold_jobs` As rV1c ON rV1b.order_id = rV1c.order_id AND rV1c.version='V1c'
        	                                WHERE  orders.publication_id IN ($designer_publication_detail) AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";    
        	    }else{
            	        $Nquery = "SELECT publications.id AS publicationId, publications.name, COUNT(cat_result.order_no) AS new_ad_count FROM cat_result
            	                    JOIN publications ON publications.id = cat_result.publication_id
                                        WHERE cat_result.publication_id IN ($designer_publication_detail) AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
                        //echo $Nquery.'<br/>';        
                        $Rquery = "SELECT publications.id AS publicationId, publications.name, COUNT(cat_result.order_no) AS rev_ad_count FROM cat_result
                                    JOIN publications ON publications.id = cat_result.publication_id
                                    JOIN rev_sold_jobs ON cat_result.order_no = rev_sold_jobs.order_id AND rev_sold_jobs.version='V1a' 
                                        WHERE cat_result.publication_id IN ($designer_publication_detail) AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
        	    } 
        	    //echo $Nquery.'<br/>' ;   echo $Rquery.'<br/>' ; 
        	     $Nquery .= " Group BY publications.id Order BY publications.name ASC";
        	     $Rquery .= " Group BY publications.id Order BY publications.name ASC";
        	     
    		    $new_ad = $this->db->query($Nquery)->result_array();
                $revision_ad = $this->db->query($Rquery)->result_array(); 
            
        	$data['new_ad'] = $new_ad;
        	$data['revision_ad'] = $revision_ad;
	    }
	    $this->load->view('new_designer/publication_revision_ratio_report', $data);                    
	}
	
	public function publication_revision_ratio_report_order_list($type, $publication_id, $version, $from, $to)
	{
	    $dId = $this->session->userdata('dId');
	    
	    if($version == 'V1a'){
	        $version = 'V1a-V1b';    
        	            $Nquery = "SELECT publications.id AS publicationId, publications.name, orders.id AS order_id, orders.job_no, orders.help_desk FROM `rev_sold_jobs` As rV1a 
        	                        JOIN `orders` ON orders.id = rV1a.order_id
        	                        JOIN publications ON publications.id = orders.publication_id
        	                            WHERE  orders.publication_id = '$publication_id' AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";
        	                            
        	            $Rquery = "SELECT publications.id AS publicationId, publications.name, orders.id AS order_id, orders.job_no, orders.help_desk  FROM `rev_sold_jobs` As rV1a 
        	                            JOIN `orders` ON orders.id = rV1a.order_id
        	                            JOIN publications ON publications.id = orders.publication_id
        	                            JOIN `rev_sold_jobs` As rV1b ON rV1a.order_id = rV1b.order_id AND rV1b.version='V1b'
        	                                WHERE  orders.publication_id = '$publication_id' AND (rV1a.ddate BETWEEN '$from' AND '$to') AND rV1a.version='V1a' AND rV1a.status=5";                
        	            
        }elseif($version == 'V1b'){
            $version = 'V1b-V1c'; 
        	            $Nquery = "SELECT publications.id AS publicationId, publications.name, orders.id AS order_id, orders.job_no, orders.help_desk FROM `rev_sold_jobs` As rV1b 
        	                        JOIN `orders` ON orders.id = rV1b.order_id
        	                        JOIN publications ON publications.id = orders.publication_id
        	                            WHERE  orders.publication_id = '$publication_id' AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";
        	                            
        	            $Rquery = "SELECT publications.id AS publicationId, publications.name, orders.id AS order_id, orders.job_no, orders.help_desk FROM `rev_sold_jobs` As rV1b 
        	                            JOIN `orders` ON orders.id = rV1b.order_id
        	                            JOIN publications ON publications.id = orders.publication_id
        	                            JOIN `rev_sold_jobs` As rV1c ON rV1b.order_id = rV1c.order_id AND rV1c.version='V1c'
        	                                WHERE  orders.publication_id = '$publication_id' AND (rV1b.ddate BETWEEN '$from' AND '$to') AND rV1b.version='V1b' AND rV1b.status=5";    
        	            
        }else{
            $version = 'V1-V1a';
            	        $Nquery = "SELECT publications.id AS publicationId, publications.name, cat_result.order_no AS order_id, cat_result.job_name AS job_no, cat_result.help_desk FROM cat_result
            	                    JOIN publications ON publications.id = cat_result.publication_id
                                        WHERE cat_result.publication_id = '$publication_id' AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
                        //echo $Nquery.'<br/>';        
                        $Rquery = "SELECT publications.id AS publicationId, publications.name, cat_result.order_no AS order_id, cat_result.job_name AS job_no, cat_result.help_desk FROM cat_result
                                    JOIN publications ON publications.id = cat_result.publication_id
                                    JOIN rev_sold_jobs ON cat_result.order_no = rev_sold_jobs.order_id AND rev_sold_jobs.version='V1a' 
                                        WHERE cat_result.publication_id = '$publication_id' AND (cat_result.ddate BETWEEN '$from' AND '$to') AND cat_result.pro_status=5"; 
                        
        } 
        if($type == 'revision'){
            $order_list = $this->db->query($Rquery)->result_array();
        }else{	     
    	    $order_list = $this->db->query($Nquery)->result_array();
        }
        $data['from'] = $from;
        $data['to'] = $to;
        $data['version'] = $version;
        $data['order_list'] = $order_list;
        
	    $this->load->view('new_designer/publication_revision_ratio_report_order_list', $data);  
	}
	
	public function back_to_designer_report() // 20Feb2023
	{
	    $data['hi']='hello';
	    $dId = $this->session->userdata('dId');
	    $adwit_team_id = $this->session->userdata('dTeamId');
	    
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
    		    $team_designers_list = "SELECT `id` FROM `designers` WHERE `adwit_teams_id`='$adwit_team_id' AND `isEnabled_adwit_teams` = 1 AND `is_active` = 1";
    		    
    		    $q = "SELECT COUNT(DISTINCT production_conversation.order_id) as adCount, designers.name FROM `production_conversation` 
                        RIGHT JOIN cat_result ON cat_result.order_no = production_conversation.order_id
                        JOIN designers ON designers.id = cat_result.designer
                        WHERE cat_result.designer IN ($team_designers_list) AND production_conversation.operation IN ('QA_designer','DC_designer','tl_designer') 
                        AND production_conversation.time BETWEEN '$from 00:00:00' AND '$to 23:59:59' GROUP BY cat_result.designer ORDER BY adCount DESC;";
             
                $data['result'] = $this->db->query($q)->result_array(); 
                
	    }
	    $this->load->view('new_designer/back_to_designer_report', $data); 
	}
	
	public function cat_calc($adtype)
	{
	    if($adtype == '1'){
			$category = "P";
		}elseif($adtype == '2'){
		    $category = "M";
		}elseif($adtype == '3'){
		    $category = "N";
		}elseif($adtype == '4'){
		    $category = "T";
		}elseif($adtype == '5'){
		    $category = "W";
		}elseif($adtype == '6'){
		    $category = "G";
		}
		
		return $category;
	}
	
	public function cshift_category($order_id = 0)
	{
	    $dId = $this->session->userdata('dId');
		$orders = $this->db->query("SELECT orders.*, adreps.first_name FROM `orders` 
		                            JOIN `adreps` ON orders.adrep_id = adreps.id
		                            WHERE orders.id = '$order_id' ")->row_array();
		if(isset($orders['id'])){
    		if(isset($_POST['confirm'])){
				$cat_check = $this->db->get_where('cat_result',array('order_no' => $order_id))->row_array();
				
					$art = $_POST['artinst'];
					$adtype = $_POST['adtype'];
						
					$category = $this->cat_calc($adtype);	//cat_calc()
					
					$rush = $orders['rush']; 
					if(isset($_POST['rush']) && !empty($_POST['rush'])){ $rush = $_POST['rush']; }
				    
					$dataa = array(
								'artinstruction' => $art,
								'adtypewt' => $adtype,
								'category' => $category,
								'cat_tl_id' => $dId,
								'date' => date("Ymd"),
								'time' => date("His"),
								);
					$this->db->where('id', $cat_check['id']);
					$this->db->update('cat_result', $dataa); 
				
						//order status
						$post = array('rush' => $rush, 'status' => '2');
						$this->db->where('id', $order_id);
						$this->db->update('orders', $post); 

						//Live_tracker Updation
						$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
						if(isset($update_order['id'])){
							$tracker_data = array('category' => $category, 'status' => '2');
							$this->db->where('id', $update_order['id']);
							$this->db->update('live_orders', $tracker_data);
						}
						
						$this->session->set_flashdata('sucess_message',$order_id.' - '.$category);
				
					redirect('new_designer/home/orderview/'.$orders['help_desk'].'/'.$order_id);
			}
		
		}
			
	}
	
	public function revision_verify_report() // revision verification for TL
	{
	    $data['hi'] = "hello";
	    $adwit_team_id = $this->session->userdata('dTeamId');
	    
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
        		
		if(isset($from) && isset($to)){
		
    		$data['from'] = $from;
    		$data['to'] = $to;
            $data['date'] = $date;
    		$query= "SELECT rev_sold_jobs.id as rev_id, rev_sold_jobs.order_id, rev_sold_jobs.note as rev_note,rev_sold_jobs.version,rev_sold_jobs.verify,
    		                rev_sold_jobs.help_desk, 
    		                cat_result.category AS cat_result_category, cat_result.designer AS cat_result_designer, cat_result.version AS cat_result_version,
    		                publications.name AS publicationName
    		                FROM `rev_sold_jobs` 
    		                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
    		                JOIN `publications` ON publications.id = cat_result.publication_id
    		                WHERE  rev_sold_jobs.version !='' AND rev_sold_jobs.verify != '2' AND rev_sold_jobs.verify != '3'
    		                AND rev_sold_jobs.designer IN (SELECT `id` FROM `designers` WHERE `adwit_teams_id` = '$adwit_team_id')
    		                AND (rev_sold_jobs.date BETWEEN '$from 00:00:00' AND '$to 23:59:59') 
    		                ORDER BY rev_sold_jobs.order_id";
    		
    		$rev_orders = $this->db->query("$query")->result_array();
    	
    		if(isset($_POST['submit'])){
    			$verify_data = array('verify' => $_POST['verify']);
    			$this->db->where('id', $_POST['id']);
    			$this->db->update('rev_sold_jobs', $verify_data);
    			
    			if($_POST['verify'] == '1'){
    				$this->session->set_flashdata('message','Verifying Adwitads ID: '.$_POST['order_id']);
    				redirect('new_designer/home/revision_verify_type/'.$_POST['id'].'/'.$date.'?from='.$from.'&to='.$to.'');
    			}else{
    				$this->session->set_flashdata('message','Ignored!! Adwitads ID: '.$_POST['id']);
    				redirect('new_designer/home/revision_verify_report?dateRange='.$date.'&from='.$from.'&to='.$to.'');
    			}
    		}
    		$data['rev_orders'] = $rev_orders; //echo $query;
    	}
	    }
		$this->load->view('new_designer/revision_verify_report',$data);
	}
	
	public function revision_verify_type($id="",$date="")
	{
		$rev_id = $id; 
		$data['rev_id'] = $rev_id; 
		
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
		
		// Verification Type
		if(isset($_POST['search']))
		{
			//$aId = $this->session->userdata('aId');
			$comment = array( 
							'rev_id' => $rev_id, 
							//'admin_id' => $aId,
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
			}else{
			    $e = $this->db->error();
				$this->session->set_flashdata("message",$e['message']);
			}
		}
		
		//Ignore
		if(isset($_POST['ignore'])){
			
			$ignore_data = array('verify' => '3');
			$this->db->where('id', $_POST['rev_id']);
			$this->db->update('rev_sold_jobs', $ignore_data);
			$this->session->set_flashdata('message','Ignored!!! Adwitads ID: '.$_POST['id']);
			redirect('new_designer/home/revision_verify_report?dateRange='.$date.'&from='.$from.'&to='.$to.'');
		}
		
		$rev_sold_jobs = $this->db->query("SELECT rev_sold_jobs.id as rev_id, rev_sold_jobs.order_id, rev_sold_jobs.designer,rev_sold_jobs.QA_csr , rev_sold_jobs.note,rev_sold_jobs.version,
		rev_sold_jobs.verify,rev_sold_jobs.verification_type, rev_sold_jobs.adrep FROM `rev_sold_jobs` 
		WHERE rev_sold_jobs.id = '".$rev_id."' AND rev_sold_jobs.version !='' AND `verify` != '2'")->row_array();
		
		$data['order_id'] = $rev_sold_jobs['order_id'];
		$data['version'] = $rev_sold_jobs['version'];
		$data['note'] = $rev_sold_jobs['note'];
		$data['verify'] = $rev_sold_jobs['verify'];
		
		if(isset($rev_sold_jobs) && $rev_sold_jobs['version'] == 'V1a'){
			
			$cat_result = $this->db->query("SELECT cat_result.id AS cat_id,cat_result.order_no,cat_result.designer ,cat_result.tl_id , cat_result.csr_QA ,cat_result.version, cat_result.publication_id, cat_result.adrep FROM `cat_result` WHERE cat_result.order_no = '".$rev_sold_jobs['order_id']."'")->row_array(); 
			$data['cat_result'] = $cat_result;
			
			$data['publication_name'] = $this->db->query("SELECT `id`, `name` FROM `publications` WHERE `id` = '".$cat_result['publication_id']."'")->row_array();
			
			$data['adrep_name'] =  $this->db->query("SELECT `id`, `first_name`,`last_name` FROM `adreps` WHERE `id` = '".$rev_sold_jobs['adrep']."'")->row_array();

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
    			
    			$msg =  $this->load->view('new_designer/error_mail',$data,TRUE);
    			
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
					redirect('new_designer/home/revision_verify_report?dateRange='.$date.'&from='.$from.'&to='.$to.'');	
			    }else{
					$e = $this->db->error();
					$this->session->set_flashdata("message",$e['message']);
					redirect('new_designer/home/revision_verify_report?dateRange='.$date.'&from='.$from.'&to='.$to.'');
			    }
	        }
	        redirect('new_designer/home/revision_verify_report?dateRange='.$date.'&from='.$from.'&to='.$to.'');
    	}
		$this->load->view('new_designer/revision_verify_type',$data);
	} 
	
	public function Ogden_create_xml_proofReady($type='', $order_id = '') //For ftp xml ads Ogden publication
	{
        $this->load->dbutil();
        $order_detail = $this->db->query("SELECT orders.id, orders.order_type_id, orders.job_no, cat_result.slug, cat_result.source_path FROM `orders` 
                                            JOIN `cat_result` ON cat_result.order_no = orders.id
                                            WHERE orders.id = '$order_id'")->row_array();
        if(isset($order_detail['id'])){
            if($type == 'revision'){
                $outgoing_path = 'Ogden_ftp_xml/revision_out';
                $rev_sold_jobs = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' AND `status` = '5' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
                $new_slug = $rev_sold_jobs['new_slug'];
                $q = 'SELECT rev_sold_jobs.order_id AS orderId, note_sent.note AS notes, CONCAT("https://adwitads.com/weborders/",rev_sold_jobs.pdf_path) AS pdf, 
                    CONCAT("https://adwitads.com/weborders/", cat_result.source_path, "/", rev_sold_jobs.new_slug,".zip") AS package FROM `rev_sold_jobs` 
                                        LEFT JOIN `note_sent` ON note_sent.revision_id = rev_sold_jobs.id
                                        LEFT JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                                        WHERE rev_sold_jobs.id = "'.$rev_sold_jobs['id'].'"';   
            }else{
                $outgoing_path = 'Ogden_ftp_xml/Outgoing';
                $new_slug = $order_detail['slug']; 
                $q = 'SELECT orders.id AS orderId, note_sent.note AS notes, CONCAT("https://adwitads.com/weborders/",orders.pdf) AS pdf, 
                    CONCAT("https://adwitads.com/weborders/", cat_result.source_path, "/", cat_result.slug,".zip") AS package FROM `orders` 
                                        LEFT JOIN `note_sent` ON note_sent.order_id = orders.id
                                        LEFT JOIN `cat_result` ON cat_result.order_no = orders.id
                                        WHERE orders.id = "'.$order_id.'"';
            }
            
			$SourceFilePath = $order_detail['source_path'];
            $zip_file = $SourceFilePath.'/'.$new_slug.'.zip';
            
            if($order_detail['order_type_id'] == 1 && file_exists($zip_file)){ //web multiple size ad
                $source_zip =  $zip_file;   
            }else{
                //zip source start
                $this->load->library('zip');
    			$this->load->helper('directory');
    			
    			$font_path = $SourceFilePath.'/Document fonts/';
    			$links_path = $SourceFilePath.'/Links/';
    			
    			$this->load->helper('directory');	
    			
    			$map = glob($SourceFilePath.'/'.$new_slug.'.{indd,psd}',GLOB_BRACE);
    			if($map){ foreach($map as $row_src){
    				$src_path = $row_src;
    			} } 
    			
    			$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
    			if($map){ foreach($map as $row_pdf){
    				$pdf_path = $row_pdf;
    			} } 
    			
    			$this->zip->read_file($src_path, FALSE);
    			$this->zip->read_file($pdf_path, FALSE);
    			
    			$map_font = directory_map($font_path.'/');
    			$map_link = directory_map($links_path.'/');
    			if($map_font){
    				$this->zip->read_dir($font_path, FALSE);
    			}	
    			if($map_link){
    				$this->zip->read_dir($links_path, FALSE);
    			}
    			
    			$this->zip->archive($zip_file);
    			$this->zip->clear_data();
    			//zip source END
            }
            
            $data = $this->db->query($q);
            $config = array (
                    'root'    => 'Ads',
                    'element' => 'Ad',
                    'newline' => "\n",
                    'tab'     => "\t"
             );
             $xml = $this->dbutil->xml_from_result($data, $config);
             $this->load->helper('file');
             $xmlFileName = $order_detail['job_no'].'.xml';
             write_file($outgoing_path.'/'.$xmlFileName, '<?xml version="1.0" ?>'.PHP_EOL);
             write_file($outgoing_path.'/'.$xmlFileName, $xml, 'a');
              //$this->output->set_content_type('text/xml');
              //$this->output->set_output($xml); 
            if($type == 'revision'){
                $this->Ogden_ftp_connect_post('revision', $xmlFileName);
            }
	    }
	}
	
	public function Ogden_ftp_connect_post($action = '', $fileName = '') //To UPLOAD XML file to FTP 
	{
	    if($action == 'question'){
	      $ftp_folder = "adwit_question" ;
	      $local_path = "Ogden_ftp_xml/question";
	      $entry = $fileName;
	    }elseif($action == 'revision'){
	      $ftp_folder = "revision_out" ;
	      $local_path = "Ogden_ftp_xml/revision_out";
	      $entry = $fileName;  
	    }
	    define('FTP_URL', 'ftp.oweb.net');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'Aw-1013');
        define('FTP_DIRECTORY', './'.$ftp_folder);
        
        //Connect to FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        /*if ($handle = opendir($local_path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {*/
                    if(ftp_put($ftp, FTP_DIRECTORY.'/'.$entry, $local_path.'/'.$entry, FTP_BINARY)) {
                        //echo "SUCCESS";
                        unlink($local_path.'/'.$entry); //Delete local entry
                    }else{
                        echo "There was a problem while uploading FTP - $file\n"; exit; //return false;//
                    }
               /* }
            }
        
            closedir($handle);
        } */  
        
        ftp_close($ftp);
	}
	
	public function unset_new_upload_pending_session(){
	    unset($_SESSION['new_upload_pending_order']);
        unset($_SESSION['new_upload_pending_search_val']);
        unset($_SESSION['u_order_by']);
	    unset($_SESSION['u_sort_by']);
	}
	
	public function unset_new_design_pending_session(){
        unset($_SESSION['new_design_pending_order']);
        unset($_SESSION['new_design_pending_search_val']);
        unset($_SESSION['order_by']);
	    unset($_SESSION['sort_by']);
    }
    public function unset_design_pending_session(){
	    unset($_SESSION['pending_no_of_orders']);
	    unset($_SESSION['pending_search_val']);
	    unset($_SESSION['d_order_by']);
	    unset($_SESSION['d_sort_by']);
	}

	public function unset_udesign_pending_session(){
        unset($_SESSION['upending_no_of_orders']);
        unset($_SESSION['upending_search_val']);
        unset($_SESSION['wu_order_by']);
	    unset($_SESSION['wu_sort_by']);
	}
	
	public function reset_designer_rev_search(){
	    unset($_SESSION['rev_no_of_order_des']);
        unset($_SESSION['rev_search_designer_val']);
        unset($_SESSION['r_order_by']);
	    unset($_SESSION['r_sort_by']);
	}
	public function unset_all_pending_session(){
	    unset($_SESSION['new_all_pending_order']);
        unset($_SESSION['new_all_pending_search_val']);
	}

	
   public function get_pagination_config(&$config){
	    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class="page-item">';        
        $config['first_tag_close'] = '</li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="page-item">';        
        $config['prev_tag_close'] = '</li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class="page-item">';        
        $config['next_tag_close'] = '</li>';        
        $config['last_tag_open'] = '<li class="page-item">';        
        $config['last_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class="page-item">';        
        $config['num_tag_close'] = '</li>';
    }
    
    public function getDesignerRevisionAdsExcel(){
       $selected_date = $this->input->post("selected_date");
       $display_type = $this->input->post("display_type");
       $help_desk_id = $this->input->post("selected_help_desk"); 
       $dId = $this->session->userdata('dId');
       
       $help_desk_detail = $this->db->query("SELECT * FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
       $adwit_teams_id = $help_desk_detail['adwit_teams_id'];
       $adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
       //$cat_id = explode(',', !empty($adwit_team['category']));
       $cat_id = explode(',', $adwit_team['category']);
	   $category_level = "'" . implode ( "', '", $cat_id ) . "'";
	   
	   $spreadsheet = new Spreadsheet();
       $sheet = $spreadsheet->getActiveSheet();
       
       foreach (range('A', 'E') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $sheet->setCellValue('A1', "Order Id");
        $sheet->setCellValue('B1', "Type");
        $sheet->setCellValue('C1', "Previous Slug");
        $sheet->setCellValue('D1', "Designer");
        $sheet->setCellValue('E1', "Status");
        
        $sql ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                left join `designers` ON designers.id = rev_sold_jobs.designer
                WHERE cat_result.publication_id IN (SELECT `id`  FROM `publications` WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ))
                AND cat_result.category IN ($category_level)
                AND rev_sold_jobs.date = '$selected_date' AND rev_sold_jobs.job_accept = '1'";  
                
         if($display_type == 'pending'){
               $sql .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
            }elseif($display_type == 'sent'){
               $sql .= " AND rev_sold_jobs.status IN ('5','9') "; 
            }elseif($display_type == 'myQ'){ //designer and designer producrion date specific
                $sql = "SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
                    JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                    left join `designers` ON designers.id = rev_sold_jobs.designer
                    WHERE rev_sold_jobs.designer = '$dId' AND rev_sold_jobs.status IN ('3','4','7')";    
            }
                
      
        $sql .= " ORDER BY rev_sold_jobs.id ASC ";
        $rev_sold_jobs = $this->db->query($sql)->result_array();
        $x = 2;
       foreach($rev_sold_jobs as $row){ 
        $designer = $this->db->get_where('designers',array('id'=>$row['designer']))->row_array();
    	if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
    	$rev_status = $this->db->query("SELECT `name` FROM `rev_order_status` WHERE `id` = '".$row['status']."'")->row_array();
    	
    	if($row['order_type_id']=='2') {$type =  "P";} elseif($row['order_type_id']=='1'){ $type = "W";}elseif($row['order_type_id']=='6'){ $type = "P&G";} else{ $type = "P&W";}
    	if($row['new_slug']=='none') {$designer_name = "";}
        if(isset($designer['username'])){$designer_name = $designer['username'];}else{$designer_name = '';}
        if(isset($rev_status)){$status = $rev_status['name'];} else{$status = "";}   
    	$sheet->setCellValue('A' . $x, $row['order_id']);
        $sheet->setCellValue('B' . $x, $type);
        $sheet->setCellValue('C' . $x, $row['order_no']);
        $sheet->setCellValue('D' . $x, $designer_name);
        $sheet->setCellValue('E' . $x, $status);
        
        $filename = "Revision-ads-".$selected_date.".xlsx";
        // Instantiate Xlsx
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Define the filename and set the headers
       
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename );
        header('Cache-Control: max-age=0');
    
        // Save and output the Excel file
        $writer->save('php://output');
               
       }
       
       
    }
    
    public function pg_frontlinetrack_order_list($help_desk_id = '')
	{     
	    $dId = $this->session->userdata('dId');
	   $help_desk_detail = $this->db->query("SELECT id, adwit_teams_id FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'")->row_array(); 
	   if(isset($help_desk_detail['id'])){
	       $adwit_teams_id = $help_desk_detail['adwit_teams_id'];
	       $adwit_team = $this->db->query("SELECT * FROM `adwit_teams` WHERE `adwit_teams_id`=".$adwit_teams_id."")->row_array();
	       //print_r("SELECT id, adwit_teams_id FROM `help_desk` WHERE `id` = '$help_desk_id' AND `active` = '1'");exit();
	       //$cat_id = explode(',', !empty($adwit_team['category']));
            $cat_id = explode(',', $adwit_team['category']);
		    $category_level = "'" . implode ( "', '", $cat_id ) . "'";
		   if(isset($_GET['display_type'])){ $display_type = $_GET['display_type'];  }else{ $display_type = 'all'; } 
	       if(isset($_GET['date'])){ $order_date = $_GET['date'];  }else{ $order_date = $today; }
            if($this->session->userdata('publicationListTeam'.$adwit_teams_id)!== null){
                  $publicationListTeam = $this->session->userdata('publicationListTeam'.$adwit_teams_id); 
               }else{
                   $team_publication = $this->db->query("SELECT GROUP_CONCAT(`id`) AS publicationsId FROM `publications`
                                        WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' GROUP BY adwit_teams_id)")->row_array();
                  $publicationListTeam =  $team_publication['publicationsId'];
               }
    
             $query ="SELECT live_revisions.order_id,live_revisions.category,rev_sold_jobs.order_no as job_no,live_revisions.designer_id,live_revisions.status,live_revisions.id,rev_sold_jobs.new_slug,
                     rev_sold_jobs.rush,live_revisions.question,designers.username FROM live_revisions
                     left JOIN `designers` ON designers.id = live_revisions.designer_id
                     left join `rev_sold_jobs` ON rev_sold_jobs.id = live_revisions.revision_id
                     WHERE live_revisions.pub_id IN ($publicationListTeam)
                     AND live_revisions.category IN ($category_level)
                    AND rev_sold_jobs.date = '$order_date' AND rev_sold_jobs.job_accept = '1' ";
                     
             if($display_type == 'pending'){
            	$query .= " AND live_revisions.status NOT IN ('5','9') ";
             }
             elseif($display_type == 'sent'){
            	$query = " SELECT rev_sold_jobs.order_id,orders.order_type_id,rev_sold_jobs.order_no as job_no,rev_sold_jobs.designer as designer_id,rev_sold_jobs.status,rev_sold_jobs.id,rev_sold_jobs.designer,rev_sold_jobs.new_slug,rev_sold_jobs.category,
                                rev_sold_jobs.classification,rev_sold_jobs.rush,rev_sold_jobs.question,cat_result.order_type_id, designers.username FROM rev_sold_jobs
            	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
            	                left JOIN `orders` ON orders.id = rev_sold_jobs.order_id
            	                left JOIN `designers` ON designers.id = rev_sold_jobs.designer
                                WHERE cat_result.publication_id IN ($publicationListTeam)
                                AND cat_result.category IN ($category_level)
                                AND rev_sold_jobs.date = '$order_date' AND rev_sold_jobs.job_accept = '1' AND rev_sold_jobs.status IN ('5','9') "; 
             }
             elseif($display_type == 'myQ'){ //designer and designer production date specific
            	 $query = "SELECT live_revisions.order_id,live_revisions.category,live_revisions.job_no,live_revisions.designer_id,live_revisions.status,live_revisions.id,rev_sold_jobs.new_slug,
                            rev_sold_jobs.rush,live_revisions.question,designers.username FROM live_revisions
                            left JOIN `designers` ON designers.id = live_revisions.designer_id
                            LEFT JOIN `rev_sold_jobs` ON rev_sold_jobs.id = live_revisions.revision_id
                            WHERE live_revisions.designer_id = '$dId' AND live_revisions.status IN ('3','4','7')";    
            }
    
            $recordsTotal = $this->db->query($query)->num_rows();
             //search or Filter
            if(isset($_GET['search']['value']) && $_GET['search']['value'] != null){
               $query .= " AND (";
              if($display_type == 'sent'){
                   $query .= ' rev_sold_jobs.order_id LIKE "%'.$_GET["search"]["value"].'%"';
           
                  $query .= ' OR rev_sold_jobs.order_no LIKE "%'.$_GET["search"]["value"].'%"';
              }else{
                  $query .= ' live_revisions.order_id LIKE "%'.$_GET["search"]["value"].'%"';
           
                  $query .= ' OR live_revisions.job_no LIKE "%'.$_GET["search"]["value"].'%"';
              } 
            
               $query .= ") ";
            }
            
            //squery order by
                if(isset($_GET["order"])){
                    $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir'];
                }else{ 
                    if($display_type == 'sent'){
                         $query .= " ORDER BY rev_sold_jobs.id ASC" ;
                    }else{
                        $query .= " ORDER BY live_revisions.id ASC" ; 
                    }
                   
                }
               
                $recordsFiltered = $this->db->query($query)->num_rows();
                //Limit range
                if(isset($_GET["length"]) && $_GET["length"] != -1){  
                    $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
                }
                
            $i =0;
            $rev_sold_jobs = $this->db->query($query)->result_array();
            $data = array();
           foreach($rev_sold_jobs as $row){
                $i--;
            // 	if($row['classification']!='0'){ $rev_classification = $this->db->get_where('rev_classification',array('id' => $row['classification']))->row_array(); }
            	$rev_status = $this->db->query("SELECT `name` FROM `rev_order_status` WHERE `id` = '".$row['status']."'")->row_array();
            	if($display_type == 'sent'){
            	   $order_type = $this->db->get_where('orders_type', array('id' => $row['order_type_id']))->row_array(); 
            	}
              
                 $row0 ='';
                 if($row['rush']=='1'){
                     $row0 ='1';
                 }
                 // $order_no
                 $order_no ='<span ';
                 if($row['rush']=='1'){
                     $order_no .='class="font-grey-cararra"';
                 }
                 $order_no .= '> '.$row['job_no'].' </span>';
                // slug 
                $slug='';
                if($row['new_slug']=='none'){
                    if($row['category'] == 'sold'){
                        $slug = '<a href="'.base_url().index_page().'new_designer/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">
            					<input type="button" value="Upload" />
            				</a>';
                    }else{
                        if($row['question']=='1'){
                           $slug = '<button>Question Sent</button>'; 
                        }else{
                             $slug = '<form name="myform" id="create_slug_form_'.$row['order_id'].'" method="post">
                                	<button type="button" onclick="showCreateSlugModal(\''.$row['order_id'].'\')" class="btn bg-green">Create Slug</button>
                                	<input name="order_id" value="'.$row['order_id'].'" readonly style="display:none;" />
                                	<input type="text" name="create_slug" style="display:none;">
                            	</form>';

                        }
                      
                    }
                    
                }else{
                    if($row['designer_id']!='0'){
                        $slug ='<a href="'.base_url().index_page().'new_designer/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'">';
                       if(isset($row['username'])) { 
                           $slug .= $row['username'];
                           
                       }
                        $slug .= '</a>';  
                    }
                   
                }
                // status
                $status ='<a href="'.base_url().index_page().'new_designer/home/orderview/'.$help_desk_id.'/'.$row['order_id'].'" style="cursor:pointer; text-decoration: none;">';
                if(isset($rev_status)){
                    if($row['status'] == '7'){
                        $status .= '<button class="btn text-danger btn-xs">'.$rev_status['name'].'</button>';
                    }else{
                        $status .= '<button class="btn blue-sunglo btn-xs">'.$rev_status['name'].'</button>';
                    }
                    
                }
                $status .= '</a>';
                
                $sub_array = array();
                $sub_array[] = $row0;
                $sub_array[] = $row['order_id'];
                if($display_type == 'sent'){
                  $sub_array[] = '<span class="badge bg-blue">'.$order_type['icon'].'</span>';  
                }else{
                    $sub_array[] = '<span class="badge bg-blue">'.$row['category'].'</span>';
                }
                $sub_array[] = $order_no;
                $sub_array[] = $slug;
                $sub_array[] = $status;
                
                $data[] = $sub_array;
               
           }
           $output = array(  
                        "draw"              =>     intval($_GET["draw"]),  
                        "recordsTotal"      =>     $recordsTotal,  
                        "recordsFiltered"   =>     $recordsFiltered,  
                        "data"              =>     $data  
           ); 
         echo json_encode($output);  
	   }
	   
	}
	
	public function web_cshift_pagination()	{
		$dId = $this->session->userdata('dId');
		$designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array();		
		$data['dId']= $dId;
		$data['designers'] = $designers; 
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59';//$today = date('Y-m-d 23:59:59'); 
		$data['today'] = $today;
		//$order_days = $this->db->query("SELECT * FROM `web_ad_tracker_date`")->result_array();
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00';//$ystday = ($order_days[0]['date'].' 00:00:00'); 
		$data['ystday'] = $ystday;
		$data['tag_designer_teamlead'] = $this->db->query("SELECT * FROM `tag_designer_teamlead` WHERE `d_id` = '$dId' ")->result_array();

        $data['orders'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';")->result_array();//data for Pending design passing to view
		
		//Upload Pending count
		$data['upload_count'] = $this->db->query("SELECT orders.id FROM orders 
											    LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
												WHERE orders.order_type_id = '1' AND orders.cancel!='1' 
						                        AND orders.crequest!='1' AND (orders.status='3' OR orders.status='4') 
						                        AND (orders.created_on BETWEEN '$ystday' AND '$today') 
						                        AND (cat_result.pro_status = '1' OR cat_result.pro_status = '3' OR cat_result.pro_status = '6' OR cat_result.pro_status = '7')  
						                        AND cat_result.designer = '$dId' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0');")->num_rows();
		//Design Pending count
		$data['design_count'] = $this->db->query("SELECT orders.id FROM orders 
					                                LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
						                            WHERE orders.order_type_id = '1' AND orders.cancel!='1' AND orders.crequest!='1' AND orders.status='2'
							                        AND (orders.created_on BETWEEN '$ystday' AND '$today') AND cat_result.pdf_path = 'none' 
							                        AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0')")->num_rows();
		//web_design_check
		$data['orders_inproduction'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,
		orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,
		orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,
		orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,
		orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,
		orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,
		orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,
		orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders`
		join cat_result on cat_result.order_no = orders.id
		WHERE orders.order_type_id='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND  orders.status='3'  AND orders.crequest !='1' AND orders.cancel !='1' AND (cat_result.pro_status='2' OR cat_result.pro_status='8') ;")->result_array();//design check

		//web_all_pending
		$data['orders_pending'] = $this->db->query("SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4')  AND `crequest`!='1' AND `cancel`!='1';")->result_array();//All pending
		
		$this->load->view('new_designer/web_cshift_pagination',$data);
// 		$response_array =array();
// 		echo json_encode($response_array);
	}
	public function web_tab_count(){
	    $dId = $this->session->userdata('dId');
		$designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array();		
		$today = date("Y-m-d", strtotime('+1 day')).' 23:59:59';
		$ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00';
		$data['designer_role']=$designers[0]['designer_role'];
        $orders = "SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1';";//data for Pending design passing to view
		
		//Upload Pending count
		$upload_count = "SELECT orders.id FROM orders 
											    LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
												WHERE orders.order_type_id = '1' AND orders.cancel!='1' 
						                        AND orders.crequest!='1' AND (orders.status='3' OR orders.status='4') 
						                        AND (orders.created_on BETWEEN '$ystday' AND '$today') 
						                        AND (cat_result.pro_status = '1' OR cat_result.pro_status = '3' OR cat_result.pro_status = '6' OR cat_result.pro_status = '7')  
						                        AND cat_result.designer = '$dId' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0');";
		//Design Pending count
		$design_count ="SELECT orders.id FROM orders 
					                                LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
						                            WHERE orders.order_type_id = '1' AND orders.cancel!='1' AND orders.crequest!='1' AND orders.status='2'
							                        AND (orders.created_on BETWEEN '$ystday' AND '$today') AND cat_result.pdf_path = 'none' 
							                        AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0')";
		//web_design_check
		$orders_inproduction = "SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,
		orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,
		orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,
		orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,
		orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,
		orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,
		orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,
		orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders`
		join cat_result on cat_result.order_no = orders.id
		WHERE orders.order_type_id='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND  orders.status='3'  AND orders.crequest !='1' AND orders.cancel !='1' AND (cat_result.pro_status='2' OR cat_result.pro_status='8') ;";//design check

		//web_all_pending
		$orders_pending = "SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		FROM `orders` WHERE `order_type_id`='1' AND (`created_on` BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4')  AND `crequest`!='1' AND `cancel`!='1';";//All pending
	 
	    if($designers[0]['designer_role'] == '1'){ //asst TL
	        $data['upload_count']=$this->db->query($upload_count)->num_rows();
	        $data['orders']=$this->db->query($orders)->num_rows();
	        $data['orders_inproduction']=$this->db->query($orders_inproduction)->num_rows();
	        $data['orders_pending']=$this->db->query($orders_pending)->num_rows();
	    }
	    else if($designers[0]['designer_role'] == '2'){ //TL
	        $data['design_count']=$this->db->query($design_count)->num_rows();
	        $data['orders_inproduction']=$this->db->query($orders_inproduction)->num_rows();
	        $data['orders_pending']=$this->db->query($orders_pending)->num_rows(); 
	    }
	    else if($designers[0]['designer_role'] == '3'){ //Designer
	        $data['upload_count']=$this->db->query($upload_count)->num_rows();
	        $data['design_count']=$this->db->query($design_count)->num_rows();
	        
	    }
	    echo json_encode($data);
	}
	public function web_cshift_pagination_details($display_type=''){
	   $dId = $this->session->userdata('dId');
	   $designers = $this->db->query("SELECT * FROM `designers` WHERE `id`='$dId'")->result_array();		
	   $today = date("Y-m-d", strtotime('+1 day')).' 23:59:59';
	   $ystday = date("Y-m-d", strtotime('-4 day')).' 00:00:00';
	   $data =array();
	   if($display_type == "webMyQ"){ //upload_pending
	       $query = "SELECT orders.created_on,orders.order_type_id,orders.id,orders.job_no,adreps.first_name,publications.name,orders.group_id,orders.adrep_id,time_zone.priority,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.advertiser_name,
	       orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,
	       orders.with_form,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,
	       orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,
	       orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,
	       orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,
	       orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,
	       orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time
		   FROM `orders` 
		   left join `adreps` on adreps.id = orders.adrep_id
    	   left join `publications` on publications.id = orders.publication_id
    	   left join `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		   WHERE `order_type_id`='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND (`status`='3' OR `status`='4') AND `crequest`!='1' AND `cancel`!='1' ";
		
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.order_type_id LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        
        $orders_upload = $this->db->query($query)->result_array();
        $i =0;
        foreach($orders_upload  as $row){
            $format = $this->db->query("SELECT `name` FROM `web_ad_formats` WHERE id='".$row['ad_format']."'")->row_array();
            $form = $row['help_desk'];
			$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND `designer` ='".$this->session->userdata('dId')."'; ")->result_array();
		
			if($cat_result && ($cat_result[0]['pro_status']=='1' || $cat_result[0]['pro_status']=='3' || $cat_result[0]['pro_status']=='6' || $cat_result[0]['pro_status']=='7') && ($cat_result[0]['tag_designer'] == $dId || $cat_result[0]['tag_designer'] == '0'))
			{
				$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
				$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
			                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                    WHERE publications.id='".$row['publication_id']."'")->result_array();
				$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
				$status = $this->db->query("SELECT * FROM `production_status` WHERE id='".$cat_result[0]['pro_status']."'")->result_array();
				
				$created_on = strtotime($row['created_on']); $date=date('d-M', $created_on);
				//type
				$type = "";
				if($order_type[0]['value']=='print') {$type = "P";}elseif($order_type[0]['value']=='web'){$type = "W";}else{ $type ="P&W";}
				//adwit id
				$row0 = '';
				$adwitId = '<a';
                if ($row['rush'] == 1) {
                    $adwitId .= ' class="font-grey-cararra"';
                    $row0 =1;
                }
                $adwitId .= ' href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $form . '/' . $row['id'] . '\'" style="cursor:pointer; text-decoration: none;">' . $row['id'] . '</a>';
                
                //category
                $classAttribute = '';
                if ($row['question'] == '1') {
                    $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                } elseif ($row['question'] == '2') {
                    $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                }
                $categoryContent = ($cat_result) ? $cat_result[0]['category'] : 'Pending';
                $category = '<button ' . $classAttribute . 'disabled>';
                $category .= $categoryContent;
                $category .= '</button>';
                
                //design
                $design = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $form . '/' . $row['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                                <button class="btn blue-sunglo btn-xs">' . ($status ? $status[0]['name'] : '') . '</button>
                            </a>';
                if(isset($format['name'])){ $format_name = $format['name'];}else{$format_name =""; }
		        $sub_array = array();
		        $sub_array[] = $row0;
		        $sub_array[] = $date;
		        $sub_array[] = '<button type="button" class="btn blue-steel btn-sm">' . $type . '</button>';
                $sub_array[] = $adwitId;
                $sub_array[] = $row['job_no'];
                $sub_array[] = $adreps[0]['first_name'];
                $sub_array[] = $publication[0]['name'];
                $sub_array[] = $category;
                $sub_array[] = $design;
                $sub_array[] = $format_name;
                $sub_array[] = $publication[0]['time_zone_priority'];
                
                $data[] = $sub_array;
            }
            
        }
		
	   }else if($display_type == "webGeneralQ"){ //design_pending
	     $query = "SELECT orders.created_on,orders.order_type_id,orders.id,orders.job_no,adreps.first_name,publications.name,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,time_zone.priority AS time_zone_priority,orders.help_desk,orders.advertiser_name,
    	     orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,
    	     orders.with_form,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,
    	     orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,
    	     orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,
    	     orders.pickup_adno,orders.file_path,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,
    	     orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,
    	     orders.activity_time FROM `orders` 
    	     left join `adreps` on adreps.id = orders.adrep_id
    	     left join `publications` on publications.id = orders.publication_id
    	     left join `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    		WHERE `order_type_id`='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1' ";
    		
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.order_type_id LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        $orders = $this->db->query($query)->result_array();
        $i =0;
        foreach($orders  as $row1){
            $form = $row1['help_desk'];
			$order_type = 	$this->db->get_where('orders_type',array('id' => $row1['order_type_id']))->result_array();
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $row1['id']))->result_array();
			$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
			                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
			                                    WHERE publications.id='".$row1['publication_id']."'")->result_array();
// 			$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row1['adrep_id']."' ;")->result_array();
			$designer = $this->db->get_where('designers',array('id' => $cat_result[0]['designer']))->result_array();
			$format = $this->db->query("SELECT `name` FROM `web_ad_formats` WHERE id='".$row1['ad_format']."'")->row_array();
			$dteam = $this->db->get_where('publications',array('id' => $row1['publication_id']))->result_array();
			$dteam_name = $this->db->get_where('design_teams',array('id' => $dteam[0]['design_team_id']))->result_array();
			
			$created_on = strtotime($row1['created_on']); $date=date('d-M', $created_on);
			//type
			$type = "";
			if($order_type[0]['value']=='print') {$type = "P";}elseif($order_type[0]['value']=='web'){$type = "W";}else{ $type ="P&W";}
			//adwit id
			$row0 = '';
			$adwitId = '<a';
            if ($row1['rush'] == 1) {
                $adwitId .= ' class="font-grey-cararra"';
                 $row0 = '1';
            }
            $adwitId .= ' href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $form . '/' . $row1['id'] . '\'" style="cursor:pointer; text-decoration: none;">' . $row1['id'] . '</a>';
            
            //category
            $classAttribute = '';
            if ($row1['question'] == '1') {
                $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
            } elseif ($row1['question'] == '2') {
                $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
            }
            $categoryContent = ($cat_result) ? $cat_result[0]['category'] : 'Pending';
            $category = '<button ' . $classAttribute . 'disabled>';
            $category .= $categoryContent;
            $category .= '</button>';
			if(isset($format['name'])){ $format_name = $format['name'];}else{$format_name =""; }
			if($cat_result && $cat_result[0]['cancel']=='0' && $cat_result[0]['pdf_path']=='none' && ($cat_result[0]['tag_designer'] == $dId || $cat_result[0]['tag_designer'] == '0') && ($designers[0]['designer_role'] == '3') ||  $designers[0]['designer_role'] == '4') { 				
			  
		        $sub_array = array();
		        $sub_array[] = $row0;
		        $sub_array[] = $date;
		        $sub_array[] = '<button type="button" class="btn blue-steel btn-sm">' . $type . '</button>';
                $sub_array[] = $adwitId;
                $sub_array[] = $row1['job_no'];
                // $sub_array[] = $adreps[0]['first_name'];
                $sub_array[] = $publication[0]['name'];
                $sub_array[] = $category;
                // $sub_array[] = $row1['web_ad_type'];
                $sub_array[] = $dteam_name[0]['name'];
                $sub_array[] = $format_name;
                 if($designers[0]['designer_role'] != '2'){
                  $design = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $form . '/' . $row1['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                            <button  type="button" class="btn green-jungle btn-sm" >Start Design</button>
                        </a>';
                    $sub_array[] = $design; 
                   
                    
                }
                $sub_array[] = $publication[0]['time_zone_priority'];
                
                $data[] = $sub_array;
                
            }else if($designers[0]['designer_role'] == '1' || $designers[0]['designer_role'] == '2'){
                if(isset($format['name'])){ $format_name = $format['name'];}else{$format_name =""; }
                $sub_array = array();
                $sub_array[] = $row0;
		        $sub_array[] = $date;
		        $sub_array[] = '<button type="button" class="btn blue-steel btn-sm">' . $type . '</button>';
		        $sub_array[] = $adwitId;
		        $sub_array[] = $row1['job_no'];
                // $sub_array[] = $adreps[0]['first_name'];
                $sub_array[] = $publication[0]['name'];
                $sub_array[] = $category;
                $sub_array[] = $row1['web_ad_type'];
                $sub_array[] = $format_name;
                $sub_array[] = $dteam_name[0]['name'];
                if($designers[0]['designer_role'] != '2'){
                    $design = '<a href="javascript:;" onclick="window.location = \'' . base_url() . index_page() . 'new_designer/home/orderview/' . $form . '/' . $row1['id'] . '\'" style="cursor:pointer; text-decoration: none;">
                            <button  type="button" class="btn green-jungle btn-sm" >Start Design</button>
                        </a>';
                    $sub_array[] = $design; 
                    
                    
                }
                $sub_array[] = $publication[0]['time_zone_priority'];
                $data[] = $sub_array;
            }
         
			
        }  
	   }
	   else if($display_type =="webDesignCheck"){
	       $query = "SELECT orders.created_on,orders.order_type_id,orders.id,orders.job_no,adreps.first_name,publications.name,orders.group_id,orders.adrep_id,orders.map_order_id,time_zone.priority,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,
	       orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,
	       orders.with_form,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,
	       orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,
	       orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,
	       orders.pickup_adno,orders.file_path,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,
	       orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,
	       orders.activity_time FROM `orders`
	       left join `adreps` on adreps.id = orders.adrep_id
	       left join `publications` on publications.id = orders.publication_id
	       left join `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
		   WHERE `order_type_id`='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND  `status`='3'  AND `crequest`!='1' AND `cancel`!='1' ";
		   
		$recordsTotal = $this->db->query($query)->num_rows();
		//search or Filter
		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
		    $query .= " AND (";
		    
			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.order_type_id LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
			
			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
			
		    $query .= ") ";
		}
    	//squery order by
        if(isset($_GET["order"])){ 
            $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
        }
        $recordsFiltered = $this->db->query($query)->num_rows();
        //Limit range
        if(isset($_GET["length"]) && $_GET["length"] != -1){  
            $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
        }
        $orders_inproduction = $this->db->query($query)->result_array();
        $i =0;
        foreach($orders_inproduction as $row){
            $form = $row['help_desk'];
			$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."' AND (`pro_status` ='2' OR `pro_status` = '8'); ")->result_array();
 			
			foreach($cat_result as $row1)
			{
				$order_type = $this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
				$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                    WHERE publications.id='".$row['publication_id']."'")->result_array();
				$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
				$status = $this->db->get_where('production_status',array('id' => $row1['pro_status']))->result_array();				
				$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();	 
				$dteam_name = $this->db->get_where('design_teams',array('id' => $dteam[0]['design_team_id']))->result_array();
                
                $created_on = strtotime($row['created_on']); $date=date('d-M', $created_on);
                //T
                $type = "";
                if($order_type[0]['id']=='1'){$type ="W";}else if($order_type[0]['id']=='2'){$type ="P";}else if($order_type[0]['id']=='3'){$type ="P&W";}
                $row0 = '';
                //adwit id
    			$adwitId = '<a';
                if ($row['rush'] == 1) {
                    $adwitId .= ' class="font-grey-cararra"';
                    $row0 = '1';
                }
                $adwitId .= ' href="' . base_url() . index_page() . 'new_designer/home/orderview/' . $row['help_desk'] . '/' . $row['id'] . '" >' . $row['id'] . '</a>';
                 //category
                $classAttribute = '';
                if ($row['question'] == '1') {
                    $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                } elseif ($row['question'] == '2') {
                    $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                }
                $category = '<button ' . $classAttribute . 'disabled>';
                $category .=  $row1['category'];
                $category .= '</button>';
                $order_status="";
                if(isset($status[0]['name'])){
                    $order_status .= '<span class="label label-sm label-success">'.$status[0]['name'].' </span>';
                }
                
                $sub_array = array();
		        $sub_array[] = $row0;
		        $sub_array[] = $date;
		        $sub_array[] = '<span class="badge bg-blue">' . $type . '</span>';
		        $sub_array[] = $adwitId;
		        $sub_array[] = $row['job_no'];
		        $sub_array[] = $adreps[0]['first_name'];
		        $sub_array[] = $publication[0]['name'];
		        $sub_array[] = $dteam_name[0]['name'];
		        $sub_array[] = $category;
		        $sub_array[] = $order_status;
		        $sub_array[] = $publication[0]['time_zone_priority'];
                $data[] = $sub_array;
            }
            
        }
        
	   }else if($display_type =="webAllPending"){
	        $query = "SELECT orders.created_on,orders.order_type_id,orders.id,orders.job_no,adreps.first_name,publications.name,orders.group_id,orders.adrep_id,orders.map_order_id,time_zone.priority,orders.csr,orders.publication_id,orders.help_desk,orders.advertiser_name,
	        orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,
	        orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,
	        orders.copy_content_description,orders.notes,orders.spec_sold_ad,orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,
	        orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,
	        orders.pickup_adno,orders.file_path,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,
	        orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,
	        orders.activity_time FROM `orders`
	        left join `adreps` on adreps.id = orders.adrep_id
	        left join `publications` on publications.id = orders.publication_id
	        left join `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
	        WHERE `order_type_id`='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND (`status`='2' OR `status`='3' OR `status`='4')  AND `crequest`!='1' AND `cancel`!='1' ";
    		
    		$recordsTotal = $this->db->query($query)->num_rows();
    		//search or Filter
    		if(isset($_GET['search']['value'])  && $_GET['search']['value'] != null){
    		    $query .= " AND (";
    		    
    			$query .= ' orders.id LIKE "%'.$_GET["search"]["value"].'%"';

    			$query .= ' OR DATE_FORMAT(orders.created_on, \'%d-%b\') LIKE "%'.$_GET["search"]["value"].'%"';
    			
    			$query .= ' OR orders.order_type_id LIKE "%'.$_GET["search"]["value"].'%"';
    			
    			$query .= ' OR orders.job_no LIKE "%'.$_GET["search"]["value"].'%"';
    			
    			$query .= ' OR adreps.first_name LIKE "%'.$_GET["search"]["value"].'%"';
    			
    			$query .= ' OR publications.name LIKE "%'.$_GET["search"]["value"].'%"';
    			
    			$query .= ' OR time_zone.priority LIKE "%'.$_GET["search"]["value"].'%"';
    			
    		    $query .= ") ";
    		}
        	//squery order by
            if(isset($_GET["order"])){ 
                $query .= " ORDER BY ".$_GET['order']['0']['column']." ".$_GET['order']['0']['dir']; 
            }
            $recordsFiltered = $this->db->query($query)->num_rows();
            //Limit range
            if(isset($_GET["length"]) && $_GET["length"] != -1){  
                $query .= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start'];  
            }
            
            $orders_pending = $this->db->query($query)->result_array();
            $i =0;
            foreach($orders_pending as $row){
				$order_type = 	$this->db->get_where('orders_type',array('id' => $row['order_type_id']))->result_array();
				$publication = $this->db->query("SELECT publications.*, time_zone.priority AS time_zone_priority FROM `publications`
	                                    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
	                                    WHERE publications.id='".$row['publication_id']."'")->result_array();
				$adreps = $this->db->query("SELECT `first_name` FROM `adreps` WHERE `id`='".$row['adrep_id']."' ;")->result_array();
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='".$row['id']."'")->result_array();						
				if($cat_result && $cat_result[0]['pro_status']!='0'){
					$status = $this->db->get_where('production_status',array('id' => $cat_result[0]['pro_status']))->result_array();					
				}else{
					$status = 	$this->db->get_where('order_status',array('id' => $row['status']))->result_array();					
				}
				$dteam = $this->db->get_where('publications',array('id' => $row['publication_id']))->result_array();
				$dteam_name = $this->db->get_where('design_teams',array('id' => $dteam[0]['design_team_id']))->result_array();
				$design_assign = $this->db->get_where('design_assign')->result_array();	
				
				$created_on = strtotime($row['created_on']); $date=date('d-M', $created_on);
                //T
                $type = "";
                if($order_type[0]['id']=='1'){$type ="W";}else if($order_type[0]['id']=='2'){$type ="P";}else if($order_type[0]['id']=='3'){$type ="P&W";}
                
                $row0 = '';
                //adwit id
    			$adwitId = '<a';
                if ($row['rush'] == 1) {
                    $adwitId .= ' class="font-grey-cararra"';
                     $row0 = '1';
                }
                $adwitId .= ' href="' . base_url() . index_page() . 'new_designer/home/orderview/' . $row['help_desk'] . '/' . $row['id'] . '" >' . $row['id'] . '</a>';
                 //category
                $classAttribute = '';
                if ($row['question'] == '1') {
                    $classAttribute = 'class="danger" style="background:#f2dede; color:#a94442;"';
                } elseif ($row['question'] == '2') {
                    $classAttribute = 'class="success" style="background:#dff0d8; color:#3c763d;"';
                }
                $category = '<button ' . $classAttribute . ' disabled>';
                $category .=  $cat_result[0]['category'];
                $category .= '</button>';
                if(isset($status)){
                    $order_status = $status[0]['name'];
                }else{
                    $order_status = "None";
                }
                
				$sub_array = array();
		        $sub_array[] = $row0;
		        $sub_array[] = $date;
		        $sub_array[] = '<span class="badge bg-blue">' . $type . '</span>';
		        $sub_array[] = $adwitId;
		        $sub_array[] = $row['job_no'];
		        $sub_array[] = $adreps[0]['first_name'];
		        $sub_array[] = $publication[0]['name'];
		        $sub_array[] = $dteam_name[0]['name'];
		        $sub_array[] = $category;
		        $sub_array[] = $order_status;
		        $sub_array[] = $publication[0]['time_zone_priority'];
		        $data[] = $sub_array;
            }
	   }
	   
	   $output = array(  
                "draw"              =>     intval($_GET["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $recordsFiltered,  
                "data"              =>     $data  
           );  
     echo json_encode($output);

	   
	}
}	 