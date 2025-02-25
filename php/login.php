



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    <h1>This is the Login Page!</h1>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required> <br>
        <input type="password" name="password" placeholder="Your password" required>
        <input type="submit" Value="Log in">
    </form>

    <h3>Do you not have an account yet? <a href="signup.php" class="signuptext">Sign up HERE</a></h3>


    
</body>
</html>

<?php 

    setcookie('test_cookie', 'test_value', time() + 3600, '/');
    if (isset($_COOKIE['test_cookie'])) {
        echo "Cookies are working!";
    } else {
        echo "Cookies are not working!";
    }

    session_start();

    require_once "../.gitignore/config.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    if($conn->connect_error) {
        echo "connection failed";
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password_hash FROM logins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        var_dump($user);
        if(password_verify($password, $user['password_hash'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("refresh:3; url=base.php");
            var_dump($_SESSION);
            echo "You are being redirected to base, if not click <a href='base.php'>here</a>";
            exit();
        } else {
            echo "False Credentials";
        }
    } else {
        echo "No such User.";
    }
}

    $stmt->close();
    $conn->close();

?>