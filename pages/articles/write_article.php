<?php
    session_start();
    require '../../core/functions.php';
    redirectIfNotConnected();

    $pattern0 = '/^http\:\/\/localhost\/WikiFine\/pages\/articles\/articles\.php\?id\=\d+$/';
    $pattern1 = '/^https\:\/\/wikifine.org\/pages\/articles\/articles\.php\?id\=\d+$/';
    if (!(isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] === LINK_PREFIX.'pages/articles/write_article.php' || $_SERVER['HTTP_REFERER'] === LINK_PREFIX.'core/articles/article_option.php' || $_SERVER['HTTP_REFERER'] === LINK_PREFIX.'core/articles/publish_article.php' || preg_match($pattern0, $_SERVER['HTTP_REFERER']) === 1 || preg_match($pattern1, $_SERVER['HTTP_REFERER']) === 1))) {
        unset($_SESSION['articleData']);
    }
    
?>

<?php require '../templates/head.php'; ?>
<link rel='stylesheet' href='../../css/templates/sidebar.css'>
<link rel='stylesheet' href='../../css/index.css'>
<link rel='stylesheet' href='../../css/articles/write_article.css'>
<?php require '../templates/navbar.php'; ?>
<?php require '../templates/sidebar.php'; ?>

<div class="contentPage">

    <div class="titlePage">
        <h1>Bienvenue dans la création d'articles !</h1>
        <p>Avant de commencer à rédiger ton article, n’hésite pas à aller lire <a href="">le règlement</a></p>
    </div>

    <div class="articleCreation">
        <form id="form" method="POST" action="../../core/articles/publish_article.php" enctype="multipart/form-data">
            <?php 
                if(!empty($_SESSION['errors'])){
            ?>
            <div class="alert">
                <?php 
                    foreach($_SESSION['errors'] as $error){
                        echo "<li>".$error[1]."</li>";
                    }
                ?>
            </div>
            <?php
                unset($_SESSION['errors']);}
            ?>
            <div class="articleTitle">
                <p class="desc">Tout d’abord, de quoi souhaites tu parler ?</p>
                <div class="inputDiv">
                    <input type="text" value='<?php echo $_SESSION['articleData']['title'] ?? ""; ?>' placeholder="Titre de l'article" name="title" maxlength="50" required <?php echo (isset($_SESSION['action']) && $_SESSION['action'] == 'modif') ? 'readonly' : '' ?>>
                    <p>0/50</p>
                </div>
            </div>

            <div class="articleContent">
                <p class="desc">Maintenant détaille nous ce sujet :</p>
                <div class="utils">
                    <div onclick="formatText('bold')" class="bold"><b>G</b></div>
                    <div onclick="formatText('italic')" class="italic"><i>I</i></div>
                    <div onclick="formatText('underline')" class="underline"><u>S</u></div>
                    <div onclick="formatText('strikethrough')" class="strikethrough"><s>B</s></div>
                    <div class="color"><input type="color" onchange="changeTextColor(this.value)"></div>
                    <div class="size">
                        <select onchange="changeFontSize(this.value)">
                            <option value="3.5">Paragraphe</option>
                            <option value="14">Titre</option>
                            <option value="6">Sous-Titre</option>
                        </select>
                    </div>
                    <div class="puces" onclick="insertPuces('puces')"><img src="../../img/other/puces.png" alt="puces"></div>
                    <div class="numbers" onclick="insertPuces('numbers')"><img src="../../img/other/numbers.png" alt="numbers"></div>
                    <input type="file" id="imageInput" style="display: none;" accept="image/*" onchange="insertImage(event)">
                    <div class="img" onclick="chooseImage()"><img src="../../img/other/img.png" alt="images"></div>
                    <div class="link" onclick="insertLink()"><img src="../../img/other/link.png" alt="link"></div>
                </div>
                <div class="textareaDiv">
                    <input type="hidden" name="content" value="" id="inputWithContent">
                    <iframe class="editor-iframe" oninput="updateInput()"></iframe>
                </div>
            </div>

            <div class="articleSummary">
                <p class="desc">Fiche descriptive :</p>
                <div class="container">
                    <div class="summaryImg"><input type='file' name='poster' id="poster" value=""><label for="poster" id="posterLabel">+</label></div>
                    <p class="summaryCtgTitle">Catégories :</p>
                    <p class="summaryCtgSubTitle">Min. 1 & Max. 3</p>
                    <div class="selectsCtg">
                        <?php 
                            $connect = connectDB();
                            $query = $connect->query("SELECT * FROM ".DB_PREFIX."CATEGORY");
                            $results = $query->fetchAll();

                            for($cpt = 0; $cpt < 3; $cpt++) {
                                $required = ($cpt == 0) ? 'required' : '';
                                echo "<select name='selectCtg".$cpt."' ".$required."><option value=''>--------</option>";
                                    foreach($results as $ctg) {
                                        $default = (isset($_SESSION['articleData']) && $_SESSION['articleData']['selectCtg'.$cpt] == $ctg['id']) ? 'selected' : '';
                                        echo '<option value="'.$ctg['id'].'" '.$default.'>'.$ctg['title'].'</option>';
                                    }
                                echo "</select>";
                            }
                        ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="publishBtn">Publier</button>

        </form>
    </div>
