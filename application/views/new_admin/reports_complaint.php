<?php $this->load->view('new_admin/header')?>

<style>
	.dropdown-menu{
		position: relative !important;
	}
	.btn-xxs{
		padding: 5px;
		font-size: 12px;
		line-height: .8;
	}
	.no-border{
		border: 0px !important;
	}
</style>

 <div class="col-md-10 border-right">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="row margin-bottom-5">	
			<div class="col-md-6 col-xs-8">
				<a href="<?php echo base_url().index_page().'new_admin/home/admin_report';?>" class="font-lg font-grey-gallery">Complaints</a>
			</div>							
			<div class="col-md-6 col-xs-4 text-right">	
				<form method="post">
					<div class="btn-group"> 
					<a href="<?php echo base_url().index_page().'new_admin/home/complaint_keywords';?>" target="_Blank" class="btn bg-blue-flamingo btn-sm margin-right-5 default">Keywords</a>
						<button type="submit" name="generate" class="btn bg-blue-flamingo btn-sm margin-right-5">Generate</button>
						<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
					</div>
				</form>
			</div>			
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-bordered table-hover" id="sample_3">
				<thead>
					<tr>
						<th class="hidden">Copy</th>
						<th class="hidden">Attachments</th>
						<th>Date</th>
						<th>AdwitAds ID</th>
						<th>Keyword</th>
						<th>Version</th>
					</tr>
				</thead>
				<tbody> 
				<?php 
					if(isset($rev_sold)){
						$order_complaint_words = $this->db->query("SELECT * FROM `order_complaint_words`")->result_array();
						foreach($rev_sold as $rev_sold_row){ ?>
					<tr>
						<td class="hidden">								
							<?php echo $rev_sold_row['note']; ?>
						</td>
						<td class="hidden">	
							<?php 
								if($rev_sold_row['file_path'] != 'none' && file_exists($rev_sold_row['file_path'])){ 
									$filepath = $rev_sold_row['file_path'];
									$this->load->helper('directory');
									$map = glob($filepath.'/*',GLOB_BRACE);
									if($map)$i=0;{ foreach($map as $row1){$i++;
							?>								
							<a href="<?php echo base_url().$row1; ?>" target="_Blank" class="btn btn-xxs bg-grey-cascade">Attachments <?php echo $i;?></a>
							<?php } } } ?>
						</td>
						<td><?php $date = strtotime($rev_sold_row['date']); echo date('M d, Y', $date); ?></td>
						<td><a href="<?php echo base_url().index_page().'new_admin/home/orderview_history/'.$rev_sold_row['help_desk'].'/'.$rev_sold_row['order_id'].'/'.$rev_sold_row['date'];?>" type="button">
						<?php echo $rev_sold_row['order_id'] ;?></a></td>
						<td>
							<?php foreach($order_complaint_words as $word_row){
								$word = $word_row['name'];
								$string1 = $rev_sold_row['note'];
									if(strpos($string1, ' '.$word.' ') !== FALSE){  
										echo $word; } }?>
						</td>
						<td><?php 
						$string = $rev_sold_row['order_no'];
						$output = explode("_",$string);
						echo $output[count($output)-1];?></td>
					</tr> 
					<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div> 
 </div>
 
 <div class="col-md-2">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="font-lg margin-bottom-5 align-center">Archive</div>	
		</div>
		<div class="portlet-body">
			<?php 	$start = date('Y-m-d', strtotime('-3 day')); //start date
					$end =  date('Y-m-d');//end date
					 $dates = array();
					$start = $current = strtotime($start);
					$end = strtotime($end);

					while ($current <= $end) { 
					$dates[] = date('Y-m-d', $current);
					$current = strtotime('+1 days', $current);}
					foreach($dates as $d){ ?>
					<a href="<?php echo base_url().index_page(). 'new_admin/home/reports_complaint/'.$d; ?>"  class="btn btn-sm margin-bottom-10 btn-block default"><?php $date = strtotime($d); echo date('M d, Y', $date); ?></a>
					<?php } ?>
		</div>
	</div>
</div>	

<?php $this->load->view('new_admin/footer')?>
<?php $this->load->view('new_admin/datatable.php'); ?>
