<?php
	$mon_data =$this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='Mon' ")->result_array();
	$tue_data = $this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='Tue' ")->result_array();
	$wed_data = $this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='Wed' ")->result_array();
	$thu_data = $this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='Thu' ")->result_array();
	$fri_data = $this->db->query("SELECT * FROM `teamwise_daily_report` WHERE `day`='Fri' ")->result_array();

	if($mon_data)
	{
		foreach($mon_data as $row)
		 {
			$adwit_team_id = $row['adwit_team_id'];
		    $adwit_team_q = $this->db->query("SELECT name,adwit_teams_id FROM `adwit_teams` WHERE adwit_teams_id =$adwit_team_id")->result_array();
		
           foreach($adwit_team_q as $data){
             if($adwit_team_id == $data['adwit_teams_id']){
                if($adwit_team_id == '1'){
                  $mon_ramesh_adcount = $row['ad_count'];
		          $mon_ramesh_color = $row['color'];  
                } 
                if($adwit_team_id == '2'){
                  $mon_radha_adcount = $row['ad_count'];
		          $mon_radha_color = $row['color'];  
                } 
                if($adwit_team_id == '3'){
                  $mon_shihab_adcount = $row['ad_count'];
		          $mon_shihab_color = $row['color'];  
                } 
                if($adwit_team_id == '4'){
                  $mon_sushmitha_adcount = $row['ad_count'];
		          $mon_sushmitha_color = $row['color'];  
                } 
             }  
           }
           $timestamp = strtotime($row['date']);
		   $mon_date = date('d', $timestamp);
		 }

	}

	if($tue_data)
	{
		foreach($tue_data as $row)
		 {
			$adwit_team_id = $row['adwit_team_id'];
		    $adwit_team_q = $this->db->query("SELECT name,adwit_teams_id FROM `adwit_teams` WHERE adwit_teams_id =$adwit_team_id")->result_array();
		
			foreach($adwit_team_q as $data ){
             if($adwit_team_id == $data['adwit_teams_id']){
                if($adwit_team_id == '1'){
                  $tue_ramesh_adcount = $row['ad_count'];
		          $tue_ramesh_color = $row['color'];  
                } 
                if($adwit_team_id == '2'){
                  $tue_radha_adcount = $row['ad_count'];
		          $tue_radha_color = $row['color'];  
                } 
                if($adwit_team_id == '3'){
                  $tue_shihab_adcount = $row['ad_count'];
		          $tue_shihab_color = $row['color'];  
                } 
                if($adwit_team_id == '4'){
                  $tue_sushmitha_adcount = $row['ad_count'];
		          $tue_sushmitha_color = $row['color'];  
                } 
             }  
           }
           $timestamp = strtotime($row['date']);
		   $tue_date = date('d', $timestamp);

		 }
	}

	if($wed_data)
	{
		foreach($wed_data as $row )
		 {
			$adwit_team_id = $row['adwit_team_id'];
		    $adwit_team_q = $this->db->query("SELECT name,adwit_teams_id FROM `adwit_teams` WHERE adwit_teams_id =$adwit_team_id")->result_array();
		
			foreach( $adwit_team_q as $data){
             if($adwit_team_id == $data['adwit_teams_id']){
                if($adwit_team_id == '1'){
                  $wed_ramesh_adcount = $row['ad_count'];
		          $wed_ramesh_color = $row['color'];  
                } 
                if($adwit_team_id == '2'){
                  $wed_radha_adcount = $row['ad_count'];
		          $wed_radha_color = $row['color'];  
                } 
                if($adwit_team_id == '3'){
                  $wed_shihab_adcount = $row['ad_count'];
		          $wed_shihab_color = $row['color'];  
                } 
                if($adwit_team_id == '4'){
                  $wed_sushmitha_adcount = $row['ad_count'];
		          $wed_sushmitha_color = $row['color'];  
                } 
             }  
           }
           $timestamp = strtotime($row['date']);
		   $wed_date = date('d', $timestamp);
		 }
	}

	if($thu_data)
	{
		foreach($thu_data as $row)
		 {
			$adwit_team_id = $row['adwit_team_id'];
		    $adwit_team_q = $this->db->query("SELECT name,adwit_teams_id FROM `adwit_teams` WHERE adwit_teams_id =$adwit_team_id")->result_array();
		
           foreach( $adwit_team_q as $data){
             if($adwit_team_id == $data['adwit_teams_id']){
                if($adwit_team_id == '1'){
                  $thu_ramesh_adcount = $row['ad_count'];
		          $thu_ramesh_color = $row['color'];  
                } 
                if($adwit_team_id == '2'){
                  $thu_radha_adcount = $row['ad_count'];
		          $thu_radha_color = $row['color'];  
                } 
                if($adwit_team_id == '3'){
                  $thu_shihab_adcount = $row['ad_count'];
		          $thu_shihab_color = $row['color'];  
                } 
                if($adwit_team_id == '4'){
                  $thu_sushmitha_adcount = $row['ad_count'];
		          $thu_sushmitha_color = $row['color'];  
                } 
             }  
           }
           $timestamp = strtotime($row['date']);
		   $thu_date = date('d', $timestamp);
		 
		 }
	}
	
	if($fri_data)
	{
		foreach( $fri_data as $row)
		 {
			$adwit_team_id = $row['adwit_team_id'];
		    $adwit_team_q = $this->db->query("SELECT name,adwit_teams_id FROM `adwit_teams` WHERE adwit_teams_id =$adwit_team_id")->result_array();
		
           foreach($adwit_team_q as $data){
             if($adwit_team_id == $data['adwit_teams_id']){
                if($adwit_team_id == '1'){
                  $fri_ramesh_adcount = $row['ad_count'];
		          $fri_ramesh_color = $row['color'];  
                } 
                if($adwit_team_id == '2'){
                  $fri_radha_adcount = $row['ad_count'];
		          $fri_radha_color = $row['color'];  
                } 
                if($adwit_team_id == '3'){
                  $fri_shihab_adcount = $row['ad_count'];
		          $fri_shihab_color = $row['color'];  
                } 
                if($adwit_team_id == '4'){
                  $fri_sushmitha_adcount = $row['ad_count'];
		          $fri_sushmitha_color = $row['color'];  
                } 
             }  
           }
           $timestamp = strtotime($row['date']);
		   $fri_date = date('d', $timestamp);
		 }
	}
