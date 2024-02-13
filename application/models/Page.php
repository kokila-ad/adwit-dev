<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Page extends CI_Model
    {   

        /* function __construct() 
        {
            $this->userTbl = 'users';
        }
        function validate()
        {
            $username = $this->security->xss_clean($this->input->post('username'));
            $password = $this->security->xss_clean($this->input->post('password'));

            $this->db->where('username', $username);
            $this->db->where('password', $password);

            $query = $this->db->get('users');

            if($query->num_rows == 1)
            {
            // If there is a user, then create session data
                $row = $query->row();
                $data = array(
                    'username'=>$row->username,
                    'password'=>$row->password  
                    );
                $this->session->set_userdata($data);
                return true;
            }
            return false;
        }
		*/

        function page_design_insert($data)
        {
            $this->db->insert('page_design',$data);
            $id = $this->db->insert_id();
            return $id;    
        }

        function pages_insert($data1)
        {
            $this->db->insert('pages',$data1);
            $p_id = $this->db->insert_id();
            return $p_id;                   
        }  
        function message_insert($data)
        {
            $this->db->insert('page_message',$data);
            $p_id = $this->db->insert_id();
            return $p_id;                   
        }  
        
    }


?>