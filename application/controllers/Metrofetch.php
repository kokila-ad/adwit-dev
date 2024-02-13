<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MetroFetch extends CI_Controller {

	public function index()
	{
		$id = 0;
		$ordersTo = date('m/d/Y');
		$ordersFrom = date('m/d/Y', strtotime('-1 day', strtotime($ordersTo)));
		$secret = 'MetroWebMaster';
		
		$this->db->order_by("id", "desc"); 
		$result = $this->db->get("metro_jobs",1)->result_array();
		
		if(isset($result[0]['od_orderid'])) $id = $result[0]['od_orderid'];
		
		$json = file_get_contents("http://metroadsondemand.com/metro-info.asp?id=".$id."&ordersFrom=".$ordersFrom."&ordersTo=".$ordersTo."&secret=".$secret);
		
		$dataArr = json_decode($json);
		
		foreach($dataArr[0] as $i => $col)
		{
			$job = array();
			$job['od_orderid'] = (string)$dataArr[0][$i];
			$job['od_user'] = (string)$dataArr[1][$i];
			$job['od_compnayname'] = (string)$dataArr[2][$i];
			$job['od_adtype'] = (string)$dataArr[3][$i];
			$job['od_custname'] = (string)$dataArr[4][$i];
			$job['od_notes'] = (string)$dataArr[5][$i];
			$job['od_custemail'] = (string)$dataArr[6][$i];
			$job['od_adname'] = (string)$dataArr[7][$i];
			$job['od_currentdate'] = (string)$dataArr[8][$i];
			$job['od_dateneeded'] = (string)$dataArr[9][$i];
			$job['od_publicationname'] = (string)$dataArr[10][$i];
			$job['od_publicationdate'] = (string)$dataArr[11][$i];
			$job['od_adsize'] = (string)$dataArr[12][$i];
			$job['od_adtype1'] = (string)$dataArr[13][$i];
			$job['od_instructions1'] = (string)$dataArr[14][$i];
			$job['od_instructions2'] = (string)$dataArr[15][$i];
			$job['od_colorpref'] = (string)$dataArr[16][$i];
			$job['od_fontpref'] = (string)$dataArr[17][$i];
			$job['od_tempused'] = (string)$dataArr[18][$i];
			$job['od_filename'] = (string)$dataArr[19][$i];
			$job['od_jobno'] = (string)$dataArr[20][$i];
			$job['od_art'] = (string)$dataArr[21][$i];
			$job['od_emphasis'] = (string)$dataArr[22][$i];
			$job['od_artwork'] = (string)$dataArr[33][$i];
			$job['od_ftp'] = (string)$dataArr[24][$i];
			$job['od_phone1'] = (string)$dataArr[25][$i];
			$job['od_phone2'] = (string)$dataArr[26][$i];
			$job['od_mobile'] = (string)$dataArr[27][$i];
			$job['od_fax'] = (string)$dataArr[28][$i];
			$job['od_misc1'] = (string)$dataArr[29][$i];
			$job['od_misc2'] = (string)$dataArr[30][$i];
			$job['od_misc3'] = (string)$dataArr[31][$i];
			$job['copy_content'] = (string)$dataArr[32][$i];
			$job['od_supercustomer'] = (string)$dataArr[33][$i];
			$job['od_customermanager'] = (string)$dataArr[34][$i];
			$job['od_accountsmanager'] = (string)$dataArr[35][$i];
			$job['od_status'] = (string)$dataArr[36][$i];
			$job['od_displaystatus'] = (string)$dataArr[37][$i];
			$job['od_ascompany'] = (string)$dataArr[38][$i];
			$job['ad_complexity'] = (string)$dataArr[39][$i];
			$job['od_admall1'] = (string)$dataArr[40][$i];
			$job['od_admall2'] = (string)$dataArr[41][$i];
			$job['web_ad_width'] = (string)$dataArr[42][$i];
			$job['web_ad_height'] = (string)$dataArr[43][$i];
			$job['adformat'] = (string)$dataArr[44][$i];
			$job['max_file_size'] = (string)$dataArr[45][$i];
			$job['web_ad_type1'] = (string)$dataArr[46][$i];
			$job['ad_type_name'] = (string)$dataArr[47][$i];
			$job['emphasis1'] = (string)$dataArr[48][$i];
			$job['notes1'] = (string)$dataArr[49][$i];
			$job['adv_text'] = (string)$dataArr[50][$i];
			$job['JobTransfer'] = (string)$dataArr[51][$i];
			$job['modular_size'] = (string)$dataArr[52][$i];
			$job['ref_metro_specAd'] = (string)$dataArr[53][$i];
			$job['ref_metro_img'] = (string)$dataArr[54][$i];
			$this->db->insert('metro_jobs',$job);
		}
	}
}