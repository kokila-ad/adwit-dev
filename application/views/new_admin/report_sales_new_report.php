<?php $this->load->view('new_admin/header.php'); ?>

<script>
$(document).ready(function(){	    
	$(".dropdown-checkboxes").hide();	
	$('.date-picker').click(function() {
		$(".cursor-pointer").addClass(" filter ");
	});	
	$('#filter').click(function() {
		$(".dropdown-checkboxes").toggle();
	});
});
</script>
<!--<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>-->


<div class="portlet light">
	<div class="portlet-title">
		<div class="row">	
			<div class="col-md-6 col-xs-12 margin-bottom-10 font-lg font-grey-gallery">
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-grey-gallery">Reports</a> - <a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type; ?>" class="font-grey-gallery"><?php echo $type;?></a> - 
				<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report/'.$type.'/'.$user; ?>" class="font-grey-gallery"><?php echo $user;?></a> 
			</div>
			
			<div class="col-md-5 col-xs-9 margin-bottom-10 text-right padding-right-0">	
				
					<form method="get">
						<div class="btn-group left-dropdown">							
							<button class="btn bg-grey btn-xs dropdown-toggle" margin-right-10" data-toggle="dropdown" aria-expanded="true"	id="filter">
								<i class="fa fa-filter cursor-pointer"></i> Filter</button>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
								<div class=" date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" data-date-end-date="+0d">
									
									<input type="text" class="form-control border-radius-left" name="from" value="<?php if(isset($from)){ echo $from; }?>" placeholder="From Date">
									<input type="text" class="form-control border-radius-right margin-top-10" name="to" value="<?php if(isset($to)){ echo $to; }?>" placeholder="To Date">
							        	<div align="center">	
								<input type="hidden" name="new_report_id" value="<?php echo $new_report_id; ?>">
								<input type="hidden" name="new_pub_id" value="<?php echo $new_pub_id; ?>">
								<select id="report_status" name="report_status">
								
						<option value="">All</option>
						<option value="5">Completed</option>
					      </select>	
						  </div> 
									<div class="text-right margin-top-10">
										<button type="submit" class="btn bg-red-flamingo btn-sm"> Submit</button>
									</div>
								</div>
							</div>
						</div>
						
					</form>
					
			</div>	
			
			<div class="col-md-1 col-xs-5 margin-bottom-10 text-right">		
				<button class="btn bg-grey btn-xs" onclick="tableToExcel('sample_6', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="portlet-body no-space" id="close_filter">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Date</th>
				<?php 
		
    
/*******************get customer id and display customer name******/
    $custname=$this->db->query("SELECT id,first_name,last_name,publication_id FROM `adreps` WHERE `publication_id`='$new_pub_id' order by id");
		
	
  	if($custname!==FALSE && $custname->num_rows()>0) { //loop1 starts
		
		$custresult=$custname->result_array();
		

		foreach($custresult as $row) { //loop2 starts
		
		$custid[]=$row["id"]; // List of customer id
		?>
      	<th><?php echo $row["first_name"]." ".$row["last_name"]; ?></th>
	  <?php		
		}	//loop2 Ends
		}
		?>
					<th>Total Result</th>
					</tr>
				</thead>
				
				<tbody>
                <tr>
  <?php  
  $mysqli = new mysqli("localhost", "root", "", "adwitac_weborders");
  
  if(isset($_GET["report_status"])) //check report status while filtering
	   {
	 
	   if($_GET["report_status"]!='')
	   { 
		$status=$_GET["report_status"];
	   }
	   else
	   {
		 $status="";   
		   
	   }   
	  
	   }
	   else 
	   {
		 
		$status="";   
		   
	   } 
  
  $i=1;
