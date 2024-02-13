<?php $this->load->view("new_csr/head.php"); ?>

<style>
@keyframes blink {
to { color: red; }
}

.my-element {
color: black;
animation: blink 1s steps(2, start) infinite;
}
.panel-default>.panel-heading {
  color: #333;
  background-color: #fff;
  border-color: #e4e5e7;
  padding: 0;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.panel .panel-body {
    font-size: 14px;
}
.panel-default>.panel-heading a {
  display: block;
  padding: 10px 15px;
}

.panel-default>.panel-heading a:after {
  content: "";
  position: relative;
  top: 1px;
  display: inline-block;
  font-family: 'Glyphicons Halflings';
  font-style: normal;
  font-weight: 400;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  float: right;
  transition: transform .25s linear;
  -webkit-transition: -webkit-transform .25s linear;
}

.panel-default>.panel-heading a[aria-expanded="true"] {
  background-color: #eee;
}

.panel-default>.panel-heading a[aria-expanded="true"]:after {
  content: "\2212";
  -webkit-transform: rotate(180deg);
  transform: rotate(180deg);
}

.panel-default>.panel-heading a[aria-expanded="false"]:after {
  content: "\002b";
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
}
.skyblue{
color: rgb(74,134,232);
}
@media (min-width: 1024px){
.core{
position:relative;
bottom:38px;
}
}
</style>


<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
		    <div class="caption static-info no-space margin-top-10">
					<div class="value bold">
						<span style="margin-left: 20px; padding: 0 10px;" class="font-blue">
							<?php echo $this->session->flashdata('message'); ?>
						</span>
					</div>
				</div>
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb hide">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Dashboard
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			
						<!-- BEGIN PAGE CONTENT INNER -->
			<div class="tiles">
			<!--<a href="<?php echo base_url().index_page()."new_csr/home/notifications";?>">
				<div class="tile double-down bg-blue-hoki">
					<div class="tile-body">
						<i class="fa fa-bell-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Notifications
						</div>
						<div class="number">
							 0
						</div>
					</div>
				</div>
			</a>-->	
			
				
				<a href="<?php echo base_url().index_page()."new_csr/home/reports";?>">
				<div class="tile bg-green">
					<div class="tile-body">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Reports
						</div>
						<div class="number">
						</div>
					</div>
				</div>
				</a>
				<a href="<?php echo base_url().index_page()."new_csr/home/my_account";?>">
				<div class="tile bg-yellow-lemon selected">
					<div class="corner">
					</div>
					<div class="check">
					</div>
					<div class="tile-body">
						<i class="fa fa-cogs"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							Settings
						</div>
					</div>
	
				</div>
				</a>
<!-- Revision Review Tab -->				
            <div class="col-md-2 border no-space">
					<h4 class="text-center"> Revision Review</h4>
					<div style="min-height: 84px;">
						<ol>
						    <?php 
						        if(isset($cat_result)){ 
						            foreach($cat_result as $cat_row){
						                $review = $this->db->query("SELECT * FROM `order_revision_review_csr` WHERE `order_id` = '".$cat_row['order_no']."' AND `version` = 'V1a'")->row_array();
						                if(!isset($review['id'])) { 
						    ?>
						        <li><a href="<?php echo base_url().index_page().'new_csr/home/orderview_history/'.$cat_row['help_desk'].'/'.$cat_row['order_no']; ?>" ><?php echo $cat_row['order_no'].'</br>';?></a></li>
						    <?php } } } ?>
						     
							<?php 
    							if(isset($csr_rev_list)) {  
    							    foreach($csr_rev_list as $rev_row){ 
    							        $review = $this->db->query("SELECT * FROM `order_revision_review_csr` WHERE `order_id` = '".$rev_row['order_id']."' AND `version` = '".$rev_row['version']."'")->row_array();
    								    if(!isset($review['id'])) {  
							?>
								<li><a href="<?php echo base_url().index_page().'new_csr/home/orderview_history/'.$rev_row['help_desk'].'/'.$rev_row['order_id']; ?>" ><?php echo $rev_row['order_id'].'</br>';?></a></li>
							<?php 
    						    	    } 
							       } 
							    } 
							?> 
						</ol>
					</div>
				</div>
				
 <!-- new collapse -->
			<div class="col-md-7 core">
<h4 class=""> <b>Our Core Values</b> </h4>
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          <b>Accurate</b>
        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
          <p>Now, for us Accurate can be like <u>“Lakshmana Rekha”</u>... explain and connect how our customers can get amplified</p>

</br>
<p>In our business, what we do has to be Accurate otherwise we will get burnt.
</br>
means, we lose the customer</p>


<p class="skyblue"><b>Show some live examples:</b> 
</br>
And explain how, overlooking the small details, can cost you, BIG.</p>

</br>
<p>Guidelines to be Accurate:</br>Examples:</p>
<ol>
<li>
<p>Especially in our ad building work...</p></li>

<li><p><b>Size</b> - even .02 inches bigger size may not fit into digital page layout </p></li>
<ol type="I">
<li><p><b>Design mandatories</b> - very important to maintain, to get a good response from reader </p></li>

<li><p><b>Technical mandatories</b> - readers can miss out the important information because of bad printing quality.</p></li>

<li><p><b>Spelling mistake</b> - just 1 Number or 1 alphabet can cost us, and the publication, a huge loss</p></li>

<li><p><b>Fact</b> - is a fact and it has to be accurate </p></li>
</ol type="I">
<li><p><b>Empirical evidence</b> - to make important decisions. Without empirical evidence, we cannot take the right decision.</p></li>

<li><p><b>Internal or external communication</b> - Using appropriate language in appropriate time brings comfort.</p></li>

<li><p><b>Documentation</b> - our experiences of working through specific activities, needs to be documented ACCURATELY, so that we can use it for future references.</p>
</li>
 </ol> 
</br>
<p><b>Being <u>Accurate</u> builds a habit of striving for perfection. And perfection is what we need, to deliver the best. </b></p>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <b>Timely</b>
        </a>
      </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
              <p>We do have contracts with our global customers like Overnight Delivery, Two hours turnarounds and rush ads. So, <u>Timely Delivery</u> is crucial to our business.</p>

</br>


<p class="skyblue"><b>Give couple of examples and explain: </b> </p>
</br>
<p class="skyblue">Example 1: the effect of “missing the customer’s deadlines”.</p>
<p class="skyblue">Example 2: the effect of “people coming late to the office”.</p>
</br>
<p>Focusing completely on what we do is an <u>effective</u> way to manage our time. </p>

<p>It enables us to spend our time on the <u>most important</u> task at hand. </p>

<p>Therefore, we need to teach ourselves how to be more punctual.</p>
</br>
<p>Practicing punctuality is an essential habit because:</p>
<ol>
<li><p>We are able to deliver our work on time.</p></li>

<li><p>We can produce <u>more</u> in less time, and thus become <u>more efficient.</u> </p></li>

<li><p>We can manage <u>rush hours</u> and <u>hectic projects</u> and still, deliver on time.</p></li>

<li><p>We can balance our work-life, well.</p></li>

<li><p>We can go home early.</p></li>
</ol>
</br>
<p>How do we manage our time, effectively:  </p>
<ul>
<li>
<p>List things-to-do daily</p></li>

<li><p>Have a Meeting Rhythm</p></li>

<li><p>For every task : we need to Plan, Schedule and use Alerts</p></li>

<li><p>ROTI (Return on Time Investment) : instead of investing your time on fruitless tasks, like using WhatsApp for hours, you could instead, invest your time in sharpening your brain, by doing crosswords, puzzles, and so on and so forth...</p>
</li>
</ul>
</br>
<p>Developing the habit of delivering our work on time is very crucial, because we provide ad building services to the media houses and thus, we need to be time sensitive. Punctuality needs to be wired in our brain.</p>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         <b>Think Through</b>
        </a>
      </h4>
      </div>
      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
          <p>Process of thinking through will enhance the <u>effectiveness</u> of our tasks and actions. And it also comes very handy to take any decisions and solve any problems <u>effectively</u> in our personal and professional life.</p>

</br>
<p>How to Think Through?</p>
<ul>
<li>
<p>We must clearly define what the problem is and what we want. </p></li>

<li><p>breakdown the problem if necessary,</p></li>

<li><p>write a pros and cons list, </p></li>

<li><p>analyse and make a decision by giving yourself time to answer. </p>
</li>
</ul>
</br>
<p class="skyblue">You can adapt the “<b>Lateral Thinking</b>” process for any problem solving easily. </p>

<p class="skyblue">Examples: </p>


<p>Think Through Process for a New Project or a task:</p>


<ol>
<li>
<p>First, identify the project or a task which gives most result (20/80 Rule)</p></li>

<li><p>Decide what is your project goal</p></li>

<li><p>Collect information or data and study</p></li>

<li><p>Weigh pros and cons</p></li>

<li><p>Think of consequences (from pros and cons)</p>
</li>
<li><p>List activities within</p></li>
<li><p>Plan and prioritise</p></li>
<li><p>Think of people and their time involved</p></li>
<li><p>Prepare a blueprint</p></li>
<li><p>List the action items and</p></li>
<li><p>Action the activity which gives the best result</p></li>

</ol> 
</br>
<p>Think Through Process for regular Ad building/Revision</p>


<ol>
<li>
<p>Determine if order has been understood</p></li>

<li><p>Ask questions if there is doubt</p></li>

<li><p>Plan before to deliver on time.</p></li>

<li><p>Design Process:</p></li>
<ol type="a">
<li><p>Go through the order</p>
</li>
<li><p>Set up document (mandatories)</p></li>
<li><p>Place Assets</p></li>
<li><p>Follow ROA process</p></li>
<li><p>Follow Design principles</p></li>
<li><p>Follow Preflight process</p></li>
</ol type="a">
<li><p>Quality Check (Proofreading)</p></li>
<li><p>Notes or instructions for customer</p></li>
<li><p>Submit to customer </p></li>
</ol> 
</br>
<p>So, think through every detail. Think through every small task, every big project. Think through every possible perspective, through every layer. 
</br>
And then only, we will be able to make the right decision and solve any problem <u>effectively.</u></p>
        </div>
      </div>
    </div>
	
	<div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingFour">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
         <b>Low Cost</b>
        </a>
      </h4>
      </div>
      <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
        <div class="panel-body">
          <p>The purpose of Low Cost is to <b>Sustain</b> and attract <b>New Customers</b></p>

</br>
<p>Accuracy, Timely and Think Through leads to Low Cost.
</br>
With accurate information, collected well within time and thought through tasks, we will get an effective and efficient result from low cost</p>
</br>
<p>So, Effectiveness and Efficiency are the key to Low Cost</p>
</br>
<p>Effectiveness is about doing things correctly, while efficiency is about doing things faster. The correlation between effectiveness and efficiency is further illustrated by this chart:</p>

<img alt="use of resources" src="https://adwitads.com/weborders/assets/new_designer/img/adwitads_designer.jpg" width="600" height="600">

<p>As you can see, there are different levels of Effectiveness and Efficiency which is portrayed through 4 boxes. </p>

<ol>
<li>
<p>II-1 shows Unhappy Customer and High Costs</p></li>


<li><p>IE-2 shows Unhappy Customer but Low Costs</p></li>

<li><p>EI-3 shows Happy Customer but High Costs</p></li>

<li><p>Whereas, EE-4 shows both Happy Customer and Low costs!!!</p>
</li>
 </ol> 
</br>
<p>Basically, when we see the EE-4 result, it will direct us to a <u>lesser cost</u> and will get <u>effective results</u>. 
</p>
</br>
<p>So, what do we have to do to get that result?</p>
</br>

<p>For an effective result we need to execute 3 simple tasks:</p>
<ol>
<li>
<p>Need to build <u>Error-free</u> ads: Customers will get confidence on our work</p></li>


<li><p>Need to Follow customer <u>Instructions:</u> Customer will not be annoyed</p></li>

<li><p>Need to build <u>ROA quality</u> ads: Customer will get more responses and will be more thrilled</p></li>


 </ol> 
 </br>
 <p>For an efficient ad building:</p>
 
 <ol>
<li>
<p>The <u>Right person:</u> Specific task needs to be assigned with the specific skilled person, for the right cost</p></li>


<li><p><u>V1 Sold:</u> Perfect ad means, NO Revisions, thus less cost</p></li>

<li><p>Adherence to <u>ad building process:</u> Sticking to process - ad will be produced at the right time, thus right cost</p></li>

<li><p><u>Organising needs:</u> Leads to quicker, hassle-free ad production, hence less cost</p>
</li>
<li><p>Mastering the <u>design tools:</u> when we know which tool to use when, we tend to build ads faster, leads to less cost
</p></li> </ol> 

 
 </br>
 
<p class="skyblue">Need to explain the seriousness of effectiveness and efficiency </p>
</br>
<p>Now, let us also look at ways to be Low Cost in our General, Overall Expenditure.</p>
</br>
<p class="skyblue">Need to explain how to be cautious in our office surroundings.</p>


</br>

<p>All wastage/leakage has to be plugged/stopped.</p>
<ol>
<li>
<p>Bandwidth wastage</p></li>

<li><p>Electricity</p></li>

<li><p>Water</p></li>

<li><p>Identify extra people, and make sure they do productive work.</p></li>


 </ol> 
</br>
<p>In short, our core value <u>Low Cost</u> will direct us to: </p>
<ol>
<li>
<p>Sustain and Attract new Customers</p></li>

<li><p>Ensure Happy Customer and with Lesser on Cost</p></li>

<li><p>Plug our expenditure from Wastage and Leakages</p></li>



 </ol> 
        </div>
      </div>
    </div>
	
	<div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingFive">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
         <b>Customer Centric</b>
        </a>
      </h4>
      </div>
      <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
        <div class="panel-body">
          <p>We need to change our mindset to <b>“Everyone is Our Customer”.</b></p>

</br>
<p>We need to begin by treating our colleagues as our internal customers.

In our work culture, if we start treating internal customers as actual customers and develop a habit of understanding, relating and getting more insight on what our actual customers expect from us, we can <u>more effectively</u> satisfy our actual customers. </p>
</br>
<p>When we build this culture around us, that’s when we become customer centric.</p>

</br>
<p>Analogy: When a person EXPECTS something, he becomes a customer and who DELIVERS the expectation, he will become a customer service.</p>
</br>
<p class="skyblue">Need to explain analogy of “Becoming a Customer” and “Customer Service” (it is very important task) </p>

</br>

<p>Important guidelines to become customer-centric:</p>
</br>

<ol>
<li>
<p>Actual work</p></li>

<ol type="a">

<li><p>We have to pay close attention to customer’s reaction to our work</p></li>

<li><p>Continuous improvement is a good way to become customer centric</p></li>

<li><p>Make sure customer has sent all assets and ask questions immediately, if not received</p></li>
</ol type="a">
<li><p>Every customer’s contact has to be responded, or at least acknowledged immediately.</p></li>

<li><p>Be explicit. Don’t assume people will understand you. Especially when you give instructions to your colleagues. Avoid assumptions.</p></li>

<li><p>Pass on messages to relevant people only.</p>
</li>
<li><p>When a customer is in a difficult situation (even if it is the customer's fault), go all out to help, it will be remembered.
 </p>
</li>
<li><p>Under-promise and overdeliver. (think and plan before commitment)
</p>
</li>
<li><p>Customer acquisition cost is very high therefore customer retention is very important. And that is possible through customer centric servicing.

<li><p>Think whether the customer will like it before hitting the send button. 
 </p>
</li></ol> 

      </div>
      </div>
    </div>
	

	

</div>
</div>
<!-- end new collapse -->	

 
			</div>
			<!-- END PAGE CONTENT INNER -->
			
                			
			
<?php if(isset($r_review[0]['id'])){ ?>	
	
		<div class="portlet light">
			<div class="portlet-title">
    			<div  class="col-xs-12 text-center"> </div>
    	        <div class="my-element text-center"><b> Customers' Feedback </b></div>
    			<div class="portlet-body">
    			 <table class="table table-striped table-bordered table-hover" >
    				<thead>
    					<tr>
    						<th>AdwitAds ID</th>
    						<th>Reason</th>
    						<th>Comment</th>
    					<!--	<th>Error (Y/N)</th>-->
    						<th></th>
    				   </tr>  
    				</thead>
    				<tbody>
    				<?php 
    				foreach($r_review as $row){ 
    					$verify_type = $this->db->query("SELECT `name` FROM `verification_type` WHERE `id` IN (".$row['verification_type'].")")->result_array();
    					
    				?>
    				<tr>
    				
    					<td><a target = "blank" href="<?php echo base_url().index_page().'new_csr/home/order_review_history/'.$row['order_id'];?>"><?php echo $row['order_id'];?></a></td>
    					<td><?php foreach($verify_type as $type){  echo $type['name'].'</br>';  } ?></td>
    					<td><?php echo $row['comment']; ?></td>
    				
    					<td><a href="<?php echo base_url().index_page()."new_csr/home/comment/".$row['id'];?>">Reply here</a>
    					</td>
    				 
    				</tr>
    				<?php } ?>
    				</tbody>
    			
    			</table>
    			</div>
			</div>
		</div>
<?php } ?>

 

		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<?php $this->load->view("new_csr/foot.php"); ?>