<?php
    require '../../conf.inc.php';
    require '../functions.php';
    session_start();

    $cpt = 0;
    $move = FILE_PREFIX."img/captcha";

    if($_FILES["img"]["size"] > 0){

        $extension_upload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
        $picture = imagecreatefromstring(file_get_contents($_FILES['img']["tmp_name"]));
        $new_height = 900;
        $new_width = 900;
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $picture, 0, 0, 0, 0, $new_width, $new_height, imagesx($picture), imagesy($picture));
        
        $alias = time()."_".uniqid();
        imagepng($new_image, "../../img/captcha/captcha_src/".$alias.".png");

        $cpt = 0;
        mkdir("../../img/captcha/captcha_cut/".$alias, 0777);
        for($cpt0 = 0; $cpt0 < 3; $cpt0++) {
            for($cpt1 = 0; $cpt1 < 3; $cpt1++) {
                $little_square = imagecreatetruecolor(300, 300);
                imagecopyresampled($little_square, $new_image, 0, 0, 300 * $cpt1, 300 * $cpt0, 300, 300, 300, 300);
                imagepng($little_square, "../../img/captcha/captcha_cut/".$alias."/captcha".$cpt.".png");
                imagedestroy($little_square);
                $cpt++;
            }
        }

        imagedestroy($picture);
        
        $connect = connectDB();
        $resultId = getData(Array('id'), $_SESSION['id']);
        $query = $connect->query('INSERT INTO '.DB_PREFIX.'CAPTCHA (name, alias, author) VALUES ("'.$_POST['name'].'", "'.$alias.'", '.$resultId[0].')');

    }

    header("Location: ../../nebula/captcha.php");

?>
