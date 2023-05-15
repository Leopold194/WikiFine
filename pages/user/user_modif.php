<?php 
    session_start();
    require '../../core/functions.php';
?>

<?php require '../../conf.inc.php'; ?>
<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/user/user.css'>
<?php require '../templates/navbar.php'; ?>

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

</body>
</html>