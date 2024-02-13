<?php $this->load->view('new_admin/header.php'); ?>

<!-- BEGIN PAGE CONTAINER -->
<div class="portlet light">
<div class="portlet-title">
<div  class="col-xs-12 text-center">
	<?php echo '<span style=" color:#900;">'.$this->session->flashdata('message').'</span>'; ?> 
</div>
<div class="row">
	<div class="col-md-7 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
		<a href="<?php echo base_url().index_page(). 'new_admin/home/size_date/'.$type; ?>" class="font-grey-gallery">Size Report</a> :
		<span><?php $f = strtotime($from) ; $t = strtotime($to); echo "From "." - ".date('M d, Y', $f)." ". "  To " . " - " .date('M d, Y', $t);?> </span>
	</div>
	<div></div>
	<div class="col-md-3 col-xs-9 margin-bottom-10 text-right padding-right-0">
		
	</div>
	<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">
		<!--<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>-->
	</div>
	<div class="col-md-1 col-xs-4 margin-bottom-10 text-right">	
		<span class="cursor-pointer"><img src="assets/new_admin/img/back.png" onclick="goBack()"></span>
	</div>
	</div>
	</div>

	<div class="portlet-body " >
		<div>
		<?php   $width = 0; $height=0;  $order['size_inches']=0; $t_v_count = 0; $t_h_count = 0; $t_s_count=0; $t_t_count=0;
				$v_count = 0;$s_count = 0;$h_count = 0;$total_count = 0;
				$v_count1 = 0;$s_count1 = 0;$h_count1 = 0;$total_count1 = 0; 
				$v_count2 = 0;$s_count2 = 0;$h_count2 = 0;$total_count2 = 0;
				$v_count3 = 0;$s_count3 = 0;$h_count3 = 0;$total_count3 = 0;
				$v_count4 = 0;$s_count4 = 0;$h_count4 = 0;$total_count4 = 0;
				$v_count5 = 0;$s_count5 = 0;$h_count5 = 0;$total_count5 = 0;
				$v_count6 = 0;$s_count6 = 0;$h_count6 = 0;$total_count6 = 0;
				
				foreach($orders as $order)
				{ //var_dump($order);
					if( $order['size_inches'] >= 1 &&  $order['size_inches'] <= 10){
						if($order['width'] < $order['height']){ $v_count = $v_count + 1;}
						if($order['width'] == $order['height']){ $s_count = $s_count + 1;}
						if($order['width'] > $order['height']){ $h_count = $h_count+ 1;}
						$total_count = $v_count + $s_count + $h_count;
								
					}elseif( $order['size_inches'] >= 11 &&  $order['size_inches'] <= 20){
						if($order['width'] < $order['height']){ $v_count1 = $v_count1 + 1;} 
						if($order['width'] == $order['height']){ $s_count1 = $s_count1 + 1;}
						if($order['width'] > $order['height']){ $h_count1 = $h_count1 +1;} 
						$total_count1 = $v_count1 + $s_count1 + $h_count1;
					}elseif( $order['size_inches'] >=21 &&  $order['size_inches']<=40){
						if($order['width'] < $order['height']){ $v_count2 = $v_count2 + 1;}
						if($order['width'] == $order['height']){ $s_count2 = $s_count2 + 1;} 
						if($order['width'] > $order['height']){ $h_count2 = $h_count2 + 1;} 
						$total_count2 = $v_count2 + $s_count2 + $h_count2;
					}elseif( $order['size_inches'] >=41 &&  $order['size_inches']<=60){
						if($order['width'] < $order['height']){ $v_count3 = $v_count3 + 1;} 
						if($order['width'] == $order['height']){ $s_count3 = $s_count3 + 1;} 
						if($order['width'] > $order['height']){ $h_count3 = $h_count3 + 1;} 
						$total_count3 = $v_count3 + $s_count3 + $h_count3;
					}elseif( $order['size_inches'] >=61 &&  $order['size_inches']<=80){
						if($order['width'] < $order['height']){ $v_count4 = $v_count4 + 1;} 
						if($order['width'] == $order['height']){ $s_count4= $s_count4 + 1;} 
						if($order['width'] > $order['height']){ $h_count4 = $h_count4 + 1;}
						$total_count4 = $v_count4 + $s_count4 + $h_count4;
					}elseif( $order['size_inches'] >=81 &&  $order['size_inches']<=100){
						if($order['width'] < $order['height']){ $v_count5 = $v_count5 + 1;} 
						if($order['width'] == $order['height']){ $s_count5 = $s_count5 + 1;} 
						if($order['width'] > $order['height']){ $h_count5 = $h_count5 + 1;}
						$total_count5 = $v_count5 + $s_count5 + $h_count5;
					}elseif( $order['size_inches'] >=101){
						if($order['width'] < $order['height']){ $v_count6 = $v_count6 + 1;} 
						if($order['width'] == $order['height']){ $s_count6 = $s_count6 + 1;} 
						if($order['width'] > $order['height']){ $h_count6 = $h_count6 + 1;}
						$total_count6 = $v_count6 + $s_count6 + $h_count6;
					}
				}
			?>
			<table class="table table-bordered table-hover" >
				<thead>
					<tr>
						<th></th>
						<th>Verticle</th>
						<th>Square</th>
						<th>Horizontal</th>
						<th>Total</th>
					</tr>
				</thead>
				
				<tbody>
				    <tr>
						<td>1-10</td>
						<td><?php echo $v_count ; ?></td>
						<td><?php echo $s_count ; ?></td>
						<td><?php echo $h_count ; ?></td>
						<td><?php echo $total_count;?></td>
				    </tr>
					 <tr>
						<td>11-20</td>
						<td><?php echo $v_count1 ; ?></td>
						<td><?php echo $s_count1; ?></td>
						<td><?php echo $h_count1; ?></td>
						<td><?php echo $total_count1;?></td>
				    </tr>
					 <tr>
						<td>21-40</td>
						<td><?php echo $v_count2 ; ?></td>
						<td><?php echo $s_count2; ?></td>
						<td><?php echo $h_count2 ; ?></td>
						<td><?php echo $total_count2;?></td>
				    </tr>
					 <tr>
						<td>41-60</td>
						<td><?php echo $v_count3 ; ?></td>
						<td><?php echo $s_count3 ; ?></td>
						<td><?php echo $h_count3 ; ?></td>
						<td><?php echo $total_count3;?></td>
				    </tr>
					 <tr>
						<td>61-80</td>
						<td><?php echo $v_count4 ; ?></td>
						<td><?php echo $s_count4 ; ?></td>
						<td><?php echo $h_count4 ; ?></td>
						<td><?php echo $total_count4;?></td>
				    </tr>
					 <tr>
						<td>81-100</td>
						<td><?php echo $v_count5 ; ?></td>
						<td><?php echo $s_count5 ; ?></td>
						<td><?php echo $h_count5 ; ?></td>
						<td><?php echo $total_count5;?></td>
				    </tr>
					<tr>
						<td>101 and above</td>
						<td><?php echo $v_count6 ; ?></td>
						<td><?php echo $s_count6 ; ?></td>
						<td><?php echo $h_count6 ; ?></td>
						<td><?php echo $total_count6;?></td>
					</tr>
					<?php 
						 $t_v_count = $v_count + $v_count1 + $v_count2 + $v_count3 + $v_count4 + $v_count5 + $v_count6;
						 $t_h_count = $h_count + $h_count1 + $h_count2 + $h_count3 + $h_count4 + $h_count5 + $h_count6;
						 $t_s_count = $s_count + $s_count1 + $s_count2 + $s_count3 + $s_count4 + $s_count5 + $s_count6;
						 $t_t_count = $total_count + $total_count1 + $total_count2 + $total_count3 + $total_count4 + $total_count5 + $total_count6;
					?>
				</tbody>
				<tfoot>
				<tr> 
				<th>Total</th>
				<th><?php echo $t_v_count;?></th>
				<th><?php echo $t_s_count;?></th>
				<th><?php echo $t_h_count;?></th>
				<th><?php echo $t_t_count;?></th>
				</tr> 
				</tfoot>
			</table>
		</div>
	</div>
</div>	

<?php $this->load->view('new_admin/footer.php'); ?>

<?php $this->load->view('new_admin/datatable.php'); ?>

