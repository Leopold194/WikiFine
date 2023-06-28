<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/categories.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<?php 

    if(!isset($_GET['filter'])) {
        $connect = connectDB();
        $results = $connect->query("SELECT id, title, description, logo FROM ".DB_PREFIX."CATEGORY");
        $listOfCategories = $results->fetchAll();
        if(isset($_SESSION['previousGet'])){
            unset($_SESSION['previousGet']);
        }
    }else{
        if(isset($_SESSION['previousGet']) && $_SESSION['previousGet'][0] == $_GET['filter'] && $_SESSION['previousGet'][0] != "") {
            $order = ($_SESSION['previousGet'][1] == 'ASC') ? 'DESC' : 'ASC';
        }
        $_SESSION['previousGet'] = Array($_GET['filter']);
        $_SESSION['previousGet'][1] = (isset($order)) ? $order : 'ASC';
        
        $connect = connectDB();
        if($_GET['filter'] == 'articles') {
            $results = $connect->query("SELECT ".DB_PREFIX."CATEGORY.id, ".DB_PREFIX."CATEGORY.title, ".DB_PREFIX."CATEGORY.description, ".DB_PREFIX."CATEGORY.logo, category, COUNT(article) FROM ".DB_PREFIX."BELONGTO RIGHT JOIN ".DB_PREFIX."CATEGORY ON ".DB_PREFIX."BELONGTO.category = ".DB_PREFIX."CATEGORY.id GROUP BY category ORDER BY COUNT(article) DESC;");

        }else{
            $results = $connect->query("SELECT id, title, description, logo FROM ".DB_PREFIX."CATEGORY ORDER BY ".$_GET['filter']." ".$_SESSION['previousGet'][1]);
        }
        $listOfCategories = $results->fetchAll();
    }

    $maxPage = ceil(count($listOfCategories) / 10);

    if(isset($_GET['id'])){
        $connect = connectDB();
        if($_GET['action'] == "Supprimer"){
            $queryArticlesPrepared = $connect->prepare("UPDATE ".DB_PREFIX."BELONGTO SET category=NULL WHERE category=:id");
            $queryArticlesPrepared->execute(['id'=>$_GET['id']]);
            $queryPrepared = $connect->prepare("DELETE FROM ".DB_PREFIX."CATEGORY WHERE id=:id");
        }
        $queryPrepared->execute(['id'=>$_GET['id']]);
        header("Location: categories.php");
    }

    if(isset($_POST['arrowLeft']) && $_SESSION['currentPage'] > 1){
        $_SESSION['currentPage']--;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowLeft']);
        header('Location: categories.php');
    }

    if(isset($_POST['arrowRight']) && $_SESSION['currentPage'] < $maxPage){
        $_SESSION['currentPage']++;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowRight']);
        header('Location: categories.php');
    }

?>

<form method="POST" action="../core/nebula/add_category.php" enctype="multipart/form-data">
    <div class="popup popupClose">
        <img src="../img/other/cross.png" alt="Fermer" class="closePopup" id="closePopupId">
        <p class="popupTitle">Créer une catégorie</p>
        <div class="row tiny-mt">
            <div class="inputColumn logoPopup">
                <label for="reportLogo">Logo</label>
                <input type="file" id="reportLogo" name="logo" class="fileInput"><label for="reportLogo" class="labelPlus">+</label>
            </div>
            <div class="inputColumn titlePopup">
                <label for="reportTitle">Titre</label>
                <input type="text" id="reportTitle" name="title" class="textInput">
            </div>
        </div>
        <div class="inputColumn tiny-mt">
            <label for="reportContent">Description<br><span class="condition">(max. 300 caractères)</span></label>
            <textarea id="reportContent" name="desc"></textarea>
        </div>
        <div class="sendBtn">
            <button type="submit">Envoyer</button>
        </div>
    </div>
</form>


<div class="pageBody">
    <div class="pageBodyHeader">
        <h1 class="pageTitle">Liste des Catégories :</h1>
        <div class="row margin">
            <input type="text" placeholder="Rechercher ..." class="searchBar">
            <div class="addCategory">+</div>
        </div>
    </div>

    <div class="userTable">
        <div class="userTableHeader">
            <p class="logo">Logo</p>
            <p class="title">Titre</p>
            <p class="description">Description</p>
            <p class="articles">Articles</p>
            <p class="action">Action</p>
        </div>

        <?php 
            
            $tempListOfCategories = array_slice($listOfCategories, 10 * ($_SESSION['currentPage'] - 1), 10);

            foreach($tempListOfCategories as $category) {
        ?>

        <div class="userTableRow">
            <div class="logo"><img src="<?php echo $category['logo']; ?>" alt="Logo de la catégorie"></div>
            <div class="title"><?php echo strtoupper($category["title"]); ?></div>
            <div class="description"><?php echo $category["description"]; ?></div>
            <div class="articles">
                <?php 
                    $connect = connectDB();
                    $results = $connect->query("SELECT COUNT(article) FROM ".DB_PREFIX."BELONGTO WHERE category=".$category["id"]);
                    $articlesNb = $results->fetch();

                    echo $articlesNb[0];
                ?>
            </div>
            <form>
                <div class="action">
                    <input type="hidden" name="id" value=<?php echo $category["id"]; ?>>
                    <input type="submit" name="action" value="Supprimer">
                    <input type="submit" name="action" value="Éditer">
                </div>
            </form>
        </div>

    <?php 
        } 
        if(count($listOfCategories) > 10){
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
    const addCategoryBtn = document.querySelector('.addCategory');
    const popup = document.querySelector('.popup');

    addCategoryBtn.addEventListener('click', () => {
        popup.classList.toggle('popupClose');
    })

    const cross = document.getElementById("closePopupId");

    cross.addEventListener("click", () => {
        popup.classList.toggle("popupClose");
    })

    const headerDivs = document.querySelectorAll('.userTableHeader p');

    headerDivs.forEach(div => {
        let className = div.classList[0];
        div.addEventListener('click', () => {
            if(className !== 'action' && className !== 'logo'){
                document.location.href = `categories.php?filter=${className}`;
            }
        })
    })
</script>
</body>
</html>