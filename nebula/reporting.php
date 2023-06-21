<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/reporting.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<?php 

    $connect = connectDB();
    $results = $connect->query("SELECT id, title, content, author, article, date FROM ".DB_PREFIX."REPORTING WHERE status=0");
    $listOfReports = $results->fetchAll();

    $maxPage = ceil(count($listOfReports) / 3);

    if(isset($_POST['arrowLeft']) && $_SESSION['currentPage'] > 1){
        $_SESSION['currentPage']--;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowLeft']);
        header('Location: reporting.php');
    }

    if(isset($_POST['arrowRight']) && $_SESSION['currentPage'] < $maxPage){
        $_SESSION['currentPage']++;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowRight']);
        header('Location: reporting.php');
    }

    if(isset($_POST['approve'])){
        $result = $connect->query("UPDATE ".DB_PREFIX."REPORTING SET status=2 WHERE id=".$_POST['approve']);
        header('Location: reporting.php');
    }elseif(isset($_POST['refuse'])){
        $result = $connect->query("UPDATE ".DB_PREFIX."REPORTING SET status=1 WHERE id=".$_POST['refuse']);
        header('Location: reporting.php');
    }
?>

<div class="pageBody">
    <div class="pageBodyHeader">
        <h1 class="pageTitle">Articles signalés :</h1>
    </div>

    <?php 
        $tempListOfReports = array_slice($listOfReports, 3 * ($_SESSION['currentPage'] - 1), 3);

        foreach($tempListOfReports as $report) {

            $queryResult0 = $connect->query("SELECT pseudo FROM ".DB_PREFIX."USER WHERE id=".$report['author']);
            $queryResult1 = $connect->query("SELECT title FROM ".DB_PREFIX."ARTICLE WHERE id=".$report['article']);
            $user = $queryResult0->fetch();
            $article = $queryResult1->fetch();
    ?>

    
    <div class="reportCase">
        <div class="datas">
            <div class="articleTitle"><b>Article :</b> <?php echo $article['title']; ?></div>
            <div class="reportAuthor"><b>Auteur du signalement :</b> <?php echo $user['pseudo']; ?></div>
            <div class="reportTitle"><b>Titre du signalement :</b> <?php echo $report['title']; ?></div>
            <div class="reportDate"><b>Date du signalement :</b> <?php echo date('d/m/Y', strtotime($report['date'])); ?></div>
        </div>
        <div class="readMore">Lire</div>
        <div class="options">
            <form method="POST">
                <button type="submit" class="approve" name="approve" value=<?php echo $report['id']; ?>><img src="../img/other/white_check.png" alt="Approuver le signalement"></button>
                <button type="submit" class="refuse" name="refuse" value=<?php echo $report['id']; ?>><img src="../img/other/white_cross.png" alt="Refuser le signalement"></button>
            </form>
        </div>
    </div>


    <?php 
        }
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
</div>


</body>
</html>