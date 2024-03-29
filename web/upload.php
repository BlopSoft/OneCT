<?php 
    require_once '../include/config.php';

    if(empty($_SESSION['user'])){
		header("Location: login.php");
	}

    $error = 0;

    if(isset($_POST['upload'])){
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
                $error = "1";
            }

            $imgwidth= imagesx($file);
            $imgheight= imagesy($file);
            
            if(($imgheight / $imgwidth) >= 1.5){
                $error = "1";
            } elseif(($imgheight / $imgwidth) <= 0.9){
                $error = "1";
            }

            if($error == 0){

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
            }
        }

        unlink(fuckimg($_FILES['file']['tmp_name'], 0, 50));

        if($error = 0 or $_FILES['file']['error'] == 0){
            $img = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .$_SESSION['user']['user_id']));

            if($img['img'] != NULL){
                unlink($img['img50']);
                unlink($img['img100']);
                unlink($img['img200']);
                unlink($img['img']);
            }

            mysqli_query($db, 'UPDATE users SET 
                img50="' .fuckimg($_FILES['file']['tmp_name'], 0, 50). '",
                img100="' .fuckimg($_FILES['file']['tmp_name'], 0, 100). '",
                img200="' .fuckimg($_FILES['file']['tmp_name'], 0, 200). '",
                img="' .fuckimg($_FILES['file']['tmp_name'], 0, 400). '"
                WHERE id = ' .$_SESSION['user']['user_id']);

            header("Location: $url");
        } else {
            mysqli_query($db, 'UPDATE users SET 
                img50="",
                img100="",
                img200="",
                img=""
                WHERE id = ' .$_SESSION['user']['user_id']);

            header("Location: $url");
        }
    }
?>

<?php $data = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .$_SESSION['user']['user_id'])); ?>

<html>
<head>
    <?php include '../include/html/head.php'; ?>
    <title>Загрузка аватарки</title>
</head>
<body>
    <?php include '../include/html/header.php'; ?>
    <div class="main_app">
        <div class="main">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <p>
                    <p>Новая аватарка:</p>
                    <input type="file" name="file" class="file" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp">
                </p>
                <p>
                    <button type="submit" name="upload">Изменить</button>
                </p>
            </form>
        </div>
    </div>
    <?php include "../include/html/footer.php" ?>
</body>
</html>

<?php mysqli_close($db);