const findUser = document.querySelector(".findUser")

if(window.location.host == 'localhost'){
  filePrefix = '/wikiFine/';
}else{
  filePrefix = '/';
}

function showSuggestionsUsers(users) {
  const suggestionsDiv = document.getElementById('searchUsers');
  suggestionsDiv.innerHTML = '';
  suggestionsDiv.style.display = 'block';
  let maxUsers = 6; // Si plus de 6 alors scroll

  users.slice(0, maxUsers).forEach(users => {
    const suggestionItem = document.createElement('div');
    suggestionItem.classList.add('suggestion-user');
    suggestionItem.textContent = users.pseudo;
    suggestionItem.addEventListener('click', () => {
      findUser.value = users.pseudo;
      suggestionsDiv.style.display = 'none';
      document.location.href=`${filePrefix}pages/user/user_mess.php?recipientId=${users.id}`;
    });
    suggestionsDiv.appendChild(suggestionItem);
  });
}

function hideSuggestionsUsers() {
  const suggestionsDiv = document.getElementById('searchUsers');
  suggestionsDiv.style.display = 'none';
}

findUser.addEventListener("input", function() {
  const searchValue = findUser.value;

  if (searchValue.length === 0) {
    console.log("oui");
    hideSuggestionsUsers();
    return;
  }

  fetch(`${filePrefix}core/user/find_user.php?search=${encodeURIComponent(searchValue)}`)
    .then(response => response.text()) // Change ici json() en text()
    .then(text => {
        const data = JSON.parse(text);
        showSuggestionsUsers(data);
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});

document.addEventListener('click', function(event) {
  if (event.target.id !== 'findUser') {
    hideSuggestionsUsers();
  }
});
