<?php
session_start();
require '../../conf.inc.php';
require '../templates/head.php';
require '../../core/functions.php';

if (
    !(isset($_SERVER['HTTP_REFERER']) &&
        ($_SERVER['HTTP_REFERER'] === LINK_PREFIX . 'core/register_login/register_user.php'
            || $_SERVER['HTTP_REFERER'] === LINK_PREFIX . 'pages/register_login/email_confirm.php'
            || $_SERVER['HTTP_REFERER'] === LINK_PREFIX . 'pages/register_login/register.php'
            || $_SERVER['HTTP_REFERER'] === LINK_PREFIX . 'pages/register_login/register.php?registerStep=/^$/'
            || $_SERVER['HTTP_REFERER'] === LINK_PREFIX . 'pages/register_login/avatar_creation.php'))
) {
    $_SESSION['register'] = 0;
}
?>

<link rel='stylesheet' href='../../css/templates/captcha_buttons.css'>
<link rel='stylesheet' href='../../css/registers/register.css'>
<script src=<?php echo FILE_PREFIX . 'js/see_password.js'; ?> defer></script>
<script src=<?php echo FILE_PREFIX . 'js/captcha.js'; ?> defer></script>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/captcha.php'; ?>

<?php
if (isset($_GET['registerStep']) && $_GET['registerStep'] < $_SESSION['register']) {
    $_SESSION['register'] = $_GET['registerStep'];
    header("Location: register.php");
}
?>

<div class="breadcrumb">
    <span class="line"></span>
    <form class="circlesForm">
        <div class="circle1 circles <?php echo ($_SESSION['register'] == 0) ? 'activeCircle' : '' ?>"><button
                name="registerStep" value="0" class="breadcrumbCircle">
                <p>1</p>
            </button></div>
        <div class="circle2 circles <?php echo ($_SESSION['register'] == 2) ? 'activeCircle' : '' ?>"><button
                name="registerStep" value="2" class="breadcrumbCircle">
                <p>2</p>
            </button></div>
        <div class="circle3 circles <?php echo ($_SESSION['register'] == 3) ? 'activeCircle' : '' ?>"><button
                name="registerStep" value="3" class="breadcrumbCircle">
                <p>3</p>
            </button></div>
    </form>
</div>

<div class="formTitle">
    <h1 class="title">Inscription</h1>
</div>

