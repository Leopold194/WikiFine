<!DOCTYPE html>
<html>
    <head>
        <title>Créateur d'Avatar</title>
        <link rel="stylesheet" href="../../css/registers/avatar.css">
        <script src="../../js/avatar_creation.js" defer></script>
    </head>
    <body>
        <div id="menu">
            <?php
            $elements = array(
                "eyebrows" => array("eyebrows-1", "eyebrows-2", "eyebrows-3", "eyebrows-4", "eyebrows-5", "eyebrows-6", "eyebrows-7", "eyebrows-8"),
                "eyes" => array("eyes"),
                "face" => array("face-1", "face-2", "face-3"),
                "hair" => array("hair-1", "hair-2", "hair-3", "hair-4", "hair-5", "hair-6", "hair-7", "hair-8", "hair-9", "hair-10", "hair-11", "hair-12"),
                "mouth" => array("mouth-1", "mouth-2", "mouth-3", "mouth-4", "mouth-5", "mouth-6", "mouth-7", "mouth-8", "mouth-9", "mouth-10", "mouth-11", "mouth-12"),
                "background" => array("background"),
                "ear" => array("ear-1", "ear-2", "ear-3")
            );
            
            foreach($elements as $element => $options) {
                echo "<div class='element-selector' id='$element-container'>";
                echo "<h2>" . ucfirst($element) . "</h2>";
                foreach($options as $option) {
                    echo "<div class='svg-option' id='$option'>";
                    echo file_get_contents(__DIR__ . "../../../img/avatar-elements/$option.svg");
                    echo "</div>";
                }
                echo "<input type='color' id='color-$element' name='color-$element' value='#000000'>";
                echo "</div>";
            }
            ?>
        </div>

        <div id="preview">
            <!-- Laisser vide-->
        </div>

        <button id="save">Sauvegarder Avatar</button>
    </body>
</html>
