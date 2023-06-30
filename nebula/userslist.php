<?php 
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/userslist.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>

<?php 

    if(!isset($_GET['filter'])) {
        $connect = connectDB();
        $results = $connect->query("SELECT id, lastname, firstname, pseudo, email, verify, status FROM ".DB_PREFIX."USER");
        $listOfUsers = $results->fetchAll();
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
        $results = $connect->query("SELECT id, lastname, firstname, pseudo, email, verify, status FROM ".DB_PREFIX."USER ORDER BY ".$_GET['filter']." ".$_SESSION['previousGet'][1]);
        $listOfUsers = $results->fetchAll();
    }

    $maxPage = ceil(count($listOfUsers) / 10);

    if(isset($_GET['id'])){
        $connect = connectDB();
        if($_GET['action'] == "Supprimer"){
            $queryArticlesPrepared = $connect->prepare("UPDATE ".DB_PREFIX."ARTICLE SET author=NULL WHERE author=:id");
            $queryArticlesPrepared->execute(['id'=>$_GET['id']]);
            $queryPrepared = $connect->prepare("DELETE FROM ".DB_PREFIX."REPORTING WHERE author=:id");
            $queryPrepared->execute(['id'=>$_GET['id']]);
            $queryPrepared = $connect->prepare("DELETE FROM ".DB_PREFIX."USER WHERE id=:id");
        }elseif($_GET['action'] == "Bannir"){
            $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."USER SET status=3 WHERE id=:id");
        }
        $queryPrepared->execute(['id'=>$_GET['id']]);
        header("Location: userslist.php");
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
            <p class="lastname">Nom</p>
            <p class="firstname">Prénom</p>
            <p class="pseudo">Pseudo</p>
            <p class="email">Email</p>
            <p class="verify">Vérifié</p>
            <p class="role">Rôle</p>
            <p class="action">Action</p>
        </div>

        <?php 
            
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
                    <option value="3|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 3)?"selected":""; ?>>Banni</option>
                    <option value="2|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 2)?"selected":""; ?>>Admin</option>
                    <option value="1|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 1)?"selected":""; ?>>Modo</option>
                    <option value="0|<?php echo $user['id']; ?>" <?php echo ($user['status'] == 0)?"selected":""; ?>>Lecteur</option>
                </select>
            </div>
            <form>
                <div class="action">
                    <input type="hidden" name="id" value=<?php echo $user["id"]; ?>>
                    <input type="submit" name="action" value="Supprimer">
                    <input type="submit" name="action" value="Bannir">
                </div>
            </form>
        </div>

    <?php 
        } 
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
<script>
    const select = document.getElementsByClassName('selectRole')
    const checkbox = document.getElementsByClassName('checkboxVerify')

    for (let i = 0; i < select.length; i++) {
        select[i].addEventListener('change', (event) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../core/nebula/modifyRole.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error(xhr.statusText);
                }
            };
            xhr.send('choice=' + event.target.value);
        });
    }

    for (let i = 0; i < checkbox.length; i++) {
        checkbox[i].addEventListener('change', (event) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../core/nebula/modifyRole.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error(xhr.statusText);
                }
            };
            xhr.send('verify=' + event.target.value);
        });
    }

    const headerDivs = document.querySelectorAll('.userTableHeader p');

    headerDivs.forEach(div => {
        let className = div.classList[0];
        div.addEventListener('click', () => {
            if(className == 'role'){
                className = 'status';
            }
            if(className !== 'action'){
                document.location.href = `userslist.php?filter=${className}`;
            }
        })
    })
</script>
</body>
</html>