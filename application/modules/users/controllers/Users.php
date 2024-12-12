<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @author CokesHome
 * @copyright Copyright (c) 2015, CokesHome
 * 
 * This is controller for Authentication
 */

class Users extends Front_Controller {
    
    /**
     * Load the models, library, etc
     *
     * 
     */

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model(array('identitas_model'));
    	$this->load->library('users/auth');
    }

    public function index()
    {
        redirect('users/setting');
    }

    public function login()
    {
        if($this->auth->is_login())
        {
            redirect('/');
			// redirect('https://sentral.dutastudy.com/metalsindo_dev/');
        }

    	//$identitas = $this->identitas_model->find(1); => ERROR variable nama_program not define krn ga ada fieldnya di tabel identitas
        $identitas = $this->identitas_model->find_by(array('ididentitas'=>1));// By Muhaemin => Di Form Login

    	if(isset($_POST['login']))
    	{
    		$username = $this->input->post('username');
    		$password = $this->input->post('password');

    		$this->auth->login($username, $password);
    	}

    	$this->template->set('idt', $identitas);
        $this->template->set_theme('default');
        $this->template->set_layout('login');
        $this->template->title('Login');
    	$this->template->render('login_animate');
    }

    public function logout()
    {
    	$this->auth->logout();
		
    }
}
