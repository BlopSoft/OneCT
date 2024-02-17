<?php 
    require_once "../include/config.php";
    include '../include/user.php';

    $user_id = $_SESSION['user']['user_id']; 
    $owner_id = mysqli_query($db, 'SELECT yespost FROM users WHERE id =' .(int)$_REQUEST['owner_id']);
    $error = 0;
    $errorimg = 0;

    if(token_data($_SESSION['user']['access_token'])['error'] == 0){

        if(empty(trim(strip_tags($_REQUEST['text']))) and empty($_FILES['file']['tmp_name'])){
            http_response_code(400);
            $_SESSION['error'] = 'У вас нету текста!';
            header("Location: " .$_SERVER['HTTP_REFERER']);
            $error = "Bad request / No text";
        }  

        if((int)$_REQUEST['owner_id'] != $user_id){
            if(mysqli_fetch_assoc($owner_id)['yespost'] == 0) {
                http_response_code(400);
                $error = "Bad request / Access Denied";
            }  
        }
    
        if(empty(trim($_REQUEST['owner_id']))){
            http_response_code(400);
            $error = "Bad request / No owner id";
        }  

        if($enable_antispam == true){
            $recent = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM post WHERE id_who =  " .(int)$user_id. " ORDER BY date DESC"));
            $date = round((time() - $recent['date']));
            
            if($date <= $antispam){
                http_response_code(400);
                $error = "Bad request / Anti Spam";
                $_SESSION['error'] = 'Вы можете писать через ' .$antispam - $date. ' секунд';
                header("Location: " .$_SERVER['HTTP_REFERER']);
            }  
        }

        // Загрузка

        function fuckimg($src, $width, $height){
            global $_FILES, $error, $errorimg;

            if($_FILES['file']['type'] == 'image/jpeg'){
                $file = imagecreatefromjpeg($src);
            } elseif($_FILES['file']['type'] == 'image/png'){
                $file = imagecreatefrompng($src);
            } elseif($_FILES['file']['type'] == 'image/bmp'){
                $file = imagecreatefrombmp($src);
            } elseif($_FILES['file']['type'] == 'image/gif'){
                $file = imagecreatefromgif($src);
            } elseif($_FILES['file']['type'] == 'image/webp'){
                $file = imagecreatefromwebp($src);
            } else {
                $errorimg = 1;
                $error = "Bad request / Bad image"; 
            }

            $imgwidth= imagesx($file);
            $imgheight= imagesy($file);
            
            if(($imgheight / $imgwidth) >= 2.5){
                $errorimg = 1;
                $error = "Bad request / Bad image"; 
            } 
            
            if($errorimg == 0){
                $imgwidth= imagesx($file);
                $imgheight= imagesy($file);
    
                if($width == 0){
                    $width = ($height / $imgwidth) * $imgheight;
                } elseif($height == 0){
                    $height = ($width / $imgheight) * $imgwidth;
                }
    
                $size = imagecreatetruecolor((int)$height, (int)$width);
    
                imagecopyresampled($size, $file, 0, 0, 0, 0, (int)$height, (int)$width,  imagesx($file), imagesy($file));
    
                $filesrc = '../cdn/' .uniqid(). '.jpg';
    
                imagejpeg($size, $filesrc, 80);

                return $filesrc;
    
                imagedestroy($file);
                imagedestroy($size);
            } else {
                http_response_code(400);
                echo "Bad request / File error";
            }
        }

        // Конец этого

        if($error == 0 or $errorimg == 0){
            if($_FILES['file']['error'] != 0){
                $post = "INSERT INTO post(id_user, id_who, post, date) VALUES (
                    '" .(int)$_REQUEST['owner_id']. "',
                    '" .(int)$user_id. "',
                    '" .mysqli_real_escape_string($db, strip_tags($_REQUEST['text'])). "',
                    '" .time(). "'
                )";
            } else {
                $post = "INSERT INTO post(id_user, id_who, post, date, img) VALUES (
                    '" .(int)$_REQUEST['owner_id']. "',
                    '" .(int)$user_id. "',
                    '" .mysqli_real_escape_string($db, strip_tags($_REQUEST['text'])). "',
                    '" .time(). "',
                    '" .fuckimg($_FILES['file']['tmp_name'], 0, 640). "'
                )";
            }
            
            if(mysqli_query($db, $post)){
                header("Location: " .$_SERVER['HTTP_REFERER']);
            }
            
        } else {
            http_response_code(400);
            header("Location: " .$_SERVER['HTTP_REFERER']);
        }
    } else {
        http_response_code(400);
        $error = "Bad request / token";
    }

    echo($error);
?>