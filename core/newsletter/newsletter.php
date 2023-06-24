<?php
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    
    require "/var/www/WikiFine/core/functions.php";
    require "/var/www/WikiFine/conf.inc.php";
    require '/var/www/WikiFine/core/vendor/autoload.php';

    $data = file_get_contents('/var/www/secrets/secrets.json');

    $obj = json_decode($data);

    $connection = connectDB();
    $query = $connection->query('SELECT pseudo, email FROM '.DB_PREFIX.'USER WHERE newsletter=1');
    $result = $query->fetchAll();

    $mailsObjectsList = [
        "Plongez dans les mystères du savoir avec notre sélection spéciale - Newsletter de WikiFine",
        "Explorez le monde de la connaissance avec nos articles passionnants - Newsletter de WikiFine",
        "Découvrez ce que vous avez toujours voulu savoir au fond de vous - Newsletter de WikiFine"
    ];
    
    $connection = connectDB();
    $query = $connection->query("SELECT id, title, content, img, author FROM ".DB_PREFIX."ARTICLE");
    $articles = $query->fetchAll();

    $articlesId = Array();

    foreach($articles as $article) {
        $articlesId[] = $article['id'];
    }

    $ids = array_rand($articlesId, 2);

    $query = $connection->query("SELECT title, content, img, author FROM ".DB_PREFIX."ARTICLE WHERE id IN (".$ids[0].", ".$ids[1].")");
    $articlesData = $query->fetchAll();

    echo "<pre>";
    print_r($articlesData);
    echo "</pre>";
    
    foreach($result as $user) {
        $mail = new PHPMailer(true);

        $mailBody = '<!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Tour Eiffel</title>
                        </head>
                        <body>
                        <center>
                            <a href="www.wikifine.org"><img src="https://drive.google.com/uc?id=1NMNel1OLhMk-XW22pAGLg2ZRvIznSSNo" alt="Logo WikiFine"></a><br><br><br>
                            <h1>Petit cadeau pour égayer ton lundi matin '.$user['pseudo'].' !</h1><br>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 400px; margin-bottom: 150px;">
                                <tr>
                                    <td align="center" style="background-color: #90B8F8; border-radius: 15px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td align="center" style="padding: 20px;">
                                                    <img src="'.$articlesData[0]['img'].'" alt="Image de couverture" width="160" height="160" style="border-radius: 80px; object-fit: cover; filter: drop-shadow(8px 8px 8px rgba(0, 0, 0, 0.3));">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding: 20px;">
                                                    <h1 style="margin: 0; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); color: #FFFFFE;">'.$articlesData[0]['title'].'</h1>
                                                    <p style="margin: 0;"><u style="color: #FFFFFE;">par ZACK7870</u></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding: 20px 20px 0 20px; border-top: 2px solid #FFFFFE;">
                                                    <p style="margin: 0; color: #FFFFFE;">'.substr($articlesData[0]['content'], 0, 250).'...</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center" style="padding: 20px;">
                                                    <a href="https://wikifine.org/pages/articles/articles.php?id='.$ids[0].'" style="display: inline-block; width: 120px; height: 50px; line-height: 50px; text-align: center; background-color: #FFFFFE; color: #90B8F8; font-weight: bold; font-size: 20px; text-decoration: none; border-radius: 50%">Lire Plus</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br><br><br>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 400px; margin-bottom: 50px;">
                                <tr>
                                    <td align="center" style="background-color: #90B8F8; border-radius: 15px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td align="center" style="padding: 20px;">
                                                    <img src="'.$articlesData[0]['img'].'" alt="Image de couverture" width="160" height="160" style="border-radius: 80px; object-fit: cover; filter: drop-shadow(8px 8px 8px rgba(0, 0, 0, 0.3));">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding: 20px;">
                                                    <h1 style="margin: 0; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); color: #FFFFFE;">'.$articlesData[1]['title'].'</h1>
                                                    <p style="margin: 0;"><u style="color: #FFFFFE;">par ZACK7870</u></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding: 20px 20px 0 20px; border-top: 2px solid #FFFFFE;">
                                                    <p style="margin: 0; color: #FFFFFE;">'.substr($articlesData[1]['content'], 0, 250).'...</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center" style="padding: 20px;">
                                                    <a href="https://wikifine.org/pages/articles/articles.php?id='.$ids[1].'" style="display: inline-block; width: 120px; height: 50px; line-height: 50px; text-align: center; background-color: #FFFFFE; color: #90B8F8; font-weight: bold; font-size: 20px; text-decoration: none; border-radius: 50%">Lire Plus</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br><br><br>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 0; padding-bottom: 0;">
                                <tr>
                                    <td align="center" style="background-color: #90B8F8; border-radius: 15px;">
                                        <a href="https://wikifine.org" style="color: #FF601C; font-size: 20px; text-decoration:none;">Aller sur WikiFine</a><br>
                                        <a href="https://wikifine.org" style="color: #EE3939; font-size: 15px; text-decoration:none;">Cliquez ici si vous souhaitez vous désabonner de notre newsletter 😢</a><br>
                                        <i>Ce mail a été généré automatiquement, merci de ne pas y répondre.</i>
                                    </td>
                                </tr>
                            </table>
                            </center>
                        </body>
                        </html>';

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = $obj[0]->HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = $obj[0]->USERNAME;
            $mail->Password   = $obj[0]->SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $obj[0]->PORT;
    
            //Recipients
            $mail->setFrom($obj[0]->USERNAME, $obj[0]->ADRESS_NAME);
            $mail->addAddress($user['email']);
    
            //Content
            $mail->isHTML(true);
            $mail->Subject = $mailsObjectsList[array_rand($mailsObjectsList)];
            $mail->Body    = $mailBody;
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        } catch (Exception $e) {
            echo "Erreur dans l'envoi du mail";
        }
    }
?>