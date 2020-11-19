<?php $pageTitle = 'Connexion'; ?>

<?php ob_start(); ?>

<main class='connection'>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
            <header>
                <h2>Créer votre compte :</h2>
            </header>
            <form action='index.php?page=createUser' method='post'>
                <div class='formSection'>
                    <label for='username'>Nom d'utilisateur</label><br />
                    <input type='text' id='username' name='username' />
                </div>
                <div class='formSection'>
                    <label for='pass'>Mot de passe</label><br />
                    <input type='password' id='pass' name='pass' />
                </div>
                <div class='formSection'>
                    <label for='email'>Adresse e-mail</label><br />
                    <input type='email' id='email' name='email' />
                </div>
                <div class='formSection'>
                    <input type='submit' class='basicButton' value='Suivant'/> 
                </div>
            </form>
        </div>
    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


