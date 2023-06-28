<?php 
    session_start();
    require '../../core/functions.php';
    redirectIfNotConnected();
?>

<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/user/user.css'>
<link rel='stylesheet' href='../../css/user/messages.css'>
<script src=<?php echo FILE_PREFIX.'js/search_user.js'; ?> defer></script>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/user_sidebar.php'; ?>


<div class="container">
    <?php 
        if(isset($_GET['recipientId'])) {
    ?>
    <form method="POST" action="../../core/user/send_message.php">
        <div class="sendMess">
            <input type="text" placeholder="Écris ton message ici ...">
            <button type="submit" class="sendBtn"><img src="../../img/other/send.png" alt="Envoyer le message"></button>
        </div>
    </form>
    <?php
        }
    ?>
    <div class="contact">
        <input type="text" name="search" class="findUser" placeholder="Rechercher ...">
        <div id="searchUsers" class="suggestion-user-container"></div>
        <span></span>
        <form class="contactForm">
            <?php 
                $connect = connectDB();
                $resultId = getData(Array('id'), $_SESSION['id']);
                $query = $connect->query("SELECT DISTINCT recipient FROM ".DB_PREFIX."MESSAGE WHERE author=".$resultId[0]." OR recipient=".$resultId[0]);
                $results = $query->fetchAll();

                foreach($results as $result) {
                    $active = ($_GET['recipientId'] == $result['recipient']) ? 'active' : '';
            ?>
                <button class="profil <?php echo $active; ?>" type="submit" name="recipientId" value="<?php echo $result['recipient']; ?>">
                <img src="../../../img_avatar/5.png" alt="Photo de profil">
                <p>
                    <?php  
                        $user = $connect->query("SELECT pseudo FROM ".DB_PREFIX."USER WHERE id=".$result['recipient']);
                        $userPseudo = $user->fetch();
                        echo $userPseudo['pseudo'];
                    ?>
                </p>
            </button>

            <?php
                }
            ?>
        </form>
    </div>
</div>


</body>
</html>