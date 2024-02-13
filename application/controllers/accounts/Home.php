<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Accounts_Controller {

	public function index()
	{
		$this->load->view('accounts/homemet');
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
			$data['status'] = $status;
			$this->load->view('accounts/employees', $data);
	} 
	
	public function view_employees($id='')
	{ 
		$data['details_emp']=$this->db->get_where('details_emp',array('empid'=>$id))->result_array();
		$data['emp_experience']=$this->db->get_where('emp_experience',array('empid'=>$id))->result_array();
		$data['emp_otherdetails']=$this->db->get_where('emp_otherdetails',array('empid'=>$id))->result_array();
		$this->load->view('accounts/view_employees',$data);
	}
	
	public function publication($id='')
	{
		$customer = $this->db->get_where('customers',array('id'=>$id))->result_array();	
		$data['publication'] = $this->db->get_where('publications',array('customer'=>$customer[0]['id']))->result_array();
		$data['customer']=$customer[0];
		
		$this->load->view('accounts/publication',$data);	
	}
	public function invoice_creation($group_id='', $publication_id='')
	{	
		$month = date('Y-m',strtotime(date('Y-m')."-1 m"));		
		$group_list = $this->db->query("SELECT DISTINCT `group_id` FROM `billing` WHERE month='$month';")->result_array();
		$data['group_list'] = $group_list;
		if($group_id != '')
		{	
			$data['publication_list'] = $this->db->get_where('publications',array('group_id'=>$group_id))->result_array();
		}
		/* elseif($group_id != '')
		{
		}	 */
		$data['group_id'] = $group_id;
		$this->load->view('accounts/invoice_creation',$data);
		
	}
	
	public function groupbillinglist()
	{
		$month = date('Y-m',strtotime(date('Y-m')."-1 m"));		
		$data['group_list'] = $this->db->query("SELECT DISTINCT `group_id` FROM `billing` WHERE month='$month';")->result_array();
		$this->load->view('accounts/groupbillinglist',$data);	
	}
	
	public function billing_homepage1()
	{
		$period1 = date('Y-m',strtotime(date('Y-m')."-1 m"));
	
		$data['billable'] = $this->db->query("SELECT * FROM `billing` WHERE month LIKE '$period1%' AND (`status` = '6' OR `status` = '1') ;")->result_array(); 
	
		
		$this->load->view('accounts/billing_homepage1',$data);	
	}
	public function publication_list($gid='')
	{
		$data['group_list'] = $this->db->query("SELECT * FROM `Group` WHERE `id`='$gid' ;")->result_array();
		$data['publication_list'] = $this->db->query("SELECT * FROM `publications` WHERE `group_id`='$gid';")->result_array();
		$this->load->view('accounts/publication_list',$data);	
	}
	
	function billing_homepage()
{
	$period1 = date('Y-m',strtotime(date('Y-m')."-1 m"));
	$data['billable'] = $this->db->query("SELECT * FROM `billing` WHERE month LIKE '$period1%' AND (`status` = '6' OR `status` = '1') ;")->result_array(); 
	$data['pending_payments'] = $this->db->query("SELECT * FROM `billing` WHERE `status` = '7';")->result_array(); 
	$data['received_payments'] = $this->db->query("SELECT * FROM `billing` WHERE `status` = '3';")->result_array(); 
	$data['bill_completed'] = $this->db->query("SELECT * FROM `billing` WHERE `status` = '5';")->result_array(); 
	if(isset($_POST['update']))
	{
		$month = $period1;
		$group_details = $this->db->query("SELECT `id` FROM `Group` WHERE `billing_system`='1' AND (`billing_effective_date` < '$month');")->result_array();
		$query = $this->db->query("SELECT * FROM `billing`; ")->result_array();
		foreach($group_details as $row)
		{
			$group_id = $row['id'];
			$billing = $this->db->query("SELECT `id` FROM `billing` WHERE `group_id`='$group_id' AND `month` = '$month';")->num_rows();
			
			if($billing == '0'){
				$publication_id = $this->db->query("SELECT * FROM `publications` WHERE `group_id` = $group_id ;")->result_array();
				foreach($publication_id as $row2){
				$data = array(
							'publication_id' => $row2['id'],
							'month' => $month,
							'status' => '6',
							'group_id' => $group_id,
							);
							$this->db->insert('billing',$data);
				}
			}
				
		}
		redirect('accounts/home/billing_homepage');
	}
	$this->load->view('accounts/billing_homepage',$data);
}

	public function month_selection($gid='',$publication_id='', $updated='')
	{	
		$data['group_list'] = $this->db->query("SELECT * FROM `Group` WHERE `id`='$gid' ;")->result_array();
		$data['publication_name'] = $this->db->get_where('publications',array('id'=>$publication_id))->result_array();
		$latest_date='0';
		$query = $this->db->query("SELECT `date` FROM `invoice` WHERE `publication_id`='$publication_id' ;")->last_row();
		foreach($query as $row)
		{
			
			$latest_date=$row;	
		}
		$data['latest_date1'] = $latest_date ;
		$data['price'] = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$publication_id))->result_array();
		$data['date1'] = date("Y-m");
		$data['pdate'] = date("Y-m", strtotime("-1 month"));
		$inv_amt = '0';
		$data['period'] = $this->db->query("SELECT * FROM `billing` WHERE `publication_id`='$publication_id' AND `inv_id` = '0';")->result_array();
		
		$data['invoice_details'] = $this->db->query("SELECT * FROM `billing` WHERE `publication_id`='$publication_id' AND `status`='1';")->result_array();
		if(isset($_POST['month']))
		{	
			$date = $_POST['month'];
			$billing = $this->db->query("SELECT * FROM `billing` WHERE `publication_id`='$publication_id' AND `month` = '$date';")->result_array();
			$data['billing_id'] = $billing[0]['id'];
			$data['date'] = $date;
			$data['publication_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='$publication_id' AND (`created_on` LIKE '$date%') ;")->result_array();		
			$query_invoice = $this->db->query("SELECT * FROM `invoice` WHERE `publication_id`='$publication_id' ORDER BY `id` DESC LIMIT 1;")->result_array();
			if($query_invoice)
			{
			$data['inv_amt1'] = $query_invoice[0]['invoice_no1'];
			}
			$this->load->view('accounts/billing_orders', $data);
		}
		elseif ($updated != '')
		{
			$date = $updated;
			$data['date'] = $date;
			$data['publication_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='$publication_id' AND (`created_on` LIKE '$date%') ;")->result_array();		
			$this->load->view('accounts/billing_orders', $data);
		}	
		else
		{
			$this->load->view('accounts/month_selection',$data);
		}
	}
	
	public function invoice($id='',$publication_id='')
	{
		
		$data['group_list'] = $this->db->query("SELECT * FROM `Group` WHERE `id`='$id' ;")->result_array();
		$data['publication_name'] = $this->db->get_where('publications',array('id'=>$publication_id))->result_array();
		$inv_id = '0';
		$data['price'] = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$publication_id))->result_array();
		if(isset($_POST['generate_bill']))
		{
			$billing_id = $_POST['billing_id'];
			$invoice_no = $_POST['invoice_no'];
			$inv_inc = $_POST['inv_inc'];
			$ad_count = $_POST['ad_count'];
			$total_sqinches = $_POST['total_sqinches'];
			$inv_amount = $_POST['inv_amount'];
			$special_discount = $_POST['special_discount'];
			$sub_total = $_POST['sub_total'];
			$desc = $_POST['desc'];
			$total_due = $_POST['total_due'];
			$date = $_POST['date'];
			$data1 = array( 
			'publication_id' => $publication_id,
			'customer_id' => $id,
			'invoice_no' => $invoice_no,
			'invoice_no1' => $inv_inc,
			'quantity' => $ad_count,
			'total_sq_inches' => $total_sqinches,
			'total_usd' => $inv_amount,
			'special_discount' => $special_discount,
			'sub_total' => $sub_total,
			'desc' => $desc,
			'total_due' => $total_due,
			'billing_status' => '2',
			'time' => date('y-m-d H-i-s'),
			'account_id' => '1',
			'date' => $date,
			); 
			
		$this->db->insert('invoice', $data1);
		$inv_id = $this->db->insert_id();
		
		
			 $data2 = array(
			'inv_id' => $inv_id,
			'status' => '1');
			$this->db->where('id', $billing_id);
			$this->db->update('billing',$data2);
			
			
			$order_id = unserialize(base64_decode($_POST['string']));
			foreach($order_id as $row)
			{
				$data3 = array(
				'inv_id' => $inv_id
				);
				$this->db->where('id', $row['id']);
				$this->db->update('orders',$data3);
			} 
			
			
			
			
		}
		$data['inv_id'] = $inv_id;
		$data['invoice_no'] = $invoice_no;
		$data['inv_inc'] = $inv_inc;
		$data['invoice_details'] = $this->db->query("SELECT * FROM `invoice` WHERE `id`='$inv_id';")->result_array();
		
		$this->load->view('accounts/invoice',$data);
		
		
		
	}
	
	public function invoice_to_customers($publication_id='',$date='')
	{
		$data['publication_name'] = $this->db->get_where('publications',array('id'=>$publication_id))->result_array();
		$invoice_details = $this->db->query("SELECT * FROM `invoice` WHERE `date`= '$date';")->result_array(); 
		$data['invoice_details'] = $this->db->query("SELECT * FROM `invoice` WHERE `date`= '$date';")->result_array(); 

		 if(isset($_POST['bill']))
		{	
			
			$data1 = array(
				'status' => '7'
			);
			$this->db->where('inv_id', $invoice_details[0]['id']);
			$this->db->update('billing',$data1);
		} 
		$this->load->view('accounts/invoice_to_customers',$data);
	}
	
		
	public function view_invoice($invoice_no='',$invoice_no1='')
	{	
		$data['invoice_details'] = $this->db->query("SELECT * FROM `invoice` WHERE `invoice_no`='$invoice_no' AND `invoice_no1`='$invoice_no1';")->result_array();
		$this->load->view('accounts/view_invoice',$data);
	}
		
	public function edit_orders($id='',$publication_id='',$id1='')
	{	
		$data['group_list'] = $this->db->query("SELECT * FROM `Group` WHERE `id`='$id' ;")->result_array();
		$data['publication_name'] = $this->db->query("SELECT * FROM `publications` WHERE `id`='$publication_id' ;")->result_array();
		$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `id`='$id1';")->result_array();		
		$period = $this->db->get_where('orders',array('id'=>$id1))->result_array();	
		$month = date('Y-m', strtotime($period[0]['created_on']));
		
		if(isset($_POST['update']))
		{
					$data1 = array(
						
						'width' => $_POST['width'],
						'height' => $_POST['height'],
						
					);
					$this->db->where('id', $id1);
					$this->db->update('orders',$data1);
					redirect('accounts/home/month_selection/'.$id.'/'.$publication_id.'/'.$month);	
						
		}
		
		$this->load->view('accounts/edit_orders',$data);
		
	}
	
	public function detailed_invoice($id='')
	{
		$data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `inv_id`='$id';")->result_array();
		$this->load->view('accounts/detailed_invoice',$data);
	}	
