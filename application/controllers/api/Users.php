<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
//		$this->load->view('home_view');
                 //load model
                $this->load->model('users_model');

                //get data from the database
                $data['user'] = $this->users_model->get_users();
//                $data['status'] = 1;
                echo json_encode($data);
                //echo "<pre>";
                
//                print_r($data);
                echo "<br><br>";
                //load view and pass the data
                //$this->load->view('users_view', $data);
	}
        
        function reset($email){
            $this->load->model('users_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email');
            
            if($this->form_validation->run() == FALSE){
                $invalid = array('data'=> 'Parameter Missing', 'status'=>'0');
                echo json_encode($invalid);
            }else{
                $data = $this->users_model->do_forget();
                echo json_encode($data);
            }
            
        }
        
        function ketan(){
           $this->load->model('users_model');   
           $result = $this->users_model->do_forget();
           echo json_encode($result);
            
        }
        
        function login(){
            $this->load->model('users_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
            
            if($this->form_validation->run() == FALSE){
                $invalid = array('data'=> 'Parameter Missing', 'status'=>'0');
                echo json_encode($invalid);
            }else{
                $data = $this->users_model->verify_login();
                echo json_encode($data);
            }
            
        }
        
        function register(){
            $this->load->library('form_validation');
            $this->load->helper(array('form'));
//            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('region', 'Region', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
            $this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required|matches[password]');

            if($this->form_validation->run() == FALSE){
                $invalid['data'] = array('Paramters Missing');
                echo json_encode($invalid);
            }else{
                $this->load->model('users_model');
                $result = $this->users_model->add_user();
                echo json_encode($result);
            }
        }
        
}
