<?php

/**
 * Description of users_model
 *
 * @author ketan
 */
class users_model extends CI_Model{
    
    function get_users(){
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $result = $query->result_array();
            return $result;
        }else{
//            echo "No Users Found";
            return false;
        }
    }
    
    function get_user_by_id($id){
        
        $this->db->where('id', $id);
        
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $result = $query->result_array();
            return $result[0];
        }else{
            $result = array('User Not Found');
            return $result[0];
        }
    }
    
    function get_user_by_email($email){
        
        $this->db->where('email', $email);
        
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $result['user'] = $query->result_array();
            return $result;
        }else{
            $result = array('User Not Found');
            return $result;
        }
    }
    
    function verify_login(){
        
        $this->db->where('email', $this->input->post('email'));
        $this->db->where('password', md5($this->input->post('password')));
        
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $result = $query->result_array();
            return array('status'=>'1', 'data'=>$result[0]);
//            return $result[0];
        }else{
            $result = array('User Not Found');
            return $result[0];
        }
    }
    
    function check_email($email){
        $this->db->select('email');
        $this -> db -> from('users');
        $this -> db -> where('email', $email);
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    function generate_referral_code(){
        $this->load->helper('string');
        $referralCode = uniqid(random_string('alnum', 5), true);
        return $referralCode;
    }
            
    function generate_random_password($id){
        $this->load->helper('string');
        $password= random_string('alnum', 10);    // Send this password to user in mail
	$this->db->where('id', $id);
	$result = $this->db->update('users',array('password'=>MD5($password)));
        if($result){
            
            $this->sendMail();
            
//            $this->load->library('email');
//		$this->email->from('ketan268@gmail.com'); 	
//                $this->email->to('ketan268@gmail.com', 'Ketan');
//		$this->email->subject('Password reset');
//		$this->email->message('You have requested the new password, Here is you new password:'. $password);	
//		$this->email->send();
//                echo $this->email->print_debugger();
                return true;
        }else 
            return false;
    }
    
    public function sendMail(){
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ketan268@gmail.com', // change it to yours
            'smtp_pass' => 'ketan268ap', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        
        $message = '';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('ketan268@gmail.com'); // change it to yours
        $this->email->to('ketan268@gmail.com');// change it to yours
        $this->email->subject('Resume from JobsBuddy for your Job posting');
        $this->email->message($message);
        if($this->email->send()) {
            echo 'Email sent.';
        }else {
            show_error($this->email->print_debugger());
        }
    }
    
    function do_forget(){
        $email = $this->input->post('email');
        if($this->check_email($email)){
            
            $this->db->select('id');
            $this -> db -> from('users');
            $this -> db -> where('email', $email);
            $query = $this->db->get();
            $result = $query->result();
//            echo $result[0]->id;
            if($this->generate_random_password($result[0]->id)){
                return array('data'=> 'Password Reset Successful!. Please Check your mail', 'status'=>'1');
            }else{
                return array('data'=> 'Something went wrong', 'status'=>'0');
            }
            
        }else{
            return array('data'=> 'Email ID Does not Exists', 'status'=>'0');
        }
        
    }
    
    function add_user(){
       
        $api_key = md5(uniqid(rand(), true));
        $referralCode = $this->generate_referral_code();
        //console.log($referralCode);
        
        $data=array(
            'first_name'=>$this->input->post('first_name'),
            'last_name'=>$this->input->post('last_name'),
            'national_id'=>$this->input->post('national_id'),
            'phone_number'=>$this->input->post('phone_number'),
            'country'=>$this->input->post('country'),
            'region'=>$this->input->post('region'),
            'email'=>$this->input->post('email'),
            'password'=>md5($this->input->post('password')),
            'api_key'=>$api_key,
            'status'=>'1',
            'role'=>'2',
            'referral_code' => $referralCode,
            'wallet_amount' => 0
        );
        
        if($this->check_email($this->input->post('email'))){
            return array('data'=> 'Email ID Already Exists', 'status'=>'0');
            //return "Email ID Already Exists";
        }else{
            $result = $this->db->insert('users',$data);
            $info = $this->get_user_by_email($this->input->post('email'));
            
            if($result){
                return array('status'=>'1', 'data'=>$this->get_user_by_email($this->input->post('email')));
            }else
                return array('status'=>'0');
        }
        
    }
    
}

?>