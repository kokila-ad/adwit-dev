<?php

class Home extends CI_Controller {
	
	public function index(){
		echo"hello";
	}

	public function download_delete() //cron : wget adwitads.com/weborders/index.php/cron_jobs/home/download_delete
	{
		$d = date("Y-m-d 23:59:59", strtotime("-200 day"));
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `down_del`='0' AND `created_on` < '$d' ")->result_array();
		// $orders = $this->db->query("SELECT * FROM `orders` WHERE `id` = '182627'")->result_array();
		if($orders && count($orders) > '0'){
			foreach($orders as $row){
				$path = 'none';
				if(file_exists($row['file_path']) && $row['file_path']!='downloads' && $row['file_path']!='downloads/')
				{
					$path = $row['file_path'];
				}/*else{
					$row['job_no'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\(\)%&-]/s', '_', $row['job_no']);
					$dir_name = $row['id'].'-'.$row['job_no'];
					$path = 'downloads/'.$dir_name;
				}*/
				
				if($path!='none' && file_exists($path)){
					//echo $dir_name."file exists<br/>";
					$this->load->helper("file");
					delete_files($path, true); 
					if(rmdir($path)){
					 	$this->db->update('orders',array('down_del' => '1'),array('id' => $row['id']));					 
					}
				}//else{ echo $path."file dnt exists <br/>"; }
			}
		}
	}
	
	public function rev_download_delete() //cron : wget adwitads.com/weborders/index.php/cron_jobs/home/rev_download_delete
	{
		$d = date("Y-m-d", strtotime("-45 day"));
		$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `down_del`='0' AND `date` < '$d'")->result_array();
		if($rev_orders && count($rev_orders) > '0'){
			foreach($rev_orders as $row){
				$path = 'none';
				if(file_exists($row['file_path']) && $row['file_path']!='revision_downloads' && $row['file_path']!='revision_downloads/')
				{
					$path = $row['file_path'];
				}/*else{
					$dir_name = $row['order_no'];
					$path = 'revision_downloads/'.$dir_name;
				}*/
				
				if($path!='none' && file_exists($path)){
					$this->load->helper("file");
					delete_files($path, true); 
					if(rmdir($path)){
					 	$this->db->update('rev_sold_jobs',array('down_del' => '1'),array('id' => $row['id']));					 
					}
				}
			}
		}
	}
	
	public function orders_table($day) 
	{
		$d = date("Y-m-d 23:59:59", strtotime("-$day day"));
		$rev_orders = $this->db->query("SELECT * FROM `orders` WHERE `down_del`='0' AND `created_on` < '$d'")->result_array();
		if($rev_orders && count($rev_orders) > '0'){
			echo "<table>";
			foreach($rev_orders as $row){
				echo"<tr>";
				echo"<td>".$row['id']."</td>";
				echo"<td>".$row['job_no']."</td>";
				echo"<td>".$row['created_on']."</td>";
				echo"<td>".$row['file_path']."</td>";
				echo"</tr>";
			}
			echo "</table>";
		}else{ echo "no orders"; }
	}
	
	public function rev_sold_jobs($day) 
	{
		$d = date("Y-m-d", strtotime("-$day day"));
		$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `down_del`='0' AND `date` < '$d'")->result_array();
		if($rev_orders && count($rev_orders) > '0'){
			echo "<table>";
			foreach($rev_orders as $row){
				echo"<tr>";
				echo"<td>".$row['order_id']."</td>";
				echo"<td>".$row['order_no']."</td>";
				echo"<td>".$row['date']."</td>";
				echo"<td>".$row['file_path']."</td>";
				echo"</tr>";
			}
			echo "</table>";
		}else{ echo "no orders"; }
	}
	
	public function create_source_zip() 
	{
		$num_days = '105';
		$d = date("Y-m-d 00:00:00", strtotime("-$num_days day"));
		$orders = $this->db->query("SELECT * FROM `orders` WHERE `source_del`='0' AND `created_on` < '$d' AND `pdf`!='none'; ")->result_array();
		//$orders = $this->db->query("SELECT * FROM `orders` WHERE `id`='182889' AND `source_del`='0' AND `pdf`!='none'; ")->result_array();
		foreach($orders as $row){
			$post = array( 'order_id' => $row['id'], 'start' => date("H:i:s"));
			$this->db->insert('source_tracker', $post);
			
			$order_id = $row['id'];
			$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='$order_id' AND `source_path`!='none' AND `pdf_path`!='none' ")->row_array();
			if(isset($cat_result['order_no'])){
				//$order_id = $cat_result['order_no'];
				$path = $cat_result['source_path'];
				$slug = $cat_result['slug'];
				$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order_id' AND `source_file`!='none' AND `pdf_file`!='none' ORDER BY `id` DESC LIMIT 1;")->row_array();
				//if revision ad get the latest source & pdf file
				if(isset($rev_orders['id'])){
					$slug = $rev_orders['new_slug'];
					$source_file = $rev_orders['source_file'];
					$pdf_file = $rev_orders['pdf_file'];
					$source_file_path = $path.'/'.$source_file;
					$pdf_file_path = $path.'/'.$pdf_file;
					
				}else{
					//if new ad get the source & pdf file using the source path
					$map1 = glob($path.'/'.$slug.'.{indd,psd}',GLOB_BRACE);
					if($map1){ foreach($map1 as $row1){
						$source_file_path = $row1;
						$source_file = basename($row1);
					} } 
					$map2 = glob($path.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
					if($map2){ foreach($map2 as $row2){
						$pdf_file_path = $row2;
						$pdf_file = basename($row2);
					} }
				}
				//zip the files
				if(isset($source_file_path) && file_exists($source_file_path) && file_exists($pdf_file_path)){
					//echo $source_file_path.'<br/>'; echo $pdf_file_path;
					$data['source_file_path'] = $source_file_path;
					$data['pdf_file_path'] = $pdf_file_path;
					$data['slug'] = $slug;
					$data['path'] = $path;
					$data['source_file'] = $source_file;
					$data['pdf_file'] = $pdf_file;
					//check
					$post_status = array('check' => date('H:i:s'));
					$this->db->where('order_id', $row['id']);
					$this->db->update('source_tracker', $post_status);
					
					if($this->zip_folder_select($data)==true){
						//zipfile
					$post_status = array('zip' => date('H:i:s'));
					$this->db->where('order_id', $row['id']);
					$this->db->update('source_tracker', $post_status);
					
						$zip_file_path = $path.'/'.$slug.'.zip';
						if(file_exists($zip_file_path)){ 
						//copy zip file to ftp
							$ftp_path = $this->source_zip_move($zip_file_path);
							if($ftp_path!=false){
								//ftp
					$post_status = array('ftp' => date('H:i:s'));
					$this->db->where('order_id', $row['id']);
					$this->db->update('source_tracker', $post_status);
					
								//update ftp_path in cat_result and move column to archive_catresult2015 table
								$this->db->trans_begin();

								$post = array('ftp_source_path' => $ftp_path);
								$this->db->where('id', $cat_result['id']);
								$this->db->update('cat_result', $post);
								//Insert
								$cat_id = $cat_result['id'];
								//$this->db->query("INSERT INTO `archive_catresult2015` SELECT * FROM `cat_result` WHERE `id` = '$cat_id'");
								
								if ($this->db->trans_status() === FALSE){
										$this->db->trans_rollback();
								}else{
									//Delete
									//$this->db->query("DELETE FROM `cat_result` WHERE `id` = '$cat_id'");
										$this->db->trans_commit();
										$folder_path = 'sourcefile/'.$cat_result['order_no'];
										//$this->delete_files($folder_path);
										if($this->delete_files($folder_path) == true){
											//delete
                        					$post_status = array('delete' => date('H:i:s'));
                        					$this->db->where('order_id', $row['id']);
                        					$this->db->update('source_tracker', $post_status);
					
											$this->db->update('orders',array('source_del' => '1'),array('id' => $row['id']));
										}
								}
							}
						}
					}
				}
			}else{ 
				$this->db->update('orders',array('source_del' => '1'),array('id' => $order_id));
				echo "No Orders";
			}
		}
	} 
	
	public function zip_folder_select($data) //zip files
	{
		$slug = $data['slug'];
		$path = $data['path'];
		$source_file_path = $data['source_file_path'];
		$pdf_file_path = $data['pdf_file_path'];
		$font_path = $path.'/Document fonts/';
		$links_path = $path.'/Links/';
		
		$this->load->library('zip');
		$this->load->helper('directory');
			
			//Source file
			if(file_exists($source_file_path)){
				$this->zip->read_file($source_file_path);
			}else{ echo"<script>alert('source file not found');</script>"; }
			//PDF file
			if(file_exists($pdf_file_path)){
				$this->zip->read_file($pdf_file_path);
			}else{ echo"<script>alert('pdf file not found');</script>"; }
			
			$map_font = directory_map($font_path.'/');
			$map_link = directory_map($links_path.'/');
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){
				$this->zip->read_dir($links_path, FALSE);
			}
		$this->zip->archive($path.'/'.$slug.'.zip');
		$this->zip->clear_data(); //avoid loading all file in one folder
		//$this->zip->download($slug.'.zip');
		return true;
	}
	
	public function source_zip_move($path)	//move zip file to ftp
	{ 
		if(isset($path) && file_exists($path)){
			$ftp_server1 = 'ftps1a4l1.adwitads.com';
			$ftp_server2 = 'ftps1a4l2.adwitads.com';
			$ftp_server3 = 'ftps1a4l3.adwitads.com';
			
			if (!@ftp_connect($ftp_server1)) {
				
				if (!@ftp_connect($ftp_server2)){ 
					
					$ftp_conn = @ftp_connect($ftp_server3) or die("couldnt connect to $ftp_server3");
				}else{
					$ftp_conn = ftp_connect($ftp_server2) or die("Could not connect to $ftp_server2");
				}
			}else{
				$ftp_conn = ftp_connect($ftp_server1) or die("Could not connect to $ftp_server1");
			}
			
			$ftp_username='';
			$ftp_userpass='';
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			
			$file = $path;
			$fname = basename($file);
			$ftppath = './'.$fname;
			// upload file
			if (@ftp_put($ftp_conn, $ftppath, $file, FTP_BINARY)){
				if(!ftp_nlist($ftp_conn, $ftppath)){
					echo "No ftp file : ".$fname;
					ftp_close($ftp_conn); return false;
				}else{
					$ftppath = 'http://ftps1a4l1.adwitads.com/sourcearchive/'.$fname;
					ftp_close($ftp_conn); return $ftppath;
				}
			}else{
				echo"FTP Upload Failed for : $file";
			}
		}
	}
	
	public function delete_files($path)		//Delete folder&files
	{	
		//$path = 'sourcefile/182626';
		$this->load->helper("file");
		if(is_dir($path)){
			//echo $path.'<br/>';
			$map = glob($path.'/*');
			if($map){ delete_files($path, true);
				foreach($map as $row)
				{ 
					delete_files($row, true);
					//echo $row.'<br/>';
					if(is_dir($row)){
						$map1 = glob($row.'/*');
						foreach($map1 as $row2){ delete_files($row2, true);
							//echo $row2.'<br/>';
							if(is_dir($row2)){
								$map2 = glob($row2.'/*');
								foreach($map2 as $row3){ delete_files($row3, true);	//Delete files
									//echo $row3.'<br/>';
								}
								
							}
						}	
					}
				}
			}
			if(rmdir($path)){	//remove folder
				return true;
			}
		}
	}
//	source zip, ftp, delete
	public function order_source_tracker()
	{
		$data['month11'] = date('Y-m', strtotime('-11 month'));
		$data['month10'] = date('Y-m', strtotime('-10 month'));
		$data['month9'] = date('Y-m', strtotime('-9 month'));
		$data['month8'] = date('Y-m', strtotime('-8 month'));
		$data['month7'] = date('Y-m', strtotime('-7 month'));
		$data['month6'] = date('Y-m', strtotime('-6 month'));
		$data['month5'] = date('Y-m', strtotime('-5 month'));
		$data['month4'] = date('Y-m', strtotime('-4 month'));
		$data['month3'] = date('Y-m', strtotime('-3 month'));
        $data['month2'] = date('Y-m', strtotime('-2 month'));
        $data['month1'] = date('Y-m', strtotime('-1 month'));
		if(isset($_GET['month'])){
			$month = $_GET['month'];
			$src_tracker = $this->db->get_where('source_tracker',array('month' => $month))->row_array();
			if(!isset($src_tracker['id'])){
				$from = $month.'-01';
				$to = $month.'-31';
				$orders = $this->db->query("SELECT * FROM `orders` WHERE `source_del`='0' AND `pdf`!='none' AND `created_on` BETWEEN '$from' AND '$to'; ")->result_array();
				foreach($orders as $row){
					$order_id = $row['id'];
					$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='$order_id' AND `source_path`!='none' AND `pdf_path`!='none' ")->row_array();
					if(isset($cat_result['order_no'])){
						$post = array('order_id' => $row['id'], 'start' => date("H:i:s"), 'month' => $month);
						$this->db->insert('source_tracker', $post);
					}
				}
			}
			$data['src_tracker'] = $this->db->get_where('source_tracker',array('month' => $month))->result_array();
			$data['month'] = $month;
		}
		$this->load->view('cron_jobs/order_source_tracker', $data);
	}
	