$query="";
 while(strtotime($from)<=strtotime($to))
	  {	  //loop3 Starts
       
      $date_wise_total=0;  //Total result on perticular date
 	  
      $from_date=date("Y-m-d",strtotime($from)); 
       echo "<tr>";
	   echo "<td>".$from_date."</td>";  //display Date
	   foreach($custid as $row1){  //loop4 Starts
	
	 
		//$query= $mysqli->query("CALL sp_sales_report_cnt('".$new_pub_id."','".$from_date."','".$status."','".$row1."')");

	   $query.= "CALL sp_sales_report_cnt('".$new_pub_id."','".$from_date."','".$status."','".$row1."');";
	  
	   }
	  
	if ($mysqli->multi_query($query))
{
  do
    {
    // Store first result set
    if ($result=$mysqli->store_result()) {
      // Fetch one and one row
    if($result->num_rows>0)
	{	
	 while ($row=$result->fetch_assoc())
        {  

	?>
		 <td><?php  echo $row["CNT"]; ?></td>	

		 <?php
		  $date_wise_total=$date_wise_total+ $row["CNT"];  
	   
		 }
	}
    elseif($result->num_rows==0)
	{
		?>
	 <td>0</td>		
		
	<?php	
	} 	
      // Free result set 

    $result->free();
      }
	 
    }
  while ($mysqli->next_result());
  
}

//$mysqli->close();

	   
	 /* 	  if($query!==false){ 
	  $row = $query->fetch_assoc();
          echo $row["CNT"];    
       
		$query->free_result();

      }   	//$mysqli->next_result();  */
   		
	/*do
	{
	 $query= $mysqli->query("CALL sp_sales_report_cnt('".$new_pub_id."','".$from_date."','".$status."','".$row1."')"); 	
  while ($row = $query->fetch_assoc()) {
          echo $row["CNT"];    
        $query->free_result();   
			}	
	
		
		
	}while ($mysqli->next_result());*/
	   
	  /* if ($mysqli->multi_query($query)) {
    do { 
   
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_assoc()) {
              
            }
            $result->free();
        } echo $row['CNT'];

      if ($mysqli->more_results()) {
           echo $row[0];
        }
    } while ($mysqli->next_result());
}*/
//$row = $query->fetch_assoc();
/*do {
      while ($row = $query->fetch_assoc()) {
		echo "CALL sp_sales_report_cnt('".$new_pub_id."','".$from_date."','".$status."','".$row1."')";
		echo $row["CNT"];
		if($l_result = $mysqli->store_result()){
              $row->free();
      }
		  
	  }
 
	
}while ($mysqli->next_result());*/

  //}

/* close connection */

	  
	   
	   
	   
	// echo $result["CNT"];
	
		
   // printf("Select returned %d rows.\n", $result->num_rows);

    /* free result set */
    //$result->close();

		
    

		
		 
		?>

				
				
			<?php
				
		
		//$query->free_result();
		
		
	
     
	
			 //loop4 Ends
			
		
        
		$from=date('Y-m-d',strtotime('+1 days',strtotime($from))); 
		
		echo "<td>$date_wise_total</td>";
		echo "</tr>";       
		$query="";
			 } //loop3 Ends
	  
?>

	<?php 
    
      /*while(strtotime($from)<=strtotime($to))
	  {	  //loop3 Starts
       
      $date_wise_total=0;  //Total result on perticular date
 	  
      $from_date=date("Y-m-d",strtotime($from)); 
       echo "<tr>";
	   echo "<td>".$from_date."</td>";  //display Date
	   foreach($custid as $row1){  //loop4 Starts */
	   
	  /* $report_query="select CNT,created from `vw_new_report` where publication_id='$new_pub_id' and created='$from'";
	  
	  if(isset($_GET["report_status"])) //check report status while filtering
	   {
	 
	   if($_GET["report_status"]!='')
	   { 
		$report_query=$report_query." and status='".$_GET["report_status"]."'";   
	   }
	   }
	  $report_query=$report_query. " group by created,adrepid";
	 // echo $report_query;
   $report_query_result=$this->db->query($report_query);
	
		if($report_query_result!==FALSE ) { 
			
			$custresult=$report_query_result->result_array();
			//print_r($custresult);
	 foreach($custresult as $row1) { 
	   echo "<tr>";
	   echo "<td>".$row1['created']."</td>";  */
	   
	 
	
 		?>

	<td><?php /*echo $row1["CNT"];*/ ?></td>		
				
			<?php
        //$date_wise_total=$date_wise_total+ $row1["cnt"];  
	    	//} //loop4 Ends
        
	//	$from=date('Y-m-d',strtotime('+1 days',strtotime($from))); 
		
		//echo "<td>$date_wise_total</td>";
		/*echo "</tr>";       
		//	 } //loop3 Ends
  }*/
	//   }
			 
			 
		  //loop1 Ends


	   ?>
                </tr>			 
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>