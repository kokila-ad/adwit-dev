<?php $this->load->view("lite/head.php"); ?>
<?php $this->load->view("lite/header.php"); ?>
<style>
.input-icon {
    position: relative;
	width: 150px;
	margin: 0 auto;
}
.input-icon > i {
    display: block;
    position: absolute;
    margin: 8px 2px 4px 5px;
    z-index: 3;
    font-size: 32px;
    text-align: center;
}
.input-icon > .form-control {
    padding-left: 25px;
	padding-top: 0px;
	padding-bottom: 0;
	padding-right: 2px;
}
.border-bottom-dashed{
	border-bottom: 1px dashed #ccc;
}
.pricing-border{
	 border: 1px solid #989898;
	 border-right:0;
}
@media only screen and (max-width: 990px){
	.row .col-md-4:nth-child(2){
		border-right: 1px solid #989898!important;
	}
}
@media only screen and (max-width: 770px){
	.row .col-md-4:nth-child(1){
		border-right: 1px solid #989898!important;
	}
}
.row .col-md-4:nth-child(3){
	border-right: 1px solid #989898;
}
.text-black{
	color: #000;
}
.minheigth{
	min-height: 20px;
}
.ng-dirty.ng-invalid { border-color: red;}
.ng-dirty.ng-valid { border-color: #74ea74;}
</style>

<div id="main">

<section>
	<div class="container center margin-top-30">                        
		<p class="xlarge"><b>Buy Credits</b></p> 
	</div><!-- /.container -->
</section>
   
<section>
    <div class="container">
        <div class="padding-vertical-20">
		<?php echo $this->session->flashdata('message'); ?>			
        </div>							
    </div>
</section>


<section ng-app>
	<div class="container margin-bottom-50">
	<div class="row"> 			
		<div class="col-md-10 col-md-offset-1">
			<div class="row padding-10">
<?php $i=0; 
$price_per_credit = $price_per_credit[0]['price'];
 foreach($lite_package as $var){ $i++; ?>
	
		<div class="col-md-4 col-sm-6 col-xs-12 margin-bottom-25 padding-0 center pricing-border">		
			<h3 class="border-bottom-dashed padding-20 margin-0"><?php echo $var['name']; ?></h3>
			<p class="margin-top-15 margin-bottom-5"><strong><?php echo $var['discount']; ?>%</strong> Discount</p>
			<p class="border-bottom-dashed margin-top-15 padding-bottom-15"><strong><?php echo $var['num_days']; ?> days</strong> Validity</p>
			
			<form name="studentForm<?php echo $i; ?>" method="post" action="<?php echo base_url().index_page().'lite/home/ccavRequestHandler'; ?>" > 
				<div class="padding-10">				
					<div class="input-icon">
						<i class="fa fa-dollar"></i>
						<input type="number" name="amount" class="form-control xxxlarge text-black" placeholder="0" maxlength="4" ng-model="price<?php echo $i; ?>" min="<?php echo $var['min_price']; ?>" <?php if($var['max_price']!='0'){ ?> max="<?php echo $var['max_price']; ?>" <?php } ?> autocomplete='off' required/>
					</div>					
					<p class="margin-0">Enter value between<span class="bold"> <?php echo '$'.$var['min_price']; ?> <?php if($var['max_price']!='0'){ echo 'to $'.$var['max_price']; }else{ echo'and  above'; }?></span></p>
					
					<div class="center minheigth">
						<span class="text-red" ng-show="studentForm<?php echo $i; ?>.amount.$error.min">Minimum value is <?php echo '$'.$var['min_price']; ?></span>
						<span class="text-red" ng-show="studentForm<?php echo $i; ?>.amount.$error.max">Maximum value is <?php echo '$'.$var['max_price']; ?></span>
						<span class="text-red" ng-show="studentForm<?php echo $i; ?>.amount.$error.number">Enter only numbers</span>
					</div>	
					
	        	  <!---
					<p class="medium margin-0">Between 
					 <?php echo '$'.$var['min_price']; ?> <?php if($var['max_price']!='0'){ echo 'to $'.$var['max_price']; }else{ echo'and  above'; }?>
					 </p> 
					 <div class="row margin-top-5">
						<div class="col-xs-5 padding-0 text-right">
							<i class="fa fa-dollar"></i>
						</div>
						<div class="col-xs-7 padding-0">
							<input type="number" name="amount" class="form-control" placeholder="Enter value" 
								ng-model="price<?php echo $i; ?>" 
								min="<?php echo $var['min_price']; ?>" <?php if($var['max_price']!='0'){ ?>
								max="<?php echo $var['max_price']; ?>" <?php } ?> style="max-width:91px;font-size: 34px;padding:0;border:0;" required/>
						</div>
					 </div>
					---> 					
				 </div>
				 <p class="center">				 
					<button type="submit" name="buynow" class="btn btn-danger btn-sm">Buy Now</button>
				<br/>
					<?php if($var['discount'] == '0'){ ?>
						Credits:<span class="bold">{{( (+price<?php echo $i; ?>) / <?php echo $price_per_credit; ?> )| number:2}}</span>
						
						<input type="hidden" name="credit" value="{{( price<?php echo $i; ?> / <?php echo $price_per_credit; ?> )}}" >
					 <?php }else{ ?>
						Credits:<span class="bold">{{(( (+price<?php echo $i; ?>) + ( (+price<?php echo $i; ?> * <?php echo $var['discount']; ?>) / 100)) / <?php echo $price_per_credit;; ?>)| number:2 }}</span>
						
						<input type="hidden" name="credit" value="{{(( price<?php echo $i; ?> + (( price<?php echo $i; ?> * <?php echo $var['discount']; ?>) / 100)) / <?php echo $price_per_credit; ?>)}}" >
					 <?php } ?>					
				</p>
			</form>
		</div>			
<?php } ?>	
			</div>
		</div>
	</div>
	
	</div>
</section>

</div>
	
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>			
<?php $this->load->view("lite/footer.php"); ?>
<?php $this->load->view("lite/foot.php"); ?>
 