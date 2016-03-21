<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
//		$this->load->view('home_view');
                 //load model
                $this->load->model('home_model');

                //get data from the database
                $data['users'] = $this->home_model->get_users();
                

                //load view and pass the data
                $this->load->view('home_view', $data);
	}
}
