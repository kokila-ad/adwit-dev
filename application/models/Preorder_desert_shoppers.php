<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preorder_desert_shoppers extends CI_Model  
{  
      var $table = "preorders_desert_shoppers";  
      var $select_column = array("preorders_desert_shoppers.id", "preorders_desert_shoppers.ad_number", "preorders_desert_shoppers.customer_name", "preorders_desert_shoppers.user", "preorders_desert_shoppers.adtitle", "preorders_desert_shoppers.width", "preorders_desert_shoppers.height", "preorders_desert_shoppers.run_date", "preorders_desert_shoppers.accept", "preorders_desert_shoppers.account_number");  
      var $order_column = array("id", "ad_number", null, null, "adtitle", "width", "height");  
      
      function make_query()  
      {  
          //$xml_file_data = $this->db->query("SELECT * from `preorders_desert_shoppers` WHERE `accept`='0' ORDER BY `id` DESC ;")->result_array();
           $this->db->select($this->select_column);  
           $this->db->from($this->table);
           //$this->db->join('preorders_desert_shoppers_publication','preorders_desert_shoppers_publication.xml_file_data_id = preorders_desert_shoppers.id');	
           $this->db->where("preorders_desert_shoppers.accept", '0'); 
           if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]))  
           { 
               $this->db->group_start(); //group by adding '('
                $this->db->like("preorders_desert_shoppers.ad_number", $_POST["search"]["value"]);  
                $this->db->or_like("preorders_desert_shoppers.adtitle", $_POST["search"]["value"]);
                $this->db->or_like("preorders_desert_shoppers.customer_name", $_POST["search"]["value"]);
                $this->db->or_like("preorders_desert_shoppers.user", $_POST["search"]["value"]);
                $this->db->or_like("preorders_desert_shoppers.width", $_POST["search"]["value"]);
                $this->db->group_end(); //end group by adding ')'
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('preorders_desert_shoppers.id', 'DESC');  
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