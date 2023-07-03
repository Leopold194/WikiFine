<?php
require_once 'vendor/autoload.php'; // Inclure le fichier autoload.php de Stripe

\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY'); // Remplace 'YOUR_STRIPE_SECRET_KEY' par ta clé secrète Stripe

header('Content-Type: application/json');

$amount = $_POST['amount'];

$stripe = new \Stripe\StripeClient('YOUR_STRIPE_SECRET_KEY'); // Remplace 'YOUR_STRIPE_SECRET_KEY' par ta clé secrète Stripe

$session = $stripe->checkout->sessions->create([
    'success_url' => 'http://www.example.com/success',
    'cancel_url' => 'http://www.example.com/cancel',
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Donation'
                ],
                'unit_amount' => $amount * 100 // Convertir le montant en centimes
            ],
            'quantity' => 1
        ]
    ]
]);

echo json_encode(['id' => $session->id]);
