<?php
namespace Blog\Model\User; 
use Blog\Model\Manager;
use Blog\Model\User\User;

class UserManager extends Manager{

    public function create(User $user){

        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(username, pass, email, creation_date) VALUES(:username, :pass, :email, NOW())');

        $req->bindValue(':username', $user->username(), \PDO::PARAM_STR);
        $req->bindValue(':pass', $user->pass(), \PDO::PARAM_STR);
        $req->bindValue(':email', $user->email(), \PDO::PARAM_STR);

        $affectedLines = $req->execute();
        return $affectedLines;
    }

    public function get($username){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, pass FROM users WHERE username = ?');
        $req->execute(array($username));
        $donnees = $req->fetch(\PDO::FETCH_ASSOC);

        return $donnees;
    }

    public function getList($user_id){
    }

    public function update(User $user){
    }

    public function delete($user_id){
    }

}