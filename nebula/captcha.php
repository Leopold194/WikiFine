<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/captcha.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<?php 

    $connect = connectDB();
    $results = $connect->query("SELECT * FROM ".DB_PREFIX."CAPTCHA");
    $listOfCaptcha = $results->fetchAll();
    if(isset($_SESSION['previousGet'])){
        unset($_SESSION['previousGet']);
    }
    
    $maxPage = ceil(count($listOfCaptcha) / 10);

    if(isset($_POST['id'])){
        $connect = connectDB();
        if($_POST['action'] == "Supprimer"){
            if(count(scandir('../img/captcha/captcha_src')) - 2 == 1) {
                $error = "<li>Vous devez garder au moins 1 captcha !</li>";
            }else {
                $queryPrepared = $connect->prepare("DELETE FROM ".DB_PREFIX."CAPTCHA WHERE id=:id");
                $queryPrepared->execute(['id'=>$_POST['id']]); 
                header("Location: captcha.php");
            }
        }elseif($_POST['action'] == "Visualiser"){
            ?>
            <div class="captchaPreview">
                <img class="previewClose" src="../img/other/white_cross.png" alt="Fermer le captcha">
                <img src="<?php echo "../img/captcha/captcha_src/".$_POST['alias'].".png" ?>" alt="Captcha">
            </div>
            <?php
        }
        
    }

    if(isset($_POST['arrowLeft']) && $_SESSION['currentPage'] > 1){
        $_SESSION['currentPage']--;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowLeft']);
        header('Location: captcha.php');
    }

    if(isset($_POST['arrowRight']) && $_SESSION['currentPage'] < $maxPage){
        $_SESSION['currentPage']++;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowRight']);
        header('Location: captcha.php');
    }

?>

<form method="POST" action="../core/nebula/add_captcha.php" enctype="multipart/form-data">
    <div class="popup popupClose">
        <img src="../img/other/cross.png" alt="Fermer" class="closePopup" id="closePopupId">
        <p class="popupTitle">Ajouter un captcha</p>
        <div class="inputColumn namePopup">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" class="textInput">
        </div>
        <div class="inputColumn imgPopup">
            <input type='file' name='img' id="img"><label for="img" id="imgLabel">+</label>
        </div>
        <div class="sendBtn">
            <button type="submit">Envoyer</button>
        </div>
    </div>
</form>


<div class="pageBody">
    <div class="pageBodyHeader">
        <h1 class="pageTitle">Liste des Captcha :</h1>
        <div class="addCaptcha">+</div>
    </div>
    <?php
        if(!empty($error)) {
            echo "<div class='alert'>";
            echo $error;
            echo "</div>";
            $error = '';
        }
    ?>
    <div class="userTable">
        <div class="userTableHeader">
            <p class="number">N°</p>
            <p class="name">Nom</p>
            <p class="author">Mis en place par</p>
            <p class="action">Action</p>
        </div>

        <?php 
            
            $tempListOfCaptcha = array_slice($listOfCaptcha, 10 * ($_SESSION['currentPage'] - 1), 10);

            $cpt = 1;
            foreach($tempListOfCaptcha as $captcha) {
        ?>

        <div class="userTableRow">
            <div class="number"><?php echo $cpt ?></div>
            <div class="name"><?php echo $captcha['name'] ?></div>
            <div class="author">
            <?php 
                $query = $connect->query("SELECT pseudo FROM ".DB_PREFIX."USER WHERE id=".$captcha['author']);
                $author = $query->fetch();
                echo $author['pseudo'];
            ?>
            </div>
            <form method="POST">
                <div class="action">
                    <input type="hidden" name="id" value="<?php echo $captcha['id'] ?>">
                    <input type="hidden" name="alias" value="<?php echo $captcha['alias'] ?>">
                    <input type="submit" class="see" name="action" value="Visualiser">
                    <input type="submit" class="del" name="action" value="Supprimer">
                </div>
            </form>
        </div>

    <?php 
            $cpt++;
        }
        if(count($listOfCaptcha) > 10){
    ?>
        <form method="POST"> 
            <div class="arrowChangePage">
                <div class="arrowLeft">
                    <input type="submit" name="arrowLeft" value="">
                    <img src="../img/other/arrow_left.png" alt="Page précédente" id="previous">
                </div>
                <p><?php echo $_SESSION['currentPage']; ?> / <?php echo $maxPage; ?></p>
                <div class="arrowRight">
                    <input type="submit" name="arrowRight" value="">
                    <img src="../img/other/arrow_right.png" alt="Page suivante" id="next">
                </div>
            </div>
        </form>
    <?php
    }
    ?>

    </div>

</div>
<script>
    const addCategoryBtn = document.querySelector('.addCaptcha');
    const popup = document.querySelector('.popup');

    addCategoryBtn.addEventListener('click', () => {
        popup.classList.toggle('popupClose');
    })

    const cross = document.getElementById("closePopupId");

    cross.addEventListener("click", () => {
        popup.classList.toggle("popupClose");
    })

    const input = document.getElementById("img");
    const preview = document.querySelector(".imgPopup");
    const label = document.getElementById("imgLabel");

    input.addEventListener("change", function () {
        const file = this.files[0];
        
        if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.style.backgroundImage = "url('" + reader.result + "')";
            preview.style.backgroundSize = "contain";
            preview.style.backgroundPosition = "center";
            preview.style.backgroundRepeat = "no-repeat";
            preview.style.backgroundColor = "#ffffff";
            label.style.display = "none";
        });

        reader.readAsDataURL(file);
        }
    });

    const previewClose =document.querySelector('.previewClose');

    previewClose.addEventListener('click', () => {
        document.location.href = 'captcha.php';
    });

</script>
</body>
</html>