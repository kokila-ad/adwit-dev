
  <!-- Footer starts -->

	<div id="Footer">
		<div id="footer-copy">&copy; <a href="http://www.adwitglobal.com/" target="_blank">Adwit Global</a></div>
		<div id="footer-version">
		<?php $footer_copy = $this->db->get('footer_copy')->row_array(); echo $footer_copy['footer_name']; ?>
		</div>
	</div> 

  <!-- Footer Ends -->

</div>

</body>

</html>