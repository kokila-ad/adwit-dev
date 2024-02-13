<?php $this->load->view("new_csr/head"); ?>

<div id="Middle-Div">
	<form method="post" id="csv_form" style="padding-top:15px;" >
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">@CompNL <span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <input type="text" name="CompNL" id="CompNL" class="form-control" required />
                   </div>
               </div>
             </div>	
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">HeadLine <span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <input type="text" name="HeadLine" id="HeadLine" class="form-control" required />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">CallToAction <span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <input type="text" name="CallToAction" id="CallToAction" class="form-control" required />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">SpecialMessage <span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <input type="text" name="SpecialMessage" id="SpecialMessage" class="form-control" required />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">ContactInfo <span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <input type="text" name="ContactInfo" id="ContactInfo" class="form-control" required />
                   </div>
               </div>
             </div>
		<div class="form-group">
            <div class="row">
			<div class="col-md-12" style="text-align:center;">
				<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
			</div>
			</div>
		</div>
	</form>
</div>

<?php $this->load->view("new_csr/foot"); ?>