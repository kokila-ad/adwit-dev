<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function advertisements($owner, $key, $skip_ads, $per_page)
	{
		$query = "";
		switch($owner){
			case 'bg':
				$query = "Select ads.name, ads.file_url, ads.slugs from advertisements as ads LEFT JOIN advertisers as adv on adv.id=ads.advertiser_id LEFT JOIN publications as pub on pub.id=adv.publication_id LEFT JOIN business_groups as bg on bg.id=pub.business_group_id where bg.name LIKE '%".$key."%'";
				break;
			case 'publications':
				$query = "Select ads.name, ads.file_url, ads.slugs from advertisements as ads LEFT JOIN advertisers as adv on adv.id=ads.advertiser_id LEFT JOIN publications as pub on pub.id=adv.publication_id where pub.name LIKE '%".$key."%'";
				break;
			case 'advertisers':
				$query = "Select ads.name, ads.file_url, ads.slugs from advertisements as ads LEFT JOIN advertisers as adv on adv.id=ads.advertiser_id where adv.name LIKE '%".$key."%' OR keywords LIKE '%".$key."%'";
				break;
			case 'advertisements':
				$query = "Select ads.name, ads.file_url, ads.slugs from advertisements as ads where ads.name LIKE '%".$key."%'";
				break;
		}
		
		$data = array();
		
		$this->load->library('pagination');
		$config['base_url'] = base_url().index_page().'search/'.$owner.'/'.$key.'/';
		$data['total_matches'] = $config['total_rows'] = count($this->db->query($query)->result_array());
		$config['per_page'] = $per_page; 
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		
		$data['ads'] = $this->db->query($query." LIMIT $skip_ads, $per_page")->result_array();
		$data['start_record'] = $skip_ads + 1;
		$data['end_record'] = ($data['start_record'] + count($data['ads'])) - 1;
		$data['paging'] =  $this->pagination->create_links();
		
		return $data;
	}
}