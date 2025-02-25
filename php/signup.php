<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>This is the Sign up Page!</h1>

    

    <form method="post">
    <input type="text" name="username" placeholder="Your Username" required> <br>
    <input type="text" name="email" placeholder="Your Email (example@example.com)" required> <br>
    <input type="password" name="password" placeholder="Enter your password" required> <br>
    <input type="password" name="2ndpassword" placeholder="Enter your password again" required> <br>
    <input type="submit" Value="Submit">
    </form>

    <?php
    
    require_once "../.gitignore/config.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    if($conn->error) {
        echo "Connection error";
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $secondpassw = $_POST['2ndpassword'];

        if($password != $secondpassw) {
            echo "Passwords dont match!";
            exit;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO logins (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password_hash);

        if($stmt->execute()) {
            echo "User registered succesfully";
            header("refresh:3; url=login.php");
            echo "You are being redirected to the login page. If not, click <a href='login.php'>HERE</a>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();

    ?>
    
    
</body>
</html>