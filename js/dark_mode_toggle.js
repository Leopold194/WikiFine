let darkMode;
if (document.cookie.indexOf('darkMode') == -1 ) {
    darkMode = false;
} else {
    darkMode = document.cookie.replace(/(?:(?:^|.*;\s*)darkMode\s*\=\s*([^;]*).*$)|^.*$/, "$1") === 'true';
}

if(window.location.host == 'localhost'){
    filePrefix = '/wikiFine/';
}else{
    filePrefix = '/';
}

const stylesheetsMap = {
    "articles.css": "articles_dark.css",
    "write_articles.css": "write_articles_dark.css",
    "dashboard.css": "dashboard_dark.css",
    "reporting.css": "reporting_dark.css",
    "userslist.css": "userslist_dark.css",
    "navbar.css": "navbar_dark.css",
    "sidebar.css": "sidebar_dark.css",
    "nebula_navbar.css": "nebula_navbar_dark.css",
    "nebula_sidebar.css": "nebula_sidebar_dark.css",
    "style.css": "style_dark.css",
    "messages.css": "messages_dark.css",
    "user.css": "user_dark.css",
    "index.css": "index_dark.css",
};
const lightStylesheetsMap = {
    "articles_dark.css": "articles.css",
    "write_articles_dark.css": "write_articles.css",
    "dashboard_dark.css": "dashboard.css",
    "reporting_dark.css": "reporting.css",
    "userslist_dark.css": "userslist.css",
    "navbar_dark.css": "navbar.css",
    "sidebar_dark.css": "sidebar.css",
    "nebula_navbar_dark.css": "nebula_navbar.css",
    "nebula_sidebar_dark.css": "nebula_sidebar.css",
    "style_dark.css": "style.css",
    "messages_dark.css": "messages.css",
    "user_dark.css": "user.css",
    "index_dark.css": "index.css",
};

const switchStyles = () => {
    const stylesheets = document.getElementsByTagName('link');
    const logo = document.querySelector('.logo');
    const modeSelector = document.getElementById('modeSelector');
    const svgIcons = document.querySelectorAll('.pageLogos');
    let newModeSelector = darkMode ? `${filePrefix}img/page_logos/sun.svg` : `${filePrefix}img/page_logos/moon.svg`;
    let newLogo = darkMode ? `${filePrefix}img/logos/wikifinedarkmode.png` : `${filePrefix}img/logos/wikifineColorFull.png`;      
    logo.src = newLogo;
    modeSelector.src = newModeSelector;

    
    for (let i = 0; i < stylesheets.length; i++) {
        if (!stylesheets[i].href) {
            continue;
        }
        let fileName = stylesheets[i].href.split('/').pop();
        let newPath;
        if (stylesheetsMap.hasOwnProperty(fileName)) {
            newPath = darkMode ? stylesheetsMap[fileName] : fileName.replace('_dark', '');
        }
        if (lightStylesheetsMap.hasOwnProperty(fileName)) {
            newPath = darkMode ? fileName : lightStylesheetsMap[fileName];
        }
        if(newPath) {
            stylesheets[i].href = stylesheets[i].href.replace(fileName, newPath);
        }
    }
};


document.getElementById('modeSelector').addEventListener('click', function(event) {
    event.preventDefault();
    darkMode = !darkMode;
    switchStyles();
    document.cookie = "darkMode=" + darkMode + ";path=/";
});

switchStyles();
