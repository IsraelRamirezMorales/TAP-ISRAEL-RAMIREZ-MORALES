<?php
session_start();
$usuarios = file_exists("usuarios.json") ? json_decode(file_get_contents("usuarios.json"), true) : [];
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Process registration
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {
    $name = trim($_POST["name"] ?? "");
    $lastName = trim($_POST["lastName"] ?? "");
    $userName = trim($_POST["userName"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirmPassword = trim($_POST["confirmPassword"] ?? "");

    if (!empty($userName) && !empty($password) && !empty($confirmPassword)) {
        if ($password !== $confirmPassword) {
            $message = "Passwords do not match.";
        } elseif (isset($usuarios[$userName])) {
            $message = "The user already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $usuarios[$userName] = ["name" => $name, "lastName" => $lastName, "password" => $hashedPassword];
            file_put_contents("usuarios.json", json_encode($usuarios));
            $message = "Registration successful. Please log in.";
            $page = "login";
        }
    } else {
        $message = "All fields are required.";
    }
}

// Process login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $userName = trim($_POST["userName"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (isset($usuarios[$userName]) && password_verify($password, $usuarios[$userName]["password"])) {
        $_SESSION["userName"] = $userName;
        $page = "welcome";
    } else {
        $message = "Incorrect username or password.";
    }
}

// Process logout
if ($page === "logout") {
    session_destroy();
    header("Location: ?page=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication PHP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="?page=login">Login</a> 
        <a href="?page=register">Register</a> 
        <?php if (isset($_SESSION["userName"])): ?>
            <a href="?page=welcome">Welcome</a> 
            <a href="?page=logout">Log out</a>
        <?php endif; ?>
    </nav>
    
    <div class="container">
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        
        <?php if ($page === "register"): ?>
            <h2>Register</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="First Name" required>
                <input type="text" name="lastName" placeholder="Last Name" required>
                <input type="text" name="userName" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
                <button type="submit" name="register">Register</button>
            </form>

        <?php elseif ($page === "login"): ?>
            <h2>Login</h2>
            <form method="POST">
                <input type="text" name="userName" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Log In</button>
            </form>

        <?php elseif ($page === "welcome" && isset($_SESSION["userName"])): ?>
            <h2>Welcome to this page <br>enjoy your day, <?php echo htmlspecialchars($usuarios[$_SESSION["userName"]]["name"] ?? "User"); ?>!</h2>
            <a href="?page=logout">Log Out</a>

        <?php else: ?>
            <p>You do not have access to this page.</p>
        <?php endif; ?>
    </div>
</body>
</html>
