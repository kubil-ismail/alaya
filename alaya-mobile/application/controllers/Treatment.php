<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Treatment extends CI_Controller
{

    var $API = '';
    public function __construct()
    {
        parent::__construct();
        
        // Check if user use vpn
        $this->vpn_model->detectVpn();

        $this->API = getenv('REST_URL');

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('auth/login'));
            exit;
        }

        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
       
            // $data['treatments'] = json_decode($response->body, true);

            $this->load->view('layouts/header');
            $this->load->view('treatment/treatment');
            $this->load->view('layouts/footer');
        // } else {
            // redirect(base_url());
            // exit;
        // }
    }

    public function getTreatment()
    {
        $response = Requests::GET($this->API . 'treatment/'. $this->session->userdata('branch_id') . '?token=' . $this->session->userdata('TOKEN'));
       
        if ($response->status_code == 200) {
            $data = json_decode($response->body, TRUE);
            echo json_encode(json_decode($response->body, TRUE));
        } else {
            echo json_encode(false,true);
        }
    }

    public function detail(INT $id = null)
    {
        if ($id == null) {
            redirect(base_url());
            exit;
        }
        $data['id'] = $id;
        // $response = Requests::GET($this->API . 'treatment/detail/'.$id . '?token=' . $this->session->userdata('TOKEN'));
       
        // if ($response->status_code == 200) {
        //     $data['treatment'] = json_decode($response->body, true);
            $this->load->view('layouts/header');
            $this->load->view('treatment/detail_treatment',$data);
            $this->load->view('layouts/footer');
        // } else {
        //     redirect(base_url());
        //     exit;
        // }
    }

    public function get_detail(INT $id = null)
    {
        $response = Requests::GET($this->API . 'treatment/detail/'.$id . '?token=' . $this->session->userdata('TOKEN'));
        echo json_encode(json_decode($response->body,true));
    }
    
    public function count(INT $id = null)
    {
        if ($id == null) {
            redirect(base_url());
            exit;
        }
        // $data['treatment'] = json_decode($response->body, true);
        $data['id'] = $id;
        $this->load->view('layouts/header');
        $this->load->view('treatment/count_treatment', $data);
        $this->load->view('layouts/footer');
    }

    public function get_count(INT $id = null)
    {
        $response = Requests::GET($this->API . 'treatment/detail/' . $id . '?token=' . $this->session->userdata('TOKEN'));
        echo json_encode(json_decode($response->body, true));
    }

    public function start(INT $user_id = null , INT $id = null)
    {
        if ($id == null || $user_id == null) {
            redirect(base_url());
            exit;
        }
        if ($user_id != $this->session->userdata('user_id')) {
            redirect(base_url());
            exit;
        } else {

            $data['id'] = $id;

            $this->load->view('layouts/header');
            $this->load->view('treatment/start_treatment',$data);
            $this->load->view('layouts/footer');
        
        }
    }

    public function finish(INT $user_id = null, INT $id = null)
    {
        if ($id == null || $user_id == null) {
            redirect(base_url());
            exit;
        }
        if ($user_id != $this->session->userdata('user_id')) {
            redirect(base_url());
            exit;
        } else {

            $start = $this->input->post('start',true);
            $end = date('h:i A');
            $date = $this->input->post('date',true);
            $duration = $this->input->post('time',true);
            
            $response = Requests::POST($this->API . 'treatment/add/history?users_id='.$user_id.'&treatment_id='. $id.'&date='.$date.'&time_entry='. $start.'&time_out='.$end.'&duration='. $duration.'&token='. $this->session->userdata('TOKEN'));
           
            if ($response->status_code === 200) {
                echo json_encode($duration);
            } else {
                echo json_encode($response);
            }
        }
    }

    public function history(INT $user_id=null,INT $id = null)
    {
        if ($id == null || $user_id == null) {
            redirect(base_url());
            exit;
        }
        if ($user_id != $this->session->userdata('user_id')) {
            redirect(base_url());
            exit;
        } else {
            
            // if ($response->status_code === 200) {
                // $data['treatment'] = json_decode($response->body, true);
                $data['id'] = $id;
                $this->load->view('layouts/header');
                $this->load->view('statistic/statistic_detail_treatment',$data);
                $this->load->view('layouts/footer');
            // } else {
            //     notif('error', 'Treatment Invalid', 'Please contact your admin');
            // }
        }
    }

    public function getHistory($id)
    {
        $user_id = $this->session->userdata('user_id');
        $response = Requests::GET($this->API . 'treatment/get/history/' . $user_id ."/" . $id . '?token=' . $this->session->userdata('TOKEN'));
        $data = json_decode($response->body, true);
        echo json_encode($data);
    }
}