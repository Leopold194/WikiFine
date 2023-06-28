const findUser = document.querySelector(".findUser")

if(window.location.host == 'localhost'){
  filePrefix = '/wikiFine/';
}else{
  filePrefix = '/';
}

function showSuggestions(users) {
  const suggestionsDiv = document.getElementById('searchUsers');
  suggestionsDiv.innerHTML = '';
  suggestionsDiv.style.display = 'block';
  let maxUsers = 6; // Si plus de 6 alors scroll

  users.slice(0, maxUsers).forEach(users => {
    const suggestionItem = document.createElement('div');
    suggestionItem.classList.add('suggestion-item');
    suggestionItem.textContent = users.pseudo;
    suggestionItem.addEventListener('click', () => {
      findUser.value = users.pseudo;
      suggestionsDiv.style.display = 'none';
      document.location.href=`${filePrefix}core/user/send_message.php?id=${users.id}`;
    });
    suggestionsDiv.appendChild(suggestionItem);
  });
}

function hideSuggestions() {
  const suggestionsDiv = document.getElementById('searchUsers');
  suggestionsDiv.style.display = 'none';
}

findUser.addEventListener("input", function() {
  const searchValue = findUser.value;

  if (searchValue.length === 0) {
    hideSuggestions();
    return;
  }

  fetch(`${filePrefix}core/user/find_user.php?search=${encodeURIComponent(searchValue)}`)
    .then(response => response.text()) // Change ici json() en text()
    .then(text => {
        const data = JSON.parse(text);
        showSuggestions(data);
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});

document.addEventListener('click', function(event) {
  if (event.target.id !== 'findUser') {
    hideSuggestions();
  }
});