// recursive fn, converts three digits per pass
public function convertTri($num, $tri) {$ones = array(
 "",
 " one",
 " two",
 " three",
 " four",
 " five",
 " six",
 " seven",
 " eight",
 " nine",
 " ten",
 " eleven",
 " twelve",
 " thirteen",
 " fourteen",
 " fifteen",
 " sixteen",
 " seventeen",
 " eighteen",
 " nineteen"
);
 
$tens = array(
 "",
 "",
 " twenty",
 " thirty",
 " forty",
 " fifty",
 " sixty",
 " seventy",
 " eighty",
 " ninety"
);
 
$triplets = array(
 "",
 " thousand",
 " million",
 " billion",
 " trillion",
 " quadrillion",
 " quintillion",
 " sextillion",
 " septillion",
 " octillion",
 " nonillion"
);
 
  //global $ones, $tens, $triplets;
 
  // chunk the number, ...rxyy
  $r = (int) ($num / 1000);
  $x = ($num / 100) % 10;
  $y = $num % 100;
 
  // init the output string
  $str = "";
 
  // do hundreds
  if ($x > 0)
   $str = $ones[$x] . " hundred";
 
  // do ones and tens
  if ($y < 20)
   $str .= $ones[$y];
  else
   $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];
 
  // add triplet modifier only if there
  // is some output to be modified...
  if ($str != "")
   $str .= $triplets[$tri];
 
  // continue recursing?
  if ($r > 0)
   return convertTri($r, $tri+1).$str;
  else
   return $str;
 }
 
