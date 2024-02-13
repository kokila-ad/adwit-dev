<?php

class Home extends CI_Controller {
	
	public function index(){
		echo"hello";
	}

	public function order($action)
	{
	    //contents from json data
	    $myJson = file_get_contents("php://input");
        $myArray = json_decode($myJson, true);
        
	    $order_id = $myArray['order_id'];
	    if($action == 'getstatus'){
	        $order_details = $this->db->query("SELECT order_status.name AS order_status_name FROM `orders`
	                                        JOIN order_status ON order_status.id = orders.status
	                                        WHERE orders.id = '$order_id'")->row_array();
    	    if(isset($order_details['order_status_name'])){
    	        $send_status = json_encode($order_details['order_status_name']);
    	        echo $send_status;
    	    }else{
    	        echo 'order details not found';
    	    }  
	    }elseif($action == 'downloadasset'){
	        $order_details = $this->db->query("SELECT orders.pdf FROM `orders`
	                                            WHERE orders.id = '$order_id' AND orders.pdf != 'none'")->row_array();
    	    if(isset($order_details['pdf'])){
    	        $order_rev = $this->db->query("SELECT rev_sold_jobs.pdf_path FROM rev_sold_jobs 
    	                                        WHERE rev_sold_jobs.order_id = '$order_id' AND rev_sold_jobs.pdf_path != 'none' ORDER BY rev_sold_jobs.id DESC LIMIT 1")->row_array();
    	        if(isset($order_rev['pdf_path'])){
    	            $pdf = $order_rev['pdf_path'];
    	        }else{
    	            $pdf = $order_details['pdf'];
    	        }
    	        if(file_exists($pdf)){
    	            $link = base_url().index_page().$pdf;    
    	        }else{
    	            echo 'order pdf not found';
    	        }
    	        $send_status = $link;
    	        echo $send_status;
    	    }else{
    	        echo 'order asset not found';
    	    } 
	    }
	}
	
}

?>