<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/articles_log.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<?php 

    if(!isset($_GET['filter'])) {
        $connect = connectDB();
        if(isset($_GET['title'])) {
            $results = $connect->query('SELECT id, title, author, date, version, like_nb FROM '.DB_PREFIX.'ARTICLE WHERE title="'.$_GET['title'].'" ORDER BY version DESC');
        }else{
            $results = $connect->query("SELECT A1.id, A1.title, A1.author, A1.date, A1.version, A1.like_nb FROM ".DB_PREFIX."ARTICLE A1 JOIN (SELECT title, MAX(version) as max_version FROM ".DB_PREFIX."ARTICLE GROUP BY title) A2 ON A1.title=A2.title AND A1.version=A2.max_version ORDER BY date DESC");
        }
        $listOfArticles = $results->fetchAll();
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
        if(isset($_GET['title'])) {
            $results = $connect->query('SELECT id, title, author, date, version, like_nb FROM '.DB_PREFIX.'ARTICLE WHERE title="'.$_GET['title'].'" ORDER BY '.$_GET['filter'].' '.$_SESSION['previousGet'][1]);
        }else{
            $results = $connect->query("SELECT A1.id, A1.title, A1.author, A1.date, A1.version, A1.like_nb FROM ".DB_PREFIX."ARTICLE A1 JOIN (SELECT title, MAX(version) as max_version FROM ".DB_PREFIX."ARTICLE GROUP BY title) A2 ON A1.title=A2.title AND A1.version=A2.max_version ORDER BY ".$_GET['filter']." ".$_SESSION['previousGet'][1]);
        }
        $listOfArticles = $results->fetchAll();
    }

    $maxPage = ceil(count($listOfArticles) / 10);

    if(isset($_GET['id'])){
        if($_GET['action'] == "Toutes versions"){
            header("Location: articles_log.php?title=".urlencode($_GET['title']));
        }elseif($_GET['action'] == "Lire"){
            header("Location: ../pages/articles/articles.php?id=".$_GET['id']);
        }elseif($_GET['action'] == "Supprimer"){
            $connect = connectDB();
            $query = $connect->prepare('DELETE FROM '.DB_PREFIX.'BELONGTO WHERE article=:article');
            $query->execute(['article'=>$_GET['id']]);
            $query = $connect->prepare('DELETE FROM '.DB_PREFIX.'REPORTING WHERE article=:article');
            $query->execute(['article'=>$_GET['id']]);
            $query = $connect->prepare('DELETE FROM '.DB_PREFIX.'ARTICLE WHERE id=:id');
            $query->execute(['id'=>$_GET['id']]);
            header("Location: articles_log.php");
        }
    }

    if(isset($_POST['arrowLeft']) && $_SESSION['currentPage'] > 1){
        $_SESSION['currentPage']--;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowLeft']);
        header('Location: articles_log.php');
    }

    if(isset($_POST['arrowRight']) && $_SESSION['currentPage'] < $maxPage){
        $_SESSION['currentPage']++;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowRight']);
        header('Location: articles_log.php');
    }

?>

<div class="pageBody">
    <div class="pageBodyHeader">
        <h1 class="pageTitle">Liste des Articles :</h1>
        <input type="text" placeholder="Rechercher ..." class="searchBar">
    </div>

    <div class="userTable">
        <div class="userTableHeader">
            <p class="title">Titre</p>
            <p class="author">Auteur</p>
            <p class="date">Date</p>
            <p class="version">Version</p>
            <p class="like_nb">Like</p>
            <p class="action">Action</p>
        </div>

        <?php 
            
            $tempListOfArticles = array_slice($listOfArticles, 10 * ($_SESSION['currentPage'] - 1), 10);

            foreach($tempListOfArticles as $article) {
                if($article['author'] == null) {
                    $author = 'Anonyme';
                }else{
                    $query = $connect->query("SELECT pseudo FROM ".DB_PREFIX."USER WHERE id=".$article['author']);
                    $author = $query->fetch()['pseudo'];
                }
        ?>

        <div class="userTableRow">
            <div class="title"><?php echo $article["title"]; ?></div>
            <div class="author"><?php echo $author; ?></div>
            <div class="date"><?php echo date('d/m/Y', strtotime($article['date'])); ?></div>
            <div class="version"><?php echo $article["version"]; ?></div>
            <div class="like_nb"><?php echo $article["like_nb"]; ?></div>
            <form>
                <div class="action">
                    <input type="hidden" name="title" value="<?php echo $article["title"]; ?>">
                    <input type="hidden" name="id" value=<?php echo $article["id"]; ?>>
                    <?php 
                        if(!isset($_GET['title'])) {
                    ?>
                    <input type="submit" name="action" class="seeAll" value="Toutes versions">
                    <?php 
                        }else{
                    ?>
                    <input type="submit" name="action" class="read" value="Lire">
                    <input type="submit" name="action" class="del" value="Supprimer">
                    <?php
                        }
                    ?>
                </div>
            </form>
        </div>

    <?php 
        } 
        if(count($listOfArticles) > 10){
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

    const headerDivs = document.querySelectorAll('.userTableHeader p');

    headerDivs.forEach(div => {
        let className = div.classList[0];
        div.addEventListener('click', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('title') !== null) {
                document.location.href = `articles_log.php?title=${urlParams.get('title')}&filter=${className}`;
            }else{
                document.location.href = `articles_log.php?filter=${className}`;
            }
        })
    })
</script>
</body>
</html>