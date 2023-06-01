<?php
    require '../../conf.inc.php';
    session_start();

    $cpt = 0;
    $move = FILE_PREFIX."img/captcha";

    if($_FILES["captcha"]["size"] > 0){
        $extension_upload = strtolower(substr(strrchr($_FILES['captcha']['name'], '.'), 1));
        $picture = imagecreatefromstring(file_get_contents($_FILES['captcha']["tmp_name"]));
        $new_height = 900;
        $new_width = 900;
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $picture, 0, 0, 0, 0, $new_width, $new_height, imagesx($picture), imagesy($picture));
        
        imagepng($new_image, "../../img/captcha/captcha_src/captcha.png");

        $cpt = 0;
        for($cpt0 = 0; $cpt0 < 3; $cpt0++) {
            for($cpt1 = 0; $cpt1 < 3; $cpt1++) {
                $little_square = imagecreatetruecolor(300, 300);
                imagecopyresampled($little_square, $new_image, 0, 0, 300 * $cpt1, 300 * $cpt0, 300, 300, 300, 300);
                imagepng($little_square, "../../img/captcha/captcha_cut/captcha".$cpt.".png");
                imagedestroy($little_square);
                $cpt++;
            }
        }

        imagedestroy($picture);
        
    }

    header("Location: ../../nebula/captcha.php");

?>