<?php 
    if(!empty($users)):
    foreach($users as $usr): 
//    echo json_encode($usr['name']); 
    endforeach;
    endif;  
    echo json_encode($users);
?>