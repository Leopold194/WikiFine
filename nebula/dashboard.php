<?php
    session_start();
    require '../core/functions.php';
    redirectIfNotConnectedNebula();
?>

<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/dashboard.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>
<?php
    function generateLineChart($dataPoints, $color, $textColor)
    {
        $graphWidth = 580;
        $graphHeight = 210;
        $margin = 20;
    
        $xInterval = ($graphWidth - 2 * $margin) / (count($dataPoints) - 1);
        $yMax = max($dataPoints);
        $yMin = min($dataPoints);
        $yScale = $graphHeight / ($yMax - $yMin);
    
        $points = '';
        $lines = '';
        foreach ($dataPoints as $index => $value) {
            $x = $margin + $index * $xInterval;
            $y = ($yMax - $value) * $yScale;
            $points .= "<circle cx='{$x}' cy='{$y}' r='0' fill='{$color}' />";
            if ($index > 0) {
                $xPrev = $margin + ($index - 1) * $xInterval;
                $yPrev = ($yMax - $dataPoints[$index - 1]) * $yScale;
                $lines .= "<line x1='{$xPrev}' y1='{$yPrev}' x2='{$x}' y2='{$y}' stroke='{$color}' stroke-width='4' />";
            }
    
            // Ajout des valeurs des axes
            $xLabel = $x;
            $yLabel = $y + 20; // Décalage pour placer le label au-dessus du point
            $points .= "<text x='{$xLabel}' y='{$yLabel}' text-anchor='middle' fill='{$textColor}' font-weight='bold'>{$value}</text>";
        }
    
        $axes = "<line x1='{$margin}' y1='0' x2='{$margin}' y2='{$graphHeight}' stroke='black' stroke-width='4' />
                <line x1='{$margin}' y1='{$graphHeight}' x2='" . ($graphWidth - $margin) . "' y2='{$graphHeight}' stroke='black' stroke-width='4' />";
    
        return $axes . $lines . $points;
    }

    $color = "#5F85DB";
    $textColor = "#000000";

    $connect = connectDB();
    $articleNb = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE");
    $reportNb = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."REPORTING WHERE status=0");
    $articleToday = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = CURDATE()");
    $userToday = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = CURDATE()");
    $articleNb = $articleNb->fetch(); 
    $reportNb = $reportNb->fetch(); 
    $articleToday = $articleToday->fetch();
    $userToday = $userToday->fetch();

?>

