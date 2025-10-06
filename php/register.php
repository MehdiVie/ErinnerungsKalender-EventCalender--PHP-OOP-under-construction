<?php

require_once __DIR__ . '/db_connect.php';
$message="";

if (isset($_POST["register"])) {
    $name=trim($_POST["name"]);
    $email=trim($_POST["email"]);
    $password=$_POST["password"];

    // erste Validierung
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "ungültige Email!";
    } else if (strlen($password) < 6) {
        $message = "password muss mindestens 6 Zahlen lang sein!";
    } else {
        try {
            $db = Database::getInstance();
            // falls diese Email schon gibt
            $check = $db->prepare("SELECT * FROM users WHERE email = :email ");
            $check->execute([':email'=>$email]);
            $existingUser = $check->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                echo $message="diese Email ist bereit registriert!";
            } else {
                // hash password
                $hashedPassword = password_hash($password , PASSWORD_DEFAULT);

                // insert new user to database
                $createUser = $db->prepare("INSERT INTO users (name,email,password) VALUES (:name, :email, :password)");

                $createUser->execute([
                    ':name' => $name ,
                    ':email' => $email , 
                    ':password' => $hashedPassword
                ]);

                $message = "Registerierung Erflogreich!";
            }

        } catch (PDOException $e) {
            echo "Fehler: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link rel="stylesheet" href="../css/style.css" >
</head>
<body>
    <h2>Benutzer Registrierung</h2>
    <form method="POST" action="">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">E-Mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit" name="register">Registrieren</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>