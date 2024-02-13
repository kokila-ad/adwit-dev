<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Home extends India_Controller {



	public function index()
	{

		$this->load->view('india/home');

	}

	public function myorders()
	{

		$this->load->library('grocery_CRUD');

		$crud = new grocery_CRUD();

		$crud->set_subject('Orders');

		$crud->set_table('india_orders');

		$crud->where('india_orders.acc_mgr_id', $this->session->userdata('iId'));

		$crud->order_by('id','desc');

		$crud->columns('order_type_id','client_name','mandatories','campaign_title','print_media_type','release_date','dead_line_date','created_on');

		$crud->set_relation('order_type_id','india_orders_type','{name}');
		
		$crud->set_relation('print_media_type','india_print_media_type','{name}');

		$crud->unset_operations();

		

		$crud->add_action('View', 'images/view.png', 'india/home/view');

		 

		$output = $crud->render();

		

		$data = array('grid' => $output, 'heading' => 'My Orders');

		$this->load->view('india/gridview',$data);	

	}

	public function view($id = 0, $email = false)
	{

		$order = $this->db->get_where('india_orders',array('id' => $id))->result_array();

		

		if(isset($order[0]['id']))

		{
			
			$order[0]['release_date'] = date("d-m-Y", strtotime($order[0]['release_date']));	

			$order[0]['dead_line_date'] = date("d-m-Y", strtotime($order[0]['dead_line_date']));	

			$type = $this->db->get_where('india_orders_type',array('id' => $order[0]['order_type_id']))->result_array();	

			$client = $this->db->get_where('india_users',array('id' => $this->session->userdata('iId')))->result_array();

            $publications = $this->db->get_where('india_bg',array('id' => $client[0]['publication_id']))->result_array();


			$data = array();
			
			$data['client'] = $client[0];

			$data['type'] = $type[0];

			$data['order'] = $order[0];

			$data['publications'] = $publications[0];

		
			if(!$email)

			{

				$this->load->view('india/vieworder',$data);

			}else

			{

				$client = $this->db->get_where('india_users',array('id' => $this->session->userdata('iId')))->result_array();

				

				$publication = $this->db->query("Select * from india_bg where id='".$client[0]['publication_id']."'")->result_array();

				

				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				

				$csr = $this->db->query("Select * from csr where id='".$publication[0]['csr_id']."'")->result_array();

				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
             				
				$data['from'] = 'do_not_reply@adwitads.com';

				$data['from_display'] = 'Order Confirmation';

				$data['replyTo'] = 'do_not_reply@adwitads.com';

				$data['replyTo_display'] = 'Order Confirmation';

				$data['subject'] = 'Order [ '.$id.' ] has been placed by '.$client[0]['first_name'].' '.$client[0]['last_name'].' from '.$publication[0]['name'];


				//Creative Group

				//$data['recipient'] = 'adwitads@gmail.com';
				
				//$data['recipient_display'] = 'Creative Group';

				//$this->send_mail2($data);


				//Ceo Email Id

				//$data['recipient'] = 'sriram@adwit.co.uk';

				//$data['recipient_display'] = 'Ceo';

				//$this->send_mail($data);


				//Creative Director Email Id

				//$data['recipient'] = 'sridhar@adwit.co.uk' ;

				//$data['recipient_display'] = 'Creative Director';

				//$this->send_mail($data);
	

				//Studio Manager Email Id

				//$data['recipient'] = 'satish@adwit.co.uk' ;

				//$data['recipient_display'] = 'Studio Manager';

				//$this->send_mail($data);
				
				//Design Team

				$data['recipient'] = $design_team[0]['email_id'];

				$data['recipient_display'] = 'Design Team';

				$this->send_mail($data);

				//CSR Email Id
/*
				$data['recipient'] = $csr[0]['email_id'];

				$data['recipient_display'] = $csr[0]['name'];

				$this->send_mail($data);
*/		
			}

		}

	}

	public function neworder($form = '')
	{		
		date_default_timezone_set(@date_default_timezone_get());
		$data['types'] = $this->db->get('india_orders_type')->result_array();


		if($form!='')

		{

			$this->load->helper('url'); 

			$this->load->helper('ckeditor');

			$data['copy_content_ckeditor'] = array(

	 

				'id' 	=> 	'copy_content_description',

				'path'	=>	'assets/grocery_crud/texteditor/ckeditor',

	 

				'config' => array(

					'toolbar' 	=> 	"Basic", 	//Using the Full toolbar

					'width' 	=> 	"95%",	//Setting a custom width

					'height' 	=> 	'130px'	//Setting a custom height

				)		

			);

			

			$data['notes_ckeditor'] = array(

	 

				'id' 	=> 	'notes',

				'path'	=>	'assets/grocery_crud/texteditor/ckeditor',

	 

				'config' => array(

					'toolbar' 	=> 	"Basic", 	//Using the Full toolbar

					'width' 	=> 	"95%",	//Setting a custom width

					'height' 	=> 	'130px'	//Setting a custom height

				)		

			);

			

			$this->load->helper(array('form', 'url'));

			$this->load->library('form_validation');

		

			$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_message('matches_pattern', 'The %s field is invalid.');

			$this->form_validation->set_rules('campaign_title', 'Campaign Title', 'trim|required');
			
			$this->form_validation->set_rules('dead_line_date', 'Dead Line Date', 'trim|required|matches_pattern[##-##-####]');
			
			$this->form_validation->set_rules('print_media_type', 'Print Media Type', 'trim');
			
			$this->form_validation->set_rules('other_print_type', 'Other Print Media Type', 'trim');

			$this->form_validation->set_rules('client_name', 'Client Name', 'trim|required|max_length[100]');
			
			$this->form_validation->set_rules('projected_ad_spent', 'Projected Ad Spent', 'trim|required');

			$this->form_validation->set_rules('no_of_agencies_competing', 'No Of Agencies Competing', 'trim');
			
			$this->form_validation->set_rules('release_date', 'Release Date', 'trim|matches_pattern[##-##-####]');
			
			$this->form_validation->set_rules('mandatories', 'Mandatories', 'trim');
			
			
			$this->form_validation->set_rules('size_cms', 'Size in cm', 'trim|required|is_numeric');
			
			$this->form_validation->set_rules('language[]', 'Language', 'trim|required');
			
			$this->form_validation->set_rules('color_preferences', 'Color Preference', 'trim');
			
			$this->form_validation->set_rules('no_of_options', 'No Of Options', 'trim|is_numeric');
			
			$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim');
			
			$this->form_validation->set_rules('images[]', 'Images', 'trim|required');
			
			$this->form_validation->set_rules('final_output_format[]', 'Final Output Format', 'trim');
			
			$this->form_validation->set_rules('target_audience', 'Target Audience', 'trim');
			
			$this->form_validation->set_rules('job_instruction', 'Job Instruction', 'trim');
			
			$this->form_validation->set_rules('one_single_line_of_text', 'One Single Line Of Text', 'trim');
			
			$this->form_validation->set_rules('what_do_we_want_them_to_do', 'What Do We Want Them To Do', 'trim');
			
			$this->form_validation->set_rules('look_feel', 'Look Feel', 'trim');
			
			$this->form_validation->set_rules('attachments_info', 'Attachments Info', 'trim');
			
			$this->form_validation->set_rules('any_other_info', 'Any Other Info', 'trim');

			

			if($form=='print-ads' || $form=='print-web-ads')

			{	

				//$this->form_validation->set_rules('spec_sold_ad', 'Spec / Sold Ad', 'trim|required');

				//$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric');

				//$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric');

				//$this->form_validation->set_rules('num_columns', 'No. of Columns', 'trim|required|is_numeric');

				//$this->form_validation->set_rules('modular_size', 'Modular Size', 'trim|required');

				$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim');

				

				//$this->form_validation->set_rules('template_used', 'Template Used', 'trim');

				//$this->form_validation->set_rules('file_name', 'File Name', 'trim|callback_fileName_check');

			}

			

			if($form=='web-ads' || $form=='print-web-ads')

			{

				//$this->form_validation->set_rules('pixel_size', 'Pixel Size', 'trim|required');

				//$this->form_validation->set_rules('web_ad_type', 'Web Ad Type', 'trim|required');

				//$this->form_validation->set_rules('ad_format', 'Ad Format', 'trim|required');

				//$this->form_validation->set_rules('maxium_file_size', 'Maximum File Size', 'trim|required|is_numeric|max_length[5]');

				//$this->form_validation->set_rules('custom_width', 'Custom Width', 'trim|is_numeric|callback_inches_check');

				//$this->form_validation->set_rules('custom_height', 'Custom Height', 'trim|is_numeric|callback_inches_check');

			}

			 $client = $this->db->get_where('india_users',array('id' => $this->session->userdata('iId')))->result_array();

             $india_bg = $this->db->get_where('india_bg',array('id' => $client[0]['publication_id']))->result_array();

			//$data=array();

			$data['india_bg'] = $india_bg[0];			

			$data['form'] = $form;
			
			$data['client'] = $client[0];

		}

		

		if ($form=='' || ($form!='' && $this->form_validation->run() == FALSE)) {

			if($form!='') $data['num_errors'] = $this->form_validation->error_count();

			$this->load->view('india/neworder',$data);

		}else{

			$order_type = $this->db->get_where('india_orders_type',array('value' => $form))->result_array();

			$_POST['acc_mgr_id'] = $this->session->userdata('iId');

			$_POST['order_type_id'] = $order_type[0]['id'];

			$_POST['release_date'] = date("Y-m-d", strtotime($_POST['release_date']));

			$_POST['dead_line_date'] = date("Y-m-d", strtotime($_POST['dead_line_date']));
			
			// convert to comma separated
			$_POST['final_output_format'] = implode(',', $_POST['final_output_format']);
			
			$_POST['images'] = implode(',', $_POST['images']);
			
			$_POST['language'] = implode(',', $_POST['language']);

			$this->db->insert('india_orders', $_POST);


			//$this->view($this->db->insert_id(), true);
			
			$id=$this->db->insert_id();
			$this->view($id, true);
			$this->folder($id);

			redirect('india/home/sendThisFile');

		}

	}

	public function folder($id = 0)
	{
		$order = $this->db->get_where('india_orders',array('id' => $id))->result_array();

	
		if(isset($order[0]['id']))

		{
			$order[0]['release_date'] = date("d-m-Y", strtotime($order[0]['release_date']));	

			$order[0]['dead_line_date'] = date("d-m-Y", strtotime($order[0]['dead_line_date']));	

			$type = $this->db->get_where('india_orders_type',array('id' => $order[0]['order_type_id']))->result_array();	

			$client = $this->db->get_where('india_users',array('id' => $this->session->userdata('iId')))->result_array();

            $publications = $this->db->get_where('india_bg',array('id' => $client[0]['publication_id']))->result_array();


			$data = array();
			
			$data['client'] = $client[0];

			$data['type'] = $type[0];

			$data['order'] = $order[0];

			$data['publications'] = $publications[0];

			
			//$data['order'] = $order[0];
			//$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $data['order']['job_no']);
			$cname = $data['order']['client_name'];
			
			$publications = $this->db->get_where('india_bg',array('id' => $client[0]['publication_id']));		
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
			//path specification
			
			$dir="india_downloads/".$bg_name;

			$dir1=$dir.'/'.$pname;

			$date=date('M-d');

			$dir2=$dir1.'/'.$id.'_'.$cname.'_'.date('d-M-Y');

			//$dir3=$dir2.'/'.$cname;
			
			//to create folders
			
			if (@mkdir($dir,0777))

			{

			}

		
			if	(@mkdir($dir1,0777))

			{

			}
			

			if (@mkdir($dir2,0777))

			{

			}


		/*	if (@mkdir($dir3,0777))

			{

			}
			//to store the form
		*/		
			$myFile = $dir2."/".$cname.".html";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = $this->load->view('i-order',$data, TRUE);
			fwrite($fh, $stringData);
			fclose($fh);
		
		}	
	}

	public function sendThisFile()
	{
		$this->load->view('india/sendThisFile');

	}

	public function fileName_check($str)
	{

		if ($this->input->post('template_used')=='1' && $str == '')

		{

			$this->form_validation->set_message('fileName_check', 'The %s field is required.');

			return FALSE;

		}

		else

		{
			return TRUE;

		}

	}

	public function inches_check($str)
	{

		if ($this->input->post('pixel_size')=='custom' && $str == '')

		{

			$this->form_validation->set_message('inches_check', 'The %s field is required.');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	public function change($error = '', $color = 'darkred')
	{

		if($error) $data['error'] = $error;

		$data['color'] = $color;

		$this->load->view('india/change',$data);

	}
	
	public function dochange()
	{

		$this->db->query("Update india_users set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('india')."' or username='".$this->session->userdata('india')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");

		if($this->db->affected_rows())

			$this->change('Your password has been changed successfully!', 'darkgreen');

		else

			$this->change('Invalid current password!', 'darkred');

	}

	public function send_mail($data) 
	{

		$this->load->library('MyMailer');

        $mail = new PHPMailer();

        $mail->SetFrom($data['from'], $data['from_display']);  

        $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);

        $mail->Subject    = $data['subject'];  

        $mail->Body      = $this->load->view('i-order',$data, TRUE);

        $mail->AltBody    = "Unable to load text!";

        $mail->AddAddress($data['recipient'], $data['recipient_display']);


        if(!$mail->Send())

            return false;

        else 

            return true;

    }

	public function send_mail2($data) 
	{
       
       $this->load->library('MyMailer');
               
       $mail = new PHPMailer();
       $mail->SetFrom($data['from'], $data['from_display']);  
       $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);
       $mail->Subject    = $data['subject'];  
       $mail->Body      = $this->load->view('i-order',$data, TRUE);
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($data['recipient'], $data['recipient_display']);

       if(!$mail->Send())
               return false;
               else
               return true;
	}
	
	public function in($error = '')
    {
        if($error) $data['error'] = $error;               
               
        $this->load->view('india/sendThisFile',$data);               
       
	}
		
	public function setfolder()
	{
		if(!isset($_POST["submit"])){

			$this->load->view('india/sendThisFile');

		}

		else 

		{

			date_default_timezone_set(@date_default_timezone_get());

			//$acc_mgr_id=$this->session->userdata('iId');

			$client = $this->db->get_where('india_users',array('id' => $this->session->userdata('iId')))->result_array();

			$india_bg = $this->db->get_where('india_bg',array('id' => $client[0]['publication_id']));

			$job = $this->db->get_where('india_orders',array('acc_mgr_id' => $this->session->userdata('iId')));

			

			foreach($job->result_array() as $row)

			{
				$id = $row['id'];
				$cname=$row['client_name'];
			//	$jname=$row['job_no'];

			}

		

			foreach($india_bg->result_array() as $row)

			{

				//echo "pid : ".$row['id'],"<br/>";

				$bg_id=$row['business_group_id'];

				$pname=$row['name'];

			}

		

			$bg=$this->db->get_where('business_groups',array('id' => $bg_id));

			

			foreach($bg->result_array() as $row)
			{

				$bg_name=$row['name'];

			}
			
			
			//make directory

			$dir="india_downloads/".$bg_name;

			$dir1=$dir.'/'.$pname;

			$date=date('M-d');

			$dir3=$dir1.'/'.$id.'_'.$cname.'_'.date('d-M-Y');

			//$dir3=$dir2.'/'.$jname;
		
			$path1= $dir3.'/'.$_FILES['ufile']['name'][0];
			$path2= $dir3.'/'.$_FILES['ufile']['name'][1];
			$path3= $dir3.'/'.$_FILES['ufile']['name'][2];
			$path4= $dir3.'/'.$_FILES['ufile']['name'][3];
			$path5= $dir3.'/'.$_FILES['ufile']['name'][4];
			
			//copy file to where you want to store file
			copy($_FILES['ufile']['tmp_name'][0], $path1);
			@copy($_FILES['ufile']['tmp_name'][1], $path2);
			@copy($_FILES['ufile']['tmp_name'][2], $path3);
			@copy($_FILES['ufile']['tmp_name'][3], $path4);
			@copy($_FILES['ufile']['tmp_name'][4], $path5);
	
			// Use this code to display the error or success.
	
			$filesize1=$_FILES['ufile']['size'][0];
			$filesize2=$_FILES['ufile']['size'][1];
			$filesize3=$_FILES['ufile']['size'][2];
			$filesize4=$_FILES['ufile']['size'][3];
			$filesize5=$_FILES['ufile']['size'][4];
			
			$file1 =  $_FILES['ufile']['name'][0];
			$file2 =  $_FILES['ufile']['name'][1];
			$file3 =  $_FILES['ufile']['name'][2];
			$file4 =  $_FILES['ufile']['name'][3];
			$file5 =  $_FILES['ufile']['name'][4];
			if($filesize1 != 0)
			{
				$data = array(
					'file1' => $file1,
					'file2' => $file2,
					'file3' => $file3,
					'file4' => $file4,
					'file5' => $file5,
					'dir3'  => $dir3
						);
				$this->load->view('india/result_view', $data);
			}else{
				$this->in('upload has encountered an error!');
                       return false;
			}
	
		}
	}
		
}