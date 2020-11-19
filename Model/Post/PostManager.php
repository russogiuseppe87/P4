<?php
namespace Blog\Model\Post; 
use Blog\Model\Manager;
use Blog\Model\Post\Post;

class PostManager extends Manager{

    public function create(Post $post){

        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(author, title, content, creation_date) VALUES(:author, :title, :content, NOW())');

        $req->bindValue(':author', $post->author(), \PDO::PARAM_STR);
        $req->bindValue(':title', $post->title(), \PDO::PARAM_STR);
        $req->bindValue(':content', $post->content(), \PDO::PARAM_LOB);

        $affectedLines = $req->execute();
        return $affectedLines;
    }

    public function get($post_id){

        $postId = (int) $postId ;

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, author, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh %imin\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($post_id));
        $donnees = $req->fetch(\PDO::FETCH_ASSOC);

        return new Post($donnees);
    }

    public function getFirstId(){

        $db = $this->dbConnect();
        $req = $db->query('SELECT id  FROM posts WHERE creation_date = (SELECT MIN(creation_date) FROM posts)');

        $result = $req->fetch();
        $post_id = $result['id'];

        return $post_id;
    }

    public function getLastId(){

        $db = $this->dbConnect();
        $req = $db->query('SELECT id FROM posts WHERE creation_date = (SELECT MAX(creation_date) FROM posts)');

        $result = $req->fetch();
        $post_id = $result['id'];

        return $post_id;
    }

    public function getNextId($post_id){

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM posts WHERE id > ? ORDER BY creation_date ASC LIMIT 1  ');

        $req->execute(array($post_id));
        $result = $req->fetch();

        $post_id = $result['id'];

        return $post_id;
    }

    public function getPreviousId($post_id){

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id FROM posts WHERE id < ? ORDER BY creation_date DESC LIMIT 1  ');

        $req->execute(array($post_id));
        $result = $req->fetch();

        $post_id = $result['id'];

        return $post_id;
    }

    public function getTitlesList(){

        $titles =[];
        $db = $this->dbConnect();
        $req = $db->query('
            SELECT id, 
                CASE
                    WHEN LENGTH(title) > 15 THEN CONCAT(RPAD(title, 15, \'\' ),\'…\')   
                    WHEN CHAR_LENGTH(title) < 15 OR CHAR_LENGTH(title) = 15 THEN title 
                END AS title
            FROM posts 
            ORDER BY creation_date 
            ASC 
            LIMIT 10
        ');
        while ($donnees = $req->fetch()){
           $titles[$donnees['id']] = $donnees['title']; 
        }
        return $titles;
    }

    public function getList(){
        $posts = [];

        $db = $this->dbConnect();
        $req = $db->query('
            SELECT 
                id, 
                author, 
                title, 
                content, 
                DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh %imin\') AS creation_date_fr,
                CASE
                    WHEN LENGTH(content) > 200 THEN CONCAT(RPAD(content, 200, \'\' ),\'…\')   
                    WHEN CHAR_LENGTH(content) < 200 OR CHAR_LENGTH(content) = 200 THEN content 
                END AS extract
            FROM posts 
            ORDER BY creation_date 
            DESC LIMIT 0, 5
        ');
        while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
        {
          $posts[] = new Post($donnees);
        }
        return $posts;
    }

    public function update(Post $post){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
        
        $req->bindValue(':title', $post->title(), \PDO::PARAM_STR);
        $req->bindValue(':content', $post->content(), \PDO::PARAM_LOB);
        $req->bindValue(':id', $post->id(), \PDO::PARAM_INT);
        $affectedLines = $req->execute();

        return $affectedLines;
    }

    public function delete($post_id){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts WHERE id = ?');
        $affectedLines = $req->execute(array($post_id));

        return $affectedLines;
    }
}