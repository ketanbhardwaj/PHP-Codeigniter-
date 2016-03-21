<?php

/**
 * Description of home_model
 *
 * @author ketan
 */
class home_model extends CI_Model{
    
    function get_users(){
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $result = $query->result_array();
            return $result;
        }else{
            echo "No Users Found";
            return false;
        }
    }
    
}

?>