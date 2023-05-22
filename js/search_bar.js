const searchBar = document.getElementById("searchBar")

function showSuggestions(articles) {
  const suggestionsDiv = document.getElementById('searchSuggestions');
  suggestionsDiv.innerHTML = '';
  suggestionsDiv.style.display = 'block';
  let maxArticles = 6; // Si plus de 6 alors scroll

  articles.slice(0, maxArticles).forEach(article => {
    const suggestionItem = document.createElement('div');
    suggestionItem.classList.add('suggestion-item');
    suggestionItem.textContent = article.title;
    suggestionItem.addEventListener('click', () => {
      searchBar.value = article.title;
      suggestionsDiv.style.display = 'none';
      // Vous pouvez ajouter une autre action ici, par exemple faire une recherche
      // searchArticles();
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

  fetch(`/WikiFine/core/articles/find_article.php?search=${encodeURIComponent(searchValue)}`)
    .then(response => response.text()) // Changez ici json() en text()
    .then(text => {
        console.log(text); // Affichez le texte de la réponse
        // Si le texte est du JSON valide, vous pouvez le convertir en objet JavaScript et afficher les suggestions
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
