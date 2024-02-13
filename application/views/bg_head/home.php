<?php
	$this->load->view("bg_head/header");
?>
 <?php
		$bg1_nj = 0;
		$bg2_nj = 0;
		$bg3_nj = 0;
		$bg4_nj = 0;
		$today = date('Y-m-d');
		foreach($bg1_news as $row)
		{
			$cat_result = $this->db->get_where('cat_result',array('news_id' => $row['id'], 'ddate' => $today))->result_array();
			foreach($cat_result as $row1)
			{
				$category = $this->db->get_where('print',array('name' => $row1['category']))->result_array();
				$bg1_nj = $bg1_nj + $category[0]['wt'];
			}
		}
	
		foreach($bg2_news as $row)
		{
			$cat_result = $this->db->get_where('cat_result',array('news_id' => $row['id'], 'ddate' => $today))->result_array();
			foreach($cat_result as $row1)
			{
				$category = $this->db->get_where('print',array('name' => $row1['category']))->result_array();
				$bg2_nj = $bg2_nj + $category[0]['wt'];
			}
		}
		
		foreach($bg3_news as $row)
		{
			$cat_result = $this->db->get_where('cat_result',array('news_id' => $row['id'], 'ddate' => $today))->result_array();
			foreach($cat_result as $row1)
			{
				$category = $this->db->get_where('print',array('name' => $row1['category']))->result_array();
				$bg3_nj = $bg3_nj + $category[0]['wt'];
			}
		}
		
		foreach($bg4_news as $row)
		{
			$cat_result = $this->db->get_where('cat_result',array('news_id' => $row['id'], 'ddate' => $today))->result_array();
			foreach($cat_result as $row1)
			{
				$category = $this->db->get_where('print',array('name' => $row1['category']))->result_array();
				$bg4_nj = $bg4_nj + $category[0]['wt'];
			}
		}
	
	?>    
	
	<div id="Middle-Div">
    <div id="Middle-text">Welcome <?php echo $this->session->userdata('bg');?></div>
	<div id="dpdd">
      <div id="dpddg1">
      <h2>&nbsp;</h2>
      <p>BG1 Today's NJ : <?php echo $bg1_nj; ?></p>
      </div>
      <div id="dpddg2">
      <h2>&nbsp;</h2>
      <p>BG2 Today's NJ : <?php echo $bg2_nj; ?></p>
      </div>
      <div id="dpddg3">
      <h2 style=" color: #39F;">&nbsp;</h2>
      <p>BG3 Today's NJ : <?php echo $bg3_nj; ?></p>
      </div>
      <div id="dpddg4">
      <h2 style=" color: #39F;">&nbsp;</h2>
      <p>BG4 Today's NJ : <?php echo $bg4_nj; ?></p>
      </div>
    </div>
	 
  </div> 

<?php
	$this->load->view("bg_head/footer");
?>