</div>

<script defer>
    const input = document.getElementById("poster");
    const preview = document.querySelector(".summaryImg");
    const label = document.getElementById("posterLabel");

    console.log(input);

    if(input.defaultValue != '') {
        console.log("ouiu");
        const file = input.defaultValue;

        preview.style.backgroundImage = "url('" + file + "')";
        preview.style.backgroundSize = "contain";
        preview.style.backgroundPosition = "center";
        preview.style.backgroundRepeat = "no-repeat";
        preview.style.backgroundColor = "#ffffff";
        label.style.display = "none";


    }

    input.addEventListener("change", function () {
        const file = this.files[0];
        
        if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.style.backgroundImage = "url('" + reader.result + "')";
            preview.style.backgroundSize = "contain";
            preview.style.backgroundPosition = "center";
            preview.style.backgroundRepeat = "no-repeat";
            preview.style.backgroundColor = "#ffffff";
            label.style.display = "none";
        });

        reader.readAsDataURL(file);
        }
    });

    const editorIframe = document.querySelector('.editor-iframe');

    editorIframe.contentDocument.designMode = 'on';
    editorIframe.contentDocument.body.style.fontFamily = "Montserrat";
    editorIframe.contentDocument.body.innerHTML = "<?php echo $_SESSION['articleData']['content'] ?? ""; ?>";
    
    function formatText(command) {
        editorIframe.contentDocument.execCommand(command, false, null);
    }

    function changeTextColor(color) {
        editorIframe.contentDocument.execCommand('foreColor', false, color);
    }

    function changeFontSize(size) {
        editorIframe.contentDocument.execCommand('fontSize', false, size);
    }

    function insertPuces(style) {

        const pucesStyle = style === "puces" ? "ul" : "ol";

        const content = editorIframe.contentDocument;
        const selection = content.getSelection();
        const range = selection.getRangeAt(0);
        const ulNode = content.createElement(pucesStyle);
        const liNode = content.createElement('li');
        ulNode.appendChild(liNode);
        range.insertNode(ulNode);
    }

    function insertLink() {
        const content = editorIframe.contentDocument;
        const url = prompt("Entrez l'URL du lien :");
        
        if (url) {
            const selection = content.getSelection();
            const selectedText = selection.toString();
            const linkNode = content.createElement('a');
            linkNode.setAttribute('href', url);
            
            if (selectedText !== '') {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                linkNode.appendChild(content.createTextNode(selectedText));
                range.insertNode(linkNode);
                selection.removeAllRanges();
            }else {
                linkNode.appendChild(content.createTextNode('Lien'));
                content.body.appendChild(linkNode);
            }
        }
    }

    function chooseImage() {
        const imageInput = document.getElementById('imageInput');
        imageInput.value = null;
        imageInput.click();
    }

    function insertImage() {
        const content = editorIframe.contentDocument;
        const imageInput = document.getElementById('imageInput');
        const file = imageInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imageUrl = event.target.result;
                const imgNode = content.createElement('img');
                imgNode.setAttribute('src', imageUrl);
                imgNode.style.width = '200px';
                content.body.appendChild(imgNode);
            };
            reader.readAsDataURL(file);
        }
        imageInput.value = null;
    }

    const btn = document.querySelector('.publishBtn');
    btn.addEventListener('click', function() {
        const hiddenInput = document.getElementById('inputWithContent');
        hiddenInput.value = editorIframe.contentDocument.body.innerHTML;
    });

</script>
</body>

</html>