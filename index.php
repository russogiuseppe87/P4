<?php
namespace Blog;
use \Blog\Autoloader;

session_start();

define('ROOT', __DIR__);

require ROOT . '/Autoloader.php';
Autoloader::register();

use \Exception;

require('Controller/postController.php');
require('Controller/commentController.php');
require('Controller/userController.php');


    /* CONNECTION TEST AND SETUP */

try {
    // if 'remember me' has been ticked 
    if (isset($_COOKIE['pass_hache']) AND isset($_COOKIE['username'])){  

        $validCookies = verifyConnectionId($_COOKIE['pass_hache'], htmlspecialchars($_COOKIE['username']));

        if ($validCookies){

            $connectionParameters = [
                'connected' => true,
                'reportedCommentsNumber' => readReportedCommentsNumber(),
                'validCookies' => true,
                'username' => $_COOKIE['username']
            ];
            // WIP : proper 'readUserStatus()' function here
            if ($_COOKIE['username'] === 'Jean Forteroche' OR $_COOKIE['username'] === 'Francois'){
                $connectionParameters['admin'] = true;
            }
        } 

        if (isset($_SESSION['ignoreCookies']) AND $_SESSION['ignoreCookies'] === true){
            // creates an array that will be sent as parameter to views
            $connectionParameters = [
                'connected' => false,
                'validCookies' => true,
                'username' => $_COOKIE['username']
            ];
        }   
    }
    // esle if 'remember me' has not been ticked but user is connected or wants to sign in
    else if( isset($_SESSION['pass_hache']) AND isset($_SESSION['username'])){

        $validSession = verifyConnectionId($_SESSION['pass_hache'], htmlspecialchars($_SESSION['username']));

        if ($validSession){
            // creates an array that will be sent as parameter to views
            $connectionParameters = [
                'connected' => true,
                'username' => $_SESSION['username'],
                'reportedCommentsNumber' => readReportedCommentsNumber()
            ];

            if ($_SESSION['username'] === 'Jean Forteroche' OR $_SESSION['username'] === 'Francois'){
                $connectionParameters['admin'] = true;
            }
        }
    }
    // else user is not connected
}
catch(Exception $e){
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}


$postTitles = readTitlesList();




    /* REQUESTS ROUTING */


