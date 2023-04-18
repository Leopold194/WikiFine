</head>
<body>
<header>
    <div class="logoBlock">
        <a href="../index.php"><img class="logo" src="..\img\logos\wikifineColorFull.png" alt="logo"></a>
        <div class="searchBarBlock">
            <input class="searchBar" type="text" name="search" placeholder="Search articles..">
        </div>
    </div>
    <?php
        if(!empty($_SESSION['login']) && $_SESSION['login'] == 1) {
    ?>


    <?php 
        }else{
    ?>
    <div class="profileBlock">
        <div class="login button">
            <a href=""><p>Se connecter</p></a>
        </div>
        <div class="register button">
            <a href="register1.php"><p>S'inscrire</p></a>
        </div>
    </div>
    <?php 
        }
    ?>
</header>