// returns the number as an anglicized string
public function convertNum($num) {
 $num = (int) $num;    // make sure it's an integer
 
 if ($num < 0)
  return "negative".convertTri(-$num, 0);
 
 if ($num == 0)
  return "zero";
 
 return $this->convertTri($num, 0);
}
 
 // Returns an integer in -10^9 .. 10^9
 // with log distribution
public function makeLogRand()
 {
  $sign = mt_rand(0,1)*2 - 1;
  $val = randThousand() * 1000000
   + randThousand() * 1000
   + randThousand();
  $scale = mt_rand(-9,0);
 
  return $sign * (int) ($val * pow(10.0, $scale));
 }
	
function display(){

$CI = &get_instance();
$this->db2 = $CI->load->database('accounts', TRUE);
$query = $this->db2->get('publication_price_list')->result_array();
foreach($query as $row)
{
	echo $row['id'];
}
$group_list = $this->db->query("SELECT * FROM `Group` ;")->result_array();
foreach($group_list as $row)
		{
			echo $row['id'];
		}
		

}


public function pending_payments()
{
	$data['pending_payments'] = $this->db->query("SELECT * FROM `billing` WHERE `status`='7';")->result_array();
	
	$this->load->view('accounts/pending_payments',$data);
}	
public function pending_inv_view($id='')
{
	$data['invoice_details'] = $this->db->query("SELECT * FROM `invoice` WHERE `id`='$id';")->result_array();
	if(isset($_POST['payment_received']))
	{
			
			$message = "Confirm?";
			echo '<script>
					alert("'.str_replace(array("/r","/n"),'',$message).'");
					</script>';
			
				$data1 = array(
				'status' => '3'
			);
			$this->db->where('inv_id', $id);
			$this->db->update('billing',$data1);
				
					
			//redirect('accounts/home/billing_homepage');
	}
	
	$this->load->view('accounts/pending_inv_view',$data);
}	

