const searchBar = document.getElementById("searchBar")

function showSuggestions(articles) {
  const suggestionsDiv = document.getElementById('searchSuggestions');
  suggestionsDiv.innerHTML = '';
  suggestionsDiv.style.display = 'block';

  articles.forEach(article => {
    const suggestionItem = document.createElement('div');
    suggestionItem.classList.add('suggestion-item');
    suggestionItem.textContent = article.title;
    suggestionItem.addEventListener('click', () => {
      searchBar.value = article.title;
      suggestionsDiv.style.display = 'none';
      searchArticles();
    });
    suggestionsDiv.appendChild(suggestionItem);
  });
}

function hideSuggestions() {
  const suggestionsDiv = document.getElementById('searchSuggestions');
  suggestionsDiv.style.display = 'none';
}

searchBar.addEventListener("input", function() {
  const searchValue = searchBar.value;

  if (searchValue.length === 0) {
    hideSuggestions();
    return;
  }

  fetch(`/core/articles/find_article.php?search=${encodeURIComponent(searchValue)}`)
    .then(response => response.text()) // Changez ici json() en text()
    .then(text => {
        /*console.log(text);*/
        const data = JSON.parse(text);
        showSuggestions(data);
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});

document.addEventListener('click', function(event) {
  if (event.target.id !== 'searchBar') {
    hideSuggestions();
  }
});
