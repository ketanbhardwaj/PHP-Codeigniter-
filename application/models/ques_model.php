<?php

/**
 * Description of ques_model
 *
 * @author ketan
 */
class ques_model extends CI_Model {
    
    function set_answer($user_id, $ques_id, $ans){
        $data=array(
            'user_id'=>$user_id,
            'ques_id'=>$ques_id,
            'ans'=>$ans,
        );
        
        try{
            if($this->check_question($ques_id, $user_id)){
                if($this->update_answer($ques_id, $ans, $user_id)){
                    return array('status'=>'0', 'data'=>'Answer Updated Successfully');
                }else{
                    return array('status'=>'0', 'data'=>'Something went wrong!');    
                }
                
            }else{
                $result = $this->db->insert('answers',$data);
                if($result){
                    return array('status'=>'1', 'data'=>'Answer Submitted Successfully');
                }else{
                    return array('status'=>'0', 'data'=>'Something went wrong!');
                }    
            }
            
        } catch (Exception $ex) {
            return array('status'=>'0', 'data'=>$ex);
        }
        
    }
    
    function check_question($id, $user_id){
        $this->db->select('*');
        $this -> db -> from('answers');
        $this -> db -> where('ques_id', $id);
        $this -> db -> where('user_id', $user_id);
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    function update_answer($ques_id, $ans, $user_id){
        $this->db->set('ans', $ans);
        $this->db->where('ques_id', $ques_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->update('answers');
        if($result){
            return true;
        }else{
            return false;
        }
    }
    
}
