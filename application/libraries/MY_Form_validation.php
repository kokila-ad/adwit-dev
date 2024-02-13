<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
 
class MY_Form_validation extends CI_Form_validation {
 
  	public function __construct()
	{
		parent::__construct();
	}
  
  // matches_pattern()
  // Ensures a string matches a basic pattern
  // # numeric, ? alphabetical, ~ any character
  function matches_pattern($str, $pattern) {
    $characters = array(
      '[', ']', '\\', '^', '$',
      '.', '|', '+', '(', ')',
      '#', '?', '~'            // Our additional characters
    );
 
    $regex_characters = array(
      '\[', '\]', '\\\\', '\^', '\$',
      '\.', '\|', '\+', '\(', '\)',
      '[0-9]', '[a-zA-Z]', '.' // Our additional characters
    );
 
    $pattern = str_replace($characters, $regex_characters, $pattern);
    if (preg_match('/^' . $pattern . '$/', $str)) return TRUE;
    return FALSE;
  }
  
  function error_count()
  {
        return count($this->_error_array);
  }
}