<?php 
    function token_data($token){
        global $db;

        $verify = array();
        $detoken = json_decode(base64_decode($token), true);
        $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users where id = "' .(int)$detoken['id']. '"'));

        if(trim(empty($token))){
            $verify['error'] = 1;
        }

        if(empty($user)){
            $verify['error'] = 1;
        }

        if(!password_verify(mysqli_real_escape_string($db, $detoken['pass']), $user['pass'])){
            $verify['error'] = 1;
        }

        if(trim(empty($detoken['id'])) or trim(empty($detoken['pass']))){
            $verify['error'] = 1;
        }

        if(empty($verify['error'])){
            $verify['error'] = 0;
            $verify['id'] = (int)$detoken['id'];
            return $verify;
        } else {
            return $verify;
        }
    } 
?>