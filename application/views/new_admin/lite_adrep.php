<?php $this->load->view('new_admin/header')?>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row">
		 <form method="post" name="order_form" id="order_form" >
		
			<div class="col-md-6">
			 <p class="font-lg">Lite Adrep Details</p>
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>Username</th>
						<th>Email Id</th>
						<th>Credits</th>
						<th>Value</th>
						<th>Credits Balance</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($lite_adrep)){
					foreach($lite_adrep as $adrep){
						$credits = $this->db->get_where('lite_credits_added',array('uid' => $adrep['id']))->result_array();
						$uid = $adrep['id'];						$credits_details = $this->db->query("SELECT SUM(`credits_debited`), SUM(`credits_credited`) FROM `lite_mycredits_history` WHERE `uid` = '$uid'")->row_array();												if(isset($credits_details['SUM(`credits_debited`)'])){							$debit = ROUND($credits_details['SUM(`credits_debited`)'], 1);							$credit = ROUND($credits_details['SUM(`credits_credited`)'], 1);							$balance_credits = ($debit - $credit);						}
				?>
					<tr>
						<td><?php echo $adrep['id'];?></td>
						<td><?php echo $adrep['username'];?></td>
						<td><?php echo $adrep['email_id'];?></td>
						<td><?php if($credits){ echo $credits[0]['credits']; }else{ echo ''; }?></td>
						<td><?php if($credits){ echo $credits[0]['price']; }else{ echo ''; }?></td>												<td>						<?php 	if(isset($credits_details['SUM(`credits_debited`)'])){ ?>								<a href="<?php echo base_url().index_page().'new_admin/home/credits_history/'.$uid; ?>" title="Credits History">		<?php echo ROUND($balance_credits, 1); ?> </a>							<?php	}else{ echo ''; } ?>							</td>
					</tr>
				<?php } }?>
				</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
</div>
<?php $this->load->view('new_admin/footer')?>