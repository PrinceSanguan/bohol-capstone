<?php
function filteration($data){
    foreach($data as $key =>$value){
        $data[$key] =  trim($value);
        $data[$key] =  stripslashes($value);
        $data[$key] =  htmlspecialchars($value);
        $data[$key] =  strip_tags($value);
       
    }
    return $data;
}
?>