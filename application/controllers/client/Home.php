<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Client_Controller {

	public function index()
	{
		$data['hi'] = 'hello';
		$notifications = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1'")->result_array();
		if($notifications){
			$to_date = date('Y-m-d');
			foreach($notifications as $row){
				if($to_date >= $row['end_date']){
					$this->db->update('notification',array('job_status' => '0'), array('id' => $row['id']));
				}
			}
		}
		$cId = $this->session->userdata('cId');
		$client = $this->db->get_where('adreps',array('id' => $cId))->row_array();
		$notification_list = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1' AND (`adrep`='$cId' OR `publication`='".$client['publication_id']."') ORDER BY `id` DESC LIMIT 2")->result_array();
		if(isset($notification_list[0]['id'])){ $data['notification_list'] = $notification_list; }
		$this->load->view('client/home', $data);
	}

	public function myorders_grid()
	{

		$this->load->library('Grocery_CRUD');

		$crud = new grocery_CRUD();

		$crud->set_subject('Orders');

		$crud->set_table('orders');

		$crud->where('orders.adrep_id', $this->session->userdata('cId'));

		$crud->order_by('id','desc');

		$crud->columns('id','order_type_id','job_no','advertiser_name','publish_date','date_needed','created_on');

		$crud->set_relation('order_type_id','orders_type','{name}');

		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$crud->add_action('View', 'images/view.png', 'client/home/view');

		$output = $crud->render();
		
		$data = array('grid' => $output, 'heading' => 'My Orders');

		$this->load->view('client/gridview',$data);	

	}
	
	public function orders_history()
	{

		$this->load->library('Grocery_CRUD');

		$crud = new grocery_CRUD();

		$crud->set_subject('Old_orders');

		$crud->set_table('old_order_history');

		$crud->where('old_order_history.adrep_id', $this->session->userdata('cId'));

		$crud->order_by('id','desc');

		$crud->columns('Date','id','Job No','adrep_id','User Name','Advertiser Name','Publisher','Publication','Wd','Ht','Size','Cols','Ad type');

		//$crud->set_relation('order_type_id','orders_type','{name}');

		//$crud->unset_operations();

		$crud->unset_add();

		//$crud->add_action('View', 'images/view.png', 'client/home/view');

		 

		$output = $crud->render();

		

		$data = array('grid' => $output, 'heading' => 'Orders History');

		$this->load->view('client/gridview',$data);	

	}

	public function view($id = 0, $email = false)
	{

		$order = $this->db->get_where('orders',array('id' => $id))->result_array();

		

		if(isset($order[0]['id']))

		{
			$order[0]['publish_date'] = date("d-m-Y", strtotime($order[0]['publish_date']));	

			if($order[0]['date_needed'] != '0000-00-00'){
				$order[0]['date_needed'] = date("d-m-Y", strtotime($order[0]['date_needed']));
			}

			$order[0]['created_on'] = date("d-m-Y", strtotime($order[0]['created_on']));

			$order_type = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();	
			
			$ad_type = $this->db->get_where('ads_type',array('id' => $order[0]['spec_sold_ad']))->result_array();
			
			$html_type = $this->db->get_where('html_type',array('id' => $order[0]['html_type']))->result_array();

			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

            $publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();


			$data = array();
			
			$data['client'] = $client[0];

			$data['order_type'] = $order_type[0];
			
			$data['ad_type'] = $ad_type[0];
			
				if ($order_type[0]['value'] == 'html_order')
				{
					$data['html_type'] = $html_type[0];
				}

			$data['order'] = $order[0];

			$data['publications'] = $publications[0];

		
			if(!$email)

			{

				$this->load->view('client/vieworder',$data);

			}else

			{

				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

				

				$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();

				

				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				

				//$csr = $this->db->query("Select * from csr where id='".$publication[0]['csr_id']."'")->result_array();

				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				$jname=$data['order']['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
				
				//$data['from'] = 'do_not_reply@adwitads.com';
				$data['from'] = $design_team[0]['email_id'];

				//$data['from_display'] = 'Do not reply';
				$data['from_display'] = 'Design Team';

				$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo2'] = $design_team[0]['email_id'];
				
				$data['replyTo_display'] = 'Do not reply';
				$data['replyTo_display2'] = 'Reply to';

				$data['subject'] = 'Your order no. '.$data['order']['id'].' with Unique Job No. '.$jname.' from '.$publication[0]['name'].' has been received';
				//Client

				$data['recipient'] = $client[0]['email_id'];
			
				$data['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];

				$data['design_recipient'] = $design_team[0]['email_id'];
				$data['design_recipient_display'] = 'Design Team';
				$data['ad_recipient'] = $publication[0]['advertising_director_email_id'];
				$data['ad_recipient_display'] = 'Advertising Director';
				
				$this->send_mail2($data);
				/*

				//Design Team

				$data['recipient'] = $design_team[0]['email_id'];

				$data['recipient_display'] = 'Design Team';

				$this->send_mail($data);


				//Advertising Director Email Id

				$data['recipient'] = $publication[0]['advertising_director_email_id'];

				$data['recipient_display'] = 'Advertising Director';

				$this->send_mail($data);
				*/
			}

		}

	}
	
	public function neworder()	//to direct control to print_neworder fun
	{	
		if(!isset($_POST["ad_type"]))	
		{
			$data['types'] = $this->db->get('orders_type')->result_array();
			
			$this->load->view('client/neworder1',$data);
		}
		else
		{
			$ad_type=$_POST["ad_type"];
		
			redirect('client/home/'.$ad_type.'_type');
		}
		
	}
	
	public function order_form($otype = '', $atype = '', $order_num = '') //print-web-p&w-order 
	{
		
		$data['types'] = $this->db->get('orders_type')->result_array();
		
		$data['type'] = $this->db->get('ads_type')->result_array();
		
		//$data['order_no'] = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId')))->result_array();
		
		$data['order_type'] = $otype;
		
		if($atype!='')

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
			
			$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');

			$this->form_validation->set_rules('publication_name', 'Publication Name', 'trim|max_length[100]');
			
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			
			$this->form_validation->set_rules('pickup_adno', 'Ad Number', 'trim');
			
			if($otype != 'web')
			{
				$this->form_validation->set_rules('width', 'Width', 'trim|required|is_numeric|greater_than[0]');

				$this->form_validation->set_rules('height', 'Height', 'trim|required|is_numeric|greater_than[0]');
				
				$this->form_validation->set_rules('print_ad_type', 'Print Ad Type', 'trim|required');
			}
			
			if($otype != 'print')
			{	
				$this->form_validation->set_rules('pixel_size', 'Pixel Size', 'trim|required');

				$this->form_validation->set_rules('web_ad_type', 'Web Ad Type', 'trim|required');

				$this->form_validation->set_rules('ad_format', 'Ad Format', 'trim|required');

				$this->form_validation->set_rules('maxium_file_size', 'Maximum File Size', 'trim|required|is_numeric|max_length[5]');
			}
			
			$this->form_validation->set_rules('custom_width', 'Custom Width', 'trim|is_numeric|callback_inches_check');

			$this->form_validation->set_rules('custom_height', 'Custom Height', 'trim|is_numeric|callback_inches_check');
			if($atype=='pickup-ads'){
				$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim');
			}else{
				$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim|required');
			}
			$this->form_validation->set_rules('notes', 'Notes', 'trim');


			if($atype=='new-ads')
			{
			
				$this->form_validation->set_rules('publish_date', 'Publish Date', 'trim|matches_pattern[##-##-####]');

				$this->form_validation->set_rules('date_needed', 'Date Needed', 'trim|matches_pattern[##-##-####]');
			
				$this->form_validation->set_rules('job_instruction', 'Job Instruction', 'trim');

				$this->form_validation->set_rules('art_work', 'Art Work', 'trim');

				$this->form_validation->set_rules('no_fax_items', 'No Of Fax Items', 'trim|is_numeric|max_length[5]');

				$this->form_validation->set_rules('no_email_items', 'No Of Email Items', 'trim|is_numeric|max_length[5]');
				
				$this->form_validation->set_rules('with_form', 'Along With Form', 'trim|is_numeric|max_length[5]');
			
				$this->form_validation->set_rules('color_preferences', 'Color Preference', 'trim');

				$this->form_validation->set_rules('font_preferences', 'Font Preference', 'trim');
				
				$this->form_validation->set_rules('copy_content', 'Copy Content', 'trim|required');
								
				$this->form_validation->set_rules('custom_width', 'Custom Width', 'trim|is_numeric|callback_inches_check');

				$this->form_validation->set_rules('custom_height', 'Custom Height', 'trim|is_numeric|callback_inches_check');

			}
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

            $publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
						
			//if($atype=='pickup-ads' || $atype=='resize-ads' || $atype=='new-ads')
			//{
			if($order_num!=''){
				if($publications[0]['design_team_id']=='8' || $publications[0]['id']=='43')
				{
					$pick_order = $this->db->get_where('orders',array('job_no' => $order_num))->result_array(); 
				}else{
					$pick_order = $this->db->get_where('orders',array('id' => $order_num))->result_array(); 
				}
				if($pick_order){ $data['pick_order'] = $pick_order[0]; $data['order_num'] = $order_num; }
			}  
			//}
							
			if($atype=='pickup-ads' || $atype=='resize-ads')
			{
				$this->form_validation->set_rules('pickup_adno', 'Pickup Ad Number', 'trim|required');
				if($publications[0]['design_team_id']=='8' || $publications[0]['id']=='43')
				{
					$data['order_publication'] = $this->db->get_where('orders',array('publication_id' => $client[0]['publication_id']))->result_array();
				}else{
					$data['order_no'] = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId')))->result_array();
				}
			}
		
			$data['publications'] = $publications[0];			

			$data['form'] = $atype;
			
			$data['client'] = $client[0];

		}

		if ($atype=='' || ($atype!='' && $this->form_validation->run() == FALSE)) 
		{

			if($atype!='') $data['num_errors'] = $this->form_validation->error_count();

			$this->load->view('client/neworder',$data);

		}else
		{
		
			$order_type = $this->db->get_where('orders_type',array('value' => $otype))->result_array();
			
			$ads_type = $this->db->get_where('ads_type',array('value' => $atype))->result_array();

			$_POST['adrep_id'] = $this->session->userdata('cId');
			
			$_POST['publication_id'] = $publications[0]['id'];
			
			$_POST['group_id'] = $publications[0]['group_id'];
			
			$_POST['help_desk'] = $publications[0]['help_desk'];

			$_POST['order_type_id'] = $order_type[0]['id'];
			
			$_POST['spec_sold_ad'] = $ads_type[0]['id'];
			
			/*if($otype != 'web')
			{
				$_POST['width'] = round($_POST['width'],2);
				$_POST['height'] = round($_POST['height'],2);
			}*/
			
			if($client[0]['rush']=='1'){ if(empty($_POST['rush'])) $_POST['rush']='0';  }		
						
			if($atype == 'new-ads')
			{
				$_POST['publish_date'] = date("Y-m-d", strtotime($_POST['publish_date']));
				if(strtotime($_POST['publish_date']) < strtotime(date('Y-m-d')) || $_POST['publish_date']==''){
					$_POST['publish_date'] = date('Y-m-d', strtotime(' +1 day'));
					$_POST['priority'] = date('Y-m-d', strtotime('-1 day', strtotime($_POST['publish_date'])));
				}else{
					$_POST['priority'] = date('Y-m-d', strtotime('-3 day', strtotime($_POST['publish_date'])));
				}
				if(!empty($_POST['date_needed'])){
					$_POST['date_needed'] = date("Y-m-d", strtotime($_POST['date_needed']));
				}
			}

			$this->db->insert('orders', $_POST);

			
			$id=$this->db->insert_id();
			if($id){
				$this->view($id, true);
				$this->orders_folder($id);
				//$this->folder($id);
				redirect('client/home/sendThisFile');
			}else{ 
				//echo $this->db->_error_message();
				//echo "<script>alert('Internal Error: Order not placed!! Try Again..')</script>";
				$this->session->set_flashdata("message","Database Error: Order not placed!");
				redirect("client/home/order_form/$otype/$atype");
			}
		}
		
	}

	public function html_order_type($form = '') //html-order 
	{
		
		$data['types'] = $this->db->get('orders_type')->result_array();
		
		$data['type'] = $this->db->get('html_type')->result_array();
		
		$data['order_no'] = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId')))->result_array();
		
		$data['order_type'] = "html_order";
		
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
			
			$this->form_validation->set_rules('job_no', 'Job No.', 'trim|required|max_length[100]|callback_alpha_dash_space');	
			
			$this->form_validation->set_rules('pickup_adno', 'Ad Number', 'trim');
			
			$this->form_validation->set_rules('custom_width', 'custom_width', 'trim|required|is_numeric');

			$this->form_validation->set_rules('copy_content_description', 'Copy Content Description', 'trim');
		
			$this->form_validation->set_rules('notes', 'Notes', 'trim');



				if($form=='email-blast')
			{
			
				//$this->form_validation->set_rules('publish_date', 'Publish Date', 'trim|required|matches_pattern[##-##-####]');

				$this->form_validation->set_rules('date_needed', 'Date Needed', 'trim|required|matches_pattern[##-##-####]');
			
				$this->form_validation->set_rules('advertiser_name', 'Advertiser Name', 'trim|required|max_length[100]');
				
				$this->form_validation->set_rules('custom_width', 'custom_width', 'trim|required|is_numeric');
							
				$this->form_validation->set_rules('job_instruction', 'Job Instruction', 'trim|required');

				$this->form_validation->set_rules('art_work', 'Art Work', 'trim|required');

				$this->form_validation->set_rules('no_fax_items', 'No Of Fax Items', 'trim|is_numeric|max_length[5]');

				$this->form_validation->set_rules('no_email_items', 'No Of Email Items', 'trim|is_numeric|max_length[5]');
				
				$this->form_validation->set_rules('with_form', 'Along With Form', 'trim|is_numeric|max_length[5]');
			
				$this->form_validation->set_rules('color_preferences', 'Color Preference', 'trim');

				$this->form_validation->set_rules('font_preferences', 'Font Preference', 'trim');

				$this->form_validation->set_rules('custom_width', 'Custom Width', 'trim|is_numeric|callback_inches_check');

				$this->form_validation->set_rules('custom_height', 'Custom Height', 'trim|is_numeric|callback_inches_check');

			}

			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

            $publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();

			//$data=array();

			$data['publications'] = $publications[0];			

			$data['form'] = $form;
			
			$data['client'] = $client[0];

		}


		if ($form=='' || ($form!='' && $this->form_validation->run() == FALSE)) 
		{

			if($form!='') $data['num_errors'] = $this->form_validation->error_count();

			$this->load->view('client/neworder',$data);

		}else
		{
		
			$order_type = $this->db->get_where('orders_type',array('value' => 'html_order'))->result_array();
			
			$html_type = $this->db->get_where('html_type',array('value' => $form))->result_array();

			$_POST['adrep_id'] = $this->session->userdata('cId');
			
			$_POST['publication_id'] = $publications[0]['id'];
			
			$_POST['group_id'] = $publications[0]['group_id'];
			
			$_POST['help_desk'] = $publications[0]['help_desk'];

			$_POST['order_type_id'] = $order_type[0]['id'];
			
			$_POST['html_type'] = $html_type[0]['id'];
						
			if($form == 'email-blast')
			{

				$_POST['date_needed'] = date("Y-m-d", strtotime($_POST['date_needed']));
			}

			$this->db->insert('orders', $_POST);

			
			$id=$this->db->insert_id();
			if($id){
				$this->view($id, true);
				$this->orders_folder($id);
				//$this->folder($id);
				redirect('client/home/sendThisFile');
			}else{ 
				$this->session->set_flashdata("message","Internal Error: Order not placed!");
				redirect('client/home/print_type/'.$form);
			}
		}
		
	}
	
	public function orders_folder($id = 0) //new
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();

		if(isset($order[0]['id']))
		{
			$order[0]['publish_date'] = date("d-m-Y", strtotime($order[0]['publish_date']));	

			$order[0]['date_needed'] = date("d-m-Y", strtotime($order[0]['date_needed']));	

			$order_type = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();//print, web, print-web	

			$ad_type = $this->db->get_where('ads_type',array('id' => $order[0]['spec_sold_ad']))->result_array();//new, resize,pickup
			
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

            $publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
				
			$data = array();
			
			$data['client'] = $client[0];

			$data['order_type'] = $order_type[0];

			$data['ad_type'] = $ad_type[0];
			
			$data['order'] = $order[0];

			$data['publications'] = $publication[0];
			
			$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $order[0]['job_no']);
			
			//path specification
			
			$dir4="downloads/".$id.'-'.$jname;

			/* $dir1=$dir.'/'.$pname; $date=date('M-d'); $dir2=$dir1.'/'.date('M'); $dir3=$dir2.'/'.date('d-M-Y'); $dir4=$dir3.'/'.$jname.'-'.$id; */
			//to create folders
			
			if (@mkdir($dir4,0777))
			{

			}
			//to store the form
			
			$myFile = $dir4."/".$jname.".html";
			//if(fopen($myFile)){ if (file_exists("C:/xampplite/htdocs/site/upload/" . $_FILES["file"]["name"]))
				$fh = fopen($myFile, 'w') or die("can't open file");
			//}else{}
			$stringData = $this->load->view('e-order',$data, TRUE);
			fwrite($fh, $stringData);
			fclose($fh);
			//save path
			$post = array('file_path' => $dir4);
			$this->db->where('id', $id);
			$this->db->update('orders', $post);
		}	
	}

	public function sendThisFile()
	{
		$this->load->view('client/sendThisFile');
	}
	
	public function sendfile() //new
	{
		if(!isset($_POST["submit"]))
		{
			$this->load->view('client/sendThisFile');
		}
		else 
		{ 
			date_default_timezone_set(@date_default_timezone_get());

			//$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

			//$publications = $this->db->get_where('publications',array('id' => $client[0]['publication_id']));

			if(isset($_POST['oid']))
			{
				$job = $this->db->get_where('orders',array('id' => $_POST['oid'], 'adrep_id' => $this->session->userdata('cId')));
			}else{
				$job = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId')));
			}

			foreach($job->result_array() as $row)
			{
				$id = $row['id'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $row['job_no']);
				
			}

			//locate directory

			$dir4="downloads/".$id.'-'.$jname;
			$file = array(); $path = array();
			for($i=0;$i<5;$i++)	//file data sent to create_folder function
			{
				if (!empty($_FILES['ufile']['tmp_name'][$i]))
				{
					//replace filename with special char with '_'
					$file[] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $_FILES['ufile']['name'][$i]);
					
					//upload path
					$path[]= $dir4.'/'.$file[$i];
					
					//copy file 
					if(!copy($_FILES['ufile']['tmp_name'][$i], $path[$i]))
					{
						$this->session->set_flashdata("message","File upload has encountered an error!! Try Again...");
						redirect('client/home/sendThisFile');
					}
				}
			}
			$data['dir4'] = $dir4;
			if(isset($_POST['oid']))
			{
				//send mail
				$data['id'] = $_POST['oid'];
				$this->mail_fwd($data);
			}
			$this->load->view('client/result_view', $data);
		}
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

	public function alpha_dash_space($str)
	{
		if(! preg_match('/^[a-z0-9 ]+$/i', $str)){
			$this->form_validation->set_message('alpha_dash_space', 'The job_no field is required & must be alphanumeric only.');
			return FALSE;
		}else{
			return TRUE;
		}//return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}
	
	public function change($error = '', $color = 'darkred')
	{

		if($error) $data['error'] = $error;

		$data['color'] = $color;

		$this->load->view('client/change',$data);

	}

	public function dochange()
	{

		$this->db->query("Update adreps set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('client')."' or username='".$this->session->userdata('client')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");

		if($this->db->affected_rows())

			$this->change('Your password has been changed successfully!', 'darkgreen');

		else

			$this->change('Invalid current password!', 'darkred');

	}

	public function image()
	{
		$uploadDir = "images/adreps/".$this->session->userdata('cId')."/";
		$data['hi'] = "hi";
		if(isset($_POST['Submit']))
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
			&& ($_FILES['Photo']['size'] < 32400)
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
				
				$this->db->where('id', $this->session->userdata('cId'));
				$this->db->update('adreps', $data); 
				
				redirect('client/home/change');
				
			}else{ $data['error']= "Invalid file type";}
		}
		$this->load->view('client/image',$data);
		
	}

	public function send_mail($data) 
	{
		$this->load->library('email'); 
		$this->email->set_mailtype("html");
        $this->email->from($data['from'], $data['from_display']); 
		$this->email->reply_to($data['replyTo'],$data['replyTo_display']);
        $this->email->subject($data['subject']);   
		$this->email->message($this->load->view('e-order',$data, TRUE));
        //$mail->Body      = $this->load->view('e-order',$data, TRUE);
		$this->email->set_alt_message("Unable to load text!");
        $this->email->to($data['recipient'], $data['recipient_display']);
        
		if(!$this->email->send()) return false; else return true;

    }
	
	/*public function send_mail($data) 
	{

		$this->load->library('MyMailer');

        $mail = new PHPMailer();

        $mail->SetFrom($data['from'], $data['from_display']);  

        $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);

        $mail->Subject    = $data['subject'];  

        $mail->Body      = $this->load->view('e-order',$data, TRUE);

        $mail->AltBody    = "Unable to load text!";

        $mail->AddAddress($data['recipient'], $data['recipient_display']);


        if(!$mail->Send())

            return false;

        else 

            return true;

    }*/
	
	/*public function send_mail2($data) 
	{
       $this->load->library('MyMailer');
               
       $mail = new PHPMailer();
       $mail->SetFrom($data['from'], $data['from_display']);  
       $mail->AddReplyTo($data['replyTo2'],$data['replyTo_display2']);
       $mail->Subject    = $data['subject'];  
       $mail->Body      = $this->load->view('e-order2',$data, TRUE);
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($data['recipient'], $data['recipient_display']);
		if(isset($data['design_recipient']) && isset($data['ad_recipient'])){		
			$mail->AddCC($data['design_recipient'], $data['design_recipient_display']);
			$mail->AddCC($data['ad_recipient'], $data['ad_recipient_display']);
		}
		
		$myFile = "downloads/".$data['order']['id'].".txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		if(!$mail->Send()){
		  $stringData = $data['order']['id']." - Mail Not Sent - ".$mail->ErrorInfo;
	   }else{
		  $stringData = $data['order']['id']." - Mail Sent ";
	   }
	   fwrite($fh, $stringData);
	   fclose($fh);
       
	}*/
	public function send_mail2($data) 
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
 		$this->email->from($data['from'], $data['from_display']);
		$this->email->reply_to($data['replyTo2'],$data['replyTo_display2']);
		$this->email->subject($data['subject']);  
		$this->email->message($this->load->view('e-order2',$data, TRUE));
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($data['recipient'], $data['recipient_display']);
		
		if(isset($data['design_recipient']) && isset($data['ad_recipient'])){		
			$this->email->bcc(array($data['design_recipient'], $data['ad_recipient']));
		}
		
		$myFile = "downloads/".$data['order']['id'].".txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		if(!$this->email->send()){
		  $stringData = $data['order']['id']." - Mail Not Sent - ".$this->email->print_debugger();
	   }else{
		  $stringData = $data['order']['id']." - Mail Sent ";
	   }
	   fwrite($fh, $stringData);
	   fclose($fh);
       
	}
	
	public function in($error = '')
    {
        if($error) $data['error'] = $error;               
               
        $this->load->view('client/sendThisFile',$data);               
       
	}
		
	public function reportview()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$data['from'] = $_POST['from_date'];
			$data['to'] = $_POST['to_date'];
			
		}
		$data['order_type'] = $this->db->get('orders_type')->result_array();
		$data['today'] = date("Y-m-d");
		//$orders = $this->db->get_where('orders',array('created_on LIKE' =>  '%2013-11-20%'))->result_array();
		$this->load->view('client/report_view',$data);
	}	
	
	public function order_uploads()
	{
		//$data['orders'] = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId'), ))->result_array();
		$from = date('Y-m-d', strtotime(' -2 day'));
		$to = date('Y-m-d');
		$cid = $this->session->userdata('cId');
		$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` ='".$this->session->userdata('cId')."' and `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59' ;")->result_array();
		$this->load->view('client/additional-upload',$data);
	}
	
	public function additional_file_uploads($id = '')	//new file_uploads($id = '')
	{
		if($id!=''){
			$order = $this->db->get_where('orders',array('id' => $id))->result_array();
			if($order)
			{
				$download_filepath = $order[0]['file_path'];
					if($download_filepath!='none' && file_exists($download_filepath) )
					{
						$data['order_id'] = $id;
						$data['dir4'] = $download_filepath;
						$this->load->view('client/sendThisFile',$data);
					}else{
						$this->orders_folder($id);
						$data['order_id'] = $id;
						$this->load->view('client/sendThisFile',$data);
					}
			}else{
				$this->session->set_flashdata('message','Order Details Unknown For : '.$id);
			}
		}	
	}
		
	public function mail_fwd($data)
	{
		if($data['id']!=''){
		$order = $this->db->get_where('orders',array('id' => $data['id']))->result_array();
		
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();

		$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();

		$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				$data['order'] = $order[0];
				$data['client'] = $client[0];
				$data['design_team'] = $design_team[0];
				$jname= $order[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$data['from'] = 'do_not_reply@adwitads.com';

				$data['from_display'] = 'Order Confirmation';

				//$data['replyTo'] = 'do_not_reply@adwitads.com';
				$data['replyTo'] = $design_team[0]['email_id'];

				$data['replyTo_display'] = 'Order Confirmation';

				$data['subject'] = 'Job No. '.$jname.' has been placed by '.$client[0]['first_name'].' '.$client[0]['last_name'].' from '.$publication[0]['name'];
				
				//Design Team
				$data['recipient'] = $design_team[0]['email_id'];
				//$data['recipient'] = 'sudarshan@adwitads.com';
				$data['recipient_display'] = 'Design Team';
				if(!isset($data['dir4']))
				{
					$this->send_mail($data);//order form
				}else{
					$this->send_mail3($data);//file list
				}
		}else{ 
			$this->session->set_flashdata("message","Send mail function failed");
					redirect('client/home'); 
		}
	}
	
	public function send_mail3($data) 
	{
       
       $this->load->library('MyMailer');
               
       $mail = new PHPMailer();
       $mail->SetFrom($data['from'], $data['from_display']);  
       $mail->AddReplyTo($data['replyTo'],$data['replyTo_display']);
       $mail->Subject    = $data['subject'];  
       $mail->Body      = $this->load->view('result_mail',$data, TRUE);
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($data['recipient'], $data['recipient_display']);

       if(!$mail->Send())
               return false;
               else
               return true;
	}
	
	public function check_mail()
	{
		if(!empty($_POST['mail_id']))
		{
			$dataa['from'] = 'do_not_reply@adwitads.com';

			$dataa['from_display'] = 'Do not reply';

			$dataa['replyTo'] = 'do_not_reply@adwitads.com';

			$dataa['replyTo_display'] = 'Do not reply';

			$dataa['subject'] = 'Job  has been placed ';

				//Client

				$dataa['recipient'] = $_POST['mail_id'];
			
				$dataa['recipient_display'] = 'test mail';

				$this->test_mail($dataa);
		}
		$this->load->view('client/check-mail');
	}
	
	/*public function test_mail($dataa) 
	{
       
       $this->load->library('MyMailer');
               
       $mail = new PHPMailer();
       $mail->SetFrom($dataa['from'], $dataa['from_display']);  
       $mail->AddReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
       $mail->Subject    = $dataa['subject'];  
       $mail->Body      = $dataa['body'];
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($dataa['recipient'], $dataa['recipient_display']);
	   if(isset($dataa['temp1'])){ $mail->AddAttachment($dataa['temp1'],$dataa['fname1']); }
	   if(isset($dataa['temp2'])){ $mail->AddAttachment($dataa['temp2'],$dataa['fname2']); }
       if(!$mail->Send())
               return false;
               else
               return true;
	}*/
	
	public function test_mail($dataa) 
	{
		$this->load->library('email'); 
		$this->email->set_mailtype("html"); 
		$this->email->from($dataa['from'], $dataa['from_display']); 
		$this->email->reply_to($dataa['replyTo'],$dataa['replyTo_display']);
		$this->email->subject($dataa['subject']);
		$this->email->message($dataa['body']);
		$this->email->set_alt_message("Unable to load text!");
		$this->email->to($dataa['recipient'], $dataa['recipient_display']);
	   
	    if(isset($dataa['design_recipient'])){ $this->email->bcc($dataa['design_recipient']); }
		
	    if(isset($dataa['fpath'])){ $this->email->attach($dataa['fpath'], 'attachment'); }
		
		if(isset($dataa['temp1'])){ $this->email->attach($dataa['temp1'], 'attachment', $dataa['fname1']); }
		if(isset($dataa['temp2'])){ $this->email->attach($dataa['temp2'], 'attachment', $dataa['fname2']); }
		
		if(!$this->email->send())
               return false;
               else
               return true;
	}
		
	public function ad_status()
	{
		$data['hi'] = 'hi';
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('id', 'Order id', 'trim');
					
		$this->form_validation->run();
			
		if(isset($_POST['id']))
		{
			$status_check = $this->db->get_where('status_check',array('order_id' => $_POST['id'], 'category !=' =>'v1', 'job_status'=>'1'))->result_array();
			if($status_check)
			{
				$data['status_check'] = $status_check ;
			}else{ $data['error'] = "No Records Found!!"; }
		}
		$this->load->view('client/ad-status',$data);
	}
	
	public function publication_orders()
	{
		$publication = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
		
		$this->load->library('Grocery_CRUD');

		$crud = new grocery_CRUD();

		$crud->set_subject('Orders');

		$crud->set_table('orders');

		$crud->where('orders.publication_id', $publication[0]['publication_id']);

		$crud->order_by('id','desc');

		$crud->columns('id','order_type_id','adrep_id','advertiser_name','publish_date','date_needed','created_on');

		$crud->set_relation('order_type_id','orders_type','{name}');
		$crud->set_relation('adrep_id','adreps','{username}');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$crud->add_action('View', 'images/view.png', 'client/home/view');
		$output = $crud->render();
		$data = array('grid' => $output, 'heading' => 'My Publication Orders');

		$this->load->view('client/gridview',$data);	

	}
	
	public function adtype_chart()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$types = $this->db->get('print_ad_types')->result_array();
		foreach($types as $rows)
		{
			if(isset($_POST['total']))
			{
				$d1 = $this->db->query("SELECT `created_on` FROM `orders` ORDER BY `id` ASC LIMIT 1")->result_array();
				$d2 = $this->db->query("SELECT `created_on` FROM `orders` ORDER BY `id` DESC LIMIT 1")->result_array();
				foreach($d1 as $rows1) $from= date('Y-m-d', strtotime($rows1['created_on'])); 
				foreach($d2 as $rows2) $to= date('Y-m-d', strtotime($rows2['created_on']));
				$dte = $from.' to '.$to;
				$dated = date('M Y', strtotime($from)).' to '.date('M Y', strtotime($to)) ;
				$sql = $this->db->get_where('orders',array('adrep_id' => $this->session->userdata('cId'), 'print_ad_type' => $rows['id']))->result_array();
							
			}elseif(isset($_POST['prevmonth']))
			{
				$dte = date('Y-m', strtotime(' -1 month'));
				$dated = date('M Y', strtotime(' -1 month'));
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `print_ad_type` = '".$rows['id']."' AND `created_on` LIKE '$dte%' ")->result_array();
			
			}elseif(isset($_POST['last3month']))
			{
				$from = date('Y-m-01', strtotime(' -2 month'));
				$to = date('Y-m-d');
				$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `print_ad_type` = '".$rows['id']."' AND (`created_on` BETWEEN '$from' AND '$to') ")->result_array();
			
			}else{
				$dte = date('Y-m');
				$dated = date('M Y');
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `print_ad_type` = '".$rows['id']."' AND `created_on` LIKE '$dte%' ")->result_array();
			}
			$r = (100 * count($sql))/100 ;
			$this->gcharts->DataTable('add')
                      ->addColumn('string', 'add', 'addtype')
                      ->addColumn('string', 'Amount', 'amount')
                      ->addColumn('string', 'Amount', 'amount')
                      ->addRow(array($rows['name'] , $r));
		}
		    
		$config = array(
            'title' => '',
            'pieHole' => .4
        );

        $this->gcharts->DonutChart('add')->setConfig($config);
		$data['date'] = $dated;
		//$data['count'] = $r;
        $this->load->view('client/chart',$data);
		
	}
	
	public function ordertype_chart()
    {
		$this->load->library('gcharts');
        $this->gcharts->load('DonutChart');
		$types = $this->db->get('orders_type')->result_array();
		foreach($types as $rows)
		{
			if(isset($_POST['total']))
			{
				$d1 = $this->db->query("SELECT `created_on` FROM `orders` ORDER BY `id` ASC LIMIT 1")->result_array();
				$d2 = $this->db->query("SELECT `created_on` FROM `orders` ORDER BY `id` DESC LIMIT 1")->result_array();
				foreach($d1 as $rows1) $from= date('Y-m-d', strtotime($rows1['created_on'])); 
				foreach($d2 as $rows2) $to= date('Y-m-d', strtotime($rows2['created_on'])); 
				$dte = $from.' to '.$to;
				$dated = date('M Y', strtotime($from)).' to '.date('M Y', strtotime($to)) ;
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `order_type_id` = '".$rows['id']."' AND (`created_on` BETWEEN '$from' AND '$to') ")->result_array();
			
			}elseif(isset($_POST['prevmonth']))
			{
				$dte = date('Y-m', strtotime(' -1 month'));
				$dated = date('M Y', strtotime(' -1 month'));
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `order_type_id` = '".$rows['id']."' AND `created_on` LIKE '$dte%' ")->result_array();
			
			}elseif(isset($_POST['last3month']))
			{
				$from = date('Y-m-01', strtotime(' -2 month'));
				$to = date('Y-m-d');
				$dated = date('M Y', strtotime(' -2 month')).' to '. date('M Y');
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `order_type_id` = '".$rows['id']."' AND (`created_on` BETWEEN '$from' AND '$to') ")->result_array();
			
			}else{
				$dte = date('Y-m');
				$dated = date('M Y');
				$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `order_type_id` = '".$rows['id']."' AND `created_on` LIKE '$dte%' ")->result_array();
			}
			$r = (100 * count($sql))/100 ;
			$this->gcharts->DataTable('add')
                      ->addColumn('string', 'add', 'addtype')
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
        $this->load->view('client/chart',$data);
		
	}

	public function column_chart()
    {
		$this->load->library('gcharts');
		$this->gcharts->load('ColumnChart');
		
		$this->gcharts->DataTable('orders')
              ->addColumn('date', 'Year', 'month')
              ->addColumn('number', 'Total Ads', 'totalads');
			  
		$s = $this->db->query("SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['created_on']; 
		 
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
	
			$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `created_on` LIKE '$dt%' ")->result_array();	//web
			
			//echo $dt."<br/>";		
			$data1 = array(
			//new jsDate($year,$month-$a,$a ,$date),
				new jsDate($year,$a,$month), //Year
				count($sql)                  
								
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
			'title' => '',
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

		$this->load->view('client/column_chart');
	}
	
	public function line_chart()
	{
		$this->load->library('gcharts');
		$this->gcharts->load('LineChart');


		$dataTable = $this->gcharts->DataTable('orders');

		$dataTable->addColumn('date', 'Year', 'month');
		$dataTable->addColumn('number', 'Total Ads', 'totalads');
		
		$s = $this->db->query("SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 1")->result_array();
		//foreach($s as $rows) $created_on= $rows['created_on']; 
		 
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
	
			$sql = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `created_on` LIKE '$dt%' ")->result_array();	//web
			
			//echo $dt."<br/>";		
			$data1 = array(
			//new jsDate($year,$month-$a,$a ,$date),
				new jsDate($year,$a-1,$month), //Year
				count($sql)                  
								
			);

			$this->gcharts->DataTable('orders')->addRow($data1);
		}

		$config = array(
			'title' => 'Stocks'
		);

		$this->gcharts->LineChart('Stocks')->setConfig($config);
		$this->load->view('client/line_chart');
	}
		
	public function myorders_v2( $display_type='' ) 
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
		$num_days = $client[0]['display_orders'];
		$data['publication'] = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$today = date('Y-m-d');     
		$pday = date('Y-m-d', strtotime(" -$num_days day"));
		$pyday = date('Y-m-d', strtotime(' -6 day'));
		
		$data['preorder_count'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$pyday 00:00:00' AND '$today 23:59:59';")->num_rows();
		if($display_type=='approved')
		{
			if($this->session->userdata('cId')=='337'){
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' OR `adrep_id` = '332' AND `status` = '7' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `status` = '7' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}
		}elseif($display_type=='proofready'){
			if($this->session->userdata('cId')=='337'){
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' OR `adrep_id` = '332' AND `status` = '5' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}else{
				$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND `status` = '5' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
			}
		}else{ 
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				if($this->session->userdata('cId')=='337'){
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' OR `adrep_id` = '332' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ORDER BY `id` DESC;")->result_array();
				}else{
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ORDER BY `id` DESC;")->result_array();										
				}
			}else{
				if($this->session->userdata('cId')=='337'){
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' OR `adrep_id` = '332' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
				}else{
					$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59') ORDER BY `id` DESC;")->result_array();
				}
			}
		}
		$this->load->view('client/myorders_v2', $data);
	}
	
	public function myorders_all()
	{
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59'")->result_array();
		
		}elseif(!empty($_POST['search'])){
			$search = $_POST['search'];
			$orders = $this->db->query("SELECT * FROM `orders` `id` = '$search' OR `advertiser_name` = '$search' OR `job_no` = '$search'")->result_array();
			if($orders){ $data['orders'] = $orders; }
			else{
				$this->session->set_flashdata("message","No Orders Found for $search");
				redirect('client/home/myorders_all');}
		}else{
			$today = date('Y-m-d');
			$pday = date('Y-m-d', strtotime(' -1 day'));
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
			
		}
		$this->load->view('client/myorders_all', $data);
	}
	 
	public function myteam_orders()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
		$num_days = $client[0]['display_orders'];
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '".$client[0]['publication_id']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') ")->result_array();
	  
		}elseif(!empty($_POST['search'])){
			$search = $_POST['search'];
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '".$client[0]['publication_id']."' AND (`id` = '$search' OR `advertiser_name` LIKE '%$search%' OR `job_no` = '$search')")->result_array();
			if($orders){ 
				$data['orders'] = $orders; 
			}elseif($publication[0]['id']=='43' || $publication[0]['id']=='47' || $this->session->userdata('cId')=='36'){ //only desert shoppers & demo user
				$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '$search%' OR `advertiser` LIKE '$search%')")->result_array();
				if($preorder){ 
					$data['preorder'] = $preorder; 
					//$this->load->view('client/preorders', $data);
				}else{ redirect('client/home/myteam_orders'); }
			}else{
				$this->session->set_flashdata("message","No Orders Found for $search");
				redirect('client/home/myteam_orders');
			}
		}else{
			$today = date('Y-m-d');
			//$pday = date('Y-m-d', strtotime(' -3 day'));
			$pday = date('Y-m-d', strtotime(" -$num_days day"));
			$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id` = '".$client[0]['publication_id']."' AND (`created_on` BETWEEN '$pday 00:00:00' AND '$today 23:59:59');")->result_array();
	   
		}
		if(isset($preorder)){
			$this->load->view('client/preorders', $data);
		}else{
			$this->load->view('client/myteam_orders', $data);
		}
	}
			
	public function rev_orders($order='')
	{
		if(isset($_POST["order_id"])) 
		{
			$data['hi'] = 'hello';
			$version = 'V1a'; $file_path = 'none';
			$oid = $_POST['order_id'];
			//$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $_POST['order_id']))->result_array();
			$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$oid' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
			if($orders_rev)
			{
				/*foreach($orders_rev as $last_row){ $version = $last_row['version']; }*/
				$version = $orders_rev[0]['version'];
				if($version == 'V1a'){ $version = 'V1b'; }
				elseif($version == 'V1b'){ $version = 'V1c'; }
				elseif($version == 'V1c'){ $version = 'V1d'; }
				elseif($version == 'V1d'){ $version = 'V1e'; }
				elseif($version == 'V1e'){ $version = 'V1f'; }
				elseif($version == 'V1f'){ $version = 'V1g'; }
				elseif($version == 'V1g'){ $version = 'V1h'; }
				elseif($version == 'V1h'){ $version = 'V1i'; }
				elseif($version == 'V1i'){ $version = 'V1j'; }
				elseif($version == 'V1j'){ $version = 'V1k'; }
				elseif($version == 'V1k'){ $version = 'V1l'; }
				elseif($version == 'V1l'){ $version = 'V1m'; }
				elseif($version == 'V1m'){ $version = 'V1n'; }
				elseif($version == 'V1n'){ $version = 'V1o'; }
				elseif($version == 'V1o'){ $version = 'V1p'; }
				elseif($version == 'V1p'){ $version = 'V1q'; }
				elseif($version == 'V1q'){ $version = 'V1r'; }
				elseif($version == 'V1r'){ $version = 'V1s'; }
				elseif($version == 'V1s'){ $version = 'V1t'; }
				elseif($version == 'V1t'){ $version = 'V1u'; }
				elseif($version == 'V1u'){ $version = 'V1v'; }
				elseif($version == 'V1v'){ $version = 'V1w'; }
				elseif($version == 'V1w'){ $version = 'V1x'; }
				elseif($version == 'V1x'){ $version = 'V1y'; }
				elseif($version == 'V1y'){ $version = 'V1z'; }
			}
			
			if (isset($_FILES['ufile']))	//file upload to revision_downloads
			{
				$dir = "revision_downloads/".$_POST["job_slug"];
				$file_path = $dir;
			    if (@mkdir($dir,0777))
				{

				}
				if(!empty($_FILES['ufile']['tmp_name'][0]) && $_FILES['ufile']['size'][0] > '0'){
					$path1= $dir.'/'.$_FILES['ufile']['name'][0];
					if(!copy($_FILES['ufile']['tmp_name'][0], $path1))
					{
						echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
						redirect('client/home/rev_orders/'.$_POST['order_id']);
					}else{
						$dataa['path1'] = $path1; 
						//$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
						//$dataa['fname1'] = $_FILES['ufile']['name'][0];
					}
				}
				
				if (!empty($_FILES['ufile']['tmp_name'][1])&& $_FILES['ufile']['size'][1] > '0'){
					$path2= $dir.'/'.$_FILES['ufile']['name'][1];
					if(!copy($_FILES['ufile']['tmp_name'][1], $path2))
					{
						echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][1] ." try again!!')</script>";
						//$this->session->set_flashdata("message2","Internal Error: Order could not be placed!");
						redirect('client/home/rev_orders/'.$_POST['order_id']);
					}else{
						$dataa['path2'] = $path2;
						//$dataa['temp2'] = $_FILES['ufile']['tmp_name'][1]; 
						//$dataa['fname2'] = $_FILES['ufile']['name'][1];
					}
				}
				$data['dir4'] = $dir;
			}
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
			$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
			
			//rev_sold_jobs
			$tday = date('Y-m-d');
			$time = date("H:i:s");
			if($publication[0]['id']=='43' || $publication[0]['id']=='13'){ if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; } }else{ $rush = '0'; } 		
			$post = array(
							'order_id' => $_POST['order_id'],
							'order_no' => $_POST['job_slug'],
							'adrep' => $this->session->userdata('cId'),
							'help_desk' => $publication[0]['help_desk'],
							'date' => $tday,
							'time' => $time,
							'category' => 'revision',
							'version' => $version,
							'note' => $_POST['copy_content_description'],
							'rush' => $rush,
							'file_path' => $file_path,
							'status' => '1'
						  );
			$this->db->insert('rev_sold_jobs', $post); 
			$rev_id = $this->db->insert_id();
			
			if($rev_id)	
			{
				//send mail
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					$dataa['from'] = $design_team[0]['email_id'];

					$dataa['from_display'] = 'Design Team';

					$dataa['replyTo'] = $design_team[0]['email_id'];

					$dataa['replyTo_display'] = 'Design Team';

					$dataa['subject'] = 'Revision :'.$_POST['job_slug'] ;
					$_POST['copy_content_description'] = str_replace(PHP_EOL,'<br/>', $_POST['copy_content_description']);
					$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> 
										Email Id : '.$this->session->userdata('cEmail').'<br/>
										Publication : '.$publication[0]['name'].'<br/>
										Note & Instructions : '.$_POST['copy_content_description'].'<br/>';
					if(isset($path1) || isset($path2)){
						$dataa['body'] .= '<a href="'.base_url().index_page().'client/home/frontline_instruction/'.$rev_id.'"><button>Attachments</button></a>';
					}
					
					//Client
					$dataa['recipient'] = $this->session->userdata('cEmail');
					$dataa['recipient_display'] = $client[0]['first_name'].' '.$client[0]['last_name'];
					
					$dataa['design_recipient'] = $design_team[0]['email_id'];
					$this->test_mail($dataa);
					/*
					//Design team	
					$dataa['recipient'] = $design_team[0]['email_id'];
					$dataa['recipient_display'] = 'Design Team';
					$this->test_mail($dataa); */
			}else{ 
				$this->session->set_flashdata("message2","Internal Error: Order could not be placed!");
				redirect('client/home/rev_orders/'.$_POST['order_id']); 
			}					
			$this->load->view('client/rev_result', $data);
			
		}elseif($order!=''){
			//if($order!=''){
				$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order' ORDER BY `id` DESC LIMIT 1 ;")->result_array();
				$cat_result = $this->db->get_where('cat_result',array('order_no' => $order))->result_array();
				if($orders_rev){
					$slug = $orders_rev[0]['new_slug'];
				}elseif($cat_result){
					$slug = $cat_result[0]['slug'];
				}else{
					$this->session->set_flashdata("message",$order." : Revision not allowed..!!");
					redirect('client/home/myorders_v2');
				} 
				if($slug!='none')
				{ 
					//$slug = $cat_result[0]['slug'];
					$data['order'] = $order;
					$data['cat_result'] = $cat_result[0];
					$data['slug'] = $slug;
				
					$this->load->view('client/rev_orders', $data);
				}else{
					$this->session->set_flashdata("message",$order." : Revision not yet allowed..!!");
					redirect('client/home/myorders_v2');
				}
			//}
		}
	} 
	
	public function frontline_instruction($rev_id = '')
	{
		$rev_sold = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id, 'job_status' => '1'))->result_array();
		if($rev_sold){
			$data['rev_sold'] = $rev_sold[0];
			$this->load->view('client/frontline_instruction',$data);
		}else{
			$this->session->set_flashdata("message","Order Details Not Found!!");
			redirect('client/home/myorders_v2');
		}
	}
	
	public function revision_details($order_id='')
	{
		$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		if($order!='' && isset($order[0]['id']))
		{
			$data['order'] = $order;
			$publication = $this->db->get_where('publications',array('id' => $order[0]['publication_id']))->result_array();
			$data['publication'] = $publication[0];
			$cat_result = $this->db->get_where('cat_result',array('order_no' => $order_id))->result_array();
			$data['cat_result'] = $cat_result;
			if(($order[0]['status']=='5' || $order[0]['status']=='7') && $cat_result[0]['source_path'] != 'none' && file_exists($cat_result[0]['source_path'])){
				$data['slug'] = $cat_result[0]['slug'];
				$sourcefilepath = $cat_result[0]['source_path'];
				$data['sourcefilepath'] = $sourcefilepath;
			}
			
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order_id))->result_array();
			$data['orders_rev'] = $orders_rev;
			//ftp sourceFile path
			if($cat_result && $cat_result[0]['ftp_source_path']!='none'){ 
				$data['ftp_source_path'] = $cat_result[0]['ftp_source_path']; 
				if($orders_rev){
					$data['last_orders_rev'] =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
				}
			}
			$this->load->view('client/revision_details', $data);
		}
	}
	
	public function zip_folder_select() 
	{
		if(isset($_POST['source_file']))
		{
			$new_slug = $_POST['new_slug'] ;
			
			$SourceFilePath = $_POST['source_path'] ;
			$source_file = $_POST['source_file'];
			$pdf_file = $new_slug.'.pdf';
			
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}//else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
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
			}
		}else{ echo"<script>alert('no sourcefile');</script>"; }
						
	}
	
	
	public function revision_list()
	{	if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		{
			$from = $_POST['from_date'];
			$to = $_POST['to_date'];
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `adrep` = '".$this->session->userdata('cId')."' AND (`date` BETWEEN '$from' AND '$to'); ")->result_array();
		}else{
			$today = date('Y-m-d');
			$pday = date('Y-m-d', strtotime(' -3 day'));
			$orders_rev = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `adrep` = '".$this->session->userdata('cId')."' AND (`date` BETWEEN '$pday' AND '$today'); ")->result_array();
			
		}
		$data['orders_rev'] = $orders_rev;
		$this->load->view('client/revision_list', $data);
	}
	
	public function answer_v2($id='') 
	{ 
		$rev_order = $this->db->get_where('rev_sold_jobs',array('id' => $id))->result_array();
		if(isset($rev_order[0]['id'])){
			$question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `rev_id`='$id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($question){
				if(isset($_POST['submit'])){
					//$order = $this->db->get_where('orders',array('id' => $id))->result_array();
					if (!empty($_FILES['ufile']['tmp_name'][0])) //file upload to downloads
					{ 
						if(!file_exists($rev_order[0]['file_path'])){
							$dir = "revision_downloads/".$rev_order[0]['order_no'];
							if (@mkdir($dir,0777)){ }
							//rev order update file_path
							$fpost = array( 'file_path' => $dir );
							$this->db->where('id', $id);
							$this->db->update('rev_sold_jobs', $fpost);
							$path1 = $dir.'/'.$_FILES['ufile']['name'][0];
						}else{
							$path1 = $rev_order[0]['file_path'].'/'.$_FILES['ufile']['name'][0];
						}
		 				
						if(!copy($_FILES['ufile']['tmp_name'][0], $path1)){
							echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
							exit();
						}else{
							//$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
							//$dataa['fname1'] = $_FILES['ufile']['name'][0];
							$dataa['fpath'] = $path1;
						}        
					}
		
					//rev order status
					$post = array( 'question' => '2' );
					$this->db->where('id', $id);
					$this->db->update('rev_sold_jobs', $post);
				
					//orders_Q_A
					$timestamp = date('Y-m-d H:i:s');
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('cId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
					
					//send mail 
					 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
					if($client)
					{
						$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
						$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						
						$dataa['from'] = $design_team[0]['email_id'];
						
						$dataa['from_display'] = 'Design Team';

						$dataa['replyTo'] = $design_team[0]['email_id'];

						$dataa['replyTo_display'] = 'Design Team';

						$dataa['subject'] = 'Question Answered for Unique Ad No: '.$_POST['order_id'] ;
						
						$_POST['answer'] = str_replace(PHP_EOL,'<br/>', $_POST['answer']);
						$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Answer : '.$_POST['answer'];
						//Design team	
						
						$dataa['recipient'] = $design_team[0]['email_id'];
						//$dataa['recipient'] = 'sudarshan@adwitads.com';
						$dataa['recipient_display'] = 'Design Team';
						$this->test_mail($dataa); 
					} 
					redirect('client/home/myorders_v2');
				}
				
				$data['question'] = $question[0];
				$data['rev_sold_jobs'] = $rev_order[0]; //revision
				$this->load->view('client/answer_v2', $data);
			}
			
		}else{ 
			echo "<script>alert('Direct Access Denied..')</script>";
			//$this->session->set_flashdata("message","Internal Error: Order not placed!");
			$this->index();
		}
	}
	
	/*
	public function answer_v2($id='')
	{
		if($id!='')
		{
			$rev_sold_jobs = $this->db->get_where('rev_sold_jobs',array('id' => $id))->result_array();
			if(isset($_POST['submit']))
			{	
				if (!empty($_FILES['ufile']['tmp_name'][0]))	//file upload to revision_downloads
				{	
					$dir = "revision_downloads/".$_POST["job_slug"];
					//$file_path = $dir;
					if (@mkdir($dir,0777))
					{

					}
					$path1= $dir.'/'.$_FILES['ufile']['name'][0];
					//$path2= $dir.'/'.$_FILES['ufile']['name'][1];
									
					if(!copy($_FILES['ufile']['tmp_name'][0], $path1))
					{
						echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
						exit();
					}else{
						$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
						$dataa['fname1'] = $_FILES['ufile']['name'][0];
					}								
				}
				$post = array( 'answer' => $_POST['answer'] );
				$this->db->where('id', $_POST['id']);
				$this->db->update('rev_sold_jobs', $post);
				
				//send mail
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
				if($client)
				{
					
					$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
					$dataa['from'] = $design_team[0]['email_id'];
					
					$dataa['from_display'] = 'Design Team';

					$dataa['replyTo'] = $design_team[0]['email_id'];

					$dataa['replyTo_display'] = 'Design Team';

					$dataa['subject'] = 'Question Answered for Unique Ad No: '.$_POST['order_id'] ;
					
					$_POST['answer'] = str_replace(PHP_EOL,'<br/>', $_POST['answer']);
					$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Answer : '.$_POST['answer'];
					//Design team	
					
					$dataa['recipient'] = $design_team[0]['email_id'];
					//$dataa['recipient'] = 'sudarshan@adwitads.com';
					$dataa['recipient_display'] = 'Design Team';
					$this->test_mail($dataa); 
				} 
				redirect('client/home/myorders_v2');
			}
			
			$data['rev_sold_jobs'] = $rev_sold_jobs[0];
			$this->load->view('client/answer', $data);
		}else{ 
				echo "<script>alert('Direct Access Denied..')</script>";
				//$this->session->set_flashdata("message","Internal Error: Order not placed!");
				$this->index();
		}
	}
	*/
	
	public function cshift_answer_v2($id='') 
	{
		if($id!='')
		{
		   $question = $this->db->query("SELECT * FROM `orders_Q_A` WHERE `order_id`='$id' ORDER BY `id` DESC LIMIT 1")->result_array();
		   if($question){
				if(isset($_POST['submit'])) 
				{
					$order = $this->db->get_where('orders',array('id' => $id))->result_array();
					if (!empty($_FILES['ufile']['tmp_name'][0])) //file upload to downloads
					{ 
						$path1 = $order[0]['file_path'].'/'.$_FILES['ufile']['name'][0];
						if(!copy($_FILES['ufile']['tmp_name'][0], $path1))
						{
							echo "<script>alert('error uploading file : " . $_FILES['ufile']['tmp_name'][0] ."')</script>";
							exit();
						}else{
						  //$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
						  //$dataa['fname1'] = $_FILES['ufile']['name'][0];
						  $dataa['fpath'] = $path1;
						}        
					}
					//order status
					$post_status = array('question' => '2');
					$this->db->where('id', $id);
					$this->db->update('orders', $post_status); 
					
					//orders_Q_A
					$timestamp = date('Y-m-d H:i:s');
					$Apost = array( 'answer' => $_POST['answer'], 'adrep' => $this->session->userdata('cId'), 'Atimestamp' => $timestamp );
					$this->db->where('id', $_POST['id']);
					$this->db->update('orders_Q_A', $Apost);
				
					//send mail 
					 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
					if($client)
					{
						 $publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
						 $design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
						 
						 $dataa['from'] = $design_team[0]['email_id'];
						 
						 $dataa['from_display'] = 'Design Team';

						 $dataa['replyTo'] = $design_team[0]['email_id'];

						 $dataa['replyTo_display'] = 'Design Team';

						 $dataa['subject'] = 'Question Answered for Unique Ad No: '.$order[0]['job_no'].' AdwitAds Id: '.$order[0]['id'];
						
						 $_POST['answer'] = str_replace(PHP_EOL,'<br/>', $_POST['answer']);
						 $dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Answer : '.$_POST['answer'];
						 //Design team 
						 
						 $dataa['recipient'] = $design_team[0]['email_id'];
						 //$dataa['recipient'] = 'sudarshan@adwitads.com';
						 $dataa['recipient_display'] = 'Design Team';
						 $this->test_mail($dataa); 
					} 
					redirect('client/home/myorders_v2');
				}
				$data['question'] = $question[0];//cat_result 
				$this->load->view('client/answer_v2', $data);
			}
		}else{ 
			echo "<script>alert('Direct Access Denied..')</script>";
			//$this->session->set_flashdata("message","Internal Error: Order not placed!");
			$this->index();
		}
	}
	
	public function jRate($order='')
	{
		if($order!=''){   
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order))->result_array();
			$order_details = $this->db->get_where('orders',array('id' => $order))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $order_details[0]['adrep_id']))->result_array();
			if($orders_rev){
				foreach($orders_rev as $row)
				{
					$filename = $row['pdf_path'];
					$rev_id = $row['id'];
					$rev_approve = $row['approve'];
				}
				if($rev_approve=='0'){
					$post = array('approve'=>'1');
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post); 
				}
			}else{
				$this->load->helper('directory');
				$map = directory_map('pdf_uploads/'.$order.'/');
				if($map){ foreach($map as $file){ $filename = 'pdf_uploads/'.$order.'/'.$file; }}
				 if($order_details[0]['approve']=='0'){
					$post = array('approve'=>'1', 'status'=>'7');
					$this->db->where('id', $order_details[0]['id']);
					$this->db->update('orders', $post);
				} 
			}
			$ftp_server = 'none';
			//ftp upload
			if($order_details[0]['publication_id']=='43'){	//Desert shoppers
				$ftp_server = '65.60.71.83';
				$ftp_username='adwit';
				$ftp_userpass='DisplayAd5';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='47'){		//Imperial valley press
				$ftp_server = '12.147.19.253';
				$ftp_username= 'adwit';
				$ftp_userpass= '!VPr3$$123';
				$folder_name = '';
			}elseif($order_details[0]['publication_id']=='206'){	//The pilot news
				$publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				//$dataa['design_team'] = $design_team[0];
				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Order Confirmation';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';

				$dataa['subject'] = 'Approved Hi-Res PDF : '.$jname ;
				$dataa['body'] = 'Hi AdRep,<br/><br/>Attached is the approved Hi-Res PDF for Unique Job Name : '.$jname.' with AdwitAds ID : '.$order.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				//Design Team
				$dataa['recipient'] = $this->session->userdata('cEmail');
				//$dataa['recipient'] = 'sudarshan@adwitads.com';
				//$dataa['recipient_display'] = 'Design Team';
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}elseif($order_details[0]['publication_id']=='27'){ //Yuma sun
				$publication = $this->db->query("Select * from publications where id='".$order_details[0]['publication_id']."'")->result_array();
				$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();

				//$dataa['design_team'] = $design_team[0];
				$jname= $order_details[0]['job_no'];
				$jname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $jname);
		
				$dataa['from'] = 'do_not_reply@adwitads.com';

				$dataa['from_display'] = 'Approved  Order';

				$dataa['replyTo'] = $design_team[0]['email_id'];

				$dataa['replyTo_display'] = 'Design Team';

				$dataa['subject'] = 'Approved Hi-Res PDF : '.$jname ;
				$dataa['body'] = 'Hi '.$client[0]['first_name'].' '.$client[0]['last_name'].',<br/><br/>Attached is the approved Hi-Res PDF for Unique Job Name : '.$jname.' with AdwitAds ID : '.$order.'<br/><br/><br/> Thanks, <br/> Your Design Team.';
				//Design Team
				
				$dataa['recipient'] = 'ads@yumasun.com';
				//$dataa['Cc'] = 'webmaster@adwitads.com';
				
				$dataa['filename'] = $filename;
				if($this->ftp_mail($dataa)){
					echo "Mail Sent!!";
			    }else{
					echo "Error Sending Mail!!";
				}
			}else{
				$ftp_server = '115.248.71.109';
				$ftp_username='annexe3';
				$ftp_userpass='adwit@123';
				$folder_name = 'adwitads-test';
			}
			if($ftp_server != 'none'){
				$ftp_conn = @ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login = @ftp_login($ftp_conn, $ftp_username, $ftp_userpass) or die("Could not login to $ftp_server");

				$file = $filename;
				$path_parts = pathinfo($file);
				$fname = $order_details[0]['job_no'].'.pdf';
				// upload file
				if (ftp_put($ftp_conn, $folder_name.'/'.$fname, $file, FTP_BINARY)){
					echo "Successfully uploaded $fname.";
			    }else{
					echo "Error uploading $fname .";
				}
				// close connection
				ftp_close($ftp_conn);
			}
		}
	}
	
	public function ftp_mail($dataa) 
	{
       
       $this->load->library('MyMailer');
               
       $mail = new PHPMailer();
       $mail->SetFrom($dataa['from'], $dataa['from_display']);  
       $mail->AddReplyTo($dataa['replyTo'],$dataa['replyTo_display']);
       $mail->Subject    = $dataa['subject'];  
       $mail->Body      = $dataa['body'];
       $mail->AltBody    = "Unable to load text!";
       $mail->AddAddress($dataa['recipient']);
	   if(isset($dataa['Cc'])){
		  $mail->AddCC($dataa['Cc']); 
	   }
	   $mail->AddAttachment($dataa['filename']);
	   if(!$mail->Send())
               return false;
               else
               return true;
	}
	
	/*public function add_rating()
	{
		if(!empty($_POST["rating"]) && !empty($_POST["id"])) 
		{
			$order_rating = $this->db->get_where('order_rating',array('order_no'=>$_POST["id"]))->result_array();
			if(!$order_rating)
			{
				$post = array('order_no'=>$_POST["id"], 'rating'=>$_POST["rating"]);
				$this->db->insert('order_rating', $post); 
			}
		}
	}*/
	
	public function unapprove_order($order = '')
	{
		if($order!=''){   
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order))->result_array();
			if($orders_rev)
			{
				foreach($orders_rev as $row)
				{
					$rev_id = $row['id'];
					$rev_approve = $row['approve'];
				}
				if($rev_approve=='1'){
					$post = array('approve'=>'0');
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post); 
				}
			}else{
				$order_details = $this->db->get_where('orders',array('id' => $order))->result_array();
				if($order_details[0]['approve']=='1'){
					$post = array('approve'=>'0', 'status'=>'5');
					$this->db->where('id', $order_details[0]['id']);
					$this->db->update('orders', $post);
				} 
			}
			redirect('client/home/myorders_v2');
		}
	}
	
	public function unapprove_teamorder($order = '')
	{
		if($order!=''){   
			$orders_rev = $this->db->get_where('rev_sold_jobs',array('order_id' => $order))->result_array();
			if($orders_rev)
			{
				foreach($orders_rev as $row)
				{
					$rev_id = $row['id'];
					$rev_approve = $row['approve'];
				}
				if($rev_approve=='1'){
					$post = array('approve'=>'0');
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post); 
				}
			}else{
				$order_details = $this->db->get_where('orders',array('id' => $order))->result_array();
				if($order_details[0]['approve']=='1'){
					$post = array('approve'=>'0', 'status'=>'5');
					$this->db->where('id', $order_details[0]['id']);
					$this->db->update('orders', $post);
				} 
			}
			redirect('client/home/myteam_orders');
		}
	}
	
	public function order_cancel($order_id = '')
	{
		if($order_id!='' && isset($_POST['remove']))
		{
			$post = array('cancel' => '1', 'crequest' => '0', 'status' => '6');
			$this->db->where('id', $order_id);
			$this->db->update('orders', $post);
						
			//orders_cancel
			$orders_cancel = $this->db->query("SELECT * FROM `orders_cancel` WHERE `order_id`='$order_id' ORDER BY `id` DESC LIMIT 1")->result_array();
			if($orders_cancel){
				//if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/Chicago');}
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('adrep' => $this->session->userdata('cId'), 'Atimestamp' => $timestamp);
				$this->db->where('id', $orders_cancel[0]['id']);
				$this->db->update('orders_cancel', $post_cancel);
			}else{
				//if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/Chicago');}
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('order_id' => $order_id, 'adrep' => $this->session->userdata('cId'), 'Atimestamp' => $timestamp);
				$this->db->insert('orders_cancel', $post_cancel);
			}
			$this->session->set_flashdata("message","Order Cancellation for $order_id Submitted!!");
			redirect('client/home/myorders_v2');
			 
		}
	}
	
	public function reject_v2($order_id = '')
	{
		if($order_id!='')
		{
			if(isset($_POST['reject']))
			{
				if (!empty($_FILES['ufile']['tmp_name'][0]))	//file attach to mail
				{	
					$dataa['temp1'] = $_FILES['ufile']['tmp_name'][0]; 
					$dataa['fname1'] = $_FILES['ufile']['name'][0];
				}
				
				/* $post = array('cancel' => '0', 'reason' => $_POST['reason']);
				$this->db->where('order_no', $order_id);
				$this->db->update('cat_result', $post); */
				
				//order status Qrequest
				$post_status = array('crequest' => '0');
				$this->db->where('id', $order_id);
				$this->db->update('orders', $post_status);
				
				//orders_cancel
				//if (function_exists('date_default_timezone_set')){date_default_timezone_set('America/Chicago');}
				$timestamp = date('Y-m-d H:i:s');
				$post_cancel = array('adrep' => $this->session->userdata('cId'), 'Rreason' => $_POST['reason'], 'Atimestamp' => $timestamp);
				$this->db->where('id', $_POST['id']);
				$this->db->update('orders_cancel', $post_cancel);
				
				//send mail
				 $client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
				if($client)
				{
					
					$publication = $this->db->query("Select * from publications where id='".$client[0]['publication_id']."'")->result_array();
					$design_team = $this->db->query("Select * from design_teams where id='".$publication[0]['design_team_id']."'")->result_array();
					
					$dataa['from'] = $design_team[0]['email_id'];
					
					$dataa['from_display'] = 'Design Team';

					$dataa['replyTo'] = $design_team[0]['email_id'];

					$dataa['replyTo_display'] = 'Design Team';

					$dataa['subject'] = 'Ad Request For Cancellation of order : '.$_POST['order_no'].' Not Approved' ;
					
					$_POST['reason'] = str_replace(PHP_EOL,'<br/>', $_POST['reason']);
					$dataa['body'] = 'Adrep Name : '.$client[0]['first_name'].' '.$client[0]['last_name'].'<br/> Publication : '.$publication[0]['name'].'<br/> Reason : '.$_POST['reason'];
					//Design team	
					
					$dataa['recipient'] = $design_team[0]['email_id'];
					//$dataa['recipient'] = 'sudarshan@adwitads.com';
					$dataa['recipient_display'] = 'Design Team';
					$this->test_mail($dataa); 
				}
				$this->session->set_flashdata("message","Order Cancellation Request Rejected!!");
				redirect('client/home/myorders_v2');
			}else{
				$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
				$data['orders_cancel'] = $this->db->get_where('orders_cancel',array('order_id' => $order_id))->result_array();
				$data['order'] = $order[0];
			}
			
			$this->load->view('client/reject_v2',$data);
		} 
	}
	
	public function preorders()
	{
		  if(isset($_POST['Submit']) && isset($_POST['id']))
		  {
			$data['preorder_details'] = $this->db->get_where('preorder',array('id' => $_POST['id']))->result_array();
			$this->load->view('client/preorder_submit', $data);
		  }else{
			if(isset($_POST['job_name']) && isset($_POST['id']))
			{
				if(empty($_POST['color']) || empty($_POST['width']) || empty($_POST['height']))
				{
					$this->session->set_flashdata("message","Fill the required(*) Fields and Try again. Order not Submitted!");
					redirect('client/home/preorders');
				}
				$preorder = $this->db->get_where('preorder',array('id' => $_POST['id']))->result_array();
				$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
				$publication_hd = $this->db->query("SELECT * FROM `publications` WHERE `id`='".$client[0]['publication_id']."' ;")->result_array();  
			
				$preorder[0]['publish_date'] = date("Y-m-d", strtotime($preorder[0]['publish_date']));
				if($preorder[0]['publish_date'] != '0000-00-00'){
					//echo $preorder[0]['publish_date'];
					$priority = date('Y-m-d', strtotime('-3 day', strtotime($preorder[0]['publish_date'])));
				}else{
					$priority= date('Y-m-d');
				}
				$preorder[0]['date_needed'] = date("Y-m-d", strtotime($preorder[0]['date_needed']));
				if(!empty($_POST['rush'])){ $rush = $_POST['rush']; }else{ $rush = '0'; }
				$post = array(
					'adrep_id' => $this->session->userdata('cId'),
					'publication_id' => $client[0]['publication_id'],
					'group_id' => $publication_hd[0]['group_id'],
					'help_desk' => $publication_hd[0]['help_desk'],
					'order_type_id' => '2', 
					'advertiser_name' => $preorder[0]['advertiser'],
					'date_needed' => $preorder[0]['date_needed'],
					'publish_date' => $preorder[0]['publish_date'],
					'job_no' => $preorder[0]['job_name'],
					//'job_instruction' => $_POST['job_instruction'],
					'copy_content_description' => $_POST['copy_content_description'],
					'notes' => $_POST['notes'],
					'width' => $_POST['width'],
					'height' => $_POST['height'],
					'print_ad_type' => $_POST['color'],
					'rush' => $rush,
					'priority' => $priority,
					);
				$this->db->insert('orders',$post); 
				$order_no = $this->db->insert_id(); 
				
				if($order_no){
				 $post = array('accept' => '1');
				 $this->db->where('job_name', $preorder[0]['job_name']);
				 $this->db->update('preorder', $post);
				 
				 $data = array();
				 for($i=0;$i<5;$i++) //file data sent to create_folder function
				 {
				  if (!empty($_FILES['ufile']['tmp_name'][$i]))
				  {
				   $data['temp'.$i] = $_FILES['ufile']['tmp_name'][$i]; 
				   $data['fname'.$i] = $_FILES['ufile']['name'][$i];
				  }
				 }
				//new changes
				 $this->orders_folder($order_no); //folder creation
				  
				 $data['id'] = $order_no;
				 $this->sendfile_preorder($data); //file upload
				 $this->mail_fwd($data); //send mail
				 
				 $this->session->set_flashdata("message","Order placed!");
				 redirect('client/home');
				}else{ 
				 $this->session->set_flashdata("message","Internal Error: Order not placed!");
				 redirect('client/home');
				}
		   }
		   if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
		   {
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				$data['preorder'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$from 00:00:00' AND '$to 23:59:59';")->result_array();
		   }else{
				$today = date('Y-m-d');
				$pday = date('Y-m-d', strtotime(' -6 day'));
				$data['preorder'] = $this->db->query("Select * from `preorder` where `accept`='0' AND `time_stamp` BETWEEN '$pday 00:00:00' AND '$today 23:59:59';")->result_array();
		   }
		   $this->load->view('client/preorders', $data);
		}
	}
	
	public function search_orders()
	{
		$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
		$publication = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
		$data['publication'] = $publication;
		if(!empty($_POST['search']))
		{
			$search = $_POST['search'];
			if($this->session->userdata('cId')=='36'){	//only demo user
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `id` LIKE '$search%' OR `advertiser_name` LIKE '$search%' OR `job_no` LIKE '$search%'")->result_array();
			}else{
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `adrep_id` = '".$this->session->userdata('cId')."' AND (`id` LIKE '$search%' OR `advertiser_name` LIKE '$search%' OR `job_no` LIKE '$search%')")->result_array();
			}
			if($orders){ 
				$data['orders'] = $orders; 
				$this->load->view('client/myorders_v2', $data);
			}elseif($publication[0]['id']=='43' || $publication[0]['id']=='47' || $this->session->userdata('cId')=='36'){ //only desert shoppers & demo user
				$preorder = $this->db->query("SELECT * FROM `preorder` WHERE `accept`='0' AND (`job_name` LIKE '$search%' OR `advertiser` LIKE '$search%')")->result_array();
				if($preorder){ 
					$data['preorder'] = $preorder; 
					$this->load->view('client/preorders', $data);
				}else{ redirect('client/home/search_result'); }
			}else{
				redirect('client/home/search_result');
			}
		}
	}
	
	public function search_result()
	{
		$this->load->view('client/search_result');
	}
	
	public function sendfile_preorder($data) //new rplc create_folder($data)
	{
		$order = $this->db->get_where('orders',array('id' => $data['id']))->result_array();
		if($order)
		{
			if($order[0]['file_path']!='none'){
				$dir4 = $order[0]['file_path'];
				//file upload 
				for($i=0;$i<5;$i++)
				{
					if(isset($data['temp'.$i]) && isset($data['fname'.$i]))
					{
						$path= $dir4.'/'.$data['fname'.$i];
						if(!copy($data['temp'.$i], $path))
						{
							$this->session->set_flashdata("message","Error: ".$data['fname'.$i]." Upload Failed.. Try Again..");
							redirect('client/home/additional_file_uploads/'.$order[0]['id']);// additional file upload
							//redirect('client/home/preorders');
						}
					}
				}
				
			}else{
				$this->session->set_flashdata("message","File couldnt be uploaded! Please Try Again");
				redirect('client/home/additional_file_uploads/'.$order[0]['id']);
			}
		}else{
			$this->session->set_flashdata("message","Order details not found");
			redirect('client/home/additional_file_uploads/'.$order[0]['id']);// additional file upload
		}
	}
	
	public function help()
	{
		$this->load->view('client/help');
	}
	
	public function advanced_search()
	{
		$data['hi']="hello";
		if(isset($_POST['search'])){
			$client = $this->db->get_where('adreps',array('id' => $this->session->userdata('cId')))->result_array();
			$publication_id = $client[0]['publication_id'];
			$data['publication'] = $this->db->get_where('publications',array('id' => $client[0]['publication_id']))->result_array();
			
			$column_name = $_POST['column'];
			$id = $_POST['id'];
			//$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` = '".$_POST['id']."';")->result_array();
			if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
			{ 
				$from = $_POST['from_date'];
				$to = $_POST['to_date'];
				if(!empty($_POST['order_type']) || !empty($_POST['status'])){  
					if(!empty($_POST['order_type'])){ 
						$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` LIKE '$id%' AND `order_type_id` = '".$_POST['order_type']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `publication_id` = $publication_id ;")->result_array();
					}
					if($_POST['column']=='status'){ 
						$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` LIKE '$id%' AND `status` = '".$_POST['status']."' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `publication_id` = $publication_id ;")->result_array();
					}
				}else{ 
						$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` LIKE '$id%' AND (`created_on` BETWEEN '$from 00:00:00' AND '$to 23:59:59') AND `publication_id` = $publication_id ;")->result_array();
				}
				
			}else{ 
				if(!empty($_POST['order_type']) || !empty($_POST['status'])){ 
					if(!empty($_POST['order_type'])){ 
						$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` LIKE '$id%' AND `order_type_id` = '".$_POST['order_type']."' AND `publication_id` = $publication_id  ;")->result_array();
					}
					if($_POST['column']=='status'){ 
						$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` LIKE '$id%' AND `status` = '".$_POST['status']."' AND `publication_id` = $publication_id ;")->result_array();
					}
				}else{ 
					$orders = $this->db->query("SELECT * FROM `orders` WHERE `$column_name` LIKE '$id%' AND `publication_id` = $publication_id ;")->result_array();
				}
			}
			if($orders){ $data['orders']= $orders; }
			else{ 
				$this->session->set_flashdata("message","No order details found");
				redirect('client/home/advanced_search');
			}
			//$data['orders']='$orders';
		}
		$this->load->view('client/advanced_search', $data);
		
	}
	
	public function notification()
	{
		$data['hi'] = 'hello';
		$notifications = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1'")->result_array();
		$cId = $this->session->userdata('cId');
		$client = $this->db->get_where('adreps',array('id' => $cId))->row_array();
		$notification_list = $this->db->query("SELECT * FROM `notification` WHERE `job_status`='1' AND (`adrep`='$cId' OR `publication`='".$client['publication_id']."') ORDER BY `id` DESC")->result_array();
		if(isset($notification_list[0]['id'])){ $data['notification_list'] = $notification_list; }
		$this->load->view('client/notification', $data);
	}
	
	public function tester_mail() 
	{ 
	      $this->load->library('email'); 
		  $this->email->set_mailtype("html");
		  $this->email->from('ravikumar@adwitads.com'); // change it to yours
		  
		  $this->email->subject("Resume from JobsBuddy for your Job posting");
		  $body = '<a href="'.base_url().index_page().'csr/home/frontline_instruction/"><button>Attachments</button></a>';
		  $this->email->message($body);
		  //$this->email->attach('revision_downloads/unijobdemo20167_demoadvt20167_dm_182339_A_999_V1/beard-cake.jpg', '', 'cake.jpg');
		  
		  $this->email->to('ravikumar@adwitads.com');// change it to yours
		 if($this->email->send())
		 {
			echo 'Email sent.';
		 }
		 else
		{
			show_error($this->email->print_debugger());
		}
	}
	
	public function switch_newui() 
	{
		$adrep = $this->db->get_where('adreps', array('id '=> $this->session->userdata('cId'), 'new_ui' => '0'))->row_array();
		if(isset($adrep['id'])){
			$this->db->update('adreps',array('new_ui' => '1'), array('id' => $this->session->userdata('cId')));
			$status = $this->db->affected_rows();
			if($status == '1'){
				$this->session->sess_destroy();
				redirect('new_client/login');
			}else{
				$this->session->set_flashdata("message","Error Loading NewUI.. Try after sometime..!!");
				redirect('client/home');
			}
		}
	}
}