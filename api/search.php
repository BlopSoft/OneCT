<?php 
    ini_set('display_errors', false); // Скрываем рукожопость автора

    require_once "config.php";

    class search{
        function get($query, $page){
            global $db, $url;
            $response = array();

            $qq = $db->query("SELECT * FROM users WHERE name LIKE " .$db->quote("%" .$query. "%"). " ORDER BY id DESC LIMIT 10 OFFSET " .(int)$page * 50);

            $i = 0;
            while($list = $qq->fetch(PDO::FETCH_ASSOC)){
                $response[$i] = [
                    'id' => (int)$list['id'],
                    'username' => $list['name'],
                    'privilege' => (int)$list['priv']
                ];

                if(!empty($list['img'])){
                    $response[$i]['img'] = $url . substr($list['img'], 2);
                    $response[$i]['img50'] = $url . substr($list['img50'], 2);
                    $response[$i]['img100'] = $url . substr($list['img100'], 2);
                    $response[$i]['img200'] = $url . substr($list['img200'], 2);
                }

                $i++;
            }

            return $response;
        }
    }

    if(isset($_REQUEST['method'])){
        header('Content-Type: application/json');

        $search = new search();

        switch($_REQUEST['method']){
            case 'get':
                echo json_encode($search->get($_REQUEST['q'], $_REQUEST['p']));
                break;
            default:
                http_response_code(400);
                echo json_encode(array('error' => 'Invalid method'));
                break;
        }
    }

    $db = null;