	public function action_zip($month='')
	{
		$src_tracker = $this->db->get_where('source_tracker',array('month' => $month, 'zip' => '00:00:00'))->result_array();
		if(isset($src_tracker[0]['id'])){
			foreach($src_tracker as $row){
				$order_id = $row['order_id'];
				$cat_result = $this->db->query("SELECT * FROM `cat_result` WHERE `order_no`='$order_id' AND `source_path`!='none' AND `pdf_path`!='none' ")->row_array();
				if(isset($cat_result['order_no'])){
					$source_file_path = 'none';
					$path = $cat_result['source_path'];
					$slug = $cat_result['slug'];
					$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`='$order_id' AND `source_file`!='none' AND `pdf_file`!='none' ORDER BY `id` DESC LIMIT 1;")->row_array();
					//if revision ad get the latest source & pdf file
					if(isset($rev_orders['id'])){
						$slug = $rev_orders['new_slug'];
						$source_file = $rev_orders['source_file'];
						$pdf_file = $rev_orders['pdf_file'];
						$source_file_path = $path.'/'.$source_file;
						$pdf_file_path = $path.'/'.$pdf_file;
					
					}else{
						//if new ad get the source & pdf file using the source path
						$indd = $path.'/'.$slug.'.indd';
						$psd = $path.'/'.$slug.'.psd';
						if(file_exists($indd)){
							$source_file_path = $indd;
							$source_file = $slug.'.indd';
						}elseif(file_exists($psd)){
							$source_file_path = $psd;
							$source_file = $slug.'.psd';
						}
						$pdf_file_path = $cat_result['pdf_path'];
						$pdf_file = basename($pdf_file_path);
					}
					//zip the files
					if(isset($source_file_path) && file_exists($source_file_path) && file_exists($pdf_file_path)){
						$data['source_file_path'] = $source_file_path;
						$data['pdf_file_path'] = $pdf_file_path;
						$data['slug'] = $slug;
						$data['path'] = $path;
						$data['source_file'] = $source_file;
						$data['pdf_file'] = $pdf_file;
						//check for file size
			             /*   $source_package_size = $this->GetDirectorySize($path); //In bytes
			                $tsize = number_format($source_package_size / 1048576, 2); //In MB
			                $allowed_fsize = '250'; //In MB
                			   if($tsize > $allowed_fsize){
                			   }
                		*/	   
						if($this->zip_folder_select($data)==true){
							$zip_file_path = $path.'/'.$slug.'.zip';
							if(file_exists($zip_file_path)){
								//zipfile
								$post_status = array('zip' => date('H:i:s'), 'zip_file_path' => $zip_file_path);
								$this->db->where('order_id', $order_id);
								$this->db->update('source_tracker', $post_status);
							}
						}
					}else{ continue; }
				}
			}
			redirect("cron_jobs/home/order_source_tracker?month=$month");
		}
		redirect("cron_jobs/home/order_source_tracker?month=$month");
	}
	
	public function action_ftp($month='')
	{
		$src_tracker = $this->db->get_where('source_tracker',array('month' => $month, 'ftp' => '00:00:00', 'zip_file_path !=' => 'none'))->result_array();
		if(isset($src_tracker[0]['id'])){ echo"src_tracker - ".$src_tracker[0]['id'];
			foreach($src_tracker as $row){
				$order_id = $row['order_id'];
				$zip_file_path = $row['zip_file_path'];
				if(file_exists($zip_file_path)){
					//$ftp_path = $this->source_zip_move($zip_file_path);//call to ftp function
					$ftp_path = "sourcearchive/".basename($zip_file_path);
					if(copy($zip_file_path, $ftp_path)){
					//if($ftp_path!=false){
						$ftp_source_path = base_url().$ftp_path;
						$this->db->trans_begin(); 
						$post = array('ftp_source_path' => $ftp_source_path);//update ftp_path in cat_result
						$this->db->where('order_no', $order_id);
						$this->db->update('cat_result', $post);
						if ($this->db->trans_status() === FALSE){
							$this->db->trans_rollback();
						}else{
							$this->db->trans_commit();
							$post_status = array('ftp' => date('H:i:s'));
							$this->db->where('order_id', $order_id);
							$this->db->update('source_tracker', $post_status);
						}
					}
				}
			}
		}
		redirect("cron_jobs/home/order_source_tracker?month=$month");
	}
	
	public function action_delete($month='')
	{
		$src_tracker = $this->db->get_where('source_tracker',array('month' => $month, 'ftp !=' => '00:00:00', 'delete' => '00:00:00'))->result_array();
		if(isset($src_tracker[0]['id'])){
			foreach($src_tracker as $row){
				$order_id = $row['order_id'];
				$folder_path = 'sourcefile/'.$order_id;
				if($this->delete_files($folder_path) == true){
					$this->db->update('orders',array('source_del' => '1'),array('id' => $order_id));//update orders table
					
					$post_status = array('delete' => date('H:i:s'));//delete
					$this->db->where('order_id', $order_id);
					$this->db->update('source_tracker', $post_status);
				}
			}
		}
		redirect("cron_jobs/home/order_source_tracker?month=$month");
	}

    function GetDirectorySize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }
    
	public function downloads_clear()
	{
		$data['month11'] = date('Y-m', strtotime('-11 month'));
		$data['month10'] = date('Y-m', strtotime('-10 month'));
		$data['month9'] = date('Y-m', strtotime('-9 month'));
		$data['month8'] = date('Y-m', strtotime('-8 month'));
		$data['month7'] = date('Y-m', strtotime('-7 month'));
		$data['month6'] = date('Y-m', strtotime('-6 month'));
		$data['month5'] = date('Y-m', strtotime('-5 month'));
		$data['month4'] = date('Y-m', strtotime('-4 month'));
		$data['month3'] = date('Y-m', strtotime('-3 month'));
        $data['month2'] = date('Y-m', strtotime('-2 month'));
        $data['month1'] = date('Y-m', strtotime('-1 month'));
		if(isset($_GET['month'])){
			$month = $_GET['month'];
			$from = $month.'-01';
			$to = $month.'-31';
			$orders = $this->db->query("SELECT `id`, `created_on`, `file_path`  FROM `orders` WHERE `file_path` != 'none' AND `down_del`='0' AND `created_on` BETWEEN '$from' AND '$to'; ")->result_array();
			$data['month'] = $month;
			$data['orders'] = $orders;
		}
		$this->load->view('cron_jobs/downloads_clear', $data);
	}
	
	public function action_download_delete($month='')
	{
		if($month != ''){
			$from = $month.'-01';
			$to = $month.'-31';
			$orders = $this->db->query("SELECT * FROM `orders` WHERE `down_del`='0' AND `created_on` BETWEEN '$from' AND '$to'; ")->result_array();
			if($orders && count($orders) > '0'){
				foreach($orders as $row){
					$path = 'none';
					if(file_exists($row['file_path']) && $row['file_path']!='downloads' && $row['file_path']!='downloads/')
					{
						$path = $row['file_path'];
					}
					
					if($path!='none' && file_exists($path)){
						//echo $dir_name."file exists<br/>";
						$this->load->helper("file");
						delete_files($path, true); 
						if(rmdir($path)){
							$this->db->update('orders',array('down_del' => '1'),array('id' => $row['id']));					 
						}
					}//else{ echo $path."file dnt exists <br/>"; }
				}
			}
		}
		redirect("cron_jobs/home/downloads_clear?month=$month");
	}
	
	public function rev_downloads_clear()
	{
		$data['month11'] = date('Y-m', strtotime('-11 month'));
		$data['month10'] = date('Y-m', strtotime('-10 month'));
		$data['month9'] = date('Y-m', strtotime('-9 month'));
		$data['month8'] = date('Y-m', strtotime('-8 month'));
		$data['month7'] = date('Y-m', strtotime('-7 month'));
		$data['month6'] = date('Y-m', strtotime('-6 month'));
		$data['month5'] = date('Y-m', strtotime('-5 month'));
		$data['month4'] = date('Y-m', strtotime('-4 month'));
		$data['month3'] = date('Y-m', strtotime('-3 month'));
        $data['month2'] = date('Y-m', strtotime('-2 month'));
        $data['month1'] = date('Y-m', strtotime('-1 month'));
		if(isset($_GET['month'])){
			$month = $_GET['month'];
			$from = $month.'-01';
			$to = $month.'-31';
			$rev_orders = $this->db->query("SELECT `id`, `order_no`, `date`, `file_path` FROM `rev_sold_jobs` WHERE `file_path` != 'none' AND `down_del`='0' AND `date` BETWEEN '$from' AND '$to'; ")->result_array();
			$data['month'] = $month;
			$data['rev_orders'] = $rev_orders;
		}
		$this->load->view('cron_jobs/rev_downloads_clear', $data);
	}
	
	public function action_rev_delete($month='')
	{
		if($month != ''){
			$from = $month.'-01';
			$to = $month.'-31';
			$rev_orders = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `down_del`='0' AND `date` BETWEEN '$from' AND '$to'; ")->result_array();
			if($rev_orders && count($rev_orders) > '0'){
				foreach($rev_orders as $row){
					$path = 'none';
					if(file_exists($row['file_path']) && $row['file_path']!='revision_downloads' && $row['file_path']!='revision_downloads/')
					{
						$path = $row['file_path'];
					}
					if($path!='none' && file_exists($path)){
						$this->load->helper("file");
						//map the path
						$map = glob($path.'/*');
						if($map){
						    foreach($map as $frow){ 
						        if(is_dir($frow)){
						            delete_files($frow, true); 
						            rmdir($frow);
						        }
            				}
						}
						delete_files($path, true); 
						if(rmdir($path)){
							$this->db->update('rev_sold_jobs',array('down_del' => '1'),array('id' => $row['id']));					 
						}
					}
				}
			}
		}
		redirect("cron_jobs/home/rev_downloads_clear?month=$month");
	}
	
	public function pdf_move()
	{
	    $y = date("Y");
		$data['yearArray'] = range(2013, $y);
		//$data['yearArray'] = range(2013, 2018);
		$data['monthArray'] = range(1, 12);
		if((isset($_GET['month']) && !empty($_GET['month'])) && (isset($_GET['year']) && !empty($_GET['year']))){
			$year = $_GET['year'];
			$month = $_GET['month'];
			$date = $year.'-'.$month;
			//orders
				$orders = $this->db->query("SELECT `id`, `pdf` FROM `orders` WHERE `created_on` LIKE '$date%' AND `pdf` LIKE 'pdf_uploads%';")->result_array();
			//rev_sold_jobs	
				$rev_sold_jobs = $this->db->query("SELECT `id`, `order_id`, `date`, `pdf_path` FROM `rev_sold_jobs` WHERE `date` LIKE '$date%' AND `pdf_path` LIKE 'pdf_uploads%';")->result_array();
			
			if(isset($_GET['move'])){ 
				//orders
				foreach($orders as $row){
					$path = $row['pdf'];
					if(file_exists($path)){
						//move pdf file from pdf_uploads to pdfarchive
						$pathinfo = pathinfo($path);
						$dir = explode('/', $pathinfo['dirname']);
						$dir1 = $dir[0];
						$dir2 = $dir[1];
						$fname = $pathinfo['basename'];
						
						$new_path = "pdfarchive/".$dir2;
						if (@mkdir($new_path,0777)){ }
						if(file_exists($new_path)){
							$new_path = $new_path."/".$fname;
							if(rename($path, $new_path)){
								//update link
								if(file_exists($new_path)){
									//echo"moved";
									$this->db->update('orders',array('pdf' => $new_path),array('id' => $row['id']));
									//remove directory
									if(file_exists($path)){
    									if(rmdir($pathinfo['dirname'])){
    										//echo"deleted";
    									}
									}
								}
							}
						}
					}else{ echo '<br/>New Ad - '.$path.' - path doesnt exists'; }
				}
				//rev_sold_jobs
				foreach($rev_sold_jobs as $row){
					$path = $row['pdf_path'];
					if(file_exists($path)){
						//move pdf file from pdf_uploads to pdfarchive
						$pathinfo = pathinfo($path);
						$dir = explode('/', $pathinfo['dirname']);
						$dir1 = $dir[0];
						$dir2 = $dir[1];
						$fname = $pathinfo['basename'];
						
						$new_path = "pdfarchive/".$dir2;
						if (@mkdir($new_path,0777)){ }
						if(file_exists($new_path)){
							$new_path = $new_path."/".$fname;
							if(rename($path, $new_path)){
								//update link
								if(file_exists($new_path)){
									//echo"moved";
									$this->db->update('rev_sold_jobs',array('pdf_path' => $new_path),array('id' => $row['id']));
									//remove directory
									if(file_exists($path)){
									    if(rmdir($pathinfo['dirname'])){
										    //echo"deleted";
									    }
									}
								}
							}
						}else{ echo '<br/>'.$new_path.' - path doesnt exists'; }
					}else{ echo '<br/>Revision Ad - '.$path.' - path doesnt exists'; }
				}
				$orders = $this->db->query("SELECT `id` FROM `orders` WHERE `created_on` LIKE '$date%' AND `pdf` LIKE 'pdf_uploads%';")->result_array();
				$rev_sold_jobs = $this->db->query("SELECT `id` FROM `rev_sold_jobs` WHERE `date` LIKE '$date%' AND `pdf_path` LIKE 'pdf_uploads%';")->result_array();
			}
			
			$data['orders'] = count($orders);
			$data['rev_sold_jobs'] = count($rev_sold_jobs);
			$data['month'] = $month;
			$data['year'] = $year;
		}else{ echo "Provide Year & Month"; }
		$this->load->view('cron_jobs/pdf_move', $data);
	}
	
//metro_csv_orders
	public function metro_csv_orders()
	{
	    $file_path = '/home/adwitac/public_html/metroaod/incoming/New Order/*.zip';
		$file_path = glob($file_path);

		$this->load->library('Unzip');//$zip = new ZipArchive;
		foreach($file_path as $zipfilename)
		{
			$folderName = basename($zipfilename, ".zip");//get file name only
			$upload_path = '/home/adwitac/public_html/metroaod/incoming/New Order/'.$folderName;
			
			if(!file_exists($upload_path)){
				if(@mkdir($upload_path, 0777)){ }
				$this->unzip->extract($zipfilename, $upload_path);
				/*$res = $zip->open($zipfilename);

				if ($res === TRUE) {
				  $zip->extractTo($upload_path);
				} else { 
					echo 'cannot open the zip file'; 
				} 
				$zip->close();*/
			}//else{ echo"folder exists"; }	

			//csv import to database(metro_orders)/public_html/weborders/weborders_downloads/metroaod/csv
			//$dir = '/home/adwitac/public_html/metroaod/csv/2018*.csv';			//only todays files	
			$y = date("Y");
			$dir = $upload_path.'/'.$y.'*.csv';
			
			$files = glob($dir);
			foreach($files as $filename)
			{
				//echo $filename."<br/>";
				//$search = mysql_query("SELECT * from `metro_orders` WHERE `file`='$filename';");
				//$num_rows = mysql_num_rows($search);
				$num_rows = $this->db->query("SELECT * from `metro_orders` WHERE `file`='$filename';")->num_rows();
				if($num_rows=='0'){
					$handle = fopen($filename, "r");

					$count = 0;
					while (($data = fgetcsv($handle, 100000, ",")) !== FALSE)
					{
						for($i=0;$i<33;$i++){
							$data[$i] = str_replace("'","",$data[$i]);
						}
						if($count)
						{
							$import = "INSERT into `metro_orders` (`order_type`, `metro_ref`, `job_num`, `prev_job_num`, `req_by`, `stage`, `submitted_date`, `required_date`, `publish_date`, `account`, `advertiser`, `publication`, `ad_type`, `ad_kind`, `ad_format`, `ad_size`, `ad_color`, `width`, `height`, `columns`, `sq_inches`, `max_filesize`, `audio`, `splash`, `metro_spec_ads`, `metro_artwork`, `color_preference`, `font_preference`, `ad_design`, `time_zone`, `production_version`, `last_action_date`, `last_customer_msg`, `file`)
									values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]','$data[31]','$data[32]', '$filename')";
							//mysql_query($import) or die(mysql_error());
							$this->db->query($import);
						}
						$count++;
					} 
					fclose($handle); 
				} 
			}
			//delete zip file
			unlink($zipfilename);
		}
	}

    public function map_orders() //map API for new orders adwitmap
	{
		if(isset($_POST['id'])){ 
			$map_id = $_POST['id'];
			$pub_id = $_POST['pub_id'];
			$job_name = $_POST['job_name'];
			$data = array(
						"map_id" => $map_id,
						"main_orders_id" => $_POST['main_orders_id'],
						"user_id" => $_POST['adwitads_adrep_id'],
						"order_type_id" => $_POST['order_type'],
						"adv_id" => $_POST['name'],
						"pub_id" => $pub_id,
						"job_name" => $job_name,
						"num_ads" => $_POST['num_ads'],
						"status" => $_POST['status'],
						"file_path" => $_POST['file_path'],
						"created_on" => $_POST['created_on'],
						"od_id" => $_POST['od_id'],
						"order_id" => $_POST['order_id'],
						"size_id" => $_POST['size_id'],
						"width" => $_POST['width'],
						"height" => $_POST['height'],
						"job_instruction" => $_POST['job_instruction'],
						"art_work" => $_POST['art_work'],
						"color_preferences" => $_POST['color_preferences'],
						"font_preferences" => $_POST['font_preferences'],
						"copy_content_description" => $_POST['copy_content_description'],
						"notes" => $_POST['notes'],
						"publish_date" => $_POST['publish_date'],
						"date_needed" => $_POST['date_needed'],
						"print_ad_type" => $_POST['print_ad_type'],
						"web_ad_type" => $_POST['web_ad_type'],
						"pixel_size" => $_POST['pixel_size'],
						"custom_width" => $_POST['custom_width'],
						"custom_height" => $_POST['custom_height'],
						"ad_format" => $_POST['ad_format'],
						"maximum_file_size" => $_POST['maximum_file_size'],
						"adwitads_pickup_id" => $_POST['adwitads_id']
					);
			$this->db->insert('map_orders', $data);
			$id = $this->db->insert_id();
			if($id){
				if(isset($_FILES['file']['tmp_name'])){
					$uploadfile = "map_downloads/".$map_id.".zip";
					move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
				}
							
			}else{
				$error = $this->db->_error_message();
				echo $error;
			}		
		}			
	}
	
	public function map_rev_orders() //map API for rev orders adwitmap
	{
		if(isset($_POST['id'])){ 
			//print_r($_POST);
			$map_order_id = $_POST['order_id'];
			$order = $this->db->get_where('orders', array('map_order_id' => $map_order_id))->row_array();
			if(isset($order['id']) && $order['status'] == '5'){
				$orderid = $order['id'];
				$version = 'V1a'; 
				$orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$orderid' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
				$cat_result = $this->db->get_where('cat_result',array('order_no' => $orderid))->row_array();
				if(isset($orders_rev['id'])){
					$slug = $orders_rev['new_slug']; 
					$version = $orders_rev['version'];
					if($version == 'V1a'){ $version = 'V1b'; }
						elseif($version == 'V1b'){ $version = 'V1c'; }
						elseif($version == 'V1c'){ $version = 'V1d'; }
						elseif($version == 'V1d'){ $version = 'V1e'; }
						elseif($version == 'V1e'){ $version = 'V1f'; }
						elseif($version == 'V1f'){ $version = 'V1g'; }
						elseif($version == 'V1g'){ $version = 'V1h'; }
						elseif($version == 'V1h'){ $version = 'V1i'; }
						elseif($version == 'V1i'){ $version = 'V1j'; }
						elseif($version == 'V1j'){ $version = 'V1k'; }
						elseif($version == 'V1k'){ $version = 'V1l'; }
						elseif($version == 'V1l'){ $version = 'V1m'; }
				}else{
					$slug = $cat_result['slug'];
				}
				$rev_data = array(
									'order_id' => $orderid,
									'order_no' => $slug,
									'adrep' => $order['adrep_id'],
									'help_desk' => $order['help_desk'],
									'date' => date('Y-m-d'),
									'time' => date("H:i:s"),
									'category' => 'revision',
									'version' => $version,
									'note' => $_POST['note'],
									'status' => '1',
									'map_revorder_id' => $_POST['id'],
								);
				$this->db->insert('rev_sold_jobs',$rev_data);
				$rev_id = $this->db->insert_id(); 
				if($rev_id){
					//orders update
					$rev_count = $order['rev_count'];
					$rev_count_data = array(
											'rev_count' => $rev_count + '1', 
											'rev_id' =>$rev_id,
											'activity_time' => date('Y-m-d h:i:s'),
											);
					$this->db->where('id', $orderid);
					$this->db->update('orders', $rev_count_data);
					
					//folder creation
					$path = "revision_downloads/".$orderid.'-'.$rev_id; 
					if (@mkdir($path,0777))	{}
					//save path
					$post = array('file_path' => $path);
					$this->db->where('id', $rev_id);
					$this->db->update('rev_sold_jobs', $post);
					//file upload
					if(isset($_FILES['file']['tmp_name'])){
						$fileName = $_FILES['file']['name'];
						$uploadfile = $path.'/'.$fileName;
						move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
					}
				}/*else{
					$error = $this->db->_error_message();
					echo $error;
				}*/
			}
		}
	}
	
  /*public function move_sourcearchive_ftp()
	{
		$query = "SELECT `id`, `ftp_source_path`  FROM `cat_result` WHERE `ftp_source_path` LIKE 'https%' LIMIT 1";
		$result = $this->db->query($query)->result_array();
		if(isset($result[0]['id'])){
			//ftp connection
			$ftp_server = '23.235.222.72';
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			
			$ftp_username='';
			$ftp_userpass='';
			
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			ftp_pasv($ftp_conn, true);
			
			foreach($result as $row){ 
				$ftp_source_path = $row['ftp_source_path'];
				$file = basename($ftp_source_path);
				$file_path = "sourcearchive/".$file;
				if(file_exists($file_path)){
					echo "File Exists - ".$file."<br/>";
					
					$ftppath = '/'.$file;
					if ( @ftp_put($ftp_conn, $ftppath, $file_path, FTP_BINARY) ){
						//$ftp_source_path = "http://adwitmap.com/adwitadssourcefile/".$file;
						//$post = array('ftp_source_path' => '');
						//$this->db->where('id', $row['id']);
						//$this->db->update('cat_result', $post);
							echo $row['id']." : file moved <br/>";
						//delete files
						
							
					}
				}
				
			}
		}else{ echo "no orders"; }
	}*/
	
	public function move_sourcearchive_ftp()
	{
		$data['month11'] = date('Y-m', strtotime('-11 month'));
		$data['month10'] = date('Y-m', strtotime('-10 month'));
		$data['month9'] = date('Y-m', strtotime('-9 month'));
		$data['month8'] = date('Y-m', strtotime('-8 month'));
		$data['month7'] = date('Y-m', strtotime('-7 month'));
		$data['month6'] = date('Y-m', strtotime('-6 month'));
		$data['month5'] = date('Y-m', strtotime('-5 month'));
		$data['month4'] = date('Y-m', strtotime('-4 month'));
		$data['month3'] = date('Y-m', strtotime('-3 month'));
        $data['month2'] = date('Y-m', strtotime('-2 month'));
        $data['month1'] = date('Y-m', strtotime('-1 month'));
		if(isset($_GET['month'])){
			$month = $_GET['month'];
			$from = $month.'-01';
			$to = $month.'-31';
			$key = "https://adwitads.com/weborders/sourcearchive";
			$query = "SELECT `id`, `order_no`, `ftp_source_path`  FROM `cat_result` WHERE (`timestamp` BETWEEN '$from' AND '$to') AND `ftp_source_path` LIKE '$key%' ";
			//$query = "SELECT `id`, `order_no`, `ftp_source_path`  FROM `cat_result` WHERE `id` = '544531' ";
			$result = $this->db->query($query)->result_array();
			if(isset($result[0]['id'])){
				$data['result'] = $result;
			}else{
				$this->session->set_flashdata("message","No Orders Found..");
				redirect('cron_jobs/home/move_sourcearchive_ftp/'.$month);
			}
			$data['month'] = $month;
		}
		$this->load->view('cron_jobs/move_sourcearchive_ftp', $data);
	}
	
	public function action_move_sourcearchive_ftp($month='')
	{ 
		if($month != ''){
			$from = $month.'-01';
			$to = $month.'-31';
			$key = "https://adwitads.com/weborders/sourcearchive";
			$query = "SELECT `id`, `ftp_source_path`  FROM `cat_result` WHERE (`timestamp` BETWEEN '$from' AND '$to') AND `ftp_source_path` LIKE '$key%' ";
			        //$query = "SELECT `id`, `ftp_source_path`  FROM `cat_result` WHERE `order_no` = '822616' ";
			        //echo $query;
			$result = $this->db->query($query)->result_array();
			if(isset($result[0]['id'])){
				$i = 0;
				foreach($result as $row){ 
					$ftp_source_path = $row['ftp_source_path'];
					$file = basename($ftp_source_path);
					$file_path = "sourcearchive/".$file;
					if(file_exists($file_path)){
						        //echo "File Exists - ".$file."<br/>";
						$ftppath = '/home/adwitac/public_html/source_backup/'.$file; //path for the file to move
						if( @rename($file_path, $ftppath) ){
							//update path
								$ftp_source_path = "https://adwitads.com/source_backup/".$file; //url path to access
								$post = array('ftp_source_path' => $ftp_source_path);
								$this->db->where('id', $row['id']);
								$this->db->update('cat_result', $post);
							
						    //delete files
							if(file_exists($file_path) && $this->db->affected_rows()){
								unlink($file_path);
							}
							$i++;
						}//else{ echo "ftp put fail - ".$file."<br/>"; }
					}//else{ echo "No File Exists - ".$file."<br/>"; }
					
				}
				$this->session->set_flashdata("message", $i." Files Moved");
				redirect('cron_jobs/home/move_sourcearchive_ftp/'.$month);
			}else{
				$this->session->set_flashdata("message","No Orders Found..");
				redirect('cron_jobs/home/move_sourcearchive_ftp/'.$month);
			}
		}
	}
	/*
	public function action_move_sourcearchive_ftp($month='')
	{
		if($month != ''){
			$from = $month.'-01';
			$to = $month.'-31';
			$query = "SELECT `id`, `ftp_source_path`  FROM `cat_result` WHERE (`timestamp` BETWEEN '$from' AND '$to') AND `ftp_source_path` LIKE 'https%' ";
			//$query = "SELECT `id`, `ftp_source_path`  FROM `cat_result` WHERE `id` = '544531' ";
			$result = $this->db->query($query)->result_array();
			if(isset($result[0]['id'])){
				
				//ftp connection
				$ftp_server = 'ftps1a4l1.adwitads.com';
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				
				$ftp_username='adwitadssourcearch';
				$ftp_userpass='ftp@123';
				
				$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
				ftp_pasv($ftp_conn, true);
				$i = 0;
				foreach($result as $row){ 
					$ftp_source_path = $row['ftp_source_path'];
					$file = basename($ftp_source_path);
					$file_path = "sourcearchive/".$file;
					if(file_exists($file_path)){
						//echo "File Exists - ".$file."<br/>";
						
						$ftppath = '/adwitadssourcearch/'.$file;
						if ( @ftp_put($ftp_conn, $ftppath, $file_path, FTP_BINARY) ){
							//update path
								$ftp_source_path = "http://ftps1a4l1.adwitads.com/sourcearchive/".$file;
								$post = array('ftp_source_path' => $ftp_source_path);
								$this->db->where('id', $row['id']);
								$this->db->update('cat_result', $post);
								//echo $row['id']." : file moved <br/>";
							//delete files
							if($this->db->affected_rows()){
								unlink($file_path);
								$i++;
							}
						}//else{ echo "ftp put fail - ".$file."<br/>"; }
					}//else{ echo "No File Exists - ".$file."<br/>"; }
					
				}
				$this->session->set_flashdata("message", $i." Files Moved");
				redirect('cron_jobs/home/move_sourcearchive_ftp/'.$month);
			}else{
				$this->session->set_flashdata("message","No Orders Found..");
				redirect('cron_jobs/home/move_sourcearchive_ftp/'.$month);
			}
		}
	}
	*/
	public function account_sign_up()
	{
	    if(isset($_POST['email_id']) && !empty($_POST['email_id'])){
			$fname = $_POST['first_name'];
			$lname = $_POST['last_name'];
			$email_id = $_POST['email_id'];
			$company_name = $_POST['company_name'];
			
			$msg_body = 'First Name : '.$fname.'<br/>';
			$msg_body .= 'Last Name : '.$lname.'<br/>';
			$msg_body .= 'Email Id : '.$email_id.'<br/>';
			$msg_body .= 'Company Name : '.$company_name.'<br/>';
			
			$data['msg_body'] = $msg_body;
			if($this->send_mail($data) == true){
			  redirect('cron_jobs/home/success'); 
			}
	    }
	    $this->load->view('cron_jobs/account_sign_up');
	}
	
	public function send_mail($data)
	{ 
		$from_email = 'itsupport@adwitads.com'; 
		$to_email =  'itsupport@adwitads.com';
		
		//Load email library 
		$config = Array( 'mailtype' => 'html' );
		$this->load->library('email', $config);
		
		$this->email->from($from_email,'AdwitGlobal'); 
		$this->email->to($to_email);
		//$this->email->bcc($ad_recipient);
		$this->email->subject('Adwit Global Account Sign Up ');
		$this->email->message($data['msg_body']);
		
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}
	
	public function success()
	{ 
	    $this->load->view('cron_jobs/success');
	}
	
	public function order_status_one()
	{
		$query = "SELECT id, created_on FROM orders WHERE status='1'";
		$order_details = $this->db->query("$query")->result_array();
		echo date_default_timezone_get().'<br/>';
		date_default_timezone_set('America/New_York');
		$curr_timestamp = date('Y-m-d H:i:s');
		$order_array = array();
		if(isset($order_details[0]['id'])){
			foreach($order_details as $od){
				$min = $this->time_difference($od['created_on']);
				if($min >= 120){
					$order_array[] = '<b>'.$od['id'].'</b> ('.$min.' mins)';
					//echo $od['created_on'].' - '.$curr_timestamp.' = '.$min.' minutes <br/>';
				}
			}
			$dataa['order_array'] = $order_array;
			$this->alert_email($dataa);
		}
	}
	
	function time_difference($created_on)
	{
		$curr_timestamp = date('Y-m-d H:i:s');
		$start_date = new DateTime($created_on);
		$since_start = $start_date->diff(new DateTime($curr_timestamp));
				
				$minutes = $since_start->days * 24 * 60;
				$minutes += $since_start->h * 60;
				$minutes += $since_start->i;
		return $minutes;	
	}
	
	function alert_email($dataa)
	{
		//send email
			$config = array();
			  $config['useragent'] = "CodeIgniter";
			  $config['mailtype']  = 'html';
			  $config['charset']   = 'utf-8';
			  $config['newline']   = "\r\n";
			  $config['wordwrap']  = TRUE;
			  $this->load->library('email');
			  $this->email->initialize($config);
			$this->email->from('do_not_reply@adwitads.com', 'Alert');
			$this->email->reply_to('do_not_reply@adwitads.com', 'Alert');
			
			if(isset($dataa['subject'])){
			    $this->email->subject($dataa['subject']); 
			    $this->email->message($dataa['message']);
			}else{
			    $this->email->subject('Alert: Stuck in order received stays');
			    $this->email->message($this->load->view('order_list_emailer',$dataa, TRUE));
			}
			
			$this->email->set_alt_message("Unable to load text!");
			$this->email->to('sudarshan@adwitads.com, giri@adwitglobal.com', 'test mail');
				
			$this->email->send();
	}
	
	//Waukesha Freeman(Id-580) publication xml file fetch  
	public function preorders_waukesha_fetch()
	{
		//file path
		$archive_path = '/home/adwitac/public_html/wfp';
		$folder_path = '/home/adwitac/public_html/wfp/XML'; //ftp path
		//$folder_path = $path.'/*.xml';

		if($dh = opendir($folder_path)){
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..'){ continue; }
				$filename = $file;
				$xml_file_data = $this->db->query('SELECT `id` FROM `preorders_waukesha` WHERE `filename` = "'.$filename.'"')->row_array();
				if(!isset($xml_file_data['id'])){
    				$valid_extension = array('xml','XML');
    				$file_data = explode('.', $file);
    				$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    //$f = file_get_contents($folder_path.'/'.$file);
    					//$data = simplexml_load_string($f);
    					
    					$use_errors = libxml_use_internal_errors(true);
                		$data = simplexml_load_file($folder_path.'/'.$file);
                		
                		//Error in loading file
                		if (false === $data) {
                          // throw new Exception("Cannot load xml source.\n");
                          $error_msg = '';
                            foreach(libxml_get_errors() as $error) {
                                $error_msg .= "\t". $error->message;
                            }
                          $dataa['error_msg'] = $error_msg;
                          $dataa['subject'] = "Waukesha Preorder File Name : $filename";
                          $dataa['to'] = "sudarshan@adwitads.com, pranav@adwitglobal.com";
                          $this->preorder_alert_email($dataa);
                          $nnew_path = $archive_path.'/Error/'.$filename;
    					  rename($folder_path.'/'.$filename, $nnew_path);
                          continue;
                        }
                        libxml_clear_errors();
                        libxml_use_internal_errors($use_errors);
    					$order_type = 'Print'; //initialise order type to print ads
    					if(isset($data->Order_Record->OrderType)){
    					    $order_type = $data->Order_Record->OrderType;
    					}
    					//insert to table
    					$post_data = array(
    					                    'filename' => $filename,
    					                    'ad_number' => $data->Order_Record->Adnumber,
    					                    'customer_name' => $data->Order_Record->Customer->Name,
    					                    'run_date' => $data->Order_Record->Order_Information->Rundate->Date,
    					                    'height' => $data->Order_Record->Production_Information->Size->height,
    					                    'width' => $data->Order_Record->Production_Information->Size->Columnwidth,
    					                    'numberofcolors' => $data->Order_Record->Production_Information->Color->numberofcolors,
    					                    'adtype' => $data->adtype,
    					                    'adtitle' => $data->Order_Record->Adtitle,
    					                    'instruction' => $data->Order_Record->Production_Information->Instructions,
    					                    'user' => $data->Order_Record->Sales->SalesPersonName,
    					                    'duedate' => $data->Order_Record->Order_Information->duedate,
    					                    'output_type' => $data->Order_Record->Production_Information->OutputType,
    					                    'camera_ready' => $data->camera_ready,
    					                    'account_number' => $data->Order_Record->Customer->Account_number,
    					                    'pickupadnumber' => $data->Order_Record->Production_Information->pickupadnumber,
    					                    'order_type' => $order_type
    					                    );
    					$this->db->insert('preorders_waukesha',$post_data);
    					$id = $this->db->insert_id();
    					if(isset($id)){
    					    //multiple publication
    					    foreach($data->Order_Record->Order_Information->Rundate as $rundate)
                            {
    					        $pub_data = array('xml_file_data_id'=>$id, 'publication'=>$rundate->Publication);
    					        $this->db->insert('preorders_waukesha_publication', $pub_data);
                            }
    					    $new_path = $archive_path.'/archive/'.$filename;
    					    rename($folder_path.'/'.$filename, $new_path);
    					}
    				}
    				/*else
    				{
    				    $output = '<div class="alert alert-warning">Invalid File - '.$filename.'</div>';
    				    echo $output;
    				}*/
				}
			}

			closedir($dh);
		}

	}
	
	public function preorders_desert_shoppers_fetch() //Desert Shoppers-43 xml format feed fetch preorder
	{
	    $archive_path = '/home/adwitac/public_html/aptfeed';
		$folder_path = '/home/adwitac/public_html/aptfeed'; //ftp path
		
		if($dh = opendir($folder_path)){
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..'){ continue; }
				$filename = $file;
				$xml_file_data = $this->db->query('SELECT `id` FROM `preorders_desert_shoppers` WHERE `filename` = "'.$filename.'"')->row_array();
			//	if(!isset($xml_file_data['id'])){
    				$valid_extension = array('xml','XML');
    				$file_data = explode('.', $file);
    				$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    $f = file_get_contents($folder_path.'/'.$file);
    				    $xml   = @simplexml_load_string($f);
    				    
    				    /******In case Error in loading file*******************/
    				    $use_errors = libxml_use_internal_errors(true);
                		$data = simplexml_load_file($folder_path.'/'.$file);
                		if (false === $data) {
                          // throw new Exception("Cannot load xml source.\n");
                            $error_msg = '';
                            foreach(libxml_get_errors() as $error) {
                                $error_msg .= "\t". $error->message;
                            }
                            $dataa['error_msg'] = $error_msg;
                            $dataa['subject'] = "Desert Shoppers Preorder File Name : $filename";
                            $dataa['to'] = "sudarshan@adwitads.com, giri@adwitglobal.com";
                            $this->preorder_alert_email($dataa);
                            $nnew_path = $archive_path.'/Error/'.$filename;
    					    rename($folder_path.'/'.$filename, $nnew_path);
                            continue;
                        }
                        libxml_clear_errors();
                        libxml_use_internal_errors($use_errors);
                        /******END In case Error in loading file***************/
                        
                        $json  = json_encode($xml);
                        $array = json_decode($json,TRUE); 
                        //print_r($array);echo'<br/>';
                        $order_type = 'Print';
                        
                        foreach($array as $value) { 
                           $run_date = '';
                           if(isset($value['Ad']['AdLocInfo'][0])){
                              $run_date =  $value['Ad']['AdLocInfo'][0]['rundates']['date'];
                              $instruction = trim($value['Ad']['AdLocInfo'][0]['sort-text']);
                           }else{
                                if(is_array($value['Ad']['AdLocInfo']['rundates']['date'])){ 
                                    $run_date =  $value['Ad']['AdLocInfo']['rundates']['date'][0]; 
                                }else{
                                    $run_date =  $value['Ad']['AdLocInfo']['rundates']['date']; 
                                }
                              $instruction = trim($value['Ad']['AdLocInfo']['sort-text']);
                           }
                           if($run_date != ''){
                                $rdate = date_create_from_format("mdY",$run_date);
                                $run_date =  date_format($rdate,"m/d/y");       
                           }else{
                                $run_date = date('m/d/y', strtotime(' +1 day'));
                           }
                           $due_date = date('Y-m-d', strtotime(' +1 day'));
                           if($value['Ad']['production-method'] == 'EX'){
                               $camera_ready = 'true';
                           }else{
                               $camera_ready = 'false';
                           }
                           $pickup_number = '';
                           if(!is_array($value['Ad']['pickup-number'])){
                                $pickup_number = $value['Ad']['pickup-number'];   
                           }
                           $numberofcolors = '';
                           if(!is_array($value['Ad']['color-comments'])){
                               $numberofcolors = $value['Ad']['color-comments'];
                               if($numberofcolors == 'FULL'){
                                    $numberofcolors = 'Full Color';   
                               }
                           }
                           //insert to table
        					$post_data = array(
        					                    'filename' => $filename,
        					                    'ad_number' => $value['adwatch-order-number'], 
        					                    'customer_name' => $value['Customer']['Name1'],
        					                    'run_date' => $run_date,
        					                    'height' => $value['Ad']['ad-height'], 
        					                    'width' =>  $value['Ad']['phy-ad-width'], 
        					                    'numberofcolors' => $numberofcolors, 
        					                    'adtype' => $value['Ad']['ad-type'],
        					                    //'adtitle' => $data->AdWatchInfo->Adtitle,
        					                    'instruction' => $instruction,
        					                    'user' => $value['ad-entered-by'],
        					                    'duedate' => $due_date,
        					                    //'output_type' => $value['Production_Information']['OutputType'],
        					                    'camera_ready' => $camera_ready,
        					                    'account_number' => $value['Customer']['account-number'], 
        					                    'pickupadnumber' => $pickup_number, 
        					                    'order_type' => $order_type
        					                    );
        					                    //print_r($post_data);
        					$this->db->insert('preorders_desert_shoppers',$post_data);
        					$id = $this->db->insert_id();
        					if(isset($id)){
        					   //multiple publication
        					  if(isset($value['Ad']['AdLocInfo'][0]['publication'])){
        					      $arr_count = count($value['Ad']['AdLocInfo']);
        					      for($i=0;$i<$arr_count;$i++){
        					        $pub_data = array('xml_file_data_id' => $id, 'publication' => $value['Ad']['AdLocInfo'][$i]['publication']);
        					        $this->db->insert('preorders_desert_shoppers_publication', $pub_data);    
        					      }
        					  }else{ 
        					      $pub_data = array('xml_file_data_id' => $id, 'publication' => $value['Ad']['AdLocInfo']['publication']);
        					       $this->db->insert('preorders_desert_shoppers_publication', $pub_data);
        					  }
        					   
        					    $new_path = $archive_path.'/aptfeed-archive/'.$filename;
        					    rename($folder_path.'/'.$filename, $new_path);
        					}
                        }
    				}else{
    				    $output = '<div class="alert alert-warning">Invalid File - '.$filename.'</div>';
    				    //echo $output;
    				}
			//	}
			}

			closedir($dh);
		}

	}
	
	function preorder_alert_email($dataa)
	{
		//send email
			$config = array();
			  $config['useragent'] = "CodeIgniter";
			  $config['mailtype']  = 'html';
			  $config['charset']   = 'utf-8';
			  $config['newline']   = "\r\n";
			  $config['wordwrap']  = TRUE;
			  $this->load->library('email');
			  $this->email->initialize($config);
			$this->email->from('do_not_reply@adwitads.com', 'Alert');
			$this->email->reply_to('do_not_reply@adwitads.com', 'Alert');
			$this->email->subject('Alert:'.$dataa['subject']);  
			$this->email->message($dataa['error_msg']);
			$this->email->set_alt_message("Unable to load text!");
			$this->email->to($dataa['to'], 'User');
				
			$this->email->send();
	}
	
	public function preorders_waukesha_fetch_single($file)
	{
		//file path
		//$archive_path = '/home/adwitac/public_html/wfp';
		$folder_path = '/home/adwitac/public_html/wfp/Error'; //ftp path
		//$folder_path = $path.'/*.xml';

		
				$filename = $file;
				$xml_file_data = $this->db->query('SELECT `id` FROM `preorders_waukesha` WHERE `filename` = "'.$filename.'"')->row_array();
				if(!isset($xml_file_data['id'])){
    				$valid_extension = array('xml','XML');
    				$file_data = explode('.', $file);
    				$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    $data = simplexml_load_file($folder_path.'/'.$file);
    					//insert to table
    					$post_data = array(
    					                    'filename' => $filename,
    					                    'ad_number' => $data->Order_Record->Adnumber,
    					                    'customer_name' => $data->Order_Record->Customer->Name,
    					                    'run_date' => $data->Order_Record->Order_Information->Rundate->Date,
    					                    'height' => $data->Order_Record->Production_Information->Size->height,
    					                    'width' => $data->Order_Record->Production_Information->Size->Columnwidth,
    					                    'numberofcolors' => $data->Order_Record->Production_Information->Color->numberofcolors,
    					                    'adtype' => $data->adtype,
    					                    'adtitle' => $data->Order_Record->Adtitle,
    					                    'instruction' => $data->Order_Record->Production_Information->Instructions,
    					                    'user' => $data->Order_Record->Sales->SalesPersonName,
    					                    'duedate' => $data->Order_Record->Order_Information->duedate,
    					                    'output_type' => $data->Order_Record->Production_Information->OutputType,
    					                    'camera_ready' => $data->camera_ready,
    					                    'account_number' => $data->Order_Record->Customer->Account_number,
    					                    'pickupadnumber' => $data->Order_Record->Production_Information->pickupadnumber
    					                    );
    					print_r($post_data);
    				}
    			
				}else{ echo"file already in table."; }
		
	}
	
	public function apt_file_clear() //Desert shoppers aptfeed files archieve delete all files and folders except past 4days files
	{
	    $dir = '/home/adwitac/public_html/aptfeed/aptfeed-archive';
	    $directories = glob($dir . '/*' , GLOB_ONLYDIR);
	    
        foreach($directories as $item) {
            $created_date = date("Y-m-d", filemtime(mb_convert_encoding($item,'ISO-8859-1', 'UTF-8')));
            $curr_date = date("Y-m-d", strtotime("-4 day"));
            if($curr_date > $created_date){
                $path = $item;
                $di = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
                $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
                foreach ( $ri as $file ) {
                    $file->isDir() ?  rmdir($file) : unlink($file);
                }
                rmdir($path);
                //return true;
            }
        }
    }
    
    public function order_annotation()
    {
        $this->load->view('cron_jobs/order_annotation');
    }
    
    public function order_annotation_content()
    {
        if(isset($_POST['content'])){
           $content =  $_POST['content'];
           $decode_content = base64_decode($content);
           //echo 'Content details : '.$_POST['content'];
           $myFile = "order_annotation/orderPdf.pdf";
		    $fh = fopen($myFile, 'w+') or die("can't open file");
		    fwrite($fh, $decode_content);
		    fclose($fh);
        }else{
            echo 'no post data';
        }
    }
    
    //hourly status count
    public function hourly_status_count(){ //cron job - curl adwitads.com/weborders/index.php/cron_jobs/home/hourly_status_count
        $today_date_time = $this->db->query("SELECT `time` FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		$current_time = date("H:i:s");
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date)); //echo $day.' '.$current_time;
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		if($day == 'Mon'){ //Friday To Monday
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $day_before_yyday.' '.$ystday_time; //Friday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    	        $from_date_range = $day_before_yyday.' '.$today_time;   //Friday 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
			}
		}elseif($day == 'Sun'){ //Saturday To Sunday
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $day_before_yday.' '.$ystday_time;   //saturday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    		    $from_date_range = $day_before_yday.' '.$today_time;    //saturday 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
			 }    
		}else{
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $ysterday.' '.$ystday_time;          //yesterday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			    //date range for yesterdays ads
			    $yst_from_date_range = $day_before_yday.' '.$ystday_time ;  
			    $yst_to_date_range = $ysterday.' '.$today_time;  
			 }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    	        $from_date_range = $current_date.' '.$today_time;      //today 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //tomorrow 08:29:59
			    //date range for yesterdays ads
			    $yst_from_date_range = $ysterday.' '.$today_time ;  
			    $yst_to_date_range = $current_date.' '.$tomo_time; 
			 }
		}
        //status wise ads count START
		$q_status = "SELECT COUNT(orders.id) as ad_count, order_status.name, order_status.id FROM `orders` 
    								JOIN order_status ON order_status.id = orders.status
    									WHERE (orders.created_on BETWEEN '$from_date_range' AND '$to_date_range')
    									AND orders.crequest != '1' AND orders.cancel !='1'
    									GROUP by orders.status";
    	//echo $q_status;
    	$order_count = $this->db->query("$q_status")->result_array();
    	$order_received_count = $order_accepted_count = $inproduction_count = $quality_check_count = $proof_ready_count = $approved_count = 0;
    	
    	foreach($order_count as $scount){
    	   if($scount['id'] == 1){
    	      $order_received_count = $scount['ad_count']; 
    	   }elseif($scount['id'] == 2){
    	      $order_accepted_count = $scount['ad_count']; 
    	   }elseif($scount['id'] == 3){
    	      $inproduction_count = $scount['ad_count']; 
    	   }elseif($scount['id'] == 4){
    	      $quality_check_count = $scount['ad_count']; 
    	   }elseif($scount['id'] == 5){
    	      $proof_ready_count = $scount['ad_count']; 
    	   }elseif($scount['id'] == 7){
    	      $approved_count = $scount['ad_count']; 
    	   } 
    	}
    	//insert to hourly_order_count table
    	//get to ist date time
    	date_default_timezone_set('Asia/Kolkata');
        $date_ist = date('Y-m-d');
        $hour_ist = date('H');
        
        //reset to est
        date_default_timezone_set('America/New_York');
    	$post_data = array(
                    	    'date'                   => $current_date,
                    	    'hour'                   => date("H"),
                    	    'date_ist'              => $date_ist,
                    	    'hour_ist'              => $hour_ist,
                    	    'order_received_count'   => $order_received_count,
                    	    'order_accepted_count'   => $order_accepted_count,
                    	    'inproduction_count'     => $inproduction_count,
                    	    'quality_check_count'    => $quality_check_count,
                    	    'proof_ready_count'      => $proof_ready_count,
                    	    'approved_count'         => $approved_count
                    	    );
    	$this->db->insert('hourly_order_count', $post_data);
    		
    	$data['order_received_count']   = $order_received_count;
    	$data['order_accepted_count']   = $order_accepted_count;
    	$data['inproduction_count']     = $inproduction_count;
    	$data['quality_check_count']    = $quality_check_count;
    	$data['proof_ready_count']      = $proof_ready_count;
    	$data['approved_count']         = $approved_count;
    	
    	//$this->load->view('hourly_status_count_emailer',$data);
    	//$this->hourly_status_count_mail($data);
    }
    
    function hourly_status_count_mail($data)
	{
		//send email
			$config = array();
			  $config['useragent'] = "CodeIgniter";
			  $config['mailtype']  = 'html';
			  $config['charset']   = 'utf-8';
			  $config['newline']   = "\r\n";
			  $config['wordwrap']  = TRUE;
			  $this->load->library('email');
			  $this->email->initialize($config);
			$this->email->from('do_not_reply@adwitads.com', 'Order Status Count');
			$this->email->reply_to('do_not_reply@adwitads.com', 'Order Status Count');
			$this->email->subject('Hourly - Order Status Count');  
			$this->email->message($this->load->view('hourly_status_count_emailer',$data, TRUE));
			$this->email->set_alt_message("Unable to load text!");
			$this->email->to('pranav@adwitglobal.com'); 
				
			$this->email->send();
	}
	
	/*******************AdwitAPI-Angular START*************************/
	//API for adwitAPI assets attachment
	public function attachmentFiles_upload()
	{
	    $order_id = $_POST['order_id'];
	    
	    $adwitads_api = $this->load->database('otherdb', TRUE);
	    
	    $order_detail = $adwitads_api->query("SELECT * FROM `orders` WHERE `order_id` = '$order_id'")->row_array();
	    if(isset($order_detail['order_id'])){
	        //create folder
	        $jname = $order_detail['job_no'];
	        $path = "downloads/".$order_id."-".$jname; //path specification
			if (@mkdir($path,0777)){}
			
			if(file_exists($path)){
		        //save path
    			$post = array('file_path' => $path);
    			$adwitads_api->where('order_id', $order_id);
    			$adwitads_api->update('orders', $post);
    			
    			if(isset($_FILES['attachments']) && !empty($_FILES['attachments'])) {
    			    // Loop through each file
    			    $total = count($_FILES['attachments']['name']);
                    for( $i=0 ; $i < $total ; $i++ ) {
                        $file_name = $_FILES['attachments']['name'][$i];
                        $file_size =$_FILES['attachments']['size'][$i];
                        $file_tmp =$_FILES['attachments']['tmp_name'][$i];
                        $file_type=$_FILES['attachments']['type'][$i];
                        
                        $targetPath = getcwd().'/'.$path.'/';
                        $targetFile = $targetPath . $file_name ;
                        move_uploaded_file($file_tmp, $targetFile);
                    }
                    
    			}	    
			
			    //mood board
			    if(isset($_FILES['mood_board_attachment']) && !empty($_FILES['mood_board_attachment'])) {
			        $order_theme_path = $path.'/'.'Theme';
				    if (@mkdir($order_theme_path, 0777)){}
				    if(file_exists($order_theme_path)){
				        $fname = $_FILES['mood_board_attachment']['name'];
                        $fsize = $_FILES['mood_board_attachment']['size'];
                        $ftmp = $_FILES['mood_board_attachment']['tmp_name'];
                        $ftype = $_FILES['mood_board_attachment']['type'];
                        
                        $targetPath = getcwd().'/'.$order_theme_path.'/';
                        $targetFile = $targetPath . $fname ;
                        move_uploaded_file($ftmp, $targetFile);
                        
                        $md = array(
									'order_id' => $order_id,
									'path' => $order_theme_path.'/'.$fname
									);
						$adwitads_api->insert('order_mood', $md);
				    }
				}
				return true;
			}else{
	            return false;
	        }
			
	    }else{
	        return false;
	    }
	}
	
	//API for adwitAPI assets attachment
	public function newad_remove_att()
	{
	    $order_id = $_POST['order_id'];
	    $filename = $_POST['fname'];
	    $adwitads_api = $this->load->database('otherdb', TRUE);
	    
	    $order_detail = $adwitads_api->query("SELECT * FROM `order` WHERE `order_id` = '$order_id'")->row_array();
	    if(isset($order_detail['file_path']) && $order_detail['file_path'] != 'none'){
			$filepath = $order_detail['file_path'];
			if(file_exists($filepath)){
    			$dirhandle = opendir($filepath);
    			while ($file = readdir($dirhandle)) { 
    				if($file==$filename){ 
    				    unlink($filepath.'/'.$filename); 
    				    return 1;
    				}
    			}
    			return 1;
    	    }else{ return -1; }
		}else{ return -1; }
		return true;
	}
	
	public function create_zip() 
	{
	    $order_id = $_POST['order_id'];
	    $slug = $_POST['slug'];
	    $SourceFilePath = $_POST['path'];
	    $source_file = $_POST['source_file'];
	    $pdf_file = $_POST['pdf_file'];
	    
			$this->load->library('zip');
			$this->load->helper('directory');
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			$src_path =  $SourceFilePath.'/'.$source_file;
			$pdf_path =  $SourceFilePath.'/'.$pdf_file;
			$idml_path = $SourceFilePath.'/'.$slug.'.idml';
			
			if(file_exists($src_path)){
				$this->zip->read_file($src_path);
			}else{ echo"<script>alert('$src_path source file not found');</script>"; }
			
			if(file_exists($idml_path)){
				$this->zip->read_file($idml_path);
			}
			
			if(file_exists($pdf_path)){
				$this->zip->read_file($pdf_path);
			}else{ 
				$this->load->helper('directory');	
				$map = glob($SourceFilePath.'/'.$slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
				if($map){ foreach($map as $row){
					$this->zip->read_file($row);
				} } 
			}
			
			$map_font = directory_map($font_path.'/');
			$map_link = directory_map($links_path.'/');
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){ 
				$this->zip->read_dir($links_path, FALSE);
			}
			
			if($this->zip->archive($SourceFilePath.'/'.$slug.'.zip')){
			    return true;
			}else{
			    return false;
			}
		
	}
	/*******************AdwitAPI-Angular END***************************/
	
	/******************tscs ftp - zip file orders START***************/
	public function tscs_new_ftp_zip_download() //http://adwitads.com/weborders/index.php/cron_jobs/home/tscs_new_ftp_zip_download
	{
	    define('FTP_URL', 'ftp.timesshamrock.com');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'MapleCarFish!');
        define('FTP_DIRECTORY', './TO-REMOTE_OVERNIGHT');
        $local_path = "temp_tscs/zip_folder";
        
        $current_timestamp = date("Y-m-d H:i:s");
        $current_timestamp_minus = date('Y-m-d H:i:s', strtotime($current_timestamp.' - 10 minute'));
        $from_date = strtotime($current_timestamp_minus);
        $to_date = strtotime($current_timestamp);
        
        //Connect ot FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        $ftp_folders = ftp_nlist($ftp, FTP_DIRECTORY);
        
        foreach ($ftp_folders as $key => $sub_folder) { //go through the folder
            //Get date
            $folder_last_modified = ftp_mdtm($ftp , $sub_folder);
            $folder_lmd = date('Y-m-d H:i:s', $folder_last_modified);
            $folder_last_modified = strtotime($folder_lmd);
            
            //create sub folder in local path
            $sub_folder_name = basename($sub_folder);
            $local_sub_folder_path = $local_path.'/'.$sub_folder_name;
            if(!file_exists($local_sub_folder_path)){
               if (@mkdir($local_sub_folder_path,0777)){ } 
            }
            
            //check for recent modified folder
            if($folder_last_modified >= $from_date && $folder_last_modified <= $to_date){
                //echo '<li><b>' . $sub_folder.'-'.$folder_lmd. '</b></li>'; //$files[] =  $sub_folder; $dates[] = $lmd;
                $ftp_files = ftp_nlist($ftp, $sub_folder);
                foreach($ftp_files as $kkey => $content){
                    $tscs_ftp_zip_file = $this->db->query("SELECT * FROM `tscs_ftp_zip_file` WHERE `zip_file_path` = '".$content."'")->row_array(); //check for duplicate
                    if(isset($tscs_ftp_zip_file['id'])){
                        continue;    
                    }else{
                        $fname = basename($content);
                        $zip_file_name = basename($content,".zip"); 
                        $DirName = basename(dirname($content));
                        
                        $file_last_modified = ftp_mdtm($ftp , $content);
                        $file_lmd = date('Y-m-d H:i:s', $file_last_modified);
                    
                        //downloads file from ftp to local path //$this->ftp->download($content, $local_path.'/'.$fname, 'binary', 0775); 
                        if (ftp_get($ftp, $local_sub_folder_path.'/'.$fname, $content, FTP_BINARY)) {
                            //echo "Successfully written to ".$local_path.'/'.$fname." \n";
                            $table_post = array('zip_file_path' => $content, 'folder_name' => $DirName, 'timestamp' => $file_lmd); 
                            $this->db->insert('tscs_ftp_zip_file', $table_post); //insert downloaded zip details in table for duplicates check
                        } else {
                            //echo "There was a problem\n";
                        }
                    }
                }
                
            }
        }
        ftp_close($ftp);
	}
	
	public function extract_html($zip_dir,$file_to_be_extracted,$unzip_sub_folder)
	{
	    $zip = new ZipArchive;
	    $res = $zip->open($zip_dir);
	    $output = array();
	    $output['message'] = "entry";
        if ($res === TRUE) {
            if($zip->locateName($file_to_be_extracted) !== FALSE) {
                $zip->extractTo($unzip_sub_folder.'/', $file_to_be_extracted); //file unziped and ad_info.html extracted
                            //echo 'success - '.$res;
                            
                 /****************read html file*********************/
                $html_file_path = $unzip_sub_folder.'/'.$file_to_be_extracted;
                $document = new DOMDocument();
                @$document->loadHTMLFile($html_file_path);
                $tableElement = $document->getElementsByTagName('table');
                foreach($tableElement as $row){
                    $allTableRows = $row->getElementsByTagName("tr");
                    $i=0;
                    foreach($allTableRows as $tableRow) { $i++;
                        $allTableCellsInThisRow = $tableRow->getElementsByTagName("td"); 
                        $firstCell = $allTableCellsInThisRow->item(0);  $secondCell = $allTableCellsInThisRow->item(1);
                                    
                        $thirdCell = $allTableCellsInThisRow->item(2);  $fourthCell = $allTableCellsInThisRow->item(3);//print_r($firstCell);
                                    
                        if($i == 3){
                            $ad_size = trim($fourthCell->nodeValue);//echo($thirdCell->nodeValue); echo '-'; if(isset($fourthCell->nodeValue)){ echo($fourthCell->nodeValue); }
                        }
                        if($i == 4){
                            $ad_color = trim($fourthCell->nodeValue);//echo($thirdCell->nodeValue); echo '-'; if(isset($fourthCell->nodeValue)){ echo($fourthCell->nodeValue); }
                            $customer_email = trim($secondCell->nodeValue);
                        }
                        if($i == 8){
                            $notes = trim($firstCell->nodeValue);//echo($firstCell->nodeValue); echo '-'; if(isset($secondCell->nodeValue)){ echo($secondCell->nodeValue); }   
                        }
                    }
                    $ad_size_arr = explode(" x ",$ad_size);
                    $output['width'] = $ad_size_arr[0];
                    $output['height'] = $ad_size_arr[1];
                    //$output['job_no'] = $zip_file_name;
                    $output['ad_color'] = $ad_color;
                    $output['customer_email'] = $customer_email;
                    $output['notes'] = $notes;
                    $output['message'] = "exit success";
                } 
            }else{ $output['message'] = "not found - ".$file_to_be_extracted; }
        }
        return $output;
	}
	
	public function orders_folder($id = '')
	{
		$order = $this->db->get_where('orders',array('id' => $id))->result_array();
		if(isset($order[0]['id'])){
			$data['order'] = $order;
			$data['order_type'] = $this->db->get_where('orders_type',array('id' => $order[0]['order_type_id']))->result_array();
			$client = $this->db->get_where('adreps',array('id' => $order[0]['adrep_id']))->result_array();
			$jname = $order[0]['job_no'];
			$data['client'] = $client[0];
				
			$path = "downloads/".$id."-".$jname; //path specification
			if (@mkdir($path,0777)){}
			
			//save path
				$post = array('file_path' => $path);
				$this->db->where('id', $id);
				$this->db->update('orders', $post);
				
				//to store the form
				$myFile = $path."/".$jname.".html";
				$fh = fopen($myFile, 'w') or die("can't open file");
				$stringData = $this->load->view('newclientorder',$data, TRUE);
				fwrite($fh, $stringData);
				fclose($fh);
		}
	}
	
	public function tscs_new_unzip_read_html_order() //unzip and read html - http://adwitads.com/weborders/index.php/cron_jobs/home/tscs_new_unzip_read_html_order
	{
	    //list the zip file downloaded from ftp and unzip it
	    $zip_dir_path = "temp_tscs/zip_folder";
	    $unzip_dir_path = "temp_tscs/unzip_folder/";
	    
        $this->load->helper('directory');
        $map_zip_sub_dir_path = directory_map($zip_dir_path, 1);
        
        $zip = new ZipArchive;
        foreach($map_zip_sub_dir_path as $subFolder){
            //sub folder creation in unzip_folder
            $unzip_sub_folder = $unzip_dir_path.basename($subFolder);
            if(!file_exists($unzip_sub_folder)){
               if (@mkdir($unzip_sub_folder,0777)){ } 
            }
            $map_zip_dir_path = directory_map($zip_dir_path.'/'.$subFolder);
            foreach($map_zip_dir_path as $zipFile){
               //echo  $zipFile;
               $zip_file_name = basename($zipFile,".zip"); 
               $tscs_orders = $this->db->query("SELECT `id`, `job_no` FROM `orders` WHERE `job_no` = '".$zip_file_name."' AND DATE(`created_on`)= CURDATE()")->row_array(); //check for duplicate on current date
               if(isset($tscs_orders['job_no']) ){
                    $dataa['subject'] = 'TSCS Alert NEW Ad: Duplicate entry for - '.$zip_file_name;
                    $dataa['message'] = 'Duplicate entry for - '.$tscs_orders['job_no'];
                    $this->alert_email($dataa);
                    //delete duplicate
                    unlink($zip_dir_path.'/'.$subFolder.$zipFile);
                    continue;    
                }else{
    				//extract html file from zip file
                    $file_to_be_extracted = $zip_file_name.'/ad_info.html';
                    $zip_dir = $zip_dir_path.'/'.$subFolder.$zipFile;
            	    $html_data = $this->extract_html($zip_dir, $file_to_be_extracted, $unzip_sub_folder);
            	    if(isset($html_data['notes'])){
            	        $width = $html_data['width'];
                        $height = $html_data['height'];
                        $job_no = $zip_file_name;
                        $ad_color = $html_data['ad_color'];
                        $notes = $html_data['notes'];
                        
                        //match publication with folder name
                        $publication_folder_name = basename($subFolder);
                        $publication_detail = $this->db->query("SELECT p.*, a.id AS adrep_id FROM `publications` p
                                                                        JOIN `adreps` a ON a.publication_id = p.id
                                                                        WHERE `name` = '$publication_folder_name'")->row_array();
                            
                        if(isset($publication_detail['id'])){
                            $publication_id = $publication_detail['id'];
                            $adrep_id = $publication_detail['adrep_id'];
        					$help_desk = $publication_detail['help_desk']; 
        					$news_id = $publication_detail['news_id'];
        					$initial = $publication_detail['initial'];
        					$slug_type = $publication_detail['slug_type'];
        					$team = $publication_detail['design_team_id'];
        					$group_id = $publication_detail['group_id'];
        					$club_id = $publication_detail['club_id'];
        						
        					$print_ad_type = '1';
        					if($ad_color == 'Full Process'){
								$print_ad_type = '1';    
							}elseif($ad_color == 'BW'){
								$print_ad_type = '2';
							}
								
						    //publish date
    						$next_day =  date('D', strtotime(' +1 day'));
    						if($next_day == 'Sat' || $next_day == 'Sun'){
    							$publish_date = date('Y-m-d', strtotime('next monday'));
    						}else{
    							$publish_date = date('Y-m-d', strtotime(' +1 day'));
    						}								    
        					$post = array(
            								'adrep_id' => $adrep_id,
            								'publication_id' => $publication_id,
            								'group_id' => $group_id,
            								'help_desk' => $help_desk,
            								'order_type_id' => '2', 	//print ad
            								'advertiser_name' => $job_no,
            								'job_no' => $job_no,
            								'copy_content_description' => $notes,
            								'width' => $width,
            								'height' => $height,
            								'print_ad_type' => $print_ad_type,
            								'activity_time' => date('Y-m-d h:i:s'),
            								//'rush' => $_POST['rush'],
            								'publish_date' => $publish_date,
            								'club_id'=> $club_id,
        								);
        							
        					$this->db->insert('orders',$post);	
        					$order_no = $this->db->insert_id();
        					if($order_no){
        						//Live_tracker updation
        						if($publication_detail['live_tracker']=='1'){
        							$tracker_data = array(
                            								'pub_id'=> $publication_id,
                            								'order_id'=> $order_no,
                            								'job_no' => $job_no,
                            								'club_id'=> $club_id,
                            								'status' => '1'
                            								);
        							$this->db->insert('live_orders', $tracker_data);
        						}
        							
        						$this->orders_folder($order_no, $help_desk);	// folder creation, html_form
        							
        						//move preorder zip file to downloads folder
        						$order_detail = $this->db->query("SELECT `id`, `file_path` FROM `orders` WHERE `id` = ".$order_no)->row_array(); //need file_path updated details
        						$source_path = $zip_dir; $destination_path = $order_detail['file_path'].'/'.basename($zipFile);
        						rename($source_path, $destination_path);
        							
    							//Delete the entry of html file and folder from unzip folder
                                $folder_path = $unzip_sub_folder.'/'.$zip_file_name;
                                $di = new RecursiveDirectoryIterator($folder_path, FilesystemIterator::SKIP_DOTS);
                                $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
                                foreach ( $ri as $file ) {
                                    $file->isDir() ?  rmdir($file) : unlink($file);
                                }
                                rmdir($folder_path);
        					}
                        }
                    }else{ echo "not found - ".$file_to_be_extracted.$html_data['message']; }
                }
            }
        }
         @$zip->close();
    }

	//revision
	public function tscs_correction_ftp_zip_download()  //ftp download - http://adwitads.com/weborders/index.php/cron_jobs/home/tscs_correction_ftp_zip_download
	{
        define('FTP_URL', 'ftp.timesshamrock.com');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'MapleCarFish!');
        define('FTP_DIRECTORY', './TO-REMOTE_IMMEDIATE/CORRECTION');
        $local_path = "temp_tscs/correction";
        
        //Connect ot FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        $correction_folder = ftp_nlist($ftp, FTP_DIRECTORY);
        
        foreach ($correction_folder as $file) { //go through the folder
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $fname = basename($file);
            $disallow = 'archive';
            if($ext == 'zip' && strpos($fname,$disallow)==false){
                //downloads file from ftp to local path
                if (ftp_get($ftp, $local_path.'/'.$fname, $file, FTP_BINARY)) {
                    $DirName = basename(dirname($file));
                    $file_last_modified = ftp_mdtm($ftp , $file);
                    $file_lmd = date('Y-m-d H:i:s', $file_last_modified);
                    $table_post = array('zip_file_path' => $file, 'folder_name' => $DirName, 'timestamp' => $file_lmd); 
                    $this->db->insert('tscs_ftp_zip_file', $table_post); //insert downloaded zip details in table for duplicates check
                    /***************rename ftp zip file post fix _timestamp_archive*****************/
                    $name = basename($fname,".zip"); 
                    $timestamp = date("YmdHis");
                    $new_file = FTP_DIRECTORY.'/'.$name.'_'.$timestamp.'_archive.zip'; 
                    @ftp_rename($ftp, $file, $new_file);
                } else {
                     //echo "There was a problem\n";
               }
            }
        }
        ftp_close($ftp);
	}
	
    public function tscs_correction_unzip_read_html_order() //unzip and read html - http://adwitads.com/weborders/index.php/cron_jobs/home/tscs_correction_unzip_read_html_order
	{
	    //list the zip file downloaded from ftp and unzip it
	    $zip_dir_path = "temp_tscs/correction";
	    
        $this->load->helper('directory');
        $map_zip_dir_path = directory_map($zip_dir_path);
        $zip = new ZipArchive;
            foreach($map_zip_dir_path as $zipFile){
               //echo  $zipFile;
                $zip_file_name = basename($zipFile,".zip");
                $check_for_order = $this->db->query("SELECT `id`, `adrep_id`, `publication_id`, `rev_count` FROM `orders` WHERE `job_no` = '$zip_file_name' AND `status` = '5' ORDER BY `id` DESC LIMIT 1")->row_array(); //get latest order details of job_no
                if(isset($check_for_order['id'])){ 
                    //echo "Revision Ad"; //Revision Ad
                    $order_id = $check_for_order['id'];
                    $adrep_id = $check_for_order['adrep_id'];
                    $publication_id = $check_for_order['publication_id'];
                    $publication = $this->db->query("Select id, name, help_desk, live_tracker, club_id from publications where id = $publication_id")->row_array();
                    $help_desk = $publication['help_desk'];
                    $tscs_rev_sold_jobs = $this->db->query("SELECT `id`, `order_no`, `new_slug`, `version`, `status` FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->row_array(); //check for duplicate
                    $version = 'V1a';
                    if(isset($tscs_rev_sold_jobs['id'])){
                        $allowed_status = array(1,2,3,4,7,6);
                        if(in_array($tscs_rev_sold_jobs['status'], $allowed_status)){
                            continue;       //reject revision for the order, previous revision version still pending 
                        }else{
                            $slug = $tscs_rev_sold_jobs['new_slug'];
                            $version = $tscs_rev_sold_jobs['version'];
                            
    					    if($version == 'V1a'){ $version = 'V1b'; }
    						elseif($version == 'V1b'){ $version = 'V1c'; }
    						elseif($version == 'V1c'){ $version = 'V1d'; }
    						elseif($version == 'V1d'){ $version = 'V1e'; }
    						elseif($version == 'V1e'){ $version = 'V1f'; }
    						elseif($version == 'V1f'){ $version = 'V1g'; }
    						elseif($version == 'V1g'){ $version = 'V1h'; }
    						elseif($version == 'V1h'){ $version = 'V1i'; }
    						elseif($version == 'V1i'){ $version = 'V1j'; }
    						elseif($version == 'V1j'){ $version = 'V1k'; }
    						elseif($version == 'V1k'){ $version = 'V1l'; }
    						elseif($version == 'V1l'){ $version = 'V1m'; }
    						elseif($version == 'V1m'){ $version = 'V1n'; }
            				elseif($version == 'V1n'){ $version = 'V1o'; }
            				elseif($version == 'V1o'){ $version = 'V1p'; }
            				elseif($version == 'V1p'){ $version = 'V1q'; }
            				elseif($version == 'V1q'){ $version = 'V1r'; }
            				elseif($version == 'V1r'){ $version = 'V1s'; }
            				elseif($version == 'V1s'){ $version = 'V1t'; }
            				elseif($version == 'V1t'){ $version = 'V1u'; }
            				elseif($version == 'V1u'){ $version = 'V1v'; }
            				elseif($version == 'V1v'){ $version = 'V1w'; }
            				elseif($version == 'V1w'){ $version = 'V1x'; }
            				elseif($version == 'V1x'){ $version = 'V1y'; }
            				elseif($version == 'V1y'){ $version = 'V1z'; }
                        }
                    }else{
                        $cat_result = $this->db->get_where('cat_result',array('order_no' => $order_id))->row_array();
				        $slug = $cat_result['slug'];    
                    }
                    
                    //extract html file from zip file
                    $file_to_be_extracted = $zip_file_name.'/ad_info.html';
                    $zip_dir = $zip_dir_path.'/'.$zipFile;
                    $html_data = $this->extract_html($zip_dir, $file_to_be_extracted, $zip_dir_path);
                    if(isset($html_data['notes'])){
            	        $width = $html_data['width'];
                        $height = $html_data['height'];
                        $job_no = $zip_file_name; 
                        $ad_color = $html_data['ad_color'];
                        $notes = $html_data['notes'];
                        
                        $rev_data = array(
        					'order_id'=> $order_id,
        					'order_no' => $slug,
        					'adrep'=> $adrep_id,
        					'help_desk'=> $help_desk,
        					'date'=> date('Y-m-d'),
        					'time'=> date("H:i:s"),
        					'category'=> 'revision',
        					'version'=> $version,
        					'note'=> $notes,
        					'status'=> '1',
        					);
        				$this->db->insert('rev_sold_jobs', $rev_data);
        				$rev_id = $this->db->insert_id();
        				if($rev_id){
        					//Live_tracker Revision updation
        					if($publication['live_tracker']=='1')
        					{
        						$tracker_data = array(
            						'pub_id'=> $publication_id,
            						'order_id' => $order_id,
            						'revision_id'=> $rev_id,
            						'status' => '1'
            						);
        						$this->db->insert('live_revisions', $tracker_data);
        					}
        					//update orders
        					$rev_count = $check_for_order['rev_count'];
        					if(empty($rev_count)){ $rev_count = 0; }
        					$rev_count_data = array(
        					    'rev_count' => $rev_count + 1, 
        					    'rev_id' => $rev_id,
        					    'rev_order_status' => '1', //Revision Submitted
        					    'activity_time' => date('Y-m-d h:i:s'),
        					);
        					$this->db->where('id', $order_id);
        					$this->db->update('orders', $rev_count_data);
        					
        					//folder creation
        					$path="revision_downloads/".$order_id.'-'.$rev_id; 
        					if (@mkdir($path,0777))	{}
        					//save path
        					$post = array('file_path' => $path);
        					$this->db->where('id', $rev_id);
        					$this->db->update('rev_sold_jobs', $post);
        					
        					//move preorder zip file to downloads folder
        					$rev_details = $this->db->query("SELECT `file_path` FROM `rev_sold_jobs` WHERE `id` = '$rev_id'")->row_array();
        					$source_path = $zip_dir; 
        					$destination_path = $rev_details['file_path'].'/'.basename($zipFile);
        					rename($source_path, $destination_path);
        					
        					//Delete the entry of html file and folder from correction folder
                            $folder_path = $zip_dir_path.'/'.$zip_file_name;
                            $di = new RecursiveDirectoryIterator($folder_path, FilesystemIterator::SKIP_DOTS);
                            $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
                            foreach ( $ri as $file ) {
                                $file->isDir() ?  rmdir($file) : unlink($file);
                            }
                            rmdir($folder_path);
        				}
                        
                    }else{ echo "not found - ".$file_to_be_extracted.$html_data['message']; }
                    
                }else{     
                    //New Ad
                    //$tscs_orders = $this->db->query("SELECT `id`, `job_no` FROM `orders` WHERE `job_no` = '".$zip_file_name."'")->row_array(); //check for duplicate
                    $tscs_orders = $this->db->query("SELECT `id`, `job_no` FROM `orders` WHERE `job_no` = '".$zip_file_name."' AND DATE(`created_on`)= CURDATE()")->row_array(); //check for duplicate on current date
                    if(isset($tscs_orders['job_no'])){
                        continue;    
                    }else{
            			//extract html file from zip file
                        $file_to_be_extracted = $zip_file_name.'/ad_info.html';
                        $zip_dir = $zip_dir_path.'/'.$zipFile;
                	    $html_data = $this->extract_html($zip_dir, $file_to_be_extracted, $zip_dir_path);
                	    if(isset($html_data['notes'])){
                	        $width = $html_data['width'];
                            $height = $html_data['height'];
                            $job_no = $zip_file_name;
                            $ad_color = $html_data['ad_color'];
                            $notes = $html_data['notes'];
                            $customer_email = $html_data['customer_email'];
                            
                            //match publication with customer email domain
                            $domain = explode('@', $customer_email)[1];

                            if($domain == 'timesshamrock.com'){
                                    $publication_name = 'TS_SCRANTON';
                            }elseif($domain == 'republicanherald.com'){
                                    $publication_name = 'TS_POTTSVILLE';
                            }elseif($domain == 'standardspeaker.com'){
                                    $publication_name = 'TS_HAZLETON';
                            }else{
                                    $publication_name = 'TS_WILKES_BARRE';
                            }
                            $publication_detail = $this->db->query("SELECT p.*, a.id AS adrep_id FROM `publications` p
                                                                        JOIN `adreps` a ON a.publication_id = p.id
                                                                        WHERE `name` = '$publication_name'")->row_array();
                            $publication_id = 0;
                            if(isset($publication_detail['id'])){
                                $publication_id = $publication_detail['id']; 
                                $adrep_id = $publication_detail['adrep_id'];
            					$help_desk = $publication_detail['help_desk']; 
            					$news_id = $publication_detail['news_id'];
            					$initial = $publication_detail['initial'];
            					$slug_type = $publication_detail['slug_type'];
            					$team = $publication_detail['design_team_id'];
            					$group_id = $publication_detail['group_id'];
            					$club_id = $publication_detail['club_id'];
            						
            					$print_ad_type = '1';
            					if($ad_color == 'Full Process'){
    								$print_ad_type = '1';    
    							}elseif($ad_color == 'BW'){
    								$print_ad_type = '2';
    							}
    								
    						    //publish date
        						$next_day =  date('D', strtotime(' +1 day'));
        						if($next_day == 'Sat' || $next_day == 'Sun'){
        							$publish_date = date('Y-m-d', strtotime('next monday'));
        						}else{
        							$publish_date = date('Y-m-d', strtotime(' +1 day'));
        						}								    
            					$post = array(
                								'adrep_id' => $adrep_id,
                								'publication_id' => $publication_id,
                								'group_id' => $group_id,
                								'help_desk' => $help_desk,
                								'order_type_id' => '2', 	//print ad
                								'advertiser_name' => $job_no,
                								'job_no' => $job_no,
                								'copy_content_description' => $notes,
                								'width' => $width,
                								'height' => $height,
                								'print_ad_type' => $print_ad_type,
                								'activity_time' => date('Y-m-d h:i:s'),
                								'rush' => '1',
                								'publish_date' => $publish_date,
                								'club_id'=> $club_id,
            								);
            					$this->db->insert('orders', $post);	
            					$order_no = $this->db->insert_id();
            					if($order_no){
            						//Live_tracker updation
            						if($publication_detail['live_tracker']=='1'){
            							$tracker_data = array(
                                								'pub_id'=> $publication_id,
                                								'order_id'=> $order_no,
                                								'job_no' => $job_no,
                                								'club_id'=> $club_id,
                                								'status' => '1'
                                								);
            							$this->db->insert('live_orders', $tracker_data);
            						}
            							
            						$this->orders_folder($order_no, $help_desk);	// folder creation, html_form
            							
            						//move preorder zip file to downloads folder
            						$order_detail = $this->db->query("SELECT `id`, `file_path` FROM `orders` WHERE `id` = ".$order_no)->row_array(); //need file_path updated details
            						$source_path = $zip_dir; $destination_path = $order_detail['file_path'].'/'.basename($zipFile);
            						rename($source_path, $destination_path);
            							
        							//Delete the entry of html file and folder from unzip folder
                                    $folder_path = $zip_dir_path.'/'.$zip_file_name;//$folder_path = $unzip_sub_folder.'/'.$zip_file_name;
                                    $di = new RecursiveDirectoryIterator($folder_path, FilesystemIterator::SKIP_DOTS);
                                    $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
                                    foreach ( $ri as $file ) {
                                        $file->isDir() ?  rmdir($file) : unlink($file);
                                    }
                                    rmdir($folder_path);
            					}
                            }
                        }else{ echo "not found - ".$file_to_be_extracted.$html_data['message']; }
                    }
                }
            }
       
        @$zip->close();
    }
    
    //Urgent
    public function tscs_urgent_ftp_zip_download() //ftp download Urgent-New-Ads  - http://adwitads.com/weborders/index.php/cron_jobs/home/tscs_urgent_zip_download
	{
        define('FTP_URL', 'ftp.timesshamrock.com');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'MapleCarFish!');
        define('FTP_DIRECTORY', './TO-REMOTE_IMMEDIATE/URGENT_NEW_AD');
        $local_path = "temp_tscs/correction";
        
        //Connect ot FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        $urgent_folder = ftp_nlist($ftp, FTP_DIRECTORY);
        
        foreach ($urgent_folder as $file) { //go through the folder
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $fname = basename($file);
            if($ext == 'zip'){
                //downloads file from ftp to local path
                if (ftp_get($ftp, $local_path.'/'.$fname, $file, FTP_BINARY)) {
                    $DirName = basename(dirname($file));
                    $file_last_modified = ftp_mdtm($ftp , $file);
                    $file_lmd = date('Y-m-d H:i:s', $file_last_modified);
                    $table_post = array('zip_file_path' => $file, 'folder_name' => $DirName, 'timestamp' => $file_lmd); 
                    $this->db->insert('tscs_ftp_zip_file', $table_post); //insert downloaded zip details in table for duplicates check
                } else {
                     //echo "There was a problem\n";
               }
               
            }
        }
         ftp_close($ftp);
	}
	
	//outgoing upload proof zip file to ftp
/*	public function tscs_outgoing($type_of_ad)             //http://adwitads.com/weborders/index.php/cron_jobs/home/tscs_outgoing
	{
	    define('FTP_URL', 'ftp.timesshamrock.com');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'MapleCarFish!');
        define('FTP_DIRECTORY', './RETURN_TO_TRACK');
        if($type_of_ad == 'new_ad'){
            $local_path = "temp_tscs/OUTGOING/NEW";
        }elseif($type_of_ad == 'revision_ad'){
            $local_path = "temp_tscs/OUTGOING/CORRECTION";
        }
        if($this->dir_is_empty($local_path) === false){ //ftp connect only if folder not empty
            //Connect ot FTP
            $ftp = ftp_connect(FTP_URL);
            //Login to FTP
            ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
            ftp_pasv($ftp, true);
            
            //Get files
            $files = array_diff(scandir($local_path), array('.', '..'));
            
            foreach ($files as $file) { //go through the folder 
               // echo $file;
               $src = $local_path.'/'.$file;
                if (ftp_put($ftp, FTP_DIRECTORY.'/'.$file, $src, FTP_ASCII)) {
                    //echo "successfully uploaded $file\n"; exit;
                    unlink($src); //delete zip file after ftp transfer
                } else {
                    echo "There was a problem while uploading $file\n";
                    exit;
                }
            }
            ftp_close($ftp);
        }
	}
*/	
	function dir_is_empty($dir) {
        $handle = opendir($dir);
         while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
            closedir($handle);
            return false;
            }
        }
        closedir($handle);
        return true;
    }
	/******************tscs ftp - zip file orders END***************/
	
	/****************** User adwitads Login details START******************/
	public function user_login_session($user) //designers/csr
    {
        $current_month = date('Y-m').'-26';
        $prev_month = date('Y-m', strtotime('-1 month')).'-25';
        
        $period = new DatePeriod(
             new DateTime($prev_month),
             new DateInterval('P1D'),
             new DateTime($current_month)
        );
        $data = array();//print_r($period);
        foreach ($period as $key => $value) {
            $data[] = $value->format('Y-m-d');
        }
        if($user == 'designers'){
            $users = $this->db->query("SELECT designers.id, designers.name FROM designers WHERE `is_active`=1")->result_array();
            $user_module = 4;
            $csv_file_name = 'UserLoginCSV/DesignerLoginDetails.csv';
        }else{
             $users = $this->db->query("SELECT csr.id, csr.name FROM csr WHERE `is_active`=1")->result_array();
             $user_module = 3;
             $csv_file_name = 'UserLoginCSV/CsrLoginDetails.csv';
        }
        $user_total_list = array(); //print_r($data);
        foreach($users as $user){
            $user_details = array();
            $user_login_date_time = array();
            $users_login_session =  $this->db->query("SELECT DATE(users_login_session.timestamp) AS LoginDate, TIME(users_login_session.timestamp) AS LoginTime FROM users_login_session
                                    WHERE  users_login_session.user_module = $user_module AND users_login_session.user_id = '".$user['id']."' AND users_login_session.in_out='in' 
                                    AND  (users_login_session.timestamp BETWEEN '$prev_month 00:00:00' AND '$current_month 23:59:59')  
                                    GROUP BY date(users_login_session.timestamp)   
                                    ORDER BY users_login_session.timestamp;")->result_array();
            
            foreach($users_login_session as $row){
                $loginDate = $row['LoginDate']; $loginTime = $row['LoginTime'];
                $user_login_date_time[$loginDate]= $loginTime;
            } 
            foreach($data as $d){
                if(isset($user_login_date_time[$d])){
                    $user_details[] = $user_login_date_time[$d];    
                }else{
                    $user_details[] = '-';
                }
            }
            array_unshift($user_details , $user['name']);
            $user_total_list[] = implode(',',$user_details); 
        }
     
		array_unshift($data , 'Name');
        $date_list = implode(',',$data);
        
		$write_data = array($date_list);
        foreach($user_total_list as $single){
            array_push($write_data, $single);    
        }
        
        $fp = fopen($csv_file_name, 'w');
        foreach ( $write_data as $line ) {
            $val = explode(",", $line);
            fputcsv($fp, $val);
        }
        fclose($fp);
        return $csv_file_name;
    }
    
    public function mail_user_login_session($user) //designers/csr
    {
        $current_year = date('Y');
        $current_month = date('F');
        //function to get details
        $return_csv_path = $this->user_login_session($user);
        if(isset($return_csv_path)){
            $file_path = $return_csv_path;
            if(file_exists($file_path)){
                $file_name = basename($return_csv_path);
                
                $from_email = 'itsupport@adwitads.com'; 
    		    $to_email =  'pranav@adwitglobal.com, lakshmi@adwitglobal.com, kavitha@adwit.co.uk, sudarshan@adwitads.com, giri@adwitglobal.com';
    		
        		//Load email library 
        		$config = Array( 'mailtype' => 'html' );
        		$this->load->library('email', $config);
        		
        		$this->email->from($from_email,'AdwitAds'); 
        		$this->email->to($to_email);
        		//$this->email->bcc($ad_recipient);
        		$this->email->subject(ucfirst($user).' attendance from AdwitAds - '.$current_month.' '.$current_year);
        		$this->email->attach($file_path, $file_name);
        		
        		if($this->email->send()){
        			return true; //echo'sent'; 
        		}else{
        			return false;//echo'failed'; 
        		}
            }
        }
    }
    /****************** User adwitads Login details END******************/
    /****************** START GroupWise Ad Volume Report **********************/
    public function groupwise_ad_volume_report()
    {
        $today_date_time = $this->db->query("SELECT `time` FROM `today_date_time`")->result_array();
										
		//Time	
		$ystday_time = $today_date_time[0]['time'];
		$today_time = $today_date_time[1]['time'];
		$tomo_time = $today_date_time[2]['time'];
		$current_time = date("H:i:s");
		
		//Day
		$current_date = date("Y-m-d");
		$day = date("D", strtotime($current_date)); //echo $day.' '.$current_time;
		$ysterday = date("Y-m-d", strtotime(' -1 day'));
		$day_before_yday = date("Y-m-d", strtotime(' -2 day'));
		$day_before_yyday = date("Y-m-d", strtotime(' -3 day'));
		$tomo = date("Y-m-d", strtotime(' +1 day'));
		
		if($day == 'Mon'){ //Friday To Monday
		    $this->db->query("TRUNCATE TABLE `Group_daily_report` ");
	        $this->db->query("TRUNCATE TABLE `Publication_daily_report` ");
	
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $day_before_yyday.' '.$ystday_time; //Friday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    	        //$from_date_range = $day_before_yyday.' '.$today_time;   //Friday 08:29:59
    	        $from_date_range = $current_date.' '.$today_time;   //Friday 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
			}
		}elseif($day == 'Sun'){ //Saturday To Sunday
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $day_before_yday.' '.$ystday_time;   //saturday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			}elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    		    $from_date_range = $day_before_yday.' '.$today_time;    //saturday 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //Tomorrow 08:30:00
			 }    
		}else{
			if($current_time >= '00:00:00' && $current_time <= '08:29:59'){
			    $from_date_range = $ysterday.' '.$ystday_time;          //yesterday 08:30:00
			    $to_date_range = $current_date.' '.$today_time;         //today 08:29:59
			    
			 }elseif($current_time >= '08:30:00' && $current_time <= '23:59:59'){
    	        $from_date_range = $current_date.' '.$today_time;      //today 08:29:59
			    $to_date_range = $tomo.' '.$tomo_time;                  //tomorrow 08:29:59
			    
			 }
		} 
        //echo $from_date_range.' - '.$to_date_range;
        $groups = $this->db->query("SELECT * FROM `Group` WHERE `is_active`='1' ORDER BY `priority` ASC ;")->result_array();
        //webads count
    	$webad_count = '0'; $web_order_count_yst = '0'; $web_order_count_today = '0'; $pagead_count = 0; $printad_count = 0;
    	
    	$print_count =  $this->db->query("SELECT COUNT(id) AS adCount FROM orders 
    	                                    WHERE `order_type_id`='2' AND `created_on` BETWEEN '$from_date_range' AND '$to_date_range'
    	                                        AND `crequest` != '1' AND `cancel` !='1'")->row_array();
    	$web_count =  $this->db->query("SELECT COUNT(id) AS adCount FROM orders 
    	                                    WHERE `order_type_id`='1' AND `created_on` BETWEEN '$from_date_range' AND '$to_date_range'
    	                                        AND `crequest` != '1' AND `cancel` !='1'")->row_array();
    	$pagination_orders =  $this->db->query("SELECT COUNT(id) AS adCount FROM orders 
    	                                    WHERE `order_type_id`='6' AND (`created_on` BETWEEN '$from_date_range' AND '$to_date_range')
    	                                        AND `status` NOT IN (9,10,11) AND `crequest` != '1' AND `cancel` !='1'")->row_array();
    	$printad_count = $print_count['adCount'];
    	$webad_count = $web_count['adCount'];
    	$pagead_count = $pagination_orders['adCount'];
    	
    	foreach($groups as $group){
    	    $group_id = $group['id'];
    		$group_name = $group['name'];
    		$group_order_count = '0';
    		$publications = $this->db->query("SELECT * FROM publications WHERE `group_id`='$group_id' AND `is_active`='1' ;")->result_array();
    		foreach($publications as $publication){
    		    $publication_id = $publication['id'];
    		    $publication_name = str_replace("'", "", $publication['name']);
    			$publications_order_count = '0'; $publications_order_count_yst = '0'; $publications_order_count_today = '0';
    									                           
    			$order_count = $this->db->query("SELECT COUNT(id) AS adCount FROM orders 
    			                                    WHERE `publication_id`='$publication_id' AND (`created_on` BETWEEN '$from_date_range' AND '$to_date_range')
    			                                                    AND `crequest` != '1' AND `cancel` !='1' AND `order_type_id` != '6'")->row_array();
    			$publications_order_count = $order_count['adCount'];
    			
    			$group_order_count = $group_order_count + $publications_order_count;
    			
    			$sql = $this->db->query("INSERT INTO `Publication_daily_report` (`day`, `publication`, `group`, `orders_count`, `date`, `time`, `group_id`, `publication_id`)
    						VALUES('$day', '$publication_name', '$group_name', '$publications_order_count', '$current_date', '$current_time', '$group_id', '$publication_id')"); 
    		} 
    		//database
    		$sql = $this->db->query("INSERT INTO `Group_daily_report` (`day`, `group_name`, `group_count`, `date`, `time`, `group_id`, `webad_count`, `pagead_count`, `printad_count`)
    						VALUES('$day', '$group_name', '$group_order_count', '$current_date', '$current_time', '$group_id', '$webad_count', '$pagead_count', '$printad_count')");     
    	}
    }
    
    public function groupwise_ad_volume_report_display()
    {
        $today = date('d-m-Y');
    	$day = date('D');
        $getActiveGroup = "SELECT * FROM `Group_daily_report`
        left join `Group` on  `Group_daily_report`.`group_id` = `Group`.id
        where  `Group_daily_report`.`day`='$day' AND `Group`.`is_active` =1 order by `group_name` asc";
        
        $data['groupDailyReports'] = $this->db->query($getActiveGroup)->result_array();

        #get the  sum of  webad,printad and pagead count
        $query = "SELECT webad_count as total_webad_count, printad_count as total_print_adcount, pagead_count as total_pagead_count FROM `Group_daily_report`
        left join `Group` on  `Group_daily_report`.`group_id` = `Group`.id
        where  `Group_daily_report`.`day`='$day' AND `Group`.`display_pub`=1 and `Group`.`is_active` =1";

        $data['groupDailyReportsTotal'] = $this->db->query($query)->row_array();
        
        #get the individual group and orders count
        $getGroupCountQuery = "SELECT `group`,`group_id`, SUM(orders_count) AS total_orders FROM Publication_daily_report
        left join `Group` on `Publication_daily_report`.`group_id` = `Group`.id 
        where `Publication_daily_report`.`day`='$day' AND `Group`.`display_pub`=1 and `Group`.`is_active` =1 
        GROUP BY `Publication_daily_report`.`group`";

        $data['getAllGroups'] = $this->db->query($getGroupCountQuery)->result_array();
        $data['day'] = $day;
        $this->load->view('cron_jobs/groupwise_ad_volume_report', $data);
    }
    /****************** END GroupWise Ad Volume Report **********************/
    
    /*public function jwtToken()
    {
        require_once ROOTPATH . 'vendor/autoload.php';

        //require 'vendor/autoload.php'; // Include the Composer autoloader

        use \Firebase\JWT\JWT;
        
        // Set the key and other required claims
        $key = 'f26e587c28064d0e855e72c0a6a0e618';
        $payload = array(
            "iss" => "issuer",
            "aud" => "audience",
            "iat" => time(), // Issued at claim
            "exp" => time() + (60 * 60), // Expiration time claim (1 hour from now)
            "userName" => "JohnDoe", // Your userName value
            "adRepId" => 12345 // Your adRepId value
        );
        
        // Generate the JWT token
        $jwt = JWT::encode($payload, $key);
        
        echo $jwt;   
    }*/
    
    public function ManualUpload($orderId)
    {
        $q = "SELECT orders.*, cat_result.source_path  FROM `orders` 
                JOIN `cat_result` ON cat_result.order_no = orders.id
                WHERE orders.id = '$orderId'";
       $order_detail = $this->db->query("$q")->row_array(); 
       if(isset($order_detail['id'])){
          //compress file 
          //Copy .pdf or .image file to path ‘pdf_uploads/order_id’
          $new_path = "pdf_uploads/".$orderId;
		    if (@mkdir($new_path,0777)){ }
          //cat_result => pdf_path, pro_status=5, csr_QA=68, csr_QA_timestamp
            echo 'Dir - '.$new_path;
           /* 
            //order status
        					$pdf_timestamp = date("Y-m-d H:i:s");
        					$post_status = array('status' => '5' , 'pdf' => $pdf, 'activity_time' => date('Y-m-d h:i:s'), 'pdf_timestamp' => $pdf_timestamp);
        					$this->db->where('id', $order_id);
        					$this->db->update('orders', $post_status);
        					
        					//Live_tracker  Updation
        					$update_orders = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
        					if(isset($update_orders['id'])){
        						$this->db->query("DELETE FROM `live_orders` WHERE `id`= '".$update_orders['id']."'");
        					}
            //Production status
        					$pro_status = array('pro_status' => '5','pdf_path' => $pdf_file);
        					$this->db->where('order_no', $order_id);
        					$this->db->update('cat_result', $pro_status);
        					*/
       }
    }
    /******************** AdwitLite *********************/
    public function adwitlite_sign_up()
    {
        if(isset($_POST['publication']) && !empty($_POST['publication'])){
            $pname = $_POST['publication']; //echo $pname;
            $adrep_email_id = $_POST['email'];
            $publication_chk = $this->db->get_where('publications',array('name' => $pname))->row_array(); 
            if(isset($publication_chk['id'])){
                $this->session->set_flashdata("message","Either the email or the publication is already associated, please contact itsupport@adwitads.com.");
                redirect('cron_jobs/home/adwitlite_sign_up');
            }
            
            $adrep_chk = $this->db->get_where('adreps',array('email_id' => $adrep_email_id))->row_array();
            if(isset($adrep_chk['id'])){
                $this->session->set_flashdata("message","Either the email or the publication is already associated, please contact itsupport@adwitads.com.");
                redirect('cron_jobs/home/adwitlite_sign_up');
            }
            //create new publication
            $post_pub = array(	'name' => $pname,
								'design_team_id' => '4',
								 'group_id' =>	'23',
								 'help_desk' => '18',
								 'channel' => '3',
								 'slug_type' => '5',
								 'club_id' => '16',
								 'ordering_system' => '1',
								 'is_active'  => '0',
								 'rev_days' => '7'
							);
			$this->db->insert('publications', $post_pub);
			$pId = $this->db->insert_id();
			if($pId){
			    $post = array(	'publication_id' => $pId,
							'first_name' => $this->input->post('first_name'),
							'last_name'  => $this->input->post('last_name'),
							'username'   => $adrep_email_id,
							'email_id'   => $adrep_email_id,
							'password'   => md5($this->input->post('password')),
							'new_ui' 	 => '1',	//lite
							'pagedesign_ad' => '1',
							'is_active'  => '0',
						);
    			$this->db->insert('adreps', $post);
    			$adrep_id = $this->db->insert_id();
    			
    			if($adrep_id){
    			    $this->send_activation_link($adrep_id);    
    			}
			}
        }
        $this->load->view('cron_jobs/adwitlite_sign_up');
    }
    
    function send_activation_link($adrep_id)
	{
		$adrep = $this->db->query("Select * from adreps where id='".$adrep_id."';")->row_array();
		if(isset($adrep['id']))
		{ 
			$email = $adrep['email_id'];
			//$mktime = time();
			$secret_key = $this->encrypt->encode($email);//$secret_key = $this->encrypt->encode($email.":".$mktime);
			$this->db->update('adreps',array('encrypted_key' => $secret_key), array('email_id' => $email));
			
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'AdwitAds';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'adwitads';
			$data['subject'] = '🚀 Almost There! Activate Your AdwitAds Account Inside';
			$data['recipient'] = $email;
			$data['recipient_display'] = 'adwitads.com';
			
			/*$data['body'] = '<p style="color:#2e2c2c;margin:0px;padding-top:20px;font-size:14px;">To activate your account, please 
			<a href="'.base_url().index_page().'cron_jobs/home/activate_account/'.$secret_key.'" target="_blank" style="color:#0066ff; text-decoration:none;">click here</a>. </p>';*/
			
			$data['adrepName'] = $adrep['first_name'].' '.$adrep['last_name'];
			
			$data['confirmationLink'] = base_url().index_page().'cron_jobs/home/activate_account/'.$secret_key;
			
			$data['body'] = $this->load->view('email_template/adwitLite_signUp/activationEmail',$data, TRUE);
			
			$this->sendgrid_mail($data);
			
			$this->session->set_flashdata("success_message", "<p class='text-normal alert alert-success'>Thank you for signing up! Check your email and click on the activation link. If you don't see it, it might be in spam. Don't forget to mark emails from us as important. We appreciate your trust and are here to provide an exceptional experience.</p>");
			redirect('cron_jobs/home/adwitlite_sign_up');
			
		}else{
			$this->session->set_flashdata("message","Invalid Email Id!");
			redirect('cron_jobs/home/adwitlite_sign_up');
		}
	}
	
    public function activate_account($encrypted_key)
	{ 
		$secrets = $this->encrypt->decode($encrypted_key); //$secrets = preg_split('/[\s:]+/',$this->encrypt->decode($encrypted_key));
		//$mktime = time();
		$email_id = $secrets;//$email_id = $secrets[0];
		$adrep_chk = $this->db->query("Select * from adreps where email_id='".$email_id."' and encrypted_key='".$encrypted_key."';")->num_rows();
		//if($secrets[1] + 172800 > $mktime && $this->secretExists_reg($secrets[0],$encrypted_key)==1){	
		if($adrep_chk == 1){
			//make adrep active
			$this->db->update('adreps',array('encrypted_key' => '', 'is_active' => '1'),array('email_id' => $email_id, 'encrypted_key' => $encrypted_key));
			
			//make publication active
			$adrep = $this->db->query("Select * from adreps where email_id='".$email_id."' and is_active='1';")->row_array();
			$this->db->update('publications', array('is_active' => '1'), array( 'id' => $adrep['publication_id'] ));
			
			//$this->session->set_flashdata("message","<p style='color:#3CBC8D;'>Congratulations! Your account has been activated successfully, Log in to continue.</p>");
			//$adrepId = urlencode(base64_encode($adrep['id']));
			//redirect('lite/login/set_password/'.$adrepId);
			
			//after activation send Welcome mail template
			$email = $adrep['email_id'];
			$data = array();
			$data['from'] = 'do_not_reply@adwitads.com';
			$data['from_display'] = 'AdwitAds';
			$data['replyTo'] = 'do_not_reply@adwitads.com';
			$data['replyTo_display'] = 'adwitads';
			$data['subject'] = 'Welcome to Unlimited Designs with AdwitAds!';
			$data['recipient'] = $email;
			$data['recipient_display'] = 'adwitads.com';
			
			$data['adrepName'] = $adrep['first_name'].' '.$adrep['last_name'];
			$data['userName'] = $email;
			//$data['password'] = $password;
			$data['designTeamEmail'] = 'design4@adwitads.com';
			$data['body'] = $this->load->view('email_template/adwitLite_signUp/welcomeEmail',$data, TRUE);
			
			$this->sendgrid_mail($data);
			//$message = "Thank you for verifying your email.";
			$this->session->set_flashdata("message", "Thank you for verifying your email.");
			redirect('client/Login/index');
		}else{
			$this->session->set_flashdata("message", "The given URL is invalid or it might have expired!".$email_id."-".$encrypted_key); 
			redirect('cron_jobs/home/adwitlite_sign_up');
		}
	}
	
	public function sendgrid_mail($data) 
	{
	    include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
        
        $to = $data['recipient'];
        $to_display = $data['recipient_display'];
        $from = $data['from'];
        $from_display = $data['from_display'];
        $replyTo = $data['replyTo'];
        $replyTo_display = $data['replyTo_display'];
        $subject = $data['subject'];
        $body = $data['body'];
        
	    $email = new \SendGrid\Mail\Mail();
		$email->setFrom($from, $from_display);
		$email->setReplyTo($replyTo, $replyTo_display);
		$email->setSubject($subject);
		
		$email->setSubject($subject);
		
		//$email->addContent("text/html", $this->load->view('email_template/OrderConfirmation',$data, TRUE));
			
		$email->addContent("text/html", $body); 
		
		$email->addTo($to, $to_display);
	
		//$email->addTo("sudarshan@adwitads.com", "recipient_display");
       	
		$sendgrid = new \SendGrid('');
		$response = $sendgrid->send($email);
		
	}
	/******************** AdwitLite END *********************/
	/**************************Adwit Billing Report - Automation***********************/
	public function adwitBillingReport() 
    {
        $from_date = date('Y-m', strtotime('-1 month')).'-01';
        $to_date = date('Y-m', strtotime('-1 month')).'-31';
        
        $csv_file_name = 'AdwitBillingCSV/AdwitBillData'.$from_date.'-'.$to_date.'.csv';
        $query = "SELECT DATE_FORMAT(orders.created_on,'%m/%d/%Y') AS orderDate, orders.id, orders_type.name AS adType, orders.job_no, CONCAT(adreps.first_name, ' ', adreps.last_name) AS adrepName,
                    orders.advertiser_name, orders.width, orders.height, orders.pixel_size, orders.custom_width, orders.custom_height, orders.pdf, publications.name AS publicationName, 
                    `Group`.name AS groupName FROM `orders` 
                    LEFT JOIN `orders_type` ON orders_type.id = orders.order_type_id
                    LEFT JOIN `adreps` ON adreps.id = orders.adrep_id
				    LEFT JOIN `publications` ON publications.id = orders.publication_id
				    LEFT JOIN `Group` ON `Group`.id = orders.group_id
                    WHERE (DATE(orders.created_on) BETWEEN '$from_date' AND '$to_date') AND orders.pdf!='none' AND orders.publication_id != '1' AND orders.group_id NOT IN (2,4,5) ORDER BY publications.name, orders.order_type_id, orders.id ";
                    
        
        $fp = fopen($csv_file_name, 'w');
        $delimiter = ","; 
        $fields = array('OrderDate', 'Id', 'AdType', 'Job Number', 'AdrepName', 'AdvertiserName', 'Width', 'Height', 'PixelSize', 'CustomWidth', 'CustomHeight', 'PDF', 'PublicationName', 'GroupName'); 
        fputcsv($fp, $fields, $delimiter); 
        
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {  
            foreach($result->result_array() as $row){
        
                $lineData = array($row['orderDate'], $row['id'], $row['adType'], $row['job_no'], $row['adrepName'], $row['advertiser_name'],$row['width'], $row['height'], 
                $row['pixel_size'], $row['custom_width'], $row['custom_height'], $row['pdf'], $row['publicationName'], $row['groupName']); 
        
                fputcsv($fp, $lineData, $delimiter); 
        
            } 
        
        } 
        fclose($fp);
        return $csv_file_name;
        /*$fileurl = $csv_file_name;
        header("Content-type:text/csv");
        header('Content-Disposition: attachment; filename=' . $fileurl);
        readfile( $fileurl );*/
    }
    
    public function mail_adwitBillingReport()
    {
        $current_year = date('Y');
        $month = date('F', strtotime('-1 month'));
        $current_month = date('F');
        //function to get details
        $return_csv_path = $this->adwitBillingReport();
        if(isset($return_csv_path)){
            $file_path = $return_csv_path;
            if(file_exists($file_path)){
                $file_name = basename($return_csv_path);
                
                $from_email = 'itsupport@adwitads.com'; 
    		    $to_email =  'pranav@adwitglobal.com, lakshmi@adwitglobal.com, kavitha@adwit.co.uk, ravi@adwitglobal.com';
    		    //$to_email =  'sudarshan@adwitads.com, ravi@adwitglobal.com';
        		//Load email library 
        		$config = Array( 'mailtype' => 'html' );
        		$this->load->library('email', $config);
        		
        		$this->email->from($from_email,'AdwitAds'); 
        		$this->email->to($to_email);
        		//$this->email->bcc($ad_recipient);
        		$this->email->subject('Adwit Billing Data - '.$month.' '.$current_year.' - EXCEPT SDR, METRO/TSCS/TS Groups');
        		$this->email->attach($file_path, $file_name);
        		
        		if($this->email->send()){
        			return true; //echo'sent'; 
        		}else{
        			return false;//echo'failed'; 
        		}
            }
        }
    }
    /**************************END Adwit Billing Report - Automation***********************/
    public function revision_csr_changes_to_proof_ready($order_id) //https://adwitads.com/weborders/index.php/cron_jobs/home/revision_csr_changes_to_proof_ready/
    {
        $rev_sold_jobs =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
        
        if(isset($rev_sold_jobs['id']) && $rev_sold_jobs['status'] == '7'){
            $rev_update = array( 'status' => '5' );
			$this->db->where('id', $rev_sold_jobs['id']);
			$this->db->update('rev_sold_jobs', $rev_update); 
			
            $orders = $this->db->query("SELECT id, rev_order_status FROM `orders` WHERE `id` = $order_id ")->row_array();
            if($orders['rev_order_status'] == '7'){
                $update = array( 'rev_order_status' => '5' );
			    $this->db->where('id', $order_id);
			    $this->db->update('orders', $update); 
			    echo 'Status Update Success.!!';
            }
        }else{
            echo 'Status not in CSR Changes..';
        }
    }
    /***************** Ogden FTP XML START ***************/
    /*public function Ogden_ftp_connect_get() //https://adwitads.com/weborders/index.php/cron_jobs/home/Ogden_ftp_connect_get
	{
	    define('FTP_URL', 'ftp.oweb.net');
        define('FTP_USERNAME', 'adwit');
        define('FTP_PASSWORD', 'Aw-1013');
        define('FTP_DIRECTORY', './adwit');
        $local_path = "Ogden_ftp_xml/Incoming";
        
        //Connect to FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        $ftp_files = ftp_nlist($ftp, FTP_DIRECTORY);
        if(is_array($ftp_files)){
            foreach($ftp_files as $kkey => $content){
                $ext = pathinfo($content, PATHINFO_EXTENSION);
                $fname = basename($content); //echo $content;
                if (ftp_get($ftp, $local_path.'/'.$fname, FTP_DIRECTORY.'/'.$content, FTP_BINARY)) { //download to localpath
                    echo "Successfully written to ".$local_path.'/'.$fname." \n";
                    //move file to 'adwit_archive' folder
                    $ftp_archive_path = './adwit_archive/'.$fname; 
                    @ftp_rename($ftp, FTP_DIRECTORY.'/'.$content, $ftp_archive_path);
                } else {
                    echo "There was a problem\n";
                }
            }
        }
        ftp_close($ftp);
	}*/
	public function Ogden_ftp_connect_get($action = '') //https://adwitads.com/weborders/index.php/cron_jobs/home/Ogden_ftp_connect_get
	{
	    define('FTP_URL', '');
        define('FTP_USERNAME', '');
        define('FTP_PASSWORD', '');
        
        if($action == 'answer'){                            //answer
	        define('FTP_DIRECTORY', './adwit_answer'); 
	        $local_path = "Ogden_ftp_xml/answer";
	    }elseif($action == 'revision'){                     //revision
	        define('FTP_DIRECTORY', './revision_in'); 
	        $local_path = "Ogden_ftp_xml/revision_in";
	    }elseif($action == 'additionalAttachment'){         //additionalAttachment
	        define('FTP_DIRECTORY', './additional_attachment'); 
	        $local_path = "Ogden_ftp_xml/additional_attachment";
	    }else{                                              //newAds
	        define('FTP_DIRECTORY', './adwit');
            $local_path = "Ogden_ftp_xml/Incoming"; 
	    }
	    
        //Connect to FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        $ftp_files = ftp_nlist($ftp, FTP_DIRECTORY);
        if(is_array($ftp_files)){
            foreach($ftp_files as $kkey => $content){
                $ext = pathinfo($content, PATHINFO_EXTENSION);
                $fname = basename($content); //echo $content;
                if (ftp_get($ftp, $local_path.'/'.$fname, FTP_DIRECTORY.'/'.$content, FTP_BINARY)) { //download to localpath
                    //echo "Successfully written to ".$local_path.'/'.$fname." \n";
                    //move file to 'adwit_archive' folder
                    $ftp_archive_path = './adwit_archive/'.$fname; 
                    @ftp_rename($ftp, FTP_DIRECTORY.'/'.$content, $ftp_archive_path);
                } else {
                    echo "There was a problem\n";
                }
                
                //action
                if($action == 'answer'){
                    $this->Ogden_answer_xml_content_fetch();
                }elseif($action == 'revision'){
                    $this->Ogden_revision_xml_content_fetch();
                }elseif($action == 'additionalAttachment'){
                    $this->Ogden_additionalAttachment_xml_content_fetch();
                }
            }
        }
        ftp_close($ftp);
	}
	
	public function Ogden_create_xml_proofReady($order_id = '')
	{
        $this->load->dbutil();
        $order_detail = $this->db->query("SELECT orders.id, orders.job_no, cat_result.slug, cat_result.source_path FROM `orders` 
                                            JOIN `cat_result` ON cat_result.order_no = orders.id
                                            WHERE orders.id = '$order_id'")->row_array();
        if(isset($order_detail['id'])){
            //zip source start
            $this->load->library('zip');
			$this->load->helper('directory');
			
			$new_slug = $order_detail['slug'];
			$SourceFilePath = $order_detail['source_path'];
			
			$font_path = $SourceFilePath.'/Document fonts/';
			$links_path = $SourceFilePath.'/Links/';
			
			$this->load->helper('directory');	
			
			$map = glob($SourceFilePath.'/'.$new_slug.'.{indd,psd}',GLOB_BRACE);
			if($map){ foreach($map as $row_src){
				$src_path = $row_src;
			} } 
			
			$map = glob($SourceFilePath.'/'.$new_slug.'.{pdf,jpg,gif,png}',GLOB_BRACE);
			if($map){ foreach($map as $row_pdf){
				$pdf_path = $row_pdf;
			} } 
			
			$this->zip->read_file($src_path, FALSE);
			$this->zip->read_file($pdf_path, FALSE);
			
			$map_font = directory_map($font_path.'/');
			$map_link = directory_map($links_path.'/');
			if($map_font){
				$this->zip->read_dir($font_path, FALSE);
			}	
			if($map_link){
				$this->zip->read_dir($links_path, FALSE);
			}
			$zip_file = $SourceFilePath.'/'.$new_slug.'.zip';
			$this->zip->archive($zip_file);
			$this->zip->clear_data();
			//zip source END
                                                    
            $data = $this->db->query('SELECT cat_result.order_no AS orderId, note_sent.note AS notes, CONCAT("https://adwitads.com/weborders/",cat_result.pdf_path) AS pdf, 
              CONCAT("https://adwitads.com/weborders/", cat_result.source_path, "/", cat_result.slug,".zip") AS package FROM `cat_result` 
                                        LEFT JOIN `note_sent` ON note_sent.order_id = cat_result.order_no
                                        WHERE cat_result.order_no = "'.$order_id.'"');
            $config = array (
                    'root'    => 'Ads',
                    'element' => 'Ad',
                    'newline' => "\n",
                    'tab'     => "\t"
             );
             $xml = $this->dbutil->xml_from_result($data, $config);
             $this->load->helper('file');
             $xmlFileName = $order_detail['job_no'].'.xml';
             write_file('Ogden_ftp_xml/Outgoing/'.$xmlFileName, '<?xml version="1.0" ?>'.PHP_EOL);
             write_file('Ogden_ftp_xml/Outgoing/'.$xmlFileName, $xml, 'a');
              //$this->output->set_content_type('text/xml');
              //$this->output->set_output($xml); 
	    }
	}
	
	public function Ogden_ftp_connect_post() //To UPLOAD XML file to FTP containing pdf & source path https://adwitads.com/weborders/index.php/cron_jobs/home/Ogden_ftp_connect_post
	{
	    define('FTP_URL', '');
        define('FTP_USERNAME', '');
        define('FTP_PASSWORD', '');
        define('FTP_DIRECTORY', '');
        $local_path = "Ogden_ftp_xml/Outgoing";
        
        //Connect to FTP
        $ftp = ftp_connect(FTP_URL);
        //Login to FTP
        ftp_login($ftp, FTP_USERNAME, FTP_PASSWORD);
        ftp_pasv($ftp, true);
        
        //Get files
        if ($handle = opendir($local_path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if(ftp_put($ftp, FTP_DIRECTORY.'/'.$entry, $local_path.'/'.$entry, FTP_BINARY)) {
                        echo "SUCCESS";
                        unlink($local_path.'/'.$entry); //return true;//
                    }else{
                        echo "There was a problem while uploading $file\n"; exit; //return false;//
                    }
                }
            }
        
            closedir($handle);
        }   
        
        ftp_close($ftp);
	}
	
	public function Ogden_xml_content_fetch() //Read ftp Downloaded XML file and place order in orders table
	{
	    //file path
		$archive_path = 'Ogden_ftp_xml/archive';
		$folder_path = 'Ogden_ftp_xml/Incoming'; 

		if($dh = opendir($folder_path)){
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..'){ continue; }
				$filename = $file;
				//$xml_file_data = $this->db->query('SELECT `id` FROM `preorders_waukesha` WHERE `filename` = "'.$filename.'"')->row_array();
				//if(!isset($xml_file_data['id'])){
    				$valid_extension = array('xml','XML');
    				$file_data = explode('.', $file);
    				$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    $use_errors = libxml_use_internal_errors(true);
                		$data = simplexml_load_file($folder_path.'/'.$file);
                		//to get content of tags having multiple values
                		$f = file_get_contents($folder_path.'/'.$file);
    				    $xml   = @simplexml_load_string($f);
    				    $json  = json_encode($xml);
                        $array = json_decode($json,TRUE); 
                        
                		//Error in loading file
                		if (false === $data) {
                            // throw new Exception("Cannot load xml source.\n");
                             $error_msg = '';
                            foreach(libxml_get_errors() as $error) {
                                $error_msg .= "\t". $error->message;
                            }
                            $dataa['message'] = $error_msg;
                            $dataa['subject'] = "Ogden News XML : $filename";
                            $dataa['to'] = "sudarshan@adwitads.com, giri@adwitglobal.com";
                            $this->alert_email($dataa);
                            $nnew_path = $archive_path.'/Error/'.$filename;
    					    rename($folder_path.'/'.$filename, $nnew_path);
                            continue;
                        }
                        libxml_clear_errors();
                        libxml_use_internal_errors($use_errors);
                        
                        //echo $data->Ad->advertiser_name;
                        $publication_name = 'Ogden News';
                        $publication_detail = $this->db->query("SELECT p.*, a.id AS adrep_id FROM `publications` p
                                                                        JOIN `adreps` a ON a.publication_id = p.id
                                                                        WHERE `name` = '$publication_name'")->row_array();
                        if(isset($publication_detail['id'])){
                            $publication_id = $publication_detail['id'];
                            $adrep_id = $publication_detail['adrep_id'];
        					$help_desk = $publication_detail['help_desk']; 
        					$group_id = $publication_detail['group_id'];
        					$club_id = $publication_detail['club_id'];
        					$order_type = $data->Ad->order_type_id; 
        					$job_no = $data->Ad->job_no;
        					$pickup_adno = '';
        					if(isset($data->Ad->pickup_ad_no)) $pickup_adno = $data->Ad->pickup_ad_no;
        					if($order_type == '2'){     //print ad
        					    $post_data = array('adrep_id' => $adrep_id,
                        						'publication_id' => $publication_id,
                        						'group_id' => $group_id,
                        						'help_desk' => $help_desk,
                        						'order_type_id' => '2',
                        						'advertiser_name' => $data->Ad->advertiser_name,
                        						'job_no' => $job_no,
                        						'copy_content_description' => $data->Ad->copy_content_description,
                        						'width' => $data->Ad->width,
                        						'height' => $data->Ad->height,
                        						'print_ad_type' => $data->Ad->print_ad_type,
                        						'notes' => $data->Ad->notes,
                        						'date_needed' => $data->Ad->date_needed, 
                        						'publish_date' => $data->Ad->publish_date, 
                        						'font_preferences' => $data->Ad->font_preferences, 
                        						'color_preferences' => $data->Ad->color_preferences,
                        						'activity_time' => date('Y-m-d h:i:s'),
                        						'club_id'=> $club_id,
                        						'pickup_adno' => $pickup_adno
        					                    );    
        					}elseif($order_type == '1'){    //online ad
        					    $post_data = array( 
                        					'adrep_id' => $adrep_id,
                        					'publication_id' => $publication_id,
                        					'group_id' => $group_id,
                        					'help_desk' => $help_desk,
                        					'order_type_id' => '1',
                        					'advertiser_name' => $data->Ad->advertiser_name,
                        					'job_no' => $job_no,
                        					'copy_content_description' => $data->Ad->copy_content_description,
                        					'maxium_file_size' => $data->Ad->maxium_file_size,	
                        					'ad_format' => $data->Ad->ad_format,	
                        					'web_ad_type' => $data->Ad->web_ad_type,	
                        					'notes' => $data->Ad->notes,
                        					'date_needed' => $data->Ad->date_needed, 
                        					'publish_date' => $data->Ad->publish_date, 
                        					'font_preferences' => $data->Ad->font_preferences, 
                        					'color_preferences' => $data->Ad->color_preferences,
                        					//'custom_width' => $data->Ad->width,
                        					//'custom_height' => $data->Ad->height,
                        					'activity_time' => date('Y-m-d h:i:s'),
                        					'club_id'=> $club_id,
                        					'pickup_adno' => $pickup_adno
                        					);   
        					}
        					//insert to table
        					$this->db->insert('orders',$post_data);
        					$orderid = $this->db->insert_id();
        					
        					if(isset($orderid)){
        					    //Live_tracker updation
            					$tracker_data = array(
            											'pub_id'=> $publication_id,
            											'order_id'=> $orderid,
            											'job_no' => $job_no,
            											'club_id'=> $club_id,
            											'status' => '1'
            											);
            					$this->db->insert('live_orders', $tracker_data);
            					
            					//$this->view($orderid, true); //email notification
            					$this->orders_folder($orderid);//html file creation
            					
            					foreach($array as $value) { //tags having multiple values
            					    /*********** Online Orders - Multiple sizes ************/
                					if($order_type == '1'){ 
                					    if(isset($value['sizes']['size'][0])){
            					            $arr_count = count($value['sizes']['size']); 
            					            for($i=0;$i<$arr_count;$i++){
            					                $w = $value['sizes']['size'][$i]['width'];
            					                $h = $value['sizes']['size'][$i]['height'];
            					                
            					                $post_size = array('order_id' => $orderid, 'custom_width' => $w, 'custom_height' => $h);
            		                            $this->db->insert('orders_multiple_custom_size', $post_size);
            					            }
                					    }else{
                					        $w = $value['sizes']['size']['width'];
            					            $h = $value['sizes']['size']['height'];
            					                
            					                $post_size = array('order_id' => $orderid, 'custom_width' => $w, 'custom_height' => $h);
            		                            $this->db->insert('orders_multiple_custom_size', $post_size);    
                					    }
                					}
                					/*********** Online Orders - Multiple sizes END************/
                				    /*************** attachments *****************/
                				    $order_detail = $this->db->query("SELECT `id`, `file_path` FROM `orders` WHERE `id` = '$orderid'")->row_array();
                					if(isset($value['attachments']['attachment'])){
                					    if(is_array($value['attachments']['attachment'])){ //multiple attachments
        					                $arr_count = count($value['attachments']['attachment']); 
                					        for($i=0;$i<$arr_count;$i++){
            					            	$fileUrl = $value['attachments']['attachment'][$i];
												$fileUrl = str_replace('\\', '/', $fileUrl);
                    					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                            					$pathinfo = pathinfo($fileUrl);
                    						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                $localFilePath = $order_detail['file_path'].'/'.$fname;
                                                
                                                // Use file_get_contents to download the file
                                                $fileContents = file_get_contents($fileUrl);
                                                
                                                if ($fileContents === false) {
                                                    echo 'Failed to download the file from the URL.';
                                                    continue;
                                                    //die("Failed to download the file from the URL.");
                                                }
                                                
                                                // Use file_put_contents to save the file locally
                                                $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                
                                                if ($fileSaved === false) {
                                                    echo 'Failed to save the file locally.';
                                                    continue;
                                                    //die("Failed to save the file locally.");
                                                }
                    					   }
                    					}else{  //Single attachments
                    					        $fileUrl = $value['attachments']['attachment'];
                    					        $fileUrl = str_replace('\\', '/', $fileUrl);
                    					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                            					$pathinfo = pathinfo($fileUrl);
                    						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                $localFilePath = $order_detail['file_path'].'/'.$fname;
                                                
                                                // Use file_get_contents to download the file
                                                $fileContents = file_get_contents($fileUrl);
                                                
                                                if ($fileContents === false) {
                                                    echo 'Failed to download the file from the URL.';
                                                    continue;
                                                    //die("Failed to download the file from the URL.");
                                                }
                                                
                                                // Use file_put_contents to save the file locally
                                                $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                
                                                if ($fileSaved === false) {
                                                    echo 'Failed to save the file locally.';
                                                    continue;
                                                    //die("Failed to save the file locally.");
                                                }    
                    					}
                				    }
                				    //copy xml file to downloads
            					        copy($folder_path.'/'.$filename, $order_detail['file_path'].'/'.$filename);
                				    /*************** attachments END*****************/
            					}
            					$new_path = $archive_path.'/'.$filename;
        					    rename($folder_path.'/'.$filename, $new_path);
        					}
        				}
    				}
			}

			closedir($dh);
		}
	}
	
	public function Ogden_answer_xml_content_fetch() //Question-Answer Read ftp Downloaded XML file 
	{
	    //file path
		$archive_path = 'Ogden_ftp_xml/archive';
		$folder_path = 'Ogden_ftp_xml/answer'; 

		if($dh = opendir($folder_path)){
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..'){ continue; }
				$filename = $file;
				
    				$valid_extension = array('xml','XML');
    				$file_data = explode('.', $file);
    				$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    $use_errors = libxml_use_internal_errors(true);
                		$data = simplexml_load_file($folder_path.'/'.$file);
                		
                		//to get content of tags having multiple values
                		$f = file_get_contents($folder_path.'/'.$file);
    				    $xml   = @simplexml_load_string($f);
    				    $json  = json_encode($xml);
                        $array = json_decode($json,TRUE); 
                        
                		//Error in loading file
                		if (false === $data) {
                            // throw new Exception("Cannot load xml source.\n");
                             $error_msg = '';
                            foreach(libxml_get_errors() as $error) {
                                $error_msg .= "\t". $error->message;
                            }
                            $dataa['message'] = $error_msg;
                            $dataa['subject'] = "Ogden News Answer XML : $filename";
                            $dataa['to'] = "sudarshan@adwitads.com";
                            $this->alert_email($dataa);
                            $nnew_path = $archive_path.'/Error/'.$filename;
    					    rename($folder_path.'/'.$filename, $nnew_path);
                            continue;
                        }
                        libxml_clear_errors();
                        libxml_use_internal_errors($use_errors);
                        
                        $order_id = $data->Ad->orderId;
                        $answer = $data->Ad->answer;
                        foreach($array as $value) { //tags having multiple values
                            $order_detail = $this->db->get_where('orders', array('id' => $order_id))->row_array();
                            if(isset($order_detail['id'])){
                                $path = $order_detail['file_path'];
                                $rev_order = $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' ORDER BY `id` DESC LIMIT 1")->row_array();
                                if(isset($rev_order['id'])){    //Answer for question  revision
                                    $path = $rev_order['file_path'];
                                    //order status question
                        			$post_status = array('question' => '2');//Q answered
                        			$this->db->where('id', $rev_order['id']);
                        			$this->db->update('rev_sold_jobs', $post_status); 
                        			
                        			//order activity time 
                        			$post_status1 = array('activity_time' => date('Y-m-d h:i:s'));
                        			$this->db->where('id', $order_id);
                        			$this->db->update('orders', $post_status1); 
                        			//orders_Q_A
                					$question = $this->db->query("SELECT * FROM `orders_Q_A` 
                                                                    WHERE `rev_id` = '".$rev_order['id']."' ORDER BY `id` DESC LIMIT 1")->row_array();
                        			if(isset($question['id'])){
                            			$timestamp = date('Y-m-d H:i:s');
                            			$Apost = array( 'answer' => $answer, 
                            							'adrep' => '2762',
                            							'Atimestamp' => $timestamp
                            							);
                            			$this->db->where('id', $question['id']);
                            			$this->db->update('orders_Q_A', $Apost);
                        			}
                                }else{                          //Answer for question  newAd
                                    //order status
                					$post_status = array('question' => '2','activity_time' => date('Y-m-d h:i:s'));
                					$this->db->where('id', $order_id);
                					$this->db->update('orders', $post_status); 
                					
                					//orders_Q_A
                					$question = $this->db->query("SELECT * FROM `orders_Q_A` 
                                                                    WHERE `order_id` = '$order_id' AND `rev_id` = '0' ORDER BY `id` DESC LIMIT 1")->row_array(); 
                                    if(isset($question['id'])){
                                        $timestamp = date('Y-m-d H:i:s');
                    					$Apost = array( 'answer' => $answer, 'adrep' => '2762', 'Atimestamp' => $timestamp );
                    					$this->db->where('id', $question['id']);
                    					$this->db->update('orders_Q_A', $Apost);    
                                    }                                
                					
                					//Live_tracker Updation
                					$update_order = $this->db->query("SELECT * FROM `live_orders` Where `order_id`='".$order_id."' ")->row_array();
                					if(isset($update_order['id'])){
                						$tracker_data = array('question' => '2');
                						$this->db->where('id', $update_order['id']);
                						$this->db->update('live_orders', $tracker_data);
                					}
                                }
                                /*************** attachments upload to downloads folder*****************/
                				    if(isset($value['attachments']['attachment'])){
                					    if(is_array($value['attachments']['attachment'])){ //multiple attachments
        					                $arr_count = count($value['attachments']['attachment']); 
                					        for($i=0;$i<$arr_count;$i++){
            					            	$fileUrl = $value['attachments']['attachment'][$i];
												$fileUrl = str_replace('\\', '/', $fileUrl);
                    					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                            					$pathinfo = pathinfo($fileUrl);
                    						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                $localFilePath = $path.'/'.$fname;
                                                
                                                // Use file_get_contents to download the file
                                                $fileContents = file_get_contents($fileUrl);
                                                
                                                if ($fileContents === false) {
                                                    echo 'Failed to download the file from the URL.';
                                                    continue;
                                                    //die("Failed to download the file from the URL.");
                                                }
                                                
                                                // Use file_put_contents to save the file locally
                                                $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                
                                                if ($fileSaved === false) {
                                                    echo 'Failed to save the file locally.';
                                                    continue;
                                                    //die("Failed to save the file locally.");
                                                }
                    					   }
                    					}else{  //Single attachments
                    					        $fileUrl = $value['attachments']['attachment'];
                    					        $fileUrl = str_replace('\\', '/', $fileUrl);
                    					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                            					$pathinfo = pathinfo($fileUrl);
                    						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                $localFilePath = $path.'/'.$fname;
                                                
                                                // Use file_get_contents to download the file
                                                $fileContents = file_get_contents($fileUrl);
                                                
                                                if ($fileContents === false) {
                                                    echo 'Failed to download the file from the URL.';
                                                    continue;
                                                    //die("Failed to download the file from the URL.");
                                                }
                                                
                                                // Use file_put_contents to save the file locally
                                                $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                
                                                if ($fileSaved === false) {
                                                    echo 'Failed to save the file locally.';
                                                    continue;
                                                    //die("Failed to save the file locally.");
                                                }    
                    					}
                				    }
                			    /*************** attachments END*****************/
                			    //copy xml file to downloads
                			    $t = date("Y-m-d h:i:s", time()); $answerXml = 'answer_'.$t.'.xml';
            					copy($folder_path.'/'.$filename, $path.'/'.$answerXml); 
            					        
            					//move file from folder answer to archive
            					$new_path = $archive_path.'/'.$filename;
        					    rename($folder_path.'/'.$filename, $new_path);
                            }
            			}
    				}
			}

			closedir($dh);
		}
	}
	
	public function Ogden_revision_xml_content_fetch() //Revision Read ftp Downloaded XML file 
	{
	    //file path
		$archive_path = 'Ogden_ftp_xml/archive';
		$folder_path = 'Ogden_ftp_xml/revision_in'; 

		if($dh = opendir($folder_path)){
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..'){ continue; }
				$filename = $file;
				$valid_extension = array('xml','XML');
    			$file_data = explode('.', $file);
    			$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    $use_errors = libxml_use_internal_errors(true);
                		$data = simplexml_load_file($folder_path.'/'.$file);
                		
                		//to get content of tags having multiple values
                		$f = file_get_contents($folder_path.'/'.$file);
    				    $xml   = @simplexml_load_string($f);
    				    $json  = json_encode($xml);
                        $array = json_decode($json,TRUE); 
                        
                		//Error in loading file
                		if (false === $data) {
                            // throw new Exception("Cannot load xml source.\n");
                             $error_msg = '';
                            foreach(libxml_get_errors() as $error) {
                                $error_msg .= "\t". $error->message;
                            }
                            $dataa['message'] = $error_msg;
                            $dataa['subject'] = "Ogden News Revision XML : $filename";
                            $dataa['to'] = "sudarshan@adwitads.com";
                            $this->alert_email($dataa);
                            $nnew_path = $archive_path.'/Error/'.$filename;
    					    rename($folder_path.'/'.$filename, $nnew_path);
                            continue;
                        }
                        libxml_clear_errors();
                        libxml_use_internal_errors($use_errors);
                        
                        $order_id = $data->Ad->orderId;
                        $instructions = $data->Ad->instructions;
                        
                            $order_detail = $this->db->get_where('orders', array('id' => $order_id))->row_array();
                            if(isset($order_detail['id'])){
                                $version = 'V1a'; 
				                $orders_rev =  $this->db->query("SELECT * FROM `rev_sold_jobs` WHERE `order_id`= '$order_id' AND `status` = '5' ORDER BY `id` DESC LIMIT 1 ;")->row_array();
				                if(isset($orders_rev['id'])){
                    				$job_slug = $orders_rev['new_slug'];
                    			}else{
                    			    $cat_result = $this->db->query("SELECT `slug` FROM `cat_result` WHERE `order_no`= '$order_id'")->row_array();
                    				$job_slug = $cat_result['slug'];
                    			}
                    			if($job_slug == 'none'){
                    			    $error_msg = $order_id."-Revision not yet allowed.. Previous job pending..";
                    				$dataa['message'] = $error_msg;
                                    $dataa['subject'] = "Ogden News Revision XML : $filename";
                                    $dataa['to'] = "sudarshan@adwitads.com";
                                    $this->alert_email($dataa);
                                    $nnew_path = $archive_path.'/Error/'.$filename;
    					            rename($folder_path.'/'.$filename, $nnew_path);
    					            continue;
                    			}
				                if(isset($orders_rev['id'])){
									$version = $orders_rev['version'];
                					if($version == 'V1a'){ $version = 'V1b'; }
                						elseif($version == 'V1b'){ $version = 'V1c'; }
                						elseif($version == 'V1c'){ $version = 'V1d'; }
                						elseif($version == 'V1d'){ $version = 'V1e'; }
                						elseif($version == 'V1e'){ $version = 'V1f'; }
                						elseif($version == 'V1f'){ $version = 'V1g'; }
                						elseif($version == 'V1g'){ $version = 'V1h'; }
                						elseif($version == 'V1h'){ $version = 'V1i'; }
                						elseif($version == 'V1i'){ $version = 'V1j'; }
                						elseif($version == 'V1j'){ $version = 'V1k'; }
                						elseif($version == 'V1k'){ $version = 'V1l'; }
                						elseif($version == 'V1l'){ $version = 'V1m'; }
                						elseif($version == 'V1m'){ $version = 'V1n'; }
                        				elseif($version == 'V1n'){ $version = 'V1o'; }
                        				elseif($version == 'V1o'){ $version = 'V1p'; }
                        				elseif($version == 'V1p'){ $version = 'V1q'; }
                        				elseif($version == 'V1q'){ $version = 'V1r'; }
                        				elseif($version == 'V1r'){ $version = 'V1s'; }
                        				elseif($version == 'V1s'){ $version = 'V1t'; }
                        				elseif($version == 'V1t'){ $version = 'V1u'; }
                        				elseif($version == 'V1u'){ $version = 'V1v'; }
                        				elseif($version == 'V1v'){ $version = 'V1w'; }
                        				elseif($version == 'V1w'){ $version = 'V1x'; }
                        				elseif($version == 'V1x'){ $version = 'V1y'; }
                        				elseif($version == 'V1y'){ $version = 'V1z'; }
                				}
                				
                				$client = $this->db->get_where('adreps',array('id' => $order_detail['adrep_id']))->row_array();
                				$publication = $this->db->query("Select * from publications where id = '".$client['publication_id']."'")->row_array();
                				
                				$rev_data = array(
                					'order_id' => $order_id,
                					'order_no' => $job_slug,
                					'adrep' => $order_detail['adrep_id'],
                					'help_desk' => $publication['help_desk'],
                					'date' => date('Y-m-d'),
                					'time' => date("H:i:s"),
                					'category' =>'revision',
                					'version' => $version,
                					'note' => $instructions,
                					'status' => '1',
                					);
                				$this->db->insert('rev_sold_jobs',$rev_data);
                				$rev_id = $this->db->insert_id(); 
                				if($rev_id){
                				    //Revision details of the order
                					$rev_count = $order_detail['rev_count'];
                					if(empty($rev_count)){ $rev_count = 0; }
                					
                					$rev_count_data = array(
                					    'rev_count' => $rev_count + 1, 
                					    'rev_id' => $rev_id,
                					    'rev_order_status' => '1', //Revision Submitted
                					    'activity_time' => date('Y-m-d h:i:s'),
                					);
                					$this->db->where('id', $order_id);
                					$this->db->update('orders', $rev_count_data);
                					
                					//folder creation
                					$path = "revision_downloads/".$order_id.'-'.$rev_id; 
                					if (@mkdir($path,0777))	{}
                					//save path
                					$post = array('file_path' => $path);
                					$this->db->where('id', $rev_id);
                					$this->db->update('rev_sold_jobs', $post);
                					/*************** attachments upload to downloads folder*****************/
                					$revision = $this->db->get_where('rev_sold_jobs',array('id' => $rev_id))->row_array(); //updated entry
                					foreach($array as $value) { //tags having multiple values
                    				    if(isset($value['attachments']['attachment'])){
                    					    if(is_array($value['attachments']['attachment'])){ //multiple attachments
            					                $arr_count = count($value['attachments']['attachment']); 
                    					        for($i=0;$i<$arr_count;$i++){
                					            	$fileUrl = $value['attachments']['attachment'][$i];
    												$fileUrl = str_replace('\\', '/', $fileUrl);
                        					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                                					$pathinfo = pathinfo($fileUrl);
                        						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                    $localFilePath = $revision['file_path'].'/'.$fname;
                                                    
                                                    // Use file_get_contents to download the file
                                                    $fileContents = file_get_contents($fileUrl);
                                                    
                                                    if ($fileContents === false) {
                                                        echo 'Failed to download the file from the URL.'; continue;
                                                        //die("Failed to download the file from the URL.");
                                                    }
                                                    
                                                    // Use file_put_contents to save the file locally
                                                    $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                    
                                                    if ($fileSaved === false) {
                                                        echo 'Failed to save the file locally.'; continue;
                                                        //die("Failed to save the file locally.");
                                                    }
                        					   }
                        					}else{  //Single attachments
                        					        $fileUrl = $value['attachments']['attachment'];
                        					        $fileUrl = str_replace('\\', '/', $fileUrl);
                        					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                                					$pathinfo = pathinfo($fileUrl);
                        						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                    $localFilePath = $revision['file_path'].'/'.$fname;
                                                    
                                                    // Use file_get_contents to download the file
                                                    $fileContents = file_get_contents($fileUrl);
                                                    
                                                    if ($fileContents === false) {
                                                        echo 'Failed to download the file from the URL.'; continue;
                                                        //die("Failed to download the file from the URL.");
                                                    }
                                                    
                                                    // Use file_put_contents to save the file locally
                                                    $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                    
                                                    if ($fileSaved === false) {
                                                        echo 'Failed to save the file locally.'; continue;
                                                        //die("Failed to save the file locally.");
                                                    }    
                        					}
                    				    }
                					}
                					//copy xml file to downloads
            					        copy($folder_path.'/'.$filename, $revision['file_path'].'/'.$filename);
                			    /*************** attachments END*****************/
                				}
                                
            					//move file from folder answer to archive
            					$new_path = $archive_path.'/'.$filename;
        					    rename($folder_path.'/'.$filename, $new_path);
                            }
            			
    				}
			}

			closedir($dh);
		}
	}
	
	public function Ogden_additionalAttachment_xml_content_fetch() //additionalAttachment Read ftp Downloaded XML file 
	{
	    //file path
		$archive_path = 'Ogden_ftp_xml/archive';
		$folder_path = 'Ogden_ftp_xml/additional_attachment'; 

		if($dh = opendir($folder_path)){
			while(($file = readdir($dh)) !== false) {
				if($file == '.' || $file == '..'){ continue; }
				$filename = $file;
				
    				$valid_extension = array('xml','XML');
    				$file_data = explode('.', $file);
    				$file_extension = end($file_data);
    				if(in_array($file_extension, $valid_extension))
    				{
    				    $use_errors = libxml_use_internal_errors(true);
                		$data = simplexml_load_file($folder_path.'/'.$file);
                		
                		//to get content of tags having multiple values
                		$f = file_get_contents($folder_path.'/'.$file);
    				    $xml   = @simplexml_load_string($f);
    				    $json  = json_encode($xml);
                        $array = json_decode($json,TRUE); 
                        
                		//Error in loading file
                		if (false === $data) {
                            // throw new Exception("Cannot load xml source.\n");
                             $error_msg = '';
                            foreach(libxml_get_errors() as $error) {
                                $error_msg .= "\t". $error->message;
                            }
                            $dataa['message'] = $error_msg;
                            $dataa['subject'] = "Ogden News Additional Attachment XML : $filename";
                            $dataa['to'] = "sudarshan@adwitads.com";
                            $this->alert_email($dataa);
                            $nnew_path = $archive_path.'/Error/'.$filename;
    					    rename($folder_path.'/'.$filename, $nnew_path);
                            continue;
                        }
                        libxml_clear_errors();
                        libxml_use_internal_errors($use_errors);
                        
                        $order_id = $data->Ad->orderId;
                        $notes = $data->Ad->notes;
                        foreach($array as $value) { //tags having multiple values
                            $order_detail = $this->db->get_where('orders', array('id' => $order_id))->row_array();
                            $rev_id = 0;
                            if(isset($order_detail['id'])){
                                $rev_details = $this->db->query("SELECT * from `rev_sold_jobs` where `order_id`='$order_id' ORDER BY `id` DESC")->row_array();
                    			if($rev_details){
                    			    $rev_id = $rev_details['id'];
                    				$path = $rev_details['file_path'];
                    				
                    				if($path == 'none'){    //if file_path is none create directory
                    				    //folder creation
                    				   	$path = "revision_downloads/".$order_id.'-'.$rev_id; 
                    					if (@mkdir($path,0777))	{}
                    					//save path
                    					$post = array('file_path' => $path);
                    					$this->db->where('id', $rev_id);
                    					$this->db->update('rev_sold_jobs', $post);   
                    				}
                    			}else{
                    				$path = $order_detail['file_path'];
                    				
                    				if($path == 'none'){    //if file_path is none create directory
                    				    $jname = $order_detail['job_no'];
                        	            $path = "downloads/".$order_id."-".$jname; //path specification
                        			    if (@mkdir($path,0777)){}
                        			
                        			    //save path
                        				$post = array('file_path' => $path);
                        				$this->db->where('id', $order_id);
                        				$this->db->update('orders', $post);
                    				}
                    			}
                    			/***insert additional instructions**/
                    			if(isset($notes) && !empty($notes) && strlen($notes) != 0){
                    			   $post_note = array('order_id' => $order_id, 'revision_id' => $rev_id, 'instructions' => $notes); 
                    			   $this->db->insert('orders_additional_instruction', $post_note);
                    			   
                    			   //html file update
                                    $html_file = $order_detail['file_path'].'/'.$order_detail['job_no'].'.html';
                                    if(file_exists($html_file)){
                                        $fh = fopen($html_file, 'a') or die("can't open file");
                                        $content = '<div>
                                                        <table>
                                                            <tr style="background-color:#eee; vertical-align: top;">
                                                                <td colspan="4"><p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px; text-align: center;"><b>Additional Instructions</b></p></td>
                                                            </tr>
                                                            <tr style="background-color:#eee; vertical-align: top;">
                                                                <td colspan="4" align="center">
                                                                    <p style="padding: 10px; margin: 0px; color: #000; font-family:Tahoma, Geneva, sans-serif; font-size:14px;">
                                                                    '.$notes.'
                                                            		</p>
                                                            	</td>
                                                            </tr> 
                                                        </table>
                                                    </div>';
                                        fwrite($fh, $content);
                        				fclose($fh);
                                    }
                    			}
                                /*************** attachments upload to downloads folder*****************/
                				    if(isset($value['attachments']['attachment'])){
                					    if(is_array($value['attachments']['attachment'])){ //multiple attachments
        					                $arr_count = count($value['attachments']['attachment']); 
                					        for($i=0;$i<$arr_count;$i++){
            					            	$fileUrl = $value['attachments']['attachment'][$i];
												$fileUrl = str_replace('\\', '/', $fileUrl);
                    					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                            					$pathinfo = pathinfo($fileUrl);
                    						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                $localFilePath = $path.'/'.$fname;
                                                
                                                // Use file_get_contents to download the file
                                                $fileContents = file_get_contents($fileUrl);
                                                
                                                if ($fileContents === false) {
                                                    echo 'Failed to download the file from the URL.'; continue;
                                                    //die("Failed to download the file from the URL.");
                                                }
                                                
                                                // Use file_put_contents to save the file locally
                                                $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                
                                                if ($fileSaved === false) {
                                                    echo 'Failed to save the file locally.'; continue;
                                                    //die("Failed to save the file locally.");
                                                }
                    					   }
                    					}else{  //Single attachments
                    					        $fileUrl = $value['attachments']['attachment'];
                    					        $fileUrl = str_replace('\\', '/', $fileUrl);
                    					        $fileUrl = str_replace(' ', '%20', $fileUrl);
                            					$pathinfo = pathinfo($fileUrl);
                    						    $fname = str_replace('%20', ' ', $pathinfo['basename']);
                                                $localFilePath = $path.'/'.$fname;
                                                
                                                // Use file_get_contents to download the file
                                                $fileContents = file_get_contents($fileUrl);
                                                
                                                if ($fileContents === false) {
                                                    echo 'Failed to download the file from the URL.'; continue;
                                                    //die("Failed to download the file from the URL.");
                                                }
                                                
                                                // Use file_put_contents to save the file locally
                                                $fileSaved = file_put_contents($localFilePath, $fileContents);
                                                
                                                if ($fileSaved === false) {
                                                    echo 'Failed to save the file locally.'; continue;
                                                    //die("Failed to save the file locally.");
                                                }    
                    					}
                				    }
                			    /*************** attachments END*****************/
                			    
            					//move file from folder answer to archive
            					$new_path = $archive_path.'/'.$filename;
        					    rename($folder_path.'/'.$filename, $new_path);
                            }
            			}
    				}
			}

			closedir($dh);
		}
	}
	/***************** Ogden FTP XML END ***************/
	
	
	// Team wise ad volume Report starts here
    public function teamwise_advolume_mail(){
       
        $current_date = date("Y-m-d");
	    $to_day = date('D');
        $query = $this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='$to_day'");
        $result_array = $query->result_array();
        $todays_data_count = $query->num_rows();
        
        if($todays_data_count=='0'){ 
            if($to_day == 'Mon')
            {
                $this->teamwise_advolume_mon_calc(); //On Monday
            }else{
                $this->teamwise_advolume_calc();	//On Otherdays
            } 
            $query = $this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='$to_day'");
            $result_array = $query->result_array();
            $todays_data_count = $query->num_rows();
        }
        if($todays_data_count!='0'){
            $Subject = "Today's Ad Volume ".$current_date;
            $Body =  $this->load->view('cron_jobs/teamwisead_volume_mail_content');
            
            include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("do_not_reply@adwitads.com", "do_not_reply");
    		$email->setSubject($Subject);
    	
    		$tos = [ 
    // 			'giri@adwitglobal.com' => "user",
    			'sudarshan@adwitads.com' => "user",
    			'kokila@adwitads.com' => "user"
    		];
    		
    		$email->addTos($tos);
            // $email->addTo('kokila@adwitads.com', "user");
            
    		$email->addContent("text/html", $Body);
    		
            $sendgrid = new \SendGrid('');
    		
    		$success = $sendgrid->send($email);

        } 

        
    }
    public function teamwise_advolume_mon_calc(){
        $today = date('Y-m-d');
        $day = date('D');
        $date1 = date('Y-m-d', strtotime(' -1 day'));
        $date2 = date('Y-m-d', strtotime(' -2 day'));
        $date3 = date('Y-m-d', strtotime(' -3 day'));
        $now = date('H:i:s');
        $tstamp = "08:29:59";
        $query = $this->db->query("TRUNCATE TABLE `teamwise_daily_report` ");
        $i = 0;
        $adwit_teams_query = $this->db->query("SELECT adwit_teams_id  from adwit_teams where team_report =1")->result_array();
        foreach($adwit_teams_query as $adwit_team){
            $adwit_team_id =$adwit_team['adwit_teams_id'];

            $data = $this->db->query("SELECT COUNT(id) as orders_count FROM `orders`where orders.club_id in (select club_id from adwit_teams_and_club where adwit_teams_id =$adwit_team_id)
			and orders.created_on between '$today 00:00:00' AND '$today $now'")->result_array();
            $adcount[$i] = $data[0]['orders_count'];

            $data = $this->db->query("SELECT COUNT(id) as orders_count FROM `orders`where orders.club_id in (select club_id from adwit_teams_and_club where adwit_teams_id =$adwit_team_id)
			and orders.created_on between '$date1 00:00:00' AND '$date1 23:59:59'")->result_array();
            $adcount[$i] += $data[0]['orders_count'];

            $data = $this->db->query("SELECT COUNT(id) as orders_count FROM `orders`where orders.club_id in (select club_id from adwit_teams_and_club where adwit_teams_id =$adwit_team_id)
			and orders.created_on between '$date2 00:00:00' AND '$date2 23:59:59'")->result_array();
            $adcount[$i] += $data[0]['orders_count'];

            $data = $this->db->query("SELECT COUNT(id) as orders_count FROM `orders`where orders.club_id in (select club_id from adwit_teams_and_club where adwit_teams_id =$adwit_team_id)
			and orders.created_on between '$date3 $tstamp' AND '$date3 23:59:59'")->result_array();
            $adcount[$i] += $data[0]['orders_count'];

            if($adwit_team_id == 1 || $adwit_team_id == 3){
                if($adcount[$i]<='69')
                {
                    $color="#ffff66"; //yellow
                }elseif($adcount[$i] >='70' && $adcount[$i] <'100')
                {
                    $color="#ff9933"; //orange
                }elseif($adcount[$i] >='100')
                {
                    $color="red";//red
                }
            }

            if($adwit_team_id == 2 || $adwit_team_id == 4){
                if($adcount[$i]<='179')
                {
                    $color="#ffff66"; //yellow
                }elseif($adcount[$i]>='180' && $adcount[$i]<'220')
                {
                    $color="#ff9933"; //orange
                }elseif($adcount[$i] >='220')
                {
                    $color="red";//red
                }
            }
            $dataArray =array("day"=>$day, 'adwit_team_id'=> $adwit_team_id, 'ad_count'=>$adcount[$i], 'color'=>$color, 'date'=>$today, 'time'=>$now);
            $this->db->insert('teamwise_daily_report', $dataArray);

            $i++;

        }

    }

    public function teamwise_advolume_calc(){
        $today = date('Y-m-d');
        $day = date('D');
        $ystday = date('Y-m-d', strtotime(' -1 day'));
        $now = date('H:i:s');
        $tstamp = "08:29:59"; //prev day 8:30am

        $i =0;
        $adwit_teams_query = $this->db->query("SELECT adwit_teams_id  from adwit_teams where team_report =1")->result_array();
        
        foreach($adwit_teams_query as $adwit_team){
            $adwit_team_id =$adwit_team['adwit_teams_id'];

            $data = $this->db->query("SELECT COUNT(id) as orders_count FROM `orders`where orders.club_id in (select club_id from adwit_teams_and_club where adwit_teams_id =$adwit_team_id)
            and orders.created_on between '$today 00:00:00' AND '$today $now'")->result_array();
            $adcount[$i] = $data[0]['orders_count'];

            $data = $this->db->query("SELECT COUNT(id) as orders_count FROM `orders`where orders.club_id in (select club_id from adwit_teams_and_club where adwit_teams_id =$adwit_team_id)
            and orders.created_on between '$ystday $tstamp' AND '$ystday 23:59:59'")->result_array();
            $adcount[$i] += $data[0]['orders_count'];
          
            if($adwit_team_id == 1 || $adwit_team_id == 3){
                if($adcount[$i]<='69')
                {
                    $color="#ffff66"; //yellow
                }elseif($adcount[$i] >='70' && $adcount[$i] <'100')
                {
                    $color="#ff9933"; //orange
                }elseif($adcount[$i] >='100')
                {
                    $color="red";//red
                }
            }

            if($adwit_team_id == 2 || $adwit_team_id == 4){
                if($adcount[$i]<='179')
                {
                    $color="#ffff66"; //yellow
                }elseif($adcount[$i]>='180' && $adcount[$i]<'220')
                {
                    $color="#ff9933"; //orange
                }elseif($adcount[$i] >='220')
                {
                    $color="red";//red
                }
            }

            $dataArray =array("day"=>$day, 'adwit_team_id'=> $adwit_team_id, 'ad_count'=>$adcount[$i], 'color'=>$color, 'date'=>$today, 'time'=>$now);
            $this->db->insert('teamwise_daily_report', $dataArray);

            $i++;

        } 
    }
	// Team wise ad volume Report ends here
}

?>