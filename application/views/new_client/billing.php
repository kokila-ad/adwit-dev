<?php $this->load->view('new_client/header'); ?>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};
</script>
<div id="main">
<section>
   <div class="container margin-top-50">
      <div class="row">
	
		<div class="col-md-12 margin-top-20">
			<div class="table-responsive border padding-15">     
				<table class="table table-striped table-bordered table-hover" id="example1">
					<thead>
						<tr>
                                                        <td class="width-90">Date</td>
							<td class="width-90">Invoice Number</td>
							<td class="width-120">Price</td>
							<td class="width-120">Status</td>
							<td class="width-120">Action</td>
							
						 </tr>  									
					</thead>
					<tbody>
                       <tr>
							<td>10 Dec, 2016</td>
							<td>AG/DC/122016/1</td>
							<td>$235</td>
							<td>Pending</td>
							<td>
								<form method="post" name="customerData" action="<?php echo base_url().index_page().'new_client/home/ccavRequestHandler'; ?>">
									<input type="hidden" name="tid" id="tid" readonly />
									<input name="amount" type="hidden" value="235" >
									<button type="submit">PAY NOW</button>
								</form>
                            </td>
						</tr>
						<tr>
							<td>12 Dec, 2016</td>
							<td>AG/DC/122016/12</td>
							<td>$130</td>
							<td>Pending</td>
							<td>
								<form method="post" name="customerData" action="<?php echo base_url().index_page().'new_client/home/ccavRequestHandler'; ?>">
									<input type="hidden" name="tid" id="tid" readonly />
									<input name="amount" type="hidden" value="130" >
									<button type="submit">PAY NOW</button>
								</form>
                            </td>
						</tr>
						<tr>
							<td>15 Dec, 2016</td>
							<td>AG/DC/122016/15</td>
							<td>$335</td>
							<td>Pending</td>
							<td>
								<form method="post" name="customerData" action="<?php echo base_url().index_page().'new_client/home/ccavRequestHandler'; ?>">
									<input type="hidden" name="tid" id="tid" readonly />
									<input name="amount" type="hidden" value="335" >
									<button type="submit">PAY NOW</button>
								</form>
                            </td>
						</tr>
						<tr>
							<td>18 Dec, 2016</td>
							<td>AG/DC/122016/18</td>
							<td>$115</td>
							<td>Pending</td>
							<td>
								<form method="post" name="customerData" action="<?php echo base_url().index_page().'new_client/home/ccavRequestHandler'; ?>">
									<input type="hidden" name="tid" id="tid" readonly />
									<input name="amount" type="hidden" value="115" >
									<button type="submit">PAY NOW</button>
								</form>
                            </td>
						</tr>
						<tr>
							<td>20 Dec, 2016</td>
							<td>AG/DC/122016/2</td>
							<td>$215</td>
							<td>Pending</td>
							<td>
								<form method="post" name="customerData" action="<?php echo base_url().index_page().'new_client/home/ccavRequestHandler'; ?>">
									<input type="hidden" name="tid" id="tid" readonly />
									<input name="amount" type="hidden" value="215" >
									<button type="submit">PAY NOW</button>
								</form>
                            </td>
						</tr>
					</tbody>
					
				
				
				</table>
			 </div>
		 </div>
	 </div>
  </div>
</section>
</div>

<?php if($this->session->userdata('ncId')=='36'){ $this->load->view('new_client/privacy_footer'); }else{ $this->load->view('new_client/footer'); } ?>