public function received_payments()
{
	$data['received_payments'] = $this->db->query("SELECT * FROM `billing` WHERE `status`='3';")->result_array();
	
	$this->load->view('accounts/received_payments',$data);
}	
public function received_inv_view($id='')
{
	$data['invoice_details'] = $this->db->query("SELECT * FROM `invoice` WHERE `id`='$id';")->result_array();
	if(isset($_POST['bill_completed']))
	{
			
			$message = "Confirm?";
			echo '<script>
					alert("'.str_replace(array("/r","/n"),'',$message).'");
					</script>';
			
				$data1 = array(
				'status' => '5'
			);
			$this->db->where('inv_id', $id);
			$this->db->update('billing',$data1);
				
					
			//redirect('accounts/home/billing_homepage');
	}
	
	$this->load->view('accounts/received_inv_view',$data);
}	

public function bill_completed()
{
	$data['bill_completed'] = $this->db->query("SELECT * FROM `billing` WHERE `status`='5';")->result_array();
	
	$this->load->view('accounts/bill_completed',$data);
}	
public function completed_inv_view($id='')
{ 
	$data['invoice_details'] = $this->db->query("SELECT * FROM `invoice` WHERE `id`='$id';")->result_array();
	
	$this->load->view('accounts/completed_inv_view',$data);
}	
public function billing_orders_pdf($publication_id='',$date='')
{
	$this->load->helper('pdf_helper');
	$data['price'] = $this->db->get_where('price_per_sq_inches',array('publication_id'=>$publication_id))->result_array();
	$data['publication_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `publication_id`='$publication_id' AND (`created_on` LIKE '$date%') ;")->result_array();		
	$this->load->view('accounts/billing_orders_pdf',$data);
}	
public function invoice_pdf($inv_id='')
{
	/*$this->load->library('pdf');
	$this->pdf->load_view('accounts/invoice.html');
 //$this->load->view('accounts/invoice.html');
	$this->pdf->render();
	$this->pdf->stream("welcome.pdf");
	*/
	$this->load->library('dompdf');
	$dompdf = new DOMPDF();

	//$html = $this->load->view('accounts/invoice.html');
	$dompdf->load_html("Hello World");
	$dompdf->render();
	$dompdf->stream("test.pdf");
}	

public function new_invoice_pdf($invoice_id='')
{
	$this->load->helper('pdf_helper');
	$inv_id= $this->db->get_where('invoice',array('id'=>$invoice_id))->result_array();
	$num = $inv_id[0]['total_due'];
	$data['inv_amount'] = $this->convertNum($num);
	$data['inv_id'] = $inv_id;
	$data['publication_orders'] = $this->db->get_where('orders',array('inv_id'=>$invoice_id))->result_array();
	$this->load->view('accounts/new_invoice_pdf',$data);
}	

public function invoice_excel($inv_id='')
{
	
	$data['inv_id'] = $this->db->get_where('invoice',array('id'=>$inv_id))->result_array();
	$data['publication_orders'] = $this->db->get_where('orders',array('inv_id'=>$inv_id))->result_array();
	$this->load->view('accounts/invoice_excel',$data);
}	
public function pdfreport()
{
	$this->load->helper('pdf_helper');
	$this->load->view('accounts/pdfreport');
}	
}

		
	
	
