<nav id="main-navigation" class="navigation">
    <a href="#" class="close-navigation"><i class='fa fa-times'></i></a>
    <div>

        <header>
            <p><a href="index.php" class='menuTitle' ><i class="fas fa-angle-right"></i></i>Accueil</a></p>
            <p><a href="index.php?page=readPostsList" class='menuTitle' ><i class="fas fa-angle-right"></i></i>Sommaire</a></p>
        </header>
        <ul>
            <?php foreach ($postTitles as $id => $title){ ?>

                <li><a href="index.php?page=readPost&amp;post_id=<?= $id ?>" class='menuTitle' ><i class="fas fa-angle-right"></i></i><?= $title ?></a></li>

            <?php
            }
            ?>   
        </ul>

        <div class='divider'></div>

        <?php if (isset($connectionParameters['connected']) AND $connectionParameters['connected'] === true){ 
        ?>   
            <header>
                <p><i class="fas fa-user"></i><?= $connectionParameters['username'] ?></p>
            </header>

            <p><a href='index.php?page=disconnectUser'>Se déconnecter</a></p>

            <footer>
                <p>
                    

                    <?php 
                    if(substr($connectionParameters['reportedCommentsNumber'], 0, 1) === '0'){

                        echo $connectionParameters['reportedCommentsNumber']; 

                    } else {

                        echo '<a href=\'index.php?page=readReportedComments\' class=\'redNotification\'>' . $connectionParameters['reportedCommentsNumber'] . '</a>';
                    }
                    ?>

                </p>
            </footer>

        <?php    
        } else {
        ?>
            <a href='index.php?page=connectUserForm' ><i class="fas fa-sign-in-alt"></i>Connexion</a> 
            
        <?php    
        } 
        ?> 
        
    </div>
</nav>