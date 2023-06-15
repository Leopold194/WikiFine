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
