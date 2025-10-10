<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../services/UserService.php';


class AuthController extends Controller {
    private UserService $service;

    public function __construct() {
        $this->service = new UserService();
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    }

    public function register() {

        if ($this->isPost()) { 

            $response = $this->service->registerUser([
                "name" => trim($_POST["name"]),
                "email" => trim($_POST["email"]),
                "password" => $_POST["password"]
                ]);

            if (!$response['success']) {
                $this->view('auth/register' ,['errors' => $response['errors']]);
            } else  {
                $this->view('auth/login' ,['message'=> $response['message']]);
            } 
            
        }
        else {
        $this->view('auth/register');
        }
    }

    public function login() {

        if ($this->isPost()) {

            $response = $this->service->loginUser(
                trim($_POST["email"]) , 
                $_POST['password']
            );

            if ($response['success']) {
                $_SESSION['flash_message'] = 'Willkommen zurück, ' . 
                                            $_SESSION['user_name'] . '!';
                $this->redirect('/');
            } else {
                $this->view('auth/login',
                ['errors' => $response['errors']]
                );
            }
        }
        else {
            $this->view('auth/login');
        }
        
    }

    public function logout() {

        $this->service->logoutUser();  
        $this->redirect('/login');
    }

}
