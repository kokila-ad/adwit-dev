<?php
       $this->load->view("admin/header");
?>
        <link href="theme001/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="theme001/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/styles.css" rel="stylesheet" media="screen">
        <link href="theme001/assets/DT_bootstrap.css" rel="stylesheet" media="screen">

<script src="theme001/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
<link rel="stylesheet" href="jq-ui/themes/base/jquery.ui.all.css" />
<script src="jq-ui/ui/jquery.ui.core.js"></script>
<script src="jq-ui/ui/jquery.ui.datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<div id="Middle-Div">
<?php echo '<h5 style="color:#900;">'.$this->session->flashdata('message').'</h5>'; ?>
		
  <div class="row-fluid" style="width:96%; margin: 0 auto;"> 
  <div style="padding-bottom: 20px;">
	<!--<div style="float: left;">
		<a href="javascript:;" onclick="window.location ='<?php echo base_url().index_page().'admin/home/add_soft_publication';?>'" style="cursor:pointer; text-decoration: none;"><button class="btn btn-primary btn-mini" >Add Publication</button></a>
	</div>-->
  </div>
    <!-- block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Ad Reps</div>
		<div style="float: right;"><input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" /></div>
	  </div>
	  
      <div class="block-content collapse in">
        <div class="span12">
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
            <tr>
				<th style="vertical-align: middle;">First Name</th>
				<th style="vertical-align: middle;">Last Name</th>
                <th style="vertical-align: middle;">Username</th>
                <th style="vertical-align: middle;">Email Id</th>
                <th style="vertical-align: middle;">Publication</th>
                
            </tr>              
            </thead>
            <tbody name="testTable" id="testTable">
      <?php foreach($adreps as $row) {
             $publicatons= $this->db->query("SELECT * FROM `publications` WHERE `id`='".$row['publication_id']."';")->result_array();	  
	  ?>
            <tr>
				<td><?php echo $row['first_name']; ?></td>
				<td><?php echo $row['last_name']; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><a href="#form_moda<?php echo $row['id']; ?>" data-toggle="modal"><?php echo $row['email_id']; ?></a></td>
				<td><?php echo $publicatons[0]['name']; ?></td>
			</tr>
      <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
 
</div>
 <?php foreach($adreps as $row) {
             
	  ?>
                              <div id="form_moda<?php echo $row['id']; ?>" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sent Mail to Adrep</h4>
										</div>
										<div class="modal-body">
										<form  method="POST" class="form-horizontal">
										<div class="form-group">
										<input type="text"  name="id" id="id" value="<?php echo $row['id']; ?>" hidden>
									    </div>
										<div class="modal-footer">
										     <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
											<button type="submit" name="sent_mail"  class="btn red">Send</button>
										</div>
										</div>
										</form>
									</div>
								</div>
							</div>
		<?php } ?>					
          <script src="theme001/vendors/jquery-1.9.1.js"></script>
        <script src="theme001/bootstrap/js/bootstrap.min.js"></script>
        <script src="theme001/vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="theme001/assets/scripts.js"></script>
        <script src="theme001/assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>
        <script>
		var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,'
					, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'
					, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
					, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		return function(table, name) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
		window.location.href = uri + base64(format(template, ctx))
		}
		})()
        </script>

                                  
<?php
       $this->load->view("admin/footer");
?>