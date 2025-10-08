<?php
class Controller {

    // render view with common header,navbar,footer
    protected function view(string $viewPath, array $data = [], string $layout = 'main'): void {
        $base = dirname(__DIR__, 2);
        extract($data, EXTR_SKIP);

        $viewFile = $base . '/views/' . $viewPath . '.php';
        $layoutFile = $base . '/views/layouts/' . $layout . '.php';

        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            include $viewFile;
        }
    }

    protected function redirect(string $path): void {
        
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base . $path);
        exit;
    }

    protected function isPost(): bool {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    }

    protected function requireLogin(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}
