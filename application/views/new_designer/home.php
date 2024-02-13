<?php $this->load->view("new_designer/head"); ?>
<!---- Date Picker Display CSS ----------------->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css'>	
	<link href="<?php echo base_url();?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	
<!---- Date Picker Display END----------------->	
<style>
	.bg-search {
    color: #ccc !important;
    background-color: #38414c;
    border-right: 1px solid #444d58;
}
</style>

<style>
@keyframes blink {
to { color: red; }
}

.my-element {
color: black;
animation: blink 1s steps(2, start) infinite;
}
</style>

<style>

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
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row no-space">
			<?php if($designer_alias['designer_role'] != '2'){  ?>	
				<div class="col-md-3 no-space">
					<div class="tiles">
						<a href="<?php echo base_url().index_page()."new_designer/home/reports";?>">
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
						<a href="<?php echo base_url().index_page()."new_designer/home/my_account";?>">
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
					</div>	
				</div>
			<?php } ?>
                
                <!-- new collapse -->
                <?php if($designer_alias['designer_role'] != 2){ ?>
                <div class="col-md-7 core pull-right">
                <h4> <b>Our Core Values</b> </h4>
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
                
                <img alt="use of resources" src="<?php echo base_url().'assets/new_designer/img/adwitads_designer.jpg';?>" width="600" height="600">
                
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
                <?php } ?>
                <!-- end new collapse -->
            </div>
            
        <!-- TeamLead Ad Volume Dashboard START --> 
        <?php if($designer_alias['designer_role'] == '2'){  ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="portlet light border padding-top-0">
                            <div class="portlet light">
    							<div class="portlet-title">
    							    <div class="col-md-12">
        								<div class="caption">
        									<span class="font-md font-grey-gallery bold">Designers Ads Count - In production </span>
        								</div>
    								</div>
    							</div>
    						</div> 
    						<div class="table-responsive border padding-15">     
            					<table class="table table-striped table-bordered " id="user_data">
            						<thead>
            							<tr>
            								<td><b>Designer Name</b></td>
            								<td><b>In production Count</b></td>
            						   </tr>  									
            						</thead>
            						<!--<tbody id="load_content">	
            							
            					   </tbody> -->        
            					</table>
            				</div>
    					</div>    
                    </div>
                    <!-- Completed Ads Count -->
                    <div class="col-sm-6">
                        <div class="portlet light border padding-top-0">
                            <div class="portlet light">
    							<div class="portlet-title">
    							    <div class="col-md-12">
        								<div class="caption">
        									<span class="font-md font-grey-gallery bold">Designers Ads Count - Completed </span>
        								</div>
    								</div>
    							</div>
    						</div> 
    						<div class="table-responsive border padding-15">     
            					<table class="table table-striped table-bordered " id="user_data_completed">
            						<thead>
            							<tr>
            								<td><b>Designer Name</b></td>
            								<td><b>Count</b></td>
            						   </tr>  									
            						</thead>
            						<!--<tbody id="load_content">	
            							
            					   </tbody> -->        
            					</table>
            				</div>
    					</div>    
                    </div> 
                </div>
        <?php  } ?>
        
        <?php if($designer_alias['designer_role'] == 2){ ?>
            <div class="row">
    				<div class="col-sm-6">
    					<div class="portlet light border padding-top-0">
    						<div class="portlet light">
    							<div class="portlet-title">
    							<div class="col-md-6">
    								<div class="caption">
    									<span class="font-md font-grey-gallery bold">Today's Ads</span> <span class="font-md font-green loading">  Loading...</span>
    								</div>
    								</div>
    							</div>
    						</div>
    						
    						<div class="row col-md-offset-2 list-separated">
    							<div class="col-md-4 col-sm-4 col-xs-8">
    								<div class="uppercase font-hg font-black-flamingo" id="todays_total_ads"></div>
    								<div class="font-grey-mint font-sm">Total Ads</div>
    							</div>
    							<div class="col-md-4 col-sm-3 col-xs-6">
    								<div class="uppercase font-hg  font-blue" id="todays_pending_ads"></div>
    								<div class="font-grey-mint font-sm">Pending</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-8">
    								<div class="uppercase font-hg font-green" id="todays_sent_ads"></div>
    								<div class="font-grey-mint font-sm">sent</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-8">
    								<div class="uppercase font-hg font-green" id="question_ads"></div>
    								<div class="font-grey-mint font-sm">Question</div>
    							</div>
    						</div>
    						
    						</br>
    					<!-- Yesterdays Ad Counts -->
    					
        					<div id="yesterday_ads">
        						<div class="portlet light">
    								<div class="portlet-title">
    								<div class="col-md-6">
    									<div class="caption">
    										<span class="font-md font-grey-gallery bold">Yesterday's Status - Ads Count</span><span class="font-md font-green loading">  Loading...</span>
    									</div>
    									</div>
    								</div>
    							</div>
    					        <div class="row col-md-offset-1 list-separated" id="yst_status_wise_count_div"></div>
    						</br>
    					</div>
    			    </div>
				</div>	
    			<div class="col-sm-6">
    				<div class="portlet light border padding-top-0">
    							<div class="portlet light">
    								<div class="portlet-title">
    								<div class="col-md-12">
    									<div class="caption">
    										<span class="font-md font-grey-gallery bold">Category - Pending Ads Count</span><span class="font-md font-green loading">  Loading...</span>
    									</div>
    									</div>
    								</div>
    							</div>
    					    <div class="row col-md-offset-2 list-separated" id="category_wise_count_div">
        					
    					    </div>
    				    
    				    <!--Status wise Ads Count -->
    				    
    							<div class="portlet light">
    								<div class="portlet-title">
    								<div class="col-md-12">
    									<div class="caption">
    										<span class="font-md font-grey-gallery bold">Status - Ads Count</span><span class="font-md font-green loading">  Loading...</span>
    									</div>
    									</div>
    								</div>
    							</div>
    					    <div class="row col-md-offset-1 list-separated" id="status_wise_count_div">
    					        
    					    </div>
    				    </div>
    			</div>
			 
		    </div>
        <?php } ?>
        
        <!-- Assigned v/s Produced START -->
        <?php if($designer_alias['designer_role'] == 2){ ?>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light border">
                    <div class="portlet-title caption"> 
                        Assigned Vs produced
                    </div>
                    <div class="portlet-body">
                        <div class="pull-right">
						    <p  class="margin-bottom-5">Select date range</p>
							<input class="form-control form-control-solid " placeholder="Pick date rage" id="kt_daterangepicker_4"/>
						</div>
                        <table class="table table-striped table-bordered table-hover" id="assigned_vs_produced">
                            <thead>
                                <tr>
                                    <td></td> 
                                    <td>M</td>
                                    <td>N</td>
                                    <td>P</td>
                                    <td>T</td>
                                    <td>W</td>
                               </tr>
                            </thead>
                             
                            </table>        
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
      <!-- Assigned v/s Produced END--> 
         
        <!-- customer feedback -->
        <?php if(isset($r_review[0]['id'])){ ?>
            <div class="row margin-top-10">
                <div class="col-md-12">
                	<div class="portlet light">
                			<div class="portlet-title">
                    			<div  class="col-xs-12 text-center"></div>	
                    
                    	        <!--<div class="my-element text-center"><b> Customers' Feedback </b></div>-->
                    	        <a class="collapsed my-element" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFeedback" aria-expanded="false" aria-controls="collapseOne">
                          <b>Customers' Feedback <i class="fa fa-angle-down pull-right"></i></b>
                        </a>
                            <div id="collapseFeedback" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                    			<div class="portlet-body">
                    			 <table class="table table-striped table-bordered table-hover" >
                    				<thead>
                    					<tr>
                    						<th>AdwitAds ID</th>
                    						<th>Reason</th>
                    						<th>Comment</th>
                    						<!--<th>Error(Y/N)</th> -->
                    						<th></th>
                    				   </tr>  
                    				</thead>
                    				<tbody>
                    				<?php 
                    				foreach($r_review as $row){ 
                    					$verify_type = $this->db->query("SELECT `name` FROM `verification_type` WHERE `id` IN (".$row['verification_type'].")")->result_array();
                    				?>
                    				<tr>
                    				<?php if($designer_alias['designer_role'] == '2' || $designer_alias['designer_role'] == '3' || $designer_alias['designer_role'] == '4' ){ ?>
                    					<td><a target = "blank" href="<?php echo base_url().index_page().'new_designer/home/order_review_history/'.$row['order_id'];?>"><?php echo $row['order_id'];?></a></td>
                    					<td><?php foreach($verify_type as $type){  echo $type['name'].'</br>';  } ?></td>
                    					<td><?php echo $row['comment']; ?></td>
                    				
                    					<td><a href="<?php echo base_url().index_page()."new_designer/home/comment/".$row['id'];?>">Reply here</a>
                    					</td>
                    					<?php }?>
                    				</tr>
                    				<?php } ?>
                    				</tbody>
                    			</table>
                    			</div>
                    		</div>	
                			</div>
                		</div>
                </div>
            </div>
        <?php } ?>
        
        <!-- Revision Review -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title"> 
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseReview" aria-expanded="false" aria-controls="collapseOne">
                                <b>Revision Review <i class="fa fa-angle-down pull-right"></i></b>
                            </a>
                        </div>
                        <div id="collapseReview" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                    	    <div class="portlet-body">
                    	        <table class="table table-striped table-bordered table-hover" >
                    				<thead>
                    					<tr>
                    						<th>AdwitAds ID</th>
                    						
                    				   </tr>  
                    				</thead>
                    				<tbody>
                    				    
                    				    <?php 
                                          if(isset($cat_result)) {  
                                            foreach($cat_result as $row){ 
                            					$review = $this->db->query("SELECT * FROM `order_revision_review` WHERE `order_id` = '".$row['order_no']."' AND `version` = 'V1a'")->row_array();
                            					if(!isset($review['id'])) {  
                                          ?>
                                        <tr>
                            				<td><a href="<?php echo base_url().index_page().'new_designer/home/orderview_history/'.$row['help_desk'].'/'.$row['order_no']; ?>" ><?php echo $row['order_no'].'</br>';?></a></td>
                                        </tr>
                            			<?php } } } ?> 
                            			
                            			<?php 
                            				if(isset($designer_rev_list)) {  
                            					foreach($designer_rev_list as $rev_row){ 
                            						$review = $this->db->query("SELECT * FROM `order_revision_review` WHERE `order_id` = '".$rev_row['order_id']."' AND `version` = '".$rev_row['version']."'")->row_array();
                            						if(!isset($review['id'])) {  
                        				?>
                        				<tr>
                        					<td><a href="<?php echo base_url().index_page().'new_designer/home/orderview_history/'.$rev_row['help_desk'].'/'.$rev_row['order_id']; ?>" ><?php echo $rev_row['order_id'].'</br>';?></a></td>
                        			    </tr>
                        			<?php } } } ?> 
                    				</tbody>
                    			</table>
                    		</div>
                    	</div>
                    </div>
                </div>    
            </div>
            <!--
            <div class="row">
                <div class="col-md-2 border no-space">
					<h4 class="text-center"> Revision Review</h4>
					<div style="min-height: 84px;">
						<ol>
                              <?php 
                              if(isset($cat_result)) {  
                                foreach($cat_result as $row){ 
                					$review = $this->db->query("SELECT * FROM `order_revision_review` WHERE `order_id` = '".$row['order_no']."' AND `version` = 'V1a'")->row_array();
                					if(!isset($review['id'])) {  
                              ?>
                					   <li><a href="<?php echo base_url().index_page().'new_designer/home/orderview_history/'.$row['help_desk'].'/'.$row['order_no']; ?>" ><?php echo $row['order_no'].'</br>';?></a></li>
                
                			<?php } } } ?> 
                
                              <?php 
                    				if(isset($designer_rev_list)) {  
                    					foreach($designer_rev_list as $rev_row){ 
                    						$review = $this->db->query("SELECT * FROM `order_revision_review` WHERE `order_id` = '".$rev_row['order_id']."' AND `version` = '".$rev_row['version']."'")->row_array();
                    						if(!isset($review['id'])) {  
                				?>
                					            <li><a href="<?php echo base_url().index_page().'new_designer/home/orderview_history/'.$rev_row['help_desk'].'/'.$rev_row['order_id']; ?>" ><?php echo $rev_row['order_id'].'</br>';?></a></li>
                			<?php } } } ?>         
              
						</ol>
					</div>
				</div>
            </div>
        -->
        </div>
    </div>
<?php if($designer_alias['designer_role'] == 2){ //mobile response view not working if below script called ?> 
<!---- Date Picker Display Script -->
    <script src="<?php echo base_url();?>assets/js/plugins.bundle.js"></script>
	<script src="<?php echo base_url();?>assets/js/datatables.bundle.js"></script>
<!-- Date Picker Display Script END ----------------->
<?php } ?>
<?php
       $this->load->view("new_designer/foot"); 
?>

<script>
    $(document).ready(function(){ 
        var fromDate = '<?php echo $from_date_range; ?>';
        var toDate = '<?php echo $to_date_range; ?>';
    //load table data
      var dataTable = $('#user_data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_designer/home/teamlead_dashboard_designer_adcount'; ?>",  
                type:"POST",
                data:{"fromDate":fromDate, "toDate":toDate, "action":'inproduction'}
           },  
           "columnDefs":[  
                {  
                     "targets":[0, 1],  
                     "orderable":false,  
                },  
           ],  
      }); 
    //completed  
      var dataTable = $('#user_data_completed').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url().index_page().'new_designer/home/teamlead_dashboard_designer_adcount'; ?>",  
                type:"POST",
                data:{"fromDate":fromDate, "toDate":toDate, "action":'completed'}
           },  
           "columnDefs":[  
                {  
                     "targets":[0, 1],  
                     "orderable":false,  
                },  
           ],  
      }); 
      
    setInterval( function () {
        dataTable.ajax.reload();
    }, 120000 );   //for every 2 mins
    
    //todays order count
    $.get("<?php echo base_url().index_page().'new_designer/home/get_dashboard_ad_count';?>", function(data){
        var myObj = JSON.parse(data);
        //console.log(myObj.todays_total_ads_count+'-'+myObj.todays_pending_ads_count+'-'+myObj.todays_sent_ads+'-'+myObj.question_ads_count);
        $('#todays_total_ads').html(myObj.todays_total_ads_count);
        $('#todays_pending_ads').html(myObj.todays_pending_ads_count);
        $('#todays_sent_ads').html(myObj.todays_sent_ads_count);
        $('#question_ads').html(myObj.question_ads_count);
        
        $('#yesterdays_total_ads').html(myObj.yesterdays_total_ads_count);
        $('#yesterdays_pending_ads').html(myObj.yesterdays_pending_ads_count);
        $('#yesterdays_sent_ads').html(myObj.yesterdays_sent_ads_count);
        
        //console.log(myObj.category_wise_count_div);
        $('#category_wise_count_div').html(myObj.category_wise_count_div);
        
        $('#yst_status_wise_count_div').html(myObj.yst_status_wise_count_div);
        
        $('#status_wise_count_div').html(myObj.status_wise_count_div);
        $('.loading').hide();
    });
    
    //Assigned Vs produced
        // pre defined date range//
        var start = moment().subtract(1, 'days');
        var end = moment();
        
        $('#kt_daterangepicker_4').daterangepicker({
           buttonClasses: ' btn',
           applyClass: 'btn-primary',
           cancelClass: 'btn-secondary',
        
           startDate: start,
           endDate: end,
           ranges: {
              'Today': [moment(), moment()],
              //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 14 Days': [moment().subtract(13, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'Last 60 Days': [moment().subtract(59, 'days'), moment()],
              'Last 90 Days': [moment().subtract(89, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
        }, function(start, end, label) {
           $('#kt_daterangepicker_4 .form-control').val( start.format('DD MMMM, YYYY') + ' / ' + end.format('DD MMMM, YYYY'));
           
           //$("#dashboard_v3").html("Loading Productivity by Designer...");
           
            //var dateRange = start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD');
            //console.log('dateRange : '+dateRange);
            
            //Load table content and ads count
            //var status = $('input[name="status"]:checked').val();   //get status(radio button checked)
            var from_date = start.format('MM/DD/YYYY');
            var to_date = end.format('MM/DD/YYYY');
            
            //called when there is change in daterange
            assigned_vs_produced(from_date, to_date); //load table content
            //adsCount(from_date, to_date); //load/refresh ads count
        });
        
        //When initial document load get time range from datepicker
            var dval = $('#kt_daterangepicker_4').val();
            var array = dval.split(' - ');
            var from_date = array[0];
            var to_date = array[1];
            
            assigned_vs_produced(from_date, to_date); //load table content
            //adsCount(from_date, to_date); //load/refresh ads count
    
    
});
//Assigned Vs produced
function assigned_vs_produced(from_date, to_date){ //alert(status);
       //console.log('from_date : '+from_date+' to_date : '+to_date);
        //load data table
        var dataTable = $('#assigned_vs_produced').DataTable({
            "destroy": true, //reinitialise the table content
            "processing": true,
            "serverSide": true,
            "searching": false, 
            "paging": false, 
            "info": false,
            "order": [],  
            "ajax": {  
                url:"<?php echo base_url().index_page().'new_designer/home/assigned_vs_produced'; ?>",  
                type:"GET",
                data: {'from_date':from_date, 'to_date':to_date}
            }
        });     
    }

</script>

