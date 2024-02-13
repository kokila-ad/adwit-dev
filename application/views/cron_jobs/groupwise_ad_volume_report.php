<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Base styles for the email */
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 10px }
    img { -ms-interpolation-mode: bicubic; }

    /* Reset styles */
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

    /* Define custom styles */
    .table-container {
      max-width: 600px !important;
      width: 100% !important;
    }

    /* Media query for mobile view */
    @media screen and (max-width: 525px) {
      .table-container {
        width: 100% !important;
      }
    }
  </style>
</head>
<body>
  <!-- Wrapper for the entire email content -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" valign="top">
        <!-- Main content wrapper -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-container">
          
          <!-- Loop through this section for each table -->
          <tr>
            <td align="center" valign="top">
              <table border="1" cellpadding="0" cellspacing="0" width="100%" bordercolor="#F0F0F0">
                <tr bgcolor="#000000">
                  <td colspan="2" align="center" valign="top"><img src="https://adwitads.com/weborders/assets/new_client/img/Adwit_ads_white.png" /></td>
                </tr>
				 <tr bgcolor="#F0F0F0">
                  <td colspan="2" align="center" valign="top">Group wise ad volume - <?php echo date('d-m-Y');?></td>
                </tr>
                <?php 
                  if($groupDailyReports){
                      foreach($groupDailyReports as $groupDailyReport){ 
                ?>  
                <tr>
                  <td align="center" valign="top"><?php echo $groupDailyReport['group_name'];?></td>
                  <td align="center" valign="top"><?php echo $groupDailyReport['group_count'];?></td>
                </tr>
                <?php } } ?>
        <?php 
          if($groupDailyReportsTotal){
            $totalAds =  $groupDailyReportsTotal['total_webad_count'] + $groupDailyReportsTotal['total_print_adcount']; 
        ?>  
				<tr bgcolor="#000000">
                  <td colspan="2" align="center" valign="top" style="color: #ffffff;font-size: 20px">Total - <?php echo $totalAds; ?></td>
                </tr>
				  
				<tr bgcolor="#000000">
                  <td colspan="2" align="center" valign="top" style="color: #ffffff;font-size: 18px">Pagination Ad Count - <?php echo $groupDailyReportsTotal['total_pagead_count'];?></td>
                </tr>
				  
				
				  <tr bgcolor="#000000">
                  <td colspan="2" align="center" valign="top" style="color: #ffffff;font-size: 18px">Web Ad Count - <?php echo $groupDailyReportsTotal['total_webad_count'];?></td>
                </tr>
				
				  <tr bgcolor="#000000">
                  <td colspan="2" align="center" valign="top" style="color: #ffffff;font-size: 18px">Print Ad Count - <?php echo $groupDailyReportsTotal['total_print_adcount'];?></td>
          </tr>
				<?php } ?>
		      </table>
            </td>
          </tr>
        <?php 
            if($getAllGroups){
                foreach($getAllGroups as $getAllGroup){
        ?> 	
			<tr>
           	 <td align="center" valign="top">
              	<table border="1" cellpadding="0" cellspacing="0" width="100%" bordercolor="#F0F0F0">
					
					 <tr bgcolor="#F0F0F0">
					  <td colspan="2" align="center" valign="top"><?php echo $getAllGroup['group']?>- <strong><?php echo $getAllGroup['total_orders']?></td>
					</tr>
                <!-- get the publication daily report for the group -->
                <?php 
                    //$group_id['group_id'] = $getAllGroup['group_id'];
                    $q = "SELECT * FROM `Publication_daily_report` WHERE `Publication_daily_report`.`day`='$day' AND `group_id` = '".$getAllGroup['group_id']."'";
                    $publicationOrders = $this->db->query($q)->result_array();
                    foreach($publicationOrders as $publicationOrder){
                ?>    
					<tr>
					  <td align="center" valign="top"><?php echo $publicationOrder['publication']?></td>
					  <td align="center" valign="top"><?php echo $publicationOrder['orders_count']?></td>
					</tr>
				<?php } ?>
				  
				</table>
				</td>
			</tr>
          <!-- End loop -->
          <?php } } ?>                 
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
