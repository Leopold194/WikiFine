<?php
session_start();
require 'core/functions.php';
?>

<?php require 'conf.inc.php'; ?>
<?php require 'pages/templates/head.php'; ?>
<link rel='stylesheet' href='css/templates/sidebar.css'>
<link rel='stylesheet' href='css/index.css'>
<?php require 'pages/templates/navbar.php'; ?>
<?php require 'pages/templates/sidebar.php'; ?>
<style>
    .contentIndex {
        position: relative;
        width: calc(100% - 350px);
        margin-left: 350px;
        margin-right: 50px;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
    }

    .welcomeTitle {
        text-align: center;
        font-size: 35px;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        margin-bottom: 100px;
    }

    .recommendationsTitle {
        text-align: left;
        font-size: 30px;
        font-weight: bold;
        width: 100%;
    }

    .recommendationFrame {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start; 
        gap: 20px;
        width: 100%;
        margin-bottom: 50px;
    }

    .recommendationCard {
        position: relative;
        width: calc(33.333% - 20px);
        height: 250px;
        background: #ECEBEB;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
    }
    .cardTitle {
        font-size: 24px;
        font-weight: bold;
        margin: 16px 16px;
        text-align: left;
    }
    .cardImage {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        position: absolute;
        top: 16px;
        right: 16px;
    }
    .cardContent {
        font-size: 16px;
        text-align: justify;
        padding: 16px 16px;
    }
</style>


<body>
    <div class="contentIndex">
        <div class="welcomeTitle">
            <h1>Ravi de votre retour sur Wikifine !</h1>
        </div>
        <h1 class="recommendationsTitle">Recommandations</h1>
        <div class="recommendationFrame">
            <div class="recommendationCard">
                <img class="cardImage" src="img/cards_logos/Burj.png" alt="Burj Khalifa">
                <h2 class="cardTitle">Burj Khalifa</h2>
                <p class="cardContent">Burj Khalifa fait partie d’un vaste projet urbanistique, immobilier et architectural couvrant une superficie de 2 km2. Il s’agit de créer un nouveau quartier, Downtown Dubai, un peu au sud du centre historique de Dubaï aux Émirats arabes unis...</p>
            </div>
            <div class="recommendationCard">
                <img class="cardImage" src="img/cards_logos/Eiffel.jpg" alt="Tour Eiffel">
                <h2 class="cardTitle">Tour Eiffel</h2>
                <p class="cardContent">La Tour Eiffel est une tour de fer puddlé de 324 mètres de hauteur située à Paris, à l’extrémité nord-ouest du parc du Champ-de-Mars en bordure de la Seine dans le 7ᵉ arrondissement...</p>
            </div>
            <div class="recommendationCard">
                <img class="cardImage" src="img/cards_logos/colisee.jpg" alt="Colisée">
                <h2 class="cardTitle">Le Colisée</h2>
                <p class="cardContent">Le Colisée, à l'origine amphithéâtre Flavien, est un immense amphithéâtre ovoïde situé dans le centre de la ville de Rome, entre l'Esquilin et le Caelius, le plus grand jamais construit dans l'Empire romain...</p>
            </div>
        </div>
        <h1 class="recommendationsTitle">Les derniers articles publiés</h1>
        <div class="recommendationFrame">
            <div class="recommendationCard">
                <img class="cardImage" src="img/cards_logos/Burj.png" alt="Burj Khalifa">
                <h2 class="cardTitle">Burj Khalifa</h2>
                <p class="cardContent">Burj Khalifa fait partie d’un vaste projet urbanistique, immobilier et architectural couvrant une superficie de 2 km2. Il s’agit de créer un nouveau quartier, Downtown Dubai, un peu au sud du centre historique de Dubaï aux Émirats arabes unis...</p>
            </div>
            <div class="recommendationCard">
                <img class="cardImage" src="img/cards_logos/Eiffel.jpg" alt="Tour Eiffel">
                <h2 class="cardTitle">Tour Eiffel</h2>
                <p class="cardContent">La Tour Eiffel est une tour de fer puddlé de 324 mètres de hauteur située à Paris, à l’extrémité nord-ouest du parc du Champ-de-Mars en bordure de la Seine dans le 7ᵉ arrondissement...</p>
            </div>
            <div class="recommendationCard">
                <img class="cardImage" src="img/cards_logos/colisee.jpg" alt="Colisée">
                <h2 class="cardTitle">Le Colisée</h2>
                <p class="cardContent">Le Colisée, à l'origine amphithéâtre Flavien, est un immense amphithéâtre ovoïde situé dans le centre de la ville de Rome, entre l'Esquilin et le Caelius, le plus grand jamais construit dans l'Empire romain...</p>
            </div>
        </div>
    </div>
</body>

</html>