<?php 
    session_start();
    require '../core/functions.php';
?>

<?php require '../conf.inc.php'; ?>
<?php require 'templates/head.php'; ?>
<?php require 'templates/navbar.php'; ?>

    <title>Page de dons</title>
    <link rel="stylesheet" type="text/css" href="../css/donate.css">
    <script src="https://js.stripe.com/v3/"></script>
<body>
    <h1>Faire un don</h1>

    <form id="donation-form" method="post">
        <div class="form-group">
            <label for="amount">Montant :</label>
            <select id="amount" name="amount">
                <option value="10">10 EUR</option>
                <option value="20">20 EUR</option>
                <option value="50">50 EUR</option>
                <option value="100">100 EUR</option>
                <option value="custom">Montant personnalisé</option>
            </select>
        </div>
        <div class="form-group custom-amount" style="display: none;">
            <label for="custom-amount">Montant personnalisé (EUR) :</label>
            <input type="number" id="custom-amount" name="amount" min="2" step="1">
        </div>
        <div>
        <button type="submit">Faire un don</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#amount').change(function() {
                if ($(this).val() === 'custom') {
                    $('.custom-amount').show();
                } else {
                    $('.custom-amount').hide();
                }
            });

            $('#donation-form').submit(function(event) {
                event.preventDefault(); 

                var amount;
                if ($('#amount').val() === 'custom') {
                    amount = $('#custom-amount').val();
                } else {
                    amount = $('#amount').val();
                }

                
                if (amount === '10') {
                    window.location.href = 'https://donate.stripe.com/6oE15n9aJ13T54A5kl';
                } else if (amount === '20') {
                    window.location.href = 'https://donate.stripe.com/8wMdS93Qp9Ap9kQ28a';
                } else if (amount === '50') {
                    window.location.href = 'https://donate.stripe.com/8wMcO5biRh2R0Ok4gj';
                } else if (amount === '100') {
                    window.location.href = 'https://donate.stripe.com/14k4hz9aJbIx7cI5ko';
                } else {
                    window.location.href = 'https://donate.stripe.com/cN2aFXgDbbIx8gM4gl';
                }
            });
        });
    </script>
</body>
</html>
