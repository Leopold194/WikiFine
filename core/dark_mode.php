<?php
$cssFiles = [
    "articles.css",
    "write_articles.css",
    "dashboard.css",
    "reporting.css",
    "userslist.css",
    "navbar.css",
    "sidebar.css",
    "nebula_navbar.css",
    "nebula_sidebar.css",
    "style.css",
    "messages.css",
    "user.css",
    "index.css",
];
$darkMode = isset($_COOKIE['darkMode']) && strtolower($_COOKIE['darkMode']) === 'true';
$stylesheetsMap = [
    "articles.css" => "articles_dark.css",
    "write_articles.css" => "write_articles_dark.css",
    "dashboard.css" => "dashboard_dark.css",
    "reporting.css" => "reporting_dark.css",
    "userslist.css" => "userslist_dark.css",
    "navbar.css" => "navbar_dark.css",
    "sidebar.css" => "sidebar_dark.css",
    "nebula_navbar.css" => "nebula_navbar_dark.css",
    "nebula_sidebar.css" => "nebula_sidebar_dark.css",
    "style.css" => "style_dark.css",
    "messages.css" => "messages_dark.css",
    "user.css" => "user_dark.css",
    "index.css" => "index_dark.css",
];

foreach ($cssFiles as $file) {
    $modeFile = $darkMode && isset($stylesheetsMap[$file]) ? $stylesheetsMap[$file] : $file;
    echo '<link rel="stylesheet" href="../css/'.$modeFile.'" />';
}
