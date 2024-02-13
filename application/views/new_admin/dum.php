public function cshift_order_search()
{
if(isset($_POST['search']) && !empty($_POST['search_id'])){
$search_id = $_POST['search_id'];
$orders = $this->db->get_where('orders', array('id' => $search_id))->result_array();
if(isset($orders[0]['id']) && $orders[0]['id'] == $search_id){
$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$search_id' ORDER BY `id` DESC LIMIT 1;")->result_array();
if($rev_orders){
redirect('new_csr/home/orderview/'.$orders[0]['help_desk'].'/'.$orders[0]['id']);
}else{
redirect('new_csr/home/orderview/'.$orders[0]['help_desk'].'/'.$orders[0]['id']);
}
}else{
$this->session->set_flashdata("message","Order not Found!!");
redirect('new_csr/home/cshift');
}
}
}