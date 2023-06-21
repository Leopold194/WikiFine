<?php 
    if(!empty($_GET['disconnectBtn'])) {
        unset($_SESSION['id'], $_SESSION['login']);
        header('Location: ../../index.php');
    }
?>

<div class="navbarUser">
    <ul>
        <li><a href="user_main.php">Mon compte</a></li>
        <li><a href="">Mes articles</a></li>
        <li><a href="user_mess.php">Messagerie</a></li>
        <?php 
            $result = getData(Array('status'), $_SESSION['id']);
            if(in_array($result[0], Array(1, 2))) {
                echo "<li><a href='../../nebula/index.php'>NEBULA</a></li>";
            }
        ?>
    </ul>
    <form><button name="disconnectBtn" value="disconect" class="disconnectBtn">Se déconnecter</button></form>
</div>