<div class="contentBody">
    <div class="pageBodyHeader">
        <h1 class="pageTitle">Dashboard :</h1>
    </div>
    <div class="dashboardCardsWrapper">
        <div class="tinyContainer">
            <div class="dashboardCard">
                <div class="cardContent">
                    <h3 class="cardTitle">Articles</h3>
                    <p class="cardNumber articles"><?php echo $articleNb[0]; ?></p>
                </div>
            </div>
            <div class="dashboardCard">
                <div class="cardContent">
                    <h3 class="cardTitle">Signalements</h3>
                    <p class="cardNumber reports"><?php echo $reportNb[0]; ?></p>
                </div>
            </div>
        </div>
        <div class="tinyContainer">
            <div class="dashboardCard">
                <div class="cardContent">
                    <h3 class="cardTitle">Nv articles</h3>
                    <p class="cardNumber newArticles"><?php echo $articleToday[0]; ?></p>
                </div>
            </div>
            <div class="dashboardCard">
                <div class="cardContent">
                    <h3 class="cardTitle">Nv inscrits</h3>
                    <p class="cardNumber deleteArticles"><?php echo $userToday[0]; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
        $articleTodayMinus1 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = DATE(DATE_SUB(CURDATE(), INTERVAL 1 DAY))");
        $articleTodayMinus1 = $articleTodayMinus1->fetch()[0];
        $articleTodayMinus2 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = DATE(DATE_SUB(CURDATE(), INTERVAL 2 DAY))");
        $articleTodayMinus2 = $articleTodayMinus2->fetch()[0];
        $articleTodayMinus3 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = DATE(DATE_SUB(CURDATE(), INTERVAL 3 DAY))");
        $articleTodayMinus3 = $articleTodayMinus3->fetch()[0];
        $articleTodayMinus4 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = DATE(DATE_SUB(CURDATE(), INTERVAL 4 DAY))");
        $articleTodayMinus4 = $articleTodayMinus4->fetch()[0];
        $articleTodayMinus5 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = DATE(DATE_SUB(CURDATE(), INTERVAL 5 DAY))");
        $articleTodayMinus5 = $articleTodayMinus5->fetch()[0];
        $articleTodayMinus6 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."ARTICLE WHERE DATE(date) = DATE(DATE_SUB(CURDATE(), INTERVAL 6 DAY))");
        $articleTodayMinus6 = $articleTodayMinus6->fetch()[0];

        $dataPoints0 = [$articleTodayMinus6, $articleTodayMinus5, $articleTodayMinus4, $articleTodayMinus3, $articleTodayMinus2, $articleTodayMinus1, $articleToday[0]];
        $chartContent0 = generateLineChart($dataPoints0, $color, $textColor);

        $userTodayMinus1 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = DATE(DATE_SUB(CURDATE(), INTERVAL 1 DAY))");
        $userTodayMinus1 = $userTodayMinus1->fetch()[0];
        $userTodayMinus2 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = DATE(DATE_SUB(CURDATE(), INTERVAL 2 DAY))");
        $userTodayMinus2 = $userTodayMinus2->fetch()[0];
        $userTodayMinus3 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = DATE(DATE_SUB(CURDATE(), INTERVAL 3 DAY))");
        $userTodayMinus3 = $userTodayMinus3->fetch()[0];
        $userTodayMinus4 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = DATE(DATE_SUB(CURDATE(), INTERVAL 4 DAY))");
        $userTodayMinus4 = $userTodayMinus4->fetch()[0];
        $userTodayMinus5 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = DATE(DATE_SUB(CURDATE(), INTERVAL 5 DAY))");
        $userTodayMinus5 = $userTodayMinus5->fetch()[0];
        $userTodayMinus6 = $connect->query("SELECT COUNT(ID) FROM ".DB_PREFIX."USER WHERE DATE(date_inserted) = DATE(DATE_SUB(CURDATE(), INTERVAL 6 DAY))");
        $userTodayMinus6 = $userTodayMinus6->fetch()[0];

        $dataPoints1 = [$userTodayMinus6, $userTodayMinus5, $userTodayMinus4, $userTodayMinus3, $userTodayMinus2, $userTodayMinus1, $userToday[0]];
        $chartContent1 = generateLineChart($dataPoints1, $color, $textColor);
    ?>
    <div class="dashboardContainer">
        <div class="dashboardGraphWrapper">
            <h3 class="graphTitle">Nombres d'articles ces 7 derniers jours :</h3>
            <div class="dashboardCardGraph">
                <div class="chartContainer">
                    <svg class="lineChart" width="90%" height="90%" viewBox="0 0 580 210">
                        <?= $chartContent0 ?>
                    </svg>
                </div>
            </div>
            <h3 class="graphTitle">Nombres d'inscrits ces 7 derniers jours :</h3>
            <div class="dashboardCardGraph">
                <div class="chartContainer">
                    <svg class="lineChart" width="90%" height="90%" viewBox="0 0 580 210">
                        <?= $chartContent1 ?>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dashboardCardList">
            <h2 class="dashboardCardListTitle">10 derniers Inscrits</h2>
            <?php 
                $lastRegisterUsers = $connect->query("SELECT pseudo, date_inserted, avatar FROM ".DB_PREFIX."USER ORDER BY date_inserted DESC LIMIT 10");
                $lastRegisterUsers = $lastRegisterUsers->fetchAll();

                foreach($lastRegisterUsers as $user) {
            ?>
            <div class="userRow">
                <div class="profilColumn">
                    <a href="<?php echo FILE_PREFIX . "pages/user/user_main.php"; ?>">
                        <img src="<?php
                        $result = getData(array('id'), $_SESSION['id']);
                        $connect = connectDB();
                        $query = $connect->query("SELECT avatar_link FROM ".DB_PREFIX."USER WHERE id=".$result[0]);
                        $profil_pic = $query->fetch()['avatar_link'];
                        echo $profil_pic;
                        ?>" alt="Avatar" class="avatar">
                    </a>
                    <p class="profilPseudo"><?php echo $user['pseudo'] ?></p>
                </div>
                <p class="profilDate"><?php echo date('d/m/Y', strtotime($user['date_inserted'])) ?></p>
            </div>

            <?php 
                }
            ?>

        </div>
    </div>
</div>

</body>

</html>