<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . "/db_connect.php";
require_once __DIR__ . '/../config/paths.php';


$message="";

if (isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // input validation
    if (!filter_var($email , FILTER_VALIDATE_EMAIL)) {
        $message = "ungültige Email.";
    } else {
        try {

            $db = Database::getInstance();

            $record = $db->prepare("Select * from users where email= :email");
            $record->execute([':email'=>$email]);
            $user=$record->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password , $user['password'])) {
                // if password is correct
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $message="Login Erfolgreich. Willkommen "
                        .htmlspecialchars($user["name"])."!";
            } else {
                $message = "falsche Email oder Password.";
            }

        } catch (PDOException $e) {
            $message = "Login Fehler: ".$e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php require_once INCLUDES_PATH . '/header.php'; ?>
</head>
<body>
    <?php require_once INCLUDES_PATH . '/navbar.php'; ?>
    <h2>Benutzer Login</h2>
    <form action="" method="post">
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password"><br><br>

        <button type="submit" name="login">Login</button>
    </form>

    <p><?php echo $message; ?></p>
    <?php require_once INCLUDES_PATH . '/footer.php'; ?>
</body>
</html>