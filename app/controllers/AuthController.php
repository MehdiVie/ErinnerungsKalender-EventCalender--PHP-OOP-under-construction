<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class AuthController extends Controller {
    private UserRepository $repo;

    public function __construct() {
        $this->repo = new UserRepository();
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    }

    public function register() {
        if ($this->isPost()) {
            $res = $this->repo->emailExists(trim($_POST["email"]));
            if (!$res) {
                $new_user = $this->repo->create([
                    "name" => trim($_POST["name"]),
                    "email" => trim($_POST["email"]),
                    "password" => $_POST["password"]
                    ]);
                if ($new_user) {
                    $this->view('auth/login', 
                    ['message' => 'User Erfolgreich registriert.']); 
                }
            }
            else {
               $this->view('auth/register', 
               ['error' => 'Email bereits registriert.']); 
            }
        }
        else {
        $this->view('auth/register');
        }
    }

    public function login() {
        if ($this->isPost()) {
            $res = $this->repo->verifyLogin(
                trim($_POST["email"]) , 
                $_POST['password']
            );
            if ($res) {
                $_SESSION["user_name"]=$res["name"];
                $_SESSION["user_id"]=$res["id"];
                $this->redirect('/');
            } else {
                $this->view('auth/login',
                ['error' => 'Email oder Password sind falsch.']
                );
            }
        }
        else {
            $this->view('auth/login');
        }
        
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();   
        $this->redirect('/login');
    }

}