<?php
if ($_SESSION['register'] == 0) {
    $_SESSION['register'] = 0;
    ?>
    <div class="registerForm mb">
        <?php
        $inputState = ["firstname" => "", "lastname" => "", "email" => "", "country" => "", "tel" => "", "pwd" => "", "pwdConfirm" => ""];
        if (!empty($_SESSION['errors'])) {
            ?>
            <div class="alert">
                <?php
                foreach ($_SESSION['errors'] as $error) {
                    echo "<li>" . $error[1] . "</li>";
                    $inputState[$error[0]] = "error";
                }
                ?>
            </div>
            <?php
            unset($_SESSION['errors']);
        }
        ?>
        <form action="../../core/register_login/register_user.php" method="POST" class="formData">
            <div class="row">
                <div class="firstname field <?php echo $inputState["firstname"]; ?>">
                    <input type="text" class="inputForm" name="firstname" id="firstname" placeholder="Prénom" required>
                    <label class="placeholderLabel">Prénom</label>
                </div>
                <div class="lastname field <?php echo $inputState["lastname"]; ?>">
                    <input type="text" class="inputForm" name="lastname" placeholder="Nom" required>
                    <label class="placeholderLabel">Nom</label>
                </div>
            </div>
            <div class="email field mt <?php echo $inputState["email"]; ?>">
                <input type="email" class="inputForm" name="email" placeholder="Email" required>
                <label class="placeholderLabel">Email</label>
            </div>
            <div class="row">
                <div class="country field mt <?php echo $inputState["country"]; ?>">
                    <select class="selectForm" name="country" placeholder=" ">
                        <option value="0">+33</option>
                        <option value="1">+93</option>
                    </select>
                </div>
                <div class="tel field mt <?php echo $inputState["tel"]; ?>">
                    <input type="tel" class="inputForm" name="tel" placeholder="Téléphone" required>
                    <label class="placeholderLabel">Téléphone</label>
                </div>
            </div>
            <div class="row">
                <div class="pwd field mt <?php echo $inputState["pwd"]; ?>">
                    <input type="password" class="inputForm" id="pwd" name="pwd" placeholder="Mot de passe" required>
                    <img src="../../img/register/open_eye.png" class="eye open_eye" id="eye0">
                    <label class="placeholderLabel">Mot de passe</label>
                </div>
                <div class="pwdConfirm field mt <?php echo $inputState["pwdConfirm"]; ?>">
                    <input type="password" class="inputForm" id="pwdConfirm" name="pwdConfirm" placeholder="Confirmation"
                        required>
                    <img src="../../img/register/open_eye.png" class="eye open_eye" id="eye1">
                    <label class="placeholderLabel">Confirmation</label>
                </div>
            </div>
            <div class="rowCenter mt mb">
                <button type="submit" class="submit submitActive field" id="connBtn">CONTINUER</button>
            </div>
        </form>
    </div>
<?php
} elseif ($_SESSION['register'] == 2) {
    ?>
    <div class="registerForm mb">
        <?php
        $inputState = ["pseudo" => "", "gender" => "", "birthday" => "", "adress" => "", "country" => "", "cp" => "", "city" => ""];
        if (!empty($_SESSION['errors'])) {
            ?>
            <div class="alert">
                <?php
                foreach ($_SESSION['errors'] as $error) {
                    echo "<li>" . $error[1] . "</li>";
                    $inputState[$error[0]] = "error";
                }
                ?>
            </div>
            <?php
            unset($_SESSION['errors']);
        }
        ?>
        <form action="../../core/register_login/register_user.php" method="POST" class="formData">
            <div class="row">
                <div class="rowCenter">
                    <div class="avatar field">
                        <?php
                        $avatarUrl = isset($_SESSION['avatarRegister']) && !empty($_SESSION['avatarRegister']) ? $_SESSION['avatarRegister'] : "../../img/register/avatar.png";
                        ?>
                        <a href="avatar_creation.php">
                            <img src="<?php echo $avatarUrl; ?>" alt="avatarMenu">
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="row">
                        <div class="pseudo field tiny-mt <?php echo $inputState["pseudo"]; ?>">
                            <input type="text" class="inputForm" name="pseudo" id="pseudo" maxlength="30"
                                placeholder="Pseudonyme" required>
                            <label class="placeholderLabel">Prénom</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="birthday field mt <?php echo $inputState["birthday"]; ?>">
                            <input type="date" class="inputForm" name="birthday" placeholder="Date de naissance" required>
                            <label class="placeholderLabel">Date de naissance</label>
                        </div>
                        <div class="gender field mt <?php echo $inputState["gender"]; ?>">

                            <input type="radio" id="gender0" name="gender" checked value="0">
                            <label for="gender0">M.</label>

                            <input type="radio" id="gender1" name="gender" value="1">
                            <label for="gender1">Mme.</label>

                            <input type="radio" id="gender2" name="gender" value="2">
                            <label for="gender2">Autre</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="adress field tiny-mt <?php echo $inputState["adress"]; ?>">
                    <input type="adress" class="inputForm" name="adress" placeholder="Adresse" required>
                    <label class="placeholderLabel">Adresse</label>
                </div>
                <div class="country field tiny-mt <?php echo $inputState["country"]; ?>">
                    <input type="country" class="inputForm" name="country" placeholder="Pays" required>
                    <label class="placeholderLabel">Pays</label>
                </div>
            </div>
            <div class="row">
                <div class="cp field mt <?php echo $inputState["cp"]; ?>">
                    <input type="text" class="inputForm" name="cp" maxlength="5" placeholder="Code postal" required>
                    <label class="placeholderLabel">Code postal</label>
                </div>
                <div class="city field mt <?php echo $inputState["city"]; ?>">
                    <input type="text" class="inputForm" name="city" placeholder="Ville" required>
                    <label class="placeholderLabel">Ville</label>
                </div>
            </div>
            <div class="rowCenter mt mb">
                <button type="submit" class="submit submitActive field" id="connBtn">CONTINUER</button>
            </div>
        </form>
    </div>
    <?php
} elseif ($_SESSION['register'] == 3) {
    ?>
    <div class="registerForm mb">
        <?php
        if (!empty($_SESSION['errors'])) {
            ?>
            <div class="alert">
                <?php
                foreach ($_SESSION['errors'] as $error) {
                    echo "<li>" . $error . "</li>";
                }
                ?>
            </div>
            <?php
            unset($_SESSION['errors']);
        }
        ?>
        <h2 class="formContentTitle"><u>Selectionnez au moins 3 centres d'intérêts :</u></h2>
        <form action="../../core/register_login/register_user.php" method="POST" id="loginFormData" class="formData">
            <div class="hobbiesForm">
                <input class="" type="checkbox" id="0" name="interest[]" value="0">
                <label for="0">Histoire</label>
                <input class="" type="checkbox" id="1" name="interest[]" value="1">
                <label for="1">Technologie</label>
                <input class="" type="checkbox" id="2" name="interest[]" value="2">
                <label for="2">Musique</label>
                <input class="" type="checkbox" id="3" name="interest[]" value="3">
                <label for="3">Sciences</label>
                <input class="" type="checkbox" id="4" name="interest[]" value="4">
                <label for="4">Environnement</label>
                <input class="" type="checkbox" id="5" name="interest[]" value="5">
                <label for="5">Politique</label>
                <input class="" type="checkbox" id="6" name="interest[]" value="6">
                <label for="6">Arts</label>
                <input class="" type="checkbox" id="7" name="interest[]" value="7">
                <label for="7">Géographie</label>
                <input class="" type="checkbox" id="8" name="interest[]" value="8">
                <label for="8">Cinéma</label>
                <input class="" type="checkbox" id="9" name="interest[]" value="9">
                <label for="9">Sport</label>
                <input class="" type="checkbox" id="10" name="interest[]" value="10">
                <label for="10">Littérature</label>
                <input class="" type="checkbox" id="11" name="interest[]" value="11">
                <label for="11">Religion</label>
            </div>
            <span class="line2"></span>
            <div class="newsletter">
                <input class="" type="checkbox" id="newsletterCheck" name="newsletter" checked>
                <label for="newsletterCheck">Oui, je souhaite recevoir la newsletter de WikiFine</label>
            </div>
            <div class="cgu">
                <input type="checkbox" id="cguCheck" name="cgu" onClick="changeClass()">
                <label for="cguCheck">J’accepte les <a href="../../docs/CGU.pdf" target="_blank" class="cguLink">Conditions Générales
                        d’Utilisation</a></label>
            </div>
            <div class="rowCenter mt mb">
                <div class="captchaBtnCheckOrUncheck captchaBtnCheck tiny-mr">CAPTCHA</div>
                <div class="submit submitInactive tiny-ml" id="connBtn">S'INSCRIRE</div>
            </div>
        </form>
    </div>
    <?php
}
?>
</body>

</html>