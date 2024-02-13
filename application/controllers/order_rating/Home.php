<?php

class Home extends CI_Controller {

	public function index()
	{
		redirect(base_url());
	}
	
	public function new_order_rating($order_id = 0)
	{ 
	    $this->load->library('Encryption');
	    
		$order_id = $this->encryption->decrypt($order_id);
		$order = $this->db->get_where('orders',array('id' => $order_id))->result_array();
		
		$check = $this->db->get_where('order_rating',array('order_id'=>$order_id))->result_array();
		if(isset($check[0]['id'])){ $data['order_rating']= $check[0]; }
		
		if(isset($order[0]['id'])){
			$data['order_id'] = $order[0]['id'];
			$data['pdf_file'] = $order[0]['pdf'];
			
			if(isset($_POST['submit']) && !empty($_POST['rating'])){
				//$check = $this->db->get_where('order_rating',array('order_id'=>$order_id))->result_array();
				$ip = $this->input->ip_address();
				
				if(isset($check[0]['id'])){
					$data = array('rating' => $_POST['rating'], 'ip' => $ip, 'comment' => $_POST['comment']);
					$this->db->where('id', $check[0]['id']);
					$this->db->update('order_rating', $data);
				}else{
					$data = array(  'order_id' => $order_id,
									'rating' => $_POST['rating'],
									'ip' => $ip,
									'comment' => $_POST['comment']
								);
					$this->db->insert('order_rating', $data);
				}
				$this->session->set_flashdata("message","Thank you for rating the ad");
				redirect('order_rating/home/new_order_rating/'.$this->encryption->encrypt($order_id));
			}
			$data['order']= $order[0];
			$this->load->view('order_rating', $data);
		}
	}
	
	public function rev_order_rating($rev_id = 0)
	{ 
	    $this->load->library('Encryption');
		$rev_id = $this->encryption->decrypt($rev_id);
		$rev_order = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->result_array();
		
		$check = $this->db->get_where('order_rating',array('rev_id'=>$rev_id))->result_array();
		if(isset($check[0]['id'])){ $data['order_rating']= $check[0]; }
		
		if(isset($rev_order[0]['id'])){
			$data['order_id'] = $rev_order[0]['order_id'];
			$data['pdf_file'] = $rev_order[0]['pdf_path'];
			
			if(isset($_POST['submit']) && !empty($_POST['rating'])){
				
				$ip = $this->input->ip_address();
				
				if(isset($check[0]['id'])){
					$data = array('rating' => $_POST['rating'], 'ip' => $ip, 'comment' => $_POST['comment']);
					$this->db->where('id', $check[0]['id']);
					$this->db->update('order_rating', $data);
				}else{
					$data = array(  'rev_id' => $rev_id,
									'rating' => $_POST['rating'],
									'ip' => $ip,
									'comment' => $_POST['comment']
								);
					$this->db->insert('order_rating', $data);
				}
				$this->session->set_flashdata("message","Thank you for rating the ad");
				redirect('order_rating/home/rev_order_rating/'.$this->encryption->decrypt($rev_id));
			}
			$data['rev_order']= $rev_order[0];
			$this->load->view('order_rating', $data);
		}
	}
	
	public function sucess(){
		$this->load->view('order_rating');
	}
}

?>