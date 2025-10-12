<?php
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($scriptName, '/'));

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/controllers/EventController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';

$router = new Router();
$event = new EventController();
$auth  = new AuthController();
$home  = new HomeController();




// Routes
$router->add('/',               [$event, 'index']);        
$router->add('/login',          [$auth,  'login']);        
$router->add('/register',       [$auth,  'register']);   
$router->add('/logout',         [$auth,  'logout']);     
$router->add('/events/create',  [$event, 'create']);       
$router->add('/events/store',   [$event, 'store']);        
$router->add('/events/edit',    [$event, 'edit']);         
$router->add('/events/update',  [$event, 'update']);       
$router->add('/events/delete',  [$event, 'delete']);  
$router->add('/run-cron', function() {
    require_once __DIR__ . '/../app/cron/cronReminder_manual.php';
});
$router->add('/home',  [$home, 'index']);  

// Dispatch
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace(BASE_URL, '', $path);
$router->dispatch($path);
