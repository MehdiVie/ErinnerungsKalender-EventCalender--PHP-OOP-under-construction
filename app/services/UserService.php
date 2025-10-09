<?php
require_once __DIR__ . "/../repositories/UserRepository.php";
require_once __DIR__ . '/../Services/ValidationService.php';

class UserService {

    private UserRepository $repo;
    private ValidationService $validator;

    public function __construct() {
        $this->repo = new UserRepository();
        $this->validator = new ValidationService();
    }

    public function registerUser(array $data) : array {
        
        $errors= $this->validator->validateRegistration($data);

        if (!empty($errors)) {
            return ['success'=> false , 'errors' => $errors];
        }

        if (emailExists($data["email"])) {
            return ['success'=> false , 'errors' => ["E-Mail existiert bereits!"]];
        }

        $created_user = $this->repo->create($data);

        if ($created_user) {
            return ['success' => $created_user , 'message' => "Registrierung Erflogreich."];
        } else {
            return ['success' => $created_user , 'errors' => ["Fehler bei der Registrierung."]];
        }
        
    }

    public function loginUser(string $email , string $password) : array {

        $user = $this->repo->verifyLogin(
            trim($_POST["email"]) , 
            $_POST['password']
            );

        if ($user) {
            $_SESSION["user_name"]=$user["name"];
            $_SESSION["user_id"]=$user["id"];
            $_SESSION["user_email"]=$user["email"];
            return ['success' => true , 'user' => $user];
        }

        return ['success' => false , 'errors' => ['Falsche Username oder Password.']];
    }

    public function logoutUser() : void {
        session_unset();
        session_destroy();
    }
}