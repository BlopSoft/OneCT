<?php 
    require_once "../include/config.php";
    include '../include/user.php';

    $user_id = $_SESSION['user']['user_id']; 
    $owner_id = mysqli_query($db, 'SELECT yespost FROM users WHERE id =' .(int)$_REQUEST['owner_id']);

    if(token_data($_SESSION['user']['access_token'])['error'] == 0){
        $error = 0;

        if(empty(trim(strip_tags($_REQUEST['text']))) and empty($_FILES['file']['tmp_name'])){
            $_SESSION['error'] = 'У вас нету текста!';
            $error = "Bad request / No text";
        }  

        if((int)$_REQUEST['owner_id'] != $user_id){
            if(mysqli_fetch_assoc($owner_id)['yespost'] == 0) {
                $error = "Bad request / Access Denied";
            }  
        }
    
        if(empty(trim($_REQUEST['owner_id']))){
            $error = "Bad request / No owner id";
        }  

        if($enable_antispam == true){
            $recent = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM post WHERE id_who =  " .(int)$user_id. " ORDER BY date DESC"));
            $date = round((time() - $recent['date']));
            
            if($date <= $antispam){
                $error = "Bad request / Anti Spam";
                $_SESSION['error'] = 'Вы можете писать через ' .$antispam - $date. ' секунд';
                header("Location: " .$_SERVER['HTTP_REFERER']);
            }  
        }

        // Загрузка

        function fuckimg($src, $width, $height){
            global $_FILES, $error;

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
                $error = "Bad request / File error";
            }
    
            if($error == 0){
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
                return $error;
            }
        }

        // Конец этого

        if($error == 0){
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
            
        }
    } else {
        $error = "Bad request / token";
    }

    echo($error);
?>