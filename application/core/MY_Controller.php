<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//error_reporting(0);

class Auth_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		$this->load->model('admin_model'); //load model
		if(!$this->session->userdata('admin') && $this->router->class!='login')
		{
			redirect('admin/Login/index');
		}else if($this->session->userdata('admin') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('admin/Home/index');
		}
    }
}

class Nadmin_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model'); //load model
		if(!$this->session->userdata('admin') && $this->router->class!='login')
		{
			redirect('client/Login/index');
		}else if($this->session->userdata('admin') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('new_admin/Home/index');
		}
    }
}

class Iadmin_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('iadmin') && $this->router->class!='login')
		{
			redirect('iadmin/Login/index');
		}else if($this->session->userdata('iadmin') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('iadmin/Home/index');
		}
    }
}


class Client_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('client') && $this->router->class!='login')
		{
			redirect('client/Login/index');
		}else if($this->session->userdata('client') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('client/Home/index');
		}
    }
}

class Designer_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('designer') && $this->router->class!='login')
		{
			redirect('designer/Login/index');
		}else if($this->session->userdata('designer') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('designer/Home/index');
		}
    }
}

class New_Designer_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('designer') && $this->router->class!='login')
        {
           redirect('new_designer/Login/index');
        }else if($this->session->userdata('designer') && $this->router->class=='login' && $this->router->method!='shutdown')
        {
           redirect('new_designer/Home/index');
        }
    }
}

class Team_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('team') && $this->router->class!='login')
		{
			redirect('team-lead/Login/index');
		}else if($this->session->userdata('team') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('team-lead/Home/index');
		}
    }
}

class Csr_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('csr') && $this->router->class!='login')
		{
			redirect('csr/Login/index');
		}else if($this->session->userdata('csr') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('csr/Home/index');
		}
    }
}
class New_Csr_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('csr') && $this->router->class!='login')
		{
			redirect('new_csr/Login/index');
		}else if($this->session->userdata('csr') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('new_csr/Home/index');
		}
    }
}

class India_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('india') && $this->router->class!='login')
		{
			redirect('india/Login/index');
		}else if($this->session->userdata('india') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('india/Home/index');
		}
    }
}

class Accounts_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('accounts') && $this->router->class!='login')
		{
			redirect('accounts/Login/index');
		}else if($this->session->userdata('accounts') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('accounts/Home/index');
		}
    }
}

class Management_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('management') && $this->router->class!='login')
		{
			redirect('management/Login/index');
		}else if($this->session->userdata('management') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('management/Home/index');
		}
    }
}	

class India_Client_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('india_client') && $this->router->class!='login')
		{
			redirect('india_client/Login/index');
		}else if($this->session->userdata('india_client') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('india_client/Home/index');
		}
    }
}

class New_Client_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('new_client') && $this->router->class!='login')
		{
		    if($this->uri->segment(5)){ $set_url_method = $this->router->method.'/'.$this->uri->segment(4).'/'.$this->uri->segment(5); }elseif($this->uri->segment(4)){ $set_url_method = $this->router->method.'/'.$this->uri->segment(4); }else{ $set_url_method = $this->router->method; }
		    $this->session->set_userdata('url_method', $set_url_method); //get method of the url and redirect after login
			redirect('new_client/Login/index');
		}else if($this->session->userdata('new_client') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('new_client/Home/index');
		}
    }
}

class Professional_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('professional_client') && $this->router->class!='login')
		{
			redirect('professional_edition/Login/index');
		}else if($this->session->userdata('professional_client') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('professional_edition/Home/index');
		}
    }
}

class Lite_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		$this->load->model('lite_client_model');
		//$this->load->library('stripegateway');
		if(!$this->session->userdata('lite_client') && $this->router->class!='login')
		{
			redirect('lite/Login/index');
		}else if($this->session->userdata('lite_client') && $this->router->class=='login' && $this->router->method!='shutdown')
		{
			redirect('lite/Home/index');
		}
    }
}
