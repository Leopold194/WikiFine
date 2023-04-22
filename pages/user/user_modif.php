<?php 
    session_start();
    require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/user/user.css'>
<?php require '../templates/navbar.php'; ?>

<!--<div class="pwd_modify_close" id="popup">
    <form method="POST">
        <?php 
            
            $inputState = ["previousPwd"=>"", "password"=>"", "confirmPwd"=>""];
            unset($_POST);
            /*
            if(count($_POST) == 3
                && !empty($_POST['previousPwd']) 
                && !empty($_POST['password']) 
                && !empty($_POST['confirmPwd']))
            {
                
                $listOfErrors = [];

                if( strlen($_POST["password"])<8
                    || !preg_match("#[a-z]#", $_POST["password"])
                    || !preg_match("#[A-Z]#", $_POST["password"])
                    || !preg_match("#[?!._&]#", $_POST["password"])
                    || !preg_match("#[0-9]#", $_POST["password"]))
                {
                    $inputState['password'] = "error";
                }

                if($_POST["password"] != $_POST["confirmPwd"]){
                    $inputState['confirmPwd'] = "error";
                }
                
                $connection = connectDB();
                $queryPrepared = $connection->prepare("SELECT password FROM ".DB_PREFIX."USER WHERE email=:email");
                $queryPrepared->execute([
                    "email"=>$_SESSION['id'],
                ]);
                $result = $queryPrepared->fetch();

                if(empty($result) && !password_verify($_POST['previousPwd'], $result['password'])){
                    $inputState['previousPwd'] = "error";
                }
                   

                if(empty($listOfErrors)){
                    $queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."USER SET password=:previousPwd WHERE email=:email");
                    $queryPrepared->execute([
                        "previousPwd"=>password_hash($_POST['password'], PASSWORD_DEFAULT),
                    ]);
                    $result = $queryPrepared->fetch();
                    unset($RELOAD);
                    unset($listOfErrors);
                }else{
                    $RELOAD = true;
                }
            }*/
        ?>
        <img src="../../img/other/cross.png" alt="Fermer" class="closePopup" id="closePopupId">
        <p class="popupTitle">Changer de mot de passe</p>
        <div class="inputColumnPwd <?php echo $inputState['previousPwd']; ?>">
            <label for="previousPwd">Ancien mot de passe</label>
            <input type="password" id="previousPwd" name="previousPwd">
            <span class="tooltiptext">8 caractères<br>&bull;Majuscules<br>&bull; Minuscules<br>&bull; Chiffres<br>&bull; Caractères spéciaux</span>
            <a href="../register_login/reset_password.php">Mot de passe oublié</a>
        </div>
        <div class="inputColumnPwd <?php echo $inputState['password']; ?>">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="inputColumnPwd <?php echo $inputState['confirmPwd']; ?>">
            <label for="confirmPwd">Confirmation</label>
            <input type="password" id="confirmPwd" name="confirmPwd">
        </div>
        <div class="saveButton saveButtonPwd">
            <button type="submit">Modifier</button>
        </div>
    </form>
</div>-->

<div class="navbarUser">
    <ul>
        <li><a href="">Mon compte</a></li>
        <li><a href="">Mes articles</a></li>
        <li><a href="">Messagerie</a></li>
    </ul>
</div>

<form action="../../core/user/modify_user.php" method="POST" class="" id="dataForm">
    <div class="userProfil">
        <div class="avatarAndNames">
            <img src=
                <?php 
                    $result = getData(Array('avatar_nb'), $_SESSION['id']);
                    echo "../../../img_avatar/".$result[0].".png";
                ?>
                alt="Avatar" class="avatar">
            <?php 
                $result = getData(Array('firstname', 'lastname', 'pseudo', 'phone', 'address', 'post_code', 'city', 'country', 'email'), $_SESSION['id']);
            ?>
            <div class="inputColumnGroup">
                <div class="inputColumn">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" placeholder="<?php echo ucwords($result[0]); ?>">
                </div>
                <div class="inputColumn">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" placeholder="<?php echo ucwords($result[1]); ?>">
                </div>
            </div>
        </div>
        <div class="descriptionContainer">
            <div class="description">
                <p class="descriptionTitle">Qui suis-je ?</p>
                <p class="descriptionContent"><?php 
                    $descriptionResult = getData(Array('description'), $_SESSION['id']);
                    echo $descriptionResult[0];
                ?></p>
            </div>
        </div>
    </div>

    <div class="userData">

        <?php
            $inputState = ["firstname"=>"", "lastname"=>"", "email"=>"", "country"=>"", "tel"=>"", "previousPwd"=>"", "password"=>"", "confirmPwd"=>""];
            if(!empty($_SESSION['errors'])){
        ?>
        <div class="alert">
            <?php 
                foreach($_SESSION['errors'] as $error){
                    echo "<li>".$error[1]."</li>";
                    $inputState[$error[0]] = "error";
                }
            ?>
        </div>
        <?php
            unset($_SESSION['errors']);}
        ?>

        <div class="inputColumnGroup">
            <div class="inputRow">
                <div class="inputColumn">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" placeholder="<?php echo $result[2]; ?>" class="medium">
                </div>
                <div class="inputColumn">
                    <label for="phone">Téléphone</label>
                    <input type="text" id="phone" name="phone" placeholder="<?php echo $result[3]; ?>" class="medium">
                </div>
            </div>
            <div class="inputRow">
                <div class="inputColumn">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="address" placeholder="<?php echo $result[4]; ?>" class="large">
                </div>
            </div>
            <div class="inputRow">
                <div class="inputColumn">
                    <label for="post_code">Code Postal</label>
                    <input type="text" id="post_code" name="post_code" placeholder="<?php echo $result[5]; ?>" class="small">
                </div>
                <div class="inputColumn">
                    <label for="city">Ville</label>
                    <input type="text" id="city" name="city" placeholder="<?php echo ucwords($result[6]); ?>" class="small">
                </div>
                <div class="inputColumn">
                    <label for="country">Pays</label>
                    <input type="text" id="country" name="country" placeholder="<?php echo ucwords($result[7]); ?>" class="small">
                </div>
            </div>
            <div class="inputRow">
                <div class="inputColumn">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="<?php echo $result[8]; ?>" class="large">
                </div>
            </div>
            <div class="inputRow">
                <div class="inputColumn <?php echo $inputState['previousPwd']; ?>">
                    <label for="previousPwd">Mot de passe</label>
                    <input type="password" id="previousPwd" name="previousPwd" class="small">
                    <a href="../register_login/reset_password.php" class="resetPwd">Mot de passe oublié</a>
                </div>
                <div class="inputColumn <?php echo $inputState['password']; ?>">
                    <label for="password">Nouveau</label>
                    <input type="password" id="password" name="password" class="small">
                </div>
                <div class="inputColumn <?php echo $inputState['confirmPwd']; ?>">
                    <label for="confirmPwd">Confirmation</label>
                    <input type="password" id="confirmPwd" name="confirmPwd" class="small">
                </div>
            </div>
        </div>
        <div class="saveButton">
            <button type="submit">Enregistrer</button>
        </div>
    </div>
</form>

<!--
<div class="editButton editPwd" id="editPwdId">
    <img src="../../img/other/pencil.svg" alt="Modify">
</div>
-->

</body>
</html>