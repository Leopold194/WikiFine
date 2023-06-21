<?php 

$prefix = ($_SERVER['HTTP_HOST'] == 'localhost') ? ("/WikiFine/") : ("/");
$link = ($_SERVER['HTTP_HOST'] == 'localhost') ? ("http://localhost/WikiFine/") : ("https://wikifine.org/");
define("FILE_PREFIX", $prefix);
define("LINK_PREFIX", $link);

$secret_prefix = ($_SERVER['HTTP_HOST'] == 'localhost') ? ("C:/xampp/htdocs/") : ("/var/www/");
$data = file_get_contents($secret_prefix.'secrets/secrets.json');
$obj = json_decode($data);

define("DB_HOST", $obj[0]->DB_HOST);
define("DB_NAME", $obj[0]->DB_NAME);
define("DB_PORT", $obj[0]->DB_PORT);
define("DB_USER", $obj[0]->DB_USER);
define("DB_PWD", $obj[0]->DB_PWD);
define("DB_PREFIX", $obj[0]->DB_PREFIX);

?>