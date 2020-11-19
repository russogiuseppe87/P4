<?php


use \Blog\Model\Comment\CommentManager;
use \Blog\Model\Post\PostManager;
use \Blog\Model\Post\Post;
use \Exception;


    /* PAGE */


function readPostsList($connectionParameters,$postTitles){
 
    $postManager = new PostManager(); 
    $posts = $postManager->getList(); 

    require('view/frontend/readPostsListView.php');
}

function readPost($post_id, $connectionParameters, $postTitles){
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $post = $postManager->get($post_id);

    if ($post->id() === intval($postManager->getFirstId())){
        $post->setFirst();
    }
    else if ($post->id() === intval($postManager->getLastId())){
        $post->setLast();
    }
    $comments = $commentManager->getList($post_id);

    require('view/frontend/readPostView.php');
}

function createPostForm($connectionParameters, $postTitles){
    require('view/frontend/createPostFormView.php');
}

function updatePostForm($post_id, $connectionParameters, $postTitles){

    $postManager = new PostManager();
    $post = $postManager->get($_GET['post_id']);

    require('view/frontend/updatePostFormView.php');
} 


    /* ACTION */    


function createPost($author, $title, $content){

	$postManager = new PostManager();

    $post = new Post([
      'author' => $author,
      'title' => $title,
      'content' => $content
    ]);

    $affectedLines = $postManager->create($post);

    if ($affectedLines === false) {
        throw new \Exception('Impossible d\'enregistrer le billet');
    }
    else {
        header('Location: index.php?page=readPostsList');
    }
}

function readFirstPost(){
    $postManager = new PostManager();
    $firstPost_id = $postManager->getFirstId();
    header('Location: index.php?page=readPost&post_id=' . intval($firstPost_id));
}

function readLastPost(){
    $postManager = new PostManager();
    $lastPost_id = $postManager->getLastId();
    header('Location: index.php?page=readPost&post_id=' . intval($lastPost_id));
}

function readNextPost($post_id){
    $postManager = new PostManager();
    $nextPost_id = $postManager->getNextId($post_id);
    header('Location: index.php?page=readPost&post_id=' . intval($nextPost_id));
}

function readPreviousPost($post_id){
    $postManager = new PostManager();
    $previousPost_id = $postManager->getPreviousId($post_id);
    header('Location: index.php?page=readPost&post_id=' . intval($previousPost_id));
}

function readTitlesList(){
    $postManager = new PostManager();
    $titles = $postManager->getTitlesList();
    return $titles;
}

function updatePost($post_id, $title, $content){

    $postManager = new PostManager();

    $post = new post([
      'id' => $post_id,
      'title' => $title,
      'content' => $content
    ]);

    $affectedLines = $postManager->update($post);

    if ($affectedLines === false) {
        throw new \Exception('Impossible d\'enregistrer le billet');
    }
    else {
        header('Location: index.php?page=readPost&post_id='. $post_id);
    }
}

function deletePost($post_id = null){

	$postManager = new PostManager();
    $affectedLines = $postManager->delete($post_id);

    if ($affectedLines === false) {
        throw new \Exception('Impossible de supprimer le billet');
    }
    else {
        if($post_id){
        header('Location: index.php?page=readPostsList');
        }
    }
}

function filterContent($content){
    $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
    $allowedTags.='<li><ol><ul><span><div><br><ins><del>';  // balises fermantes

    if($content!='') {
        $filteredContent = strip_tags(stripslashes($content), $allowedTags);
        return $filteredContent;
    } else {
        throw new \Exception('Tous les champs ne sont pas remplis');
    }
}








