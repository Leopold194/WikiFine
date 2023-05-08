<?php
session_start();
require '../core/functions.php';
?>

<?php require '../conf.inc.php'; ?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/nebula/dashboard.css'>
<?php require 'templates/navbar.php'; ?>
<?php require 'templates/sidebar.php'; ?>
<?php
function generateLineChart($dataPoints, $color)
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
        $points .= "<circle cx='{$x}' cy='{$y}' r='5' fill='{$color}' />";
        if ($index > 0) {
            $xPrev = $margin + ($index - 1) * $xInterval;
            $yPrev = ($yMax - $dataPoints[$index - 1]) * $yScale;
            $lines .= "<line x1='{$xPrev}' y1='{$yPrev}' x2='{$x}' y2='{$y}' stroke='{$color}' stroke-width='4' />";
        }
    }

    $axes = "<line x1='{$margin}' y1='0' x2='{$margin}' y2='{$graphHeight}' stroke='black' stroke-width='4' />
             <line x1='{$margin}' y1='{$graphHeight}' x2='" . ($graphWidth - $margin) . "' y2='{$graphHeight}' stroke='black' stroke-width='4' />";

    return $axes . $lines . $points;
}

$dataPoints = [60, 20, 30, 20, 40, 50];
$color = "#5F85DB";
$chartContent = generateLineChart($dataPoints, $color);
?>

<div class="contentBody">
    <div class="dashboardCardsWrapper">
        <div class="dashboardCard">
            <div class="cardContent">
                <h3 class="cardTitle">Articles</h3>
                <p class="cardNumber articles">491</p>
            </div>
        </div>
        <div class="dashboardCard">
            <div class="cardContent">
                <h3 class="cardTitle">Reports</h3>
                <p class="cardNumber reports">6</p>
            </div>
        </div>
        <div class="dashboardCard">
            <div class="cardContent">
                <h3 class="cardTitle">New articles</h3>
                <p class="cardNumber newArticles">12</p>
            </div>
        </div>
        <div class="dashboardCard">
            <div class="cardContent">
                <h3 class="cardTitle">Delete articles</h3>
                <p class="cardNumber deleteArticles">2</p>
            </div>
        </div>
    </div>
    <?php
    $chartContent = generateLineChart($dataPoints, $color);
    ?>
    <div class="dashboardGraphWrapper">
        <div class="dashboardCardGraph">
            <div class="chartContainer">
                <svg class="lineChart" width="90%" height="90%" viewBox="0 0 580 210">
                    <?= $chartContent ?>
                </svg>
            </div>
        </div>
        <div class="dashboardCardGraph">
            <div class="chartContainer">
                <svg class="lineChart" width="90%" height="90%" viewBox="0 0 580 210">
                    <?= $chartContent ?>
                </svg>
            </div>
        </div>
    </div>

    <div class="dashboardCardList"></div>
</div>

</body>

</html>