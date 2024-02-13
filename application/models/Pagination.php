<?php
class Pagination extends CI_Model
{
   public function __construct() {
       parent::__construct();
   }
   #get categorise ad starts here
   public function get_categorise_ad_count($club_id,$search=null) {
    $query ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.adrep_id, orders.order_type_id, orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name, time_zone.priority AS time_zone_priority,publications.name, adreps.first_name,orders.page_design_id	
    FROM `live_orders`
    RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    JOIN `publications` ON publications.id = orders.publication_id
    join `adreps` ON adreps.id = orders.adrep_id
    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    WHERE live_orders.club_id IN $club_id AND live_orders.status = '1' AND live_orders.crequest != '1'  AND orders.cancel != '1'";
     if($search != null){
        $query .=" AND (
            live_orders.job_no LIKE '%$search%'
            OR live_orders.order_id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )";
    }
       return $this->db->query($query)->num_rows();
   }
   
   public function get_categorise_ad($limit, $start,$club_id,$sort_by,$order_by,$search=null) {
    
    $sql ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, 
    live_orders.pro_status, live_orders.club_id, orders.adrep_id, orders.order_type_id, orders.rush, orders.created_on, orders.question, orders.help_desk, orders.advertiser_name, 
    time_zone.priority AS time_zone_priority, publications.name, adreps.first_name, orders.page_design_id
    FROM `live_orders`
    RIGHT JOIN `orders` ON orders.id = live_orders.order_id
    JOIN `publications` ON publications.id = orders.publication_id
    join `adreps` ON adreps.id = orders.adrep_id
    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    WHERE live_orders.club_id IN $club_id AND live_orders.status = '1' AND live_orders.crequest != '1'  AND orders.cancel != '1'";

    if($search != null){
        $sql .=" AND (
            live_orders.job_no LIKE '%$search%'
            OR live_orders.order_id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )";
    }
      //sort by column starts here
    
    if(($sort_by != null && $order_by != null) || (($this->session->userdata("c_order_by") != "") && ($this->session->userdata("c_sort_by") != ""))){
           if($this->session->userdata("c_order_by")){
                $order_by = $this->session->userdata("c_order_by");
            }
            if($this->session->userdata("c_sort_by")){
                $sort_by = $this->session->userdata("c_sort_by");
            }
             if($order_by == "created_on"){
                $sql .= " ORDER BY  orders.created_on $sort_by"; 
            }else if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "order_id"){
                $sql .= " ORDER BY  live_orders.order_id $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }else if($order_by == "adreps"){
                $sql .= " ORDER BY adreps.first_name $sort_by";
            }
        }
    // sort by column ends here
    
    $sql .=" LIMIT $start, $limit;";
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
   #get categorise ad ends here

   # get new pending ads starts here
   public function get_newpending_ad_count($club_id,$cat_series,$search=null) {
    $query ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, 
    live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.order_type_id, orders.advertiser_name, 
    orders.rush, orders.adrep_id, orders.question, orders.help_desk, orders.created_on, orders.status, time_zone.priority AS time_zone_priority,publications.name,adreps.first_name,orders.page_design_id
            FROM `live_orders`
            RIGHT JOIN `orders` ON orders.id = live_orders.order_id
            JOIN `publications` ON publications.id = orders.publication_id
            join `adreps` ON adreps.id = orders.adrep_id
            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
            WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status BETWEEN '1' AND '4' 
            AND live_orders.crequest != '1'";
     if($search != null){
        $query .=" AND (
            live_orders.job_no LIKE '%$search%'
            OR live_orders.order_id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )"; 
    }
   
       return $this->db->query($query)->num_rows();
   }
   public function get_newpending_ad($limit, $start,$club_id,$cat_series,$sort_by,$order_by,$search=null) {
    
    $sql ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, 
    live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, orders.order_type_id, orders.advertiser_name, 
    orders.rush, orders.adrep_id, orders.question, orders.help_desk, orders.created_on, orders.status, time_zone.priority AS time_zone_priority,publications.name,
    adreps.first_name,orders.page_design_id, orders_type.value
            FROM `live_orders`
            RIGHT JOIN `orders` ON orders.id = live_orders.order_id
            JOIN `publications` ON publications.id = orders.publication_id
            join `adreps` ON adreps.id = orders.adrep_id
            JOIN `orders_type` ON orders_type.id = orders.order_type_id
            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
            WHERE live_orders.club_id IN $club_id AND live_orders.category IN ($cat_series) AND live_orders.status BETWEEN '1' AND '4' 
            AND live_orders.crequest != '1'";

    if($search != null){
        $sql .=" AND (
            live_orders.job_no LIKE '%$search%'
            OR live_orders.order_id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )";
    }
    
     //sort by column starts here
    
    if(($sort_by != null && $order_by != null) || (($this->session->userdata("n_order_by") != "") && ($this->session->userdata("n_sort_by") != ""))){
           if($this->session->userdata("n_order_by")){
                $order_by = $this->session->userdata("n_order_by");
            }
            if($this->session->userdata("n_sort_by")){
                $sort_by = $this->session->userdata("n_sort_by");
            }
            if($order_by == "created_on"){
                $sql .= " ORDER BY  orders.created_on $sort_by"; 
            }else if($order_by == "type"){ 
                $sql .= " ORDER BY orders_type.value $sort_by"; 
            }else if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "order_id"){
                $sql .= " ORDER BY  live_orders.order_id $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }else if($order_by == "adreps"){
                $sql .= " ORDER BY adreps.first_name $sort_by";
            }
        }
    // sort by column ends here
    $sql .=" LIMIT $start, $limit;";
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
    # get new pending ads ends here
    
    
     # get metro send ads starts here
   public function get_metrosend_ad_count($form,$ystday,$today,$search=null) {
    $query ="SELECT A.order_id, A.sent, P.order_type_id, P.publication_id, P.adrep_id, P.status, P.created_on, P.id, P.rush, P.job_no, P.question,publications.name,adreps.first_name FROM `metro_sent_ads` AS A
					left outer join `orders` AS P on P.id = A.order_id
					LEFT join publications on publications.id = P.publication_id
					LEFT join adreps on adreps.id = P.adrep_id
					WHERE P.status='5' AND P.help_desk='".$form."' AND A.sent='0' AND (`timestamp` BETWEEN '$ystday' AND '$today')";
     if($search != null){
        $query .=" AND (
             P.job_no LIKE '%$search%'
            OR A.order_id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )"; 
    }
       return $this->db->query($query)->num_rows();
   }
   public function get_metrosend_ad($limit, $start,$form,$ystday,$today,$search=null) {
  
    $sql ="SELECT A.order_id, A.sent, P.order_type_id, P.publication_id, P.adrep_id, P.status, P.created_on, P.id, P.rush, P.job_no, P.question,publications.name,adreps.first_name FROM `metro_sent_ads` AS A
					left outer join `orders` AS P on P.id = A.order_id
					LEFT join publications on publications.id = P.publication_id
					LEFT join adreps on adreps.id = P.adrep_id
					WHERE P.status='5' AND P.help_desk='".$form."' AND A.sent='0' AND (`timestamp` BETWEEN '$ystday' AND '$today')";

    if($search != null){
        $sql .=" AND (
            P.job_no LIKE '%$search%'
            OR A.order_id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )";
    }
    $sql .=" LIMIT $start, $limit;";
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
    # get metro send ads ends here
    
    # get web ad categorise starts here
    public function get_web_categorise_ad_count($ystday,$today,$search=null) {
        $query ="SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, publications.name, adreps.first_name FROM `orders` 
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    WHERE orders.order_type_id = '1' AND orders.status = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.created_on BETWEEN '$ystday' AND '$today')";
         if($search != null){
            $query .=" AND (
               orders.job_no LIKE '%$search%'
                OR orders.id LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                
            )";
        }
       
           return $this->db->query($query)->num_rows();
     }
   
   public function get_web_categorise_ad($limit, $start,$ystday,$today,$sort_by,$order_by,$search=null) {
    
    $sql ="SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, publications.name, adreps.first_name FROM `orders` 
                JOIN `publications` ON orders.publication_id = publications.id
                JOIN `adreps` ON orders.adrep_id = adreps.id
                WHERE orders.order_type_id = '1' AND orders.status = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                AND (orders.created_on BETWEEN '$ystday' AND '$today')";

    if($search != null){
        $sql .=" AND (
            orders.job_no LIKE '%$search%'
            OR orders.id LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            
        )";
    }
    
    if(($sort_by != null && $order_by != null) || (($this->session->userdata("c_web_order_by") != "") && ($this->session->userdata("c_web_sort_by") != ""))){
       if($this->session->userdata("c_web_order_by")){
            $order_by = $this->session->userdata("c_web_order_by");
        }
        if($this->session->userdata("c_web_sort_by")){
            $sort_by = $this->session->userdata("c_web_sort_by");
        }
        else if($order_by == "publications"){
            $sql .= " ORDER BY  publications.name $sort_by"; 
        }else if($order_by == "order_id"){
            $sql .= " ORDER BY  orders.id $sort_by"; 
        }else if($order_by == "adreps"){
            $sql .= " ORDER BY adreps.first_name $sort_by";
        }
    }
    
    
    $sql .=" LIMIT $start, $limit;";
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
    # get web ad categorise ends here
    
    #get qa web ads starts here
    public function get_web_qa_ad_count($ystday,$today,$csr_id,$search=null) {
        $query ="SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, cat_result.id AS catId, cat_result.timestamp, cat_result.csr_QA, publications.name, adreps.first_name FROM `orders`
                    RIGHT JOIN `cat_result` ON orders.id = cat_result.order_no
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.status BETWEEN '1' AND '4' OR orders.status = '8') AND (orders.created_on BETWEEN '$ystday' AND '$today')
                    AND cat_result.pro_status = '3' AND (cat_result.csr_QA = '".$csr_id."' OR cat_result.csr_QA = '0')";
         if($search != null){
            $query .=" AND (
               orders.job_no LIKE '%$search%'
                OR orders.id LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                
            )";
        }
          return $this->db->query($query)->num_rows();
     }
     
    public function get_web_qa_ad($limit, $start,$ystday,$today,$csr_id,$sort_by,$order_by,$search=null) {
    
        $sql ="SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, cat_result.id AS catId, cat_result.timestamp, cat_result.csr_QA, publications.name, adreps.first_name FROM `orders`
                    RIGHT JOIN `cat_result` ON orders.id = cat_result.order_no
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.status BETWEEN '1' AND '4' OR orders.status = '8') AND (orders.created_on BETWEEN '$ystday' AND '$today')
                    AND cat_result.pro_status = '3' AND (cat_result.csr_QA = '".$csr_id."' OR cat_result.csr_QA = '0')";
    
        if($search != null){
            $sql .=" AND (
                orders.job_no LIKE '%$search%'
                OR orders.id LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                
            )";
        }
        
        if(($sort_by != null && $order_by != null) || (($this->session->userdata("c_qa_order_by") != "") && ($this->session->userdata("c_qa_sort_by") != ""))){
       if($this->session->userdata("c_qa_order_by")){
            $order_by = $this->session->userdata("c_qa_order_by");
        }
        if($this->session->userdata("c_qa_sort_by")){
            $sort_by = $this->session->userdata("c_qa_sort_by");
        }
        else if($order_by == "publications"){
            $sql .= " ORDER BY  publications.name $sort_by"; 
        }else if($order_by == "order_id"){
            $sql .= " ORDER BY  orders.id $sort_by"; 
        }else if($order_by == "adreps"){
            $sql .= " ORDER BY adreps.first_name $sort_by";
        }
    }
        $sql .=" LIMIT $start, $limit;";
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }
   
   }
    #get qa web ads ends here
    
    #get web new ad starts here
     public function get_web_new_ad_count($ystday,$today,$search=null) {
        $query ="SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, orders.status, publications.name, adreps.first_name, order_status.d_name FROM `orders`
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    JOIN `order_status` ON orders.status = order_status.id
                    WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.status BETWEEN '1' AND '4') AND (orders.created_on BETWEEN '$ystday' AND '$today')";
                    
         if($search != null){
            $query .=" AND (
               orders.job_no LIKE '%$search%'
                OR orders.id LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                
            )";
        }
          return $this->db->query($query)->num_rows();
     }
     
    public function get_web_new_ad($limit, $start,$ystday,$today,$search=null) {
    
        $sql ="SELECT orders.id, orders.job_no, orders.help_desk, orders.rush, orders.created_on, orders.crequest, orders.question, orders.cancel, orders.status, publications.name, adreps.first_name, order_status.d_name FROM `orders`
                    JOIN `publications` ON orders.publication_id = publications.id
                    JOIN `adreps` ON orders.adrep_id = adreps.id
                    JOIN `order_status` ON orders.status = order_status.id
                    WHERE orders.order_type_id = '1' AND orders.cancel = '0' AND orders.crequest != '1' 
                    AND (orders.status BETWEEN '1' AND '4') AND (orders.created_on BETWEEN '$ystday' AND '$today')";
    
        if($search != null){
            $sql .=" AND (
                orders.job_no LIKE '%$search%'
                OR orders.id LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                
            )";
        }
        $sql .=" LIMIT $start, $limit;";
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }
   
   }
    #get web new ad ends here
    
    #get revision pagination starts here
     public function get_revision_ad_count($adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$search=null) {
         if($help_desk_id == "20"){
             $query ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
    	                left join designers`designers` ON designers.id = rev_sold_jobs.designer
                        WHERE cat_result.category = 'G'
                        AND rev_sold_jobs.date = '$order_date' ";
         }else{
             $query ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
	                left join designers`designers` ON designers.id = rev_sold_jobs.designer
                    WHERE cat_result.publication_id IN ($publicationListTeam)
                    AND cat_result.category IN ($category_level)
                    AND rev_sold_jobs.date = '$order_date'";
         }
         
         if($display_type == 'pending'){
                   $query .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
                }elseif($display_type == 'sent'){
                   $query .= " AND rev_sold_jobs.status IN ('5','9') "; 
                }elseif($display_type == 'QA'){
                   $query .= " AND rev_sold_jobs.status IN ('4','7') "; 
                }
                
         if($search != null){
            $query .=" AND (
               rev_sold_jobs.order_no LIKE '%$search%'
               OR designers.username LIKE '%$search%'
                
            )";
        }
         $query .= " ORDER BY rev_sold_jobs.id ASC ";
        //  print_r($query);exit();
        
        return $this->db->query($query)->num_rows();
     }
     
     public function get_rev_ad($limit, $start,$adwit_teams_id,$category_level,$order_date,$display_type,$help_desk_id,$publicationListTeam,$sort_by,$order_by,$search=null) {
         
         if($help_desk_id == "20"){
             $sql = "SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
    	                left join `designers` ON designers.id = rev_sold_jobs.designer
                        WHERE cat_result.category = 'G'
                        AND rev_sold_jobs.date = '$order_date' ";
         }else{
           /* $sql ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
	                 left join `designers` ON designers.id = rev_sold_jobs.designer
                    WHERE cat_result.publication_id IN ($publicationListTeam)
                    AND cat_result.category IN ($category_level)
                    AND rev_sold_jobs.date = '$order_date'";*/  
        $sql = "SELECT rev_sold_jobs.*, cat_result.order_type_id FROM rev_sold_jobs
    	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
                        WHERE cat_result.publication_id IN ($publicationListTeam)
                        AND cat_result.category IN ($category_level)
                        AND rev_sold_jobs.date = '$order_date' ";
         }
        
                    
         if($display_type == 'pending'){
                   $sql .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
                }elseif($display_type == 'sent'){
                   $sql .= " AND rev_sold_jobs.status IN ('5','9') "; 
                }elseif($display_type == 'QA'){
                   $sql .= " AND rev_sold_jobs.status IN ('4','7') "; 
                }
                
       if($search != null){
            $sql .=" AND (
                rev_sold_jobs.order_no LIKE '%$search%'
                OR designers.username LIKE '%$search%'
            )";
        }
        
        if(($sort_by != null && $order_by != null) || (($this->session->userdata("csr_r_order_by") != "") && ($this->session->userdata("csr_r_sort_by") != ""))){
        // if(($sort_by != null && $order_by != null)){
          
            if($this->session->userdata("csr_r_order_by")){
                $order_by = $this->session->userdata("csr_r_order_by");
            }
            if($this->session->userdata("csr_r_sort_by")){
                $sort_by = $this->session->userdata("csr_r_sort_by");
            }
            if($order_by == "type"){ 
                $sql .= " ORDER BY orders_type.value $sort_by"; 
            }else if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "club"){
                $sql .= " ORDER BY  club.name $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }else if($order_by == "category" || $order_by =="order_id"){
                $sql .= " ORDER BY live_orders.$order_by $sort_by";  
            }
           
        }else{ 
            $sql .= " ORDER BY rev_sold_jobs.id ASC ";
        }
        
        $sql .=" LIMIT $start, $limit;";
        // print_r($sql);exit();
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }

   }
   
   #revision rush stars here
   public function get_rush_ad_count($adwit_teams_id,$search=null) {
        $query ="SELECT orders.id, orders.created_on, orders.order_type_id, orders.status, orders.advertiser_name, orders.job_no, orders.question, orders.help_desk,
	            publications.name AS Pname, CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname FROM orders 
	                    JOIN `publications` ON publications.id = orders.publication_id
	                    JOIN `adreps` ON adreps.id = orders.adrep_id
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.crequest != '1'  AND orders.help_desk != '0'
	                    AND orders.club_id IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ) AND DATE(orders.created_on) > '2023-01-01' ";

     if($search != null){
            $query .=" AND (
               orders.id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                OR adreps.last_name LIKE '%$search%'
                
            )";
        } 
         $query .= " ORDER BY orders.id DESC";

        return $this->db->query($query)->num_rows();
     }
     //get_rush_ad
     public function get_rush_ad($limit, $start,$adwit_teams_id,$search=null) {

        $sql ="SELECT orders.id, orders.created_on, orders.order_type_id, orders.status, orders.advertiser_name, orders.job_no, orders.question, orders.help_desk,
	            publications.name AS Pname, CONCAT(adreps.first_name,' ',adreps.last_name) AS Aname FROM orders 
	                    JOIN `publications` ON publications.id = orders.publication_id
	                    JOIN `adreps` ON adreps.id = orders.adrep_id
	                    WHERE orders.rush = '1' AND orders.status IN ('1','2','3','4','8') AND orders.cancel != '1' AND orders.question != '1' AND orders.help_desk != '0'
	                    AND orders.club_id IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ) AND DATE(orders.created_on) > '2023-01-01' ";
       
       if($search != null){
            $sql .=" AND (
                orders.id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                OR adreps.last_name LIKE '%$search%'
            )";
        } 
        $sql .= " ORDER BY orders.id DESC";
        $sql .=" LIMIT $start, $limit;";
        
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }

   }
    #get revision pagination ends here
    
    #############################   Designer    #################################
    
    # get design pending ads starts here
     public function get_pending_ad_count($ystday,$today,$dId,$search=null) {
         
    $query = "SELECT orders.id FROM orders 
                LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
                left join `adreps` on adreps.id = orders.adrep_id
                left join `publications` on publications.id = orders.publication_id
                left join `design_teams` on design_teams.id = publications.design_team_id
                WHERE orders.order_type_id = '1' AND orders.cancel!='1' AND orders.crequest!='1' AND orders.status='2'
                AND (orders.created_on BETWEEN '$ystday' AND '$today') AND cat_result.pdf_path = 'none' 
                AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0')";

    if($search != null){
        $query .=" AND (
            orders.id LIKE '%$search%'
            OR orders.job_no LIKE '%$search%'
            OR orders.web_ad_type LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR design_teams.name LIKE '%$search%'
            
        )";
    }
    // print_r($query);exit();
       return $this->db->query($query)->num_rows();
   }
   
    public function get_design_pending_ad($limit, $start,$ystday,$today,$sort_by,$order_by,$search=null) {
    
    $sql ="SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,
    orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,
    orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,
    orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,orders.down_del,
    orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time,adreps.first_name,publications.name,design_teams.name as dteam_name,orders_type.value,time_zone.priority AS time_zone_priority
	FROM `orders` 
	join `publications` on publications.id = orders.publication_id
	JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    join `adreps` on adreps.id = orders.adrep_id
    join `design_teams` on design_teams.id = publications.design_team_id
    JOIN `orders_type` ON orders_type.id = orders.order_type_id
	WHERE `order_type_id`='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND `status`='2' AND `crequest`!='1' AND `cancel`!='1'";

   if($search != null){
        $sql .=" AND (
            orders.id LIKE '%$search%'
            OR orders.job_no LIKE '%$search%'
            OR orders.web_ad_type LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR design_teams.name LIKE '%$search%'
            
        )";
    }
    
     if(($sort_by != null && $order_by != null) || (($this->session->userdata("d_order_by") != "") && ($this->session->userdata("d_sort_by") != ""))){
        // if(($sort_by != null && $order_by != null)){
          
            if($this->session->userdata("d_order_by")){
                $order_by = $this->session->userdata("d_order_by");
            }
            if($this->session->userdata("d_sort_by")){
                $sort_by = $this->session->userdata("d_sort_by");
            }
            if($order_by == "type"){ 
                $sql .= " ORDER BY orders_type.value $sort_by"; 
            }else if( $order_by =="order_id"){
                $sql .= " ORDER BY orders.id $sort_by";  
            }else if( $order_by =="adreps"){
                $sql .= " ORDER BY adreps.first_name $sort_by";  
            }else if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "ad_type"){
                $sql .= " ORDER BY  orders.web_ad_type $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }
           
        }
    
    $sql .=" LIMIT $start, $limit;";
    // print_R($sql);exit();
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
   
    # get design pending ads ends here
    
    #get upload pending ads starts here
    
    public function get_upending_ad_count($ystday,$today,$dId,$search=null) {
        
    $query ="SELECT orders.id FROM orders 
		    LEFT OUTER JOIN cat_result on orders.id = cat_result.order_no 
		    join `publications` on publications.id = orders.publication_id
            join `adreps` on adreps.id = orders.adrep_id
			WHERE orders.order_type_id = '1' AND orders.cancel!='1' 
            AND orders.crequest!='1' AND (orders.status='3' OR orders.status='4') 
            AND (orders.created_on BETWEEN '$ystday' AND '$today') 
            AND (cat_result.pro_status = '1' OR cat_result.pro_status = '3' OR cat_result.pro_status = '6' OR cat_result.pro_status = '7')  
            AND cat_result.designer = '$dId' AND (cat_result.tag_designer = '$dId' OR cat_result.tag_designer = '0') ";
   if($search != null){
        $query .=" AND (
            orders.id LIKE '%$search%'
            OR orders.job_no LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            OR publications.name LIKE '%$search%'

        )";
    }
 
       return $this->db->query($query)->num_rows();
   }
   
   public function get_udesign_pending_ad($limit, $start,$ystday,$today,$sort_by,$order_by,$search=null) {
    
    $sql ="SELECT orders.id,orders.group_id,orders.adrep_id,orders.map_order_id,orders.csr,orders.publication_id,orders.help_desk,orders.order_type_id,orders.advertiser_name,orders.publish_date,
    orders.publication_name,orders.date_needed,orders.copy_content,orders.job_instruction,orders.art_work,orders.no_fax_items,orders.no_email_items,orders.with_form,orders.job_no,orders.section,
    orders.is_requested_before,orders.can_use_previous,orders.is_change_previous,orders.color_preferences,orders.font_preferences,orders.copy_content_description,orders.notes,orders.spec_sold_ad,
    orders.html_type,orders.width,orders.height,orders.size_inches,orders.num_columns,orders.modular_size,orders.print_ad_type,orders.template_used,orders.file_name,orders.pixel_size,
    orders.web_ad_type,orders.ad_format,orders.maxium_file_size,orders.custom_width,orders.custom_height,orders.pickup_adno,orders.file_path,orders.created_on,orders.approve,orders.cancel,
    orders.reason,orders.rush,orders.oldadrep_id,orders.question,orders.crequest,orders.priority,orders.pdf,orders.pdf_timestamp,orders.credits,orders.rev_count,orders.rev_id,orders.status,
    orders.down_del,orders.source_del,orders.inv_id,orders.project_id,orders.approved_time,orders.activity_time,orders_type.value,time_zone.priority AS time_zone_priority,adreps.first_name,publications.name FROM `orders`
    join `publications` on publications.id = orders.publication_id
    join `adreps` on adreps.id = orders.adrep_id
    JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
    JOIN `orders_type` ON orders_type.id = orders.order_type_id
	 WHERE `order_type_id`='1' AND (orders.created_on BETWEEN '$ystday' AND '$today') AND (`status`='3' OR `status`='4') AND `crequest`!='1' AND `cancel`!='1' ";

   if($search != null){
        $sql .=" AND (
            orders.id LIKE '%$search%'
            OR orders.job_no LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            OR publications.name LIKE '%$search%'

        )";
    }
    
     if(($sort_by != null && $order_by != null) || (($this->session->userdata("wu_order_by") != "") && ($this->session->userdata("wu_sort_by") != ""))){
            if($this->session->userdata("wu_order_by")){
                $order_by = $this->session->userdata("wu_order_by");
            }
            if($this->session->userdata("wu_sort_by")){
                $sort_by = $this->session->userdata("wu_sort_by");
            }
            if($order_by == "type"){ 
                $sql .= " ORDER BY orders_type.value $sort_by"; 
            }else if( $order_by =="order_id"){
                $sql .= " ORDER BY orders.id $sort_by";  
            }else if( $order_by =="adreps"){
                $sql .= " ORDER BY adreps.first_name $sort_by";  
            }else if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "ad_type"){
                $sql .= " ORDER BY  orders.web_ad_type $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }
           
        }
    
    $sql .=" LIMIT $start, $limit;";
    // print_r($sql);exit();
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
    
    #get upload pending ads ends here
    
    #get new ad upload pending starts here
    public function get_upload_pending_ad_count($dId,$search=null) {
    $query ="SELECT live_orders.id, live_orders.order_id,orders.job_no,adreps.first_name, adreps.last_name,publications.name,club.name FROM `live_orders`
			RIGHT JOIN `orders` ON orders.id = live_orders.order_id
			RIGHT JOIN `adreps` ON adreps.id = orders.adrep_id
			RIGHT JOIN `publications` ON publications.id = orders.publication_id
			RIGHT JOIN `club` ON club.id = orders.club_id
            WHERE live_orders.designer_id = '$dId' AND live_orders.crequest != '1'";
   if($search != null){
        $query .=" AND (
            live_orders.order_id LIKE '%$search%'
            OR orders.job_no LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            OR adreps.last_name LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR club.name LIKE '%$search%'

        )";
    }
    
 
       return $this->db->query($query)->num_rows();
   }

    public function get_upload_pending_ad($limit, $start,$dId,$sort_by,$order_by,$search=null) {
    $sql ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.category,live_orders.sub_category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority,
            orders.job_no,adreps.first_name, adreps.last_name,publications.name,club.name,orders.created_on
            FROM `live_orders`
            JOIN `orders` ON orders.id = live_orders.order_id
            JOIN `adreps` ON adreps.id = orders.adrep_id
            JOIN `club` ON club.id = orders.club_id
            JOIN `publications` ON publications.id = live_orders.pub_id
            JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
            WHERE live_orders.designer_id = '$dId' AND live_orders.crequest != '1'";

   if($search != null){
        $sql .=" AND (
            live_orders.order_id LIKE '%$search%'
            OR orders.job_no LIKE '%$search%'
            OR adreps.first_name LIKE '%$search%'
            OR adreps.last_name LIKE '%$search%'
            OR publications.name LIKE '%$search%'
            OR club.name LIKE '%$search%'

        )";
    }
    //sort by column starts here
    
    if(($sort_by != null && $order_by != null) || (($this->session->userdata("u_order_by") != "") && ($this->session->userdata("u_sort_by") != ""))){
        // if(($sort_by != null && $order_by != null)){
          
            if($this->session->userdata("u_order_by")){
                $order_by = $this->session->userdata("u_order_by");
            }
            if($this->session->userdata("u_sort_by")){
                $sort_by = $this->session->userdata("u_sort_by");
            }
            // print_r($order_by);print_r($sort_by);
             if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "club"){
                $sql .= " ORDER BY  club.name $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }else if($order_by == "created_on"){
                $sql .= " ORDER BY  orders.created_on $sort_by"; 
            }else if($order_by == "adrep"){
                $sql .= " ORDER BY CONCAT(adreps.first_name, ' ', adreps.last_name) $sort_by";
 
            }else if($order_by == "category" || $order_by =="order_id"){
                $sql .= " ORDER BY live_orders.$order_by $sort_by";  
            }
           
        }
    // sort by column ends here
    
    $sql .=" LIMIT $start, $limit;";
    // print_r($sql);exit();
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
   
   }
       #get new ad upload pending ends here
       
       #get new upload total Q starts here
       
    public function get_design_pending_ad_count($cat_series,$club_id,$search=null) {
        $query =" SELECT live_orders.id, live_orders.order_id,live_orders.category,orders.job_no,publications.name,club.name FROM `live_orders` 
                  RIGHT JOIN `orders` ON orders.id = live_orders.order_id
                  RIGHT JOIN `club` ON club.id = live_orders.club_id
                  RIGHT JOIN `publications` ON publications.id = live_orders.pub_id
    		      WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
    			  AND live_orders.crequest != '1' AND live_orders.question != '1'";
       if($search != null){
            $query .=" AND (
                live_orders.order_id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR live_orders.category LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR club.name LIKE '%$search%'
    
            )";
        }
          return $this->db->query($query)->num_rows();
       }
       
       public function get_new_design_pending_ad($limit, $start,$cat_series,$club_id,$sort_by,$order_by,$search=null){
         $sql ="SELECT live_orders.pub_id AS publication_id, live_orders.order_id AS oid, live_orders.job_no, live_orders.category, live_orders.designer_id, 
                live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question,
                orders.id, orders.order_type_id, orders.rush, orders.help_desk, orders.adrep_id, orders.advertiser_name,
                publications.name, publications.design_team_id, time_zone.priority AS time_zone_priority, orders_type.value,club.name
                FROM `live_orders`
                JOIN `orders` ON orders.id = live_orders.order_id
                JOIN `publications` ON publications.id = live_orders.pub_id
                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                JOIN `club` ON club.id = live_orders.club_id
                JOIN `orders_type` ON orders_type.id = orders.order_type_id
	            WHERE live_orders.status = '2' AND live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
				AND live_orders.crequest != '1' AND live_orders.question != '1' "; 
				

       if($search != null){
            $sql .=" AND (
                live_orders.order_id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR live_orders.category LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR club.name LIKE '%$search%'
    
            )";
        }
        
       /* print_r($this->session->userdata("order_by"));
        print_r($this->session->userdata("sort_by"));*/
       
        if(($sort_by != null && $order_by != null) || (($this->session->userdata("order_by") != "") && ($this->session->userdata("sort_by") != ""))){
        // if(($sort_by != null && $order_by != null)){
          
            if($this->session->userdata("order_by")){
                $order_by = $this->session->userdata("order_by");
            }
            if($this->session->userdata("sort_by")){
                $sort_by = $this->session->userdata("sort_by");
            }
            if($order_by == "type"){ 
                $sql .= " ORDER BY orders_type.value $sort_by"; 
            }else if($order_by == "publication"){
                $sql .= " ORDER BY  publications.name $sort_by"; 
            }else if($order_by == "club"){
                $sql .= " ORDER BY  club.name $sort_by"; 
            }else if($order_by == "priority"){
                $sql .= " ORDER BY  time_zone_priority $sort_by"; 
            }else if($order_by == "category" || $order_by =="order_id"){
                $sql .= " ORDER BY live_orders.$order_by $sort_by";  
            }
           
        }else{
           $sql .= " ORDER BY orders.rush DESC, time_zone_priority"; 
        }
         $sql .=" LIMIT $start, $limit;";
        // print_r($sql);exit();
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }
         
           }
       #get totalQ ends here
       #get designer revision ads starts here
       
    public function get_designer_revision_ad_count($adwit_teams_id,$category_level,$order_date,$display_type,$search=null) {
        $dId = $this->session->userdata('dId');
             $query ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
	                left join `designers` ON designers.id = rev_sold_jobs.designer
                    WHERE cat_result.publication_id IN (SELECT `id`  FROM `publications` WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ))
                    AND cat_result.category IN ($category_level)
                    AND rev_sold_jobs.date = '$order_date' AND rev_sold_jobs.job_accept = '1'";
         
         if($display_type == 'pending'){
               $query .= " AND rev_sold_jobs.status NOT IN ('5','9') ";
            }elseif($display_type == 'sent'){
               $query .= " AND rev_sold_jobs.status IN ('5','9') "; 
            }elseif($display_type == 'myQ'){ //designer and designer producrion date specific
                $query = "SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
	                left join `designers` ON designers.id = rev_sold_jobs.designer
                    WHERE rev_sold_jobs.designer = '$dId' AND rev_sold_jobs.status IN ('3','4','7')";    
            }
                
         if($search != null){
            $query .=" AND (
               rev_sold_jobs.order_no LIKE '%$search%'
                OR designers.username LIKE '%$search%'
                
            )";
        }
         $query .= " ORDER BY rev_sold_jobs.id ASC ";
        return $this->db->query($query)->num_rows();
     }
    
     public function get_designer_rev_ad($limit, $start,$adwit_teams_id,$category_level,$order_date,$display_type,$sort_by,$order_by,$search=null) {
         $dId = $this->session->userdata('dId');
            $sql ="SELECT rev_sold_jobs.*, cat_result.order_type_id,designers.username FROM rev_sold_jobs
	                JOIN `cat_result` ON cat_result.order_no = rev_sold_jobs.order_id
	                left join `designers` ON designers.id = rev_sold_jobs.designer
                    WHERE cat_result.publication_id IN (SELECT `id`  FROM `publications` WHERE `club_id` IN (SELECT `club_id` FROM `adwit_teams_and_club` WHERE `adwit_teams_id` = '$adwit_teams_id' ))
                    AND cat_result.category IN ($category_level)
                    AND rev_sold_jobs.date = '$order_date' AND rev_sold_jobs.job_accept = '1'";  
         
                    
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
                
       if($search != null){
            $sql .=" AND (
                rev_sold_jobs.order_id LIKE '%$search%'
                OR designers.username LIKE '%$search%'
            )";
        }
        
        //sort by column starts here

    if(($sort_by != null && $order_by != null) || (($this->session->userdata("r_order_by") != "") && ($this->session->userdata("r_sort_by") != ""))){
            if($this->session->userdata("r_order_by")){
                $order_by = $this->session->userdata("r_order_by");
            }
            if($this->session->userdata("r_sort_by")){
                $sort_by = $this->session->userdata("r_sort_by");
            }
             if($order_by == "order_id"){
                $sql .= " ORDER BY  rev_sold_jobs.order_id $sort_by"; 
            }
           
        }else{
            $sql .= " ORDER BY rev_sold_jobs.id ASC ";
        }
    
        //sort by column ends here

        $sql .=" LIMIT $start, $limit;";
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }

   }
   
       #get designer revision ads ends here
       
       #functions for TL starts here
       #get all pending orders starts here
        public function get_all_pending_ad_count($cat_series,$club_id,$search=null) {
        $query ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, 
                live_orders.question, time_zone.priority AS time_zone_priority,orders.created_on,designers.username,adreps.first_name,adreps.last_name
            	FROM `live_orders`
                LEFT JOIN orders ON orders.id = live_orders.order_id
                LEFT JOIN `designers` on designers.id = live_orders.designer_id
                JOIN `publications` ON publications.id = live_orders.pub_id
                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                left join `adreps` ON adreps.id = orders.adrep_id
                WHERE live_orders.category IN ($cat_series) AND live_orders.status IN (2,3,4,8) AND live_orders.club_id IN $club_id 
                AND live_orders.crequest != '1' AND live_orders.question != '1'";
                
       if($search != null){
            $query .=" AND (
                live_orders.order_id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                OR adreps.last_name LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR designers.username LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR live_orders.category LIKE '%$search%'
                OR time_zone.priority LIKE '%$search%'
                
    
            )";
        }
        $query.= " ORDER BY time_zone.priority ASC";
        // print_r($query);exit();
          return $this->db->query($query)->num_rows();
       }
       
       public function get_new_all_pending_ad($limit, $start,$cat_series,$club_id,$search=null){
         $sql ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category, live_orders.designer_id, live_orders.csr_id, live_orders.status,
                live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority,orders.created_on,designers.username,adreps.first_name,adreps.last_name
            	FROM `live_orders`
                LEFT JOIN orders ON orders.id = live_orders.order_id
                LEFT JOIN `designers` on designers.id = live_orders.designer_id
                JOIN `publications` ON publications.id = live_orders.pub_id
                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                left join `adreps` ON adreps.id = orders.adrep_id
                WHERE live_orders.category IN ($cat_series) AND live_orders.status IN (2,3,4,8) AND live_orders.club_id IN $club_id 
                AND live_orders.crequest != '1' AND live_orders.question != '1' "; 
				

       if($search != null){
            $sql .=" AND (
                live_orders.order_id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                OR adreps.last_name LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR designers.username LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR live_orders.category LIKE '%$search%'
                OR time_zone.priority LIKE '%$search%'
                
    
            )";
        }
        
        $sql .= " ORDER BY time_zone.priority ASC";
        $sql .=" LIMIT $start, $limit;";
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }
         
    }
        #get all pending orders ends here
        
    #get question sent starts here
    public function get_question_sent_ad_count($cat_series,$club_id,$search=null) {
        $query ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category,live_orders.sub_category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
            	FROM `live_orders`
                LEFT JOIN orders ON orders.id = live_orders.order_id
                JOIN `publications` ON publications.id = live_orders.pub_id
                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                WHERE live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
                AND live_orders.crequest != '1' AND live_orders.question = '1'";
                        
                
       if($search != null){
            $query .=" AND (
                live_orders.order_id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                OR adreps.last_name LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR designers.username LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR live_orders.category LIKE '%$search%'
                OR time_zone.priority LIKE '%$search%'
                
    
            )";
        }
        $query.= " ORDER BY time_zone.priority ASC";
          return $this->db->query($query)->num_rows();
       }
       
       public function get_question_sent_ad($limit, $start,$cat_series,$club_id,$search=null){
         $sql ="SELECT live_orders.id, live_orders.pub_id, live_orders.order_id, live_orders.job_no, live_orders.category,live_orders.sub_category, live_orders.designer_id, live_orders.csr_id, live_orders.status, live_orders.pro_status, live_orders.club_id, live_orders.question, time_zone.priority AS time_zone_priority
            	FROM `live_orders`
                LEFT JOIN orders ON orders.id = live_orders.order_id
                JOIN `publications` ON publications.id = live_orders.pub_id
                JOIN `time_zone` ON time_zone.time_zone_id  = publications.time_zone_id
                WHERE live_orders.category IN ($cat_series) AND live_orders.club_id IN $club_id 
                AND live_orders.crequest != '1' AND live_orders.question = '1'"; 
				

       if($search != null){
            $sql .=" AND (
                live_orders.order_id LIKE '%$search%'
                OR orders.job_no LIKE '%$search%'
                OR adreps.first_name LIKE '%$search%'
                OR adreps.last_name LIKE '%$search%'
                OR publications.name LIKE '%$search%'
                OR designers.username LIKE '%$search%'
                OR DATE_FORMAT(orders.created_on, '%d-%b') LIKE '%$search%'
                OR live_orders.category LIKE '%$search%'
                OR time_zone.priority LIKE '%$search%'
                
    
            )";
        }
        
        $sql .= " ORDER BY time_zone.priority ASC";
        $sql .=" LIMIT $start, $limit;";
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }else{
                return false;
            }
         
           }
    
    #get question sent ends here
       #functions for TL ends here
   
}
