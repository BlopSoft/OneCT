<?php 
    ini_set('display_errors', true); // Скрываем рукожопость автора

    require_once "config.php";

    class user{
        // Это же твой профиль

        function profile($token){
            global $db, $url;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    // Ты не фигел?
                    http_response_code(403);
                    $response = array(
                        'error' => 'Bad token'
                    );
                } else {
                    // Узнаём про тебя

                    $user_data = $get_user_token->fetch();

                    $response = array(
                        'id' => (int)$user_data['id'],
                        'email' => $user_data['email'],
                        'username' => $user_data['name'],
                        'description' => $user_data['descr'],
                        'ban' => boolval($user_data['ban']),
                        'openwall' => boolval($user_data['yespost']),
                        'privilege' => (int)$user_data['priv']
                    );

                    if(!empty($user_data['img'])){
                        $response['img'] = $url . substr($user_data['img'], 2);
                        $response['img50'] = $url . substr($user_data['img50'], 2);
                        $response['img100'] = $url . substr($user_data['img100'], 2);
                        $response['img200'] = $url . substr($user_data['img200'], 2);
                    }
                }
            } else{
                http_response_code(403);
                $response = array(
                    'error' => 'Bad token'
                );
            }

            return $response;
        }

        // Узнаём другим

        function getuser($id){
            global $db, $url;
            $response = array();

            if(empty($id)){
                // Где ИДшнки?
                http_response_code(403);
                $response = array(
                    'error' => 'No user IDs'
                );
            } else {
                // Бабах
                $user_ids = explode(',', $id);

                $i=0;

                // Сам разберёшься

                foreach($user_ids as &$ids){
                    $user_data = $db->query("SELECT * FROM users WHERE id = '" .(int)$ids. "'")->fetch();
                    
                    if(!empty($user_data)){
                        $response[$i] = [
                            'id' => (int)$ids,
                            'username' => $user_data['name'],
                            'description' => $user_data['descr'],
                            'ban' => boolval($user_data['ban']),
                            'openwall' => boolval($user_data['yespost']),
                            'privilege' => (int)$user_data['priv']
                        ];

                        if(!empty($user_data['img'])){
                            $response[$i]['img'] = $url . substr($user_data['img'], 2);
                            $response[$i]['img50'] = $url . substr($user_data['img50'], 2);
                            $response[$i]['img100'] = $url . substr($user_data['img100'], 2);
                            $response[$i]['img200'] = $url . substr($user_data['img200'], 2);
                        }
                    }else{
                        $response[$i] = [
                            'id' => (int)$ids,
                            'username' => "Not found"
                        ];
                    }

                    $i++;

                }
            }

            return $response;
        }

        // Изменяем твой профиль

        function change($token, $name, $desc, $wall){
            global $db;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    // Ты не фигел?

                    http_response_code(403);
                    $response = array(
                        'error' => 'Bad token'
                    );
                } else {
                    $user_data = $get_user_token->fetch();

                    $username = "";
                    $open_wall = "";

                    // Проверяем твою бездарность
                    
                    if(empty(trim($name))){
                        $username = "'{$user_data['name']}'";
                    } else {
                        $username = $db->quote($name);
                    }
                    
                    if((int)$wall >= 1){
                        $open_wall = 1;
                    } else {
                        $open_wall = 0;
                    }

                    // Мы поняли что ты написал

                    $query = "UPDATE users SET 
                        name = " .$username. ",
                        descr = " .$db->quote($desc). ",
                        yespost = " .(int)$open_wall. " WHERE id = " .$user_data['id'];

                    if($db->query($query)){
                        $response = array(
                            'ok'
                        );
                    } else{
                        http_response_code(500);
                        $response = array(
                            'error' => 'Server error'
                        );
                    }

                }
            } else{
                http_response_code(403);

                $response = array(
                    'error' => 'Bad token'
                );
            }

            return $response;
        }

        function avatar($token){
            global $db;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $img = $get_user_token->fetch();

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    // Ты не фигел?

                    http_response_code(403);
                    $response = array(
                        'error' => 'Bad token'
                    );
                } else{
                    $error = 0;

                    if(empty($_FILES['file']['tmp_name'])){
                        $error = 1;
                        $response = array('error' => 'Image not found');
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
                            http_response_code(400);
                            $error = 1; 
                        }
                        
                        $imgwidth= imagesx($file);
                        $imgheight= imagesy($file);
                        
                        if(($imgheight / $imgwidth) >= 1.5){
                            http_response_code(400);
                            $error = 1; 
                        } elseif(($imgheight / $imgwidth) <= 0.9){
                            http_response_code(400);
                            $error = 1;
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
                        }
                    }

                    // Омагад, костыли
                    if(!empty($_FILES)){
                        if($_FILES['file']['error'] == 0){
                            if(!unlink(fuckimg($_FILES['file']['tmp_name'], 0, 50))){
                                $error = 1;
                                $response = array('error' => 'Bad image');
                            }
                        }
                    }

                    if($error == 0){
                        if(empty($img['img'])){
                            unlink($img['img50']);
                            unlink($img['img100']);
                            unlink($img['img200']);
                            unlink($img['img']);
                        } 

                        $db->query("UPDATE users SET 
                            img50='" .fuckimg($_FILES['file']['tmp_name'], 0, 50). "',
                            img100='" .fuckimg($_FILES['file']['tmp_name'], 0, 100). "',
                            img200='" .fuckimg($_FILES['file']['tmp_name'], 0, 200). "',
                            img='" .fuckimg($_FILES['file']['tmp_name'], 0, 400). "' 
                            WHERE id = " .$img['id']);

                        $response = array(1);
                    }
                }
            } else{
                http_response_code(403);

                $response = array(
                    'error' => 'Bad token'
                );
            }

            return $response;
        }
    }

    if(isset($_REQUEST['method'])){
        header('Content-Type: application/json');

        $user = new user();

        switch($_REQUEST['method']){
            case 'profile':
                echo json_encode($user->profile($_REQUEST['token']));
                break;
            case 'getuser':
                echo json_encode($user->getuser($_REQUEST['id']));
                break;
            case 'change':
                echo json_encode($user->change($_REQUEST['token'], $_REQUEST['name'], $_REQUEST['desc'], $_REQUEST['wall']));
                break;
            case 'avatar':
                echo json_encode($user->avatar($_REQUEST['token']));
                break;
            default:
                http_response_code(400);
                echo json_encode(array('error' => 'Invalid method'));
                break;
        }
    }

    $db = null;