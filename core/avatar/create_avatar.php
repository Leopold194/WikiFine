<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Création d'Avatar</title>
    <style>
        .container {
            display: flex;
        }

        .selectionContainer {
            width: 300px;
            overflow: auto;
        }

        .elementSelector {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            margin-bottom: 20px;
        }

        .elementPreview {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            margin-right: 10px;
        }

        .avatarContainer {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatarPreview {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="selectionContainer">
            <h3>Elément 1</h3>
            <div class="elementSelector">
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
            </div>
            <h3>Elément 2</h3>
            <div class="elementSelector">
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
                <div class="elementPreview"></div>
            </div>
        </div>
        <div class="avatarContainer">
            <div class="avatarPreview"></div>
        </div>
    </div>
</body>
</html>
