<?php

/**
 * Description of Question
 *
 * @author ketan
 */
class Question extends CI_Controller {
    
    function ans($user_id, $ques_id, $ans){
        $this->load->model('ques_model');
        $result = $this->ques_model->set_answer($user_id, $ques_id, $ans);
        echo json_encode($result);
    }
    
}
