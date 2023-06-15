<?php
    // URL de l'API Wikipedia pour obtenir un titre de page aléatoire
    $wikiRandomURL = "https://fr.wikipedia.org/w/api.php?action=query&format=json&list=random&rnnamespace=0&rnlimit=1";

    // Effectuez la requête
    $response = file_get_contents($wikiRandomURL);
    
    // Convertir en JSON
    $json = json_decode($response, true);
    $randomArticleTitle = $json['query']['random'][0]['title'];

    // Retourner le titre de l'article
    echo json_encode(['title' => $randomArticleTitle]);
?>
