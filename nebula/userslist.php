<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require '../conf.inc.php'; ?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/userslist.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<?php 

    $connect = connectDB();
    $results = $connect->query("SELECT id, lastname, firstname, pseudo, email, verify, status FROM ".DB_PREFIX."USER");
    $listOfUsers = $results->fetchAll();

    $maxPage = ceil(count($listOfUsers) / 10);

    if(isset($_GET['id'])){
        $connect = connectDB();
        $queryPrepared = $connect->prepare("DELETE FROM ".DB_PREFIX."USER WHERE id=:id");
        $queryPrepared->execute(['id'=>$_GET['id']]);
    }

    if(isset($_POST['arrowLeft']) && $_SESSION['currentPage'] > 1){
        $_SESSION['currentPage']--;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowLeft']);
        header('Location: userslist.php');
    }

    if(isset($_POST['arrowRight']) && $_SESSION['currentPage'] < $maxPage){
        $_SESSION['currentPage']++;
        echo $_SESSION['currentPage'];
        unset($_POST['arrowRight']);
        header('Location: userslist.php');
    }

?>

<div class="pageBody">
    <div class="pageBodyHeader">
        <h1 class="pageTitle">Liste des Utilisateurs :</h1>
        <input type="text" placeholder="Rechercher ..." class="searchBar">
    </div>

    <div class="userTable">
        <div class="userTableHeader">
            <ul>
                <li class="lastname">Nom</li>
                <li class="firstname">Prénom</li>
                <li class="pseudo">Pseudo</li>
                <li class="email">Email</li>
                <li class="verify">Vérifié</li>
                <li class="role">Rôle</li>
                <li class="action">Action</li>
            </ul>
        </div>

        <?php 
            $connect = connectDB();
	        $results = $connect->query("SELECT id, lastname, firstname, pseudo, email, verify, status FROM ".DB_PREFIX."USER");
	        $listOfUsers = $results->fetchAll();

            $tempListOfUsers = array_slice($listOfUsers, 10 * ($_SESSION['currentPage'] - 1), 10);

            foreach($tempListOfUsers as $user) {
        ?>

        <div class="userTableRow">
            <div class="lastname"><?php echo strtoupper($user["lastname"]); ?></div>
            <div class="firstname"><?php echo ucwords($user["firstname"]); ?></div>
            <div class="pseudo"><?php echo $user["pseudo"]; ?></div>
            <div class="email"><?php echo $user["email"]; ?></div>
            <div class="verify"><input type="checkbox" value="<?php echo $user['id']; ?>" class="checkboxVerify"
            <?php 
                if($user["verify"] == 1) {
                    echo 'checked';
                } 
            ?>>
            </div>
            <div class="role">
                <select class="selectRole" name="role">
                    <option value="2|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 2)?"selected":""; ?>>Admin</option>
                    <option value="1|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 1)?"selected":""; ?>>Modo</option>
                    <option value="0|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 0)?"selected":""; ?>>Lecteur</option>
                </select>
            </div>
            <form>
                <div class="action">
                    <input type="hidden" name="id" value=<?php echo $user["id"]; ?>>
                    <input type="submit" value="Supprimer">
                </div>
            </form>
        </div>

    <?php } 
    if(count($listOfUsers) > 10){
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


</body>
</html>