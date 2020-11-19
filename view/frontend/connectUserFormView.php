<?php $pageTitle = 'Connexion'; ?>

<?php ob_start(); ?>

<main class='connection'>

    <?php require('navigation.php'); ?>

    <div class='page-wrap'>

        <?php require('title.php'); ?>

        <div class='page'>
            <header>
                <h2>Connexion :</h2>
                <p>Entrez vos identifiants</p>
            </header>

            <form action="index.php?page=connectUser" method="post">
                <div class='formSection'>
                    <label for="username">Nom d'utilisateur</label><br />
                    <input type="text" id="username" name="username" placeholder="Jean Forteroche"
                    <?php if (isset($connectionParameters['validCookies'])){ echo 'value=\'' . $connectionParameters['username'] . '\''; }?> 
                    />
                </div>
                <div class='formSection'>
                    <label for="pass">Mot de passe</label><br />
                    <input type="password" id="pass" name="pass" placeholder="test">
                </div>
                <div class='formSection'>
                    <label for="rememberMe">Se souvenir de moi</label>
                    <input type="checkbox" id="rememberMe" name="rememberMe" 
                    <?php if (isset($connectionParameters['validCookies'])){ ?>  checked  <?php } ?> 
                    />   
                </div>
                <div class='formSection'>
                    <input type="submit" class='basicButton' value='Se connecter'/> 
                </div>
            </form>

            <footer>
                <p>Vous n'avez pas encore de compte?</p>
                <a href='index.php?page=createUserForm' >Inscrivez-vous</a>
            </footer>
        </div>
    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


