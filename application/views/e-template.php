<body>
<table align="center" width="550" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeeeee; font-family:Tahoma, Geneva, sans-serif; border: thin solid #ccc;">
<tbody>
  <tr>
    <td>
    <!-- news letter starts -->
    <table align="center"width="500" border="0" cellspacing="0" cellpadding="0">
    <tbody>
  <tr>
    <td><p style="padding-top:25px;"><a href="<?php echo base_url().index_page();?>" target="_blank"><img src="<?php echo base_url()."images/logo_dark.png";?>" alt="Adwit-Ads" width="180" height="47" style="border:0px; display:block;"/></a></p></td>
  </tr>
  <tr>
  	<td><h2 style="color:#c30013; margin:0px; padding-top:30px;"><?php echo isset($headline) ? $headline : 'Hello!';?></h2></td>
  </tr>
  <?php if(isset($p_one)):?>
  <tr>
  	<td>
    <p style="color:#333; font-size:18px; padding-top:30px; line-height:26px; margin:0px;"><?php echo $p_one;?></p>
    </td>
  </tr>
  <?php endif;?>
  <?php if(isset($p_three)):?>
  <tr>
  	<td>
    <p style="color:#333; font-size:18px; padding-top:30px; line-height:26px; margin:0px;"><?php echo $p_three;?></p>
    </td>
  </tr>
  <?php endif;?>
  <?php if(isset($p_two)):?>
  <tr>
  	<td>
    <p style="color:#333; font-size:18px; padding-top:30px; line-height:26px; margin:0px;"><?php echo $p_two;?></p>
    </td>
  </tr>
  <?php endif;?>
  
  <tr>
  	<td>
    <p style="color:#333; font-size:18px; padding-top:30px; margin:0px; line-height:26px; padding-bottom:25px;"><span style="color:#c30013;"><strong><?php echo isset($footline) ? $footline : 'Thanks';?></strong>,</span><br/>AdwitAds Support Team</p>
    </td>
  </tr>
  </tbody>
</table>

    <!-- news letter ends -->    
    
    </td>
  </tr>
</tbody>
</table>
</body>
