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

            $colorPalettes = array(
                "eyebrows" => array("#614335", "#A48776", "#000000", "#403221"),
                "eyes" => array("#000000", "#593C1F", "#1C1C1C", "#FFFFFF"),
                "face" => array("#BA4A27", "#E36A41", "#F58F63", "#E87F72", "#F7A584", "#F7B1AD", "#F18C80"),
                "hair" => array("#833B23", "#BA4A27", "#E83837", "#EA8723", "#0B2C48", "#F0CA4A", "#FFFFFF", "#B8BEC2"),
                "mouth" => array("#614335", "#A48776", "#000000", "#403221"),
                "background" => array("#008162", "#6DB8DE", "#0B2C48", "#E83837", "#E36A41", "#2782AB", "#55A896", "#51646F", "#F18C80", "#F0CA4A"),
                "ear" => array("#BA4A27", "#E36A41", "#F58F63", "#E87F72", "#F7A584", "#F7B1AD", "#F18C80"),
            );
        
            $elementNames = array(
                "eyebrows" => "Sourcils",
                "eyes" => "Yeux",
                "face" => "Visage",
                "hair" => "Cheveux",
                "mouth" => "Bouche",
                "background" => "Fond",
                "ear" => "Oreilles"
            );
            
            foreach($elements as $element => $options) {
                echo "<h2>" . $elementNames[$element] . "</h2>";
                echo "<div>";
                    echo "<div class='element-selector' id='$element-container'>";
                    foreach($options as $option) {
                        echo "<div class='svg-option' id='$option'>";
                        echo file_get_contents(__DIR__ . "../../../img/avatar-elements/$option.svg");
                        echo "</div>";
                    }
                    echo "</div>";
                    if ($element !== "mouth" && $element !== "eyes") {
                        echo "<div class='color-selector' id='color-container-$element'>";
                        foreach($colorPalettes[$element] as $color) {
                            echo "<div class='color-option' id='color-$element' data-color='$color' style='background-color: $color;'></div>";
                        }
                        echo "</div>";
                    }
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
