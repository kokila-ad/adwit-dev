<?php $this->load->view('new_admin/header.php'); ?>
<?php $this->load->view('new_admin/amchart')?>


<script type="text/javascript">
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

		<!-- BEGIN CONTENT -->

<div class="portlet light">
	<div class="row margin-bottom-5">	
		<div class="col-md-6 col-xs-12 text-capitalize margin-bottom-5">
			<a href="<?php echo base_url().index_page(). 'new_admin/home/admin_report'; ?>" class="font-lg">Reports</a> -
<?php
	/*---------------------Modified on 29-12-2017------------------*/
  
  /*----------It checks All Publication or one publication-----------*/
	$rep_date=$nm_year."-".$nm_month;
		$strtime=strtotime($rep_date);
		$month=date('M',$strtime);

		/*$sqlmonthcont=$this->db->query("SELECT MONTH(B.Created_on) As Created,A.Id As Publication_id,A.Name As Publication_name,B.`publication_id`,(SELECT COUNT(*) from orders WHERE DATE(created_on) LIKE '$rep_date%' and status=1 AND `publication_id`=A.Id) AS Online_ad_count,(SELECT COUNT(*) from orders WHERE  DATE(created_on) LIKE '$rep_date%' AND `publication_id`=A.Id) AS Print_ad_count  FROM `Publications` A LEFT JOIN `Orders` B On A.Id=B.`publication_id` WHERE DATE(B.Created_on) LIKE '2017-06%' Group BY MONTH(B.Created_on),A.Id ORDER BY A.Id");*/


		
		
$sqlmonthcont=$this->db->query("SELECT Y.Id As Publication_id,X.Online_ad_count,Y.Print_ad_count,Y.Created_on,Y.Name As Publication_name FROM(SELECT A.Name,COUNT(B.Order_type_id) AS Online_ad_count,B.Created_on,B.Order_type_id,B.Publication_id,A.Id FROM `publications` A LEFT JOIN `orders` B On A.Id=B.`Publication_id` WHERE DATE(B.Created_on) LIKE '$rep_date%' AND B.Order_type_id=1 Group BY B.Order_type_id,A.Id ORDER BY `Publication_id`) X RIGHT JOIN (SELECT A.Name,COUNT(C.Order_type_id) AS Print_ad_count,C.Created_on,C.Order_type_id,C.Publication_id,A.Id FROM `publications` A LEFT JOIN `orders` C On A.Id=C.`Publication_id` WHERE DATE(C.Created_on) LIKE '$rep_date%' AND C.Order_type_id=2 Group BY C.Order_type_id,A.Id ORDER BY `Publication_id`) Y ON X.Publication_id=Y.Publication_id Order BY Y.Id");	
	
	if($sqlmonthcont->num_rows>0) { 
	$result=$sqlmonthcont->result_array(); 
	echo "<table border=1>";
	echo "<tr><th colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$month</th>";
	echo "<tr><th>Publication Id</th><th>Publication Name</th><th>online Add Count</th><th>Print Add Count</th></tr>";

   foreach($result as $row) {
	
	echo "<tr><td>$row[Publication_id]</td><td>$row[Publication_name]</td><td>$row[Online_ad_count]</td><td>$row[Print_ad_count]</td></tr>";    
	   
   }
	echo "</table>";	
		
		
	}
	?>
		
		



<?php $this->load->view('new_admin/footer.php'); ?>
<?php $this->load->view('new_admin/datatable.php'); ?>