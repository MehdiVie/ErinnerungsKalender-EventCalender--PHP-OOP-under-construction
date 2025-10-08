<?php
require_once __DIR__ . "/../core/Model.php";

class UserRepository extends Model {

    public function findByEmail(string $email) : ?array {
        $sql = "select * from users where email = :email LIMIT 1 ";
        $res = $this->query($sql , [':email'=>$email]);
        $user = $res->fetch(PDO::FETCH_ASSOC);
        return $user?:null;
    }

    public function emailExists(string $email) : bool {
        return $this->findByEmail($email) !== null;
    }

    public function verifyLogin(string $email , string $password) : ?array {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password , $user["password"])) {
            return $user;
        }
        return null;
    }

    public function create(array $data) : bool {
        $sql = "insert into users (name,email,password)
                values (:name,:email,:password)";
        $res = $this->query($sql , [
                "name" => $data["name"] , 
                "email" => $data["email"] , 
                "password" => password_hash(
                    $data["password"] , PASSWORD_DEFAULT)
        ]);
        return $res->rowCount() > 0;
    }


}