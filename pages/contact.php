<?php require '../conf.inc.php'; ?>
<?php require 'templates/head.php'; ?><?php require 'templates/navbar.php'; ?>
<style>
<?php include '../css/contact.css';?>
</style>


<div class="formTitle">
    <h1>Contactez-nous</h1>
</div>

<div class="contactForm">
<form>
    <?php if (isset($success) && $success) { ?>
        <div class="success">
            Votre message a été envoyé avec succès !
        </div>
    <?php } else if (isset($errors) && count($errors) > 0) { ?>
        <div class="error">
            <?php foreach ($errors as $error) { ?>
                <p><?php echo $error ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    
    <div class="container">
        <div class="row">
            <div class="lastname">
                <input type="lastname" class="inputForm" name="Nom" placeholder="Nom" >
                <label class="placeholderLabel">Nom :</label>
            </div>

            <div class="firstname">
                <input type="Prenom" class="inputForm" name="Prenom" placeholder="Prenom" required>
                <label class="placeholderLabel">prenom :</label>
            </div>
        </div>
            <div class="email">
                <input type="Email" class="inputForm" name="Email" placeholder="Email" required>
                <label class="placeholderLabel">Email :</label>
            </div>
            
            <div class="tel1">
                <select class="selectForm" name="country">
                    <option value="0">+33</option>
                    </select>

                <div class="tel">
                    <input type="tel" class="inputForm" name="tel" placeholder="Téléphone" >
                    
                    <label class="placeholderLabel">Téléphone :</label>
                </div>
            </div>

            <div class="Objet">
                <input type="objet" class="inputForm" name="objet" placeholder="Objet" required>
                <label class="placeholderLabel">Objet :</label>
            </div>
            
            <div class="commentaire">
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire" required></textarea>
            </div>

            <div class="submit">
                <input type="submit" name="submit" value="Envoyer">
            </div>
                </form>
        </div>
    </div>