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
    <div class="msgBox">

            <?php
                $connect = connectDB();
                $resultId = getData(Array('id'), $_SESSION['id']);
                $query = $connect->query("SELECT content, author FROM ".DB_PREFIX.'MESSAGE WHERE (author='.$_GET["recipientId"].' AND recipient='.$resultId[0].') OR (recipient='.$_GET["recipientId"].' AND author='.$resultId[0].')');
                $msgs = $query->fetchAll();

                foreach($msgs as $msg) {
                    $imAuthorOrNot = ($msg['author'] != $_GET['recipientId']) ? 'myMsg' : 'hisMsg';
            ?>
                    <div class="msg <?php echo $imAuthorOrNot; ?>">
                        <p><?php echo $msg['content']; ?></p>
                    </div>
            <?php
                }
            ?>
    </div>
    <?php 
        }
    ?>
    <form method="POST" action="../../core/user/send_message.php">
        <div class="sendMess">
        <?php 
            if(isset($_GET['recipientId'])) {
        ?>
            <input type="hidden" name="recipient" value="<?php echo $_GET['recipientId']; ?>">
            <input type="text" name="content" placeholder="Écris ton message ici ...">
            <button type="submit" class="sendBtn"><img src="../../img/other/send.png" alt="Envoyer le message"></button>
        <?php
            }
        ?>
        </div>
    </form>
    
    <div class="contact">
        <div class="inputDiv">
            <input type="text" name="search" class="findUser" placeholder="Rechercher ...">
            <div id="searchUsers" class="suggestion-user-container"></div>
            <span></span>
        </div>
        <form class="contactForm">
            <?php 
                $connect = connectDB();
                $resultId = getData(Array('id'), $_SESSION['id']);
                $query = $connect->query("SELECT DISTINCT recipient, author FROM ".DB_PREFIX."MESSAGE WHERE author=".$resultId[0]." OR recipient=".$resultId[0]);
                $results = $query->fetchAll();
                $uniqueArray = array();

                foreach ($results as $item) {
                    $key1 = $item['recipient'] . '_' . $item['author'];
                    $key2 = $item['author'] . '_' . $item['recipient'];

                    if (!isset($uniqueArray[$key1]) && !isset($uniqueArray[$key2])) {
                        $uniqueArray[$key1] = $item;
                    }
                }
                $results = array_values($uniqueArray);

                foreach($results as $result) {
                    $userId = ($result['recipient'] == $resultId[0]) ? $result['author'] : $result['recipient'];
                    $active = (isset($_GET['recipientId']) && $_GET['recipientId'] == $userId) ? 'active' : '';
            ?>
                <button class="profil <?php echo $active; ?>" type="submit" name="recipientId" value="<?php echo $userId; ?>">
                <img src="../../../img_avatar/5.png" alt="Photo de profil">
                <p>
                    <?php  
                        $connect = connectDB();
                        $user = $connect->query("SELECT pseudo FROM ".DB_PREFIX."USER WHERE id=".$userId);

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
<script>

    const msgBox = document.querySelector('.msgBox');
    try {
        msgBox.scrollTop = msgBox.scrollHeight;
    } catch {}
    
    function update() {
        fetch(`${filePrefix}core/user/update.php`)
            .then(response => response.text())
            .then(text => {
                const data = JSON.parse(text);
                if(data === 1) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    setInterval(update, 2000);

</script>
</body>
</html>