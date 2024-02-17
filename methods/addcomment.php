<?php 
    require_once "../include/config.php";
    include '../include/user.php';

    $user_id = $_SESSION['user']['user_id']; 
    $owner_id = mysqli_query($db, 'SELECT yespost FROM users WHERE id =' .(int)$_REQUEST['owner_id']);

    if(token_data($_SESSION['user']['access_token'])['error'] == 0){
        $error = 0;

        if(empty(trim(strip_tags($_REQUEST['text'])))){
            http_response_code(400);
            $_SESSION['error'] = 'У вас нету текста!';
            header("Location: " .$_SERVER['HTTP_REFERER']);
            $error = "Bad request / No text";
        }  
    
        if(empty(trim($_REQUEST['post_id']))){
            http_response_code(400);
            $error = "Bad request / No post id";
        }  

        if($enable_antispam == true){
            $recent = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM comments WHERE user_id =  " .(int)$user_id. " ORDER BY date DESC"));
            $date = time() - $recent['date'];
            
            if($date <= $antispam){
                http_response_code(400);
                $error = "Bad request / Anti Spam";
                $_SESSION['error'] = 'Вы можете писать через ' .$antispam - $date. ' секунд';
                header("Location: " .$_SERVER['HTTP_REFERER']);
            }  
        }


        // Конец этого

        if($error == 0){
            $post = "INSERT INTO comments(post_id, user_id, text, date) VALUES (
                '" .(int)$_REQUEST['post_id']. "',
                '" .(int)$user_id. "',
                '" .mysqli_real_escape_string($db, strip_tags($_REQUEST['text'])). "',
                '" .time(). "'
            )";
            
            if(mysqli_query($db, $post)){
                header("Location: " .$_SERVER['HTTP_REFERER']);
            }
            
        }
    } else {
        http_response_code(400);
        $error = "Bad request / token";
    }

    echo($error);
?>