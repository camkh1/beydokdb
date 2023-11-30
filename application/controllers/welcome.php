<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {
	protected $mod_general;
    public function __construct() {        
        parent::__construct();
        $this->load->model('Mod_general');
        $this->load->theme('layout');
        $this->mod_general = new Mod_general ();
        date_default_timezone_set('Asia/Phnom_Penh');
    }

    public function index() {
        $this->load->theme('layout');
        $data['title'] = 'User login';
        $data['css'] = array(
            'themes/layout/blueone/assets/css/login',
            'themes/layout/blueone/assets/css/responsive',
            'themes/layout/blueone/assets/css/plugins',
            'themes/layout/blueone/assets/css/icons',
            'themes/layout/blueone/bootstrap/css/bootstrap.min',
            'themes/layout/blueone/assets/css/main',
        );
        $data['addJsScript'] = array(
            "if('ontouchend' in document) document.write('<script src='assets/js/jquery.mobile.custom.min.js'>'+'<'+'/script>');
",
            "function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
"
        );
        $data['bodyClass'] = 'login';        
        /* form */

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            if ($this->input->post('username')) {
                $user = $this->input->post('username');
                $password = $this->input->post('password');
                $where = array('u_email' => $user, 'u_password' => md5($password),'u_status'=>1);
                $query = $this->mod_general->select('users','*',$where);
                if (count($query) > 0) {
                    foreach ($query as $row) {
                        $this->session->set_userdata('password', $password);
                        $this->session->set_userdata('email', $row->u_email);
                        $this->session->set_userdata('user_type', $row->u_type);
                        $this->session->set_userdata('user_id', $row->u_id);
                        redirect(base_url() . 'home/index');
                    }
                }
            }
        }
        $user = $this->session->userdata('email');
        if ($user) {
            if($backto) {
                redirect($backto);
            } else {
                redirect(base_url() . 'home/index');
            }
            //redirect(base_url() . 'home');
        } else {
            //$this->load->view('login', $data);
            //redirect(base_url() . 'hauth');
        	$this->load->view('login', $data);
        }
    }

    public function login() {
        $this->load->theme('layout');
        $data['title'] = 'User login';
        $data['css'] = array(
            'themes/layout/blueone/assets/css/login',
            'themes/layout/blueone/assets/css/responsive',
        );
        $data['addJsScript'] = array(
            "if('ontouchend' in document) document.write('<script src='assets/js/jquery.mobile.custom.min.js'>'+'<'+'/script>');
",
            "function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
"
        );
        $data['bodyClass'] = 'login';

        /* form */

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            if ($this->input->post('username')) {
                $user = $this->input->post('username');
                $password = $this->input->post('password');
                $field = array(
                    'username',
                    'log_id',
                    'user_type'
                );
                $where = array(
                    'username' => $user, 
                    'password' => md5($password),
                    'user_status' => 1,
                    );
                $query = $this->Mod_general->getuser($field, $where);
                if (count($query) > 0) {
                    foreach ($query as $row) {
                        $this->session->set_userdata('username', $row->username);
                        $this->session->set_userdata('user_type', $row->user_type);
                        $this->session->set_userdata('log_id', $row->log_id);
                        redirect(base_url() . 'home');
                    }
                }
            }
        }
        $user = $this->session->userdata('username');
        if ($user) {
            redirect(base_url() . 'home');
        } else {
            $this->load->view('login', $data);
        }
    }
    
    public function autoposter()
    {
        $this->load->theme('layout');
        $data['title'] = 'Facebook Auto Poster 1.0';
        $data['css'] = array(
            'themes/layout/blueone/assets/css/responsive',
            'themes/layout/blueone/assets/css/plugins',
            'themes/layout/blueone/assets/css/icons',
            'themes/layout/blueone/bootstrap/css/bootstrap.min',
            'themes/layout/blueone/assets/css/main',
            'themes/layout/blueone/assets/css/fontawesome/font-awesome.min',
        );
        $data['addJsScript'] = array(
            "if('ontouchend' in document) document.write('<script src='assets/js/jquery.mobile.custom.min.js'>'+'<'+'/script>');
",
            "function show_box(id) {
             jQuery('.widget-box.visible').removeClass('visible');
             jQuery('#'+id).addClass('visible');
            }
"
        );
        $this->load->view('autoposter', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */