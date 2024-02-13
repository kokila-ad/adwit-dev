<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends hr_Controller {

	public function index()
	{
		$this->load->view('hr/homemet');
	}
	
	public function check()
	{
		$this->load->view('hr/cshift');
	}
	

	public function employees($status='')
	{	
			if($status=='1'){
				$data['employees']=$this->db->get_where('employees',array('isactive'=>'1'))->result_array();
			}elseif($status=='0'){
				$data['employees']=$this->db->get_where('employees',array('isactive'=>'0'))->result_array();
			}else{
				$data['employees']=$this->db->get('employees')->result_array();
			}
			$data['status']= $status;
			$this->load->view('hr/employees', $data);
	} 
		
		
	public function change($error = '', $color = 'darkred')
	{
		if($error) $data['error'] = $error;
		$data['color'] = $color;
		
		$this->load->view('hr/change',$data);
	}
	
	public function dochange()
	{
		$this->db->query("Update hr set password='".md5($this->input->post('new_password'))."' where (email_id='".$this->session->userdata('hr')."') and password='".md5($this->input->post('current_password'))."' and is_active='1' and is_deleted='0'");
		if($this->db->affected_rows())
			$this->change('Your password has been changed successfully!', 'darkgreen');
		else
			$this->change('Invalid current password!', 'darkred');
	}
	
	public function add_employee()
	{ 
		if(isset($_POST['submit']))
		{
			$data = array(
				'emp_name' => $_POST['emp_name'],
				'entity' => $_POST['entity'],
				'branch' => $_POST['branch'],
				'department'=> $_POST['department'],
				'designation' => $_POST['designation']
				);
				$this->db->insert('employees', $data);
				$empid = $this->db->insert_id();
			//details of emp	
			$post = array(
				'empid' => $empid,
				'empname' => $_POST['emp_name'],
				'branch' => $_POST['branch'],
				'designation' => $_POST['designation']
				);
			$this->db->insert('details_emp', $post);
			
			//details of emp_experience	
			$post1 = array(
				'empid' => $empid);
				$this->db->insert('emp_experience', $post1);
			
			//details of emp_otherdetails
			$post2 = array(
				'empid' => $empid);
				$this->db->insert('emp_otherdetails', $post2);
			$this->session->set_flashdata('message',"Employee added successfully");
			redirect('hr/home/employees');
		
		}
		$this->load->view('hr/add_employee');
		
		if(isset($_POST['DASHBOARD']))
		{
			$this->load->view('hr/homemet');
		}
	}

	public function edit_employees($id='')
	{ 	
		
		if(isset($_POST['update']))
		{
					$data = array(
						
						'empdob' => $_POST['empdob'],
						'fathername' => $_POST['fathername'],
						'gender' => $_POST['gender'],
						'nationality' => $_POST['nationality'],
						'marital_status' => $_POST['marital_status'],
						'contact_no' => $_POST['contact_no'],
						'present_addr' => $_POST['present_addr'],
						'permanent_addr' => $_POST['permanent_addr'],
						'personalemail_id' => $_POST['personalemail_id'],
						'spousename' => $_POST['spousename'],
						'childrenname' => $_POST['childrenname'],
						'educational_details' => $_POST['educational_details'],
						'language_proficiency' => $_POST['language_proficiency'],
						
					);
					$this->db->where('empid', $id);
					$this->db->update('details_emp',$data);
					
					$data1 = array(
						'organisation' => $_POST['organisation'],
						'role' => $_POST['role'],
						'from_dt' => $_POST['from_dt'],
						'to_dt' => $_POST['to_dt'],
					);
					$this->db->where('empid', $id);
					$this->db->update('emp_experience',$data1);
			
			if (!empty($_FILES['passbook']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['passbook']['tmp_name']; 
				$details['fname'] = $_FILES['passbook']['name'];
				$details['table_path'] = 'passbook_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['aadharcard']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['aadharcard']['tmp_name']; 
				$details['fname'] = $_FILES['aadharcard']['name'];
				$details['table_path'] = 'aadharcard_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['pancard']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['pancard']['tmp_name']; 
				$details['fname'] = $_FILES['pancard']['name'];
				$details['table_path'] = 'pancard_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['passport']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['passport']['tmp_name']; 
				$details['fname'] = $_FILES['passport']['name'];
				$details['table_path'] = 'passport_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['drivinglicense']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['drivinglicense']['tmp_name']; 
				$details['fname'] = $_FILES['drivinglicense']['name'];
				$details['table_path'] = 'drivinglicense_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['electioncard']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['electioncard']['tmp_name']; 
				$details['fname'] = $_FILES['electioncard']['name'];
				$details['table_path'] = 'electioncard_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['rationcard']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['rationcard']['tmp_name']; 
				$details['fname'] = $_FILES['rationcard']['name'];
				$details['table_path'] = 'rationcard_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			if (!empty($_FILES['esicard']['tmp_name']))
			{
				$details['ftemp'] = $_FILES['esicard']['tmp_name']; 
				$details['fname'] = $_FILES['esicard']['name'];
				$details['table_path'] = 'esicard_path';
				$details['empid'] = $id;
				$this->upload($details);
			}
			
			
			$data_exp = array('organisation'=>$_POST['organisation']);
			$this->db->where('empid', $id);
			$this->db->update('emp_experience',$data_exp);
			
			redirect('hr/home/employees');
		}
		$data['details_emp']=$this->db->get_where('details_emp',array('empid'=>$id))->result_array();
		$data['emp_experience']=$this->db->get_where('emp_experience',array('empid'=>$id))->result_array();
		$data['emp_otherdetails']=$this->db->get_where('emp_otherdetails',array('empid'=>$id))->result_array();
		$this->load->view('hr/edit_employees',$data);
	}	
	
	
		public function view_employees($id='')
	{ 
		$data['details_emp']=$this->db->get_where('details_emp',array('empid'=>$id))->result_array();
		$data['emp_experience']=$this->db->get_where('emp_experience',array('empid'=>$id))->result_array();
		$data['emp_otherdetails']=$this->db->get_where('emp_otherdetails',array('empid'=>$id))->result_array();
		$this->load->view('hr/view_employees',$data);
	}

		
	
	public function deactivate($id='')
	{ 
			if(isset($_POST['submit']))
		{
			$data = array(
				'dor' => $_POST['dor'],
				'isactive'=>'0'
				);
			$this->db->where('empid', $id);
			$this->db->update('details_emp', $data);
			$this->session->set_flashdata('message',"Updated");
			redirect('hr/home/employees');
		
		}
				$this->load->view('hr/deactivate');
	}
	
	
	public function upload($details)
	{ 
			if (!empty($details['ftemp']))
			{
					$dir = "emp_documents/".$details['empid'];
					if (@mkdir($dir,0777))
					{

					}
					$path= $dir.'/'.$details['fname'];
						
					if(!copy($details['ftemp'], $path))
					{
						echo "<script>alert('Error: " . $details['ftemp']["error"] ."')</script>";
					}else{ 
						
						$post = array( $details['table_path'] => $path );		//save file path to cat_result table
						$this->db->where('empid', $details['empid']);
						$this->db->update('emp_otherdetails', $post);
					}
			} 
					
	}
		
	public function upload01($field, $empid)
	{ 
			
					$dir = "emp_documents/".$empid;
					if (@mkdir($dir,0777))
					{

					}
					$path= $dir.'/'.$_FILES['userfile']['name'];
						
					if(!copy($_FILES['userfile']['tmp_name'], $path))
					{
						echo "<script>alert('Error: " . $_FILES['userfile']['tmp_name']["error"] ."')</script>";
					}else{ 
						
						$post = array( $field => $path );		//save file path to cat_result table
						$this->db->where('empid', $empid);
						$this->db->update('emp_otherdetails', $post);
					}
		redirect('hr/home/edit_employees/'.$empid);	
					
	}	
	
	
}

		
	
