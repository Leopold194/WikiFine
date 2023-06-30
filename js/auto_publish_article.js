fetch('../core/articles/get_categories_json.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.json()
    })
    .then(categories => {
        let randomCategory = categories[Math.floor(Math.random() * categories.length)];
        console.log("Random category: ", randomCategory);
    })
    .catch(error => console.error('Error:', error));


function getRandomCategory() {
    return categories[Math.floor(Math.random() * categories.length)];
}

function getArticleImage(title) {
    return fetch(`https://pixabay.com/api/?key=37860753-949e0c538450a72d0bf6db984&q=${encodeURIComponent(title)}&image_type=photo`) // Remplacez par votre propre clé d'accès Pixabay
        .then(response => response.json())
        .then(data => {
            if(data.hits.length > 0) {
                return data.hits[0].webformatURL;
            } else {
                return "img/logos/wikifineColor.png";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            return "img/logos/wikifineColor.png";
        });
}


function publishRandomArticle() {
    fetch('../core/nebula/fetch_wikipedia_article.php')
        .then(response => response.json())
        .then(data => {
            let articleTitle = data.title;
            let category = getRandomCategory();

            fetch(`https://fr.wikipedia.org/api/rest_v1/page/summary/${articleTitle}`)
                .then(response => response.json())
                .then(data => {
                    let articleTitle = data.title;
                    let articleContent = data.extract;
                    
                    getArticleImage(articleTitle).then(articleImage => {
                        fetch('../core/articles/publish_article.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                'title': articleTitle,
                                'content': articleContent,
                                'poster': articleImage,
                                'selectCtg0': category,
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
                });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