?>

<table align="center" width="0" border="0" cellspacing="0" cellpadding="0" style=" width:550px; border:#666 solid 1px;">
<tr>
    <tr>
		<td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
      <tr>
        <td style="width:172px; background-color:#66ff66;">
			<img src="http://www.adwitads.com/BG-Report/images/ad_logo.png" width="172" height="84">
		</td>
        <td align="left" valign="middle" style="width:428px; opacity: .8; background-color:#66ff66">
			<p style=" font-family:Arial, Helvetica, sans-serif; color:#654833; font-size:24px; margin:0px; padding:0 0 0 25px;">Team wise ad volume</p>
		</td> 
      </tr>
    </table></td>
    
	</tr>
	
<tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px; border-right: #999999 solid 1px;">
  <tr>
    <td style=" width:150px; background-color:#f6f6f6; border-bottom: #cccccc solid 1px; border-right: #ccc solid 1px;">&nbsp;</td>
     <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:#f6f6f6;">
		<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">Mon<br/>
		 <?php if($mon_data){echo $mon_date;}else{ echo ""; } ?> 
		</p>
	</td>

    <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:#f6f6f6;">
	  <p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">Tue<br/>
		 <?php if($tue_data){echo $tue_date;}else{ echo ""; } ?> 
	  </p>
	</td>
      
    <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:#f6f6f6;">
		<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">Wed<br/>
		 	<?php if($wed_data){echo $wed_date;}else{ echo ""; } ?> 
		</p>
	</td>
       
    <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:#f6f6f6;">
		<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">Thu<br/>
		 	<?php if($thu_data){echo $thu_date;}else{ echo ""; } ?>
		</p>
	</td>
        
     <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:#f6f6f6;">
		<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">Fri<br/>
			  <?php if($fri_data){echo $fri_date;}else{ echo ""; } ?> 
		</p>
	</td>
	</tr>
	</table>
	</td>
