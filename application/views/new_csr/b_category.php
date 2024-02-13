<?php $this->load->view("new_csr/head"); ?>

<div id="Middle-Div">
	<form method="post" id="csv_form" style="padding-top:15px;" >
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">HeadlineFlavour </label>
                  <div class="col-md-4">
                    <textarea type="text" name="HeadlineFlavour" id="HeadlineFlavour" class="form-control"  /></textarea>
                   </div>
               </div>
             </div>	
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">FlavourImage1 </label>
                  <div class="col-md-4">
                    <input type="text" name="FlavourImage1" id="FlavourImage1" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">FlavourImage2 </label>
                  <div class="col-md-4">
                    <input type="text" name="FlavourImage2" id="FlavourImage2" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">BodyCopy </label>
                  <div class="col-md-4">
                    <input type="text" name="BodyCopy" id="BodyCopy" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">BenefitText </label>
                  <div class="col-md-4">
                    <input type="text" name="BenefitText" id="BenefitText" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">SpecialMessageText1 </label>
                  <div class="col-md-4">
                    <input type="text" name="SpecialMessageText1" id="SpecialMessageText1" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">CallToActionText1 </label>
                  <div class="col-md-4">
                    <input type="text" name="CallToActionText1" id="CallToActionText1" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">CompanyName </label>
                  <div class="col-md-4">
                    <input type="text" name="CompanyName" id="CompanyName" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">CompanyLogo </label>
                  <div class="col-md-4">
                    <input type="text" name="CompanyLogo" id="CompanyLogo" class="form-control"  />
                   </div>
               </div>
             </div>
		<div class="form-group">
               <div class="row">
                  <label class="col-md-4 text-right">ContactInfoText </label>
                  <div class="col-md-4">
                    <input type="text" name="ContactInfoText" id="ContactInfoText" class="form-control"  />
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