try {
    if (isset($_GET['page'])) {




        if ($_GET['page'] == 'home'){
            require('view/frontend/homePageView.php');
        }    


        /* POSTS */        
            /* pages */ 


        else if ($_GET['page'] == 'createPostForm'){
            if(isset($connectionParameters['admin'])){
                createPostForm($connectionParameters, $postTitles);
            } else {
                header('Location: index.php');
            } 
        }

        elseif ($_GET['page'] == 'readPostsList') {
            readPostsList($connectionParameters, $postTitles);

        }

        elseif ($_GET['page'] == 'readPost') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                readPost($_GET['post_id'], $connectionParameters, $postTitles);

            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'readFirst') {
            readFirstPost();
        }

        elseif ($_GET['page'] == 'readLast') {
            readLastPost();
        }

        elseif ($_GET['page'] == 'readNextPost') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                readNextPost($_GET['post_id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'readPreviousPost') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                readPreviousPost($_GET['post_id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'updatePostForm') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if(isset($connectionParameters['admin'])){
                    updatePostForm($_GET['post_id'], $connectionParameters, $postTitles); 
                } else {
                    readPostsList($connectionParameters, $postTitles);
                }
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }


            /* actions */ 


        elseif ($_GET['page'] == 'createPost'){
            if (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])){
                $filteredContent = filterContent($_POST['content']);
                if(isset($connectionParameters['admin'])){
                    createPost(htmlspecialchars($_POST['author']), htmlspecialchars($_POST['title']), $filteredContent);
                } else {
                    header('Location: index.php');
                }
            } else {
                throw new \Exception('Tous les champs ne sont pas remplis');
            }  
        }
        
        elseif ($_GET['page'] == 'updatePost') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (!empty($_POST['title']) && !empty($_POST['content'])) {
                    if(isset($connectionParameters['admin'])){
                        $filteredContent = filterContent($_POST['content']);
                        updatePost($_GET['post_id'], $_POST['title'], $filteredContent);
                    } else {
                        header('Location: index.php');
                    }
                } else {
                    throw new \Exception('Tous les champs ne sont pas remplis');
                }                          
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'deletePost'){
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if(isset($connectionParameters['admin'])){
                    deletePost($_GET['post_id']);
                } else {
                    header('Location: index.php');
                } 
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }


        /* COMMENTS */
            /* pages */ 


        elseif ($_GET['page'] == 'createCommentForm') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                createCommentForm($connectionParameters, $postTitles);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'updateCommentForm') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                    if(isset($connectionParameters['admin'])){
                        updateCommentForm($connectionParameters, $postTitles);
                    } else {
                        header('Location: index.php');
                    } 
                } else {
                    throw new \Exception('Aucun identifiant de commentaire envoyé');
                }
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'readReportedComments') {
            if(isset($connectionParameters['admin'])){
                readReportedComments($connectionParameters, $postTitles);
            } else {
                header('Location: index.php');
            }
        }


            /* actions */ 


        elseif ($_GET['page'] == 'createComment') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['content'])) {
                    createComment($_GET['post_id'], htmlspecialchars($_POST['author']), $_POST['content']);
                } else {
                    throw new \Exception('Tous les champs ne sont pas remplis');
                }
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'updateComment') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                    if (!empty($_POST['content'])) {
                        if(isset($connectionParameters['admin'])){
                            updateComment($_GET['post_id'], $_POST['content'], $_GET['comment_id']);
                        } else {
                            header('Location: index.php');
                        } 
                    } else {
                        throw new \Exception('Tous les champs ne sont pas remplis');
                    }   
                } else {
                    throw new \Exception('Aucun identifiant de commentaire envoyé');
                }            
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'reportComment') {
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                    reportComment($_GET['post_id'], $_GET['comment_id']);
                } else {
                    throw new \Exception('Aucun identifiant de commentaire envoyé');
                }
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['page'] == 'cancelCommentReport'){
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                if(isset($connectionParameters['admin'])){
                    cancelCommentReport($_GET['comment_id']);
                } else {
                    header('Location: index.php');
                }
            } else {
                throw new \Exception('Aucun identifiant de commentaire envoyé');
            } 
        }

        elseif ($_GET['page'] == 'deleteComment'){
            if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                    if(isset($connectionParameters['admin'])){
                        deleteComment($_GET['post_id'], $_GET['comment_id']);
                    } else {
                        header('Location: index.php');
                    }
                } else {
                    throw new \Exception('Aucun identifiant de commentaire envoyé');
                }
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }


        /* USERS */
            /* pages */ 
        

        elseif ($_GET['page'] == 'connectUserForm') {
            connectUserForm($connectionParameters, $postTitles);
        }

        elseif ($_GET['page'] == 'createUserForm') {
            createUserForm($postTitles);
        }


            /* actions */ 


        elseif ($_GET['page'] == 'createUser') {
            if (!empty($_POST['username'])) {
                if (!empty($_POST['pass'])) {
                    if (!empty($_POST['email'])) {
                        createUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['pass']), htmlspecialchars($_POST['email']));
                    } else {
                        throw new \Exception('Aucune adresse e-mail enregistrée');
                    }
                } else {
                    throw new \Exception('Aucun mot de passe enregistré');
                }
            } else {
                throw new \Exception('Aucun nom d\'identifiant enregistré');
            }
        }

        elseif ($_GET['page'] == 'connectUser') {
            if (!empty($_POST['username'])) {
                if (!empty($_POST['pass'])) {
                    if(isset($_POST['rememberMe'])){
                        connectUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['pass']), $_POST['rememberMe']);
                    } else {
                        connectUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['pass']));
                    }  
                } else {
                    throw new \Exception('Aucun mot de passe enregistré');
                }
            } else {
                throw new \Exception('Aucun nom d\'identifiant enregistré');
            }     
        }

        elseif ($_GET['page'] == 'disconnectUser') {
            disconnectUser($connectionParameters);
        }

    } else {
        require('view/frontend/homePageView.php');
    }
}
catch(Exception $e){
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}


