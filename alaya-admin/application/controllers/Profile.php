<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    var $API = '';

    public function __construct()
    {
        parent::__construct();
        
        // Check if user use vpn
        $this->vpn_model->detectVpn();
        
        $this->API = getenv('REST_URL');

        if (!$this->session->userdata('logged_in') || !$this->session->userdata('admin')) {
            redirect(base_url('auth/login'));
            exit;
        }
    }

    // Profile
	public function index(INT $id) {
        if ($id != $this->session->userdata('user_id')) {
            redirect(base_url());
            exit;
        } else {
            $this->load->model('profile_model');
            $response = $this->profile_model->getProfile($id);
            $response = json_decode($response->body,true);
            $data['user'] = $response;
            $this->load->view('layouts/header');
            $this->load->view('home/profile',$data);
            $this->load->view('layouts/footer');
        }
    }
}