</tr>

	<tr>
		<td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
		<tr>
			<td style=" width:149px; background-color:#f6f6f6; border-bottom: #cccccc solid 1px; border-right: #ccc solid 1px;"><p style="font-family:Arial, Helvetica, sans-serif; font-size:1.2em; margin:0px; text-align: center; color:#000;">Shihab</p></td>
    
			<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:<?php if($mon_data){echo $mon_shihab_color;}else{ echo "#f6f6f6;"; }?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($mon_data){echo $mon_shihab_adcount;}else{ echo "&nbsp;"; }?>
			</p>
			</td>

			<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:<?php if($tue_data){echo $tue_shihab_color;}else{ echo "#f6f6f6;"; }?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($tue_data){echo $tue_shihab_adcount;}else{ echo "&nbsp;"; }?>
			</p>
			</td>
      
			<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:<?php if($wed_data){echo $wed_shihab_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($wed_data){echo $wed_shihab_adcount;}else{ echo "&nbsp;"; }?>
			</p>
			</td>
       
			<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:<?php if($thu_data){echo $thu_shihab_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($thu_data){echo $thu_shihab_adcount;}else{ echo "&nbsp;"; }?>
			</p>
			</td>
        
			<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color:<?php if($fri_data){echo $fri_shihab_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($fri_data){echo $fri_shihab_adcount;}else{ echo "&nbsp;"; }?>
			</p>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<!-- Ramesh -->
	<tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
	<tr>
		<td style=" width:149px; background-color:#f6f6f6; border-bottom: #cccccc solid 1px; border-right: #ccc solid 1px;"><p style="font-family:Arial, Helvetica, sans-serif; font-size:1.2em; margin:0px; text-align: center; color:#000;">Ramesh</p></td>
    
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($mon_data){echo $mon_ramesh_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($mon_data){echo $mon_ramesh_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>

		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($tue_data){echo $tue_ramesh_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($tue_data){echo $tue_ramesh_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
      
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($wed_data){echo $wed_ramesh_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($wed_data){echo $wed_ramesh_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
       
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($thu_data){echo $thu_ramesh_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($thu_data){echo $thu_ramesh_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
        
        <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($fri_data){echo $fri_ramesh_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($fri_data){echo $fri_ramesh_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
	</tr>
	</table>
	</td>
  </tr>
  <!-- Radha -->
  <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
	<tr>
		<td style=" width:149px; background-color:#f6f6f6; border-bottom: #cccccc solid 1px; border-right: #ccc solid 1px;"><p style="font-family:Arial, Helvetica, sans-serif; font-size:1.2em; margin:0px; text-align: center; color:#000;">Radha</p></td>
    
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($mon_data){echo $mon_radha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($mon_data){echo $mon_radha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>

		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($tue_data){echo $tue_radha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($tue_data){echo $tue_radha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
      
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($wed_data){echo $wed_radha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($wed_data){echo $wed_radha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
       
        <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($thu_data){echo $thu_radha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($thu_data){echo $thu_radha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
        
        <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($fri_data){echo $fri_radha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($fri_data){echo $fri_radha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
	</tr>
	</table>
	</td>
  </tr>
   <!-- Sushmitha -->
   <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
	<tr>
		<td style=" width:149px; background-color:#f6f6f6; border-bottom: #cccccc solid 1px; border-right: #ccc solid 1px;"><p style="font-family:Arial, Helvetica, sans-serif; font-size:1.2em; margin:0px; text-align: center; color:#000;">Sushmitha</p></td>
    
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($mon_data){echo $mon_sushmitha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($mon_data){echo $mon_sushmitha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>

		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($tue_data){echo $tue_sushmitha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($tue_data){echo $tue_sushmitha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
      
		<td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($wed_data){echo $wed_sushmitha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($wed_data){echo $wed_sushmitha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
       

        <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($thu_data){echo $thu_sushmitha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($thu_data){echo $thu_sushmitha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
        
        <td align="center" style=" width:80px; border-bottom:#dddddd solid 1px; border-right:#dddddd solid 1px; background-color: <?php if($fri_data){echo $fri_sushmitha_color;}else{ echo "#f6f6f6;";} ?>">
			<p style="font-family:Arial, Helvetica, sans-serif; font-size:1em; margin:0px; padding:15px 0 15px 0;">
				<?php if($fri_data){echo $fri_sushmitha_adcount;}else{ echo "&nbsp;"; }?>
			</p>
		</td>
	</tr>
	</table>
	</td>
  </tr>

  <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style=" width:550px;">
  <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
      <tr>
        <td style="width:150px; background-color:#f6f6f6;">&nbsp;</td>
        <td align="left" valign="middle" style="width:428px; background-color:#f6f6f6;"><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:428px;">
  <tr>
    <td style=" width:128px;">&nbsp;</td>
    <td style=" width:300px;"><table width="0" border="0" cellspacing="0" cellpadding="0" style=" width:250px;">
  <tr>
    <td style=" width:10px;"><img src="http://www.adwitads.com/BG-Report/images/yellow.jpg" width="11" height="10"></td>
    <td style=" width:44px;"><p style=" font-family:Arial, Helvetica, sans-serif; font-size:11px; margin:0px; padding:20px 10px 20px 5px; color:#22252e;">Low</p></td>
    <td style=" width:10px;"><img src="http://www.adwitads.com/BG-Report/images/orng.jpg" width="10" height="10"></td>
    <td style=" width:44px;"><p style=" font-family:Arial, Helvetica, sans-serif; font-size:11px; margin:0px; padding:20px 10px 20px 5px; color:#22252e;">Medium</p></td>
     <td style=" width:10px;"><img src="http://www.adwitads.com/BG-Report/images/red.jpg" width="10" height="10"></td>
    <td style=" width:46px;"><p style=" font-family:Arial, Helvetica, sans-serif; font-size:11px; margin:0px; padding:20px 5px 20px 5px; color:#22252e;">High</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
      </tr>
    </table></td>
    
  </tr>
  
  <tr>
    <td><table width="0" border="0" cellspacing="0" cellpadding="0" style="width:550px;">
      <tr>
        <td style="width:172px; background-color:#f6f6f6;"><p style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#333; margin:0px; padding:5px 5px 10px 15px; ">auto system generated report*</p></td>
        <!-- <td align="right" style="width:428px; background-color:#f6f6f6;"><p style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#424449; margin:0px; padding:0px 30px 10px 15px; ">Click to <a href="#">view</a> team capacity range</p> -->
</td>
      </tr>
    </table></td>
    
  </tr>
  
</table>
</td>
</tr>
 </table> 
	