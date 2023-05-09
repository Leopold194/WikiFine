const searchBar = document.getElementById("searchBar")

searchBar.addEventListener("keypress", function(event) {
    if(event.key === "Enter"){
        searchArticles()
    }
});

function searchArticles() {
    
    let searchValue = document.getElementById("searchBar").value;

    fetch(`/WikiFine/core/articles/find_article.php?search=${encodeURIComponent(searchValue)}`)
    .then(response => response.json())
    .then(data => {
        console.log(data);
        /*document.location.href=`/WikiFine/pages/articles/articles.php?id=${data}`; */
    })
    .catch(error => {
        console.error('Erreur:', error);
    })
}