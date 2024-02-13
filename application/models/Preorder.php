<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preorder extends CI_Model  
{  
      var $table = "preorders_waukesha";  
      var $select_column = array("preorders_waukesha.id", "preorders_waukesha.ad_number", "preorders_waukesha.customer_name", "preorders_waukesha.user", "preorders_waukesha.adtitle", "preorders_waukesha.width", "preorders_waukesha.height", "preorders_waukesha.run_date", "preorders_waukesha.accept", "preorders_waukesha.account_number");  
      //var $order_column = array("id", "ad_number", null, null, "adtitle", "width", "height");  
      //DATE_FORMAT(run_date,'%m-%d-%Y')
      var $order_column = array("ad_number", "customer_name", "user", "adtitle", "account_number", "ad_number", "DATE_FORMAT(`run_date`, '%m%d%Y')", "width", "height");
      function make_query()  
      {  
          //$xml_file_data = $this->db->query("SELECT * from `preorders_waukesha` WHERE `accept`='0' ORDER BY `id` DESC ;")->result_array();
           $this->db->select($this->select_column);  
           $this->db->from($this->table);
           //$this->db->join('preorders_waukesha_publication','preorders_waukesha_publication.xml_file_data_id = preorders_waukesha.id');	
           $this->db->where("preorders_waukesha.accept", '0'); 
           if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]))  
           { 
               $this->db->group_start(); //group by adding '('
                $this->db->like("preorders_waukesha.ad_number", $_POST["search"]["value"]);  
                $this->db->or_like("preorders_waukesha.adtitle", $_POST["search"]["value"]);
                $this->db->or_like("preorders_waukesha.customer_name", $_POST["search"]["value"]);
                $this->db->or_like("preorders_waukesha.user", $_POST["search"]["value"]);
                $this->db->group_end(); //end group by adding ')'
           }  
           if(isset($_POST["order"])){  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }else{  
                $this->db->order_by('preorders_waukesha.id', 'DESC');  
           }  
      } 
      
      function make_datatables()
      {  
           $this->make_query();
           
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result_array();  
      } 
      
      function get_filtered_data(){  
           $this->make_query();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }
      
      function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);
           $this->db->where("accept", '0'); 
           return $this->db->count_all_results();  
      }  
 }  


?>