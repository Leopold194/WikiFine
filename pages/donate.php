<?php
session_start();
require '../core/functions.php';

require '../conf.inc.php';
require 'templates/head.php';
require 'templates/navbar.php';

$title = "Page de dons";
$amounts = array(
    '10' => '10 EUR',
    '20' => '20 EUR',
    '50' => '50 EUR',
    '100' => '100 EUR',
    'custom' => 'Montant personnalisé'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    if ($amount === '10') {
        header('Location: https://donate.stripe.com/6oE15n9aJ13T54A5kl');
        exit;
    } elseif ($amount === '20') {
        header('Location: https://donate.stripe.com/8wMdS93Qp9Ap9kQ28a');
        exit;
    } elseif ($amount === '50') {
        header('Location: https://donate.stripe.com/8wMcO5biRh2R0Ok4gj');
        exit;
    } elseif ($amount === '100') {
        header('Location: https://donate.stripe.com/14k4hz9aJbIx7cI5ko');
        exit;
    } else {
        header('Location: https://donate.stripe.com/cN2aFXgDbbIx8gM4gl');
        exit;
    }
}
?>

    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/donate.css">
</head>
<body>
    <h1>Faire un don</h1>

    <form id="donation-form" method="post">
        <div class="form-group">
            <label for="amount">Montant :</label>
            <select id="amount" name="amount">
                <?php foreach ($amounts as $value => $label) { ?>
                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group custom-amount" style="display: none;">
            <label for="custom-amount">Montant personnalisé (EUR) :</label>
            <input type="number" id="custom-amount" name="custom-amount" min="2" step="1">
        </div>
        <div>
            <button type="submit">Faire un don</button>
        </div>
    </form>
