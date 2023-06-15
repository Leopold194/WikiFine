<!DOCTYPE html>
<html>
<head>
    <title>Publication d'articles de Wikipedia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f0f0f0;
        }
        button {
            padding: 10px;
            margin: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #searchInput {
            padding: 10px;
            margin: 10px;
            width: 50%;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
    </style>
    <script>
            var intervalId;

            function publishRandomArticle() {
                // API de Wikipedia pour obtenir des titres d'articles aléatoires
                fetch('../core/nebula/fetch_wikipedia_article.php')
                    .then(response => response.json())
                    .then(data => {
                        let articleTitle = data.title;

                        // Récupérer les données de l'article
                        fetch(`https://fr.wikipedia.org/api/rest_v1/page/summary/${articleTitle}`)
                            .then(response => response.json())
                            .then(data => {
                                // Extraction des informations nécessaires
                                let articleTitle = data.title;
                                let articleContent = data.extract;
                                let articleImage = data.originalimage ? data.originalimage.source : "img/logos/wikifineColor.png";

                                // Envoi des données à votre script PHP
                                fetch('../core/articles/publish_article.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: new URLSearchParams({
                                        'title': articleTitle,
                                        'content': articleContent,
                                        'poster': articleImage,
                                    }),
                                })
                                .then(response => response.text())
                                .then(result => {
                                    console.log('Success:', result);
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function startPublishing() {
            // Démarrer la publication automatique toutes les 5 secondes
            intervalId = setInterval(() => publishRandomArticle("Category:Science"), 3000);
            }


            function stopPublishing() {
                // Arrêter la publication automatique
                clearInterval(intervalId);
            }

            function searchArticle() {
                let articleTitle = document.getElementById('searchInput').value;
                // Insérez ici le code pour rechercher et publier l'article avec le titre donné
            }
        </script>
    </head>
    <body>
        <h1>Publication automatique d'articles de Wikipedia</h1>
        <button onclick="startPublishing()">Démarrer la publication automatique</button>
        <button onclick="stopPublishing()">Arrêter la publication automatique</button>
        
        <input type="text" id="searchInput" placeholder="Recherchez un article">
        <button onclick="searchArticle()">Rechercher</button>
        <div id="result"></div>
    </body>
</html>
